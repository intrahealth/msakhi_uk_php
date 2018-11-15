p<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Graph extends Gov_Controller {

	private $from_date;
	private $to_date;

	public function __construct()
	{
		parent::__construct();
		$this->from_date = $this->session->userdata("from_date");
		$this->to_date = $this->session->userdata("to_date");
	}



	public function preg_women_reg_first_trimester()
	{

		if ($this->from_date != NULL && $this->to_date != NULL) {
			$query = "select COUNT(*) AS done
			FROM
			`tblpregnant_woman`
			WHERE
			Regwithin12weeks = 1 AND PWRegistrationDate BETWEEN STR_TO_DATE('".$this->from_date."',
			'%Y-%m-%d') AND STR_TO_DATE('".$this->to_date."',
			'%Y-%m-%d') and IsPregnant=1
			UNION ALL
			SELECT COUNT(*) AS done
			FROM
			`tblpregnant_woman`
			WHERE
			PWRegistrationDate BETWEEN STR_TO_DATE('".$this->from_date."',
			'%Y-%m-%d') AND STR_TO_DATE('".$this->to_date."',
			'%Y-%m-%d')
			and IsPregnant=1";
		}else{
			$query = "select COUNT(*) AS done
			FROM
			`tblpregnant_woman`
			WHERE
			Regwithin12weeks = 1
			and IsPregnant=1
			UNION ALL
			SELECT COUNT(*) AS done
			FROM
			`tblpregnant_woman` where IsPregnant=1";
		}

		$resultSet = $this->db->query($query)->result();

		$numenator = $resultSet[0]->done;
		$content['numenator'] = $numenator;
		$content['numenator_description'] = "Number of Women registered within first trimster";

		$total = $resultSet[1]->done;
		$complement = $total - $numenator;
		$content['denominator'] = $complement;
		$content['denominator_description'] = "Number of Women not registered within first trimster";

		$content['heading'] = "Proportion of Pregnant Women Registered in the First Trimester";
		$content['indicator'] = 'preg_women_reg_first_trimester';
		$content['subview'] = 'graph';
		$this->load->view('gov/main_layout', $content);
	}

	public function one_anc_checkup()
	{	

		if ($this->from_date != NULL && $this->to_date != NULL) {
			$query = "
			select count(*) as done from 
			(
			SELECT v.AncVisitID FROM tblancvisit v
			inner join tblpregnant_woman pw
			on v.PWGUID = pw.PWGUID
			where v.CheckupVisitDate is not null
			and pw.PWRegistrationDate between STR_TO_DATE('".$this->from_date."', '%Y-%m-%d') and  STR_TO_DATE('".$this->to_date."', '%Y-%m-%d') and IsPregnant=1
			group by v.PWGUID having count(*) = 1
			)a
			UNION ALL
			SELECT count(PWGUID) as done FROM `tblpregnant_woman` where PWRegistrationDate between STR_TO_DATE('".$this->from_date."', '%Y-%m-%d') and  STR_TO_DATE('".$this->to_date."', '%Y-%m-%d') and IsPregnant = 1";
		}else{
			$query = "
			select count(*) as done from 
			(
			SELECT v.AncVisitID FROM tblancvisit v
			inner join tblpregnant_woman pw
			on v.PWGUID = pw.PWGUID
			where v.CheckupVisitDate is not null
			and IsPregnant=1
			group by v.PWGUID having count(*) = 1
			)a
			UNION ALL
			SELECT count(PWGUID) as done FROM `tblpregnant_woman` WHERE IsPregnant = 1";
		}

		$resultSet = $this->db->query($query)->result();

		$numenator = $resultSet[0]->done;
		$content['numenator'] = $numenator;
		$content['numenator_description'] = "Number of pregnant women with 1 ANC check-up";

		$total = $resultSet[1]->done;
		$complement = $total - $numenator;
		$content['denominator'] = $complement;
		$content['denominator_description'] = "Total Number of pregnant women";

		$content['heading'] = "Proportion of pregnant women with 1 ANC check-up";
		$content['indicator'] = "one_anc_checkup";
		$content['subview'] = 'graph';
		$this->load->view('gov/main_layout', $content);
	}

	public function two_anc_checkup()
	{	

		if ($this->from_date != NULL && $this->to_date != NULL) {
			$query = "
			select count(*) as done from 
			(
			SELECT v.AncVisitID FROM tblancvisit v
			inner join tblpregnant_woman pw
			on v.PWGUID = pw.PWGUID
			where v.CheckupVisitDate is not null
			and pw.PWRegistrationDate between STR_TO_DATE('".$this->from_date."', '%Y-%m-%d') and  STR_TO_DATE('".$this->to_date."', '%Y-%m-%d') and IsPregnant = 1
			group by v.PWGUID having count(*) = 2
			)a
			UNION ALL
			SELECT count(PWGUID) as done FROM `tblpregnant_woman` where PWRegistrationDate between STR_TO_DATE('".$this->from_date."', '%Y-%m-%d') and  STR_TO_DATE('".$this->to_date."', '%Y-%m-%d') and IsPregnant = 1";
		}else{
			$query = "
			select count(*) as done from 
			(
			SELECT v.AncVisitID FROM tblancvisit v
			inner join tblpregnant_woman pw
			on v.PWGUID = pw.PWGUID
			where v.CheckupVisitDate is not null 
			and IsPregnant = 1
			group by v.PWGUID having count(*) = 2
			)a
			UNION ALL
			SELECT count(PWGUID) as done FROM `tblpregnant_woman` WHERE IsPregnant = 1";
		}

		$resultSet = $this->db->query($query)->result();

		$numenator = $resultSet[0]->done;
		$content['numenator'] = $numenator;
		$content['numenator_description'] = "Number of pregnant women with 2 ANC check-up";

		$total = $resultSet[1]->done;
		$complement = $total - $numenator;
		$content['denominator'] = $complement;
		$content['denominator_description'] = "Total Number of pregnant women";

		$content['heading'] = "Proportion of pregnant women with 2 ANC check-up";
		$content['indicator'] = "two_anc_checkup";
		$content['subview'] = 'graph';
		$this->load->view('gov/main_layout', $content);
	}

	public function three_anc_checkup()
	{	

		if ($this->from_date != NULL && $this->to_date != NULL) {
			$query = "
			select count(*) as done from 
			(
			SELECT v.AncVisitID FROM tblancvisit v
			inner join tblpregnant_woman pw
			on v.PWGUID = pw.PWGUID
			where v.CheckupVisitDate is not null 
			and pw.PWRegistrationDate between STR_TO_DATE('".$this->from_date."', '%Y-%m-%d') and  STR_TO_DATE('".$this->to_date."', '%Y-%m-%d') and IsPregnant = 1
			group by v.PWGUID having count(*) = 3
			)a
			UNION ALL
			SELECT count(PWGUID) as done FROM `tblpregnant_woman` where PWRegistrationDate between STR_TO_DATE('".$this->from_date."', '%Y-%m-%d') and  STR_TO_DATE('".$this->to_date."', '%Y-%m-%d') and IsPregnant = 1";
		}else{
			$query = "
			select count(*) as done from 
			(
			SELECT v.AncVisitID FROM tblancvisit v
			inner join tblpregnant_woman pw
			on v.PWGUID = pw.PWGUID
			where v.CheckupVisitDate is not null
			and IsPregnant = 1
			group by v.PWGUID having count(*) = 3
			)a
			UNION ALL
			SELECT count(PWGUID) as done FROM `tblpregnant_woman` where IsPregnant = 1";
		}

		$resultSet = $this->db->query($query)->result();

		$numenator = $resultSet[0]->done;
		$content['numenator'] = $numenator;
		$content['numenator_description'] = "Number of pregnant women with 3 ANC check-up";

		$total = $resultSet[1]->done;
		$complement = $total - $numenator;
		$content['denominator'] = $complement;
		$content['denominator_description'] = "Total Number of pregnant women";

		$content['heading'] = "Proportion of pregnant women with 3 ANC check-up";
		$content['indicator'] = "three_anc_checkup";
		$content['subview'] = 'graph';
		$this->load->view('gov/main_layout', $content);
	}

	public function four_anc_checkup()
	{	

		if ($this->from_date != NULL && $this->to_date != NULL) {
			$query = "
			select count(*) as done from 
			(
			SELECT v.AncVisitID FROM tblancvisit v
			inner join tblpregnant_woman pw
			on v.PWGUID = pw.PWGUID
			where v.CheckupVisitDate is not null
			and pw.PWRegistrationDate between STR_TO_DATE('".$this->from_date."', '%Y-%m-%d') and  STR_TO_DATE('".$this->to_date."', '%Y-%m-%d') and IsPregnant = 1
			group by v.PWGUID having count(*) = 4
			)a
			UNION ALL
			SELECT count(PWGUID) as done FROM `tblpregnant_woman` where PWRegistrationDate between STR_TO_DATE('".$this->from_date."', '%Y-%m-%d') and  STR_TO_DATE('".$this->to_date."', '%Y-%m-%d') and IsPregnant = 1";
		}else{
			$query = "
			select count(*) as done from 
			(
			SELECT v.AncVisitID FROM tblancvisit v
			inner join tblpregnant_woman pw
			on v.PWGUID = pw.PWGUID
			where v.CheckupVisitDate is not null
			and IsPregnant = 1
			group by v.PWGUID having count(*) = 4
			)a
			UNION ALL
			SELECT count(PWGUID) as done FROM `tblpregnant_woman` WHERE IsPregnant = 1";
		}

		$resultSet = $this->db->query($query)->result();

		$numenator = $resultSet[0]->done;
		$content['numenator'] = $numenator;
		$content['numenator_description'] = "Number of pregnant women with 4 ANC check-up";

		$total = $resultSet[1]->done;
		$complement = $total - $numenator;
		$content['denominator'] = $complement;
		$content['denominator_description'] = "Total Number of pregnant women";

		$content['heading'] = "Proportion of pregnant women with 4 ANC check-up";
		$content['indicator'] = "four_anc_checkup";
		$content['subview'] = 'graph';
		$this->load->view('gov/main_layout', $content);
	}

	public function tt2_booster()
	{	

		if ($this->from_date != NULL && $this->to_date != NULL) {
			$query = "
			select count(*) as done from 
			(
			SELECT v.AncVisitID FROM tblancvisit v
			inner join tblpregnant_woman pw
			on v.PWGUID = pw.PWGUID
			where v.TT2=1 or v.TTbooster=1
			and pw.PWRegistrationDate between STR_TO_DATE('".$this->from_date."', '%Y-%m-%d') and  STR_TO_DATE('".$this->to_date."', '%Y-%m-%d')
			and IsPregnant = 1
			group by v.PWGUID having count(*) > 0
			)a
			UNION ALL
			SELECT count(*) as done FROM `tblpregnant_woman` where PWRegistrationDate between STR_TO_DATE('".$this->from_date."', '%Y-%m-%d') and  STR_TO_DATE('".$this->to_date."', '%Y-%m-%d') 
			and IsPregnant = 1";

		}else{
			$query = "
			select count(*) as done from 
			(
			SELECT v.AncVisitID FROM tblancvisit v
			inner join tblpregnant_woman pw
			on v.PWGUID = pw.PWGUID
			where v.TT2=1 or v.TTbooster=1
			and IsPregnant = 1
			group by v.PWGUID having count(*) > 0
			)a
			UNION ALL
			SELECT count(PWGUID) as done FROM `tblpregnant_woman` WHERE IsPregnant = 1";
		}
		$resultSet = $this->db->query($query)->result();

		$numenator = $resultSet[0]->done;
		$content['numenator'] = $numenator;
		$content['numenator_description'] = "Number of pregnant women who received  TT2  or Booster";

		$total = $resultSet[1]->done;
		$complement = $total - $numenator;
		$content['denominator'] = $complement;
		$content['denominator_description'] = "Total Number of pregnant women";

		$content['heading'] = "Proportion of pregnant women who received  TT2  or Booster";
		$content['indicator'] = "tt2_booster";
		$content['subview'] = 'graph';
		$this->load->view('gov/main_layout', $content);
	}

	public function institutional_delivery()
	{	

		if ($this->from_date != NULL && $this->to_date != NULL) {
			$query = "
			select count(*) as done from 
			(
			SELECT PWGUID from tblpregnant_woman w 
			inner join tblchild c 
			on w.PWGUID = c.pw_GUID
			where  c.place_of_birth = 2
			and w.PWRegistrationDate between STR_TO_DATE('".$this->from_date."', '%Y-%m-%d') and  STR_TO_DATE('".$this->to_date."', '%Y-%m-%d')
			)a
			UNION ALL
			SELECT count(PWGUID) as done FROM `tblpregnant_woman` where PWRegistrationDate between STR_TO_DATE('".$this->from_date."', '%Y-%m-%d') and  STR_TO_DATE('".$this->to_date."', '%Y-%m-%d')";
		}else{
			$query = "
			select count(*) as done from 
			(
			SELECT PWGUID from tblpregnant_woman w 
			inner join tblchild c 
			on w.PWGUID = c.pw_GUID
			where  c.place_of_birth = 2
			)a
			UNION ALL
			SELECT count(PWGUID) as done FROM `tblpregnant_woman`";
		}

		$resultSet = $this->db->query($query)->result();

		$numenator = $resultSet[0]->done;
		$content['numenator'] = $numenator;
		$content['numenator_description'] = "Number of pregnant women with institutional delivery";

		$total = $resultSet[1]->done;
		$complement = $total - $numenator;
		$content['denominator'] = $complement;
		$content['denominator_description'] = "Total Number of pregnant women";

		$content['heading'] = "Proportion of institutional deliveries";
		$content['indicator'] = "institutional_delivery";
		$content['subview'] = 'graph';
		$this->load->view('gov/main_layout', $content);
	}

	public function newborns_visited_two_or_more_times()
	{	
		if ($this->from_date != NULL && $this->to_date != NULL) {
			$query = "
			select count(*) as done from 
			(
			SELECT v.AncVisitID FROM tblancvisit v
			inner join tblpregnant_woman pw
			on v.PWGUID = pw.PWGUID
			inner join tblchild c 
			on c.pw_GUID = pw.PWGUID
			where v.CheckupVisitDate BETWEEN c.child_dob and DATE_ADD(c.child_dob, INTERVAL 7 day)
			and pw.PWRegistrationDate between STR_TO_DATE('".$this->from_date."', '%Y-%m-%d') and  STR_TO_DATE('".$this->to_date."', '%Y-%m-%d')
			group by v.PWGUID having count(*) > 2
			)a
			UNION ALL
			SELECT count(PWGUID) as done FROM `tblpregnant_woman` where PWRegistrationDate between STR_TO_DATE('".$this->from_date."', '%Y-%m-%d') and  STR_TO_DATE('".$this->to_date."', '%Y-%m-%d')";

		}else{
			$query = "
			select count(*) as done from 
			(
			SELECT v.AncVisitID FROM tblancvisit v
			inner join tblpregnant_woman pw
			on v.PWGUID = pw.PWGUID
			INNER JOIN tblchild c 
			on c.pw_GUID = pw.PWGUID
			where v.CheckupVisitDate BETWEEN c.child_dob and DATE_ADD(c.child_dob, INTERVAL 7 day)
			group by v.PWGUID having count(*) > 2
			)a
			UNION ALL
			SELECT count(PWGUID) as done FROM `tblpregnant_woman`";
		}

		$resultSet = $this->db->query($query)->result();

		$numenator = $resultSet[0]->done;
		$content['numenator'] = $numenator;
		$content['numenator_description'] = "Number of pregnant women with Newborns visited by ASHA";

		$total = $resultSet[1]->done;
		$complement = $total - $numenator;
		$content['denominator'] = $complement;
		$content['denominator_description'] = "Total Number of Newborns";


		$content['heading'] = "Newborns visited by ASHA at least two  or more times within first seven days";
		$content['indicator'] = "newborns_visited_two_or_more_times";
		$content['subview'] = 'graph';
		$this->load->view('gov/main_layout', $content);
	}

	public function newborns_visited_three_or_more_times_home_delivery()
	{	
		if ($this->from_date != NULL && $this->to_date != NULL) {
			$query = "
			select COUNT(*) AS done
			FROM
			(
			SELECT
			v.AncVisitID
			FROM
			tblancvisit v
			INNER JOIN
			tblpregnant_woman pw ON v.PWGUID = pw.PWGUID
			INNER JOIN
			tblchild c ON c.pw_GUID = pw.PWGUID
			WHERE
			v.CheckupVisitDate BETWEEN c.child_dob AND DATE_ADD(c.child_dob,
			INTERVAL 7 DAY) AND c.place_of_birth = 1 AND pw.PWRegistrationDate BETWEEN STR_TO_DATE('".$this->from_date."',
			'%Y-%m-%d') AND STR_TO_DATE('".$this->to_date."',
			'%Y-%m-%d')
			GROUP BY
			v.PWGUID
			HAVING COUNT(*) > 3
			) a
			UNION ALL
			SELECT COUNT(PWGUID) AS done
			FROM
			`tblpregnant_woman`
			WHERE
			PWRegistrationDate BETWEEN STR_TO_DATE('".$this->from_date."',
			'%Y-%m-%d') AND STR_TO_DATE('".$this->to_date."',
			'%Y-%m-%d')";

		}else{
			$query = "
			select COUNT(*) AS done
			FROM
			(
			SELECT
			v.AncVisitID
			FROM
			tblancvisit v
			INNER JOIN
			tblpregnant_woman pw ON v.PWGUID = pw.PWGUID
			INNER JOIN
			tblchild c ON c.pw_GUID = pw.PWGUID
			WHERE
			v.CheckupVisitDate BETWEEN c.child_dob AND DATE_ADD(c.child_dob,
			INTERVAL 7 DAY) AND c.place_of_birth = 1
			GROUP BY
			v.PWGUID
			HAVING COUNT(*) > 3
			) a
			UNION ALL
			SELECT COUNT(PWGUID) AS done
			FROM
			`tblpregnant_woman`";
		}


		$resultSet = $this->db->query($query)->result();

		$numenator = $resultSet[0]->done;
		$content['numenator'] = $numenator;
		$content['numenator_description'] = "Number of pregnant women with Newborns visited three or more times by ASHA";

		$total = $resultSet[1]->done;
		$complement = $total - $numenator;
		$content['denominator'] = $complement;
		$content['denominator_description'] = "Total Number of Newborns";
		
		$content['heading'] = "Newborns visited by ASHA at least three  or more times within first seven days of home delivery";
		$content['indicator'] = "newborns_visited_three_or_more_times_home_delivery";
		$content['subview'] = 'graph';
		$this->load->view('gov/main_layout', $content);
	}

	public function newborns_visited_two_or_more_times_instituional()
	{	

		if ($this->from_date != NULL && $this->to_date != NULL) {
			$query = "
			select count(*) as done from 
			(
			SELECT v.AncVisitID FROM tblancvisit v
			inner join tblpregnant_woman pw
			on v.PWGUID = pw.PWGUID
			inner join tblchild c 
			on c.pw_GUID = pw.PWGUID
			where v.CheckupVisitDate BETWEEN c.child_dob and DATE_ADD(c.child_dob, INTERVAL 7 day)
			and c.place_of_birth = 2
			and pw.PWRegistrationDate between STR_TO_DATE('".$this->from_date."', '%Y-%m-%d') and  STR_TO_DATE('".$this->to_date."', '%Y-%m-%d')
			group by v.PWGUID having count(*) > 2
			)a
			UNION ALL
			SELECT count(PWGUID) as done FROM `tblpregnant_woman` where PWRegistrationDate between STR_TO_DATE('".$this->from_date."', '%Y-%m-%d') and  STR_TO_DATE('".$this->to_date."', '%Y-%m-%d')";

		}else{
			$query = "
			select count(*) as done from 
			(
			SELECT v.AncVisitID FROM tblancvisit v
			inner join tblpregnant_woman pw
			on v.PWGUID = pw.PWGUID
			INNER JOIN tblchild c 
			on c.pw_GUID = pw.PWGUID
			where v.CheckupVisitDate BETWEEN c.child_dob and DATE_ADD(c.child_dob, INTERVAL 7 day)
			and c.place_of_birth = 2
			group by v.PWGUID having count(*) > 2
			)a
			UNION ALL
			SELECT count(PWGUID) as done FROM `tblpregnant_woman`";
		}
		
		$resultSet = $this->db->query($query)->result();

		$numenator = $resultSet[0]->done;
		$content['numenator'] = $numenator;
		$content['numenator_description'] = "Number of Newborns visited by ASHA first seven days of institutional delivery";

		$total = $resultSet[1]->done;
		$complement = $total - $numenator;
		$content['denominator'] = $complement;
		$content['denominator_description'] = "Total Number of Newborns";
		$content['heading'] = "Newborns visited by ASHA at least two  or more times within first seven days of institutional delivery";
		$content['indicator'] = "newborns_visited_two_or_more_times_instituional";
		$content['subview'] = 'graph';
		$this->load->view('gov/main_layout', $content);
	}

	public function low_birth_weight()
	{	

		if ($this->from_date != NULL && $this->to_date != NULL) {
			$query = "
			select count(*) as done from 
			(
			SELECT w.PWGUID from tblchild c 
			inner join tblpregnant_woman w 
			on c.pw_GUID = w.PWGUID
			where  c.Wt_of_child < 2.5
			and w.PWRegistrationDate between STR_TO_DATE('".$this->from_date."', '%Y-%m-%d') and  STR_TO_DATE('".$this->to_date."', '%Y-%m-%d')
			)a
			UNION ALL
			select count(*) as done from 
			(
			SELECT w.PWGUID from tblchild c 
			inner join tblpregnant_woman w 
			on c.pw_GUID = w.PWGUID
			where w.PWRegistrationDate between STR_TO_DATE('".$this->from_date."', '%Y-%m-%d') and  STR_TO_DATE('".$this->to_date."', '%Y-%m-%d')
			)b
			";
		}else{
			$query = "
			select count(*) as done from 
			(
			SELECT w.PWGUID from tblchild c 
			inner join tblpregnant_woman w 
			on c.pw_GUID = w.PWGUID
			where  c.Wt_of_child < 2.5)a
			UNION ALL
			SELECT count(*) as done FROM (SELECT w.PWGUID from tblchild c 
			inner join tblpregnant_woman w 
			on c.pw_GUID = w.PWGUID)b";
		}

		$resultSet = $this->db->query($query)->result();

		$numenator = $resultSet[0]->done;
		$content['numenator'] = $numenator;
		$content['numenator_description'] = "Number of Children with low birth weight";

		$total = $resultSet[1]->done;
		$complement = $total - $numenator;
		$content['denominator'] = $complement;
		$content['denominator_description'] = "Total Number Delivered Children";

		$content['indicator'] = "low_birth_weight";
		$content['heading'] = "Low Birth Weight";
		$content['subview'] = 'graph';
		$this->load->view('gov/main_layout', $content);
	}

}
