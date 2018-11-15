<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hrp extends Auth_controller {

	public function __construct()
	{
		parent::__construct();
		$this->loginData = $this->session->userdata('loginData');
		$this->load->model('Mnch_dashboard_model');
	}


	public function index($HRP_Pdf = ' ')
	{
     // start permission 
		$user_role = $this->loginData->user_role;
		$query = "SELECT * FROM role_permissions as rp LEFT JOIN mstrole as mst on rp.RoleID=mst.RoleID WHERE rp.RoleID='$user_role' ";
		$content['role_permission'] = $this->Common_Model->query_data($query);
		// end permission 


		// load model after the filter is all set
		$this->load->model('Hrp_model');
		$hrp_summary = $this->Hrp_model->get_hrp_summary();

		$content['hrp_summary'] = $hrp_summary;

		$content['total_pregnant_women'] = $this->Mnch_dashboard_model->get_total_preg_women();

		// print_r($content['hrp_summary']); die();

/*		$total = 0;
		foreach ($hrp_summary as $key => $value) {
			$total += $value;
		}
		$content['total_hrp'] = $total;*/

		$this->db->where('is_visible', 1);
		$content['indicator_group_list'] = $this->db->get('tbl_indicator_group')->result();

	
		$content['subview'] = 'hrp_report';

		if ($HRP_Pdf == "export_pdf") {
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