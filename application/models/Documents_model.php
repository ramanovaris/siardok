<?php
	class Documents_model extends CI_Model{

		var $table = 'tbl_dokumen';
		var $tbl_unit_document = 'tbl_unit_document';
	    var $column_order = array('no_document','name_document','upload_date','document_date','expired_date','document_label', 'versi'); //field yang ada di table unit
	    var $column_search = array('no_document','name_document','upload_date','document_date','expired_date','document_label', 'versi'); //field yang diizin untuk pencarian 
	    var $order = array('upload_date' => 'desc'); // default order
		
		private $token = '785918748:AAFmDZMCNsgouUDtkDOzAJ1fonziabxwmXk';

	    private function _get_datatables_query(){
	    	$now = date("Y-m-d");
	    	$nama = $this->session->userdata('id_user');

	    	$this->db->from($this->table);
	        $this->db->where('tbl_dokumen.status', 'Aktif');
	       	$this->db->where('tbl_dokumen.upload_by', $nama);
	       	// $this->db->where('tbl_dokumen.expired_date >', $now);
	 
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

	    function get_datatables(){
	        $this->_get_datatables_query();
	        if($_POST['length'] != -1)
	        $this->db->limit($_POST['length'], $_POST['start']);
	    	$this->db->join ( 'user', 'user.id_user = tbl_dokumen.upload_by');
	        $query = $this->db->get();
	        return $query->result();
	    }
	 
	    function count_filtered(){
	        $this->_get_datatables_query();
	        $this->db->join ( 'user', 'user.id_user = tbl_dokumen.upload_by');
	        $query = $this->db->get();
	        return $query->num_rows();
	    }
	 
	    public function count_all(){
	        $now = date("Y-m-d");
	    	$nama = $this->session->userdata('id_user');

	    	$this->db->from($this->table);
	        $this->db->where('tbl_dokumen.status', 'Aktif');
	       	$this->db->where('tbl_dokumen.upload_by', $nama);
	        return $this->db->count_all_results();
	    }

	    public function get_document_by_id_no_units($id){
			$this->db->from('tbl_dokumen');
			$this->db->where('id_document', $id);
			$query = $this->db->get();
			return $query->result();
			// return $query->result_array();
		}

		public function get_by_id($id){
	        $this->db->from('tbl_dokumen');
	        $this->db->where('id_document',$id);
	        $query = $this->db->get();
	 
	        return $query->row();
	    }

		public function get_unit_by_id($id){
			$this->db->select('nama_unit');
			$this->db->from('tbl_unit_document');
			$this->db->join ( 'tbl_dokumen', 'tbl_dokumen.id_document = tbl_unit_document.id_document');
			$this->db->join ( 'tbl_units', 'tbl_units.id_unit = tbl_unit_document.id_unit');
			$this->db->where('tbl_unit_document.id_document', $id);
			$query = $this->db->get();
			return $query->result();
			// return $query->result_array();
		}

		public function get_document_by_id($id){
			$this->db->from('tbl_dokumen');
			$this->db->join ( 'tbl_unit_document', 'tbl_unit_document.id_document = tbl_dokumen.id_document');
			$this->db->join ( 'tbl_units', 'tbl_units.id_unit = tbl_unit_document.id_unit');
			$this->db->where('tbl_dokumen.id_document', $id);
			$query = $this->db->get();
			// return $query->result();
			return $query->row_array();
			// return $query->result_array();
		}

		public function get_document_interal_by_id($id){
			// $this->db->select('tbl_dokumen.id_document, tbl_dokumen.no_document, tbl_dokumen.name_document, tbl_dokumen.upload_date, tbl_dokumen.document_date, tbl_dokumen.expired_date, tbl_dokumen.status, tbl_dokumen.document_label, tbl_dokumen.upload_by, tbl_dokumen.file, tbl_unit_document.id_document, tbl_unit_document.id_unit_document, tbl_unit_document.id_unit, tbl_units.id_unit, tbl_units.nama_unit');
			$this->db->from('tbl_dokumen');
			$this->db->join ( 'tbl_unit_document', 'tbl_unit_document.id_document = tbl_dokumen.id_document');
			$this->db->join ( 'tbl_units', 'tbl_units.id_unit = tbl_unit_document.id_unit');
			$this->db->where('tbl_dokumen.id_document', $id);
			$query = $this->db->get();
			return $query->result_array();
		}

		public function update($where, $data){
	        $this->db->update($this->table, $data, $where);
	        return $this->db->affected_rows();
	    }

    	public function delete_by_status($id){

			$data = array(
				'status' => 'Inactive', 
			);

			$this->db->where('id_document', $id);
			$this->db->update('tbl_dokumen', $data);
		}

		public function get_tbl_units(){
			$this->db->from('tbl_units');
			$query = $this->db->get();
			return $query->result();
		}

		public function save($data){
		    $this->db->insert($this->table, $data);
		    return $this->db->insert_id();
		}

		public function save_history($data2){
		    $this->db->insert('tbl_history_document', $data2);
		    return $this->db->insert_id();
		}

		public function add_mapping_documents($data3){
			$this->db->insert($this->tbl_unit_document, $data3);
		    return $this->db->insert_id();
		}

		public function update_mapping_documents($where, $data2){
			$this->db->update($this->tbl_unit_document, $data2, $where);
	        // return $this->db->affected_rows();
		}

		public function delete_unit_document($id){
			$this->db->where('id_document', $id);
			$this->db->delete('tbl_unit_document');
		}

		public function delete_history_document($file){
			$this->db->where('file', $file);
			$this->db->delete('tbl_history_document');
		}

		public function get_id_telegram($id_document) {
			$sql = "SELECT id_telegram FROM user INNER JOIN tbl_units_member ON tbl_units_member.id_user=user.id_user WHERE tbl_units_member.id_unit IN (SELECT tbl_unit_document.id_unit FROM tbl_dokumen INNER JOIN tbl_unit_document ON tbl_unit_document.id_document=tbl_dokumen.id_document WHERE tbl_dokumen.id_document = ".$id_document.") GROUP BY user.id_telegram";

			$query = $this->db->query($sql);
			return $query->result_array();
    	}

     	public function get_file_dokumen($id) {
			// $this->db->select('file');
			$this->db->select('file, name_document, no_document');
			$this->db->from('tbl_dokumen');
			$this->db->where('id_document', $id);
			$query = $this->db->get();
			// return $query->row()->file;
			return $query->row_array();
    	}

    	public function send_message($telegram, $file_name, $name_document, $no_document){
	        $telegram_api = "https://api.telegram.org/bot".$this->token;
			$document = new CURLFile(realpath("assets/upload/dokumen/".$file_name)); //first parameter is YOUR IMAGE path
			$post_fields = array(
				'chat_id'   => $telegram,
			    'caption' => "Nama Dokumen: ".$name_document,
			    'document'     => $document
			);

			$ch = curl_init($telegram_api.'/sendDocument');
		    curl_setopt($ch, CURLOPT_HEADER, false);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		    curl_setopt($ch, CURLOPT_POST, 1);
		    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
		    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		    $result = curl_exec($ch);
		    curl_close($ch);
	    }
	    
	    public function get_file_by_id($id_document){
	    	$this->db->select('file');
	    	$this->db->from('tbl_dokumen');
	    	$this->db->where('id_document', $id_document);
	    	$query = $this->db->get();

	    	return $query->row();
	    }

	    public function get_file_by_id_history($id_history){
	    	$this->db->select('file');
	    	$this->db->from('tbl_history_document');
	    	$this->db->where('id_history', $id_history);
	    	$query = $this->db->get();

	    	return $query->row();
	    }

	    public function get_name_file_by_id($id_document){
	    	$this->db->select('file');
	    	$this->db->from('tbl_dokumen');
	    	$this->db->where('id_document', $id_document);
	    	$query = $this->db->get();

	    	return $query->row()->file;
	    }

	    public function get_units_by_id($id){
			$this->db->from('tbl_unit_document');
			$this->db->join ( 'tbl_units', 'tbl_units.id_unit = tbl_unit_document.id_unit');
			$this->db->where('tbl_unit_document.id_document', $id);
			$query = $this->db->get();

			return $query->result();
		}

		public function get_upload_date_by_id($id_document){
	    	$this->db->select('upload_date');
	    	$this->db->from('tbl_dokumen');
	    	$this->db->where('id_document', $id_document);
	    	$query = $this->db->get();

	    	return $query->row()->upload_date;
	    }

	    public function get_versi_by_id($id_document){
	    	$this->db->select('versi');
	    	$this->db->from('tbl_dokumen');
	    	$this->db->where('id_document', $id_document);
	    	$query = $this->db->get();

	    	return $query->row()->versi;
	    } 

	    public function get_history_by_id($id){
			$this->db->from('tbl_history_document');
			$this->db->where('id_document', $id);
			$this->db->order_by("upload_date", "desc");
			$query = $this->db->get();

			return $query->result();
		}  

		public function getNoDocuments($no_document){
			$this->db->where('no_document' , $no_document);
			$query = $this->db->get('tbl_dokumen');

			if($query->num_rows()>0){
				return true;
			} else {
				return false;
			}
		}

		public function get_name_document_for_delete($id_document){
 			$this->db->select('name_document');
	    	$this->db->from('tbl_dokumen');
	    	$this->db->where('id_document', $id_document);
	    	$query = $this->db->get();

	    	return $query->row_array();
 		}

 		public function get_name_document_for_broadcast($id_document){
 			$this->db->select('name_document');
	    	$this->db->from('tbl_dokumen');
	    	$this->db->where('id_document', $id_document);
	    	$query = $this->db->get();

	    	return $query->row_array();
 		}

 		public function select_unit_by_status(){
	    	$this->db->from('tbl_units');
	    	$this->db->where('status', 'Active');
	    	$query = $this->db->get();

	    	return $query->result();
 		}
	}