<?php 

/**
* Dashboard model for Monthly Report
*/
class Monthly_report_model extends Ci_model
{

	protected $date_filter;
	
	public function __construct()
	{
		parent::__construct();
		$this->date_filter = $this->session->userdata("date_filter");
	}


	public function get_ashawise_demographics()
	{
		$query = "select 
		e.user_id, 
		e.state_code, 
		c.ASHAName,
		ifnull(w.total,0) as Area_and_Demographics,
		ifnull(x.total,0) as total_household,
		ifnull(f.total,0) as total_population,
		ifnull(g.total,0) as women_15_49_years,
		ifnull(h.total,0) as pregnant_women_in_area,
		ifnull(i.total,0) as child_0_5_years,
		ifnull(q.total,0) as married_with_no_child,
		ifnull(r.total,0) as married_with_one_child,
		ifnull(s.total,0) as married_with_3_or_more_child,
		ifnull(l.total,0) as child_0_6_month,
		ifnull(m.total,0) as child_6_1_year,
		ifnull(n.total,0) as child_1_2_year,
		ifnull(o.total,0) as child_2_3_year,
		ifnull(p.total,0) as child_3_5_year,
		ifnull(t.total,0) as pregnant_women_with_no_child,
		ifnull(u.total,0) as pregnant_women_with_one_child,
		ifnull(v.total,0) as pregnant_women_with_3_or_more_child,
		ifnull(j.total,0) as adults_35_50,
		ifnull(k.total,0) as adults_60_plus
		from (select a.user_id, a.user_name, a.state_code, c.ASHAID from tblusers a INNER JOIN userashamapping b on a.user_id = b.UserID INNER JOIN mstasha c on b.ASHAID = c.ASHAID where a.is_deleted=0 and a.user_mode = 1 and a.is_active = 1 and c.LanguageID = 2) e
		LEFT JOIN userashamapping b 
		on b.UserID = e.user_id
		LEFT JOIN mstasha c 
		on b.AshaID = c.ASHAID and c.LanguageID = 1 and c.IsActive=1
		
		left join (SELECT
			COUNT(*) AS total,
			a.createdBy
			FROM
			tblhhfamilymember a 
			inner join tblhhsurvey b
			on a.HHSurveyGUID = b.HHSurveyGUID 
			where a.IsDeleted = 0 and b.IsDeleted = 0
			group by a.CreatedBy
		)f
		on e.user_id = f.CreatedBy
		left join (SELECT
			COUNT(*) AS total,
			a.createdBy
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
			) <=49
			group by a.CreatedBy)g
			on e.user_id = g.createdBy
			left join (select count(*) as total,
			a.CreatedBy,
			c.VillageID
			from tblpregnant_woman a
			inner join tblhhfamilymember b
			on a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
			inner join tblhhsurvey c
			on b.HHSurveyGUID = c.HHSurveyGUID
			where a.IsPregnant=1 and a.IsDeleted = 0 and b.IsDeleted = 0 and c.IsDeleted = 0 AND
			TIMESTAMPDIFF(
			DAY,
			a.LMPDate,
			CURRENT_TIMESTAMP
		) > 0 
			 group by a.CreatedBy
		)h
		on e.user_id = h.createdBy
		left join (SELECT
   count(*) as total, a.AshaID
   FROM
       tblhhfamilymember a
   INNER JOIN tblhhsurvey b ON
       a.HHSurveyGUID = b.HHSurveyGUID
   WHERE
       a.IsDeleted = 0 AND b.IsDeleted = 0 AND (a.GenderID = 1 OR GenderID = 2) AND b.IsActive = 1 
   and
   (
           CASE
           WHEN a.DOBAvailable = 2 THEN (a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear))*365
           WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(DAY, a.DateOfBirth,CURRENT_DATE) END
       ) between 0 and 1825
        GROUP BY a.AshaID
	)i
	on e.AshaID = i.AshaID
	left join (SELECT
		COUNT(*) AS total,
		a.createdBy, b.VillageID
		FROM
		tblhhfamilymember a
		inner join tblhhsurvey b
		on a.HHSurveyGUID = b.HHSurveyGUID
		WHERE
		(
			CASE
			WHEN a.DOBAvailable = 2 THEN a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear)
			WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(YEAR, a.DateOfBirth,CURRENT_DATE) END
		) >= 35 and
		(
			CASE
			WHEN a.DOBAvailable = 2 THEN a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear)
			WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(YEAR, a.DateOfBirth,CURRENT_DATE) END
		) <=50
		group by a.CreatedBy
	)j
		on e.user_id = j.createdBy
		left join (SELECT
			COUNT(*) AS total,
			a.createdBy, b.VillageID
			FROM
			tblhhfamilymember a
			inner join tblhhsurvey b
			on a.HHSurveyGUID = b.HHSurveyGUID
			WHERE a.IsDeleted = 0 and b.IsDeleted = 0 and
			(
				CASE
				WHEN a.DOBAvailable = 2 THEN a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear)
				WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(YEAR, a.DateOfBirth,CURRENT_DATE) END
			) >=60
			group by a.CreatedBy
		)k
		on e.user_id = k.createdBy
		left join (SELECT
   count(*) as total, a.AshaID
   FROM
       tblhhfamilymember a
   INNER JOIN tblhhsurvey b ON
       a.HHSurveyGUID = b.HHSurveyGUID
   WHERE
       a.IsDeleted = 0 AND b.IsDeleted = 0 AND (a.GenderID = 1 OR GenderID = 2) AND b.IsActive = 1 
   and
   (
           CASE
           WHEN a.DOBAvailable = 2 THEN (a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear))*365
           WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(DAY, a.DateOfBirth,CURRENT_DATE) END
       ) between 0 and 182
        GROUP BY a.AshaID
	)l
	on e.AshaID = l.AshaID
	left join (SELECT
   count(*) as total, a.AshaID
   FROM
       tblhhfamilymember a
   INNER JOIN tblhhsurvey b ON
       a.HHSurveyGUID = b.HHSurveyGUID
   WHERE
       a.IsDeleted = 0 AND b.IsDeleted = 0 AND (a.GenderID = 1 OR GenderID = 2) AND b.IsActive = 1 
   and
   (
           CASE
           WHEN a.DOBAvailable = 2 THEN (a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear))*365
           WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(DAY, a.DateOfBirth,CURRENT_DATE) END
       ) between 183 and 365
        GROUP BY a.AshaID
)m
on e.AshaID = m.AshaID
left join (SELECT
   count(*) as total, a.AshaID
   FROM
       tblhhfamilymember a
   INNER JOIN tblhhsurvey b ON
       a.HHSurveyGUID = b.HHSurveyGUID
   WHERE
       a.IsDeleted = 0 AND b.IsDeleted = 0 AND (a.GenderID = 1 OR GenderID = 2) AND b.IsActive = 1 
   and
   (
           CASE
           WHEN a.DOBAvailable = 2 THEN (a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear))*365
           WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(DAY, a.DateOfBirth,CURRENT_DATE) END
       ) between 366 and 730
        GROUP BY a.AshaID
)n
on e.AshaID = n.AshaID
left join (SELECT
   count(*) as total, a.AshaID
   FROM
       tblhhfamilymember a
   INNER JOIN tblhhsurvey b ON
       a.HHSurveyGUID = b.HHSurveyGUID
   WHERE
       a.IsDeleted = 0 AND b.IsDeleted = 0 AND (a.GenderID = 1 OR GenderID = 2) AND b.IsActive = 1 
   and
   (
           CASE
           WHEN a.DOBAvailable = 2 THEN (a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear))*365
           WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(DAY, a.DateOfBirth,CURRENT_DATE) END
       ) between 731 and 1095
        GROUP BY a.AshaID
)o
on e.AshaID = o.AshaID
left join (SELECT
   count(*) as total, a.AshaID
   FROM
       tblhhfamilymember a
   INNER JOIN tblhhsurvey b ON
       a.HHSurveyGUID = b.HHSurveyGUID
   WHERE
       a.IsDeleted = 0 AND b.IsDeleted = 0 AND (a.GenderID = 1 OR GenderID = 2) AND b.IsActive = 1 
   and
   (
           CASE
           WHEN a.DOBAvailable = 2 THEN (a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear))*365
           WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(DAY, a.DateOfBirth,CURRENT_DATE) END
       ) between 1096 and 1825
        GROUP BY a.AshaID
)p
on e.AshaID = p.AshaID
left join(
	select
			COUNT(*) AS total, a.CreatedBy, b.VillageID
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
			) <=49 
			and a.HHFamilyMemberGUID not in (select HHFamilyMemberGUID from tblchild where IsDeleted=0)
	group by a.CreatedBy
)q
on e.user_id = q.CreatedBy
left join(
	select count(*) as total,
	a.CreatedBy,
	b.VillageID
	from tblhhfamilymember a
	inner join tblhhsurvey b
	on a.HHSurveyGUID = b.HHSurveyGUID
	inner join (select motherGUID from tblchild group by motherGUID having count(*) = 1)c
	on c.motherGUID = a.HHFamilyMemberGUID
	where a.MaritialStatusID = 1 and a.IsDeleted = 0 and b.IsDeleted = 0 and a.GenderID = 2 AND
	(
		CASE
		WHEN a.DOBAvailable = 2 THEN a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear)
		WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(YEAR, a.DateOfBirth, CURRENT_DATE) END
	) >= 15 and
	(
		CASE
		WHEN a.DOBAvailable = 2 THEN a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear)
		WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(YEAR, a.DateOfBirth, CURRENT_DATE) END
	) <=49
	group by a.CreatedBy
)r
on e.user_id = r.CreatedBy
left join(
	select count(*) as total,
	a.CreatedBy,
	b.VillageID
	from tblhhfamilymember a
	inner join tblhhsurvey b
	on a.HHSurveyGUID = b.HHSurveyGUID
	inner join (select motherGUID from tblchild where IsDeleted = 0 group by motherGUID having count(*) >= 3)c
	on c.motherGUID = a.HHFamilyMemberGUID
	where a.MaritialStatusID = 1 and a.IsDeleted = 0 and b.IsDeleted = 0 and a.GenderID = 2 AND
	(
		CASE
		WHEN a.DOBAvailable = 2 THEN a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear)
		WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(YEAR, a.DateOfBirth, CURRENT_DATE) END
	) >= 15 and
	(
		CASE
		WHEN a.DOBAvailable = 2 THEN a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear)
		WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(YEAR, a.DateOfBirth, CURRENT_DATE) END
	) <=49
	group by a.CreatedBy
)s
on e.user_id = s.CreatedBy
left join(
	select
						COUNT(*) AS total, a.CreatedBy
						FROM
						tblhhfamilymember a
						inner join tblpregnant_woman b
						on a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
						WHERE 
						a.IsDeleted = 0 and b.IsDeleted = 0 AND b.IsPregnant = 1
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
						) <=49 
						and a.HHFamilyMemberGUID not in (select HHFamilyMemberGUID from tblchild where IsDeleted=0)
	group by a.CreatedBy
)t
on e.user_id = t.CreatedBy
left join(
	select count(*) as total,
	a.CreatedBy
	from tblhhfamilymember a
	inner join tblpregnant_woman b
	on a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
	inner join (select HHFamilyMemberGUID from tblchild group by HHFamilyMemberGUID having count(*) = 1 )d
	on d.HHFamilyMemberGUID = b.HHFamilyMemberGUID
	where 
	a.IsDeleted = 0 and b.IsDeleted = 0 AND b.IsPregnant = 1 and a.GenderID = 2
	and a.MaritialStatusID = 1 and
	(
		CASE
		WHEN a.DOBAvailable = 2 THEN a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear)
		WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(YEAR, a.DateOfBirth,CURRENT_DATE) END
	) >= 15 and
	(
		CASE
		WHEN a.DOBAvailable = 2 THEN a.AprilAgeYear + (YEAR(CURRENT_DATE) - a.AgeAsOnYear)
		WHEN a.DOBAvailable = 1 THEN TIMESTAMPDIFF(YEAR, a.DateOfBirth,CURRENT_DATE) END
	) <=49 
	group by a.CreatedBy
)u
on e.user_id = u.CreatedBy
left join(
	select count(*) as total,
		b.CreatedBy
		from tblpregnant_woman a
		inner join tblhhfamilymember b
		on a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
		inner join (select HHFamilyMemberGUID from tblchild group by HHFamilyMemberGUID having count(*)>=3)d
		on d.HHFamilyMemberGUID = b.HHFamilyMemberGUID
		where 
		a.IsDeleted = 0 and b.IsDeleted = 0 AND a.IsPregnant = 1 and b.GenderID = 2
		and b.MaritialStatusID = 1 and
		(
			CASE
			WHEN b.DOBAvailable = 2 THEN b.AprilAgeYear + (YEAR(CURRENT_DATE) - b.AgeAsOnYear)
			WHEN b.DOBAvailable = 1 THEN TIMESTAMPDIFF(YEAR, b.DateOfBirth,CURRENT_DATE) END
		) >= 15 and
		(
			CASE
			WHEN b.DOBAvailable = 2 THEN b.AprilAgeYear + (YEAR(CURRENT_DATE) - b.AgeAsOnYear)
			WHEN b.DOBAvailable = 1 THEN TIMESTAMPDIFF(YEAR, b.DateOfBirth,CURRENT_DATE) END
		) <=49 
		group by b.CreatedBy
)v
on e.user_id = v.CreatedBy
left join(select count(*) as total, a.ASHAID, b.UserID
from ashavillage a 
left join userashamapping b 
on a.ASHAID = b.AshaID
group by b.UserID
)w 
on e.user_id = w.UserID
left join(select count(*) as total, CreatedBy
from tblhhsurvey WHERE IsDeleted = 0 group by CreatedBy
)x 
on e.user_id = x.CreatedBy ORDER BY e.user_id ASC";

