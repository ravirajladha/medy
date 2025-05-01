<?php require APPROOT .'/views/inc_ot/header.php'; ?>


<div class="wraper container-fluid">
                <div class="page-title"> 
                    <h3 class="title">Attending Operation</h3> 
                </div>

				<div class="row">
                    <!-- Basic example -->
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading"><h3 class="panel-title">Patient Details</h3></div>
                            <div class="panel-body">
                               <form method="post" id="myform" action="<?php echo URLROOT; ?>/ot/save_ed_op_update/<?php echo $data['ot_id']; ?>">
                                 <div class="col-md-3">
                                    <div class="form-group">
                                        <label >Patient</label>
                                        <input type="text" class="form-control"  placeholder="Patient" readonly="true" value="<?php if(isset($data['patient_name'])):  
                                        echo $data['patient_name']." (".$data['patient_id'].")"; endif; ?>">
                                    </div>
                                     <div class="form-group">
                                        <label >Patient Gender & Age</label>
                                    <input type="text" class="form-control"  placeholder="Patient Gender" readonly="true" value="<?php if(isset($data['patient_gender'])):  
                                        echo $data['patient_gender']; endif; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label >Patient Age</label>
                                        <input type="text" class="form-control"  placeholder="Patient Age" readonly="true" value="<?php 
                                        if(isset($data['patient_dob']) AND isset($data['patient_age'])):  
                                        {
                                            if(empty($date['patient_age']))
                                            {

                                                echo date('Y') - date('Y',strtotime($data['patient_dob']));
                                            }
                                           else 
                                           {
                                                echo $data['patient_age']; 
                                            }
                                        }
                                        endif; ?>">
                                    </div>
                                    <div class="form-group">

                                        <label for="">Operation date and time</label>
                                          <input type="datetime-local" id="btn3" name="op_date_time" class="form-control"   value="<?php echo date('Y-m-d',strtotime($data['ot_date'])); ?>T<?php echo date('h:i',strtotime($data['ot_date'])); ?>">
                                    </div>
                                  </div>
                                  <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Patient Admit Date and Time</label>
                                        <input type="text" class="form-control" id="" placeholder="Patient Admit Date and Time" readonly="true" value="<?php if(isset($data['admission_date_time'])):  
                                        echo date('d-m-Y h:i A',strtotime($data['admission_date_time'])); endif; ?>">
                                    </div>
                                     <div class="form-group">
                                        <label for="">Refered Doctor Name</label>
                                        <input type="text" class="form-control" id="" placeholder="Refered Doctor Name" readonly="true" value="<?php if(isset($data['mem_name'])):  
                                        echo $data['mem_name']; endif; ?>">
                                    </div>
                                     <div class="form-group">
                                        <label for="">Operation Name</label>
                                        <input type="text" class="form-control" id="" placeholder="Operation Name" readonly="true" value="<?php if(isset($data['ot_name'])):  
                                        echo $data['ot_name']; endif; ?>">
                                    </div>
                                     <div class="form-group">
                                        <label for="">Instructed date and time</label>
                                        <input type="text" class="form-control" id="" placeholder="Instructed date and time" value="<?php if(isset($data['created_at'])):  
                                        echo date('d-m-Y h:i A',strtotime($data['created_at'])); endif; ?>" readonly="true">
                                    </div>
                                  </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                      <label for="">Operation Description</label>
                                        <textarea class="form-control" rows="12" name="description" id="btn1"><?php if(isset($data['ot_description'])):  
                                        echo $data['ot_description']; endif; ?>
                                        </textarea>
                                    </div>
                                  </div>
                                  <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Operation Feedback</label>
                                        <textarea rows="12"  class="form-control" id="btn2" name="feedback"><?php if(isset($data['feedback'])):  
                                        echo $data['feedback']; endif; ?></textarea>

                                    </div>                                    
                                  </div>
                                    <table style="float: right;"><tr >
                                      <td style="padding-right: 5px;">
                                        <input type="submit" id="mybutton" name="save" class="btn btn-info " value="Save" />
                                       </td>
                                       <td>
                                      <input type="submit" name="saveupdate" class="btn btn-success " value="Save & Finish"  />
                                    </td>
                                    <td>
                                      &nbsp
                                       <a href="<?php echo URLROOT; ?>/ot/active_status_from_current_cancel/<?php echo $data['ot_id']; ?>" class="btn btn-warning "  >Cancel</a>
                                    </td>
                                  </tr></table>
                                </form>
                            </div><!-- panel-body -->
                        </div> <!-- panel -->
                    </div> <!-- col-->
                </div> <!-- End row -->

  

        <div class="row">
                    <!-- Basic example -->
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading"><h3 class="panel-title">Instruction Details</h3></div>
                            <div class="panel-body">
                               <form method="post"  action="<?php echo URLROOT; ?>/ot/update_service_row/<?php echo $data['ot_id']; ?>">
                                 <div class="col-md-12">
                                  
                                  <div class="table-responsive">
                                            <table class="table" >
                                                <thead>
                                                  <tr>
                                                <th>Service</th>
                                                 <th>Cost</th>
                                                 <th>Action</th>
                                                    </tr>
                                                </thead>
                                  <tbody id="stock_all" >
                                    <tr>
                                    <td> <div class="form-group">

                                      <input type="text" name="services" class="form-control" placeholder="                                              Enter New Service" /> </div></td>
                                    <td><div class="form-group">
                                      <input type="text" name="cost" class="form-control" placeholder="                                                Enter Service Cost" /> </div></td>
                                    
                                    <td><div class="form-group">
                                      <input type="submit" name="send" class="btn btn-info" value="&nbsp Add &nbsp" >
                                    </div></td>


                                    

                                  </tr>  
                                  <?php
                                  foreach ($data['serv'] as $k) 
                                  {?>
                                    <tr>
                                      <td><?php echo $k->services; ?></td>
                                      <td><?php echo  $k->price; ?></td>
                                      <td></td>
                                    </tr>
                                  <?php
                                  }
                                  ?>     
                                                      
                                  </tbody>
                                  </table>  
                                  </div>
                             </form>
                            </div><!-- panel-body -->
                        </div> <!-- panel -->
                    </div> <!-- col-->
                </div> <!-- End row -->
                
            </div>  



