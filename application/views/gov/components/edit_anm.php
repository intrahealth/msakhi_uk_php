						<section id="content">
							<div class="block-header">
								<h2>Manage ANM</h2>
							</div>

							<div class="card">
								<div class="card-header">
									<h2><b>Edit ANM</b><small>
										Use the form below to Edit ANM
									</small></h2>
								</div>

								<div class="card-body card-padding">
									<form role="form" method="post" action="">
										<h4>ANM Details</h4>

										<div class="form-group fg-line">
											<label for="ANMNameEnglish">ANM Name In English </label>
											<input type="text" class="form-control" data-toggle="dropdown" id="ANMNameEnglish" name="ANMNameEnglish" placeholder="Enter ANM Name In English" value="<?php print $Anm_details['ANMNameEnglish'];?>" required>
										</div>

										<div class="form-group fg-line">
											<label for="ANMNameHindi">ANM Name in Hindi </label>
											<input type="text" class="form-control" data-toggle="dropdown" id="ANMNameHindi" name="ANMNameHindi" placeholder="Enter ANM Name in Hindi" value="<?php print $Anm_details['ANMNameHindi'];?>" required>
										</div>

										<button type="submit" class="btn btn-primary btn-sm m-t-10">Submit</button>

									</form>

								</div>
							</div>
						</section>