    </section>

    <footer id="footer">
        Copyright &copy; 2012-2017 Intrahealth

        <ul class="f-menu">
            <li><a href="">Home</a></li>
            <li><a href="">Dashboard</a></li>
            <li><a href="">Reports</a></li>
            <li><a href="">Support</a></li>
            <li><a href="">Contact</a></li>
        </ul>
    </footer>

    <!-- Page Loader -->
    <div class="page-loader">
        <div class="preloader pls-blue">
            <svg class="pl-circular" viewBox="25 25 50 50">
                <circle class="plc-path" cx="50" cy="50" r="20" />
            </svg>

            <p>Please wait...</p>
        </div>
    </div>

    <!-- Older IE warning message -->
        <!--[if lt IE 9]>
            <div class="ie-warning">
                <h1 class="c-white">Warning!!</h1>
                <p>You are using an outdated version of Internet Explorer, please upgrade <br/>to any of the following web browsers to access this website.</p>
                <div class="iew-container">
                    <ul class="iew-download">
                        <li>
                            <a href="http://www.google.com/chrome/">
                                <img src="img/browsers/chrome.png" alt="">
                                <div>Chrome</div>
                            </a>
                        </li>
                        <li>
                            <a href="https://www.mozilla.org/en-US/firefox/new/">
                                <img src="img/browsers/firefox.png" alt="">
                                <div>Firefox</div>
                            </a>
                        </li>
                        <li>
                            <a href="http://www.opera.com">
                                <img src="img/browsers/opera.png" alt="">
                                <div>Opera</div>
                            </a>
                        </li>
                        <li>
                            <a href="https://www.apple.com/safari/">
                                <img src="img/browsers/safari.png" alt="">
                                <div>Safari</div>
                            </a>
                        </li>
                        <li>
                            <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
                                <img src="img/browsers/ie.png" alt="">
                                <div>IE (New)</div>
                            </a>
                        </li>
                    </ul>
                </div>
                <p>Sorry for the inconvenience!</p>
            </div>
            <![endif]-->

            <!-- Javascript Libraries -->
            <script src="<?php echo site_url('common_libs');?>/vendors/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>

            <script src="<?php echo site_url('common_libs');?>/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

            <script src="<?php echo site_url('common_libs');?>/vendors/bower_components/flot/jquery.flot.js"></script>
            <script src="<?php echo site_url('common_libs');?>/vendors/bower_components/flot/jquery.flot.resize.js"></script>
            <script src="<?php echo site_url('common_libs');?>/vendors/bower_components/flot.curvedlines/curvedLines.js"></script>
            <script src="<?php echo site_url('common_libs');?>/vendors/sparklines/jquery.sparkline.min.js"></script>
            <script src="<?php echo site_url('common_libs');?>/vendors/bower_components/jquery.easy-pie-chart/dist/jquery.easypiechart.js"></script>
            <script src="<?php echo site_url('common_libs');?>/vendors/bower_components/moment/min/moment.min.js"></script>
            <script src="<?php echo site_url('common_libs');?>/vendors/bower_components/fullcalendar/dist/fullcalendar.min.js "></script>
            <script src="<?php echo site_url('common_libs');?>/vendors/bower_components/simpleWeather/jquery.simpleWeather.min.js"></script> 
            <script src="<?php echo site_url('common_libs');?>/vendors/bower_components/Waves/dist/waves.min.js"></script>
            <script src="<?php echo site_url('common_libs');?>/vendors/bootstrap-growl/bootstrap-growl.min.js"></script>
            <script src="<?php echo site_url('common_libs');?>/vendors/bower_components/sweetalert/dist/sweetalert.min.js"></script>
            <!-- <script src="<?php echo site_url('common_libs');?>/js/inc/charts.js"></script> -->
            <script src="<?php echo site_url('common_libs');?>/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>



            <script src="<?php echo site_url('common_libs');?>/vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
            <script src="<?php echo site_url('common_libs');?>/vendors/bootgrid/jquery.bootgrid.min.js"></script>
            <!-- <script src="<?php echo site_url('common_libs');?>/vendors/bootstrap-select/bootstrap-select.js"></script>  -->
            <!-- <script src="<?php echo site_url('common_libs');?>/js/bootstrap.min.js"></script> -->

            <!-- Placeholder for IE9 -->
        <!--[if IE 9 ]>
            <script src="vendors/bower_components/jquery-placeholder/jquery.placeholder.min.js"></script>
            <![endif]-->

            <script src="<?php echo site_url('common_libs');?>/js/app.js"></script>
            <!-- <script src="<?php echo site_url('common_libs/js/jquery-ui.min.js');?>"></script> -->
            <script src="<?php echo site_url('common_libs/js/select2.min.js');?>"></script>
            <!--<script src="<?php echo site_url('common_libs/js/jquery.multiselect.js');?>"></script> -->

            <script src="<?php echo site_url('common_libs');?>/js/charts.min.js"></script>
            <script src="<?php echo site_url('common_libs');?>/js/chartsjs-plugin-deferred.js"></script>

            <!-- jQuery fixed header -->
            <script src="<?php echo site_url('common_libs');?>/vendors/jquery-fixed-header/tableHeadFixer.js"></script>

            <!-- jQuery export HTML to CSV -->
            <script src="<?php echo site_url('common_libs');?>/vendors/jquery-table-to-csv/jquery.tabletoCSV.js"></script>

            <script>
                if(localStorage.getItem('ma-layout-status') == 0 || localStorage.getItem('ma-layout-status') == undefined){

                    setTimeout(function () {
                        $('#content').css('padding-left', '15px');
                        $('#sidebar').hide();
                        // localStorage.setItem('ma-layout-status', 0);
                    }, 100);

                }else{

                    setTimeout(function () {
                        $('#content').css('padding-left', '283px');
                        $('#sidebar').show(300);
                        // localStorage.setItem('ma-layout-status', 1);
                    }, 100);

                }
            </script>


        </body>
        </html>
