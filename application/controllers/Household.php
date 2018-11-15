<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Household extends Auth_controller {

	public function __construct()
	{
		parent::__construct();
		$this->loginData = $this->session->userdata('loginData');
		$this->load->library('session');
	}

	public function index($StateCode="NULL",$ANMCode="NULL", $AshaCode= "NULL")
	{	
		// echo "<pre>";
		// die(print_r($_SESSION));


		// start permission 

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
			$query = "SELECT  *
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

			$query = "SELECT   *
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

		$content['subview'] = "list_household";
		$this->load->view('auth/main_layout', $content);
	}

	public function familymembers($uid=null, $export_familymembers = NULL)
	{		

		// print_r($HHFamilyMemberGUID); die();

		$HHSurveyGUID = $this->input->post('HHSurveyGUID');

		$query = "select HHFamilyMemberCode,HHFamilyMemberGUID,FamilyMemberName,AprilAgeYear,AprilAgeMonth,(
			CASE WHEN GenderID = NULL THEN '' WHEN GenderID = 1 THEN 'Male' WHEN GenderID = 2 THEN 'Female' WHEN GenderID = 3 THEN 'Other' WHEN GenderID = 4 THEN 'Other' END
		) AS GenderID,

		( CASE when tblhhfamilymember.IsDeleted = 0 THEN 'No' when tblhhfamilymember.IsDeleted = 1 THEN 'Yes' END) AS Deleted,
		(
			Case WHEN MaritialStatusID = NULL THEN '' WHEN MaritialStatusID = 1 THEN 'Married' WHEN MaritialStatusID = 2 THEN 'UnMarried' WHEN MaritialStatusID = 3 THEN 'Widowed/Separate' END		
		)AS MaritialStatusID FROM tblhhfamilymember		
		where HHSurveyGUID= '$uid'";

		if ($export_familymembers != NULL) {
			if ($export_familymembers == "export_csv") {
				$this->load->model('Data_export_model');
				$this->Data_export_model->export_csv($query);
				die();
			}else if ($export_familymembers == "export_pdf") {
				$this->load->model('Data_export_model');
				$this->Data_export_model->export_pdf($query);
				die();
			}
		}

		$content['Familymembers_list'] = $this->Common_Model->query_data($query);

		// print_r($content['Familymembers_list']); die();

		$content['subview'] = "list_household_familymembers";
		$this->load->view('auth/main_layout', $content);

	}


	public function edit_family_members($HHFamilyMemberGUID = NULL,$HHSurveyGUID = NULL)
	{	


		$query = "select HHSurveyGUID from tblhhfamilymember where HHFamilyMemberGUID = ? and IsDeleted = 0";
		$PWGUID_data = $this->db->query($query, [$HHFamilyMemberGUID])->result()[0];
		$HHSurveyGUID =  $PWGUID_data->HHSurveyGUID;


		$query = "select *,(
			CASE WHEN GenderID = NULL THEN '' WHEN GenderID = 1 THEN 'Male' WHEN GenderID = 2 THEN 'Female' WHEN GenderID = 3 THEN 'Other' WHEN GenderID = 4 THEN 'Other' END
		) AS GenderID,
		( Case WHEN MaritialStatusID = NULL THEN '' WHEN MaritialStatusID = 1 THEN 'Married' WHEN MaritialStatusID = 2 THEN 'UnMarried' WHEN MaritialStatusID = 3 THEN 'Widowed/Separate' END		
	)AS MaritialStatusID FROM tblhhfamilymember		
	where HHFamilyMemberGUID= '$HHFamilyMemberGUID' and IsDeleted = 0";

	$content['Detail_Family_Member'] = $this->Common_Model->query_data($query);


	$RequestMethod= $this->input->server("REQUEST_METHOD");
	if ($RequestMethod == "POST") {

		$this->db->trans_start();

		$updateArr = array(
			'FamilyMemberName'		=>	$this->input->post('FamilyMemberName'),
			'GenderID'			    =>	$this->input->post('GenderID'),
			'MaritialStatusID'		 =>	$this->input->post('MaritialStatusID'),
			'DateOfBirth'			=>	$this->input->post('DateOfBirth'),
			'AgeAsOnYear'			=>	$this->input->post('AgeAsOnYear'),
			'AprilAgeMonth'			 =>	$this->input->post('AprilAgeMonth'),
			'AprilAgeYear'			=>	$this->input->post('AprilAgeYear'),
			// "UploadedBy"       =>$this->loginData['user_id'],
			"UploadedOn"       =>	date('Y-m-d h:i:s'),
		);

		$this->db->where('HHFamilyMemberGUID' , $HHFamilyMemberGUID);
		$this->db->where('HHSurveyGUID', $HHSurveyGUID);
		$this->db->update('tblhhfamilymember', $updateArr);

		$this->db->trans_complete();

		$this->session->set_flashdata('tr_msg', 'Successfully Updated Records');


		if ($this->db->trans_status() === FALSE){
			$this->session->set_flashdata('tr_msg', 'Error Updating Records');					
		}else{
			$this->session->set_flashdata('tr_msg', 'Successfully Updated Records');			
		}

		redirect('household/familymembers/'.$HHSurveyGUID);


	}

	$content['subview']="edit_household_familymember";
	$this->load->view('auth/main_layout',$content);

}


