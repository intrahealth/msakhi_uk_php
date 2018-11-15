<!-- <?php // echo "<pre>"; print_r($anm_active); exit; ?> -->
<!-- 						<section id="content">
							<div class="block-header">
								<h2>Manage ANM</h2>
							</div>

							<div class="card">
								<div class="card-header">
									<h2><b>Edit ANM</b><small>
										Use the form below to Edit ANM
									</small></h2>
								</div>

								<div class="card-body card-padding">
									<form role="form" method="post" action="">
										<h4>ANM Details</h4>

										<div class="form-group fg-line">
											<label for="ANMNameEnglish">ANM Name In English </label>
											<input type="text" class="form-control" data-toggle="dropdown" id="ANMNameEnglish" name="ANMNameEnglish" placeholder="Enter ANM Name In English" value="<?php print $Anm_details['ANMNameEnglish'];?>" required>
										</div>

										<div class="form-group fg-line">
											<label for="ANMNameHindi">ANM Name in Hindi </label>
											<input type="text" class="form-control" data-toggle="dropdown" id="ANMNameHindi" name="ANMNameHindi" placeholder="Enter ANM Name in Hindi" value="<?php print $Anm_details['ANMNameHindi'];?>" required>
										</div>

										<button type="submit" class="btn btn-primary btn-sm m-t-10">Submit</button>

									</form>

								</div>
							</div>
						</section> -->



						<section id="content">
							<div class="block-header">
								<h2>Manage ANM</h2>
							</div>

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

									<form role="form" method="post" action="">
										<div class="card">
											<div class="card-header">
												<h2><b>Edit ANM</b><small>
													Use the form below to edit ANM
												</small></h2>

										<!-- <h5 style="color: #f2be00;"><b>
											<?php if ($anm_record[0]->ReplacedBy != 0 ) { ?>

											Replacement From: <a href=""><?php echo $anm_record[0]->ANMName; ?></a>

											<?php }
											?></b></h5> -->
										</div>
										<div class="card-body card-padding">

											<h4>ANM Details</h4>
											<div class="row" style="padding-left:25px;">


												<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
													<div class="form-group fg-line">
														<label for="ANMNameEnglish">ANM Name In English </label>
														<input type="text" class="form-control" data-toggle="dropdown" id="ANMNameEnglish" name="ANMNameEnglish" placeholder="Enter ANM Name In English" value="<?php echo $Anm_details['ANMNameEnglish']; ?>" required>
													</div>
												</div>

												<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
													<div class="form-group fg-line">
														<label for="ANMNameHindi">ANM Name In Hindi </label>
														<input type="text" class="form-control" data-toggle="dropdown" id="ANMNameHindi" name="ANMNameHindi" placeholder="Enter ANM Name In Hindi" value="<?php echo $Anm_details['ANMNameHindi']; ?>" required>
													</div>
												</div>

												<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
													<div class="form-group">
														<div class="select">
															<label for="country">Country</label>
															<select class="form-control" data-toggle="dropdown" id="country" name="country" required>
																<option value="">--select--</option>
																<?php foreach($countries as $row){?>
																<option value="<?php echo $row->CountryCode;?>" <?php echo ($row->CountryCode == $geo_codes->CountryCode)?"selected":"" ?>><?php echo $row->CountryName;?></option>
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
																<option value="<?php echo $row->StateCode;?>" <?php echo ($row->StateCode == $geo_codes->StateCode)?"selected":"" ?>><?php echo $row->StateName;?></option>
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
																<option value="<?php echo $row->DistrictCode;?>" <?php echo ($row->DistrictCode == $geo_codes->DistrictCode)?"selected":"" ?>><?php echo $row->DistrictName;?></option>
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
																<option value="<?php echo $row->BlockCode;?>" <?php echo ($row->BlockCode == $geo_codes->BlockCode)?"selected":"" ?>><?php echo $row->BlockName;?></option>
																<?php } ?>
															</select>
														</div>
													</div>
												</div>
<!-- 
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"> 
							<div class="form-group">
								<div class="select">
									<label for="phc">PHC</label>
									<select name="phc" id="phc" class="form-control" data-toggle="dropdown">
										<option value="">---select---</option>
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
											<option value="<?php echo $row->SubCenterCode;?>" <?php echo ($row->SubCenterCode == $geo_codes->SubCenterCode)?"selected":"" ?>><?php echo $row->SubCenterName;?></option>
											<?php } ?>
										</select>
									</div>
								</div>														
							</div>														
						</div>	
