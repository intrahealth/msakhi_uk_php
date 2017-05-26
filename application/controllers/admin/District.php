<?php
class District extends Admin_Controller {


	public function __construct(){
		parent::__construct();
	}
	

	function index() {

		// to fill the upper container
		$query = "select * from mststate where LanguageID = 1 and IsDeleted = 0";
		$content['State_list'] = $this->Common_Model->query_data($query);


		$RequestMethod = $this->input->server('REQUEST_METHOD');
		if($RequestMethod == "POST")
		{
			$query = "select * from mstdistrict where StateCode=".$this->input->post('StateCode')." and LanguageID=1 and IsDeleted = 0";
			$content['District_list'] = $this->Common_Model->query_data($query);		
			
		}else{
			$content['District_list'] = array();
			
		}
		
		$content['subview']="list_district";
		$this->load->view('admin/main_layout', $content);
	}

	public function export_csv($StateCode = NULL)
	{
		$query = "select * from mstdistrict where StateCode = $StateCode and LanguageID = 1 and IsDeleted = 0";
		$this->load->model('Data_export_model');
		$this->Data_export_model->export_csv($query);
	}

	public function export_pdf($StateCode = NULL)
	{
		$query = "select * from mstdistrict where StateCode = $StateCode and LanguageID = 1 and IsDeleted = 0";
		$this->load->model('Data_export_model');
		$this->Data_export_model->export_pdf($query);
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
			
			redirect('admin/district');
		}

		$content['subview']="add_district";
		$this->load->view('admin/main_layout', $content);
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
			
			redirect('admin/district');
		}
		
		$query = "select * from mstdistrict where DistrictCode=$districtcode and IsDeleted=0";
		$District_details = $this->Common_Model->query_data($query);

		if(count($District_details) < 1){
			$this->session->set_flashdata('er_msg', 'The record does not exist / permission denied. Please contact your system administrator.');
			redirect('admin/district');
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
		/*print_r($content['District_details']); die();*/
		$content['subview']="edit_district";
		$this->load->view('admin/main_layout', $content);
		
		
	}
	
	function delete($districtcode=null){

		$query = "update mstdistrict
		set IsDeleted = 1
		where DistrictCode=$districtcode";

		$this->db->query($query);
		$this->session->set_flashdata('tr_msg' ,"District Deleted Successfully");
		redirect('admin/district');
	}
	

}