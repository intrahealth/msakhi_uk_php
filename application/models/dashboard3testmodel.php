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
		$this->filter_data = $this->session->userdata("filter_data");
	}

	/**
	 * get_indicator_trend
	 * @indicator_id
	 * return [description, color, trend_data]
	 */
	public function get_indicator_trend($indicator_id = NULL)
	{
		$this->db->where('id', $indicator_id);
		$result = $this->db->get('tbl_indicator')->result();

		if (count($result) != 1) {
			return false;
		}

		$description = $result[0]->description;
		$color = $result[0]->color;
		$trend_data = $this->{$result[0]->trend_function}();

		return ["description"=>$description, "color"=>$color, "data"=>$trend_data];
	}

	/**
	 * get_proportion
	 */
	public function get_indicator_proportion($indicator_id = NULL)
	{
		$this->db->where('id', $indicator_id);
		$result = $this->db->get('tbl_indicator')->result();

		if (count($result) != 1) {
			return false;
		}
		
		return $this->{$result[0]->proportion_function}();
	}

	/**
	 * Get indicator details
	 */
	public function get_indicator_details($indicator_id = null)
	{
		$this->db->where('id', $indicator_id);
		$result = $this->db->get('tbl_indicator')->result();

		if (count($result) != 1) {
			return false;
		}
		return $result[0];
	}

	/**
	 * Get indicators of group
	 */
	public function get_indicator_of_group($indicator_group_id)
	{

		$this->db->where('group_id', $indicator_group_id);
		$this->db->order_by('sequence', 'asc');
		return $this->db->get('tbl_indicator')->result();
	}


	/**
	 * Total Population
	 */

	public function get_total_population()
	{

		$query = "SELECT count(*) as total from tblhhfamilymember m
		inner join tblhhsurvey s 
		on m.HHSurveyGUID = s.HHSurveyGUID
		WHERE m.IsDeleted = 0 and s.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and m.CreatedOn > '" . $this->filter_data['date_from'] . "' and m.CreatedOn < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and m.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and m.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= " and m.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
		if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
		{
			$state_code = $this->loginData->state_code;
			$query .= " and state_code = '$state_code'";	
		}
		else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code'";	
		}
		else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$block_code = $this->loginData->block_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
		}
		$query .= " and user_mode= 1)";

		// print_r($query);die;

		return $this->db->query($query)->result()[0]->total;
	}

	public function get_total_households()
	{

		$query = "select count(*) as total
		from tblhhsurvey  WHERE IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and CreatedOn > '" . $this->filter_data['date_from'] . "' and CreatedOn < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and ServiceProviderID = " . $this->filter_data['Asha'];
		}

		$query .= " and CreatedBy in (select user_id from tblusers where is_deleted=0 ";
		if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
		{
			$state_code = $this->loginData->state_code;
			$query .= " and state_code = '$state_code'";	
		}
		else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code'";	
		}
		else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$block_code = $this->loginData->block_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
		}
		$query .= " and user_mode= 1)";

		// print_r($query);die;

		return $this->db->query($query)->result()[0]->total;
	}

	/**
	 * Number of Women 15-49 years
	 */

	public function get_woman_age_15_49_years()
	{

		$query = "select
		COUNT(*) AS total
		FROM
		tblhhfamilymember a
		inner join tblhhsurvey b
		on a.HHSurveyGUID = b.HHSurveyGUID
		WHERE
		a.GenderID = 2 AND a.IsDeleted = 0 and b.IsDeleted = 0 AND a.MaritialStatusID = 1
		and
		(
			CASE
			WHEN a.DOBAvailable = 2 THEN a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear)
			WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(YEAR, a.DateOfBirth,CURRENT_DATE) END
		) >= 15 and
		(
			CASE
			WHEN a.DOBAvailable = 2 THEN a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear)
			WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(YEAR, a.DateOfBirth,CURRENT_DATE) END
		) <=49 ";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and a.CreatedOn > '" . $this->filter_data['date_from'] . "' and a.CreatedOn < '" . $this->filter_data['date_to'] . "'";
		}
		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and a.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and a.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= " and a.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
		if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
		{
			$state_code = $this->loginData->state_code;
			$query .= " and state_code = '$state_code'";	
		}
		else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code'";	
		}
		else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$block_code = $this->loginData->block_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
		}
		$query .= " and user_mode= 1 group by a.CreatedBy, b.VillageID)";

		return $this->db->query($query)->result()[0]->total;
	}



	/*Query for childern counts from tblhhfamilymember*/

	public function children_0_to_5_year($start_month, $end_month, $group_by_gender = 0)
	{
		$query = " SELECT
		COUNT(*) AS total, gender
		( SELECT
		count(*) as total, gender
		FROM
		tblhhfamilymember a
		INNER JOIN tblhhsurvey b ON
		a.HHSurveyGUID = b.HHSurveyGUID
		WHERE
		a.IsDeleted = 0 AND b.IsDeleted = 0  AND b.IsActive = 1
		and
		(
		CASE
		WHEN a.DOBAvailable = 2 THEN (a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear))*365
		WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(DAY, a.DateOfBirth,CURRENT_DATE) END
		) between $start_month and $end_month ";

		// if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		// {
		// 	$query .= " and a.CreatedOn > '" . $this->filter_data['date_from'] . "' and a.CreatedOn < '" . $this->filter_data['date_to'] . "'";
		// }
		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and a.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and a.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= " and a.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
		if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
		{
			$state_code = $this->loginData->state_code;
			$query .= " and state_code = '$state_code'";	
		}
		else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code'";	
		}
		else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$block_code = $this->loginData->block_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
		}
		$query .= " and user_mode= 1 group by a.CreatedBy, b.VillageID)";

		$query .= " ) a";

		if ($group_by_gender) {
			$query .= " group by a.gender order by a.gender asc";
			$query = "select * from (select * from mstcommon where Flag = 4 AND LanguageID = 1 and Id in(1,2) )d 
			left join (".$query.")a 
			ON a.gender = d.Id
			order by d.Id asc";
			die($query);

			return $this->db->query($query)->result();
		}

		$result =  $this->db->query($query)->result()[0];
		return $result;
}


	/**
	 * Get list of children in the specified month range
	 */

	public function get_children_age_months($start_month, $end_month, $group_by_gender = 0)
	{

		$query = "SELECT 
		COUNT(*) AS total, gender
		FROM
		(SELECT 
		TIMESTAMPDIFF(MONTH, child_dob, NOW()) AS ageInMonth, gender
		FROM
		tblchild c 
		inner join tblhhsurvey h 
		on c.HHGUID = h.HHSurveyGUID
		where c.created_by in (select user_id from tblusers where user_mode = 1 and is_deleted = 0) and c.IsDeleted=0  and h.IsDeleted=0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and c.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and c.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= " ) a
		WHERE
		a.ageInMonth $start_month AND a.ageInMonth $end_month";

		if ($group_by_gender) {
			$query .= " group by a.gender order by a.gender asc";
			$query = "select * from (select * from mstcommon where Flag = 4 AND LanguageID = 1 and Id in(1,2) )d 
			left join (".$query.")a 
			ON a.gender = d.Id
			order by d.Id asc";
			// die($query);

			return $this->db->query($query)->result();
		}
		return $this->db->query($query)->result()[0]->total;

	}

	
	/**
	 * Adults aged 35-50 years
	 */
	public function get_adults_aged_35_50_years()
	{

		$query = "select
		COUNT(*) AS total
		FROM
		tblhhfamilymember a
		inner join tblhhsurvey b
		on a.HHSurveyGUID = b.HHSurveyGUID
		WHERE
		a.IsDeleted = 0 and b.IsDeleted = 0
		and
		(
			CASE
			WHEN a.DOBAvailable = 2 THEN a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear)
			WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(YEAR, a.DateOfBirth,CURRENT_DATE) END
		) >= 35 and
		(
			CASE
			WHEN a.DOBAvailable = 2 THEN a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear)
			WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(YEAR, a.DateOfBirth,CURRENT_DATE) END
		) <=50 ";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and a.CreatedOn > '" . $this->filter_data['date_from'] . "' and a.CreatedOn < '" . $this->filter_data['date_to'] . "'";
		}
		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and a.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and a.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= " and a.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
		if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
		{
			$state_code = $this->loginData->state_code;
			$query .= " and state_code = '$state_code'";	
		}
		else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code'";	
		}
		else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$block_code = $this->loginData->block_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
		}
		$query .= " and user_mode= 1 group by a.CreatedBy, b.VillageID)";
		
		return $this->db->query($query)->result()[0]->total;
	}

	
	/**
	 * Adults age more than 60 years of age
	 */
	public function get_adults_aged_60_years_and_more()
	{

		$query = "select
		COUNT(*) AS total
		FROM
		tblhhfamilymember a
		inner join tblhhsurvey b
		on a.HHSurveyGUID = b.HHSurveyGUID
		WHERE
		a.IsDeleted = 0 and b.IsDeleted = 0
		and
		(
			CASE
			WHEN a.DOBAvailable = 2 THEN a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear)
			WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(YEAR, a.DateOfBirth,CURRENT_DATE) END
		) >= 60 ";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and a.CreatedOn > '" . $this->filter_data['date_from'] . "' and a.CreatedOn < '" . $this->filter_data['date_to'] . "'";
		}
		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and a.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and a.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= " and a.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
		if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
		{
			$state_code = $this->loginData->state_code;
			$query .= " and state_code = '$state_code'";	
		}
		else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code'";	
		}
		else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$block_code = $this->loginData->block_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
		}
		$query .= " and user_mode= 1 group by a.CreatedBy, b.VillageID)";
		
		return $this->db->query($query)->result()[0]->total;
	}

	/**
	 * Total pregnant women in the area
	 	 with condition that their age is 15 and 49 years inclusive
	 */

	 	 public function get_total_pregnant_women_in_area()
	 	 {

	 	 	$query = "select count(*) as total from tblpregnant_woman m 
	 	 	INNER JOIN tblhhfamilymember fm 
	 	 	on
	 	 	m.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
	 	 	inner join tblhhsurvey h 
	 	 	on fm.HHSurveyGUID = h.HHSurveyGUID
	 	 	where
	 	 	m.IsDeleted = 0 and fm.IsDeleted = 0 and fm.statusID = 1 and h.IsDeleted=0 and m.IsPregnant = 1
	 	 	AND TIMESTAMPDIFF(
	 	 		DAY,
	 	 		m.LMPDate,
	 	 		CURRENT_TIMESTAMP
	 	 	) > 0
	 	 	";
	 	 	if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
	 	 	{
	 	 		$query .= " and fm.CreatedOn > '" . $this->filter_data['date_from'] . "' and fm.CreatedOn < '" . $this->filter_data['date_to'] . "'";
	 	 	}

	 	 	if ($this->filter_data['ANM'] != NULL) 
	 	 	{
	 	 		$query .= " and fm.ANMID = " . $this->filter_data['ANM'];
	 	 	}

	 	 	if ($this->filter_data['Asha'] != NULL) 
	 	 	{
	 	 		$query .= " and fm.AshaID = " . $this->filter_data['Asha'];
	 	 	}

	 	 	$query .= " and fm.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
	 	 	if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
	 	 	{
	 	 		$state_code = $this->loginData->state_code;
	 	 		$query .= " and state_code = '$state_code'";	
	 	 	}
	 	 	else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
	 	 	{
	 	 		$state_code = $this->loginData->state_code;
	 	 		$district_code = $this->loginData->district_code;
	 	 		$query .= " and state_code = '$state_code' and district_code='$district_code'";	
	 	 	}
	 	 	else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
	 	 	{
	 	 		$state_code = $this->loginData->state_code;
	 	 		$district_code = $this->loginData->district_code;
	 	 		$block_code = $this->loginData->block_code;
	 	 		$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
	 	 	}
	 	 	$query .= " and user_mode= 1)";

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


		$query = "select count(pw.PWGUID) as total from tblpregnant_woman pw
		inner join tblhhfamilymember fm on pw.HHFamilyMemberGUID = fm.HHFamilyMemberGUID inner join tblhhsurvey h on fm.HHSurveyGUID = h.HHSurveyGUID where pw.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0 and  pw.Regwithin12weeks=1";
		
		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and pw.PWRegistrationDate > '" . $this->filter_data['date_from'] . "' and pw.PWRegistrationDate < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= "
		union all 
		SELECT count(pw.PWGUID) as total from tblpregnant_woman pw
		where 1=1  and pw.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and pw.PWRegistrationDate > '" . $this->filter_data['date_from'] . "' and pw.PWRegistrationDate < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
		if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
		{
			$state_code = $this->loginData->state_code;
			$query .= " and state_code = '$state_code'";	
		}
		else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code'";	
		}
		else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$block_code = $this->loginData->block_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
		}
		$query .= " and user_mode= 1)";

		return $this->get_proportion($query);

	}

	public function trend_pregnant_woman_registered_in_first_trimester()
	{


		$query = "SELECT  concat(MONTHNAME(pw.PWRegistrationDate), ' - ', YEAR(pw.PWRegistrationDate)) as label, YEAR(pw.PWRegistrationDate) as year, MONTH(pw.PWRegistrationDate) as month, count(pw.PWGUID) as total from tblpregnant_woman pw inner join tblhhfamilymember fm on pw.HHFamilyMemberGUID = fm.HHFamilyMemberGUID inner join tblhhsurvey h on fm.HHSurveyGUID = h.HHSurveyGUID
		where pw.Regwithin12weeks=1  and pw.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0";

		
		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and pw.PWRegistrationDate > '" . $this->filter_data['date_from'] . "' and pw.PWRegistrationDate < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= " group by MONTH(pw.PWRegistrationDate) order by year, month";

		$trend_result =  $this->db->query($query)->result();

		if ($this->filter_data['date_from'] == NULL || $this->filter_data['date_to'] == NULL) {
			$this->filter_data['date_from'] = date("Y-m-d", strtotime("-1 year", time()));
			$this->filter_data['date_to'] = date("Y-m-d");
		}

		$query = "call fillmonths(?, ?)";
		$month_result = $this->db->query($query, [$this->filter_data['date_from'], $this->filter_data['date_to']])->result();

		$month_result = json_decode(json_encode($month_result), TRUE);
		$trend_result = json_decode(json_encode($trend_result), TRUE);

		$final_array = $this->left_join_array($month_result, $trend_result, 'label');

		$query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
		if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
		{
			$state_code = $this->loginData->state_code;
			$query .= " and state_code = '$state_code'";	
		}
		else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code'";	
		}
		else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$block_code = $this->loginData->block_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
		}
		$query .= " and user_mode= 1)";

		return $final_array;

	}

	private function left_join_array($left, $right, $left_join_on, $right_join_on = NULL){
		$final= array();

		if(empty($right_join_on))
			$right_join_on = $left_join_on;

		foreach($left AS $k => $v){
			$final[$k] = $v;
			foreach($right AS $kk => $vv){
				if($v[$left_join_on] == $vv[$right_join_on]){
					foreach($vv AS $key => $val)
						$final[$k][$key] = $val; 
				} /*else {
					foreach($vv AS $key => $val)
						$final[$k][$key] = NULL;            
					}*/
				}
			}
			return $final;
		}

	/**
	 * Proportion of pregnant women with 1 ANC check-up
	 */

	public function get_proportion_of_pregnant_woman_with_one_anc_checkup()
	{


		$query = "select count(*) as total from (SELECT count(v.AncVisitID) as total FROM tblancvisit v
		inner join tblpregnant_woman pw
		on v.PWGUID = pw.PWGUID
		inner join tblhhfamilymember fm on pw.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		inner join tblhhsurvey h on fm.HHSurveyGUID = h.HHSurveyGUID
		where v.CheckupVisitDate is not null and fm.IsDeleted = 0 and h.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and v.CheckupVisitDate > '" . $this->filter_data['date_from'] . "' and v.CheckupVisitDate < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
		if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
		{
			$state_code = $this->loginData->state_code;
			$query .= " and state_code = '$state_code'";	
		}
		else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code'";	
		}
		else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$block_code = $this->loginData->block_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
		}
		$query .= " and user_mode=1)";

		$query .= "
		group by pw.PWGUID
		having count(*) = 1)a 
		UNION ALL
		SELECT count(pw.PWGUID) as total FROM tblpregnant_woman pw 
		where 1=1  and pw.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and pw.LMPDate > '" . $this->filter_data['date_from'] . "' and pw.LMPDate < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
		if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
		{
			$state_code = $this->loginData->state_code;
			$query .= " and state_code = '$state_code'";	
		}
		else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code'";	
		}
		else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$block_code = $this->loginData->block_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
		}
		$query .= " and user_mode= 1)";

		return $this->get_proportion($query);

	}

	public function trend_pregnant_woman_with_one_anc_checkup()
	{
		
		$query = "select concat(MONTHNAME(CheckupVisitDate), ' - ', YEAR(CheckupVisitDate)) as label, YEAR(CheckupVisitDate) as year, MONTH(CheckupVisitDate) as month, count(*) as total from (
			select v.CheckupVisitDate FROM tblancvisit v
			inner join tblpregnant_woman pw
			on v.PWGUID = pw.PWGUID
			inner join tblhhfamilymember fm on pw.HHFamilyMemberGUID = fm.HHFamilyMemberGUID 
			inner join tblhhsurvey h on fm.HHSurveyGUID = h.HHSurveyGUID
			where v.CheckupVisitDate is not null and pw.IsDeleted = 0  and fm.IsDeleted = 0 and h.IsDeleted = 0";

			if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
			{
				$query .= " and v.CheckupVisitDate > '" . $this->filter_data['date_from'] . "' and v.CheckupVisitDate < '" . $this->filter_data['date_to'] . "'";
			}

			if ($this->filter_data['ANM'] != NULL) 
			{
				$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
			}

			if ($this->filter_data['Asha'] != NULL) 
			{
				$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
			}

			$query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
			if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
			{
				$state_code = $this->loginData->state_code;
				$query .= " and state_code = '$state_code'";	
			}
			else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
			{
				$state_code = $this->loginData->state_code;
				$district_code = $this->loginData->district_code;
				$query .= " and state_code = '$state_code' and district_code='$district_code'";	
			}
			else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
			{
				$state_code = $this->loginData->state_code;
				$district_code = $this->loginData->district_code;
				$block_code = $this->loginData->block_code;
				$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
			}
			$query .= " and user_mode= 1)";

			$query .= " group by pw.PWGUID
			having count(*)=1)a 
			group by month(CheckupVisitDate)";

			$trend_result =  $this->db->query($query)->result();

			if ($this->filter_data['date_from'] == NULL || $this->filter_data['date_to'] == NULL) {
				$this->filter_data['date_from'] = date("Y-m-d", strtotime("-1 year", time()));
				$this->filter_data['date_to'] = date("Y-m-d");
			}

			$query = "call fillmonths(?, ?)";
			$month_result = $this->db->query($query, [$this->filter_data['date_from'], $this->filter_data['date_to']])->result();

			$month_result = json_decode(json_encode($month_result), TRUE);
			$trend_result = json_decode(json_encode($trend_result), TRUE);

			$final_array = $this->left_join_array($month_result, $trend_result, 'label');

			return $final_array;

		}

	/**
	 * Proportion of pregnant women with 2 ANC check-up
	 */

	public function get_proportion_of_pregnant_woman_with_two_anc_checkup()
	{

		$query = "select count(*) as total from (SELECT count(v.AncVisitID) as total FROM tblancvisit v
		inner join tblpregnant_woman pw
		on v.PWGUID = pw.PWGUID 
		inner join tblhhfamilymember fm on pw.HHFamilyMemberGUID = fm.HHFamilyMemberGUID 
		inner join tblhhsurvey h on fm.HHSurveyGUID = h.HHSurveyGUID
		where v.CheckupVisitDate is not null  and pw.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0 ";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and v.CheckupVisitDate > '" . $this->filter_data['date_from'] . "' and v.CheckupVisitDate < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
		if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
		{
			$state_code = $this->loginData->state_code;
			$query .= " and state_code = '$state_code'";	
		}
		else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code'";	
		}
		else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$block_code = $this->loginData->block_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
		}
		$query .= " and user_mode=1)";

		$query .= "
		group by pw.PWGUID
		having count(*) = 2)a 
		UNION ALL
		SELECT count(pw.PWGUID) as total FROM tblpregnant_woman pw 
		where 1=1 and pw.IsDeleted = 0  ";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and pw.LMPDate > '" . $this->filter_data['date_from'] . "' and pw.LMPDate < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
		if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
		{
			$state_code = $this->loginData->state_code;
			$query .= " and state_code = '$state_code'";	
		}
		else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code'";	
		}
		else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$block_code = $this->loginData->block_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
		}
		$query .= " and user_mode= 1)";
		
		return $this->get_proportion($query);

	}

	public function trend_pregnant_woman_with_two_anc_checkup()
	{

		$query = "select concat(MONTHNAME(CheckupVisitDate), ' - ', YEAR(CheckupVisitDate)) as label, YEAR(CheckupVisitDate) as year, MONTH(CheckupVisitDate) as month, count(*) as total from (
			select v.CheckupVisitDate FROM tblancvisit v
			inner join tblpregnant_woman pw
			on v.PWGUID = pw.PWGUID 
			inner join tblhhfamilymember fm on pw.HHFamilyMemberGUID = fm.HHFamilyMemberGUID 
			inner join tblhhsurvey h on fm.HHSurveyGUID = h.HHSurveyGUID
			where v.CheckupVisitDate is not null and pw.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0";

			if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
			{
				$query .= " and v.CheckupVisitDate > '" . $this->filter_data['date_from'] . "' and v.CheckupVisitDate < '" . $this->filter_data['date_to'] . "'";
			}

			if ($this->filter_data['ANM'] != NULL) 
			{
				$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
			}

			if ($this->filter_data['Asha'] != NULL) 
			{
				$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
			}

			$query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
			if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
			{
				$state_code = $this->loginData->state_code;
				$query .= " and state_code = '$state_code'";	
			}
			else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
			{
				$state_code = $this->loginData->state_code;
				$district_code = $this->loginData->district_code;
				$query .= " and state_code = '$state_code' and district_code='$district_code'";	
			}
			else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
			{
				$state_code = $this->loginData->state_code;
				$district_code = $this->loginData->district_code;
				$block_code = $this->loginData->block_code;
				$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
			}
			$query .= " and user_mode= 1)";

			$query .= " group by pw.PWGUID
			having count(*)=2)a 
			group by month(CheckupVisitDate)";

			$trend_result =  $this->db->query($query)->result();

			if ($this->filter_data['date_from'] == NULL || $this->filter_data['date_to'] == NULL) {
				$this->filter_data['date_from'] = date("Y-m-d", strtotime("-1 year", time()));
				$this->filter_data['date_to'] = date("Y-m-d");
			}

			$query = "call fillmonths(?, ?)";
			$month_result = $this->db->query($query, [$this->filter_data['date_from'], $this->filter_data['date_to']])->result();

			$month_result = json_decode(json_encode($month_result), TRUE);
			$trend_result = json_decode(json_encode($trend_result), TRUE);

			$final_array = $this->left_join_array($month_result, $trend_result, 'label');

			return $final_array;

		}

	/**
	 * Proportion of pregnant women with 3 ANC check-up
	 */

	public function get_proportion_of_pregnant_woman_with_three_anc_checkup()
	{

		$query = "select count(*) as total from (SELECT count(v.AncVisitID) as total FROM tblancvisit v
		inner join tblpregnant_woman pw
		on v.PWGUID = pw.PWGUID 
		inner join tblhhfamilymember fm on pw.HHFamilyMemberGUID = fm.HHFamilyMemberGUID 
		inner join tblhhsurvey h on fm.HHSurveyGUID = h.HHSurveyGUID
		where v.CheckupVisitDate is not null and pw.IsDeleted = 0 and h.IsDeleted = 0 and fm.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and v.CheckupVisitDate > '" . $this->filter_data['date_from'] . "' and v.CheckupVisitDate < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
		if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
		{
			$state_code = $this->loginData->state_code;
			$query .= " and state_code = '$state_code'";	
		}
		else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code'";	
		}
		else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$block_code = $this->loginData->block_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
		}
		$query .= " and user_mode=1)";

		$query .= "
		group by pw.PWGUID
		having count(*) = 3)a 
		UNION ALL
		SELECT count(pw.PWGUID) as total FROM tblpregnant_woman pw 
		where 1=1 and pw.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and pw.LMPDate > '" . $this->filter_data['date_from'] . "' and pw.LMPDate < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
		if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
		{
			$state_code = $this->loginData->state_code;
			$query .= " and state_code = '$state_code'";	
		}
		else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code'";	
		}
		else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$block_code = $this->loginData->block_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
		}
		$query .= " and user_mode= 1)";
		
		return $this->get_proportion($query);

	}

	public function trend_pregnant_woman_with_three_anc_checkup()
	{

		$query = "select concat(MONTHNAME(CheckupVisitDate), ' - ', YEAR(CheckupVisitDate)) as label, YEAR(CheckupVisitDate) as year, MONTH(CheckupVisitDate) as month, count(*) as total from (
			select v.CheckupVisitDate FROM tblancvisit v
			inner join tblpregnant_woman pw
			on v.PWGUID = pw.PWGUID 
			inner join tblhhfamilymember fm on pw.HHFamilyMemberGUID = fm.HHFamilyMemberGUID 
			inner join tblhhsurvey h on fm.HHSurveyGUID = h.HHSurveyGUID
			where v.CheckupVisitDate is not null and pw.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0";

			if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
			{
				$query .= " and v.CheckupVisitDate > '" . $this->filter_data['date_from'] . "' and v.CheckupVisitDate < '" . $this->filter_data['date_to'] . "'";
			}

			if ($this->filter_data['ANM'] != NULL) 
			{
				$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
			}

			if ($this->filter_data['Asha'] != NULL) 
			{
				$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
			}

			$query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
			if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
			{
				$state_code = $this->loginData->state_code;
				$query .= " and state_code = '$state_code'";	
			}
			else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
			{
				$state_code = $this->loginData->state_code;
				$district_code = $this->loginData->district_code;
				$query .= " and state_code = '$state_code' and district_code='$district_code'";	
			}
			else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
			{
				$state_code = $this->loginData->state_code;
				$district_code = $this->loginData->district_code;
				$block_code = $this->loginData->block_code;
				$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
			}
			$query .= " and user_mode= 1)";

			$query .= " group by pw.PWGUID
			having count(*)=3)a 
			group by month(CheckupVisitDate)";

			$trend_result =  $this->db->query($query)->result();

			if ($this->filter_data['date_from'] == NULL || $this->filter_data['date_to'] == NULL) {
				$this->filter_data['date_from'] = date("Y-m-d", strtotime("-1 year", time()));
				$this->filter_data['date_to'] = date("Y-m-d");
			}

			$query = "call fillmonths(?, ?)";
			$month_result = $this->db->query($query, [$this->filter_data['date_from'], $this->filter_data['date_to']])->result();

			$month_result = json_decode(json_encode($month_result), TRUE);
			$trend_result = json_decode(json_encode($trend_result), TRUE);

			$final_array = $this->left_join_array($month_result, $trend_result, 'label');

			return $final_array;

		}

	/**
	 * Proportion of pregnant women with 4 ANC check-up
	 */

	public function get_proportion_of_pregnant_woman_with_four_anc_checkup()
	{

		$query = "select count(*) as total from (SELECT count(v.AncVisitID) as total FROM tblancvisit v
		inner join tblpregnant_woman pw
		on v.PWGUID = pw.PWGUID 
		inner join tblhhfamilymember fm on pw.HHFamilyMemberGUID = fm.HHFamilyMemberGUID 
		inner join tblhhsurvey h on fm.HHSurveyGUID = h.HHSurveyGUID
		where v.CheckupVisitDate is not null and pw.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0 ";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and v.CheckupVisitDate > '" . $this->filter_data['date_from'] . "' and v.CheckupVisitDate < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
		if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
		{
			$state_code = $this->loginData->state_code;
			$query .= " and state_code = '$state_code'";	
		}
		else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code'";	
		}
		else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$block_code = $this->loginData->block_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
		}
		$query .= " and user_mode=1)";

		$query .= "
		group by pw.PWGUID
		having count(*) = 4)a 
		UNION ALL
		SELECT count(pw.PWGUID) as total FROM tblpregnant_woman pw 
		where 1=1  and pw.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and pw.LMPDate > '" . $this->filter_data['date_from'] . "' and pw.LMPDate < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
		if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
		{
			$state_code = $this->loginData->state_code;
			$query .= " and state_code = '$state_code'";	
		}
		else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code'";	
		}
		else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$block_code = $this->loginData->block_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
		}
		$query .= " and user_mode= 1)";
		
		return $this->get_proportion($query);

	}

	public function trend_pregnant_woman_with_four_anc_checkup()
	{

		$query = "select concat(MONTHNAME(CheckupVisitDate), ' - ', YEAR(CheckupVisitDate)) as label, YEAR(CheckupVisitDate) as year, MONTH(CheckupVisitDate) as month, count(*) as total from (
			select v.CheckupVisitDate FROM tblancvisit v
			inner join tblpregnant_woman pw
			on v.PWGUID = pw.PWGUID 
			inner join tblhhfamilymember fm on pw.HHFamilyMemberGUID = fm.HHFamilyMemberGUID 
			inner join tblhhsurvey h on fm.HHSurveyGUID = h.HHSurveyGUID
			where v.CheckupVisitDate is not null and pw.IsDeleted = 0 and h.IsDeleted = 0 and fm.IsDeleted = 0 ";

			if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
			{
				$query .= " and v.CheckupVisitDate > '" . $this->filter_data['date_from'] . "' and v.CheckupVisitDate < '" . $this->filter_data['date_to'] . "'";
			}

			if ($this->filter_data['ANM'] != NULL) 
			{
				$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
			}

			if ($this->filter_data['Asha'] != NULL) 
			{
				$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
			}

			$query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
			if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
			{
				$state_code = $this->loginData->state_code;
				$query .= " and state_code = '$state_code'";	
			}
			else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
			{
				$state_code = $this->loginData->state_code;
				$district_code = $this->loginData->district_code;
				$query .= " and state_code = '$state_code' and district_code='$district_code'";	
			}
			else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
			{
				$state_code = $this->loginData->state_code;
				$district_code = $this->loginData->district_code;
				$block_code = $this->loginData->block_code;
				$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
			}
			$query .= " and user_mode= 1)";

			$query .= " group by pw.PWGUID
			having count(*)=4)a 
			group by month(CheckupVisitDate)";

		// echo $query; die();

			$trend_result =  $this->db->query($query)->result();

			if ($this->filter_data['date_from'] == NULL || $this->filter_data['date_to'] == NULL) {
				$this->filter_data['date_from'] = date("Y-m-d", strtotime("-1 year", time()));
				$this->filter_data['date_to'] = date("Y-m-d");
			}

			$query = "call fillmonths(?, ?)";
			$month_result = $this->db->query($query, [$this->filter_data['date_from'], $this->filter_data['date_to']])->result();

			$month_result = json_decode(json_encode($month_result), TRUE);
			$trend_result = json_decode(json_encode($trend_result), TRUE);

			$final_array = $this->left_join_array($month_result, $trend_result, 'label');

			return $final_array;

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
		inner join tblhhfamilymember fm on pw.HHFamilyMemberGUID = fm.HHFamilyMemberGUID 
		inner join tblhhsurvey h on fm.HHSurveyGUID = h.HHSurveyGUID
		where v.TT2=1 or v.TTbooster=1  and pw.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and pw.LMPDate > '" . $this->filter_data['date_from'] . "' and pw.LMPDate < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
		if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
		{
			$state_code = $this->loginData->state_code;
			$query .= " and state_code = '$state_code'";	
		}
		else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code'";	
		}
		else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$block_code = $this->loginData->block_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
		}
		$query .= " and user_mode = 1)";

		$query .= " group by v.PWGUID having count(*) > 0
	)a
	UNION ALL
	SELECT count(pw.PWGUID) as total FROM `tblpregnant_woman` pw 
	where 1=1  and pw.IsDeleted = 0";

	if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
	{
		$query .= " and pw.LMPDate > '" . $this->filter_data['date_from'] . "' and pw.LMPDate < '" . $this->filter_data['date_to'] . "'";
	}

	if ($this->filter_data['ANM'] != NULL) 
	{
		$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
	}

	if ($this->filter_data['Asha'] != NULL) 
	{
		$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
	}

	$query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
	if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
	{
		$state_code = $this->loginData->state_code;
		$query .= " and state_code = '$state_code'";	
	}
	else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
	{
		$state_code = $this->loginData->state_code;
		$district_code = $this->loginData->district_code;
		$query .= " and state_code = '$state_code' and district_code='$district_code'";	
	}
	else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
	{
		$state_code = $this->loginData->state_code;
		$district_code = $this->loginData->district_code;
		$block_code = $this->loginData->block_code;
		$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
	}
	$query .= " and user_mode= 1)";

	return $this->get_proportion($query);

}

