<style type="text/css">
.sbtn{
	float: right;
	margin-right: 193px;
	margin-top: -34px;
	height: 34px;
}
.chkb{
	margin-left: 15px;
}
.shodo-h2{
	box-shadow: 0 0 10px #ccc;
	padding: 12px;
	font-size: 16px;
}
</style>
<section id="content">
	<?php foreach ($role_permission as $row) { if ($row->Controller == "Permissions" && $row->Action == "index"){ ?>
	<div class="block-header">
		<h2>Manage Permissions</h2>
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
			<!-- Exportable Table -->
			<div class="row clearfix">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="card">
						<div class="card-header">
							<h2><b>Manage Permissions</b><small>
								Manage Permissions
							</small></h2>
						</div>
						<div class="body">
							<div class="table-responsive">
								<form method="post">
									<input type="hidden" name="flag" value="index">
									<div class="col-sm-12"> 
										<div class="col-sm-6"> 
											<label for="doctoradvice_date" class="field-wrapper required-field">Select Role</label>
											<select style="width: 200px;border-radius: 10px;margin-left: 11px;" name="RoleID" id="RoleID" class="form-control" required>
												<option value="">Select</option>
												<?php foreach($role_list as $row){ ?>
												<option value="<?php echo $row->RoleID; ?>" <?php echo ($row->RoleID == set_value('RoleID') ? "selected" : "");?>><?php echo $row->RoleName; ?></option>
												<?php } ?>
											</select>
											<button type="submit" name="submit" class="btn btn-round btn-primary sbtn ">GO</button>
										</div>
									</div>
								</form>
								<form action="" method="post">
									<?php $roleid = set_value('RoleID');
									if(!empty($roleid)){ ?>
									<input type="hidden" name="RoleID" value="<?php echo $roleid;?>">
									<input type="hidden" name="flag" value="update">
									<?php }?>							
									
									<div class="col-sm-6">
										<h2 class="card-inside-title shodo-h2">Dashboard</h2>
										<div class="demo-checkbox">
											<table class="table table-bordered">
												<tr><td>
													<b class="chkb">MNCH Dashboard</b> 
												</td><td>
													<input type="checkbox" id="mnch_dashboardindex" name="selected[mnch_dashboard][index]" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "mnch_dashboard" && $row->Action=="index"){
															echo "checked";
														}
													}
													?>>
													<label for="mnch_dashboardindex">Default</label>
												</td></tr>
												<tr><td>
													<b class="chkb">Dashboard</b> 
												</td><td>
													<input type="checkbox" id="dashboardindex" name="selected[dashboard][index]" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "dashboard" && $row->Action=="index"){
															echo "checked";
														}
													}
													?>>
													<label for="dashboardindex">Default</label>
												</td></tr>
												<tr><td>
													<b class="chkb">Output Indicators</b>
												</td><td>
													<input type="checkbox" id="Output_indicatorsindex" name="selected[Output_indicators][index]" class="filled-in" value="<?php echo set_value('RoleID');?>" 
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "Output_indicators" && $row->Action == "index"){
															echo "checked";
														}
													}
													?> >
													<label for="Output_indicatorsindex">Default</label>
												</td></tr>
												<tr><td>
													<b class="chkb">Process Indicators</b>
												</td><td>
													<input type="checkbox" id="Process_indicatorsindex" name="selected[Process_indicators][index]" class="filled-in" value="<?php echo set_value('RoleID');?>" addonly
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "Process_indicators" && $row->Action == "index"){
															echo "checked";
														}
													}
													?> >
													<label for="Process_indicatorsindex">Default</label>
												</td></tr>
												<tr><td>
													<b class="chkb"> Drill down report</b>
												</td><td>
													<input type="checkbox" id="Drill_downreportindex" name="selected[Drill_downreport][index]" class="filled-in" value="<?php echo set_value('RoleID');?>" addonly
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "Drill_downreport" && $row->Action == "index"){
															echo "checked";
														}
													}
													?> >
													<label for="Drill_downreportindex">Default</label>
												</td></tr>
											</table>
										</div>
									</div>

									<div class="col-sm-6">
										<h2 class="card-inside-title shodo-h2">Manage Permission &nbsp;&nbsp;&nbsp;&nbsp;
											<input type="checkbox" class="checkAll"/>Check All</h2>
										</h2>
										<div class="demo-checkbox">
											<table class="table table-bordered">
												<tr><td>
													<b class="chkb"> My Profile</b>
												</td><td colspan="4">
													<input type="checkbox" id="Profileindex" name="selected[Profile][index]" class="filled-in" checked="cehcked" value="<?php echo set_value('RoleID');?>" addonly
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "Profile" && $row->Action == "index"){
															echo "checked";
														}
													}
													?> >
													<label for="Profileindex">Default</label>
												</td></tr>
												<tr><td>
													<b class="chkb">Change Password</b>
												</td><td colspan="4">
													<input type="checkbox" id="Change_passwordindex" name="selected[Change_password][index]" class="filled-in" checked="cehcked" value="<?php echo set_value('RoleID');?>" addonly
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "Change_password" && $row->Action == "index"){
															echo "checked";
														}
													}
													?> >
													<label for="Change_passwordindex">Default</label>
												</td></tr>


												<tr><td>
													<b class="chkb">Manage Role</b> 
												</td><td>
													<input type="checkbox" id="roleindex" name="selected[role][index]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "role" && $row->Action == "index"){
															echo "checked";
														}
													}
													?> >
													<label for="roleindex">View</label>
												</td><td>
													<input type="checkbox" id="roleadd" name="selected[role][add]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "role" && $row->Action == "add"){
															echo "checked";
														}
													}
													?> >
													<label for="roleadd">add</label>
												</td><td>
													<input type="checkbox" id="roleedit" name="selected[role][edit]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "role" && $row->Action == "edit"){
															echo "checked";
														}
													}
													?> >
													<label for="roleedit">Edit</label>
												</td><td>
													<input type="checkbox" id="roledelete" name="selected[role][delete]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "role" && $row->Action == "delete"){
															echo "checked";
														}
													}
													?> >
													<label for="roledelete">Delete</label>
												</td>
											</tr>
											<tr><td>
												<b class="chkb">Manage Permission</b>
											</td><td>
												<input type="checkbox" id="Permissionsindex" name="selected[Permissions][index]" class="filled-in" value="<?php echo set_value('RoleID');?>"
												<?php 
												foreach ($permissions_list as $row) {
													if ($row->Controller == "Permissions" && $row->Action == "index"){
														echo "checked";
													}
												}
												?> >
												<label for="Permissionsindex">View</label>
											</td><td>
												<input type="checkbox" id="Permissionsadd" name="selected[Permissions][add]" class="filled-in" value="<?php echo set_value('RoleID');?>"
												<?php 
												foreach ($permissions_list as $row) {
													if ($row->Controller == "Permissions" && $row->Action == "add"){
														echo "checked";
													}
												}
												?> >
												<label for="Permissionsadd">add</label>
											</td><td>
												<input type="checkbox" id="Permissionsedit" name="selected[Permissions][edit]" class="filled-in" value="<?php echo set_value('RoleID');?>"
												<?php 
												foreach ($permissions_list as $row) {
													if ($row->Controller == "Permissions" && $row->Action == "edit"){
														echo "checked";
													}
												}
												?> >
												<label for="Permissionsedit">Edit</label>
											</td><td>
												<input type="checkbox" id="Permissionsdelete" name="selected[Permissions][delete]" class="filled-in" value="<?php echo set_value('RoleID');?>"
												<?php 
												foreach ($permissions_list as $row) {
													if ($row->Controller == "Permissions" && $row->Action == "delete"){
														echo "checked";
													}
												}
												?> >
												<label for="roledelete">Delete</label>
											</td>


										</tr>
									</table>
								</div>
							</div>


							<!-- start code user section -->

							<div class="col-sm-12 a_bunch_of_checkboxes">
								<h2 class="card-inside-title shodo-h2"> User Management &nbsp;&nbsp;&nbsp;
									<input type="checkbox" class="checkAll"/>Check All</h2>
									<div class="demo-checkbox">
										<!-- Start admin section code -->
										<table class="table table-bordered">
											<tr><td>
												<b class="chkb" style="margin-right: 35px;">ANM</b> 
											</td><td>
												<input type="checkbox" id="anmindex" name="selected[anm][index]" class="filled-in" value="<?php echo set_value('RoleID');?>"
												<?php 
												foreach ($permissions_list as $row) {
													if ($row->Controller == "anm" && $row->Action == "index"){
														echo "checked";
													}
												}
												?> >
												<label for="anmindex">View</label>
											</td><td>
												<input type="checkbox" id="anmadd" name="selected[anm][add]" class="filled-in" value="<?php echo set_value('RoleID');?>"
												<?php 
												foreach ($permissions_list as $row) {
													if ($row->Controller == "anm" && $row->Action == "add"){
														echo "checked";
													}
												}
												?> >
												<label for="adminadd">add</label>
											</td><td>
												<input type="checkbox" id="anmedit" name="selected[anm][edit]" class="filled-in" value="<?php echo set_value('RoleID');?>"
												<?php 
												foreach ($permissions_list as $row) {
													if ($row->Controller == "anm" && $row->Action == "edit"){
														echo "checked";
													}
												}
												?> >
												<label for="adminedit">Edit</label>
											</td><td>
												<input type="checkbox" id="anmdelete" name="selected[anm][delete]" class="filled-in" value="<?php echo set_value('RoleID');?>"
												<?php 
												foreach ($permissions_list as $row) {
													if ($row->Controller == "anm" && $row->Action == "delete"){
														echo "checked";
													}
												}
												?> >
												<label for="anmdelete">Delete</label>
											</td><td>
												<input type="checkbox" id="export_csv" name="selected[anm][export_csv]" class="filled-in" value="<?php echo set_value('RoleID');?>"
												<?php 
												foreach ($permissions_list as $row) {
													if ($row->Controller == "anm" && $row->Action == "export_csv"){
														echo "checked";
													}
												}
												?> >
												<label for="export_csv">Export_Excel</label>
											</td><td>
												<input type="checkbox" id="Export_pdf" name="selected[anm][Export_pdf]" class="filled-in" value="<?php echo set_value('RoleID');?>"
												<?php 
												foreach ($permissions_list as $row) {
													if ($row->Controller == "anm" && $row->Action == "Export_pdf"){
														echo "checked";
													}
												}
												?> >
												<label for="Export_pdf">Export PDF</label>
											</td></tr>
											<!-- end admin section code -->

											<!-- start code asha section -->
											<tr><td>
												<b class="chkb" style="margin-right: 40px;">Asha</b> 
											</td><td>
												<input type="checkbox" id="ashaindex" name="selected[asha][index]" class="filled-in" value="<?php echo set_value('RoleID');?>"
												<?php 
												foreach ($permissions_list as $row) {
													if ($row->Controller == "asha" && $row->Action == "index"){
														echo "checked";
													}
												}
												?> >
												<label for="ashaindex">View</label>
											</td><td>
												<input type="checkbox" id="ashaadd" name="selected[asha][add]" class="filled-in" value="<?php echo set_value('RoleID');?>"
												<?php 
												foreach ($permissions_list as $row) {
													if ($row->Controller == "asha" && $row->Action == "add"){
														echo "checked";
													}
												}
												?> >
												<label for="ashaadd">add</label>
											</td><td>
												<input type="checkbox" id="ashaedit" name="selected[asha][edit]" class="filled-in" value="<?php echo set_value('RoleID');?>"
												<?php 
												foreach ($permissions_list as $row) {
													if ($row->Controller == "asha" && $row->Action == "edit"){
														echo "checked";
													}
												}
												?> >
												<label for="ashaedit">Edit</label>
											</td><td>
												<input type="checkbox" id="ashadelete" name="selected[asha][delete]" class="filled-in" value="<?php echo set_value('RoleID');?>"
												<?php 
												foreach ($permissions_list as $row) {
													if ($row->Controller == "asha" && $row->Action == "delete"){
														echo "checked";
													}
												}
												?>>
												<label for="ashadelete">Delete</label>
											</td><td>
												<input type="checkbox" id="export_csv" name="selected[asha][export_csv]" class="filled-in" value="<?php echo set_value('RoleID');?>"
												<?php 
												foreach ($permissions_list as $row) {
													if ($row->Controller == "asha" && $row->Action == "export_csv"){
														echo "checked";
													}
												}
												?> >
												<label for="export_csv">Export_Excel</label>
											</td><td>
												<input type="checkbox" id="Export_pdf" name="selected[asha][Export_pdf]" class="filled-in" value="<?php echo set_value('RoleID');?>"
												<?php 
												foreach ($permissions_list as $row) {
													if ($row->Controller == "asha" && $row->Action == "Export_pdf"){
														echo "checked";
													}
												}
												?> >
												<label for="Export_pdf">Export PDF</label>
											</td></tr>
											<!--  end asha section code -->

											<!-- start orw section code -->
											<tr><td>
												<b class="chkb" style="margin-right: 40px;">User</b> 
											</td><td>
												<input type="checkbox" id="userindex" name="selected[Users][index]" class="filled-in" value="<?php echo set_value('RoleID');?>"
												<?php 
												foreach ($permissions_list as $row) {
													if ($row->Controller == "Users" && $row->Action == "index"){
														echo "checked";
													}
												}
												?> >
												<label for="userindex">View</label>
											</td><td>
												<input type="checkbox" id="useradd" name="selected[Users][add]" class="filled-in" value="<?php echo set_value('RoleID');?>"
												<?php 
												foreach ($permissions_list as $row) {
													if ($row->Controller == "Users" && $row->Action == "add"){
														echo "checked";
													}
												}
												?> >
												<label for="orwadd">add</label>
											</td><td>
												<input type="checkbox" id="useredit" name="selected[Users][edit]" class="filled-in" value="<?php echo set_value('RoleID');?>"
												<?php 
												foreach ($permissions_list as $row) {
													if ($row->Controller == "Users" && $row->Action == "edit"){
														echo "checked";
													}
												}
												?> >
												<label for="orwedit">Edit</label>
											</td><td>
												<input type="checkbox" id="userdelete" name="selected[Users][delete]" class="filled-in" value="<?php echo set_value('RoleID');?>"
												<?php 
												foreach ($permissions_list as $row) {
													if ($row->Controller == "Users" && $row->Action == "delete"){
														echo "checked";
													}
												}
												?> >
												<label for="orwdelete">Delete</label>
											</td><td>
												<input type="checkbox" id="export_csv" name="selected[Users][export_csv]" class="filled-in" value="<?php echo set_value('RoleID');?>"
												<?php 
												foreach ($permissions_list as $row) {
													if ($row->Controller == "Users" && $row->Action == "export_csv"){
														echo "checked";
													}
												}
												?> >
												<label for="export_csv">Export_Excel</label>
											</td><td>
												<input type="checkbox" id="Export_pdf" name="selected[Users][Export_pdf]" class="filled-in" value="<?php echo set_value('RoleID');?>"
												<?php 
												foreach ($permissions_list as $row) {
													if ($row->Controller == "Users" && $row->Action == "Export_pdf"){
														echo "checked";
													}
												}
												?> >
												<label for="Export_pdf">Export PDF</label>
											</td></tr>
										</table>
										<!-- End code ANM section -->
									</div>
								</div>

								<!--  end user section code -->

								<!-- start code in manage location -->
								<div class="col-sm-12">
									<div class="col-sm-12 a_bunch_of_checkboxes">
										<h2 class="card-inside-title shodo-h2">Manage Location &nbsp;&nbsp;&nbsp;
											<input type="checkbox" class="checkAll"/>Check All</h2>
										</h2>
										<div class="demo-checkbox">
											<table class="table table-bordered">
												<tr><td>
													<b class="chkb" style="margin-right:42px;">State</b>
												</td><td>
													<input type="checkbox" id="stateindex" name="selected[state][index]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "state" && $row->Action == "index"){
															echo "checked";
														}
													}
													?>>
													<label for="stateindex">View</label>
												</td><td>
													<input type="checkbox" id="stateadd" name="selected[state][add]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "state" && $row->Action == "add"){
															echo "checked";
														}
													}
													?> >
													<label for="stateadd">add</label>
												</td><td>
													<input type="checkbox" id="stateedit" name="selected[state][edit]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "state" && $row->Action == "edit"){
															echo "checked";
														}
													}
													?> >
													<label for="stateedit">Edit</label>
												</td><td>
													<input type="checkbox" id="statedelete" name="selected[state][delete]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "state" && $row->Action == "delete"){
															echo "checked";
														}
													}
													?> >
													<label for="statedelete">Delete</label>
												</td><td>
													<input type="checkbox" id="export_csv" name="selected[state][export_csv]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "state" && $row->Action == "export_csv"){
															echo "checked";
														}
													}
													?> >
													<label for="export_csv">Export_Excel</label>
												</td><td>
													<input type="checkbox" id="Export_pdf" name="selected[state][Export_pdf]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "state" && $row->Action == "Export_pdf"){
															echo "checked";
														}
													}
													?> >
													<label for="Export_pdf">Export PDF</label>
												</td></tr>
												<tr><td>
													<b class="chkb" style="margin-right: 31px;">District</b>
												</td><td>
													<input type="checkbox" id="districtindex" name="selected[district][index]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "district" && $row->Action == "index"){
															echo "checked";
														}
													}
													?> >
													<label for="districtindex">View</label>
												</td><td>
													<input type="checkbox" id="districtadd" name="selected[district][add]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "district" && $row->Action == "add"){
															echo "checked";
														}
													}
													?> >
													<label for="districtadd">add</label>
												</td><td>
													<input type="checkbox" id="districtedit" name="selected[district][edit]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "district" && $row->Action == "edit"){
															echo "checked";
														}
													}
													?> >
													<label for="districtedit">Edit</label>
												</td><td>
													<input type="checkbox" id="districtdelete" name="selected[district][delete]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "district" && $row->Action == "delete"){
															echo "checked";
														}
													}
													?> >
													<label for="districtdelete">Delete</label>
												</td><td>
													<input type="checkbox" id="export_csv" name="selected[district][export_csv]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "district" && $row->Action == "export_csv"){
															echo "checked";
														}
													}
													?> >
													<label for="export_csv">Export_Excel</label>
												</td><td>
													<input type="checkbox" id="Export_pdf" name="selected[district][Export_pdf]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "district" && $row->Action == "Export_pdf"){
															echo "checked";
														}
													}
													?> >
													<label for="Export_pdf">Export PDF</label>
												</td></tr>
												<tr><td>
													<b class="chkb" style="margin-right: 42px;">Block</b>
												</td><td>
													<input type="checkbox" id="Blockindex" name="selected[block][index]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "block" && $row->Action == "index"){
															echo "checked";
														}
													}
													?> >
													<label for="Blockindex">View</label>
												</td><td>
													<input type="checkbox" id="Blockadd" name="selected[block][add]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "block" && $row->Action == "add"){
															echo "checked";
														}
													}
													?> >
													<label for="Blockadd">add</label>
												</td><td>
													<input type="checkbox" id="Blockedit" name="selected[block][edit]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "block" && $row->Action == "edit"){
															echo "checked";
														}
													}
													?>>
													<label for="Blockedit">Edit</label>
												</td><td>
													<input type="checkbox" id="Blockdelete" name="selected[block][delete]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "block" && $row->Action == "delete"){
															echo "checked";
														}
													}
													?>>
													<label for="Blockdelete">Delete</label>
												</td><td>
													<input type="checkbox" id="export_csv" name="selected[block][export_csv]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "block" && $row->Action == "export_csv"){
															echo "checked";
														}
													}
													?> >
													<label for="export_csv">Export_Excel</label>
												</td><td>
													<input type="checkbox" id="Export_pdf" name="selected[block][Export_pdf]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "block" && $row->Action == "Export_pdf"){
															echo "checked";
														}
													}
													?> >
													<label for="Export_pdf">Export PDF</label>
												</td></tr>

												<tr><td>
													<b class="chkb">Panchayat:</b>
												</td><td>
													<input type="checkbox" id="Panchayatindex" name="selected[panchayat][index]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "panchayat" && $row->Action == "index"){
															echo "checked";
														}
													}
													?> >
													<label for="Panchayatindex">View</label>
												</td><td>
													<input type="checkbox" id="Panchayatadd" name="selected[panchayat][add]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "panchayat" && $row->Action == "add"){
															echo "checked";
														}
													}
													?>>
													<label for="Panchayatadd">add</label>
												</td><td>
													<input type="checkbox" id="Panchayatedit" name="selected[panchayat][edit]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "panchayat" && $row->Action == "edit"){
															echo "checked";
														}
													}
													?> >
													<label for="Panchayatedit">Edit</label>
												</td><td>
													<input type="checkbox" id="Panchayatdelete" name="selected[panchayat][delete]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "panchayat" && $row->Action=="delete"){
															echo "checked";
														}
													}
													?>>
													<label for="Panchayatdelete">Delete</label>
												</td><td>
													<input type="checkbox" id="export_csv" name="selected[panchayat][export_csv]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "panchayat" && $row->Action == "export_csv"){
															echo "checked";
														}
													}
													?> >
													<label for="export_csv">Export_Excel</label>
												</td><td>
													<input type="checkbox" id="Export_pdf" name="selected[panchayat][Export_pdf]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "panchayat" && $row->Action == "Export_pdf"){
															echo "checked";
														}
													}
													?> >
													<label for="Export_pdf">Export PDF</label>
												</td></tr>
												<tr><td>
													<b class="chkb" style="margin-right: 34px;"> Subcenter</b> 
												</td><td>
													<input type="checkbox" id="Subcenterindex" name="selected[Subcenter][index]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "Subcenter" && $row->Action == "index"){
															echo "checked";
														}
													}
													?>>
													<label for="Subcenterindex">View</label>
												</td><td>
													<input type="checkbox" id="Subcenteradd" name="selected[Subcenter][add]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "Subcenter" && $row->Action == "add"){
															echo "checked";
														}
													}
													?> >
													<label for="Subcenteradd">add</label>
												</td><td>
													<input type="checkbox" id="Subcenteredit" name="selected[Subcenter][edit]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "Subcenter" && $row->Action == "edit"){
															echo "checked";
														}
													}
													?> >
													<label for="Subcenteredit">Edit</label>
												</td><td>
													<input type="checkbox" id="Subcenterdelete" name="selected[Subcenter][delete]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "Subcenter" && $row->Action == "delete"){
															echo "checked";
														}
													}
													?> >
													<label for="Subcenterdelete">Delete</label>
												</td><td>
													<input type="checkbox" id="export_csv" name="selected[Subcenter][export_csv]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "Subcenter" && $row->Action == "export_csv"){
															echo "checked";
														}
													}
													?> >
													<label for="export_csv">Export_Excel</label>
												</td><td>
													<input type="checkbox" id="Export_pdf" name="selected[Subcenter][Export_pdf]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "Subcenter" && $row->Action == "Export_pdf"){
															echo "checked";
														}
													}
													?> >
													<label for="Export_pdf">Export PDF</label>
												</td></tr>
												<tr><td>
													<b class="chkb" style="margin-right: 34px;">Village</b> 
												</td><td>
													<input type="checkbox" id="Villageindex" name="selected[village][index]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "village" && $row->Action == "index"){
															echo "checked";
														}
													}
													?> >
													<label for="Villageindex">View</label>
												</td><td>
													<input type="checkbox" id="Villageadd" name="selected[village][add]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "village" && $row->Action == "add"){
															echo "checked";
														}
													}
													?> >
													<label for="Villageadd">add</label>
												</td><td>
													<input type="checkbox" id="Villageedit" name="selected[village][edit]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "village" && $row->Action == "edit"){
															echo "checked";
														}
													}
													?> >
													<label for="Villageedit">Edit</label>
												</td><td>
													<input type="checkbox" id="Villagedelete" name="selected[village][delete]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "village" && $row->Action == "delete"){
															echo "checked";
														}
													}
													?> >
													<label for="Villagedelete">Delete</label>
												</td><td>
													<input type="checkbox" id="export_csv" name="selected[village][export_csv]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "village" && $row->Action == "export_csv"){
															echo "checked";
														}
													}
													?> >
													<label for="export_csv">Export_Excel</label>
												</td><td>
													<input type="checkbox" id="Export_pdf" name="selected[village][Export_pdf]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "village" && $row->Action == "Export_pdf"){
															echo "checked";
														}
													}
													?> >
													<label for="Export_pdf">Export PDF</label>
												</td></tr>

											</table>
										</div>
									</div>
								</div>
								<!-- end manage location -->

								<!-- start code in Reports -->
								<div class="col-sm-12">
									<div class="col-sm-12 a_bunch_of_checkboxes">
										<h2 class="card-inside-title shodo-h2">Manage Reports &nbsp;&nbsp;&nbsp;
											<input type="checkbox" class="checkAll"/>Check All
										</h2>
										<div class="demo-checkbox">
											<table class="table table-bordered">
												<tr><td>
													<b class="chkb" style="margin-right:42px;">Household Verification</b>
												</td><td>
													<input type="checkbox" id="Household_verificationindex" name="selected[Household_verification][index]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "Household_verification" && $row->Action == "index"){
															echo "checked";
														}
													}
													?>>
													<label for="Household_verificationindex">View</label>
												</td><td>
													<input type="checkbox" id="export_csv" name="selected[Household_verification][export_csv]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "Household_verification" && $row->Action == "export_csv"){
															echo "checked";
														}
													}
													?> >
													<label for="export_csv">Export_Excel</label>
												</td><td colspan="3">
													<input type="checkbox" id="Export_pdf" name="selected[Household_verification][Export_pdf]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "Household_verification" && $row->Action == "Export_pdf"){
															echo "checked";
														}
													}
													?> >
													<label for="Export_pdf">Export PDF</label>
												</td></tr>
												<tr><td>
													<b class="chkb" style="margin-right: 31px;">Household Summary</b>
												</td><td>
													<input type="checkbox" id="household_reportindex" name="selected[household_report][index]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "household_report" && $row->Action == "index"){
															echo "checked";
														}
													}
													?> >
													<label for="household_reportindex">View</label>
												</td><td>
													<input type="checkbox" id="household_reportedit" name="selected[household_report][edit]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "household_report" && $row->Action == "edit"){
															echo "checked";
														}
													}
													?> >
													<label for="household_reportedit">Edit</label>
												</td><td>
													<input type="checkbox" id="household_reportdelete" name="selected[household_report][delete]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "household_report" && $row->Action == "delete"){
															echo "checked";
														}
													}
													?> >
													<label for="household_reportdelete">Delete</label>
												</td><td>
													<input type="checkbox" id="export_csv" name="selected[household_report][export_csv]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "household_report" && $row->Action == "export_csv"){
															echo "checked";
														}
													}
													?> >
													<label for="export_csv">Export_Excel</label>
												</td><td>
													<input type="checkbox" id="Export_pdf" name="selected[household_report][Export_pdf]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "household_report" && $row->Action == "Export_pdf"){
															echo "checked";
														}
													}
													?> >
													<label for="Export_pdf">Export PDF</label>
												</td></tr>
												<tr><td>
													<b class="chkb" style="margin-right: 42px;">Track Changes</b>
												</td><td>
													<input type="checkbox" id="track_changesindex" name="selected[track_changes][index]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "track_changes" && $row->Action == "index"){
															echo "checked";
														}
													}
													?> >
													<label for="track_changesindex">View</label>
												</td><td>
													<input type="checkbox" id="export_csv" name="selected[track_changes][export_csv]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "track_changes" && $row->Action == "export_csv"){
															echo "checked";
														}
													}
													?> >
													<label for="export_csv">Export_Excel</label>
												</td><td colspan="3">
													<input type="checkbox" id="Export_pdf" name="selected[track_changes][Export_pdf]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "track_changes" && $row->Action == "Export_pdf"){
															echo "checked";
														}
													}
													?> >
													<label for="Export_pdf">Export PDF</label>
												</td></tr>

												<tr><td>
													<b class="chkb">Data Summary</b>
												</td><td>
													<input type="checkbox" id="data_reportindex" name="selected[data_report][index]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "data_report" && $row->Action == "index"){
															echo "checked";
														}
													}
													?> >
													<label for="data_reportindex">View</label>
												</td><td>
													<input type="checkbox" id="export_csv" name="selected[data_report][export_csv]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "data_report" && $row->Action == "export_csv"){
															echo "checked";
														}
													}
													?> >
													<label for="export_csv">Export_Excel</label>
												</td><td colspan="3">
													<input type="checkbox" id="Export_pdf" name="selected[data_report][Export_pdf]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "data_report" && $row->Action == "Export_pdf"){
															echo "checked";
														}
													}
													?> >
													<label for="Export_pdf">Export PDF</label>
												</td></tr>
												<tr><td>
													<b class="chkb" style="margin-right: 34px;">VHND Schedule</b> 
												</td><td>
													<input type="checkbox" id="vhnd_scheduleindex" name="selected[vhnd_schedule][index]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "vhnd_schedule" && $row->Action == "index"){
															echo "checked";
														}
													}
													?> >
													<label for="vhnd_scheduleindex">View</label>
												</td><td>
													<input type="checkbox" id="export_csv" name="selected[vhnd_schedule][export_csv]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "vhnd_schedule" && $row->Action == "export_csv"){
															echo "checked";
														}
													}
													?> >
													<label for="export_csv">Export_Excel</label>
												</td><td colspan="3">
													<input type="checkbox" id="Export_pdf" name="selected[vhnd_schedule][Export_pdf]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "vhnd_schedule" && $row->Action == "Export_pdf"){
															echo "checked";
														}
													}
													?> >
													<label for="Export_pdf">Export PDF</label>
												</td></tr>
												<tr><td>
													<b class="chkb" style="margin-right: 34px;">AF Module</b> 
												</td><td>
													<input type="checkbox" id="af_moduleindex" name="selected[af_module][index]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "af_module" && $row->Action == "index"){
															echo "checked";
														}
													}
													?>>
													<label for="af_moduleindex">View</label>
												</td><td>
													<input type="checkbox" id="export_csv" name="selected[af_module][export_csv]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "af_module" && $row->Action == "export_csv"){
															echo "checked";
														}
													}
													?> >
													<label for="export_csv">Export_Excel</label>
												</td><td colspan="3">
													<input type="checkbox" id="Export_pdf" name="selected[af_module][Export_pdf]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "af_module" && $row->Action == "Export_pdf"){
															echo "checked";
														}
													}
													?> >
													<label for="Export_pdf">Export PDF</label>
												</td></tr>
												<tr><td>

													<b class="chkb" style="margin-right: 34px;"> HRP</b> 
												</td><td>
													<input type="checkbox" id="hrpindex" name="selected[hrp][index]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "hrp" && $row->Action == "index"){
															echo "checked";
														}
													}
													?>>
													<label for="hrpindex">View</label>
												</td><td>
													<input type="checkbox" id="export_csv" name="selected[hrp][export_csv]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "hrp" && $row->Action == "export_csv"){
															echo "checked";
														}
													}
													?> >
													<label for="export_csv">Export_Excel</label>
												</td><td colspan="3">
													<input type="checkbox" id="Export_pdf" name="selected[hrp][Export_pdf]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "hrp" && $row->Action == "Export_pdf"){
															echo "checked";
														}
													}
													?> >
													<label for="Export_pdf">Export PDF</label>
												</td></tr>
												<tr><td>

													<b class="chkb" style="margin-right: 34px;"> HRP Current</b> 
												</td><td>
													<input type="checkbox" id="hrpindex" name="selected[hrp_current][index]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "hrp_current" && $row->Action == "index"){
															echo "checked";
														}
													}
													?>>
													<label for="hrpindex">View</label>
												</td><td>
													<input type="checkbox" id="export_csv" name="selected[hrp_current][export_csv]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "hrp_current" && $row->Action == "export_csv"){
															echo "checked";
														}
													}
													?> >
													<label for="export_csv">Export_Excel</label>
												</td><td colspan="3">
													<input type="checkbox" id="Export_pdf" name="selected[hrp_current][Export_pdf]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "hrp_current" && $row->Action == "Export_pdf"){
															echo "checked";
														}
													}
													?> >
													<label for="Export_pdf">Export PDF</label>
												</td></tr>

												<tr><td>
													<b class="chkb" style="margin-right: 34px;"> Immunization</b> 
												</td><td>
													<input type="checkbox" id="immunizationindex" name="selected[immunization][index]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "immunization" && $row->Action == "index"){
															echo "checked";
														}
													}
													?>>
													<label for="immunizationindex">View</label>
												</td><td>
													<input type="checkbox" id="export_csv" name="selected[immunization][export_csv]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "immunization" && $row->Action == "export_csv"){
															echo "checked";
														}
													}
													?> >
													<label for="export_csv">Export_Excel</label>
												</td><td colspan="3">
													<input type="checkbox" id="Export_pdf" name="selected[immunization][Export_pdf]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "immunization" && $row->Action == "Export_pdf"){
															echo "checked";
														}
													}
													?> >
													<label for="Export_pdf">Export PDF</label>
												</td></tr>

												<tr><td>
													<b class="chkb" style="margin-right: 34px;"> Immunization administered</b> 
												</td><td>
													<input type="checkbox" id="immunization_administeredindex" name="selected[immunization_administered][index]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "immunization_administered" && $row->Action == "index"){
															echo "checked";
														}
													}
													?>>
													<label for="immunization_administeredindex">View</label>
												</td><td>
													<input type="checkbox" id="export_csv" name="selected[immunization_administered][export_csv]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "immunization_administered" && $row->Action == "export_csv"){
															echo "checked";
														}
													}
													?> >
													<label for="export_csv">Export_Excel</label>
												</td><td colspan="3">
													<input type="checkbox" id="Export_pdf" name="selected[immunization_administered][Export_pdf]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "immunization_administered" && $row->Action == "Export_pdf"){
															echo "checked";
														}
													}
													?> >
													<label for="Export_pdf">Export PDF</label>
												</td></tr>												

											</table>
			
												<table  class="table table-bordered">
													<tr><td>
													<b class="chkb" style="margin-right: 34px;">Monthly Reports</b> 
												</td><td>
													<input type="checkbox" id="monthly_reportsindex" name="selected[monthly_reports][index]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "monthly_reports" && $row->Action == "index"){
															echo "checked";
														}
													}
													?>>
													<label for="monthly_reportsindex">View</label>
												</td><td>
													<input type="checkbox" id="get_monthly_report_1" name="selected[monthly_reports][get_monthly_report_1]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "monthly_reports" && $row->Action == "get_monthly_report_1"){
															echo "checked";
														}
													}
													?> >
													<label for="get_monthly_report_1">Export_Excel 1</label>
												</td>

												<td>
													<input type="checkbox" id="get_monthly_report_2" name="selected[monthly_reports][get_monthly_report_2]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "monthly_reports" && $row->Action == "get_monthly_report_2"){
															echo "checked";
														}
													}
													?> >
													<label for="get_monthly_report_2">Export_Excel 2</label>
												</td>

												<td>
													<input type="checkbox" id="get_monthly_report_3" name="selected[monthly_reports][get_monthly_report_3]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "monthly_reports" && $row->Action == "get_monthly_report_3"){
															echo "checked";
														}
													}
													?> >
													<label for="get_monthly_report_3">Export_Excel 3</label>
												</td>

												<td>
													<input type="checkbox" id="get_monthly_report_4" name="selected[monthly_reports][get_monthly_report_4]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "monthly_reports" && $row->Action == "get_monthly_report_4"){
															echo "checked";
														}
													}
													?> >
													<label for="get_monthly_report_4">Export_Excel 4</label>
												</td>

												<td colspan="3">
													<input type="checkbox" id="Export_pdf" name="selected[monthly_reports][Export_pdf]" class="filled-in" value="<?php echo set_value('RoleID');?>"
													<?php 
													foreach ($permissions_list as $row) {
														if ($row->Controller == "monthly_reports" && $row->Action == "Export_pdf"){
															echo "checked";
														}
													}
													?> >
													<label for="Export_pdf">Export PDF</label>
												</td></tr>
												</table>



										</div>
									</div>
								</div>
								<!-- end Reports location -->
								<div class="col-sm-12">
									<h2 class="card-inside-title shodo-h2">Exception Reports</h2>
									<div class="demo-checkbox">
										<table class="table table-bordered">
											<tr><td>
												<b class="chkb">List of Women marked pregnant having elapsed LMP (10 months):</b> 
											</td><td>
												<input type="checkbox" id="exception_reportsindex" name="selected[exception_reports][pregnant_women_more_than_10_months_lmp]"
												<?php 
												foreach ($permissions_list as $row) {
													if ($row->Controller == "exception_reports" && $row->Action == "pregnant_women_more_than_10_months_lmp"){
														echo "checked";
													}
												}
												?>>
												<label for="exception_reportsindex">View</label>
											</td><td>
												<input type="checkbox" id="export_csv" name="selected[exception_reports][export_csv]" class="filled-in" value="<?php echo set_value('RoleID');?>"
												<?php 
												foreach ($permissions_list as $row) {
													if ($row->Controller == "exception_reports" && $row->Action == "export_csv"){
														echo "checked";
													}
												}
												?> >
												<label for="export_csv">Export_Excel</label>
											</td><td>
												<input type="checkbox" id="Export_pdf" name="selected[Exception_reports][Export_pdf]" class="filled-in" value="<?php echo set_value('RoleID');?>"
												<?php 
												foreach ($permissions_list as $row) {
													if ($row->Controller == "Exception_reports" && $row->Action == "Export_pdf"){
														echo "checked";
													}
												}
												?> >
												<label for="Export_pdf">Expodfdsfdrt PDF</label>
											</td></tr></table>
										</div>
									</div>


									<div class="col-sm-12">
										<div class="col-sm-12 a_bunch_of_checkboxes">
											<h2 class="card-inside-title shodo-h2">Manage Data &nbsp;&nbsp;&nbsp;
												<input type="checkbox" class="checkAll"/>Check All
											</h2>
											<div class="demo-checkbox">
												<table class="table table-bordered">

													<tr><td>
														<b class="chkb" style="margin-right: 34px;">Household</b> 
													</td><td>
														<input type="checkbox" id="Householdindex" name="selected[Household][index]" class="filled-in" value="<?php echo set_value('RoleID');?>"
														<?php 
														foreach ($permissions_list as $row) {
															if ($row->Controller == "Household" && $row->Action == "index"){
																echo "checked";
															}
														}
														?>>
														<label for="Householdindex">View</label>
													</td><td>
														<input type="checkbox" id="Householdadd" name="selected[Household][add]" class="filled-in" value="<?php echo set_value('RoleID');?>"
														<?php 
														foreach ($permissions_list as $row) {
															if ($row->Controller == "Household" && $row->Action == "add"){
																echo "checked";
															}
														}
														?>>
														<label for="Householdadd">add</label>
													</td><td>
														<input type="checkbox" id="Householdedit" name="selected[Household][edit]" class="filled-in" value="<?php echo set_value('RoleID');?>"
														<?php 
														foreach ($permissions_list as $row) {
															if ($row->Controller == "Household" && $row->Action == "edit"){
																echo "checked";
															}
														}
														?>>
														<label for="Householdedit">Edit</label>
													</td><td>
														<input type="checkbox" id="Householddelete" name="selected[Household][delete]" class="filled-in" value="<?php echo set_value('RoleID');?>"
														<?php 
														foreach ($permissions_list as $row) {
															if ($row->Controller == "Household" && $row->Action == "delete"){
																echo "checked";
															}
														}
														?>>
														<label for="Householddelete">Delete</label>
													</td><td>
														<input type="checkbox" id="export_csv" name="selected[Household][export_csv]" class="filled-in" value="<?php echo set_value('RoleID');?>"
														<?php 
														foreach ($permissions_list as $row) {
															if ($row->Controller == "Household" && $row->Action == "export_csv"){
																echo "checked";
															}
														}
														?> >
														<label for="export_csv">Export_Excel</label>
													</td><td>
														<input type="checkbox" id="Export_pdf" name="selected[Household][Export_pdf]" class="filled-in" value="<?php echo set_value('RoleID');?>"
														<?php 
														foreach ($permissions_list as $row) {
															if ($row->Controller == "Household" && $row->Action == "Export_pdf"){
																echo "checked";
															}
														}
														?> >
														<label for="Export_pdf">Export PDF</label>
													</td></tr>
												</table>
											</div>
										</div>


										<div class="col-sm-12" style="display: none;">
											<h2 class="card-inside-title shodo-h2">Ajax Controller</h2>
											<div class="demo-checkbox">
												<table class="table table-bordered">
													<tr><td>
														<b class="chkb">Ajax</b> 
													</td><td>
														<input type="checkbox" id="get_indicator_trendindex" name="selected[Output_indicators][get_indicator_trend]" checked="cehcked" value="<?php echo set_value('RoleID');?>"
														<?php 
														foreach ($permissions_list as $row) {
															if ($row->Controller == "Output_indicators" && $row->Action=="get_indicator_trend"){
																echo "Default";
															}
														}
														?>>
														<label for="get_indicator_trendindex">Default</label>
													</td></tr>
												</table>
											</div>
										</div>

									<!-- 	<div class="col-sm-12" style="display: none;">
											<h2 class="card-inside-title shodo-h2">Household</h2>
											<div class="demo-checkbox">
												<table class="table table-bordered">
													<tr><td>
														<b class="chkb">Household</b> 
													</td><td>
														<input type="checkbox" id="get_indicator_trendindex" name="selected[Household][familymembers]" checked="cehcked" value="<?php echo set_value('RoleID');?>"
														<?php 
														foreach ($permissions_list as $row) {
															if ($row->Controller == "Household" && $row->Action=="familymembers"){
																echo "Default";
															}
														}
														?>>
														<label for="get_indicator_trendindex">Default</label>
													</td></tr>
												</table>
											</div>
										</div> -->


										<div class="col-sm-12" style="display: none;">
											<h2 class="card-inside-title shodo-h2">Drill downreport Graph</h2>
											<div class="demo-checkbox">
												<table class="table table-bordered">
													<tr><td>
														<b class="chkb">Graph</b> 
													</td><td>
														<input type="checkbox" id="get_indicator_trendindex" name="selected[graph][preg_women_reg_first_trimester]" checked="cehcked" value="<?php echo set_value('RoleID');?>"
														<?php 
														foreach ($permissions_list as $row) {
															if ($row->Controller == "graph" && $row->Action=="preg_women_reg_first_trimester"){
																echo "Default";
															}
														}
														?>>

														<label for="get_indicator_trendindex">View Graph1</label>
													</td><td>
														<input type="checkbox" id="get_indicator_trendindex" name="selected[graph][one_anc_checkup]" checked="cehcked" value="<?php echo set_value('RoleID');?>"
														<?php 
														foreach ($permissions_list as $row) {
															if ($row->Controller == "graph" && $row->Action=="one_anc_checkup"){
																echo "Default";
															}
														}
														?>>
														<label for="get_indicator_trendindex">View Graph2</label>
													</td><td>
														<input type="checkbox" id="get_indicator_trendindex" name="selected[graph][two_anc_checkup]" checked="cehcked" value="<?php echo set_value('RoleID');?>"
														<?php 
														foreach ($permissions_list as $row) {
															if ($row->Controller == "graph" && $row->Action=="two_anc_checkup"){
																echo "Default";
															}
														}
														?>>
														<label for="get_indicator_trendindex">View Graph3</label>
													</td><td>
														<input type="checkbox" id="get_indicator_trendindex" name="selected[graph][three_anc_checkup]" checked="cehcked" value="<?php echo set_value('RoleID');?>"
														<?php 
														foreach ($permissions_list as $row) {
															if ($row->Controller == "graph" && $row->Action=="three_anc_checkup"){
																echo "Default";
															}
														}
														?>>
														<label for="get_indicator_trendindex">View Graph4</label>
													</td><td>
														<input type="checkbox" id="get_indicator_trendindex" name="selected[graph][four_anc_checkup]" checked="cehcked" value="<?php echo set_value('RoleID');?>"
														<?php 
														foreach ($permissions_list as $row) {
															if ($row->Controller == "graph" && $row->Action=="four_anc_checkup"){
																echo "Default";
															}
														}
														?>>
														<label for="get_indicator_trendindex">View Graph5</label>
													</td></tr>
													<tr><td>
														<input type="checkbox" id="get_indicator_trendindex" name="selected[graph][tt2_booster]" checked="cehcked" value="<?php echo set_value('RoleID');?>"
														<?php 
														foreach ($permissions_list as $row) {
															if ($row->Controller == "graph" && $row->Action=="tt2_booster"){
																echo "Default";
															}
														}
														?>>
														<label for="get_indicator_trendindex">View Graph6</label>
													</td><td>
														<input type="checkbox" id="get_indicator_trendindex" name="selected[graph][institutional_delivery]" checked="cehcked" value="<?php echo set_value('RoleID');?>"
														<?php 
														foreach ($permissions_list as $row) {
															if ($row->Controller == "graph" && $row->Action=="institutional_delivery"){
																echo "Default";
															}
														}
														?>>
														<label for="get_indicator_trendindex">View Graph7</label>
													</td><td>
														<input type="checkbox" id="get_indicator_trendindex" name="selected[graph][newborns_visited_two_or_more_times]" checked="cehcked" value="<?php echo set_value('RoleID');?>"
														<?php 
														foreach ($permissions_list as $row) {
															if ($row->Controller == "graph" && $row->Action=="newborns_visited_two_or_more_times"){
																echo "Default";
															}
														}
														?>>
														<label for="get_indicator_trendindex">View Graph8</label>
													</td><td>
														<input type="checkbox" id="get_indicator_trendindex" name="selected[graph][newborns_visited_three_or_more_times_home_delivery]" checked="cehcked" value="<?php echo set_value('RoleID');?>"
														<?php 
														foreach ($permissions_list as $row) {
															if ($row->Controller == "graph" && $row->Action=="newborns_visited_three_or_more_times_home_delivery"){
																echo "Default";
															}
														}
														?>>
														<label for="get_indicator_trendindex">View Graph9</label>
													</td><td>
														<input type="checkbox" id="get_indicator_trendindex" name="selected[graph][newborns_visited_two_or_more_times_instituional]" checked="cehcked" value="<?php echo set_value('RoleID');?>"
														<?php 
														foreach ($permissions_list as $row) {
															if ($row->Controller == "graph" && $row->Action=="newborns_visited_two_or_more_times_instituional"){
																echo "Default";
															}
														}
														?>>
														<label for="get_indicator_trendindex">View Graph10</label>
													</td><td>
														<input type="checkbox" id="get_indicator_trendindex" name="selected[graph][low_birth_weight]" checked="cehcked" value="<?php echo set_value('RoleID');?>"
														<?php 
														foreach ($permissions_list as $row) {
															if ($row->Controller == "graph" && $row->Action=="low_birth_weight"){
																echo "Default";
															}
														}
														?>>
														<label for="get_indicator_trendindex">View Graph11</label>
													</td></tr>

													<tr><td colspan="6">
														<input type="checkbox" id="indicator_anm_listindex" name="selected[indicator_anm_list][get_indicator_trend]" checked="cehcked" value="<?php echo set_value('RoleID');?>"
														<?php 
														foreach ($permissions_list as $row) {
															if ($row->Controller == "indicator_anm_list" && $row->Action=="two_anc_checkup"){
																echo "Default";
															}
														}
														?>>
														<label for="indicator_anm_listindex">Go to table data</label>
													</td></tr>
												</table>
											</div>
										</div>



										<div class="col-md-12" style="margin-bottom: 20px;">
											<div align="center"> 
												<button  type="submit"  class="btn btn-success btn-sm m-t-10 waves-effect" data-toggle="tooltip" title="Save">Save</button>
												<a href="<?php echo site_url("Permissions/index");?>" class="btn btn-danger btn-sm m-t-10 waves-effect" data-toggle="tooltip" title="Close">Close</a> 
											</div>
										</div>

									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php } } ?>
				<!-- #END# Exportable Table -->
			</section>

			<script type="text/javascript">
				$('.checkAll').on('click',function(){
					if($(this).is(':checked')){
						$(this).closest('div').find('input[type="checkbox"]').prop('checked','checked');
					}else{        
						$(this).closest('div').find('input[type="checkbox"]').prop('checked','');
					}
				});
			</script>
