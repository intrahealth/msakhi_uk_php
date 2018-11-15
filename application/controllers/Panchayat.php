<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Panchayat extends Auth_controller {

	public function __construct(){
		parent::__construct();
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
		$query = "select * from mststate where IsDeleted=0 and LanguageID = 1 ";
		if ($this->loginData->user_role == 1 || $this->loginData->user_role == 2 || $this->loginData->user_role == 3 || $this->loginData->user_role == 6 || $this->loginData->user_role == 7 || $this->loginData->user_role == 8) 	 {
			$query .= "	and StateCode='".$this->loginData->state_code."' ";

			// add district based filter if district role
			if ($this->loginData->user_role == 7) {
				$query .= " and district_code =  $this->loginData->district_code ";
			}
			// add district based filter if block role
			if ($this->loginData->user_role == 8) {
				$query .= " and block_code =  $this->loginData->block_code ";
			}

		}
		$content['State_List'] = $this->Common_Model->query_data($query);

		$RequestMethod = $this->input->server('REQUEST_METHOD');
		if($RequestMethod == "POST")
		{
			$this->form_validation->set_rules('StateCode','State Name','required');
			$this->form_validation->set_rules('DistrictCode','District Name','required');
			$this->form_validation->set_rules('BlockCode','Block Name','required');

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
			
			$query = "select * from mstblock where DistrictCode =".$this->input->post('DistrictCode')." and LanguageID=1 and IsDeleted= 0";
			$content['Block_List'] = $this->Common_Model->query_data($query);

			$query	=	"select * from mstpanchayat where BlockCode	=" .$this->input->post('BlockCode')." and IsDeleted=0". " and LanguageID=1";
			$content['Panchayat_List']	=	$this->Common_Model->query_data($query);
			
			//print_r($content['Panchayat_List']); die();
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
			$content['Panchayat_List']	=	array();

		}
		$content['subview']="list_panchayat";
		$this->load->view('auth/main_layout', $content);
	}

	public function export_csv($StateCode = NULL , $DistrictCode = NULL , $BlockCode = NULL)
	{		
		$query =  "select * from mstpanchayat where StateCode = $StateCode and DistrictCode = $DistrictCode and $BlockCode = BlockCode and LanguageID = 1 and IsDeleted = 0";

		$this->load->model('Data_export_model');
		$this->Data_export_model->export_csv($query);
	}

	public function export_pdf($StateCode = NULL , $DistrictCode = NULL , $BlockCode = NULL)
	{
		$query = "select * from mstvillage where StateCode = $StateCode and DistrictCode = $DistrictCode and BlockCode = $BlockCode and LanguageID = 1 and IsDeleted = 0";

		$this->load->model('Data_export_model');
		$this->Data_export_model->export_pdf($query);
	}
	
	
	function add($StateCode = null, $DistrictCode = null, $BlockCode = null){

		$RequestMethod = $this->input->server('REQUEST_METHOD');
		if($RequestMethod == "POST"){
			
			$this->db->trans_start();
			
			$StateCode = $this->input->get('StateCode');
			$DistrictCode = $this->input->get('DistrictCode');
			$BlockCode	=	$this->input->get('BlockCode');

			//Get the PanchayatCode, THis is the max(PanchayatCode) column
			$sql=	"select max(PanchayatCode) as PanchayatCode from mstpanchayat";
			$panchayatRec	=	$this->Common_Model->query_data($sql);
			$panchayatcode	=	$panchayatRec[0]->PanchayatCode;


		//Record For English LanguageID = 1

			$insertArr = array(
				'StateCode'			=>	$StateCode,
				'DistrictCode'			=>	$DistrictCode,
				'BlockCode'			=>	$BlockCode,
				'PanchayatCode'			=>	$panchayatcode+1,
				'PanchayatName'			=>	$this->input->post('PanchayatNameEnglish'),
				'LanguageID'		=> 1,
				'IsDeleted' 	=> 0,
				
				);
			$this->Common_Model->insert_data('mstpanchayat', $insertArr);
			
			//Record For Hindi LanguageID = 2
			$insertArr = array(
				'StateCode'					=>	$StateCode,
				'DistrictCode'			=>	$DistrictCode,
				'BlockCode'					=>	$BlockCode,
				'PanchayatCode'			=>	$panchayatcode+1,
				'PanchayatName'			=>	$this->input->post('PanchayatNameHindi'),
				'LanguageID'				=>	 2,
				'IsDeleted' 				=>	 0,
				
				);
			$this->Common_Model->insert_data('mstpanchayat', $insertArr);
			
			$this->session->set_flashdata('tr_msg', 'Successfully added panchayat');
			
			$this->db->trans_complete();
			
			if ($this->db->trans_status() === FALSE){
				$this->session->set_flashdata('tr_msg', 'Error adding Panchayat');					
			}else{
				$this->session->set_flashdata('tr_msg', 'Successfully added Panchayat');			
			}
			
			redirect('panchayat');
		}
		
		$content['subview']="add_panchayat";
		$this->load->view('auth/main_layout', $content);
	}
	
	function edit($panchayatcode=null){

		$RequestMethod = $this->input->server('REQUEST_METHOD');
		if($RequestMethod == "POST"){
			
			
			if(!isset($_GET['step'])){
			//die('No Step Selected');
			}
			
			$this->db->trans_start();
			
			//Record for Enlish LanguageID=1
			
			$updateArr = array(
				'PanchayatName'			=>	$this->input->post('PanchayatNameEnglish'),
				'LanguageID'		=> 1,
				'IsDeleted'			=>	0,
				);
			
			$this->db->where('PanchayatCode' , $panchayatcode);
			$this->db->where('LanguageID' , 1);
			$this->db->update('mstpanchayat' , $updateArr);


				//Record for Hindi LanguageID=2
			$updateArr = array(
				'PanchayatName'			=>	$this->input->post('PanchayatNameHindi'),
				'LanguageID'		=> 2,
				'IsDeleted'			=>	0,
				);

			$this->db->where('PanchayatCode' , $panchayatcode);
			$this->db->where('LanguageID' , 2);
			$this->db->update('mstpanchayat' , $updateArr);
			
			
			$this->db->trans_complete();
			
			$this->session->set_flashdata('tr_msg', 'Successfully updated panchayat');
			
			if ($this->db->trans_status() === FALSE){
				$this->session->set_flashdata('tr_msg', 'Error adding Panchayat');					
			}else{
				$this->session->set_flashdata('tr_msg', 'Successfully added Panchayat');			
			}

			redirect('panchayat');
		}

		$query = "select * from mstpanchayat where PanchayatCode=$panchayatcode and IsDeleted=0";
		$Panchayat_details = $this->Common_Model->query_data($query);
		
		if(count($Panchayat_details) < 1){
			$this->session->set_flashdata('er_msg', 'The record does not exist / permission denied. Please contact your system authistrator.');
			redirect('panchayat');
		}

		$updatePanchayatArr= array();

		foreach ($Panchayat_details as $key =>$val) 
		{

			if( $Panchayat_details[$key]->LanguageID ==1)
				$updatePanchayatArr['PanchayatNameEnglish']	= $Panchayat_details[$key]->PanchayatName;

			if($Panchayat_details[$key]->LanguageID==2)
				$updatePanchayatArr['PanchayatNameHindi']	= $Panchayat_details[$key]->PanchayatName;

			if($key==0)
			{
				$updatePanchayatArr['PanchayatName']		= 	$Panchayat_details[$key]->PanchayatName;
			}
		}
		$content['Panchayat_details'] = $updatePanchayatArr;
		
		$content['Panchayat_details'] = $updatePanchayatArr;
		$content['subview']="edit_panchayat";
		$this->load->view('auth/main_layout', $content);
		
		
	}
	
	function delete($panchayatcode =  NULL){

		$query = "update mstpanchayat set IsDeleted = 1 where PanchayatCode=$panchayatcode";

		$this->db->query($query);
		$this->session->set_flashdata('tr_msg' ,"Panchayat Deleted Successfully");
		redirect('panchayat');
	}
	

}