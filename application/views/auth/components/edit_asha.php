<?php // echo "<pre>"; print_r($village_boxes); exit; 
	// echo "<pre>"; print_r($asha_active); exit;
?>
<!-- <section id="content">
	<div class="block-header">
		<h2>Manage Asha</h2>
	</div>
	<form action="" method="post">	
		<div class="card">
			<div class="card-header">
				<h2><b>Edit Asha</b><small>
					Use the form below to update Asha
				</small></h2>
			</div>

			<div class="row" style="padding-left:25px;">

				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<div class="form-group">
						<div class="select">
							<label for="StateCode">State Name</label>
							<select class="form-control" data-toggle="dropdown" id="StateCode" name="StateCode" required>
								<option value="">--select--</option>
								<?php foreach($State_List as $row){?>
								<option value="<?php echo $row->StateCode;?>" <?php echo (trim($this->input->post('StateCode')) == $row->StateCode?"selected":"");?>><?php echo $row->StateName;?></option>
											<?php } ?>
							</select>
						</div>
					</div>
				</div>

				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<div class="form-group">
						<div class="select">
							<label for="DistrictCode">District Name</label>
							<select class="form-control" data-toggle="dropdown" id="DistrictCode" name="DistrictCode" >
								<option value="">---select---</option>
								<?php foreach($District_List as $row){?>
								<option value="<?php echo $row->DistrictCode;?>" <?php echo ($Asha_details->DistrictCode == trim($this->input->post("DistrictCode"))?"selected":"");?>><?php echo $row->DistrictName;?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>

				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<div class="form-group">
						<div class="select">
							<label for="BlockID">Block Name</label>
							<select class="form-control" data-toggle="dropdown" id="BlockID" name="BlockID" >
								<option value="">---select---</option>
								<?php foreach($Block_List as $row){?>
								<option value="<?php echo $row->BlockID;?>" <?php echo ($row->BlockID == trim($this->input->post("BlockID"))?"selected":"");?>><?php echo $row->BlockName;?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>

				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"> 
					<div class="form-group">
						<div class="select">
							<label for="PHC_id">PHC</label>
							<select name="PHC_id" id="PHC_id" class="form-control" data-toggle="dropdown">
								<option value="">---select---</option>
								<?php foreach ($PHC_List as $row) {?>
								<option value="<?php echo $row->PHC_id;?>"  <?php echp ($row->PHC_id == trim($this->input->post("PHC_id"))?"selected":"");?>><?php echo $row->PHC_Name;?>   </option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>

				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<div class="form-group">
						<div class="fg-line">
							<div class="select">
								<label for="SubCenterID">Sub Center Name</label>
								<select name="SubCenterID" id="SubCenterID" data-toggle="dropdown" class="form-control" required>
									<option value="">--select--</option>
									<?php foreach ($Subcenter_List as $row) {?>
									<option value="<?php echo $row->SubCenterID;?>"<?php echo (trim($this->input->post('SubCenterID')) == $row->SubCenterID?"selected":"");?>><?php echo $row->SubCenterName;?></option>
									<?php } ?>
								</select>
							</div>
						</div>														
					</div>														
				</div>	

				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<div class="form-group">
						<div class="fg-line">
							<div class="select">
								<label for="VillageCode">Village Name</label>
								<select name="VillageCode" id="VillageCode" data-toggle="dropdown" class="form-control" required>
									<option value="">--select--</option>
									<?php foreach ($Village_List as $row) {?>
									<option value="<?php echo $row->VillageCode;?>"<?php echo (trim($this->input->post('VillageCode')) == $row->VillageCode?"selected":"");?>><?php echo $row->VillageName;?></option>
									<?php } ?>
								</select>
							</div>
						</div>														
					</div>														
				</div>			
			</div>
		</div>


		<div class="card">
			<div class="card-header">
			</div>
			<div class="row" style="padding-left:25px;">
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<div class="form-group">
						<div class="fg-line">
							<label for="AshaNameEnglish">Asha Name In English</label>
							<input type="text" class="form-control" data-toggle="dropdown" id="AshaNameEnglish" name="AshaNameEnglish" placeholder="Enter Asha Name In English " value="<?php print $Asha_details['AshaNameEnglish'];?>" required>
						</div>
					</div>
				</div>

				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<div class="form-group">
						<div class="fg-line">
							<label for="AshaNameHindi">Asha Name In Hindi</label>
							<input type="text" class="form-control" data-toggle="dropdown" id="AshaNameHindi" name="AshaNameHindi" placeholder="Enter Asha Name In Hindi " value="" required>
						</div>														
					</div>														
				</div>	

				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<div class="form-group">
						<div class="fg-line">
							<label for="phone_no">Asha Contact No</label>
							<input type="number" class="form-control" data-toggle="dropdown"
							id="phone_no" name="phone_no" placeholder="Enter Asha Contact No" value="<?php print $Asha_details['phone_no'];?>" required>
						</div>
					</div>
				</div>

				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<div class="form-group">
						<div class="fg-line">
							<label for="email">Asha E-mail </label>
							<input type="text" class="form-control" data-toggle="dropdown" id="email" name="email" placeholder="Enter Asha E-mail " value="" required>
						</div>
					</div>
				</div>	

				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<div class="form-group">
						<div class="fg-line">
							<label for="">Device Id/IMEI No.</label>
							<input type="text" class="form-control" data-toggle="dropdown" id="" name="" placeholder="" value="" required>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="card">
			<div class="card-header">

			</div>

			<div class="row" style="padding-left:25px;">

				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<div class="form-group">
						<div class="select">
							<label for="ANMID">ANM Name</label>
							<select class="form-control" data-toggle="dropdown" id="ANMID" name="ANMID" required>
								<option value="">--select--</option>
								<?php foreach($Anm_List as $row){?>
								<option value="<?php echo $row->ANMID;?>" <?php echo (trim($this->input->post('ANMID')) == $row->ANMID?"selected":"");?>><?php echo $row->ANMName;?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>

				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<div class="form-group">
						<div class="fg-line">
							<label for="SupervisorCode">AF Name</label>
							<select name="SupervisorCode" id="SupervisorCode" data-toggle="dropdown" class="form-control" required>
								<option value="">--select--</option>
								<?php foreach ($Supervisor_List as $row) {?>
								<option value="<?php echo $row->SupervisorCode;?>"<?php echo (trim($this->input->post('SupervisorCode')) == $row->SupervisorCode?"selected":"");?>><?php echo $row->SupervisorName;?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>

				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"  style="padding:25px;"> 
					<button class="btn btn-primary btn-sm m-t-10 pull-right padding:10px;" id="btn_go">Submit</button>
				</div>	
			</div>
		</div>	

		<div class="card">
			<div class="card-header">

			</div>

			<div class="row" style="padding-left:25px;">
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<div class="form-group">
						<div class="fg-line">
							<label for="">User Name</label>
							<input type="text" class="form-control" data-toggle="dropdown" id="" name="" placeholder="" value="" required>
						</div>
					</div>
				</div>

				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<div class="form-group">
						<div class="fg-line">
							<label for="">Password</label>
							<input type="text" class="form-control" data-toggle="dropdown" id="Password" name="Password" placeholder="Password" required>
						</div>

					</div>
				</div>										

				<div  style="text-align:center;";> 
					<button  type="submit" class="btn btn-primary  btn-sm m-t-10 waves-effect">Save</button>

					<a href="<?php echo site_url("admin/asha");?>" class="btn btn-primary btn-sm m-t-10 waves-effect">Reset Password</a>
				</div>
			</div>


		</div>

	</form>
</div>
</section>


<script language="javascript">

	$(document).ready(function(){

		$('#StateCode').change(function(){
			var StateCode = $(this).val();
			$.post('<?php echo site_url('admin/Ajax/getDistrictLists/');?>/'+StateCode, {}, function(raw){
				$('#DistrictCode').html(raw);
			});
		});

		$('#DistrictCode').change(function(){
			var DistrictCode = $(this).val();
			$.post('<?php echo site_url('admin/Ajax/getBlockLists/');?>/'+DistrictCode, {}, function(raw){
				$('#BlockID').html(raw);
			});
		});

		$('#BlockID').change(function(){
			var BlockID= $(this).val();
			$.post('<?php echo site_url('admin/Ajax/getPhcLists/');?>/'+BlockID, {},
				function(raw){
					$('#PHC_id').html(raw);
				});
		});

		$('#PHC_id').change(function(){
			var PHC_id = $(this).val();
			$.post('<?php echo site_url('admin/Ajax/getSubcenterList');?>/'+PHC_id, {}, function(raw){
				$('#SubCenterID').html(raw);
			});
		});

		$('#SubCenterID').change(function(){
			var SubCenterID = $(this).val();
			$.post('<?php echo site_url('admin/Ajax/getAnmListViaSubcenter');?>/'+SubCenterID, {},
				function(raw){
					$('#ANMID').html(raw);
				});
		});

		$('#ANMCode').change(function(){
			var ANMCode = $(this).val();
			$.post('<?php echo site_url('admin/Ajax/getAnmVillageviaAnmCode');?>/'+ANMCode, {}, function(raw){
				$('#VillageCode').html(raw);
			});
		});

	});

</script> -->


<section id="content">
	<div class="block-header">
		<h2>Manage Asha</h2>
	</div>
	<style>

	ul,li { margin:0; padding:0; list-style:none;}
	.label { color:#000; font-size:16px;}
</style>
<?php 
$tr_msg= $this->session->flashdata('tr_msg');
$er_msg= $this->session->flashdata('er_msg');

if(!empty($tr_msg)){ ?>
<div class="content animate-panel">
	<div class="row">
		<div class="col-md-12">
			<div class="hpanel">
				<div class="alert alert-success alert-dismissable alert1"> <i class="fa fa-check"></i>
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<?php echo $this->session->flashdata('tr_msg');?>. </div>
				</div>
			</div>
		</div>
	</div>
	<?php } else if(!empty($er_msg)){?>
	<div class="content animate-panel">
		<div class="row">
			<div class="col-md-12">
				<div class="hpanel">
					<div class="alert alert-danger alert-dismissable alert1"> <i class="fa fa-check"></i>
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<?php echo $this->session->flashdata('er_msg');?>. </div>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>	

		<form action="" method="post">	
			<div class="card">
				<div class="card-header">
					<h2><b>Edit ASHA</b><small>
						Use the form below to edit ASHA
					</small></h2>
					<!-- <h5 style="color: #f2be00;"><b>
						<?php if ($asha_replaced_name[0]->ReplacedBy != 0 ) { ?>

						Replacement From: <a href=""><?php echo $asha_replaced_name[0]->ASHAName; ?></a>

						<?php }
						?></b></h5> -->
					</div>
					<div class="row" style="padding-left:25px;">
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<div class="form-group">
								<div class="fg-line">
									<label for="AshaNameEnglish">Asha Name In English</label>
									<input type="text" class="form-control" data-toggle="dropdown" id="AshaNameEnglish" name="AshaNameEnglish" placeholder="Enter Asha Name In English " value="<?php echo $asha_details[0]->ASHAName; ?>" required>
								</div>
							</div>
						</div>

						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<div class="form-group">
								<div class="fg-line">
									<label for="AshaNameHindi">Asha Name In Hindi</label>
									<input type="text" class="form-control" data-toggle="dropdown" id="AshaNameHindi" name="AshaNameHindi" placeholder="Enter Asha Name In Hindi " value="<?php echo $asha_details[1]->ASHAName; ?>" required>
								</div>														
							</div>														
						</div>	

						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"> 
							<div class="form-group">
								<div class="select">
									<label for="country">Country</label>
									<select name="country" id="country" class="form-control" data-toggle="dropdown" required>
										<option value="">---select---</option>
										<?php foreach ($Country_List as $row) {?>
										<option value="<?php echo $row->CountryCode;?>" <?php if(isset($geo_codes)){ echo ($row->CountryCode == $geo_codes->CountryCode)?"selected":"";} ?>><?php echo $row->CountryName;?>   </option>
										<?php } ?>
									</select>
								</div>
							</div>

						</div>


						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<div class="form-group">
								<div class="select">
									<label for="states">State Name</label>
									<select class="form-control" data-toggle="dropdown" id="states" name="states" required>
										<option value="">---select---</option>
										<?php foreach($states as $row){?>
										<option value="<?php echo $row->StateCode;?>" <?php if(isset($geo_codes)){ echo ($row->StateCode == $geo_codes->StateCode)?"selected":"";} ?>><?php echo $row->StateName;?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>

						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<div class="form-group">
								<div class="select">
									<label for="districts">District Name</label>
									<select class="form-control" data-toggle="dropdown" id="districts" name="districts" >
										<option value="">---select---</option>
										<?php foreach($districts as $row){?>
										<option value="<?php echo $row->DistrictCode;?>" <?php if(isset($geo_codes)){ echo ($row->DistrictCode == $geo_codes->DistrictCode)?"selected":"";} ?>><?php echo $row->DistrictName;?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>

						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<div class="form-group">
								<div class="select">
									<label for="blocks">Block Name</label>
									<select class="form-control" data-toggle="dropdown" id="blocks" name="blocks" >
										<option value="">---select---</option>
										<?php foreach($blocks as $row){?>
										<option value="<?php echo $row->BlockCode;?>" <?php if(isset($geo_codes)){ echo ($row->BlockCode == $geo_codes->BlockCode)?"selected":"";} ?>><?php echo $row->BlockName;?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>

						<!-- <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"> 
							<div class="form-group">
								<div class="select">
									<label for="PHC_id">PHC</label>
									<select name="PHC_id" id="PHC_id" class="form-control" data-toggle="dropdown">
										<option value="">---select---</option>
										<?php foreach ($PHC_List as $row) {?>
										<option value="<?php echo $row->PHC_id;?>"  <?php echp ($row->PHC_id == trim($this->input->post("PHC_id"))?"selected":"");?>><?php echo $row->PHC_Name;?>   </option>
										<?php } ?>
									</select>
								</div>
							</div>

						</div> -->

						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<div class="form-group">
								<div class="fg-line">
									<div class="select">
										<label for="subcenter">Sub Center Name</label>
										<select name="subcenter" id="subcenter" data-toggle="dropdown" class="form-control" required>
											<option value="">--select--</option>
											<?php foreach($subcenters as $row){?>
											<option value="<?php echo $row->SubCenterCode;?>" <?php if(isset($geo_codes)){ echo ($row->SubCenterCode == $geo_codes->SubCenterCode)?"selected":"";} ?>><?php echo $row->SubCenterName;?></option>
											<?php } ?>
										</select>
									</div>
								</div>														
							</div>														
						</div>	

						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<div class="form-group">
								<div class="fg-line">
									<div class="select">
										<label for="anm">ANM Name</label>
										<select name="anm" id="anm" data-toggle="dropdown" class="form-control" required>
											
											<option value="">--select--</option>
											<?php foreach($anm_list as $row){?>
											<option value="<?php echo $row->ANMCode;?>" <?php if(isset($geo_codes)){ echo ($row->ANMCode == $Anm_details[0]->ANMCode)?"selected":"";} ?>><?php echo $row->ANMName;?></option>
											<?php } ?>
										</select>
									</div>
								</div>														
							</div>														
						</div>

						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<div class="form-group">
								<div class="fg-line">
									<label for="imei1">Device Id/IMEI No. 1</label>
									<input type="text" class="form-control" data-toggle="dropdown" id="imei1" name="imei1" placeholder="Enter IMEI 1 " value="<?php echo $User_IMEI[0]->imei1;?>" >
								</div>														
							</div>														
						</div>	


						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<div class="form-group">
								<div class="fg-line">
									<label for="imei2">Device Id/IMEI No. 2</label>
									<input type="text" class="form-control" data-toggle="dropdown" id="imei2" name="imei2" placeholder="Enter IMEI 2 " value="<?php echo $User_IMEI[0]->imei2;?>" >
								</div>														
							</div>														
						</div>

					</div>
				</div>

				
				<div class="card">
					<div class="card-header">
						<h2>Select Villages</h2>
					</div>

					<div class="row">
						<div class="card-body card-padding col-lg-6 " id="villages" >

							<?php if($village_boxes != '') 
							{
								echo $village_boxes;
							}
							else
							{
								echo '<p>Villages will be populated here...</p>';
							}
							?>
							<br>
						</div>


						<div class="card-body card-padding col-lg-6 " id="anmvillages" style="color: red;">
							<?php if($village_anm_boxes != '') 
							{
								echo $village_anm_boxes;
							}
							else
							{
								echo '<p>Villages will be populated here...</p>';
							}
							?>
							<br>
						</div>
					</div>
				</div>
				<div class="card">
					
					<div class="card-body card-padding" >
						<div class="row" style="padding-left:25px;">
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
								<div class="form-group">
									<div class="fg-line">
										<div class="select">	
											<label for="IsActive"><b>Status</b></label>									
											<select class="form-control" data-toggle="dropdown" id="IsActive" name="IsActive">
												<option value="" >--select--</option>
												<option value="1" <?php echo($asha_details[0]->IsActive == 1?"selected":""); ?>>Active</option>
												<option value="0" <?php echo($asha_details[0]->IsActive == 0?"selected":""); ?>>InActive</option>
											</select>
										</div>
									</div>														
								</div>														
							</div>	


							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" id="reason">
								<div class="form-group">
									<div class="fg-line">
										<div class="select">
											<label for="LeaveStatus"><b>Reason</b></label>
											<select class="form-control" data-toggle="dropdown" id="LeaveStatus" name="LeaveStatus">
												<option value="" >--Reason--</option>
												<option value="1" <?php echo($asha_details[0]->LeaveStatus == 1?"selected":""); ?>>Retired</option>
												<option value="2" <?php echo($asha_details[0]->LeaveStatus == 2?"selected":""); ?>>Left</option>
												<option value="3" <?php echo($asha_details[0]->LeaveStatus == 3?"selected":""); ?>>Death</option>
												<!-- <option value="4" <?php echo($asha_leave[0]->LeaveStatus == 4?"selected":""); ?>>Replacement</option> -->
											</select>
										</div>
									</div>														
								</div>														
							</div>	

							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" id="lwd">
								<div class="form-group">
									<div class="fg-line">
										<label for="LastWorkingDate"><b>Last Working Date</b></label>
										<input type="date" id="LastWorkingDate" name="LastWorkingDate" class="datepicker form-control" value="<?php echo $asha_details[0]->LastWorkingDate;?>">
									</div>														
								</div>														
							</div>	
							
							<br>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" id="replacement">		
								<button type="submit" name="mode" value="addreplacement" class="btn btn-round btn-success" style="background: #f2be00; border-color: #f2be00;">Add Replacement</button> 
							</div>

						</div>

						<!-- <div class="row" id="add_new">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" >
								<h4><b>Replacement</b></h4>
								<div class="form-group">
									<div class="fg-line">
											<div class="select">
										<?php if ($asha_details[0]->ReplacedBy != NULL) { ?>
						
										Replaced By: <a href=""><?php echo $asha_details[0]->ASHAName; ?></a>
						
										<?php }else{ ?>
						
											Replace by: <select class="form-control" name="ReplacedBy" id="ReplacedBy"  data-toggle="dropdown">
												<option value="">--select--</option>
												<?php foreach ($asha_of_anm as $asha_row) { ?>
						
												<option value="<?php echo $asha_row->ASHACode;?>"><?php echo $asha_row->ASHAName;?></option>
												<?php } ?>
											</select>
										</div>
						
										<?php } ?>  
									</div>
								</div>
							</div>
						</div> -->
					</div>

					<div class="card-body card-padding" id="hidden_message" style="display: none;color: red;"><h5>Message :Before Submit Please ensure that proper data upload from the <b>ASHA</b> device or not who is being removed.
					Take an email confirmation from Field Incharge with counts.</h5></div>


					<div class="card-body card-padding" style="text-align: center;">
						<button type="submit" class="btn btn-primary" data-toggle="confirmation" data-singleton= "true" data-placement="right" data-title="Do you want to submit"  >Submit</button>
					</div>
				</div>



				<div class="card" id="extracharge">
					<div class="card-header">
						<h2>Extra Charge</h2>	<br>			

						<a href="<?php echo site_url('asha/extracharge/'. $asha_details[0]->ASHAUID);?>" class="btn btn-primary" data-toggle="confirmation" data-singleton= "true" data-placement="right" data-title="Before Addding Extra Charge please ensure that proper data upload from the ASHA device or not .Take an Emial Confirmation from the Field Incharge. DO you want to proceed ?" >Add New</a>					
					</div>

					<div class="card-body card-padding" >

						<table id="data-table-command" class="table table-striped table-vmiddle" width="100%" height="100%">
							<thead>
								<tr>
									<th data-column-id="ID" data-visible="false" style="background-color: #f2be00; color: white;" class="text-center">ID</th>
									<th data-column-id="ChargeOf" style="background-color: #f2be00; color: white;" class="text-center">Charged To</th>
									<th data-column-id="ChargeType" style="background-color: #f2be00; color: white;" class="text-center">Charge Type</th>
									<th data-column-id="EndDate" style="background-color: #f2be00; color: white;" class="text-center">Last Working Date</th>
									<th style="background-color: #f2be00; color: white;" class="text-center" data-column-id="commands" data-formatter="commands" data-sortable="false">Delete</th>
								</tr>		

							</thead>


							<tbody>
								<?php if(!empty($asha_name)) {
									foreach($asha_name as $row){ ?>
									<tr>
										<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php echo $row->ID; ?></td>
										<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php echo $row->ASHAName; ?></td>
										<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php echo ($row->ChargeType==1?"Temporary":"Permanent"); ?></td>
										<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php echo $row->EndDate; ?></td>
									</tr>
									<?php } }?> 


								</tbody>

							</table>




<!-- 
						<div class="row" style="padding-left:25px;">
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
								<div class="form-group">
									<div class="fg-line">
										<div class="select">
											<?php if ($asha_replaced_name[0]->ReplacedBy != NULL) { ?>

											Replaced By: <a href=""><?php echo $asha_details[0]->ASHAName; ?></a>

											<?php }else{ ?>

											Replace by: <select class="form-control" name="ReplacedBy" id="ReplacedBy"  data-toggle="dropdown">
												<option value="">--select--</option>
												<?php foreach ($asha_of_anm as $asha_row) { ?>

												<option value="<?php echo $asha_row->ASHACode;?>"><?php echo $asha_row->ASHAName;?></option>
												<?php } ?>
											</select>

											<?php } ?>  
										</div>  
									</div>
								</div>
							</div>


							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
								<div class="form-group">
									<div class="fg-line">
										<div class="select">
											
											Charge Type: <select class="form-control" data-toggle="dropdown" id="Charge_type" name="Charge_type" onchange="myFunction()">
												<option value="" >--select--</option>

												<option value="1" >Temporary</option>
												<option value="2">Permanent</option>
											</select> 
										</div>
									</div>
								</div>
							</div>



							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" id="lwd">
								<div class="form-group">
									<div class="fg-line">
										<label for="End_date"><b>End Date</b></label>
										<input type="date" class="form-control" data-toggle="dropdown" id="End_date" name="End_date"  value="<?php echo $asha_leave[0]->LastWorkingDate;?>">
									</div>														
								</div>														
							</div>	

						</div> -->

					</div>


					<br>


					
				</div>
				


			<!-- 	<div class="card">
					<div class="card-header">
					</div>
					<div class="card-body card-padding">
						
					<div class="row" style="padding-left:25px;">
					


						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<div class="form-group">
								<div class="fg-line">
									<label for="phone_no">Asha Contact No</label>
									<input type="number" class="form-control" data-toggle="dropdown"
									id="phone_no" name="phone_no" placeholder="Enter Asha Contact No" value="" required>
								</div>
							</div>
						</div>

						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<div class="form-group">
								<div class="fg-line">
									<label for="email">Asha E-mail </label>
									<input type="text" class="form-control" data-toggle="dropdown" id="email" name="email" placeholder="Enter Asha E-mail " value="" required>
								</div>
							</div>
						</div>	

						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<div class="form-group">
								<div class="fg-line">
									<label for="">Device Id/IMEI No.</label>
									<input type="text" class="form-control" data-toggle="dropdown" id="" name="" placeholder="" value="" required>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<button type="submit" class="btn btn-primary">Submit</button>
						</div>
					</div>
					</div>
				</div> -->

				<!-- <div class="card">
					<div class="card-header">

					</div>

					<div class="row" style="padding-left:25px;">

						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<div class="form-group">
								<div class="select">
									<label for="ANMID">ANM Name</label>
									<select class="form-control" data-toggle="dropdown" id="ANMID" name="ANMID" required>
										<option value="">--select--</option>
										<?php foreach($Anm_List as $row){?>
										<option value="<?php echo $row->ANMID;?>" <?php echo (trim($this->input->post('ANMID')) == $row->ANMID?"selected":"");?>><?php echo $row->ANMName;?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>

						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<div class="form-group">
								<div class="fg-line">
									<label for="SupervisorCode">AF Name</label>
									<select name="SupervisorCode" id="SupervisorCode" data-toggle="dropdown" class="form-control" required>
										<option value="">--select--</option>
										<?php foreach ($Supervisor_List as $row) {?>
										<option value="<?php echo $row->SupervisorCode;?>"<?php echo (trim($this->input->post('SupervisorCode')) == $row->SupervisorCode?"selected":"");?>><?php echo $row->SupervisorName;?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>	
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"  style="padding:25px;"> 
					<button class="btn btn-primary btn-sm m-t-10 pull-right padding:10px;" id="btn_go">Submit</button>
				</div>
					</div>

				</div>	 -->	

				
				
			</div>
		</form>

	</section>

	<style type="text/css">
	#reason,#lwd,#hidden_message,#replacement {  }
</style>

<style type="text/css">
#add_new {}
</style>
<script type="text/javascript">
	$('#IsActive').load('change', function() {
		if(this.value == "1") {
			$('#reason').hide();
			$('#lwd').hide();
			$('#add_new').hide();
			$('#hidden_message').hide();
			$('#replacement').hide();

		}
	});




</script>

<script type="text/javascript">


	$('#IsActive').on('change', function() {
		if(this.value == "1") {
			$('#reason').hide(1000);
			$('#lwd').hide(1000);
			$('#add_new').hide(1000);
			$('#hidden_message').hide(1000);
			$('#replacement').hide(1000);

		}else {
			$('#reason').show(1000);
			$('#lwd').show(1000);
			$('#add_new').show(1000);
			$('#hidden_message').show(1000);
			$('#replacement').show(1000);
		}
	});



	$('#IsActive').on('change', function() {
		if(this.value == "1") {
			$('#message').hide(1000);
			

		}else {
			$('#message').show(1000);
			
		}
	});

	$('#Reason').on('change', function() {
		if(this.value == "4") {
			$('#add_new').show(1000);

		} else {
			$('#add_new').hide(1000);
		}
	});

	
</script>



<script type="text/javascript">

	$(document).ready(function(){

		$("#country").change(function(){

			$("#states").html("<option val=''>--select--</option>");
			$("#districts").html("<option val=''>--select--</option>");
			$("#blocks").html("<option val=''>--select--</option>");
			$("#subcenter").html("<option val=''>--select--</option>");
			$("#anm").html("<option val=''>--select--</option>");

			$.ajax({
				url: '<?php echo site_url(); ?>ajax/getStates/'+$(this).val(),
				type: 'POST',
				dataType: 'text',
			})
			.done(function(states) {
				console.log("success");

				$("#states").html(states);
				console.log(states);
			})
			.fail(function() {
				console.log("error");
			})
			.always(function() {
				console.log("complete");
			});

		});

		$("#states").change(function(){


			$("#districts").html('<option>--select--</option>');
			$("#blocks").html('<option>--select--</option>');
			$("#subcenter").html('<option>--select--</option>');
			$("#anm").html('<option>--select--</option>');

			$.ajax({
				url: '<?php echo site_url(); ?>ajax/getDistrictLists/'+$(this).val(),
				type: 'POST',
				dataType: 'text',
			})
			.done(function(states) {
				console.log("success");

				$("#districts").html(states);
				console.log(states);
			})
			.fail(function() {
				console.log("error");
			})
			.always(function() {
				console.log("complete");
			});

		});

		$("#districts").change(function(){


			$("#blocks").html('<option>--select--</option>');
			$("#subcenter").html('<option>--select--</option>');
			$("#anm").html('<option>--select--</option>');

			$.ajax({
				url: '<?php echo site_url(); ?>ajax/getBlockLists/'+$(this).val(),
				type: 'POST',
				dataType: 'text',
			})
			.done(function(states) {
				console.log("success");

				$("#blocks").html(states);
				console.log(states);
			})
			.fail(function() {
				console.log("error");
			})
			.always(function() {
				console.log("complete");
			});

		});

		$("#blocks").change(function(){


			$("#subcenter").html('<option>--select--</option>');
			$("#anm").html('<option>--select--</option>');

			$.ajax({
				url: '<?php echo site_url(); ?>ajax/getSubcenterFromBlock/'+$(this).val(),
				type: 'POST',
				dataType: 'text',
			})
			.done(function(states) {
				console.log("success");

				$("#subcenter").html(states);
				console.log(states);
			})
			.fail(function() {
				console.log("error");
			})
			.always(function() {
				console.log("complete");
			});

		});

		$("#subcenter").change(function(){

			$("#anm").html('<option>--select--</option>');

			$.ajax({
				url: '<?php echo site_url(); ?>ajax/getAnmListViaSubcenter_anmcode/'+$(this).val(),
				type: 'POST',
				dataType: 'text',
			})
			.done(function(states) {
				console.log("success");

				$("#anm").html(states);
				console.log(states);
			})
			.fail(function() {
				console.log("error");
			})
			.always(function() {
				console.log("complete");
			});

		});

		$("#anm").change(function(){

			$.ajax({
				url: '<?php echo site_url(); ?>ajax/getVillagesForANM_checkboxes/'+$(this).val(),
				type: 'POST',
				dataType: 'text',
			})
			// .done(function(states) {
			// 	console.log("success");

			// 	$("#villages").html(states);
			// 	console.log(states);
			// })
			.done(function(states) {
				console.log("success");

				$("#anmvillages").html(states);
				console.log(states);
			})
			.fail(function() {
				console.log("error");
			})
			.always(function() {
				console.log("complete");
			});

		});

		var Status_check = $("#IsActive").val();
		if(Status_check == 0){
			$('#extracharge').hide();		
		}

		$("#IsActive").on('change', function(){
			var Status_change = $("#IsActive").val();
		// alert(Status_change);
		if(Status_change == 0){
			$('#extracharge').hide(1000);

		}

		else
		{
			$('#extracharge').show(1000);

		}

	});
	});
</script>

<!-- Data Table -->
<script type="text/javascript">
	$(document).ready(function(){
				//Command Buttons
				$("#data-table-command").bootgrid({
					css: {
						icon: 'zmdi icon',
						iconColumns: 'zmdi-view-module',
						iconDown: 'zmdi-expand-more',
						iconRefresh: 'zmdi-refresh',
						iconUp: 'zmdi-expand-less'
					},
					formatters: {
						"commands": function(column, row) {
							// raw = JSON.stringify(row);
							// alert(raw);
							return  "<a href=\"<?php echo site_url('asha/delete_extra_charge');?>/" + row.ID + "\" type=\"button\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\"" + row.ID + "\"  data-toggle=\"confirmation\"data-singleton=\"true\" data-placement=\"left\" data-title=\"Proceed to delete?\" ><span class=\"zmdi zmdi-flattr\"></span></a>";

						},

						"formatLanguage": function(column, row){

							if(row.LanguageID == 1){
								language = "English";
							}else{
								language = "हिंदी ";
							}

							return language;
						}

					}
				}).on("loaded.rs.jquery.bootgrid", function () {
					/* Executes after data is loaded and rendered */
					if ($('[data-toggle="tooltip"]')[0]) {
						$('[data-toggle="tooltip"]').tooltip();
					}

					$('[data-toggle=confirmation]').confirmation({
						rootSelector: '[data-toggle=confirmation]',
					});

				});
			});

	function deleteAlert() {

		return confirm("Before Addding Extra Charge please ensure that proper data upload from the ASHA device or not .Take an Emial Confirmation from the Field Incharge. ?");
	}
</script>