function delete_family_member($HHFamilyMemberGUID = NULL, $HHSurveyGUID = NULL)
{
	$HHSurveyGUID = $this->db->get_where('tblhhfamilymember',array('HHFamilyMemberGUID'=> $HHFamilyMemberGUID))->result();
	// echo "<pre>"; print_r($HHSurveyGUID); exit;
	$HHSurveyGUID = $HHSurveyGUID[0]->HHSurveyGUID;
	$this->db->trans_start();

		// delete from tblhhfamilymember
	$query = "update tblhhfamilymember set IsDeleted = 1 where HHFamilyMemberGUID = '".$HHFamilyMemberGUID."'";

	// print_r($query); die();
	$this->db->query($query);


	// delete entry from tblfp_followup table
	$query = "update  tblfp_followup c INNER JOIN tblhhfamilymember b on b.HHFamilyMemberGUID=c.WomenName_Guid    set c.UploadedOn='". date('Y-m-d h:i:s')."', c.IsDeleted=1   where  b.HHFamilyMemberGUID= '$HHFamilyMemberGUID' ";
	$this->db->query($query);
	
	// delete from tblncdcbac
	$query = "update tblncdcbac set UpdatedOn='". date('Y-m-d h:i:s')."', IsDeleted = 1 where HHFamilyMemberGUID = '".$HHFamilyMemberGUID."'";
	$this->db->query($query);

	// delete from tblncdfollowup
	$query = "update tblncdfollowup set UpdatedOn='". date('Y-m-d h:i:s')."', IsDeleted = 1 where HHFamilyMemberGUID = '".$HHFamilyMemberGUID."'";
	$this->db->query($query);

	// delete from tblncdscreening
	$query = "update tblncdscreening set UpdatedOn='". date('Y-m-d h:i:s')."', IsDeleted = 1 where HHFamilyMemberGUID = '".$HHFamilyMemberGUID."'";
	$this->db->query($query);

	// delete entry from tblpnchomevisit_ans table
	$query = "update  tblpnchomevisit_ans c INNER JOIN tblchild b on b.childGUID=c.ChildGUID  inner join tblpregnant_woman a on a.PWGUID = b.pw_GUID inner join tblhhfamilymember d on d.HHFamilyMemberGUID = a.HHFamilyMemberGUID  set c.UpdatedOn='". date('Y-m-d h:i:s')."', c.IsDeleted=1   where  d.HHFamilyMemberGUID= '$HHFamilyMemberGUID' ";
	$this->db->query($query);

		// delete entry from tblmstimmunizationans table
	$query = "update  tblmstimmunizationans c INNER JOIN tblchild b on b.childGUID=c.ChildGUID  inner join tblpregnant_woman a on a.PWGUID = b.pw_GUID inner join tblhhfamilymember d on d.HHFamilyMemberGUID = a.HHFamilyMemberGUID  set c.UpdatedOn='". date('Y-m-d h:i:s')."', c.IsDeleted=1   where  d.HHFamilyMemberGUID= '$HHFamilyMemberGUID' ";
	$this->db->query($query);


	// delete entry from ANC VISIT table
	$query = "update  tblancvisit c INNER JOIN tblpregnant_woman b on b.PWGUID=c.PWGUID  inner join tblhhfamilymember d on d.HHFamilyMemberGUID = b.HHFamilyMemberGUID set c.IsDeleted=1   where  d.HHFamilyMemberGUID= '$HHFamilyMemberGUID' ";
	$this->db->query($query);


		// delete entry from tblchild table
	$query = "update  tblchild c INNER JOIN tblhhfamilymember b on b.HHFamilyMemberGUID=c.childGUID   set modified_on='". date('Y-m-d h:i:s')."', c.IsDeleted=1   where  b.HHFamilyMemberGUID= '$HHFamilyMemberGUID' ";
	$this->db->query($query);

		// delete from tblpregnant_woman
	
	$query = "update  tblpregnant_woman c INNER JOIN tblhhfamilymember b on b.HHFamilyMemberGUID=c.HHFamilyMemberGUID   set c.UpdatedOn='". date('Y-m-d h:i:s')."', c.IsDeleted=1   where  b.HHFamilyMemberGUID= '$HHFamilyMemberGUID' ";

	$this->db->query($query);

		// complete transaction
	$this->db->trans_complete();
	if ($this->db->trans_status() === FALSE)
	{
		$this->session->set_flashdata('er_msg', 'Error during deleted HH Family Member');
		redirect('household/familymembers/'.$HHSurveyGUID);
	}

	$this->session->set_flashdata('tr_msg', 'HH Family Member Deleted Successfully');
	redirect('household/familymembers/'.$HHSurveyGUID);
}


