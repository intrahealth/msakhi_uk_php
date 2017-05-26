<section id="content">
	<div class="block-header">
		<h2>Manage Users</h2>
	</div>

	<div class="card">
		<div class="card-header">
			<h2><b>Edit User</b><small>
				Use the form below to edit User
			</small></h2>
		</div>

		<div class="card-body card-padding">
			<form role="form" method="post"  action="">
				<h4>User details</h4>

				<div class="row" style="padding-left:25px;">
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
						<div class="form-group fg-line">
							<label for="username">Username</label>
							<input type="text" class="form-control" id="username" autocomplete="off" 
							onblur="return validateUser(this.value)" name="username" placeholder="Enter user name" value="<?php echo $user_data->user_name; ?>" required>
						</div>
					</div>


					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
						<div class="form-group fg-line">
							<label for="password">Password</label>
							<input type="password" class="form-control" id="password" name="password" placeholder="Enter password" value="" >
						</div>
					</div>

					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
						<div class="form-group fg-line">
							<label for="repassword">Re-type Password</label>
							<input type="password" class="form-control" id="repassword" name="repassword" placeholder="Enter password Again" value="" >
						</div>
					</div>
				</div>

				<div class="row" style="padding-left:25px;">
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
						<div class="form-group fg-line">
							<label for="firstname">First Name</label>
							<input type="text" class="form-control" id="firstname"  name="firstname" placeholder="Enter first name" value="<?php echo $user_data->first_name; ?>" required>
						</div>
					</div>

					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
						<div class="form-group fg-line">
							<label for="lastname">Last Name</label>
							<input type="text" class="form-control" id="lastname" name="lastname" placeholder="Enter last name" 
							value="<?php echo $user_data->last_name; ?>" required>
						</div>
					</div>

					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
						<div class="form-group fg-line">
							<label for="phone_no">Contact No</label>
							<input type="number" class="form-control" id="phone_no" name="phone_no" placeholder="Enter contact no" value="<?php echo $user_data->phone_no; ?>" required>
						</div>
					</div>
				</div>

				<div class="row" style="padding-left:25px;">
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
						<div class="form-group fg-line">
							<label for="email">Email</label>
							<input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="<?php echo $user_data->email; ?>" required>
						</div>
					</div>

					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
						<div class="form-group fg-line select">
							<label for="usertype">Select Role</label>
							<br>
							<select name="usertype" id="usertype" onchange="return selectRoleList(this.value)" class="form-control" required>
								<option value="">--select--</option>
								<option value="1" <?php echo($user_data->user_role == 1?"selected":""); ?> >Admin Role</option>
								<option value="8" <?php echo($user_data->user_role ==8?"selected":"");?> >Block Role</option>
								<option value="7" <?php echo($user_data->user_role ==7?"selected":"");?> >District Role</option>
								<option value="6"  <?php echo($user_data->user_role ==6?"selected":"");?>  >State Role</option>>
							</select>
						</div>
					</div>

					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
						<div class="form-group fg-line select" id="stateList">
						</div>
					</div>	

				</div>

				<div class="row" style="padding-left:25px;" >
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
						<div class="form-group fg-line select" id="disttrictList">
						</div>
					</div>

					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
						<div class="form-group fg-line select" id="blockList">
						</div>
					</div>			

				</div>

				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"  style="padding:25px;"> 
						<button class="btn btn-primary btn-sm m-t-10 pull-right padding:10px;" id="btn_go">Submit</button>
					</div>
				</div>	

			</form>

		</div>
	</div>
