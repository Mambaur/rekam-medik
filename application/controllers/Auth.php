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



    public function tes(){
        $data = $this->db->get('comments')->num_rows();
        $data2 = $this->db->get('comments')->result_array();

        // echo $data;
        if ($data == 10) {
            for ($i=0; $i < 5; $i++) { 
                // echo $data2[$i]['comment_id'];
                $this->db->delete('comments', ['comment_id' => $data2[$i]['comment_id']]);
            }
        }


        $this->db->insert('comments', ['comment_id' => $this->createId() ,'comment_subject' => $this->input->get('data')]);
    }

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