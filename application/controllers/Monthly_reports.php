<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Monthly_reports extends Auth_controller {
	public function __construct(){
		parent::__construct();
		$this->loginData = $this->session->userdata('loginData');
	}
	function index()
	{
		$content['subview'] = "monthly_reports_view";
		$this->load->view('auth/main_layout', $content);

		$RequestMethod = $this->input->server('REQUEST_METHOD');

		if($RequestMethod == "POST")
		{
			$operation = $this->input->post('operation');
			if ($operation == "clear_filter") {
				$this->session->unset_userdata("date_filter");
				redirect(current_url());
			}

			if ($this->input->post('date_from') != NULL && $this->input->post('date_from') != "" && $this->input->post('date_to') != NULL && $this->input->post('date_to') != "") 
			{
				$date_filter = array(
					'date_from' => $this->input->post('date_from'),
					'date_to' => $this->input->post('date_to')
				);
				$this->session->set_userdata("date_filter",$date_filter);
			}else{
				$this->session->unset_userdata("date_filter");
			}

			if ($operation == "report1") {
				$this->get_monthly_report_3();
			}else if ($operation == "report2") {
				$this->get_monthly_report_4();
			}
		}
	}


	public function get_monthly_report_1($data = array(), $start_row = 6)
	{
		error_reporting(E_ALL);
		date_default_timezone_set('Asia/Kolkata');
		require_once APPPATH . 'libraries/PHPExcel/IOFactory.php';
		require_once  APPPATH . 'libraries/PHPExcel.php';

		$excel2 = PHPExcel_IOFactory::createReader('Excel2007');
		PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);
		$excel2 = $excel2->load(FCPATH . 'datafiles/Monthly_Report.xlsx');
		$excel2->setActiveSheetIndex(0);

		/**
		*Code for rows
		*/

		// load model after the filter is all set
		$this->load->model('Monthly_report_model');
		$data = $this->Monthly_report_model->get_ashawise_demographics();



		foreach ($data as $row) {
			$excel2->getActiveSheet()
			->setCellValue('A'.$start_row, $row->user_id)
			->setCellValue('B'.$start_row, $row->state_code)
			->setCellValue('C'.$start_row, $row->ASHAName)       
			->setCellValue('D'.$start_row, $row->Area_and_Demographics)
			->setCellValue('E'.$start_row, $row->total_household)
			->setCellValue('F'.$start_row, $row->total_population)
			->setCellValue('G'.$start_row, $row->women_15_49_years)
			->setCellValue('H'.$start_row, $row->pregnant_women_in_area)
			->setCellValue('I'.$start_row, $row->child_0_5_years)
			->setCellValue('J'.$start_row, $row->married_with_no_child)
			->setCellValue('K'.$start_row, $row->married_with_one_child)
			->setCellValue('L'.$start_row, $row->married_with_3_or_more_child)
			->setCellValue('M'.$start_row, $row->child_0_6_month)
			->setCellValue('N'.$start_row, $row->child_6_1_year)
			->setCellValue('O'.$start_row, $row->child_1_2_year)
			->setCellValue('P'.$start_row, $row->child_2_3_year)
			->setCellValue('Q'.$start_row, $row->child_3_5_year)
			->setCellValue('R'.$start_row, $row->pregnant_women_with_no_child)
			->setCellValue('S'.$start_row, $row->pregnant_women_with_one_child)
			->setCellValue('T'.$start_row, $row->pregnant_women_with_3_or_more_child)
			->setCellValue('U'.$start_row, $row->adults_35_50)
			->setCellValue('V'.$start_row, $row->adults_60_plus);
			
			$start_row++;
		}



		$objWriter = PHPExcel_IOFactory::createWriter($excel2, 'Excel2007');
		header('Content-type: application/vnd.ms-excel');

		// It will be called file.xls
		header('Content-Disposition: attachment; filename="Monthly_Report.xlsx"');

		ob_end_clean();
		$file_name = "consolidated_report.xlsx";
		$objWriter->save(FCPATH . "datafiles/$file_name");
		readfile(FCPATH . "datafiles/$file_name");
		exit();
	}


	public function get_monthly_report_2($data = array(), $start_row = 3)
	{
		error_reporting(E_ALL);
		date_default_timezone_set('Asia/Kolkata');
		require_once APPPATH . 'libraries/PHPExcel/IOFactory.php';
		require_once  APPPATH . 'libraries/PHPExcel.php';

		$excel2 = PHPExcel_IOFactory::createReader('Excel2007');
		PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);
		$excel2 = $excel2->load(FCPATH . 'datafiles/Monthly_Report.xlsx');
		$excel2->setActiveSheetIndex(1);

		/**
		*Code for rows
		*/

		// load model after the filter is all set
		$this->load->model('Monthly_report_model');
		$data = $this->Monthly_report_model->get_Pregnent();
		

		$excel2->getActiveSheet()
		->setCellValue('B3',$data->one_to_three)
		->setCellValue('C3', $data->three_to_six)
		->setCellValue('D3', $data->six_to_nine)
		->setCellValue('E3', $data->nine_more)
		->setCellValue('F3', $data->nonpregnent)
		->setCellValue('G3', $data->total);



		$this->load->model('Monthly_report_model');
		$data = $this->Monthly_report_model->get_Pregnent_anc1();

			// print_r($data);die;

		$excel2->getActiveSheet()
		->setCellValue('B4',$data->one_to_three)
		->setCellValue('C4', $data->three_to_six)
		->setCellValue('D4', $data->six_to_nine)
		->setCellValue('E4', $data->nine_more)
		->setCellValue('F4', $data->nonpregnent)
		->setCellValue('G4', $data->total);


		$this->load->model('Monthly_report_model');
		$data = $this->Monthly_report_model->get_Pregnent_anc2();

		$excel2->getActiveSheet()
		->setCellValue('B5',$data->one_to_three)
		->setCellValue('C5', $data->three_to_six)
		->setCellValue('D5', $data->six_to_nine)
		->setCellValue('E5', $data->nine_more)
		->setCellValue('F5', $data->nonpregnent)
		->setCellValue('G5', $data->total);

		$this->load->model('Monthly_report_model');
		$data = $this->Monthly_report_model->get_Pregnent_anc3();

		$excel2->getActiveSheet()
		->setCellValue('B6',$data->one_to_three)
		->setCellValue('C6', $data->three_to_six)
		->setCellValue('D6', $data->six_to_nine)
		->setCellValue('E6', $data->nine_more)
		->setCellValue('F6', $data->nonpregnent)
		->setCellValue('G6', $data->total);


		$this->load->model('Monthly_report_model');
		$data = $this->Monthly_report_model->get_Pregnent_anc4();

		$excel2->getActiveSheet()
		->setCellValue('B7',$data->one_to_three)
		->setCellValue('C7', $data->three_to_six)
		->setCellValue('D7', $data->six_to_nine)
		->setCellValue('E7', $data->nine_more)
		->setCellValue('F7', $data->nonpregnent)
		->setCellValue('G7', $data->total);



		$objWriter = PHPExcel_IOFactory::createWriter($excel2, 'Excel2007');
		header('Content-type: application/vnd.ms-excel');

		// It will be called file.xls
		header('Content-Disposition: attachment; filename="Monthly_Report.xlsx"');

		ob_end_clean();
		$file_name = "consolidated_report.xlsx";
		$objWriter->save(FCPATH . "datafiles/$file_name");
		readfile(FCPATH . "datafiles/$file_name");
		exit();
	}

	public function get_monthly_report_3($data = array(), $start_row = 4)
	{
		error_reporting(E_ALL);
		date_default_timezone_set('Asia/Kolkata');
		require_once APPPATH . 'libraries/PHPExcel/IOFactory.php';
		require_once  APPPATH . 'libraries/PHPExcel.php';

		$excel2 = PHPExcel_IOFactory::createReader('Excel2007');
		PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);
		$excel2 = $excel2->load(FCPATH . 'datafiles/Monthly_Report.xlsx');
		$excel2->setActiveSheetIndex(2);

		/**
		*Code for rows
		*/

		// $RequestMethod = $this->input->server('REQUEST_METHOD');

		// if($RequestMethod == "POST")
		// {
		// 	$this->apply_filter();
		// }

		// $content['filter_data'] = $this->session->userdata("filter_data");

		// load model after the filter is all set
			//Live birth
		$this->load->model('Monthly_report_model');
		$data = $this->Monthly_report_model->live_birth();

			// print_r($data);die;

		$excel2->getActiveSheet()
		->setCellValue('B2', $data->male)
		->setCellValue('C2', $data->female)
		->setCellValue('D2', $data->total);

			//Caesarean Deliveries
			// $this->load->model('Monthly_report_model');
			// $data = $this->Monthly_report_model->Caesarean_Deliveries();

			// // print_r($data);die;

			// $excel2->getActiveSheet()
			// ->setCellValue('B2', $data->male)
			// ->setCellValue('C2', $data->female);

			// Still Birth
		$this->load->model('Monthly_report_model');
		$data = $this->Monthly_report_model->Still_Birth();

			// print_r($data);die;

		$excel2->getActiveSheet()
			// ->setCellValue('B4', $data->male)
			// ->setCellValue('C4', $data->female)
		->setCellValue('D4', $data->total);



			// Abortion
		$this->load->model('Monthly_report_model');
		$data = $this->Monthly_report_model->Abortion();

			// print_r($data);die;

		$excel2->getActiveSheet()
			// ->setCellValue('B2', $data->male)
		->setCellValue('D5', $data->total);



			//Number of Newborns having weight less than 2.5 kg
		$this->load->model('Monthly_report_model');
		$data = $this->Monthly_report_model->newborn_heaving_weight_less();

			// print_r($data);die;

		$excel2->getActiveSheet()
		->setCellValue('B6', $data->male)
		->setCellValue('C6', $data->female)
		->setCellValue('D6', $data->total);






			//Number of Newborns breast fed within 1 hour of birth
		$this->load->model('Monthly_report_model');
		$data = $this->Monthly_report_model->newborn_breast_fed_within_1_hour();

			// print_r($data);die;

		$excel2->getActiveSheet()
		->setCellValue('B7', $data->male)
		->setCellValue('C7', $data->female)
		->setCellValue('D7', $data->total);




		$objWriter = PHPExcel_IOFactory::createWriter($excel2, 'Excel2007');
		header('Content-type: application/vnd.ms-excel');

		// It will be called file.xls
		header('Content-Disposition: attachment; filename="Monthly_Report.xlsx"');

		ob_end_clean();
		$file_name = "consolidated_report.xlsx";
		$objWriter->save(FCPATH . "datafiles/$file_name");
		readfile(FCPATH . "datafiles/$file_name");
		exit();
	}


	public function get_monthly_report_4($data = array(), $start_row = 2)
	{
		error_reporting(E_ALL);
		date_default_timezone_set('Asia/Kolkata');
		require_once APPPATH . 'libraries/PHPExcel/IOFactory.php';
		require_once  APPPATH . 'libraries/PHPExcel.php';

		$excel2 = PHPExcel_IOFactory::createReader('Excel2007');
		PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);
		$excel2 = $excel2->load(FCPATH . 'datafiles/Monthly_Report.xlsx');
		$excel2->setActiveSheetIndex(3);



		//Number of children (<= 5 years)
		$this->load->model('Monthly_report_model');
		$data = $this->Monthly_report_model->children_age_less_then_5();

			// print_r($data);die;

		$excel2->getActiveSheet()
		->setCellValue('B2', $data->male)
		->setCellValue('C2', $data->female)
		->setCellValue('D2', $data->total);


			//Number of children (<= 1 years)
		$this->load->model('Monthly_report_model');
		$data = $this->Monthly_report_model->children_age_less_then_1();

			// print_r($data);die;
		$excel2->getActiveSheet()
		->setCellValue('B3', $data->male)
		->setCellValue('C3', $data->female)
		->setCellValue('D3', $data->total);



			//Number of children (>1 month to <= 6 month)
		$this->load->model('Monthly_report_model');
		$data = $this->Monthly_report_model->children_age_greater_then_1_and_less_then_6();

			// print_r($data);die;

		$excel2->getActiveSheet()
		->setCellValue('B4', $data->male)
		->setCellValue('C4', $data->female)
		->setCellValue('D4', $data->total);




			//Number of children 11 months or above
		$this->load->model('Monthly_report_model');
		$data = $this->Monthly_report_model->children_age_greater_then_11();

			// print_r($data);die;

		$excel2->getActiveSheet()
		->setCellValue('B5', $data->male)
		->setCellValue('C5', $data->female)
		->setCellValue('D5', $data->total);



			//Number of children 11 months or above and take BCG
		$this->load->model('Monthly_report_model');
		$data = $this->Monthly_report_model->children_age_greater_then_11_BCG();

			// print_r($data);die;

		$excel2->getActiveSheet()
		->setCellValue('B7', $data->male)
		->setCellValue('C7', $data->female)
		->setCellValue('D7', $data->total);




			//Number of children 11 months or above and take DPT1
		$this->load->model('Monthly_report_model');
		$data = $this->Monthly_report_model->children_age_greater_then_11_DPT1();

			// print_r($data);die;

		$excel2->getActiveSheet()
		->setCellValue('B8', $data->male)
		->setCellValue('C8', $data->female)
		->setCellValue('D8', $data->total);


			//Number of children 11 months or above and take DPT2
		$this->load->model('Monthly_report_model');
		$data = $this->Monthly_report_model->children_age_greater_then_11_DPT2();

			// print_r($data);die;

		$excel2->getActiveSheet()
		->setCellValue('B9', $data->male)
		->setCellValue('C9', $data->female)
		->setCellValue('D9', $data->total);


			//Number of children 11 months or above and take DPT3
		$this->load->model('Monthly_report_model');
		$data = $this->Monthly_report_model->children_age_greater_then_11_DPT3();

			// print_r($data);die;

		$excel2->getActiveSheet()
		->setCellValue('B10', $data->male)
		->setCellValue('C10', $data->female)
		->setCellValue('D10', $data->total);


			//Number of children 11 months or above and take Pentavalent 1
		$this->load->model('Monthly_report_model');
		$data = $this->Monthly_report_model->children_age_greater_then_11_Pentavalent_1();

			// print_r($data);die;

		$excel2->getActiveSheet()
		->setCellValue('B11', $data->male)
		->setCellValue('C11', $data->female)
		->setCellValue('D11', $data->total);



			//Number of children 11 months or above and take Pentavalent 2
		$this->load->model('Monthly_report_model');
		$data = $this->Monthly_report_model->children_age_greater_then_11_Pentavalent_2();

			// print_r($data);die;

		$excel2->getActiveSheet()
		->setCellValue('B12', $data->male)
		->setCellValue('C12', $data->female)
		->setCellValue('D12', $data->total);



			//Number of children 11 months or above and take Pentavalent 3
		$this->load->model('Monthly_report_model');
		$data = $this->Monthly_report_model->children_age_greater_then_11_Pentavalent_3();

			// print_r($data);die;

		$excel2->getActiveSheet()
		->setCellValue('B13', $data->male)
		->setCellValue('C13', $data->female)
		->setCellValue('D13', $data->total);




			//Number of children 11 months or above and take OPV 1
		$this->load->model('Monthly_report_model');
		$data = $this->Monthly_report_model->children_age_greater_then_11_OPV_1();

			// print_r($data);die;

		$excel2->getActiveSheet()
		->setCellValue('B14', $data->male)
		->setCellValue('C14', $data->female)
		->setCellValue('D14', $data->total);



			//Number of children 11 months or above and take OPV 2
		$this->load->model('Monthly_report_model');
		$data = $this->Monthly_report_model->children_age_greater_then_11_OPV_2();

			// print_r($data);die;

		$excel2->getActiveSheet()
		->setCellValue('B15', $data->male)
		->setCellValue('C15', $data->female)
		->setCellValue('D15', $data->total);




			//Number of children 11 months or above and take OPV 3
		$this->load->model('Monthly_report_model');
		$data = $this->Monthly_report_model->children_age_greater_then_11_OPV_3();

			// print_r($data);die;

		$excel2->getActiveSheet()
		->setCellValue('B16', $data->male)
		->setCellValue('C16', $data->female)
		->setCellValue('D16', $data->total);




			//Number of children 11 months or above and take OPV 4
		$this->load->model('Monthly_report_model');
		$data = $this->Monthly_report_model->children_age_greater_then_11_OPV_4();

			// print_r($data);die;

		$excel2->getActiveSheet()
		->setCellValue('B17', $data->male)
		->setCellValue('C17', $data->female)
		->setCellValue('D17', $data->total);


			//Number of children 11 months or above and take Hepatitis 1
		$this->load->model('Monthly_report_model');
		$data = $this->Monthly_report_model->children_age_greater_then_11_Hepatitis_1();

			// print_r($data);die;

		$excel2->getActiveSheet()
		->setCellValue('B18', $data->male)
		->setCellValue('C18', $data->female)
		->setCellValue('D18', $data->total);



			//Number of children 11 months or above and take Hepatitis 2
		$this->load->model('Monthly_report_model');
		$data = $this->Monthly_report_model->children_age_greater_then_11_Hepatitis_2();

			// print_r($data);die;

		$excel2->getActiveSheet()
		->setCellValue('B19', $data->male)
		->setCellValue('C19', $data->female)
		->setCellValue('D19', $data->total);



			//Number of children 11 months or above and take Hepatitis 3
		$this->load->model('Monthly_report_model');
		$data = $this->Monthly_report_model->children_age_greater_then_11_Hepatitis_3();

			// print_r($data);die;

		$excel2->getActiveSheet()
		->setCellValue('B20', $data->male)
		->setCellValue('C20', $data->female)
		->setCellValue('D20', $data->total);



			//Number of children 11 months or above and take Hepatitis 4
		$this->load->model('Monthly_report_model');
		$data = $this->Monthly_report_model->children_age_greater_then_11_Hepatitis_4();

			// print_r($data);die;

		$excel2->getActiveSheet()
		->setCellValue('B21', $data->male)
		->setCellValue('C21', $data->female)
		->setCellValue('D21', $data->total);


			//Number of children 11 months or above and take Measles
		$this->load->model('Monthly_report_model');
		$data = $this->Monthly_report_model->children_age_greater_then_11_Measles();

			// print_r($data);die;

		$excel2->getActiveSheet()
		->setCellValue('B22', $data->male)
		->setCellValue('C22', $data->female)
		->setCellValue('D22', $data->total);



			//Number of children 9 and 11 months fully Immunized
		$this->load->model('Monthly_report_model');
		$data = $this->Monthly_report_model->children_age_between_9_and_11_fully_immunized();

			// print_r($data);die;

		$excel2->getActiveSheet()
		->setCellValue('B23', $data->male)
		->setCellValue('C23', $data->female)
		->setCellValue('D23', $data->total);



			//Number of children more than 16 months who received DPT Booster
		$this->load->model('Monthly_report_model');
		$data = $this->Monthly_report_model->children_age_more_then_16_received_DPT_Booster();

			// print_r($data);die;

		$excel2->getActiveSheet()
		->setCellValue('B26', $data->male)
		->setCellValue('C26', $data->female)
		->setCellValue('D26', $data->total);



			//Number of children more than 16 months who received DPT Booster
		$this->load->model('Monthly_report_model');
		$data = $this->Monthly_report_model->children_age_more_then_16_received_OPV_Booster();

			// print_r($data);die;

		$excel2->getActiveSheet()
		->setCellValue('B27', $data->male)
		->setCellValue('C27', $data->female)
		->setCellValue('D27', $data->total);



			//Number of children more than 16 months who received DPT Booster
		$this->load->model('Monthly_report_model');
		$data = $this->Monthly_report_model->children_age_more_then_16_received_Measles_Rubella();

			// print_r($data);die;

		$excel2->getActiveSheet()
		->setCellValue('B28', $data->male)
		->setCellValue('C28', $data->female)
		->setCellValue('D28', $data->total);



			//Number of children age between 12 and 23 months fully immunized
		$this->load->model('Monthly_report_model');
		$data = $this->Monthly_report_model->children_age_between_12_and_23_months_fully_immunized();

			// print_r($data);die;

		$excel2->getActiveSheet()
		->setCellValue('B30', $data->male)
		->setCellValue('C30', $data->female)
		->setCellValue('D30', $data->total);





		$objWriter = PHPExcel_IOFactory::createWriter($excel2, 'Excel2007');
		header('Content-type: application/vnd.ms-excel');

		// It will be called file.xls
		header('Content-Disposition: attachment; filename="Monthly_Report.xlsx"');

		ob_end_clean();
		$file_name = "consolidated_report.xlsx";
		$objWriter->save(FCPATH . "datafiles/$file_name");
		readfile(FCPATH . "datafiles/$file_name");
		exit();
	}
}