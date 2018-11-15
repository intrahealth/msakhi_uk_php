<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends Ci_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Common_Model');
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
			 // print_r($row); die();

			$query = "SELECT * FROM role_permissions as rp LEFT JOIN mstrole as mst on rp.RoleID=mst.RoleID WHERE rp.RoleID='$row->user_role' ";
			 // die($query);
			$content['role_permission'] = $this->Common_Model->query_data($query);
      // print_r($content['role_permission']); die();

			if($row->user_role == 1)
			{
				$this->session->set_flashdata('tr_msg', 'Your username or password was incorrect.');
				redirect('login');
			}else if($row->user_role == 2){
				$this->session->set_flashdata('tr_msg', 'Your username or password was incorrect.');
				redirect('login');
			}else if($row->user_role == 3)
			{
				$this->session->set_flashdata('tr_msg', 'Your username or password was incorrect.');
				redirect('login');
			}else if($row->user_role == 4){
				$this->session->set_flashdata('tr_msg', 'Your username or password was incorrect.');
				redirect('login');
			}else if($row->user_role == 5)
			{
				redirect('mnch_dashboard');
			}else if($row->user_role == 6){

				foreach ($content['role_permission'] as $row) { 
					if ($row->Controller == "mnch_dashboard" && $row->Action == "index") { 
						redirect('dashboard');
					} else if ($row->Controller == "dashboard" && $row->Action == "index") { 
						redirect('dashboard');
					} else if ($row->Controller == "Output_indicators" && $row->Action == "index") { 
						redirect('Output_indicators');
					}else if ($row->Controller == "Process_indicators" && $row->Action == "index") { 
						redirect('Process_indicators');
					}else if ($row->Controller == "Drill_downreport" && $row->Action == "index") { 
						redirect('Drill_downreport');
					}
				}

			}else if($row->user_role == 7)
			{
				foreach ($content['role_permission'] as $row) { 
					if ($row->Controller == "mnch_dashboard" && $row->Action == "index") { 
						redirect('dashboard');
					} else if ($row->Controller == "dashboard" && $row->Action == "index") { 
						redirect('dashboard');
					} else if ($row->Controller == "Output_indicators" && $row->Action == "index") { 
						redirect('Output_indicators');
					}else if ($row->Controller == "Process_indicators" && $row->Action == "index") { 
						redirect('Process_indicators');
					}else if ($row->Controller == "Drill_downreport" && $row->Action == "index") { 
						redirect('Drill_downreport');
					}
				}

			}else if($row->user_role == 8)
			{
				foreach ($content['role_permission'] as $row) { 
					if ($row->Controller == "mnch_dashboard" && $row->Action == "index") { 
						redirect('dashboard');
					} else if ($row->Controller == "dashboard" && $row->Action == "index") { 
						redirect('dashboard');
					} else if ($row->Controller == "Output_indicators" && $row->Action == "index") { 
						redirect('Output_indicators');
					}else if ($row->Controller == "Process_indicators" && $row->Action == "index") { 
						redirect('Process_indicators');
					}else if ($row->Controller == "Drill_downreport" && $row->Action == "index") { 
						redirect('Drill_downreport');
					}
				}

			}else if ($row->user_role == 10) {
				
				foreach ($content['role_permission'] as $row) { 
					if ($row->Controller == "mnch_dashboard" && $row->Action == "index") { 
						redirect('dashboard');
					} else if ($row->Controller == "dashboard" && $row->Action == "index") { 
						redirect('dashboard');
					} else if ($row->Controller == "Output_indicators" && $row->Action == "index") { 
						redirect('Output_indicators');
					}else if ($row->Controller == "Process_indicators" && $row->Action == "index") { 
						redirect('Process_indicators');
					}else if ($row->Controller == "Drill_downreport" && $row->Action == "index") { 
						redirect('Drill_downreport');
					}
				}

			}
		}
		else
		{
			$this->session->set_flashdata('tr_msg', 'Your username or password was incorrect.');
			redirect('login');
		}
	}

	public function logout()
	{
		$this->session->set_flashdata('er_msg', 'Please login agin to continue...');
		$this->session->sess_destroy('loginData');
		redirect('');
	}

}
