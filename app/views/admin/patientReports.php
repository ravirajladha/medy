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
                <a href="<?php echo URLROOT; ?>/admin/exportPatientAllData"><button class="btn btn-success btn-xs pull-right">All Patient Data</button></a>
                <h3 class="panel-title">Patient Report</h3>
            </div>
            <br>
            <form action="<?php echo URLROOT;?>/admin/exportPatientData" method="POST">
            <div class="row">
                <div class="col-sm-3">
                    <label for="">Patient Name/Id</label>
                    <input type="text" id="cust" name="pat" class="form-control" placeholder="Search By Patient ID/Name" style="margin-top: 10px;">
                    <div id="list3" style="display: none;"></div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-3">
                    <button class="btn btn-info btn-sm">Export</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
<?php require APPROOT .'/views/inc_admin/footer.php';?>
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