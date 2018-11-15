<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class State extends Auth_controller {

	public function __construct()
	{
		parent::__construct();
		$this->loginData = $this->session->userdata('loginData');
	}

	function index($StatePDF = ' ') 
	{
  // start permission 
		
		$user_role = $this->loginData->user_role;
		$query = "SELECT * FROM role_permissions as rp LEFT JOIN mstrole as mst on rp.RoleID=mst.RoleID WHERE rp.RoleID='$user_role' ";
		$content['role_permission'] = $this->Common_Model->query_data($query);
		// end permission 

		$query = "select * from mststate where IsDeleted=0 and LanguageID = 1";
		if ($this->loginData->user_role == 1 || $this->loginData->user_role == 2 || $this->loginData->user_role == 3 || $this->loginData->user_role == 6 ) 	 {
			$query .= "	and StateCode='".$this->loginData->state_code."' ";

			// add district based filter if district role
			if ($this->loginData->user_role == 7) {
				$query .= " and district_code ='".$this->loginData->district_code."'' ";
			}
			// add district based filter if block role
			if ($this->loginData->user_role == 8) {
				$query .= " and block_code ='".$this->loginData->block_code."'' ";
			}
			
		}

		$content['State_list'] = $this->Common_Model->query_data($query);

		$content['subview']="list_state";

		if ($StatePDF == "export_pdf") {
			$this->export_section($content);
			die();
		}

		$this->load->view('auth/main_layout', $content);
	}

	public function export_csv()
	{
		$query = "select * from mststate where LanguageID = 1 and StateCode='".$this->loginData->state_code."' ";
		$this->load->model('Data_export_model');
		$this->Data_export_model->export_csv($query);
	}

	function add($id=null){

		$hasValidationErrors = false;

		$RequestMethod = $this->input->server('REQUEST_METHOD');
		if($RequestMethod == "POST"){

			$this->form_validation->set_rules('StateNameEnglish','State Name in English','required');
			$this->form_validation->set_rules('StateNameHindi','State Name in Hindi','required');

			if($this->form_validation->run() == FALSE){
				$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible" role="alert" style="color: red;">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>',
					'</div>');

				$this->session->set_flashdata('er_msg', 'There have been validation error(s), please check the error messages');

				$hasValidationErrors	=	true;
				goto prepareview;

			}

			$this->db->trans_start();

// get the StateCode, this is the max(StateCode) column
			$query = "select max(StateCode) as StateCode from mststate";
			$stateRec = $this->Common_Model->query_data($query);

			$statecode = $stateRec[0]->StateCode;

//Record For English LanguageID = 1
			$insertArr = array(
				'StateCode'			=>	$statecode+1,
				'StateName'			=>	$this->input->post('StateNameEnglish'),
				'LanguageID'		=>  1,
				'IsDeleted'			=>  0,

				);
			$this->Common_Model->insert_data('mststate', $insertArr);

//Record For Hindi LanguageID = 2
			$insertArr = array(
				'StateCode'			=>	$statecode+1,
				'StateName'			=>	$this->input->post('StateNameHindi'),
				'LanguageID'		=> 	2,
				'IsDeleted'			=>  0,

				);

			$this->Common_Model->insert_data('mststate', $insertArr);

			$this->session->set_flashdata('tr_msg', 'Successfully added state');


			$this->db->trans_complete();

			if ($this->db->trans_status() === FALSE){
				$this->session->set_flashdata('tr_msg', 'Error adding State');					
			}
			else
			{
				$this->session->set_flashdata('tr_msg', 'Successfully added State');			
			}
			redirect('state');
		}

				prepareview:

		if($hasValidationErrors){
			$content['hasValidationErrors']	=	true;
		}
		else{
			$content['hasValidationErrors']	=	false;				
		}

		$content['subview']="add_state";
		$this->load->view('auth/main_layout', $content);
	}

	function edit($statecode = null){

		$RequestMethod = $this->input->server('REQUEST_METHOD');
		if($RequestMethod == "POST"){

/*	$StateNameEnglish = $this->input->post('StateNameEnglish');
$StateNameHindi= $this->input->post('StateNameHindi');*/

if(!isset($_GET['step'])){
//die('No Step Selected');
}

$this->db->trans_start();

//Record For English LanguageID = 1
$updateArr = array(

	'StateName'			=>	$this->input->post('StateNameEnglish'),
	'LanguageID'		=> 	1,
	'IsDeleted'			=>	0,
	);

$this->db->where('StateCode', $statecode);
$this->db->where('LanguageID', 1);
$this->db->update('mststate', $updateArr);

//Record For Hindi LanguageID = 2
$updateArr = array(

	'StateName'			=>	$this->input->post('StateNameHindi'),
	'LanguageID'		=> 	2,
	'IsDeleted'			=>  0,
	);

$this->db->where('StateCode', $statecode);
$this->db->where('LanguageID', 2);
$this->db->update('mststate', $updateArr);

$this->db->trans_complete();

$this->session->set_flashdata('tr_msg', 'Successfully updated state');

$this->db->trans_complete();

if ($this->db->trans_status() === FALSE){
	$this->session->set_flashdata('tr_msg', 'Error adding state');					
}else
{
	$this->session->set_flashdata('tr_msg', 'Successfully added state');			
}

redirect('state');
}

$query = "select * from mststate where StateCode=$statecode and IsDeleted=0";
$State_details = $this->Common_Model->query_data($query);


if(count($State_details) < 1){
	$this->session->set_flashdata('er_msg', 'The record does not exist / permission denied. Please contact your system administrator.');
	redirect('state');
}

$updateStateArr= array();

foreach ($State_details as $key =>$val) 
{

	if( $State_details[$key]->LanguageID ==1)
		$updateStateArr['StateNameEnglish']	= $State_details[$key]->StateName;

	if($State_details[$key]->LanguageID==2)
		$updateStateArr['StateNameHindi']	= $State_details[$key]->StateName;

	if($key==0)
	{
		$updateStateArr['StateName']		= 	$State_details[$key]->StateName;
	}
}
$content['State_details'] = $updateStateArr;
//print_r($content['State_details']); die();
$content['subview']="edit_state";
$this->load->view('auth/main_layout', $content);
}

function delete($statecode=null){

	$query = "update mststate 
	set IsDeleted = 1
	where StateCode=$statecode";

	$this->db->query($query);
	$this->session->set_flashdata('tr_msg' ,"State Deleted Successfully");
	redirect('state');
}

public function export_section($content = array())
{

		// <link rel='stylesheet' href='" . site_url() . "common/frontend/bootstrap.min.css'>

	$dom = "<!DOCTYPE html>
	<html lang='en'>
	<head>
		<meta charset='UTF-8'>
		<title>Document</title>

	</head>
	<body>";
		$dom .= $this->load->view("print/" . $content['subview'] , $content, true);

		$dom .= "
	</body>
	</html>";

	$this->load->model('Dompdf_model');
	$this->Dompdf_model->export($dom);

}

}