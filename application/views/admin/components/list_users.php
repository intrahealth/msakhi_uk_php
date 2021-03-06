<section id="content">
	<div class="block-header">
		<h2>Manage Users</h2><br>
		<a href="<?php echo site_url("admin/users/add/")?>" class="btn btn-primary">Add New</a>
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
					<h2>Users list <small>List of Users </small></h2>

					<a href="<?php echo site_url('admin/users/export_pdf');?>" class="pull-right hvr-pulse-grow" id="btn-Preview-Image" data-toggle="tooltip" title="Export PDF">
						<i class="fa fa-2x fa-file-pdf-o" id="" name="" style="color: #cc3300; cursor: pointer; margin-right: 20px;" onclick="csv()"></i>
					</a>

					<a href="<?php echo site_url('admin/users/export_csv');?>" class="pull-right hvr-pulse-grow" id="btn-Preview-Image" data-toggle="tooltip" title="Export Excel">
						<i class="fa fa-2x fa-file-excel-o" id="" name="" style="color: #009999; cursor: pointer; margin-right: 20px;" onclick="csv()"></i>
					</a>

				</div>

				<table id="data-table-command" class="table table-striped table-vmiddle">
					<thead>
						<tr>
							<th data-column-id="user_id" data-type="numeric" data-order="asc">User ID</th>
							<th data-column-id="user_name">User Name</th>
							<th data-column-id="first_name">First Name</th>
							<th data-column-id="last_name">Last  Name</th>
							<th data-column-id="email">Email</th>
							<th data-column-id="user_role" data-formatter="formatUserType">User Role</th>
							<th data-column-id="commands" data-formatter="commands" data-sortable="false">Commands</th>
						</tr>

					</thead>
					<tbody>
						<?php foreach($users_list as $row){ ?>
						<tr>
							<td><?php echo $row->user_id; ?></td>
							<td><?php echo $row->user_name; ?></td>
							<td><?php echo $row->first_name; ?></td>
							<td><?php echo $row->last_name; ?></td>
							<td><?php echo $row->email; ?></td>
							<td><?php echo $row->user_role; ?></td>
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
			return  "<a href=\"<?php echo site_url('admin/users/edit');?>/" + row.user_id + "\" type=\"button\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\"" + row.id + "\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"\" data-original-title=\"Edit\"><span class=\"zmdi zmdi-edit\"></span></a>"

			+

			"<a href=\"<?php echo site_url('admin/users/delete');?>/" + row.user_id + "\" type=\"button\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\"" + row.id + "\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"\" data-original-title=\"Delete\"><span class=\"zmdi zmdi-delete\"></span></a>";
		},
		"formatUserType": function(column, row){

			if(row.user_role == 1){
				user_type = "Admin";
			}
			else if(row.user_role == 6){
				user_type = "State user";
			}

			else if(row.user_role == 7){
				user_type = "District";
			}
			else if(row.user_role == 8){
				user_type = "Block User";
			}
			else{
				user_type = "User ";
			}

			return user_type;
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


