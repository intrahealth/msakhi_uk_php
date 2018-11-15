<section id="content">
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

</script>