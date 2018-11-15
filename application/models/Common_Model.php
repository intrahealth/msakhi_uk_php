<?php 
class Common_Model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
		$this->file_path = realpath(APPPATH . '../datafiles');
		$this->banner_path = realpath(APPPATH . '../banners');
		$this->gallery_path_url = base_url().'datafiles/';
	}

	public function insert_data($table,$data1)
	{   
		$this->db->insert($table,$data1);
	}	
	
	public function update_data($table,$data1,$col,$val)
	{   
		
		$this->db->where($col, $val);
		$this->db->update($table,$data1);
	}	
	
	
	public function delete_row($table,$col,$val)
	{   
		
		$this->db->where($col, $val);
		$this->db->delete($table);
	}			

	public function exist_data($table,$compare)
	{   
		
		$query = $this->db->get_where($table, $compare);

        $count = $query->num_rows(); //counting result from query

        return $count;

      }

      public function query_data($sql){
      	$query = $this->db->query($sql);
      	return $query->result();
      }

      public function query_data_noresult($sql){
      	$query = $this->db->query($sql);
      }

      public function query_data_array($sql){
      	$query = $this->db->query($sql);
      	return $query->result_array();
      }

      public function get_data($table,$fld = "*",$col=NULL,$val=NULL){
      	$this->db->select($fld);

      	if($col != NULL){ 
      		$this->db->where($col,$val); 
      	}		
      	$query = $this->db->get($table);
      	$row  = $query->result();
      	return $row;
      }

      public function get_data_multiple_where($table,$fld = "*",$where){
      	$this->db->select($fld);
      	$this->db->where($where); 
      	$query = $this->db->get($table);
      	$row  = $query->result();
      	return $row;
      }

      public function get_data_array($table,$fld = "*",$col=NULL,$val=NULL){
      	$this->db->select($fld);

      	if($col != NULL){ 
      		$this->db->where($col,$val); 
      	}
      	$query = $this->db->get($table);
      	$row  = $query->result_array();
      	return $row;
      }

      public function get_data_like($table,$fld = "*",$col=NULL,$val=NULL){
      	$this->db->select($fld);

      	if($col != NULL){ 
      		$this->db->like($col,$val,'both'); 
      	}		
      	$query = $this->db->get($table);
      	$row  = $query->result();
      	return $row;
      }	

      function do_upload($new_name = null) {

		//$this->load->helper(array('form', 'url'));

      	$config = array(
      		'allowed_types' => 'csv|docx|txt|doc|xlsx',
      		'upload_path' => $this->file_path,
      		'max_size' => 20000,
      		'file_name' => $new_name
      		);

      	$this->load->library('upload', $config);
      	$this->upload->do_upload();
      	$file_data = $this->upload->data();


      	return $file_data;
      }
