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
        <br><br>  <table>
    <tr>
      <th>Buyer</th>
      <th></th>
      <th></th>
      <th>Order Number</th>
      <th>Date</th>
      <th>Batch</th>
      
    </tr>
    <tr>
      <td> <?php echo ucwords($b->vendor);?></td>
      <td></td>
      <td></td>
      <td><?php echo $b->id;?></td>
      <td> <?php echo $b->receive_date;?></td>
      <td><?php echo ucwords($b->batch);?></td>
     
    </tr>
   
  </table>
 <br>
        <br>
        <br>
        <br><br>
  <table>
 
                <tr style="font-size: 10px;">
                                        <th>Item id</th>
                                        <th>Item Name</th>
                                        <th>Receivable</th>
                                        <th>Quantity Ordered</th>
                                    
                </tr>
           
                                       
                                    <?php $batch_wise = $Page->get_all_nonpurchase_order_details_find_batch($b->batch); ?>
                                    <?php foreach ($batch_wise as $k) { ?>
                                        <tr>
                                            <td><?php echo $k->item_id;?></td>
                                            <?php $item_name = $Page->getTheItemDetails($k->item_id); ?>
                                            <td><?php echo $item_name->name;?></td>
                                            <td><?php if($k->receivable==1){ echo "Box"; }elseif($k->receivable==3){ echo "Pieces"; } ?></td>
                                            <td><?php echo $k->qty_receive;?></td>
                                        </tr>
                                    <?php } ?>
   
  </table>
 
 
  
  
</div>

</div>


 <button class="btn btn-primary pull-right no-print" onclick="window.print()"><i class="fa fa-print" aria-hidden="true"></i> Print</button>