<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class District extends Auth_controller {

	public function __construct(){
		parent::__construct();
		$this->loginData = $this->session->userdata('loginData');
	}
	
	function index($districtPDF = ' ') {

		$hasValidationErrors = false;

		// start permission code
		$user_role = $this->loginData->user_role;
		$query = "SELECT * FROM role_permissions as rp LEFT JOIN mstrole as mst on rp.RoleID=mst.RoleID WHERE rp.RoleID='$user_role' ";
		$content['role_permission'] = $this->Common_Model->query_data($query);
    // End permission code

		// to fill the upper container
		//$query = "select * from mststate where LanguageID = 1 and IsDeleted = 0";
		$query = "select * from mststate where IsDeleted=0 and LanguageID = 1 ";
		if ($this->loginData->user_role == 1 || $this->loginData->user_role == 2 || $this->loginData->user_role == 3 || $this->loginData->user_role == 6){
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
		
		$content['State_list'] = $this->Common_Model->query_data($query);


		$RequestMethod = $this->input->server('REQUEST_METHOD');
		if($RequestMethod == "POST")
		{
			$this->form_validation->set_rules('StateCode','State Name','required');

			if($this->form_validation->run() == FALSE){
				$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible" role="alert" style="color: red;">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>',
					'</div>');

				$this->session->set_flashdata('er_msg', 'There have been validation error(s), please check the error messages');

				$hasValidationErrors	=	true;
				goto prepareview;

			}


			$query = "select * from mstdistrict where StateCode=".$this->input->post('StateCode')." and LanguageID=1 and IsDeleted = 0";
			$content['District_list'] = $this->Common_Model->query_data($query);		
			
		}else{

			prepareview:

		if($hasValidationErrors){
			$content['hasValidationErrors']	=	true;
		}
		else{
			$content['hasValidationErrors']	=	false;				
		}

			$content['District_list'] = array();
		}
		$content['subview']="list_district";

		if ($districtPDF == "export_pdf") {
			$this->export_section($content);
			die();
		}
		$this->load->view('auth/main_layout', $content);
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

	public function export_csv($StateCode = NULL)
	{
		$query = "select * from mstdistrict where StateCode = $StateCode and LanguageID = 1 and IsDeleted = 0";
		$this->load->model('Data_export_model');
		$this->Data_export_model->export_csv($query);
	}

	public function export_pdf($StateCode = NULL)
	{
		$query = "select DistrictCode,DistrictName from mstdistrict where StateCode = $StateCode and LanguageID = 1 and IsDeleted = 0";
     $content['District_list'] = $this->Common_Model->query_data($query);
		 $content['subview']="list_district";
			$this->export_section($content);
			die();
	}
	
	function add($StateCode=null){

		$RequestMethod = $this->input->server('REQUEST_METHOD');
		if($RequestMethod == "POST"){
			
			$this->db->trans_start();
			
			$StateCode = $this->input->get('StateCode');
			
		// get the DistrictCode, This is the max(DistrictCode) column
			$query = "select max(DistrictCode) as DistrictCode from mstdistrict";
			$districtCod	=	$this->Common_Model->query_data($query);
			$districtcode = $districtCod[0]->DistrictCode;

		//Record For English LanguageID = 1

			$insertArr = array(
				'StateCode'					=> $StateCode,
				'DistrictCode'			=>	$districtcode+1,
				'DistrictName'			=>	$this->input->post('DistrictNameEnglish'),
				'LanguageID'				=> 	1,
				'IsDeleted'					=>	0,
				);

			$this->Common_Model->insert_data('mstdistrict', $insertArr);
			
			//Record For Hindi LanguageID = 2
			$insertArr = array(
				'StateCode'					=>	$StateCode,
				'DistrictCode'			=>	$districtcode+1,
				'DistrictName'			=>	$this->input->post('DistrictNameHindi'),
				'LanguageID'				=> 	2,
				'IsDeleted'					=>	0,
				);
			
			$this->Common_Model->insert_data('mstdistrict', $insertArr);
			
			$this->session->set_flashdata('tr_msg', 'Successfully added district');
			
			$this->db->trans_complete();
			
			if ($this->db->trans_status() === FALSE){
				$this->session->set_flashdata('tr_msg', 'Error adding Anm');					
			}else{
				$this->session->set_flashdata('tr_msg', 'Successfully added Anm');			
			}
			
			redirect('district');
		}

		$content['subview']="add_district";
		$this->load->view('auth/main_layout', $content);
	}
	
	function edit($districtcode=null){

		$RequestMethod = $this->input->server('REQUEST_METHOD');
		if($RequestMethod == "POST"){

			/*$DistrictNameEnglish = $this->input->post('DistrictNameEnglish');
			$DistrictNameHindi = $this->input->post('DistrictNameHindi');*/
			
			if(!isset($_GET['step'])){
			//die('No Step Selected');
			}
			
			$this->db->trans_start();

			//Record for English LanguageID=1
			$updateArr = array(
				'DistrictName'			=>	$this->input->post('DistrictNameEnglish'),
				'LanguageID'		=> 1,
				'IsDeleted'	=>	0,
				);
			
			$this->db->where('DistrictCode' , $districtcode);
			$this->db->where('LanguageID', 1);
			$this->db->update('mstdistrict', $updateArr);
			
			//Record for Hindi LanguageID=2
			$updateArr = array(
				'DistrictName'			=>	$this->input->post('DistrictNameHindi'),
				'LanguageID'		=> 2,
				'IsDeleted'	=>	0,
				);

			$this->db->where('DistrictCode' , $districtcode);
			$this->db->where('LanguageID', 2);
			$this->db->update('mstdistrict' , $updateArr);

			$this->db->trans_complete();

			$this->session->set_flashdata('tr_msg', 'Successfully updated district');
			
			if ($this->db->trans_status() === FALSE){
				$this->session->set_flashdata('tr_msg', 'Error adding state');					
			}else{
				$this->session->set_flashdata('tr_msg', 'Successfully added state');			
			}
			
			redirect('district');
		}
		
		$query = "select * from mstdistrict where DistrictCode=$districtcode and IsDeleted=0";
		$District_details = $this->Common_Model->query_data($query);

		if(count($District_details) < 1){
			$this->session->set_flashdata('er_msg', 'The record does not exist / permission denied. Please contact your system authistrator.');
			redirect('district');
		}
		
		$updateDistrictArr= array();

		foreach ($District_details as $key =>$val) 
		{

			if( $District_details[$key]->LanguageID ==1)
				
				$updateDistrictArr['DistrictNameEnglish']	= $District_details[$key]->DistrictName;

			if($District_details[$key]->LanguageID==2)
				
				$updateDistrictArr['DistrictNameHindi']	= $District_details[$key]->DistrictName;
			

			if($key==0)
			{
				$updateDistrictArr['DistrictName']		= 	$District_details[$key]->DistrictName;
			}
		}
		$content['District_details'] = $updateDistrictArr;
		$content['subview']="edit_district";
		$this->load->view('auth/main_layout', $content);
		
		
	}
	
	function delete($districtcode=null){

		$query = "update mstdistrict
		set IsDeleted = 1
		where DistrictCode=$districtcode";

		$this->db->query($query);
		$this->session->set_flashdata('tr_msg' ,"District Deleted Successfully");
		redirect('district');
	}
	
}