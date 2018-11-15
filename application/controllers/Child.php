<?php
// defined('BASEPATH') OR exit('No direct script access allowed');
class Child extends Auth_controller {

	public function __construct()
	{
		parent::__construct();
		$this->loginData = $this->session->userdata('loginData');
	}

	public function index($id = NULL,$StateCode = NULL,$ANMCode = NULL,$VillageCode = NULL)
	{

		$user_role = $this->loginData->user_role;
		$query = "SELECT * FROM role_permissions as rp LEFT JOIN mstrole as mst on rp.RoleID=mst.RoleID WHERE rp.RoleID='$user_role' ";

		$content['role_permission'] = $this->Common_Model->query_data($query);

		//end permission 

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


		$RequestMethod = $this->input->server('REQUEST_METHOD');
		if($RequestMethod == "POST")
		{

			$query = "SELECT * from mstanm a INNER JOIN mstasha b on a.ANMCode=b.ANMCode inner join userashamapping c on c.AshaID=a.ANMUID inner join tblusers d on c.UserID=d.user_id where d.state_code= '".$StateCode."' AND a.LanguageID=1 and a.IsDeleted=0 GROUP by a.ANMName";

			$content['Anm_list'] = $this->Common_Model->query_data($query);

			$query = "SELECT * from mstanm a INNER JOIN mstasha b on a.ANMCode=b.ANMCode inner join userashamapping c on c.AshaID=a.ANMUID inner join tblusers d on c.UserID=d.user_id where a.ANMCode= '".$ANMCode."' AND b.LanguageID=1 and b.IsDeleted=0 GROUP by b.ASHAName";

			$content['Asha_list'] = $this->Common_Model->query_data($query);


		}else{
			$query = "SELECT  *
			FROM
			mstanm a
			INNER JOIN useranmmapping b ON
			a.ANMID = b.ANMID
			INNER JOIN tblusers c ON
			b.UserID = c.user_id
			WHERE
			a.IsDeleted = 0 AND a.IsActive = 1 AND c.is_deleted = 0 AND a.LanguageID = 1 AND c.user_mode = 1";

			$content['Anm_list'] = $this->Common_Model->query_data($query);

						// $content['Anm_list'] = array();

			$query = "SELECT   *
			FROM
			mstasha a
			INNER JOIN userashamapping b ON
			a.ASHAID = b.AshaID
			INNER JOIN tblusers c ON
			b.UserID = c.user_id
			WHERE
			a.LanguageID = 1 AND a.IsDeleted = 0 AND a.IsActive = 1 AND c.is_deleted = 0 AND c.user_mode = 1";

			$content['Asha_list'] = $this->Common_Model->query_data($query);
						// $content['Asha_list'] = array();


			$query = "SELECT * FROM mstvillage WHERE LanguageID = 1 and IsDeleted = 0";
			$content['Village_list'] = $this->Common_Model->query_data($query);
		}

		$content['subview'] = "Child";
		$this->load->view('auth/main_layout', $content);
	}



	public function getChildList()
	{

		$searchPhrase = $this->input->post('searchPhrase');
		$StateCode = $this->input->post('StateCode');
		$ANMID = $this->input->post('ANMID');
		$ASHAID = $this->input->post('ASHAID');
		$VillageCode = $this->input->post('VillageCode');
		$IsDeleted = $this->input->post('IsDeleted');

		$query ="
		select
		a.*,
		b.FamilyMemberName AS MotherName,
		c.AshaName,
		d.ANMName,
		e.VillageName,
		d.ANMCode,
		e.VillageCode,
		c.ASHACode

		FROM
		(
			SELECT
			a.childGUID,
			a.child_dob,
			a.child_name,
			a.motherGUID,
			c.HHCode,
			c.ServiceProviderID,
			a.ANMID,
			a.AshaID,
			c.VillageID,
			c.StateCode,
			a.IsDeleted,
			( CASE when a.Gender = 1 Then 'Female' when a.Gender = 2 THEN 'Male' END) as Gender

			FROM
			tblchild a
			INNER JOIN tblhhsurvey c ON
			a.HHGUID = c.HHSurveyGUID
			WHERE
			c.IsDeleted = 0 AND c.IsActive = 1 AND a.created_by IN(
				SELECT
				user_id
				FROM
				tblusers
				WHERE
				user_mode = 1
			)
		) a
		LEFT JOIN tblhhfamilymember b ON
		a.motherGUID = b.HHFamilyMemberGUID
		LEFT JOIN mstasha c ON
		a.ServiceProviderID = c.ASHAID AND c.languageID = 1
		LEFT JOIN mstanm d ON
		a.ANMID = d.ANMID AND d.LanguageID = 1
		LEFT JOIN mstvillage e ON
		a.villageID = e.VillageID AND e.LanguageID = 1 
		WHERE a.childGUID IS NOT NULL";

			// print_r($query);die();

 //    if ($StateCode != "") {
	// 	$query .= " and a.StateCode = $StateCode ";
	// }

		if ($ANMID != "") {
			$query .= " and a.ANMID = $ANMID ";
		}

		if ($ASHAID != "") {
			$query .= " and a.AshaID = $ASHAID ";
		}


		if ($VillageCode != "") {
			$query .= " and e.VillageCode = $VillageCode ";
		}


		if ($IsDeleted == 1) {
			$query .= " and a.IsDeleted = 1 ";
		}else if($IsDeleted == 2) {
			$query .= " and a.IsDeleted = 0 ";
		}

		// print_r($query); die();
		//extraQuery for search dialog

		$extraQuery = " and (d.ANMName like '".$searchPhrase."%'
		or c.ASHAName like '".$searchPhrase."%'
		or a.child_name like '".$searchPhrase."%'
		or a.child_dob like '".$searchPhrase."%'
		or a.HHCode like '".$searchPhrase."%'
		or e.VillageName like '".$searchPhrase."%')";
		if($searchPhrase != "") $query .= $extraQuery;

