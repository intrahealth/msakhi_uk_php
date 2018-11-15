<?php


class Mnch_dashboard_model extends CI_Model 
{
	private $filter_data;

	public function __construct()
	{
		parent:: __construct();
		$this->filter_data = $this->session->userdata("filter_data");
		/*echo "<pre>";
		print_r($this->filter_data);exit();die();*/
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
		if ($this->loginData->user_role == 5) {

			if ($this->filter_data['StateCode'] != NULL) 
			{
				$query .= " and state_code = " . $this->filter_data['StateCode'];
			}

			// if ($this->filter_data['district_code'] != NULL) 
			// {
			// 	$query .= " and district_code = " . $this->filter_data['district_code'];
			// }

			// if ($this->filter_data['block_code'] != NULL) 
			// {
			// 	$query .= " and block_code = " . $this->filter_data['block_code'];
			// }

		}
		if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
		{
			$state_code = $this->loginData->state_code;
			$query .= " and state_code = '$state_code'";

			if ($this->filter_data['district_code'] != NULL) 
			{
				$query .= " and district_code = " . $this->filter_data['district_code'];
			}

			if ($this->filter_data['block_code'] != NULL) 
			{
				$query .= " and block_code = " . $this->filter_data['block_code'];
			}

		}
		else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$query .= " and state_code = '$state_code' and district_code='$district_code'";

			if ($this->filter_data['block_code'] != NULL) 
			{
				$query .= " and block_code = " . $this->filter_data['block_code'];
			}

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
		if ($this->loginData->user_role == 5) {

			if ($this->filter_data['StateCode'] != NULL) 
			{
				$query .= " and state_code = " . $this->filter_data['StateCode'];
			}

			// if ($this->filter_data['district_code'] != NULL) 
			// {
			// 	$query .= " and district_code = " . $this->filter_data['district_code'];
			// }

			// if ($this->filter_data['block_code'] != NULL) 
			// {
			// 	$query .= " and block_code = " . $this->filter_data['block_code'];
			// }

		}
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


	public function get_total_preg_women()
	{
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

					// print_r($query); die();

		return $this->db->query($query)->result()[0]->total;
	}


	public function get_child_0_to_1()
	{

		// $query = "SELECT 
		// COUNT(*) AS total
		// FROM
		// (SELECT 
		// TIMESTAMPDIFF(MONTH, child_dob, NOW()) AS ageInMonth, gender
		// FROM
		// tblchild c 
		// inner join tblhhsurvey h 
		// on c.HHGUID = h.HHSurveyGUID
		// where c.created_by in (select user_id from tblusers where user_mode = 1 and is_deleted = 0) and c.IsDeleted=0 and h.IsDeleted=0";

		// if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		// {
		// 	$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
		// }

		// if ($this->filter_data['ANM'] != NULL) 
		// {
		// 	$query .= " and c.ANMID = " . $this->filter_data['ANM'];
		// }

		// if ($this->filter_data['Asha'] != NULL) 
		// {
		// 	$query .= " and c.AshaID = " . $this->filter_data['Asha'];
		// }

		// $query .= " ) a
		// WHERE
		// a.ageInMonth >=0 AND a.ageInMonth <= 12";


		$query = "SELECT
		a.total as male,
		b.total as female,
		a.total + b.total as total FROM 
		( SELECT
		count(*) as total
		FROM
		tblhhfamilymember a
		INNER JOIN tblhhsurvey b ON
		a.HHSurveyGUID = b.HHSurveyGUID
		WHERE
		a.IsDeleted = 0 AND b.IsDeleted = 0 AND a.GenderID = 1 AND b.IsActive = 1 ";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and a.child_dob > '" . $this->filter_data['date_from'] . "' and a.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and a.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and a.AshaID = " . $this->filter_data['Asha'];
		}
		$query .="	and
		(
			CASE
			WHEN a.DOBAvailable = 2 THEN (a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear))*365
			WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(DAY, a.DateOfBirth,CURRENT_DATE) END
		) between 0 and 365 ) a

		INNER JOIN
		(
			SELECT
			count(*) as total
			FROM
			tblhhfamilymember a
			INNER JOIN tblhhsurvey b ON
			a.HHSurveyGUID = b.HHSurveyGUID
			WHERE
			a.IsDeleted = 0 AND b.IsDeleted = 0 AND a.GenderID = 2 AND b.IsActive = 1 ";

			if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
			{
				$query .= " and a.DateOfBirth > '" . $this->filter_data['date_from'] . "' and a.DateOfBirth < '" . $this->filter_data['date_to'] . "'";
			}

			if ($this->filter_data['ANM'] != NULL) 
			{
				$query .= " and a.ANMID = " . $this->filter_data['ANM'];
			}

			if ($this->filter_data['Asha'] != NULL) 
			{
				$query .= " and a.AshaID = " . $this->filter_data['Asha'];
			}
			$query .="	 
			and
			(
				CASE
				WHEN a.DOBAvailable = 2 THEN (a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear))*365
				WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(DAY, a.DateOfBirth,CURRENT_DATE) END
			) between 0 and 365    
		) b";

		// print_r($query);die();

		return $this->db->query($query)->result()[0]->total;

	}

	public function get_child_1_to_5()
	// {

	// 	$query = "SELECT 
	// 	COUNT(*) AS total
	// 	FROM
	// 	(SELECT 
	// 	TIMESTAMPDIFF(MONTH, child_dob, NOW()) AS ageInMonth, gender
	// 	FROM
	// 	tblchild c 
	// 	inner join tblhhsurvey h 
	// 	on c.HHGUID = h.HHSurveyGUID
	// 	where c.created_by in (select user_id from tblusers where user_mode = 1 and is_deleted = 0) and c.IsDeleted=0  and h.IsDeleted=0";

	// 	if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
	// 	{
	// 		$query .= " and c.child_dob > '" . $this->filter_data['date_from'] . "' and c.child_dob < '" . $this->filter_data['date_to'] . "'";
	// 	}

	// 	if ($this->filter_data['ANM'] != NULL) 
	// 	{
	// 		$query .= " and c.ANMID = " . $this->filter_data['ANM'];
	// 	}

	// 	if ($this->filter_data['Asha'] != NULL) 
	// 	{
	// 		$query .= " and c.AshaID = " . $this->filter_data['Asha'];
	// 	}

	// 	$query .= " ) a
	// 	WHERE
	// 	a.ageInMonth >=13 AND a.ageInMonth <= 60";

	// 	// print_r($query);die();

	// 	return $this->db->query($query)->result()[0]->total;

	// }


	{
		$query = "SELECT
		a.total as male,
		b.total as female,
		a.total + b.total as total FROM 
		( SELECT
		count(*) as total
		FROM
		tblhhfamilymember a
		INNER JOIN tblhhsurvey b ON
		a.HHSurveyGUID = b.HHSurveyGUID
		WHERE
		a.IsDeleted = 0 AND b.IsDeleted = 0 AND a.GenderID = 1 AND b.IsActive = 1 ";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and a.child_dob > '" . $this->filter_data['date_from'] . "' and a.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and a.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and a.AshaID = " . $this->filter_data['Asha'];
		}
		$query .="	and
		(
			CASE
			WHEN a.DOBAvailable = 2 THEN (a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear))*365
			WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(DAY, a.DateOfBirth,CURRENT_DATE) END
		) between 366 and 730 ) a

		INNER JOIN
		(
			SELECT
			count(*) as total
			FROM
			tblhhfamilymember a
			INNER JOIN tblhhsurvey b ON
			a.HHSurveyGUID = b.HHSurveyGUID
			WHERE
			a.IsDeleted = 0 AND b.IsDeleted = 0 AND a.GenderID = 2 AND b.IsActive = 1 ";

			if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
			{
				$query .= " and a.DateOfBirth > '" . $this->filter_data['date_from'] . "' and a.DateOfBirth < '" . $this->filter_data['date_to'] . "'";
			}

			if ($this->filter_data['ANM'] != NULL) 
			{
				$query .= " and a.ANMID = " . $this->filter_data['ANM'];
			}

			if ($this->filter_data['Asha'] != NULL) 
			{
				$query .= " and a.AshaID = " . $this->filter_data['Asha'];
			}
			$query .="	 
			and
			(
				CASE
				WHEN a.DOBAvailable = 2 THEN (a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear))*365
				WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(DAY, a.DateOfBirth,CURRENT_DATE) END
			) between 366 and 730    
		) b";

		// print_r($query);die();

		return $this->db->query($query)->result()[0]->total;
	}


	public function get_child_2_to_5()
	{
		$query = "SELECT
		a.total as male,
		b.total as female,
		a.total + b.total as total FROM 
		( SELECT
		count(*) as total
		FROM
		tblhhfamilymember a
		INNER JOIN tblhhsurvey b ON
		a.HHSurveyGUID = b.HHSurveyGUID
		WHERE
		a.IsDeleted = 0 AND b.IsDeleted = 0 AND a.GenderID = 1 AND b.IsActive = 1 ";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and a.child_dob > '" . $this->filter_data['date_from'] . "' and a.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and a.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and a.AshaID = " . $this->filter_data['Asha'];
		}
		$query .="	and
		(
			CASE
			WHEN a.DOBAvailable = 2 THEN (a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear))*365
			WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(DAY, a.DateOfBirth,CURRENT_DATE) END
		) between 731 and 1825 ) a

		INNER JOIN
		(
			SELECT
			count(*) as total
			FROM
			tblhhfamilymember a
			INNER JOIN tblhhsurvey b ON
			a.HHSurveyGUID = b.HHSurveyGUID
			WHERE
			a.IsDeleted = 0 AND b.IsDeleted = 0 AND a.GenderID = 2 AND b.IsActive = 1 ";

			if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
			{
				$query .= " and a.DateOfBirth > '" . $this->filter_data['date_from'] . "' and a.DateOfBirth < '" . $this->filter_data['date_to'] . "'";
			}

			if ($this->filter_data['ANM'] != NULL) 
			{
				$query .= " and a.ANMID = " . $this->filter_data['ANM'];
			}

			if ($this->filter_data['Asha'] != NULL) 
			{
				$query .= " and a.AshaID = " . $this->filter_data['Asha'];
			}
			$query .="	 
			and
			(
				CASE
				WHEN a.DOBAvailable = 2 THEN (a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear))*365
				WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(DAY, a.DateOfBirth,CURRENT_DATE) END
			) between 731 and 1825    
		) b";

		// print_r($query);die();

		return $this->db->query($query)->result();
	}


	public function get_child_6_to_14()
	{
		$query = "SELECT
		a.total as male,
		b.total as female,
		a.total + b.total as total FROM 
		( SELECT
		count(*) as total
		FROM
		tblhhfamilymember a
		INNER JOIN tblhhsurvey b ON
		a.HHSurveyGUID = b.HHSurveyGUID
		WHERE
		a.IsDeleted = 0 AND b.IsDeleted = 0 AND a.GenderID = 1 AND b.IsActive = 1 ";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and a.child_dob > '" . $this->filter_data['date_from'] . "' and a.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and a.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and a.AshaID = " . $this->filter_data['Asha'];
		}
		$query .="	and
		(
			CASE
			WHEN a.DOBAvailable = 2 THEN (a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear))*365
			WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(DAY, a.DateOfBirth,CURRENT_DATE) END
		) between 1826 and 5110 ) a

		INNER JOIN
		(
			SELECT
			count(*) as total
			FROM
			tblhhfamilymember a
			INNER JOIN tblhhsurvey b ON
			a.HHSurveyGUID = b.HHSurveyGUID
			WHERE
			a.IsDeleted = 0 AND b.IsDeleted = 0 AND a.GenderID = 2 AND b.IsActive = 1 ";

			if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
			{
				$query .= " and a.DateOfBirth > '" . $this->filter_data['date_from'] . "' and a.DateOfBirth < '" . $this->filter_data['date_to'] . "'";
			}

			if ($this->filter_data['ANM'] != NULL) 
			{
				$query .= " and a.ANMID = " . $this->filter_data['ANM'];
			}

			if ($this->filter_data['Asha'] != NULL) 
			{
				$query .= " and a.AshaID = " . $this->filter_data['Asha'];
			}
			$query .="	 
			and
			(
				CASE
				WHEN a.DOBAvailable = 2 THEN (a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear))*365
				WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(DAY, a.DateOfBirth,CURRENT_DATE) END
			) between 1826 and 5110    
		) b";

		// print_r($query);die();

		return $this->db->query($query)->result();
	}


	public function get_child_15_to_49()
	{
		$query = "SELECT
		a.total as male,
		b.total as female,
		a.total + b.total as total FROM 
		( SELECT
		count(*) as total
		FROM
		tblhhfamilymember a
		INNER JOIN tblhhsurvey b ON
		a.HHSurveyGUID = b.HHSurveyGUID
		WHERE
		a.IsDeleted = 0 AND b.IsDeleted = 0 AND a.GenderID = 1 AND b.IsActive = 1 ";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and a.child_dob > '" . $this->filter_data['date_from'] . "' and a.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and a.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and a.AshaID = " . $this->filter_data['Asha'];
		}
		$query .="	and
		(
			CASE
			WHEN a.DOBAvailable = 2 THEN (a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear))*365
			WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(DAY, a.DateOfBirth,CURRENT_DATE) END
		) between 5111 and 17885 ) a

		INNER JOIN
		(
			SELECT
			count(*) as total
			FROM
			tblhhfamilymember a
			INNER JOIN tblhhsurvey b ON
			a.HHSurveyGUID = b.HHSurveyGUID
			WHERE
			a.IsDeleted = 0 AND b.IsDeleted = 0 AND a.GenderID = 2 AND b.IsActive = 1 ";

			if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
			{
				$query .= " and a.DateOfBirth > '" . $this->filter_data['date_from'] . "' and a.DateOfBirth < '" . $this->filter_data['date_to'] . "'";
			}

			if ($this->filter_data['ANM'] != NULL) 
			{
				$query .= " and a.ANMID = " . $this->filter_data['ANM'];
			}

			if ($this->filter_data['Asha'] != NULL) 
			{
				$query .= " and a.AshaID = " . $this->filter_data['Asha'];
			}
			$query .="	 
			and
			(
				CASE
				WHEN a.DOBAvailable = 2 THEN (a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear))*365
				WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(DAY, a.DateOfBirth,CURRENT_DATE) END
			) between 5111 and 17885    
		) b";

		// print_r($query);die();

		return $this->db->query($query)->result();
	}


	public function get_child_50_and_more()
	{
		$query = "SELECT
		a.total as male,
		b.total as female,
		a.total + b.total as total FROM 
		( SELECT
		count(*) as total
		FROM
		tblhhfamilymember a
		INNER JOIN tblhhsurvey b ON
		a.HHSurveyGUID = b.HHSurveyGUID
		WHERE
		a.IsDeleted = 0 AND b.IsDeleted = 0 AND a.GenderID = 1 AND b.IsActive = 1 ";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and a.child_dob > '" . $this->filter_data['date_from'] . "' and a.child_dob < '" . $this->filter_data['date_to'] . "'";
		}

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and a.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and a.AshaID = " . $this->filter_data['Asha'];
		}
		$query .="	and
		(
			CASE
			WHEN a.DOBAvailable = 2 THEN (a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear))*365
			WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(DAY, a.DateOfBirth,CURRENT_DATE) END
		) between 17886 and 100000 ) a

		INNER JOIN
		(
			SELECT
			count(*) as total
			FROM
			tblhhfamilymember a
			INNER JOIN tblhhsurvey b ON
			a.HHSurveyGUID = b.HHSurveyGUID
			WHERE
			a.IsDeleted = 0 AND b.IsDeleted = 0 AND a.GenderID = 2 AND b.IsActive = 1 ";

			if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
			{
				$query .= " and a.DateOfBirth > '" . $this->filter_data['date_from'] . "' and a.DateOfBirth < '" . $this->filter_data['date_to'] . "'";
			}

			if ($this->filter_data['ANM'] != NULL) 
			{
				$query .= " and a.ANMID = " . $this->filter_data['ANM'];
			}

			if ($this->filter_data['Asha'] != NULL) 
			{
				$query .= " and a.AshaID = " . $this->filter_data['Asha'];
			}
			$query .="	 
			and
			(
				CASE
				WHEN a.DOBAvailable = 2 THEN (a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear))*365
				WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(DAY, a.DateOfBirth,CURRENT_DATE) END
			) between 17886 and 100000    
		) b";

		// print_r($query);die();

		return $this->db->query($query)->result();
	}



	public function get_preg_0_to_3()
	{
		$query = "SELECT
		COUNT(*) AS total
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
		) > 0 AND TIMESTAMPDIFF(
		DAY,
		m.LMPDate,
		CURRENT_TIMESTAMP
	) <= 90";

	if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
	{
		$query .= " and fm.CreatedOn > '" . $this->filter_data['date_from'] . "' and fm.CreatedOn < '" . $this->filter_data['date_to'] . "'";
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
// print_r($query);die();

	return $this->db->query($query)->result()[0]->total;
}


