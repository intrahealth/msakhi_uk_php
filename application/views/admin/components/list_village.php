<section id="content">
	<div class="block-header">
		<h2>Manage Village</h2><br>
		
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
					<h2>Village list <small>List of Village </small></h2>
				</div>
				
				<form action="" method="post">
					
					<div class="row" style="padding-left : 25px;">
						<div class="col-xs-6 col-xs-4">
							<div class="form-group fg-line select">
								
								<h4>State Name</h4>
								<select class="form-control" data-toggle="dropdown" id="StateCode" name="StateCode" required>
									<option value="">--select--</option>
									<?php foreach($State_List as $row){?>
									<option value="<?php echo $row->StateCode;?>" <?php echo (trim($this->input->post('StateCode')) == $row->StateCode?"selected":"");?>><?php echo $row->StateName;?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						
						
						<div class="col-xs-6 col-xs-4">
							<div class="form-group">
								<div class="fg-line">
									<div class="select">
										
										<h4>District Name</h4>
										<select class="form-control" data-toggle="dropdown" id="DistrictCode" name="DistrictCode" >
											<option value="">---select---</option>
											<?php foreach($District_List as $row){?>
											<option value="<?php echo $row->DistrictCode;?>" <?php echo ($row->DistrictCode == trim($this->input->post("DistrictCode"))?"selected":"");?>><?php echo $row->DistrictName;?></option>
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
										
										<h4>Block Name</h4>
										<select class="form-control" data-toggle="dropdown" id="BlockCode" name="BlockCode" >
											<option value="">---select---</option>
											<?php foreach($Block_List as $row){?>
											<option value="<?php echo $row->BlockCode;?>" <?php echo ($row->BlockCode == trim($this->input->post("BlockCode"))?"selected":"");?>><?php echo $row->BlockName;?></option>
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

										<h4>Panchayat Name</h4>
										<select class="form-control" data-toggle="dropdown" id="PanchayatCode" name="PanchayatCode" >
											<option value="">---select---</option>
											<?php foreach($Panchayat_List as $row){?>
											<option value="<?php echo $row->PanchayatCode;?>" <?php echo ($row->PanchayatCode == trim($this->input->post("PanchayatCode"))?"selected":"");?>><?php echo $row->PanchayatName;?></option>
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

					<?php if($this->input->post('StateCode') != null){ ?>

					<a href="<?php echo site_url("admin/Village/add/?" . http_build_query(array(
					'StateCode'	=>	$this->input->post('StateCode'),
					'DistrictCode'=>	$this->input->post('DistrictCode'),
					'BlockCode'=> $this->input->post('BlockCode'),
					'PanchayatCode'=> $this->input->post('PanchayatCode'),
					)
					)); ?>" class="btn btn-primary">Add New</a>

					<a href="<?php echo site_url('admin/village/export_pdf') . "/" . $this->input->post('StateCode') . "/" . $this->input->post('DistrictCode') . "/" . $this->input->post('BlockCode') ."/" . $this->input->post('PanchayatCode');?>" class="pull-right hvr-pulse-grow" id="btn-Preview-Image" data-toggle="tooltip" title="Export PDF">
						<i class="fa fa-2x fa-file-pdf-o" id="" name="" style="color: #cc3300; cursor: pointer; margin-right: 20px;" onclick="csv()"></i>
					</a>

					<a href="<?php echo site_url('admin/village/export_csv') ."/" .$this->input->post('StateCode'). "/" . $this->input->post('DistrictCode') ."/" .$this->input->post('BlockCode') ."/" . $this->input->post('PanchayatCode');?>" class="pull-right hvr-pulse-grow" id="btn-Preview-Image" data-toggle="tooltip" title="Export Excel">
						<i class="fa fa-2x fa-file-excel-o" id="" name="" style="color: #009999; cursor: pointer; margin-right: 20px;" onclick="csv()"></i>
					</a>

					<?php } ?>
					
				</div>
				
				<div class="card">
					<div class="card-header">
						<h2>Village list <small>List of Village </small></h2>
					</div>
					
					<table id="data-table-command" class="table table-striped table-vmiddle">
						<thead>
							<tr>
								<th data-column-id="VillageID">Village ID</th>
								<th data-column-id="VillageCode">Village Code</th>
								<th data-column-id="VillageName">Village Name</th>
								<th data-column-id="commands" data-formatter="commands" data-sortable="false">Commands</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($Village_List as $row){ ?>
							<tr>
								<td><?php echo $row->VillageID ?></td>
								<td><?php echo $row->VillageCode ?></td>
								<td><?php echo $row->VillageName ?></td>
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
                			return  "<a href=\"<?php echo site_url('admin/village/edit');?>/" + row.VillageCode + "\" type=\"button\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\"" + row.id + "\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"\" data-original-title=\"Edit\"><span class=\"zmdi zmdi-edit\"></span></a>"
                			
                			+
                			
                			"<a href=\"<?php echo site_url('admin/village/delete/');?>/" + row.VillageCode + "\" type=\"button\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\"" + row.id + "\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"\" data-original-title=\"Delete\"><span class=\"zmdi zmdi-delete\"></span></a>";
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
                		$.post('<?php echo site_url('admin/Ajax/getDistrictLists/');?>/'+StateCode, {}, function(raw){
                			$('#DistrictCode').html(raw);
                		});
                	});
                	
                	$('#DistrictCode').change(function(){
                		var DistrictCode = $(this).val();
                		$.post('<?php echo site_url('admin/Ajax/getBlockLists/');?>/'+DistrictCode, {}, function(raw){
                			$('#BlockCode').html(raw);
                		});
                		
                	});
                	
                	$('#BlockCode').change(function(){
                		var BlockCode = $(this).val();
                		$.post('<?php echo site_url('admin/Ajax/getPanchayatLists/');?>/'+BlockCode, {}, function(raw){
                			$('#PanchayatCode').html(raw);
                		});
                		
                	});
                	
                });
              });
            </script>