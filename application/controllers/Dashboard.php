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
        $poli = $this->input->post('poli');

        $input = [
            'tanggal' => date("Y-m-d"),
            'keterangan' => 'Pengembalian dari '.$poli,
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
}