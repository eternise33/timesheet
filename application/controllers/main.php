<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	/*
		This project is a buy and sell project :-)
		Created by Lawrence Santos

	*/	

class Main extends CI_Controller {

	
	public function index(){
		$this->v_login();
	}
	
	public function v_login(){
		$this->load->view('view_login');
	}
	
	public function v_admin_page(){
		if ($this->session->userdata('is_logged_in')){
			
			$this->load->view('view_main_admin');
		}else{
			redirect('main/index');
		}
	
	}
	
	public function v_delete_user(){
		if ($this->session->userdata('is_logged_in')){
			
			$this->load->view('views_delete');
		}else{
			redirect('main/index');
		}
	
	}
	
	public function v_reset_password(){
		if ($this->session->userdata('is_logged_in')){
			
			$this->load->view('views_reset');
		}else{
			redirect('main/index');
		}
	
	}
	
	
	public function v_add_users(){
		if ($this->session->userdata('is_logged_in')){
			
			$this->load->view('view_add_users');
		}else{
			redirect('main/index');
		}
	}
	
	public function v_reports(){
		if ($this->session->userdata('is_logged_in')){
			$this->load->view('views_reports');
		}else{
			redirect('main/index');
		}
	}
	
	
	
	public function v_nonadmin_page(){
		if ($this->session->userdata('is_logged_in')){
			
			$this->load->view('view_main');
		}else{
			redirect('main/index');
		}
	
	}
	
	
	public function change_password(){
		$this->load->view('view_update_password');
	
	}
	
