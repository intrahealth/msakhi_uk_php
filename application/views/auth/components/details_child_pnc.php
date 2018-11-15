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
					<h2>PNC Visits List <small>List of PNC Visits </small></h2>
				</div>
				<div class="table-responsive">
					<table id="data-table-command" class="table table-striped table-vmiddle table table-condensed">
						<thead>
							<tr class="success">
								<th class="text-middle" data-column-id="childGUID" data-visible="false">ID</th>
								<th class="text-middle" data-column-id="PNCGUID" data-visible="false">PNC ID</th>
								<th class="text-middle" data-column-id="VisitNo">Visit No</th>
								<th class="text-middle" data-column-id="Q_0">Visit Date</th>
								<!-- <th class="text-middle" data-column-id="deliveryDateTime">Deleviry date</th> -->
								<th class="text-middle" data-column-id="IsDeleted">Deleted Status</th>
								<th class="text-middle" data-column-id="commands" data-formatter="commands" data-sortable="false">Action</th>
							</tr>
						</thead>

						<tbody>
							<?php foreach($child_list as $row){ ?>
							<tr>
								<td><?php echo $row->childGUID;?></td>
								<td><?php echo $row->PNCGUID;?></td>
								<td><?php echo $row->VisitNo;?></td>
								<td><?php echo $row->Q_0;?></td>
								<!-- <td><?php echo $row->LMPDate;?></td> -->
								<td><?php echo $row->IsDeleted;?></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>

				<div  style="text-align:center;"> 									
					<a href="<?php echo site_url("MNCH/PNCList");?>" class="btn btn-info">Back</a>
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

                	formatters: {

                		"commands": function(column, row)
                		{
                			return"<a href=\"<?php echo site_url('MNCH/delete_pnc_visit');?>/" + row.PNCGUID + "\" type=\"button\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\"" + row.PNCGUID + "\"  data-toggle=\"confirmation\"data-singleton=\"true\" data-placement=\"left\" data-title=\"Proceed to delete?\" ><span class=\"zmdi zmdi-delete\"></span></a>";
                		},


                	}

                }).on("loaded.rs.jquery.bootgrid", function () {
                	/* Executes after data is loaded and rendered */
                	
                	if ($('[data-toggle="tooltip"]')[0]) {
                		$('[data-toggle="tooltip"]').tooltip();
                	}
                	$('[data-toggle=confirmation]').confirmation({
                		rootSelector: '[data-toggle=confirmation]',
                	});
                });
              });
            </script>

            <style>

            .btn {
            	vertical-align: super;
            }
          </style>



