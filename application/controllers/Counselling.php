<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Counselling extends Auth_controller {

	public function __construct()
	{
		parent::__construct();
		$this->loginData = $this->session->userdata('loginData');
	}
	
	function index($childGUID = NULL,$ANMCode="NULL", $AshaCode= "NULL",$StateCode="NULL")
	{	
		// start permission 

		$user_role = $this->loginData->user_role;
		$query = "SELECT * FROM role_permissions as rp LEFT JOIN mstrole as mst on rp.RoleID=mst.RoleID WHERE rp.RoleID='$user_role' ";

		$content['role_permission'] = $this->Common_Model->query_data($query);


		$query = "select * from mststate where IsDeleted=0 and LanguageID = 1 ";
		if ($this->loginData->user_role == 1 || $this->loginData->user_role == 2 || $this->loginData->user_role == 3 || $this->loginData->user_role == 6) 	 {
			$query .= "	and StateCode='".$this->loginData->state_code."' ";

		// add district based filter if district role

			if ($this->loginData->user_role == 7) {
				$query .= " and district_code ='".$this->loginData->district_code."' ";
			}
		// add district based filter if block role

			if ($this->loginData->user_role == 8) {
				$query .= " and block_code ='".$this->loginData->block_code."' ";
			}
		}

		$content['State_List'] = $this->Common_Model->query_data($query);


		$query = "select * from tblchild a inner join tblpregnant_woman b WHERE a.pw_GUID = b.PWGUID and a.IsDeleted = 0";
		$content['List_Counselling'] = $this->Common_Model->query_data($query);


		$RequestMethod = $this->input->server('REQUEST_METHOD');
		if($RequestMethod == "POST")
		{  
			$query = "SELECT * from mstanm a INNER JOIN mstasha b on a.ANMCode=b.ANMCode inner join userashamapping c on c.AshaID=a.ANMUID inner join tblusers d on c.UserID=d.user_id where d.state_code= '".$StateCode."' AND a.LanguageID=1 and a.IsDeleted=0 GROUP by a.ANMName";

			$content['Anm_list'] = $this->Common_Model->query_data($query);

			$query = "SELECT * from mstanm a INNER JOIN mstasha b on a.ANMCode=b.ANMCode inner join userashamapping c on c.AshaID=a.ANMUID inner join tblusers d on c.UserID=d.user_id where a.ANMCode= '".$ANMCode."' AND b.LanguageID=1 and b.IsDeleted=0 GROUP by b.ASHAName";

			$content['Asha_list'] = $this->Common_Model->query_data($query);


		}else{
			$content['Anm_list'] = array();
			$content['Asha_list'] = array();
		}


		$content['subview'] = "list_counselling_data";
		$this->load->view('auth/main_layout', $content);
	}

	function edit_immunization_counselling($childGUID = NULL)
	{
		// start permission

		$user_role = $this->loginData->user_role;
		$query = "SELECT * FROM role_permissions as rp LEFT JOIN mstrole as mst on rp.RoleID=mst.RoleID WHERE rp.RoleID='$user_role' ";

		$content['role_permission'] = $this->Common_Model->query_data($query);

		$RequestMethod= $this->input->server("REQUEST_METHOD");
		if ($RequestMethod == "POST") {

			$this->db->trans_start();

			$updateArr = array(
				'bcg'     		 		=>	$this->input->post('bcg'),
				'hepb1'					=>	$this->input->post('hepb1'),
				'opv1'				    =>	$this->input->post('opv1'),
				'opv2'					=>	$this->input->post('opv2'),
				'opv3'					=>	$this->input->post('opv3'),
				'dpt1'					=>	$this->input->post('dpt1'),
				'dpt2'					=>	$this->input->post('dpt2'),
				'dpt3'					=>	$this->input->post('dpt3'),				
				'hepb2'					=>	$this->input->post('hepb2'),
				'hepb3'					=>	$this->input->post('hepb3'),
				'Pentavalent1'			=>	$this->input->post('Pentavalent1'),
				'Pentavalent2'			=>	$this->input->post('Pentavalent2'),
				'Pentavalent3'			=>	$this->input->post('Pentavalent3'),
				'IPV'					=>	$this->input->post('IPV'),
				'measeals'				=>	$this->input->post('measeals'),
				'vitaminA'            	=> $this->input->post('vitaminA'),
				'JEVaccine1'           	=> $this->input->post('JEVaccine1'),
				'OPVBooster'			=>	$this->input->post('OPVBooster'),
				'DPTBooster'			=>	$this->input->post('DPTBooster'),
				'MeaslesTwoDose'		=>	$this->input->post('MeaslesTwoDose'),	
				"modified_on"            =>	date('Y-m-d h:i:s'),
			);


			$this->db->where('childGUID' , $childGUID);
			$this->db->update('tblchild', $updateArr);

			$this->db->trans_complete();

			$this->session->set_flashdata('tr_msg', 'Successfully Updated Records');


			if ($this->db->trans_status() === FALSE){
				$this->session->set_flashdata('tr_msg', 'Error Updating Records');					
			}else{
				$this->session->set_flashdata('tr_msg', 'Successfully Updated Records');			
			}

			redirect('counselling');
		}

		$query = "select * from (select * from tblchild where childGUID = ?)a
		left join (select * from tblpregnant_woman)b on b.PWGUID = a.motherGUID
		left join (select * from mstasha)c on c.ASHAID = a.AshaID and c.LanguageID = 1
		left join (select * from mstanm)d on d.ANMID = a.ANMID and d.LanguageID = 1";


		$content['child_detail'] = $this->db->query($query,[$childGUID])->result();


		$content['subview']="edit_counselling";
		$this->load->view('auth/main_layout', $content);
	}


	function getCounsellingList()
	{

		// print_r($_POST); die();

		$searchPhrase = $this->input->post('searchPhrase');
		$StateCode = $this->input->post('StateCode');
		$ANMCode = $this->input->post('ANMCode');
		$ASHACode = $this->input->post('ASHACode');
		$VillageCode = $this->input->post('VillageCode');
		$IsDeleted = $this->input->post('IsDeleted');



		$query ="select 
		tblchild.child_name,
		tblchild.child_dob,
		tblchild.childGUID,
		tblpregnant_woman.PWName,
		mstanm.ANMName,
		mstasha.ASHAName,
		mstvillage.VillageName,
		( CASE when tblchild.IsDeleted = NULL THEN '' WHEN tblchild.IsDeleted = 0 THEN 'No' when tblchild.IsDeleted = 1 THEN 'Yes' END
	) AS IsDeleted
	FROM
	tblchild
	left JOIN
	tblpregnant_woman on tblpregnant_woman.PWGUID = tblchild.motherGUID
	left JOIN
	mstasha ON mstasha.ASHAID = tblchild.AshaID and mstasha.LanguageID = 1
	left JOIN
	mstanm ON mstanm.ANMID = tblchild.ANMID and mstanm.LanguageID = 1
	where tblchild.childGUID is not null 
	";

	if ($ANMCode != "") {
		$query .= " and mstanm.ANMCode = $ANMCode ";
	}

	if ($ASHACode != "") {
		$query .= " and mstasha.ASHACode = $ASHACode ";
	}


	if ($VillageCode != "") {
		$query .= " and mstvillage.VillageCode = $VillageCode ";
	}

	if ($IsDeleted == 1) {
		$query .= " and tblchild.IsDeleted = 1 ";
	}else if($IsDeleted == 2) {
		$query .= " and tblchild.IsDeleted = 0 ";
	}

		//extraQuery for search dialog

	$extraQuery = "and (tblchild.child_name like '".$searchPhrase."%'
	or mstanm.ANMName like '".$searchPhrase."%'
	or mstasha.ASHAName like '".$searchPhrase."%'
	or mstvillage.VillageName like '".$searchPhrase."%'
	or tblchild.childGUID like '".$searchPhrase."%') ";
	if($searchPhrase != "") $query .= $extraQuery;

		//order by clause
	$sort = $this->input->post('sort');
	if ($sort != NULL) 
	{
		$sortBy = array_keys($sort);

		switch($sortBy[0]){
			case "childGUID":
			$orderQuery = " order by tblchild.childGUID " . $sort[$sortBy[0]];
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
			$orderQuery = " order by tblchild.childGUID " . $sort[$sortBy[0]];
			break;
		}

		$query .= $orderQuery ;

	}

			//make a query to show total records
		$tmp = $this->db->query($query);
		$total = $tmp->num_rows();

		$current = (int)$this->input->post('current');
		$rowCount = (int)$this->input->post('rowCount');

			//limit conditions
		$limitQuery = " limit ".($current - 1)*($rowCount).",".$rowCount;
		$query .= $limitQuery;

		 //die($limitQuery);

		$Child_list = $this->Common_Model->query_data($query);

		$returnArray = array(
			"current"		=>	$this->input->post('current'),
			"rowCount"		=>	$this->input->post('rowCount'),
			"total"			=>	$total,
			"rows"			=>	$Child_list,
		);

		echo json_encode($returnArray);		
	}
} 
