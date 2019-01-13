<?php
	class User_model extends CI_Model{
		
		var $table = 'user';
		var $tbl_units_member = 'tbl_units_member';
	    var $column_order = array('nama', 'no_ktp', 'nik', 'foto_ktp', 'foto_karpeg', 'no_hp', 'level', 'posisi', 'instansi'); //field yang ada di table user
	    var $column_search = array('no_ktp', 'nama', 'instansi', 'posisi', 'nik', 'no_hp', 'level'); //field yang diizin untuk pencarian 
	    var $order = array('nama' => 'asc'); // default order
		
	    private function _get_datatables_query(){
	        $this->db->from($this->table);
	        $this->db->where('status', 'Active');
	 
	        $i = 0;
	     
	        foreach ($this->column_search as $item) // looping awal
	        {
	            if($_POST['search']['value']) // jika datatable mengirimkan pencarian dengan metode POST
	            {
	                 
	                if($i===0) // looping awal
	                {
	                    $this->db->group_start(); 
	                    $this->db->like($item, $_POST['search']['value']);
	                }
	                else
	                {
	                    $this->db->or_like($item, $_POST['search']['value']);
	                }
	 
	                if(count($this->column_search) - 1 == $i) 
	                    $this->db->group_end(); 
	            }
	            $i++;
	        }
	         
	        if(isset($_POST['order'])) 
	        {
	            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
	        } 
	        else if(isset($this->order))
	        {
	            $order = $this->order;
	            $this->db->order_by(key($order), $order[key($order)]);
	        }
	    }

	    function get_datatables()
	    {
	    	$this->_get_datatables_query();	
	        if($_POST['length'] != -1)
	        $this->db->limit($_POST['length'], $_POST['start']);
	        $query = $this->db->get();
	        return $query->result();
	    }
	 
	    function count_filtered()
	    {
	    	$this->_get_datatables_query();	
	        $query = $this->db->get();
	        return $query->num_rows();
	    }
	 
	    public function count_all()
	    {	
	    	$this->db->from($this->table);
		    $this->db->where('status', 'Active');
		    return $this->db->count_all_results();
	    }

		public function addUser($data){
			$this->db->insert('user', $data);		
			return $this->db->insert_id();
		}

		public function get_all_users(){
			$this->db->from('user');
			$query = $this->db->get();
			return $query->result();
		}

		public function get_data_by_id($id_user){
			$this->db->from($this->table);
			$this->db->where('id_user', $id_user);
			$query = $this->db->get();

			return $query->row();
		}

		public function user_update($where, $data) {
			$this->db->update('user', $data, $where);
			return $this->db->affected_rows();
		}

		public function delete_by_status($id){

			$data = array(
				'status' => 'Inactive', 
			);

			$this->db->where('id_user', $id);
			$this->db->update('user', $data);
		} 	

		public function get_units_by_id_user($id){
			$this->db->select ( '*' ); 
		    $this->db->from ( 'tbl_units_member' );
		    $this->db->join ( 'tbl_units', 'tbl_units.id_unit = tbl_units_member.id_unit' , 'left' );
		    $this->db->join ( 'user', 'user.id_user = tbl_units_member.id_user' , 'left' );
		    $this->db->where('tbl_units_member.id_user', $id);
			$query = $this->db->get();
			return $query->result();
		}

		public function delete_by_id_unit($id){
			$this->db->where('id_unit_member', $id);
			$this->db->delete('tbl_units_member');
		}

		public function get_units_except($id){
			$sql = "SELECT * FROM `tbl_units` WHERE id_unit NOT IN (SELECT id_unit FROM `tbl_units_member` WHERE id_user = ".$id.") AND status = 'Active'";
			$query = $this->db->query($sql);
			return $query->result();
		}
		
		public function addUnits($data){
			$this->db->insert($this->tbl_units_member, $data);		
			return $this->db->insert_id();
		}
		
		//Cek NIK kalo ada yang sama
		public function getNik($nik){
			$this->db->where('nik' , $nik);
			$query = $this->db->get('user');

			if($query->num_rows()>0){
				return true;
			} else {
				return false;
			}
 		}

 		//Cek no_ktp kalo ada yang sama
		public function get_no_ktp($no_ktp){
			$this->db->where('no_ktp' , $no_ktp);
			$query = $this->db->get('user');

			if($query->num_rows()>0){
				return true;
			} else {
				return false;
			}
 		}

 		//Cek no_hp kalo ada yang sama
		public function get_no_hp($no_hp){
			$this->db->where('no_hp' , $no_hp);
			$query = $this->db->get('user');

			if($query->num_rows()>0){
				return true;
			} else {
				return false;
			}
 		}

 		//Cek id_telegram kalo ada yang sama
		public function get_id_telegram($id_telegram){
			$this->db->where('id_telegram' , $id_telegram);
			$query = $this->db->get('user');

			if($query->num_rows()>0){
				return true;
			} else {
				return false;
			}
 		}

 		public function get_file_by_id($id_user){
 			$this->db->select('foto_ktp, foto_karpeg');
	    	$this->db->from('user');
	    	$this->db->where('id_user', $id_user);
	    	$query = $this->db->get();

	    	return $query->row();
 		}

 		public function get_detail_by_id($id_user){
 			$this->db->select('instansi, posisi');
	    	$this->db->from('user');
	    	$this->db->where('id_user', $id_user);
	    	$query = $this->db->get();

	    	return $query->row_array();
 		}

 		public function get_name_for_delete($id_user){
 			$this->db->select('nama');
	    	$this->db->from('user');
	    	$this->db->where('id_user', $id_user);
	    	$query = $this->db->get();

	    	return $query->row_array();
 		}

 		public function get_unit_for_delete($id_unit){
 			$this->db->select('nama_unit');
	    	$this->db->from('tbl_units_member');
	 		$this->db->join('tbl_units', 'tbl_units.id_unit = tbl_units_member.id_unit');   	
	    	$this->db->where('tbl_units_member.id_unit_member', $id_unit);
	    	$query = $this->db->get();

	    	return $query->row_array();
 		}
	}