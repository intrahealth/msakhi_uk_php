<style>
  #immunization table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
  }

  #immunization td, th {
    border: 1px solid #fff;
    text-align: left;
    padding: 8px;
  }
</style>

<section id="content">
<?php foreach ($role_permission as $row) { if ($row->Controller == "immunization_administered" && $row->Action == "index") { ?>
  <div class="panel panel-default">
    <div class="panel-heading">

      <span class="panel-title"><b>Immunization Administered Report</b>
        <small>
          <span class="pull-right">
           <a href="javascript:window.print();" class="hvr-pulse-grow" id="btn-Preview-Image" data-toggle="tooltip" title="Export PDF">
            <i class="fa fa-2x fa-file-pdf-o" id="" name="" style="color: #cc3300; cursor: pointer; margin-right: 20px;"></i>
          </a>

          <a href="javascript:export_excel();" class="hvr-pulse-grow" id="btn-Preview-Image" data-toggle="tooltip" title="Export Excel">
            <i class="fa fa-2x fa-file-excel-o" id="" name="" style="color: #009999; cursor: pointer; margin-right: 20px;"></i>
          </a>
        </span>
      </small>
    </span>
  </div>

  <div class="panel-body">
    <div class="row">
      <div class="col-lg-12">

        <table class="table table-striped table-bordered table-vmiddle table-hover" id="immunization_administered">
          <thead>

            <tr>
              <th>
                <b>Indicator</b>
              </th>
              <th>
                <b>Administered</b>
              </th>
              <th>
                <b>Not administered till date</b>
              </th>
            </tr>

          </thead>
          <tbody>

            <?php foreach ($immunization_summary as $key=>$irow) { 
                // print_r($irow); die();
              ?>
              <tr>
                <td><?php echo $irow[0]['label'];?></td>
                <td><?php echo $irow[1]['value'] . '/' . $irow[1]['total'] . ' (' . $irow[1]['proportion'] . '%)';?></td>
                <td><?php echo $irow[0]['value'] . '/' . $irow[0]['total'] . ' (' . $irow[0]['proportion'] . '%)';?></td>
              </tr>
              <?php } ?>

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <?php } } ?>
</section>
<script>

  function export_excel() {
    $("#immunization").tableToCSV();
  }    
</script>