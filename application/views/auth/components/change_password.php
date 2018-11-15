<section id="content">
  <?php foreach ($role_permission as $row) { if ($row->Controller == "Change_password" && $row->Action == "index") { ?>
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
            <!-- <div class="form-group fg-line">
              <label for="StateNameHindi"> Old Password</label>
              <input type="text" class="form-control" data-toggle="dropdown" id="password" name="password" required>
            </div> -->
            <div class="form-group fg-line">
              <label for="StateNameHindi"> New Password</label>
              <input type="text" class="form-control" data-toggle="dropdown" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-sm m-t-10">Submit</button>
          </form>
        </div>
      </div>
      <?php } }?>
    </section>