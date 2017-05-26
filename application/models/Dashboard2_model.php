<?php 
class Dashboard2_model extends CI_Model {
	
	private $filter_data;
	private $eligible_couple_count;
	private $fp_user_count;
	private $ocp_user_count;
	private $condom_user_count;
	private $iucd_user_count;
	private $pregnancies_registered_count;
	private $live_birth_count;
	private $still_birth_count;
	private $abortion_count;
	private $child_partial_immunization_count;
	private $child_full_immunization_count;
	private $pregnant_woman_immunization_count;
	private $child_count;
	private $pregnant_woman_count;

	public function __construct()
	{
		parent::__construct();
		$this->eligible_couple_count = NULL;
		$this->fp_user_count = NULL;
		$this->ocp_user_count = NULL;
		$this->condom_user_count = NULL;
		$this->iucd_user_count = NULL;
		$this->pregnancies_registered_count = NULL;
		$this->live_birth_count = NULL;
		$this->still_birth_count = NULL;
		$this->abortion_count = NULL;
		$this->child_partial_immunization_count = NULL;
		$this->child_full_immunization_count = NULL;
		$this->pregnant_woman_immunization_count = NULL;
		$this->child_count = NULL;
		$this->pregnant_woman_count = NULL;
	}

	public function get_household_count()
	{

		$this->filter_data = $this->session->userdata("filter_data");

		$query = "select count(*) as household_count from tblhhsurvey where 1 ";

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and ANMID = " . $this->filter_data['ANM'];
		}


		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and ServiceProviderID = " . $this->filter_data['Asha'];
		}


		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and CreatedOn > '" . $this->filter_data['date_from'] . "' and CreatedOn < '" . $this->filter_data['date_to'] . "'";
		}

		return $this->db->query($query)->result()[0]->household_count;

	}
	
	public function get_child_registration_count()
	{

		$this->filter_data = $this->session->userdata("filter_data");

		$query = "select count(*) as child_registration_count 
		from tblpregnant_woman w 
		inner join tblchild c 
		on w.PWGUID = c.pw_GUID
		where 1";

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and w.ANMID = " . $this->filter_data['ANM'];
		}


		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and w.AshaID = " . $this->filter_data['Asha'];
		}


		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and c.Date_Of_Registration > '" . $this->filter_data['date_from'] . "' and c.Date_Of_Registration < '" . $this->filter_data['date_to'] . "'";
		}

		return $this->db->query($query)->result()[0]->child_registration_count;

	}

	public function get_immunization_count()
	{

		$this->filter_data = $this->session->userdata("filter_data");

		$query = "select count(*) as immunization_count 
		from tblmstimmunizationans
		where 1";

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and ANMID = " . $this->filter_data['ANM'];
		}


		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and AshaID = " . $this->filter_data['Asha'];
		}


		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and CreatedOn > '" . $this->filter_data['date_from'] . "' and CreatedOn < '" . $this->filter_data['date_to'] . "'";
		}

		return $this->db->query($query)->result()[0]->immunization_count;

	}

	public function fp_block()
	{

		$fp_block['main_dial']['percent'] = 	number_format(($this->get_fp_user_count() / $this->get_eligible_couple_count())*100, 1);
		$fp_block['main_dial']['numenator'] = 	$this->get_fp_user_count();
		$fp_block['main_dial']['denominator'] = 	$this->get_eligible_couple_count();

		$fp_block['first_dial']['percent'] = 	number_format(($this->get_ocp_user_count() / $this->get_fp_user_count())*100, 1);
		$fp_block['first_dial']['numenator'] = 	$this->get_ocp_user_count();
		$fp_block['first_dial']['denominator'] = 	$this->get_fp_user_count();

		$fp_block['second_dial']['percent'] = 	number_format(($this->get_condom_user_count() / $this->get_fp_user_count())*100, 1);
		$fp_block['second_dial']['numenator'] = 	$this->get_condom_user_count();
		$fp_block['second_dial']['denominator'] = 	$this->get_fp_user_count();

		$fp_block['third_dial']['percent'] = 	number_format(($this->get_iucd_user_count() / $this->get_fp_user_count())*100, 1);
		$fp_block['third_dial']['numenator'] = 	$this->get_iucd_user_count();
		$fp_block['third_dial']['denominator'] = 	$this->get_fp_user_count();


		return $fp_block;
	}

	public function p_block()
	{
		/*echo "pregnancy registered: " . $this->get_pregnancies_registered_count();
		echo "eligible couple count: " . $this->get_eligible_couple_count();

		die();*/

		$p_block['main_dial']['percent'] = 	number_format(($this->get_pregnancies_registered_count() / $this->get_eligible_couple_count())*100, 1);
		$p_block['main_dial']['numenator'] = 	$this->get_pregnancies_registered_count();
		$p_block['main_dial']['denominator'] = 	$this->get_eligible_couple_count();

		$p_block['first_dial']['percent'] = 	number_format(($this->get_live_birth_count() / $this->get_pregnancies_registered_count())*100, 1);
		$p_block['first_dial']['numenator'] = 	$this->get_live_birth_count();
		$p_block['first_dial']['denominator'] = 	$this->get_pregnancies_registered_count();

		$p_block['second_dial']['percent'] = 	number_format(($this->get_still_birth_count() / $this->get_pregnancies_registered_count())*100, 1);
		$p_block['second_dial']['numenator'] = 	$this->get_still_birth_count();
		$p_block['second_dial']['denominator'] = 	$this->get_pregnancies_registered_count();

		$p_block['third_dial']['percent'] = 	number_format(($this->get_abortion_count() / $this->get_pregnancies_registered_count())*100, 1);
		$p_block['third_dial']['numenator'] = 	$this->get_abortion_count();
		$p_block['third_dial']['denominator'] = 	$this->get_pregnancies_registered_count();

		return $p_block;
	}

	public function i_block()
	{
		$i_block['main_dial']['percent'] = 	number_format(($this->get_total_immunization_count() / $this->get_total_mother_plus_child_count())*100, 1);
		$i_block['main_dial']['numenator'] = 	$this->get_total_immunization_count();
		$i_block['main_dial']['denominator'] = 	$this->get_total_mother_plus_child_count();

		$i_block['first_dial']['percent'] = 	number_format(($this->get_pregnant_woman_immunization_count() / $this->get_pregnancies_registered_count())*100, 1);
		$i_block['first_dial']['numenator'] = 	$this->get_pregnant_woman_immunization_count();
		$i_block['first_dial']['denominator'] = 	$this->get_pregnancies_registered_count();

		$i_block['second_dial']['percent'] = 	number_format(($this->get_child_full_immunization_count() / $this->get_child_count())*100, 1);
		$i_block['second_dial']['numenator'] = 	$this->get_child_full_immunization_count();
		$i_block['second_dial']['denominator'] = 	$this->get_child_count();

		$i_block['third_dial']['percent'] = 	number_format(($this->get_child_partial_immunization_count() / $this->get_child_count())*100, 1);
		$i_block['third_dial']['numenator'] = 	$this->get_child_partial_immunization_count();
		$i_block['third_dial']['denominator'] = 	$this->get_child_count();

		return $i_block;
	}


	private function get_eligible_couple_count()
	{

		if ($this->eligible_couple_count != NULL) {
			return $this->eligible_couple_count;
		}

		$query = "select 
		count(m.HHUID) as total
		FROM
		tblhhfamilymember m
		LEFT JOIN tblhhsurvey s ON m.HHUID = s.HHUID
		WHERE
		m.GenderID = 2 
		AND m.MaritialStatusID = 1 ";

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and s.ANMID = " . $this->filter_data['ANM'];
		}


		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and s.ServiceProviderID = " . $this->filter_data['Asha'];
		}

		$query .= " AND m.StatusID = 1";

		$result = $this->db->query($query)->result()[0]->total;
		if ($result == 0) {
			$result = 1;
		}
		$this->eligible_couple_count = $result;
		return $this->eligible_couple_count;
	}

	private function get_fp_user_count()
	{
		if ($this->fp_user_count != NULL) {
			return $this->fp_user_count;
		}

		$query = "select
		count(*) as total
		FROM
		tblhhfamilymember m
		INNER JOIN tblhhsurvey s ON m.HHUID = s.HHUID
		WHERE 1";

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and s.ANMID = " . $this->filter_data['ANM'];
		}


		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and s.ServiceProviderID = " . $this->filter_data['Asha'];
		}

		$query .= " AND (
		m.HHFamilyMemberGUID IN(
		SELECT DISTINCT
		(womenname_guid)
		FROM
		tblmstfpans ans";
		
		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " where ans.CreatedOn > '" . $this->filter_data['date_from'] . "' and ans.CreatedOn < '" . $this->filter_data['date_to'] . "'";
		}

		$query .= ") OR m.HHFamilyMemberGUID IN(
		SELECT DISTINCT
		(womenname_guid)
		FROM
		tblmstfpfdetail fp";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " where fp.CreatedOn > '" . $this->filter_data['date_from'] . "' and fp.CreatedOn < '" . $this->filter_data['date_to'] . "'";
		}
		
		$query .= " )
		)";

		$result = $this->db->query($query)->result()[0]->total;
		if ($result == 0) {
			$result = 1;
		}
		$this->fp_user_count = $result;
		return $this->fp_user_count;
		
	}

	private function get_ocp_user_count()
	{
		if ($this->ocp_user_count != NULL) {
			return $this->ocp_user_count;
		}

		$query = "select
		count(*) as total
		FROM
		tblhhfamilymember m
		INNER JOIN tblhhsurvey s ON m.HHUID = s.HHUID
		WHERE 1";

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and s.ANMID = " . $this->filter_data['ANM'];
		}


		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and s.ServiceProviderID = " . $this->filter_data['Asha'];
		}

		$query .= " AND m.HHFamilyMemberGUID IN(
		SELECT DISTINCT
		(womenname_guid)
		FROM
		tblmstfpfdetail fp
		where fp.MethodAdopted = 2 or fp.MethodAdopted = 3";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and fp.CreatedOn > '" . $this->filter_data['date_from'] . "' and fp.CreatedOn < '" . $this->filter_data['date_to'] . "'";
		}
		
		$query .= "
		)";

		$this->ocp_user_count = $this->db->query($query)->result()[0]->total;
		return $this->ocp_user_count;

	}

	private function get_condom_user_count()
	{
		if ($this->condom_user_count != NULL) {
			return $this->condom_user_count;
		}

		$query = "select
		count(*) as total
		FROM
		tblhhfamilymember m
		INNER JOIN tblhhsurvey s ON m.HHUID = s.HHUID
		WHERE 1";

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and s.ANMID = " . $this->filter_data['ANM'];
		}


		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and s.ServiceProviderID = " . $this->filter_data['Asha'];
		}

		$query .= " AND m.HHFamilyMemberGUID IN(
		SELECT DISTINCT
		(womenname_guid)
		FROM
		tblmstfpfdetail fp
		where fp.MethodAdopted = 1";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and fp.CreatedOn > '" . $this->filter_data['date_from'] . "' and fp.CreatedOn < '" . $this->filter_data['date_to'] . "'";
		}
		
		$query .= "
		)";

		$this->condom_user_count = $this->db->query($query)->result()[0]->total;
		return $this->condom_user_count;

	}

	private function get_iucd_user_count()
	{
		if ($this->iucd_user_count != NULL) {
			return $this->iucd_user_count;
		}

		$query = "select
		count(*) as total
		FROM
		tblhhfamilymember m
		INNER JOIN tblhhsurvey s ON m.HHUID = s.HHUID
		WHERE 1";

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and s.ANMID = " . $this->filter_data['ANM'];
		}


		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and s.ServiceProviderID = " . $this->filter_data['Asha'];
		}

		$query .= " AND m.HHFamilyMemberGUID IN(
		SELECT DISTINCT
		(womenname_guid)
		FROM
		tblmstfpfdetail fp
		where fp.MethodAdopted = 4 or fp.MethodAdopted = 5";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and fp.CreatedOn > '" . $this->filter_data['date_from'] . "' and fp.CreatedOn < '" . $this->filter_data['date_to'] . "'";
		}
		
		$query .= "
		)";

		$this->iucd_user_count = $this->db->query($query)->result()[0]->total;
		return $this->iucd_user_count;

	}

	public function get_pregnancies_registered_count()
	{
		if ($this->pregnancies_registered_count != NULL) {
			return $this->pregnancies_registered_count;
		}

		$query = "select 
		count(*) as total
		FROM tblpregnant_woman pw 
		inner join tblhhsurvey s 
		on pw.HHGUID = s.HHSurveyGUID
		where pw.IsPregnant = 1";

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and s.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and s.ServiceProviderID = " . $this->filter_data['Asha'];
		}

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and pw.PWRegistrationDate  > '" . $this->filter_data['date_from'] . "' and pw.PWRegistrationDate < '" . $this->filter_data['date_to'] . "'";
		}

		$result = $this->db->query($query)->result()[0]->total;
		if ($result == 0) {
			$result = 1;
		}
		$this->pregnancies_registered_count = $result;
		return $this->pregnancies_registered_count;

	}

	private function get_live_birth_count()
	{
		if ($this->live_birth_count != NULL) {
			return $this->live_birth_count;
		}

		$query = "select 
		count(*) as total
		FROM tblpregnant_woman pw 
		inner join tblhhsurvey s 
		on pw.HHGUID = s.HHSurveyGUID
		inner join tblchild c 
		on c.pw_GUID = pw.PWGUID
		where pw.IsPregnant = 1";

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and s.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and s.ServiceProviderID = " . $this->filter_data['Asha'];
		}

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and pw.PWRegistrationDate  > '" . $this->filter_data['date_from'] . "' and pw.PWRegistrationDate < '" . $this->filter_data['date_to'] . "'";
		}

		$this->live_birth_count = $this->db->query($query)->result()[0]->total;
		return $this->live_birth_count;

	}

	private function get_still_birth_count()
	{
		if ($this->still_birth_count != NULL) {
			return $this->still_birth_count;
		}

		$query = "select 
		count(*) as total
		FROM tblpregnant_woman pw 
		inner join tblhhsurvey s 
		on pw.HHGUID = s.HHSurveyGUID
		where pw.IsPregnant = 1
		and pw.DeliveryType = 2
		";

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and s.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and s.ServiceProviderID = " . $this->filter_data['Asha'];
		}

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and pw.PWRegistrationDate  > '" . $this->filter_data['date_from'] . "' and pw.PWRegistrationDate < '" . $this->filter_data['date_to'] . "'";
		}

		$this->still_birth_count = $this->db->query($query)->result()[0]->total;
		return $this->still_birth_count;

	}

	private function get_abortion_count()
	{
		if ($this->abortion_count != NULL) {
			return $this->abortion_count;
		}

		$query = "select 
		count(*) as total
		FROM tblpregnant_woman pw 
		inner join tblhhsurvey s 
		on pw.HHGUID = s.HHSurveyGUID
		where pw.ISAbortion=1";

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and s.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and s.ServiceProviderID = " . $this->filter_data['Asha'];
		}

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and pw.PWRegistrationDate  > '" . $this->filter_data['date_from'] . "' and pw.PWRegistrationDate < '" . $this->filter_data['date_to'] . "'";
		}

		$this->abortion_count = $this->db->query($query)->result()[0]->total;
		return $this->abortion_count;

	}

	private function get_total_immunization_count()
	{
		if ($this->child_partial_immunization_count == NULL) {
			$this->get_child_partial_immunization_count();
		}

		if ($this->pregnant_woman_immunization_count == NULL) {
			$this->get_pregnant_woman_immunization_count();
		}

		return $this->child_partial_immunization_count + $this->pregnant_woman_immunization_count;

	}

	public function get_child_partial_immunization_count()
	{
		if ($this->child_partial_immunization_count != NULL) {
			return $this->child_partial_immunization_count;
		}

		$query = "select
		COUNT(*) AS total
		FROM
		tblpregnant_woman pw
		INNER JOIN tblhhsurvey s ON
		pw.HHGUID = s.HHSurveyGUID
		INNER JOIN tblchild c ON
		c.pw_GUID = pw.PWGUID
		WHERE
		c.pw_GUID IS NOT NULL
		and (
		c.bcg is not null 
		or c.opv1 is not null
		or c.dpt1 is not null
		or c.hepb1 is not null
		or c.opv2 is not null
		or c.dpt2 is not null
		or c.hepb2 is not null
		or c.opv3 is not null
		or c.dpt3 is not null
		or c.hepb3 is not null
		or c.measeals is not null
		or c.vitaminA is not null
		or c.opv4 is not null
		or c.hepb4 is not null
		or c.Pentavalent1 is not null
		or c.Pentavalent2 is not null
		or c.Pentavalent3 is not null
		or c.IPV is not null
		or c.DPTBooster is not null
		or c.OPVBooster is not null
		or c.MeaslesTwoDose is not null
		or c.VitaminAtwo is not null
		or c.DPTBoostertwo is not null
		or c.ChildTT is not null
		or c.JEVaccine1 is not null
		or c.JEVaccine2 is not null
		or c.VitaminA3 is not null
		or c.VitaminA4 is not null
		or c.VitaminA5 is not null
		or c.VitaminA6 is not null
		or c.VitaminA7 is not null
		or c.VitaminA8 is not null
		or c.VitaminA9 is not null
		or c.TT2 is not null
		)
		";

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and s.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and s.ServiceProviderID = " . $this->filter_data['Asha'];
		}

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and pw.PWRegistrationDate  > '" . $this->filter_data['date_from'] . "' and pw.PWRegistrationDate < '" . $this->filter_data['date_to'] . "'";
		}

		$this->child_partial_immunization_count = $this->db->query($query)->result()[0]->total;
		return $this->child_partial_immunization_count;

	}

	private function get_child_full_immunization_count()
	{
		if ($this->child_full_immunization_count != NULL) {
			return $this->child_full_immunization_count;
		}

		$query = "select
		COUNT(*) AS total
		FROM
		tblpregnant_woman pw
		INNER JOIN tblhhsurvey s ON
		pw.HHGUID = s.HHSurveyGUID
		INNER JOIN tblchild c ON
		c.pw_GUID = pw.PWGUID
		WHERE
		c.pw_GUID IS NOT NULL AND(
		c.bcg IS NOT NULL AND(
		(
		c.Pentavalent1 IS NOT NULL OR(
		c.dpt1 IS NOT NULL AND c.hepb1 AND NOT NULL
		)
		) AND(
		c.Pentavalent2 IS NOT NULL OR(
		c.dpt2 IS NOT NULL AND c.hepb2 AND NOT NULL
		)
		) AND(
		c.Pentavalent3 IS NOT NULL OR(
		c.dpt3 IS NOT NULL AND c.hepb3 AND NOT NULL
		)
		)
		) AND c.opv1 IS NOT NULL AND c.dpt1 IS NOT NULL AND c.hepb1 IS NOT NULL AND c.opv2 IS NOT NULL AND c.dpt2 IS NOT NULL AND c.hepb2 IS NOT NULL AND c.opv3 IS NOT NULL AND c.dpt3 IS NOT NULL AND c.hepb3 IS NOT NULL AND c.measeals IS NOT NULL AND c.vitaminA IS NOT NULL AND c.opv4 IS NOT NULL AND c.hepb4 IS NOT NULL AND c.Pentavalent1 IS NOT NULL AND c.Pentavalent2 IS NOT NULL AND c.Pentavalent3 IS NOT NULL AND c.IPV IS NOT NULL AND c.DPTBooster IS NOT NULL AND c.OPVBooster IS NOT NULL AND c.MeaslesTwoDose IS NOT NULL AND c.VitaminAtwo IS NOT NULL AND c.DPTBoostertwo IS NOT NULL AND c.ChildTT IS NOT NULL AND c.JEVaccine1 IS NOT NULL AND c.JEVaccine2 IS NOT NULL AND c.VitaminA3 IS NOT NULL AND c.VitaminA4 IS NOT NULL AND c.VitaminA5 IS NOT NULL AND c.VitaminA6 IS NOT NULL AND c.VitaminA7 IS NOT NULL AND c.VitaminA8 IS NOT NULL AND c.VitaminA9 IS NOT NULL AND c.TT2 IS NOT NULL
		)
		";

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and s.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and s.ServiceProviderID = " . $this->filter_data['Asha'];
		}

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and pw.PWRegistrationDate  > '" . $this->filter_data['date_from'] . "' and pw.PWRegistrationDate < '" . $this->filter_data['date_to'] . "'";
		}

		$this->child_full_immunization_count = $this->db->query($query)->result()[0]->total;
		return $this->child_full_immunization_count;

	}

	private function get_pregnant_woman_immunization_count()
	{
		if ($this->pregnant_woman_immunization_count != NULL) {
			return $this->pregnant_woman_immunization_count;
		}

		$query = "select 
		count(*) as total
		FROM tblpregnant_woman pw 
		inner join tblhhsurvey s 
		on pw.HHGUID = s.HHSurveyGUID
		where (TT1Date is not null or TT2Date is not null or TTBoosterDate is not null)";

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and s.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and s.ServiceProviderID = " . $this->filter_data['Asha'];
		}

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and pw.PWRegistrationDate  > '" . $this->filter_data['date_from'] . "' and pw.PWRegistrationDate < '" . $this->filter_data['date_to'] . "'";
		}

		$this->pregnant_woman_immunization_count = $this->db->query($query)->result()[0]->total;
		return $this->pregnant_woman_immunization_count;

	}

	private function get_total_mother_plus_child_count()
	{
		if ($this->child_count == NULL) {
			$this->get_child_count();
		}

		if ($this->pregnancies_registered_count == NULL) {
			$this->get_pregnancies_registered_count();
		}

		$result = $this->child_count + $this->pregnancies_registered_count;
		if ($result == 0) {
			$result = 1;
		}
		return $result;

	}

	private function get_child_count()
	{
		if ($this->child_count != NULL) {
			return $this->child_count;
		}

		$query = "select 
		count(*) as total
		FROM tblpregnant_woman pw 
		inner join tblhhsurvey s 
		on pw.HHGUID = s.HHSurveyGUID
		inner join tblchild c 
		on c.pw_GUID = pw.PWGUID
		where 1";

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and s.ANMID = " . $this->filter_data['ANM'];
		}

		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and s.ServiceProviderID = " . $this->filter_data['Asha'];
		}

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and pw.PWRegistrationDate  > '" . $this->filter_data['date_from'] . "' and pw.PWRegistrationDate < '" . $this->filter_data['date_to'] . "'";
		}

		$result = $this->db->query($query)->result()[0]->total;
		if ($result == 0) {
			$result = 1;
		}
		$this->child_count = $result;
		return $this->child_count;

	}

	public function get_household_trend()
	{
		$this->filter_data = $this->session->userdata("filter_data");

		$query = "select count(*) as total, 
		month(CreatedOn) as month
		from tblhhsurvey 
		where 1";

		if ($this->filter_data['ANM'] != NULL) 
		{
			$query .= " and ANMID = " . $this->filter_data['ANM'];
		}


		if ($this->filter_data['Asha'] != NULL) 
		{
			$query .= " and ServiceProviderID = " . $this->filter_data['Asha'];
		}

/*
			$date_from = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-12 month" ) );
			$date_to = date("Y-m-d");*/

			$query .= " and CreatedOn < CURRENT_DATE and CreatedOn > CURRENT_DATE - INTERVAL 1 YEAR";

			$query .= " group by month(CreatedOn) order by month(CreatedOn) asc";

			$result = $this->db->query($query)->result();

			$currYearMonth = date("m");
			$prevYearMonth = date("m") + 1;
			
			for ($i = $prevYearMonth; $i <= 12; $i++) { 
				$monthcount[$i] = 0;
			}
			for ($i=1; $i <= $currYearMonth ; $i++) { 
				$monthcount[$i] = 0;
			}

			foreach ($result as $row) {
				if (in_array($row->month, array_keys($monthcount))) {
					$monthcount[$row->month] = $row->total;
				}
			}

			return $monthcount;

		}

		public function get_pregnancy_registration_trend()
		{
			$this->filter_data = $this->session->userdata("filter_data");

			$query = "select
			count(*) as total, 
			month(pw.PWRegistrationDate) as month 
			FROM tblpregnant_woman pw 
			inner join tblhhsurvey s 
			on pw.HHGUID = s.HHSurveyGUID
			where pw.IsPregnant = 1";

			if ($this->filter_data['ANM'] != NULL) 
			{
				$query .= " and s.ANMID = " . $this->filter_data['ANM'];
			}


			if ($this->filter_data['Asha'] != NULL) 
			{
				$query .= " and s.ServiceProviderID = " . $this->filter_data['Asha'];
			}

/*			$date_from = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-12 month" ) );
			$date_to = date("Y-m-d");
*/
			$query .= " and pw.PWRegistrationDate < CURRENT_DATE and pw.PWRegistrationDate > CURRENT_DATE - INTERVAL 1 YEAR";

			$query .= " group by month(pw.PWRegistrationDate) order by month(pw.PWRegistrationDate) asc";

			$result = $this->db->query($query)->result();

			$currYearMonth = date("m");
			$prevYearMonth = date("m") + 1;

			for ($i = $prevYearMonth; $i <= 12; $i++) { 
				$monthcount[$i] = 0;
			}
			for ($i=1; $i <= $currYearMonth ; $i++) { 
				$monthcount[$i] = 0;
			}

			foreach ($result as $row) {
				if (in_array($row->month, array_keys($monthcount))) {
					$monthcount[$row->month] = $row->total;
				}
			}

			return $monthcount;

		}

		public function get_child_registration_trend()
		{
			$this->filter_data = $this->session->userdata("filter_data");

			$query = "select
			count(*) as total, 
			month(c.child_dob) as month 
			FROM tblpregnant_woman pw 
			inner join tblhhsurvey s 
			on pw.HHGUID = s.HHSurveyGUID
			inner join tblchild c 
			on c.pw_GUID = pw.PWGUID";

			if ($this->filter_data['ANM'] != NULL) 
			{
				$query .= " and s.ANMID = " . $this->filter_data['ANM'];
			}


			if ($this->filter_data['Asha'] != NULL) 
			{
				$query .= " and s.ServiceProviderID = " . $this->filter_data['Asha'];
			}


/*			$date_from = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-12 month" ) );
			$date_to = date("Y-m-d");
*/
			$query .= " and c.child_dob < CURRENT_DATE and c.child_dob > CURRENT_DATE - INTERVAL 1 YEAR";

			$query .= " group by month(c.child_dob) order by month(c.child_dob) asc";

			$result = $this->db->query($query)->result();

			$currYearMonth = date("m");
			$prevYearMonth = date("m") + 1;

			for ($i = $prevYearMonth; $i <= 12; $i++) { 
				$monthcount[$i] = 0;
			}
			for ($i=1; $i <= $currYearMonth ; $i++) { 
				$monthcount[$i] = 0;
			}

			foreach ($result as $row) {
				if (in_array($row->month, array_keys($monthcount))) {
					$monthcount[$row->month] = $row->total;
				}
			}

			return $monthcount;

		}

		public function get_child_immunization_trend()
		{
			$this->filter_data = $this->session->userdata("filter_data");

			$query = "select
			count(*) as total, 
			month(c.child_dob) as month 
			FROM tblpregnant_woman pw 
			inner join tblhhsurvey s 
			on pw.HHGUID = s.HHSurveyGUID
			inner join tblchild c 
			on c.pw_GUID = pw.PWGUID
			WHERE (
			c.bcg is not null 
			or c.opv1 is not null
			or c.dpt1 is not null
			or c.hepb1 is not null
			or c.opv2 is not null
			or c.dpt2 is not null
			or c.hepb2 is not null
			or c.opv3 is not null
			or c.dpt3 is not null
			or c.hepb3 is not null
			or c.measeals is not null
			or c.vitaminA is not null
			or c.opv4 is not null
			or c.hepb4 is not null
			or c.Pentavalent1 is not null
			or c.Pentavalent2 is not null
			or c.Pentavalent3 is not null
			or c.IPV is not null
			or c.DPTBooster is not null
			or c.OPVBooster is not null
			or c.MeaslesTwoDose is not null
			or c.VitaminAtwo is not null
			or c.DPTBoostertwo is not null
			or c.ChildTT is not null
			or c.JEVaccine1 is not null
			or c.JEVaccine2 is not null
			or c.VitaminA3 is not null
			or c.VitaminA4 is not null
			or c.VitaminA5 is not null
			or c.VitaminA6 is not null
			or c.VitaminA7 is not null
			or c.VitaminA8 is not null
			or c.VitaminA9 is not null
			or c.TT2 is not null
			)";

			if ($this->filter_data['ANM'] != NULL) 
			{
				$query .= " and s.ANMID = " . $this->filter_data['ANM'];
			}


			if ($this->filter_data['Asha'] != NULL) 
			{
				$query .= " and s.ServiceProviderID = " . $this->filter_data['Asha'];
			}

			/*$date_from = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-12 month" ) );
			$date_to = date("Y-m-d");*/

			$query .= " and c.child_dob < CURRENT_DATE and c.child_dob > CURRENT_DATE - INTERVAL 1 YEAR";

			$query .= " group by month(c.child_dob) order by month(c.child_dob) asc";

			$result = $this->db->query($query)->result();

			$currYearMonth = date("m");
			$prevYearMonth = date("m") + 1;

			for ($i = $prevYearMonth; $i <= 12; $i++) { 
				$monthcount[$i] = 0;
			}
			for ($i=1; $i <= $currYearMonth ; $i++) { 
				$monthcount[$i] = 0;
			}

			foreach ($result as $row) {
				if (in_array($row->month, array_keys($monthcount))) {
					$monthcount[$row->month] = $row->total;
				}
			}

			return $monthcount;

		}

		private function get_trend_anc_visit()
		{
			$this->filter_data = $this->session->userdata("filter_data");

			$query = "select
			count(*) as total, 
			month(pw.PWRegistrationDate) as month 
			FROM tblpregnant_woman pw 
			inner join tblhhsurvey s 
			on pw.HHGUID = s.HHSurveyGUID
			inner join tblancvisit v 
			on v.PWGUID = pw.PWGUID
			where pw.IsPregnant = 1";

			if ($this->filter_data['ANM'] != NULL) 
			{
				$query .= " and s.ANMID = " . $this->filter_data['ANM'];
			}


			if ($this->filter_data['Asha'] != NULL) 
			{
				$query .= " and s.ServiceProviderID = " . $this->filter_data['Asha'];
			}

/*
			$date_from = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-12 month" ) );
			$date_to = date("Y-m-d");*/
			
			$query .= " and pw.PWRegistrationDate < CURRENT_DATE and pw.PWRegistrationDate > CURRENT_DATE - INTERVAL 1 YEAR";

			$query .= " group by month(pw.PWRegistrationDate) order by month(pw.PWRegistrationDate) asc";

			$result = $this->db->query($query)->result();

			$currYearMonth = date("m");
			$prevYearMonth = date("m") + 1;

			for ($i = $prevYearMonth; $i <= 12; $i++) { 
				$monthcount[$i] = 0;
			}
			for ($i=1; $i <= $currYearMonth ; $i++) { 
				$monthcount[$i] = 0;
			}

			foreach ($result as $row) {
				if (in_array($row->month, array_keys($monthcount))) {
					$monthcount[$row->month] = $row->total;
				}
			}

			return $monthcount;
		}

		private function get_trend_pnc_visit()
		{
			$this->filter_data = $this->session->userdata("filter_data");

			$query = "select
			count(*) as total, 
			month(pw.PWRegistrationDate) as month 
			FROM tblpregnant_woman pw 
			inner join tblhhsurvey s 
			on pw.HHGUID = s.HHSurveyGUID
			inner join tblpnchomevisit_ans v
			on v.PWGUID = pw.PWGUID";

			if ($this->filter_data['ANM'] != NULL) 
			{
				$query .= " and s.ANMID = " . $this->filter_data['ANM'];
			}


			if ($this->filter_data['Asha'] != NULL) 
			{
				$query .= " and s.ServiceProviderID = " . $this->filter_data['Asha'];
			}

/*
			$date_from = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-12 month" ) );
			$date_to = date("Y-m-d");*/

			$query .= " and pw.PWRegistrationDate < CURRENT_DATE and pw.PWRegistrationDate > CURRENT_DATE - INTERVAL 1 YEAR";

			$query .= " group by month(pw.PWRegistrationDate) order by month(pw.PWRegistrationDate) asc";

			$result = $this->db->query($query)->result();

			$currYearMonth = date("m");
			$prevYearMonth = date("m") + 1;

			for ($i = $prevYearMonth; $i <= 12; $i++) { 
				$monthcount[$i] = 0;
			}
			for ($i=1; $i <= $currYearMonth ; $i++) { 
				$monthcount[$i] = 0;
			}

			foreach ($result as $row) {
				if (in_array($row->month, array_keys($monthcount))) {
					$monthcount[$row->month] = $row->total;
				}
			}

			return $monthcount;
		}

		private function get_trend_immunization_counselling()
		{
			$this->filter_data = $this->session->userdata("filter_data");

			$query = "select
			count(*) as total, 
			month(pw.PWRegistrationDate) as month 
			FROM tblpregnant_woman pw 
			inner join tblhhsurvey s 
			on pw.HHGUID = s.HHSurveyGUID
			inner join tblchild c 
			on c.pw_GUID = pw.PWGUID
			inner join tblmstimmunizationans i 
			on i.ChildGUID = c.childGUID";

			if ($this->filter_data['ANM'] != NULL) 
			{
				$query .= " and s.ANMID = " . $this->filter_data['ANM'];
			}


			if ($this->filter_data['Asha'] != NULL) 
			{
				$query .= " and s.ServiceProviderID = " . $this->filter_data['Asha'];
			}


	/*		$date_from = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-12 month" ) );
	$date_to = date("Y-m-d");*/

	$query .= " and pw.PWRegistrationDate < CURRENT_DATE and pw.PWRegistrationDate > CURRENT_DATE - INTERVAL 1 YEAR";

	$query .= " group by month(pw.PWRegistrationDate) order by month(pw.PWRegistrationDate) asc";

	$result = $this->db->query($query)->result();

	$currYearMonth = date("m");
	$prevYearMonth = date("m") + 1;

	for ($i = $prevYearMonth; $i <= 12; $i++) { 
		$monthcount[$i] = 0;
	}
	for ($i=1; $i <= $currYearMonth ; $i++) { 
		$monthcount[$i] = 0;
	}

	foreach ($result as $row) {
		if (in_array($row->month, array_keys($monthcount))) {
			$monthcount[$row->month] = $row->total;
		}
	}

	return $monthcount;
}

