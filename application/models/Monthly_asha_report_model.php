<?php 

/**
* Monthly_asha_report_model
*/
class Monthly_asha_report_model extends Ci_model
{
	
	public function __construct()
	{
		
	}

	public function monthly_asha_report_1()
	{

		// $ASHAID = $this->input->post('ashaid');

		$ASHAID = 4;
		$from_date = '12/3/2014';
		$to_date = '12/3/2018';
		// die($from_date);

		
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

		 // die($query);

		$result = $this->db->query($query, [$ASHAID])->result();

		// if (count($result) < 1) {
		// 	die("ERROR: No ASHA record found with this ASHAID = $ASHAID");
		// }

		$content['asha_data'] = $result[0];

    // print_r($content['asha_data']); die();


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
		a.ASHAID = ? AND a.LanguageID = 1 and c.IsDeleted = 0 and d.IsDeleted = 0 ";
		// AND 
		// c.child_dob > '".$this->input->post('date_from')."' and c.child_dob < '".$this->input->post('date_to')."'";
		// die($query);

		$content['child_data'] = $this->db->query($query, [$ASHAID])->result();


		$query = "SELECT
		COUNT(*) AS total
		FROM
		(
		SELECT
		TIMESTAMPDIFF(MONTH, child_dob, NOW()) AS ageInMonth
		FROM
		tblchild a
		INNER JOIN tblhhfamilymember b ON
		a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey c ON
		b.HHSurveyGUID = c.HHSurveyGUID
		INNER JOIN userashamapping d ON
		a.created_by = d.UserID
		WHERE
		d.ASHAID = ? AND a.IsDeleted = 0 AND b.IsDeleted = 0 AND c.IsDeleted = 0) a
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
		INNER JOIN tblhhfamilymember b ON
		a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey c ON
		b.HHSurveyGUID = c.HHSurveyGUID
		INNER JOIN userashamapping d ON
		a.created_by = d.UserID
		WHERE
		d.ASHAID = ? AND a.IsDeleted = 0 AND b.IsDeleted = 0 AND c.IsDeleted = 0 and a.bcg is not null and a.opv1 is not null) a
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
		INNER JOIN tblhhfamilymember b ON
		a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey c ON
		b.HHSurveyGUID = c.HHSurveyGUID
		INNER JOIN userashamapping d ON
		a.created_by = d.UserID
		WHERE
		d.ASHAID = ? AND a.IsDeleted = 0 AND b.IsDeleted = 0 AND c.IsDeleted = 0 and a.dpt1 is not null and a.opv2 is not null) a
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
		INNER JOIN tblhhfamilymember b ON
		a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey c ON
		b.HHSurveyGUID = c.HHSurveyGUID
		INNER JOIN userashamapping d ON
		a.created_by = d.UserID
		WHERE
		d.ASHAID = ? AND a.IsDeleted = 0 AND b.IsDeleted = 0 AND c.IsDeleted = 0 and a.dpt2 is not null and a.opv3 is not null) a
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
		INNER JOIN tblhhfamilymember b ON
		a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey c ON
		b.HHSurveyGUID = c.HHSurveyGUID
		INNER JOIN userashamapping d ON
		a.created_by = d.UserID
		WHERE
		d.ASHAID = ? AND a.IsDeleted = 0 AND b.IsDeleted = 0 AND c.IsDeleted = 0 and a.dpt3 is not null and a.opv4 is not null) a
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
		INNER JOIN tblhhfamilymember b ON
		a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey c ON
		b.HHSurveyGUID = c.HHSurveyGUID
		INNER JOIN userashamapping d ON
		a.created_by = d.UserID
		WHERE
		d.ASHAID = ? AND a.IsDeleted = 0 AND b.IsDeleted = 0 AND c.IsDeleted = 0 and a.Pentavalent1 is not null and a.opv2 is not null) a
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
		INNER JOIN tblhhfamilymember b ON
		a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey c ON
		b.HHSurveyGUID = c.HHSurveyGUID
		INNER JOIN userashamapping d ON
		a.created_by = d.UserID
		WHERE
		d.ASHAID = ? AND a.IsDeleted = 0 AND b.IsDeleted = 0 AND c.IsDeleted = 0 and a.Pentavalent2 is not null and a.opv3 is not null) a
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
		INNER JOIN tblhhfamilymember b ON
		a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey c ON
		b.HHSurveyGUID = c.HHSurveyGUID
		INNER JOIN userashamapping d ON
		a.created_by = d.UserID
		WHERE
		d.ASHAID = ? AND a.IsDeleted = 0 AND b.IsDeleted = 0 AND c.IsDeleted = 0 and a.Pentavalent3 is not null and a.opv4 is not null) a
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
		INNER JOIN tblhhfamilymember b ON
		a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey c ON
		b.HHSurveyGUID = c.HHSurveyGUID
		INNER JOIN userashamapping d ON
		a.created_by = d.UserID
		WHERE
		d.ASHAID = ? AND a.IsDeleted = 0 AND b.IsDeleted = 0 AND c.IsDeleted = 0 AND a.measeals IS NOT NULL AND a.bcg IS NOT NULL AND a.opv1 IS NOT NULL AND a.dpt1 IS NOT NULL AND a.opv2 IS NOT NULL AND a.dpt2 IS NOT NULL AND a.opv3 IS NOT NULL AND a.dpt3 IS NOT NULL AND a.opv4 IS NOT NULL AND a.Pentavalent1 IS NOT NULL AND a.Pentavalent2 IS NOT NULL AND a.Pentavalent3 IS NOT NULL) a
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
		INNER JOIN tblhhfamilymember b ON
		a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey c ON
		b.HHSurveyGUID = c.HHSurveyGUID
		INNER JOIN userashamapping d ON
		a.created_by = d.UserID
		WHERE
		d.ASHAID = ? AND a.IsDeleted = 0 AND b.IsDeleted = 0 AND c.IsDeleted = 0 ) a
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
		INNER JOIN tblhhfamilymember b ON
		a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey c ON
		b.HHSurveyGUID = c.HHSurveyGUID
		INNER JOIN userashamapping d ON
		a.created_by = d.UserID
		WHERE
		d.ASHAID = ? AND a.IsDeleted = 0 AND b.IsDeleted = 0 AND c.IsDeleted = 0 and a.DPTBooster is not null and a.OPVBooster is NOT null) a
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
		INNER JOIN tblhhfamilymember b ON
		a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey c ON
		b.HHSurveyGUID = c.HHSurveyGUID
		INNER JOIN userashamapping d ON
		a.created_by = d.UserID
		WHERE
		d.ASHAID = ? AND a.IsDeleted = 0 AND b.IsDeleted = 0 AND c.IsDeleted = 0 and a.measeals is not null) a
		WHERE
		a.ageInMonth > 12 AND a.ageInMonth <= 24";

		$content['child_1_2_measeles'] = $this->db->query($query, [$ASHAID])->result()[0];


		$query = "SELECT
		COUNT(*) AS total
		FROM
		tblpregnant_woman a
		INNER JOIN tblhhfamilymember b ON
		a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
		INNER JOIN userashamapping c ON
		a.CreatedBy = c.UserID
		WHERE
		a.IsDeleted = 0 AND b.IsDeleted = 0 AND a.IsPregnant = 1 AND c.AshaID = ?";


		$content['totalpregnentwomen'] = $this->db->query($query, [$ASHAID])->result()[0];


		$query = "SELECT
		COUNT(*) AS total
		FROM
		tblpregnant_woman a
		INNER JOIN tblhhfamilymember b ON
		a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
		INNER JOIN userashamapping c ON
		a.CreatedBy = c.UserID
		WHERE
		a.IsDeleted = 0 AND b.IsDeleted = 0 AND a.IsPregnant = 1 AND c.AshaID = ? AND TIMESTAMPDIFF(
		DAY,
		a.LMPDate,
		CURRENT_TIMESTAMP
		) > 0 AND TIMESTAMPDIFF(
		DAY,
		a.LMPDate,
		CURRENT_TIMESTAMP
	) <= 90";

	$content['totalpregnentwomen_0_3'] = $this->db->query($query, [$ASHAID])->result()[0];


	$query = "SELECT
	COUNT(*) AS total
	FROM
	tblpregnant_woman a
	INNER JOIN tblhhfamilymember b ON
	a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
	INNER JOIN userashamapping c ON
	a.CreatedBy = c.UserID
	WHERE
	a.IsDeleted = 0 AND b.IsDeleted = 0 AND a.IsPregnant = 1 AND c.AshaID = ? AND TIMESTAMPDIFF(
	DAY,
	a.LMPDate,
	CURRENT_TIMESTAMP
	) > 90 AND TIMESTAMPDIFF(
	DAY,
	a.LMPDate,
	CURRENT_TIMESTAMP
) <= 180";

