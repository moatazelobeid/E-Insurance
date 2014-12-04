<section class="sldierbanner">
			<div> 
				
                <div id="banner-fade">

				<!-- start Basic Jquery Slider -->
					<ul class="bjqs">
					
						<li data-text="<span><img src='<?php echo SITE_URL; ?>images/motorinsurance.png'>MOTOR<br> INSURANCE</span>">
							<img src="<?php echo SITE_URL; ?>images/Motor Insurance.jpg" title="">
						</li>
						
						<li data-text="<span><img src='<?php echo SITE_URL; ?>images/medicalinsurance.png'>MEDICAL<br> INSURANCE</span>">
							<img src="<?php echo SITE_URL; ?>images/Health.jpg" title="">
						</li>
						  <?php $i=1;
			/*$row=mysql_query("SELECT * FROM ".HOMEBANNER." WHERE status='1'");
			$num_rows=mysql_num_rows($row);
			$count = 0;
        	while($ress=mysql_fetch_array($row))
			{
				$count++;
				$image = $ress['banner_img'];
				$str = $ress['banner_title'];
				$name = strtoupper($str);*/
				?>    
						<li data-text="<span><img src='<?php echo SITE_URL; ?>images/travelinsurance.png'>TRAVEL<br> INSURANCE</span>">
							<img src="<?php echo SITE_URL; ?>images/Travel Insurance.jpg" title="">
						</li>
                        <?php //} ?>
                        <li data-text="<span><img src='<?php echo SITE_URL; ?>images/malprct.png'>MEDICAL<br> MALPRACTICE</span>">
							<img src="<?php echo SITE_URL; ?>images/Medical Malpractice.jpg" title="">
						</li>
  					</ul>
                    
				<!-- end Basic jQuery Slider -->
                
                <div class="TabbedPanelsContentGroup">
                    <div class="TabbedPanelsContent">
                      	<?php /*?><div>
                                <div id="home-form" class="yakeendown brownbox">
                                  <h2 id="getquote" style="text-align:center;">
                                    Get A Quote
                                  </h2>
                                  <form id="step1" name="step1" method="post">
                                    <div id="step-1">
                                      <legend>
                                      <span class="home-form-legend">
                                      Sponsor Details
                                      </span>
                                      </legend>
                                      <input value="" class="mobile" type="text">
                                      <div class="form-row-medical">
                                        <input value="" id="Sponsor_Email" placeholder="Sponsor Email" type="text">
                                      </div>
                                      <div style="margin-top:10px;">
                                      </div>
                                      <legend>
                                      <span class="home-form-legend">
                                      Insured Details
                                      </span>
                                      </legend>
                                      <div class="form-row-medical">
                                        <input value="" class="masterTooltip mobile" placeholder="Insured Mobile" title="" type="text">
                                      </div>
                                      <div class="form-row-medical">
                                        <input value="" id="Email" name="Email" placeholder="Insured Email" type="text">
                                      </div>
                                      <div class="form-row-medical">
                                        <input value="" class="borderentryiqama" id="IqamaNumber" maxlength="10" type="text">
                                      </div>
                                      <div class="form-row-medical" style="padding:10px 0px;" id="DivMultiplePolicy">
                                        <label for="MultiplePolicy" style="display:inline;" class="home-form-legend">Multiple Policies</label>
                                        <input type="checkbox" id="MultiplePolicy" name="MultiplePolicy">
                                      </div>
                                      <div class="form-row" style="margin-top: 10px;" id="CartSubmit">
                                        <button type="submit" id="submit3" class="submit">
                                        Submit
                                        </button>
                                      </div>
                                      <br clear="all">
                                    </div>
                                  </form>
                                  <div id="SponsorDivToolTip" style="left: 220px; display: none;">
                                    A verification code will be sent to this mobile number
                                  </div>
                                </div>
                          </div><?php */?>
                          <?php include_once("includes/get-a-quote.php");?>
                    </div>
						  
                    <div class="TabbedPanelsContent">
                      	<?php include_once("includes/medical-get-a-quote.php");?>
                    </div>
						  
                     <div class="TabbedPanelsContent">
                      	<div>
                                <div id="home-form" class="yakeendown yellowbox">
                                  <h2 id="getquote" style="text-align:center;">
                                    Quick Quote
                                  </h2>
                                  <form id="step1" name="step1" method="post">
                                    <div id="step-1">
									<div class="form-row-medical">
									<input value="" class="date_picker_calender" type="text" placeholder="Date of Travelling">
									  </div>
									  <?php /*?><div class="form-row-medical">
									  <select name="policy_type_id" id="policy_type_id" onchange="showVehicleColumn(this.value);">
									  		<option selected="selected">Insurance Type</option>
											<option value="2">Short Term Cover</option>
											<option value="1">Annual Cover</option>
										</select>
										</div><?php */?>
									  <div class="form-row-medical">
									  <select name="policy_type_id" id="policy_type_id" onchange="showVehicleColumn(this.value);">
									  		<option selected="selected">Trip Type</option>
											<option value="2">Single</option>
											<option value="1">Multiple</option>
										</select>
										</div>
										<div class="form-row-medical">
									  <select name="policy_type_id" id="policy_type_id" onchange="showVehicleColumn(this.value);">
									  		<option selected="selected">Geographic coverage</option>
											<option value="1">Worldwide</option>
                                           <option value="3">Schengen Countries</option>
                                           <option value="4">Worldwide Excluding USA & Canada</option>
										</select>
										</div>
									<div class="form-row-medical">
									<input value="" class="mobile" type="text" placeholder="Mobile Number">
									</div>
                                      <div class="form-row" style="margin-top: 10px;" id="CartSubmit">
                                        <button type="submit" id="submit3" class="submit" style="position: inherit; margin-left: 25%;">
                                        Get A Quote
                                        </button>
                                      </div>
                                      <br clear="all">
                                    </div>
                                  </form>
                                  <div id="SponsorDivToolTip" style="left: 220px; display: none;">
                                    A verification code will be sent to this mobile number
                                  </div>
                                </div>
                          </div>
                    </div>
					
					
					<div class="TabbedPanelsContent">
                      	<div>
                                <div id="home-form" class="yakeendown graybox">
                                  <h2 id="getquote" style="text-align:center;">
                                    Quick Quote
                                  </h2>
                                  <form id="step1" name="step1" method="post">
                                    <div id="step-1">
									  <div class="form-row-medical">
									  <select name="period_of_insurance" id="period_of_insurance">
									  		<option selected="selected">Medical Profession</option>
											<option value="2">Nurse</option>
											<option value="1">Lab/Path Tech</option>
											<option value="1">Scanning Tech</option>
											<option value="1">X-Ray Tech</option>
											<option value="1">Paramedic</option>
											<option value="1">Physiotherapist</option>
											<option value="1">Pathologist</option>
											<option value="1">Dietician</option>
											<option value="1">Midwives</option>
											<option value="1">Pediatrician (Non Surg)</option>
											<option value="1">Nephrologists</option>
											<option value="1">Ophtalmologist</option>
											<option value="1">General Practitioner</option>
											<option value="1">Psychiatrist</option>
											<option value="1">Radiology</option>
											<option value="1">Dentist</option>
											<option value="1">Surgeon</option>
										</select>
										</div>			  
									  <div class="form-row-medical">
									  <select name="limit_of_indemnity" id="limit_of_indemnity">
									  		<option selected="selected">Limit of Indemnity</option>
											<option value="2">100,000</option>
											<option value="1">250,000</option>
											<option value="1">500,000</option>
											<option value="1">1,000,000</option>
										</select>
										</div>	
									  <div class="form-row-medical">
									  <select name="year_of_experience" id="year_of_experience">
									  		<option selected="selected">Year of Experience</option>
											<option value="1">0 to 5 Years</option>
											<option value="1">6 to 10 Years</option>
											<option value="1">11 to 20 Years</option>
											<option value="1">Above 20 Years</option>
										</select>
										</div>	
									  <div class="form-row-medical">
                                      <input value="" class="date_picker_calender" type="text" placeholder="Date of Birth">
									  </div>
									<div class="form-row-medical">
                                      <input value="" class="mobile" type="text" placeholder="Mobile No">
									  </div>
									  <div class="clearfix"></div>
									  
                                      <div class="form-row" style="margin-top: 10px;" id="CartSubmit">
                                        <button type="submit" id="submit3" class="submit" style="position: inherit; margin-left: 25%;">
                                        Get A Quote
                                        </button>
                                      </div>
                                      <br clear="all">
                                    </div>
                                  </form>
                                  <div id="SponsorDivToolTip" style="left: 220px; display: none;">
                                    A verification code will be sent to this mobile number
                                  </div>
                                </div>
                          </div>
                    </div>
                </div>

      			</div>
				
	  		</div>
		
        </section>