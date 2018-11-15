<?php
class Qr_code_managment_child extends Auth_controller{

	public function __construct()
	{
		parent:: __construct();
		$this->loginData = $this->session->userdata('loginData');
		include FCPATH . "application/libraries/phpqrcode/qrlib.php";
	}

	public function index($id = NULL,$StateCode = NULL,$ANMCode = NULL,$VillageCode = NULL)
	{

		$user_role = $this->loginData->user_role;
		$query = "SELECT * FROM role_permissions as rp LEFT JOIN mstrole as mst on rp.RoleID=mst.RoleID WHERE rp.RoleID='$user_role' ";

		$content['role_permission'] = $this->Common_Model->query_data($query);

		//end permission 

		$query = "select * from mststate where IsDeleted=0 and LanguageID = 1 ";
		if ($this->loginData->user_role == 1 || $this->loginData->user_role == 2 || $this->loginData->user_role == 3 || $this->loginData->user_role == 6) 	 {
			$query .= "	and StateCode='".$this->loginData->state_code."' ";

		// add district based filter if district role

			if ($this->loginData->user_role == 7) {
				$query .= " and district_code ='".$this->loginData->district_code."' ";
			}
		// add district based filter if block role

			if ($this->loginData->user_role == 8) {
				$query .= " and block_code ='".$this->loginData->block_code."' ";
			}
		}

		$content['State_List'] = $this->Common_Model->query_data($query);


		$RequestMethod = $this->input->server('REQUEST_METHOD');
		if($RequestMethod == "POST")
		{

			$query = "SELECT * from mstanm a INNER JOIN mstasha b on a.ANMCode=b.ANMCode inner join userashamapping c on c.AshaID=a.ANMUID inner join tblusers d on c.UserID=d.user_id where d.state_code= '".$StateCode."' AND a.LanguageID=1 and a.IsDeleted=0 GROUP by a.ANMName";

			$content['Anm_list'] = $this->Common_Model->query_data($query);

			$query = "SELECT * from mstanm a INNER JOIN mstasha b on a.ANMCode=b.ANMCode inner join userashamapping c on c.AshaID=a.ANMUID inner join tblusers d on c.UserID=d.user_id where a.ANMCode= '".$ANMCode."' AND b.LanguageID=1 and b.IsDeleted=0 GROUP by b.ASHAName";

			$content['Asha_list'] = $this->Common_Model->query_data($query);


		}else{
			$query = "SELECT
						    *
			FROM
			mstanm a
			INNER JOIN useranmmapping b ON
			a.ANMID = b.ANMID
			INNER JOIN tblusers c ON
			b.UserID = c.user_id
			WHERE
			a.IsDeleted = 0 AND a.IsActive = 1 AND c.is_deleted = 0 AND a.LanguageID = 1 AND c.user_mode = 1";

			$content['Anm_list'] = $this->Common_Model->query_data($query);

			// $content['Anm_list'] = array();

			$query = "SELECT
						    *
			FROM
			mstasha a
			INNER JOIN userashamapping b ON
			a.ASHAID = b.AshaID
			INNER JOIN tblusers c ON
			b.UserID = c.user_id
			WHERE
			a.LanguageID = 1 AND a.IsDeleted = 0 AND a.IsActive = 1 AND c.is_deleted = 0 AND c.user_mode = 1";

			$content['Asha_list'] = $this->Common_Model->query_data($query);
			// $content['Asha_list'] = array();


			$query = "SELECT * FROM mstvillage WHERE LanguageID = 1 and IsDeleted = 0";
			$content['Village_list'] = $this->Common_Model->query_data($query);
		}

		$content['subview'] = "QRCode_Child";
		$this->load->view('auth/main_layout', $content);
	}


