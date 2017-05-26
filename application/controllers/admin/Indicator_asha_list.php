<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Indicator_asha_list extends Admin_Controller {

	private $from_date;
	private $to_date;

	public function __construct()
	{
		parent::__construct();
		$this->from_date = $this->session->userdata("from_date");
		$this->to_date = $this->session->userdata("to_date");
	}

	public function preg_women_reg_first_trimester($anmcode, $export_preg_women = NULL)
	{	

		if ($this->from_date != NULL && $this->to_date != NULL) 
		{
			$query = "select asha.ASHAID, asha.ASHAName, ifnull(a.done, 0) as done, ifnull(b.total, 0) as total FROM mstasha asha
			left join 
			(
			SELECT count(*) as done, tblpregnant_woman.AshaID FROM `tblpregnant_woman`
			inner join mstasha on mstasha.ASHAID = tblpregnant_woman.ASHAID and mstasha.LanguageID = 1
			where Regwithin12weeks=1
			and PWRegistrationDate between STR_TO_DATE('".$this->from_date."', '%Y-%m-%d') and  STR_TO_DATE('".$this->to_date."', '%Y-%m-%d')
			group by tblpregnant_woman.ASHAID
			)a on asha.ASHAID = a.ASHAID
			left join 
			(
			SELECT count(*) as total, tblpregnant_woman.AshaID FROM `tblpregnant_woman`
			inner join mstasha on mstasha.ASHAID = tblpregnant_woman.ASHAID and mstasha.LanguageID = 1
			and PWRegistrationDate between STR_TO_DATE('".$this->from_date."', '%Y-%m-%d') and  STR_TO_DATE('".$this->to_date."', '%Y-%m-%d')
			group by tblpregnant_woman.ASHAID
			)b on asha.ASHAID = b.ASHAID
			where asha.LanguageID=1 and asha.ANMCode = $anmcode";
		}else{
			$query = "select asha.ASHAID, asha.ASHAName, ifnull(a.done, 0) as done, ifnull(b.total, 0) as total FROM mstasha asha
			left join 
			(
			SELECT count(*) as done, tblpregnant_woman.AshaID FROM `tblpregnant_woman`
			inner join mstasha on mstasha.ASHAID = tblpregnant_woman.ASHAID and mstasha.LanguageID = 1
			where Regwithin12weeks=1
			group by tblpregnant_woman.ASHAID
			)a on asha.ASHAID = a.ASHAID
			left join 
			(
			SELECT count(*) as total, tblpregnant_woman.AshaID FROM `tblpregnant_woman`
			inner join mstasha on mstasha.ASHAID = tblpregnant_woman.ASHAID and mstasha.LanguageID = 1
			group by tblpregnant_woman.ASHAID
			)b on asha.ASHAID = b.ASHAID
			where asha.LanguageID=1 and asha.ANMCode = $anmcode";
		}

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

		$content['asha_list'] = $this->db->query($query)->result();
		$content['indicator_name'] = "Proportion of pregnant Women Registered in the First Trimester";
		$content['indicator'] = "preg_women_reg_first_trimester";
		$content['subview'] = "indicator_asha_list";
		$this->load->view('admin/main_layout', $content);
	}

	public function institutional_delivery($anmcode, $export_institutional_delivery = NULL)
	{	

		if ($this->from_date != NULL && $this->to_date != NULL) 
		{
			$query = "select
			asha.ASHAID,
			asha.ASHAName,
			IFNULL(a.done, 0) AS done,
			IFNULL(b.total, 0) AS total
			FROM
			mstasha asha
			LEFT JOIN
			(
			SELECT
			COUNT(*) AS done,
			AshaID
			FROM
			`tblpregnant_woman`
			WHERE
			DeliveryPlace = 2
			and PWRegistrationDate between STR_TO_DATE('".$this->from_date."', '%Y-%m-%d') and  STR_TO_DATE('".$this->to_date."', '%Y-%m-%d')
			GROUP BY
			tblpregnant_woman.AshaID
			) a
			ON
			asha.AshaID = a.AshaID
			LEFT JOIN
			(
			SELECT
			COUNT(*) AS total,
			AshaID
			FROM
			`tblpregnant_woman`
			where PWRegistrationDate between STR_TO_DATE('".$this->from_date."', '%Y-%m-%d') and  STR_TO_DATE('".$this->to_date."', '%Y-%m-%d')
			GROUP BY
			tblpregnant_woman.AshaID
			) b
			ON
			asha.AshaID = b.AshaID
			WHERE
			asha.LanguageID = 1 and asha.ANMCode = $anmcode";

		}else{

			$query = "select
			asha.ASHAID,
			asha.ASHAName,
			IFNULL(a.done, 0) AS done,
			IFNULL(b.total, 0) AS total
			FROM
			mstasha asha
			LEFT JOIN
			(
			SELECT
			COUNT(*) AS done,
			AshaID
			FROM
			`tblpregnant_woman`
			WHERE
			DeliveryPlace = 2
			GROUP BY
			tblpregnant_woman.AshaID
			) a
			ON
			asha.AshaID = a.AshaID
			LEFT JOIN
			(
			SELECT
			COUNT(*) AS total,
			AshaID
			FROM
			`tblpregnant_woman`
			GROUP BY
			tblpregnant_woman.AshaID
			) b
			ON
			asha.AshaID = b.AshaID
			WHERE
			asha.LanguageID = 1 and asha.ANMCode = $anmcode";
		}

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

		$content['asha_list'] = $this->db->query($query)->result();
		$content['indicator_name'] = "Proportion of institutional deliveries";
		$content['indicator'] = "institutional_delivery";
		$content['subview'] = "indicator_asha_list";
		$this->load->view('admin/main_layout', $content);
	}

	
	public function one_anc_checkup($anmcode, $export_one_anc = NULL)
	{	

		if ($this->from_date != NULL && $this->to_date != NULL) 
		{

			$query = "select asha.ASHAID, asha.ASHAName, ifnull(a.done, 0) as done, ifnull(b.total, 0) as total FROM mstasha asha
			left join 
			(
			SELECT count(*) as done, tmp.ByAshaID FROM
			(
			SELECT v.ByAshaID FROM `tblancvisit` v 
			inner join tblpregnant_woman w 
			on v.PWGUID = w.PWGUID
			where v.CheckupVisitDate is not null
			and w.PWRegistrationDate between STR_TO_DATE('".$this->from_date."', '%Y-%m-%d') and  STR_TO_DATE('".$this->to_date."', '%Y-%m-%d')
			group by v.PWGUID, v.ByAshaID having count(*) = 1
			) tmp group by ByAshaID
			)a on asha.ASHAID = a.ByAshaID
			left join 
			(
			SELECT count(*) as total, tmp.ByAshaID FROM
			(
			SELECT v.ByAshaID FROM `tblancvisit` v 
			inner join tblpregnant_woman w 
			on v.PWGUID = w.PWGUID
			where w.PWRegistrationDate between STR_TO_DATE('".$this->from_date."', '%Y-%m-%d') and  STR_TO_DATE('".$this->to_date."', '%Y-%m-%d')
			group by v.PWGUID, v.ByAshaID
			) tmp group by ByAshaID
			)b on asha.ASHAID = b.ByAshaID
			where asha.LanguageID=1 and asha.ANMCode = $anmcode";

		}else{
			$query = "select asha.ASHAID, asha.ASHAName, ifnull(a.done, 0) as done, ifnull(b.total, 0) as total FROM mstasha asha
			left join 
			(
			SELECT count(*) as done, tmp.ByAshaID FROM
			(
			SELECT v.ByAshaID FROM `tblancvisit` v 
			inner join tblpregnant_woman w 
			on v.PWGUID = w.PWGUID
			where v.CheckupVisitDate is not null
			group by v.PWGUID, v.ByAshaID having count(*) = 1
			) tmp group by ByAshaID
			)a on asha.ASHAID = a.ByAshaID
			left join 
			(
			SELECT count(*) as total, tmp.ByAshaID FROM
			(
			SELECT v.ByAshaID FROM `tblancvisit` v 
			inner join tblpregnant_woman w 
			on v.PWGUID = w.PWGUID
			group by v.PWGUID, v.ByAshaID
			) tmp group by ByAshaID
			)b on asha.ASHAID = b.ByAshaID
			where asha.LanguageID=1 and asha.ANMCode = $anmcode";
		}

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

		$content['asha_list'] = $this->db->query($query)->result();
		$content['indicator_name'] = "Proportion of pregnant women with 1 ANC check-up";
		$content['indicator'] = "one_anc_checkup";
		$content['subview'] = "indicator_asha_list";
		$this->load->view('admin/main_layout', $content);

	}

	public function low_birth_weight($anmcode, $export_low_birth = NULL)
	{	

		if ($this->from_date != NULL && $this->to_date != NULL) 
		{

			$query = "select
			asha.ASHAID,
			asha.ASHAName,
			IFNULL(a.done, 0) AS done,
			IFNULL(b.total, 0) AS total
			FROM
			mstasha asha
			LEFT JOIN
			(
			SELECT w.AshaID, count(*) as done FROM `tblchild` c 
			inner join 
			tblpregnant_woman w 
			on c.pw_guid = w.PWGUID
			WHERE c.Wt_of_child < 2.5 
			and PWRegistrationDate between STR_TO_DATE('".$this->from_date."', '%Y-%m-%d') and  STR_TO_DATE('".$this->to_date."', '%Y-%m-%d')
			group by w.AshaID
			) a
			ON
			asha.AshaID = a.AshaID
			LEFT JOIN
			(
			SELECT w.AshaID, count(*) as total FROM `tblchild` c 
			inner join 
			tblpregnant_woman w 
			on c.pw_guid = w.PWGUID
			where PWRegistrationDate between STR_TO_DATE('".$this->from_date."', '%Y-%m-%d') and  STR_TO_DATE('".$this->to_date."', '%Y-%m-%d')
			group by w.AshaID
			) b
			ON
			asha.AshaID = b.AshaID
			WHERE
			asha.LanguageID = 1 and asha.ANMCode = $anmcode";
		}else{

			$query = "select
			asha.ASHAID,
			asha.ASHAName,
			IFNULL(a.done, 0) AS done,
			IFNULL(b.total, 0) AS total
			FROM
			mstasha asha
			LEFT JOIN
			(
			SELECT w.AshaID, count(*) as done FROM `tblchild` c 
			inner join 
			tblpregnant_woman w 
			on c.pw_guid = w.PWGUID
			WHERE c.Wt_of_child < 2.5
			group by w.AshaID
			) a
			ON
			asha.AshaID = a.AshaID
			LEFT JOIN
			(
			SELECT w.AshaID, count(*) as total FROM `tblchild` c 
			inner join 
			tblpregnant_woman w 
			on c.pw_guid = w.PWGUID
			group by w.AshaID
			) b
			ON
			asha.AshaID = b.AshaID
			WHERE
			asha.LanguageID = 1 and asha.ANMCode = $anmcode";

		}

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

		$content['asha_list'] = $this->db->query($query)->result();
		$content['indicator_name'] = "Low Birth Weight";
		$content['indicator'] = "low_birth_weight";
		$content['subview'] = "indicator_asha_list";
		$this->load->view('admin/main_layout', $content);
	}

	public function two_anc_checkup($anmcode, $export_two_anc = NULL)
	{	
		if ($this->from_date != NULL && $this->to_date != NULL) 
		{

			$query = "select asha.ASHAID, asha.ASHAName, ifnull(a.done, 0) as done, ifnull(b.total, 0) as total FROM mstasha asha
			left join 
			(
			SELECT count(*) as done, tmp.ByAshaID FROM
			(
			SELECT v.ByAshaID FROM `tblancvisit` v 
			inner join tblpregnant_woman w 
			on v.PWGUID = w.PWGUID
			where v.CheckupVisitDate is not null
			and w.PWRegistrationDate between STR_TO_DATE('".$this->from_date."', '%Y-%m-%d') and  STR_TO_DATE('".$this->to_date."', '%Y-%m-%d')
			group by v.PWGUID, v.ByAshaID having count(*) = 2
			) tmp group by ByAshaID
			)a on asha.ASHAID = a.ByAshaID
			left join 
			(
			SELECT count(*) as total, tmp.ByAshaID FROM
			(
			SELECT v.ByAshaID FROM `tblancvisit` v 
			inner join tblpregnant_woman w 
			on v.PWGUID = w.PWGUID
			where w.PWRegistrationDate between STR_TO_DATE('".$this->from_date."', '%Y-%m-%d') and  STR_TO_DATE('".$this->to_date."', '%Y-%m-%d')
			group by v.PWGUID, v.ByAshaID
			) tmp group by ByAshaID
			)b on asha.ASHAID = b.ByAshaID
			where asha.LanguageID=1 and asha.ANMCode = $anmcode";

		}else{
			$query = "select asha.ASHAID, asha.ASHAName, ifnull(a.done, 0) as done, ifnull(b.total, 0) as total FROM mstasha asha
			left join 
			(
			SELECT count(*) as done, tmp.ByAshaID FROM
			(
			SELECT v.ByAshaID FROM `tblancvisit` v 
			inner join tblpregnant_woman w 
			on v.PWGUID = w.PWGUID
			where v.CheckupVisitDate is not null
			group by v.PWGUID, v.ByAshaID having count(*) = 2
			) tmp group by ByAshaID
			)a on asha.ASHAID = a.ByAshaID
			left join 
			(
			SELECT count(*) as total, tmp.ByAshaID FROM
			(
			SELECT v.ByAshaID FROM `tblancvisit` v 
			inner join tblpregnant_woman w 
			on v.PWGUID = w.PWGUID
			group by v.PWGUID, v.ByAshaID
			) tmp group by ByAshaID
			)b on asha.ASHAID = b.ByAshaID
			where asha.LanguageID=1 and asha.ANMCode = $anmcode";
		}

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

		$content['asha_list'] = $this->db->query($query)->result();
		$content['indicator_name'] = "Proportion of pregnant women with 1 ANC check-up";
		$content['indicator'] = "two_anc_checkup";
		$content['subview'] = "indicator_asha_list";
		$this->load->view('admin/main_layout', $content);
	}

	public function three_anc_checkup($anmcode, $export_three_anc = NULL)
	{	

		if ($this->from_date != NULL && $this->to_date != NULL) 
		{

			$query = "select asha.ASHAID, asha.ASHAName, ifnull(a.done, 0) as done, ifnull(b.total, 0) as total FROM mstasha asha
			left join 
			(
			SELECT count(*) as done, tmp.ByAshaID FROM
			(
			SELECT v.ByAshaID FROM `tblancvisit` v 
			inner join tblpregnant_woman w 
			on v.PWGUID = w.PWGUID
			where v.CheckupVisitDate is not null
			and w.PWRegistrationDate between STR_TO_DATE('".$this->from_date."', '%Y-%m-%d') and  STR_TO_DATE('".$this->to_date."', '%Y-%m-%d')
			group by v.PWGUID, v.ByAshaID having count(*) = 3
			) tmp group by ByAshaID
			)a on asha.ASHAID = a.ByAshaID
			left join 
			(
			SELECT count(*) as total, tmp.ByAshaID FROM
			(
			SELECT v.ByAshaID FROM `tblancvisit` v 
			inner join tblpregnant_woman w 
			on v.PWGUID = w.PWGUID
			where w.PWRegistrationDate between STR_TO_DATE('".$this->from_date."', '%Y-%m-%d') and  STR_TO_DATE('".$this->to_date."', '%Y-%m-%d')
			group by v.PWGUID, v.ByAshaID
			) tmp group by ByAshaID
			)b on asha.ASHAID = b.ByAshaID
			where asha.LanguageID=1 and asha.ANMCode = $anmcode";

		}else{
			$query = "select asha.ASHAID, asha.ASHAName, ifnull(a.done, 0) as done, ifnull(b.total, 0) as total FROM mstasha asha
			left join 
			(
			SELECT count(*) as done, tmp.ByAshaID FROM
			(
			SELECT v.ByAshaID FROM `tblancvisit` v 
			inner join tblpregnant_woman w 
			on v.PWGUID = w.PWGUID
			where v.CheckupVisitDate is not null
			group by v.PWGUID, v.ByAshaID having count(*) = 3
			) tmp group by ByAshaID
			)a on asha.ASHAID = a.ByAshaID
			left join 
			(
			SELECT count(*) as total, tmp.ByAshaID FROM
			(
			SELECT v.ByAshaID FROM `tblancvisit` v 
			inner join tblpregnant_woman w 
			on v.PWGUID = w.PWGUID
			group by v.PWGUID, v.ByAshaID
			) tmp group by ByAshaID
			)b on asha.ASHAID = b.ByAshaID
			where asha.LanguageID=1 and asha.ANMCode = $anmcode";
		}

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

		$content['asha_list'] = $this->db->query($query)->result();
		$content['indicator_name'] = "Proportion of pregnant women with 1 ANC check-up";
		$content['indicator'] = "three_anc_checkup";
		$content['subview'] = "indicator_asha_list";
		$this->load->view('admin/main_layout', $content);
	}

	public function four_anc_checkup($anmcode, $export_four_anc = NULL)
	{	

		if ($this->from_date != NULL && $this->to_date != NULL) 
		{

			$query = "select asha.ASHAID, asha.ASHAName, ifnull(a.done, 0) as done, ifnull(b.total, 0) as total FROM mstasha asha
			left join 
			(
			SELECT count(*) as done, tmp.ByAshaID FROM
			(
			SELECT v.ByAshaID FROM `tblancvisit` v 
			inner join tblpregnant_woman w 
			on v.PWGUID = w.PWGUID
			where v.CheckupVisitDate is not null
			and w.PWRegistrationDate between STR_TO_DATE('".$this->from_date."', '%Y-%m-%d') and  STR_TO_DATE('".$this->to_date."', '%Y-%m-%d')
			group by v.PWGUID, v.ByAshaID having count(*) = 4
			) tmp group by ByAshaID
			)a on asha.ASHAID = a.ByAshaID
			left join 
			(
			SELECT count(*) as total, tmp.ByAshaID FROM
			(
			SELECT v.ByAshaID FROM `tblancvisit` v 
			inner join tblpregnant_woman w 
			on v.PWGUID = w.PWGUID
			where w.PWRegistrationDate between STR_TO_DATE('".$this->from_date."', '%Y-%m-%d') and  STR_TO_DATE('".$this->to_date."', '%Y-%m-%d')
			group by v.PWGUID, v.ByAshaID
			) tmp group by ByAshaID
			)b on asha.ASHAID = b.ByAshaID
			where asha.LanguageID=1 and asha.ANMCode = $anmcode";

		}else{
			$query = "select asha.ASHAID, asha.ASHAName, ifnull(a.done, 0) as done, ifnull(b.total, 0) as total FROM mstasha asha
			left join 
			(
			SELECT count(*) as done, tmp.ByAshaID FROM
			(
			SELECT v.ByAshaID FROM `tblancvisit` v 
			inner join tblpregnant_woman w 
			on v.PWGUID = w.PWGUID
			where v.CheckupVisitDate is not null
			group by v.PWGUID, v.ByAshaID having count(*) = 4
			) tmp group by ByAshaID
			)a on asha.ASHAID = a.ByAshaID
			left join 
			(
			SELECT count(*) as total, tmp.ByAshaID FROM
			(
			SELECT v.ByAshaID FROM `tblancvisit` v 
			inner join tblpregnant_woman w 
			on v.PWGUID = w.PWGUID
			group by v.PWGUID, v.ByAshaID
			) tmp group by ByAshaID
			)b on asha.ASHAID = b.ByAshaID
			where asha.LanguageID=1 and asha.ANMCode = $anmcode";
		}

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

		$content['asha_list'] = $this->db->query($query)->result();
		$content['indicator_name'] = "Proportion of pregnant women with 1 ANC check-up";
		$content['indicator'] = "four_anc_checkup";
		$content['subview'] = "indicator_asha_list";
		$this->load->view('admin/main_layout', $content);
	}

	public function tt2_booster($anmcode, $export_tt2_booster = NULL)
	{	

		if ($this->from_date != NULL && $this->to_date != NULL) 
		{

			$query = "select asha.ASHAID, asha.ASHAName, ifnull(a.done, 0) as done, ifnull(b.total, 0) as total FROM mstasha asha
			left join 
			(
			SELECT count(*) as done, tmp.ByAshaID FROM
			(
			SELECT v.ByAshaID FROM `tblancvisit` v 
			inner join tblpregnant_woman w 
			on v.PWGUID = w.PWGUID
			where v.TT2=1 or v.TTbooster=1 
			and w.PWRegistrationDate between STR_TO_DATE('".$this->from_date."', '%Y-%m-%d') and  STR_TO_DATE('".$this->to_date."', '%Y-%m-%d')
			group by v.PWGUID having count(*) > 0
			) tmp group by ByAshaID
			)a on asha.ASHAID = a.ByAshaID
			left join 
			(
			SELECT count(*) as total, tmp.ByAshaID FROM
			(
			SELECT v.ByAshaID FROM `tblancvisit` v 
			inner join tblpregnant_woman w 
			on v.PWGUID = w.PWGUID
			where w.PWRegistrationDate between STR_TO_DATE('".$this->from_date."', '%Y-%m-%d') and  STR_TO_DATE('".$this->to_date."', '%Y-%m-%d')
			group by v.PWGUID
			) tmp group by ByAshaID
			)b on asha.ASHAID = b.ByAshaID
			where asha.LanguageID=1 and asha.ANMCode = $anmcode";

		}else{

			$query = "select asha.ASHAID, asha.ASHAName, ifnull(a.done, 0) as done, ifnull(b.total, 0) as total FROM mstasha asha
			left join 
			(
			SELECT count(*) as done, tmp.ByAshaID FROM
			(
			SELECT v.ByAshaID FROM `tblancvisit` v 
			inner join tblpregnant_woman w 
			on v.PWGUID = w.PWGUID
			where v.TT2=1 or v.TTbooster=1
			group by v.PWGUID having count(*) > 0
			) tmp group by ByAshaID
			)a on asha.ASHAID = a.ByAshaID
			left join 
			(
			SELECT count(*) as total, tmp.ByAshaID FROM
			(
			SELECT v.ByAshaID FROM `tblancvisit` v 
			inner join tblpregnant_woman w 
			on v.PWGUID = w.PWGUID
			group by v.PWGUID
			) tmp group by ByAshaID
			)b on asha.ASHAID = b.ByAshaID
			where asha.LanguageID=1 and asha.ANMCode = $anmcode";

		}

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

		$content['asha_list'] = $this->db->query($query)->result();
		$content['indicator_name'] = "Proportion of pregnant women with 1 ANC check-up";
		$content['indicator'] = "tt2_booster";
		$content['subview'] = "indicator_asha_list";
		$this->load->view('admin/main_layout', $content);
	}


	public function newborns_visited_two_or_more_times($anmcode , $export_newborns = NULL)
	{
		if ($this->from_date != NULL && $this->to_date != NULL) {

			$query = "select
			asha.ASHAID,
			asha.ASHAName,
			IFNULL(a.done,
			0) AS done,
			IFNULL(b.total,
			0) AS total
			FROM
			mstasha asha
			LEFT JOIN
			(
			SELECT COUNT(*) AS done,
			c.ASHAID AS ASHAID
			FROM
			(
			SELECT COUNT(*) AS done,
			v.ByAshaID AS ASHAID
			FROM
			tblancvisit v
			INNER JOIN
			tblpregnant_woman pw ON v.PWGUID = pw.PWGUID
			INNER JOIN
			tblchild c ON c.pw_GUID = pw.PWGUID
			WHERE
			v.CheckupVisitDate BETWEEN c.child_dob AND DATE_ADD(c.child_dob,
			INTERVAL 7 DAY) AND pw.PWRegistrationDate BETWEEN STR_TO_DATE('".$this->from_date."',
			'%Y-%m-%d') AND STR_TO_DATE('".$this->to_date."',
			'%Y-%m-%d')
			GROUP BY
			v.PWGUID
			HAVING COUNT(*) > 2
			) c
			GROUP BY
			c.ASHAID
			) a ON asha.ASHAID = a.ASHAID
			LEFT JOIN
			(
			SELECT COUNT(*) AS total,
			d.ASHAID
			FROM
			(
			SELECT COUNT(*) AS total,
			v.ByAshaID AS ASHAID
			FROM
			tblancvisit v
			INNER JOIN
			tblpregnant_woman pw ON v.PWGUID = pw.PWGUID
			INNER JOIN
			tblchild c ON c.pw_GUID = pw.PWGUID AND pw.PWRegistrationDate BETWEEN STR_TO_DATE('".$this->from_date."',
			'%Y-%m-%d') AND STR_TO_DATE('".$this->to_date."',
			'%Y-%m-%d')
			GROUP BY
			v.PWGUID
			) d
			GROUP BY
			d.ASHAID
			) b ON asha.ASHAID = b.ASHAID
			WHERE
			asha.LanguageID = 1";
		}else{
			$query = "select
			asha.ASHAID, asha.ASHAName,
			IFNULL(a.done, 0) AS done,
			IFNULL(b.total,0) as total
			FROM
			mstasha asha
			LEFT JOIN
			(
			SELECT COUNT(*) AS done,
			c.ASHAID AS ASHAID
			FROM
			(
			SELECT COUNT(*) AS done,
			v.ByAshaID AS ASHAID
			FROM
			tblancvisit v
			INNER JOIN
			tblpregnant_woman pw ON v.PWGUID = pw.PWGUID
			INNER JOIN
			tblchild c ON c.pw_GUID = pw.PWGUID
			WHERE
			v.CheckupVisitDate BETWEEN c.child_dob AND DATE_ADD(c.child_dob,
			INTERVAL 7 DAY)
			GROUP BY
			v.PWGUID
			HAVING COUNT(*) > 2
			) c
			GROUP BY
			c.ASHAID
			) a ON asha.ASHAID = a.ASHAID
			LEFT JOIN
			(
			select count(*) as total, d.ASHAID from 
			(
			SELECT COUNT(*) AS total,
			v.ByAshaID AS ASHAID
			FROM
			tblancvisit v
			INNER JOIN
			tblpregnant_woman pw ON v.PWGUID = pw.PWGUID
			INNER JOIN
			tblchild c ON c.pw_GUID = pw.PWGUID
			GROUP BY
			v.PWGUID    
			)d group by d.ASHAID
			) b ON asha.ASHAID = b.ASHAID
			WHERE
			asha.LanguageID = 1 AND asha.ANMCode = $anmcode";

		}

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

		$content['asha_list'] = $this->db->query($query)->result();
		$content['indicator_name'] = "Newborns visited by ASHA at least two  or more times within first seven days";
		$content['indicator'] = "newborns_visited_two_or_more_times";
		$content['subview'] = "indicator_asha_list";
		$this->load->view('admin/main_layout', $content);

	}

	public function newborns_visited_three_or_more_times_home_delivery($anmcode , $export_home_delivery = NULL)
	{
		if ($this->from_date != NULL && $this->to_date != NULL) {
			$query = "select
			asha.ASHAID,
			asha.ASHAName,
			IFNULL(a.done,
			0) AS done,
			IFNULL(b.total,
			0) AS total
			FROM
			mstasha asha
			LEFT JOIN
			(
			SELECT COUNT(*) AS done,
			c.ASHAID AS ASHAID
			FROM
			(
			SELECT COUNT(*) AS done,
			v.ByAshaID AS ASHAID
			FROM
			tblancvisit v
			INNER JOIN
			tblpregnant_woman pw ON v.PWGUID = pw.PWGUID
			INNER JOIN
			tblchild c ON c.pw_GUID = pw.PWGUID
			WHERE
			v.CheckupVisitDate BETWEEN c.child_dob AND DATE_ADD(c.child_dob,
			INTERVAL 7 DAY) AND c.place_of_birth = 1 AND pw.PWRegistrationDate BETWEEN STR_TO_DATE('".$this->from_date."',
			'%Y-%m-%d') AND STR_TO_DATE('".$this->to_date."',
			'%Y-%m-%d')
			GROUP BY
			v.PWGUID
			HAVING COUNT(*) > 3
			) c
			GROUP BY
			c.ASHAID
			) a ON asha.ASHAID = a.ASHAID
			LEFT JOIN
			(
			SELECT COUNT(*) AS total,
			d.ASHAID
			FROM
			(
			SELECT COUNT(*) AS total,
			v.ByAshaID AS ASHAID
			FROM
			tblancvisit v
			INNER JOIN
			tblpregnant_woman pw ON v.PWGUID = pw.PWGUID
			INNER JOIN
			tblchild c ON c.pw_GUID = pw.PWGUID AND c.place_of_birth = 1 AND pw.PWRegistrationDate BETWEEN STR_TO_DATE('".$this->from_date."',
			'%Y-%m-%d') AND STR_TO_DATE('".$this->to_date."',
			'%Y-%m-%d')
			GROUP BY
			v.PWGUID
			) d
			GROUP BY
			d.ASHAID
			) b ON asha.ASHAID = b.ASHAID
			WHERE
			asha.LanguageID = 1";

		}else{
			$query = "select asha.ASHAID, asha.ASHAName,  ifnull(a.done, 0) as done, ifnull(b.total, 0) as total FROM mstasha asha
			left join
			(
			select count(*) as done, v.ByAshaID ASHAID FROM tblancvisit v
			INNER JOIN mstasha on mstasha.ASHAID = v.ByAshaID and mstasha.LanguageID = 1
			inner join tblpregnant_woman pw
			on v.PWGUID = pw.PWGUID
			inner join tblchild c 
			on c.pw_GUID = pw.PWGUID
			where v.CheckupVisitDate BETWEEN c.child_dob and DATE_ADD(c.child_dob, INTERVAL 7 day)
			and c.place_of_birth = 1			
			group by v.PWGUID having count(*) > 3
			)a on asha.ASHAID = a.ASHAID
			left join 
			(
			select count(*) as total, v.ByAshaID as ASHAID FROM tblancvisit v
			INNER JOIN mstasha on mstasha.ASHAID = v.ByAshaID and mstasha.LanguageID = 1
			inner join tblpregnant_woman pw
			on v.PWGUID = pw.PWGUID
			inner join tblchild c 
			on c.pw_GUID = pw.PWGUID
			where v.CheckupVisitDate BETWEEN c.child_dob and DATE_ADD(c.child_dob, INTERVAL 7 day)
			and c.place_of_birth = 1
			group by v.PWGUID having count(*) > 3
			)b on asha.AshaID = b.ASHAID
			WHERE asha.LanguageID = 1 and asha.ANMCode = $anmcode";
		}
		
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

		$content['asha_list'] = $this->db->query($query)->result();
		$content['indicator_name'] = "Newborns visited by ASHA at least three  or more times within first seven days of home delivery";
		$content['indicator'] = "newborns_visited_three_or_more_times_home_delivery";
		$content['subview'] = "indicator_asha_list";
		$this->load->view('admin/main_layout', $content);
	}

	public function newborns_visited_two_or_more_times_instituional($anmcode, $export_newborns_instituional = NULL)
	{
		if ($this->from_date != NULL && $this->to_date != NULL) {
			$query = "select
			asha.ASHAID,
			asha.ASHAName,
			IFNULL(a.done,
			0) AS done,
			IFNULL(b.total,
			0) AS total
			FROM
			mstasha asha
			LEFT JOIN
			(
			SELECT COUNT(*) AS done,
			c.ASHAID AS ASHAID
			FROM
			(
			SELECT COUNT(*) AS done,
			v.ByAshaID AS ASHAID
			FROM
			tblancvisit v
			INNER JOIN
			tblpregnant_woman pw ON v.PWGUID = pw.PWGUID
			INNER JOIN
			tblchild c ON c.pw_GUID = pw.PWGUID
			WHERE
			v.CheckupVisitDate BETWEEN c.child_dob AND DATE_ADD(c.child_dob,
			INTERVAL 7 DAY) AND c.place_of_birth = 2 AND pw.PWRegistrationDate BETWEEN STR_TO_DATE('".$this->from_date."',
			'%Y-%m-%d') AND STR_TO_DATE('".$this->to_date."',
			'%Y-%m-%d')
			GROUP BY
			v.PWGUID
			HAVING COUNT(*) > 2
			) c
			GROUP BY
			c.ASHAID
			) a ON asha.ASHAID = a.ASHAID
			LEFT JOIN
			(
			SELECT COUNT(*) AS total,
			d.ASHAID
			FROM
			(
			SELECT COUNT(*) AS total,
			v.ByAshaID AS ASHAID
			FROM
			tblancvisit v
			INNER JOIN
			mstasha ON mstasha.ASHAID = v.ByAshaID AND mstasha.LanguageID = 1
			INNER JOIN
			tblpregnant_woman pw ON v.PWGUID = pw.PWGUID
			INNER JOIN
			tblchild c ON c.pw_GUID = pw.PWGUID
			WHERE
			c.place_of_birth = 2 AND pw.PWRegistrationDate BETWEEN STR_TO_DATE('".$this->from_date."',
			'%Y-%m-%d') AND STR_TO_DATE('".$this->to_date."',
			'%Y-%m-%d')
			GROUP BY
			v.PWGUID
			) d
			GROUP BY
			d.ASHAID
			) b ON asha.ASHAID = b.ASHAID
			WHERE
			asha.LanguageID = 1";
		}
		else{
			$query = "select
			asha.ASHAID,
			asha.ASHAName,
			IFNULL(a.done,
			0) AS done,
			IFNULL(b.total,
			0) AS total
			FROM
			mstasha asha
			LEFT JOIN
			(
			SELECT COUNT(*) AS done,
			c.ASHAID AS ASHAID
			FROM
			(
			SELECT COUNT(*) AS done,
			v.ByAshaID AS ASHAID
			FROM
			tblancvisit v
			INNER JOIN
			tblpregnant_woman pw ON v.PWGUID = pw.PWGUID
			INNER JOIN
			tblchild c ON c.pw_GUID = pw.PWGUID
			WHERE
			v.CheckupVisitDate BETWEEN c.child_dob AND DATE_ADD(c.child_dob,
			INTERVAL 7 DAY) AND c.place_of_birth = 2
			GROUP BY
			v.PWGUID
			HAVING COUNT(*) > 2
			) c
			GROUP BY
			c.ASHAID
			) a ON asha.ASHAID = a.ASHAID
			LEFT JOIN
			(
			SELECT COUNT(*) AS total,
			d.ASHAID
			FROM
			(
			SELECT COUNT(*) AS done,
			v.ByAshaID AS ASHAID
			FROM
			tblancvisit v
			INNER JOIN
			tblpregnant_woman pw ON v.PWGUID = pw.PWGUID
			INNER JOIN
			tblchild c ON c.pw_GUID = pw.PWGUID
			WHERE
			c.place_of_birth = 2
			GROUP BY
			v.PWGUID
			HAVING COUNT(*) > 2
			) d
			GROUP BY
			d.ASHAID
			) b ON asha.ASHAID = b.ASHAID
			WHERE
			asha.LanguageID = 1 and asha.ANMCode = $anmcode";
		}

		if ($export_newborns_instituional != NULL) {
			if ($export_newborns_instituional == "export_csv") {
				$this->load->model('Data_export_model');
				$this->Data_export_model->export_csv($query);
				die();
			}else if ($export_newborns_instituional == "export_pdf") {
				$this->load->model('Data_export_model');
				$this->Data_export_model->export_pdf($query);
				die();
			}
		}

		$content['asha_list'] = $this->db->query($query)->result();
		$content['indicator_name'] = "Newborns visited by ASHA at least two  or more times within first seven days of institutional delivery";
		$content['indicator'] = "newborns_visited_two_or_more_times_instituional";
		$content['subview'] = "indicator_asha_list";
		$this->load->view('admin/main_layout', $content);
	}

}