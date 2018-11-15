<section id="content">
	<div class="block-header">
		<h2>Manage Village</h2>
	</div>

	<div class="card">
		<div class="card-header">
			<h2><b>Edit Village</b><small>
				Use the form below to edit new village
			</small></h2>
		</div>

		<div class="card-body card-padding">
			<form role="form" method="post" action="">
				<h4>Village details</h4>


				<div class="form-group fg-line">
					<label for="VillageNameEnglish">Village Name In English </label>
					<input type="text" class="form-control" data-toggle="dropdown" id="VillageNameEnglish" name="VillageNameEnglish" placeholder="Enter Village Name in English" value="<?php print $Village_details['VillageNameEnglish'];?>" required>
				</div>

				<div class="form-group fg-line">
					<label for="VillageNameHindi">Village Name In Hindi </label>
					<input type="text" class="form-control" data-toggle="dropdown" id="VillageNameHindi" name="VillageNameHindi" placeholder="Enter Village Name in Hindi" value="<?php print $Village_details['VillageNameHindi'];?>" required>
				</div>


				<button type="submit" class="btn btn-primary btn-sm m-t-10">Submit</button>

				<a href="<?php echo site_url("village");?>" class="btn btn-danger btn-sm m-t-10" id="close">Cancel</a>
			</form>
		</div>

	</div>
</section>