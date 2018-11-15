<!-- <?php // echo $redire_asha; exit;?> -->
<section id="content">
	<div class="block-header">
		<h2>Manage Extra Charge</h2>
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
					<h2><b>Extra Charge</b><small>
					</small></h2>
				</div>
				<div class="row" style="padding-left:25px;">
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
						<div class="form-group">
							<div class="fg-line">
								<div class="select">
									<label for="ReplacedBy"><b>Name:</b></label>

									<select class="form-control" name="ReplacedBy" id="ReplacedBy"  data-toggle="dropdown">
										<option value="">--select--</option>
										<?php foreach ($asha_of_anm as $asha_row) { ?>

										<option value="<?php echo $asha_row->ASHAUID;?>"><?php echo $asha_row->ASHAName;?></option>
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
									<label for="Charge_Type"><b>Charge Type:</b></label>
									<select class="form-control" data-toggle="dropdown" id="ChargeType" name="ChargeType" onchange="myFunction()">
										<option value="" >--select--</option>

										<option value="1" >Temporary</option>
										<option value="2">Permanent</option>
									</select> 
								</div>
							</div>														
						</div>														
					</div>	

					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12"> 
						<div class="form-group">
							<label for="EndDate"><b>End Date</b></label>
							<input type="date" class="datepicker form-control"  id="EndDate" name="EndDate"  value="">
						</div>

					</div>
					<br />
					<br />
					<br />

					<div class="card-body card-padding" style="text-align: center;">
						<button type="submit" class="btn btn-primary">Submit</button>
					</div>

				</div>
			</div>


		</form>

	</section>

	<style type="text/css">
	#reason,#lwd {}
</style>

<style type="text/css">
#add_new { }
</style>
<script>
	// $(document).ready(function(){
	// 	// alert('is here');
	// 	// $('#ReplacedBy').on('change', function){
	// 	// 	alert($('#ReplacedBy').val());
	// 	// 	// $.ajax({
	// 	// 	// 	type: "POST",
	// 	// 	// 	url: "<?php // echo site_url('asha/check_extra_charge'); ?>",
	// 	// 	// 	success: function(result){
 //  //  //      		// alert(result);
 //  //  //      		console.log(result);
 //  //  //      	}
 //  //  //      	});
 //  //   });
	// });
</script>



<script type="text/javascript">

	$(document).ready(function(){
		// alert('welcome');
		// var redirect_asha = '<?php // echo $redire_asha; ?>';
			// alert(redirect_asha);
		// $('#ReplacedBy').on('change',function(){
		// 	// alert($('#ReplacedBy').val());
		// 	$.ajax({
		// 		type: "POST";
		// 		data: ({redire_asha:redirect_asha});
		// 		url: "<?php // echo site_url('asha/check_extra_charge/'); ?>",
		// 		success: function(result){
		// 			alert(result);
		// 			// if(result>=2){
		// 			// 	alert("You can select max 2 and limit has been crossed");
		// 			// 	// alert('hello');
		// 			// }
		// 			// else{
		// 			// 	alert("<?php // echo $this->session->userdata('ashaID_redirect'); ?>");
		// 			// }
		// 		}
		// 	});
		// });

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