private function get_trend_fp_counselling()
{
	$this->filter_data = $this->session->userdata("filter_data");

	$query = "select count(*) as total, month(a.CreatedOn) as month from tblhhsurvey s 
	inner join tblhhfamilymember m 
	on s.HHUID = m.HHUID
	inner join 
	(select * from tblmstfpfdetail group by womenname_guid) a
	on a.womenname_guid = m.HHFamilyMemberGUID
	where 1";

	if ($this->filter_data['ANM'] != NULL) 
	{
		$query .= " and s.ANMID = " . $this->filter_data['ANM'];
	}

	if ($this->filter_data['Asha'] != NULL) 
	{
		$query .= " and s.ServiceProviderID = " . $this->filter_data['Asha'];
	}

	/*		$date_from = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-12 month" ) );
	$date_to = date("Y-m-d");*/

	$query .= " and  a.CreatedOn < CURRENT_DATE and a.CreatedOn > CURRENT_DATE - INTERVAL 1 YEAR";

	$query .= "	group by month(a.CreatedOn) order by month(a.CreatedOn) asc";

	$result = $this->db->query($query)->result();

	$currYearMonth = date("m");
	$prevYearMonth = date("m") + 1;

	for ($i = $prevYearMonth; $i <= 12; $i++) { 
		$monthcount[$i] = 0;
	}
	for ($i=1; $i <= $currYearMonth ; $i++) { 
		$monthcount[$i] = 0;
	}

	foreach ($result as $row) {
		if (in_array($row->month, array_keys($monthcount))) {
			$monthcount[$row->month] = $row->total;
		}
	}

	return $monthcount;
}

public function get_trend_statistics()
{
	$trends['trend_anc_visit'] = $this->get_trend_anc_visit();
	$trends['trend_pnc_visit'] = $this->get_trend_pnc_visit();
	$trends['trend_immunization_counselling'] = $this->get_trend_immunization_counselling();
	$trends['trend_fp_counselling'] = $this->get_trend_fp_counselling();

	return $trends;
}

public function update_summary_table()
{
	$content['household_trend'] = $this->get_household_trend();
	$content['pregnancy_registration_trend'] = $this->get_pregnancy_registration_trend();
	$content['child_registration_trend'] = $this->get_child_registration_trend();
	$content['child_immunization_trend'] = $this->get_child_immunization_trend();
	$content['trend_anc_visit'] = $this->get_trend_anc_visit();
	$content['trend_pnc_visit'] = $this->get_trend_pnc_visit();
	$content['trend_immunization_counselling'] = $this->get_trend_immunization_counselling();
	$content['trend_fp_counselling'] = $this->get_trend_fp_counselling();

	foreach ($content as $key => $value) {

		$updateArr = array(
			'summary_value' => json_encode($value), 
			);
		$this->db->where('summary_key', $key);
		$this->db->update('dashboard_summary', $updateArr);
	}

}



}
