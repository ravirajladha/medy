<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">Non Purchase Receive</h4>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo URLROOT; ?>/pages/index">Home</a></li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="contentbar">
    <div class="row">
        <div class="col-md-12">
            <div class="card m-b-30">
                <div class="card-header bg-primary-rgba">
                    <h5 class="card-title text-primary">Non Purchase Receive</h5>
                </div>
                <div class="card-body">

                    <form action="<?php echo URLROOT; ?>/pages/saveTheReceive1" method="POST">
                        <div class="table-responsive m-b-30">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Vendor Name</label>
                                            <div class="dropdown-menu" id="dropDownAjaxvname" style="width: 470px;padding-bottom: 0px;padding-top: 0px;">
                                            </div> 
                                            <input type="text" name="vendor" id="vname" style="display: none;" />
                                            <select class="select2-single form-control"  name="vendor_id" id="vname_id" onchange="getvendoradd(this.value)" required="true">
                                                <option selected >--Select--</option>
                                                <?php foreach ($data['vendor'] as $ve) { ?>
                                                <option value="<?php echo $ve->vendor_id;?>"><?php echo $ve->dispName;?></option>
                                                <?php }?>
                                            </select> 
                                        </div>
                                        <div class="col-md-4">
                                            <label for="">Receive Date</label>
                                            <input type="date" name="rec_date" class="form-control" required="true" min='1960-01-01' max="<?php echo date('Y-m-d');?>" value="<?php echo date('Y-m-d'); ?>">
                                        </div>
                                        <?php $Page = new Page(); ?>
                                        <?php $ab = $Page->get_auto_batch_count(); ?>
                                        <?php if(empty($ab)){ ?> 
                                            <div class="col-md-4">
                                                <label for="">Batch</label>
                                                <input type="text" name="batch" class="form-control" placeholder="Enter Batch" required="true" value="batch1">
                                            </div>
                                        <?php }else{ ?>
                                            <?php $ab = explode("batch", $ab->batch );  ?>
                                            <?php $ab = (int)$ab[1] + 1; ?>
                                            <div class="col-md-4">
                                                <label for="">Batch</label>
                                                <input type="text" name="batch" class="form-control" placeholder="Enter Batch" required="true" value="<?php echo "batch".$ab; ?>">
                                            </div>
                                        <?php }?>

                                    </div>
                                    <br>
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col" width="10">Sl.No.</th>
                                                <th scope="col" width="400">Item</th>
                                                <th scope="col"></th>
                                                <th scope="col">Receivable</th>
                                                <th scope="col-md-1">Quantity To Receive</th>
                                                <th scope="col">Positions</th>
                                                <!-- <th scope="col">Barcode</th> -->
                                            </tr>
                                        </thead>
                                        <tbody id="addr1">
                                            <tr id='addr0'>
                                                <td width="10">1</td>
                                                <td width="400">
                                                    <input type="number" name="itemId" class="form-control" placeholder="Enter Item Id" id="itemId" style="display: none;">
                                                    
                                                    <input type="text" name='itemName' placeholder='Enter Item Name' class="form-control" id="tags1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" autocomplete="off" style="display: none;" />
                                                    
                                                    <div class="dropdown-menu" id="dropDownAjax" style="width: 500px;padding-bottom: 0px;padding-top: 0px;">
                                                    </div>

                                                    <select class="select2-single form-control" name='' id="tags" onchange="getitem_name(this.value)">
                                                        <option>--Select--</option>
                                                        <?php foreach ($data['all_items'] as $it) 
                                                        {
                                                                     $m = $Page->get_model_name_by_id($it->model_id);
                                                                    if(empty($m->model_name)){ $m=""; }else{ $m=$m->model_name; } ?>
                                                                    <option value="<?php echo $it->id;?>"><?php echo "(".$m.")";?><?php echo $it->name;?></option>
                                                        <?php }?>
                                                    </select> 
                                                    
                                                </td>
                                                <td><a href="#" class="btn btn-primary" data-toggle="modal" data-target="#exampleStandardModal"><i class="fa fa-search"></i></a></td>
                                                <td>
                                                    <select name="receivable" id="receive">
                                                        <option value="1">Box</option>
                                                        <option value="3">Pieces</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control" placeholder="Quantity Receive" name="rQty" id="rqty">
                                                </td>
                                                <td>
                                                    <select name="pos" id="position">
                                                        <?php foreach ($data['positions'] as $value) {
                                                        ?>
                                                            <option><?php echo $value->position_code ?></option>
                                                        <?php
                                                        } ?>
                                                    </select>
                                                </td>
                                                <!-- <td> -->
                                                    <input type="text" class="form-control mt-1" placeholder="Barcode" name="barcode" id="pastbarcode" style="width: 180px;display: none;">
                                                <!-- </td> -->
                                            </tr>
                                            

                                            
                                        </tbody>
                                    </table>
                        </div>
                        <a class="btn btn-primary" style="color: white" onclick="addRowForBill()">Add Another Line</a>
                        <br>
                        <br>
                        <label for="">Notes</label>
                        <textarea class="form-control" name="notes"></textarea><br>
                        <button class="btn btn-primary" type="submit" name="npreceive">Receive</button>
                        <a class="btn btn-warning text-white">Cancel</a>
                        </from>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
