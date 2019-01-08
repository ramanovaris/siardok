<?php
	class Pages extends CI_Controller{
		public function __construct() {
			
			parent::__construct();
			$this->load->model('pages_model');
			//validasi jika user belum login
		    if($this->session->userdata('logged_in') != TRUE){
		            redirect('login/sign_in');
		    }
		}

		public function index(){
			$this->load->view('templates/header');
			$this->load->view('pages/home');
			$this->load->view('templates/footer');
		}

		function get_documents_internal(){
	        $list = $this->pages_model->get_datatables_internal();
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
	            // $row[] = $field->document_label;
	            $row[] = $field->nama;
	            $row[] = "<a href='javascript:void(0);' class='btn-primary btn-xs' onclick='view_units(".$field->id_document.")' title='View Unit Documents' data-toggle='tooltip' data-placement='bottom'><i class='glyphicon glyphicon-eye-open'></i></a>";
	            $row[] = "<a href='javascript:void(0);' class='btn-primary btn-xs' onclick='view_file(".$field->id_document.")' title='View File' data-toggle='tooltip' data-placement='bottom'><i class='glyphicon glyphicon-eye-open'></i></a>";
	        	
	            $data[] = $row;
	        }
	 
	        $output = array(
	            "draw" => $_POST['draw'],
	            "recordsTotal" => $this->pages_model->count_all_internal(),
	            "recordsFiltered" => $this->pages_model->count_filtered_internal(),
	            "data" => $data,
	        );
	        //output dalam format JSON
	        echo json_encode($output);
	    }

		function get_documents_umum() {
		    $list = $this->pages_model->get_datatables_umum();
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
	            // $row[] = $field->document_label;
	            $row[] = $field->nama;
	            $row[] = "<a href='javascript:void(0);' class='btn-primary btn-xs' onclick='view_file(".$field->id_document.")' title='View File' data-toggle='tooltip' data-placement='bottom'><i class='glyphicon glyphicon-eye-open'></i></a>";
	        	
	            $data[] = $row;
	        }
	 
	        $output = array(
	            "draw" => $_POST['draw'],
	            "recordsTotal" => $this->pages_model->count_all_umum(),
	            "recordsFiltered" => $this->pages_model->count_filtered_umum(),
	            "data" => $data,
	        );
	        //output dalam format JSON
	        echo json_encode($output);
		}

		function get_documents_rahasia() {
		    $list = $this->pages_model->get_datatables_rahasia();
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
	            // $row[] = $field->document_label;
	            $row[] = $field->nama;
	            $row[] = "<a href='javascript:void(0);' class='btn-primary btn-xs' onclick='view_file(".$field->id_document.")' title='View File' data-toggle='tooltip' data-placement='bottom'><i class='glyphicon glyphicon-eye-open'></i></a>";
	        	
	            $data[] = $row;
	        }
	 
	        $output = array(
	            "draw" => $_POST['draw'],
	            "recordsTotal" => $this->pages_model->count_all_rahasia(),
	            "recordsFiltered" => $this->pages_model->count_filtered_rahasia(),
	            "data" => $data,
	        );
	        //output dalam format JSON
	        echo json_encode($output);
		}

		public function view_units($id){
			$unit = $this->pages_model->get_units_by_id($id);
			echo json_encode($unit);
		}

		public function view_file($id_document){
	    	$data = $this->pages_model->get_file_by_id($id_document);
	    	echo json_encode($data);
	    }
	}