public function get_preg_4_to_6()
{
	$query = "SELECT
	COUNT(*) AS total
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
	) > 90 AND TIMESTAMPDIFF(
	DAY,
	m.LMPDate,
	CURRENT_TIMESTAMP
) <= 180";

if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
{
	$query .= " and fm.CreatedOn > '" . $this->filter_data['date_from'] . "' and fm.CreatedOn < '" . $this->filter_data['date_to'] . "'";
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
// print_r($query);die();

return $this->db->query($query)->result()[0]->total;
}



public function get_preg_7_to_8()
{
	$query = "SELECT
	COUNT(*) AS total
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
	) > 180 AND TIMESTAMPDIFF(
	DAY,
	m.LMPDate,
	CURRENT_TIMESTAMP
) < 270";


if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
{
	$query .= " and fm.CreatedOn > '" . $this->filter_data['date_from'] . "' and fm.CreatedOn < '" . $this->filter_data['date_to'] . "'";
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
// print_r($query);die();

return $this->db->query($query)->result()[0]->total;
}



public function get_9_and_more()
{
	$query = "SELECT
	COUNT(*) AS total
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
) >= 270";


if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
{
	$query .= " and fm.CreatedOn > '" . $this->filter_data['date_from'] . "' and fm.CreatedOn < '" . $this->filter_data['date_to'] . "'";
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
// print_r($query);die();

return $this->db->query($query)->result()[0]->total;
}

public function get_total_hrp_count()
{
	$query = "SELECT COUNT(*) as total from (
	SELECT
	COUNT(*) total
	FROM
	tblpregnant_woman a
	INNER JOIN tblancvisit j on a.PWGUID = j.PWGUID
	INNER JOIN tblhhfamilymember b ON
	a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
	INNER JOIN tblhhsurvey c ON
	b.HHSurveyGUID = c.HHSurveyGUID
	INNER JOIN mstasha d ON
	a.AshaID = d.ASHAID
	INNER JOIN mstanm e ON
	a.ANMID = e.ANMID
	INNER JOIN userashamapping f ON
	d.ASHAID = f.AshaID
	INNER JOIN tblusers g ON
	g.user_id = f.UserID
	INNER JOIN anmsubcenter h ON
	e.ANMID = h.ANMID
	INNER JOIN mstsubcenter i ON
	h.SubCenterID = i.SubCenterID
	WHERE
	a.IsPregnant = 1 AND (a.HighRisk = 1 or j.HighRisk = 1) AND a.IsDeleted = 0 AND b.IsDeleted = 0 AND c.IsDeleted = 0 AND d.LanguageID = 1 AND d.IsDeleted = 0 AND d.IsActive = 1 AND e.LanguageID = 1 AND e.IsDeleted = 0 AND i.IsDeleted = 0 AND i.LanguageID = 1 AND g.user_mode = 1";

	if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
	{
		$query .= " and fm.CreatedOn > '" . $this->filter_data['date_from'] . "' and fm.CreatedOn < '" . $this->filter_data['date_to'] . "'";
	}

	if ($this->filter_data['ANM'] != NULL) 
	{
		$query .= " and a.ANMID = " . $this->filter_data['ANM'];
	}

	if ($this->filter_data['Asha'] != NULL) 
	{
		$query .= " and a.AshaID = " . $this->filter_data['Asha'];
	}

	$query .= " GROUP BY a.PWGUID )a";

// print_r($query);die();

	return $this->db->query($query)->result()[0]->total;
}

public function get_child_12_to_24()
{
	$ANMID = $this->filter_data['ANM'];
	$query = "";
	/*print_r($this->filter_data);AND c.ANMID = $ANMID
	die();*/
	$query .= "SELECT
	COUNT(*) AS total,
	gender
	FROM
	(
	SELECT
	TIMESTAMPDIFF(MONTH, child_dob, NOW()) AS ageInMonth,
	gender
	FROM
	tblchild c
	INNER JOIN tblhhfamilymember m ON
	c.HHFamilyMemberGUID = m.HHFamilyMemberGUID
	INNER JOIN tblhhsurvey h ON
	m.HHSurveyGUID = h.HHSurveyGUID
	WHERE
	c.created_by IN(
	SELECT
	user_id
	FROM
	tblusers
	WHERE
	user_mode = 1 AND is_deleted = 0
	) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0";
	if($ANMID){
		$query .= " AND c.ANMID = $ANMID";
	}
	$query .= " ) a
	WHERE
	a.ageInMonth >= 12 AND a.ageInMonth <= 24";
	

	return $this->db->query($query)->result()[0]->total;
}



/*Old anc Query*/

// public function get_full_ANC()
// {
// 	$query = "SELECT
// 	COUNT(*) AS total
// 	FROM
// 	(
// 	SELECT
// 	a.PWGUID
// 	FROM
// 	(
// 	SELECT
// 	m.PWGUID
// 	FROM
// 	tblpregnant_woman m
// 	INNER JOIN tblhhfamilymember fm ON
// 	m.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
// 	INNER JOIN tblhhsurvey h ON
// 	h.HHSurveyGUID = fm.HHSurveyGUID
// 	WHERE
// 	m.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0 AND m.IsPregnant = 1 AND TIMESTAMPDIFF(
// 	DAY,
// 	m.LMPDate,
// 	CURRENT_TIMESTAMP
// ) >= 270 ";

// if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
// {
// 	$query .= " and m.LMPDate > '" . $this->filter_data['date_from'] . "' and m.LMPDate < '" . $this->filter_data['date_to'] . "'";
// }

// if ($this->filter_data['ANM'] != NULL) 
// {
// 	$query .= " and m.ANMID = " . $this->filter_data['ANM'];
// }

// if ($this->filter_data['Asha'] != NULL) 
// {
// 	$query .= " and m.AshaID = " . $this->filter_data['Asha'];
// }

// $query .= " AND m.CreatedBy IN(
// 	SELECT
// 	user_id
// 	FROM
// 	tblusers a
// 	WHERE
// 	a.user_mode = 1 AND a.is_deleted = 0
// )";



// $query .= "
// ) a
// INNER JOIN(
// 	SELECT
// 	  *
// 	FROM
// 	tblancvisit
// 	WHERE
// 	CheckupVisitDate IS NOT NULL and (TTfirstDoseDate is not null or TTsecondDoseDate is not null or TTboosterDate is not null or TT1date is not null or TT2date is not null or TTboosterDate1 is not null )
// ) b
// ON
// a.PWGUID = b.PWGUID
// GROUP BY
// a.PWGUID
// HAVING
// COUNT(*) = 4
// ) a";

// // print_r($query);die();

// return $this->db->query($query)->result()[0]->total;
// }



/*New Full ANC Query*/


public function get_full_ANC()
{
	$query = "SELECT
	COUNT(*) as total
	FROM
	(
	SELECT
	b.PWGUID,
	c.child_dob,
	b.DeliveryDateTime
	FROM
	tblchild c
	INNER JOIN tblpregnant_woman b ON
	c.pw_GUID = b.PWGUID
	WHERE
	YEAR(c.child_dob) = YEAR(
	       CURRENT_DATE - INTERVAL 1 MONTH
	   ) AND ( MONTH(c.child_dob) = MONTH(
	       CURRENT_DATE - INTERVAL 3 MONTH
	   ) OR MONTH(c.child_dob) = MONTH(
	       CURRENT_DATE - INTERVAL 2 MONTH
	   ) OR MONTH(c.child_dob) = MONTH(
	       CURRENT_DATE - INTERVAL 1 MONTH
	   ) ) AND YEAR(c.child_dob) = 2018 AND b.IsDeleted = 0 AND c.IsDeleted = 0 ";

if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " and c.ANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " and c.AshaID = " . $this->filter_data['Asha'];
}
$query .=" ) a
INNER JOIN 
(
	select * from 
	tblancvisit WHERE
	CheckupVisitDate IS NOT NULL 
	GROUP BY
	PWGUID
	having count(*)=4 AND(
		TTfirstDoseDate IS NOT NULL OR TTsecondDoseDate IS NOT NULL OR TTboosterDate IS NOT NULL OR TT1date IS NOT NULL OR TT2date IS NOT NULL OR TTboosterDate1 IS NOT NULL
	)
)b 
on a.PWGUID = b.PWGUID";
 // die($query);
return $this->db->query($query)->result()[0]->total;
}


// Need only three opv and DPT and pantavalent also dpt and pantavalent is same we need only a one from this 


public function  get_full_immunization()
{
	$query = "SELECT
	COUNT(*) AS total
	FROM
	(
	SELECT
	TIMESTAMPDIFF(MONTH, child_dob, NOW()) AS ageInMonth,
	gender
	FROM
	tblchild c
	INNER JOIN tblhhfamilymember m ON
	c.HHFamilyMemberGUID = m.HHFamilyMemberGUID
	INNER JOIN tblhhsurvey h ON
	m.HHSurveyGUID = h.HHSurveyGUID
	WHERE
	c.created_by IN(
	SELECT
	user_id
	FROM
	tblusers
	WHERE
	user_mode = 1 AND is_deleted = 0
) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0 and c.bcg is not null and c.opv2 is not null and c.opv3 is not null and c.opv4 is not null and (c.dpt1 is not null or c.Pentavalent1 is not null) and (c.dpt2 is not null or c.Pentavalent2 is not null) and (c.dpt3 is not null or c.Pentavalent3 is not null) and (c.measeals is not null or c.MeaslesRubella is not null)";

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

$query .= ")a
WHERE
a.ageInMonth >= 12 AND a.ageInMonth <= 24";

	// print_r($query);die();

return $this->db->query($query)->result()[0]->total;
}


public function get_total_child()
{
	$query = "SELECT
	COUNT(pw.PWGUID) as total
	from tblchild c 
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
		$query .= " and c.ANMID = " . $this->filter_data['ANM'];
	}

	if ($this->filter_data['Asha'] != NULL) 
	{
		$query .= " and c.AshaID = " . $this->filter_data['Asha'];
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
// print_r($query);die();

	return $this->db->query($query)->result()[0]->total;
}

public function get_bcg()
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
	$query .= " and c.ANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " and c.AshaID = " . $this->filter_data['Asha'];
}

	// print_r($query); die();

return $this->db->query($query)->result()[0]->total;
}


public function get_opv1()
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
	c.opv1 = c.child_dob AND pw.IsDeleted = 0 AND c.IsDeleted = 0 AND fm.IsDeleted = 0 AND h.IsDeleted = 0";

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

	// print_r($query); die();

	return $this->db->query($query)->result()[0]->total;
}

public function get_opv2()
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
	(
	c.opv2 >= c.child_dob + INTERVAL 45 DAY
) AND pw.IsDeleted = 0 AND c.IsDeleted = 0 AND fm.IsDeleted = 0 AND h.IsDeleted = 0";

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
// print_r($query); die();

return $this->db->query($query)->result()[0]->total;
}


public function get_opv3()
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
	(
	c.opv3 >= c.child_dob + INTERVAL 75 DAY
) AND pw.IsDeleted = 0 AND c.IsDeleted = 0 AND fm.IsDeleted = 0 AND h.IsDeleted = 0";

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

// print_r($query); die();

return $this->db->query($query)->result()[0]->total;
}


