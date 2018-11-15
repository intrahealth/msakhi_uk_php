<section id="content">
	<div class="block-header">
		<h2>Manage Subcenter</h2><br>
		<a href="<?php echo site_url("gov/subcenter/add/")?>" class="btn btn-primary">Add New</a>
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
					<h2>Subcenter list <small>List of Subcenter </small></h2>

					<a href="<?php echo site_url('gov/subcenter/export_pdf');?>" class="pull-right hvr-pulse-grow" id="btn-Preview-Image" data-toggle="tooltip" title="Export PDF">
						<i class="fa fa-2x fa-file-pdf-o" id="" name="" style="color: #cc3300; cursor: pointer; margin-right: 20px;" onclick="csv()"></i>
					</a>

					<a href="<?php echo site_url('gov/subcenter/export_csv');?>" class="pull-right hvr-pulse-grow" id="btn-Preview-Image" data-toggle="tooltip" title="Export Excel">
						<i class="fa fa-2x fa-file-excel-o" id="" name="" style="color: #009999; cursor: pointer; margin-right: 20px;" onclick="csv()"></i>
					</a>

				</div>

				<table id="data-table-command" class="table table-striped table-vmiddle">
					<thead>
						<tr>
							<th data-column-id="id" data-type="numeric" data-order="asc">Subcenter UID</th>
							<th data-column-id="SubCenterID">SubCenter ID</th>
							<th data-column-id="SubCenterCode">SubCenter Code</th>
							<th data-column-id="SubCenterName">SubCenter Name</th>
							<th data-column-id="LanguageID" data-formatter="formatLanguage">Language</th>
							<th data-column-id="commands" data-formatter="commands" data-sortable="false">Commands</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($Subcenter_list as $row){ ?>
						<tr>
							<td><?php echo $row->SubCenterUID; ?></td>
							<td><?php echo $row->SubCenterID; ?></td>
							<td><?php echo $row->SubCenterCode; ?></td>
							<td><?php echo $row->SubCenterName; ?></td>
							<td><?php echo $row->LanguageID; ?></td>
						</tr>
						<?php } ?>
					</tbody>		
				</table>
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
		"commands": function(column, row) {
			return  "<a href=\"<?php echo site_url('gov/subcenter/edit');?>/" + row.SubCenterCode + "\" type=\"button\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\"" + row.id + "\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"\" data-original-title=\"Edit\"><span class=\"zmdi zmdi-edit\"></span></a>"

			+

			"<a href=\"<?php echo site_url('gov/subcenter/delete');?>/" + row.SubCenterCode + "\" type=\"button\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\"" + row.id + "\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"\" data-original-title=\"Delete\"><span class=\"zmdi zmdi-delete\"></span></a>";
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
</script>