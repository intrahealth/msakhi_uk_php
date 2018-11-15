<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration extends Ci_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{	
		
	}

	/**
	*	routine to change the databsae character set and the collate
	* ALTER DATABASE databasename CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
	* ALTER TABLE tablename CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
	*/
	public function fix_structure()
	{
		$tables = $this->db->list_tables();

		$databasename = $this->db->database;
		$query = "ALTER DATABASE $databasename CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;";
		$this->db->query($query);

		foreach ($tables as $tablename)
		{
			$query = "ALTER TABLE $tablename CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;";
			$this->db->query($query);
		}

		echo "DONE!";
	}

	public function get_date_sheet()
	{
		$repositary = array();
		$tables = $this->db->list_tables();

		foreach ($tables as $tablename)
		{
			
			$fields = $this->db->field_data($tablename);

			foreach ($fields as $field)
			{
				if ($field->type == "date" || $field->type == "datetime") {
					$repositary[$tablename][$field->name] = $field->type;
				}
			}
		}

		print_r($repositary);
	}

	public function get_upload_status($from_date, $to_date)
	{
		$query = "select  tablet_dataimport.userid,anmname,mstasha.ashaname,count(*) as total from tablet_dataimport
		inner join userashamapping on userashamapping.userid = tablet_dataimport.userid
		inner join mstasha on mstasha.ashaid = userashamapping.ashaid
		inner join mstanm on mstanm.anmcode = mstasha.anmcode
		where impotedon between ? and  ?  and mstanm.languageid=1 and mstasha.languageid=1 and status ='Success' group by tablet_dataimport.userid,anmname,mstasha.ashaname";

		$result = $this->db->query($query, [$from_date, $to_date])->result();

		echo json_encode($result, JSON_PRETTY_PRINT);


	}



}
