<section id="main">
  <aside id="sidebar" class="sidebar c-overflow">
    <div class="s-profile" style=" padding-left: 10px;
    padding-top: 10px;
    padding-right: 10px;">
    <a href="" data-ma-action="profile-menu-toggle" style="background-color : white;"></a>

    <ul class="main-menu">
      <li>
        <a href="<?php echo site_url(); ?>login/logout"><i class="zmdi zmdi-time-restore"></i> Logout</a>
      </li>
    </ul>
  </div>

  <?php

  $query = "select * from role_permissions where RoleID = ? and Controller in ('dashboard', 'Output_indicators', 'Process_indicators', 'Drill_downreport', 'mnch_dashboard') group by Controller";

  $result = $this->db->query($query, [$this->session->userdata("loginData")->user_role])->result();
  if (count($result) > 0) { ?>

  <ul class="main-menu">
    <li class="sub-menu">
      <a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-home"></i> Dashboard</a>
      <ul>
        <?php 
        foreach ($result as $row) { if ($row->Controller == 'dashboard' && $row->Action == "index") { ?>
        <li class="active">
          <a href="<?php echo site_url(); ?>dashboard"> Dashboard</a>
        </li>
        <?php }else if ($row->Controller == 'Output_indicators' && $row->Action == "index") { ?>
        <li class="active">
          <a href="<?php echo site_url(); ?>Output_indicators"> Output Indicators</a>
        </li>
        <?php }else if ($row->Controller == 'Process_indicators' && $row->Action == "index") { ?>
        <li class="active">
          <a href="<?php echo site_url(); ?>Process_indicators"> Process Indicators</a>
        </li>
        <?php }else if ($row->Controller == 'mnch_dashboard' && $row->Action == "index") { ?>
        <li class="active">
          <a href="<?php echo site_url(); ?>mnch_dashboard"> MNCH DashBoard</a>
        </li>
        <?php }else if ($row->Controller == 'Drill_downreport' && $row->Action == "index") { ?>
        <li class="active">
          <a href="<?php echo site_url(); ?>Drill_downreport"> Drill down report</a>
        </li>
        <?php } } ?>        
      </ul>
    </li> 
    <?php }  ?>  

    <?php 
    $query = "select * from role_permissions where RoleID = ? and Controller in ('anm', 'asha', 'Users') group by Controller";
// print_r($this->session->userdata("loginData")); die();
    $result = $this->db->query($query, [$this->session->userdata("loginData")->user_role])->result();
    if (count($result) > 0) { ?>

    <li class="sub-menu">
      <a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-accounts-list"></i> User Management</a>
      <ul>
        <?php 
        foreach ($result as $row) {  if ($row->Controller == 'anm'  && $row->Action == "index") { ?>
        <li class="active">
          <a href="<?php echo site_url('anm');?>"> ANM</a>
        </li>
        <?php }else if ($row->Controller == 'asha'  && $row->Action == "index") { ?>
        <li class="active">
          <a href="<?php echo site_url('asha');?>"> ASHA</a>
        </li>
        <?php }else if ($row->Controller == 'Users' && $row->Action == "index") { ?>
        <li class="active">
          <a href="<?php echo site_url('Users');?>"> Users</a>
        </li>
        <?php } } ?>
      </ul>
    </li> 
    <?php }  ?> 

    <?php 
    $query = "select * from role_permissions where RoleID = ? and Controller in ('state', 'district', 'block','Subcenter','village','panchayat')";
// print_r($this->session->userdata("loginData")); die();
    $result = $this->db->query($query, [$this->session->userdata("loginData")->user_role])->result();
    if (count($result) > 0) { ?>
    <li class="sub-menu">
      <a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-my-location"></i> Manage Location</a>
      <ul>
        <?php 
        foreach ($result as $row) {  if ($row->Controller == 'state'  && $row->Action == "index") { ?>
        <li class="active">
          <a href="<?php echo site_url('state');?>"> State</a>
        </li>
        <?php }else if ($row->Controller == 'district' && $row->Action == "index") { ?>
        <li class="active">
          <a href="<?php echo site_url('district');?>"> District</a>
        </li>
        <?php }else if ($row->Controller == 'block' && $row->Action == "index") { ?>
        <li class="active">
          <a href="<?php echo site_url('block');?>"> Block</a>
        </li>
        <?php }else if ($row->Controller == 'Subcenter' && $row->Action == "index") { ?>
        <li class="active">
          <a href="<?php echo site_url('Subcenter');?>"> Subcenter</a>
        </li>
        <?php }else if ($row->Controller == 'village' && $row->Action == "index") { ?>
        <li class="active">
          <a href="<?php echo site_url('village');?>" > Village</a>
        </li>
        <?php }else if ($row->Controller == 'panchayat' && $row->Action == "index") { ?>
        <li class="active">
          <a href="<?php echo site_url('panchayat');?>"> Panchayat</a>
        </li>    

        <?php } } ?>
      </ul>
    </li> 
    <?php }  ?> 

    <?php 
    $query = "select * from role_permissions where RoleID = ? and Controller in ('Household_verification', 'household_report', 'track_changes','data_report','vhnd_schedule','af_module','hrp', 'hrp_current', 'immunization_administered', 'immunization','monthly_reports') group by Controller";
    // print_r($query); die();