public function trend_pregnant_woman_received_tt2_or_booster()
{

	$query = "SELECT
	CONCAT(MONTHNAME(a.LMPDate), ' - ', YEAR(a.LMPDate)) AS label,
	YEAR(a.LMPDate) AS YEAR,
	MONTH(a.LMPDate) AS MONTH,
	COUNT(a.PWGUID) AS total
	FROM
	(
	SELECT pw.PWGUID, pw.LMPDate FROM tblancvisit v
	inner join tblpregnant_woman pw
	on v.PWGUID = pw.PWGUID
	inner join tblhhfamilymember fm on pw.HHFamilyMemberGUID = fm.HHFamilyMemberGUID 
	inner join tblhhsurvey h on fm.HHSurveyGUID = h.HHSurveyGUID
	where v.TT2=1 or v.TTbooster=1 and pw.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0";

	if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
	{
		$query .= " and pw.LMPDate > '" . $this->filter_data['date_from'] . "' and pw.LMPDate < '" . $this->filter_data['date_to'] . "'";
	}

	if ($this->filter_data['ANM'] != NULL) 
	{
		$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
	}

	if ($this->filter_data['Asha'] != NULL) 
	{
		$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
	}

	$query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
	if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
	{
		$state_code = $this->loginData->state_code;
		$query .= " and state_code = '$state_code'";	
	}
	else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
	{
		$state_code = $this->loginData->state_code;
		$district_code = $this->loginData->district_code;
		$query .= " and state_code = '$state_code' and district_code='$district_code'";	
	}
	else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
	{
		$state_code = $this->loginData->state_code;
		$district_code = $this->loginData->district_code;
		$block_code = $this->loginData->block_code;
		$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
	}
	$query .= " and user_mode= 1)";

	$query .= " group by v.PWGUID having count(*) > 0
)a";

$query .= " group by MONTH(a.LMPDate) order by year, month";

		// echo $query; die();
$trend_result =  $this->db->query($query)->result();

if ($this->filter_data['date_from'] == NULL || $this->filter_data['date_to'] == NULL) {
	$this->filter_data['date_from'] = date("Y-m-d", strtotime("-1 year", time()));
	$this->filter_data['date_to'] = date("Y-m-d");
}

$query = "call fillmonths(?, ?)";
$month_result = $this->db->query($query, [$this->filter_data['date_from'], $this->filter_data['date_to']])->result();

$month_result = json_decode(json_encode($month_result), TRUE);
$trend_result = json_decode(json_encode($trend_result), TRUE);

$final_array = $this->left_join_array($month_result, $trend_result, 'label');

return $final_array;

}


	/**
	 * Proportion of institutional deliveries
	 */

	public function get_proportion_of_institutional_deliveries()
	{

		$query = "SELECT COUNT(pw.PWGUID) AS total
		FROM
		tblpregnant_woman pw
		inner join tblhhfamilymember fm on pw.HHFamilyMemberGUID = fm.HHFamilyMemberGUID 
		inner join tblhhsurvey h on fm.HHSurveyGUID = h.HHSurveyGUID
		INNER JOIN
		tblchild c ON pw.PWGUID = c.pw_GUID
		WHERE c.place_of_birth = 2  and pw.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0 and c.IsDeleted= 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
		if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
		{
			$state_code = $this->loginData->state_code;
			$query .= " and state_code = '$state_code'";	
		}
		else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code'";	
		}
		else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$block_code = $this->loginData->block_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
		}
		$query .= " and user_mode= 1)";

		$query .= "
		UNION ALL
		SELECT COUNT(pw.PWGUID) AS total
		FROM
		`tblpregnant_woman` pw
		inner join tblhhfamilymember fm on pw.HHFamilyMemberGUID = fm.HHFamilyMemberGUID 
		inner join tblhhsurvey h on fm.HHSurveyGUID = h.HHSurveyGUID
		INNER JOIN
		tblchild c ON pw.PWGUID = c.pw_GUID 
		where 1=1  and pw.IsDeleted = 0 and c.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL)
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}
		
		$query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
		if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
		{
			$state_code = $this->loginData->state_code;
			$query .= " and state_code = '$state_code'";	
		}
		else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code'";	
		}
		else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$block_code = $this->loginData->block_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
		}
		$query .= " and user_mode= 1)";

		return $this->get_proportion($query);

	}

	public function trend_institutional_deliveries()
	{

		// $query = "SELECT concat(MONTHNAME(a.LMPDate), ' - ', YEAR(a.LMPDate)) as label, YEAR(a.LMPDate) as year, MONTH(a.LMPDate) as month, count(a.PWGUID) as total from 
		// (
		// SELECT pw.PWGUID, pw.LMPDate
		// FROM
		// tblpregnant_woman pw
		// INNER JOIN
		// tblchild c ON pw.PWGUID = c.pw_GUID
		// WHERE c.place_of_birth = 2 ";

		// if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		// {
		// 	$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		// }

		// if ($this->filter_data['ANM'] != NULL) 
		// {
		// 	$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		// }

		// if ($this->filter_data['Asha'] != NULL) 
		// {
		// 	$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		// }

		// $query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
		// if ($this->loginData->user_role == 6 ) 
		// {
		// 	$state_code = $this->loginData->state_code;
		// 	$query .= " and state_code = '$state_code'";	
		// }
		// $query .= " and user_mode= 1)";

		// $query .= ")a group by MONTH(a.LMPDate) order by year, month";

		$query = "SELECT
		CONCAT(
		MONTHNAME(a.child_dob),
		' - ',
		YEAR(a.child_dob)
		) AS label,
		YEAR(a.child_dob) AS YEAR,
		MONTH(a.child_dob) AS MONTH,
		COUNT(a.ChildGUID) AS total
		FROM
		(
		SELECT
		COUNT(*),
		c.child_dob,
		c.ChildGUID
		FROM
		`tblpnchomevisit_ans` p
		INNER JOIN tblchild c ON
		p.ChildGUID = c.ChildGUID
		INNER JOIN tblhhfamilymember fm ON
		c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		fm.HHSurveyGUID = h.HHSurveyGUID
		WHERE
		p.Q_0 BETWEEN c.child_dob AND DATE_ADD(c.child_dob, INTERVAL 7 DAY) AND c.IsDeleted = 0 AND fm.IsDeleted = 0 AND h.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and p.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and p.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= " and p.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
		if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
		{
			$state_code = $this->loginData->state_code;
			$query .= " and state_code = '$state_code'";	
		}
		else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code'";	
		}
		else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$block_code = $this->loginData->block_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
		}
		$query .= " and user_mode= 1)";

		$query .= ")a group by MONTH(a.child_dob) order by year, month";

		// echo $query; die();
		$trend_result =  $this->db->query($query)->result();

		if ($this->filter_data['date_from'] == NULL || $this->filter_data['date_to'] == NULL) {
			$this->filter_data['date_from'] = date("Y-m-d", strtotime("-1 year", time()));
			$this->filter_data['date_to'] = date("Y-m-d");
		}

		$query = "call fillmonths(?, ?)";
		$month_result = $this->db->query($query, [$this->filter_data['date_from'], $this->filter_data['date_to']])->result();

		$month_result = json_decode(json_encode($month_result), TRUE);
		$trend_result = json_decode(json_encode($trend_result), TRUE);

		$final_array = $this->left_join_array($month_result, $trend_result, 'label');

		return $final_array;

	}

	/**
	 * Newborns visited by ASHA at least three  or more times within first seven days of home delivery
	 */

	public function get_newborns_visited_three_more_seven_days_home_delivery()
	{

		$query = "SELECT
		COUNT(*) AS total
		FROM
		(
		SELECT
		v.AncVisitID
		FROM
		tblancvisit v
		INNER JOIN tblpregnant_woman pw ON
		v.PWGUID = pw.PWGUID
		INNER JOIN tblhhfamilymember fm ON
		pw.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		fm.HHSurveyGUID = h.HHSurveyGUID
		INNER JOIN tblchild c ON
		c.pw_GUID = pw.PWGUID
		WHERE
		v.CheckupVisitDate BETWEEN c.child_dob AND DATE_ADD(c.child_dob, INTERVAL 7 DAY) AND pw.IsDeleted = 0 AND c.IsDeleted = 0 AND fm.IsDeleted = 0 AND h.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= " group by v.PWGUID having count(*) > 2
	)a
	UNION ALL
	SELECT count(pw.PWGUID) as total 
	FROM `tblpregnant_woman` pw
	inner join tblhhfamilymember fm on pw.HHFamilyMemberGUID = fm.HHFamilyMemberGUID 
	inner join tblhhsurvey h on fm.HHSurveyGUID = h.HHSurveyGUID
	inner join tblchild c 
	on c.pw_GUID = pw.PWGUID
	where 1=1 and pw.IsDeleted = 0 and c.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0 ";

	if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
	{
		$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
	}

	if ($this->filter_data['ANM'] != NULL) 
	{
		$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
	}

	if ($this->filter_data['Asha'] != NULL) 
	{
		$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
	}

	$query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
	if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
	{
		$state_code = $this->loginData->state_code;
		$query .= " and state_code = '$state_code'";	
	}
	else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
	{
		$state_code = $this->loginData->state_code;
		$district_code = $this->loginData->district_code;
		$query .= " and state_code = '$state_code' and district_code='$district_code'";	
	}
	else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
	{
		$state_code = $this->loginData->state_code;
		$district_code = $this->loginData->district_code;
		$block_code = $this->loginData->block_code;
		$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
	}
	$query .= " and user_mode= 1)";

	return $this->get_proportion($query);

}

