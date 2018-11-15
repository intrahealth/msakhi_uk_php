<script src="<?php echo site_url('common_libs/vendors/chartsjs/Chart.min.js');?>"></script>
<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/serial.js"></script>
<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
<script src="https://www.amcharts.com/lib/3/themes/light.js"></script>

<style type="text/css">
body{
background-color: #ffffff !important;
}
/*Tiles CSS START*/
.tiles-height {
min-height: 50px;
max-height: 100%;
}

.tiles-1 {
background-color: #ffffff;
color: #fff;
padding: 0px;
}



.tiles-1-40 {
float: left;
width: 30%;
background-color: white;
font-size: 24px;
text-align: center;
line-height: 50px;
}

.tiles-1-60 {
float: left;
width: 70%;
background-color: transparent;
text-align: center;
line-height: 15px;
font-size: 14px;
padding: 10px;
}

.tiles-1-60 a {
color: #337ab7;
text-decoration: none;
float: left;
width: 100%;
}

/*Hover*/
/*1*/
.hvr-bounce-to-right {
/*display: inline-block;*/
vertical-align: middle;
-webkit-transform: translateZ(0);
transform: translateZ(0);
box-shadow: 0 0 1px rgba(0, 0, 0, 0);
-webkit-backface-visibility: hidden;
backface-visibility: hidden;
-moz-osx-font-smoothing: grayscale;
position: relative;
-webkit-transition-property: color;
transition-property: color;
-webkit-transition-duration: 0.5s;
transition-duration: 0.5s;
width: 100%;
height: 50px;
color: #000;
}

.hvr-bounce-to-right:before {
content: "";
position: absolute;
z-index: -1;
top: 0;
left: 0;
right: 0;
bottom: 0;
background: rgba(0, 0, 0, 0.1);
-webkit-transform: scaleX(0);
transform: scaleX(0);
-webkit-transform-origin: 0 50%;
transform-origin: 0 50%;
-webkit-transition-property: transform;
transition-property: transform;
-webkit-transition-duration: 0.5s;
transition-duration: 0.5s;
-webkit-transition-timing-function: ease-out;
transition-timing-function: ease-out;
}

.hvr-bounce-to-right:hover, .hvr-bounce-to-right:focus, .hvr-bounce-to-right:active {
color: #08c;
text-decoration: none;
}

.hvr-bounce-to-right:hover:before, .hvr-bounce-to-right:focus:before, .hvr-bounce-to-right:active:before {
-webkit-transform: scaleX(1);
transform: scaleX(1);
-webkit-transition-timing-function: cubic-bezier(0.52, 0, 0, 0);
transition-timing-function: cubic-bezier(0.52, 0, 0, 0);
}


/*Tiles CSS END*/

.child-div{
text-align: right;
line-height: 40px;
padding: 0px 8px;
background-color: #e6f3ff;
height: 35px;
margin: 5px;
width: calc(60% - 10px);
}

#main {
padding-top: 45px;
background-color: #ddd;
}

.count-div{
font-size: 11px;
margin-left: -15px;
color: #333333;
}
.counts-div{
font-size: 14px;
margin-left:  -22px;
color: #333333;
}

#chartdiv {
width: 40%;
height: 300px;
}

/*create by Chandan*/


.col-left-padd{
padding-left: 7px;
}
.col-right-padd{
padding-right: 7px;
}
.m-l{
margin-left: -283px;
}
@media(max-width: 768px){
.col-left-padd{
padding-right: 12px;
}
.col-right-padd{
padding-left: 12px;
}
.m-l{
margin-left: -18px;
}
}
.table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
    border: 1px solid #ddd !important;
}
.rotate
{
	transform: rotate(-90deg); -webkit-transform: rotate(-90deg); -ms-transform: rotate(-90deg);
}
</style>




<section id="content" style="background-color: #dddddd !important; padding-top: 2px;">

<div class="row" id="content" style="background-color: 	#dddddd !important; padding-top: 2px; margin-bottom: 2px;">

<div class="col-lg-4 col-md-4 col-sm-6 col-xs-8">
<label class="m-l" style=" color: #000;">Analytical DashBoard</label>
<?php $filter_data = $this->session->userdata('filter_data');
if ($filter_data != NULL) { ?>
<span style="color: black !important;">
applied filters: 
ANM: <?php if ($filter_data['ANM'] == NULL) {
echo 'ALL';
}else{
echo $this->Mnch_dashboard_model->get_anm_name_by_id($filter_data['ANM']);
} ?>

ASHA: <?php if ($filter_data['Asha'] == NULL) {
echo 'ALL';
}else{
echo $this->Mnch_dashboard_model->get_asha_name_by_id($filter_data['Asha']);
} ?>

<!-- Date Range: <?php if ($filter_data['date_from'] == NULL) {
echo 'ALL';
}else{
echo $filter_data['date_from'] . ' to ' . $filter_data['date_to'];
} ?> --> <br>

</span>
<?php }else{ ?>
<span style="color: white !important;">No filters applied</span>
<?php } ?>
</div>
<div class="col-lg-8 col-md-8 col-sm-6 col-xs-4">
<a href="javascript:document.getElementById('clearForm').submit();" class="pull-right hvr-pulse-grow" id="btn-Preview-Image" data-toggle="tooltip" title="Clear Filter">
<i class="fa fa-2x fa-filter" id="" name="" style="color: #f2f2f2; cursor: pointer; margin-right: 10px;margin-top: 1px;"></i>
</a>

<a href="javascript:showFilterDialog();" class="pull-right hvr-pulse-grow" id="btn-Preview-Image" data-toggle="tooltip" title="Apply Filter">
<i class="fa fa-2x fa-filter" id="" name="" style="color: rgb(242,190,0); cursor: pointer; margin-right: 20px;margin-top: 1px;"></i>
</a>
</div>





</div>


