<!-- <style>
	.bootgrid-table th>.column-header-anchor>.text {
		display: block;
		margin: 0 16px 0 0;
		/* overflow: auto !important; */
		-ms-text-overflow: ellipsis;
		-o-text-overflow: ellipsis;
		text-overflow: ellipsis;
		white-space: pre-wrap !important;
	}
}
</style> -->

<section id="content">
<?php foreach ($role_permission as $row) { if ($row->Controller == "af_module" && $row->Action == "index") { ?>
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
						<h2>AF Module</h2>
					</div>
					<form action="<?php echo site_url("af_module/?". $this->input->get('SubCenterCode'));?>" method="get">
						<div class="row" style="padding-left : 15px;">

						<div class="col-sm-3 form-group fg-line">
								<label for="date">Select State</label><br>
								<select class="form-control" data-toggle="dropdown" id="StateCode" name="StateCode" required>
											<option value="">--select--</option>
											<?php foreach($State_List as $row){?>
											<option value="<?php echo $row->StateCode;?>" <?php echo (trim($this->input->post('StateCode')) == $row->StateCode?"selected":"");?>><?php echo $row->StateName;?></option>
											<?php } ?>
										</select>
							</div>


							<div class="col-sm-3 form-group fg-line">
								<label for="date">Sub Centre</label><br>
								<select class="form-control" data-toggle="dropdown" id="SubCenterCode" name="SubCenterCode" required>
									<option value="">--select--</option>
									<?php foreach($Subcentre_list as $row){?>
									<option value="<?= $row->SubCenterCode?>" <?php if(isset($_GET['SubCenterCode'])){echo ($_GET['SubCenterCode'] == $row->SubCenterCode)?"selected":"";}?>><?php echo $row->SubCenterName;?></option>
									<?php } ?>
								</select>
							</div>

							<div class="col-xs-2">
								<button class="btn btn-info" id="doSearch" name="doSearch" onclick="doSearch()" style="margin-top : 25px;">Search</button>
							</div>

							<div class="col-xs-2">
								<a href="<?php echo site_url("af_module");?>" class="btn btn-default" style="margin-top : 25px;">Clear</a>
							</div>

						</div>
					</form>
				</div>

				<div class="card">

					<div class="card-header">
						<h2>Af Module list <small>List of Af Module </small></h2>
						<?php if(isset($_GET['SubCenterCode'])){ ?>
						<a href="<?php echo site_url("af_module/add/" . $_GET['SubCenterCode'])?>" class="btn btn-primary">Add New</a>
						<?php } ?>

						<a href="<?php echo site_url('af_module/index/export_pdf') . "/" . $this->input->post('SubCenterCode');?>" class="pull-right hvr-pulse-grow" id="btn-Preview-Image" data-toggle="tooltip" title="Export PDF">
							<i class="fa fa-2x fa-file-pdf-o" id="" name="" style="color: #cc3300; cursor: pointer; margin-right: 20px;" onclick="csv()"></i>
						</a>

						<a href="javascript:export_excel();" class="pull-right hvr-pulse-grow" id="btn-Preview-Image" data-toggle="tooltip" title="Export Excel">
							<i class="fa fa-2x fa-file-excel-o" id="" name="" style="color: #009999; cursor: pointer; margin-right: 20px;" onclick="csv()"></i>
						</a>

					</div>
						
						<div class="table-responsive">
					<table id="data-table-command" class="table table-striped table-vmiddle">
						<thead>
							<tr class="break-row">
								<!-- 				<th data-column-id="CHS_ID" data-sortable="true" data-order="asc">ID</th> -->
								<th data-column-id="SupervisorCode">Supervisor Code </th>
								<th data-column-id="SupervisorName">Supervisor Name	</th>
								<th data-column-id="commands" data-formatter="commands" data-sortable="false">Commands</th>
							</tr>
						</thead>

						<tbody>

							<?php
							if(count($Af_Module_List) > 0){
								foreach($Af_Module_List as $row){ ?>
								<tr>
									<td><?php echo $row->SupervisorCode; ?></td>
									<td><?php echo $row->SupervisorName; ?></td>
								</tr>
								<?php } }?>
							</tbody>
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

					$("#data-table-command").bootgrid({
						css: {
							icon: 'zmdi icon',
							iconColumns: 'zmdi-view-module',
							iconDown: 'zmdi-expand-more',
							iconRefresh: 'zmdi-refresh',
							iconUp: 'zmdi-expand-less'
						},
						formatters: {
							"commands": function(column, row) {
								return  "<a href=\"<?php echo site_url('af_module/edit');?>/" + row.SupervisorCode + "\" type=\"button\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\"" + row.id + "\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"\" data-original-title=\"Edit\"><span class=\"zmdi zmdi-edit\"></span></a>"

								+

								"<a href=\"<?php echo site_url('af_module/delete');?>/" + row.SupervisorCode + "\" type=\"button\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\"" + row.id + "\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"\" data-original-title=\"Delete\"><span class=\"zmdi zmdi-delete\"></span></a>";
							},

							"formatLanguage": function(column, row){

								if(row.LanguageID == 1){
									language = "English";
								}else{
									language = "हिंदी ";
								}

								return language;
							}

						}
					}).on("loaded.rs.jquery.bootgrid", function () {
						/* Executes after data is loaded and rendered */
						if ($('[data-toggle="tooltip"]')[0]) {
							$('[data-toggle="tooltip"]').tooltip();
						}
					});
				});
				function doSearch(){
					$("#data-table-command").bootgrid('reload');
				}

				function clearFilters(){
					$('#SubCenterCode').val('');
					doSearch();
				}

				function export_excel() {
					$("#data-table-command").tableToCSV();
				}
				
				// get state 
   $('#StateCode').change(function(){
						var StateCode = $(this).val();
						$.post('<?php echo site_url('Ajax/mstsubcenter/');?>/'+StateCode, {}, function(raw){
							$('#SubCenterCode').html(raw);
						});
					});

			</script>