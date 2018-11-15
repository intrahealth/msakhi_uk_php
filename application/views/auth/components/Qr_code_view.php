<section id="content">
	<?php foreach ($role_permission as $row) { if($row->Controller == "Qr_code_managment_women" && $row->Action == "index") { ?>

	<div class="container" style="width: 1070px;">
		<?php
		$tr_msg = $this->session->flashdata('tr_msg');
		$er_msg = $this->session->flashdata('er_msg');
		if(!empty($tr_msg)) { ?>
		<div class="panel panel-default">
			<div class="panel-heading">
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
							<h2>Generate Qr Code <small>List of Pregenent Women</small></h2>
						</div>


						<div class="row" style="padding-left : 15px;">
							<div class="col-lg-2">
								<div class="form-group fg-line">
									<div class="select">
										<h5>State Name</h5>
										<?php echo form_error('StateCode'); ?>
										<select class="form-control" data-toggle="dropdown" id="StateCode" name="StateCode" style="width: 75%">
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
										<select class="form-control" data-toggle="dropdown" id="ANMID" name="ANMID" style="width: 75%">
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
										<select class="form-control" data-toggle="dropdown" id="ASHAID" name="ASHAID" style="width: 75%">
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
										<select class="form-control" data-toggle="dropdown" id="VillageCode" name="VillageCode" style="width: 75%">
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
									<select class="form-control" data-toggle="dropdown" id="IsDeleted" name="IsDeleted" style="width: 100%">
										<option value="">select</option>
										<option value="1">Yes</option>
										<option value="2">No</option>
									</select>							
								</div>
							</div>





							<div style="text-align:center;">
								<a class="btn btn-info"  style="margin-top : 20px;" onclick="doSearch()">Apply filters</a>
								
								&nbsp &nbsp

								<a class="btn btn-default" id="clearFilters" name="clearFilters" onclick="clearFilters()" style="margin-top : 20px;">Clear</a>
							</div>
						</div>
					</div>
					<div class="card">
						<div class="card-header">
							<h2>Pregnent Women List<small>List of Pregnent Women</small></h2>

							<div style="text-align:center;">
								<button class="btn btn-info" id="approve" onclick="approve()"  style="margin-top : -60px;  margin-left: 716px;" >Download Selected</button>
							</div>


						</div>
						<div class="table-responsive">
							<table id="data-table-command" class="table  table-vmiddle table table-condensed">
								<thead>
									<tr class="success">
										
										<th class="text-middle" data-column-id="pwGUID" data-identifier="true" data-visible="false">ID</th>
										<th class="text-middle" data-column-id="ANMName">ANM Name</th>
										<th class="text-middle" data-column-id="ASHAName">ASHA Name</th>
										<!-- <th class="text-middle" data-column-id="ANMName">ANM Name</th> -->
										<!-- <th class="text-middle" data-column-id="ASHAName">ASHA Name</th> -->
										<th class="text-middle" data-column-id="VillageName">Village Name</th>
										<th class="text-middle" data-column-id="PWName">Pregnent Women Name</th>
										<th class="text-middle" data-column-id="HusbandName">Husband Name</th>
										<th class="text-middle" data-column-id="HHCode">HH Code</th>
										<th class="text-middle" data-column-id="LMPDate">LMP Date</th>
										<th class="text-middle" data-column-id="IsDeleted" data-formatter="IsDeleted">Deleted Status</th>
										<th class="text-middle" data-column-id="commands" data-formatter="commands" data-sortable="false">Print QR</th>
									</tr>
								</thead>

							</table>
						</div>
					</div>
				</div>
			</div>
			<?php } } ?>


		</section>


		<form method="POST" id="qr_download_form" action="<?php echo site_url('Qr_code_managment_women/download_multiple_qr_code');?>">
			<input type="hidden" name="pwGUID" id="pwGUID" value="">
		</form>

		<script type="text/javascript">
			$(document).ready(function()
			{
				bindBootgrid();
			});

			function bindBootgrid()
			{
				$("#data-table-command").bootgrid('destroy').bootgrid({

					caseSensitive: false,
					selection: true,
					multiSelect: true,
					rowSelect: true,
					keepSelection: true,

					ajax: true,
					url: "<?php echo site_url("MNCH/getANCList");?>",
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
					return  "<a href=\"<?php echo site_url('Qr_code_managment_women/dwnload_qr_code');?>/" + row.pwGUID + "\" type=\"button\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\"" + row.pwGUID +"\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"\" data-original-title= \"Print QR Code\"><span class=\"zmdi zmdi-download\"></span></a>"

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


	function approve() 
	{

		var selection = $("#data-table-command").bootgrid("getSelectedRows");

		if (selection.length < 1) {
			alert('No rows selected for QR Code Generated');
			return false;
		}

		$('#pwGUID').val(selection.toString());
		console.log($('#pwGUID').val());
		$('#qr_download_form').submit();

	}

	$(document).ready(function(){
      $('#ANMID').select2();
      $('#ASHAID').select2();
      $('#StateCode').select2();
      $('#VillageCode').select2();
      $('#IsDeleted').select2();

      $("#fixTable").tableHeadFixer({"left" : 1});

    });	

	





</script>