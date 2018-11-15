<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Block extends Auth_controller {

	public function __construct(){
		parent::__construct();
		// $this->load->library('form_validation');
		$this->loginData = $this->session->userdata('loginData');
	}
	
	function index() {

		$hasValidationErrors = false;

    // start permission code
		$user_role = $this->loginData->user_role;
		$query = "SELECT * FROM role_permissions as rp LEFT JOIN mstrole as mst on rp.RoleID=mst.RoleID WHERE rp.RoleID='$user_role' ";
		$content['role_permission'] = $this->Common_Model->query_data($query);
    // End permission code
		
		// $query = "select * from mststate where LanguageID=1 and IsDeleted = 0";
		// $content['State_List'] = $this->Common_Model->query_data($query);

		$query = "select * from mststate where IsDeleted=0 and LanguageID = 1 ";
		if ($this->loginData->user_role == 1 || $this->loginData->user_role == 2 || $this->loginData->user_role == 3 || $this->loginData->user_role == 6) 	 {
			$query .= "	and StateCode='".$this->loginData->state_code."' ";

			// add district based filter if district role
			if ($this->loginData->user_role == 7) {
				$query .= " and district_code ='".$this->loginData->district_code."' ";
			}
			// add district based filter if block role
			if ($this->loginData->user_role == 8) {
				$query .= " and block_code ='".$this->loginData->block_code."' ";
			}

		}
		$content['State_List'] = $this->Common_Model->query_data($query);

		$RequestMethod = $this->input->server('REQUEST_METHOD');
		if($RequestMethod == "POST")
		{
			$this->form_validation->set_rules('StateCode','State Name','required');
			$this->form_validation->set_rules('DistrictCode','District Name','required');

			if($this->form_validation->run() == FALSE){
				$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible" role="alert" style="color: red;">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>',
					'</div>');

				$this->session->set_flashdata('er_msg', 'There have been validation error(s), please check the error messages');

				$hasValidationErrors	=	true;
				goto prepareview;

			}


			$query = "select * from mstdistrict where StateCode=".$this->input->post('StateCode')." and LanguageID=1 and IsDeleted = 0";
			$content['District_List'] = $this->Common_Model->query_data($query);
			
			$query = "select * from mstblock where DistrictCode =".$this->input->post('DistrictCode')." and IsDeleted=0 "." and LanguageID=1";
			$content['Block_List'] = $this->Common_Model->query_data($query);
			
		}else{

			
			prepareview:

		if($hasValidationErrors){
			$content['hasValidationErrors']	=	true;
		}
		else{
			$content['hasValidationErrors']	=	false;				
		}
			$content['District_List'] = array();
			$content['Block_List'] = array();
			
		}

		
		
		$content['subview']="list_block";
		$this->load->view('auth/main_layout', $content);
	}

	public function export_csv($StateCode = NULL , $DistrictCode = NULL)
	{		
		$query = "select * from mstblock where StateCode = $StateCode and DistrictCode = $DistrictCode and LanguageID = 1 and IsDeleted = 0";

		$this->load->model('Data_export_model');
		$this->Data_export_model->export_csv($query);
	}

	public function export_pdf($StateCode = NULL , $DistrictCode = NULL)
	{
		$query = "select * from mstblock where StateCode = $StateCode and DistrictCode = $DistrictCode and LanguageID = 1 and IsDeleted = 0";

		$content['Block_List'] = $this->Common_Model->query_data($query);
		//print_r($content['Block_List']); die();

		$content['subview']="list_block";
		$this->export_section($content);
		die();
	}

	public function export_section($content = array())
	{
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

	function add($StateCode = NULL, $DistrictCode = NULL){

		$RequestMethod = $this->input->server('REQUEST_METHOD');
		if($RequestMethod == "POST"){

			$this->db->trans_start();

			$StateCode = $this->input->get('StateCode');
			$DistrictCode = $this->input->get('DistrictCode');

			//Get the BlockCode, THis is the max(BlockCode) column
			$sql=	"select max(BlockCode) as BlockCode from mstblock";
			$blockLis	=	$this->Common_Model->query_data($sql);
			$blockcode	=	$blockLis[0]->BlockCode;


		//Record For English LanguageID = 1

			$insertArr = array(
				'StateCode'			=>	$StateCode,
				'DistrictCode'  =>	$DistrictCode,
				'BlockCode'			=>	$blockcode+1,
				'BlockName'			=>	$this->input->post('BlockNameEnglish'),
				'LanguageID'		=>  1,
				'IsDeleted'			=>  0,

				);
		// print_r($insertArr); die();			
			$this->Common_Model->insert_data('mstblock', $insertArr);

			//Record For Hindi LanguageID=2
			$insertArr = array(
				'StateCode'			=>	$StateCode,
				'DistrictCode'	=>	$DistrictCode,
				'BlockCode'			=>	$blockcode+1,
				'BlockName'			=>	$this->input->post('BlockNameHindi'),
				'LanguageID'		=>  2,
				'IsDeleted'			=>	0,

				);
			$this->Common_Model->insert_data('mstblock', $insertArr);

			$this->session->set_flashdata('tr_msg', 'Successfully added block');

			$this->db->trans_complete();

			if ($this->db->trans_status() === FALSE){
				$this->session->set_flashdata('tr_msg', 'Error adding Block');					
			}else{
				$this->session->set_flashdata('tr_msg', 'Successfully added BLock');			
			}
			redirect('block');
		}

		$content['subview']="add_block";
		$this->load->view('auth/main_layout', $content);
	}

	function edit($blockcode = NULL){

		$RequestMethod = $this->input->server('REQUEST_METHOD');
		if($RequestMethod == "POST"){

			$this->db->trans_start();

			//Record for Enlish LanguageID=1
			$updateArr = array(				
				'BlockName'			=>	$this->input->post('BlockNameEnglish'),
				'LanguageID'		=> 	1,
				'IsDeleted'			=>	0,
				);

			$this->db->where('BlockCode' , $blockcode);
			$this->db->where('LanguageID' , 1);
			$this->db->update('mstblock' , $updateArr);


			//Record for Hindi LanguageID=2
			$updateArr = array(
				'BlockName'		=>	$this->input->post('BlockNameHindi'),
				'LanguageID'	=>	2,
				'IsDeleted'		=>	0,
				);

			$this->db->where('BlockCode' , $blockcode);
			$this->db->where('LanguageID' , 2);
			$this->db->update('mstblock' , $updateArr);


			$this->db->trans_complete();

			$this->session->set_flashdata('tr_msg', 'Successfully updated block');

			if ($this->db->trans_status() === FALSE){
				$this->session->set_flashdata('tr_msg', 'Error adding state');					
			}else{
				$this->session->set_flashdata('tr_msg', 'Successfully added state');			
			}
			redirect('block');
		}

		$query = "select * from mstblock where BlockCode=$blockcode and IsDeleted=0";
		$Block_details = $this->Common_Model->query_data($query);

		if(count($Block_details) < 1){
			$this->session->set_flashdata('er_msg', 'The record does not exist / permission denied. Please contact your system authistrator.');
			redirect('block');
		}

		$updateBlockArr = array();
		foreach ($Block_details as $key =>$val) 
		{

			if( $Block_details[$key]->LanguageID ==1)

				$updateBlockArr['BlockNameEnglish']	= $Block_details[$key]->BlockName;

			if($Block_details[$key]->LanguageID==2)

				$updateBlockArr['BlockNameHindi']	= $Block_details[$key]->BlockName;


			if($key==0)
			{
				$updateBlockArr['BlockName']	= $Block_details[$key]->BlockName;
			}
		}
		$content['Block_details'] = $updateBlockArr;
		$content['subview']="edit_block";
		$this->load->view('auth/main_layout', $content);
	}

	function delete($blockcode =  NULL){

		$sql = "update mstblock	set IsDeleted = 1	where	BlockCode=$blockcode";

		$this->db->query($sql);
		$this->session->set_flashdata('tr_msg' ,"Block Deleted Successfully");
		redirect('block');
	}


}