public function get_opv4()
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
	(
	c.opv4 >= c.child_dob + INTERVAL 105 DAY
) AND pw.IsDeleted = 0 AND c.IsDeleted = 0 AND fm.IsDeleted = 0 AND h.IsDeleted = 0";

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

// print_r($query); die();

return $this->db->query($query)->result()[0]->total;
}


public function get_hepb1()
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
	c.hepb1 = c.child_dob AND pw.IsDeleted = 0 AND c.IsDeleted = 0 AND fm.IsDeleted = 0 AND h.IsDeleted = 0";

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

	// print_r($query); die();

	return $this->db->query($query)->result()[0]->total;
}


public function get_hepb2()
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
	(
	c.hepb2 >= c.child_dob + INTERVAL 45 DAY
) AND pw.IsDeleted = 0 AND c.IsDeleted = 0 AND fm.IsDeleted = 0 AND h.IsDeleted = 0";

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

// print_r($query); die();

return $this->db->query($query)->result()[0]->total;
}


public function get_hepb3()
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
	(
	c.hepb3 >= c.child_dob + INTERVAL 75 DAY
) AND pw.IsDeleted = 0 AND c.IsDeleted = 0 AND fm.IsDeleted = 0 AND h.IsDeleted = 0";

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

// print_r($query); die();

return $this->db->query($query)->result()[0]->total;
}


public function get_hepb4()
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
	(
	c.hepb4 >= c.child_dob + INTERVAL 105 DAY
) AND pw.IsDeleted = 0 AND c.IsDeleted = 0 AND fm.IsDeleted = 0 AND h.IsDeleted = 0";

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
// print_r($query); die();
return $this->db->query($query)->result()[0]->total;
}


public function get_dpt1()
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
	(
	c.dpt1 is not null or c.Pentavalent1 is not null 
) AND pw.IsDeleted = 0 AND c.IsDeleted = 0 AND fm.IsDeleted = 0 AND h.IsDeleted = 0";

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
// print_r($query); die();
return $this->db->query($query)->result()[0]->total;
}


public function get_dpt2()
{
	$query = "SELECT count(pw.PWGUID) as total from tblchild c 
	inner join tblpregnant_woman pw 
	on c.pw_GUID = pw.PWGUID
	inner join tblhhfamilymember fm
	on c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID 
	inner join tblhhsurvey h 
	on fm.HHSurveyGUID = h.HHSurveyGUID
	where  (c.dpt2 is not null or c.Pentavalent2 is not null) and pw.IsDeleted = 0 and c.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0 ";

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

	// print_r($query); die();

	return $this->db->query($query)->result()[0]->total;
}


public function get_dpt3()
{
	$query = "SELECT count(pw.PWGUID) as total from tblchild c 
	inner join tblpregnant_woman pw 
	on c.pw_GUID = pw.PWGUID
	inner join tblhhfamilymember fm 
	on c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID 
	inner join tblhhsurvey h
	on fm.HHSurveyGUID = h.HHSurveyGUID
	where (c.dpt3 is not null or c.Pentavalent3 is not null) and pw.IsDeleted = 0 and c.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0";

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

	// print_r($query); die();

	return $this->db->query($query)->result()[0]->total;
}


public function get_measeals()
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
	(
	c.measeals is not null or c.MeaslesRubella is not null
) AND pw.IsDeleted = 0 AND c.IsDeleted = 0 AND fm.IsDeleted = 0 AND h.IsDeleted = 0";

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

// print_r($query); die();

return $this->db->query($query)->result()[0]->total;
}



public function get_total_pregnent_women()
{
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

					// print_r($query); die();

	return $this->db->query($query)->result()[0]->total;
}


public function get_registered_in_first_trimester()
{
	$query = "SELECT
	COUNT(pw.PWGUID) AS total
	FROM
	tblpregnant_woman pw
	INNER JOIN tblhhfamilymember fm ON
	pw.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
	INNER JOIN tblhhsurvey h ON
	fm.HHSurveyGUID = h.HHSurveyGUID
	WHERE
	pw.IsDeleted = 0 AND fm.IsDeleted = 0 AND h.IsDeleted = 0 and pw.IsPregnant = 1 AND pw.Regwithin12weeks = 1";

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
	$query .= " and user_mode=1)";
	// print_r($query); die();

	return $this->db->query($query)->result()[0]->total;
}

public function get_one_anc_checkup()
{
	$query = "SELECT
	COUNT(*) AS total
	FROM tblancvisit an INNER JOIN 
	tblpregnant_woman m on an.PWGUID = m.pwguid
	INNER JOIN tblhhfamilymember fm ON
	m.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
	INNER JOIN tblhhsurvey h ON
	h.HHSurveyGUID = fm.HHSurveyGUID
	WHERE
	m.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0 AND m.IsPregnant = 1 and an.Visit_No = 1 and an.CheckupVisitDate is not null AND TIMESTAMPDIFF(
	DAY,
	m.LMPDate,
	CURRENT_TIMESTAMP
	) > 0 AND TIMESTAMPDIFF(
	DAY,
	m.LMPDate,
	CURRENT_TIMESTAMP
) <= 90";

if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
{
	$query .= " and m.LMPDate > '" . $this->filter_data['date_from'] . "' and m.LMPDate < '" . $this->filter_data['date_to'] . "'";
}

if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " and an.ByANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " and an.ByAshaID = " . $this->filter_data['Asha'];
}

$query .= " and an.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
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

		// $query .= "
		// group by pw.PWGUID
		// having count(*) = 1)a";
// print_r($query); die();

return $this->db->query($query)->result()[0]->total;
}






public function get_tt2_or_booster()
{
	$query = "SELECT count(*) as total from 
	(
	SELECT v.AncVisitID FROM tblancvisit v
	inner join tblpregnant_woman pw
	on v.PWGUID = pw.PWGUID 
	inner join tblhhfamilymember fm on pw.HHFamilyMemberGUID = fm.HHFamilyMemberGUID 
	inner join tblhhsurvey h on fm.HHSurveyGUID = h.HHSurveyGUID
	where (v.TTfirstDoseDate is not null or v.TTBoosterDate is not null or v.TTsecondDoseDate is not null)  and pw.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0 and pw.IsPregnant = 1";

	if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
	{
		$query .= " and pw.LMPDate > '" . $this->filter_data['date_from'] . "' and pw.LMPDate < '" . $this->filter_data['date_to'] . "'";
	}

	if ($this->filter_data['ANM'] != NULL) 
	{
		$query .= " and v.ByANMID = " . $this->filter_data['ANM'];
	}

	if ($this->filter_data['Asha'] != NULL) 
	{
		$query .= " and v.ByAshaID = " . $this->filter_data['Asha'];
	}

	$query .= " and v.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
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
)a";
// print_r($query); die();

return $this->db->query($query)->result()[0]->total;

}

/*public function get_pnc_home_visit_counts()
{
	$query = "select a.visit1, b.visit2, c.visit3, d.visit4, e.visit5, f.visit6, g.visit7  from 
(
select count(*) as visit1, 1 from tblpnchomevisit_ans where VisitNo=1 "; 
if ($this->filter_data['ANM'] != NULL) 
	{
		$query .= " and ANMID = " . $this->filter_data['ANM'];
	}

	if ($this->filter_data['Asha'] != NULL) 
	{
		$query .= " and AshaID = " . $this->filter_data['Asha'];
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
	$query .= " and user_mode = 1)"; 
$query .= " ) a 
LEFT JOIN 
(
    select count(*) as visit2, 1 from tblpnchomevisit_ans where VisitNo=2  "; 
if ($this->filter_data['ANM'] != NULL) 
	{
		$query .= " and ANMID = " . $this->filter_data['ANM'];
	}

	if ($this->filter_data['Asha'] != NULL) 
	{
		$query .= " and AshaID = " . $this->filter_data['Asha'];
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
	$query .= " and user_mode = 1)"; 
$query .= "  ) b 
    ON a.1= b.1
    LEFT JOIN
    (select count(*) as visit3, 1 from tblpnchomevisit_ans where VisitNo=3  "; 
if ($this->filter_data['ANM'] != NULL) 
	{
		$query .= " and ANMID = " . $this->filter_data['ANM'];
	}

	if ($this->filter_data['Asha'] != NULL) 
	{
		$query .= " and AshaID = " . $this->filter_data['Asha'];
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
	$query .= " and user_mode = 1)"; 
$query .= "  ) c 
    ON b.1= c.1
    LEFT JOIN 
    (select count(*) as visit4, 1 from tblpnchomevisit_ans where VisitNo=4  "; 
if ($this->filter_data['ANM'] != NULL) 
	{
		$query .= " and ANMID = " . $this->filter_data['ANM'];
	}

	if ($this->filter_data['Asha'] != NULL) 
	{
		$query .= " and AshaID = " . $this->filter_data['Asha'];
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
	$query .= " and user_mode = 1)"; 
$query .= "  ) d 
    ON c.1 = d.1
    LEFT JOIN 
    (select count(*) as visit5, 1 from tblpnchomevisit_ans where VisitNo=5  "; 
if ($this->filter_data['ANM'] != NULL) 
	{
		$query .= " and ANMID = " . $this->filter_data['ANM'];
	}

	if ($this->filter_data['Asha'] != NULL) 
	{
		$query .= " and AshaID = " . $this->filter_data['Asha'];
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
	$query .= " and user_mode = 1)"; 
$query .= "  ) e 
    on d.1 = e.1 
    LEFT JOIN 
    (select count(*) as visit6, 1 from tblpnchomevisit_ans where VisitNo=6  "; 
if ($this->filter_data['ANM'] != NULL) 
	{
		$query .= " and ANMID = " . $this->filter_data['ANM'];
	}

	if ($this->filter_data['Asha'] != NULL) 
	{
		$query .= " and AshaID = " . $this->filter_data['Asha'];
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
	$query .= " and user_mode = 1)"; 
$query .= "  ) f 
    ON e.1 = f.1 
    LEFT JOIN 
    (select count(*) as visit7, 1 from tblpnchomevisit_ans where VisitNo=7  "; 
if ($this->filter_data['ANM'] != NULL) 
	{
		$query .= " and ANMID = " . $this->filter_data['ANM'];
	}

	if ($this->filter_data['Asha'] != NULL) 
	{
		$query .= " and AshaID = " . $this->filter_data['Asha'];
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
	$query .= " and user_mode = 1)"; 
$query .= "  ) g 
    ON f.1 = g.1";

    return $this->db->query($query)->result();

}
*/

public function get_pnc_home_visit_1()
{
	$query = "SELECT count(*) as total FROM tblpnchomevisit_ans a INNER JOIN tblchild c on a.ChildGUID = c.childGUID WHERE YEAR(c.child_dob) = YEAR(
	       CURRENT_DATE - INTERVAL 1 MONTH
	   ) AND ( MONTH(c.child_dob) = MONTH(
	       CURRENT_DATE - INTERVAL 3 MONTH
	   ) OR MONTH(c.child_dob) = MONTH(
	       CURRENT_DATE - INTERVAL 2 MONTH
	   ) OR MONTH(c.child_dob) = MONTH(
	       CURRENT_DATE - INTERVAL 1 MONTH
	   ) ) AND VisitNo = 1 ";

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
	$query .= " and user_mode = 1)"; 

	return $this->db->query($query)->result()[0]->total;
}



public function get_pnc_home_visit_2()
{
	$query = "SELECT count(*) as total FROM tblpnchomevisit_ans a INNER JOIN tblchild c on a.ChildGUID = c.childGUID WHERE YEAR(c.child_dob) = YEAR(
	       CURRENT_DATE - INTERVAL 1 MONTH
	   ) AND ( MONTH(c.child_dob) = MONTH(
	       CURRENT_DATE - INTERVAL 3 MONTH
	   ) OR MONTH(c.child_dob) = MONTH(
	       CURRENT_DATE - INTERVAL 2 MONTH
	   ) OR MONTH(c.child_dob) = MONTH(
	       CURRENT_DATE - INTERVAL 1 MONTH
	   ) ) AND VisitNo = 2 ";

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
	$query .= " and user_mode = 1)"; 

	return $this->db->query($query)->result()[0]->total;
}


public function get_pnc_home_visit_3()
{
	$query = "SELECT count(*) as total FROM tblpnchomevisit_ans a INNER JOIN tblchild c on a.ChildGUID = c.childGUID WHERE YEAR(c.child_dob) = YEAR(
	       CURRENT_DATE - INTERVAL 1 MONTH
	   ) AND ( MONTH(c.child_dob) = MONTH(
	       CURRENT_DATE - INTERVAL 3 MONTH
	   ) OR MONTH(c.child_dob) = MONTH(
	       CURRENT_DATE - INTERVAL 2 MONTH
	   ) OR MONTH(c.child_dob) = MONTH(
	       CURRENT_DATE - INTERVAL 1 MONTH
	   ) ) AND VisitNo = 3 ";

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
	$query .= " and user_mode = 1)"; 

	return $this->db->query($query)->result()[0]->total;
}


public function get_pnc_home_visit_4()
{
	$query = "SELECT count(*) as total FROM tblpnchomevisit_ans a INNER JOIN tblchild c on a.ChildGUID = c.childGUID WHERE YEAR(c.child_dob) = YEAR(
	       CURRENT_DATE - INTERVAL 1 MONTH
	   ) AND ( MONTH(c.child_dob) = MONTH(
	       CURRENT_DATE - INTERVAL 3 MONTH
	   ) OR MONTH(c.child_dob) = MONTH(
	       CURRENT_DATE - INTERVAL 2 MONTH
	   ) OR MONTH(c.child_dob) = MONTH(
	       CURRENT_DATE - INTERVAL 1 MONTH
	   ) ) AND VisitNo = 4 ";

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
	$query .= " and user_mode = 1)"; 

	return $this->db->query($query)->result()[0]->total;
}


