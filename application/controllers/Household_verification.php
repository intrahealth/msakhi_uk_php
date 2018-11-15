<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Household_verification extends Auth_controller {

	public function __construct()
	{
		parent::__construct();
		$this->loginData = $this->session->userdata('loginData');
	}
	
	public function index()
	{
	   // start permission 
		$user_role = $this->loginData->user_role;
		$query = "SELECT * FROM role_permissions as rp LEFT JOIN mstrole as mst on rp.RoleID=mst.RoleID WHERE rp.RoleID='$user_role' ";
		$content['role_permission'] = $this->Common_Model->query_data($query);
		// end permission 
		
		//$query = "SELECT * FROM mstasha where nm.LanguageID=1 and nm.IsDeleted=0";
		$query = "SELECT * FROM mstasha as ash LEFT JOIN mstanm as nm on ash.ANMCode=nm.ANMCode LEFT JOIN mstsubcenter as sub on ash.SubCenterCode=sub.SubCenterCode where nm.LanguageID=1 and nm.IsDeleted=0 ";

		if ($this->loginData->user_role == 1 || $this->loginData->user_role == 2 || $this->loginData->user_role == 3 || $this->loginData->user_role == 6 || $this->loginData->user_role == 7 || $this->loginData->user_role == 8) 	 {
			$query .= "	and sub.StateCode='".$this->loginData->state_code."' group by nm.ANMName ";

			// add district based filter if district role
			if ($this->loginData->user_role == 7) {
				$query .= " and district_code =  $this->loginData->district_code ";
			}
			// add district based filter if block role
			if ($this->loginData->user_role == 8) {
				$query .= " and block_code =  $this->loginData->block_code ";
			}

		}

		$content['Anm_List'] = $this->Common_Model->query_data($query);
    //print_r($query); die();

		$RequestMethod = $this->input->server('REQUEST_METHOD');
		if($RequestMethod == "POST")
		{
			$query = "select * from mstasha where ANMCode=".$this->input->post('ANMCode')." and LanguageID=1 and IsDeleted = 0";

			$content['Asha_List'] = $this->Common_Model->query_data($query);

		}else{
			$content['Asha_List'] = array();
		}
		/*print_r($content['Asha_List']); die();*/

		$content['subview'] = "list_household_verification";
		$this->load->view('auth/main_layout', $content);
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
		where tblhhsurvey.HHSurveyGUID is not null  and tblhhsurvey.IsDeleted = 0
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

} 
