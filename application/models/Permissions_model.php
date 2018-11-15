<?php 
class Permissions_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		
	}
	public function update_permissions()
	{
		$RoleID = $this->input->post('RoleID');
		$selected = $this->input->post('selected');
		// empty the role_permissions table 
	  //print_r($selected); die();
		$this->db->where('RoleID', $RoleID);
		$this->db->delete('role_permissions');
		foreach ($selected as $controller => $row) {
		//print_r($row); die();
			foreach ($row as $action => $value) {
				$insertArr = array(
					'controller' 	=> 	$controller, 
					'action'		=>	$action,
					'RoleID'		=>	$RoleID,
					);
				$this->db->insert('role_permissions', $insertArr);
				$this->session->set_flashdata('tr_msg', 'Successfully added Controller');
				
			}
		}
	}

}