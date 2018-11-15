

<center style="background-color: rgb(242,190,0); color: white;">

	<img src="<?php echo $_SERVER["DOCUMENT_ROOT"] . '/common_libs/img/msakhi_logo.png';?>" alt="Msakhi Logo" height="100" width="100">
	<h2>Msakhi (Uttrakhand)</h2>

</center>

<h2 style="background-color: #f5f5f5;" class="text-center">
	<b>User List</b>
</h2>					

<table width="100%" height="100%">
	<thead>
		<tr>

			<th style="background-color: #005585; color: white;" class="text-center">User ID</th>
			<th style="background-color: #005585; color: white;" class="text-center">User Name</th>
			<th style="background-color: #005585; color: white;" class="text-center">First Name</th>
			<th style="background-color: #005585; color: white;" class="text-center">Last Name</th>
			<th style="background-color: #005585; color: white;" class="text-center">Email</th>
			<th style="background-color: #005585; color: white;" class="text-center">User Role</th>

		</tr>		
	</thead>

	<tbody>
		<?php foreach($users_list as $row){ ?>
		<tr>
			<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php echo $row->user_id; ?></td>
			<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php echo $row->user_name; ?></td>
			<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php echo $row->first_name; ?></td>
			<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php echo $row->last_name; ?></td>

			<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php echo $row->email; ?></td>
			<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php echo $row->user_role; ?></td>
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





