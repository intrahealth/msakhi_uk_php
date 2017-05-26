<section id="content">

    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">Filter</h4>
        </div>
        <div class="panel-body">
            <form action="" method="post">
                <div class="row">
                    <div class="formgroup col-lg-3">
                        <label for="from_date">From Date</label>
                        <input type="date" class="form-control" id="from_date" name="from_date" value="<?php echo $from_date;?>">
                    </div>

                    <div class="formgroup col-lg-3">
                        <label for="to_date">To Date</label>
                        <input type="date" class="form-control" id="to_date" name="to_date" value="<?php echo $to_date;?>">
                    </div>

                    <div class="formgroup col-lg-2">
                        <button name="apply_filter" value="apply_filter" class="form-control btn btn-info" style="margin-top : 25px;">Apply Filter</button>
                    </div>

                    <div class="formgroup col-lg-2">
                        <button name="clear_filter"  value="clear_filter" class="form-control btn btn-default" style="margin-top : 25px;">Clear Filter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">Household Data <?php if ($from_date != NULL) {
                echo "( " . $from_date . " to " . $to_date . " )"; 
            } ?></h4>
            
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-12">

                    <table class="table table-striped table-bordered table-vmiddle table-hover">
                        <thead>
                            <tr>
                                <th>Indicator</th>
                                <th>Count</th>
                                <th>Graph</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Total Population</td>
                                <td><?php  print $pouplation[0]->totalPopulation;?></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Number of Women 15-49 years</td>
                                <td><?php  print $pouplation[0]->NumofWomenFifteentofortyNine ;?></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Number of children 0-6 months</td>
                                <td><?php  print $ChildAgeInMonth_list['zeroToSixMonth']; ?></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Number of children 6 months-1 year</td>
                                <td><?php  print $ChildAgeInMonth_list['sixToOneYear']; ?></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Number of children 0-2 years</td>
                                <td><?php  print $ChildAgeInMonth_list['zeroToTwoYear']; ?></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Number of children 1-3 years</td>
                                <td><?php  print $ChildAgeInMonth_list['oneToThreeYear']; ?></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Number of children 4-6 years</td>
                                <td><?php  print $ChildAgeInMonth_list['fourToSixYear']; ?></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Number of children 0-6 years</td>
                                <td><?php  print $ChildAgeInMonth_list['zeroToSixYear']; ?></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Adults aged 35-50 years</td>
                                <td><?php  print $pouplation[0]->AdultsAgeThirtyFiveToFifty ;?> </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Adults age more than 60 years of age</td>
                                <td><?php  print $pouplation[0]->AdultsAgeMorethanSixty ;?></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Total pregnant women in the area</td>
                                <td><?php  print $pouplation[0]->totalPregnantWomen ;?></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Proportion of pregnant Women Registered in the First Trimester</td>
                                <td><?php echo $prop_preg_first_trimster[0] . '/' . $prop_preg_first_trimster[1]; ?></td>
                                <td class="text-center">
                                    <a href="<?php echo site_url(); ?>admin/graph/preg_women_reg_first_trimester" class="btn btn-success">View Graph</a>
                                </td>
                            </tr>
                            <tr>
                                <td>Proportion of pregnant women with 1 ANC check-up</td>
                                <td><?php echo $prop_one_anc_checkup[0] . '/' . $prop_one_anc_checkup[1]; ?></td>
                                <td class="text-center">
                                    <a href="<?php echo site_url(); ?>admin/graph/one_anc_checkup" class="btn btn-success">View Graph</a>
                                </td>
                            </tr>
                            <tr>
                                <td>Proportion of pregnant women with 2 ANC check-ups</td>
                                <td><?php echo $prop_two_anc_checkup[0] . '/' . $prop_two_anc_checkup[1]; ?></td>
                                <td class="text-center">
                                    <a href="<?php echo site_url(); ?>admin/graph/two_anc_checkup" class="btn btn-success">View Graph</a>
                                </td>
                            </tr>
                            <tr>
                                <td>Proportion of pregnant women with 3 ANC check-ups</td>
                                <td><?php echo $prop_three_anc_checkup[0] . '/' . $prop_three_anc_checkup[1]; ?></td>
                                <td class="text-center">
                                    <a href="<?php echo site_url(); ?>admin/graph/three_anc_checkup" class="btn btn-success">View Graph</a>
                                </td>
                            </tr>
                            <tr>
                                <td>Proportion of pregnant women with 4 ANC check-ups</td>
                                <td><?php echo $prop_four_anc_checkup[0] . '/' . $prop_four_anc_checkup[1]; ?></td>
                                <td class="text-center">
                                    <a href="<?php echo site_url(); ?>admin/graph/four_anc_checkup" class="btn btn-success">View Graph</a>
                                </td>
                            </tr>
                            <tr>
                                <td>Proportion of pregnant women who received  TT2  or Booster</td>
                                <td><?php echo $tt2_booster[0] . '/' . $tt2_booster[1]; ?></td>
                                <td class="text-center">
                                    <a href="<?php echo site_url(); ?>admin/graph/tt2_booster" class="btn btn-success">View Graph</a>
                                </td>
                            </tr>
                            <tr>
                                <td>Proportion of institutional deliveries</td>
                                <td><?php echo $institutional_delivery[0] . '/' . $institutional_delivery[1]; ?></td>
                                <td class="text-center">
                                    <a href="<?php echo site_url(); ?>admin/graph/institutional_delivery" class="btn btn-success">View Graph</a>
                                </td>
                            </tr>
                            <tr>
                                <td>Newborns visited by ASHA at least two  or more times within first seven days</td>
                                <td><?php echo $newborns_visited_two_or_more_times[0] . '/' . $newborns_visited_two_or_more_times[1]; ?></td>
                                <td class="text-center">
                                    <a href="<?php echo site_url(); ?>admin/graph/newborns_visited_two_or_more_times" class="btn btn-success">View Graph</a>
                                </td>
                            </tr>
                            <tr>
                                <td>Newborns visited by ASHA at least three  or more times within first seven days of home delivery</td>
                                <td><?php echo $newborns_visited_three_or_more_times_home_delivery[0] . '/' . $newborns_visited_three_or_more_times_home_delivery[1]; ?></td>
                                <td class="text-center">
                                    <a href="<?php echo site_url(); ?>admin/graph/newborns_visited_three_or_more_times_home_delivery" class="btn btn-success">View Graph</a>
                                </td>
                            </tr>
                            <tr>
                                <td>Newborns visited by ASHA at least two  or more times within first seven days of institutional delivery</td>
                                <td><?php echo $newborns_visited_two_or_more_times_instituional[0] . '/' . $newborns_visited_two_or_more_times_instituional[1];?></td>
                                <td class="text-center">
                                    <a href="<?php echo site_url(); ?>admin/graph/newborns_visited_two_or_more_times_instituional" class="btn btn-success">View Graph</a>
                                </td>
                            </tr>
                            <tr>
                                <td>Low Birth Weight</td>
                                <td><?php echo $low_birth_weight[0] . '/' . $low_birth_weight[1]; ?></td>
                                <td class="text-center">
                                    <a href="<?php echo site_url(); ?>admin/graph/low_birth_weight" class="btn btn-success">View Graph</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>