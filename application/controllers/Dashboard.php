<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    // Fungsi yang pertama kali dijalankan
	public function __construct(){
        parent::__construct();

        // Memanggil model Pasien
        $this->load->model('Pasien');

        // Menangani login session
        if (!$this->session->userdata('email')) {
			redirect('auth');
		}
    }

    // Menampilkan halaman beranda
    public function index(){

        // Menampilkan data semua poli yang dipinjam
        $poliYangPinjam = $this->db->get('peminjaman')->result_array();
        $temp = null;
        $totalPoli = null;
        $keyPoli=null;
        foreach($poliYangPinjam as $item){
            if($item['status'] !== '-'){
                $temp[] = $item['status'];
            }
        }

        if ($temp) {
            $totalPoli = array_count_values($temp);
            $keyPoli = array_keys($totalPoli);;
        }

        // menampilkan data distributor yang mengirimkan hari ini
        $this->db->join('distributor', 'peminjaman.distributor = distributor.id_distributor');
        $disHariIni = $this->db->get('peminjaman')->result_array();

        $temp2 = null;
        $totalDistributor = null;
        $keyDistributor=null;
        foreach($disHariIni as $item){
            if($item['status'] !== '-'){
                $temp2[] = $item['nama_distributor'];
            }
        }

        if ($temp2) {
            $totalDistributor = array_count_values($temp2);
            $keyDistributor = array_keys($totalDistributor);;
        }

        $berkasTerlambat = $this->db->get_where('detail_pinjam', ['status' => 'Terlambat', 'tipe' => 'Peminjaman'])->result_array();
        $totalBerkasTerlambat = 0;
        foreach($berkasTerlambat as $item){ 
            $date = date("Y-m-d", strtotime($item['waktu']));
            if($date == date('Y-m-d')){
                $totalBerkasTerlambat++;
            }
        }

        $data = [
            'pasien' => $this->Pasien->getPasien(),
            'totalPoli' => $totalPoli,
            'keyPoli' => $keyPoli,
            'totalDistributor' => $totalDistributor,
            'keyDistributor' => $keyDistributor,
            'berkasTerlambat' => $totalBerkasTerlambat
        ];

        $this->load->view('widgets/header-view.php');
        $this->load->view('widgets/sidebar-view.php');
        $this->load->view('widgets/topbar-view.php');
        $this->load->view('dashboard-view.php', $data);
        $this->load->view('widgets/footer-view.php');
    }

    // Menangani tampilan halaman peminjaman
    public function peminjaman(){

        // Mendapatkan data informasi dari input dan database, kemudian dimasukkan kedalam array
        $data = [
            'distributor' => $this->Pasien->getDistributor(),
            'poli' => $this->Pasien->getPoli(),
            'id_pinjam' => $this->input->post('id_pinjam'),
            'nama_pasien' => $this->input->post('nama_pasien')
        ];

        // Menampilkan dan mengirimkan data ke view
        $this->load->view('widgets/header-view.php');
        $this->load->view('widgets/sidebar-view.php');
        $this->load->view('widgets/topbar-view.php');
        $this->load->view('peminjaman-berkas-view.php', $data);
        $this->load->view('widgets/footer-view.php');
    }

    // menangani aksi atau logika peminjaman
    public function peminjaman_aksi(){

        // Set zona waktu di indonesia
        date_default_timezone_set("Asia/Jakarta");

        // Mengambil data dari input
        $id_distributor = $this->input->post('id_distributor');
        $id_poli = $this->input->post('id_poli');
        $id_pinjam = $this->input->post('id_pinjam');
        $keterangan = $this->input->post('keterangan');
        $nama_pasien = $this->input->post('nama_pasien');
        $waktu = null;

        // Mendapatkan input waktu lama peminjaman
        if ($this->input->post('waktu') == '1x24') {
            $waktu = date("Y-m-d H:i:s", strtotime('+ 1 day'));
        }elseif($this->input->post('waktu') == '2x24'){
            $waktu = date("Y-m-d H:i:s", strtotime('+ 2 day'));
        }else{
            $waktu = date("Y-m-d H:i:s", strtotime('+1 minutes'));
        }
        
        // Memasukkan segala informasi atau data di array
        $input = [
            'tanggal' => date("Y-m-d"),
            'keterangan' => $keterangan,
            'peminjaman_id_peminjaman' => $id_pinjam,
            'poli_id_poli' => $id_poli,
            'distributor_id_distributor' => $id_distributor,
            'waktu' => $waktu,
            'tipe' => 'Peminjaman',
            'status' => 'dipinjam'
        ];

        // Mendapatkan id poli
        $data = $this->db->get_where('poli', ['id_poli' => $id_poli])->row_array();

        // Mengupdate tabel peminjaman
        $this->db->set('status', $data['nama_poli']);
        $this->db->set('distributor', $id_distributor);
        $this->db->where('id_peminjaman', $this->input->post('id_pinjam'));

        // Mengeksekusi update tabel peminjaman
        // Menambahkan data di tabel detail pinjam
        if ($this->db->update('peminjaman') && $this->db->insert('detail_pinjam', $input)) {
            $this->sendMessage($nama_pasien, $data['telepon']); //Mengirim pesan ke petugas
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berkas berhasil dikirim!</div>'); 
            redirect('dashboard');
        }else{
            // Jika gagal mengupdate tabel peminjaman dan menambahkan data di tabel detail pinjam
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Berkas gagal dikirim!</div>');
            redirect('dashboard'); // Kembali ke halaman dashboard
        }
        echo json_encode($data);
    }

    // Menangani fungsi atau logika pengembalian berkas
    public function pengembalian(){

        // Set zona waktu di indonesia
        date_default_timezone_set("Asia/Jakarta");

        // Mendapatkan data dari input
        $id_pasien = $this->input->post('id_pasien');
        $id_pinjam = $this->input->post('id_pinjam');
        $id_distributor = $this->input->post('id_distributor');
        $poli = $this->input->post('poli');

        // Data input dimasukkan kedalam array
        $input = [
            'tanggal' => date("Y-m-d"),
            'keterangan' => 'Pengembalian dari '.$poli,
            'peminjaman_id_peminjaman' => $id_pinjam,
            'poli_id_poli' => '1',
            'distributor_id_distributor' => $id_distributor,
            'waktu' => date('Y-m-d'),
            'tipe' => 'Pengembalian',
            'status' => 'dikembalikan'
        ];

        // Mengupdate tabel peminjaman, mengganti statusnya menjadi kosong / kondisi standby tidak sedang dipinjam
        $this->db->set('status', '-');
        $this->db->where('id_peminjaman', $id_pinjam);

        // Mengeksekusi update peminjaman dan menambahkan data ke tabel detail pinjam
        if ($this->db->update('peminjaman') && $this->db->insert('detail_pinjam', $input)) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berkas berhasil dikembalikan!</div>');
            redirect('dashboard'); // Kembali ke halaman dashboard
        }else{
            // Jika gagal
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Berkas gagal dikembalikan!</div>');
            redirect('dashboard'); // Kembali ke halaman dashboard
        }
    }

    // Aksi untuk menghapus data peminjaman pasien
    public function hapus(){
        
        // Mengeksekusi hapus data berdasarkan id
        if ($this->db->delete('peminjaman', ['id_peminjaman' => $this->input->get('id')])) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berkas berhasil dihapus!</div>');
            redirect('dashboard'); // redirect ke dashboard
        }else{
            // Jika gagal
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Berkas gagal dihapus!</div>');
            redirect('dashboard'); // Redirect ke dashbaord
        }
    }


    // Menangani aksi atau fungsi search
    public function search(){

        // Mendapatkan data dari input (keyword)
        $keyword = $this->input->get('keyword');

        // Jika data tidak ditemukan didatabase
        if (empty($this->Pasien->search($keyword))) {
            echo "
                <div class='alert alert-light mt-2'>
                    <strong>Mohon maaf,</strong> data yang anda cari tidak ditemukan!
                </div>
            ";
        }else{
            // Jika data ditemukan
            $no = 1; // nomor tabel
            foreach ($this->Pasien->search($keyword) as $item) {
                // Menampilkan tabel, tabel yang lama direplace diganti dengan tabel dibawah ini
                echo '
                <tr>
                    <td style="width: 8%">'. $no++ .'</td>
                    <td>'. $item['no_rm'] .'</td>
                    <td>'. $item['nama_pasien'] .'</td>
                    <td>'. $item['status'] .'</td>
                    <td>'. $item['tanggal_masuk'] .'</td>
                    <td>'. $item['no_rak'] .'</td>
                    <td style="width: 27%" class="text-center">
                        <form 
                            action="
                            ';
                            if ($item['status'] == '-') {
                                echo base_url('dashboard/peminjaman');
                            }else{
                                echo base_url('dashboard/pengembalian');
                            }
                            echo '"
                            method="post">

                            <input type="hidden" name="id_pasien" value="'. $item['id_pasien'].'">
                            <input type="hidden" name="id_pinjam" value="'. $item['id_peminjaman'].'">
                            <input type="hidden" name="id_distributor" value="'. $item['distributor'].'">
                            
                            
                            '; 
                            if ($item['status'] == '-') {
                            echo '
                                <button type="submit" class="btn btn-success btn-icon-split">
                                    <span class="icon text-white-50">
                                    <i class="fas fa-check"></i>
                                    </span>
                                    <span class="text">Kirim</span>
                                </button>
                            ';
                            }else{
                            echo '
                                <button type="submit" class="btn btn-warning btn-icon-split">
                                    <span class="icon text-white-50">
                                    <i class="fas fa-arrow-left"></i>
                                    </span>
                                    <span class="text">Kembali</span>
                                </button>
                            ';
                            }
                            echo '
                                <a href="'. base_url('dashboard/hapus?id='.$item['id_peminjaman']).'" class="btn btn-danger btn-icon-split">
                                    <span class="icon text-white-50">
                                    <i class="fas fa-trash"></i>
                                    </span>
                                    <span class="text">Hapus</span>
                                </a>
                        </form>
                    </td>
                </tr>';
            }
        }
    }


    // Menangani pengiriman pesan ke petugas menggunakan telegram
    // Membawa parameter nama pasien dan telepon
    public function sendMessage($nama_pasien, $telepon) {

        // Token/key untuk bot yang dibuat di telegram
        $secret_token = '1357308704:AAFTKe7m7Q7P1dfX4MY-4kYmRs7tQi20w-4';

        // Pesan yang akan dikirimkan 
        $message_text = 'Berkas pasien '.$nama_pasien.' akan segera dikirimkan';

        // id telegram target yang akan dikirim, diisi dengan parameter telepon
        $telegram_id = $telepon;

        // Mengeksekusi pengiriman pesan
        $url = "https://api.telegram.org/bot" . $secret_token . "/sendMessage?parse_mode=markdown&chat_id=" . $telegram_id;
        $url = $url . "&text=" . urlencode($message_text);
        $ch = curl_init();
        $optArray = array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true
        );
        curl_setopt_array($ch, $optArray);
        $result = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
    }
}