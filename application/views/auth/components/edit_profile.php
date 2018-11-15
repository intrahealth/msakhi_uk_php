<section id="content">
  <?php foreach ($role_permission as $row) { if ($row->Controller == "Profile" && $row->Action == "index") { ?>
  <div class="block-header">
    <h2>Manage Profile</h2>
  </div>
  <div class="card">
    <div class="card-header">
      <h2><b>Edit Profile</b><small>
        Use the form below to edit Profile
      </small></h2>
    </div>
    <?php 
    $tr_msg= $this->session->flashdata('tr_msg');
    $er_msg= $this->session->flashdata('er_msg');
    if(!empty($tr_msg)){ ?>
    <div class="content animate-panel">
      <div class="row">
        <div class="col-md-12">
          <div class="hpanel">
            <div class="alert alert-success alert-dismissable alert1"> <i class="fa fa-check"></i>
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <?php echo $this->session->flashdata('tr_msg');?>. </div>
            </div>
          </div>
        </div>
      </div>
      <?php } else if(!empty($er_msg)){?>
      <div class="content animate-panel">
        <div class="row">
          <div class="col-md-12">
            <div class="hpanel">
              <div class="alert alert-danger alert-dismissable alert1"> <i class="fa fa-check"></i>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?php echo $this->session->flashdata('er_msg');?>. </div>
              </div>
            </div>
          </div>
        </div>1
        <?php } ?>   
        <div class="card-body card-padding">
          <form role="form" method="post" action="">
            <div class="form-group fg-line">
              <label for="StateNameHindi">First Name</label>
              <input type="text" class="form-control" data-toggle="dropdown" id="first_name" name="first_name" value="<?php echo $user_data[0]->first_name; ?>">
            </div>
            <div class="form-group fg-line">
              <label for="StateNameHindi">Last Name</label>
              <input type="text" class="form-control" data-toggle="dropdown" id="last_name" name="last_name" value="<?php echo $user_data[0]->last_name; ?>">
            </div>
            <div class="form-group fg-line">
              <label for="StateNameEnglish">User Name</label>
              <input type="text" class="form-control" data-toggle="dropdown" id="user_name" name="user_name" value="<?php echo $user_data[0]->user_name; ?>">
            </div>
            <div class="form-group fg-line">
              <label for="StateNameHindi">Email</label>
              <input type="text" class="form-control" data-toggle="dropdown" id="email" name="email" value="<?php echo $user_data[0]->email; ?>">
            </div>
            <div class="form-group fg-line">
              <label for="StateNameHindi">Password</label>
              <input type="text" class="form-control" data-toggle="dropdown" id="password" name="password" required>
            </div>
            
            <div class="form-group fg-line">
              <label for="StateNameHindi">Phone Number</label>
              <input type="number" class="form-control" data-toggle="dropdown" id="phone_no" name="phone_no" value="<?php echo $user_data[0]->phone_no; ?>">
            </div>
            <button type="submit" class="btn btn-primary btn-sm m-t-10">Submit</button>
          </form>
        </div>
      </div>
    </div>
    <?php } } ?>
  </section>