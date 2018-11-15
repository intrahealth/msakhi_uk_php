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
<section id="content">
	<?php foreach ($role_permission as $row) { if ($row->Controller == "monthly_asha_report" && $row->Action == "monthly_asha_report_1"){ ?>
	<div class="block-header">
		<h2>Manage Monthly asha report</h2>
	</div>
	<?php 
	$tr_msg= $this->session->flashdata('tr_msg');
	$er_msg= $this->session->flashdata('er_msg');
	if(!empty($tr_msg)){ ?>
	<div class="content animate-panel">
		<div class="row">
			<div class="col-md-12">
				<div class="hpanel">
					<div class="alert alert-success alert-dismissable alert1"> <i class="fa fa-check"></i>
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<?php echo $this->session->flashdata('tr_msg');?>. </div>
					</div>
				</div>
			</div>
		</div>
		<?php } else if(!empty($er_msg)){?>
		<div class="content animate-panel">
			<div class="row">
				<div class="col-md-12">
					<div class="hpanel">
						<div class="alert alert-danger alert-dismissable alert1"> <i class="fa fa-check"></i>
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<?php echo $this->session->flashdata('er_msg');?>. </div>
						</div>
					</div>
				</div>
			</div>
			<?php } ?>
			<!-- Exportable Table -->
			<div class="row clearfix">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="card">
						<div class="card-header" style="text-align: center;">
							<h2><b>समूह गतिविधि आशा का भुगतान प्रपत्र <br><br>
								आशा द्वारा प्रत्येक माह जमा किया जाने वाला प्रपत्र।
							</small></h2>
						</div>
						<div class="body">
							<div class="table-responsive">
								<h1></h1> 
								<div class="col-sm-12 col-md-12">
									<!-- <h2 class="card-inside-title shodo-h2">monthly asha report</h2> -->
									<div class="col-sm-12 col-md-3">
										<span>आशा का नाम</span><span> _ _ _ _ _ _ _ _ _ _ _ _</span>
									</div>										

									<div class="col-sm-12 col-md-3">
										<span>गॉव  का नाम</span><span> _ _ _ _ _ _ _ _ _ _ _ _</span>
									</div>

									<div class="col-sm-12 col-md-3">
										<span>विकासखण्ड</span><span> _ _ _ _ _ _ _ _ _ _ _ _</span>
									</div>
									<div class="col-sm-12 col-md-3">
										<span>जनपद</span><span> _ _ _ _ _ _ _ _ _ _ _ _ _ _</span>
									</div>										
								</div>	
								<br><br>
								<div class="col-sm-12 col-md-12">
									<div class="col-sm-12 col-md-4">
										<span>सी0एच0सी0/पी0एच0सी0 का नाम</span><span> _ _ _ _ _ _ _ _ _ _ _ _</span>
									</div>										

									<div class="col-sm-12 col-md-4">
										<span>उपकेन्द्र का नाम</span><span> _ _ _ _ _ _ _ _ _ _ _ _ _ _</span>
									</div>

									<div class="col-sm-12 col-md-4">
										<span>रिपोर्ट का माह व  सत्र</span><span>_ _ _ _ _ _ _ _ _ _ _ _</span>
									</div>

								</div>	
								<br><br>
								<div class="col-sm-12 col-md-12">
									<div class="col-sm-12 col-md-12">
										1. ग्राम स्तर पर ग्राम स्वास्थ्य पजका एवं जन्म और मत्य का सपोर्टिग निर्तमाल पंजिकरण का रखरखाव हेत।।

										जन्म पंजीकरण		
									</div>
									<br><br>
									<div class="row">
										<div class="col-sm-12 col-md-8">
											<div class="col-sm-12 col-md-12 tablejanpatri">
												जन्म का पंजीकरण
											</div>
											<div class="col-sm-12 col-md-3 tablejanpatri">शिशु का नाम ।</div>
											<div class="col-sm-12 col-md-3 tablejanpatri">माँ का नाम</div>
											<div class="col-sm-12 col-md-3 tablejanpatri">लिंग</div>
											<div class="col-sm-12 col-md-3 tablejanpatri">जन्म की तिथि</div>
										</div>
										<div class="col-sm-12 col-md-4" style="margin-left: -30px;">
											<div class="col-sm-12 col-md-12  tablejanpatri">जन्म का स्थान (घर पर/अस्पताल)</div>
											<div class="col-sm-12 col-md-12  tablejanpatri">.</div>
										</div>
									</div>	
                 <br><br>
									<div class="row">										
										<div class="col-sm-12 col-md-12">
											<br><br>
											माँ व शिशु मृत्यु पञ्जीकरण (42 दिन के अन्दर माता एवं शिशु मृत्य का पजिकरण
										</div>
										<div class="col-sm-12 col-md-12">
											<div class="col-sm-12 col-md-2 tablejanpatri">मृतक का नाम</div>
											<div class="col-sm-12 col-md-1 tablejanpatri">उम्र</div>
											<div class="col-sm-12 col-md-1 tablejanpatri">लिंग</div>
											<div class="col-sm-12 col-md-2 tablejanpatri">माता/पति का नाम</div>
											<div class="col-sm-12 col-md-2 tablejanpatri">गाँव का नाम</div>
											<div class="col-sm-12 col-md-2 tablejanpatri">मृत्यु का कारण</div>
											<div class="col-sm-12 col-md-1 tablejanpatri">दिनांक/ माह/वर्ष</div>
											<div class="col-sm-12 col-md-1 tablejanpatri">मृत्यु का स्थान</div>
										</div>
									</div>
                 <br><br>
									<div class="row">										
										<div class="col-sm-12 col-md-12">
											<br><br>
											मृत्यु पजीकरण (माँ व शिशु की 42 दिन के अन्दर होने वाली मृत्यु को छोडकर अन्य सभी प्रकार की मृत्यु)
										</div>
										<div class="col-sm-12 col-md-12">
											<div class="col-sm-12 col-md-2 tablejanpatri">नाम</div>
											<div class="col-sm-12 col-md-1 tablejanpatri">उम्र</div>
											<div class="col-sm-12 col-md-1 tablejanpatri">लिंग</div>
											<div class="col-sm-12 col-md-2 tablejanpatri">गाँव का नाम</div>
										<div class="col-sm-12 col-md-2 tablejanpatri">मृत्यु का कारण</div>
											<div class="col-sm-12 col-md-2 tablejanpatri">दिनांक/ माह/वर्ष</div>
											<div class="col-sm-12 col-md-2 tablejanpatri">मृत्यु का स्थान</div>
										</div>
									</div>
									<!-- <br><br>
									<div class="row">
										<div class="col-sm-12 col-md-12">
											<div class="col-sm-12 col-md-3">
												<span>हस्ताo आशा</span><span> _ _ _ _ _ _ </span>
											</div>
											<div class="col-sm-12 col-md-3">
												<span>हस्ताo ए0एन0एम0</span><span> _ _ _ _ _ _ </span>
											</div>
											<div class="col-sm-12 col-md-2">
												<span>हस्ताo ए0एफ0</span><span> _ _ _ _ _ _</span>
											</div>
											<div class="col-sm-12 col-md-2">
												<span>हस्ता०बी०सी०.</span><span> _ _ _ _ _ _ </span>
											</div>
											<div class="col-sm-12 col-md-2">
												<span>हस्त बी०पी०एम०</span><span> _ _ _ _ _ </span>
											</div>										
										</div>
									</div> -->
									<br><br>
									<div class="row">										
										<div class="col-sm-12 col-md-12">
											<div class="col-sm-12 col-md-12">
												2.बच्चों की टीकाकरण सूची तैयार करने हेतु									
											</div>
											<br><br>
											<div class="col-sm-12 col-md-12">
												<div class="col-sm-12 col-md-1 tablejanpatri">कुल  बच्चे(0-1)</div>
												<div class="col-sm-12 col-md-1 tablejanpatri">बी 0  सी 0 जी 0  ओ 0 पी 0 वी </div>
												<div class="col-sm-12 col-md-1 tablejanpatri">डीपीटी व ओ0पी0 वी 1</div>
												<div class="col-sm-12 col-md-1 tablejanpatri">डीपीटी  व  ओ 0 पी 0 वी 0  2 </div>
												<div class="col-sm-12 col-md-1 tablejanpatri">डीपीटी  व  ओ 0 पी 0 वी 0  3</div>
												<div class="col-sm-12 col-md-1 tablejanpatri">पेंटावेलन्ट ओ 0 पी 0 वी 0 1</div>
												<div class="col-sm-12 col-md-1 tablejanpatri">पेंटावेलन्ट ओ 0 पी 0 वी 0 2</div>
												<div class="col-sm-12 col-md-1 tablejanpatri">पेंटावेलन्ट ओ 0 पी 0 वी 0 3</div>
												<div class="col-sm-12 col-md-1 tablejanpatri"> मीजल्स पूर्ण टीकाकरण</div>
												<div class="col-sm-12 col-md-1 tablejanpatri">कुल  बच्चे  1 -2 वर्ष </div>
												<div class="col-sm-12 col-md-1 tablejanpatri">डीपीटी ,बूस्टर -ओ 0 पी 0 बी 0 </div>
												<div class="col-sm-12 col-md-1 tablejanpatri">मीजल्स</div>
											</div>
										</div>
									</div>
									<br><br>
									<div class="row">										
										<div class="col-sm-12 col-md-12">
											<div class="col-sm-12 col-md-12">
												3. गर्भवती महिलाओं की सूची तैयार रखने हेतु									
											</div>
											<br><br>
											<div class="col-sm-12 col-md-12">
												<div class="col-sm-12 col-md-2 tablejanpatri">कुल गर्भवती</div>
												<div class="col-sm-12 col-md-1 tablejanpatri">पहली  जांच </div>
												<div class="col-sm-12 col-md-1 tablejanpatri">दूसरी  जांच</div>
												<div class="col-sm-12 col-md-1 tablejanpatri">तीसरी  जांच</div>
												<div class="col-sm-12 col-md-1 tablejanpatri">चौथी  जांच</div>
												<div class="col-sm-12 col-md-2 tablejanpatri">कुल  महिलायें  जिन्हे  आयरन  की  गोली  दी  जानी  है  |</div>
												<div class="col-sm-12 col-md-2 tablejanpatri">जांच  न  करने  का  कारण</div>												
											</div>
										</div>
									</div>
									<br><br>
									<div class="row">										
										<div class="col-sm-12 col-md-12">
											<div class="col-sm-12 col-md-12">
												4. लक्ष्य दम्पति की सूची तैयार रखने हेतु			
											</div>
											<br><br>
											<div class="col-sm-12 col-md-12">
												<div class="col-sm-12 col-md-2 tablejanpatri">कुल लक्ष्य दम्पति  15 से 49 वर्ष</div>
												<div class="col-sm-12 col-md-1 tablejanpatri">कोन्डोम उपयोग दम्पति</div>
												<div class="col-sm-12 col-md-1 tablejanpatri">माला एन0 उपयोग दम्पति</div>
												<div class="col-sm-12 col-md-1 tablejanpatri">शादी के दो  साल तक अन्तराल वाले दम्पति</div>
												<div class="col-sm-12 col-md-1 tablejanpatri">दो बच्चों में अन्तराल  रखने वाले  दम्पाती </div>
												<div class="col-sm-12 col-md-2 tablejanpatri">दो बच्चों के बढ़ नसबन्द करने वाले दम्पाती </div>
												<div class="col-sm-12 col-md-2 tablejanpatri">कुल गर्भवती जिसे पीपीआयूसीडी  पर  सलाह वाले  दम्पाती </div>	
												<div class="col-sm-12 col-md-2 tablejanpatri">कापर -टी  वाले  दम्पती</div>
												<div class="col-sm-12 col-md-2 tablejanpatri"> अन्य जो परिवार नियोजन  हेतु अपनी सेवा नहीं ले चुके हैं।</div>
											</div>
										</div>
									</div>
									<br><br>
									<div class="row">
										<div class="col-sm-12 col-md-12">
											<div class="col-sm-12 col-md-3">
												<span>हस्ताo आशा</span><span> _ _ _ _ _ _ </span>
											</div>
											<div class="col-sm-12 col-md-3">
												<span>हस्ताo ए0एन0एम0</span><span> _ _ _ _ _ _ </span>
											</div>
											<div class="col-sm-12 col-md-2">
												<span>हस्ताo ए0एफ0</span><span> _ _ _ _ _ _</span>
											</div>
											<div class="col-sm-12 col-md-2">
												<span>हस्ता०बी०सी०.</span><span> _ _ _ _ _ _ </span>
											</div>
											<div class="col-sm-12 col-md-2">
												<span>हस्त बी०पी०एम०</span><span> _ _ _ _ _ </span>
											</div>										
										</div>
									</div>
                  <br><br>

								</div>
							</div>
						</div>
						<?php } } ?>
						<!-- #END# Exportable Table -->
					</section>
