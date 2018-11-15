<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Household extends Gov_Controller {

	public function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{	
		$query = "select * from mstanm where LanguageID = 1 and IsDeleted = 0";
		$content['Anm_List'] = $this->Common_Model->query_data($query);

		$RequestMethod = $this->input->server('REQUEST_METHOD');
		if($RequestMethod == "POST")
		{
			$query = "select * from mstasha where ANMCode=".$this->input->post('ANMCode')." and LanguageID=1 and IsDeleted = 0";

			$content['Asha_List'] = $this->Common_Model->query_data($query);

		}else{
			$content['Asha_List'] = array();
		}
		/*print_r($content['Asha_List']); die();*/

		$content['subview'] = "list_household";
		$this->load->view('gov/main_layout', $content);
	}

	public function familymembers($uid=null, $export_familymembers = NULL)
	{		

		$HHSurveyGUID = $this->input->post('HHSurveyGUID');

		$query = "select HHFamilyMemberCode,FamilyMemberName,AprilAgeYear,AprilAgeMonth,(
		CASE WHEN GenderID = NULL THEN '' WHEN GenderID = 1 THEN 'Male' WHEN GenderID = 2 THEN 'Female' WHEN GenderID = 3 THEN 'Other' WHEN GenderID = 4 THEN 'Other' END
		) AS GenderID,
		(
		Case WHEN MaritialStatusID = NULL THEN '' WHEN MaritialStatusID = 1 THEN 'Married' WHEN MaritialStatusID = 2 THEN 'UnMarried' WHEN MaritialStatusID = 3 THEN 'Widowed/Separate' END		
		)AS MaritialStatusID FROM tblhhfamilymember		
		where HHSurveyGUID= '$uid' ";

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
		
		$content['subview'] = "list_household_familymembers";
		$this->load->view('gov/main_layout', $content);

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
		where tblhhsurvey.HHSurveyGUID is not null
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
		where tblhhsurvey.HHSurveyGUID is not null
		";

		$this->load->model('Data_export_model');
		$this->Data_export_model->export_pdf($query);
	}

} 
