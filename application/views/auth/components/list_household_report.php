<style>
	.bootgrid-table th>.column-header-anchor>.text {
		display: block;
		margin: 0 16px 0 0;
		/* overflow: auto !important; */
		-ms-text-overflow: ellipsis;
		-o-text-overflow: ellipsis;
		text-overflow: ellipsis;
		white-space: pre-wrap !important;
	}
	.filter-design{
		height: 36px;
		width: 87%;
		border-radius: 8px;
	}
</style>

<section id="content">
	<?php foreach ($role_permission as $row) { if ($row->Controller == "household_report"  && $row->Action == "index") { ?>
	<div class="container" style="width: 1080px;">
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
						<h2>Household Report List <small>List of Household Report </small></h2>
						<!-- <form action="" method="Post"> -->
						<div class="row" style="padding-left : 25px;">
							<div class="col-sm-3">
								<div class="form-group">
									<div class="fg-line">
										<div class="select">
											<h4>State Name</h4>
											<select class="filter-design" data-toggle="dropdown" id="StateCode" name="StateCode" required>
												<option value="">--select--</option>
												<?php foreach($State_List as $row){?>
												<option value="<?php echo $row->StateCode;?>" <?php echo (trim($this->input->post('StateCode')) == $row->StateCode?"selected":"");?>><?php echo $row->StateName;?></option>
												<?php } ?>
											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group">
									<div class="fg-line">
										<div class="select">
											<h4>ANM Name</h4>
											<select class="filter-design" data-toggle="dropdown" id="ANMCode" name="ANMCode" >
												<option value="">---select---</option>
												<?php foreach($Anm_list as $row){?>
												<option value="<?php echo $row->ANMCode;?>" <?php echo ($row->ANMCode == trim($this->input->post("ANMCode"))?"selected":"");?>><?php echo $row->ANMName;?></option>
												<?php } ?>
											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group">
									<div class="fg-line">
										<div class="select">
											<h4>ASHA Name</h4>
											<select class="filter-design" data-toggle="dropdown" id="ASHACode" name="ASHACode" >
												<option value="">---select---</option>
												<?php foreach($Asha_list as $row){?>
												<option value="<?php echo $row->ASHACode;?>" <?php echo ($row->ASHACode == trim($this->input->post("ASHACode"))?"selected":"");?>><?php echo $row->ASHAName;?></option>
												<?php } ?>
											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-3">
								<button class="btn btn-info" id="doSearch" name="doSearch" onclick="doSearch()" style="margin-top: 42px;">Apply filters</button>
							</div>
						</div>
					</form>

					<a href="<?php echo site_url('household_report/export_pdf');?>" class="pull-right hvr-pulse-grow" id="btn-Preview-Image" data-toggle="tooltip" title="Export PDF">
						<i class="fa fa-2x fa-file-pdf-o" id="" name="" style="color: #cc3300; cursor: pointer; margin-right: 20px;" onclick="csv()"></i>
					</a>

					<a href="<?php echo site_url('household_report/export_csv');?>" class="pull-right hvr-pulse-grow" id="btn-Preview-Image" data-toggle="tooltip" title="Export Excel">
						<i class="fa fa-2x fa-file-excel-o" id="" name="" style="color: #009999; cursor: pointer; margin-right: 20px;" onclick="csv()"></i>
					</a>
				</div>								

				<table id="data-table-command" class="table table-striped table-vmiddle">
					<thead>
						<tr class="break-row">
							<th data-column-id="HHFamilyMemberGUID" data-visible="false" data-type="numeric">ID</th>
							<th data-column-id="ANMCode" data-sortable="true" data-order="asc">ANM<br> Code</th>
							<th data-column-id="ANMName">ANM Name</th>
							<th data-column-id="no_of_ashas">No. Of ASHA</th>
							<th data-column-id="hh_count">No. Of Household</th>
							<th data-column-id="fm_count">Population</th>
							<th data-column-id="hh_verified">No. of HHVerified</th>
							<th data-column-id="Score">% Of HH Verified</th>
							<th data-column-id="population_verified">Population Verified</th>
							<th data-column-id="percent_population_verified">% Of Population Verified</th>
							<th data-column-id="new_household">New HH Added</th>
							<th data-column-id="commands" data-formatter="commands" data-sortable="false">Details</th>
						</tr>
					</thead>

				</table>
			</div>
		</div>
		<?php } } ?>
	</section>

	<!-- Data Table -->
	<script type="text/javascript">
		var bootgrid;

		$(document).ready(function()
		{

			bootgrid = $("#data-table-command").bootgrid({

				ajax: true,
				url: "<?php echo site_url('Ajax/getHouseHoldReportList');?>",
				post: function ()
				{

					return {
						id: "b0df282a-0d67-40e5-8558-c9e93b7befed",
						StateCode : $('#StateCode').val(), 
						ANMCode : $('#ANMCode').val(),
						ASHACode : $('#ASHACode').val(),
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
					"commands": function(column, row) {
						return  "<a href=\"<?php echo site_url('household_report/ashadetails');?>/" + row.ANMCode + "\" type=\"button\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\"" + row.ANMCode +"\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"\" data-original-title= \"View Activities\"><span class=\"zmdi zmdi-time-countdown\"></span></a>"
						+													

						"<a href=\"<?php echo site_url('household_report/edit');?>/" + row.ANMCode + "\" type=\"button\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\"" + row.ANMCode + "\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"\" data-original-title=\"Edit\"><span class=\"zmdi zmdi-edit\"></span></a>"

						+

						"<a href=\"<?php echo site_url('household_report/delete');?>/" + row.ANMCode + "\" type=\"button\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\"" + row.ANMCode + "\"  data-toggle=\"confirmation\"data-singleton=\"true\" data-placement=\"left\" data-title=\"Proceed to delete?\" ><span class=\"zmdi zmdi-delete\"></span></a>";

					},
				}

			}).on("loaded.rs.jquery.bootgrid", function () {

				if ($('[data-toggle="tooltip"]')[0]) {
					$('[data-toggle="tooltip"]').tooltip();
				}

			});
		});

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

			// $('#ApplyFilter').click(function(){
			// 	bootgrid.reload();
			// });

			function doSearch(){
				$("#data-table-command").bootgrid('reload');
			}
		</script>