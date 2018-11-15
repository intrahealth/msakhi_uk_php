<section id="content">
  <div class="block-header">
    <h2>Manage Family Members</h2>
  </div>

  <div class="card">
    <div class="card-header">
      <h2><b>Edit Family Members </b> <small>List Of Family Members</small></h2>
    </div>

    <div class="card-body card-padding">
      <form role="form" method="post" action="">

        <div class="form-group fg-line">
          <label for="FamilyMemberName">Family Member Name</label>
          <input type="text" class="form-control" data-toggle="dropdown" id="FamilyMemberName" name="FamilyMemberName" value="<?php echo $Detail_Family_Member[0]->FamilyMemberName; ?>" readonly>
        </div>

     <div class="form-group fg-line">
          <label for="ASHAName">Gender</label>
          <select class="form-control" data-toggle="dropdown" id="GenderID" name="GenderID" required>
           <option value="" <?php echo ($Detail_Family_Member[0]->GenderID == "0" ? "selected":"")?>> --Select Gender-- </option>
            <option value="1" <?php echo ($Detail_Family_Member[0]->GenderID == "Male" ? "selected":"")?>>Male</option>
            <option value="2" <?php echo ($Detail_Family_Member[0]->GenderID == "Female" ? "selected":"")?>>Female</option>
            <option value="3" <?php echo ($Detail_Family_Member[0]->GenderID == "Other" ? "selected":"")?>>Other</option>
          </select>
        </div>

        <div class="form-group fg-line">
          <label for="MaritialStatusID">Maritial Status</label>
          <select class="form-control" data-toggle="dropdown" id="MaritialStatusID" name="MaritialStatusID" required>
            <option value="" <?php echo ($Detail_Family_Member[0]->MaritialStatusID == "0" ? "selected":"")?>>--Select Maritial Status--</option>
            <option value="1" <?php echo ($Detail_Family_Member[0]->MaritialStatusID == "Married" ? "selected":"")?> >Married</option>
            <option value="2" <?php echo ($Detail_Family_Member[0]->MaritialStatusID == "UnMarried" ? "selected":"")?>>UnMarried</option>
            <option value="3" <?php echo ($Detail_Family_Member[0]->MaritialStatusID == "Widowed/Separate" ? "selected":"")?>>Widowed/Separate</option>
          </select>
        </div>

          <div class="form-group fg-line">
          <label for="DateOfBirth"> Date Of Birth</label>
          <input type="text" class="form-control date-picker" data-toggle="dropdown" id="DateOfBirth" name="DateOfBirth" placeholder="Enter Age in Year" value="<?php echo $Detail_Family_Member[0]->DateOfBirth; ?>" required>
        </div>

          <div class="form-group fg-line">
          <label for="AgeAsOnYear"> Age As On</label>
          <input type="text" class="form-control" data-toggle="dropdown" id="AgeAsOnYear" name="AgeAsOnYear" placeholder="Enter Age in Year" value="<?php echo $Detail_Family_Member[0]->AgeAsOnYear; ?>" required>
        </div>

        <div class="form-group fg-line">
          <label for="AprilAgeYear"> April Age Year</label>
          <input type="text" class="form-control" data-toggle="dropdown" id="AprilAgeYear" name="AprilAgeYear" placeholder="Enter Age in Year" value="<?php echo $Detail_Family_Member[0]->AprilAgeYear; ?>" required>
        </div>

        <div class="form-group fg-line">
          <label for="AprilAgeMonth"> April Age Month </label>
          <input type="text" class="form-control" data-toggle="dropdown" id="AprilAgeMonth" name="AprilAgeMonth" placeholder="Enter Age in Month" value="<?php echo $Detail_Family_Member[0]->AprilAgeMonth; ?>" required>
        </div>

      <button type="submit" class="btn btn-primary btn-sm m-t-10">Submit</button>
    </form>
  </div>
</div>
</section>