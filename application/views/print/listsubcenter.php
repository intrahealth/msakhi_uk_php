

<center style="background-color: rgb(242,190,0); color: white;">

	<img src="<?php echo $_SERVER["DOCUMENT_ROOT"] . '/common_libs/img/msakhi_logo.png';?>" alt="Msakhi Logo" height="100" width="100">
	<h2>Msakhi (Uttrakhand)</h2>

</center>

<h2 style="background-color: #f5f5f5;" class="text-center">
	<b>Sub District List</b>
</h2>					

<table width="100%" height="100%">
	<thead>
		<tr>
			<th style="background-color: #005585; color: white;" class="text-center">Subcenter UID</th>
			<th style="background-color: #005585; color: white;" class="text-center">SubCenter ID</th>
			<th style="background-color: #005585; color: white;" class="text-center">SubCenter Code</th>
			<th style="background-color: #005585; color: white;" class="text-center">SubCenter Name</th>
			<th style="background-color: #005585; color: white;" class="text-center">Language</th>			
		</tr>		
	</thead>

	<tbody>
	<?php foreach($Subcenter_list as $row){ ?>
						<tr>
							<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php echo $row->SubCenterUID; ?></td>
							<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php echo $row->SubCenterID; ?></td>
							<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php echo $row->SubCenterCode; ?></td>
							<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php echo $row->SubCenterName; ?></td>
							<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php echo $row->LanguageID; ?></td>
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





