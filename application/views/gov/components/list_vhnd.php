<section id="content">
	
	<form action="" method="post">

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
						<h2>VHND Micro Plan</h2>

						<?php if($this->input->post('SubCenterCode') != null){ ?>

						<a href="<?php echo site_url('gov/vhnd_schedule/export_pdf');?>" class="pull-right hvr-pulse-grow" id="btn-Preview-Image" data-toggle="tooltip" title="Export PDF">
							<i class="fa fa-2x fa-file-pdf-o" id="" name="" style="color: #cc3300; cursor: pointer; margin-right: 20px;" onclick="csv()"></i>
						</a>

						<a href="<?php echo site_url('gov/vhnd_schedule/export_csv');?>" class="pull-right hvr-pulse-grow" id="btn-Preview-Image" data-toggle="tooltip" title="Export Excel">
							<i class="fa fa-2x fa-file-excel-o" id="" name="" style="color: #009999; cursor: pointer; margin-right: 20px;" onclick="csv()"></i>
						</a>
						<?php } ?>
						
					</div>
					<div class="card-header less-padding">

						<div class="row">

							<div class="col-xs-3 form-group">
								<label for="year">Year</label>

								<select name="year" id="year" class="form-control" required>
									<?php echo form_error('year'); ?>
									<option value="">--select--</option>
									<option value="2016" <?php echo (set_value('year') == 2016)?"selected":"" ?>>2016</option>
									<option value="2017" <?php echo (set_value('year') == 2017)?"selected":"" ?>>2017</option>
								</select>

							</div>

							<div class="col-xs-3 form-group">
								<label for="date">Sub Centre</label><br>
								<select class="form-control" data-toggle="dropdown" id="SubCenterCode" name="SubCenterCode" required>
									<option value="">---select---</option>
									<?php foreach($Subcentre_list as $row){?>
									<option value="<?php echo $row->SubCenterCode;?>" <?php echo ($row->SubCenterCode == trim($this->input->post("SubCenterCode"))?"selected":"");?>><?php echo $row->SubCenterName;?></option>
									<?php } ?>
								</select>
							</div>

							<div class="col-xs-3 form-group">
								<label for="">ANM</label>
								<select class="form-control" data-toggle="dropdown" id="ANMID" name="ANMID" required>
									<option value="">--select--</option>
									<?php foreach($Anm_List as $row){?>
									<option value="<?php echo $row->ANMID;?>" <?php echo (trim($this->input->post('ANMID')) == $row->ANMID?"selected":"");?>><?php echo $row->ANMName;?></option>
									<?php } ?>
								</select>
							</div>

							<div class="col-xs-3">
								<button class="btn btn-success btn-block" name="operation" value="show_records">Show Records</button>
								<button class="btn btn-warning btn-block" name="operation" value="copy_previous" >Copy From Prev Year</button>
								<button class="btn btn-danger btn-block" name="operation" value="generate_records" >Generate Records</button>
								<a href="<?php echo site_url("gov/vhnd_schedule");?>" class="btn btn-default btn-block" >Refresh / Reset</a>
							</div>

						</div>
					</div>

					<div class="card" style="overflow: auto;">	

						
						<table id="data-table-command" class="table table-striped table-bordered table-vmiddle table-hover">
							<thead>
								<tr>
									<th class="text-center" style="background-color: #f2be00; color: white;">ID</th>
									<th class="text-center" style="background-color: #f2be00; color: white;">Asha Name</th>
									<th class="text-center" style="background-color: #f2be00; color: white;">Village/AWC</th>
									<th class="text-center" style="background-color: #f2be00; color: white;">Occurence</th>
									<th class="text-center" style="background-color: #f2be00; color: white;">Day</th>
									<th class="text-center" style="background-color: #f2be00; color: white;">Jan</th>
									<th class="text-center" style="background-color: #f2be00; color: white;">Feb</th>
									<th class="text-center" style="background-color: #f2be00; color: white;">March</th>
									<th class="text-center" style="background-color: #f2be00; color: white;">April</th>
									<th class="text-center" style="background-color: #f2be00; color: white;">May</th>
									<th class="text-center" style="background-color: #f2be00; color: white;">June</th>
									<th class="text-center" style="background-color: #f2be00; color: white;">July</th>
									<th class="text-center" style="background-color: #f2be00; color: white;">Aug</th>
									<th class="text-center" style="background-color: #f2be00; color: white;">Sep</th>
									<th class="text-center" style="background-color: #f2be00; color: white;">October</th>
									<th class="text-center" style="background-color: #f2be00; color: white;">November</th>
									<th class="text-center" style="background-color: #f2be00; color: white;">December</th>
								</tr>
							</thead>

							<tbody class="text-center">
								<?php 
								if(count($Vhnd_List) > 0){
									foreach($Vhnd_List as $row){ ?>
									<tr>

										<td>
											<?php echo $row->Schedule_ID; ?>

										</td>

										<td>
											<?php echo $row->ASHAName; ?>
										</td>

										<td>
											<select class="form-control" data-toggle="dropdown" id="vhnd[<?php echo $row->ASHA_ID;?>][VillageCode]" name="vhnd[<?php echo $row->ASHA_ID;?>][VillageCode]" style="width:70px;" >
												<option value="">---select---</option>
												<?php 
												$villQuery = "select v.VillageID, v.VillageName FROM `ashavillage` av 
												inner join mstvillage v
												on av.VillageID = v.VillageID
												and v.LanguageID = 1
												where av.ASHAID = " . $row->ASHA_ID;
												$villageList = $this->db->query($villQuery)->result();
												foreach($villageList as $vrow){ ?>
												<option value="<?php echo $vrow->VillageID;?>" <?php echo ($vrow->VillageID == $row->Village_ID?"selected":"");?> ><?php echo $vrow->VillageName;?></option>
												<?php } ?>
											</select>
										</td>

										<td>
											<select name="vhnd[<?php echo $row->ASHA_ID;?>][occurence]" id="vhnd[<?php echo $row->ASHA_ID;?>][occurence]" class="form-control" required style="width:70px;">
												<option value="">--Select--</option>
												<option value="1" <?php echo ($row->Occurence == 1? "selected":"");?>>First</option>
												<option value="2" <?php echo ($row->Occurence == 2? "selected":"");?>>Second</option>
												<option value="3" <?php echo ($row->Occurence == 3? "selected":"");?>>Third</option>
												<option value="4" <?php echo ($row->Occurence == 4? "selected":"");?>>Fourth</option>
												<option value="5" <?php echo ($row->Occurence == 5? "selected":"");?>>fifth</option>
											</select>
										</td>

										<td>
											<select name="vhnd[<?php echo $row->ASHA_ID;?>][days]" id="vhnd[<?php echo $row->ASHA_ID;?>][days]" class="form-control" required style="width:70px;">
												<option value="">--Select--</option>
												<option value="1" <?php echo ($row->Days == 1? "selected":"");?>>Monday</option>
												<option value="2" <?php echo ($row->Days == 2? "selected":"");?>>Tuesday</option>
												<option value="3" <?php echo ($row->Days == 3? "selected":"");?>>Wednesday</option>
												<option value="4" <?php echo ($row->Days == 4? "selected":"");?>>Thursday</option>
												<option value="5" <?php echo ($row->Days == 5? "selected":"");?>>Friday</option>
												<option value="6" <?php echo ($row->Days == 6? "selected":"");?>>Saturday</option>
												<option value="7" <?php echo ($row->Days == 7? "selected":"");?>>Sunday</option>
											</select>
										</td>

										<td>
											<input type="text" id="Jan"  value="<?php echo $row->Jan;?>" style="width:70px;"/>
										</td>

										<td>
											<input type="text" id="Feb"  value="<?php echo $row->Feb;?>" style="width:70px;"/>
										</td>

										<td>
											<input type="text" id="Mar"  value="<?php echo $row->Mar;?>" style="width:70px;"/>
										</td>
										<td>
											<input type="text" id="Apr"  value="<?php echo $row->Apr;?>" style="width:70px;"/>
										</td>
										<td>
											<input type="text" id="May"  value="<?php echo $row->May;?>" style="width:70px;"/>
										</td>

										<td>
											<input type="text" id="Jun"  value="<?php echo $row->Jun;?>" style="width:70px;"/>
										</td>

										<td>
											<input type="text" id="Jul"  value="<?php echo $row->Jul;?>" style="width:70px;"/>
										</td>

										<td>
											<input type="text" id="Aug"  value="<?php echo $row->Aug;?>" style="width:70px;"/>
										</td>

										<td>
											<input type="text" id="Sep"  value="<?php echo $row->Sep;?>" style="width:70px;"/>
										</td>

										<td>
											<input type="text" id="Oct"  value="<?php echo $row->Oct;?>" style="width:70px;"/>
										</td>

										<td>
											<input type="text" id="Nov"  value="<?php echo $row->Nov;?>" style="width:70px;"/>
										</td>

										<td>
											<input type="text" id="Dec"  value="<?php echo $row->Dec;?>" style="width:70px;"/>
										</td>

									</tr>
									<?php } }?>
								</tbody>
							</table>
						</div>	

					</div>
				</form>

			</div>
		</div>

	</section>

	<!-- Data Table -->
	<script type="text/javascript">
		$(document).ready(function(){

		// $('#table_vhnd_schedule').bootgrid();
		
		$('#SubCenterCode').change(function(){
			var SubCenterCode = $(this).val();
			$.post('<?php echo site_url('gov/Ajax/getanmsubcenter/');?>/'+SubCenterCode, {}, function(raw){
				$('#ANMID').html(raw);
			});
		});
	});

</script>