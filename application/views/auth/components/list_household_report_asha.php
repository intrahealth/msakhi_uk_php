<style>
	
	.btn {
		vertical-align: super;
	}
</style>

<section id="content">

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
					<h2>Asha Household Details <small> Asha Household Details </small></h2>
				</div>

				<div class="card-header">

					<a href="<?php echo site_url('household_report/ashadetails/ANMCode/export_pdf');?>" class="pull-right hvr-pulse-grow" id="btn-Preview-Image" data-toggle="tooltip" title="Export PDF">
						<i class="fa fa-2x fa-file-pdf-o" id="" name="" style="color: #cc3300; cursor: pointer; margin-right: 20px;" onclick="csv()"></i>
					</a>

					<a href="<?php echo site_url('household_report/ashadetails/ANMCode/export_csv');?>" class="pull-right hvr-pulse-grow" id="btn-Preview-Image" data-toggle="tooltip" title="Export Excel">
						<i class="fa fa-2x fa-file-excel-o" id="" name="" style="color: #009999; cursor: pointer; margin-right: 20px;" onclick="csv()"></i>
					</a>
					
				</div>

				<table id="data-table-command" class="table table-striped table-vmiddle">
					<thead>
						<tr>
							<th data-column-id="ANMCode" data-order="asc">ANM Code</th>
							<th data-column-id="ASHAID">Asha Id</th>
							<th data-column-id="ASHAName">Asha Name</th>
							<th data-column-id="hh_count">No. Of Household</th>
							<th data-column-id="fm_count">Population</th>
							<th data-column-id="hh_verified" >No. Of Household Verified</th>
							<th data-column-id="Score">% of Household Verified</th>
							<th data-column-id="population_verified">Population Verified</th>
							<th data-column-id="percent_population_verified">% of Population Verified</th>
							<th data-column-id="new_household">No. of New HH Added</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($Asha_Details as $row){ ?>
						<tr>
							<td><?php echo $row->ANMCode;?></td>
							<td><?php echo $row->ASHAID;?></td>
							<td><?php echo $row->ASHAName;?></td>
							<td><?php echo $row->hh_count;?></td>
							<td><?php echo $row->fm_count;?></td>
							<td><?php echo $row->hh_verified;?></td>
							<td><?php echo $row->Score;?></td>
							<td><?php echo $row->population_verified;?></td>
							<td><?php echo $row->percent_population_verified;?></td>
							<td><?php echo $row->new_household;?></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>

				<div  style="text-align:center;"> 									
					<a href="<?php echo site_url("household_report");?>" class="btn btn-info">Back</a>
				</div>

			</div>
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
            </script>