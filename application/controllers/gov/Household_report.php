<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Household_report extends Gov_Controller {

	public function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{	
		$content['subview'] = "list_household_report";
		$this->load->view('gov/main_layout', $content);
	}

	public function ashadetails($ANMCode = NULL , $export_ashadetails = NULL)
	{
		$query = "select asha.ANMCode,asha.ASHAID,asha.ASHAName, b.hh_count, c.fm_count, d.hh_verified,  f.population_verified, (f.population_verified / c.fm_count ) * 100 as percent_population_verified, (d.hh_verified / b.hh_count ) * 100 as Score, g.new_household from mstasha asha
		left join 
		(select count(*)  as hh_count, ServiceProviderID from tblhhsurvey group by ServiceProviderID) b 
		on b.ServiceProviderID = asha.ASHAID
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
		where asha.LanguageID = 1 and asha.ANMCode = $ANMCode ";

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

		$content['subview'] = "list_household_report_asha";
		$this->load->view('gov/main_layout', $content);

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
		where anm.LanguageID = 1";

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
		where anm.LanguageID = 1";

		$this->load->model('Data_export_model');
		$this->Data_export_model->export_pdf($query);
	}

} 
