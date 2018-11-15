<?php 

/**
* Dashboard4 model for process indicators
*/
class Immunization_model extends Ci_model
{

	public function __construct()
	{
		parent::__construct();
		$this->filter_data = $this->session->userdata('filter_data_list');
		$this->child_count = $this->get_child_count();
		$this->child_count_45_above = $this->get_child_count_45_above();
		$this->child_count_75_above = $this->get_child_count_75_above();
		$this->child_count_105_above = $this->get_child_count_105_above();
		$this->child_count_9_completed_month = $this->get_child_count_9_completed_month();
		$this->child_count_18_completed_month = $this->get_child_count_18_completed_month();
		$this->child_count_16_completed_month = $this->get_child_count_16_completed_month();
		$this->child_count_16_24_completed_month = $this->get_child_count_16_24_completed_month();
		$this->child_count_24_completed_month = $this->get_child_count_24_completed_month();
		$this->child_count_30_completed_month = $this->get_child_count_30_completed_month();
		$this->child_count_36_completed_month = $this->get_child_count_36_completed_month();
	}

	private function get_child_count()
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
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInMonth >= 0 AND a.ageInMonth <= 60";
		$total = $this->db->query($query)->result()[0]->total;
		return $total;
	}

	private function get_child_count_45_above()
	{
		$query = "SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        TIMESTAMPDIFF(day, child_dob, NOW()) AS ageInDay,
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
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInDay >= 45";
		$total = $this->db->query($query)->result()[0]->total;
		return $total;
	}

	private function get_child_count_75_above()
	{
		$query = "SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        TIMESTAMPDIFF(day, child_dob, NOW()) AS ageInDay,
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
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInDay >= 75";
		$total = $this->db->query($query)->result()[0]->total;
		return $total;
	}

	private function get_child_count_105_above()
	{
		$query = "SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        TIMESTAMPDIFF(day, child_dob, NOW()) AS ageInDay,
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
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInDay >= 105";
		$total = $this->db->query($query)->result()[0]->total;
		return $total;
	}

	private function get_child_count_9_completed_month()
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
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInMonth >= 9";
		$total = $this->db->query($query)->result()[0]->total;
		return $total;
	}

	private function get_child_count_18_completed_month()
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
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInMonth >= 18";
		$total = $this->db->query($query)->result()[0]->total;
		return $total;
	}

	private function get_child_count_16_completed_month()
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
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInMonth >= 16";
		$total = $this->db->query($query)->result()[0]->total;
		return $total;
	}

	private function get_child_count_16_24_completed_month()
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
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInMonth >= 16 and a.ageInMonth <= 24";
		$total = $this->db->query($query)->result()[0]->total;
		return $total;
	}

	private function get_child_count_24_completed_month()
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
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInMonth >= 24";
		$total = $this->db->query($query)->result()[0]->total;
		return $total;
	}

	private function get_child_count_30_completed_month()
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
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInMonth >= 30";
		$total = $this->db->query($query)->result()[0]->total;
		return $total;
	}

	private function get_child_count_36_completed_month()
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
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInMonth >= 36";
		$total = $this->db->query($query)->result()[0]->total;
		return $total;
	}

	public function get_immunization_summary()
	{
		$content = array();

		$content['proportion_bcg_at_birth'] = $this->proportion_bcg_at_birth();
		$content['proportion_opv0_at_birth'] = $this->proportion_opv0_at_birth();
		$content['proportion_hepb0_at_birth'] = $this->proportion_hepb0_at_birth();
		$content['proportion_pentavalent1_45_days'] = $this->proportion_pentavalent1_45_days();
		$content['proportion_opv1_45_days'] = $this->proportion_opv1_45_days();
		$content['proportion_dpt1_45_days'] = $this->proportion_dpt1_45_days();
		$content['proportion_hepb1_45_days'] = $this->proportion_hepb1_45_days();
		$content['proportion_pentavalent2_75_days'] = $this->proportion_pentavalent2_75_days();
		$content['proportion_hepb2_75_days'] = $this->proportion_hepb2_75_days();
		$content['proportion_pentavalent3_105_days'] = $this->proportion_pentavalent3_105_days();
		$content['proportion_OPV3_105_days'] = $this->proportion_OPV3_105_days();
		$content['proportion_DPT3_105_days'] = $this->proportion_DPT3_105_days();
		$content['proportion_hepb3_105_days'] = $this->proportion_hepb3_105_days();
		$content['proportion_measles_nine_months'] = $this->proportion_measles_nine_months();
		$content['proportion_vitamin_a_nine_months'] = $this->proportion_vitamin_a_nine_months();
		$content['proportion_vitamin_a_16_months'] = $this->proportion_vitamin_a_16_months();
		$content['proportion_dptbooster_16_24_months'] = $this->proportion_dptbooster_16_24_months();
		$content['proportion_poliobooster_16_24_months'] = $this->proportion_poliobooster_16_24_months();
		$content['proportion_vitamin_a3_24_months'] = $this->proportion_vitamin_a3_24_months();
		$content['proportion_vitamin_a4_30_months'] = $this->proportion_vitamin_a4_30_months();
		$content['proportion_vitamin_a5_36_months'] = $this->proportion_vitamin_a5_36_months();

		return $content;
	}

/**
* Due date 1 year
*/
private function proportion_bcg_at_birth()
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
        c.bcg >= c.child_dob AND(
            c.bcg <= c.child_dob + INTERVAL 1 YEAR
        ) AND c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0 AND c.bcg IS NOT NULL) a
    WHERE
        a.ageInMonth >= 0 AND a.ageInMonth <= 60
	UNION ALL 
	SELECT
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
       (c.bcg > c.child_dob + interval 1 year) and (c.bcg <= c.child_dob + interval 1 year + interval 15 day) AND c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0 AND c.bcg IS NOT NULL) a
    WHERE
        a.ageInMonth >= 0 AND a.ageInMonth <= 60
	UNION ALL 
	SELECT
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
         (c.bcg > c.child_dob + interval 1 year) and (c.bcg <= c.child_dob + interval 1 year + interval 30 day) AND c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0 AND c.bcg IS NOT NULL) a
    WHERE
        a.ageInMonth >= 0 AND a.ageInMonth <= 60 
	UNION ALL 
	SELECT
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
        (c.bcg > c.child_dob + interval 1 year + interval 30 day) AND c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0 AND c.bcg IS NOT NULL) a
    WHERE
        a.ageInMonth >= 0 AND a.ageInMonth <= 60
	UNION ALL 
	SELECT
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
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0 and  c.bcg is null) a
    WHERE
        a.ageInMonth >= 0 AND a.ageInMonth <= 60";

	$result = $this->db->query($query)->result();

	foreach ($result as $row) {
		$proportion[] = array(
			"label"	=>	"% of children received BCG at birth",
			"value"	=>	$row->total,
			"total" =>	$this->child_count,
			"proportion"	=>	number_format(($row->total / ($this->child_count == 0 ? 1 : $this->child_count)) * 100, 1),
			);
	}

	return $proportion;
}

