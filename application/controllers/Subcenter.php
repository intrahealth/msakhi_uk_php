<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Subcenter extends Auth_controller {


	public function __construct()
	{
		parent::__construct();
		$this->loginData = $this->session->userdata('loginData');
	}
	
	function index() {

		// start permission code
		$user_role = $this->loginData->user_role;
		$query = "SELECT * FROM role_permissions as rp LEFT JOIN mstrole as mst on rp.RoleID=mst.RoleID WHERE rp.RoleID='$user_role' ";
		$content['role_permission'] = $this->Common_Model->query_data($query);
    // End permission code

		//$query = "select * from mstsubcenter where IsDeleted=0 and LanguageID=1 ";
		$query = "select * from mststate as mst LEFT JOIN mstsubcenter as subc on subc.StateCode=mst.StateCode where subc.IsDeleted=0 and subc.LanguageID=1 ";
		if ($this->loginData->user_role == 1 || $this->loginData->user_role == 2 || $this->loginData->user_role == 3 || $this->loginData->user_role == 6 || $this->loginData->user_role == 7 || $this->loginData->user_role == 8) 	 {
			$query .= "	and subc.StateCode='".$this->loginData->state_code."' ";

			// add district based filter if district role
			if ($this->loginData->user_role == 7) {
				$query .= " and district_code =  $this->loginData->district_code ";
			}
			// add district based filter if block role
			if ($this->loginData->user_role == 8) {
				$query .= " and block_code =  $this->loginData->block_code ";
			}

		}
		$content['Subcenter_list'] = $this->Common_Model->query_data($query);

		$content['subview']="list_subcenter";
		$this->load->view('auth/main_layout', $content);

	}

	public function export_csv()
	{		
		$query = "select * from mstsubcenter where LanguageID = 1 and IsDeleted = 0"; 
		$this->load->model('Data_export_model');
		$this->Data_export_model->export_csv($query);
	}

	public function export_pdf($StateCode = NULL)
	{
		$query = "select * from mstsubcenter where LanguageID = 1 and IsDeleted = 0";
		$this->load->model('Data_export_model');
		$this->Data_export_model->export_pdf($query);
	}

	
	function add($id=null){

		$hasValidationErrors = false;

		$RequestMethod = $this->input->server('REQUEST_METHOD');
		if($RequestMethod == "POST"){

			$this->form_validation->set_rules('SubCenterNameEnglish','Sub Center Name in English','required');
			$this->form_validation->set_rules('SubCenterNameHindi','Sub Center Name in Hindi','required');
			$this->form_validation->set_rules('PHC_id','PHC ID','required|numeric');

			if($this->form_validation->run() == FALSE){
				$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible" role="alert" style="color: red;">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>',
					'</div>');

				$this->session->set_flashdata('er_msg', 'There have been validation error(s), please check the error messages');

				$hasValidationErrors	=	true;
				goto prepareview;

			}

			$this->db->trans_start();


					//get the SubCenterID , this is the max (SubCenterId) column
			$query = "select max(SubCenterID) as SubCenterID from mstsubcenter";
			$centeridRec = $this->Common_Model->query_data($query);
			$subcenterid = $centeridRec[0]->SubCenterID;


					// get the SubCenterCode, this is the max(SubCenterCode) column
			$query = "select max(SubCenterCode) as SubCenterCode from mstsubcenter";
			$centerRec = $this->Common_Model->query_data($query);
			$subcentercode = $centerRec[0]->SubCenterCode;

			//Record For English LanguageID = 1
			$insertArr = array(
				'SubCenterID'				=>	$subcenterid+1,
				'SubCenterCode'			=>	$subcentercode+1,
				'SubCenterName'			=>	$this->input->post('SubCenterNameEnglish'),
				'PHC_id'						=>	$this->input->post('PHC_id'),
				'LanguageID'				=>  1,
				'IsDeleted'					=>  0,
				
				);
			$this->Common_Model->insert_data('mstsubcenter', $insertArr);

			//Record For Hindi LanguageID = 2
			$insertArr = array(
				'SubCenterID'			=>	$subcenterid+1,
				'SubCenterCode'		=>	$subcentercode+1,
				'SubCenterName'		=>	$this->input->post('SubCenterNameHindi'),
				'PHC_id'					=> 	$this->input->post('PHC_id'),
				'LanguageID'			=> 	2,
				'IsDeleted'				=>  0,

				);

			$this->Common_Model->insert_data('mstsubcenter', $insertArr);

			$this->session->set_flashdata('tr_msg', 'Successfully added subcenter');

			$this->db->trans_complete();

			if ($this->db->trans_status() === FALSE){
				$this->session->set_flashdata('tr_msg', 'Error adding Subcenter');					
			}else{
				$this->session->set_flashdata('tr_msg', 'Successfully added Subcenter');			
			}

			redirect('subcenter');
		}

				prepareview:

		if($hasValidationErrors){
			$content['hasValidationErrors']	=	true;
		}
		else{
			$content['hasValidationErrors']	=	false;				
		}

		$content['subview']="add_subcenter";
		$this->load->view('auth/main_layout', $content);
	}

	function edit($subcentercode = null){

		$RequestMethod = $this->input->server('REQUEST_METHOD');
		if($RequestMethod == "POST"){
			
			if(!isset($_GET['step'])){
			//die('No Step Selected');
			}
			
			$this->db->trans_start();

	  //Record For English LanguageID = 1
			$updateArr = array(
				'SubCenterName'			=>	$this->input->post('SubCenterNameEnglish'),
				'PHC_id'						=>	$this->input->post('PHC_id'),
				'LanguageID'				=> 	1,
				'IsDeleted'					=>	0,
				);

			$this->db->where('SubCenterCode', $subcentercode);
			$this->db->where('LanguageID', 1);
			$this->db->update('mstsubcenter', $updateArr);

		//Record For Hindi LanguageID = 2
			$updateArr = array(
				'SubCenterName'			=>	$this->input->post('SubCenterNameHindi'),
				'PHC_id'						=>	$this->input->post('PHC_id'),
				'LanguageID'				=> 	2,
				'IsDeleted'					=>  0,
				);
			
			$this->db->where('SubCenterCode', $subcentercode);
			$this->db->where('LanguageID', 2);
			$this->db->update('mstsubcenter', $updateArr);

			$this->db->trans_complete();

			$this->session->set_flashdata('tr_msg', 'Successfully updated subcenter');

			if ($this->db->trans_status() === FALSE){
				$this->session->set_flashdata('tr_msg', 'Error Editing subcenter');					
			}else
			{
				$this->session->set_flashdata('tr_msg', 'Successfully Edit subcenter');			
			}

			redirect('subcenter');
		}

		$query = "select * from mstsubcenter where SubCenterCode=$subcentercode and IsDeleted=0";
		$Subcenter_details = $this->Common_Model->query_data($query);

		if(count($Subcenter_details) < 1){
			$this->session->set_flashdata('er_msg', 'The record does not exist / permission denied. Please contact your system authistrator.');
			redirect('subcenter');
		}
		
		$updateSubcenterArr = array();

		foreach ($Subcenter_details as $key =>$val) 
		{

			if( $Subcenter_details[$key]->LanguageID ==1)
				
				$updateSubcenterArr['SubCenterNameEnglish']	= $Subcenter_details[$key]->SubCenterName;
			$updateSubcenterArr['PHC_id'] = $Subcenter_details[$key]->PHC_id;

			if($Subcenter_details[$key]->LanguageID==2)
				
				$updateSubcenterArr['SubCenterNameHindi']	= $Subcenter_details[$key]->SubCenterName;
			$updateSubcenterArr['PHC_id'] = $Subcenter_details[$key]->PHC_id;
			

			if($key==0)
			{
				$updateSubcenterArr['SubCenterName']	= $Subcenter_details[$key]->SubCenterName;
				$updateSubcenterArr['PHC_id']  = $Subcenter_details[$key]->PHC_id;
			}
		}

		$content['Subcenter_details'] = $updateSubcenterArr;

		$content['subview'] = "edit_subcenter";
		$this->load->view('auth/main_layout', $content);
	}
	
	function delete($subcentercode=null){

		$query = "update mstsubcenter set IsDeleted = 1	where SubCenterCode=$subcentercode";

		$this->db->query($query);
		$this->session->set_flashdata('tr_msg' ,"Subcenter Deleted Successfully");
		redirect('subcenter');
	}
	

}