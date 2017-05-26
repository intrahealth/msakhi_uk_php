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
                        <a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-account-circle"></i> Analytics</a>
                        <ul>
                            <li class="active">
                                <a href="<?php echo site_url(); ?>admin/dashboard"> Dashboard</a>
                            </li>
                            <li class="active">
                                <a href="<?php echo site_url(); ?>admin/dashboard2"> Dashboard2</a>
                            </li>
                            <li class="active">
                                <a href="<?php echo site_url(); ?>admin/dashboard3"> Dashboard Output Indicator</a>
                            </li>
                        </ul>
                    </li> 
                    <!-- <li class="active">
                        <a href="<?php echo site_url(); ?>admin/dashboard"><i class="zmdi zmdi-home"></i> Dashboard</a>
                        <a href="<?php echo site_url(); ?>admin/dashboard2"><i class="zmdi zmdi-view-dashboard"></i> Dashboard2</a>
                    </li> -->
                    <li class="sub-menu">
                        <a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-account-circle"></i> User Management</a>
                        <ul>
                            <li class="active">
                                <a href="<?php echo site_url('admin/anm');?>"> ANM</a>
                            </li>
                            <li class="active">
                                <a href="<?php echo site_url('admin/asha');?>"> ASHA</a>
                            </li>
                            <li class="active">
                                <a href="<?php echo site_url('admin/users');?>"> Users</a>
                            </li>
                        </ul>
                    </li> 
                    <li class="sub-menu">
                        <a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-my-location"></i> Manage Location</a>
                        <ul>
                            <li class="active">
                                <a href="<?php echo site_url('admin/state');?>"> State</a>
                            </li>
                            <li class="active">
                                <a href="<?php echo site_url('admin/district');?>"> District</a>
                            </li>
                            <li class="active">
                                <a href="<?php echo site_url('admin/block');?>"> Block</a>
                            </li>
                            <li class="active">
                                <a href="<?php echo site_url('admin/subcenter');?>"> Subcenter</a>
                            </li>
                            <li class="active">
                                <a href="<?php echo site_url('admin/village');?>" > Village</a>
                            </li>
                            <li class="active">
                                <a href="<?php echo site_url('admin/panchayat');?>"> Panchayat</a>
                            </li>                            
                            <li class="active">
                                <a href="<?php echo site_url(); ?>admin/household">Household</a>
                            </li>                                
                        </ul>
                    </li>

                    <li class="sub-menu">
                        <a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-folder-person"></i>Reports</a>
                        <ul>
                            <li class="active">
                                <a href="<?php echo site_url(); ?>admin/household_verification">Household Verification</a>
                            </li>
                            <li class="active">
                                <a href="<?php echo site_url(); ?>admin/household_report">Household Summary</a>
                            </li>  

                            <li class="active">
                                <a href="<?php echo site_url(); ?>admin/track_changes">Track Changes</a>                              
                            </li>

                            <li class="active">
                                <a href="<?php echo site_url(); ?>admin/data_report">Data Summary</a>
                            </li>
                            
                            <li class="active">
                             <a href="<?php echo site_url(); ?>admin/vhnd_schedule">VHND Schedule</a>
                         </li>

                         <li class="active">
                             <a href="<?php echo site_url(); ?>admin/af_module">AF Module</a>
                         </li>

                     </li>
                 </ul>
             </li>

         </ul>
     </aside>