<?php require APPROOT .'/views/inc_reception/header.php'; ?>

<?php
    if(!isset($_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']) AND $_SESSION['type'] != 'rec')
    {
        redirect('users/login');
    }
?>

<?php
	if(isset($data['p_details']))
 	{
 		foreach ($data['p_details'] as $key4)
 		{
 			$p_id = $key4->patient_id;
 		}
 	}
?>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
<div class="row">
	<form >
	<div class="col-md-12">
		<div class="panel panel-default">
            <div class="panel-heading"><?php if (isset($data['p_details'])) { ?><h3 class="panel-title">Update Patient</h3><?php } else { ?><h3 class="panel-title">New Patient</h3><?php } ?></div>
                <div class="panel-body">
				<div class="row" >
					<div class="col-md-3">
		                <div class="form-group">
							<label for="exampleInputEmail1">Patient Name</label>
		                        <input style="margin-top: 10px;" type="text" class="form-control" id="p_name" placeholder="Enter Patient Name" required="true" onkeypress="" >

		                        <input type="number" id="patient_update_id" value="<?php echo $p_id;?>" style="display: none;">
				    	</div>
					</div>
					<div class="col-md-3">
		                <div class="form-group">
							<label for="exampleInputEmail1">Gender</label>
		                        <select style="margin-top: 10px;" class="form-control" id="gen">
                                  <!--   <option selected="" disabled="">Select Gender</option> -->
                                    <option>Male</option>
                                    <option>Female</option>
                                    <option>Transgender</option>
                                </select>
				        </div>
			    	</div>
				<div class="col-md-3">
		            <div class="form-group">
					    <label for="exampleInputEmail1">Date Of Birth</label>
		                    <input style="margin-top: 10px;" type="date" class="form-control" id="dob" >
		                    <input style="margin-top: 10px;display: none;" type="text" class="form-control" id="dob1" readonly="false">
					</div>
				</div>

				<script type="text/javascript">	
						$("#dob").hover(function(){
							    var today = new Date();
							    var birthDate = new Date(document.getElementById("dob").value);
							    var age = today.getFullYear() - birthDate.getFullYear();
							    var m = today.getMonth() - birthDate.getMonth();
							    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
							        age--;
							    }
									document.getElementById("age").value = age;	    	
							  		
						   
						});
				</script>

				<script type="text/javascript">	
						$(document).ready(function(){
						  $("#age").keyup(function(){

						  		var age = document.getElementById("age").value; 
						  		var today = new Date();
							    var result = today.getFullYear() - age;
							    document.getElementById("dob1").value = '01-'+'01-'+result;
							    document.getElementById("dob").style.display="none";
							    $('#dob1').css({'display':'block'});
						  });
						});
				</script>

			

				<div class="col-md-3">
		            <div class="form-group">
					   <label for="exampleInputEmail1">Age (yrs)</label>
		                    <input style="margin-top: 10px;" type="number" class="form-control" id="age" placeholder="Enter Age (yrs) ">
		                    <!-- <input style="margin-top: 10px;" type="date" class="form-control" id="dob"> -->
		                  
					</div>	
				</div>


				<div class="col-md-3">
		            <div class="form-group">
					   <label for="exampleInputEmail1">Height (ft)</label>
		                    <input style="margin-top: 10px;" type="number" class="form-control" id="hgt" placeholder="Enter Patient Height (ft)">
					</div>
				</div>
				<div class="col-md-3">
		            <div class="form-group">
					   <label for="exampleInputEmail1">Weight (kg)</label>
		                    <input style="margin-top: 10px;" type="number" class="form-control" id="wht" placeholder="Enter Patient Weight (kg)">
					</div>
				</div>
				<div class="col-md-3">
					<label for="exampleInputEmail1">Phone Number</label>
					<div class="input-group m-t-10"> 
                          <select class="form-control" style="width: 70px;" name="country" id="cty">
					    <option value="+376">AD - Andorra (+376)</option>
						<option value="+971">AE - United Arab Emirates (+971)</option>
						<option value="+93">AF - Afghanistan (+93)</option>
						<option value="+1268">AG - Antigua And Barbuda (+1268)</option>
						<option value="+1264">AI - Anguilla (+1264)</option>
						<option value="+355">AL - Albania (+355)</option>
						<option value="+374">AM - Armenia (+374)</option>
						<option value="+599">AN - Netherlands Antilles (+599)</option>
						<option value="+244">AO - Angola (+244)</option>
						<option value="+672">AQ - Antarctica (+672)</option>
						<option value="+54">AR - Argentina (+54)</option>
						<option value="+1684">AS - American Samoa (+1684)</option>
						<option value="+43">AT - Austria (+43)</option>
						<option value="+61">AU - Australia (+61)</option>
						<option value="+297">AW - Aruba (+297)</option>
						<option value="+994">AZ - Azerbaijan (+994)</option>
						<option value="+387">BA - Bosnia And Herzegovina (+387)</option>
						<option value="+1246">BB - Barbados (+1246)</option>
						<option value="+880">BD - Bangladesh (+880)</option>
						<option value="+32">BE - Belgium (+32)</option>
						<option value="+226">BF - Burkina Faso (+226)</option>
						<option value="+359">BG - Bulgaria (+359)</option>
						<option value="+973">BH - Bahrain (+973)</option>
						<option value="+257">BI - Burundi (+257)</option>
						<option value="+229">BJ - Benin (+229)</option>
						<option value="+590">BL - Saint Barthelemy (+590)</option>
						<option value="+1441">BM - Bermuda (+1441)</option>
						<option value="+673">BN - Brunei Darussalam (+673)</option>
						<option value="+591">BO - Bolivia (+591)</option>
						<option value="+55">BR - Brazil (+55)</option>
						<option value="+1242">BS - Bahamas (+1242)</option>
						<option value="+975">BT - Bhutan (+975)</option>
						<option value="+267">BW - Botswana (+267)</option>
						<option value="+375">BY - Belarus (+375)</option>
						<option value="+501">BZ - Belize (+501)</option>
						<option value="+1">CA - Canada (+1)</option>
						<option value="+61">CC - Cocos (keeling) Islands (+61)</option>
						<option value="+243">CD - Congo, The Democratic Republic Of The (+243)</option>
						<option value="+236">CF - Central African Republic (+236)</option>
						<option value="+242">CG - Congo (+242)</option>
						<option value="+41">CH - Switzerland (+41)</option>
						<option value="+225">CI - Cote D Ivoire (+225)</option>
						<option value="+682">CK - Cook Islands (+682)</option>
						<option value="+56">CL - Chile (+56)</option>
						<option value="+237">CM - Cameroon (+237)</option>
						<option value="+86">CN - China (+86)</option>
						<option value="+57">CO - Colombia (+57)</option>
						<option value="+506">CR - Costa Rica (+506)</option>
						<option value="+53">CU - Cuba (+53)</option>
						<option value="+238">CV - Cape Verde (+238)</option>
						<option value="+61">CX - Christmas Island (+61)</option>
						<option value="+357">CY - Cyprus (+357)</option>
						<option value="+420">CZ - Czech Republic (+420)</option>
						<option value="+49">DE - Germany (+49)</option>
						<option value="+253">DJ - Djibouti (+253)</option>
						<option value="+45">DK - Denmark (+45)</option>
						<option value="+1767">DM - Dominica (+1767)</option>
						<option value="+1809">DO - Dominican Republic (+1809)</option>
						<option value="+213">DZ - Algeria (+213)</option>
						<option value="+593">EC - Ecuador (+593)</option>
						<option value="+372">EE - Estonia (+372)</option>
						<option value="+20">EG - Egypt (+20)</option>
						<option value="+291">ER - Eritrea (+291)</option>
						<option value="+34">ES - Spain (+34)</option>
						<option value="+251">ET - Ethiopia (+251)</option>
						<option value="+358">FI - Finland (+358)</option>
						<option value="+679">FJ - Fiji (+679)</option>
						<option value="+500">FK - Falkland Islands (malvinas) (+500)</option>
						<option value="+691">FM - Micronesia, Federated States Of (+691)</option>
						<option value="+298">FO - Faroe Islands (+298)</option>
						<option value="+33">FR - France (+33)</option>
						<option value="+241">GA - Gabon (+241)</option>
						<option value="+44">GB - United Kingdom (+44)</option>
						<option value="+1473">GD - Grenada (+1473)</option>
						<option value="+995">GE - Georgia (+995)</option>
						<option value="+233">GH - Ghana (+233)</option>
						<option value="+350">GI - Gibraltar (+350)</option>
						<option value="+299">GL - Greenland (+299)</option>
						<option value="+220">GM - Gambia (+220)</option>
						<option value="+224">GN - Guinea (+224)</option>
						<option value="+240">GQ - Equatorial Guinea (+240)</option>
						<option value="+30">GR - Greece (+30)</option>
						<option value="+502">GT - Guatemala (+502)</option>
						<option value="+1671">GU - Guam (+1671)</option>
						<option value="+245">GW - Guinea-bissau (+245)</option>
						<option value="+592">GY - Guyana (+592)</option>
						<option value="+852">HK - Hong Kong (+852)</option>
						<option value="+504">HN - Honduras (+504)</option>
						<option value="+385">HR - Croatia (+385)</option>
						<option value="+509">HT - Haiti (+509)</option>
						<option value="+36">HU - Hungary (+36)</option>
						<option value="+62">ID - Indonesia (+62)</option>
						<option value="+353">IE - Ireland (+353)</option>
						<option value="+972">IL - Israel (+972)</option>
						<option value="+44">IM - Isle Of Man (+44)</option>
						<option selected="" value="+91">IN - India (+91)</option>
						<option value="+964">IQ - Iraq (+964)</option>
						<option value="+98">IR - Iran, Islamic Republic Of (+98)</option>
						<option value="+354">IS - Iceland (+354)</option>
						<option value="+39">IT - Italy (+39)</option>
						<option value="+1876">JM - Jamaica (+1876)</option>
						<option value="+962">JO - Jordan (+962)</option>
						<option value="+81">JP - Japan (+81)</option>
						<option value="+254">KE - Kenya (+254)</option>
						<option value="+996">KG - Kyrgyzstan (+996)</option>
						<option value="+855">KH - Cambodia (+855)</option>
						<option value="+686">KI - Kiribati (+686)</option>
						<option value="+269">KM - Comoros (+269)</option>
						<option value="+1869">KN - Saint Kitts And Nevis (+1869)</option>
						<option value="+850">KP - Korea Democratic Peoples Republic Of (+850)</option>
						<option value="+82">KR - Korea Republic Of (+82)</option>
						<option value="+965">KW - Kuwait (+965)</option>
						<option value="+1345">KY - Cayman Islands (+1345)</option>
						<option value="+7">KZ - Kazakstan (+7)</option>
						<option value="+856">LA - Lao Peoples Democratic Republic (+856)</option>
						<option value="+961">LB - Lebanon (+961)</option>
						<option value="+1758">LC - Saint Lucia (+1758)</option>
						<option value="+423">LI - Liechtenstein (+423)</option>
						<option value="+94">LK - Sri Lanka (+94)</option>
						<option value="+231">LR - Liberia (+231)</option>
						<option value="+266">LS - Lesotho (+266)</option>
						<option value="+370">LT - Lithuania (+370)</option>
						<option value="+352">LU - Luxembourg (+352)</option>
						<option value="+371">LV - Latvia (+371)</option>
						<option value="+218">LY - Libyan Arab Jamahiriya (+218)</option>
						<option value="+212">MA - Morocco (+212)</option>
						<option value="+377">MC - Monaco (+377)</option>
						<option value="+373">MD - Moldova, Republic Of (+373)</option>
						<option value="+382">ME - Montenegro (+382)</option>
						<option value="+1599">MF - Saint Martin (+1599)</option>
						<option value="+261">MG - Madagascar (+261)</option>
						<option value="+692">MH - Marshall Islands (+692)</option>
						<option value="+389">MK - Macedonia, The Former Yugoslav Republic Of (+389)</option>
						<option value="+223">ML - Mali (+223)</option>
						<option value="+95">MM - Myanmar (+95)</option>
						<option value="+976">MN - Mongolia (+976)</option>
						<option value="+853">MO - Macau (+853)</option>
						<option value="+1670">MP - Northern Mariana Islands (+1670)</option>
						<option value="+222">MR - Mauritania (+222)</option>
						<option value="+1664">MS - Montserrat (+1664)</option>
						<option value="+356">MT - Malta (+356)</option>
						<option value="+230">MU - Mauritius (+230)</option>
						<option value="+960">MV - Maldives (+960)</option>
						<option value="+265">MW - Malawi (+265)</option>
						<option value="+52">MX - Mexico (+52)</option>
						<option value="+60">MY - Malaysia (+60)</option>
						<option value="+258">MZ - Mozambique (+258)</option>
						<option value="+264">NA - Namibia (+264)</option>
						<option value="+687">NC - New Caledonia (+687)</option>
						<option value="+227">NE - Niger (+227)</option>
						<option value="+234">NG - Nigeria (+234)</option>
						<option value="+505">NI - Nicaragua (+505)</option>
						<option value="+31">NL - Netherlands (+31)</option>
						<option value="+47">NO - Norway (+47)</option>
						<option value="+977">NP - Nepal (+977)</option>
						<option value="+674">NR - Nauru (+674)</option>
						<option value="+683">NU - Niue (+683)</option>
						<option value="+64">NZ - New Zealand (+64)</option>
						<option value="+968">OM - Oman (+968)</option>
						<option value="+507">PA - Panama (+507)</option>
						<option value="+51">PE - Peru (+51)</option>
						<option value="+689">PF - French Polynesia (+689)</option>
						<option value="+675">PG - Papua New Guinea (+675)</option>
						<option value="+63">PH - Philippines (+63)</option>
						<option value="+92">PK - Pakistan (+92)</option>
						<option value="+48">PL - Poland (+48)</option>
						<option value="+508">PM - Saint Pierre And Miquelon (+508)</option>
						<option value="+870">PN - Pitcairn (+870)</option>
						<option value="+1">PR - Puerto Rico (+1)</option>
						<option value="+351">PT - Portugal (+351)</option>
						<option value="+680">PW - Palau (+680)</option>
						<option value="+595">PY - Paraguay (+595)</option>
						<option value="+974">QA - Qatar (+974)</option>
						<option value="+40">RO - Romania (+40)</option>
						<option value="+981">RS - Serbia (+381)</option>
						<option value="+7">RU - Russian Federation (+7)</option>
						<option value="+250">RW - Rwanda (+250)</option>
						<option value="+966">SA - Saudi Arabia (+966)</option>
						<option value="+677">SB - Solomon Islands (+677)</option>
						<option value="+248">SC - Seychelles (+248)</option>
						<option value="+249">SD - Sudan (+249)</option>
						<option value="+46">SE - Sweden (+46)</option>
						<option value="+65">SG - Singapore (+65)</option>
						<option value="+290">SH - Saint Helena (+290)</option>
						<option value="+386">SI - Slovenia (+386)</option>
						<option value="+421">SK - Slovakia (+421)</option>
						<option value="+232">SL - Sierra Leone (+232)</option>
						<option value="+378">SM - San Marino (+378)</option>
						<option value="+221">SN - Senegal (+221)</option>
						<option value="+252">SO - Somalia (+252)</option>
						<option value="+597">SR - Suriname (+597)</option>
						<option value="+239">ST - Sao Tome And Principe (+239)</option>
						<option value="+503">SV - El Salvador (+503)</option>
						<option value="+963">SY - Syrian Arab Republic (+963)</option>
						<option value="+268">SZ - Swaziland (+268)</option>
						<option value="+1649">TC - Turks And Caicos Islands (+1649)</option>
						<option value="+235">TD - Chad (+235)</option>
						<option value="+228">TG - Togo (+228)</option>
						<option value="+66">TH - Thailand (+66)</option>
						<option value="+992">TJ - Tajikistan (+992)</option>
						<option value="+690">TK - Tokelau (+690)</option>
						<option value="+670">TL - Timor-leste (+670)</option>
						<option value="+993">TM - Turkmenistan (+993)</option>
						<option value="+216">TN - Tunisia (+216)</option>
						<option value="+676">TO - Tonga (+676)</option>
						<option value="+90">TR - Turkey (+90)</option>
						<option value="+1868">TT - Trinidad And Tobago (+1868)</option>
						<option value="+688">TV - Tuvalu (+688)</option>
						<option value="+886">TW - Taiwan, Province Of China (+886)</option>
						<option value="+255">TZ - Tanzania, United Republic Of (+255)</option>
						<option value="+380">UA - Ukraine (+380)</option>
						<option value="+256">UG - Uganda (+256)</option>
						<option value="+1">US - United States (+1)</option>
						<option value="+598">UY - Uruguay (+598)</option>
						<option value="+998">UZ - Uzbekistan (+998)</option>
						<option value="+39">VA - Holy See (vatican City State) (+39)</option>
						<option value="+1784">VC - Saint Vincent And The Grenadines (+1784)</option>
						<option value="+58">VE - Venezuela (+58)</option>
						<option value="+1284">VG - Virgin Islands, British (+1284)</option>
						<option value="+1340">VI - Virgin Islands, U.s. (+1340)</option>
						<option value="+84">VN - Viet Nam (+84)</option>
						<option value="+678">VU - Vanuatu (+678)</option>
						<option value="+681">WF - Wallis And Futuna (+681)</option>
						<option value="+685">WS - Samoa (+685)</option>
						<option value="+381">XK - Kosovo (+381)</option>
						<option value="+967">YE - Yemen (+967)</option>
						<option value="+262">YT - Mayotte (+262)</option>
						<option value="+27">ZA - South Africa (+27)</option>
						<option value="+260">ZM - Zambia (+260)</option>
						<option value="+263">ZW - Zimbabwe (+263)</option>
					       
                          </select>
                          <input type="number" class="form-control" placeholder="Enter Phone Number" autocomplete="off" id="phn" style="width: 170px;" onKeyPress="if(this.value.length==15) return false;">
                      </div>
				</div>
				<div class="col-md-3">
		            <div class="form-group">
					   <label for="exampleInputEmail1">Email</label>
		                    <input style="margin-top: 10px;" type="email" class="form-control" id="email" placeholder="Enter Email" required="true">
					</div>
				</div>

				<div class="col-md-3">
		            <div class="form-group">
					   <label for="exampleInputEmail1">Photo</label>
		                    <input style="margin-top: 10px;" type="file" class="form-control" id="file" placeholder="" onKeyPress="if(this.value.length==15) return false;">
					</div>

				</div>

				<div class="col-md-9">
		            <div class="form-group">
					   <label for="exampleInputEmail1">Address</label>
		                    <input style="margin-top: 10px;" type="text" class="form-control" id="address" placeholder="Enter Comma Separated Fields.">
					</div>
				</div>
				<div class="col-md-2">
		            <div class="form-group">
		            	<?php if (isset($data['p_details'])) { ?>
		            		<button style="margin-top: 34px" type="button" class="btn btn-info w-md m-b-5" onclick="patient_details(0)">Update Details</button>
		            	<?php } else { ?>
					   <button style="margin-top: 34px" type="button" class="btn btn-info w-md m-b-5" onclick="patient_details(1)">Add Patient</button>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</form>
</div>


   
 



<?php require APPROOT .'/views/inc_reception/footer.php';?>

<script type="text/javascript">
	function patient_details(check)
	{

		var patid = 0;
		if(check == 0)
		{
			patid = $('#patient_update_id').val();

		}
		var p_name = $('#p_name').val();
		var gen = $('#gen').children('option:selected').val();
		var dob = $('#dob').val();
		var age = $('#age').val();
		var phone = $('#phn').val();
		var email = $('#email').val();
		var address = $('#address').val();
		var height = $('#hgt').val();
		var weight = $('#wht').val();
		var country = $('#cty').val();
		if(p_name == '')
		{
				swal({
	            title: "Please Enter Name",
	            timer: 2300,   
	            showConfirmButton: false 
	        	});

		}
		else if (gen == '') 
		{
			swal({
	            title: "Please Select Gender",
	            timer: 2300,   
	            showConfirmButton: false 
	        	});
		}

		else if (phone == '') 
		{
			swal({
	            title: "Please Enter Phone Number",
	            timer: 2300,   
	            showConfirmButton: false 
	        	});
		}
		
		else
		{
			
			if(check == 0)
			{
				upload_photo1(patid);
			}
			else
			{
				upload_photo();
			}
			$.ajax({
			url:'<?php echo URLROOT;?>/receptions/add_patient',
			type:'POST',
			data:{check,p_name,gen,dob,age,phone,email,address,patid,height,weight,country},
			success : function(data)
			{
				if(data=="updated")
				{
					swal({
			            title: "Patient Added Successfully",   
			            timer: 2000,   
			            showConfirmButton: false, 
			        });
			        $(location).attr('href', '<?php echo URLROOT;?>/receptions/all_patients');
				}
				else
				{
					swal({
			            title: "Patient Email or phone already exist",   
			            timer: 2000,   
			            showConfirmButton: false, 
			        });
				}
				// $('#p_name').val(null);
				// $('#gen').val('Select Gender');
				// $('#dob').val(null);
				// $('#age').val(null);
				// $('#phn').val(null);
				// $('#email').val(null);
				// $('#address').val(null);
				// $('#wht').val(null);
				// $('#hgt').val(null);
				// $('#cty').val(null);
				
			}
		});
		}
	}

	function upload_photo()
	{
        var fd = new FormData(); 
        var files = $('#file')[0].files[0]; 
        fd.append('file', files); 
        $.ajax({ 
            url: '<?php echo URLROOT; ?>/receptions/patient_photo_upload', 
            type: 'POST', 
            data: fd,
            contentType: false, 
            processData: false, 
            success: function(response){ 
            	$('#file').val(null);
            }, 
        });
	}
	function upload_photo1(patid)
	{
		var p = patid;
        var fd = new FormData(); 
		var files = $('#file')[0].files[0]; 
		if(files)
		{
        fd.append('file', files); 
        $.ajax({ 
            url: '<?php echo URLROOT; ?>/receptions/patient_photo_upload1', 
            type: 'POST', 
            data: fd,
            contentType: false, 
            processData: false, 
            success: function(response){ 
            	$('#file').val(null);
            }, 
		});
		}
	}
	
</script>

<script type="text/javascript">
	$('#sel_date').click(function(){
		$('#age').hide();
		$('#dob').show();
	});
</script>

<script type="text/javascript">
	$('#sel_age').click(function(){
		$('#age').show();
		$('#dob').hide();
	});
</script>

<?php
 if(isset($data['p_details']))
 {
 	foreach ($data['p_details'] as $key)
 	{
 		$name = json_encode($key->patient_name);
 		$gen = json_encode($key->patient_gender);
 		$dob = json_encode($key->patient_dob);
 		$age = json_encode($key->patient_age);
 		$phone = json_encode($key->patient_phone);
 		$eml = json_encode($key->patient_email);
 		$adrs = json_encode($key->patient_address);
 		$wght = json_encode($key->patient_weight);
 		$hght = json_encode($key->patient_height);
 	}
 	?>
 		<script type="text/javascript">
 			var name = <?php echo $name;?>;
 			var gen = <?php echo $gen;?>;
 			var dob = <?php echo $dob;?>;
 			var age = <?php echo $age;?>;
 			var phone = <?php echo $phone;?>;
 			var eml = <?php echo $eml;?>;
 			var adrs = <?php echo $adrs;?>;
 			var ht = <?php echo $hght; ?>;
 			var wt = <?php echo $wght; ?>;
 			$('#p_name').val(name);
 			$('#gen').val(gen);
 			$('#dob').val(dob);
 			if(age != null)
 			{
 				$('#age').val(age);
 			}
 			$('#phn').val(phone);
 			$('#email').val(eml);
 			$('#address').val(adrs);
 			$('#wht').val(wt);
 			$('#hgt').val(ht);
 		</script>
 	<?php
 }
?>

<script type="text/javascript">
	$(".innn").intlTelInput({
  utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.6/js/utils.js"
});
</script>