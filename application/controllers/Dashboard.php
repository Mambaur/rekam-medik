<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	public function __construct(){
        parent::__construct();
        $this->load->model('Pasien');
        if (!$this->session->userdata('email')) {
			redirect('auth');
		}
    }

    public function index(){
        $data['pasien'] = $this->Pasien->getPasien();
        $this->load->view('widgets/header-view.php');
        $this->load->view('widgets/sidebar-view.php');
        $this->load->view('widgets/topbar-view.php');
        $this->load->view('dashboard-view.php', $data);
        $this->load->view('widgets/footer-view.php');
    }

    public function peminjaman(){
        $data = [
            'distributor' => $this->Pasien->getDistributor(),
            'poli' => $this->Pasien->getPoli(),
            'id_pinjam' => $this->input->post('id_pinjam')
        ];
        $this->load->view('widgets/header-view.php');
        $this->load->view('widgets/sidebar-view.php');
        $this->load->view('widgets/topbar-view.php');
        $this->load->view('peminjaman-berkas-view.php', $data);
        $this->load->view('widgets/footer-view.php');
    }

    public function peminjaman_aksi(){
        $id_distributor = $this->input->post('id_distributor');
        $id_poli = $this->input->post('id_poli');
        $id_pinjam = $this->input->post('id_pinjam');
        $keterangan = $this->input->post('keterangan');

        $input = [
            'tanggal' => date("Y-m-d"),
            'keterangan' => $keterangan,
            'peminjaman_id_peminjaman' => $id_pinjam,
            'poli_id_poli' => $id_poli,
            'distributor_id_distributor' => $id_distributor,
        ];

        $data = $this->db->get_where('poli', ['id_poli' => $id_poli])->row_array();

        $this->db->set('status', $data['nama_poli']);
        $this->db->set('distributor', $id_distributor);
        $this->db->where('id_peminjaman', $this->input->post('id_pinjam'));

        if ($this->db->update('peminjaman') && $this->db->insert('detail_pinjam', $input)) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berkas berhasil dikirim!</div>');
            redirect('dashboard');
        }else{
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Berkas gagal dikirim!</div>');
            redirect('dashboard');
        }
        echo json_encode($data);
    }

    public function pengembalian(){
        $id_pasien = $this->input->post('id_pasien');
        $id_pinjam = $this->input->post('id_pinjam');
        $id_distributor = $this->input->post('id_distributor');
        $input = [
            'tanggal' => date("Y-m-d"),
            'keterangan' => 'Pengembalian',
            'peminjaman_id_peminjaman' => $id_pinjam,
            'poli_id_poli' => '1',
            'distributor_id_distributor' => $id_distributor
        ];

        $this->db->set('status', '-');
        $this->db->where('id_peminjaman', $id_pinjam);

        if ($this->db->update('peminjaman') && $this->db->insert('detail_pinjam', $input)) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berkas berhasil dikembalikan!</div>');
            redirect('dashboard');
        }else{
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Berkas gagal dikembalikan!</div>');
            redirect('dashboard');
        }
    }

    public function hapus(){
        if ($this->db->delete('peminjaman', ['id_peminjaman' => $this->input->get('id')])) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berkas berhasil dihapus!</div>');
            redirect('dashboard');
        }else{
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Berkas gagal dihapus!</div>');
            redirect('dashboard');
        }
    }
}