/**
* Due date 15 days
*/
private function proportion_opv0_at_birth()
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
      c.opv1 >= c.child_dob and (c.opv1 <= c.child_dob + interval 15 day) AND
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0 and  c.opv1 is not null) a
    WHERE
        a.ageInMonth >= 0 AND a.ageInMonth <= 60
	UNION ALL 
	SELECT
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
      (c.opv1 > c.child_dob + interval 15 day) and (c.opv1 <= c.child_dob + interval 15 day + interval 15 day) AND
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0 and  c.opv1 is not null) a
    WHERE
        a.ageInMonth >= 0 AND a.ageInMonth <= 60
	UNION ALL 
	SELECT
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
       (c.opv1 > c.child_dob + interval 15 day + interval 15 day) and (c.opv1 <= c.child_dob + interval 15 day + interval 30 day) AND
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0 and  c.opv1 is not null) a
    WHERE
        a.ageInMonth >= 0 AND a.ageInMonth <= 60
	UNION ALL 
	SELECT
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
	       (c.opv1 > c.child_dob + interval 15 day + interval 30 day) AND
	        c.created_by IN(
	        SELECT
	            user_id
	        FROM
	            tblusers
	        WHERE
	            user_mode = 1 AND is_deleted = 0
	    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0 and  c.opv1 is not null) a
	    WHERE
	        a.ageInMonth >= 0 AND a.ageInMonth <= 60
	UNION ALL 
	SELECT
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
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0 and  c.opv1 is null) a
    WHERE
        a.ageInMonth >= 0 AND a.ageInMonth <= 60";

	$result = $this->db->query($query)->result();

	foreach ($result as $row) {
		$proportion[] = array(
			"label"	=>	"% of children received OPV0 at birth",
			"value"	=>	$row->total,
			"total" =>	$this->child_count,
			"proportion"	=>	number_format(($row->total / ($this->child_count == 0 ? 1 : $this->child_count)) * 100, 1),
			);
	}

	return $proportion;
}

/**
* Due date same day
*/
private function proportion_hepb0_at_birth()
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
         c.hepb1 = c.child_dob AND
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0 and  c.hepb1 is NOT null) a
    WHERE
        a.ageInMonth >= 0 AND a.ageInMonth <= 60
	UNION ALL 
	SELECT
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
         c.hepb1 > c.child_dob and (c.hepb1 <= c.child_dob + interval 15 day) AND
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0 and  c.hepb1 is NOT null) a
    WHERE
        a.ageInMonth >= 0 AND a.ageInMonth <= 60
	UNION ALL 
	SELECT
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
         (c.hepb1 > c.child_dob + interval 15 day) and (c.hepb1 <= c.child_dob + interval 30 day) AND
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0 and  c.hepb1 is NOT null) a
    WHERE
        a.ageInMonth >= 0 AND a.ageInMonth <= 60
	UNION ALL 
	SELECT
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
         (c.hepb1 > c.child_dob + interval 30 day) AND
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0 and  c.hepb1 is NOT null) a
    WHERE
        a.ageInMonth >= 0 AND a.ageInMonth <= 60 
	UNION ALL 
	SELECT
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
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0 and  c.hepb1 is null) a
    WHERE
        a.ageInMonth >= 0 AND a.ageInMonth <= 60";

	$result = $this->db->query($query)->result();

	foreach ($result as $row) {
		$proportion[] = array(
			"label"	=>	"% of children received HEPB0 at birth",
			"value"	=>	$row->total,
			"total" =>	$this->child_count,
			"proportion"	=>	number_format(($row->total / ($this->child_count == 0 ? 1 : $this->child_count)) * 100, 1),
			);
	}

	return $proportion;
}

/**
* Due date 6 weeks
*/
private function proportion_pentavalent1_45_days()
{
	$query = "SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        TIMESTAMPDIFF(day, child_dob, NOW()) AS ageInDay,
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
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0 and c.Pentavalent1 >= c.child_dob and (c.Pentavalent1 <= c.child_dob + interval 6 week) AND
    c.Pentavalent1 IS NOT NULL) a
    WHERE
        a.ageInDay >= 45
	UNION ALL 
	SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        TIMESTAMPDIFF(day, child_dob, NOW()) AS ageInDay,
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
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0 and (c.Pentavalent1 > c.child_dob + interval 6 week) and (c.Pentavalent1 <= c.child_dob + interval 6 week  + interval 15 day) AND
    c.Pentavalent1 IS NOT NULL) a
    WHERE
        a.ageInDay >= 45
	UNION ALL 
	SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        TIMESTAMPDIFF(day, child_dob, NOW()) AS ageInDay,
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
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0 and (c.Pentavalent1 > c.child_dob + interval 6 week  + interval 15 day) and (c.Pentavalent1 <= c.child_dob + interval 6 week  + interval 30 day) AND
    c.Pentavalent1 IS NOT NULL) a
    WHERE
        a.ageInDay >= 45
	UNION ALL 
	SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        TIMESTAMPDIFF(day, child_dob, NOW()) AS ageInDay,
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
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0 and (c.Pentavalent1 > c.child_dob + interval 6 week + interval 30 day) AND
    c.Pentavalent1 IS NOT NULL) a
    WHERE
        a.ageInDay >= 45
	UNION ALL 
	SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        TIMESTAMPDIFF(day, child_dob, NOW()) AS ageInDay,
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
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0 AND
    c.Pentavalent1 IS NULL) a
    WHERE
        a.ageInDay >= 45";

	$result = $this->db->query($query)->result();

	foreach ($result as $row) {
		$proportion[] = array(
			"label"	=>	"% of children aged 45 days or more received Pentavalent1",
			"value"	=>	$row->total,
			"total" =>	$this->child_count_45_above,
			"proportion"	=>	number_format(($row->total / ($this->child_count_45_above == 0 ? 1 : $this->child_count_45_above)) * 100, 1),
			);
	}

	return $proportion;
}

/**
* Due date 6 weeks
*/
private function proportion_opv1_45_days()
{
	$query = "SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        TIMESTAMPDIFF(day, child_dob, NOW()) AS ageInDay,
        gender
    FROM
        tblchild c
    INNER JOIN tblhhfamilymember m ON
        c.HHFamilyMemberGUID = m.HHFamilyMemberGUID
    INNER JOIN tblhhsurvey h ON
        m.HHSurveyGUID = h.HHSurveyGUID
    WHERE c.opv2 >= c.child_dob and (c.opv2 <= c.child_dob + interval 6 week) and 
    c.opv2 is not NULL and  
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInDay >= 45
	UNION ALL 
	SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        TIMESTAMPDIFF(day, child_dob, NOW()) AS ageInDay,
        gender
    FROM
        tblchild c
    INNER JOIN tblhhfamilymember m ON
        c.HHFamilyMemberGUID = m.HHFamilyMemberGUID
    INNER JOIN tblhhsurvey h ON
        m.HHSurveyGUID = h.HHSurveyGUID
    WHERE (c.opv2 > c.child_dob + interval 6 week) and (c.opv2 <= c.child_dob + interval 6 week  + interval 15 day) and c.opv2 is not NULL and  
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInDay >= 45
	UNION ALL 
	SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        TIMESTAMPDIFF(day, child_dob, NOW()) AS ageInDay,
        gender
    FROM
        tblchild c
    INNER JOIN tblhhfamilymember m ON
        c.HHFamilyMemberGUID = m.HHFamilyMemberGUID
    INNER JOIN tblhhsurvey h ON
        m.HHSurveyGUID = h.HHSurveyGUID
    WHERE (c.opv2 > c.child_dob + interval 6 week + interval 15 day) and (c.opv2 <= c.child_dob + interval 6 week  + interval 30 day) and   c.opv2 is not NULL and  
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInDay >= 45
	UNION ALL 
	SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        TIMESTAMPDIFF(day, child_dob, NOW()) AS ageInDay,
        gender
    FROM
        tblchild c
    INNER JOIN tblhhfamilymember m ON
        c.HHFamilyMemberGUID = m.HHFamilyMemberGUID
    INNER JOIN tblhhsurvey h ON
        m.HHSurveyGUID = h.HHSurveyGUID
    WHERE(c.opv2 > c.child_dob + interval 6 week + interval 30 day) and c.opv2 is not NULL and  
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInDay >= 45
	UNION ALL 
	SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        TIMESTAMPDIFF(day, child_dob, NOW()) AS ageInDay,
        gender
    FROM
        tblchild c
    INNER JOIN tblhhfamilymember m ON
        c.HHFamilyMemberGUID = m.HHFamilyMemberGUID
    INNER JOIN tblhhsurvey h ON
        m.HHSurveyGUID = h.HHSurveyGUID
    WHERE c.opv2 is NULL and  
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInDay >= 45";

	$result = $this->db->query($query)->result();

	foreach ($result as $row) {
		$proportion[] = array(
			"label"	=>	"% of children aged 45 days or more received OPV1",
			"value"	=>	$row->total,
			"total" =>	$this->child_count_45_above,
			"proportion"	=>	number_format(($row->total / ($this->child_count_45_above == 0 ? 1 : $this->child_count_45_above)) * 100, 1),
			);
	}

	return $proportion;
}

