<?php 

/**
* Dashboard4 model for process indicators
*/
class Dashboard4_model extends Ci_model
{
	
	public function __construct()
	{
		parent::__construct();
		$this->filter_data = $this->session->userdata('filter_data_list');
		$this->loginData = $this->session->userdata('loginData');
	}
	public function get_process_indicators_counts()
	{

		$query = "
		select 
		a.*, 
		ifnull(aa.total,0) as hh_records_created, 
		ifnull(b.total,0) as hh_records_updated, 
		ifnull(bb.total,0) as hh_records_uploaded,
		ifnull(c.total,0) as anc_checkup_created,
		ifnull(ac.total,0) as anc_checkup_updated,
		ifnull(bc.total,0) as anc_checkup_uploaded,
		ifnull(d.total,0) as new_pregnancies_added,
		ifnull(ad.total,0) as new_pregnancies_updated,
		ifnull(bd.total,0) as new_pregnancies_uploaded,
		ifnull(e.total,0) as anc_checkups_added_updated,
		ifnull(f.total,0) as new_child_added,
		ifnull(af.total,0) as child_uploaded,
		ifnull(g.total,0) as existing_child_updated,
		ifnull(h.total,0) as immunuzation_counselling_done,
		ifnull(i.total,0) as anc_homevisit_done,
		ifnull(j.total,0) as pnc_homevisit_done,
		ifnull(k.total,0) as fp_followup_done,
		ifnull(l.total,0) as fp_counselling_done,
		ifnull(b.total,0) as updates_household_details,
		ifnull(c.total,0) + ifnull(k.total,0) as updates_mnch_module,
		ifnull(i.total,0) as updates_mnch_anc_module,
		ifnull(f.total,0) as updates_mnch_newborn,
		ifnull(e.total,0) + ifnull(j.total,0) as updates_mnch_homevisit,
		ifnull(k.total,0) + ifnull(l.total,0) as updates_fp_module,
		m.user_name as anm_login_id,
		ifnull(n.total,0) as ncd_cbac_update,
		ifnull(o.total,0) as ncd_cbac_uploads,
		ifnull(p.total,0) as ncd_followup_updates,
		ifnull(q.total,0) as ncd_followup_uploads,
		ifnull(p.total,0) as ncd_screening_updates,
		ifnull(p.total,0) as ncd_screening_uploads
		from (select a.ASHAName, n.ANMName, a.ASHAID, n.ANMID, tu.user_name from mstasha a 
		inner join anmasha m 
		on m.ASHAID = a.ASHAID and a.LanguageID = 1 and a.IsActive=1 ";

		if (is_array($this->filter_data['Asha']) && count($this->filter_data['Asha']) > 0) {
			$query .= " and a.ASHAID in (". implode(",", $this->filter_data['Asha']) .")";
		}

		$query .=" inner join mstanm n 
		on n.ANMID = m.ANMID and n.LanguageID = 1 and n.IsActive = 1 ";

		if (is_array($this->filter_data['ANM']) && count($this->filter_data['ANM']) > 0) {
			$query .= " and n.ANMID in (" . implode(",",$this->filter_data['ANM']) .")";
		}

		$query .= " inner join userashamapping ua 
		on ua.AshaID = a.ASHAID 
		inner join tblusers tu 
		on ua.UserID = tu.user_id
		where tu.user_mode=1 ";

		if ($this->loginData->user_role == 5 && count($this->filter_data['State'])>0) {
			$query .= "	and tu.state_code in (" . implode(",",$this->filter_data['State']) .")";
		}
		else if ($this->loginData->user_role == 6 || $this->loginData->user_role == 10) 
		{
			$state_code = $this->loginData->state_code;
			$query .= " and tu.state_code = '$state_code'";	
		}
		else if ($this->loginData->user_role == 7 || $this->loginData->user_role == 11) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$query .= " and tu.state_code = '$state_code' and tu.district_code='$district_code'";	
		}
		else if ($this->loginData->user_role == 8 || $this->loginData->user_role == 12) 
		{
			$state_code = $this->loginData->state_code;
			$district_code = $this->loginData->district_code;
			$block_code = $this->loginData->block_code;
			$query .= " and tu.state_code = '$state_code' and tu.district_code='$district_code' and tu.block_code='$block_code'";	
		}

		$query .= "	group by n.ANMID, a.ASHAID) a 
		left join 
		(SELECT s.ServiceProviderID, count(*) as total FROM `tblhhsurvey` s 
		where 1=1 ";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and (s.CreatedOn >= '" . $this->filter_data['date_from'] . "' and s.CreatedOn <= '" . $this->filter_data['date_to'] . "')";
		}else{
			$query .= " and s.CreatedOn is not null ";
		}

		$query .= " group by s.ServiceProviderID) aa
		on a.ASHAID = aa.ServiceProviderID
		left join
		(SELECT s.ServiceProviderID, count(*) as total FROM `tblhhsurvey` s 
		where 1=1";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and (s.UpdatedOn >= '" . $this->filter_data['date_from'] . "' and s.UpdatedOn <= '" . $this->filter_data['date_to'] . "')";
		}else{
			$query .= " and s.UpdatedOn is not null ";
		}

		$query .= " group by s.ServiceProviderID) b 
		on a.ASHAID = b.ServiceProviderID
		left join
		(SELECT s.ServiceProviderID, count(*) as total FROM `tblhhsurvey` s 
		where 1=1 ";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and (s.UploadedOn >= '" . $this->filter_data['date_from'] . "' and s.UploadedOn <= '" . $this->filter_data['date_to'] . "')";
		}else{
			$query .= " and s.UploadedOn is not null ";
		}

		$query .= " group by s.ServiceProviderID) bb
		on a.ASHAID = bb.ServiceProviderID
		left join 
		(SELECT v.ByAshaID, count(*) as total from tblancvisit v 
		where ";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= "  (v.CreatedOn >= '" . $this->filter_data['date_from'] . "' and v.CreatedOn <= '" . $this->filter_data['date_to'] . "')";
		}else{
			$query .= "  v.CreatedOn is not null ";
		}

		$query .= " group by v.ByAshaID) c 
		on a.ASHAID = c.ByAshaID
		left join 
		(SELECT v.ByAshaID, count(*) as total from tblancvisit v 
		where v.CheckupVisitDate is not null";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and (v.UpdatedOn >= '" . $this->filter_data['date_from'] . "' and v.UpdatedOn <= '" . $this->filter_data['date_to'] . "')";
		}else{
			$query .= " and v.UpdatedOn is not null ";
		}

		$query .= " group by v.ByAshaID) ac 
		on a.ASHAID = ac.ByAshaID
		left join 
		(SELECT v.ByAshaID, count(*) as total from tblancvisit v 
		where v.CheckupVisitDate is not null";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and (v.UploadedOn >= '" . $this->filter_data['date_from'] . "' and v.UploadedOn <= '" . $this->filter_data['date_to'] . "')";
		}else{
			$query .= " and v.UploadedOn is not null ";
		}

		$query .= " group by v.ByAshaID) bc 
		on a.ASHAID = bc.ByAshaID
		left join(
		select pw.AshaID, count(*) as total from tblpregnant_woman pw 
		where 1=1";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and (pw.CreatedOn >= '" . $this->filter_data['date_from'] . "' and pw.CreatedOn <= '" . $this->filter_data['date_to'] . "')";
		}else{
			$query .= " and pw.CreatedOn is not null ";
		}

		$query .= " group by pw.AshaID)d
		on a.ASHAID = d.AshaID
		left join(
		select pw.AshaID, count(*) as total from tblpregnant_woman pw 
		where 1=1";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and (pw.UpdatedOn >= '" . $this->filter_data['date_from'] . "' and pw.UpdatedOn <= '" . $this->filter_data['date_to'] . "')";
		}else{
			$query .= " and pw.UpdatedOn is not null ";
		}

		$query .= " group by pw.AshaID)ad
		on a.ASHAID = ad.AshaID
		left join(
		select pw.AshaID, count(*) as total from tblpregnant_woman pw 
		where 1=1";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and (pw.UploadedOn >= '" . $this->filter_data['date_from'] . "' and pw.UploadedOn <= '" . $this->filter_data['date_to'] . "')";
		}else{
			$query .= " and pw.UploadedOn is not null ";
		}

		$query .= " group by pw.AshaID)bd
		on a.ASHAID = bd.AshaID
		left join (
		select ByAshaID, count(*) as total from tblancvisit v 
		where v.CheckupVisitDate is not null";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and ((v.UpdatedOn >= '" . $this->filter_data['date_from'] . "' and v.UpdatedOn <= '" . $this->filter_data['date_to'] . "')";
			$query .= " or (v.CreatedOn >= '" . $this->filter_data['date_from'] . "' and v.CreatedOn <= '" . $this->filter_data['date_to'] . "'))";
		}else{
			$query .= " and v.UpdatedOn is not null ";
			$query .= " and v.CreatedOn is not null ";
		}

		$query .= " group by v.ByAshaID)e 
		on a.ASHAID = e.ByAshaID
		left join (
		select c.AshaID, count(*) as total from tblchild c
		where 1=1";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and (c.created_on >= '" . $this->filter_data['date_from'] . "' and c.created_on <= '" . $this->filter_data['date_to'] . "')";
		}else{
			$query .= " and c.created_on is not null ";
		}

		$query .= " group by c.AshaID)f
		on a.ASHAID = f.AshaID
		left join (
		select c.AshaID, count(*) as total from tblchild c
		where 1=1";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and (c.uploaded_on >= '" . $this->filter_data['date_from'] . "' and c.uploaded_on <= '" . $this->filter_data['date_to'] . "')";
		}else{
			$query .= " and c.uploaded_on is not null ";
		}


		$query .= " group by c.AshaID)af
		on a.ASHAID = af.AshaID
		left join (
		select c.AshaID, count(*) as total from tblchild c
		where 1=1";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and (c.modified_on >= '" . $this->filter_data['date_from'] . "' and c.modified_on <= '" . $this->filter_data['date_to'] . "')";
		}else{
			$query .= " and c.modified_on is not null ";
		}

		$query .= " group by c.AshaID)g
		on a.ASHAID = g.AshaID
		left join (
		select i.AshaID, count(*) as total from tblmstimmunizationans i
		where 1=1";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and ((i.CreatedOn >= '" . $this->filter_data['date_from'] . "' and i.CreatedOn <= '" . $this->filter_data['date_to'] . "')";
			$query .= " or (i.UpdatedOn >= '" . $this->filter_data['date_from'] . "' and i.UpdatedOn <= '" . $this->filter_data['date_to'] . "'))";
		}

		$query .= " group by i.AshaID)h 
		on a.ASHAID = h.AshaID
		left join (
		select v.ByAshaID, count(*) as total from tblancvisit v 
		where v.HomeVisitDate is not null";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and ((v.CreatedOn >= '" . $this->filter_data['date_from'] . "' and v.CreatedOn <= '" . $this->filter_data['date_to'] . "')";
			$query .= " or (v.UpdatedOn >= '" . $this->filter_data['date_from'] . "' and v.UpdatedOn <= '" . $this->filter_data['date_to'] . "'))";
		}

		$query .= " group by v.ByAshaID)i 
		on a.ASHAID = i.ByAshaID
		left join (
		select AshaID, count(*) as total from tblpnchomevisit_ans p 
		where 1=1";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and ((p.CreatedOn >= '" . $this->filter_data['date_from'] . "' and p.CreatedOn <= '" . $this->filter_data['date_to'] . "')";
			$query .= " or (p.UpdatedOn >= '" . $this->filter_data['date_from'] . "' and p.UpdatedOn <= '" . $this->filter_data['date_to'] . "'))";
		}

		$query .= " group by p.AshaID)j 
		on a.ASHAID = j.AshaID
		left join (
		select AshaID, count(*) as total from tblfp_followup a 
		where 1=1";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and (a.CreatedOn >= '" . $this->filter_data['date_from'] . "' and a.CreatedOn <= '" . $this->filter_data['date_to'] . "')";
		}

		$query .= " group by a.AshaID)k 
		on a.ASHAID = k.AshaID
		left join (
		select a.AshaID, count(*) as total from tblfp_visit a 
		where 1=1";

		if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
		{
			$query .= " and (a.CreatedOn >= '" . $this->filter_data['date_from'] . "' and a.CreatedOn <= '" . $this->filter_data['date_to'] . "')";
		}

		$query .= " group by a.AshaID)l 
		on a.ASHAID = l.AshaID
		left join (
		select a.user_id, a.user_name, b.ANMID, c.ASHAID as AshaID from tblusers a 
		inner join useranmmapping b
		on a.user_id = b.UserID and a.user_role = 3
		inner join anmasha c 
		on b.ANMID = c.ANMID
		)m 
		on a.ASHAID = m.AshaID ";

		$query .= " LEFT JOIN(
    SELECT ashaid,
        COUNT(*) AS total
    FROM
        tblncdcbac
    WHERE
        UpdatedBy IS NOT NULL ";

        if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
        {
        	$query .= " and ((CreatedOn >= '" . $this->filter_data['date_from'] . "' and CreatedOn <= '" . $this->filter_data['date_to'] . "')";
        	$query .= " or (UpdatedOn >= '" . $this->filter_data['date_from'] . "' and UpdatedOn <= '" . $this->filter_data['date_to'] . "'))";
        }
   $query .=" GROUP BY
        ashaid
) n
ON
    a.ASHAID = n.ashaid";

    $query .= " LEFT JOIN(
    SELECT ashaid,
        COUNT(*) AS total
    FROM
        tblncdcbac
    WHERE
        UploadedBy IS NOT NULL ";

        if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
        {
        	$query .= " and ((CreatedOn >= '" . $this->filter_data['date_from'] . "' and CreatedOn <= '" . $this->filter_data['date_to'] . "')";
        	$query .= " or (UploadedOn >= '" . $this->filter_data['date_from'] . "' and UploadedOn <= '" . $this->filter_data['date_to'] . "'))";
        }
   $query .=" GROUP BY
        ashaid
) o
ON
    a.ASHAID = o.ashaid";


