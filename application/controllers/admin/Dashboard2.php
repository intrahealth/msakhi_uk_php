<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard2 extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Dashboard2_model');
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
		 * start getting data from dashboard2 model
		 */
		$content['household_count'] = $this->Dashboard2_model->get_household_count();
		$content['pregnancy_count'] = $this->Dashboard2_model->get_pregnancies_registered_count();
		$content['child_registration_count'] = $this->Dashboard2_model->get_child_registration_count();
		$content['immunization_count'] = $this->Dashboard2_model->get_child_partial_immunization_count();

		$content['fp_block'] = $this->Dashboard2_model->fp_block();
		$content['p_block'] = $this->Dashboard2_model->p_block();
		$content['i_block'] = $this->Dashboard2_model->i_block();

		$content['subview'] = 'dashboard2';
		$content['anm_list'] = $this->get_anm_list();

		$content['household_trend'] = $this->Dashboard2_model->get_household_trend();
		$content['pregnancy_registration_trend'] = $this->Dashboard2_model->get_pregnancy_registration_trend();
		$content['child_registration_trend'] = $this->Dashboard2_model->get_child_registration_trend();
		$content['child_immunization_trend'] = $this->Dashboard2_model->get_child_immunization_trend();

		$content['trends'] = $this->Dashboard2_model->get_trend_statistics();

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

	
}