public function get_pnc_home_visit_5()
{
	$query = "SELECT count(*) as total FROM tblpnchomevisit_ans a INNER JOIN tblchild c on a.ChildGUID = c.childGUID WHERE YEAR(c.child_dob) = YEAR(
	       CURRENT_DATE - INTERVAL 1 MONTH
	   ) AND ( MONTH(c.child_dob) = MONTH(
	       CURRENT_DATE - INTERVAL 3 MONTH
	   ) OR MONTH(c.child_dob) = MONTH(
	       CURRENT_DATE - INTERVAL 2 MONTH
	   ) OR MONTH(c.child_dob) = MONTH(
	       CURRENT_DATE - INTERVAL 1 MONTH
	   ) ) AND VisitNo = 5 ";

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
	$query .= " and user_mode = 1)"; 

	return $this->db->query($query)->result()[0]->total;
}


public function get_pnc_home_visit_6()
{
	$query = "SELECT count(*) as total FROM tblpnchomevisit_ans a INNER JOIN tblchild c on a.ChildGUID = c.childGUID WHERE YEAR(c.child_dob) = YEAR(
	       CURRENT_DATE - INTERVAL 1 MONTH
	   ) AND ( MONTH(c.child_dob) = MONTH(
	       CURRENT_DATE - INTERVAL 3 MONTH
	   ) OR MONTH(c.child_dob) = MONTH(
	       CURRENT_DATE - INTERVAL 2 MONTH
	   ) OR MONTH(c.child_dob) = MONTH(
	       CURRENT_DATE - INTERVAL 1 MONTH
	   ) ) AND VisitNo = 6 ";

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
	$query .= " and user_mode = 1)"; 

	return $this->db->query($query)->result()[0]->total;
}


public function get_pnc_home_visit_7()
{
	$query = "SELECT count(*) as total FROM tblpnchomevisit_ans a INNER JOIN tblchild c on a.ChildGUID = c.childGUID WHERE YEAR(c.child_dob) = YEAR(
	       CURRENT_DATE - INTERVAL 1 MONTH
	   ) AND ( MONTH(c.child_dob) = MONTH(
	       CURRENT_DATE - INTERVAL 3 MONTH
	   ) OR MONTH(c.child_dob) = MONTH(
	       CURRENT_DATE - INTERVAL 2 MONTH
	   ) OR MONTH(c.child_dob) = MONTH(
	       CURRENT_DATE - INTERVAL 1 MONTH
	   ) ) AND VisitNo = 7 ";

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
	$query .= " and user_mode = 1)"; 

	return $this->db->query($query)->result()[0]->total;
}





public function get_child_count()
{
	$query = "SELECT count(pw.PWGUID) as total from tblchild c 
	inner join tblpregnant_woman pw
	on c.pw_GUID = pw.PWGUID
	inner join tblhhfamilymember fm on c.HHFamilyMemberGUID = fm.HHFamilyMemberGUID 
	inner join tblhhsurvey h on fm.HHSurveyGUID = h.HHSurveyGUID
	where  YEAR(c.child_dob) = YEAR(
	       CURRENT_DATE - INTERVAL 1 MONTH
	   ) AND ( MONTH(c.child_dob) = MONTH(
	       CURRENT_DATE - INTERVAL 3 MONTH
	   ) OR MONTH(c.child_dob) = MONTH(
	       CURRENT_DATE - INTERVAL 2 MONTH
	   ) OR MONTH(c.child_dob) = MONTH(
	       CURRENT_DATE - INTERVAL 1 MONTH
	   ) ) AND 1=1 and pw.IsDeleted = 0 and c.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0";

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

	$query .= " and c.created_by in (select user_id from tblusers where is_deleted=0 ";
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
// print_r($query); die();

	return $this->db->query($query)->result()[0]->total;
}




public function get_low_weight_birth()
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
	 YEAR(c.child_dob) = YEAR(
	       CURRENT_DATE - INTERVAL 1 MONTH
	   ) AND ( MONTH(c.child_dob) = MONTH(
	       CURRENT_DATE - INTERVAL 3 MONTH
	   ) OR MONTH(c.child_dob) = MONTH(
	       CURRENT_DATE - INTERVAL 2 MONTH
	   ) OR MONTH(c.child_dob) = MONTH(
	       CURRENT_DATE - INTERVAL 1 MONTH
	   ) ) AND
	c.Wt_of_child < 2.5 AND pw.IsDeleted = 0 AND c.IsDeleted = 0 AND fm.IsDeleted = 0 AND h.IsDeleted = 0";

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

	$query .= " and c.created_by in (select user_id from tblusers where is_deleted=0 ";
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
	// print_r($query); die();

	return $this->db->query($query)->result()[0]->total;

}


public function get_2_or_more_times_within_first_7_days_of_institutional_delivery()
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
	 YEAR(c.child_dob) = YEAR(
	       CURRENT_DATE - INTERVAL 1 MONTH
	   ) AND ( MONTH(c.child_dob) = MONTH(
	       CURRENT_DATE - INTERVAL 3 MONTH
	   ) OR MONTH(c.child_dob) = MONTH(
	       CURRENT_DATE - INTERVAL 2 MONTH
	   ) OR MONTH(c.child_dob) = MONTH(
	       CURRENT_DATE - INTERVAL 1 MONTH
	   ) ) AND
	p.Q_0 BETWEEN c.child_dob AND DATE_ADD(c.child_dob, INTERVAL 7 DAY) AND c.IsDeleted = 0 AND fm.IsDeleted = 0 AND h.IsDeleted = 0 ";

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
)a";

// print_r($query); die();

return $this->db->query($query)->result()[0]->total;

}

public function get_place_of_delivery()
{
	$query = "SELECT COUNT(pw.PWGUID) AS total
	FROM
	tblpregnant_woman pw
	inner join tblhhfamilymember fm on pw.HHFamilyMemberGUID = fm.HHFamilyMemberGUID 
	inner join tblhhsurvey h on fm.HHSurveyGUID = h.HHSurveyGUID
	INNER JOIN
	tblchild c ON pw.PWGUID = c.pw_GUID
	WHERE
	 YEAR(c.child_dob) = YEAR(
	       CURRENT_DATE - INTERVAL 1 MONTH
	   ) AND ( MONTH(c.child_dob) = MONTH(
	       CURRENT_DATE - INTERVAL 3 MONTH
	   ) OR MONTH(c.child_dob) = MONTH(
	       CURRENT_DATE - INTERVAL 2 MONTH
	   ) OR MONTH(c.child_dob) = MONTH(
	       CURRENT_DATE - INTERVAL 1 MONTH
	   ) ) AND c.place_of_birth = 2  and pw.IsDeleted = 0 and fm.IsDeleted = 0 and h.IsDeleted = 0 and c.IsDeleted= 0";

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
		// print_r($query); die();

	return $this->db->query($query)->result()[0]->total;
}



public function get_current_month_delivery()
{
	$query = "SELECT
	COUNT(*) as total
	FROM
	tblchild c
	INNER JOIN tblpregnant_woman b ON
	c.pw_GUID = b.PWGUID
	WHERE
	(
	MONTH(c.child_dob) = MONTH(CURDATE())
) AND YEAR(c.child_dob) = YEAR(CURDATE()) AND b.IsDeleted = 0 AND c.IsDeleted = 0 ";

if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " and c.ANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " and c.AshaID = " . $this->filter_data['Asha'];
}

$query .= " and c.created_by in (select user_id from tblusers where is_deleted=0 ";
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


public function get_last_month_delivery()
{

	$query = "SELECT
    COUNT(*) AS total
FROM
    tblhhfamilymember a
INNER JOIN tblhhsurvey b ON
    a.HHSurveyGUID = b.HHSurveyGUID
WHERE
    YEAR(a.DateofBirth) = YEAR(
        CURRENT_DATE - INTERVAL 1 MONTH
    ) AND
        MONTH(a.DateofBirth) = MONTH(
            CURRENT_DATE - INTERVAL 1 MONTH
        ) 
     AND a.IsDeleted = 0 AND b.IsDeleted = 0 AND(
        a.GenderID = 1 OR a.GenderID = 2
    ) AND b.IsActive = 1 ";

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

return $this->db->query($query)->result()[0]->total;
}


public function get_last_three_month_delivery()
{
	$query = "SELECT
    COUNT(*) AS total
FROM
    tblhhfamilymember a
INNER JOIN tblhhsurvey b ON
    a.HHSurveyGUID = b.HHSurveyGUID
WHERE
    YEAR(a.DateofBirth) = YEAR(
        CURRENT_DATE - INTERVAL 1 MONTH
    ) AND(
        MONTH(a.DateofBirth) = MONTH(
            CURRENT_DATE - INTERVAL 1 MONTH
        ) OR MONTH(a.DateofBirth) = MONTH(
            CURRENT_DATE - INTERVAL 2 MONTH
        ) OR MONTH(a.DateofBirth) = MONTH(
            CURRENT_DATE - INTERVAL 3 MONTH
        )
    ) AND a.IsDeleted = 0 AND b.IsDeleted = 0 AND(
        a.GenderID = 1 OR a.GenderID = 2
    ) AND b.IsActive = 1 ";

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

return $this->db->query($query)->result()[0]->total;
}

public function get_april_to_current_month_livebirth()
{
	$query = "SELECT
    COUNT(*) AS total
FROM
    tblhhfamilymember a
INNER JOIN tblhhsurvey b ON
    a.HHSurveyGUID = b.HHSurveyGUID
WHERE
    a.DateOfBirth >= CONCAT(YEAR(NOW()),
    '-04-01') AND a.DateOfBirth < CONCAT(YEAR(NOW()),
    '-04-01') + INTERVAL 1 YEAR AND a.IsDeleted = 0 AND b.IsDeleted = 0 AND(
        a.GenderID = 1 OR a.GenderID = 2
    ) AND b.IsActive = 1 ";

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

return $this->db->query($query)->result()[0]->total;
}


public function get_current_infant_death()
{
	$query = "SELECT
	COUNT(*) as total
	FROM
    tblpregnant_woman 
	WHERE
	(
	MONTH(DeliveryDateTime) = MONTH(CURDATE())
) AND YEAR(DeliveryDateTime) = YEAR(CURDATE()) AND IsDeleted = 0 AND DeliveryType =2";

if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " and ANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " and AshaID = " . $this->filter_data['Asha'];
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

return $this->db->query($query)->result()[0]->total;
}


public function get_last_month_infant_death()
{
	$query = "SELECT
    COUNT(*) AS total
FROM
    tblpregnant_woman
WHERE
    YEAR(DeliveryDateTime) = YEAR(
        CURRENT_DATE - INTERVAL 1 MONTH
    ) AND MONTH(DeliveryDateTime) = MONTH(
        CURRENT_DATE - INTERVAL 1 MONTH
    ) AND IsDeleted = 0 AND DeliveryType = 2 ";

if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " and ANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " and AshaID = " . $this->filter_data['Asha'];
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


return $this->db->query($query)->result()[0]->total;
}

public function get_last_three_month_infant_death()
{
	$query = "SELECT
    COUNT(*) AS total
FROM
    tblpregnant_woman
WHERE
    YEAR(DeliveryDateTime) = YEAR(
        CURRENT_DATE - INTERVAL 1 MONTH
    ) AND ( MONTH(DeliveryDateTime) = MONTH(
        CURRENT_DATE - INTERVAL 3 MONTH
    ) OR MONTH(DeliveryDateTime) = MONTH(
        CURRENT_DATE - INTERVAL 2 MONTH
    ) or MONTH(DeliveryDateTime) = MONTH(
        CURRENT_DATE - INTERVAL 1 MONTH
    )) AND IsDeleted = 0 AND DeliveryType = 2 ";

if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " and ANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " and AshaID = " . $this->filter_data['Asha'];
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



return $this->db->query($query)->result()[0]->total;
}

public function get_april_to_current_month_infant_death()
{
	$query = "SELECT
    COUNT(*) AS total
FROM
    tblpregnant_woman
WHERE
    DeliveryDateTime >= CONCAT(YEAR(NOW()),
    '-04-01') AND DeliveryDateTime < CONCAT(YEAR(NOW()),
    '-04-01') + INTERVAL 1 YEAR AND IsDeleted = 0 AND DeliveryType = 2 ";

if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " and ANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " and AshaID = " . $this->filter_data['Asha'];
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



return $this->db->query($query)->result()[0]->total;
}



public function one_anc_checkup_in_4_to_6_month()
{
	$query = "SELECT
	COUNT(*) AS total
	FROM tblancvisit an INNER JOIN 
	tblpregnant_woman m on an.PWGUID = m.pwguid
	INNER JOIN tblhhfamilymember fm ON
	m.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
	INNER JOIN tblhhsurvey h ON
	h.HHSurveyGUID = fm.HHSurveyGUID
	WHERE
	m.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0 AND m.IsPregnant = 1 and an.Visit_No = 1 and an.CheckupVisitDate is not null AND TIMESTAMPDIFF(
	DAY,
	m.LMPDate,
	CURRENT_TIMESTAMP
	) > 90 AND TIMESTAMPDIFF(
	DAY,
	m.LMPDate,
	CURRENT_TIMESTAMP
) <= 180";

if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
{
	$query .= " and m.LMPDate > '" . $this->filter_data['date_from'] . "' and m.LMPDate < '" . $this->filter_data['date_to'] . "'";
}

if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " and an.ByANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " and an.ByAshaID = " . $this->filter_data['Asha'];
}

$query .= " and an.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
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



return $this->db->query($query)->result()[0]->total;
}


public function one_anc_checkup_in_7_to_8_month()
{
	$query = "SELECT
	COUNT(*) AS total
	FROM tblancvisit an INNER JOIN 
	tblpregnant_woman m on an.PWGUID = m.pwguid
	INNER JOIN tblhhfamilymember fm ON
	m.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
	INNER JOIN tblhhsurvey h ON
	h.HHSurveyGUID = fm.HHSurveyGUID
	WHERE
	m.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0 AND m.IsPregnant = 1 and an.Visit_No = 1 and an.CheckupVisitDate is not null AND TIMESTAMPDIFF(
	DAY,
	m.LMPDate,
	CURRENT_TIMESTAMP
	) > 180 AND TIMESTAMPDIFF(
	DAY,
	m.LMPDate,
	CURRENT_TIMESTAMP
) <= 270";

if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
{
	$query .= " and m.LMPDate > '" . $this->filter_data['date_from'] . "' and m.LMPDate < '" . $this->filter_data['date_to'] . "'";
}

if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " and an.ByANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " and an.ByAshaID = " . $this->filter_data['Asha'];
}

