<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	public function __construct(){
        parent::__construct();
        if (!$this->session->userdata('email')) {
			redirect('auth');
		}
    }

    public function index(){
        $this->load->view('widgets/header-view.php');
        $this->load->view('widgets/sidebar-view.php');
        $this->load->view('widgets/topbar-view.php');
        $this->load->view('dashboard-view.php');
        $this->load->view('widgets/footer-view.php');
    }
}