public function export_csv()
{
	$query ="select
	mstsubcenter.SubCenterCode,
	mstsubcenter.SubCenterName,
	mstanm.ANMName,
	mstasha.ASHAName,
	mstvillage.VillageName,
	tblhhsurvey.VillageID,
	tblhhsurvey.FamilyCode,
	tblhhsurvey.ANMID,
	tblhhsurvey.HHSurveyGUID,
	(
		CASE WHEN tblhhsurvey.Verified = NULL THEN '' WHEN tblhhsurvey.Verified = 0 THEN 'No' WHEN tblhhsurvey.Verified = 1 THEN 'Yes' END
	) AS Verified,
	(
		CASE WHEN tblhhsurvey.CasteID = 0 THEN '' WHEN tblhhsurvey.CasteID = 1 THEN 'SC' WHEN tblhhsurvey.CasteID = 2 THEN 'ST' WHEN tblhhsurvey.CasteID = 3 THEN 'OBC' WHEN tblhhsurvey.CasteID = 4 THEN 'Other' WHEN tblhhsurvey.CasteID = 5 THEN 'UR' END
	) AS caste,
	(
		CASE WHEN tblhhsurvey.FinancialStatusID = 0 THEN '' WHEN tblhhsurvey.FinancialStatusID = 1 THEN 'A.P.L.' WHEN tblhhsurvey.FinancialStatusID = 2 THEN 'B.P.L.' END
	) AS FinancialStatusID
	FROM
	tblhhsurvey
	left JOIN
	mstasha ON mstasha.ASHAID = tblhhsurvey.ServiceProviderID and mstasha.LanguageID = 1
	left JOIN
	mstanm ON mstanm.ANMID = tblhhsurvey.ANMID and mstanm.LanguageID = 1
	left JOIN
	mstsubcenter ON mstsubcenter.SubCenterID = tblhhsurvey.SubCenterID and mstsubcenter.LanguageID = 1
	left JOIN
	mstvillage ON mstvillage.VillageID = tblhhsurvey.VillageID and mstvillage.LanguageID = 1
	where tblhhsurvey.HHSurveyGUID is not null and tblhhsurvey.IsDeleted = 0
	";

	$this->load->model('Data_export_model');
	$this->Data_export_model->export_csv($query);
}

