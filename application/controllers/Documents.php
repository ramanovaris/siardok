<?php
	class Documents extends CI_Controller{
		
		public function __construct() {
			
			parent::__construct();
			$this->load->model('documents_model');
			//validasi jika user belum login
		    if($this->session->userdata('logged_in') != TRUE){
		            redirect('login/sign_in');
		    }
		}

		public function index(){

			$data['units'] = $this->documents_model->get_tbl_units();

			$this->load->view('templates/header');
			$this->load->view('documents/index', $data);
			$this->load->view('templates/footer');
		}

		function get_data_documents(){
	        $list = $this->documents_model->get_datatables();
	        $data = array();
	        $no = $_POST['start'];
	        foreach ($list as $field) {
	            $no++;
	            $row = array();
	            //$row[] = $no;
	            $row[] = $field->no_document;
	            $row[] = $field->name_document;
	            $row[] = $field->upload_date;
	            $row[] = $field->document_date;
	            $row[] = $field->expired_date;
	            $row[] = $field->document_label;
	            $row[] = $field->versi;
	            if ($field->document_label == "umum" || $field->document_label == "rahasia"){
	            	$row[] = "<a href='javascript:void(0);' class='btn-primary btn-xs' onclick='view_file(".$field->id_document.")' title='View File' data-toggle='tooltip' data-placement='bottom'><i class='glyphicon glyphicon-eye-open'></i></a>";
		            $row[] = "";
		            $row[] = "<a href='javascript:void(0);' class='btn-primary btn-xs' onclick='view_history(".$field->id_document.")' title='View History Documents' data-toggle='tooltip' data-placement='bottom'><i class='glyphicon glyphicon-eye-open'></i></a>";
		        	$row[] = "<a href='javascript:void(0);' class='btn-warning btn-xs' onclick='edit_document(".$field->id_document.")' title='Edit Document' data-toggle='tooltip' data-placement='bottom'><i class='glyphicon glyphicon-pencil'></i></a>  <a href='javascript:void(0);' class='btn-danger btn-xs' onclick='delete_modal(".$field->id_document.")' title='Delete Document' data-toggle='tooltip' data-placement='bottom'><i class='glyphicon glyphicon-trash'></i></a>";
	            }
	            else{
	            	$row[] = "<a href='javascript:void(0);' class='btn-primary btn-xs' onclick='view_file(".$field->id_document.")' title='View File' data-toggle='tooltip' data-placement='bottom'><i class='glyphicon glyphicon-eye-open'></i></a>";
		            $row[] = "<a href='javascript:void(0);' class='btn-primary btn-xs' onclick='view_units(".$field->id_document.")' title='View Unit Documents' data-toggle='tooltip' data-placement='bottom'><i class='glyphicon glyphicon-eye-open'></i></a>";
		            $row[] = "<a href='javascript:void(0);' class='btn-primary btn-xs' onclick='view_history(".$field->id_document.")' title='View History Documents' data-toggle='tooltip' data-placement='bottom'><i class='glyphicon glyphicon-eye-open'></i></a>";
		        	$row[] = "<a href='javascript:void(0);' class='btn-warning btn-xs' onclick='edit_document(".$field->id_document.")' title='Edit Document' data-toggle='tooltip' data-placement='bottom'><i class='glyphicon glyphicon-pencil'></i></a>  <a href='javascript:void(0);' class='btn-danger btn-xs' onclick='delete_modal(".$field->id_document.")' title='Delete Document' data-toggle='tooltip' data-placement='bottom'><i class='glyphicon glyphicon-trash'></i></a>  <a href='javascript:void(0);' class='btn-success btn-xs' id='send_document' onclick='send_document_modal(".$field->id_document.")' title='Broadcast Document' data-toggle='tooltip' data-placement='bottom'><i class='glyphicon glyphicon-send'></i></a>";
	            }
	            $data[] = $row;
	        }
	 
	        $output = array(
	            "draw" => $_POST['draw'],
	            "recordsTotal" => $this->documents_model->count_all(),
	            "recordsFiltered" => $this->documents_model->count_filtered(),
	            "data" => $data,
	        );
	        //output dalam format JSON
	        echo json_encode($output);
	    }

	    public function ajax_edit($id){
	        $data = $this->documents_model->get_document_by_id($id);
	        if ($data['document_label'] == "internal") {
	        	$data2 = $this->documents_model->get_document_interal_by_id($id);
	        	echo json_encode($data2);
	        }
	        else{
	        	$data3 = $this->documents_model->get_document_by_id_no_units($id);
	        	echo json_encode($data3);
	        }
	    }

	    public function ajax_add(){
	    	// date_default_timezone_set('Asia/Jakarta');
	    	$now = date("Y-m-d H:i:s");
	        $data = array(
	                'no_document' => $this->input->post('txtNoDokumen'), 
			        'name_document' => $this->input->post('txtNamaDokumen'),
			        'document_date' => $this->input->post('txtTanggalDokumen'),
			       	'expired_date' => $this->input->post('txtKadaluarsaDokumen'),
			        'document_label' => $this->input->post('txtLabelDokumen'),
			        'upload_by' => $this->session->userdata('id_user'),
			        'upload_date' => $now,
			        'versi' => $this->input->post('txtVersionDokumen')
	            );

	        $data['no_document'] = preg_replace('/[^ \w-.]/', '', trim($data['no_document']));
			$data['name_document'] = preg_replace('/[^ \w-.]/', '', trim($data['name_document']));
			$data['versi'] = preg_replace('/[^ 0-9.]/', '', trim($data['versi']));
	 
	        if(!empty($_FILES['file']['name']))
	        {
	            $upload = $this->_do_upload();
	            $data['file'] = $upload;
	        }

	       	$insert['id_document'] = $this->documents_model->save($data);

	        $upload_date = $this->documents_model->get_upload_date_by_id($insert['id_document']);
	       	$data2 = array(
	                'id_document' => $insert['id_document'],
	                'no_document' => $this->input->post('txtNoDokumen'), 
			        'name_document' => $this->input->post('txtNamaDokumen'),
			        'upload_date' => $upload_date,
			        'document_date' => $this->input->post('txtTanggalDokumen'),
			       	'expired_date' => $this->input->post('txtKadaluarsaDokumen'),
			        'document_label' => $this->input->post('txtLabelDokumen'),
			        'upload_date' => $now,
			        'upload_by' => $this->session->userdata('id_user'),
			        'file' => $data['file'],
			        'versi' => $this->input->post('txtVersionDokumen')
	        );

	        $data2['no_document'] = preg_replace('/[^ \w-.]/', '', trim($data2['no_document']));
			$data2['name_document'] = preg_replace('/[^ \w-.]/', '', trim($data2['name_document']));
			$data2['versi'] = preg_replace('/[^ 0-9.]/', '', trim($data2['versi']));
	       	
	       	$this->documents_model->save_history($data2);

	       	$cek = $this->input->post('txtUnitDokumen');
	       	if (!empty($cek)) {
		 		$unit_lists = $this->input->post('txtUnitDokumen');
		 		foreach ($unit_lists as $units) {
					$data2 = array(
						'id_document' => $insert['id_document'],
						'id_unit' => $units
					);
					$last_id = $this->documents_model->add_mapping_documents($data2);
				}
			}

			$checked = $this->input->post('BroadcastId');
			if (isset($checked) == 'on') {
				$telegram['id_telegram'] = $this->documents_model->get_id_telegram($insert['id_document']);
				$file_name = $this->documents_model->get_file_dokumen($insert['id_document']);
				foreach ($telegram['id_telegram'] as $id => $id_telegram) {
					// $this->documents_model->send_message($id_telegram['id_telegram'], $file_name['file']);
					$this->documents_model->send_message($id_telegram['id_telegram'], $file_name['file'], $file_name['name_document'], $file_name['no_document']);	
				}
			}
	 
	        echo json_encode(array("status" => TRUE));
	    }

	    public function ajax_update(){	       
	       	$now = date("Y-m-d H:i:s");
	        $data = array(
	                'no_document' => $this->input->post('txtNoDokumen'), 
			        'name_document' => $this->input->post('txtNamaDokumen'),
			        'document_date' => $this->input->post('txtTanggalDokumen'),
			        'upload_date' => $now,
			       	'expired_date' => $this->input->post('txtKadaluarsaDokumen'),
			        'document_label' => $this->input->post('txtLabelDokumen'),
			        'versi' => $this->input->post('txtVersionDokumen')
	            );

	        $data['no_document'] = preg_replace('/[^ \w-.]/', '', trim($data['no_document']));
			$data['name_document'] = preg_replace('/[^ \w-.]/', '', trim($data['name_document']));
			$data['versi'] = preg_replace('/[^ 0-9.]/', '', trim($data['versi']));
	 		
	        $data2 = array(
	                'id_document' => $this->input->post('id_document'),
	                'no_document' => $this->input->post('txtNoDokumen'), 
			        'name_document' => $this->input->post('txtNamaDokumen'),
			        'upload_date' => $now,
			        'document_date' => $this->input->post('txtTanggalDokumen'),
			       	'expired_date' => $this->input->post('txtKadaluarsaDokumen'),
			        'document_label' => $this->input->post('txtLabelDokumen'),
			        'upload_by' => $this->session->userdata('id_user'),
			        'versi' => $this->input->post('txtVersionDokumen')
	        );

	        $data2['no_document'] = preg_replace('/[^ \w-.]/', '', trim($data2['no_document']));
			$data2['name_document'] = preg_replace('/[^ \w-.]/', '', trim($data2['name_document']));
			$data2['versi'] = preg_replace('/[^ 0-9.]/', '', trim($data2['versi']));

	        if(!empty($_FILES['file']['name']))
	        {
	            $upload = $this->_do_upload();
	            $data['file'] = $upload;
	            $data2['file'] = $upload;

	            $this->documents_model->save_history($data2);
	        }
	        else{
	        	$id_document = $this->input->post('id_document');
	            $name_file = $this->documents_model->get_name_file_by_id($id_document);
	            $data2['file'] = $name_file;

	            $this->documents_model->delete_history_document($data2['file']);
	        	$this->documents_model->save_history($data2);
	        }        
	 		
	        $this->documents_model->update(array('id_document' => $this->input->post('id_document')), $data);

	        $id = $this->input->post('id_document');

	        $cek = $this->input->post('txtUnitDokumen');
	       	if (!empty($cek)) {
		 		$unit_lists = $this->input->post('txtUnitDokumen');
		 		$this->documents_model->delete_unit_document($id);
		 		foreach ($unit_lists as $units) {
					$data3 = array(
						'id_document' => $this->input->post('id_document'),
						'id_unit' => $units
					);
					$this->documents_model->add_mapping_documents($data3);
				}
			}
	        echo json_encode(array("status" => TRUE));
	    }

	    private function _do_upload(){
	        $config['upload_path']          = 'assets/upload/dokumen/';
	        $config['allowed_types']        = 'gif|jpg|png|pdf|xlsx|docx|doc';
	        // $config['max_size']             = 10000; //set max size allowed in Kilobyte
	        // $config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name
	        $config['file_name']            = date("dmY_His"); //just milisecond timestamp fot unique name
	 
	        $this->load->library('upload', $config);
	 
	        if(!$this->upload->do_upload('file')) //upload and validate
	        {
	            $data['inputerror'][] = 'file';
	            $data['error_string'][] = 'Upload error: '.$this->upload->display_errors('',''); //show ajax error
	            $data['status'] = FALSE;
	            echo json_encode($data);
	            exit();
	        }
	        return $this->upload->data('file_name');
	    }

	    public function delete_document($id){
			$this->documents_model->delete_by_status($id);
			echo json_encode(array("status" => true));
	    }

	    public function send_document($id){
			$telegram['id_telegram'] = $this->documents_model->get_id_telegram($id);
			$file_name = $this->documents_model->get_file_dokumen($id);
			
				if (!empty($telegram['id_telegram'])) {
					foreach ($telegram['id_telegram'] as $id => $id_telegram) {
					$this->documents_model->send_message($id_telegram['id_telegram'], $file_name['file'], $file_name['name_document'], $file_name['no_document']);	
					}
				}
				else {
					alert('Tidak Broadcast');
				}
			echo json_encode(array("status" => true));
	    }
	    
	    public function select_dynamic(){
			$query = $this->db->get('tbl_units')->result();
			echo json_encode($query);
	    }

	    public function view_file($id_document){
	    	$data = $this->documents_model->get_file_by_id($id_document);
	    	echo json_encode($data);
	    }

	    public function view_file_history($id_history){
	    	$data = $this->documents_model->get_file_by_id_history($id_history);
	    	echo json_encode($data);
	    }

	    public function view_units($id){
	    	$unit = $this->documents_model->get_units_by_id($id);
			echo json_encode($unit);
	    }

	    public function view_history($id){
	    	$history = $this->documents_model->get_history_by_id($id);
			echo json_encode($history);
	    }

	    //Cek No Document kalo ada yang sama
		public function cekNoDocuments(){
			$data['no_document'] = preg_replace('/[^ \w-.]/', '', trim($_POST['no_document']));

			if($this->documents_model->getNoDocuments($data['no_document'])){
				echo 'taken';
			}else {
				echo 'not_taken';
			}
		}
	}