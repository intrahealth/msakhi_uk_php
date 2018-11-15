<section id="content">
	<?php foreach ($role_permission as $row) { if($row->Controller == "MNCH" && $row->Action == "index") { ?>
	<div class="container" style="width: 1070px;">
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
						<h2>Delivery List <small>List of Non Pregnent Women </small></h2>
					</div>


					<div class="row" style="padding-left : 15px;">
						<div class="col-lg-2">
							<div class="form-group fg-line">
								<div class="select">
									<h5>State Name</h5>
									<?php echo form_error('StateCode'); ?>
									<select class="form-control" data-toggle="dropdown" id="StateCode" name="StateCode"  style="width: 75%">
										<option value="">--select--</option>
										<?php foreach($State_List as $row){?>
										<option value="<?php echo $row->StateCode;?>" <?php echo (trim($this->input->post('StateCode')) == $row->StateCode?"selected":"");?>><?php echo $row->StateName;?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>

						<div class="col-lg-2">
							<div class="form-group fg-line">
								<div class="select">
									<h5>ANM Name</h5>
									<?php echo form_error('ANMID'); ?>
									<select class="form-control" data-toggle="dropdown" id="ANMID" name="ANMID"  style="width: 75%">
										<option value="">--select--</option>
										<?php foreach($Anm_list as $row){?>
										<option value="<?php echo $row->ANMID;?>" <?php echo (trim($this->input->post('ANMID')) == $row->ANMID?"selected":"");?>><?php echo $row->ANMName. '('.$row->user_name.')';?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>

						<div class="col-lg-2">
							<div class="form-group fg-line">
								<div class="select">
									<h5>ASHA Name</h5>
									<?php echo form_error('ASHAID'); ?>
									<select class="form-control" data-toggle="dropdown" id="ASHAID" name="ASHAID"  style="width: 75%">
										<option value="">--select--</option>
										<?php foreach($Asha_list as $row){?>
										<option value="<?php echo $row->ASHAID;?>" <?php echo (trim($this->input->post('ASHAID')) == $row->ASHAID?"selected":"");?>><?php echo $row->ASHAName. '('.$row->user_name.')';?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>

						<div class="col-lg-2">
							<div class="form-group fg-line">
								<div class="select">
									<h5>Village Name</h5>
									<?php echo form_error('VillageCode'); ?>
									<select class="form-control" data-toggle="dropdown" id="VillageCode" name="VillageCode"  style="width: 75%">
										<option value="">--select--</option>
										<?php foreach($Village_list as $row){?>
										<option value="<?php echo $row->VillageCode;?>" <?php echo (trim($this->input->post('VillageCode')) == $row->VillageCode?"selected":"");?>><?php echo $row->VillageName;?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>

						<div class="col-lg-1">
							<div class="form-group fg-line">
								<h5>Deleted</h5>
								<?php echo form_error('IsDeleted'); ?>
								<select class="form-control" data-toggle="dropdown" id="IsDeleted" name="IsDeleted" style="width: 100%">
									<option value="">select</option>
									<option value="1">Yes</option>
									<option value="2">No</option>
								</select>							
							</div>
						</div>





						<div style="text-align:center;">
							<a type="submit" class="btn btn-info" onclick="doSearch()" style="margin-top : 20px;">Apply filters</a>
							
							&nbsp &nbsp

							<a class="btn btn-default" id="clearFilters" name="clearFilters" onclick="clearFilters()" style="margin-top : 20px;">Clear</a>
						</div>
					</div>

				</form>
			</div>
			<div class="card">
				<div class="card-header">
					<h2>Delivery List<small>List of Non Pregnent Women</small></h2>
					<?php foreach ($role_permission as $row) { if ($row->Controller == "MNCH" && $row->Action == "Export_pdf") { ?>
					<a href="<?php echo site_url('MNCH/export_pdf');?>" class="pull-right hvr-pulse-grow" id="btn-Preview-Image" data-toggle="tooltip" title="Export PDF">
						<i class="fa fa-2x fa-file-pdf-o" id="" name="" style="color: #cc3300; cursor: pointer; margin-right: 20px;" onclick="csv()"></i>
					</a>
					<?php } } ?>
					<?php foreach ($role_permission as $row) { if ($row->Controller == "MNCH" && $row->Action == "export_csv") { ?>
					<a href="<?php echo site_url('MNCH/export_csv');?>" class="pull-right hvr-pulse-grow" id="btn-Preview-Image" data-toggle="tooltip" title="Export Excel">
						<i class="fa fa-2x fa-file-excel-o" id="clearFilters" name="clearFilters" style="color: #009999; cursor: pointer; margin-right: 20px;" onclick="csv()"></i>
					</a>
					<?php } } ?>

				</div>
				<div class="table-responsive">
					<table id="data-table-command" class="table table-striped table-vmiddle table table-condensed">
						<thead>
							<tr class="success">
								<th class="text-middle" data-column-id="HHSurveyGUID" data-visible="false">ID</th>
								<th class="text-middle" data-column-id="PWGUID" data-visible="false">ID</th>
								<!-- <th class="text-middle" data-column-id="ANMName">ANM Name</th> -->
								<th class="text-middle" data-column-id="ANMName">ANM Name</th>
								<th class="text-middle" data-column-id="ASHAName">ASHA Name</th>
								<th class="text-middle" data-column-id="VillageName">Village Name</th>
								
								<th class="text-middle" class="text-middle" data-column-id="PWName">Mother Name</th>
								<th class="text-middle" data-column-id="FamilyMemberName">Husband Name</th>
								<th class="text-middle" data-column-id="HHCode">HH Code</th>
								<!-- <th class="text-middle" data-column-id="LMPDate">LMP Date</th> -->
								<th class="text-middle" data-column-id="DeliveryDateTime">Delivery Date</th>
								<!-- <th class="text-middle" data-column-id="DeliveryType">Delivery Type</th> -->
								<th class="text-middle" data-column-id="IsDeleted" data-formatter="IsDeleted">Deleted Status</th>
								<th class="text-middle" data-column-id="commands" data-formatter="commands" data-sortable="false">Commands</th>
							</tr>
						</thead>

					</table>
				</div>
			</div>
		</div>
		<?php } } ?>
	</section>

	<!-- Data Table -->
	<script type="text/javascript">
		$(document).ready(function()
		{
			
			bindBootgrid();
		});

		function bindBootgrid()
		{
			$("#data-table-command").bootgrid('destroy').bootgrid({

				caseSensitive: false,

				ajax: true,
				url: "<?php echo site_url("MNCH/getPNCList");?>",
				post: function ()
				{

					return {
						id: "b0df282a-0d67-40e5-8558-c9e93b7befed",
							// filterStateCode:	$('#StateCode').val(),
							// filterANMCode:	$('#ANMCode').val(),
							// filterASHACode:	$('#ASHACode').val(),
							// filterVerified: $('#Verified').val(),

							StateCode : $('#StateCode').val(), 
							ANMID : $('#ANMID').val(),
							ASHAID : $('#ASHAID').val(),
							VillageCode : $('#VillageCode').val(),
							IsDeleted : $('#IsDeleted').val()
						};
					},
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
							return  "<a href=\"<?php echo site_url('MNCH/child_details');?>/" + row.pwGUID + "\" type=\"button\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\"" + row.pwGUID +"\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"\" data-original-title= \"View Child\"><span class=\"zmdi zmdi-view-list\"></span></a>"
							+
							"<a href=\"<?php echo site_url('MNCH/edit_non_preg_woman');?>/" + row.pwGUID + "\" type=\"button\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\"" + row.pwGUID + "\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"\" data-original-title=\"Edit\"><span class=\"zmdi zmdi-edit\"></span></a>"

							+

							"<a href=\"<?php echo site_url('MNCH/delete_nonpregwoman_child_pnc');?>/" + row.pwGUID + "\" type=\"button\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\"" + row.pwGUID + "\"  data-toggle=\"confirmation\"data-singleton=\"true\" data-placement=\"left\" data-title=\"Proceed to delete?\" ><span class=\"zmdi zmdi-delete\"></span></a>";
						},

						
						"IsDeleted": function(column, row){

							
							if(row.IsDeleted == 0){
								var formatter = "<span>No</span>";
							}else{
								var formatter = "<span>Yes</span>";
							}
							return formatter;
						},



					}

				}).on("loaded.rs.jquery.bootgrid", function () {

					if ($('[data-toggle="tooltip"]')[0]) {
						$('[data-toggle="tooltip"]').tooltip();
					}

					$('[data-toggle=confirmation]').confirmation({
						rootSelector: '[data-toggle=confirmation]',
					});

					
				});
			}

			$('#StateCode').change(function(){
				var StateCode = $(this).val();
				$.post('<?php echo site_url('Ajax/getanmLists1/');?>'+StateCode, {}, function(raw){
					console.log('in response');
					console.log(raw);
					$('#ANMID').html(raw);
				});
			});

			$('#ANMID').change(function(){
				var ANMID = $(this).val();
				$.post('<?php echo site_url('Ajax/getashaLists2/');?>/'+ANMID, {}, function(raw){
					$('#ASHAID').html(raw);
				});

			});

			$('#ASHAID').change(function(){
				var ASHAID = $(this).val();
				$.post('<?php echo site_url('Ajax/getvillageLists1/');?>/'+ASHAID, {}, function(raw){
					$('#VillageCode').html(raw);
				});

			});


			function doSearch()
			{
				$("#data-table-command").bootgrid('reload');
			}

			function clearFilters(){
				$('#ANMID').val('');
				$('#ASHAID').val('');
				$('#VillageCode').val('');
				$('#Verified').val('');
				$('#IsDeleted').val('');
				doSearch();
			}

			$(document).ready(function(){
				$('#ANMID').select2();
				$('#ASHAID').select2();
				$('#StateCode').select2();
				$('#VillageCode').select2();
				$('#IsDeleted').select2();
			});

			// function deleteAlert() {
			// 	return confirm("Do you want to delete this opportunity ?");
			// }
		</script>