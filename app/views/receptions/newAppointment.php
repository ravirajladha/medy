<?php require APPROOT .'/views/inc_reception/header.php'; ?>
<style type="text/css">
	.ee
    {
		padding: 5px;
	}
	.ee:hover
    {
		background-color: lightgray;
	}
	.ee1
    {
		padding: 5px;
	}
	.ee1:hover
    {
		background-color: lightgray;
	}
	.ee32
    {
		padding: 5px;
	}
	.ee32:hover
    {
		background-color: lightgray;
	}

	#list
	{
        max-height: 400px;
        max-width: 415px;
        min-width: 415px;
        position: absolute;
        background-color: white;
        border: solid;
        border-width: 1px;
        border-color: lightgray;
        font-size: 13px;
        cursor: pointer;
        z-index: 50;
        text-align: left;
        display: none;
	}
</style>
<div class="col-md-12"><br>
<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-heading"><h3 class="panel-title">New Appointment</h3></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-5 p-5" style="padding-top:10px!important;">
                    <form action="<?php echo URLROOT; ?>/receptions/bookAppointment" method="POST">
                    <div class="login-wrapper" style="padding-top:0px!important;">
                        <p style="margin-bottom: 0px;"><b>Have registered Patient ID ?</b></p>
                        <span>
                            <input id="reg" type="checkbox" checked onchange="displayReg()" name="type" value="1"> Yes
                            <input id="nonReg" type="checkbox" onchange="displayNonReg()" name="type" value="2"> No 
                        </span>
                        <input name="hos_id" id="name" type="hidden" class="form-control" placeholder="Medhike Id" required="" value="mh1">
                            <div class="form-group" id="regDiv">
                            <label for="email">Patient ID</label>
                            <input type="text" name="patientIdName" class="form-control patient_search" placeholder="Enter Patient ID">
                            <input type="hidden" id="id_id" name="patientId">
                            <div id="list"></div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 nonRegDiv"  style="display: none;">
                                    <label for="email">Name</label>
                                    <input type="text" name="patientName" id="email" class="form-control" placeholder="Enter Patient Name">
                                </div>
                                <div class="col-md-6 nonRegDiv"  style="display: none;">
                                    <label for="email">Phone Number</label>
                                    <input type="text" name="phoneNumberWithout" id="email" class="form-control" placeholder="eg - 9876543210">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email">Doctor Speciality</label>
                                <select class="form-control" onchange="getDoctors(this.value)" name="docSpec" required>
                                    <option>-- select --</option>
                                    <?php
                                        foreach ($data['specialty'] as $key) 
                                        {
                                            echo "<option value='".$key->doctor_speciality."'>".$key->doctor_speciality."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="email">Name</label>
                                    <select id="doctorDisplay" class="form-control" name="docName" required>
                                        
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="email">Date</label>
                                    <input type="datetime-local" name="appoint_date" id="email" class="form-control" required="">
                                </div>
                            </div>
                            <br>
                            <!-- <input name="login" id="login" class="btn btn-block login-btn" type="submit" value="Book Appointment" style="background-color: #01358D"> -->
                            <button type="submit" class="btn btn-block btn--md btn-info">Book Appointment</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 

<?php require APPROOT .'/views/inc_reception/footer.php';?>
<?php
    if(isset($_SESSION['appStatus']))
    {
        echo "<script>swal('Appointment created');</script>";
    }
    unset($_SESSION['appStatus']);
?>
<?php
    if(isset($_SESSION['fillAll']))
    {
        echo "<script>swal('Enter all required fields');</script>";
    }
?>
<script>
    function getDoctors(spec)
    {
        $.ajax({
            url: "<?php echo URLROOT; ?>/appointment/getTheDoctorBySpecialty",
            type: "POST",
            data: {spec},

            success: function(response)
            {
                $('#doctorDisplay').html(response);
            }
        });
    }

    function displayReg()
    {
        $('#nonReg').prop('checked', false);
        $('.nonRegDiv').css('display', 'none');
        $('#regDiv').css('display', 'block');
    }

    function displayNonReg()
    {
        $('#reg').prop('checked', false);
        $('.nonRegDiv').css('display', 'block');
        $('#regDiv').css('display', 'none');
    }

</script>

<script type="text/javascript">
    $(document).ready(function(){
      $('.patient_search').keyup(function(){
        var query3 = $(this).val();
        if(query3!=0)
        {
          $.ajax({
            url:'<?php echo URLROOT;?>/receptions/get_auto_patient_name2',
            type:'POST',
            data:{query3:query3},
            success:function(data)
            {
              $('#list').fadeIn();
              $('#list').html(data);
            }
          });
        }
        else
        {
           $('#list').fadeOut();
        }
      });
       $(document).on('click', '.ee', function(){
       	   var id = $(this).text();
       	   var res = id.split("(",2);
       	   var res1 = res[0].trim();
           var res2 = res[1].split(")",2);
       	   var res2 = res2[0].trim();
           $('.patient_search').val(res1);
           $('#id_id').val(res2);
           $('#list').fadeOut();
      });
       
      $(document).click(function (event){
        $('#list').fadeOut(); 
      }); 
    });
  </script>
