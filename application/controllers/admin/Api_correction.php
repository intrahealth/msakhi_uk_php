<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_correction extends Ci_controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Common_Model');
	}

	public function index()
	{
		echo "No operation selected";
	}

	public function re_parse_json($pass_number)
	{

		
		$query = "SELECT * FROM `tablet_dataimport` where JSON like '%tbl_hhfamilymember%' and ImpotedOn > CURRENT_DATE - INTERVAL 3 month order by ImpotedOn ASC limit " . (($pass_number - 1) * 1000) . ",". (($pass_number * 1000) - 1);
		
		die($query);

		$json_result = $this->db->query($query)->result();

		print_r($json_result);

		$processed = 0;

		$errorBag = array();

		foreach ($json_result as $record)
		{

			$json = $record->JSON;
			$user_id = $record->UserID;
			$import_id = $record->ImportID;

			// get the user login details 
			$this->db->where('user_id', $user_id);
			$result = $this->db->get('tblusers')->result();

			if (count($result) < 1) {
				$errorBag[] = "ERROR: Skipping ImportID: $import_id log No user found for user_id $user_id";
			}

			$user_name = $result[0]->user_name;
			$password = "1234";

			$upload_url = "http://msakhi.org/api/uploadData";

			$fields = array(
				'username' => $user_name,
				'password' => $password,
				'data' => $json,
			);

			//open connection
			$ch = curl_init();

			//set the url, number of POST vars, POST data
			curl_setopt($ch,CURLOPT_URL, $upload_url);
			curl_setopt($ch,CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch,CURLOPT_POSTFIELDS, http_build_query($fields));

			//execute post
			$curl_result = curl_exec($ch);

			if($curl_result == FALSE) 
			{ 
				echo curl_error($ch); 
			}

			//close connection
			curl_close($ch);

			$processed++;

		}
		
		print_r($errorBag);
		echo "processed $processed records";

	}

	public function re_parse_json_tblhhfamilymember($pass_number = NULL)
	{

		ini_set('memory_limit','2048M');
		ini_set('max_execution_time',600);

		$query = "SELECT * FROM `tablet_dataimport` where ImpotedOn > '2017-12-01' and Status='Success'  order by ImpotedOn ASC limit " . (($pass_number - 1) * 10000) . ",10000";
		
		$json_result = $this->db->query($query)->result();

		$processed = 0;

		$errorBag = array();

		foreach ($json_result as $record)
		{

			$json_bag = $record->JSON;
			$user_id = $record->UserID;
			$import_id = $record->ImportID;
			$imported_on = $record->ImpotedOn;
			$imported_date = date("Y-m-d", strtotime($imported_on));

			$json_object = json_decode($json_bag);


			if(isset($json_object->tbl_hhfamilymember) && count($json_object->tbl_hhfamilymember) > 0)
			{
				$familymember_list = $json_object->tbl_hhfamilymember;
			}else{
				$errorBag[] = "No tbl_hhfamilymember entry in object";
				continue;
			}



			$dateFields = $this->get_date_fields('tblhhfamilymember');
			foreach ($familymember_list as $row) 
			{

				$row = $this->clean_row($row, $dateFields);
				unset($row->HHFamilyMemberUID);

				if (trim($row->Father) == '0' || $row->Father == NULL || trim($row->Father) == '') {
					unset($row->Father);
				}

				if (trim($row->Mother) == '0' || $row->Mother == NULL || trim($row->Mother) == '') {
					unset($row->Mother);
				}

				if (trim($row->Spouse) == '0' || $row->Spouse == NULL || trim($row->Spouse) == '') {
					unset($row->Spouse);
				}

				$row->UploadedOn = $imported_date;

				
				$this->db->where('HHFamilyMemberGUID', $row->HHFamilyMemberGUID);
				$result = $this->db->get('tblhhfamilymember')->result();
				if (count($result) < 1) {

					$errorBag[] = "No record found for guid" . $row->HHFamilyMemberGUID;
				// insert
					// $row->IMEI = $this->input->post('IMEI');
					// $this->Common_Model->insert_data('tblhhfamilymember', $row);
				}else{
				// update

					unset($row->AshaID);
					unset($row->ANMID);

					$this->Common_Model->update_data('tblhhfamilymember', $row, 'HHFamilyMemberGUID', $row->HHFamilyMemberGUID);
				}

			}

			$processed++;
		}


		echo "processed $processed records";
		echo "error bad " . print_r($errorBag, true);
	}


	public function re_parse_json_csv($cutoff = NULL)
	{

		if ($cutoff == NULL) {
			die("ERROR: No cutoff date specified");
		}

		$query = "select * FROM `tablet_dataimport` where ImpotedOn >= ? and Status='Success' and json like '%ancvisit%' order by ImpotedOn ASC";

		die($query);

		$json_result = $this->db->query($query, [$cutoff])->result();

		header("Content-type: application/csv");
		header("Content-Disposition: attachment; filename=\"test".".csv\"");
		header("Pragma: no-cache");
		header("Expires: 0");

		$filepath = FCPATH . "datafiles/export.csv";
		$handle = fopen($filepath, 'w');
		$first = TRUE;

		foreach ($json_result as $record)
		{

			$json_bag = $record->JSON;
			$user_id = $record->UserID;
			$import_id = $record->ImportID;
			$imported_on = $record->ImpotedOn;
			$imported_date = date("Y-m-d", strtotime($imported_on));

			$json_object = json_decode($json_bag);

			$ancvisit_list = $json_object->tbl_ancvisit;

			$dateFields = $this->get_date_fields('tblancvisit');

			foreach ($ancvisit_list as $row) {

				$row = $this->clean_row($row, $dateFields);
				unset($row->AncVisitID);

				$row->UpdatedOn = $imported_date;
				$row->UpdatedBy = $user_id;
				$row->imported_on = $imported_on;

				if ($first == TRUE) {
					fputcsv($handle, array_keys(json_decode(json_encode($row), TRUE)));
					$first = FALSE;
				}

				fputcsv($handle, json_decode(json_encode($row), TRUE));

			}
		}

		fclose($handle);
		readfile($filepath);

	}

	private function get_date_fields($table_name)
	{

		$dateFields = array();

		$fields = $this->db->field_data($table_name);
		foreach ($fields as $field) {
			if ($field->type == "date") {
				$dateFields[] = strtolower($field->name);
			}
		}

		return $dateFields;
	}

	private function clean_row($row = array(), $dateFields = array())
	{
		$cleanRow = new stdclass;
		foreach ($row as $key => $value) {

			if (trim($value) == "") {
				$cleanRow->{$key} = NULL;
				continue;
			}

			if (in_array(strtolower($key), $dateFields)) {
				// echo " cleaning $key  |   ";
				$cleanRow->{$key} = date("Y-m-d", strtotime($value));
			}else{
				$cleanRow->{$key} = $value;
			}

		}

		return $cleanRow;
	}


}  
