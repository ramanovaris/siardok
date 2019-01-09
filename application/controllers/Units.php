<?php
	class Units extends CI_Controller{
		public function __construct() {
			
			parent::__construct();
			$this->load->model('unit_model');
			$this->load->model('view_member_model');
			//validasi jika user belum login
		    if($this->session->userdata('logged_in') != TRUE){
		            redirect('login/sign_in');
		    }
		}

		public function index(){
			if($this->session->userdata('level')=='Admin' || $this->session->userdata('level')=='SuperAdmin'){
			$this->load->view('templates/header');
			$this->load->view('units/index');
			$this->load->view('templates/footer');
			} else {
			 	show_404();
			 }
		}

		function get_data_unit(){
	        $list = $this->unit_model->get_datatables();
	        $data = array();
	        $no = $_POST['start'];
	        foreach ($list as $field) {
	            $no++;
	            $row = array();
	            //$row[] = $no;
	            $row[] = $field->nama_unit;
	            $row[] = "<a href='javascript:void(0);' class='btn-primary btn-xs' onclick='view_member(".$field->id_unit.")' title='View Members' data-toggle='tooltip' data-placement='bottom'><i class='glyphicon glyphicon-eye-open'></i></a>";
	        	$row[] = "<a href='javascript:void(0);' class='btn-warning btn-xs' onclick='edit_unit(".$field->id_unit.")' title='Edit Unit' data-toggle='tooltip' data-placement='bottom'><i class='glyphicon glyphicon-pencil'></i></a>  <a href='javascript:void(0);' class='btn-danger btn-xs' onclick='delete_modal(".$field->id_unit.")' title='Delete Unit' data-toggle='tooltip' data-placement='bottom'><i class='glyphicon glyphicon-trash'></i></a>";
	        	
	            $data[] = $row;
	        }
	 
	        $output = array(
	            "draw" => $_POST['draw'],
	            "recordsTotal" => $this->unit_model->count_all(),
	            "recordsFiltered" => $this->unit_model->count_filtered(),
	            "data" => $data,
	        );
	        //output dalam format JSON
	        echo json_encode($output);
	    }

	    function get_data_member($id){
	        $list = $this->view_member_model->get_datatables($id);
	        $data = array();
	        $no = $_POST['start'];
	        foreach ($list as $field) {
	            $no++;
	            $row = array();
	            //$row[] = $no;
	            $row[] = $field->nama;
	            $row[] = $field->nama_unit;
	            if ($this->session->userdata('level')=='SuperAdmin') {
	            	$row[] = "<a href='javascript:void(0);' class='btn-danger btn-xs' onclick='delete_modal(".$field->id_unit_member.")' title='Delete Member' data-toggle='tooltip' data-placement='bottom'><i class='glyphicon glyphicon-trash'></i></a>";
	            }
	            elseif ($this->session->userdata('level')=='Admin') {
	            	if ($this->session->userdata('id_user') == $field->id_user) {
	            		$row[] = "<a href='javascript:void(0);' class='btn-danger btn-xs' onclick='delete_modal(".$field->id_unit_member.")' title='Delete Member' data-toggle='tooltip' data-placement='bottom'><i class='glyphicon glyphicon-trash'></i></a>";
	            	}
	            	elseif ($field->level == "User") {
	            		$row[] = "<a href='javascript:void(0);' class='btn-danger btn-xs' onclick='delete_modal(".$field->id_unit_member.")' title='Delete Member' data-toggle='tooltip' data-placement='bottom'><i class='glyphicon glyphicon-trash'></i></a>";
	            	}
	            	elseif ($field->level == "Admin") {
	            		$row[] = "<a href='javascript:void(0);' class='btn-danger btn-xs' onclick='delete_modal(".$field->id_unit_member.")' title='Delete Member' data-toggle='tooltip' data-placement='bottom'><i class='glyphicon glyphicon-trash'></i></a>";
	            	}
	            	$row[] = "";
	            }
	        	
	            $data[] = $row;
	        }
	 
	        $output = array(
	            "draw" => $_POST['draw'],
	            "recordsTotal" => $this->view_member_model->count_all_view_member($id),
	            "recordsFiltered" => $this->view_member_model->count_filtered($id),
	            "data" => $data,
	        );
	        //output dalam format JSON
	        echo json_encode($output);
	    }

		public function addUnit(){
		//	$this->_validate();

			$data = array(
				'nama_unit' => $this->input->post('txtUnitName'), 
			);

			$data['nama_unit'] = preg_replace('/[^ \w-.]/', '', trim($data['nama_unit']));
			
			$insert	= $this->unit_model->addUnit($data);
		}

		public function delete_unit($id){
			$this->unit_model->delete_by_id($id);
			echo json_encode(array("status" => true));
		}	

		public function ajax_edit($id){
			
			$data = $this->unit_model->get_by_id($id);
			echo json_encode($data);
		}

		public function unit_update() {
			
			$data = array(
				'nama_unit' => $this->input->post('txtUnitName'), 
			);
			$this->unit_model->unit_update(array('id_unit' => $this->input->post('id_unit')), $data);

			echo json_encode(array("status" => true));
		}

		public function view_member(){
			$this->load->view('templates/header');
			$this->load->view('units/view');
			$this->load->view('templates/footer');
		}

		public function list_member($id){
			$data = $this->unit_model->get_user_except($id);

			echo json_encode($data);
		}

		public function list_member_admin($id){
			$data = $this->unit_model->get_user_except_admin($id);

			echo json_encode($data);
		}

		public function delete_member($id){
			$this->unit_model->delete_by_id_user($id);
			echo json_encode(array("status" => true));
		}		

		public function addMember($id){

			$member_list = $this->input->post('user_id');
			foreach ($member_list as $member) {
				$data = array(
					'id_unit' => $id,
					'id_user' => $member
				);
				$this->unit_model->addMember($data);
			}
			echo json_encode(array("status" => true));
		}

		//Cek Nama Unit kalo ada yang sama
		public function cekNamaUnit(){
			$data['nama_unit'] = preg_replace('/[^ \w-.]/', '', trim($_POST['nama_unit']));

			if($this->unit_model->getNamaUnit($data['nama_unit'])){
				echo 'taken';
			}else {
				echo 'not_taken';
			}
		}

		public function get_name_unit_for_delete($id_unit){
			$data = $this->unit_model->get_name_unit_for_delete($id_unit);
	    	echo json_encode($data);
		}

		public function get_name_member_for_delete($id_unit){
			$data = $this->unit_model->get_name_member_for_delete($id_unit);
	    	echo json_encode($data);
		}
	}