$query .= " and an.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
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



return $this->db->query($query)->result()[0]->total;
}


public function one_anc_checkup_9_and_more_months()
{
	$query = "SELECT
	COUNT(*) AS total
	FROM tblancvisit an INNER JOIN 
	tblpregnant_woman m on an.PWGUID = m.pwguid
	INNER JOIN tblhhfamilymember fm ON
	m.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
	INNER JOIN tblhhsurvey h ON
	h.HHSurveyGUID = fm.HHSurveyGUID
	WHERE
	m.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0 AND m.IsPregnant = 1 and an.Visit_No = 1 and an.CheckupVisitDate is not null AND TIMESTAMPDIFF(
	DAY,
	m.LMPDate,
	CURRENT_TIMESTAMP
) > 270";

if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
{
	$query .= " and m.LMPDate > '" . $this->filter_data['date_from'] . "' and m.LMPDate < '" . $this->filter_data['date_to'] . "'";
}

if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " and an.ByANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " and an.ByAshaID = " . $this->filter_data['Asha'];
}

$query .= " and an.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
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



return $this->db->query($query)->result()[0]->total;
}



public function get_two_anc_checkup()
{
	$query = "SELECT
	COUNT(*) AS total
	FROM tblancvisit an INNER JOIN 
	tblpregnant_woman m on an.PWGUID = m.pwguid
	INNER JOIN tblhhfamilymember fm ON
	m.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
	INNER JOIN tblhhsurvey h ON
	h.HHSurveyGUID = fm.HHSurveyGUID
	WHERE
	m.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0 AND m.IsPregnant = 1 and an.Visit_No = 2 and an.CheckupVisitDate is not null AND TIMESTAMPDIFF(
	DAY,
	m.LMPDate,
	CURRENT_TIMESTAMP
	) > 90 AND TIMESTAMPDIFF(
	DAY,
	m.LMPDate,
	CURRENT_TIMESTAMP
) <= 180";

if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
{
	$query .= " and m.LMPDate > '" . $this->filter_data['date_from'] . "' and m.LMPDate < '" . $this->filter_data['date_to'] . "'";
}

if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " and an.ByANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " and an.ByAshaID = " . $this->filter_data['Asha'];
}

$query .= " and an.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
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
		// die($query);



return $this->db->query($query)->result()[0]->total;
}


public function two_anc_checkup_in_7_to_8_months()
{
	$query = "SELECT
	COUNT(*) AS total
	FROM tblancvisit an INNER JOIN 
	tblpregnant_woman m on an.PWGUID = m.pwguid
	INNER JOIN tblhhfamilymember fm ON
	m.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
	INNER JOIN tblhhsurvey h ON
	h.HHSurveyGUID = fm.HHSurveyGUID
	WHERE
	m.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0 AND m.IsPregnant = 1 and an.Visit_No = 2 and an.CheckupVisitDate is not null AND TIMESTAMPDIFF(
	DAY,
	m.LMPDate,
	CURRENT_TIMESTAMP
	) > 180 AND TIMESTAMPDIFF(
	DAY,
	m.LMPDate,
	CURRENT_TIMESTAMP
) <= 270";

if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
{
	$query .= " and m.LMPDate > '" . $this->filter_data['date_from'] . "' and m.LMPDate < '" . $this->filter_data['date_to'] . "'";
}

if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " and an.ByANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " and an.ByAshaID = " . $this->filter_data['Asha'];
}

$query .= " and an.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
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
		// die($query);

return $this->db->query($query)->result()[0]->total;
}


public function two_anc_checkup_9_and_more_months()
{
	$query = "SELECT
	COUNT(*) AS total
	FROM tblancvisit an INNER JOIN 
	tblpregnant_woman m on an.PWGUID = m.pwguid
	INNER JOIN tblhhfamilymember fm ON
	m.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
	INNER JOIN tblhhsurvey h ON
	h.HHSurveyGUID = fm.HHSurveyGUID
	WHERE
	m.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0 AND m.IsPregnant = 1 and an.Visit_No = 2 and an.CheckupVisitDate is not null AND TIMESTAMPDIFF(
	DAY,
	m.LMPDate,
	CURRENT_TIMESTAMP
) > 270";

if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
{
	$query .= " and m.LMPDate > '" . $this->filter_data['date_from'] . "' and m.LMPDate < '" . $this->filter_data['date_to'] . "'";
}

if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " and an.ByANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " and an.ByAshaID = " . $this->filter_data['Asha'];
}

$query .= " and an.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
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
		// die($query);

return $this->db->query($query)->result()[0]->total;
}



public function get_three_anc_checkup()
{
	$query = "SELECT
	COUNT(*) AS total
	FROM tblancvisit an INNER JOIN 
	tblpregnant_woman m on an.PWGUID = m.pwguid
	INNER JOIN tblhhfamilymember fm ON
	m.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
	INNER JOIN tblhhsurvey h ON
	h.HHSurveyGUID = fm.HHSurveyGUID
	WHERE
	m.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0 AND m.IsPregnant = 1 and an.Visit_No = 3 and an.CheckupVisitDate is not null AND TIMESTAMPDIFF(
	DAY,
	m.LMPDate,
	CURRENT_TIMESTAMP
	) > 180 AND TIMESTAMPDIFF(
	DAY,
	m.LMPDate,
	CURRENT_TIMESTAMP
) <= 270";

if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
{
	$query .= " and m.LMPDate > '" . $this->filter_data['date_from'] . "' and m.LMPDate < '" . $this->filter_data['date_to'] . "'";
}

if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " and an.ByANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " and an.ByAshaID = " . $this->filter_data['Asha'];
}

$query .= " and an.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
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
		// die($query);

return $this->db->query($query)->result()[0]->total;
}



public function three_anc_checkup_9_and_more_months()
{
	$query = "SELECT
	COUNT(*) AS total
	FROM tblancvisit an INNER JOIN 
	tblpregnant_woman m on an.PWGUID = m.pwguid
	INNER JOIN tblhhfamilymember fm ON
	m.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
	INNER JOIN tblhhsurvey h ON
	h.HHSurveyGUID = fm.HHSurveyGUID
	WHERE
	m.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0 AND m.IsPregnant = 1 and an.Visit_No = 3 and an.CheckupVisitDate is not null AND TIMESTAMPDIFF(
	DAY,
	m.LMPDate,
	CURRENT_TIMESTAMP
) > 270";

if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
{
	$query .= " and m.LMPDate > '" . $this->filter_data['date_from'] . "' and m.LMPDate < '" . $this->filter_data['date_to'] . "'";
}

if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " and an.ByANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " and an.ByAshaID = " . $this->filter_data['Asha'];
}

$query .= " and an.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
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
		// die($query);

return $this->db->query($query)->result()[0]->total;
}


public function get_four_anc_checkup()
{
	$query = "SELECT
	COUNT(*) AS total
	FROM tblancvisit an INNER JOIN 
	tblpregnant_woman m on an.PWGUID = m.pwguid
	INNER JOIN tblhhfamilymember fm ON
	m.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
	INNER JOIN tblhhsurvey h ON
	h.HHSurveyGUID = fm.HHSurveyGUID
	WHERE
	m.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0 AND m.IsPregnant = 1 and an.Visit_No = 4 and an.CheckupVisitDate is not null AND TIMESTAMPDIFF(
	DAY,
	m.LMPDate,
	CURRENT_TIMESTAMP
) > 270";

if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
{
	$query .= " and m.LMPDate > '" . $this->filter_data['date_from'] . "' and m.LMPDate < '" . $this->filter_data['date_to'] . "'";
}

if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " and an.ByANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " and an.ByAshaID = " . $this->filter_data['Asha'];
}

$query .= " and an.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
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
		// die($query);

return $this->db->query($query)->result()[0]->total;
}


public function comp_one_anc_checkup()
{
	$query = "SELECT
	COUNT(*) AS total
	FROM tblancvisit an INNER JOIN 
	tblpregnant_woman m on an.PWGUID = m.pwguid
	INNER JOIN tblhhfamilymember fm ON
	m.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
	INNER JOIN tblhhsurvey h ON
	h.HHSurveyGUID = fm.HHSurveyGUID
	WHERE
	m.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0 AND m.IsPregnant = 1 and an.Visit_No = 1 and an.CheckupVisitDate is not null AND TIMESTAMPDIFF(
	DAY,
	m.LMPDate,
	CURRENT_TIMESTAMP
) > 0";

if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
{
	$query .= " and m.LMPDate > '" . $this->filter_data['date_from'] . "' and m.LMPDate < '" . $this->filter_data['date_to'] . "'";
}

if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " and an.ByANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " and an.ByAshaID = " . $this->filter_data['Asha'];
}

$query .= " and an.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
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
		// die($query);

return $this->db->query($query)->result()[0]->total;
}

public function comp_two_anc_checkup()
{
	$query = "SELECT
	COUNT(*) AS total
	FROM tblancvisit an INNER JOIN 
	tblpregnant_woman m on an.PWGUID = m.pwguid
	INNER JOIN tblhhfamilymember fm ON
	m.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
	INNER JOIN tblhhsurvey h ON
	h.HHSurveyGUID = fm.HHSurveyGUID
	WHERE
	m.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0 AND m.IsPregnant = 1 and an.Visit_No = 2 and an.CheckupVisitDate is not null AND TIMESTAMPDIFF(
	DAY,
	m.LMPDate,
	CURRENT_TIMESTAMP
) > 0";

if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
{
	$query .= " and m.LMPDate > '" . $this->filter_data['date_from'] . "' and m.LMPDate < '" . $this->filter_data['date_to'] . "'";
}

if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " and an.ByANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " and an.ByAshaID = " . $this->filter_data['Asha'];
}

$query .= " and an.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
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
		// die($query);

return $this->db->query($query)->result()[0]->total;
}

public function comp_three_anc_checkup()
{
	$query = "SELECT
	COUNT(*) AS total
	FROM tblancvisit an INNER JOIN 
	tblpregnant_woman m on an.PWGUID = m.pwguid
	INNER JOIN tblhhfamilymember fm ON
	m.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
	INNER JOIN tblhhsurvey h ON
	h.HHSurveyGUID = fm.HHSurveyGUID
	WHERE
	m.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0 AND m.IsPregnant = 1 and an.Visit_No = 3 and an.CheckupVisitDate is not null AND TIMESTAMPDIFF(
	DAY,
	m.LMPDate,
	CURRENT_TIMESTAMP
) > 0";

if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
{
	$query .= " and m.LMPDate > '" . $this->filter_data['date_from'] . "' and m.LMPDate < '" . $this->filter_data['date_to'] . "'";
}

if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " and an.ByANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " and an.ByAshaID = " . $this->filter_data['Asha'];
}

$query .= " and an.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
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
		// die($query);

return $this->db->query($query)->result()[0]->total;
}


public function comp_four_anc_checkup()
{
	$query = "SELECT
	COUNT(*) AS total
	FROM tblancvisit an INNER JOIN 
	tblpregnant_woman m on an.PWGUID = m.pwguid
	INNER JOIN tblhhfamilymember fm ON
	m.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
	INNER JOIN tblhhsurvey h ON
	h.HHSurveyGUID = fm.HHSurveyGUID
	WHERE
	m.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0 AND m.IsPregnant = 1 and an.Visit_No = 4 and an.CheckupVisitDate is not null AND TIMESTAMPDIFF(
	DAY,
	m.LMPDate,
	CURRENT_TIMESTAMP
) > 0";

if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
{
	$query .= " and m.LMPDate > '" . $this->filter_data['date_from'] . "' and m.LMPDate < '" . $this->filter_data['date_to'] . "'";
}

if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " and an.ByANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " and an.ByAshaID = " . $this->filter_data['Asha'];
}

$query .= " and an.CreatedBy in (select user_id from tblusers where is_deleted=0 ";
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
		// die($query);

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


public function get_hrp_report()
{
	$query = "SELECT
	a.*,
	c.anticipated_visits,
	b.ActualVisits,
	c.anticipated_visits - b.ActualVisits AS Difference
	FROM
	(
	SELECT
	a.PWName,
	a.MotherMCTSID,
	a.MobileNo,
	a.LMPDate,
	a.EDDDate,
	TIMESTAMPDIFF(DAY, a.LMPDate, CURRENT_DATE) AS days,
	a.PWGUID,
	a.AshaID,
	a.ANMID,
	d.ASHAName,
	e.ANMName,
	g.user_name,
	i.SubCenterID,
	i.SubCenterName,
	c.HHCode,
	g.phone_no
	FROM
	tblpregnant_woman a
	INNER JOIN tblancvisit j on a.PWGUID = j.PWGUID
	INNER JOIN tblhhfamilymember b ON
	a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
	INNER JOIN tblhhsurvey c ON
	b.HHSurveyGUID = c.HHSurveyGUID
	INNER JOIN mstasha d ON
	a.AshaID = d.ASHAID
	INNER JOIN mstanm e ON
	a.ANMID = e.ANMID
	INNER JOIN userashamapping f ON
	d.ASHAID = f.AshaID
	INNER JOIN tblusers g ON
	g.user_id = f.UserID
	INNER JOIN anmsubcenter h ON
	e.ANMID = h.ANMID
	INNER JOIN mstsubcenter i ON
	h.SubCenterID = i.SubCenterID
	WHERE
	a.IsPregnant = 1 AND (a.HighRisk = 1 or j.HighRisk = 1) AND a.IsDeleted = 0 AND b.IsDeleted = 0 AND c.IsDeleted = 0 AND d.LanguageID = 1 AND d.IsDeleted = 0 AND d.IsActive = 1 AND e.LanguageID = 1 AND e.IsDeleted = 0 AND i.IsDeleted = 0 AND i.LanguageID = 1 AND g.user_mode = 1 GROUP BY a.PWGUID
) a
LEFT JOIN(
SELECT
a.PWGUID,
COUNT(*) AS ActualVisits
FROM
tblancvisit a
WHERE
a.CheckupVisitDate IS NOT NULL AND a.IsDeleted = 0
GROUP BY
a.PWGUID
HAVING
COUNT(*)
) b
ON
a.PWGUID = b.PWGUID
LEFT JOIN(
SELECT
PWGUID,
CASE WHEN TIMESTAMPDIFF(MONTH, LMPDate, CURRENT_DATE) > 0 AND TIMESTAMPDIFF(MONTH, LMPDate, CURRENT_DATE) <= 3 THEN 1 WHEN TIMESTAMPDIFF(MONTH, LMPDate, CURRENT_DATE) > 3 AND TIMESTAMPDIFF(MONTH, LMPDate, CURRENT_DATE) <= 6 THEN 2 WHEN TIMESTAMPDIFF(MONTH, LMPDate, CURRENT_DATE) > 6 AND TIMESTAMPDIFF(MONTH, LMPDate, CURRENT_DATE) <= 8 THEN 3 WHEN TIMESTAMPDIFF(MONTH, LMPDate, CURRENT_DATE) > 8 THEN 4
END AS anticipated_visits
FROM
tblpregnant_woman
WHERE
ispregnant = 1
) c
ON
b.PWGUID = c.PWGUID
WHERE
1";


if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " AND  a.ANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " AND a.AshaID = " . $this->filter_data['Asha'];
}

