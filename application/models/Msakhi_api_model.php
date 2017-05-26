<?php

class Msakhi_api_model extends CI_Model
{
	private $user;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Common_Model');
	}

	public function authenticateApiUser()
	{	
		$requested_method = $this->input->server('REQUEST_METHOD');
		if($requested_method != "POST")
		{
			return "ERROR! Request method not supported. Please use HTTP POST method";
		}

		$username = $this->security->xss_clean($this->input->post('username'));
		$password = $this->security->xss_clean($this->input->post('password'));
		// $user_role=$this->security->xss_clean($this->input->post('user_role'));

		if($username == "" || $password == "" )
		{
			return "Please specify username and password in the request";
		}

		$this->db->where('user_name',$username);
		$this->db->where('password', md5($password));
		// $this->db->where('user_role', $user_role);
		$query = $this->db->get('tblusers');


		// Error executing query
		if(!$query)
		{
			$errObj   = $this->db->error();
			$errNo = $errObj->code;
			$errMess = $errObj->message;
			return "ERROR: Login error: ".$errNo .' : '.$errMess;
		}

		// Check if corresponding user founds
		if($query->num_rows() != 1)
		{
			return "ERROR: Incorrect username/password. Please try again.";
		}

		$this->user = $query->result()[0];
		return $query->result()[0];
	}

	public function get_masters($user)
	{

		$this->user = $user;
		$content = array();
		$this->db->trans_start();

		$query = "select * from mststate";
		$content['mststate'] = $this->Common_Model->query_data($query);

		$query = "select * from mstdistrict";
		$content['mstdistrict'] = $this->Common_Model->query_data($query);

		$query = "select * from mstblock";
		$content['mstblock'] = $this->Common_Model->query_data($query);

		$query = "select * from mstvillage";
		$content['mstvillage'] = $this->Common_Model->query_data($query);

		$query = "select * from mstsubcenter";
		$content['mstsubcenter'] = $this->Common_Model->query_data($query);

		$query = "select * from mstpanchayat";
		$content['mstpanchayat'] = $this->Common_Model->query_data($query);

		if ($this->user->user_role == 2) 
		{
			$anm_id = $this->get_anm_of_asha($this->user->user_id);
			$query 	=	"select * from mstanm where ANMID = $anm_id";
			$content['mstanm']	=	$this->Common_Model->query_data($query);

			$asha_id = $this->get_asha_id_from_user_id($this->user->user_id);
			$query 	=	"select * from mstasha where ASHAID = $asha_id";
			$content['mstasha']	=	$this->Common_Model->query_data($query);
			
		}
		else if ($this->user->user_role == 3) 
		{
			$anm_id = $this->get_amn_id_from_user_id($this->user->user_id);	
			$query 	=	"select * from mstanm where ANMID = $anm_id";
			$content['mstanm']	=	$this->Common_Model->query_data($query);

			$asha_list = $this->get_asha_of_anm($this->user->user_id);
			$query 	=	"select * from mstasha where ASHAID in (".implode(",", $asha_list).")";
			$content['mstasha']	=	$this->Common_Model->query_data($query);

		}

		$query = "select * from mstcommon";
		$content['mstcommon']	=	$this->Common_Model->query_data($query);

		$query =	"select * from mstversion";
		$content['mstversion']	=	$this->Common_Model->query_data($query);

		$query =	"select * from mstphc";
		$content['mstphc']	=	$this->Common_Model->query_data($query);

		$query = "select * from mstcatchmentarea";
		$content['mstcatchmentarea'] = $this->Common_Model->query_data($query);

		$query = "select * from mstcatchmentsupervisor";
		$content['mstcatchmentsupervisor'] = $this->Common_Model->query_data($query);

		$query =	"select * from mstsubcentervillagemapping";
		$content['mstsubcentervillagemapping']	=	array();

		$query =	"select * from mstrole";
		$content['mstrole']	=	$this->Common_Model->query_data($query);

		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			return "ERROR: Error in transaction";					
		}

		return $content;

	}

	public function uploadData($user)
	{
		$this->user = $user;

		$data = $this->input->post('data');

		if($data == null || $data == "")
		{
			return "ERROR: Please send data with request";	
		}

		$data_array = json_decode($data);

		if($data_array == null)
		{
			return "ERROR: Please send properly formatted json";	
		}

		$this->db->trans_start();

		foreach ($data_array as $tableName => $tableData) {

			switch(strtolower($tableName))
			{
				case "tbl_hhsurvey":
				$this->tblhhsurvey($tableData);
				break;

				case "tbl_hhfamilymember":
				$this->tblhhfamilymember($tableData);
				break;

				case "tblmigration":
				$this->tblmigration($tableData);
				break;

				case "tblhhupdate_log":
				$this->tblhhupdate_log($tableData);
				break;

				case "tbl_ancvisit":
				$this->tblancvisit($tableData);
				break;

				case "tbl_pregnantwomen":
				$this->tblpregnant_woman($tableData);
				break;

				case "tblchild":
				$this->tblchild($tableData);
				break;

				case "tbl_datesed":
				$this->tbl_datesed($tableData);
				break;

				case "tblmstfpans":
				$this->tblmstfpans($tableData);
				break;

				case "tblmstimmunizationans":
				$this->tblmstimmunizationans($tableData);
				break;

				case "tblpnchomevisit_ans":
				$this->tblpnchomevisit_ans($tableData);
				break;

				default:
				return "ERROR: Unknown table $tableName in data.".__LINE__;	
				//default : $this = "error";
			}
		}


		$this->db->trans_complete();

		if($this->db->trans_status() === FALSE)
		{
			return "ERROR:error in transaction";
		}

		return array("success");

	}

	private function tblhhsurvey($data)
	{
		$dateFields = $this->get_date_fields(__FUNCTION__);

		foreach ($data as $row) {

			$row = $this->clean_row($row, $dateFields);

			$this->db->where('HHSurveyGUID', $row->HHSurveyGUID);
			$result = $this->db->get('tblhhsurvey')->result();
			if (count($result) < 1) {
				// insert
				$this->Common_Model->insert_data('tblhhsurvey', $row);
			}else{
				// update
				$this->Common_Model->update_data('tblhhsurvey', $row, 'HHSurveyGUID', $row->HHSurveyGUID);
			}
		}
	}

	private function tblhhfamilymember($data)
	{
		$dateFields = $this->get_date_fields(__FUNCTION__);

		foreach ($data as $row) {

			$row = $this->clean_row($row, $dateFields);

			$row->UploadedBy = $this->user->user_id;
			$row->UploadedOn = date("Y-m-d");

			$this->db->where('HHFamilyMemberGUID', $row->HHFamilyMemberGUID);
			$result = $this->db->get('tblhhfamilymember')->result();
			if (count($result) < 1) {
				// insert
				$this->Common_Model->insert_data('tblhhfamilymember', $row);
			}else{
				// update
				$this->Common_Model->update_data('tblhhfamilymember', $row, 'HHFamilyMemberGUID', $row->HHFamilyMemberGUID);
			}
		}
	}

	private function tblmigration($data)
	{
		$dateFields = $this->get_date_fields(__FUNCTION__);

		foreach ($data as $row) {

			$row = $this->clean_row($row, $dateFields);

			$row->UpdatedBy = $this->user->user_id;
			$row->UpdatedOn = date("Y-m-d");


			$this->db->where('HHFamilyMemberGUID', $row->HHFamilyMemberGUID);
			$result = $this->db->get('tblmigration')->result();
			if (count($result) < 1) {
				// insert
				$this->Common_Model->insert_data('tblmigration', $row);
			}else{
				// update
				$this->Common_Model->update_data('tblmigration', $row, 'HHFamilyMemberGUID', $row->HHFamilyMemberGUID);
			}
		}
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

	private function tblchild($data)
	{

		$dateFields = $this->get_date_fields(__FUNCTION__);

		foreach ($data as $row) {

			$row = $this->clean_row($row, $dateFields);

			$this->db->where('ChildGUID', $row->ChildGUID);
			$result = $this->db->get('tblchild')->result();
			if (count($result) < 1) {
				// insert
				$this->Common_Model->insert_data('tblchild', $row);
			}else{
				// update
				$this->Common_Model->update_data('tblchild', $row, 'ChildGUID', $row->ChildGUID);
			}
		}
	}

	private function tblancvisit($data)
	{
		$dateFields = $this->get_date_fields(__FUNCTION__);

		foreach ($data as $row) {

			$row = $this->clean_row($row, $dateFields);

			$this->db->where('VisitGUID', $row->VisitGUID);
			$result = $this->db->get('tblancvisit')->result();
			if (count($result) < 1) {
				// insert
				$this->Common_Model->insert_data('tblancvisit', $row);
			}else{
				// update
				$this->Common_Model->update_data('tblancvisit', $row, 'VisitGUID', $row->VisitGUID);
			}
		}
	}

	private function tblpregnant_woman($data)
	{
		$dateFields = $this->get_date_fields(__FUNCTION__);

		foreach ($data as $row) {

			$row = $this->clean_row($row, $dateFields);

			$this->db->where('PWGUID', $row->PWGUID);
			$result = $this->db->get('tblpregnant_woman')->result();
			if (count($result) < 1) {
				// insert
				$this->Common_Model->insert_data('tblpregnant_woman', $row);
			}else{
				// update
				$this->Common_Model->update_data('tblpregnant_woman', $row, 'PWGUID', $row->PWGUID);
			}
		}
	}

	private function tbl_datesed($data)
	{
		$dateFields = $this->get_date_fields(__FUNCTION__);

		foreach ($data as $row) {

			$row = $this->clean_row($row, $dateFields);

			$this->db->where('HHSurveyGUID', $row->HHSurveyGUID);
			$this->db->where('HHFamilyMemberGUID', $row->HHFamilyMemberGUID);
			$this->db->where('PWGUID', $row->PWGUID);
			$result = $this->db->get('tbl_datesed')->result();
			if (count($result) < 1) {
				// insert
				$this->Common_Model->insert_data('tbl_datesed', $row);
			}else{
				// update
				$this->db->where('HHSurveyGUID', $row->HHSurveyGUID);
				$this->db->where('HHFamilyMemberGUID', $row->HHFamilyMemberGUID);
				$this->db->where('PWGUID', $row->PWGUID);
				$this->db->update('tbl_datesed', $row);
			}
		}
	}

	private function tblmstfpans($data)
	{
		$dateFields = $this->get_date_fields(__FUNCTION__);

		foreach ($data as $row) {

			$row = $this->clean_row($row, $dateFields);

			$this->db->where('FPAns_Guid', $row->FPAns_Guid);
			$result = $this->db->get('tblmstfpans')->result();
			if (count($result) < 1) {
				// insert
				$this->Common_Model->insert_data('tblmstfpans', $row);
			}else{
				// update
				$this->Common_Model->update_data('tblmstfpans', $row, 'FPAns_Guid', $row->FPAns_Guid);
			}
		}
	}

	private function tblmstimmunizationans($data)
	{
		$dateFields = $this->get_date_fields(__FUNCTION__);

		foreach ($data as $row) {

			$row = $this->clean_row($row, $dateFields);

			$this->db->where('ImmunizationGUID', $row->ImmunizationGUID);
			$result = $this->db->get('tblmstimmunizationans')->result();
			if (count($result) < 1) {
				// insert
				$this->Common_Model->insert_data('tblmstimmunizationans', $row);
			}else{
				// update
				$this->Common_Model->update_data('tblmstimmunizationans', $row, 'ImmunizationGUID', $row->ImmunizationGUID);
			}
		}
	}

	private function tblpnchomevisit_ans($data)
	{
		$dateFields = $this->get_date_fields(__FUNCTION__);

		foreach ($data as $row) {

			$row = $this->clean_row($row, $dateFields);

			$this->db->where('ChildGUID', $row->ChildGUID);
			$this->db->where('PNCGUID', $row->PNCGUID);
			$result = $this->db->get('tblpnchomevisit_ans')->result();
			if (count($result) < 1) {
				// insert
				$this->Common_Model->insert_data('tblpnchomevisit_ans', $row);
			}else{
				// update
				$this->db->where('ChildGUID', $row->ChildGUID);
				$this->db->where('PNCGUID', $row->PNCGUID);
				$this->db->update('tblpnchomevisit_ans', $row);
			}
		}
	}

	private function tblhhupdate_log($data)
	{
		foreach ($data as $row) {
			
		}
	}

	private function get_asha_of_anm($user_id)
	{

		// get the anmid of currnet user 
		$query = "select * from useranmmapping where UserID = $user_id";
		$anm_id = $this->db->query($query)->result()[0]->ANMID;

		$query = "select * from anmasha where ANMID = $anm_id";
		$result = $this->db->query($query)->result();

		$ashaArr = array();
		foreach ($result as $row) {
			$ashaArr[] = $row->ASHAID;
		}
		return $ashaArr;
	}

	private function get_anm_of_asha($user_id)
	{

		// get the asha id of current user 
		$query = "select * from userashamapping where UserID = $user_id limit 1";
		$asha_id = $this->db->query($query)->result()[0]->AshaID;

		$query = "select * from anmasha where ASHAID = $asha_id limit 1";
		return $this->db->query($query)->result()[0]->ANMID;

	}

	private function get_user_id_from_asha_id($asha_id)
	{
		$query = "select * from userashamapping where AshaID = $asha_id";
		return $this->db->query($query)->result()[0]->UserID;
	}

	private function get_asha_id_from_user_id($user_id)
	{
		$query = "select * from userashamapping where UserID = $user_id";
		return $this->db->query($query)->result()[0]->AshaID;
	}

	private function get_amn_id_from_user_id($user_id)
	{
		$query = "select * from useranmmapping where UserID = $user_id";
		return $this->db->query($query)->result()[0]->ANMID;
	}

	private function null_to_empty_string($table_name)
	{
		$tableFields = $this->db->list_fields($table_name);
		
		$returnArray = array();
		foreach ($tableFields as $field) {
			$returnArray[] = "IFNULL($field,'') as $field";
		}

		return implode(' , ', $returnArray);

	}

	public function get_table_data($user, $table_name, $created_by=NULL)
	{
		$this->user = $user;

		if ($this->user->user_role == 3)
		{
			$asha_id = $this->input->post('asha_id');
			if ($asha_id == NULL || trim($asha_id) == "")
			{
				// this means that the request is meant for anm
				$user_id = $this->user->user_id;

			}else{
				// if the asha_id is set, then check if the asha is associated with this anm 
				$ashaArr = $this->get_asha_of_anm($this->user->user_id);
				if (!in_array($asha_id, $ashaArr)) {
					return "ERROR: This asha is not linked with ANM used in login";
				}

				$user_id = $this->get_user_id_from_asha_id($asha_id);
			}
		}
		else if ($this->user->user_role == 2)
		{

			$user_id = $this->user->user_id;

		}else{

			return "ERROR: This user role is not allowed to download data";

		}

		$content = array();

		$this->db->trans_start();

		if ($created_by == NULL) {
			$created_by = "createdBy";
		}

		$query = "select ".$this->null_to_empty_string($table_name)." from $table_name where $created_by = " . $user_id;
		$resultSet = $this->Common_Model->query_data($query);


		$content[$table_name] = $resultSet;
		$this->db->trans_complete();

		if($this->db->trans_status() === FALSE)
		{
			return "ERROR:error in transaction";
		}

		return $content;
	}

	public function get_question_tables()
	{

		$this->db->trans_start();
		$tables = ["tblmstfpques", "tblmstancques", "tblmstimmunizationques", "tblmstpncques"];

		foreach ($tables as $table) {
			$query = "select ".$this->null_to_empty_string($table)." from $table";
			$content[$table] = $this->Common_Model->query_data($query);
		}

		$this->db->trans_complete();

		if($this->db->trans_status() === FALSE)
		{
			return "ERROR:error in transaction";
		}

		return $content;
	}

}
