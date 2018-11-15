<?php 

/**
* Dashboard4 model for process indicators
*/
class Hrp_model extends Ci_model
{
	
	public function __construct()
	{
		parent::__construct();
		$this->filter_data = $this->session->userdata('filter_data_list');
		// print_r($this->filter_data); die();
	}

	public function get_hrp_summary()
	{
		$content = array();

		/*	$content['past_illness_heart_disease'] = $this->past_illness_heart_disease();*/
		$content['two_or_more_than_two_abortions'] = $this->two_or_more_than_two_abortions();
		$content['still_birth'] = $this->still_birth();
		$content['neonatal_loss'] = $this->neonatal_loss();
		$content['obstructed_labour'] = $this->obstructed_labour();
		$content['ante_partum_haemorrhage'] = $this->ante_partum_haemorrhage();
		$content['excessive_bleeding_after_delivery'] = $this->excessive_bleeding_after_delivery();
		$content['weight_of_the_previous_baby_greater_than_4500g'] = $this->weight_of_the_previous_baby_greater_than_4500g();
		$content['caesarean_section'] = $this->caesarean_section();
		$content['congenital_anomaly'] = $this->congenital_anomaly();
		$content['high_blood_pressure_hypertension'] = $this->high_blood_pressure_hypertension();
		$content['diabetes'] = $this->diabetes();
		$content['breathlessness_on_exertion_palpitations_heart_disease'] = $this->breathlessness_on_exertion_palpitations_heart_disease();
		$content['chronic_cough_blood_in_the_sputum_prolonged_fever_tuberculosis'] = $this->chronic_cough_blood_in_the_sputum_prolonged_fever_tuberculosis();
		$content['convulsions_epilepsy'] = $this->convulsions_epilepsy();
		$content['severe_anaemia_hb_less_than_7gm_percent'] = $this->severe_anaemia_hb_less_than_7gm_percent();
		$content['blood_pressure_equal_to_or_more_than_140mmHg_S_and_or_equal_to_or_more_than_90_mmHg_D'] = $this->blood_pressure_equal_to_or_more_than_140mmHg_S_and_or_equal_to_or_more_than_90_mmHg_D();
		$content['any_vaginal_bleeding'] = $this->any_vaginal_bleeding();
		$content['malpresentation_Breech_transverse_lie'] = $this->malpresentation_Breech_transverse_lie();
		$content['gestational_diabetes'] = $this->gestational_diabetes();
		$content['cephalopelvic_disproportion'] = $this->cephalopelvic_disproportion();
		$content['teenage_pregnancy_less_than_19_years'] = $this->teenage_pregnancy_less_than_19_years();
		$content['elderly_primigravida_greater_than_40_years'] = $this->elderly_primigravida_greater_than_40_years();
		$content['low_height_of_mother_less_than_145_cm'] = $this->low_height_of_mother_less_than_145_cm();
		$content['low_weight_of_mother_less_than_45_kg'] = $this->low_weight_of_mother_less_than_45_kg();
		$content['hiv_positive'] = $this->hiv_positive();
		$content['wr_positive'] = $this->wr_positive();

		$content['total_hrp_cases_metch_condition'] = $this->get_total_hrp_count_metch_conditions();
		$content['total_hrp_cases'] = $this->get_total_hrp_count();
		
		return $content;
	}

	private function two_or_more_than_two_abortions()
	{
		// $this->db->where("LastPregnancyResult=2 and LTLPregnancyResult=2");
		// $this->db->where('IsPregnant', 1);	
		// $this->db->where('IsDeleted', 0);	
		// $this->db->from('tblpregnant_woman');
		// return $this->db->count_all_results();

		$query = "SELECT
		count(*) as total
		FROM
		tblpregnant_woman pw
		INNER JOIN tblhhfamilymember fm ON
		pw.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = fm.HHSurveyGUID
		WHERE
		pw.IsPregnant = 1 AND pw.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0 AND pw.LastPregnancyResult = 2 AND pw.LTLPregnancyResult = 2";
		return $this->db->query($query)->result()[0]->total;
	}

	private function still_birth()
	{
		// $this->db->where("LastPregnancyResult=3");
		// $this->db->where('IsPregnant', 1);	
		// $this->db->where('IsDeleted', 0);
		// $this->db->from('tblpregnant_woman');
		// return $this->db->count_all_results();
		$query = "SELECT
		count(*) as total
		FROM
		tblpregnant_woman pw
		INNER JOIN tblhhfamilymember fm ON
		pw.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = fm.HHSurveyGUID
		WHERE
		pw.IsPregnant = 1 AND pw.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0 AND pw.LastPregnancyResult = 3";
		return $this->db->query($query)->result()[0]->total;
	}

	private function neonatal_loss()
	{
		// $this->db->where("LastPregnancyComplication=14");
		// $this->db->where('IsPregnant', 1);	
		// $this->db->where('IsDeleted', 0);
		// $this->db->from('tblpregnant_woman');
		// return $this->db->count_all_results();

		$query = "SELECT
		count(*) as total
		FROM
		tblpregnant_woman pw
		INNER JOIN tblhhfamilymember fm ON
		pw.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = fm.HHSurveyGUID
		WHERE
		pw.IsPregnant = 1 AND pw.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0 AND pw.LastPregnancyComplication=14";
		return $this->db->query($query)->result()[0]->total;
	}

	private function obstructed_labour()
	{
		// $this->db->where("LastPregnancyComplication=11");
		// $this->db->where('IsPregnant', 1);	
		// $this->db->where('IsDeleted', 0);
		// $this->db->from('tblpregnant_woman');
		// return $this->db->count_all_results();

		$query = "SELECT
		count(*) as total
		FROM
		tblpregnant_woman pw
		INNER JOIN tblhhfamilymember fm ON
		pw.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = fm.HHSurveyGUID
		WHERE
		pw.IsPregnant = 1 AND pw.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0 AND pw.LastPregnancyComplication=11";
		return $this->db->query($query)->result()[0]->total;
	}

	private function ante_partum_haemorrhage()
	{
		// $this->db->where("LastPregnancyComplication=3");
		// $this->db->where('IsPregnant', 1);	
		// $this->db->where('IsDeleted', 0);
		// $this->db->from('tblpregnant_woman');
		// return $this->db->count_all_results();

		$query = "SELECT
		count(*) as total
		FROM
		tblpregnant_woman pw
		INNER JOIN tblhhfamilymember fm ON
		pw.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = fm.HHSurveyGUID
		WHERE
		pw.IsPregnant = 1 AND pw.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0 AND pw.LastPregnancyComplication=3";
		return $this->db->query($query)->result()[0]->total;
	}

