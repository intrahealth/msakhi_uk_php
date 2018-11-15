<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Permissions extends Auth_controller 
{
	public function __construct(){
		parent::__construct();
		$this->load->model("Permissions_model");
		$this->loginData = $this->session->userdata('loginData');
	}
	
	function index() 
	{	
		 // start permission 
		$user_role = $this->loginData->user_role;
		$query = "SELECT * FROM role_permissions as rp LEFT JOIN mstrole as mst on rp.RoleID=mst.RoleID WHERE rp.RoleID='$user_role' ";
		$content['role_permission'] = $this->Common_Model->query_data($query);
		// end permission 

		$content['role_list'] = $this->db->get('mstrole')->result();
		$RoleID = $this->input->post('RoleID');

		$flag = $this->input->post('flag');
		if ($flag == "update") {
			$this->Permissions_model->update_permissions();
		}

		if ($RoleID != NULL) {
			$this->db->where('RoleID', $RoleID);
			
			$content['permissions_list'] = $this->db->get('role_permissions')->result();
			//print_r($content['permissions_list']); die();
		}else{
			$content['permissions_list'] = [];
		}

		$content['subview']="list_permissions";
		$this->load->view('auth/main_layout', $content);
	}

	public function Add()
	{

		$RequestMethod = $this->input->server('REQUEST_METHOD');
		if($RequestMethod == 'POST'){

			$insertArr = array(
				'RoleID'            => $this->input->post('RoleID'),
				'Controller'        => $this->input->post('controller'),
				);
			$this->Common_Model->insert_data('role_permissions', $insertArr);
			$this->session->set_flashdata('tr_msg', 'Successfully added Controller');
			redirect('Permissions/');
		}

		$content['subview']="list_permissions";
		$this->load->view('auth/main_layout', $content);
	}

}	