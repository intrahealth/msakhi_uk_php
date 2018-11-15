

<center style="background-color: rgb(242,190,0); color: white;">

	<img src="<?php echo $_SERVER["DOCUMENT_ROOT"] . '/common_libs/img/msakhi_logo.png';?>" alt="Msakhi Logo" height="100" width="100">
	<h2>Msakhi (Uttrakhand)</h2>

</center>

<h2 style="background-color: #f5f5f5;">
	<b>Track Changes</b>
</h2>					

<table width="100%" height="100%">

			<thead>
							<tr>
								<th style="background-color: #005585; color: white;" class="text-center" data-column-id="daterow" data-sortable="true" data-order="desc">Date</th>
								<th  style="background-color: #005585; color: white;" class="text-center" data-column-id="household_created">Household/Member</th>
								<th style="background-color: #005585; color: white;" class="text-center" data-column-id="household_uploaded">Household Update/Member Update</th>
								<th style="background-color: #005585; color: white;" class="text-center" data-column-id="preg_woman_registered">Pregnant Woman Register</th>
								<th style="background-color: #005585; color: white;" class="text-center" data-column-id="anc_checkup">ANC CheckUp</th>
								<th style="background-color: #005585; color: white;" class="text-center" data-column-id="anc_visit">ANC Visit</th>
								<th style="background-color: #005585; color: white;" class="text-center" data-column-id="delivery_outcome">Delivery Outcome</th>
								<th style="background-color: #005585; color: white;" class="text-center" data-column-id="hbnc">HBNC</th>
							</tr>
						</thead>


			<tbody>
							<?php foreach($Track_List as $row){ ?>
							<tr>			
								<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php echo $row->daterow;?></td>	
								<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php echo $row->household_created . ' / ' . $row->familymember_created ;?></td> 
								<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php echo $row->household_uploaded. ' / '. $row->familymember_uploaded;?></td>						
								<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php echo $row->preg_woman_registered;?></td>						
								<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php echo $row->anc_checkup;?></td>	
								<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php echo $row->anc_visit;?></td>		
								<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php echo $row->delivery_outcome;?></td>			
								<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php echo $row->hbnc;?></td>			
							</tr>
							<?php } ?>
						</tbody>



	</table>
	<br>

	<center>
		<footer id="footer">
			Copyright &copy; 2012-2017 Intrahealth
		</footer>
	</center>





