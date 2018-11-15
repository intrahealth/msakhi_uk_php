<?php

/**
* Scheduled_tasks
*/
class Scheduled_tasks extends Ci_controller
{
	
	private $secret;
	function __construct()
	{
		parent::__construct();
		$this->secret = "mickey";
	}

	public function update_ashaid_anmid($secret=NULL)
	{
		if ($secret != $this->secret) {
			die("ERROR: You are not allowed to run this routine");
		}

		// update ASHAID
		$query = "update tblhhsurvey a 
		inner join userashamapping b 
		on a.CreatedBy = b.UserID
		set a.ServiceProviderID = b.AshaID";
		$result[] = $this->db->query($query);

		$query = "update tblhhfamilymember a 
		inner join userashamapping b 
		on a.CreatedBy = b.UserID 
		set a.AshaID = b.AshaID";
		$this->db->query($query);

		// update ANMID
		$query = "update tblhhsurvey a 
		inner join userashamapping b 
		on a.CreatedBy = b.UserID
		inner join anmasha c 
		on b.AshaID = c.ASHAID
		set a.ANMID = c.ANMID";
		$this->db->query($query);

		$query = "update tblhhfamilymember a 
		inner join userashamapping b
		on a.CreatedBy = b.UserID
		inner join anmasha c 
		on b.AshaID = c.ASHAID
		set a.ANMID = c.ANMID";
		$this->db->query($query);
		
	}
}