$content['totalpregnentwomen_3_6'] = $this->db->query($query, [$ASHAID])->result()[0];


$query = "SELECT
COUNT(*) AS total
FROM
tblpregnant_woman a
INNER JOIN tblhhfamilymember b ON
a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
INNER JOIN userashamapping c ON
a.CreatedBy = c.UserID
WHERE
a.IsDeleted = 0 AND b.IsDeleted = 0 AND a.IsPregnant = 1 AND c.AshaID = ? AND TIMESTAMPDIFF(
DAY,
a.LMPDate,
CURRENT_TIMESTAMP
) >= 180 AND TIMESTAMPDIFF(
DAY,
a.LMPDate,
CURRENT_TIMESTAMP
) <= 270";

$content['totalpregnentwomen_7_8'] = $this->db->query($query, [$ASHAID])->result()[0];


$query = "SELECT
COUNT(*) AS total
FROM
tblpregnant_woman a
INNER JOIN tblhhfamilymember b ON
a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
INNER JOIN userashamapping c ON
a.CreatedBy = c.UserID
WHERE
a.IsDeleted = 0 AND b.IsDeleted = 0 AND a.IsPregnant = 1 AND c.AshaID = ? AND TIMESTAMPDIFF(
DAY,
a.LMPDate,
CURRENT_TIMESTAMP
) >= 270";

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

