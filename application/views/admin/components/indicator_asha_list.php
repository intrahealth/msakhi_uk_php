<style>
	.link_row
	{
		cursor: pointer;
	}
</style>
<section id="content">
	<div class="panel">

		<div class="panel-heading">

			<a href="<?php echo site_url("admin/indicator_asha_list/$indicator/ANMCode/export_pdf");?>" class="pull-right hvr-pulse-grow" id="btn-Preview-Image" data-toggle="tooltip" title="Export PDF">
				<i class="fa fa-2x fa-file-pdf-o" id="" name="" style="color: #cc3300; cursor: pointer; margin-right: 20px;" onclick="csv()"></i>
			</a>

			<a href="<?php echo site_url("admin/indicator_asha_list/$indicator/ANMCode/export_csv");?>" class="pull-right hvr-pulse-grow" id="btn-Preview-Image" data-toggle="tooltip" title="Export Excel">
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
					<th>ASHA Name</th>
					<th>Area</th>
					<th>Done/Total</th>
					<th>Performance</th>
				</tr>
				<tbody>
					<?php 
					$sno = 1;
					foreach ($asha_list as $asha) {
						// print_r($anm); die();
						?>
						<tr class="link_row" data-href="<?php echo base_url()."admin/indicator_beneficiary_list/".$indicator."/".$asha->ASHAID; ?>">
							<td><?php echo $sno; ?></td>
							<td><?php echo $asha->ASHAName; ?></td>
							<td></td>
							<td><?php echo $asha->done . "/" . $asha->total;?></td>
							<td><?php 
								if ($asha->total == 0) {
									echo "0.00%";
								}else{
									echo number_format(($asha->done/$asha->total)*100,2) . "%";
								}
								?></td>
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

	<script>
		$(document).ready(function(){
			$(".link_row").click(function(){
				window.location = $(this).data("href");
			});
		});
	</script>