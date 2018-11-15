<?php 

/**
 * Ondemand_api_model
 */
class Ondemand_api_model extends Ci_model
{

	private $loginData;
	
	public function __construct()
	{
		parent::__construct();
	}

	private function response($response)
	{
		header('Content-Type: application/json');
		die(json_encode(["response"=>[$response]]));
	}

	public function scheduler()
	{
		$this->db->where("OTPExpiryDatetime < '" . date('Y-m-d H:i:s') . "'");
		$this->db->where('IsActive', 0);
		$result = $this->db->delete('ondemand_tbluser');
	}

	public function register()
	{
		if ($this->input->post('mobile_no') != null) 
		{

			$query = "select a.MobileNo, b.HHSurveyGUID, b.HHFamilyMemberGUID, b.FamilyMemberName, b.AshaID, b.ANMID  from (select * from tblpregnant_woman where MobileNo=?) a 
			inner join tblhhfamilymember b 
			on a.HHFamilyMemberGUID = b.HHFamilyMemberGUID";
			$result = $this->db->query($query, [$this->input->post('mobile_no')])->result();

			if (count($result) < 1) 
			{
				$response = array(
					'status'  => 1,
					'mobile'  => null,
					'message' => "This mobile number is not registred. Please get in touch with your nearest ASHA to get your mobile number registered in the system"
				);

				$this->response($response);

			}
			else if (count($result) > 1)
			{
				$response = array(
					'status'  => 1,
					'mobile'  => null,
					'message' => "More than 1 user found with mobile number same as " . $this->input->post('mobile_no') . " please get in touch with nearest ASHA for this issue"
				);

				$this->response($response);
			}
			
		}
		elseif ($this->input->post('adhaar_no') != null) 
		{
			$query = "select a.MobileNo, b.HHSurveyGUID, b.HHFamilyMemberGUID, b.FamilyMemberName, b.AshaID, b.ANMID from (select * from tblpregnant_woman) a 
			inner join (select * from tblhhfamilymember where UniqueIDNumber=?) b 
			on a.HHFamilyMemberGUID = b.HHFamilyMemberGUID";
			$result = $this->db->query($query, [$this->input->post('adhaar_no')])->result();
			if (count($result) < 1)
			{
				$response = array(
					'status'  => 1,
					'mobile'  => null,
					'message' => "This mobile number is not registred. Please get in touch with your nearest ASHA to get your mobile number registered in the system"
				);

				$this->response($response);

			}else if (count($result) > 1) {
				$response = array(
					'status'  => 1,
					'mobile'  => null,
					'message' => "More than 1 user found with adhaar number same as " . $this->input->post('adhaar_no') . " please get in touch with nearest ASHA for this issue"
				);

				$this->response($response);
			}
			
		}
		elseif ($this->input->post('mcts_id') != null) 
		{
			$query = "select a.MobileNo, b.HHSurveyGUID, b.HHFamilyMemberGUID, b.FamilyMemberName, b.AshaID, b.ANMID from (select * from tblpregnant_woman where MotherMCTSID=?) a 
			inner join tblhhfamilymember b 
			on a.HHFamilyMemberGUID = b.HHFamilyMemberGUID";
			$result = $this->db->query($query, [$this->input->post('mcts_id')])->result();
			if (count($result) < 1) {
				$response = array(
					'status'  => 1,
					'mobile'  => null,
					'message' => "This mobile number is not registred. Please get in touch with your nearest ASHA to get your mobile number registered in the system"
				);

				$this->response($response);

			}else if (count($result) > 1) {
				$response = array(
					'status'  => 1,
					'mobile'  => null,
					'message' => "More than 1 user found with MCTS ID number same as " . $this->input->post('mcts_id') . " please get in touch with nearest ASHA for this issue"
				);

				$this->response($response);
			}

		}
		else
		{
			$response = array(
				'status'  => 1,
				'mobile'  => null,
				'message' => "No supported ID sent. Please sent mobile number, adhaar or mcts_id in request"
			);

			$this->response($response);
		}

		$userRecord = array(
			'MobileNo'           => $result[0]->MobileNo,
			'HHSurveyGUID'       => $result[0]->HHSurveyGUID,
			'HHFamilyMemberGUID' => $result[0]->HHFamilyMemberGUID,
			'FamilyMemberName'   => $result[0]->FamilyMemberName,
			'ANMID'              => $result[0]->ANMID,
			'AshaID'             => $result[0]->AshaID,
		);

		// get demographics details from tbluser of this asha

		$query = "select a.ASHAID, c.state_code, c.district_code, c.block_code from mstasha a 
		inner join userashamapping b 
		on a.ASHAID = b.AshaID and a.IsActive = 1 and a.LanguageID = 1
		inner join tblusers c 
		on b.UserID = c.user_id
		where a.ASHAID = ?";
		$result = $this->db->query($query, $result[0]->AshaID)->result();
		if (count($result) < 1)
		{
			$response = array(
				'status'  => 1,
				'mobile'  => null,
				'message' => "No ASHA record found linked with this user. Please get in touch with system admin"
			);

			$this->response($response);
		}

		$userRecord['StateCode'] = $result[0]->state_code;
		$userRecord['DistrictCode'] = $result[0]->district_code;
		$userRecord['BlockCode'] = $result[0]->block_code;

		$this->createTemporaryUser($userRecord);
	}