	private function excessive_bleeding_after_delivery()
	{
		// $this->db->where("LastPregnancyComplication=12");
		// $this->db->where('IsPregnant', 1);	
		// $this->db->where('IsDeleted', 0);
		// $this->db->from('tblpregnant_woman');
		// return $this->db->count_all_results();

		$query = "SELECT
		count(*) as total
		FROM
		tblpregnant_woman pw
		INNER JOIN tblhhfamilymember fm ON
		pw.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = fm.HHSurveyGUID
		WHERE
		pw.IsPregnant = 1 AND pw.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0 AND pw.LastPregnancyComplication=12";
		return $this->db->query($query)->result()[0]->total;
	}

	private function weight_of_the_previous_baby_greater_than_4500g()
	{
		// $this->db->where("LastPregnancyComplication=15");
		// $this->db->where('IsPregnant', 1);	
		// $this->db->where('IsDeleted', 0);
		// $this->db->from('tblpregnant_woman');
		// return $this->db->count_all_results();

		$query = "SELECT
		count(*) as total
		FROM
		tblpregnant_woman pw
		INNER JOIN tblhhfamilymember fm ON
		pw.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = fm.HHSurveyGUID
		WHERE
		pw.IsPregnant = 1 AND pw.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0 AND pw.LastPregnancyComplication=15";
		return $this->db->query($query)->result()[0]->total;
	}

	private function caesarean_section()
	{
		// $this->db->where("LastPregnancyComplication=8");
		// $this->db->where('IsPregnant', 1);
		// $this->db->where('IsDeleted', 0);	
		// $this->db->from('tblpregnant_woman');
		// return $this->db->count_all_results();

		$query = "SELECT
		count(*) as total
		FROM
		tblpregnant_woman pw
		INNER JOIN tblhhfamilymember fm ON
		pw.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = fm.HHSurveyGUID
		WHERE
		pw.IsPregnant = 1 AND pw.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0 AND pw.LastPregnancyComplication=8";
		return $this->db->query($query)->result()[0]->total;
	}

	private function congenital_anomaly()
	{
		// $this->db->where("LastPregnancyComplication=7");
		// $this->db->where('IsPregnant', 1);	
		// $this->db->where('IsDeleted', 0);
		// $this->db->from('tblpregnant_woman');
		// return $this->db->count_all_results();

		$query = "SELECT
		count(*) as total
		FROM
		tblpregnant_woman pw
		INNER JOIN tblhhfamilymember fm ON
		pw.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = fm.HHSurveyGUID
		WHERE
		pw.IsPregnant = 1 AND pw.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0 AND pw.LastPregnancyComplication=7";
		return $this->db->query($query)->result()[0]->total;
	}

	private function high_blood_pressure_hypertension()
	{
		// $this->db->where("FIND_IN_SET('HYPERTENSION', PastIllnessYN) > 0");
		// $this->db->where('IsPregnant', 1);	
		// $this->db->where('IsDeleted', 0);
		// $this->db->from('tblpregnant_woman');
		// return $this->db->count_all_results();

		$query = "SELECT
		count(*) as total
		FROM
		tblpregnant_woman pw
		INNER JOIN tblhhfamilymember fm ON
		pw.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = fm.HHSurveyGUID
		WHERE
		pw.IsPregnant = 1 AND pw.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0 AND FIND_IN_SET('HYPERTENSION', pw.PastIllnessYN) > 0";
		return $this->db->query($query)->result()[0]->total;
	}


	private function diabetes()
	{
		// $this->db->where("FIND_IN_SET('DIABETES', PastIllnessYN) > 0");
		// $this->db->where('IsPregnant', 1);	
		// $this->db->where('IsDeleted', 0);
		// $this->db->from('tblpregnant_woman');
		// return $this->db->count_all_results();

		$query = "SELECT
		count(*) as total
		FROM
		tblpregnant_woman pw
		INNER JOIN tblhhfamilymember fm ON
		pw.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = fm.HHSurveyGUID
		WHERE
		pw.IsPregnant = 1 AND pw.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0 AND FIND_IN_SET('DIABETES', pw.PastIllnessYN) > 0";
		return $this->db->query($query)->result()[0]->total;
	}

	private function breathlessness_on_exertion_palpitations_heart_disease()
	{
		// $this->db->where("FIND_IN_SET('HEART DISEASE', PastIllnessYN) >0");
		// $this->db->where('IsPregnant', 1);
		// $this->db->where('IsDeleted', 0);	
		// $this->db->from('tblpregnant_woman');
		// return $this->db->count_all_results();

		$query = "SELECT
		count(*) as total
		FROM
		tblpregnant_woman pw
		INNER JOIN tblhhfamilymember fm ON
		pw.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = fm.HHSurveyGUID
		WHERE
		pw.IsPregnant = 1 AND pw.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0 AND FIND_IN_SET('HEART DISEASE', pw.PastIllnessYN) >0";
		return $this->db->query($query)->result()[0]->total;
	}

	private function chronic_cough_blood_in_the_sputum_prolonged_fever_tuberculosis()
	{
		// $this->db->where("FIND_IN_SET('TB', PastIllnessYN) > 0");
		// $this->db->where('IsPregnant', 1);	
		// $this->db->where('IsDeleted', 0);
		// $this->db->from('tblpregnant_woman');
		// return $this->db->count_all_results();

		$query = "SELECT
		count(*) as total
		FROM
		tblpregnant_woman pw
		INNER JOIN tblhhfamilymember fm ON
		pw.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = fm.HHSurveyGUID
		WHERE
		pw.IsPregnant = 1 AND pw.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0 AND FIND_IN_SET('TB', pw.PastIllnessYN) >0";
		return $this->db->query($query)->result()[0]->total;
	}

	private function convulsions_epilepsy()
	{
		// $this->db->where("FIND_IN_SET('EPILEPTICCONVULSIONS', PastIllnessYN) > 0");
		// $this->db->where('IsPregnant', 1);	
		// $this->db->where('IsDeleted', 0);
		// $this->db->from('tblpregnant_woman');
		// return $this->db->count_all_results();

		$query = "SELECT
		count(*) as total
		FROM
		tblpregnant_woman pw
		INNER JOIN tblhhfamilymember fm ON
		pw.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
		INNER JOIN tblhhsurvey h ON
		h.HHSurveyGUID = fm.HHSurveyGUID
		WHERE
		pw.IsPregnant = 1 AND pw.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0 AND FIND_IN_SET('EPILEPTICCONVULSIONS', pw.PastIllnessYN) >0";
		return $this->db->query($query)->result()[0]->total;

	}