<div id="div_chart_dialog" style="display:none;">
<div id="chart_div"></div>

</div>




<div class="modal fade" id="myModal" role="dialog">
<div class="modal-dialog">

<!-- Modal content-->
<div class="modal-content">
<div class="modal-header" style="padding:10px 35px;">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4><span class="zmdi zmdi-check-all"></span> Apply Filter</h4>
</div>
<form role="form" method="post" action="">
<div class="modal-body" style="padding:10px;">
<div class="container">
<div class="row">

<div class="col-md-2 form-group">
<label for="State">Select State</label>
<select class="form-control" data-toggle="dropdown" id="StateCode" name="StateCode" style="width: 75%">
<option value="">--select--</option>
<?php foreach($State_List as $row){?>
<option value="<?php echo $row->StateCode;?>" <?php echo (trim($this->input->post('StateCode')) == $row->StateCode?"selected":"");?>><?php echo $row->StateName;?></option>
<?php } ?>
</select>
</div>

<div class="col-md-2 form-group">
<label for="ANM">Select ANM</label>
<select name="ANM" id="ANM" class="form-control fg-line" onchange="get_asha_list()" style="width: 75%">
<option value="">--select--</option>
<?php foreach ($anm_list as $anm_row) { ?>
<option value="<?php echo $anm_row->ANMID;?>" <?php echo ($anm_row->ANMID == $filter_data['ANM'] ? "selected":"");?>><?php echo $anm_row->ANMName  .  '('.$anm_row->user_name.')';?></option>
<?php } ?>

</select>
</div>

<div class="col-md-2 form-group">
<label for="Asha">Select Asha</label>
<select name="Asha" id="Asha" class="form-control fg-line" style="width: 75%">
<option value="">--select--</option>
<?php foreach ($asha_list as $asha_row) { ?>
<option value="<?php echo $asha_row->ASHAID;?>" <?php echo ($asha_row->ASHAID == $filter_data['Asha'] ? "selected":"");?>><?php echo $asha_row->ASHAName  .  '('.$asha_row->user_name.')';?></option>
<?php } ?>
</select>
</div>
</div>

<!-- <div class="row">
<div class="col-md-3 form-group">
<label for="Asha">Date From</label>
<input type="text" class="date-picker form-control fg-line" name="date_from" >
</div>

<div class="col-md-3 form-group">
<label for="Asha">Date To</label>
<input type="text" class="date-picker form-control fg-line" name="date_to" >
</div>

</div> -->
</div>
</div>
<div class="modal-footer">
<button type="submit" class="btn btn-success pull-left" name="command" value="apply_filter">APPLY</button>
<button type="submit" class="btn btn-warning pull-left" name="command" value="clear_filter">CLEAR</button>
<button type="reset" class="btn btn-default pull-left" data-dismiss="modal">CANCEL</button>
</div>
</form>
</div>

</div>
</div>

<form action="" method="post" id="clearForm">
<input type="hidden" name="command" value="clear_filter">
</form>






<!-- <div class="block-header">
<h2 style="color: #adadad">Dashboard</h2>
</div> -->

<div class="row">
<div class="card" style="background-color: transparent !important;">

<div class="col-md-4 col-right-padd" style=" margin-bottom: -18px;" >
<div class="card" style="background-color: #ddd;box-shadow: 0 0px 0px rgba(0, 0, 0, 0.15);">
<div class="row" style="margin-bottom: 7px;">
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 col-right-padd">
<div class="tiles-height tiles-1">
<i class="tiles-1-40">
<img src="<?php echo site_url() ?>/datafiles/mnch dashboard resources/households.png" height="40px" /> 

</i>
<span class="tiles-1-60">
<a href="#home" data-toggle="tab" title=" Total Households">
<label class="counts-div"><?php echo $demographic['total_households']['count'];?></label></a>
<small class="count-div"> Households</small>
</span>

</div>
</div>
<span>
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 col-left-padd">
<div class="tiles-height tiles-1">
<label style="font-size: 12px; color: black; margin-top: 18px; margin-left: 25px;">Age Groups</label>

</div>
</div>
</span>
</div>
<div class="row" style="margin-bottom: 7px;">
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 col-right-padd">
<div class="tiles-height tiles-1">
<i class="tiles-1-40">
<img src="<?php echo site_url() ?>/datafiles/mnch dashboard resources/population.png" height="40px" /> 

</i>
<span class="tiles-1-60">
<a href="#home" data-toggle="tab" title="Total Population">
<label class="counts-div"><?php echo $demographic['total_population']['count']; ?></label><br></a>
<small class="count-div">Population</small>
</span>

</div>
</div>
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 col-left-padd">
<div class="tiles-height tiles-1" style="background-color: #fff;">
<div class="row">
<table width="100%">
<tr>
<td  style="color: black;" ><label style="padding-left: 23px; padding-top: 10px;">2-5</label>
</td>
<td style="color: black;"><label style="padding-right: 12px;padding-top: 10px;">F<br><?php echo $demographic['child_2_to_5']['count'][0]->female; ?></label></td>
<td style="color: black;"><label style="padding-right: 12px; padding-top: 10px;">M<br><?php echo $demographic['child_2_to_5']['count'][0]->male; ?></label></td>
</tr>
</table>
<!-- 	<div class="col-md-4 col-sm-4 col-xs-4 col-lg-4 col-left-padd" style="font-size: 12px; color: black; margin-top: 16px; margin-left: 4px;">
<label style="padding-left: 12px;">2-5</label>
</div>
<div class="col-md-4" style="font-size: 12px; color: black; margin-top: 7px; margin-left: -15px;">
<label style=" margin-left: 15px;">F</label><br>
<label>20000</label>
</div>
<div class="col-md-4" style="font-size: 12px; color: black; margin-top: 7px; margin-left: 0px;">
<label style=" margin-left: 12px;">M</label><br>
<label>10000</label>
</div> -->
</div>
<!-- 	<i class="tiles-1-40" style="font-size: 12px; color: black;">
<b style="margin-left: -11px;font-size: 12px;">0 to 3</b>
</i>
<span class="tiles-1-60 child-div">
<a href="#home" data-toggle="tab" title="Pregnancy 0-3">
<b style="padding-right: 17px; color: #595959; font-size: 16px; "><?php echo $demographic['preg_0_to_3']['count'] ; ?></b></a>
</span> -->
</div>
</div>
</div>
<div class="row"  style="margin-bottom: 7px;">
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 col-right-padd">
<div class="tiles-height tiles-1">
<i class="tiles-1-40">
<img src="<?php echo site_url() ?>/datafiles/mnch dashboard resources/pregwomen.png" height="40px" /> 

