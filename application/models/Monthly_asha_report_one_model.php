<?php 

/**
* Monthly_asha_report_model
*/
class Monthly_asha_report_one_model extends Ci_model
{
	
	public function __construct()
	{
		
	}

	public function get_report()
	{

		$ASHAID = $this->input->post('ashaid');
		
		$query = "SELECT a.*, c.ANMName, e.SubCenterName from (
		SELECT
		a.ASHAID,
		a.ASHAName,
		group_concat(c.VillageName) as Villages
		FROM
		mstasha a
		left JOIN ashavillage b ON
		a.ASHAID = b.ASHAID
		inner join mstvillage c 
		on b.VillageID = c.VillageID and c.LanguageID = 2
		where a.LanguageID = 2 and a.IsActive = 1
		group by a.ASHAID)a 
		left join anmasha b 
		on a.ASHAID = b.ASHAID
		left join mstanm c 
		on b.ANMID = c.ANMID and c.LanguageID = 2 and c.IsActive = 1
		left join anmsubcenter d 
		on c.ANMID = d.ANMID 
		left join mstsubcenter e 
		on d.SubCenterID = e.SubCenterID and e.LanguageID = 2
		where a.ASHAID = ?";

		$result = $this->db->query($query, [$ASHAID])->result();

		if (count($result) < 1) {
			die("ERROR: No ASHA record found with this ASHAID = $ASHAID");
		}

		$content['asha_data'] = $result[0];

		$query = "SELECT
		c.child_name,
		d.PWName,
		c.child_dob,
		(case when c.place_of_birth = 1 THEN 'Home' WHEN c.place_of_birth = 2 THEN 'Hospital' WHEN c.place_of_birth = 3 THEN 'On the Way' END) as place_of_birth,
		(case when c.Gender = 1 THEN 'FeMale' when c.Gender = 2 THEN 'Male' WHEN c.Gender = 3 THEN 'Others' END) as Gender
		FROM
		mstasha a
		INNER JOIN userashamapping b ON
		a.ASHAID = b.AshaID
		INNER JOIN tblchild c ON
		b.UserID = c.created_by
		INNER JOIN tblpregnant_woman d ON
		d.PWGUID = c.pw_GUID
		WHERE
		a.ASHAID = ? AND a.LanguageID = 1 and c.IsDeleted = 0 and d.IsDeleted = 0 AND 
		c.child_dob > '".$this->input->post('date_from')."' and c.child_dob < '".$this->input->post('date_to')."'";
		
		$content['child_data'] = $this->db->query($query, [$ASHAID])->result();


		$query = "SELECT
		COUNT(*) AS total
		FROM
		(
		SELECT
		TIMESTAMPDIFF(MONTH, child_dob, NOW()) AS ageInMonth
		FROM
		tblchild a
		INNER JOIN tblhhsurvey c ON
		a.HHGUID = c.HHSurveyGUID
		WHERE
		a.ASHAID = ? AND a.IsDeleted = 0 AND c.IsDeleted = 0 AND 
		a.child_dob > '".$this->input->post('date_from')."' and a.child_dob < '".$this->input->post('date_to')."') a
		WHERE
		a.ageInMonth >= 0 AND a.ageInMonth <= 12";

		$content['child_count'] = $this->db->query($query, [$ASHAID])->result()[0];
        // print_r($content['child_count']); die();


		$query = "SELECT
		COUNT(*) AS total
		FROM
		(
		SELECT
		TIMESTAMPDIFF(MONTH, child_dob, NOW()) AS ageInMonth
		FROM
		tblchild a
		INNER JOIN tblhhsurvey c ON
		a.HHGUID = c.HHSurveyGUID
		WHERE
		a.ASHAID = ? AND a.IsDeleted = 0 AND c.IsDeleted = 0 and a.bcg is not null and a.opv1 is not null AND 
		a.child_dob > '".$this->input->post('date_from')."' and a.child_dob < '".$this->input->post('date_to')."') a
		WHERE
		a.ageInMonth >= 0 AND a.ageInMonth <= 12";

		$content['child_bcg_opv1'] = $this->db->query($query, [$ASHAID])->result()[0];


