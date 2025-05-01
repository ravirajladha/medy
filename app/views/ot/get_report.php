<?php require APPROOT .'/views/inc_ot/header.php'; ?>
<div class="panel panel-default">
	<div class="row">
		<div class="col-md-12">
			<div>
      <br><br>        
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Patient</th>
                                    <th>Patient Gender</th>
                                    <th>Patient Age</th>
                                    <th>Patient Admit Date & Time</th>
                                    <th>Refered Doctor Name</th>
                                    <th>Operation Name</th>
                                    <th>Operation Date & Time</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data['pdata'] as $p) { ?> 
                                <tr>
                                    <td><?php echo $p->patient_name." (".$p->patient_id.")"; ?></td>
                                    <td><?php echo $p->patient_gender; ?></td>
                                    <td><?php if(empty($p->patient_age))
                                    { echo date('Y') - date('Y',strtotime($p->patient_dob));
                                    } else echo $p->patient_age; ?></td>
                                    <td><?php echo date('d-m-Y h:i A',strtotime($p->admission_date_time)); ?></td>
                                    <td><?php echo $p->mem_name; ?></td>
                                    <td><?php echo $p->ot_name; ?></td>
                                    <td><?php echo $p->ot_date; ?></td>
                                    <td>
                                        <?php if($p->status == '3') 
                                        { ?>
                                              <a href="<?php echo URLROOT; ?>/ot/print_operation_details/<?php echo $p->ot_id; ?>"><button style="width: 54px;" type="button" class="btn btn-success btn-xs m-b-5">Print</button></a>
                                              <a href="<?php echo URLROOT; ?>/ot/view_operation_report/<?php echo $p->ot_id; ?>"><button style="width: 54px;" type="button" class="btn btn-purple btn-xs m-b-5">View</button></a>
                                      <?php }
                                      elseif ($p->status == '4') 
                                      { ?>
                                                <a href="<?php echo URLROOT; ?>/ot/Canceled_operation"><button style="width: 64px;" type="button" class="btn btn-danger btn-xs m-b-5">Cancelled</button></a>

                                    <?php } 
                                    else
                                    { ?>
                                        <a href="<?php echo URLROOT; ?>/ot/index"><button style="width: 54px;" type="button" class="btn btn-info btn-xs m-b-5">Pending</button></a>
                                   <?php }
                                    
                                    ?></td>
                                </tr>
                                <?php }?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
		</div>
	</div>
</div>
<?php require APPROOT .'/views/inc_ot/footer.php'; ?>