$query = "SELECT
a.child_name,
b.PWName,
a.Gender,
a.child_dob,
a.place_of_birth
FROM
tblchild a
INNER JOIN tblpregnant_woman b ON
a.pw_GUID = b.PWGUID
WHERE
a.IsDeleted = 0 AND b.IsDeleted = 0 AND a.AshaID = ? ";

$content['child_details'] = $this->db->query($query, [$ASHAID])->result();
    // print_r($content['child_details']); die();

return $content;
}
public function monthly_asha_report_2()
{

	$ASHAID = 4;

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

		// die($query);

	$result = $this->db->query($query, [$ASHAID])->result();

		// if (count($result) < 1) {
		// 	die("ERROR: No ASHA record found with this ASHAID = $ASHAID");
		// }

	$content['asha_data'] = $result[0];


	$query= "SELECT 
	b.FamilyMemberName,
	a.child_name,
	a.child_dob,
	g.VillageName,
	a.opv1,
	a.bcg,
	CASE WHEN a.dpt1 IS NULL THEN a.Pentavalent1 ELSE a.dpt1
	END AS dpt1,
	CASE WHEN a.dpt2 IS NULL THEN a.Pentavalent2 ELSE a.dpt2
	END AS dpt2,
	CASE WHEN a.dpt3 IS NULL THEN a.Pentavalent3 ELSE a.dpt3
	END AS dpt3,
	a.opv2,
	a.opv3,
	a.opv4,
	a.measeals,
	a.vitaminA,
	a.MeaslesRubella
	FROM
	tblchild a
	INNER JOIN tblhhfamilymember b ON
	a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
	INNER JOIN tblhhsurvey c ON
	b.HHSurveyGUID = c.HHSurveyGUID
	INNER JOIN mstasha d ON
	a.AshaID = d.ASHAID
	INNER JOIN userashamapping e ON
	d.ASHAID = e.AshaID
	INNER JOIN tblusers f ON
	e.UserID = f.user_id
	INNER JOIN mstvillage g ON
	c.VillageID = g.VillageID
	WHERE
	a.IsDeleted = 0 AND b.IsDeleted = 0 AND c.IsDeleted = 0 AND d.IsDeleted = 0 AND f.is_deleted = 0 AND d.LanguageID = 1 AND g.IsDeleted = 0 AND g.LanguageID = 1 AND b.GenderID = 2 AND a.bcg IS NOT NULL AND a.opv1 IS NOT NULL AND a.opv2 IS NOT NULL AND a.opv3 IS NOT NULL AND a.opv4 IS NOT NULL AND(
	a.dpt1 IS NOT NULL OR a.Pentavalent1 IS NOT NULL
	) AND(
	a.dpt2 IS NOT NULL OR a.Pentavalent2 IS NOT NULL
	) AND(
	a.dpt3 IS NOT NULL OR a.Pentavalent3 IS NOT NULL
	) AND(
	a.measeals IS NOT NULL OR a.MeaslesRubella IS NOT NULL
	) AND TIMESTAMPDIFF(
	MONTH,
	a.child_dob,
	CURRENT_TIMESTAMP
	) > 12 AND TIMESTAMPDIFF(
	MONTH,
	a.child_dob,
	CURRENT_TIMESTAMP
) < 24 and a.ASHAID = ?";
// print_r($query);die();

$content['full_immunization']=$this->db->query($query, [$ASHAID])->result();
// print_r($content['full_immunization']);die();
return $content;
}




