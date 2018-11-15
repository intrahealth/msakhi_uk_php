<section id="content">
	<?php foreach ($role_permission as $row) { if ($row->Controller == "exception_reports" && $row->Action == "pregnant_women_more_than_10_months_lmp") { ?>
	<div class="block-header">

		<div class="card">
			<div class="card-header">
				<h2><?php echo $report_title;?></h2><br>
				<?php foreach ($role_permission as $row) { if ($row->Controller == "exception_reports" && $row->Action == "export_csv"){ ?>
				<a href="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]/export_csv";?>" class="pull-right hvr-pulse-grow" id="btn-Preview-Image" data-toggle="tooltip" title="Export Excel">
					<i class="fa fa-2x fa-file-excel-o" id="" name="" style="color: #009999; cursor: pointer; margin-right: 20px;" onclick="csv()"></i>
				</a>
      <?php } } ?>
			</div>

			<table class="table table-striped table-vmiddle">
				<thead>
					<tr>
						<?php $header_row = $data_list[0];
						foreach ($header_row as $key => $value) { ?>
						<th data-column-id="<?php echo $key;?>" data-visible="false"><?php echo $key;?></th>
						<?php } ?>
					</tr>
				</thead>

				<tbody>
					<?php foreach($data_list as $row){ ?>
					<tr>
						<?php foreach ($row as $key => $value) { ?>
						<td><?php echo $value; ?></td>
						<?php } ?>
					</tr>
					<?php } ?>
				</tbody>

			</table>
		</div>
		<?php } } ?>
	</section>
	<!-- Data Table -->
	<script>
		$(document).ready(function(){
//Command Buttons
$("#data-table-command").bootgrid({
	css: {
		icon: 'zmdi icon',
		iconColumns: 'zmdi-view-module',
		iconDown: 'zmdi-expand-more',
		iconRefresh: 'zmdi-refresh',
		iconUp: 'zmdi-expand-less'
	},
	formatters: {
		"commands": function(column, row) {
			return  "<a href=\"<?php echo site_url('asha/edit');?>/" + row.ASHAID + "\" type=\"button\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\"" + row.id + "\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"\" data-original-title=\"Edit\"><span class=\"zmdi zmdi-edit\"></span></a>"

			+

			"<a href=\"<?php echo site_url('asha/delete/');?>/" + row.ASHAID + "\" type=\"button\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\"" + row.id+ "\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"\" data-original-title=\"Delete\"><span class=\"zmdi zmdi-delete\"></span></a>";
		},

		"formatLanguage": function(column, row){
			if(row.LanguageID == 1){
				language = "English";
			}else{
				language = "हिंदी ";
			}

			return language;
		}

	}
}).on("loaded.rs.jquery.bootgrid", function () {
	/* Executes after data is loaded and rendered */
	if ($('[data-toggle="tooltip"]')[0]) {
		$('[data-toggle="tooltip"]').tooltip();
	}
});
});
</script>