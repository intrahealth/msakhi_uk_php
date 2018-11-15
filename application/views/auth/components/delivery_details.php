<section id="content">
  <?php foreach ($role_permission as $row) { if($row->Controller == "delivery" && $row->Action == "index") { ?>

  <div class="block-header">
    <h2>Manage Pregnent Woman</h2>
  </div>

  <div class="card">
    <div class="card-header">
      <h2><b>Edit Pregnent Woman Detail</b><small>
        Use the form below to edit pregnent woman
      </small></h2>
    </div>

    <div class="card-body card-padding">
      <form role="form" method="post" action="">


        <div class="col-md-4 col-sm-12 col-xs-12 form-group fg-line">
          <label for="PWName">Pregnent Woman Name</label>
          <input type="text" class="form-control" data-toggle="dropdown" id="PWName" name="PWName" placeholder="Enter Pregnent Woman Name " value="<?php echo $PW_Detail[0]->PWName ; ?>" required>
        </div>

        <div class="col-md-4 col-sm-12 col-xs-12 form-group fg-line">
          <label for="HusbandName">Husband Name</label>
          <input type="text" class="form-control" data-toggle="dropdown" id="HusbandName" name="HusbandName" placeholder="Enter Husband Name" value="<?php echo $PW_Detail[0]->HusbandName; ?>" required>
        </div>

        <div class="col-md-4 col-sm-12 col-xs-12 form-group fg-line">
          <label for="LMPDate">LMP Date</label>
          <input type="date" class="form-control" data-toggle="dropdown" id="LMPDate" name="LMPDate" placeholder="Enter State Name in Hindi" value="<?php echo $PW_Detail[0]->LMPDate; ?>" required>
        </div>

        <div class="col-md-4 col-sm-12 col-xs-12 form-group fg-line">
          <label for="PWRegistrationDate">Pregnent Woman Registration Date</label>
          <input type="date" class="form-control" data-toggle="dropdown" id="PWRegistrationDate" name="PWRegistrationDate" placeholder="" value="<?php echo $PW_Detail[0]->PWRegistrationDate; ?>" required>
        </div>



        <div class="col-md-4 col-sm-12 col-xs-12 form-group fg-line">
          <label for="MobileNo">Mobile Number</label>
          <input type="number" class="form-control" data-toggle="dropdown" id="MobileNo" name="MobileNo" placeholder="Enter Mobile Number" value="<?php echo $PW_Detail[0]->MobileNo; ?>" required>
        </div>


          <button type="submit" class="btn btn-primary btn-sm m-t-10" style="margin-top : 20px;">Submit</button>
        

        <div style="margin-top: 30px;"></div>

      </form>
    </div>
  </div>
  <?php } } ?>
</section>