public function monthly_asha_report_3()
{

	$ASHAID = 4;

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

		// die($query);

	$result = $this->db->query($query, [$ASHAID])->result();

		// if (count($result) < 1) {
		// 	die("ERROR: No ASHA record found with this ASHAID = $ASHAID");
		// }

	$content['asha_data'] = $result[0];

	$query = "select a.*, b.total as first,c.total as second,d.total as third,e.total as fourth, f.total as fifth, g.total as sixth, h.total as sevemth from 
	(SELECT
		b.FamilyMemberName,
		a.MotherMCTSID,
		e.VillageName,
		c.child_dob,
		case WHEN c.place_of_birth = 2 THEN 'अस्पताल' WHEN c.place_of_birth = 1 THEN 'घर' WHEN c.place_of_birth = 0 THEN 'रास्ते में' end as place_of_birth,
		c.childGUID,
		a.HHFamilyMemberGUID,
		a.AshaID,
		a.ANMID
		FROM
		tblpregnant_woman a
		INNER JOIN tblhhfamilymember b ON
		a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
		INNER JOIN tblchild c ON
		b.HHFamilyMemberGUID = c.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey d ON
		b.HHSurveyGUID = d.HHSurveyGUID
		INNER JOIN mstvillage e ON
		d.VillageID = e.VillageID AND e.LanguageID = 1
		whERE
		a.IsDeleted = 0 AND b.IsDeleted = 0 AND c.IsDeleted = 0 AND d.IsDeleted = 0 AND e.IsDeleted = 0 AND a.IsPregnant = 0 )a 
		left join 
		(
			select count(*) as total,ChildGUID from tblpnchomevisit_ans where VisitNo=1 group by ChildGUID
		)b 
		on a.childGUID = b.childGUID
		left join 
		(
			select count(*) as total,ChildGUID from tblpnchomevisit_ans where VisitNo=2 group by ChildGUID
		)c
		on a.childGUID = c.childGUID
		left join 
		(
			select count(*) as total,ChildGUID from tblpnchomevisit_ans where VisitNo=3 group by ChildGUID
		)d
		on a.childGUID = d.childGUID
		left join 
		(
			select count(*) as total,ChildGUID from tblpnchomevisit_ans where VisitNo=4 group by ChildGUID
		)e
		on a.childGUID = e.childGUID
		left join 
		(
			select count(*) as total,ChildGUID from tblpnchomevisit_ans where VisitNo=5 group by ChildGUID
		)f
		on a.childGUID = f.childGUID
		left join 
		(
			select count(*) as total,ChildGUID from tblpnchomevisit_ans where VisitNo=6 group by ChildGUID
		)g
		on a.childGUID = g.childGUID
		left join 
		(
			select count(*) as total,ChildGUID from tblpnchomevisit_ans where VisitNo=7 group by ChildGUID
		)h
		on a.childGUID = h.childGUID
		where a.AshaID = ?
		order by a.HHFamilyMemberGUID";

		$content['pnc_home_visit']=$this->db->query($query, [$ASHAID])->result();
		return $content;
	}


	public function monthly_asha_report_4()
	{
		$ASHAID = 8;



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

			// die($query);

		$result = $this->db->query($query, [$ASHAID])->result();

			// if (count($result) < 1) {
			// 	die("ERROR: No ASHA record found with this ASHAID = $ASHAID");
			// }

		$content['asha_data'] = $result[0];

		/*Village Counts*/

		$query = "SELECT
		COUNT(*) AS total
		FROM
		mstvillage a
		INNER JOIN ashavillage b ON
		a.VillageID = b.VillageID
		INNER JOIN mstasha c ON
		b.ASHAID = c.ASHAID
		WHERE
		a.IsDeleted = 0 AND a.LanguageID = 1 AND c.LanguageID = 1 AND c.IsDeleted = 0 AND c.IsActive = 1 AND c.AshaID = ? ";

		$content['village_count'] = $this->db->query($query,[$ASHAID])->result()[0];

		/*Housold Counts*/

		$query = "select count(*) as total
		from tblhhsurvey  WHERE IsDeleted = 0 and ServiceProviderID = ?";


		$content['household_count'] = $this->db->query($query, [$ASHAID])->result()[0];

		/*Cast Id Query*/


		$query = "SELECT * FROM (
    SELECT COUNT(*) as sc from tblhhsurvey WHERE CasteID = 1 AND IsDeleted = 0 and IsActive = 1 AND ServiceProviderID = $ASHAID ) a
    INNER JOIN ( SELECT COUNT(*) as st from tblhhsurvey WHERE CasteID = 2 AND IsDeleted = 0 and IsActive = 1 AND ServiceProviderID =  $ASHAID ) b 
    INNER JOIN ( SELECT COUNT(*) as obc from tblhhsurvey WHERE CasteID = 3 AND IsDeleted = 0 and IsActive = 1 AND ServiceProviderID =  $ASHAID ) c 
    INNER JOIN ( SELECT COUNT(*) as other from tblhhsurvey WHERE CasteID = 4 AND IsDeleted = 0 and IsActive = 1 AND ServiceProviderID = $ASHAID ) d";
    // die($query);


    $content['cast_id'] = $this->db->query($query)->result()[0];

    // print_r($content['cast_id']);die();