<div class="modal fade" id="exampleStandardModal" tabindex="-1" role="dialog" aria-labelledby="exampleStandardModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
      
            <div class="modal-header">
                <h5 class="modal-title" id="exampleStandardModalLabel">Search Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label >Type</label>
                            <select name="type_id" id="type_id" class="form-control" onchange="categoryChange4(this.value)">
                                <option selected="" disabled="">--select--</option>
                                <?php foreach ($data['type'] as $key) {
                                ?>
                                    <option value="<?php echo $key->type_id; ?>"><?php echo $key->type_name ?></option>
                                <?php
                                } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Model</label>
                            <select name="model_id" id="model1" class="form-control" onclick="categoryChange5(this.value)">
                                <option selected="" disabled="">--select--</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                             <label>Category</label>
                            <select name="category_new_id" id="category_new" class="form-control" onclick="categoryChange6(this.value)">
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                             <label>Sub category</label>
                            <select name="subcategory_new_id" id="subcat_new" class="form-control" onclick="categoryChange7(this.value)">
                            </select>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-border">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Color</th>
                                <th>Size</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="allItems">
                          
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="reset" class="btn btn-secondary" data-dismiss="modal">Close</button>
               
            </div>
        
        </div>
    </div>
</div>

<script>
    function addRowForBill()
    {
        if(($('#rqty').val())=="")
        {
            alert("Enter Item First");
        }
        else
        {
            var itemId = $('#itemId').val();
            var sItem = $('#tags1').val();
            var receive = $('#receive').val();
            var rqty = $('#rqty').val();
            var position = $('#position').val();

            $.ajax({
                url: "<?php echo URLROOT; ?>/pages/tempnon_purchase",
                type: "POST",
                data: { itemId, sItem, receive, rqty, position },
                success: function(response4)
                {
                    $('#addr1').append(response4);
                    $('#itemId').val("");
                    // $('#tags').val("");
                    $('#sItem').val("");
                    $('#rqty').val("");
                    refresh_tag();
                }
            });
            
        }
    }
    function refresh_tag() {
        $.ajax({
                url: "<?php echo URLROOT; ?>/pages/refresh_tag_for_next",
                type: "POST",
                data: { },
                success: function(response4)
                {
                    $('#tags').html(response4);
                }
            });
    }
    function getitem_name(vid) 
    {
        var val = vid;
        $.ajax({
            url: "<?php echo URLROOT; ?>/pages/getTheItemName_for_jquery_name",
            type: "POST",
            data: {val},
            success: function(response)
            {
               $('#tags1').val(response);
            }
        });
        $('#itemId').val(val);
    }
    function getvendoradd(vid) 
    {
        $.ajax({
            url: '<?php echo URLROOT; ?>/pages/get_sort_by_item_using_vendor_list',
            type: "POST",
            data: {vid},
            success : function(res)
            {
                $('#tags').html(res);
            }
        });
    }
    // $('#rqty').keyup(function(){
    function copybarcode(){
        var itemid = $('#itemId').val();
        var rqty = $('#rqty').val();
        $.ajax({
            url: "<?php echo URLROOT; ?>/pages/calculate_barcode",
            type: "POST",
            data: {itemid,rqty},
            success: function(response)
            {
                 $('#pastbarcode').val(response);
            }
        });
        $.ajax({
            url: "<?php echo URLROOT; ?>/pages/calculate_barcode1",
            type: "POST",
            data: {itemid,rqty},
            success: function(response)
            {
                 $('#myIframe1').html(response);
            }
        });
        $.ajax({
            url: "<?php echo URLROOT; ?>/pages/calculate_barcode2",
            type: "POST",
            data: {itemid,rqty},
            success: function(response)
            {
                 $('#myIframe2').html(response);
            }
        });
    }
     // });

    function existingBatch() {
        $('#newBatch').css('display', 'none');
        $('#newBatch').attr('disabled', true);
        $('#newBatchA').css('display', 'block');
        $('#existingBatch').css('display', 'block');
        $('#existingBatchA').css('display', 'none');
        $('#existingBatch').attr('disabled', false);
    }

    function newBatch() {
        $('#newBatch').css('display', 'block');
        $('#newBatchA').css('display', 'none');
        $('#existingBatch').css('display', 'none');
        $('#existingBatchA').css('display', 'block');
        $('#newBatch').attr('disabled', false);
        $('#existingBatch').attr('disabled', true);
    }
