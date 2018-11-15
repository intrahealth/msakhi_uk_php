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
    <h2 style="color: #adadad">Immunization Child</h2>

    <ul class="actions">

      <li style="padding-right: 10px;">
        <form action="" method="post">
          <select name="filterPeriod" id="filterPeriod" onchange="this.form.submit()">
            <option value="0" <?php echo (set_value("filterPeriod") == 0? "selected" : "");?>> -- ALL -- </option>
            <option value="1" <?php echo (set_value("filterPeriod") == 1? "selected" : "");?>>Last Month</option>
            <option value="2" <?php echo (set_value("filterPeriod") == 2? "selected" : "");?>>Current Month</option>
            <option value="3" <?php echo (set_value("filterPeriod") == 3? "selected" : "");?>>Last Completed Quater</option>
            <option value="4" <?php echo (set_value("filterPeriod") == 4? "selected" : "");?>>Current Running Year</option>
            <option value="5" <?php echo (set_value("filterPeriod") == 5? "selected" : "");?>>Last Financial Year</option>
            <option value="6" <?php echo (set_value("filterPeriod") == 6? "selected" : "");?>>Current Financial Year</option>
          </select>
        </form>
      </li>

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

    <div class="col-md-4 col-sm-6">
      <div id="pie-charts" class="dw-item bgm-brown c-white">

        <div class="dw-item">
          <div class="dwi-header">
            <div class="dwih-title">Proportion of chidren aged 16 months received second dose of Vitamin A</div>
          </div>

          <div class="clearfix"></div>

          <div class="text-center p-20 m-t-25">
            <div class="easy-pie main-pie" data-percent="<?php echo $proportion_children_sixteen_months_vitamin_a2['percent'];?>">
              <div class="percent"><?php echo $proportion_children_sixteen_months_vitamin_a2['percent'];?></div>
            </div>
            <div class="pie-title"><span data-toggle="tooltip" title="<?php echo $proportion_children_sixteen_months_vitamin_a2['numenator'];?>">Number of children received second dose of Vitamin A</span> / <br><span data-toggle="tooltip" title="<?php echo $proportion_children_sixteen_months_vitamin_a2['denominator'];?>">Number of children aged 16 months</span></div>
          </div>
        </div>

      </div>
    </div>

    <div class="col-md-4 col-sm-6">
      <div id="pie-charts" class="dw-item bgm-purple c-white">

        <div class="dw-item">
          <div class="dwi-header">
            <div class="dwih-title">Proportion of children aged 16 to 24 motnhs received DPT booster</div>
          </div>

          <div class="clearfix"></div>

          <div class="text-center p-20 m-t-25">
            <div class="easy-pie main-pie" data-percent="<?php echo $proportion_children_16_24_months_dptbooster['percent'];?>">
              <div class="percent"><?php echo $proportion_children_16_24_months_dptbooster['percent'];?></div>
            </div>
            <div class="pie-title"><span data-toggle="tooltip" title="<?php echo $proportion_children_16_24_months_dptbooster['numenator'];?>">Number of children received DPT booster</span> / <br><span data-toggle="tooltip" title="<?php echo $proportion_children_16_24_months_dptbooster['denominator'];?>">Number of children aged 16 to 24 months</span></div>
          </div>
        </div>

      </div>
    </div>

    <div class="col-md-4 col-sm-6">
      <div id="pie-charts" class="dw-item bgm-bluegray c-white">

        <div class="dw-item">
          <div class="dwi-header">
            <div class="dwih-title">Proportion of children aged 16 to 24 motnhs received Polio booster</div>
          </div>

          <div class="clearfix"></div>

          <div class="text-center p-20 m-t-25">
            <div class="easy-pie main-pie" data-percent="<?php echo $proportion_children_16_24_months_poliobooster['percent'];?>">
              <div class="percent"><?php echo $proportion_children_16_24_months_poliobooster['percent'];?></div>
            </div>
            <div class="pie-title"><span data-toggle="tooltip" title="<?php echo $proportion_children_16_24_months_poliobooster['numenator'];?>">Number of children received Polio booster</span> /<br><span data-toggle="tooltip" title="<?php echo $proportion_children_16_24_months_poliobooster['denominator'];?>">Number of children aged 16 to 24 months</span></div>
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
            <div class="dwih-title">Proportion of chidren aged 24 months received third dose of Vitamin A</div>
          </div>

          <div class="clearfix"></div>

          <div class="text-center p-20 m-t-25">
            <div class="easy-pie main-pie" data-percent="<?php echo $proportion_children_24_months_vitamin_a3['percent'];?>">
              <div class="percent"><?php echo $proportion_children_24_months_vitamin_a3['percent'];?></div>
            </div>
            <div class="pie-title"><span data-toggle="tooltip" title="<?php echo $proportion_children_24_months_vitamin_a3['numenator'];?>">Number of children received third dose of Vitamin A</span> / <br><span data-toggle="tooltip" title="<?php echo $proportion_children_24_months_vitamin_a3['denominator'];?>">Number of children aged 24 months</span></div>
          </div>
        </div>

      </div>
    </div>

    <div class="col-md-4 col-sm-6">
      <div id="pie-charts" class="dw-item bgm-purple c-white">

        <div class="dw-item">
          <div class="dwi-header">
            <div class="dwih-title">Proportion of chidren aged 30 months received 4th dose of Vitamin A</div>
          </div>

          <div class="clearfix"></div>

          <div class="text-center p-20 m-t-25">
            <div class="easy-pie main-pie" data-percent="<?php echo $proportion_children_30_months_vitamin_a4['percent'];?>">
              <div class="percent"><?php echo $proportion_children_30_months_vitamin_a4['percent'];?></div>
            </div>
            <div class="pie-title"><span data-toggle="tooltip" title="<?php echo $proportion_children_30_months_vitamin_a4['numenator'];?>">Number of children received 4th dose of Vitamin A</span> / <br><span data-toggle="tooltip" title="<?php echo $proportion_children_30_months_vitamin_a4['denominator'];?>">Number of children aged 30 months</span></div>
          </div>
        </div>

      </div>
    </div>

    <div class="col-md-4 col-sm-6">
      <div id="pie-charts" class="dw-item bgm-bluegray c-white">

        <div class="dw-item">
          <div class="dwi-header">
            <div class="dwih-title">Proportion of chidren aged 36 months received 5th dose of Vitamin A</div>
          </div>

          <div class="clearfix"></div>

          <div class="text-center p-20 m-t-25">
            <div class="easy-pie main-pie" data-percent="<?php echo $proportion_children_36_months_vitamin_a5['percent'];?>">
              <div class="percent"><?php echo $proportion_children_36_months_vitamin_a5['percent'];?></div>
            </div>
            <div class="pie-title"><span data-toggle="tooltip" title="<?php echo $proportion_children_36_months_vitamin_a5['numenator'];?>">Number of children received 5th dose of Vitamin A</span> /<br><span data-toggle="tooltip" title="<?php echo $proportion_children_36_months_vitamin_a5['denominator'];?>">Number of children aged 36 months</span></div>
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
    $.post('<?php echo site_url("ajax/getAshaOfAnm/");?>' + '/' + anmid, {}, function(raw){
      console.log(raw);
      $('#Asha').html(raw);
    });
  }

  $(document).ready(function(){

    $('#Isterminal').change(function(){
      var c = $(this).prop('checked');
      if (c) {
        $('[data-toggle="tooltip"]').tooltip('show');
      }else{
        $('[data-toggle="tooltip"]').tooltip('hide');
      }
    });

  });
  
</script>