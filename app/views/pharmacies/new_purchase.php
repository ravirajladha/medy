<?php require APPROOT .'/views/inc_pharmacy/header.php'; ?>
<style type="text/css">
#list3,#list4{
        max-height: 100px;
        max-width: 345px;
        min-width: 345px;
        position: absolute;
        overflow-y: auto;
        overflow-x: hidden;
        background-color: white;
        border: solid;
        border-width: 1px;
        border-color: lightgray;
        padding-left: 10px;
        font-size: 13px;
        cursor: pointer;
        z-index: 50;
        text-align: left;
      }
.ee:hover{
	background-color: lightgray;
}  
.ff:hover{
	background-color: lightgray;
} 
.ee,.ff{
	font-size: 15px;
	margin: 1px;
}  
</style>
<div class="row">
	<form>
	<div class="col-md-12">
		<div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">New Stock</h3></div>
                <div class="panel-body">
                
				<div class="row">
					<div class="col-md-4">
		                <div class="form-group">
							<label for="exampleInputEmail1">Drug Identity</label>
		                    <input style="margin-top: 10px;" type="text" class="form-control" id="cust" placeholder="Barcode/Drug ID/Drug Name" autocomplete="off">
		                    <div id="list3" style="display: none;"></div>
				    	</div>
					</div>


			
				<div class="col-md-4">
		                <div class="form-group">
							<label for="exampleInputEmail1">Drug Batch</label>
		                        <input style="margin-top: 10px;" type="text" class="form-control" id="drug_batch" placeholder="Enter Batch Number">
				    </div>
				</div>
				<div class="col-md-4">
					<div class="col-md-6">
		            <div class="form-group">
					    <label for="exampleInputEmail1">Drug Expiry</label>
		                    <input style="margin-top: 10px;" type="number" class="form-control" id="drug_exp_mth" placeholder="Month">
					</div>
					</div>
					<div class="col-md-6">
		            <div class="form-group">
					    <label for="exampleInputEmail1">&nbsp</label>
		                    <input style="margin-top: 10px;" type="number" class="form-control" id="drug_exp_yr" placeholder="Year">
					</div>
					</div>
				</div>
				<div class="col-md-4">
		            <div class="form-group">

					   <label for="exampleInputEmail1">Drug Stocks</label>
		                    <input style="margin-top: 10px;" type="text" class="form-control" id="drug_stck" placeholder="Enter Stocks">

					</div>
				</div>

				<div class="col-md-4">
		            <div class="form-group">
						
					   <label for="exampleInputEmail1">Drug Distributor</label>
		                    <input style="margin-top: 10px;" type="text" class="form-control" id="dist" placeholder="Enter Distributor Name">
		                    <div id="list4" style="display: none;"></div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="col-md-6">
					<div class="form-group">
					   <label for="exampleInputEmail1">Drug CGST(%)</label>
		                    <input style="margin-top: 10px;" type="text" class="form-control" id="drug_cgst" placeholder="Enter CGST">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
					   <label for="exampleInputEmail1">Drug SGST(%)</label>
		                    <input style="margin-top: 10px;" type="text" class="form-control" id="drug_sgst" placeholder="Enter SGST">
					</div>
				</div>
				</div>
				

				<div class="col-md-4">
		            <div class="form-group">
						
					   <label for="exampleInputEmail1">Drug Buy Cost</label>
		                    <input style="margin-top: 10px;" type="text" class="form-control" id="drug_buy" placeholder="Enter Buy Cost">

					</div>
				</div>
				<div class="col-md-4">
		            <div class="form-group">
						
					   <label for="exampleInputEmail1">Drug Sell Cost</label>
		                    <input style="margin-top: 10px;" type="text" class="form-control" id="drug_sell" placeholder="Enter Sell Cost">

					</div>
				</div>
				<div class="col-md-4">
					<div class="col-md-6">
		            <div class="form-group">
					   <button style="margin-top: 34px" type="button" class="btn btn-info w-md m-b-5 add_drug">Add Stock</button>
					</div>
				</div>
				</div>
			</div>
		</div>
	</div>
</div>
</form>
</div>
	
<?php require APPROOT .'/views/inc_pharmacy/footer.php';?>
<script type="text/javascript">
    $(document).ready(function(){
      $('#cust').keyup(function(){
        var query3 = $(this).val();
        if(query3!=0)
        {
          $.ajax({
            url:'<?php echo URLROOT;?>/pharmacies/get_auto_drug',
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

<script type="text/javascript">
    $(document).ready(function(){
      $('#dist').keyup(function(){
        var query3 = $(this).val();
        if(query3!=0)
        {
          $.ajax({
            url:'<?php echo URLROOT;?>/pharmacies/get_auto_dist',
            type:'POST',
            data:{query3:query3}, 
            success:function(data)
            {
              $('#list4').fadeIn();
              $('#list4').html(data);
            }
          });
        }
        else
        {
          $('#list4').fadeOut();
        }
      });
       $(document).on('click', '.ff', function(){  
           $('#dist').val($(this).text());  
           $('#list4').fadeOut();  
      });
      $(document).click(function (event){
        $('#list4').fadeOut(); 
      });  
    });
</script>

<script type="text/javascript">
	$(document).ready(function(){
		$('.add_drug').click(function(){
			var drug_identity = $('#cust').val();
			var drug_batch = $('#drug_batch').val();
			var drug_exp_yr = $('#drug_exp_yr').val();
			var drug_exp_mth = $('#drug_exp_mth').val();
			var drug_stck = $('#drug_stck').val();
			var dist = $('#dist').val();
			var drug_cgst = $('#drug_cgst').val();
			var drug_sgst = $('#drug_sgst').val();
			var drug_buy = $('#drug_buy').val();
			var drug_sell = $('#drug_sell').val();
			var id = drug_identity.split('|');
			var drug_id = id[1].trim();
			$.ajax({
				url : '<?php echo URLROOT;?>/pharmacies/new_batch',
				type : 'POST',
				data : {drug_id,drug_identity,drug_batch,drug_exp_yr,drug_exp_mth,drug_stck,dist,drug_cgst,drug_sgst,drug_buy,drug_sell},
				success : function(response)
				{
					alert(response);
					$('#cust').val('');
					$('#drug_batch').val('');
					$('#drug_exp_mth').val('');
					$('#drug_exp_yr').val('');
					$('#drug_stck').val('');
					$('#dist').val('');
					$('#drug_cgst').val('');
					$('#drug_sgst').val('');
					$('#drug_buy').val('');
					$('#drug_sell').val('');
				}
			})
		});
	});
</script>