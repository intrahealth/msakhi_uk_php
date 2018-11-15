<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Users extends Auth_controller {

	public function __construct()
	{
		parent::__construct();
		$this->loginData = $this->session->userdata('loginData');
	}

	public function index($UserPDF = ' ')
	{
		$user_role = $this->loginData->user_role;
		$query = "SELECT * FROM role_permissions as rp LEFT JOIN mstrole as mst on rp.RoleID=mst.RoleID WHERE rp.RoleID='$user_role' ";
		$content['role_permission'] = $this->Common_Model->query_data($query);

		//$query = "select * from mststate where is_deleted = 0";
		//$content['state_list'] = $this->Common_Model->getStateList();
		$content['selected_state'] = 0;
		
		$query = "select * from mststate where IsDeleted=0 and LanguageID = 1 ";
		if ($this->loginData->user_role == 1 || $this->loginData->user_role == 2 || $this->loginData->user_role == 3 || $this->loginData->user_role == 4 || $this->loginData->user_role == 6 || $this->loginData->user_role == 7 || $this->loginData->user_role == 8 || $this->loginData->user_role == 10) 	 {
			$query .= "	and StateCode='".$this->loginData->state_code."' ";

			// add district based filter if district role
			if ($this->loginData->user_role == 7) {
				$query .= " and district_code =  $this->loginData->district_code ";
			}
			// add district based filter if block role
			if ($this->loginData->user_role == 8) {
				$query .= " and block_code =  $this->loginData->block_code ";
			}
		}
		$content['State_list'] = $this->Common_Model->query_data($query);


		$RequestMethod = $this->input->server('REQUEST_METHOD');
		if($RequestMethod == "POST")
		{

			$statecode = $this->input->post('StateCode');
			// $state	= $this->loginData->state_code;
			//$content['state_list'] = $this->Common_Model->getStateList(1,$state);
			$query = "select * from tblusers where is_deleted = 0 
			and state_code ='".$statecode."' ";
		
			$content['users_list'] = $this->Common_Model->query_data($query);

			//$content['selected_state'] = $state;
		}else{
			$content['users_list'] = [];
		}

		$content['subview'] = "list_users";

		if ($UserPDF == "export_pdf") {
			$this->export_section($content);
			die();
		}

		$this->load->view('auth/main_layout', $content);
	}

	public function export_csv($selected_state)
	{		
		$query = "select * from tblusers where is_deleted = 0";
		if($selected_state > 0)
		{
			
			$query = "select * from tblusers where is_deleted = 0 and state_code =".$selected_state;
		}

		$this->load->model('Data_export_model');
		$this->Data_export_model->export_csv($query);
	}

/*	public function export_pdf()
	{

		$query = "select * from tblusers where is_deleted = 0";

		$this->load->model('Data_export_model');
		$this->Data_export_model->export_pdf($query);
	}
*/
	public function delete($id = null)
	{
		$sql = "update tblusers set is_deleted = 1 where user_id = $id";
		$this->db->query($sql);
		$this->session->set_flashdata('tr_msg' ,"User Deleted Successfully");
		redirect('Users');
	}
	public function edit($id = null)
	{	

		$RequestMethod = $this->input->server('REQUEST_METHOD');

		if($RequestMethod == "POST")
		{

			$username   = $this->input->post('username');
			$email      = $this->input->post('email'); 
			$first_name =	$this->input->post('firstname');
			$last_name  =	$this->input->post('lastname');
			$phone_no   =	$this->input->post('phone_no');
			$user_role  = $this->input->post('usertype'); 
			$first_name =	$this->input->post('firstname');
			$last_name  =	$this->input->post('lastname');
			$phone_no   =	$this->input->post('phone_no');

			/* auth Role  1*/
			if($user_role==5)
			{

				$state_code    = 	'';
				$district_code =	'';
				$block_code    =	'';
			}
			/* State Rol  6*/
			if($user_role==6)
			{
				$state_code    = $this->input->post('state');
				$district_code =	'';
				$block_code    =	'';

			}
			/*District Role  6*/
			if($user_role==7)
			{
				$state_code    = 	$this->input->post('state');
				$district_code =	$this->input->post('districtname');
				$block_code    =	'';
			}
			/* Block Role 8*/
			if($user_role==8)
			{

				$district_code =	$this->input->post('districtname');
				$block_code    =	$this->input->post('blockname');
				$state_code    = 	$this->input->post('state');

			}

			$updateArray = array(
				'user_name'     => $username,
				'email'         => $email,
				'user_role'     => $user_role,
				'first_name'    => $first_name,
				'last_name'     => $last_name,
				'phone_no'      => $phone_no,
				'state_code'    => $state_code,	
				'district_code' => $district_code,
				// 'block_code' => $block_code,
				'modify_on'     => date("Y-m-d H:i:s"),
				'modify_by'     => $username
				);

			if($this->input->post('password')!== null)
			{
				$updateArray['password'] = md5($this->input->post('password'));
			}

			$this->Common_Model->update_data('tblusers', $updateArray,'user_id',$id);
			$this->session->set_flashdata('tr_msg', 'Successfully updated User');
			redirect('Users');
		}

		$sql = "select * from tblusers where user_id = $id";
		$content['user_data'] = $this->Common_Model->query_data($sql)[0];

		$content['subview'] = 'edit_user';
		$this->load->view('auth/main_layout', $content);
	}

	public function add()
	{	
     // $state_code = $this->input->get('StateCode');
		


		$RequestMethod = $this->input->server('REQUEST_METHOD');
		if($RequestMethod == "POST")
		{
      	// print_r($_POST); die();
			$user_type	= $this->input->post('usertype');
			$username	= $this->input->post('username');

			// if($user_type == 7)
			// {

			$this->db->where('user_name',$username);
			$res = $this->db->get('tblusers');
			if($res->num_rows() == 0)
			{
				$user_id                =   $this->Common_Model->getMaxId('tblusers','user_id');
				$password				=   md5($this->input->post('password')) ; 
				$email					=   $this->input->post('email'); 
				$first_name			=	  $this->input->post('firstname');
				$phone_no				=	  $this->input->post('phone_no');
				$imei1         =   $this->input->post('imei1');
				$imei2         =   $this->input->post('imei2');

				
				switch($user_type)
				{
					case 1 : $user_role	= 5;
					break;
					case 2 : $user_role	= 6;
					break;
					case 3 : $user_role	= 7;
					break;
					case 4 : $user_role	= 8;
					break;
					case 5 : $user_role	= 3;
					break;
					case 7 : $user_role	= 2;
					break;
					default : echo "wrong user type"; die();

				}
				/* auth Role  1*/
				if($user_role==5)
				{

					$state_code    = '05';
					$district_code = '';
					$block_code    = '';
					$user_device   = 'Web';
				}
				/* State Rol  6*/
				if($user_role==6)
				{
					$state_code			= $this->input->post('state');
					$district_code	=	'';
					$block_code			=	'';
					$user_device = 'Web';

				}
				/*District Role  7*/
				if($user_role==7)
				{
					$state_code			= $this->input->post('state');
					$district_code	=	$this->input->post('districtname');
					$block_code			=	'';
					$user_device = 'Web';


				}
				/* Block Role 8*/
				if($user_role==8)
				{

					$district_code	=	$this->input->post('districtname');
					$block_code			=	$this->input->post('blockname');
					$state_code			= $this->input->post('state');
					$user_device = 'Web';

				}

				if($user_role == 2)
				{
					$state_code			= $this->input->post('state');
					$district_code	    =	$this->input->post('districts');
					$block_code			=	$this->input->post('block');
					$user_device        = 'Mobile';
					$ashaid             = $this->input->post('asha');
					$subcenter          = $this->input->post('subcenter');

					$sql = "SELECT ASHAName FROM `mstasha` where AshaID = ".$ashaid." and LanguageID = 1";
					$asha_name = $this->Common_Model->query_data($sql);


					$sql = "SELECT SubCenterName FROM `mstsubcenter` where SubCenterCode = ".$subcenter;
					$subcenter_name = $this->Common_Model->query_data($sql);

					$insertArrayForMapping = array(
						'AshaID' => $ashaid,
						'UserID' => $user_id+1,
						'AshaName' => $asha_name[0]->ASHAName,
						'SubCenterName' => $subcenter_name[0]->SubCenterName
						);

					$this->Common_Model->insert_data('userashamapping', $insertArrayForMapping);
					$insertArrayForMapping = array(
						'UserID' => $user_id+1,
						'StateCode' => $state_code,
						'DistrictCode' => $district_code,
						'BlockCode' => $block_code
						);
					$this->Common_Model->insert_data('userstatemapping', $insertArrayForMapping);
					
				}

				if($user_role == 3)
				{
					$state_code			= $this->input->post('state');
					$district_code	    =	$this->input->post('districts');
					$block_code			=	$this->input->post('block');
					$user_device        = 'Mobile';
					$anmid             = $this->input->post('anm');
					$subcenter          = $this->input->post('subcenter');

					$insertArrayForMapping = array(
						'ANMID' => $anmid,
						'UserID' => $user_id+1,
						);

					$this->Common_Model->insert_data('useranmmapping', $insertArrayForMapping);
					$insertArrayForMapping = array(
						'UserID' => $user_id+1,
						'StateCode' => $state_code,
						'DistrictCode' => $district_code,
						'BlockCode' => $block_code
						);
					$this->Common_Model->insert_data('userstatemapping', $insertArrayForMapping);
				}
				$insertArray = array(
					'user_id'       => $user_id+1,
					'user_name'     => $username,
					'password'      => $password,
					'email'         => $email,
					'user_role'     => $user_role,
					'first_name'    => $first_name,
					//'last_name'     => $last_name,
					'phone_no'      => $phone_no,
					'imei1'        => $imei1,
					'imei2'        => $imei2,
					'state_code'    => $state_code,
					'district_code' => $district_code,
					// 'block_code' => $block_code,
					'user_type'     => $user_device,
					'created_by'    => $this->session->userdata('loginData')->user_name,
					'created_on'    => date("Y-m-d H:i:s"),
					'is_deleted'    => 0,
					'user_mode'			=> 1,
					);
		

				$this->Common_Model->insert_data('tblusers', $insertArray);


				$this->session->set_flashdata('tr_msg', 'Successfully added User');
				redirect('Users');
				
			}

			else{

				$this->session->set_flashdata('er_msg',"$username User already taken");
				print("<script language='javascript'>history.back()</script>");

			}
		// }
		}

		$content['subview'] = 'add_user';
		$content['state_list'] = $this->Common_Model->getStateList();
		//$content['state_list'] = $this->Common_Model->getDistrictList($stateId);
		//$content['state_list'] = $this->Common_Model->getStateList();

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

	public function register($export_excel = null)
	{

		$sql = "SELECT * FROM user_register_with_af";
		$res = $this->db->query($sql)->result();

		if($export_excel)
		{
			$this->load->model('Data_export_model');
			$this->Data_export_model->export_csv($sql);
		}
		$content['user_list'] = $res;
		$content['subview'] = 'user_register';
		$this->load->view('auth/main_layout', $content);
	}
	
}