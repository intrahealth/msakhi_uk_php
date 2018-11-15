						<section id="content">
							<div class="block-header">
								<h2>Manage Block</h2>
							</div>

							<div class="card">
								<div class="card-header">
									<h2><b>Edit Block</b><small>
										Use the form below to Edit new Block
									</small></h2>
								</div>

								<div class="card-body card-padding">
									<form role="form" method="post" action="">
										<h4>Edit details</h4>

										<div class="form-group fg-line">
											<label for="BlockNameEnglish">Block Name In English</label>
											<input type="text" class="form-control" data-toggle="dropdown" id="BlockNameEnglish" name="BlockNameEnglish" placeholder="Enter Block Name In English " value="<?php print $Block_details['BlockNameEnglish'];?>" required>
										</div>

										<div class="form-group fg-line">
											<label for="BlockNameHindi">Block Name In Hindi</label>
											<input type="text" class="form-control" data-toggle="dropdown" id="BlockNameHindi" name="BlockNameHindi" placeholder="Enter Block Name In Hindi " value="<?php print $Block_details['BlockNameHindi'];?>" required>
										</div>

										<button type="submit" class="btn btn-primary btn-sm m-t-10">Submit</button>
									</form>
								</div>
							</div>
						</section>