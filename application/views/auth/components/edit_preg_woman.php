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
					<b>ANC Visits Details</b>
				</small>
			</span>
		</div>

		<div class="panel-body">
			<div class="row">
				<div class="col-lg-12">
					<form action="" method="post">

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
							<input type="hidden" name="PWGUID" value="<?php echo $anc_data->PWGUID;?>">
							<tr>
								<td>Visit No.</td>
								<td><input type="text" id="Visit_No" name="Visit_No" value="<?php echo $anc_data->Visit_No;?>" readonly style="width:117px;"/></td>
							</tr>


							<tr>
								<td>Visit Due Date</td>
								<td><input type="date" id="VisitDueDate" class="form_datetime" name="VisitDueDate"  value="<?php echo $anc_data->VisitDueDate;?>" readonly style="width:117px;"/></td>
							</tr>




							<tr>
								<td>Checkup Visit Date</td>
								<td><input type="date" class="form_datetime" id="CheckupVisitDate" name="CheckupVisitDate"  value="<?php echo $anc_data->CheckupVisitDate; ?>" style="width:117px;"/></td>
							</tr>

							<tr>
								<td>BP</td>
								<td><input type="number" id="BP" name="BP" value="<?php echo $anc_data->BP;?>" style="width:117px;"/></td>
							</tr>

							<tr>
								<td>Hemoglobin</td>
								<td><input type="number" id="Hemoglobin" name="Hemoglobin" value="<?php echo $anc_data->Hemoglobin;?>" style="width:117px;"/></td>
							</tr>

							<tr>
								<td>TT first Dose Date</td>
								<td><input type="date" id="TTfirstDoseDate" name="TTfirstDoseDate"  value="<?php echo $anc_data->TTfirstDoseDate;?>" style="width:117px;"/></td>
							</tr>

							<tr>
								<td>TT second Dose Date</td>
								<td><input type="date" id="TTsecondDoseDate" name="TTsecondDoseDate" value="<?php echo $anc_data->TTsecondDoseDate;?>" style="width:117px;"/></td>
							</tr>

							<tr>
								<td>TT booster Date</td>
								<td><input type="date" id="TTboosterDate" name="TTboosterDate" value="<?php echo $anc_data->TTboosterDate;?>" style="width:117px;"/></td>
							</tr>

							<tr>
								<td>TT 1</td>
								<td><input type="text" id="TT1" name="TT1"  value="<?php echo $anc_data->TT1;?>" style="width:117px;"/></td>
							</tr>

							<tr>
								<td>TT 1 date</td>
								<td><input type="date" id="TT1date" name="TT1date"   value="<?php echo $anc_data->TT1date;?>" style="width:117px;"/></td>
							</tr>

							<tr>
								<td>TT 2</td>
								<td><input type="text" id="TT2" name="TT2"   value="<?php echo $anc_data->TT2;?>" style="width:117px;"/></td>
							</tr>

							<tr>
								<td>TT 2 date</td>
								<td><input type="date" id="TT2date" name="TT2date"  value="<?php echo $anc_data->TT2date;?>" style="width:117px;"/></td>
							</tr>

							<tr>
								<td>TTbooster</td>
								<td><input type="text" id="TTbooster" name="TTbooster"   value="<?php echo $anc_data->TTbooster;?>" style="width:117px;"/></td>
							</tr>

							<tr>
								<td>TTbooster Date 1</td>
								<td><input type="date" id="TTboosterDate1" name="TTboosterDate1"   value="<?php echo $anc_data->TTboosterDate1;?>" style="width:117px;"/></td>
							</tr>

							<tr>
								<td>BP1</td>
								<td><input type="text" id="BP1" name="BP1"  value="<?php echo $anc_data->BP1;?>" style="width:117px;"/></td>
							</tr>

							<tr>
								<td>HB1</td>
								<td><input type="text" id="HB1" name="HB1"  value="<?php echo $anc_data->HB1;?>" style="width:117px;"/></td>
							</tr>
							<tr>
								<td>Deleted Status</td>
								<td><select id="IsDeleted" name="IsDeleted" style="width:117px;"/>
									<option selected="" disabled>Change Deleted Status</option>
									<option value="1" <?php echo ($anc_data->IsDeleted == "1" ? "selected" : "") ?> >Yes</option>

									<option value="0" <?php echo ($anc_data->IsDeleted == "0" ? "selected" : "") ?> >No</option>
								</select></td>
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

<!-- <script>
	function export_excel() {
		$("#immunization_report").tableToCSV();
	}    
</script> -->
<script type="text/javascript">
	$(document).ready(function(){
$("#btn").click(function(){
/* Single line Reset function executes on click of Reset Button */
$("#form")[0].reset();
});});
</script>

<script type="text/javascript">
    $(".form_datetime").datetimepicker({format: 'yyyy-mm-dd'});
</script>    