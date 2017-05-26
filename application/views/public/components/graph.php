<section id="content">
	<div class="panel">
		<div class="panel-heading">
			<h3 class="text-center"><?php echo $heading; ?></h3>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-lg-12" style="padding : 20px">
					<canvas id="chart" width="100vw" height="30vh"></canvas>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12 text-center">
					<a class="btn btn-info" href="<?php echo site_url();?>public/indicator_anm_list/<?php echo $indicator; ?>">Go To Table Data</a>
				</div>
			</div>
		</div>
	</div>
</section>
<script>
	$(document).ready(function(){
		drawGraph();
	});

	function drawGraph()
	{

		var ctx = $("#chart");
		
		var data = {
			labels: [

			"<?php echo $numenator_description;?>",
			"<?php echo $denominator_description;?>",
			],
			datasets: [
			{
				data: [<?php echo $numenator;?>, <?php echo $denominator;?>],
				backgroundColor: [
				"#36A2EB",
				"#FF6384"
				],
				hoverBackgroundColor: [
				"#36A2EB",
				"#FF6384"
				]
			}]
		};
		var options = {
			animation : {
				animateRotate : true,
			}
		};
		var myPieChart = new Chart(ctx,{
			type: 'pie',
			data: data,
			options: options
		});
	}
</script>