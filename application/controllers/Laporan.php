<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {
	public function __construct(){
		parent::__construct();
        if (!$this->session->userdata('email')) {
			redirect('auth');
		}
    }

    public function index(){

        $this->db->join('detail_pinjam', 'detail_pinjam.peminjaman_id_peminjaman = peminjaman.id_peminjaman');
        $this->db->join('poli', 'detail_pinjam.poli_id_poli = poli.id_poli');
        $this->db->join('pasien', 'pasien.id_pasien = peminjaman.pasien_id_pasien');
		$this->db->order_by('id_detail_pinjam', 'desc');
        $data['laporan'] = $this->db->get('peminjaman')->result_array();

        $this->load->view('widgets/header-view.php');
        $this->load->view('widgets/sidebar-view.php');
        $this->load->view('widgets/topbar-view.php');
        $this->load->view('laporan/laporan-view.php', $data);
        $this->load->view('widgets/footer-view.php');
    }

    public function coba(){
        $string = substr('Akumanusia biasa', 0, 10);
        echo $string;
    }
}