<!-- 
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<div class="form-group">
								<div class="fg-line">
									<div class="select">
										<label for="villages">Village Name</label>
										<select name="villages" id="villages" data-toggle="dropdown" class="form-control" required>
											<option value="">--select--</option>
										</select>
									</div>
								</div>														
							</div>														
						</div>	 -->		

						<br>

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

					</div></div></div>

					<div class="card">

						<div class="card-body card-padding">
							<div class="row" style="padding-left:25px;">
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
									<div class="form-group">
										<div class="fg-line">
											<div class="select">	
												<label for="IsActive"><b>Status</b></label>									
												<select class="form-control" data-toggle="dropdown"  id="IsActive" name="IsActive">
													<option value="" >--select--</option>
													<option value="1" <?php echo($anm_active->IsActive == 1?"selected":""); ?>>Active</option>
													<option value="0" <?php echo($anm_active->IsActive == 0?"selected":""); ?>>InActive</option>
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
													<option value="1" <?php echo($anm_record[0]->LeaveStatus == 1?"selected":""); ?>>Retired</option>
													<option value="2" <?php echo($anm_record[0]->LeaveStatus == 2?"selected":""); ?>>Left</option>
													<option value="3" <?php echo($anm_record[0]->LeaveStatus == 3?"selected":""); ?>>Death</option>
													<!-- <option value="4" <?php echo($anm_record[0]->LeaveStatus == 4?"selected":""); ?>>Replacement</option> -->
												</select>
											</div>
										</div>														
									</div>														
								</div>	

								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" id="lwd">
									<div class="form-group">
										<div class="fg-line">
											<label for="LastWorkingDate"><b>Last Working Date</b></label>
											<input type="date" class="form-control datepicker"  id="LastWorkingDate" name="LastWorkingDate"  value="<?php echo $anm_record[0]->LastWorkingDate;?>">
										</div>														
									</div>														
								</div>	


								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" id="lwd">

									<button type="submit" name="mode" value="addreplacement" class="btn btn-round btn-success" style="background: #f2be00; border-color: #f2be00;" id="replacement">Add Replacement</button> 
								</div>
							</div>					
						</div>

						<div id="hidden_message" style="display: none;text-align: center;color: red;"><h5>Warning :Before Submit Please ensure that proper data upload from the <b>ASHA</b> device or not who is being removed.
						Take an email confirmation from Field Incharge with counts.</h5>
					</div>

					<div class="card-body card-padding" style="text-align: center;">
						<button type="submit" class="btn btn-primary" data-toggle="confirmation" data-singleton= "true" data-placement="right" data-title="Do you want to submit"  >Submit</button>
					</div>
				</div>



			</form>

		</div>


		<div class="card" id="extracharge">

			<div class="card-header">
				<h2>Extra Charge</h2>	<br>
				<a href="<?php echo site_url('anm/extracharge/'. $Anm_charge_details[0]->ANMUID);?>" class="btn btn-primary" data-toggle="confirmation" data-singleton="true" data-placement="right" data-title="Before Addding Extra Charge please ensure that proper data upload from the ANM device or not .Take an Emial Confirmation from the Field Incharge. DO you want to proceed ?">Add New</a>			
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
						<?php if(!empty($anm_name)) {
							foreach($anm_name as $row){ ?>
							<tr>
								<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php echo $row->ID; ?></td>
								<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php echo $row->ANMName; ?></td>
								<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php echo ($row->ChargeType==1?"Temporary":"Permanent"); ?></td>
								<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php  echo $row->EndDate; ?></td>
							</tr>
							<?php } }?> 


						</tbody>
					</table>
				</div>
				<br>


			</div>
		</div>
	</section>

	<style type="text/css">
	#reason,#lwd,#hidden_message,#replacement {  }
</style>

<style type="text/css">
#add_new {}
</style>


<script type="text/javascript">

	$(document).ready(function(){
		var Status_check = $("#IsActive").val();
		if(Status_check == 1){
			$('#reason').hide();
			$('#lwd').hide();
			$('#hidden_message').hide();
			$('#replacement').hide();
		}

		$("#IsActive").on('change', function(){
			var Status_change = $("#IsActive").val();
		// alert(Status_change);
		if(Status_change == 1){
			$('#reason').hide(1000);
			$('#lwd').hide(1000);
			$('#hidden_message').hide(1000);
			$('#replacement').hide(1000);
		}

		else
		{
			$('#reason').show(1000);
			$('#lwd').show(1000);
			$('#hidden_message').show(1000);
			$('#replacement').show(1000);
		}

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


<script type="text/javascript">

	$(document).ready(function(){

		$("#country").change(function(){

			$("#states").html('<option>--select--</option>');
			$("#districts").html('<option>--select--</option>');
			$("#blocks").html('<option>--select--</option>');
			$("#subcenter").html('<option>--select--</option>');

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

		// $("#phc").change(function(){

		// 	$.ajax({
		// 		url: '<?php echo site_url(); ?>ajax/getSubcenterList_code/'+$(this).val(),
		// 		type: 'POST',
		// 		dataType: 'text',
		// 	})
		// 	.done(function(states) {
		// 		console.log("success");

		// 		$("#subcenter").html(states);
		// 		console.log(states);
		// 	})
		// 	.fail(function() {
		// 		console.log("error");
		// 	})
		// 	.always(function() {
		// 		console.log("complete");
		// 	});

		// });

		// $("#subcenter").change(function(){

		// 	$.ajax({
		// 		url: '<?php echo site_url(); ?>ajax/getVillagesForSubcenter/'+$(this).val(),
		// 		type: 'POST',
		// 		dataType: 'text',
		// 	})
		// 	.done(function(states) {
		// 		console.log("success");

		// 		$("#villages").html(states);
		// 		console.log(states);
		// 	})
		// 	.fail(function() {
		// 		console.log("error");
		// 	})
		// 	.always(function() {
		// 		console.log("complete");
		// 	});

		// });
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
							return  "<a href=\"<?php echo site_url('anm/delete_extra_charge');?>/" + row.ID + "\" type=\"button\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\"" + row.ID + "\"  data-toggle=\"confirmation\"data-singleton=\"true\" data-placement=\"left\" data-title=\"Proceed to delete?\" ><span class=\"zmdi zmdi-flattr\"></span></a>";

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
		</script>