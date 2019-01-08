<?php
	class Beranda_model extends CI_Model{

		var $table = 'tbl_dokumen';
	    var $column_order = array(null, 'no_document','name_document','upload_date','document_date','expired_date','document_label','nama', 'file'); //field yang ada di table unit
	    var $column_search = array('no_document','name_document','upload_date','document_date','expired_date','document_label','nama', 'file'); //field yang diizin untuk pencarian 
	    var $order = array('upload_date' => 'desc'); // default order
		
	    private function _get_datatables_query(){
	        $now = date("Y-m-d");

	        $this->db->from($this->table);
	        $this->db->where('tbl_dokumen.status', 'Aktif');
	        $this->db->where('tbl_dokumen.document_label', 'umum');
	 		$this->db->group_start();
	        $this->db->where('tbl_dokumen.expired_date >', $now);
	        $this->db->or_where('tbl_dokumen.expired_date =', "00-00-00 00:00:00");
	        $this->db->group_end(); 

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
	    	$this->db->join ( 'user', 'user.id_user = tbl_dokumen.upload_by');
	        $query = $this->db->get();
	        return $query->result();
	    }
	 
	    function count_filtered()
	    {
	        $this->_get_datatables_query();
	        $this->db->join ( 'user', 'user.id_user = tbl_dokumen.upload_by');
	        $query = $this->db->get();
	        return $query->num_rows();
	    }
	 
	    public function count_all()
	    {
	        $now = date("Y-m-d");

	        $this->db->from($this->table);
	        $this->db->where('tbl_dokumen.status', 'Aktif');
	        $this->db->where('tbl_dokumen.document_label', 'umum');
	 		$this->db->group_start();
	        $this->db->where('tbl_dokumen.expired_date >', $now);
	        $this->db->or_where('tbl_dokumen.expired_date =', "00-00-00 00:00:00");
	        $this->db->group_end(); 
	        return $this->db->count_all_results();
	    }

	    public function get_by_id($id){
			$this->db->from($this->table);
			$this->db->where('id_document', $id);
			$query = $this->db->get();

			return $query->row();
		}

		public function get_file_by_id($id_document){
	    	$this->db->select('file');
	    	$this->db->from('tbl_dokumen');
	    	$this->db->where('id_document', $id_document);
	    	$query = $this->db->get();

	    	return $query->row();
	    }
	}