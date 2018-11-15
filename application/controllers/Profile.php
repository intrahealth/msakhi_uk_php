<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Profile extends Auth_controller {

	public function __construct()
	{
		parent::__construct();
		$this->loginData = $this->session->userdata('loginData');
	}

	function index($id=null) 
	{
       // start permission 
		$user_role = $this->loginData->user_role;
		$query = "SELECT * FROM role_permissions as rp LEFT JOIN mstrole as mst on rp.RoleID=mst.RoleID WHERE rp.RoleID='$user_role' ";
		$content['role_permission'] = $this->Common_Model->query_data($query);
		// end permission 
		$uid = $this->loginData->id;
		$RequestMethod = $this->input->server('REQUEST_METHOD');
		if($RequestMethod == "POST")
		{
			$updateArray = array( 
				'user_name'   => $this->input->post('user_name'),
				'email'      => $this->input->post('email'),
				'password'   => md5($this->input->post('password')),
				'first_name' =>	$this->input->post('first_name'),
				'last_name'  => $this->input->post('last_name'), 
				'phone_no'   =>	$this->input->post('phone_no'),
				);
			
			$this->Common_Model->update_data('tblusers',$updateArray,'id',$uid);
			$this->session->set_flashdata('tr_msg', 'Successfully updated User');
			redirect('profile');
		}

		$query = "select * from tblusers where id= '".$this->loginData->id."' ";
		$content['user_data'] = $this->Common_Model->query_data($query);

		$content['subview'] = 'edit_profile';
		$this->load->view('auth/main_layout', $content);
	}

}