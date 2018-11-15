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
						<h2><b>Add ASHA</b><small>
							Use the form below to add new ASHA
						</small></h2>
					</div>
					<div class="row" style="padding-left:25px;">

						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"> 
							<div class="form-group">
								<div class="select">
									<label for="country">Country</label>
									<select name="country" id="country" class="form-control" data-toggle="dropdown" required>
										<option value="">---select---</option>
										<?php foreach ($Country_List as $row) {?>
										<option value="<?php echo $row->CountryCode;?>"><?php echo $row->CountryName;?>   </option>
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
										<option value="">--select--</option>
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
										</select>
									</div>
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
						
						<p>Villages will be populated here...</p>
					</div>
				</div>

				<div class="card">
					<div class="card-header">
						<h2>Select CHS</h2>
					</div>
					<div class="card-body card-padding">
							<div class="form-group">
								<select name="chs" id="chs" class="form-control">
									<option value="">--select--</option>
								</select>
							</div>
					</div>
				</div>

				<div class="card">
					<div class="card-header">
					</div>
					<div class="card-body card-padding">
						
						<div class="row" style="padding-left:25px;">
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
								<div class="form-group">
									<div class="fg-line">
										<label for="AshaNameEnglish">Asha Name In English</label>
										<input type="text" class="form-control" data-toggle="dropdown" id="AshaNameEnglish" name="AshaNameEnglish" placeholder="Enter Asha Name In English " value="" required>
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


						<!-- <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
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
						</div> -->
					</div>
					<div class="row">
						<div class="col-md-12">
							<button type="submit" class="btn btn-primary">Submit</button>
						</div>
					</div>
				</div>
			</div>

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

	<script type="text/javascript">

		$(document).ready(function(){

			$("#country").change(function(){

				$("#states").html('<option val="">--select--</option>');
				$("#districts").html('<option val="">--select--</option>');
				$("#blocks").html('<option val="">--select--</option>');
				$("#subcenter").html('<option val="">--select--</option>');
				$("#anm").html('<option val="">--select--</option>');

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

				$.ajax({
					url: '<?php echo site_url(); ?>ajax/getChsFromBlock/'+$(this).val(),
					type: 'POST',
					dataType: 'text',
				})
				.done(function(states) {
					console.log("success");

					$("#chs").html(states);
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