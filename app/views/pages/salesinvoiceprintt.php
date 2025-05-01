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

<div style="height:100mm; width:205mm; border: 0.5px black solid;">
    <div style="height:100mm; width:28mm; float: left; border-bottom: 0.5px solid black;">
        <pre style="transform: rotate(-90deg); margin-top:180px; font-size: 15px;">Bharathi Electricals</pre>
    </div>

    <div style="overflow-x:auto;transform: rotate(-90deg);height:168mm; margin-left:200px;margin-top:-130px;width:100mm; ">
  <table>
    <tr>
      <th>Invoice No</th>
    
      
    </tr>
    <tr>
      <td>  <?php echo $data['sales']->sale_id; ?></td>

     
    </tr>
   
  </table>
 <br>
  <table>
  <thead>
      <tr style="font-size:10px;">
          <th>Sl.No.</th>
          <th>Item Id</th>
          <th>Item Name</th>
          <th>Item Quantity</th>
          <th>Tax</th>
          <th>Unit Price</th>
          <th>Item Price</th>
      </tr>
      </thead>
      <?php
          $item_t_total=0;
          $t_tax = 0;
          $itemId = explode('|||', $data['sales']->item_id);
          $itemName = explode('|||', $data['sales']->item_name);
          $itemQty = explode('|||', $data['sales']->item_qty);
          $itemPrice = explode('|||', $data['sales']->item_price);
          $itemTax = explode('|||', $data['sales']->item_tax);
          $itemTotal = explode('|||', $data['sales']->item_total);
          $itemState = explode('|||', $data['sales']->item_state);
      ?>
      <tbody style="font-size:11px;">
          <?php for ($i=0; $i < sizeof($itemId); $i++) { 
          ?>
          <tr>
              <td><?php echo $i+1; ?></td>
              <td><?php echo $itemId[$i]; ?></td>
              <td><?php echo $itemName[$i]; ?></td>
              <td><?php echo $itemQty[$i]; ?></td>
              <td>
                  <?php 
                      if($itemState[$i] == 1)
                      {
                          echo 'CGST-'.($itemTax[$i]/2).'%';
                          echo "<br>";
                          echo 'SGST-'.($itemTax[$i]/2).'%';
                      }
                      else
                      {
                          echo 'IGST-'.($itemTax[$i]).'%';
                      }
                  ?>
              </td>
              <td><?php echo $itemPrice[$i]; ?></td>
              <td><?php echo $itemTotal[$i]; 
              $item_t_total = $item_t_total + $itemTotal[$i];
              $t_tax = $t_tax + ($itemTotal[$i] /100 * $itemTax[$i]);
               ?></td>
          </tr>
          <?php } ?>
      </tbody>
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
  
  <table>
    <tr>
      <th>Sub Total:</th>
     
      <td style="float:right;">₹ <?php echo array_sum($itemTotal); ?></td>
      
    </tr>
   
  </table>
  <table>
    <tr>
      <th>Tax:</th>
     
      <td style="float:right;">₹ <?php echo $t_tax; ?></td>
      
    </tr>
   
  </table>
  <table>
    <tr>
      <th>Amount Payable:</th>
     
      <td style="float:right;">₹ <?php echo $t_tax + $item_t_total; ?></td>
      
    </tr>
   
  </table>
 
  
 
</div>

</div>



 <button class="btn btn-primary pull-right no-print" onclick="window.print()"><i class="fa fa-print" aria-hidden="true"></i> Print</button>