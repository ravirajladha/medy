<?php require APPROOT .'/views/inc_reception/header.php'; ?>
<?php
    if(!isset($_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']) AND $_SESSION['type'] != 'rec')
    {
        redirect('users/login');
    }
?>

<div class="wraper container-fluid">
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
        <div class="panel-heading"><h3 class="panel-title">New Operation Services</h3></div>
            <div class="panel-body">
				<div class="row">
          <form method="post" action="<?php echo URLROOT;?>/receptions/add_operation_service">
					<div class="col-md-6">
		          <div class="form-group">
  							<label for="">Service Name </label>
                <input style="margin-top: 10px;" autocomplete="off" type="text" name="s_name" class="form-control " placeholder="Service Name" required="true">
	            
					    </div>
					</div>
					
					<div class="col-md-4">
			      <div class="form-group">
						  <label for="exampleInputEmail1">Service Cost</label>

			          <input style="margin-top: 10px;" type="number" class="form-control"  name="s_cost" placeholder="Service Cost" autocomplete="off" required="true">
						</div>
					</div>
					<div class="col-md-2">
			        <div class="form-group">
						   <button style="margin-top: 34px" type="submit" class="btn btn-info w-md m-b-5">Create Service</button>
						</div>
					</div>
          </form>
				</div>
			</div>
		</div>
	</div>

  <div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading"><h3 class="panel-title">Existing Operation Services</h3></div>
            <div class="panel-body">
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive" style="margin-top: -45px;">
              <table class="table m-t-30">
                  <thead>
                      <tr>
                          <th style="text-align: left;padding-left: 100px;">Service Name</th>
                          <th style="text-align: left;padding-left: 100px;">Service Cost</th>  
                          <th>Action</th>                  
                      </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($data['rows'] as $key ) { ?>
                          <tr>
                            <td style="text-align: left; padding-left: 100px;"><?php echo $key->name;?></td>
                            <td style="text-align: left; padding-left: 100px;"><?php echo $key->cost;?></td>
                            <td> <a href="<?php echo URLROOT;?>/receptions/delete_op_service/<?php echo $key->id;?>" ><i class="ion-close" style="color: orange;"></i></a> </td>
                          </tr>
                   <?php } 
                    ?>
                  </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>



</div>
</div>





<?php require APPROOT .'/views/inc_reception/footer.php';?>
