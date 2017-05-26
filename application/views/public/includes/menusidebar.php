         <section id="main">
            <aside id="sidebar" class="sidebar c-overflow">
                <div class="s-profile">
                    <a href="" data-ma-action="profile-menu-toggle">
                        <div class="sp-pic">
                            <img src="<?php echo site_url('common_libs'); ?>/img/msakhi_logo.png" alt="">
                        </div>

                        <div class="sp-info">
                            <!-- <?php 
                            $loginData = $this->session->userdata('loginData');
                            echo $loginData->user_name; 
                            ?> -->
                            <i class="zmdi zmdi-caret-down"></i>
                        </div>
                    </a>
                </div>

                <ul class="main-menu">
                    <li class="active">
                        <a href="<?php echo site_url(); ?>public/dashboard"><i class="zmdi zmdi-home"></i> Dashboard</a>
                    </li>

                </ul>
            </aside>