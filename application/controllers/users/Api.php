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

	private function check_auth_login($user_name, $password)
	{	
		$sql = "select * from tblusers where user_name = '".$user_name."' limit 1";
		$res = $this->db->query($sql);

		$res_row = $res->result();

		if($res_row[0]->user_name === $user_name && $res_row[0]->password === md5($password))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	private function getuserid($user_name, $password)
	{
		$sql = "select * from tblusers where user_name = '".$user_name."' and password = '".md5($password)."'";
		$res = $this->Common_Model->query_data($sql);

		return $res[0]->id_tblusers;
	}

	public function index()
	{

	}

	public function getdataDownload()
	{	

		$sFlag = $this->input->post('sFlag');
		if($sFlag == null || trim($sFlag) == ''){
			die("ERROR: No sFlag parameter sent with request");
		}

		switch ($sFlag) {
			case 'Master':
			$content = $this->msakhi_api_model->getMasters();
			break;
			case 'Data':
			$content = $this->msakhi_api_model->getData();
			break;
			case 'MNCH':
			$content = $this->msakhi_api_model->getMNCH();
			break;
			case 'Counseling':
			$content = $this->msakhi_api_model->getCounseling();
			break;
			default:
			die("ERROR: sFlag type not found/invalid");
			break;
		}

		header("Content-Type: application/json");
		die(json_encode($content));
	}

	
}