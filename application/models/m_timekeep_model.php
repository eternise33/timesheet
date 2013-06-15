	<?php
		ini_set('date.timezone', 'Asia/Manila');
	
	
	class M_timekeep_model extends CI_Model {
		
		
		
		public function login_check(){

			$username = $this->input->post('username');
			$password =  $this->input->post('password');
			$username =  mysql_real_escape_string($username);
			$password =  mysql_real_escape_string($password);
			$password = sha1($password);
			$this->db->where('username', $username);
			$this->db->where('password', $password);
			
			$result = $this->db->get('users');
			
			if($result->num_rows() == 1){
				return true;
			}else{
				return false;
			}
		}
		
		public function add_user(){
			$username = $this->input->post('add_username');
			$username =  mysql_real_escape_string($username);
			$password = "aiming";
			$password = sha1($password);
			$firstname = $this->input->post('fname');
			$firstname = mysql_real_escape_string($firstname);
			$firstname = ucwords(strtolower($firstname));
			$lastname = $this->input->post('lname');
			$lastname = mysql_real_escape_string($lastname);
			$lastname = ucwords(strtolower($lastname));
			
			$this->db->where('username', $username);
			$result = $this->db->get('users');
			
			if($result->num_rows() == 1){
				//this means that the username is not available for use
				return false;
			}else{
				$data = array(
				'username'=> $username,
				'password'=> $password,
				'first_name'=> $firstname,
				'last_name'=> $lastname
				);
				
				$query = $this->db->insert('users', $data);
				
				if($query == true){
					
					$script = "CREATE TABLE IF NOT EXISTS $username (
								  `entry_id` int(11) NOT NULL AUTO_INCREMENT,
								  `date` date ,
								  `clock_in` varchar(30) ,
								  `lunch_out` varchar(30),
								  `lunch_in` varchar(30) ,
								  `clock_out` varchar(30) ,
								  PRIMARY KEY (`entry_id`)
								);";
				
				}
				
				$this->db->query($script );
				return true;
				
			}
		
		}
		
		
		public function update_password(){
			$new_pass = $this->input->post('new_password');
			$new_pass = mysql_real_escape_string($new_pass);
			$new_pass = sha1($new_pass);
			$verified = 1;
			$data = array(
				'password'=> $new_pass,
				'verified'=> $verified
				);
			$username = $this->session->userdata('username');
			
			$this->db->where('username', $username);
			$query3 = $this->db->update('users', $data);
			
			if($query3 == true){
				return true;
			}else{
				return false;
			}
			
			
		}
		
		
		
		public function reset_password(){
			error_reporting(0);
			$username_toreset = $this->input->post('who');
			$default_password = "aiming";
			$default_password = sha1($default_password);
			$verified = 0;
			
			// creating a loop to check the array and see who are selected for password reset
			// first is to update the counter on the users and then change the password to the default password
		
			$data = array(
				'password'=> $default_password,	
				'verified'=> $verified
				);
					
			$this->db->where('username', $username_toreset);
			$query = $this->db->update('users', $data);
		
			
			if($query){
				return true;
			}else{
				return false;
			}	
		
		
		}
		
		
		public function delete_user(){
			error_reporting(0);
			$username_todelete = $this->input->post('who');		
			// creating a loop to check the array and see who are selected for password reset
			// first is to update the counter on the users and then change the password to the default password
			
			$this->db->where('username', $username_todelete);
			$query = $this->db->delete('users');
			$script = "Drop table $username_todelete;";
			
			if($query){
				$query1 = $this->db->query($script);
				if($query1){
					return true;
				}else{
					return false;
				}
				
				
			}else{
				return false;
			}	
		
		}
		
		
		public function time_in(){
			
			$datetime = date('Y-m-d H:i:s') ;
			$clock_in = date("g:i A");
			
			$data = array(
				'date'=> $datetime,
				'clock_in'=> $clock_in
			);
			
			$table_name = $this->session->userdata('username');
			$query = $this->db->insert($table_name, $data);
			
			if ($query == true){
				return true;
			}else{
				return false;
			}
			
		
		}
		
		public function time_out(){
			error_reporting(0);
			$table_name = $this->session->userdata('username');
			
			$yesterdays_date = date("Y-m-d", strtotime( '-1 days' ) );
			
			$todays_date = date('Y-m-d') ;
			
			$time = date("g:i A");
			
			$this->db->where('date', $yesterdays_date);
			$query1 = $this->db->get($table_name);
			foreach($query1->result() as $row1){}
			$yesterdays_timeout = $row1->clock_out;
			
			$this->db->where('date', $todays_date);
			$query2 = $this->db->get($table_name);
			foreach($query2->result() as $row2){}
			$todays_timeout = $row2->clock_out;
		
			if($yesterdays_timeout == Null and $query2->num_rows() == 0 and $query1->num_rows() == 1){
				$data = array(
					'clock_out'=> $time
				);
				$this->db->where('date', $yesterdays_date);
				$query3 = $this->db->update($table_name, $data);
				
				if($query3 == true){
					return true;
				}else{
					return false;
				}
		
			}else if($query1->num_rows() == 1 and $todays_timeout == NULL and $query2->num_rows() == 1){
				$data = array(
				'clock_out'=> $time
				);
				$this->db->where('date', $todays_date);
				$query3 = $this->db->update($table_name, $data);
				
				if($query3 == true){
					return true;
				}else{
					return false;
				}
				
			}else if($query1->num_rows() == 0 and $todays_lunch_out == NULL and $query2->num_rows() == 1){
				$data = array(
				'clock_out'=> $time
				);
				$this->db->where('date', $todays_date);
				$query3 = $this->db->update($table_name, $data);
				
				if($query3 == true){
					return true;
				}else{
					return false;
				}
			
			}else {
			
				return false;
			}
		
		}
		
		
		public function lunch_out(){
			error_reporting(0);
			
			$table_name = $this->session->userdata('username');
			$yesterdays_date = date("Y-m-d", strtotime( '-1 days' ) );
			$todays_date = date('Y-m-d') ;
			
			
			$time = date("g:i A");
			
			$this->db->where('date', $yesterdays_date);
			$query1 = $this->db->get($table_name);
			foreach($query1->result() as $row1){}
			$yesterdays_lunch_out = $row1->lunch_out;
			
			$this->db->where('date', $todays_date);
			$query2 = $this->db->get($table_name);
			foreach($query2->result() as $row2){}
			$todays_lunch_out = $row2->lunch_out;
			
			if($yesterdays_lunch_out == Null and $query2->num_rows() == 0 and $query1->num_rows() == 1){
				$data = array(
					'lunch_out'=> $time
				);
				$this->db->where('date', $yesterdays_date);
				$query3 = $this->db->update($table_name, $data);
				
				if($query3 == true){
					return true;
				}else{
					return false;
				}
		
			}else if($query1->num_rows() == 1 and $todays_lunch_out == NULL and $query2->num_rows() == 1){
				$data = array(
				'lunch_out'=> $time
				);
				$this->db->where('date', $todays_date);
				$query3 = $this->db->update($table_name, $data);
				
				if($query3 == true){
					return true;
				}else{
					return false;
				}
				
			}else if($query1->num_rows() == 0 and $todays_lunch_out == NULL and $query2->num_rows() == 1){
				$data = array(
				'lunch_out'=> $time
				);
				$this->db->where('date', $todays_date);
				$query3 = $this->db->update($table_name, $data);
				
				if($query3 == true){
					return true;
				}else{
					return false;
				}
			
			}else {
			
				return false;
			}

		}
		
		public function lunch_in(){
			error_reporting(0);
			/* 
				for the entry of times ill be using a total of 3 queries to determine if the time would be for today or yesterdays log in
				the reason for this is because there are guys who will be logging in and log out on different days :-)
			*/
			
			$table_name = $this->session->userdata('username');

			
			$yesterdays_date = date("Y-m-d", strtotime( '-1 days' ) );
			$todays_date = date('Y-m-d') ;
			$time = date("g:i A");
			
			/*
				first is to query yesterday's date and identify if the whole row has already been filled out
			*/
			
			$this->db->where('date', $yesterdays_date);
			$query1 = $this->db->get($table_name);
			foreach($query1->result() as $row1){}
			$yesterdays_lunch_in = $row1->lunch_in;
			
			
			
			
			/*
				next is to query todays date and check if a log in has already been made. This would mean that the user forgot to completely log his/her activities for yesterday
			*/
			
			$this->db->where('date', $todays_date);
			$query2 = $this->db->get($table_name);
			foreach($query2->result() as $row2){}
			$todays_lunch_in = $row2->lunch_in;
			
			
			if($yesterdays_lunch_in == Null and $query2->num_rows() == 0 and $query1->num_rows() == 1){
				$data = array(
					'lunch_in'=> $time
				);
				$this->db->where('date', $yesterdays_date);
				$query3 = $this->db->update($table_name, $data);
				
				if($query3 == true){
					return true;
				}else{
					return false;
				}
		
			}else if($query1->num_rows() == 1 and $todays_lunch_in == NULL and $query2->num_rows() == 1){
				$data = array(
				'lunch_in'=> $time
				);
				$this->db->where('date', $todays_date);
				$query3 = $this->db->update($table_name, $data);
				
				if($query3 == true){
					return true;
				}else{
					return false;
				}
				
			}else if($query1->num_rows() == 0 and $todays_lunch_in == NULL and $query2->num_rows() == 1){
				$data = array(
				'lunch_in'=> $time
				);
				$this->db->where('date', $todays_date);
				$query3 = $this->db->update($table_name, $data);
				
				if($query3 == true){
					return true;
				}else{
					return false;
				}
			
			}else{
			
				return false;
			}
			

		}

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	}

?>