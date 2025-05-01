<?php require APPROOT .'/views/inc_ot_room/header.php'; ?>
<style type="text/css">
    .ee1{
        padding: 5px;
    }
    .ee1:hover{
        background-color: lightgray;
    }

    #list1
    {
    max-height: 400px;
    max-width: 237px;
    min-width: 237px;
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
<div class="wraper container-fluid">
    <div class="page-title"> 
        <h3 class="title">Bookings</h3> 
    </div>
    <div class="row">
    <!-- Basic example -->
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <form role="form" action="<?php echo URLROOT; ?>/ot_room/bookRoom" method="POST">
                	<div class="row">
                		<div class="col-md-3">
                			<div class="form-group">
		                        <label for="exampleInputEmail1">Room Number</label>
		                        <input type="text" class="form-control" id="roomNumber" placeholder="Enter Room Number" name="roomNumber">
		                        <div id="list1"></div>
		                    </div>
                		</div>
                		<div class="col-md-3">
                			<div class="form-group">
		                        <label for="exampleInputEmail1">Select Bed</label>
		                        <select class="form-control" name="bedId" id="selectId">
		                        	
		                        </select>
		                    </div>
                		</div>
                		<div class="col-md-3">
                			<div class="form-group">
                				<label>From Date</label>
                				<input type="date" name="fromDate" class="form-control">
                			</div>
                		</div>
                		<div class="col-md-3">
                			<div class="form-group">
                				<label>To Date</label>
                				<input type="date" name="toDate" class="form-control">
                			</div>
                		</div>
                	</div>
                    <button type="submit" class="btn btn-info">Book</button>
                </form>
            </div><!-- panel-body -->
        </div> <!-- panel -->
    </div> <!-- col-->
</div>

<?php require APPROOT .'/views/inc_ot_room/footer.php'; ?>

<script type="text/javascript">
    $(document).ready(function(){
      $('#roomNumber').keyup(function(){
        var query3 = $(this).val();
        if(query3!=0)
        {
          $.ajax({
            url:'<?php echo URLROOT;?>/ot_room/getRooms',
            type:'POST',
            data:{query3:query3},
            success:function(data)
            {

              $('#list1').fadeIn();
              $('#list1').html(data);
            }
          });
        }
        else
        { 
           $('#list1').fadeOut();
        }
      });
       $(document).on('click', '.ee1', function(){

           var id = $(this).text();
           $('#roomNumber').val(id);
           $('#list1').fadeOut();

           $.ajax({
            url : '<?php echo URLROOT; ?>/ot_room/getTheRoomId',
            type : 'POST',
            data : {id},
            success : function(res)
            {
                $('#selectId').html(res);
            }
           });
      });
       
      $(document).click(function (event){
        $('#list1').fadeOut(); 
      }); 
    });
  </script>
