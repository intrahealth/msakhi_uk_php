<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// require_once APPPATH . 'vendor/autoload.php';
// use Dompdf\Dompdf;

/**
* Dompdf wrapper class
* @author: Sandeep Kumar
*/
class Wkhtmltopdf_model extends Ci_model
{
	
	public function __construct()
	{
		parent::__construct();
	}

	public function export($dom, $report_file_name='report_01.pdf', $orientation = '-O landscape')
	{
		$wkhtmltopdf = FCPATH . $this->config->item('wkhtmltopdf_path');

		$filename = md5(time() . rand(1,1000));
		file_put_contents(FCPATH . "pdf_reports/$filename.htm", $dom);
		$html = site_url("pdf_reports/$filename.htm");
		print_r($html);
		// die();
		$pdf = FCPATH  . "pdf_reports/$filename.pdf";
		exec("$wkhtmltopdf --viewport-size 1280x1024 $orientation $html $pdf");

		header("Content-Disposition: attachment; filename=" . urlencode($report_file_name));   
		header("Content-Type: application/octet-stream");
		header("Content-Type: application/download");
		header("Content-Description: File Transfer");            
		header("Content-Length: " . filesize($pdf));
		readfile($pdf);
	}

	public function export_return_url($dom, $orientation = '-O landscape')
	{

		$wkhtmltopdf = FCPATH . $this->config->item('wkhtmltopdf_path');

		$filename = md5(time() . rand(1,1000));
		file_put_contents(FCPATH . "pdf_reports/$filename.htm", $dom);
		$html = site_url("pdf_reports/$filename.htm");
		$pdf = FCPATH  . "pdf_reports/$filename.pdf";
		exec("$wkhtmltopdf --viewport-size 1280x1024 $orientation $html $pdf");

		return "$filename.pdf";
	}


}