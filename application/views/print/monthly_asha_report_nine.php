<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
	<center style="background-color: rgb(242,190,0); color: white;">

		<img src="<?php echo site_url() . '/common_libs/img/msakhi_logo.png';?>" alt="Msakhi Logo" height="50" width="50">
		<h2>Msakhi (Uttrakhand)</h2>

	</center>
	<tr><h4 style="text-align: center; font-weight: bold;">पूर्ण प्रतिरक्षण रिपोर्ट</h4></tr><br>
	<table width="100%" height="100%">
		<tr>
			<td>उपकेन्द् का नाम......<?php echo $asha_data->SubCenterName; ?>......</td>
			<td>प्रा0स्वा0 केंद्र दुगडडा..........................</td>
			<td>वर्ष.......................................</td>
		</tr>
	</table><br>
	<table width="100%" height="100%">
		<tr>
			<td>आशा का नाम......<?php echo $asha_data->ASHAName; ?>.....</td>
			<td>खाता संख्या.......................................................</td>
			<td>बैंक का नाम.............................................</td>
		</tr>
	</table><br>
	<table width="100%" height="100%" border="1px">
		<tr>
			<th >क्र.सं.</th>
			<th  style="text-align: center;">माता का नाम आई.डी. सहित</th>
			<th  style="text-align: center;">बच्चे का नाम आई.डी. सहित</th>
			<th  style="text-align: center;">जन्मतिथि</th>
			<th  style="text-align: center;">गाँव का नाम</th>
			<th  style="text-align: center;">Zero पोलियो</th>
			<th  style="text-align: center;">मिजिल्स(खसरा) </th>
			<th  style="text-align: center;">विटामिन A</th>
			<th  style="text-align: center;">मिजिल्स बूसटर</th>
			<th  style="text-align: center;">मिजिल्स(खसरा) बूसटर की धनराशि@50रू0प्रति</th>
			
		</tr>
		<tbody>
			
			<?php $i=1;
			foreach ($full_immunization as $row) { ?>
		<tr>
			<td><?php echo $i++;?></td>
			<td><?php echo $row->FamilyMemberName;?></td>
			<td><?php echo $row->child_name;?></td>
			<td><?php echo $row->child_dob;?></td>
			<td><?php echo $row->VillageName;?></td>
			<td><?php echo $row->opv1;?></td>
			<td><?php echo $row->measeals;?></td>
			<td><?php echo $row->vitaminA;?></td>
			<td><?php echo $row->MeaslesRubella;?></td>
			<td></td>
			
		</tr>

			<?php } ?>
		</tbody>
	</table><br><br>
	<table width="100%" height="100%">
		<tr>
			<td>आशा का नाम..................</td>
			<td>आशा फेसिलिटेटर का नाम........................</td>
			<td>ए0एन0एम0 का नाम...............................</td>
		</tr>
	</table><br>
	<table width="100%" height="100%">
		<tr>
			<td>हस्ताक्षर......................................</td>
			<td>हस्ताक्षर.........................................</td>
			<td>हस्ताक्षर.........................................</td>
		</tr>
	</table>
</body>
</html>