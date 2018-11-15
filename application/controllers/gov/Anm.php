<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Anm extends Gov_Controller {

	public function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{	
		$query = "select * from mstanm where LanguageID = 1 and IsDeleted = 0";
		$content['anm_list'] = $this->Common_Model->query_data($query);
		
		$content['subview'] = "list_anm";
		$this->load->view('gov/main_layout', $content);
	}

	public function export_csv()
	{
		$query = "select * from mstanm where LanguageID = 1 and IsDeleted = 0";
		$this->load->model('Data_export_model');
		$this->Data_export_model->export_csv($query);
	}

	public function export_pdf()
	{
		$query = "select * from mstanm where LanguageID = 1 and IsDeleted = 0";
		$this->load->model('Data_export_model');
		$this->Data_export_model->export_pdf($query);
	}

	function add($id = null)
	{
		
		$RequestMethod = $this->input->server('REQUEST_METHOD');
		if($RequestMethod == "POST"){

			$this->db->trans_start();

			// get the anmid, this is the max(ANMID) column
			$query = "select max(ANMID) as ANMID from mstanm";
			$anmRec = $this->Common_Model->query_data($query);
			$anmid = $anmRec[0]->ANMID;
			
			$query = "select max(ANMCode) as ANMCode from mstanm";
			$anmrc = $this->Common_Model->query_data($query);
			$anmcode = $anmrc[0]->ANMCode;

			// record for English, languageID=1
			$insertArr = array(
				'ANMID'				=>	$anmid+1,
				'ANMCode'			=>	 $anmcode+1,
				'ANMName'			=>	$this->input->post('ANMNameEnglish'),
				'LanguageID'	=> 	1,
				'IsDeleted'		=>	0,
				);

			$this->Common_Model->insert_data('mstanm', $insertArr);
			
			// record for Hindi, languageID=2
			$insertArr = array(
				'ANMID'				=>	$anmid+1,
				'ANMCode'			=>	$anmcode+1,
				'ANMName'			=>	$this->input->post('ANMNameHindi'),
				'LanguageID'	=> 	2,
				'IsDeleted'		=>	0,
				);
			
			$this->Common_Model->insert_data('mstanm', $insertArr);
			
			$this->db->trans_complete();
			
			if ($this->db->trans_status() === FALSE){
				$this->session->set_flashdata('tr_msg', 'Error adding Anm');					
			}else{
				$this->session->set_flashdata('tr_msg', 'Successfully added Anm');			
			}

			redirect('gov/anm');
		}

		$content['subview']="add_anm";
		$this->load->view('gov/main_layout', $content);
	}
	

	function edit($anmcode=null , $id=null ,$ANMUID = null)
	{

		$RequestMethod = $this->input->server('REQUEST_METHOD');
		if($RequestMethod == "POST"){
			
			if(!isset($_GET['step'])){
				// die('no setp selected');
			}
			
			$this->db->trans_start();

			//Record For English , LaguageId=1
			$updateArr = array(
				
				'ANMName'			=>	$this->input->post('ANMNameEnglish'),
				'LanguageID'	=>  1,
				'IsDeleted'	  => 0,
				);
			
			$this->db->where('ANMCode', $anmcode);
			$this->db->where('LanguageID', 1);
			$this->db->update('mstanm', $updateArr);

			
			//Record For Hindi , LanguageID= 2
			$updateArr = array(
				
				'ANMName'			=>	$this->input->post('ANMNameHindi'),
				'LanguageID'	=>  2,
				'IsDeleted'		=> 0,
				);
			
			$this->db->where('ANMCode', $anmcode);
			$this->db->where('LanguageID', 2);
			$this->db->update('mstanm', $updateArr);

			$this->db->trans_complete();

			$this->session->set_flashdata('tr_msg', 'Successfully updated anm');

			$this->db->trans_complete();
			
			if ($this->db->trans_status() === FALSE){
				$this->session->set_flashdata('tr_msg', 'Error Edit Anm');					
			}else{
				$this->session->set_flashdata('tr_msg', 'Successfully Edit Anm');			
			}
			
			redirect('gov/anm');
		}

		$query = "SELECT * FROM mstanm where ANMCode = $anmcode and IsDeleted = 0";
		$Anm_details = $this->Common_Model->query_data($query);
		//print_r($query); die();
		
		
		if(count($Anm_details) < 1){
			$this->session->set_flashdata('er_msg', 'The record does not exist / permission denied. Please contact your system govistrator.');
			redirect('gov/anm');
		}

		$updateAnmArr= array();

		foreach ($Anm_details as $key =>$val) 
		{

			if( $Anm_details[$key]->LanguageID ==1)
				$updateAnmArr['ANMNameEnglish']	= $Anm_details[$key]->ANMName;

			if($Anm_details[$key]->LanguageID==2)
				$updateAnmArr['ANMNameHindi']	= $Anm_details[$key]->ANMName;

			if($key==0)
			{
				$updateAnmArr['ANMName']	= $Anm_details[$key]->ANMName;
			}
		}
		
		$content['Anm_details'] = $updateAnmArr;
		$content['subview']="edit_anm";
		$this->load->view('gov/main_layout', $content);		
	}
	
	function delete($ANMCode = NULL)
	{
		$query =  "update mstanm set IsDeleted = 1 where ANMCode=$ANMCode ";
		$this->db->query($query);
		$this->session->set_flashdata('tr_msg' ,"Anm Deleted Successfully");
		redirect('gov/anm');
	}
	
}