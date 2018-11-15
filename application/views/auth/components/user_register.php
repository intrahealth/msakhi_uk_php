<section id="content">

<div class="block-header">
		<h2>User Register</h2><br>
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
	
	<div class="card" style="overflow: scroll; max-height: 80vh;">

				<div class="card-header">
					<h2>User list <small>List of Users </small></h2>

					<a href="<?php echo site_url();?>" class="pull-right hvr-pulse-grow" id="btn-Preview-Image" data-toggle="tooltip" title="Export PDF">
						<i class="fa fa-2x fa-file-pdf-o" id="" name="" style="color: #cc3300; cursor: pointer; margin-right: 20px;" onclick="csv()"></i>
					</a>

					<a href="<?php echo site_url();?>admin/users/register/1" class="pull-right hvr-pulse-grow" id="btn-Preview-Image" data-toggle="tooltip" title="Export Excel">
						<i class="fa fa-2x fa-file-excel-o" id="" name="" style="color: #009999; cursor: pointer; margin-right: 20px;" onclick="csv()"></i>
					</a>

				</div>

				<table id="data-table-command" class="table table-striped table-vmiddle">
					<thead>
						<tr>
							<th data-column-id="SubcenterCode" data-type="numeric" data-order="asc">SubcenterCode</th>
							<th data-column-id="SubcenterName">SubcenterName</th>
							<th data-column-id="ANMUserID">ANMUserID</th>
							<th data-column-id="ANMUserName">ANMUserName</th>
							<th data-column-id="ANMCode">ANMCode</th>
							<th data-column-id="ANMName">ANMName</th>
							<th data-column-id="ANMPhoneNumber">ANMPhoneNumber</th>
							<th data-column-id="ASHAUserID">ASHAUserID</th>
							<th data-column-id="ASHAUserName">ASHAUserName</th>
							<th data-column-id="SupervisorName">SupervisorName</th>
							<th data-column-id="ASHACode">ASHACode</th>
							<th data-column-id="ASHAName">ASHAName</th>
							<th data-column-id="ASHAPhoneNumber">ASHAPhoneNumber</th>
							<th data-column-id="VillageCode">VillageCode</th>
							<th data-column-id="VillageName">VillageName</th>
							<th data-column-id="commands" data-formatter="commands" data-sortable="false">Commands</th>
						</tr>
					</thead>

					<tbody>
						<?php foreach($user_list as $row){ ?>
						<tr>
							<td><?php echo $row->SubcenterCode; ?></td>
							<td><?php echo $row->SubcenterName; ?></td>
							<td><?php echo $row->ANMUserID; ?></td>
							<td><?php echo $row->ANMUserName; ?></td>
							<td><?php echo $row->ANMCode; ?></td>
							<td><?php echo $row->ANMName; ?></td>
							<td><?php echo $row->ANMPhoneNumber; ?></td>
							<td><?php echo $row->ASHAUserID; ?></td>
							<td><?php echo $row->ASHAUserName; ?></td>
							<td><?php echo $row->SupervisorName; ?></td>
							<td><?php echo $row->ASHACode; ?></td>
							<td><?php echo $row->ASHAName; ?></td>
							<td><?php echo $row->ASHAPhoneNumber; ?></td>
							<td><?php echo $row->VillageCode; ?></td>
							<td><?php echo $row->VillageName; ?></td>
						</tr>
						<?php } ?>
					</tbody>

				</table>
			</div>

</section>

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
			return  "<a href=\"<?php echo site_url('anm/edit');?>/" + row.ANMCode + "\" type=\"button\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\"" + row.ANMCode + "\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"\" data-original-title=\"Edit\"><span class=\"zmdi zmdi-edit\"></span></a>"

			+

			"<a href=\"<?php echo site_url('anm/delete');?>/" + row.ANMCode + "\" type=\"button\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\"" + row.ANMCode + "\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"\" data-original-title=\"Delete\"><span class=\"zmdi zmdi-delete\"></span></a>";
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