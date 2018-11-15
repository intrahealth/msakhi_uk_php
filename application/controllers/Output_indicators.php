<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Output_indicators extends Auth_controller {

	public function __construct()
	{
		parent::__construct();
		$this->loginData = $this->session->userdata("loginData");
	}

	/**
	* Compute the start and end date of some fixed o relative quarter in a specific year.
	* @param mixed $quarter  Integer from 1 to 4 or relative string value:
	*                        'this', 'current', 'previous', 'first' or 'last'.
	*                        'this' is equivalent to 'current'. Any other value
	*                        will be ignored and instead current quarter will be used.
	*                        Default value 'current'. Particulary, 'previous' value
	*                        only make sense with current year so if you use it with
	*                        other year like: get_dates_of_quarter('previous', 1990)
	*                        the year will be ignored and instead the current year
	*                        will be used.
	* @param int $year       Year of the quarter. Any wrong value will be ignored and
	*                        instead the current year will be used.
	*                        Default value null (current year).
	* @param string $format  String to format returned dates
	* @return array          Array with two elements (keys): start and end date.
	*/	
	private function get_dates_of_quarter($quarter = 'current', $year = null, $format = null)
	{
		if ( !is_int($year) ) {        
			$year = (new DateTime)->format('Y');
		}
		$current_quarter = ceil((new DateTime)->format('n') / 3);
		switch (  strtolower($quarter) ) {
			case 'this':
			case 'current':
			$quarter = ceil((new DateTime)->format('n') / 3);
			break;

			case 'previous':
			$year = (new DateTime)->format('Y');
			if ($current_quarter == 1) {
				$quarter = 4;
				$year--;
			} else {
				$quarter =  $current_quarter - 1;
			}
			break;

			case 'first':
			$quarter = 1;
			break;

			case 'last':
			$quarter = 4;
			break;

			default:
			$quarter = (!is_int($quarter) || $quarter < 1 || $quarter > 4) ? $current_quarter : $quarter;
			break;
		}
		if ( $quarter === 'this' ) {
			$quarter = ceil((new DateTime)->format('n') / 3);
		}
		$start = new DateTime($year.'-'.(3*$quarter-2).'-1 00:00:00');
		$end = new DateTime($year.'-'.(3*$quarter).'-'.($quarter == 1 || $quarter == 4 ? 31 : 30) .' 23:59:59');

		return array(
			'start' => $format ? $start->format($format) : $start,
			'end' => $format ? $end->format($format) : $end,
		);
	}

	public function apply_filter()
	{
		$this->session->unset_userdata("filter_data");
		$command = $this->input->post("command");
		$filterPeriod = $this->input->post("filterPeriod");

		if ($filterPeriod != NULL) {
			
			switch ($filterPeriod) {
				case 1:
				// case of Last Month
				$date_from = date("Y-m-d", mktime(0, 0, 0, date("m")-1, 1));
				$date_to = date("Y-m-d", mktime(0, 0, 0, date("m"), 0));
				break;
				case 2:
				// case of Current Month
				$date_from = date('Y-m-01');
				$date_to = date('Y-m-t');
				break;
				case 3:
				// case of Last Completed Quater
				$quater_result = $this->get_dates_of_quarter('previous', NULL, "Y-m-d");
				$date_from = $quater_result['start'];
				$date_to = $quater_result['end'];
				break;
				case 4:
				// case of Current running Quarter
				$quater_result = $this->get_dates_of_quarter(NULL, NULL, "Y-m-d");
				$date_from = $quater_result['start'];
				$date_to = $quater_result['end'];
				break;
				case 5:
				// case of Last financial year
				$date_from = "2016-04-01";
				$date_to = "2017-03-31";
				break;
				case 6:
				// case of Current Financial year
				$date_from = "2017-04-01";
				$date_to = "2018-03-31";
				break;
				// all times	
				default:
				$date_from = NULL;
				$date_to = NULL;
				break;
			}

			$filter_data = array(
				"ANM" 	=>	$this->input->post("ANM"),
				"Asha"	=>	$this->input->post("Asha"),
				"date_from"	=>	$date_from,
				"date_to"	=>	$date_to,
			);

			$this->session->set_userdata("filter_data", $filter_data);


		} else if ($command != NULL) {

			if ($command == "apply_filter") 
			{

				$filter_data = array(
					"ANM" 	=>	$this->input->post("ANM"),
					"Asha"	=>	$this->input->post("Asha"),
					"date_from"	=>	$this->input->post("date_from"),
					"date_to"	=>	$this->input->post("date_to"),
				);


				$this->session->set_userdata("filter_data", $filter_data);

			} elseif ($command == "clear_filter") {

				$filter_data = array(
					"ANM" 	=>	NULL,
					"Asha"	=>	NULL,
					"date_from"	=>	NULL,
					"date_to"	=>	NULL,
				);

				$this->session->set_userdata("filter_data", $filter_data);

			}	
		}else{

			/**
			 * case for the first time page open
			 */

			$filter_data = array(
				"ANM" 	=>	array(),
				"Asha"	=>	array(),
				"date_from"	=>	NULL,
				"date_to"	=>	NULL,
			);

			$this->session->set_userdata("filter_data", $filter_data);

		}

	}

	public function index()
	{
       // start permission 
		$user_role = $this->loginData->user_role;
		$query = "SELECT * FROM role_permissions as rp LEFT JOIN mstrole as mst on rp.RoleID=mst.RoleID WHERE rp.RoleID='$user_role' ";
		$content['role_permission'] = $this->Common_Model->query_data($query);
		// end permission

		$RequestMethod = $this->input->server('REQUEST_METHOD');

		if($RequestMethod == "POST")
		{
			$this->apply_filter();
		}

		$content['filter_data'] = $this->session->userdata("filter_data");

		$query = "select * from mstanm a inner join useranmmapping b on a.ANMID = b.ANMID inner join tblusers c on b.UserID = c.user_id where LanguageID = 1 and user_mode = 1";
		$content['anm_list'] = $this->db->query($query)->result(); 
		
		if ($content['filter_data']['ANM'] != NULL) 
		{

			$query = "select a.ASHAID, a.ASHAName FROM anmasha m 
			inner join mstasha a 
			on a.ASHAID = m.ASHAID
			and m.ANMID = ".$content['filter_data']['ANM']."
			where a.LanguageID = 1";

			$content['asha_list']= $this->db->query($query)->result();

		}else{

			$query = "select a.ASHAID, a.ASHAName, u.user_name FROM mstasha a
			inner join userashamapping ua 
			on a.ASHAID = ua.AshaID
			inner join tblusers u 
			on ua.UserID = u.user_id
			where u.user_mode=1 and a.LanguageID = 1 and u.user_role = 2
			and a.IsActive = 1 ";

			if ($this->loginData->user_role == 1 || $this->loginData->user_role == 2 || $this->loginData->user_role == 3 || $this->loginData->user_role == 4 || $this->loginData->user_role == 6 || $this->loginData->user_role == 7 || $this->loginData->user_role == 8 || $this->loginData->user_role == 10) 	 {
				$query .= "	and u.state_code='".$this->loginData->state_code."' ";

			// add district based filter if district role
				if ($this->loginData->user_role == 7) {
					$query .= " and district_code = '".$this->loginData->district_code."' ";
				}
			// add district based filter if block role
				if ($this->loginData->user_role == 8) {
					$query .= " and block_code = '".$this->loginData->block_code."' ";
				}
			}
			$content['asha_list'] = $this->db->query($query)->result();

			// $content['asha_list'] = array();
			
		}
		/**
		 * start getting data from dashboard3 model
		 */

		// load model after the filter is all set
		$this->load->model('Dashboard3_model');

		$demographic['total_population']['count'] = $this->Dashboard3_model->get_total_population();

		$demographic['total_population']['percent'] = 100;
		$total_population = $demographic['total_population']['count'];

		$demographic['total_households']['count'] = $this->Dashboard3_model->get_total_households();

		// $demographic['total_households']['percent'] = 100;
		// $total_population = $demographic['total_households']['count'];

		$demographic['woman_age_15_49_years']['count'] = $this->Dashboard3_model->get_woman_age_15_49_years();
		$demographic['woman_age_15_49_years']['percent'] = ($demographic['woman_age_15_49_years']['count'] / ($total_population == 0? 1 : $total_population)) * 100;

		$demographic['children_age_months_0_6']['count'] = $this->Dashboard3_model->get_children_age_months('>=0','<=6');
		$demographic['children_age_months_0_6']['percent'] = ($demographic['children_age_months_0_6']['count'] / ($total_population == 0?1:$total_population)) * 100;

		$demographic['children_age_months_6_12']['count'] = $this->Dashboard3_model->get_children_age_months('>6','<12');
		$demographic['children_age_months_6_12']['percent'] = ($demographic['children_age_months_6_12']['count'] / ($total_population == 0?1:$total_population)) * 100;

		$demographic['children_age_months_0_24']['count'] = $this->Dashboard3_model->get_children_age_months('>=0','<24');
		$demographic['children_age_months_0_24']['percent'] = ($demographic['children_age_months_0_24']['count'] / ($total_population == 0?1:$total_population)) * 100;

		$demographic['children_age_months_12_36']['count'] = $this->Dashboard3_model->get_children_age_months('>=12','<36');
		$demographic['children_age_months_12_36']['percent'] = ($demographic['children_age_months_12_36']['count'] / ($total_population == 0?1:$total_population)) * 100;

		$demographic['children_age_months_48_72']['count'] = $this->Dashboard3_model->get_children_age_months('>48','<72');
		$demographic['children_age_months_48_72']['percent'] = ($demographic['children_age_months_48_72']['count'] / ($total_population == 0?1:$total_population)) * 100;

		$demographic['children_age_months_0_72']['count'] = $this->Dashboard3_model->get_children_age_months('>=0','<72');
		$demographic['children_age_months_0_72']['percent'] = ($demographic['children_age_months_0_72']['count'] / ($total_population == 0?1:$total_population)) * 100;

		/*$demographic['children_age_months_0_60']['count'] = $this->Dashboard3_model->get_children_age_months('>=0','<=60');
		$demographic['children_age_months_0_60']['percent'] = ($demographic['children_age_months_0_60']['count'] / ($total_population == 0?1:$total_population)) * 100;*/

		$demographic['get_children_age_months_0_to_5_year']['count'] = $this->Dashboard3_model->get_children_age_months_0_to_5_year();

		$demographic['get_children_age_months_0_to_5_year']['percent'] = ($demographic['get_children_age_months_0_to_5_year']['count'] / ($total_population == 0?1:$total_population)) * 100;

		$demographic['adults_aged_35_50_years']['count'] = $this->Dashboard3_model->get_adults_aged_35_50_years(0,6);
		$demographic['adults_aged_35_50_years']['percent'] = ($demographic['adults_aged_35_50_years']['count'] / ($total_population == 0?1:$total_population)) * 100;

		$demographic['adults_aged_60_years_and_more']['count'] = $this->Dashboard3_model->get_adults_aged_60_years_and_more(0,6);
		$demographic['adults_aged_60_years_and_more']['percent'] = ($demographic['adults_aged_60_years_and_more']['count'] / ($total_population == 0?1:$total_population)) * 100;

		$demographic['total_pregnant_women_in_area']['count'] = $this->Dashboard3_model->get_total_pregnant_women_in_area(0,6);
		$demographic['total_pregnant_women_in_area']['percent'] = ($demographic['total_pregnant_women_in_area']['count'] / ($total_population == 0?1:$total_population)) * 100;

		// push to content
		$content['demographic'] = $demographic;



		/*Block Start for Childern as day wise from tblhhfamilymember*/


		$content['get_children_age_months_0_to_5_year']['count'] = $this->Dashboard3_model->get_children_age_months_0_to_5_year();

		$content['get_children_age_months_0_to_5_year']['percent'] = ($content['get_children_age_months_0_to_5_year']['count'] / ($total_population == 0?1:$total_population)) * 100;


		// print_r($content['get_children_age_months_0_to_5_year']['percent']); die();



		$content['get_children_age_months_zero_to_five_year'] = $this->Dashboard3_model->get_children_age_months_zero_to_five_year();
		// print_r($content['get_children_age_months_zero_to_five_year']); die();


		$content['get_children_age_months_zero_to_six_months'] = $this->Dashboard3_model->get_children_age_months_zero_to_six_months();
		// print_r($content['get_children_age_months_zero_to_six_months']); die();

		$content['get_children_age_months_six_to_one_year'] = $this->Dashboard3_model->get_children_age_months_six_to_one_year();
		// print_r($content['get_children_age_months_six_to_one_year']); die();

		$content['get_children_age_months_one_to_two_year'] = $this->Dashboard3_model->get_children_age_months_one_to_two_year();
		// print_r($content['get_children_age_months_one_to_two_year']); die();

		$content['get_children_age_months_two_to_three_year'] = $this->Dashboard3_model->get_children_age_months_two_to_three_year();
		// print_r($content['get_children_age_months_two_to_three_year']); die();

		$content['get_children_age_months_three_to_five_year'] = $this->Dashboard3_model->get_children_age_months_three_to_five_year();
		// print_r($content['get_children_age_months_three_to_five_year']); die();





		/**
		 * Block for children start
		 */

		$model_result = $this->Dashboard3_model->get_children_age_months('>=0','<=60',1);
		$children['children_age_months_0_60_gender']['male'] = $model_result[0]->total;
		$children['children_age_months_0_60_gender']['female'] = $model_result[1]->total;
		$children['children_age_months_0_60_gender']['total'] = $model_result[0]->total + $model_result[1]->total;

		$model_result = $this->Dashboard3_model->get_children_age_months('>=0','<=6',1);
		$children['children_age_months_0_6_gender']['male'] = $model_result[0]->total;
		$children['children_age_months_0_6_gender']['female'] = $model_result[1]->total;
		$children['children_age_months_0_6_gender']['total'] = $model_result[0]->total + $model_result[1]->total;

		$model_result = $this->Dashboard3_model->get_children_age_months('>6','<=12',1);
		$children['children_age_months_7_12_gender']['male'] = $model_result[0]->total;
		$children['children_age_months_7_12_gender']['female'] = $model_result[1]->total;
		$children['children_age_months_7_12_gender']['total'] = $model_result[0]->total + $model_result[1]->total;

		$model_result = $this->Dashboard3_model->get_children_age_months('>12','<=24',1);
		$children['children_age_months_12_24_gender']['male'] = $model_result[0]->total;
		$children['children_age_months_12_24_gender']['female'] = $model_result[1]->total;
		$children['children_age_months_12_24_gender']['total'] = $model_result[0]->total + $model_result[1]->total;

		$model_result = $this->Dashboard3_model->get_children_age_months('>24','<=36',1);
		$children['children_age_months_24_36_gender']['male'] = $model_result[0]->total;
		$children['children_age_months_24_36_gender']['female'] = $model_result[1]->total;
		$children['children_age_months_24_36_gender']['total'] = $model_result[0]->total + $model_result[1]->total;

		$model_result = $this->Dashboard3_model->get_children_age_months('>36','<=60',1);
		$children['children_age_months_36_60_gender']['male'] = $model_result[0]->total;
		$children['children_age_months_36_60_gender']['female'] = $model_result[1]->total;
		$children['children_age_months_36_60_gender']['total'] = $model_result[0]->total + $model_result[1]->total;

		// push to content
		$content['children'] = $children;

		/**
		 * Block for Married woman start
		 */
		
		$married['total_married_women']['count'] = $this->Dashboard3_model->get_currently_married_woman();
		$married['total_married_women']['percent'] = 100;
		$total_married_women = $married['total_married_women']['count'];


		$married['woman_with_no_child']['count'] = $this->Dashboard3_model->get_woman_with_no_child();
		$married['woman_with_no_child']['percent'] = ($married['woman_with_no_child']['count'] / ($total_married_women == 0? 1 : $total_married_women)) * 100;


		$married['woman_with_1_child']['count'] = $this->Dashboard3_model->get_woman_with_1_child();
		$married['woman_with_1_child']['percent'] = ($married['woman_with_1_child']['count'] / ($total_married_women == 0? 1 : $total_married_women)) * 100;


		$married['woman_with_2_child']['count'] = $this->Dashboard3_model->get_woman_with_2_child();
		$married['woman_with_2_child']['percent'] = ($married['woman_with_2_child']['count'] / ($total_married_women == 0? 1 : $total_married_women)) * 100;		


		$married['woman_with_3_child']['count'] = $this->Dashboard3_model->get_woman_with_3_child();
		$married['woman_with_3_child']['percent'] = ($married['woman_with_3_child']['count'] / ($total_married_women == 0? 1 : $total_married_women)) * 100;

		$content['married'] = $married;


		/**
		 * Block for Pregnant woman start
		 */

		$pregnent['total_pregnent_women']['count'] = $this->Dashboard3_model->get_currently_pregnent_women();
		$pregnent['total_pregnent_women']['percent'] = 100;
		$total_pregnent_women = $pregnent['total_pregnent_women']['count'];


		$pregnent['pregnent_with_no_child']['count'] = $this->Dashboard3_model->get_pregnant_woman_with_no_child();
		$pregnent['pregnent_with_no_child']['percent'] = ($pregnent['pregnent_with_no_child']['count'] / ($total_pregnent_women == 0? 1 : $total_pregnent_women)) * 100;


		$pregnent['pregnent_with_1_child']['count'] = $this->Dashboard3_model->get_pregnant_woman_with_1_child();
		$pregnent['pregnent_with_1_child']['percent'] = ($pregnent['pregnent_with_1_child']['count'] / ($total_pregnent_women == 0? 1 : $total_pregnent_women)) * 100;

		$pregnent['pregnent_with_2_child']['count'] = $this->Dashboard3_model->get_pregnant_woman_with_2_child();
		$pregnent['pregnent_with_2_child']['percent'] = ($pregnent['pregnent_with_2_child']['count'] / ($total_pregnent_women == 0? 1 : $total_pregnent_women)) * 100;

		$pregnent['pregnent_with_3_child']['count'] = $this->Dashboard3_model->get_pregnant_woman_with_3_child();
		$pregnent['pregnent_with_3_child']['percent'] = ($pregnent['pregnent_with_3_child']['count'] / ($total_pregnent_women == 0? 1 : $total_pregnent_women)) * 100;

		$content['pregnent'] = $pregnent;


		$married['with_no_child']['count'] = $this->Dashboard3_model->get_children_age_months('>=36','<60',1);
		
		$this->db->where('is_visible', 1);
		$content['indicator_group_list'] = $this->db->get('tbl_indicator_group')->result();

		$content['subview'] = 'Output_indicators';
		$this->load->view('auth/main_layout', $content);
	}

	public function demographic()
	{

		
		$RequestMethod = $this->input->server('REQUEST_METHOD');

		if($RequestMethod == "POST")
		{
			$this->apply_filter();
		}

		$content['filter_data'] = $this->session->userdata("filter_data");

		$query = "select * from mstanm where LanguageID = 1";
		$content['anm_list'] = $this->db->query($query)->result();

		if ($content['filter_data']['ANM'] != NULL) 
		{

			$query = "select a.ASHAID, a.ASHAName FROM anmasha m 
			inner join mstasha a 
			on a.ASHAID = m.ASHAID
			and m.ANMID = ".$content['filter_data']['ANM']."
			where a.LanguageID = 1";

			$content['asha_list']= $this->db->query($query)->result();

		}else{

			$content['asha_list'] = array(); 
			
		}

		/**
		 * start getting data from dashboard2 model
		 */

		// load model after the filter is all set
		$this->load->model('Dashboard3_model');

		$content['total_population'] = $this->Dashboard3_model->get_total_population();
		$content['woman_age_15_49_years'] = $this->Dashboard3_model->get_woman_age_15_49_years();
		$content['children_age_months_0_6'] = $this->Dashboard3_model->get_children_age_months('>=0','<=6');
		$content['children_age_months_6_12'] = $this->Dashboard3_model->get_children_age_months('>6','<=12');
		$content['children_age_months_0_24'] = $this->Dashboard3_model->get_children_age_months('>=0','<=24');
		$content['children_age_months_12_36'] = $this->Dashboard3_model->get_children_age_months('>12','<=36');
		$content['children_age_months_48_72'] = $this->Dashboard3_model->get_children_age_months('>48','<=72');
		$content['children_age_months_0_72'] = $this->Dashboard3_model->get_children_age_months('>=0','<=72');
		
		$content['adults_aged_35_50_years'] = $this->Dashboard3_model->get_adults_aged_35_50_years();
		$content['adults_aged_60_years_and_more'] = $this->Dashboard3_model->get_adults_aged_60_years_and_more();
		$content['total_pregnant_women_in_area'] = $this->Dashboard3_model->get_total_pregnant_women_in_area();
		$content['total_merried_woman'] = $this->Dashboard3_model->get_current_married_woman();

		$content['subview'] = 'dashboard3_demographic';
		$this->load->view('gov/main_layout', $content);

	}


	public function anti_natal()
	{

		$RequestMethod = $this->input->server('REQUEST_METHOD');

		if($RequestMethod == "POST")
		{
			$this->apply_filter();
		}

		$content['filter_data'] = $this->session->userdata("filter_data");

		$query = "select * from mstanm where LanguageID = 1";
		$content['anm_list'] = $this->db->query($query)->result();
		
		if ($content['filter_data']['ANM'] != NULL) 
		{

			$query = "select a.ASHAID, a.ASHAName FROM anmasha m 
			inner join mstasha a 
			on a.ASHAID = m.ASHAID
			and m.ANMID = ".$content['filter_data']['ANM']."
			where a.LanguageID = 1";

			$content['asha_list']= $this->db->query($query)->result();

		}else{

			$content['asha_list'] = array(); 
			
		}


		/**
		 * start getting data from dashboard3 model
		 */

		// load model after the filter is all set
		$this->load->model('Dashboard3_model');

		$content['proportion_of_pregnant_woman_registered_in_first_trimester'] = $this->Dashboard3_model->get_proportion_of_pregnant_woman_registered_in_first_trimester();

		// Proportion of pregnant women with 1 ANC check-up
		$content['proportion_of_pregnant_woman_with_one_anc_checkup'] = $this->Dashboard3_model->get_proportion_of_pregnant_woman_with_one_anc_checkup();

		// Proportion of pregnant women with 2 ANC check-up
		$content['proportion_of_pregnant_woman_with_two_anc_checkup'] = $this->Dashboard3_model->get_proportion_of_pregnant_woman_with_two_anc_checkup();

		// Proportion of pregnant women with 3 ANC check-up
		$content['proportion_of_pregnant_woman_with_three_anc_checkup'] = $this->Dashboard3_model->get_proportion_of_pregnant_woman_with_three_anc_checkup();

		// Proportion of pregnant women with 5 ANC check-up
		$content['proportion_of_pregnant_woman_with_four_anc_checkup'] = $this->Dashboard3_model->get_proportion_of_pregnant_woman_with_four_anc_checkup();

		// Proportion of pregnant women who received  TT2  or Booster
		$content['proportion_of_pregnant_woman_received_tt2_or_booster'] = $this->Dashboard3_model->get_proportion_of_pregnant_woman_received_tt2_or_booster();

		// Proportion of institutional deliveries
		$content['proportion_of_institutional_deliveries'] = $this->Dashboard3_model->get_proportion_of_institutional_deliveries();

		// Newborns visited by ASHA at least three  or more times within first seven days of home delivery
		$content['newborns_visited_three_more_seven_days_home_delivery'] = $this->Dashboard3_model->get_newborns_visited_three_more_seven_days_home_delivery();

		$content['subview'] = 'dashboard3_anti_natal';
		$this->load->view('gov/main_layout', $content);

	}

	public function post_natal()
	{

		
		$RequestMethod = $this->input->server('REQUEST_METHOD');

		if($RequestMethod == "POST")
		{
			$this->apply_filter();
		}

		$content['filter_data'] = $this->session->userdata("filter_data");

		$query = "select * from mstanm where LanguageID = 1";
		$content['anm_list'] = $this->db->query($query)->result();
		
		if ($content['filter_data']['ANM'] != NULL) 
		{

			$query = "select a.ASHAID, a.ASHAName FROM anmasha m 
			inner join mstasha a 
			on a.ASHAID = m.ASHAID
			and m.ANMID = ".$content['filter_data']['ANM']."
			where a.LanguageID = 1";

			$content['asha_list']= $this->db->query($query)->result();

		}else{

			$content['asha_list'] = array(); 
			
		}


		/**
		 * start getting data from dashboard3 model
		 */

		// load model after the filter is all set
		$this->load->model('Dashboard3_model');
		
		// Newborns visited by ASHA at least two  or more times within first seven days of institutional delivery
		$content['newborns_visited_two_more_seven_days_institutional_delivery'] = $this->Dashboard3_model->get_newborns_visited_two_more_seven_days_institutional_delivery();

		// Low Birth Weight
		$content['low_birth_weight'] = $this->Dashboard3_model->get_low_birth_weight();

		// Proportion of chidren received BCG at birth
		$content['proportion_received_bcg_birth'] = $this->Dashboard3_model->get_proportion_received_bcg_birth();

		// Proportion of chidren received OPV0 at birth
		$content['proportion_received_opv0_birth'] = $this->Dashboard3_model->get_proportion_received_opv0_birth();

		// Proportion of chidren received HepatitisB0 at birth
		$content['proportion_received_hepb0_birth'] = $this->Dashboard3_model->get_proportion_received_hepb0_birth();

		$content['subview'] = 'dashboard3_post_natal';
		$this->load->view('gov/main_layout', $content);

	}


	public function immunization_infant()
	{

		$RequestMethod = $this->input->server('REQUEST_METHOD');

		if($RequestMethod == "POST")
		{
			$this->apply_filter();
		}

		$content['filter_data'] = $this->session->userdata("filter_data");

		$query = "select * from mstanm where LanguageID = 1";
		$content['anm_list'] = $this->db->query($query)->result();
		
		if ($content['filter_data']['ANM'] != NULL) 
		{

			$query = "select a.ASHAID, a.ASHAName FROM anmasha m 
			inner join mstasha a 
			on a.ASHAID = m.ASHAID
			and m.ANMID = ".$content['filter_data']['ANM']."
			where a.LanguageID = 1";

			$content['asha_list']= $this->db->query($query)->result();

		}else{

			$content['asha_list'] = array(); 
			
		}

		/**
		 * start getting data from dashboard3 model
		 */

		// load model after the filter is all set
		$this->load->model('Dashboard3_model');

		// Proportion of chidren aged 45 days or more received OPV1
		$content['proportion_children_less_45_days_opv1'] = $this->Dashboard3_model->get_proportion_children_less_45_days_opv1();

		// Proportion of chidren aged 45 days or more received DPT1
		$content['proportion_children_less_45_days_dpt1'] = $this->Dashboard3_model->get_proportion_children_less_45_days_dpt1();

		// Proportion of chidren aged 45 days or more received Hepatitis B1
		$content['proportion_children_less_45_days_hepb1'] = $this->Dashboard3_model->get_proportion_children_less_45_days_hepb1();

		// Proportion of chidren aged 75 days or more received OPV2
		$content['proportion_children_more_75_days_opv2'] = $this->Dashboard3_model->get_proportion_children_more_75_days_opv2();

		// Proportion of chidren aged 75 days or more received DPT2
		$content['proportion_children_more_75_days_dpt2'] = $this->Dashboard3_model->get_proportion_children_more_75_days_dpt2();

		// Proportion of chidren aged 75 days or more received Hepatitis B2
		$content['proportion_children_more_75_days_hepb2'] = $this->Dashboard3_model->get_proportion_children_more_75_days_hepb2();

		// Proportion of chidren aged 105 days or more received OPV3
		$content['proportion_children_more_105_days_opv3'] = $this->Dashboard3_model->get_proportion_children_more_105_days_opv3();

		// Proportion of chidren aged 105 days or more received DPT3
		$content['proportion_children_more_105_days_dpt3'] = $this->Dashboard3_model->get_proportion_children_more_105_days_dpt3();

		// Proportion of chidren aged 105 days or more received HepatitisB3
		$content['proportion_children_more_105_days_hepb3'] = $this->Dashboard3_model->get_proportion_children_more_105_days_hepb3();

		// Proportion of chidren aged 9 months received Measles vaccination
		$content['proportion_children_nine_months_more_measles'] = $this->Dashboard3_model->get_proportion_children_nine_months_more_measles();

		// Proportion of chidren aged 9 months received Vitamin A
		$content['proportion_children_nine_months_more_vitamin_a'] = $this->Dashboard3_model->get_proportion_children_nine_months_more_vitamin_a();

		$content['subview'] = 'dashboard3_immunization_infant';
		$this->load->view('gov/main_layout', $content);

	}


	public function immunization_child()
	{

		
		$RequestMethod = $this->input->server('REQUEST_METHOD');

		if($RequestMethod == "POST")
		{
			$this->apply_filter();
		}

		$content['filter_data'] = $this->session->userdata("filter_data");
		
		$query = "select * from mstanm where LanguageID = 1";
		$content['anm_list'] = $this->db->query($query)->result();
		
		if ($content['filter_data']['ANM'] != NULL) 
		{

			$query = "select a.ASHAID, a.ASHAName FROM anmasha m 
			inner join mstasha a 
			on a.ASHAID = m.ASHAID
			and m.ANMID = ".$content['filter_data']['ANM']."
			where a.LanguageID = 1";
			$content['asha_list']= $this->db->query($query)->result();

		}else{

			$content['asha_list'] = array(); 	
		}
		/**
		 * start getting data from dashboard3 model
		 */

		// load model after the filter is all set
		$this->load->model('Dashboard3_model');

		// Proportion of chidren aged 16 months received second dose of Vitamin A
		$content['proportion_children_sixteen_months_vitamin_a2'] = $this->Dashboard3_model->get_proportion_children_sixteen_months_vitamin_a2();
		
		// Proportion of children aged 16 to 24 motnhs received DPT booster
		$content['proportion_children_16_24_months_dptbooster'] = $this->Dashboard3_model->get_proportion_children_16_24_months_dptbooster();

		// Proportion of children aged 16 to 24 motnhs received Polio booster
		$content['proportion_children_16_24_months_poliobooster'] = $this->Dashboard3_model->get_proportion_children_16_24_months_poliobooster();

		// Proportion of chidren aged 24 months received third dose of Vitamin A
		$content['proportion_children_24_months_vitamin_a3'] = $this->Dashboard3_model->proportion_children_24_months_vitamin_a3();

		// Proportion of chidren aged 30 months received 4th dose of Vitamin A
		$content['proportion_children_30_months_vitamin_a4'] = $this->Dashboard3_model->get_proportion_children_30_months_vitamin_a4();

		// Proportion of chidren aged 36 months received 5th dose of Vitamin A
		$content['proportion_children_36_months_vitamin_a5'] = $this->Dashboard3_model->get_proportion_children_36_months_vitamin_a5();

		$content['subview'] = 'dashboard3_immunization_child';
		$this->load->view('gov/main_layout', $content);
	}

	public function get_indicator_trend($id)
	{
		// load model after the filter is all set
		$this->load->model('Dashboard3_model');

		$trend_data = $this->Dashboard3_model->get_indicator_trend($id);
		echo json_encode($trend_data);
	}

	public function test()
	{
		// load model after the filter is all set
		$this->load->model('Dashboard3_model');

		$trend_data = $this->Dashboard3_model->trend_pregnant_woman_registered_in_first_trimester();
		echo json_encode($trend_data);

	}
}
