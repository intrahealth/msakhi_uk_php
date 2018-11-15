<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Indicator_beneficiary_list extends Gov_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function preg_women_reg_first_trimester($ashacode, $export_preg_women = NULL)
	{	

		$query = "SELECT PWName,HusbandName,PWRegistrationDate,MotherMCTSID,LMPDate,EDDDate FROM `tblpregnant_woman` inner join mstasha on mstasha.ASHAID = tblpregnant_woman.ASHAID and mstasha.LanguageID = 1 where Regwithin12weeks=1 and tblpregnant_woman.ASHAID = $ashacode";

		if ($export_preg_women != NULL) {
			if ($export_preg_women == "export_csv") {
				$this->load->model('Data_export_model');
				$this->Data_export_model->export_csv($query);
				die();
			}else if ($export_preg_women == "export_pdf") {
				$this->load->model('Data_export_model');
				$this->Data_export_model->export_pdf($query);
				die();
			}
		}

		$content['ben_list'] = $this->db->query($query)->result();
		$content['indicator_name'] = "Proportion of pregnant Women Registered in the First Trimester";
		$content['indicator'] = "preg_women_reg_first_trimester";
		$content['subview'] = "indicator_beneficiary_list";
		$this->load->view('gov/main_layout', $content);
	}


	public function institutional_delivery($ashacode, $export_institutional_delivery = NULL)
	{	

		$query = "SELECT
		PWName,HusbandName,PWRegistrationDate,MotherMCTSID,LMPDate,EDDDate
		FROM
		`tblpregnant_woman`
		WHERE
		DeliveryPlace = 2 and ASHAID = $ashacode";

		if ($export_institutional_delivery != NULL) {
			if ($export_institutional_delivery == "export_csv") {
				$this->load->model('Data_export_model');
				$this->Data_export_model->export_csv($query);
				die();
			}else if ($export_institutional_delivery == "export_pdf") {
				$this->load->model('Data_export_model');
				$this->Data_export_model->export_pdf($query);
				die();
			}
		}

		$content['ben_list'] = $this->db->query($query)->result();
		$content['indicator_name'] = "Proportion of institutional deliveries";
		$content['indicator'] = "institutional_delivery";
		$content['subview'] = "indicator_beneficiary_list";
		$this->load->view('gov/main_layout', $content);
	}

	public function one_anc_checkup($ashacode, $export_one_anc = NULL)
	{

		$query = "SELECT w.PWNAME as PWName,w.HusbandName,w.PWRegistrationDate,w.MotherMCTSID,w.LMPDate,w.EDDDate  FROM `tblancvisit` c inner join tblpregnant_woman w on c.pwguid = w.PWGUID where CheckupVisitDate is not null and w.ASHAID = $ashacode group by c.PWGUID, c.ByAshaID having count(*) = 1";	

		if ($export_one_anc != NULL) {
			if ($export_one_anc == "export_csv") {
				$this->load->model('Data_export_model');
				$this->Data_export_model->export_csv($query);
				die();
			}else if ($export_one_anc == "export_pdf") {
				$this->load->model('Data_export_model');
				$this->Data_export_model->export_pdf($query);
				die();
			}
		}

		$content['ben_list'] = $this->db->query($query)->result();
		$content['indicator_name'] = "Proportion of pregnant women with 1 ANC check-up";
		$content['indicator'] = "one_anc_checkup";
		$content['subview'] = "indicator_beneficiary_list";
		$this->load->view('gov/main_layout', $content);
	}

	public function low_birth_weight($ashacode, $export_low_birth = NULL)
	{	
		$query = "SELECT w.PWNAME as PWName, w.HusbandName, w.PWRegistrationDate, w.MotherMCTSID,w.LMPDate,w.EDDDate FROM `tblchild` c inner join tblpregnant_woman w on c.pw_guid = w.PWGUID  WHERE Wt_of_child < 2.5 and w.AshaID = $ashacode";

		if ($export_low_birth != NULL) {
			if ($export_low_birth == "export_csv") {
				$this->load->model('Data_export_model');
				$this->Data_export_model->export_csv($query);
				die();
			}else if ($export_low_birth == "export_pdf") {
				$this->load->model('Data_export_model');
				$this->Data_export_model->export_pdf($query);
				die();
			}
		}

		$content['ben_list'] = $this->db->query($query)->result();
		$content['indicator_name'] = "Low Birth Weight";
		$content['indicator'] = "low_birth_weight";
		$content['subview'] = "indicator_beneficiary_list";
		$this->load->view('gov/main_layout', $content);
	}

	public function two_anc_checkup($ashacode, $export_two_anc = NULL)
	{

		$query = "select w.PWNAME as PWName, w.HusbandName,w.PWRegistrationDate, w.MotherMCTSID,w.LMPDate,w.EDDDate FROM `tblancvisit` c inner join tblpregnant_woman w on c.pwguid = w.PWGUID where CheckupVisitDate is not null and w.ASHAID = $ashacode group by c.PWGUID, c.ByAshaID having count(*) = 2";	

		if ($export_two_anc != NULL) {
			if ($export_two_anc == "export_csv") {
				$this->load->model('Data_export_model');
				$this->Data_export_model->export_csv($query);
				die();
			}else if ($export_two_anc == "export_pdf") {
				$this->load->model('Data_export_model');
				$this->Data_export_model->export_pdf($query);
				die();
			}
		}

		$content['ben_list'] = $this->db->query($query)->result();
		$content['indicator_name'] = "Proportion of pregnant women with 2 ANC check-up";
		$content['indicator'] = "two_anc_checkup";
		$content['subview'] = "indicator_beneficiary_list";
		$this->load->view('gov/main_layout', $content);
	}


	public function three_anc_checkup($ashacode, $export_three_anc = NULL)
	{

		$query = "SELECT w.PWNAME as PWName, w.HusbandName,w.PWRegistrationDate,w.MotherMCTSID,w.LMPDate,w.EDDDate FROM `tblancvisit` c inner join tblpregnant_woman w on c.pwguid = w.PWGUID where CheckupVisitDate is not null and w.ASHAID = $ashacode group by c.PWGUID, c.ByAshaID having count(*) = 3";	

		if ($export_three_anc != NULL) {
			if ($export_three_anc == "export_csv") {
				$this->load->model('Data_export_model');
				$this->Data_export_model->export_csv($query);
				die();
			}else if ($export_three_anc == "export_pdf") {
				$this->load->model('Data_export_model');
				$this->Data_export_model->export_pdf($query);
				die();
			}
		}

		$content['ben_list'] = $this->db->query($query)->result();
		$content['indicator_name'] = "Proportion of pregnant women with 3 ANC check-up";
		$content['indicator'] = "three_anc_checkup";
		$content['subview'] = "indicator_beneficiary_list";
		$this->load->view('gov/main_layout', $content);
	}

	public function four_anc_checkup($ashacode, $export_four_anc = NULL)
	{

		$query = "SELECT w.PWNAME as PWName, w.HusbandName,w.PWRegistrationDate,w.MotherMCTSID,w.LMPDate,w.EDDDate FROM `tblancvisit` c inner join tblpregnant_woman w on c.pwguid = w.PWGUID where CheckupVisitDate is not null and w.ASHAID = $ashacode group by c.PWGUID, c.ByAshaID having count(*) = 4";

		if ($export_four_anc != NULL) {
			if ($export_four_anc == "export_csv") {
				$this->load->model('Data_export_model');
				$this->Data_export_model->export_csv($query);
				die();
			}else if ($export_four_anc == "export_pdf") {
				$this->load->model('Data_export_model');
				$this->Data_export_model->export_pdf($query);
				die();
			}
		}	

		$content['ben_list'] = $this->db->query($query)->result();
		$content['indicator_name'] = "Proportion of pregnant women with 4 ANC check-up";
		$content['indicator'] = "four_anc_checkup";
		$content['subview'] = "indicator_beneficiary_list";
		$this->load->view('gov/main_layout', $content);
	}

	public function tt2_booster($ashacode, $export_tt2_booster = NULL)
	{

		$query = "select w.PWName as PWName, w.HusbandName,w.PWRegistrationDate,w.MotherMCTSID,w.LMPDate,w.EDDDate from 
		(SELECT PWGUID FROM `tblancvisit` where TT2=1 or TTbooster=1 group by PWGUID having count(*) > 0)a
		inner join tblpregnant_woman w 
		on w.PWGUID = a.PWGUID 
		where w.ASHAID = $ashacode";

		if ($export_tt2_booster != NULL) {
			if ($export_tt2_booster == "export_csv") {
				$this->load->model('Data_export_model');
				$this->Data_export_model->export_csv($query);
				die();
			}else if ($export_tt2_booster == "export_pdf") {
				$this->load->model('Data_export_model');
				$this->Data_export_model->export_pdf($query);
				die();
			}
		}

		$content['ben_list'] = $this->db->query($query)->result();
		$content['indicator_name'] = "Proportion of pregnant women who received  TT2  or Booster";
		$content['indicator'] = "tt2_booster";
		$content['subview'] = "indicator_beneficiary_list";
		$this->load->view('gov/main_layout', $content);
	}

	public function newborns_visited_two_or_more_times($ashacode , $export_newborns = NULL)
	{
		$query = "select
		pw.PWNAME, pw.HusbandName, pw.PWRegistrationDate, pw.MotherMCTSID, pw.LMPDate, pw.EDDDate
		FROM
		tblancvisit v
		INNER JOIN
		tblpregnant_woman pw ON v.PWGUID = pw.PWGUID
		INNER JOIN
		tblchild c ON c.pw_GUID = pw.PWGUID
		WHERE
		v.CheckupVisitDate BETWEEN c.child_dob AND DATE_ADD(c.child_dob,
		INTERVAL 7 DAY) AND pw.ASHAID = $ashacode
		HAVING COUNT(*) > 2";	

		if ($export_newborns != NULL) {
			if ($export_newborns == "export_csv") {
				$this->load->model('Data_export_model');
				$this->Data_export_model->export_csv($query);
				die();
			}else if ($export_newborns == "export_pdf") {
				$this->load->model('Data_export_model');
				$this->Data_export_model->export_pdf($query);
				die();
			}
		}

		$content['ben_list'] = $this->db->query($query)->result();
		$content['indicator_name'] = "Newborns visited by ASHA at least two  or more times within first seven days";
		$content['indicator'] = "newborns_visited_two_or_more_times";
		$content['subview'] = "indicator_beneficiary_list";
		$this->load->view('gov/main_layout', $content);
	}	
	
	public function newborns_visited_three_or_more_times_home_delivery($ashacode, $export_home_delivery = NULL)
	{
		$query = "select pw.PWNAME, pw.HusbandName, pw.PWRegistrationDate, pw.MotherMCTSID, pw.LMPDate, pw.EDDDate FROM
		tblancvisit v
		INNER JOIN
		tblpregnant_woman pw ON v.PWGUID = pw.PWGUID
		INNER JOIN
		tblchild c ON c.pw_GUID = pw.PWGUID
		WHERE
		v.CheckupVisitDate BETWEEN c.child_dob AND DATE_ADD(c.child_dob,
		INTERVAL 7 DAY) and pw.ASHAID = $ashacode HAVING COUNT(*) > 3";

		if ($export_home_delivery != NULL) {
			if ($export_home_delivery == "export_csv") {
				$this->load->model('Data_export_model');
				$this->Data_export_model->export_csv($query);
				die();
			}else if ($export_home_delivery == "export_pdf") {
				$this->load->model('Data_export_model');
				$this->Data_export_model->export_pdf($query);
				die();
			}
		}

		$content['ben_list'] = $this->db->query($query)->result();
		$content['indicator_name'] = "Newborns visited by ASHA at least three  or more times within first seven days of home delivery";
		$content['indicator'] = "newborns_visited_three_or_more_times_home_delivery";
		$content['subview'] = "indicator_beneficiary_list";
		$this->load->view('gov/main_layout', $content);
	}

	public function newborns_visited_two_or_more_times_instituional($ashacode , $export_newborns_institutional = NULL)
	{
		$query = "select
		pw.PWNAME ,pw.HusbandName, pw.PWRegistrationDate, pw.MotherMCTSID, pw.LMPDate, pw.EDDDate
		FROM
		tblancvisit v
		INNER JOIN
		tblpregnant_woman pw ON v.PWGUID = pw.PWGUID
		INNER JOIN
		tblchild c ON c.pw_GUID = pw.PWGUID
		WHERE
		v.CheckupVisitDate BETWEEN c.child_dob AND DATE_ADD(c.child_dob,
		INTERVAL 7 DAY) AND c.place_of_birth = 2 and pw.ASHAID = $ashacode
		HAVING COUNT(*) > 2";

		if ($export_newborns_institutional != NULL) {
			if ($export_newborns_institutional == "export_csv") {
				$this->load->model('Data_export_model');
				$this->Data_export_model->export_csv($query);
				die();
			}else if ($export_newborns_institutional == "export_pdf") {
				$this->load->model('Data_export_model');
				$this->Data_export_model->export_pdf($query);
				die();
			}
		}

		$content['ben_list'] = $this->db->query($query)->result();
		$content['indicator_name'] = "Newborns visited by ASHA at least two  or more times within first seven days of institutional delivery";
		$content['indicator'] = "newborns_visited_two_or_more_times_instituional";
		$content['subview'] = "indicator_beneficiary_list";
		$this->load->view('gov/main_layout', $content);
	}
}