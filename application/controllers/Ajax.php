<?php
class Ajax extends Auth_controller {

	public function __construct(){
		parent::__construct();
	}

	function index($id = NULL) {
		die("No service selected");
	}
	
	public function  getDistrictLists($StateCode) {
		
		$query = "select * from mstdistrict where StateCode = $StateCode and LanguageID=1 and IsDeleted=0";
		$result = $this->Common_Model->query_data($query);

		$option = '<option value="">---select---</option>';
		foreach($result as $row){
			$option .= '<option value="'.$row->DistrictCode.'">'.$row->DistrictName.'</option>';
		}

		echo $option;

	}
	
	public function mstsubcenter($StateCode)
	{
		$query = "select * from mstsubcenter where StateCode = '$StateCode' and LanguageID =1 and IsDeleted = 0";
		$result = $this->Common_Model->query_data($query);

		$option = '<option value="">---select---</option>';
		foreach ($result as $row) {
			$option .='<option value="'.$row->SubCenterCode.'">'.$row->SubCenterName.'</option>';
		}
		echo $option;
	}

	public function getanmsubcenter($SubCenterCode)
	{
		$query = "select * from anmsubcenter where SubCenterCode = $SubCenterCode";
		$result = $this->Common_Model->query_data($query);

		$option = '<option value="">---select---</option>';
		foreach ($result as $row) {
			$option .='<option value="'.$row->ANMID.'">'.$row->ANMName.'</option>';
		}
		echo $option;
	}

	function getBlockLists($DistrictCode)
	{

		$query = "select * from mstblock where DistrictCode = $DistrictCode and LanguageID=1";
		$blocks = $this->Common_Model->query_data($query);

		$option = "<option value=''>---select---</option>";
		foreach ($blocks as $row) {
			$option .= '<option value="'.$row->BlockCode.'">' .$row->BlockName.'</option>';
		}
		echo $option;
	}

	function getPhcLists($BlockID)
	{
		$query = "Select * from mstphc where Block_id = $BlockID and LanguageID=1";
		$phc = $this->Common_Model->query_data($query);

		$option = "<option value=''>---select---</option>";
		foreach ($phc as $row) {
			$option .= '<option value="'.$row->PHC_id.'">' .$row->PHC_Name.'</option>';
		}
		echo $option;
	}

	function getSubcenterList($PHC_id)
	{
		$query = "select * from mstsubcenter where PHC_id = $PHC_id and LanguageID=1";
		$subcenter = $this->Common_Model->query_data($query);

		$option = "<option value=''>--select--</option>";
		foreach ($subcenter as $row) {
			$option .='<option value="'.$row->SubCenterID.'">'.$row->SubCenterName.'</option>';
		}

		echo $option;
	}

	function getSubcenterList_code($PHC_id)
	{
		$query = "select * from mstsubcenter where PHC_id = $PHC_id and LanguageID=1";
		$subcenter = $this->Common_Model->query_data($query);

		$option = "<option value=''>--select--</option>";
		foreach ($subcenter as $row) {
			$option .='<option value="'.$row->SubCenterCode.'">'.$row->SubCenterName.'</option>';
		}

		echo $option;
	}