/**
* Due date 6 weeks
*/
private function proportion_dpt1_45_days()
{
	$query = "SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        TIMESTAMPDIFF(day, child_dob, NOW()) AS ageInDay,
        gender
    FROM
        tblchild c
    INNER JOIN tblhhfamilymember m ON
        c.HHFamilyMemberGUID = m.HHFamilyMemberGUID
    INNER JOIN tblhhsurvey h ON
        m.HHSurveyGUID = h.HHSurveyGUID
    WHERE  c.dpt2 >= c.child_dob and (c.dpt2 <= c.child_dob + interval 6 week) and c.dpt2 is not NULL AND  
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInDay >= 45
	UNION ALL 
	SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        TIMESTAMPDIFF(day, child_dob, NOW()) AS ageInDay,
        gender
    FROM
        tblchild c
    INNER JOIN tblhhfamilymember m ON
        c.HHFamilyMemberGUID = m.HHFamilyMemberGUID
    INNER JOIN tblhhsurvey h ON
        m.HHSurveyGUID = h.HHSurveyGUID
    WHERE  (c.dpt2 > c.child_dob + interval 6 week) and (c.dpt2 <= c.child_dob + interval 6 week + interval 15 day) and c.dpt2 is not NULL AND  
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInDay >= 45
	UNION ALL 
	SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        TIMESTAMPDIFF(day, child_dob, NOW()) AS ageInDay,
        gender
    FROM
        tblchild c
    INNER JOIN tblhhfamilymember m ON
        c.HHFamilyMemberGUID = m.HHFamilyMemberGUID
    INNER JOIN tblhhsurvey h ON
        m.HHSurveyGUID = h.HHSurveyGUID
    WHERE  (c.dpt2 > c.child_dob + interval 6 week + interval 15 day) and (c.dpt2 <= c.child_dob + interval 6 week + interval 30 day) and c.dpt2 is not NULL AND  
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInDay >= 45
	UNION ALL 
	SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        TIMESTAMPDIFF(day, child_dob, NOW()) AS ageInDay,
        gender
    FROM
        tblchild c
    INNER JOIN tblhhfamilymember m ON
        c.HHFamilyMemberGUID = m.HHFamilyMemberGUID
    INNER JOIN tblhhsurvey h ON
        m.HHSurveyGUID = h.HHSurveyGUID
    WHERE  (c.dpt2 > c.child_dob + interval 6 week + interval 30 day) and c.dpt2 is not NULL AND  
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInDay >= 45
	UNION ALL 
	SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        TIMESTAMPDIFF(day, child_dob, NOW()) AS ageInDay,
        gender
    FROM
        tblchild c
    INNER JOIN tblhhfamilymember m ON
        c.HHFamilyMemberGUID = m.HHFamilyMemberGUID
    INNER JOIN tblhhsurvey h ON
        m.HHSurveyGUID = h.HHSurveyGUID
    WHERE c.dpt2 is NULL AND  
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInDay >= 45";

	$result = $this->db->query($query)->result();

	foreach ($result as $row) {
		$proportion[] = array(
			"label"	=>	"% of children aged 45 days or more received DPT1",
			"value"	=>	$row->total,
			"total" =>	$this->child_count_45_above,
			"proportion"	=>	number_format(($row->total / ($this->child_count_45_above == 0 ? 1 : $this->child_count_45_above)) * 100, 1),
			);
	}

	return $proportion;
}
/**
* Due date 6 weeks
*/
private function proportion_hepb1_45_days()
{
	$query = "SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        TIMESTAMPDIFF(day, child_dob, NOW()) AS ageInDay,
        gender
    FROM
        tblchild c
    INNER JOIN tblhhfamilymember m ON
        c.HHFamilyMemberGUID = m.HHFamilyMemberGUID
    INNER JOIN tblhhsurvey h ON
        m.HHSurveyGUID = h.HHSurveyGUID
    WHERE  c.hepb2 >= c.child_dob and (c.hepb2 <= c.child_dob + interval 6 week) and c.hepb2 is not NULL AND  
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInDay >= 45
	UNION ALL 
	SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        TIMESTAMPDIFF(day, child_dob, NOW()) AS ageInDay,
        gender
    FROM
        tblchild c
    INNER JOIN tblhhfamilymember m ON
        c.HHFamilyMemberGUID = m.HHFamilyMemberGUID
    INNER JOIN tblhhsurvey h ON
        m.HHSurveyGUID = h.HHSurveyGUID
    WHERE (c.hepb2 > c.child_dob + interval 6 week) and (c.hepb2 <= c.child_dob + interval 6 week +interval 15 day) and c.hepb2 is not NULL AND  
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInDay >= 45
	UNION ALL 
	SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        TIMESTAMPDIFF(day, child_dob, NOW()) AS ageInDay,
        gender
    FROM
        tblchild c
    INNER JOIN tblhhfamilymember m ON
        c.HHFamilyMemberGUID = m.HHFamilyMemberGUID
    INNER JOIN tblhhsurvey h ON
        m.HHSurveyGUID = h.HHSurveyGUID
    WHERE(c.hepb2 > c.child_dob + interval 6 week + interval 15 day) and (c.hepb2 <= c.child_dob + interval 6 week +interval 30 day) and c.hepb2 is not NULL AND  
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInDay >= 45
	UNION ALL 
	SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        TIMESTAMPDIFF(day, child_dob, NOW()) AS ageInDay,
        gender
    FROM
        tblchild c
    INNER JOIN tblhhfamilymember m ON
        c.HHFamilyMemberGUID = m.HHFamilyMemberGUID
    INNER JOIN tblhhsurvey h ON
        m.HHSurveyGUID = h.HHSurveyGUID
    WHERE(c.hepb2 > c.child_dob + interval 6 week + interval 30 day) and c.hepb2 is not NULL AND  
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInDay >= 45
	UNION ALL 
	SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        TIMESTAMPDIFF(day, child_dob, NOW()) AS ageInDay,
        gender
    FROM
        tblchild c
    INNER JOIN tblhhfamilymember m ON
        c.HHFamilyMemberGUID = m.HHFamilyMemberGUID
    INNER JOIN tblhhsurvey h ON
        m.HHSurveyGUID = h.HHSurveyGUID
    WHERE c.hepb2 is NULL AND  
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInDay >= 45";


	$result = $this->db->query($query)->result();

	foreach ($result as $row) {
		$proportion[] = array(
			"label"	=>	"% of children aged 45 days or more received Hepatitis B1",
			"value"	=>	$row->total,
			"total" =>	$this->child_count_45_above,
			"proportion"	=>	number_format(($row->total / ($this->child_count_45_above == 0?1:$this->child_count_45_above)) * 100, 1),
			);
	}

	return $proportion;
}

