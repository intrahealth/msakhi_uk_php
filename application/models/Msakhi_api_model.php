<?php

class Msakhi_api_model extends CI_Model
{
	private $user;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Common_Model');
	}

	public function authenticateApiUser()
	{	
		$requested_method = $this->input->server('REQUEST_METHOD');
		if($requested_method != "POST")
		{
			return "ERROR! Request method not supported. Please use HTTP POST method";
		}

		$username = $this->security->xss_clean($this->input->post('username'));
		$password = $this->security->xss_clean($this->input->post('password'));
		// $user_role=$this->security->xss_clean($this->input->post('user_role'));

		if($username == "" || $password == "" )
		{
			return "Please specify username and password in the request";
		}

		$this->db->where('user_name = BINARY ',$username);
		$this->db->where('password', md5($password));
		
		$query = $this->db->get('tblusers');

		// Error executing query
		if(!$query)
		{
			$errObj   = $this->db->error();
			$errNo = $errObj->code;
			$errMess = $errObj->message;
			return "ERROR: Login error: ".$errNo .' : '.$errMess;
		}

		// Check if corresponding user founds
		if($query->num_rows() != 1)
		{
			return "ERROR: Incorrect username/password. Please try again.";
		}

		$this->user = $query->result()[0];

		if ($this->input->post('user_role') != NULL && $this->input->post('user_role') != '0') {
			if ($this->user->user_role != $this->input->post('user_role')) {
				return "ERROR: The user role on device is different from the one being added now";
			}
		}

		// check if the anmmid of user is same as currently logged-in user of device
		if ($this->user->user_role == 2) 
		{

			$anmid_server = $this->get_anm_of_asha($this->user->user_id);

			$anmid_device = $this->input->post('anmid');
			if ($anmid_device == NULL || $anmid_device == "" || $anmid_device == 0) {
				// all okay
			}else{

				if ($anmid_server != $anmid_device) {
					return "ERROR: The ASHA being added is linked to some other ANM than the ASHA on device. Can't add two ANM data on one device";
				}

			}

		}


		// all good, return user record

		// add checking for imei 
		$imei = $this->input->post('imei');
		if ($imei != NULL && $imei != "") {

			if ($this->user->imei1 == $imei || $this->user->imei2 == $imei || $this->user->imei_fa == $imei || $this->user->imei_admin == $imei) {
				$apple = "sweet";
			}else{
				$this->user->is_temp = "2";
			}
			
		}

		return $this->user;
	}

	public function get_masters($user)
	{

		$this->user = $user;
		$content = array();
		$this->db->trans_start();

		// state
		if ($this->user->user_role == 2)
		{
			$query = "select * from mststate where StateCode in(select distinct StateCode from userstatemapping where UserID = ?)";
			$content['mststate'] = $this->db->query($query, [$this->user->user_id])->result();
		}
		else if ($this->user->user_role == 3) 
		{
			$query = "select * from mststate where StateCode in(select distinct StateCode from userstatemapping where UserID in(".implode(",", $this->get_asha_userid_of_anm($this->user->user_id))."))";
			$content['mststate'] = $this->db->query($query)->result();
		}
		else if ($this->user->user_role == 11)
		{
			$query = "select
			c.*
			FROM
			userchcmapping a
			INNER JOIN tblusers b ON
			a.UserID = b.user_id
			INNER JOIN mststate c ON
			b.state_code = c.StateCode
			WHERE
			a.UserID = ?";
			$content['mststate'] = $this->db->query($query, [$this->user->user_id])->result();
		}
		elseif ($this->user->user_role == 4) 
		{
			$this->db->where('StateCode', $this->user->state_code);
			$content['mststate'] = $this->db->get('mststate')->result();
		}

		// district
		if ($this->user->user_role == 2)
		{
			$query = "select * from mstdistrict where DistrictCode in(select distinct DistrictCode from userstatemapping where UserID = ?)";
			$content['mstdistrict'] = $this->db->query($query, [$this->user->user_id])->result();
		}
		else if ($this->user->user_role == 3) 
		{
			$query = "select * from mstdistrict where DistrictCode in(select distinct DistrictCode from userstatemapping where UserID in(".implode(",", $this->get_asha_userid_of_anm($this->user->user_id))."))";
			$content['mstdistrict'] = $this->db->query($query)->result();
		}
		else if ($this->user->user_role == 11)
		{
			$query = "select
			c.*
			FROM
			userchcmapping a
			INNER JOIN tblusers b ON
			a.UserID = b.user_id
			INNER JOIN mstdistrict c ON
			b.district_code = c.DistrictCode
			WHERE
			a.UserID = ?";
			$content['mstdistrict'] = $this->db->query($query, [$this->user->user_id])->result();
		}
		elseif ($this->user->user_role == 4) 
		{
			$this->db->where('DistrictCode', $this->user->district_code);
			$content['mstdistrict'] = $this->db->get('mstdistrict')->result();
		}


		// block
		if ($this->user->user_role == 2)
		{
			$query = "select * from mstblock where BlockCode in(select distinct BlockCode from userstatemapping where UserID = ?)";
			$content['mstblock'] = $this->db->query($query, [$this->user->user_id])->result();
		}
		else if ($this->user->user_role == 3) 
		{
			$query = "select * from mstblock where BlockCode in(select distinct BlockCode from userstatemapping where UserID in(".implode(",", $this->get_asha_userid_of_anm($this->user->user_id))."))";
			$content['mstblock'] = $this->db->query($query)->result();
		}
		else if ($this->user->user_role == 11) 
		{
			$query = "select
			c.*
			FROM
			userchcmapping a
			INNER JOIN tblusers b ON
			a.UserID = b.user_id
			INNER JOIN mstblock c ON
			b.block_code = c.BlockCode
			WHERE
			a.UserID = ?";
			$content['mstblock'] = $this->db->query($query, [$this->user->user_id])->result();
		}
		elseif ($this->user->user_role == 4) 
		{
			$this->db->where('BlockCode', $this->user->block_code);
			$content['mstblock'] = $this->db->get('mstblock')->result();
		}

		// village
		if ($this->user->user_role == 2)
		{
			$query = "select * from mstvillage where VillageID in(select distinct VillageID from ashavillage where ASHAID = ?)";
			$content['mstvillage'] = $this->db->query($query, [$this->get_asha_id_from_user_id($this->user->user_id)])->result();
		}
		else if ($this->user->user_role == 3) 
		{
			$query = "select * from mstvillage where VillageID in(select distinct VillageID from ashavillage where ASHAID in(".implode(",", $this->get_asha_of_anm($this->user->user_id))."))";
			$content['mstvillage'] = $this->db->query($query)->result();
		}
		else if ($this->user->user_role == 11)
		{
			$query = "select
			f.*
			FROM
			userchcmapping a
			INNER JOIN mstsubcenter b ON
			a.CHCID = b.CHCID 
			INNER JOIN anmsubcenter c ON
			b.SubCenterID = c.SubCenterID
			INNER JOIN anmasha d ON
			c.ANMID = d.ANMID
			INNER JOIN ashavillage e ON
			d.ASHAID = e.ASHAID
			INNER JOIN mstvillage f ON
			e.VillageID = f.VillageID 
			where a.UserID=?
			group by f.VillageID, f.LanguageID
			";

			$content['mstvillage'] = $this->db->query($query, [$this->user->user_id])->result();		    

		}
		elseif ($this->user->user_role == 4) 
		{
			$query = "select e.* FROM userafmapping a 
			inner join mstcatchmentsupervisor b
			on a.AFID = b.CHS_ID and b.LanguageID = 1
			inner join mstasha c 
			on b.CHS_ID = c.CHS_ID and c.LanguageID = 1 and c.IsActive = 1
			inner join ashavillage d 
			on c.ASHAID = d.ASHAID 
			inner join mstvillage e 
			on d.VillageID = e.VillageID
			where a.UserID = ?";
			$content['mstvillage'] = $this->db->query($query,[$this->user->user_id])->result();
		}

		// subcenter
		if ($this->user->user_role == 2)
		{
			$query = "select * from mstsubcenter where SubCenterCode in(select distinct SubCenterCode from anmsubcenter where ANMID in (select distinct ANMID from anmasha where ASHAID = ?))";
			$content['mstsubcenter'] = $this->db->query($query, [$this->get_asha_id_from_user_id($this->user->user_id)])->result();
		}
		else if ($this->user->user_role == 3) 
		{
			$query = "select * from mstsubcenter where SubCenterCode in(select distinct SubCenterCode from anmsubcenter where ANMID in( select distinct ANMID from anmasha where ASHAID in (".implode(",", $this->get_asha_of_anm($this->user->user_id)).")))";
			$content['mstsubcenter'] = $this->db->query($query)->result();
		}
		else if ($this->user->user_role == 11)
		{
			$query = "SELECT
			b.*
			FROM
			userchcmapping a
			INNER JOIN mstsubcenter b ON
			a.CHCID = b.CHCID
			WHERE
			a.UserID = ?";
			$content['mstsubcenter'] = $this->db->query($query, [$this->user->user_id])->result();
		}
		elseif ($this->user->user_role == 4) 
		{
			$query = "select f.* FROM userafmapping a 
			inner join mstcatchmentsupervisor b
			on a.AFID = b.CHS_ID and b.LanguageID = 1
			inner join mstasha c 
			on b.CHS_ID = c.CHS_ID and c.LanguageID = 1 and c.IsActive = 1
			inner join anmasha d 
			on c.ASHAID = d.ASHAID
			inner join anmsubcenter e 
			on d.ANMID = e.ANMID 
			inner join mstsubcenter f 
			on e.SubcenterID = f.SubcenterID
			where a.UserID=?";
			$content['mstsubcenter'] = $this->db->query($query,[$this->user->user_id])->result();
		}

		// pachayat
		if ($this->user->user_role == 2)
		{
			$query = "select * from mstpanchayat where PanchayatCode in(select distinct PanchayatCode from userstatemapping where UserID = ?)";
			$content['mstpanchayat'] = $this->db->query($query, [$this->user->user_id])->result();
		}
		else if ($this->user->user_role == 3) 
		{
			$query = "select * from mstpanchayat where PanchayatCode in(select distinct PanchayatCode from userstatemapping where UserID in(".implode(",", $this->get_asha_userid_of_anm($this->user->user_id))."))";
			$content['mstpanchayat'] = $this->db->query($query)->result();
		}
		else if ($this->user->user_role == 11)
		{
			$query = "select * from mstpanchayat where PanchayatCode in(select distinct PanchayatCode from userstatemapping where UserID = ?)";
			$content['mstpanchayat'] = $this->db->query($query, [$this->user->user_id])->result(); 
		}
		elseif ($this->user->user_role == 4) 
		{
			$query = "select * from mstpanchayat where PanchayatCode in(select distinct PanchayatCode from userstatemapping where UserID = ?)";
			$content['mstpanchayat'] = $this->db->query($query, [$this->user->user_id])->result();
		}
		
		// mstanm and mstasha and mstchc
		if ($this->user->user_role == 2) 
		{
			$anm_id = $this->get_anm_of_asha($this->user->user_id);
			$query 	=	"select * from mstanm where ANMID = $anm_id";
			$content['mstanm']	=	$this->Common_Model->query_data($query);

			$asha_id = $this->get_asha_id_from_user_id($this->user->user_id);
			$query 	=	"select * from mstasha where ASHAID = $asha_id and IsActive=1";
			$content['mstasha']	=	$this->Common_Model->query_data($query);

			$query = "SELECT
			d.*
			FROM
			mstanm a
			INNER JOIN anmsubcenter b ON
			a.ANMID = b.ANMID
			INNER JOIN mstsubcenter c ON
			c.SubCenterID = b.SubCenterID
			INNER JOIN mstchc d ON
			c.CHCID = d.CHCID
			INNER JOIN userchcmapping e ON
			e.CHCID = d.CHCID
			WHERE
			e.UserID = ?
			GROUP by d.CHCID, d.LanguageID";

			$content['mstchc']	=	$this->db->query($query, [$this->user->user_id])->result();
			
		}
		else if ($this->user->user_role == 3) 
		{
			$anm_id = $this->get_amn_id_from_user_id($this->user->user_id);	
			$query 	=	"select * from mstanm where ANMID = $anm_id";
			$content['mstanm']	=	$this->Common_Model->query_data($query);

			$asha_list = $this->get_asha_of_anm($this->user->user_id);
			$query 	=	"select * from mstasha where ASHAID in (".implode(",", $asha_list).") and IsActive=1";
			$content['mstasha']	=	$this->Common_Model->query_data($query);

			$query = "SELECT
			c.*
			FROM
			mstasha a
			INNER JOIN mstsubcenter b ON
			a.SubCenterCode = b.SubCenterCode
			INNER JOIN mstchc c ON
			c.CHCID = b.CHCID
			INNER JOIN userchcmapping d ON
			c.CHCID = d.CHCID
			WHERE
			d.UserID = ?
			GROUP by c.CHCID, c.LanguageID";

			$content['mstchc']	=	$this->db->query($query, [$this->user->user_id])->result();

		}
		else if ($this->user->user_role == 11)
		{
			$query 	=	"select
			d.*
			FROM
			userchcmapping a
			INNER JOIN mstsubcenter b ON
			a.CHCID = b.CHCID 
			INNER JOIN anmsubcenter c ON
			b.SubCenterID = c.SubCenterID
			INNER JOIN mstanm d ON
			c.ANMID = d.ANMID 
			WHERE
			a.UserID = ?";
			$content['mstanm']	=	$this->db->query($query, [$this->user->user_id])->result();

			$query = "select
			f.*
			FROM
			userchcmapping a
			INNER JOIN mstsubcenter b ON
			a.CHCID = b.CHCID 
			INNER JOIN anmsubcenter c ON
			b.SubCenterID = c.SubCenterID
			INNER JOIN mstanm d ON
			c.ANMID = d.ANMID 
			INNER JOIN anmasha e ON
			d.ANMID = e.ANMID
			INNER JOIN mstasha f ON
			e.ASHAID = f.ASHAID 
			WHERE
			a.UserID = ?
			group by f.ashaid, f.languageID";

			$content['mstasha']	=	$this->db->query($query, [$this->user->user_id])->result();

			$query = "select b.* from userchcmapping a INNER join mstchc b on a.CHCID = b.CHCID where a.UserID = ? ";

			$content['mstchc']	=	$this->db->query($query, [$this->user->user_id])->result();

		}elseif ($this->user->user_role == 4) {
			
			$query = "select c.* FROM userafmapping a 
			inner join mstcatchmentsupervisor b
			on a.AFID = b.CHS_ID and b.LanguageID = 1
			inner join mstasha c 
			on b.CHS_ID = c.CHS_ID and c.IsActive = 1
			where a.UserID = ?";
			$content['mstasha']	= $this->db->query($query, [$this->user->user_id])->result();

			$query = "select e.* FROM userafmapping a 
			inner join mstcatchmentsupervisor b
			on a.AFID = b.CHS_ID and b.LanguageID = 1
			inner join mstasha c 
			on b.CHS_ID = c.CHS_ID and c.LanguageID = 1 and c.IsActive = 1
			inner join anmasha d 
			on c.ASHAID = d.ASHAID
			inner join mstanm e 
			on d.ANMID = e.ANMID and e.IsActive=1
			where a.UserID = ?
			group by e.ANMID, e.LanguageID";
			$content['mstanm']	= $this->db->query($query, [$this->user->user_id])->result();

			$query = "select b.* from 
			userchcmapping a 
			INNER join mstchc b 
			on a.CHCID = b.CHCID 
			where a.UserID = ?";
			$content['mstchc']	= $this->db->query($query, [$this->user->user_id])->result();
		}

		$query = "select * from mstcommon";
		$content['mstcommon']	=	$this->Common_Model->query_data($query);

		$query = "select * from anmsubcenter";
		$content['anmsubcenter']	=	$this->Common_Model->query_data($query);

		$query =	"select * from mstversion";
		$content['mstversion']	=	$this->Common_Model->query_data($query);

		$query =	"select * from mstphc";
		$content['mstphc']	=	$this->Common_Model->query_data($query);

		$query =	"select * from mstsubcentervillagemapping";
		$content['mstsubcentervillagemapping']	=	array();

		$query = "select * from mstcatchmentarea";
		$content['mstcatchmentarea'] = $this->Common_Model->query_data($query);

		// mstcatchmentsupervisor
		if ($this->user->user_role == 2)
		{
			$query = "select *, 0 as SubCenterID from mstcatchmentsupervisor where CHS_ID in (select distinct CHS_ID from mstasha where ASHAID = ? and IsActive=1)";
			$content['mstcatchmentsupervisor'] = $this->db->query($query, [$this->get_asha_id_from_user_id($this->user->user_id)])->result();
		}
		else if ($this->user->user_role == 3) 
		{
			$query = "select *, 0 as SubCenterID from mstcatchmentsupervisor where CHS_ID in (select distinct CHS_ID from mstasha where ASHAID in(".implode(",", $this->get_asha_of_anm($this->user->user_id)).") and IsActive=1)";
			$content['mstcatchmentsupervisor'] = $this->db->query($query)->result();
		}		
		else if ($this->user->user_role == 11)
		{
			$query = "select *, 0 as SubCenterID from mstcatchmentsupervisor where CHS_ID in (

			SELECT
			DISTINCT f.CHS_ID
			FROM
			userchcmapping a
			INNER JOIN mstsubcenter b ON
			a.CHCID = b.CHCID 
			INNER JOIN anmsubcenter c ON
			b.SubCenterID = c.SubCenterID
			INNER JOIN mstanm d ON
			c.ANMID = d.ANMID 
			INNER JOIN anmasha e ON
			d.ANMID = e.ANMID
			INNER JOIN mstasha f ON
			e.ASHAID = f.ASHAID 
			WHERE
			a.UserID = ?)";
			$content['mstcatchmentsupervisor']=$this->db->query($query, [$this->user->user_id])->result();
		}
		elseif ($this->user->user_role == 4) 
		{
			$query = "select b.*, 0 as SubCenterID FROM userafmapping a 
			inner join mstcatchmentsupervisor b
			on a.AFID = b.CHS_ID
			where a.UserID = ?";
			$content['mstcatchmentsupervisor'] = $this->db->query($query, [$this->user->user_id])->result();
		}

		$query =	"select * from mstrole where RoleID = ?";
		$content['mstrole']	=	$this->db->query($query, [$this->user->user_role])->result();

		$query =	"select * from tbl_incentive";
		$content['tbl_incentive']	=	$this->Common_Model->query_data($query);

		$query =	"select * from mstvhnd_duelistitems";
		$content['mstvhnd_duelistitems']	=	$this->Common_Model->query_data($query);

		$query =	"select * from mstvhnd_performanceindicator";
		$content['mstvhnd_performanceindicator']	=	$this->Common_Model->query_data($query);

		$query =	"select * from mstpdfreport";
		$content['mstpdfreport']	=	$this->Common_Model->query_data($query);

		// vhnd_schedule
		if ($this->user->user_role == 2)
		{
			$query = "select * from vhnd_schedule where ASHA_ID = ?";
			$content['vhnd_schedule'] = $this->db->query($query, [$this->get_asha_id_from_user_id($this->user->user_id)])->result();
		}
		else if ($this->user->user_role == 3) 
		{
			$query = "select * from vhnd_schedule where ASHA_ID in (".implode(",", $this->get_asha_of_anm($this->user->user_id)).")";
			$content['vhnd_schedule'] = $this->db->query($query)->result();
		}
		else if ($this->user->user_role == 11)
		{
			$query = "select * from vhnd_schedule where ASHA_ID in  (
			SELECT
			DISTINCT f.CHS_ID
			FROM
			userchcmapping a
			INNER JOIN mstsubcenter b ON
			a.CHCID = b.CHCID 
			INNER JOIN anmsubcenter c ON
			b.SubCenterID = c.SubCenterID
			INNER JOIN mstanm d ON
			c.ANMID = d.ANMID 
			INNER JOIN anmasha e ON
			d.ANMID = e.ANMID
			INNER JOIN mstasha f ON
			e.ASHAID = f.ASHAID 
			WHERE
			a.UserID = ?)";
			$content['vhnd_schedule']=$this->db->query($query, [$this->user->user_id])->result();
		}
		else if ($this->user->user_role == 4)
		{
			$content['vhnd_schedule'] = [];
		}

		$content['tblmedia'] = $this->db->get('tblmedia')->result();

		$content['userashamapping'] = $this->db->get('userashamapping')->result();

		$content['anmasha'] = $this->db->get('anmasha')->result();

		$content['ashavillage'] = $this->db->get('ashavillage')->result();

		$content['mstashaactivity'] = $this->db->get('mstashaactivity')->result();

		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			return "ERROR: Error in transaction";					
		}

		return $content;

	}

	/**
	 *  0. If no imei number is sent with request then return FALSE
	 *	1. check if the imei numbers are not filled, then return TRUE
	 *	2. If any one is filled, then compare the sent imei number with that
	 *	3. If both imei1 and imei2 are filled, then any match will return TRUE
	 */
	public function is_imei_verified($user)
	{

		if (!isset($_POST['IMEI'])) {
			header("Content-Type: application/json");
			die(json_encode("ERROR: No IMEI number sent with request"));
			return FALSE;
		}

		$imei = $this->input->post('IMEI');
		
		if (trim($imei) == "") {
			die(json_encode("ERROR: IMEI number sent with request is empty"));
			return FALSE;
		}

		$settings = $this->db->get('tblsettings')->result()[0];
		if ($settings->allow_by_admin == 1) {
			
			if ($user->imei_admin == $imei) {
				return true;
			}
		}

		if ($settings->allow_by_fa == 1) {
			
			if ($user->imei_fa == $imei) {
				return true;
			}
		}

		/**
		 * upload from admin and af stopped manually,
		 	will get stopped from interface later
		 	@2018-03-20
		 */
	/*	if ($user->imei_fa == $imei || $user->imei_admin == $imei) {
			return TRUE;
		}*/

/*		if ($user->imei1 == NULL && $user->imei2 == NULL) {
			return TRUE;
		}

		if ($user->imei1 != NULL && $user->imei2 == NULL) {
			if ($imei != $user->imei1) {
				return FALSE;
			}

			return TRUE;
		}

		if ($user->imei1 == NULL && $user->imei2 != NULL) {
			if ($imei != $user->imei2) {
				return FALSE;
			}

			return TRUE;
		}
*/
		if ($user->imei1 == $imei || $user->imei2 == $imei) {
			return TRUE;		
		}

		return FALSE;
	}

	public function uploadData($user)
	{
		$this->user = $user;

		$data = $this->input->post('data');

		if($data == null || $data == "")
		{
			return "ERROR: Please send data with request";	
		}

		$data_array = json_decode($data);

		if($data_array == null)
		{
			return "ERROR: Please send properly formatted json";
		}

		if (!$this->is_imei_verified($user)) {
			return "ERROR: This device is not allowed for data upload";
		}

		$this->db->trans_start();

		// add version number if present in request
		if ($this->input->post('VersionName') != NULL && $this->input->post('VersionName') !="") 
		{
			$this->db->where('user_id', $this->user->user_id);
			$updateArr = array(
				'VersionName' => $this->input->post('VersionName'),
			);
			$this->db->update('tblusers', $updateArr);
		}

		foreach ($data_array as $tableName => $tableData) {

			switch(strtolower($tableName))
			{
				case "tbl_hhsurvey":
				$this->tblhhsurvey($tableData);
				break;

				case "tbl_hhfamilymember":
				$this->tblhhfamilymember($tableData);
				break;

				case "tblmigration":
				$this->tblmigration($tableData);
				break;

				case "tblhhupdate_log":
				$this->tblhhupdate_log($tableData);
				break;

				case "tbl_ancvisit":
				$this->tblancvisit($tableData);
				break;

				case "tbl_pregnantwomen":
				$this->tblpregnant_woman($tableData);
				break;

				case "tblchild":
				$this->tblchild($tableData);
				break;

				case "tbl_datesed":
				$this->tbl_datesed($tableData);
				break;

				case "tblmstimmunizationans":
				$this->tblmstimmunizationans($tableData);
				break;

				case "tblpnchomevisit_ans":
				$this->tblpnchomevisit_ans($tableData);
				break;

				case "tblfp_followup":
				$this->tblfp_followup($tableData);
				break;

				case "tblfp_visit":
				$this->tblfp_visit($tableData);
				break;

				case "tbl_vhnd_duelist":
				$this->tbl_vhnd_duelist($tableData);
				break;

				case "tblvhndduelist":
				$this->tblvhndduelist($tableData);
				break;

				case "tbl_vhndperformance":
				$this->tbl_vhndperformance($tableData);
				break;

				case "tbl_detailedmoduleusage":
				$this->tbl_detailedmoduleusage($tableData);
				break;

				case "tbldevicespaceusage":
				$this->tbldevicespaceusage($tableData);
				break;

				case "tblncdscreening":
				$this->tblncdscreening($tableData);
				break;

				case "tblncdfollowup":
				$this->tblncdfollowup($tableData);
				break;

				case "tblncdcbac":
				$this->tblncdcbac($tableData);
				break;

				case "tbldowloaddetail":
				$this->tbldowloaddetail($tableData);
				break;

				case "tblncdscreeningmedicine":
				$this->tblncdscreeningmedicine($tableData);
				break;

				case "tblncdscreeningoutside":
				$this->tblncdscreeningoutside($tableData);
				break;

				case "tblncdscreeningmedicineoutside":
				$this->tblncdscreeningmedicineoutside($tableData);
				break;

				case "tblncdcbacdiagnosis":
				$this->tblncdcbacdiagnosis($tableData);
				break;

				case "tblincentivesurvey":
				$this->tblincentivesurvey($tableData);
				break;

				case "tblashaincentivedetail":
				$this->tblashaincentivedetail($tableData);
				break;

				case "tblafverify":
				$this->tblafverify($tableData);
				break;

				case "tblashaclaim":
				$this->tblashaclaim($tableData);
				break;

				default:
				$this->db->trans_complete();
				return "ERROR: Unknown table $tableName in data.".__LINE__;
				
			}
		}


		$this->db->trans_complete();

		if($this->db->trans_status() === FALSE)
		{
			return "ERROR:error in transaction";
		}

		return array("success");

	}

	private function tblhhsurvey($data)
	{
		$dateFields = $this->get_date_fields(__FUNCTION__);

		foreach ($data as $row) {

			$row = $this->clean_row($row, $dateFields);
			unset($row->HHUID);

			$row->UploadedBy = $this->user->user_id;
			$row->UploadedOn = date("Y-m-d");

			$this->db->where('HHSurveyGUID', $row->HHSurveyGUID);
			$result = $this->db->get('tblhhsurvey')->result();
			if (count($result) < 1) {
				// insert

				$row->IMEI = $this->input->post('IMEI');
				$this->Common_Model->insert_data('tblhhsurvey', $row);

			}else{
				// update

				unset($row->ServiceProviderID);
				unset($row->ANMID);

				$this->Common_Model->update_data('tblhhsurvey', $row, 'HHSurveyGUID', $row->HHSurveyGUID);
			}

		}
	}

	private function tblhhfamilymember($data)
	{
		$dateFields = $this->get_date_fields(__FUNCTION__);

		foreach ($data as $row) {

			$row = $this->clean_row($row, $dateFields);
			unset($row->HHFamilyMemberUID);

			$row->UploadedBy = $this->user->user_id;
			$row->UploadedOn = date("Y-m-d");

			/**
			 * change to clear zero in Father, Mother and Spouse
			 */
			if (trim($row->Father) == '0') {
				$row->Father = NULL;
			}

			if (trim($row->Mother) == '0') {
				$row->Mother = NULL;
			}

			if (trim($row->Spouse) == '0') {
				$row->Spouse = NULL;
			}

			$this->db->where('HHFamilyMemberGUID', $row->HHFamilyMemberGUID);
			$result = $this->db->get('tblhhfamilymember')->result();
			if (count($result) < 1) {
				// insert
				$row->IMEI = $this->input->post('IMEI');
				$this->Common_Model->insert_data('tblhhfamilymember', $row);
			}else{
				// update

				unset($row->AshaID);
				unset($row->ANMID);

				$this->Common_Model->update_data('tblhhfamilymember', $row, 'HHFamilyMemberGUID', $row->HHFamilyMemberGUID);
			}
		}
	}

	private function tblmigration($data)
	{
		$dateFields = $this->get_date_fields(__FUNCTION__);

		foreach ($data as $row) {

			$row = $this->clean_row($row, $dateFields);

			$row->UploadedBy = $this->user->user_id;
			$row->UploadedOn = date("Y-m-d");

			$this->db->where('HHFamilyMemberGUID', $row->HHFamilyMemberGUID);
			$result = $this->db->get('tblmigration')->result();
			if (count($result) < 1) {
				// insert
				$row->IMEI = $this->input->post('IMEI');
				$this->Common_Model->insert_data('tblmigration', $row);
			}else{
				// update
				$this->Common_Model->update_data('tblmigration', $row, 'HHFamilyMemberGUID', $row->HHFamilyMemberGUID);
			}
		}
	}

	private function clean_row($row = array(), $dateFields = array())
	{
		$cleanRow = new stdclass;
		foreach ($row as $key => $value) {

			if (trim($value) == "") {
				$cleanRow->{$key} = NULL;
				continue;
			}

			if (in_array(strtolower($key), $dateFields)) {
				// echo " cleaning $key  |   ";
				$cleanRow->{$key} = date("Y-m-d", strtotime($value));
			}else{
				$cleanRow->{$key} = $value;
			}

		}

		return $cleanRow;
	}

	private function get_date_fields($table_name)
	{

		$dateFields = array();

		$fields = $this->db->field_data($table_name);
		foreach ($fields as $field) {
			if ($field->type == "date") {
				$dateFields[] = strtolower($field->name);
			}
		}

		return $dateFields;
	}

	private function tblchild($data)
	{

		$dateFields = $this->get_date_fields(__FUNCTION__);

		foreach ($data as $row) {

			$row = $this->clean_row($row, $dateFields);

			$row->uploaded_by = $this->user->user_id;
			$row->uploaded_on = date("Y-m-d");

			

			$this->db->where('ChildGUID', $row->ChildGUID);
			$result = $this->db->get('tblchild')->result();
			if (count($result) < 1) {
				// insert
				$row->IMEI = $this->input->post('IMEI');
				$this->Common_Model->insert_data('tblchild', $row);
			}else{
				// update

				unset($row->AshaID);
				unset($row->ANMID);

				$this->Common_Model->update_data('tblchild', $row, 'ChildGUID', $row->ChildGUID);
			}
		}
	}

	private function tblancvisit($data)
	{
		$dateFields = $this->get_date_fields(__FUNCTION__);

		foreach ($data as $row) {

			$row = $this->clean_row($row, $dateFields);
			unset($row->AncVisitID);

			$row->UploadedOn = date("Y-m-d");
			$row->UploadedBy = $this->user->user_id;

			$this->db->where('VisitGUID', $row->VisitGUID);
			$result = $this->db->get('tblancvisit')->result();
			if (count($result) < 1) {
				// insert
				$row->IMEI = $this->input->post('IMEI');
				$this->Common_Model->insert_data('tblancvisit', $row);
			}else{
				// update

				unset($row->ByAshaID);
				unset($row->ByANMID);

				$this->Common_Model->update_data('tblancvisit', $row, 'VisitGUID', $row->VisitGUID);
			}
		}
	}

	private function tblpregnant_woman($data)
	{
		$dateFields = $this->get_date_fields(__FUNCTION__);

		foreach ($data as $row) {

			$row = $this->clean_row($row, $dateFields);

			$row->UploadedOn = date("Y-m-d");
			$row->UploadedBy = $this->user->user_id;

			

			$this->db->where('PWGUID', $row->PWGUID);
			$result = $this->db->get('tblpregnant_woman')->result();
			if (count($result) < 1) {
				// insert
				$row->IMEI = $this->input->post('IMEI');
				$this->Common_Model->insert_data('tblpregnant_woman', $row);
			}else{
				// update

				unset($row->ANMID);
				unset($row->AshaID);

				$this->Common_Model->update_data('tblpregnant_woman', $row, 'PWGUID', $row->PWGUID);
			}
		}
	}

	private function tbl_datesed($data)
	{
		$dateFields = $this->get_date_fields(__FUNCTION__);

		foreach ($data as $row) {

			$row = $this->clean_row($row, $dateFields);

			$this->db->where('HHSurveyGUID', $row->HHSurveyGUID);
			$this->db->where('HHFamilyMemberGUID', $row->HHFamilyMemberGUID);
			$this->db->where('PWGUID', $row->PWGUID);
			$result = $this->db->get('tbl_datesed')->result();
			if (count($result) < 1) {
				// insert
				$row->IMEI = $this->input->post('IMEI');
				$this->Common_Model->insert_data('tbl_datesed', $row);
			}else{
				// update

				unset($row->ANMID);
				unset($row->AshaID);

				$this->db->where('HHSurveyGUID', $row->HHSurveyGUID);
				$this->db->where('HHFamilyMemberGUID', $row->HHFamilyMemberGUID);
				$this->db->where('PWGUID', $row->PWGUID);
				$this->db->update('tbl_datesed', $row);
			}
		}
	}

	private function tblfp_visit($data)
	{
		$dateFields = $this->get_date_fields(__FUNCTION__);

		foreach ($data as $row) {

			$row = $this->clean_row($row, $dateFields);
			unset($row->UID);

			$row->UploadedOn = date("Y-m-d");
			$row->UploadedBy = $this->user->user_id;

			$this->db->where('FPAns_Guid', $row->FPAns_Guid);
			$result = $this->db->get('tblfp_visit')->result();
			if (count($result) < 1) {
				// insert
				$row->IMEI = $this->input->post('IMEI');
				$this->Common_Model->insert_data('tblfp_visit', $row);
			}else{
				// update

				unset($row->ANMID);
				unset($row->AshaID);

				$this->Common_Model->update_data('tblfp_visit', $row, 'FPAns_Guid', $row->FPAns_Guid);
			}
		}
	}

	private function tblmstimmunizationans($data)
	{
		$dateFields = $this->get_date_fields(__FUNCTION__);

		foreach ($data as $row) {

			$row = $this->clean_row($row, $dateFields);

			$row->UploadedOn = date("Y-m-d");
			$row->UploadedBy = $this->user->user_id;

			$this->db->where('ImmunizationGUID', $row->ImmunizationGUID);
			$result = $this->db->get('tblmstimmunizationans')->result();
			if (count($result) < 1) {
				// insert
				$row->IMEI = $this->input->post('IMEI');
				$this->Common_Model->insert_data('tblmstimmunizationans', $row);
			}else{
				// update

				unset($row->ANMID);
				unset($row->AshaID);

				$this->Common_Model->update_data('tblmstimmunizationans', $row, 'ImmunizationGUID', $row->ImmunizationGUID);
			}
		}
	}

	private function tblpnchomevisit_ans($data)
	{
		$dateFields = $this->get_date_fields(__FUNCTION__);

		foreach ($data as $row) {

			$row = $this->clean_row($row, $dateFields);
			unset($row->UID);

			$row->UploadedOn = date("Y-m-d");
			$row->UploadedBy = $this->user->user_id;

			$this->db->where('ChildGUID', $row->ChildGUID);
			$this->db->where('PNCGUID', $row->PNCGUID);
			$result = $this->db->get('tblpnchomevisit_ans')->result();
			if (count($result) < 1) {
				// insert
				$row->IMEI = $this->input->post('IMEI');
				$this->Common_Model->insert_data('tblpnchomevisit_ans', $row);
			}else{
				// update

				unset($row->ANMID);
				unset($row->AshaID);

				$this->db->where('ChildGUID', $row->ChildGUID);
				$this->db->where('PNCGUID', $row->PNCGUID);
				$this->db->update('tblpnchomevisit_ans', $row);
			}
		}
	}

	private function tblfp_followup($data)
	{
		$dateFields = $this->get_date_fields(__FUNCTION__);

		foreach ($data as $row) {

			$row = $this->clean_row($row, $dateFields);
			unset($row->UID);

			$row->UploadedOn = date("Y-m-d");
			$row->UploadedBy = $this->user->user_id;

			$this->db->where('FPF_Guid', $row->FPF_Guid);
			$result = $this->db->get('tblfp_followup')->result();
			if (count($result) < 1) {
				// insert
				$row->IMEI = $this->input->post('IMEI');
				$this->Common_Model->insert_data('tblfp_followup', $row);
			}else{
				// update

				unset($row->ANMID);
				unset($row->AshaID);

				$this->Common_Model->update_data('tblfp_followup', $row, 'FPF_Guid', $row->FPF_Guid);
			}
		}
	}

	private function tbl_vhnd_duelist($data)
	{
		$dateFields = $this->get_date_fields(__FUNCTION__);

		foreach ($data as $row) {

			$row = $this->clean_row($row, $dateFields);
			unset($row->PID);

			$row->UploadedOn = date("Y-m-d");
			$row->UploadedBy = $this->user->user_id;

			$this->db->where('VHND_ID', $row->VHND_ID);
			$result = $this->db->get('tbl_vhnd_duelist')->result();
			if (count($result) < 1) {
				// insert
				$row->IMEI = $this->input->post('IMEI');
				$this->Common_Model->insert_data('tbl_vhnd_duelist', $row);
			}else{
				// update

				unset($row->ANMID);
				unset($row->AshaID);

				$this->Common_Model->update_data('tbl_vhnd_duelist', $row, 'VHND_ID', $row->VHND_ID);
			}
		}
	}

	private function tblvhndduelist($data)
	{
		$dateFields = $this->get_date_fields(__FUNCTION__);

		foreach ($data as $row) {

			$row = $this->clean_row($row, $dateFields);
			unset($row->ID);

			$this->db->where('BeneficiaryGUID', $row->BeneficiaryGUID);
			$this->db->where('MemberGUID', $row->MemberGUID);
			$this->db->where('HHGUID', $row->HHGUID);
			$this->db->where('VHNDDate', $row->VHNDDate);
			$result = $this->db->get('tblvhndduelist')->result();
			if (count($result) < 1) {
				// insert
				$row->IMEI = $this->input->post('IMEI');
				$this->Common_Model->insert_data('tblvhndduelist', $row);
			}else{
				// update

				unset($row->ANMID);
				unset($row->AshaID);

				$this->db->where('BeneficiaryGUID', $row->BeneficiaryGUID);
				$this->db->where('MemberGUID', $row->MemberGUID);
				$this->db->where('HHGUID', $row->HHGUID);
				$this->db->where('VHNDDate', $row->VHNDDate);
				$this->db->update('tblvhndduelist', $row);
			}
		}
	}

	private function tbl_vhndperformance($data)
	{
		$dateFields = $this->get_date_fields(__FUNCTION__);

		foreach ($data as $row) {

			$row = $this->clean_row($row, $dateFields);
			unset($row->PID);

			$row->UploadedOn = date("Y-m-d");
			$row->UploadedBy = $this->user->user_id;

			$this->db->where('VHND_ID', $row->VHND_ID);
			$result = $this->db->get('tbl_vhndperformance')->result();
			if (count($result) < 1) {
				// insert
				$row->IMEI = $this->input->post('IMEI');
				$this->Common_Model->insert_data('tbl_vhndperformance', $row);
			}else{
				// update

				unset($row->ANMID);
				unset($row->AshaID);
				
				$this->Common_Model->update_data('tbl_vhndperformance', $row, 'VHND_ID', $row->VHND_ID);
			}
		}
	}

	private function tblhhupdate_log($data)
	{
		$dateFields = $this->get_date_fields(__FUNCTION__);
		
		foreach ($data as $row) {
			$row = $this->clean_row($row, $dateFields);
			unset($row->UID);
			$this->Common_Model->insert_data('tblhhupdate_log', $row);
		}
	}

	private function tbl_detailedmoduleusage($data)
	{
		$dateFields = $this->get_date_fields(__FUNCTION__);

		foreach ($data as $row) {

			$row = $this->clean_row($row, $dateFields);
			unset($row->UID);

			$this->db->where('GUID', $row->GUID);
			$result = $this->db->get('tbl_detailedmoduleusage')->result();
			if (count($result) < 1) {
				// insert
				$row->IMEI = $this->input->post('IMEI');
				$this->db->insert('tbl_detailedmoduleusage', $row);
			}else{
				// update
				$this->db->where('GUID', $row->GUID);
				$this->db->update('tbl_detailedmoduleusage', $row);
			}
		}
	}

	private function tbldevicespaceusage($data)
	{
		$dateFields = $this->get_date_fields(__FUNCTION__);
		
		foreach ($data as $row) {
			$row = $this->clean_row($row, $dateFields);
			unset($row->ID);
			$this->Common_Model->insert_data('tbldevicespaceusage', $row);
		}
	}

	private function tblncdscreening($data)
	{
		$dateFields = $this->get_date_fields(__FUNCTION__);

		foreach ($data as $row) {

			$row = $this->clean_row($row, $dateFields);
			unset($row->Uid);
			$row->IsEdited = 0;

			$row->UploadedOn = date("Y-m-d");
			$row->UploadedBy = $this->user->user_id;

			$this->db->where('NCDScreeningGUID', $row->NCDScreeningGUID);
			$result = $this->db->get('tblncdscreening')->result();
			if (count($result) < 1) {
				// insert
				$row->IMEI = $this->input->post('IMEI');
				$this->db->insert('tblncdscreening', $row);
			}else{
				// update

				unset($row->ANMID);
				unset($row->AshaID);

				$this->db->where('NCDScreeningGUID', $row->NCDScreeningGUID);
				$this->db->update('tblncdscreening', $row);
			}
		}

	}


	private function tblncdfollowup($data)
	{
		$dateFields = $this->get_date_fields(__FUNCTION__);

		foreach ($data as $row) {

			$row = $this->clean_row($row, $dateFields);
			unset($row->Uid);
			$row->IsEdited = 0;

			$row->UploadedOn = date("Y-m-d");
			$row->UploadedBy = $this->user->user_id;

			$this->db->where('NCDFollowupGUID', $row->NCDFollowupGUID);
			$result = $this->db->get('tblncdfollowup')->result();
			if (count($result) < 1) {
				// insert
				$row->IMEI = $this->input->post('IMEI');
				$this->db->insert('tblncdfollowup', $row);
			}else{
				// update

				unset($row->ANMID);
				unset($row->AshaID);

				$this->db->where('NCDFollowupGUID', $row->NCDFollowupGUID);
				$this->db->update('tblncdfollowup', $row);
			}
		}

	}

	private function tblncdcbac($data)
	{
		$dateFields = $this->get_date_fields(__FUNCTION__);

		foreach ($data as $row) {

			$row = $this->clean_row($row, $dateFields);
			unset($row->UID);
			$row->IsEdited = 0;

			$row->UploadedOn = date("Y-m-d");
			$row->UploadedBy = $this->user->user_id;

			$this->db->where('NCDCBACGUID', $row->NCDCBACGUID);
			$result = $this->db->get('tblncdcbac')->result();
			
			if (count($result) < 1) {
				// insert
				$row->IMEI = $this->input->post('IMEI');
				$this->db->insert('tblncdcbac', $row);
			}else{
				// update

				unset($row->ANMID);
				unset($row->AshaID);

				$this->db->where('NCDCBACGUID', $row->NCDCBACGUID);
				$this->db->update('tblncdcbac', $row);
			}
		}

	}

	private function tbldowloaddetail($data)
	{
		$dateFields = $this->get_date_fields(__FUNCTION__);

		foreach ($data as $row) 
		{

			
			$row = $this->clean_row($row, $dateFields);
			unset($row->UID);
			$row->IMEI = $this->input->post('IMEI');
			$this->db->insert('tbldowloaddetail', $row);
		}

	}

	private function tblncdscreeningmedicine($data)
	{
		$dateFields = $this->get_date_fields(__FUNCTION__);

		// delete existing records of patients
		$NCDScreeningGUID = [];
		foreach ($data as $row) 
		{
			if (!in_array($row->NCDScreeningGUID, $NCDScreeningGUID)) {
				$NCDScreeningGUID[] = $row->NCDScreeningGUID;
			}
		}

		if (count($NCDScreeningGUID) > 0) {
			$this->db->where_in('NCDScreeningGUID', $NCDScreeningGUID);
			$this->db->delete('tblncdscreeningmedicine');
		}

		foreach ($data as $row) 
		{

			$row = $this->clean_row($row, $dateFields);
			unset($row->Uid);
			$row->IsEdited = 0;

			$row->UploadedOn = date("Y-m-d");
			$row->UploadedBy = $this->user->user_id;
			$row->IMEI = $this->input->post('IMEI');

			$this->db->insert('tblncdscreeningmedicine', $row);
		}
	}

	private function tblncdscreeningoutside($data)
	{
		$dateFields = $this->get_date_fields(__FUNCTION__);

		foreach ($data as $row) 
		{

			$row = $this->clean_row($row, $dateFields);
			$row->IsEdited = 0;
			unset($row->Uid);

			$row->UploadedOn = date("Y-m-d");
			$row->UploadedBy = $this->user->user_id;

			$this->db->where('NCDScreeningGUID', $row->NCDScreeningGUID);
			$result = $this->db->get('tblncdscreeningoutside')->result();
			
			if (count($result) < 1) {
				// insert
				$row->IMEI = $this->input->post('IMEI');
				$this->db->insert('tblncdscreeningoutside', $row);

			}else{
				// update

				unset($row->ANMID);
				unset($row->AshaID);

				$this->db->where('NCDScreeningGUID', $row->NCDScreeningGUID);
				$this->db->update('tblncdscreeningoutside', $row);
			}
		}
	}

	private function tblncdscreeningmedicineoutside($data)
	{
		$dateFields = $this->get_date_fields(__FUNCTION__);

		// delete existing records of patients
		$NCDScreeningGUID = [];
		foreach ($data as $row) 
		{
			if (!in_array($row->NCDScreeningGUID, $NCDScreeningGUID)) {
				$NCDScreeningGUID[] = $row->NCDScreeningGUID;
			}
		}

		if (count($NCDScreeningGUID) > 0) {
			$this->db->where_in('NCDScreeningGUID', $NCDScreeningGUID);
			$this->db->delete('tblncdscreeningmedicineoutside');
		}

		foreach ($data as $row) 
		{

			$row = $this->clean_row($row, $dateFields);
			unset($row->Uid);
			$row->IsEdited = 0;

			$row->UploadedOn = date("Y-m-d");
			$row->UploadedBy = $this->user->user_id;
			
			$row->IMEI = $this->input->post('IMEI');
			$this->db->insert('tblncdscreeningmedicineoutside', $row);
		}
	}

	private function get_asha_of_anm($user_id)
	{

		// get the anmid of currnet user 
		$query = "select * from useranmmapping where UserID = $user_id";
		$anm_id = $this->db->query($query)->result()[0]->ANMID;

		$query = "select * from anmasha where ANMID = $anm_id";
		$result = $this->db->query($query)->result();

		$ashaArr = array();
		foreach ($result as $row) {
			$ashaArr[] = $row->ASHAID;
		}
		return $ashaArr;
	}

	private function get_asha_of_chc($user_id)
	{

		// get the anmid of currnet user 
		$query = "select
		f.*
		FROM
		userchcmapping a
		INNER JOIN mstsubcenter b ON
		a.CHCID = b.CHCID 
		INNER JOIN anmsubcenter c ON
		b.SubCenterID = c.SubCenterID
		INNER JOIN mstanm d ON
		c.ANMID = d.ANMID 
		INNER JOIN anmasha e ON
		d.ANMID = e.ANMID
		INNER JOIN mstasha f ON
		e.ASHAID = f.ASHAID 
		WHERE
		a.UserID = $user_id";
		$result = $this->db->query($query)->result();

		$ashaArr = array();
		foreach ($result as $row) {
			$ashaArr[] = $row->ASHAID;
		}
		return $ashaArr;
	}

	private function get_chcid_userid($CHCID)
	{
		$query = "select * from userchcmapping where CHCID = $CHCID";
		return $this->db->query($query)->result()[0]->CHCID;
	}

	/**
	 * returns user ids of ashas linked with anm
	 */
	private function get_asha_userid_of_anm($user_id)
	{

		// get the anmid of currnet user 
		$query = "select * from useranmmapping where UserID = $user_id";
		$anm_id = $this->db->query($query)->result()[0]->ANMID;

		$query = "select a.ANMID, b.AshaID, b.UserID, b.AshaName FROM `anmasha` a left join userashamapping b on a.ASHAID = b.AshaID where a.ANMID = ?";
		$result = $this->db->query($query, [$anm_id])->result();

		$user_ids = array();
		foreach ($result as $row) {
			$user_ids[] = $row->UserID;
		}
		return $user_ids;
	}

	private function get_anm_of_asha($user_id)
	{

		// get the asha id of current user 
		$query = "select * from userashamapping where UserID = $user_id limit 1";
		$asha_id = $this->db->query($query)->result()[0]->AshaID;

		$query = "select * from anmasha where ASHAID = $asha_id limit 1";
		return $this->db->query($query)->result()[0]->ANMID;

	}

	private function get_user_id_from_asha_id($asha_id)
	{
		$query = "select * from userashamapping where AshaID = $asha_id";
		return $this->db->query($query)->result()[0]->UserID;
	}

	private function get_asha_id_from_user_id($user_id)
	{
		$query = "select * from userashamapping where UserID = $user_id";
		return $this->db->query($query)->result()[0]->AshaID;
	}

	private function get_amn_id_from_user_id($user_id)
	{
		$query = "select * from useranmmapping where UserID = $user_id";
		return $this->db->query($query)->result()[0]->ANMID;
	}

	private function null_to_empty_string($table_name, $blank=[])
	{
		$tableFields = $this->db->list_fields($table_name);
		
		$returnArray = array();
		foreach ($tableFields as $field) 
		{
			if (in_array($field, $blank)) 
			{
				$returnArray[] = "null as `$field`";
			}else{
				$returnArray[] = "IFNULL(`$field`,'') as `$field`";
			}
		}

		return implode(' , ', $returnArray);

	}

	public function get_table_data($user, $table_name, $created_by=NULL)
	{
		$this->user = $user;

		if ($this->user->user_role == 3)
		{
			$asha_id = $this->input->post('asha_id');
			if ($asha_id == NULL || trim($asha_id) == "")
			{
				// this means that the request is meant for anm
				$user_id = $this->user->user_id;

			}else{
				// if the asha_id is set, then check if the asha is associated with this anm 
				$ashaArr = $this->get_asha_of_anm($this->user->user_id);
				if (!in_array($asha_id, $ashaArr)) {
					return "ERROR: This asha is not linked with ANM used in login";
				}

				$user_id = $this->get_user_id_from_asha_id($asha_id);
			}
		}
		else if ($this->user->user_role == 2)
		{
			$user_id = $this->user->user_id;
		}
		else if ($this->user->user_role == 11)
		{

			$asha_id = $this->input->post('asha_id');
			if ($asha_id == NULL || trim($asha_id) == "")
			{
				// this means that the request is meant for anm
				return "ERROR: CHC user must supply ASHAID to get data";

			}else{
				// if the asha_id is set, then check if the asha is associated with this anm 
				$ashaArr = $this->get_asha_of_chc($this->user->user_id);
				if (!in_array($asha_id, $ashaArr)) {
					return "ERROR: This asha is not linked with CHC used in login";
				}

				$user_id = $this->get_user_id_from_asha_id($asha_id);
			}

		}
		else
		{
			return "ERROR: This user role is not allowed to download data";
		}

		$content = array();

		$this->db->trans_start();

		if ($created_by == NULL) {
			$created_by = "createdBy";
		}


		if ($this->user->user_role == 11 && in_array($table_name, ["tblhhsurvey", "tblhhfamilymember"])) {
			
			if ($table_name == "tblhhsurvey") {


				$query = "select ".$this->null_to_empty_string($table_name)." from $table_name where HHSurveyGUID in (select distinct HHSurveyGUID from tblncdscreening)";

				
			}else if ($table_name == "tblhhfamilymember") {

				$query = "select ".$this->null_to_empty_string($table_name)." from $table_name where HHSurveyGUID in (select distinct HHSurveyGUID from tblncdscreening)";
				
			}

			$query .= " and $created_by = " . $user_id;

		}else{
			
			$query = "select ".$this->null_to_empty_string($table_name)." from $table_name where $created_by = " . $user_id;

		}

		$uploaded_on = "UploadedOn";
		if ($table_name == "tblchild") {
			$uploaded_on = "uploaded_on";
		}
		$ldownload_date = $this->input->post('lastdownload_date');
		if ($ldownload_date != null && trim($ldownload_date) != "") {
			$query .= " and $uploaded_on >= '" . $ldownload_date . "' ";
		}

		$resultSet = $this->Common_Model->query_data($query);

		$content[$table_name] = $resultSet;
		$this->db->trans_complete();

		if($this->db->trans_status() === FALSE)
		{
			return "ERROR:error in transaction";
		}

		return $content;
	}

	public function get_table_data_by_ashaid($user, $table_name)
	{
		$this->user = $user;

		if (!in_array($this->user->user_role, [2,3,11])) {
			return "ERROR: This user role is now allowed for download";
		}

		if ($this->user->user_role == 3)
		{
			$asha_id = $this->input->post('asha_id');
			if ($asha_id == NULL || trim($asha_id) == "")
			{
				return "ERROR: When logging-in with ANM role, sending of AshaID is mandatory";
			}

			$ashaArr = $this->get_asha_of_anm($this->user->user_id);
			if (!in_array($asha_id, $ashaArr)) 
			{
				return "ERROR: This asha is not linked with ANM used in login";
			}
		}
		else if ($this->user->user_role == 2)
		{
			$asha_id = $this->get_asha_id_from_UserID($this->user->user_id);

		}else if ($this->user->user_role == 11) {
			
			$asha_id = $this->input->post('asha_id');
			if ($asha_id == NULL || trim($asha_id) == "")
			{
				// this means that the request is meant for anm
				return "ERROR: CHC user must supply ASHAID to get data";

			}else{
				// if the asha_id is set, then check if the asha is associated with this anm 
				$ashaArr = $this->get_asha_of_chc($this->user->user_id);
				if (!in_array($asha_id, $ashaArr)) {
					return "ERROR: This asha is not linked with CHC used in login";
				}

				$user_id = $this->get_user_id_from_asha_id($asha_id);
			}
		}

		$content = array();

		$this->db->trans_start();

		if ($table_name == "tblancvisit") {
			$identifier = "ByAshaID";
		}elseif ($table_name == "tblhhsurvey") {
			$identifier = "ServiceProviderID";
		}else{
			$identifier = "AshaID";
		}

		if ($table_name == "tblpregnant_woman" && $this->user->is_temp == "2") {
			$query = "select ".$this->null_to_empty_string($table_name, ["PWImage"])." from $table_name where $identifier = " . $asha_id;
		}else{
			$query = "select ".$this->null_to_empty_string($table_name)." from $table_name where $identifier = " . $asha_id;
		}


		$uploaded_on = "UploadedOn";
		if ($table_name == "tblchild") {
			$uploaded_on = "uploaded_on";
		}
		$ldownload_date = $this->input->post('lastdownload_date');
		if ($ldownload_date != null && trim($ldownload_date) != "") {
			$query .= " and $uploaded_on >= '" . $ldownload_date . "' ";
		}
		
		$resultSet = $this->db->query($query)->result();

		$content[$table_name] = $resultSet;
		$this->db->trans_complete();

		if($this->db->trans_status() === FALSE)
		{
			return "ERROR:error in transaction";
		}

		return $content;
	}

	public function get_question_tables()
	{

		$this->db->trans_start();
		$tables = ["tblmstfpques", "tblmstancques", "tblmstimmunizationques", "tblmstpncques"];

		foreach ($tables as $table) {
			$query = "select ".$this->null_to_empty_string($table)." from $table";
			$content[$table] = $this->Common_Model->query_data($query);
		}

		$this->db->trans_complete();

		if($this->db->trans_status() === FALSE)
		{
			return "ERROR:error in transaction";
		}

		return $content;
	}

	public function PutImage()
	{
		$filebytes = $this->input->post('filebytes');
		$fileName = $this->input->post('fileName');

		if ($filebytes == NULL || trim($filebytes) == '') {
			return "ERROR: image data not sent";
		}

		if ($fileName == NULL || trim($fileName) == '') {
			return "ERROR: Image file name not sent";
		}

		$result = file_put_contents(FCPATH . "datafiles/$fileName", base64_decode($filebytes));
		if ($result == FALSE) {
			return "ERROR: Can not write image";
		}

		return "SUCCESS: Successfully uploaded image";

	}

	public function DownloadFile()
	{
		$FName = $this->input->post('FName');

		if ($FName == NULL || trim($FName) == '') {
			die("ERROR: File name not sent");
		}

		if (!file_exists(FCPATH . "datafiles/$FName")) {
			die("ERROR: File does not exist");
		}

		die(base64_encode(file_get_contents(FCPATH . "datafiles/$FName")));
	}

	private function get_asha_id_from_UserID($UserID)
	{
		$query = "select * from userashamapping where UserID = $UserID";
		return $this->db->query($query)->result()[0]->AshaID;
	}



	public function download_pdf($report_id=NULL)
	{


		$report_list = array(
			1 => "one",
			2 => "two",
			3 => "three",
			4 => "four",
			5 => "five",
			6 => "six",
			7 => "seven",
			8 => "eight",
			9 => "nine",
			10 => "ten",
			11 => "eleven",
		);

		if (isset($report_list[$report_id])) {
			$model = $report_list[$report_id];
		}else{
			return "ERROR: No report model found associated with report_id $report_id";
		}



		$this->load->model("Monthly_asha_report_".$model."_model");


		$content = $this->{"Monthly_asha_report_".$model."_model"}->get_report();
		$html = $this->load->view("print/monthly_asha_report_$model", $content, true);

		$this->load->model('Wkhtmltopdf_model');
		$pdf_url = $this->Wkhtmltopdf_model->export_return_url($html);

		return ["filename" => $pdf_url];
	}

	private function tblincentivesurvey($data)
	{
		$dateFields = $this->get_date_fields(__FUNCTION__);

		foreach ($data as $row) {

			$row = $this->clean_row($row, $dateFields);
			unset($row->UID);

			$this->db->where('IncentiveSurveyGUID', $row->IncentiveSurveyGUID);
			$result = $this->db->get('tblincentivesurvey')->result();
			if (count($result) < 1) {
				// insert
				$this->db->insert('tblincentivesurvey', $row);
			}else{
				// update
				$this->db->where('IncentiveSurveyGUID', $row->IncentiveSurveyGUID);
				$this->db->update('tblincentivesurvey', $row);
			}
		}

	}

	private function tblashaincentivedetail($data)
	{
		$dateFields = $this->get_date_fields(__FUNCTION__);

		foreach ($data as $row) {

			$row = $this->clean_row($row, $dateFields);
			unset($row->UID);

			$this->db->where('IncentiveGUID', $row->IncentiveGUID);
			$result = $this->db->get('tblashaincentivedetail')->result();
			if (count($result) < 1) {
				// insert
				$this->db->insert('tblashaincentivedetail', $row);
			}else{
				// update
				$this->db->where('IncentiveGUID', $row->IncentiveGUID);
				$this->db->update('tblashaincentivedetail', $row);
			}
		}

	}

	private function tblncdcbacdiagnosis($data)
	{
		$dateFields = $this->get_date_fields(__FUNCTION__);

		foreach ($data as $row) {

			$row = $this->clean_row($row, $dateFields);
			unset($row->UID);

			$this->db->where('NCDScreeningGUID', $row->NCDScreeningGUID);
			$this->db->where('NCD_id', $row->NCD_id);

			$result = $this->db->get('tblncdcbacdiagnosis')->result();
			if (count($result) < 1) {
				// insert
				$this->db->insert('tblncdcbacdiagnosis', $row);
			}else{
				// update
				$this->db->where('NCDScreeningGUID', $row->NCDScreeningGUID);
				$this->db->where('NCD_id', $row->NCD_id);
				$this->db->update('tblncdcbacdiagnosis', $row);
			}
		}

	}

	private function tblafverify($data)
	{
		$dateFields = $this->get_date_fields(__FUNCTION__);

		foreach ($data as $row) {

			$row = $this->clean_row($row, $dateFields);
			unset($row->UID);

			$this->db->where('ModuleGUID', $row->ModuleGUID);

			$result = $this->db->get('tblafverify')->result();
			if (count($result) < 1) {
				// insert
				$this->db->insert('tblafverify', $row);
			}else{
				// update
				$this->db->where('ModuleGUID', $row->ModuleGUID);
				$this->db->update('tblafverify', $row);
			}
		}

	}

	private function tblashaclaim($data)
	{
		$dateFields = $this->get_date_fields(__FUNCTION__);

		foreach ($data as $row) {

			$row = $this->clean_row($row, $dateFields);
			unset($row->UID);

			$this->db->where('ClaimGUID', $row->ClaimGUID);

			$result = $this->db->get('tblashaclaim')->result();
			if (count($result) < 1) {
				// insert
				$this->db->insert('tblashaclaim', $row);
			}else{
				// update
				$this->db->where('ClaimGUID', $row->ClaimGUID);
				$this->db->update('tblashaclaim', $row);
			}
		}

	}

	public function get_af_data()
	{
		$asha_id = $this->input->post('asha_id');
		
		$query = "select PWGUID from tblpregnant_woman where UploadedOn BETWEEN CURRENT_DATE - INTERVAL 1 MONTH and CURRENT_DATE and AshaID = ?
		union 
		select PWGUID from tblancvisit where UploadedOn BETWEEN CURRENT_DATE - INTERVAL 1 MONTH and CURRENT_DATE and ByAshaID = ?
		union 
		select pw_GUID from tblchild where uploaded_on BETWEEN CURRENT_DATE - INTERVAL 1 MONTH and CURRENT_DATE and AshaID = ?
		union
		select b.pw_GUID from tblpnchomevisit_ans a 
		inner join tblchild b 
		on a.ChildGUID = b.childGUID
		where a.UploadedOn BETWEEN CURRENT_DATE - INTERVAL 1 MONTH and CURRENT_DATE and a.AshaID = ?";
		$pg_list = $this->db->query($query, [$asha_id, $asha_id, $asha_id, $asha_id])->result();

		$pw_guid_arr = [];
		foreach ($pg_list as $row) {
			$pw_guid_arr[] = $row->PWGUID;
		}

		$query = "select * from tblpregnant_woman where PWGUID in ('".implode("','", $pw_guid_arr)."')";
		$content['tblpregnant_woman'] = $this->db->query($query)->result();

		$query = "select * from tblancvisit  where PWGUID in ('".implode("','", $pw_guid_arr)."')";
		$content['tblancvisit'] = $this->db->query($query)->result();
		
		$query = "select * from tblchild where pw_GUID in ('".implode("','", $pw_guid_arr)."')";
		$content['tblchild'] = $this->db->query($query)->result();

		$query = "select a.* from tblpnchomevisit_ans a 
		inner join tblchild b 
		on a.ChildGUID = b.childGUID
		where b.pw_GUID in ('".implode("','", $pw_guid_arr)."')";
		$content['tblpnchomevisit_ans'] = $this->db->query($query)->result();

		$query = "select b.* from tblpregnant_woman a 
		inner join tblhhsurvey b 
		on a.HHGUID = b.HHSurveyGUID
		where a.PWGUID in ('".implode("','", $pw_guid_arr)."')";
		$content['tblhhsurvey'] = $this->db->query($query)->result();

		$query = "select b.* from tblpregnant_woman a 
		inner join tblhhfamilymember b 
		on a.HHGUID = b.HHSurveyGUID
		where a.PWGUID in ('".implode("','", $pw_guid_arr)."')";
		$content['tblhhfamilymember'] = $this->db->query($query)->result();

		$this->db->where('ASHAID', $asha_id);
		$content['tblafverify'] = $this->db->get('tblafverify')->result();

		return $content;

	}

}
