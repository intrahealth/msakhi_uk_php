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
          <input type="text" class="form-control" data-toggle="dropdown" id="SubCenterID" name="SubCenterID" value="<?php echo $list_household[0]->SubCenterName; ?>" readonly>
        </div>

        <div class="form-group fg-line">
          <label for="ANMName"> ANM Name </label>
          <input type="text" class="form-control" data-toggle="dropdown" id="ANMID" name="ANMID"  value="<?php echo $list_household[0]->ANMName; ?>" readonly>
        </div>

        <div class="form-group fg-line">
          <label for="ASHAName"> ASHA Name </label>
          <input type="text" class="form-control" data-toggle="dropdown" id="ServiceProviderID" name="ServiceProviderID"  value="<?php echo $list_household[0]->ASHAName; ?>" readonly>
        </div>

        <div class="form-group fg-line">
          <label for="VillageName"> Village Name </label>
          <input type="text" class="form-control" data-toggle="dropdown" id="VillageID" name="VillageID"  value="<?php echo $list_household[0]->VillageName; ?>" readonly>
        </div>

        <div class="form-group fg-line">
          <label for="FamilyCode"> Family Code</label>
          <input type="text" class="form-control" data-toggle="dropdown" id="FamilyCode" name="FamilyCode" placeholder="Enter FamilyCode" value="<?php echo $list_household[0]->FamilyCode; ?>" readonly>
        </div>

        <div class="form-group fg-line">
          <label for="StateNameHindi"> CASTE </label>
          <select class="form-control" data-toggle="dropdown" id="CasteID" name="CasteID" required>
           <option value="0" <?php echo ($list_household[0]->CasteID == "0" ? "selected" : "") ?>>--select--</option>
           <option value="1" <?php echo ($list_household[0]->CasteID == "1" ? "selected" : "") ?>>SC</option>           
           <option value="2" <?php echo ($list_household[0]->CasteID == "2" ? "selected" : "") ?>>ST</option>
           <option value="3" <?php echo ($list_household[0]->CasteID == "3" ? "selected" : "") ?>>OBC</option>
           <option value="4" <?php echo ($list_household[0]->CasteID == "4" ? "selected" : "") ?>>Other</option>
           <option value="5" <?php echo ($list_household[0]->CasteID == "5" ? "selected" : "")?> >UR</option>
         </select>
       </div>

       <div class="form-group fg-line">
        <label for="StateNameHindi"> Financial StatusID </label>
       
        <select class="form-control" name="FinancialStatusID" id="<FinancialStatusID></FinancialStatusID>" required>
          <option value="" <?php echo ($list_household[0]->FinancialStatusID == "0" ? "selected" : "") ?>>--select--</option>
          <option value="1" <?php echo ($list_household[0]->FinancialStatusID == "1" ? "selected" : "") ?>>A.P.L.</option>
          <option value="2" <?php echo ($list_household[0]->FinancialStatusID == "2" ? "selected" : "")?>>B.P.L.</option>
        </select>
      </div>

      <button type="submit" class="btn btn-primary btn-sm m-t-10">Submit</button>
    </form>
  </div>
</div>
</section>