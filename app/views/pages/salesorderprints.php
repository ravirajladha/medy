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
      <th>Customer Name</th>
      <th>Address</th>
      <th></th>
      <th>Order No</th>
      <th>Date</th>
     
      
    </tr>
    <tr>
      <td>  <?php echo ucwords($b->customer);?></td>
      <td> <?php $v = $Page->get_customer_by_id($b->customer_id);?><?php echo $v->b_attention. " " . $v->b_street1 . " " . $v->b_street2 . " " . $v->b_city . " " . $v->b_state . " " . $v->b_country . " " . $v->b_zip_code . " " . $v->b_phone . " " . $v->b_fax;?></td>
      <td></td>
      <td><?php echo $b->id;?></td>
      <td><?php echo $b->stock_dt;?></td>
     
     
    </tr>
   
  </table>
 <br><br>
        <br>
        <br>
  <table>
 
                <tr style="font-size: 10px;">
                                        <th>Item id</th>
                                        <th>Item Name</th>
                                        <th>Receivable</th>
                                        <th>Quantity Ordered</th>
                        <th style="display: none;">Price</th>
                                        <th style="display: none;">Total</th>
                                       
                </tr>
           
                                 <?php $so = $Page->get_single_stock_out_order_details($b->id); ?>
                                    <?php 
                                            $item_id = explode("|||", $so->item_id);
                                            $item_name = explode("|||", $so->item_name);
                                            $receivable = explode("|||", $so->item_rec);
                                            $item_qty = explode("|||", $so->item_qty);
                                            $item_price = explode("|||", $so->item_price);
                                            $item_rtotal = explode("|||", $so->item_rtotal);

                                    ?>
                                    <?php for ($h=0; $h < sizeof($item_id); $h++) 
                                      { ?>
                                        <tr>
                                            <td><?php echo $item_id[$h];?></td>
                                            <td><?php echo $item_name[$h];?></td>
                                            <td><?php
                                            if($receivable[$h]==1)
                                            {
                                                echo 'Box';
                                            }else
                                            {
                                                echo 'Pieces';
                                            } ?></td>
                                            <td><?php echo $item_qty[$h];?></td>
                                           <td style="display: none;"><?php echo $item_price[$h];?></td>
                                           <td style="display: none;"><?php echo $item_rtotal[$h];?></td>
                                        </tr>
                                    <?php } ?>
                                
                              
   
  </table>
 
  <!-- <br><br>
  <br><br>
  <br><br>
  <br><br>
  <br><br>
  <br><br> -->
  <br><br>
  <br><br>
  <br><br>
  
  
</div>

</div>



 <button class="btn btn-primary pull-right no-print" onclick="window.print()"><i class="fa fa-print" aria-hidden="true"></i> Print</button>