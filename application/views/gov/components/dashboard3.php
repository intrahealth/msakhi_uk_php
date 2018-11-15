<style>
  .dw-item
  {
    min-height: 220px;
  }
  .easy-pie.main-pie .percent{
    font-size: 30px;
    margin-top: 59px;
  }

  .chart {
    width: 100%; 
    min-height: 450px;
  }
</style>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">

  google.charts.load('current', {'packages':['corechart']});

  function chartDownload(uri, fileName)
  {
    var url = uri.replace(/^data:image\/[^;]/, 'data:image/png');

    var downloadLink = document.createElement("a");
    downloadLink.href = url;
    downloadLink.download = fileName;

    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.removeChild(downloadLink);

  }

</script>


<section id="content" >

  <div class="block-header">
    <h2 style="color: #adadad">Dashboard</h2>
    <?php $filter_data = $this->session->userdata('filter_data');
    if ($filter_data != NULL) { ?>
    <span style="color: white !important;">
      applied filters: <br>
      ANM: <?php if ($filter_data['ANM'] == NULL) {
        echo 'ALL';
      }else{
        echo $this->Dashboard3_model->get_anm_name_by_id($filter_data['ANM']);
      } ?> <br>

      Asha: <?php if ($filter_data['Asha'] == NULL) {
        echo 'ALL';
      }else{
        echo $this->Dashboard3_model->get_asha_name_by_id($filter_data['Asha']);
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

<div class="row">
  <div class="col-xs-12 col-sm-12 col-lg-12">
    <div class="card">
      <div class="card-header">
        <h2>Demographics / HH detail</h2>

        <br>

        <div class="row">
          <div class="col-md-6">
            <table class="table table-hover table-condensed table-vmiddle">
              <thead>
                <tr>
                  <th>Population</th>
                  <th></th>
                  <th>%</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Total Population</td>
                  <td><?php echo $demographic['total_population']['count'];?></td>
                  <td><?php echo number_format($demographic['total_population']['percent'],1);?></td>
                </tr>
                <tr>
                  <td>Women 15-49 years currently married</td>
                  <td><?php echo $demographic['woman_age_15_49_years']['count'];?></td>
                  <td><?php echo number_format($demographic['woman_age_15_49_years']['percent'],1);?></td>
                </tr>
                <tr>
                  <td>Currently pregnant women in the area</td>
                  <td><?php echo $demographic['total_pregnant_women_in_area']['count'];?></td>
                  <td><?php echo number_format($demographic['total_pregnant_women_in_area']['percent'],1);?></td>
                </tr>
                <tr>
                  <td>Children 0-5 years</td>
                  <td><?php echo $demographic['children_age_months_0_60']['count'];?></td>
                  <td><?php echo number_format($demographic['children_age_months_0_60']['percent'],1);?></td>
                </tr>
                <tr>
                  <td>Adults aged 35-50 years</td>
                  <td><?php echo $demographic['adults_aged_35_50_years']['count'];?></td>
                  <td><?php echo number_format($demographic['adults_aged_35_50_years']['percent'],1);?></td>
                </tr>
                <tr>
                  <td>Adults age 60+ yrs</td>
                  <td><?php echo $demographic['adults_aged_60_years_and_more']['count'];?></td>
                  <td><?php echo number_format($demographic['adults_aged_60_years_and_more']['percent'], 1);?></td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="col-md-6">

            <table class="table table-hover table-condensed table-vmiddle">
              <thead>
                <tr>
                  <th>Children</th>
                  <th>Male</th>
                  <th>Female</th>
                  <th>Total</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>0-5 years</td>
                  <td><?php echo number_format($children['children_age_months_0_60_gender']['male']);?></td>
                  <td><?php echo number_format($children['children_age_months_0_60_gender']['female']);?></td>
                  <td><?php echo number_format($children['children_age_months_0_60_gender']['total']);?></td>
                </tr>
                <tr>
                  <td>0 months to <=6 months</td>
                  <td><?php echo number_format($children['children_age_months_0_6_gender']['male']);?></td>
                  <td><?php echo number_format($children['children_age_months_0_6_gender']['female']);?></td>
                  <td><?php echo number_format($children['children_age_months_0_6_gender']['total']);?></td>
                </tr>
                <tr>
                  <td>More than 6 months to <= 1 year</td>
                  <td><?php echo number_format($children['children_age_months_7_12_gender']['male']);?></td>
                  <td><?php echo number_format($children['children_age_months_7_12_gender']['female']);?></td>
                  <td><?php echo number_format($children['children_age_months_7_12_gender']['total']);?></td>
                </tr>
                <tr>
                  <td>> 1 yr to <= 2 yr</td>
                  <td><?php echo number_format($children['children_age_months_12_24_gender']['male']);?></td>
                  <td><?php echo number_format($children['children_age_months_12_24_gender']['female']);?></td>
                  <td><?php echo number_format($children['children_age_months_12_24_gender']['total']);?></td>
                </tr>
                <tr>
                  <td>> 2 yr to <= 3 yr</td>
                  <td><?php echo number_format($children['children_age_months_24_36_gender']['male']);?></td>
                  <td><?php echo number_format($children['children_age_months_24_36_gender']['female']);?></td>
                  <td><?php echo number_format($children['children_age_months_24_36_gender']['total']);?></td>
                </tr>
                <tr>
                  <td>> 3 yr to <= 5 yr</td>
                  <td><?php echo number_format($children['children_age_months_36_60_gender']['male']);?></td>
                  <td><?php echo number_format($children['children_age_months_36_60_gender']['female']);?></td>
                  <td><?php echo number_format($children['children_age_months_36_60_gender']['total']);?></td>
                </tr>
              </tbody>
            </table>
            

          </div>
        </div>
        
      </div>
    </div>
  </div>
</div>

<div class="row">

  <?php foreach ($indicator_group_list as $indicator_group_row) { ?>

  <div class="col-xs-12 col-sm-12 col-lg-12">
    <div class="card">
      <div class="card-header">
        <h2><?php echo $indicator_group_row->name;?></h2>

        <ul class="actions">

          <li>
            <a href="">
              <i class="zmdi zmdi-refresh-alt"></i>
            </a>
          </li>
          <!-- <li>
            <a href="<?php echo site_url("gov/Dashboard3/" . $indicator_group_row->pie_controller);?>">
              <i class="zmdi zmdi-format-list-bulleted zmdi-hc-fw"></i>
            </a>
          </li> -->
          <li>
            <a onclick="chartDownload(imgUri<?php echo $indicator_group_row->id;?>, '<?php echo $indicator_group_row->name . ".png";?>'); return false;">
              <i class="zmdi zmdi-download"></i>
            </a>
          </li>

        </ul>
      </div>
      <div id="chart_div<?php echo $indicator_group_row->id;?>"></div>
      <script type="text/javascript">

        google.charts.setOnLoadCallback(drawChart<?php echo $indicator_group_row->id;?>);

        var chart<?php echo $indicator_group_row->id;?>;
        var imgUri<?php echo $indicator_group_row->id;?>;

        function drawChart<?php echo $indicator_group_row->id;?>() {

          var color = '<?php echo $indicator_group_row->color;?>';
          var ChartTitle = '<?php echo $indicator_group_row->name;?>';
          var xtitle = 'Proportion';
          var ytitle = 'Indicator';

          var data = new google.visualization.DataTable();

          data.addColumn('string', 'Label');
          data.addColumn('number', 'Total');
          data.addColumn({label: 'Style', type: 'string', role: 'style'});
          data.addColumn('number', 'Indicator');

          <?php 
          $indicator_list = $this->Dashboard3_model->get_indicator_of_group($indicator_group_row->id);
          ?>

          data.addRows(<?php echo count($indicator_list);?>);

          <?php 
          $i = 0;
          foreach ($indicator_list as $irow) { ?>

            data.setValue(<?php echo $i;?>, 0, "<?php echo $irow->description;?>");
            data.setValue(<?php echo $i;?>, 1, <?php echo $this->Dashboard3_model->get_indicator_proportion($irow->id)["percent"];?>);
            data.setValue(<?php echo $i;?>, 2, "color: <?php echo $irow->color;?>");
            data.setValue(<?php echo $i;?>, 3, <?php echo $irow->id;?>);

            <?php 
            $i++;
          } ?>

          // data.sort({ column: 1, desc: true });

          var DisView<?php echo $indicator_group_row->id;?> = new google.visualization.DataView(data);
          DisView<?php echo $indicator_group_row->id;?>.setColumns([0, 1, 2]);

          // chart<?php echo $indicator_group_row->id;?> = new google.visualization.ColumnChart(document.getElementById("chart_div<?php echo $indicator_group_row->id;?>"));

          chart<?php echo $indicator_group_row->id;?> = new google.visualization.BarChart(document.getElementById("chart_div<?php echo $indicator_group_row->id;?>"));

          google.visualization.events.addListener(chart<?php echo $indicator_group_row->id;?>, 'ready', function () {
            imgUri<?php echo $indicator_group_row->id;?> = chart<?php echo $indicator_group_row->id;?>.getImageURI();
            console.log('chart loaded and set the imgUri');
          });

          chart<?php echo $indicator_group_row->id;?>.draw(
            DisView<?php echo $indicator_group_row->id;?>, 
            {
              height: <?php echo $i * 50;?>, 
              legend:'none', 
              title: ChartTitle,
              'chartArea': {left:500,top:20,'width': '70%', 'height': '75%'},
              hAxis: { title: xtitle, textStyle : {
                fontSize: 12
              } },
              vAxis: { title: ytitle,
                textStyle: {
                  fontSize: 12
                }
              }});

          google.visualization.events.addListener(chart<?php echo $indicator_group_row->id;?>, 'select', function () {
            var selection = chart<?php echo $indicator_group_row->id;?>.getSelection();
            if (selection.length) {

              var row = selection[0].row;
              var categoryID = row + 1;
              console.log(categoryID);

              var indicator_id = data.getValue(row, 3);
              makeChartDialog(indicator_id);

            }
          });

        }

        $(window).resize(function(){
          drawChart<?php echo $indicator_group_row->id;?>();
        });

      </script>
    </div>
  </div>

  <?php } ?>

</div>

<div id="chart_C11"></div>

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
    var anmid = $('#ANM').val();
    $.post('<?php echo site_url("gov/ajax/getAshaOfAnm/");?>' + '/' + anmid, {}, function(raw){
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

  var dialogChart;
  function makeChartDialog(indicator_id){

    dialogChart = $('#div_chart_dialog').dialog({
      autoOpen:true,
      width:screen.width - 200,
      height:540,
      title: 'Loading ...',
      modal: true,
      buttons: {
        Cancel: function() {
          dialogChart.dialog( "close" );
        }
      },
      close: function() {
        $('#div_chart_dialog').dialog('destroy');
      },
      buttons: [
      {
        text: "Download Chart",
        click: function(){
          chartDownload(ZoomImgUri, 'Export.png');
        }
      },
      {
        text: "Close",
        click: function(){
          $('#div_chart_dialog').dialog('destroy');
        }
      }
      ],
      open: function(){

        $.get('<?php echo site_url('gov/dashboard/get_indicator_trend');?>/' + indicator_id, function(raw){

          var response = $.parseJSON(raw);
          var responseData = response.data;
          var ChartTitle = response.description;
          var color = response.color;
          var xtitle = 'month';
          var ytitle = 'number';

          $('#div_chart_dialog').dialog('option', 'title', ChartTitle);

          var data = new google.visualization.DataTable();

          data.addColumn('string', 'Label');
          data.addColumn('number', 'Total');

          data.addRows(responseData.length);

          for (var i = responseData.length - 1; i >= 0; i--) {
            data.setValue(i, 0, responseData[i].label);
            data.setValue(i, 1, parseInt(responseData[i].total));
          }

          // data.sort({ column: 1, desc: false });

          var DisView = new google.visualization.DataView(data);
          DisView.setColumns([0, 1]);

          Zoomchart = new google.visualization.LineChart(document.getElementById("chart_div"));

          var options = {
            /*chartArea: {
              left: 70,
              width: 800,
              right: 30
            },
            width: 840, */
            height: 415,
            fontSize: 11,
            pointSize: 10,
            colors: [
            color
            ],
            title: ChartTitle,
            legend: 'none',
            backgroundColor: '#ffffff',
            hAxis: {
              title: xtitle,
              titleTextStyle: {
                color: '#6C6F7A',
                italic: false,
                bold: true
              }
            },
            vAxis: {
              title: ytitle,
              titleTextStyle: {
                color: '#6C6F7A',
                italic: false,
                bold: true
              },
              logScale: false
            }
          };

          google.visualization.events.addListener(Zoomchart, 'ready', function () {
            ZoomImgUri = Zoomchart.getImageURI();
            console.log('chart loaded and set the imgUri');
          });

          Zoomchart.draw(DisView, options);

        });

      },
    }); 

  }

</script>