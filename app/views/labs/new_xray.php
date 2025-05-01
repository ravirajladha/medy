<?php require APPROOT .'/views/inc_labs/header.php'; ?>

<style type="text/css">
	.ee{
		padding: 5px;
	}
	.ee:hover{
		background-color: lightgray;
	}

	#list
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
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
        <div class="panel-heading"><h3 class="panel-title">Reports Upload</h3>
                  
        </div>
            <div class="panel-body " >
				<div class="row">
					<div class="col-md-3">
		          <div class="form-group">
  							<label for="">Patient Name / ID / Phone</label>
  							<input id="id_id" type="text" name="" style="display: none;"  autocomplete="off">
                <input style="margin-top: 10px;" autocomplete="off" type="text" class="form-control patient_search" id="pat_name_q" placeholder="Enter Patient Name / ID / Phone" required="true">
	             <div id="list"></div>
					    </div>
					</div>
					
					<div class="col-md-3">
			      <div class="form-group">
						  <label for="exampleInputEmail1">Report Name/title</label>
			          <input style="margin-top: 10px;" type="text" class="form-control" id="visit_pur" placeholder="Enter Report title" autocomplete="off" required="true">
						</div>
					</div>
          <div class="col-md-3">
              <div class="form-group">
                  <label for="exampleInputEmail1">Select file</label>
                    <input type="file" style="margin-top: 10px;" class="form-control" id="file" placeholder="" autocomplete="off" required="true">
                </div>
          </div>
					<div class="col-md-3">
              <div class="first_div">

                       
        			        <div class="form-group">
        						   <button style="margin-top: 34px" id="op_visit" type="button" class="btn btn-info w-md m-b-5">Upload</button>
        						  </div>
              </div>
              
					</div>

				</div>
			</div>

		</div>
	</div>
</div>  
</div>
<?php  require APPROOT .'/views/inc_labs/footer.php';?>

<script type="text/javascript">
	
  $(document).ready(function() { 
    $("#op_visit").click(function() { 

        var ip_rep = $('#id_id').val();
        var rep_tit = $('#visit_pur').val();
        var fd = new FormData(); 
        var files = $('#file')[0].files[0]; 
        fd.append('file', files); 
        if(ip_rep == '')
        {
            swal({
                  title: "Please Enter Name",
                  timer: 2300,   
                  showConfirmButton: false 
                });

        }
        else
        {
        $.ajax({ 
            url: '<?php echo URLROOT; ?>/labs/doc_upload_jq', 
            type: 'POST', 
            data: fd,
            contentType: false, 
            processData: false, 
            success: function(response){ 
                if(response != 0){ 
                   $('.aft_upd1').css("display", "block");
                   setTimeout( function(){ 
                    $('.aft_upd2').css("display", "block"); 
                  }  , 5000 );

                     swal({
                title: "File uploaded Successfully",   
                timer: 2000,   
                showConfirmButton: false 
            });

                    save_other_upload_details(ip_rep, rep_tit);
                } 
                else{ 
                    alert('file not uploaded'); 
                } 
            }, 
        }); }
    }); 
}); 
  function save_other_upload_details(ip_rep, rep_tit)
{
    $.ajax({
        url:'<?php echo URLROOT; ?>/labs/save_other_upload_details',
        type:'POST',
        data:{ip_rep, rep_tit},
        success : function(data)
        {
            $('#id_id').val('');
            $('#visit_pur').val('');
            $('#pat_name_q').val('');
             $('#file').val(''); 
            return true;
        }
    });
}
</script>


  <script type="text/javascript">
    $(document).ready(function(){
      $('.patient_search').keyup(function(){
        var query3 = $(this).val();
        if(query3!=0)
        {
          $.ajax({
            url:'<?php echo URLROOT;?>/labs/get_auto_patient_name2',
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

  <script type="text/javascript">
  $('#tggle_div').click(function(){
    $('.first_div').css({'display':'none'});
    $('.sec_div').css({'display':'block'});
    $('.c_button').css({'display':'none'});
  });
</script>