return $this->db->query($query)->result();
}


public function get_Pregnent()
{
	$query = "select
    a.one_to_three,
    b.three_to_six,
    c.six_to_nine,
    d.nine_more,
    e.nonpregnent,
    a.one_to_three + b.three_to_six + c.six_to_nine + d.nine_more AS total
FROM
    (
    SELECT
        COUNT(*) AS one_to_three,
        1 AS id
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
        ) <= 90
        and fm.CreatedBy in (select user_id from tblusers where is_deleted=0 and user_mode= 1)
) a
LEFT JOIN(
    SELECT
        COUNT(*) AS three_to_six,
        1 AS id
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
        ) <= 180
        and fm.CreatedBy in (select user_id from tblusers where is_deleted=0 and user_mode= 1)
) b
ON
    a.id = b.id
LEFT JOIN(
    SELECT
        COUNT(*) AS six_to_nine,
        1 AS id
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
        ) <= 270
        and fm.CreatedBy in (select user_id from tblusers where is_deleted=0 and user_mode= 1)
) c
ON
    b.id = c.id
    LEFT JOIN(
    SELECT
        COUNT(*) AS nine_more,
        1 AS id
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
        ) > 270
        and fm.CreatedBy in (select user_id from tblusers where is_deleted=0 and user_mode= 1)
) d
ON
    c.id = d.id
LEFT JOIN(
    SELECT
        COUNT(*) AS nonpregnent,
        1 AS id
    FROM
        tblpregnant_woman m
    INNER JOIN tblhhfamilymember fm ON
        m.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
    INNER JOIN tblhhsurvey h ON
        h.HHSurveyGUID = fm.HHSurveyGUID
    WHERE
        m.IsDeleted = 0 AND fm.IsDeleted = 0 AND h.IsDeleted = 0 AND fm.StatusID = 1 AND m.IsPregnant = 0
        and fm.CreatedBy in (select user_id from tblusers where is_deleted=0 and user_mode= 1)
) e
ON
    d.id = e.id";
		// die($query);
	return $this->db->query($query)->row();


}



public function get_Pregnent_anc1()
{
	$query = "select
	a.one_to_three,
	b.three_to_six,
	c.six_to_nine,
    d.nine_more,
	e.nonpregnent,
	a.one_to_three+b.three_to_six+c.six_to_nine+d.nine_more as total
	FROM
	(
		SELECT
		COUNT(*) AS one_to_three,
		1 AS id
		FROM
		tblancvisit a
		INNER JOIN tblpregnant_woman m ON
		a.PWGUID = m.PWGUID
		INNER JOIN tblhhfamilymember fm ON
		m.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = fm.HHSurveyGUID
		WHERE
		a.CheckupVisitDate IS NOT NULL AND a.Visit_No = 1 and m.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND a.VisitGUID IS NOT NULL AND a.Visit_No = 1 AND h.IsDeleted = 0 AND m.IsPregnant = 1 AND TIMESTAMPDIFF(
			DAY,
			m.LMPDate,
			CURRENT_TIMESTAMP
		) > 0 AND TIMESTAMPDIFF(
			DAY,
			m.LMPDate,
			CURRENT_TIMESTAMP
		) <= 90
	) a
	LEFT JOIN(
		SELECT
		COUNT(*) AS three_to_six,
		1 AS id
		FROM
		tblancvisit a
		INNER JOIN tblpregnant_woman m ON
		a.PWGUID = m.PWGUID
		INNER JOIN tblhhfamilymember fm ON
		m.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = fm.HHSurveyGUID
		WHERE
		a.CheckupVisitDate IS NOT NULL AND a.Visit_No = 1 AND m.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0 AND m.IsPregnant = 1 AND TIMESTAMPDIFF(
			DAY,
			m.LMPDate,
			CURRENT_TIMESTAMP
		) > 90 AND TIMESTAMPDIFF(
			DAY,
			m.LMPDate,
			CURRENT_TIMESTAMP
		) <= 180
	) b
	ON
	a.id = b.id
	LEFT JOIN(
		SELECT
		COUNT(*) AS six_to_nine,
		1 AS id
		FROM
		tblancvisit a
		INNER JOIN tblpregnant_woman m ON
		a.PWGUID = m.PWGUID
		INNER JOIN tblhhfamilymember fm ON
		m.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = fm.HHSurveyGUID
		WHERE
		a.CheckupVisitDate IS NOT NULL AND a.Visit_No = 1 AND m.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0 AND m.IsPregnant = 1 AND TIMESTAMPDIFF(
			DAY,
			m.LMPDate,
			CURRENT_TIMESTAMP
		) > 180 AND TIMESTAMPDIFF(
			DAY,
			m.LMPDate,
			CURRENT_TIMESTAMP
		) <= 270
	) c
	ON
	b.id = c.id
    LEFT JOIN(
		SELECT
		COUNT(*) AS nine_more,
		1 AS id
		FROM
		tblancvisit a
		INNER JOIN tblpregnant_woman m ON
		a.PWGUID = m.PWGUID
		INNER JOIN tblhhfamilymember fm ON
		m.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = fm.HHSurveyGUID
		WHERE
		a.CheckupVisitDate IS NOT NULL AND a.Visit_No = 1 AND m.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0 AND m.IsPregnant = 1 AND TIMESTAMPDIFF(
			DAY,
			m.LMPDate,
			CURRENT_TIMESTAMP
		) > 270
	) d
	ON
	d.id = c.id
	LEFT JOIN(
		SELECT
		COUNT(*) AS nonpregnent,
		1 AS id
		FROM
		tblancvisit a
		INNER JOIN tblpregnant_woman m ON
		a.PWGUID = m.PWGUID
		INNER JOIN tblhhfamilymember fm ON
		m.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		fm.HHSurveyGUID = h.HHSurveyGUID
		WHERE
		a.CheckupVisitDate IS NOT NULL AND a.Visit_No = 1 AND m.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0 AND m.IsPregnant = 0
	) e
	ON
	e.id = d.id";

	return $this->db->query($query)->row();
}

