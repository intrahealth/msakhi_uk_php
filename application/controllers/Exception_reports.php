<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Exception_reports extends Auth_controller {
	public function __construct(){
		parent::__construct();
		$this->loginData = $this->session->userdata('loginData');
	}
	function index()
	{

		$user_role = $this->loginData->user_role;
		$query = "SELECT * FROM role_permissions as rp LEFT JOIN mstrole as mst on rp.RoleID=mst.RoleID WHERE rp.RoleID='$user_role' ";

		
		$content['role_permission'] = $this->Common_Model->query_data($query);
		$content['subview'] = "exception_reports_view";
		$this->load->view('auth/main_layout', $content);
	}

	public function pregnant_women_more_than_10_months_lmp($export_command = NULL)
	{
		// start permission 
		$user_role = $this->loginData->user_role;
		$query = "SELECT * FROM role_permissions as rp LEFT JOIN mstrole as mst on rp.RoleID=mst.RoleID WHERE rp.RoleID='$user_role' ";
		$content['role_permission'] = $this->Common_Model->query_data($query);
		// end permission 
		
		$query = "select a.PWName, a.LMPDate, a.IsPregnant, b.user_name, d.ASHAName, f.ANMName, h.HHCode, i.VillageName  from tblpregnant_woman a
		left join tblusers b 
		on a.CreatedBy = b.user_id
		left join userashamapping c 
		on b.user_id = c.UserID
		left join mstasha d 
		on c.AshaID = d.ASHAID and d.LanguageID = 2
		left join anmasha e 
		on d.ASHAID = e.ASHAID
		left join mstanm f 
		on e.ANMID = f.ANMID and f.LanguageID = 2
		left join tblhhfamilymember g
		on a.HHFamilyMemberGUID = g.HHFamilyMemberGUID 
		left join tblhhsurvey h
		on g.HHSurveyGUID = h.HHSurveyGUID
		left join mstvillage i 
		on h.VillageID = i.VillageID and i.LanguageID = 2
		where a.IsPregnant=1 and TIMESTAMPDIFF(MONTH, a.LMPDate, CURRENT_DATE) >= 11 and b.user_mode = 1";

		$content['data_list'] = $this->db->query($query)->result();
		if ($export_command == "export_csv") {
			$this->load->model('Data_export_model');
			$this->Data_export_model->export_csv($query);
		}

		$content['report_title'] = 'List of pregnant women marked pregnant with 11 months of LMP';
		$content['subview'] = "generic_list";
		$this->load->view('auth/main_layout', $content);
		
	}

	public function children_in_tblchild_more_than_15_years($export_command = NULL)
	{
		// start permission 
		$user_role = $this->loginData->user_role;
		$query = "SELECT * FROM role_permissions as rp LEFT JOIN mstrole as mst on rp.RoleID=mst.RoleID WHERE rp.RoleID='$user_role' ";
		$content['role_permission'] = $this->Common_Model->query_data($query);
		// end permission 
		
		$query = "select a.child_name, b.FamilyMemberName, c.HHCode, timestampdiff(YEAR, a.child_dob, CURRENT_DATE) as AgeInYears, d.user_name, e.ASHAName, f.ANMName, g.VillageName from tblchild a 
		inner join tblhhfamilymember b 
		on a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
		inner join tblhhsurvey c 
		on b.HHSurveyGUID = c.HHSurveyGUID
		left join tblusers d
		on c.CreatedBy = d.user_id
		left join mstasha e 
		on c.ServiceProviderID = e.ASHAID and e.LanguageID=1
		left join mstanm f 
		on c.ANMID = f.ANMID and f.LanguageID=1
		left join mstvillage g 
		on c.VillageID = g.VillageID and g.LanguageID=1
		where timestampdiff(YEAR, a.child_dob, CURRENT_DATE) > 15 and d.user_mode=1";

		$content['data_list'] = $this->db->query($query)->result();
		if ($export_command == "export_csv") {
			$this->load->model('Data_export_model');
			$this->Data_export_model->export_csv($query);
		}

		$content['report_title'] = 'List of children in tblchild having age greater than 15 years';
		$content['subview'] = "generic_list";
		$this->load->view('auth/main_layout', $content);
	}


	public function list_of_households_having_more_then_1_family_members_with_relation_ID_1($export_command = NULL)
	{
		// start permission 
		$user_role = $this->loginData->user_role;
		$query = "SELECT * FROM role_permissions as rp LEFT JOIN mstrole as mst on rp.RoleID=mst.RoleID WHERE rp.RoleID='$user_role' ";
		$content['role_permission'] = $this->Common_Model->query_data($query);
		// end permission 

		$query = "select a.user_id, c.AshaCode, c.AshaName, d.* 
					from (select * from tblusers where state_code='05' and user_mode=1) a
					inner join userashamapping b
					on a.user_id = b.UserID
					inner join (select * from mstasha where isActive=1)c
					on b.AshaID = c.ashaID and c.LanguageID=1
					left join (
					select a.CreatedBy, a.HHSurveyGUID, a.HHCode, a.total as total from (
					select a.HHSurveyGUID, count(*) as total, a.HHCode, a.CreatedBy from tblhhsurvey a 
					inner join tblhhfamilymember b 
					on a.HHSurveyGUID = b.HHSurveyGUID
					where b.RelationID=1
					group by a.HHSurveyGUID
					having count(*) > 1)a 
					   group by a.CreatedBy, a.HHSurveyGUID)d 
					on a.user_id = d.createdBy
					order by a.user_id asc";
					$content['data_list'] = $this->db->query($query)->result();
		if ($export_command == "export_csv") {
			$this->load->model('Data_export_model');
			$this->Data_export_model->export_csv($query);
		}

		$content['report_title'] = 'list of households having more then 1 family members with relation ID 1';
		$content['subview'] = "generic_list";
		$this->load->view('auth/main_layout', $content);
	}

}