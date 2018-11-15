<?php 

class Monthly_asha_report_two_model extends Ci_model
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
	a.MeaslesRubella,
	a.ASHAID
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
) < 24 and a.ASHAID = ? AND 
		a.child_dob > '".$this->input->post('date_from')."' and a.child_dob < '".$this->input->post('date_to')."'";

$content['full_immunization']=$this->db->query($query,[$ASHAID])->result();
return $content;
}
}