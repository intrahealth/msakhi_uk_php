<?php 

$PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
$PNG_WEB_DIR = 'temp/';
include "qrlib.php";

$data = json_encode([
	"HHSurveyGUID"       =>	uniqid(),
	"HHFamilyMemberGUID" =>	uniqid(),
	"ChildGUID"          =>	uniqid(),
	"PWGUID"             =>	uniqid(),
	]);

QRcode::png($data, 'temp/' . uniqid().'.png', 'H', 4, 2);
