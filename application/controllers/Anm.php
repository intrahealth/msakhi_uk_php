'<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Anm extends Auth_controller {

	public function __construct()
	{
		parent::__construct();
		$this->loginData = $this->session->userdata('loginData');
	}
	public function index($AnmPDF = ' ')
	{	
		// permission start code
		$user_role = $this->loginData->user_role;
		$query = "SELECT * FROM role_permissions as rp LEFT JOIN mstrole as mst on rp.RoleID=mst.RoleID WHERE rp.RoleID='$user_role' ";
		$content['role_permission'] = $this->Common_Model->query_data($query); 

		$query = "select * from mststate where IsDeleted=0 and LanguageID = 1 ";
		if ($this->loginData->user_role == 1 || $this->loginData->user_role == 2 || $this->loginData->user_role == 3 || $this->loginData->user_role == 6 || $this->loginData->user_role == 7 || $this->loginData->user_role == 8 || $this->loginData->user_role == 10) 	 {
			$query .= "	and StateCode='".$this->loginData->state_code."' ";

			// add district based filter if district role
			if ($this->loginData->user_role == 7) {
				$query .= " and district_code ='".$this->loginData->district_code."' ";
			}
			// add district based filter if block role
			if ($this->loginData->user_role == 8) {
				$query .= " and block_code ='".$this->loginData->block_code."' ";
			}
		}
		$content['State_list'] = $this->Common_Model->query_data($query);

		// $query = "select * from mstanm where LanguageID = 1 and IsDeleted = 0";
		$RequestMethod = $this->input->server('REQUEST_METHOD');
		if($RequestMethod == "POST")
		{
			$query = "SELECT
			a.user_name,
			a.user_id,
			c.ANMCode,
			c.ANMName,
			c.ANMUID
			FROM
			tblusers a
			INNER JOIN useranmmapping b ON
			a.user_id = b.UserID
			INNER JOIN mstanm c ON
			b.ANMID = c.ANMID and c.LanguageID = 1
			WHERE
			a.state_code = '".$this->input->post('StateCode')."' group by ANMName";
// print_r($query); die();
			// print_r($query); die();

			$content['anm_list'] = $this->Common_Model->query_data($query);		
		}else{
			$content['anm_list'] = array();
		}

		//$content['anm_list'] = $this->Common_Model->query_data($query);

		$content['subview'] = "list_anm";

		if ($AnmPDF == "export_pdf") {
			$this->export_section($content);
			die();
		}
		$this->load->view('auth/main_layout', $content);
	}

	public function export_csv()
	{
		$query = "select ANMCode,ANMName,(CASE WHEN LanguageID = NULL THEN ' ' WHEN LanguageID = 1 THEN 'English' WHEN LanguageID = 2 THEN 'Hindi' END
	) AS LanguageID from mstanm where languageID = 1 and IsDeleted = 0";
	$this->load->model('Data_export_model');
	$this->Data_export_model->export_csv($query);

}

