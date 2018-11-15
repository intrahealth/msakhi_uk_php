<section id="content">
 

  <div class="block-header">
    <h2>Manage Child</h2>
  </div>

  <div class="card">
    <div class="card-header">
      <h2><b>Edit Child Detail</b><small>
        Use the form below to edit child Detail
      </small></h2>
    </div>

    <div class="card-body card-padding">
      <form role="form" method="post" action="">


        <div class="col-md-4 col-sm-12 col-xs-12 form-group fg-line">
          <label for="child_name">Child Name</label>
          <input type="text" class="form-control" data-toggle="dropdown" id="child_name" name="child_name" placeholder="Enter Child Name " value="<?php echo $child_detail[0]->child_name ; ?>" required>
        </div>

        <div class="col-md-4 col-sm-12 col-xs-12 form-group fg-line">
          <label for="Date_Of_Registration">Date Of Registration</label>
          <input type="date" class="datepicker form-control"  id="Date_Of_Registration" name="Date_Of_Registration" placeholder="Enter Date Of Registration" value="<?php echo $child_detail[0]->Date_Of_Registration; ?>" required>
        </div>

        <div class="col-md-4 col-sm-12 col-xs-12 form-group fg-line">
          <label for="child_dob">Child Date Of Birth</label>
          <input type="date" class="datepicker form-control"  id="child_dob" name="child_dob" placeholder="Enter Child Date Of Birth" value="<?php echo $child_detail[0]->child_dob; ?>" required>
        </div>

        <div class="col-md-4 col-sm-12 col-xs-12 form-group fg-line">
          <label for="birth_time">Birth Time</label>
          <input type="text" class="form-control" data-toggle="dropdown" id="birth_time" name="birth_time" placeholder="Birth Time" value="<?php echo $child_detail[0]->birth_time; ?>" required>
        </div>


        <button type="submit" class="btn btn-primary btn-sm m-t-10" style="margin-top : 20px;">Submit</button>
        
        <div style="margin-top: 30px;"></div>

      </form>
    </div>
  </div>
  
</section>