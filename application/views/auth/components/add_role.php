<section id="content">
  <div class="block-header">
    <h2>Manage Role</h2>
  </div>
  <div class="card">
    <div class="card-header">
      <h2><b>Add Role</b><small>
        Use the form below to add new Role
      </small></h2>
    </div>
    <div class="card-body card-padding">
      <form role="form" method="post" action="">
        <div class="form-group fg-line">
          <label for="StateNameEnglish">Role Nmae</label>
          <input type="text" class="form-control" data-toggle="dropdown" id="RoleName" name="RoleName" placeholder="Enter Role Name" required>
        </div>
        <button type="submit" class="btn btn-primary btn-sm m-t-10">Submit</button>
        <a href="<?php echo site_url('role');?>" class="btn btn-primary btn-sm m-t-10">Back</a>
      </form>
    </div>
  </div>
</section>