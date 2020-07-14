<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pesan extends CI_Controller {
	public function __construct(){
		parent::__construct();
        if (!$this->session->userdata('email')) {
			redirect('auth');
		}
    }

    public function index(){
        $data['poli'] = $this->db->get('poli')->result_array();
        $data['tbpesan'] = $this->db->get('pesan')->result_array();
        $this->load->view('widgets/header-view.php');
        $this->load->view('widgets/sidebar-view.php');
        $this->load->view('widgets/topbar-view.php');
        $this->load->view('pesan/pesan-view.php', $data);
        $this->load->view('widgets/footer-view.php');
    }

    public function telegram(){
        $secret_token = '1357308704:AAFTKe7m7Q7P1dfX4MY-4kYmRs7tQi20w-4';
        // $telegram_id = '628079062';
        // $message_text = 'Hello mambaur';
        $telegram_id = $this->input->post('telepon');
        $message_text = $this->input->post('pesan');
        $poli = $this->db->get_where('poli', ['telepon' => $telegram_id])->row_array();
        $data = [
            'subjek' => $poli['nama_poli'],
            'isi_pesan' => $message_text,
            'status' => '0',
            'time' => date('d-m-Y H:i:s'),
        ];
        if ($this->db->insert('pesan', $data)) {
            $this->sendMessage($telegram_id, $message_text, $secret_token);
        }else{
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Pesan gagal dimasukkan kedalam database!</div>');
            redirect('pesan');
        }
    }

    public function sendMessage($telegram_id, $message_text, $secret_token) {
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

        if ($err) {
        //    echo 'Pesan gagal terkirim, error :' . $err;
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Pesan gagal dikirim, mohon periksa koneksi internet anda!</div>');
            redirect('pesan');
        }else{
            // echo 'Pesan terkirim';
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Pesan berhasil dikirim!</div>');
            redirect('pesan');
        }
    }
}