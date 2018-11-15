<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Track_Changes extends Auth_controller {

	public function __construct()
	{
		parent::__construct();
		$this->loginData = $this->session->userdata('loginData');
	}
	
	public function index($uuashaid = NULL, $TrackChangesPDF = ' ')
	{	
		// start permission 
		$user_role = $this->loginData->user_role;
		$query = "SELECT * FROM role_permissions as rp LEFT JOIN mstrole as mst on rp.RoleID=mst.RoleID WHERE rp.RoleID='$user_role' ";
		$content['role_permission'] = $this->Common_Model->query_data($query);
		// end permission 
		
		//$query = "select * from mststate where IsDeleted=0 and LanguageID = 1";
		$query = "SELECT * FROM mstsubcenter as sub LEFT JOIN mststate as st on sub.StateCode=st.StateCode LEFT JOIN mstasha as ash on ash.SubCenterCode=sub.SubCenterCode where ash.LanguageID=1 and st.LanguageID=1 and sub.LanguageID=1 group by ash.ASHACode,ash.SubCenterCode";

		if ($this->loginData->user_role == 1 || $this->loginData->user_role == 2 || $this->loginData->user_role == 3 || $this->loginData->user_role == 6) 	 {
			$query .= "	and sub.StateCode='".$this->loginData->state_code."' ";
       
			// add district based filter if district role
			if ($this->loginData->user_role == 7) {
				$query .= " and district_code ='".$this->loginData->district_code."' ";
			}
			// add district based filter if block role
			if ($this->loginData->user_role == 8) {
				$query .= " and block_code ='".$this->loginData->block_code."' ";
			}

		}
		$content['Asha_List'] = $this->Common_Model->query_data($query);
        //print_r($content['Asha_List']); die();
		$RequestMethod = $this->input->server('REQUEST_METHOD');
		if($RequestMethod == "POST")
		{
			$month = $this->input->post("month");
			$startDate = date("Y-m-d", strtotime("-$month month"));
			$endDate = date("Y-m-d");

			$uuashaid = $this->input->post('ASHACode');

			$content['Track_List'] = $this->db->query("CALL filldates('$startDate','$endDate', $uuashaid)")->result();	
		}else{
			$content['Track_List']= array();
		}


		$content['subview'] = "list_trackchanges";


		if ($TrackChangesPDF == "export_pdf") {
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
