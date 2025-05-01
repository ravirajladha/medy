<?php require APPROOT .'/views/inc_doctor/header.php'; ?>
<style>
    .badge.badge-success{
        background-color: #F48FB1;
        position: absolute; 
        top: -8px;
        right: -8px;
        color: white;
        }
    .includer{
    position: relative;
    }
</style>
<div class="wraper container-fluid">
    <div class="page-title"> 
        <h3 class="title">Schedule Timings for Consultation</h3> 
    </div>
    <?php
        if(!empty($data['times']->days_slots_start))
        {
            $startTime = explode('__', $data['times']->days_slots_start);
            $endTime = explode('__', $data['times']->days_slots_end);

            $sundayStart = explode('||', $startTime[0]);
            $sundayEnd = explode('||', $endTime[0]);

            $mondayStart = explode('||', $startTime[1]);
            $mondayEnd = explode('||', $endTime[1]);

            $tuesdayStart = explode('||', $startTime[2]);
            $tuesdayEnd = explode('||', $endTime[2]);

            $wednesdayStart = explode('||', $startTime[3]);
            $wednesdayEnd = explode('||', $endTime[3]);

            $thursadayStart = explode('||', $startTime[4]);
            $thursdayEnd = explode('||', $endTime[4]);

            $fridayStart = explode('||', $startTime[5]);
            $fridayEnd = explode('||', $endTime[5]);

            $saturdayStart = explode('||', $startTime[6]);
            $saturdayEnd = explode('||', $endTime[6]);
        }
    ?>
    <!-- Tabs-style-1 -->
    <div class="row"> 
        <div class="col-lg-12"> 
            <ul class="nav nav-tabs"> 
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
                        <span class="visible-xs"><i class="fa fa-user"></i></span> 
                        <span class="hidden-xs">Monday</span> 
                    </a> 
                </li> 
                <li class="<?php if($_SESSION['timeslot'] == 2) { ?>
                active
                <?php } ?>"> 
                    <a href="#tue" data-toggle="tab" aria-expanded="false"> 
                        <span class="visible-xs"><i class="fa fa-envelope-o"></i></span> 
                        <span class="hidden-xs">Tuesday</span> 
                    </a> 
                </li> 
                <li class="<?php if($_SESSION['timeslot'] == 3) { ?>
                active
                <?php } ?>"> 
                    <a href="#wed" data-toggle="tab" aria-expanded="false"> 
                        <span class="visible-xs"><i class="fa fa-cog"></i></span> 
                        <span class="hidden-xs">Wednesday</span> 
                    </a> 
                </li>
                <li class="<?php if($_SESSION['timeslot'] == 4) { ?>
                active
                <?php } ?>"> 
                    <a href="#thu" data-toggle="tab" aria-expanded="false"> 
                        <span class="visible-xs"><i class="fa fa-cog"></i></span> 
                        <span class="hidden-xs">Thursday</span> 
                    </a> 
                </li>
                <li class="<?php if($_SESSION['timeslot'] == 5) { ?>
                active
                <?php } ?>"> 
                    <a href="#fri" data-toggle="tab" aria-expanded="false"> 
                        <span class="visible-xs"><i class="fa fa-cog"></i></span> 
                        <span class="hidden-xs">Friday</span> 
                    </a> 
                </li>
                <li class="<?php if($_SESSION['timeslot'] == 6) { ?>
                active
                <?php } ?>"> 
                    <a href="#sat" data-toggle="tab" aria-expanded="false"> 
                        <span class="visible-xs"><i class="fa fa-cog"></i></span> 
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
                    <button style="float:right" class="md-trigger btn btn-purple btn-xs m-b-5" onclick="openModal(0)">+ Add</button> 
                    <h4>Time Slots</h4>
                    <br>
                    <div>
                        <?php
                            if(!empty($sundayStart))
                            {
                                for ($sun=0; $sun < sizeof($sundayStart); $sun++) 
                                { 
                                    if($sundayStart[$sun] != 0)
                                    {
                                        echo '<button type="button" class="btn btn-pink m-b-5 includer">'.$sundayStart[$sun].' - '.$sundayEnd[$sun].' 
                                        <a href="'.URLROOT.'/doctors/updateTimeSlot/'.$sun.',0"><span class="badge badge-success">X</span></a>
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
                <?php if($_SESSION['timeslot'] == 1) { ?>
                active
                <?php } ?>
                " id="mon"> 
                    <button style="float:right" class="md-trigger btn btn-purple btn-xs m-b-5" onclick="openModal(1)">+ Add</button> 
                        <h4>Time Slots</h4>
                    <br>
                    <div>
                        <?php
                            if(!empty($mondayStart))
                            {
                                for ($mon=0; $mon < sizeof($mondayStart); $mon++) 
                                {
                                    if($mondayStart[$mon] != 0)
                                    { 
                                        echo '<button type="button" class="btn btn-pink m-b-5 includer">'.$mondayStart[$mon].' - '.$mondayEnd[$mon].' 
                                        <a href="'.URLROOT.'/doctors/updateTimeSlot/'.$mon.',1"><span class="badge badge-success">X</span></a>
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
                    <button style="float:right" class="md-trigger btn btn-purple btn-xs m-b-5" onclick="openModal(2)">+ Add</button> 
                    <h4>Time Slots</h4>
                    <br>
                    <div>
                        <?php
                            if(!empty($tuesdayStart))
                            {
                                for ($tue=0; $tue < sizeof($tuesdayStart); $tue++) 
                                { 
                                    if($tuesdayStart[$tue] != 0)
                                    {
                                        echo '<button type="button" class="btn btn-pink m-b-5 includer">'.$tuesdayStart[$tue].' - '.$tuesdayEnd[$tue].' 
                                        <a href="'.URLROOT.'/doctors/updateTimeSlot/'.$tue.',2"><span class="badge badge-success">X</span></a>
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
                    <button style="float:right" class="md-trigger btn btn-purple btn-xs m-b-5" onclick="openModal(3)">+ Add</button> 
                    <h4>Time Slots</h4>
                    <br>
                    <div>
                        <?php
                            if(!empty($wednesdayStart))
                            {
                                for ($wed=0; $wed < sizeof($wednesdayStart); $wed++) 
                                { 
                                    if($wednesdayStart[$wed] != 0)
                                    {
                                        echo '<button type="button" class="btn btn-pink m-b-5 includer">'.$wednesdayStart[$wed].' - '.$wednesdayEnd[$wed].' 
                                        <a href="'.URLROOT.'/doctors/updateTimeSlot/'.$wed.',3"><span class="badge badge-success">X</span></a>
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
                    <button style="float:right" class="md-trigger btn btn-purple btn-xs m-b-5" onclick="openModal(4)">+ Add</button> 
                    <h4>Time Slots</h4>
                    <br>
                    <div>
                        <?php
                            if(!empty($thursadayStart))
                            {
                                for ($thu=0; $thu < sizeof($thursadayStart); $thu++) 
                                { 
                                    if($thursadayStart[$thu] != 0)
                                    {
                                        echo '<button type="button" class="btn btn-pink m-b-5 includer">'.$thursadayStart[$thu].' - '.$thursadayStart[$thu].' 
                                        <a href="'.URLROOT.'/doctors/updateTimeSlot/'.$thu.',4"><span class="badge badge-success">X</span></a>
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
                    <button style="float:right" class="md-trigger btn btn-purple btn-xs m-b-5" onclick="openModal(5)">+ Add</button> 
                    <h4>Time Slots</h4>
                    <br>
                    <div>
                        <?php
                            if(!empty($fridayStart))
                            {
                                for ($fri=0; $fri < sizeof($fridayStart); $fri++) 
                                { 
                                    if($fridayStart[$fri] != 0)
                                    {
                                        echo '<button type="button" class="btn btn-pink m-b-5 includer">'.$fridayStart[$fri].' - '.$fridayEnd[$fri].' 
                                        <a href="'.URLROOT.'/doctors/updateTimeSlot/'.$fri.',5"><span class="badge badge-success">X</span></a>
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
                    <button style="float:right" class="md-trigger btn btn-purple btn-xs m-b-5" onclick="openModal(6)">+ Add</button> 
                    <h4>Time Slots</h4>
                    <br>
                    <div>
                        <?php
                            if(!empty($saturdayStart))
                            {
                                for ($sat=0; $sat < sizeof($saturdayStart); $sat++) 
                                { 
                                    if($saturdayStart[$sat] != 0)
                                    {
                                        echo '<button type="button" class="btn btn-pink m-b-5 includer">'.$saturdayStart[$sat].' - '.$saturdayStart[$sat].' 
                                        <a href="'.URLROOT.'/doctors/updateTimeSlot/'.$sat.',6"><span class="badge badge-success">X</span></a>
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
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="timeSlotModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="exampleModalLabel">Time Slots</h5>
      </div>
      <form action="<?php echo URLROOT; ?>/doctors/saveTimeSlots" method="POST">
      <div class="modal-body">
        <div class="row" id="appendDiv">
            <input type="hidden" class="" id="dayId" name="dayId">
            <div class="col-md-6">
                <label for="" class="">Start Date</label>
                <div class="form-group">
                    <select name="start[]" id="" class="form-control">
                        <option>12.00 am</option>
                        <option>1.00 am</option>
                        <option>2.00 am</option>
                        <option>3.00 am</option>
                        <option>4.00 am</option>
                        <option>5.00 am</option>
                        <option>6.00 am</option>
                        <option>7.00 am</option>
                        <option>8.00 am</option>
                        <option>9.00 am</option>
                        <option>10.00 am</option>
                        <option>11.00 am</option>
                        <option>12.00 pm</option>
                        <option>1.00 pm</option>
                        <option>2.00 pm</option>
                        <option>3.00 pm</option>
                        <option>4.00 pm</option>
                        <option>5.00 pm</option>
                        <option>6.00 pm</option>
                        <option>7.00 pm</option>
                        <option>8.00 pm</option>
                        <option>9.00 pm</option>
                        <option>10.00 pm</option>
                        <option>11.00 pm</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
            <label for="" class="">End Date</label>
                <div class="form-group">
                <select name="end[]" id="" class="form-control">
                    <option>12.00 am</option>
                    <option>1.00 am</option>
                    <option>2.00 am</option>
                    <option>3.00 am</option>
                    <option>4.00 am</option>
                    <option>5.00 am</option>
                    <option>6.00 am</option>
                    <option>7.00 am</option>
                    <option>8.00 am</option>
                    <option>9.00 am</option>
                    <option>10.00 am</option>
                    <option>11.00 am</option>
                    <option>12.00 pm</option>
                    <option>1.00 pm</option>
                    <option>2.00 pm</option>
                    <option>3.00 pm</option>
                    <option>4.00 pm</option>
                    <option>5.00 pm</option>
                    <option>6.00 pm</option>
                    <option>7.00 pm</option>
                    <option>8.00 pm</option>
                    <option>9.00 pm</option>
                    <option>10.00 pm</option>
                    <option>11.00 pm</option>
                </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
            <a href="#" style="float: right; color:#01358D" onclick="appendDiv()"> <b>+ Add More</b> </a>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <center class=""><button type="submit" class="btn btn-primary">Save changes</button></center>
      </div>
    </form>
    </div>
  </div>
</div>
<script>
    function openModal(id)
    {
        $('#dayId').val(id);
        $('#timeSlotModal').modal('show');
    }

    function appendDiv()
    {
        $('#appendDiv').append('<div class="col-md-6">\
                <div class="form-group">\
                    <select name="start[]" id="" class="form-control">\
                        <option>12.00 am</option>\
                        <option>1.00 am</option>\
                        <option>2.00 am</option>\
                        <option>3.00 am</option>\
                        <option>4.00 am</option>\
                        <option>5.00 am</option>\
                        <option>6.00 am</option>\
                        <option>7.00 am</option>\
                        <option>8.00 am</option>\
                        <option>9.00 am</option>\
                        <option>10.00 am</option>\
                        <option>11.00 am</option>\
                        <option>12.00 pm</option>\
                        <option>1.00 pm</option>\
                        <option>2.00 pm</option>\
                        <option>3.00 pm</option>\
                        <option>4.00 pm</option>\
                        <option>5.00 pm</option>\
                        <option>6.00 pm</option>\
                        <option>7.00 pm</option>\
                        <option>8.00 pm</option>\
                        <option>9.00 pm</option>\
                        <option>10.00 pm</option>\
                        <option>11.00 pm</option>\
                    </select>\
                </div>\
            </div>\
            <div class="col-md-6">\
                <div class="form-group">\
                <select name="end[]" id="" class="form-control">\
                    <option>12.00 am</option>\
                    <option>1.00 am</option>\
                    <option>2.00 am</option>\
                    <option>3.00 am</option>\
                    <option>4.00 am</option>\
                    <option>5.00 am</option>\
                    <option>6.00 am</option>\
                    <option>7.00 am</option>\
                    <option>8.00 am</option>\
                    <option>9.00 am</option>\
                    <option>10.00 am</option>\
                    <option>11.00 am</option>\
                    <option>12.00 pm</option>\
                    <option>1.00 pm</option>\
                    <option>2.00 pm</option>\
                    <option>3.00 pm</option>\
                    <option>4.00 pm</option>\
                    <option>5.00 pm</option>\
                    <option>6.00 pm</option>\
                    <option>7.00 pm</option>\
                    <option>8.00 pm</option>\
                    <option>9.00 pm</option>\
                    <option>10.00 pm</option>\
                    <option>11.00 pm</option>\
                </select>\
                </div>\
            </div>');
    }
</script>
<?php require APPROOT .'/views/inc_doctor/footer.php'; ?>