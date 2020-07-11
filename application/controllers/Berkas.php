<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Berkas extends CI_Controller {
	// public function __construct(){
	// 	parent::__construct();
		
    // }
    public function index(){
        $this->load->view('widgets/header-view.php');
        $this->load->view('widgets/sidebar-view.php');
        $this->load->view('widgets/topbar-view.php');
        $this->load->view('berkas/berkas-pasien-view.php');
        $this->load->view('widgets/footer-view.php');
    }

    public function baru(){
        $this->load->view('widgets/header-view.php');
        $this->load->view('widgets/sidebar-view.php');
        $this->load->view('widgets/topbar-view.php');
        $this->load->view('berkas/berkas-baru-view.php');
        $this->load->view('widgets/footer-view.php');
    }
    
    public function update(){
        $this->load->view('widgets/header-view.php');
        $this->load->view('widgets/sidebar-view.php');
        $this->load->view('widgets/topbar-view.php');
        $this->load->view('berkas/berkas-detail-pasien.php');
        $this->load->view('widgets/footer-view.php');
    }

    public function poli(){
        $this->load->view('widgets/header-view.php');
        $this->load->view('widgets/sidebar-view.php');
        $this->load->view('widgets/topbar-view.php');
        $this->load->view('berkas/poli/poli-daftar.php');
        $this->load->view('widgets/footer-view.php');
    }

    public function polibaru(){
        $this->load->view('widgets/header-view.php');
        $this->load->view('widgets/sidebar-view.php');
        $this->load->view('widgets/topbar-view.php');
        $this->load->view('berkas/poli/poli-baru.php');
        $this->load->view('widgets/footer-view.php');
    }
    
    public function distributor(){
        $this->load->view('widgets/header-view.php');
        $this->load->view('widgets/sidebar-view.php');
        $this->load->view('widgets/topbar-view.php');
        $this->load->view('berkas/distributor/distributor-daftar.php');
        $this->load->view('widgets/footer-view.php');
    }
    
    public function distributorbaru(){
        $this->load->view('widgets/header-view.php');
        $this->load->view('widgets/sidebar-view.php');
        $this->load->view('widgets/topbar-view.php');
        $this->load->view('berkas/distributor/distributor-baru.php');
        $this->load->view('widgets/footer-view.php');
    }
    
    public function petugas(){
        $this->load->view('widgets/header-view.php');
        $this->load->view('widgets/sidebar-view.php');
        $this->load->view('widgets/topbar-view.php');
        $this->load->view('berkas/petugas/petugas-daftar.php');
        $this->load->view('widgets/footer-view.php');
    }
    
    public function petugasbaru(){
        $this->load->view('widgets/header-view.php');
        $this->load->view('widgets/sidebar-view.php');
        $this->load->view('widgets/topbar-view.php');
        $this->load->view('berkas/petugas/petugas-baru.php');
        $this->load->view('widgets/footer-view.php');
    }
}