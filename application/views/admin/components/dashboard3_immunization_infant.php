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
    <h2 style="color: #adadad">Immunization Infant</h2>

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
            <div class="dwih-title">Proportion of chidren aged 45 days or more received OPV1</div>
          </div>

          <div class="clearfix"></div>

          <div class="text-center p-20 m-t-25">
            <div class="easy-pie main-pie" data-percent="<?php echo $proportion_children_less_45_days_opv1['percent'];?>">
              <div class="percent"><?php echo $proportion_children_less_45_days_opv1['percent'];?></div>
            </div>
              <div class="pie-title"><span data-toggle="tooltip" title="<?php echo $proportion_children_less_45_days_opv1['numenator'];?>">Number of children received OPV1</span> / <br><span data-toggle="tooltip" title="<?php echo $proportion_children_less_45_days_opv1['denominator'];?>">Number of children aged 45 days or more</span></div>
          </div>
        </div>

      </div>
    </div>

    <div class="col-md-4 col-sm-6">
      <div id="pie-charts" class="dw-item bgm-purple c-white">

        <div class="dw-item">
          <div class="dwi-header">
            <div class="dwih-title">Proportion of chidren aged 45 days or more received DPT1</div>
          </div>

          <div class="clearfix"></div>

          <div class="text-center p-20 m-t-25">
            <div class="easy-pie main-pie" data-percent="<?php echo $proportion_children_less_45_days_dpt1['percent'];?>">
              <div class="percent"><?php echo $proportion_children_less_45_days_dpt1['percent'];?></div>
            </div>
              <div class="pie-title"><span data-toggle="tooltip" title="<?php echo $proportion_children_less_45_days_dpt1['numenator'];?>">Number of children received DPT1</span> / <br><span data-toggle="tooltip" title="<?php echo $proportion_children_less_45_days_dpt1['denominator'];?>">Number of children aged 45 days or more</span></div>
          </div>
        </div>

      </div>
    </div>

    <div class="col-md-4 col-sm-6">
      <div id="pie-charts" class="dw-item bgm-bluegray c-white">

        <div class="dw-item">
          <div class="dwi-header">
            <div class="dwih-title">Proportion of chidren aged 45 days or more received Hepatitis B1</div>
          </div>

          <div class="clearfix"></div>

          <div class="text-center p-20 m-t-25">
            <div class="easy-pie main-pie" data-percent="<?php echo $proportion_children_less_45_days_hepb1['percent'];?>">
              <div class="percent"><?php echo $proportion_children_less_45_days_hepb1['percent'];?></div>
            </div>
              <div class="pie-title"><span data-toggle="tooltip" title="<?php echo $proportion_children_less_45_days_hepb1['numenator'];?>">Number of children received Hepatitis B1</span> /<br><span data-toggle="tooltip" title="<?php echo $proportion_children_less_45_days_hepb1['denominator'];?>">Number of children aged 45 days or more</span></div>
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
            <div class="dwih-title">Proportion of chidren aged 75 days or more received OPV2</div>
          </div>

          <div class="clearfix"></div>

          <div class="text-center p-20 m-t-25">
            <div class="easy-pie main-pie" data-percent="<?php echo $proportion_children_more_75_days_opv2['percent'];?>">
              <div class="percent"><?php echo $proportion_children_more_75_days_opv2['percent'];?></div>
            </div>
              <div class="pie-title"><span data-toggle="tooltip" title="<?php echo $proportion_children_more_75_days_opv2['numenator'];?>">Number of children received OPV2</span> / <br><span data-toggle="tooltip" title="<?php echo $proportion_children_more_75_days_opv2['denominator'];?>">Number of children aged 75 days or more</span></div>
          </div>
        </div>

      </div>
    </div>

    <div class="col-md-4 col-sm-6">
      <div id="pie-charts" class="dw-item bgm-purple c-white">

        <div class="dw-item">
          <div class="dwi-header">
            <div class="dwih-title">Proportion of chidren aged 75 days or more received DPT2</div>
          </div>

          <div class="clearfix"></div>

          <div class="text-center p-20 m-t-25">
            <div class="easy-pie main-pie" data-percent="<?php echo $proportion_children_more_75_days_dpt2['percent'];?>">
              <div class="percent"><?php echo $proportion_children_more_75_days_dpt2['percent'];?></div>
            </div>
              <div class="pie-title"><span data-toggle="tooltip" title="<?php echo $proportion_children_more_75_days_dpt2['numenator'];?>">Number of children received DPT2</span> / <br><span data-toggle="tooltip" title="<?php echo $proportion_children_more_75_days_dpt2['denominator'];?>">Number of children aged 75 days or more</span></div>
          </div>
        </div>

      </div>
    </div>

    <div class="col-md-4 col-sm-6">
      <div id="pie-charts" class="dw-item bgm-brown c-white">

        <div class="dw-item">
          <div class="dwi-header">
            <div class="dwih-title">Proportion of chidren aged 75 days or more received Hepatitis B2</div>
          </div>

          <div class="clearfix"></div>

          <div class="text-center p-20 m-t-25">
            <div class="easy-pie main-pie" data-percent="<?php echo $proportion_children_more_75_days_hepb2['percent'];?>">
              <div class="percent"><?php echo $proportion_children_more_75_days_hepb2['percent'];?></div>
            </div>
              <div class="pie-title"><span data-toggle="tooltip" title="<?php echo $proportion_children_more_75_days_hepb2['numenator'];?>">Number of children received Hepatitis B2</span> / <br><span data-toggle="tooltip" title="<?php echo $proportion_children_more_75_days_hepb2['denominator'];?>">Number of children aged 75 days or more</span></div>
          </div>
        </div>

      </div>
    </div>


   

  </div>
  <div class="row">

 <div class="col-md-4 col-sm-6">
      <div id="pie-charts" class="dw-item bgm-bluegray c-white">

        <div class="dw-item">
          <div class="dwi-header">
            <div class="dwih-title">Proportion of chidren aged 105 days or more received OPV3</div>
          </div>

          <div class="clearfix"></div>

          <div class="text-center p-20 m-t-25">
            <div class="easy-pie main-pie" data-percent="<?php echo $proportion_children_more_105_days_opv3['percent'];?>">
              <div class="percent"><?php echo $proportion_children_more_105_days_opv3['percent'];?></div>
            </div>
              <div class="pie-title"><span data-toggle="tooltip" title="<?php echo $proportion_children_more_105_days_opv3['numenator'];?>">Number of children received OPV3</span> /<br><span data-toggle="tooltip" title="<?php echo $proportion_children_more_105_days_opv3['denominator'];?>">Number of children aged 105 days or more</span></div>
          </div>
        </div>

      </div>
    </div>

    <div class="col-md-4 col-sm-6">
      <div id="pie-charts" class="dw-item bgm-brown c-white">

        <div class="dw-item">
          <div class="dwi-header">
            <div class="dwih-title">Proportion of chidren aged 105 days or more received DPT3</div>
          </div>

          <div class="clearfix"></div>

          <div class="text-center p-20 m-t-25">
            <div class="easy-pie main-pie" data-percent="<?php echo $proportion_children_more_105_days_dpt3['percent'];?>">
              <div class="percent"><?php echo $proportion_children_more_105_days_dpt3['percent'];?></div>
            </div>
              <div class="pie-title"><span data-toggle="tooltip" title="<?php echo $proportion_children_more_105_days_dpt3['numenator'];?>">Number of children received DPT3</span> / <br><span data-toggle="tooltip" title="<?php echo $proportion_children_more_105_days_dpt3['denominator'];?>">Number of children aged 105 days or more</span></div>
          </div>
        </div>

      </div>
    </div>

    <div class="col-md-4 col-sm-6">
      <div id="pie-charts" class="dw-item bgm-purple c-white">

        <div class="dw-item">
          <div class="dwi-header">
            <div class="dwih-title">Proportion of chidren aged 105 days or more received HepatitisB3</div>
          </div>

          <div class="clearfix"></div>

          <div class="text-center p-20 m-t-25">
            <div class="easy-pie main-pie" data-percent="<?php echo $proportion_children_more_105_days_hepb3['percent'];?>">
              <div class="percent"><?php echo $proportion_children_more_105_days_hepb3['percent'];?></div>
            </div>
              <div class="pie-title"><span data-toggle="tooltip" title="<?php echo $proportion_children_more_105_days_hepb3['numenator'];?>">Number of children received Hepatitis B3</span> / <br><span data-toggle="tooltip" title="<?php echo $proportion_children_more_105_days_hepb3['denominator'];?>">Number of children aged 105 days or more</span></div>
          </div>
        </div>

      </div>
    </div>


  </div>
  <div class="row">

    <div class="col-md-4 col-sm-6">
      <div id="pie-charts" class="dw-item bgm-bluegray c-white">

        <div class="dw-item">
          <div class="dwi-header">
            <div class="dwih-title">Proportion of chidren aged 9 months received Measles vaccination</div>
          </div>

          <div class="clearfix"></div>

          <div class="text-center p-20 m-t-25">
            <div class="easy-pie main-pie" data-percent="<?php echo $proportion_children_nine_months_more_measles['percent'];?>">
              <div class="percent"><?php echo $proportion_children_nine_months_more_measles['percent'];?></div>
            </div>
              <div class="pie-title"><span data-toggle="tooltip" title="<?php echo $proportion_children_nine_months_more_measles['numenator'];?>">Number of children received Measles</span> /<br><span data-toggle="tooltip" title="<?php echo $proportion_children_nine_months_more_measles['denominator'];?>">Number of children aged 9 months</span></div>
          </div>
        </div>

      </div>
    </div>
    <div class="col-md-4 col-sm-6">
      <div id="pie-charts" class="dw-item bgm-brown c-white">

        <div class="dw-item">
          <div class="dwi-header">
            <div class="dwih-title">Proportion of chidren aged 9 months received Vitamin A</div>
          </div>

          <div class="clearfix"></div>

          <div class="text-center p-20 m-t-25">
            <div class="easy-pie main-pie" data-percent="<?php echo $proportion_children_nine_months_more_vitamin_a['percent'];?>">
              <div class="percent"><?php echo $proportion_children_nine_months_more_vitamin_a['percent'];?></div>
            </div>
              <div class="pie-title"><span data-toggle="tooltip" title="<?php echo $proportion_children_nine_months_more_vitamin_a['numenator'];?>">Number of children received Vitamin A</span> / <br><span data-toggle="tooltip" title="<?php echo $proportion_children_nine_months_more_vitamin_a['denominator'];?>">Number of children aged 9 months</span></div>
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