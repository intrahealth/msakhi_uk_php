<section id="content">
	<?php foreach ($role_permission as $row) { if ($row->Controller == "counselling" && $row->Action == "index") { ?>
	<div class="block-header">
		<h2>Manage Counselling</h2><br>
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
			<div class="card">
				<div class="card-header">
					<h2>Counselling List <small>List of Counselling </small></h2>
				</div>
				<form action="" method="post">
					<div class="row" style="padding-left : 15px;">
						<div class="col-lg-2">
							<div class="form-group fg-line">
								<div class="fg-line">
									<div class="select">
										<h5>State Name</h5>
										<?php echo form_error('StateCode'); ?>
										<select class="form-control" data-toggle="dropdown" id="StateCode" name="StateCode">
											<option value="">--select--</option>
											<?php foreach($State_List as $row){?>
											<option value="<?php echo $row->StateCode;?>" <?php echo (trim($this->input->post('StateCode')) == $row->StateCode?"selected":"");?>><?php echo $row->StateName;?></option>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>
						</div>

						<div class="col-lg-2">
							<div class="form-group fg-line">
								<div class="select">
									<h5>ANM Name</h5>
									<?php echo form_error('ANMCode'); ?>
									<select class="form-control" data-toggle="dropdown" id="ANMCode" name="ANMCode">
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
									<select class="form-control" data-toggle="dropdown" id="ASHACode" name="ASHACode">
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
									<select class="form-control" data-toggle="dropdown" id="VillageCode" name="VillageCode">
										<option value="">--select--</option>
										<?php foreach($Village_list as $row){?>
										<option value="<?php echo $row->VillageCode;?>" <?php echo (trim($this->input->post('VillageCode')) == $row->VillageCode?"selected":"");?>><?php echo $row->VillageName;?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>

						<!-- <div class="col-lg-2">
							<div class="form-group fg-line">
								<div class="select">
									<h5>Verified</h5>
									<?php echo form_error('Verified'); ?>
									<select class="form-control" data-toggle="dropdown" id="Verified" name="Verified">
										<option value="">--select--</option>
										<option value="1">All</option>
										<option value="2">Yes</option>
										<option value="3">No</option>
									</select>
								</div>
							</div>
						</div> 
 -->
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
				</form>
			</div>

			<div class="card">	
				<div class="card-header"></div>												

				<table id="data-table-command" class="table table-striped table-vmiddle table table-condensed">
					<thead>



						<!-- <tr class="success">
							<th class="text-middle" data-column-id="childGUID" data-visible="false"  data-order="asc">ID</th>
							<th class="text-middle" data-column-id="PWName">Mother's Name/ Child Name</th>
							<th class="text-middle" data-column-id="ANMName">ANM Name</th>
							<th class="text-middle" data-column-id="ASHAName">ASHA Name</th>
							<th class="text-middle" data-column-id="VillageName">Village Name</th>
							<th class="text-middle" data-column-id="child_dob">Age(Month/Day)</th>

							<th class="text-middle" data-column-id="IsDeleted">Deleted Status</th>
							<th class="text-middle" data-column-id="commands" data-formatter="commands" data-sortable="false">Member Details</th>
						</tr> -->



						<tr class="success">
							<th class="text-middle" data-column-id="childGUID" data-visible="false"  data-order="asc">ID</th>

							<th data-column-id="PWName">Mother's Name/ Child Name</th>
							<th data-column-id="child_dob">Age(Month/Day)</th>
							<th data-column-id="commands" data-formatter="commands" data-sortable="false">Counselling</th>
						</tr>
					</thead>

					<tbody>
						<?php foreach($List_Counselling as $row){ ?>
						<tr>
							<td><?php echo $row->childGUID;?></td>
							<td><?php echo $row->PWName.' / '.$row->child_name; ?></td>
							<td><?php echo $row->child_dob; ?></td>
						</tr>
						<?php } ?>
					</tbody>

				</table>
			</div>
		</div>
		<?php } } ?>
	</section>


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

				caseSensitive: false,

				
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
						return  "<a href=\"<?php echo site_url('counselling/edit_immunization_counselling');?>/" + row.childGUID + "\" type=\"button\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\"" + row.childGUID +"\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"\" data-original-title= \"View Activities\"><span class=\"zmdi zmdi-view-list\"></span></a>"

						+

						"<a href=\"<?php echo site_url('Household/delete');?>/" + row.childGUID + "\" type=\"button\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\"" + row.childGUID + "\"  data-toggle=\"confirmation\"data-singleton=\"true\" data-placement=\"left\" data-title=\"Proceed to delete?\" ><span class=\"zmdi zmdi-delete\"></span></a>";
					},


				}

			}).on("loaded.rs.jquery.bootgrid", function () {

				if ($('[data-toggle="tooltip"]')[0]) {
					$('[data-toggle="tooltip"]').tooltip();
				}

				$('[data-toggle=confirmation]').confirmation({
					rootSelector: '[data-toggle=confirmation]',
				});


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

		$('#ASHACode').change(function(){
			var ASHACode = $(this).val();
			$.post('<?php echo site_url('Ajax/getvillageLists1/');?>/'+ASHACode, {}, function(raw){
				$('#VillageCode').html(raw);
			});

		});


		function doSearch()
		{
			$("#data-table-command").bootgrid('reload');
		}

		function clearFilters(){
			$('#ANMCode').val('');
			$('#ASHACode').val('');
			$('#IsDeleted').val('');
			doSearch();
		}

	</script>






