

<center style="background-color: rgb(242,190,0); color: white;">

	<img src="<?php echo $_SERVER["DOCUMENT_ROOT"] . '/common_libs/img/msakhi_logo.png';?>" alt="Msakhi Logo" height="50" width="50">
	<h2>Msakhi (Uttrakhand)</h2>

</center>

<h2 style="background-color: #f5f5f5;">
	<b>High Risk Pregnancies</b>
</h2>					

<table width="100%" height="100%">


	<thead>

		<tr>
			<td></td>
			<td style="background-color: #005585; color: white;" class="text-center" colspan="2"><b> Data Required </b></td>
		</tr>

		<tr>
			<td style="background-color: #005585; color: white;" class="text-center"></td>

			<td style="background-color: #005585; color: white;" class="text-center">
				<b>Count</b>
			</td>

			<td style="background-color: #005585; color: white;" class="text-center">
				<b>Percent</b>
			</td>

		</tr>

	</thead>

	<tbody>
		<tr>
			<td style="background-color: #d7d6ca; color:black;"  class="text-center">
				<b>
					<u>Total Number of currently pregnant women</u>
				</b>
			</td>

			<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php echo $total_pregnant_women;?></td>

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
                                	<td style="background-color: #005585; color: white;"  class="text-center">
                                		<h4>
                                			<b>
                                				<i>Obstetric History/History of Previous Pregnancies</i>
                                			</b>
                                		</h4>
                                	</td>
                                </tr>

                                <tr>
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center">Two or more than Two Abortions</td>

                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php  print $hrp_summary['two_or_more_than_two_abortions'];?></td> 

                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php  print number_format(($hrp_summary['two_or_more_than_two_abortions'] / $total_pregnant_women) * 100, 2);?></td> 

                                </tr> 

                                <tr>
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center">Still Birth</td>
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php  print $hrp_summary['still_birth'];?></td>   
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php  print number_format(($hrp_summary['still_birth'] / $total_pregnant_women) * 100, 2);?></td> 
                                </tr> 

                                <tr>
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center">Neonatal Loss</td>
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php  print $hrp_summary['neonatal_loss'];?></td>  
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php  print number_format(($hrp_summary['neonatal_loss'] / $total_pregnant_women) * 100, 2);?></td>     
                                </tr> 

                                <tr>
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center">Obstructed Labour</td>
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php  print $hrp_summary['obstructed_labour'];?></td>  
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php  print number_format(($hrp_summary['obstructed_labour'] / $total_pregnant_women) * 100, 2);?></td>  
                                </tr> 

                                <tr>
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center">Ante-Partum Haemorrhage (APH)</td>
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php  print $hrp_summary['ante_partum_haemorrhage'];?></td>
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php  print number_format(($hrp_summary['ante_partum_haemorrhage'] / $total_pregnant_women) * 100, 2);?></td>    
                                </tr> 

                                <tr>
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center">Excessive Bleeding After Delivery (PPH)
                                	</td>
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php  print $hrp_summary['excessive_bleeding_after_delivery'];?></td>  
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php  print number_format(($hrp_summary['excessive_bleeding_after_delivery'] / $total_pregnant_women) * 100, 2);?></td>                         
                                </tr> 

                                <tr>
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center">Weight of the Previous Baby >4500 g</td>
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php  print $hrp_summary['weight_of_the_previous_baby_greater_than_4500g'];?></td>  
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php  print number_format(($hrp_summary['weight_of_the_previous_baby_greater_than_4500g'] / $total_pregnant_women) * 100, 2);?></td>    
                                </tr> 

                                <tr>
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center">Caesarean Section</td>
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php  print $hrp_summary['caesarean_section'];?></td> 
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php  print number_format(($hrp_summary['caesarean_section'] / $total_pregnant_women) * 100, 2);?></td>        
                                </tr> 


                                <tr>
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center">Congenital Anomaly</td>
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php  print $hrp_summary['congenital_anomaly'];?></td>   
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php  print number_format(($hrp_summary['congenital_anomaly'] / $total_pregnant_women) * 100, 2);?></td>   
                                </tr> 

                                <tr>
                                	<td style="background-color: #005585; color: white;"  class="text-center">
                                		<h4>
                                			<b>
                                				<i>History of any Current Systemic illness(es)/Past History of illness</i>
                                			</b>
                                		</h4>
                                	</td>
                                </tr>

                                <tr>
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center">High Blood Pressure (Hypertension)</td>
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php  print $hrp_summary['high_blood_pressure_hypertension'];?></td>   
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php  print number_format(($hrp_summary['high_blood_pressure_hypertension'] / $total_pregnant_women) * 100, 2);?></td>  
                                </tr> 


                                <tr>
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center">Diabetes</td>
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php  print $hrp_summary['diabetes'];?></td>   
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php  print number_format(($hrp_summary['diabetes'] / $total_pregnant_women) * 100, 2);?></td>  
                                </tr> 


                                <tr>
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center">Breathlessness on exertion, palpitations (Heart Disease)</td>
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php  print $hrp_summary['breathlessness_on_exertion_palpitations_heart_disease'];?></td>     
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php  print number_format(($hrp_summary['breathlessness_on_exertion_palpitations_heart_disease'] / $total_pregnant_women) * 100, 2);?></td>  
                                </tr>                           


                                <tr>
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center">Chronic Cough, Blood in the Sputum, Prolonged Fever (Tuberculosis)</td>
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php  print $hrp_summary['chronic_cough_blood_in_the_sputum_prolonged_fever_tuberculosis'];?></td> 
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php  print number_format(($hrp_summary['chronic_cough_blood_in_the_sputum_prolonged_fever_tuberculosis'] / $total_pregnant_women) * 100, 2);?></td>     
                                </tr> 

                                <tr>
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center">Convulsions (Epilepsy)</td>
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php  print $hrp_summary['convulsions_epilepsy'];?></td> 
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php  print number_format(($hrp_summary['convulsions_epilepsy'] / $total_pregnant_women) * 100, 2);?></td>     
                                </tr>

                                <tr>
                                	<td style="background-color: #005585; color: white;"  class="text-center">
                                		<h4>
                                			<b>
                                				<i>Current Pregnancy</i>
                                			</b>
                                		</h4>
                                	</td>
                                </tr>

                                <tr>
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center">Severe Anaemia (Hb < 7gm%)</td>
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php  print $hrp_summary['severe_anaemia_hb_less_than_7gm_percent'];?></td> 
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php  print number_format(($hrp_summary['severe_anaemia_hb_less_than_7gm_percent'] / $total_pregnant_women) * 100, 2);?></td>      
                                </tr> 

                                <tr>
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center">Blood pressure  equal to or more than  140mmHg (S) and /or equal to or more than  90 mmHg (D)</td>
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php  print $hrp_summary['blood_pressure_equal_to_or_more_than_140mmHg_S_and_or_equal_to_or_more_than_90_mmHg_D'];?>
                                	</td>   

                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php  print number_format(($hrp_summary['blood_pressure_equal_to_or_more_than_140mmHg_S_and_or_equal_to_or_more_than_90_mmHg_D'] / $total_pregnant_women) * 100, 2);?></td>  
                                </tr> 

                                <tr>
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center">Any Vaginal Bleeding</td>
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php  print $hrp_summary['any_vaginal_bleeding'];?></td>  
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php  print number_format(($hrp_summary['any_vaginal_bleeding'] / $total_pregnant_women) * 100, 2);?></td>     
                                </tr> 

                                <tr>
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center">Malpresentation (Breech/Transverse lie)</td>
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php  print $hrp_summary['malpresentation_Breech_transverse_lie'];?></td>  
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php  print number_format(($hrp_summary['malpresentation_Breech_transverse_lie'] / $total_pregnant_women) * 100, 2);?></td>      
                                </tr> 

                                <tr>
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center">Gestational Diabetes</td>
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php  print $hrp_summary['gestational_diabetes'];?></td> 
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php  print number_format(($hrp_summary['gestational_diabetes'] / $total_pregnant_women) * 100, 2);?></td>     
                                </tr> 


                                <tr>
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center">Cephalopelvic Disproportion</td>
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php  print $hrp_summary['cephalopelvic_disproportion'];?></td>     
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php  print number_format(($hrp_summary['cephalopelvic_disproportion'] / $total_pregnant_women) * 100, 2);?></td> 
                                </tr> 

                                <tr>
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center">Teenage Pregnancy (Less Than 19 years)</td>
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php  print $hrp_summary['teenage_pregnancy_less_than_19_years'];?></td>
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php  print number_format(($hrp_summary['teenage_pregnancy_less_than_19_years'] / $total_pregnant_women) * 100, 2);?></td>     
                                </tr> 

                                <tr>
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center">Elderly Primigravida (>40 years)</td>
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php  print $hrp_summary['elderly_primigravida_greater_than_40_years'];?></td>   
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php  print number_format(($hrp_summary['elderly_primigravida_greater_than_40_years'] / $total_pregnant_women) * 100, 2);?></td>   
                                </tr> 

                                <tr>
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center">Low Height Of Mother (Less than 145 cm)</td>
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php  print $hrp_summary['low_height_of_mother_less_than_145_cm'];?></td>  
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php  print number_format(($hrp_summary['low_height_of_mother_less_than_145_cm'] / $total_pregnant_women) * 100, 2);?></td>     
                                </tr> 


                                <tr>
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center">Low Weight Of Mother (Less than 45 kg)</td>
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php  print $hrp_summary['low_weight_of_mother_less_than_45_kg'];?></td>    
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php  print number_format(($hrp_summary['low_weight_of_mother_less_than_45_kg'] / $total_pregnant_women) * 100, 2);?></td> 
                                </tr> 


                                <tr>
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center">HIV +ve</td>
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php  print $hrp_summary['hiv_positive'];?></td>  
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php  print number_format(($hrp_summary['hiv_positive'] / $total_pregnant_women) * 100, 2);?></td>   
                                </tr> 

                                <tr>
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center">WR +ve</td>
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php  print $hrp_summary['wr_positive'];?></td>    
                                	<td style="background-color: #d7d6ca; color:black;"  class="text-center"><?php  print number_format(($hrp_summary['wr_positive'] / $total_pregnant_women) * 100, 2);?></td> 
                                </tr>


                              </tbody>

                            </table>
                            <br>

                            <center>
                            	<footer id="footer">
                            		Copyright &copy; 2012-2017 Intrahealth
                            	</footer>
                            </center>