/**
* Due date 10 week
*/
private function proportion_opv2_75_days()
{
	$query = "SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        TIMESTAMPDIFF(day, child_dob, NOW()) AS ageInDay,
        gender
    FROM
        tblchild c
    INNER JOIN tblhhfamilymember m ON
        c.HHFamilyMemberGUID = m.HHFamilyMemberGUID
    INNER JOIN tblhhsurvey h ON
        m.HHSurveyGUID = h.HHSurveyGUID
    WHERE c.opv3 >= c.child_dob and (c.opv3 <= c.child_dob + interval 10 week) and c.opv3 is not NUll AND  
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInDay >= 75
	UNION ALL 
	SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        TIMESTAMPDIFF(day, child_dob, NOW()) AS ageInDay,
        gender
    FROM
        tblchild c
    INNER JOIN tblhhfamilymember m ON
        c.HHFamilyMemberGUID = m.HHFamilyMemberGUID
    INNER JOIN tblhhsurvey h ON
        m.HHSurveyGUID = h.HHSurveyGUID
    WHERE (c.opv3 > c.child_dob + interval 10 week) and (c.opv3 <= c.child_dob + interval 10 week + interval 15 day) and c.opv3 is not NUll AND  
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInDay >= 75
	UNION ALL 
	SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        TIMESTAMPDIFF(day, child_dob, NOW()) AS ageInDay,
        gender
    FROM
        tblchild c
    INNER JOIN tblhhfamilymember m ON
        c.HHFamilyMemberGUID = m.HHFamilyMemberGUID
    INNER JOIN tblhhsurvey h ON
        m.HHSurveyGUID = h.HHSurveyGUID
    WHERE (c.opv3 > c.child_dob + interval 10 week + interval 15 day) and (c.opv3 <= c.child_dob + interval 10 week + interval 30 day) and c.opv3 is not NUll AND  
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInDay >= 75
	UNION ALL 
	SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        TIMESTAMPDIFF(day, child_dob, NOW()) AS ageInDay,
        gender
    FROM
        tblchild c
    INNER JOIN tblhhfamilymember m ON
        c.HHFamilyMemberGUID = m.HHFamilyMemberGUID
    INNER JOIN tblhhsurvey h ON
        m.HHSurveyGUID = h.HHSurveyGUID
    WHERE (c.opv3 > c.child_dob + interval 10 week + interval 30 day) and c.opv3 is not NUll AND  
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInDay >= 75
	UNION ALL 
	SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        TIMESTAMPDIFF(day, child_dob, NOW()) AS ageInDay,
        gender
    FROM
        tblchild c
    INNER JOIN tblhhfamilymember m ON
        c.HHFamilyMemberGUID = m.HHFamilyMemberGUID
    INNER JOIN tblhhsurvey h ON
        m.HHSurveyGUID = h.HHSurveyGUID
    WHERE c.opv3 is NUll AND  
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInDay >= 75";

	$result = $this->db->query($query)->result();

	foreach ($result as $row) {
		$proportion[] = array(
			"label"	=>	"% of children aged 75 days or more received OPV2",
			"value"	=>	$row->total,
			"total" =>	$this->child_count_75_above,
			"proportion"	=>	number_format(($row->total / ($this->child_count_75_above==0?1:$this->child_count_75_above)) * 100, 1),
			);
	}

	return $proportion;
}

/**
* Due date 10 week
*/
private function proportion_dpt2_75_days()
{
	$query = "SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        TIMESTAMPDIFF(day, child_dob, NOW()) AS ageInDay,
        gender
    FROM
        tblchild c
    INNER JOIN tblhhfamilymember m ON
        c.HHFamilyMemberGUID = m.HHFamilyMemberGUID
    INNER JOIN tblhhsurvey h ON
        m.HHSurveyGUID = h.HHSurveyGUID
    WHERE c.dpt2 >= c.child_dob and (c.dpt2 <= c.child_dob + interval 10 week) and c.dpt2 is not NUll AND  
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInDay >= 75
	UNION ALL 
	SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        TIMESTAMPDIFF(day, child_dob, NOW()) AS ageInDay,
        gender
    FROM
        tblchild c
    INNER JOIN tblhhfamilymember m ON
        c.HHFamilyMemberGUID = m.HHFamilyMemberGUID
    INNER JOIN tblhhsurvey h ON
        m.HHSurveyGUID = h.HHSurveyGUID
    WHERE (c.dpt2 > c.child_dob + interval 10 week) and (c.dpt2 <= c.child_dob + interval 10 week + interval 15 day) and c.dpt2 is not NUll AND  
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInDay >= 75
	UNION ALL 
	SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        TIMESTAMPDIFF(day, child_dob, NOW()) AS ageInDay,
        gender
    FROM
        tblchild c
    INNER JOIN tblhhfamilymember m ON
        c.HHFamilyMemberGUID = m.HHFamilyMemberGUID
    INNER JOIN tblhhsurvey h ON
        m.HHSurveyGUID = h.HHSurveyGUID
    WHERE (c.dpt2 > c.child_dob + interval 10 week + interval 15 day) and (c.dpt2 <= c.child_dob + interval 10 week + interval 30 day) and c.dpt2 is not NUll AND  
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInDay >= 75
	UNION ALL 
	SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        TIMESTAMPDIFF(day, child_dob, NOW()) AS ageInDay,
        gender
    FROM
        tblchild c
    INNER JOIN tblhhfamilymember m ON
        c.HHFamilyMemberGUID = m.HHFamilyMemberGUID
    INNER JOIN tblhhsurvey h ON
        m.HHSurveyGUID = h.HHSurveyGUID
    WHERE (c.dpt2 > c.child_dob + interval 10 week + interval 30 day) and c.dpt2 is not NUll AND  
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInDay >= 75
	UNION ALL 
	SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        TIMESTAMPDIFF(day, child_dob, NOW()) AS ageInDay,
        gender
    FROM
        tblchild c
    INNER JOIN tblhhfamilymember m ON
        c.HHFamilyMemberGUID = m.HHFamilyMemberGUID
    INNER JOIN tblhhsurvey h ON
        m.HHSurveyGUID = h.HHSurveyGUID
    WHERE c.dpt2 is NUll AND  
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInDay >= 75";

	$result = $this->db->query($query)->result();

	foreach ($result as $row) {
		$proportion[] = array(
			"label"	=>	"% of children aged 75 days or more received DPT2",
			"value"	=>	$row->total,
			"total" =>	$this->child_count_75_above,
			"proportion"	=>	number_format(($row->total / ($this->child_count_75_above==0?1:$this->child_count_75_above)) * 100, 1),
			);
	}

	return $proportion;
}

/**
* Due date 10 week
*/
private function proportion_pentavalent2_75_days()
{
	$query = "SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        TIMESTAMPDIFF(day, child_dob, NOW()) AS ageInDay,
        gender
    FROM
        tblchild c
    INNER JOIN tblhhfamilymember m ON
        c.HHFamilyMemberGUID = m.HHFamilyMemberGUID
    INNER JOIN tblhhsurvey h ON
        m.HHSurveyGUID = h.HHSurveyGUID
    WHERE c.Pentavalent2 >= c.child_dob and (c.Pentavalent2 <= c.child_dob + interval 10 week) and c.Pentavalent2 is not NUll AND  
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInDay >= 75
	UNION ALL 
	SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        TIMESTAMPDIFF(day, child_dob, NOW()) AS ageInDay,
        gender
    FROM
        tblchild c
    INNER JOIN tblhhfamilymember m ON
        c.HHFamilyMemberGUID = m.HHFamilyMemberGUID
    INNER JOIN tblhhsurvey h ON
        m.HHSurveyGUID = h.HHSurveyGUID
    WHERE (c.Pentavalent2 > c.child_dob + interval 10 week) and (c.Pentavalent2 <= c.child_dob + interval 10 week + interval 15 day) and c.Pentavalent2 is not NUll AND  
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInDay >= 75
	UNION ALL 
	SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        TIMESTAMPDIFF(day, child_dob, NOW()) AS ageInDay,
        gender
    FROM
        tblchild c
    INNER JOIN tblhhfamilymember m ON
        c.HHFamilyMemberGUID = m.HHFamilyMemberGUID
    INNER JOIN tblhhsurvey h ON
        m.HHSurveyGUID = h.HHSurveyGUID
    WHERE (c.Pentavalent2 > c.child_dob + interval 10 week + interval 15 day) and (c.Pentavalent2 <= c.child_dob + interval 10 week + interval 30 day) and c.Pentavalent2 is not NUll AND  
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInDay >= 75
	UNION ALL 
	SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        TIMESTAMPDIFF(day, child_dob, NOW()) AS ageInDay,
        gender
    FROM
        tblchild c
    INNER JOIN tblhhfamilymember m ON
        c.HHFamilyMemberGUID = m.HHFamilyMemberGUID
    INNER JOIN tblhhsurvey h ON
        m.HHSurveyGUID = h.HHSurveyGUID
    WHERE (c.Pentavalent2 > c.child_dob + interval 10 week + interval 30 day) and c.Pentavalent2 is not NUll AND  
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInDay >= 75 
	UNION ALL 
	SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        TIMESTAMPDIFF(day, child_dob, NOW()) AS ageInDay,
        gender
    FROM
        tblchild c
    INNER JOIN tblhhfamilymember m ON
        c.HHFamilyMemberGUID = m.HHFamilyMemberGUID
    INNER JOIN tblhhsurvey h ON
        m.HHSurveyGUID = h.HHSurveyGUID
    WHERE c.Pentavalent2 is NUll AND  
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInDay >= 75";

	$result = $this->db->query($query)->result();

	foreach ($result as $row) {
		$proportion[] = array(
			"label"	=>	"% of children aged 75 days or more received Pentavalent2",
			"value"	=>	$row->total,
			"total" =>	$this->child_count_75_above,
			"proportion"	=>	number_format(($row->total / ($this->child_count_75_above==0?1:$this->child_count_75_above)) * 100, 1),
			);
	}

	return $proportion;
}


