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
					<b>Pregnent Woman Details</b>

				</small>
			</span>
		</div>

		<!-- <?php //echo '<img  src="'.site_url('datafiles/'. $PNG_FILENAME).'">'; ?> -->
		<div class="col-lg-12">
			<div id="div1">
				<?php echo '<img  src="'.site_url('datafiles/'. $PNG_FILENAME).'">'; ?>
				<div>
				<b style="text-align: center;     padding-left: 141px;"> <?php echo $anc_data->PWName;?></b>
			</div>
			</div>

			<div  class="btn btn-primary btn-round btn-sm m-t-10" id="preview" style="color:#fff; font-size:14px; text-align: center;">
				Generate QR Code
			</div>
			 <a href="javascript:window.print();" class="pull-right hvr-pulse-grow" id="btn-Preview-Image" data-toggle="tooltip" title="Export PDF">
        <i class="fa fa-2x fa-file-pdf-o" id="" name="" style="color: #cc3300; cursor: pointer; margin-right: 20px;"></i>
      </a>
		</div>
		<br /><br />

		<div class="panel-body">
			<div class="row">
				<div class="col-lg-12">
					<form role="form" method="post" action="">

						<table class="table table-striped table-bordered table-vmiddle table-hover" id="immunization_report">
							<thead>

								<tr>
									<th style="background-color: #f2be00; color: white;">
										<b>Perticular</b>
									</th>

									<th style="background-color: #f2be00; color: white;">

									</th>
								</tr>

							</thead>

							<tbody>
								<tr>
									<td>Woman Name</td>
									<td><input type="text" id="PWName" name="PWName" value="<?php echo $anc_data->PWName;?>" style="width:117px;"/></td>
								</tr>



								<tr>
									<td>LMP Date</td>
									<td><input type="date" id="LMPDate" name="LMPDate"  value="<?php echo $anc_data->LMPDate; ?>" style="width:117px;"/></td>
								</tr>


								<tr>
									<td>PW Registration Date</td>
									<td><input type="date" id="PWRegistrationDate" name="PWRegistrationDate" value="<?php echo $anc_data->PWRegistrationDate;?>" style="width:117px;"/></td>
								</tr>


								<tr>
									<td>Husband Name</td>
									<td><input type="text" id="HusbandName" name="HusbandName"  value="<?php echo $anc_data->HusbandName;?>" style="width:117px;"/></td>
								</tr>

								<tr>
									<td>Mobile No</td>
									<td><input type="number" id="MobileNo" name="MobileNo" value="<?php echo $anc_data->MobileNo;?>" style="width:117px;"/></td>
								</tr>

								<tr>
									<td>Account No</td>
									<td><input type="number" id="Accountno" name="Accountno"  value="<?php echo $anc_data->Accountno;?>" style="width:117px;"/></td>
								</tr>

								<tr>
									<td>PW DOB</td>
									<td><input type="date" id="PWDOB" name="PWDOB" value="<?php echo $anc_data->PWDOB;?>" style="width:117px;"/></td>
								</tr>

								<tr>
									<td>PW Age Years</td>
									<td><input type="number" id="PWAgeYears" name="PWAgeYears" value="<?php echo $anc_data->PWAgeYears;?>" style="width:117px;"/></td>
								</tr>

								<tr>
									<td>PW Weight</td>
									<td><input type="number" id="PWWeight" name="PWWeight"  value="<?php echo $anc_data->PWWeight;?>" style="width:117px;"/></td>
								</tr>

								<tr>
									<td>PWBloodGroup</td>
									<td><input type="text" id="PWBloodGroup" name="PWBloodGroup"   value="<?php echo $anc_data->PWBloodGroup;?>" style="width:117px;"/></td>
								</tr>

								<tr>
									<td>Total Pregnancy</td>
									<td><input type="text" id="TotalPregnancy" name="TotalPregnancy"   value="<?php echo $anc_data->TotalPregnancy;?>" style="width:117px;"/></td>
								</tr>

								<tr>
									<td>Last Pregnancy Result</td>
									<td><input type="date" id="LastPregnancyResult" name="LastPregnancyResult"  value="<?php echo $anc_data->LastPregnancyResult;?>" style="width:117px;"/></td>
								</tr>

								<tr>
									<td>HIV Result</td>
									<td><input type="text" id="HIVResult" name="HIVResult"   value="<?php echo $anc_data->HIVResult;?>" style="width:117px;"/></td>
								</tr>

								<tr>
									<td>Visit 1 Date</td>
									<td><input type="date" id="Visit1Date" name="Visit1Date"   value="<?php echo $anc_data->Visit1Date;?>" style="width:117px;"/></td>
								</tr>

								<tr>
									<td>Visit 2 Date</td>
									<td><input type="date" id="Visit2Date" name="Visit2Date"  value="<?php echo $anc_data->Visit2Date;?>" style="width:117px;"/></td>
								</tr>

								<tr>
									<td>Visit 3 Date</td>
									<td><input type="date" id="Visit3Date" name="Visit3Date"  value="<?php echo $anc_data->Visit3Date;?>" style="width:117px;"/></td>
								</tr>

								<tr>
									<td>Visit 4 Date</td>
									<td><input type="date" id="Visit4Date" name="Visit4Date"  value="<?php echo $anc_data->Visit4Date;?>" style="width:117px;"/></td>
								</tr>

								<tr>
									<td>Delivery Date Time</td>
									<td><input type="date" id="DeliveryDateTime" name="DeliveryDateTime"  value="<?php echo $anc_data->DeliveryDateTime;?>" style="width:117px;"/></td>
								</tr>

								<tr>
									<td>Delivery Place</td>
									<td><input type="date" id="DeliveryPlace" name="DeliveryPlace"  value="<?php echo $anc_data->DeliveryPlace;?>" style="width:117px;"/></td>
								</tr>

								<tr>
									<td>Updated On</td>
									<td><input type="date" id="UpdatedOn" name="UpdatedOn"  value="<?php echo $anc_data->UpdatedOn;?>" style="width:117px;"/></td>
								</tr>



								<th style="text-align: center;"><button type="submit" class="btn btn-primary btn-round btn-sm m-t-10">Save</button></th>
								<th style="text-align: center;"></th>


							</tbody>

						</table>
					</form>
				</div>
			</div>
		</div>
	</div>

</section>

<!-- <script>
	function export_excel() {
		$("#immunization_report").tableToCSV();
	}    
</script> -->

<script>
	$(function(){
		$("#div1").hide();
		$("#preview").on("click", function(){
			$("#div1").toggle();
			$("#preview").hide();
		});
	});
	
</script>