<!-- <table id="myTable">
                                    <tr>
                                      <td><input type="text" placeholder="sn" /></td>
                                    </tr>
                                  </table>

                                  <br>

                                  <button type="button" onclick="myFunction()">Try it</button> 
<script>
function myFunction() {
  var table = document.getElementById("myTable");
  var row = table.insertRow(0);
  var cell1 = row.insertCell(0);
  cell1.innerHTML = "<input type='text'/>";
}
</script>-->

<script>

$(function() {

    var form_original_data = $("#myform").serialize(); 

    $("#mybutton").click(function() {
        if ($("#myform").serialize() != form_original_data) {
          // alert("form data changes save before click out side");
        }

    });

});

</script>
<script>
$(document).ready(function(){
  $("#btn1").keydown(function(){
//    $("#btn1").css("background-color", "yellow");
  
 if(a==1){
  alert("Content is changed please save before go back. Thank you");
 a++;
 }
  });
  
});
</script>
<script>
$(document).ready(function(){
  var b = 0;
  $("#btn2").keydown(function(){
//    $("#btn1").css("background-color", "yellow");
  
 if(b==0){
   alert("Content is changed please save before go back. Thank you");
 b++;
 }
  });
  
});
</script>
<script>
$(document).ready(function(){
  var c =0;
  $("#btn3").keydown(function(){
//    $("#btn1").css("background-color", "yellow");
  
 if(c==0){
   alert("Content is changed please save before go back. Thank you");
 c++;
 }
  });
  
});
</script>




   


<?php require APPROOT .'/views/inc_ot/footer.php'; ?>



