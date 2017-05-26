<?php
class Admin_Controller extends MY_Controller
{
	function __construct ()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('Users_Model');
		$this->data['meta_title'] = 'Admin panel : Service Central';
		$this->data['my_title'] = "Service Central Admin";
		$exception_uris = array(
					'admin',
					'admin/login/verifylogin',
					'admin/login/forget_pass',
					'admin/login/logout'
				);
				if ($this->Users_Model->isLoggedInAdmin() != FALSE)
				{
					/*$tt=$this->session->userdata('loginData');
					$this->db->where('email', $tt['email']);
					$query = $this->db->get('tblmstuser');
					$_SESSION['user_data'] = $query->row();*/
				}
				
				if (in_array(uri_string(), $exception_uris) == FALSE)
				{
					if ($this->Users_Model->isLoggedInAdmin() == FALSE)
					{
			      redirect('admin/');
					} 
			}
	}

	function index(){}
}