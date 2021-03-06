<style>
  #fixTable table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
  }

  #fixTable td, th {
    border: 1px solid #fff;
    text-align: left;
    padding: 8px;
  }
</style>


<section id="content" >

  <div class="block-header">
    <h2 style="color: #adadad">Process Dashboard</h2>
    <?php $filter_data = $this->session->userdata('filter_data_list');

    if ($filter_data != NULL) { ?>
    <span style="color: white !important;">
      applied filters: <br>
      ANM: <?php if ($filter_data['ANM'] == NULL) {
        echo 'ALL';
      }else{

        foreach ($filter_data['ANM'] as $ANMID) {
          $a_list[] = $this->Dashboard4_model->get_anm_name_by_id($ANMID);
        }
        echo implode(", ", $a_list);
        
      } ?> <br>

      Asha: <?php if ($filter_data['Asha'] == NULL) {
        echo 'ALL';
      }else{

        foreach ($filter_data['Asha'] as $ASHAID) {
          $b_list[] = $this->Dashboard4_model->get_asha_name_by_id($ASHAID);
        }
        echo implode(", ", $b_list);

      } ?> <br>

      Date Range: <?php if ($filter_data['date_from'] == NULL) {
        echo 'ALL';
      }else{
        echo $filter_data['date_from'] . ' to ' . $filter_data['date_to'];
      } ?> <br>

    </span>
    <?php }else{ ?>
    <span style="color: white !important;">No filters applied</span>
    <?php } ?>

    <ul class="actions">

      <li style="padding-right: 10px;">
        <form action="" method="post">
          <select name="filterPeriod" id="filterPeriod" onchange="this.form.submit()">
            <option value="0" <?php echo (set_value("filterPeriod") == 0? "selected" : "");?>> -- ALL -- </option>
            <option value="1" <?php echo (set_value("filterPeriod") == 1? "selected" : "");?>>Last Month</option>
            <option value="2" <?php echo (set_value("filterPeriod") == 2? "selected" : "");?>>Current Month</option>
            <option value="3" <?php echo (set_value("filterPeriod") == 3? "selected" : "");?>>Last Completed Quater</option>
            <option value="4" <?php echo (set_value("filterPeriod") == 4? "selected" : "");?>>Current Running Quater</option>
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
        <i class="fa fa-2x fa-filter" id="" name="" style="color: #ef8c5d; cursor: pointer; margin-right: 20px;margin-top: 10px;"></i>
      </a>

    </li>
    <li>

      <?php if (is_array($filter_data)) { ?>

      <a href="javascript:document.getElementById('clearForm').submit();" class="pull-right hvr-pulse-grow" id="btn-Preview-Image" data-toggle="tooltip" title="Clear Filter">
        <i class="fa fa-2x fa-filter" id="" name="" style="color: #7ade95; cursor: pointer; margin-right: 20px;margin-top: 10px;"></i>
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

<?php foreach ($data as $row) {

  $user_name_list[] = $row->user_name;

  $asha_name_list[] = $row->ASHAName;
  $asha_id_list[] = $row->ASHAID;
  
  $anm_name_list[] = $row->ANMName;
  $anm_id_list[] = $row->ANMID;

  $hh_records_updated[] = $row->hh_records_updated;
  $anc_checkup_updated[] = $row->anc_checkup_updated;
  $new_pregnancies_added[] = $row->new_pregnancies_added;
  $anc_checkups_added_updated[] = $row->anc_checkups_added_updated;
  $new_child_added[] = $row->new_child_added;
  $existing_child_updated[] = $row->existing_child_updated;
  $immunuzation_counselling_done[] = $row->immunuzation_counselling_done;
  $anc_homevisit_done[] = $row->anc_homevisit_done;
  $pnc_homevisit_done[] = $row->pnc_homevisit_done;
  $fp_followup_done[] = $row->fp_followup_done;
  $fp_counselling_done[] = $row->fp_counselling_done;
  $updates_household_details[] = $row->updates_household_details;
  $updates_mnch_module[] = $row->updates_mnch_module;
  $updates_mnch_anc_module[] = $row->updates_mnch_anc_module;
  $updates_mnch_newborn[] = $row->updates_mnch_newborn;
  $updates_mnch_homevisit[] = $row->updates_mnch_homevisit;
  $updates_fp_module[] = $row->updates_fp_module;

}

$column_count = count($asha_id_list);

// Prepare column headings 
$heading[0] = "How many HH details updated (addition/correction/deletion)";
$heading[1] = "How many ANC check-up details updated";
$heading[2] = "How many new pregnancies added";
$heading[3] = "How many ANC check-ups date updated/added";
$heading[4] = "How many new child added";
$heading[5] = "How many existing children data updated";
$heading[6] = "How many counselling done through mSakhi for Immunisation";
$heading[7] = "How many home ANC home visits done";
$heading[8] = "How many PNC home visits done";
$heading[9] = "How many follow-up done for FP";
$heading[10] = "How many counselling done for FP";
$heading[11] = "How many updates made in - Household details module";
$heading[12] = "How many updates made in - MNCH module";
$heading[13] = "How many updates made in - MNCH ANC submodule";
$heading[14] = "How many updates made in - MNCH Newborn submodule";
$heading[15] = "How many updates made in - MNCH Home visit submodule";
$heading[16] = "How many updates made in - FP module";

?>



<div class="card" style="overflow: auto; padding: 5px; height: 500px;">
  <table id="fixTable" class="table table-hover table-condensed table-vmiddle">
    <thead>
      <tr class="anm_row">
        <th class="col-md-4">ANM Name</th>
        <?php 
        $i = 0;
        $colspan = 0;
        $anm_id_old = $anm_id_list[0];
        $anm_name_old = $anm_name_list[0];
        $user_name_old = $user_name_list[0];
        $first = true;

        foreach ($asha_id_list as $asha_id) {
          $asha_name = $asha_name_list[$i];
          $anm_id = $anm_id_list[$i];
          $anm_name = $anm_name_list[$i];
          $user_name = $user_name_list[0];

          if ($anm_id != $anm_id_old) {
            ?>
            <th colspan="<?php echo $colspan;?>" class="col-md-3" style="text-align: center; border: 2px solid black; background-color: rgb(240, 188, 0);"><?php echo $anm_name_old . '('.$user_name_old.')';?></th>
            <?php 
            $colspan = 1;
          }else{
            $colspan++;
          }
          $anm_id_old = $anm_id;
          $anm_name_old = $anm_name;

          $i++;
        } ?>

        <th colspan="<?php echo $colspan;?>" class="col-md-3" style="text-align: center; border: 2px solid black; background-color: rgb(240, 188, 0);"><?php echo $anm_name_old;?></th>
      </tr>


      <tr>
        <th class="col-md-4">Indicator Name</th>
        <?php 
        $i = 0;
        foreach ($asha_id_list as $asha_id) {
          $asha_name = $asha_name_list[$i];
          ?>
          <th class="col-md-3"><?php echo $asha_name . '<br>('.$user_name_list[$i].')';?></th>
          <?php 
          $i++;
        } ?>
      </tr>

    </thead>
    <tbody>

      <tr>
        <td class="col-md-3"><?php echo $heading[0];?></td>
        <?php for ($i=0; $i < $column_count; $i++) { ?>
        <td class="<?php echo ($hh_records_updated[$i]<1?"danger":"success");?>"><?php echo $hh_records_updated[$i];?></td>
        <?php } ?>
      </tr>

      <tr>
        <td class="col-md-3"><?php echo $heading[1];?></td>
        <?php for ($i=0; $i < $column_count; $i++) { ?>
        <td class="<?php echo ($anc_checkup_updated[$i]<1?"danger":"success");?>"><?php echo $anc_checkup_updated[$i];?></td>
        <?php } ?>
      </tr>

      <tr>
        <td class="col-md-3"><?php echo $heading[2];?></td>
        <?php for ($i=0; $i < $column_count; $i++) { ?>
        <td class="<?php echo ($new_pregnancies_added[$i]<1?"danger":"success");?>"><?php echo $new_pregnancies_added[$i];?></td>
        <?php } ?>
      </tr>

      <tr>
        <td class="col-md-3"><?php echo $heading[3];?></td>
        <?php for ($i=0; $i < $column_count; $i++) { ?>
        <td class="<?php echo ($anc_checkups_added_updated[$i]<1?"danger":"success");?>"><?php echo $anc_checkups_added_updated[$i];?></td>
        <?php } ?>
      </tr>

      <tr>
        <td class="col-md-3"><?php echo $heading[4];?></td>
        <?php for ($i=0; $i < $column_count; $i++) { ?>
        <td class="<?php echo ($new_child_added[$i]<1?"danger":"success");?>"><?php echo $new_child_added[$i];?></td>
        <?php } ?>
      </tr>

      <tr>
        <td class="col-md-3"><?php echo $heading[5];?></td>
        <?php for ($i=0; $i < $column_count; $i++) { ?>
        <td class="<?php echo ($existing_child_updated[$i]<1?"danger":"success");?>"><?php echo $existing_child_updated[$i];?></td>
        <?php } ?>
      </tr>
      
      <tr>
        <td class="col-md-3"><?php echo $heading[6];?></td>
        <?php for ($i=0; $i < $column_count; $i++) { ?>
        <td class="<?php echo ($immunuzation_counselling_done[$i]<1?"danger":"success");?>"><?php echo $immunuzation_counselling_done[$i];?></td>
        <?php } ?>
      </tr>

      <tr>
        <td class="col-md-3"><?php echo $heading[7];?></td>
        <?php for ($i=0; $i < $column_count; $i++) { ?>
        <td class="<?php echo ($anc_homevisit_done[$i]<1?"danger":"success");?>"><?php echo $anc_homevisit_done[$i];?></td>
        <?php } ?>
      </tr>

      <tr>
        <td class="col-md-3"><?php echo $heading[8];?></td>
        <?php for ($i=0; $i < $column_count; $i++) { ?>
        <td class="<?php echo ($pnc_homevisit_done[$i]<1?"danger":"success");?>"><?php echo $pnc_homevisit_done[$i];?></td>
        <?php } ?>
      </tr>

      <tr>
        <td class="col-md-3"><?php echo $heading[9];?></td>
        <?php for ($i=0; $i < $column_count; $i++) { ?>
        <td class="<?php echo ($fp_followup_done[$i]<1?"danger":"success");?>"><?php echo $fp_followup_done[$i];?></td>
        <?php } ?>
      </tr>

      <tr>
        <td class="col-md-3"><?php echo $heading[10];?></td>
        <?php for ($i=0; $i < $column_count; $i++) { ?>
        <td class="<?php echo ($fp_counselling_done[$i]<1?"danger":"success");?>"><?php echo $fp_counselling_done[$i];?></td>
        <?php } ?>
      </tr>

      <tr>
        <td class="col-md-3"><?php echo $heading[11];?></td>
        <?php for ($i=0; $i < $column_count; $i++) { ?>
        <td class="<?php echo ($updates_household_details[$i]<1?"danger":"success");?>"><?php echo $updates_household_details[$i];?></td>
        <?php } ?>
      </tr>

      <tr>
        <td class="col-md-3"><?php echo $heading[12];?></td>
        <?php for ($i=0; $i < $column_count; $i++) { ?>
        <td class="<?php echo ($updates_mnch_module[$i]<1?"danger":"success");?>"><?php echo $updates_mnch_module[$i];?></td>
        <?php } ?>
      </tr>

      <tr>
        <td class="col-md-3"><?php echo $heading[13];?></td>
        <?php for ($i=0; $i < $column_count; $i++) { ?>
        <td class="<?php echo ($updates_mnch_anc_module[$i]<1?"danger":"success");?>"><?php echo $updates_mnch_anc_module[$i];?></td>
        <?php } ?>
      </tr>

      <tr>
        <td class="col-md-3"><?php echo $heading[14];?></td>
        <?php for ($i=0; $i < $column_count; $i++) { ?>
        <td class="<?php echo ($updates_mnch_newborn[$i]<1?"danger":"success");?>"><?php echo $updates_mnch_newborn[$i];?></td>
        <?php } ?>
      </tr>

      <tr>
        <td class="col-md-3"><?php echo $heading[15];?></td>
        <?php for ($i=0; $i < $column_count; $i++) { ?>
        <td class="<?php echo ($updates_mnch_homevisit[$i]<1?"danger":"success");?>"><?php echo $updates_mnch_homevisit[$i];?></td>
        <?php } ?>
      </tr>

      <tr>
        <td class="col-md-3"><?php echo $heading[16];?></td>
        <?php for ($i=0; $i < $column_count; $i++) { ?>
        <td class="<?php echo ($updates_fp_module[$i]<1?"danger":"success");?>"><?php echo $updates_fp_module[$i];?></td>
        <?php } ?>
      </tr>

    </tbody>
  </table>
</div>

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

              <div class="col-md-6 form-group">
                <label for="ANM">Select ANM</label>
                <select name="ANM[]" id="ANM" class="form-control fg-line" multiple="multiple" onchange="get_asha_list()" style="width: 75%">
                  <option value="">--select--</option>
                  <?php print_r($anm_list);?>
                  <?php foreach ($anm_list as $anm_row) { ?>
                  <option value="<?php echo $anm_row->ANMID;?>" <?php echo (in_array($anm_row->ANMID, (is_array($filter_data['ANM']) ? $filter_data['ANM'] : array()) ) ? "selected":"");?>><?php echo $anm_row->ANMName;?></option>
                  <?php } ?>
                </select>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 form-group">
                <label for="Asha">Select Asha</label>
                <select name="Asha[]" id="Asha" class="form-control fg-line" multiple="multiple" style="width: 75%">
                  <option value="">--select--</option>
                  <?php foreach ($asha_list as $asha_row) { ?>
                  <option value="<?php echo $asha_row->ASHAID;?>" <?php echo (in_array($asha_row->ASHAID ,$filter_data['Asha']) ? "selected" : "");?>><?php echo $asha_row->ASHAName . '('.$asha_row->user_name.')';?></option>
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



<div id="div_chart_dialog" style="display:none;">

  <div id="chart_div"></div>

</div>

<form action="" method="post" id="clearForm">
  <input type="hidden" name="command" value="clear_filter">
</form>

<script>

  function showFilterDialog() {
    $('#myModal').modal('show');
  }

  function get_asha_list() {
    var anm_list = $('#ANM').val();
    var asha_list = $('#Asha').val();

    $.post('<?php echo site_url("gov/ajax/getAshaOfAnmDashboard4");?>', {anm_list : anm_list, asha_list : asha_list}, function(raw){

      $('#Asha').html(raw);
      $('#Asha').select2();

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

    $('#ANM').select2();
    $('#Asha').select2();

    $("#fixTable").tableHeadFixer({"left" : 1});

  });

  function export_excel() {
    $('.anm_row').remove();
    $("#fixTable").tableToCSV();
  }

</script>