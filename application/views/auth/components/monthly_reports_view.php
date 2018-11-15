<section id="content" >
<?php //foreach ($role_permission as $row) { if ($row->Controller == "Exception_reports" && $row->Action ==  "index") {
  ?>


  <div class="row">
    <div class="col-sm-12 col-md-6">
      <div class="mini-charts-item bgm-lightgreen">
        <div class="clearfix">
          <div class="chart stats-bar"><canvas width="68" height="105" style="display: inline-block; width: 68px; height: 105px; vertical-align: top;"></canvas></div>
          <div class="count">
            <large>Monthly Report</large>
            <h2><?php// echo $household_count;?></h2>
            <p class="card-text">Demographics (ASHA wise)</p>
            <a href="<?php base_url()?>Monthly_reports/get_monthly_report_1" class="btn btn-primary">Get List</a>
          </div>
        </div>
      </div>
    </div>

    <div class="col-sm-12 col-md-6">
      <div class="mini-charts-item bgm-amber">
        <div class="clearfix">
          <div class="chart stats-line"><canvas width="68" height="105" style="display: inline-block; width: 68px; height: 105px; vertical-align: top;"></canvas></div>
          <div class="count">
            <large>Monthly Report</large>
            <h2><?php //echo $child_registration_count;?></h2>
            <p class="card-text">ANC</p>
            <a href="<?php base_url()?>Monthly_reports/get_monthly_report_2" class="btn btn-primary">Get List</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12 col-md-6">
      <div class="mini-charts-item bgm-amber">
        <div class="clearfix">
          <div class="chart stats-line"><canvas width="68" height="105" style="display: inline-block; width: 68px; height: 105px; vertical-align: top;"></canvas></div>
          <div class="count">
            <large>Monthly Report</large>
            <h2><?php //echo $child_registration_count;?></h2>
            <p class="card-text">Delivery</p>
          <!-- <a href="<?php base_url()?>Monthly_reports/get_monthly_report_3" class="btn btn-primary">Get List</a> -->
            <a href="javascript:showFilterDialog('report1');" class="btn btn-primary">Get List</a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-12 col-md-6">
      <div class="mini-charts-item bgm-lightgreen">
        <div class="clearfix">
          <div class="chart stats-bar"><canvas width="68" height="105" style="display: inline-block; width: 68px; height: 105px; vertical-align: top;"></canvas></div>
          <div class="count">
            <large>Monthly Report</large>
            <h2><?php// echo $household_count;?></h2>
            <p class="card-text">Immunization</p>
           <!--  <a href="<?php base_url()?>Monthly_reports/get_monthly_report_4" class="btn btn-primary">Get List</a> -->
           <a href="javascript:showFilterDialog('report2');" class="btn btn-primary">Get List</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php //} } ?>
</section>

<div id="chart_C11"></div>

<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="padding:35px 50px;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4><span class="zmdi zmdi-check-all"></span> Apply Filter For Month wise Report</h4>
      </div>
      <form role="form" method="post" action="">
        <div class="modal-body" style="padding:10px;">
          <div class="container">

            <div class="row">
              <div class="col-md-3 form-group">
                <label for="Asha">Date From</label>
                <input type="text" class="date-picker form-control fg-line" name="date_from">
              </div>

              <div class="col-md-3 form-group">
                <label for="Asha">Date To</label>
                <input type="text" class="date-picker form-control fg-line" name="date_to">
              </div>

            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" id="report1" class="apply_report btn btn-success pull-left" name="operation" value="report1">APPLY</button>
          <button type="submit" id="report2" class="apply_report btn btn-success pull-left" name="operation" value="report2">APPLY</button>
          <button type="submit" class="btn btn-warning pull-left" name="operation" value="clear_filter">CLEAR</button>
          <button type="reset" class="btn btn-default pull-left" data-dismiss="modal">CANCEL</button>
        </div>
      </form>
    </div>

  </div>
</div>

<script type="text/javascript">
  function showFilterDialog(show_id) 
  {
    $('.apply_report').hide();
    $('#'+show_id).show();
    $('#myModal').modal('show');
  }

</script>