public function export_pdf()
{
	$query ="select
	mstsubcenter.SubCenterCode,
	mstsubcenter.SubCenterName,
	mstanm.ANMName,
	mstasha.ASHAName,
	mstvillage.VillageName,
	tblhhsurvey.VillageID,
	tblhhsurvey.FamilyCode,
	tblhhsurvey.ANMID,
	tblhhsurvey.HHSurveyGUID,
	(
		CASE WHEN tblhhsurvey.Verified = NULL THEN '' WHEN tblhhsurvey.Verified = 0 THEN 'No' WHEN tblhhsurvey.Verified = 1 THEN 'Yes' END
	) AS Verified,
	(
		CASE WHEN tblhhsurvey.CasteID = 0 THEN '' WHEN tblhhsurvey.CasteID = 1 THEN 'SC' WHEN tblhhsurvey.CasteID = 2 THEN 'ST' WHEN tblhhsurvey.CasteID = 3 THEN 'OBC' WHEN tblhhsurvey.CasteID = 4 THEN 'Other' WHEN tblhhsurvey.CasteID = 5 THEN 'UR' END
	) AS caste,
	(
		CASE WHEN tblhhsurvey.FinancialStatusID = 0 THEN '' WHEN tblhhsurvey.FinancialStatusID = 1 THEN 'A.P.L.' WHEN tblhhsurvey.FinancialStatusID = 2 THEN 'B.P.L.' END
	) AS FinancialStatusID
	FROM
	tblhhsurvey
	left JOIN
	mstasha ON mstasha.ASHAID = tblhhsurvey.ServiceProviderID and mstasha.LanguageID = 1
	left JOIN
	mstanm ON mstanm.ANMID = tblhhsurvey.ANMID and mstanm.LanguageID = 1
	left JOIN
	mstsubcenter ON mstsubcenter.SubCenterID = tblhhsurvey.SubCenterID and mstsubcenter.LanguageID = 1
	left JOIN
	mstvillage ON mstvillage.VillageID = tblhhsurvey.VillageID and mstvillage.LanguageID = 1
	where tblhhsurvey.HHSurveyGUID is not null and tblhhsurvey.IsDeleted = 0
	";

	$this->load->model('Data_export_model');
	$this->Data_export_model->export_pdf($query);
}

public function edit($HHSurveyGUID = NULL)
{

	$RequestMethod= $this->input->server("REQUEST_METHOD");
	if ($RequestMethod == "POST") {

		$this->db->trans_start();

		$updateArr = array(
		// 'SubCenterID'			=>	$this->input->post('SubCenterID'),
		// 'ANMID'			    =>	$this->input->post('ANMID'),
		// 'ServiceProviderID'			    =>	$this->input->post('ServiceProviderID'),
		// 'VillageID'			=>	$this->input->post('VillageID'),
		// 'FamilyCode'			=>	$this->input->post('FamilyCode'),
			'CasteID'			        =>	$this->input->post('CasteID'),
			'FinancialStatusID'			=>	$this->input->post('FinancialStatusID'),
			"UploadedBy"       => $this->loginData['user_id'],
			"UploadedOn"       =>	date('Y-m-d h:i:s'),
		);

		$this->db->where('HHSurveyGUID' , $HHSurveyGUID);
		$this->db->update('tblhhsurvey', $updateArr);

		$this->db->trans_complete();

		$this->session->set_flashdata('tr_msg', 'Successfully Updated Records');


		if ($this->db->trans_status() === FALSE){
			$this->session->set_flashdata('tr_msg', 'Error Updating Records');					
		}else{
			$this->session->set_flashdata('tr_msg', 'Successfully Updated Records');			
		}

		redirect('household');

	}

	$query="select * from (select * from tblhhsurvey where HHSurveyGUID = ?)a
	left join (select * from mstasha)b ON b.ASHAID = a.ServiceProviderID and b.LanguageID = 1
	left join (select * from mstanm)c ON c.ANMID = a.ANMID and c.LanguageID = 1
	left join (select * from mstsubcenter)d ON d.SubCenterID = a.SubCenterID and d.LanguageID = 1
	left join (select * from mstvillage)e ON e.VillageID = a.VillageID and e.LanguageID = 1
	";

	$content['list_household'] = $this->db->query($query, [$HHSurveyGUID])->result();

	$content['subview']="edit_household";
	$this->load->view('auth/main_layout',$content);
}

		// public function what_if_delete($HHSurveyGUID = NULL)
		// {

		// 	$this->db->where('HHSurveyGUID', $HHSurveyGUID)
		// 	$content['ancvisit'] = $this->db->get('ancvisit')->num_rows();


		// 	echo json_encode($content);
		// 	die();

		// 	$visit [] 

		// }