		$query = "SELECT
		COUNT(*) AS total
		FROM
		(
		SELECT
		TIMESTAMPDIFF(MONTH, child_dob, NOW()) AS ageInMonth
		FROM
		tblchild a
		INNER JOIN tblhhsurvey c ON
		a.HHGUID = c.HHSurveyGUID
		WHERE
		a.ASHAID = ? AND a.IsDeleted = 0  AND c.IsDeleted = 0 and a.dpt1 is not null and a.opv2 is not null AND 
		a.child_dob > '".$this->input->post('date_from')."' and a.child_dob < '".$this->input->post('date_to')."') a
		WHERE
		a.ageInMonth >= 0 AND a.ageInMonth <= 12";

		$content['child_dpt1_opv2'] = $this->db->query($query, [$ASHAID])->result()[0];

		$query = "SELECT
		COUNT(*) AS total
		FROM
		(
		SELECT
		TIMESTAMPDIFF(MONTH, child_dob, NOW()) AS ageInMonth
		FROM
		tblchild a
		INNER JOIN tblhhsurvey c ON
		a.HHGUID = c.HHSurveyGUID
		WHERE
		a.ASHAID = ? AND a.IsDeleted = 0  AND c.IsDeleted = 0 and a.dpt2 is not null and a.opv3 is not null AND 
		a.child_dob > '".$this->input->post('date_from')."' and a.child_dob < '".$this->input->post('date_to')."') a
		WHERE
		a.ageInMonth >= 0 AND a.ageInMonth <= 12";

		$content['child_dpt2_opv3'] = $this->db->query($query, [$ASHAID])->result()[0];

		$query = "SELECT
		COUNT(*) AS total
		FROM
		(
		SELECT
		TIMESTAMPDIFF(MONTH, child_dob, NOW()) AS ageInMonth
		FROM
		tblchild a
		INNER JOIN tblhhsurvey c ON
		a.HHGUID = c.HHSurveyGUID
		WHERE
		a.ASHAID = ? AND a.IsDeleted = 0  AND c.IsDeleted = 0 and a.dpt3 is not null and a.opv4 is not null AND 
		a.child_dob > '".$this->input->post('date_from')."' and a.child_dob < '".$this->input->post('date_to')."') a
		WHERE
		a.ageInMonth >= 0 AND a.ageInMonth <= 12";

		$content['child_dpt3_opv4'] = $this->db->query($query, [$ASHAID])->result()[0];


		$query = "SELECT
		COUNT(*) AS total
		FROM
		(
		SELECT
		TIMESTAMPDIFF(MONTH, child_dob, NOW()) AS ageInMonth
		FROM
		tblchild a
		INNER JOIN tblhhsurvey c ON
		a.HHGUID = c.HHSurveyGUID
		WHERE
		a.ASHAID = ? AND a.IsDeleted = 0 AND c.IsDeleted = 0 and a.Pentavalent1 is not null and a.opv2 is not null AND 
		a.child_dob > '".$this->input->post('date_from')."' and a.child_dob < '".$this->input->post('date_to')."') a
		WHERE
		a.ageInMonth >= 0 AND a.ageInMonth <= 12";

		$content['child_pentavalent1_opv2'] = $this->db->query($query,[$ASHAID])->result()[0];



		$query = "SELECT
		COUNT(*) AS total
		FROM
		(
		SELECT
		TIMESTAMPDIFF(MONTH, child_dob, NOW()) AS ageInMonth
		FROM
		tblchild a
		INNER JOIN tblhhsurvey c ON
		a.HHGUID = c.HHSurveyGUID
		WHERE
		a.ASHAID = ? AND a.IsDeleted = 0  AND c.IsDeleted = 0 and a.Pentavalent2 is not null and a.opv3 is not null AND 
		a.child_dob > '".$this->input->post('date_from')."' and a.child_dob < '".$this->input->post('date_to')."') a
		WHERE
		a.ageInMonth >= 0 AND a.ageInMonth <= 12";

		$content['child_pentavalent2_opv3'] = $this->db->query($query, [$ASHAID])->result()[0];



		$query = "SELECT
		COUNT(*) AS total
		FROM
		(
		SELECT
		TIMESTAMPDIFF(MONTH, child_dob, NOW()) AS ageInMonth
		FROM
		tblchild a
		INNER JOIN tblhhsurvey c ON
		a.HHGUID = c.HHSurveyGUID
		WHERE
		a.ASHAID = ? AND a.IsDeleted = 0 AND c.IsDeleted = 0 and a.Pentavalent3 is not null and a.opv4 is not null AND 
		a.child_dob > '".$this->input->post('date_from')."' and a.child_dob < '".$this->input->post('date_to')."') a
		WHERE
		a.ageInMonth >= 0 AND a.ageInMonth <= 12";

