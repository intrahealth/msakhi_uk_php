<section id="content">
	<div class="block-header">
		<h2>Manage Users</h2>
	</div>

	<div class="card">
		<div class="card-header">
			<h2><b>Add User</b><small>
				Use the form below to add new User
			</small></h2>
		</div>
		<?php
    $this->loginData = $this->session->userdata('loginData');
		$er_msg=$this->session->flashdata('er_msg');
		if(!empty($er_msg)){
			?>
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
				<?php }?>

				<div class="card-body card-padding">
					<form role="form" method="post"   action="">
						<h4>User details</h4>
						<div class="row">
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
								<div class="form-group fg-line select">
									<label for="usertype">Select Role</label>
									<br>
									<!-- <select name="usertype" id="usertype" class="form-control" required>
										<option value="">--select--</option>
										<option value="1" >Admin</option>
										<option value="2">State</option>>
										<option value="3">District</option>
										<option value="4">Block</option>
										<option value="5">ANM</option>
										<option value="6">AF</option>
										<option value="7">ASHA</option>
									</select> -->
                   <?php 
                    $role = $this->loginData->user_role;
                    if($role == 5){
                     echo  '<select name="usertype" id="usertype" class="form-control" required>
										<option value="">--select--</option>
										<option value="1">Admin</option>
										<option value="2">State</option>>
										<option value="3">District</option>
										<option value="4">Block</option>
										<option value="5">ANM</option>
										<option value="6">AF</option>
										<option value="7">ASHA</option>
									</select>';
                   }else if($role == 6){
                      echo  '<select name="usertype" id="usertype" class="form-control" required>
										<option value="">--select--</option>
										<option value="2">State</option>>
										<option value="3">District</option>
										<option value="4">Block</option>
										<option value="5">ANM</option>
										<option value="6">AF</option>
										<option value="7">ASHA</option>
									</select>';
                   } ?>
								
								</div>

							</div>
						</div>
						<hr>
						<br>

						<section id="user_mappings">
							<div class="row">
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" id="col_state">
									<div class="form-group fg-line select" id="stateList">
										<label for="state">Select State </label>
										<br>
										<select name="state" id="state" class="form-control" required>
											<?php print $state_list;?>
										</select>
									</div>

								</div>	

								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" id="col_district">
									<div class="form-group fg-line select" id="stateList">
										<label for="districts">Select District </label>
										<br>
										<select name="districts"id="districts" class="form-control" required>
											<option value="">--select--</option>

										</select>
									</div>

								</div>	

								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" id="col_block">
									<div class="form-group fg-line select" id="stateList">
										<label for="block">Select Block </label>
										<br>
										<select name="block" id="block" class="form-control" required>
											<option value="">--select--</option>
										</select>
									</div>

								</div>	


							</div>

							<div class="row">
						<!-- <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" id="col_phc">
								<div class="form-group fg-line select" id="stateList">
									<label for="phc">Select PHC </label>
									<br>
									<select name="phc" id="phc" class="form-control" required>
									<option value="">--select--</option>
									</select>
								</div>

							</div>	 -->

							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" id="col_subcenter">
								<div class="form-group fg-line select" id="stateList">
									<label for="subcenter">Select Subcenter </label>
									<br>
									<select name="subcenter" id="subcenter" class="form-control" required>
										<option value="">--select--</option>
									</select>
								</div>

							</div>	

							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" id="col_anm">
								<div class="form-group fg-line select" id="stateList">
									<label for="anm">Select ANM </label>
									<br>
									<select name="anm" id="anm" class="form-control" required>
										<option value="">--select--</option>
									</select>
								</div>

							</div>

							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" id="col_asha">
								<div class="form-group fg-line select" id="stateList">
									<label for="asha">Select ASHA </label>
									<br>
									<select name="asha" id="asha" class="form-control" required>
										<option value="">--select--</option>
									</select>
								</div>

							</div>	

						</div>

						<div class="row">
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" id="col_af">
								<div class="form-group fg-line select" id="stateList">
									<label for="af">Select AF </label>
									<br>
									<select name="af" id="af" class="form-control" required>
										<option value="">--select--</option>
									</select>
								</div>

							</div>	


						</div>

						<hr>
					</section>

					<div class="row">
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<div class="form-group fg-line">
								<label for="username">Username</label>
								<input type="text" class="form-control" 
								id="username" autocomplete="off" name="username" placeholder="Enter user name" value="" required>
							</div>

						</div>


						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<div class="form-group fg-line">
								<label for="password">Password</label>
								<input type="password" class="form-control" id="password" name="password" placeholder="Enter password" value="" required>
							</div>

						</div>

						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<div class="form-group fg-line">
								<label for="repassword">Re-type Password</label>
								<input type="password" class="form-control" id="repassword" name="repassword" placeholder="Enter password Again" value="" required>
							</div>

						</div>
					</div>

					<div class="row">
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<div class="form-group fg-line">
								<label for="firstname">Name</label>
								<input type="text" class="form-control" id="firstname"  name="firstname" placeholder="Enter first name" value="" required>
							</div>
						</div>

					
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
								<div class="form-group fg-line">
									<label for="phone_no">Contact No</label>
									<input type="number" class="form-control" id="phone_no" name="phone_no" placeholder="Enter contact no" value="" required>
								</div>
							</div>

							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
								<div class="form-group fg-line">
									<label for="email">Email</label>
									<input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="" required>
								</div>
							</div>



						</div>


				


						<div class="row">
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
								<div class="form-group fg-line">
									<label for="imei1">Imei No 1</label>
									<input type="text" class="form-control" id="imei1" name="imei1" placeholder="Enter IMEI 1" value="" required>
								</div>

							</div>


							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
								<div class="form-group fg-line">
									<label for="imei2">Imei No 2</label>
									<input type="text" class="form-control" id="imei2" name="imei2" placeholder="Enter IMEI 2" value="" required>
								</div>

							</div>

						</div>

						<div class="row" style="padding-left:25px;" >
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
								<div class="form-group fg-line select" id="disttrictList"></div>
							</div>

							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
								<div class="form-group fg-line select" id="blockList"></div>
							</div>			

						</div>

						<div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"  style="padding:25px;"> 
							<button class="btn btn-primary btn-sm m-t-10 pull-right padding:10px;" id="btn_go">Submit</button></div></div>			

						</form>

					</div>
				</div>
			</section>

			<script language=javascript>	
				// $("#stateList").hide();

				// $('#stateList').find('input, textarea, button, select').attr('disabled','disabled');

				// function selectRoleList(roleType)
				// {
				// 	if(roleType=='' || roleType ==1){
				// 		$('#stateList').find('input, textarea, button, select').attr('disabled','disabled');
				// 		$("#stateList").hide();
				// 		$("#disttrictList").html('');
				// 		$("#blockList").html('');
				// 		$("#state").val('');

				// 		return false;

				// 	}
				// 	else
				// 	{

				// 		$('#stateList').find('input, textarea, button, select').removeAttr("disabled");
				// 		$("#stateList").show();	
				// 		/* Only  State level User*/
				// 		if(roleType ==6)
				// 		{
				// 			$("#state").val('')
				// 			$("#disttrictList").html('');
				// 			$("#blockList").html('');
				// 			return false
				// 		}
				// 		/* Only District Level 7 */
				// 		if(roleType ==7 )
				// 		{

				// 			$("#state").val('')
				// 			$("#blockList").html('');
				// 			$("#disttrictList").html('');

				// 		}
				// 		/* Block Lavel 8 */
				// 		if(roleType ==8){

				// 			$("#state").val('')
				// 			$("#blockList").html('');
				// 			$("#blockList").html('');
				// 			$("#disttrictList").html('');

				// 		}

				// 	}
				// }



				// function districtList(stateCode)
				// {
				// 	if(stateCode=='' || stateCode==0){
				// 		return false;
				// 	}
				// 	var roleType=$("#usertype").val();
				// 	if(roleType==7 || roleType==8  ){
				// 		$.post('<?php echo site_url("users/Ajax/getDistrict");?>',{'roleType':roleType,'stateCode':stateCode}, function(data)
				// 		{
				// 			$("#disttrictList").html(data);
				// 		});
				// 	}
				// }

				// function blocklist(distCode){

				// 	var roleType=$("#usertype").val();
				// 	if(distCode=='' || distCode==0)
				// 	{
				// 		return false;
				// 	}

				// 	if(roleType==8){ 

				// 		$.post('<?php echo site_url("users/Ajax/getBlock");?>',{'roleType':roleType,'distCode':distCode}, function(data)
				// 		{
				// 			$("#blockList").html(data);
				// 		});
				// 	}
				// }

				// var password = document.getElementById('password');
				// var repassword = document.getElementById('repassword');

				// var checkPasswordValidity = function()
				// {
				// 	if(password.value != repassword.value) 
				// 	{
				// 		repassword.setCustomValidity('Passwords do not match with confirm password.');
				// 	} 
				// 	else 
				// 	{
				// 		repassword.setCustomValidity('');
				// 	}        
				// };

				// password.addEventListener('change', checkPasswordValidity, false);
				// repassword.addEventListener('change', checkPasswordValidity, false);


				// function validateUser(usernameVal)
				// {

				// 	var username = document.getElementById('username');

				// 	$.ajax({
				// 		async: false,
				// 		type: "POST",
				// 		url: "<?php echo site_url("users/Ajax/validateUser");?>",
				// 		data: {'username':usernameVal },
				// 		success: function (data) {
				// 			if(parseInt(data) ==2){
				// 				username.setCustomValidity('This username already taken');
				// 			}else{
				// 				username.setCustomValidity('');
				// 			}
				// 		}
				// 	});

				// }

				$(document).ready(function(){

					$("#user_mappings").hide();
					$("#col_state").hide();
					$("#col_district").hide();
					$("#col_block").hide();
					$("#col_phc").hide();
					$("#col_subcenter").hide();
					$("#col_anm").hide();
					$("#col_af").hide();
					$("#col_asha").hide();

					$('#state').change(function(){

						$("#districts").html('<option>--select--</option>');
						$("#block").html('<option>--select--</option>');
						$("#subcenter").html('<option>--select--</option>');
						$("#anm").html('<option>--select--</option>');
						$("#asha").html('<option>--select--</option>');

						$.ajax({
							url: '<?php echo site_url("Ajax/getDistrictLists/");?>'+$(this).val(),
							type: 'POST',
							dataType: 'text'
						})
						.done(function(data) {
							console.log(data);
							$("#districts").html(data);
						})
						.fail(function() {
							console.log("error");
						})
						.always(function() {
							console.log("complete");
						});
						
					});

					$('#districts').change(function(){


						$("#block").html('<option>--select--</option>');
						$("#subcenter").html('<option>--select--</option>');
						$("#anm").html('<option>--select--</option>');
						$("#asha").html('<option>--select--</option>');

						$.ajax({
							url: '<?php echo site_url("Ajax/getBlockLists/");?>'+$(this).val(),
							type: 'POST',
							dataType: 'text'
						})
						.done(function(data) {
							console.log(data);
							$("#block").html(data);
						})
						.fail(function() {
							console.log("error");
						})
						.always(function() {
							console.log("complete");
						});
						
					});

					$('#block').change(function(){

						if($('#usertype').val() == 6)
						{

							$.ajax({
								url: '<?php echo site_url("Ajax/getAFFromBlock/");?>'+$(this).val(),
								type: 'POST',
								dataType: 'text'
							})
							.done(function(data) {
								console.log(data);
								$("#af").html(data);
							})
							.fail(function() {
								console.log("error");
							})
							.always(function() {
								console.log("complete");
							});

						}
						else
						{


							$("#subcenter").html('<option>--select--</option>');
							$("#anm").html('<option>--select--</option>');
							$("#asha").html('<option>--select--</option>');

							$.ajax({
								url: '<?php echo site_url("Ajax/getSubcenterFromBlock/");?>'+$(this).val(),
								type: 'POST',
								dataType: 'text'
							})
							.done(function(data) {
								console.log(data);
								$("#subcenter").html(data);
							})
							.fail(function() {
								console.log("error");
							})
							.always(function() {
								console.log("complete");
							});
						}
						
					});

					// $('#phc').change(function(){
					// 	$.ajax({
					// 		url: '<?php echo site_url("Ajax/getSubcenterList/");?>'+$(this).val(),
					// 		type: 'POST',
					// 		dataType: 'text'
					// 	})
					// 	.done(function(data) {
					// 		console.log(data);
					// 		$("#subcenter").html(data);
					// 	})
					// 	.fail(function() {
					// 		console.log("error");
					// 	})
					// 	.always(function() {
					// 		console.log("complete");
					// 	});

					// });

					$('#subcenter').change(function(){


						$("#anm").html('<option>--select--</option>');
						$("#asha").html('<option>--select--</option>');

						$.ajax({
							url: '<?php echo site_url("Ajax/getAnmListViaSubcenter/");?>'+$(this).val(),
							type: 'POST',
							dataType: 'text'
						})
						.done(function(data) {
							console.log(data);
							$("#anm").html(data);
						})
						.fail(function() {
							console.log("error");
						})
						.always(function() {
							console.log("complete");
						});
						
					});

					$('#anm').change(function(){

						
						$("#asha").html('<option>--select--</option>');

						$.ajax({
							url: '<?php echo site_url("Ajax/getAshaOfAnmWithoutUser/");?>'+$(this).val(),
							type: 'POST',
							dataType: 'text'
						})
						.done(function(data) {
							console.log(data);
							$("#asha").html(data);
						})
						.fail(function() {
							console.log("error");
						})
						.always(function() {
							console.log("complete");
						});
						
					});

					$('#asha').change(function(){

						$.ajax({
							url: '<?php echo site_url("Ajax/getAshaDetails/");?>'+$(this).val(),
							type: 'POST',
							dataType: 'json'
						})
						.done(function(data) {
							$("#firstname").val(data.ASHAName);
						})
						.fail(function() {
							console.log("error");
						})
						.always(function() {
							console.log("complete");
						});
						
					});

					$("#usertype").change(function(){

						var role = $(this).val();

						$("#state").val('');
						$("#districts").html('<option>--select--</option>');
						$("#block").html('<option>--select--</option>');
						$("#phc").html('<option>--select--</option>');
						$("#subcenter").html('<option>--select--</option>');
						$("#anm").html('<option>--select--</option>');
						$("#af").html('<option>--select--</option>');
						$("#asha").html('<option>--select--</option>');

						switch(role)
						{
							case "1" : 
							$("#col_state").hide();
							$("#col_district").hide();
							$("#col_block").hide();
							$("#col_phc").hide();
							$("#col_subcenter").hide();
							$("#col_anm").hide();
							$("#col_af").hide();
							$("#col_asha").hide();
							$("#user_mappings").hide('fast');

							$("#state").removeAttr('required');
							$("#districts").removeAttr('required');
							$("#block").removeAttr('required');
								// $("#phc").removeAttr('required');
								$("#subcenter").removeAttr('required');
								$("#anm").removeAttr('required');
								$("#af").removeAttr('required');
								$("#asha").removeAttr('required');

								break;
								case "2" : 
								$("#col_state").show();
								$("#col_district").hide();
								$("#col_block").hide();
								$("#col_phc").hide();
								$("#col_subcenter").hide();
								$("#col_anm").hide();
								$("#col_af").hide();
								$("#col_asha").hide();
								$("#user_mappings").show('fast');

								$("#state").prop('required',true);
								$("#districts").removeAttr('required');
								$("#block").removeAttr('required');
								// $("#phc").removeAttr('required');
								$("#subcenter").removeAttr('required');
								$("#anm").removeAttr('required');
								$("#af").removeAttr('required');
								$("#asha").removeAttr('required');

								break;
								case "3" : 
								$("#col_state").show();
								$("#col_district").show();
								$("#col_block").hide();
								$("#col_phc").hide();
								$("#col_subcenter").hide();
								$("#col_anm").hide();
								$("#col_af").hide();
								$("#col_asha").hide();
								$("#user_mappings").show('fast');

								$("#state").prop('required',true);
								$("#districts").prop('required',true);
								$("#block").removeAttr('required');
								// $("#phc").removeAttr('required');
								$("#subcenter").removeAttr('required');
								$("#anm").removeAttr('required');
								$("#af").removeAttr('required');
								$("#asha").removeAttr('required');

								break;
								case "4" : 
								$("#col_state").show();
								$("#col_district").show();
								$("#col_block").show();
								$("#col_phc").hide();
								$("#col_subcenter").hide();
								$("#col_anm").hide();
								$("#col_af").hide();
								$("#col_asha").hide();
								$("#user_mappings").show('fast');

								$("#state").prop('required',true);
								$("#districts").prop('required',true);
								$("#block").prop('required',true);
								// $("#phc").removeAttr('required');
								$("#subcenter").removeAttr('required');
								$("#anm").removeAttr('required');
								$("#af").removeAttr('required');
								$("#asha").removeAttr('required');

								break;
								case "5" : 
								$("#col_state").show();
								$("#col_district").show();
								$("#col_block").show();
								$("#col_phc").show();
								$("#col_subcenter").show();
								$("#col_anm").show();
								$("#col_af").hide();
								$("#col_asha").hide();
								$("#user_mappings").show('fast');

								$("#state").prop('required',true);
								$("#districts").prop('required',true);
								$("#block").prop('required',true);
								// $("#phc").prop('required',true);
								$("#subcenter").prop('required',true);
								$("#anm").prop('required',true);
								$("#af").removeAttr('required');
								$("#asha").removeAttr('required');
								break;
								case "6" : 
								$("#col_state").show();
								$("#col_district").show();
								$("#col_block").show();
								$("#col_phc").hide();
								$("#col_subcenter").hide();
								$("#col_anm").hide();
								$("#col_af").show();
								$("#col_asha").hide();
								$("#user_mappings").show('fast');

								$("#state").prop('required',true);
								$("#districts").prop('required',true);
								$("#block").prop('required',true);
								// $("#phc").prop('required',true);
								// $("#subcenter").prop('required',true);
								// $("#anm").prop('required',true);
								$("#af").prop('required',true);
								$("#asha").removeAttr('required');

								break;
								case "7" : 
								$("#col_state").show();
								$("#col_district").show();
								$("#col_block").show();
								// $("#col_phc").show();
								$("#col_subcenter").show();
								$("#col_anm").show();
								// $("#col_af").show();
								$("#col_asha").show();
								$("#user_mappings").show('fast');

								$("#state").prop('required',true);
								$("#districts").prop('required',true);
								$("#block").prop('required',true);
								// $("#phc").prop('required',true);
								$("#subcenter").prop('required',true);
								$("#anm").prop('required',true);
								$("#af").removeAttr('required');
								$("#asha").prop('required',true);

								break;
								default : console.log("wrong case");
							}
						});


});

</script>>