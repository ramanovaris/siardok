<?php
	class Login_model extends CI_Model{
		// Login User
		public function __construct() {
        	$this->load->database();
        }
        
		public function sign_in($nik){
			// Validate
			$this->db->where('nik', $nik);

			$result = $this->db->get('user');

			if($result->num_rows() == 1){
				return $result->row(0)->id_user;
			} else {
				return false;
			}
		}

		public function get_id_telegram_by_username($nik) {
    		$query = $this->db->select('id_user, id_telegram')
            ->from('user')
            ->where('nik', $nik)
            ->get();
        	return $query->row_array();
    	}
	}