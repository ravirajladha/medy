<?php require APPROOT .'/views/inc_nurse/header.php'; ?>

<?php
    if(!isset($_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']) AND $_SESSION['type'] != 'rec')
    {
        redirect('users/login');
    }
?>
<?php
	foreach ($data['mem_data'] as $key)
	{
		$id = $key->mem_id;
		$name = $key->mem_name;
		$type = $key->mem_type;
		$phone = $key->mem_phone;
		$email = $key->mem_email;
		$photo = $key->mem_photo;
	}
?>
<?php if (isset($data['pass_err']))
{
	if($data['pass_err'] == 1)
	{
		echo '<script>swal("Password Doesnt Match!", "Re-enter your password", "error");</script>';	
	}

	elseif($data['pass_err'] == 2)
	{
		echo '<script>swal("Updated!", "Your Details Updated Successfully.", "success");</script>';
	}
	else
	{
		echo '<script>swal("Error!", "", "Somethingn Went Wrong.");</script>';	
	}
	
} 
?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Settings</h3></div>
                <div class="panel-body">
                <form action="<?php echo URLROOT;?>/nurses/update_password" method="POST" enctype="multipart/form-data">
				<div class="row">
					<div class="col-md-3">
						<input type="number" name="id" value="<?php echo $id;?>" style="display: none;">
		                <div class="form-group">
							<label for="exampleInputEmail1">Name</label>
		                    <input style="margin-top: 10px;" type="text" class="form-control" id="" required="" placeholder="Enter Doctor Name / ID" disabled="" value="<?php echo $name;?>">
				    	</div>
					</div>
					<div class="col-md-3">
		                <div class="form-group">
							<label for="exampleInputEmail1">Type</label>
		                    <input style="margin-top: 10px;" type="text" class="form-control" id="" required="" placeholder="Enter Doctor Name / ID" disabled="" value="<?php echo $type;?>">
				        </div>
				    </div>
			    	<div class="col-md-3">
		                <div class="form-group">
							<label for="exampleInputEmail1">Phone</label>
		                    <input style="margin-top: 10px;" type="number" required="" class="form-control" id="" placeholder="Enter Phone" disabled="" value="<?php echo $phone?>">
				    	</div>
					</div>
					<div class="col-md-3">
		                <div class="form-group">
							<label for="exampleInputEmail1">Email</label>
		                    <input style="margin-top: 10px;" type="email" required="" class="form-control" id="" placeholder="Enter Email" disabled="" value="<?php echo $email;?>">
				    	</div>
					</div>
					<div class="col-md-3">
		                <div class="form-group">

							<label for="exampleInputEmail1">Password</label>
								<table><tr><td >
		                    <input style="margin-top: 10px;margin-right: 40px;" type="Password" required="" class="form-control" name="pass" placeholder="Enter Password" id="myInput" >
		                </td><td >

		                 <span class="form-control col-md-6" onclick="myFunction()" style="margin-top: 10px;" id="show"><i class="fa fa-eye"></i></span>

		                  <span class="form-control col-md-6" onclick="myFunction()" style="margin-top: 10px; display: none;" id="show1"><i class="fa fa-eye-slash"></i></span>
		             	</td></tr></table>
				    	</div>
	
<!-- <div class="form-group">
    <input  type="password" name="user_password" id="user_password" class="form-control" id="user_password" data-toggle="password">
      <span class="input-group-text col-md-6"><i class="fa fa-eye"></i></span>
  </div> -->
				    	
				    	
					</div>
					<!-- <div class="col-md-3">
				    	 <div class="form-group">

							<label for="exampleInputEmail1">Confirm Password</label>
								<table><tr><td >
									
		                    <input style="margin-top: 10px;margin-right: 40px;" type="Password" required="" class="form-control" name="cpass" placeholder="Enter Confirm Password" id="myInput1" >
		                </td><td >

		                 <span class="form-control col-md-6" onclick="myFunction1()" style="margin-top: 10px;" id="show2"><i class="fa fa-eye"></i></span>

		                  <span class="form-control col-md-6" onclick="myFunction1()" style="margin-top: 10px; display: none;" id="show22"><i class="fa fa-eye-slash"></i></span>
		             	</td></tr></table>
				    	</div>
					</div>  -->
					<div class="col-md-3">
		                <div class="form-group">
							<label for="exampleInputEmail1">Change Profile Image</label>
		                    <input style="margin-top: 10px;" type="file" name="files" required="" class="form-control">
				    	</div>
					</div>
					
					
						<div class="col-md-3">
						<button style="margin-top: 35px" type="submit" class="btn btn-info w-md m-b-5">Update Changes</button>
					</div>
					</div>
					</form>
				</div>
		</div>
	</div>
</div>
</div> 	

<?php require APPROOT .'/views/inc_nurse/footer.php';?>
<!-- <script type="text/javascript">
	$(document).ready(function(){
		$("#update_pass").click(function(){
			var pass = $("#pass").val();
			var cpass = $("#cpass").val();
			var id = <?php echo $id;?>;
			if(pass == cpass)
			{
				$.ajax({
					url:'<?php echo URLROOT;?>/receptions/update_password',
					type:'POST',
					data:{id,cpass},
					success : function(data)
					{
						alert(data);
						window.location.reload();
					}
				});
			}
			else
			{
				alert('Password does not match');
			}
		});
	});
</script> -->
<script type="text/javascript">
	function myFunction() {
  var x = document.getElementById("myInput");
  if (x.type === "password") {
    x.type = "text";
    document.getElementById("show1").style.display="block";
     document.getElementById("show").style.display="none";

  } else {
    x.type = "password";
     document.getElementById("show1").style.display="none";
     document.getElementById("show").style.display="block";
  }
}
</script>

<script type="text/javascript">
	function myFunction1() {
  var x = document.getElementById("myInput1");
  if (x.type === "password") {
    x.type = "text";
    document.getElementById("show22").style.display="block";
     document.getElementById("show2").style.display="none";

  } else {
    x.type = "password";
     document.getElementById("show22").style.display="none";
     document.getElementById("show2").style.display="block";
  }
}
</script>

<script>
    // tell the embed parent frame the height of the content
    if (window.parent && window.parent.parent){
      window.parent.parent.postMessage(["resultsFrame", {
        height: document.body.getBoundingClientRect().height,
        slug: "zkou4dej"
      }], "*")
    }

    // always overwrite window.name, in case users try to set it manually
    window.name = "result"
  </script>
  <script type="text/javascript">//<![CDATA[

    window.onload=function(){
      
/**
 * @author Abdo-Hamoud <abdo.host@gmail.com>
 * https://github.com/Abdo-Hamoud/bootstrap-show-password
 * version: 1.0
 */

!function(a){a(function(){a('[data-toggle="password"]').each(function(){var b = a(this); var c = a(this).parent().find(".input-group-text"); c.css("cursor", "pointer").addClass("input-password-hide"); c.on("click", function(){if (c.hasClass("input-password-hide")){c.removeClass("input-password-hide").addClass("input-password-show"); c.find(".fa").removeClass("fa-eye").addClass("fa-eye-slash"); b.attr("type", "text")} else{c.removeClass("input-password-show").addClass("input-password-hide"); c.find(".fa").removeClass("fa-eye-slash").addClass("fa-eye"); b.attr("type", "password")}})})})}(window.jQuery);


    }

  //]]></script>