/**
* Due date 10 week
*/
private function proportion_hepb2_75_days()
{
	$query = "SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        TIMESTAMPDIFF(day, child_dob, NOW()) AS ageInDay,
        gender
    FROM
        tblchild c
    INNER JOIN tblhhfamilymember m ON
        c.HHFamilyMemberGUID = m.HHFamilyMemberGUID
    INNER JOIN tblhhsurvey h ON
        m.HHSurveyGUID = h.HHSurveyGUID
    WHERE c.hepb3 >= c.child_dob and (c.hepb3 <= c.child_dob + interval 10 week) and c.hepb3 is not NUll AND  
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInDay >= 75
	UNION ALL 
	SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        TIMESTAMPDIFF(day, child_dob, NOW()) AS ageInDay,
        gender
    FROM
        tblchild c
    INNER JOIN tblhhfamilymember m ON
        c.HHFamilyMemberGUID = m.HHFamilyMemberGUID
    INNER JOIN tblhhsurvey h ON
        m.HHSurveyGUID = h.HHSurveyGUID
    WHERE (c.hepb3 > c.child_dob + interval 10 week) and (c.hepb3 <= c.child_dob + interval 10 week + interval 15 day) and c.hepb3 is not NUll AND  
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInDay >= 75
	UNION ALL 
	SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        TIMESTAMPDIFF(day, child_dob, NOW()) AS ageInDay,
        gender
    FROM
        tblchild c
    INNER JOIN tblhhfamilymember m ON
        c.HHFamilyMemberGUID = m.HHFamilyMemberGUID
    INNER JOIN tblhhsurvey h ON
        m.HHSurveyGUID = h.HHSurveyGUID
    WHERE (c.hepb3 > c.child_dob + interval 10 week + interval 15 day) and (c.hepb3 <= c.child_dob + interval 10 week + interval 30 day) and c.hepb3 is not NUll AND  
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInDay >= 75
	UNION ALL 
	SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        TIMESTAMPDIFF(day, child_dob, NOW()) AS ageInDay,
        gender
    FROM
        tblchild c
    INNER JOIN tblhhfamilymember m ON
        c.HHFamilyMemberGUID = m.HHFamilyMemberGUID
    INNER JOIN tblhhsurvey h ON
        m.HHSurveyGUID = h.HHSurveyGUID
    WHERE (c.hepb3 > c.child_dob + interval 10 week + interval 30 day) and c.hepb3 is not NUll AND  
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInDay >= 75 
	UNION ALL 
	SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        TIMESTAMPDIFF(day, child_dob, NOW()) AS ageInDay,
        gender
    FROM
        tblchild c
    INNER JOIN tblhhfamilymember m ON
        c.HHFamilyMemberGUID = m.HHFamilyMemberGUID
    INNER JOIN tblhhsurvey h ON
        m.HHSurveyGUID = h.HHSurveyGUID
    WHERE c.hepb3 is NUll AND  
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInDay >= 75";

	$result = $this->db->query($query)->result();

	foreach ($result as $row) {
		$proportion[] = array(
			"label"	=>	"% of children aged 75 days or more received Hepatitis B2",
			"value"	=>	$row->total,
			"total" =>	$this->child_count_75_above,
			"proportion"	=>	number_format(($row->total / ($this->child_count_75_above==0?1:$this->child_count_75_above)) * 100, 1),
			);
	}

	return $proportion;
}

// Due Date 14 week
private function proportion_OPV3_105_days()
{
	$query = "SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        TIMESTAMPDIFF(day, child_dob, NOW()) AS ageInDay,
        gender
    FROM
        tblchild c
    INNER JOIN tblhhfamilymember m ON
        c.HHFamilyMemberGUID = m.HHFamilyMemberGUID
    INNER JOIN tblhhsurvey h ON
        m.HHSurveyGUID = h.HHSurveyGUID
    WHERE c.opv4 >= c.child_dob and (c.opv4 <= c.child_dob + interval 14 week) and c.opv4 is not Null AND  
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInDay >= 105
	UNION ALL 
	SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        TIMESTAMPDIFF(day, child_dob, NOW()) AS ageInDay,
        gender
    FROM
        tblchild c
    INNER JOIN tblhhfamilymember m ON
        c.HHFamilyMemberGUID = m.HHFamilyMemberGUID
    INNER JOIN tblhhsurvey h ON
        m.HHSurveyGUID = h.HHSurveyGUID
    WHERE (c.opv4 > c.child_dob + interval 14 week) and (c.opv4 < c.child_dob + interval 14 week + interval 15 day) and c.opv4 is not Null AND  
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInDay >= 105
	UNION ALL 
	SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        TIMESTAMPDIFF(day, child_dob, NOW()) AS ageInDay,
        gender
    FROM
        tblchild c
    INNER JOIN tblhhfamilymember m ON
        c.HHFamilyMemberGUID = m.HHFamilyMemberGUID
    INNER JOIN tblhhsurvey h ON
        m.HHSurveyGUID = h.HHSurveyGUID
    WHERE (c.opv4 > c.child_dob + interval 14 week + interval 15 day) and (c.opv4 < c.child_dob + interval 14 week + interval 30 day) and c.opv4 is not Null AND  
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInDay >= 105 
	UNION ALL 
	SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        TIMESTAMPDIFF(day, child_dob, NOW()) AS ageInDay,
        gender
    FROM
        tblchild c
    INNER JOIN tblhhfamilymember m ON
        c.HHFamilyMemberGUID = m.HHFamilyMemberGUID
    INNER JOIN tblhhsurvey h ON
        m.HHSurveyGUID = h.HHSurveyGUID
    WHERE (c.opv4 > c.child_dob + interval 14 week + interval 30 day) and c.opv4 is not Null AND  
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInDay >= 105	UNION ALL 
	SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        TIMESTAMPDIFF(day, child_dob, NOW()) AS ageInDay,
        gender
    FROM
        tblchild c
    INNER JOIN tblhhfamilymember m ON
        c.HHFamilyMemberGUID = m.HHFamilyMemberGUID
    INNER JOIN tblhhsurvey h ON
        m.HHSurveyGUID = h.HHSurveyGUID
    WHERE c.opv4 is  Null AND  
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInDay >= 105";

	$result = $this->db->query($query)->result();

	foreach ($result as $row) {
		$proportion[] = array(
			"label"	=>	"% of children aged 105 days or more received OPV3",
			"value"	=>	$row->total,
			"total" =>	$this->child_count_105_above,
			"proportion"	=>	number_format(($row->total / ($this->child_count_105_above==0?1:$this->child_count_105_above)) * 100, 1),
			);
	}

	return $proportion;
}

