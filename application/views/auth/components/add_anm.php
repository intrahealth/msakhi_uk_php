<section id="content">
	<div class="block-header">
		<h2>Manage ANM</h2>
	</div>

	<div class="card">
		<div class="card-header">
			<h2><b>Add ANM</b><small>
				Use the form below to add new ANM
			</small></h2>
		</div>
		<div class="card-body card-padding">
			<form role="form" method="post" action="">
				<h4>ANM Details</h4>
				<div class="row" style="padding-left:25px;">

					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
						<div class="form-group">
							<div class="select">
								<label for="country">Country</label>
								<select class="form-control" data-toggle="dropdown" id="country" name="country" required>
									<option value="">--select--</option>
									<?php foreach($countries as $row){?>
									<option value="<?php echo $row->CountryCode;?>" ><?php echo $row->CountryName;?></option>
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
										</select>
									</div>
								</div>														
							</div>														
						</div>	

						<!-- <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
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
					</div>
					<br>

					<div class="form-group fg-line">
						<label for="ANMNameEnglish">ANM Name In English </label>
						<input type="text" class="form-control" data-toggle="dropdown" id="ANMNameEnglish" name="ANMNameEnglish" placeholder="Enter ANM Name In English" value="" required>
					</div>


					<div class="form-group fg-line">
						<label for="ANMNameHindi">ANM Name In Hindi </label>
						<input type="text" class="form-control" data-toggle="dropdown" id="ANMNameHindi" name="ANMNameHindi" placeholder="Enter ANM Name In Hindi" value="" required>
					</div>

					<button type="submit" class="btn btn-primary btn-sm m-t-10">Submit</button>

				</form>

			</div>
		</div>
	</section>


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