// 		$query = "SELECT
//     a.male,
//     b.female,
//     a.male + b.female as total
// FROM
//     (
//     SELECT
//         COUNT(*) as male
//     FROM
//         tblhhfamilymember a
//     INNER JOIN tblhhsurvey b ON
//         a.HHSurveyGUID = b.HHSurveyGUID
//     WHERE
//         a.IsDeleted = 0 AND b.IsDeleted = 0 AND a.GenderID = 1 AND a.AshaID = $ASHAID
// ) a
// INNER JOIN(
//     SELECT COUNT(*) AS female
//     FROM
//         tblhhfamilymember a
//     INNER JOIN tblhhsurvey b ON
//         a.HHSurveyGUID = b.HHSurveyGUID
//     WHERE
//         a.IsDeleted = 0 AND b.IsDeleted = 0 AND a.GenderID = 2 AND a.AshaID = $ASHAID
// ) b";

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
			a.IsDeleted = 0 AND b.IsDeleted = 0 AND a.GenderID = 1 AND b.IsActive = 1 AND a.AshaID = $ASHAID and
			(
			CASE
			WHEN a.DOBAvailable = 2 THEN (a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear))*365
			WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(DAY, a.DateOfBirth,CURRENT_DATE) END
			) between 0 and 42000 ) a

			INNER JOIN
			(
			SELECT
			count(*) as total
			FROM
			tblhhfamilymember a
			INNER JOIN tblhhsurvey b ON
			a.HHSurveyGUID = b.HHSurveyGUID
			WHERE
			a.IsDeleted = 0 AND b.IsDeleted = 0 AND a.GenderID = 2 AND b.IsActive = 1 AND a.AshaID = $ASHAID  and
			(
			CASE
			WHEN a.DOBAvailable = 2 THEN (a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear))*365
			WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(DAY, a.DateOfBirth,CURRENT_DATE) END
			) between 0 and 42000 
		) b";


		$content['total_members'] = $this->db->query($query)->result()[0];

		// print_r($content['total_members']); die();

		

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
		a.IsDeleted = 0 AND b.IsDeleted = 0 AND a.GenderID = 1 AND b.IsActive = 1 AND a.AshaID = $ASHAID and
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
		a.IsDeleted = 0 AND b.IsDeleted = 0 AND a.GenderID = 2 AND b.IsActive = 1 AND a.AshaID = $ASHAID  and
		(
		CASE
		WHEN a.DOBAvailable = 2 THEN (a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear))*365
		WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(DAY, a.DateOfBirth,CURRENT_DATE) END
		) between 0 and 365 
	) b";
	// die($query);

	$content['total_population_zero_to_one'] = $this->db->query($query)->result()[0];

	// print_r($content['total_population_zero_to_one']); die();



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
		a.IsDeleted = 0 AND b.IsDeleted = 0 AND a.GenderID = 1 AND b.IsActive = 1 AND a.AshaID = $ASHAID and
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
		a.IsDeleted = 0 AND b.IsDeleted = 0 AND a.GenderID = 2 AND b.IsActive = 1 AND a.AshaID = $ASHAID  and
		(
		CASE
		WHEN a.DOBAvailable = 2 THEN (a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear))*365
		WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(DAY, a.DateOfBirth,CURRENT_DATE) END
		) between 366 and 730 
	) b";
	// die($query);

	$content['total_population_one_to_two'] = $this->db->query($query)->result()[0];

	// print_r($content['total_population_one_to_two']); die();


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
		a.IsDeleted = 0 AND b.IsDeleted = 0 AND a.GenderID = 1 AND b.IsActive = 1 AND a.AshaID = $ASHAID and
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
		a.IsDeleted = 0 AND b.IsDeleted = 0 AND a.GenderID = 2 AND b.IsActive = 1 AND a.AshaID = $ASHAID  and
		(
		CASE
		WHEN a.DOBAvailable = 2 THEN (a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear))*365
		WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(DAY, a.DateOfBirth,CURRENT_DATE) END
		) between 731 and 1825 
	) b";
	// die($query);

	$content['total_population_two_to_five'] = $this->db->query($query)->result()[0];

	// print_r($content['total_population_two_to_five']); die();



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
		a.IsDeleted = 0 AND b.IsDeleted = 0 AND a.GenderID = 1 AND b.IsActive = 1 AND a.AshaID = $ASHAID and
		(
		CASE
		WHEN a.DOBAvailable = 2 THEN (a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear))*365
		WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(DAY, a.DateOfBirth,CURRENT_DATE) END
		) between 1826 and 3652 ) a

		INNER JOIN
		(
		SELECT
		count(*) as total
		FROM
		tblhhfamilymember a
		INNER JOIN tblhhsurvey b ON
		a.HHSurveyGUID = b.HHSurveyGUID
		WHERE
		a.IsDeleted = 0 AND b.IsDeleted = 0 AND a.GenderID = 2 AND b.IsActive = 1 AND a.AshaID = $ASHAID  and
		(
		CASE
		WHEN a.DOBAvailable = 2 THEN (a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear))*365
		WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(DAY, a.DateOfBirth,CURRENT_DATE) END
		) between 1826 and 3652 
	) b";
	// die($query);

	$content['total_population_five_to_ten'] = $this->db->query($query)->result()[0];

	// print_r($content['total_population_five_to_ten']); die();


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
		a.IsDeleted = 0 AND b.IsDeleted = 0 AND a.GenderID = 1 AND b.IsActive = 1 AND a.AshaID = $ASHAID and
		(
		CASE
		WHEN a.DOBAvailable = 2 THEN (a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear))*365
		WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(DAY, a.DateOfBirth,CURRENT_DATE) END
		) between 3653 and 6935 ) a

		INNER JOIN
		(
		SELECT
		count(*) as total
		FROM
		tblhhfamilymember a
		INNER JOIN tblhhsurvey b ON
		a.HHSurveyGUID = b.HHSurveyGUID
		WHERE
		a.IsDeleted = 0 AND b.IsDeleted = 0 AND a.GenderID = 2 AND b.IsActive = 1 AND a.AshaID = $ASHAID  and
		(
		CASE
		WHEN a.DOBAvailable = 2 THEN (a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear))*365
		WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(DAY, a.DateOfBirth,CURRENT_DATE) END
		) between 3653 and 6935 
	) b";
	// die($query);

	$content['total_population_ten_to_ninteen'] = $this->db->query($query)->result()[0];

	// print_r($content['total_population_ten_to_ninteen']); die();



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
		a.IsDeleted = 0 AND b.IsDeleted = 0 AND a.GenderID = 1 AND b.IsActive = 1 AND a.AshaID = $ASHAID and
		(
		CASE
		WHEN a.DOBAvailable = 2 THEN (a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear))*365
		WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(DAY, a.DateOfBirth,CURRENT_DATE) END
		) between 6936 and 21900 ) a

		INNER JOIN
		(
		SELECT
		count(*) as total
		FROM
		tblhhfamilymember a
		INNER JOIN tblhhsurvey b ON
		a.HHSurveyGUID = b.HHSurveyGUID
		WHERE
		a.IsDeleted = 0 AND b.IsDeleted = 0 AND a.GenderID = 2 AND b.IsActive = 1 AND a.AshaID = $ASHAID  and
		(
		CASE
		WHEN a.DOBAvailable = 2 THEN (a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear))*365
		WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(DAY, a.DateOfBirth,CURRENT_DATE) END
		) between 6936 and 21900 
	) b";
	// die($query);

	$content['total_population_ninteen_to_sixty'] = $this->db->query($query)->result()[0];

	// print_r($content['total_population_ninteen_to_sixty']); die();



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
		a.IsDeleted = 0 AND b.IsDeleted = 0 AND a.GenderID = 1 AND b.IsActive = 1 AND a.AshaID = $ASHAID and
		(
		CASE
		WHEN a.DOBAvailable = 2 THEN (a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear))*365
		WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(DAY, a.DateOfBirth,CURRENT_DATE) END
		) between 21901 AND 42000 ) a

		INNER JOIN
		(
		SELECT
		count(*) as total
		FROM
		tblhhfamilymember a
		INNER JOIN tblhhsurvey b ON
		a.HHSurveyGUID = b.HHSurveyGUID
		WHERE
		a.IsDeleted = 0 AND b.IsDeleted = 0 AND a.GenderID = 2 AND b.IsActive = 1 AND a.AshaID = $ASHAID  and
		(
		CASE
		WHEN a.DOBAvailable = 2 THEN (a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear))*365
		WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(DAY, a.DateOfBirth,CURRENT_DATE) END
		) between 21901 AND 42000
	) b";
	// die($query);

	$content['total_population_sixty_and_more'] = $this->db->query($query)->result()[0];

	// print_r($content['total_population_sixty_and_more']); die();


	return $content;
}

