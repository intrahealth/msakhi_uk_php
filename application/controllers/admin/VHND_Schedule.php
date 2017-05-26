<?php
class Vhnd_schedule extends Admin_Controller {

	private $debug;
	private $loginData;

	public function __construct()
	{
		parent::__construct();
		$this->session->flashdata("tr_msg");
		$this->session->flashdata("er_msg");
		$this->loginData = $this->session->userdata("loginData");
		$this->debug = [];
	}

	function index($export_vhnd = NULL) 
	{

		$query = "select * from mstsubcenter where LanguageID =1 and IsDeleted = 0";
		$content['Subcentre_list'] = $this->Common_Model->query_data($query);

		$RequestMethod = $this->input->server('REQUEST_METHOD');
		if($RequestMethod == "POST")
		{

			$query = "select * from anmsubcenter where SubCenterCode =  " . $this->input->post("SubCenterCode");
			$content['Anm_List'] = $this->Common_Model->query_data($query);

			$query = "select * from mstasha where LanguageID=1 and IsDeleted = 0";
			$content['Asha_List'] = $this->Common_Model->query_data($query);

			$operation = $this->input->post("operation");
			$year = $this->input->post("year");
			$anmid = $this->input->post("ANMID");

			if ($operation == "show_records") {
				// a = 1;
			}else if ($operation == "copy_previous") {
				$this->copy_previous();
			}else if ($operation == "generate_records") {
				$this->generate_records();
			}
	

			$content['Vhnd_List'] = $this->show_records($anmid, $year);

		}else{

			$content['Anm_List'] = array();
			$content['Village_List'] = array();
			$content['Vhnd_List']	=	array();

		}	

		$content['subview']="list_vhnd";
		$this->load->view('admin/main_layout', $content);
	}


	private function show_records($anmid, $year)
	{
		$query = "select * from mstanm anm 
		left join vhnd_schedule s 
		on anm.ANMID = s.ANM_ID
		left join mstasha a 
		on a.ASHAID = s.ASHA_ID 
		and a.LanguageID = 1
		where s.Year = $year
		and s.ANM_ID = $anmid
		and anm.LanguageID = 1";

		$result = $this->db->query($query)->result();
		if (count($result) < 1) {

			$query = "select 
			null as Schedule_ID, 
			null as Village_ID, 
			null as Occurence,
			null as Days,
			null as Jan,
			null as Feb,
			null as Mar,
			null as Apr,
			null as May,
			null as Jun,
			null as Jul,
			null as Aug,
			null as Sep,
			null as Oct,
			null as Nov,
			null as `Dec`,
			mstasha.ASHAID as ASHA_ID, mstasha.ASHAName from mstanm 
			left join anmasha
			on anmasha.ANMID = mstanm.ANMID
			left join mstasha 
			on mstasha.ASHAID = anmasha.ASHAID and mstasha.LanguageID = 1
			where mstanm.ANMID = $anmid
			and mstanm.LanguageID = 1";


			$this->session->set_flashdata("er_msg", "Microplan does not exist, loading list of asha of this ANM. Click on Generate Records to create microplan");
			$result = $this->db->query($query)->result();
			return $result;

		}

		$this->session->set_flashdata("tr_msg", "Successfully loaded VHND schedule");
		return $result;
		
	}

	private function copy_previous()
	{
		
	}

	private function generate_records()
	{

		$ANMID = $this->input->post("ANMID");

		// get subcenter id
		$SubCenterCode = $this->input->post("SubCenterCode");
		$query = "select * from  mstsubcenter where SubCenterCode = $SubCenterCode and LanguageID = 1";
		$SubCenter_ID = $this->db->query($query)->result()[0]->SubCenterID;

		$year = $this->input->post("year");
		$vhnd = $this->input->post("vhnd");

		$this->db->trans_start();

		foreach ($vhnd as $ashaid => $vhndrow) 
		{

			$VillageCode = $vhndrow["VillageCode"];
			if ($VillageCode == NULL) {
				$villageName = NULL;
			}else{

				$query = "select * from mstvillage where VillageCode = $VillageCode and LanguageID=2";
				$result = $this->db->query($query)->result();
				if (count($result) > 0) {
					$villageName = $this->db->query($query)->result()[0]->VillageName;
				}else{
					$villageName = NULL;
				}

			}
			

			$occurence = $vhndrow['occurence'];
			$day = $vhndrow['days'];

			$insertArr = array(
				'SubCenter_ID'	=>	$SubCenter_ID,
				'ANM_ID'				=>	$ANMID,
				'ASHA_ID'				=>	$ashaid,
				'Village_ID'		=>	$this->input->post("VillageCode"),
				'AW_Name'				=>	$villageName,
				'Frequency'			=>	$this->get_vhnd_frequency($occurence, $day),
				'Occurence'			=>	$occurence,
				'Days'					=>	$day,
				'Year'					=>	$year,
				'Jan'						=>	$this->get_vhnd_date($year, 1, $occurence, $day),
				'Feb'						=>	$this->get_vhnd_date($year, 2, $occurence, $day),
				'Mar'						=>	$this->get_vhnd_date($year, 3, $occurence, $day),
				'Apr'						=>	$this->get_vhnd_date($year, 4, $occurence, $day),
				'May'						=>	$this->get_vhnd_date($year, 5, $occurence, $day),
				'Jun'						=>	$this->get_vhnd_date($year, 6, $occurence, $day),
				'Jul'						=>	$this->get_vhnd_date($year, 7, $occurence, $day),
				'Aug'						=>	$this->get_vhnd_date($year, 8, $occurence, $day),
				'Sep'						=>	$this->get_vhnd_date($year, 9, $occurence, $day),
				'Oct'						=>	$this->get_vhnd_date($year, 10, $occurence, $day),
				'Nov'						=>	$this->get_vhnd_date($year, 11, $occurence, $day),
				'Dec'						=>	$this->get_vhnd_date($year, 12, $occurence, $day),
				'active'				=>	'A',
				'createdOn'			=>	date("Y-m-d"),
				'createdBy'			=>	$this->loginData->id,
				);
			// print_r($this->debug);
			// print_r($insertArr); die();
			$this->db->insert('vhnd_schedule', $insertArr);

		}


		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			return false;
		}

		return true;
	}

	private function get_vhnd_date($year = 2017, $month = 01, $occurence = 1, $day = 1)
	{

		// echo date('F', strtotime('2017-01-01'));
		$monthName = date('F', strtotime("$year-" . str_pad($month, 2, "0", STR_PAD_LEFT) . "-01"));
		// echo $monthName;

		$occurence_enum = ["dummy", "first","second","third","fourth","fifth"];
		$occurence_name = $occurence_enum[$occurence];
		// echo $occurence_name;

		$day_enum = ['dummy', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
		$day_name = $day_enum[$day];
		// echo $day_name;

		$this->debug[] =  "$occurence_name $day_name of $monthName $year";
		// echo date('Y-m-d', strtotime('first monday of January 2017'));
		$vhnd_date = date('Y-m-d', strtotime("$occurence_name $day_name of $monthName $year"));
		$this->debug[] =  "   $vhnd_date    ";

		return $vhnd_date;
	}

	public function get_vhnd_frequency($occurence = 1, $day = 1)
	{
		$occurence_enum = ["dummy", "first","second","third","fourth","fifth"];
		$occurence_name = $occurence_enum[$occurence];
		// echo $occurence_name;

		$day_enum = ['dummy', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
		$day_name = $day_enum[$day];

		return $occurence_name . ' ' . $day_name;
	}

}