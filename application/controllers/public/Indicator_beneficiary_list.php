<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Indicator_beneficiary_list extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Common_Model');
	}

	public function preg_women_reg_first_trimester($ashacode)
	{	

		$query = "SELECT PWName FROM `tblpregnant_woman` inner join mstasha on mstasha.ASHAID = tblpregnant_woman.ASHAID and mstasha.LanguageID = 1 where Regwithin12weeks=1 and tblpregnant_woman.ASHAID = $ashacode";

		$content['ben_list'] = $this->db->query($query)->result();
		$content['indicator_name'] = "Proportion of pregnant Women Registered in the First Trimester";
		$content['indicator'] = "preg_women_reg_first_trimester";
		$content['subview'] = "indicator_beneficiary_list";
		$this->load->view('public/main_layout', $content);
	}


	public function institutional_delivery($ashacode)
	{	

		$query = "SELECT
		PWName
		FROM
		`tblpregnant_woman`
		WHERE
		DeliveryPlace = 2 and ASHAID = $ashacode";

		$content['ben_list'] = $this->db->query($query)->result();
		$content['indicator_name'] = "Proportion of institutional deliveries";
		$content['indicator'] = "institutional_delivery";
		$content['subview'] = "indicator_beneficiary_list";
		$this->load->view('public/main_layout', $content);
	}

	public function one_anc_checkup($ashacode)
	{

		$query = "SELECT w.PWNAME as PWName FROM `tblancvisit` c inner join tblpregnant_woman w on c.pwguid = w.PWGUID where CheckupVisitDate is not null and w.ASHAID = $ashacode group by c.PWGUID, c.ByAshaID having count(*) = 1
		";	

		$content['ben_list'] = $this->db->query($query)->result();
		$content['indicator_name'] = "Proportion of pregnant women with 1 ANC check-up";
		$content['indicator'] = "one_anc_checkup";
		$content['subview'] = "indicator_beneficiary_list";
		$this->load->view('public/main_layout', $content);
	}


	public function low_birth_weight($ashacode)
	{	

		$query = "SELECT w.PWNAME as PWName FROM `tblchild` c inner join tblpregnant_woman w on c.pw_guid = w.PWGUID  WHERE Wt_of_child < 2.5 and w.ASHAID = $ashacode";

		$content['ben_list'] = $this->db->query($query)->result();
		$content['indicator_name'] = "Low Birth Weight";
		$content['indicator'] = "low_birth_weight";
		$content['subview'] = "indicator_beneficiary_list";
		$this->load->view('public/main_layout', $content);
	}

	public function two_anc_checkup($ashacode)
	{

		$query = "SELECT w.PWNAME as PWName FROM `tblancvisit` c inner join tblpregnant_woman w on c.pwguid = w.PWGUID where CheckupVisitDate is not null and w.ASHAID = $ashacode group by c.PWGUID, c.ByAshaID having count(*) = 2
		";	

		$content['ben_list'] = $this->db->query($query)->result();
		$content['indicator_name'] = "Proportion of pregnant women with 2 ANC check-up";
		$content['indicator'] = "two_anc_checkup";
		$content['subview'] = "indicator_beneficiary_list";
		$this->load->view('public/main_layout', $content);
	}


	public function three_anc_checkup($ashacode)
	{

		$query = "SELECT w.PWNAME as PWName FROM `tblancvisit` c inner join tblpregnant_woman w on c.pwguid = w.PWGUID where CheckupVisitDate is not null and w.ASHAID = $ashacode group by c.PWGUID, c.ByAshaID having count(*) = 3
		";	

		$content['ben_list'] = $this->db->query($query)->result();
		$content['indicator_name'] = "Proportion of pregnant women with 3 ANC check-up";
		$content['indicator'] = "three_anc_checkup";
		$content['subview'] = "indicator_beneficiary_list";
		$this->load->view('public/main_layout', $content);
	}

	public function four_anc_checkup($ashacode)
	{

		$query = "SELECT w.PWNAME as PWName FROM `tblancvisit` c inner join tblpregnant_woman w on c.pwguid = w.PWGUID where CheckupVisitDate is not null and w.ASHAID = $ashacode group by c.PWGUID, c.ByAshaID having count(*) = 4
		";	

		$content['ben_list'] = $this->db->query($query)->result();
		$content['indicator_name'] = "Proportion of pregnant women with 4 ANC check-up";
		$content['indicator'] = "four_anc_checkup";
		$content['subview'] = "indicator_beneficiary_list";
		$this->load->view('public/main_layout', $content);
	}

	public function tt2_booster($ashacode)
	{

		$query = "SELECT w.PWName as PWName from 
		(SELECT PWGUID FROM `tblancvisit` where TT2=1 or TTbooster=1 group by PWGUID having count(*) > 0)a
		inner join tblpregnant_woman w 
		on w.PWID = a.PWGUID 
		where w.ASHAID = $ashacode
		";

		$content['ben_list'] = $this->db->query($query)->result();
		$content['indicator_name'] = "Proportion of pregnant women who received  TT2  or Booster";
		$content['indicator'] = "tt2_booster";
		$content['subview'] = "indicator_beneficiary_list";
		$this->load->view('public/main_layout', $content);
	}
	
}