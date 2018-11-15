	<section id="content">
		<?php foreach ($role_permission as $row) { if($row->Controller == "delivery" && $row->Action == "index") { ?>
		<div class="container" style="width: 1070px;">
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

					<div class="card">
						<div class="card-header">
							<h2>Delivery list <small>List of Delivery </small></h2>
						</div>

							<div class="row" style="padding-left : 15px;">
						<div class="col-lg-2">
							<div class="form-group fg-line">
								<div class="select">
									<h5>State Name</h5>
									<?php echo form_error('StateCode'); ?>
									<select class="form-control" data-toggle="dropdown" id="StateCode" name="StateCode" required>
										<option value="">--select--</option>
										<?php foreach($State_List as $row){?>
										<option value="<?php echo $row->StateCode;?>" <?php echo (trim($this->input->post('StateCode')) == $row->StateCode?"selected":"");?>><?php echo $row->StateName;?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>

						<div class="col-lg-2">
							<div class="form-group fg-line">
								<div class="select">
									<h5>ANM Name</h5>
									<?php echo form_error('ANMCode'); ?>
									<select class="form-control" data-toggle="dropdown" id="ANMCode" name="ANMCode" required>
										<option value="">--select--</option>
										<?php foreach($Anm_list as $row){?>
										<option value="<?php echo $row->ANMCode;?>" <?php echo (trim($this->input->post('ANMCode')) == $row->ANMCode?"selected":"");?>><?php echo $row->ANMName;?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>

						<div class="col-lg-2">
							<div class="form-group fg-line">
								<div class="select">
									<h5>ASHA Name</h5>
									<?php echo form_error('ASHACode'); ?>
									<select class="form-control" data-toggle="dropdown" id="ASHACode" name="ASHACode" required>
										<option value="">--select--</option>
										<?php foreach($Asha_list as $row){?>
										<option value="<?php echo $row->ASHACode;?>" <?php echo (trim($this->input->post('ASHACode')) == $row->ASHACode?"selected":"");?>><?php echo $row->ASHAName;?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>

						<div class="col-lg-2">
							<div class="form-group fg-line">
								<div class="select">
									<h5>Village Name</h5>
									<?php echo form_error('VillageCode'); ?>
									<select class="form-control" data-toggle="dropdown" id="VillageCode" name="VillageCode" required>
										<option value="">--select--</option>
										<?php foreach($Village_list as $row){?>
										<option value="<?php echo $row->VillageCode;?>" <?php echo (trim($this->input->post('VillageCode')) == $row->VillageCode?"selected":"");?>><?php echo $row->VillageName;?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>						 

						<div class="col-lg-1">
							<div class="form-group fg-line">
								<h5>Deleted</h5>
								<?php echo form_error('IsDeleted'); ?>
								<select class="form-control" data-toggle="dropdown" id="IsDeleted" name="IsDeleted">
									<option value="">--select--</option>
									<option value="1">Yes</option>
									<option value="2">No</option>
								</select>							
							</div>
						</div>
						
						<div style="text-align:center;">
							<button class="btn btn-info" id="doSearch" name="doSearch" style="margin-top : 20px;" onclick="doSearch()" >Apply filters</button>
							&nbsp &nbsp
							<button class="btn btn-default" id="clearFilters" style="margin-top : 20px;" name="clearFilters" onclick="clearFilters()" >Clear</button>
						</div>

						<div style="margin-top: 30px;"></div>
					</div>
					</div>

					<div class="card">
						<div class="card-header">
						</div>

						<div class="table-responsive">
							<table id="data-table-command" class="table table-striped table-vmiddle table table-condensed">
								<thead>
									<tr class="success">

										<th class="text-middle" data-column-id="PWGUID" data-visible="false"  data-order="asc">ID</th>

										<th class="text-middle" data-column-id="PWName">Mother Name</th>
										<!-- <th class="text-middle" data-column-id="FamilyMemberName">Husband Name</th> -->
										<th class="text-middle" data-column-id="DeliveryDateTime">Delivery Date</th>
										<th class="text-middle" data-column-id="IsDeleted" data-formatter="IsDeleted">Deleted Status</th>
										<th data-column-id="commands" data-formatter="commands" data-sortable="false">Pregnent Woman Details</th>
										
									</tr>
								</thead>

							</table>
						</div>
					</div>
				</div>
				<?php } } ?>
			</section>

			<!-- Data Table -->
			<script type="text/javascript">
				$(document).ready(function()
				{
					$('#ANMCode').change(function(){
						var ANMCode = $(this).val();
						$.post('<?php echo site_url('Ajax/getAshaOfAnmViaAnmCode');?>/'+ANMCode, {}, function(raw){
							$('#ASHACode').html(raw);
						});
					});
					bindBootgrid();
				});

				function bindBootgrid()
				{
					$("#data-table-command").bootgrid('destroy').bootgrid({

						ajax: true,
						url: "<?php echo site_url("delivery/getDeliveryList");?>",
						post: function ()
						{

							return {
								id: "b0df282a-0d67-40e5-8558-c9e93b7befed",

								StateCode : $('#StateCode').val(), 
								ANMCode : $('#ANMCode').val(),
								ASHACode : $('#ASHACode').val(),
								VillageCode : $('#VillageCode').val(),
								IsDeleted : $('#IsDeleted').val(),
							};
						},
						css: {
							icon: 'zmdi icon',
							iconColumns: 'zmdi-view-module',
							iconDown: 'zmdi-expand-more',
							iconRefresh: 'zmdi-refresh',
							iconUp: 'zmdi-expand-less'
						},
						formatters: {

							"commands": function(column, row)
							{
								return  "<a href=\"<?php echo site_url('delivery/view_delivery_detail');?>/" + row.pwGUID + "\" type=\"button\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\"" + row.pwGUID +"\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"\" data-original-title= \"View Pregnent woman\"><span class=\"zmdi zmdi-view-carousel\"></span></a>"
								+
								"<a href=\"<?php echo site_url('delivery/view_child');?>/" + row.pwGUID + "\" type=\"button\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\"" + row.pwGUID + "\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"\" data-original-title=\"Child Details\"><span class=\"zmdi zmdi-view-quilt\"></span></a>"

								+

								"<a href=\"<?php echo site_url('delivery/delete');?>/" + row.pwGUID + "\" type=\"button\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\"" + row.pwGUID + "\"  data-toggle=\"confirmation\"data-singleton=\"true\" data-placement=\"left\" data-title=\"Proceed to delete?\" ><span class=\"zmdi zmdi-delete\"></span></a>";
							},

							"IsDeleted": function(column, row){

										
										if(row.IsDeleted == 0){
											var formatter = "<span>No</span>";
										}else{
											var formatter = "<span>Yes</span>";
										}
										return formatter;
									},


						}

					}).on("loaded.rs.jquery.bootgrid", function () {

						if ($('[data-toggle="tooltip"]')[0]) {
							$('[data-toggle="tooltip"]').tooltip();
						}


					});
				}

				$('#StateCode').change(function(){
					var StateCode = $(this).val();
					$.post('<?php echo site_url('Ajax/getanmLists1/');?>'+StateCode, {}, function(raw){
						console.log('in response');
						console.log(raw);
						$('#ANMCode').html(raw);
					});
				});

				$('#ANMCode').change(function(){
					var ANMCode = $(this).val();
					$.post('<?php echo site_url('Ajax/getashaLists2/');?>/'+ANMCode, {}, function(raw){
						$('#ASHACode').html(raw);
					});

				});


				function doSearch()
				{
					$("#data-table-command").bootgrid('reload');
				}

				function clearFilters(){
					$('#ANMCode').val('');
					$('#ASHACode').val('');
					$('#VillageCode').val('');
					$('#IsDeleted').val('');
					doSearch();
				}


			</script>