</i>
<span class="tiles-1-60">
<a href="#home" data-toggle="tab" title="Total Pregnant">
<label class="counts-div"><?php echo $demographic['total_pregnent_women']['count'];?></label><br></a>
<small class="count-div">Currently Pregnant</small>
</span>

</div>
</div>
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 col-left-padd">
<div class="tiles-height tiles-1" style="background-color: #fff;">
<div class="row">
<table width="100%">
<tr>
<td  style="color: black;" ><label style="padding-left: 23px; padding-top: 10px;">6-14</label>
</td>
<td style="color: black;"><label style="padding-right: 12px;padding-top: 10px;">F<br><?php echo $demographic['child_6_to_14']['count'][0]->female; ?></label></td>
<td style="color: black;"><label style="padding-right: 12px; padding-top: 10px;">M<br><?php echo $demographic['child_6_to_14']['count'][0]->male; ?></label></td>
</tr>
</table>
<!-- <div class="col-md-4 col-sm-4 col-xs-4 col-lg-4 col-left-padd" style="font-size: 12px; color: black; margin-top: 16px; margin-left: 4px;">
<label style="padding-left: 12px;">6-14</label>
</div>
<div class="col-md-4" style="font-size: 12px; color: black; margin-top: 7px; margin-left: -15px;">
<label style=" margin-left: 15px;">F</label><br>
<label>20000</label>
</div>
<div class="col-md-4" style="font-size: 12px; color: black; margin-top: 7px; margin-left: 0px;">
<label style=" margin-left: 12px;">M</label><br>
<label>10000</label>
</div> -->
</div>
<!-- <i class="tiles-1-40" style="font-size: 12px; color: black;">
<b style="margin-left: -11px;font-size: 12px;">4 to 6</b>
</i>
<span class="tiles-1-60 child-div">
<a href="#home" data-toggle="tab" title="Pregnancy 4-6">
<b style="padding-right: 17px; color: #595959; font-size: 16px;"><?php echo $demographic['preg_4_to_6']['count'] ; ?></b></a>
</span> -->
</div>
</div>
</div>
<div class="row" style="margin-bottom: 7px;">
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 col-right-padd">
<div class="tiles-height tiles-1">
<i class="tiles-1-40">
<img src="<?php echo site_url() ?>/datafiles/mnch dashboard resources/chidren0to1.png" height="40px" />
</i>
<span class="tiles-1-60">
<a href="#home" data-toggle="tab" title="Children 0-1">
<label class="counts-div"><?php echo $demographic['child_0_to_1']['count']; ?></label><br></a>
<small class="count-div">Children 0 to 1 year</small>
</span>
</div>
</div>
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 col-left-padd">
<div class="tiles-height tiles-1" style="background-color: #fff;">
<div class="row">
<table width="100%">
<tr>
	<td  style="color: black;" ><label style="padding-left: 23px; padding-top: 10px;">15-49</label>
	</td>
	<td style="color: black;"><label style="padding-right: 12px;padding-top: 10px;">F<br><?php echo $demographic['child_15_to_49']['count'][0]->female; ?></label></td>
	<td style="color: black;"><label style="padding-right: 12px; padding-top: 10px;">M<br><?php echo $demographic['child_15_to_49']['count'][0]->male; ?></label></td>
</tr>
</table>
<!-- <div class="col-md-4 col-sm-4 col-xs-4 col-lg-4 col-left-padd" style="font-size: 12px; color: black; margin-top: 16px; margin-left: 4px;">
<label style="padding-left: 8px;">15-49</label>
</div>
<div class="col-md-4" style="font-size: 12px; color: black; margin-top: 7px; margin-left: -15px;">
<label style=" margin-left: 15px;">F</label><br>
<label>20000</label>
</div>
<div class="col-md-4" style="font-size: 12px; color: black; margin-top: 7px; margin-left: 0px;">
<label style=" margin-left: 12px;">M</label><br>
<label>10000</label>
</div> -->
</div>
<!-- <i class="tiles-1-40" style="font-size: 12px; color: black;">
<b style="margin-left: -11px;font-size: 12px;">7 to 8</b>
</i>
<span class="tiles-1-60 child-div">
<a href="#home" data-toggle="tab" title="Pregnancy 7-8">
<b style="padding-right: 17px; color: #595959; font-size: 16px;"><?php echo $demographic['preg_7_to_8']['count']; ?></b></a>
</span> -->
</div>
</div>
</div>
<div class="row" style="margin-bottom: 7px;">
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 col-right-padd">
<div class="tiles-height tiles-1">
<i class="tiles-1-40">
<img src="<?php echo site_url() ?>/datafiles/mnch dashboard resources/child.png" height="40px" /> 

</i>
<span class="tiles-1-60">
<a href="#home" data-toggle="tab" title="Children 1-5">
	<label class="counts-div"><?php echo $demographic['child_1_to_5']['count']; ?></label><br></a>
	<small class="count-div"> Children 1 to 2 year</small>
</span>

