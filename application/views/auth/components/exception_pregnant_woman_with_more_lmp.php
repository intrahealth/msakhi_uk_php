<section id="content">
			
			<div class="card">

				<div class="card-header">
					<h2>Exception Report <small>List of Women marked pregnant having elapsed LMP (10 months) </small></h2>

					<a href="export_pdf" class="pull-right hvr-pulse-grow" id="btn-Preview-Image" data-toggle="tooltip" title="Export PDF">
						<i class="fa fa-2x fa-file-pdf-o" id="" name="" style="color: #cc3300; cursor: pointer; margin-right: 20px;"></i>
					</a>

					<a href="export_csv" class="pull-right hvr-pulse-grow" id="btn-Preview-Image" data-toggle="tooltip" title="Export Excel">
						<i class="fa fa-2x fa-file-excel-o" id="" name="" style="color: #009999; cursor: pointer; margin-right: 20px;"></i>
					</a>

				</div>
				
				<table id="data-table-command" class="table table-striped table-vmiddle">
					<thead>
						<tr>
							<!-- <th data-column-id="id" data-type="numeric" data-order="asc">State ID</th> -->
							<th data-column-id="PWName">Name</th>
							<th data-column-id="HusbandName">Husband Name</th>
							<th data-column-id="LMPDate">LMPDate</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($data_list as $row){ ?>
						<tr>
							<td><?php echo $row->PWName; ?></td>
							<td><?php echo $row->HusbandName; ?></td>
							<td><?php echo $row->LMPDate; ?></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
			
		</section>
		
		<!-- Data Table -->
		<script type="text/javascript">
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
                			return  "<a href=\"<?php echo site_url('admin/state/edit');?>/" + row.StateCode + "\" type=\"button\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\"" + row.id + "\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"\" data-original-title=\"Edit\"><span class=\"zmdi zmdi-edit\"></span></a>"
                			
                			+
                			
                			"<a href=\"<?php echo site_url('admin/state/delete');?>/" + row.StateCode + "\" type=\"button\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\"" + row.id + "\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"\" data-original-title=\"Delete\"><span class=\"zmdi zmdi-delete\"></span></a>";
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