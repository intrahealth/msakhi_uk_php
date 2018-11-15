<?php
class State extends Gov_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	function index() {

		$query = "select * from mststate where IsDeleted=0 and LanguageID = 1";
		$content['State_list'] = $this->Common_Model->query_data($query);

		$content['subview']="list_state";
		$this->load->view('gov/main_layout', $content);
	}

		public function export_csv()
	{
		$query = "select * from mststate where LanguageID = 1";
		$this->load->model('Data_export_model');
		$this->Data_export_model->export_csv($query);
	}

	public function export_pdf()
	{
		$query = "select * from mststate where LanguageID = 1";
		$this->load->model('Data_export_model');
		$this->Data_export_model->export_pdf($query);
	}

	function add($id=null){

		$RequestMethod = $this->input->server('REQUEST_METHOD');
		if($RequestMethod == "POST"){

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
			redirect('gov/state');
		}

		$content['subview']="add_state";
		$this->load->view('gov/main_layout', $content);
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

redirect('gov/state');
}

$query = "select * from mststate where StateCode=$statecode and IsDeleted=0";
$State_details = $this->Common_Model->query_data($query);


if(count($State_details) < 1){
	$this->session->set_flashdata('er_msg', 'The record does not exist / permission denied. Please contact your system govistrator.');
	redirect('gov/state');
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
$this->load->view('gov/main_layout', $content);
}

function delete($statecode=null){

	$query = "update mststate 
	set IsDeleted = 1
	where StateCode=$statecode";

	$this->db->query($query);
	$this->session->set_flashdata('tr_msg' ,"State Deleted Successfully");
	redirect('gov/state');
}

}