<section id="content">
	<?php foreach ($role_permission as $row) { if ($row->Controller == "delivery" && $row->Action == "index") { ?>
	<div class="block-header">
		<h2>Child Details</h2><br>
	</div>
	<?php 
	$tr_msg= $this->session->flashdata('tr_msg');
	$er_msg= $this->session->flashdata('er_msg');
	if(!empty($tr_msg)){ ?>
	<div class="content animate-panel">
		<div class="row">
			<div class="col-md-12">
				<div class="hpanel">
					<div class="alert alert-success alert-dismissable alert1"> <i class="fa fa-check"></i>
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<?php echo $this->session->flashdata('tr_msg');?>. </div>
					</div>
				</div>
			</div>
		</div>
		<?php } else if(!empty($er_msg)){?>
		<div class="content animate-panel">
			<div class="row">
				<div class="col-md-12">
					<div class="hpanel">
						<div class="alert alert-danger alert-dismissable alert1"> <i class="fa fa-check"></i>
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<?php echo $this->session->flashdata('er_msg');?>. </div>
						</div>
					</div>
				</div>
			</div>
			<?php } ?>	
			
			<div class="card">	
				<div class="card-header"></div>												

				<table id="data-table-command" class="table table-striped table-vmiddle table table-condensed">
					<thead>
						<tr class="success">
							<th class="text-middle" data-column-id="childGUID" data-visible="false"  data-order="asc">ID</th>

							<th data-column-id="child_name">Child Name</th>
							<th data-column-id="child_dob">Age(Month/Day)</th>
							<th data-column-id="Wt_of_child">Weigth Of Child</th>
							<th data-column-id="Date_Of_Registration">Date Of Registration</th>
							<th data-column-id="commands" data-formatter="commands"  data-sortable="false">Counselling</th>
						</tr>
					</thead>

					<tbody>
						<?php foreach($PW_list as $row){ ?>
						<tr>
							<td><?php echo $row->childGUID;?></td>
							<td><?php echo $row->child_name; ?></td>
							<td><?php echo $row->child_dob; ?></td>
							<td><?php echo $row->Wt_of_child; ?></td>
							<td><?php echo $row->Date_Of_Registration; ?></td>
						</tr>
						<?php } ?>
					</tbody>

				</table>
			</div>
		</div>
		<?php } } ?>
	</section>


	<script type="text/javascript">
		$(document).ready(function()
		{
			$('#ANMCode').change(function(){
				var ANMCode = $(this).val();
				$.post('<?php echo site_url('Ajax/getAshaOfAnmViaAnmCode');?>/'+ANMCode, {}, function(raw){
					$('#ASHACode').html(raw);
				});
			});
			bindBootgrid();
		});

		function bindBootgrid()
		{
			$("#data-table-command").bootgrid('destroy').bootgrid({

				caseSensitive: false,

				
				post: function ()
				{

					return {
						id: "b0df282a-0d67-40e5-8558-c9e93b7befed",
						
						StateCode : $('#StateCode').val(), 
						ANMCode : $('#ANMCode').val(),
						ASHACode : $('#ASHACode').val(),
						VillageCode : $('#VillageCode').val(),
						IsDeleted : $('#IsDeleted').val(),

					};
				},
				css: {
					icon: 'zmdi icon',
					iconColumns: 'zmdi-view-module',
					iconDown: 'zmdi-expand-more',
					iconRefresh: 'zmdi-refresh',
					iconUp: 'zmdi-expand-less'
				},
				formatters: {

					"commands": function(column, row)
					{
						return  "<a href=\"<?php echo site_url('counselling/edit_immunization_counselling');?>/" + row.childGUID + "\" type=\"button\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\"" + row.childGUID +"\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"\" data-original-title= \"View Activities\"><span class=\"zmdi zmdi-view-list\"></span></a>"

						+

						"<a href=\"<?php echo site_url('Household/delete');?>/" + row.childGUID + "\" type=\"button\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\"" + row.childGUID + "\"  data-toggle=\"confirmation\"data-singleton=\"true\" data-placement=\"left\" data-title=\"Proceed to delete?\" ><span class=\"zmdi zmdi-delete\"></span></a>";
					},


				}

			}).on("loaded.rs.jquery.bootgrid", function () {

				if ($('[data-toggle="tooltip"]')[0]) {
					$('[data-toggle="tooltip"]').tooltip();
				}

				$('[data-toggle=confirmation]').confirmation({
					rootSelector: '[data-toggle=confirmation]',
				});


			});
		}



	</script>






