<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Change_password extends Auth_controller {

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
				'password'   => md5($this->input->post('password')),
				);
			
			$this->Common_Model->update_data('tblusers',$updateArray,'id',$uid);
			$this->session->set_flashdata('tr_msg', 'Successfully updated User');
			redirect('change_password');
		}

		$query = "select * from tblusers where id= '".$this->loginData->id."' ";
		$content['user_data'] = $this->Common_Model->query_data($query);

		$content['subview'] = 'change_password';
		$this->load->view('auth/main_layout', $content);
	}

}