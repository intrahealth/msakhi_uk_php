<?php 

/**
 * Api_ondemand
 */
class Api_ondemand extends Ci_controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('Ondemand_api_model');
	}

	public function index()
	{
		echo "On Demand app";
	}

	public function scheduler()
	{
		$this->Ondemand_api_model->scheduler();
	}

	private function response($response)
	{
		header('Content-Type: application/json');
		die(json_encode(["response"=>[$response]]));
	}

	public function register()
	{
		$RequestMethod = $this->input->server('REQUEST_METHOD');
		if($RequestMethod != "POST")
		{
			$response = array(
				'status' => 1,
				'message'	=>	"only POST method allowed"
			);
			$this->response($response);
		}

		$this->Ondemand_api_model->register();
	}

	public function login()
	{
		$RequestMethod = $this->input->server('REQUEST_METHOD');
		if($RequestMethod != "POST")
		{
			$response = array(
				'status' => 1,
				'message'	=>	"only POST method allowed"
			);
			$this->response($response);
		}

		$this->Ondemand_api_model->login();
	}

	public function verify_otp()
	{
		$MobileNo = $this->input->post('mobile_no');
		$OTP = $this->input->post('otp');

		$this->db->where('MobileNo', $MobileNo);
		$result = $this->db->get('ondemand_tbluser')->result();

		if (count($result) < 1) 
		{
			$response = array(
				'status' => 1,
				'message'	=>	"No user found with this mobile number - " . $MobileNo
			);
			$this->response($response);
		}

		if (strtotime(strtotime(date("Y-m-d H:i:s") > $result[0]->OTPExpiryDatetime))) 
		{
			$response = array(
				'status' => 1,
				'message'	=>	"OTP code has expired, please try register again"
			);
			$this->response($response);
		}

		if ($result[0]->OTP != $OTP) 
		{
			$response = array(
				'status' => 1,
				'message'	=>	"OTP code mis-match."
			);
			$this->response($response);
			
		}

		$PIN = $this->input->post('pin');
		$IMEI = $this->input->post('IMEI');

		// update ondemand_tbluser.IsActive = 1
		// update ondemand_tbluser.PIN

		$this->db->where('MobileNo', $MobileNo);
		$updateArr = array(
			'IsActive'  => 1,
			'UpdatedOn' =>	date('Y-m-d H:i:s'),
			'PIN'       => $PIN,
			'IMEI'		=> $IMEI,
		);
		$this->db->update('ondemand_tbluser', $updateArr);

		$this->Ondemand_api_model->download_masters_and_data($MobileNo);

	}

	public function upload()
	{
		$this->Ondemand_api_model->upload();
	}

	public function generate_qr_child()
	{
		$this->Ondemand_api_model->generate_qr_child();
	}

	public function generate_qr_mother()
	{
		$this->Ondemand_api_model->generate_qr_mother();
	}

}