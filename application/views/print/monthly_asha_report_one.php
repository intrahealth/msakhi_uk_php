<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Monthly ASHA report 01</title>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.min.css">

</head>
<body>


	<style type="text/css">
	.sbtn{
		float: right;
		margin-right: 193px;
		margin-top: -34px;
		height: 34px;
	}
	.chkb{
		margin-left: 15px;
	}
	.shodo-h2{
		box-shadow: 0 0 10px #ccc;
		padding: 12px;
		font-size: 16px;
	}
	.tablejanpatri{  
		text-align: center;
		padding: 10px;
		border: 1px solid;
	}

</style>


<center style="background-color: rgb(242,190,0); color: white;">

	<img src="<?php echo site_url() . '/common_libs/img/msakhi_logo.png';?>" alt="Msakhi Logo" height="50" width="50">
	<h2>Msakhi (Uttrakhand)</h2>

</center>

<h2 style="background-color: #f5f5f5; text-align: center;">
	<b>समूह गतिविधि आशा का भुगतान प्रपत्र <br>
		आशा द्वारा प्रत्येक माह जमा किया जाने वाला प्रपत्र &nbsp
	</small></b>
</h2>

<table width="100%" height="100%">

	<tr>
		<td>आशा का नाम_ _ _ _<?php echo $asha_data->ASHAName; ?>_ _ _ _</td>
		<td>गॉव  का नाम _ _ _ _<?php echo $asha_data->Villages;?> _ _ _ _</td>
		<td>विकासखण्ड _ _ _ _ _ _ _ _ _ _ _ _</td>
		<td>जनपद _ _ _ _ _ _ _ _ _ _ _ _ _ _</td>
	</tr>
</table>

<tr><br></tr>

<table width="100%" height="100%">	
	<tr>
		<td>सी0एच0सी0/पी0एच0सी0 का नाम _ _ _ _ _ _ _ _ _ _ _ _</td>
		<td>उपकेन्द्र का नाम _ _ _ _<?php echo $asha_data->SubCenterName; ?> _ _ _ _</td>
		<td>रिपोर्ट का माह व  सत्र_ _ _ _ _ _ _ _ _ _ _ _</td>
	</tr>
</table>

<tr><br></tr>

<table width="100%" height="100%">

	<tr>
		<td>1. ग्राम स्तर पर ग्राम स्वास्थ्य पजका एवं जन्म और मत्य का सपोर्टिग निर्तमाल पंजिकरण का रखरखाव हेतु।।
		</td>
	</tr>

</table>

<tr><br></tr>

<table>

	<tr>
		<td>जन्म पंजीकरण	</td>
	</tr>
	
</table>


