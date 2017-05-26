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
			case "tblhhfamilymember":
			case "tblhhsurvey":
			case "tblmigration":
			case "tblancvisit":
			case "tbl_datesed":
			case "tblpnchomevisit_ans":
			case "tblmstimmunizationans":
			case "tblmstfpans":
			case "tblmstfpfdetail":
			case "tblpregnant_woman":
				$content = $this->msakhi_api_model->get_table_data($this->user, $sFlag);
				break;
			case "tblchild":
				$content = $this->msakhi_api_model->get_table_data($this->user, $sFlag, "created_by");
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
		header("Content-Type: application/json");
		die(json_encode($content));
	}

	public function make1900Null($table_name)
	{
		// $table_name = "tblchild";
		$tableFields = $this->db->list_fields($table_name);
		
		foreach ($tableFields as $field) {
			$query = "update $table_name set $field=null where $field='1900-01-01'";
			$this->db->query($query);
		}

	}




	
}