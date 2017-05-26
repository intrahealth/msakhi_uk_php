<style>
  .dw-item
  {
    min-height: 315px;
  }
  .easy-pie.main-pie .percent{
    font-size: 30px;
    margin-top: 59px;
  }
</style>
<section id="content" >

  <div class="block-header">
    <h2 style="color: #adadad">Dashboard</h2>

    <ul class="actions">

      <li>

        <div class="toggle-switch toggle-switch-demo" data-toggle="tooltip" title="Show Counts" style="margin-top: -2px;
    margin-right: 12px;">
          <input id="Isterminal" name="Isterminal" type="checkbox"  hidden="hidden">
          <label for="Isterminal" class="ts-helper"></label>
        </div>

      </li>

      <li>

      <a href="javascript:showFilterDialog();" class="pull-right hvr-pulse-grow" id="btn-Preview-Image" data-toggle="tooltip" title="Apply Filter">
          <i class="fa fa-2x fa-filter" id="" name="" style="color: #ef8c5d; cursor: pointer; margin-right: 20px;margin-top: 10px;" onclick="csv()"></i>
        </a>

      </li>
      <li>

        <?php if (is_array($filter_data)) { ?>
        
        <a href="javascript:document.getElementById('clearForm').submit();" class="pull-right hvr-pulse-grow" id="btn-Preview-Image" data-toggle="tooltip" title="Clear Filter">
          <i class="fa fa-2x fa-filter" id="" name="" style="color: #7ade95; cursor: pointer; margin-right: 20px;margin-top: 10px;" onclick="csv()"></i>
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

      </li>
    </ul>

  </div>


<div class="row">
  <div class="col-md-12 col-sm-12">
      <div id="pie-charts" class="dw-item bgm-brown c-white">

        <div class="dw-item">
          <div class="dwi-header">
            <div class="dwih-title"><h3 class="text-center">Demographics/HH Detail</h3></div>
          </div>
          <div class="clearfix"></div>
  <br>
  <br>
  <br>
          <div class="p-t-25 p-b-20 text-center">
          
          <div class="row">
            <div class="col-lg-4">
              <!-- <div class="easy-pie main-pie" data-percent="<?php echo $total_population;?>">
            </div> -->
              <div class="percent"><h1 class="text-center"><?php echo $total_population;?></h1></div>
              <div class="pie-title"><span data-toggle="tooltip" title="<?php echo $total_population;?>">Total Population</span></div>
            </div>
            <div class="col-lg-4">
              <!-- <div class="easy-pie main-pie" data-percent="<?php echo $woman_age_15_49_years;?>">
            </div> -->
              <div class="percent"><h1 class="text-center"><?php echo $woman_age_15_49_years;?></h1></div>
              <div class="pie-title"><span data-toggle="tooltip" title="<?php echo $woman_age_15_49_years;?>">Number of Women 15-49 years</span></div>
            </div>
            <div class="col-lg-4">
               <!-- <div class="easy-pie main-pie" data-percent="<?php echo $children_age_months_0_6;?>">
            </div> -->
              <div class="percent"><h1 class="text-center"><?php echo $children_age_months_0_6;?></h1></div>
              <div class="pie-title"><span data-toggle="tooltip" title="<?php echo $children_age_months_0_6;?>">Number of children 0-6 months</span></div>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-md-1 col-md-offset-10">
              <a href="<?php echo site_url(); ?>admin/Dashboard3/demographic" class="btn btn-default btn-xs">More...</a>
            </div>
          </div>
          </div>
        </div>

      </div>
    </div>
</div>
 <div class="row">
  <div class="col-md-12 col-sm-12">
      <div id="pie-charts" class="dw-item bgm-purple c-white">

        <div class="dw-item">
          <div class="dwi-header">
            <div class="dwih-title"><h3 class="text-center">Anti natal care</h3></div>
          </div>

          <div class="clearfix"></div>
  <br>
  <br>
  <br>
          <div class="p-t-25 p-b-20 text-center">
          <div class="row">
            <div class="col-lg-4">
              <div class="easy-pie main-pie" data-percent="<?php echo $proportion_of_pregnant_woman_registered_in_first_trimester['percent'];?>">
              <div class="percent"><?php echo $proportion_of_pregnant_woman_registered_in_first_trimester['percent'];?></div>
            </div>
              <div class="pie-title"><span data-toggle="tooltip" title="<?php echo $proportion_of_pregnant_woman_registered_in_first_trimester['numenator'];?>">Number of pregnant women registered <= 3months of pregnancy</span> / <br><span data-toggle="tooltip" title="<?php echo $proportion_of_pregnant_woman_registered_in_first_trimester['denominator'];?>">Number of pregnant women</span></div>
            </div>
            <div class="col-lg-4">
              <div class="easy-pie main-pie" data-percent="<?php echo $proportion_of_pregnant_woman_with_one_anc_checkup['percent'];?>">
              <div class="percent"><?php echo $proportion_of_pregnant_woman_with_one_anc_checkup['percent'];?></div>
            </div>
              <div class="pie-title"><span data-toggle="tooltip" title="<?php echo $proportion_of_pregnant_woman_with_one_anc_checkup['numenator'];?>">Number of women got 1st ANC check-up</span> / <br><span data-toggle="tooltip" title="<?php echo $proportion_of_pregnant_woman_with_one_anc_checkup['denominator'];?>">Number of pregnant women in their first trimester</span></div>
            </div>
            <div class="col-lg-4">
               <div class="easy-pie main-pie" data-percent="<?php echo $proportion_of_pregnant_woman_with_two_anc_checkup['percent'];?>">
              <div class="percent"><?php echo $proportion_of_pregnant_woman_with_two_anc_checkup['percent'];?></div>
            </div>
              <div class="pie-title"><span data-toggle="tooltip" title="<?php echo $proportion_of_pregnant_woman_with_two_anc_checkup['numenator'];?>">Number of women got 2nd ANC check-up</span> /<br><span data-toggle="tooltip" title="<?php echo $proportion_of_pregnant_woman_with_two_anc_checkup['denominator'];?>">Number of pregnant women in their second trimester</span></div>
            </div>
          </div>

          <br>
          <div class="row">
            <div class="col-md-1 col-md-offset-10">
              <a href="<?php echo site_url(); ?>admin/Dashboard3/anti_natal" class="btn btn-default btn-xs">More...</a>
            </div>
          </div>
          </div>
        </div>

      </div>
    </div>
</div>

<div class="row">
  <div class="col-md-12 col-sm-12">
      <div id="pie-charts" class="dw-item bgm-cyan c-white">

        <div class="dw-item">
          <div class="dwi-header">
            <div class="dwih-title"><h3 class="text-center">Post natal care</h3></div>
          </div>

          <div class="clearfix"></div>
  <br>
  <br>
  <br>
          <div class="p-t-25 p-b-20 text-center">
          <div class="row">
            <div class="col-lg-4">
              <div class="easy-pie main-pie" data-percent="<?php echo $newborns_visited_two_more_seven_days_institutional_delivery['percent'];?>">
              <div class="percent"><?php echo $newborns_visited_two_more_seven_days_institutional_delivery['percent'];?></div>
            </div>
              <div class="pie-title"><span data-toggle="tooltip" title="<?php echo $newborns_visited_two_more_seven_days_institutional_delivery['numenator'];?>">Number of newborns visited by ASHA at least two or more times within first seven days of institutional delivery</span> / <br><span data-toggle="tooltip" title="<?php echo $newborns_visited_two_more_seven_days_institutional_delivery['denominator'];?>">Number of newborns with age more than seven days</span></div>
            </div>
            <div class="col-lg-4">
              <div class="easy-pie main-pie" data-percent="<?php echo $low_birth_weight['percent'];?>">
              <div class="percent"><?php echo $low_birth_weight['percent'];?></div>
            </div>
              <div class="pie-title"><span data-toggle="tooltip" title="<?php echo $low_birth_weight['numenator'];?>">Number of children with weight at birth < 2500gms</span> / <br><span data-toggle="tooltip" title="<?php echo $low_birth_weight['denominator'];?>">Total number of births</span></div>
            </div>
            <div class="col-lg-4">
               <div class="easy-pie main-pie" data-percent="<?php echo $proportion_received_bcg_birth['percent'];?>">
              <div class="percent"><?php echo $proportion_received_bcg_birth['percent'];?></div>
            </div>
              <div class="pie-title"><span data-toggle="tooltip" title="<?php echo $proportion_received_bcg_birth['numenator'];?>">Number children received BCG</span> /<br><span data-toggle="tooltip" title="<?php echo $proportion_received_bcg_birth['denominator'];?>">Number of births</span></div>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-md-1 col-md-offset-10">
              <a href="<?php echo site_url(); ?>admin/Dashboard3/post_natal" class="btn btn-default btn-xs">More...</a>
            </div>
          </div>
          </div>
        </div>

      </div>
    </div>
</div>

<div class="row">
  <div class="col-md-12 col-sm-12">
      <div id="pie-charts" class="dw-item bgm-gray c-white">

        <div class="dw-item">
          <div class="dwi-header">
            <div class="dwih-title"><h3 class="text-center">Immunization (Infant)</h3></div>
          </div>

          <div class="clearfix"></div>
  <br>
  <br>
  <br>
          <div class="p-t-25 p-b-20 text-center">
          <div class="row">
            <div class="col-lg-4">
              <div class="easy-pie main-pie" data-percent="<?php echo $proportion_children_less_45_days_opv1['percent'];?>">
              <div class="percent"><?php echo $proportion_children_less_45_days_opv1['percent'];?></div>
            </div>
              <div class="pie-title"><span data-toggle="tooltip" title="<?php echo $proportion_children_less_45_days_opv1['numenator'];?>">Number of children received OPV1</span> / <br><span data-toggle="tooltip" title="<?php echo $proportion_children_less_45_days_opv1['denominator'];?>">Number of children aged 45 days or more</span></div>
            </div>
            <div class="col-lg-4">
              <div class="easy-pie main-pie" data-percent="<?php echo $proportion_children_less_45_days_dpt1['percent'];?>">
              <div class="percent"><?php echo $proportion_children_less_45_days_dpt1['percent'];?></div>
            </div>
              <div class="pie-title"><span data-toggle="tooltip" title="<?php echo $proportion_children_less_45_days_dpt1['numenator'];?>">Number of children received DPT1</span> / <br><span data-toggle="tooltip" title="<?php echo $proportion_children_less_45_days_dpt1['denominator'];?>">Number of children aged 45 days or more</span></div>
            </div>
            <div class="col-lg-4">
               <div class="easy-pie main-pie" data-percent="<?php echo $proportion_children_less_45_days_hepb1['percent'];?>">
              <div class="percent"><?php echo $proportion_children_less_45_days_hepb1['percent'];?></div>
            </div>
              <div class="pie-title"><span data-toggle="tooltip" title="<?php echo $proportion_children_less_45_days_hepb1['numenator'];?>">Number of children received Hepatitis B1</span> /<br><span data-toggle="tooltip" title="<?php echo $proportion_children_less_45_days_hepb1['denominator'];?>">Number of children aged 45 days or more</span></div>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-md-1 col-md-offset-10">
              <a href="<?php echo site_url(); ?>admin/Dashboard3/immunization_infant" class="btn btn-default btn-xs">More...</a>
            </div>
          </div>
          </div>
        </div>

      </div>
    </div>
</div>

<div class="row">
  <div class="col-md-12 col-sm-12">
      <div id="pie-charts" class="dw-item bgm-green c-white">

        <div class="dw-item">
          <div class="dwi-header">
            <div class="dwih-title"><h3 class="text-center">Immunization (Child)</h3></div>
          </div>

          <div class="clearfix"></div>
  <br>
  <br>
  <br>
          <div class="p-t-25 p-b-20 text-center">
          <div class="row">
            <div class="col-lg-4">
              <div class="easy-pie main-pie" data-percent="<?php echo $proportion_children_sixteen_months_vitamin_a2['percent'];?>">
              <div class="percent"><?php echo $proportion_children_sixteen_months_vitamin_a2['percent'];?></div>
            </div>
              <div class="pie-title"><span data-toggle="tooltip" title="<?php echo $proportion_children_sixteen_months_vitamin_a2['numenator'];?>">Number of children received second dose of Vitamin A</span> / <br><span data-toggle="tooltip" title="<?php echo $proportion_children_sixteen_months_vitamin_a2['denominator'];?>">Number of children aged 16 months</span></div>
            </div>
            <div class="col-lg-4">
              <div class="easy-pie main-pie" data-percent="<?php echo $proportion_children_16_24_months_dptbooster['percent'];?>">
              <div class="percent"><?php echo $proportion_children_16_24_months_dptbooster['percent'];?></div>
            </div>
              <div class="pie-title"><span data-toggle="tooltip" title="<?php echo $proportion_children_16_24_months_dptbooster['numenator'];?>">Number of children received DPT booster</span> / <br><span data-toggle="tooltip" title="<?php echo $proportion_children_16_24_months_dptbooster['denominator'];?>">Number of children aged 16 to 24 months</span></div>
            </div>
            <div class="col-lg-4">
               <div class="easy-pie main-pie" data-percent="<?php echo $proportion_children_16_24_months_poliobooster['percent'];?>">
              <div class="percent"><?php echo $proportion_children_16_24_months_poliobooster['percent'];?></div>
            </div>
              <div class="pie-title"><span data-toggle="tooltip" title="<?php echo $proportion_children_16_24_months_poliobooster['numenator'];?>">Number of children received Polio booster</span> /<br><span data-toggle="tooltip" title="<?php echo $proportion_children_16_24_months_poliobooster['denominator'];?>">Number of children aged 16 to 24 months</span></div>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-md-1 col-md-offset-10">
              <a href="<?php echo site_url(); ?>admin/Dashboard3/immunization_child" class="btn btn-default btn-xs">More...</a>
            </div>
          </div>
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
    // draw_bar_trend_chart();

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

  // function draw_bar_trend_chart() 
  // {
  //   var ctx = document.getElementById('myChart').getContext('2d');
  //   var myChart = new Chart(ctx, {
  //     type: 'line',
  //     data: {
  //       labels: ['<?php echo implode("','", array_map(function($month){return date('F', mktime(0, 0, 0, $month, 10));}, array_keys($trends['trend_anc_visit'])));?>'],
  //       datasets: [{
  //         label: 'ANC visits',
  //         data: [<?php echo implode(",", $trends['trend_anc_visit']);?>],
  //         backgroundColor: "rgba(139,195,74,0.6)"
  //       },{
  //         label: 'PNC visits',
  //         data: [<?php echo implode(",", $trends['trend_pnc_visit']);?>],
  //         backgroundColor: "rgba(255,193,7,0.6)"
  //       },{
  //         label: 'Immunization counselling',
  //         data: [<?php echo implode(",", $trends['trend_immunization_counselling']);?>],
  //         backgroundColor: "rgba(96,125,139,0.6)"
  //       },{
  //         label: 'FP counselling',
  //         data: [<?php echo implode(",", $trends['trend_fp_counselling']);?>],
  //         backgroundColor: "rgba(121,85,72,0.6)"
  //       }]
  //     }
  //   });
  // }
  
</script>