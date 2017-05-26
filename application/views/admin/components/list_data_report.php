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
}
</style>

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
						<h2>Data Report List <small>List of Data Report </small></h2>

						<a href="<?php echo site_url('admin/data_report/export_pdf');?>" class="pull-right hvr-pulse-grow" id="btn-Preview-Image" data-toggle="tooltip" title="Export PDF">
							<i class="fa fa-2x fa-file-pdf-o" id="" name="" style="color: #cc3300; cursor: pointer; margin-right: 20px;" onclick="csv()"></i>
						</a>

						<a href="<?php echo site_url('admin/data_report/export_csv');?>" class="pull-right hvr-pulse-grow" id="btn-Preview-Image" data-toggle="tooltip" title="Export Excel">
							<i class="fa fa-2x fa-file-excel-o" id="" name="" style="color: #009999; cursor: pointer; margin-right: 20px;" onclick="csv()"></i>
						</a>

					</div>
					
					<table id="data-table-command" class="table table-striped table-vmiddle">
						<thead>
							<tr class="break-row">
								<th data-column-id="ASHAID" data-sortable="true" data-order="asc">ID</th>
								<th data-column-id="ASHAName">ASHA Name</th>
								<th data-column-id="SubCenterName">Sub Center Name</th>
								<th data-column-id="user_name">User Id</th>
								<th data-column-id="">Month</th>
								<th data-column-id="hh_updated">HH Data Updated</th>
								<th data-column-id="pregnancies">Pregnancies</th>
								<th data-column-id="anc_visits">ANCs</th>
								<th data-column-id="child_births">Deliveries</th>
								<th data-column-id="pnc_visits">PNCs</th>
								<th data-column-is="immunizationANS">Immunizations</th>								
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

				$("#data-table-command").bootgrid({

					ajax: true,
					url: "<?php echo site_url("admin/Ajax/getDataReportList");?>"	,
					post: function ()
					{

						return {
							id: "b0df282a-0d67-40e5-8558-c9e93b7befed",
							
						};
					},
					css: {
						icon: 'zmdi icon',
						iconColumns: 'zmdi-view-module',
						iconDown: 'zmdi-expand-more',
						iconRefresh: 'zmdi-refresh',
						iconUp: 'zmdi-expand-less'
					},


				}).on("loaded.rs.jquery.bootgrid", function () {

					if ($('[data-toggle="tooltip"]')[0]) {
						$('[data-toggle="tooltip"]').tooltip();
					}
					
				});
			});
			
		</script>