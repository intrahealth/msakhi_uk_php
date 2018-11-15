
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
					<h2>Family members list <small>List of family members </small></h2>

					<a href="<?php echo site_url('household/familymembers/export_pdf');?>" class="pull-right hvr-pulse-grow" id="btn-Preview-Image" data-toggle="tooltip" title="Export PDF">
						<i class="fa fa-2x fa-file-pdf-o" id="" name="" style="color: #cc3300; cursor: pointer; margin-right: 20px;" onclick="csv()"></i>
					</a>

					<a href="<?php echo site_url('household/familymembers/export_csv');?>" class="pull-right hvr-pulse-grow" id="btn-Preview-Image" data-toggle="tooltip" title="Export Excel">
						<i class="fa fa-2x fa-file-excel-o" id="" name="" style="color: #009999; cursor: pointer; margin-right: 20px;" onclick="csv()"></i>
					</a>
				</div>

				<div class="table-responsive">
					<table id="data-table-command" class="table table-striped table-vmiddle table table-condensed">
						<thead>
							<tr class="success">
								<th class="text-middle" data-column-id="FamilyCode" data-order="asc">Family Code</th>
								<th class="text-middle" data-column-id="HHFamilyMemberGUID" data-visible="false">Family Member GUID</th>
								<th class="text-middle" data-column-id="FamilyMemberName">HH Member Name</th>
								<th class="text-middle" class="text-middle" data-column-id="GenderID">Gender</th>
								<th class="text-middle" data-column-id="MaritialStatusID">Maritial Status ID</th>
								<th class="text-middle" data-column-id="AprilAgeYear">Age Year</th>
								<th class="text-middle" data-column-id="AprilAgeMonth">Age Month</th>
								<th>Deleted Status</th>
								<th class="text-middle" data-column-id="commands" data-formatter="commands" data-sortable="false">Member Details</th>
							</tr>
						</thead>

						<tbody>
							<?php foreach($Familymembers_list as $row){ ?>
							<tr>
								<td><?php echo $row->HHFamilyMemberCode;?></td>
								<td><?php echo $row->HHFamilyMemberGUID; ?></td>
								<td><?php echo $row->FamilyMemberName; ?></td>
								<td><?php echo $row->GenderID;?></td>
								<td><?php echo $row->MaritialStatusID; ?></td>
								<td><?php echo $row->AprilAgeYear;?></td>
								<td><?php echo $row->AprilAgeMonth;?></td>
								<td><?php echo $row->Deleted;?></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
 <div  style="text-align:center;"> 									
 	<a href="<?php echo site_url("Household");?>" class="btn btn-info">Back</a>
				</div>

			</div>
		</section>

		<!-- Data Table -->
		<script type="text/javascript">
			$(document).ready(function(){
                //Command Buttons
                $("#data-table-command").bootgrid({

                	caseSensitive: false,
                	
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
                			return "<a href=\"<?php echo site_url('Household/edit_family_members');?>/" + row.HHFamilyMemberGUID + "\" type=\"button\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\"" + row.HHFamilyMemberGUID + "\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"\" data-original-title=\"Edit\"><span class=\"zmdi zmdi-edit\"></span></a>"

                			+

                			"<a href=\"<?php echo site_url('Household/delete_family_member');?>/" + row.HHFamilyMemberGUID + "\" type=\"button\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\"" + row.HHFamilyMemberGUID + "\"  data-toggle=\"confirmation\"data-singleton=\"true\" data-placement=\"left\" data-title=\"Proceed to delete?\" ><span class=\"zmdi zmdi-delete\"></span></a>";
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

			function deleteAlert() {
				return confirm("Do you want to delete this opportunity ?");
			}
		</script>