<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Immunization_administered extends Auth_controller {

	public function __construct()
	{
		parent::__construct();
		$this->loginData = $this->session->userdata('loginData');
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


				$this->session->set_userdata("filter_data_list", $filter_data);

			} elseif ($command == "clear_filter") {

				$filter_data = array(
					"ANM" 	=>	array(),
					"Asha"	=>	array(),
					"date_from"	=>	NULL,
					"date_to"	=>	NULL,
				);

				$this->session->set_userdata("filter_data_list", $filter_data);

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

			$this->session->set_userdata("filter_data_list", $filter_data);

		}

	}

	public function index($ImmunizationPDF = ' ')
	{
		 // start permission 
		$user_role = $this->loginData->user_role;
		$query = "SELECT * FROM role_permissions as rp LEFT JOIN mstrole as mst on rp.RoleID=mst.RoleID WHERE rp.RoleID='$user_role' ";
		$content['role_permission'] = $this->Common_Model->query_data($query);
		// end permission 

		$this->apply_filter();
		
		$content['filter_data'] = $this->session->userdata("filter_data_list");

		// print_r($content); die();

		$query = "select * from mstanm where LanguageID = 1";
		$content['anm_list'] = $this->db->query($query)->result();
		
		if (is_array($content['filter_data']['ANM']) && count($content['filter_data']['ANM']) > 0) 
		{

			$query = "select a.ASHAID, a.ASHAName FROM anmasha m 
			inner join mstasha a 
			on a.ASHAID = m.ASHAID
			and m.ANMID in (". implode(",",$content['filter_data']['ANM']).")
			where a.LanguageID = 1";

			$content['asha_list']= $this->db->query($query)->result();

		}else{

			$content['asha_list'] = array();
			
		}


		/**
		 * start getting data from dashboard3 model
		 */

		// load model after the filter is all set
		$this->load->model('Immunization_administered_model');
		$content['immunization_summary'] = $this->Immunization_administered_model->get_immunization_summary();
		// echo "<pre>";

		// print_r($content['immunization_summary']); die();

		$this->db->where('is_visible', 1);
		$content['indicator_group_list'] = $this->db->get('tbl_indicator_group')->result();

		$content['subview'] = 'immunization_administered_report';

		if ($ImmunizationPDF == "export_pdf") {
			$this->export_section($content);
			die();
		}
		

		$this->load->view('auth/main_layout', $content);
	}

	public function export_section($content = array())
	{

		// <link rel='stylesheet' href='" . site_url() . "common/frontend/bootstrap.min.css'>

		$dom = "<!DOCTYPE html>
		<html lang='en'>
		<head>
		<meta charset='UTF-8'>
		<title>Document</title>
		
		</head>
		<body>";
		$dom .= $this->load->view("print/" . $content['subview'] , $content, true);
		
		$dom .= "
		</body>
		</html>";

		$this->load->model('Dompdf_model');
		$this->Dompdf_model->export($dom);
		
	}

}