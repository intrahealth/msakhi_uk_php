<?php


class Ajax extends Users_Controller {

	public function __construct(){
		parent::__construct();
	}

	function index($id = NULL) {
		die("No service selected");
	}
	/*
	public function  getDistrictLists($StateCode) {
		
			$query = "select * from mstdistrict where StateCode = $StateCode and LanguageID=1";
						$result = $this->Common_Model->query_data($query);

						$option = '<option value="">--select--</option>';
						foreach($result as $row){
							$option .= '<option value="'.$row->DistrictCode.'">'.$row->DistrictName.'</option>';
									}
									
								echo $option;
			
	}
	
	function getBlockLists($DistrictCode)
	{
		$query = "select * from mstblock where DistrictCode = $DistrictCode and LanguageID=1";
			$blocks = $this->Common_Model->query_data($query);

		$option = "<option value=''>Select</option>";
		foreach ($blocks as $row) {
			$option .= '<option value="'.$row->BlockCode.'">' .$row->BlockName.'</option>';
		}

		echo $option;
	}
	
	function getPanchayatLists($BlockCode)
	{
		$query	=	"select * from mstpanchayat where BlockCode	=	$BlockCode and LanguageID=1";
			$panchayat	= $this->Common_Model->query_data($query);
			
			$option = "<option value=''>Select</option>";
			foreach ($panchayat as $row){
			$option .= '<option value=" '.$row->PanchayatCode.'">' .$row->PanchayatName.'</option>';
	}
	
	echo $option;
		
	}
	
*/


	function getAnmList(){

		$searchPhrase = $this->input->post('searchPhrase');
		$section = $this->input->post('section');
		$sectionId = $this->input->post('sectionId');
		
		$query = "select * from mstanm where LanguageID=1";
		
		// die($query);
		
		//extraQuery for search dialog
		$extraQuery = " where ANMName like '".$searchPhrase."%'
		or ANMCode like '".$searchPhrase."%'";
		if($searchPhrase != "") $query .= $extraQuery;
		
		//order by clause
		$sort = $this->input->post('sort');
		$sortBy = array_keys($sort);
		
		switch($sortBy[0]){
			case "ANMID":
			$orderQuery = " order by ANMID " . $sort[$sortBy[0]];
			break;
			case "ANMName":
			$orderQuery = " order by ANMName " . $sort[$sortBy[0]];
			break;
			case "ANMCode":
			$orderQuery = " order by ANMCode " . $sort[$sortBy[0]];
			break;
			default:
			$orderQuery = " order by ANMID " . $sort[$sortBy[0]];
			break;
		}
		
		$query .= $orderQuery;
		
		//make a query to show total records
		$Opportunity_list = $this->Common_Model->query_data($query);
		$total = count($Opportunity_list);
		
		$current = (int)$this->input->post('current');
		$rowCount = (int)$this->input->post('rowCount');
		
		//limit conditions
		$limitQuery = " limit ".($current - 1)*($rowCount).",".$rowCount;
		$query .= $limitQuery;
		
		// echo $query; die();
		$Opportunity_list = $this->Common_Model->query_data($query);
		
		$counter = 1;
		foreach($Opportunity_list as $opp)
		{
			$opp->sno = $counter;
			$counter++;
		}
		
		$returnArray = array(
			"current"		=>	$this->input->post('current'),
			"rowCount"	=>	$this->input->post('rowCount'),
			"total"			=>	$total,
			"rows"			=>	$Opportunity_list,
			);
		
		echo json_encode($returnArray);		
	}
	
	
	
