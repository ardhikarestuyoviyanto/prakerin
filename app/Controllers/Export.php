<?php
namespace App\Controllers;
use App\Models\ModelsAdmin;
use App\Models\Application;

class Export extends BaseController{

    private $ModelsAdmin;
    private $input;
    private $ModelsApp;

    public function __construct(){

        $this->input = service('request');
        $this->ModelsAdmin = new ModelsAdmin();
        $this->ModelsApp = new Application();

        view_cell('App\Libraries\Widgets::getDataSekolah', ['data_sekolah'=>$this->ModelsApp->getApp()->getResult()]);
    }

    public function export_lapsiswa(){

        if(isset($_GET['kelas']) && isset($_GET['type'])){

            $data = array(

                'data' => $this->ModelsAdmin->getSiswaBykelas($_GET['kelas'])->getResult()

            );

            if($_GET['type'] == "pdf"){

                echo view('admin/export/export_lapsiswa_pdf', $data);
                
            }else{

                echo view('admin/export/export_lapsiswa_excel', $data);

            }

        }

    }

    public function export_lappembimbing(){

        $data = array(
            'pembimbing' => $this->ModelsAdmin->getGuru()->getResult()
        );

        if($_GET['type'] == "pdf"){

            echo view('admin/export/export_lappembimbing_pdf', $data);

        }else{

            echo view('admin/export/export_lappembimbing_excel', $data);

        }

    }

    public function export_lappenempatan(){

        if(isset($_GET['kelas']) && isset($_GET['industri'])){

            $data = array(
                'data' => $this->ModelsAdmin->FilterPenempatan($_GET['kelas'], $_GET['industri'])->getResult()
            );

            if($_GET['type'] == "pdf"){

                echo view('admin/export/export_lappenempatan_pdf', $data);

            }else{

                echo view('admin/export/export_lappenempatan_excel', $data);

            }

        }


    }

    public function export_kartu(){

        if(!empty($this->input->uri->getSegment('3'))){

            $data = array(
                'data' => $this->ModelsAdmin->getKartuPenempatanPerSiswa($this->input->uri->getSegment('3'))->getResult(),
                'data_siswa' => $this->ModelsAdmin->getSiswaByid($this->input->uri->getSegment('3'))->getResult()
            );

            echo view('admin/export/export_kartu', $data);

        }


    }

    public function export_nilaipersiswa(){

        if(!empty($this->input->uri->getSegment('3'))){

            //uri (3) id_siswa
            //uri (4) id_jurusan

            $data = array(
                'data_siswa' => $this->ModelsAdmin->getSiswaByid($this->input->uri->getSegment('3'))->getResult(),
                'data_aspek' => $this->ModelsAdmin->getDataAspekByidJurusan($this->input->uri->getSegment('4'))->getResult(),
                'data_jurnal' => $this->ModelsAdmin->getJurnalByIdSiswa($this->input->uri->getSegment('3'))->getResult(),

                'id_siswa' => $this->input->uri->getSegment('3')
            );

            echo view('admin/export/export_nilaipersiswa', $data);

        }

    }

    public function export_nilaiperkelas(){

        if(isset($_GET['kelas']) &&isset($_GET['type'])){

            $data = array(
                'siswa' => $this->ModelsAdmin->getSiswaBykelas($_GET['kelas'])->getResult(),
            );

            if($_GET['type'] == "pdf"){

                echo view('admin/export/export_nilaiperkelas_pdf', $data);

            }else{

                echo view('admin/export/export_nilaiperkelas_excel', $data);

            }


        }


    }

    public function export_perindustri(){

        if(isset($_GET['industri'])){

            $data = array(
                'siswa' => $this->ModelsAdmin->getSiswaByIndustri($_GET['industri'])->getResult(),
            );

            echo view('admin/export/export_perindustri', $data);

        }

    }

}

?>