public function trend_newborns_visited_three_more_seven_days_home_delivery()
{

	$query = "SELECT
	CONCAT(
	MONTHNAME(a.LMPDate),
	' - ',
	YEAR(a.LMPDate)
	) AS label,
	YEAR(a.LMPDate) AS YEAR,
	MONTH(a.LMPDate) AS MONTH,
	COUNT(a.PWGUID) AS total
	FROM
	(
	SELECT
	pw.LMPDate,
	pw.PWGUID
	FROM
	tblancvisit v
	INNER JOIN tblpregnant_woman pw ON
	v.PWGUID = pw.PWGUID
	INNER JOIN tblhhfamilymember fm ON
	pw.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
	INNER JOIN tblhhsurvey h ON
	fm.HHSurveyGUID = h.HHSurveyGUID
	INNER JOIN tblchild c ON
	c.pw_GUID = pw.PWGUID
	WHERE
	v.CheckupVisitDate BETWEEN c.child_dob AND DATE_ADD(c.child_dob, INTERVAL 7 DAY) AND pw.IsDeleted = 0 AND c.IsDeleted = 0 AND fm.IsDeleted = 0 AND h.IsDeleted = 0";

	if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
	{
		$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
	}

	if ($this->filter_data['ANM'] != NULL) 
	{
		$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
	}

	if ($this->filter_data['Asha'] != NULL) 
	{
		$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
	}

	$query .= " group by v.PWGUID having count(*) > 2
)a";

$query .= " group by MONTH(a.LMPDate) order by year, month";
$trend_result =  $this->db->query($query)->result();

if ($this->filter_data['date_from'] == NULL || $this->filter_data['date_to'] == NULL) {
	$this->filter_data['date_from'] = date("Y-m-d", strtotime("-1 year", time()));
	$this->filter_data['date_to'] = date("Y-m-d");
}

$query = "call fillmonths(?, ?)";
$month_result = $this->db->query($query, [$this->filter_data['date_from'], $this->filter_data['date_to']])->result();

$month_result = json_decode(json_encode($month_result), TRUE);
$trend_result = json_decode(json_encode($trend_result), TRUE);

$final_array = $this->left_join_array($month_result, $trend_result, 'label');

$query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
{
	$state_code = $this->loginData->state_code;
	$query .= " and state_code = '$state_code'";	
}
else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
{
	$state_code = $this->loginData->state_code;
	$district_code = $this->loginData->district_code;
	$query .= " and state_code = '$state_code' and district_code='$district_code'";	
}
else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
{
	$state_code = $this->loginData->state_code;
	$district_code = $this->loginData->district_code;
	$block_code = $this->loginData->block_code;
	$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
}
$query .= " and user_mode= 1)";

return $final_array;

}

	/**
	 * Newborns visited by ASHA at least two  or more times within first seven days of institutional delivery
	 */

	public function get_newborns_visited_two_more_seven_days_institutional_delivery()
	{

		$query = "SELECT
		COUNT(*) AS total
		FROM
		(
		SELECT
		c.ChildGUID
		FROM
		tblpnchomevisit_ans p
		INNER JOIN tblchild c ON
		p.ChildGUID = c.ChildGUID
		INNER JOIN tblhhfamilymember fm ON
		c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		fm.HHSurveyGUID = h.HHSurveyGUID
		WHERE
		p.Q_0 BETWEEN c.child_dob AND DATE_ADD(c.child_dob, INTERVAL 7 DAY) AND c.IsDeleted = 0 AND fm.IsDeleted = 0 AND h.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and p.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and p.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= " group by c.ChildGUID having count(*) > 1
	)a
	UNION ALL
	SELECT count(pw.PWGUID) as total 
	FROM `tblpregnant_woman` pw
	inner join tblchild c 
	on c.pw_GUID = pw.PWGUID
	inner join tblhhfamilymember fm on c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID 
	inner join tblhhsurvey h on fm.HHSurveyGUID = h.HHSurveyGUID
	where 1=1 and pw.IsDeleted = 0 and c.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0 ";

	if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
	{
		$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
	}

	if ($this->filter_data['ANM'] != NULL) 
	{
		$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
	}

	if ($this->filter_data['Asha'] != NULL) 
	{
		$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
	}

	$query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
	if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
	{
		$state_code = $this->loginData->state_code;
		$query .= " and state_code = '$state_code'";	
	}
	else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
	{
		$state_code = $this->loginData->state_code;
		$district_code = $this->loginData->district_code;
		$query .= " and state_code = '$state_code' and district_code='$district_code'";	
	}
	else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
	{
		$state_code = $this->loginData->state_code;
		$district_code = $this->loginData->district_code;
		$block_code = $this->loginData->block_code;
		$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
	}
	$query .= " and user_mode= 1)";

	return $this->get_proportion($query);

}

public function trend_newborns_visited_two_more_seven_days_institutional_delivery()
{

		// $query = "SELECT concat(MONTHNAME(a.LMPDate), ' - ', YEAR(a.LMPDate)) as label, YEAR(a.LMPDate) as year, MONTH(a.LMPDate) as month, count(a.PWGUID) as total from 
		// (
		// SELECT pw.LMPDate, pw.PWGUID FROM tblancvisit v
		// inner join tblpregnant_woman pw
		// on v.PWGUID = pw.PWGUID
		// inner join tblchild c 
		// on c.pw_GUID = pw.PWGUID
		// where v.CheckupVisitDate BETWEEN c.child_dob and DATE_ADD(c.child_dob, INTERVAL 7 day) ";

		// if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		// {
		// 	$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		// }

		// if ($this->filter_data['ANM'] != NULL) 
		// {
		// 	$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		// }

		// if ($this->filter_data['Asha'] != NULL) 
		// {
		// 	$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		// }

		// $query .= " group by v.PWGUID having count(*) > 1
		// )a";

		// $query .= " group by MONTH(a.LMPDate) order by year, month";

		// edited by faris
	$query = "SELECT
	CONCAT(
	MONTHNAME(a.child_dob),
	' - ',
	YEAR(a.child_dob)
	) AS label,
	YEAR(a.child_dob) AS YEAR,
	MONTH(a.child_dob) AS MONTH,
	COUNT(a.ChildGUID) AS total
	FROM
	(
	SELECT
	COUNT(*),
	c.child_dob,
	c.ChildGUID
	FROM
	`tblpnchomevisit_ans` p
	INNER JOIN tblchild c ON
	p.ChildGUID = c.ChildGUID
	INNER JOIN tblhhfamilymember fm ON
	c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
	INNER JOIN tblhhsurvey h ON
	fm.HHSurveyGUID = h.HHSurveyGUID
	WHERE
	p.Q_0 BETWEEN c.child_dob AND DATE_ADD(c.child_dob, INTERVAL 7 DAY) AND c.IsDeleted = 0 AND fm.IsDeleted = 0 AND h.IsDeleted = 0";

	if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
	{
		$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
	}

	if ($this->filter_data['ANM'] != NULL) 
	{
		$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
	}

	if ($this->filter_data['Asha'] != NULL) 
	{
		$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
	}

	$query .= "GROUP BY p.ChildGUID having count(*) > 1) a ";

	$query .= " GROUP BY MONTH(a.child_dob) ORDER BY YEAR, MONTH ";

		// echo $query; die();
	$trend_result =  $this->db->query($query)->result();

	if ($this->filter_data['date_from'] == NULL || $this->filter_data['date_to'] == NULL) {
		$this->filter_data['date_from'] = date("Y-m-d", strtotime("-1 year", time()));
		$this->filter_data['date_to'] = date("Y-m-d");
	}

	$query = "call fillmonths(?, ?)";
	$month_result = $this->db->query($query, [$this->filter_data['date_from'], $this->filter_data['date_to']])->result();

	$month_result = json_decode(json_encode($month_result), TRUE);
	$trend_result = json_decode(json_encode($trend_result), TRUE);

	$final_array = $this->left_join_array($month_result, $trend_result, 'label');

	$query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
	if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
	{
		$state_code = $this->loginData->state_code;
		$query .= " and state_code = '$state_code'";	
	}
	else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
	{
		$state_code = $this->loginData->state_code;
		$district_code = $this->loginData->district_code;
		$query .= " and state_code = '$state_code' and district_code='$district_code'";	
	}
	else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
	{
		$state_code = $this->loginData->state_code;
		$district_code = $this->loginData->district_code;
		$block_code = $this->loginData->block_code;
		$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
	}
	$query .= " and user_mode= 1)";

	return $final_array;

}

	/**
	 * Low Birth Weight
	 */

	public function get_low_birth_weight()
	{

		$query = "SELECT
		COUNT(pw.PWGUID) AS total
		FROM
		tblchild c
		INNER JOIN tblpregnant_woman pw ON
		c.pw_GUID = pw.PWGUID
		INNER JOIN tblhhfamilymember fm ON
		c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		fm.HHSurveyGUID = h.HHSurveyGUID
		WHERE
		c.Wt_of_child < 2.5 AND pw.IsDeleted = 0 AND c.IsDeleted = 0 AND fm.IsDeleted = 0 AND h.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= "	UNION ALL
		SELECT count(pw.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman pw
		on c.pw_GUID = pw.PWGUID
		inner join tblhhfamilymember fm on c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID 
		inner join tblhhsurvey h on fm.HHSurveyGUID = h.HHSurveyGUID
		where 1=1 and pw.IsDeleted = 0 and c.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
		if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
		{
			$state_code = $this->loginData->state_code;
			$query .= " and state_code = '$state_code'";	
		}
		else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code'";	
		}
		else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$block_code = $this->loginData->block_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
		}
		$query .= " and user_mode= 1)";

		return $this->get_proportion($query);

	}

	public function trend_low_birth_weight()
	{

		$query = "SELECT
		CONCAT(
		MONTHNAME(c.child_dob),
		' - ',
		YEAR(c.child_dob)
		) AS label,
		YEAR(c.child_dob) AS YEAR,
		MONTH(c.child_dob) AS MONTH,
		COUNT(c.childGUID) AS total
		FROM
		tblchild c
		INNER JOIN tblpregnant_woman pw ON
		c.pw_GUID = pw.PWGUID
		INNER JOIN tblhhfamilymember fm ON
		c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		fm.HHSurveyGUID = h.HHSurveyGUID
		WHERE
		c.Wt_of_child < 2.5 AND pw.IsDeleted = 0 AND c.IsDeleted = 0 AND fm.IsDeleted = 0 AND h.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= " group by MONTH(c.child_dob) order by year, month";
		$trend_result =  $this->db->query($query)->result();

		if ($this->filter_data['date_from'] == NULL || $this->filter_data['date_to'] == NULL) {
			$this->filter_data['date_from'] = date("Y-m-d", strtotime("-1 year", time()));
			$this->filter_data['date_to'] = date("Y-m-d");
		}

		$query = "call fillmonths(?, ?)";
		$month_result = $this->db->query($query, [$this->filter_data['date_from'], $this->filter_data['date_to']])->result();

		$month_result = json_decode(json_encode($month_result), TRUE);
		$trend_result = json_decode(json_encode($trend_result), TRUE);

		$final_array = $this->left_join_array($month_result, $trend_result, 'label');

		$query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
		if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
		{
			$state_code = $this->loginData->state_code;
			$query .= " and state_code = '$state_code'";	
		}
		else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code'";	
		}
		else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$block_code = $this->loginData->block_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
		}
		$query .= " and user_mode= 1)";

		return $final_array;

	}

	/**
	 * Proportion of chidren received BCG at birth
	 */

	public function get_proportion_received_bcg_birth()
	{

		$query = "SELECT
		COUNT(pw.PWGUID) AS total
		FROM
		tblchild c
		INNER JOIN tblpregnant_woman pw ON
		c.pw_GUID = pw.PWGUID
		INNER JOIN tblhhfamilymember fm ON
		c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		fm.HHSurveyGUID = h.HHSurveyGUID
		WHERE
		c.bcg >= c.child_dob AND(
		c.bcg <= c.child_dob + INTERVAL 1 YEAR
	) AND pw.IsDeleted = 0 AND c.IsDeleted = 0 AND fm.IsDeleted = 0 AND h.IsDeleted = 0";

	if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
	{
		$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
	}

	if ($this->filter_data['ANM'] != NULL) 
	{
		$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
	}

	if ($this->filter_data['Asha'] != NULL) 
	{
		$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
	}

	$query .= " UNION ALL
	SELECT count(pw.PWGUID) from tblchild c 
	inner join tblpregnant_woman pw
	on c.pw_GUID = pw.PWGUID
	inner join tblhhfamilymember fm on c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID 
	inner join tblhhsurvey h on fm.HHSurveyGUID = h.HHSurveyGUID
	where 1=1 and pw.IsDeleted = 0 and c.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0";

	if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
	{
		$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
	}

	if ($this->filter_data['ANM'] != NULL) 
	{
		$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
	}

	if ($this->filter_data['Asha'] != NULL) 
	{
		$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
	}

	$query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
	if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
	{
		$state_code = $this->loginData->state_code;
		$query .= " and state_code = '$state_code'";	
	}
	else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
	{
		$state_code = $this->loginData->state_code;
		$district_code = $this->loginData->district_code;
		$query .= " and state_code = '$state_code' and district_code='$district_code'";	
	}
	else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
	{
		$state_code = $this->loginData->state_code;
		$district_code = $this->loginData->district_code;
		$block_code = $this->loginData->block_code;
		$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
	}
	$query .= " and user_mode= 1)";

	return $this->get_proportion($query);

}

