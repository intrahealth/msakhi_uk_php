<!DOCTYPE html>
<html lang="en">
<head>	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.min.css">
	<meta charset="utf-8">
	<title>Monthly Asha report 04</title>
</head>
<body>
	<center style="background-color: rgb(242,190,0); color: white;">

		<img src="<?php echo site_url() . '/common_libs/img/msakhi_logo.png';?>" alt="Msakhi Logo" height="50" width="50">
		<h2>Msakhi (Uttrakhand)</h2></center>
		<tr><h4 style="text-align: center; font-weight: bold;" >समूह गतिविधि हेतु</h4></tr>
		<tr><h4 style="text-align: center; font-weight: bold; ">(आशा द्वारा प्रत्येक वर्ष के माह अप्रैल व अक्टूबर मे घरो का सर्वेक्षण के भुगतान हेतु प्रपत्र</h4></tr>
		<table width="100%" height="100%">
			<tr>
				<td style="text-align: center;">आशा का नाम.....<?php echo $asha_data->ASHAName; ?>...</td>
				<td style="text-align: center;">गाँव का नाम....<?php echo $asha_data->Villages;?>...</td>
				<td style="text-align: center;">विकासखण्ड...............</td>
				<td style="text-align: center;">जनपद का नाम..............</td>
			</tr><br>
		</table><br>
		<table width="100%" height="100%">
			<tr>
				<td style="text-align: center;">सी0एच0सी0/पी0एच0सी0 का नाम.............................</td>
				<td style="text-align: center;">उपकेन्द् का नाम.......<?php echo $asha_data->SubCenterName; ?>......</td>
				<td style="text-align: center;">रिपोर्ट का माह व वर्ष....................................</td>
			</tr>
		</table><br>
		<table width="100%" height="100%">
			<tr style="text-align: center;">
				5. घरो का सर्वेक्षण सूची तैयार रखने हेतु
			</tr>
		</table><br>
		<table width="100%" border="1px" height="100%">
			<tr>
				<th rowspan="2" style="text-align: center;">कुल ग्राम सभा</th>
				<th rowspan="2" style="text-align: center;">कुल गाँव</th>
				<th rowspan="2" style="text-align: center;">कुल वी.एच.एस.एन.सी.</th>
				<th rowspan="2" style="text-align: center;">कुल परिवार</th>
				<th colspan="4" style="text-align: center;">धर्म</th>
				<th colspan="5" style="text-align: center;">जाति</th>
				<th colspan="2" style="text-align: center;">मकान का प्रकार</th>
				<th colspan="2" style="text-align: center;">आर्थिक स्थिति</th>
				<th style="text-align: center;">बिजली</th>
				<th style="text-align: center;">पानी</th>
				<th style="text-align: center;">शौचालय</th>
				<th style="text-align: center;">टेलीविजन</th>
				<th style="text-align: center;">गैस की सुविधा</th>
				<th style="text-align: center;">कितने परिवार के पास बैंक खाता है</th>
			</tr>
			<tr>
				
				<th style="text-align: center;">हिंदू</th>
				<th style="text-align: center;">मुस्लिम</th>
				<th style="text-align: center;">इसाई</th>
				<th style="text-align: center;">अन्य</th>
				<th style="text-align: center;">सामान्य</th>
				<th style="text-align: center;">अनु जाति</th>
				<th style="text-align: center;">अनु जन जाति</th>
				<th style="text-align: center;">पिछड़ा वर्ग</th>
				<th style="text-align: center;">अन्य</th>
				<th style="text-align: center;">कच्चा मकान</th>
				<th style="text-align: center;">पक्का मकान</th>
				<th style="text-align: center;">बीपीएल</th>
				<th style="text-align: center;">एपीएल</th>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td><?php echo $village_count->total; ?></td>
				<td></td>
				<td><?php echo $household_count->total; ?></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td><?php echo $cast_id->sc; ?></td>
				<td><?php echo $cast_id->st; ?></td>
				<td><?php echo $cast_id->obc; ?></td>
				<td><?php echo $cast_id->other; ?></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>



			<tr>
				<th colspan="5" style="text-align: center;">पिछले छ माह तक लक्ष्य दम्पति</th>
				<th colspan="3" style="text-align: center;">कुल नये आने वाले लक्ष्य दम्पति</th>
				<th colspan="3" style="text-align: center;">विस्थापित लक्ष्य दम्पति</th>
				<th colspan="3" style="text-align: center;">लक्ष्य दम्पति की मृत्यु</th>
				<th colspan="3" style="text-align: center;">49 वर्ष से अधिक आयु के लक्ष्य दम्पति</th>
				<th colspan="3" style="text-align: center;">कुल लक्ष्य दम्पति की सख्या 15 वर्ष से 49 वर्ष</th>
				<th colspan="3" style="text-align: center;">कुल मृत्यु</th>

			</tr>
			<tr>
				<td colspan="5">-</td>
				<td colspan="3">-</td>
				<td colspan="3">-</td>
				<td colspan="3">-</td>
				<td colspan="3">-</td>
				<td colspan="3">-</td>
				<td colspan="3">-</td>

			</tr>
		</table><br><br>
		<table width="100%" height="100%" border="1px">
			<tr>
				<th colspan="3" style="text-align: center;">कुल जनसंख्या</th>
				<th colspan="2" style="text-align: center;">0 से 1 साल</th>
				<th colspan="2" style="text-align: center;">1 से 2 साल</th>
				<th colspan="2" style="text-align: center;">2 से 5 साल</th>
				<th colspan="2" style="text-align: center;">5 से 10 साल</th>
				<th colspan="2" style="text-align: center;">10 से 19 साल</th>
				<th colspan="2" style="text-align: center;">19 से 60 साल</th>
				<th colspan="2" style="text-align: center;">60 से ऊपर साल</th>
			</tr>
			<tr>
				<th style="text-align: center;">कुल</th>
				<th style="text-align: center;">पुरुष</th>
				<th style="text-align: center; ">महिला</th>
				<th style="text-align: center;">पुरुष</th>
				<th style="text-align: center;">महिला</th>
				<th style="text-align: center;">पुरुष</th>
				<th style="text-align: center;">महिला</th>
				<th style="text-align: center;">पुरुष</th>
				<th style="text-align: center;">महिला</th>
				<th style="text-align: center;">पुरुष</th>
				<th style="text-align: center;">महिला</th>
				<th style="text-align: center;">पुरुष</th>
				<th style="text-align: center;">महिला</th>
				<th style="text-align: center;">पुरुष</th>
				<th style="text-align: center;">महिला</th>
				<th style="text-align: center;">पुरुष</th>
				<th style="text-align: center;">महिला</th>
			</tr>
			<tr>
				<td><?php  echo $total_members->total; ?></td>
				<td><?php  echo $total_members->male; ?></td>
				<td><?php  echo $total_members->female; ?></td>
				<td><?php echo $total_population_zero_to_one->male; ?></td>
				<td><?php echo $total_population_zero_to_one->female; ?></td>
				<td><?php echo $total_population_one_to_two->male;?></td>
				<td><?php echo $total_population_one_to_two->female;?></td>
				<td><?php echo $total_population_two_to_five->male; ?></td>
				<td><?php echo $total_population_two_to_five->female; ?></td>
				<td><?php echo $total_population_five_to_ten->male; ?></td>
				<td><?php echo $total_population_five_to_ten->female; ?></td>
				<td><?php echo $total_population_ten_to_ninteen->male;?></td>
				<td><?php echo $total_population_ten_to_ninteen->female;?></td>
				<td><?php echo $total_population_ninteen_to_sixty->male; ?></td>
				<td><?php echo $total_population_ninteen_to_sixty->female;?></td>
				<td><?php echo $total_population_sixty_and_more->male;?></td>
				<td><?php echo $total_population_sixty_and_more->female;?></td>
			</tr>
		</table><br><br>
		<table width="100%" height="100%">
			<tr>
				<td>हस्ता0 आाशा..........................</td>
				<td>हस्ता0 ए0एन0एम0.........................</td>
				<td>हस्ता0 ए0एफ0............................</td>
				<td>हस्ता0 बी0सी0...............................</td>
				<td>हस्ता0 बी0पी0 एम0.............................</td>
			</tr>
		</table>
	</body>
	</html>