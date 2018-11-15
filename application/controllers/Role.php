<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role extends Auth_controller {

	public function __construct()
	{
		parent::__construct();
		$this->loginData = $this->session->userdata('loginData');
	}
	public function index()
	{	
		 // start permission 
		$user_role = $this->loginData->user_role;
		$query = "SELECT * FROM role_permissions as rp LEFT JOIN mstrole as mst on rp.RoleID=mst.RoleID WHERE rp.RoleID='$user_role' ";
		$content['role_permission'] = $this->Common_Model->query_data($query);
		// end permission 
		
		$query = "select * from mstrole where IsDeleted = 0";
		$content['role_list'] = $this->Common_Model->query_data($query);
		$content['subview'] = "list_role";
		$this->load->view('auth/main_layout', $content);
	}
	public function add()
	{
		$RequestMethod = $this->input->server('REQUEST_METHOD');
		if($RequestMethod == "POST"){
			$insertArr = array(
				'RoleName'			=>	$this->input->post('RoleName'),
				'IsDeleted'	=> 	0,
				);

			$this->Common_Model->insert_data('mstrole', $insertArr);
			$this->session->set_flashdata('tr_msg', 'Successfully added Role');	
			redirect('role');
		}
		$content['subview']="add_role";
		$this->load->view('auth/main_layout', $content);
	}

	public function edit($RoleID =NULL)
	{
		$RequestMethod = $this->input->server('REQUEST_METHOD');
		if($RequestMethod == "POST"){
			$insertArr = array(
				'RoleName'			=>	$this->input->post('RoleName'),
				'IsDeleted'	=> 	0,
				);

			$this->Common_Model->update_data('mstrole', $insertArr,'RoleID',$RoleID);
			$this->session->set_flashdata('tr_msg', 'Successfully added Role');	
			redirect('role');
		}
		$query = "select * from mstrole where RoleID='$RoleID' ";
		$content['list_role'] = $this->Common_Model->query_data($query);

		$content['subview']="edit_role";
		$this->load->view('auth/main_layout', $content);
	}

	function delete($RoleID = NULL)
	{
		$query =  "update mstrole set IsDeleted = 1 where RoleID=$RoleID";
		$this->db->query($query);
		$this->session->set_flashdata('tr_msg' ,"Role Deleted Successfully");
		redirect('role');
	}
}