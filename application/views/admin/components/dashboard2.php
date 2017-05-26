<section id="content" >

  <div class="block-header">
    <h2 style="color: #adadad">Dashboard</h2>

    <ul class="actions">

      <li>

        <div class="toggle-switch toggle-switch-demo" data-toggle="tooltip" title="Show Counts">
          <input id="Isterminal" name="Isterminal" type="checkbox"  hidden="hidden">
          <label for="Isterminal" class="ts-helper"></label>
        </div>

      </li>

      <li>

      <a href="javascript:showFilterDialog();" class="pull-right hvr-pulse-grow" id="btn-Preview-Image" data-toggle="tooltip" title="Apply Filter">
          <i class="fa fa-2x fa-filter" id="" name="" style="color: #ef8c5d; cursor: pointer; margin-right: 20px;" onclick="csv()"></i>
        </a>

      </li>
      <li>

        <?php if (is_array($filter_data)) { ?>
        
        <a href="javascript:document.getElementById('clearForm').submit();" class="pull-right hvr-pulse-grow" id="btn-Preview-Image" data-toggle="tooltip" title="Clear Filter">
          <i class="fa fa-2x fa-filter" id="" name="" style="color: #7ade95; cursor: pointer; margin-right: 20px;" onclick="csv()"></i>
        </a>

        <?php } ?>

      </li>
      <li class="dropdown">

        <a href="" data-toggle="dropdown">
          <i class="zmdi zmdi-more-vert"></i>
        </a>

        <a href="javascript:window.print();" class="pull-right hvr-pulse-grow" id="btn-Preview-Image" data-toggle="tooltip" title="Export PDF">
          <i class="fa fa-2x fa-file-pdf-o" id="" name="" style="color: #cc3300; cursor: pointer; margin-right: 20px;"></i>
        </a>

        <a href="javascript:export_excel();" class="pull-right hvr-pulse-grow" id="btn-Preview-Image" data-toggle="tooltip" title="Export Excel">
          <i class="fa fa-2x fa-file-excel-o" id="" name="" style="color: #009999; cursor: pointer; margin-right: 20px;"></i>
        </a>

        <!-- <ul class="dropdown-menu dropdown-menu-right">
          <li>
            <a href="">Refresh</a>
          </li>
          <li>
            <a href="">Export PDF</a>
          </li>
          <li>
            <a href="">Export XLS</a>
          </li>
        </ul> -->
      </li>
    </ul>

  </div>

  <div class="row">
    <div class="col-sm-6 col-md-3">
      <div class="mini-charts-item bgm-lightgreen">
        <div class="clearfix">
          <div class="chart stats-bar"><canvas width="68" height="35" style="display: inline-block; width: 68px; height: 35px; vertical-align: top;"></canvas></div>
          <div class="count">
            <small>Household Registration</small>
            <h2><?php echo $household_count;?></h2>
          </div>
        </div>
      </div>
    </div>

    <div class="col-sm-6 col-md-3">
      <div class="mini-charts-item bgm-amber">
        <div class="clearfix">
          <div class="chart stats-line"><canvas width="68" height="35" style="display: inline-block; width: 68px; height: 35px; vertical-align: top;"></canvas></div>
          <div class="count">
            <small>Child Registration</small>
            <h2><?php echo $child_registration_count;?></h2>
          </div>
        </div>
      </div>
    </div>

    <div class="col-sm-6 col-md-3">
      <div class="mini-charts-item bgm-purple">
        <div class="clearfix">
          <div class="chart stats-bar-2"><canvas width="68" height="35" style="display: inline-block; width: 68px; height: 35px; vertical-align: top;"></canvas></div>
          <div class="count">
            <small>Pregnancy Registration</small>
            <h2><?php echo $pregnancy_count;?></h2>
          </div>
        </div>
      </div>
    </div>

    <div class="col-sm-6 col-md-3">
      <div class="mini-charts-item bgm-bluegray">
        <div class="clearfix">
          <div class="chart stats-line-2"><canvas width="68" height="35" style="display: inline-block; width: 68px; height: 35px; vertical-align: top;"></canvas></div>
          <div class="count">
            <small>Immunization</small>
            <h2><?php echo $immunization_count;?></h2>
          </div>
        </div>
      </div>
    </div>
  </div>


  <div class="row">

    <div class="col-md-4 col-sm-6">
      <div id="pie-charts" class="dw-item bgm-brown c-white">

        <div class="dw-item">
          <div class="dwi-header">
            <div class="dwih-title">Family Planning Statistics</div>
          </div>

          <div class="clearfix"></div>

          <div class="text-center p-20 m-t-25">
            <div class="easy-pie main-pie" data-percent="<?php echo $fp_block['main_dial']['percent'];?>">
              <div class="percent"><?php echo $fp_block['main_dial']['percent'];?></div>
              <div class="pie-title"><span data-toggle="tooltip" title="<?php echo $fp_block['main_dial']['numenator'];?>">FP user</span> / <br><span data-toggle="tooltip" title="<?php echo $fp_block['main_dial']['denominator'];?>">Eligible couple</span></div>
            </div>
          </div>

          <div class="p-t-25 p-b-20 text-center">
            <div class="easy-pie sub-pie-1" data-percent="<?php echo $fp_block['first_dial']['percent'];?>">
              <div class="percent"><?php echo $fp_block['first_dial']['percent'];?></div>
              <div class="pie-title"><span data-toggle="tooltip" title="<?php echo $fp_block['first_dial']['numenator'];?>">OCP user</span> / <br> <span data-toggle="tooltip" title="<?php echo $fp_block['first_dial']['denominator'];?>">FP users</span></div>
            </div>
            <div class="easy-pie sub-pie-2" data-percent="<?php echo $fp_block['second_dial']['percent'];?>">
              <div class="percent"><?php echo $fp_block['second_dial']['percent'];?></div>
              <div class="pie-title"><span data-toggle="tooltip" title="<?php echo $fp_block['second_dial']['numenator'];?>">Condom users</span> / <br><span data-toggle="tooltip" title="<?php echo $fp_block['second_dial']['denominator'];?>">FP user</span> </div>
            </div>
            <div class="easy-pie sub-pie-2" data-percent="<?php echo $fp_block['third_dial']['percent'];?>">
              <div class="percent"><?php echo $fp_block['third_dial']['percent'];?></div>
              <div class="pie-title"><span data-toggle="tooltip" title="<?php echo $fp_block['third_dial']['numenator'];?>">IUCD users</span> / <br><span data-toggle="tooltip" title="<?php echo $fp_block['third_dial']['denominator'];?>">FP user</span> </div>
            </div>
          </div>
        </div>

      </div>
    </div>

    <div class="col-md-4 col-sm-6">
      <div id="pie-charts" class="dw-item bgm-purple c-white">

        <div class="dw-item">
          <div class="dwi-header">
            <div class="dwih-title">Pregnancy Statistics</div>
          </div>

          <div class="clearfix"></div>

          <div class="text-center p-20 m-t-25">
            <div class="easy-pie main-pie" data-percent="<?php echo $p_block['main_dial']['percent'];?>">
              <div class="percent"><?php echo $p_block['main_dial']['percent'];?></div>
              <div class="pie-title"><span data-toggle="tooltip" title="<?php echo $p_block['main_dial']['numenator'];?>">Pregnancies registered</span> / <br><span data-toggle="tooltip" title="<?php echo $p_block['main_dial']['denominator'];?>">Eligible woman</span></div>
            </div>
          </div>

          <div class="p-t-25 p-b-20 text-center">
            <div class="easy-pie sub-pie-1" data-percent="<?php echo $p_block['first_dial']['percent'];?>">
              <div class="percent"><?php echo $p_block['first_dial']['percent'];?></div>
              <div class="pie-title"><span data-toggle="tooltip" title="<?php echo $p_block['first_dial']['numenator'];?>">Live birth</span> / <br> <span data-toggle="tooltip" title="<?php echo $p_block['first_dial']['denominator'];?>">Pregancies</span></div>
            </div>
            <div class="easy-pie sub-pie-2" data-percent="<?php echo $p_block['second_dial']['percent'];?>">
              <div class="percent"><?php echo $p_block['second_dial']['percent'];?></div>
              <div class="pie-title"><span data-toggle="tooltip" title="<?php echo $p_block['second_dial']['numenator'];?>">Still birth</span> / <br> <span data-toggle="tooltip" title="<?php echo $p_block['second_dial']['denominator'];?>">Pregancies</span></div>
            </div>
            <div class="easy-pie sub-pie-2" data-percent="<?php echo $p_block['third_dial']['percent'];?>">
              <div class="percent"><?php echo $p_block['third_dial']['percent'];?></div>
              <div class="pie-title"><span data-toggle="tooltip" title="<?php echo $p_block['third_dial']['numenator'];?>">Abortion</span> / <br> <span data-toggle="tooltip" title="<?php echo $p_block['third_dial']['denominator'];?>">Pregancies</span></div>
            </div>
            <!-- <div class="easy-pie sub-pie-2" data-percent="21">
              <div class="percent">36</div>
              <div class="pie-title">Pending / Not Registered</div>
            </div> -->
          </div>
        </div>

      </div>
    </div>

    <div class="col-md-4 col-sm-6">
      <div id="pie-charts" class="dw-item bgm-bluegray c-white">

        <div class="dw-item">
          <div class="dwi-header">
            <div class="dwih-title">Immunization Statistics</div>
          </div>

          <div class="clearfix"></div>

          <div class="text-center p-20 m-t-25">
            <div class="easy-pie main-pie" data-percent="<?php echo $i_block['main_dial']['percent'];?>">
              <div class="percent"><?php echo $i_block['main_dial']['percent'];?></div>
              <div class="pie-title"><span data-toggle="tooltip" title="<?php echo $i_block['main_dial']['numenator'];?>">Immunized</span> /<br><span data-toggle="tooltip" title="<?php echo $i_block['main_dial']['denominator'];?>">Total</span></div>
            </div>
          </div>

          <div class="p-t-25 p-b-20 text-center">
            <div class="easy-pie sub-pie-1" data-percent="<?php echo $i_block['first_dial']['percent'];?>">
              <div class="percent"><?php echo $i_block['first_dial']['percent'];?></div>
              <div class="pie-title" style="font-size: 9px; !important;"><span data-toggle="tooltip" title="<?php echo $i_block['first_dial']['numenator'];?>">Woman Immunized</span> / <br> <span data-toggle="tooltip" title="<?php echo $i_block['first_dial']['denominator'];?>">Prgnant Woman</span></div>
            </div>
            <div class="easy-pie sub-pie-2" data-percent="<?php echo $i_block['second_dial']['percent'];?>">
              <div class="percent"><?php echo $i_block['second_dial']['percent'];?></div>
              <div class="pie-title" style="font-size: 9px; !important;"><span data-toggle="tooltip" title="<?php echo $i_block['second_dial']['numenator'];?>">Child fully Immunized</span>/<br> <span data-toggle="tooltip" title="<?php echo $i_block['second_dial']['denominator'];?>">Total Child</span></div>
            </div>
            <div class="easy-pie sub-pie-2" data-percent="<?php echo $i_block['third_dial']['percent'];?>">
              <div class="percent"><?php echo $i_block['third_dial']['percent'];?></div>
              <div class="pie-title" style="font-size: 9px; !important;"><span data-toggle="tooltip" title="<?php echo $i_block['third_dial']['numenator'];?>">Child partially Immunized</span> / <br> <span data-toggle="tooltip" title="<?php echo $i_block['third_dial']['denominator'];?>">Total Child</span></div>
            </div>
          </div>
        </div>

      </div>
    </div>

  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="dw-item bgm-white c-black">
        <div class="dw-item">
          <div class="dwi-header">
            <div class="dwih-title">Trend Statistics (last 12 months)</div>
          </div>
          <div class="clearfix"></div>
          <!-- <div class="text-center p-20 m-t-25">
            asdasd
          </div> -->
          <div class="p-t-5 text-center">
            <canvas id="myChart" height="100px"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>

