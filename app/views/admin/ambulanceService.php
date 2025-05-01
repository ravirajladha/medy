<?php require APPROOT .'/views/inc_admin/header.php';?>
<style>
    #list3{
        max-height: 100px;
        max-width: 252px;
        min-width: 252px;
        position: absolute;
        overflow-y: auto;
        overflow-x: hidden;
        background-color: white;
        border: solid;
        border-width: 1px;
        border-color: lightgray;
        font-size: 13px;
        cursor: pointer;
        text-align: left;
        z-index: 1;
      }
</style>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <a href="<?php echo URLROOT; ?>/admin/assignedAmbulance"><button class="btn btn-success btn-xs pull-right">Assigned Ambulance</button></a>
                <h3 class="panel-title">Assign Ambulance</h3>
            </div>
            <br>
            <form action="<?php echo URLROOT;?>/admin/assignAmbulance" method="POST">
            <div class="row">
                <center>
                    <div class="form-group">
                        <label class="cr-styled">
                            <input type="checkbox" checked="" id="int" onchange="changeInt()" name="int" value="1">
                            <i class="fa"></i> 
                            Internal
                        </label>
                        <label class="cr-styled">
                            <input type="checkbox" id="ext" onchange="changeExt()" name="ext" value="1">
                            <i class="fa"></i> 
                            External
                        </label>
                    </div>
                </center>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <label for="">Select Vehicle</label>
                    <select class="form-control" name="vehicleId">
                        <?php foreach($data['ambulances'] as $amb) { ?>
                        <option value="<?php echo $amb->vehicle_id; ?>"><?php echo ucwords($amb->vehicle_name);?> (<?php echo strtoupper($amb->vehicle_number); ?>)</option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-sm-3">
                    <label for="">Patient</label>
                    <input class="form-control" type="text" placeholder="Enter Patient Name" name="patient" id="cust">
                    <input class="form-control" type="text" placeholder="Enter Patient Name" name="patient" id="cust2" style="display: none;" disabled>
                    <div id="list3" style="display: none;"></div>
                </div>
                <div class="col-sm-3">
                    <label for="">Driver Name</label>
                    <input class="form-control" type="text" placeholder="Enter Driver Name" name="driver">
                </div>
                <div class="col-sm-3">
                    <label for="">Initial Reading Kilometer</label>
                    <input class="form-control" type="text" placeholder="Enter KM" name="irk">
                </div>
                <div class="col-sm-3" style="margin-top: 20px;">
                    <label for="">Patient Condition</label>
                    <input class="form-control" type="text" placeholder="Patient Condition" name="condition">
                </div>
                <div class="col-sm-3" style="margin-top: 20px;">
                    <label for="">From Time</label>
                    <input class="form-control" type="time" placeholder="Patient Condition" name="fromTime">
                </div>
                <div class="col-sm-6" style="margin-top: 20px;">
                    <label for="">Remarks</label>
                    <input class="form-control" type="text" placeholder="Enter Remarks" name="remarks">
                </div>
                <div class="col-sm-8" style="margin-top: 20px;">
                    <label for="">Address</label>
                    <input class="form-control" type="text" placeholder="Enter Address" name="address">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-3">
                    <button class="btn btn-info btn-md" type="submit">Assign</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
<?php require APPROOT .'/views/inc_admin/footer.php';?>

<script>
    function changeExt()
    {
        $('#int').prop("checked", false);
        $('#cust').css('display','none');
        $('#cust').attr('disabled', true);
        $('#cust2').attr('disabled', false);
        $('#cust2').css('display','block');
    }

    function changeInt()
    {
        $('#ext').prop("checked", false);
        $('#cust2').css('display','none');
        $('#cust').css('display','block');
        $('#cust2').attr('disabled', true);
        $('#cust').attr('disabled', false);
    }
</script>
<script type="text/javascript">
     $(document).ready(function(){
      $('#cust').keyup(function(){
        var query3 = $(this).val();
        if(query3!=0)
        {
          $.ajax({
            url:'<?php echo URLROOT;?>/receptions/get_auto_patient_name',
            type:'POST',
            data:{query3:query3}, 
            success:function(data)
            {
              $('#list3').fadeIn();
              $('#list3').html(data);
            }
          });
        }
        else
        {
          $('#list3').fadeOut();
        }
      });
       $(document).on('click', '.ee', function(){  
           $('#cust').val($(this).text());  
           $('#list3').fadeOut();  
      });
      $(document).click(function (event){
        $('#list3').fadeOut(); 
      });  
    });
</script>