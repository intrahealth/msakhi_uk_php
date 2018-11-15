<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>QR</title>


	<link rel="stylesheet" href="<?php echo site_url('common_libs/css/bootstrap.min.css'); ?>">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.min.css">

</head>
<body>
	
	<div class="container">

		<div class="row">
			<div class="col-md-12">				
				<span style="font-size: 30px;">QR Code Information for Child</span>
			</div>
		</div>

		<div class="row">

			<?php foreach ($data as $row) { ?>

			<div class="col-sm-2">
				<div class="card">
							<img src="<?php echo site_url('datafiles/' . $row->PNG_FILENAME) ?>" alt="QR code"><br>
							<span style="font-size: 14px; text-align: center; padding-left: 30px;"><?php echo $row->child_name;?></span><br>
							<span style="font-size: 14px; text-align: center; padding-left: 16px;"><?php echo $row->child_dob;?></span><br>
							<span style="font-size: 14px; text-align: center; padding-left: 16px;"><?php echo $row->ASHAName;?>(<?php echo $row->user_name;?>)</span><br>			
				</div>
			</div>

			<?php } ?>
		</div>
	</div>
</body>
</html>