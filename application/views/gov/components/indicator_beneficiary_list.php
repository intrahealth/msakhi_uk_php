<style>
	.link_row
	{
		cursor: pointer;
	}
</style>
<section id="content">
	<div class="panel">

		<div class="panel-heading">

			<a href="<?php echo site_url("gov/indicator_beneficiary_list/$indicator/ASHAID/export_pdf");?>" class="pull-right hvr-pulse-grow" id="btn-Preview-Image" data-toggle="tooltip" title="Export PDF">
				<i class="fa fa-2x fa-file-pdf-o" id="" name="" style="color: #cc3300; cursor: pointer; margin-right: 20px;" onclick="csv()"></i>
			</a>

			<a href="<?php echo site_url("gov/indicator_beneficiary_list/$indicator/ASHAID/export_csv");?>" class="pull-right hvr-pulse-grow" id="btn-Preview-Image" data-toggle="tooltip" title="Export Excel">
				<i class="fa fa-2x fa-file-excel-o" id="" name="" style="color: #009999; cursor: pointer; margin-right: 20px;" onclick="csv()"></i>
			</a>

		</div>

		<div class="panel-heading">
			<h4 class="panel-title text-center"><?php echo $indicator_name; ?></h4>
		</div>
		<div class="panel-body">
			<table class="table table-striped table-bordered table-hover">
				<tr>
					<th>S.no</th>
					<th>Beneficiary Name</th>
					<th>Husband Name</th>
					<th>Registration Date</th>
					<th>Mother MCTS ID</th>
					<th>LMP Date</th>
					<th>EDD Date</th>

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
							<td><?php echo $ben->HusbandName; ?></td>
							<td><?php echo $ben->PWRegistrationDate; ?></td>
							<td><?php echo $ben->MotherMCTSID; ?></td>
							<td><?php echo $ben->LMPDate; ?></td>
							<td><?php echo $ben->EDDDate; ?></td>
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
