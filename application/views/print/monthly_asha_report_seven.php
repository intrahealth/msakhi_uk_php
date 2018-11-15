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
<table height="100%" width="100%" border="1px">
	<tr>
		<th rowspan="2">ए0एन0सी0-2</th>
		<th rowspan="2">ए0एन0सी0-3</th>
		<th rowspan="2">ए0एन0सी0-4</th>
		<th rowspan="2">ट0टी0-1 गर्भ का पता चलने के तुरन्त बाद</th>
		<th rowspan="2">ट0टी0-1 ट0टी0-2 के एक माह बाद</th>
		<th rowspan="2">ट0टी0 बूसटर</th>
		<th rowspan="2">आई0एफ0ए0 दिंनाक जिस दिन 100 आई0एफ0ए0 टै0 दी गई</th>
		<th rowspan="2">एनीमिया(Moderate<11/Server<7/Normal</th>
		<th rowspan="2">प्रसव का दिंनाक</th>
		<th rowspan="2">प्रसव का स्थान अवासीय या संस्थागत</th>
		<th rowspan="2">प्रसव का प्रकार सामान्य/सीजेरियन/औजार के प्रयोग से</th>
		<th rowspan="2">डिस्चार्ज का दिंनाक</th>
		<th colspan="3">बच्चे का विवरण</th>
		<th rowspan="2">क्र.सं.</th>
		<th rowspan="2" >आई0डी0न0</th>
		<th rowspan="2">ग्राम पंचायत/गाँव</th>
	</tr>
	<tr>
		
		<th>नाम</th>
		<th> लिंग </th>
		<th>वजन</th>
		

	</tr>
	<tr>
		<tbody>
		<?php $i = 1;
		foreach ($preg_details as $row) { ?>

		<td><?php echo $row->visit2;?></td>
		<td><?php echo $row->visit3;?></td>
		<td><?php echo $row->visit4;?></td>
		<td><?php echo $row->TTfirstDoseDate;?></td>
		<td><?php echo $row->TTsecondDoseDate;?></td>
		<td><?php echo $row->TTboosterDate;?></td>
		<td>-</td>
		<td>-</td>
		<td><?php echo $row->DeliveryDateTime;?></td>
		<td><?php echo $row->place_of_birth;?></td>
		<td><?php echo $row->DeliveryType;?></td>
		<td>-</td>
		<td><?php echo $row->child_name;?></td>
		<td><?php echo $row->Gender;?></td>
		<td><?php echo $row->Wt_of_child;?></td>
		<td><?php echo $i++; ?></td>
		<td>-</td>
		<td><?php echo $row->VillageName;?></td>
	</tr>
	<?php } ?>
	</tbody>
</table>
</body>
</html>