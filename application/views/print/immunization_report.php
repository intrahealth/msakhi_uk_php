

<center style="background-color: rgb(242,190,0); color: white;">

	<img src="<?php echo $_SERVER["DOCUMENT_ROOT"] . '/common_libs/img/msakhi_logo.png';?>" alt="Msakhi Logo" height="100" width="100">
	<h2>Msakhi (Uttrakhand)</h2>

</center>

<h2 style="background-color: #f5f5f5;">
	<b>Immunization Report</b>
</h2>					

<table width="100%" height="100%">
	<thead>
		<tr>
			<th style="background-color: #005585; color: white;" class="text-center">
				<b>Indicator</b>
			</th>
			<th style="background-color: #005585; color: white;" class="text-center">
				<b>Administered on due date</b>
			</th>
			<th style="background-color: #005585; color: white;" class="text-center">
				<b>Administered within 15 days of actual due date</b>
			</th>
			<th style="background-color: #005585; color: white;" class="text-center">
				<b>Administered within 30 days of actual due date</b>
			</th>
			<th style="background-color: #005585; color: white;" class="text-center">
				<b>Administered after 30 days of actual due date</b>
			</th>
		</tr>		

	</thead>


	<tbody>

		<?php foreach ($immunization_summary as $key=>$irow) { 
                // print_r($irow); die();
			?>
			<tr>
				<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php echo $irow[0]['label'];?></td>
				<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php echo $irow[0]['value'] . '/' . $irow[0]['total'] . '(' . $irow[0]['proportion'] . '%)';?></td>
				<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php echo $irow[1]['value'] . '/' . $irow[1]['total'] . '(' . $irow[1]['proportion'] . '%)';?></td>
				<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php echo $irow[2]['value'] . '/' . $irow[2]['total'] . '(' . $irow[2]['proportion'] . '%)';?></td>
				<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php echo $irow[3]['value'] . '/' . $irow[3]['total'] . '(' . $irow[3]['proportion'] . '%)';?></td>
				<th></th>
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





