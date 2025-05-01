<?php require APPROOT .'/views/inc_reception/header.php'; ?>
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
    $_SESSION['timeslot'] = date('w');
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
                        <li class=""><a data-toggle="tab" href="#user-activities">Timeslots</a></li>
                    </ul>
                    <div class="tab-content m-0"> 
                        <div id="aboutme" class="tab-pane active">
                            <div class="box-layout meta bottom" >
                                <div class="col-sm-12 clearfix ">
                                    <div class="row">
                                        <div class="col-md-1">
                                            <span class="img-wrapper pull-left m-r-15" style="margin-top: 4px;"><img src="<?php echo URLROOT;?>/img/doc1.png" alt="" style="width:64px; height: 65px!important;" class="br-radius"></span>
                                        </div>
                                        <div class="col-md-3">

                                            <h3 class="" style="margin-top: 10px;padding-top: 0px;"><?php echo ucwords($data['doctors']->doctor_name);?><span style="font-size: 14px;">(<?php echo $data['doctors']->mem_id;?>)</span></h3>
                                            <h5 class="text"> 
                                                <?php 
                                                    echo $data['doctors']->doctor_speciality;
                                                ?>
                                            </h5>
                                        </div>
                                        <div class="col-md-8">
                                            
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
                                        <td class="come_left"><b>Phone</b></td>
                                        <td class="come_left">
                                        <a href="#" class="ng-binding" style="cursor: text;">
                                           <?php echo $data['auth']->mem_phone;?>
                                        </a></td>
                                    </tr>
                                     <tr>
                                        <td class="come_left"><b>Email</b></td>
                                        <td class="come_left">
                                        <a href="#" class="ng-binding" style="cursor: text;">
                                            <?php echo $data['auth']->mem_email;?>
                                        </a></td>
                                    </tr>
                                </tbody>
                            </table>
                          </div>
                        </div> <!-- end profile-desk -->
                    </div> <!-- about-me -->


                    <!-- Activities -->

                    <div id="user-activities" class="tab-pane">
                        <div class="row"> 
                        <?php
                            if(isset($data['times']->days_slots_start)) {
                            $startTime = explode('__', $data['times']->days_slots_start);
                            $endTime = explode('__', $data['times']->days_slots_end);
                        ?>
                            <div class="col-lg-12"> 
                                <ul class="nav nav-tabs nav-justified"> 
                                    <li class="<?php if(!isset($_SESSION['timeslot'])) { ?>
                                    active
                                    <?php } elseif($_SESSION['timeslot'] == 0) { ?>
                                    active    
                                    <?php } ?>"> 
                                        <a href="#sun" data-toggle="tab" aria-expanded="false"> 
                                            <span class="visible-xs">Sunday</span> 
                                            <span class="hidden-xs">Sunday</span> 
                                        </a> 
                                    </li> 
                                    <li class="<?php if($_SESSION['timeslot'] == 1) { ?>
                                    active
                                    <?php } ?>"> 
                                        <a href="#mon" data-toggle="tab" aria-expanded="flase"> 
                                            <span class="visible-xs">Monday</span> 
                                            <span class="hidden-xs">Monday</span> 
                                        </a> 
                                    </li> 
                                    <li class="<?php if($_SESSION['timeslot'] == 2) { ?>
                                    active
                                    <?php } ?>"> 
                                        <a href="#tue" data-toggle="tab" aria-expanded="false"> 
                                            <span class="visible-xs">Tuesday</span> 
                                            <span class="hidden-xs">Tuesday</span> 
                                        </a> 
                                    </li> 
                                    <li class="<?php if($_SESSION['timeslot'] == 3) { ?>
                                    active
                                    <?php } ?>"> 
                                        <a href="#wed" data-toggle="tab" aria-expanded="false"> 
                                            <span class="visible-xs">Wednesday</span> 
                                            <span class="hidden-xs">Wednesday</span> 
                                        </a> 
                                    </li>
                                    <li class="<?php if($_SESSION['timeslot'] == 4) { ?>
                                    active
                                    <?php } ?>"> 
                                        <a href="#thu" data-toggle="tab" aria-expanded="false"> 
                                            <span class="visible-xs">Thursday</span> 
                                            <span class="hidden-xs">Thursday</span> 
                                        </a> 
                                    </li>
                                    <li class="<?php if($_SESSION['timeslot'] == 5) { ?>
                                    active
                                    <?php } ?>"> 
                                        <a href="#fri" data-toggle="tab" aria-expanded="false"> 
                                            <span class="visible-xs">Friday</span> 
                                            <span class="hidden-xs">Friday</span> 
                                        </a> 
                                    </li>
                                    <li class="<?php if($_SESSION['timeslot'] == 6) { ?>
                                    active
                                    <?php } ?>"> 
                                        <a href="#sat" data-toggle="tab" aria-expanded="false"> 
                                            <span class="visible-xs">Saturday</span> 
                                            <span class="hidden-xs">Saturday</span> 
                                        </a> 
                                    </li> 
                                </ul> 
                                <div class="tab-content"> 
                                    <div class="tab-pane 
                                    <?php if(!isset($_SESSION['timeslot'])) { ?>
                                    active
                                    <?php } elseif($_SESSION['timeslot'] == 0) { ?>
                                    active    
                                    <?php } ?>
                                    " id="sun">
                                        
                                        <h4>Time Slots</h4>
                                        <br>
                                        <div>
                                            <?php
                                                $sundayStart = explode('||', $startTime[0]);
                                                $sundayEnd = explode('||', $endTime[0]);

                                                if(!empty($sundayStart))
                                                {
                                                    for ($sun=0; $sun < sizeof($sundayStart); $sun++) 
                                                    { 
                                                        if($sundayStart[$sun] != 0)
                                                        {
                                                            echo '<button type="button" class="btn btn-pink m-b-5 includer">'.$sundayStart[$sun].' - '.$sundayEnd[$sun].'</button>
                                                            &nbsp
                                                            &nbsp';
                                                        }
                                                    }
                                                }
                                                else
                                                {
                                                    echo "No timeslots.";
                                                }
                                            ?> 
                                        </div> 
                                    </div>
                                    <div class="tab-pane
                                    <?php if($_SESSION['timeslot'] == 1) { ?>
                                    active
                                    <?php } ?>
                                    " id="mon"> 
                                         
                                            <h4>Time Slots</h4>
                                        <br>
                                        <div>
                                            <?php
                                                $mondayStart = explode('||', $startTime[1]);
                                                $mondayEnd = explode('||', $endTime[1]);

                                                if(array_sum($mondayStart) != 0)
                                                {
                                                    for ($mon=0; $mon < sizeof($mondayStart); $mon++) 
                                                    {
                                                        if($mondayStart[$mon] != 0)
                                                        { 
                                                            echo '<button type="button" class="btn btn-pink m-b-5 includer">'.$mondayStart[$mon].' - '.$mondayEnd[$mon].'
                                                            </button>
                                                            &nbsp
                                                            &nbsp';
                                                        }
                                                    }
                                                }
                                                else
                                                {
                                                    echo "No timeslots.";
                                                }
                                            ?> 
                                        </div> 
                                    </div> 
                                    <div class="tab-pane  
                                    <?php if($_SESSION['timeslot'] == 2) { ?>
                                    active
                                    <?php } ?>
                                    " id="tue"> 
                                       
                                        <h4>Time Slots</h4>
                                        <br>
                                        <div>
                                            <?php
                                                $tuesdayStart = explode('||', $startTime[2]);
                                                $tuesdayEnd = explode('||', $endTime[2]);

                                                if(array_sum($tuesdayStart) != 0)
                                                {
                                                    for ($tue=0; $tue < sizeof($tuesdayStart); $tue++) 
                                                    { 
                                                        if($tuesdayStart[$tue] != 0)
                                                        {
                                                            echo '<button type="button" class="btn btn-pink m-b-5 includer">'.$tuesdayStart[$tue].' - '.$tuesdayEnd[$tue].'
                                                            </button>
                                                            &nbsp
                                                            &nbsp';
                                                        }
                                                    }
                                                }
                                                else
                                                {
                                                    echo "No timeslots.";
                                                }
                                            ?> 
                                        </div> 
                                    </div>
                                    <div class="tab-pane  
                                    <?php if($_SESSION['timeslot'] == 3) { ?>
                                    active
                                    <?php } ?>
                                    " id="wed"> 
                                        
                                        <h4>Time Slots</h4>
                                        <br>
                                        <div>
                                            <?php
                                                $wednesdayStart = explode('||', $startTime[3]);
                                                $wednesdayEnd = explode('||', $endTime[3]);

                                                if(array_sum($wednesdayStart) != 0)
                                                {
                                                    for ($wed=0; $wed < sizeof($wednesdayStart); $wed++) 
                                                    { 
                                                        if($wednesdayStart[$wed] != 0)
                                                        {
                                                            echo '<button type="button" class="btn btn-pink m-b-5 includer">'.$wednesdayStart[$wed].' - '.$wednesdayEnd[$wed].'
                                                            </button>
                                                            &nbsp
                                                            &nbsp';
                                                        }
                                                    }
                                                }
                                                else
                                                {
                                                    echo "No timeslots.";
                                                }
                                            ?> 
                                        </div> 
                                    </div>
                                    <div class="tab-pane  
                                    <?php if($_SESSION['timeslot'] == 4) { ?>
                                    active
                                    <?php } ?>
                                    " id="thu"> 
                                        
                                        <h4>Time Slots</h4>
                                        <br>
                                        <div>
                                            <?php
                                                $thursadayStart = explode('||', $startTime[4]);
                                                $thursdayEnd = explode('||', $endTime[4]);

                                                if(array_sum($thursadayStart) != 0)
                                                {
                                                    for ($thu=0; $thu < sizeof($thursadayStart); $thu++) 
                                                    { 
                                                        if($thursadayStart[$thu] != 0)
                                                        {
                                                            echo '<button type="button" class="btn btn-pink m-b-5 includer">'.$thursadayStart[$thu].' - '.$thursadayStart[$thu].'
                                                            </button>
                                                            &nbsp
                                                            &nbsp';
                                                        }
                                                    }
                                                }
                                                else
                                                {
                                                    echo "No timeslots.";
                                                }
                                            ?> 
                                        </div> 
                                    </div>
                                    <div class="tab-pane
                                    <?php if($_SESSION['timeslot'] == 5) { ?>
                                    active
                                    <?php } ?>
                                    " id="fri"> 
                                         
                                        <h4>Time Slots</h4>
                                        <br>
                                        <div>
                                            <?php
                                                $fridayStart = explode('||', $startTime[5]);
                                                $fridayEnd = explode('||', $endTime[5]);

                                                if(array_sum($fridayStart) != 0)
                                                {
                                                    for ($fri=0; $fri < sizeof($fridayStart); $fri++) 
                                                    { 
                                                        if($fridayStart[$fri] != 0)
                                                        {
                                                            echo '<button type="button" class="btn btn-pink m-b-5 includer">'.$fridayStart[$fri].' - '.$fridayEnd[$fri].'
                                                            </button>
                                                            &nbsp
                                                            &nbsp';
                                                        }
                                                    }
                                                }
                                                else
                                                {
                                                    echo "No timeslots.";
                                                }
                                            ?> 
                                        </div>  
                                    </div>
                                    <div class="tab-pane 
                                    <?php if($_SESSION['timeslot'] == 6) { ?>
                                    active
                                    <?php } ?>
                                    " id="sat"> 
                                        <h4>Time Slots</h4>
                                        <br>
                                        <div>
                                            <?php
                                                $saturdayStart = explode('||', $startTime[6]);
                                                $saturdayEnd = explode('||', $endTime[6]);

                                                if(array_sum($saturdayStart) != 0)
                                                {
                                                    for ($sat=0; $sat < sizeof($saturdayStart); $sat++) 
                                                    { 
                                                        if($saturdayStart[$sat] != 0)
                                                        {
                                                            echo '<button type="button" class="btn btn-pink m-b-5 includer">'.$saturdayStart[$sat].' - '.$saturdayStart[$sat].'
                                                            </button>
                                                            &nbsp
                                                            &nbsp';
                                                        }
                                                    }
                                                }
                                                else
                                                {
                                                    echo "No timeslots.";
                                                }
                                            ?> 
                                        </div> 
                                    </div>
                                </div> 
                            </div> 
                            <?php } else { ?>
                                <h4>Timeslots not updated</h4>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>
</div>
</div>

<?php require APPROOT .'/views/inc_reception/footer.php'; ?>


