<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function index(){
        if ($this->session->userdata('email')) {
			redirect('dashboard');
		}
        $this->load->view('login-view');
    }

    public function login(){
        $input = [
            'email' => $this->input->post('email'),
            'password' => $this->input->post('password'),
        ];

        $user = $this->db->get_where('petugas', $input)->row_array();

        if($user){
            $data = [
                'email' => $user['email'],
                'nama_petugas' => $user['nama_petugas']
            ];
            $this->session->set_userdata($data);
            redirect('dashboard');
        }else{
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Mohon maaf password anda salah!</div>');
            redirect('auth');
        }
    }

    public function logout(){
        $this->session->unset_userdata('email');
		$this->session->unset_userdata('nama_petugas');

		$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Anda berhasil logout!</div>');
		redirect('auth');
    }
}