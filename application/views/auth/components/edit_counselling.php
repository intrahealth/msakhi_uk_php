<style>
#immunization_report table {
	font-family: arial, sans-serif;
	border-collapse: collapse;
	width: 100%;
}

#immunization_report td, th {
	border: 1px solid #fff;
	text-align: left;
	padding: 8px;
}
</style>

<section id="content">
	<?php foreach ($role_permission as $row) { if ($row->Controller == "counselling" && $row->Action == "edit_immunization_counselling") { ?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<span class="panel-title">
				<small>  
					<b>Immunization</b>
				</small>
			</span>
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

				<div class="panel-body">
					<div class="row">

						<div class="col-lg-12">

							<table class="table table-striped table-bordered table-vmiddle table-hover" id="immunization_report">
								<thead>

									<tr>
										<th style="background-color: #f2be00; color: white;">
											<b>Name</b>
										</th>

										<th style="background-color: #f2be00; color: white;">
											<b>Date</b>
										</th>
									</tr>

								</thead>

								<tbody>
									<form role="form" method="post" action="">

										<tr>
											<td>BCG</td>
											<td><input type="date" id="bcg" name="bcg" value="<?php echo $child_detail[0]->bcg;?>" style="width:117px;"/></td>
										</tr>


										<tr>
											<td>Hep B (Birth Dose)</td>
											<td><input type="date" id="hepb1" name="hepb1"  value="<?php echo $child_detail[0]->hepb1;?>" style="width:117px;"/></td>
										</tr>

									<!-- 	<tr>
											<td>OPV 0</td>
											<td><input type="date" id="BCG"   value="" style="width:117px;"/></td>
										</tr> -->

										<tr>
											<td>OPV 1</td>
											<td><input type="date" id="opv1" name="opv1" value="<?php echo $child_detail[0]->opv1;?>" style="width:117px;"/></td>
										</tr>

										<tr>
											<td>OPV 2</td>
											<td><input type="date" id="opv2" name="opv2" value="<?php echo $child_detail[0]->opv2;?>" style="width:117px;"/></td>
										</tr>

										<tr>
											<td>OPV 3</td>
											<td><input type="date" id="opv3" name="opv3"  value="<?php echo $child_detail[0]->opv3;?>" style="width:117px;"/></td>
										</tr>

										<tr>
											<td>DPT 1</td>
											<td><input type="date" id="dpt1" name="dpt1" value="<?php echo $child_detail[0]->dpt1;?>" style="width:117px;"/></td>
										</tr>

										<tr>
											<td>DPT 2</td>
											<td><input type="date" id="dpt2" name="dpt2" value="<?php echo $child_detail[0]->dpt2;?>" style="width:117px;"/></td>
										</tr>

										<tr>
											<td>DPT 3</td>
											<td><input type="date" id="dpt3" name="dpt3"  value="<?php echo $child_detail[0]->dpt3;?>" style="width:117px;"/></td>
										</tr>

										<tr>
											<td>Hep B1</td>
											<td><input type="date" id="hepb1" name="hepb1"   value="<?php echo $child_detail[0]->hepb1;?>" style="width:117px;"/></td>
										</tr>

										<tr>
											<td>Hep B2</td>
											<td><input type="date" id="hepb2" name="hepb2"   value="<?php echo $child_detail[0]->hepb2;?>" style="width:117px;"/></td>
										</tr>

										<tr>
											<td>Hep B3</td>
											<td><input type="date" id="hepb3" name="hepb3"  value="<?php echo $child_detail[0]->hepb3;?>" style="width:117px;"/></td>
										</tr>

										<tr>
											<td>Pentavalent 1</td>
											<td><input type="date" id="Pentavalent1" name="Pentavalent1"   value="<?php echo $child_detail[0]->Pentavalent1;?>" style="width:117px;"/></td>
										</tr>

										<tr>
											<td>Pentavalent 2</td>
											<td><input type="date" id="Pentavalent2" name="Pentavalent2"   value="<?php echo $child_detail[0]->Pentavalent2;?>" style="width:117px;"/></td>
										</tr>

										<tr>
											<td>Pentavalent 3</td>
											<td><input type="date" id="Pentavalent3" name="Pentavalent3"  value="<?php echo $child_detail[0]->Pentavalent3;?>" style="width:117px;"/></td>
										</tr>

										<tr>
											<td>IPV</td>
											<td><input type="date" id="IPV" name="IPV"  value="<?php echo $child_detail[0]->IPV;?>" style="width:117px;"/></td>
										</tr>

										<tr>
											<td>Measles(First Dose)</td>
											<td><input type="date" id="measeals" name="measeals"   value="<?php echo $child_detail[0]->measeals;?>" style="width:117px;"/></td>
										</tr>
										<tr>
											<td>Vitamin A/First Dose</td>
											<td><input type="date" id="vitaminA" name="vitaminA" value="<?php echo $child_detail[0]->vitaminA;?>" style="width:117px;"/></td>

										</tr>
										<tr>
											<td> JE Vaccine(First Dose)</td>
											<td><input type="date" id="JEVaccine1" name="JEVaccine1" value="<?php echo $child_detail[0]->JEVaccine1;?>" style="width:117px;"/></td>
										</tr>

										<tr>
											<td>OPV Booster</td>
											<td><input type="date" id="OPVBooster" name="OPVBooster" value="<?php echo $child_detail[0]->OPVBooster;?>" style="width:117px;"/></td>
										</tr>

										<tr>
											<td>DPT Booster</td>
											<td><input type="date" id="DPTBooster" name="DPTBooster" value="<?php echo $child_detail[0]->DPTBooster;?>" style="width:117px;"/></td>
										</tr>

										<tr>
											<td>Measles(Second Dose)</td>
											<td><input type="date" id="MeaslesTwoDose" name="MeaslesTwoDose"   value="<?php echo $child_detail[0]->MeaslesTwoDose;?>" style="width:117px;"/></td>
										</tr>

										<th style="text-align: center;"><button type="submit" class="btn btn-primary btn-round btn-sm m-t-10">Save</button>

											<a href="<?php echo site_url("counselling");?>" class="btn btn-danger btn-sm m-t-10">Back</a></th>
										</form>

									</tbody>

								</table>
							</div>

						</div>
					</div>
				</div>
				<?php } } ?>
			</section>

			