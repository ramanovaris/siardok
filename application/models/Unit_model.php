<?php
	class Unit_model extends CI_Model{

		var $table = 'tbl_units';
		var $tbl_units_member = 'tbl_units_member';
	    var $column_order = array(null, 'id_unit','nama_unit'); //field yang ada di table unit
	    var $column_search = array('nama_unit'); //field yang diizin untuk pencarian 
	    var $order = array('id_unit' => 'asc'); // default order
		
	    private function _get_datatables_query(){
	        $this->db->from($this->table);
	 
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
	        return $this->db->count_all_results();
	    }

		public function addUnit($data){
			$res = array(
			  'status' => 'success',
			  'id_unit' => $this->db->insert_id(),
			  'nama_unit' => $data['nama_unit']
			);

			$this->db->insert($this->table, $data);
			echo json_encode($res);
		}

		public function get_all_units(){
			$this->db->from('tbl_units');
			$query = $this->db->get();
			return $query->result();
		}

		public function get_by_id($id){
			$this->db->from($this->table);
			$this->db->where('id_unit', $id);
			$query = $this->db->get();

			return $query->row();
		}

		public function unit_update($where, $data) {
			$this->db->update($this->table, $data, $where);
			return $this->db->affected_rows();
		}

		public function delete_by_id($id){
			$this->db->where('id_unit', $id);
			$this->db->delete($this->table);
		}

		public function get_member_by_id_unit($id){
			$this->db->select ( '*' ); 
		    $this->db->from ( 'tbl_units_member' );
		    $this->db->join ( 'tbl_units', 'tbl_units.id_unit = tbl_units_member.id_unit' , 'left' );
		    $this->db->join ( 'user', 'user.id_user = tbl_units_member.id_user' , 'left' );
		    $this->db->where('tbl_units_member.id_unit', $id);
			$query = $this->db->get();
			return $query->result();
		}

		public function get_id_user_by_id_unit($id){
			$this->db->select ( '*' ); 
		    $this->db->from ( 'tbl_units_member' );
		    $this->db->join ( 'tbl_units', 'tbl_units.id_unit = tbl_units_member.id_unit' , 'left' );
		    $this->db->join ( 'user', 'user.id_user = tbl_units_member.id_user' , 'left' );
		    $this->db->where('tbl_units_member.id_unit', $id);
			$query = $this->db->get();
			return $query->result_array();
		}

		public function delete_by_id_user($id){
			$this->db->where('id_unit_member', $id);
			$this->db->delete('tbl_units_member');
		}
		
		public function get_user_except($id){
			$sql = "SELECT * FROM `user` WHERE id_user NOT IN (SELECT id_user FROM `tbl_units_member` WHERE id_unit = ".$id.") AND status = 'Active'";
			$query = $this->db->query($sql);
			return $query->result();
		}

		public function get_user_except_admin($id){
			$sql = "SELECT * FROM `user` WHERE id_user NOT IN (SELECT id_user FROM `tbl_units_member` WHERE id_unit = ".$id.") AND status = 'Active' AND level != 'SuperAdmin'";
			$query = $this->db->query($sql);
			return $query->result();
		}

		public function addMember($data){
			$this->db->insert($this->tbl_units_member, $data);		
			return $this->db->insert_id();
		}

		//Cek Nama Unit kalo ada yang sama
		public function getNamaUnit($nama_unit){
			$this->db->where('nama_unit' , $nama_unit);
			$query = $this->db->get('tbl_units');

			if($query->num_rows()>0){
				return true;
			} else {
				return false;
			}
 		}

 		public function get_name_unit_for_delete($id_unit){
 			$this->db->select('nama_unit');
	    	$this->db->from('tbl_units');
	    	$this->db->where('id_unit', $id_unit);
	    	$query = $this->db->get();

	    	return $query->row_array();
 		}

 		public function get_name_member_for_delete($id_unit){
 			$this->db->select('nama');
	    	$this->db->from('tbl_units_member');
	 		$this->db->join('user', 'user.id_user = tbl_units_member.id_user');   	
	    	$this->db->where('tbl_units_member.id_unit_member', $id_unit);
	    	$query = $this->db->get();

	    	return $query->row_array();
 		}
	}