<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Graph extends CI_Controller {

	private $from_date;
	private $to_date;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Common_Model');
		$this->from_date = $this->session->userdata("from_date");
		$this->to_date = $this->session->userdata("to_date");
	}

	public function preg_women_reg_first_trimester()
	{

		if ($this->from_date != NULL && $this->to_date != NULL) {
			$query = "SELECT count(*) as done FROM `tblpregnant_woman`
			 where Regwithin12weeks=1
			 and PWRegistrationDate between STR_TO_DATE('".$this->from_date."', '%Y-%m-%d') and  STR_TO_DATE('".$this->to_date."', '%Y-%m-%d')
			UNION 
			SELECT count(*) as done FROM `tblpregnant_woman` 
			where PWRegistrationDate between STR_TO_DATE('".$this->from_date."', '%Y-%m-%d') and  STR_TO_DATE('".$this->to_date."', '%Y-%m-%d')";
		}else{
			$query = "SELECT count(*) as done FROM `tblpregnant_woman`
			 where Regwithin12weeks=1
			UNION 
			SELECT count(*) as done FROM `tblpregnant_woman`";
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
		$this->load->view('public/main_layout', $content);
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
	        and pw.PWRegistrationDate between STR_TO_DATE('".$this->from_date."', '%Y-%m-%d') and  STR_TO_DATE('".$this->to_date."', '%Y-%m-%d')
	        group by v.PWGUID having count(*) = 1
			)a
			UNION 
			SELECT count(PWGUID) as done FROM `tblpregnant_woman` where PWRegistrationDate between STR_TO_DATE('".$this->from_date."', '%Y-%m-%d') and  STR_TO_DATE('".$this->to_date."', '%Y-%m-%d')";
		}else{
			$query = "
			select count(*) as done from 
			(
			SELECT v.AncVisitID FROM tblancvisit v
	        inner join tblpregnant_woman pw
	        on v.PWGUID = pw.PWGUID
	        where v.CheckupVisitDate is not null
	        group by v.PWGUID having count(*) = 1
			)a
			UNION 
			SELECT count(PWGUID) as done FROM `tblpregnant_woman`";
		}

		$resultSet = $this->db->query($query)->result();

		$numenator = $resultSet[0]->done;
		$content['numenator'] = $numenator;
		$content['numenator_description'] = "Number of pregnant women with 1 ANC check-up";

		$total = $resultSet[1]->done;
		$complement = $total - $numenator;
		$content['denominator'] = $complement;
		$content['denominator_description'] = "Total Nmber of pregnant women";

		$content['heading'] = "Proportion of pregnant women with 1 ANC check-up";
		$content['indicator'] = "one_anc_checkup";
		$content['subview'] = 'graph';
		$this->load->view('public/main_layout', $content);
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
	        and pw.PWRegistrationDate between STR_TO_DATE('".$this->from_date."', '%Y-%m-%d') and  STR_TO_DATE('".$this->to_date."', '%Y-%m-%d')
	        group by v.PWGUID having count(*) = 2
			)a
			UNION 
			SELECT count(PWGUID) as done FROM `tblpregnant_woman` where PWRegistrationDate between STR_TO_DATE('".$this->from_date."', '%Y-%m-%d') and  STR_TO_DATE('".$this->to_date."', '%Y-%m-%d')";
		}else{
			$query = "
			select count(*) as done from 
			(
			SELECT v.AncVisitID FROM tblancvisit v
	        inner join tblpregnant_woman pw
	        on v.PWGUID = pw.PWGUID
	        where v.CheckupVisitDate is not null
	        group by v.PWGUID having count(*) = 2
			)a
			UNION 
			SELECT count(PWGUID) as done FROM `tblpregnant_woman`";
		}

		$resultSet = $this->db->query($query)->result();

		$numenator = $resultSet[0]->done;
		$content['numenator'] = $numenator;
		$content['numenator_description'] = "Number of pregnant women with 2 ANC check-up";

		$total = $resultSet[1]->done;
		$complement = $total - $numenator;
		$content['denominator'] = $complement;
		$content['denominator_description'] = "Total Nmber of pregnant women";

		$content['heading'] = "Proportion of pregnant women with 2 ANC check-up";
		$content['indicator'] = "two_anc_checkup";
		$content['subview'] = 'graph';
		$this->load->view('public/main_layout', $content);
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
	        and pw.PWRegistrationDate between STR_TO_DATE('".$this->from_date."', '%Y-%m-%d') and  STR_TO_DATE('".$this->to_date."', '%Y-%m-%d')
	        group by v.PWGUID having count(*) = 3
			)a
			UNION 
			SELECT count(PWGUID) as done FROM `tblpregnant_woman` where PWRegistrationDate between STR_TO_DATE('".$this->from_date."', '%Y-%m-%d') and  STR_TO_DATE('".$this->to_date."', '%Y-%m-%d')";
		}else{
			$query = "
			select count(*) as done from 
			(
			SELECT v.AncVisitID FROM tblancvisit v
	        inner join tblpregnant_woman pw
	        on v.PWGUID = pw.PWGUID
	        where v.CheckupVisitDate is not null
	        group by v.PWGUID having count(*) = 3
			)a
			UNION 
			SELECT count(PWGUID) as done FROM `tblpregnant_woman`";
		}

		$resultSet = $this->db->query($query)->result();

		$numenator = $resultSet[0]->done;
		$content['numenator'] = $numenator;
		$content['numenator_description'] = "Number of pregnant women with 3 ANC check-up";

		$total = $resultSet[1]->done;
		$complement = $total - $numenator;
		$content['denominator'] = $complement;
		$content['denominator_description'] = "Total Nmber of pregnant women";

		$content['heading'] = "Proportion of pregnant women with 3 ANC check-up";
		$content['indicator'] = "three_anc_checkup";
		$content['subview'] = 'graph';
		$this->load->view('public/main_layout', $content);
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
	        and pw.PWRegistrationDate between STR_TO_DATE('".$this->from_date."', '%Y-%m-%d') and  STR_TO_DATE('".$this->to_date."', '%Y-%m-%d')
	        group by v.PWGUID having count(*) = 4
			)a
			UNION 
			SELECT count(PWGUID) as done FROM `tblpregnant_woman` where PWRegistrationDate between STR_TO_DATE('".$this->from_date."', '%Y-%m-%d') and  STR_TO_DATE('".$this->to_date."', '%Y-%m-%d')";
		}else{
			$query = "
			select count(*) as done from 
			(
			SELECT v.AncVisitID FROM tblancvisit v
	        inner join tblpregnant_woman pw
	        on v.PWGUID = pw.PWGUID
	        where v.CheckupVisitDate is not null
	        group by v.PWGUID having count(*) = 4
			)a
			UNION 
			SELECT count(PWGUID) as done FROM `tblpregnant_woman`";
		}

		$resultSet = $this->db->query($query)->result();

		$numenator = $resultSet[0]->done;
		$content['numenator'] = $numenator;
		$content['numenator_description'] = "Number of pregnant women with 4 ANC check-up";

		$total = $resultSet[1]->done;
		$complement = $total - $numenator;
		$content['denominator'] = $complement;
		$content['denominator_description'] = "Total Nmber of pregnant women";

		$content['heading'] = "Proportion of pregnant women with 4 ANC check-up";
		$content['indicator'] = "four_anc_checkup";
		$content['subview'] = 'graph';
		$this->load->view('public/main_layout', $content);
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
	        group by v.PWGUID having count(*) > 0
			)a
			UNION 
			SELECT count(*) as done FROM `tblpregnant_woman` where PWRegistrationDate between STR_TO_DATE('".$this->from_date."', '%Y-%m-%d') and  STR_TO_DATE('".$this->to_date."', '%Y-%m-%d')";
		}else{
			$query = "
			select count(*) as done from 
			(
			SELECT v.AncVisitID FROM tblancvisit v
	        inner join tblpregnant_woman pw
	        on v.PWGUID = pw.PWGUID
	        where v.TT2=1 or v.TTbooster=1
	        group by v.PWGUID having count(*) > 0
			)a
			UNION 
			SELECT count(PWGUID) as done FROM `tblpregnant_woman`";
		}

		$resultSet = $this->db->query($query)->result();

		$numenator = $resultSet[0]->done;
		$content['numenator'] = $numenator;
		$content['numenator_description'] = "Number of pregnant women who received  TT2  or Booster";

		$total = $resultSet[1]->done;
		$complement = $total - $numenator;
		$content['denominator'] = $complement;
		$content['denominator_description'] = "Total Nmber of pregnant women";

		$content['heading'] = "Proportion of pregnant women who received  TT2  or Booster";
		$content['indicator'] = "tt2_booster";
		$content['subview'] = 'graph';
		$this->load->view('public/main_layout', $content);
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
			where  c.place_of_birth = 1
			and w.PWRegistrationDate between STR_TO_DATE('".$this->from_date."', '%Y-%m-%d') and  STR_TO_DATE('".$this->to_date."', '%Y-%m-%d')
			)a
			UNION 
			SELECT count(PWGUID) as done FROM `tblpregnant_woman` where PWRegistrationDate between STR_TO_DATE('".$this->from_date."', '%Y-%m-%d') and  STR_TO_DATE('".$this->to_date."', '%Y-%m-%d')";
		}else{
			$query = "
			select count(*) as done from 
			(
				SELECT PWGUID from tblpregnant_woman w 
			inner join tblchild c 
            on w.PWGUID = c.pw_GUID
			where  c.place_of_birth = 1
			)a
			UNION 
			SELECT count(PWGUID) as done FROM `tblpregnant_woman`";
		}

		$resultSet = $this->db->query($query)->result();

		$numenator = $resultSet[0]->done;
		$content['numenator'] = $numenator;
		$content['numenator_description'] = "Number of pregnant women with institutional delivery";

		$total = $resultSet[1]->done;
		$complement = $total - $numenator;
		$content['denominator'] = $complement;
		$content['denominator_description'] = "Total Nmber of pregnant women";

		$content['heading'] = "Proportion of institutional deliveries";
		$content['indicator'] = "institutional_delivery";
		$content['subview'] = 'graph';
		$this->load->view('public/main_layout', $content);
	}

	public function newborns_visited_two_or_more_times()
	{	
		$content['heading'] = "Newborns visited by ASHA at least two  or more times within first seven days";
		$content['subview'] = 'graph';
		$this->load->view('public/main_layout', $content);
	}

	public function newborns_visited_three_or_more_times()
	{	
		$content['heading'] = "Newborns visited by ASHA at least three  or more times within first seven days of home delivery";
		$content['subview'] = 'graph';
		$this->load->view('public/main_layout', $content);
	}

	public function newborns_visited_two_or_more_times_instituional()
	{	
		$content['heading'] = "Newborns visited by ASHA at least two  or more times within first seven days of institutional delivery";
		$content['subview'] = 'graph';
		$this->load->view('public/main_layout', $content);
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
			UNION 
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
			UNION 
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
		$content['denominator_description'] = "Total Nmber Delivered Children";

		$content['indicator'] = "low_birth_weight";
		$content['heading'] = "Low Birth Weight";
		$content['subview'] = 'graph';
		$this->load->view('public/main_layout', $content);
	}

}
