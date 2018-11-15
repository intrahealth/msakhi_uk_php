						<section id="content">
							<div class="block-header">
								<h2>Manage Subcenter</h2>
							</div>
							
							<div class="card">
								<div class="card-header">
									<h2><b>Add Subcenter</b><small>
										Use the form below to add new Subcenter
									</small></h2>
								</div>
								
								<div class="card-body card-padding">
									<form role="form" method="post" action="">
										<h4>Subcenter details</h4>
										
										
										<div class="form-group fg-line">
											<label for="SubCenterName">SubCenter Name In English</label>
											<?php echo form_error('SubCenterNameEnglish'); ?>
											<input type="text" class="form-control" data-toggle="dropdown" id="SubCenterNameEnglish" name="SubCenterNameEnglish" placeholder="Enter SubCenter Name In English " value="<?php echo set_value('SubCenterNameEnglish'); ?>" required>
										</div>
										
										
										<div class="form-group fg-line">
											<label for="SubCenterName">SubCenter Name In Hindi</label>
											<?php echo form_error('SubCenterNameHindi'); ?>
											<input type="text" class="form-control" data-toggle="dropdown" id="SubCenterNameHindi" name="SubCenterNameHindi" placeholder="SubCenter Name In Hindi " value="<?php echo set_value('SubCenterNameHindi'); ?>" required>
										</div>
										
										
										<div class="form-group fg-line">
											<label for="PHC_id">PHC Id</label>
											<?php echo form_error('PHC_id'); ?>
											<input type="number" class="form-control" data-toggle="dropdown" id="PHC_id" name="PHC_id" placeholder="PHC Id " value="<?php echo set_value('PHC_id'); ?>" required>
										</div>
										
										<button type="submit" class="btn btn-primary btn-sm m-t-10">Submit</button>
									</form>
								</div>
							</div>
						</section>