	public function reset_password(){
	
		$this->load->model('m_timekeep_model');
		if($this->m_timekeep_model->reset_password()){
			echo ("<SCRIPT LANGUAGE='JavaScript'>
				window.alert('Password has been reset')
				window.location.href='v_admin_page';
			</SCRIPT>");
			
		}else{
			echo ("<SCRIPT LANGUAGE='JavaScript'>
				window.alert('An Error has occured. Please Try Again Later or Contact Website Administrator')
				window.location.href='v_reset_password';
			</SCRIPT>");
		}
		
	}
	
	
	public function delete_user(){
	
		$this->load->model('m_timekeep_model');
		if($this->m_timekeep_model->delete_user()){
			echo ("<SCRIPT LANGUAGE='JavaScript'>
				window.alert('User has been deleted')
				window.location.href='v_admin_page';
			</SCRIPT>");
			
		}else{
			echo ("<SCRIPT LANGUAGE='JavaScript'>
				window.alert('An Error has occured. Please Try Again Later or Contact Website Administrator')
				window.location.href='v_reset_password';
			</SCRIPT>");
		}
		
	}
	
	
	
	
	
	
	public function validate_password(){
		$this->load->library('form_validation');


		
		$this->form_validation->set_rules('new_password', 'Password', 'required|trim|min_length[6]');
		$this->form_validation->set_rules('ver_password', 'Password Verification', 'required|trim|min_length[6]|max_length[16]|matches[new_password]');
		
		
		if($this->form_validation->run()){
			$this->load->model('m_timekeep_model');
			if($this->m_timekeep_model->update_password()){
				redirect('main/v_nonadmin_page');
			}else{
				echo ("<SCRIPT LANGUAGE='JavaScript'>
				window.alert('An Error has occured. Please Try Again Later or Contact Website Administrator')
				window.location.href='index';
			</SCRIPT>");
			}
		
		
		}else{
			$this->load->view('view_update_password');
		
		}
		
		
	}
	
	public function verification() {
		$username = $this->session->userdata('username');
		$this->db->where('username', $username);
		$query = $this->db->get('users');
		foreach($query->result() as $row){}
		$verified = $row->verified;
		
		if($verified == 0){
			redirect('main/change_password');
		}else{
		
			redirect('main/v_nonadmin_page');
		}

	
	}
	
	
	
	// the following code validates the login credential provided
	public function validate_login(){
		$this->load->library('form_validation');
		
		// gets the data entered by the user of the system
		$username = $this->input->post('username');
		
		$this->form_validation->set_rules('username', 'Username', 'required|trim|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'required|trim');
		
		if($this->form_validation->run()){
			// this will load up the model for server validation
			$this->load->model('m_timekeep_model');
			
			if($this->m_timekeep_model->login_check()){
				// this part creates the session for the user in case its a successful login
				$data1 = array(
					'username'=> $username,
					'is_logged_in'=> 1
				);
				$this->session->set_userdata($data1);
				
				// im creating two separate views for admin and ordinary users
				if($username == "admin"){
					redirect('main/v_admin_page');
				}else{
					redirect('main/verification');
				}
			
			}else{
			
				$this->load->view('view_login');
			
			
			}
			
		}else{
			// this will load up the same login screen for invalid credentials
			echo ("<SCRIPT LANGUAGE='JavaScript'>
				window.alert('Invalid Username or Password')
				window.location.href='index';
			</SCRIPT>");
			

		}
	}
	
	
	
	public function validate_add_user(){
		$this->load->library('form_validation');
	
		$this->form_validation->set_rules('add_username', 'Username', 'required|trim|xss_clean');
		
		if($this->form_validation->run()){
			$this->load->model('m_timekeep_model');
			
			if($this->m_timekeep_model->add_user()){
			
				redirect('main/v_add_users');
	
			}else{
				echo "Behlat";
			}
		

		
		}
		
		
	
	}
	
	
	

	
	public function clock_in(){
		$this->load->model('m_timekeep_model');
		
		if($this->m_timekeep_model->time_in()){
			echo ("<SCRIPT LANGUAGE='JavaScript'>
				window.alert('You have successfully Time In')
				window.location.href='v_nonadmin_page';
			</SCRIPT>");
		
	
		}else{
			echo ("<SCRIPT LANGUAGE='JavaScript'>
				window.alert('An error has occured. Please try again later or Contact Website Administrator')
				window.location.href='v_nonadmin_page';
			</SCRIPT>");
		}
		
	
	}
	
	public function lunch_out(){
		$this->load->model('m_timekeep_model');
		
		
		if($this->m_timekeep_model->lunch_out()){
			
			echo ("<SCRIPT LANGUAGE='JavaScript'>
				window.alert('Enjoy your Lunch')
				window.location.href='v_nonadmin_page';
			</SCRIPT>");
	
		}else{
			echo ("<SCRIPT LANGUAGE='JavaScript'>
				window.alert('An error has occured. Please try again later or Contact Website Administrator')
				window.location.href='v_nonadmin_page';
			</SCRIPT>");
		}
	}
	

	public function lunch_in(){
		$this->load->model('m_timekeep_model');
		
		if($this->m_timekeep_model->lunch_in()){
			echo ("<SCRIPT LANGUAGE='JavaScript'>
				window.alert('You have successfully Lunch In')
				window.location.href='v_nonadmin_page';
			</SCRIPT>");
	
		}else{
			echo ("<SCRIPT LANGUAGE='JavaScript'>
				window.alert('An error has occured. Please try again later or Contact Website Administrator')
				window.location.href='v_nonadmin_page';
			</SCRIPT>");
			
		}
		

		
	}
	
	public function clock_out(){
		$this->load->model('m_timekeep_model');
		
		if($this->m_timekeep_model->time_out()){
			echo ("<SCRIPT LANGUAGE='JavaScript'>
				window.alert('You have successfully Lunch In')
				window.location.href='v_nonadmin_page';
			</SCRIPT>");
		
	
		}else{
			echo ("<SCRIPT LANGUAGE='JavaScript'>
				window.alert('An error has occured. Please try again later or Contact Website Administrator')
				window.location.href='v_nonadmin_page';
			</SCRIPT>");
		
		}
		
	}
	

	
	
	public function logout(){
		$this->session->sess_destroy();
		redirect('main/index');
	
	}
	
}

