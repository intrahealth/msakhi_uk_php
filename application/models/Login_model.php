<?php 

/**
* Login Class
*/
class Login_modelff extends CI_model
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		
	}

	public function verifylogin()
	{
		$username = $this->security->xss_clean($this->input->post('username'));
		$password = $this->security->xss_clean($this->input->post('password'));

		if ($username == NULL || trim($username) == '') {
			$this->session->set_flashdata('er_msg', 'Username is required for loggin in');
			return false;
		}

		if ($password == NULL || trim($password) == '') {
			$this->session->set_flashdata('er_msg', 'Password is required for loggin in');
			return false;
		}

		$this->db->where('username', $username);
		$this->db->where('password', md5($password));
		$result = $this->db->get('tblusers')->result();
    //print_r($result); die();
		if (count($result) != 1) {
			$this->session->set_flashdata('er_msg', 'Incorrect username / password please try again');
			return false;
		}

		$this->session->set_userdata('login_data', $result[0]);
		return true;
		
	}
}