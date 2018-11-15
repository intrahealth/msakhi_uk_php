<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends Gov_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$query = "select * from tblusers where is_deleted = 0";
		$content['users_list'] = $this->Common_Model->query_data($query);
		
		$content['subview'] = "list_users";
		$this->load->view('gov/main_layout', $content);
	}

	public function export_csv()
	{		
		$query = "select * from tblusers where is_deleted = 0";

		$this->load->model('Data_export_model');
		$this->Data_export_model->export_csv($query);
	}

	public function export_pdf()
	{

		$query = "select * from tblusers where is_deleted = 0";

		$this->load->model('Data_export_model');
		$this->Data_export_model->export_pdf($query);
	}

	public function delete($id = null)
	{
		$sql = "update tblusers set is_deleted = 1 where user_id = $id";
		$this->db->query($sql);
		$this->session->set_flashdata('tr_msg' ,"User Deleted Successfully");
		redirect('gov/users');
	}

	public function edit($id = null)
	{	

		$RequestMethod = $this->input->server('REQUEST_METHOD');

		if($RequestMethod == "POST")
		{

			$username	= $this->input->post('username');
			$email					= $this->input->post('email'); 
			$first_name			=	$this->input->post('firstname');
			$last_name			=	$this->input->post('lastname');
			$phone_no				=	$this->input->post('phone_no');
			$user_role			= $this->input->post('usertype'); 
			$first_name			=	$this->input->post('firstname');
			$last_name			=	$this->input->post('lastname');
			$phone_no				=	$this->input->post('phone_no');

			/* Admin Role  1*/
			if($user_role==1)
			{

				$state_code			= '';
				$district_code	=	'';
				$block_code			=	'';
			}
			/* State Rol  6*/
			if($user_role==6)
			{
				$state_code			= $this->input->post('state');
				$district_code	=	'';
				$block_code			=	'';

			}
			/*District Role  6*/
			if($user_role==7)
			{
				$state_code			= $this->input->post('state');
				$district_code	=	$this->input->post('districtname');
				$block_code			=	'';


			}
			/* Block Role 8*/
			if($user_role==8)
			{

				$district_code	=	$this->input->post('districtname');
				$block_code			=	$this->input->post('blockname');
				$state_code			= $this->input->post('state');

			}

			$updateArray = array(
				'user_name' 		=> $username,
				'email'					=> $email,
				'user_role'			=> $user_role,
				'first_name' 		=> $first_name,
				'last_name' 		=> $last_name,
				'phone_no' 			=> $phone_no,
				'state_code' 		=> $state_code,	
				'district_code' => $district_code,
				'block_code' 		=> $block_code,
				'user_type' 		=> date("Y-m-d H:i:s"),
				'modify_by'			=> $username
				);

			if($this->input->post('password')!== null)
			{
				$updateArray['password'] = md5($this->input->post('password'));
			}

			$this->Common_Model->update_data('tblusers', $updateArray,'user_id',$id);
			$this->session->set_flashdata('tr_msg', 'Successfully updated User');
			redirect('gov/users');
		}

		$sql = "select * from tblusers where user_id = $id";
		$content['user_data'] = $this->Common_Model->query_data($sql)[0];

		$content['subview'] = 'edit_user';
		$this->load->view('gov/main_layout', $content);
	}

	public function add()
	{	
		$RequestMethod = $this->input->server('REQUEST_METHOD');


		if($RequestMethod == "POST")
		{

			$username	= $this->input->post('username');
			$this->db->where('user_name',$username);
			$res = $this->db->get('tblusers');
			if($res->num_rows() == 0)
			{
				$user_id=$this->Common_Model->getMaxId('tblusers','user_id');
				$password				= md5($this->input->post('password')) ; 
				$email					= $this->input->post('email'); 
				$first_name			=	$this->input->post('firstname');
				$last_name			=	$this->input->post('lastname');
				$phone_no				=	$this->input->post('phone_no');
				$user_role			= $this->input->post('usertype'); 


				/* Admin Role  1*/
				if($user_role==1)
				{

					$state_code			= '';
					$district_code	=	'';
					$block_code			=	'';
				}
				/* State Rol  6*/
				if($user_role==6)
				{
					$state_code			= $this->input->post('state');
					$district_code	=	'';
					$block_code			=	'';

				}
				/*District Role  6*/
				if($user_role==7)
				{
					$state_code			= $this->input->post('state');
					$district_code	=	$this->input->post('districtname');
					$block_code			=	'';


				}
				/* Block Role 8*/
				if($user_role==8)
				{

					$district_code	=	$this->input->post('districtname');
					$block_code			=	$this->input->post('blockname');
					$state_code			= $this->input->post('state');

				}

				$insertArray = array(
					'user_id'				=>	$user_id+1,
					'user_name' 		=> $username,
					'password'			=> $password,
					'email'					=> $email,
					'user_role'			=> $user_role,
					'first_name' 		=> $first_name,
					'last_name' 		=> $last_name,
					'phone_no' 			=> $phone_no,
					'state_code' 		=> $state_code,
					'district_code' => $district_code,
					'block_code' 		=> $block_code,
					'user_type' 		=> 'Web',
					'created_by' 		=> $this->session->userdata('loginData')->user_name,
					'created_on' 		=> date("Y-m-d H:i:s"),
					'is_deleted'		 => 0
					);
				$this->Common_Model->insert_data('tblusers', $insertArray);
				$this->session->set_flashdata('tr_msg', 'Successfully added User');
				redirect('gov/users');
				
			}

			else{

				$this->session->set_flashdata('er_msg',"$username User already taken");
				print("<script language='javascript'>history.back()</script>");

			}
		}

		$content['subview'] = 'add_user';

		$content['state_list'] = $this->Common_Model->getStateList();
		//$content['state_list'] = $this->Common_Model->getDistrictList($stateId);
		//$content['state_list'] = $this->Common_Model->getStateList();

		$this->load->view('gov/main_layout', $content);
	}
}