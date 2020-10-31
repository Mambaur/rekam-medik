<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    // Menampilkan halamn login
    public function index(){
        // Mengecek apakah user sudah login apa belum
        if ($this->session->userdata('email')) {
            // jika sudah, dialihkan ke halaman dashboard
			redirect('dashboard');
        }
        // jika belum ke halaman login
        $this->load->view('login-view');
    }

    // Menangani ketika tombol login di klik
    public function login(){

        // Mengambil data dari inputan, dan di masukkan kedalam array
        $input = [
            'email' => $this->input->post('email'),
            'password' => $this->input->post('password'),
        ];

        // Mencocokkan data input dengan yang ada di database
        $user = $this->db->get_where('petugas', $input)->row_array();

        // Jika data di database ada
        if($user){
            // Menyimpan data petugas  yang login ke cache, agar nanti tidak perlu login kembali jika menutup browser atau tab
            $data = [
                'email' => $user['email'],
                'nama_petugas' => $user['nama_petugas']
            ];
            $this->session->set_userdata($data);
            redirect('dashboard'); // dialihkan ke halaman dashboard
        }else{
            // Jika gagal muncul pesan 
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Mohon maaf password anda salah!</div>');
            // kembali ke halaman login
            redirect('auth');
        }
    }

    // Menangani fungsi ketika tombol atau menu logout ditekan
    public function logout(){
        $this->session->unset_userdata('email'); // menghapus session cache
		$this->session->unset_userdata('nama_petugas'); // menghapus session cache

		$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Anda berhasil logout!</div>'); // menampilkan pesan logout
		redirect('auth'); // dialihkan ke halaman login
    }



    // public function tes(){
    //     $data = $this->db->get('comments')->num_rows();
    //     $data2 = $this->db->get('comments')->result_array();

    //     if ($data == 10) {
    //         for ($i=0; $i < 5; $i++) { 
    //             $this->db->delete('comments', ['comment_id' => $data2[$i]['comment_id']]);
    //         }
    //     }


    //     $this->db->insert('comments', ['comment_id' => $this->createId() ,'comment_subject' => $this->input->get('data')]);
    // }
    

    // Men-generate id baru
    public function createId(){
        $this->db->select('RIGHT(comments.comment_id, 4) as kode', FALSE);
        $this->db->order_by('comment_id','DESC');    
        $this->db->limit(1);    
        $query = $this->db->get('comments');     
        if($query->num_rows() <> 0){      
        
            $data = $query->row();      
            $kode = intval($data->kode) + 1;    
        }
        else {      
            //jika kode belum ada      
            $kode = 1;    
        }
        $kodemax = str_pad($kode, 4, "0", STR_PAD_LEFT); 
        $kodejadi = "PS".$kodemax; 
        return $kodejadi;
    }

}