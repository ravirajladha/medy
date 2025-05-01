<?php require APPROOT .'/views/inc_labs/header.php'; ?>
	<div class="row">
	    <div class="col-sm-12">
	    	<div class="col-sm-6">
	    		<div class="row">
	    			<div class="col-sm-12">
	    		<div style="padding-top: 10px">
	       		<div class="panel panel-default">
	       			<div class="row">
	       			<div class="col-sm-8">
		       			<div class="form-group">
			                <input style="margin-top: 10px;" type="text" class="form-control" id="quick_search_1" placeholder="Quick Search Test">
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
					   <a href="<?php echo URLROOT;?>/labs/new_test"><button style="margin-top: 10px" class="btn btn-info w-md m-b-5">Create New Test</button></a>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="panel-heading"><label for="exampleInputEmail1" style="padding-left: 10px">Biochemistry</label></div>
					<div class="table-responsive">
                        <table class="table">
                            <tbody id="get_data" >
                                
                            </tbody>
                        
                        </table>
                    </div>
				  </div>
				</div>
			</div>
	        	</div>
	        	<div class="col-sm-12">
	        		<button style="position: fixed;bottom: 60px;" id="upd_grp_btnn" type="button" class="btn btn-info w-md m-b-5">Update Group</button>	        		
	        	</div>
	    	</div>
	    </div>

	    <div class="col-sm-6">
	    	<div class="row">
	    	 <div class="col-sm-12">
	    		<div style="padding-top: 10px">
	       		<div class="panel panel-default">
	       			<div class="row">
	       			<div class="col-sm-12">
		       			<div class="form-group">
			                <input style="margin-top: 10px;" type="text" id="quick_search_2" class="form-control"  placeholder="Quick Search Test">
						</div>
					</div>
					
				</div>
				<div class="row">
					<div class="panel-heading"></div>
					<div class="table-responsive">
						<!-- <form action="<?php echo URLROOT;?>/labs/test_group2" method="post"> -->
                        <table class="table" id="test_name_display">
                        	
                        </table>
                    </div>
				  </div>
				</div>
			</div>
	        	</div>
	        	<div class="col-sm-12">
	        		<button style="position: fixed;bottom: 60px;" id="cb_check" type="submit" class="btn btn-info w-md m-b-5">Add to Group</button>	 
	        		<!-- </form> -->
	        	</div>
	    	</div>
	    </div>
	</div>
</div>
<?php require APPROOT .'/views/inc_labs/footer.php'; ?>

<script type="text/javascript">
  $(document).ready(function()
      {
          $.ajax({
            url: '<?php echo URLROOT;?>/labs/get_available_tests',
            success:function(response)
            {
              $('#get_data').html(response);
            }
          });
      });
</script>

<script type="text/javascript">
  $(document).ready(function()
	{
	  $.ajax({
	    url: '<?php echo URLROOT;?>/labs/test_group1',
	    cache: false,
	    success:function(response)
	    {
	      $('#test_name_display').html(response);
	    }
	  });
	});
</script>


<script type="text/javascript">
 $(document).ready(function(){
 	$('#quick_search_2').keyup(function(){
 		var val = $(this).val();
 		$.ajax({
 			url:'<?php echo URLROOT;?>/labs/quick_test_list',
 			type:'POST',
 			data:{val},
 			success:function(response)
 			{
 				$('#test_name_display').html(response);
	 			$.ajax({
	                url: '<?php echo URLROOT;?>/labs/get_available_tests',
	                success:function(response)
	                {
	                  $('#get_data').html(response);
	                }
	              });
 			}
 		});
 		if(val == "")
 		{
 			$.ajax({
		    url: '<?php echo URLROOT;?>/labs/test_group1',
		    cache: false,
		    success:function(response)
		    {
		      $('#test_name_display').html(response);
		    }
		  });
 		}
 	});
 });
</script>

<script type="text/javascript">

	function get_test_id(id)
	{
		var cost = $('#cost'+id+'').val();
		$.ajax({
			url:'<?php echo URLROOT;?>/labs/save_available_test',
			type:'POST',
			data:{id,cost},
			success:function(response)
 			{
 				alert(response);
 				location.reload(true);
 			}
		});
	}

</script>

<script type="text/javascript">
 $(document).ready(function(){
 	$('#quick_search_1').keyup(function(){
 		var val = $(this).val();
 		$.ajax({
 			url:'<?php echo URLROOT;?>/labs/get_available_tests_db_autocomplete',
 			type:'POST',
 			data:{val},
 			success:function(response)
 			{
 				$('#get_data').html(response);
 			}
 		});
 	});
 });
</script>

<script type="text/javascript">
	$(document).ready(function(){
		$('#cb_check').click(function(){
			var ch = [];
			var cst = [];
            $.each($("input[name='hello']:checked"), function(){
                ch.push($(this).val());
            });
            if(ch != '')
            {
	            for(var i = 0; i < ch.length; i++)
	            {
	            	cst.push($('#cost'+ch[i]+'').val());
	            }
	            $.ajax({
	            	url : '<?php echo URLROOT;?>/labs/bulk_add_to_group',
	            	type : 'POST',
	            	data : {ch, cst},
	            	success : function(data)
	            	{
	            		alert(data);
	            		location.reload(true);
	            	}
	            });
	        }
	        else
	        {
	        	alert('Please Select Test');
	        }
		});
	});
</script>

<script type="text/javascript">
	$(document).ready(function(){
		$('#upd_grp_btnn').click(function(){
			var t_ids = [];
			$.each($("input[name='added_tests']:checked"), function(){
                t_ids.push($(this).val());
            });
            if(t_ids == '')
            {
            	$.ajax({
            	url:'<?php echo URLROOT;?>/labs/delete_all_tests',
            	success : function(data)
            	{
            		alert(data);
            		location.reload(true);
            	}
            });
            }
            else
            {
            	$.ajax({
            	url:'<?php echo URLROOT;?>/labs/update_new_group',
            	type:'POST',
            	data:{t_ids},
            	success : function(data)
            	{
            		alert(data);
            		location.reload(true);
            	}
            });
            }
            
		});
	});
</script>