public function monthly_asha_report_5()
{
	return true;
}


public function monthly_asha_report_6()
{
	$ASHAID = 4;

	$query = "select
	d.PWGUID,
	a.MotherMCTSID,
	a.PWName,
	a.HusbandName,
	c.VillageName,
	a.MobileNo,
	(case WHEN b.CasteID = 1 THEN 'SC' WHEN b.CasteID = 2 THEN 'ST' WHEN b.CasteID = 3 THEN 'OBC' WHEN b.CasteID = 4 THEN 'OTHER' WHEN b.CasteID = 5 THEN 'General' END) as CasteID,
	a.LMPDate,
	(case when h.place_of_birth = 1 THEN 'Home' WHEN h.place_of_birth = 2 THEN 'Hospital' WHEN h.place_of_birth = 3 THEN 'On the Way' END) as DeliveryPlace,
	e.ASHAName,
	g.phone_no,
	CASE WHEN d.Visit_No = 1 THEN d.CheckupVisitDate
	END AS visit1,
	CASE WHEN d.Visit_No = 2 THEN d.CheckupVisitDate
	END AS visit2,
	CASE WHEN d.Visit_No = 3 THEN d.CheckupVisitDate
	END AS visit3,
	CASE WHEN d.Visit_No = 4 THEN d.CheckupVisitDate
	END AS visit4,
	1,
	d.TTfirstDoseDate,
	d.TTsecondDoseDate,
	d.TTboosterDate,
	1,
	1,
	a.DeliveryDateTime,
	(case when h.place_of_birth = 1 THEN 'Home' WHEN h.place_of_birth = 2 THEN 'Hospital' WHEN h.place_of_birth = 3 THEN 'On the Way' END) as place_of_birth,
	(case WHEN a.DeliveryType = 1 THEN 'Normal Delivery' WHEN a.DeliveryType = 2 THEN 'Caesarean' end) as DeliveryType,
	1,
	h.child_name,
	(case when h.Gender = 1 THEN 'FeMale' when h.Gender = 2 THEN 'Male' WHEN h.Gender = 3 THEN 'Others' END) as Gender,
	h.Wt_of_child,
	1,
	1,
	c.VillageName
	FROM
	tblpregnant_woman a
	INNER JOIN tblhhsurvey b ON
	a.HHGUID = b.HHSurveyGUID
	INNER JOIN mstvillage c ON
	b.VillageID = c.VillageID
	INNER JOIN tblancvisit d ON
	a.PWGUID = d.PWGUID
	INNER JOIN mstasha e ON
	a.AshaID = e.ASHAID
	INNER JOIN userashamapping f ON
	e.ASHAID = f.AshaID
	INNER JOIN tblusers g ON
	f.UserID = g.user_id
    INNER JOIN tblchild h ON
    a.pwguid = h.pw_GUID
	WHERE
	a.IsPregnant = 0 AND a.IsDeleted = 0 AND b.IsDeleted = 0 AND c.LanguageID = 1 AND c.IsDeleted = 0 AND d.IsDeleted = 0 AND e.LanguageID = 1 AND e.IsDeleted = 0 AND g.is_deleted = 0 AND g.is_active = 1 AND h.IsDeleted = 0 and a.AshaID = ?
	GROUP BY
	d.PWGUID";

	$content['preg_details'] = $this->db->query($query, [$ASHAID])->result();

	return $content;
}

