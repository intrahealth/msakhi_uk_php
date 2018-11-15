<?php 
$this->loginData = $this->session->userdata('loginData');
$user_name = $this->loginData->user_name;
$query ="SELECT * FROM mststate where LanguageID=1 and StateCode='".$this->loginData->state_code."' ";
$content['list_state'] = $this->Common_Model->query_data($query);
foreach ($content['list_state'] as $row){ $statename = $row->StateName; } ?>
<?php
$query ="SELECT * FROM mstrole as rl inner join tblusers as ur on rl.RoleID ='".$this->loginData->user_role."' ";
$content['list_role'] = $this->Common_Model->query_data($query);
foreach ($content['list_role'] as $row){ $rolename_user = $row->RoleName; } ?>
<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie9"><![endif]-->
<head>
 <meta charset="utf-8">
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <title>Msakhi (<?php echo $statename; ?>)</title>
 <!-- Vendor CSS -->
<!-- <link href="<?php echo site_url('common_libs');?>/vendors/bower_components/fullcalendar/dist/fullcalendar.min.css" rel="stylesheet">
<link href="<?php echo site_url('common_libs');?>/vendors/bower_components/animate.css/animate.min.css" rel="stylesheet">
<link href="<?php echo site_url('common_libs');?>/vendors/bower_components/sweetalert/dist/sweetalert.css" rel="stylesheet"> -->
<link href="<?php echo site_url('common_libs');?>/vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css" rel="stylesheet">

<link href="<?php echo site_url('common_libs');?>/vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css" rel="stylesheet">
<link href="<?php echo site_url('common_libs');?>/vendors/bootgrid/jquery.bootgrid.min.css" rel="stylesheet">
<link href="<?php echo site_url('common_libs');?>/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">

<link href="<?php echo site_url('common_libs');?>/vendors/jquery-ui-1.12.1.custom/jquery-ui.min.css" rel="stylesheet">

<!-- CSS -->
<link href="<?php echo site_url('common_libs');?>/css/inc/app_1.css" rel="stylesheet">
<link href="<?php echo site_url('common_libs');?>/css/inc/app_2.css" rel="stylesheet">
<link href="<?php echo site_url('common_libs');?>/css/style.css" rel="stylesheet">
<!-- <link rel="stylesheet" href="<?php echo site_url('common_libs');?>/vendors/bootstrap-select/bootstrap-select.css"> -->
<link rel="stylesheet" href="<?php echo site_url('common_libs');?>/css/bootstrap.min.css">
<link type="text/css" href="<?php echo site_url('common_libs/css/select2.min.css');?>" rel="stylesheet"/> 

<!--<link href="<?php echo site_url('common_libs/css/jquery.multiselect.css');?>" rel="stylesheet" type="text/css"> -->
<link href="<?php echo site_url('common_libs/fonts/font-awesome-4.7.0/css/font-awesome.css');?>" rel="stylesheet" type="text/css">

<!--   <script type="text/javascript" src="http://www.google.com/jsapi"></script>

<script type="text/javascript">
google.load("elements", "1", {packages: "transliteration"});

function OnLoad() {                
var options = {
sourceLanguage:
google.elements.transliteration.LanguageCode.ENGLISH,
destinationLanguage:
[google.elements.transliteration.LanguageCode.HINDI],
shortcutKey: 'ctrl+g',
transliterationEnabled: true
};

var control = new google.elements.transliteration.TransliterationControl(options);
control.makeTransliteratable(["AshaNameHindi"]);
var keyVal = 32; // Space key
$("#AshaNameEnglish").on('keydown', function(event) {
if(event.keyCode === 32) {
var engText = $("#AshaNameEnglish").val() + " ";
var engTextArray = engText.split(" ");
$("#AshaNameHindi").val($("#AshaNameHindi").val() + engTextArray[engTextArray.length-2]);
document.getElementById("AshaNameHindi").focus();
$("#AshaNameHindi").trigger ( {
type: 'keypress', keyCode: keyVal, which: keyVal, charCode: keyVal
} );
}
});

$("#AshaNameHindi").bind ("keyup",  function (event) {
setTimeout(function(){ $("#AshaNameEnglish").val($("#AshaNameEnglish").val() + " "); document.getElementById("AshaNameEnglish").focus()},0);
});
} 

google.setOnLoadCallback(OnLoad);



</script> 
-->



</head>
<body style="background-color: rgb(0,0,0);">
 <!-- <header id="header" class="clearfix" data-ma-theme="blue"> -->
 <header id="header" class="clearfix" style="background-color: rgb(242,190,0);">
  <ul class="h-inner">
   <li class="hi-trigger ma-trigger" data-ma-action="sidebar-open" data-ma-target="#sidebar">
    <div class="line-wrap">
     <div class="line top"></div>
     <div class="line center"></div>
     <div class="line bottom"></div>
 </div>
