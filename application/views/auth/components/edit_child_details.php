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
	
	<div class="panel panel-default">
		<div class="panel-heading">
			<span class="panel-title">
				<small>  
					<b>Child Details</b>
				</small>
			</span>
		</div>

		<div class="col-lg-12">
			<div id="div1">
				<?php echo '<img  src="'.site_url('datafiles/'. $PNG_FILENAME).'">'; ?>
				<p style="text-align: left;"> <?php echo $child_data->child_name;?></p>
			</div>

			<div  class="btn btn-primary btn-round btn-sm m-t-10" id="preview" style="color:#fff; font-size:14px; text-align: center;">
				Generate QR Code
			</div>
		</div>
		<br /><br />
		
		<div class="panel-body">
			<div class="row">
				<div class="col-lg-12">
					<form action="" method="POST">

						<table class="table table-striped table-bordered table-vmiddle table-hover" id="immunization_report">
							<thead>

								<tr>
									<th style="background-color: #f2be00; color: white;">
										<b>Perticulars</b>
									</th>

									<th style="background-color: #f2be00; color: white;">
										
									</th>
								</tr>

							</thead>

							<tbody>
								<tr>
									<td>Date Of Registration</td>
									<td><input type="date" id="Date_Of_Registration" name="Date_Of_Registration" value="<?php echo $child_data->Date_Of_Registration;?>" style="width:117px;"/></td>
								</tr>


								<tr>
									<td>Child DOB</td>
									<td><input type="date" id="child_dob" name="child_dob"  value="<?php echo $child_data->child_dob;?>" style="width:117px;"/></td>
								</tr>



								<tr>
									<td>Birth Time</td>
									<td><input type="text" id="birth_time" name="birth_time" value="<?php echo $child_data->birth_time;?>" style="width:117px;"/></td>
								</tr>

								<tr>
									<td>Gender</td>
									<td><select id="Gender" name="Gender" style="width:117px;"/>
										<option selected="" disabled>Select Gender</option>
										<option value="1" <?php echo ($child_data->Gender == "1" ? "selected" : "") ?> >Female</option>

										<option value="2" <?php echo ($child_data->Gender == "2" ? "selected" : "") ?> >Male</option>
									</select></td>
								</tr>

								<tr>
									<td>Weight of Child</td>
									<td><input type="number" id="Wt_of_child" name="Wt_of_child" value="<?php echo $child_data->Wt_of_child;?>" style="width:117px;"/></td>
								</tr>

								<tr>
									<td>Child Name</td>
									<td><input type="text" id="child_name" name="child_name"  value="<?php echo $child_data->child_name;?>" style="width:117px;"/></td>
								</tr>

								<tr>
									<td>BCG</td>
									<td><input type="date" id="bcg" name="bcg" value="<?php echo $child_data->bcg;?>" style="width:117px;"/></td>
								</tr>


								<tr>
									<td>Hep B (Birth Dose)</td>
									<td><input type="date" id="hepb1" name="hepb1"  value="<?php echo $child_data->hepb1;?>" style="width:117px;"/></td>
								</tr>

							<!-- 	<tr>
									<td>OPV 0</td>
									<td><input type="date" id="BCG"   value="" style="width:117px;"/></td>
								</tr> -->

								<tr>
									<td>OPV 1</td>
									<td><input type="date" id="opv1" name="opv1" value="<?php echo $child_data->opv1;?>" style="width:117px;"/></td>
								</tr>

								<tr>
									<td>OPV 2</td>
									<td><input type="date" id="opv2" name="opv2" value="<?php echo $child_data->opv2;?>" style="width:117px;"/></td>
								</tr>

								<tr>
									<td>OPV 3</td>
									<td><input type="date" id="opv3" name="opv3"  value="<?php echo $child_data->opv3;?>" style="width:117px;"/></td>
								</tr>

								<tr>
									<td>DPT 1</td>
									<td><input type="date" id="dpt1" name="dpt1" value="<?php echo $child_data->dpt1;?>" style="width:117px;"/></td>
								</tr>

								<tr>
									<td>DPT 2</td>
									<td><input type="date" id="dpt2" name="dpt2" value="<?php echo $child_data->dpt2;?>" style="width:117px;"/></td>
								</tr>

								<tr>
									<td>DPT 3</td>
									<td><input type="date" id="dpt3" name="dpt3"  value="<?php echo $child_data->dpt3;?>" style="width:117px;"/></td>
								</tr>

								<tr>
									<td>Hep B1</td>
									<td><input type="date" id="hepb1" name="hepb1"   value="<?php echo $child_data->hepb1;?>" style="width:117px;"/></td>
								</tr>

								<tr>
									<td>Hep B2</td>
									<td><input type="date" id="hepb2" name="hepb2"   value="<?php echo $child_data->hepb2;?>" style="width:117px;"/></td>
								</tr>

								<tr>
									<td>Hep B3</td>
									<td><input type="date" id="hepb3" name="hepb3"  value="<?php echo $child_data->hepb3;?>" style="width:117px;"/></td>
								</tr>

								<tr>
									<td>Pentavalent 1</td>
									<td><input type="date" id="Pentavalent1" name="Pentavalent1"   value="<?php echo $child_data->Pentavalent1;?>" style="width:117px;"/></td>
								</tr>

								<tr>
									<td>Pentavalent 2</td>
									<td><input type="date" id="Pentavalent2" name="Pentavalent2"   value="<?php echo $child_data->Pentavalent2;?>" style="width:117px;"/></td>
								</tr>

								<tr>
									<td>Pentavalent 3</td>
									<td><input type="date" id="Pentavalent3" name="Pentavalent3"  value="<?php echo $child_data->Pentavalent3;?>" style="width:117px;"/></td>
								</tr>

								<tr>
									<td>IPV</td>
									<td><input type="date" id="IPV" name="IPV"  value="<?php echo $child_data->IPV;?>" style="width:117px;"/></td>
								</tr>

								<tr>
									<td>Measles(First Dose)</td>
									<td><input type="date" id="measeals" name="measeals"   value="<?php echo $child_data->measeals;?>" style="width:117px;"/></td>
								</tr>
								<tr>
									<td>Vitamin A/First Dose</td>
									<td><input type="date" id="vitaminA" name="vitaminA" value="<?php echo $child_data->vitaminA;?>" style="width:117px;"/></td>

								</tr>
								<tr>
									<td> JE Vaccine(First Dose)</td>
									<td><input type="date" id="JEVaccine1" name="JEVaccine1" value="<?php echo $child_data->JEVaccine1;?>" style="width:117px;"/></td>
								</tr>

								<tr>
									<td>OPV Booster</td>
									<td><input type="date" id="OPVBooster" name="OPVBooster" value="<?php echo $child_data->OPVBooster;?>" style="width:117px;"/></td>
								</tr>

								<tr>
									<td>DPT Booster</td>
									<td><input type="date" id="DPTBooster" name="DPTBooster" value="<?php echo $child_data->DPTBooster;?>" style="width:117px;"/></td>
								</tr>

								<tr>
									<td>Measles(Second Dose)</td>
									<td><input type="date" id="MeaslesTwoDose" name="MeaslesTwoDose"   value="<?php echo $child_data->MeaslesTwoDose;?>" style="width:117px;"/></td>
								</tr>

								

								<tr>
									<th style="text-align: center;">

										<button type="submit" name="operation" value="save" class="btn btn-primary btn-round btn-sm m-t-10">Save</button>
										<button type="submit" name="operation" value="reset" class="btn btn-danger btn-sm m-t-10">Reset</button>

									</th>
									<th style="text-align: center;" style="text-align: center;">
									</th>
								</tr>


							</tbody>

						</table>
					</form>
				</div>
			</div>
		</div>
	</div>
	
</section>

<script>
	function export_excel() {
		$("#immunization_report").tableToCSV();
	}    
</script>
<script>
	$(function(){
		$("#div1").hide();
		$("#preview").on("click", function(){
			$("#div1").toggle();
			$("#preview").hide();
		});
	});
	
</script>