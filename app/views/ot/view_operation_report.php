<?php require APPROOT .'/views/inc_ot/header.php'; ?>

<?php
        foreach ($data['logo'] as $key2)
        {
            $logo = $key2->client_logo;
            $client_name = $key2->client_name;
            $client_add = $key2->client_address;
            $client_email = $key2->client_email;
            $client_phone = $key2->client_phone;
        } 

       

?>
<div class="wraper container-fluid" >
                <div class="page-title"> 
                    <center><h3 class="title"><b>Operation Report</b></h3></center>
                </div>

                <div class="row" >
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <!-- <div class="panel-heading">
                                <h4>Invoice</h4>
                            </div> -->

                            <div class="panel-body">

                                <div class="clearfix">
                                    <div class="pull-left">
                                        <?php
                                        if($logo)
                                        {
                                            ?>
                                            <h4 class="text-right"><img width="100" height="100" src="<?php echo URLROOT;?>/service_detail/<?php echo $logo;?>" alt="velonic"></h4>
                                            <?php
                                        }
                                        else
                                        {
                                        ?>
                                            <h4 class="text-right"><img src="<?php echo URLROOT;?>/img/logo.png" alt="velonic"></h4>
                                    <?php } ?>
                                    </div>
                                    <div class="pull-left" style="padding-left: 10px;">
                                        <h3 class=""><?php echo $client_name; ?></h3>
                                        <h5><?php echo $client_add;?></h5>
                                        <h5><?php echo $client_email;?> | <?php echo $client_phone;?></h5>
                                    </div>
                                    <div class="pull-right">
                                        <h4>Report #<br>
                                            <strong><?php echo $data['ot_id'];?></strong>
                                        </h4>
                                    </div>
                                </div>

                                <hr/>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="pull-left m-t-30">
                                            <address>
                                              <strong>Patient Name: </strong><?php echo ucwords($data['patient_name']);?><br>
                                              <strong>Patient ID: </strong><?php echo $data['patient_id'];?><br>
                                            
                                              <strong>Age: </strong>
                                             <?php if(empty($data['patient_age']))
                                    { echo date('Y') - date('Y',strtotime($data['patient_dob']));
                                    } else echo $data['patient_age']; ?>
                                              <br>
                                              <strong>Refered Doctor Name: </strong>Dr <?php echo ucwords($data['mem_name']);?><br>
                                              <!-- 795 Folsom Ave, Suite 600<br>
                                              San Francisco, CA 94107<br>
                                              <abbr title="Phone">P:</abbr> (123) 456-7890 -->
                                              </address>
                                        </div>
                                        <div class="pull-right m-t-30">
                                            <p><strong>Operation Date: </strong><?php echo  date('d-m-Y h:i A',strtotime($data['ot_date']));?></p>
                                            <p><strong>Admit Date and Time: </strong>
            <?php echo date('d-m-Y h:i A',strtotime($data['admission_date_time'])); ?></p>
                                            <!-- <p class="m-t-10"><strong>Order Status: </strong> <span class="label label-warning">Pending</span></p>
                                            <p class="m-t-10"><strong>Order ID: </strong> #123456</p> -->
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table m-t-30">
                                                <thead>
                                                    <tr><th>#</th>
                                                    <th style="text-align: left;padding-left: 100px;">Operation Name</th>
                                                    <th>Instructed services</th>
                                                
                                                </tr></thead>
                                                <tbody>
                                                 
                                                    <tr>
                                                        <td><?php echo $data['ot_id'];?></td>
                                                        <td style="text-align: left; padding-left: 100px;"><?php echo $data['ot_name'];?></td>
                                                        <td><?php echo $data['ot_description'];?></td>
                                                      
                                                    </tr>
                                                
                                                </tbody>
                                                
                                            </table>
                                        </div>
                                    </div>
                                </div>
                              
                               
                                <hr>
                                <div class="hidden-print">
                                    <div class="pull-right">
                                        <a href="<?php echo URLROOT;?>/ot/print_operation_details/<?php echo $data['ot_id'];?>" class="btn btn-success">&nbsp;<i class="fa fa-print"></i> &nbsp;Print</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
   <?php require APPROOT .'/views/inc_ot/footer.php'; ?>
   