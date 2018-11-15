<?php
// defined('BASEPATH') OR exit('No direct script access allowed');
class MNCH extends Auth_controller {

	public function __construct()
	{
		parent::__construct();
		$this->loginData = $this->session->userdata('loginData');
	}

	public function ANCList($id = NULL,$StateCode = NULL,$ANMCode = NULL,$VillageCode = NULL)
	{

		$user_role = $this->loginData->user_role;
		$query = "SELECT * FROM role_permissions as rp LEFT JOIN mstrole as mst on rp.RoleID=mst.RoleID WHERE rp.RoleID='$user_role' ";

		$content['role_permission'] = $this->Common_Model->query_data($query);

		//end permission 

		$query = "select * from mststate where IsDeleted=0 and LanguageID = 1 ";
		if ($this->loginData->user_role == 1 || $this->loginData->user_role == 2 || $this->loginData->user_role == 3 || $this->loginData->user_role == 6) 	 {
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

		$content['State_List'] = $this->Common_Model->query_data($query);


		$RequestMethod = $this->input->server('REQUEST_METHOD');
		if($RequestMethod == "POST")
		{

			$query = "SELECT * from mstanm a INNER JOIN mstasha b on a.ANMCode=b.ANMCode inner join userashamapping c on c.AshaID=a.ANMUID inner join tblusers d on c.UserID=d.user_id where d.state_code= '".$StateCode."' AND a.LanguageID=1 and a.IsDeleted=0 GROUP by a.ANMName";

			$content['Anm_list'] = $this->Common_Model->query_data($query);

			$query = "SELECT * from mstanm a INNER JOIN mstasha b on a.ANMCode=b.ANMCode inner join userashamapping c on c.AshaID=a.ANMUID inner join tblusers d on c.UserID=d.user_id where a.ANMCode= '".$ANMCode."' AND b.LanguageID=1 and b.IsDeleted=0 GROUP by b.ASHAName";

			$content['Asha_list'] = $this->Common_Model->query_data($query);


		}else{
			$query = "SELECT
						    *
			FROM
			mstanm a
			INNER JOIN useranmmapping b ON
			a.ANMID = b.ANMID
			INNER JOIN tblusers c ON
			b.UserID = c.user_id
			WHERE
			a.IsDeleted = 0 AND a.IsActive = 1 AND c.is_deleted = 0 AND a.LanguageID = 1 AND c.user_mode = 1";

			$content['Anm_list'] = $this->Common_Model->query_data($query);

			// $content['Anm_list'] = array();

			$query = "SELECT
						    *
			FROM
			mstasha a
			INNER JOIN userashamapping b ON
			a.ASHAID = b.AshaID
			INNER JOIN tblusers c ON
			b.UserID = c.user_id
			WHERE
			a.LanguageID = 1 AND a.IsDeleted = 0 AND a.IsActive = 1 AND c.is_deleted = 0 AND c.user_mode = 1";

			$content['Asha_list'] = $this->Common_Model->query_data($query);
			// $content['Asha_list'] = array();


			$query = "SELECT * FROM mstvillage WHERE LanguageID = 1 and IsDeleted = 0";
			$content['Village_list'] = $this->Common_Model->query_data($query);
		}

		$content['subview'] = "list_ANC";
		$this->load->view('auth/main_layout', $content);
	}

	public function DeliveryList($id = NULL,$StateCode = NULL,$ANMCode = NULL,$VillageCode = NULL)
	{

		$user_role = $this->loginData->user_role;
		$query = "SELECT * FROM role_permissions as rp LEFT JOIN mstrole as mst on rp.RoleID=mst.RoleID WHERE rp.RoleID='$user_role' ";

		$content['role_permission'] = $this->Common_Model->query_data($query);

		//end permission 

		$query = "select * from mststate where IsDeleted=0 and LanguageID = 1 ";
		if ($this->loginData->user_role == 1 || $this->loginData->user_role == 2 || $this->loginData->user_role == 3 || $this->loginData->user_role == 6) 	 {
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

		$content['State_List'] = $this->Common_Model->query_data($query);


		$RequestMethod = $this->input->server('REQUEST_METHOD');
		if($RequestMethod == "POST")
		{

			$query = "SELECT * from mstanm a INNER JOIN mstasha b on a.ANMCode=b.ANMCode inner join userashamapping c on c.AshaID=a.ANMUID inner join tblusers d on c.UserID=d.user_id where d.state_code= '".$StateCode."' AND a.LanguageID=1 and a.IsDeleted=0 GROUP by a.ANMName";

			$content['Anm_list'] = $this->Common_Model->query_data($query);

			$query = "SELECT * from mstanm a INNER JOIN mstasha b on a.ANMCode=b.ANMCode inner join userashamapping c on c.AshaID=a.ANMUID inner join tblusers d on c.UserID=d.user_id where a.ANMCode= '".$ANMCode."' AND b.LanguageID=1 and b.IsDeleted=0 GROUP by b.ASHAName";

			$content['Asha_list'] = $this->Common_Model->query_data($query);


		}else{
			$query = "SELECT
									    *
			FROM
			mstanm a
			INNER JOIN useranmmapping b ON
			a.ANMID = b.ANMID
			INNER JOIN tblusers c ON
			b.UserID = c.user_id
			WHERE
			a.IsDeleted = 0 AND a.IsActive = 1 AND c.is_deleted = 0 AND a.LanguageID = 1 AND c.user_mode = 1";

			$content['Anm_list'] = $this->Common_Model->query_data($query);

						// $content['Anm_list'] = array();

			$query = "SELECT
									    *
			FROM
			mstasha a
			INNER JOIN userashamapping b ON
			a.ASHAID = b.AshaID
			INNER JOIN tblusers c ON
			b.UserID = c.user_id
			WHERE
			a.LanguageID = 1 AND a.IsDeleted = 0 AND a.IsActive = 1 AND c.is_deleted = 0 AND c.user_mode = 1";

			$content['Asha_list'] = $this->Common_Model->query_data($query);
						// $content['Asha_list'] = array();


			$query = "SELECT * FROM mstvillage WHERE LanguageID = 1 and IsDeleted = 0";
			$content['Village_list'] = $this->Common_Model->query_data($query);
		}

		$content['subview'] = "list_PNC";
		$this->load->view('auth/main_layout', $content);
	}



	public function index1($id = NULL,$StateCode = NULL,$ANMCode = NULL,$VillageCode = NULL)
	{

		$user_role = $this->loginData->user_role;
		$query = "SELECT * FROM role_permissions as rp LEFT JOIN mstrole as mst on rp.RoleID=mst.RoleID WHERE rp.RoleID='$user_role' ";

		$content['role_permission'] = $this->Common_Model->query_data($query);

		//end permission 

		$query = "select * from mststate where IsDeleted=0 and LanguageID = 1 ";
		if ($this->loginData->user_role == 1 || $this->loginData->user_role == 2 || $this->loginData->user_role == 3 || $this->loginData->user_role == 6) 	 {
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

		$content['State_List'] = $this->Common_Model->query_data($query);


		$RequestMethod = $this->input->server('REQUEST_METHOD');
		if($RequestMethod == "POST")
		{

			$query = "SELECT * from mstanm a INNER JOIN mstasha b on a.ANMCode=b.ANMCode inner join userashamapping c on c.AshaID=a.ANMUID inner join tblusers d on c.UserID=d.user_id where d.state_code= '".$StateCode."' AND a.LanguageID=1 and a.IsDeleted=0 GROUP by a.ANMName";

			$content['Anm_list'] = $this->Common_Model->query_data($query);

			$query = "SELECT * from mstanm a INNER JOIN mstasha b on a.ANMCode=b.ANMCode inner join userashamapping c on c.AshaID=a.ANMUID inner join tblusers d on c.UserID=d.user_id where a.ANMCode= '".$ANMCode."' AND b.LanguageID=1 and b.IsDeleted=0 GROUP by b.ASHAName";

			$content['Asha_list'] = $this->Common_Model->query_data($query);


		}else{
			$content['Anm_list'] = array();
			$content['Asha_list'] = array();
		}

		$content['subview'] = "list_PNC";
		$this->load->view('auth/main_layout', $content);
	}



	public function ANC_visit_list($pwGUID = NULL)
	{
		$query = "select a.*,
		b.*,
		( CASE when b.IsDeleted = 0 THEN 'No' when b.IsDeleted = 1 THEN 'Yes' END) AS Deleted
		from tblpregnant_woman a 
		inner join tblancvisit b 
		on a.pwGUID = b.PWGUID
		where a.pwGUID = ? and a.IsDeleted = 0 order by b.Visit_No asc ";
		$content['anc_list'] = $this->db->query($query, [$pwGUID])->result();
		

		$query = "select a.*,
		b.*
		from tblpregnant_woman a 
		inner join tblancvisit b 
		on a.pwGUID = b.PWGUID
		where a.pwGUID = ?";
		$content['anc_name'] = $this->db->query($query, [$pwGUID])->result()[0];

		$content['subview'] = "details_pregwoman";
		$this->load->view('auth/main_layout', $content);
	}

	public function child_details($pwGUID = NULL)
	{
		// print_r($pwGUID);die();
		$query = "select
		a.*,
		b.*,
		( CASE when b.IsDeleted = 0 THEN 'No' when b.IsDeleted = 1 THEN 'Yes' END) AS IsDeleted
		FROM
		tblpregnant_woman a
		INNER JOIN tblchild b ON
		a.HHGUID = b.HHGUID
		WHERE
		a.pwGUID = ?";
		$content['pnc_list'] = $this->db->query($query, [$pwGUID])->result();

		$content['subview'] = "details_non_pregwoman";
		$this->load->view('auth/main_layout', $content);
	}


	public function delete_pnc_visit($PNCGUID = NULL)
	{

		// print_r($PNCGUID);die();
		$query = "select ChildGUID from tblpnchomevisit_ans where PNCGUID = ?";
		// print_r($query);die();
		$child_data = $this->db->query($query, [$PNCGUID])->result()[0];
		$ChildGUID =  $child_data->ChildGUID;

		$query = "update tblpnchomevisit_ans set IsDeleted = 1 where PNCGUID =  '$PNCGUID'";
		// print_r($query);die();
		$this->db->query($query);

		$query = "update tblpnchomevisit_ans set UpdatedOn='". date('Y-m-d h:i:s')."' where PNCGUID = '$PNCGUID'";
			// print_r($query);die();
		$this->db->query($query);

		// $query = "update tblpnchomevisit_ans set UpdatedBy = '".$this->loginData['user_id']."' where childGUID = '$childGUID'";

		// print_r($query);die();


		$this->session->set_flashdata('tr_msg' ,"PNC Visit Deleted Successfully");
		redirect('MNCH/child_PNC/'.$ChildGUID);
	}


	public function delete_child_pnc($childGUID = NULL)
	{

		$query = "select pw_GUID from tblchild where childGUID = ?";
		$PWGUID_data = $this->db->query($query, [$childGUID])->result()[0];
		$pw_GUID =  $PWGUID_data->pw_GUID;

		$query = "update tblchild set IsDeleted = 1 where childGUID =  '$childGUID'";
		$this->db->query($query);

		$query = "update tblpnchomevisit_ans set IsDeleted = 1 where childGUID = '$childGUID'";
		$this->db->query($query);

		$this->session->set_flashdata('tr_msg' ,"Child and PNC Visits Deleted Successfully");
		redirect('MNCH/non_preg_woman/'.$pw_GUID);
	}

	public function delete_nonpregwoman_child_pnc($pwGUID = NULL)
	{

		$query = "update tblpregnant_woman set UpdatedOn='". date('Y-m-d h:i:s')."', IsPregnant = 1  where pwGUID = '$pwGUID'";

		$this->db->query($query);

		// $query = "update tblpregnant_woman set UpdatedOn='". date('Y-m-d h:i:s')."', IsDeleted = 1 where pwGUID =  '$pwGUID'";
		// $this->db->query($query);

		$query = "update tblchild set modified_on='". date('Y-m-d h:i:s')."', IsDeleted = 1 where pw_GUID =  '$pwGUID'";

		$this->db->query($query);

		// $query = "update  tblpnchomevisit_ans c INNER JOIN tblchild b on b.childGUID=c.ChildGUID set UpdatedOn='". date('Y-m-d h:i:s')."', c.IsDeleted=1   where  b.pw_GUID= '$pwGUID' ";

		// $this->db->query($query);


     //record not delted
		$query = "update  tblmstimmunizationans c INNER JOIN tblchild b on b.childGUID=c.ChildGUID set UpdatedOn='". date('Y-m-d h:i:s')."', c.IsDeleted=1   where  b.pw_GUID= '$pwGUID' ";

		$this->db->query($query);

		$this->session->set_flashdata('tr_msg' ,"PNC Data Deleted Successfully");
		redirect('MNCH/PNCList');
	}

	public function edit_anc_visit_list($VisitGUID = NULL, $PWGUID = NULL)
	{

		$query = "select PWGUID from tblancvisit where VisitGUID = ?";
		$PWGUID_data = $this->db->query($query, [$VisitGUID])->result()[0];
		$PWGUID =  $PWGUID_data->PWGUID;
		// print_r($PWGUID_data);die();

		$RequestMethod = $this->input->server('REQUEST_METHOD');
		
		if($RequestMethod == "POST"){

			$operation = $this->input->post("operation");
			if ($operation == "reset") {
				
				$updateArr = array(
					'Visit_No' 		=> $this->input->post('Visit_No'),
					'VisitDueDate' 	=> $this->input->post('VisitDueDate'),
					'CheckupVisitDate'  => $this->input->post(''),
					'BP' 	=> $this->input->post('NULL'),
					'Hemoglobin'	=> $this->input->post('NULL'),
					'TTfirstDoseDate'	=> $this->input->post('NULL'),
					'TTsecondDoseDate'	=> $this->input->post('NULL'),
					'TTboosterDate'	=> $this->input->post('NULL'),
					'TT1'	=> $this->input->post('NULL'),
					'TT1date'	=> $this->input->post('NULL'),
					'TT2'	=> $this->input->post('NULL'),
					'TT2date'	=> $this->input->post('NULL'),
					'TTbooster'	=> $this->input->post('NULL'),
					'TTboosterDate1'	=> $this->input->post('NULL'),
					'BP1'	=> $this->input->post('NULL'),
					'HB1'	=> $this->input->post('NULL'),
					'IsDeleted'	=> '0'
				);
				// print_r($updateArr);die();

				$this->db->update('tblancvisit',$updateArr);
				if($flag) $this->session->set_flashdata('tr_msg','Data Updated Successfully.'); 
				else $this->session->set_flashdata('er_msg','Something Went Wrong!! Please Try Again');
				redirect('MNCH/edit_anc_visit_list/'.$VisitGUID);

			}

			$data = array(
				'Visit_No' 		=> $this->input->post('Visit_No'),
				'VisitDueDate' 	=> $this->input->post('VisitDueDate'),
				'CheckupVisitDate'  => $this->input->post('CheckupVisitDate'),
				'BP' 	=> $this->input->post('BP'),
				'Hemoglobin'	=> $this->input->post('Hemoglobin'),
				'TTfirstDoseDate'	=> $this->input->post('TTfirstDoseDate'),
				'TTsecondDoseDate'	=> $this->input->post('TTsecondDoseDate'),
				'TTboosterDate'	=> $this->input->post('TTboosterDate'),
				'TT1'	=> $this->input->post('TT1'),
				'TT1date'	=> $this->input->post('TT1date'),
				'TT2'	=> $this->input->post('TT2'),
				'TT2date'	=> $this->input->post('TT2date'),
				'TTbooster'	=> $this->input->post('TTbooster'),
				'TTboosterDate1'	=> $this->input->post('TTboosterDate1'),
				'BP1'	=> $this->input->post('BP1'),
				'HB1'	=> $this->input->post('HB1'),
				'IsDeleted'	=> $this->input->post('IsDeleted')
			);
			// print_r($data);die();

			$this->db->where('VisitGUID',$VisitGUID);
				// $this->db->where('PWGUID',$PWGUID);
			$flag = $this->db->update('tblancvisit',$data);
			if($flag) $this->session->set_flashdata('tr_msg','Data Updated Successfully.'); 
			else $this->session->set_flashdata('er_msg','Something Went Wrong!! Please Try Again');
			redirect('MNCH/ANC_visit_list/'.$PWGUID);
		}
		$query = "select * from tblancvisit
		where VisitGUID = ?";
		$content['anc_data'] = $this->db->query($query, [$VisitGUID])->result()[0];

		$content['subview'] = "edit_preg_woman";
		$this->load->view('auth/main_layout', $content);

	}


	public function delete_preg_woman($VisitGUID = NULL)
	{
		$query = "select PWGUID from tblancvisit where VisitGUID = ?";
		$PWGUID_data = $this->db->query($query, [$VisitGUID])->result()[0];
		$PWGUID =  $PWGUID_data->PWGUID;
		$query = "update tblancvisit set IsDeleted = 1 where VisitGUID =  '$VisitGUID'";
				// print_r($query);die();
		$this->db->query($query);

		$query = "update tblancvisit set CheckupVisitDate = NULL where VisitGUID = '$VisitGUID'";
		$this->db->query($query);
		$this->session->set_flashdata('tr_msg' ,"ANC Visit Deleted Successfully");
		redirect('MNCH/ANC_visit_list/'.$PWGUID);
	}




	public function edit_anc_list($pwGUID = NULL)
	{

		// get the ashaID from ashaUID
		$this->db->where('PWGUID',$pwGUID);
		$result = $this->db->get('tblpregnant_woman')->result();

		// print_r($result); die();
		if (count($result) < 1) {
			$this->session->set_flashdata('er_msg', "No Pregnent Woman reference set for this ID");
			redirect('MNCH/ANC_visit_list/');
		}

		$HHFamilyMemberGUID = $result[0]->HHFamilyMemberGUID;
		$PWName = $result[0]->PWName;
		$LMPDate = $result[0]->LMPDate;
		$PWGUID = $result[0]->PWGUID;
		// print_r($PWGUID); die();


		$RequestMethod = $this->input->server('REQUEST_METHOD');
		
		if($RequestMethod == "POST"){
			$data = array(
				'PWName' 		=> $this->input->post('PWName'),
				'LMPDate' 	=> $this->input->post('LMPDate'),
				'PWRegistrationDate'  => $this->input->post('PWRegistrationDate'),
				'HusbandName' 	=> $this->input->post('HusbandName'),
				'MobileNo'	=> $this->input->post('MobileNo'),
				'Accountno'	=> $this->input->post('Accountno')
			);
			// print_r($data);die();

			$this->db->where('pwGUID',$pwGUID);
				// $this->db->where('PWGUID',$PWGUID);
			$flag = $this->db->update('tblpregnant_woman',$data);
			if($flag) $this->session->set_flashdata('tr_msg','Data Updated Successfully.'); 
			else $this->session->set_flashdata('er_msg','Something Went Wrong!! Please Try Again');
			redirect('MNCH/ANCList/'.$pwGUID);
		}
		// print_r($PWGUID);die();



		$query = "select * from tblpregnant_woman
		where pwGUID = ?";
		$content['anc_data'] = $this->db->query($query, [$pwGUID])->result()[0];




		$PNG_TEMP_DIR = FCPATH . 'temp/';
		$PNG_WEB_DIR = FCPATH . 'datafiles/';
		$content['PNG_FILENAME'] = uniqid() . ".png";

		include FCPATH . "application/libraries/phpqrcode/qrlib.php";

		$data = json_encode(["data"=>[0=>[
			"HHFamilyMemberGUID" =>	($HHFamilyMemberGUID),
			"PWGUID"             =>	($pwGUID),
			"PWName"			=>	($PWName),
			"LMPDate"			=> ($LMPDate),
		]]], JSON_UNESCAPED_UNICODE);
		// print_r($data); die();


		define('IMAGE_WIDTH',500);
		define('IMAGE_HEIGHT',500);

		QRcode::png($data, $PNG_WEB_DIR . $content['PNG_FILENAME'], 'H', 4, 6);

		// print_r($content['PNG_FILENAME']); die();

		$content['subview'] = "edit_anc_list";
		$this->load->view('auth/main_layout', $content);
	}


	public function edit_non_preg_woman($pwGUID = NULL)
	{
		// print_r($pwGUID);die();


		// get the ashaID from ashaUID
		$this->db->where('PWGUID',$pwGUID);
		$result = $this->db->get('tblpregnant_woman')->result();

		// print_r($result); die();
		if (count($result) < 1) {
			$this->session->set_flashdata('er_msg', "No Pregnent Woman reference set for this ID");
			redirect('MNCH/ANC_visit_list/');
		}

		$HHFamilyMemberGUID = $result[0]->HHFamilyMemberGUID;
		$PWName = $result[0]->PWName;
		$LMPDate = $result[0]->LMPDate;
		// print_r($HHFamilyMemberGUID); die();

		$RequestMethod = $this->input->server('REQUEST_METHOD');
		
		if($RequestMethod == "POST"){
			$data = array(
				'PWName' 		=> $this->input->post('PWName'),
				'LMPDate' 	=> $this->input->post('LMPDate'),
				'PWRegistrationDate'  => $this->input->post('PWRegistrationDate'),
				'HusbandName' 	=> $this->input->post('HusbandName'),
				'MobileNo'	=> $this->input->post('MobileNo'),
				'Accountno'	=> $this->input->post('Accountno')
			);
			// print_r($data);die();

			$this->db->where('pwGUID',$pwGUID);
				// $this->db->where('PWGUID',$PWGUID);
			$flag = $this->db->update('tblpregnant_woman',$data);
			if($flag) $this->session->set_flashdata('tr_msg','Data Updated Successfully.'); 
			else $this->session->set_flashdata('er_msg','Something Went Wrong!! Please Try Again');
			redirect('MNCH/PNCList/'.$pwGUID);
		}

		$query = "select * from tblpregnant_woman
		where pwGUID = ?";
		$content['pnc_data'] = $this->db->query($query, [$pwGUID])->result()[0];



		$PNG_TEMP_DIR = FCPATH . 'temp/';
		$PNG_WEB_DIR = FCPATH . 'datafiles/';
		$content['PNG_FILENAME'] = uniqid() . ".png";

		include FCPATH . "application/libraries/phpqrcode/qrlib.php";

		$data = json_encode([
			"HHSurveyGUID"       =>	uniqid(NULL),
			"HHFamilyMemberGUID" =>	uniqid($HHFamilyMemberGUID),
			"ChildGUID"          =>	uniqid(NULL),
			"PWGUID"             =>	uniqid($pwGUID),
			"PWName"			=>	uniqid($PWName),
			"LMPDate"			=> uniqid($LMPDate),
		]);
		// print_r($data); die();


		QRcode::png($data, $PNG_WEB_DIR . $content['PNG_FILENAME'], 'H', 2, 4);


		$content['subview'] = "edit_pnc_details";
		$this->load->view('auth/main_layout', $content);
	}

	public function edit_child_details($childGUID = NULL)
	{
		//die($childGUID);

		$query = "SELECT
				    *
		FROM
		tblchild a
		INNER JOIN tblpregnant_woman b ON
		a.HHGUID = b.HHGUID
		INNER JOIN tblhhfamilymember c ON
		c.HHFamilyMemberGUID = b.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey d ON
		d.HHSurveyGUID = c.HHSurveyGUID  where a.childGUID = ?";
		$PWGUID_data = $this->db->query($query, [$childGUID])->result()[0];
		// print_r($PWGUID_data); die();


		$PWGUID =  $PWGUID_data->PWGUID;
		$HHFamilyMemberGUID =  $PWGUID_data->HHFamilyMemberGUID;
		$PWName =  $PWGUID_data->PWName;
		$child_dob =  $PWGUID_data->child_dob;
		$child_name =  $PWGUID_data->child_name;
		$HHSurveyGUID = $PWGUID_data->HHSurveyGUID;
		$HusbandName = $PWGUID_data->HusbandName;
		$child_dob = $PWGUID_data->child_dob;
		// print_r($child_dob);die;

		$RequestMethod = $this->input->server('REQUEST_METHOD');
		
		if($RequestMethod == "POST")
		{

			$operation = $this->input->post("operation");
			if ($operation == "reset") {
				
				$updateArr = array(
					'Date_Of_Registration' 		=> $this->input->post('Date_Of_Registration'),
					'child_dob' 	=> $this->input->post('child_dob'),
					'birth_time'  => $this->input->post('birth_time'),
					'Gender' 	=> $this->input->post('Gender'),
					'Wt_of_child'	=> $this->input->post('Wt_of_child'),
					'child_name'	=> $this->input->post('child_name'),
					'bcg'     		 		=>	$this->input->post('NULL'),
					'hepb1'					=>	$this->input->post('NULL'),
					'opv1'				    =>	$this->input->post('NULL'),
					'opv2'					=>	$this->input->post('NULL'),
					'opv3'					=>	$this->input->post('NULL'),
					'dpt1'					=>	$this->input->post('NULL'),
					'dpt2'					=>	$this->input->post('NULL'),
					'dpt3'					=>	$this->input->post('NULL'),				
					'hepb2'					=>	$this->input->post('NULL'),
					'hepb3'					=>	$this->input->post('NULL'),
					'Pentavalent1'			=>	$this->input->post('NULL'),
					'Pentavalent2'			=>	$this->input->post('NULL'),
					'Pentavalent3'			=>	$this->input->post('NULL'),
					'IPV'					=>	$this->input->post('NULL'),
					'measeals'				=>	$this->input->post('NULL'),
					'vitaminA'            	=> $this->input->post('NULL'),
					'JEVaccine1'           	=> $this->input->post('NULL'),
					'OPVBooster'			=>	$this->input->post('NULL'),
					'DPTBooster'			=>	$this->input->post('NULL'),
					'MeaslesTwoDose'		=>	$this->input->post('NULL'),	
					"modified_on"            =>	date('Y-m-d h:i:s')
				);
				// print_r($updateArr);die();
				$this->db->where('childGUID', $childGUID);
				$this->db->update('tblchild',$updateArr);
				if($flag) $this->session->set_flashdata('tr_msg','Data Updated Successfully.'); 
				else $this->session->set_flashdata('er_msg','Something Went Wrong!! Please Try Again');
				redirect('MNCH/edit_child_details/'.$childGUID);

			}
			$data = array(
				'Date_Of_Registration' 		=> $this->input->post('Date_Of_Registration'),
				'child_dob' 	=> $this->input->post('child_dob'),
				'birth_time'  => $this->input->post('birth_time'),
				'Gender' 	=> $this->input->post('Gender'),
				'Wt_of_child'	=> $this->input->post('Wt_of_child'),
				'child_name'	=> $this->input->post('child_name'),
				'bcg'     		 		=>	$this->input->post('bcg'),
				'hepb1'					=>	$this->input->post('hepb1'),
				'opv1'				    =>	$this->input->post('opv1'),
				'opv2'					=>	$this->input->post('opv2'),
				'opv3'					=>	$this->input->post('opv3'),
				'dpt1'					=>	$this->input->post('dpt1'),
				'dpt2'					=>	$this->input->post('dpt2'),
				'dpt3'					=>	$this->input->post('dpt3'),				
				'hepb2'					=>	$this->input->post('hepb2'),
				'hepb3'					=>	$this->input->post('hepb3'),
				'Pentavalent1'			=>	$this->input->post('Pentavalent1'),
				'Pentavalent2'			=>	$this->input->post('Pentavalent2'),
				'Pentavalent3'			=>	$this->input->post('Pentavalent3'),
				'IPV'					=>	$this->input->post('IPV'),
				'measeals'				=>	$this->input->post('measeals'),
				'vitaminA'            	=>  $this->input->post('vitaminA'),
				'JEVaccine1'           	=>  $this->input->post('JEVaccine1'),
				'OPVBooster'			=>	$this->input->post('OPVBooster'),
				'DPTBooster'			=>	$this->input->post('DPTBooster'),
				'MeaslesTwoDose'		=>	$this->input->post('MeaslesTwoDose'),	
				"modified_on"           =>	date('Y-m-d h:i:s')
			);
			// print_r($data);die();

			$this->db->where('childGUID',$childGUID);
				// $this->db->where('PWGUID',$PWGUID);
			$flag = $this->db->update('tblchild',$data);
			if($flag) $this->session->set_flashdata('tr_msg','Data Updated Successfully.'); 
			else $this->session->set_flashdata('er_msg','Something Went Wrong!! Please Try Again');
			redirect('MNCH/child_details/'.$PWGUID);
		}

		$query = "select * from tblchild
		where childGUID = ?";
		$content['child_data'] = $this->db->query($query, [$childGUID])->result()[0];

		// print_r($content['child_data']); die();
		$PNG_TEMP_DIR = FCPATH . 'temp/';
		$PNG_WEB_DIR = FCPATH . 'datafiles/';
		$content['PNG_FILENAME'] = uniqid() . ".png";

		include FCPATH . "application/libraries/phpqrcode/qrlib.php";

		$data = json_encode(["data"=>[0=>[
			"HHSurveyGUID"       =>	($HHSurveyGUID),
			"HHFamilyMemberGUID" =>	($HHFamilyMemberGUID),
			"ChildGUID"          =>	($childGUID),
			"PWGUID"             =>	($PWGUID),
			"PWName"             =>	($PWName),
			"child_dob"			=> ($child_dob),
			"child_name"			=> ($child_name),
			"HusbandName" => ($HusbandName),
		]]], JSON_UNESCAPED_UNICODE);

		// print_r($data); die();


		QRcode::png($data, $PNG_WEB_DIR . $content['PNG_FILENAME'], 'H', 2, 4);

		$content['subview'] = "edit_child_details";
		$this->load->view('auth/main_layout', $content);
	}

	public function child_PNC($childGUID = NULL)
	{
		// print_r($childGUID);die();
		$query = "select a.*,
		b.VisitNo, b.IsDeleted,Q_0,b.PNCGUID,
		( CASE when b.IsDeleted = 0 THEN 'No' when b.IsDeleted = 1 THEN 'Yes' END) AS IsDeleted
		FROM
		tblchild a
		INNER JOIN
		tblpnchomevisit_ans b
		ON
		a.childGUID = b.childGUID
		WHERE
		a.childGUID = ?";
		$content['child_list'] = $this->db->query($query, [$childGUID])->result();
		// print_r($query);die();
		$content['subview'] = "details_child_pnc";
		$this->load->view('auth/main_layout', $content);
	}


	public function edit_pnc_list($PWGUID = NULL)
	{
		print_r($PWGUID);die();
		$query = "select * from tblpregnant_woman
		where PWGUID = ?";
		$content['pnc_data'] = $this->db->query($query, [$VisitGUID])->result()[0];

		$content['subview'] = "edit_pnc_list";
		$this->load->view('auth/main_layout', $content);
	}

	public function delete_anc_list($PWGUID = NULL)
	{
		
		$query = "update tblpregnant_woman set IsDeleted = 1 where PWGUID =  '$PWGUID'";
		$this->db->query($query);

		$query = "update tblancvisit set IsDeleted = 1 where PWGUID = '$PWGUID'";
		$this->db->query($query);

		$this->session->set_flashdata('tr_msg' ,"Data Deleted Successfully");
		redirect('MNCH/ANCList');
	}
	


	public function detail_preg_woman($HHSurveyGUID = NULL)
	{
		$content['subview'] = "details_pregwoman";
		$this->load->view('auth/main_layout', $content);
	}


	public function getANCList()
	{
		$searchPhrase = $this->input->post('searchPhrase');
		$StateCode = $this->input->post('StateCode');
		$ANMID = $this->input->post('ANMID');
		$ASHAID = $this->input->post('ASHAID');
		$VillageCode = $this->input->post('VillageCode');
		$IsDeleted = $this->input->post('IsDeleted');
		// die($ANMID);

		$query ="select
		*
		FROM
		(
			select
			a.IsPregnant,
			a.PWName,
			a.HusbandName,
			b.HHCode,
			b.HHSurveyGUID,
			a.pwGUID,
			a.LMPDate,
			a.ANMID,
			a.AshaID,
			b.VillageID,
			a.HHGUID,
			b.SubCenterID,
			a.IsDeleted
			FROM
			tblpregnant_woman a
			INNER JOIN tblhhsurvey b ON
			a.HHGUID = b.hhsurveyGUID
			WHERE
			a.IsPregnant = 1 and a.IsDeleted = 0 and b.IsDeleted = 0 and a.CreatedBy in (select user_id from tblusers where is_deleted=0 and user_mode= 1)
		) a
		left JOIN(
			SELECT
			ASHAName,
			ASHAID,
			ASHACode
			FROM
			mstasha
			WHERE
			LanguageID = 1 AND IsDeleted = 0 and IsActive = 1
		) c
		ON
		a.ASHAID = c.ASHAID
		left JOIN(
			SELECT
			ANMName,
			ANMID,
			ANMCode
			FROM
			mstanm
			WHERE
			LanguageID = 1 AND IsDeleted = 0 and IsActive = 1
		) d
		ON
		a.ANMID = d.ANMID
		left JOIN(
			SELECT
			VillageName,
			VillageID,
			VillageCode
			FROM
			mstvillage
			WHERE
			LanguageID = 1
		) e
		ON
		e.VillageID = a.VillageID 
		
		Where a.pwGUID is NOT NULL";

     	// print_r($query);die();

		if ($ANMID != "") {
			$query .= " and a.ANMID = $ANMID ";
		}

		if ($ASHAID != "") {
			$query .= " and a.AshaID = $ASHAID ";
		}

		if ($VillageCode != "") {
			$query .= " and e.VillageCode = $VillageCode ";
		}

		if ($IsDeleted == "1") {
			$query .= " and a.IsDeleted = 1 ";
		}else if($IsDeleted == "2") {
			$query .= " and a.IsDeleted = 0 ";
		}
			// print_r($query);die();

		//extraQuery for search dialog

		$extraQuery = " and (f.SubCenterName like '".$searchPhrase."%'
		or d.ANMName like '".$searchPhrase."%'
		or c.ASHAName like '".$searchPhrase."%'
		or a.PWName like '".$searchPhrase."%'
		or a.HusbandName like '".$searchPhrase."%'
		or a.HHCode like '".$searchPhrase."%'
		or e.VillageName like '".$searchPhrase."%')";
		if($searchPhrase != "") $query .= $extraQuery;

     	// print_r($extraQuery);die();

		//order by clause
		$sort = $this->input->post('sort');
		if ($sort != NULL) 
		{
			$sortBy = array_keys($sort);

			switch($sortBy[0]){
				case "SubCenterName":
				$orderQuery = " order by f.SubCenterName " . $sort[$sortBy[0]];
				break;
				case "ANMName":
				$orderQuery = " order by d.ANMName " . $sort[$sortBy[0]];
				break;
				case "ASHAName":
				$orderQuery = " order by c.ASHAName " . $sort[$sortBy[0]];
				break;
				case "VillageName":
				$orderQuery = " order by e.VillageName " . $sort[$sortBy[0]];
				break;
				case "IsDeleted":
				$orderQuery = " order by a.IsDeleted " . $sort[$sortBy[0]];
				break;
				default:
				$orderQuery = " order by c.HHSurveyGUID " . $sort[$sortBy[0]];
				break;
				default:
				$orderQuery = " order by a.PWName " . $sort[$sortBy[0]];
				break;
				default:
				$orderQuery = " order by a.HusbandName " . $sort[$sortBy[0]];
				break;
				default:
				$orderQuery = " order by c.HHCode " . $sort[$sortBy[0]];
				break;
				default:
				$orderQuery = " order by a.LMPDate " . $sort[$sortBy[0]];
				break;
			}

			$query .= $orderQuery ;

		}

		$tmp = $this->db->query($query);
		$total = $tmp->num_rows();

		$current = (int)$this->input->post('current');
		$rowCount = (int)$this->input->post('rowCount');

		//limit conditions
		$limitQuery = " limit ".($current - 1)*($rowCount).",".$rowCount;
		$query .= $limitQuery;

		$Mnch_list = $this->Common_Model->query_data($query);

		$returnArray = array(
			"current"		=>	$this->input->post('current'),
			"rowCount"		=>	$this->input->post('rowCount'),
			"total"			=>	$total,
			"rows"			=>	$Mnch_list,
		);

		echo json_encode($returnArray);	

	}


	public function getPNCList()
	{

		$searchPhrase = $this->input->post('searchPhrase');
		$StateCode = $this->input->post('StateCode');
		$ANMID = $this->input->post('ANMID');
		$ASHAID = $this->input->post('ASHAID');
		$VillageCode = $this->input->post('VillageCode');
		$Verified = $this->input->post('Verified');
		$IsDeleted = $this->input->post('IsDeleted');

		$query ="select * FROM
		(
			SELECT
			a.IsPregnant,
			a.PWName,
			b.FamilyMemberName,
			c.HHCode,
			c.HHSurveyGUID,
			a.pwGUID,
			a.LMPDate,
			a.DeliveryDateTime,
			a.ANMID,
			a.AshaID,
			c.VillageID,
			a.HHGUID,
			c.SubCenterID,
			a.IsDeleted,
			( CASE when a.DeliveryType = 1 Then 'Livebirth' when a.DeliveryType = 2 THEN 'StillBirth' when a.DeliveryType = 3 THEN 'NeonatalDeath' END) AS DeliveryType
			FROM
			tblpregnant_woman a
			INNER JOIN tblhhfamilymember b ON
			a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
			INNER JOIN tblhhsurvey c ON
			b.hhsurveyGUID = c.hhsurveyGUID
			where a.IsPregnant = 0 			
			and 
			a.DeliveryDateTime >= date_add(date_format(now(),'%Y-%m-%d'), INTERVAL -1 YEAR) and a.DeliveryDateTime < date_format(now(),'%Y-%m-%d')
		) a
		LEFT JOIN(
			SELECT 
			HHSurveyGUID,
			FamilyMemberName
			FROM
			tblhhfamilymember as HeadName
			WHERE
			RelationID = 1
			GROUP BY
			hhsurveyGUID
		) b
		ON
		a.hhsurveyGUID = b.hhsurveyGUID

		LEFT JOIN(
			SELECT
			ASHAName,
			ASHAID,
			ASHACode
			FROM
			mstasha
			WHERE
			LanguageID = 1
		) c
		ON
		a.ASHAID = c.ASHAID
		LEFT JOIN(
			SELECT
			ANMName,
			ANMID,
			ANMCode
			FROM
			mstanm
			WHERE
			LanguageID = 1
		) d
		ON
		a.ANMID = d.ANMID
		LEFT JOIN(
			SELECT
			VillageName,
			VillageID,
			VillageCode
			FROM
			mstvillage
			WHERE
			LanguageID = 1
		) e
		ON
		e.VillageID = a.VillageID
		LEFT JOIN(
			SELECT
			SubCenterName,
			SubCenterCode,
			SubCenterID
			FROM
			mstsubcenter
			WHERE
			LanguageID = 1
		) f
		ON
		f.SubCenterID = a.SubCenterID
		Where a.pwGUID is NOT NULL
		";



     		//die($query);
     		// if ($StateCode != "") {
     		// 	$query .= " and mststate.StateCode=$StateCode";
     		// }

		if ($ANMID != "") {
			$query .= " and a.ANMID = $ANMID ";
		}

		if ($ASHAID != "") {
			$query .= " and a.ASHAID = $ASHAID ";
		}


		if ($VillageCode != "") {
			$query .= " and e.VillageCode = $VillageCode ";
		}

		if ($IsDeleted == 1) {
			$query .= " and a.IsDeleted = 1 ";
		}else if($IsDeleted == 2) {
			$query .= " and a.IsDeleted = 0 ";
		}

     		//extraQuery for search dialog

		$extraQuery = " and (f.SubCenterName like '".$searchPhrase."%'
		or d.ANMName like '".$searchPhrase."%'
		or c.ASHAName like '".$searchPhrase."%'
		or a.PWName like '".$searchPhrase."%'
		or b.FamilyMemberName like '".$searchPhrase."%'
		or a.HHCode like '".$searchPhrase."%'
		or e.VillageName like '".$searchPhrase."%')";
		if($searchPhrase != "") $query .= $extraQuery;

     		//order by clause
		$sort = $this->input->post('sort');
		if ($sort != NULL) 
		{
			$sortBy = array_keys($sort);

			switch($sortBy[0]){
				case "SubCenterName":
				$orderQuery = " order by f.SubCenterName " . $sort[$sortBy[0]];
				break;
				case "ANMName":
				$orderQuery = " order by d.ANMName " . $sort[$sortBy[0]];
				break;
				case "ASHAName":
				$orderQuery = " order by c.ASHAName " . $sort[$sortBy[0]];
				break;
				case "VillageName":
				$orderQuery = " order by e.VillageName " . $sort[$sortBy[0]];
				break;
				case "IsDeleted":
				$orderQuery = " order by a.IsDeleted " . $sort[$sortBy[0]];
				break;
				default:
				$orderQuery = " order by c.HHSurveyGUID " . $sort[$sortBy[0]];
				break;
				default:
				$orderQuery = " order by a.PWName " . $sort[$sortBy[0]];
				break;
				default:
				$orderQuery = " order by b.FamilyMemberName " . $sort[$sortBy[0]];
				break;
				default:
				$orderQuery = " order by c.HHCode " . $sort[$sortBy[0]];
				break;
				default:
				$orderQuery = " order by a.DeliveryDateTime " . $sort[$sortBy[0]];
				break;
			}

			$query .= $orderQuery ;

		}
		$tmp = $this->db->query($query);
		$total = $tmp->num_rows();

		$current = (int)$this->input->post('current');
		$rowCount = (int)$this->input->post('rowCount');

     			//limit conditions
		$limitQuery = " limit ".($current - 1)*($rowCount).",".$rowCount;
		$query .= $limitQuery;

     		 //die($limitQuery);

		$Mnch_list = $this->Common_Model->query_data($query);

		$returnArray = array(
			"current"		=>	$this->input->post('current'),
			"rowCount"		=>	$this->input->post('rowCount'),
			"total"			=>	$total,
			"rows"			=>	$Mnch_list,
		);

		echo json_encode($returnArray);	

	}

	public function qr_code($HHGUID = 'NULL')
	{


		$this->db->trans_start();


		$this->db->trans_complete();
		

		$this->load->model('Data_export_model');
		$this->Data_export_model->export_pdf($query);

	}

}