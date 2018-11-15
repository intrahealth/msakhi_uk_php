<section id="content">
  <div class="block-header">
    <h2>Manage Household </h2>
  </div>

  <div class="card">
    <div class="card-header">
      <h2><b>Edit Household </b><small>
        Use the form below to Household 
      </small></h2>
    </div>

    <div class="card-body card-padding">
      <form role="form" method="post" action="">

        <div class="form-group fg-line">
          <label for="SubCenterName">Sub Center Name</label>
          <input type="text" class="form-control" data-toggle="dropdown" id="SubCenterName" name="SubCenterName" placeholder="Enter SubCenterName" value="<?php echo $list_household[0]->SubCenterName; ?>">
        </div>

        <div class="form-group fg-line">
          <label for="ANMName"> ANM Name </label>
          <input type="text" class="form-control" data-toggle="dropdown" id="ANMName" name="ANMName" placeholder="Enter ANMName" value="<?php echo $list_household[0]->ANMName; ?>">
        </div>

        <div class="form-group fg-line">
          <label for="ASHAName"> ASHA Name </label>
          <input type="text" class="form-control" data-toggle="dropdown" id="ASHAName" name="ASHAName" placeholder="Enter ASHAName" value="<?php echo $list_household[0]->ASHAName; ?>">
        </div>

        <div class="form-group fg-line">
          <label for="VillageName"> Village Name </label>
          <input type="text" class="form-control" data-toggle="dropdown" id="VillageName" name="VillageName" placeholder="Enter VillageName" value="<?php echo $list_household[0]->VillageName; ?>">
        </div>

        <div class="form-group fg-line">
          <label for="FamilyCode"> Family Code</label>
          <input type="text" class="form-control" data-toggle="dropdown" id="FamilyCode" name="FamilyCode" placeholder="Enter FamilyCode" value="<?php echo $list_household[0]->FamilyCode; ?>">
        </div>

        <div class="form-group fg-line">
          <label for="StateNameHindi"> CASTE </label>
          <input type="text" class="form-control" data-toggle="dropdown" id="caste" name="caste" placeholder="Enter caste" value="<?php echo $list_household[0]->caste; ?>" required>
        </div>

        <div class="form-group fg-line">
          <label for="StateNameHindi"> Financial StatusID </label>
          <input type="text" class="form-control" data-toggle="dropdown" id="FinancialStatusID" name="FinancialStatusID" placeholder="Enter FinancialStatusID" value="<?php echo $list_household[0]->FinancialStatusID; ?>">
        </div>

        <button type="submit" class="btn btn-primary btn-sm m-t-10">Submit</button>
      </form>
    </div>
  </div>
</section>