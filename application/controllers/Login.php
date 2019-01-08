<?php
	class Login extends CI_Controller{
		// Login User
		public function sign_in(){
			$data['title'] = "Sign In";

			$this->form_validation->set_rules('txtNIK', 'TxtNIK', 'required');
			
			if($this->form_validation->run() === FALSE){
				$this->load->view('login/index', $data);
			} 
			else {

				// Get Username
				$nik = $this->input->post('txtNIK');

				// Login user
				$user_id = $this->login_model->sign_in($nik);

				if ($user_id) {
					// Create Session
					$user_data = array(
						'id_user' => $user_id,
						'nik' => $nik,
						'logged_in' => true
					);
				
					$this->session->set_userdata($user_data);

					// Set message
					//$this->session->set_flashdata('Masukkan_OTP', 'Silahkan Cek BOT Telegram SIMADOC BOT Untuk Memasukkan OTP');
				} else {
					die('gagal');
					// Set message
					//redirect('login/sign_in');
				}
			}
		}

		public function login_step_one() {
			$this->form_validation->set_rules('txtNIK', 'TxtNIK', 'required');
			if ($this->form_validation->run() == true) {
				$nik = $this->input->post('txtNIK');
				$telegram = $this->login_model->get_id_telegram_by_username($nik);
				$otp = rand(999, 10000);

				while ($this->otp_model->otp_exists($otp)) {
					$otp = rand(999, 10000);
				}

				if (!empty($telegram)) {
					$createOtp = $this->otp_model->save_otp($otp, $telegram['id_user']);
					$this->otp_model->send_message($telegram['id_telegram'], $otp);
					
					// Set message
					$this->session->set_flashdata('masukkan_otp', 'Silahkan Cek BOT Telegram Untuk Memasukkan OTP (SIMADOC BOT)');

					redirect('login/verification');
				}
				else {
					// Set message
					$this->session->set_flashdata('salah_nik', 'Pastikan NIK yang anda masukkan sudah benar', 5);
					redirect('login/sign_in');
				}
			}
		}

		public function verification() {
				//Set Message
				$this->session->set_flashdata('Masukkan_OTP', 'Silahkan Cek BOT Telegram SIMADOC BOT Untuk Memasukkan OTP');
				$this->form_validation->set_rules('txtotp', 'Txtotp', 'required');
				$this->load->view('login/vertifikasi');	
		}

		public function login_step_two() {
			$otp = $this->input->post('txtotp');
			$user = $this->otp_model->get_user_by_otp($otp);

			$check_otp = $this->otp_model->check_otp($otp, $user['id_user']);

			if ($check_otp != NULL) {
				$now = date("Y-m-d H:i:s");
				if ($check_otp['otp_expired'] < $now) {
					$this->otp_model->delete_otp($user['id_user']);
					$this->session->set_flashdata('expired', 'OTP Anda Sudah Tidak Berlaku');
					redirect('login/sign_in');
				}
				else {
					$this->otp_model->delete_otp($user['id_user']);
					$user_data = array(
						'logged_in' => true,
						'nik' => $user['nik'],
						'nama' => $user['nama'],
						'level'=> $user['level'],
						'id_user' => $user['id_user']
					);
					$this->session->set_userdata($user_data);
					redirect('pages');
				}
				$this->otp_model->delete_expired_otp();
			}
			else{
			// Set message
			$this->session->set_flashdata('salah_otp', 'Pastikan OTP yang anda masukkan sudah benar');
			redirect('login/verification');
			}
		}

		// Logout user
		public function sign_out(){
			// Unset user data
			$this->session->unset_userdata('logged_in');
			$this->session->unset_userdata('nik');
			$this->session->unset_userdata('nama_pegawai');
			$this->session->unset_userdata('tipe_users');
			$this->session->unset_userdata('id_user');

			// Set message
			$this->session->set_flashdata('user_loggedout', 'You are now logged out');

			redirect('beranda');
		}
	}