function delete($HHSurveyGUID)
{
	$this->db->trans_start();

// follow women name guid hhmember guid hhfamilymember 3 join 
// anc visit join with pregnent women
	//tblncdfollowup
// ncd--3 table
// tblpnchomevistans 3 join child and pregnent
// tnlimmunizationans 3 join child and pregnent

	// fp 2 table

		// delete from tblhhsurvey
	$query = "update tblhhsurvey set UploadedOn='". date('Y-m-d h:i:s')."', IsDeleted = 1 where HHSurveyGUID = '".$HHSurveyGUID."'";
	$this->db->query($query);

	$query = "update tblhhfamilymember set UploadedOn='". date('Y-m-d h:i:s')."', IsDeleted = 1 where HHSurveyGUID = '".$HHSurveyGUID."'";
	$this->db->query($query);
	
// delete entry from tblfp_followup table
	$query = "update  tblfp_followup c INNER JOIN tblhhfamilymember b on b.HHFamilyMemberGUID=c.WomenName_Guid    set UploadedOn='". date('Y-m-d h:i:s')."', c.IsDeleted=1   where  b.HHSurveyGUID= '$HHSurveyGUID' ";
	$this->db->query($query);
	
	// delete from tblncdcbac
	$query = "update tblncdcbac set UpdatedOn='". date('Y-m-d h:i:s')."', IsDeleted = 1 where HHSurveyGUID = '".$HHSurveyGUID."'";
	$this->db->query($query);

	// delete from tblncdfollowup
	$query = "update tblncdfollowup set UpdatedOn='". date('Y-m-d h:i:s')."', IsDeleted = 1 where HHSurveyGUID = '".$HHSurveyGUID."'";
	$this->db->query($query);

	// delete from tblncdscreening
	$query = "update tblncdscreening set UpdatedOn='". date('Y-m-d h:i:s')."', IsDeleted = 1 where HHSurveyGUID = '".$HHSurveyGUID."'";
	$this->db->query($query);

	// delete entry from tblpnchomevisit_ans table
	$query = "update  tblpnchomevisit_ans c INNER JOIN tblchild b on b.childGUID=c.ChildGUID  inner join tblpregnant_woman a on a.PWGUID = b.pw_GUID inner join tblhhfamilymember d on d.HHFamilyMemberGUID = a.HHFamilyMemberGUID  set c.UpdatedOn='". date('Y-m-d h:i:s')."', c.IsDeleted=1   where  d.HHSurveyGUID= '$HHSurveyGUID' ";
	$this->db->query($query);

		// delete entry from tblmstimmunizationans table
	$query = "update  tblmstimmunizationans c INNER JOIN tblchild b on b.childGUID=c.ChildGUID  inner join tblpregnant_woman a on a.PWGUID = b.pw_GUID inner join tblhhfamilymember d on d.HHFamilyMemberGUID = a.HHFamilyMemberGUID  set c.UpdatedOn='". date('Y-m-d h:i:s')."', c.IsDeleted=1   where  d.HHSurveyGUID= '$HHSurveyGUID' ";
	$this->db->query($query);


	// delete entry from ANC VISIT table
	$query = "update  tblancvisit c INNER JOIN tblpregnant_woman b on b.PWGUID=c.PWGUID  inner join tblhhfamilymember d on d.HHFamilyMemberGUID = b.HHFamilyMemberGUID set c.IsDeleted=1   where  d.HHSurveyGUID= '$HHSurveyGUID' ";
	$this->db->query($query);


		// delete entry from tblchild table
	$query = "update  tblchild c INNER JOIN tblhhfamilymember b on b.HHFamilyMemberGUID=c.HHFamilyMemberGUID   set modified_on='". date('Y-m-d h:i:s')."', c.IsDeleted=1   where  b.HHSurveyGUID= '$HHSurveyGUID' ";
	$this->db->query($query);

		// delete from tblpregnant_woman
	
	$query = "update  tblpregnant_woman c INNER JOIN tblhhfamilymember b on b.HHFamilyMemberGUID=c.HHFamilyMemberGUID   set c.UpdatedOn='". date('Y-m-d h:i:s')."', c.IsDeleted=1   where  b.HHSurveyGUID= '$HHSurveyGUID' ";

	$this->db->query($query);
	

	// print_r($query); die();


		// complete transaction
	$this->db->trans_complete();
	if ($this->db->trans_status() === FALSE)
	{
		$this->session->set_flashdata('er_msg', 'Error during deleted HH Survey');
		redirect('household');
	}


	$this->session->set_flashdata('tr_msg', 'HH Survey Deleted Successfully');
	redirect('household');
}