</li>
<li class="hi-logo hidden-xs">
    <div class="sp-pic">
     <img src="<?php echo site_url('common_libs'); ?>/img/msakhi_logo.png" alt="Msakhi Logo" height="40" width="40">
     <a href="<?php echo site_url("auth/dashboard");?>">Msakhi (<?php echo $statename; ?>)</a>

 </div>
</li>

<li class="pull-right">
    <ul class="hi-menu">
     <li style="margin-right: 53px;color: #fff;font-size: 16px;margin-top: 8px;">
     <i class="fa fa-user" aria-hidden="true" style="font-size: 20px;"></i>&nbsp;
     <?php echo $user_name; ?>&nbsp;(<?php echo $rolename_user; ?>)</li>
     <li id="toggle-width">

      <div class="toggle-switch">
       <input id="tw-switch" type="checkbox" hidden="hidden">
       <label for="tw-switch" class="ts-helper"></label>
   </div>
</li> 

    <!-- <li data-ma-action="search-open">
        <a href=""><i class="him-icon zmdi zmdi-search"></i></a>
    </li>

    <li class="dropdown">
        <a data-toggle="dropdown" href="">
            <i class="him-icon zmdi zmdi-email"></i>
            <i class="him-counts">6</i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg pull-right">
            <div class="list-group">
                <div class="lg-header">
                    Messages
                </div>
                <div class="lg-body">
                    <a class="list-group-item media" href="">
                        <div class="pull-left">
                            <img class="lgi-img" src="img/profile-pics/1.jpg" alt="">
                        </div>
                        <div class="media-body">
                            <div class="lgi-heading">David Belle</div>
                            <small class="lgi-text">Cum sociis natoque penatibus et magnis dis parturient montes</small>
                        </div>
                    </a>
                    <a class="list-group-item media" href="">
                        <div class="pull-left">
                            <img class="lgi-img" src="img/profile-pics/2.jpg" alt="">
                        </div>
                        <div class="media-body">
                            <div class="lgi-heading">Jonathan Morris</div>
                            <small class="lgi-text">Nunc quis diam diamurabitur at dolor elementum, dictum turpis vel</small>
                        </div>
                    </a>
                    <a class="list-group-item media" href="">
                        <div class="pull-left">
                            <img class="lgi-img" src="img/profile-pics/3.jpg" alt="">
                        </div>
                        <div class="media-body">
                            <div class="lgi-heading">Fredric Mitchell Jr.</div>
                            <small class="lgi-text">Phasellus a ante et est ornare accumsan at vel magnauis blandit turpis at augue ultricies</small>
                        </div>
                    </a>
                    <a class="list-group-item media" href="">
                        <div class="pull-left">
                            <img class="lgi-img" src="img/profile-pics/4.jpg" alt="">
                        </div>
                        <div class="media-body">
                            <div class="lgi-heading">Glenn Jecobs</div>
                            <small class="lgi-text">Ut vitae lacus sem ellentesque maximus, nunc sit amet varius dignissim, dui est consectetur neque</small>
                        </div>
                    </a>
                    <a class="list-group-item media" href="">
                        <div class="pull-left">
                            <img class="lgi-img" src="img/profile-pics/4.jpg" alt="">
                        </div>
                        <div class="media-body">
                            <div class="lgi-heading">Bill Phillips</div>
                            <small class="lgi-text">Proin laoreet commodo eros id faucibus. Donec ligula quam, imperdiet vel ante placerat</small>
                        </div>
                    </a>
                </div>
                <a class="view-more" href="">View All</a>
            </div>
        </div>
    </li>
    <li class="dropdown">
        <a data-toggle="dropdown" href="">
            <i class="him-icon zmdi zmdi-notifications"></i>
            <i class="him-counts">9</i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg pull-right">
            <div class="list-group him-notification">
                <div class="lg-header">
                    Notification

                    <ul class="actions">
                        <li class="dropdown">
                            <a href="" data-ma-action="clear-notification">
                                <i class="zmdi zmdi-check-all"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="lg-body">
                    <a class="list-group-item media" href="">
                        <div class="pull-left">
                            <img class="lgi-img" src="img/profile-pics/1.jpg" alt="">
                        </div>
                        <div class="media-body">
                            <div class="lgi-heading">David Belle</div>
                            <small class="lgi-text">Cum sociis natoque penatibus et magnis dis parturient montes</small>
                        </div>
                    </a>
                    <a class="list-group-item media" href="">
                        <div class="pull-left">
                            <img class="lgi-img" src="img/profile-pics/2.jpg" alt="">
                        </div>
                        <div class="media-body">
                            <div class="lgi-heading">Jonathan Morris</div>
                            <small class="lgi-text">Nunc quis diam diamurabitur at dolor elementum, dictum turpis vel</small>
                        </div>
                    </a>
                    <a class="list-group-item media" href="">
                        <div class="pull-left">
                            <img class="lgi-img" src="img/profile-pics/3.jpg" alt="">
                        </div>
                        <div class="media-body">
                            <div class="lgi-heading">Fredric Mitchell Jr.</div>
                            <small class="lgi-text">Phasellus a ante et est ornare accumsan at vel magnauis blandit turpis at augue ultricies</small>
                        </div>
                    </a>
                    <a class="list-group-item media" href="">
                        <div class="pull-left">
                            <img class="lgi-img" src="img/profile-pics/4.jpg" alt="">
                        </div>
                        <div class="media-body">
                            <div class="lgi-heading">Glenn Jecobs</div>
                            <small class="lgi-text">Ut vitae lacus sem ellentesque maximus, nunc sit amet varius dignissim, dui est consectetur neque</small>
                        </div>
                    </a>
                    <a class="list-group-item media" href="">
                        <div class="pull-left">
                            <img class="lgi-img" src="img/profile-pics/4.jpg" alt="">
                        </div>
                        <div class="media-body">
                            <div class="lgi-heading">Bill Phillips</div>
                            <small class="lgi-text">Proin laoreet commodo eros id faucibus. Donec ligula quam, imperdiet vel ante placerat</small>
                        </div>
                    </a>
                </div>

                <a class="view-more" href="">View Previous</a>
            </div>
        </div>
    </li>
    <li class="dropdown hidden-xs">
        <a data-toggle="dropdown" href="">
            <i class="him-icon zmdi zmdi-view-list-alt"></i>
            <i class="him-counts">2</i>
        </a>
        <div class="dropdown-menu pull-right dropdown-menu-lg">
            <div class="list-group">
                <div class="lg-header">
                    Tasks
                </div>
                <div class="lg-body">
                    <div class="list-group-item">
                        <div class="lgi-heading m-b-5">HTML5 Validation Report</div>

                        <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100" style="width: 95%">
                                <span class="sr-only">95% Complete (success)</span>
                            </div>
                        </div>
                    </div>
                    <div class="list-group-item">
                        <div class="lgi-heading m-b-5">Google Chrome Extension</div>

                        <div class="progress">
                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                <span class="sr-only">80% Complete (success)</span>
                            </div>
                        </div>
                    </div>
                    <div class="list-group-item">
                        <div class="lgi-heading m-b-5">Social Intranet Projects</div>

                        <div class="progress">
                            <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                                <span class="sr-only">20% Complete</span>
                            </div>
                        </div>
                    </div>
                    <div class="list-group-item">
                        <div class="lgi-heading m-b-5">Bootstrap Admin Template</div>

                        <div class="progress">
                            <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                <span class="sr-only">60% Complete (warning)</span>
                            </div>
                        </div>
                    </div>
                    <div class="list-group-item">
                        <div class="lgi-heading m-b-5">Youtube Client App</div>

                        <div class="progress">
                            <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                <span class="sr-only">80% Complete (danger)</span>
                            </div>
                        </div>
                    </div>
                </div>

                <a class="view-more" href="">View All</a>
            </div>
        </div>
    </li> -->
    <li class="dropdown">
        <a data-toggle="dropdown" href=""><i class="him-icon zmdi zmdi-more-vert"></i></a>
        <ul class="dropdown-menu dm-icon pull-right">
         <li class="divider hidden-xs"></li>
         <li><a href="<?php echo site_url(); ?>Profile"><i class="zmdi zmdi-account"></i> Profile</a></li>
         <li><a href="<?php echo site_url(); ?>change_password"><i class="zmdi zmdi-lock"></i> Change Password</a></li>
         <li><a href="<?php echo site_url(); ?>login/logout"><i class="zmdi zmdi-time-restore"></i> Logout</a> </li>
     </ul>
 </li>
    <!-- <li class="hidden-xs ma-trigger" data-ma-action="sidebar-open" data-ma-target="#chat">
        <a href=""><i class="him-icon zmdi zmdi-comment-alt-text"></i></a>
    </li> -->
</ul>
</li>
</ul>

<!-- Top Search Content -->
<div class="h-search-wrap">
 <div class="hsw-inner">
  <i class="hsw-close zmdi zmdi-arrow-left" data-ma-action="search-close"></i>
  <input type="text">
</div>
</div>
</header>