/*Due date 14 weeks*/
private function proportion_DPT3_105_days()
{
	$query = "SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        TIMESTAMPDIFF(day, child_dob, NOW()) AS ageInDay,
        gender
    FROM
        tblchild c
    INNER JOIN tblhhfamilymember m ON
        c.HHFamilyMemberGUID = m.HHFamilyMemberGUID
    INNER JOIN tblhhsurvey h ON
        m.HHSurveyGUID = h.HHSurveyGUID
    WHERE c.dpt3 >= c.child_dob and (c.dpt3 <= c.child_dob + interval 14 week) and c.dpt3 is not Null AND  
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInDay >= 105
	UNION ALL 
	SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        TIMESTAMPDIFF(day, child_dob, NOW()) AS ageInDay,
        gender
    FROM
        tblchild c
    INNER JOIN tblhhfamilymember m ON
        c.HHFamilyMemberGUID = m.HHFamilyMemberGUID
    INNER JOIN tblhhsurvey h ON
        m.HHSurveyGUID = h.HHSurveyGUID
    WHERE (c.dpt3 >=c.child_dob + interval 14 week) and (c.dpt3 <= c.child_dob + interval 14 week + interval 15 day) and c.dpt3 is not Null AND  
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInDay >= 105
	UNION ALL 
	SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        TIMESTAMPDIFF(day, child_dob, NOW()) AS ageInDay,
        gender
    FROM
        tblchild c
    INNER JOIN tblhhfamilymember m ON
        c.HHFamilyMemberGUID = m.HHFamilyMemberGUID
    INNER JOIN tblhhsurvey h ON
        m.HHSurveyGUID = h.HHSurveyGUID
    WHERE (c.dpt3 >=c.child_dob + interval 14 week + interval 15 day) and (c.dpt3 <= c.child_dob + interval 14 week + interval 30 day) and c.dpt3 is not Null AND  
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInDay >= 105
	UNION ALL 
	SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        TIMESTAMPDIFF(day, child_dob, NOW()) AS ageInDay,
        gender
    FROM
        tblchild c
    INNER JOIN tblhhfamilymember m ON
        c.HHFamilyMemberGUID = m.HHFamilyMemberGUID
    INNER JOIN tblhhsurvey h ON
        m.HHSurveyGUID = h.HHSurveyGUID
    WHERE (c.dpt3 > c.child_dob + interval 14 week + interval 30 day) and c.dpt3 is not Null AND  
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInDay >= 105
	UNION ALL 
	SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        TIMESTAMPDIFF(day, child_dob, NOW()) AS ageInDay,
        gender
    FROM
        tblchild c
    INNER JOIN tblhhfamilymember m ON
        c.HHFamilyMemberGUID = m.HHFamilyMemberGUID
    INNER JOIN tblhhsurvey h ON
        m.HHSurveyGUID = h.HHSurveyGUID
    WHERE c.dpt3 is Null AND  
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInDay >= 105";

	$result = $this->db->query($query)->result();

	foreach ($result as $row) {
		$proportion[] = array(
			"label"	=>	"% of children aged 105 days or more received DPT3",
			"value"	=>	$row->total,
			"total" =>	$this->child_count_105_above,
			"proportion"	=>	number_format(($row->total / ($this->child_count_105_above==0?1:$this->child_count_105_above)) * 100, 1),
			);
	}

	return $proportion;
}

/*Due Date 14 weeks*/
private function proportion_pentavalent3_105_days()
{
	$query = "SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        TIMESTAMPDIFF(day, child_dob, NOW()) AS ageInDay,
        gender
    FROM
        tblchild c
    INNER JOIN tblhhfamilymember m ON
        c.HHFamilyMemberGUID = m.HHFamilyMemberGUID
    INNER JOIN tblhhsurvey h ON
        m.HHSurveyGUID = h.HHSurveyGUID
    WHERE c.Pentavalent3 >= c.child_dob and (c.Pentavalent3 <= c.child_dob + interval 14 week) and c.Pentavalent3 is not Null AND  
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInDay >= 105 
	UNION ALL 
	SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        TIMESTAMPDIFF(day, child_dob, NOW()) AS ageInDay,
        gender
    FROM
        tblchild c
    INNER JOIN tblhhfamilymember m ON
        c.HHFamilyMemberGUID = m.HHFamilyMemberGUID
    INNER JOIN tblhhsurvey h ON
        m.HHSurveyGUID = h.HHSurveyGUID
    WHERE (c.Pentavalent3 > c.child_dob + interval 14 week) and (c.Pentavalent3 <= c.child_dob + interval 14 week + interval 15 day) and c.Pentavalent3 is not Null AND  
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInDay >= 105
	UNION ALL 
	SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        TIMESTAMPDIFF(day, child_dob, NOW()) AS ageInDay,
        gender
    FROM
        tblchild c
    INNER JOIN tblhhfamilymember m ON
        c.HHFamilyMemberGUID = m.HHFamilyMemberGUID
    INNER JOIN tblhhsurvey h ON
        m.HHSurveyGUID = h.HHSurveyGUID
    WHERE (c.Pentavalent3 > c.child_dob + interval 14 week + interval 15 day) and (c.Pentavalent3 <= c.child_dob + interval 14 week + interval 30 day) and c.Pentavalent3 is not Null AND  
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInDay >= 105 
	UNION ALL 
	SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        TIMESTAMPDIFF(day, child_dob, NOW()) AS ageInDay,
        gender
    FROM
        tblchild c
    INNER JOIN tblhhfamilymember m ON
        c.HHFamilyMemberGUID = m.HHFamilyMemberGUID
    INNER JOIN tblhhsurvey h ON
        m.HHSurveyGUID = h.HHSurveyGUID
    WHERE (c.Pentavalent3 > c.child_dob + interval 14 week + interval 30 day) and c.Pentavalent3 is not Null AND  
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInDay >= 105 
	UNION ALL 
	SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        TIMESTAMPDIFF(day, child_dob, NOW()) AS ageInDay,
        gender
    FROM
        tblchild c
    INNER JOIN tblhhfamilymember m ON
        c.HHFamilyMemberGUID = m.HHFamilyMemberGUID
    INNER JOIN tblhhsurvey h ON
        m.HHSurveyGUID = h.HHSurveyGUID
    WHERE c.Pentavalent3 is Null AND  
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInDay >= 105";

	$result = $this->db->query($query)->result();

	foreach ($result as $row) {
		$proportion[] = array(
			"label"	=>	"% of children aged 105 days or more received Pentavalent3",
			"value"	=>	$row->total,
			"total" =>	$this->child_count_105_above,
			"proportion"	=>	number_format(($row->total / ($this->child_count_105_above==0?1:$this->child_count_105_above)) * 100, 1),
			);
	}

	return $proportion;
}