function delete_confirm($HHSurveyGUID)
{
	$this->db->trans_start();

// follow women name guid hhmember guid hhfamilymember 3 join 
// anc visit join with pregnent women
	//tblncdfollowup
// ncd--3 table
// tblpnchomevistans 3 join child and pregnent
// tnlimmunizationans 3 join child and pregnent

	// fp 2 table

		// delete from tblhhsurvey
	$query = "select count(HHUID) as tblhhsurvey from tblhhsurvey where HHSurveyGUID = '$HHSurveyGUID' AND IsDeleted = 0";
	$result[] = $this->db->query($query)->row();
	// echo (json_encode($tblhhsurvey));

	$query = " select count(HHSurveyGUID) as tblhhfamilymember from tblhhfamilymember where HHSurveyGUID = '$HHSurveyGUID' AND IsDeleted = 0";
	$result[] = $this->db->query($query)->row();
	
// delete entry from tblfp_followup table
	$query = "select count(b.HHSurveyGUID) as tblfp_followup from tblfp_followup c inner join tblhhfamilymember b on b.HHFamilyMemberGUID=c.WomenName_Guid where b.HHSurveyGUID = '$HHSurveyGUID' AND c.IsDeleted = 0";
	$result[] = $this->db->query($query)->row();
	
	// delete from tblncdcbac
	$query = " select count(HHSurveyGUID) as tblncdcbac from tblncdcbac where HHSurveyGUID = '$HHSurveyGUID' AND IsDeleted = 0";
	$result[] = $this->db->query($query)->row();

	// delete from tblncdfollowup
	$query = " select count(HHSurveyGUID) as tblncdfollowup from tblncdfollowup where HHSurveyGUID = '$HHSurveyGUID' AND IsDeleted = 0";
	$result[] = $this->db->query($query)->row();

	// delete from tblncdscreening
	$query = " select count(HHSurveyGUID) as tblncdscreening from tblncdscreening where HHSurveyGUID = '$HHSurveyGUID' AND IsDeleted = 0";
	$result[] = $this->db->query($query)->row();

	// delete entry from tblpnchomevisit_ans table
	$query = "select count(c.UID) as tblpnchomevisit_ans from tblpnchomevisit_ans c INNER JOIN tblchild b on b.childGUID=c.ChildGUID  inner join tblpregnant_woman a on a.PWGUID = b.pw_GUID inner join tblhhfamilymember d on d.HHFamilyMemberGUID = a.HHFamilyMemberGUID where  d.HHSurveyGUID= '$HHSurveyGUID' AND c.IsDeleted = 0";
	$result[] = $this->db->query($query)->row();

		// delete entry from tblmstimmunizationans table
	$query = "select count(c.AshaID) as tblmstimmunizationans from tblmstimmunizationans c INNER JOIN tblchild b on b.childGUID=c.ChildGUID  inner join tblpregnant_woman a on a.PWGUID = b.pw_GUID inner join tblhhfamilymember d on d.HHFamilyMemberGUID = a.HHFamilyMemberGUID where d.HHSurveyGUID= '$HHSurveyGUID' AND c.IsDeleted=0";
	$result[] = $this->db->query($query)->row();


	// delete entry from ANC VISIT table
	$query = "select count(c.AncVisitID) as tblancvisit from tblancvisit c INNER JOIN tblpregnant_woman b on b.PWGUID=c.PWGUID  inner join tblhhfamilymember d on d.HHFamilyMemberGUID = b.HHFamilyMemberGUID where  d.HHSurveyGUID= '$HHSurveyGUID' AND c.IsDeleted=0";
	$result[] = $this->db->query($query)->row();


		// delete entry from tblchild table
	$query = "select count(c.UID) as tblchild from tblchild c INNER JOIN tblhhfamilymember b on b.HHFamilyMemberGUID=c.HHFamilyMemberGUID where b.HHSurveyGUID= '$HHSurveyGUID' AND c.IsDeleted=0";
	$result[] = $this->db->query($query)->row();

		// delete from tblpregnant_woman
	
	$query = "select count(c.PWID) as tblpregnant_woman from tblpregnant_woman c INNER JOIN tblhhfamilymember b on b.HHFamilyMemberGUID=c.HHFamilyMemberGUID where  b.HHSurveyGUID= '$HHSurveyGUID' AND c.IsDeleted=0";
	$result[] = $this->db->query($query)->row();
	

	// print_r($query); die();


		// complete transaction
	$this->db->trans_complete();
	if ($this->db->trans_status() === FALSE)
	{
		$this->session->set_flashdata('er_msg', 'Error during deleted HH Survey');
		redirect('household');
	}
	// die(var_dump($result));

	$message = "This Household has following dependent record in the system::\nHousehold(S):: ".$result[0]->tblhhsurvey."\nHH Members :: ".$result[1]->tblhhfamilymember."\nPregnant Woman :: ".$result[10]->tblpregnant_woman."\nANC visit :: ".$result[8]->tblancvisit."\nPnc Homevisits :: ".$result[6]->tblpnchomevisit_ans."\nChilds :: ".$result[9]->tblchild."\nImmunizationans :: ".$result[7]->tblmstimmunizationans."\nFamily Planning(FP) :: ".$result[2]->tblfp_followup."\nNCD-CBAC :: ".$result[3]->tblncdcbac."\nNCD Screening :: ".$result[5]->tblncdscreening."\nNCD Follow up :: ".$result[4]->tblncdfollowup."\n Do You Still Want to  Delete it";
	echo "$message";
}