	private function authenticate()
	{
		$MobileNo = $this->security->xss_clean($this->input->post('mobile_no'));
		$PIN = $this->security->xss_clean($this->input->post('pin'));

		$this->db->where('MobileNo', $MobileNo);
		$this->db->where('PIN', $PIN);
		$result = $this->db->get('ondemand_tbluser')->result();
		if (count($result) < 1) {
			$response = array(
				'status'  => 1,
				'mobile'  => null,
				'message' => "Incorrect mobile number / pin"
			);

			$this->response($response);
		}

		$this->loginData = $result[0];
	}

	public function login()
	{
		$this->authenticate();
		$MobileNo = $this->input->post('mobile_no');
		$this->download_masters_and_data($MobileNo);
	}

	private function sendOTP($MobileNo, $OTP)
	{
		$url = 'http://apps.smslane.com/vendorsms/pushsms.aspx?user=kkumar.sandeep89@gmail.com&password=%20mSakhi@123&msisdn=91'.$MobileNo.'&sid=MSAKHI&msg=Dear%20user,%20Your%20OTP%20for%20registration%20is%20'.$OTP.'%20.&fl=0&gwid=2';

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$response = curl_exec($ch);
		
		if (substr($response, 0, 14) != 'The Message Id') 
		{
			$response = array(
				'status'  => 1,
				'message' => "Error sending OTP with error: " . $response
			);
			$this->response($response);
		}
	}

	private function createTemporaryUser($userRecord)
	{

		// check if there already exists a user in ondemand table for this mobile number

		$this->db->where('MobileNo', $userRecord['MobileNo']);
		$result = $this->db->get('ondemand_tbluser')->result();
		if (count($result) > 0) {
			$response = array(
				'status'  => 1,
				'mobile'  => null,
				'message' => "There is already a members registered with this mobile number. Please login instead"
			);
			$this->response($response);
		}

		$OTP = rand(1000,9999);
		$OTPExpiryDatetime = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s')) + 60*30);
		$this->sendOTP($userRecord['MobileNo'], $OTP);

		$insertArr = array(
			'MobileNo'           => $userRecord['MobileNo'],
			'HHSurveyGUID'       => $userRecord['HHSurveyGUID'],
			'HHFamilyMemberGUID' => $userRecord['HHFamilyMemberGUID'],
			'FamilyMemberName'   => $userRecord['FamilyMemberName'],
			'StateCode'          => $userRecord['StateCode'],
			'DistrictCode'       => $userRecord['DistrictCode'],
			'BlockCode'          => $userRecord['BlockCode'],
			'ANMID'              => $userRecord['ANMID'],
			'AshaID'             => $userRecord['AshaID'],
			'OTP'                => $OTP,
			'OTPExpiryDatetime'  => $OTPExpiryDatetime,
			'CreatedOn'          => date("Y-m-d H:i:s"),
			'UpdatedOn'          => date("Y-m-d H:i:s"),
		);

		$status = $this->db->insert('ondemand_tbluser', $insertArr);
		if ($status) {
			$response = array(
				'status'  => 0,
				'mobile'  => $userRecord['MobileNo'],
				'message' => "Request sent successfully"
			);
		}else{
			$response = array(
				'status'  => 1,
				'mobile'  => null,
				'message' => "Error saving temporary user account"
			);
		}

		$this->response($response);
	}