</div>
</div>
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 col-left-padd">
<div class="tiles-height tiles-1" style="background-color: #fff;">
<div class="row">
	<table width="100%">
		<tr>
			<td  style="color: black;" ><label style="padding-left: 23px; padding-top: 10px;">50+</label>
			</td>
			<td style="color: black; padding-left: 19px;"><label style="padding-right: 12px;padding-top: 10px;">F<br><?php echo $demographic['child_50_and_more']['count'][0]->female; ?></label></td>
			<td style="color: black;"><label style="padding-right: 12px; padding-top: 10px;">M<br><?php echo $demographic['child_50_and_more']['count'][0]->male; ?></label></td>
		</tr>
	</table>
	<!-- <div class="col-md-4 col-sm-4 col-xs-4 col-lg-4 col-left-padd" style="font-size: 12px; color: black; margin-top: 16px; margin-left: 4px;">
		<label style="padding-left: 12px;">50+</label>
	</div>
	<div class="col-md-4" style="font-size: 12px; color: black; margin-top: 7px; margin-left: -15px;">
		<label style=" margin-left: 15px;">F</label><br>
		<label>20000</label>
	</div>
	<div class="col-md-4" style="font-size: 12px; color: black; margin-top: 7px; margin-left: 0px;">
		<label style=" margin-left: 12px;">M</label><br>
		<label>10000</label>
	</div> -->
</div>
<!-- <i class="tiles-1-40" style="font-size: 12px; color: black;">
	<b style="margin-left: -11px;font-size: 12px;">9+</b>
</i>
<span class="tiles-1-60 child-div">
	<a href="#home" data-toggle="tab" title="Pregnancy 9+">
		<b style="padding-right: 17px; color: #595959; font-size: 16px;"><?php echo $demographic['preg_9_and_more']['count']; ?></b></a>
	</span> -->
</div>
</div>
</div>
</div>
</div>
<div class="col-md-8 col-left-padd" style="margin-bottom: -20px;">
<div class="card" style="min-height: 301px;">
<div class="row" style="margin: 0px 0px 15px 0px;">
<div class="col-sm-4 col-md-4" >
<!-- <div class="mini-chart-item bgm-white"> -->
	<div class="clearfix">
		<div class="chart stats-bar" style="padding-top: 10px;"></div>
		<div class="count">
			<label><b style="padding-left: 12px;">Antenatal Care (%)</b></label>
			<!-- </div> -->
		</div>
	</div>
</div>
<div class="col-sm-4 col-md-4">
	<div class="tiles-height tiles-1" style="background-color: #e6f3ff; margin-top: 2px;">
		<span style="float: left;width:  100%;text-align:  center;padding:  6px;">
			<a href="<?php echo site_url() ?>/Mnch_dashboard/getHRPReport" title=" HRP cases among the currently pregnant women who were ever identified as HRP due to any HRP condition">
				<label style="color: #595959">Number of HRP</label><br>
				<b style="font-size: 16px; color: #595959"><?php echo $demographic['total_hrp_count']['count'];?></b></a>
			</span>
		</div>
	</div>
	<div class="col-sm-4 col-md-4">
		<div class="tiles-height tiles-1" style="background-color: #e6f3ff; margin-top: 2px;">
			<span style="float: left;width:  100%;text-align:  center;padding:  6px;">
				<a href="#home" data-toggle="tab" title=" Denominator: All women who have gave birth in last three months; Numerator: All women who gave birth in last 3 months and have completed all 4 ANCs and have got at least one TT.">
					<label style="color: #595959">Full ANC</label><br>
					<b style="font-size: 16px; color: #595959"><?php echo number_format($demographic['Full_ANC']['percent'],1);?>%</b></a>
				</span>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12" style="margin-bottom: -1px;
		">
		<div class="card">
			<canvas id="pregWomenRegchart" width="100" height="23"></canvas>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<table style="width: 100%;">
			<tr style="background-color: gold;">
				<td style=" padding:6px; border: 3px solid; border-color: white;    width: 20px;"><label>PW</label></td>
				<td style=" padding:6px; border: 3px solid; border-color: white;    width: 70px;padding-left: 25px;"><label><?php echo $demographic['preg_0_to_3']['count'] ; ?></label></td>
				<td style=" padding:6px; border: 3px solid; border-color: white;    width: 70px;padding-left: 25px;"><label><?php echo $demographic['preg_4_to_6']['count'] ; ?></label></td>
				<td style=" padding:6px; border: 3px solid; border-color: white;    width: 70px;padding-left: 25px;"><label><?php echo $demographic['preg_7_to_8']['count'] ; ?></label></td>
				<td style=" padding:6px; border: 3px solid; border-color: white;    width: 70px;padding-left: 25px;"><label><?php echo $demographic['preg_9_and_more']['count'] ; ?></label></td>
				<td style=" padding:6px; border: 3px solid; border-color: white;    width: 70px;padding-left: 25px;"><label><?php echo $demographic['total_pregnent_women']['count'];?></label></td>
				<td style=" padding:6px; border: 3px solid; border-color: white;    width: 70px;padding-left: 25px;"><label><?php echo $demographic['total_pregnent_women']['count'];?></label></td>
				<td style=" padding:6px; border: 3px solid; border-color: white;    width: 90px;padding-left: 25px;"><label><?php echo $demographic['total_pregnent_women']['count'];?></label></td>
			</tr>
		</table>
	</div>
	
