<?php  

class Monthly_asha_report_seven_model extends Ci_model 
{
	public function __construct()
	{

	}

	public function get_report()
	{
		$ASHAID = $this->input->post('ashaid');

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
	a.IsPregnant = 0 AND a.IsDeleted = 0 AND b.IsDeleted = 0 AND c.LanguageID = 1 AND c.IsDeleted = 0 AND d.IsDeleted = 0 AND e.LanguageID = 1 AND e.IsDeleted = 0 AND g.is_deleted = 0 AND g.is_active = 1 AND h.IsDeleted = 0 AND 
        a.LMPDate > '".$this->input->post('date_from')."' and a.LMPDate < '".$this->input->post('date_to')."' and a.AshaID = ?
	GROUP BY
	d.PWGUID";

	$content['preg_details'] = $this->db->query($query, [$ASHAID])->result();

	return $content;
	}
}