public function get_Pregnent_anc2()
{
	$query = "select
	a.one_to_three,
	b.three_to_six,
	c.six_to_nine,
    d.nine_more,
	e.nonpregnent,
	a.one_to_three+b.three_to_six+c.six_to_nine+d.nine_more as total
	FROM
	(
		SELECT
		COUNT(*) AS one_to_three,
		1 AS id
		FROM
		tblancvisit a
		INNER JOIN tblpregnant_woman m ON
		a.PWGUID = m.PWGUID
		INNER JOIN tblhhfamilymember fm ON
		m.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = fm.HHSurveyGUID
		WHERE
		a.CheckupVisitDate IS NOT NULL AND a.Visit_No = 2 and m.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND a.VisitGUID IS NOT NULL AND a.Visit_No = 1 AND h.IsDeleted = 0 AND m.IsPregnant = 1 AND TIMESTAMPDIFF(
			DAY,
			m.LMPDate,
			CURRENT_TIMESTAMP
		) > 0 AND TIMESTAMPDIFF(
			DAY,
			m.LMPDate,
			CURRENT_TIMESTAMP
		) <= 90
	) a
	LEFT JOIN(
		SELECT
		COUNT(*) AS three_to_six,
		1 AS id
		FROM
		tblancvisit a
		INNER JOIN tblpregnant_woman m ON
		a.PWGUID = m.PWGUID
		INNER JOIN tblhhfamilymember fm ON
		m.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = fm.HHSurveyGUID
		WHERE
		a.CheckupVisitDate IS NOT NULL AND a.Visit_No = 2 AND m.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0 AND m.IsPregnant = 1 AND TIMESTAMPDIFF(
			DAY,
			m.LMPDate,
			CURRENT_TIMESTAMP
		) > 90 AND TIMESTAMPDIFF(
			DAY,
			m.LMPDate,
			CURRENT_TIMESTAMP
		) <= 180
	) b
	ON
	a.id = b.id
	LEFT JOIN(
		SELECT
		COUNT(*) AS six_to_nine,
		1 AS id
		FROM
		tblancvisit a
		INNER JOIN tblpregnant_woman m ON
		a.PWGUID = m.PWGUID
		INNER JOIN tblhhfamilymember fm ON
		m.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = fm.HHSurveyGUID
		WHERE
		a.CheckupVisitDate IS NOT NULL AND a.Visit_No = 2 AND m.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0 AND m.IsPregnant = 1 AND TIMESTAMPDIFF(
			DAY,
			m.LMPDate,
			CURRENT_TIMESTAMP
		) > 180 AND TIMESTAMPDIFF(
			DAY,
			m.LMPDate,
			CURRENT_TIMESTAMP
		) <= 270
	) c
	ON
	b.id = c.id
    LEFT JOIN(
		SELECT
		COUNT(*) AS nine_more,
		1 AS id
		FROM
		tblancvisit a
		INNER JOIN tblpregnant_woman m ON
		a.PWGUID = m.PWGUID
		INNER JOIN tblhhfamilymember fm ON
		m.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = fm.HHSurveyGUID
		WHERE
		a.CheckupVisitDate IS NOT NULL AND a.Visit_No = 2 AND m.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0 AND m.IsPregnant = 1 AND TIMESTAMPDIFF(
			DAY,
			m.LMPDate,
			CURRENT_TIMESTAMP
		) > 270
	) d
	ON
	d.id = c.id
	LEFT JOIN(
		SELECT
		COUNT(*) AS nonpregnent,
		1 AS id
		FROM
		tblancvisit a
		INNER JOIN tblpregnant_woman m ON
		a.PWGUID = m.PWGUID
		INNER JOIN tblhhfamilymember fm ON
		m.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		fm.HHSurveyGUID = h.HHSurveyGUID
		WHERE
		a.CheckupVisitDate IS NOT NULL AND a.Visit_No = 2 AND m.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0 AND m.IsPregnant = 0
	) e
	ON
	e.id = d.id";
	return $this->db->query($query)->row();
}

public function get_Pregnent_anc3()
{
	$query = "select
	a.one_to_three,
	b.three_to_six,
	c.six_to_nine,
    d.nine_more,
	e.nonpregnent,
	a.one_to_three+b.three_to_six+c.six_to_nine+d.nine_more as total
	FROM
	(
		SELECT
		COUNT(*) AS one_to_three,
		1 AS id
		FROM
		tblancvisit a
		INNER JOIN tblpregnant_woman m ON
		a.PWGUID = m.PWGUID
		INNER JOIN tblhhfamilymember fm ON
		m.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = fm.HHSurveyGUID
		WHERE
		a.CheckupVisitDate IS NOT NULL AND a.Visit_No = 3 and m.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND a.VisitGUID IS NOT NULL AND a.Visit_No = 1 AND h.IsDeleted = 0 AND m.IsPregnant = 1 AND TIMESTAMPDIFF(
			DAY,
			m.LMPDate,
			CURRENT_TIMESTAMP
		) > 0 AND TIMESTAMPDIFF(
			DAY,
			m.LMPDate,
			CURRENT_TIMESTAMP
		) <= 90
	) a
	LEFT JOIN(
		SELECT
		COUNT(*) AS three_to_six,
		1 AS id
		FROM
		tblancvisit a
		INNER JOIN tblpregnant_woman m ON
		a.PWGUID = m.PWGUID
		INNER JOIN tblhhfamilymember fm ON
		m.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = fm.HHSurveyGUID
		WHERE
		a.CheckupVisitDate IS NOT NULL AND a.Visit_No = 3 AND m.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0 AND m.IsPregnant = 1 AND TIMESTAMPDIFF(
			DAY,
			m.LMPDate,
			CURRENT_TIMESTAMP
		) > 90 AND TIMESTAMPDIFF(
			DAY,
			m.LMPDate,
			CURRENT_TIMESTAMP
		) <= 180
	) b
	ON
	a.id = b.id
	LEFT JOIN(
		SELECT
		COUNT(*) AS six_to_nine,
		1 AS id
		FROM
		tblancvisit a
		INNER JOIN tblpregnant_woman m ON
		a.PWGUID = m.PWGUID
		INNER JOIN tblhhfamilymember fm ON
		m.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = fm.HHSurveyGUID
		WHERE
		a.CheckupVisitDate IS NOT NULL AND a.Visit_No = 3 AND m.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0 AND m.IsPregnant = 1 AND TIMESTAMPDIFF(
			DAY,
			m.LMPDate,
			CURRENT_TIMESTAMP
		) > 180 AND TIMESTAMPDIFF(
			DAY,
			m.LMPDate,
			CURRENT_TIMESTAMP
		) <= 270
	) c
	ON
	b.id = c.id
    LEFT JOIN(
		SELECT
		COUNT(*) AS nine_more,
		1 AS id
		FROM
		tblancvisit a
		INNER JOIN tblpregnant_woman m ON
		a.PWGUID = m.PWGUID
		INNER JOIN tblhhfamilymember fm ON
		m.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = fm.HHSurveyGUID
		WHERE
		a.CheckupVisitDate IS NOT NULL AND a.Visit_No = 3 AND m.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0 AND m.IsPregnant = 1 AND TIMESTAMPDIFF(
			DAY,
			m.LMPDate,
			CURRENT_TIMESTAMP
		) > 270
	) d
	ON
	d.id = c.id
	LEFT JOIN(
		SELECT
		COUNT(*) AS nonpregnent,
		1 AS id
		FROM
		tblancvisit a
		INNER JOIN tblpregnant_woman m ON
		a.PWGUID = m.PWGUID
		INNER JOIN tblhhfamilymember fm ON
		m.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		fm.HHSurveyGUID = h.HHSurveyGUID
		WHERE
		a.CheckupVisitDate IS NOT NULL AND a.Visit_No = 3 AND m.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0 AND m.IsPregnant = 0
	) e
	ON
	e.id = d.id";
	return $this->db->query($query)->row();
}

