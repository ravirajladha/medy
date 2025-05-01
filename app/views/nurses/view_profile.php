<?php require APPROOT .'/views/inc_nurse/header.php'; ?>
<style type="text/css">
    .come_left
    {
        text-align: left!important;
    }

    @media (min-width: 320px) and (max-width: 480px)
    {
        .dispr_in_mob
        {
            display: none;
        } 
    }

    @media(min-width: 480px) and (max-width: 1500px)
    {
        .disp_other_than_mob
        {
            display: none;
        }
    }
</style>
<?php
$i = 1;
$rec_obj = new Nurses;
foreach ($data['p_data'] as $key)
{
    $patient_name = $key->patient_name;
    $patient_id = $key->patient_id;
    $dob = $key->patient_dob;
    $p_gen = $key->patient_gender;
    $pphone = $key->patient_phone;
    $pemail = $key->patient_email;
    $paddress = $key->patient_address;
    $age = $key->patient_age;
    $reg_date = $key->age_update_time;
}

?>
<div class="wraper container-fluid">
    <div class="row">
    </div>
    <div class="row m-t-30">
        <div class="col-sm-12">
            <div class="panel panel-default p-0">
                <div class="panel-body p-0"> 
                    <ul class="nav nav-tabs profile-tabs">
                        <li class="active"><a data-toggle="tab" href="#aboutme">About</a></li>
                        <li class=""><a data-toggle="tab" href="#user-activities">Visits</a></li>
                        <li class=""><a data-toggle="tab" href="#user-activities1">Admits</a></li>
                    </ul>

                    <div class="tab-content m-0"> 
                        <div id="aboutme" class="tab-pane active">
                            <div class="box-layout meta bottom" >
                                <div class="col-sm-12 clearfix ">
                                    <div class="row">
                                        <div class="col-md-1">
                                            <span class="img-wrapper pull-left m-r-15" style="margin-top: 4px;"><img src="<?php echo URLROOT;?>/img/pat.jpg" alt="" style="width:64px; height: 65px!important;" class="br-radius"></span>
                                        </div>
                                        <div class="col-md-3">

                                            <h3 class="" style="margin-top: 0px;padding-top: 0px;"><?php echo ucwords($patient_name);?><span style="font-size: 14px;">(<?php echo $patient_id;?>)</span></h3>
                                            <h5 class="text">Age: 
                                            <?php 
                                                $curr_yr = date('Y-m-d');
                                                if($dob != "0000-00-00")
                                                {
                                                    $diff = abs(strtotime($curr_yr) - strtotime($dob));
                                                    $years = floor($diff / (365*60*60*24));
                                                    $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                                                    $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24)); 
                                                    if($years > 1)
                                                    {
                                                        echo $years;
                                                        echo " years ";
                                                    }
                                                    else
                                                    {
                                                        if($years != 0)
                                                        {
                                                            echo $years;
                                                            echo " year ";
                                                        }
                                                    }
                                                    if($years < 1)
                                                    {
                                                        if($months > 1)
                                                        {
                                                            echo $months;
                                                            echo " months";
                                                        }
                                                        else
                                                        {
                                                            if($months != 0)
                                                            {
                                                                echo $months;
                                                                echo " month";
                                                            }
                                                            else
                                                            {
                                                                if($days > 0)
                                                                {
                                                                    echo $days;
                                                                    echo " days";
                                                                }
                                                                else
                                                                {
                                                                    echo $days;
                                                                    echo " day";
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                                else
                                                {
                                                    $au_year = date('Y', strtotime($reg_date));
                                                    $c_year = date('Y');
                                                    $age = $age + ($c_year - $au_year);
                                                    if($age > 1)
                                                    {
                                                        echo $age;
                                                        echo " years";
                                                    }
                                                    else
                                                    {
                                                        echo $age;
                                                        echo " year";
                                                    }
                                                }
                                            ?></h5>
                                        </div>
                                        <div class="col-md-8">
                                            <!--  -->
                                        </div>
                                    </div>
                                  
                                </div>
                                
                            </div>
                            <div class="profile-desk">
                            <!-- <h1><?php echo $patient_name;?></h1> -->
                            <!-- <span class="designation"><?php echo $patient_id;?></span> -->
                            <!-- <br> -->
                            <div class="col-sm-12">
                                <br>
                            <table class="table table-condensed" >
                                <thead>
                                    <tr>
                                        <th colspan="3" class="come_left"><h3>Basic Information</h3></th>
                                    </tr>
                                </thead>
                                <br>
                                <tbody>
                                    <tr>
                                        <td class="come_left"><b>DOB</b></td>
                                        <td class="come_left">
                                        <a href="#" class="ng-binding">
                                           <?php echo date('d-m-Y',strtotime($dob));?>
                                        </a></td>
                                    </tr>
                                     <tr>
                                        <td class="come_left"><b>Gender</b></td>
                                        <td class="come_left">
                                        <a href="" class="ng-binding">
                                            <?php echo $p_gen;?>
                                        </a></td>
                                    </tr>
                                    <tr>
                                        <td class="come_left"><b>Email</b></td>
                                        <td class="come_left">
                                        <a href="" class="ng-binding">
                                            <?php echo $pemail;?>
                                        </a></td>
                                    </tr>
                                    <tr>
                                        <td class="come_left"><b>Phone</b></td>
                                        <td class="ng-binding come_left">
                                        <a href="" class="ng-binding">
                                            <?php echo $pphone;?>
                                        </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="come_left"><b>Address</b></td>
                                        <td class="ng-binding come_left">
                                        <a href="" class="ng-binding">
                                            <?php echo ucwords($paddress);?>
                                        </a>    
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                          </div>
                        </div> <!-- end profile-desk -->
                    </div> <!-- about-me -->


                    <!-- Activities -->
                    <div id="user-activities" class="tab-pane">
                        <?php foreach($data['opd_data'] as $test) {
                            $doc_data = $rec_obj->get_doc($test->opd_doctor_id);
                            $date = $test->visit_date_time;
                            $pur = $test->opd_purpose;
                            $visit_date = $test->visit_date_time;
                            $visit_id = $test->opd_visit_id;
                            foreach ($doc_data as $value)
                            {
                                $doc_name = $value->doctor_name;
                            }
                        ?>
                        <div class="timeline-2">
                            <div class="time-item">
                                <div class="item-info">
                                    <div class="text-muted">Visit: <?php echo date('d-m-Y h:i A', strtotime($visit_date));?></div>
                                    <p><strong>Doctor: <a href="#" class="text-info"><?php echo ucwords($doc_name);?></a></strong></p>
                                    <p><strong>Purpose: <a href="#" class="text-info"><?php echo ucwords($pur) ;?></a></strong></p>
                                    <a data-toggle="modal" href="#con-close-modal<?php echo $visit_id;?>" class="" style="font-size: 14px; color: #F0B27A;">Know More →</a>
                                </div>
                            </div>
                        </div>

                        <div id="con-close-modal<?php echo $visit_id;?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                            <?php
                                 $opd_dat = $rec_obj->get_all_opd_data($visit_id);
                                 foreach ($opd_dat as $key3)
                                 {
                                    $visit_id = $key3->opd_visit_id;
                                    $p_id = $key3->opd_patient_id;
                                    $visit_date = $key3->visit_date_time;
                                    $opc = $key3->opd_present_condition;
                                    $oe = $key3->opd_examination;
                                    $oi = $key3->opd_investigation;
                                    $on = $key3->opd_notes;
                                    $od = $key3->opd_diagnosis;
                                    $op = $key3->opd_prescription;
                                    $pres = explode('$$', $op);
                                    $pres0 = $pres[0];
                                    $pres0 = explode(',', $pres0);
                                    $pres1 = $pres[1];
                                    $pres1 = explode(',', $pres1);//unit
                                    $oins = $key3->opd_instruction;
                                    $ota = $key3->opd_test_advised;
                                    $ofd = $key3->opd_followup_date;
                                    $proc = explode('$&$x', $key3->opd_prescription_procedure);
                                    $length = sizeof($proc);
                                    unset($proc[$length-1]);
                                 }
                            ?>
                                <div class="modal-dialog"> 
                                    <div class="modal-content"> 
                                        <div class="modal-header"> 
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
                                            <h4 class="modal-title">Visit Details</h4>
                                        </div> 
                                        <div class="modal-body"> 
                                            <div class="row"> 
                                                <div class="col-md-6"> 
                                                    <label>Visit Date and Time: </label> <?php echo date('d-m-Y H:i A',strtotime($visit_date));?><br>
                                                    <label>Doctor Name: </label> <?php echo ucwords($doc_name);?><br>
                                                    <label>Diagnosis: </label> <?php echo ucwords($od);?>
                                                </div> 
                                                <div class="col-md-5"> 
                                                     
                                                </div> 
                                                <div class="col-md-1"> 
                                                    <a href="<?php echo URLROOT;?>/nurses/print_prescription/<?php echo $visit_id;?>"><button type="button" class="btn btn-info btn-xs m-b-5"> Print </button></a><br>
                                                </div> 
                                            </div> 
                                            <div class="row"> 
                                                <div class="col-md-12"> 
                                                    <div class="form-group"> 
                                                        
                                                         
                                                    </div> 
                                                </div> 
                                            </div> 
                                            <div class="row"> 
                                                <div class="col-md-12">
                                                    <div class="table-responsive">
                                                        <table class="table m-t-30">
                                                            <h3>Prescription</h3>
                                                            <thead>
                                                                <tr>
                                                                    <th style="text-align: left;">Medicine Name</th>
                                                                    <th style="text-align: left;">Dosage</th>
                                                                    <th style="text-align: left;">Duration</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                                <?php 
                                                                if(!empty($op)){

                                                                for ($i=0; $i < count($pres0) ; $i++) 
                                                                { 
                                                                ?>  
                                                                <tr>
                                                                    <td style="text-align: left;"><?php $withoutId = explode('(', $pres0[$i]);
                                                                     
                                                                        echo ucwords($withoutId[0]);
                                                                        
                                                                    ?><br>
                                                                    <?php if($withoutId[1] > 1 ) { ?>    
                                                                        <small>(Units: <?php echo $withoutId[1];?></small>
                                                                    <?php } else { ?>
                                                                        <small>Unit: <?php echo $withoutId[1];?></small>
                                                                    <?php } ?>
                                                                    </td>
                                                                    <td style="text-align: left;">
                                                                        <?php
                                                                            $pr = explode(',', $proc[$i]);
                                                                            $len = sizeof($pr);
                                                                            $prin = '';
                                                                            $day = '';
                                                                            for($k=0;$k<$len/4;$k++)
                                                                            {
                                                                            for ($j=$k; $j < $len;$j=$j+$len/4) 
                                                                            { 
                                                                                $prin .= $pr[$j];
                                                                                $prin .= ',';
                                                                            }
                                                                            $prin = explode(',', $prin);
                                                                            if($prin[2] == "Not Specified") {
                                                                                
                                                                              echo $prin[1],' &bull; ',$prin[3];
                                                                            }
                                                                            else{
                                                                              echo $prin[1],' &bull; ',$prin[2],' &bull; ',$prin[3];
                                                                            }
                                                                            $day .= $prin[0];
                                                                            $day .= ','; 
                                                                            $prin = '';
                                                                            ?><br><?php
                                                                            }
                                                                        ?>
                                                                    </td>
                                                                    <td style="text-align: left">
                                                                        <?php 
                                                                            $day = explode(',', $day);
                                                                            $leng = sizeof($day);
                                                                            unset($day[$leng-1]);
                                                                            for ($n=0; $n < sizeof($day); $n++)
                                                                            { 
                                                                                if($day[$n] == 1)
                                                                                {
                                                                                    echo $day[$n];
                                                                                    echo " day";
                                                                                }
                                                                                else
                                                                                {
                                                                                    echo $day[$n];
                                                                                    echo " days";
                                                                                }
                                                                                echo "<br>";
                                                                            }
                                                                        ?>
                                                                    </td>
                                                                </tr>
                                                               <?php }} ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div> 
                                            <?php if($oins != '') { ?>
                                            <div class="row"> 
                                                <div class="col-md-12"> 
                                                    <div class="form-group"> 
                                                        <label for="field-4" class="control-label">Instruction :</label> <?php echo $oins;?> 
                                                    </div> 
                                                </div> 
                                            </div> 
                                            <?php } ?>
                                        </div> 
                                        <!-- <div class="modal-footer"> 
                                            <button type="button" class="btn btn-white" data-dismiss="modal">Close</button> 
                                        </div>  -->
                                    </div> 
                                </div>
                            </div>
                        <?php } ?>
                    </div>

                    <div id="user-activities1" class="tab-pane">
                        <?php if($data['ipd_data'] == NULL)
                        {
                            echo "No Admits for this Patient.";
                        } ?>
                        <?php foreach ($data['ipd_data'] as $ipd) {
                            $doct = $rec_obj->get_doc($ipd->ipd_doctor_id);
                            foreach ($doct as $doc) {
                                $doct_name = $doc->doctor_name;
                            }
                        ?>
                        <div class="timeline-2">
                            <div class="time-item">
                                <div class="item-info">
                                    <div class="text-muted">Admit: <?php echo date('d-m-Y h:i A', strtotime($ipd->admission_date_time));?></div>
                                    <p><strong>Doctor: <a href="#" class="text-info"><?php echo ucwords($doct_name);?></a></strong></p>
                                    <form action="<?php echo URLROOT; ?>/receptions/discharge_summary" method="POST">
                                        <input type="number" name="pat" value="<?php echo $ipd->ipd_patient_id; ?>" style="display: none;">
                                        <input type="number" name="admit" value="<?php echo $ipd->ipd_admit_id; ?>" style="display: none;" >
                                        <button class="btn btn-primary btn-xs m-b-5" type="submit">Print Discharge Summary</button>
                                    </form>
                                    <a href="<?php echo URLROOT; ?>/receptions/print_admit_medicines/<?php echo $ipd->ipd_admit_id; ?>"><button class="btn btn-purple btn-xs m-b-5">Print Medicine</button></a>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div> 
        </div>
    </div>
</div>
</div>

<?php require APPROOT .'/views/inc_nurse/footer.php'; ?>


