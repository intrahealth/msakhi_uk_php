<style>
	.link_row
	{
		cursor: pointer;
	}
</style>
<section id="content">
	<div class="panel">
		<div class="panel-heading">
			<h4 class="panel-title text-center"><?php echo $indicator_name; ?></h4>
		</div>
		<div class="panel-body">
			<table class="table table-striped table-bordered table-hover">
				<tr>
					<th>S.no</th>
					<th>Beneficiary Name</th>
				</tr>
				<tbody>
					<?php 
					$sno = 1;
					foreach ($ben_list as $ben) {
						// print_r($ben_list); die();
						?>
						<tr>
								<td><?php echo $sno; ?></td>
								<td><?php echo $ben->PWName; ?></td>
							</tr>
							<?php 
							$sno++;
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</section>