</div>
</div>
</div>
</div>
</div>
<div class="row">
<div class="card">
<div class="col-md-4 col-right-padd">
<div class="card">
<div class="row">
	<div class="col-md-12">
		<table style="width: 100%;">
			<tr style="background-color: #3390FF;">
				<td style=" padding:5px; border: 2px solid; border-color: white;"></td>
				<td style=" padding:5px; border: 2px solid; border-color: white; font-size: 9px; color: white;">Current<br>Month</td>
				<td style=" padding:5px; border: 2px solid; border-color: white; font-size: 9px; color: white;">Previous<br>Month</td>
				<td style=" padding:5px; border: 2px solid; border-color: white; font-size: 9px; color: white;">Last three<br>Completed<br>Months</td>
				<td style=" padding:5px; border: 2px solid; border-color: white; font-size: 9px; color: white;">This Year<br>(From April)</td>
			</tr>
			<!-- </table> -->
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<!-- <table style="width: 100%;"> -->
				<tr style="background-color: #cce0ff;">
					<td style=" padding:3px; border: 1px solid; border-color: white;"><label style="font-size: 10px;">Live<br>Births</label></td>
					<td style=" padding:3px; border: 1px solid; border-color: white;"><?php echo $delivery['current_month_livebirth']['count']; ?></td>
					<td style=" padding:3px; border: 1px solid; border-color: white;"><?php echo $delivery['last_month_livebirth']['count']; ?></td>
					<td style=" padding:3px; border: 1px solid; border-color: white;"><?php echo $delivery['last_three_month_livebirth']['count'];?></td>
					<td style=" padding:3px; border: 1px solid; border-color: white;"><?php echo $delivery['april_to_current_month_livebirth']['count'];?></td>
				</tr>
				<!-- </table> -->
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<!-- <table style="width: 100%;"> -->
					<tr style="background-color: #cce0ff;">
						<td style=" padding:3px; border: 1px solid; border-color: white;"><label style="font-size: 10px;">Infant Death</label></td>
						<td style=" padding:3px; border: 1px solid; border-color: white;"><?php echo $delivery['current_month_infant_death']['count']; ?></td>
						<td style=" padding:3px; border: 1px solid; border-color: white;"><?php echo $delivery['last_month_infant_death']['count']; ?></td>
						<td style=" padding:3px; border: 1px solid; border-color: white;"><?php echo $delivery['last_three_month_infant_death']['count']; ?></td>
						<td style=" padding:3px; border: 1px solid; border-color: white;"><?php echo $delivery['april_to_current_month_infant_death']['count']; ?></td>
					</tr>
				</table>
			</div>
		</div>
		<div class="row" style="margin-bottom: 7px;">
			<div class="col-md-12">
				<div class="count" style="margin-top: 0px;margin-left: 13px;">
					<label>Delivery and PNC<small> (for all births in last 3 months)</small></label></div>
					<div class="tiles-height tiles-1">
						<canvas id="bar-chart-institutional" width="1200" height="300"></canvas>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="tiles-height tiles-1">
						<canvas id="bar-chart-birthweight" width="1200" height="300"></canvas>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="tiles-height tiles-1">
						<canvas id="bar-chart-HBNC" width="1200" height="300"></canvas>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-5 col-left-padd">
		<div class="card">
			<div class="row" style="margin: 0px 0px 15px 0px;">
				<div class="col-md-7">
					<div class="clearfix">
						<div class="chart stats-bar"></div>
						<div class="count" style="margin-top: 8px;margin-left: 13px;">
							<label>Immunisation<small> (all children < 1yr)</small></label><br>
							<small><b>dose received / eligible as per age</b></small>
						</div>
					</div>
				</div>

				<div class="col-sm-5 col-md-5">
					<div class="tiles-height tiles-1" style="background-color: #e6f3ff; margin-top: 2px;">
						<span style="float: left;width:  100%;text-align:  center;padding:  6px;">
							<a href="#home" data-toggle="tab" title="Denominator: All children with age >= 12 months and <= 24 months Numerator: All children with age >= 12 months and <= 24 months and have received BCG, 3 doses of OPV (1, 2 and 3) and 3 doses of DPT or Pentavalent and 1 dose of Measles or Measles Rubella">
								<label style="color: #595959">Full Immunisation</label><br>
								<b style="font-size: 16px; color: #595959"><?php echo $demographic['Full_Immunization']['percent'];?>%</b></a>
							</span>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="card">
							<canvas id="childImmunizationChart" width="100" height="70"></canvas>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-3 col-left-padd">
			<div class="card">
				<div class="row" style="margin: 0px 0px 15px 0px;">
					<div class="col-md-12">
						<canvas id="line-chart" width="160" height="295"></canvas>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-4" style="margin-bottom: -11px; margin-top: -15px;margin-right: 0px;  margin-left: 4px;">
		<div class="card">
			<div class="row">
				<div class="col-md-12">
					<label>More then 30+ <small>(in age)</small></label>
					<label style=" font-size: 15px;margin-left: 25px;margin-top: 0px;">Assessed by ASHA (CBAC)</label>
					<br>
					<label style=" font-size: 15px;margin-left: 25px;"><?php echo $cbac['cbac_box']['total_cbac'];?></label>

				</div>
			</div>
			<br>
			<label style="font-size: 14px; margin-left: 22px;">Screened</label>
			<br>
			<label style="font-size: 14px; margin-left: 22px;"><?php echo $cbac['cbac_box']['total_screening'];?></label>
		</div>
	</div>
	<div class="col-md-8" style="margin-bottom: -12px;margin-top: -15px; margin-left: -8px;">
		<div class="card">
			<div class="row">
				<div class="col-md-4">
					<canvas id="ChartHT" width="60" height="40"></canvas>
				</div>
				<div class="col-md-4">
					<canvas id="ChartDB" width="60" height="40"></canvas>
				</div>
				<div class="col-md-4">
					<canvas id="ChartHTandDB" width="60" height="40"></canvas>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-9">
		<div class="card">
			<div class="row">
			 <div class="col-md-12">
					<div class="table-responsive">
					<table class="table table-bordered table-striped table-hover">
						<tr style="background-color: #04254c;">
							<th></th>
							<th></th>
							<th style="font-size: 14px; color: white;">Assessed</th>
							<th style="font-size: 14px; color: white;">Screened</th>
							<th style="font-size: 14px; color: white;">Suspected</th>
							<th style="font-size: 14px; color: white;">Detected</th>
							<th style="font-size: 14px; color: white;">Follow-up going on</th>
						</tr>
						<tr>
								<th rowspan="3" class="rotate" style="font-size: 14px; color: black;">Hypertensive</th>
								<th style=" padding-left: 28px;">M</th>
								<td><?php echo $cbac['ht']['assessed_male'];?></td>
								<td><?php echo $cbac['ht']['screened_male'];?></td>
								<td><?php echo $cbac['ht']['suspected_male'];?></td>
								<td><?php echo $cbac['ht']['detected_male'];?></td>
								<td><?php echo $cbac['ht']['followup_male'];?></td>
							</tr>
							<tr>
								<th>F</th>
								<td><?php echo $cbac['ht']['assessed_female'];?></td>
								<td><?php echo $cbac['ht']['screened_female'];?></td>
								<td><?php echo $cbac['ht']['suspected_female'];?></td>
								<td><?php echo 	$cbac['ht']['detected_female'];?></td>
								<td><?php echo $cbac['ht']['followup_female'];?></td>
							</tr>
							<tr>
								<th>T</th>
								<td><?php echo $cbac['ht']['assessed_both'];?></td>
								<td><?php echo $cbac['ht']['screened_both'];?></td>
								<td><?php echo $cbac['ht']['suspected_both'];?></td>
								<td><?php echo $cbac['ht']['detected_both'];?></td>
							<td><?php echo $cbac['ht']['followup_both'];?></td>
							</tr>
							<tr>
								<th rowspan="3" class="rotate" style="font-size: 14px; color: black;">Diabetic</th>
								<th style=" padding-left: 28px;">M</th>
								<td><?php echo $cbac['bp']['assessed_male'];?></td>
								<td><?php echo $cbac['bp']['screened_male'];?></td>
								<td><?php echo $cbac['bp']['suspected_male'];?></td>
								<td><?php echo $cbac['bp']['detected_male'];?></td>
								<td><?php echo$cbac['bp']['followup_male'];?></td>
							</tr>
							<tr>
								<th>F</th>
								<td><?php echo $cbac['bp']['assessed_female'];?></td>
							  <td><?php echo $cbac['bp']['screened_female'];?></td>
								<td><?php echo $cbac['bp']['suspected_female'];?></td>
								<td><?php echo $cbac['bp']['detected_female'];?></td>
								<td><?php echo$cbac['bp']['followup_female'];?></td>
							</tr>
							<tr>
								<th>T</th>
								<td><?php echo $cbac['bp']['assessed_both'];?></td>
								<td><?php echo $cbac['bp']['screened_both'];?></td>
								<td><?php echo $cbac['bp']['suspected_both'];?></td>
								<td><?php echo $cbac['bp']['detected_both'];?></td>
									<td><?php echo $cbac['bp']['followup_both'];?></td>
							</tr>
							<tr>
								<th rowspan="3" class="rotate" style="font-size: 14px; color: black;">Both</th>
								<th style=" padding-left: 28px;">M</th>
								<td><?php echo $cbac['bp']['assessed_male'];?></td>
								<td><?php echo $cbac['bp']['screened_male'];?></td>
								<td><?php echo $cbac['ht_bp']['suspected_male'];?></td>
							<td><?php echo $cbac['ht_bp']['detected_male'];?></td>
								<td><?php echo$cbac['ht_bp']['followup_male'];?></td>
							</tr>
							<tr>
								<th>F</th>
								<td><?php echo $cbac['bp']['assessed_female'];?></td>
							  <td><?php echo $cbac['bp']['screened_female'];?></td>
								<td><?php echo $cbac['ht_bp']['suspected_female'];?></td>
								<td><?php echo $cbac['ht_bp']['detected_female'];?></td>
								<td><?php echo$cbac['ht_bp']['followup_female'];?></td>
							</tr>
							<tr>
								<td>T</td>
								<td><?php echo $cbac['bp']['assessed_both'];?></td>
								<td><?php echo $cbac['bp']['screened_both'];?></td>
								<td><?php echo $cbac['ht_bp']['suspected_both'];?></td>
								<td><?php echo $cbac['ht_bp']['detected_both'];?></td>
								<td><?php echo $cbac['ht_bp']['followup_both'];?></td>
							</tr>
					</table>
					</div>
				 </div>
			</div>
		</div>
	</div>
	<div class="col-md-3" style=" margin-left: -10px;">
		<div class="card">
			<div class="row">
				<div class="col-md-12">
					<label style="font-size: 14px; margin-top: 18px; margin-bottom: 18px;margin-left: 51px;">Stopped Treatment</label>
					<div class="table-responsive">
					<table class="table table-bordered table-striped table-hover">
						<tr>
							<td>Hypertension</td>
							<td>3</td>
						</tr>
						<tr>
							<td>Diabetes</td>
							<td>5</td>
						</tr>
						<tr>
							<td>Both</td>
							<td>2</td>
						</tr>
					</table>
				</div>
				</div>
			</div>
		</div>
		<div class="card">
			<div class="row">
				<div class="col-md-12">
					<label style="font-size: 16px; margin-top: 12px;margin-bottom: 12px;margin-left: 37px;">Number of persons counselled by ASHA</label>
					<label style="font-size: 20px;margin-top: 15px;margin-bottom: 44px;margin-left: 79px;"><?php echo $cbac['counselled']['total']; ?></label>
				</div>
			</div>
		</div>
	</div>
