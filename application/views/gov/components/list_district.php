<section id="content">
	<div class="block-header">
		<h2>Manage District</h2><br>

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
			</div>1
			<?php } ?>	

			<div class="card">

				<div class="card-header">
					<h2>District list <small>List of District </small></h2>
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
							<button type="submit" class="btn btn-success waves-effect" style="margin-top : 40px;">GO</button>

						</div>
					</div>
				</form>
			</div>

			<div class="card">													
				<div class="card-header">
					<h2>District list <small>List of District </small></h2>

					<?php if($this->input->post('StateCode') != null){ ?>

					<a href="<?php echo site_url("gov/district/add/?" . http_build_query(array(
					'StateCode'	=>	$this->input->post('StateCode'),
					)
					)); ?>" class="btn btn-primary">Add New</a>

					<a href="<?php echo site_url('gov/district/export_pdf'). "/" . $this->input->post('StateCode');?>" class="pull-right hvr-pulse-grow" id="btn-Preview-Image" data-toggle="tooltip" title="Export PDF">
						<i class="fa fa-2x fa-file-pdf-o" id="" name="" style="color: #cc3300; cursor: pointer; margin-right: 20px;" onclick="csv()"></i>
					</a>

					<a href="<?php echo site_url('gov/district/export_csv'). "/" . $this->input->post('StateCode');?>" class="pull-right hvr-pulse-grow" id="btn-Preview-Image" data-toggle="tooltip" title="Export Excel">
						<i class="fa fa-2x fa-file-excel-o" id="" name="" style="color: #009999; cursor: pointer; margin-right: 20px;" onclick="csv()"></i>
					</a>

					<?php } ?>

				</div>

				<table id="data-table-command" class="table table-striped table-vmiddle">
					
					<thead>
						<tr>
							<th data-column-id="DistrictCode">District Code</th>
							<th data-column-id="DistrictName">District Name</th>
							<th data-column-id="commands" data-formatter="commands" data-sortable="false">Commands</th>
						</tr>
					</thead>

					<tbody>
						<?php foreach($District_list as $row){ ?>
						<tr>
							<td><?php echo $row->DistrictCode; ?></td>
							<td><?php echo $row->DistrictName; ?></td>
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
			return  "<a href=\"<?php echo site_url('gov/district/edit');?>/" + row.DistrictCode + "\" type=\"button\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\"" + row.id + "\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"\" data-original-title=\"Edit\"><span class=\"zmdi zmdi-edit\"></span></a>"

			+

			"<a href=\"<?php echo site_url('gov/district/delete');?>/" + row.DistrictCode + "\" type=\"button\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\"" + row.id + "\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"\" data-original-title=\"Delete\"><span class=\"zmdi zmdi-delete\"></span></a>";
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