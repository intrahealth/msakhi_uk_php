<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Graph extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$loginData = $this->session->userdata('loginData');
		// print_r($loginData); die();
		if(!isset($loginData))
		{
			redirect('login');	
		}
		if($loginData->user_role != 2){
			$this->session->set_flashdata('er_msg','You are not logged-in, please login again to continue');
			redirect('login');	
		}
	}

	public function preg_women_reg_first_trimester()
	{	
		$content['heading'] = "Proportion of Pregnant Women Registered in the First Trimester";
		$content['indicator'] = 'preg_women_reg_first_trimester';
		$content['subview'] = 'graph';
		$this->load->view('users/main_layout', $content);
	}

	public function one_anc_checkup()
	{	
		$content['heading'] = "Proportion of pregnant women with 1 ANC check-up";
		$content['subview'] = 'graph';
		$this->load->view('users/main_layout', $content);
	}

	public function two_anc_checkup()
	{	
		$content['heading'] = "Proportion of pregnant women with 2 ANC check-ups";
		$content['subview'] = 'graph';
		$this->load->view('users/main_layout', $content);
	}

	public function three_anc_checkup()
	{	
		$content['heading'] = "Proportion of pregnant women with 3 ANC check-ups";
		$content['subview'] = 'graph';
		$this->load->view('users/main_layout', $content);
	}

	public function four_anc_checkup()
	{	
		$content['heading'] = "Proportion of pregnant women with 4 ANC check-ups";
		$content['subview'] = 'graph';
		$this->load->view('users/main_layout', $content);
	}

	public function tt2_booster()
	{	
		$content['heading'] = "Proportion of pregnant women who received  TT2  or Booster";
		$content['subview'] = 'graph';
		$this->load->view('users/main_layout', $content);
	}

	public function institutional_delivery()
	{	
		$content['heading'] = "Proportion of institutional deliveries";
		$content['subview'] = 'graph';
		$this->load->view('users/main_layout', $content);
	}

	public function newborns_visited_two_or_more_times()
	{	
		$content['heading'] = "Newborns visited by ASHA at least two  or more times within first seven days";
		$content['subview'] = 'graph';
		$this->load->view('users/main_layout', $content);
	}

	public function newborns_visited_three_or_more_times()
	{	
		$content['heading'] = "Newborns visited by ASHA at least three  or more times within first seven days of home delivery";
		$content['subview'] = 'graph';
		$this->load->view('users/main_layout', $content);
	}

	public function newborns_visited_two_or_more_times_instituional()
	{	
		$content['heading'] = "Newborns visited by ASHA at least two  or more times within first seven days of institutional delivery";
		$content['subview'] = 'graph';
		$this->load->view('users/main_layout', $content);
	}

	public function low_birth_weight()
	{	
		$content['heading'] = "Low Birth Weight";
		$content['subview'] = 'graph';
		$this->load->view('users/main_layout', $content);
	}

}
