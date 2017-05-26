<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{


		$RequestMethod = $this->input->server('REQUEST_METHOD');
		if($RequestMethod == "POST")
		{

			$from_date = $this->input->post("from_date");
			$to_date = $this->input->post("to_date");

			$apply_filter = $this->input->post("apply_filter");
			$clear_filter = $this->input->post("clear_filter");

			if ($apply_filter ) 
			{
				$this->session->set_userdata("from_date", $from_date);
				$this->session->set_userdata("to_date", $to_date);

			}
			else if ($clear_filter != NULL) 
			{
				$this->session->unset_userdata("from_date");
				$this->session->unset_userdata("to_date");
			}

			
		}

		$query = "SELECT TIMESTAMPDIFF(MONTH,child_dob,now()) As childAgeInMonth from tblchild";
		$data = $this->Common_Model->query_data($query);
		$sixMonthAge=0;
		$sixMonthToOneYear=0;
		$twoyearAge=0;
		$oneToThreeYear=0;
		$fourToSixYear=0;
		$sixYearAge=0;
		for ($i=0; $i < count($data); $i++) { 
			$ageInMonth=$data[$i]->childAgeInMonth;
			if($ageInMonth<=6 && $ageInMonth >=0){
				$sixMonthAge=$sixMonthAge+1;
			} else if ($ageInMonth<=12 && $ageInMonth>=6) {
				$sixMonthToOneYear=$sixMonthToOneYear+1;
			}
			else if ($ageInMonth<=24 && $ageInMonth>=0) {
				$twoyearAge=$twoyearAge+1;
			}
			else if ($ageInMonth<=36 && $ageInMonth>=12) {
				$oneToThreeYear=$oneToThreeYear+1;
			}
			else if ($sixYearAge<=72 && $sixYearAge>=0) {
				$sixYearAge=$sixYearAge+1;
			}
			else if ($ageInMonth<=72 && $ageInMonth>=48) {
				$fourToSixYear=$fourToSixYear+1;
			}

		}

		$sqlQuery="SELECT COUNT(FamilyMemberName) as totalPopulation,
		(SELECT COUNT(FamilyMemberName) from tblhhfamilymember where AprilAgeYear BETWEEN 15 and 49 and GenderID=2 )
		as NumofWomenFifteentofortyNine ,
		(SELECT COUNT(FamilyMemberName) from tblhhfamilymember where AprilAgeYear BETWEEN 35 and 50  ) as AdultsAgeThirtyFiveToFifty ,
		(SELECT COUNT(FamilyMemberName) from tblhhfamilymember where AprilAgeYear >60  ) as AdultsAgeMorethanSixty ,
		( SELECT count(FamilyMemberName)   from tblhhfamilymember where AshaID!='' and GenderID=2) as totalPregnantWomen
		FROM tblhhfamilymember";

		/*print_r($sqlQuery); die();*/
		
		$content['from_date'] = $this->session->userdata("from_date");
		$content['to_date'] = $this->session->userdata("to_date");

		$content['pouplation'] = $this->Common_Model->query_data($sqlQuery);

		$content['ChildAgeInMonth_list']=array("zeroToSixMonth"=>$sixMonthAge,"sixToOneYear"=>$sixMonthToOneYear,"zeroToTwoYear"=>$twoyearAge,"oneToThreeYear"=>$oneToThreeYear,"zeroToSixYear"=>$sixYearAge,"fourToSixYear"=>$fourToSixYear);

		$content['prop_preg_first_trimster'] =  $this->prop_preg_first_trimster($content['from_date'], $content['to_date']);
		
		$content['prop_one_anc_checkup'] =  $this->prop_one_anc_checkup($content['from_date'], $content['to_date']);
		$content['prop_two_anc_checkup'] =  $this->prop_two_anc_checkup($content['from_date'], $content['to_date']);
		$content['prop_three_anc_checkup'] =  $this->prop_three_anc_checkup($content['from_date'], $content['to_date']);
		$content['prop_four_anc_checkup'] =  $this->prop_four_anc_checkup($content['from_date'], $content['to_date']);
		$content['tt2_booster'] =  $this->tt2_booster($content['from_date'], $content['to_date']);
		$content['institutional_delivery'] =  $this->institutional_delivery($content['from_date'], $content['to_date']);
		$content['newborns_visited_two_or_more_times'] = $this->newborns_visited_two_or_more_times($content['from_date'], $content['to_date']);
		$content['newborns_visited_three_or_more_times_home_delivery'] = $this->newborns_visited_three_or_more_times_home_delivery($content['from_date'], $content['to_date']);
		$content['newborns_visited_two_or_more_times_instituional'] = $this->newborns_visited_two_or_more_times_instituional($content['from_date'], $content['to_date']);
		$content['low_birth_weight'] =  $this->low_birth_weight($content['from_date'], $content['to_date']);

		$content['subview'] = 'dashboard';
		$this->load->view('admin/main_layout', $content);
	}

		public function export_csv()
	{
		$query = "select * from mstanm where LanguageID = 1";
		$this->load->model('Data_export_model');
		$this->Data_export_model->export_csv($query);
	}

	public function export_pdf()
	{
		$query = "select * from mstanm where LanguageID = 1";
		$this->load->model('Data_export_model');
		$this->Data_export_model->export_pdf($query);
	}

	public function prop_preg_first_trimster($from_date, $to_date)
	{
		if ($from_date != NULL && $to_date != NULL) {
			$query = "select count(*) as done FROM `tblpregnant_woman`
			where Regwithin12weeks=1
			and PWRegistrationDate between STR_TO_DATE('$from_date', '%Y-%m-%d') and  STR_TO_DATE('$to_date', '%Y-%m-%d') and IsPregnant = 1
			UNION ALL
			select count(*) as done FROM `tblpregnant_woman` 
			where PWRegistrationDate between STR_TO_DATE('$from_date', '%Y-%m-%d') and  STR_TO_DATE('$to_date', '%Y-%m-%d') and IsPregnant = 1";
		}else{
			$query = "select count(*) as done FROM `tblpregnant_woman`
			where Regwithin12weeks=1 and IsPregnant = 1
			UNION ALL
			select count(*) as done FROM `tblpregnant_woman` where IsPregnant = 1";
		}

		$stats = $this->db->query($query)->result();
		return [$stats[0]->done, $stats[1]->done];

	}

	public function prop_one_anc_checkup($from_date, $to_date)
	{
		if ($from_date != NULL && $to_date != NULL) {
			$query = "
			select count(*) as done from 
			(
			SELECT v.AncVisitID FROM tblancvisit v
			inner join tblpregnant_woman pw
			on v.PWGUID = pw.PWGUID
			where v.CheckupVisitDate is not null
			and pw.PWRegistrationDate between STR_TO_DATE('$from_date', '%Y-%m-%d') and  STR_TO_DATE('$to_date', '%Y-%m-%d')
			and pw.IsPregnant = 1
			group by v.PWGUID having count(*) = 1
			)a
			UNION ALL
			SELECT count(PWGUID) as done FROM `tblpregnant_woman` where PWRegistrationDate between STR_TO_DATE('$from_date', '%Y-%m-%d') and  STR_TO_DATE('$to_date', '%Y-%m-%d')
			and IsPregnant = 1";
		}else{
			$query = "
			select count(*) as done from 
			(
			SELECT v.AncVisitID FROM tblancvisit v
			inner join tblpregnant_woman pw
			on v.PWGUID = pw.PWGUID
			where v.CheckupVisitDate is not null
			and pw.IsPregnant = 1
			group by v.PWGUID having count(*) = 1
			)a
			UNION 
			SELECT count(PWGUID) as done FROM `tblpregnant_woman` where IsPregnant = 1";
		}

		$stats = $this->db->query($query)->result();
		return [$stats[0]->done, $stats[1]->done];

	}

	public function prop_two_anc_checkup($from_date, $to_date)
	{
		if ($from_date != NULL && $to_date != NULL) {
			$query = "
			select count(*) as done from 
			(
			SELECT v.AncVisitID FROM tblancvisit v
			inner join tblpregnant_woman pw
			on v.PWGUID = pw.PWGUID
			where v.CheckupVisitDate is not null
			and pw.PWRegistrationDate between STR_TO_DATE('$from_date', '%Y-%m-%d') and  STR_TO_DATE('$to_date', '%Y-%m-%d')
			and pw.IsPregnant = 1
			group by v.PWGUID having count(*) = 2
			)a
			UNION ALL
			SELECT count(PWGUID) as done FROM `tblpregnant_woman` where PWRegistrationDate between STR_TO_DATE('$from_date', '%Y-%m-%d') and  STR_TO_DATE('$to_date', '%Y-%m-%d') 
			and IsPregnant = 1";
		}else{
			$query = "
			select count(*) as done from 
			(
			SELECT v.AncVisitID FROM tblancvisit v
			inner join tblpregnant_woman pw
			on v.PWGUID = pw.PWGUID
			where v.CheckupVisitDate is not null
			and pw.IsPregnant = 1
			group by v.PWGUID having count(*) = 2
			)a
			UNION 
			SELECT count(PWGUID) as done FROM `tblpregnant_woman` where IsPregnant = 1";
		}

		$stats = $this->db->query($query)->result();
		return [$stats[0]->done, $stats[1]->done];

	}

	public function prop_three_anc_checkup($from_date, $to_date)
	{
		if ($from_date != NULL && $to_date != NULL) {
			$query = "
			select count(*) as done from 
			(
			SELECT v.AncVisitID FROM tblancvisit v
			inner join tblpregnant_woman pw
			on v.PWGUID = pw.PWGUID
			where v.CheckupVisitDate is not null
			and pw.PWRegistrationDate between STR_TO_DATE('$from_date', '%Y-%m-%d') and  STR_TO_DATE('$to_date', '%Y-%m-%d')
			and pw.IsPregnant = 1
			group by v.PWGUID having count(*) = 3
			)a
			UNION ALL
			SELECT count(PWGUID) as done FROM `tblpregnant_woman` where PWRegistrationDate between STR_TO_DATE('$from_date', '%Y-%m-%d') and  STR_TO_DATE('$to_date', '%Y-%m-%d')
			and IsPregnant = 1";
		}else{
			$query = "
			select count(*) as done from 
			(
			SELECT v.AncVisitID FROM tblancvisit v
			inner join tblpregnant_woman pw
			on v.PWGUID = pw.PWGUID
			where v.CheckupVisitDate is not null
			and pw.IsPregnant = 1
			group by v.PWGUID having count(*) = 3
			)a
			UNION 
			SELECT count(PWGUID) as done FROM `tblpregnant_woman` where IsPregnant = 1";
		}

		$stats = $this->db->query($query)->result();
		return [$stats[0]->done, $stats[1]->done];

	}


	public function prop_four_anc_checkup($from_date, $to_date)
	{
		if ($from_date != NULL && $to_date != NULL) {
			$query = "
			select count(*) as done from 
			(
			SELECT v.AncVisitID FROM tblancvisit v
			inner join tblpregnant_woman pw
			on v.PWGUID = pw.PWGUID
			where v.CheckupVisitDate is not null
			and pw.PWRegistrationDate between STR_TO_DATE('$from_date', '%Y-%m-%d') and  STR_TO_DATE('$to_date', '%Y-%m-%d')
			and pw.IsPregnant = 1
			group by v.PWGUID having count(*) = 4
			)a
			UNION ALL
			SELECT count(PWGUID) as done FROM `tblpregnant_woman` where PWRegistrationDate between STR_TO_DATE('$from_date', '%Y-%m-%d') and  STR_TO_DATE('$to_date', '%Y-%m-%d')
			and IsPregnant = 1";
		}else{
			$query = "
			select count(*) as done from 
			(
			SELECT v.AncVisitID FROM tblancvisit v
			inner join tblpregnant_woman pw
			on v.PWGUID = pw.PWGUID
			where v.CheckupVisitDate is not null
			and pw.IsPregnant = 1
			group by v.PWGUID having count(*) = 4
			)a
			UNION ALL
			SELECT count(PWGUID) as done FROM `tblpregnant_woman` where IsPregnant = 1";
		}

		$stats = $this->db->query($query)->result();
		return [$stats[0]->done, $stats[1]->done];

	}


	public function tt2_booster($from_date, $to_date)
	{
		if ($from_date != NULL && $to_date != NULL) {
			$query = "
			select count(*) as done from 
			(
			SELECT v.AncVisitID FROM tblancvisit v
			inner join tblpregnant_woman pw
			on v.PWGUID = pw.PWGUID
			where v.TT2=1 or v.TTbooster=1
			and pw.PWRegistrationDate between STR_TO_DATE('$from_date', '%Y-%m-%d') and  STR_TO_DATE('$from_date', '%Y-%m-%d')
			and pw.IsPregnant = 1
			group by v.PWGUID having count(*) > 0
			)a
			UNION ALL
			SELECT count(*) as done FROM `tblpregnant_woman` where PWRegistrationDate between STR_TO_DATE('$from_date', '%Y-%m-%d') and  STR_TO_DATE('$to_date', '%Y-%m-%d') and IsPregnant = 1";
		}else{
			$query = "
			select count(*) as done from 
			(
			SELECT v.AncVisitID FROM tblancvisit v
			inner join tblpregnant_woman pw
			on v.PWGUID = pw.PWGUID
			where v.TT2=1 or v.TTbooster=1
			and pw.IsPregnant = 1
			group by v.PWGUID having count(*) > 0
			)a
			UNION ALL
			SELECT count(PWGUID) as done FROM `tblpregnant_woman` where IsPregnant = 1";
		}

		$stats = $this->db->query($query)->result();
		return [$stats[0]->done, $stats[1]->done];

	}

	public function institutional_delivery($from_date, $to_date)
	{
		if ($from_date != NULL && $to_date != NULL) {
			$query = "
			select COUNT(*) AS done
			FROM
			(
			SELECT PWGUID
			FROM
			tblpregnant_woman w
			INNER JOIN
			tblchild c ON w.PWGUID = c.pw_GUID
			WHERE
			c.place_of_birth = 2 AND w.PWRegistrationDate BETWEEN STR_TO_DATE('$from_date',
			'%Y-%m-%d') AND STR_TO_DATE('$to_date',
			'%Y-%m-%d')
			) a
			UNION ALL
			SELECT COUNT(PWGUID) AS done
			FROM
			`tblpregnant_woman`
			WHERE
			PWRegistrationDate BETWEEN STR_TO_DATE('$from_date',
			'%Y-%m-%d') AND STR_TO_DATE('$to_date',
			'%Y-%m-%d')";
		}else{
			$query = "
			select COUNT(*) AS done
			FROM
			(
			SELECT
			PWGUID
			FROM
			tblpregnant_woman w
			INNER JOIN
			tblchild c ON w.PWGUID = c.pw_GUID
			WHERE
			c.place_of_birth = 2
			) a
			UNION ALL
			SELECT COUNT(PWGUID) AS done
			FROM
			`tblpregnant_woman`";
		}

		$stats = $this->db->query($query)->result();
		return [$stats[0]->done, $stats[1]->done];

	}

	public function low_birth_weight($from_date, $to_date)
	{
		if ($from_date != NULL && $to_date != NULL) {
			$query = "
			select count(*) as done from 
			(
			SELECT w.PWGUID from tblchild c 
			inner join tblpregnant_woman w 
			on c.pw_GUID = w.PWGUID
			where  c.Wt_of_child < 2.5
			and w.PWRegistrationDate between STR_TO_DATE('$from_date', '%Y-%m-%d') and  STR_TO_DATE('$to_date', '%Y-%m-%d')
			)a
			UNION ALL
			SELECT count(PWGUID) as done FROM `tblpregnant_woman` where PWRegistrationDate between STR_TO_DATE('$from_date', '%Y-%m-%d') and  STR_TO_DATE('$to_date', '%Y-%m-%d')";
		}else{
			$query = "
			select count(*) as done from 
			(
			SELECT w.PWGUID from tblchild c 
			inner join tblpregnant_woman w 
			on c.pw_GUID = w.PWGUID
			where  c.Wt_of_child < 2.5)a
			UNION ALL
			SELECT count(PWGUID) as done FROM `tblpregnant_woman`";
		}
		$stats = $this->db->query($query)->result();
		return [$stats[0]->done, $stats[1]->done];

	}

	public function newborns_visited_two_or_more_times($from_date, $to_date)
	{
		if ($from_date != NULL && $to_date != NULL) {
			$query = "
			select count(*) as done from 
			(
			SELECT v.AncVisitID FROM tblancvisit v
			inner join tblpregnant_woman pw
			on v.PWGUID = pw.PWGUID
			inner join tblchild c 
			on c.pw_GUID = pw.PWGUID
			where v.CheckupVisitDate BETWEEN c.child_dob and DATE_ADD(c.child_dob, INTERVAL 7 day)
			and pw.PWRegistrationDate between STR_TO_DATE('$from_date', '%Y-%m-%d') and  STR_TO_DATE('$to_date', '%Y-%m-%d')
			group by v.PWGUID having count(*) > 2
			)a
			UNION ALL
			SELECT count(PWGUID) as done FROM `tblpregnant_woman` where PWRegistrationDate between STR_TO_DATE('$from_date', '%Y-%m-%d') and  STR_TO_DATE('$to_date', '%Y-%m-%d')";

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

		$stats = $this->db->query($query)->result();

		return [$stats[0]->done, $stats[1]->done];

	}


	public function newborns_visited_three_or_more_times_home_delivery($from_date, $to_date)
	{
		if ($from_date != NULL && $to_date != NULL) {
			$query = "
			select count(*) as done from 
			(
			SELECT v.AncVisitID FROM tblancvisit v
			inner join tblpregnant_woman pw
			on v.PWGUID = pw.PWGUID
			inner join tblchild c 
			on c.pw_GUID = pw.PWGUID
			where v.CheckupVisitDate BETWEEN c.child_dob and DATE_ADD(c.child_dob, INTERVAL 7 day)
			and c.place_of_birth = 1
			and pw.PWRegistrationDate between STR_TO_DATE('$from_date', '%Y-%m-%d') and  STR_TO_DATE('$to_date', '%Y-%m-%d')
			group by v.PWGUID having count(*) > 3
			)a
			UNION ALL
			SELECT count(PWGUID) as done FROM `tblpregnant_woman` where PWRegistrationDate between STR_TO_DATE('$from_date', '%Y-%m-%d') and  STR_TO_DATE('$to_date', '%Y-%m-%d')";

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
			and c.place_of_birth = 1
			group by v.PWGUID having count(*) > 3
			)a
			UNION ALL
			SELECT count(PWGUID) as done FROM `tblpregnant_woman`";
		}

		$stats = $this->db->query($query)->result();

		return [$stats[0]->done, $stats[1]->done];

	}

	public function newborns_visited_two_or_more_times_instituional($from_date, $to_date)
	{
		if ($from_date != NULL && $to_date != NULL) {
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
			and pw.PWRegistrationDate between STR_TO_DATE('$from_date', '%Y-%m-%d') and  STR_TO_DATE('$to_date', '%Y-%m-%d')
			group by v.PWGUID having count(*) > 2
			)a
			UNION ALL
			SELECT count(PWGUID) as done FROM `tblpregnant_woman` where PWRegistrationDate between STR_TO_DATE('$from_date', '%Y-%m-%d') and  STR_TO_DATE('$to_date', '%Y-%m-%d')";

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

		$stats = $this->db->query($query)->result();

		return [$stats[0]->done, $stats[1]->done];

	}

}
