<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Indicator_anm_list extends CI_Controller {

	private $from_date;
	private $to_date;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Common_Model');
		$this->from_date = $this->session->userdata("from_date");
		$this->to_date = $this->session->userdata("to_date");
	}

	public function preg_women_reg_first_trimester()
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

		$content['anm_list'] = $this->db->query($query)->result();
		$content['indicator_name'] = "Proportion of pregnant Women Registered in the First Trimester";
		$content['indicator'] = "preg_women_reg_first_trimester";
		$content['subview'] = "indicator_anm_list";
		$this->load->view('public/main_layout', $content);
	}
	
	public function institutional_delivery()
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


		$content['anm_list'] = $this->db->query($query)->result();
		$content['indicator_name'] = "Proportion of institutional deliveries";
		$content['indicator'] = "institutional_delivery";
		$content['subview'] = "indicator_anm_list";
		$this->load->view('public/main_layout', $content);
	}

	public function low_birth_weight()
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

		$content['anm_list'] = $this->db->query($query)->result();
		$content['indicator_name'] = "Low Birth Weight";
		$content['indicator'] = "low_birth_weight";
		$content['subview'] = "indicator_anm_list";
		$this->load->view('public/main_layout', $content);
	}

	public function one_anc_checkup()
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
			group by v.PWGUID, ByANMID having count(*) = 1
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
			group by v.PWGUID, ByANMID having count(*) = 1
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

		$content['anm_list'] = $this->db->query($query)->result();
		$content['indicator_name'] = "Proportion of pregnant women with 1 ANC check-up";
		$content['indicator'] = "one_anc_checkup";
		$content['subview'] = "indicator_anm_list";
		$this->load->view('public/main_layout', $content);
	}


	public function two_anc_checkup()
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

		$content['anm_list'] = $this->db->query($query)->result();
		$content['indicator_name'] = "Proportion of pregnant women with 2 ANC check-up";
		$content['indicator'] = "two_anc_checkup";
		$content['subview'] = "indicator_anm_list";
		$this->load->view('public/main_layout', $content);
	}	

	public function three_anc_checkup()
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

		$content['anm_list'] = $this->db->query($query)->result();
		$content['indicator_name'] = "Proportion of pregnant women with 3 ANC check-up";
		$content['indicator'] = "three_anc_checkup";
		$content['subview'] = "indicator_anm_list";
		$this->load->view('public/main_layout', $content);
	}

	public function four_anc_checkup()
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

		$content['anm_list'] = $this->db->query($query)->result();
		$content['indicator_name'] = "Proportion of pregnant women with 4 ANC check-up";
		$content['indicator'] = "four_anc_checkup";
		$content['subview'] = "indicator_anm_list";
		$this->load->view('public/main_layout', $content);
	}

	public function tt2_booster()
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

		$content['anm_list'] = $this->db->query($query)->result();
		$content['indicator_name'] = "Proportion of pregnant women who received  TT2  or Booster";
		$content['indicator'] = "tt2_booster";
		$content['subview'] = "indicator_anm_list";
		$this->load->view('public/main_layout', $content);
	}

}