//


      function do_upload_banner() {

		//$this->load->helper(array('form', 'url'));

      	$config = array(
      		'allowed_types' => 'png|jpeg|jpg',
      		'upload_path' => $this->banner_path,
      		'max_size' => 20000
      		);

      	$this->load->library('upload', $config);
      	$this->upload->do_upload();
      	$file_data = $this->upload->data();


      	return $file_data;
      }


      function do_upload_thumbnail()
      {
		// Get configuartion data (we fill up 2 arrays - $config and $conf)

      	$conf['img_path']			= $this->config->item('img_path');
      	$conf['allow_resize']		= $this->config->item('allow_resize');

      	$config['allowed_types']	= $this->config->item('allowed_types');
      	$config['max_size']			= $this->config->item('max_size');
      	$config['encrypt_name']		= $this->config->item('encrypt_name');
      	$config['overwrite']		= $this->config->item('overwrite');
      	$config['upload_path']		= $this->config->item('upload_path');

      	if (!$conf['allow_resize'])
      	{
      		$config['max_width']	= $this->config->item('max_width');
      		$config['max_height']	= $this->config->item('max_height');
      	}
      	else
      	{
      		$conf['max_width']		= $this->config->item('max_width');
      		$conf['max_height']		= $this->config->item('max_height');

      		if ($conf['max_width'] == 0 and $conf['max_height'] == 0)
      		{
      			$conf['allow_resize'] = FALSE;
      		}
      	}


		// Load uploader
      	$this->load->library('upload', $config);

		if ($this->upload->do_upload()) // Success
		{
			// General result data
			$result = $this->upload->data();
			
			// Shall we resize an image?
			if ($conf['allow_resize'] and $conf['max_width'] > 0 and $conf['max_height'] > 0 and (($result['image_width'] > $conf['max_width']) or ($result['image_height'] > $conf['max_height'])))
			{			
				// Resizing parameters
				$resizeParams = array
				(
					'source_image'	=> $result['full_path'],
					'new_image'		=> $result['full_path'],
					'width'			=> $conf['max_width'],
					'height'		=> $conf['max_height']
					);
				
				// Load resize library
				$this->load->library('image_lib', $resizeParams);
				
				// Do resize
				$this->image_lib->resize();
			}
			
			// Add our stuff
			$result['result']		= "file_uploaded";
			$result['resultcode']	= 'ok';
			$result['file_name']	= $conf['img_path'] . '/' . $result['file_name'];
		}
		else // Failure
		{
			// Compile data for output
			$result['result']		= $this->upload->display_errors(' ', ' ');
			$result['resultcode']	= 'failure';
		}
		return $result;
	}
	
	public function send_email($subject, $body, $to_email, $to_name=null, $attachments=array()){
		
		// $this->load->library('phpmailer','phpmailer');

		//load SMTP details
		$loginDetails = $this->Common_Model->get_data('tblsaas_customer');		
		
		//SMTP needs accurate times, and the PHP time zone MUST be set
		//This should be done in your php.ini, but this is how to do it if you don't have access to that
		// date_default_timezone_set('Etc/UTC');
		date_default_timezone_set('Asia/Calcutta');

		//Create a new PHPMailer instance
		$mail = new Phpmailer;

		//Tell PHPMailer to use SMTP
		$mail->isSMTP();

		//Enable SMTP debugging
		// 0 = off (for production use)
		// 1 = client messages
		// 2 = client and server messages
		$mail->SMTPDebug = 0;

		//Ask for HTML-friendly debug output
		$mail->Debugoutput = 'html';

		//Set the hostname of the mail server
		$mail->Host = $loginDetails[0]->Smtp_Hostname;
		// use
		// $mail->Host = gethostbyname('smtp.gmail.com');
		// if your network does not support SMTP over IPv6

		//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
		$mail->Port = $loginDetails[0]->Smtp_Port;

		//Set the encryption system to use - ssl (deprecated) or tls
		$mail->SMTPSecure = 'tls';

		//Whether to use SMTP authentication
		$mail->SMTPAuth = true;

		//Username to use for SMTP authentication - use full email address for gmail
		$mail->Username = $loginDetails[0]->Smtp_Username;

		//Password to use for SMTP authentication
		$mail->Password = $loginDetails[0]->Smtp_Password;

		//Set who the message is to be sent from
		$mail->setFrom($loginDetails[0]->Smtp_Username, $loginDetails[0]->Org_Name);

		//Set an alternative reply-to address
		// $mail->addReplyTo('replyto@example.com', 'First Last');

		//Set who the message is to be sent to
		// $mail->addAddress('kkumar.sandeep89@gmail.com', 'test');
		$mail->addAddress($to_email, ($to_name==null?'':$to_name));

		//Set the subject line
		$mail->Subject = $loginDetails[0]->Org_Name . ' - ' . $subject;

		//Read an HTML message body from an external file, convert referenced images to embedded,
		//convert HTML into a basic plain-text alternative body
		$mail->msgHTML($body);

		//Replace the plain text body with one created manually
		// $mail->AltBody = 'This is a plain-text message body';

		//Attach an image file
		if(count($attachments)>0){
			foreach($attachments as $attachment){
				if(file_exists(FCPATH  . 'datafiles/' . $attachment)){
					$mail->addAttachment(FCPATH  . 'datafiles/' . $attachment);
				}else{
					return "ERROR: attachment file ". FCPATH  . 'datafiles/' . $attachment . " does not exists";
				}
			}
		}
		
		// print_r($mail); die();
		
		//send the message, check for errors
		if (!$mail->send()) {
			return "ERROR: Mailer Error: " . $mail->ErrorInfo;
		} else {
			return "SUCCESS: Message sent!";
		}	
	}
	
	public function getStateList($languageId=1,$selected='',$stateCode=null){
		$sql="SELECT StateCode,StateName FROM mststate where LanguageID=$languageId";
		if ($stateCode != null)
			$sql.= ' and  StateCode=' . $stateCode;
		$result=$this->query_data($sql);
		$option = '<option value="">--select--</option>';
		foreach($result as $row){
			
			if(intval($selected) == intval($row->StateCode)) {
				$sal = "selected='selected'";
			} else {
				$sal = " ";
			}


			$option .= '<option  '.$sal.' value="'.$row->StateCode.'"   >'.$row->StateName.'</option>';
		}

		return  $option;
	}



	public function  getDistrictLists($StateCode,$selected='',$languageId=1) {


		$query = "select DistrictCode,DistrictName from mstdistrict where StateCode = $StateCode and LanguageID=$languageId";
		$result = $this->query_data($query);
		$option = '<option value="">--select--</option>';
		foreach($result as $row)
		{

			if(intval($row->DistrictCode) == intval($selected)) {
				$sal = "selected='selected'";
			} else {
				$sal = " ";
			}

			$option .= '<option  '.$sal.'  value="'.$row->DistrictCode.'">'.$row->DistrictName.'</option>';
		}

		return $option;

	}



	function getBlockLists($DistrictCode,$selected='',$languageId=1)
	{
		$query = "select BlockCode,BlockName from mstblock where DistrictCode = $DistrictCode and LanguageID=$languageId";
		$blocks = $this->query_data($query);

		$option = "<option value=''>Select</option>";
		foreach ($blocks as $row) {

	if(intval($row->BlockCode) == intval($selected)) {
				$sal = "selected='selected'";
			} else {
				$sal = " ";
			}

			$option .= '<option   '. $sal .'  value="'.$row->BlockCode.'">' .$row->BlockName.'</option>';
		}

		return $option;
	}


	function getPanchayatLists($BlockCode,$languageId=1,$selected='')
	{
		$query	=	"select * from mstpanchayat where BlockCode	=	$BlockCode and LanguageID=$languageId";
		$panchayat	= $this->query_data($query);
		$option = "<option value=''>Select</option>";
		foreach ($panchayat as $row)
		{
			if($selected == $row->PanchayatCode) {
				$salect = "selected='selected'";
			} else {
				$salect = "";
			}

			$option .= '<option   "'.$salect.'"  value=" '.$row->PanchayatCode.'">' .$row->PanchayatName.'</option>';
		}

		return $option;
		
	}


	function getMaxId($table,$fieldName, $where = null)
	{
		$query = "SELECT max($fieldName) as maxid  FROM $table";
		if($where!= null)
			$query .= " WHERE $where";
		$maxrow	= $this->query_data($query);
		return $maxrow[0]->maxid;
		
	}

	function get_user_id_from_asha_id($asha_id = '')
	{

	$ashaid = 	$this->db->get_where('mstasha', array('ASHAUID' => $asha_id))->row('ASHAID');
	return $this->db->get_where('userashamapping', array('AshaID'=> $ashaid))->row('UserID');

 	}

 	function get_user_id_from_charge_of($id = '')
	{
		$asha_id = $this->db->get_where('tblextracharge', array('ID' => $id))->row('ChargeOf');

		$ashaid = 	$this->db->get_where('mstasha', array('ASHAUID' => $asha_id))->row('ASHAID');
		
		return $this->db->get_where('userashamapping', array('AshaID'=> $ashaid))->row('UserID');

 	}


 	function get_user_id_anm_from_charge_of($id='')
 	{
 		$anm_id = $this->db->get_where('tblextrachargeanm', array('ID' => $id))->row('ChargeOf');

		$anmid = 	$this->db->get_where('mstanm', array('ANMUID' => $anm_id))->row('ANMID');
		
		return $this->db->get_where('useranmmapping', array('ANMID'=> $anmid))->row('UserID');
 	}

 	function get_user_id_from_anm_id($anm_id = '')
	{

	$anmid = 	$this->db->get_where('mstanm', array('ANMUID' => $anm_id))->row('ANMID');
	return $this->db->get_where('useranmmapping', array('ANMID'=> $anmid))->row('UserID');

 	}

}