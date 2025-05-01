<?php require APPROOT .'/views/inc_ot/header.php'; ?>
<?php 
$ro=new Ot;
?>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Current Operation Details</h3></div>
            <div class="row">
             </div>
             <br>
              <div class="row">
                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table" >
                                                <thead>
                                                    <tr>
 
                                                <th>Patient</th>
                                                 <th>Patient Gender</th>
                                                 <th>Patient Age</th>
                                                 <th>Patient Admit Date & Time</th>
                                                 <th>Refered Doctor Name</th>
                                                 <th>Operation Name</th>
                                                 <th>Operation description</th>
                                                 <th>Operation date and time</th>
                                                 <th>Instructed date and time</th>
                                                 <th>Room No</th>
                                                 <th colspan=3>Actions</th>
                                                    </tr>
                                                </thead>
            <tbody id="stock_all" >
                 <?php foreach ($data['ot'] as $key) { 
                    if($key->status == '0')
                    { ?>
                 <tr>
                 	<td><?php echo ucwords($key->patient_name)."&nbsp<small>(".$key->patient_id.")</small>" ; ?></td>
					<td><?php echo $key->patient_gender; ?></td>
					<td><?php if(empty($key->patient_age))
					{ echo date('Y') - date('Y',strtotime($key->patient_dob));
					} else echo $key->patient_age; ?></td>
				
					<td><?php echo date('d-m-Y h:i A',strtotime($key->admission_date_time)); ?></td>
					<td><?php echo $key->mem_name; ?></td>
					<td><?php echo $key->ot_name; ?></td>
					<td><?php echo $key->ot_description; ?></td>
					<td><?php echo date('d-m-Y h:i A',strtotime($key->ot_date));?></td>
					<td>
                        <?php echo date('d-m-Y h:i A',strtotime($key->created_at)) ; ?></td>
                    <?php 
                    if($key->room_ref_id == 0)
                    {
                        $room_name = 0;
                    }
                    else
                    {
                        $room_name = $ro->getRoomName($key->room_ref_id);
                    }
                    ?>
                    <td>( <?php  echo $room_name; ?> ) 
                    <?php if(empty($room_name)){ ?>
                        <a href="" data-toggle="modal" data-target="#myModal<?php echo $key->ot_id; ?>"><span class="glyphicon glyphicon-pencil"> </span></a>
                    <?php } else {?>
                         <a href="<?php echo URLROOT;?>/ot/room_cancel_status/<?php echo $key->ot_id; ?>" class="ion-close-round"></a> 

                    <?php } ?>
                    </td>





                    <td><a href="<?php echo URLROOT;?>/ot/active_status_from_current/<?php echo $key->ot_id; ?>" class="btn btn-info btn-xs m-b-5"> Attend</a>
                    <a href="<?php echo URLROOT;?>/ot/active_status_from_current_cancel/<?php echo $key->ot_id; ?>" class="btn btn-warning btn-xs m-b-5"> Cancel</a>
                    <a href="<?php echo URLROOT;?>/ot/teamAssign/<?php echo $key->ot_id; ?>" class="btn btn-pink btn-xs m-b-5">Assign Team</a>
                    <a href="<?php echo URLROOT;?>/ot/viewTeam/<?php echo $key->ot_id; ?>" class="btn btn-purple btn-xs m-b-5">View Team</a>
                    </td>
                 </tr>

                    <!-- Modal -->
                      <div class="modal fade" id="myModal<?php echo $key->ot_id; ?>" role="dialog">
                        <div class="modal-dialog">
                        
                          <!-- Modal content-->
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title" style="text-align: center;">Available Rooms For Operation</h4>
                            </div>
                            <div class="modal-body">
                                
                                <form method="post" action="<?php echo URLROOT;?>/ot/current_room_update/<?php echo $key->ot_id; ?>">           
                                         <select class="form-control" name="room_id" >   

                                        <?php foreach ($data['room'] as $key) 
                                        { 
                                            if($key->status == '0' AND $key->room_type == 'operation')
                                            { ?>
                                          <option value="<?php echo $key->id;?>">Room No: <?php echo $key->room_no;?></option>
                                         <?php } } ?> 
                                         </select>     
                                         <br>
                                         <button type="submit" class="btn btn-primary" style="float: right;">Select</button>
                                         <br>
                                         <br>  

                                </form>             
                                

                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                          </div>
                          
                        </div>
                      </div>

                 <?php } } ?>	
            </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>   

<?php require APPROOT .'/views/inc_ot/footer.php'; ?>


  
  

