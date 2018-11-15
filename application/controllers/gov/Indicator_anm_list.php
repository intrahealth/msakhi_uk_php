<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Indicator_anm_list extends Gov_Controller {

	private $from_date;
	private $to_date;

	public function __construct()
	{
		parent::__construct();
		$this->from_date = $this->session->userdata("from_date");
		$this->to_date = $this->session->userdata("to_date");
	}

	public function preg_women_reg_first_trimester($export_preg_women = NULL)
	{	

		if ($this->from_date != NULL && $this->to_date != NULL) 
		{
			$query = "select anm.ANMID, anm.ANMCode, anm.ANMName, ifnull(a.done, 0) as done, ifnull(b.total, 0) as total FROM mstanm anm
			left join 
			(
			SELECT count(*) as done, tblpregnant_woman.ANMID FROM `tblpregnant_woman`
			inner join mstanm on mstanm.ANMID = tblpregnant_woman.ANMID and mstanm.LanguageID = 1
			where Regwithin12weeks=1
			and PWRegistrationDate between STR_TO_DATE('".$this->from_date."', '%Y-%m-%d') and  STR_TO_DATE('".$this->to_date."', '%Y-%m-%d')
			group by tblpregnant_woman.ANMID
			)a on anm.ANMID = a.ANMID
			left join 
			(
			SELECT count(*) as total, tblpregnant_woman.ANMID FROM `tblpregnant_woman`
			inner join mstanm on mstanm.ANMID = tblpregnant_woman.ANMID and mstanm.LanguageID = 1
			where PWRegistrationDate between STR_TO_DATE('".$this->from_date."', '%Y-%m-%d') and  STR_TO_DATE('".$this->to_date."', '%Y-%m-%d')
			group by tblpregnant_woman.ANMID
			)b on anm.ANMID = b.ANMID
			where anm.LanguageID=1";
		}else{
			$query = "select anm.ANMID, anm.ANMCode, anm.ANMName, ifnull(a.done, 0) as done, ifnull(b.total, 0) as total FROM mstanm anm
			left join 
			(
			SELECT count(*) as done, tblpregnant_woman.ANMID FROM `tblpregnant_woman`
			inner join mstanm on mstanm.ANMID = tblpregnant_woman.ANMID and mstanm.LanguageID = 1
			where Regwithin12weeks=1
			group by tblpregnant_woman.ANMID
			)a on anm.ANMID = a.ANMID
			left join 
			(
			SELECT count(*) as total, tblpregnant_woman.ANMID FROM `tblpregnant_woman`
			inner join mstanm on mstanm.ANMID = tblpregnant_woman.ANMID and mstanm.LanguageID = 1
			group by tblpregnant_woman.ANMID
			)b on anm.ANMID = b.ANMID
			where anm.LanguageID=1";
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

		$content['anm_list'] = $this->db->query($query)->result();
		$content['indicator_name'] = "Proportion of pregnant Women Registered in the First Trimester";
		$content['indicator'] = "preg_women_reg_first_trimester";
		$content['subview'] = "indicator_anm_list";
		$this->load->view('gov/main_layout', $content);
	}

	public function institutional_delivery($export_institutional_delivery= NULL)
	{	

		if ($this->from_date != NULL && $this->to_date != NULL) {
			$query = "select
			anm.ANMID,
			anm.ANMCode,
			anm.ANMName,
			IFNULL(a.done, 0) AS done,
			IFNULL(b.total, 0) AS total
			FROM
			mstanm anm
			LEFT JOIN
			(
			SELECT
			COUNT(*) AS done,
			w.ANMID
			FROM
			`tblpregnant_woman` w 
			inner join tblchild c 
			on w.PWGUID = c.pw_GUID
			where  c.place_of_birth = 1
			and w.PWRegistrationDate between STR_TO_DATE('".$this->from_date."', '%Y-%m-%d') and  STR_TO_DATE('".$this->to_date."', '%Y-%m-%d')
			GROUP BY
			w.ANMID
			) a
			ON
			anm.ANMID = a.ANMID
			LEFT JOIN
			(
			SELECT
			COUNT(*) AS total,
			ANMID
			FROM
			`tblpregnant_woman`
			where PWRegistrationDate between STR_TO_DATE('".$this->from_date."', '%Y-%m-%d') and  STR_TO_DATE('".$this->to_date."', '%Y-%m-%d')
			GROUP BY
			tblpregnant_woman.ANMID
			) b
			ON
			anm.ANMID = b.ANMID
			WHERE
			anm.LanguageID = 1";
		}else{
			$query = "select
			anm.ANMID,
			anm.ANMCode,
			anm.ANMName,
			IFNULL(a.done, 0) AS done,
			IFNULL(b.total, 0) AS total
			FROM
			mstanm anm
			LEFT JOIN
			(
			SELECT
			COUNT(*) AS done,
			w.ANMID
			FROM
			`tblpregnant_woman` w 
			inner join tblchild c 
			on w.PWGUID = c.pw_GUID
			where  c.place_of_birth = 1
			GROUP BY
			w.ANMID
			) a
			ON
			anm.ANMID = a.ANMID
			LEFT JOIN
			(
			SELECT
			COUNT(*) AS total,
			ANMID
			FROM
			`tblpregnant_woman` w
			GROUP BY
			w.ANMID
			) b
			ON
			anm.ANMID = b.ANMID
			WHERE
			anm.LanguageID = 1";
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

		$content['anm_list'] = $this->db->query($query)->result();
		$content['indicator_name'] = "Proportion of institutional deliveries";
		$content['indicator'] = "institutional_delivery";
		$content['subview'] = "indicator_anm_list";
		$this->load->view('gov/main_layout', $content);
	}

	public function low_birth_weight($export_birth = NULL)
	{	

		if ($this->from_date != NULL && $this->to_date != NULL) {
			$query = "select
			anm.ANMID,
			anm.ANMCode,
			anm.ANMName,
			IFNULL(a.done, 0) AS done,
			IFNULL(b.total, 0) AS total
			FROM
			mstanm anm
			LEFT JOIN
			(
			SELECT w.ANMID, count(*) as done FROM `tblchild` c 
			inner join 
			tblpregnant_woman w 
			on c.pw_guid = w.PWGUID
			WHERE c.Wt_of_child < 2.5 
			and w.PWRegistrationDate between STR_TO_DATE('".$this->from_date."', '%Y-%m-%d') and  STR_TO_DATE('".$this->to_date."', '%Y-%m-%d')
			group by w.ANMID
			) a
			ON
			anm.ANMID = a.ANMID
			LEFT JOIN
			(
			SELECT w.ANMID, count(*) as total FROM `tblchild` c 
			inner join 
			tblpregnant_woman w 
			on c.pw_guid = w.PWGUID
			where w.PWRegistrationDate between STR_TO_DATE('".$this->from_date."', '%Y-%m-%d') and  STR_TO_DATE('".$this->to_date."', '%Y-%m-%d')
			group by w.ANMID
			) b
			ON
			anm.ANMID = b.ANMID
			WHERE
			anm.LanguageID = 1";
		}else{
			$query = "select
			anm.ANMID,
			anm.ANMCode,
			anm.ANMName,
			IFNULL(a.done, 0) AS done,
			IFNULL(b.total, 0) AS total
			FROM
			mstanm anm
			LEFT JOIN
			(
			SELECT w.ANMID, count(*) as done FROM `tblchild` c 
			inner join 
			tblpregnant_woman w 
			on c.pw_guid = w.PWGUID
			WHERE c.Wt_of_child < 2.5
			group by w.ANMID
			) a
			ON
			anm.ANMID = a.ANMID
			LEFT JOIN
			(
			SELECT w.ANMID, count(*) as total FROM `tblchild` c 
			inner join 
			tblpregnant_woman w 
			on c.pw_guid = w.PWGUID
			group by w.ANMID
			) b
			ON
			anm.ANMID = b.ANMID
			WHERE
			anm.LanguageID = 1";
		}

		if ($export_birth != NULL) {
			if ($export_birth == "export_csv") {
				$this->load->model('Data_export_model');
				$this->Data_export_model->export_csv($query);
				die();
			}else if ($export_birth == "export_pdf") {
				$this->load->model('Data_export_model');
				$this->Data_export_model->export_pdf($query);
				die();
			}
		}

		$content['anm_list'] = $this->db->query($query)->result();
		$content['indicator_name'] = "Low Birth Weight";
		$content['indicator'] = "low_birth_weight";
		$content['subview'] = "indicator_anm_list";
		$this->load->view('gov/main_layout', $content);
	}


	public function one_anc_checkup($export_one_anc = NULL)
	{		

		if ($this->from_date != NULL && $this->to_date != NULL) 
		{
			$query = "select
			anm.ANMID,
			anm.ANMCode,
			anm.ANMName,
			IFNULL(a.done,
			0) AS done,
			IFNULL(b.total,
			0) AS total
			FROM
			mstanm anm
			LEFT JOIN
			(
			SELECT COUNT(*) AS done,
			tmp.ByANMID
			FROM
			(
			SELECT
			v.*
			FROM
			`tblancvisit` v
			INNER JOIN
			tblpregnant_woman w ON v.PWGUID = w.PWGUID
			WHERE
			v.CheckupVisitDate IS NOT NULL AND w.PWRegistrationDate BETWEEN STR_TO_DATE('".$this->from_date."',
			'%Y-%m-%d') AND STR_TO_DATE('".$this->to_date."',
			'%Y-%m-%d')
			GROUP BY
			v.PWGUID,
			ByANMID
			HAVING COUNT(*) = 1
			) tmp
			GROUP BY
			ByANMID
			) a ON anm.ANMID = a.ByANMID
			LEFT JOIN
			(
			SELECT COUNT(*) AS total,
			tmp.ByANMID
			FROM
			(
			SELECT
			v.*
			FROM
			`tblancvisit` v
			INNER JOIN
			tblpregnant_woman w ON v.PWGUID = w.PWGUID
			WHERE
			w.PWRegistrationDate BETWEEN STR_TO_DATE('".$this->from_date."',
			'%Y-%m-%d') AND STR_TO_DATE('".$this->to_date."',
			'%Y-%m-%d')
			GROUP BY
			v.PWGUID,
			ByANMID
			) tmp
			GROUP BY
			ByANMID
			) b ON anm.ANMID = b.ByANMID
			WHERE
			anm.LanguageID = 1";
		}else{
			$query = "select
			anm.ANMID,
			anm.ANMCode,
			anm.ANMName,
			IFNULL(a.done,
			0) AS done,
			IFNULL(b.total,
			0) AS total
			FROM
			mstanm anm
			LEFT JOIN
			(
			SELECT COUNT(*) AS done,
			tmp.ByANMID
			FROM
			(
			SELECT
			v.*
			FROM
			`tblancvisit` v
			INNER JOIN
			tblpregnant_woman w ON v.PWGUID = w.PWGUID
			WHERE
			v.CheckupVisitDate IS NOT NULL
			GROUP BY
			v.PWGUID,
			ByANMID
			HAVING COUNT(*) = 1
			) tmp
			GROUP BY
			ByANMID
			) a ON anm.ANMID = a.ByANMID
			LEFT JOIN
			(
			SELECT COUNT(*) AS total,
			tmp.ByANMID
			FROM
			(
			SELECT
			v.*
			FROM
			`tblancvisit` v
			INNER JOIN
			tblpregnant_woman w ON v.PWGUID = w.PWGUID
			GROUP BY
			v.PWGUID,
			ByANMID
			) tmp
			GROUP BY
			ByANMID
			) b ON anm.ANMID = b.ByANMID
			WHERE
			anm.LanguageID = 1";

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

		$content['anm_list'] = $this->db->query($query)->result();
		$content['indicator_name'] = "Proportion of pregnant women with 1 ANC check-up";
		$content['indicator'] = "one_anc_checkup";
		$content['subview'] = "indicator_anm_list";
		$this->load->view('gov/main_layout', $content);
	}


	public function two_anc_checkup($export_two_anc = NULL)
	{	

		if ($this->from_date != NULL && $this->to_date != NULL) 
		{
			$query = "select anm.ANMID, anm.ANMCode, anm.ANMName, ifnull(a.done, 0) as done, ifnull(b.total, 0) as total FROM mstanm anm
			left join 
			(	
			SELECT count(*) as done, tmp.ByANMID FROM
			(
			SELECT v.* FROM `tblancvisit` v 
			inner join tblpregnant_woman w 
			on v.PWGUID = w.PWGUID
			where v.CheckupVisitDate is not null
			and w.PWRegistrationDate between STR_TO_DATE('".$this->from_date."', '%Y-%m-%d') and  STR_TO_DATE('".$this->to_date."', '%Y-%m-%d')
			group by v.PWGUID, ByANMID having count(*) = 2
			) tmp group by ByANMID
			)a on anm.ANMID = a.ByANMID
			left join 
			(
			SELECT count(*) as total, tmp.ByANMID FROM
			(
			SELECT v.* FROM `tblancvisit` v 
			inner join tblpregnant_woman w 
			on v.PWGUID = w.PWGUID
			where w.PWRegistrationDate between STR_TO_DATE('".$this->from_date."', '%Y-%m-%d') and  STR_TO_DATE('".$this->to_date."', '%Y-%m-%d')
			group by v.PWGUID, ByANMID
			)tmp group by ByANMID
			)b on anm.ANMID = b.ByANMID
			where anm.LanguageID=1";
		}else{

			$query = "select anm.ANMID, anm.ANMCode, anm.ANMName, ifnull(a.done, 0) as done, ifnull(b.total, 0) as total FROM mstanm anm
			left join 
			(	
			SELECT count(*) as done, tmp.ByANMID FROM
			(
			SELECT v.* FROM `tblancvisit` v 
			inner join tblpregnant_woman w 
			on v.PWGUID = w.PWGUID
			where v.CheckupVisitDate is not null
			group by v.PWGUID, ByANMID having count(*) = 2
			) tmp group by ByANMID
			)a on anm.ANMID = a.ByANMID
			left join 
			(
			SELECT count(*) as total, tmp.ByANMID FROM
			(
			SELECT v.* FROM `tblancvisit` v 
			inner join tblpregnant_woman w 
			on v.PWGUID = w.PWGUID
			group by v.PWGUID, ByANMID
			)tmp group by ByANMID
			)b on anm.ANMID = b.ByANMID
			where anm.LanguageID=1";

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

		$content['anm_list'] = $this->db->query($query)->result();
		$content['indicator_name'] = "Proportion of pregnant women with 2 ANC check-up";
		$content['indicator'] = "two_anc_checkup";
		$content['subview'] = "indicator_anm_list";
		$this->load->view('gov/main_layout', $content);
	}	

	public function three_anc_checkup($export_three_anc = NULL)
	{	

		if ($this->from_date != NULL && $this->to_date != NULL) 
		{
			$query = "select anm.ANMID, anm.ANMCode, anm.ANMName, ifnull(a.done, 0) as done, ifnull(b.total, 0) as total FROM mstanm anm
			left join 
			(	
			SELECT count(*) as done, tmp.ByANMID FROM
			(
			SELECT v.* FROM `tblancvisit` v 
			inner join tblpregnant_woman w 
			on v.PWGUID = w.PWGUID
			where v.CheckupVisitDate is not null
			and w.PWRegistrationDate between STR_TO_DATE('".$this->from_date."', '%Y-%m-%d') and  STR_TO_DATE('".$this->to_date."', '%Y-%m-%d')
			group by v.PWGUID, ByANMID having count(*) = 3
			) tmp group by ByANMID
			)a on anm.ANMID = a.ByANMID
			left join 
			(
			SELECT count(*) as total, tmp.ByANMID FROM
			(
			SELECT v.* FROM `tblancvisit` v 
			inner join tblpregnant_woman w 
			on v.PWGUID = w.PWGUID
			where w.PWRegistrationDate between STR_TO_DATE('".$this->from_date."', '%Y-%m-%d') and  STR_TO_DATE('".$this->to_date."', '%Y-%m-%d')
			group by v.PWGUID, ByANMID
			)tmp group by ByANMID
			)b on anm.ANMID = b.ByANMID
			where anm.LanguageID=1";
		}else{

			$query = "select anm.ANMID, anm.ANMCode, anm.ANMName, ifnull(a.done, 0) as done, ifnull(b.total, 0) as total FROM mstanm anm
			left join 
			(	
			SELECT count(*) as done, tmp.ByANMID FROM
			(
			SELECT v.* FROM `tblancvisit` v 
			inner join tblpregnant_woman w 
			on v.PWGUID = w.PWGUID
			where v.CheckupVisitDate is not null
			group by v.PWGUID, ByANMID having count(*) = 3
			) tmp group by ByANMID
			)a on anm.ANMID = a.ByANMID
			left join 
			(
			SELECT count(*) as total, tmp.ByANMID FROM
			(
			SELECT v.* FROM `tblancvisit` v 
			inner join tblpregnant_woman w 
			on v.PWGUID = w.PWGUID
			group by v.PWGUID, ByANMID
			)tmp group by ByANMID
			)b on anm.ANMID = b.ByANMID
			where anm.LanguageID=1";

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

		$content['anm_list'] = $this->db->query($query)->result();
		$content['indicator_name'] = "Proportion of pregnant women with 3 ANC check-up";
		$content['indicator'] = "three_anc_checkup";
		$content['subview'] = "indicator_anm_list";
		$this->load->view('gov/main_layout', $content);
	}

	public function four_anc_checkup($export_four_anc = NULL)
	{			
		if ($this->from_date != NULL && $this->to_date != NULL) 
		{
			$query = "select anm.ANMID, anm.ANMCode, anm.ANMName, ifnull(a.done, 0) as done, ifnull(b.total, 0) as total FROM mstanm anm
			left join 
			(	
			SELECT count(*) as done, tmp.ByANMID FROM
			(
			SELECT v.* FROM `tblancvisit` v 
			inner join tblpregnant_woman w 
			on v.PWGUID = w.PWGUID
			where v.CheckupVisitDate is not null
			and w.PWRegistrationDate between STR_TO_DATE('".$this->from_date."', '%Y-%m-%d') and  STR_TO_DATE('".$this->to_date."', '%Y-%m-%d')
			group by v.PWGUID, ByANMID having count(*) = 4
			) tmp group by ByANMID
			)a on anm.ANMID = a.ByANMID
			left join 
			(
			SELECT count(*) as total, tmp.ByANMID FROM
			(
			SELECT v.* FROM `tblancvisit` v 
			inner join tblpregnant_woman w 
			on v.PWGUID = w.PWGUID
			where w.PWRegistrationDate between STR_TO_DATE('".$this->from_date."', '%Y-%m-%d') and  STR_TO_DATE('".$this->to_date."', '%Y-%m-%d')
			group by v.PWGUID, ByANMID
			)tmp group by ByANMID
			)b on anm.ANMID = b.ByANMID
			where anm.LanguageID=1";

		}else{

			$query = "select anm.ANMID, anm.ANMCode, anm.ANMName, ifnull(a.done, 0) as done, ifnull(b.total, 0) as total FROM mstanm anm
			left join 
			(	
			SELECT count(*) as done, tmp.ByANMID FROM
			(
			SELECT v.* FROM `tblancvisit` v 
			inner join tblpregnant_woman w 
			on v.PWGUID = w.PWGUID
			where v.CheckupVisitDate is not null
			group by v.PWGUID, ByANMID having count(*) = 4
			) tmp group by ByANMID
			)a on anm.ANMID = a.ByANMID
			left join 
			(
			SELECT count(*) as total, tmp.ByANMID FROM
			(
			SELECT v.* FROM `tblancvisit` v 
			inner join tblpregnant_woman w 
			on v.PWGUID = w.PWGUID
			group by v.PWGUID, ByANMID
			)tmp group by ByANMID
			)b on anm.ANMID = b.ByANMID
			where anm.LanguageID=1";

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

		$content['anm_list'] = $this->db->query($query)->result();
		$content['indicator_name'] = "Proportion of pregnant women with 4 ANC check-up";
		$content['indicator'] = "four_anc_checkup";
		$content['subview'] = "indicator_anm_list";
		$this->load->view('gov/main_layout', $content);
	}

	public function tt2_booster($export_tt2_booster = NULL)
	{	

		if ($this->from_date != NULL && $this->to_date != NULL) 
		{
			$query = "select anm.ANMID, anm.ANMCode, anm.ANMName, ifnull(a.done, 0) as done, ifnull(b.total, 0) as total FROM mstanm anm
			left join 
			(	
			SELECT count(*) as done, tmp.ByANMID FROM
			(
			SELECT v.ByANMID FROM `tblancvisit` v 
			inner join tblpregnant_woman w 
			on v.PWGUID = w.PWGUID
			where v.TT2=1 or v.TTbooster=1 
			and w.PWRegistrationDate between STR_TO_DATE('".$this->from_date."', '%Y-%m-%d') and  STR_TO_DATE('".$this->to_date."', '%Y-%m-%d')
			group by v.PWGUID having count(*) > 0
			) tmp group by ByANMID
			)a on anm.ANMID = a.ByANMID
			left join 
			(
			SELECT count(*) as total, tmp.ByANMID FROM
			(
			SELECT v.ByANMID FROM `tblancvisit` v 
			inner join tblpregnant_woman w 
			on v.PWGUID = w.PWGUID
			where w.PWRegistrationDate between STR_TO_DATE('".$this->from_date."', '%Y-%m-%d') and  STR_TO_DATE('".$this->to_date."', '%Y-%m-%d')
			group by v.PWGUID
			)tmp group by ByANMID
			)b on anm.ANMID = b.ByANMID
			where anm.LanguageID=1";

		}else{

			$query = "select anm.ANMID, anm.ANMCode, anm.ANMName, ifnull(a.done, 0) as done, ifnull(b.total, 0) as total FROM mstanm anm
			left join 
			(	
			SELECT count(*) as done, tmp.ByANMID FROM
			(
			SELECT v.ByANMID FROM `tblancvisit` v 
			inner join tblpregnant_woman w 
			on v.PWGUID = w.PWGUID
			where v.TT2=1 or v.TTbooster=1
			group by v.PWGUID having count(*) > 0
			) tmp group by ByANMID
			)a on anm.ANMID = a.ByANMID
			left join 
			(
			SELECT count(*) as total, tmp.ByANMID FROM
			(
			SELECT v.ByANMID FROM `tblancvisit` v 
			inner join tblpregnant_woman w 
			on v.PWGUID = w.PWGUID
			group by v.PWGUID
			)tmp group by ByANMID
			)b on anm.ANMID = b.ByANMID
			where anm.LanguageID=1";
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

		$content['anm_list'] = $this->db->query($query)->result();
		$content['indicator_name'] = "Proportion of pregnant women who received  TT2  or Booster";
		$content['indicator'] = "tt2_booster";
		$content['subview'] = "indicator_anm_list";
		$this->load->view('gov/main_layout', $content);
	}

	public function newborns_visited_two_or_more_times($export_newborns = NULL)
	{
		if ($this->from_date != NULL && $this->to_date != NULL) {

			$query = "select
			anm.ANMID,
			anm.ANMName,
			anm.ANMCode,
			IFNULL(a.done,
			0) AS done,
			IFNULL(b.total,
			0) AS total
			FROM
			mstanm anm
			LEFT JOIN
			(
			SELECT COUNT(*) AS done,
			c.ANMID AS ANMID
			FROM
			(
			SELECT COUNT(*) AS done,
			v.ByANMID AS ANMID
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
			c.ANMID
			) a ON anm.ANMID = a.ANMID
			LEFT JOIN
			(
			SELECT COUNT(*) AS total,
			d.ANMID
			FROM
			(
			SELECT COUNT(*) AS total,
			v.ByANMID AS ANMID
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
			d.ANMID
			) b ON anm.ANMID = b.ANMID
			WHERE
			anm.LanguageID = 1";
		}else{
			$query = "select
			anm.ANMID, anm.ANMName,anm.ANMCode,
			IFNULL(a.done, 0) AS done,
			IFNULL(b.total,0) as total
			FROM
			mstanm anm
			LEFT JOIN
			(
			SELECT COUNT(*) AS done,
			c.ANMID AS ANMID
			FROM
			(
			SELECT COUNT(*) AS done,
			v.ByANMID AS ANMID
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
			c.ANMID
			) a ON anm.ANMID = a.ANMID
			LEFT JOIN
			(
			select count(*) as total, d.ANMID from 
			(
			SELECT COUNT(*) AS total,
			v.ByANMID AS ANMID
			FROM
			tblancvisit v
			INNER JOIN
			mstanm ON mstanm.ANMID = v.ByANMID AND mstanm.LanguageID = 1
			INNER JOIN
			tblpregnant_woman pw ON v.PWGUID = pw.PWGUID
			INNER JOIN
			tblchild c ON c.pw_GUID = pw.PWGUID
			GROUP BY
			v.PWGUID    
			)d group by d.ANMID
			) b ON anm.ANMID = b.ANMID
			WHERE
			anm.LanguageID = 1";
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

		$content['anm_list'] = $this->db->query($query)->result();
		$content['indicator_name'] = "PNewborns visited by ASHA at least two  or more times within first seven days";
		$content['indicator'] = "newborns_visited_two_or_more_times";
		$content['subview'] = "indicator_anm_list";
		$this->load->view('gov/main_layout', $content);
	}


	public function newborns_visited_three_or_more_times_home_delivery($export_home_delivery = NULL)
	{
		if ($this->from_date != NULL && $this->to_date != NULL) {
			$query = "select
			anm.ANMID,
			anm.ANMCode,
			anm.ANMName,
			IFNULL(a.done,
			0) AS done,
			IFNULL(b.total,
			0) AS total
			FROM
			mstanm anm
			LEFT JOIN
			(
			SELECT COUNT(*) AS done,
			c.ANMID AS ANMID
			FROM
			(
			SELECT COUNT(*) AS done,
			v.ByANMID AS ANMID
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
			c.ANMID
			) a ON anm.ANMID = a.ANMID
			LEFT JOIN
			(
			SELECT COUNT(*) AS total,
			d.ANMID
			FROM
			(
			SELECT COUNT(*) AS total,
			v.ByANMID AS ANMID
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
			d.ANMID
			) b ON anm.ANMID = b.ANMID
			WHERE
			anm.LanguageID = 1";

		}else{
			$query = "select anm.ANMID, anm.ANMCode, anm.ANMName, ifnull(a.done, 0) as done, ifnull(b.total, 0) as total FROM mstanm anm
			left join
			(
			select count(*) as done, v.ByANMID as ANMID FROM tblancvisit v
			INNER JOIN mstanm on mstanm.ANMID = v.ByANMID and mstanm.LanguageID = 1
			inner join tblpregnant_woman pw
			on v.PWGUID = pw.PWGUID
			inner join tblchild c 
			on c.pw_GUID = pw.PWGUID
			where v.CheckupVisitDate BETWEEN c.child_dob and DATE_ADD(c.child_dob, INTERVAL 7 day)
			and c.place_of_birth = 1			
			group by v.PWGUID having count(*) > 3
			)a on anm.ANMID = a.ANMID
			left join 
			(
			select count(*) as total, v.ByANMID as ANMID FROM tblancvisit v
			INNER JOIN mstanm on mstanm.ANMID = v.ByANMID and mstanm.LanguageID = 1
			inner join tblpregnant_woman pw
			on v.PWGUID = pw.PWGUID
			inner join tblchild c 
			on c.pw_GUID = pw.PWGUID
			where v.CheckupVisitDate BETWEEN c.child_dob and DATE_ADD(c.child_dob, INTERVAL 7 day)
			and c.place_of_birth = 1
			group by v.PWGUID having count(*) > 3
			)b on anm.ANMID = b.ANMID
			WHERE anm.LanguageID =1";
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

		$content['anm_list'] = $this->db->query($query)->result();
		$content['indicator_name'] = "Newborns visited by ASHA at least three  or more times within first seven days of home delivery";
		$content['indicator'] = "newborns_visited_three_or_more_times_home_delivery";
		$content['subview'] = "indicator_anm_list";
		$this->load->view('gov/main_layout', $content);
	}


	public function newborns_visited_two_or_more_times_instituional($export_newborns_instituional = NULL)
	{
		if ($this->from_date != NULL && $this->to_date != NULL) {
			$query = "select
			anm.ANMID,
			anm.ANMCode,
			anm.ANMName,
			IFNULL(a.done,
			0) AS done,
			IFNULL(b.total,
			0) AS total
			FROM
			mstanm anm
			LEFT JOIN
			(
			SELECT COUNT(*) AS done,
			c.ANMID AS ANMID
			FROM
			(
			SELECT COUNT(*) AS done,
			v.ByANMID AS ANMID
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
			c.ANMID
			) a ON anm.ANMID = a.ANMID
			LEFT JOIN
			(
			SELECT COUNT(*) AS total,
			d.ANMID
			FROM
			(
			SELECT COUNT(*) AS total,
			v.ByANMID AS ANMID
			FROM
			tblancvisit v
			INNER JOIN
			mstanm ON mstanm.ANMID = v.ByANMID AND mstanm.LanguageID = 1
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
			d.ANMID
			) b ON anm.ANMID = b.ANMID
			WHERE
			anm.LanguageID = 1";
		}
		else{
			$query = "select
			anm.ANMID,
			anm.ANMCode,
			anm.ANMName,
			IFNULL(a.done,
			0) AS done,
			IFNULL(b.total,
			0) AS total
			FROM
			mstanm anm
			LEFT JOIN
			(
			SELECT COUNT(*) AS done,
			c.ANMID AS ANMID
			FROM
			(
			SELECT COUNT(*) AS done,
			v.ByANMID AS ANMID
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
			c.ANMID
			) a ON anm.ANMID = a.ANMID
			LEFT JOIN
			(
			SELECT COUNT(*) AS total,
			d.ANMID
			FROM
			(
			SELECT COUNT(*) AS done,
			v.ByANMID AS ANMID
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
			d.ANMID
			) b ON anm.ANMID = b.ANMID
			WHERE
			anm.LanguageID = 1";
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

		$content['anm_list'] = $this->db->query($query)->result();
		$content['indicator_name'] = "Newborns visited by ASHA at least two  or more times within first seven days of institutional delivery";
		$content['indicator'] = "newborns_visited_two_or_more_times_instituional";
		$content['subview'] = "indicator_anm_list";
		$this->load->view('gov/main_layout', $content);
	}
}