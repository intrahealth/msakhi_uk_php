<section id="content">
  <div class="block-header">
    <h2>Manage State</h2>
  </div>

  <div class="card">
    <div class="card-header">
      <h2><b>Edit State</b><small>
        Use the form below to edit new State
      </small></h2>
    </div>

    <div class="card-body card-padding">
      <form role="form" method="post" action="">
        <h4>State details</h4>


        <div class="form-group fg-line">
          <label for="StateNameEnglish">State Name in English</label>
          <input type="text" class="form-control" data-toggle="dropdown" id="StateNameEnglish" name="StateNameEnglish" placeholder="Enter State Name in English " value="<?php print $State_details['StateNameEnglish'] ; ?>" required>
        </div>

        <div class="form-group fg-line">
          <label for="StateNameHindi">State Name in Hindi</label>
          <input type="text" class="form-control" data-toggle="dropdown" id="StateNameHindi" name="StateNameHindi" placeholder="Enter State Name in Hindi" value="<?php print $State_details['StateNameHindi']; ?>" required>
        </div>


        <button type="submit" class="btn btn-primary btn-sm m-t-10">Submit</button>
      </form>
    </div>
  </div>
</section>