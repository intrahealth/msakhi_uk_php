<?php 

/**
* Qr
*/
class Qr extends Ci_controller
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$PNG_TEMP_DIR = FCPATH . 'temp/';
		$PNG_WEB_DIR = FCPATH . 'datafiles/';
		$PNG_FILENAME = uniqid() . ".png";

		include FCPATH . "application/libraries/phpqrcode/qrlib.php";

		$data = json_encode([
			"HHSurveyGUID"       =>	uniqid(),
			"HHFamilyMemberGUID" =>	uniqid(),
			"ChildGUID"          =>	uniqid(),
			"PWGUID"             =>	uniqid(),
			]);

		QRcode::png($data, $PNG_WEB_DIR . $PNG_FILENAME, 'H', 4, 2);

		echo '<img src="'.site_url('datafiles/'. $PNG_FILENAME).'">';
	}
}