<table border="1" width="100%" height="100%">
	<!-- <thead> -->

		<tr>			
			<th colspan="4"> जन्म का पंजीकरण</th>
			<th rowspan="2">जन्म का स्थान (घर पर/अस्पताल)</th>
			<!-- <th rowspan="1"></th> -->
			<tr>
				<th>शिशु का नाम</th>
				<th>माँ का नाम</th>
				<th>लिंग</th>
				<th>जन्म की तिथि</th>
			</tr>

		</tr>
		<!-- </thead> -->

		<tbody>
			<?php foreach ($child_data as $row) { ?>
				<tr>

					<td><?php echo $row->child_name;?></td>
					<td><?php echo $row->PWName;?></td>
					<td><?php echo $row->Gender;?></td>
					<td><?php echo $row->child_dob;?></td>
					<td><?php echo $row->place_of_birth;?></td>
					
				</tr>
			<?php } ?>       
		</tbody>

		<tbody>
			<tr>

				<td>-</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>   
		</tbody>
	</table>

	<tr><br></tr>

	<table>

		<tr>
			<td>माँ व शिशु मृत्यु पञ्जीकरण (42 दिन के अन्दर माता एवं शिशु मृत्य का पजिकरण)</td>
		</tr>
		
	</table>


	<table border="1" width="100%" height="100%">

		<!-- <thead> -->
			<tr>
				<th>मृतक का नाम</th>
				<th>उम्र</th>
				<th>लिंग</th>
				<th>माता/पति का नाम</th>
				<th>गाँव का नाम</th>
				<th>मृत्यु का कारण</th>
				<th>दिनांक/ माह/वर्ष</th>
				<th>मृत्यु का स्थान</th>
			</tr>
			<!-- </thead> -->

			<tbody>
				<?php foreach ($status_name as $raw) { ?>
					<tr>
						<td><?php echo $raw->name;?></td>
						<td><?php echo $raw->age;?></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>

					</tr>
				<?php } ?>
			</tbody>
			<tbody>
				<tr>
					<td>-</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
			</tbody>

		</table>

		<tr><br></tr>

		<table>


			<tr>
				<td>मृत्यु पजीकरण (माँ व शिशु की 42 दिन के अन्दर होने वाली मृत्यु को छोडकर अन्य सभी प्रकार की मृत्यु)</td>
			</tr>
			
		</table>


		<table border="1" width="100%" height="100%">
			<!-- <thead> -->
				<tr>
					<th>नाम</th>
					<th>उम्र</th>
					<th>लिंग</th>
					<th>गाँव का नाम</th>
					<th>मृत्यु का कारण</th>
					<th>दिनांक/ माह/वर्ष</th>
					<th>मृत्यु का स्थान</th>

				</tr>
				<!-- </thead> -->

				<tbody>
					<?php foreach ($status_name as $raw) { ?>
						<tr>
							<td><?php echo $raw->name;?></td>
							<td><?php echo $raw->age;?></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
					<?php } ?>
				</tbody>

				<tbody>
					<tr>
						<td>-</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
				</tbody>

			</table>
			<tr><br></tr>

			<table>

				<tr>
					<td>2.बच्चों की टीकाकरण सूची तैयार करने हेतु।।</td>
				</tr>
				
			</table>

			<table border="1" width="100%" height="100%">
				<!-- <thead> -->
					<tr>
						<th>कुल  बच्चे(0-1)</th>
						<th>बी 0  सी 0 जी 0  ओ 0 पी 0 वी </th>
						<th>डीपीटी व ओ0पी0 वी 1</th>
						<th>डीपीटी  व  ओ 0 पी 0 वी 0  2 </th>
						<th>डीपीटी  व  ओ 0 पी 0 वी 0  3</th>
						<th>पेंटावेलन्ट ओ 0 पी 0 वी 0 1</th>
						<th>पेंटावेलन्ट ओ 0 पी 0 वी 0 2</th>
						<th>पेंटावेलन्ट ओ 0 पी 0 वी 0 3</th>
						<th> मीजल्स पूर्ण टीकाकरण</th>
						<th>कुल  बच्चे  1 -2 वर्ष </th>
						<th>डीपीटी ,बूस्टर -ओ 0 पी 0 बी 0 </th>
						<th>मीजल्स</th>			
					</tr>
					<!-- </thead> -->
					<tbody>
						<tr>
							<td><?php echo $child_count->total;?></td>
							<td><?php echo $child_bcg_opv1->total;?></td>
							<td><?php echo $child_dpt1_opv2->total;?></td>
							<td><?php echo $child_dpt2_opv3->total;?></td>
							<td><?php echo $child_dpt3_opv4->total;?></td>
							<td><?php echo $child_pentavalent1_opv2->total;?></td>
							<td><?php echo $child_pentavalent2_opv3->total;?></td>
							<td><?php echo $child_pentavalent3_opv4->total;?></td>
							<td><?php echo $child_measels_allimmunization->total;?></td>
							<td><?php echo $child_1_2->total;?></td>
							<td><?php echo $dpt_opv_booster->total;?></td>
							<td><?php echo $child_1_2_measeles->total;?></td>
						</tr>
					</tbody>
				</table>

				<tr><br></tr>

				<table>

					<tr>
						<td>3. गर्भवती महिलाओं की सूची तैयार रखने हेतु।।</td>
					</tr>
					
				</table>

				<table border="1" width="100%" height="100%">
					<!-- <thead> -->
						<tr>
							<th>कुल गर्भवती</th>
							<th>पहली  जांच </th>
							<th>दूसरी  जांच</th>
							<th>तीसरी  जांच</th>
							<th>चौथी  जांच</th>
							<th>कुल  महिलायें  जिन्हे  आयरन  की  गोली  दी  जानी  है |</th>
							<th>जांच  न  करने  का  कारण</th>		
						</tr>		
						<!-- </thead> -->
						<tbody>
							<tr>
								<td><?php echo $totalpregnentwomen->total;?></td>
								<td><?php echo $totalpregnentwomen_0_3->total;?></td>
								<td><?php echo $totalpregnentwomen_3_6->total;?></td>
								<td><?php echo $totalpregnentwomen_7_8->total;?></td>
								<td><?php echo $totalpregnentwomen_8_9->total;?></td>
								<td></td>
								<td></td>
							</tr>
						</tbody>
					</table>

					<tr><br></tr>

					<table>

						<tr>
							<td>4. लक्ष्य दम्पति की सूची तैयार रखने हेतु।।</td>
						</tr>
						
					</table>

					<table border="1" width="100%" height="100%">
						<!-- <thead> -->
							<tr>
								<th>कुल लक्ष्य दम्पति  15 से 49 वर्ष</th>
								<th>कोन्डोम उपयोग दम्पति</th>
								<th>माला एन0 उपयोग दम्पति</th>
								<th>शादी के दो  साल तक अन्तराल वाले दम्पति</th>
								<th>दो बच्चों में अन्तराल  रखने वाले  दम्पाती </th>
								<th>दो बच्चों के बढ़ नसबन्द करने वाले दम्पाती </th>
								<th>कुल गर्भवती जिसे पीपीआयूसीडी  पर  सलाह वाले  दम्पाती </th>	
								<th>कापर -टी  वाले  दम्पती</th>
								<th> अन्य जो परिवार नियोजन  हेतु अपनी सेवा नहीं ले चुके हैं।</th>
							</tr>
							<!-- </thead> -->
							<tbody>
								<tr>
									<td>-</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
							</tbody>
						</table>

						<tr><br></tr>
						<tr><br></tr>
						<tr><br></tr>
						<tr><br></tr>
						<tr><br></tr>
						<tr><br></tr>
						<tr><br></tr>

						<table width="100%" height="100%">

							<tr>
								<td>हस्ताo आशा.............</td>
								<td>हस्ताo ए0एन0एम0..................</td>
								<td>हस्ताo ए0एफ0.................</td>
								<td>हस्ता०बी०सी०....................</td>
								<td>हस्त बी०पी०एम०...................</td>
							</tr>

						</table>


					</body>
					</html>