/*Due Date 14 weeks*/
private function proportion_hepb3_105_days()
{
	$query = "SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        TIMESTAMPDIFF(day, child_dob, NOW()) AS ageInDay,
        gender
    FROM
        tblchild c
    INNER JOIN tblhhfamilymember m ON
        c.HHFamilyMemberGUID = m.HHFamilyMemberGUID
    INNER JOIN tblhhsurvey h ON
        m.HHSurveyGUID = h.HHSurveyGUID
    WHERE c.hepb4 >= c.child_dob and (c.hepb4 <= c.child_dob + interval 14 week) and c.hepb4 is not Null AND  
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInDay >= 105
	UNION ALL 
	SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        TIMESTAMPDIFF(day, child_dob, NOW()) AS ageInDay,
        gender
    FROM
        tblchild c
    INNER JOIN tblhhfamilymember m ON
        c.HHFamilyMemberGUID = m.HHFamilyMemberGUID
    INNER JOIN tblhhsurvey h ON
        m.HHSurveyGUID = h.HHSurveyGUID
    WHERE (c.hepb4 > c.child_dob + interval 14 week) and (c.hepb4 <= c.child_dob + interval 14 week + interval 15 day) and c.hepb4 is not Null AND  
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInDay >= 105
	UNION ALL 
	SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        TIMESTAMPDIFF(day, child_dob, NOW()) AS ageInDay,
        gender
    FROM
        tblchild c
    INNER JOIN tblhhfamilymember m ON
        c.HHFamilyMemberGUID = m.HHFamilyMemberGUID
    INNER JOIN tblhhsurvey h ON
        m.HHSurveyGUID = h.HHSurveyGUID
    WHERE (c.hepb4 > c.child_dob + interval 14 week + interval 15 day) and (c.hepb4 <= c.child_dob + interval 14 week + interval 30 day) and c.hepb4 is not Null AND  
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInDay >= 105
	UNION ALL 
	SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        TIMESTAMPDIFF(day, child_dob, NOW()) AS ageInDay,
        gender
    FROM
        tblchild c
    INNER JOIN tblhhfamilymember m ON
        c.HHFamilyMemberGUID = m.HHFamilyMemberGUID
    INNER JOIN tblhhsurvey h ON
        m.HHSurveyGUID = h.HHSurveyGUID
    WHERE (c.hepb4 > c.child_dob + interval 14 week + interval 30 day) and c.hepb4 is not Null AND  
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInDay >= 105
	UNION ALL 
	SELECT
    COUNT(*) AS total
FROM
    (
    SELECT
        TIMESTAMPDIFF(day, child_dob, NOW()) AS ageInDay,
        gender
    FROM
        tblchild c
    INNER JOIN tblhhfamilymember m ON
        c.HHFamilyMemberGUID = m.HHFamilyMemberGUID
    INNER JOIN tblhhsurvey h ON
        m.HHSurveyGUID = h.HHSurveyGUID
    WHERE c.hepb4 is Null AND  
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInDay >= 105";

	$result = $this->db->query($query)->result();

	foreach ($result as $row) {
		$proportion[] = array(
			"label"	=>	"% of children aged 105 days or more received HepatitisB3",
			"value"	=>	$row->total,
			"total" =>	$this->child_count_105_above,
			"proportion"	=>	number_format(($row->total / ($this->child_count_105_above==0?1:$this->child_count_105_above)) * 100, 1),
			);
	}

	return $proportion;
}

/*Due Date  9 completed months to 12 months.*/
private function proportion_measles_nine_months()
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
    ) AND  c.measeals >= c.child_dob and (c.measeals <= c.child_dob + interval 12 month) and c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0 and c.measeals is not NULL) a
    WHERE
        a.ageInMonth >= 0 AND a.ageInMonth <= 9
	UNION ALL 
	SELECT
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
    ) AND (c.measeals > c.child_dob + interval 12 month) and (c.measeals < c.child_dob + interval 12 month + interval 15 day) and c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0 and c.measeals is not NULL) a
    WHERE
        a.ageInMonth >= 9
	UNION ALL 
	SELECT
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
    ) AND(c.measeals > c.child_dob + interval 12 month + INTERVAL 15 day) and (c.measeals < c.child_dob + interval 12 month + interval 30 day) and c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0 and c.measeals is not NULL) a
    WHERE
        a.ageInMonth >= 9
	UNION ALL 
	SELECT
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
    ) AND (c.measeals > c.child_dob + interval 12 month + interval 30 day) and c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0 and c.measeals is not NULL) a
    WHERE
        a.ageInMonth >= 9
	UNION ALL 
	SELECT
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
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0 and c.measeals is NULL) a
    WHERE
        a.ageInMonth >= 9";

	$result = $this->db->query($query)->result();

	foreach ($result as $row) {
		$proportion[] = array(
			"label"	=>	"% of children aged 9 months and above received Measles vaccination",
			"value"	=>	$row->total,
			"total" =>	$this->child_count_9_completed_month,
			"proportion"	=>	number_format(($row->total / ($this->child_count_9_completed_month==0?1:$this->child_count_9_completed_month)) * 100, 1),
			);
	}

	return $proportion;
}

/*Due Date  9 completed months to measles.*/
private function proportion_vitamin_a_nine_months()
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
    ) AND  c.vitaminA >= c.child_dob and (c.vitaminA <= c.child_dob + interval 12 month) and c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0 and c.vitaminA is not NULL) a
    WHERE
        a.ageInMonth >= 9
	UNION ALL 
	SELECT
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
    ) AND (c.vitaminA > c.child_dob + interval 12 month) and (c.vitaminA < c.child_dob + interval 12 month + interval 15 day) and c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0 and c.vitaminA is not NULL) a
    WHERE
        a.ageInMonth >= 9
	UNION ALL 
	SELECT
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
    ) AND(c.vitaminA > c.child_dob + interval 12 month + INTERVAL 15 day) and (c.vitaminA < c.child_dob + interval 12 month + interval 30 day) and c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0 and c.vitaminA is not NULL) a
    WHERE
        a.ageInMonth >= 9
	UNION ALL 
	SELECT
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
    ) AND (c.vitaminA > c.child_dob + interval 12 month + interval 30 day) and c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0 and c.vitaminA is not NULL) a
    WHERE
        a.ageInMonth >= 9
	UNION ALL 
	SELECT
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
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0 and c.vitaminA is NULL) a
    WHERE
        a.ageInMonth >= 9";

	$result = $this->db->query($query)->result();

	foreach ($result as $row) {
		$proportion[] = array(
			"label"	=>	"% of children aged 9 months and above received Vitamin A",
			"value"	=>	$row->total,
			"total" =>	$this->child_count_9_completed_month,
			"proportion"	=>	number_format(($row->total / ($this->child_count_9_completed_month==0?1:$this->child_count_9_completed_month)) * 100, 1),
			);
	}

	return $proportion;
}

/*Due Date 18 Month.*/

private function proportion_vitamin_a_16_months()
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
    WHERE c.VitaminAtwo >= c.child_dob and c.VitaminAtwo <= c.child_dob + interval 18 month and c.VitaminAtwo is not NUll and
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInMonth >= 16
	UNION ALL 
	SELECT
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
    WHERE (c.VitaminAtwo > c.child_dob + interval 18 month) and (c.VitaminAtwo <= c.child_dob + interval 18 month + interval 15 day) and c.VitaminAtwo is not NUll and
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInMonth >= 16
	UNION ALL 
	SELECT
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
    WHERE (c.VitaminAtwo > c.child_dob + interval 18 month + interval 15 day) and (c.VitaminAtwo <= c.child_dob + interval 18 month + interval 30 day) and c.VitaminAtwo is not NUll and
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInMonth >= 16
	UNION ALL 
	SELECT
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
    WHERE (c.VitaminAtwo > c.child_dob + interval 18 month + interval 30 day) and c.VitaminAtwo is not NUll and
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInMonth >= 16
	UNION ALL 
	SELECT
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
    WHERE c.VitaminAtwo is NUll and
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInMonth >= 16";

	$result = $this->db->query($query)->result();

	foreach ($result as $row) {
		$proportion[] = array(
			"label"	=>	"% of children aged 16 months and above received second dose of Vitamin A",
			"value"	=>	$row->total,
			"total" =>	$this->child_count_16_completed_month,
			"proportion"	=>	number_format(($row->total / ($this->child_count_16_completed_month==0?1:$this->child_count_16_completed_month)) * 100, 1),
			);
	}

	return $proportion;
}


/*Due Date 16-24 Month.*/

