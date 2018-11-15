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
    <?php foreach ($role_permission as $row) { if ($row->Controller == "immunizations" && $row->Action == "edit_immunization_counselling") { ?>

  <div class="panel panel-default">
    <div class="panel-heading">

      <span class="panel-title" style="text-align: middle;"><b>Immunization</b>      
    </span>

  </div>

  <div class="card">0
    <div class="row">
      <div class="col-lg-12">

            <div class="table-responsive">
        <table class="table table-striped table-vmiddle table table-condensed" id="immunization">
          <thead>

            <tr class="success">
              <th>
                <b>Name</b>
              </th>
              <th>
                <b>Date</b>
              </th>

              <th data-column-id="commands" data-formatter="commands" data-sortable="false">Immunization Counselling</th>
              
            </tr>

          </thead>
          <tbody>


            <?php foreach ($datalist as $row) {?>
              <tr><td>dfgf</td>
                <td>dewe</td>
              </tr>


               <tr><td>dsfds</td>
                <td>fewfewf</td>
              </tr>
            <?php } ?>
            <!-- <tr>
              <td>
              Hep(Birth dose)
            </td>
            <td>
              fsdfds

            </td>
          </tr>
          <tr>
              <td>
              fdsf
            </td>
            <td>
             fdgd

            </td>
          </tr> -->


            </tbody>
          </table>
        </div>
        </div>
      </div>
    </div>
  </div>

<?php } } ?>
</section>


  <!-- Data Table -->
          <script type="text/javascript">
            $(document).ready(function(){
//Command Buttons
$("#immunization").bootgrid({
  css: {
    icon: 'zmdi icon',
    iconColumns: 'zmdi-view-module',
    iconDown: 'zmdi-expand-more',
    iconRefresh: 'zmdi-refresh',
    iconUp: 'zmdi-expand-less'
  },
  formatters: {
    "commands": function(column, row) {

      return  "<a href=\"<?php echo site_url('immunizations/edit');?>/" + row.HHSurveyGUID + "\" type=\"button\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\"" + row.id +"\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"\" data-original-title= \"View Activities\"><span class=\"zmdi zmdi-view-list\"></span></a>"

      +

      "<?php foreach ($role_permission as $row) { if ($row->Controller == "district" && $row->Action == "delete"){ ?><a href=\"<?php echo site_url('district/delete');?>/" + row.DistrictCode + "\" type=\"button\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\"" + row.id + "\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"\" data-original-title=\"Delete\"><span class=\"zmdi zmdi-delete\"></span></a><?php } } ?>";
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