<section id="content">
	<div class="block-header">
		<h2>Manage Panchayat</h2>
	</div>
	
	<div class="card">
		<div class="card-header">
			<h2><b>Edit Panchayat</b><small>
				Use the form below to edit new panchayat
			</small></h2>
		</div>
		
		<div class="card-body card-padding">
			<form role="form" method="post" action="">
				<h4>Panchayat details</h4>

				
				<div class="form-group fg-line">
					<label for="PanchayatNameEnglish">Panchayat Name In English </label>
					<input type="text" class="form-control" data-toggle="dropdown" id="PanchayatNameEnglish" name="PanchayatNameEnglish" placeholder="Enter Panchayat Name" value="<?php print $Panchayat_details['PanchayatNameEnglish']; ?>" required>
				</div>			

				<div class="form-group fg-line">
					<label for="PanchayatNameHindi"> Panchayat Name In Hindi</label>
					<input type="text" class="form-control" data-toggle="dropdown" id="PanchayatNameHindi"
					name="PanchayatNameHindi" placeholder="Enter Panchayat Name in Hindi" value="<?php print $Panchayat_details['PanchayatNameHindi']; ?>" required>
				</div>
				
				<button type="submit" class="btn btn-primary btn-sm m-t-10">Submit</button>
				
			</form>

		</div>

	</div>

</section>