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
								<label for="imei1">IMEI 1</label>
								<input type="text" class="form-control" data-toggle="dropdown" id="imei1" name="imei1" placeholder="Enter IMEI 1 " value="<?php echo $User_IMEI[0]->imei1;?>" required>
							</div>														
						</div>														
					</div>	


					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
						<div class="form-group">
							<div class="fg-line">
								<label for="imei2">IME 2</label>
								<input type="text" class="form-control" data-toggle="dropdown" id="imei2" name="imei2" placeholder="Enter IMEI 2" value="<?php echo $User_IMEI[0]->imei2;?>" required>
							</div>														
						</div>														
					</div>
				</div>
			</div>


			<div class="card">
				<div class="card-header">
					<h2>Select Villages</h2>
				</div>
				<div class="card-body card-padding" id="villages">
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


				<div class="card-body card-padding" style="text-align: center;">
					<button type="submit" class="btn btn-primary">Submit</button>
				</div>

			</div>

			<br>
		</form>

	</section>

	<style type="text/css">
	#reason,#lwd {}
</style>

<style type="text/css">
#add_new { }
</style>

<script type="text/javascript">
	$('#IsActive').load('change', function() {
		if(this.value == "1") {
			$('#reason').hide();
			$('#lwd').hide();
			$('#add_new').hide();

		}
	});
</script>

<script type="text/javascript">


	$('#IsActive').on('change', function() {
		if(this.value == "1") {
			$('#reason').hide();
			$('#lwd').hide();
			$('#add_new').hide();

		}else {
			$('#reason').show();
			$('#lwd').show();
			$('#add_new').show();
		}
	});

	$('#Reason').on('change', function() {
		if(this.value == "4") {
			$('#add_new').show();

		} else {
			$('#add_new').hide();
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
			.done(function(states) {
				console.log("success");

				$("#villages").html(states);
				console.log(states);
			})
			.fail(function() {
				console.log("error");
			})
			.always(function() {
				console.log("complete");
			});

		});
	});
</script>