	public function dwnload_qr_code($childGUID = NULL)
	{
		// $this->db->where('childGUID',$childGUID);
		// $result = $this->db->get('tblchild')->result();
		$result = $this->db->query("select a.*, b.FamilyMemberName as HusbandName from
						(SELECT
		               a.childGUID,
		               a.child_dob,
		               a.child_name,
		                c.ASHAName,
        				e.user_name,
		               CASE WHEN b.GenderID = 2 THEN b.FamilyMemberName END AS PWName,
		               b.Spouse
		               FROM
		               tblchild a
		               INNER JOIN tblhhfamilymember b ON
		               a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
		               INNER JOIN mstasha c on a.AshaID = c.ASHAID
		                      INNER JOIN userashamapping d on c.ASHAID = d.AshaID
		                      INNER JOIN tblusers e on d.UserID = e.user_id
		               WHERE
		               a.IsDeleted = 0 AND b.IsDeleted = 0 and c.LanguageID = 1 )a
		               left join
		               tblhhfamilymember b
		               on a.Spouse = b.HHFamilyMemberGUID WHERE a.childGUID = '".$childGUID."'")->result();

		// print_r($result); die();
		if (count($result) < 1) {
			$this->session->set_flashdata('er_msg', "No Child reference set for this ID");
			redirect('MNCH/getANCList/');
		}

		$childGUID = $result[0]->childGUID;
		$HusbandName = $result[0]->HusbandName;
		$child_name = $result[0]->child_name;
		$child_dob = $result[0]->child_dob;
		$PWName = $result[0]->PWName;
		$ASHAName = $result[0]->ASHAName;
		$user_name = $result[0]->user_name;
		// print_r($user_name); die();


		$PNG_TEMP_DIR = FCPATH . 'temp/';
		$PNG_WEB_DIR = FCPATH . 'datafiles/';
		$content['PNG_FILENAME'] = uniqid() . ".png";

		// include FCPATH . "application/libraries/phpqrcode/qrlib.php";

		$data = json_encode(["data"=>[0=>[
			"HusbandName" =>	($HusbandName),
			"ChildGUID"             =>	($childGUID),
			"child_name"			=>	($child_name),
			"child_dob"			=> ($child_dob),
			"PWName"			=> ($PWName),
			"ASHAName"			=> ($ASHAName),
			"user_name"			=>($user_name),
		]]], JSON_UNESCAPED_UNICODE);
		// die($data);

		QRcode::png($data, $PNG_WEB_DIR . $content['PNG_FILENAME'], 'L', 2, 4);

		$html = '<html>';
		$html .= '<head>';
		$html .= '<meta charset="UTF-8">';
		$html .= "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>";
		$html .= '<title>Qr Code</title>';
		$html .= '<style>
		@page { margin: 0px; }
		body{
			
			background-repeat: no-repeat;
			background-attachment: fixed;
			background-position: center; 
			margin: 0px;
			font-family: gargi;
		}
		</style>';
		$html .= '</head>';
		$html .= '<body>';
		$html .= '<table>';

		$html .= $row = '';
		$html .= $row .='<tr>';
		$row .= '<td colspan="100%"><img src="'.FCPATH . 'datafiles/' . $content['PNG_FILENAME'].'"><br>';
		$row .= 'Name : ' . $child_name .'<br>';
		$row .= 'Date of Birth:' . $child_dob . '<br>';
		$row .= 'Asha(UserName):' .$ASHAName.'('.$user_name. ')';
		$row .= '</tr>';

		$row .= '</table>';
		$html .= $row;
		$html .='</body>';
		$html .= '</html>';

		// die($html);



		$this->load->model('Dompdf_model');
		$this->Dompdf_model->export($html,NULL,'test.pdf');
	}

	public function download_multiple_qr_code()
	{
		$selection = $this->input->post('childGUID');

		$selection = explode(',', $selection);

		$collection = [];
		foreach ($selection as $childGUID)
		{
			// $this->db->where('childGUID', $childGUID);
			// $result = $this->db->get('tblchild')->result();
			$result = $this->db->query("select a.*, b.FamilyMemberName as HusbandName from
				(SELECT
               a.childGUID,
               a.child_dob,
               a.child_name,
               c.ASHAName,
               e.user_name,
               CASE WHEN b.GenderID = 2 THEN b.FamilyMemberName END AS PWName,
               b.Spouse
               FROM
               tblchild a
               INNER JOIN tblhhfamilymember b ON
               a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
               INNER JOIN mstasha c on a.AshaID = c.ASHAID
		                      INNER JOIN userashamapping d on c.ASHAID = d.AshaID
		                      INNER JOIN tblusers e on d.UserID = e.user_id
               WHERE
               a.IsDeleted = 0 AND b.IsDeleted = 0 and c.LanguageID = 1 )a
               left join
               tblhhfamilymember b
               on a.Spouse = b.HHFamilyMemberGUID WHERE a.childGUID = '".$childGUID."'")->result();
			if (count($result) < 1) {
				continue;
			}

			$childDetails = $result[0];
			// print_r($childDetails); die();
			$PNG_FILENAME = $this->createQr($childDetails);

			$childDetails->PNG_FILENAME = $PNG_FILENAME;

			$collection[] = $childDetails;
		}

		$content['data'] = $collection;
		$html = $this->load->view('auth/components/qr_list_child', $content, true);
		// die($html);

		$this->load->model('Wkhtmltopdf_model');
		$this->Wkhtmltopdf_model->export($html, 'report_01.pdf');
	}

	public function createQr($details =[])
	{

	// print_r($details); die();


		$PNG_TEMP_DIR = FCPATH . 'temp/';
		$PNG_WEB_DIR = FCPATH . 'datafiles/';
		$PNG_FILENAME = uniqid() . ".png";


			$data = json_encode(["data"=>[0=>[
			"ChildGUID" 		=>	$details->childGUID,
			"child_name"        =>	$details->child_name,
			"child_dob"			=>	$details->child_dob,
			"PWName"			=>  $details->PWName,
			"HusbandName" 		=>	$details->HusbandName,
			"ASHAName"			=>	$details->ASHAName,
			"user_name"			=>	$details->user_name,
			// "LMPDate"		=> $details->LMPDate,
		]]], JSON_UNESCAPED_UNICODE);
		// die($data);

		QRcode::png($data, $PNG_WEB_DIR . $PNG_FILENAME, 'L', 2, 4);
		return $PNG_FILENAME;
	}



}