		$content['child_pentavalent3_opv4'] = $this->db->query($query, [$ASHAID])->result()[0];


		$query = "SELECT
		COUNT(*) AS total
		FROM
		(
		SELECT
		TIMESTAMPDIFF(MONTH, child_dob, NOW()) AS ageInMonth
		FROM
		tblchild a
		INNER JOIN tblhhsurvey c ON
		a.HHGUID = c.HHSurveyGUID
		WHERE
		a.ASHAID = ? AND a.IsDeleted = 0  AND c.IsDeleted = 0 AND a.measeals IS NOT NULL AND a.bcg IS NOT NULL AND a.opv1 IS NOT NULL AND a.dpt1 IS NOT NULL AND a.opv2 IS NOT NULL AND a.dpt2 IS NOT NULL AND a.opv3 IS NOT NULL AND a.dpt3 IS NOT NULL AND a.opv4 IS NOT NULL AND a.Pentavalent1 IS NOT NULL AND a.Pentavalent2 IS NOT NULL AND a.Pentavalent3 IS NOT NULL AND 
		a.child_dob > '".$this->input->post('date_from')."' and a.child_dob < '".$this->input->post('date_to')."') a
		WHERE
		a.ageInMonth >= 0 AND a.ageInMonth <= 12";

		$content['child_measels_allimmunization'] = $this->db->query($query, [$ASHAID])->result()[0];


		$query = "SELECT
		COUNT(*) AS total
		FROM
		(
		SELECT
		TIMESTAMPDIFF(MONTH, child_dob, NOW()) AS ageInMonth
		FROM
		tblchild a
		INNER JOIN tblhhsurvey c ON
		a.HHGUID = c.HHSurveyGUID
		WHERE
		a.ASHAID = ? AND a.IsDeleted = 0  AND c.IsDeleted = 0  AND 
		a.child_dob > '".$this->input->post('date_from')."' and a.child_dob < '".$this->input->post('date_to')."') a
		WHERE
		a.ageInMonth > 12 AND a.ageInMonth <= 24";

		$content['child_1_2'] = $this->db->query($query, [$ASHAID])->result()[0];


		$query = "SELECT
		COUNT(*) AS total
		FROM
		(
		SELECT
		TIMESTAMPDIFF(MONTH, child_dob, NOW()) AS ageInMonth
		FROM
		tblchild a
		INNER JOIN tblhhsurvey c ON
		a.HHGUID = c.HHSurveyGUID
		WHERE
		a.ASHAID = ? AND a.IsDeleted = 0 AND c.IsDeleted = 0 and a.DPTBooster is not null and a.OPVBooster is NOT null AND 
		a.child_dob > '".$this->input->post('date_from')."' and a.child_dob < '".$this->input->post('date_to')."') a
		WHERE
		a.ageInMonth > 12 AND a.ageInMonth <= 24";

		$content['dpt_opv_booster'] = $this->db->query($query, [$ASHAID])->result()[0];



		$query = "SELECT
		COUNT(*) AS total
		FROM
		(
		SELECT
		TIMESTAMPDIFF(MONTH, child_dob, NOW()) AS ageInMonth
		FROM
		tblchild a
		INNER JOIN tblhhsurvey c ON
		a.HHGUID = c.HHSurveyGUID
		WHERE
		a.ASHAID = ? AND a.IsDeleted = 0  AND c.IsDeleted = 0 and a.measeals is not null AND 
		a.child_dob > '".$this->input->post('date_from')."' and a.child_dob < '".$this->input->post('date_to')."') a
		WHERE
		a.ageInMonth > 12 AND a.ageInMonth <= 24";

		$content['child_1_2_measeles'] = $this->db->query($query, [$ASHAID])->result()[0];


		$query = "SELECT
		COUNT(*) AS total
		FROM
		tblpregnant_woman a
		INNER JOIN tblhhfamilymember b ON
		a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
		WHERE
		a.IsDeleted = 0 AND b.IsDeleted = 0 AND a.IsPregnant = 1 AND a.AshaID = ? AND 
		a.LMPDate > '".$this->input->post('date_from')."' and a.LMPDate < '".$this->input->post('date_to')."'";


