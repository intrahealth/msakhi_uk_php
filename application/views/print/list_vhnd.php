

<center style="background-color: rgb(242,190,0); color: white;">

  <img src="<?php echo $_SERVER["DOCUMENT_ROOT"] . '/common_libs/img/msakhi_logo.png';?>" alt="Msakhi Logo" height="100" width="100">
  <h2>Msakhi (Uttrakhand)</h2>

</center>

<h2 style="background-color: #f5f5f5;">
  <b>Immunization Report</b>
</h2>         

<table width="100%" height="100%">
  <thead>
    <tr>
      <th style="background-color: #005585; color: white;" class="text-center">
        <b>Id</b>        
        <th class="text-center" style="background-color: #005585; color: white;"><b>Asha Name</b></th>
        <th class="text-center" style="background-color: #005585; color: white;"><b>Village/AWC</b></th>
        <th class="text-center" style="background-color: #005585; color: white;">Occurence</th>
        <th class="text-center" style="background-color: #005585; color: white;">Day</th>
        <th class="text-center" style="background-color: #005585; color: white;">Jan</th>
        <th class="text-center" style="background-color: #005585; color: white;">Feb</th>
        <th class="text-center" style="background-color: #005585; color: white;">March</th>
        <th class="text-center" style="background-color: #005585; color: white;">April</th>
        <th class="text-center" style="background-color: #005585; color: white;">May</th>
        <th class="text-center" style="background-color: #005585; color: white;">June</th>
        <th class="text-center" style="background-color: #005585; color: white;">July</th>
        <th class="text-center" style="background-color: #005585; color: white;">Aug</th>
        <th class="text-center" style="background-color: #005585; color: white;">Sep</th>
        <th class="text-center" style="background-color: #005585; color: white;">October</th>
        <th class="text-center" style="background-color: #005585; color: white;">November</th>
        <th class="text-center" style="background-color: #005585; color: white;">December</th>
      </tr>  

    </thead>


    <tbody>


      <?php 
      if(count($Vhnd_List) > 0){
        foreach($Vhnd_List as $row){ ?>
        <tr>

          <td style="background-color: #d7d6ca; color:black;"  class="text-center">
            <?php echo $row->Schedule_ID; ?>

          </td>

          <td style="background-color: #d7d6ca; color:black;"  class="text-center">
            <?php echo $row->ASHAName; ?>
          </td>

          <td style="background-color: #d7d6ca; color:black;"  class="text-center">
          
              <?php 
              $villQuery = "select v.VillageID, v.VillageName FROM `ashavillage` av 
              inner join mstvillage v
              on av.VillageID = v.VillageID
              and v.LanguageID = 1
              where av.ASHAID = " . $row->ASHA_ID;
              $villageList = $this->db->query($villQuery)->result();
              foreach($villageList as $vrow){ ?>
              <option value="<?php echo $vrow->VillageID;?>" <?php echo ($vrow->VillageID == $row->Village_ID?"selected":"");?> ><?php echo $vrow->VillageName;?></option>
              <?php } ?>
          </td>

          <td style="background-color: #d7d6ca; color:black;"  class="text-center">
            <select name="vhnd[<?php echo $row->ASHA_ID;?>][occurence]" id="vhnd[<?php echo $row->ASHA_ID;?>][occurence]" class="form-control" required style="width:70px;">
              <option value="">--Select--</option>
              <option value="1" <?php echo ($row->Occurence == 1? "selected":"");?>>First</option>
              <option value="2" <?php echo ($row->Occurence == 2? "selected":"");?>>Second</option>
              <option value="3" <?php echo ($row->Occurence == 3? "selected":"");?>>Third</option>
              <option value="4" <?php echo ($row->Occurence == 4? "selected":"");?>>Fourth</option>
              <option value="5" <?php echo ($row->Occurence == 5? "selected":"");?>>fifth</option>
            </select>
          </td>

          <td style="background-color: #d7d6ca; color:black;"  class="text-center">
            <select name="vhnd[<?php echo $row->ASHA_ID;?>][days]" id="vhnd[<?php echo $row->ASHA_ID;?>][days]" class="form-control" required style="width:70px;">
              <option value="">--Select--</option>
              <option value="1" <?php echo ($row->Days == 1? "selected":"");?>>Monday</option>
              <option value="2" <?php echo ($row->Days == 2? "selected":"");?>>Tuesday</option>
              <option value="3" <?php echo ($row->Days == 3? "selected":"");?>>Wednesday</option>
              <option value="4" <?php echo ($row->Days == 4? "selected":"");?>>Thursday</option>
              <option value="5" <?php echo ($row->Days == 5? "selected":"");?>>Friday</option>
              <option value="6" <?php echo ($row->Days == 6? "selected":"");?>>Saturday</option>
              <option value="7" <?php echo ($row->Days == 7? "selected":"");?>>Sunday</option>
            </select>
          </td>

          <td style="background-color: #d7d6ca; color:black;"  class="text-center">
            <input type="text" id="Jan"  value="<?php echo $row->Jan;?>" style="width:70px;"/>
          </td>

          <td style="background-color: #d7d6ca; color:black;"  class="text-center">
            <input type="text" id="Feb"  value="<?php echo $row->Feb;?>" style="width:70px;"/>
          </td>

          <td style="background-color: #d7d6ca; color:black;"  class="text-center">
            <input type="text" id="Mar"  value="<?php echo $row->Mar;?>" style="width:70px;"/>
          </td>
          <td style="background-color: #d7d6ca; color:black;"  class="text-center">
            <input type="text" id="Apr"  value="<?php echo $row->Apr;?>" style="width:70px;"/>
          </td>
          <td>
            <input type="text" id="May"  value="<?php echo $row->May;?>" style="width:70px;"/>
          </td>

          <td style="background-color: #d7d6ca; color:black;"  class="text-center">
            <input type="text" id="Jun"  value="<?php echo $row->Jun;?>" style="width:70px;"/>
          </td>

          <td style="background-color: #d7d6ca; color:black;"  class="text-center">
            <input type="text" id="Jul"  value="<?php echo $row->Jul;?>" style="width:70px;"/>
          </td>

          <td style="background-color: #d7d6ca; color:black;"  class="text-center">
            <input type="text" id="Aug"  value="<?php echo $row->Aug;?>" style="width:70px;"/>
          </td>

          <td style="background-color: #d7d6ca; color:black;"  class="text-center">
            <input type="text" id="Sep"  value="<?php echo $row->Sep;?>" style="width:70px;"/>
          </td>

          <td style="background-color: #d7d6ca; color:black;"  class="text-center">
            <input type="text" id="Oct"  value="<?php echo $row->Oct;?>" style="width:70px;"/>
          </td>

          <td style="background-color: #d7d6ca; color:black;"  class="text-center">
            <input type="text" id="Nov"  value="<?php echo $row->Nov;?>" style="width:70px;"/>
          </td>

          <td style="background-color: #d7d6ca; color:black;"  class="text-center">
            <input type="text" id="Dec"  value="<?php echo $row->Dec;?>" style="width:70px;"/>
          </td>

        </tr>
        <?php } }?>

        </tbody>

      </table>
      <br>

      <center>
        <footer id="footer">
          Copyright &copy; 2012-2017 Intrahealth
        </footer>
      </center>





