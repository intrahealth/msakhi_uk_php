<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Monthly_asha_report extends Auth_controller {

	public function __construct()
	{
		parent::__construct();
		$this->loginData = $this->session->userdata('loginData');
		$this->load->model('Monthly_asha_report_model');
	}
	
	public function index($id = NULL)
	{
		// start permission 
		$user_role = $this->loginData->user_role;
		$query = "SELECT * FROM role_permissions as rp LEFT JOIN mstrole as mst on rp.RoleID=mst.RoleID WHERE rp.RoleID='$user_role' ";
		$content['role_permission'] = $this->Common_Model->query_data($query);
		// end permission 

		$content['subview']="monthly_asha_report_view";
		$this->load->view('auth/main_layout', $content);
	}
	public function monthly_asha_report_1()
	{
		$content = $this->Monthly_asha_report_model->monthly_asha_report_1();

		$html = $this->load->view('print/monthly_asha_report_one', $content, true);
		 //die($html);

		$this->load->model('Wkhtmltopdf_model');
		$this->Wkhtmltopdf_model->export($html, 'report_01.pdf');
	}


	public function monthly_asha_report_2()
	{

		$content = $this->Monthly_asha_report_model->monthly_asha_report_2();
		
		$html = $this->load->view('print/monthly_asha_report_two' , $content, true);

		//die($html);

		$this->load->model('Wkhtmltopdf_model');
		$this->Wkhtmltopdf_model->export($html,'report_01.pdf');
	}
	public function monthly_asha_report_3()
	{
		

		$content = $this->Monthly_asha_report_model->monthly_asha_report_3();
		$html = $this->load->view('print/monthly_asha_report_three' , $content, true);
		 //die($html);

		$this->load->model('Wkhtmltopdf_model');
		$this->Wkhtmltopdf_model->export($html,'report_01.pdf');	
	}
	public function monthly_asha_report_4()
	{ 
		
		$content = $this->Monthly_asha_report_model->monthly_asha_report_4();
		$html =$this->load->view('print/monthly_asha_report_four', $content,true);
		// print_r($html); die();
		// die($html);

		$this->load->model('Wkhtmltopdf_model');
		$this->Wkhtmltopdf_model->export($html,'report_01.pdf');
	}
	public function monthly_asha_report_5()
	{


		$content = $this->Monthly_asha_report_model->monthly_asha_report_5();		
		$html = $this->load->view('print/monthly_asha_report_five' , $content, true);
		// print_r($html); die();

		// die($html);

		$this->load->model('Wkhtmltopdf_model');
		$this->Wkhtmltopdf_model->export($html,'report_01.pdf');
	}
	public function monthly_asha_report_6()
	{


		$content = $this->Monthly_asha_report_model->monthly_asha_report_6();		
		$html = $this->load->view('print/monthly_asha_report_six' , $content, true);

		// die($html);

		$this->load->model('Wkhtmltopdf_model');
		$this->Wkhtmltopdf_model->export($html,'report_01.pdf');
	}
	public function monthly_asha_report_7()
	{
		$content = $this->Monthly_asha_report_model->monthly_asha_report_7();
		
		$html = $this->load->view('print/monthly_asha_report_seven' , $content, true);

		// die($html);

		$this->load->model('Wkhtmltopdf_model');
		$this->Wkhtmltopdf_model->export($html,'report_01.pdf');
	}
	public function monthly_asha_report_8()
	{
		$content = "";
		
		$html = $this->load->view('print/monthly_asha_report_eight' , $content, true);

		// die($html);

		$this->load->model('Wkhtmltopdf_model');
		$this->Wkhtmltopdf_model->export($html,'report_01.pdf');
	}
	public function monthly_asha_report_9()
	{
		$content = $this->Monthly_asha_report_model->monthly_asha_report_9();
		
		$html = $this->load->view('print/monthly_asha_report_nine' , $content, true);

		// die($html);

		$this->load->model('Wkhtmltopdf_model');
		$this->Wkhtmltopdf_model->export($html,'report_01.pdf');
	}
	public function monthly_asha_report_10()
	{
		$content = $this->Monthly_asha_report_model->monthly_asha_report_10();
		
		$html = $this->load->view('print/monthly_asha_report_ten' , $content, true);

		// die($html);

		$this->load->model('Wkhtmltopdf_model');
		$this->Wkhtmltopdf_model->export($html,'report_01.pdf');
	}

}