private function proportion_dptbooster_16_24_months()
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
    WHERE  c.DPTBooster > c.child_dob and (c.DPTBooster <= c.child_dob + interval 24 month) and c.DPTBooster is not Null AND
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInMonth >= 16 and a.ageInMonth <= 24
	UNION ALL 
	SELECT
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
    WHERE  (c.DPTBooster >= c.child_dob + interval 24 month) and (c.DPTBooster <= c.child_dob + interval 24 month + interval 15 day) and c.DPTBooster is not Null AND
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInMonth >= 16 and a.ageInMonth <= 24
	UNION ALL 
	SELECT
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
    WHERE (c.DPTBooster >= c.child_dob + interval 24 month + interval 15 day) and (c.DPTBooster <= c.child_dob + interval 24 month + interval 30 day) and c.DPTBooster is not Null AND
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInMonth >= 16 and a.ageInMonth <= 24
	UNION ALL 
	SELECT
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
    WHERE (c.DPTBooster > c.child_dob + interval 24 month + interval 30 day) and c.DPTBooster is not Null AND
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInMonth >= 16 and a.ageInMonth <= 24
	UNION ALL 
	SELECT
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
    WHERE c.DPTBooster is Null AND
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInMonth >= 16 and a.ageInMonth <= 24";

	$result = $this->db->query($query)->result(); 

	foreach ($result as $row) {
		$proportion[] = array(
			"label"	=>	"% of children aged 16 to 24 motnhs received DPT booster",
			"value"	=>	$row->total,
			"total" =>	$this->child_count_16_24_completed_month,
			"proportion"	=>	number_format(($row->total / ($this->child_count_16_24_completed_month==0?1:$this->child_count_16_24_completed_month)) * 100, 1),
			);
	}

	return $proportion;
}

/*Due Date 16-24 Month.*/

private function proportion_poliobooster_16_24_months()
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
    WHERE  c.OPVBooster > c.child_dob and (c.OPVBooster <= c.child_dob + interval 24 month) and c.OPVBooster is not Null AND
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInMonth >= 16 and a.ageInMonth <= 24
	UNION ALL 
	SELECT
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
    WHERE (c.OPVBooster >= c.child_dob + interval 24 month) and (c.OPVBooster <= c.child_dob + interval 24 month + interval 15 day) and c.OPVBooster is not Null AND
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInMonth >= 16 and a.ageInMonth <= 24
	UNION ALL 
	SELECT
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
    WHERE (c.OPVBooster >= c.child_dob + interval 24 month + interval 15 day) and (c.OPVBooster <= c.child_dob + interval 24 month + interval 30 day) and c.OPVBooster is not Null AND
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInMonth >= 16 and a.ageInMonth <= 24
	UNION ALL 
	SELECT
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
    WHERE (c.OPVBooster >= c.child_dob + interval 24 month + interval 30 day) and c.OPVBooster is not Null AND
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInMonth >= 16 and a.ageInMonth <= 24
	UNION ALL 
	SELECT
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
    WHERE c.OPVBooster is Null AND
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInMonth >= 16 and a.ageInMonth <= 24";

	$result = $this->db->query($query)->result();

	foreach ($result as $row) {
		$proportion[] = array(
			"label"	=>	"% of children aged 16 to 24 motnhs received Polio booster",
			"value"	=>	$row->total,
			"total" =>	$this->child_count_16_24_completed_month,
			"proportion"	=>	number_format(($row->total / ($this->child_count_16_24_completed_month==0?1:$this->child_count_16_24_completed_month)) * 100, 1),
			);
	}

	return $proportion;
}

/*Due Date 24 Month.*/
private function proportion_vitamin_a3_24_months()
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
    WHERE c.VitaminA3 >= c.child_dob and (c.VitaminA3 <= c.child_dob + interval 24 month) and c.VitaminA3 is not NUll and
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInMonth >= 24
	UNION ALL 
	SELECT
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
    WHERE (c.VitaminA3 > c.child_dob + interval 24 month) and (c.VitaminA3 <= c.child_dob + interval 24 month + interval 15 day) and c.VitaminA3 is not NUll and
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInMonth >= 24
	UNION ALL 
	SELECT
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
    WHERE (c.VitaminA3 > c.child_dob + interval 24 month + interval 15 day) and (c.VitaminA3 <= c.child_dob + interval 24 month + interval 30 day) and c.VitaminA3 is not NUll and
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInMonth >= 24
	UNION ALL 
	SELECT
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
    WHERE (c.VitaminA3 > c.child_dob + interval 24 month + interval 30 day) and c.VitaminA3 is not NUll and
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInMonth >= 24
	UNION ALL 
	SELECT
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
    WHERE c.VitaminA3 is NUll and
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInMonth >= 24";

	$result = $this->db->query($query)->result();

	foreach ($result as $row) {
		$proportion[] = array(
			"label"	=>	"% of children aged 24 months and above received third dose of Vitamin A",
			"value"	=>	$row->total,
			"total" =>	$this->child_count_24_completed_month,
			"proportion"	=>	number_format(($row->total / ($this->child_count_24_completed_month==0?1:$this->child_count_24_completed_month)) * 100, 1),
			);
	}

	return $proportion;
}

/*Due Date 30 Month.*/
private function proportion_vitamin_a4_30_months()
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
    WHERE c.VitaminA4 >= c.child_dob and (c.VitaminA4 <= c.child_dob + interval 30 month) and c.VitaminA4 is not NUll and
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInMonth >= 30
	UNION ALL 
	SELECT
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
    WHERE (c.VitaminA4 > c.child_dob + interval 30 month) and (c.VitaminA4 <= c.child_dob + interval 30 month + interval 15 day) and c.VitaminA4 is not NUll and
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInMonth >= 30
	UNION ALL 
	SELECT
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
    WHERE (c.VitaminA4 > c.child_dob + interval 30 month + interval 15 day) and (c.VitaminA4 <= c.child_dob + interval 30 month + interval 30 day) and c.VitaminA4 is not NUll and
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInMonth >= 30
	UNION ALL 
	SELECT
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
    WHERE (c.VitaminA4 > c.child_dob + interval 30 month + interval 30 day)  and c.VitaminA4 is not NUll and
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInMonth >= 30
	UNION ALL 
	SELECT
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
    WHERE c.VitaminA4 is NUll and
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInMonth >= 30";

	$result = $this->db->query($query)->result();

	foreach ($result as $row) {
		$proportion[] = array(
			"label"	=>	"% of children aged 30 months and above received 4th dose of Vitamin A",
			"value"	=>	$row->total,
			"total" =>	$this->child_count_30_completed_month,
			"proportion"	=>	number_format(($row->total / ($this->child_count_30_completed_month==0?1:$this->child_count_30_completed_month)) * 100, 1),
			);
	}

	return $proportion;
}

/*Due Date 36 Month.*/

private function proportion_vitamin_a5_36_months()
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
    WHERE c.VitaminA5 >= c.child_dob and (c.VitaminA5 <= c.child_dob + interval 36 month) and c.VitaminA5 is not Null and
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInMonth >= 36
	UNION ALL 
	SELECT
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
    WHERE (c.VitaminA5 > c.child_dob + interval 36 month) and (c.VitaminA5 <= c.child_dob + interval 36 month + interval 15 day) and c.VitaminA5 is not Null and
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInMonth >= 36
	UNION ALL 
	 
	SELECT
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
    WHERE (c.VitaminA5 > c.child_dob + interval 36 month + interval 15 day) and (c.VitaminA5 <= c.child_dob + interval 36 month + interval 30 day) and c.VitaminA5 is not Null and
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInMonth >= 36 
	UNION ALL 
	SELECT
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
    WHERE (c.VitaminA5 > c.child_dob + interval 36 month + interval 30 day) and c.VitaminA5 is not Null and
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInMonth >= 36 
	UNION ALL 
	SELECT
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
    WHERE  c.VitaminA5 is Null and
        c.created_by IN(
        SELECT
            user_id
        FROM
            tblusers
        WHERE
            user_mode = 1 AND is_deleted = 0
    ) AND c.IsDeleted = 0 AND m.IsDeleted = 0 AND h.IsDeleted = 0) a
    WHERE
        a.ageInMonth >= 36";

	$result = $this->db->query($query)->result();

	foreach ($result as $row) {
		$proportion[] = array(
			"label"	=>	"% of children aged 36 months and above received 5th dose of Vitamin A",
			"value"	=>	$row->total,
			"total" =>	$this->child_count_36_completed_month,
			"proportion"	=>	number_format(($row->total / ($this->child_count_36_completed_month==0?1:$this->child_count_36_completed_month)) * 100, 1),
			);
	}
	return $proportion;
}

}