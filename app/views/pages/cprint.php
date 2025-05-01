<style>
    @media print
    {    
        .no-print, .no-print *
        {
            display: none !important;
        }
    }


    table {
  border-collapse: collapse;
  border-spacing: 0;
  width: 100%;
  border: 1px solid #ddd;
}

th, td {
  text-align: left;
  padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2}
</style>
<?php $b = $data['p_details'];?>

<?php $Page = new Page(); ?>
<div style="height:100mm; width:205mm; border: 0.5px black solid;">
    <div style="height:100mm; width:28mm; float: left; border-bottom: 0.5px solid black;">
        <pre style="transform: rotate(-90deg); margin-top:180px; font-size: 15px;">Bharathi Electricals</pre>
    </div>

    <div style="overflow-x:auto;transform: rotate(-90deg);height:168mm; margin-left:200px;margin-top:-130px;width:100mm; ">
  <table>
    <tr>
      <th>Buyer</th>
      <th></th>
      <th></th>
      <th>Order Number</th>
      <th>Date</th>
      <th>Expected Date</th>
      
    </tr>
    <tr>
      <td>  <?php echo $b->bill_address;?></td>
      <td></td>
      <td></td>
      <td><?php echo $b->id;?></td>
      <td> <?php echo $b->ndate;?></td>
      <td> <?php echo $b->expected_delivery_date;?></td>
     
    </tr>
   
  </table>
 <br>
  <table>
 
                <tr style="font-size: 10px;">
                                        <th>Item id</th>
                                        <th>Item Name</th>
                                        <th>Receivable</th>
                                        <th>Quantity Ordered</th>
                                        <th>Item Price</th>
                </tr>
           
                                    <?php 
                                    $bb = $Page->get_purchase_order_item_details($b->id);
                                    $item_id = explode("|||", $bb->item_id);
                                    $item_name = explode("|||", $bb->item_name);
                                    $receivable = explode("|||", $bb->receivable);
                                    $per_unit_quantity = explode("|||", $bb->per_unit_quantity);
                                    $act_qty = explode("|||", $bb->act_qty);
                                    $row_price = explode("|||", $bb->row_price);
                                    $row_total = explode("|||", $bb->row_total);
                                    $subtotal = $bb->subtotal;
                                    $po_tax = $bb->po_tax;
                                    $po_discount = $bb->po_discount;
                                    $grand_total = $bb->grand_total;
                                    ?>

                                    <?php for ($i=0; $i < sizeof($item_id) ; $i++) { ?>
                                        <tr>
                                            <td><?php echo $item_id[$i];?></td>
                                            <td><?php echo $item_name[$i];?></td>
                                            <td><?php if($receivable[$i]==1){ echo "Box (Per Qty:".$per_unit_quantity[$i].")"; }elseif($receivable[$i]==3){ echo "Pieces"; } ?></td>
                                            <td><?php echo $act_qty[$i];?></td>
                                            <td><?php echo $row_price[$i];?></td>
                                            
                                        </tr>
                                        
                                    <?php }?>
                              
   
  </table>
 
  <!-- <br><br>
  <br><br>
  <br><br>
  <br><br>
  <br><br>
  <br><br> -->
  <br><br>
  <br>
  
  <table>
    <tr>
      <th>Sub Total</th>
     
      <td style="float:right;"><?php echo $subtotal;?></td>
      
    </tr>
   
  </table>
  <table>
    <tr>
      <th>Tax</th>
     
      <td style="float:right;"><?php echo $po_tax;?> %</td>
      
    </tr>
   
  </table>
  <table>
    <tr>
      <th>Discount</th>
     
      <td style="float:right;"><?php echo $po_discount;?></td>
      
    </tr>
   
  </table>
 
  <table>
    <tr>
      <th> Grand Total</th>
     
      <th style="float:right;"><?php echo $grand_total;?></th>
      
    </tr>
   
  </table>
 
</div>

</div>
<!-- <div style="height:73mm; width:205mm; border: 0.5px black solid; border-top:none">
    <div style="height:73mm; width:28mm; float: left; border-bottom: 0.5px solid black;">
    </div>
    <div style="height:73mm; width:148mm; float: left; border-left: 0.5px solid black;">
        
    </div>
    <div style="height:73mm; width:28mm; float:right; border-left: 0.5px black solid;">
        
    </div>
</div> -->
<!-- <div style="height:73mm; width:205mm; border: 0.5px black solid; border-top:none">
    <div style="height:73mm; width:28mm; float: left; border-bottom: 0.5px solid black;">
    </div>
    <div style="height:73mm; width:148mm; float: left; border-left: 0.5px solid black;">
        
    </div>
    <div style="height:73mm; width:28mm; float:right; border-left: 0.5px black solid;">
        
    </div>
</div> -->
<!-- <div style="height:73mm; width:205mm; border: 0.5px black solid; border-top:none">
    <div style="height:73mm; width:28mm; float: left; border-bottom: 0.5px solid black;">
    </div>
    <div style="height:73mm; width:148mm; float: left; border-left: 0.5px solid black;">
        
    </div>
    <div style="height:73mm; width:28mm; float:right; border-left: 0.5px black solid;">
        
    </div>
</div> -->


 <button class="btn btn-primary pull-right no-print" onclick="window.print()"><i class="fa fa-print" aria-hidden="true"></i> Print</button>