</div>

</section>

<script type="text/javascript">

new Chart(document.getElementById("line-chart"), {
	type: 'line',
	data: {
		labels: ['DAY1','DAY3','DAY7','DAY14','DAY21','DAY28','DAY42'],
		datasets: [{ 
			data: [<?php echo number_format($pnchomevisit['pnc_home_visit_1']['percent'],1); ?>,
			<?php echo number_format($pnchomevisit['pnc_home_visit_2']['percent'],1); ?>,
			<?php echo number_format($pnchomevisit['pnc_home_visit_3']['percent'],1); ?>,
			<?php echo number_format($pnchomevisit['pnc_home_visit_4']['percent'],1); ?>,
			<?php echo number_format($pnchomevisit['pnc_home_visit_5']['percent'],1); ?>,
			<?php echo number_format($pnchomevisit['pnc_home_visit_6']['percent'],1); ?>,
			<?php echo number_format($pnchomevisit['pnc_home_visit_7']['percent'],1); ?>],
			label: "HBNC Visits",
			borderColor: "gold",
			fill: false
		}
		]
	},
	options: {
		title: {
			display: true,
			text: 'HBNC visits by ASHA (for all births in last 3 months)'
		}
	}
});



var ctx = document.getElementById("pregWomenRegchart");
var myLineChart = new Chart(ctx, {
	type: 'bar',
	options: {
		scaleShowValues: true,
		scales: {
			yAxes: [{
				ticks: {
					beginAtZero: true
				}
			}],
			xAxes: [{
				ticks: {
					autoSkip: false
				}
			}]
		}
	},
	data: {
		labels:  ["Preg 0-3 m", "Preg 4-6 m", "Preg 7-8 m", "Preg 9(+)m", "Total PW","Reg in 1st Trim.",  "TT or Booster"],
		datasets: [{
			label: "1 ANC",
			backgroundColor: "#c8981e",
			borderColor: "rgb(242,190,0)",
			stack: 'Stack 0',
			data: [
			<?php echo number_format($antenatel['one_anc_checkup']['percent'],1);?>,
			<?php echo number_format($antenatel['one_anc_checkup_in_4_to_6_month']['percent'],1);?>,
			<?php echo number_format($antenatel['one_anc_checkup_in_7_to_8_month']['percent'],1);?>,
			<?php echo number_format($antenatel['one_anc_checkup_9_and_more_months']['percent'],1);?>,
			<?php echo number_format($antenatel['comp_one_anc_checkup']['percent'],1);?>,
			0,
			0
			],
		},
		{
			label: "2 ANC",
			backgroundColor: "#e1b137",
			stack: 'Stack 1',
			data: [
			0,
			<?php echo number_format($antenatel['two_anc_checkup']['percent'],1);?>,
			<?php echo number_format($antenatel['two_anc_checkup_in_7_to_8_months']['percent'],1);?>,
			<?php echo number_format($antenatel['two_anc_checkup_9_and_more_months']['percent'],1);?>,
			<?php echo number_format($antenatel['comp_two_anc_checkup']['percent'],1);?>,
			0,
			0
			],
		},
		{
			label: "3 ANC",
			backgroundColor: "#ebcb7a",
			stack: 'Stack 2',
			data: [
			0,
			0,
			<?php echo number_format($antenatel['three_anc_checkup']['percent'],1);?>,
			<?php echo number_format($antenatel['three_anc_checkup_9_and_more_months']['percent'],1);?>,
			<?php echo number_format($antenatel['comp_three_anc_checkup']['percent'],1);?>,
			0,
			0
			],
		},
		{
			label: "4 ANC",
			backgroundColor: "#f5e5bc",
			stack: 'Stack 3',
			data: [
			0,
			0,
			0,
			<?php echo number_format($antenatel['four_anc_checkup']['percent'],1);?>,
			<?php echo number_format($antenatel['comp_four_anc_checkup']['percent'],1);?>,
			0,
			0
			],
		},
		{
			label: "Reg. Preg. Women",
			backgroundColor: "rgb(242,190,0)",
			stack: 'Stack 4',
			data: [
			0,
			0,
			0,
			0,
			0,
			<?php echo number_format($antenatel['registered_in_first_trimester']['percent'],1);?>,
			0
			],
		},
		{
			label: "TT Dose",
			backgroundColor: "#fff099",
			stack: 'Stack 5',
			data: [
			0,
			0,
			0,
			0,
			0,
			0,
			<?php echo number_format($antenatel['tt2_or_booster']['percent'],1);?>
			],
		}],
	},


});



