<?php
class Gov_Controller extends CI_Controller
{
	function __construct ()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('Users_model', 'Users_Model');
		$this->load->model('Common_Model');
		$this->data['meta_title'] = 'Admin panel : Msakhi';
		$this->data['my_title'] = "Intrahealth Admin";
		$exception_uris = array(
					'gov',
					'gov/login/verifylogin',
					'gov/login/forget_pass',
					'gov/login/logout'
				);
				if ($this->Users_Model->isLoggedInGov() != FALSE)
				{
					/**
					 * Here any pre-rendering tasks
					 */
				}
				
				if (in_array(uri_string(), $exception_uris) == FALSE)
				{
					if ($this->Users_Model->isLoggedInGov() == FALSE)
					{
			      redirect('');
					} 
			}
	}

	function index(){}
}