	public function download_masters_and_data($MobileNo)
	{
		$this->db->trans_start();

		/**
		 * download masters
		 * 1. get the ondemand user record
		 * 2. get masters
		 * 3. get data
		 */

		$this->db->where('MobileNo', $MobileNo);
		$userRecord = $this->db->get('ondemand_tbluser')->result()[0];

		// master tables

		$query = "select a.*, c.mobile from mstasha a
		inner join userashamapping b 
		on a.ASHAID = b.AshaID and a.IsActive = 1
		inner join tblusers c 
		on b.UserID = c.user_id
		where a.ASHAID = ?";
		$content['mstasha'] = $this->db->query($query,[$userRecord->AshaID])->result();

		$this->db->where('IsActive', 1);
		$this->db->where('ANMID', $userRecord->ANMID);
		$content['mstanm'] = $this->db->get('mstanm')->result();

		$this->db->where('SubCenterID', $userRecord->SubcenterID);
		$content['mstsubcenter'] = $this->db->get('mstsubcenter')->result();

		$this->db->where('StateCode', $userRecord->StateCode);
		$content['mststate'] = $this->db->get('mststate')->result();

		$this->db->where('DistrictCode', $userRecord->DistrictCode);
		$content['mstdistrict'] = $this->db->get('mstdistrict')->result();

		$this->db->where('BlockCode', $userRecord->BlockCode);
		$content['mstblock'] = $this->db->get('mstblock')->result();

		$this->db->where('VillageCode', $userRecord->VillageCode);
		$content['mstvillage'] = $this->db->get('mstvillage')->result();

		$content['tblpregnancytips'] = $this->db->get('tblpregnancytips')->result();

		// data tables

		$this->db->where('MobileNo', $userRecord->MobileNo);
		$content['ondemand_tbluser'] = $this->db->get('ondemand_tbluser')->result();

		$this->db->where('HHSurveyGUID', $userRecord->HHSurveyGUID);
		$content['tblhhsurvey'] = $this->db->get('tblhhsurvey')->result();

		$this->db->where('HHSurveyGUID', $userRecord->HHSurveyGUID);
		$content['tblhhfamilymember'] = $this->db->get('tblhhfamilymember')->result();

		$this->db->where('HHFamilyMemberGUID', $userRecord->HHFamilyMemberGUID);
		$content['tblpregnant_woman'] = $this->db->get('tblpregnant_woman')->result();

		$this->db->where('HHFamilyMemberGUID', $userRecord->HHFamilyMemberGUID);
		$content['tblchild'] = $this->db->get('tblchild')->result();

		$query = "select a.* from tblancvisit a 
		inner join tblpregnant_woman b 
		on a.PWGUID = b.PWGUID
		where b.HHFamilyMemberGUID = ?";
		$content['tblancvisit'] = $this->db->query($query, [$userRecord->HHFamilyMemberGUID])->result();

		$query = "select a.* FROM tblpnchomevisit_ans a
		inner join tblpregnant_woman b 
		on a.PWGUID = b.PWGUID
		where b.HHFamilyMemberGUID = ?";
		$content['tblpnchomevisit_ans'] = $this->db->query($query, [$userRecord->HHFamilyMemberGUID])->result();

		$this->db->where('HHFamilyMemberGUID', $userRecord->HHFamilyMemberGUID);
		$content['tblncdcbac'] = $this->db->get('tblncdcbac')->result();

		$this->db->where('HHFamilyMemberGUID', $userRecord->HHFamilyMemberGUID);
		$content['tblncdscreening'] = $this->db->get('tblncdscreening')->result();

		$this->db->where('HHFamilyMemberGUID', $userRecord->HHFamilyMemberGUID);
		$content['tblncdfollowup'] = $this->db->get('tblncdfollowup')->result();

		$query = "select b.* from tblpregnant_woman a 
		inner join tblpregnant_food b 
		on a.PWGUID = b.PWGUID
		where a.HHFamilyMemberGUID = ?";
		$content['tblpregnant_food'] = $this->db->query($query, [$userRecord->HHFamilyMemberGUID])->result();

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
		{
			$response = array(
				'status'  => 1,
				'message' => "Error in transaction"
			);
			$this->response($content);
		}else{
			header('Content-Type: application/json');

			$content['response'] = [0=>array(
				'status'  => 0,
				'message' => "Data download successful"
			)];
			die(json_encode($content));
		}

		$this->response($response);
	}