	function getSubList(){

		$searchPhrase = $this->input->post('searchPhrase');
		$section = $this->input->post('section');
		$sectionId = $this->input->post('sectionId');
		
		$query = "select * from mstsubcenter where LanguageID=1";
		
		// die($query);
		
		//extraQuery for search dialog
		$extraQuery = " where SubCenterName like '".$searchPhrase."%'
		or SubCenterCode like '".$searchPhrase."%'";
		if($searchPhrase != "") $query .= $extraQuery;
		
		//order by clause
		$sort = $this->input->post('sort');
		$sortBy = array_keys($sort);
		
		switch($sortBy[0]){
			case "SubCenterID":
			$orderQuery = " order by SubCenterID " . $sort[$sortBy[0]];
			break;
			case "SubCenterName":
			$orderQuery = " order by SubCenterName " . $sort[$sortBy[0]];
			break;
			case "SubCenterCode	":
			$orderQuery = " order by SubCenterCode	 " . $sort[$sortBy[0]];
			break;
			default:
			$orderQuery = " order by SubCenterID   " . $sort[$sortBy[0]];
			break;
		}
		
		$query .= $orderQuery;
		
		//make a query to show total records
		$Opportunity_list = $this->Common_Model->query_data($query);
		$total = count($Opportunity_list);
		
		$current = (int)$this->input->post('current');
		$rowCount = (int)$this->input->post('rowCount');
		
		//limit conditions
		$limitQuery = " limit ".($current - 1)*($rowCount).",".$rowCount;
		$query .= $limitQuery;
		
		// echo $query; die();
		$Opportunity_list = $this->Common_Model->query_data($query);
		
		$counter = 1;
		foreach($Opportunity_list as $opp)
		{
			$opp->sno = $counter;
			$counter++;
		}
		
		$returnArray = array(
			"current"		=>	$this->input->post('current'),
			"rowCount"	=>	$this->input->post('rowCount'),
			"total"			=>	$total,
			"rows"			=>	$Opportunity_list,
			);
		
		echo json_encode($returnArray);		
	}
	
	
	function getVillageList(){

		$searchPhrase = $this->input->post('searchPhrase');
		$section = $this->input->post('section');
		$sectionId = $this->input->post('sectionId');
		
		$query = "select * from mstvillage where LanguageID=1";
		
		// die($query);
		
		//extraQuery for search dialog
		$extraQuery = " where VillageName like '".$searchPhrase."%'
		or VillageCode like '".$searchPhrase."%'";
		if($searchPhrase != "") $query .= $extraQuery;
		
		//order by clause
		$sort = $this->input->post('sort');
		$sortBy = array_keys($sort);
		
		switch($sortBy[0]){
			case "VillageID":
			$orderQuery = " order by ANMID " . $sort[$sortBy[0]];
			break;
			case "VillageName":
			$orderQuery = " order by VillageName " . $sort[$sortBy[0]];
			break;
			case "VillageCode":
			$orderQuery = " order by VillageCode " . $sort[$sortBy[0]];
			break;
			default:
			$orderQuery = " order by VillageID " . $sort[$sortBy[0]];
			break;
		}
		
		$query .= $orderQuery;
		
		//make a query to show total records
		$Opportunity_list = $this->Common_Model->query_data($query);
		$total = count($Opportunity_list);
		
		$current = (int)$this->input->post('current');
		$rowCount = (int)$this->input->post('rowCount');
		
		//limit conditions
		$limitQuery = " limit ".($current - 1)*($rowCount).",".$rowCount;
		$query .= $limitQuery;
		
		// echo $query; die();
		$Opportunity_list = $this->Common_Model->query_data($query);
		
		$counter = 1;
		foreach($Opportunity_list as $opp)
		{
			$opp->sno = $counter;
			$counter++;
		}
		
		$returnArray = array(
			"current"		=>	$this->input->post('current'),
			"rowCount"	=>	$this->input->post('rowCount'),
			"total"			=>	$total,
			"rows"			=>	$Opportunity_list,
			);
		
		echo json_encode($returnArray);		
	}
	
	
	function getDistrict(){
		
		$roleType = $this->input->post('roleType');
		$stateCode = $this->input->post('stateCode');
		$districtCode=$this->input->post('districtCode');

		/* Distrct level Lavel*/

			$result=$this->Common_Model->getDistrictLists($stateCode,$districtCode);

			print("<label for=\"districtname\">Select District  </label>
				<br>
				<select name=\"districtname\" onchange=\"blocklist(this.value)\" id=\"districtname\" class=\"form-control\" required>
					$result

				</select>");

	
		

	}



	function getBlock(){

		$roleType = $this->input->post('roleType');
		$distCode = $this->input->post('distCode');
		$blockCode = $this->input->post('blockCode');
		/* Distrct level Lavel*/
	$result=$this->Common_Model->getBlockLists($distCode, $blockCode);
			print("<label for=\"blockname\">Select Block  </label>
				<br>
				<select name=\"blockname\" id=\"blockname\"  class=\"form-control\" required>
					$result

				</select>");
	


	}
	

	function validateUser()
	{
			
		$username = $this->input->post('username');
		$this->db->where('user_name',$username);
		$res = $this->db->get('tblusers');
		if($res->num_rows() == 0)
		{
			echo 1;

		}else{

			echo 2;
		}


	}


function validateEditUser()
{
		$username = $this->input->post('username');
		$id = $this->input->post('id');
		$this->db->where('user_name',$username);
		$this->db->where('id!=',$id);
		$res= $this->db->get('tblusers');
		$row = $res->row();
		if($res->num_rows() == 0)
		{
			echo 1;

		}else{

			echo 2;
		}

}




function getState(){

		$stateCode = $this->input->post('stateCode');
		$result=$this->Common_Model->getStateList(1,$stateCode,$stateCode=null);

		print("<label for=\"state\">Select State  </label><br>
		<select name=\"state\" id=\"state\" onchange=\"return districtList(this.value)\"  class=\"form-control\" required>$result</select>");



}






	
}
