<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends Ci_Controller {

	public function __construct()
	{
		parent::__construct();
	}
	public function index()
	{	
		$this->load->view('login');
	}

	public function verifylogin()
	{
		$user_name = $this->security->xss_clean($this->input->post('email'));
		$password = $this->security->xss_clean($this->input->post('password'));

		$this->db->where('user_name',$user_name);
		$this->db->where('password', md5($password));
		$res = $this->db->get('tblusers');

		if($res->num_rows() == 1)
		{
			$row = $res->row();

			$this->session->set_userdata('loginData',$row);

			if($row->user_role == 5)
			{
				redirect('admin/dashboard');
			}
			else if($row->user_role == 2)
			{
				redirect('users/dashboard');
			}
		}
		else
		{
			redirect('');
		}
	}

	public function logout()
	{
		$this->session->set_flashdata('er_msg', 'Please login agin to continue...');
		$this->session->sess_destroy('loginData');
		redirect('');
	}

}
