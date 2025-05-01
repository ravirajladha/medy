<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Login - Med Hike</title>
  <link href="https://fonts.googleapis.com/css?family=Karla:400,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.8.95/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/login.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link rel="shortcut icon" type="image/x-icon" href="<?php echo URLROOT; ?>/assets/images/favicon.png" />
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body>
  <main>
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-7 px-0 d-none d-sm-block">
        <?php if($data['loginPage']->login_photo == NULL) { ?>  
            <img src="" alt="login image" class="login-img" style="text-align: center !important;">
        <?php } else { ?>
            <img src="" alt="login image" class="login-img" style="text-align: center !important;">
        <?php } ?>
        </div>
        <div class="col-sm-5 p-5" style="padding-top:10px!important;">
          <div class="brand-wrapper" style="text-align: center">
            <img src="" alt="logo" class="logo">
          </div>
          <form action="<?php echo URLROOT; ?>/appointment/bookAppointment" method="POST">
          <div class="login-wrapper" style="padding-top:0px!important;">
              <h1 class="login-title" style="text-align: center">Demo( Hospital Name )</h1>
              <p style="margin-bottom: 0px;"><b>Have registered Patient ID ?</b></p>
              <span>
                    <input id="reg" type="checkbox" checked onchange="displayReg()"> Yes
                    <input id="nonReg" type="checkbox" onchange="displayNonReg()"> No 
            </span>
            <br>
            <br>
            <input name="hos_id" id="name" type="hidden" class="form-control" placeholder="Medhike Id" required="" value="mh1">
              <div class="form-group" id="regDiv">
                <label for="email">Patient ID</label>
                <input type="text" name="patientId" id="email" class="form-control" placeholder="Enter Patient ID">
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
              <br>
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
                <div class="col-md-7">
                    <label for="email">Name</label>
                    <select id="doctorDisplay" class="form-control" name="docName" required>
                        
                    </select>
                </div>
                <div class="col-md-5">
                    <label for="email">Date</label>
                    <input type="date" name="date" id="email" class="form-control" required="" min="<?php echo date('Y-m-d'); ?>">
                </div>
              </div>
              <br>
              <input name="login" id="login" class="btn btn-block login-btn" type="submit" value="Book Appointment" style="background-color: #01358D">
                <div class="row">
                    <div class="col-md-6 col-xs-12" style="text-align:center;">
                        support@medhike.com
                    </div>
                    <div class="col-md-6 col-xs-12" style="text-align:center;">
                        +91 80 80 287 287
                    </div>
                </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </main>
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
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>

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



