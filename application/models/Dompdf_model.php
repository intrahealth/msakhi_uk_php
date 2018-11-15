<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . 'vendor/autoload.php';
use Dompdf\Dompdf;

/**
* Dompdf wrapper class
* @author: Sandeep Kumar
*/
class Dompdf_model extends Ci_model
{
	
	public function __construct()
	{
		parent::__construct();
	}

	public function export($dom)
	{

		// instantiate and use the dompdf class
		$dompdf = new Dompdf();
		$dompdf->loadHtml($dom);
		
		// (Optional) Setup the paper size and orientation
		$dompdf->setPaper('A4', 'portrait');
		// $dompdf->setPaper('A4', 'landscape');

		// Render the HTML as PDF
		$dompdf->render();

		// Output the generated PDF to Browser
		$dompdf->stream();
	}


}