function getHouseHoldList()
{

	/*print_r($_POST); die();*/

	$searchPhrase = $this->input->post('searchPhrase');
	$StateCode    = $this->input->post('StateCode');
	$ANMID      = $this->input->post('ANMID');
	$ASHAID     = $this->input->post('ASHAID');
	$VillageCode  = $this->input->post('VillageCode');
	$IsDeleted    = $this->input->post('IsDeleted');

	$query ="select
	mstsubcenter.SubCenterCode,
	mstsubcenter.SubCenterName,
	mstanm.ANMName,
	mstasha.ASHAName,
	mstvillage.VillageName,
	tblhhsurvey.VillageID,
	tblhhsurvey.FamilyCode,
	tblhhsurvey.ANMID,
	tblhhsurvey.HHSurveyGUID,
	tblhhsurvey.IsDeleted,	
	tblhhsurvey.Verified,
	tblhhsurvey.HHCode,
	tblhhsurvey.ServiceProviderID,
	tblhhsurvey.StateCode,
	(
		CASE WHEN tblhhsurvey.CasteID = 0 THEN '' WHEN tblhhsurvey.CasteID = 1 THEN 'SC' WHEN tblhhsurvey.CasteID = 2 THEN 'ST' WHEN tblhhsurvey.CasteID = 3 THEN 'OBC' WHEN tblhhsurvey.CasteID = 4 THEN 'Other' WHEN tblhhsurvey.CasteID = 5 THEN 'UR' END
	) AS caste,
	(
		CASE WHEN tblhhsurvey.FinancialStatusID = 0 THEN '' WHEN tblhhsurvey.FinancialStatusID = 1 THEN 'A.P.L.' WHEN tblhhsurvey.FinancialStatusID = 2 THEN 'B.P.L.' END
	) AS FinancialStatusID
	FROM
	tblhhsurvey
	LEFT JOIN
	mstasha ON mstasha.ASHAID = tblhhsurvey.ServiceProviderID and mstasha.LanguageID = 1 and mstasha.IsDeleted = 0 and mstasha.IsActive = 1
	LEFT JOIN
	mstanm ON mstanm.ANMID = tblhhsurvey.ANMID and mstanm.LanguageID = 1 and mstanm.IsDeleted = 0 and mstanm.IsActive = 1
	LEFT JOIN
	mstsubcenter ON mstsubcenter.SubCenterID = tblhhsurvey.SubCenterID and mstsubcenter.LanguageID = 1 and mstsubcenter.IsDeleted = 0
	LEFT JOIN
	mstvillage ON mstvillage.VillageID = tblhhsurvey.VillageID and mstvillage.LanguageID = 1 and mstvillage.IsDeleted = 0
	where tblhhsurvey.HHSurveyGUID is not null and tblhhsurvey.CreatedBy in (select user_id from tblusers where is_deleted=0";

	if ($StateCode != "") {
		$query .= " and state_code = $StateCode ";
	} 

	// die($query);
	
	if ($ANMID != "") {
		$query .= " and mstanm.ANMID = $ANMID ";
	}

	if ($ASHAID != "") {
		$query .= " and mstasha.ASHAID = $ASHAID ";
	}


	if ($VillageCode != "") {
		$query .= " and mstvillage.VillageCode = $VillageCode ";
	}

	if ($IsDeleted == "1") {
		$query .= " and tblhhsurvey.IsDeleted = 1 ";
	}else if($IsDeleted == "2") {
		$query .= " and tblhhsurvey.IsDeleted = 0 ";
	}

	$query .= "and user_mode= 1)";
// die($query);
		//extraQuery for search dialog

	$extraQuery = "and (mstsubcenter.SubCenterName like '".$searchPhrase."%'
	or mstanm.ANMName like '".$searchPhrase."%'
	or mstasha.ASHAName like '".$searchPhrase."%'
	or mstvillage.VillageName like '".$searchPhrase."%'
	or tblhhsurvey.IsDeleted like '".$searchPhrase."%'
	or tblhhsurvey.FamilyCode like '".$searchPhrase."%'
	or tblhhsurvey.HHCode like '".$searchPhrase."%'
	or tblhhsurvey.HHSurveyGUID like '".$searchPhrase."%') ";
	if($searchPhrase != "") $query .= $extraQuery;

		//order by clause
	$sort = $this->input->post('sort');
	if ($sort != NULL) 
	{
		$sortBy = array_keys($sort);

		switch($sortBy[0]){
			case "HHSurveyGUID":
			$orderQuery = " order by tblhhsurvey.HHSurveyGUID " . $sort[$sortBy[0]];
			break;
			case "SubCenterName":
			$orderQuery = " order by mstsubcenter.SubCenterName " . $sort[$sortBy[0]];
			break;
			case "ANMName":
			$orderQuery = " order by mstanm.ANMName " . $sort[$sortBy[0]];
			break;
			case "ASHAName":
			$orderQuery = " order by mstasha.ASHAName " . $sort[$sortBy[0]];
			break;
			case "VillageName":
			$orderQuery = " order by mstvillage.VillageName " . $sort[$sortBy[0]];
			break;
			case "IsDeleted":
			$orderQuery = " order by tblhhsurvey.IsDeleted " . $sort[$sortBy[0]];
			break;
			default:
			$orderQuery = " order by tblhhsurvey.HHSurveyGUID " . $sort[$sortBy[0]];
			break;
		}

		$query .= $orderQuery ;

	}
		//die($query);

	$tmp =$this->db->query($query);
	$total = $tmp->num_rows();


	$current = (int)$this->input->post('current');
	$rowCount = (int)$this->input->post('rowCount');

			//limit conditions
	$limitQuery = " limit ".($current - 1)*($rowCount).",".$rowCount;
	$query .= $limitQuery;

		 //die($limitQuery);

	$Household_list = $this->Common_Model->query_data($query);

	$returnArray = array(
		"current"		=>	$this->input->post('current'),
		"rowCount"		=>	$this->input->post('rowCount'),
		"total"			=>	$total,
		"rows"			=>	$Household_list,
	);

	echo json_encode($returnArray);		
}

} 
