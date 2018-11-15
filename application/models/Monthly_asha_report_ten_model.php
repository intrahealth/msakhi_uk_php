<?php  

class Monthly_asha_report_ten_model extends Ci_model 
{
	public function __construct()
	{

	}

	public function get_report()
	{
			$ASHAID = $this->input->post('ashaid');
			$query = "SELECT
		     child_name,
		    bcg,
		    opv1,
		    Pentavalent1,
		    opv2,
		    Pentavalent2,
		    opv3,
		    Pentavalent3,
		    measeals,
		    vitaminA,
		    MeaslesRubella
		FROM
		    `tblchild`
		WHERE
		    IsDeleted = 0 AND AshaID = ? AND child_dob > '".$this->input->post('date_from')."' and child_dob < '".$this->input->post('date_to')."'";

		    $content['RCH_immunization'] = $this->db->query($query, [$ASHAID])->result();

		    return $content;
	}
}