public function monthly_asha_report_7()
{

	$ASHAID = 4;

	$query = "select
	d.PWGUID,
	a.MotherMCTSID,
	a.PWName,
	a.HusbandName,
	c.VillageName,
	a.MobileNo,
	b.CasteID,
	(case WHEN b.CasteID = 1 THEN 'SC' WHEN b.CasteID = 2 THEN 'ST' WHEN b.CasteID = 3 THEN 'OBC' WHEN b.CasteID = 4 THEN 'OTHER' WHEN b.CasteID = 5 THEN 'General' END) as CasteID,
	(case when h.place_of_birth = 1 THEN 'Home' WHEN h.place_of_birth = 2 THEN 'Hospital' WHEN h.place_of_birth = 3 THEN 'On the Way' END) as DeliveryPlace,
	e.ASHAName,
	g.phone_no,
	CASE WHEN d.Visit_No = 1 THEN d.CheckupVisitDate
	END AS visit1,
	CASE WHEN d.Visit_No = 2 THEN d.CheckupVisitDate
	END AS visit2,
	CASE WHEN d.Visit_No = 3 THEN d.CheckupVisitDate
	END AS visit3,
	CASE WHEN d.Visit_No = 4 THEN d.CheckupVisitDate
	END AS visit4,
	1,
	d.TTfirstDoseDate,
	d.TTsecondDoseDate,
	d.TTboosterDate,
	1,
	1,
	a.DeliveryDateTime,
	(case when h.place_of_birth = 1 THEN 'Home' WHEN h.place_of_birth = 2 THEN 'Hospital' WHEN h.place_of_birth = 3 THEN 'On the Way' END) as place_of_birth,
	
	(case WHEN a.DeliveryType = 1 THEN 'Normal Delivery' WHEN a.DeliveryType = 2 THEN 'Caesarean' end) as DeliveryType,
	1,
	h.child_name,
	(case when h.Gender = 1 THEN 'FeMale' when h.Gender = 2 THEN 'Male' WHEN h.Gender = 3 THEN 'Others' END) as Gender,
	h.Wt_of_child,
	1,
	1,
	c.VillageName
	FROM
	tblpregnant_woman a
	INNER JOIN tblhhsurvey b ON
	a.HHGUID = b.HHSurveyGUID
	INNER JOIN mstvillage c ON
	b.VillageID = c.VillageID
	INNER JOIN tblancvisit d ON
	a.PWGUID = d.PWGUID
	INNER JOIN mstasha e ON
	a.AshaID = e.ASHAID
	INNER JOIN userashamapping f ON
	e.ASHAID = f.AshaID
	INNER JOIN tblusers g ON
	f.UserID = g.user_id
    INNER JOIN tblchild h ON
    a.pwguid = h.pw_GUID
	WHERE
	a.IsPregnant = 0 AND a.IsDeleted = 0 AND b.IsDeleted = 0 AND c.LanguageID = 1 AND c.IsDeleted = 0 AND d.IsDeleted = 0 AND e.LanguageID = 1 AND e.IsDeleted = 0 AND g.is_deleted = 0 AND g.is_active = 1 AND h.IsDeleted = 0 and a.AshaID = ?
	GROUP BY
	d.PWGUID";

	$content['preg_details'] = $this->db->query($query, [$ASHAID])->result();

	return $content;
}