		if($searchPhrase != "") $query .= $extraQuery;

		//order by clause
		$sort = $this->input->post('sort');
		if ($sort != NULL) 
		{
			$sortBy = array_keys($sort);

			switch($sortBy[0]){
				case "childGUID":
				$orderQuery = " order by a.childGUID " . $sort[$sortBy[0]];
				break;
				case "ANMName":
				$orderQuery = " order by d.ANMName " . $sort[$sortBy[0]];
				break;
				case "ASHAName":
				$orderQuery = " order by c.ASHAName " . $sort[$sortBy[0]];
				break;
				case "VillageName":
				$orderQuery = " order by e.VillageName " . $sort[$sortBy[0]];
				break;
				default:
				$orderQuery = " order by a.childGUID " . $sort[$sortBy[0]];
				break;
			}

			$query .= $orderQuery ;

		}
		//die($query);

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

	public function edit_child($childGUID)
	{

		// start permission

		$user_role = $this->loginData->user_role;
		$query = "SELECT * FROM role_permissions as rp LEFT JOIN mstrole as mst on rp.RoleID=mst.RoleID WHERE rp.RoleID='$user_role' ";

		$content['role_permission'] = $this->Common_Model->query_data($query);



		$RequestMethod= $this->input->server("REQUEST_METHOD");
		if ($RequestMethod == "POST") {

			$this->db->trans_start();

			$updateArr = array(
				'child_name'     		=>	$this->input->post('child_name'),
				'Date_Of_Registration'			=>	$this->input->post('Date_Of_Registration'),
				'child_dob'				=>	$this->input->post('child_dob'),
				'birth_time'	=>	$this->input->post('birth_time'),
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
			redirect('child');
		}


		// $query = "select * from (select * from tblchild where childGUID = ?)a 
		// left join(select * from tblpregnant_woman)b on a.HHFamilyMemberGUID = b.HHFamilyMemberGUID";

		$query = "select * from tblchild
		where childGUID = ?";

		$content['child_detail'] = $this->db->query($query,[$childGUID])->result();

		$content['subview']="edit_child_detail";
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

			redirect('child');
		}

		$query = "select * from (select * from tblchild where childGUID = ?)a
		left join (select * from tblpregnant_woman)b on b.PWGUID = a.motherGUID
		left join (select * from mstasha)c on c.ASHAID = a.AshaID and c.LanguageID = 1
		left join (select * from mstanm)d on d.ANMID = a.ANMID and d.LanguageID = 1";


		$content['child_immunization_detail'] = $this->db->query($query,[$childGUID])->result();


		$content['subview']="edit_immunization";
		$this->load->view('auth/main_layout', $content);
	}


	public function delete($childGUID = NULL)
	{
		$query = "update tblchild set IsDeleted = 1 where childGUID =  '$childGUID'";
		$this->db->query($query);

		$query = "update tblpnchomevisit_ans set IsDeleted = 1 where childGUID = '$childGUID'";
		$this->db->query($query);

		$query = "update tblmstimmunizationans set IsDeleted = 1 where childGUID = '$tblmstimmunizationans'";
		$this->db->query($query);


		$this->session->set_flashdata('tr_msg' ,"Child and PNC Visits Deleted Successfully");
		redirect('child');
	}



}