	private function severe_anaemia_hb_less_than_7gm_percent()
	{
		// $query = "select count(*) as total 
		// from tblpregnant_woman a 
		// inner join 
		// (SELECT PWGUID FROM tblancvisit WHERE DangerSign = 1 group by PWGUID)b 
		// on a.PWGUID = b.PWGUID
		// where a.IsPregnant = 1 and a.IsDeleted = 0 ";

		$query = "SELECT
		COUNT(*) AS total
		FROM
		(
		SELECT
        *
		FROM
		(
		SELECT
		MAX(CheckupVisitDate) AS CheckupVisitDate,
		PWGUID,
		VisitGUID,
		DangerSign
		FROM
		tblancvisit
		WHERE
		DangerSign IS NOT NULL
		GROUP BY
		PWGUID
		) a
		WHERE
		DangerSign = 1
	) a
	INNER JOIN tblpregnant_woman b ON
	a.PWGUID = b.PWGUID
	INNER JOIN tblhhfamilymember c ON
	c.HHFamilyMemberGUID = b.HHFamilyMemberGUID
	INNER JOIN tblhhsurvey d ON
	d.HHSurveyGUID = c.HHSurveyGUID
	WHERE
	b.IsPregnant = 1 AND b.IsDeleted = 0 AND c.StatusID = 1 AND c.IsDeleted = 0 AND d.IsDeleted = 0 AND b.PWGUID IS NOT NULL";

	return $this->db->query($query)->result()[0]->total;
}

private function blood_pressure_equal_to_or_more_than_140mmHg_S_and_or_equal_to_or_more_than_90_mmHg_D()
{
		// $query = "select count(a.PWGUID) as total from tblpregnant_woman a 
		// inner join (
		// 	select * from (SELECT BPResult, PWGUID, SUBSTRING_INDEX(BPResult,',',1) as systolic, reverse(substring_index(reverse(BPResult),',', 1)) as diastolic from tblancvisit v where BPResult is not null and BPResult != '') a where a.systolic >= 140 or a.diastolic >= 90 group by PWGUID
		// )b 
		// on a.PWGUID = b.PWGUID
		// where a.IsPregnant = 1 and a.IsDeleted = 0";

	$query = "SELECT
	COUNT(*) AS total
	FROM
	(
	SELECT
        *
	FROM
	(
	SELECT
	MAX(CheckupVisitDate) AS CheckupVisitDate,
	BPResult,
	PWGUID,
	SUBSTRING_INDEX(BPResult, ',', 1) AS systolic,
	REVERSE(
	SUBSTRING_INDEX(REVERSE(BPResult),
	',',
	1)
	) AS diastolic
	FROM
	tblancvisit
	WHERE
	BPResult IS NOT NULL AND BPResult != '' AND SUBSTRING_INDEX(BPResult, ',', 1) != 0 AND REVERSE(
	SUBSTRING_INDEX(REVERSE(BPResult),
	',',
	1)
	) != 0
	GROUP BY
	PWGUID
	) a
	WHERE
	systolic >= 140 OR diastolic >= 90
) a
INNER JOIN tblpregnant_woman b ON
a.PWGUID = b.PWGUID
INNER JOIN tblhhfamilymember c ON
c.HHFamilyMemberGUID = b.HHFamilyMemberGUID
INNER JOIN tblhhsurvey d ON
d.HHSurveyGUID = c.HHSurveyGUID
WHERE
b.IsPregnant = 1 AND b.IsDeleted = 0 AND c.StatusID = 1 AND c.IsDeleted = 0 AND d.IsDeleted = 0 AND b.PWGUID IS NOT NULL";
return	$this->db->query($query)->result()[0]->total;

}

private function any_vaginal_bleeding()
{
		// $query = "select count(*) as total 
		// from tblpregnant_woman a 
		// inner join 
		// (SELECT PWGUID FROM tblancvisit WHERE DangerSign = 2 group by PWGUID)b 
		// on a.PWGUID = b.PWGUID
		// where a.IsPregnant = 1 and a.IsDeleted = 0";
	$query = "SELECT
	COUNT(*) AS total
	FROM
	(
	SELECT
        *
	FROM
	(
	SELECT
	MAX(CheckupVisitDate) AS CheckupVisitDate,
	PWGUID,
	VisitGUID,
	DangerSign
	FROM
	tblancvisit
	WHERE
	DangerSign IS NOT NULL
	GROUP BY
	PWGUID
	) a
	WHERE
	DangerSign = 2
) a
INNER JOIN tblpregnant_woman b ON
a.PWGUID = b.PWGUID
INNER JOIN tblhhfamilymember c ON
c.HHFamilyMemberGUID = b.HHFamilyMemberGUID
INNER JOIN tblhhsurvey d ON
d.HHSurveyGUID = c.HHSurveyGUID
WHERE
b.IsPregnant = 1 AND b.IsDeleted = 0 AND c.StatusID = 1 AND c.IsDeleted = 0 AND d.IsDeleted = 0 AND b.PWGUID IS NOT NULL";

return $this->db->query($query)->result()[0]->total;
}

private function malpresentation_Breech_transverse_lie()
{
		// $query = "select count(*) as total 
		// from tblpregnant_woman a 
		// inner join 
		// (SELECT PWGUID FROM tblancvisit WHERE DangerSign = 8 group by PWGUID)b 
		// on a.PWGUID = b.PWGUID
		// where a.IsPregnant = 1 and a.IsDeleted = 0";
	$query = "SELECT
	COUNT(*) AS total
	FROM
	(
	SELECT
        *
	FROM
	(
	SELECT
	MAX(CheckupVisitDate) AS CheckupVisitDate,
	PWGUID,
	VisitGUID,
	DangerSign
	FROM
	tblancvisit
	WHERE
	DangerSign IS NOT NULL
	GROUP BY
	PWGUID
	) a
	WHERE
	DangerSign = 8
) a
INNER JOIN tblpregnant_woman b ON
a.PWGUID = b.PWGUID
INNER JOIN tblhhfamilymember c ON
c.HHFamilyMemberGUID = b.HHFamilyMemberGUID
INNER JOIN tblhhsurvey d ON
d.HHSurveyGUID = c.HHSurveyGUID
WHERE
b.IsPregnant = 1 AND b.IsDeleted = 0 AND c.StatusID = 1 AND c.IsDeleted = 0 AND d.IsDeleted = 0 AND b.PWGUID IS NOT NULL";		

return $this->db->query($query)->result()[0]->total;
}

private function gestational_diabetes()
{
		// $query = "select count(*) as total 
		// from tblpregnant_woman a 
		// inner join 
		// (SELECT PWGUID FROM tblancvisit WHERE DangerSign = 5 group by PWGUID)b 
		// on a.PWGUID = b.PWGUID
		// where a.IsPregnant = 1 and a.IsDeleted = 0";

	$query = "SELECT
	COUNT(*) AS total
	FROM
	(
	SELECT
        *
	FROM
	(
	SELECT
	MAX(CheckupVisitDate) AS CheckupVisitDate,
	PWGUID,
	VisitGUID,
	DangerSign
	FROM
	tblancvisit
	WHERE
	DangerSign IS NOT NULL
	GROUP BY
	PWGUID
	) a
	WHERE
	DangerSign = 5
) a
INNER JOIN tblpregnant_woman b ON
a.PWGUID = b.PWGUID
INNER JOIN tblhhfamilymember c ON
c.HHFamilyMemberGUID = b.HHFamilyMemberGUID
INNER JOIN tblhhsurvey d ON
d.HHSurveyGUID = c.HHSurveyGUID
WHERE
b.IsPregnant = 1 AND b.IsDeleted = 0 AND c.StatusID = 1 AND c.IsDeleted = 0 AND d.IsDeleted = 0 AND b.PWGUID IS NOT NULL";

return $this->db->query($query)->result()[0]->total;
}

private function cephalopelvic_disproportion()
{
		// $query = "select count(*) as total 
		// from tblpregnant_woman a 
		// inner join 
		// (SELECT PWGUID FROM tblancvisit WHERE DangerSign = 9 group by PWGUID)b 
		// on a.PWGUID = b.PWGUID
		// where a.IsPregnant = 1 and a.IsDeleted = 0";

	$query = "SELECT
	COUNT(*) AS total
	FROM
	(
	SELECT
        *
	FROM
	(
	SELECT
	MAX(CheckupVisitDate) AS CheckupVisitDate,
	PWGUID,
	VisitGUID,
	DangerSign
	FROM
	tblancvisit
	WHERE
	DangerSign IS NOT NULL
	GROUP BY
	PWGUID
	) a
	WHERE
	DangerSign = 9
) a
INNER JOIN tblpregnant_woman b ON
a.PWGUID = b.PWGUID
INNER JOIN tblhhfamilymember c ON
c.HHFamilyMemberGUID = b.HHFamilyMemberGUID
INNER JOIN tblhhsurvey d ON
d.HHSurveyGUID = c.HHSurveyGUID
WHERE
b.IsPregnant = 1 AND b.IsDeleted = 0 AND c.StatusID = 1 AND c.IsDeleted = 0 AND d.IsDeleted = 0 AND b.PWGUID IS NOT NULL";

return $this->db->query($query)->result()[0]->total;
}

private function teenage_pregnancy_less_than_19_years()
{
								// $this->db->where("PWAgeYears < 19 and PWAgeYears >=11");
								// $this->db->where('IsPregnant', 1);	
								// $this->db->where('IsDeleted', 0);	
								// $this->db->from('tblpregnant_woman');
								// return $this->db->count_all_results();

	$query = "SELECT
	count(*) as total
	FROM
	tblpregnant_woman pw
	INNER JOIN tblhhfamilymember fm ON
	pw.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
	INNER JOIN tblhhsurvey h ON
	h.HHSurveyGUID = fm.HHSurveyGUID
	WHERE
	pw.IsPregnant = 1 AND pw.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0  and pw.PWAgeYears < 19 and pw.PWAgeYears >=11";
	return $this->db->query($query)->result()[0]->total;
}

private function elderly_primigravida_greater_than_40_years()
{
								// $this->db->where("PWAgeYears > 40");
								// $this->db->where('IsPregnant', 1);	
								// $this->db->where('IsDeleted', 0);
								// $this->db->from('tblpregnant_woman');
								// return $this->db->count_all_results();

	$query = "SELECT
	count(*) as total
	FROM
	tblpregnant_woman pw
	INNER JOIN tblhhfamilymember fm ON
	pw.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
	INNER JOIN tblhhsurvey h ON
	h.HHSurveyGUID = fm.HHSurveyGUID
	WHERE
	pw.IsPregnant = 1 AND pw.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0  and pw.PWAgeYears > 40";
	return $this->db->query($query)->result()[0]->total;
}

private function low_height_of_mother_less_than_145_cm()
{
								// $this->db->where("PWHeight < 145 and PWHeight > 121");
								// $this->db->where('IsPregnant', 1);
								// $this->db->where('IsDeleted', 0);
								// $this->db->from('tblpregnant_woman');
								// return $this->db->count_all_results();

	$query = "SELECT
	count(*) as total
	FROM
	tblpregnant_woman pw
	INNER JOIN tblhhfamilymember fm ON
	pw.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
	INNER JOIN tblhhsurvey h ON
	h.HHSurveyGUID = fm.HHSurveyGUID
	WHERE
	pw.IsPregnant = 1 AND pw.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0  and pw.PWHeight < 145 and pw.PWHeight > 121";
	return $this->db->query($query)->result()[0]->total;
}

private function low_weight_of_mother_less_than_45_kg()
{
								// $query = "select count(*) as total from 
								// (select * from (
								// 	select max(CheckupVisitDate) as CheckupVisitDate, PWGUID, VisitGUID, BirthWeight from tblancvisit where BirthWeight is not null group by PWGUID )a 
								// 	where BirthWeight < 45 and BirthWeight > 30)a 
								// 	inner join tblpregnant_woman b 
								// 	on a.PWGUID = b.PWGUID
								// 	where b.IsPregnant = 1 and b.IsDeleted = 0 and b.PWGUID is not null";

	$query = "SELECT
	COUNT(*) AS total
	FROM
	(
	SELECT
        *
	FROM
	(
	SELECT
	MAX(CheckupVisitDate) AS CheckupVisitDate,
	PWGUID,
	VisitGUID,
	BirthWeight
	FROM
	tblancvisit
	WHERE
	BirthWeight IS NOT NULL
	GROUP BY
	PWGUID
	) a
	WHERE
	BirthWeight < 45 AND BirthWeight > 30
) a
INNER JOIN tblpregnant_woman b ON
a.PWGUID = b.PWGUID
INNER JOIN tblhhfamilymember c ON
c.HHFamilyMemberGUID = b.HHFamilyMemberGUID
INNER JOIN tblhhsurvey d ON
d.HHSurveyGUID = c.HHSurveyGUID
WHERE
b.IsPregnant = 1 AND b.IsDeleted = 0 AND c.StatusID = 1 AND c.IsDeleted = 0 AND d.IsDeleted = 0 AND b.PWGUID IS NOT NULL";
return $this->db->query($query)->result()[0]->total;
}

private function hiv_positive()
{
									// $this->db->where("HIVTestYN = 1");
									// $this->db->where('IsPregnant', 1);	
									// $this->db->where('IsDeleted', 0);
									// $this->db->from('tblpregnant_woman');
									// return $this->db->count_all_results();

	$query = "SELECT
	count(*) as total
	FROM
	tblpregnant_woman pw
	INNER JOIN tblhhfamilymember fm ON
	pw.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
	INNER JOIN tblhhsurvey h ON
	h.HHSurveyGUID = fm.HHSurveyGUID
	WHERE
	pw.IsPregnant = 1 AND pw.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0  and pw.HIVTestYN = 1";
	return $this->db->query($query)->result()[0]->total;

}

private function wr_positive()
{
									// $this->db->where("VDRLTestYN = 1");
									// $this->db->where('IsPregnant', 1);	
									// $this->db->where('IsDeleted', 0);
									// $this->db->from('tblpregnant_woman');
									// return $this->db->count_all_results();

	$query = "SELECT
	count(*) as total
	FROM
	tblpregnant_woman pw
	INNER JOIN tblhhfamilymember fm ON
	pw.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
	INNER JOIN tblhhsurvey h ON
	h.HHSurveyGUID = fm.HHSurveyGUID
	WHERE
	pw.IsPregnant = 1 AND pw.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0  and pw.VDRLTestYN = 1";
	return $this->db->query($query)->result()[0]->total;
}

private function get_total_hrp_count_metch_conditions()
{
	$query = "SELECT
    pw.PWGUID
FROM
    tblpregnant_woman pw
INNER JOIN tblhhfamilymember fm ON
    pw.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
INNER JOIN tblhhsurvey h ON
    h.HHSurveyGUID = fm.HHSurveyGUID
WHERE
    pw.IsPregnant = 1 AND pw.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0 AND pw.LastPregnancyResult = 2 AND pw.LTLPregnancyResult = 2
UNION
SELECT
    pw.PWGUID
FROM
    tblpregnant_woman pw
INNER JOIN tblhhfamilymember fm ON
    pw.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
INNER JOIN tblhhsurvey h ON
    h.HHSurveyGUID = fm.HHSurveyGUID
WHERE
    pw.IsPregnant = 1 AND pw.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0 AND pw.LastPregnancyResult = 3
UNION
SELECT
    pw.PWGUID
FROM
    tblpregnant_woman pw
INNER JOIN tblhhfamilymember fm ON
    pw.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
INNER JOIN tblhhsurvey h ON
    h.HHSurveyGUID = fm.HHSurveyGUID
WHERE
    pw.IsPregnant = 1 AND pw.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0 AND pw.LastPregnancyComplication = 14
UNION
SELECT
    pw.PWGUID
FROM
    tblpregnant_woman pw
INNER JOIN tblhhfamilymember fm ON
    pw.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
INNER JOIN tblhhsurvey h ON
    h.HHSurveyGUID = fm.HHSurveyGUID
WHERE
    pw.IsPregnant = 1 AND pw.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0 AND pw.LastPregnancyComplication = 11
UNION
SELECT
    pw.PWGUID
FROM
    tblpregnant_woman pw
INNER JOIN tblhhfamilymember fm ON
    pw.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
INNER JOIN tblhhsurvey h ON
    h.HHSurveyGUID = fm.HHSurveyGUID
WHERE
    pw.IsPregnant = 1 AND pw.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0 AND pw.LastPregnancyComplication = 3
UNION
SELECT
    pw.PWGUID
FROM
    tblpregnant_woman pw
INNER JOIN tblhhfamilymember fm ON
    pw.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
INNER JOIN tblhhsurvey h ON
    h.HHSurveyGUID = fm.HHSurveyGUID
WHERE
    pw.IsPregnant = 1 AND pw.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0 AND pw.LastPregnancyComplication = 12
UNION
SELECT
    pw.PWGUID
FROM
    tblpregnant_woman pw
INNER JOIN tblhhfamilymember fm ON
    pw.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
INNER JOIN tblhhsurvey h ON
    h.HHSurveyGUID = fm.HHSurveyGUID
WHERE
    pw.IsPregnant = 1 AND pw.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0 AND pw.LastPregnancyComplication = 15
UNION
SELECT
    pw.PWGUID
FROM
    tblpregnant_woman pw
INNER JOIN tblhhfamilymember fm ON
    pw.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
INNER JOIN tblhhsurvey h ON
    h.HHSurveyGUID = fm.HHSurveyGUID
WHERE
    pw.IsPregnant = 1 AND pw.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0 AND pw.LastPregnancyComplication = 8
UNION
SELECT
    pw.PWGUID
FROM
    tblpregnant_woman pw
INNER JOIN tblhhfamilymember fm ON
    pw.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
INNER JOIN tblhhsurvey h ON
    h.HHSurveyGUID = fm.HHSurveyGUID
WHERE
    pw.IsPregnant = 1 AND pw.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0 AND pw.LastPregnancyComplication = 7
UNION
SELECT
    pw.PWGUID
FROM
    tblpregnant_woman pw
INNER JOIN tblhhfamilymember fm ON
    pw.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
INNER JOIN tblhhsurvey h ON
    h.HHSurveyGUID = fm.HHSurveyGUID
WHERE
    pw.IsPregnant = 1 AND pw.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0 AND FIND_IN_SET('HYPERTENSION', pw.PastIllnessYN) > 0
UNION
SELECT
    pw.PWGUID
FROM
    tblpregnant_woman pw
INNER JOIN tblhhfamilymember fm ON
    pw.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
INNER JOIN tblhhsurvey h ON
    h.HHSurveyGUID = fm.HHSurveyGUID
WHERE
    pw.IsPregnant = 1 AND pw.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0 AND FIND_IN_SET('DIABETES', pw.PastIllnessYN) > 0
UNION
SELECT
    pw.PWGUID
FROM
    tblpregnant_woman pw
INNER JOIN tblhhfamilymember fm ON
    pw.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
INNER JOIN tblhhsurvey h ON
    h.HHSurveyGUID = fm.HHSurveyGUID
WHERE
    pw.IsPregnant = 1 AND pw.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0 AND FIND_IN_SET(
        'HEART DISEASE',
        pw.PastIllnessYN
    ) > 0
UNION
SELECT
    pw.PWGUID
FROM
    tblpregnant_woman pw
INNER JOIN tblhhfamilymember fm ON
    pw.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
INNER JOIN tblhhsurvey h ON
    h.HHSurveyGUID = fm.HHSurveyGUID
WHERE
    pw.IsPregnant = 1 AND pw.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0 AND FIND_IN_SET('TB', pw.PastIllnessYN) > 0
UNION
SELECT
    pw.PWGUID
FROM
    tblpregnant_woman pw
INNER JOIN tblhhfamilymember fm ON
    pw.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
INNER JOIN tblhhsurvey h ON
    h.HHSurveyGUID = fm.HHSurveyGUID
WHERE
    pw.IsPregnant = 1 AND pw.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0 AND FIND_IN_SET(
        'EPILEPTICCONVULSIONS',
        pw.PastIllnessYN
    ) > 0
UNION
SELECT
    b.PWGUID
FROM
    (
    SELECT
        *
    FROM
        (
        SELECT
            MAX(CheckupVisitDate) AS CheckupVisitDate,
            PWGUID,
            VisitGUID,
            DangerSign
        FROM
            tblancvisit
        WHERE
            DangerSign IS NOT NULL
        GROUP BY
            PWGUID
    ) a
WHERE
    DangerSign = 1
) a
INNER JOIN tblpregnant_woman b ON
    a.PWGUID = b.PWGUID
INNER JOIN tblhhfamilymember c ON
    c.HHFamilyMemberGUID = b.HHFamilyMemberGUID
INNER JOIN tblhhsurvey d ON
    d.HHSurveyGUID = c.HHSurveyGUID
WHERE
    b.IsPregnant = 1 AND b.IsDeleted = 0 AND c.StatusID = 1 AND c.IsDeleted = 0 AND d.IsDeleted = 0 AND b.PWGUID IS NOT NULL
UNION
SELECT
    b.PWGUID
FROM
    (
    SELECT
        *
    FROM
        (
        SELECT
            MAX(CheckupVisitDate) AS CheckupVisitDate,
            PWGUID,
            VisitGUID,
            DangerSign
        FROM
            tblancvisit
        WHERE
            DangerSign IS NOT NULL
        GROUP BY
            PWGUID
    ) a
WHERE
    DangerSign = 2
) a
INNER JOIN tblpregnant_woman b ON
    a.PWGUID = b.PWGUID
INNER JOIN tblhhfamilymember c ON
    c.HHFamilyMemberGUID = b.HHFamilyMemberGUID
INNER JOIN tblhhsurvey d ON
    d.HHSurveyGUID = c.HHSurveyGUID
WHERE
    b.IsPregnant = 1 AND b.IsDeleted = 0 AND c.StatusID = 1 AND c.IsDeleted = 0 AND d.IsDeleted = 0 AND b.PWGUID IS NOT NULL
UNION
SELECT
    b.PWGUID
FROM
    (
    SELECT
        *
    FROM
        (
        SELECT
            MAX(CheckupVisitDate) AS CheckupVisitDate,
            PWGUID,
            VisitGUID,
            DangerSign
        FROM
            tblancvisit
        WHERE
            DangerSign IS NOT NULL
        GROUP BY
            PWGUID
    ) a
WHERE
    DangerSign = 8
) a
INNER JOIN tblpregnant_woman b ON
    a.PWGUID = b.PWGUID
INNER JOIN tblhhfamilymember c ON
    c.HHFamilyMemberGUID = b.HHFamilyMemberGUID
INNER JOIN tblhhsurvey d ON
    d.HHSurveyGUID = c.HHSurveyGUID
WHERE
    b.IsPregnant = 1 AND b.IsDeleted = 0 AND c.StatusID = 1 AND c.IsDeleted = 0 AND d.IsDeleted = 0 AND b.PWGUID IS NOT NULL
UNION
SELECT
    b.PWGUID
FROM
    (
    SELECT
        *
    FROM
        (
        SELECT
            MAX(CheckupVisitDate) AS CheckupVisitDate,
            PWGUID,
            VisitGUID,
            DangerSign
        FROM
            tblancvisit
        WHERE
            DangerSign IS NOT NULL
        GROUP BY
            PWGUID
    ) a
WHERE
    DangerSign = 9
) a
INNER JOIN tblpregnant_woman b ON
    a.PWGUID = b.PWGUID
INNER JOIN tblhhfamilymember c ON
    c.HHFamilyMemberGUID = b.HHFamilyMemberGUID
INNER JOIN tblhhsurvey d ON
    d.HHSurveyGUID = c.HHSurveyGUID
WHERE
    b.IsPregnant = 1 AND b.IsDeleted = 0 AND c.StatusID = 1 AND c.IsDeleted = 0 AND d.IsDeleted = 0 AND b.PWGUID IS NOT NULL
UNION
SELECT
    pw.PWGUID
FROM
    tblpregnant_woman pw
INNER JOIN tblhhfamilymember fm ON
    pw.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
INNER JOIN tblhhsurvey h ON
    h.HHSurveyGUID = fm.HHSurveyGUID
WHERE
    pw.IsPregnant = 1 AND pw.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0 AND pw.PWAgeYears < 19 AND pw.PWAgeYears >= 11
UNION
SELECT
    pw.PWGUID
FROM
    tblpregnant_woman pw
INNER JOIN tblhhfamilymember fm ON
    pw.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
INNER JOIN tblhhsurvey h ON
    h.HHSurveyGUID = fm.HHSurveyGUID
WHERE
    pw.IsPregnant = 1 AND pw.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0 AND pw.PWAgeYears > 40
UNION
SELECT
    pw.PWGUID
FROM
    tblpregnant_woman pw
INNER JOIN tblhhfamilymember fm ON
    pw.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
INNER JOIN tblhhsurvey h ON
    h.HHSurveyGUID = fm.HHSurveyGUID
WHERE
    pw.IsPregnant = 1 AND pw.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0 AND pw.PWHeight < 145 AND pw.PWHeight > 121
UNION
SELECT
    b.PWGUID
FROM
    (
    SELECT
        *
    FROM
        (
        SELECT
            MAX(CheckupVisitDate) AS CheckupVisitDate,
            PWGUID,
            VisitGUID,
            BirthWeight
        FROM
            tblancvisit
        WHERE
            BirthWeight IS NOT NULL
        GROUP BY
            PWGUID
    ) a
WHERE
    BirthWeight < 45 AND BirthWeight > 30
) a
INNER JOIN tblpregnant_woman b ON
    a.PWGUID = b.PWGUID
WHERE
    b.IsPregnant = 1 AND b.IsDeleted = 0 AND b.PWGUID IS NOT NULL
UNION
SELECT
    pw.PWGUID
FROM
    tblpregnant_woman pw
INNER JOIN tblhhfamilymember fm ON
    pw.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
INNER JOIN tblhhsurvey h ON
    h.HHSurveyGUID = fm.HHSurveyGUID
WHERE
    pw.IsPregnant = 1 AND pw.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0 AND pw.HIVTestYN = 1
UNION
SELECT
    pw.PWGUID
FROM
    tblpregnant_woman pw
INNER JOIN tblhhfamilymember fm ON
    pw.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
INNER JOIN tblhhsurvey h ON
    h.HHSurveyGUID = fm.HHSurveyGUID
WHERE
    pw.IsPregnant = 1 AND pw.IsDeleted = 0 AND fm.IsDeleted = 0 AND fm.StatusID = 1 AND h.IsDeleted = 0 AND pw.VDRLTestYN = 1
UNION
SELECT
    b.PWGUID
FROM
    (
    SELECT
        *
    FROM
        (
        SELECT
            MAX(CheckupVisitDate) AS CheckupVisitDate,
            BPResult,
            PWGUID,
            SUBSTRING_INDEX(BPResult, ',', 1) AS systolic,
            REVERSE(
                SUBSTRING_INDEX(REVERSE(BPResult),
                ',',
                1)
            ) AS diastolic
        FROM
            tblancvisit
        WHERE
            BPResult IS NOT NULL AND BPResult != '' AND SUBSTRING_INDEX(BPResult, ',', 1) != 0 AND REVERSE(
                SUBSTRING_INDEX(REVERSE(BPResult),
                ',',
                1)
            ) != 0
        GROUP BY
            PWGUID
    ) a
WHERE
    systolic >= 140 OR diastolic >= 90
) a
INNER JOIN tblpregnant_woman b ON
    a.PWGUID = b.PWGUID
INNER JOIN tblhhfamilymember c ON
    c.HHFamilyMemberGUID = b.HHFamilyMemberGUID
INNER JOIN tblhhsurvey d ON
    d.HHSurveyGUID = c.HHSurveyGUID
WHERE
    b.IsPregnant = 1 AND b.IsDeleted = 0 AND c.StatusID = 1 AND c.IsDeleted = 0 AND d.IsDeleted = 0 AND b.PWGUID IS NOT NULL
UNION
SELECT
    b.PWGUID
FROM
    (
    SELECT
        *
    FROM
        (
        SELECT
            MAX(CheckupVisitDate) AS CheckupVisitDate,
            PWGUID,
            VisitGUID,
            DangerSign
        FROM
            tblancvisit
        WHERE
            DangerSign IS NOT NULL
        GROUP BY
            PWGUID
    ) a
WHERE
    DangerSign = 5
) a
INNER JOIN tblpregnant_woman b ON
    a.PWGUID = b.PWGUID
INNER JOIN tblhhfamilymember c ON
    c.HHFamilyMemberGUID = b.HHFamilyMemberGUID
INNER JOIN tblhhsurvey d ON
    d.HHSurveyGUID = c.HHSurveyGUID
WHERE
    b.IsPregnant = 1 AND b.IsDeleted = 0 AND c.StatusID = 1 AND c.IsDeleted = 0 AND d.IsDeleted = 0 AND b.PWGUID IS NOT NULL";
    return $this->db->query($query)->num_rows();
}

private function get_total_hrp_count()
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
        a.IsPregnant = 1 AND (a.HighRisk = 1 or j.HighRisk = 1) AND a.IsDeleted = 0 AND b.IsDeleted = 0 AND c.IsDeleted = 0 AND d.LanguageID = 1 AND d.IsDeleted = 0 AND d.IsActive = 1 AND e.LanguageID = 1 AND e.IsDeleted = 0 AND i.IsDeleted = 0 AND i.LanguageID = 1 AND g.user_mode = 1 GROUP BY a.PWGUID )a";

	return $this->db->query($query)->result()[0]->total;
}

