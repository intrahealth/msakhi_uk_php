<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.min.css">
	<meta charset="utf-8">
</head>
<body>
	<center style="background-color: rgb(242,190,0); color: white;">

		<img src="<?php echo site_url() . '/common_libs/img/msakhi_logo.png';?>" alt="Msakhi Logo" height="50" width="50">
		<h2>Msakhi (Uttrakhand)</h2></center>
<table height="100%" width="100%">
	<h4 style="text-align: center;">उपकेन्द्र पदमपुर</h4>
</table>
<table height="100%" width="100%" border="1px">
	<thead>
	<tr>
		<th>क्र.सं.</th>
		<th>आईoडीoनo</th>
		<th>लाभार्थी का नाम</th>
		<th>पति का नाम</th>
		<th>पता</th>
		<th>मोबाइल न0</th>
		<th>आयु</th>
		<th>जाति</th>
		<th>एलoएमoपी 0</th>
		<th>ए0एन0सी0-1 पंजीकरण सहित</th>
		<th>प्रसव का स्थान</th>
		<th>आशा का नाम</th>
		<th>मोबाइल न0</th>
	</tr>
	</thead>
	<tbody>
		<?php $i = 1;
		foreach ($preg_details as $row) { ?>
	<tr>
		<td><?php echo $i++; ?></td>
		<td><?php echo $row->MotherMCTSID;?></td>
		<td><?php echo $row->PWName;?></td>
		<td><?php echo $row->HusbandName;?></td>
		<td><?php echo $row->VillageName;?></td>
		<td><?php echo $row->MobileNo;?></td>
		<td></td>
		<td><?php echo $row->CasteID;?></td>
		<td><?php echo $row->LMPDate;?></td>
		<td><?php echo $row->visit1;?></td>
		<td><?php echo $row->DeliveryPlace;?></td>
		<td><?php echo $row->ASHAName;?></td>
		<td><?php echo $row->phone_no;?></td>
	</tr>
	<?php } ?>
	</tbody>
</table>
</body>
</html>