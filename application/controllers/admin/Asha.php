<?php
class Asha extends Admin_Controller {


	public function __construct(){
		parent::__construct();
	}
	

	function index() 
	{	
		$query	=	"select * from mstasha where LanguageID=1 and IsDeleted=0";
		$content['Asha_list']	=	$this->Common_Model->query_data($query);

		$content['subview']="list_asha";
		$this->load->view('admin/main_layout', $content);
	}

	public function export_csv()
	{
		$query = "select * from mstasha where LanguageID = 1 and IsDeleted = 0";
		$this->load->model('Data_export_model');
		$this->Data_export_model->export_csv($query);
	}

	public function export_pdf()
	{
		$query = "select * from mstasha where LanguageID = 1 and IsDeleted = 0";
		$this->load->model('Data_export_model');
		$this->Data_export_model->export_pdf($query);
	}
	
	function add()
	{

		$query = "select * from mststate where LanguageID=1 and IsDeleted = 0";
		$content['State_List'] = $this->Common_Model->query_data($query);

		$query = "select * from mstvillage where LanguageID = 1 and IsDeleted = 0";
		$content['Village_List'] = $this->Common_Model->query_data($query);

		$query = "select * from mstcatchmentsupervisor where LanguageID = 1 and IsDeleted = 0";
		$content['Supervisor_List'] = $this->Common_Model->query_data($query);

		$RequestMethod = $this->input->server('REQUEST_METHOD');

		if($RequestMethod == "POST")
		{

			$query = "select * from mstdistrict where StateCode=".$this->input->post('StateCode')." and LanguageID=1 and IsDeleted = 0";
			$content['District_List'] = $this->Common_Model->query_data($query);

			$query = "select * from mstblock where DistrictCode=".$this->input->post('DistrictCode')." and LanguageID=1 and IsDeleted=0";
			$content['Block_List'] = $this->Common_Model->query_data($query);

			$query = "select * from mstsubcenter where SubCenterID=".$this->input->post('SubCenterID')." and LanguageID = 1 and IsDeleted = 0";
			$content['Subcenter_List'] = $this->Common_Model->query_data($query);

			$query = "select * from mstanm where ANMID = ".$this->input->post('ANMID')."
			and LanguageID = 1 and IsDeleted = 0";
			$content['Anm_List'] = $this->Common_Model->query_data($query);

			$query = "select * from mstphc where PHC_id = ".$this->input->post('PHC_id')."
			and LanguageID = 1 and IsDeleted = 0";
			$content['PHC_List'] = $this->Common_Model->query_data($query);

			$this->db->trans_start();


		//Get the ASHAID, THis is the max(ASHAID) column
			$query	="select max(ASHAID) as ASHAID from mstasha";
			$ashaList =$this->Common_Model->query_data($query);
			$ashaId	 =	$ashaList[0]->ASHAID;

			//Get the AshaCode, THis is the max(ASHACode) column
			$query =	"select max(ASHACode) as ASHACode from mstasha";
			$ashaRec	=	$this->Common_Model->query_data($query);
			$ashaCode	=	$ashaRec[0]->ASHACode;

			$insertArr = array(

				'ASHAID'				=>	$ashaId+1,
				'ASHACode'			=> 	$ashaCode+1,
				'ANMCode'				=> 	$this->input->post('ANMID'),
				'SubCenterCode'	=>	$this->input->post('SubCenterID'),
				'VillageCode'		=>	$this->input->post('VillageCode'),
				'ASHAName'			=> 	$this->input->post('AshaNameEnglish'),
				'CHS_ID'				=>	$this->input->post('CHS_ID'),
				'LanguageID'		=>  1,
				'IsDeleted'			=>  0,

				);

			$this->Common_Model->insert_data('mstasha', $insertArr);

	//Get the ASHAID, THis is the max(ASHAID) column
			$query	="select max(ASHAID) as ASHAID from mstasha";
			$ashaList =$this->Common_Model->query_data($query);
			$ashaId	 =	$ashaList[0]->ASHAID;

			//Get the AshaCode, THis is the max(ASHACode) column
			$query =	"select max(ASHACode) as ASHACode from mstasha";
			$ashaRec	=	$this->Common_Model->query_data($query);
			$ashaCode	=	$ashaRec[0]->ASHACode;



			$insertArr	=	array(
			//Record for Hindi LanguageID = 1

				'ASHAID'				=>	$ashaId+1,
				'ASHACode'			=> 	$ashaCode+1,
				'ANMCode'				=> 	$this->input->post('ANMID'),
				'SubCenterCode'	=>	$this->input->post('SubCenterID'),
				'VillageCode'		=>	$this->input->post('VillageCode'),				
				'ASHAName'			=> 	$this->input->post('AshaNameHindi'),
				'CHS_ID'				=>	$this->input->post('CHS_ID'),
				'LanguageID'		=> 2,
				'IsDeleted'			=> 0,
				);

			$this->Common_Model->insert_data('mstasha', $insertArr);

			//record added anmasha
			$insertArrAshaAnm	=	array(
				'ANMID'					=>	$this->input->post('ANMID'),
				'ASHAID'				=>	$ashaId+1,
				);

			$this->Common_Model->insert_data('anmasha',$insertArrAshaAnm);

		// Create New Asha User Name
			$insertUser	=array(				
				'phone_no'			=>	$this->input->post('phone_no'),
				'user_id'				=>  $ashaId+1,
				'user_name'			=>	'asha',
				'email'					=>	$this->input->post('email'),
				'password'			=>	md5(1234),
				'state_code' 		=>  $this->input->post('StateCode'),
				'district_code' =>  $this->input->post('DistrictCode'),
				'block_code'  	=>  $this->input->post('BlockID'),
				'user_role'			=>	'4',
				'is_deleted'		=>	'0',
				'user_type'			=>	'Transaction',
				'created_by'		=>	'',
				'created_on'		=>	date("Y-m-d H:i:s")

				);

			$this->Common_Model->insert_data('tblusers',$insertUser);

			$last_id = $this->db->insert_id();
			$username="asha$last_id";
			$updateUserArr = array('user_name' => $username);

			$this->db->where('id',$last_id);
			$this->db->update('tblusers',$updateUserArr);


			$this->db->trans_complete();

			//$this->session->set_flashdata('tr_msg', 'Successfully added asha');

			if ($this->db->trans_status() === FALSE){
				$this->session->set_flashdata('tr_msg', 'Error adding asha');					
			}else{
				$this->session->set_flashdata('tr_msg', "Successfully added asha 
					username:-  $username ");			
			}

			redirect('admin/asha');
		}


		$content['subview']="add_asha";
		$this->load->view('admin/main_layout', $content);
	}

	function edit($ashaID=null, $ashaCode=NULL, $villageId=null)
	{

		$query = "select * from mststate where LanguageID=1 and IsDeleted = 0";
		$content['State_List'] = $this->Common_Model->query_data($query);

		$query = "select * from mstvillage where LanguageID = 1 and IsDeleted = 0";
		$content['Village_List'] = $this->Common_Model->query_data($query);

		$query = "select * from mstcatchmentsupervisor where LanguageID = 1 and IsDeleted = 0";
		$content['Supervisor_List'] = $this->Common_Model->query_data($query);

		$RequestMethod = $this->input->server('REQUEST_METHOD');
		if($RequestMethod == "POST")
		{


			$this->db->trans_start();

			//Record   for English LanguageID=1
			$updateArr = array(
				'ANMCode'				=> 	$this->input->post('ANMID'),
				'SubCenterCode'	=>	$this->input->post('SubCenterID'),
				'VillageCode'		=>	$this->input->post('VillageCode'),				
				'ASHAName'			=> 	$this->input->post('AshaNameEnglish'),
				'CHS_ID'				=>	$this->input->post('CHS_ID'),
				'LanguageID'		=> 	1,
				'IsDeleted'			=> 	0,				
				);

			$this->db->where('ASHACode' , $ashaCode);
			$this->db->where('LanguageID', 1);
			$this->db->update('mstasha', $updateArr);

			//Record for Hindi LanguageID=2

			$updateArr	=	array(
				'ANMCode'				=>	$this->input->post('ANMID'),
				'SubCenterCode'	=>	$this->input->post('SubCenterID'),
				'VillageCode'		=>	$this->input->post('VillageCode'),
				'ASHAName'			=>	$this->input->post('AshaNameHindi'),
				'CHS_ID'				=>	$this->input->post('CHS_ID'),
				'LanguageID'		=>	2,
				'IsDeleted'			=>	0,
				);

			$this->db->where('ASHACode' ,  $ashaCode);
			$this->db->where('LanguageID' , 2);
			$this->db->update('mstasha' , $updateArr);

		// Update User Details
			$updateUser	=array(

				'phone_no'			=>	$this->input->post('phone_no'),				
				'email'					=>	$this->input->post('email'),
				'password'			=>	md5(1234),
				'state_code' 		=>  $this->input->post('StateCode'),
				'district_code' =>  $this->input->post('DistrictCode'),
				'block_code'  	=>  $this->input->post('BlockID'),
				'user_role'			=>	'4',
				'is_deleted'		=>	'0',
				'user_type'			=>	'Transaction',
				'created_by'		=>	'',
				'created_on'		=>	date("Y-m-d H:i:s")
				);


			$this->db->where('id',$last_id);
			$this->db->update('tblusers',$updateUserArr);

			$query = "select * from mstdistrict where StateCode=".$this->input->post('StateCode')." and LanguageID=1 and IsDeleted = 0";
			$content['District_List'] = $this->Common_Model->query_data($query);

			$query = "select * from mstblock where DistrictCode=".$this->input->post('DistrictCode')." and LanguageID=1 and IsDeleted=0";
			$content['Block_List'] = $this->Common_Model->query_data($query);

			$query = "select * from mstsubcenter where SubCenterID=".$this->input->post('SubCenterID')." and LanguageID = 1 and IsDeleted = 0";
			$content['Subcenter_List'] = $this->Common_Model->query_data($query);

			$query = "select * from mstanm where ANMID = ".$this->input->post('ANMID')."
			and LanguageID = 1 and IsDeleted = 0";
			$content['Anm_List'] = $this->Common_Model->query_data($query);

			$query = "select * from mstphc where PHC_id = ".$this->input->post('PHC_id')."
			and LanguageID = 1 and IsDeleted = 0";
			$content['PHC_List'] = $this->Common_Model->query_data($query);


       //update anmasha associated with this asha
		  // first delete records of all added in anmasha
			$query = "delete from anmasha where ANMID = $ANMID";
			$this->db->query($query);

			$insertArrAshaAnm	=	array(
				'ANMID'					=>	$this->input->post('ANMID'),
				'ASHAID'				=>	$ashaId+1,
				);


			$this->db->trans_complete();

			$this->session->set_flashdata('tr_msg', 'Successfully updated asha');

			if ($this->db->trans_status() === FALSE){
				$this->session->set_flashdata('tr_msg', 'Error a edit Asha');					
			}else{
				$this->session->set_flashdata('tr_msg', 'Successfully edit Asha');			
			}

			redirect('admin/asha');
		}

	/*		$query = "select mstanm.ANMName,
			mstasha.ASHAUID,mstasha.ASHAID,mstasha.ANMCode,mstasha.SubCenterCode,mstsubcenter.SubCenterName,mstasha.ASHACODE,
			mstasha.ASHAName,mstasha.LanguageID, mstasha.CHS_ID, GROUP_CONCAT(mstvillage.VillageID,'-',mstvillage.VillageName) as VillageName,
			GROUP_CONCAT(mstvillage.VillageID) as VillageID , tblusers.user_name,tblusers.email,tblusers.phone_no,tblusers.id,anmasha.ANMID 
			from mstasha,ashavillage,tblusers,anmasha,mstvillage,mstsubcenter,mstanm
			where mstasha.ASHAID = $ashaID
			and tblusers.user_id=$ashaID
			and ashavillage.ASHAID=$ashaID
			and ashavillage.ASHAID=$ashaID
			and anmasha.ASHAID=$ashaID
			and mstvillage.VillageID=ashavillage.VillageID 
			and mstanm.ANMID=anmasha.ANMID
			and mstvillage.LanguageID=1 
			and mstanm.LanguageID=1
			and mstsubcenter.LanguageID=1 
			and mstsubcenter.SubCenterCode=mstasha.SubCenterCode
			group BY  mstasha.LanguageID";*/

			$query ="select mstasha.`ANMCode` , mstasha.ANMCode ,mstasha.SubCenterCode ,mstasha.ASHAName,mstasha.VillageCode,mstasha.ASHACode,tblusers.user_name,tblusers.email,tblusers.password,tblusers.password,tblusers.phone_no  FROM mstasha INNER join userashamapping on mstasha.ASHAID = userashamapping.AshaID and mstasha.LanguageID=1
			INNER JOIN tblusers on tblusers.user_id= userashamapping.UserID
			INNER JOIN anmasha on anmasha.ASHAID = mstasha.ASHAID WHERE mstasha.LanguageID=1";

			$Asha_details = $this->Common_Model->query_data($query);

			if(count($Asha_details) < 1){
				$this->session->set_flashdata('er_msg', 'The record does not exist / permission denied. Please contact your system administrator.');
				redirect('admin/asha');

			}

			$updateAshaArr= array();

			foreach ($Asha_details as $key =>$val) 
			{

				if( $Asha_details[$key]->LanguageID ==1)
					$updateAshaArr['AshaNameEnglish']	= $Asha_details[$key]->ASHAName;

				if($Asha_details[$key]->LanguageID ==2)
					$updateAshaArr['AshaNameHindi']	= $Asha_details[$key]->ASHAName;

				if($key==0)
				{
					$updateAshaArr['ASHAName']	= $Asha_details[$key]->ASHAName;
				}
			}

			$content['Asha_details'] = $updateAshaArr;

			//print_r($content['Asha_details']); die();

			$content['subview']="edit_asha";
			$this->load->view('admin/main_layout',$content);
		}

		function delete($ashaCode=null){

			$query =  "update mstasha set IsDeleted = 1 where ASHACode=$ashaCode";

			$this->db->query($query);
			$this->session->set_flashdata('tr_msg' ,"Asha Deleted Successfully");
			redirect('asha');
		}


	}