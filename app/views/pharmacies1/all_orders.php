<?php require APPROOT .'/views/inc_pharmacy/header.php'; ?>
 <?php $fff = new Pharmacy();?>
 <div class="row">

    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">All Purchase Orders</h3></div>
             <br>
              <div class="row">
                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th style="text-align: left">Purchase Order Id</th>
                                                        <th style="text-align: left">Supplier Name</th>
                                                        <th style="text-align: left">Total Amount</th>
                                                        <th style="text-align: left">Order Date</th>
                                                        <th width="300">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
        <?php  foreach ($data['posts'] as $key){
           $invoice_id = $key->invoice_id;
          $company_name = $key->comany_name;
          $company_name = explode(' | ', $company_name);
          $invoice_total = $key->grand_total;
           $invoice_total = $key->grand_total;
          $order_status = $key->order_status;
          $invoice_date_time = date('d-m-Y', strtotime($key->created_at));
          $items = explode('|', $key->product_name);
        $qty = explode('|', $key->qunatity);
        $item_price = explode('|', $key->item_price);
        $buying_price = explode('|', $key->buying_price);
        $total = explode('|', $key->total);
          ?>
         
         <tr>
            <td style="text-align: left">
           <?php echo $invoice_id;?></td>
            <td style="text-align:left;"><a href="#" data-toggle="modal" data-target="#<?php echo $company_name[1];?>"><?php echo ucwords($company_name[0]);?></a></td>
            <td style="text-align: left"><?php echo $invoice_total;?></td>
            <td style="text-align: left"><?php echo $invoice_date_time;?></td>
            <td style="text-align:left;padding-left:65px;">
            
                <a href="<?php echo URLROOT;?>/pharmacies/view_listed_invoices/<?php echo $invoice_id;?>"><button style="width: 40px;" type="button" class="btn btn-success w-sm m-b-5">Print</button></a>
                  <a href="<?php echo URLROOT;?>/pharmacies/view_listed_invoices/<?php echo $invoice_id;?>"><button style="width: 40px;" type="button" class="btn btn-purple w-sm m-b-5">View</button></a>&nbsp;
                  <?php if($order_status == 0)
                  { ?>
                    <a href="<?php echo URLROOT;?>/pharmacies/accepted_order/<?php echo $invoice_id;?>" style="width: 40px" class="btn btn-danger w-sm m-b-5">Accept</a>
                    <a href="<?php URLROOT;?>/pharmacies/reject_order/<?php $invoice_id;?>"><button style="width: 40px" type="button" class="btn btn-info w-sm m-b-5">Reject</button></a>
                 <?php }
                  elseif($order_status == 1)
                  { ?>
                    <button data-toggle="modal" data-target="#con-close-modal<?php echo $invoice_id;?>" style="width: 54px" class="btn btn-info w-sm m-b-5" id="update" onclick="caaa()">Update</button> 
                 <form action="<?php echo URLROOT;?>/pharmacies/add_purchased_stock/<?php echo $invoice_id;?>" method="POST">
                      <div id="con-close-modal<?php echo $invoice_id;?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog modal-lg"> 
                                        <div class="modal-content"> 
                                            <div class="modal-header"> 
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
                                                <h4 class="modal-title">Update Stock 2</h4> 
                                            </div> 
                                            <div class="modal-body"> 
                                                <div class="row"> 
                                                     <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Purchase Order ID:<?php echo $invoice_id;?></h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <table class="table table-striped" id="tab_logic" >
                                            <thead>
                                                <tr>
                                                    <th>Name(ID)</th>
                                                    <th>Quantity</th>
                                                    <th>Cost</th>
                                                    <th>Total</th>
                                                    <th>Deliverd</th>
                                                    <th>Batch</th>
                                                    <th>Expiry</th>
                                                    <th>Balance</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                          <?php
                                            for ($i=0; $i < count($items); $i++) 
                                                { 
                                                ?>  
                                                <tr>
                                                    <td><?php echo $items[$i]?></td>
                                                    <td><input  type="number" id="qty<?php echo $invoice_id.$i ?>" value="<?php echo 
                                                    $qty[$i];?>"  style="width: 50px;border:none;background-color: #f9f9f9" readonly></td>
                                                    <td><?php echo $buying_price[$i]?></td>
                                                    <td><?php echo $total[$i]?></td>
                                                    <td><input type="number" class="price" value="<?php echo 
                                                    $qty[$i];?>" id="<?php echo $invoice_id.$i ?>" min="0" name ="deliverd[]" onkeyup="lookup1(this);" style="width: 50px;border:none;background-color: #f9f9f9"></td>
                                                    <td>
                                                      <input type="text" name="batch[]" class="price" style="width: 90px;border:none;background-color: #fff" >
                                                    </td>
                                                    <td>
                                                      <input type="date" name="expiry[]" class="price" style="width: 130px;border:none;background-color: #fff" >
                                                    </td>
                                                    <td><input type="number" id="total<?php echo $invoice_id.$i ?>" value="<?php echo 
                                                    ($qty[$i] - $qty[$i]);?>" name ="total[]" min="0" style="width: 50px;border:none;background-color: #f9f9f9" readonly></td>

                                                </tr>

                                                             <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                                </div> 
                                            </div> 
                                            <div class="modal-footer"> 
                                                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button> 
                                                <button type="submit" class="btn btn-info">Update</button>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                </form>
                      <a href="<?php echo URLROOT;?>/pharmacies/deliverd_update/<?php echo  $invoice_id;?>" style="width: 40px" class="btn btn-danger w-sm m-b-5">Delivered</a>
                       <?php } elseif($order_status == 5) { ?>

           
            

            <?php $jj = $fff->get_stock_orders($invoice_id);
            ?>

        
                <button data-toggle="modal" data-target="#stockmodal<?php echo $invoice_id;?>" style="width: 40px" class="btn btn-info w-sm m-b-5" id="update">Stock Update</button>
                 <a href="<?php echo URLROOT;?>/pharmacies/deliverd_update/<?php echo  $invoice_id;?>" style="width: 40px" class="btn btn-danger w-sm m-b-5">Delivered</a>

            <form action="<?php echo URLROOT;?>/pharmacies/update_stock_db/<?php echo $invoice_id;?>" method="POST">
                      <div id="stockmodal<?php echo $invoice_id;?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog modal-lg"> 
                                        <div class="modal-content"> 
                                            <div class="modal-header"> 
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
                                                <h4 class="modal-title">Update Stock</h4> 
                                            </div> 
                                            <div class="modal-body"> 
                                                <div class="row"> 
                                                     <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Purchase Order Id:<?php echo $invoice_id;?></h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <table class="table table-striped" id="tab_logic" >
                                            <thead>
                                                <tr>
                                                    <th>Name(ID)</th>
                                                    <th>Quantity</th>
                                                    <th>Cost</th>
                                                    <th>Deliverd</th>
                                                    <th>Batch</th>
                                                    <th>Expiry</th>
                                                    <th>Balance</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                          <?php
                                            $re = 0;
                                            foreach($jj as $jey) 
                                                { 
                                                ?>  
                                                <tr>
                                                    <td><input type="text" name="id[]" value="<?php echo $jey->drug_id;?>" style="display: none;"><?php echo $jey->drug_id;?></td>
                                                    <td><input  type="number" id="qty_s<?php echo $jey->stock_id.$re ?>" value="<?php echo 
                                                    $jey->stock_receiving;?>"  style="width: 50px;border:none;background-color: #f9f9f9" readonly></td>
                                                    <td><?php echo $jey->drug_sell_cost?></td>
                                                    <td><input type="number" id="<?php echo $jey->stock_id.$re ?>" class="price" value="<?php echo 
                                                    $jey->stock_total;?>"  min="0" name ="recived[]" onkeyup="stock(this);" style="width: 50px;border:none;background-color: #f9f9f9"></td>
                                                    <td>
                                                      <?php if($jey->stock_total == 0) { ?>
                                                      <input type="text" name="batch[]" class="price" style="width: 70px;border:none;background-color: #fff" value="<?php echo $jey->stock_batch; ?>">
                                                    <?php } else { echo $jey->stock_batch; } ?>
                                                    </td>
                                                    <td>
                                                      <?php if($jey->stock_total == 0) { ?>
                                                      <input type="date" name="expiry[]" class="price" style="width: 130px;border:none;background-color: #fff" value="<?php echo $jey->stock_expiry ?>">
                                                      <?php } else { echo $jey->stock_expiry; } ?>
                                                    </td>
                                                    <td><input type="number" id="bal<?php echo $jey->stock_id.$re ?>" value="<?php echo $jey->stock_receiving - $jey->stock_total;?>" name ="remain[]" min="0" style="width: 50px;border:none;background-color: #f9f9f9" readonly></td>

                                                </tr>

                                                             <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                                </div> 
                                            </div> 
                                            <div class="modal-footer"> 
                                                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button> 
                                                <button type="submit" class="btn btn-info">Update</button>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                </form>
              <?php  ?>
                  <?php }

                   elseif($order_status == 2)
                  {?>
                      <a><button style="width: 40px" type="button" class="btn btn-info w-sm m-b-5">Rejected</button></a>
                  <?php } 
                   elseif($order_status == 3)
                  {?>
                      <a><button style="width: 40px" type="button" class="btn btn-info w-sm m-b-5">Delivered</button></a>
                  <?php } ?>
            </td>

          </tr>
    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
<?php foreach ($data['sup'] as $key6) {
?>
<div class="modal fade" id="<?php echo $key6->s_id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="exampleModalLabel">Company Details</h5>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th>Supplier Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>GSTIN</th>
                <th>Address</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><?php echo ucwords($key6->s_name); ?></td>
                <td><?php echo $key6->s_phone; ?></td>
                <td><?php echo $key6->s_email; ?></td>
                <td><?php echo $key6->s_gstin; ?></td>
                <td><?php echo $key6->s_address; ?></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<?php } ?>
<?php require APPROOT .'/views/inc_pharmacy/footer.php';?>

<script type="text/javascript">

function lookup1(arg){
 var id = arg.getAttribute('id');
 var tot = $('#qty'+id+'').val()- $('#'+id+'').val();
 $('#total'+id+'').val(tot);
}
</script>

<script type="text/javascript">

function stock(arg){
 var id = arg.getAttribute('id');
 var tot = $('#qty_s'+id+'').val()- $('#'+id+'').val();
 $('#bal'+id+'').val(tot);
}
</script>
