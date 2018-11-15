<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Asha extends Auth_controller {

	public function __construct(){
		parent::__construct();
		$this->loginData = $this->session->userdata('loginData');
	}
	
	function index($AshaPDF = ' ') 
	{	
		$user_role = $this->loginData->user_role;
		$query = "SELECT * FROM role_permissions as rp LEFT JOIN mstrole as mst on rp.RoleID=mst.RoleID WHERE rp.RoleID='$user_role' ";
		$content['role_permission'] = $this->Common_Model->query_data($query);


		$query = "select * from mststate where IsDeleted=0 and LanguageID = 1 ";
		if ($this->loginData->user_role == 1 || $this->loginData->user_role == 2 || $this->loginData->user_role == 3 || $this->loginData->user_role == 6 || $this->loginData->user_role == 7 || $this->loginData->user_role == 8 || $this->loginData->user_role == 10) 	 {
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
		$content['State_list'] = $this->Common_Model->query_data($query);


		$RequestMethod = $this->input->server('REQUEST_METHOD');
		if($RequestMethod == "POST")
		{
			// $query = "select * from mstasha as mas LEFT JOIN mstanm as nm on mas.ANMCode=nm.ANMCode LEFT JOIN userashamapping as ump on ump.AshaID = mas.ASHAID LEFT JOIN tblusers as ur on ump.UserID=ur.id LEFT JOIN mststate as st on ur.state_code=st.StateCode where st.StateCode=".$this->input->post('StateCode')." and mas.LanguageID=1 and mas.IsDeleted = 0 group by mas.ASHAName";
			$query = "select a.user_name, a.user_id, c.ASHAName,c.ASHAUID, c.ASHACode,c.ASHAID,c.IsActive, e.ANMName, e.ANMCode from tblusers a 
			inner join userashamapping b 
			on a.user_id = b.UserID
			inner join mstasha c 
			on b.AshaID = c.ASHAID and c.LanguageID = 1
			inner join anmasha d 
			on c.ASHAID = d.ASHAID
			inner join mstanm e 
			on d.ANMID = e.ANMID and e.LanguageID = 1
			where a.user_mode and a.state_code = '".$this->input->post('StateCode')."'";

			// print_r($query); die();

			$content['Asha_list'] = $this->Common_Model->query_data($query);	

		}else{
			$content['Asha_list'] = array();
		}

     //print_r($content['Asha_list']); die();

		$content['subview']="list_asha";

		if ($AshaPDF == "export_pdf") {
			$this->export_section($content);
			die();
		}

		$this->load->view('auth/main_layout', $content);
	}


	public function export_csv()
	{
		$query = "select ASHACode,ANMCode,SubCenterCode,VillageCode,ASHAName,
		(CASE WHEN LanguageID = NULL THEN ' ' WHEN LanguageID = 1 THEN 'English' WHEN LanguageID = 2 THEN 'Hindi' END) as LanguageID  from mstasha where LanguageID = 1 and IsDeleted = 0";
		$this->load->model('Data_export_model');
		$this->Data_export_model->export_csv($query);
	}

/*	public function export_pdf()
	{
		$query = "select * from mstasha where LanguageID = 1 and IsDeleted = 0";
		$this->load->model('Data_export_model');
		$this->Data_export_model->export_pdf($query);
	}*/
	
	function add()
	{
		$query = "select * from mstcountry where LanguageID=1 and IsDeleted = 0";
		$content['Country_List'] = $this->Common_Model->query_data($query);

		// $query = "select * from mststate where LanguageID=1 and IsDeleted = 0";
		// $content['State_List'] = $this->Common_Model->query_data($query);

		// $query = "select * from mstvillage where LanguageID = 1 and IsDeleted = 0";
		// $content['Village_List'] = $this->Common_Model->query_data($query);

		// $query = "select * from mstcatchmentsupervisor where LanguageID = 1 and IsDeleted = 0";
		// $content['Supervisor_List'] = $this->Common_Model->query_data($query);

		$RequestMethod = $this->input->server('REQUEST_METHOD');

		if($RequestMethod == "POST")
		{

			// print_r($_POST); die();
			$query = "select * from mstdistrict where StateCode=".$this->input->post('states')." and LanguageID=1 and IsDeleted = 0";
			$content['District_List'] = $this->Common_Model->query_data($query);

			$query = "select * from mstblock where DistrictCode=".$this->input->post('districts')." and LanguageID=1 and IsDeleted=0";
			$content['Block_List'] = $this->Common_Model->query_data($query);

			$query = "select * from mstsubcenter where SubCenterID=".$this->input->post('subcenter')." and LanguageID = 1 and IsDeleted = 0";
			$content['Subcenter_List'] = $this->Common_Model->query_data($query);

			$query = "select * from mstanm where ANMID = ".$this->input->post('anm')."
			and LanguageID = 1 and IsDeleted = 0";
			$content['Anm_List'] = $this->Common_Model->query_data($query);

			// $query = "select * from mstphc where PHC_id = ".$this->input->post('PHC_id')."
			// and LanguageID = 1 and IsDeleted = 0";
			// $content['PHC_List'] = $this->Common_Model->query_data($query);

			$this->db->trans_start();


		    //Get the ASHAID, THis is the max(ASHAID) column
			$query	="select max(ASHAID) as ASHAID from mstasha where StateCode = ".$this->input->post('states');
			$ashaList =$this->Common_Model->query_data($query);
			$ashaId	 =	$ashaList[0]->ASHAID;

			//Get the AshaCode, THis is the max(ASHACode) column
			$query =	"select max(ASHACode) as ASHACode from mstasha where StateCode = ".$this->input->post('states');
			$ashaRec	=	$this->Common_Model->query_data($query);
			$ashaCode	=	$ashaRec[0]->ASHACode;

			// $sql = "select ANMCode from mstanm where ANMID = ".$this->input->post('anm');
			// $res_anm = $this->Common_Model->query_data($sql);

			$this->db->where('ANMCode', $this->input->post('anm'));
			$this->db->where('LanguageID' , 1);
			$res_anm = $this->db->get('mstanm')->result();



			$insertArr = array(

				'ASHAID'        =>	$ashaId+1,
				'ASHACode'      => 	$ashaCode+1,
				'ANMCode'       => 	$res_anm[0]->ANMCode,
				'SubCenterCode' =>	$this->input->post('subcenter'),
				'VillageCode'   =>	$this->input->post('VillageCode'),
				'ASHAName'      => 	$this->input->post('AshaNameEnglish'),
				'CHS_ID'        =>	$this->input->post('chs'),
				'LanguageID'    =>  1,
				'IsDeleted'     =>  0,
				'StateCode'     =>  $this->input->post('states'),
				);


			$this->Common_Model->insert_data('mstasha', $insertArr);

        	// Get the ASHAID, THis is the max(ASHAID) column
			// $query	="select max(ASHAID) as ASHAID from mstasha";
			// $ashaList =$this->Common_Model->query_data($query);
			// $ashaId	 =	$ashaList[0]->ASHAID;

			// //Get the AshaCode, THis is the max(ASHACode) column
			// $query =	"select max(ASHACode) as ASHACode from mstasha";
			// $ashaRec	=	$this->Common_Model->query_data($query);
			// $ashaCode	=	$ashaRec[0]->ASHACode;



			$insertArr	=	array(
			//Record for Hindi LanguageID = 1
				
				'ASHAID'        =>	$ashaId+1,
				'ASHACode'      => 	$ashaCode+1,
				'ANMCode'       => 	$res_anm[0]->ANMCode,
				'SubCenterCode' =>	$this->input->post('subcenter'),
				'VillageCode'   =>	$this->input->post('VillageCode'),				
				'ASHAName'      => 	$this->input->post('AshaNameHindi'),
				'CHS_ID'        =>	  $this->input->post('chs'),
				'LanguageID'    => 2,
				'IsDeleted'     => 0,
				'StateCode'     => $this->input->post('states'),
				);

			$this->Common_Model->insert_data('mstasha', $insertArr);

			$ANMID = $this->get_anmid_from_anmcode($this->input->post('anm'));

			//record added anmasha
			$insertArrAshaAnm	=	array(
				'ANMID'					=>	$ANMID,
				'ASHAID'				=>	$ashaId+1,
				);

			$this->Common_Model->insert_data('anmasha',$insertArrAshaAnm);

			//adding entries to ashvillage

			$villages = $this->input->post('villages');
			for($i = 0; $i<count($villages); $i++)
			{

				$insertArrAshaAnm	=	array(
					'ASHAID'					=>	$ashaId+1,
					'VillageID'				=>	$villages[$i],
					);

				$this->Common_Model->insert_data('ashavillage',$insertArrAshaAnm);
			}

			$this->db->trans_complete();

			//$this->session->set_flashdata('tr_msg', 'Successfully added asha');

			if ($this->db->trans_status() === FALSE){
				$this->session->set_flashdata('tr_msg', 'Error adding asha');					
			}else{
				$this->session->set_flashdata('tr_msg', "Successfully added asha 
					username:-  $username ");			
			}

			redirect('asha');
		}


		$content['subview']="add_asha";
		$this->load->view('auth/main_layout', $content);
	}

	function edit($ashaUID=null, $ashaCode=NULL, $villageId=null)
	{

		// get the ashaID from ashaUID
		$this->db->where('ASHAUID in ('.$ashaUID.','.($ashaUID+1).')');
		$result = $this->db->get('mstasha')->result();

		// print_r($result); die();
		if (count($result) < 1) {
			$this->session->set_flashdata('er_msg', "No asha reference set for this ID");
			redirect('asha');
		}

		$ashaID = $result[0]->ASHAID;


		$ashaID_redirect = $ashaID;		
		$this->session->set_userdata('ashaID_redirect',$ashaID_redirect);


		//EXTRA CHARGE LIST IN EDIT

		$query = "select *,b.ASHAName FROM tblextracharge a 
		inner join mstasha b 
		on a.ChargeTo = b.ASHAUID where b.LanguageID = 1 and b.ASHAID=".$ashaID." AND a.IsDeleted = 0 ";

		$content['extra_charge_list'] = $this->Common_Model->query_data($query);		


		foreach ($content['extra_charge_list'] as $nm ){
			$ChargeOf =  $nm->ChargeOf;
		}
		if(!empty($ChargeOf)){
			$query ="select * from tblextracharge a inner join mstasha b on a.ChargeOf=b.ASHAUID  and a.IsDeleted = 0 and a.ChargeTo =".$ashaUID;
			// die($query);

			$content['asha_name'] = $this->Common_Model->query_data($query);
			// print_r($content['asha_name']); die();
		}

       // echo "<pre>";
        // print_r($content['asha_name']); die();


		

		$this->db->where('ASHAUID in ('.$ashaUID.','.($ashaUID+1).')');

		// $query = "SELECT * FROM mstasha where ASHAUID = $ashaUID and IsDeleted = 0 ";
		$asha_details = $this->db->get('mstasha')->result();
		$content['asha_details'] = $asha_details;

		//USER IMEI Number
		$query = "select * from tblusers a inner join userashamapping b 
		on a.user_id = b.UserID inner join mstasha c on c.ASHAID = b.AshaID where c.ASHAID ='".$ashaID."' and a.is_active = 1";

		$content['User_IMEI'] = $this->db->query($query)->result();
		foreach ($content['User_IMEI'] as $row) {
			$uid = $row->user_id;

		}
		/*echo "<pre>";
		print_r($content['User_IMEI']); die();*/

		$query = "select * from mstcountry where LanguageID=1 and IsDeleted = 0";
		$content['Country_List'] = $this->Common_Model->query_data($query);
		$sql_asha_dets = "select * from mstasha where LanguageID = 1 and IsActive = 1 and ASHAID = ".$ashaID ;
		$content['asha_active'] = $this->Common_Model->query_data($sql_asha_dets);

		$sql_asha_leave = "select * from mstasha where LanguageID = 1 and ASHAID = ".$ashaID;
		$content['asha_leave'] = $this->Common_Model->query_data($sql_asha_leave);

		$RequestMethod = $this->input->server('REQUEST_METHOD');
		if($RequestMethod == "POST")
		{

			$this->db->trans_start();

			//Record   for English LanguageID=1
			$sql_asha_dets = "select * from mstasha where LanguageID = 1 and ASHAID = ".$ashaID;
			$res_asha_dets = $this->Common_Model->query_data($sql_asha_dets);


			$updateArr = array(
				// 'ANMCode'       => 	$this->input->post('ANMID'),
				'SubCenterCode' =>	$this->input->post('subcenter'),
				// 'VillageCode'   =>	$this->input->post('VillageCode'),				
				'ASHAName'      => 	$this->input->post('AshaNameEnglish'),
				'ANMCODE'      => 	$this->input->post('anm'),
				'LeaveStatus'      => 	$this->input->post('LeaveStatus'),
				'LastWorkingDate'      => 	$this->input->post('LastWorkingDate'),
				// 'ReplacedBy'      => 	$this->input->post('ReplacedBy'),
				// 'CHS_ID'        =>	$this->input->post('CHS_ID'),
				'LanguageID'    => 	1,
				'IsDeleted'     => 	0,
				'IsActive'     => 	$this->input->post('IsActive'),
				);

			$this->db->where('ASHAUID' , $ashaUID);
			$this->db->where('LanguageID', 1);
			$this->db->update('mstasha', $updateArr);

			//Record for Hindi LanguageID=2

			$updateArr = array(
				// 'ANMCode'       => 	$this->input->post('ANMID'),
				'SubCenterCode' =>	$this->input->post('subcenter'),
				// 'VillageCode'   =>	$this->input->post('VillageCode'),				
				'ASHAName'      => 	$this->input->post('AshaNameHindi'),
				'ANMCODE'      => 	$this->input->post('anm'),
				'LeaveStatus'      => 	$this->input->post('LeaveStatus'),
				'LastWorkingDate'      => 	$this->input->post('LastWorkingDate'),
				// 'ReplacedBy'      => 	$this->input->post('ReplacedBy'),
				'LanguageID'    => 	2,
				'IsDeleted'     => 	0,	
				'IsActive'     => 	$this->input->post('IsActive'),			
				);

			$this->db->where('ASHAUID' ,  $ashaUID+1);
			$this->db->where('LanguageID' , 2);
			$this->db->update('mstasha' , $updateArr);



			$updateArray = array(
				'imei1'     => $this->input->post('imei1'),
				'imei2'         => $this->input->post('imei2'),
				);
			$this->db->where('user_id',$uid);
			$this->db->update('tblusers' , $updateArray);


			// $this->db->select('*');
			// $this->db->from('tblusers');
			// $this->db->join('userashamapping', 'tblusers.user_id = userashamapping.UserID');
			// $this->db->join('mstasha', 'mstasha.ASHAID = userashamapping.AshaID');
			// $this->db->where('tblusers.is_active', '1');
			// $this->db->where('mstasha.ASHAID', $ashaID);
			// $this->db->update('tblusers' , $updateArray);

			// For language Id = 1

			/*$IsActive = $this->input->post('IsActive');
			if ($IsActive != 1) {


				$updateArray = array(
					'imei1'     => NULL,
					'imei2'         => NULL,
				);
				$this->db->where('user_id',$uid);
				$this->db->update('tblusers' , $updateArray);

				
			}

			// For language Id = 2
			$IsActive = $this->input->post('IsActive');
			if ($IsActive != 1) {


				$updateArray = array(
					'imei1'     => NULL,
					'imei2'         => NULL,
				);
				$this->db->where('user_id',$uid);
				$this->db->update('tblusers' , $updateArray);

				

			}*/

			//Record For Extra Charge

			// $query = "select * from mstasha where LanguageID = 1 and ASHAID = ".$ashaID;
			// $asha_extra_charge = $this->Common_Model->query_data($query)[0];

			// $insertArr = array(
			// 	'Charge_to'			=>	$asha_extra_charge->ReplacedBy,
			// 	'Charge_of'			=>	$asha_extra_charge->ASHAID,
			// 	'Charge_type'	    =>	$this->input->post('Charge_type'),
			// 	'End_date'			=>	$this->input->post('End_date'),
			// 	'UpdatedBy'			=>	'',
			// 	'UpdatedOn'			=>	date("Y-m-d H:i:s"),
			// 	'LanguageID'		=> 	1,
			// 	'IsDeleted'			=>	0,
			// );


			// $this->Common_Model->insert_data('tblextracharge', $insertArr);



			$sql_delete_ashanmmapping = "delete FROM `anmasha` where ASHAID = ".$ashaID;
			$this->Common_Model->query_data_noresult($sql_delete_ashanmmapping);

			$this->db->where('ANMCode', $this->input->post('anm'));
			$this->db->where('LanguageID' , 1);
			$res_anm_id = $this->db->get('mstanm')->result();

			$insertArr = array(
				"ANMID" => $res_anm_id[0]->ANMID,
				"ASHAID" => $ashaID,
				);

			$this->Common_Model->insert_data('anmasha',$insertArr);

			$sql_delete_ashavillagemapping = "delete FROM `ashavillage` where ASHAID =".$ashaID;
			$this->Common_Model->query_data_noresult($sql_delete_ashavillagemapping);

			$villages = $this->input->post('villages');

			for($i = 0; $i<count($villages); $i++)
			{

				$insertArrAshaAnm	=	array(
					'ASHAID'					=>	$ashaID,
					'VillageID'				=>	$villages[$i],
					);

				$this->Common_Model->insert_data('ashavillage',$insertArrAshaAnm);
			}


			
			$this->db->trans_complete();

			$this->session->set_flashdata('tr_msg', 'Successfully updated asha');

			if ($this->db->trans_status() === FALSE){
				$this->session->set_flashdata('tr_msg', 'Error a edit Asha');					
			}else{
				$this->session->set_flashdata('tr_msg', 'Successfully Modified Asha');			
			}

			// check if ReplacedBy is filled 
			$ReplacedBy = $this->input->post('ReplacedBy');
			if ($ReplacedBy != NULL) {
				redirect("asha/replacement/'. $asha_details[0]->ASHAUID");
			}


			$mode = $this->input->post('mode');

			if ($mode == "addreplacement") {

				//update for LAnguage id = 1
				$updateArr = array(
					'LeaveStatus' => $this->input->post('LeaveStatus'),
					'LastWorkingDate'  => $this->input->post('LastWorkingDate'),
					);

				$this->db->where('ASHAUID' , $ashaUID);
				$this->db->where('LanguageID', 1);
				$this->db->update('mstasha', $updateArr);


				//update for LanguageID = 2

				$updateArr = array(
					'LeaveStatus' => $this->input->post('LeaveStatus'),
					'LastWorkingDate'  => $this->input->post('LastWorkingDate'),
					);
				
				$this->db->where('ASHAUID' , $ashaUID);
				$this->db->where('LanguageID',2);
				$this->db->update('mstasha', $updateArr);

				redirect("asha/replacement/". $asha_details[0]->ASHAUID);
			}



			redirect('asha');
		}


		$sql_extra_charge = "select * from tblextracharge where LanguageID = 1 and ASHAID = ".$ashaID;
		$content['asha_extra_charge'] = $this->Common_Model->query_data($sql_extra_charge);

		

		$query = "SELECT * FROM mstasha where ASHAID = $ashaID and IsDeleted = 0";

		$asha_replaced_name = $this->Common_Model->query_data($query);

		// print_r($asha_replaced_name); die();

		$content['asha_replaced_name'] = $asha_replaced_name;


		$village_boxes = '';
		$village_anm_boxes = '';

		if($asha_details[0]->ANMCode != null)
		{

			$query = "SELECT * FROM mstanm where ANMCode = ".$asha_details[0]->ANMCode." and IsDeleted = 0";
			$Anm_details = $this->Common_Model->query_data($query);

			$content['Anm_details'] = $Anm_details;


			$query = "SELECT * FROM mstasha where ANMCode = ".$asha_details[0]->ANMCode." and IsDeleted = 0 and LanguageID = 1";
			$asha_of_anm = $this->Common_Model->query_data($query);

			$content['asha_of_anm'] = $asha_of_anm;


			$sql = "select CountryCode, StateCode, DistrictCode, BlockCode, SubCenterCode from mstsubcenter where SubCenterCode = (SELECT SubCenterCode FROM `anmsubcenter` where ANMID = ".$Anm_details[0]->ANMID.") and LanguageID = 1";		
			$anm_geo_codes = $this->Common_Model->query_data($sql);
			$content['geo_codes'] = $anm_geo_codes[0];

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

			$sql = "select * from mstanm where LanguageID = 1 and anmid in (SELECT ANMID FROM `anmsubcenter` where SubCenterCode = ".$anm_geo_codes[0]->SubCenterCode.")";
			$content['anm_list'] = $this->Common_Model->query_data($sql);

			$sql = "SELECT * FROM `ashavillage` where ASHAID =".$ashaID;
			$res_mapped_villages = $this->Common_Model->query_data($sql);
			$village_store = [];
			foreach ($res_mapped_villages as $vrow) {
				$village_store[] = $vrow->VillageID;
			}


			// print_r($res_mapped_villages); die();

			$sql = "select * from mstvillage where LanguageID = 1 and VillageID in (SELECT VillageID FROM `ashavillage` where ASHAID = ".$asha_details[0]->ASHAID.")";
			$res_villages = $this->Common_Model->query_data($sql);

			// print_r($res_villages); die();


			$query = "SELECT * FROM mstanm 
			inner join anmvillage on anmvillage.ANMID = mstanm.ANMID
			inner join mstvillage on mstvillage.VillageID =  anmvillage.VillageID
			where mstanm.ANMCode = ".$asha_details[0]->ANMCode." 
			and mstanm.IsDeleted = 0 and mstanm.LanguageID = 1 and mstvillage.LanguageID = 1 
			and mstvillage.VillageID not in (".implode(',', $village_store).") ";
			$res_anm_villages = $this->Common_Model->query_data($query);


			 // print_r($res_anm_villages); die();


			foreach ($res_villages as $row) {

				$checked = '';

				foreach ($res_mapped_villages as $row_mapped_village) {
					if($row_mapped_village->VillageID == $row->VillageID)
					{
						$checked = 'checked';
					}
				}
				$village_boxes .= '<div class="checkbox m-b-15">
				<label>
					<input type="checkbox" value="'.$row->VillageID.'" name="villages[]" '.$checked.'>
					<i class="input-helper"></i>
					'.$row->VillageName.'
				</label>
			</div>';
		}


		foreach ($res_anm_villages as $row) {

			$checked = '';


			$village_anm_boxes .= '<div class="checkbox m-b-15">
			<label>
				<input type="checkbox" value="'.$row->VillageID.'" name="villages[]" '.$checked.'>
				<i class="input-helper"></i>
				'.$row->VillageName.'
			</label>
		</div>';
	}

}
$content['village_boxes'] = $village_boxes;
$content['village_anm_boxes'] = $village_anm_boxes;



$content['subview']="edit_asha";
$this->load->view('auth/main_layout',$content);
}

function replacement($ashaUID=null, $ashaCode=NULL, $villageId=null)
{

		// get the ashaID from ashaUID
	$this->db->where('ASHAUID', $ashaUID);
	$result = $this->db->get('mstasha')->result();
	if (count($result) < 1) {
		$this->session->set_flashdata('er_msg', "No asha reference set for this ID");
		redirect('asha');
	}

	$ashaID = $result[0]->ASHAID;

		// die($ashaID);

		//USER IMEI Number
	$query = "select * from tblusers a inner join userashamapping b 
	on a.user_id = b.UserID inner join mstasha c on c.ashaid = b.AshaID where c.ashaid ='".$ashaID."' and a.is_active = 1";

	$content['User_IMEI'] = $this->db->query($query)->result();

	foreach ($content['User_IMEI'] as $row) {
		$uid = $row->user_id;

	}

		/*	//ASHA REPLACEMENT NAME		
		$query = "select * from mstasha where ASHAID = '".$ashaID."' and IsDeleted = 0 ";
		$asha_replacement = $this->Common_Model->query_data($query);
	  // print_r($asha_replacement);
		$RepBy = $asha_replacement[0]->ReplacedBy ;
		$query1 = "select * from mstasha where ASHACode = '".$RepBy."' and IsDeleted = 0 ";
		$asha_replacement1 = $this->Common_Model->query_data($query1);	  

		$RepBy1 = $asha_replacement[1]->ReplacedBy ;
		$query2 = "select * from mstasha where ASHACode = '".$RepBy1."' and IsDeleted = 0 ";
		$asha_replacement2 = $this->Common_Model->query_data($query2);

		$content['asha_replacement'] = $asha_replacement1;*/
		

		// print_r($content['asha_replacement']); die();

		$query = "select * from mstcountry where LanguageID=1 and IsDeleted = 0";
		$content['Country_List'] = $this->Common_Model->query_data($query);
		$sql_asha_dets = "select * from mstasha where LanguageID = 1 and ashaid = ".$ashaID;
		$content['asha_active'] = $this->Common_Model->query_data($sql_asha_dets);

		$sql_asha_leave = "select * from mstasha where LanguageID = 1 and ashaid = ".$ashaID;
		$content['asha_leave'] = $this->Common_Model->query_data($sql_asha_leave);


		
		$RequestMethod = $this->input->server('REQUEST_METHOD');
		if($RequestMethod == "POST")
		{

			$this->db->trans_start();

			//Record   for English LanguageID=1
			$query = "select * from mstasha where LanguageID = 1 and ASHAID = ".$ashaID;
			$asha_english = $this->Common_Model->query_data($query)[0];

			$insertArr = array(
				'ASHAID'          =>	$ashaID,
				'ASHACode'        => 	$asha_english->ASHACode,
				'SubCenterCode'   =>	$asha_english->SubCenterCode,
				'VillageCode'     =>	$asha_english->VillageCode,
				'StateCode'		=>		$asha_english->StateCode,
				'CHS_ID'			=> $asha_english->CHS_ID,
				'ASHAName'        => 	$this->input->post('AshaNameEnglish'),
				'ANMCode'         => 	$asha_english->ANMCode,
				'LeaveStatus'     => 	NULL,
				'LastWorkingDate' => 	NULL,
				'ReplacedBy'      => 	0,
				'LanguageID'      => 	1,
				'IsDeleted'       => 	0,
				'IsActive'        => 	1,
				);

			$this->Common_Model->insert_data('mstasha', $insertArr);

			$asha_uid_new = $this->db->insert_id();

			$insertArr = array(
				'ASHAID'          =>	$ashaID,
				'ASHACode'        => 	$asha_english->ASHACode,
				'SubCenterCode'   =>	$asha_english->SubCenterCode,
				'VillageCode'     =>	$asha_english->VillageCode,
				'StateCode'		=>		$asha_english->StateCode,
				'CHS_ID'		=>	$asha_english->CHS_ID,
				'ASHAName'        => 	$this->input->post('AshaNameHindi'),
				'ANMCode'         => 	$asha_english->ANMCode,
				'LeaveStatus'     => 	NULL,
				'LastWorkingDate' => 	NULL,
				'ReplacedBy'      => 	0,
				'LanguageID'      => 	2,
				'IsDeleted'       => 	0,
				'IsActive'        => 	1,
				);
			$this->Common_Model->insert_data('mstasha', $insertArr);


			$updateArray = array(
				'imei1'     => $this->input->post('imei1'),
				'imei2'         => $this->input->post('imei2'),
				);
			$this->db->where('user_id',$uid);
			$this->db->update('tblusers' , $updateArray);


			$sql_delete_ashanmmapping = "delete FROM `anmasha` where ASHAID = ".$ashaID;
			$this->Common_Model->query_data_noresult($sql_delete_ashanmmapping);

			$this->db->where('ANMCode', $this->input->post('anm'));
			$this->db->where('LanguageID' , 1);
			$res_anm_id = $this->db->get('mstanm')->result();

			$insertArr = array(
				"ANMID" => $res_anm_id[0]->ANMID,
				"ASHAID" => $ashaID,
				);

			$this->Common_Model->insert_data('anmasha',$insertArr);

			$sql_delete_ashavillagemapping = "delete FROM `ashavillage` where ASHAID =".$ashaID;
			$this->Common_Model->query_data_noresult($sql_delete_ashavillagemapping);

			$villages = $this->input->post('villages');

			for($i = 0; $i<count($villages); $i++)
			{

				$insertArrAshaAnm	=	array(
					'ASHAID'    =>	$ashaID,
					'VillageID' =>	$villages[$i],
					);

				$this->Common_Model->insert_data('ashavillage',$insertArrAshaAnm);
			}

			// find the asha UID's being replaced and update them
			$this->db->where('ASHAUID in ('.$ashaUID.','.($ashaUID+1).')');
			$updateArr = array(
				'IsActive'   => 0,
				'ReplacedBy' =>	$asha_uid_new,
				);
			$this->db->update('mstasha', $updateArr);

			$this->db->trans_complete();

			$this->session->set_flashdata('tr_msg', 'Successfully updated asha');

			if ($this->db->trans_status() === FALSE){
				$this->session->set_flashdata('tr_msg', 'Error in adding Asha replacement');					
			}else{
				$this->session->set_flashdata('tr_msg', 'Successfully added Asha replacement');			
			}

			redirect('asha');
		}




		// $query = "SELECT * FROM mstasha where ASHAID = $ashaID  and IsDeleted = 0";
		$this->db->where('ASHAUID in ('.$ashaUID.','.($ashaUID+1).')');
		$asha_details = $this->db->get('mstasha')->result();
		$content['asha_details'] = $asha_details;
		// print_r($asha_details); die();

		$content['asha_details'] = $asha_details;
		$village_boxes = '';

		if($asha_details[0]->ANMCode != null)
		{

			$query = "SELECT * FROM mstanm where ANMCode = ".$asha_details[0]->ANMCode." and IsDeleted = 0";
			$Anm_details = $this->Common_Model->query_data($query);

			$content['Anm_details'] = $Anm_details;



			$query = "SELECT * FROM mstasha where ANMCode = ".$asha_details[0]->ANMCode." and IsDeleted = 0 and LanguageID = 1";
			$asha_of_anm = $this->Common_Model->query_data($query);

			$content['asha_of_anm'] = $asha_of_anm;


			$sql = "select CountryCode, StateCode, DistrictCode, BlockCode, SubCenterCode from mstsubcenter where SubCenterCode = (SELECT SubCenterCode FROM `anmsubcenter` where ANMID = ".$Anm_details[0]->ANMID.") and LanguageID = 1";		
			$anm_geo_codes = $this->Common_Model->query_data($sql);
			$content['geo_codes'] = $anm_geo_codes[0];

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

			$sql = "select * from mstanm where LanguageID = 1 and anmid in (SELECT ANMID FROM `anmsubcenter` where SubCenterCode = ".$anm_geo_codes[0]->SubCenterCode.")";
			$content['anm_list'] = $this->Common_Model->query_data($sql);

			$sql = "SELECT * FROM `ashavillage` where ASHAID =".$ashaID;
			$res_mapped_villages = $this->Common_Model->query_data($sql);

			$sql = "select * from mstvillage where LanguageID = 1 and VillageID in (SELECT VillageID FROM `anmvillage` where ANMID = ".$Anm_details[0]->ANMID.")";
			$res_villages = $this->Common_Model->query_data($sql);


			foreach ($res_villages as $row) {

				$checked = '';

				foreach ($res_mapped_villages as $row_mapped_village) {
					if($row_mapped_village->VillageID == $row->VillageID)
					{
						$checked = 'checked';
					}
				}
				$village_boxes .= '<div class="checkbox m-b-15">
				<label>
					<input type="checkbox" value="'.$row->VillageID.'" name="villages[]" '.$checked.'>
					<i class="input-helper"></i>
					'.$row->VillageName.'
				</label>
			</div>';
		}

	}
	$content['village_boxes'] = $village_boxes;



	$content['subview']="edit_replacement";
	$this->load->view('auth/main_layout',$content);
}

function extracharge($ashaUID=null, $ashaCode=NULL, $villageId=null)
{

				// $content['redire_asha'] = $ashaUID;
		// get the ashaID from ashaUID
	$this->db->where('ASHAUID', $ashaUID);
	$result = $this->db->get('mstasha')->result();
	if (count($result) < 1) {
		$this->session->set_flashdata('er_msg', "No asha reference set for this ID");
		redirect('asha');
	}

	$ashaID = $result[0]->ASHAID;


	$extra_charge_check = $this->db->get_where('tblextracharge',array('IsDeleted' =>0, 'ChargeTo' =>$ashaUID))->result();
	$extra_charge_count = count($extra_charge_check);
	if($extra_charge_count>=2){
		$this->session->set_flashdata('er_msg',"This ASHA alredy contains 2 extra charges");
		redirect('asha/edit/'.$ashaUID);
	}


	$sql_asha_leave = "select * from mstasha where LanguageID = 1 and ASHAID = ".$ashaID;
	$content['asha_leave'] = $this->Common_Model->query_data($sql_asha_leave);

	$query = "SELECT * FROM mstasha where ASHAID = $ashaID  and IsDeleted = 0 and IsActive = 1";
	$asha_details = $this->Common_Model->query_data($query);
		// print_r($asha_details); die();

	$content['asha_details'] = $asha_details;

	$query = "SELECT * FROM mstasha where ANMCode = ".$asha_details[0]->ANMCode." and IsDeleted = 0 and LanguageID = 1 and IsActive = 0 and ASHAUID != ".$ashaUID."";

		// print_r($query); die();
	$asha_of_anm = $this->Common_Model->query_data($query);

	$content['asha_of_anm'] = $asha_of_anm;



	$ashaUID2 = $asha_of_anm[0]->ASHAUID;
		// print_r($ashaUID2); die();


		//USER IMEI Number

	$query = "select * from tblusers a inner join userashamapping b 
	on a.user_id = b.UserID inner join mstasha c on c.ASHAID = b.AshaID where c.ASHAID ='".$ashaID."' and a.is_active = 1";

	$content['User_IMEI'] = $this->db->query($query)->result();
	foreach ($content['User_IMEI'] as $row) {
		$uid = $row->user_id;

	}


	$query = "select imei1 from tblusers a inner join userashamapping b 
	on a.user_id = b.UserID inner join mstasha c on c.ashaid = b.AshaID where c.ASHAUID ='".$ashaUID."' and a.is_active = 1";

	$ChargeToimei1 = $this->db->query($query)->row('imei1');

	$query = "select imei2 from tblusers a inner join userashamapping b 
	on a.user_id = b.UserID inner join mstasha c on c.ashaid = b.AshaID where c.ASHAUID ='".$ashaUID."' and a.is_active = 1";

	$ChargeToimei2 = $this->db->query($query)->row('imei2');


	$RequestMethod = $this->input->server('REQUEST_METHOD');
	if($RequestMethod == "POST")
	{

		$this->db->trans_start();

	// find the asha UID's being replaced and update them
			// $this->db->where('ASHAUID in ('.$ashaUID.','.($ashaUID+1).')');
			// $updateArr = array(
			// 	'IsActive'   => 0,
				// 'ReplacedBy' =>	$ashaUID,
			// );

		$query = "select imei1, imei2 from tblusers a inner join userashamapping b 
		on a.user_id = b.UserID inner join mstasha c on c.ashaid = b.AshaID where c.ashaid ='".$ashaID."' and a.is_active = 1";
		$ChargeOfUserRow = $this->db->query($query)->result()[0];
		$ChargeOfImei1 = $ChargeOfUserRow->imei1; 
		$ChargeOfImei2 = $ChargeOfUserRow->imei2;


		$ChargeToAshaUID = $this->input->post('ReplacedBy');
		$query = "select imei1, imei2 from tblusers a inner join userashamapping b 
		on a.user_id = b.UserID inner join mstasha c on c.ashaid = b.AshaID where c.ASHAUID ='".$ChargeToAshaUID."' and a.is_active = 1";
		$ChargeToUserRow = $this->db->query($query)->result()[0];
		$ChargeToImei1 = $ChargeToUserRow->imei1; 
		$ChargeToImei2 = $ChargeToUserRow->imei2;


		$content['chargeOF_list'] = $this->db->get_where('tblextracharge',array('IsDeleted'=> 0, 'ChargeOf' => $ChargeToAshaUID))->result();

		if(count($content['chargeOF_list']) > 1){


			$this->session->set_flashdata('er_msg', "There is asha found In the list please select another asha");
			redirect(current_url());
		} 


		$insertArr = array(
			'ChargeTo'			=>	$ashaUID,
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

		$this->Common_Model->insert_data('tblextracharge', $insertArr);


		$query = "select * from mstasha where LanguageID = 1 and ASHAID = ".$ashaID;
		$asha_extra_charge = $this->Common_Model->query_data($query)[0];


			// update IMEI of extra charge in tbuser

		$replace_user_id = $this->Common_Model->get_user_id_from_asha_id($this->input->post('ReplacedBy'));

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
		$this->db->where('ASHAUID',$ashaUID2);
		$this->db->update('mstasha' , $updateArray);



			// For language Id = 2

		$updateArray = array(
			'IsActive'     => 1,
			);
		$this->db->where('ASHAUID',$ashaUID2+1);
		$this->db->update('mstasha' , $updateArray);





		$this->db->trans_complete();

		$this->session->set_flashdata('tr_msg', 'Successfully updated asha');

		if ($this->db->trans_status() === FALSE){
			$this->session->set_flashdata('tr_msg', 'Error in adding Asha extra charge');					
		}else{
			$this->session->set_flashdata('tr_msg', 'Successfully added Asha extra charge');			
		}

		redirect('asha');
	}	


	$content['subview']="extra_charge_replacement";
	$this->load->view('auth/main_layout',$content);
}

	// public function check_extra_charge()
	// {
		// echo "is here";
		// $redire_asha = $this->input->post('redire_asha');
		// return $redire_asha;
		// $res = $this->db->get_where('tblextracharge',array('IsDeleted' => 0))->result();
		// echo count($res);
		// echo $this->db->last_query();
	// }
function delete_extra_charge($ID)
{

		//step 1 - Roll back imei

	$replace_user_id = $this->Common_Model->get_user_id_from_charge_of($ID);
	$cols = array('ChargeOfImei1 as imei1','ChargeOfImei2 as imei2');

	$this->db->select($cols);

	$updateArray = $this->db->get_where('tblextracharge',array('ID'=>$ID))->result_array();
	$this->db->where('user_id',$replace_user_id);
	$this->db->update('tblusers' , $updateArray[0]);

		// step 2 - set the flag IsDeleted of tblextracharge to 1
	$query =  "update tblextracharge set IsDeleted = 1 where ID='".$ID."'";

	$this->db->query($query);
		// die($query);
	$this->session->set_flashdata('tr_msg',"Extra Charge Delete Successfully");
	redirect('asha');
}


function delete($ashaCode=null){

	$query =  "update mstasha set IsDeleted = 1 where ASHACode=$ashaCode";

	$this->db->query($query);
	$this->session->set_flashdata('tr_msg' ,"Asha Deleted Successfully");
	redirect('asha');
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

public function get_anmid_from_anmcode($ANMCode='')
{
	$this->db->where('ANMCode', $ANMCode);
	$result = $this->db->get('mstanm')->result();
	if (count($result) < 1) {
		return null;
	}

	return $result[0]->ANMID;
}


}