private function two_or_more_abortions()
{
	$query = "SELECT count(*) as total FROM `tblpregnant_woman` WHERE LastPregnancyResult = 2 and LTLPregnancyResult = 2 and IsDeleted = 0";
	$this->db->query($query)->result();
}



public function get_process_indicators_counts()
{
	$query = "
	select 
	a.*, 
	ifnull(b.total,0) as hh_records_updated, 
	ifnull(c.total,0) as anc_checkup_updated,
	ifnull(d.total,0) as new_pregnancies_added,
	ifnull(e.total,0) as anc_checkups_added_updated,
	ifnull(f.total,0) as new_child_added,
	ifnull(g.total,0) as existing_child_updated,
	ifnull(h.total,0) as immunuzation_counselling_done,
	ifnull(i.total,0) as anc_homevisit_done,
	ifnull(j.total,0) as pnc_homevisit_done,
	ifnull(k.total,0) as fp_followup_done,
	ifnull(l.total,0) as fp_counselling_done,
	ifnull(b.total,0) as updates_household_details,
	ifnull(c.total,0) + ifnull(k.total,0) as updates_mnch_module,
	ifnull(i.total,0) as updates_mnch_anc_module,
	ifnull(f.total,0) as updates_mnch_newborn,
	ifnull(e.total,0) + ifnull(j.total,0) as updates_mnch_homevisit,
	ifnull(k.total,0) + ifnull(l.total,0) as updates_fp_module
	from (select a.ASHAName, n.ANMName, a.ASHAID, n.ANMID from mstasha a 
		inner join anmasha m 
		on m.ASHAID = a.ASHAID and a.LanguageID = 1
		inner join mstanm n 
		on n.ANMID = m.ANMID and n.LanguageID = 1
		where 1=1";

		if (is_array($this->filter_data['Asha']) && count($this->filter_data['Asha']) > 0) {
			$query .= " and a.ASHAID in (". implode(",", $this->filter_data['Asha']) .")";
		}

		if (is_array($this->filter_data['ANM']) && count($this->filter_data['ANM']) > 0) {
			$query .= " and n.ANMID in (" . implode(",",$this->filter_data['ANM']) .")";
		}

		$query .= "	group by n.ANMID, a.ASHAID) a 
		left join 
		(SELECT s.ServiceProviderID, count(*) as total FROM `tblhhsurvey` s 
		where 1=1";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and ((s.CreatedOn > '" . $this->filter_data['date_from'] . "' and s.CreatedOn < '" . $this->filter_data['date_to'] . "')";
			$query .= " or (s.UploadedOn > '" . $this->filter_data['date_from'] . "' and s.UploadedOn < '" . $this->filter_data['date_to'] . "'))";
		}

		/*if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and s.ANMID in (" . implode(",",$this->filter_data['ANM']) .")";
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and s.ServiceProviderID in (" . implode(",",$this->filter_data['Asha']) . ")";
		}*/

		$query .= " group by s.ServiceProviderID) b 
		on a.ASHAID = b.ServiceProviderID
		left join 
		(SELECT v.ByAshaID, count(*) as total from tblancvisit v 
		where v.CheckupVisitDate is not null";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and (v.UpdatedOn > '" . $this->filter_data['date_from'] . "' and v.UpdatedOn < '" . $this->filter_data['date_to'] . "')";
		}

		$query .= " group by v.ByAshaID) c 
		on a.ASHAID = c.ByAshaID
		left join(
			select pw.AshaID, count(*) as total from tblpregnant_woman pw 
			where 1=1";

			if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
			{
				$query .= " and (pw.CreatedOn > '" . $this->filter_data['date_from'] . "' and pw.CreatedOn < '" . $this->filter_data['date_to'] . "')";
			}

			$query .= " group by pw.AshaID)d
			on a.ASHAID = d.AshaID
			left join (
				select ByAshaID, count(*) as total from tblancvisit v 
				where v.CheckupVisitDate is not null";

				if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
				{
					$query .= " and ((v.UpdatedOn > '" . $this->filter_data['date_from'] . "' and v.UpdatedOn < '" . $this->filter_data['date_to'] . "')";
					$query .= " or (v.CreatedOn > '" . $this->filter_data['date_from'] . "' and v.CreatedOn < '" . $this->filter_data['date_to'] . "'))";
				}

				$query .= " group by v.ByAshaID)e 
				on a.ASHAID = e.ByAshaID
				left join (
					select c.AshaID, count(*) as total from tblchild c
					where 1=1";

					if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
					{
						$query .= " and (c.created_on > '" . $this->filter_data['date_from'] . "' and c.created_on < '" . $this->filter_data['date_to'] . "')";
					}

					$query .= " group by c.AshaID)f
					on a.ASHAID = f.AshaID
					left join (
						select c.AshaID, count(*) as total from tblchild c
						where 1=1";

						if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
						{
							$query .= " and (c.modified_on > '" . $this->filter_data['date_from'] . "' and c.modified_on < '" . $this->filter_data['date_to'] . "')";
						}

						$query .= " group by c.AshaID)g
						on a.ASHAID = g.AshaID
						left join (
							select i.AshaID, count(*) as total from tblmstimmunizationans i
							where 1=1";

							if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
							{
								$query .= " and ((i.CreatedOn > '" . $this->filter_data['date_from'] . "' and i.CreatedOn < '" . $this->filter_data['date_to'] . "')";
								$query .= " or (i.UpdatedOn > '" . $this->filter_data['date_from'] . "' and i.UpdatedOn < '" . $this->filter_data['date_to'] . "'))";
							}

							$query .= " group by i.AshaID)h 
							on a.ASHAID = h.AshaID
							left join (
								select v.ByAshaID, count(*) as total from tblancvisit v 
								where v.HomeVisitDate is not null";

								if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
								{
									$query .= " and ((v.CreatedOn > '" . $this->filter_data['date_from'] . "' and v.CreatedOn < '" . $this->filter_data['date_to'] . "')";
									$query .= " or (v.UpdatedOn > '" . $this->filter_data['date_from'] . "' and v.UpdatedOn < '" . $this->filter_data['date_to'] . "'))";
								}

								$query .= " group by v.ByAshaID)i 
								on a.ASHAID = i.ByAshaID
								left join (
									select AshaID, count(*) as total from tblpnchomevisit_ans p 
									where 1=1";

									if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
									{
										$query .= " and ((p.CreatedOn > '" . $this->filter_data['date_from'] . "' and p.CreatedOn < '" . $this->filter_data['date_to'] . "')";
										$query .= " or (p.UpdatedOn > '" . $this->filter_data['date_from'] . "' and p.UpdatedOn < '" . $this->filter_data['date_to'] . "'))";
									}

									$query .= " group by p.AshaID)j 
									on a.ASHAID = j.AshaID
									left join (
										select AshaID, count(*) as total from tblmstfpfdetail a 
										where 1=1";

										if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
										{
											$query .= " and (a.CreatedOn > '" . $this->filter_data['date_from'] . "' and a.CreatedOn < '" . $this->filter_data['date_to'] . "')";
										}

										$query .= " group by a.AshaID)k 
										on a.ASHAID = k.AshaID
										left join (
											select a.AshaID, count(*) as total from tblmstfpans a 
											where 1=1";

											if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
											{
												$query .= " and (a.CreatedOn > '" . $this->filter_data['date_from'] . "' and a.CreatedOn < '" . $this->filter_data['date_to'] . "')";
											}

											$query .= " group by a.AshaID)l 
											on a.ASHAID = l.AshaID";

		// die($query);

											return $this->db->query($query)->result();
										}

										public function get_total_pregnant_women()
										{

											$query = "select count(*) as total from tblpregnant_woman m 
											INNER JOIN tblhhfamilymember fm 
											on
											m.HHFamilyMemberGUID = fm.HHFamilyMemberGUID
											where
											m.IsDeleted = 0 and fm.IsDeleted = 0 and m.IsPregnant = 1
											and
											(
												CASE
												WHEN fm.DOBAvailable = 2 THEN fm.AprilAgeYear + (YEAR(CURRENT_DATE) - fm.AgeAsOnYear)
												WHEN fm.DOBAvailable = 1 THEN TIMESTAMPDIFF(YEAR,fm.DateOfBirth, CURRENT_DATE) END
											) >= 15 and
											(
												CASE
												WHEN fm.DOBAvailable = 2 THEN fm.AprilAgeYear + (YEAR(CURRENT_DATE) - fm.AgeAsOnYear)
												WHEN fm.DOBAvailable = 1 THEN TIMESTAMPDIFF(YEAR,fm.DateOfBirth, CURRENT_DATE) END
											) <=49 ";
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
											if ($this->loginData->user_role == 6 ) 
											{
												$state_code = $this->loginData->state_code;
												$query .= " and state_code = '$state_code'";	
											}
											$query .= " and user_mode= 1)";

											return $this->db->query($query)->result()[0]->total;

										}


									}