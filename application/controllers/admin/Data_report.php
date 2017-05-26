<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_report extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{	
		$content['subview'] = "list_data_report";
		$this->load->view('admin/main_layout', $content);
	}

	public function export_csv()
	{
		$query= "select
		asha.ASHAID,
		asha.ASHAName,
		sc.SubCenterName,
		u.user_name,
		b.hh_count AS hh_updated,
		c.pregnancies,
		d.anc_visits,
		f.child_births,
		g.pnc_visits,
		h.immunizationANS

		FROM
		mstasha asha
		LEFT JOIN 
		userashamapping ua on ua.AshaID = asha.ASHAID and asha.LanguageID= 1
		LEFT JOIN
		tblusers u on u.user_id = ua.UserID
		LEFT JOIN
		mstsubcenter sc on sc.SubCenterCode = asha.SubCenterCode and sc.LanguageID = 1

		LEFT JOIN
		(
		SELECT COUNT(*) AS hh_count,
		tblhhsurvey.ServiceProviderID AS ashaid
		FROM
		tblhhsurvey
		WHERE
		tblhhsurvey.UploadedOn BETWEEN '2017-02-01' AND '2017-02-28'
		GROUP BY
		tblhhsurvey.ServiceProviderID
		) b ON b.ashaid = asha.ashaid
		LEFT JOIN
		(
		SELECT COUNT(*) AS pregnancies,
		pw.AshaID AS ashaid
		FROM
		tblpregnant_woman pw
		WHERE
		pw.PWRegistrationDate BETWEEN '2017-02-01' AND '2017-02-28'
		GROUP BY
		pw.AshaID
		) c ON c.ashaid = asha.ashaid
		LEFT JOIN
		(
		SELECT COUNT(*) AS anc_visits,
		v.ByAshaID AS ashaid
		FROM
		tblancvisit v
		WHERE
		v.CheckupVisitDate BETWEEN '2017-02-01' AND '2017-02-28'
		GROUP BY
		v.ByAshaID
		) d ON d.ashaid = asha.ashaid
		LEFT JOIN
		(
		SELECT COUNT(*) AS child_births,
		c.AshaID AS ashaid
		FROM
		tblchild c
		WHERE
		c.child_dob BETWEEN '2017-02-01' AND '2017-02-28'
		GROUP BY
		c.AshaID
		) f ON f.ashaid = asha.ashaid
		LEFT JOIN
		(
		SELECT COUNT(*) AS pnc_visits,
		p.AshaID AS ashaid
		FROM
		tblpnchomevisit_ans p
		WHERE
		p.UpdatedOn BETWEEN '2017-02-01' AND '2017-02-28'
		GROUP BY
		p.AshaID
		) g ON g.ashaid = asha.ashaid
		LEFT JOIN
		(
		SELECT COUNT(*) AS immunizationANS,
		i.AshaID AS ashaid
		FROM
		tblmstimmunizationANS i
		WHERE
		i.CreatedOn BETWEEN '2017-02-01' AND '2017-02-28'
		GROUP BY
		i.AshaID
		) h ON h.ashaid = asha.ashaid
		WHERE
		asha.LanguageID = 1";

		$this->load->model('Data_export_model');
		$this->Data_export_model->export_csv($query);
	}

	public function export_pdf()
	{
		$query= "select
		asha.ASHAID,
		asha.ASHAName,
		sc.SubCenterName,
		u.user_name,
		b.hh_count AS hh_updated,
		c.pregnancies,
		d.anc_visits,
		f.child_births,
		g.pnc_visits,
		h.immunizationANS

		FROM
		mstasha asha
		LEFT JOIN 
		userashamapping ua on ua.AshaID = asha.ASHAID and asha.LanguageID= 1
		LEFT JOIN
		tblusers u on u.user_id = ua.UserID
		LEFT JOIN
		mstsubcenter sc on sc.SubCenterCode = asha.SubCenterCode and sc.LanguageID = 1

		LEFT JOIN
		(
		SELECT COUNT(*) AS hh_count,
		tblhhsurvey.ServiceProviderID AS ashaid
		FROM
		tblhhsurvey
		WHERE
		tblhhsurvey.UploadedOn BETWEEN '2017-02-01' AND '2017-02-28'
		GROUP BY
		tblhhsurvey.ServiceProviderID
		) b ON b.ashaid = asha.ashaid
		LEFT JOIN
		(
		SELECT COUNT(*) AS pregnancies,
		pw.AshaID AS ashaid
		FROM
		tblpregnant_woman pw
		WHERE
		pw.PWRegistrationDate BETWEEN '2017-02-01' AND '2017-02-28'
		GROUP BY
		pw.AshaID
		) c ON c.ashaid = asha.ashaid
		LEFT JOIN
		(
		SELECT COUNT(*) AS anc_visits,
		v.ByAshaID AS ashaid
		FROM
		tblancvisit v
		WHERE
		v.CheckupVisitDate BETWEEN '2017-02-01' AND '2017-02-28'
		GROUP BY
		v.ByAshaID
		) d ON d.ashaid = asha.ashaid
		LEFT JOIN
		(
		SELECT COUNT(*) AS child_births,
		c.AshaID AS ashaid
		FROM
		tblchild c
		WHERE
		c.child_dob BETWEEN '2017-02-01' AND '2017-02-28'
		GROUP BY
		c.AshaID
		) f ON f.ashaid = asha.ashaid
		LEFT JOIN
		(
		SELECT COUNT(*) AS pnc_visits,
		p.AshaID AS ashaid
		FROM
		tblpnchomevisit_ans p
		WHERE
		p.UpdatedOn BETWEEN '2017-02-01' AND '2017-02-28'
		GROUP BY
		p.AshaID
		) g ON g.ashaid = asha.ashaid
		LEFT JOIN
		(
		SELECT COUNT(*) AS immunizationANS,
		i.AshaID AS ashaid
		FROM
		tblmstimmunizationANS i
		WHERE
		i.CreatedOn BETWEEN '2017-02-01' AND '2017-02-28'
		GROUP BY
		i.AshaID
		) h ON h.ashaid = asha.ashaid
		WHERE
		asha.LanguageID = 1";
		
		$this->load->model('Data_export_model');
		$this->Data_export_model->export_pdf($query);
	}
} 
