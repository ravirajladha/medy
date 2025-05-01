<?php require APPROOT .'/views/inc_ot_room/header.php'; ?>
<div class="wraper container-fluid">
                <div class="page-title"> 
                    <h3 class="title">Create Room</h3> 
                </div>

                <div class="row">
                    <!-- Basic example -->
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading"><h3 class="panel-title">Patient and Operation Details</h3></div>
                            <div class="panel-body">
                               <form method="post" id="myform" action="<?php echo URLROOT; ?>/ot_room/create_rooms/">
                                 <div class="col-md-4">
                                    <div class="form-group">
                                        <label >Room No</label>
                                        <input type="text" class="form-control" name="room_no" placeholder="Enter Room No"  required="true">
                                        <span style="color: red;"><?php if(!empty($data['room_no_err'])){ echo $data['room_no_err'];}?></span>
                                    </div>
                                    <div class="form-group">
                                        <label >Room Type</label>
                                    <!-- <input type="text" class="form-control" name="room_type"  placeholder="Enter Room Type"  > -->
                                        <select class="form-control" name="room_type">
                                          <option value="general" >General</option>
                                          <option value="semi_special" >Semi Special</option>
                                          <option value="special" >Special</option>
                                          <option value="icu" >ICU</option>
                                          <option value="operation" >Operation</option>
                                          <option value="other" >Other</option>
                                        </select>
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                      <div class="form-group">
                                          <label >Floor No</label>
                                          <input type="text" class="form-control" name="floor_no" placeholder="Enter Floor No"  >
                                      </div>
                                      <div class="form-group">
                                          <label >Building No</label>
                                          <input type="text" class="form-control" name="building_no" placeholder="Enter Building No"  >
                                      </div>
                                  </div>
                                 <div class="col-md-4">
                                      <div class="form-group">
                                         <label >Address</label>
                                         <input type="text" class="form-control" name="address" placeholder="Enter Address"  >
                                      </div>
                                      <div class="form-group">
                                        <br>
                                           <table style="float: right;"><tr >
                                            <td style="padding-right: 2px;padding-top: 5px;">
                                              <input type="submit"  name="save" class="btn btn-info " value="ADD" />
                                             </td>
                                            </tr>
                                           </table>
                                      </div>
                                  </div>
                                  
                                   
                                </form>
                            </div><!-- panel-body -->
                        </div> <!-- panel -->
                    </div> <!-- col-->
                </div> <!-- End row -->
            </div>

<?php require APPROOT .'/views/inc_ot_room/footer.php'; ?>