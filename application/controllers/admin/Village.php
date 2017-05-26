<?php
class Village extends Admin_Controller {


	public function __construct(){
		parent::__construct();
	}
	

	function index() {


		$query = "select * from mststate where LanguageID=1 and IsDeleted = 0";
		$content['State_List'] = $this->Common_Model->query_data($query);

		$RequestMethod = $this->input->server('REQUEST_METHOD');
		if($RequestMethod == "POST")
		{
			$query = "select * from mstdistrict where StateCode=".$this->input->post('StateCode')." and LanguageID=1 and IsDeleted = 0";
			$content['District_List'] = $this->Common_Model->query_data($query);
			
			$query = "select * from mstblock where DistrictCode=".$this->input->post('DistrictCode')." and LanguageID=1 and IsDeleted=0";
			$content['Block_List'] = $this->Common_Model->query_data($query);
			
			$query = "select * from mstpanchayat where BlockCode=".$this->input->post('BlockCode')." and LanguageID=1 and IsDeleted=0";
			$content['Panchayat_List'] = [];
			
			$query = "select * from mstvillage where StateCode = ".$this->input->post('StateCode')." and LanguageID=1 and IsDeleted=0 ";
			$content['Village_List'] = $this->Common_Model->query_data($query);
			
			// print_r($content);
			// print_r($_POST);
			// die();
			
		}else{
			$content['District_List'] = array();
			$content['Block_List'] = array();
			$content['Panchayat_List'] = array();
			$content['Village_List'] = array();
		}
		
		$content['subview']="list_village";
		$this->load->view('admin/main_layout', $content);
		
	}

	public function export_csv($StateCode = NULL , $DistrictCode = NULL , $BlockCode = NULL ,$PanchayatCode = NULL)
	{		
		$query = "select * from mstvillage where StateCode = $StateCode and DistrictCode = $DistrictCode and BlockCode = $BlockCode and PanchayatCode = $PanchayatCode and  LanguageID = 1 and IsDeleted = 0";

		$this->load->model('Data_export_model');
		$this->Data_export_model->export_csv($query);
	}

	public function export_pdf($StateCode = NULL , $DistrictCode = NULL , $BlockCode = NULL , $PanchayatCode = NULL)
	{
		$query = "select * from mstvillage where StateCode = $StateCode and DistrictCode = $DistrictCode and BlockCode = $BlockCode and PanchayatCode = $PanchayatCode and LanguageID = 1 and IsDeleted = 0";

		$this->load->model('Data_export_model');
		$this->Data_export_model->export_pdf($query);
	}
	
	function add(){

		$RequestMethod = $this->input->server('REQUEST_METHOD');
		if($RequestMethod == "POST"){
			
			
			$this->db->trans_start();

			$StateCode = $this->input->get('StateCode');
			$DistrictCode = $this->input->get('DistrictCode');
			$BlockCode	=	$this->input->get('BlockCode');
			$PanchayatCode	=	$this->input->get('PanchayatCode');

		//Get the VillageID , this is the max (VillageID) column
			$query = "select max(VillageID) as VillageID from mstvillage";
			$villageidRec = $this->Common_Model->query_data($query);
			$villageid = $villageidRec[0]->VillageID;

		//Get the 	VillageCode , This is the max (VillageCode) column
			$query = "select max(VillageCode) as VillageCode from mstvillage";
			$villagecodeRec	=	$this->Common_Model->query_data($query);
			$villagecode =	$villagecodeRec[0]->VillageCode;

							// Record For English LanguageID=1
			$insertArr = array(
				'StateCode'	=> $StateCode,
				'DistrictCode'	=>	$DistrictCode,
				'BlockCode'	=>	$BlockCode,
				'PanchayatCode'	=>	$PanchayatCode,
				'VillageID'		=>	$villageid+1,
				'VillageCode'			=>	$villagecode+1,
				'VillageName'			=>	$this->input->post('VillageNameEnglish'),
				'LanguageID'		=> 1,
				'IsDeleted'	=>	0,
				);
			
			$this->Common_Model->insert_data('mstvillage', $insertArr);
			
				// Record For English LanguageID=2
			$insertArr	=	array(
				'StateCode'	=>$StateCode,
				'DistrictCode'=>	$DistrictCode,
				'BlockCode'	=>	$BlockCode,
				'PanchayatCode'	=> $PanchayatCode,
				'VillageID'			=> $villageid+1,
				'VillageCode'	=>	$villagecode+1,
				'VillageName'	=> $this->input->post('VillageNameHindi'),
				'LanguageID'	=>	2,
				'IsDeleted'		=>	0,
				);
			$this->Common_Model->insert_data('mstvillage' , $insertArr);
			
			$this->session->set_flashdata('tr_msg', 'Successfully added village');

			$this->db->trans_complete();
			
			if ($this->db->trans_status() === FALSE){
				$this->session->set_flashdata('tr_msg', 'Error adding Village');					
			}else{
				$this->session->set_flashdata('tr_msg', 'Successfully added Village');			
			}
			
			redirect('admin/village');
		}
		
		$content['subview']="add_village";
		$this->load->view('admin/main_layout', $content);
	}
	
