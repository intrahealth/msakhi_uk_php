<section id="content">
	<div class="block-header">
		<h2>Manage Subcenter</h2>
	</div>

	<div class="card">
		<div class="card-header">
			<h2><b>Edit Subcenter</b><small>
				Use the form below to edit new Subcenter
			</small></h2>
		</div>

		<div class="card-body card-padding">
			<form role="form" method="post" action="">
				<h4>Subcenter details</h4>


				<div class="form-group fg-line">
					<label for="SubCenterNameEnglish">SubCenter Name In English</label>
					<input type="text" class="form-control" data-toggle="dropdown" id="SubCenterNameEnglish" name="SubCenterNameEnglish" placeholder="Enter SubCenter Name In English" value="<?php print $Subcenter_details['SubCenterNameEnglish']; ?>" required>
				</div>
				

				<div class="form-group fg-line">
					<label for="SubCenterNameHindi">SubCenter Name In Hindi</label>
					<input type="text" class="form-control" data-toggle="dropdown" id="SubCenterNameHindi" name="SubCenterNameHindi" placeholder="SubCenter Name In Hindi" value="<?php print $Subcenter_details['SubCenterNameHindi']; ?>" required>
				</div>
				

				<div class="form-group fg-line">
					<label for="PHC_id">PHC Id</label>
					<input type="number" class="form-control" data-toggle="dropdown" id="PHC_id" name="PHC_id" placeholder="PHC Id" value="<?php print $Subcenter_details['PHC_id']; ?>" required> 
				</div>

				<button type="submit" class="btn btn-primary btn-sm m-t-10">Submit</button>

			</form>
		</div>
	</div>
</section>