// print_r($this->session->userdata("loginData")); die();
    $result = $this->db->query($query, [$this->session->userdata("loginData")->user_role])->result();
    if (count($result) > 0) { ?>

    <li class="sub-menu">
      <a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-shape"></i>Reports</a>
      <ul>
        <?php foreach ($result as $row) {  if ($row->Controller == 'Household_verification' && $row->Action == "index") { ?>
       
        <li class="active">
          <a href="<?php echo site_url(); ?>monthly_asha_report">Monthly Asha Report</a>
        </li>

        <li class="active">
          <a href="<?php echo site_url(); ?>Household_verification">Household Verification</a>
        </li>
        <?php }else if ($row->Controller == 'household_report' && $row->Action == "index") { ?> 
        <li class="active">
          <a href="<?php echo site_url(); ?>household_report">Household Summary</a>
        </li>  
        <?php }else if ($row->Controller == 'track_changes' && $row->Action == "index") { ?> 
        <li class="active">
          <a href="<?php echo site_url(); ?>track_changes">Track Changes</a>                           
        </li>
        <?php }else if ($row->Controller == 'data_report' && $row->Action == "index") { ?> 
        <li class="active">
          <a href="<?php echo site_url(); ?>data_report">Data Summary</a>
        </li>
        <?php }else if ($row->Controller == 'vhnd_schedule' && $row->Action == "index") { ?> 
        <li class="active">
          <a href="<?php echo site_url(); ?>vhnd_schedule">VHND Schedule</a>
        </li>
        <?php }else if ($row->Controller == 'af_module' && $row->Action == "index") { ?> 
        <li class="active">
          <a href="<?php echo site_url(); ?>af_module">AF Module</a>
        </li>
        <?php }else if ($row->Controller == 'hrp' && $row->Action == "index") { ?> 
        <li class="active">
          <a href="<?php echo site_url(); ?>hrp">HRP</a>
        </li>
        <?php }else if ($row->Controller == 'hrp_current' && $row->Action == "index") { ?> 
        <!-- <li class="active">
          <a href="<?php echo site_url(); ?>hrp_current">HRP (Current)</a>
        </li> -->
        <?php }else if ($row->Controller == 'immunization_administered' && $row->Action == "index") { ?> 
        <li class="active">
          <a href="<?php echo site_url(); ?>immunization_administered">Immunization Administered</a>
        </li>
        <?php }else if ($row->Controller == 'immunization' && $row->Action == "index") { ?> 
        <li class="active">
          <a href="<?php echo site_url(); ?>immunization">Immunization</a>
        </li>
         <?php }else if ($row->Controller == 'monthly_reports' && $row->Action == "index") { ?> 
        <li class="active">
          <a href="<?php echo site_url(); ?>monthly_reports">Monthly Reports</a>
        </li>
     
        <?php } } ?>
      </ul>
    </li> 
    <?php }  ?> 

    <?php 
    $query = "select * from role_permissions where RoleID = ? and Controller in ('exception_reports') group by Controller";
// print_r($this->session->userdata("loginData")); die();
    $result = $this->db->query($query, [$this->session->userdata("loginData")->user_role])->result();
    if (count($result) > 0) { ?>

    <li class="active">
          <a href="<?php echo site_url(); ?>exception_reports"><i class="zmdi zmdi-folder-person"></i>Exception Reports</a>
        </li>

    <!-- <li class="sub-menu">
      <a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-folder-person"></i>Exception Reports</a>
      <ul>
        <?php foreach ($result as $row) {  if ($row->Controller == 'exception_reports'  && $row->Action == "index") { ?>
        <li class="active">
          <a href="<?php echo site_url(); ?>exception_reports/pregnant_women_more_than_10_months_lmp">List of Women marked pregnant having elapsed LMP (10 months)</a>
        </li>
        <?php } } ?>
      </ul>
    </li>  -->
    <?php }  ?> 

    <?php 
    $query = "select * from role_permissions where RoleID = ? and Controller in ('role') group by Controller";
