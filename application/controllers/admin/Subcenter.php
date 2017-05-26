<?php
class Subcenter extends Admin_Controller {


	public function __construct()
	{
		parent::__construct();
	}
	
	function index() {

		$query = "select * from mstsubcenter where IsDeleted=0 and LanguageID=1 ";
		$content['Subcenter_list'] = $this->Common_Model->query_data($query);

		$content['subview']="list_subcenter";
		$this->load->view('admin/main_layout', $content);

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

		$RequestMethod = $this->input->server('REQUEST_METHOD');
		if($RequestMethod == "POST"){

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

			redirect('admin/subcenter');
		}

		$content['subview']="add_subcenter";
		$this->load->view('admin/main_layout', $content);
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

			redirect('admin/subcenter');
		}

		$query = "select * from mstsubcenter where SubCenterCode=$subcentercode and IsDeleted=0";
		$Subcenter_details = $this->Common_Model->query_data($query);

		if(count($Subcenter_details) < 1){
			$this->session->set_flashdata('er_msg', 'The record does not exist / permission denied. Please contact your system administrator.');
			redirect('admin/subcenter');
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
		$this->load->view('admin/main_layout', $content);
	}
	
	function delete($subcentercode=null){

		$query = "update mstsubcenter set IsDeleted = 1	where SubCenterCode=$subcentercode";

		$this->db->query($query);
		$this->session->set_flashdata('tr_msg' ,"Subcenter Deleted Successfully");
		redirect('admin/subcenter');
	}
	

}