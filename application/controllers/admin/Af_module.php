<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AF_Module extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{	
		$query = "select * from mstsubcenter where LanguageID =1 and IsDeleted = 0";
		$content['Subcentre_list'] = $this->Common_Model->query_data($query);

		if (isset($_GET['SubCenterID'])) {
			$SubCenterID = trim($_GET['SubCenterID']);
			$query = "select * from mstcatchmentsupervisor where SubCenterID = $SubCenterID and LanguageID = 1 and IsDeleted = 0";
			$result = $this->Common_Model->query_data($query);

		}else{
			$result = array();
		}
		$content['Af_Module_List'] = $result;

		$content['subview'] = "list_af_module";
		$this->load->view('admin/main_layout', $content);
	}

	public function export_csv($SubCenterID = NULL)
	{		
		$query = "select * from mstcatchmentsupervisor where LanguageID = 1 and IsDeleted = 0";

		$this->load->model('Data_export_model');
		$this->Data_export_model->export_csv($query);
	}

	public function export_pdf()
	{

		$query = "select * from mstcatchmentsupervisor  where  LanguageID = 1 and IsDeleted = 0";

		$this->load->model('Data_export_model');
		$this->Data_export_model->export_pdf($query);
	}

	function add($subcenterId=null){

		$RequestMethod = $this->input->server('REQUEST_METHOD');
		if($RequestMethod == "POST"){
			
			$this->db->trans_start();
			
		// get the SupervisorCode, This is the max(SupervisorCode) column
			$query = "select max(SupervisorCode) as SupervisorCode from mstcatchmentsupervisor";
			$supervisorCod	=	$this->Common_Model->query_data($query);
			$supervisorCode = $supervisorCod[0]->SupervisorCode;

		//Record For English LanguageID = 1

			$insertArr = array(
				'SubCenterID'				=> $subcenterId,
				'SupervisorCode'		=>	$supervisorCode+1,
				'SupervisorName'		=>	$this->input->post('SupervisorNameEnglish'),
				'LanguageID'				=> 	1,
				'IsDeleted'					=>	0,
				);

			$this->Common_Model->insert_data('mstcatchmentsupervisor', $insertArr);
			
			//Record For Hindi LanguageID = 2
			$insertArr = array(
				'SubCenterID'  			=> $subcenterId,
				'SupervisorCode' 		=> $supervisorCode+1,
				'SupervisorName'	  => $this->input->post('SupervisorNameHindi'),
				'LanguageID'   		  => 2,
				'IsDeleted'   			=> 0,
				);
			
			$this->Common_Model->insert_data('mstcatchmentsupervisor', $insertArr);
			
			$this->session->set_flashdata('tr_msg', 'Successfully added Catchment Supervisor');
			
			$this->db->trans_complete();
			
			if ($this->db->trans_status() === FALSE){
				$this->session->set_flashdata('tr_msg', 'Error adding catchment Supervisor');					
			}else{
				$this->session->set_flashdata('tr_msg', 'Successfully added catchment Supervisor');			
			}
			
			redirect('admin/af_module');
		}

		$content['subview']="add_af_module";
		$this->load->view('admin/main_layout', $content);
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

			redirect('admin/af_module');
		}

		$query = "select * from mstcatchmentsupervisor where SupervisorCode=$supervisorCode and IsDeleted=0";
		$Af_Module_Details = $this->Common_Model->query_data($query);

		if(count($Af_Module_Details) < 1){
			$this->session->set_flashdata('er_msg', 'The record does not exist / permission denied. Please contact your system administrator.');
			redirect('admin/af_module');
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
		$this->load->view('admin/main_layout', $content);
	}

	function delete($supervisorCode=null){

		$query = "update mstcatchmentsupervisor
		set IsDeleted = 1
		where SupervisorCode=$supervisorCode";

		$this->db->query($query);
		$this->session->set_flashdata('tr_msg' ,"Catchment Supervisor Deleted Successfully");
		redirect('admin/af_module');
	}
} 
