<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Berkas extends CI_Controller {

    // Fungsi yang pertama kali dijalankan
	public function __construct(){
        parent::__construct();
        $this->load->model('Pasien'); //memanggil model pasien
        // memeriksa apakah user sudah login, jika belum maka akan dialihkan ke halaman login
        if (!$this->session->userdata('email')) {
			redirect('auth');
		}
    }

    // Menampilkan halaman beranda 
    public function index(){
        // mengambil data pasien untuk ditampilkan ke view
        $data['pasien'] = $this->db->get('pasien')->result_array();

        // Menampilkan dan mengirim data ke view
        $this->load->view('widgets/header-view.php');
        $this->load->view('widgets/sidebar-view.php');
        $this->load->view('widgets/topbar-view.php');
        $this->load->view('berkas/berkas-pasien-view.php', $data);
        $this->load->view('widgets/footer-view.php');
    }

    // menampilkan halaman pasien baru
    public function baru(){
        // mengambil data dari distributor dan poli untuk ditampilkan kedalam dropdown menu, dimasukkan kedalam array
        $data = [
            'distributor' => $this->Pasien->getDistributor(),
            'poli' => $this->Pasien->getPoli(),
        ];

        // menampilkan dan mengirimkan data ke view
        $this->load->view('widgets/header-view.php');
        $this->load->view('widgets/sidebar-view.php');
        $this->load->view('widgets/topbar-view.php');
        $this->load->view('berkas/berkas-baru-view.php', $data);
        $this->load->view('widgets/footer-view.php');
    }


    // Fungsi untuk menambahka berkas
    public function addberkas(){

        // Set zona waktu di indonesia
        date_default_timezone_set("Asia/Jakarta");
        
        // Membuat id baru dengan fungsi yang ada di model Pasien
        $idpinjam = $this->Pasien->createIdPinjam();
        $idpasien = $this->Pasien->createIdPasien();

        // Mendapatkan data dari input
        $id_poli = $this->input->post('id_poli');
        $id_distributor = $this->input->post('id_distributor');
        $keterangan = $this->input->post('keterangan');
        $waktu = $this->input->post('waktu');

        /** 
         * id poli 1 = poli kosong / temp, selain itu ada poli anak, gigi, dst.
         * berkas pasien baru yang tidak memasukkan poli, memiliki status baru, artinya tidak dipinjam oleh poli manapun.
         * tipe diberi nama berkas baru, selain itu dipinjam.
        */

        if ($id_poli == 1 && $waktu == '-') {
            $waktu = null;
            $tipe = 'Berkas baru';
            $status = 'baru';
        }elseif($waktu == '1x24'){
            // apabila waktu peminjaman selama satu hari
            $waktu = date("Y-m-d H:i:s", strtotime('+ 1 day'));
            $tipe = 'Peminjaman';
            $status = 'dipinjam';
        }elseif($waktu == '2x24'){
            // apabila waktu peminjaman selama dua hari
            $waktu = date("Y-m-d H:i:s", strtotime('+ 2 day'));
            $tipe = 'Peminjaman';
            $status = 'dipinjam';
        }else{
            // apabila waktu peminjaman selama dua menit
            $waktu = date("Y-m-d H:i:s", strtotime('+1 minutes'));
            $tipe = 'Peminjaman';
            $status = 'dipinjam';
        }

        // mendapatkan data poli berdasarkan id poli yang dimasukkan
        $data = $this->db->get_where('poli', ['id_poli' => $id_poli])->row_array();

        // Memasukkan semua data pasien kedalam array
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

        // Memasukkan data peminjaman kedalam array
        $inputPinjam = [
            'id_peminjaman' => $idpinjam,
            'pasien_id_pasien' => $idpasien,
            'status' => $data['nama_poli'],
            'distributor' => $id_distributor
        ];

        // Memasukkan data detail pinjam kedalam array
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

        /**
         * Mengeksekusi insert data ke tabel pasien
         * Mengeksekusi insert data ke tabel peminjaman
         * Mengeksekusi insert data ke tabel detail pinjam
        */

        if ($this->db->insert('pasien', $inputPasien) && $this->db->insert('peminjaman', $inputPinjam) && $this->db->insert('detail_pinjam', $inputDetailPinjam)) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berkas berhasil ditambahkan!</div>'); // pesan jika data berhasil di insert ke database
            redirect('berkas/baru'); // dialihkan ke halaman berkas baru
        }else{
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Berkas gagal ditambahkan!</div>'); // pesan jika gagal
            redirect('berkas/baru'); // dialihkan ke halamn berkas baru
        }
    }
    
    // Menampilkan halamn update pasien
    public function update(){
        // Mengambil data pasien berdasarkan id
        $data['pasien'] = $this->db->get_where('pasien', ['id_pasien' => $this->input->get('id')])->row_array();

        // menampilkan dan mengirimkan data pasien ke view
        $this->load->view('widgets/header-view.php');
        $this->load->view('widgets/sidebar-view.php');
        $this->load->view('widgets/topbar-view.php');
        $this->load->view('berkas/berkas-detail-pasien.php', $data);
        $this->load->view('widgets/footer-view.php');
    }

    // Menangani apabila tombol update pasien di klik
    public function updatepasien(){
        // Mendapatkan semua data dari input, dan menaruhnya ke dalam array
        $data = [
            'no_rm' => $this->input->post('no_rm'),
            'nik' => $this->input->post('nik'),
            'nama_pasien' => $this->input->post('nama_pasien'),
            'jeniskelamin' => $this->input->post('jk'),
            'alamat' => $this->input->post('alamat'),
            'no_rak' => $this->input->post('no_rak'),
        ];

        // Mengeksekusi update data pasien
        $this->db->where('id_pasien', $this->input->get('id'));
        if ($this->db->update('pasien', $data)) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berkas berhasil perbarui!</div>'); // pesan jika berhasil
            redirect('berkas'); // dialihkan ke halamn berkas
        }else{
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Berkas gagal diperbarui!</div>'); // pesan jika gagal
            redirect('berkas'); // dialihkan ke halaman berkas
        }
    }

    // menampilkan halaman poli
    public function poli(){
        // mengambil list data poli dari database
        $data['poli'] = $this->db->get('poli')->result_array();

        // menampilkan dan mengirim data poli ke view
        $this->load->view('widgets/header-view.php');
        $this->load->view('widgets/sidebar-view.php');
        $this->load->view('widgets/topbar-view.php');
        $this->load->view('berkas/poli/poli-daftar.php',$data);
        $this->load->view('widgets/footer-view.php');
    }

    // Menampilkan halaman tambah poli
    public function polibaru(){
        $this->load->view('widgets/header-view.php');
        $this->load->view('widgets/sidebar-view.php');
        $this->load->view('widgets/topbar-view.php');
        $this->load->view('berkas/poli/poli-baru.php');
        $this->load->view('widgets/footer-view.php');
    }

    // Mengeksekusi apabila menekan tombol tambah poli
    public function politambah(){
        // Mendapatkan data dari input, dan dimasukkan kedalam array
        $data = [
            'nama_poli' => $this->input->post('nama_poli'),
            'penanggung_jawab' => $this->input->post('penanggung_jawab'),
            'telepon' => $this->input->post('telepon'),
        ];

        // mengeksekusi perintah tambah poli ke database
        if ($this->db->insert('poli', $data)) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Poli berhasil tambahkan!</div>'); // pesan jika gagal
            redirect('berkas/polibaru'); // dialihkan ke halaman tambah poli
        }else{
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Poli gagal ditambahkan!</div>'); // pesan jika gagal
            redirect('berkas/polibaru'); // dialihkan ke halaman tambah poli
        }
    }

    // Menangani perintah hapus poli
    public function hapuspoli(){
        if ($this->db->delete('poli', ['id_poli' => $this->input->get('id')])) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Poli berhasil dihapus!</div>'); // pesan jika berhasil
            redirect('berkas/poli'); // dialihkan ke halaman poli
        }else{
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Poli gagal dihapus!</div>'); // pesan jika gagal
            redirect('berkas/poli'); // dialihkan ke halaman poli
        }
    }
    
    // Menampilkan halaman distributor
    public function distributor(){
        // Mengambil data distributor dari database untuk ditampilkan didalam tabel
        $data['distributor'] = $this->db->get('distributor')->result_array();

        // menampilkan dan mengirim data distributor ke view
        $this->load->view('widgets/header-view.php');
        $this->load->view('widgets/sidebar-view.php');
        $this->load->view('widgets/topbar-view.php');
        $this->load->view('berkas/distributor/distributor-daftar.php',$data);
        $this->load->view('widgets/footer-view.php');
    }
    

    // Menampilkan halaman tambah distributor
    public function distributorbaru(){
        $this->load->view('widgets/header-view.php');
        $this->load->view('widgets/sidebar-view.php');
        $this->load->view('widgets/topbar-view.php');
        $this->load->view('berkas/distributor/distributor-baru.php');
        $this->load->view('widgets/footer-view.php');
    }

    // Menangani perintah ketika tombol tambah distributor di klik
    public function distributortambah(){
        // mendapatkan data dari input, lalu ditaruh ke dalam array
        $data = [
            'nama_distributor' => $this->input->post('nama_distributor'),
            'no_telp' => $this->input->post('no_telp'),
        ];

        // mengeksekusi tambah distributor ke database
        if ($this->db->insert('distributor', $data)) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Distributor berhasil ditambah!</div>'); // pesan jika berhasil
            redirect('berkas/distributorbaru'); // dialihkan ke halaman distributor baru
        }else{
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Distributor gagal ditambah!</div>'); // pesan jika gagal
            redirect('berkas/distributorbaru'); // dialihkan ke halaman distributor baru
        }
    }

    // menangani perintah hapus distributor
    public function hapusdistributor(){
        // Mengeksekusi hapus distributor berdasarkan id
        if ($this->db->delete('distributor', ['id_distributor' => $this->input->get('id')])) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Distributor berhasil dihapus!</div>'); // pesan jika berhasil
            redirect('berkas/distributor'); // dialihkan ke halaman distributor
        }else{
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Distributor gagal dihapus!</div>'); // pesan jika gagal
            redirect('berkas/distributor'); // dialihkan ke halaman distributor
        }
    }
    
    // Menampilkan halaman petugas
    public function petugas(){
        // Mendapatkan data petugas di database
        $data['petugas'] = $this->db->get('petugas')->result_array();

        // menampilkan dan mengirimkan data ke view
        $this->load->view('widgets/header-view.php');
        $this->load->view('widgets/sidebar-view.php');
        $this->load->view('widgets/topbar-view.php');
        $this->load->view('berkas/petugas/petugas-daftar.php', $data);
        $this->load->view('widgets/footer-view.php');
    }
    
    // Mendampilkan halaman petugas baru
    public function petugasbaru(){
        $this->load->view('widgets/header-view.php');
        $this->load->view('widgets/sidebar-view.php');
        $this->load->view('widgets/topbar-view.php');
        $this->load->view('berkas/petugas/petugas-baru.php');
        $this->load->view('widgets/footer-view.php');
    }

    // Menangani aksi perintah tambah petugas
    public function petugastambah(){
        // Mendapatkan data dari input
        $nama_petugas = $this->input->post('nama_petugas');
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $konfirmasi_password = $this->input->post('konfirmasi_password');

        // memeriksa apakah email sudah didaftarkan sebelumnya atau belum
        $cek = $this->db->get_where('petugas', ['email' => $email])->row_array();

        // Jika sudah muncul pesan email sudah didaftarkan
        if($email == $cek['email']){
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email sudah didaftarkan!</div>');
            redirect('berkas/petugasbaru');
        }
        // Apa bila input password dan konfirmasi password sudah sama
        else if ($password == $konfirmasi_password) {
            // data input dimasukkan ke dalam array
            $data = [
                'nama_petugas' => $nama_petugas,
                'email' => $email,
                'password' => $password
            ];
            // mengeksekusi tambah petugas
            if ($this->db->insert('petugas', $data)) {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Petugas berhasil ditambahkan!</div>'); // pesan jika berhasil
                redirect('berkas/petugasbaru'); // dialihkan ke halaman petugas baru
            }else{
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Petugas gagal ditambahkan!</div>'); // pesan jika gagal
                redirect('berkas/petugasbaru'); // dialihkan ke halaman petugas baru
            }
        }
        // jika input password dan password konfirmasi tidak sama
        else{
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Konfirmasi password tidak cocok!</div>'); // pesan konfirmasi password
            redirect('berkas/petugasbaru'); // dialihkan ke halaman petugas baru
        }
    }


    // Menangani perintah hapus data petugas
    public function hapuspetugas(){
        // Mengeksekusi hapus petugas berdasarka id
        if ($this->db->delete('petugas', ['id_petugas' => $this->input->get('id')])) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Petugas berhasil dihapus!</div>'); // menampilkan pesan petugas berhasil dihapus
            redirect('berkas/petugas'); // dialihkan ke halaman petugas
        }else{
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Petugas gagal dihapus!</div>'); // pesan jika gagal
            redirect('berkas/petugas'); // dialihkan ke halaman petugas
        }
    }
}