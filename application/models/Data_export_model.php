<?php 

/**
* 
*/
class Data_export_model extends Ci_Model
{
	
	public function __construct()
	{
		parent::__construct();
	}

	public function export_pdf($query, $header_title = NULL, $header_title_string = NULL)
	{

		$result = $this->db->query($query)->result_array();
		$data = [];
		$headerStored = FALSE;

		foreach ($result as $result_row) 
		{
			foreach ($result_row as $result_column_key => $result_column_value) 
			{
				$buffer[] = $result_column_value;
				if ($headerStored == FALSE) 
				{
					$header[] = $result_column_key;
				}

			}

			$headerStored = TRUE;
			$data[] = $buffer;
			$buffer = [];
		}

		// print_r($header); die();

		if (!defined('PDF_AUTHOR')) {
			define ('PDF_AUTHOR', 'Intrahealth');
		}

		if ($header_title != NULL) {
			define ('PDF_HEADER_TITLE', $header_title);
		}else{
			define ('PDF_HEADER_TITLE', 'Data export');
		}

		if ($header_title_string != NULL) {
			define ('PDF_HEADER_STRING', $header_title_string);
		}else{
			define ('PDF_HEADER_STRING', 'List of Entries');
		}

		if (count($header) < 5) {
			define ('PDF_PAGE_ORIENTATION', 'P');
		}else{
			define ('PDF_PAGE_ORIENTATION', 'L');
		}

		require_once APPPATH . 'libraries/tcpdf/tcpdf.php';

		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// $pdf->SetCreator('Sandeep Kumar');
		$pdf->SetAuthor('Intrahealth');
		$pdf->SetTitle(PDF_HEADER_TITLE);
		// $pdf->SetSubject('Export ANM');
		// $pdf->SetKeywords('Export ANM');
		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
			require_once(dirname(__FILE__).'/lang/eng.php');
			$pdf->setLanguageArray($l);
		}

		// TCPDF_FONTS::addTTFfont(K_PATH_FONTS . 'lohit_hi.ttf', 'TrueTypeUnicode', '', 32);
		$pdf->SetFont('helvetica', '', 12);
		
		$pdf->AddPage();
		// $header = array('Country', 'Capital', 'Area (sq km)', 'Pop. (thousands)');
		// $data = $pdf->LoadData('data/table_data_demo.txt');
		// $pdf->ColoredTable($header, $data);

		$pdf->SetFillColor(255, 0, 0);
		$pdf->SetTextColor(255);
		$pdf->SetDrawColor(128, 0, 0);
		$pdf->SetLineWidth(0.3);
		$pdf->SetFont('', 'B');
		// Header
		$w = array(30,30,30,30,30);
		// $header = ["ANMUID", "ANMID", "ANMName", "LanguageID", "IsDeleted"];

		// print_r($header);
		$num_headers = count($header);
		for($i = 0; $i < $num_headers; $i++) {
			// $pdf->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
			$pdf->Cell(30, 7, $header[$i], 1, 0, 'C', 1);
		}
		$pdf->Ln();

		// Color and font restoration
		$pdf->SetFillColor(224, 235, 255);
		$pdf->SetTextColor(0);
		$pdf->SetFont('');
		// Data
		$fill = 0;
		foreach($data as $row) {
			
			for ($i=0; $i < $num_headers; $i++) { 
				$pdf->Cell(30,
					6, 
					$row[$i],
					'LR', 
					0, 
					'L', 
					$fill);
			}
			/*$pdf->Cell($w[0], 6, $row[0], 'LR', 0, 'L', $fill);
			$pdf->Cell($w[1], 6, $row[1], 'LR', 0, 'L', $fill);
			$pdf->Cell($w[2], 6, number_format($row[2]), 'LR', 0, 'R', $fill);
			$pdf->Cell($w[3], 6, number_format($row[3]), 'LR', 0, 'R', $fill);
			$pdf->Ln();
			$fill=!$fill;*/
			$pdf->Ln();
			$fill=!$fill;
		}
		$pdf->Cell(array_sum($w), 0, '', 'T');


		$pdf->Output(PDF_HEADER_TITLE . '.pdf', 'I');
	}

	public function export_csv($query)
	{
		$records = $result = $this->db->query($query)->result_array();

		// to get the column headers 
		$header_row = $records[0];
		foreach ($header_row as $key => $value) {
			$header[] = $key;
		}

		header("Content-type: application/csv");
		header("Content-Disposition: attachment; filename=\"export".".csv\"");
		header("Pragma: no-cache");
		header("Expires: 0");

		$handle = fopen('php://output', 'w');

		fputcsv($handle, $header);
		foreach ($records as $row) {
			fputcsv($handle, $row);
		}

		fclose($handle);
	}

}