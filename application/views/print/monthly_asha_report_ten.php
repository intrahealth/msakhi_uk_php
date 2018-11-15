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
	<thead style="font-style: bold; font-size: 18px;">
	<tr>
		<th>ID</th>
		<th>Child Name</th>
		<th>BCG</th>
		<th>OPV1/Penta1</th>
		<th>OPV2/Penta2</th>
		<th>OPV3/Penta3</th>
		<th>Measles</th>
		<th>Vita1</th>
		<th>Measl Booster</th>
		<th>MR Veci</th>
	</tr>
	</thead>

	<tbody>
			
			<?php $i=1;
			foreach ($RCH_immunization as $row) { ?>

			<tr>
			<td></td>
			<td><?php echo $row->child_name;?></td>
			<td><?php echo $row->bcg;?></td>
			<td><?php echo $row->opv1;?>/<?php echo $row->Pentavalent1;?></td>
			<td><?php echo $row->opv2;?>/<?php echo $row->Pentavalent2;?></td>
			<td><?php echo $row->opv3;?>/<?php echo $row->Pentavalent3;?></td>
			<td><?php echo $row->measeals;?></td>
			<td><?php echo $row->vitaminA;?></td>
			<td></td>
			<td><?php echo $row->MeaslesRubella;?></td>
			
			
		</tr>

			<?php } ?>
		</tbody>
</table>
</body>
</html>