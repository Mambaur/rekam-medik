<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pesan extends CI_Controller {
	public function __construct(){
		parent::__construct();
        if (!$this->session->userdata('email')) {
			redirect('auth');
		}
    }

    // Remove webhook
    // https://api.telegram.org/bot1357308704:AAFTKe7m7Q7P1dfX4MY-4kYmRs7tQi20w-4/SETWebhook

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
            'id_userMessage' => $telegram_id,
            'tipe' => 'Kirim'
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

    public function getMessage(){
        $getData = file_get_contents('https://api.telegram.org/bot1357308704:AAFTKe7m7Q7P1dfX4MY-4kYmRs7tQi20w-4/getUpdates');

        $data = json_decode($getData, TRUE);

        $this->expiredMessage();

        if(count($data['result']) > 0){
            for ($i=0; $i < count($data['result']); $i++) { 
                $message_id = $data['result'][$i]['message']['message_id'];
                $cek = $this->db->get_where('pesan', ['id_pesan' => $message_id])->num_rows();

                if ($cek == 0) {
                    $dataPesan = [
                        'id_pesan' => $data['result'][$i]['message']['message_id'],
                        'subjek' => $data['result'][$i]['message']['from']['first_name'],
                        'isi_pesan' => $data['result'][$i]['message']['text'],
                        'status' => 0,
                        'time' => date('d/m/Y H:i:s', $data['result'][$i]['message']['date']),
                        'id_userMessage' =>  $data['result'][$i]['message']['chat']['id'],
                        'tipe' => 'Terima'
                    ];
                    $this->db->insert('pesan', $dataPesan);
                }
            }
            echo $this->db->get_where('pesan', ['status' => 0, 'tipe' => 'Terima'])->num_rows();
        }

    }

    // fungsi yang dilakukan di cron job
    public function expiredMessage(){
        
        $secret_token = '1357308704:AAFTKe7m7Q7P1dfX4MY-4kYmRs7tQi20w-4';
        $message_text = 'Mohon maaf, berkas pasien harus segera dikembalikan';

        $data = $this->db->get_where('detail_pinjam', ['tipe' => 'Peminjaman', 'status' => 'dipinjam'])->result_array();
        for ($i=0; $i < count($data); $i++) { 
            $data_poli = $this->db->get_where('poli', ['id_poli' => $data[$i]['poli_id_poli']])->row_array();
            $telegram_id = $data_poli['telepon'];

            if (strtotime($data[$i]['waktu']) <= strtotime(date("Y-m-d"))) {
                $this->db->where('status', 'dipinjam');
                $this->db->update('detail_pinjam', ['status' => 'Terlambat']);
                $this->sendMessage($telegram_id, $message_text, $secret_token);
            }
        }

    }

    public function readMessage(){
        $data = $this->db->get_where('pesan', ['status' => 0, 'tipe' => 'Terima'])->result_array();
        foreach ($data as $item) {
            echo '<a class="dropdown-item d-flex align-items-center" href="#">
            <div>
                <div class="text-truncate">'.$item['isi_pesan'].'</div>
                <div class="small text-gray-500">'.$item['subjek'].' - '.$item['id_userMessage'].'</div>
            </div>
            </a>';
        }
        $this->db->update('pesan', ['status' => 1]);
    }
}