/*	public function export_pdf()
	{
		$query = "select * from mstanm where LanguageID = 1 and IsDeleted = 0";
		$this->load->model('Data_export_model');
		$this->Data_export_model->export_pdf($query);
	}*/

	function add($id = null)
	{
		
		$RequestMethod = $this->input->server('REQUEST_METHOD');
		if($RequestMethod == "POST"){

			$this->db->trans_start();

			// get the anmid, this is the max(ANMID) column
			$query = "select max(ANMID) as ANMID from mstanm where StateCode = ".$this->input->post('states');
			$anmRec = $this->Common_Model->query_data($query);
			$anmid = $anmRec[0]->ANMID;
			
			$query = "select max(ANMCode) as ANMCode from mstanm where StateCode = ".$this->input->post('states');
			$anmrc = $this->Common_Model->query_data($query);
			$anmcode = $anmrc[0]->ANMCode;

			// record for English, languageID=1
			$insertArr = array(
				'ANMID'				=>	$anmid+1,
				'ANMCode'			=>	 $anmcode+1,
				'ANMName'			=>	$this->input->post('ANMNameEnglish'),
				'LanguageID'	=> 	1,
				'IsDeleted'		=>	0,
				'StateCode'		=>	$this->input->post('states'),
			);

			$this->Common_Model->insert_data('mstanm', $insertArr);
			
			// record for Hindi, languageID=2
			$insertArr = array(
				'ANMID'				=>	$anmid+1,
				'ANMCode'			=>	$anmcode+1,
				'ANMName'			=>	$this->input->post('ANMNameHindi'),
				'LanguageID'	=> 	2,
				'IsDeleted'		=>	0,
				'StateCode'		=>	$this->input->post('states'),
			);
			
			$this->Common_Model->insert_data('mstanm', $insertArr);

			//anmsubcenter mapping

			$sql = "select SubCenterID from mstsubcenter where Languageid = 1 and subcentercode = ".$this->input->post('subcenter');
			$res_subcenter = $this->Common_Model->query_data($sql);

			$insertArr = array(
				'ANMID'         =>	$anmid+1,
				'SubCenterID'   =>	$res_subcenter[0]->SubCenterID,
				'SubCenterCode' =>	$this->input->post('subcenter'),
				'ANMName'       => 	$this->input->post('ANMNameEnglish')
			);
			
			$this->Common_Model->insert_data('anmsubcenter', $insertArr);	
			
			$this->db->trans_complete();
			
			if ($this->db->trans_status() === FALSE){
				$this->session->set_flashdata('tr_msg', 'Error adding Anm');					
			}else{
				$this->session->set_flashdata('tr_msg', 'Successfully added Anm');			
			}

			redirect('anm');
		}

		$this->db->where('LanguageID',1);
		$countries = $this->db->get('mstcountry');

		$content['countries'] = $countries->result();
		$content['subview']="add_anm";
		$this->load->view('auth/main_layout', $content);
	}
	

	function edit($anmUID=null)
	{

			// get the anmID from ANMCODE
		$this->db->where('ANMUID in ('.$anmUID.','.($anmUID+1).')');
		$result = $this->db->get('mstanm')->result();
		if (count($result) < 1) {
			$this->session->set_flashdata('er_msg', "No anm reference set for this ID");
			redirect('anm');
		}

		$anmID = $result[0]->ANMID;


//EXTRA CHARGE LIST IN EDIT

		$query = "select *,b.ANMName FROM tblextrachargeanm a 
		inner join mstanm b 
		on a.ChargeTo = b.ANMUID where b.LanguageID = 1 and b.ANMID=".$anmID." AND a.IsDeleted = 0 ";

		$content['extra_charge_list'] = $this->Common_Model->query_data($query);
		// die($query);

		foreach ($content['extra_charge_list'] as $nm ){
			$ChargeOf =  $nm->ChargeOf;
		}
		if(!empty($ChargeOf)){
			$query ="select * from tblextrachargeanm a inner join mstanm b on a.ChargeOf=b.ANMUID where a.ChargeTo= '".$anmUID."'  and a.IsDeleted = 0 ";
			$content['anm_name'] = $this->Common_Model->query_data($query);
		}


		$query = "SELECT * FROM mstanm where ANMID = $anmID and IsDeleted = 0 and IsActive = 1 ";
		$Anm_charge_details = $this->Common_Model->query_data($query);
		$content['Anm_charge_details'] = $Anm_charge_details;

		$this->db->where('ANMUID in ('.$anmUID.','.($anmUID+1).')');
		$Anm_details = $this->db->get('mstanm')->result();
		// $query = "SELECT * FROM mstanm where ANMCode = $anmcode and IsDeleted = 0 ";
		// $Anm_details = $this->Common_Model->query_data($query);
		$content['Anm_details'] = $Anm_details;


		//USER IMEI Number
		$query = "select * from tblusers a inner join useranmmapping b 
		on a.user_id = b.UserID inner join mstanm c on c.ANMID = b.ANMID where c.ANMID ='".$anmID."' and a.is_active = 1";

		$content['User_IMEI'] = $this->db->query($query)->result();

		foreach ($content['User_IMEI'] as $row) {
			$uid = $row->user_id;

		}

		$RequestMethod = $this->input->server('REQUEST_METHOD');
		if($RequestMethod == "POST"){
			// print_r($_POST); die();
			if(!isset($_GET['step'])){
				// die('no setp selected');
			}
			
			$this->db->trans_start();

			//Record For English , LaguageId=1
			$updateArr = array(
				
				'ANMName'			=>	$this->input->post('ANMNameEnglish'),
				'LeaveStatus'      => 	$this->input->post('LeaveStatus'),
				'LastWorkingDate'      => 	$this->input->post('LastWorkingDate'),
				'LanguageID'	=>  1,
				'IsDeleted'	  => 0,
				'IsActive'    => 	$this->input->post('IsActive'),
			);


			
			$this->db->where('ANMUID', $anmUID);
			$this->db->where('LanguageID', 1);
			$this->db->update('mstanm', $updateArr);

			
			//Record For Hindi , LanguageID= 2
			$updateArr = array(
				
				'ANMName'			=>	$this->input->post('ANMNameHindi'),
				'LeaveStatus'      => 	$this->input->post('LeaveStatus'),
				'LastWorkingDate'      => 	$this->input->post('LastWorkingDate'),
				'LanguageID'	=>  2,
				'IsDeleted'		=> 0,
				'IsActive'    => 	$this->input->post('IsActive'),
			);
			$this->db->where('ANMUID', $anmUID);
			$this->db->where('LanguageID', 2);
			$this->db->update('mstanm', $updateArr);

			//update IMEI Number in tblusers
			
			$updateArray = array(
				'imei1'     => $this->input->post('imei1'),
				'imei2'         => $this->input->post('imei2'),
			);
			$this->db->where('user_id',$uid);
			$this->db->update('tblusers' , $updateArray);

			// $IsActive = $this->input->post('IsActive');
			// if ($IsActive != 1) {


			// 	$updateArray = array(
			// 		'imei1'     => NULL,
			// 		'imei2'         => NULL,
			// 	);
			// 	$this->db->where('user_id',$uid);
			// 	$this->db->update('tblusers' , $updateArray);

			// }

			// // For language Id = 2
			// $IsActive = $this->input->post('IsActive');
			// if ($IsActive != 1) {

			// 	$updateArray = array(
			// 		'imei1'     => NULL,
			// 		'imei2'         => NULL,
			// 	);
			// 	$this->db->where('user_id',$uid);
			// 	$this->db->update('tblusers' , $updateArray);				

			// }



			$sql = "select * from mstsubcenter where subcentercode = ".$this->input->post('subcenter');
			$res = $this->Common_Model->query_data($sql);

			$sql = "SELECT ANMID FROM `mstanm` where LanguageID = 1 and ANMID = ".$anmID;
			$res_anm_id = $this->Common_Model->query_data($sql);

			$updateArr = array(
				'SubCenterID'   =>	$res[0]->SubCenterID,
				'SubCenterCode' =>	$this->input->post('subcenter'),
				'ANMName'       => 	$this->input->post('ANMNameEnglish')
			);

			$this->db->where('ANMID', $res_anm_id[0]->ANMID);
			$this->db->update('anmsubcenter', $updateArr);

			$this->db->trans_complete();

			$this->session->set_flashdata('tr_msg', 'Successfully updated anm');

			$this->db->trans_complete();
			
			if ($this->db->trans_status() === FALSE){
				$this->session->set_flashdata('tr_msg', 'Error Edit Anm');					
			}else{
				$this->session->set_flashdata('tr_msg', 'Successfully Edit Anm');			
			}

				// check if ReplacedBy is filled 
			$ReplacedBy = $this->input->post('ReplacedBy');
			if ($ReplacedBy != NULL) {
				redirect("anm/replacement/'. $Anm_details[0]->ANMUID");
			}


			$mode = $this->input->post('mode');

			if ($mode == "addreplacement") {

				//update for LAnguage id = 1
				$updateArr = array(
					'LeaveStatus' => $this->input->post('LeaveStatus'),
					'LastWorkingDate'  => $this->input->post('LastWorkingDate'),
				);

				$this->db->where('ANMUID' , $anmUID);
				$this->db->where('LanguageID', 1);
				$this->db->update('mstanm', $updateArr);


				//update for LanguageID = 2

				$updateArr = array(
					'LeaveStatus' => $this->input->post('LeaveStatus'),
					'LastWorkingDate'  => $this->input->post('LastWorkingDate'),
				);
				
				$this->db->where('ANMUID' , $anmUID);
				$this->db->where('LanguageID',2);
				$this->db->update('mstanm', $updateArr);

				redirect("anm/replacement/". $Anm_details[0]->ANMUID);
			}

			
			redirect('anm');
		}
		

		$sql = "select CountryCode, StateCode, DistrictCode, BlockCode, SubCenterCode from mstsubcenter where SubCenterCode = (SELECT SubCenterCode FROM `anmsubcenter` where ANMID = ".$Anm_details[0]->ANMID.") and LanguageID = 1";		
		$anm_geo_codes = $this->Common_Model->query_data($sql);
		$content['geo_codes'] = $anm_geo_codes[0];

		// echo "<pre>"; print_r($Anm_details); die();
		$content['anm_active'] = $Anm_details[0];
		
		if(count($Anm_details) < 1){
			$this->session->set_flashdata('er_msg', 'The record does not exist / permission denied. Please contact your system authistrator.');
			redirect('anm');
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

		$this->db->where('LanguageID',1);
		$countries = $this->db->get('mstcountry');
		$content['countries'] = $countries->result();

		$query = "select * FROM mstanm where ANMID = $anmID and IsDeleted = 0 and LanguageID = 1";
		$content['anm_record'] = $this->Common_Model->query_data($query);

		$this->db->where('LanguageID',1);
		$this->db->where('CountryCode',$anm_geo_codes[0]->CountryCode);
		$states = $this->db->get('mststate');
		$content['states'] = $states->result();

		$this->db->where('LanguageID',1);
		$this->db->where('StateCode',$anm_geo_codes[0]->StateCode);
		$districts = $this->db->get('mstdistrict');
		$content['districts'] = $districts->result();

		$this->db->where('LanguageID',1);
		$this->db->where('DistrictCode',$anm_geo_codes[0]->DistrictCode);
		$blocks = $this->db->get('mstblock');
		$content['blocks'] = $blocks->result();

		$this->db->where('LanguageID',1);
		$this->db->where('BlockCode',$anm_geo_codes[0]->BlockCode);
		$subcenters = $this->db->get('mstsubcenter');
		$content['subcenters'] = $subcenters->result();

		
		$content['Anm_details'] = $updateAnmArr;
		// print_r($content['Anm_details']); die();
		$content['subview']="edit_anm";
		$this->load->view('auth/main_layout', $content);		
	}
	

	function replacement($anmUID=null, $anmCode=NULL, $villageId=null)
	{

// get the ashaID from ashaUID
		$this->db->where('ANMUID', $anmUID);
		$result = $this->db->get('mstanm')->result();
		if (count($result) < 1) {
			$this->session->set_flashdata('er_msg', "No anm reference set for this ID");
			redirect('anm');
		}

		$anmID = $result[0]->ANMID;

		// print_r($anmID); die();

	//USER IMEI Number
		$query = "select * from tblusers a inner join useranmmapping b 
		on a.user_id = b.UserID inner join mstanm c on c.ANMID = b.ANMID where c.ANMID ='".$anmID."' and a.is_active = 1";


		$content['User_IMEI'] = $this->db->query($query)->result();

		foreach ($content['User_IMEI'] as $row) {
			$uid = $row->user_id;
			
		}

		$RequestMethod = $this->input->server('REQUEST_METHOD');
		if($RequestMethod == "POST")
		{

			$this->db->trans_start();

			//Record   for English LanguageID=1
			$query = "select * from mstanm where LanguageID = 1 and ANMID = ".$anmID;
			$anm_english = $this->Common_Model->query_data($query)[0];

			// print_r($anm_english); die();

			$insertArr = array(
				'ANMID'          =>	$anmID,
				'StateCode'		=>		$anm_english->StateCode,
				'ANMName'        => 	$this->input->post('ANMNameEnglish'),
				'ANMCode'         => 	$anm_english->ANMCode,
				'LeaveStatus'     => 	NULL,
				'LastWorkingDate' => 	NULL,
				'ReplacedBy'      => 	NULL,
				'LanguageID'      => 	1,
				'IsDeleted'       => 	0,
				'IsActive'        => 	1,
			);

			$this->Common_Model->insert_data('mstanm', $insertArr);

			$anm_uid_new = $this->db->insert_id();

			$insertArr = array(
				'ANMID'          =>	$anmID,
				'StateCode'		=>		$anm_english->StateCode,
				'ANMName'        => 	$this->input->post('ANMNameHindi'),
				'ANMCode'         => 	$anm_english->ANMCode,
				'LeaveStatus'     => 	NULL,
				'LastWorkingDate' => 	NULL,
				'ReplacedBy'      => 	NULL,
				'LanguageID'      => 	2,
				'IsDeleted'       => 	0,
				'IsActive'        => 	1,
			);

			$this->Common_Model->insert_data('mstanm', $insertArr);

			$updateArray = array(
				'imei1'     => $this->input->post('imei1'),
				'imei2'         => $this->input->post('imei2'),
			);
			$this->db->where('user_id',$uid);
			$this->db->update('tblusers' , $updateArray);
			



			$sql_delete_anmvillagemapping = "delete FROM `anmvillage` where ANMID =".$anmID;
			$this->Common_Model->query_data_noresult($sql_delete_anmvillagemapping);

			$villages = $this->input->post('villages');

			for($i = 0; $i<count($villages); $i++)
			{

				$insertArrAshaAnm	=	array(
					'ANMID'    =>	$anmID,
					'VillageID' =>	$villages[$i],
				);

				$this->Common_Model->insert_data('anmvillage',$insertArrAshaAnm);
			}

			// find the asha UID's being replaced and update them
			$this->db->where('ANMUID in ('.$anmUID.','.($anmUID+1).')');
			$updateArr = array(
				'IsActive'   => 0,
				'ReplacedBy' =>	$anm_uid_new,
			);
			$this->db->update('mstanm', $updateArr);

			$this->db->trans_complete();

			$this->session->set_flashdata('tr_msg', 'Successfully updated anm');

			if ($this->db->trans_status() === FALSE){
				$this->session->set_flashdata('tr_msg', 'Error in adding ANm replacement');					
			}else{
				$this->session->set_flashdata('tr_msg', 'Successfully added Anm replacement');			
			}

			redirect('anm');
		}



		$this->db->where('ANMUID in ('.$anmUID.','.($anmUID+1).')');
		$Anm_details = $this->db->get('mstanm')->result();
		$content['Anm_details'] = $Anm_details;


		$sql = "select CountryCode, StateCode, DistrictCode, BlockCode, SubCenterCode from mstsubcenter where SubCenterCode = (SELECT SubCenterCode FROM `anmsubcenter` where ANMID = ".$Anm_details[0]->ANMID.") and LanguageID = 1";		
		$anm_geo_codes = $this->Common_Model->query_data($sql);
		$content['geo_codes'] = $anm_geo_codes[0];


		$this->db->where('LanguageID',1);
		$countries = $this->db->get('mstcountry');
		$content['countries'] = $countries->result();


		$this->db->where('LanguageID',1);
		$this->db->where('CountryCode',$anm_geo_codes[0]->CountryCode);
		$states = $this->db->get('mststate');
		$content['states'] = $states->result();

		$this->db->where('LanguageID',1);
		$this->db->where('StateCode',$anm_geo_codes[0]->StateCode);
		$districts = $this->db->get('mstdistrict');
		$content['districts'] = $districts->result();

		$this->db->where('LanguageID',1);
		$this->db->where('DistrictCode',$anm_geo_codes[0]->DistrictCode);
		$blocks = $this->db->get('mstblock');
		$content['blocks'] = $blocks->result();

		$this->db->where('LanguageID',1);
		$this->db->where('BlockCode',$anm_geo_codes[0]->BlockCode);
		$subcenters = $this->db->get('mstsubcenter');
		$content['subcenters'] = $subcenters->result();


		$content['subview']="edit_anm_replacement";
		$this->load->view('auth/main_layout',$content);
	}


		//Extra Charge

	function extracharge($anmUID=null, $ashaCode=NULL, $villageId=null)
	{

		// get the ashaID from ashaUID
		$this->db->where('ANMUID', $anmUID);
		$result = $this->db->get('mstanm')->result();
		if (count($result) < 1) {
			$this->session->set_flashdata('er_msg', "No anm reference set for this ID");
			redirect('anm');
		}

		$anmID = $result[0]->ANMID;

		// print_r($anmID); die();

		$extra_charge_check = $this->db->get_where('tblextrachargeanm',array('IsDeleted' =>0, 'ChargeTo' =>$anmUID))->result();
		$extra_charge_count = count($extra_charge_check);
		if($extra_charge_count>=2){
			$this->session->set_flashdata('er_msg',"This ANM alredy contains 2 extra charges");
			redirect('anm/edit/'.$anmUID);
		}
		
		$query = "SELECT * FROM mstanm where  IsDeleted = 0 and LanguageID = 1 and IsActive = 0";

		$anm_name = $this->Common_Model->query_data($query);


		$content['anm_name'] = $anm_name;
		$anmUID2 = $anm_name[0]->ANMUID;
		// print_r($anmUID2); die();

		// print_r($content['anm_name']); die();

		$query = "select imei1 from tblusers a inner join useranmmapping b 
		on a.user_id = b.UserID inner join mstanm c on c.ANMID = b.ANMID where c.ANMUID ='".$anmUID."' and a.is_active = 1";

		$ChargeToimei1 = $this->db->query($query)->row('imei1');

		$query = "select imei2 from tblusers a inner join useranmmapping b 
		on a.user_id = b.UserID inner join mstanm c on c.ANMID = b.ANMID where c.ANMUID ='".$anmUID."' and a.is_active = 1";

		$ChargeToimei2 = $this->db->query($query)->row('imei2');

		
		$RequestMethod = $this->input->server('REQUEST_METHOD');
		if($RequestMethod == "POST")
		{

			$this->db->trans_start();


			$query = "select imei1, imei2 from tblusers a inner join useranmmapping b 
			on a.user_id = b.UserID inner join mstanm c on c.ANMID = b.ANMID where c.ANMID ='".$anmID."' and a.is_active = 1";
			$ChargeOfUserRow = $this->db->query($query)->result()[0];
			$ChargeOfImei1 = $ChargeOfUserRow->imei1; 
			$ChargeOfImei2 = $ChargeOfUserRow->imei2;


			$ChargeToAnmUID = $this->input->post('ReplacedBy');
			$query = "select imei1, imei2 from tblusers a inner join useranmmapping b 
			on a.user_id = b.UserID inner join mstanm c on c.ANMID = b.ANMID where c.ANMUID ='".$ChargeToAnmUID."' and a.is_active = 1";
			$ChargeToUserRow = $this->db->query($query)->result()[0];
			$ChargeToImei1 = $ChargeToUserRow->imei1; 
			$ChargeToImei2 = $ChargeToUserRow->imei2;

			$content['chargeOF_list'] = $this->db->get_where('tblextrachargeanm',array('IsDeleted'=> 0))->result()[0];
// print_r($content['chargeOF_list']); die();

			if(count($content['chargeOF_list']) > 1){


				$this->session->set_flashdata('er_msg', "There is ANM found In the list please select another ANM");
				redirect(current_url());
			} 

			$query = "select * from mstanm where LanguageID = 1 and ANMID = ".$anmID;
			$asha_extra_charge = $this->Common_Model->query_data($query)[0];

			$insertArr = array(
				'ChargeTo'			=>	$anmUID,
				'ChargeOf'			=>	$this->input->post('ReplacedBy'),				
				'ChargeToImei1'		=> 	$ChargeOfImei1,
				'ChargeToImei2'		=>	$ChargeOfImei2,
				'ChargeOfImei1'		=>	$ChargeToImei1,
				'ChargeOfImei2'		=>	$ChargeToImei2,	
				'EndDate'			=>	$this->input->post('EndDate'),
				'UpdatedBy'			=>	'',
				'UpdatedOn'			=>	date("Y-m-d H:i:s"),
				'LanguageID'		=> 	1,
				'IsDeleted'			=>	0,
			);

			$this->Common_Model->insert_data('tblextrachargeanm', $insertArr);

		// update IMEI of extra charge in tbuser

			$replace_user_id = $this->Common_Model->get_user_id_from_anm_id($this->input->post('ReplacedBy'));
			// die($replace_user_id);
			$updateArray = array(
				'imei1'     => $ChargeOfImei1,
				'imei2'         => $ChargeOfImei2,
				'ChargeType'	    =>	$this->input->post('ChargeType'),
				'is_temp'  => 1,
			);
			$this->db->where('user_id',$replace_user_id);
			$this->db->update('tblusers' , $updateArray);
			// die($this->db->last_query());

			// find the userID of chargeOF from ashaID  and update with imei of ChargeTo user 


			// For Language ID = 1

			$updateArray = array(
				'IsActive'     => 1,
			);
			$this->db->where('ANMUID',$anmUID2);
			$this->db->update('mstanm' , $updateArray);

			

			// For language Id = 2
			
			$updateArray = array(
				'IsActive'     => 1,
			);
			$this->db->where('ANMUID',$anmUID2+1);
			$this->db->update('mstanm' , $updateArray);



			$this->db->trans_complete();

			$this->session->set_flashdata('tr_msg', 'Successfully Modified anm');

			if ($this->db->trans_status() === FALSE){
				$this->session->set_flashdata('tr_msg', 'Error in updating Asha extra charge');					
			}else{
				$this->session->set_flashdata('tr_msg', 'Successfully modified Asha extra charge');			
			}

			redirect('anm');
		}	



		$content['subview']="extra_charge_anm_replacement";
		$this->load->view('auth/main_layout',$content);
	}



	function delete_extra_charge($ID)
	{

//step 1 - Roll back imei

		$replace_user_id = $this->Common_Model->get_user_id_anm_from_charge_of($ID);
		$cols = array('ChargeOfImei1 as imei1','ChargeOfImei2 as imei2');

		$this->db->select($cols);
		
		$updateArray = $this->db->get_where('tblextrachargeanm',array('ID'=>$ID))->result_array();
		$this->db->where('user_id',$replace_user_id);
		$this->db->update('tblusers' , $updateArray[0]);

		// step 2 - set the flag IsDeleted of tblextracharge to 1
		$query =  "update tblextrachargeanm set IsDeleted = 1 where ID='".$ID."'";

		$this->db->query($query);
		// die($query);
		$this->session->set_flashdata('tr_msg',"Extra Charge Delete Successfully");
		redirect('anm');

	}

	function delete($ANMCode = NULL)
	{
		$query =  "update mstanm set IsDeleted = 1 where ANMCode=$ANMCode ";

		// print_r($query); die();
		$this->db->query($query);
		$this->session->set_flashdata('tr_msg' ,"Anm Deleted Successfully");
		redirect('anm');
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