$query .= " ORDER BY Difference DESC";

	// die($query);

return $this->db->query($query)->result();
}




public function total_pregnent_women_last_three_months()
{
	$query = "SELECT
	COUNT(*) as total
	FROM
	tblchild c
	INNER JOIN tblpregnant_woman b ON
	c.pw_GUID = b.PWGUID
	WHERE
	 YEAR(c.child_dob) = YEAR(
            CURRENT_DATE - INTERVAL 1 MONTH
        ) AND(
            MONTH(c.child_dob) = MONTH(
                CURRENT_DATE - INTERVAL 3 MONTH
            ) OR MONTH(c.child_dob) = MONTH(
                CURRENT_DATE - INTERVAL 2 MONTH
            ) OR MONTH(c.child_dob) = MONTH(
                CURRENT_DATE - INTERVAL 1 MONTH
            )
        ) AND YEAR(c.child_dob) = 2018 AND b.IsDeleted = 0 AND c.IsDeleted = 0";

if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " AND  c.ANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " AND c.AshaID = " . $this->filter_data['Asha'];
}


        // die($query);

return $this->db->query($query)->result()[0]->total;
}

public function get_assessed_count(){
	$query = "SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        HHFamilyMemberGUID,
        AshaID,
        ANMID
    FROM
        `tblncdcbac`
    GROUP BY
        HHFamilyMemberGUID
) a
INNER JOIN tblhhfamilymember b ON
    a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
WHERE
    (
        CASE WHEN b.DOBAvailable = 2 THEN b.AprilAgeYear +(
            YEAR(CURRENT_DATE) - b.AgeAsOnYear
        ) WHEN b.DOBAvailable = 1 THEN TIMESTAMPDIFF(
            YEAR,
            b.DateOfBirth,
            CURRENT_DATE
        )
    END
) >= 30";
	
	if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " and a.ANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " and a.AshaID = " . $this->filter_data['Asha'];
}
if($this->db->query($query)->result())
 return $this->db->query($query)->result()[0]->total;
else
	return false;
}

public function get_screened_count(){
	$query = "SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        HHFamilyMemberGUID,
        AshaID,
        ANMID
    FROM
        `tblncdscreening`
    GROUP BY
        HHFamilyMemberGUID
) a
INNER JOIN tblhhfamilymember b ON
    a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
WHERE
    (
        CASE WHEN b.DOBAvailable = 2 THEN b.AprilAgeYear +(
            YEAR(CURRENT_DATE) - b.AgeAsOnYear
        ) WHEN b.DOBAvailable = 1 THEN TIMESTAMPDIFF(
            YEAR,
            b.DateOfBirth,
            CURRENT_DATE
        )
    END
) >= 30";
	if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " and a.ANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " and a.AshaID = " . $this->filter_data['Asha'];
}
	if($this->db->query($query)->result())
 return $this->db->query($query)->result()[0]->total;
else
	return false;
}

public function get_ht_suspected(){
	$query = "SELECT
   count(*) as total
FROM
    (
    SELECT
        MAX(CreatedOn) AS CreatedOn,
        AshaID,
        ANMID,
    		STATUS,
        HHFamilyMemberGUID
    FROM
        `tblncdcbac`
    GROUP BY
        HHFamilyMemberGUID
) a
WHERE
    a.Status = 1 ";

    if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
{
	$query .= " and a.CreatedOn > '" . $this->filter_data['date_from'] . "' a.CreatedOn < '" . $this->filter_data['date_to'] . "'";
}

if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " and a.ANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " and a.AshaID = " . $this->filter_data['Asha'];
}

    if($this->db->query($query)->result())
 return $this->db->query($query)->result()[0]->total;
else
	return false;

}

public function get_ht_detected(){
	$query = "SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        MAX(CreatedOn),
    		STATUS,
        HHFamilyMemberGUID,
        SUBSTRING_INDEX(BP, '/', 1) AS systolic,
        REVERSE(
            SUBSTRING_INDEX(REVERSE(BP),
            '/',
            1)
        ) AS diastolic,
        AshaID,
        ANMID,
        CreatedOn
    FROM
        `tblncdscreening`
    GROUP BY
        HHFamilyMemberGUID
) a
WHERE
    a.Status = 1 AND(
        a.systolic >= 140 OR a.diastolic >= 90
    )";

    if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
{
	$query .= " and a.CreatedOn > '" . $this->filter_data['date_from'] . "' a.CreatedOn < '" . $this->filter_data['date_to'] . "'";
}

if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " and a.ANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " and a.AshaID = " . $this->filter_data['Asha'];
}
   if($this->db->query($query)->result())
 return $this->db->query($query)->result()[0]->total;
else
	return false;

}

public function get_ht_followup(){
	$query = "SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        a.*
    FROM
        (
        SELECT
            MAX(CreatedOn),
        STATUS
            ,
            HHFamilyMemberGUID,
            SUBSTRING_INDEX(BP, '/', 1) AS systolic,
            REVERSE(
                SUBSTRING_INDEX(REVERSE(BP),
                '/',
                1)
            ) AS diastolic,
             AshaID,
             ANMID,
             CreatedOn
        FROM
            `tblncdscreening`
        GROUP BY
            HHFamilyMemberGUID
    ) a
WHERE
    a.Status = 1 AND(
        a.systolic >= 140 OR a.diastolic >= 90
    )
) a
INNER JOIN(
    SELECT
        HHFamilyMemberGUID
    FROM
        tblncdfollowup
    GROUP BY
        HHFamilyMemberGUID
) b
ON
    a.HHFamilyMemberGUID = b.HHFamilyMemberGUID";

    if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
{
	$query .= " and a.CreatedOn > '" . $this->filter_data['date_from'] . "' a.CreatedOn < '" . $this->filter_data['date_to'] . "'";
}

if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " and a.ANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " and a.AshaID = " . $this->filter_data['Asha'];
}
if($this->db->query($query)->result())
 return $this->db->query($query)->result()[0]->total;
else
	return false;
}


public function get_bp_suspected(){
	$query = "SELECT
    *
FROM
    (
    SELECT
        MAX(CreatedOn) AS total,
    STATUS
        ,
        HHFamilyMemberGUID,
        AshaID,
        ANMID
    FROM
        `tblncdcbac`
    GROUP BY
        HHFamilyMemberGUID
) a
WHERE
    a.Status = 1";
        if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
{
	$query .= " and a.CreatedOn > '" . $this->filter_data['date_from'] . "' a.CreatedOn < '" . $this->filter_data['date_to'] . "'";
}

if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " and a.ANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " and a.AshaID = " . $this->filter_data['Asha'];
}
 if($this->db->query($query)->result())
 return $this->db->query($query)->result()[0]->total;
else
	return false;
}

public function get_bp_detected(){
	$query = "SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        MAX(CreatedOn),
    STATUS
        ,
        HHFamilyMemberGUID,
        ANMID,
        AshaID,
        SUBSTRING_INDEX(BP, '/', 1) AS systolic,
        REVERSE(
            SUBSTRING_INDEX(REVERSE(BP),
            '/',
            1)
        ) AS diastolic
    FROM
        `tblncdscreening`
    GROUP BY
        HHFamilyMemberGUID
) a
WHERE
    a.Status = 1 AND(
        a.systolic >= 140 OR a.diastolic >= 90
    )";
        if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
{
	$query .= " and a.CreatedOn > '" . $this->filter_data['date_from'] . "' a.CreatedOn < '" . $this->filter_data['date_to'] . "'";
}

if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " and a.ANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " and a.AshaID = " . $this->filter_data['Asha'];
}
 if($this->db->query($query)->result())
 return $this->db->query($query)->result()[0]->total;
else
	return false;
}

public function get_bp_followup(){
	$query = "SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        a.*
    FROM
        (
        SELECT
            MAX(CreatedOn),
        STATUS
            ,
            HHFamilyMemberGUID,
            ANMID,
            AshaID,
            RBS
        FROM
            `tblncdscreening`
        GROUP BY
            HHFamilyMemberGUID
    ) a
WHERE
    a.Status = 1 AND a.RBS > 140
) a
INNER JOIN(
    SELECT
        HHFamilyMemberGUID,
        AshaID,
        ANMID
    FROM
        tblncdfollowup
    GROUP BY
        HHFamilyMemberGUID
) b
ON
    a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
";
    if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
{
	$query .= " and a.CreatedOn > '" . $this->filter_data['date_from'] . "' a.CreatedOn < '" . $this->filter_data['date_to'] . "'";
}

if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " and a.ANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " and a.AshaID = " . $this->filter_data['Asha'];
}
if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " and b.ANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " and b.AshaID = " . $this->filter_data['Asha'];
}
 if($this->db->query($query)->result())
 return $this->db->query($query)->result()[0]->total;
else
	return false;
}


public function get_ht_bp_suspected(){
	$query = "SELECT
    *
FROM
    (
    SELECT
        MAX(CreatedOn) AS total,
    STATUS
        ,
        HHFamilyMemberGUID,
        AshaID,
        ANMID
    FROM
        `tblncdcbac`
    GROUP BY
        HHFamilyMemberGUID
) a
WHERE
    a.Status = 1";
     if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
{
	$query .= " and a.CreatedOn > '" . $this->filter_data['date_from'] . "' a.CreatedOn < '" . $this->filter_data['date_to'] . "'";
}

if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " and a.ANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " and a.AshaID = " . $this->filter_data['Asha'];
}
if($this->db->query($query)->result())
 return $this->db->query($query)->result()[0]->total;
else
	return false;
}

public function get_ht_bp_detected(){
	$query = "SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        MAX(CreatedOn),
    STATUS
        ,
        ANMID,
        AshaID,
        HHFamilyMemberGUID,
        SUBSTRING_INDEX(BP, '/', 1) AS systolic,
        REVERSE(
            SUBSTRING_INDEX(REVERSE(BP),
            '/',
            1)
        ) AS diastolic,
        RBS
    FROM
        `tblncdscreening`
    GROUP BY
        HHFamilyMemberGUID
) a
WHERE
    a.Status = 1 AND(
        a.systolic >= 140 OR a.diastolic >= 90
    ) AND a.RBS > 140";
     if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
{
	$query .= " and a.CreatedOn > '" . $this->filter_data['date_from'] . "' a.CreatedOn < '" . $this->filter_data['date_to'] . "'";
}

if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " and a.ANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " and a.AshaID = " . $this->filter_data['Asha'];
}
 if($this->db->query($query)->result())
 return $this->db->query($query)->result()[0]->total;
else
	return false;
}

public function get_ht_bp_followup(){
	$query = "SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        a.*
    FROM
        (
        SELECT
            MAX(CreatedOn),
        STATUS
            ,
            AshaID,
            ANMID,
            HHFamilyMemberGUID,
            SUBSTRING_INDEX(BP, '/', 1) AS systolic,
            REVERSE(
                SUBSTRING_INDEX(REVERSE(BP),
                '/',
                1)
            ) AS diastolic,
            RBS
        FROM
            `tblncdscreening`
        GROUP BY
            HHFamilyMemberGUID
    ) a
WHERE
    a.Status = 1 AND(
        a.systolic >= 140 OR a.diastolic >= 90
    ) and a.RBS > 140
) a
INNER JOIN(
    SELECT
        HHFamilyMemberGUID,
        ANMID,
        AshaID
    FROM
        tblncdfollowup
    GROUP BY
        HHFamilyMemberGUID
) b
ON
    a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
";
 if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
{
	$query .= " and a.CreatedOn > '" . $this->filter_data['date_from'] . "' a.CreatedOn < '" . $this->filter_data['date_to'] . "'";
}

if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " and a.ANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " and a.AshaID = " . $this->filter_data['Asha'];
}
if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " and b.ANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " and b.AshaID = " . $this->filter_data['Asha'];
}
 if($this->db->query($query)->result())
 return $this->db->query($query)->result()[0]->total;
else
	return false;
}
public function get_assessed_count_male()
{
	$query ="SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        HHFamilyMemberGUID,
        AshaID,
        ANMID
    FROM
        `tblncdcbac`
    GROUP BY
        HHFamilyMemberGUID
) a
INNER JOIN tblhhfamilymember b ON
    a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
    AND
    b.GenderID=1
WHERE
    (
        CASE WHEN b.DOBAvailable = 2 THEN b.AprilAgeYear +(
            YEAR(CURRENT_DATE) - b.AgeAsOnYear
        ) WHEN b.DOBAvailable = 1 THEN TIMESTAMPDIFF(
            YEAR,
            b.DateOfBirth,
            CURRENT_DATE
        )
    END
)";
if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " and a.ANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " and a.AshaID = " . $this->filter_data['Asha'];
}
if($this->db->query($query)->result())
 return $this->db->query($query)->result()[0]->total;
else
	return false;
}
public function get_assessed_count_female()
{
		$query ="SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        HHFamilyMemberGUID,
        AshaID,
        ANMID
    FROM
        `tblncdcbac`
    GROUP BY
        HHFamilyMemberGUID
) a
INNER JOIN tblhhfamilymember b ON
    a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
    AND
    b.GenderID=2
