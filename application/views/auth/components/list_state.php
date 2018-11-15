<section id="content">
	<?php foreach ($role_permission as $row) { if ($row->Controller == "state" && $row->Action == "index") { ?>
	
	<?php foreach ($role_permission as $row) {
		if ($row->Controller == "state" && $row->Action == "add"){ ?>
		<div class="block-header">
			<h2>Manage State</h2><br>
			<a href="<?php echo site_url("state/add/")?>" class="btn btn-primary">Add New</a>
		</div>
		<?php } } ?>

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
						<h2>State list <small>List of States </small></h2>
						<?php foreach ($role_permission as $row) {
							if ($row->Controller == "state" && $row->Action == "Export_pdf"){ ?>
							<a href="<?php echo site_url('state/index/export_pdf');?>" class="pull-right hvr-pulse-grow" id="btn-Preview-Image" data-toggle="tooltip" title="Export PDF">
								<i class="fa fa-2x fa-file-pdf-o" id="" name="" style="color: #cc3300; cursor: pointer; margin-right: 20px;" onclick="csv()"></i>
							</a>
							 <?php } } ?>
							<?php foreach ($role_permission as $row) {
								if ($row->Controller == "state" && $row->Action == "export_csv"){ ?>
								<a href="<?php echo site_url('state/export_csv');?>" class="pull-right hvr-pulse-grow" id="btn-Preview-Image" data-toggle="tooltip" title="Export Excel">
									<i class="fa fa-2x fa-file-excel-o" id="" name="" style="color: #009999; cursor: pointer; margin-right: 20px;" onclick="csv()"></i>
								</a>
								<?php } } ?>

							</div>

							<table id="data-table-command" class="table table-striped table-vmiddle">
								<thead>
									<tr>
										<!-- <th data-column-id="id" data-type="numeric" data-order="asc">State ID</th> -->
										<th data-column-id="StateCode">State Code</th>
										<th data-column-id="StateName">State Name</th>
										<th data-column-id="commands" data-formatter="commands" data-sortable="false">Commands</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($State_list as $row){ ?>
									<tr>
										<td><?php echo $row->StateCode; ?></td>
										<td><?php echo $row->StateName; ?></td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
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
	formatters: {
		"commands": function(column, row) {
			return  "<?php foreach ($role_permission as $row) { if ($row->Controller == "state" && $row->Action == "edit"){ ?><a href=\"<?php echo site_url('state/edit');?>/" + row.StateCode + "\" type=\"button\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\"" + row.id + "\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"\" data-original-title=\"Edit\"><span class=\"zmdi zmdi-edit\"></span></a><?php } } ?>"
			
			+
			
			"<?php foreach ($role_permission as $row) { if ($row->Controller == "state" && $row->Action == "delete"){ ?><a href=\"<?php echo site_url('state/delete');?>/" + row.StateCode + "\" type=\"button\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\"" + row.id + "\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"\" data-original-title=\"Delete\"><span class=\"zmdi zmdi-delete\"></span></a><?php } } ?>";
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