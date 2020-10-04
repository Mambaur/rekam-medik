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
            'id_pinjam' => $this->input->post('id_pinjam'),
            'nama_pasien' => $this->input->post('nama_pasien')
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
        $nama_pasien = $this->input->post('nama_pasien');
        if ($this->input->post('waktu') == '1x24') {
            $waktu = date("Y-m-d", strtotime('+ 1 day'));
        }else{
            $waktu = date("Y-m-d", strtotime('+ 2 day'));
        }
        

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

        $data = $this->db->get_where('poli', ['id_poli' => $id_poli])->row_array();

        $this->db->set('status', $data['nama_poli']);
        $this->db->set('distributor', $id_distributor);
        $this->db->where('id_peminjaman', $this->input->post('id_pinjam'));

        if ($this->db->update('peminjaman') && $this->db->insert('detail_pinjam', $input)) {
            $this->sendMessage($nama_pasien, $data['telepon']);
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
        $poli = $this->input->post('poli');

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

    public function search(){
        $keyword = $this->input->get('keyword');
        if (empty($this->Pasien->search($keyword))) {
            echo "
                <div class='alert alert-light mt-2'>
                    <strong>Mohon maaf,</strong> data yang anda cari tidak ditemukan!
                </div>
            ";
        }else{
            $no = 1;
            foreach ($this->Pasien->search($keyword) as $item) {
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


    public function sendMessage($nama_pasien, $telepon) {
        $secret_token = '1357308704:AAFTKe7m7Q7P1dfX4MY-4kYmRs7tQi20w-4';
        $message_text = 'Berkas pasien '.$nama_pasien.' akan segera dikirimkan';
        $telegram_id = $telepon;

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