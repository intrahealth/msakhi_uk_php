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
  <?php foreach ($role_permission as $row) { if ($row->Controller == "Process_indicators" && $row->Action == "index") { ?>

  <div class="block-header">
    <h2 style="color: #adadad">Process Dashboard</h2>
    <?php $filter_data = $this->session->userdata('filter_data_list');
    // print_r($filter_data); die();

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
      <?php if ($this->session->userdata('loginData')->user_role == 5) { ?>
      State: <?php if ($filter_data['State'] == NULL) {
        echo 'ALL';
      }else{

        foreach ($filter_data['State'] as $stataecode) {
          $a_list[] = $this->Dashboard4_model->get_state_by_code($stataecode);
        }
        echo implode(", ", $a_list);
        
      } }?> <br>

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

<?php
//echo "<pre>";
//print_r($data);
foreach ($data as $row) {

  $user_name_list[] = $row->user_name;

  $asha_name_list[] = $row->ASHAName;
  $asha_id_list[] = $row->ASHAID;
  
  $anm_name_list[] = $row->ANMName;
  $anm_id_list[] = $row->ANMID;

  $anm_login_id_list[] = $row->anm_login_id;

  $hh_records_created[] = $row->hh_records_created;
  $hh_records_updated[] = $row->hh_records_updated;
  $hh_records_uploaded[] = $row->hh_records_uploaded;
  $anc_checkup_created[] = $row->anc_checkup_created;
  $anc_checkup_updated[] = $row->anc_checkup_updated;
  $anc_checkup_uploaded[] = $row->anc_checkup_uploaded;
  $new_pregnancies_added[] = $row->new_pregnancies_added;
  $new_pregnancies_updated[] = $row->new_pregnancies_updated;
  $new_pregnancies_uploaded[] = $row->new_pregnancies_uploaded;
  $anc_checkups_added_updated[] = $row->anc_checkups_added_updated;
  $new_child_added[] = $row->new_child_added;
  $existing_child_updated[] = $row->existing_child_updated;
  $child_uploaded[] = $row->child_uploaded;
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
  $ncd_cbac_update[] = $row->ncd_cbac_update;
  $ncd_cbac_uploads[] = $row->ncd_cbac_uploads;
  $ncd_followup_updates[] = $row->ncd_followup_updates;
  $ncd_followup_uploads[] = $row->ncd_followup_uploads;
  $ncd_screening_updates[] = $row->ncd_screening_updates;
  $ncd_screening_uploads[] = $row->ncd_screening_uploads;

}

$column_count = count($asha_id_list);

// Prepare column headings 
$heading[0] = "How many HH details created (addition)";
$heading[1] = "How many HH details updated (update/deletion)";
$heading[2] = "How many HH details uploaded (upload)";
$heading[3] = "How many ANC check-up details (created)";
$heading[4] = "How many ANC check-up details (updated)";
$heading[5] = "How many ANC check-up details (uploaded)";
$heading[6] = "How many pregnancies added";
$heading[7] = "How many pregnancies updated";
$heading[8] = "How many pregnancies uploaded";
$heading[9] = "How many ANC check-ups date updated/added";
$heading[10] = "How many child added";
$heading[11] = "How many existing children data updated";
$heading[12] = "How many child uploaded";
$heading[13] = "How many counselling done through mSakhi for Immunisation";
$heading[14] = "How many home ANC home visits done";
$heading[15] = "How many PNC home visits done";
$heading[16] = "How many follow-up done for FP";
$heading[17] = "How many counselling done for FP";
$heading[18] = "How many updates made in - NCD CBAC";
$heading[19] = "How many uploads made in - NCD CBAC";
$heading[20] = "How many updates made in - NCD Followup";
$heading[21] = "How many uploads made in - NCD Followup";
$heading[22] = "How many updates made in - NCD screening";
$heading[23] = "How many uploads made in - NCD screening";

?>



<div class="card" style="overflow: auto; padding: 5px; height: 500px;">
  <table id="fixTable" class="table table-hover table-condensed table-vmiddle">
    <thead>
      <tr class="anm_row">
        <th class="col-md-4">ANM Name</th>
        <?php
        $anm_array = array_count_values($anm_name_list);
        $log_array = array_count_values($anm_login_id_list);
        $anm = array();
        $i = 0;
        foreach ($anm_array as $key => $value){
          $anm[$i]['colspan'] = $value;
          $anm[$i]['anm_name'] = $key;
          $i++;
        }
        $i = 0;
        foreach ($log_array as $key => $value){
          $anm[$i]['log_name'] = $key;
          $i++;
        }
        // print_r($anm); die();
        foreach ($anm as $row) {
          ?>
          <th colspan="<?php echo $row['colspan'];?>" class="col-md-3" style="text-align: center; border: 2px solid black; background-color: rgb(240, 188, 0);"><?php echo $row['anm_name'].'('.$row['log_name'].')';?></th>
          <?php } ?>
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
          <td class="<?php echo ($hh_records_created[$i]<1?"danger":"success");?>"><?php echo $hh_records_created[$i];?></td>
          <?php } ?>
        </tr>

        <tr>
          <td class="col-md-3"><?php echo $heading[1];?></td>
          <?php for ($i=0; $i < $column_count; $i++) { ?>
          <td class="<?php echo ($hh_records_updated[$i]<1?"danger":"success");?>"><?php echo $hh_records_updated[$i];?></td>
          <?php } ?>
        </tr>

        <tr>
          <td class="col-md-3"><?php echo $heading[2];?></td>
          <?php for ($i=0; $i < $column_count; $i++) { ?>
          <td class="<?php echo ($hh_records_uploaded[$i]<1?"danger":"success");?>"><?php echo $hh_records_uploaded[$i];?></td>
          <?php } ?>
        </tr>

        <tr>
          <td class="col-md-3"><?php echo $heading[3];?></td>
          <?php for ($i=0; $i < $column_count; $i++) { ?>
          <td class="<?php echo ($anc_checkup_created[$i]<1?"danger":"success");?>"><?php echo $anc_checkup_created[$i];?></td>
          <?php } ?>
        </tr>

        <tr>
          <td class="col-md-3"><?php echo $heading[4];?></td>
          <?php for ($i=0; $i < $column_count; $i++) { ?>
          <td class="<?php echo ($anc_checkup_updated[$i]<1?"danger":"success");?>"><?php echo $anc_checkup_updated[$i];?></td>
          <?php } ?>
        </tr>

        <tr>
          <td class="col-md-3"><?php echo $heading[5];?></td>
          <?php for ($i=0; $i < $column_count; $i++) { ?>
          <td class="<?php echo ($anc_checkup_uploaded[$i]<1?"danger":"success");?>"><?php echo $anc_checkup_uploaded[$i];?></td>
          <?php } ?>
        </tr>

        <tr>
          <td class="col-md-3"><?php echo $heading[6];?></td>
          <?php for ($i=0; $i < $column_count; $i++) { ?>
          <td class="<?php echo ($new_pregnancies_added[$i]<1?"danger":"success");?>"><?php echo $new_pregnancies_added[$i];?></td>
          <?php } ?>
        </tr>
        
        <tr>
          <td class="col-md-3"><?php echo $heading[7];?></td>
          <?php for ($i=0; $i < $column_count; $i++) { ?>
          <td class="<?php echo ($new_pregnancies_updated[$i]<1?"danger":"success");?>"><?php echo $new_pregnancies_updated[$i];?></td>
          <?php } ?>
        </tr>

        <tr>
          <td class="col-md-3"><?php echo $heading[8];?></td>
          <?php for ($i=0; $i < $column_count; $i++) { ?>
          <td class="<?php echo ($new_pregnancies_uploaded[$i]<1?"danger":"success");?>"><?php echo $new_pregnancies_uploaded[$i];?></td>
          <?php } ?>
        </tr>

        <tr>
          <td class="col-md-3"><?php echo $heading[9];?></td>
          <?php for ($i=0; $i < $column_count; $i++) { ?>
          <td class="<?php echo ($anc_checkups_added_updated[$i]<1?"danger":"success");?>"><?php echo $anc_checkups_added_updated[$i];?></td>
          <?php } ?>
        </tr>

        <tr>
          <td class="col-md-3"><?php echo $heading[10];?></td>
          <?php for ($i=0; $i < $column_count; $i++) { ?>
          <td class="<?php echo ($new_child_added[$i]<1?"danger":"success");?>"><?php echo $new_child_added[$i];?></td>
          <?php } ?>
        </tr>

        <tr>
          <td class="col-md-3"><?php echo $heading[11];?></td>
          <?php for ($i=0; $i < $column_count; $i++) { ?>
          <td class="<?php echo ($existing_child_updated[$i]<1?"danger":"success");?>"><?php echo $existing_child_updated[$i];?></td>
          <?php } ?>
        </tr>

        <tr>
          <td class="col-md-3"><?php echo $heading[12];?></td>
          <?php for ($i=0; $i < $column_count; $i++) { ?>
          <td class="<?php echo ($child_uploaded[$i]<1?"danger":"success");?>"><?php echo $child_uploaded[$i];?></td>
          <?php } ?>
        </tr>

        <tr>
          <td class="col-md-3"><?php echo $heading[13];?></td>
          <?php for ($i=0; $i < $column_count; $i++) { ?>
          <td class="<?php echo ($immunuzation_counselling_done[$i]<1?"danger":"success");?>"><?php echo $immunuzation_counselling_done[$i];?></td>
          <?php } ?>
        </tr>

        <tr>
          <td class="col-md-3"><?php echo $heading[14];?></td>
          <?php for ($i=0; $i < $column_count; $i++) { ?>
          <td class="<?php echo ($anc_homevisit_done[$i]<1?"danger":"success");?>"><?php echo $anc_homevisit_done[$i];?></td>
          <?php } ?>
        </tr>

        <tr>
          <td class="col-md-3"><?php echo $heading[15];?></td>
          <?php for ($i=0; $i < $column_count; $i++) { ?>
          <td class="<?php echo ($pnc_homevisit_done[$i]<1?"danger":"success");?>"><?php echo $pnc_homevisit_done[$i];?></td>
          <?php } ?>
        </tr>

        <tr>
          <td class="col-md-3"><?php echo $heading[16];?></td>
          <?php for ($i=0; $i < $column_count; $i++) { ?>
          <td class="<?php echo ($fp_followup_done[$i]<1?"danger":"success");?>"><?php echo $fp_followup_done[$i];?></td>
          <?php } ?>
        </tr>

        <tr>
          <td class="col-md-3"><?php echo $heading[17];?></td>
          <?php for ($i=0; $i < $column_count; $i++) { ?>
          <td class="<?php echo ($fp_counselling_done[$i]<1?"danger":"success");?>"><?php echo $fp_counselling_done[$i];?></td>
          <?php } ?>
        </tr>

        <tr>
          <td class="col-md-3"><?php echo $heading[18];?></td>
          <?php for ($i=0; $i < $column_count; $i++) { ?>
          <td class="<?php echo ($ncd_cbac_update[$i]<1?"danger":"success");?>"><?php echo $ncd_cbac_update[$i];?></td>
          <?php } ?>
        </tr>

       <tr>
          <td class="col-md-3"><?php echo $heading[19];?></td>
          <?php for ($i=0; $i < $column_count; $i++) { ?>
          <td class="<?php echo ($ncd_cbac_uploads[$i]<1?"danger":"success");?>"><?php echo $ncd_cbac_uploads[$i];?></td>
          <?php } ?>
        </tr>

        <tr>
          <td class="col-md-3"><?php echo $heading[20];?></td>
          <?php for ($i=0; $i < $column_count; $i++) { ?>
          <td class="<?php echo ($ncd_followup_updates[$i]<1?"danger":"success");?>"><?php echo $ncd_followup_updates[$i];?></td>
          <?php } ?>
        </tr>

        <tr>
          <td class="col-md-3"><?php echo $heading[21];?></td>
          <?php for ($i=0; $i < $column_count; $i++) { ?>
          <td class="<?php echo ($ncd_followup_uploads[$i]<1?"danger":"success");?>"><?php echo $ncd_followup_uploads[$i];?></td>
          <?php } ?>
        </tr>

       <tr>
          <td class="col-md-3"><?php echo $heading[22];?></td>
          <?php for ($i=0; $i < $column_count; $i++) { ?>
          <td class="<?php echo ($ncd_screening_updates[$i]<1?"danger":"success");?>"><?php echo $ncd_screening_updates[$i];?></td>
          <?php } ?>
        </tr>

        <tr>
          <td class="col-md-3"><?php echo $heading[23];?></td>
          <?php for ($i=0; $i < $column_count; $i++) { ?>
          <td class="<?php echo ($ncd_screening_uploads[$i]<1?"danger":"success");?>"><?php echo $ncd_screening_uploads[$i];?></td>
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

              <?php if ($this->session->userdata('loginData')->user_role == 5) { ?>
              <div class="row">        
                <div class="col-md-6 form-group">
                  <label for="State">State</label>
                  <select name="State[]" id="State" class="form-control fg-line" multiple="multiple" style="width: 75%">
                    <option value="">--select--</option>
                    <?php foreach ($state_list as $row) { ?>
                    <option value="<?php echo $row->StateCode;?>" <?php  if(!empty($filter_data['State'])) echo (in_array($row->StateCode, (is_array($filter_data['State']) ? $filter_data['State'] : array()) ) ? "selected":"");?>><?php echo $row->StateName;?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <?php } ?>


              <div class="row">        
                <div class="col-md-6 form-group">
                  <label for="ANM">Select ANM</label>
                  <select name="ANM[]" id="ANM" class="form-control fg-line" multiple="multiple" onchange="get_asha_list()" style="width: 75%">
                    <option value="">--select--</option>
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
                    <option value="<?php echo $asha_row->ASHAID;?>" <?php if(!empty($filter_data['Asha'])) echo (in_array($asha_row->ASHAID ,$filter_data['Asha']) ? "selected" : "");?>><?php echo $asha_row->ASHAName . '('.$asha_row->user_name.')';?></option>
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

  <?php } } ?>

  <script>

    function showFilterDialog() {
      $('#myModal').modal('show');
    }

    function get_asha_list() {
      var anm_list = $('#ANM').val();
      var asha_list = $('#Asha').val();

      $.post('<?php echo site_url("ajax/getAshaOfAnmDashboard4");?>', {anm_list : anm_list, asha_list : asha_list}, function(raw){

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
      $('#State').select2();

      $("#fixTable").tableHeadFixer({"left" : 1});

    });

    function export_excel() {
     $('.anm_row').remove();
     $("#fixTable").tableToCSV();
   }

 </script>