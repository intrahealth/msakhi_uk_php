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
					<th>ANM Name</th>
					<th>Area</th>
					<th>Done/Total</th>
					<th>Performance</th>
				</tr>
				<tbody>
					<?php 
					$sno = 1;
					foreach ($anm_list as $anm) {
						// print_r($anm); die();
						?>
						<tr class="link_row" data-href="<?php echo base_url()."public/indicator_asha_list/".$indicator."/".$anm->ANMCode; ?>">
								<td><?php echo $sno; ?></td>
								<td><?php echo $anm->ANMName; ?></td>
								<td></td>
								<td><?php echo $anm->done . "/" . $anm->total;?></td>
								<td><?php 
									if ($anm->total == 0) {
										echo "0.00%";
									}else{
										echo number_format(($anm->done/$anm->total)*100,2) . "%";
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