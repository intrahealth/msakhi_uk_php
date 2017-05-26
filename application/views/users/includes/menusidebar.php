         <section id="main">
            <aside id="sidebar" class="sidebar c-overflow">
                <div class="s-profile">
                    <a href="" data-ma-action="profile-menu-toggle">
                        <div class="sp-pic">
                            <img src="<?php echo site_url('common_libs'); ?>/img/msakhi_logo.png" alt="">
                        </div>

                        <div class="sp-info">
                            <?php 
                            $loginData = $this->session->userdata('loginData');
                            echo $loginData->user_name; 
                            ?>
                            <i class="zmdi zmdi-caret-down"></i>
                        </div>
                    </a>

                    <ul class="main-menu">
                        <li>
                            <a href="<?php echo site_url(); ?>login/logout"><i class="zmdi zmdi-time-restore"></i> Logout</a>
                        </li>
                    </ul>
                </div>

                <ul class="main-menu">
                    <li class="active">
                        <a href="<?php echo site_url(); ?>users/dashboard"><i class="zmdi zmdi-home"></i> Dashboard</a>
                    </li>
                </ul>
            </aside>