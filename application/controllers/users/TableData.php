<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tabledata extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$loginData = $this->session->userdata('loginData');
		if($loginData->user_role != 2){
			$this->session->set_flashdata('er_msg','You are not logged-in, please login again to continue');
			redirect('login');	
		}
	}

}