	public function upload()
	{

		$this->authenticate();
		$data = $this->input->post('data');

		if (FALSE == ($data = json_decode($data))) {
			$response = array(
				'status'  => 1,
				'message' => "Improperly formatted JSON received"
			);
			$this->response($response);
		}

		$this->db->trans_start();

		foreach ($data as $table_name => $table_data) {
			$this->{$table_name}($table_data);	
		}

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
		{
			$response = array(
				'status'  => 1,
				'message' => "Error in transaction"
			);
			$this->response($response);
		}else{
			$response = array(
				'status'  => 0,
				'message' => "Table successfully uploaded"
			);
			$this->response($response);
		}

	}


	private function tblpregnant_food($table_data)
	{

		foreach ($table_data as $row) 
		{

			$this->db->where('PWGUID', $row->PWGUID);
			$this->db->where('FoodDay', $row->FoodDay);
			$result = $this->db->get('tblpregnant_food')->result();

			unset($row->UID);
			
			$row->UploadedOn = date("Y-m-d H:i:s");
			$row->UploadedBy = $this->loginData->ID;

			if (count($result) < 1) 
			{

				$this->db->insert('tblpregnant_food', $row);

			}else{
				
				$this->db->where('PWGUID', $row->PWGUID);
				$this->db->where('FoodDay', $row->FoodDay);
				$this->db->update('tblpregnant_food', $row);

			}

		}
	}

