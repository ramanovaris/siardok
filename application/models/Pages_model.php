<?php
	class Pages_model extends CI_Model{

		var $table = 'tbl_dokumen';
	    var $column_order = array('no_document','name_document','upload_date','document_date','expired_date','nama'); //field yang ada di table unit
	    var $column_search = array('no_document','name_document','upload_date','document_date','expired_date','nama', 'file'); //field yang diizin untuk pencarian 
	    var $order = array('upload_date' => 'desc'); // default order
		
	    private function _get_datatables_query_internal(){
			
			$now = date("Y-m-d");

			$sesIdUser = $this->session->userdata('id_user');

			$query1 = $this->db->query("SELECT id_unit from tbl_units_member WHERE id_user = '".$sesIdUser."'");
			$query1_result = $query1->result();
			$id_user= array();
			foreach($query1_result as $row){
			     $id_user[] = $row->id_unit;
			}
			$user = implode(",",$id_user);
	  		$id = explode(",", $user);

	        $this->db->select('tbl_dokumen.id_document, tbl_dokumen.no_document, tbl_dokumen.name_document, tbl_dokumen.upload_date, tbl_dokumen.document_date, tbl_dokumen.expired_date, tbl_dokumen.status, tbl_dokumen.document_label, user.nama, tbl_dokumen.file');
	        $this->db->from('tbl_dokumen');
	        $this->db->join('user', 'user.id_user=tbl_dokumen.upload_by');
	        $this->db->join('tbl_unit_document', 'tbl_unit_document.id_document=tbl_dokumen.id_document');
	        $this->db->where('tbl_dokumen.status', 'Aktif');
	        $this->db->group_start();
	        $this->db->where('tbl_dokumen.expired_date >', $now);
	        $this->db->or_where('tbl_dokumen.expired_date =', "00-00-00 00:00:00");
	        $this->db->group_end(); 
	        $this->db->where_in('tbl_unit_document.id_unit', $id);
	        $this->db->group_by('tbl_dokumen.id_document');
			

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

	    function get_datatables_internal(){
	        $this->_get_datatables_query_internal();
	        if($_POST['length'] != -1)
	        $this->db->limit($_POST['length'], $_POST['start']);

	    	$query2 = $this->db->get();
	    	return $query2->result();
	    }
	 
	    function count_filtered_internal(){
	        $this->_get_datatables_query_internal();

	        $query2 = $this->db->get();
	    	return $query2->num_rows();
	    }
	 
	    public function count_all_internal(){
	        $now = date("Y-m-d");

			$sesIdUser = $this->session->userdata('id_user');

			$query1 = $this->db->query("SELECT id_unit from tbl_units_member WHERE id_user = '".$sesIdUser."'");
			$query1_result = $query1->result();
			$id_user= array();
			foreach($query1_result as $row){
			     $id_user[] = $row->id_unit;
			}
			$user = implode(",",$id_user);
	  		$id = explode(",", $user);

	        $this->db->select('tbl_dokumen.id_document, tbl_dokumen.no_document, tbl_dokumen.name_document, tbl_dokumen.upload_date, tbl_dokumen.document_date, tbl_dokumen.expired_date, tbl_dokumen.status, tbl_dokumen.document_label, user.nama, tbl_dokumen.file');
	        $this->db->from('tbl_dokumen');
	        $this->db->join('user', 'user.id_user=tbl_dokumen.upload_by');
	        $this->db->join('tbl_unit_document', 'tbl_unit_document.id_document=tbl_dokumen.id_document');
	        $this->db->where('tbl_dokumen.status', 'Aktif');
	        $this->db->group_start();
	        $this->db->where('tbl_dokumen.expired_date >', $now);
	        $this->db->or_where('tbl_dokumen.expired_date =', "00-00-00 00:00:00");
	        $this->db->group_end(); 
	        $this->db->where_in('tbl_unit_document.id_unit', $id);
	        $this->db->group_by('tbl_dokumen.id_document');
	        return $this->db->count_all_results();
	    }

	    private function _get_datatables_query_umum(){
			
			$now = date("Y-m-d");

	        $this->db->select('id_document, no_document,name_document,upload_date,document_date,expired_date,document_label,nama,file');
	        $this->db->from('tbl_dokumen');
	        $this->db->join('user', 'user.id_user=tbl_dokumen.upload_by');
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

	    function get_datatables_umum(){
	        $this->_get_datatables_query_umum();
	        if($_POST['length'] != -1)
	        $this->db->limit($_POST['length'], $_POST['start']);

	    	$query2 = $this->db->get();
	    	return $query2->result();
	    }

	    function count_filtered_umum(){
	        $this->_get_datatables_query_umum();

	        $query2 = $this->db->get();
	    	return $query2->num_rows();
	    }

	    public function count_all_umum(){
	        $now = date("Y-m-d");

	        $this->db->select('no_document,name_document,upload_date,document_date,expired_date,document_label,nama,file');
	        $this->db->from('tbl_dokumen');
	        $this->db->join('user', 'user.id_user=tbl_dokumen.upload_by');
	        $this->db->where('tbl_dokumen.status', 'Aktif');
	        $this->db->where('tbl_dokumen.document_label', 'umum');
	        $this->db->group_start();
	        $this->db->where('tbl_dokumen.expired_date >', $now);
	        $this->db->or_where('tbl_dokumen.expired_date =', "00-00-00 00:00:00");
	        $this->db->group_end();
	        return $this->db->count_all_results();
	    }

	    private function _get_datatables_query_rahasia(){
			$id_user = $this->session->userdata('id_user');
			$now = date("Y-m-d");
			
	        $this->db->select('id_document, no_document,name_document,upload_date,document_date,expired_date,document_label,nama,file');
	        $this->db->from('tbl_dokumen');
	        $this->db->join('user', 'user.id_user=tbl_dokumen.upload_by');
	        $this->db->where('tbl_dokumen.status', 'Aktif');
	        $this->db->where('tbl_dokumen.document_label', 'rahasia');
	        $this->db->where('tbl_dokumen.upload_by', $id_user);
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

	    function get_datatables_rahasia(){
	        $this->_get_datatables_query_rahasia();
	        if($_POST['length'] != -1)
	        $this->db->limit($_POST['length'], $_POST['start']);

	    	$query2 = $this->db->get();
	    	return $query2->result();
	    }

	    function count_filtered_rahasia(){
	        $this->_get_datatables_query_rahasia();

	        $query2 = $this->db->get();
	    	return $query2->num_rows();
	    }

	    public function count_all_rahasia(){
	        $id_user = $this->session->userdata('id_user');
			$now = date("Y-m-d");
			
	        $this->db->select('no_document,name_document,upload_date,document_date,expired_date,document_label,nama,file');
	        $this->db->from('tbl_dokumen');
	        $this->db->join('user', 'user.id_user=tbl_dokumen.upload_by');
	        $this->db->where('tbl_dokumen.status', 'Aktif');
	        $this->db->where('tbl_dokumen.document_label', 'rahasia');
	         $this->db->group_start();
	        $this->db->where('tbl_dokumen.expired_date >', $now);
	        $this->db->or_where('tbl_dokumen.expired_date =', "00-00-00 00:00:00");
	        $this->db->group_end();
	        $this->db->where('tbl_dokumen.upload_by', $id_user);
	        return $this->db->count_all_results();
	    }

	    public function get_by_id($id){
			$this->db->from($this->table);
			$this->db->where('id_document', $id);
			$query = $this->db->get();

			return $query->row();
		}

		public function get_units_by_id($id){
			$this->db->from('tbl_unit_document');
			$this->db->join ( 'tbl_units', 'tbl_units.id_unit = tbl_unit_document.id_unit');
			$this->db->where('tbl_unit_document.id_document', $id);
			$query = $this->db->get();

			return $query->result();
		}

		public function get_file_by_id($id_document){
	    	$this->db->select('file');
	    	$this->db->from('tbl_dokumen');
	    	$this->db->where('id_document', $id_document);
	    	$query = $this->db->get();

	    	return $query->row();
	    }
	}