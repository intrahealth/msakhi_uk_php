<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Track_Changes extends Gov_Controller {

	public function __construct()
	{
		parent::__construct();
	}
	
	public function index($uuashaid = NULL)
	{	
		$query = "select * from mstasha where LanguageID=1 and IsDeleted = 0";

		$content['Asha_List'] = $this->Common_Model->query_data($query);

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
		$this->load->view('gov/main_layout', $content);
	}
	
} 
