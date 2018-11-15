<section id="content">
	<!-- Start Role Permission view code -->
	<?php foreach ($role_permission as $row) { if ($row->Controller == "anm" && $row->Action == "index"){ 

		if (!$row->Action == "index") {
			redirect('dashboard');
		}
		?>

		
		<div class="block-header">
			<h2>Manage ANM</h2><br>
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
						<h2>Anm list <small>List of Anm </small></h2>
					</div>
					<form action="" method="post">
						<div class="row" style="padding-left : 25px;">
							<div class="col-xs-6 col-xs-4">
								<div class="form-group">
									<div class="fg-line">
										<div class="select">
											<h4>State Name</h4>
											<select class="form-control" data-toggle="dropdown" id="StateCode" name="StateCode" required>
												<option value="">--select--</option>
												<?php foreach($State_list as $row){?>
												<option value="<?php echo $row->StateCode;?>" <?php echo (trim($this->input->post('StateCode')) == $row->StateCode?"selected":"");?>><?php echo $row->StateName;?></option>
												<?php } ?>
											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<button type="submit" class="btn btn-primary waves-effect" style="margin-top : 40px;">Filter</button>
							</div>
						</div>
					</form>
				</div>

				<div class="card">
					<div class="card-header">
						<h2>ANM list <small>List of ANM </small></h2>
						<?php foreach ($role_permission as $row) { if ($row->Controller == "anm" && $row->Action == "add"){ ?>
						<a href="<?php echo site_url("anm/add/")?>" class="btn btn-primary">Add New</a>
						<?php } } ?>
						<?php foreach ($role_permission as $row) {
							if ($row->Controller == "anm" && $row->Action == "Export_pdf"){ ?>
							<a href="<?php echo site_url('anm/index/export_pdf');?>" class="pull-right hvr-pulse-grow" id="btn-Preview-Image" data-toggle="tooltip" title="Export PDF">
								<i class="fa fa-2x fa-file-pdf-o" id="" name="" style="color: #cc3300; cursor: pointer; margin-right: 20px;" onclick="csv()"></i>
							</a>
							<?php } } ?>

							<?php foreach ($role_permission as $row) {
								if ($row->Controller == "anm" && $row->Action == "export_csv"){ ?>
								<a href="<?php echo site_url('anm/export_csv');?>" class="pull-right hvr-pulse-grow" id="btn-Preview-Image" data-toggle="tooltip" title="Export Excel">
									<i class="fa fa-2x fa-file-excel-o" id="" name="" style="color: #009999; cursor: pointer; margin-right: 20px;" onclick="csv()"></i>
								</a>
								<?php } }?>

							</div>

							<table id="data-table-command" class="table table-striped table-vmiddle">
								<thead>
									<tr>
										<th data-column-id="ANMUID" data-visible="false">ID</th>
										<th data-column-id="ANMCode" data-type="numeric" data-order="asc">ANMCode</th>
										<th data-column-id="ANMName">ANM Name</th>
										<th data-column-id="user_name">User Name</th>
										<!-- <th data-column-id="IsActive"  data-formatter="IsActive">Active</th> -->
										<th data-column-id="commands" data-formatter="commands" data-sortable="false">Commands</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($anm_list as $row){ ?>
									<tr>
										<td><?php echo $row->ANMUID; ?></td>
										<td><?php echo $row->ANMCode; ?></td>
										<td><?php echo $row->ANMName; ?></td>
										<td><?php echo $row->user_name; ?></td>
										<!-- <td><?php //echo $row->IsActive; ?></td> -->
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
						<?php } }
				// {
				// 	echo "<h2 style='color:#fff'>This is not access ANM / permission denied. Please contact your system administrator.</h2>";
				// }                 
						?>

						<!-- end role permission view code -->
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
			return  "<?php foreach ($role_permission as $row) { if ($row->Controller == "anm" && $row->Action == "edit"){ ?><a href=\"<?php echo site_url('anm/edit');?>/" + row.ANMUID + "\" type=\"button\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\"" + row.ANMUID + "\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"\" data-original-title=\"Edit\"><span class=\"zmdi zmdi-edit\"></span></a> <?php } } ?>"
			+

			"<?php foreach ($role_permission as $row) { if ($row->Controller == "anm" && $row->Action == "delete"){ ?><a href=\"<?php echo site_url('anm/delete');?>/" + row.ANMCode + "\" type=\"button\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\"" + row.ANMCode + "\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"\" data-original-title=\"Delete\"><span class=\"zmdi zmdi-delete\"></span></a><?php } } ?>";
		},
		"formatLanguage": function(column, row){

			if(row.LanguageID == 1){
				language = "English";
			}else{
				language = "हिंदी ";
			}

			return language;
		},


		"IsActive": function(column, row){


			if(row.IsActive == 0){
				var formatter = "<span>No</span>";
			}else{
			// var formatter = $(this).closest('tr').addClass( 'success' );
			var formatter = "<span>Yes</span>";
		}
		return formatter;
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