var ctx = document.getElementById("childImmunizationChart");
var myLineChart = new Chart(ctx, {
type: 'bar',height: '1000px',
display: true,
autoSkip: false,
data: {
labels:["BCG", "OPV0", "HepB0", "OPV1", "D/P-1", "OPV2", "D/P-2", "OPV3", "D/P-3", "Measles"],
datasets: [{
label: "Immunized",
backgroundColor: "rgb(242,190,0)",
borderColor: "rgb(242,190,0)",
stack: 'Stack 0',
data: [
<?php echo number_format($immunization['bcg']['percent'],1); ?>,
<?php echo number_format($immunization['opv1']['percent'],1); ?>,
<?php echo number_format($immunization['hepb1']['percent'],1); ?>, 
<?php echo number_format($immunization['opv2']['percent'],1); ?>, 
<?php echo number_format($immunization['dpt1']['percent'],1); ?>,
	// <?php echo number_format($immunization['hepb2']['percent'],1); ?>,
	<?php echo number_format($immunization['opv3']['percent'],1); ?>,
	<?php echo number_format($immunization['dpt2']['percent'],1); ?>, 
	// <?php echo number_format($immunization['hepb3']['percent'],1); ?>,
	<?php echo number_format($immunization['opv4']['percent'],1); ?>,
	<?php echo number_format($immunization['dpt3']['percent'],1); ?>,
	// <?php echo number_format($immunization['hepb4']['percent'],1); ?>,
	<?php echo number_format($immunization['measeals']['percent'],1); ?>
	],
},
{
	label: "Not Immunized",
	backgroundColor: "#f2f2f2",
	stack: 'Stack 0',
	data: [
	<?php echo number_format(100 - $immunization['bcg']['percent'],1); ?>,
	<?php echo number_format(100 - $immunization['opv1']['percent'],1); ?>,
	<?php echo number_format(100 - $immunization['hepb1']['percent'],1); ?>, 
	<?php echo number_format(100 - $immunization['opv2']['percent'],1); ?>, 
	<?php echo number_format(100 - $immunization['dpt1']['percent'],1); ?>,
	// <?php echo number_format(100 - $immunization['hepb2']['percent'],1); ?>,
	<?php echo number_format(100 - $immunization['opv3']['percent'],1); ?>,
	<?php echo number_format(100 - $immunization['dpt2']['percent'],1); ?>, 
	// <?php echo number_format(100 - $immunization['hepb3']['percent'],1); ?>,
	<?php echo number_format(100 - $immunization['opv4']['percent'],1); ?>,
	<?php echo number_format(100 - $immunization['dpt3']['percent'],1); ?>,
	// <?php echo number_format(100 - $immunization['hepb4']['percent'],1); ?>,
	<?php echo number_format(100 - $immunization['measeals']['percent'],1); ?>
	],
}],
},

});