</script>

<script>
    function selectProduct(val)
    {
        $.ajax({
            url: "<?php echo URLROOT; ?>/pages/getItemDetailsById1",
            type: "POST",
            data: {val},
            success: function(response)
            {
                var itemName = response.trim();
                $('#tags1').val(itemName);
                getReceivable(val);
            }
        });
        $.ajax({
            url: "<?php echo URLROOT; ?>/pages/getItemDetailsById2",
            type: "POST",
            data: {val},
            success: function(response)
            {
                // var itemid = response.trim();
                $('#itemId').val(val);
                //getReceivable(val);
            }
        });
    }
    $('#tags1').keyup(function(){
        var tags = $('#tags1').val();
        $.ajax({
            url: '<?php echo URLROOT; ?>/pages/getTheItems1',
            type: "POST",
            data: {tags},
            success : function(res)
            {
                $('#dropDownAjax').html(res);
            }
        });
    });
</script>
<script>
  $('#vname').keyup(function(){
        var vname = $('#vname').val();
        $.ajax({
            url: '<?php echo URLROOT; ?>/pages/get_all_vender_for_auto_complete_vname',
            type: "POST",
            data: {vname},
            success : function(res)
            {
                $('#dropDownAjaxvname').html(res);
                // alert(res);

            }
        });
  });
</script>
<script>
    function selectProductvname(val)
    {
        document.getElementById("vname_id").value = val.id;
        document.getElementById("vname").value = val.name;
        // document.getElementById("bill_address").value = val.address;
           
    }
</script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<?php if(isset($_SESSION['success'])){ ?>
    <script type="text/javascript">

                swal("<?php echo $_SESSION['success']; ?>");
    </script>
  <?php } unset($_SESSION['success']); ?>  
<script type="text/javascript">
   $(document).keypress(
  function(event){
    if (event.which == '13') {
      event.preventDefault();
    }
});
</script> 
<script type="text/javascript">
    
    function categoryChange4(typeid)
    {
        $.ajax({
            url: "<?php echo URLROOT; ?>/pages/types",
            type: "POST",
            data: {typeid},

            success: function(response)
            {   
                $('#model1').html(response);
                $('#c').val(typeid);
                categoryChange5();
            }
        });
    }
     function categoryChange5(model)
    {
        $.ajax({
            url: "<?php echo URLROOT; ?>/pages/models",
            type: "POST",
            data: {model},

            success: function(response)
            {   
                $('#category_new').html(response);
                 $('#s1').val(model);
                categoryChange6();
            }
        });

    }
    function categoryChange6(cat_new)
    {
        $.ajax({
            url: "<?php echo URLROOT; ?>/pages/category_new",
            type: "POST",
            data: {cat_new},

            success: function(response)
            {   
                $('#subcat_new').html(response);
                $('#s2').val(cat_new);
                categoryChange7();
            }
        });
       
    }
    function categoryChange7(subcat_new)
    {
        $('#s3').val(subcat_new);
        get_all_category_search();
       
    }
</script>
<script type="text/javascript">
  function get_all_category_search()
    {
        var category_id = $('#type_id').val();
        var subCategory = $('#model1').val();
        var subCategory1 = $('#category_new').val();
        var subCategory2 = $('#subcat_new').val();
        if(category_id!=0)
        {
          $.ajax({
            type:'POST',
            url:'<?php echo URLROOT;?>/pages/by_allcategory_item_catfornameonly',
            data:{category_id,subCategory,subCategory1,subCategory2},
            success : function(data)
            {
               $('#allItems').html(data);
            
            }
          });
        }
   }
   function select_items(vl) 
   {
        document.getElementById("itemId").value = vl.id;
        document.getElementById("tags1").value = vl.name;
        var val = vl.id;
        $.ajax({
            url: "<?php echo URLROOT; ?>/pages/getTheItemName_for_jquery",
            type: "POST",
            data: {val},
            success: function(response)
            {
               $('#tags').html(response);
            }
        });
        $('#exampleStandardModal').modal('hide');

   }
</script>