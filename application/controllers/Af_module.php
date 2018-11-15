<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AF_Module extends Auth_controller {

	public function __construct()
	{
		parent::__construct();
        $this->loginData = $this->session->userdata('loginData');
	}
	
	function index($AfModule = ' ')
	{	
		// start permission 
		$user_role = $this->loginData->user_role;
		$query = "SELECT * FROM role_permissions as rp LEFT JOIN mstrole as mst on rp.RoleID=mst.RoleID WHERE rp.RoleID='$user_role' ";
		$content['role_permission'] = $this->Common_Model->query_data($query);
		// end permission 

         // get state list
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

		// $query = "select * from mstsubcenter where LanguageID =1 and IsDeleted = 0";
		// $content['Subcentre_list'] = $this->db->query($query)->result();


		if (isset($_GET['SubCenterCode'])) {
			$SubCenterCode = trim($_GET['SubCenterCode']);
			$query = "select distinct mstcatchmentsupervisor.* from mstcatchmentsupervisor inner join mstasha on mstasha.CHS_ID = mstcatchmentsupervisor.CHS_ID where subcentercode=? and mstasha.languageid=1 and mstcatchmentsupervisor.languageid=1 and mstcatchmentsupervisor.IsDeleted = 0";
			$result = $this->db->query($query,[$SubCenterCode])->result();

		}else{
			$result = array();
		}
		$content['Af_Module_List'] = $result;

		$content['subview'] = "list_af_module";


		if ($AfModule == "export_pdf") {
			$this->export_section($content);
			die();
		}

		$this->load->view('auth/main_layout', $content);
	}

	public function export_csv($SubCenterCode = NULL)
	{		
		$query = "select distinct mstcatchmentsupervisor.* from mstcatchmentsupervisor inner join mstasha on mstasha.CHS_ID = mstcatchmentsupervisor.CHS_ID where mstasha.languageid=1 and mstcatchmentsupervisor.languageid=1 and mstcatchmentsupervisor.IsDeleted = 0";

		$this->load->model('Data_export_model');
		$this->Data_export_model->export_csv($query);
	}

/*	public function export_pdf()
	{

		$query = "select distinct mstcatchmentsupervisor.* from mstcatchmentsupervisor inner join mstasha on mstasha.CHS_ID = mstcatchmentsupervisor.CHS_ID where mstasha.languageid=1 and mstcatchmentsupervisor.languageid=1 and mstcatchmentsupervisor.IsDeleted = 0";

		$this->load->model('Data_export_model');
		$this->Data_export_model->export_pdf($query);
	}*/

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
			
			redirect('auth/af_module');
		}

		$content['subview']="add_af_module";
		$this->load->view('auth/main_layout', $content);
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

			redirect('auth/af_module');
		}

		$query = "select * from mstcatchmentsupervisor where SupervisorCode=$supervisorCode and IsDeleted=0";
		$Af_Module_Details = $this->Common_Model->query_data($query);

		if(count($Af_Module_Details) < 1){
			$this->session->set_flashdata('er_msg', 'The record does not exist / permission denied. Please contact your system authistrator.');
			redirect('auth/af_module');
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

		
		$this->load->view('auth/main_layout', $content);
	}

	function delete($supervisorCode=null){

		$query = "update mstcatchmentsupervisor
		set IsDeleted = 1
		where SupervisorCode=$supervisorCode";

		$this->db->query($query);
		$this->session->set_flashdata('tr_msg' ,"Catchment Supervisor Deleted Successfully");
		redirect('auth/af_module');
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

} 