	function getAnmListViaSubcenter($subcenter = null)
	{

		$query = "select mstsubcenter.SubCenterID, mstsubcenter.SubCenterName,anmsubcenter.ANMName FROM `anmsubcenter` 
		LEFT JOIN mstsubcenter on mstsubcenter.SubCenterCode = anmsubcenter.SubCenterCode and mstsubcenter.LanguageID=1";

		if($subcenter != null)
		{
			$query = "SELECT * FROM `anmsubcenter` where SubCenterCode =".$subcenter;
		}

		$anmsublist = $this->Common_Model->query_data($query);

		$option = "<option value=''>--select--</option>";
		foreach ($anmsublist as $row) {
			$option .='<option value="'.$row->ANMID.'">'.$row->ANMName.'</option>';
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
	
	function getAnmList(){

		$searchPhrase = $this->input->post('searchPhrase');
		$section = $this->input->post('section');
		$sectionId = $this->input->post('sectionId');
		
		//$query = "select * from mstanm where LanguageID=1";
		$query= "select mstanm.ANMUID,mstanm.ANMID,mstanm.ANMCode,mstanm.ANMName,mstsubcenter.SubCenterCode,mstsubcenter.SubCenterName from mstanm,mstsubcenter where mstanm.LanguageID=1 and mstsubcenter.LanguageID=1 and mstsubcenter.SubCenterID=mstanm.ANMID";

		// die($query);
		
		//extraQuery for search dialog
		$extraQuery = " and mstanm.ANMName like '".$searchPhrase."%'
		or mstanm.ANMCode like '".$searchPhrase."%'";
		if($searchPhrase != "") $query .= $extraQuery;
		
		//order by clause
		$sort = $this->input->post('sort');
		$sortBy = array_keys($sort);
		
		switch($sortBy[0]){
			case "ANMID":
			$orderQuery = " order by mstanm.ANMID " . $sort[$sortBy[0]];
			break;
			case "ANMName":
			$orderQuery = " order by mstanm.ANMName " . $sort[$sortBy[0]];
			break;
			case "ANMCode":
			$orderQuery = " order by mstanm.ANMCode " . $sort[$sortBy[0]];
			break;
			default:
			$orderQuery = " order by mstanm.ANMID " . $sort[$sortBy[0]];
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
		
		// $query = "select * from mstsubcenter where LanguageID=1";
		$query = "select  s.SubCenterCode, s.SubCenterName , an.ANMName FROM anmsubcenter anms 
		INNER join mstanm an on an.ANMID = anms.ANMID and an.LanguageID=1
		LEFT join mstsubcenter s on anms.SubCenterCode = s.SubCenterCode       
		WHERE s.LanguageID = 1";
		// die($query);
		
		//extraQuery for search dialog
		$extraQuery = " where SubCenterName like '".$searchPhrase."%'
		or SubCenterCode like '".$searchPhrase."%'";
		if($searchPhrase != "") $query .= $extraQuery;
		
		//order by clause
		$sort = $this->input->post('sort');
		$sortBy = array_keys($sort);
		
		switch($sortBy[0]){
			case "SubCenterName":
			$orderQuery = " order by SubCenterName " . $sort[$sortBy[0]];
			break;
			case "SubCenterCode	":
			$orderQuery = " order by SubCenterCode	 " . $sort[$sortBy[0]];
			break;
			default:
			$orderQuery = " order by SubCenterName   " . $sort[$sortBy[0]];
			break;
		}
		
		$query .= $orderQuery;
		
		//make a query to show total records
		$Subcenter_list = $this->Common_Model->query_data($query);
		$total = count($Subcenter_list);
		
		$current = (int)$this->input->post('current');
		$rowCount = (int)$this->input->post('rowCount');
		
		//limit conditions
		$limitQuery = " limit ".($current - 1)*($rowCount).",".$rowCount;
		$query .= $limitQuery;
		
		// echo $query; die();
		$Subcenter_list = $this->Common_Model->query_data($query);
		
		$counter = 1;
		foreach($Subcenter_list as $opp)
		{
			$opp->sno = $counter;
			$counter++;
		}

		$returnArray = array(
			"current"		=>	$this->input->post('current'),
			"rowCount"	=>	$this->input->post('rowCount'),
			"total"			=>	$total,
			"rows"			=>	$Subcenter_list,
		);
		
		echo json_encode($returnArray);		
	}
	
	
	function getVillageList(){

		$searchPhrase = $this->input->post('searchPhrase');
		$section = $this->input->post('section');
		$sectionId = $this->input->post('sectionId');
		$anmId = $this->input->post('anmId');
		$query = "select * from mstvillage where LanguageID=1";

		$query="SELECT mstvillage.VillageName,mstvillage.VillageCode,mstvillage.VillageID FROM `anmvillage`,mstvillage WHERE  mstvillage.VillageID=anmvillage.VillageID and mstvillage.LanguageID=1";
		if($anmId!="") $query .=" and anmvillage.ANMID=$anmId";
		
		
		//extraQuery for search dialog
		$extraQuery = " and (mstvillage.VillageName like '".$searchPhrase."%'
		or mstvillage.VillageCode like '".$searchPhrase."%')";
		if($searchPhrase != "") $query .= $extraQuery;
		
		//order by clause
		$sort = $this->input->post('sort');
		$sortBy = array_keys($sort);
		
		switch($sortBy[0]){
			case "VillageID":
			$orderQuery = " order by mstvillage.VillageID  " . $sort[$sortBy[0]];
			break;
			case "VillageName":
			$orderQuery = " order by VillageName " . $sort[$sortBy[0]];
			break;
			case "VillageCode":
			$orderQuery = " order by VillageCode " . $sort[$sortBy[0]];
			break;
			default:
			$orderQuery = " order by mstvillage.VillageID " . $sort[$sortBy[0]];
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
			"current"=>	$this->input->post('current'),
			"rowCount"=>$this->input->post('rowCount'),
			"total"	 =>	$total,
			"rows"	=>	$Opportunity_list,
		);
		echo json_encode($returnArray);
	}


	function getAshaLists($ASHACode=NUll)
	{
		$searchPhrase = $this->input->post('searchPhrase');
		$ASHACode = $this->input->post('filterASHACode');
		$month = $this->input->post('filtermonth');

		$query = "select * from mstasha where ASHACode = $ASHACode and LanguageID=1";
		$result = $this->Common_Model->query_data($query);

		$option = '<option value="">--select--</option>';
		foreach ($result as $row) {
			$option .='<option value="'.$row->ASHACode.'">'.$row->ASHAName.'</option>';
		}

		echo $option;

		//extraQuery for search dialog
		$extraQuery = " where ASHAName like '".$searchPhrase."%'
		or ASHACode like '".$searchPhrase."%'
		or ANMCode like '".$searchPhrase."%'";
		if($searchPhrase != "") $query .= $extraQuery;
		
		//order by clause
		$sort = $this->input->post('sort');
		$sortBy = array_keys($sort);
		
		switch($sortBy[0]){
			case "ASHAUID":
			$orderQuery = " order by ASHAUID " . $sort[$sortBy[0]];
			break;
			case "ASHAName":
			$orderQuery = " order by ASHAName " . $sort[$sortBy[0]];
			break;
			case "ASHACode":
			$orderQuery =" order by ASHACode " . $sort[$sortBy[0]];
			break;
			case "ANMCode":
			$orderQuery = " order by ANMCode " . $sort[$sortBy[0]];
			break;
			default:
			$orderQuery = " order by ASHAUID " . $sort[$sortBy[0]];
			break;
		}
		
		$query .= $orderQuery;

//make a query to show total records
		$totalQuery = "select count(*) as total from mstasha";
		$total = $this->db->query($totalQuery)->result()[0]->total;

		//make a query to show total records
		$Anm_List = $this->Common_Model->query_data($query);
		$total = count($Anm_List);
		
		$current = (int)$this->input->post('current');
		$rowCount = (int)$this->input->post('rowCount');

		//limit conditions
		$limitQuery = " limit ".($current - 1)*($rowCount).",".$rowCount;
		$query .= $limitQuery;
		
		// echo $query; die();
		$Anm_List = $this->Common_Model->query_data($query);
		
		$counter = 1;
		foreach($Anm_List as $opp)
		{
			$opp->sno = $counter;
			$counter++;
		}
		
		$returnArray = array(
			"current"		=>	$this->input->post('current'),
			"rowCount"	=>	$this->input->post('rowCount'),
			"total"			=>	$total,
			"rows"			=>	$Anm_List,
		);
		
		echo json_encode($returnArray);		
	}

	function getSubCenterVillage()
	{
		$SubCenterCode = $this->input->post('SubCenterCode');
		$languageID = $this->input->post('languageID');
		$selecte = explode(',',$this->input->post('selected'));
		$sal ='';
		/*	$query="SELECT mstvillage.VillageCode,	mstvillage.VillageID,mstvillage.VillageName,mstsubcenter.SubCenterID FROM `mstvillage`,mstsubcenter on mstsubcenter.SubCenterID=mstvillage.SubCenterID and mstsubcenter.SubCenterCode='$SubCenterCode' and mstvillage.LanguageID=$languageID  group by VillageCode";*/

		$query="select mstvillage.VillageCode,mstvillage.VillageID,mstvillage.VillageName  FROM mstvillage LEFT join anmvillage on mstvillage.VillageID = anmvillage.VillageID  and mstvillage.LanguageID=1 inner join mstanm on mstanm.ANMID=anmvillage.ANMID WHERE mstanm.LanguageID = 1";

		$Village_list = $this->Common_Model->query_data($query);

		$option = '<option value="">--select--</option>';
		foreach($Village_list  as $row)
		{
			if($selecte!='')
			{

				if(in_array($row->VillageID,$selecte))
				{
					$sal = "selected='selected'";
				} 
				else 
				{
					$sal = " ";
				}

			}

			$option .= '<option '.$sal.' value="'.$row->VillageID.'">'.$row->VillageName.'</option>';
		}
		print $option;

	}


	function getSubCenterVillageForSelect2($languageID=1)
	{
		$searchPhrase = $this->input->get('q');
		$query = "select mstvillage.VillageCode,mstvillage.VillageID,mstvillage.VillageName,mstvillage.SubCenterID,mstsubcenter.SubCenterID FROM `mstvillage`,mstsubcenter where mstsubcenter.SubCenterID=mstvillage.SubCenterID and mstsubcenter.SubCenterCode='$SubCenterCode' and mstvillage.LanguageID=$languageID  ";

		$extraQuery = " where mstvillage.VillageName like '".$searchPhrase."%'
		or VillageCode like '".$searchPhrase."%'";

		if($searchPhrase != "") 
			$query .= $extraQuery;

		$query .= 'group by VillageCode';

		$ulbList = $this->Common_Model->query_data($query);
		$totalCount = count($ulbList);

		die(json_encode(["total_count"=>$totalCount, "items"=>$ulbList]));

	}


	function getFamilymemberList(){

		$searchPhrase = $this->input->post('searchPhrase');
		$section = $this->input->post('section');
		$sectionId = $this->input->post('sectionId');

		$query= "select s.FamilyCode,f.FamilyMemberName,f.GenderID,f.MaritialStatusID,f.AprilAgeYear,f.AprilAgeMonth from tblhhfamilymember f INNER JOIN tblhhsurvey s  where s.HHSurveyGUID = f.HHSurveyGUID";

		//extraQuery for search dialog
		$extraQuery = " where f.FamilyMemberName like '".$searchPhrase."%'
		or f.HHFamilyMemberCode like '".$searchPhrase."%'";
		if($searchPhrase != "") $query .= $extraQuery;

		//order by clause
		$sort = $this->input->post('sort');
		$sortBy = array_keys($sort);

		switch($sortBy[0]){
			case "HHFamilyMemberGUID":
			$orderQuery = " order by f.HHFamilyMemberGUID " . $sort[$sortBy[0]];
			break;
			case "FamilyMemberName":
			$orderQuery = " order by f.FamilyMemberName " . $sort[$sortBy[0]];
			break;
			case "HHFamilyMemberCode":
			$orderQuery = " order by f.HHFamilyMemberCode " . $sort[$sortBy[0]];
			break;
			default:
			$orderQuery = " order by f.HHFamilyMemberGUID " . $sort[$sortBy[0]];
			break;
		}

		$query .= $orderQuery;


//make a query to show total records
		$totalQuery = "select count(*) as total from tblhhfamilymember";
		$total = $this->db->query($totalQuery)->result()[0]->total;

		//make a query to show total records
		$Familymembers_list = $this->Common_Model->query_data($query);
		$total = count($Familymembers_list);

		$current = (int)$this->input->post('current');
		$rowCount = (int)$this->input->post('rowCount');

		//limit conditions
		$limitQuery = " limit ".($current - 1)*($rowCount).",".$rowCount;
		$query .= $limitQuery;

		// echo $query; die();
		$Familymembers_list = $this->Common_Model->query_data($query);

		$counter = 1;
		foreach($Familymembers_list as $opp)
		{
			$opp->sno = $counter;
			$counter++;
		}

		$returnArray = array(
			"current"		=>	$this->input->post('current'),
			"rowCount"	=>	$this->input->post('rowCount'),
			"total"			=>	$total,
			"rows"			=>	$Familymembers_list,
		);

		echo json_encode($returnArray);		
	}


	


	function getHouseHoldVerificationList()
	{

		/*print_r($_POST); die();*/

		$searchPhrase = $this->input->post('searchPhrase');
		$ANMCode = $this->input->post('filterANMCode');
		$ASHACode = $this->input->post('filterASHACode');

		$query ="select
		mstsubcenter.SubCenterCode,
		mstsubcenter.SubCenterName,
		mstanm.ANMName,
		mstasha.ASHAName,
		mstvillage.VillageName,
		tblhhsurvey.VillageID,
		tblhhsurvey.FamilyCode,
		tblhhsurvey.ANMID,
		tblhhsurvey.HHSurveyGUID,
		(
			CASE WHEN tblhhsurvey.Verified = NULL THEN '' WHEN tblhhsurvey.Verified = 0 THEN 'No' WHEN tblhhsurvey.Verified = 1 THEN 'Yes' END
		) AS Verified,
		(
			CASE WHEN tblhhsurvey.CasteID = 0 THEN '' WHEN tblhhsurvey.CasteID = 1 THEN 'SC' WHEN tblhhsurvey.CasteID = 2 THEN 'ST' WHEN tblhhsurvey.CasteID = 3 THEN 'OBC' WHEN tblhhsurvey.CasteID = 4 THEN 'Other' WHEN tblhhsurvey.CasteID = 5 THEN 'UR' END
		) AS caste,
		(
			CASE WHEN tblhhsurvey.FinancialStatusID = 0 THEN '' WHEN tblhhsurvey.FinancialStatusID = 1 THEN 'A.P.L.' WHEN tblhhsurvey.FinancialStatusID = 2 THEN 'B.P.L.' END
		) AS FinancialStatusID
		FROM
		tblhhsurvey
		left JOIN
		mstasha ON mstasha.ASHAID = tblhhsurvey.ServiceProviderID and mstasha.LanguageID = 1
		left JOIN
		mstanm ON mstanm.ANMID = tblhhsurvey.ANMID and mstanm.LanguageID = 1
		left JOIN
		mstsubcenter ON mstsubcenter.SubCenterID = tblhhsurvey.SubCenterID and mstsubcenter.LanguageID = 1
		left JOIN
		mstvillage ON mstvillage.VillageID = tblhhsurvey.VillageID and mstvillage.LanguageID = 1
		where tblhhsurvey.HHSurveyGUID is not null and tblhhsurvey.IsDeleted = 0
		";

		// die($query);

		if ($ANMCode != "") {
			$query .= " and mstanm.ANMCode = $ANMCode ";
		}

		if ($ASHACode != "") {
			$query .= " and mstasha.ASHACode = $ASHACode ";
		}
		
		//extraQuery for search dialog
		
		$extraQuery = " and (mstsubcenter.SubCenterName like '".$searchPhrase."%'
		or mstanm.ANMName like '".$searchPhrase."%'
		or mstasha.ASHAName like '".$searchPhrase."%'
		or mstvillage.VillageName like '".$searchPhrase."%'
		or tblhhsurvey.HHSurveyGUID like '".$searchPhrase."%') ";
		if($searchPhrase != "") $query .= $extraQuery;

		//order by clause
		$sort = $this->input->post('sort');
		if ($sort != NULL) 
		{
			$sortBy = array_keys($sort);

			switch($sortBy[0]){
				case "HHSurveyGUID":
				$orderQuery = " order by tblhhsurvey.HHSurveyGUID " . $sort[$sortBy[0]];
				break;
				case "SubCenterName":
				$orderQuery = " order by mstsubcenter.SubCenterName " . $sort[$sortBy[0]];
				break;
				case "ANMName":
				$orderQuery = " order by mstanm.ANMName " . $sort[$sortBy[0]];
				break;
				case "ASHAName":
				$orderQuery = " order by mstasha.ASHAName " . $sort[$sortBy[0]];
				break;
				case "VillageName":
				$orderQuery = " order by mstvillage.VillageName " . $sort[$sortBy[0]];
				break;
				default:
				$orderQuery = " order by tblhhsurvey.HHSurveyGUID " . $sort[$sortBy[0]];
				break;
			}

			$query .= $orderQuery ;

		}
		/*die($query);*/

			//make a query to show total records
		$totalQuery = "select count(*) as total from tblhhsurvey 
		left join mstanm ON mstanm.ANMID = tblhhsurvey.ANMID and mstanm.LanguageID = 1
		left join mstasha ON mstasha.ASHAID = tblhhsurvey.ServiceProviderID and mstasha.LanguageID = 1
		where HHSurveyGUID is not null ";
		
		if ($ANMCode != "") {
			$totalQuery .= " and mstanm.ANMCode = $ANMCode ";
		}

		if ($ASHACode != "") {
			$totalQuery .= " and mstasha.ASHACode = $ASHACode ";
		}
/*
		die($totalQuery);
*/
		$total = $this->db->query($totalQuery)->result()[0]->total;

		$current = (int)$this->input->post('current');
		$rowCount = (int)$this->input->post('rowCount');

			//limit conditions
		$limitQuery = " limit ".($current - 1)*($rowCount).",".$rowCount;
		$query .= $limitQuery;

		// die($query);

		$household_verification_list = $this->Common_Model->query_data($query);

		$returnArray = array(
			"current"		=>	$this->input->post('current'),
			"rowCount"		=>	$this->input->post('rowCount'),
			"total"			=>	$total,
			"rows"			=>	$household_verification_list,
		);

		echo json_encode($returnArray);		
	}


	function getHouseHoldReportList($ANMCode = NULL){

		$searchPhrase = $this->input->post('searchPhrase');

		$query= "select anm.ANMName,anm.ANMCode,anm.ANMCode,anm.ANMID,anm.ANMName, a.no_of_ashas, b.hh_count, c.fm_count, d.hh_verified,  f.population_verified, (f.population_verified / c.fm_count ) * 100 as percent_population_verified, (d.hh_verified / b.hh_count ) * 100 as Score, g.new_household from mstanm anm
		left join (select count(*) as no_of_ashas, ANMCode from mstasha where LanguageID = 1 group by ANMCode) a 
		on anm.ANMCode = a.ANMCode
		left join 
		(select count(*)  as hh_count, anmid from tblhhsurvey group by anmid) b 
		on b.ANMID = anm.ANMID
		left join 
		(select count(*)  as fm_count, tblhhsurvey.ANMID from tblhhfamilymember 
		inner join tblhhsurvey on tblhhfamilymember.HHUID = tblhhsurvey.HHUID
		group by tblhhsurvey.ANMID) c 
		on c.ANMID = anm.ANMID
		left join 
		(select count(*)  as hh_verified, anmid from tblhhsurvey where Verified=1 group by anmid) d 
		on d.ANMID = anm.ANMID
		left join 
		(select count(*) as population_verified, tblhhsurvey.ANMID  from tblhhsurvey 
		inner join tblhhfamilymember 
		on tblhhsurvey.HHUID = tblhhfamilymember.HHUID and tblhhsurvey.Verified = 1
		group by tblhhsurvey.ANMID
	) f
	on f.ANMID = anm.ANMID
	left join 
	(select count(HHUID) as new_household, anmid from tblhhsurvey where tblhhsurvey.CreatedOn > '2016-11-12'
	group by anmid) g 
	on g.anmid = anm.anmid 
	where anm.LanguageID = 1 AND anm.IsDeleted=0";
		//die($query);

		//print_r($query); die();

			//extraQuery for search dialog
	$extraQuery = " and anm.ANMName like '".$searchPhrase."%'";
	if($searchPhrase != "") $query .= $extraQuery;
	
			//order by clause
	$sort = $this->input->post('sort');
	$sortBy = array_keys($sort);

	switch($sortBy[0]){
		
		case "ANMCode":
		$orderQuery = " order by anm.ANMCode " . $sort[$sortBy[0]];
		break;
		
		default:
		$orderQuery = " order by anm.ANMCode " . $sort[$sortBy[0]];
		break;
	}

	$query .= $orderQuery ;

		// die($query);

			//make a query to show total records
	$totalQuery = "select count(*) as total from mstanm where LanguageID=1";
	$total = $this->db->query($totalQuery)->result()[0]->total;

	$current = (int)$this->input->post('current');
	$rowCount = (int)$this->input->post('rowCount');

			//limit conditions
	$limitQuery = " limit ".($current - 1)*($rowCount).",".$rowCount;
	$query .= $limitQuery;

			// echo $query; die();
	$Household_report_list = $this->Common_Model->query_data($query);

	$returnArray = array(
		"current"		=>	$this->input->post('current'),
		"rowCount"		=>	$this->input->post('rowCount'),
		"total"			=>	$total,
		"rows"			=>	$Household_report_list,
	);

	echo json_encode($returnArray);
}

public function getAshaOfAnm($anmid = null)
{
	if($anmid == null || $anmid== "")
	{
		$query = "SELECT
						    *
			FROM
			mstasha a
			INNER JOIN userashamapping b ON
			a.ASHAID = b.AshaID
			INNER JOIN tblusers c ON
			b.UserID = c.user_id
			WHERE
			a.LanguageID = 1 AND a.IsDeleted = 0 AND a.IsActive = 1 AND c.is_deleted = 0 AND c.user_mode = 1";

	}
	else
	{

		$query = "select a.ASHAID, a.ASHAName, c.user_name FROM anmasha m 
		inner join mstasha a 
		on a.ASHAID = m.ASHAID inner join userashamapping b on a.AshaID = b.AshaID inner join tblusers c on b.UserID = c.user_id
		and m.ANMID = $anmid
		where a.LanguageID = 1";
	}

	$html = '<option value="">--select--</option>';
	$result = $this->db->query($query)->result();

	foreach ($result as $row) {
		$html .= '<option value="'.$row->ASHAID.'">'.$row->ASHAName.' ('.$row->user_name.') </option>';
	}

	echo $html;

}

public function getAshaOfAnmDashboard4()
{

	$anm_list = $this->input->post('anm_list');
	$asha_list = $this->input->post('asha_list');



	if (!is_array($anm_list)) {

		$query = "select a.ASHAID, a.ASHAName FROM anmasha m 
		inner join mstasha a 
		on a.ASHAID = m.ASHAID
		where a.LanguageID = 1";

		$asha_list = array();

	}else{

		$query = "select a.ASHAID, a.ASHAName FROM anmasha m 
		inner join mstasha a 
		on a.ASHAID = m.ASHAID
		and m.ANMID in (".implode(",", $anm_list).")
		where a.LanguageID = 1";

	}

	if (!is_array($asha_list)) {
		$asha_list = array();
	}

	$html = '<option value="">--select--</option>';
	$result = $this->db->query($query)->result();

	foreach ($result as $row) {
		$html .= '<option value="'.$row->ASHAID.'" ' . (in_array($row->ASHAID, $asha_list)?"selected":"") . '>'.$row->ASHAName.'</option>';
	}

	echo $html;

}

public function getAshaOfAnmViaAnmCode($anmcode = null)
{
	$query = "select * from mstasha where ANMCode = $anmcode and LanguageID = 1";

	$html = '<option value="">--select--</option>';
	$result = $this->db->query($query)->result();

	foreach ($result as $row) {
		$html .= '<option value="'.$row->ASHACode.'">'.$row->ASHAName.'</option>';
	}

	echo $html;

}


public function getAnmVillageviaAnmCode($anmCode=Null)
{
	$query="Select v.VillageCode,v.VillageName from mstvillage v inner join anmvillage anv on anv.VillageID = v.VillageID and v.LanguageID = 1 inner JOIN mstanm anm on anm.ANMID = anv.ANMID where anm.ANMCode=$anmCode and anm.LanguageID = 1";

	$result = $this->Common_Model->query_data($query);

	$option = '<option value="">--select--</option>';
	foreach ($result as $row) {
		$option .= '<option value="'.$row->VillageCode.'">'.$row->VillageName.'</option>';
	}

	echo $option;
}

function getDataReportList(){

	$searchPhrase = $this->input->post('searchPhrase');

	$query= "select
	asha.ASHAID,
	asha.ASHAName,
	sc.SubCenterName,
	u.user_name,
	b.hh_count AS hh_updated,
	c.pregnancies,
	d.anc_visits,
	f.child_births,
	g.pnc_visits,
	h.tblmstimmunizationans

	FROM
	mstasha asha
	LEFT JOIN 
	userashamapping ua on ua.AshaID = asha.ASHAID and asha.LanguageID= 1
	LEFT JOIN
	tblusers u on u.user_id = ua.UserID
	LEFT JOIN
	mstsubcenter sc on sc.SubCenterCode = asha.SubCenterCode and sc.LanguageID = 1

	LEFT JOIN
	(
		SELECT COUNT(*) AS hh_count,
		tblhhsurvey.ServiceProviderID AS ashaid
		FROM
		tblhhsurvey
		WHERE
		tblhhsurvey.UploadedOn BETWEEN '2017-02-01' AND '2017-02-28'
		GROUP BY
		tblhhsurvey.ServiceProviderID
	) b ON b.ashaid = asha.ashaid
	LEFT JOIN
	(
		SELECT COUNT(*) AS pregnancies,
		pw.AshaID AS ashaid
		FROM
		tblpregnant_woman pw
		WHERE
		pw.PWRegistrationDate BETWEEN '2017-02-01' AND '2017-02-28'
		GROUP BY
		pw.AshaID
	) c ON c.ashaid = asha.ashaid
	LEFT JOIN
	(
		SELECT COUNT(*) AS anc_visits,
		v.ByAshaID AS ashaid
		FROM
		tblancvisit v
		WHERE
		v.CheckupVisitDate BETWEEN '2017-02-01' AND '2017-02-28'
		GROUP BY
		v.ByAshaID
	) d ON d.ashaid = asha.ashaid
	LEFT JOIN
	(
		SELECT COUNT(*) AS child_births,
		c.AshaID AS ashaid
		FROM
		tblchild c
		WHERE
		c.child_dob BETWEEN '2017-02-01' AND '2017-02-28'
		GROUP BY
		c.AshaID
	) f ON f.ashaid = asha.ashaid
	LEFT JOIN
	(
		SELECT COUNT(*) AS pnc_visits,
		p.AshaID AS ashaid
		FROM
		tblpnchomevisit_ans p
		WHERE
		p.UpdatedOn BETWEEN '2017-02-01' AND '2017-02-28'
		GROUP BY
		p.AshaID
	) g ON g.ashaid = asha.ashaid
	LEFT JOIN
	(
		SELECT COUNT(*) AS tblmstimmunizationans,
		i.AshaID AS ashaid
		FROM
		tblmstimmunizationans i
		WHERE
		i.CreatedOn BETWEEN '2017-02-01' AND '2017-02-28'
		GROUP BY
		i.AshaID
	) h ON h.ashaid = asha.ashaid
	WHERE
	asha.LanguageID = 1 and asha.IsDeleted = 0";

         /*
         print_r($query); die();*/

			//extraQuery for search dialog
         $extraQuery = " and asha.ASHAName like '".$searchPhrase."%'";
         if($searchPhrase != "") $query .= $extraQuery;

			//order by clause
         $sort = $this->input->post('sort');
         $sortBy = array_keys($sort);

         switch($sortBy[0]){

         	case "ASHAID":
         	$orderQuery = " order by asha.ASHAID " . $sort[$sortBy[0]];
         	break;

         	default:
         	$orderQuery = " order by asha.ASHAID " . $sort[$sortBy[0]];
         	break;
         }

         $query .= $orderQuery ;

		// die($query);

			//make a query to show total records
         $totalQuery = "select count(*) as total from mstasha where LanguageID=1";
         $total = $this->db->query($totalQuery)->result()[0]->total;

         $current = (int)$this->input->post('current');
         $rowCount = (int)$this->input->post('rowCount');

			//limit conditions
         $limitQuery = " limit ".($current - 1)*($rowCount).",".$rowCount;
         $query .= $limitQuery;

			// echo $query; die();
         $list_data_report = $this->Common_Model->query_data($query);

         $returnArray = array(
         	"current"		=>	$this->input->post('current'),
         	"rowCount"		=>	$this->input->post('rowCount'),
         	"total"			=>	$total,
         	"rows"			=>	$list_data_report,
         );

         echo json_encode($returnArray);
     }

     public function getStates($CountryCode = null)
     {
     	$this->db->where('CountryCode',$CountryCode);
     	$this->db->where('LanguageID',1);
     	$states = $this->db->get('mststate')->result();

     	$states_str = '<option>---select---</option>';
     	foreach ($states as $row) {
     		$states_str .= '<option value="'.$row->StateCode.'">'.$row->StateName.'</option>';
     	}

     	echo $states_str;

     }

     public function getVillagesForSubcenter($subcentercode = null)
     {

     	$query = "SELECT * FROM mstvillage where VillageCode in (select VillageID from mstsubcentervillagemapping where SubCenterID = ".$subcentercode.")";

     	$villages = $this->Common_Model->query_data($query);

     	$villages_str = '<option>---select---</option>';
     	foreach ($villages as $row) {
     		$villages_str .= '<option value="'.$row->VillageCode.'">'.$row->VillageName.'</option>';
     	}

     	echo $villages_str;

     }

     public function getSubcenterFromBlock($block)
     {
     	$query = "select * from mstsubcenter where languageID = 1 and BlockCode = ".$block;
     	$subcenter = $this->Common_Model->query_data($query);

     	$subcenter_str = '<option>---select---</option>';
     	foreach ($subcenter as $row) {
     		$subcenter_str .= '<option value="'.$row->SubCenterCode.'">'.$row->SubCenterName.'</option>';
     	}

     	echo $subcenter_str;
     }
    public function getChsFromBlock($block)
     {
     	$query = "select * from mstcatchmentsupervisor where languageID = 1 and BlockCode = ".$block;
     	$catchmentsupervisor = $this->Common_Model->query_data($query);

     	$catchmentsupervisor_str = '<option>---select---</option>';
     	foreach ($catchmentsupervisor as $row) {
     		$catchmentsupervisor_str .= '<option value="'.$row->CHS_ID.'">'.$row->SupervisorName.'</option>';
     	}

     	echo $catchmentsupervisor_str;
     }

     public function getAshaDetails($ashaid = null)
     {
     	$query = "select * from mstasha where languageID =1 and ashaid = ".$ashaid;
     	$asha_details = "";
     	$asha_details = $this->Common_Model->query_data($query);

     	echo json_encode($asha_details[0]);
     }

     public function getAshaOfAnmWithoutUser($anmid = null)
     {
     	$query = "select a.ASHAID, a.ASHAName FROM anmasha m 
     	inner join mstasha a 
     	on a.ASHAID = m.ASHAID and m.ANMID = ".$anmid."
     	left join userashamapping u 
     	on a.AshaID = u.AshaID		
     	where a.LanguageID = 1 and u.AshaID is null";

     	$html = '<option value="">--select--</option>';
     	$result = $this->db->query($query)->result();

     	foreach ($result as $row) {
     		$html .= '<option value="'.$row->ASHAID.'">'.$row->ASHAName.'</option>';
     	}

     	echo $html;

     }

     public function getAFFromBlock($blockid = null)
     {
     	$sql = "SELECT * FROM `mstcatchmentsupervisor` where languageID = 1 and BlockCode =".$blockid;
     	$res = $this->Common_Model->query_data($sql);

     	$html = '<option value="">--select--</option>';
     	foreach ($res as $row) {
     		$html .= '<option value="'.$row->CHS_ID.'">'.$row->SupervisorName.'</option>';
     	}

     	echo $html;
     }

     public function getVillagesForANM_checkboxes($anmcode = null)
     {

     	$sql = "select ANMID from mstanm where languageid =1 and ANMCode = ".$anmcode;
     	$res = $this->Common_Model->query_data($sql);

     	$sql = "select * from mstvillage where languageID = 1 and VillageID in (SELECT VillageID FROM `anmvillage` where ANMID = ".$res[0]->ANMID.")";
     	$res = $this->Common_Model->query_data($sql);
		// print_r($res); die();

     	$html = '';
     	foreach ($res as $row) {
     		$html .= '<div class="checkbox m-b-15">
     		<label>
     		<input type="checkbox" value="'.$row->VillageID.'" name="villages[]">
     		<i class="input-helper"></i>
     		'.$row->VillageName.'
     		</label>
     		</div>';
     	}
     	echo $html;
     }

     function getAnmListViaSubcenter_anmcode($subcenter = null)
     {

     	$query = "select mstsubcenter.SubCenterID, mstsubcenter.SubCenterName,anmsubcenter.ANMName FROM `anmsubcenter` 
     	LEFT JOIN mstsubcenter on mstsubcenter.SubCenterCode = anmsubcenter.SubCenterCode and mstsubcenter.LanguageID=1";

     	if($subcenter != null)
     	{
     		$query = "SELECT * FROM `anmsubcenter` s inner join mstanm a on s.anmid = a.anmid where a.languageid = 1 and SubCenterCode = ".$subcenter;
     	}

     	$anmsublist = $this->Common_Model->query_data($query);

     	$option = "<option value=''>--select--</option>";
     	foreach ($anmsublist as $row) {
     		$option .='<option value="'.$row->ANMCode.'">'.$row->ANMName.'</option>';
     	}
     	echo $option;
     }



     public function  getanmLists1($StateCode = NULL) {
     	$this->session->set_userdata('StateCode',$StateCode);

     	     	if ($StateCode == NULL || $StateCode == "") {
     	     			$query = "SELECT
     					    a.*, c.user_name, c.user_id
     					FROM
     					    mstanm a
     					LEFT JOIN useranmmapping b ON
     					    a.ANMID = b.ANMID
     					LEFT JOIN tblusers c ON
     					    c.user_id = b.UserID WHERE LanguageID = 1 AND IsDeleted = 0 and c.user_mode = 1 AND c.is_deleted = 0";
     	     	}else {

     	$query = "SELECT
				    a.*, c.user_name, c.user_id
				FROM
				    mstanm a
				LEFT JOIN useranmmapping b ON
				    a.ANMID = b.ANMID
				LEFT JOIN tblusers c ON
				    c.user_id = b.UserID WHERE StateCode = '".$StateCode."' AND LanguageID = 1 AND IsDeleted = 0 and c.user_mode = 1 AND c.is_deleted = 0";
				}
     	$result = $this->Common_Model->query_data($query);
     	$html = '<option value="">---select---</option>';
     	foreach($result as $row){
     		$html .= '<option value="'.$row->ANMID.'">'.$row->ANMName.' ('.$row->user_name.')</option>';
     	}
     	echo $html;
     

     	
     }

     public function  getashaLists2($ANMID = NULL)
      {
     	$this->session->set_userdata('ANMID',$ANMID);
     		if ($ANMID == NULL || $ANMID == "") {
     		$query = "SELECT
						    *
			FROM
			mstasha a
			INNER JOIN userashamapping b ON
			a.ASHAID = b.AshaID
			INNER JOIN tblusers c ON
			b.UserID = c.user_id
			WHERE
			a.LanguageID = 1 AND a.IsDeleted = 0 AND a.IsActive = 1 AND c.is_deleted = 0 AND c.user_mode = 1";
     	}else {
     	$query = "SELECT b.*, d.user_id, d.user_name
					FROM mstanm a INNER JOIN mstasha b ON
					    a.ANMCode = b.ANMCode 
					    LEFT JOIN userashamapping c 
					    on b.ASHAID = c.AshaID
					    LEFT JOIN tblusers d 
					    on c.UserID = d.user_id where a.ANMID= '".$ANMID."' AND a.LanguageID=1 and b.LanguageID = 1 and a.IsDeleted=0 AND d.is_deleted = 0";
					}
					    // die($query);
     	$result = $this->Common_Model->query_data($query);
     	$option = '<option value="">---select---</option>';
     	foreach($result as $row){
     		$option .= '<option value="'.$row->ASHAID.'">'.$row->ASHAName.' ('.$row->user_name.')</option>';
     	}
     	echo $option;

     
     }



     public function  getvillageLists1($ASHAID = NULL) 
     {
     	$this->session->set_userdata('ASHAID',$ASHAID);

     	if ($ASHAID == NULL || $ASHAID == "") {
     		$query = "select
     	a.VillageCode, a.VillageName
     	FROM
     	mstvillage a
     	INNER JOIN ashavillage c ON
     	c.VillageID = a.VillageID
     	INNER JOIN mstasha b ON
     	b.ASHAID = c.ASHAID
     	WHERE
     	a.LanguageID = 1 AND b.LanguageID = 1 AND b.IsDeleted = 0
     	";
     	} else {

     	$query = "select
     	a.VillageCode, a.VillageName
     	FROM
     	mstvillage a
     	INNER JOIN ashavillage c ON
     	c.VillageID = a.VillageID
     	INNER JOIN mstasha b ON
     	b.ASHAID = c.ASHAID
     	WHERE
     	b.ASHAID = '".$ASHAID."' AND a.LanguageID = 1 AND b.LanguageID = 1 AND b.IsDeleted = 0
     	GROUP BY
     	a.VillageName";
     }

     	$result = $this->Common_Model->query_data($query);
     	$option = '<option value="">---select---</option>';
     	foreach($result as $row){
     		$option .= '<option value="'.$row->VillageCode.'">'.$row->VillageName.'</option>';
     	}
     	echo $option;

     	
     }






 }