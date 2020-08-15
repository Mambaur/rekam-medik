<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Berkas extends CI_Controller {
	public function __construct(){
        parent::__construct();
        $this->load->model('Pasien');
        if (!$this->session->userdata('email')) {
			redirect('auth');
		}
    }

    public function index(){
        $data['pasien'] = $this->db->get('pasien')->result_array();
        $this->load->view('widgets/header-view.php');
        $this->load->view('widgets/sidebar-view.php');
        $this->load->view('widgets/topbar-view.php');
        $this->load->view('berkas/berkas-pasien-view.php', $data);
        $this->load->view('widgets/footer-view.php');
    }

    public function baru(){
        $data = [
            'distributor' => $this->Pasien->getDistributor(),
            'poli' => $this->Pasien->getPoli(),
        ];
        $this->load->view('widgets/header-view.php');
        $this->load->view('widgets/sidebar-view.php');
        $this->load->view('widgets/topbar-view.php');
        $this->load->view('berkas/berkas-baru-view.php', $data);
        $this->load->view('widgets/footer-view.php');
    }

    public function addberkas(){
        $idpinjam = $this->Pasien->createIdPinjam();
        $idpasien = $this->Pasien->createIdPasien();
        $id_poli = $this->input->post('id_poli');
        $id_distributor = $this->input->post('id_distributor');
        $keterangan = $this->input->post('keterangan');
        $waktu = $this->input->post('waktu');


        if ($id_poli == 1 && $waktu == '-') {
            $waktu = null;
            $tipe = 'Berkas baru';
            $status = 'baru';
        }elseif($waktu == '1x24'){
            $waktu = date("Y-m-d", strtotime('+ 1 day'));
            $tipe = 'Peminjaman';
            $status = 'dipinjam';
        }else{
            $waktu = date("Y-m-d", strtotime('+ 2 day'));
            $tipe = 'Peminjaman';
            $status = 'dipinjam';
        }

        $data = $this->db->get_where('poli', ['id_poli' => $id_poli])->row_array();

        $inputPasien = [
            'id_pasien' => $idpasien,
            'no_rm' => $this->input->post('norm'),
            'nik' => $this->input->post('nik'),
            'nama_pasien' => $this->input->post('nama_pasien'),
            'jeniskelamin' => $this->input->post('jk'),
            'alamat' => $this->input->post('alamat'),
            'no_rak' => $this->input->post('norak'),
            'tanggal_masuk' => date('d-m-Y'),
            'poli_id_poli' => $id_poli,
        ];

        $inputPinjam = [
            'id_peminjaman' => $idpinjam,
            'pasien_id_pasien' => $idpasien,
            'status' => $data['nama_poli'],
            'distributor' => $id_distributor
        ];

        $inputDetailPinjam = [
            'tanggal' => date('d-m-Y'),
            'keterangan' => $keterangan,
            'peminjaman_id_peminjaman' => $idpinjam,
            'poli_id_poli' => $id_poli,
            'distributor_id_distributor' => $id_distributor,
            'waktu' => $waktu,
            'tipe' => $tipe,
            'status' => $status
        ];

        if ($this->db->insert('pasien', $inputPasien) && $this->db->insert('peminjaman', $inputPinjam) && $this->db->insert('detail_pinjam', $inputDetailPinjam)) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berkas berhasil ditambahkan!</div>');
            redirect('berkas/baru');
        }else{
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Berkas gagal ditambahkan!</div>');
            redirect('berkas/baru');
        }
    }
    
    public function update(){
        $data['pasien'] = $this->db->get_where('pasien', ['id_pasien' => $this->input->get('id')])->row_array();
        $this->load->view('widgets/header-view.php');
        $this->load->view('widgets/sidebar-view.php');
        $this->load->view('widgets/topbar-view.php');
        $this->load->view('berkas/berkas-detail-pasien.php', $data);
        $this->load->view('widgets/footer-view.php');
    }

    public function updatepasien(){
        $data = [
            'no_rm' => $this->input->post('no_rm'),
            'nik' => $this->input->post('nik'),
            'nama_pasien' => $this->input->post('nama_pasien'),
            'jeniskelamin' => $this->input->post('jk'),
            'alamat' => $this->input->post('alamat'),
            'no_rak' => $this->input->post('no_rak'),
        ];

        $this->db->where('id_pasien', $this->input->get('id'));
        if ($this->db->update('pasien', $data)) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berkas berhasil perbarui!</div>');
            redirect('berkas');
        }else{
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Berkas gagal diperbarui!</div>');
            redirect('berkas');
        }
    }

    public function poli(){
        $data['poli'] = $this->db->get('poli')->result_array();
        $this->load->view('widgets/header-view.php');
        $this->load->view('widgets/sidebar-view.php');
        $this->load->view('widgets/topbar-view.php');
        $this->load->view('berkas/poli/poli-daftar.php',$data);
        $this->load->view('widgets/footer-view.php');
    }

    public function polibaru(){
        $this->load->view('widgets/header-view.php');
        $this->load->view('widgets/sidebar-view.php');
        $this->load->view('widgets/topbar-view.php');
        $this->load->view('berkas/poli/poli-baru.php');
        $this->load->view('widgets/footer-view.php');
    }

    public function politambah(){
        $data = [
            'nama_poli' => $this->input->post('nama_poli'),
            'penanggung_jawab' => $this->input->post('penanggung_jawab'),
            'telepon' => $this->input->post('telepon'),
        ];
        if ($this->db->insert('poli', $data)) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Poli berhasil tambahkan!</div>');
            redirect('berkas/polibaru');
        }else{
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Poli gagal ditambahkan!</div>');
            redirect('berkas/polibaru');
        }
    }

    public function hapuspoli(){
        if ($this->db->delete('poli', ['id_poli' => $this->input->get('id')])) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Poli berhasil dihapus!</div>');
            redirect('berkas/poli');
        }else{
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Poli gagal dihapus!</div>');
            redirect('berkas/poli');
        }
    }
    
    public function distributor(){
        $data['distributor'] = $this->db->get('distributor')->result_array();
        $this->load->view('widgets/header-view.php');
        $this->load->view('widgets/sidebar-view.php');
        $this->load->view('widgets/topbar-view.php');
        $this->load->view('berkas/distributor/distributor-daftar.php',$data);
        $this->load->view('widgets/footer-view.php');
    }
    
    public function distributorbaru(){
        $this->load->view('widgets/header-view.php');
        $this->load->view('widgets/sidebar-view.php');
        $this->load->view('widgets/topbar-view.php');
        $this->load->view('berkas/distributor/distributor-baru.php');
        $this->load->view('widgets/footer-view.php');
    }

    public function distributortambah(){
        $data = [
            'nama_distributor' => $this->input->post('nama_distributor'),
            'no_telp' => $this->input->post('no_telp'),
        ];
        if ($this->db->insert('distributor', $data)) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Distributor berhasil ditambah!</div>');
            redirect('berkas/distributorbaru');
        }else{
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Distributor gagal ditambah!</div>');
            redirect('berkas/distributorbaru');
        }
    }

    public function hapusdistributor(){
        if ($this->db->delete('distributor', ['id_distributor' => $this->input->get('id')])) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Distributor berhasil dihapus!</div>');
            redirect('berkas/distributor');
        }else{
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Distributor gagal dihapus!</div>');
            redirect('berkas/distributor');
        }
    }
    
    public function petugas(){
        $data['petugas'] = $this->db->get('petugas')->result_array();
        $this->load->view('widgets/header-view.php');
        $this->load->view('widgets/sidebar-view.php');
        $this->load->view('widgets/topbar-view.php');
        $this->load->view('berkas/petugas/petugas-daftar.php', $data);
        $this->load->view('widgets/footer-view.php');
    }
    
    public function petugasbaru(){
        $this->load->view('widgets/header-view.php');
        $this->load->view('widgets/sidebar-view.php');
        $this->load->view('widgets/topbar-view.php');
        $this->load->view('berkas/petugas/petugas-baru.php');
        $this->load->view('widgets/footer-view.php');
    }

    public function petugastambah(){
        $nama_petugas = $this->input->post('nama_petugas');
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $konfirmasi_password = $this->input->post('konfirmasi_password');

        $cek = $this->db->get_where('petugas', ['email' => $email])->row_array();
        if($email == $cek['email']){
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email sudah didaftarkan!</div>');
            redirect('berkas/petugasbaru');
        }else if ($password == $konfirmasi_password) {
            $data = [
                'nama_petugas' => $nama_petugas,
                'email' => $email,
                'password' => $password
            ];
            if ($this->db->insert('petugas', $data)) {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Petugas berhasil ditambahkan!</div>');
                redirect('berkas/petugasbaru');
            }else{
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Petugas gagal ditambahkan!</div>');
                redirect('berkas/petugasbaru');
            }
        }else{
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Konfirmasi password tidak cocok!</div>');
            redirect('berkas/petugasbaru');
        }
    }

    public function hapuspetugas(){
        if ($this->db->delete('petugas', ['id_petugas' => $this->input->get('id')])) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Petugas berhasil dihapus!</div>');
            redirect('berkas/petugas');
        }else{
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Petugas gagal dihapus!</div>');
            redirect('berkas/petugas');
        }
    }
}