<?php 

class Api extends CI_Controller
{
	private $user;

	public function __construct()
	{
		
		parent::__construct();
		$this->load->model('Common_Model');
		$this->load->model('msakhi_api_model');
		$auth_res = $this->msakhi_api_model->authenticateApiUser();

		if(is_string($auth_res))
		{
			die($auth_res);
		}
		$this->user = $auth_res;
	}

	public function login()
	{
		header("Content-Type: application/json");

		$content = $this->msakhi_api_model->get_masters($this->user);
		
		$users[0] = $this->user;
		$content["tblusers"] = $users;

		die(json_encode($content));
		
	}

	public function index()
	{

	}

	public function getMasterData()
	{

		$sFlag = $this->input->post('sFlag');
		switch ($sFlag) {
			case 'Master':
			$content = $this->msakhi_api_model->get_masters($this->user);
			break;

			case "incentive":
			$content = $this->msakhi_api_model->get_table_data_by_ashaid($this->user, "tblincentivesurvey");
			$content += $this->msakhi_api_model->get_table_data_by_ashaid($this->user, "tblashaincentivedetail");
			$content += $this->msakhi_api_model->get_table_data_by_ashaid($this->user, "tblashaclaim");
			break;
			
			// case "tblhhfamilymember":
			case "tblhhsurvey":
			case "tblmigration":
			// case "tblancvisit":
			case "tbl_datesed":
			case "tblpnchomevisit_ans":
			case "tblmstimmunizationans":
			// case "tblfp_visit":
			// case "tblfp_followup":
			// case "tblpregnant_woman":
			case "tbl_vhnd_duelist":
			case "tbl_vhndperformance":
			case "tblvhndduelist":
			case "tblncdfollowup":
			$content = $this->msakhi_api_model->get_table_data($this->user, $sFlag);
			break;
			// case "tblchild":
			// $content = $this->msakhi_api_model->get_table_data($this->user, $sFlag, "created_by");
			break;
			case "tblncdcbac":
			case "tblncdscreening":
			case "tblncdscreeningmedicine":
			case "tblncdcbacdiagnosis":

			/**
			 * New tables for fetching data through AshaID
			 */
			case "tblchild":

			case "tblpregnant_woman":
			case "tblancvisit":

			case "tblfp_visit":
			case "tblfp_followup":

			case "tblhhfamilymember":

			$content = $this->msakhi_api_model->get_table_data_by_ashaid($this->user, $sFlag);
			break;
			case "Questions":
			$content = $this->msakhi_api_model->get_question_tables();
			break;
			default:
			die("ERROR: the sFlag $sFlag is not supported");
			break;
		}

		header("Content-Type: application/json");
		die(json_encode($content));
	}

	public function uploadData()
	{

		$content = $this->msakhi_api_model->uploadData($this->user);

		$data = $this->input->post('data');

		if (is_array($content)) {
			// insert success log
			$insertArr = array(
				'UserID' => $this->user->user_id, 
				'JSON'=> $data,
				'ImpotedOn'	=>	date("Y-m-d H:i:s"),
				'Status'=>'Success',
				'Message'=>json_encode($content),
				'ErrorNumber'=>NULL,
				'ErrorMessage'=>NULL,
			);
			$this->db->insert('tablet_dataimport', $insertArr);

		}else{


			// insert error log
			$db_error = $this->db->error();

			$insertArr = array(
				'UserID' => $this->user->user_id, 
				'JSON'=> $data,
				'ImpotedOn'	=>	date("Y-m-d H:i:s"),
				'Status'=>'Error',
				'Message'=>json_encode($content),
				'ErrorNumber'=>$db_error['code'],
				'ErrorMessage'=>(trim($db_error['message']) == ""?NULL:trim($db_error['message'])),
			);
			$e = $this->db->insert('tablet_dataimport', $insertArr);
			if ($e == FALSE) {
				echo "error in executing " . print_r($this->db->error(), TRUE);
			}
		}

		header("Content-Type: application/json");
		die(json_encode($content));
	}

	public function make1900Null($table_name)
	{
		$tableFields = $this->db->list_fields($table_name);
		
		foreach ($tableFields as $field) {
			$query = "update $table_name set `$field`= NULL where `$field` = '1900-01-01'";
			$this->db->query($query);
		}

	}

	public function PutImage()
	{
		
		$result = $this->msakhi_api_model->PutImage();
		die($result);
	}

	public function DownloadFile()
	{
		$this->msakhi_api_model->DownloadFile();
	}



	public function get_aadhaar_data()
	{
		header("Content-Type: application/json");

		$anm_id = $this->input->post('anmid');
		$AshaID = $this->input->post('ashaid');
		$userid = $this->input->post('userid');
		$UniqueIDNumber  = $this->input->post('adharcard');
		$FamilyMemberName  = $this->input->post('name');

		if( $UniqueIDNumber != "" && $UniqueIDNumber != NULL)
		{

		$query = "select b.FamilyMemberName, b.HHSurveyGUID, a.HHCode FROM tblhhsurvey a inner join tblhhfamilymember b on a.HHSurveyGUID = b.HHSurveyGUID where b.UniqueIDNumber = '".$UniqueIDNumber."' and b.AshaID = ".$AshaID."";
		// print_r($query);die();

		$data['data'] = $this->db->query($query)->result();
			echo json_encode($data);
		}
		else 
		{
			// $query = "Select b.FamilyMemberName, b.HHSurveyGUID, a.HHCode from tblhhsurvey a inner join tblhhfamilymember b on a.HHSurveyGUID = b.HHSurveyGUID where FamilyMemberName like '%".$FamilyMemberName."%' and b.AshaID = ".$AshaID."";

			$query = "select
			a.AshaID,
			a.FamilyMemberName,
			b.FamilyMemberName AS HeadName,
			c.HHCode,
			a.HHSurveyGUID
			FROM
			tblhhfamilymember a
			LEFT JOIN tblhhfamilymember b ON
			a.HHSurveyGUID = b.HHSurveyGUID AND b.RelationID = 1
			left JOIN tblhhsurvey c ON
			a.HHSurveyGUID = c.HHSurveyGUID where a.FamilyMemberName like '%".$FamilyMemberName."%' and a.AshaID = ".$AshaID."";
			// print_r($query); die();

			$data['data'] = $this->db->query($query)->result();
			echo json_encode($data);
		}
	}


	public function get_hhsurveyid_data()
	{
		header("Content-Type: application/json");

		$HHSurveyGUID = $this->input->post('HHSurveyGUID');

		$query = "select * from tblhhsurvey where HHSurveyGUID = '".$HHSurveyGUID."'";
		$date['tblhhsurvey'] = $this->db->query($query)->result();

		$query = "select * from tblhhfamilymember where HHSurveyGUID = '".$HHSurveyGUID."'";
		$date['tblhhfamilymember'] = $this->db->query($query)->result();

		echo json_encode($date);
	}

	public function download_pdf()
	{
		$report_id = $this->input->post('report_id');
		$result = $this->msakhi_api_model->download_pdf($report_id);
		echo json_encode($result);
	}

	public function get_af_data()
	{
		header("Content-Type: application/json");
		$result = $this->msakhi_api_model->get_af_data();
		echo json_encode($result);
	}


	
}