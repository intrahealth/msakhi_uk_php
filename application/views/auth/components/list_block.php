
<section id="content">
	<?php foreach ($role_permission as $row) { if ($row->Controller == "block" && $row->Action == "index") { ?>
	<div class="block-header">
		<h2>Manage Block</h2><br>
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
					<h2>Block list <small>List of Block </small></h2>
				</div>
				<form action="" method="Post">					
					<div class="row" style="padding-left : 25px;">
						<div class="col-xs-6 col-xs-4">
							<div class="form-group">
								<div class="fg-line">
									<div class="select">
										
										<h4>State Name</h4>
										<?php echo form_error('StateCode'); ?>
										<select class="form-control" data-toggle="dropdown" id="StateCode" name="StateCode" required>
											<option value="">--select--</option>
											<?php foreach($State_List as $row){?>
											<option value="<?php echo $row->StateCode;?>" <?php echo (trim($this->input->post('StateCode')) == $row->StateCode?"selected":"");?>><?php echo $row->StateName;?></option>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>
						</div>

						<div class="col-xs-6 col-xs-4">
							<div class="form-group">
								<div class="fg-line">
									<div class="select">

										<h4>District Name</h4>
										<?php echo form_error('DistrictCode'); ?>
										<select class="form-control" data-toggle="dropdown" id="DistrictCode" name="DistrictCode" required>
											<option value="">---select---</option>
											<?php foreach($District_List as $row){?>
											<option value="<?php echo $row->DistrictCode;?>" <?php echo ($row->DistrictCode == trim($this->input->post("DistrictCode"))?"selected":"");?>><?php echo $row->DistrictName;?></option>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>
						</div>

						<div class="col-md-3">
							<button type="submit" class="btn btn-success waves-effect" style="margin-top : 40px;">GO</button>
						</div>

					</div>
				</form>


			</div>

			<div class="card">													
				<div class="card-header">
					<h2>Block list <small>List of Block </small></h2>

					<?php if($this->input->post('StateCode') != null){ ?>
					<?php foreach ($role_permission as $row) {
						if ($row->Controller == "block" && $row->Action == "add"){ ?>
						<a href="<?php echo site_url("Block/add/?" . http_build_query(array(
						'StateCode'	=>	$this->input->post('StateCode'),
						'DistrictCode'=>	$this->input->post('DistrictCode'),	
						)
						)); ?>" class="btn btn-primary">Add New</a>
						<?php } } ?>

						<?php foreach ($role_permission as $row) { if ($row->Controller == "block" && $row->Action == "Export_pdf") { ?>      
						<a href="<?php echo site_url('block/export_pdf') . "/" . $this->input->post('StateCode') . "/" . $this->input->post('DistrictCode');?>" class="pull-right hvr-pulse-grow" id="btn-Preview-Image" data-toggle="tooltip" title="Export PDF">
							<i class="fa fa-2x fa-file-pdf-o" id="" name="" style="color: #cc3300; cursor: pointer; margin-right: 20px;" onclick="csv()"></i>
						</a>
						<?php } } ?>

						<?php foreach ($role_permission as $row) { if ($row->Controller == "block" && $row->Action == "export_csv") { ?> 
						<a href="<?php echo site_url('block/export_csv') ."/" .$this->input->post('StateCode'). "/" . $this->input->post('DistrictCode');?>" class="pull-right hvr-pulse-grow" id="btn-Preview-Image" data-toggle="tooltip" title="Export Excel">
							<i class="fa fa-2x fa-file-excel-o" id="" name="" style="color: #009999; cursor: pointer; margin-right: 20px;" onclick="csv()"></i>
						</a>
						<?php } } ?>

						<?php } ?>					

					</div>

					<table id="data-table-command" class="table table-striped table-vmiddle">
						<thead>
							<tr>
								<th data-column-id="id" data-type="numeric" data-order="asc">Block ID</th>
								<th data-column-id="StateCode">State Code</th>
								<th data-column-id="DistrictCode">District Code</th>
								<th data-column-id="BlockCode">Block Code</th>
								<th data-column-id="BlockName">Block Name</th>
								<th data-column-id="LanguageID" data-formatter="formatLanguage">Language</th>
								<th data-column-id="commands" data-formatter="commands" data-sortable="false">Commands</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							if(count($Block_List) > 0){
								foreach($Block_List as $row){ ?>
								<tr>
									<td><?php echo $row->BlockID; ?></td>
									<td><?php echo $row->StateCode; ?></td>
									<td><?php echo $row->DistrictCode; ?></td>
									<td><?php echo $row->BlockCode; ?></td>
									<td><?php echo $row->BlockName; ?></td>
									<td><?php echo $row->LanguageID; ?></td>
								</tr>
								<?php } }?>
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
							return  "<?php foreach ($role_permission as $row) { if ($row->Controller == "block" && $row->Action == "edit"){ ?><a href=\"<?php echo site_url('block/edit');?>/" + row.BlockCode + "\" type=\"button\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\"" + row.id + "\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"\" data-original-title=\"Edit\"><span class=\"zmdi zmdi-edit\"></span></a><?php } } ?>"

							+

							"<?php foreach ($role_permission as $row) { if ($row->Controller == "block" && $row->Action == "delete"){ ?><a href=\"<?php echo site_url('block/delete');?>/" + row.BlockCode + "\" type=\"button\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\"" + row.id + "\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"\" data-original-title=\"Delete\"><span class=\"zmdi zmdi-delete\"></span></a><?php } } ?>";
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

					$('#StateCode').change(function(){
						var StateCode = $(this).val();
						$.post('<?php echo site_url('Ajax/getDistrictLists/');?>/'+StateCode, {}, function(raw){
							$('#DistrictCode').html(raw);
						});
					});

				});
			});
		</script>