<section id="content">
	<div class="container">
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
						<h2>Household list <small>List of Household </small></h2>
					</div>

					<div class="row" style="padding-left : 25px;">
						<div class="col-xs-4 col-xs-2">
							<div class="form-group fg-line">
								<div class="select">
									<h4>ANM Name</h4>
									<select class="form-control" data-toggle="dropdown" id="ANMCode" name="ANMCode" required>
										<option value="">--select--</option>
										<?php foreach($Anm_List as $row){?>
										<option value="<?php echo $row->ANMCode;?>" <?php echo (trim($this->input->post('ANMCode')) == $row->ANMCode?"selected":"");?>><?php echo $row->ANMName;?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>

						<div class="col-xs-4 col-xs-2">
							<div class="form-group fg-line">
								<div class="select">
									<h4>ASHA Name</h4>
									<select class="form-control" data-toggle="dropdown" id="ASHACode" name="ASHACode" required>
										<option value="">--select--</option>
										<?php foreach($Asha_List as $row){?>
										<option value="<?php echo $row->ASHACode;?>" <?php echo (trim($this->input->post('ASHACode')) == $row->ASHACode?"selected":"");?>><?php echo $row->ASHAName;?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>

						<div class="col-xs-4 col-xs-2">
							<div class="form-group fg-line">
								<div class="select">
									<h4>Verified</h4>
									<select class="form-control" data-toggle="dropdown" id="Verified" name="Verified" required>
										<option value="">--select--</option>
										<option value="1">All</option>
										<option value="2">Yes</option>
										<option value="3">No</option>
									</select>
								</div>
							</div>
						</div>

						<div class="col-xs-2">
							<button class="btn btn-info" id="doSearch" name="doSearch" onclick="doSearch()" style="margin-top : 40px;">Search</button>
						</div>

						<div class="col-xs-2">
							<button class="btn btn-default" id="clearFilters" name="clearFilters" onclick="clearFilters()" style="margin-top : 40px;">Clear</button>
						</div>
					</div>
				</div>


				<div class="card">
					<div class="card-header">
						<h2>Household list<small>List of Household</small></h2>

							<a href="<?php echo site_url('gov/household/export_pdf');?>" class="pull-right hvr-pulse-grow" id="btn-Preview-Image" data-toggle="tooltip" title="Export PDF">
							<i class="fa fa-2x fa-file-pdf-o" id="" name="" style="color: #cc3300; cursor: pointer; margin-right: 20px;" onclick="csv()"></i>
						</a>

						<a href="<?php echo site_url('gov/household/export_csv');?>" class="pull-right hvr-pulse-grow" id="btn-Preview-Image" data-toggle="tooltip" title="Export Excel">
							<i class="fa fa-2x fa-file-excel-o" id="" name="" style="color: #009999; cursor: pointer; margin-right: 20px;" onclick="csv()"></i>
						</a>
					</div>

					<table id="data-table-command" class="table table-striped table-vmiddle">
						<thead>
							<tr>
								<th data-column-id="HHSurveyGUID" data-visible="false" data-type="numeric" data-order="asc">ID</th>
								<th data-column-id="SubCenterName">Sub Center Name</th>
								<th data-column-id="ANMName">ANM Name</th>
								<th data-column-id="ASHAName">ASHA Name</th>
								<th data-column-id="VillageName">Village Name</th>
								<th data-column-id="FamilyCode">Family Code</th>
								<!-- <th data-column-id="FamilyMemberName">HH Head</th> -->
								<th data-column-id="caste">Caste</th>
								<th data-column-id="Verified">Verify</th>
								<th data-column-id="FinancialStatusID">Financial Status ID</th>
								<th data-column-id="commands" data-formatter="commands" data-sortable="false">Member Details</th>
							</tr>
						</thead>

					</table>
				</div>
			</div>
		</section>

		<!-- Data Table -->
		<script type="text/javascript">
			$(document).ready(function()
			{

				$('#ANMCode').change(function(){
					var ANMCode = $(this).val();
					$.post('<?php echo site_url('gov/Ajax/getAshaOfAnmViaAnmCode');?>/'+ANMCode, {}, function(raw){
						$('#ASHACode').html(raw);
					});
				});

				bindBootgrid();

			});

			function bindBootgrid()
			{
				$("#data-table-command").bootgrid('destroy').bootgrid({

					ajax: true,
					url: "<?php echo site_url("gov/Ajax/getHouseHoldList");?>"	,
					post: function ()
					{

						return {
							id: "b0df282a-0d67-40e5-8558-c9e93b7befed",
							filterANMCode:	$('#ANMCode').val(),
							filterASHACode:	$('#ASHACode').val(),
							filterVerified: $('#Verified').val(),

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
							return  "<a href=\"<?php echo site_url('gov/Household/familymembers');?>/" + row.HHSurveyGUID + "\" type=\"button\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\"" + row.id +"\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"\" data-original-title= \"View Activities\"><span class=\"zmdi zmdi-view-list\"></span></a>"
						}


					}

				}).on("loaded.rs.jquery.bootgrid", function () {

					if ($('[data-toggle="tooltip"]')[0]) {
						$('[data-toggle="tooltip"]').tooltip();
					}

					
				});
			}

			function doSearch()
			{
				$("#data-table-command").bootgrid('reload');
			}

			function clearFilters(){
				$('#ANMCode').val('');
				$('#ASHACode').val('');
				$('#Verified').val('');
				doSearch();
			}

		</script>