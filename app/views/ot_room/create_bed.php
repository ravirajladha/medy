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
        <h3 class="title">Create Bed</h3> 
    </div>
    <div class="col-md-12">
        <form action="<?php echo URLROOT; ?>/ot_room/createBed" method="POST">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                <div class="col-md-4">
                    <div class="form-group">    
                        <label>Bed ID</label>
                        <input type="text" name="bedID" class="form-control" required="">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">    
                        <label>Room Number</label>
                        <input type="text" name="roomNo" class="form-control" id="roomNumber" required="">
                        <div id="list1"></div>
                    </div>
                </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <button class="btn btn-primary">Create</button>
                    </div>
                </div>
           </div>
       </div>
        </form>
   </div>
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
      });
       
      $(document).click(function (event){
        $('#list1').fadeOut(); 
      }); 
    });
  </script>