		$content['totalpregnentwomen'] = $this->db->query($query, [$ASHAID])->result()[0];


		$query = "SELECT
		COUNT(*) AS total
		FROM
		tblpregnant_woman a
		INNER JOIN tblhhfamilymember b ON
		a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
		WHERE
		a.IsDeleted = 0 AND b.IsDeleted = 0 AND a.IsPregnant = 1 AND a.AshaID = ? AND TIMESTAMPDIFF(
		DAY,
		a.LMPDate,
		CURRENT_TIMESTAMP
		) > 0 AND TIMESTAMPDIFF(
		DAY,
		a.LMPDate,
		CURRENT_TIMESTAMP
	) <= 90 AND 
		a.LMPDate > '".$this->input->post('date_from')."' and a.LMPDate < '".$this->input->post('date_to')."'";

	$content['totalpregnentwomen_0_3'] = $this->db->query($query, [$ASHAID])->result()[0];


	$query = "SELECT
	COUNT(*) AS total
	FROM
	tblpregnant_woman a
	INNER JOIN tblhhfamilymember b ON
	a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
	WHERE
	a.IsDeleted = 0 AND b.IsDeleted = 0 AND a.IsPregnant = 1 AND a.AshaID = ? AND TIMESTAMPDIFF(
	DAY,
	a.LMPDate,
	CURRENT_TIMESTAMP
	) > 90 AND TIMESTAMPDIFF(
	DAY,
	a.LMPDate,
	CURRENT_TIMESTAMP
) <= 180 AND 
		a.LMPDate > '".$this->input->post('date_from')."' and a.LMPDate < '".$this->input->post('date_to')."'";

$content['totalpregnentwomen_3_6'] = $this->db->query($query, [$ASHAID])->result()[0];


$query = "SELECT
COUNT(*) AS total
FROM
tblpregnant_woman a
INNER JOIN tblhhfamilymember b ON
a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
WHERE
a.IsDeleted = 0 AND b.IsDeleted = 0 AND a.IsPregnant = 1 AND a.AshaID = ? AND TIMESTAMPDIFF(
DAY,
a.LMPDate,
CURRENT_TIMESTAMP
) >= 180 AND TIMESTAMPDIFF(
DAY,
a.LMPDate,
CURRENT_TIMESTAMP
) <= 270 AND 
		a.LMPDate > '".$this->input->post('date_from')."' and a.LMPDate < '".$this->input->post('date_to')."'";

$content['totalpregnentwomen_7_8'] = $this->db->query($query, [$ASHAID])->result()[0];


$query = "SELECT
COUNT(*) AS total
FROM
tblpregnant_woman a
INNER JOIN tblhhfamilymember b ON
a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
WHERE
a.IsDeleted = 0 AND b.IsDeleted = 0 AND a.IsPregnant = 1 AND a.AshaID = ? AND TIMESTAMPDIFF(
DAY,
a.LMPDate,
CURRENT_TIMESTAMP
) >= 270 AND 
		a.LMPDate > '".$this->input->post('date_from')."' and a.LMPDate < '".$this->input->post('date_to')."'";

$content['totalpregnentwomen_8_9'] = $this->db->query($query, [$ASHAID])->result()[0];



// death status for child and pregnent women

$query = "SELECT
a.child_name AS NAME,
b.PWName AS NAME, TIMESTAMPDIFF(MONTH, child_dob, NOW()) AS age
FROM
tblchild a
INNER JOIN tblpregnant_woman b ON
a.pw_GUID = b.PWGUID
INNER JOIN tblhhfamilymember c ON
c.HHFamilyMemberGUID = b.HHFamilyMemberGUID
INNER JOIN tblhhsurvey d ON
d.HHSurveyGUID = c.HHSurveyGUID
INNER JOIN userashamapping e ON
a.created_by = e.UserID
WHERE
a.IsDeleted = 0 AND b.IsDeleted = 0 AND c.IsDeleted = 0 AND a.child_status = 1 AND a.mother_status = 1 AND e.AshaID = ?";

$content['status_name'] = $this->db->query($query, [$ASHAID])->result();

return $content;
}

}