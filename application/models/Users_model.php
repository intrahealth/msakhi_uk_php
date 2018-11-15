<?php 
class Users_Model extends CI_Model {
	
	public function __construct()
  {
			parent::__construct();
			$this->gallery_path = realpath(APPPATH . '../uploadsimage');
			$this->gallery_path_url = base_url().'uploadsimage/';
  }

	public function isLoggedInAdmin(){
		$loginData = $this->session->userdata('loginData');
		if($loginData->user_role == 5){
			return true;
		} else {
			return false;
		}	
	}

	public function isLoggedInGov(){
		$loginData = $this->session->userdata('loginData');
		if($loginData->user_role == 8){
			return true;
		} else {
			return false;
		}	
	}
	
	
}
