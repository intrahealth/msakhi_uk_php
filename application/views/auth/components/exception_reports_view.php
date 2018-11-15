<section id="content" >
<?php foreach ($role_permission as $row) { if ($row->Controller == "Exception_reports" && $row->Action ==  "index") {
  ?>


  <div class="row">
    <div class="col-sm-12 col-md-6">
      <div class="mini-charts-item bgm-lightgreen">
        <div class="clearfix">
          <div class="chart stats-bar"><canvas width="68" height="105" style="display: inline-block; width: 68px; height: 105px; vertical-align: top;"></canvas></div>
          <div class="count">
            <large>Total Pregnent Women more then 10 month LMP date</large>
            <h2><?php// echo $household_count;?></h2>
            <p class="card-text">List of pregnant women marked pregnant with 11 months of LMP.</p>
            <a href="<?php echo site_url() ?>Exception_reports/pregnant_women_more_than_10_months_lmp" class="btn btn-primary">Get List</a>
          </div>
        </div>
      </div>
    </div>

    <div class="col-sm-12 col-md-6">
      <div class="mini-charts-item bgm-amber">
        <div class="clearfix">
          <div class="chart stats-line"><canvas width="68" height="105" style="display: inline-block; width: 68px; height: 105px; vertical-align: top;"></canvas></div>
          <div class="count">
            <large>List of children in tblchild having age greater than 15 years</large>
            <h2><?php //echo $child_registration_count;?></h2>
            <p class="card-text">List of children in tblchild having age greater than 15 years and more in table .</p>
            <a href="<?php echo site_url() ?>Exception_reports/children_in_tblchild_more_than_15_years" class="btn btn-primary">Get List</a>
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
            <large>list of households having more then 1 family members with relation ID 1</large>
            <h2><?php //echo $child_registration_count;?></h2>
            <p class="card-text">list of households they are more then 1 family members with relation ID 1 at their home.</p>
            <a href="<?php echo site_url() ?>Exception_reports/list_of_households_having_more_then_1_family_members_with_relation_ID_1" class="btn btn-primary">Get List</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php } } ?>
</section>