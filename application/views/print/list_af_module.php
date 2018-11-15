

<center style="background-color: rgb(242,190,0); color: white;">

	<img src="<?php echo $_SERVER["DOCUMENT_ROOT"] . '/common_libs/img/msakhi_logo.png';?>" alt="Msakhi Logo" height="100" width="100">
	<h2>Msakhi (Uttrakhand)</h2>

</center>

<h2 style="background-color: #f5f5f5;">
	<b>Af Module List</b>
</h2>					

<table width="100%" height="100%">
	<thead>
		<tr>
			<th style="background-color: #005585; color: white;" class="text-center">Supervisor Code </th>
			<th style="background-color: #005585; color: white;" class="text-center">Supervisor Name	</th>
		</tr>
	</thead>

	<tbody>
		<?php
		if(count($Af_Module_List) > 0){
			foreach($Af_Module_List as $row){ ?>
			<tr>
				<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php echo $row->SupervisorCode; ?></td>
				<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php echo $row->SupervisorName; ?></td>
			</tr>
			<?php } }?>


		</tbody>

	</table>
	<br>

	<center>
		<footer id="footer">
			Copyright &copy; 2012-2017 Intrahealth
		</footer>
	</center>