// public function monthly_asha_report_8()
// {

// }

public function monthly_asha_report_9()
{
	$ASHAID = 4;

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

		// die($query);

	$result = $this->db->query($query, [$ASHAID])->result();

		// if (count($result) < 1) {
		// 	die("ERROR: No ASHA record found with this ASHAID = $ASHAID");
		// }

	$content['asha_data'] = $result[0];


	$query= "SELECT 
	b.FamilyMemberName,
	a.child_name,
	a.child_dob,
	g.VillageName,
	a.opv1,
	a.bcg,
	CASE WHEN a.dpt1 IS NULL THEN a.Pentavalent1 ELSE a.dpt1
	END AS dpt1,
	CASE WHEN a.dpt2 IS NULL THEN a.Pentavalent2 ELSE a.dpt2
	END AS dpt2,
	CASE WHEN a.dpt3 IS NULL THEN a.Pentavalent3 ELSE a.dpt3
	END AS dpt3,
	a.opv2,
	a.opv3,
	a.opv4,
	a.measeals,
	a.vitaminA,
	a.MeaslesRubella
	FROM
	tblchild a
	INNER JOIN tblhhfamilymember b ON
	a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
	INNER JOIN tblhhsurvey c ON
	b.HHSurveyGUID = c.HHSurveyGUID
	INNER JOIN mstasha d ON
	a.AshaID = d.ASHAID
	INNER JOIN userashamapping e ON
	d.ASHAID = e.AshaID
	INNER JOIN tblusers f ON
	e.UserID = f.user_id
	INNER JOIN mstvillage g ON
	c.VillageID = g.VillageID
	WHERE
	a.IsDeleted = 0 AND b.IsDeleted = 0 AND c.IsDeleted = 0 AND d.IsDeleted = 0 AND f.is_deleted = 0 AND d.LanguageID = 1 AND g.IsDeleted = 0 AND g.LanguageID = 1 AND b.GenderID = 2 AND a.bcg IS NOT NULL AND a.opv1 IS NOT NULL AND a.opv2 IS NOT NULL AND a.opv3 IS NOT NULL AND a.opv4 IS NOT NULL AND(
	a.dpt1 IS NOT NULL OR a.Pentavalent1 IS NOT NULL
	) AND(
	a.dpt2 IS NOT NULL OR a.Pentavalent2 IS NOT NULL
	) AND(
	a.dpt3 IS NOT NULL OR a.Pentavalent3 IS NOT NULL
	) AND(
	a.measeals IS NOT NULL OR a.MeaslesRubella IS NOT NULL
	) AND TIMESTAMPDIFF(
	MONTH,
	a.child_dob,
	CURRENT_TIMESTAMP
	) > 12 AND TIMESTAMPDIFF(
	MONTH,
	a.child_dob,
	CURRENT_TIMESTAMP
) < 24 and a.ASHAID = ?";
// print_r($query);die();

$content['full_immunization']=$this->db->query($query, [$ASHAID])->result();
// print_r($content['full_immunization']);die();
return $content;
}


public function monthly_asha_report_10()
{

	$ASHAID = 4;
	$query = "SELECT
	child_name,
	bcg,
	opv1,
	Pentavalent1,
	opv2,
	Pentavalent2,
	opv3,
	Pentavalent3,
	measeals,
	vitaminA,
	MeaslesRubella
	FROM
	`tblchild`
	WHERE
	IsDeleted = 0 AND AshaID = ?";

	$content['RCH_immunization'] = $this->db->query($query, [$ASHAID])->result();

	return $content;
}



}