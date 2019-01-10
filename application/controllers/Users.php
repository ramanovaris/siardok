<?php
	class Users extends CI_Controller{
		public function __construct() {
			
			parent::__construct();
			$this->load->model('user_model');
			$this->load->model('view_units_model');
			//validasi jika user belum login
		    if($this->session->userdata('logged_in') != TRUE){
		            redirect('login/sign_in');
		    }
		}

		public function index(){
			 if($this->session->userdata('level')=='Admin' || $this->session->userdata('level')=='SuperAdmin'){
			 	$this->load->view('templates/header');
				$this->load->view('users/index');
				$this->load->view('templates/footer');
			 } else {
			 	show_404();
			 }
		}

		function get_data_users()
	    {
	    	$list = $this->user_model->get_datatables();
	        $data = array();
	        $no = $_POST['start'];
	        foreach ($list as $field) {
	            $no++;
	            $row = array();
	            //$row[] = $no;
	            $row[] = $field->nama;
	            $row[] = $field->no_ktp;
	            $row[] = $field->nik;
	            $row[] = "<div class='text-center'>
	            			<a href='javascript:void(0);' class='btn-primary btn-xs' onclick='view_file(".$field->id_user.")' title='View Photo' data-toggle='tooltip' data-placement='bottom'><i class='glyphicon glyphicon-eye-open'></i></a>
	            			</div>";
	            $row[] = "<div class='text-center'>
	            			<a href='javascript:void(0);' class='btn-primary btn-xs' onclick='view_file2(".$field->id_user.")' title='View Photo' data-toggle='tooltip' data-placement='bottom'><i class='glyphicon glyphicon-eye-open'></i></a>
	            			</div>";
	            $row[] = $field->no_hp;
	            $row[] = $field->level;
	            $row[] = "<a href='javascript:void(0);' class='btn-primary btn-xs' onclick='view_units(".$field->id_user.")' title='View Units' data-toggle='tooltip' data-placement='bottom'><i class='glyphicon glyphicon-eye-open'></i></a>";
	        	if ($this->session->userdata('level') == 'SuperAdmin' || $field->level == 'User' || $this->session->userdata('id_user') == $field->id_user) {
	        		$row[] = "<a href='javascript:void(0);' class='btn-success btn-xs' onclick='detail_user(".$field->id_user.")' title='Details User' data-toggle='tooltip' data-placement='bottom'><i class='glyphicon glyphicon-info-sign'></i></a> <a href='javascript:void(0);' class='btn-warning btn-xs' onclick='edit_user(".$field->id_user.")' title='Edit User' data-toggle='tooltip' data-placement='bottom'><i class='glyphicon glyphicon-pencil'></i></a> <a href='javascript:void(0);' class='btn-danger btn-xs' onclick='delete_modal(".$field->id_user.")' title='Delete User' data-toggle='tooltip' data-placement='bottom'><i class='glyphicon glyphicon-trash'></i></a>";
	        	}elseif ($this->session->userdata('level') == 'Admin') {
	        		$row[] = "<a href='javascript:void(0);' class='btn-success btn-xs' onclick='detail_user(".$field->id_user.")' title='Details User' data-toggle='tooltip' data-placement='bottom'><i class='glyphicon glyphicon-info-sign'></i></a>";
	        	}
	            $data[] = $row;
	        }
	 
	        $output = array(
	            "draw" => $_POST['draw'],
	            "recordsTotal" => $this->user_model->count_all(),
	            "recordsFiltered" => $this->user_model->count_filtered(),
	            "data" => $data,
	        );
	        //output dalam format JSON
	        echo json_encode($output);
	    }

	    function get_data_unit_member($id)
	    {
	        $list = $this->view_units_model->get_datatables($id);
	        $data = array();
	        $no = $_POST['start'];
	        $id_user = $this->uri->segment(3);
			$cek_level = $this->view_units_model->cek_level($id_user);
	        foreach ($list as $field) {
	            $no++;
	            $row = array();
	            //$row[] = $no;
	            $row[] = $field->nama_unit;
	            $row[] = $field->nama;
	        	if ($this->session->userdata('level')=='SuperAdmin') {
	        		$row[] = "<a href='javascript:void(0);' class='btn-danger btn-xs' onclick='delete_modal(".$field->id_unit_member.")' title='Delete Unit' data-toggle='tooltip' data-placement='bottom'><i class='glyphicon glyphicon-trash'></i></a>";
	        	}
	        	elseif ($this->session->userdata('level')=='Admin') {
	        		if ($this->session->userdata('id_user') == $this->uri->segment(3)) {
	        			$row[] = "<a href='javascript:void(0);' class='btn-danger btn-xs' onclick='delete_modal(".$field->id_unit_member.")' title='Delete Unit' data-toggle='tooltip' data-placement='bottom'><i class='glyphicon glyphicon-trash'></i></a>";
	        		}elseif ($cek_level == "User") {
	        			$row[] = "<a href='javascript:void(0);' class='btn-danger btn-xs' onclick='delete_modal(".$field->id_unit_member.")' title='Delete Unit' data-toggle='tooltip' data-placement='bottom'><i class='glyphicon glyphicon-trash'></i></a>";
	        		}elseif ($cek_level == "Admin") {
	        			$row[] = "<a href='javascript:void(0);' class='btn-danger btn-xs' onclick='delete_modal(".$field->id_unit_member.")' title='Delete Unit' data-toggle='tooltip' data-placement='bottom'><i class='glyphicon glyphicon-trash'></i></a>";
	        		}
	        		$row[] = "";
	        	}
	        	
	            $data[] = $row;
	        }
	 
	        $output = array(
	            "draw" => $_POST['draw'],
	            "recordsTotal" => $this->view_units_model->count_all_view_units($id),
	            "recordsFiltered" => $this->view_units_model->count_filtered($id),
	            "data" => $data,
	        );
	        //output dalam format JSON
	        echo json_encode($output);
	    }

		public function addUser(){

			$data = array(
				'no_ktp' => $this->input->post('no_ktp'), 
				'nama' => $this->input->post('nama'), 
				'instansi' => $this->input->post('instansi'), 
				'posisi' => $this->input->post('posisi'), 
				'no_hp' => $this->input->post('no_hp'), 
				'nik' => $this->input->post('nik'),
				'id_telegram' => $this->input->post('id_telegram'),
				'level' => $this->input->post('level')
			);

			if(!empty($_FILES['userfile']['name']))
	        {
	            $upload = $this->_do_upload_add();
	            $data['foto_ktp'] = $upload;
	        }

	        if(!empty($_FILES['userfile1']['name']))
	        {
	            $upload = $this->_do_upload_add_2();
	            $data['foto_karpeg'] = $upload;
	        }

	        $data['no_ktp'] = preg_replace('/[^ 0-9]/', '', trim($data['no_ktp']));
			$data['nama'] = preg_replace('/[^ \w-.]/', '', trim($data['nama']));
			$data['instansi'] = preg_replace('/[^ \w-.]/', '', trim($data['instansi']));
			$data['posisi'] = preg_replace('/[^ \w-.]/', '', trim($data['posisi']));
			$data['no_hp'] = preg_replace('/[^ 0-9]/', '', trim($data['no_hp']));
			$data['nik'] = preg_replace('/[^ 0-9]/', '', trim($data['nik']));
			$data['id_telegram'] = preg_replace('/[^ 0-9]/', '', trim($data['id_telegram']));

			$insert	= $this->user_model->addUser($data);
			echo json_encode(array("status" => true));
		}

		public function ajax_edit($id_user){
			$data = $this->user_model->get_data_by_id($id_user);
			echo json_encode($data);
		}

		private function _do_upload_add(){
	        $config['upload_path']          = '../simaru/assets/images';
	        // $config['upload_path']          = 'assets/upload/dokumen/';
	        $config['allowed_types']        = 'jpg|png';
	        // $config['max_size']             = 10000; //set max size allowed in Kilobyte
	        // $config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name
	        $config['file_name']            = date("dmY_His"); //just milisecond timestamp fot unique name
	 
	        $this->load->library('upload', $config);
	 
	        if(!$this->upload->do_upload('userfile')) //upload and validate
	        {
	            $data['inputerror'][] = 'file';
	            $data['error_string'][] = 'Upload error: '.$this->upload->display_errors('',''); //show ajax error
	            $data['status'] = FALSE;
	            echo json_encode($data);
	            alert('error');
	            exit();
	        }
	        else
	        {
	        	$data = array('upload_data' => $this->upload->data());
	        }
	        return $this->upload->data('file_name');
	    }

	    private function _do_upload_add_2(){
	        $config['upload_path']          = '../simaru/assets/images';
	        // $config['upload_path']          = 'assets/upload/dokumen/';
	        $config['allowed_types']        = 'jpg|png';
	        // $config['max_size']             = 10000; //set max size allowed in Kilobyte
	        // $config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name
	        $config['file_name']            = date("dmY_His"); //just milisecond timestamp fot unique name
	 
	        $this->load->library('upload', $config);
	 
	        if(!$this->upload->do_upload('userfile1')) //upload and validate
	        {
	            $data['inputerror'][] = 'file';
	            $data['error_string'][] = 'Upload error: '.$this->upload->display_errors('',''); //show ajax error
	            $data['status'] = FALSE;
	            echo json_encode($data);
	            alert('error');
	            exit();
	        }
	        else
	        {
	        	$data = array('upload_data' => $this->upload->data());
	        }
	        return $this->upload->data('file_name');
	    }

		private function _do_upload(){
	        $config['upload_path']          = '../simaru/assets/images';
	        // $config['upload_path']          = 'assets/upload/dokumen/';
	        $config['allowed_types']        = 'jpg|png';
	        // $config['max_size']             = 10000; //set max size allowed in Kilobyte
	        // $config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name
	        $config['file_name']            = date("dmY_His"); //just milisecond timestamp fot unique name
	 
	        $this->load->library('upload', $config);
	 
	        if(!$this->upload->do_upload('userfile_edit')) //upload and validate
	        {
	            $data['inputerror'][] = 'file';
	            $data['error_string'][] = 'Upload error: '.$this->upload->display_errors('',''); //show ajax error
	            $data['status'] = FALSE;
	            echo json_encode($data);
	            alert('error');
	            exit();
	        }
	        else
	        {
	        	$data = array('upload_data' => $this->upload->data());
	        }
	        return $this->upload->data('file_name');
	    }

	    private function _do_upload_2(){
	        $config['upload_path']          = '../simaru/assets/images';
	        // $config['upload_path']          = 'assets/upload/dokumen/';
	        $config['allowed_types']        = 'jpg|png';
	        // $config['max_size']             = 10000; //set max size allowed in Kilobyte
	        // $config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name
	        $config['file_name']            = date("dmY_His"); //just milisecond timestamp fot unique name
	 
	        $this->load->library('upload', $config);
	 
	        if(!$this->upload->do_upload('userfile1_edit')) //upload and validate
	        {
	            $data['inputerror'][] = 'file';
	            $data['error_string'][] = 'Upload error: '.$this->upload->display_errors('',''); //show ajax error
	            $data['status'] = FALSE;
	            echo json_encode($data);
	            alert('error');
	            exit();
	        }
	        else
	        {
	        	$data = array('upload_data' => $this->upload->data());
	        }
	        return $this->upload->data('file_name');
	    }

		public function user_update() {

			if ($this->session->userdata('level')=='SuperAdmin') {
				$data = array(
				'no_ktp' => $this->input->post('no_ktp_edit'), 
				'nama' => $this->input->post('nama_edit'), 
				'instansi' => $this->input->post('instansi_edit'), 
				'posisi' => $this->input->post('posisi_edit'), 
				'no_hp' => $this->input->post('no_hp_edit'), 
				'nik' => $this->input->post('nik_edit'), 
				'id_telegram' => $this->input->post('id_telegram_edit'), 
				'level' => $this->input->post('level_edit'), 
				);
			}
			elseif ($this->session->userdata('level')=='Admin') {
				$data = array(
				'no_ktp' => $this->input->post('no_ktp_edit'), 
				'nama' => $this->input->post('nama_edit'), 
				'instansi' => $this->input->post('instansi_edit'), 
				'posisi' => $this->input->post('posisi_edit'), 
				'no_hp' => $this->input->post('no_hp_edit'), 
				'nik' => $this->input->post('nik_edit'), 
				'id_telegram' => $this->input->post('id_telegram_edit'), 
				);
			}

			if(!empty($_FILES['userfile_edit']['name']))
	        {
	            $upload = $this->_do_upload();
	            $data['foto_ktp'] = $upload;
	        }
	        
	        if(!empty($_FILES['userfile1_edit']['name']))
	        {
	            $upload = $this->_do_upload_2();
	            $data['foto_karpeg'] = $upload;
	        }

			$data['no_ktp'] = preg_replace('/[^ 0-9]/', '', trim($data['no_ktp']));
			$data['nama'] = preg_replace('/[^ \w-.]/', '', trim($data['nama']));
			$data['instansi'] = preg_replace('/[^ \w-.]/', '', trim($data['instansi']));
			$data['posisi'] = preg_replace('/[^ \w-.]/', '', trim($data['posisi']));
			$data['no_hp'] = preg_replace('/[^ 0-9]/', '', trim($data['no_hp']));
			$data['nik'] = preg_replace('/[^ 0-9]/', '', trim($data['nik']));
			$data['id_telegram'] = preg_replace('/[^ 0-9]/', '', trim($data['id_telegram']));

			$this->user_model->user_update(array('id_user' => $this->input->post('id_user_edit')), $data);

			echo json_encode(array("status" => true));
		}

		public function delete_user($id){
			$this->user_model->delete_by_status($id);
			echo json_encode(array("status" => true));
		}

		public function view_units(){
			$this->load->view('templates/header');
			$this->load->view('users/view');
			$this->load->view('templates/footer');
		}

		public function list_unit($id){
			$data = $this->user_model->get_units_except($id);

			echo json_encode($data);
		}

		public function delete_units($id){
			
			$this->user_model->delete_by_id_unit($id);
			echo json_encode(array("status" => true));
		}

		public function addUnits($id){

			$units_list = $this->input->post('id_unit');
			foreach ($units_list as $units) {
				$data = array(
					'id_user' => $id,
					'id_unit' => $units
				);
				$this->user_model->addUnits($data);
			}
			echo json_encode(array("status" => true));
		}
		
		//Cek NIK kalo ada yang sama
		public function cekNIK(){
			if($this->user_model->getNik($_POST['nik'])){
				echo 'taken';
			}else {
				echo 'not_taken';
			}
		}

		//Cek NIK kalo ada yang sama
		public function cekNIK_edit(){
			if($this->user_model->getNik($_POST['nik_edit'])){
				echo 'taken';
			}else {
				echo 'not_taken';
			}
		}

		//Cek no_ktp kalo ada yang sama
		public function cek_no_ktp(){
			if($this->user_model->get_no_ktp($_POST['no_ktp'])){
				echo 'taken';
			}else {
				echo 'not_taken';
			}
		}

		//Cek no_ktp kalo ada yang sama
		public function cek_no_ktp_edit(){
			if($this->user_model->get_no_ktp($_POST['no_ktp_edit'])){
				echo 'taken';
			}else {
				echo 'not_taken';
			}
		}

		//Cek no_hp kalo ada yang sama
		public function cek_no_hp(){
			if($this->user_model->get_no_hp($_POST['no_hp'])){
				echo 'taken';
			}else {
				echo 'not_taken';
			}
		}

		//Cek no_hp kalo ada yang sama
		public function cek_no_hp_edit(){
			if($this->user_model->get_no_hp($_POST['no_hp_edit'])){
				echo 'taken';
			}else {
				echo 'not_taken';
			}
		}

		//Cek id_telegram kalo ada yang sama
		public function cek_id_telegram(){
			if($this->user_model->get_id_telegram($_POST['id_telegram'])){
				echo 'taken';
			}else {
				echo 'not_taken';
			}
		}

		//Cek id_telegram kalo ada yang sama
		public function cek_id_telegram_edit(){
			if($this->user_model->get_id_telegram($_POST['id_telegram_edit'])){
				echo 'taken';
			}else {
				echo 'not_taken';
			}
		}

		public function view_file($id_user){
	    	$data = $this->user_model->get_file_by_id($id_user);
	    	echo json_encode($data);
	    }

	    public function detail_user($id_user){
	    	$data = $this->user_model->get_detail_by_id($id_user);
	    	echo "<tr>
					<td>".$data['instansi']."</td>
					<td>".$data['posisi']."</td>
				  </tr>";
	    }

	    public function get_name_for_delete($id_user){
	    	$data = $this->user_model->get_name_for_delete($id_user);
	    	echo json_encode($data);
	    }

	    public function get_unit_for_delete($id_unit){
	    	$data = $this->user_model->get_unit_for_delete($id_unit);
	    	echo json_encode($data);
	    }
	}