// print_r($this->session->userdata("loginData")); die();
    $result = $this->db->query($query, [$this->session->userdata("loginData")->user_role])->result();
    if (count($result) > 0) { ?>

    <li class="sub-menu">
      <a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-accounts-outline"></i>Manage Role</a>
      <ul>
        <?php foreach ($result as $row) {  if ($row->Controller == 'role' && $row->Action == "index") { ?>
        <li class="active">
          <a href="<?php echo site_url(); ?>Role">List Role</a>
        </li>
        <?php } } ?>
      </ul>
    </li> 
    <?php }  ?> 

    <?php 
    $query = "select * from role_permissions where RoleID = ? and Controller in ('Permissions') group by Controller";
// print_r($this->session->userdata("loginData")); die();
    $result = $this->db->query($query, [$this->session->userdata("loginData")->user_role])->result();
    if (count($result) > 0) { ?>

    <li class="sub-menu">
      <a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-devices"></i>Manage Permissions</a>
      <ul>
        <?php foreach ($result as $row) {  if ($row->Controller == 'Permissions'  && $row->Action == "index") { ?>
        <li class="active">
          <a href="<?php echo site_url(); ?>Permissions">Manager Role</a>
        </li>
        <?php } } ?>
      </ul>
    </li> 

    <li>
      <a href="<?php echo site_url('Export_flat_file/list_options'); ?>"><i class="zmdi zmdi-download"></i>Download Data Files</a>
    </li>
    <?php }  ?> 




    <?php 
    $query = "select * from role_permissions where RoleID = ? and Controller in ('household','mnch','delivery','child') group by Controller";
// print_r($this->session->userdata("loginData")); die();
    $result = $this->db->query($query, [$this->session->userdata("loginData")->user_role])->result();
    if (count($result) > 0) { ?>
    <li class="sub-menu">
      <a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-filter-frames"></i>Data Management</a>
      <ul>
        <?php 
        foreach ($result as $row) {  if ($row->Controller == 'Household'  && $row->Action == "index") { ?>
        <li class="active">
          <a href="<?php echo site_url(); ?>household">Household</a>
        </li>      
        <?php }else if ($row->Controller == 'MNCH' && $row->Action == "index") { ?>
        <li class="sub-menu">
          <a href="" data-ma-action="submenu-toggle" style="color: #4c4c4c;"> <i class="zmdi zmdi-filter-frames"></i> MNCH</a>
          <ul>
            <li class="active">
              <a href="<?php echo site_url(); ?>MNCH/ANCList" >Ante Natal Care</a>
            </li>
            <li class="active">
              <a href="<?php echo site_url(); ?>MNCH/DeliveryList">Delivery</a>
            </li>
            <!-- <li class="active">
              <a href="<?php echo site_url();?>delivery"> Delivery</a>
            </li> -->
            <li class="active">
              <a href="<?php echo site_url();?>child"> Child</a>
            </li>
          </ul>
        </li>


        <?php }  }  ?>
        </ul>

    </li> 
    <?php }  ?> 

    <?php $query = "select * from role_permissions where RoleID = ? and Controller in ('Qr_code_managment', 'Qr_code_managment_child') group by Controller";
    $result = $this->db->query($query, [$this->session->userdata("loginData")->user_role])->result();
    if(count($result)> 0){ ?>

     <li class="sub-menu">
      <a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-view-week"></i>Manage QrCode</a>
      <ul>

     <li class="active">
             <a href="<?php echo site_url(); ?>Qr_code_managment_women">Women</a>
           </li>

           <li class="active">
             <a href="<?php echo site_url(); ?>Qr_code_managment_child">Child</a>
           </li>


         </ul>
       </li>
    <?php }  ?> 



  <?php 
      $query = "select * from role_permissions where RoleID = ? and Controller in ('settings') group by Controller";
  // print_r($this->session->userdata("loginData")); die();
      $result = $this->db->query($query, [$this->session->userdata("loginData")->user_role])->result();
      if (count($result) > 0) { ?>

      <li class="active">
            <a href="<?php echo site_url(); ?>settings"><i class="zmdi zmdi-settings zmdi-hc-spin"></i>Setttings</a>
          </li>
   <?php }  ?> 

   
</aside>