WHERE
    (
        CASE WHEN b.DOBAvailable = 2 THEN b.AprilAgeYear +(
            YEAR(CURRENT_DATE) - b.AgeAsOnYear
        ) WHEN b.DOBAvailable = 1 THEN TIMESTAMPDIFF(
            YEAR,
            b.DateOfBirth,
            CURRENT_DATE
        )
    END
)";
if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " and a.ANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " and a.AshaID = " . $this->filter_data['Asha'];
}
		if($this->db->query($query)->result())
 return $this->db->query($query)->result()[0]->total;
else
	return false;
}
public function get_assessed_count_both()
{

		$query ="SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        HHFamilyMemberGUID
    FROM
        `tblncdcbac`
    GROUP BY
        HHFamilyMemberGUID
) a
INNER JOIN tblhhfamilymember b ON
    a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
WHERE
    (
        CASE WHEN b.DOBAvailable = 2 THEN b.AprilAgeYear +(
            YEAR(CURRENT_DATE) - b.AgeAsOnYear
        ) WHEN b.DOBAvailable = 1 THEN TIMESTAMPDIFF(
            YEAR,
            b.DateOfBirth,
            CURRENT_DATE
        )
    END
)";
		if($this->db->query($query)->result())
 return $this->db->query($query)->result()[0]->total;
else
	return false;

}
public function get_screened_count_male()
{
	$query="SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        HHFamilyMemberGUID,
        AshaID,
        ANMID
    FROM
        `tblncdscreening`
    GROUP BY
        HHFamilyMemberGUID
) a
INNER JOIN tblhhfamilymember b ON
    a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
    AND
    b.GenderID=1
WHERE
    (
        CASE WHEN b.DOBAvailable = 2 THEN b.AprilAgeYear +(
            YEAR(CURRENT_DATE) - b.AgeAsOnYear
        ) WHEN b.DOBAvailable = 1 THEN TIMESTAMPDIFF(
            YEAR,
            b.DateOfBirth,
            CURRENT_DATE
        )
    END
)";
if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " and a.ANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " and a.AshaID = " . $this->filter_data['Asha'];
}
	if($this->db->query($query)->result())
 return $this->db->query($query)->result()[0]->total;
else
	return false;

}
public function get_screened_count_female()
{
	$query="SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        HHFamilyMemberGUID,
        AshaID,
        ANMID
    FROM
        `tblncdscreening`
    GROUP BY
        HHFamilyMemberGUID
) a
INNER JOIN tblhhfamilymember b ON
    a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
    AND
    b.GenderID=2
WHERE
    (
        CASE WHEN b.DOBAvailable = 2 THEN b.AprilAgeYear +(
            YEAR(CURRENT_DATE) - b.AgeAsOnYear
        ) WHEN b.DOBAvailable = 1 THEN TIMESTAMPDIFF(
            YEAR,
            b.DateOfBirth,
            CURRENT_DATE
        )
    END
)";
if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " and a.ANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " and a.AshaID = " . $this->filter_data['Asha'];
}
	if($this->db->query($query)->result())
 return $this->db->query($query)->result()[0]->total;
else
	return false;
}
public function get_screened_count_total()
{
$query="SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        HHFamilyMemberGUID,
        AshaID,
        ANMID
    FROM
        `tblncdscreening`
    GROUP BY
        HHFamilyMemberGUID
) a
INNER JOIN tblhhfamilymember b ON
    a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
WHERE
    (
        CASE WHEN b.DOBAvailable = 2 THEN b.AprilAgeYear +(
            YEAR(CURRENT_DATE) - b.AgeAsOnYear
        ) WHEN b.DOBAvailable = 1 THEN TIMESTAMPDIFF(
            YEAR,
            b.DateOfBirth,
            CURRENT_DATE
        )
    END
)";
if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " and a.ANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " and a.AshaID = " . $this->filter_data['Asha'];
}
if($this->db->query($query)->result())
 return $this->db->query($query)->result()[0]->total;
else
	return false;
}
public function get_ht_suspected_male()
{
	$query= "SELECT
   count(*) as total
FROM
    (
    SELECT
        MAX(CreatedOn) AS CreatedOn,
        AshaID,
        ANMID,
            STATUS,
        HHFamilyMemberGUID
    FROM
        `tblncdcbac`
    GROUP BY
        HHFamilyMemberGUID
) a
INNER JOIN tblhhfamilymember b ON
    a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
    AND
    b.GenderID=1
WHERE
    a.Status = 1";
    if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " and a.ANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " and a.AshaID = " . $this->filter_data['Asha'];
}
	if($this->db->query($query)->result())
 return $this->db->query($query)->result()[0]->total;
else
	return false;
}
public function get_ht_suspected_female()
{
	$query= "SELECT
   count(*) as total
FROM
    (
    SELECT
        MAX(CreatedOn) AS CreatedOn,
        AshaID,
        ANMID,
            STATUS,
        HHFamilyMemberGUID
    FROM
        `tblncdcbac`
    GROUP BY
        HHFamilyMemberGUID
) a
INNER JOIN tblhhfamilymember b ON
    a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
    AND
    b.GenderID=2
WHERE
    a.Status = 1";
    if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " and a.ANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " and a.AshaID = " . $this->filter_data['Asha'];
}
	if($this->db->query($query)->result())
 return $this->db->query($query)->result()[0]->total;
else
	return false;
}
public function get_ht_suspected_total()
{
	$query= "SELECT
   count(*) as total
FROM
    (
    SELECT
        MAX(CreatedOn) AS CreatedOn,
        AshaID,
        ANMID,
            STATUS,
        HHFamilyMemberGUID
    FROM
        `tblncdcbac`
    GROUP BY
        HHFamilyMemberGUID
) a
INNER JOIN tblhhfamilymember b ON
    a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
    
WHERE
    a.Status = 1";
    if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " and a.ANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " and a.AshaID = " . $this->filter_data['Asha'];
}
	if($this->db->query($query)->result())
 return $this->db->query($query)->result()[0]->total;
else
	return false;
}
public function get_ht_detected_male()
{
	$query="SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        MAX(CreatedOn),
            STATUS,
        HHFamilyMemberGUID,
        SUBSTRING_INDEX(BP, '/', 1) AS systolic,
        REVERSE(
            SUBSTRING_INDEX(REVERSE(BP),
            '/',
            1)
        ) AS diastolic,
        AshaID,
        ANMID,
        CreatedOn
    FROM
        `tblncdscreening`
    GROUP BY
        HHFamilyMemberGUID
) a
INNER JOIN tblhhfamilymember b ON
    a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
    AND
    b.GenderID=1
WHERE
    a.Status = 1 AND(
        a.systolic >= 140 OR a.diastolic >= 90
    )";
    if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " and a.ANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " and a.AshaID = " . $this->filter_data['Asha'];
}
	if($this->db->query($query)->result())
 return $this->db->query($query)->result()[0]->total;
else
	return false;
}
public function get_ht_detected_female()
{
	$query="SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        MAX(CreatedOn),
            STATUS,
        HHFamilyMemberGUID,
        SUBSTRING_INDEX(BP, '/', 1) AS systolic,
        REVERSE(
            SUBSTRING_INDEX(REVERSE(BP),
            '/',
            1)
        ) AS diastolic,
        AshaID,
        ANMID,
        CreatedOn
    FROM
        `tblncdscreening`
    GROUP BY
        HHFamilyMemberGUID
) a
INNER JOIN tblhhfamilymember b ON
    a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
    AND
    b.GenderID=2
WHERE
    a.Status = 1 AND(
        a.systolic >= 140 OR a.diastolic >= 90
    )";
    if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " and a.ANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " and a.AshaID = " . $this->filter_data['Asha'];
}
	if($this->db->query($query)->result())
 return $this->db->query($query)->result()[0]->total;
else
	return false;
}
public function get_ht_detected_total()
{
	$query="SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        MAX(CreatedOn),
            STATUS,
        HHFamilyMemberGUID,
        SUBSTRING_INDEX(BP, '/', 1) AS systolic,
        REVERSE(
            SUBSTRING_INDEX(REVERSE(BP),
            '/',
            1)
        ) AS diastolic,
        AshaID,
        ANMID,
        CreatedOn
    FROM
        `tblncdscreening`
    GROUP BY
        HHFamilyMemberGUID
) a
INNER JOIN tblhhfamilymember b ON
    a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
WHERE
    a.Status = 1 AND(
        a.systolic >= 140 OR a.diastolic >= 90
    )";
    if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " and a.ANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " and a.AshaID = " . $this->filter_data['Asha'];
}
	if($this->db->query($query)->result())
 return $this->db->query($query)->result()[0]->total;
else
	return false;
}
public function get_ht_followup_male()
{
	$query="SELECT
    count(*) as total
FROM
    (
    SELECT
        a.*
    FROM
        (
        SELECT
            MAX(CreatedOn),
        STATUS
            ,
            HHFamilyMemberGUID,
            SUBSTRING_INDEX(BP, '/', 1) AS systolic,
            REVERSE(
                SUBSTRING_INDEX(REVERSE(BP),
                '/',
                1)
            ) AS diastolic,
             AshaID,
             ANMID,
             CreatedOn
        FROM
            `tblncdscreening`
        GROUP BY
            HHFamilyMemberGUID
    ) a
WHERE
    a.Status = 1 AND(
        a.systolic >= 140 OR a.diastolic >= 90
    )
) a
INNER JOIN(
    SELECT
        HHFamilyMemberGUID
    FROM
        tblncdfollowup
    GROUP BY
        HHFamilyMemberGUID
) b
ON
    a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
inner join tblhhfamilymember c 
on a.HHFamilyMemberGUID = c.HHFamilyMemberGUID and c.GenderID=1
";
if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " and a.ANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " and a.AshaID = " . $this->filter_data['Asha'];
}
	if($this->db->query($query)->result())
 return $this->db->query($query)->result()[0]->total;
else
	return false;
}
public function get_ht_followup_female()
{
	$query="SELECT
    count(*) as total
FROM
    (
    SELECT
        a.*
    FROM
        (
        SELECT
            MAX(CreatedOn),
        STATUS
            ,
            HHFamilyMemberGUID,
            SUBSTRING_INDEX(BP, '/', 1) AS systolic,
            REVERSE(
                SUBSTRING_INDEX(REVERSE(BP),
                '/',
                1)
            ) AS diastolic,
             AshaID,
             ANMID,
             CreatedOn
        FROM
            `tblncdscreening`
        GROUP BY
            HHFamilyMemberGUID
    ) a
WHERE
    a.Status = 1 AND(
        a.systolic >= 140 OR a.diastolic >= 90
    )
) a
INNER JOIN(
    SELECT
        HHFamilyMemberGUID
    FROM
        tblncdfollowup
    GROUP BY
        HHFamilyMemberGUID
) b
ON
    a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
inner join tblhhfamilymember c 
on a.HHFamilyMemberGUID = c.HHFamilyMemberGUID and c.GenderID=2
";
if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " and a.ANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " and a.AshaID = " . $this->filter_data['Asha'];
}
	if($this->db->query($query)->result())
 return $this->db->query($query)->result()[0]->total;
else
	return false;
}
public function get_ht_followup_total()
{
	$query="SELECT
    count(*) as total
FROM
    (
    SELECT
        a.*
    FROM
        (
        SELECT
            MAX(CreatedOn),
        STATUS
            ,
            HHFamilyMemberGUID,
            SUBSTRING_INDEX(BP, '/', 1) AS systolic,
            REVERSE(
                SUBSTRING_INDEX(REVERSE(BP),
                '/',
                1)
            ) AS diastolic,
             AshaID,
             ANMID,
             CreatedOn
        FROM
            `tblncdscreening`
        GROUP BY
            HHFamilyMemberGUID
    ) a
WHERE
    a.Status = 1 AND(
        a.systolic >= 140 OR a.diastolic >= 90
    )
) a
INNER JOIN(
    SELECT
        HHFamilyMemberGUID
    FROM
        tblncdfollowup
    GROUP BY
        HHFamilyMemberGUID
) b
ON
    a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
";
if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " and a.ANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " and a.AshaID = " . $this->filter_data['Asha'];
}
	if($this->db->query($query)->result())
 return $this->db->query($query)->result()[0]->total;
else
	return false;
}
public function get_bp_suspected_male()
{
	$query="SELECT
    count(*) as total
FROM
    (
    SELECT
        MAX(CreatedOn) AS total,
    STATUS
        ,
        HHFamilyMemberGUID,
        AshaID,
        ANMID
    FROM
        `tblncdcbac`
    GROUP BY
        HHFamilyMemberGUID
) a
INNER JOIN tblhhfamilymember b ON
    a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
    AND
    b.GenderID=1
WHERE
    a.Status = 1";
    if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " and a.ANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " and a.AshaID = " . $this->filter_data['Asha'];
}
	if($this->db->query($query)->result())
 return $this->db->query($query)->result()[0]->total;
else
	return false;
}
public function get_bp_suspected_female()
{
	$query="SELECT
    count(*) as total
FROM
    (
    SELECT
        MAX(CreatedOn) AS total,
    STATUS
        ,
        HHFamilyMemberGUID,
        AshaID,
        ANMID
    FROM
        `tblncdcbac`
    GROUP BY
        HHFamilyMemberGUID
) a
INNER JOIN tblhhfamilymember b ON
    a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
    AND
    b.GenderID=2
WHERE
    a.Status = 1";
    if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " and a.ANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " and a.AshaID = " . $this->filter_data['Asha'];
}
	if($this->db->query($query)->result())
 return $this->db->query($query)->result()[0]->total;
else
	return false;
}
public function get_bp_suspected_total()
{
	$query="SELECT
    count(*) as total
FROM
    (
    SELECT
        MAX(CreatedOn) AS total,
    STATUS
        ,
        HHFamilyMemberGUID,
        AshaID,
        ANMID
    FROM
        `tblncdcbac`
    GROUP BY
        HHFamilyMemberGUID
) a
WHERE
    a.Status = 1";
    if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " and a.ANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " and a.AshaID = " . $this->filter_data['Asha'];
}
	if($this->db->query($query)->result())
 return $this->db->query($query)->result()[0]->total;