    		$query .= " LEFT JOIN(
        SELECT ashaid,
            COUNT(*) AS total
        FROM
            tblncdfollowup
        WHERE
            UpdatedBy IS NOT NULL ";

            if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
            {
            	$query .= " and ((CreatedOn >= '" . $this->filter_data['date_from'] . "' and CreatedOn <= '" . $this->filter_data['date_to'] . "')";
            	$query .= " or (UpdatedOn >= '" . $this->filter_data['date_from'] . "' and UpdatedOn <= '" . $this->filter_data['date_to'] . "'))";
            }
       $query .=" GROUP BY
            ashaid
    ) p
    ON
        a.ASHAID = p.ashaid";


            $query .= " LEFT JOIN(
            SELECT ashaid,
                COUNT(*) AS total
            FROM
                tblncdfollowup
            WHERE
                UploadedBy IS NOT NULL ";

                if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
                {
                	$query .= " and ((CreatedOn >= '" . $this->filter_data['date_from'] . "' and CreatedOn <= '" . $this->filter_data['date_to'] . "')";
                	$query .= " or (UploadedOn >= '" . $this->filter_data['date_from'] . "' and UploadedOn <= '" . $this->filter_data['date_to'] . "'))";
                }
           $query .=" GROUP BY
                ashaid
        ) q
        ON
            a.ASHAID = q.ashaid";



            		$query .= " LEFT JOIN(
                SELECT ashaid,
                    COUNT(*) AS total
                FROM
                    tblncdscreening
                WHERE
                    UpdatedBy IS NOT NULL ";

                    if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
                    {
                    	$query .= " and ((CreatedOn >= '" . $this->filter_data['date_from'] . "' and CreatedOn <= '" . $this->filter_data['date_to'] . "')";
                    	$query .= " or (UpdatedOn >= '" . $this->filter_data['date_from'] . "' and UpdatedOn <= '" . $this->filter_data['date_to'] . "'))";
                    }
               $query .=" GROUP BY
                    ashaid
            ) r
            ON
                a.ASHAID = r.ashaid";


                    $query .= " LEFT JOIN(
                    SELECT ashaid,
                        COUNT(*) AS total
                    FROM
                        tblncdscreening
                    WHERE
                        UploadedBy IS NOT NULL ";

                        if ($this->filter_data['date_from'] != NULL && $this->filter_data['date_to'] != NULL)
                        {
                        	$query .= " and ((CreatedOn >= '" . $this->filter_data['date_from'] . "' and CreatedOn <= '" . $this->filter_data['date_to'] . "')";
                        	$query .= " or (UploadedOn >= '" . $this->filter_data['date_from'] . "' and UploadedOn <= '" . $this->filter_data['date_to'] . "'))";
                        }
                   $query .=" GROUP BY
                        ashaid
                ) s
                ON
                    a.ASHAID = s.ashaid";

		// die($query);

		return $this->db->query($query)->result();
	}

	public function get_anm_name_by_id($anmid = NULL)
	{
		$this->db->where('ANMID', $anmid);
		$this->db->where('LanguageID', 1);
		$anm_result = $this->db->get('mstanm')->result();
		if (count($anm_result) < 1) {
			return '';
		}

		return $anm_result[0]->ANMName;
	}

	public function get_asha_name_by_id($ashaid = NULL)
	{
		$this->db->where('ASHAID', $ashaid);
		$this->db->where('LanguageID', 1);
		$this->db->where('IsActive', 1);
		$anm_result = $this->db->get('mstasha')->result();
		if (count($anm_result) < 1) {
			return '';
		}

		return $anm_result[0]->ASHAName;
	}

	public function get_state_by_code($code = ''){
		$this->db->where(array('StateCode'=>$code,'LanguageID'=>1,'IsDeleted'=>0));
		return $this->db->get('mststate')->row('StateName');
	}

}
