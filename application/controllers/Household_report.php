<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Household_report extends Auth_controller {

	public function __construct()
	{
		parent::__construct();
		$this->loginData = $this->session->userdata('loginData');
	}
	
	public function index($ANMCode="NULL", $AshaCode= "NULL",$StateCode="NULL")
	{	
		// start permission 
		$user_role = $this->loginData->user_role;
		$query = "SELECT * FROM role_permissions as rp LEFT JOIN mstrole as mst on rp.RoleID=mst.RoleID WHERE rp.RoleID='$user_role' ";
		$content['role_permission'] = $this->Common_Model->query_data($query);
		// end permission 

		$query = "select * from mststate where IsDeleted=0 and LanguageID = 1 ";
		if ($this->loginData->user_role == 1 || $this->loginData->user_role == 2 || $this->loginData->user_role == 3 || $this->loginData->user_role == 6 || $this->loginData->user_role == 7 || $this->loginData->user_role == 8) 	 {
			$query .= "	and StateCode='".$this->loginData->state_code."' ";

			// add district based filter if district role
			if ($this->loginData->user_role == 7) {
				$query .= " and district_code =  $this->loginData->district_code ";
			}
			// add district based filter if block role
			if ($this->loginData->user_role == 8) {
				$query .= " and block_code =  $this->loginData->block_code ";
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
			$content['Anm_list'] = array();
			$content['Asha_list'] = array();
		}

		$content['subview'] = "list_household_report";
		$this->load->view('auth/main_layout', $content);
	}

	public function getHouseHoldReportList($ANMCode = NULL , $export_ashadetails = NULL)
	{
    //$ANMCode = $this->input->post('ANMCode');
		$searchPhrase = $this->input->post('searchPhrase');

		$query = "select st.StateCode,asha.SubCenterCode,asha.ANMCode,asha.ASHAID,asha.ASHAName, b.hh_count, c.fm_count, d.hh_verified,  f.population_verified, (f.population_verified / c.fm_count ) * 100 as percent_population_verified, (d.hh_verified / b.hh_count ) * 100 as Score, g.new_household from mstasha asha
		left join 
		(select count(*)  as hh_count, ServiceProviderID from tblhhsurvey group by ServiceProviderID) b 
		on b.ServiceProviderID = asha.ASHAID
		left join 
		mstsubcenter sb on asha.SubCenterCode=sb.SubCenterCode 
		left join 
		mststate st on sb.StateCode=st.StateCode 

		left join 
		(select count(*)  as fm_count, tblhhsurvey.ServiceProviderID from tblhhfamilymember 
		inner join tblhhsurvey on tblhhfamilymember.HHUID = tblhhsurvey.HHUID
		group by tblhhsurvey.ServiceProviderID) c 
		on c.ServiceProviderID = asha.ASHAID
		left join 
		(select count(*)  as hh_verified, ServiceProviderID from tblhhsurvey where Verified=1 group by ServiceProviderID) d 
		on d.ServiceProviderID = asha.ASHAID
		left join 
		(select count(*) as population_verified, tblhhsurvey.ServiceProviderID  from tblhhsurvey 
		inner join tblhhfamilymember 
		on tblhhsurvey.HHUID = tblhhfamilymember.HHUID and tblhhsurvey.Verified = 1
		group by tblhhsurvey.ServiceProviderID
		) f
		on f.ServiceProviderID = asha.ASHAID
		left join 
		(select count(HHUID) as new_household, ServiceProviderID from tblhhsurvey where tblhhsurvey.CreatedOn > '2016-11-12'
		group by ServiceProviderID) g 
		on g.ServiceProviderID = asha.ASHAID 
		where asha.LanguageID = 1 and asha.IsDeleted = 0 and asha.ANMCode = '".$ANMCode."'";

		if ($export_ashadetails != NULL) {
			if ($export_ashadetails == "export_csv") {
				$this->load->model('Data_export_model');
				$this->Data_export_model->export_csv($query);
				die();
			}else if ($export_ashadetails == "export_pdf") {
				$this->load->model('Data_export_model');
				$this->Data_export_model->export_pdf($query);
				die();
			}
		}
		$content['Asha_Details'] = $this->Common_Model->query_data($query);
     //print_r($content['Asha_Details']); die();
		$content['subview'] = "list_household_report_asha";
		$this->load->view('auth/main_layout', $content);
	}

	public function export_csv()
	{
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
		where anm.LanguageID = 1 and anm.IsDeleted = 0";

		$this->load->model('Data_export_model');
		$this->Data_export_model->export_csv($query);
	}

	public function export_pdf()
	{
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
		where anm.LanguageID = 1 and anm.IsDeleted = 0";

		$this->load->model('Data_export_model');
		$this->Data_export_model->export_pdf($query);
	}

	public function edit($ANMCode = NULL){

		$RequestMethod= $this->input->server("REQUEST_METHOD");
		if ($RequestMethod == "POST") {

			$updateArr = array(
				'DistrictName'			=>	$this->input->post('DistrictNameEnglish'),
				
				);

			$this->db->where('ANMCode' , $ANMCode);
			$this->db->update('mstasha', $updateArr);
			$this->session->set_flashdata('tr_msg', 'Successfully Updated Records');
		}
		
		$content['subview']="edit_houseboardreport";
		$this->load->view('auth/main_layout',$content);
	}   


	function delete($ANMCode =  NULL){
		$sql = "update mstanm set IsDeleted = 1 where	ANMCode='$ANMCode' ";
		$this->db->query($sql);
		$this->session->set_flashdata('tr_msg' ,"Household Report Deleted Successfully");
		redirect('Household_report');
	}

} 
