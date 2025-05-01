<?php require APPROOT .'/views/inc_ot/header.php'; ?>
<div class="wraper container-fluid">
                <div class="page-title"> 
                    <h3 class="title">New Operation</h3> 
                </div>

                <div class="row">
                    <!-- Basic example -->
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading"><h3 class="panel-title">Patient and Operation Details</h3></div>
                            <div class="panel-body">
                               <form method="post" id="myform" action="<?php echo URLROOT; ?>/ot/new_operation/">
                                 <div class="col-md-3">
                                    <div class="form-group">
                                        <label >Patient ID</label>
                                        <input type="text" class="form-control" name="patient_id"  placeholder="Enter Patient ID"  value="">
                                    </div>
                                    <div class="form-group">

                                        <label for="">Operation date and time</label>
                                          <input type="datetime-local" name="op_date_time" class="form-control">
                                    </div>
                                  </div>
                                  <div class="col-md-3">
                                     <div class="form-group">
                                        <label for="">Refered Doctor ID</label>
                                        <input type="text" class="form-control" name="r_doctor_id" placeholder="Refered Doctor ID" >
                                    </div>
                                     <div class="form-group">
                                        <label for="">Operation Name</label>
                                        <input type="text" class="form-control" name="op_name" placeholder="Enter Operation Name" >
                                    </div>
                                  </div>
                                 <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Operation Description</label>
                                        <textarea class="form-control" rows="4" name="description" >
                                        </textarea>
                                    </div>
                                  </div>
                                  
                                    <table style="float: right;"><tr >
                                      <td style="padding-right: 5px;">
                                        <input type="submit"  name="save" class="btn btn-info " value="ADD" />
                                       </td>
                                       
                                    
                                  </tr></table>
                                </form>
                            </div><!-- panel-body -->
                        </div> <!-- panel -->
                    </div> <!-- col-->
                </div> <!-- End row -->
            </div>

<?php require APPROOT .'/views/inc_ot/footer.php'; ?>