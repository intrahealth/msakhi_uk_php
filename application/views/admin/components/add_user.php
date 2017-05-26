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

						<div class="row" style="padding-left:25px;">
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
								<div class="form-group fg-line">
									<label for="username">Username</label>
									<input type="text" class="form-control" 
									id="username" autocomplete="off" onblur="return validateUser(this.value)"    name="username" placeholder="Enter user name" value="" required>
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

						<div class="row" style="padding-left:25px;">
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
								<div class="form-group fg-line">
									<label for="firstname">First Name</label>
									<input type="text" class="form-control" id="firstname"  name="firstname" placeholder="Enter first name" value="" required>
								</div>
							</div>

							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
								<div class="form-group fg-line">
									<label for="lastname">Last Name</label>
									<input type="text" class="form-control" id="lastname" name="lastname" placeholder="Enter last name" value="" required>
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
								<div class="form-group fg-line">
									<label for="phone_no">Contact No</label>
									<input type="number" class="form-control" id="phone_no" name="phone_no" placeholder="Enter contact no" value="" required>
								</div>

							</div>
						</div>


						<div class="row" style="padding-left:25px;">
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
								<div class="form-group fg-line">
									<label for="email">Email</label>
									<input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="" required>
								</div>

							</div>

							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
								<div class="form-group fg-line select">
									<label for="usertype">Select Role</label>
									<br>
									<select name="usertype" id="usertype" onchange="return selectRoleList(this.value)" class="form-control" required>
										<option value="">--select--</option>
										<option value="1" >Admin Role</option>
										<option value="8">Block Role</option>
										<option value="7">District Role</option>
										<option value="6">State Role</option>>
									</select>
								</div>

							</div>

							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
								<div class="form-group fg-line select" id="stateList">
									<label for="state">Select State </label>
									<br>
									<select name="state" onchange='return districtList(this.value)' id="state" class="form-control" required>
										<?php print $state_list;?>

									</select>
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
				$("#stateList").hide();

				$('#stateList').find('input, textarea, button, select').attr('disabled','disabled');

				function selectRoleList(roleType)
				{
					if(roleType=='' || roleType ==1){
						$('#stateList').find('input, textarea, button, select').attr('disabled','disabled');
						$("#stateList").hide();
						$("#disttrictList").html('');
						$("#blockList").html('');
						$("#state").val('');

						return false;

					}
					else
					{

						$('#stateList').find('input, textarea, button, select').removeAttr("disabled");
						$("#stateList").show();	
						/* Only  State level User*/
						if(roleType ==6)
						{
							$("#state").val('')
							$("#disttrictList").html('');
							$("#blockList").html('');
							return false
						}
						/* Only District Level 7 */
						if(roleType ==7 )
						{

							$("#state").val('')
							$("#blockList").html('');
							$("#disttrictList").html('');

						}
						/* Block Lavel 8 */
						if(roleType ==8){

							$("#state").val('')
							$("#blockList").html('');
							$("#blockList").html('');
							$("#disttrictList").html('');

						}

					}
				}



				function districtList(stateCode)
				{
					if(stateCode=='' || stateCode==0){
						return false;
					}
					var roleType=$("#usertype").val();
					if(roleType==7 || roleType==8  ){
						$.post('<?php echo site_url("users/Ajax/getDistrict");?>',{'roleType':roleType,'stateCode':stateCode}, function(data)
						{
							$("#disttrictList").html(data);
						});
					}
				}

				function blocklist(distCode){

					var roleType=$("#usertype").val();
					if(distCode=='' || distCode==0)
					{
						return false;
					}

					if(roleType==8){ 

						$.post('<?php echo site_url("users/Ajax/getBlock");?>',{'roleType':roleType,'distCode':distCode}, function(data)
						{
							$("#blockList").html(data);
						});
					}
				}

				var password = document.getElementById('password');
				var repassword = document.getElementById('repassword');

				var checkPasswordValidity = function()
				{
					if(password.value != repassword.value) 
					{
						repassword.setCustomValidity('Passwords do not match with confirm password.');
					} 
					else 
					{
						repassword.setCustomValidity('');
					}        
				};

				password.addEventListener('change', checkPasswordValidity, false);
				repassword.addEventListener('change', checkPasswordValidity, false);


				function validateUser(usernameVal)
				{

					var username = document.getElementById('username');

					$.ajax({
						async: false,
						type: "POST",
						url: "<?php echo site_url("users/Ajax/validateUser");?>",
						data: {'username':usernameVal },
						success: function (data) {
							if(parseInt(data) ==2){
								username.setCustomValidity('This username already taken');
							}else{
								username.setCustomValidity('');
							}
						}
					});

				}

			</script>>