	function edit($villagecode = null){

		$RequestMethod = $this->input->server('REQUEST_METHOD');
		if($RequestMethod == "POST"){
			
			
			if(!isset($_GET['step'])){
			//die('No Step Selected');
			}
			
			$this->db->trans_start();

	//Record For English LanguageID = 1
			$updateArr	=	array(
				'VillageName'	=>	$this->input->post('VillageNameEnglish'),
				'LanguageID'	=>	1,
				'IsDeleted'	=>	0,
				);

			$this->db->where('VillageCode' , $villagecode);
			$this->db->where('LanguageID' , 1);
			$this->db->update('mstvillage' , $updateArr);


		//Record For HIndi LanguageID	=	2
			$updateArr	=	array(
				'VillageName'	=>	$this->input->post('VillageNameHindi'),
				'LanguageID'	=>	2,
				'IsDeleted'=>	0,
				);
			
			$this->db->where('VillageCode' , $villagecode);
			$this->db->where('LanguageID' , 2);
			$this->db->update('mstvillage' , $updateArr);
			
			$this->db->trans_complete();
			$this->session->set_flashdata('tr_msg', 'Successfully updated village');

			
			if ($this->db->trans_status() === FALSE){
				$this->session->set_flashdata('tr_msg', 'Error adding Anm');					
			}else{
				$this->session->set_flashdata('tr_msg', 'Successfully added Anm');			
			}
			
			redirect('admin/village');
		}

		$query = "select * from mstvillage where VillageCode=$villagecode and IsDeleted=0";
		
		$Village_details = $this->Common_Model->query_data($query);
		
		if(count($Village_details) < 1){
			$this->session->set_flashdata('er_msg', 'The record does not exist / permission denied. Please contact your system administrator.');
			redirect('village');
		}

		$updateVillageArr= array();

		foreach ($Village_details as $key =>$val) 
		{

			if( $Village_details[$key]->LanguageID ==1)
				$updateVillageArr['VillageNameEnglish']	= $Village_details[$key]->VillageName;

			if($Village_details[$key]->LanguageID==2)
				$updateVillageArr['VillageNameHindi']	= $Village_details[$key]->VillageName;

			if($key==0)
			{
				$updateVillageArr['VillageName'] = 	$Village_details[$key]->VillageName;
			}
		}
		
		$content['Village_details'] = $updateVillageArr;

		$content['subview']="edit_village";
		$this->load->view('admin/main_layout', $content);
		
		
	}
	
	function delete($villagecode =  NULL){

		$query = "update mstvillage set IsDeleted=1 where VillageCode=$villagecode";

		$this->db->query($query);
		$this->session->set_flashdata('tr_msg' ,"Village Deleted Successfully");
		redirect('admin/Village');
	}
	

}