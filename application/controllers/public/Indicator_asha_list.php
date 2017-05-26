<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Indicator_asha_list extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Common_Model');
	}

	public function preg_women_reg_first_trimester($anmcode)
	{	

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

		$content['asha_list'] = $this->db->query($query)->result();
		$content['indicator_name'] = "Proportion of pregnant Women Registered in the First Trimester";
		$content['indicator'] = "preg_women_reg_first_trimester";
		$content['subview'] = "indicator_asha_list";
		$this->load->view('public/main_layout', $content);
	}

	public function institutional_delivery($anmcode)
	{	

		$query = "SELECT
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

		$content['asha_list'] = $this->db->query($query)->result();
		$content['indicator_name'] = "Proportion of institutional deliveries";
		$content['indicator'] = "institutional_delivery";
		$content['subview'] = "indicator_asha_list";
		$this->load->view('public/main_layout', $content);
	}

	public function one_anc_checkup($anmcode)
	{	

		$query = "select asha.ASHAID, asha.ASHAName, ifnull(a.done, 0) as done, ifnull(b.total, 0) as total FROM mstasha asha
		left join 
		(
			SELECT count(*) as done, tmp.ByAshaID FROM
			(
				SELECT * FROM `tblancvisit` where CheckupVisitDate is not null group by PWGUID, ByAshaID having count(*) = 1
			) tmp group by ByAshaID
		)a on asha.ASHAID = a.ByAshaID
		left join 
		(
			SELECT count(*) as total, tmp.ByAshaID FROM
			(
				SELECT * FROM `tblancvisit` group by PWGUID, ByAshaID
			) tmp group by ByAshaID
		)b on asha.ASHAID = b.ByAshaID
		where asha.LanguageID=1 and asha.ANMCode = $anmcode";

		$content['asha_list'] = $this->db->query($query)->result();
		$content['indicator_name'] = "Proportion of pregnant women with 1 ANC check-up";
		$content['indicator'] = "one_anc_checkup";
		$content['subview'] = "indicator_asha_list";
		$this->load->view('public/main_layout', $content);
	}

	public function low_birth_weight($anmcode)
	{	

		$query = "SELECT
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

		$content['asha_list'] = $this->db->query($query)->result();
		$content['indicator_name'] = "Low Birth Weight";
		$content['indicator'] = "low_birth_weight";
		$content['subview'] = "indicator_asha_list";
		$this->load->view('public/main_layout', $content);
	}

	public function two_anc_checkup($anmcode)
	{	

		$query = "select asha.ASHAID, asha.ASHAName, ifnull(a.done, 0) as done, ifnull(b.total, 0) as total FROM mstasha asha
		left join 
		(
			SELECT count(*) as done, tmp.ByAshaID FROM
			(
				SELECT * FROM `tblancvisit` where CheckupVisitDate is not null group by PWGUID, ByAshaID having count(*) = 2
			) tmp group by ByAshaID
		)a on asha.ASHAID = a.ByAshaID
		left join 
		(
			SELECT count(*) as total, tmp.ByAshaID FROM
			(
				SELECT * FROM `tblancvisit` group by PWGUID, ByAshaID
			) tmp group by ByAshaID
		)b on asha.ASHAID = b.ByAshaID
		where asha.LanguageID=1 and asha.ANMCode = $anmcode";

		$content['asha_list'] = $this->db->query($query)->result();
		$content['indicator_name'] = "Proportion of pregnant women with 1 ANC check-up";
		$content['indicator'] = "two_anc_checkup";
		$content['subview'] = "indicator_asha_list";
		$this->load->view('public/main_layout', $content);
	}

	public function three_anc_checkup($anmcode)
	{	

		$query = "select asha.ASHAID, asha.ASHAName, ifnull(a.done, 0) as done, ifnull(b.total, 0) as total FROM mstasha asha
		left join 
		(
			SELECT count(*) as done, tmp.ByAshaID FROM
			(
				SELECT * FROM `tblancvisit` where CheckupVisitDate is not null group by PWGUID, ByAshaID having count(*) = 3
			) tmp group by ByAshaID
		)a on asha.ASHAID = a.ByAshaID
		left join 
		(
			SELECT count(*) as total, tmp.ByAshaID FROM
			(
				SELECT * FROM `tblancvisit` group by PWGUID, ByAshaID
			) tmp group by ByAshaID
		)b on asha.ASHAID = b.ByAshaID
		where asha.LanguageID=1 and asha.ANMCode = $anmcode";

		$content['asha_list'] = $this->db->query($query)->result();
		$content['indicator_name'] = "Proportion of pregnant women with 1 ANC check-up";
		$content['indicator'] = "three_anc_checkup";
		$content['subview'] = "indicator_asha_list";
		$this->load->view('public/main_layout', $content);
	}

	public function four_anc_checkup($anmcode)
	{	

		$query = "select asha.ASHAID, asha.ASHAName, ifnull(a.done, 0) as done, ifnull(b.total, 0) as total FROM mstasha asha
		left join 
		(
			SELECT count(*) as done, tmp.ByAshaID FROM
			(
				SELECT * FROM `tblancvisit` where CheckupVisitDate is not null group by PWGUID, ByAshaID having count(*) = 4
			) tmp group by ByAshaID
		)a on asha.ASHAID = a.ByAshaID
		left join 
		(
			SELECT count(*) as total, tmp.ByAshaID FROM
			(
				SELECT * FROM `tblancvisit` group by PWGUID, ByAshaID
			) tmp group by ByAshaID
		)b on asha.ASHAID = b.ByAshaID
		where asha.LanguageID=1 and asha.ANMCode = $anmcode";

		$content['asha_list'] = $this->db->query($query)->result();
		$content['indicator_name'] = "Proportion of pregnant women with 1 ANC check-up";
		$content['indicator'] = "four_anc_checkup";
		$content['subview'] = "indicator_asha_list";
		$this->load->view('public/main_layout', $content);
	}

	public function tt2_booster($anmcode)
	{	

		$query = "select asha.ASHAID, asha.ASHAName, ifnull(a.done, 0) as done, ifnull(b.total, 0) as total FROM mstasha asha
		left join 
		(
			SELECT count(*) as done, tmp.ByAshaID FROM
			(
				SELECT * FROM `tblancvisit` where TT2=1 or TTbooster=1 group by PWGUID having count(*) > 0
			) tmp group by ByAshaID
		)a on asha.ASHAID = a.ByAshaID
		left join 
		(
			SELECT count(*) as total, tmp.ByAshaID FROM
			(
				SELECT * FROM `tblancvisit` group by PWGUID, ByAshaID
			) tmp group by ByAshaID
		)b on asha.ASHAID = b.ByAshaID
		where asha.LanguageID=1 and asha.ANMCode = $anmcode";

		$content['asha_list'] = $this->db->query($query)->result();
		$content['indicator_name'] = "Proportion of pregnant women with 1 ANC check-up";
		$content['indicator'] = "tt2_booster";
		$content['subview'] = "indicator_asha_list";
		$this->load->view('public/main_layout', $content);
	}

}