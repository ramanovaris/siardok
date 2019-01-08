<?php
	class Beranda extends CI_Controller{
		public function __construct() {
			
			parent::__construct();
			$this->load->model('beranda_model');
		}

		public function index(){
			$this->load->view('beranda/index');
		}

		function get_data_documents(){
	        $list = $this->beranda_model->get_datatables();
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
	            $row[] = $field->nama;
	            $row[] = "<a href='javascript:void(0);' class='btn-primary btn-xs' onclick='view_file(".$field->id_document.")' title='View File' data-toggle='tooltip' data-placement='bottom'><i class='glyphicon glyphicon-eye-open'></i></a>";
	        	
	            $data[] = $row;
	        }
	 
	        $output = array(
	            "draw" => $_POST['draw'],
	            "recordsTotal" => $this->beranda_model->count_all(),
	            "recordsFiltered" => $this->beranda_model->count_filtered(),
	            "data" => $data,
	        );
	        //output dalam format JSON
	        echo json_encode($output);
	    }

	    public function view_file($id_document){
	    	$data = $this->beranda_model->get_file_by_id($id_document);
	    	echo json_encode($data);
	    }
	}