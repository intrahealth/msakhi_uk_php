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
<?php foreach ($role_permission as $row) { if ($row->Controller == "track_changes" && $row->Action == "index") { ?>
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
						<h2>Track Changes list <small>List of Track Changes</small></h2>
					</div>	

					<form action="" method="post">
						<div class="row" style="padding-left : 25px;">
							<div class="col-xs-6 col-xs-4">
								<div class="form-group fg-line">
									<div class="select">
										<h4>ASHA Name</h4>
										<select class="form-control" data-toggle="dropdown" id="ASHACode" name="ASHACode" required>
											<option value="">--Select--</option>
											<?php foreach($Asha_List as $row){?>
											<option value="<?php echo $row->ASHACode;?>" <?php echo (trim($this->input->post('ASHACode')) == $row->ASHACode?"selected":"");?>><?php echo $row->ASHAName;?></option>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>

							<div class="col-xs-6 col-xs-4">
								<div class="form-group fg-line">
									<div class="select">
										<h4>Month</h4>
										<select class="form-control" data-toggle="dropdown" id="month" name="month" required>
											<?php echo form_error('month'); ?>
											<option value="">--Select--</option>
											<option value="1" <?php echo (set_value('month') == 1)?"selected":"" ?>>Current Month</option>
											<option value="2" <?php echo (set_value('month') == 2)?"selected":"" ?>>Last 3 Months</option>
										</select>
									</div>
								</div>
							</div>

							<div class="col-xs-2">
								<button class="btn btn-info" id="doSearch" name="doSearch" onclick="doSearch()" style="margin-top : 40px;">Search</button>
							</div>

							<div class="col-xs-2">
								<a href="<?php echo site_url("track_changes");?>" class="btn btn-default" style="margin-top : 40px;">Clear</a>
							</div>

						</div>
					</form>
				</div>



				<div class="card">
					<div class="card-header">
						<h2>Track Changes List <small>List of Track Changes </small></h2>
					</div>

					<div class="card-header">
						
						<?php if($this->input->post('ASHACode') != null){ ?>
						<a href="<?php echo site_url('track_changes/index/export_pdf');?>" class="pull-right hvr-pulse-grow" id="btn-Preview-Image" data-toggle="tooltip" title="Export PDF">
							<i class="fa fa-2x fa-file-pdf-o" id="" name="" style="color: #cc3300; cursor: pointer; margin-right: 20px;" onclick="csv()"></i>
						</a>

						<a href="<?php echo site_url('track_changes/export_csv');?>" class="pull-right hvr-pulse-grow" id="btn-Preview-Image" data-toggle="tooltip" title="Export Excel">
							<i class="fa fa-2x fa-file-excel-o" id="" name="" style="color: #009999; cursor: pointer; margin-right: 20px;" onclick="csv()"></i>
						</a>
						<?php } ?>
					</div>

					<table id="data-table-command" class="table table-striped table-vmiddle">
						<thead>
							<tr>
								<th data-column-id="daterow" data-sortable="true" data-order="desc">Date</th>
								<th data-column-id="household_created">Household/Member</th>
								<th data-column-id="household_uploaded">Household Update/Member Update</th>
								<th data-column-id="preg_woman_registered">Pregnant Woman Register</th>
								<th data-column-id="anc_checkup">ANC CheckUp</th>
								<th data-column-id="anc_visit">ANC Visit</th>
								<th data-column-id="delivery_outcome">Delivery Outcome</th>
								<th data-column-id="hbnc">HBNC</th>
							</tr>
						</thead>

						<tbody>
							<?php foreach($Track_List as $row){ ?>
							<tr>			
								<td><?php echo $row->daterow;?></td>	
								<td><?php echo $row->household_created . ' / ' . $row->familymember_created ;?></td> 
								<td><?php echo $row->household_uploaded. ' / '. $row->familymember_uploaded;?></td>						
								<td><?php echo $row->preg_woman_registered;?></td>						
								<td><?php echo $row->anc_checkup;?></td>	
								<td><?php echo $row->anc_visit;?></td>		
								<td><?php echo $row->delivery_outcome;?></td>			
								<td><?php echo $row->hbnc;?></td>			
							</tr>
							<?php } ?>
						</tbody>

					</table>
				</div>
			</div>
           <?php } } ?>
		</section>

		<!-- Data Table -->
		<script type="text/javascript">

			$(document).ready(function(){
                //Command Buttons
                $("#data-table-command").bootgrid({
                	css: {
                		icon: 'zmdi icon',
                		iconColumns: 'zmdi-view-module',
                		iconDown: 'zmdi-expand-more',
                		iconRefresh: 'zmdi-refresh',
                		iconUp: 'zmdi-expand-less'
                	},
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
				$('#ASHACode').val('');
				$('#month').val('');
				doSearch();
			}

		</script>