public function get_Pregnent_anc4()
{
	$query = "select
	a.one_to_three,
	b.three_to_six,
	c.six_to_nine,
    d.nine_more,
	e.nonpregnent,
	a.one_to_three+b.three_to_six+c.six_to_nine+d.nine_more as total
	FROM
	(
		SELECT
		COUNT(*) AS one_to_three,
		1 AS id
		FROM
		tblancvisit a
		INNER JOIN tblpregnant_woman m ON
		a.PWGUID = m.PWGUID
		INNER JOIN tblhhfamilymember fm ON
		m.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = fm.HHSurveyGUID
		WHERE
		a.CheckupVisitDate IS NOT NULL AND a.Visit_No = 4 and m.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND a.VisitGUID IS NOT NULL AND a.Visit_No = 1 AND h.IsDeleted = 0 AND m.IsPregnant = 1 AND TIMESTAMPDIFF(
			DAY,
			m.LMPDate,
			CURRENT_TIMESTAMP
		) > 0 AND TIMESTAMPDIFF(
			DAY,
			m.LMPDate,
			CURRENT_TIMESTAMP
		) <= 90
	) a
	LEFT JOIN(
		SELECT
		COUNT(*) AS three_to_six,
		1 AS id
		FROM
		tblancvisit a
		INNER JOIN tblpregnant_woman m ON
		a.PWGUID = m.PWGUID
		INNER JOIN tblhhfamilymember fm ON
		m.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = fm.HHSurveyGUID
		WHERE
		a.CheckupVisitDate IS NOT NULL AND a.Visit_No = 4 AND m.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0 AND m.IsPregnant = 1 AND TIMESTAMPDIFF(
			DAY,
			m.LMPDate,
			CURRENT_TIMESTAMP
		) > 90 AND TIMESTAMPDIFF(
			DAY,
			m.LMPDate,
			CURRENT_TIMESTAMP
		) <= 180
	) b
	ON
	a.id = b.id
	LEFT JOIN(
		SELECT
		COUNT(*) AS six_to_nine,
		1 AS id
		FROM
		tblancvisit a
		INNER JOIN tblpregnant_woman m ON
		a.PWGUID = m.PWGUID
		INNER JOIN tblhhfamilymember fm ON
		m.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = fm.HHSurveyGUID
		WHERE
		a.CheckupVisitDate IS NOT NULL AND a.Visit_No = 4 AND m.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0 AND m.IsPregnant = 1 AND TIMESTAMPDIFF(
			DAY,
			m.LMPDate,
			CURRENT_TIMESTAMP
		) > 180 AND TIMESTAMPDIFF(
			DAY,
			m.LMPDate,
			CURRENT_TIMESTAMP
		) <= 270
	) c
	ON
	b.id = c.id
    LEFT JOIN(
		SELECT
		COUNT(*) AS nine_more,
		1 AS id
		FROM
		tblancvisit a
		INNER JOIN tblpregnant_woman m ON
		a.PWGUID = m.PWGUID
		INNER JOIN tblhhfamilymember fm ON
		m.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = fm.HHSurveyGUID
		WHERE
		a.CheckupVisitDate IS NOT NULL AND a.Visit_No = 4 AND m.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0 AND m.IsPregnant = 1 AND TIMESTAMPDIFF(
			DAY,
			m.LMPDate,
			CURRENT_TIMESTAMP
		) > 270
	) d
	ON
	d.id = c.id
	LEFT JOIN(
		SELECT
		COUNT(*) AS nonpregnent,
		1 AS id
		FROM
		tblancvisit a
		INNER JOIN tblpregnant_woman m ON
		a.PWGUID = m.PWGUID
		INNER JOIN tblhhfamilymember fm ON
		m.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		fm.HHSurveyGUID = h.HHSurveyGUID
		WHERE
		a.CheckupVisitDate IS NOT NULL AND a.Visit_No = 4 AND m.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0 AND m.IsPregnant = 0
	) e
	ON
	e.id = d.id";
	return $this->db->query($query)->row();
}


