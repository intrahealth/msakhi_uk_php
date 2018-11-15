<?php 

class Monthly_asha_report_three_model extends Ci_model
{
	public function __construct()
	{

	}


	public function get_report()
	{
		$ASHAID = $this->input->post('ashaid');

        $query = "SELECT a.*, c.ANMName, e.SubCenterName from (
        SELECT
        a.ASHAID,
        a.ASHAName,
        group_concat(c.VillageName) as Villages
        FROM
        mstasha a
        left JOIN ashavillage b ON
        a.ASHAID = b.ASHAID
        inner join mstvillage c 
        on b.VillageID = c.VillageID and c.LanguageID = 2
        where a.LanguageID = 2 and a.IsActive = 1
        group by a.ASHAID)a 
        left join anmasha b 
        on a.ASHAID = b.ASHAID
        left join mstanm c 
        on b.ANMID = c.ANMID and c.LanguageID = 2 and c.IsActive = 1
        left join anmsubcenter d 
        on c.ANMID = d.ANMID 
        left join mstsubcenter e 
        on d.SubCenterID = e.SubCenterID and e.LanguageID = 2
        where a.ASHAID = ?";

        $result = $this->db->query($query, [$ASHAID])->result();

        if (count($result) < 1) {
            die("ERROR: No ASHA record found with this ASHAID = $ASHAID");
        }

        $content['asha_data'] = $result[0];

	$query = "select a.*, b.total as first,c.total as second,d.total as third,e.total as fourth, f.total as fifth, g.total as sixth, h.total as sevemth from 
(SELECT
    b.FamilyMemberName,
    a.MotherMCTSID,
    e.VillageName,
    c.child_dob,
    c.place_of_birth,
    c.childGUID,
    a.HHFamilyMemberGUID,
    a.AshaID,
    a.ANMID
FROM
    tblpregnant_woman a
INNER JOIN tblhhfamilymember b ON
    a.HHFamilyMemberGUID = b.HHFamilyMemberGUID
INNER JOIN tblchild c ON
    b.HHFamilyMemberGUID = c.HHFamilyMemberGUID
INNER JOIN tblhhsurvey d ON
    b.HHSurveyGUID = d.HHSurveyGUID
INNER JOIN mstvillage e ON
    d.VillageID = e.VillageID AND e.LanguageID = 1
whERE
    a.IsDeleted = 0 AND b.IsDeleted = 0 AND c.IsDeleted = 0 AND d.IsDeleted = 0 AND e.IsDeleted = 0 AND a.IsPregnant = 0  AND 
        a.LMPDate > '".$this->input->post('date_from')."' and a.LMPDate < '".$this->input->post('date_to')."' )a 
left join 
(
    select count(*) as total,ChildGUID from tblpnchomevisit_ans where VisitNo=1 group by ChildGUID
)b 
on a.childGUID = b.childGUID
left join 
(
    select count(*) as total,ChildGUID from tblpnchomevisit_ans where VisitNo=2 group by ChildGUID
)c
on a.childGUID = c.childGUID
left join 
(
    select count(*) as total,ChildGUID from tblpnchomevisit_ans where VisitNo=3 group by ChildGUID
)d
on a.childGUID = d.childGUID
left join 
(
    select count(*) as total,ChildGUID from tblpnchomevisit_ans where VisitNo=4 group by ChildGUID
)e
on a.childGUID = e.childGUID
left join 
(
    select count(*) as total,ChildGUID from tblpnchomevisit_ans where VisitNo=5 group by ChildGUID
)f
on a.childGUID = f.childGUID
left join 
(
    select count(*) as total,ChildGUID from tblpnchomevisit_ans where VisitNo=6 group by ChildGUID
)g
on a.childGUID = g.childGUID
left join 
(
    select count(*) as total,ChildGUID from tblpnchomevisit_ans where VisitNo=7 group by ChildGUID
)h
on a.childGUID = h.childGUID
where a.AshaID = ?
order by a.HHFamilyMemberGUID";

$content['pnc_home_visit']=$this->db->query($query, [$ASHAID])->result();
return $content;
	}
}