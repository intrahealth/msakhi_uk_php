<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* Auth controller, this is entry point for all the auth
* All the controller access defined in role_permissions
* are enforced from here
*/
class Auth_controller extends Ci_controller
{
	function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('Users_model', 'Users_Model');
		$this->load->model('Common_Model');
		$this->data['meta_title'] = 'Auth panel : Msakhi';
		$this->data['my_title'] = "Intrahealth Auth";

		if (!$this->is_allowed()) {
			$this->session->set_flashdata('er_msg', 'The record does not exist / permission denied. Please contact your system authistrator.');
         	    redirect('mnch_dashboard');
		}	
	}
	public function is_allowed()
	{
		$login_data = $this->session->userdata('loginData');
		
		if ($login_data == NULL) {
			redirect('login');
		}

		$controller = trim(strtolower($this->uri->segment(1)));
		$action = trim(strtolower($this->uri->segment(2)));

		if ($action == NULL) {
			$action = 'index';
		}

		$user_role = $login_data->user_role;
		if ($controller == 'ajax') {
			return true;
		}

		// $user_role = $login_data->user_role;
		// if ($controller == 'Exception_reports') {
		// 	return true;
		// }

		$this->db->where('Controller', $controller);
		$this->db->where('Action', $action);
		$this->db->where('RoleID', $user_role);
		$result = $this->db->get('role_permissions')->result();

		if (count($result) < 1) {
			return false;
		}

		return true;
	}
}