</section>

<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="padding:35px 50px;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4><span class="zmdi zmdi-check-all"></span> Apply Filter</h4>
      </div>
      <form role="form" method="post" action="">
        <div class="modal-body" style="padding:10px;">


          <div class="container">
            <div class="row">

              <div class="col-md-3 form-group">
                <label for="ANM">Select ANM</label>
                <select name="ANM" id="ANM" class="form-control fg-line" onchange="get_asha_list()">
                  <option value="">--select--</option>
                  <?php foreach ($anm_list as $anm_row) { ?>
                  <option value="<?php echo $anm_row->ANMID;?>" <?php echo ($anm_row->ANMID == $filter_data['ANM'] ? "selected":"");?>><?php echo $anm_row->ANMName;?></option>
                  <?php } ?>
                </select>
              </div>

              <div class="col-md-3 form-group">
                <label for="Asha">Select Asha</label>
                <select name="Asha" id="Asha" class="form-control fg-line">
                  <option value="">--select--</option>
                  <?php foreach ($asha_list as $asha_row) { ?>
                  <option value="<?php echo $asha_row->ASHAID;?>" <?php echo ($asha_row->ASHAID == $filter_data['Asha'] ? "selected" : "");?>><?php echo $asha_row->ASHAName;?></option>
                  <?php } ?>
                </select>
              </div>
            </div>

            <div class="row">
              <div class="col-md-3 form-group">
                <label for="Asha">Date From</label>
                <input type="text" class="date-picker form-control fg-line" name="date_from" value="<?php echo $filter_data['date_from'];?>">
              </div>

              <div class="col-md-3 form-group">
                <label for="Asha">Date To</label>
                <input type="text" class="date-picker form-control fg-line" name="date_to" value="<?php echo $filter_data['date_to'];?>">
              </div>

            </div>
          </div>


        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success pull-left" name="command" value="apply_filter">APPLY</button>
          <button type="submit" class="btn btn-warning pull-left" name="command" value="clear_filter">CLEAR</button>
          <button type="reset" class="btn btn-default pull-left" data-dismiss="modal">CANCEL</button>
        </div>
      </form>
    </div>

  </div>
