<?php 

/**
 * Dashboard3 model 
 * made to show output indicators
 */

class Dashboard3_model extends CI_Model {
	
	private $filter_data;

	public function __construct()
	{
		parent::__construct();
		// $this->filter_data = ["date_from" => "2016-01-01", "date_to" => "2017-02-01"];
		$this->filter_data = ["date_from" => NULL, "date_to" => NULL];
	}

	/**
	 * Total Population
	 */

	public function get_total_population()
	{

		$query = "SELECT count(m.HHUID) as total from tblhhfamilymember m
		inner join tblhhsurvey s 
		on m.HHUID = s.HHUID";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and m.CreatedOn > '" . $this->filter_data['date_from'] . "' and m.CreatedOn < '" . $this->filter_data['date_to'] . "'";
		}

		return $this->db->query($query)->result()[0]->total;

	}

	/**
	 * Number of Women 15-49 years
	 */

	public function get_woman_age_15_49_years()
	{

		$query = "SELECT count(*) as total FROM `tblhhfamilymember` 
		where AprilAgeYear between
		(15+(TIMESTAMPDIFF(YEAR, str_to_date(concat(AgeAsOnYear, '-04-01'), '%Y-%m-%d'),now()))) and 
		(49+(TIMESTAMPDIFF(YEAR, str_to_date(concat(AgeAsOnYear, '-04-01'), '%Y-%m-%d'),now()))) and 
		GenderID = 2";

		return $this->db->query($query)->result()[0]->total;

	}

	
	/**
	 * Get list of children in the specified month range
	 */

	public function get_children_age_months($start_month, $end_month)
	{

		$query = "SELECT 
		COUNT(*) AS total
		FROM
		(SELECT 
		TIMESTAMPDIFF(MONTH, child_dob, NOW()) AS ageInMonth
		FROM
		tblchild) a
		WHERE
		a.ageInMonth BETWEEN $start_month AND $end_month";

		return $this->db->query($query)->result()[0]->total;

	}

	
	/**
	 * Adults aged 35-50 years
	 */

	public function get_adults_aged_35_50_years()
	{

		$query = "SELECT count(*) as total FROM `tblhhfamilymember` 
		where AprilAgeYear between
		(35+(TIMESTAMPDIFF(YEAR, str_to_date(concat(AgeAsOnYear, '-04-01'), '%Y-%m-%d'),now()))) and 
		(50+(TIMESTAMPDIFF(YEAR, str_to_date(concat(AgeAsOnYear, '-04-01'), '%Y-%m-%d'),now())))";

		return $this->db->query($query)->result()[0]->total;

	}

	
	/**
	 * Adults age more than 60 years of age
	 */

	public function get_adults_aged_60_years_and_more()
	{

		$query = "SELECT count(*) as total FROM `tblhhfamilymember` 
		where AprilAgeYear >
		(60+(TIMESTAMPDIFF(YEAR, str_to_date(concat(AgeAsOnYear, '-04-01'), '%Y-%m-%d'),now())))";

		return $this->db->query($query)->result()[0]->total;

	}

	/**
	 * Total pregnant women in the area
	 */

	public function get_total_pregnant_women_in_area()
	{

		$query = "SELECT count(*) as total from tblpregnant_woman 
		where IsPregnant=1 
		and TIMESTAMPDIFF(MONTH, LMPDate, CURRENT_TIMESTAMP) < 10";

		return $this->db->query($query)->result()[0]->total;

	}

	/**
	 * Functon to calculate proportion from query
	 */
	private function get_proportion($query)
	{

		$result = $this->db->query($query)->result();

		if (count($result) < 2) {
			return ["numenator"=>0, "denominator"=>0, "percent"=>number_format(0,2)];
		}

		$numenator = $result[0]->total;
		$denominator = $result[1]->total;

		if ($denominator == 0) {
			return ["numenator"=>$numenator, "denominator"=>0, "percent"=>number_format(0,2)];
		}

		return ["numenator"=>$numenator, "denominator"=>$denominator, "percent"=>number_format(($numenator / $denominator) * 100,2)];
	}

	/**
	 * Proportion of pregnant Women Registered in the First Trimester
	 */

	public function get_proportion_of_pregnant_woman_registered_in_first_trimester()
	{

		$query = "SELECT count(*) as total from tblpregnant_woman 
		where IsPregnant=1 
		and Regwithin12weeks=1
		and TIMESTAMPDIFF(MONTH, LMPDate, CURRENT_TIMESTAMP) < 10";
		
		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and PWRegistrationDate > '" . $this->filter_data['date_from'] . "' and PWRegistrationDate < '" . $this->filter_data['date_to'] . "'";
		}

		$query .= "
		union all 
		SELECT count(*) as total from tblpregnant_woman 
		where IsPregnant=1 
		and TIMESTAMPDIFF(MONTH, LMPDate, CURRENT_TIMESTAMP) < 10";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and PWRegistrationDate > '" . $this->filter_data['date_from'] . "' and PWRegistrationDate < '" . $this->filter_data['date_to'] . "'";
		}


		return $this->get_proportion($query);

	}

	/**
	 * Proportion of pregnant women with 1 ANC check-up
	 */

	public function get_proportion_of_pregnant_woman_with_one_anc_checkup()
	{

		$query = "SELECT count(v.AncVisitID) as total FROM tblancvisit v
		inner join tblpregnant_woman pw
		on v.PWGUID = pw.PWGUID
		where  pw.IsPregnant = 1
		and v.Visit_No = 1
		and v.CheckupVisitDate is not null
		and TIMESTAMPDIFF(MONTH, pw.LMPDate, CURRENT_TIMESTAMP) <=3 ";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and pw.PWRegistrationDate > '" . $this->filter_data['date_from'] . "' and pw.PWRegistrationDate < '" . $this->filter_data['date_to'] . "'";
		}

		$query .= "
		UNION ALL
		SELECT count(PWGUID) as total FROM `tblpregnant_woman` where 
		TIMESTAMPDIFF(MONTH, LMPDate, CURRENT_TIMESTAMP) <=3 
		and IsPregnant = 1";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and PWRegistrationDate > '" . $this->filter_data['date_from'] . "' and PWRegistrationDate < '" . $this->filter_data['date_to'] . "'";
		}

		return $this->get_proportion($query);

	}

	/**
	 * Proportion of pregnant women with 2 ANC check-up
	 */

	public function get_proportion_of_pregnant_woman_with_two_anc_checkup()
	{

		$query = "SELECT count(v.AncVisitID) as total FROM tblancvisit v
		inner join tblpregnant_woman pw
		on v.PWGUID = pw.PWGUID
		where  pw.IsPregnant = 1
		and v.Visit_No = 2
		and v.CheckupVisitDate is not null
		and TIMESTAMPDIFF(MONTH, pw.LMPDate, CURRENT_TIMESTAMP) >3 
		and TIMESTAMPDIFF(MONTH, pw.LMPDate, CURRENT_TIMESTAMP) <=6 ";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and pw.PWRegistrationDate > '" . $this->filter_data['date_from'] . "' and pw.PWRegistrationDate < '" . $this->filter_data['date_to'] . "'";
		}

		$query .= "
		UNION ALL
		SELECT count(PWGUID) as total FROM `tblpregnant_woman` 
		where TIMESTAMPDIFF(MONTH, LMPDate, CURRENT_TIMESTAMP) >3 
		and TIMESTAMPDIFF(MONTH, LMPDate, CURRENT_TIMESTAMP) <=6 
		and IsPregnant = 1";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and PWRegistrationDate > '" . $this->filter_data['date_from'] . "' and PWRegistrationDate < '" . $this->filter_data['date_to'] . "'";
		}
		

		return $this->get_proportion($query);

	}

	/**
	 * Proportion of pregnant women with 3 ANC check-up
	 */

	public function get_proportion_of_pregnant_woman_with_three_anc_checkup()
	{

		$query = "SELECT count(v.AncVisitID) as total FROM tblancvisit v
		inner join tblpregnant_woman pw
		on v.PWGUID = pw.PWGUID
		where  pw.IsPregnant = 1
		and v.Visit_No = 3
		and v.CheckupVisitDate is not null
		and TIMESTAMPDIFF(MONTH, pw.LMPDate, CURRENT_TIMESTAMP) >=7 
		and TIMESTAMPDIFF(MONTH, pw.LMPDate, CURRENT_TIMESTAMP) <=8 ";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and pw.PWRegistrationDate > '" . $this->filter_data['date_from'] . "' and pw.PWRegistrationDate < '" . $this->filter_data['date_to'] . "'";
		}

		$query .= "
		UNION ALL
		SELECT count(PWGUID) as total FROM `tblpregnant_woman` 
		where TIMESTAMPDIFF(MONTH, LMPDate, CURRENT_TIMESTAMP) >=7
		and TIMESTAMPDIFF(MONTH, LMPDate, CURRENT_TIMESTAMP) <=8 
		and IsPregnant = 1";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and PWRegistrationDate > '" . $this->filter_data['date_from'] . "' and PWRegistrationDate < '" . $this->filter_data['date_to'] . "'";
		}


		return $this->get_proportion($query);

	}

	/**
	 * Proportion of pregnant women with 4 ANC check-up
	 */

	public function get_proportion_of_pregnant_woman_with_four_anc_checkup()
	{

		$query = "SELECT count(v.AncVisitID) as total FROM tblancvisit v
		inner join tblpregnant_woman pw
		on v.PWGUID = pw.PWGUID
		where  pw.IsPregnant = 1
		and v.Visit_No = 4
		and v.CheckupVisitDate is not null
		and TIMESTAMPDIFF(MONTH, pw.LMPDate, CURRENT_TIMESTAMP) >=9 
		and TIMESTAMPDIFF(MONTH, pw.LMPDate, CURRENT_TIMESTAMP) <=10 ";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and pw.PWRegistrationDate > '" . $this->filter_data['date_from'] . "' and pw.PWRegistrationDate < '" . $this->filter_data['date_to'] . "'";
		}

		$query .= "
		UNION ALL
		SELECT count(PWGUID) as total FROM `tblpregnant_woman` 
		where TIMESTAMPDIFF(MONTH, LMPDate, CURRENT_TIMESTAMP) >=9
		and TIMESTAMPDIFF(MONTH, LMPDate, CURRENT_TIMESTAMP) <=10
		and IsPregnant = 1";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and PWRegistrationDate > '" . $this->filter_data['date_from'] . "' and PWRegistrationDate < '" . $this->filter_data['date_to'] . "'";
		}


		return $this->get_proportion($query);

	}

	/**
	 * Proportion of pregnant women who received  TT2  or Booster
	 */

	public function get_proportion_of_pregnant_woman_received_tt2_or_booster()
	{

		$query = "SELECT count(*) as total from 
		(
		SELECT v.AncVisitID FROM tblancvisit v
		inner join tblpregnant_woman pw
		on v.PWGUID = pw.PWGUID
		where v.TT2=1 or v.TTbooster=1 ";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and pw.PWRegistrationDate > '" . $this->filter_data['date_from'] . "' and pw.PWRegistrationDate < '" . $this->filter_data['date_to'] . "'";
		}

		$query .= " and pw.IsPregnant = 1
		group by v.PWGUID having count(*) > 0
		)a
		UNION ALL
		SELECT count(*) as total FROM `tblpregnant_woman` pw 
		where TIMESTAMPDIFF(MONTH, pw.LMPDate, CURRENT_TIMESTAMP) < 10
		and pw.IsPregnant = 1";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and pw.PWRegistrationDate > '" . $this->filter_data['date_from'] . "' and pw.PWRegistrationDate < '" . $this->filter_data['date_to'] . "'";
		}

		return $this->get_proportion($query);

	}


	/**
	 * Proportion of institutional deliveries
	 */

	public function get_proportion_of_institutional_deliveries()
	{

		$query = "SELECT COUNT(w.PWGUID) AS total
		FROM
		tblpregnant_woman w
		INNER JOIN
		tblchild c ON w.PWGUID = c.pw_GUID
		WHERE c.place_of_birth = 2 ";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		$query .= "
		UNION ALL
		SELECT COUNT(w.PWGUID) AS total
		FROM
		`tblpregnant_woman` w
		INNER JOIN
		tblchild c ON w.PWGUID = c.pw_GUID 
		where 1=1 ";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		return $this->get_proportion($query);

	}

	/**
	 * Newborns visited by ASHA at least three  or more times within first seven days of home delivery
	 */

	public function get_newborns_visited_three_more_seven_days_home_delivery()
	{

		$query = "SELECT count(*) as total from 
		(
		SELECT v.AncVisitID FROM tblancvisit v
		inner join tblpregnant_woman pw
		on v.PWGUID = pw.PWGUID
		inner join tblchild c 
		on c.pw_GUID = pw.PWGUID
		where v.CheckupVisitDate BETWEEN c.child_dob and DATE_ADD(c.child_dob, INTERVAL 7 day) ";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}		

		$query .= " group by v.PWGUID having count(*) > 2
		)a
		UNION ALL
		SELECT count(PWGUID) as total 
		FROM `tblpregnant_woman` pw
		inner join tblchild c 
		on c.pw_GUID = pw.PWGUID
		where 1=1 ";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		return $this->get_proportion($query);

	}

	/**
	 * Newborns visited by ASHA at least two  or more times within first seven days of institutional delivery
	 */

	public function get_newborns_visited_two_more_seven_days_institutional_delivery()
	{

		$query = "SELECT count(*) as total from 
		(
		SELECT v.AncVisitID FROM tblancvisit v
		inner join tblpregnant_woman pw
		on v.PWGUID = pw.PWGUID
		inner join tblchild c 
		on c.pw_GUID = pw.PWGUID
		where v.CheckupVisitDate BETWEEN c.child_dob and DATE_ADD(c.child_dob, INTERVAL 7 day) ";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		$query .= " group by v.PWGUID having count(*) > 1
		)a
		UNION ALL
		SELECT count(PWGUID) as total 
		FROM `tblpregnant_woman` pw
		inner join tblchild c 
		on c.pw_GUID = pw.PWGUID
		where 1=1 ";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		return $this->get_proportion($query);

	}

	/**
	 * Low Birth Weight
	 */

	public function get_low_birth_weight()
	{

		$query = "SELECT count(w.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman w 
		on c.pw_GUID = w.PWGUID
		where  c.Wt_of_child < 2.5 ";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		$query .= "	UNION ALL
		SELECT count(w.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman w 
		on c.pw_GUID = w.PWGUID
		where 1=1 ";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		return $this->get_proportion($query);

	}

	/**
	 * Proportion of chidren received BCG at birth
	 */

	public function get_proportion_received_bcg_birth()
	{

		$query = "SELECT count(w.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman w 
		on c.pw_GUID = w.PWGUID
		where  c.bcg = c.child_dob ";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		$query .= " UNION ALL
		SELECT count(w.PWGUID) from tblchild c 
		inner join tblpregnant_woman w 
		on c.pw_GUID = w.PWGUID
		where 1=1 ";
		
		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}
		
		return $this->get_proportion($query);

	}

	/**
	 * Proportion of chidren received OPV0 at birth
	 */

	public function get_proportion_received_opv0_birth()
	{

		$query = "SELECT count(w.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman w 
		on c.pw_GUID = w.PWGUID
		where  c.opv1 = c.child_dob ";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		$query .= " UNION ALL
		SELECT count(w.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman w 
		on c.pw_GUID = w.PWGUID
		where 1=1 ";
		
		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		return $this->get_proportion($query);

	}

	/**
	 * Proportion of chidren received HEPB0 at birth
	 */

	public function get_proportion_received_hepb0_birth()
	{

		$query = "SELECT count(w.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman w 
		on c.pw_GUID = w.PWGUID
		where  c.hepb1 = c.child_dob ";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		$query .= " UNION ALL
		SELECT count(w.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman w 
		on c.pw_GUID = w.PWGUID
		where 1=1 ";
		
		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		return $this->get_proportion($query);

	}


	/**
	 * Proportion of chidren received HEPB0 at birth
	 */

	public function get_proportion_children_less_45_days_opv1()
	{

		$query = "SELECT count(w.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman w 
		on c.pw_GUID = w.PWGUID
		where  c.opv2 is not null
		and TIMESTAMPDIFF(DAY, c.child_dob, CURRENT_TIMESTAMP) >= 45 ";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		$query .= "	UNION ALL
		SELECT count(w.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman w 
		on c.pw_GUID = w.PWGUID
		where TIMESTAMPDIFF(DAY, c.child_dob, CURRENT_TIMESTAMP) >= 45 ";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		return $this->get_proportion($query);

	}

	/**
	 * Proportion of chidren aged 45 days or more received DPT1
	 */

	public function get_proportion_children_less_45_days_dpt1()
	{

		$query = "SELECT count(w.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman w 
		on c.pw_GUID = w.PWGUID
		where  c.dpt2 is not null
		and TIMESTAMPDIFF(DAY, c.child_dob, CURRENT_TIMESTAMP) >= 45 ";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		$query .= "	UNION ALL
		SELECT count(w.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman w 
		on c.pw_GUID = w.PWGUID
		where TIMESTAMPDIFF(DAY, c.child_dob, CURRENT_TIMESTAMP) >= 45 ";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		return $this->get_proportion($query);

	}

	/**
	 * Proportion of chidren aged 45 days or more received Hepatitis B1
	 */

	public function get_proportion_children_less_45_days_hepb1()
	{

		$query = "SELECT count(w.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman w 
		on c.pw_GUID = w.PWGUID
		where  c.hepb2 is not null
		and TIMESTAMPDIFF(DAY, c.child_dob, CURRENT_TIMESTAMP) >= 45 ";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		$query .= "	UNION ALL
		SELECT count(w.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman w 
		on c.pw_GUID = w.PWGUID
		where TIMESTAMPDIFF(DAY, c.child_dob, CURRENT_TIMESTAMP) >= 45 ";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		return $this->get_proportion($query);

	}

	/**
	 * Proportion of chidren aged 75 days or more received OPV2
	 */

	public function get_proportion_children_more_75_days_opv2()
	{

		$query = "SELECT count(w.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman w 
		on c.pw_GUID = w.PWGUID
		where  c.opv3 is not null
		and TIMESTAMPDIFF(DAY, c.child_dob, CURRENT_TIMESTAMP) >= 75 ";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		$query .= "	UNION ALL
		SELECT count(w.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman w 
		on c.pw_GUID = w.PWGUID
		where TIMESTAMPDIFF(DAY, c.child_dob, CURRENT_TIMESTAMP) >= 75 ";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		return $this->get_proportion($query);

	}

	/**
	 * Proportion of chidren aged 75 days or more received DPT2
	 */

	public function get_proportion_children_more_75_days_dpt2()
	{

		$query = "SELECT count(w.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman w 
		on c.pw_GUID = w.PWGUID
		where  c.dpt2 is not null
		and TIMESTAMPDIFF(DAY, c.child_dob, CURRENT_TIMESTAMP) >= 75 ";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		$query .= "	UNION ALL
		SELECT count(w.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman w 
		on c.pw_GUID = w.PWGUID
		where TIMESTAMPDIFF(DAY, c.child_dob, CURRENT_TIMESTAMP) >= 75 ";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		return $this->get_proportion($query);

	}

	/**
	 * Proportion of chidren aged 75 days or more received Hepatitis B2
	 */

	public function get_proportion_children_more_75_days_hepb2()
	{

		$query = "SELECT count(w.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman w 
		on c.pw_GUID = w.PWGUID
		where  c.hepb3 is not null
		and TIMESTAMPDIFF(DAY, c.child_dob, CURRENT_TIMESTAMP) >= 75 ";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		$query .= "	UNION ALL
		SELECT count(w.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman w 
		on c.pw_GUID = w.PWGUID
		where TIMESTAMPDIFF(DAY, c.child_dob, CURRENT_TIMESTAMP) >= 75 ";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		return $this->get_proportion($query);

	}

	/**
	 * Proportion of chidren aged 105 days or more received OPV3
	 */

	public function get_proportion_children_more_105_days_opv3()
	{

		$query = "SELECT count(w.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman w 
		on c.pw_GUID = w.PWGUID
		where  c.opv4 is not null
		and TIMESTAMPDIFF(DAY, c.child_dob, CURRENT_TIMESTAMP) >= 105 ";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		$query .= "	UNION ALL
		SELECT count(w.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman w 
		on c.pw_GUID = w.PWGUID
		where TIMESTAMPDIFF(DAY, c.child_dob, CURRENT_TIMESTAMP) >= 105 ";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		return $this->get_proportion($query);

	}

	/**
	 * Proportion of chidren aged 105 days or more received DPT3
	 */

	public function get_proportion_children_more_105_days_dpt3()
	{

		$query = "SELECT count(w.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman w 
		on c.pw_GUID = w.PWGUID
		where  c.dpt3 is not null
		and TIMESTAMPDIFF(DAY, c.child_dob, CURRENT_TIMESTAMP) >= 105 ";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		$query .= "	UNION ALL
		SELECT count(w.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman w 
		on c.pw_GUID = w.PWGUID
		where TIMESTAMPDIFF(DAY, c.child_dob, CURRENT_TIMESTAMP) >= 105 ";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		return $this->get_proportion($query);

	}

	/**
	 * Proportion of chidren aged 105 days or more received HRPB3
	 */

	public function get_proportion_children_more_105_days_hepb3()
	{

		$query = "SELECT count(w.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman w 
		on c.pw_GUID = w.PWGUID
		where  c.hepb4 is not null
		and TIMESTAMPDIFF(DAY, c.child_dob, CURRENT_TIMESTAMP) >= 105 ";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		$query .= "	UNION ALL
		SELECT count(w.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman w 
		on c.pw_GUID = w.PWGUID
		where TIMESTAMPDIFF(DAY, c.child_dob, CURRENT_TIMESTAMP) >= 105 ";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		return $this->get_proportion($query);

	}

	/**
	 * Proportion of chidren aged 9 months received Measles vaccination
	 */

	public function get_proportion_children_nine_months_more_measles()
	{

		$query = "SELECT count(w.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman w 
		on c.pw_GUID = w.PWGUID
		where  c.measeals is not null
		and TIMESTAMPDIFF(MONTH, c.child_dob, CURRENT_TIMESTAMP) >= 9 ";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		$query .= "	UNION ALL
		SELECT count(w.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman w 
		on c.pw_GUID = w.PWGUID
		where TIMESTAMPDIFF(MONTH, c.child_dob, CURRENT_TIMESTAMP) >= 9 ";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		return $this->get_proportion($query);

	}

	/**
	 * Proportion of chidren aged 9 months received Vitamin A
	 */

	public function get_proportion_children_nine_months_more_vitamin_a()
	{

		$query = "SELECT count(w.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman w 
		on c.pw_GUID = w.PWGUID
		where  c.vitaminA is not null
		and TIMESTAMPDIFF(MONTH, c.child_dob, CURRENT_TIMESTAMP) >= 9 ";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		$query .= "	UNION ALL
		SELECT count(w.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman w 
		on c.pw_GUID = w.PWGUID
		where TIMESTAMPDIFF(MONTH, c.child_dob, CURRENT_TIMESTAMP) >= 9 ";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		return $this->get_proportion($query);

	}

	/**
	 * Proportion of chidren aged 16 months received second dose of Vitamin A
	 */

	public function get_proportion_children_sixteen_months_vitamin_a2()
	{

		$query = "SELECT count(w.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman w 
		on c.pw_GUID = w.PWGUID
		where  c.VitaminAtwo is not null
		and TIMESTAMPDIFF(MONTH, c.child_dob, CURRENT_TIMESTAMP) = 18 ";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		$query .= "	UNION ALL
		SELECT count(w.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman w 
		on c.pw_GUID = w.PWGUID
		where TIMESTAMPDIFF(MONTH, c.child_dob, CURRENT_TIMESTAMP) = 18 ";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		return $this->get_proportion($query);

	}

	/**
	 * Proportion of children aged 16 to 24 motnhs received DPT booster
	 */

	public function get_proportion_children_16_24_months_dptbooster()
	{

		$query = "SELECT count(w.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman w 
		on c.pw_GUID = w.PWGUID
		where  c.DPTBooster is not null
		and TIMESTAMPDIFF(MONTH, c.child_dob, CURRENT_TIMESTAMP) >= 16
		and TIMESTAMPDIFF(MONTH, c.child_dob, CURRENT_TIMESTAMP) <= 24 ";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		$query .= "	UNION ALL
		SELECT count(w.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman w 
		on c.pw_GUID = w.PWGUID
		where TIMESTAMPDIFF(MONTH, c.child_dob, CURRENT_TIMESTAMP) >= 16 
		and TIMESTAMPDIFF(MONTH, c.child_dob, CURRENT_TIMESTAMP) <= 24 ";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		return $this->get_proportion($query);

	}

	/**
	 * Proportion of children aged 16 to 24 motnhs received Polio booster
	 */

	public function get_proportion_children_16_24_months_poliobooster()
	{

		$query = "SELECT count(w.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman w 
		on c.pw_GUID = w.PWGUID
		where  c.OPVBooster is not null
		and TIMESTAMPDIFF(MONTH, c.child_dob, CURRENT_TIMESTAMP) >= 16
		and TIMESTAMPDIFF(MONTH, c.child_dob, CURRENT_TIMESTAMP) <= 24 ";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		$query .= "	UNION ALL
		SELECT count(w.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman w 
		on c.pw_GUID = w.PWGUID
		where TIMESTAMPDIFF(MONTH, c.child_dob, CURRENT_TIMESTAMP) >= 16 
		and TIMESTAMPDIFF(MONTH, c.child_dob, CURRENT_TIMESTAMP) <= 24 ";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		return $this->get_proportion($query);

	}

	/**
	 * Proportion of chidren aged 24 months received third dose of Vitamin A
	 */

	public function proportion_children_24_months_vitamin_a3()
	{

		$query = "SELECT count(w.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman w 
		on c.pw_GUID = w.PWGUID
		where  c.VitaminA3 is not null
		and TIMESTAMPDIFF(MONTH, c.child_dob, CURRENT_TIMESTAMP) = 25";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		$query .= "	UNION ALL
		SELECT count(w.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman w 
		on c.pw_GUID = w.PWGUID
		where TIMESTAMPDIFF(MONTH, c.child_dob, CURRENT_TIMESTAMP) = 24 ";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		return $this->get_proportion($query);

	}

	/**
	 * Proportion of chidren aged 30 months received 4th dose of Vitamin A
	 */

	public function get_proportion_children_30_months_vitamin_a4()
	{

		$query = "SELECT count(w.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman w 
		on c.pw_GUID = w.PWGUID
		where  c.VitaminA4 is not null
		and TIMESTAMPDIFF(MONTH, c.child_dob, CURRENT_TIMESTAMP) = 30";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		$query .= "	UNION ALL
		SELECT count(w.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman w 
		on c.pw_GUID = w.PWGUID
		where TIMESTAMPDIFF(MONTH, c.child_dob, CURRENT_TIMESTAMP) = 30 ";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		return $this->get_proportion($query);

	}

	/**
	 * Proportion of chidren aged 36 months received 5th dose of Vitamin A
	 */

	public function get_proportion_children_36_months_vitamin_a5()
	{

		$query = "SELECT count(w.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman w 
		on c.pw_GUID = w.PWGUID
		where  c.VitaminA5 is not null
		and TIMESTAMPDIFF(MONTH, c.child_dob, CURRENT_TIMESTAMP) = 36";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		$query .= "	UNION ALL
		SELECT count(w.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman w 
		on c.pw_GUID = w.PWGUID
		where TIMESTAMPDIFF(MONTH, c.child_dob, CURRENT_TIMESTAMP) = 36 ";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		return $this->get_proportion($query);

	}















}