public function trend_received_bcg_birth()
{

	$query = "SELECT concat(MONTHNAME(c.child_dob), ' - ', YEAR(c.child_dob)) as label, YEAR(c.child_dob) as year, MONTH(c.child_dob) as month, count(c.childGUID) as total from tblchild c 
	inner join tblpregnant_woman pw
	on c.pw_GUID = pw.PWGUID
	inner join tblhhfamilymember fm on c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID 
	inner join tblhhsurvey h on fm.HHSurveyGUID = h.HHSurveyGUID
	where  c.bcg >= c.child_dob and (c.bcg <= c.child_dob + interval 1 year) and pw.IsDeleted = 0 and c.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0";

	if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
	{
		$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
	}

	if ($this->filter_data['ANM'] != NULL) 
	{
		$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
	}

	if ($this->filter_data['Asha'] != NULL) 
	{
		$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
	}

	$query .= " group by MONTH(c.child_dob) order by year, month";
	$trend_result =  $this->db->query($query)->result();

	if ($this->filter_data['date_from'] == NULL || $this->filter_data['date_to'] == NULL) {
		$this->filter_data['date_from'] = date("Y-m-d", strtotime("-1 year", time()));
		$this->filter_data['date_to'] = date("Y-m-d");
	}

	$query = "call fillmonths(?, ?)";
	$month_result = $this->db->query($query, [$this->filter_data['date_from'], $this->filter_data['date_to']])->result();

	$month_result = json_decode(json_encode($month_result), TRUE);
	$trend_result = json_decode(json_encode($trend_result), TRUE);

	$final_array = $this->left_join_array($month_result, $trend_result, 'label');

	$query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
	if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
	{
		$state_code = $this->loginData->state_code;
		$query .= " and state_code = '$state_code'";	
	}
	else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
	{
		$state_code = $this->loginData->state_code;
		$district_code = $this->loginData->district_code;
		$query .= " and state_code = '$state_code' and district_code='$district_code'";	
	}
	else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
	{
		$state_code = $this->loginData->state_code;
		$district_code = $this->loginData->district_code;
		$block_code = $this->loginData->block_code;
		$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
	}
	$query .= " and user_mode= 1)";

	return $final_array;

}

	/**
	 * Proportion of chidren received OPV0 at birth
	 */

	public function get_proportion_received_opv0_birth()
	{

		$query = "SELECT count(pw.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman pw
		on c.pw_GUID = pw.PWGUID
		inner join tblhhfamilymember fm on c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID 
		inner join tblhhsurvey h on fm.HHSurveyGUID = h.HHSurveyGUID
		where  c.opv1 = c.child_dob and pw.IsDeleted = 0 and c.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= " UNION ALL
		SELECT count(pw.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman pw
		on c.pw_GUID = pw.PWGUID
		inner join tblhhfamilymember fm on c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID 
		inner join tblhhsurvey h on fm.HHSurveyGUID = h.HHSurveyGUID
		where 1=1 and pw.IsDeleted = 0 and c.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0";
		
		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
		if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
		{
			$state_code = $this->loginData->state_code;
			$query .= " and state_code = '$state_code'";	
		}
		else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code'";	
		}
		else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$block_code = $this->loginData->block_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
		}
		$query .= " and user_mode= 1)";

		return $this->get_proportion($query);

	}

	public function trend_received_opv0_birth()
	{

		$query = "SELECT
		CONCAT(
		MONTHNAME(c.child_dob),
		' - ',
		YEAR(c.child_dob)
		) AS label,
		YEAR(c.child_dob) AS YEAR,
		MONTH(c.child_dob) AS MONTH,
		COUNT(c.childGUID) AS total
		FROM
		tblchild c
		INNER JOIN tblpregnant_woman pw ON
		c.pw_GUID = pw.PWGUID
		INNER JOIN tblhhfamilymember fm ON
		c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		fm.HHSurveyGUID = h.HHSurveyGUID
		WHERE
		c.opv1 = c.child_dob AND pw.IsDeleted = 0 AND c.IsDeleted = 0 AND fm.IsDeleted = 0 AND h.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= " group by MONTH(c.child_dob) order by year, month";
		$trend_result =  $this->db->query($query)->result();

		if ($this->filter_data['date_from'] == NULL || $this->filter_data['date_to'] == NULL) {
			$this->filter_data['date_from'] = date("Y-m-d", strtotime("-1 year", time()));
			$this->filter_data['date_to'] = date("Y-m-d");
		}

		$query = "call fillmonths(?, ?)";
		$month_result = $this->db->query($query, [$this->filter_data['date_from'], $this->filter_data['date_to']])->result();

		$month_result = json_decode(json_encode($month_result), TRUE);
		$trend_result = json_decode(json_encode($trend_result), TRUE);

		$final_array = $this->left_join_array($month_result, $trend_result, 'label');

		$query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
		if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
		{
			$state_code = $this->loginData->state_code;
			$query .= " and state_code = '$state_code'";	
		}
		else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code'";	
		}
		else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$block_code = $this->loginData->block_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
		}
		$query .= " and user_mode= 1)";

		return $final_array;

	}

	/**
	 * Proportion of chidren received HEPB0 at birth
	 */

	public function get_proportion_received_hepb0_birth()
	{

		$query = "SELECT count(pw.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman pw
		on c.pw_GUID = pw.PWGUID
		inner join tblhhfamilymember fm on c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID 
		inner join tblhhsurvey h on fm.HHSurveyGUID = h.HHSurveyGUID
		where  c.hepb1 = c.child_dob and pw.IsDeleted = 0 and c.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= " UNION ALL
		SELECT count(pw.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman pw
		on c.pw_GUID = pw.PWGUID
		inner join tblhhfamilymember fm on c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID 
		inner join tblhhsurvey h on fm.HHSurveyGUID = h.HHSurveyGUID
		where 1=1 and pw.IsDeleted = 0 and c.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0";
		
		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
		if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
		{
			$state_code = $this->loginData->state_code;
			$query .= " and state_code = '$state_code'";	
		}
		else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code'";	
		}
		else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$block_code = $this->loginData->block_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
		}
		$query .= " and user_mode= 1)";

		return $this->get_proportion($query);

	}

	public function trend_received_hepb0_birth()
	{

		$query = "SELECT concat(MONTHNAME(c.child_dob), ' - ', YEAR(c.child_dob)) as label, YEAR(c.child_dob) as year, MONTH(c.child_dob) as month, count(c.childGUID) as total from tblchild c 
		inner join tblpregnant_woman pw
		on c.pw_GUID = pw.PWGUID
		inner join tblhhfamilymember fm on c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID 
		inner join tblhhsurvey h on fm.HHSurveyGUID = h.HHSurveyGUID
		where  c.hepb1 = c.child_dob and pw.IsDeleted = 0 and c.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= " group by MONTH(c.child_dob) order by year, month";
		$trend_result =  $this->db->query($query)->result();

		if ($this->filter_data['date_from'] == NULL || $this->filter_data['date_to'] == NULL) {
			$this->filter_data['date_from'] = date("Y-m-d", strtotime("-1 year", time()));
			$this->filter_data['date_to'] = date("Y-m-d");
		}

		$query = "call fillmonths(?, ?)";
		$month_result = $this->db->query($query, [$this->filter_data['date_from'], $this->filter_data['date_to']])->result();

		$month_result = json_decode(json_encode($month_result), TRUE);
		$trend_result = json_decode(json_encode($trend_result), TRUE);

		$final_array = $this->left_join_array($month_result, $trend_result, 'label');

		$query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
		if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
		{
			$state_code = $this->loginData->state_code;
			$query .= " and state_code = '$state_code'";	
		}
		else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code'";	
		}
		else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$block_code = $this->loginData->block_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
		}
		$query .= " and user_mode= 1)";

		return $final_array;

	}


	/**
	 * Proportion of chidren received HEPB0 at birth
	 */

	public function get_proportion_children_less_45_days_opv1()
	{

		$query = "SELECT count(pw.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman pw
		on c.pw_GUID = pw.PWGUID
		inner join tblhhfamilymember fm on c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID 
		inner join tblhhsurvey h on fm.HHSurveyGUID = h.HHSurveyGUID
		where  (c.opv2 <= c.child_dob + interval 45 day) and pw.IsDeleted = 0 and c.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= "	UNION ALL
		SELECT count(pw.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman pw
		on c.pw_GUID = pw.PWGUID
		inner join tblhhfamilymember fm on c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID 
		inner join tblhhsurvey h on fm.HHSurveyGUID = h.HHSurveyGUID
		where 1=1 and pw.IsDeleted = 0 and c.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
		if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
		{
			$state_code = $this->loginData->state_code;
			$query .= " and state_code = '$state_code'";	
		}
		else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code'";	
		}
		else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$block_code = $this->loginData->block_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
		}
		$query .= " and user_mode= 1)";

		return $this->get_proportion($query);

	}

	public function trend_children_less_45_days_opv1()
	{

		$query = "SELECT concat(MONTHNAME(c.child_dob), ' - ', YEAR(c.child_dob)) as label, YEAR(c.child_dob) as year, MONTH(c.child_dob) as month, count(c.childGUID) as total from tblchild c 
		inner join tblpregnant_woman pw
		on c.pw_GUID = pw.PWGUID
		inner join tblhhfamilymember fm on c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID 
		inner join tblhhsurvey h on fm.HHSurveyGUID = h.HHSurveyGUID
		where  (c.opv2 <= c.child_dob + interval 45 day) and pw.IsDeleted = 0 and c.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= " group by MONTH(c.child_dob) order by year, month";
		$trend_result =  $this->db->query($query)->result();

		if ($this->filter_data['date_from'] == NULL || $this->filter_data['date_to'] == NULL) {
			$this->filter_data['date_from'] = date("Y-m-d", strtotime("-1 year", time()));
			$this->filter_data['date_to'] = date("Y-m-d");
		}

		$query = "call fillmonths(?, ?)";
		$month_result = $this->db->query($query, [$this->filter_data['date_from'], $this->filter_data['date_to']])->result();

		$month_result = json_decode(json_encode($month_result), TRUE);
		$trend_result = json_decode(json_encode($trend_result), TRUE);

		$final_array = $this->left_join_array($month_result, $trend_result, 'label');

		$query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
		if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
		{
			$state_code = $this->loginData->state_code;
			$query .= " and state_code = '$state_code'";	
		}
		else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code'";	
		}
		else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$block_code = $this->loginData->block_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
		}
		$query .= " and user_mode= 1)";

		return $final_array;

	}

	/**
	 * Proportion of chidren aged 45 days or more received DPT1
	 */

	public function get_proportion_children_less_45_days_dpt1()
	{

		$query = "SELECT count(pw.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman pw
		on c.pw_GUID = pw.PWGUID
		inner join tblhhfamilymember fm 
		on c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID 
		inner join tblhhsurvey h 
		on fm.HHSurveyGUID = h.HHSurveyGUID
		where  (c.dpt2 <= c.child_dob + interval 45 day) and pw.IsDeleted = 0 and c.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= "	UNION ALL
		SELECT count(pw.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman pw 
		on c.pw_GUID = pw.PWGUID
		inner join tblhhfamilymember fm
		on c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID 
		inner join tblhhsurvey h 
		on fm.HHSurveyGUID = h.HHSurveyGUID
		where 1=1 and pw.IsDeleted = 0 and c.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
		if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
		{
			$state_code = $this->loginData->state_code;
			$query .= " and state_code = '$state_code'";	
		}
		else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code'";	
		}
		else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$block_code = $this->loginData->block_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
		}
		$query .= " and user_mode= 1)";

		return $this->get_proportion($query);

	}

	public function trend_children_less_45_days_dpt1()
	{

		$query = "SELECT concat(MONTHNAME(c.child_dob), ' - ', YEAR(c.child_dob)) as label, YEAR(c.child_dob) as year, MONTH(c.child_dob) as month, count(c.childGUID) as total from tblchild c 
		inner join tblpregnant_woman pw
		on c.pw_GUID = pw.PWGUID
		inner join tblhhfamilymember fm
		on c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID 
		inner join tblhhsurvey h 
		on fm.HHSurveyGUID = h.HHSurveyGUID
		where  (c.dpt2 <= c.child_dob + interval 45 day) and pw.IsDeleted = 0 and c.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}
		
		$query .= " group by MONTH(c.child_dob) order by year, month";
		$trend_result =  $this->db->query($query)->result();

		if ($this->filter_data['date_from'] == NULL || $this->filter_data['date_to'] == NULL) {
			$this->filter_data['date_from'] = date("Y-m-d", strtotime("-1 year", time()));
			$this->filter_data['date_to'] = date("Y-m-d");
		}

		$query = "call fillmonths(?, ?)";
		$month_result = $this->db->query($query, [$this->filter_data['date_from'], $this->filter_data['date_to']])->result();

		$month_result = json_decode(json_encode($month_result), TRUE);
		$trend_result = json_decode(json_encode($trend_result), TRUE);

		$final_array = $this->left_join_array($month_result, $trend_result, 'label');

		$query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
		if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
		{
			$state_code = $this->loginData->state_code;
			$query .= " and state_code = '$state_code'";	
		}
		else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code'";	
		}
		else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$block_code = $this->loginData->block_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
		}
		$query .= " and user_mode= 1)";

		return $final_array;

	}

	/**
	 * Proportion of chidren aged 45 days or more received Hepatitis B1
	 */

	public function get_proportion_children_less_45_days_hepb1()
	{

		$query = "SELECT count(pw.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman pw
		on c.pw_GUID = pw.PWGUID
		inner join tblhhfamilymember fm 
		on c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID 
		inner join tblhhsurvey h 
		on fm.HHSurveyGUID = h.HHSurveyGUID
		where  (c.hepb2 <= c.child_dob + interval 45 day) and pw.IsDeleted = 0 and c.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= "	UNION ALL
		SELECT count(pw.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman pw
		on c.pw_GUID = pw.PWGUID
		inner join tblhhfamilymember fm
		on c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID 
		inner join tblhhsurvey h
		on fm.HHSurveyGUID = h.HHSurveyGUID
		where 1=1 and pw.IsDeleted = 0 and c.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
		if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
		{
			$state_code = $this->loginData->state_code;
			$query .= " and state_code = '$state_code'";	
		}
		else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code'";	
		}
		else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$block_code = $this->loginData->block_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
		}
		$query .= " and user_mode= 1)";

		return $this->get_proportion($query);

	}

	public function trend_children_less_45_days_hepb1()
	{

		$query = "SELECT concat(MONTHNAME(c.child_dob), ' - ', YEAR(c.child_dob)) as label, YEAR(c.child_dob) as year, MONTH(c.child_dob) as month, count(c.childGUID) as total
		from tblchild c 
		inner join tblpregnant_woman pw
		on c.pw_GUID = pw.PWGUID
		inner join tblhhfamilymember fm 
		on c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID 
		inner join tblhhsurvey h
		on fm.HHSurveyGUID = h.HHSurveyGUID
		where  (c.hepb2 <= c.child_dob + interval 45 day) and pw.IsDeleted = 0 and c.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= " group by MONTH(c.child_dob) order by year, month";
		$trend_result =  $this->db->query($query)->result();

		if ($this->filter_data['date_from'] == NULL || $this->filter_data['date_to'] == NULL) {
			$this->filter_data['date_from'] = date("Y-m-d", strtotime("-1 year", time()));
			$this->filter_data['date_to'] = date("Y-m-d");
		}

		$query = "call fillmonths(?, ?)";
		$month_result = $this->db->query($query, [$this->filter_data['date_from'], $this->filter_data['date_to']])->result();

		$month_result = json_decode(json_encode($month_result), TRUE);
		$trend_result = json_decode(json_encode($trend_result), TRUE);

		$final_array = $this->left_join_array($month_result, $trend_result, 'label');

		$query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
		if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
		{
			$state_code = $this->loginData->state_code;
			$query .= " and state_code = '$state_code'";	
		}
		else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code'";	
		}
		else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$block_code = $this->loginData->block_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
		}
		$query .= " and user_mode= 1)";

		return $final_array;

	}

	/**
	 * Proportion of chidren aged 75 days or more received OPV2
	 */

	public function get_proportion_children_more_75_days_opv2()
	{

		$query = "SELECT count(pw.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman pw 
		on c.pw_GUID = pw.PWGUID
		inner join tblhhfamilymember fm 
		on c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID 
		inner join tblhhsurvey h 
		on fm.HHSurveyGUID = h.HHSurveyGUID
		where  (c.opv3 <= c.child_dob + interval 75 day) and pw.IsDeleted = 0 and c.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= "	UNION ALL
		SELECT count(pw.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman pw 
		on c.pw_GUID = pw.PWGUID
		inner join tblhhfamilymember fm on c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID 
		inner join tblhhsurvey h on fm.HHSurveyGUID = h.HHSurveyGUID
		where 1=1 and pw.IsDeleted = 0 and c.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
		if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
		{
			$state_code = $this->loginData->state_code;
			$query .= " and state_code = '$state_code'";	
		}
		else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code'";	
		}
		else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$block_code = $this->loginData->block_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
		}
		$query .= " and user_mode= 1)";

		return $this->get_proportion($query);

	}

	public function trend_children_more_75_days_opv2()
	{

		// $query = "SELECT concat(MONTHNAME(c.child_dob), ' - ', YEAR(c.child_dob)) as label, YEAR(c.child_dob) as year, MONTH(c.child_dob) as month, count(c.childGUID) as total
		// from tblchild c 
		// inner join tblpregnant_woman pw 
		// on c.pw_GUID = pw.PWGUID
		// where  (c.opv3 <= c.child_dob + interval 75 day) ";

		// faris edit
		$query = "SELECT concat(MONTHNAME(c.child_dob), ' - ', YEAR(c.child_dob)) as label, YEAR(c.child_dob) as year, MONTH(c.child_dob) as month, count(c.childGUID) as total
		from tblchild c 
		inner join tblhhfamilymember fm on c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID 
		inner join tblhhsurvey h on fm.HHSurveyGUID = h.HHSurveyGUID
		where  (c.opv2 <= c.child_dob + interval 75 day)  and c.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= " group by MONTH(c.child_dob) order by year, month";

		// echo $query; die();
		$trend_result =  $this->db->query($query)->result();

		if ($this->filter_data['date_from'] == NULL || $this->filter_data['date_to'] == NULL) {
			$this->filter_data['date_from'] = date("Y-m-d", strtotime("-1 year", time()));
			$this->filter_data['date_to'] = date("Y-m-d");
		}

		$query = "call fillmonths(?, ?)";
		$month_result = $this->db->query($query, [$this->filter_data['date_from'], $this->filter_data['date_to']])->result();

		$month_result = json_decode(json_encode($month_result), TRUE);
		$trend_result = json_decode(json_encode($trend_result), TRUE);

		$final_array = $this->left_join_array($month_result, $trend_result, 'label');

		$query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
		if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
		{
			$state_code = $this->loginData->state_code;
			$query .= " and state_code = '$state_code'";	
		}
		else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code'";	
		}
		else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$block_code = $this->loginData->block_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
		}
		$query .= " and user_mode= 1)";

		return $final_array;

	}

	/**
	 * Proportion of chidren aged 75 days or more received DPT2
	 */

	public function get_proportion_children_more_75_days_dpt2()
	{

		$query = "SELECT count(pw.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman pw 
		on c.pw_GUID = pw.PWGUID
		inner join tblhhfamilymember fm
		on c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID 
		inner join tblhhsurvey h 
		on fm.HHSurveyGUID = h.HHSurveyGUID
		where  (c.dpt2 <= c.child_dob + interval 75 day) and pw.IsDeleted = 0 and c.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0 ";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= "	UNION ALL
		SELECT count(pw.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman pw 
		on c.pw_GUID = pw.PWGUID
		inner join tblhhfamilymember fm
		on c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID 
		inner join tblhhsurvey h 
		on fm.HHSurveyGUID = h.HHSurveyGUID
		where 1=1 and pw.IsDeleted = 0 and c.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
		if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
		{
			$state_code = $this->loginData->state_code;
			$query .= " and state_code = '$state_code'";	
		}
		else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code'";	
		}
		else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$block_code = $this->loginData->block_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
		}
		$query .= " and user_mode= 1)";

		return $this->get_proportion($query);

	}

	public function trend_children_more_75_days_dpt2()
	{

		$query = "SELECT concat(MONTHNAME(c.child_dob), ' - ', YEAR(c.child_dob)) as label, YEAR(c.child_dob) as year, MONTH(c.child_dob) as month, count(c.childGUID) as total from tblchild c 
		inner join tblpregnant_woman pw 
		on c.pw_GUID = pw.PWGUID
		inner join tblhhfamilymember fm 
		on c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID 
		inner join tblhhsurvey h
		on fm.HHSurveyGUID = h.HHSurveyGUID
		where  (c.dpt2 <= c.child_dob + interval 75 day) and pw.IsDeleted = 0 and c.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= " group by MONTH(c.child_dob) order by year, month";
		$trend_result =  $this->db->query($query)->result();

		if ($this->filter_data['date_from'] == NULL || $this->filter_data['date_to'] == NULL) {
			$this->filter_data['date_from'] = date("Y-m-d", strtotime("-1 year", time()));
			$this->filter_data['date_to'] = date("Y-m-d");
		}

		$query = "call fillmonths(?, ?)";
		$month_result = $this->db->query($query, [$this->filter_data['date_from'], $this->filter_data['date_to']])->result();

		$month_result = json_decode(json_encode($month_result), TRUE);
		$trend_result = json_decode(json_encode($trend_result), TRUE);

		$final_array = $this->left_join_array($month_result, $trend_result, 'label');

		$query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
		if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
		{
			$state_code = $this->loginData->state_code;
			$query .= " and state_code = '$state_code'";	
		}
		else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code'";	
		}
		else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$block_code = $this->loginData->block_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
		}
		$query .= " and user_mode= 1)";

		return $final_array;

	}

	/**
	 * Proportion of chidren aged 75 days or more received Hepatitis B2
	 */

	public function get_proportion_children_more_75_days_hepb2()
	{

		$query = "SELECT count(pw.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman pw 
		on c.pw_GUID = pw.PWGUID
		inner join tblhhfamilymember fm
		on c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID 
		inner join tblhhsurvey h 
		on fm.HHSurveyGUID = h.HHSurveyGUID
		where  (c.hepb3 <= c.child_dob + interval 75 day) and pw.IsDeleted = 0 and c.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= "	UNION ALL
		SELECT count(pw.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman pw 
		on c.pw_GUID = pw.PWGUID
		inner join tblhhfamilymember fm on c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID 
		inner join tblhhsurvey h on fm.HHSurveyGUID = h.HHSurveyGUID
		where 1=1 and pw.IsDeleted = 0 and c.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0 ";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
		if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
		{
			$state_code = $this->loginData->state_code;
			$query .= " and state_code = '$state_code'";	
		}
		else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code'";	
		}
		else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$block_code = $this->loginData->block_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
		}
		$query .= " and user_mode= 1)";

		return $this->get_proportion($query);

	}

	public function trend_children_more_75_days_hepb2()
	{

		$query = "select concat(MONTHNAME(c.child_dob), ' - ', YEAR(c.child_dob)) as label, YEAR(c.child_dob) as year, MONTH(c.child_dob) as month, count(c.childGUID) as total from tblchild c 
		inner join tblpregnant_woman pw 
		on c.pw_GUID = pw.PWGUID
		inner join tblhhfamilymember fm 
		on c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID 
		inner join tblhhsurvey h
		on fm.HHSurveyGUID = h.HHSurveyGUID
		where  (c.hepb3 <= c.child_dob + interval 75 day) and pw.IsDeleted = 0 and c.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= " group by MONTH(c.child_dob) order by year, month";
		$trend_result =  $this->db->query($query)->result();

		if ($this->filter_data['date_from'] == NULL || $this->filter_data['date_to'] == NULL) {
			$this->filter_data['date_from'] = date("Y-m-d", strtotime("-1 year", time()));
			$this->filter_data['date_to'] = date("Y-m-d");
		}

		$query = "call fillmonths(?, ?)";
		$month_result = $this->db->query($query, [$this->filter_data['date_from'], $this->filter_data['date_to']])->result();

		$month_result = json_decode(json_encode($month_result), TRUE);
		$trend_result = json_decode(json_encode($trend_result), TRUE);

		$final_array = $this->left_join_array($month_result, $trend_result, 'label');

		$query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
		if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
		{
			$state_code = $this->loginData->state_code;
			$query .= " and state_code = '$state_code'";	
		}
		else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code'";	
		}
		else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$block_code = $this->loginData->block_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
		}
		$query .= " and user_mode= 1)";

		return $final_array;

	}

	/**
	 * Proportion of chidren aged 105 days or more received OPV3
	 */

	public function get_proportion_children_more_105_days_opv3()
	{

		$query = "SELECT count(pw.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman pw 
		on c.pw_GUID = pw.PWGUID
		inner join tblhhfamilymember fm on c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID 
		inner join tblhhsurvey h on fm.HHSurveyGUID = h.HHSurveyGUID
		where  (c.opv4 <= c.child_dob + interval 105 day) and pw.IsDeleted = 0 and c.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= "	UNION ALL
		SELECT count(pw.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman pw 
		on c.pw_GUID = pw.PWGUID
		inner join tblhhfamilymember fm 
		on c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID 
		inner join tblhhsurvey h
		on fm.HHSurveyGUID = h.HHSurveyGUID
		where 1=1 and pw.IsDeleted = 0 and c.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
		if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
		{
			$state_code = $this->loginData->state_code;
			$query .= " and state_code = '$state_code'";	
		}
		else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code'";	
		}
		else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$block_code = $this->loginData->block_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
		}
		$query .= " and user_mode= 1)";

		return $this->get_proportion($query);

	}

	public function trend_children_more_105_days_opv3()
	{

		$query = "SELECT concat(MONTHNAME(c.child_dob), ' - ', YEAR(c.child_dob)) as label, YEAR(c.child_dob) as year, MONTH(c.child_dob) as month, count(c.childGUID) as total from tblchild c 
		inner join tblpregnant_woman pw 
		on c.pw_GUID = pw.PWGUID
		inner join tblhhfamilymember fm
		on c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID 
		inner join tblhhsurvey h 
		on fm.HHSurveyGUID = h.HHSurveyGUID
		where  (c.opv4 < = c.child_dob + interval 105 day) and pw.IsDeleted = 0 and c.IsDeleted = 0 and fm.IsDeleted= 0 and h.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= " group by MONTH(c.child_dob) order by year, month";
		$trend_result =  $this->db->query($query)->result();

		if ($this->filter_data['date_from'] == NULL || $this->filter_data['date_to'] == NULL) {
			$this->filter_data['date_from'] = date("Y-m-d", strtotime("-1 year", time()));
			$this->filter_data['date_to'] = date("Y-m-d");
		}

		$query = "call fillmonths(?, ?)";
		$month_result = $this->db->query($query, [$this->filter_data['date_from'], $this->filter_data['date_to']])->result();

		$month_result = json_decode(json_encode($month_result), TRUE);
		$trend_result = json_decode(json_encode($trend_result), TRUE);

		$final_array = $this->left_join_array($month_result, $trend_result, 'label');

		$query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
		if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
		{
			$state_code = $this->loginData->state_code;
			$query .= " and state_code = '$state_code'";	
		}
		else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code'";	
		}
		else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$block_code = $this->loginData->block_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
		}
		$query .= " and user_mode= 1)";

		return $final_array;

	}

	/**
	 * Proportion of chidren aged 105 days or more received DPT3
	 */

	public function get_proportion_children_more_105_days_dpt3()
	{

		$query = "SELECT count(pw.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman pw 
		on c.pw_GUID = pw.PWGUID
		inner join tblhhfamilymember fm 
		on c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID 
		inner join tblhhsurvey h
		on fm.HHSurveyGUID = h.HHSurveyGUID
		where (c.dpt3 <= c.child_dob + interval 105 day) and pw.IsDeleted = 0 and c.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= "	UNION ALL
		SELECT count(pw.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman pw 
		on c.pw_GUID = pw.PWGUID
		inner join tblhhfamilymember fm 
		on c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID 
		inner join tblhhsurvey h
		on fm.HHSurveyGUID = h.HHSurveyGUID
		where 1=1 and pw.IsDeleted = 0 and c.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}
		
		$query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
		if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
		{
			$state_code = $this->loginData->state_code;
			$query .= " and state_code = '$state_code'";	
		}
		else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code'";	
		}
		else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$block_code = $this->loginData->block_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
		}
		$query .= " and user_mode= 1)";

		return $this->get_proportion($query);

	}

	public function trend_children_more_105_days_dpt3()
	{

		$query = "SELECT
		CONCAT(
		MONTHNAME(c.child_dob),
		' - ',
		YEAR(c.child_dob)
		) AS label,
		YEAR(c.child_dob) AS YEAR,
		MONTH(c.child_dob) AS MONTH,
		COUNT(c.childGUID) AS total
		FROM
		tblchild c
		INNER JOIN tblpregnant_woman pw ON
		c.pw_GUID = pw.PWGUID
		INNER JOIN tblhhfamilymember fm ON
		c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		fm.HHSurveyGUID = h.HHSurveyGUID
		WHERE
		(
		c.dpt3 <= c.child_dob + INTERVAL 105 DAY
	) AND pw.IsDeleted = 0 AND c.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0";

	if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
	{
		$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
	}

	if ($this->filter_data['ANM'] != NULL) 
	{
		$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
	}

	if ($this->filter_data['Asha'] != NULL) 
	{
		$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
	}

	$query .= " group by MONTH(c.child_dob) order by year, month";
	$trend_result =  $this->db->query($query)->result();

	if ($this->filter_data['date_from'] == NULL || $this->filter_data['date_to'] == NULL) {
		$this->filter_data['date_from'] = date("Y-m-d", strtotime("-1 year", time()));
		$this->filter_data['date_to'] = date("Y-m-d");
	}

	$query = "call fillmonths(?, ?)";
	$month_result = $this->db->query($query, [$this->filter_data['date_from'], $this->filter_data['date_to']])->result();

	$month_result = json_decode(json_encode($month_result), TRUE);
	$trend_result = json_decode(json_encode($trend_result), TRUE);

	$final_array = $this->left_join_array($month_result, $trend_result, 'label');

	$query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
	if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
	{
		$state_code = $this->loginData->state_code;
		$query .= " and state_code = '$state_code'";	
	}
	else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
	{
		$state_code = $this->loginData->state_code;
		$district_code = $this->loginData->district_code;
		$query .= " and state_code = '$state_code' and district_code='$district_code'";	
	}
	else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
	{
		$state_code = $this->loginData->state_code;
		$district_code = $this->loginData->district_code;
		$block_code = $this->loginData->block_code;
		$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
	}
	$query .= " and user_mode= 1)";

	return $final_array;

}

	/**
	 * Proportion of chidren aged 105 days or more received HRPB3
	 */

	public function get_proportion_children_more_105_days_hepb3()
	{

		$query = "SELECT count(pw.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman pw 
		on c.pw_GUID = pw.PWGUID
		INNER JOIN tblhhfamilymember fm ON
		c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		fm.HHSurveyGUID = h.HHSurveyGUID
		where  (c.hepb4 <= c.child_dob + interval 105 day) and pw.IsDeleted = 0 and c.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= "	UNION ALL
		SELECT count(pw.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman pw
		on c.pw_GUID = pw.PWGUID
		INNER JOIN tblhhfamilymember fm ON
		c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		fm.HHSurveyGUID = h.HHSurveyGUID
		where 1=1 and pw.IsDeleted = 0 and c.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
		if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
		{
			$state_code = $this->loginData->state_code;
			$query .= " and state_code = '$state_code'";	
		}
		else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code'";	
		}
		else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$block_code = $this->loginData->block_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
		}
		$query .= " and user_mode= 1)";

		return $this->get_proportion($query);

	}

	public function trend_children_more_105_days_hepb3()
	{

		$query = "SELECT concat(MONTHNAME(c.child_dob), ' - ', YEAR(c.child_dob)) as label, YEAR(c.child_dob) as year, MONTH(c.child_dob) as month, count(c.childGUID) as total from tblchild c 
		inner join tblpregnant_woman pw 
		on c.pw_GUID = pw.PWGUID
		INNER JOIN tblhhfamilymember fm ON
		c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		fm.HHSurveyGUID = h.HHSurveyGUID
		where  (c.hepb4 <= c.child_dob + interval 105 day) and pw.IsDeleted = 0 and c.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= " group by MONTH(c.child_dob) order by year, month";
		$trend_result =  $this->db->query($query)->result();

		if ($this->filter_data['date_from'] == NULL || $this->filter_data['date_to'] == NULL) {
			$this->filter_data['date_from'] = date("Y-m-d", strtotime("-1 year", time()));
			$this->filter_data['date_to'] = date("Y-m-d");
		}

		$query = "call fillmonths(?, ?)";
		$month_result = $this->db->query($query, [$this->filter_data['date_from'], $this->filter_data['date_to']])->result();

		$month_result = json_decode(json_encode($month_result), TRUE);
		$trend_result = json_decode(json_encode($trend_result), TRUE);

		$final_array = $this->left_join_array($month_result, $trend_result, 'label');

		$query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
		if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
		{
			$state_code = $this->loginData->state_code;
			$query .= " and state_code = '$state_code'";	
		}
		else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code'";	
		}
		else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$block_code = $this->loginData->block_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
		}
		$query .= " and user_mode= 1)";

		return $final_array;

	}

	/**
	 * Proportion of chidren aged 9 months received Measles vaccination
	 */

	public function get_proportion_children_nine_months_more_measles()
	{

		$query = "SELECT count(pw.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman pw 
		on c.pw_GUID = pw.PWGUID
		INNER JOIN tblhhfamilymember fm ON
		c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		fm.HHSurveyGUID = h.HHSurveyGUID
		where  (c.measeals <= c.child_dob + interval 9 month) and pw.IsDeleted = 0 and c.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= "	UNION ALL
		SELECT count(pw.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman pw 
		on c.pw_GUID = pw.PWGUID
		INNER JOIN tblhhfamilymember fm ON
		c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		fm.HHSurveyGUID = h.HHSurveyGUID
		where 1=1 and pw.IsDeleted = 0 and c.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
		if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
		{
			$state_code = $this->loginData->state_code;
			$query .= " and state_code = '$state_code'";	
		}
		else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code'";	
		}
		else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$block_code = $this->loginData->block_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
		}
		$query .= " and user_mode= 1)";

		return $this->get_proportion($query);

	}

	public function trend_children_nine_months_more_measles()
	{

		$query = "SELECT concat(MONTHNAME(c.child_dob), ' - ', YEAR(c.child_dob)) as label, YEAR(c.child_dob) as year, MONTH(c.child_dob) as month, count(c.childGUID) as total
		from tblchild c 
		inner join tblpregnant_woman pw 
		on c.pw_GUID = pw.PWGUID
		INNER JOIN tblhhfamilymember fm ON
		c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		fm.HHSurveyGUID = h.HHSurveyGUID
		where  (c.measeals <= c.child_dob + interval 9 month) and pw.IsDeleted = 0 and c.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$trend_result =  $this->db->query($query)->result();

		if ($this->filter_data['date_from'] == NULL || $this->filter_data['date_to'] == NULL) {
			$this->filter_data['date_from'] = date("Y-m-d", strtotime("-1 year", time()));
			$this->filter_data['date_to'] = date("Y-m-d");
		}

		$query = "call fillmonths(?, ?)";
		$month_result = $this->db->query($query, [$this->filter_data['date_from'], $this->filter_data['date_to']])->result();

		$month_result = json_decode(json_encode($month_result), TRUE);
		$trend_result = json_decode(json_encode($trend_result), TRUE);

		$final_array = $this->left_join_array($month_result, $trend_result, 'label');

		$query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
		if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
		{
			$state_code = $this->loginData->state_code;
			$query .= " and state_code = '$state_code'";	
		}
		else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code'";	
		}
		else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$block_code = $this->loginData->block_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
		}
		$query .= " and user_mode= 1)";

		return $final_array;

	}

	/**
	 * Proportion of chidren aged 9 months received Vitamin A
	 */

	public function get_proportion_children_nine_months_more_vitamin_a()
	{

		$query = "SELECT count(pw.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman pw 
		on c.pw_GUID = pw.PWGUID
		INNER JOIN tblhhfamilymember fm ON
		c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		fm.HHSurveyGUID = h.HHSurveyGUID
		where  (c.vitaminA <= c.child_dob + interval 9 month) and pw.IsDeleted = 0 and c.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= "	UNION ALL
		SELECT count(pw.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman pw 
		on c.pw_GUID = pw.PWGUID
		INNER JOIN tblhhfamilymember fm ON
		c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		fm.HHSurveyGUID = h.HHSurveyGUID
		where 1=1 and pw.IsDeleted = 0 and c.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
		if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
		{
			$state_code = $this->loginData->state_code;
			$query .= " and state_code = '$state_code'";	
		}
		else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code'";	
		}
		else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$block_code = $this->loginData->block_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
		}
		$query .= " and user_mode= 1)";

		return $this->get_proportion($query);

	}

	public function trend_children_nine_months_more_vitamin_a()
	{

		$query = "SELECT concat(MONTHNAME(c.child_dob), ' - ', YEAR(c.child_dob)) as label, YEAR(c.child_dob) as year, MONTH(c.child_dob) as month, count(c.childGUID) as total from tblchild c 
		inner join tblpregnant_woman pw 
		on c.pw_GUID = pw.PWGUID
		INNER JOIN tblhhfamilymember fm ON
		c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		fm.HHSurveyGUID = h.HHSurveyGUID
		where  (c.vitaminA <= c.child_dob + interval 9 month) and pw.IsDeleted = 0 and c.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= " group by MONTH(c.child_dob) order by year, month";

		$trend_result =  $this->db->query($query)->result();

		if ($this->filter_data['date_from'] == NULL || $this->filter_data['date_to'] == NULL) {
			$this->filter_data['date_from'] = date("Y-m-d", strtotime("-1 year", time()));
			$this->filter_data['date_to'] = date("Y-m-d");
		}

		$query = "call fillmonths(?, ?)";
		$month_result = $this->db->query($query, [$this->filter_data['date_from'], $this->filter_data['date_to']])->result();

		$month_result = json_decode(json_encode($month_result), TRUE);
		$trend_result = json_decode(json_encode($trend_result), TRUE);

		$final_array = $this->left_join_array($month_result, $trend_result, 'label');

		$query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
		if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
		{
			$state_code = $this->loginData->state_code;
			$query .= " and state_code = '$state_code'";	
		}
		else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code'";	
		}
		else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$block_code = $this->loginData->block_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
		}
		$query .= " and user_mode= 1)";

		return $final_array;

	}

	/**
	 * Proportion of chidren aged 16 months received second dose of Vitamin A
	 */

	public function get_proportion_children_sixteen_months_vitamin_a2()
	{

		$query = "SELECT count(pw.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman pw 
		on c.pw_GUID = pw.PWGUID
		INNER JOIN tblhhfamilymember fm ON
		c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		fm.HHSurveyGUID = h.HHSurveyGUID
		where  (c.VitaminAtwo <= c.child_dob + interval 18 month) and pw.IsDeleted = 0 and c.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= "	UNION ALL
		SELECT count(pw.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman pw 
		on c.pw_GUID = pw.PWGUID
		INNER JOIN tblhhfamilymember fm ON
		c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		fm.HHSurveyGUID = h.HHSurveyGUID
		where 1=1 and pw.IsDeleted = 0 and c.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
		if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
		{
			$state_code = $this->loginData->state_code;
			$query .= " and state_code = '$state_code'";	
		}
		else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code'";	
		}
		else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$block_code = $this->loginData->block_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
		}
		$query .= " and user_mode= 1)";

		return $this->get_proportion($query);

	}

	public function trend_children_sixteen_months_vitamin_a2()
	{

		$query = "SELECT concat(MONTHNAME(c.child_dob), ' - ', YEAR(c.child_dob)) as label, YEAR(c.child_dob) as year, MONTH(c.child_dob) as month, count(c.childGUID) as total from tblchild c 
		inner join tblpregnant_woman pw 
		on c.pw_GUID = pw.PWGUID
		INNER JOIN tblhhfamilymember fm ON
		c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		fm.HHSurveyGUID = h.HHSurveyGUID
		where  (c.VitaminAtwo <= c.child_dob + interval 18 month) and pw.IsDeleted = 0 and c.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= " group by MONTH(c.child_dob) order by year, month";
		
		$trend_result =  $this->db->query($query)->result();

		if ($this->filter_data['date_from'] == NULL || $this->filter_data['date_to'] == NULL) {
			$this->filter_data['date_from'] = date("Y-m-d", strtotime("-1 year", time()));
			$this->filter_data['date_to'] = date("Y-m-d");
		}

		$query = "call fillmonths(?, ?)";
		$month_result = $this->db->query($query, [$this->filter_data['date_from'], $this->filter_data['date_to']])->result();

		$month_result = json_decode(json_encode($month_result), TRUE);
		$trend_result = json_decode(json_encode($trend_result), TRUE);

		$final_array = $this->left_join_array($month_result, $trend_result, 'label');

		$query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
		if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
		{
			$state_code = $this->loginData->state_code;
			$query .= " and state_code = '$state_code'";	
		}
		else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code'";	
		}
		else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$block_code = $this->loginData->block_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
		}
		$query .= " and user_mode= 1)";

		return $final_array;

	}

	/**
	 * Proportion of children aged 16 to 24 motnhs received DPT booster
	 */

	public function get_proportion_children_16_24_months_dptbooster()
	{

		$query = "SELECT count(pw.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman pw 
		on c.pw_GUID = pw.PWGUID
		INNER JOIN tblhhfamilymember fm ON
		c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		fm.HHSurveyGUID = h.HHSurveyGUID
		where  c.DPTBooster is not null
		and TIMESTAMPDIFF(MONTH, c.child_dob, CURRENT_TIMESTAMP) >= 16
		and TIMESTAMPDIFF(MONTH, c.child_dob, CURRENT_TIMESTAMP) <= 24 and pw.IsDeleted = 0 and c.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= "	UNION ALL
		SELECT count(pw.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman pw 
		on c.pw_GUID = pw.PWGUID
		INNER JOIN tblhhfamilymember fm ON
		c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		fm.HHSurveyGUID = h.HHSurveyGUID
		where TIMESTAMPDIFF(MONTH, c.child_dob, CURRENT_TIMESTAMP) >= 16 
		and TIMESTAMPDIFF(MONTH, c.child_dob, CURRENT_TIMESTAMP) <= 24 and pw.IsDeleted = 0 and c.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
		if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
		{
			$state_code = $this->loginData->state_code;
			$query .= " and state_code = '$state_code'";	
		}
		else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code'";	
		}
		else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$block_code = $this->loginData->block_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
		}
		$query .= " and user_mode= 1)";

		return $this->get_proportion($query);

	}

	public function trend_children_16_24_months_dptbooster()
	{

		$query = "SELECT concat(MONTHNAME(c.child_dob), ' - ', YEAR(c.child_dob)) as label, YEAR(c.child_dob) as year, MONTH(c.child_dob) as month, count(c.childGUID) as total from tblchild c 
		inner join tblpregnant_woman pw 
		on c.pw_GUID = pw.PWGUID
		INNER JOIN tblhhfamilymember fm ON
		c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		fm.HHSurveyGUID = h.HHSurveyGUID
		where  c.DPTBooster is not null
		and TIMESTAMPDIFF(MONTH, c.child_dob, CURRENT_TIMESTAMP) >= 16
		and TIMESTAMPDIFF(MONTH, c.child_dob, CURRENT_TIMESTAMP) <= 24 and pw.IsDeleted = 0 and c.IsDeleted = 0 fm.IsDeleted = 0 and h.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= " group by MONTH(c.child_dob) order by year, month";
		
		$trend_result =  $this->db->query($query)->result();

		if ($this->filter_data['date_from'] == NULL || $this->filter_data['date_to'] == NULL) {
			$this->filter_data['date_from'] = date("Y-m-d", strtotime("-1 year", time()));
			$this->filter_data['date_to'] = date("Y-m-d");
		}

		$query = "call fillmonths(?, ?)";
		$month_result = $this->db->query($query, [$this->filter_data['date_from'], $this->filter_data['date_to']])->result();

		$month_result = json_decode(json_encode($month_result), TRUE);
		$trend_result = json_decode(json_encode($trend_result), TRUE);

		$final_array = $this->left_join_array($month_result, $trend_result, 'label');

		$query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
		if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
		{
			$state_code = $this->loginData->state_code;
			$query .= " and state_code = '$state_code'";	
		}
		else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code'";	
		}
		else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$block_code = $this->loginData->block_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
		}
		$query .= " and user_mode= 1)";

		return $final_array;

	}

	/**
	 * Proportion of children aged 16 to 24 motnhs received Polio booster
	 */

	public function get_proportion_children_16_24_months_poliobooster()
	{

		$query = "SELECT count(pw.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman pw 
		on c.pw_GUID = pw.PWGUID
		INNER JOIN tblhhfamilymember fm ON
		c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		fm.HHSurveyGUID = h.HHSurveyGUID
		where  c.OPVBooster is not null
		and TIMESTAMPDIFF(MONTH, c.child_dob, CURRENT_TIMESTAMP) >= 16
		and TIMESTAMPDIFF(MONTH, c.child_dob, CURRENT_TIMESTAMP) <= 24 and pw.IsDeleted = 0 and c.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= "	UNION ALL
		SELECT count(pw.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman pw 
		on c.pw_GUID = pw.PWGUID
		INNER JOIN tblhhfamilymember fm ON
		c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		fm.HHSurveyGUID = h.HHSurveyGUID
		where TIMESTAMPDIFF(MONTH, c.child_dob, CURRENT_TIMESTAMP) >= 16 
		and TIMESTAMPDIFF(MONTH, c.child_dob, CURRENT_TIMESTAMP) <= 24 and pw.IsDeleted = 0 and c.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
		if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
		{
			$state_code = $this->loginData->state_code;
			$query .= " and state_code = '$state_code'";	
		}
		else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code'";	
		}
		else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$block_code = $this->loginData->block_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
		}
		$query .= " and user_mode= 1)";

		return $this->get_proportion($query);

	}

	public function trend_children_16_24_months_poliobooster()
	{

		$query = "SELECT concat(MONTHNAME(c.child_dob), ' - ', YEAR(c.child_dob)) as label, YEAR(c.child_dob) as year, MONTH(c.child_dob) as month, count(c.childGUID) as total from tblchild c 
		inner join tblpregnant_woman pw 
		on c.pw_GUID = pw.PWGUID
		INNER JOIN tblhhfamilymember fm ON
		c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		fm.HHSurveyGUID = h.HHSurveyGUID
		where  c.OPVBooster is not null
		and TIMESTAMPDIFF(MONTH, c.child_dob, CURRENT_TIMESTAMP) >= 16
		and TIMESTAMPDIFF(MONTH, c.child_dob, CURRENT_TIMESTAMP) <= 24 and pw.IsDeleted = 0 and c.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= " group by MONTH(c.child_dob) order by year, month";

		$trend_result =  $this->db->query($query)->result();

		if ($this->filter_data['date_from'] == NULL || $this->filter_data['date_to'] == NULL) {
			$this->filter_data['date_from'] = date("Y-m-d", strtotime("-1 year", time()));
			$this->filter_data['date_to'] = date("Y-m-d");
		}

		$query = "call fillmonths(?, ?)";
		$month_result = $this->db->query($query, [$this->filter_data['date_from'], $this->filter_data['date_to']])->result();

		$month_result = json_decode(json_encode($month_result), TRUE);
		$trend_result = json_decode(json_encode($trend_result), TRUE);

		$final_array = $this->left_join_array($month_result, $trend_result, 'label');

		$query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
		if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
		{
			$state_code = $this->loginData->state_code;
			$query .= " and state_code = '$state_code'";	
		}
		else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code'";	
		}
		else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$block_code = $this->loginData->block_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
		}
		$query .= " and user_mode= 1)";

		return $final_array;

	}

	/**
	 * Proportion of chidren aged 24 months received third dose of Vitamin A
	 */

	public function proportion_children_24_months_vitamin_a3()
	{

		$query = "SELECT count(pw.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman pw 
		on c.pw_GUID = pw.PWGUID
		INNER JOIN tblhhfamilymember fm ON
		c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		fm.HHSurveyGUID = h.HHSurveyGUID
		where  c.VitaminA3 is not null
		and TIMESTAMPDIFF(MONTH, c.child_dob, CURRENT_TIMESTAMP) >= 25 and pw.IsDeleted = 0 and c.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= "	UNION ALL
		SELECT count(pw.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman pw 
		on c.pw_GUID = pw.PWGUID
		INNER JOIN tblhhfamilymember fm ON
		c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		fm.HHSurveyGUID = h.HHSurveyGUID
		where TIMESTAMPDIFF(MONTH, c.child_dob, CURRENT_TIMESTAMP) = 24 and pw.IsDeleted = 0 and c.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
		if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
		{
			$state_code = $this->loginData->state_code;
			$query .= " and state_code = '$state_code'";	
		}
		else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code'";	
		}
		else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$block_code = $this->loginData->block_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
		}
		$query .= " and user_mode= 1)";

		return $this->get_proportion($query);

	}

	public function trend_children_24_months_vitamin_a3()
	{

		$query = "SELECT concat(MONTHNAME(c.child_dob), ' - ', YEAR(c.child_dob)) as label, YEAR(c.child_dob) as year, MONTH(c.child_dob) as month, count(c.childGUID) as total from tblchild c 
		inner join tblpregnant_woman pw 
		on c.pw_GUID = pw.PWGUID
		INNER JOIN tblhhfamilymember fm ON
		c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		fm.HHSurveyGUID = h.HHSurveyGUID
		where  c.VitaminA3 is not null
		and TIMESTAMPDIFF(MONTH, c.child_dob, CURRENT_TIMESTAMP) >= 25 and pw.IsDeleted = 0 and c.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}


		$query .= " group by MONTH(c.child_dob) order by year, month";
		
		$trend_result =  $this->db->query($query)->result();

		if ($this->filter_data['date_from'] == NULL || $this->filter_data['date_to'] == NULL) {
			$this->filter_data['date_from'] = date("Y-m-d", strtotime("-1 year", time()));
			$this->filter_data['date_to'] = date("Y-m-d");
		}

		$query = "call fillmonths(?, ?)";
		$month_result = $this->db->query($query, [$this->filter_data['date_from'], $this->filter_data['date_to']])->result();

		$month_result = json_decode(json_encode($month_result), TRUE);
		$trend_result = json_decode(json_encode($trend_result), TRUE);

		$final_array = $this->left_join_array($month_result, $trend_result, 'label');

		$query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
		if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
		{
			$state_code = $this->loginData->state_code;
			$query .= " and state_code = '$state_code'";	
		}
		else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code'";	
		}
		else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$block_code = $this->loginData->block_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
		}
		$query .= " and user_mode= 1)";

		return $final_array;

	}

	/**
	 * Proportion of chidren aged 30 months received 4th dose of Vitamin A
	 */

	public function get_proportion_children_30_months_vitamin_a4()
	{

		$query = "SELECT count(pw.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman pw 
		on c.pw_GUID = pw.PWGUID
		INNER JOIN tblhhfamilymember fm ON
		c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		fm.HHSurveyGUID = h.HHSurveyGUID
		where  c.VitaminA4 is not null
		and TIMESTAMPDIFF(MONTH, c.child_dob, CURRENT_TIMESTAMP) >= 30 and pw.IsDeleted = 0 and c.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= "	UNION ALL
		SELECT count(pw.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman pw 
		on c.pw_GUID = pw.PWGUID
		INNER JOIN tblhhfamilymember fm ON
		c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		fm.HHSurveyGUID = h.HHSurveyGUID
		where TIMESTAMPDIFF(MONTH, c.child_dob, CURRENT_TIMESTAMP) = 30 and pw.IsDeleted = 0 and c.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
		if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
		{
			$state_code = $this->loginData->state_code;
			$query .= " and state_code = '$state_code'";	
		}
		else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code'";	
		}
		else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$block_code = $this->loginData->block_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
		}
		$query .= " and user_mode= 1)";

		return $this->get_proportion($query);

	}

	public function trend_children_30_months_vitamin_a4()
	{

		$query = "SELECT concat(MONTHNAME(c.child_dob), ' - ', YEAR(c.child_dob)) as label, YEAR(c.child_dob) as year, MONTH(c.child_dob) as month, count(c.childGUID) as total from tblchild c 
		inner join tblpregnant_woman pw 
		on c.pw_GUID = pw.PWGUID
		INNER JOIN tblhhfamilymember fm ON
		c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		fm.HHSurveyGUID = h.HHSurveyGUID
		where  c.VitaminA4 is not null
		and TIMESTAMPDIFF(MONTH, c.child_dob, CURRENT_TIMESTAMP) >= 30 and pw.IsDeleted = 0 and c.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= " group by MONTH(c.child_dob) order by year, month";
		
		$trend_result =  $this->db->query($query)->result();

		if ($this->filter_data['date_from'] == NULL || $this->filter_data['date_to'] == NULL) {
			$this->filter_data['date_from'] = date("Y-m-d", strtotime("-1 year", time()));
			$this->filter_data['date_to'] = date("Y-m-d");
		}

		$query = "call fillmonths(?, ?)";
		$month_result = $this->db->query($query, [$this->filter_data['date_from'], $this->filter_data['date_to']])->result();

		$month_result = json_decode(json_encode($month_result), TRUE);
		$trend_result = json_decode(json_encode($trend_result), TRUE);

		$final_array = $this->left_join_array($month_result, $trend_result, 'label');

		
		$query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
		if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
		{
			$state_code = $this->loginData->state_code;
			$query .= " and state_code = '$state_code'";	
		}
		else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code'";	
		}
		else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$block_code = $this->loginData->block_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
		}
		$query .= " and user_mode= 1)";

		return $final_array;

	}

	/**
	 * Proportion of chidren aged 36 months received 5th dose of Vitamin A
	 */

	public function get_proportion_children_36_months_vitamin_a5()
	{

		$query = "SELECT count(pw.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman pw 
		on c.pw_GUID = pw.PWGUID
		INNER JOIN tblhhfamilymember fm ON
		c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		fm.HHSurveyGUID = h.HHSurveyGUID
		where  c.VitaminA5 is not null
		and TIMESTAMPDIFF(MONTH, c.child_dob, CURRENT_TIMESTAMP) >= 36 and pw.IsDeleted = 0 and c.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= "	UNION ALL
		SELECT count(pw.PWGUID) as total from tblchild c 
		inner join tblpregnant_woman pw 
		on c.pw_GUID = pw.PWGUID
		INNER JOIN tblhhfamilymember fm ON
		c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		fm.HHSurveyGUID = h.HHSurveyGUID
		where TIMESTAMPDIFF(MONTH, c.child_dob, CURRENT_TIMESTAMP) = 36 and pw.IsDeleted = 0 and c.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}


		$query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
		if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
		{
			$state_code = $this->loginData->state_code;
			$query .= " and state_code = '$state_code'";	
		}
		else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code'";	
		}
		else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$block_code = $this->loginData->block_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
		}
		$query .= " and user_mode= 1)";

		return $this->get_proportion($query);

	}

	public function trend_children_36_months_vitamin_a5()
	{

		$query = "SELECT concat(MONTHNAME(c.child_dob), ' - ', YEAR(c.child_dob)) as label, YEAR(c.child_dob) as year, MONTH(c.child_dob) as month, count(c.childGUID) as total from tblchild c 
		inner join tblpregnant_woman pw 
		on c.pw_GUID = pw.PWGUID
		INNER JOIN tblhhfamilymember fm ON
		c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		fm.HHSurveyGUID = h.HHSurveyGUID
		where  c.VitaminA5 is not null
		and TIMESTAMPDIFF(MONTH, c.child_dob, CURRENT_TIMESTAMP) >= 36 and pw.IsDeleted = 0 and c.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= " group by MONTH(c.child_dob) order by year, month";
		
		$trend_result =  $this->db->query($query)->result();

		if ($this->filter_data['date_from'] == NULL || $this->filter_data['date_to'] == NULL) {
			$this->filter_data['date_from'] = date("Y-m-d", strtotime("-1 year", time()));
			$this->filter_data['date_to'] = date("Y-m-d");
		}

		$query = "call fillmonths(?, ?)";
		$month_result = $this->db->query($query, [$this->filter_data['date_from'], $this->filter_data['date_to']])->result();

		$month_result = json_decode(json_encode($month_result), TRUE);
		$trend_result = json_decode(json_encode($trend_result), TRUE);

		$final_array = $this->left_join_array($month_result, $trend_result, 'label');

		$query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
		if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
		{
			$state_code = $this->loginData->state_code;
			$query .= " and state_code = '$state_code'";	
		}
		else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code'";	
		}
		else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$block_code = $this->loginData->block_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
		}
		$query .= " and user_mode= 1)";

		return $final_array;

	}

	/**
	 * Married women section start
	 */


	public function married_no_child()
	{

		$query = "SELECT count(*) as total from tblpregnant_woman pw
		INNER JOIN tblhhfamilymember fm 
		on
		pw.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		inner join tblhhsurvey h 
		on fm.HHSurveyGUID = h.HHSurveyGUID
		where pw.IsPregnant=1 and pw.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0
		and TIMESTAMPDIFF(MONTH, pw.LMPDate, CURRENT_TIMESTAMP) < 10";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and pw.LMPDate > '" . $this->filter_data['date_from'] . "' and pw.LMPDate < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and pw.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and pw.AshaID = " . $this->filter_data['Asha'];
		}
		
		$query .= " and pw.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
		if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
		{
			$state_code = $this->loginData->state_code;
			$query .= " and state_code = '$state_code'";	
		}
		else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code'";	
		}
		else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$block_code = $this->loginData->block_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
		}
		$query .= " and user_mode= 1)";

		return $this->db->query($query)->result()[0]->total;
	}

	public function get_anm_name_by_id($anmid = NULL)
	{
		$this->db->where('ANMID', $anmid);
		$this->db->where('LanguageID', 1);
		$anm_result = $this->db->get('mstanm')->result();
		if (count($anm_result) < 1) {
			return '';
		}

		return $anm_result[0]->ANMName;
	}

	public function get_asha_name_by_id($ashaid = NULL)
	{
		$this->db->where('ASHAID', $ashaid);
		$this->db->where('LanguageID', 1);
		$anm_result = $this->db->get('mstasha')->result();
		if (count($anm_result) < 1) {
			return '';
		}

		return $anm_result[0]->ASHAName;
	}


	public function get_currently_married_woman()
	{
		$query = "select
		COUNT(*) AS total
		FROM
		tblhhfamilymember a
		inner join tblhhsurvey b
		on a.HHSurveyGUID = b.HHSurveyGUID
		WHERE
		a.GenderID = 2 AND a.IsDeleted = 0 and b.IsDeleted = 0 AND a.MaritialStatusID = 1
		and
		(
			CASE
			WHEN a.DOBAvailable = 2 THEN a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear)
			WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(YEAR, a.DateOfBirth,CURRENT_DATE) END
		) >= 15 and
		(
			CASE
			WHEN a.DOBAvailable = 2 THEN a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear)
			WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(YEAR, a.DateOfBirth,CURRENT_DATE) END
		) <=49";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and a.CreatedOn > '" . $this->filter_data['date_from'] . "' and a.CreatedOn < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and a.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and a.AshaID = " . $this->filter_data['Asha'];
		}

		$query .= " and a.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
		if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
		{
			$state_code = $this->loginData->state_code;
			$query .= " and state_code = '$state_code'";	
		}
		else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code'";	
		}
		else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$block_code = $this->loginData->block_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
		}
		$query .= " and user_mode= 1)";
		// print_r($query);die();

		return $this->db->query($query)->result()[0]->total;
	}


	public function get_woman_with_no_child()
	{
		$query = " select
		a.total - b.total  AS total
		FROM
		(
			SELECT
			COUNT(*) AS total,
			1
			FROM
			tblhhfamilymember a
			INNER JOIN tblhhsurvey b ON
			a.HHSurveyGUID = b.HHSurveyGUID
			WHERE
			a.GenderID = 2 AND a.IsDeleted = 0 AND b.IsDeleted = 0 AND a.MaritialStatusID = 1 AND(
				CASE WHEN a.DOBAvailable = 2 THEN a.AprilAgeYear +(
					YEAR(CURRENT_DATE) - a.AgeAsOnYear
				) WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(
					YEAR,
					a.DateOfBirth,
					CURRENT_DATE
				)
				END
			) >= 15 AND(
				CASE WHEN a.DOBAvailable = 2 THEN a.AprilAgeYear +(
					YEAR(CURRENT_DATE) - a.AgeAsOnYear
				) WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(
					YEAR,
					a.DateOfBirth,
					CURRENT_DATE
				)
				END
			) <= 49 ";
			if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
			{
				$query .= " and a.CreatedOn > '" . $this->filter_data['date_from'] . "' and a.CreatedOn < '" . $this->filter_data['date_to'] . "'";
			}

			if ($this->filter_data['ANM'] != NULL) 
			{
				$query .= " and a.ANMID = " . $this->filter_data['ANM'];
			}

			if ($this->filter_data['Asha'] != NULL) 
			{
				$query .= " and a.AshaID = " . $this->filter_data['Asha'];
			}

			$query .= " and a.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
			if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
			{
				$state_code = $this->loginData->state_code;
				$query .= " and state_code = '$state_code'";	
			}
			else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
			{
				$state_code = $this->loginData->state_code;
				$district_code = $this->loginData->district_code;
				$query .= " and state_code = '$state_code' and district_code='$district_code'";	
			}
			else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
			{
				$state_code = $this->loginData->state_code;
				$district_code = $this->loginData->district_code;
				$block_code = $this->loginData->block_code;
				$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
			}
			$query .= " and user_mode= 1)";
			$query .= ") a 

			INNER JOIN(
				SELECT COUNT(*) AS total,
				1
				FROM
				(
					SELECT
					COUNT(*) AS total, 1
					FROM
					tblhhfamilymember m
					INNER JOIN tblhhsurvey h ON
					h.HHSurveyGUID = m.HHSurveyGUID
					INNER JOIN tblchild c ON
					m.HHFamilyMemberGUID = c.HHFamilyMemberGUID
					WHERE
					m.MaritialStatusID = 1 AND m.GenderID = 2 AND m.IsDeleted = 0 AND c.IsDeleted = 0 AND h.IsDeleted = 0 AND(
						CASE WHEN m.DOBAvailable = 2 THEN m.AprilAgeYear +(
							YEAR(CURRENT_DATE) - m.AgeAsOnYear
						) WHEN m.DOBAvailable = 1 THEN TIMESTAMPDIFF(
							YEAR,
							m.DateOfBirth,
							CURRENT_DATE
						)
						END
					) >= 15 AND(
						CASE WHEN m.DOBAvailable = 2 THEN m.AprilAgeYear +(
							YEAR(CURRENT_DATE) - m.AgeAsOnYear
						) WHEN m.DOBAvailable = 1 THEN TIMESTAMPDIFF(
							YEAR,
							m.DateOfBirth,
							CURRENT_DATE
						)
						END
					) <= 49 ";
					if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
					{
						$query .= " and m.CreatedOn > '" . $this->filter_data['date_from'] . "' and m.CreatedOn < '" . $this->filter_data['date_to'] . "'";
					}

					if ($this->filter_data['ANM'] != NULL) 
					{
						$query .= " and m.ANMID = " . $this->filter_data['ANM'];
					}

					if ($this->filter_data['Asha'] != NULL) 
					{
						$query .= " and m.AshaID = " . $this->filter_data['Asha'];
					}

					$query .= " and m.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
					if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
					{
						$state_code = $this->loginData->state_code;
						$query .= " and state_code = '$state_code'";	
					}
					else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
					{
						$state_code = $this->loginData->state_code;
						$district_code = $this->loginData->district_code;
						$query .= " and state_code = '$state_code' and district_code='$district_code'";	
					}
					else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
					{
						$state_code = $this->loginData->state_code;
						$district_code = $this->loginData->district_code;
						$block_code = $this->loginData->block_code;
						$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
					}
					$query .= " and user_mode= 1)";
					$query.=  " GROUP BY
					c.HHFamilyMemberGUID
					HAVING
					COUNT(*) >= 1
				) a
			) b
			ON
			a.1 = b.1";
// die($query);

			return $this->db->query($query)->result()[0]->total;
		}


// public function get_woman_with_no_child()
// {
// 	$query = "select
// 	COUNT(*) AS total
// 	FROM
// 	tblhhfamilymember a
// 	inner join tblhhsurvey b
// 	on a.HHSurveyGUID = b.HHSurveyGUID
// 	WHERE
// 	a.GenderID = 2 AND a.IsDeleted = 0 and b.IsDeleted = 0 AND a.MaritialStatusID = 1
// 	and
// 	(
// 		CASE
// 		WHEN a.DOBAvailable = 2 THEN a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear)
// 		WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(YEAR, a.DateOfBirth,CURRENT_DATE) END
// 	) >= 15 and
// 	(
// 		CASE
// 		WHEN a.DOBAvailable = 2 THEN a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear)
// 		WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(YEAR, a.DateOfBirth,CURRENT_DATE) END
// 	) <=49 
// 	and a.HHFamilyMemberGUID not in (select HHFamilyMemberGUID from tblchild where IsDeleted=0)

// 	";

// 	if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
// 	{
// 		$query .= " and a.CreatedOn > '" . $this->filter_data['date_from'] . "' and a.CreatedOn < '" . $this->filter_data['date_to'] . "'";
// 	}

// 	if ($this->filter_data['ANM'] != NULL) 
// 	{
// 		$query .= " and a.ANMID = " . $this->filter_data['ANM'];
// 	}

// 	if ($this->filter_data['Asha'] != NULL) 
// 	{
// 		$query .= " and a.AshaID = " . $this->filter_data['Asha'];
// 	}

// 	$query .= " and a.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
// 	if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
// 	{
// 		$state_code = $this->loginData->state_code;
// 		$query .= " and state_code = '$state_code'";	
// 	}
// 	else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
// 	{
// 		$state_code = $this->loginData->state_code;
// 		$district_code = $this->loginData->district_code;
// 		$query .= " and state_code = '$state_code' and district_code='$district_code'";	
// 	}
// 	else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
// 	{
// 		$state_code = $this->loginData->state_code;
// 		$district_code = $this->loginData->district_code;
// 		$block_code = $this->loginData->block_code;
// 		$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
// 	}
// 	$query .= " and user_mode= 1)";
// 		// print_r($query);die();

// 	return $this->db->query($query)->result()[0]->total;
// }

	// SELECT count(*) as total FROM tblhhfamilymember m 
	// 	INNER join tblhhsurvey s
	// 	on 
	// 	m.HHSurveyGUID = s.HHSurveyGUID
	// 	where m.GenderID=2 and m.MaritialStatusID=1  and   m.HHFamilyMemberGUID not in(SELECT HHFamilyMemberGUID from tblchild where IsDeleted = 0) and m.IsDeleted = 0 and s.IsDeleted = 0


		public function get_woman_with_1_child()
		{
			$query = " select
			COUNT(*) AS total
			FROM
			(
				SELECT
				COUNT(*) AS total
				FROM
				tblhhfamilymember m
				INNER JOIN tblhhsurvey h ON
				h.HHSurveyGUID = m.HHSurveyGUID
				INNER JOIN tblchild c ON
				m.HHFamilyMemberGUID = c.HHFamilyMemberGUID
				WHERE
				m.MaritialStatusID = 1 AND m.GenderID = 2 AND m.IsDeleted = 0 AND c.IsDeleted = 0 and h.IsDeleted = 0
				and
				(
					CASE
					WHEN m.DOBAvailable = 2 THEN m.AprilAgeYear + (YEAR(CURRENT_DATE) - m.AgeAsOnYear)
					WHEN m.DOBAvailable = 1 THEN TIMESTAMPDIFF(YEAR, m.DateOfBirth, CURRENT_DATE) END
				) >= 15 and
				(
					CASE
					WHEN m.DOBAvailable = 2 THEN m.AprilAgeYear + (YEAR(CURRENT_DATE) - m.AgeAsOnYear)
					WHEN m.DOBAvailable = 1 THEN TIMESTAMPDIFF(YEAR, m.DateOfBirth, CURRENT_DATE) END
				) <=49 ";

				if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
				{
					$query .= " and m.CreatedOn > '" . $this->filter_data['date_from'] . "' and m.CreatedOn < '" . $this->filter_data['date_to'] . "'";
				}

				if ($this->filter_data['ANM'] != NULL) 
				{
					$query .= " and m.ANMID = " . $this->filter_data['ANM'];
				}

				if ($this->filter_data['Asha'] != NULL) 
				{
					$query .= " and m.AshaID = " . $this->filter_data['Asha'];
				}

				$query .= " and m.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
				if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
				{
					$state_code = $this->loginData->state_code;
					$query .= " and state_code = '$state_code'";	
				}
				else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
				{
					$state_code = $this->loginData->state_code;
					$district_code = $this->loginData->district_code;
					$query .= " and state_code = '$state_code' and district_code='$district_code'";	
				}
				else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
				{
					$state_code = $this->loginData->state_code;
					$district_code = $this->loginData->district_code;
					$block_code = $this->loginData->block_code;
					$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
				}
				$query .= " and user_mode= 1)";

				$query .= " GROUP by c.HHFamilyMemberGUID HAVING COUNT(*)=1 )a";

		// die($query);
				return $this->db->query($query)->result()[0]->total;
			}


			public function get_woman_with_2_child()
			{
				$query = " select
				COUNT(*) AS total
				FROM
				(
					SELECT
					COUNT(*) AS total
					FROM
					tblhhfamilymember m
					INNER JOIN tblhhsurvey h ON
					h.HHSurveyGUID = m.HHSurveyGUID
					INNER JOIN tblchild c ON
					m.HHFamilyMemberGUID = c.HHFamilyMemberGUID
					WHERE
					m.MaritialStatusID = 1 AND m.GenderID = 2 AND m.IsDeleted = 0 AND c.IsDeleted = 0 and h.IsDeleted = 0
					and
					(
						CASE
						WHEN m.DOBAvailable = 2 THEN m.AprilAgeYear + (YEAR(CURRENT_DATE) - m.AgeAsOnYear)
						WHEN m.DOBAvailable = 1 THEN TIMESTAMPDIFF(YEAR, m.DateOfBirth, CURRENT_DATE) END
					) >= 15 and
					(
						CASE
						WHEN m.DOBAvailable = 2 THEN m.AprilAgeYear + (YEAR(CURRENT_DATE) - m.AgeAsOnYear)
						WHEN m.DOBAvailable = 1 THEN TIMESTAMPDIFF(YEAR, m.DateOfBirth, CURRENT_DATE) END
					) <=49 ";

					if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
					{
						$query .= " and m.CreatedOn > '" . $this->filter_data['date_from'] . "' and m.CreatedOn < '" . $this->filter_data['date_to'] . "'";
					}

					if ($this->filter_data['ANM'] != NULL) 
					{
						$query .= " and m.ANMID = " . $this->filter_data['ANM'];
					}

					if ($this->filter_data['Asha'] != NULL) 
					{
						$query .= " and m.AshaID = " . $this->filter_data['Asha'];
					}

					$query .= " and m.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
					if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
					{
						$state_code = $this->loginData->state_code;
						$query .= " and state_code = '$state_code'";	
					}
					else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
					{
						$state_code = $this->loginData->state_code;
						$district_code = $this->loginData->district_code;
						$query .= " and state_code = '$state_code' and district_code='$district_code'";	
					}
					else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
					{
						$state_code = $this->loginData->state_code;
						$district_code = $this->loginData->district_code;
						$block_code = $this->loginData->block_code;
						$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
					}
					$query .= " and user_mode= 1)";

					$query .= " GROUP by c.HHFamilyMemberGUID HAVING COUNT(*)=2 )a";

		// die($query);
					return $this->db->query($query)->result()[0]->total;
				}

				public function get_woman_with_3_child()
				{
					$query = " select
					COUNT(*) AS total
					FROM
					(
						SELECT
						COUNT(*) AS total
						FROM
						tblhhfamilymember m
						INNER JOIN tblhhsurvey h ON
						h.HHSurveyGUID = m.HHSurveyGUID
						INNER JOIN tblchild c ON
						m.HHFamilyMemberGUID = c.HHFamilyMemberGUID
						WHERE
						m.MaritialStatusID = 1 AND m.GenderID = 2 AND m.IsDeleted = 0 AND c.IsDeleted = 0 and h.IsDeleted = 0
						and
						(
							CASE
							WHEN m.DOBAvailable = 2 THEN m.AprilAgeYear + (YEAR(CURRENT_DATE) - m.AgeAsOnYear)
							WHEN m.DOBAvailable = 1 THEN TIMESTAMPDIFF(YEAR, m.DateOfBirth,CURRENT_DATE) END
						) >= 15 and
						(
							CASE
							WHEN m.DOBAvailable = 2 THEN m.AprilAgeYear + (YEAR(CURRENT_DATE) - m.AgeAsOnYear)
							WHEN m.DOBAvailable = 1 THEN TIMESTAMPDIFF(YEAR, m.DateOfBirth,CURRENT_DATE) END
						) <=49 ";

						if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
						{
							$query .= " and m.CreatedOn > '" . $this->filter_data['date_from'] . "' and m.CreatedOn < '" . $this->filter_data['date_to'] . "'";
						}

						if ($this->filter_data['ANM'] != NULL) 
						{
							$query .= " and m.ANMID = " . $this->filter_data['ANM'];
						}

						if ($this->filter_data['Asha'] != NULL) 
						{
							$query .= " and m.AshaID = " . $this->filter_data['Asha'];
						}

						$query .= " and m.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
						if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
						{
							$state_code = $this->loginData->state_code;
							$query .= " and state_code = '$state_code'";	
						}
						else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
						{
							$state_code = $this->loginData->state_code;
							$district_code = $this->loginData->district_code;
							$query .= " and state_code = '$state_code' and district_code='$district_code'";	
						}
						else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
						{
							$state_code = $this->loginData->state_code;
							$district_code = $this->loginData->district_code;
							$block_code = $this->loginData->block_code;
							$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
						}
						$query .= " and user_mode= 1)";

						$query .= " GROUP by c.HHFamilyMemberGUID HAVING COUNT(*)>=3 )a";

		// die($query);
						return $this->db->query($query)->result()[0]->total;
					}

					public function get_currently_pregnent_women()
					{
		// $query = "select count(*) as total from tblpregnant_woman m where m.IsPregnant = 1 and m.IsDeleted = 0";

						$query = "select count(*) as total from tblpregnant_woman m 
						INNER JOIN tblhhfamilymember fm 
						on
						m.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
						INNER JOIN tblhhsurvey h ON
						h.HHSurveyGUID = fm.HHSurveyGUID
						where
						m.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0 AND m.IsPregnant = 1
						AND TIMESTAMPDIFF(
							DAY,
							m.LMPDate,
							CURRENT_TIMESTAMP
						) > 0 
						";
						if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
						{
							$query .= " and fm.CreatedOn > '" . $this->filter_data['date_from'] . "' and fm.CreatedOn < '" . $this->filter_data['date_to'] . "'";
						}

						if ($this->filter_data['ANM'] != NULL) 
						{
							$query .= " and fm.ANMID = " . $this->filter_data['ANM'];
						}

						if ($this->filter_data['Asha'] != NULL) 
						{
							$query .= " and fm.AshaID = " . $this->filter_data['Asha'];
						}

						$query .= " and fm.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
						if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
						{
							$state_code = $this->loginData->state_code;
							$query .= " and state_code = '$state_code'";	
						}
						else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
						{
							$state_code = $this->loginData->state_code;
							$district_code = $this->loginData->district_code;
							$query .= " and state_code = '$state_code' and district_code='$district_code'";	
						}
						else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
						{
							$state_code = $this->loginData->state_code;
							$district_code = $this->loginData->district_code;
							$block_code = $this->loginData->block_code;
							$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
						}
						$query .= " and user_mode= 1)";



						return $this->db->query($query)->result()[0]->total;

					}

					public function get_pregnant_woman_with_no_child()
					{
						$query = "SELECT
						a.total - b.total AS total
						FROM
						(
						SELECT
						COUNT(*) AS total,
						1
						FROM
						tblpregnant_woman m
						INNER JOIN tblhhfamilymember fm ON
						m.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
						INNER JOIN tblhhsurvey h ON
						h.HHSurveyGUID = fm.HHSurveyGUID
						WHERE
						m.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0 AND m.IsPregnant = 1 AND TIMESTAMPDIFF(
						DAY,
						m.LMPDate,
						CURRENT_TIMESTAMP
					) > 0  ";
					if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
					{
						$query .= " and fm.CreatedOn > '" . $this->filter_data['date_from'] . "' and fm.CreatedOn < '" . $this->filter_data['date_to'] . "'";
					}

					if ($this->filter_data['ANM'] != NULL) 
					{
						$query .= " and fm.ANMID = " . $this->filter_data['ANM'];
					}

					if ($this->filter_data['Asha'] != NULL) 
					{
						$query .= " and fm.AshaID = " . $this->filter_data['Asha'];
					}

					$query .= " and fm.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
					if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
					{
						$state_code = $this->loginData->state_code;
						$query .= " and state_code = '$state_code'";	
					}
					else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
					{
						$state_code = $this->loginData->state_code;
						$district_code = $this->loginData->district_code;
						$query .= " and state_code = '$state_code' and district_code='$district_code'";	
					}
					else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
					{
						$state_code = $this->loginData->state_code;
						$district_code = $this->loginData->district_code;
						$block_code = $this->loginData->block_code;
						$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
					}
					$query .= " and user_mode= 1)
				) a ";
				$query .=" INNER JOIN(
					SELECT COUNT(*) AS total,
					1
					FROM
					(
						SELECT
						COUNT(*) AS total
						FROM
						tblhhfamilymember m
						INNER JOIN tblpregnant_woman pw ON
						m.HHFamilyMemberGUID = pw.HHFamilyMemberGUID
						INNER JOIN tblchild c ON
						m.HHFamilyMemberGUID = c.HHFamilyMemberGUID
						WHERE
						m.MaritialStatusID = 1 AND m.GenderID = 2 AND pw.IsPregnant = 1 AND m.IsDeleted = 0 AND pw.IsDeleted = 0 AND c.IsDeleted = 0 AND(
							CASE WHEN m.DOBAvailable = 2 THEN m.AprilAgeYear +(
								YEAR(CURRENT_DATE) - m.AgeAsOnYear
							) WHEN m.DOBAvailable = 1 THEN TIMESTAMPDIFF(
								YEAR,
								m.DateOfBirth,
								CURRENT_DATE
							)
							END
						) >= 15 AND(
							CASE WHEN m.DOBAvailable = 2 THEN m.AprilAgeYear +(
								YEAR(CURRENT_DATE) - m.AgeAsOnYear
							) WHEN m.DOBAvailable = 1 THEN TIMESTAMPDIFF(
								YEAR,
								m.DateOfBirth,
								CURRENT_DATE
							)
							END
						) <= 49 ";
						if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
						{
							$query .= " and m.CreatedOn > '" . $this->filter_data['date_from'] . "' and m.CreatedOn < '" . $this->filter_data['date_to'] . "'";
						}

						if ($this->filter_data['ANM'] != NULL) 
						{
							$query .= " and m.ANMID = " . $this->filter_data['ANM'];
						}

						if ($this->filter_data['Asha'] != NULL) 
						{
							$query .= " and m.AshaID = " . $this->filter_data['Asha'];
						}

						$query .= " and m.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
						if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
						{
							$state_code = $this->loginData->state_code;
							$query .= " and state_code = '$state_code'";	
						}
						else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
						{
							$state_code = $this->loginData->state_code;
							$district_code = $this->loginData->district_code;
							$query .= " and state_code = '$state_code' and district_code='$district_code'";	
						}
						else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
						{
							$state_code = $this->loginData->state_code;
							$district_code = $this->loginData->district_code;
							$block_code = $this->loginData->block_code;
							$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
						}
						$query .= " and user_mode= 1)";


						$query .= " GROUP by c.HHFamilyMemberGUID HAVING COUNT(*)>=1 )a 
					) b
					ON
					a.1 = b.1";
	// die($query);

					return $this->db->query($query)->result()[0]->total;
				}

		// 		public function get_pregnant_woman_with_no_child1()
		// 		{
		// 			$query = "select
		// 			COUNT(*) AS total
		// 			FROM
		// 			tblhhfamilymember a
		// 			inner join tblpregnant_woman b
		// 			on a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
		// 			WHERE 
		// 			a.IsDeleted = 0 and b.IsDeleted = 0 AND b.IsPregnant = 1
		// 			and
		// 			(
		// 				CASE
		// 				WHEN a.DOBAvailable = 2 THEN a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear)
		// 				WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(YEAR, a.DateOfBirth,CURRENT_DATE) END
		// 			) >= 15 and
		// 			(
		// 				CASE
		// 				WHEN a.DOBAvailable = 2 THEN a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear)
		// 				WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(YEAR, a.DateOfBirth,CURRENT_DATE) END
		// 			) <=49 
		// 			and a.HHFamilyMemberGUID not in (select HHFamilyMemberGUID from tblchild where IsDeleted=0)
		// 			";

		// 			if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		// 			{
		// 				$query .= " and a.CreatedOn > '" . $this->filter_data['date_from'] . "' and a.CreatedOn < '" . $this->filter_data['date_to'] . "'";
		// 			}

		// 			if ($this->filter_data['ANM'] != NULL) 
		// 			{
		// 				$query .= " and a.ANMID = " . $this->filter_data['ANM'];
		// 			}

		// 			if ($this->filter_data['Asha'] != NULL) 
		// 			{
		// 				$query .= " and a.AshaID = " . $this->filter_data['Asha'];
		// 			}

		// 			$query .= " and a.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
		// 			if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
		// 			{
		// 				$state_code = $this->loginData->state_code;
		// 				$query .= " and state_code = '$state_code'";	
		// 			}
		// 			else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
		// 			{
		// 				$state_code = $this->loginData->state_code;
		// 				$district_code = $this->loginData->district_code;
		// 				$query .= " and state_code = '$state_code' and district_code='$district_code'";	
		// 			}
		// 			else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
		// 			{
		// 				$state_code = $this->loginData->state_code;
		// 				$district_code = $this->loginData->district_code;
		// 				$block_code = $this->loginData->block_code;
		// 				$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
		// 			}
		// 			$query .= " and user_mode= 1)";
		// // die($query);
		// 			return $this->db->query($query)->result()[0]->total;
		// 		}

				public function get_pregnant_woman_with_1_child()
				{
					$query = "select count(*) as total FROM 
					(
						select count(*) as total 
						from
						tblhhfamilymember m  
						inner join 
						tblpregnant_woman pw 
						on m.HHFamilyMemberGUID = pw.HHFamilyMemberGUID
						inner join
						tblchild c on m.HHFamilyMemberGUID=c.HHFamilyMemberGUID
						WHERE m.MaritialStatusID = 1 and m.GenderID = 2 and pw.IsPregnant = 1 and m.IsDeleted = 0 and pw.IsDeleted = 0 and c.IsDeleted = 0
						and
						(
							CASE
							WHEN m.DOBAvailable = 2 THEN m.AprilAgeYear + (YEAR(CURRENT_DATE) - m.AgeAsOnYear)
							WHEN m.DOBAvailable = 1 THEN TIMESTAMPDIFF(YEAR, m.DateOfBirth,CURRENT_DATE) END
						) >= 15 and
						(
							CASE
							WHEN m.DOBAvailable = 2 THEN m.AprilAgeYear + (YEAR(CURRENT_DATE) - m.AgeAsOnYear)
							WHEN m.DOBAvailable = 1 THEN TIMESTAMPDIFF(YEAR, m.DateOfBirth,CURRENT_DATE) END
						) <=49";

						if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
						{
							$query .= " and m.CreatedOn > '" . $this->filter_data['date_from'] . "' and m.CreatedOn < '" . $this->filter_data['date_to'] . "'";
						}

						if ($this->filter_data['ANM'] != NULL) 
						{
							$query .= " and m.ANMID = " . $this->filter_data['ANM'];
						}

						if ($this->filter_data['Asha'] != NULL) 
						{
							$query .= " and m.AshaID = " . $this->filter_data['Asha'];
						}

						$query .= " and m.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
						if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
						{
							$state_code = $this->loginData->state_code;
							$query .= " and state_code = '$state_code'";	
						}
						else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
						{
							$state_code = $this->loginData->state_code;
							$district_code = $this->loginData->district_code;
							$query .= " and state_code = '$state_code' and district_code='$district_code'";	
						}
						else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
						{
							$state_code = $this->loginData->state_code;
							$district_code = $this->loginData->district_code;
							$block_code = $this->loginData->block_code;
							$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
						}
						$query .= " and user_mode= 1)";

						$query .= " GROUP by c.HHFamilyMemberGUID HAVING COUNT(*)=1 )a";

		// die($query);
						return $this->db->query($query)->result()[0]->total;
					}

					public function get_pregnant_woman_with_2_child()
					{
						$query = "select count(*) as total FROM 
						(
							select count(*) as total 
							from
							tblhhfamilymember m  
							inner join 
							tblpregnant_woman pw 
							on m.HHFamilyMemberGUID = pw.HHFamilyMemberGUID
							inner join
							tblchild c on m.HHFamilyMemberGUID=c.HHFamilyMemberGUID
							WHERE m.MaritialStatusID = 1 and m.GenderID = 2 and pw.IsPregnant = 1 and m.IsDeleted = 0 and pw.IsDeleted = 0 and c.IsDeleted = 0
							and
							(
								CASE
								WHEN m.DOBAvailable = 2 THEN m.AprilAgeYear + (YEAR(CURRENT_DATE) - m.AgeAsOnYear)
								WHEN m.DOBAvailable = 1 THEN TIMESTAMPDIFF(YEAR, m.DateOfBirth,CURRENT_DATE) END
							) >= 15 and
							(
								CASE
								WHEN m.DOBAvailable = 2 THEN m.AprilAgeYear + (YEAR(CURRENT_DATE) - m.AgeAsOnYear)
								WHEN m.DOBAvailable = 1 THEN TIMESTAMPDIFF(YEAR, m.DateOfBirth,CURRENT_DATE) END
							) <=49";

							if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
							{
								$query .= " and m.CreatedOn > '" . $this->filter_data['date_from'] . "' and m.CreatedOn < '" . $this->filter_data['date_to'] . "'";
							}

							if ($this->filter_data['ANM'] != NULL) 
							{
								$query .= " and m.ANMID = " . $this->filter_data['ANM'];
							}

							if ($this->filter_data['Asha'] != NULL) 
							{
								$query .= " and m.AshaID = " . $this->filter_data['Asha'];
							}

							$query .= " and m.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
							if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
							{
								$state_code = $this->loginData->state_code;
								$query .= " and state_code = '$state_code'";	
							}
							else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
							{
								$state_code = $this->loginData->state_code;
								$district_code = $this->loginData->district_code;
								$query .= " and state_code = '$state_code' and district_code='$district_code'";	
							}
							else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
							{
								$state_code = $this->loginData->state_code;
								$district_code = $this->loginData->district_code;
								$block_code = $this->loginData->block_code;
								$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
							}
							$query .= " and user_mode= 1)";

							$query .= " GROUP by c.HHFamilyMemberGUID HAVING COUNT(*)=2 )a";

		// die($query);
							return $this->db->query($query)->result()[0]->total;
						}


						public function get_pregnant_woman_with_3_child()
						{
							$query = "select count(*) as total FROM 
							(
								select count(*) as total 
								from
								tblhhfamilymember m  
								inner join 
								tblpregnant_woman pw 
								on m.HHFamilyMemberGUID = pw.HHFamilyMemberGUID
								inner join
								tblchild c on m.HHFamilyMemberGUID=c.HHFamilyMemberGUID
								WHERE m.MaritialStatusID = 1 and m.GenderID = 2 and pw.IsPregnant = 1 and m.IsDeleted = 0 and pw.IsDeleted = 0 and c.IsDeleted = 0
								and
								(
									CASE
									WHEN m.DOBAvailable = 2 THEN m.AprilAgeYear + (YEAR(CURRENT_DATE) - m.AgeAsOnYear)
									WHEN m.DOBAvailable = 1 THEN TIMESTAMPDIFF(YEAR, m.DateOfBirth,CURRENT_DATE) END
								) >= 15 and
								(
									CASE
									WHEN m.DOBAvailable = 2 THEN m.AprilAgeYear + (YEAR(CURRENT_DATE) - m.AgeAsOnYear)
									WHEN m.DOBAvailable = 1 THEN TIMESTAMPDIFF(YEAR, m.DateOfBirth,CURRENT_DATE) END
								) <=49";

								if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
								{
									$query .= " and m.CreatedOn > '" . $this->filter_data['date_from'] . "' and m.CreatedOn < '" . $this->filter_data['date_to'] . "'";
								}

								if ($this->filter_data['ANM'] != NULL) 
								{
									$query .= " and m.ANMID = " . $this->filter_data['ANM'];
								}

								if ($this->filter_data['Asha'] != NULL) 
								{
									$query .= " and m.AshaID = " . $this->filter_data['Asha'];
								}

								$query .= " and m.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
								if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
								{
									$state_code = $this->loginData->state_code;
									$query .= " and state_code = '$state_code'";	
								}
								else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
								{
									$state_code = $this->loginData->state_code;
									$district_code = $this->loginData->district_code;
									$query .= " and state_code = '$state_code' and district_code='$district_code'";	
								}
								else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
								{
									$state_code = $this->loginData->state_code;
									$district_code = $this->loginData->district_code;
									$block_code = $this->loginData->block_code;
									$query .= " and state_code = '$state_code' and district_code='$district_code' and block_code='$block_code'";	
								}
								$query .= " and user_mode= 1)";


								$query .= " GROUP by c.HHFamilyMemberGUID HAVING COUNT(*)>=3 )a";

		// die($query);
								return $this->db->query($query)->result()[0]->total;
							}


						}