</section>
<script language="javascript">
	role()
	function role()
	{
		$('#stateList').find('input, textarea, button, select').attr('disabled','disabled');
		var roleType=$("#usertype").val()
		if(roleType==1)
		{
			$('#stateList').find('input, textarea, button, select').attr('disabled','disabled');

			$("#disttrictList").html('');
			$("#blockList").html('');
			$("#state").val('');
			return false;
		}
		/* When Need state code*/
		else if(roleType==6){

			$("#disttrictList").html('');
			$("#blockList").html('');

			$.post('<?php echo site_url("users/Ajax/getState");?>', {'roleType':roleType,'stateCode':'<?php $user_data->state_code ?>'}, function(data){
				$("#stateList").html(data);
			});

		}
		/* When need district code*/
		else if(roleType==7){

			$.post('<?php echo site_url("users/Ajax/getState");?>', {'roleType':roleType,'stateCode':'<?php print $user_data->state_code; ?>'}, function(data){
				$("#stateList").html(data);
			});

			$.post('<?php echo site_url("users/Ajax/getDistrict");?>', 
				{'roleType':roleType,'stateCode':'<?php print $user_data->state_code ;?>','districtCode':'<?php print $user_data->district_code; ?>' }, function(data){
					$("#disttrictList").html(data);
				});

		}
		/*When need Block code*/
		else if(roleType==8){



			$.post('<?php echo site_url("users/Ajax/getState");?>', {'roleType':roleType,'stateCode':'<?php print $user_data->state_code; ?>'}, function(data){
				$("#stateList").html(data);
			});

			$.post('<?php echo site_url("users/Ajax/getDistrict");?>', 
				{'roleType':roleType,'stateCode':'<?php print $user_data->state_code ;?>','districtCode':'<?php print $user_data->district_code; ?> '}, function(data){
					$("#disttrictList").html(data);
				});

			$.post('<?php echo site_url("users/Ajax/getBlock");?>',
				{'roleType':roleType,'distCode':'<?php print $user_data->district_code; ?>','blockCode':'<?php print $user_data->block_code; ?>'}, function(data){
					$("#blockList").html(data);
				});

		}
	}

	function selectRoleList(roleType){
		if(roleType==1)
		{
			$('#stateList').html('');
			$("#disttrictList").html('');
			$("#blockList").html('');
			$("#state").val('');
			return false;
		}

		if(roleType==6)
		{
			$("#disttrictList").html('');
			$("#blockList").html('');
			$('#stateList').html('');
			$.post('<?php echo site_url("users/Ajax/getState");?>', {'roleType':roleType,'stateCode':''}, function(data){
				$("#stateList").html(data);
			});

		}

		if(roleType==7)
		{
			$('#stateList').html('');
			$("#disttrictList").html('');
			$("#blockList").html('');
			$.post('<?php echo site_url("users/Ajax/getState");?>', {'roleType':roleType,'stateCode':''}, function(data){
				$("#stateList").html(data);
			});
			
		}

		if(roleType==8)
		{

			$('#stateList').html('');
			$("#disttrictList").html('');
			$("#blockList").html('');

			$.post('<?php echo site_url("users/Ajax/getState");?>', {'roleType':roleType,'stateCode':''}, function(data){
				$("#stateList").html(data);
			});
			
		}

	}

	function districtList(stateCode)
	{
		var roleType=$("#usertype").val();

		if(stateCode=='' || stateCode==0){
			return false;
		}

		$.post('<?php echo site_url("users/Ajax/getDistrict");?>',{'roleType':roleType,'stateCode':stateCode}, function(data)
		{
			$("#disttrictList").html(data);
		});
	}

	function blocklist(distCode){

		if(distCode=='' || distCode==0){
			return false;
		}

		var roleType=$("#usertype").val();
		if(roleType==7){ return false;}
		if(roleType==8){ 

			$.post('<?php echo site_url("users/Ajax/getBlock");?>',{'roleType':roleType,'distCode':distCode}, function(data)
			{
				$("#blockList").html(data);
			});
		}

	}

	function validateUser(usernameVal)
	{
		var username = document.getElementById('username');
		$.ajax({
			async: false,
			type: "POST",
			url: "<?php echo site_url("users/Ajax/validateEditUser");?>",
			data: {'username':usernameVal,'id':<?php print $user_data->id;?> },
			success: function (data) {
				if(parseInt(data) ==2){
					username.setCustomValidity('This username already taken');
				}else{
					username.setCustomValidity('');
				}
			}
		});

	}

	var password = document.getElementById("password")
	, confirm_password = document.getElementById("repassword");

	function validatePassword(){
		if(password.value != confirm_password.value) {
			confirm_password.setCustomValidity("Passwords do not match with confirm password.");
		} else {
			confirm_password.setCustomValidity('');
		}
	}

	password.onchange = validatePassword;
	confirm_password.onkeyup = validatePassword;
</script>