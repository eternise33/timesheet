<?php 

	include("/system/libraries/facebook/facebook.php");

	Class Fbconnect extends Facebook{
	
			public $user = NULL;
			public $user_id = NULL;
			public $fb = false;
			public $fbSession = false;
			public $appkey = 0;	
	
	
		public function Fbconnect(){
			error_reporting(0);
			

			
			$ci = & get_instance();
			$ci->config->load('facebook', TRUE);
			$config = $ci->config->item('facebook');
			parent::__construct($config);
			
			$this->user_id = $this->getUser();
			$me = null;
			
			if($this->user_id){
				try{
					$me = $this->api('/me');
					$this->user = $me;
				}catch(FacebookApiException $e){
					error_log($e);
				}
			}
		}
	
		public function return_value($value){
			return $value;
	
		}	
		
		
		public function login_validation(){
			$ci = & get_instance();
			$ci->load->helper('url');
			
		
		}
	
	}



?>