public function live_birth($date_filter = NULL)
{
	$query = "select
	a.male,
	b.female,
	a.male+b.female as total
	FROM
	(
		SELECT
		COUNT(*) AS male,
		1 AS id
		FROM
		tblchild a
		INNER JOIN tblpregnant_woman b ON
		a.pw_GUID = b.PWGUID
		INNER JOIN tblhhfamilymember c ON
		c.HHFamilyMemberGUID = b.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey d ON
		d.HHSurveyGUID = c.HHSurveyGUID
		WHERE
		c.IsDeleted = 0 AND a.IsDeleted = 0 AND d.IsDeleted = 0 AND a.Gender = 2 AND c.StatusID = 1 AND b.DeliveryType = 1";
		if ($this->date_filter != NULL)
	{
		$query .= " and  a.child_dob > '" . $this->date_filter['date_from'] . "' and a.child_dob < '" . $this->date_filter['date_to'] . "'";
	}

	$query .= ") a
	LEFT JOIN(
		SELECT
		COUNT(*) AS female,
		1 AS id
		FROM
		tblchild a
		INNER JOIN tblpregnant_woman b ON
		a.pw_GUID = b.PWGUID
		INNER JOIN tblhhfamilymember c ON
		c.HHFamilyMemberGUID = b.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey d ON
		d.HHSurveyGUID = c.HHSurveyGUID
		WHERE
		c.IsDeleted = 0 AND a.IsDeleted = 0 AND d.IsDeleted = 0 AND a.Gender = 1 AND c.StatusID = 1 AND b.DeliveryType = 1 ";
		if ($this->date_filter != NULL)
	{
		$query .= " and a.child_dob > '" . $this->date_filter['date_from'] . "' and a.child_dob < '" . $this->date_filter['date_to'] . "'";
	}

	$query .= ") b
	ON
	a.id = b.id";

	// if ($this->date_filter != NULL)
	// {
	// 	$query .= " a.created_on > '" . $this->date_filter['date_from'] . "' and a.created_on < '" . $this->date_filter['date_to'] . "'";
	// }
	// print_r($query); die();
	return $this->db->query($query)->row();
}




public function Caesarean_Deliveries()
{
	$query = " ";
	return $this->db->query($query)->row();
}


public function Still_Birth()
{
	$query = "SELECT count(*) as total FROM `tblpregnant_woman`where DeliveryType =2";
	if ($this->date_filter != NULL)
	{
		$query .= "  and DeliveryDateTime > '" . $this->date_filter['date_from'] . "' and DeliveryDateTime < '" . $this->date_filter['date_to'] . "'";
	}
	// print_r($query); die();
	return $this->db->query($query)->row();
}


public function Abortion()
{
	$query = "SELECT count(*) as total FROM `tblpregnant_woman` where ISAbortion = 1";
	if ($this->date_filter != NULL)
	{
		$query .= "  and DeliveryDateTime > '" . $this->date_filter['date_from'] . "' and DeliveryDateTime < '" . $this->date_filter['date_to'] . "'";
	}
	// print_r($query); die();

	return $this->db->query($query)->row();
}

public function newborn_heaving_weight_less()
{
	$query = "select
	a.male,
	b.female,
	a.male+b.female as total
	FROM
	(
		SELECT
		COUNT(*) AS male,
		1 AS id
		FROM
		tblchild 
		WHERE
		IsDeleted = 0 AND Wt_of_child < 2.5 and Gender = 2 ";
			if ($this->date_filter != NULL)
		{
			$query .= " and child_dob > '" . $this->date_filter['date_from'] . "' and child_dob < '" . $this->date_filter['date_to'] . "'";
		}
	$query .= ") a
	LEFT JOIN(
		SELECT
		COUNT(*) AS female,
		1 AS id
		FROM
		tblchild 
		WHERE
		IsDeleted = 0 AND Wt_of_child < 2.5 and Gender = 1";
			if ($this->date_filter != NULL)
		{
			$query .= " and child_dob > '" . $this->date_filter['date_from'] . "' and child_dob < '" . $this->date_filter['date_to'] . "'";
		}
	$query .= ") b
	ON
	a.id = b.id";

	// print_r($query); die();

	return $this->db->query($query)->row();
}

public function newborn_breast_fed_within_1_hour()
{
	$query = "select
	a.male,
	b.female,
	a.male+b.female as total
	FROM
	(
		SELECT
		COUNT(*) AS male,
		1 AS id
		FROM
		tblchild
		WHERE
		IsDeleted = 0 AND breastfeeding_within1H = 1 AND Gender = 2";
			if ($this->date_filter != NULL)
		{
			$query .= " and child_dob > '" . $this->date_filter['date_from'] . "' and child_dob < '" . $this->date_filter['date_to'] . "'";
		}
	$query .= ") a
	LEFT JOIN(
		SELECT
		COUNT(*) AS female,
		1 AS id
		FROM
		tblchild
		WHERE
		IsDeleted = 0 AND breastfeeding_within1H = 1 AND Gender = 1 ";
			if ($this->date_filter != NULL)
		{
			$query .= " and child_dob > '" . $this->date_filter['date_from'] . "' and child_dob < '" . $this->date_filter['date_to'] . "'";
		}
	$query .=") b
	ON
	a.id = b.id";
	// print_r($query); die();
	return $this->db->query($query)->row();
}


public function children_age_less_then_5()
{
	$query = "select
	a.male,
	b.female,
	a.male+b.female as total
	FROM
	(
		SELECT
		COUNT(*) AS male,
		1 AS id
		FROM
		tblchild c
		INNER JOIN tblhhsurvey h ON
		c.HHGUID = h.HHSurveyGUID
		WHERE
		c.IsDeleted = 0  AND h.IsDeleted = 0 AND c.Gender = 1 AND TIMESTAMPDIFF(
			MONTH,
			c.child_dob,
			CURRENT_TIMESTAMP
		) <= 60 and c.created_by in (select user_id from tblusers where is_deleted=0 and user_mode=1)";
			
	$query .= ") a
	LEFT JOIN(
		SELECT
		COUNT(*) AS female,
		1 AS id
		FROM
		tblchild c
		INNER JOIN tblhhsurvey h ON
		c.HHGUID = h.HHSurveyGUID
		WHERE
		c.IsDeleted = 0 AND h.IsDeleted = 0 AND c.Gender = 2 AND TIMESTAMPDIFF(
			MONTH,
			c.child_dob,
			CURRENT_TIMESTAMP
		) <= 60 and c.created_by in (select user_id from tblusers where is_deleted=0 and user_mode=1)";
			
	$query .= ") b
	on a.id=b.id";
	// print_r($query); die();
	return $this->db->query($query)->row();
}

public function children_age_less_then_1()
{
	$query = "select
	a.male,
	b.female,
	a.male+b.female as total
	FROM
	(
		SELECT
		COUNT(*) AS male,
		1 AS id
		FROM
		tblchild c
		INNER JOIN tblhhsurvey h ON
		c.HHGUID = h.HHSurveyGUID
		WHERE
		c.IsDeleted = 0  AND h.IsDeleted = 0  AND c.Gender = 2 AND TIMESTAMPDIFF(
			MONTH,
			c.child_dob,
			CURRENT_TIMESTAMP
		) <= 1 and c.created_by in (select user_id from tblusers where is_deleted=0 and user_mode=1)";
			
	$query .= ") a
	LEFT JOIN(
		SELECT
		COUNT(*) AS female,
		1 AS id
		FROM
		tblchild c
		INNER JOIN tblhhsurvey h ON
		c.HHGUID = h.HHSurveyGUID
		WHERE
		c.IsDeleted = 0  AND h.IsDeleted = 0  AND c.Gender = 1 AND TIMESTAMPDIFF(
			MONTH,
			c.child_dob,
			CURRENT_TIMESTAMP
		) <= 1 and c.created_by in (select user_id from tblusers where is_deleted=0 and user_mode=1)";
			
	$query .= ") b
	ON
	a.id = b.id";
	// print_r($query); die();
	return $this->db->query($query)->row();
}


public function children_age_greater_then_1_and_less_then_6()
{
	$query = "select
	a.male,
	b.female,
	a.male+b.female as total
	FROM
	(
		SELECT
		COUNT(*) AS male,
		1 AS id
		FROM
		tblchild c
		INNER JOIN tblhhsurvey h ON
		c.HHGUID = h.HHSurveyGUID
		WHERE
		c.IsDeleted = 0  AND h.IsDeleted = 0  AND c.Gender = 2 AND TIMESTAMPDIFF(
			MONTH,
			c.child_dob,
			CURRENT_TIMESTAMP
		) > 1 AND TIMESTAMPDIFF(
			MONTH,
			c.child_dob,
			CURRENT_TIMESTAMP
		) <= 6 and c.created_by in (select user_id from tblusers where is_deleted=0 and user_mode=1)";
			
	$query .= ") a
	LEFT JOIN(
		SELECT
		COUNT(*) AS female,
		1 AS id
		FROM
		tblchild c
		INNER JOIN tblhhsurvey h ON
		c.HHGUID = h.HHSurveyGUID
		WHERE
		c.IsDeleted = 0 AND h.IsDeleted = 0  AND c.Gender = 1 AND TIMESTAMPDIFF(
			MONTH,
			c.child_dob,
			CURRENT_TIMESTAMP
		) > 1 AND TIMESTAMPDIFF(
			MONTH,
			c.child_dob,
			CURRENT_TIMESTAMP
		) <= 6 and c.created_by in (select user_id from tblusers where is_deleted=0 and user_mode=1)";
			
	$query .= ") b
	ON
	a.id = b.id";
	// print_r($query); die();

	return $this->db->query($query)->row();
}



public function children_age_greater_then_11()
{
	$query = "select
	a.male,
	b.female,
	a.male+b.female as total
	FROM
	(
		SELECT
		COUNT(*) AS male,
		1 AS id
		FROM
		tblchild c
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = c.HHGUID
		WHERE
		c.IsDeleted = 0  AND h.IsDeleted = 0  AND c.Gender = 2 AND TIMESTAMPDIFF(
			MONTH,
			c.child_dob,
			CURRENT_TIMESTAMP
		) >= 11 and c.created_by in (select user_id from tblusers where is_deleted=0 and user_mode=1)";
		
	$query .= ") a
	LEFT JOIN(
		SELECT
		COUNT(*) AS female,
		1 AS id
		FROM
		tblchild c
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = c.HHGUID
		WHERE
		c.IsDeleted = 0  AND h.IsDeleted = 0  AND c.Gender = 1 AND TIMESTAMPDIFF(
			MONTH,
			c.child_dob,
			CURRENT_TIMESTAMP
		) >= 11 and c.created_by in (select user_id from tblusers where is_deleted=0 and user_mode=1)";
			
	$query .= ") b
	ON
	a.id = b.id";

	return $this->db->query($query)->row();
}

public function children_age_greater_then_11_BCG()
{
	$query = "select
	a.male,
	b.female,
	a.male+b.female as total
	FROM
	(
		SELECT
		COUNT(*) AS male,
		1 AS id
		FROM
		tblchild c
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = c.HHGUID
		WHERE
		c.IsDeleted = 0  AND h.IsDeleted = 0  AND c.Gender = 2 AND TIMESTAMPDIFF(
			MONTH,
			c.child_dob,
			CURRENT_TIMESTAMP
		) >= 11 AND c.bcg IS NOT NULL ";
			if ($this->date_filter != NULL)
		{
			$query .= " and c.bcg > '" . $this->date_filter['date_from'] . "' and c.bcg < '" . $this->date_filter['date_to'] . "'";
		}
	$query .= ") a
	LEFT JOIN(
		SELECT
		COUNT(*) AS female,
		1 AS id
		FROM
		tblchild c
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = c.HHGUID
		WHERE
		c.IsDeleted = 0 AND h.IsDeleted = 0  AND c.Gender = 1 AND TIMESTAMPDIFF(
			MONTH,
			c.child_dob,
			CURRENT_TIMESTAMP
		) >= 11 AND c.bcg IS NOT NULL ";
			if ($this->date_filter != NULL)
		{
			$query .= " and c.bcg > '" . $this->date_filter['date_from'] . "' and c.bcg < '" . $this->date_filter['date_to'] . "'";
		}
	$query .=") b
	ON
	a.id = b.id";
	// print_r($query); die();

	return $this->db->query($query)->row();
}

public function children_age_greater_then_11_DPT1()
{
	$query = "select
	a.male,
	b.female,
	a.male+b.female as total
	FROM
	(
		SELECT
		COUNT(*) AS male,
		1 AS id
		FROM
		tblchild c
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = c.HHGUID
		WHERE
		c.IsDeleted = 0  AND h.IsDeleted = 0  AND c.Gender = 2 AND TIMESTAMPDIFF(
			MONTH,
			c.child_dob,
			CURRENT_TIMESTAMP
		) >= 11 AND c.dpt1 IS NOT NULL ";
			if ($this->date_filter != NULL)
		{
			$query .= " and c.dpt1 > '" . $this->date_filter['date_from'] . "' and c.dpt1 < '" . $this->date_filter['date_to'] . "'";
		}
	$query .=") a
	LEFT JOIN(
		SELECT
		COUNT(*) AS female,
		1 AS id
		FROM
		tblchild c
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = c.HHGUID
		WHERE
		c.IsDeleted = 0  AND h.IsDeleted = 0  AND c.Gender = 1 AND TIMESTAMPDIFF(
			MONTH,
			c.child_dob,
			CURRENT_TIMESTAMP
		) >= 11 AND c.dpt1 IS NOT NULL";
			if ($this->date_filter != NULL)
		{
			$query .= " and c.dpt1 > '" . $this->date_filter['date_from'] . "' and c.dpt1 < '" . $this->date_filter['date_to'] . "'";
		}
	$query .= ") b
	ON
	a.id = b.id";

	return $this->db->query($query)->row();
}

public function children_age_greater_then_11_DPT2()
{
	$query = "select
	a.male,
	b.female,
	a.male+b.female as total
	FROM
	(
		SELECT
		COUNT(*) AS male,
		1 AS id
		FROM
		tblchild c
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = c.HHGUID
		WHERE
		c.IsDeleted = 0  AND h.IsDeleted = 0  AND c.Gender = 2 AND TIMESTAMPDIFF(
			MONTH,
			c.child_dob,
			CURRENT_TIMESTAMP
		) >= 11 AND c.dpt2 IS NOT NULL ";
			if ($this->date_filter != NULL)
		{
			$query .= " and c.dpt2 > '" . $this->date_filter['date_from'] . "' and c.dpt2 < '" . $this->date_filter['date_to'] . "'";
		}
	$query .= ") a
	LEFT JOIN(
		SELECT
		COUNT(*) AS female,
		1 AS id
		FROM
		tblchild c
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = c.HHGUID
		WHERE
		c.IsDeleted = 0  AND h.IsDeleted = 0  AND c.Gender = 1 AND TIMESTAMPDIFF(
			MONTH,
			c.child_dob,
			CURRENT_TIMESTAMP
		) >= 11 AND c.dpt2 IS NOT NULL";
			if ($this->date_filter != NULL)
		{
			$query .= " and c.dpt2 > '" . $this->date_filter['date_from'] . "' and c.dpt2 < '" . $this->date_filter['date_to'] . "'";
		}
	$query .= ") b
	ON
	a.id = b.id";

	return $this->db->query($query)->row();
}


public function children_age_greater_then_11_DPT3()
{
	$query = "select
	a.male,
	b.female,
	a.male+b.female as total
	FROM
	(
		SELECT
		COUNT(*) AS male,
		1 AS id
		FROM
		tblchild c
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = c.HHGUID
		WHERE
		c.IsDeleted = 0  AND h.IsDeleted = 0  AND c.Gender = 2 AND TIMESTAMPDIFF(
			MONTH,
			c.child_dob,
			CURRENT_TIMESTAMP
		) >= 11 AND c.dpt3 IS NOT NULL ";
			if ($this->date_filter != NULL)
		{
			$query .= " and c.dpt3 > '" . $this->date_filter['date_from'] . "' and c.dpt3 < '" . $this->date_filter['date_to'] . "'";
		}
	$query .= ") a
	LEFT JOIN(
		SELECT
		COUNT(*) AS female,
		1 AS id
		FROM
		tblchild c
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = c.HHGUID
		WHERE
		c.IsDeleted = 0  AND h.IsDeleted = 0  AND c.Gender = 1 AND TIMESTAMPDIFF(
			MONTH,
			c.child_dob,
			CURRENT_TIMESTAMP
		) >= 11 AND c.dpt3 IS NOT NULL";
			if ($this->date_filter != NULL)
		{
			$query .= " and c.dpt3 > '" . $this->date_filter['date_from'] . "' and c.dpt3 < '" . $this->date_filter['date_to'] . "'";
		}
	$query .= ") b
	ON
	a.id = b.id";

	return $this->db->query($query)->row();
}


public function children_age_greater_then_11_Pentavalent_1()
{
	$query = "select
	a.male,
	b.female,
	a.male+b.female as total
	FROM
	(
		SELECT
		COUNT(*) AS male,
		1 AS id
		FROM
		tblchild c
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = c.HHGUID
		WHERE
		c.IsDeleted = 0  AND h.IsDeleted = 0  AND c.Gender = 2 AND TIMESTAMPDIFF(
			MONTH,
			c.child_dob,
			CURRENT_TIMESTAMP
		) >= 11 AND c.Pentavalent1 IS NOT NULL ";
			if ($this->date_filter != NULL)
		{
			$query .= " and c.Pentavalent1 > '" . $this->date_filter['date_from'] . "' and c.Pentavalent1 < '" . $this->date_filter['date_to'] . "'";
		}
	$query .= ") a
	LEFT JOIN(
		SELECT
		COUNT(*) AS female,
		1 AS id
		FROM
		tblchild c
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = c.HHGUID
		WHERE
		c.IsDeleted = 0  AND h.IsDeleted = 0  AND c.Gender = 1 AND TIMESTAMPDIFF(
			MONTH,
			c.child_dob,
			CURRENT_TIMESTAMP
		) >= 11 AND c.Pentavalent1 IS NOT NULL";
			if ($this->date_filter != NULL)
		{
			$query .= " and c.Pentavalent1 > '" . $this->date_filter['date_from'] . "' and c.Pentavalent1 < '" . $this->date_filter['date_to'] . "'";
		}
	$query .=") b
	ON
	a.id = b.id";

	return $this->db->query($query)->row();
}



public function children_age_greater_then_11_Pentavalent_2()
{
	$query = "select
	a.male,
	b.female,
	a.male+b.female as total
	FROM
	(
		SELECT
		COUNT(*) AS male,
		1 AS id
		FROM
		tblchild c
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = c.HHGUID
		WHERE
		c.IsDeleted = 0  AND h.IsDeleted = 0  AND c.Gender = 2 AND TIMESTAMPDIFF(
			MONTH,
			c.child_dob,
			CURRENT_TIMESTAMP
		) >= 11 AND c.Pentavalent2 IS NOT NULL";
			if ($this->date_filter != NULL)
		{
			$query .= " and c.Pentavalent2 > '" . $this->date_filter['date_from'] . "' and c.Pentavalent2 < '" . $this->date_filter['date_to'] . "'";
		}
	$query .=") a
	LEFT JOIN(
		SELECT
		COUNT(*) AS female,
		1 AS id
		FROM
		tblchild c
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = c.HHGUID
		WHERE
		c.IsDeleted = 0  AND h.IsDeleted = 0  AND c.Gender = 1 AND TIMESTAMPDIFF(
			MONTH,
			c.child_dob,
			CURRENT_TIMESTAMP
		) >= 11 AND c.Pentavalent2 IS NOT NULL";
			if ($this->date_filter != NULL)
		{
			$query .= " and c.Pentavalent2 > '" . $this->date_filter['date_from'] . "' and c.Pentavalent2 < '" . $this->date_filter['date_to'] . "'";
		}
	$query .=") b
	ON
	a.id = b.id";

	return $this->db->query($query)->row();
}

public function children_age_greater_then_11_Pentavalent_3()
{
	$query = "select
	a.male,
	b.female,
	a.male+b.female as total
	FROM
	(
		SELECT
		COUNT(*) AS male,
		1 AS id
		FROM
		tblchild c
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = c.HHGUID
		WHERE
		c.IsDeleted = 0  AND h.IsDeleted = 0  AND c.Gender = 2 AND TIMESTAMPDIFF(
			MONTH,
			c.child_dob,
			CURRENT_TIMESTAMP
		) >= 11 AND c.Pentavalent3 IS NOT NULL";
			if ($this->date_filter != NULL)
		{
			$query .= " and c.Pentavalent3 > '" . $this->date_filter['date_from'] . "' and c.Pentavalent3 < '" . $this->date_filter['date_to'] . "'";
		}
	$query .= ") a
	LEFT JOIN(
		SELECT
		COUNT(*) AS female,
		1 AS id
		FROM
		tblchild c
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = c.HHGUID
		WHERE
		c.IsDeleted = 0  AND h.IsDeleted = 0  AND c.Gender = 1 AND TIMESTAMPDIFF(
			MONTH,
			c.child_dob,
			CURRENT_TIMESTAMP
		) >= 11 AND c.Pentavalent3 IS NOT NULL ";
			if ($this->date_filter != NULL)
		{
			$query .= " and c.Pentavalent3 > '" . $this->date_filter['date_from'] . "' and c.Pentavalent3 < '" . $this->date_filter['date_to'] . "'";
		}
	$query .= ") b
	ON
	a.id = b.id";

	return $this->db->query($query)->row();
}



public function children_age_greater_then_11_OPV_1()
{
	$query = "select
	a.male,
	b.female,
	a.male+b.female as total
	FROM
	(
		SELECT
		COUNT(*) AS male,
		1 AS id
		FROM
		tblchild c
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = c.HHGUID
		WHERE
		c.IsDeleted = 0  AND h.IsDeleted = 0  AND c.Gender = 2 AND TIMESTAMPDIFF(
			MONTH,
			c.child_dob,
			CURRENT_TIMESTAMP
		) >= 11 AND c.opv1 IS NOT NULL";
			if ($this->date_filter != NULL)
		{
			$query .= " and c.opv1 > '" . $this->date_filter['date_from'] . "' and c.opv1 < '" . $this->date_filter['date_to'] . "'";
		}
	$query .=") a
	LEFT JOIN(
		SELECT
		COUNT(*) AS female,
		1 AS id
		FROM
		tblchild c
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = c.HHGUID
		WHERE
		c.IsDeleted = 0  AND h.IsDeleted = 0  AND c.Gender = 1 AND TIMESTAMPDIFF(
			MONTH,
			c.child_dob,
			CURRENT_TIMESTAMP
		) >= 11 AND c.opv1 IS NOT NULL";
			if ($this->date_filter != NULL)
		{
		$query .= " and c.opv1 > '" . $this->date_filter['date_from'] . "' and c.opv1 < '" . $this->date_filter['date_to'] . "'";
		}
	$query .=") b
	ON
	a.id = b.id";

	return $this->db->query($query)->row();
}


public function children_age_greater_then_11_OPV_2()
{
	$query = "select
	a.male,
	b.female,
	a.male+b.female as total
	FROM
	(
		SELECT
		COUNT(*) AS male,
		1 AS id
		FROM
		tblchild c
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = c.HHGUID
		WHERE
		c.IsDeleted = 0  AND h.IsDeleted = 0  AND c.Gender = 2 AND TIMESTAMPDIFF(
			MONTH,
			c.child_dob,
			CURRENT_TIMESTAMP
		) >= 11 AND c.opv2 IS NOT NULL";
			if ($this->date_filter != NULL)
		{
			$query .= " and c.opv2 > '" . $this->date_filter['date_from'] . "' and c.opv2 < '" . $this->date_filter['date_to'] . "'";
		}
	$query .=") a
	LEFT JOIN(
		SELECT
		COUNT(*) AS female,
		1 AS id
		FROM
		tblchild c
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = c.HHGUID
		WHERE
		c.IsDeleted = 0  AND h.IsDeleted = 0  AND c.Gender = 1 AND TIMESTAMPDIFF(
			MONTH,
			c.child_dob,
			CURRENT_TIMESTAMP
		) >= 11 AND c.opv2 IS NOT NULL";
			if ($this->date_filter != NULL)
		{
			$query .= " and c.opv2 > '" . $this->date_filter['date_from'] . "' and c.opv2 < '" . $this->date_filter['date_to'] . "'";
		}
	$query.=") b
	ON
	a.id = b.id";

	return $this->db->query($query)->row();
}


public function children_age_greater_then_11_OPV_3()
{
	$query = "select
	a.male,
	b.female,
	a.male+b.female as total
	FROM
	(
		SELECT
		COUNT(*) AS male,
		1 AS id
		FROM
		tblchild c
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = c.HHGUID
		WHERE
		c.IsDeleted = 0  AND h.IsDeleted = 0  AND c.Gender = 2 AND TIMESTAMPDIFF(
			MONTH,
			c.child_dob,
			CURRENT_TIMESTAMP
		) >= 11 AND c.opv3 IS NOT NULL";
			if ($this->date_filter != NULL)
		{
			$query .= " and c.opv3 > '" . $this->date_filter['date_from'] . "' and c.opv3 < '" . $this->date_filter['date_to'] . "'";
		}
	$query .=") a
	LEFT JOIN(
		SELECT
		COUNT(*) AS female,
		1 AS id
		FROM
		tblchild c
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = c.HHGUID
		WHERE
		c.IsDeleted = 0  AND h.IsDeleted = 0  AND c.Gender = 1 AND TIMESTAMPDIFF(
			MONTH,
			c.child_dob,
			CURRENT_TIMESTAMP
		) >= 11 AND c.opv3 IS NOT NULL";
			if ($this->date_filter != NULL)
		{
			$query .= " and c.opv3 > '" . $this->date_filter['date_from'] . "' and c.opv3 < '" . $this->date_filter['date_to'] . "'";
		}
	$query .=") b
	ON
	a.id = b.id";

	return $this->db->query($query)->row();
}



public function children_age_greater_then_11_OPV_4()
{
	$query = "select
	a.male,
	b.female,
	a.male+b.female as total
	FROM
	(
		SELECT
		COUNT(*) AS male,
		1 AS id
		FROM
		tblchild c
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = c.HHGUID
		WHERE
		c.IsDeleted = 0  AND h.IsDeleted = 0  AND c.Gender = 2 AND TIMESTAMPDIFF(
			MONTH,
			c.child_dob,
			CURRENT_TIMESTAMP
		) >= 11 AND c.opv4 IS NOT NULL";
			if ($this->date_filter != NULL)
		{
			$query .= " and c.opv4 > '" . $this->date_filter['date_from'] . "' and c.opv4 < '" . $this->date_filter['date_to'] . "'";
		}
	$query .=") a
	LEFT JOIN(
		SELECT
		COUNT(*) AS female,
		1 AS id
		FROM
		tblchild c
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = c.HHGUID
		WHERE
		c.IsDeleted = 0  AND h.IsDeleted = 0  AND c.Gender = 1 AND TIMESTAMPDIFF(
			MONTH,
			c.child_dob,
			CURRENT_TIMESTAMP
		) >= 11 AND c.opv4 IS NOT NULL ";
			if ($this->date_filter != NULL)
		{
			$query .= " and c.opv4 > '" . $this->date_filter['date_from'] . "' and c.opv4 < '" . $this->date_filter['date_to'] . "'";
		}
	$query .=") b
	ON
	a.id = b.id";

	return $this->db->query($query)->row();
}



public function children_age_greater_then_11_Hepatitis_1()
{
	$query = "select
	a.male,
	b.female,
	a.male+b.female as total
	FROM
	(
		SELECT
		COUNT(*) AS male,
		1 AS id
		FROM
		tblchild c
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = c.HHGUID
		WHERE
		c.IsDeleted = 0  AND h.IsDeleted = 0  AND c.Gender = 2 AND TIMESTAMPDIFF(
			MONTH,
			c.child_dob,
			CURRENT_TIMESTAMP
		) >= 11 AND c.hepb1 IS NOT NULL";
			if ($this->date_filter != NULL)
		{
			$query .= " and c.hepb1 > '" . $this->date_filter['date_from'] . "' and c.hepb1 < '" . $this->date_filter['date_to'] . "'";
		}
	$query .= ") a
	LEFT JOIN(
		SELECT
		COUNT(*) AS female,
		1 AS id
		FROM
		tblchild c
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = c.HHGUID
		WHERE
		c.IsDeleted = 0  AND h.IsDeleted = 0  AND c.Gender = 1 AND TIMESTAMPDIFF(
			MONTH,
			c.child_dob,
			CURRENT_TIMESTAMP
		) >= 11 AND c.hepb1 IS NOT NULL";
			if ($this->date_filter != NULL)
		{
			$query .= " and c.hepb1 > '" . $this->date_filter['date_from'] . "' and c.hepb1 < '" . $this->date_filter['date_to'] . "'";
		}
	$query .= ") b
	ON
	a.id = b.id";

	return $this->db->query($query)->row();
}

public function children_age_greater_then_11_Hepatitis_2()
{
	$query = "select
	a.male,
	b.female,
	a.male+b.female as total
	FROM
	(
		SELECT
		COUNT(*) AS male,
		1 AS id
		FROM
		tblchild c
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = c.HHGUID
		WHERE
		c.IsDeleted = 0  AND h.IsDeleted = 0  AND c.Gender = 2 AND TIMESTAMPDIFF(
			MONTH,
			c.child_dob,
			CURRENT_TIMESTAMP
		) >= 11 AND c.hepb2 IS NOT NULL";
			if ($this->date_filter != NULL)
		{
			$query .= " and c.hepb2 > '" . $this->date_filter['date_from'] . "' and c.hepb2 < '" . $this->date_filter['date_to'] . "'";
		}
	$query .=") a
	LEFT JOIN(
		SELECT
		COUNT(*) AS female,
		1 AS id
		FROM
		tblchild c
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = c.HHGUID
		WHERE
		c.IsDeleted = 0  AND h.IsDeleted = 0  AND c.Gender = 1 AND TIMESTAMPDIFF(
			MONTH,
			c.child_dob,
			CURRENT_TIMESTAMP
		) >= 11 AND c.hepb2 IS NOT NULL";
			if ($this->date_filter != NULL)
		{
			$query .= " and c.hepb2 > '" . $this->date_filter['date_from'] . "' and c.hepb2 < '" . $this->date_filter['date_to'] . "'";
		}
	$query .= ") b
	ON
	a.id = b.id";

	return $this->db->query($query)->row();
}


public function children_age_greater_then_11_Hepatitis_3()
{
	$query = "select
	a.male,
	b.female,
	a.male+b.female as total
	FROM
	(
		SELECT
		COUNT(*) AS male,
		1 AS id
		FROM
		tblchild c
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = c.HHGUID
		WHERE
		c.IsDeleted = 0 AND h.IsDeleted = 0  AND c.Gender = 2 AND TIMESTAMPDIFF(
			MONTH,
			c.child_dob,
			CURRENT_TIMESTAMP
		) >= 11 AND c.hepb3 IS NOT NULL"; 
			if ($this->date_filter != NULL)
		{
			$query .= " and c.hepb3 > '" . $this->date_filter['date_from'] . "' and c.hepb3 < '" . $this->date_filter['date_to'] . "'";
		}
	$query .= ") a
	LEFT JOIN(
		SELECT
		COUNT(*) AS female,
		1 AS id
		FROM
		tblchild c
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = c.HHGUID
		WHERE
		c.IsDeleted = 0  AND h.IsDeleted = 0  AND c.Gender = 1 AND TIMESTAMPDIFF(
			MONTH,
			c.child_dob,
			CURRENT_TIMESTAMP
		) >= 11 AND c.hepb3 IS NOT NULL";
			if ($this->date_filter != NULL)
		{
			$query .= " and c.hepb3 > '" . $this->date_filter['date_from'] . "' and c.hepb3 < '" . $this->date_filter['date_to'] . "'";
		}
	$query .=") b
	ON
	a.id = b.id";

	return $this->db->query($query)->row();
}


public function children_age_greater_then_11_Hepatitis_4()
{
	$query = "select
	a.male,
	b.female,
	a.male+b.female as total
	FROM
	(
		SELECT
		COUNT(*) AS male,
		1 AS id
		FROM
		tblchild c
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = c.HHGUID
		WHERE
		c.IsDeleted = 0  AND h.IsDeleted = 0  AND c.Gender = 2 AND TIMESTAMPDIFF(
			MONTH,
			c.child_dob,
			CURRENT_TIMESTAMP
		) >= 11 AND c.hepb4 IS NOT NULL";
			if ($this->date_filter != NULL)
		{
			$query .= " and c.hepb4 > '" . $this->date_filter['date_from'] . "' and c.hepb4 < '" . $this->date_filter['date_to'] . "'";
		}
	$query .=") a
	LEFT JOIN(
		SELECT
		COUNT(*) AS female,
		1 AS id
		FROM
		tblchild c
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = c.HHGUID
		WHERE
		c.IsDeleted = 0  AND h.IsDeleted = 0  AND c.Gender = 1 AND TIMESTAMPDIFF(
			MONTH,
			c.child_dob,
			CURRENT_TIMESTAMP
		) >= 11 AND c.hepb4 IS NOT NULL";
			if ($this->date_filter != NULL)
		{
			$query .= " and c.hepb4 > '" . $this->date_filter['date_from'] . "' and c.hepb4 < '" . $this->date_filter['date_to'] . "'";
		}
	$query .= ") b
	ON
	a.id = b.id";

	return $this->db->query($query)->row();
}



public function children_age_greater_then_11_Measles()
{
	$query = "select
	a.male,
	b.female,
	a.male+b.female as total
	FROM
	(
		SELECT
		COUNT(*) AS male,
		1 AS id
		FROM
		tblchild c
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = c.HHGUID
		WHERE
		c.IsDeleted = 0  AND h.IsDeleted = 0  AND c.Gender = 2 AND TIMESTAMPDIFF(
			MONTH,
			c.child_dob,
			CURRENT_TIMESTAMP
		) >= 11 AND c.measeals IS NOT NULL";
			if ($this->date_filter != NULL)
		{
			$query .= " and c.measeals > '" . $this->date_filter['date_from'] . "' and c.measeals < '" . $this->date_filter['date_to'] . "'";
		}
	$query .= ") a
	LEFT JOIN(
		SELECT
		COUNT(*) AS female,
		1 AS id
		FROM
		tblchild c
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = c.HHGUID
		WHERE
		c.IsDeleted = 0  AND h.IsDeleted = 0 AND c.Gender = 1 AND TIMESTAMPDIFF(
			MONTH,
			c.child_dob,
			CURRENT_TIMESTAMP
		) >= 11 AND c.measeals IS NOT NULL";
			if ($this->date_filter != NULL)
		{
			$query .= " and c.measeals > '" . $this->date_filter['date_from'] . "' and c.measeals < '" . $this->date_filter['date_to'] . "'";
		}
	$query .= ") b
	ON
	a.id = b.id";

	return $this->db->query($query)->row();
}


public function children_age_between_9_and_11_fully_immunized()
{
	$query = "select
	a.male,
	b.female,
	a.male+b.female as total
	FROM
	(
		SELECT
		COUNT(*) AS male,
		1 AS id
		FROM
		tblchild c
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = c.HHGUID
		WHERE
		c.IsDeleted = 0  AND h.IsDeleted = 0  AND c.Gender = 2 AND TIMESTAMPDIFF(
			MONTH,
			c.child_dob,
			CURRENT_TIMESTAMP
		) > 9 AND TIMESTAMPDIFF(
			MONTH,
			c.child_dob,
			CURRENT_TIMESTAMP
		) <= 11 AND (c.measeals IS NOT NULL or c.MeaslesRubella is not Null) AND c.bcg IS NOT NULL AND (c.dpt1 IS NOT NULL or  c.Pentavalent1 IS NOT NULL ) and (c.dpt2 IS NOT NULL or c.Pentavalent2 IS NOT NULL) AND (c.dpt3 IS NOT NULL or c.Pentavalent3 IS NOT NULL ) AND c.opv2 IS NOT NULL AND c.opv3 IS NOT NULL AND c.opv4 IS NOT NULL";
			if ($this->date_filter != NULL)
		{
			$query .= " and c.child_dob > '" . $this->date_filter['date_from'] . "' and c.child_dob < '" . $this->date_filter['date_to'] . "'";
		}
	$query .= " ) a
	LEFT JOIN(
		SELECT
		COUNT(*) AS female,
		1 AS id
		FROM
		tblchild c
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = c.HHGUID
		WHERE
		c.IsDeleted = 0  AND h.IsDeleted = 0  AND c.Gender = 1 AND TIMESTAMPDIFF(
			MONTH,
			c.child_dob,
			CURRENT_TIMESTAMP
		) > 9 AND TIMESTAMPDIFF(
			MONTH,
			c.child_dob,
			CURRENT_TIMESTAMP
		) <= 11 AND (c.measeals IS NOT NULL or c.MeaslesRubella is not Null) AND c.bcg IS NOT NULL AND (c.dpt1 IS NOT NULL or  c.Pentavalent1 IS NOT NULL ) and (c.dpt2 IS NOT NULL or c.Pentavalent2 IS NOT NULL) AND (c.dpt3 IS NOT NULL or c.Pentavalent3 IS NOT NULL ) AND c.opv1 IS NOT NULL AND c.opv2 IS NOT NULL AND c.opv3 IS NOT NULL AND c.opv4 IS NOT NULL";
			if ($this->date_filter != NULL)
		{
			$query .= " and c.child_dob > '" . $this->date_filter['date_from'] . "' and c.child_dob < '" . $this->date_filter['date_to'] . "'";
		}
	$query .= ") b
	ON
	a.id = b.id";
	// print_r($query); die();
	return $this->db->query($query)->row();
}


public function children_age_more_then_16_received_DPT_Booster()
{
	$query = "select
	a.male,
	b.female,
	a.male+b.female as total
	FROM
	(
		SELECT
		COUNT(*) AS male,
		1 AS id
		FROM
		tblchild c
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = c.HHGUID
		WHERE
		c.IsDeleted = 0  AND h.IsDeleted = 0  AND c.Gender = 2 AND TIMESTAMPDIFF(
			MONTH,
			c.child_dob,
			CURRENT_TIMESTAMP
		) > 16 AND  c.DPTBooster is not null";
			if ($this->date_filter != NULL)
		{
			$query .= " and c.DPTBooster > '" . $this->date_filter['date_from'] . "' and c.DPTBooster < '" . $this->date_filter['date_to'] . "'";
		}
	$query .=" ) a
	LEFT JOIN(
		SELECT
		COUNT(*) AS female,
		1 AS id
		FROM
		tblchild c
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = c.HHGUID
		WHERE
		c.IsDeleted = 0  AND h.IsDeleted = 0  AND c.Gender = 1 AND TIMESTAMPDIFF(
			MONTH,
			c.child_dob,
			CURRENT_TIMESTAMP
		) > 16 AND c.DPTBooster is not null";
			if ($this->date_filter != NULL)
		{
			$query .= " and c.DPTBooster > '" . $this->date_filter['date_from'] . "' and c.DPTBooster < '" . $this->date_filter['date_to'] . "'";
		}
	$query .=") b
	ON
	a.id = b.id";

	return $this->db->query($query)->row();
}


public function children_age_more_then_16_received_OPV_Booster()
{
	$query = "select
	a.male,
	b.female,
	a.male+b.female as total
	FROM
	(
		SELECT
		COUNT(*) AS male,
		1 AS id
		FROM
		tblchild c
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = c.HHGUID
		WHERE
		c.IsDeleted = 0  AND h.IsDeleted = 0 AND c.Gender = 2 AND TIMESTAMPDIFF(
			MONTH,
			c.child_dob,
			CURRENT_TIMESTAMP
		) > 16 AND c.OPVBooster IS NOT NULL ";
			if ($this->date_filter != NULL)
		{
			$query .= " and c.OPVBooster > '" . $this->date_filter['date_from'] . "' and c.OPVBooster < '" . $this->date_filter['date_to'] . "'";
		}
	$query .=") a
	LEFT JOIN(
		SELECT
		COUNT(*) AS female,
		1 AS id
		FROM
		tblchild c
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = c.HHGUID
		WHERE
		c.IsDeleted = 0  AND h.IsDeleted = 0  AND c.Gender = 1 AND TIMESTAMPDIFF(
			MONTH,
			c.child_dob,
			CURRENT_TIMESTAMP
		) > 16 AND c.OPVBooster IS NOT NULL";
			if ($this->date_filter != NULL)
		{
			$query .= " and c.OPVBooster > '" . $this->date_filter['date_from'] . "' and c.OPVBooster < '" . $this->date_filter['date_to'] . "'";
		}
	$query .=") b
	ON
	a.id = b.id";

	return $this->db->query($query)->row();
}


public function children_age_more_then_16_received_Measles_Rubella()
{
	$query = "select
	a.male,
	b.female,
	a.male+b.female as total
	FROM
	(
		SELECT
		COUNT(*) AS male,
		1 AS id
		FROM
		tblchild c
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = c.HHGUID
		WHERE
		c.IsDeleted = 0  AND h.IsDeleted = 0  AND c.Gender = 2 AND TIMESTAMPDIFF(
			MONTH,
			c.child_dob,
			CURRENT_TIMESTAMP
		) > 16 AND c.MeaslesRubella IS NOT NULL";
			if ($this->date_filter != NULL)
		{
			$query .= " and c.MeaslesRubella > '" . $this->date_filter['date_from'] . "' and c.MeaslesRubella < '" . $this->date_filter['date_to'] . "'";
		}
	$query .=") a
	LEFT JOIN(
		SELECT
		COUNT(*) AS female,
		1 AS id
		FROM
		tblchild c
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = c.HHGUID
		WHERE
		c.IsDeleted = 0  AND h.IsDeleted = 0  AND c.Gender = 1 AND TIMESTAMPDIFF(
			MONTH,
			c.child_dob,
			CURRENT_TIMESTAMP
		) > 16 AND c.MeaslesRubella IS NOT NULL";
			if ($this->date_filter != NULL)
		{
			$query .= " and c.MeaslesRubella > '" . $this->date_filter['date_from'] . "' and c.MeaslesRubella < '" . $this->date_filter['date_to'] . "'";
		}
	$query .=") b
	ON
	a.id = b.id";

	return $this->db->query($query)->row();
}


public function children_age_between_12_and_23_months_fully_immunized()
{
	$query = "select
	a.male,
	b.female,
	a.male+b.female as total
	FROM
	(
		SELECT
		COUNT(*) AS male,
		1 AS id
		FROM
		tblchild c
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = c.HHGUID
		WHERE
		c.IsDeleted = 0  AND h.IsDeleted = 0 AND c.Gender = 2 AND TIMESTAMPDIFF(
			MONTH,
			c.child_dob,
			CURRENT_TIMESTAMP
		) > 12 AND TIMESTAMPDIFF(
			MONTH,
			c.child_dob,
			CURRENT_TIMESTAMP
		) <= 23 AND (c.measeals IS NOT NULL or c.MeaslesRubella is not Null) AND c.bcg IS NOT NULL AND (c.dpt1 IS NOT NULL or  c.Pentavalent1 IS NOT NULL ) and (c.dpt2 IS NOT NULL or c.Pentavalent2 IS NOT NULL) AND (c.dpt3 IS NOT NULL or c.Pentavalent3 IS NOT NULL ) AND c.opv2 IS NOT NULL AND c.opv3 IS NOT NULL AND c.opv4 IS NOT NULL";
			if ($this->date_filter != NULL)
		{
			$query .= " and c.child_dob > '" . $this->date_filter['date_from'] . "' and c.child_dob < '" . $this->date_filter['date_to'] . "'";
		}
	$query .=") a
	LEFT JOIN(
		SELECT
		COUNT(*) AS female,
		1 AS id
		FROM
		tblchild c
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = c.HHGUID
		WHERE
		c.IsDeleted = 0  AND h.IsDeleted = 0  AND c.Gender = 1 AND TIMESTAMPDIFF(
			MONTH,
			c.child_dob,
			CURRENT_TIMESTAMP
		) > 12 AND TIMESTAMPDIFF(
			MONTH,
			c.child_dob,
			CURRENT_TIMESTAMP
		) <= 23 AND (c.measeals IS NOT NULL or c.MeaslesRubella is not Null) AND c.bcg IS NOT NULL AND (c.dpt1 IS NOT NULL or  c.Pentavalent1 IS NOT NULL ) and (c.dpt2 IS NOT NULL or c.Pentavalent2 IS NOT NULL) AND (c.dpt3 IS NOT NULL or c.Pentavalent3 IS NOT NULL ) AND c.opv1 IS NOT NULL AND c.opv2 IS NOT NULL AND c.opv3 IS NOT NULL AND c.opv4 IS NOT NULL";
			if ($this->date_filter != NULL)
		{
			$query .= " and c.child_dob > '" . $this->date_filter['date_from'] . "' and c.child_dob < '" . $this->date_filter['date_to'] . "'";
		}
	$query .= ") b
	ON
	a.id = b.id";
	return $this->db->query($query)->row();
}


}