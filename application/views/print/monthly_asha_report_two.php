<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Monthly ASHA report 01</title>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.min.css">

</head>
<body>
	
	<center style="background-color: rgb(242,190,0); color: white;">

		<img src="<?php echo site_url() . '/common_libs/img/msakhi_logo.png';?>" alt="Msakhi Logo" height="50" width="50">
		<h2>Msakhi (Uttrakhand)</h2>

	</center>

	<tr><h4 style="text-align: center; font-weight: bold;">पूर्ण प्रतिरक्षण रिपोर्ट</h4></tr><br>
	<table width="100%" height="100%">
		<tr>
			<td>उपकेन्द् का नाम.......<?php echo $asha_data->SubCenterName; ?>.....</td>
			<td>प्रा0स्वा0 केंद्र दुगडडा..........................</td>
			<td>वर्ष.......................................</td>
		</tr>
	</table><br>
	<table width="100%" height="100%">
		<tr>
			<td>आशा का नाम.......<?php echo $asha_data->ASHAName; ?>........</td>
			<td>खाता संख्या.......................................................</td>
			<td>बैंक का नाम.............................................</td>
		</tr>
	</table><br>
	<table width="100%" height="100%" border="1px">
		
		<tr>
			<th rowspan="2">क्र.सं.</th>
			<th rowspan="2" style="text-align: center;">माता का नाम आई.डी. सहित</th>
			<th rowspan="2" style="text-align: center;">बच्चे का नाम आई.डी. सहित</th>
			<th rowspan="2" style="text-align: center;">जन्मतिथि</th>
			<th rowspan="2" style="text-align: center;">गाँव का नाम</th>
			<th rowspan="2" style="text-align: center;">Zero पोलियो</th>
			<th rowspan="2" style="text-align: center;">B.C.G की तिथि</th>
			<th colspan="3" style="text-align: center;">DPT  की तिथि</th>
			<th colspan="3" style="text-align: center;">Polio</th>
			<th rowspan="2" style="text-align: center;">मिजिल्स(खसरा) </th>
			<th rowspan="2" style="text-align: center;">विटामिन A</th>
			<th rowspan="2" style="text-align: center;">मिजिल्स बूसटर</th>

		</tr>
		
		<tr>

			<th style="text-align: center;">I</th>
			<th style="text-align: center;">II</th>
			<th style="text-align: center;">III</th>
			<th style="text-align: center;">I</th>
			<th style="text-align: center;">II</th>
			<th style="text-align: center;">III</th>
			
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
					<td><?php echo $row->bcg;?></td>
					<td><?php echo $row->dpt1;?></td>
					<td><?php echo $row->dpt2;?></td>
					<td><?php echo $row->dpt3;?></td>
					<td><?php echo $row->opv2;?></td>
					<td><?php echo $row->opv3;?></td>
					<td><?php echo $row->opv4;?></td>
					<td><?php echo $row->measeals;?></td>
					<td><?php echo $row->vitaminA;?></td>
					<td><?php echo $row->MeaslesRubella;?></td>
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