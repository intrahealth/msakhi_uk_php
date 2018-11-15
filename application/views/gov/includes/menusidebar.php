<section id="main">
<aside id="sidebar" class="sidebar c-overflow">
<div class="s-profile" style="    padding-left: 10px;
padding-top: 10px;
padding-right: 10px;">
<a href="" data-ma-action="profile-menu-toggle" style="background-color : white;">
      <!-- <div class="sp-pic">
          <img src="<?php echo site_url('common_libs'); ?>/img/msakhi_logo.png" alt="">
        </div> -->

      <!-- <div class="sp-info" sty>
          <!-- <?php 
          $loginData = $this->session->userdata('loginData');
          echo $loginData->user_name; 
          ?> 
          <i class="zmdi zmdi-caret-down"></i>
        </div> -->
      </a>
      <ul class="main-menu">
        <li>
          <a href="<?php echo site_url(); ?>login/logout"><i class="zmdi zmdi-time-restore"></i> Logout</a>
        </li>
      </ul>
    </div>

    <ul class="main-menu">
      <li class="sub-menu">
        <a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-account-circle"></i> Dashboard</a>
        <ul>
          <!-- <li class="active">
              <a href="<?php echo site_url(); ?>gov/dashboard2"> Dashboard</a>
            </li> -->
            <li class="active">
              <a href="<?php echo site_url(); ?>gov/dashboard"> Output Indicators</a>
            </li>
            <li class="active">
              <a href="<?php echo site_url(); ?>gov/dashboard4"> Process Indicators</a>
            </li>
          <!-- <li class="active">
              <a href="<?php echo site_url(); ?>gov/dashboard"> Drill down report</a>
            </li> -->
          </ul>
        </li> 
  <!-- <li class="active">
      <a href="<?php echo site_url(); ?>gov/dashboard"><i class="zmdi zmdi-home"></i> Dashboard</a>
      <a href="<?php echo site_url(); ?>gov/dashboard2"><i class="zmdi zmdi-view-dashboard"></i> Dashboard2</a>
    </li> -->

    <li class="sub-menu">
      <a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-folder-person"></i>Reports</a>
      <ul>
          <!-- <li class="active">
              <a href="<?php echo site_url(); ?>gov/household_verification">Household Verification</a>
          </li>
          <li class="active">
              <a href="<?php echo site_url(); ?>gov/household_report">Household Summary</a>
          </li>  
          
          <li class="active">
              <a href="<?php echo site_url(); ?>gov/track_changes">Track Changes</a>                              
          </li>
          
          <li class="active">
              <a href="<?php echo site_url(); ?>gov/data_report">Data Summary</a>
            </li> -->

            <li class="active">
             <a href="<?php echo site_url(); ?>gov/vhnd_schedule">VHND Schedule</a>
           </li>

        <!--  <li class="active">
             <a href="<?php echo site_url(); ?>gov/af_module">AF Module</a>
           </li> -->

           <li class="active">
             <a href="<?php echo site_url(); ?>gov/hrp">HRP</a>
           </li>

           <li class="active">
             <a href="<?php echo site_url(); ?>gov/immunization">Immunization</a>
           </li>

         </li>
       </ul>
     </li>

   </ul>
 </aside>