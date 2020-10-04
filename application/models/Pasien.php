<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pasien extends CI_Model{
	public function getPasien(){
        $this->db->join('poli', 'pasien.poli_id_poli = poli.id_poli');
		$this->db->join('peminjaman', 'pasien.id_pasien = peminjaman.pasien_id_pasien');
		$this->db->order_by('id_pasien', 'desc');
		return $this->db->get('pasien')->result_array();
	}

	public function getDistributor(){
		return $this->db->get('distributor')->result_array();
	}
	
	public function getPoli(){
		return $this->db->get('poli')->result_array();
	}

	public function createIdPasien(){
		$this->db->select('RIGHT(pasien.id_pasien, 4) as kode', FALSE);
		$this->db->order_by('id_pasien','DESC');    
		$this->db->limit(1);    
		$query = $this->db->get('pasien');     
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
	
	public function createIdPinjam(){
		$this->db->select('RIGHT(detail_pinjam.peminjaman_id_peminjaman, 4) as kode', FALSE);
		$this->db->order_by('peminjaman_id_peminjaman','DESC');    
		$this->db->limit(1);    
		$query = $this->db->get('detail_pinjam');     
		if($query->num_rows() <> 0){      
		
			$data = $query->row();      
			$kode = intval($data->kode) + 1;    
		}
		else {      
			//jika kode belum ada      
			$kode = 1;    
		}
		$kodemax = str_pad($kode, 4, "0", STR_PAD_LEFT); 
		$kodejadi = '11'.$kodemax;  
		return $kodejadi;
	}

	function search($keyword){
		$this->db->join('poli', 'pasien.poli_id_poli = poli.id_poli');
		$this->db->join('peminjaman', 'pasien.id_pasien = peminjaman.pasien_id_pasien');
		$this->db->order_by('id_pasien', 'desc');
		$this->db->or_like(["nama_pasien"=>$keyword, 'no_rm'=> $keyword]);
		return $this->db->get('pasien')->result_array();
	}
}