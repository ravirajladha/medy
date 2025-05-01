<?php require APPROOT .'/views/inc_ot/header.php'; ?>
<?php 
$ro=new Ot;
?>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Active Operation Details</h3></div>
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
                                                 <th>Instruction Details</th>
                                                 <th>Operation date and time</th>
                                                 <th>Instructed date and time</th>
                                                 <th>Room No</th>
                                                 <th colspan=3>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="stock_all" >
                                 <?php foreach ($data['ot'] as $key) { 
                                    if($key->status == '1' or $key->status == '2')
                                    { ?>
                                 <tr>
                                 	<td><?php echo ucwords($key->patient_name)."&nbsp<small>(".$key->patient_id.")</small>" ; ?></td>
									<td><?php echo $key->patient_gender; ?></td>
									<td>
                                        <?php if(empty($key->patient_age))
									{ echo date('Y') - date('Y',strtotime($key->patient_dob));
									} else echo $key->patient_age; ?>
                                    </td>
								
									<td><?php echo date('d-m-Y h:i A',strtotime($key->admission_date_time)); ?></td>
									<td><?php echo $key->mem_name; ?></td>
									<td><?php echo $key->ot_name; ?></td>
									<td><?php echo $key->ot_description; ?></td>
									<td><?php echo date('d-m-Y h:i A',strtotime($key->ot_date));?></td>
									<td><?php echo date('d-m-Y h:i A',strtotime($key->created_at)) ; ?></td>
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
                                                        <td>( <?php  echo $room_name; ?> )</td>
                                        <?php
                                        if($key->status == "2")
                                        { ?>
                                            <td><a href="<?php echo URLROOT;?>/ot/edit_operation/<?php echo $key->ot_id; ?>" class="btn btn-success btn-xs m-b-5"> 
                                            <?php
                                            echo "Saved operation";
                                        }else
                                        { ?>
                                            <td><a href="<?php echo URLROOT;?>/ot/edit_operation/<?php echo $key->ot_id; ?>" class="btn btn-info btn-xs m-b-5"> 
                                            <?php
                                             echo "Update Operation";
                                        }
                                        ?>
                                    </a> </td>

                                    <td>
                                    <a href="<?php echo URLROOT;?>/ot/active_status_from_current_cancel/<?php echo $key->ot_id; ?>" class="btn btn-warning btn-xs m-b-5"> Cancel</a>
                                    <a href="<?php echo URLROOT;?>/ot/viewTeam/<?php echo $key->ot_id; ?>" class="btn btn-purple btn-xs m-b-5">View Team</a>
                                    </td>
                                 </tr>
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