else
	return false;
}
public function get_bp_detected_male()
{
	$query="SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        MAX(CreatedOn),
    STATUS
        ,
        HHFamilyMemberGUID,
        ANMID,
        AshaID,
        SUBSTRING_INDEX(BP, '/', 1) AS systolic,
        REVERSE(
            SUBSTRING_INDEX(REVERSE(BP),
            '/',
            1)
        ) AS diastolic
    FROM
        `tblncdscreening`
    GROUP BY
        HHFamilyMemberGUID
) a
inner join tblhhfamilymember c 
on a.HHFamilyMemberGUID = c.HHFamilyMemberGUID and c.GenderID=1
WHERE
    a.Status = 1 AND(
        a.systolic >= 140 OR a.diastolic >= 90
    )
";
if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " and a.ANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " and a.AshaID = " . $this->filter_data['Asha'];
}
		if($this->db->query($query)->result())
 return $this->db->query($query)->result()[0]->total;
else
	return false;
}
public function get_bp_detected_female()
{
	$query="SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        MAX(CreatedOn),
    STATUS
        ,
        HHFamilyMemberGUID,
        ANMID,
        AshaID,
        SUBSTRING_INDEX(BP, '/', 1) AS systolic,
        REVERSE(
            SUBSTRING_INDEX(REVERSE(BP),
            '/',
            1)
        ) AS diastolic
    FROM
        `tblncdscreening`
    GROUP BY
        HHFamilyMemberGUID
) a
inner join tblhhfamilymember c 
on a.HHFamilyMemberGUID = c.HHFamilyMemberGUID and c.GenderID=2
WHERE
    a.Status = 1 AND(
        a.systolic >= 140 OR a.diastolic >= 90
    )
";
if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " and a.ANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " and a.AshaID = " . $this->filter_data['Asha'];
}
		if($this->db->query($query)->result())
 return $this->db->query($query)->result()[0]->total;
else
	return false;
}
public function get_bp_detected_total()
{
	$query="SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        MAX(CreatedOn),
    STATUS
        ,
        HHFamilyMemberGUID,
        ANMID,
        AshaID,
        SUBSTRING_INDEX(BP, '/', 1) AS systolic,
        REVERSE(
            SUBSTRING_INDEX(REVERSE(BP),
            '/',
            1)
        ) AS diastolic
    FROM
        `tblncdscreening`
    GROUP BY
        HHFamilyMemberGUID
) a
WHERE
    a.Status = 1 AND(
        a.systolic >= 140 OR a.diastolic >= 90
    )
";
if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " and a.ANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " and a.AshaID = " . $this->filter_data['Asha'];
}
		if($this->db->query($query)->result())
 return $this->db->query($query)->result()[0]->total;
else
	return false;
}
public function get_bp_followup_male()
{
	$query="SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        a.*
    FROM
        (
        SELECT
            MAX(CreatedOn),
        STATUS
            ,
            HHFamilyMemberGUID,
            ANMID,
            AshaID,
            RBS
        FROM
            `tblncdscreening`
        GROUP BY
            HHFamilyMemberGUID
    ) a
WHERE
    a.Status = 1 AND a.RBS > 140
) a
INNER JOIN(
    SELECT
        HHFamilyMemberGUID,
        AshaID,
        ANMID
    FROM
        tblncdfollowup
    GROUP BY
        HHFamilyMemberGUID
) b
ON
    a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
inner join tblhhfamilymember c 
on a.HHFamilyMemberGUID = c.HHFamilyMemberGUID and c.GenderID=1";
if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " and a.ANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " and a.AshaID = " . $this->filter_data['Asha'];
}
		if($this->db->query($query)->result())
 return $this->db->query($query)->result()[0]->total;
else
	return false;
}
public function get_bp_followup_female()
{
	$query="SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        a.*
    FROM
        (
        SELECT
            MAX(CreatedOn),
        STATUS
            ,
            HHFamilyMemberGUID,
            ANMID,
            AshaID,
            RBS
        FROM
            `tblncdscreening`
        GROUP BY
            HHFamilyMemberGUID
    ) a
WHERE
    a.Status = 1 AND a.RBS > 140
) a
INNER JOIN(
    SELECT
        HHFamilyMemberGUID,
        AshaID,
        ANMID
    FROM
        tblncdfollowup
    GROUP BY
        HHFamilyMemberGUID
) b
ON
    a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
inner join tblhhfamilymember c 
on a.HHFamilyMemberGUID = c.HHFamilyMemberGUID and c.GenderID=2";
	if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " and a.ANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " and a.AshaID = " . $this->filter_data['Asha'];
}
		if($this->db->query($query)->result())
 return $this->db->query($query)->result()[0]->total;
else
	return false;
}
public function get_bp_followup_total()
{
	$query="SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        a.*
    FROM
        (
        SELECT
            MAX(CreatedOn),
        STATUS
            ,
            HHFamilyMemberGUID,
            ANMID,
            AshaID,
            RBS
        FROM
            `tblncdscreening`
        GROUP BY
            HHFamilyMemberGUID
    ) a
WHERE
    a.Status = 1 AND a.RBS > 140
) a
INNER JOIN(
    SELECT
        HHFamilyMemberGUID,
        AshaID,
        ANMID
    FROM
        tblncdfollowup
    GROUP BY
        HHFamilyMemberGUID
) b
ON
    a.HHFamilyMemberGUID = b.HHFamilyMemberGUID";
	if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " and a.ANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " and a.AshaID = " . $this->filter_data['Asha'];
}
		if($this->db->query($query)->result())
 return $this->db->query($query)->result()[0]->total;
else
	return false;
}
public function get_ht_bp_suspected_male()
{
	$query="SELECT
    count(*) as total
FROM
    (
    SELECT
        MAX(CreatedOn) AS total,
    STATUS
        ,
        HHFamilyMemberGUID,
        AshaID,
        ANMID
    FROM
        `tblncdcbac`
    GROUP BY
        HHFamilyMemberGUID
) a
INNER JOIN tblhhfamilymember b ON
    a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
    AND
    b.GenderID=1
WHERE
    a.Status = 1";
    if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " and a.ANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " and a.AshaID = " . $this->filter_data['Asha'];
}
		if($this->db->query($query)->result())
 return $this->db->query($query)->result()[0]->total;
else
	return false;
}
public function get_ht_bp_suspected_female()
{
	$query="SELECT
    count(*) as total
FROM
    (
    SELECT
        MAX(CreatedOn) AS total,
    STATUS
        ,
        HHFamilyMemberGUID,
        AshaID,
        ANMID
    FROM
        `tblncdcbac`
    GROUP BY
        HHFamilyMemberGUID
) a
INNER JOIN tblhhfamilymember b ON
    a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
    AND
    b.GenderID=2
WHERE
    a.Status = 1";
    if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " and a.ANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " and a.AshaID = " . $this->filter_data['Asha'];
}
		if($this->db->query($query)->result())
 return $this->db->query($query)->result()[0]->total;
else
	return false;
}
public function get_ht_bp_suspected_total()
{
	$query="SELECT
    count(*) as total
FROM
    (
    SELECT
        MAX(CreatedOn) AS total,
    STATUS
        ,
        HHFamilyMemberGUID,
        AshaID,
        ANMID
    FROM
        `tblncdcbac`
    GROUP BY
        HHFamilyMemberGUID
) a

WHERE
    a.Status = 1";
    if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " and a.ANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " and a.AshaID = " . $this->filter_data['Asha'];
}
		if($this->db->query($query)->result())
 return $this->db->query($query)->result()[0]->total;
else
	return false;
}
public function get_ht_bp_detected_male()
{
	$query="SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        MAX(CreatedOn),
    STATUS
        ,
        ANMID,
        AshaID,
        HHFamilyMemberGUID,
        SUBSTRING_INDEX(BP, '/', 1) AS systolic,
        REVERSE(
            SUBSTRING_INDEX(REVERSE(BP),
            '/',
            1)
        ) AS diastolic,
        RBS
    FROM
        `tblncdscreening`
    GROUP BY
        HHFamilyMemberGUID
) a
INNER JOIN tblhhfamilymember b ON
    a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
    AND
    b.GenderID=1
WHERE
    a.Status = 1 AND(
        a.systolic >= 140 OR a.diastolic >= 90
    ) AND a.RBS > 140";
    if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " and a.ANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " and a.AshaID = " . $this->filter_data['Asha'];
}
	if($this->db->query($query)->result())
 return $this->db->query($query)->result()[0]->total;
else
	return false;
}
public function get_ht_bp_detected_female()
{
	$query="SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        MAX(CreatedOn),
    STATUS
        ,
        ANMID,
        AshaID,
        HHFamilyMemberGUID,
        SUBSTRING_INDEX(BP, '/', 1) AS systolic,
        REVERSE(
            SUBSTRING_INDEX(REVERSE(BP),
            '/',
            1)
        ) AS diastolic,
        RBS
    FROM
        `tblncdscreening`
    GROUP BY
        HHFamilyMemberGUID
) a
INNER JOIN tblhhfamilymember b ON
    a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
    AND
    b.GenderID=2
WHERE
    a.Status = 1 AND(
        a.systolic >= 140 OR a.diastolic >= 90
    ) AND a.RBS > 140";
    if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " and a.ANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " and a.AshaID = " . $this->filter_data['Asha'];
}
	if($this->db->query($query)->result())
 return $this->db->query($query)->result()[0]->total;
else
	return false;
}
public function get_ht_bp_detected_total()
{
	$query="SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        MAX(CreatedOn),
    STATUS
        ,
        ANMID,
        AshaID,
        HHFamilyMemberGUID,
        SUBSTRING_INDEX(BP, '/', 1) AS systolic,
        REVERSE(
            SUBSTRING_INDEX(REVERSE(BP),
            '/',
            1)
        ) AS diastolic,
        RBS
    FROM
        `tblncdscreening`
    GROUP BY
        HHFamilyMemberGUID
) a
WHERE
    a.Status = 1 AND(
        a.systolic >= 140 OR a.diastolic >= 90
    ) AND a.RBS > 140";
    if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " and a.ANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " and a.AshaID = " . $this->filter_data['Asha'];
}
	if($this->db->query($query)->result())
 return $this->db->query($query)->result()[0]->total;
else
	return false;
}
public function get_ht_bp_followup_male()
{
	$query ="SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        a.*
    FROM
        (
        SELECT
            MAX(CreatedOn),
        STATUS
            ,
            AshaID,
            ANMID,
            HHFamilyMemberGUID,
            SUBSTRING_INDEX(BP, '/', 1) AS systolic,
            REVERSE(
                SUBSTRING_INDEX(REVERSE(BP),
                '/',
                1)
            ) AS diastolic,
            RBS
        FROM
            `tblncdscreening`
        GROUP BY
            HHFamilyMemberGUID
    ) a
WHERE
    a.Status = 1 AND(
        a.systolic >= 140 OR a.diastolic >= 90
    ) and a.RBS > 140
) a
INNER JOIN(
    SELECT
        HHFamilyMemberGUID,
        ANMID,
        AshaID
    FROM
        tblncdfollowup
    GROUP BY
        HHFamilyMemberGUID
) b
ON
    a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
inner join tblhhfamilymember c 
on a.HHFamilyMemberGUID = c.HHFamilyMemberGUID and c.GenderID=1
";
if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " and a.ANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " and a.AshaID = " . $this->filter_data['Asha'];
}
	if($this->db->query($query)->result())
 return $this->db->query($query)->result()[0]->total;
else
	return false;
}
public function get_ht_bp_followup_female()
{
	$query ="SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        a.*
    FROM
        (
        SELECT
            MAX(CreatedOn),
        STATUS
            ,
            AshaID,
            ANMID,
            HHFamilyMemberGUID,
            SUBSTRING_INDEX(BP, '/', 1) AS systolic,
            REVERSE(
                SUBSTRING_INDEX(REVERSE(BP),
                '/',
                1)
            ) AS diastolic,
            RBS
        FROM
            `tblncdscreening`
        GROUP BY
            HHFamilyMemberGUID
    ) a
WHERE
    a.Status = 1 AND(
        a.systolic >= 140 OR a.diastolic >= 90
    ) and a.RBS > 140
) a
INNER JOIN(
    SELECT
        HHFamilyMemberGUID,
        ANMID,
        AshaID
    FROM
        tblncdfollowup
    GROUP BY
        HHFamilyMemberGUID
) b
ON
    a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
inner join tblhhfamilymember c 
on a.HHFamilyMemberGUID = c.HHFamilyMemberGUID and c.GenderID=2
";
if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " and a.ANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " and a.AshaID = " . $this->filter_data['Asha'];
}
	if($this->db->query($query)->result())
 return $this->db->query($query)->result()[0]->total;
else
	return false;
}
public function get_ht_bp_followup_total()
{
	$query ="SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        a.*
    FROM
        (
        SELECT
            MAX(CreatedOn),
        STATUS
            ,
            AshaID,
            ANMID,
            HHFamilyMemberGUID,
            SUBSTRING_INDEX(BP, '/', 1) AS systolic,
            REVERSE(
                SUBSTRING_INDEX(REVERSE(BP),
                '/',
                1)
            ) AS diastolic,
            RBS
        FROM
            `tblncdscreening`
        GROUP BY
            HHFamilyMemberGUID
    ) a
WHERE
    a.Status = 1 AND(
        a.systolic >= 140 OR a.diastolic >= 90
    ) and a.RBS > 140
) a
INNER JOIN(
    SELECT
        HHFamilyMemberGUID,
        ANMID,
        AshaID
    FROM
        tblncdfollowup
    GROUP BY
        HHFamilyMemberGUID
) b
ON
    a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
";
if ($this->filter_data['ANM'] != NULL) 
{
	$query .= " and a.ANMID = " . $this->filter_data['ANM'];
}

if ($this->filter_data['Asha'] != NULL) 
{
	$query .= " and a.AshaID = " . $this->filter_data['Asha'];
}
if($this->db->query($query)->result())
return $this->db->query($query)->result()[0]->total;
else
	return false;
}
}