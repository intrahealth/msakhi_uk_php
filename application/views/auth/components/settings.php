<style>
.switch {
  position: relative;
  display: inline-block;
  width: 90px;
  height: 34px;
}

.switch input {display:none;}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ca2222;
  -webkit-transition: .4s;
  transition: .4s;
  border-radius: 34px;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
  border-radius: 50%;
}

input:checked + .slider {
  background-color: #2ab934;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(55px);
}

/*------ ADDED CSS ---------*/
.slider:after
{
 content:'OFF';
 color: white;
 display: block;
 position: absolute;
 transform: translate(-50%,-50%);
 top: 50%;
 left: 50%;
 font-size: 10px;
 font-family: Verdana, sans-serif;
}

input:checked + .slider:after
{  
  content:'ON';
}

/*--------- END --------*/

</style>

<section id="content">
  <div class="block-header">
    <h2 style="color: white;"><i class="zmdi zmdi-settings zmdi-hc"></i>  Settings <small style="color: white;">Preview of Admin Website Settings</small> </h2>
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
      </div>
      <?php } ?>

      <div class="card">
        <div class="card-body card-padding">
          <div id="tabs">
            <?php echo form_open();?>
            <ul>
              <li><a href="#basicSettings">Basic Settings</a></li>
              <li><a href="#apiSettings">API Settings</a></li>
              <li><a href="#smtpSettings">SMTP Settings</a></li>
              <li><a href="#smsSettings">SMS Settings</a></li>
            </ul>
            <div id="basicSettings">

             <div class="form-group fg-line">
               <label for="Org_Name">Organization  Name</label>
               <input type="text" class="form-control" data-toggle="dropdown" id="Org_Name" name="Org_Name" placeholder="Enter Organization Name" value="<?php echo $api_setting->Org_Name ?>" >
             </div>

             <div class="form-group fg-line">
               <label for="Contact_Person">Contact Person</label>
               <input type="text" class="form-control" data-toggle="dropdown" id="Contact_Person" name="Contact_Person" placeholder="Enter Contact Person" value="<?php echo $api_setting->Contact_Person ?>" >
             </div>

             <div class="form-group fg-line">
               <label for="Contact_DirectLine">Contact DirectLine</label>
               <input type="text" class="form-control" data-toggle="dropdown" id="Contact_DirectLine" name="Contact_DirectLine" placeholder="Enter Contact DirectLine" value="<?php echo $api_setting->Contact_DirectLine ?>" >
             </div>

           </div>

           <div id="apiSettings">
            <div class="row">
             <div class="col-lg-2">
               <label class="switch">
                 <input type="checkbox" name="allow_by_admin" id="allow_by_admin" <?php echo $api_setting->allow_by_admin == '1' ? 'checked' : ''; ?>>
                 <span class="slider round"  data-on="Yes" data-off="No"></span>
               </label>
             </div>
             <div class="col-lg-6">
                <label>Allow upload by Admin</label>
              </div>
            </div>
            <div class="row">
             <div class="col-lg-2">
               <label class="switch">
                 <input type="checkbox" name="allow_by_fa" id="allow_by_fa"  <?php echo $api_setting->allow_by_fa == '1' ? 'checked' : ''; ?>>
                 <span class="slider round"  data-on="Yes" data-off="No"></span>
               </label>           
             </div>
             <div class="col-lg-6">
              <label>Allow upload by FA</label>
            </div>
          </div>
        </div>

        <div id="smtpSettings">

         <div class="form-group fg-line">
           <label for="Smtp_Hostname">Smtp Hostname</label>
           <input type="text" class="form-control" data-toggle="dropdown" id="Smtp_Hostname" name="Smtp_Hostname" placeholder="Enter Smtp Hostname" value="<?php echo $api_setting->Smtp_Hostname ?>" >
         </div>
         <div class="form-group fg-line">
           <label for="Smtp_Port">Smtp Port</label>
           <input type="text" class="form-control" data-toggle="dropdown" id="Smtp_Port" name="Smtp_Port" placeholder="Enter Smtp Port" value="<?php echo $api_setting->Smtp_Port ?>" >
         </div>
         <div class="form-group fg-line">
           <label for="Smtp_Username">Smtp Username</label>
           <input type="text" class="form-control" data-toggle="dropdown" id="Smtp_Username" name="Smtp_Username" placeholder="Enter Smtp Username" value="<?php echo $api_setting->Smtp_Username ?>" >
         </div>
         <div class="form-group fg-line">
           <label for="Smtp_Password">Smtp Password</label>
           <input type="text" class="form-control" data-toggle="dropdown" id="Smtp_Password" name="Smtp_Password" placeholder="Enter Smtp Password" value="<?php echo $api_setting->Smtp_Password ?>" >
         </div>

       </div>

       <div id="smsSettings">
         <div class="form-group fg-line">
           <label for="trello_key">Trello Key</label>
           <input type="text" class="form-control" data-toggle="dropdown" id="trello_key" name="trello_key" placeholder="Enter Trello Key" value="<?php echo $api_setting->trello_key ?>" novalidate>
         </div>

         <div class="form-group fg-line">
           <label for="trello_secret">Trello Secret</label>
           <input type="text" class="form-control" data-toggle="dropdown" id="trello_secret" name="trello_secret" placeholder="Enter Trello Secret" value="<?php echo $api_setting->trello_secret ?>" novalidate>
         </div>
       </div>

       <div class="form-group fg-line" style="text-align: center;">

         <button type="submit" class="btn btn-primary">Submit</button>
       </div>
       <?php echo form_close();?>
     </div>
   </div>
 </div>
</section>

<script>
  $(document).ready(function(){
    $("#tabs").tabs({
      collapsible: true
    });
  });
</script>