	public function generate_qr_child()
	{
		$this->authenticate();

		$PNG_TEMP_DIR = FCPATH . 'temp/';
		$PNG_WEB_DIR = FCPATH . 'ondemand_qr/';
		$PNG_FILENAME = uniqid() . ".png";

		include FCPATH . "application/libraries/phpqrcode/qrlib.php";

		$query = "select a.PWName, a.HusbandName,
		b.childGUID, b.child_name, b.child_dob, d.ASHAName, null as user_name
		from 
		(select a.FamilyMemberName as PWName, b.FamilyMemberName as HusbandName, a.HHFamilyMemberGUID, a.CreatedBy 
		from tblhhfamilymember a 
		left join tblhhfamilymember b 
		on a.HHFamilyMemberGUID = b.Spouse
		where a.HHFamilyMemberGUID = ?
		)a
		left join tblchild b
		on a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
		inner join userashamapping c
		on a.CreatedBy = c.UserID
		inner join mstasha d
		on c.AshaID = d.AshaID and d.LanguageID = 1 and d.IsActive = 1";

		$result = $this->db->query($query, [$this->loginData->HHFamilyMemberGUID])->result();
		if (count($result) < 1) {
			$response = array(
				'status'  => 1,
				'message' => "Error in creating QR code"
			);
			$this->response($response);
		}

		$jsonRecord = $result[0];

		$data = json_encode(["data"=>[0=>[
			"HusbandName" => $jsonRecord->HusbandName,
			"ChildGUID"   => $jsonRecord->childGUID,
			"child_name"  => $jsonRecord->child_name,
			"child_dob"   => $jsonRecord->child_dob,
			"PWName"      => $jsonRecord->PWName,
			"ASHAName"    => $jsonRecord->ASHAName,
			"user_name"   => $jsonRecord->user_name,
		]]], JSON_UNESCAPED_UNICODE);

		QRcode::png($data, $PNG_WEB_DIR . $PNG_FILENAME, 'L', 2, 4);

		if (!file_exists($PNG_WEB_DIR . $PNG_FILENAME)) {
			$response = array(
				'status'  => 1,
				'message' => "Error in creating QR code"
			);
			$this->response($response);
		}


		$this->db->where('MobileNo', $this->loginData->MobileNo);
		$updateArr = array(
			'ChildQR' => $PNG_FILENAME,
		);
		$this->db->update('ondemand_tbluser', $updateArr);

		$response = array(
			'status'    => 0,
			'message'   => "Successfully generated QR code",
			'file_name' => $PNG_FILENAME,
		);
		$this->response($response);
		
	}

	public function generate_qr_mother()
	{
		$this->authenticate();

		$PNG_TEMP_DIR = FCPATH . 'temp/';
		$PNG_WEB_DIR = FCPATH . 'ondemand_qr/';
		$PNG_FILENAME = uniqid() . ".png";

		include FCPATH . "application/libraries/phpqrcode/qrlib.php";

		$query = "select a.HHFamilyMemberGUID, b.PWGUID, b.PWName, b.LMPDate, d.ASHAName, null as user_name
		from tblhhfamilymember a 
		left join tblpregnant_woman b
		on a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
		inner join userashamapping c
		on a.CreatedBy = c.UserID
		inner join mstasha d
		on c.AshaID = d.AshaID and d.LanguageID = 1 and d.IsActive = 1
		where a.HHFamilyMemberGUID = ?";

		$result = $this->db->query($query, [$this->loginData->HHFamilyMemberGUID])->result();
		if (count($result) < 1) {
			$response = array(
				'status'  => 1,
				'message' => "Error in creating QR code"
			);
			$this->response($response);
		}

		$jsonRecord = $result[0];

		$data = json_encode(["data"=>[0=>[
			"HHFamilyMemberGUID" =>	$jsonRecord->HHFamilyMemberGUID,
			"PWGUID"             =>	$jsonRecord->pwGUID,
			"PWName"             =>	$jsonRecord->PWName,
			"LMPDate"            => $jsonRecord->LMPDate,
			"ASHAName"           => $jsonRecord->ASHAName,
			"user_name"          => $jsonRecord->user_name,
		]]], JSON_UNESCAPED_UNICODE);

		QRcode::png($data, $PNG_WEB_DIR . $PNG_FILENAME, 'L', 2, 4);

		if (!file_exists($PNG_WEB_DIR . $PNG_FILENAME)) {
			$response = array(
				'status'  => 1,
				'message' => "Error in writing QR code"
			);
			$this->response($response);
		}

		$this->db->where('MobileNo', $this->loginData->MobileNo);
		$updateArr = array(
			'MotherQR' => $PNG_FILENAME,
		);
		$this->db->update('ondemand_tbluser', $updateArr);

		$response = array(
			'status'    => 0,
			'message'   => "Successfully generated QR code",
			'file_name' => $PNG_FILENAME,
		);
		$this->response($response);
		
	}


}