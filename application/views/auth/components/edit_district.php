						<section id="content">
              <div class="block-header">
                <h2>Manage District</h2>
              </div>
              
              <div class="card">
                <div class="card-header">
                  <h2><b>Edit District</b><small>
                    Use the form below to edit new District
                  </small></h2>
                </div>
                
                <div class="card-body card-padding">
                  <form role="form" method="post" action="">
                    <h4>District details</h4>
                    
                    <div class="form-group fg-line">
                     <label for="DistrictNameEnglish">District Name In English</label>
                     <input type="text" class="form-control" data-toggle="dropdown" id="DistrictNameEnglish" name="DistrictNameEnglish" placeholder="Enter District Name In English " value="<?php print $District_details['DistrictNameEnglish'];?>" required>
                   </div>
                   
                   <div class="form-group fg-line">
                     <label for="DistrictNameHindi">District Name In Hindi</label>
                     <input type="text" class="form-control" data-toggle="dropdown" id="DistrictNameHindi" name="DistrictNameHindi" placeholder="Enter District Name In Hindi " value="<?php print $District_details['DistrictNameHindi'];?>" required>
                   </div>
                   
                   <button type="submit" class="btn btn-primary btn-sm m-t-10">Submit</button>
                 </form>
               </div>
             </div>
           </section>