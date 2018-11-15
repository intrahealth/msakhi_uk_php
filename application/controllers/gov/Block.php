<?php
class Block extends Gov_Controller {


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
			
			$query = "select * from mstblock where DistrictCode =".$this->input->post('DistrictCode')." and IsDeleted=0 "." and LanguageID=1";
			$content['Block_List'] = $this->Common_Model->query_data($query);
			
		}else{
			$content['District_List'] = array();
			$content['Block_List'] = array();
			
		}
		
		$content['subview']="list_block";
		$this->load->view('gov/main_layout', $content);
	}

	public function export_csv($StateCode = NULL , $DistrictCode = NULL)
	{		
		$query = "select * from mstblock where StateCode = $StateCode and DistrictCode = $DistrictCode and LanguageID = 1 and IsDeleted = 0";

		$this->load->model('Data_export_model');
		$this->Data_export_model->export_csv($query);
	}

	public function export_pdf($StateCode = NULL , $DistrictCode = NULL)
	{
		$query = "select * from mstblock where StateCode = $StateCode and DistrictCode = $DistrictCode and LanguageID = 1 and IsDeleted = 0";

		$this->load->model('Data_export_model');
		$this->Data_export_model->export_pdf($query);
	}

	function add($StateCode = NULL, $DistrictCode = NULL){

		$RequestMethod = $this->input->server('REQUEST_METHOD');
		if($RequestMethod == "POST"){

			$this->db->trans_start();

			$StateCode = $this->input->get('StateCode');
			$DistrictCode = $this->input->get('DistrictCode');

			//Get the BlockCode, THis is the max(BlockCode) column
			$sql=	"select max(BlockCode) as BlockCode from mstblock";
			$blockLis	=	$this->Common_Model->query_data($sql);
			$blockcode	=	$blockLis[0]->BlockCode;


		//Record For English LanguageID = 1

			$insertArr = array(
				'StateCode'			=>	$StateCode,
				'DistrictCode'  =>	$DistrictCode,
				'BlockCode'			=>	$blockcode+1,
				'BlockName'			=>	$this->input->post('BlockNameEnglish'),
				'LanguageID'		=>  1,
				'IsDeleted'			=>  0,

				);
		// print_r($insertArr); die();			
			$this->Common_Model->insert_data('mstblock', $insertArr);

			//Record For Hindi LanguageID=2
			$insertArr = array(
				'StateCode'			=>	$StateCode,
				'DistrictCode'	=>	$DistrictCode,
				'BlockCode'			=>	$blockcode+1,
				'BlockName'			=>	$this->input->post('BlockNameHindi'),
				'LanguageID'		=>  2,
				'IsDeleted'			=>	0,

				);
			$this->Common_Model->insert_data('mstblock', $insertArr);

			$this->session->set_flashdata('tr_msg', 'Successfully added block');

			$this->db->trans_complete();

			if ($this->db->trans_status() === FALSE){
				$this->session->set_flashdata('tr_msg', 'Error adding Block');					
			}else{
				$this->session->set_flashdata('tr_msg', 'Successfully added BLock');			
			}
			redirect('gov/block');
		}

		$content['subview']="add_block";
		$this->load->view('gov/main_layout', $content);
	}

	function edit($blockcode = NULL){

		$RequestMethod = $this->input->server('REQUEST_METHOD');
		if($RequestMethod == "POST"){

			$this->db->trans_start();

			//Record for Enlish LanguageID=1
			$updateArr = array(				
				'BlockName'			=>	$this->input->post('BlockNameEnglish'),
				'LanguageID'		=> 	1,
				'IsDeleted'			=>	0,
				);

			$this->db->where('BlockCode' , $blockcode);
			$this->db->where('LanguageID' , 1);
			$this->db->update('mstblock' , $updateArr);


			//Record for Hindi LanguageID=2
			$updateArr = array(
				'BlockName'		=>	$this->input->post('BlockNameHindi'),
				'LanguageID'	=>	2,
				'IsDeleted'		=>	0,
				);

			$this->db->where('BlockCode' , $blockcode);
			$this->db->where('LanguageID' , 2);
			$this->db->update('mstblock' , $updateArr);


			$this->db->trans_complete();

			$this->session->set_flashdata('tr_msg', 'Successfully updated block');

			if ($this->db->trans_status() === FALSE){
				$this->session->set_flashdata('tr_msg', 'Error adding state');					
			}else{
				$this->session->set_flashdata('tr_msg', 'Successfully added state');			
			}
			redirect('gov/block');
		}

		$query = "select * from mstblock where BlockCode=$blockcode and IsDeleted=0";
		$Block_details = $this->Common_Model->query_data($query);

		if(count($Block_details) < 1){
			$this->session->set_flashdata('er_msg', 'The record does not exist / permission denied. Please contact your system govistrator.');
			redirect('gov/block');
		}

		$updateBlockArr = array();
		foreach ($Block_details as $key =>$val) 
		{

			if( $Block_details[$key]->LanguageID ==1)

				$updateBlockArr['BlockNameEnglish']	= $Block_details[$key]->BlockName;

			if($Block_details[$key]->LanguageID==2)

				$updateBlockArr['BlockNameHindi']	= $Block_details[$key]->BlockName;


			if($key==0)
			{
				$updateBlockArr['BlockName']	= $Block_details[$key]->BlockName;
			}
		}


		$content['Block_details'] = $updateBlockArr;
		$content['subview']="edit_block";
		$this->load->view('gov/main_layout', $content);


	}

	function delete($blockcode =  NULL){

		$sql = "update mstblock	set IsDeleted = 1	where	BlockCode=$blockcode";

		$this->db->query($sql);
		$this->session->set_flashdata('tr_msg' ,"Block Deleted Successfully");
		redirect('gov/block');
	}


}