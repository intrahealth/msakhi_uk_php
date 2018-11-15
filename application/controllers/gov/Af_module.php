<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AF_Module extends Gov_Controller {

	public function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{	
		$query = "select * from mstsubcenter where LanguageID =1 and IsDeleted = 0";
		$content['Subcentre_list'] = $this->db->query($query)->result();


		if (isset($_GET['SubCenterCode'])) {
			$SubCenterCode = trim($_GET['SubCenterCode']);
			$query = "select distinct mstcatchmentsupervisor.* from mstcatchmentsupervisor inner join mstasha on mstasha.CHS_ID = mstcatchmentsupervisor.CHS_ID where subcentercode=? and mstasha.languageid=1 and mstcatchmentsupervisor.languageid=1 and mstcatchmentsupervisor.IsDeleted = 0";
			$result = $this->db->query($query,[$SubCenterCode])->result();

		}else{
			$result = array();
		}
		$content['Af_Module_List'] = $result;

		$content['subview'] = "list_af_module";
		$this->load->view('gov/main_layout', $content);
	}

	public function export_csv($SubCenterCode = NULL)
	{		
		$query = "select distinct mstcatchmentsupervisor.* from mstcatchmentsupervisor inner join mstasha on mstasha.CHS_ID = mstcatchmentsupervisor.CHS_ID where mstasha.languageid=1 and mstcatchmentsupervisor.languageid=1 and mstcatchmentsupervisor.IsDeleted = 0";

		$this->load->model('Data_export_model');
		$this->Data_export_model->export_csv($query);
	}

	public function export_pdf()
	{

		$query = "select distinct mstcatchmentsupervisor.* from mstcatchmentsupervisor inner join mstasha on mstasha.CHS_ID = mstcatchmentsupervisor.CHS_ID where mstasha.languageid=1 and mstcatchmentsupervisor.languageid=1 and mstcatchmentsupervisor.IsDeleted = 0";

		$this->load->model('Data_export_model');
		$this->Data_export_model->export_pdf($query);
	}

	function add($subcenterId=null){

		$RequestMethod = $this->input->server('REQUEST_METHOD');
		if($RequestMethod == "POST"){
			
			$this->db->trans_start();
			
		// get the CHS_ID, This is the max(CHS_ID) column
			$query = "select max(CHS_ID) as CHS_ID from mstcatchmentsupervisor";
			$supervisorCod	=	$this->Common_Model->query_data($query);
			$CHS_ID = $supervisorCod[0]->CHS_ID;

			// get the SupervisorCode, This is the max(SupervisorCode) column
			$query = "select max(SupervisorCode) as SupervisorCode from mstcatchmentsupervisor";
			$supervisorCod	=	$this->Common_Model->query_data($query);
			$supervisorCode = $supervisorCod[0]->SupervisorCode;

		//Record For English LanguageID = 1

			$insertArr = array(
				'CHS_ID'				=> $CHS_ID,
				'SupervisorCode'		=>	$supervisorCode+1,
				'SupervisorName'		=>	$this->input->post('SupervisorNameEnglish'),
				'LanguageID'				=> 	1,
				'IsDeleted'					=>	0,
				);

			$this->db->insert('mstcatchmentsupervisor', $insertArr);
			
			//Record For Hindi LanguageID = 2
			$insertArr = array(
				'CHS_ID'  			=> $CHS_ID,
				'SupervisorCode' 		=> $supervisorCode+1,
				'SupervisorName'	  => $this->input->post('SupervisorNameHindi'),
				'LanguageID'   		  => 2,
				'IsDeleted'   			=> 0,
				);
			
			$this->db->insert('mstcatchmentsupervisor', $insertArr);

			$this->db->trans_complete();
			
			if ($this->db->trans_status() === FALSE){
				$this->session->set_flashdata('tr_msg', 'Error adding catchment Supervisor');					
			}else{
				$this->session->set_flashdata('tr_msg', 'Successfully added catchment Supervisor');			
			}
			
			redirect('gov/af_module');
		}

		$content['subview']="add_af_module";
		$this->load->view('gov/main_layout', $content);
	}
	
	function edit($supervisorCode=null){

		$RequestMethod = $this->input->server('REQUEST_METHOD');
		if($RequestMethod == "POST"){

			$this->db->trans_start();

			//Record for English LanguageID=1
			$updateArr = array(
				'SupervisorName'	=>	$this->input->post('SupervisorNameEnglish'),
				'LanguageID'		  =>	1,
				'IsDeleted'	      =>	0,
				);

			$this->db->where('SupervisorCode' , $supervisorCode);
			$this->db->where('LanguageID', 1);
			$this->db->update('mstcatchmentsupervisor', $updateArr);

			//Record for Hindi LanguageID=2
			$updateArr = array(
				'SupervisorName'			=>	$this->input->post('SupervisorNameHindi'),
				'LanguageID'					=>	2,
				'IsDeleted'						=>	0,
				);

			$this->db->where('SupervisorCode' , $supervisorCode);
			$this->db->where('LanguageID', 2);
			$this->db->update('mstcatchmentsupervisor' , $updateArr);

			$this->db->trans_complete();

			$this->session->set_flashdata('tr_msg', 'Successfully updated Catchment Supervisor');

			if ($this->db->trans_status() === FALSE){
				$this->session->set_flashdata('tr_msg', 'Error adding Catchment Supervisor');					
			}else{
				$this->session->set_flashdata('tr_msg', 'Successfully added Catchment Supervisor');			
			}

			redirect('gov/af_module');
		}

		$query = "select * from mstcatchmentsupervisor where SupervisorCode=$supervisorCode and IsDeleted=0";
		$Af_Module_Details = $this->Common_Model->query_data($query);

		if(count($Af_Module_Details) < 1){
			$this->session->set_flashdata('er_msg', 'The record does not exist / permission denied. Please contact your system administrator.');
			redirect('gov/af_module');
		}

		$updateAf_moduleArr= array();

		foreach ($Af_Module_Details as $key =>$val) 
		{

			if( $Af_Module_Details[$key]->LanguageID ==1)

				$updateAf_moduleArr['SupervisorNameEnglish']	= $Af_Module_Details[$key]->SupervisorName;

			if($Af_Module_Details[$key]->LanguageID==2)

				$updateAf_moduleArr['SupervisorNameHindi']	= $Af_Module_Details[$key]->SupervisorName;


			if($key==0)
			{
				$updateAf_moduleArr['SupervisorName']		= 	$Af_Module_Details[$key]->SupervisorName;
			}
		}
		$content['Af_Module_Details'] = $updateAf_moduleArr;

		$content['subview']="edit_af_module";
		$this->load->view('gov/main_layout', $content);
	}

	function delete($supervisorCode=null){

		$query = "update mstcatchmentsupervisor
		set IsDeleted = 1
		where SupervisorCode=$supervisorCode";

		$this->db->query($query);
		$this->session->set_flashdata('tr_msg' ,"Catchment Supervisor Deleted Successfully");
		redirect('gov/af_module');
	}

} 
