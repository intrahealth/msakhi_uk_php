<style>
  #hrp_report table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
  }

  #hrp_report td, th {
    border: 1px solid #fff;
    text-align: left;
    padding: 8px;
  }
</style>

<section id="content">
 <?php foreach ($role_permission as $row) { if ($row->Controller == "hrp" && $row->Action == "index") { ?>
  <div class="panel panel-default">
    <div class="panel-heading">
      <span class="panel-title">
        <small>
          <b>High Risk Pregnancies</b>

          <span class="pull-right">

            <a href="<?php echo site_url("hrp/index/export_pdf")?>" class="hvr-pulse-grow" id="btn-Preview-Image" data-toggle="tooltip" title="Export PDF">
              <i class="fa fa-2x fa-file-pdf-o" id="" name="" style="color: #cc3300; cursor: pointer; margin-right: 20px;"></i>
            </a>

            <a href="javascript:export_excel();" class="hvr-pulse-grow" id="btn-Preview-Image" data-toggle="tooltip" title="Export Excel">
              <i class="fa fa-2x fa-file-excel-o" id="" name="" style="color: #009999; cursor: pointer; margin-right: 20px;"></i>
            </a>

          </span>
        </small>
      </span>
    </div>

    <div class="panel-body">
      <div class="row">
        <div class="col-lg-12">

          <table class="table table-striped table-bordered table-vmiddle table-hover" id="hrp_report">
            <thead>

              <tr>
                <td></td>
                <td colspan="2"><b> Data Required </b></td>
              </tr>

              <tr>
                <td></td>

                <td>
                  <b>Count</b>
                </td>

                <td>
                  <b>Percent</b>
                </td>

              </tr>

            </thead>

            <tbody>
              <tr>
                <td>
                  <b>
                    <u>Total Number of currently pregnant women</u>
                  </b>
                </td>

                <td><?php echo $total_pregnant_women;?></td>

              </tr>

<!--  <tr>
<th><b>Total number of HRPs</b></th>
<td><?php echo $total_hrp;?></td>
</tr>  -->
<!-- <tr>
<td>Past Illness Heart Disease</td>
<td><?php  print $hrp_summary['past_illness_heart_disease'];?></td> 
<td><?php  print number_format(($hrp_summary['past_illness_heart_disease'] / $total_pregnant_women) * 100, 2);?></td> 
</tr> -->  
<tr>
  <td>
    <h4>
      <b>
        <i>Obstetric History/History of Previous Pregnancies</i>
      </b>
    </h4>
  </td>
</tr>

<tr>
  <td>Two or more than Two Abortions</td>

  <td><?php  print $hrp_summary['two_or_more_than_two_abortions'];?></td> 

  <td><?php  print number_format(($hrp_summary['two_or_more_than_two_abortions'] / $total_pregnant_women) * 100, 2);?></td> 

</tr> 

<tr>
  <td>Still Birth</td>
  <td><?php  print $hrp_summary['still_birth'];?></td>   
  <td><?php  print number_format(($hrp_summary['still_birth'] / $total_pregnant_women) * 100, 2);?></td> 
</tr> 

<tr>
  <td>Neonatal Loss</td>
  <td><?php  print $hrp_summary['neonatal_loss'];?></td>  
  <td><?php  print number_format(($hrp_summary['neonatal_loss'] / $total_pregnant_women) * 100, 2);?></td>     
</tr> 

<tr>
  <td>Obstructed Labour</td>
  <td><?php  print $hrp_summary['obstructed_labour'];?></td>  
  <td><?php  print number_format(($hrp_summary['obstructed_labour'] / $total_pregnant_women) * 100, 2);?></td>  
</tr> 

<tr>
  <td>Ante-Partum Haemorrhage (APH)</td>
  <td><?php  print $hrp_summary['ante_partum_haemorrhage'];?></td>
  <td><?php  print number_format(($hrp_summary['ante_partum_haemorrhage'] / $total_pregnant_women) * 100, 2);?></td>    
</tr> 

<tr>
  <td>Excessive Bleeding After Delivery (PPH)
  </td>
  <td><?php  print $hrp_summary['excessive_bleeding_after_delivery'];?></td>  
  <td><?php  print number_format(($hrp_summary['excessive_bleeding_after_delivery'] / $total_pregnant_women) * 100, 2);?></td>                         
</tr> 

<tr>
  <td>Weight of the Previous Baby >4500 g</td>
  <td><?php  print $hrp_summary['weight_of_the_previous_baby_greater_than_4500g'];?></td>  
  <td><?php  print number_format(($hrp_summary['weight_of_the_previous_baby_greater_than_4500g'] / $total_pregnant_women) * 100, 2);?></td>    
</tr> 

<tr>
  <td>Caesarean Section</td>
  <td><?php  print $hrp_summary['caesarean_section'];?></td> 
  <td><?php  print number_format(($hrp_summary['caesarean_section'] / $total_pregnant_women) * 100, 2);?></td>        
</tr> 


<tr>
  <td>Congenital Anomaly</td>
  <td><?php  print $hrp_summary['congenital_anomaly'];?></td>   
  <td><?php  print number_format(($hrp_summary['congenital_anomaly'] / $total_pregnant_women) * 100, 2);?></td>   
</tr> 

<tr>
  <td>
    <h4>
      <b>
        <i>History of any Current Systemic illness(es)/Past History of illness</i>
      </b>
    </h4>
  </td>
</tr>

<tr>
  <td>High Blood Pressure (Hypertension)</td>
  <td><?php  print $hrp_summary['high_blood_pressure_hypertension'];?></td>   
  <td><?php  print number_format(($hrp_summary['high_blood_pressure_hypertension'] / $total_pregnant_women) * 100, 2);?></td>  
</tr> 


<tr>
  <td>Diabetes</td>
  <td><?php  print $hrp_summary['diabetes'];?></td>   
  <td><?php  print number_format(($hrp_summary['diabetes'] / $total_pregnant_women) * 100, 2);?></td>  
</tr> 


<tr>
  <td>Breathlessness on exertion, palpitations (Heart Disease)</td>
  <td><?php  print $hrp_summary['breathlessness_on_exertion_palpitations_heart_disease'];?></td>     
  <td><?php  print number_format(($hrp_summary['breathlessness_on_exertion_palpitations_heart_disease'] / $total_pregnant_women) * 100, 2);?></td>  
</tr>                           


<tr>
  <td>Chronic Cough, Blood in the Sputum, Prolonged Fever (Tuberculosis)</td>
  <td><?php  print $hrp_summary['chronic_cough_blood_in_the_sputum_prolonged_fever_tuberculosis'];?></td> 
  <td><?php  print number_format(($hrp_summary['chronic_cough_blood_in_the_sputum_prolonged_fever_tuberculosis'] / $total_pregnant_women) * 100, 2);?></td>     
</tr> 

<tr>
  <td>Convulsions (Epilepsy)</td>
  <td><?php  print $hrp_summary['convulsions_epilepsy'];?></td> 
  <td><?php  print number_format(($hrp_summary['convulsions_epilepsy'] / $total_pregnant_women) * 100, 2);?></td>     
</tr>

<tr>
  <td>
    <h4>
      <b>
        <i>Current Pregnancy</i>
      </b>
    </h4>
  </td>
</tr>

<tr>
  <td>Severe Anaemia (Hb < 7gm%)</td>
  <td><?php  print $hrp_summary['severe_anaemia_hb_less_than_7gm_percent'];?></td> 
  <td><?php  print number_format(($hrp_summary['severe_anaemia_hb_less_than_7gm_percent'] / $total_pregnant_women) * 100, 2);?></td>      
</tr> 

<tr>
  <td>Blood pressure  equal to or more than  130mmHg (S) and /or equal to or more than  90 mmHg (D)</td>
  <td><?php  print $hrp_summary['blood_pressure_equal_to_or_more_than_140mmHg_S_and_or_equal_to_or_more_than_90_mmHg_D'];?>
  </td>   

  <td><?php  print number_format(($hrp_summary['blood_pressure_equal_to_or_more_than_140mmHg_S_and_or_equal_to_or_more_than_90_mmHg_D'] / $total_pregnant_women) * 100, 2);?></td>  
</tr> 

<tr>
  <td>Any Vaginal Bleeding</td>
  <td><?php  print $hrp_summary['any_vaginal_bleeding'];?></td>  
  <td><?php  print number_format(($hrp_summary['any_vaginal_bleeding'] / $total_pregnant_women) * 100, 2);?></td>     
</tr> 

<tr>
  <td>Malpresentation (Breech/Transverse lie)</td>
  <td><?php  print $hrp_summary['malpresentation_Breech_transverse_lie'];?></td>  
  <td><?php  print number_format(($hrp_summary['malpresentation_Breech_transverse_lie'] / $total_pregnant_women) * 100, 2);?></td>      
</tr> 

<tr>
  <td>Gestational Diabetes</td>
  <td><?php  print $hrp_summary['gestational_diabetes'];?></td> 
  <td><?php  print number_format(($hrp_summary['gestational_diabetes'] / $total_pregnant_women) * 100, 2);?></td>     
</tr> 


<tr>
  <td>Cephalopelvic Disproportion</td>
  <td><?php  print $hrp_summary['cephalopelvic_disproportion'];?></td>     
  <td><?php  print number_format(($hrp_summary['cephalopelvic_disproportion'] / $total_pregnant_women) * 100, 2);?></td> 
</tr> 

<tr>
  <td>Teenage Pregnancy (Less Than 19 years)</td>
  <td><?php  print $hrp_summary['teenage_pregnancy_less_than_19_years'];?></td>
  <td><?php  print number_format(($hrp_summary['teenage_pregnancy_less_than_19_years'] / $total_pregnant_women) * 100, 2);?></td>     
</tr> 

<tr>
  <td>Elderly Primigravida (>40 years)</td>
  <td><?php  print $hrp_summary['elderly_primigravida_greater_than_40_years'];?></td>   
  <td><?php  print number_format(($hrp_summary['elderly_primigravida_greater_than_40_years'] / $total_pregnant_women) * 100, 2);?></td>   
</tr> 

<tr>
  <td>Low Height Of Mother (Less than 145 cm)</td>
  <td><?php  print $hrp_summary['low_height_of_mother_less_than_145_cm'];?></td>  
  <td><?php  print number_format(($hrp_summary['low_height_of_mother_less_than_145_cm'] / $total_pregnant_women) * 100, 2);?></td>     
</tr> 


<tr>
  <td>Low Weight Of Mother (Less than 45 kg)</td>
  <td><?php  print $hrp_summary['low_weight_of_mother_less_than_45_kg'];?></td>    
  <td><?php  print number_format(($hrp_summary['low_weight_of_mother_less_than_45_kg'] / $total_pregnant_women) * 100, 2);?></td> 
</tr> 


<tr>
  <td>HIV +ve</td>
  <td><?php  print $hrp_summary['hiv_positive'];?></td>  
  <td><?php  print number_format(($hrp_summary['hiv_positive'] / $total_pregnant_women) * 100, 2);?></td>   
</tr> 

<tr>
  <td>WR +ve</td>
  <td><?php  print $hrp_summary['wr_positive'];?></td>    
  <td><?php  print number_format(($hrp_summary['wr_positive'] / $total_pregnant_women) * 100, 2);?></td> 
</tr>


</tbody>
<tfoot>
<tr>
  <td>Total HRP</td>
  <td><?php  print $hrp_summary['total_hrp_cases'];?></td>    
  <td><?php  print number_format(($hrp_summary['total_hrp_cases'] / $total_pregnant_women) * 100, 2);?></td> 
</tr>
</tfoot>
</table>
</div>
</div>
</div>
</div>
<?php } } ?>
</section>

<script>
  function export_excel() {
    $("#hrp_report").tableToCSV();
  }    
</script>