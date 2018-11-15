<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mnch_dashboard extends Auth_controller {

	public function __construct()
	{
		parent::__construct();
		$this->loginData = $this->session->userdata('loginData');
		//$this->load->model('Mnch_dashboard_model');
	}

	public function apply_filter()
	{
		$this->session->unset_userdata("filter_data");
		$command = $this->input->post("command");
		$filterPeriod = $this->input->post("filterPeriod");

		if ($filterPeriod != NULL) {
			
			

			$filter_data = array(
				"ANM" 	=>	$this->input->post("ANM"),
				"Asha"	=>	$this->input->post("Asha"),
				"StateCode"	=>	$this->input->post("StateCode"),
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
					"StateCode"	=>	$this->input->post("StateCode"),
					"date_from"	=>	$this->input->post("date_from"),
					"date_to"	=>	$this->input->post("date_to"),
				);


				$this->session->set_userdata("filter_data", $filter_data);

			} elseif ($command == "clear_filter") {

				$filter_data = array(
					"ANM" 	=>	NULL,
					"Asha"	=>	NULL,
					"StateCode"	=>	NULL,
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
				"StateCode"	=>	array(),
				"date_from"	=>	NULL,
				"date_to"	=>	NULL,
			);

			$this->session->set_userdata("filter_data", $filter_data);

		}

	}
	public function index()
	{

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
		// die($content['filter_data'] );

		


		$query = "select * from mststate where IsDeleted=0 and LanguageID = 1 ";
		if ($this->loginData->user_role == 1 || $this->loginData->user_role == 2 || $this->loginData->user_role == 3 || $this->loginData->user_role == 4 || $this->loginData->user_role == 6 || $this->loginData->user_role == 7 || $this->loginData->user_role == 8 || $this->loginData->user_role == 10) 	 {
			$query .= "	and StateCode='".$this->loginData->state_code."' ";

			// add district based filter if district role
			if ($this->loginData->user_role == 7) {
				$query .= " and district_code = '".$this->loginData->district_code."' ";
			}
			// add district based filter if block role
			if ($this->loginData->user_role == 8) {
				$query .= " and block_code = '".$this->loginData->block_code."' ";
			}
		}

		$content['State_List'] = $this->Common_Model->query_data($query);


		$query = "select * from mstanm a inner join useranmmapping b on a.ANMID = b.ANMID inner join tblusers c on b.UserID = c.user_id where LanguageID = 1 and a.IsDeleted = 0 and c.user_mode = 1";
		$content['anm_list'] = $this->db->query($query)->result(); 
		
		if ($content['filter_data']['ANM'] != NULL) 
		{

			$query = "select a.ASHAID, a.ASHAName, u.user_name FROM anmasha m 
			inner join mstasha a 
			on a.ASHAID = m.ASHAID
			inner join userashamapping ua 
			on a.ASHAID = ua.AshaID
			inner join tblusers u 
			on ua.UserID = u.user_id
			and m.ANMID = ".$content['filter_data']['ANM']."
			where a.LanguageID = 1 and a.IsDeleted = 0 and u.user_mode = 1 and u.is_deleted = 0";
			// die($query);

			$content['asha_list']= $this->db->query($query)->result();

		}else{

			$query = "select a.ASHAID, a.ASHAName, u.user_name FROM mstasha a
			inner join userashamapping ua 
			on a.ASHAID = ua.AshaID
			inner join tblusers u 
			on ua.UserID = u.user_id
			where u.user_mode=1 and a.LanguageID = 1
			and a.IsActive = 1 and u.user_mode = 1 and u.is_deleted = 0";

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

		$this->load->model('Mnch_dashboard_model');

		$demographic['total_households']['count'] = $this->Mnch_dashboard_model->get_total_households();
		// print_r($demographic['total_households']['count']); die();

		$demographic['total_population']['count'] = $this->Mnch_dashboard_model->get_total_population();

		$demographic['total_pregnent_women']['count'] = $this->Mnch_dashboard_model->get_total_preg_women();

		$demographic['child_0_to_1']['count'] = $this->Mnch_dashboard_model->get_child_0_to_1();

		$demographic['child_1_to_5']['count'] = $this->Mnch_dashboard_model->get_child_1_to_5();

		$demographic['child_2_to_5']['count'] = $this->Mnch_dashboard_model->get_child_2_to_5();

		$demographic['child_6_to_14']['count'] = $this->Mnch_dashboard_model->get_child_6_to_14();

		$demographic['child_15_to_49']['count'] = $this->Mnch_dashboard_model->get_child_15_to_49();

		$demographic['child_50_and_more']['count'] = $this->Mnch_dashboard_model->get_child_50_and_more();

		$demographic['preg_0_to_3']['count'] = $this->Mnch_dashboard_model->get_preg_0_to_3();

		$demographic['preg_4_to_6']['count'] = $this->Mnch_dashboard_model->get_preg_4_to_6();

		$demographic['preg_7_to_8']['count'] = $this->Mnch_dashboard_model->get_preg_7_to_8();

		$demographic['preg_9_and_more']['count'] = $this->Mnch_dashboard_model->get_9_and_more();


		$demographic['total_hrp_count']['count'] = $this->Mnch_dashboard_model->get_total_hrp_count();

	  $demographic['total_pregnent_women_last_three_months']['count'] = $this->Mnch_dashboard_model->total_pregnent_women_last_three_months();
		// print_r($demographic['total_pregnent_women_last_three_months']['count']); die();

		$demographic['Full_ANC']['count'] = $this->Mnch_dashboard_model->get_full_ANC();
		// print_r($demographic['Full_ANC']['count']); die();
		

		$demographic['Full_ANC']['percent'] = ($demographic['Full_ANC']['count'] / ($demographic['total_pregnent_women_last_three_months']['count'] == 0 ? 1 : $demographic['total_pregnent_women_last_three_months']['count']) * 100);
		// print_r($demographic['Full_ANC']['percent']);die();


		$demographic['child_12_to_24_months']['count'] = $this->Mnch_dashboard_model->get_child_12_to_24();
		$Full_Immunization = $demographic['child_12_to_24_months']['count'];

		$demographic['Full_Immunization']['count'] = $this->Mnch_dashboard_model->get_full_immunization();
		$demographic['Full_Immunization']['percent'] = number_format(($demographic['Full_Immunization']['count'] / ($Full_Immunization == 0 ? 1 : $Full_Immunization) * 100),1);

		// print_r($demographic['child_12_to_24_months']['count']); die();

		$content['demographic'] = $demographic;

// CBAC Section start


		$cbac['cbac_box']['total_cbac']      = $this->Mnch_dashboard_model->get_assessed_count();
		$cbac['cbac_box']['total_screening'] = $this->Mnch_dashboard_model->get_screened_count(); 
		$cbac['ht']['suspected']      = $this->Mnch_dashboard_model->get_ht_suspected();
		$cbac['ht']['detected']       = $this->Mnch_dashboard_model->get_ht_bp_detected();
		$cbac['ht']['followup']       = $this->Mnch_dashboard_model->get_ht_bp_followup();
		$cbac['bp']['suspected']      = $this->Mnch_dashboard_model->get_bp_suspected();
		$cbac['bp']['detected']       = $this->Mnch_dashboard_model->get_bp_detected();
		$cbac['bp']['followup']       = $this->Mnch_dashboard_model->get_bp_followup();
		$cbac['ht_bp']['suspected']   = $this->Mnch_dashboard_model->get_ht_bp_suspected();
		$cbac['ht_bp']['detected']    = $this->Mnch_dashboard_model->get_ht_bp_detected();
		$cbac['ht_bp']['followup']    = $this->Mnch_dashboard_model->get_ht_bp_followup();

		$cbac['ht']['assessed_male']  = $this->Mnch_dashboard_model->get_assessed_count_male();
		$cbac['ht']['assessed_female']  = $this->Mnch_dashboard_model->get_assessed_count_female();
		//$cbac['ht']['assessed_both']  = $this->Mnch_dashboard_model->get_assessed_count_both();
		$cbac['ht']['assessed_both']  = $cbac['ht']['assessed_male'] + $cbac['ht']['assessed_female'];
		$cbac['ht']['screened_male']  = $this->Mnch_dashboard_model->get_screened_count_male();
		$cbac['ht']['screened_female']  = $this->Mnch_dashboard_model->get_screened_count_female();
		$cbac['ht']['screened_both']  = $this->Mnch_dashboard_model->get_screened_count_total();
		$cbac['ht']['suspected_male']  = $this->Mnch_dashboard_model->get_ht_suspected_male();
		$cbac['ht']['suspected_female']  = $this->Mnch_dashboard_model->get_ht_suspected_female();
		$cbac['ht']['suspected_both']  = $this->Mnch_dashboard_model->get_ht_suspected_total();
		$cbac['ht']['detected_male']  = $this->Mnch_dashboard_model->get_ht_detected_male();
		$cbac['ht']['detected_female']  = $this->Mnch_dashboard_model->get_ht_detected_female();
		$cbac['ht']['detected_both']  = $this->Mnch_dashboard_model->get_ht_detected_total();
		$cbac['ht']['followup_male']  = $this->Mnch_dashboard_model->get_ht_followup_male();
		$cbac['ht']['followup_female']  = $this->Mnch_dashboard_model->get_ht_followup_female();
		$cbac['ht']['followup_both']  = $this->Mnch_dashboard_model->get_ht_followup_total();

		$cbac['bp']['assessed_male']  = $this->Mnch_dashboard_model->get_assessed_count_male();
		$cbac['bp']['assessed_female']  = $this->Mnch_dashboard_model->get_assessed_count_female();
		//$cbac['bp']['assessed_both']  = $this->Mnch_dashboard_model->get_assessed_count_both();
		$cbac['bp']['assessed_both']  = $cbac['ht']['assessed_male'] + $cbac['ht']['assessed_female'];
		$cbac['bp']['screened_male']  = $this->Mnch_dashboard_model->get_screened_count_male();
		$cbac['bp']['screened_female']  = $this->Mnch_dashboard_model->get_screened_count_female();
		$cbac['bp']['screened_both']  = $this->Mnch_dashboard_model->get_screened_count_total();
		$cbac['bp']['suspected_male']  = $this->Mnch_dashboard_model->get_bp_suspected_male();
		$cbac['bp']['suspected_female']  = $this->Mnch_dashboard_model->get_bp_suspected_female();
		$cbac['bp']['suspected_both']  = $this->Mnch_dashboard_model->get_bp_suspected_total();
		$cbac['bp']['detected_male']  = $this->Mnch_dashboard_model->get_bp_detected_male();
		$cbac['bp']['detected_female']  = $this->Mnch_dashboard_model->get_bp_detected_female();
		$cbac['bp']['detected_both']  = $this->Mnch_dashboard_model->get_bp_detected_total();
		$cbac['bp']['followup_male']  = $this->Mnch_dashboard_model->get_bp_followup_male();
		$cbac['bp']['followup_female']  = $this->Mnch_dashboard_model->get_bp_followup_female();
		$cbac['bp']['followup_both']  = $this->Mnch_dashboard_model->get_bp_followup_total();

    $cbac['ht_bp']['assessed_male']  = $this->Mnch_dashboard_model->get_assessed_count_male();
		$cbac['ht_bp']['assessed_female']  = $this->Mnch_dashboard_model->get_assessed_count_female();
	//	$cbac['ht_bp']['assessed_both']  = $this->Mnch_dashboard_model->get_assessed_count_both();
		$cbac['ht_bp']['assessed_both']  = $cbac['ht']['assessed_male'] + $cbac['ht']['assessed_female'];
		$cbac['ht_bp']['screened_male']  = $this->Mnch_dashboard_model->get_screened_count_male();
		$cbac['ht_bp']['screened_female']  = $this->Mnch_dashboard_model->get_screened_count_female();
		$cbac['ht_bp']['screened_both']  = $this->Mnch_dashboard_model->get_screened_count_total();
		$cbac['ht_bp']['suspected_male']  = $this->Mnch_dashboard_model->get_ht_bp_suspected_male();
		$cbac['ht_bp']['suspected_female']  = $this->Mnch_dashboard_model->get_ht_bp_suspected_female();
		$cbac['ht_bp']['suspected_both']  = $this->Mnch_dashboard_model->get_ht_bp_suspected_total();
		$cbac['ht_bp']['detected_male']  = $this->Mnch_dashboard_model->get_ht_bp_detected_male();
		$cbac['ht_bp']['detected_female']  = $this->Mnch_dashboard_model->get_ht_bp_detected_female();
		$cbac['ht_bp']['detected_both']  = $this->Mnch_dashboard_model->get_ht_bp_detected_total();
		$cbac['ht_bp']['followup_male']  = $this->Mnch_dashboard_model->get_ht_bp_followup_male();
		$cbac['ht_bp']['followup_female']  = $this->Mnch_dashboard_model->get_ht_bp_followup_female();
		$cbac['ht_bp']['followup_both']  = $this->Mnch_dashboard_model->get_ht_bp_followup_total();

		$cbac['counselled']['total']     =$this->Mnch_dashboard_model->get_assessed_count();

		$content['cbac'] = $cbac;


		// Queries for immunization Section.............


		$immunization['total_child']['count'] = $this->Mnch_dashboard_model->get_total_child();
		$total_child = $immunization['total_child']['count'];
		// print_r($total_child); die();

		$immunization['bcg']['count'] = $this->Mnch_dashboard_model->get_bcg();
		// print_r($immunization['bcg']['count']);
		// die();
		$immunization['bcg']['percent'] = ($immunization['bcg']['count'] / ($immunization['total_child']['count'] ==0?1:$immunization['total_child']['count'])) * 100;
		// print_r($immunization['bcg']['percent']); die();

		$immunization['opv1']['count'] = $this->Mnch_dashboard_model->get_opv1();
		$immunization['opv1']['percent'] = ($immunization['opv1']['count'] / ($immunization['total_child']['count'] == 0?1:$immunization['total_child']['count'])) * 100;
		// print_r($immunization['opv1']['precent']);die();

		$immunization['opv2']['count'] = $this->Mnch_dashboard_model->get_opv2();
		$immunization['opv2']['percent'] = ($immunization['opv2']['count'] / ($immunization['total_child']['count'] == 0?1:$immunization['total_child']['count'])) * 100;

		$immunization['opv3']['count'] = $this->Mnch_dashboard_model->get_opv3();
		$immunization['opv3']['percent'] = ($immunization['opv3']['count'] / ($immunization['total_child']['count'] == 0?1:$immunization['total_child']['count'])) * 100;

		$immunization['opv4']['count'] = $this->Mnch_dashboard_model->get_opv4();
		$immunization['opv4']['percent'] = ($immunization['opv4']['count'] / ($immunization['total_child']['count'] == 0?1:$immunization['total_child']['count'])) * 100;

		$immunization['hepb1']['count'] = $this->Mnch_dashboard_model->get_hepb1();
		$immunization['hepb1']['percent'] = ($immunization['hepb1']['count'] / ($immunization['total_child']['count'] == 0?1:$immunization['total_child']['count'])) * 100;

		$immunization['hepb2']['count'] = $this->Mnch_dashboard_model->get_hepb2();
		$immunization['hepb2']['percent'] = ($immunization['hepb2']['count'] / ($immunization['total_child']['count'] == 0?1:$immunization['total_child']['count'])) * 100;

		$immunization['hepb3']['count'] = $this->Mnch_dashboard_model->get_hepb3();
		$immunization['hepb3']['percent'] = ($immunization['hepb3']['count'] / ($immunization['total_child']['count'] == 0?1:$immunization['total_child']['count'])) * 100;

		$immunization['hepb4']['count'] = $this->Mnch_dashboard_model->get_hepb4();
		$immunization['hepb4']['percent'] = ($immunization['hepb4']['count'] / ($immunization['total_child']['count'] == 0?1:$immunization['total_child']['count'])) * 100;

		$immunization['dpt1']['count'] = $this->Mnch_dashboard_model->get_dpt1();
		$immunization['dpt1']['percent'] = ($immunization['dpt1']['count'] / ($immunization['total_child']['count'] == 0?1:$immunization['total_child']['count'])) * 100;

		$immunization['dpt2']['count'] = $this->Mnch_dashboard_model->get_dpt2();
		$immunization['dpt2']['percent'] = ($immunization['dpt2']['count'] / ($immunization['total_child']['count'] == 0?1:$immunization['total_child']['count'])) * 100;

		$immunization['dpt3']['count'] = $this->Mnch_dashboard_model->get_dpt3();
		$immunization['dpt3']['percent'] = ($immunization['dpt3']['count'] / ($immunization['total_child']['count'] == 0?1:$immunization['total_child']['count'])) * 100;

		$immunization['measeals']['count'] = $this->Mnch_dashboard_model->get_measeals();
		$immunization['measeals']['percent'] = ($immunization['measeals']['count'] / ($immunization['total_child']['count'] == 0?1:$immunization['total_child']['count'])) * 100;


		$content['immunization'] = $immunization;


		// Queries for child section................


		$delivery['child']['count'] = $this->Mnch_dashboard_model->get_child_count();
		$total_child_count = $delivery['child']['count'];

		// print_r($total_child_count); die();

		$delivery['low_weight_birth']['count'] = $this->Mnch_dashboard_model->get_low_weight_birth();
		$delivery['low_weight_birth']['percent'] = ($delivery['low_weight_birth']['count'] / ($total_child_count == 0?1:$total_child_count)) * 100;

		$delivery['institutional_delivery']['count'] = $this->Mnch_dashboard_model->get_2_or_more_times_within_first_7_days_of_institutional_delivery();
		$delivery['institutional_delivery']['percent'] = ($delivery['institutional_delivery']['count'] / ($total_child_count == 0?1:$total_child_count)) * 100;

		$delivery['place_of_delivery']['count'] = $this->Mnch_dashboard_model->get_place_of_delivery();
		$delivery['place_of_delivery']['percent'] = ($delivery['place_of_delivery']['count'] / ($total_child_count ==0?1:$total_child_count)) *100;
		// print_r($delivery['place_of_delivery']['percent']); die();

		$delivery['current_month_livebirth']['count'] = $this->Mnch_dashboard_model->get_current_month_delivery();

		$delivery['last_month_livebirth']['count'] = $this->Mnch_dashboard_model->get_last_month_delivery();

		$delivery['last_three_month_livebirth']['count'] = $this->Mnch_dashboard_model->get_last_three_month_delivery();

		$delivery['april_to_current_month_livebirth']['count'] = $this->Mnch_dashboard_model->get_april_to_current_month_livebirth();


		$delivery['current_month_infant_death']['count'] = $this->Mnch_dashboard_model->get_current_infant_death();

		$delivery['last_month_infant_death']['count'] = $this->Mnch_dashboard_model->get_last_month_infant_death();

		$delivery['last_three_month_infant_death']['count'] = $this->Mnch_dashboard_model->get_last_three_month_infant_death();

		$delivery['april_to_current_month_infant_death']['count'] = $this->Mnch_dashboard_model->get_april_to_current_month_infant_death();
		// print_r($delivery['last_three_month_infant_death']['count']); die();

		$content['delivery'] = $delivery;


		// queries for Antenatel care graph...........


		$antenatel['total_pregnent_women']['count'] = $this->Mnch_dashboard_model->get_total_pregnent_women();
		$total_pregnent_women = $antenatel['total_pregnent_women']['count'];

		$antenatel['registered_in_first_trimester']['count'] = $this->Mnch_dashboard_model->get_registered_in_first_trimester();

		$antenatel['registered_in_first_trimester']['percent'] = ($antenatel['registered_in_first_trimester']['count'] / ($total_pregnent_women == 0?1:$total_pregnent_women)) *100 ;
		// print_r($content['registered_in_first_trimester']['percent'] ); die();

		$antenatel['one_anc_checkup']['count'] = $this->Mnch_dashboard_model->get_one_anc_checkup();
		// die($antenatel['one_anc_checkup']['count']);
		$antenatel['one_anc_checkup']['percent'] = ($antenatel['one_anc_checkup']['count'] / ($demographic['preg_0_to_3']['count'] == 0?1:$demographic['preg_0_to_3']['count'])) *100;

		$antenatel['one_anc_checkup_in_4_to_6_month']['count'] = $this->Mnch_dashboard_model->one_anc_checkup_in_4_to_6_month();
		$antenatel['one_anc_checkup_in_4_to_6_month']['percent'] = ($antenatel['one_anc_checkup_in_4_to_6_month']['count'] / ($demographic['preg_4_to_6']['count'] == 0?1:$demographic['preg_4_to_6']['count'])) *100;


		$antenatel['one_anc_checkup_in_7_to_8_month']['count'] = $this->Mnch_dashboard_model->one_anc_checkup_in_7_to_8_month();
		$antenatel['one_anc_checkup_in_7_to_8_month']['percent'] = ($antenatel['one_anc_checkup_in_7_to_8_month']['count'] / ($demographic['preg_7_to_8']['count'] == 0?1:$demographic['preg_7_to_8']['count'])) *100;


		$antenatel['one_anc_checkup_9_and_more_months']['count'] = $this->Mnch_dashboard_model->one_anc_checkup_9_and_more_months();
		$antenatel['one_anc_checkup_9_and_more_months']['percent'] = ($antenatel['one_anc_checkup_9_and_more_months']['count'] / ($demographic['preg_9_and_more']['count'] == 0?1:$demographic['preg_9_and_more']['count'])) *100;
		// die($antenatel['one_anc_checkup_9_and_more_months']['percent']);


		$antenatel['two_anc_checkup']['count'] = $this->Mnch_dashboard_model->get_two_anc_checkup();
		$antenatel['two_anc_checkup']['percent'] = ($antenatel['two_anc_checkup']['count'] / ($demographic['preg_4_to_6']['count'] == 0?1:$demographic['preg_4_to_6']['count'])) *100;
		// die($antenatel['two_anc_checkup']['percent']);


		$antenatel['two_anc_checkup_in_7_to_8_months']['count'] = $this->Mnch_dashboard_model->two_anc_checkup_in_7_to_8_months();
		// die($antenatel['two_anc_checkup_in_7_to_8_months']['count']);
		$antenatel['two_anc_checkup_in_7_to_8_months']['percent'] = ($antenatel['two_anc_checkup_in_7_to_8_months']['count'] / ($demographic['preg_7_to_8']['count'] == 0?1:$demographic['preg_7_to_8']['count'])) *100;
		// die($antenatel['two_anc_checkup_in_7_to_8_months']['percent']);



		$antenatel['two_anc_checkup_9_and_more_months']['count'] = $this->Mnch_dashboard_model->two_anc_checkup_9_and_more_months();
		$antenatel['two_anc_checkup_9_and_more_months']['percent'] =  ($antenatel['two_anc_checkup_9_and_more_months']['count'] / ($demographic['preg_9_and_more']['count'] == 0?1:$demographic['preg_9_and_more']['count'])) *100;
		// die($antenatel['two_anc_checkup_9_and_more_months']['percent']);



		$antenatel['three_anc_checkup']['count'] = $this->Mnch_dashboard_model->get_three_anc_checkup();
		$antenatel['three_anc_checkup']['percent'] = ($antenatel['three_anc_checkup']['count'] / ($demographic['preg_7_to_8']['count'] == 0?1:$demographic['preg_7_to_8']['count'])) *100;


		$antenatel['three_anc_checkup_9_and_more_months']['count'] = $this->Mnch_dashboard_model->three_anc_checkup_9_and_more_months();
		$antenatel['three_anc_checkup_9_and_more_months']['percent'] = ($antenatel['three_anc_checkup_9_and_more_months']['count'] / ($demographic['preg_9_and_more']['count'] == 0?1:$demographic['preg_9_and_more']['count'])) *100;



		$antenatel['four_anc_checkup']['count'] = $this->Mnch_dashboard_model->get_four_anc_checkup();
		$antenatel['four_anc_checkup']['percent'] = ($antenatel['four_anc_checkup']['count'] / ($demographic['preg_9_and_more']['count'] == 0?1:$demographic['preg_9_and_more']['count'])) *100;



		$antenatel['comp_one_anc_checkup']['count'] = $this->Mnch_dashboard_model->comp_one_anc_checkup();
		$antenatel['comp_one_anc_checkup']['percent'] = ($antenatel['comp_one_anc_checkup']['count'] / ($demographic['total_pregnent_women']['count'] == 0?1:$demographic['total_pregnent_women']['count'])) *100;
		// die($antenatel['comp_one_anc_checkup']['percent']);



		$antenatel['comp_two_anc_checkup']['count'] = $this->Mnch_dashboard_model->comp_two_anc_checkup();
		$antenatel['comp_two_anc_checkup']['percent'] = ($antenatel['comp_two_anc_checkup']['count'] / ($demographic['total_pregnent_women']['count'] == 0?1:$demographic['total_pregnent_women']['count'])) *100;
		// die($antenatel['comp_two_anc_checkup']['percent']);



		$antenatel['comp_three_anc_checkup']['count'] = $this->Mnch_dashboard_model->comp_three_anc_checkup();
		$antenatel['comp_three_anc_checkup']['percent'] = ($antenatel['comp_three_anc_checkup']['count'] / ($demographic['total_pregnent_women']['count'] == 0?1:$demographic['total_pregnent_women']['count'])) *100;
		// die($antenatel['comp_three_anc_checkup']['percent']);
		

		$antenatel['comp_four_anc_checkup']['count'] = $this->Mnch_dashboard_model->comp_four_anc_checkup();
		$antenatel['comp_four_anc_checkup']['percent'] = ($antenatel['comp_four_anc_checkup']['count'] / ($demographic['total_pregnent_women']['count'] == 0?1:$demographic['total_pregnent_women']['count'])) *100;
		// die($antenatel['comp_four_anc_checkup']['percent']);






		$antenatel['tt2_or_booster']['count'] = $this->Mnch_dashboard_model->get_tt2_or_booster();
		$antenatel['tt2_or_booster']['percent'] = ($antenatel['tt2_or_booster']['count'] / ($total_pregnent_women == 0?1:$total_pregnent_women)) *100;


		$content['antenatel'] = $antenatel;

	// $pnchomevisit['pnc_home_visits']['count'] = $this->Mnch_dashboard_model->get_pnc_home_visit_counts();

	$pnchomevisit['pnc_home_visit_1']['count'] = $this->Mnch_dashboard_model->get_pnc_home_visit_1();
	$pnchomevisit['pnc_home_visit_1']['percent'] = ($pnchomevisit['pnc_home_visit_1']['count'] / ($total_child_count == 0?1:$total_child_count)) *100;

	$pnchomevisit['pnc_home_visit_2']['count'] = $this->Mnch_dashboard_model->get_pnc_home_visit_2();
	$pnchomevisit['pnc_home_visit_2']['percent'] = ($pnchomevisit['pnc_home_visit_2']['count'] / ($total_child_count == 0?1:$total_child_count)) *100;

	$pnchomevisit['pnc_home_visit_3']['count'] = $this->Mnch_dashboard_model->get_pnc_home_visit_3();
	$pnchomevisit['pnc_home_visit_3']['percent'] = ($pnchomevisit['pnc_home_visit_3']['count'] / ($total_child_count == 0?1:$total_child_count)) *100;

	$pnchomevisit['pnc_home_visit_4']['count'] = $this->Mnch_dashboard_model->get_pnc_home_visit_4();
	$pnchomevisit['pnc_home_visit_4']['percent'] = ($pnchomevisit['pnc_home_visit_4']['count'] / ($total_child_count == 0?1:$total_child_count)) *100;

	$pnchomevisit['pnc_home_visit_5']['count'] = $this->Mnch_dashboard_model->get_pnc_home_visit_5();
	$pnchomevisit['pnc_home_visit_5']['percent'] = ($pnchomevisit['pnc_home_visit_5']['count'] / ($total_child_count == 0?1:$total_child_count)) *100;

	$pnchomevisit['pnc_home_visit_6']['count'] = $this->Mnch_dashboard_model->get_pnc_home_visit_6();
	$pnchomevisit['pnc_home_visit_6']['percent'] = ($pnchomevisit['pnc_home_visit_6']['count'] / ($total_child_count == 0?1:$total_child_count)) *100;

	$pnchomevisit['pnc_home_visit_7']['count'] = $this->Mnch_dashboard_model->get_pnc_home_visit_7();
	$pnchomevisit['pnc_home_visit_7']['percent'] = ($pnchomevisit['pnc_home_visit_7']['count'] / ($total_child_count == 0?1:$total_child_count)) *100;

	// print_r($pnchomevisit['pnc_home_visit_7']['percent']); die();

	$content['pnchomevisit'] = $pnchomevisit;

		$content['subview'] = 'mnch_dashboard_view';
		$this->load->view('auth/main_layout', $content);
	}

public function getHRPReport($data = array(), $start_row = 2)
{
	error_reporting(E_ALL);
		date_default_timezone_set('Asia/Kolkata');
		require_once APPPATH . 'libraries/PHPExcel/IOFactory.php';
		require_once  APPPATH . 'libraries/PHPExcel.php';

		$excel2 = PHPExcel_IOFactory::createReader('Excel2007');
		PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);
		$excel2 = $excel2->load(FCPATH . 'datafiles/HRP_Report.xlsx');
		$excel2->setActiveSheetIndex(0);

		/**
		*Code for rows
		*/

		// load model after the filter is all set
		$this->load->model('Mnch_dashboard_model');
		$data = $this->Mnch_dashboard_model->get_hrp_report();

		foreach ($data as $row) {
			$excel2->getActiveSheet()
			->setCellValue('A'.$start_row, $row->SubCenterID)
			->setCellValue('B'.$start_row, $row->SubCenterName)
			->setCellValue('C'.$start_row, $row->ANMID)
			->setCellValue('D'.$start_row, $row->ANMName)
			->setCellValue('E'.$start_row, $row->AshaID)
			->setCellValue('F'.$start_row, $row->ASHAName)
			->setCellValue('G'.$start_row, $row->user_name)
			->setCellValue('H'.$start_row, $row->phone_no)
			->setCellValue('I'.$start_row, $row->HHCode)
			->setCellValue('J'.$start_row, $row->PWName)
			->setCellValue('K'.$start_row, $row->MotherMCTSID)
			->setCellValue('L'.$start_row, $row->MobileNo)
			->setCellValue('M'.$start_row, $row->LMPDate)
			->setCellValue('N'.$start_row, $row->EDDDate)
			->setCellValue('O'.$start_row, $row->days)
			->setCellValue('P'.$start_row, $row->anticipated_visits)
			->setCellValue('Q'.$start_row, $row->ActualVisits)
			->setCellValue('R'.$start_row, $row->Difference)
			->setCellValue('S'.$start_row, $row->PWGUID);


			$start_row++;
		}


		$objWriter = PHPExcel_IOFactory::createWriter($excel2, 'Excel2007');
		header('Content-type: application/vnd.ms-excel');

		// It will be called file.xls
		header('Content-Disposition: attachment; filename="HRP_Report.xlsx"');

		ob_end_clean();
		$file_name = "consolidated_report.xlsx";
		$objWriter->save(FCPATH . "datafiles/$file_name");
		readfile(FCPATH . "datafiles/$file_name");
		exit();
}


}