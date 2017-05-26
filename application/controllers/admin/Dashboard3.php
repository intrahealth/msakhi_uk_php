<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard3 extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Dashboard3_model');
	}

	public function index()
	{

		$RequestMethod = $this->input->server('REQUEST_METHOD');

		if($RequestMethod == "POST")
		{

			$this->session->unset_userdata("filter_data");
			$command = $this->input->post("command");
			
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

		}

		$content['filter_data'] = $this->session->userdata("filter_data");
		// print_r($content['filter_data']); die();

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

		$content['total_population'] = $this->Dashboard3_model->get_total_population();
		$content['woman_age_15_49_years'] = $this->Dashboard3_model->get_woman_age_15_49_years();
		$content['children_age_months_0_6'] = $this->Dashboard3_model->get_children_age_months(0,6);

		$content['proportion_of_pregnant_woman_registered_in_first_trimester'] = $this->Dashboard3_model->get_proportion_of_pregnant_woman_registered_in_first_trimester();

		// Proportion of pregnant women with 1 ANC check-up
		$content['proportion_of_pregnant_woman_with_one_anc_checkup'] = $this->Dashboard3_model->get_proportion_of_pregnant_woman_with_one_anc_checkup();

		// Proportion of pregnant women with 2 ANC check-up
		$content['proportion_of_pregnant_woman_with_two_anc_checkup'] = $this->Dashboard3_model->get_proportion_of_pregnant_woman_with_two_anc_checkup();

		$content['newborns_visited_two_more_seven_days_institutional_delivery'] = $this->Dashboard3_model->get_newborns_visited_two_more_seven_days_institutional_delivery();

		// Low Birth Weight
		$content['low_birth_weight'] = $this->Dashboard3_model->get_low_birth_weight();

		// Proportion of chidren received BCG at birth
		$content['proportion_received_bcg_birth'] = $this->Dashboard3_model->get_proportion_received_bcg_birth();

		// Proportion of chidren aged 45 days or more received OPV1
		$content['proportion_children_less_45_days_opv1'] = $this->Dashboard3_model->get_proportion_children_less_45_days_opv1();

		// Proportion of chidren aged 45 days or more received DPT1
		$content['proportion_children_less_45_days_dpt1'] = $this->Dashboard3_model->get_proportion_children_less_45_days_dpt1();

		// Proportion of chidren aged 45 days or more received Hepatitis B1
		$content['proportion_children_less_45_days_hepb1'] = $this->Dashboard3_model->get_proportion_children_less_45_days_hepb1();

		// Proportion of chidren aged 16 months received second dose of Vitamin A
		$content['proportion_children_sixteen_months_vitamin_a2'] = $this->Dashboard3_model->get_proportion_children_sixteen_months_vitamin_a2();
		
		// Proportion of children aged 16 to 24 motnhs received DPT booster
		$content['proportion_children_16_24_months_dptbooster'] = $this->Dashboard3_model->get_proportion_children_16_24_months_dptbooster();

		// Proportion of children aged 16 to 24 motnhs received Polio booster
		$content['proportion_children_16_24_months_poliobooster'] = $this->Dashboard3_model->get_proportion_children_16_24_months_poliobooster();

		$content['subview'] = 'dashboard3';
		$this->load->view('admin/main_layout', $content);
	}

	public function get_anm_list()
	{
		$query = "select * from mstanm where LanguageID = 1";
		return $this->db->query($query)->result();
	}

	public function update_summary_table()
	{
		$this->Dashboard2_model->update_summary_table();
	}

	public function demographic()
	{

		
		$RequestMethod = $this->input->server('REQUEST_METHOD');

		if($RequestMethod == "POST")
		{

			$this->session->unset_userdata("filter_data");
			$command = $this->input->post("command");
			
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

		}

		// $content['filter_data'] = $this->session->userdata("filter_data");
		// print_r($content['filter_data']); die();

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
		$content['total_population'] = $this->Dashboard3_model->get_total_population();
		$content['woman_age_15_49_years'] = $this->Dashboard3_model->get_woman_age_15_49_years();
		$content['children_age_months_0_6'] = $this->Dashboard3_model->get_children_age_months(0,6);
		$content['children_age_months_6_12'] = $this->Dashboard3_model->get_children_age_months(6,12);
		$content['children_age_months_0_24'] = $this->Dashboard3_model->get_children_age_months(0,24);
		$content['children_age_months_12_36'] = $this->Dashboard3_model->get_children_age_months(12,36);
		$content['children_age_months_48_72'] = $this->Dashboard3_model->get_children_age_months(48,72);
		$content['children_age_months_0_72'] = $this->Dashboard3_model->get_children_age_months(0,72);
		
		$content['adults_aged_35_50_years'] = $this->Dashboard3_model->get_adults_aged_35_50_years();
		$content['adults_aged_60_years_and_more'] = $this->Dashboard3_model->get_adults_aged_60_years_and_more();
		$content['total_pregnant_women_in_area'] = $this->Dashboard3_model->get_total_pregnant_women_in_area();

		$content['subview'] = 'dashboard3_demographic';
		$this->load->view('admin/main_layout', $content);

	}

	
	public function anti_natal()
	{

		
		$RequestMethod = $this->input->server('REQUEST_METHOD');

		if($RequestMethod == "POST")
		{

			$this->session->unset_userdata("filter_data");
			$command = $this->input->post("command");
			
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

				// $this->session->set_userdata("filter_data", $filter_data);
				
			}

		}

		// $content['filter_data'] = $this->session->userdata("filter_data");
		// print_r($content['filter_data']); die();

		/*if ($content['filter_data']['ANM'] != NULL) 
		{

			$query = "select a.ASHAID, a.ASHAName FROM anmasha m 
			inner join mstasha a 
			on a.ASHAID = m.ASHAID
			and m.ANMID = ".$content['filter_data']['ANM']."
			where a.LanguageID = 1";

			$content['asha_list']= $this->db->query($query)->result();

		}else{

			$content['asha_list'] = array(); 
			
		}*/

		/**
		 * start getting data from dashboard2 model
		 */
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
		$this->load->view('admin/main_layout', $content);

	}


	public function post_natal()
	{

		
		$RequestMethod = $this->input->server('REQUEST_METHOD');

		if($RequestMethod == "POST")
		{

			$this->session->unset_userdata("filter_data");
			$command = $this->input->post("command");
			
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

		}

		$content['filter_data'] = $this->session->userdata("filter_data");
		// print_r($content['filter_data']); die();

		/*if ($content['filter_data']['ANM'] != NULL) 
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
*/
		/**
		 * start getting data from dashboard2 model
		 */
		
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
		$this->load->view('admin/main_layout', $content);

	}


	public function immunization_infant()
	{

		
		$RequestMethod = $this->input->server('REQUEST_METHOD');

		if($RequestMethod == "POST")
		{

			$this->session->unset_userdata("filter_data");
			$command = $this->input->post("command");
			
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

		}

		$content['filter_data'] = $this->session->userdata("filter_data");
		// print_r($content['filter_data']); die();

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
		$this->load->view('admin/main_layout', $content);

	}


	public function immunization_child()
	{

		
		$RequestMethod = $this->input->server('REQUEST_METHOD');

		if($RequestMethod == "POST")
		{

			$this->session->unset_userdata("filter_data");
			$command = $this->input->post("command");
			
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

		}

		$content['filter_data'] = $this->session->userdata("filter_data");
		// print_r($content['filter_data']); die();

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
		$this->load->view('admin/main_layout', $content);

	}
}
