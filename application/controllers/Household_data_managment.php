<?php
// defined('BASEPATH') OR exit('No direct script access allowed');
class Household_data_managment extends Auth_controller {

	public function __construct()
	{
		parent::__construct();
		$this->loginData = $this->session->userdata('loginData');
	}

	public function index($id = NULL)
	{

	// start permission code
		$user_role = $this->loginData->user_role;
		$query = "SELECT * FROM role_permissions as rp LEFT JOIN mstrole as mst on rp.RoleID=mst.RoleID WHERE rp.RoleID='$user_role' ";
		$content['role_permission'] = $this->Common_Model->query_data($query);
    // End permission code

		$content['subview'] = "household_data_managment";
		$this->load->view('auth/main_layout', $content);
	}

}