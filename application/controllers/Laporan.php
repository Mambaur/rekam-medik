<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {

    // Fungsi yang pertama kali dijalankan
	public function __construct(){
        parent::__construct();
        
        // Menangani login session
        if (!$this->session->userdata('email')) {
			redirect('auth');
		}
    }

    // Menampilkan halaman dashboard
    public function index(){

        // Menghubungkan atau join tabel detail pinjam
        $this->db->join('detail_pinjam', 'detail_pinjam.peminjaman_id_peminjaman = peminjaman.id_peminjaman');

        // Menghubungkan atau join dengan tabel poli
        $this->db->join('poli', 'detail_pinjam.poli_id_poli = poli.id_poli');

        // Menghubungkan atau join dengan tabel pasien
        $this->db->join('pasien', 'pasien.id_pasien = peminjaman.pasien_id_pasien');

        // Mengurutkan berdasarkan id_detail_pinjam dari besar ke kecil
        $this->db->order_by('id_detail_pinjam', 'desc');
        
        // Mengeksekusi untuk menambil data dar tabel peminjaman dan semua tabel join
        $data['laporan'] = $this->db->get('peminjaman')->result_array();

        // Menampilkan dan mengirimkan data ke view
        $this->load->view('widgets/header-view.php');
        $this->load->view('widgets/sidebar-view.php');
        $this->load->view('widgets/topbar-view.php');
        $this->load->view('laporan/laporan-view.php', $data);
        $this->load->view('widgets/footer-view.php');
    }
}