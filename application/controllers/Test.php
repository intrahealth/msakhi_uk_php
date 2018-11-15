<?php 

/**
 * 	Class for test
 */
class Test extends Ci_controller
{
	
	public function __construct()
	{
		parent::__construct();
	}


	/**
	 * Function to re-order household ID
	   to be run via console as below:

	   php index.php test re_order_hh

	 */
	public function re_order_hh($VillageID=null)
	{

		if ($VillageID != null) 
		{
			$this->db->where('VillageID >' . $VillageID);
		}

		$this->db->where('LanguageID', 1);
		$this->db->order_by('VillageID', 'asc');
		$village_list = $this->db->get('mstvillage')->result();
		foreach ($village_list as $row) 
		{
			$this->db->where('VillageID', $row->VillageID);
			$hh_list = $this->db->get('tblhhsurvey')->result();
			
			$index = 1;
			foreach ($hh_list as $hh_row) 
			{
				$updateArr = array('HHCode' => $index++, );
				$this->db->where('HHSurveyGUID', $hh_row->HHSurveyGUID);
				$this->db->update('tblhhsurvey', $updateArr);
			}

			echo "===============================================\n";
			echo "processed: village ID : " . $row->VillageID . "\n";
			echo "sleeping for a second ...\n";
			sleep(1);
			echo "resuming next...\n";
		}

	}
}