</div>

<form action="" method="post" id="clearForm">
  <input type="hidden" name="command" value="clear_filter">
</form>

<script>

  function showFilterDialog() {
    $('#myModal').modal('show');
  }

  function get_asha_list() {
    var anmid = $('#ANM').val();
    $.post('<?php echo site_url("admin/ajax/getAshaOfAnm/");?>' + '/' + anmid, {}, function(raw){
      console.log(raw);
      $('#Asha').html(raw);
    });
  }

  $(document).ready(function(){
    initialize_trend();
    draw_bar_trend_chart();

    $('#Isterminal').change(function(){
      var c = $(this).prop('checked');
      if (c) {
        $('[data-toggle="tooltip"]').tooltip('show');
      }else{
        $('[data-toggle="tooltip"]').tooltip('hide');
      }
    });

  });

  function initialize_trend() 
  {
    /* Mini Chart - Bar Chart 1 */
    if ($('.stats-bar')[0]) {
      sparklineBar('stats-bar', [<?php echo implode(',', $household_trend);?>], '35px', 3, '#fff', 2);
    }
    
    /* Mini Chart - Bar Chart 2 */
    if ($('.stats-bar-2')[0]) {
      sparklineBar('stats-bar-2', [<?php echo implode(',', $pregnancy_registration_trend);?>], '35px', 3, '#fff', 2);
    }
    
    /* Mini Chart - Line Chart 1 */
    if ($('.stats-line')[0]) {
      sparklineLine('stats-line', [<?php echo implode(',', $child_registration_trend);?>], 68, 35, '#fff', 'rgba(0,0,0,0)', 1.25, 'rgba(255,255,255,0.4)', 'rgba(255,255,255,0.4)', 'rgba(255,255,255,0.4)', 3, '#fff', 'rgba(255,255,255,0.4)');
    }
    
    /* Mini Chart - Line Chart 2 */
    if ($('.stats-line-2')[0]) {
      sparklineLine('stats-line-2', [<?php echo implode(',', $child_immunization_trend);?>], 68, 35, '#fff', 'rgba(0,0,0,0)', 1.25, 'rgba(255,255,255,0.4)', 'rgba(255,255,255,0.4)', 'rgba(255,255,255,0.4)', 3, '#fff', 'rgba(255,255,255,0.4)');
    }
  }

  function draw_bar_trend_chart() 
  {
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: ['<?php echo implode("','", array_map(function($month){return date('F', mktime(0, 0, 0, $month, 10));}, array_keys($trends['trend_anc_visit'])));?>'],
        datasets: [{
          label: 'ANC visits',
          data: [<?php echo implode(",", $trends['trend_anc_visit']);?>],
          backgroundColor: "rgba(139,195,74,0.6)"
        },{
          label: 'PNC visits',
          data: [<?php echo implode(",", $trends['trend_pnc_visit']);?>],
          backgroundColor: "rgba(255,193,7,0.6)"
        },{
          label: 'Immunization counselling',
          data: [<?php echo implode(",", $trends['trend_immunization_counselling']);?>],
          backgroundColor: "rgba(96,125,139,0.6)"
        },{
          label: 'FP counselling',
          data: [<?php echo implode(",", $trends['trend_fp_counselling']);?>],
          backgroundColor: "rgba(121,85,72,0.6)"
        }]
      }
    });
  }
  
</script>