<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Monthly ASHA report 03</title>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.min.css">
</head>
<body>
	<style type="text/css">
	.card
	{
		display: table;
	}
	.Title
	{
		/*display: table-caption;*/
		text-align: center;
		font-weight: bold;
		font-size: larger;
	}
	.Heading
	{
		display: table-row;
		/*font-weight: bold;*/
		text-align: center;
	}
	.Row
	{
		display: table-row;
	}
	.Cell
	{
		display: table-cell;
		border: solid;
		border-width: thin;
		padding-left: 3px;
		padding-right: 3px;
		font-style: bold;
	}
	.label
	{
		display: table-cell;
		border: solid;
		border-width: thin;
		padding-left: 3px;
		padding-right: 3px;
		font-weight: bold;
	}
</style>

<center style="background-color: rgb(242,190,0); color: white;">

	<img src="<?php echo site_url() . '/common_libs/img/msakhi_logo.png';?>" alt="Msakhi Logo" height="50" width="50">
	<h2>Msakhi (Uttrakhand)</h2>

</center>
<div class="container">
	<div class="Title">
		<p><h4 style="font-weight: bold;"><u>पी.एन.सी. प्रपत्र</u></h4></p>
	</div>
	<div class="row">
		<div class="col-md-4">
			<p>पी.एच.सी. का नाम :</p>
		</div>	
		<div class="col-md-4">
			<p>उपकेन्द्.......<?php echo $asha_data->SubCenterName; ?>.....</p>
		</div>	
		<div class="col-md-4">
			<p>माह/अवधि</p>
		</div>
	</div><br><br>
	<div class="row">
		<div class="col-md-4">
			<p>आशा  कार्यकर्ती का  नाम.......<?php echo $asha_data->ASHAName; ?>........</p>
		</div>
		<div class="col-md-4">
			<p>ग्राम सभा</p>
		</div>
	</div><br>
	<div class="card">
		<div class="Heading">
			<div class="label">
				<p>क्र.सं.</p>
			</div>
			<div class="label">
				<p>प्रसव धात्री का नाम</p>
			</div>
			<div class="label">
				<p>आई.डी.सं0</p>
			</div>
			<div class="label">
				<p>गांव का नाम</p>
			</div>
			<div class="label">
				<p>प्रसव की तिथि</p>
			</div>
			<div class="label">
				<p>प्रसव का स्थान घर पर /अस्पताल मे)</p>
			</div>
			<div class="label">
				<p>पहला दिन</p>
			</div>
			<div class="label">
				<p>3रा दिन</p>
			</div>
			<div class="label">
				<p>7वां दिन</p>
			</div>
			<div class="label">
				<p>14वां दिन</p>
			</div>
			<div class="label">
				<p>21वां दिन</p>
			</div>
			<div class="label">
				<p>28वां दिन</p>
			</div>
			<div class="label">
				<p>42वां दिन</p>
			</div>
			<div class="label">
				<p>42वां दिन के बाद माँ व बच्चा स्वस्थ है हाॅं/नही</p>
			</div>
			<div class="label">
				<p>धनराशि</p>
			</div>
		</div>

		<?php $i=1;
			foreach ($pnc_home_visit as $row) { ?>

		<div class="Row">
			<div class="Cell">
				<p><?php echo $i++;?></p>
			</div>
			<div class="Cell">
				<p><?php echo $row->FamilyMemberName;?></p>
			</div>
			<div class="Cell">
				<p><?php echo $row->MotherMCTSID;?></p>
			</div>
			<div class="Cell">
				<p><?php echo $row->VillageName;?></p>
			</div>
			<div class="Cell">
				<p><?php echo $row->child_dob;?></p>
			</div>
			<div class="Cell">
				<p><?php echo $row->place_of_birth;?></p>
			</div>
			<div class="Cell">
				<p><?php echo $row->first;?></p>
			</div>
			<div class="Cell">
				<p><?php echo $row->second;?></p>
			</div>
			<div class="Cell">
				<p><?php echo $row->third;?></p>
			</div>
			<div class="Cell">
				<p><?php echo $row->fourth;?></p>
			</div>
			<div class="Cell">
				<p><?php echo $row->fifth;?></p>
			</div>
			<div class="Cell">
				<p><?php echo $row->sixth;?></p>
			</div>
			<div class="Cell">
				<p><?php echo $row->sevemth;?></p>
			</div>
			<div class="Cell">
				<p></p>
			</div>
			<div class="Cell">
				<p></p>
			</div>
		</div>
		<?php } ?>
	</div><br>
	
	<div class="row">
		<div class="col-md-4">
			<p>*यदि हाँ तो 250रू0 की धनराशि अाशा को प्रदान करे</p>
		</div>
	</div><br>
	<div class="row">
		<div class="col-md-4">
			<p> अाशा फेसिलिटेटर का हस्ता0</p>
		</div>
		<div class="col-md-4">
			<p>ए0एन0एम0 का हस्ता0</p>
		</div>
		<div class="col-md-4">
			<p>ब्लाकॅ काॅडिॆनेटर</p>
		</div>
	</div>
</div>
</body>
</html>
