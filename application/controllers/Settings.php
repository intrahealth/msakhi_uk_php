<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Settings extends Auth_controller {

	public function __construct(){
		parent::__construct();
		$this->loginData = $this->session->userdata('loginData');
	}

	public function index()
	{

		$RequestMethod = $this->input->server('REQUEST_METHOD');
		if($RequestMethod == "POST") {

			if (isset($_POST['allow_by_admin'])) {
				$allow_by_admin = 1;
			}else{
				$allow_by_admin = 0;
			}

			if (isset($_POST['allow_by_fa'])) {
				$allow_by_fa = 1;
			}else{
				$allow_by_fa = 0;
			}

			$updateArr = array(
				'Org_Name'           =>	$this->input->post('Org_Name'),
				'Contact_Person'     =>	$this->input->post('Contact_Person'),
				'Contact_DirectLine' =>	$this->input->post('Contact_DirectLine'),
				'Smtp_Hostname'      =>	$this->input->post('Smtp_Hostname'),
				'Smtp_Port'          =>	$this->input->post('Smtp_Port'),
				'Smtp_Username'      =>	$this->input->post('Smtp_Username'),
				'Smtp_Password'      =>	$this->input->post('Smtp_Password'),
				'trello_key'         =>	$this->input->post('trello_key'),
				'trello_secret'      =>	$this->input->post('trello_secret'),
				'allow_by_admin'     =>	$allow_by_admin,
				'allow_by_fa'     	 =>	$allow_by_fa,
			);
			// print_r($updateArr); die();
			$this->db->where('id', 1);
			$this->db->update('tblsettings', $updateArr);
		}

		$query = "select * from tblsettings";
		$content['api_setting'] = $this->db->query($query)->result()[0];
		// print_r($content['api_setting']); die();
		
		$content['subview'] = "settings";
		$this->load->view('auth/main_layout', $content);
	}

}