new Chart(document.getElementById("bar-chart-institutional"), {
type: 'horizontalBar',
data: {
// labels: ["Instituational"],
datasets: [
{
label: "Instuitutional",
backgroundColor: ["rgb(242,190,0)"],
stack: 'Stack 0',
data: [<?php echo number_format($delivery['place_of_delivery']['percent'],1); ?>]
},
{

label: "Home",
backgroundColor: "#f2f2f2",
stack: 'Stack 0',
data: [
<?php echo number_format(100 - $delivery['place_of_delivery']['percent'],1); ?>
],
}
]
},
options: {
legend: { display: false },
title: {
display: true,
text: 'Place of Delivery'
}
}
});

new Chart(document.getElementById("bar-chart-birthweight"), {
type: 'horizontalBar',
data: {
// labels: ["Instituational"],
datasets: [
{
label: "Normal Birth Weight",
backgroundColor: ["rgb(242,190,0)"],
stack: 'Stack 0',
data: [<?php echo number_format(100 - $delivery['low_weight_birth']['percent'],1); ?>]
},
{
label: "Low Birth Weight",
backgroundColor: "#f2f2f2",
stack: 'Stack 0',
data: [
<?php echo number_format($delivery['low_weight_birth']['percent'],1); ?>
],
}
]
},
options: {
legend: { display: false },
title: {
display: true,
text: 'Normal Birth Weight'
}
}
});

new Chart(document.getElementById("bar-chart-HBNC"), {
type: 'horizontalBar',
data: {
// labels: ["Instituational"],
datasets: [
{
label: "at least 2 visits in 1st 7 days",
backgroundColor: ["rgb(242,190,0)"],
stack: 'Stack 0',
data: [<?php echo number_format($delivery['institutional_delivery']['percent'],1); ?>]
},
{

label: "Less than 2 visits in 1st 7 days",
backgroundColor: "#f2f2f2",
stack: 'Stack 0',
data: [
<?php echo number_format(100 - $delivery['institutional_delivery']['percent'],1); ?>
],
}
]
},
options: {
legend: { display: false },
title: {
display: true,
text: 'HBNC(at least 2 visits in 1st 7 days)'
}
}
});
</script>

<script type="text/javascript">

function showFilterDialog() {
// alert('sfsdf');
$('#myModal').modal('show');
}
$('#StateCode').change(function(){
// alert('sdf');
var StateCode = $(this).val();
$.post('<?php echo site_url('Ajax/getanmLists1/');?>'+StateCode, {}, function(raw){
console.log('in response');
console.log(raw);
$('#ANM').html(raw);
});
});


function get_asha_list() {
var anmid = $('#ANM').val();
$.post('<?php echo site_url("ajax/getAshaOfAnm/");?>' + '/' + anmid, {}, function(raw){
console.log(raw);
$('#Asha').html(raw);
});
}

$(document).ready(function(){
$('#ANM').select2();
$('#Asha').select2();
$('#StateCode').select2();

$("#fixTable").tableHeadFixer({"left" : 1});

});	
</script>

<script type="text/javascript">

var ctx = document.getElementById("ChartHT");
var myLineChart = new Chart(ctx, {
type: 'bar',height: '1000px',
display: true,
autoSkip: false,
data: {
labels:["Sus.", "Dec.", "Fol."],
datasets: [{
label: "HT",
backgroundColor: "rgb(242,190,0)",
borderColor: "rgb(242,190,0)",
stack: 'Stack 0',
data: [
<?php echo $cbac['ht']['suspected'] ?>,
<?php echo $cbac['ht']['detected'] ?>,
<?php echo $cbac['ht']['followup'] ?>
	],
}],
},

});


var ctx = document.getElementById("ChartDB");
var myLineChart = new Chart(ctx, {
type: 'bar',height: '1000px',
display: true,
autoSkip: false,
data: {
labels:["Sus.", "Dec.", "Fol."],
datasets: [{
label: "DB",
backgroundColor: "rgb(242,190,0)",
borderColor: "rgb(242,190,0)",
stack: 'Stack 0',
data: [

<?php echo $cbac['bp']['suspected'] ?>,
<?php echo $cbac['bp']['detected'] ?>,
<?php echo $cbac['bp']['followup'] ?>
	],
}],
},

});




var ctx = document.getElementById("ChartHTandDB");
var myLineChart = new Chart(ctx, {
type: 'bar',height: '1000px',
display: true,
autoSkip: false,
data: {
labels:["Sus.", "Dec.", "Fol."],
datasets: [{
label: "HT and DB",
backgroundColor: "rgb(242,190,0)",
borderColor: "rgb(242,190,0)",
stack: 'Stack 0',
data: [
<?php echo $cbac['ht_bp']['suspected'] ?>,
<?php echo $cbac['ht_bp']['detected'] ?>,
<?php echo $cbac['ht_bp']['followup'] ?>
	],
}],
},

});
</script>