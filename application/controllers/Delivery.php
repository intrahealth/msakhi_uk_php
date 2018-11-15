<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Delivery extends Auth_controller {

	public function __construct()
	{
		parent::__construct();
		$this->loginData = $this->session->userdata('loginData');
	}

	public function index($ANMCode="NULL", $AshaCode= "NULL",$StateCode="NULL")
	{

	// start permission code
		$user_role = $this->loginData->user_role;
		$query = "SELECT * FROM role_permissions as rp LEFT JOIN mstrole as mst on rp.RoleID=mst.RoleID WHERE rp.RoleID='$user_role' ";
		$content['role_permission'] = $this->Common_Model->query_data($query);
    // End permission code


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

			$query = "select * FROM
			mstanm a
			INNER JOIN mstasha b ON
			a.ANMCode = b.ANMCode
			INNER JOIN userashamapping c ON
			c.AshaID = a.ANMUID
			INNER JOIN tblusers d ON
			c.UserID = d.user_id
			WHERE
			d.state_code = '".$StateCode."' AND a.LanguageID = 1 AND a.IsDeleted = 0
			GROUP BY
			a.ANMName";

			$content['Anm_list'] = $this->Common_Model->query_data($query);

			$query = "select *
			FROM
			mstanm a
			INNER JOIN mstasha b ON
			a.ANMCode = b.ANMCode
			INNER JOIN userashamapping c ON
			c.AshaID = a.ANMUID
			INNER JOIN tblusers d ON
			c.UserID = d.user_id
			WHERE
			a.ANMCode = '".$ANMCode."' AND b.LanguageID = 1 AND b.IsDeleted = 0
			GROUP BY
			b.ASHAName";

			$content['Asha_list'] = $this->Common_Model->query_data($query);


		}else{
			$content['Anm_list'] = array();
			$content['Asha_list'] = array();
		}


		$content['subview'] = "list_delivery";
		$this->load->view('auth/main_layout', $content);
	}

	public function view_child($pwGUID = NULL)
	{

		// start permission

		$user_role = $this->loginData->user_role;
		$query = "SELECT * FROM role_permissions as rp LEFT JOIN mstrole as mst on rp.RoleID=mst.RoleID WHERE rp.RoleID='$user_role' ";

		$content['role_permission'] = $this->Common_Model->query_data($query);

		$query = "select
		a.*,
		b.*,
		( CASE when b.IsDeleted = 0 THEN 'No' when b.IsDeleted = 1 THEN 'Yes' END) AS IsDeleted
		FROM
		tblpregnant_woman a
		INNER JOIN tblchild b ON
		a.HHGUID = b.HHGUID
		WHERE
		a.pwGUID = ?";

        // print_r($query); die();

		$content['PW_list'] = $this->db->query($query,[$pwGUID])->result();

		$content['subview']="child_details";
		$this->load->view('auth/main_layout', $content);

	}

	public function delete($pwGUID = NULL)
	{
		//delete from tblpregnent_women.........
		$query = "update tblpregnant_woman set UpdatedOn='". date('Y-m-d h:i:s')."', IsPregnant = 1  where pwGUID = '$pwGUID'";
		$this->db->query($query);

		//delete from tbl child............
		$query = "update tblchild set modified_on='". date('Y-m-d h:i:s')."', IsDeleted = 1 where pw_GUID =  '$pwGUID'";

		$this->db->query($query);

     	//detlete fromtblimmunization................
		$query = "update  tblmstimmunizationans c INNER JOIN tblchild b on b.childGUID=c.ChildGUID set UpdatedOn='". date('Y-m-d h:i:s')."', c.IsDeleted=1   where  b.pw_GUID= '$pwGUID' ";

		$this->db->query($query);

		$this->session->set_flashdata('tr_msg' ,"PNC Data Deleted Successfully");
		redirect('delivery');
	}


	public function view_delivery_detail($pwGUID = null)
	{

		// start permission

		$user_role = $this->loginData->user_role;
		$query = "SELECT * FROM role_permissions as rp LEFT JOIN mstrole as mst on rp.RoleID=mst.RoleID WHERE rp.RoleID='$user_role' ";

		$content['role_permission'] = $this->Common_Model->query_data($query);


		$RequestMethod= $this->input->server("REQUEST_METHOD");
		if ($RequestMethod == "POST") {

			$this->db->trans_start();

			$updateArr = array(
				'PWName'     		 		=>	$this->input->post('PWName'),
				'HusbandName'			=>	$this->input->post('HusbandName'),
				'LMPDate'				=>	$this->input->post('LMPDate'),
				'PWRegistrationDate'	=>	$this->input->post('PWRegistrationDate'),
				'MobileNo'				=>	$this->input->post('MobileNo'),
				"UpdatedOn"            =>	date('Y-m-d h:i:s'),
			);


			$this->db->where('HHFamilyMemberGUID' , $HHFamilyMemberGUID);
			$this->db->update('tblpregnant_woman', $updateArr);

			$this->db->trans_complete();

			$this->session->set_flashdata('tr_msg', 'Successfully Updated Records');


			if ($this->db->trans_status() === FALSE){
				$this->session->set_flashdata('tr_msg', 'Error Updating Records');					
			}else{
				$this->session->set_flashdata('tr_msg', 'Successfully Updated Records');			
			}

			redirect('delivery');
		}

		$query = "select
		a.*,
		b.*,
		( CASE when b.IsDeleted = 0 THEN 'No' when b.IsDeleted = 1 THEN 'Yes' END) AS IsDeleted
		FROM
		tblpregnant_woman a
		INNER JOIN tblchild b ON
		a.HHGUID = b.HHGUID
		WHERE
		a.pwGUID = ?";

		$content['PW_Detail'] = $this->db->query($query,[$pwGUID])->result();

		$content['subview']="delivery_details";
		$this->load->view('auth/main_layout', $content);
	}

	public function getDeliveryList()
	{
		$searchPhrase = $this->input->post('searchPhrase');
		$StateCode = $this->input->post('StateCode');
		$ANMCode = $this->input->post('ANMCode');
		$ASHACode = $this->input->post('ASHACode');
		$VillageCode = $this->input->post('VillageCode');
		$Verified = $this->input->post('Verified');
		$IsDeleted = $this->input->post('IsDeleted');

		$query ="select * FROM
		(
			SELECT
			a.IsPregnant,
			a.PWName,
			b.FamilyMemberName,
			c.HHCode,
			c.HHSurveyGUID,
			a.pwGUID,
			a.LMPDate,
			a.DeliveryDateTime,
			a.ANMID,
			a.AshaID,
			c.VillageID,
			a.HHGUID,
			c.SubCenterID,
			a.IsDeleted,
			( CASE when a.DeliveryType = 1 Then 'Livebirth' when a.DeliveryType = 2 THEN 'StillBirth' when a.DeliveryType = 3 THEN 'NeonatalDeath' END) AS DeliveryType
			FROM
			tblpregnant_woman a
			INNER JOIN tblhhfamilymember b ON
			a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
			INNER JOIN tblhhsurvey c ON
			b.hhsurveyGUID = c.hhsurveyGUID
			where a.IsPregnant = 0 			
			and 
			a.DeliveryDateTime >= date_add(date_format(now(),'%Y-%m-%d'), INTERVAL -1 YEAR) and a.DeliveryDateTime < date_format(now(),'%Y-%m-%d')
		) a
		LEFT JOIN(
			SELECT 
			HHSurveyGUID,
			FamilyMemberName
			FROM
			tblhhfamilymember as HeadName
			WHERE
			RelationID = 1
			GROUP BY
			hhsurveyGUID
		) b
		ON
		a.hhsurveyGUID = b.hhsurveyGUID

		LEFT JOIN(
			SELECT
			ASHAName,
			ASHAID,
			ASHACode
			FROM
			mstasha
			WHERE
			LanguageID = 1
		) c
		ON
		a.ASHAID = c.ASHAID
		LEFT JOIN(
			SELECT
			ANMName,
			ANMID,
			ANMCode
			FROM
			mstanm
			WHERE
			LanguageID = 1
		) d
		ON
		a.ANMID = d.ANMID
		LEFT JOIN(
			SELECT
			VillageName,
			VillageID,
			VillageCode
			FROM
			mstvillage
			WHERE
			LanguageID = 1
		) e
		ON
		e.VillageID = a.VillageID
		LEFT JOIN(
			SELECT
			SubCenterName,
			SubCenterCode,
			SubCenterID
			FROM
			mstsubcenter
			WHERE
			LanguageID = 1
		) f
		ON
		f.SubCenterID = a.SubCenterID
		Where a.pwGUID is NOT NULL
		";



     		//die($query);
     		// if ($StateCode != "") {
     		// 	$query .= " and mststate.StateCode=$StateCode";
     		// }

		if ($ANMCode != "") {
			$query .= " and d.ANMCode = $ANMCode ";
		}

		if ($ASHACode != "") {
			$query .= " and c.ASHACode = $ASHACode ";
		}


		if ($VillageCode != "") {
			$query .= " and e.VillageCode = $VillageCode ";
		}

		if ($IsDeleted == 1) {
			$query .= " and a.IsDeleted = 1 ";
		}else if($IsDeleted == 2) {
			$query .= " and a.IsDeleted = 0 ";
		}

     		//extraQuery for search dialog

		$extraQuery = "and (mstsubcenter.SubCenterName like '".$searchPhrase."%'
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
				case "SubCenterName":
				$orderQuery = " order by f.SubCenterName " . $sort[$sortBy[0]];
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
				case "IsDeleted":
				$orderQuery = " order by a.IsDeleted " . $sort[$sortBy[0]];
				break;
				default:
				$orderQuery = " order by c.HHSurveyGUID " . $sort[$sortBy[0]];
				break;
				default:
				$orderQuery = " order by a.PWName " . $sort[$sortBy[0]];
				break;
				default:
				$orderQuery = " order by b.FamilyMemberName " . $sort[$sortBy[0]];
				break;
				default:
				$orderQuery = " order by c.HHCode " . $sort[$sortBy[0]];
				break;
				default:
				$orderQuery = " order by a.DeliveryDateTime " . $sort[$sortBy[0]];
				break;
			}

			$query .= $orderQuery ;

		}
		$tmp = $this->db->query($query);
		$total = $tmp->num_rows();

		$current = (int)$this->input->post('current');
		$rowCount = (int)$this->input->post('rowCount');

     			//limit conditions
		$limitQuery = " limit ".($current - 1)*($rowCount).",".$rowCount;
		$query .= $limitQuery;

     		 //die($limitQuery);

		$Mnch_list = $this->Common_Model->query_data($query);

		$returnArray = array(
			"current"		=>	$this->input->post('current'),
			"rowCount"		=>	$this->input->post('rowCount'),
			"total"			=>	$total,
			"rows"			=>	$Mnch_list,
		);

		echo json_encode($returnArray);	

	}

}