<?php require APPROOT . '/views/inc/header.php'; ?>
  <!-- Start Breadcrumbbar -->                    
            <div class="breadcrumbbar">
                <div class="row align-items-center">
                    <div class="col-lg-11">
                        <h4 class="page-title">Customer Wise Sales Report</h4>
                        <div class="breadcrumb-list">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo URLROOT; ?>/pages/index">Home</a></li>
                               
                            </ol>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <!-- <a class="btn btn-primary" style="color: white" onclick="print_page()"><i class="fa fa-print" aria-hidden="true"></i></a> -->
                    </div>
                </div>          
            </div>
            <?php $Page = new Page(); ?>
            <!-- End Breadcrumbbar -->
            <!-- Start Contentbar -->    
            <div class="contentbar">                
                <!-- Start row -->
                <div class="row">
                    <!-- Start col -->
                    <div class="col-lg-12">
                        <div class="card m-b-30">
                            <div class="card-header">                                
                                <div class="row align-items-center">
                                    <div class="col-12">
                                        <center>
                                            <h6><?php echo URLROOT1;?><h6>
                                            <h5 class="card-title mb-0" style="font-size: 28px;">Customer Wise Sales Report</h5>
                                            <br>
                                        </center>
                                    </div>
                                </div>
                            </div>
                           <!--  <div class="container">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row ">
                                            <div class="col-md-4"></div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label >Customer Name</label>
                                                    <select name="" id="cust_id" class="form-control select2-single " onchange="categoryChange4(this.value)">
                                                        <option selected="" disabled="">--select--</option>
                                                        <?php foreach ($data['dist_customer_id'] as $key) {
                                                                $cn = $Page->get_customer_namefordisplay($key->customer_id);
                                                        ?>
                                                            <option value="<?php echo $key->customer_id; ?>"><?php echo $cn->customer_display_name ?></option>
                                                        <?php
                                                        } ?>
                                                    </select>
                                                </div> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Customer Name</th>
                                                <th>Date</th>
                                                <th>Type</th>
                                                <th>Model</th>
                                                <th>Category</th>
                                                 <!-- <th>Item Name</th> -->
                                                <th>Size</th>
                                                <th>Color</th>
                                                <th>Quantity</th>
                                                <!--  <th>Item Price</th>
                                                <th>Sub Total</th>
                                                <th>Grand Total</th>
                                                <th></th> -->
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            foreach ($data['dist_customer_id'] as $key) 
                                            {
                                                $cn = $Page->get_customer_namefordisplay($key->customer_id);
                                            ?>
                                            <?php if($_SESSION['ctype']==3){ ?>
                                            <tr>
                                                <td style="border-bottom: 1px solid black"><?php echo $cn->customer_display_name;?></td>

                                                <?php
                                                $st = $Page->get_all_stockout_by_custid($key->customer_id); 
                                                ?>
                                                <td style="border-bottom: 1px solid black">
                                                    <?php foreach ($st as $k) 
                                                    { 
                                                        echo date("d-m-Y",strtotime($k->stock_dt));
                                                        break;
                                                    }
                                                    ?>

                                                </td>
                                                <!-- Type -->
                                                <td style="border-bottom: 1px solid black">
                                                    <?php foreach ($st as $k) 
                                                    { 
                                                        $sto = $Page->get_all_stockoutorder_by_id($k->id);
                                                        $item_id = explode("|||", $sto->item_id);
                                                        for ($i=0; $i <sizeof($item_id); $i++) 
                                                        { 
                                                            $s_item = $Page->get_item_by_id($item_id[$i]);
                                                            $d_type = $Page->get_type_name_by_id($s_item->type_id);
                                                            ?>
                                                            <p><?php echo $d_type->type_name."<br>";?></p>  
                                                       <?php }
                                                    }
                                                    ?>
                                                         
                                                </td>
                                                <!-- model -->
                                                <td style="border-bottom: 1px solid black">
                                                    <?php foreach ($st as $k) 
                                                    { 
                                                        $sto = $Page->get_all_stockoutorder_by_id($k->id);
                                                        $item_id = explode("|||", $sto->item_id);
                                                        for ($i=0; $i <sizeof($item_id); $i++) 
                                                        { 
                                                            $s_item = $Page->get_item_by_id($item_id[$i]);
                                                            $d_modal = $Page->get_model_name_by_id($s_item->model_id);
                                                            ?>
                                                            <p><?php echo $d_modal->model_name."<br>";?></p>  
                                                       <?php }
                                                    }
                                                    ?>
                                                         
                                                </td>
                                                <!-- category -->
                                                <td style="border-bottom: 1px solid black">
                                                    <?php foreach ($st as $k) 
                                                    { 
                                                        $sto = $Page->get_all_stockoutorder_by_id($k->id);
                                                        $item_id = explode("|||", $sto->item_id);
                                                        for ($i=0; $i <sizeof($item_id); $i++) 
                                                        { 
                                                            $s_item = $Page->get_item_by_id($item_id[$i]);
                                                            $d_category = $Page->get_category_name_by_id($s_item->category_new_id);
                                                            if(empty($d_category->category_name))
                                                            {
                                                                $d = "---";
                                                            }else
                                                            {
                                                                $d= $d_category->category_name;
                                                            }
                                                            ?>
                                                            <p><?php echo $d."<br>";?></p>  
                                                       <?php }
                                                    }
                                                    ?>
                                                         
                                                </td>
                                                <!-- Item name -->
                                              
                                                <!-- Size -->
                                                <td style="border-bottom: 1px solid black">
                                                    <?php foreach ($st as $k) 
                                                    { 
                                                        $sto = $Page->get_all_stockoutorder_by_id($k->id);
                                                        $item_id = explode("|||", $sto->item_id);
                                                        for ($i=0; $i <sizeof($item_id); $i++) 
                                                        { 
                                                            $s_item = $Page->get_item_by_id($item_id[$i]);
                                                            $d_get_size = $Page->get_size($s_item->size_id);
                                                            if(empty($d_get_size->size_name))
                                                            {
                                                                $d = "---";
                                                            }else
                                                            {
                                                                $d= $d_get_size->size_name;
                                                            }
                                                            ?>
                                                            <p><?php echo $d."<br>";?></p>  
                                                       <?php }
                                                    }
                                                    ?>     
                                                </td>
                                                <!-- Color -->
                                                <td style="border-bottom: 1px solid black">
                                                    <?php foreach ($st as $k) 
                                                    { 
                                                        $sto = $Page->get_all_stockoutorder_by_id($k->id);
                                                        $item_id = explode("|||", $sto->item_id);
                                                        for ($i=0; $i <sizeof($item_id); $i++) 
                                                        { 
                                                            $s_item = $Page->get_item_by_id($item_id[$i]);
                                                            $d_color_id = $Page->get_color($s_item->color_id);
                                                            if(empty($d_color_id->color_name))
                                                            {
                                                                $d = "---";
                                                            }else
                                                            {
                                                                $d= $d_color_id->color_name;
                                                            }
                                                            ?>
                                                            <p><?php echo $d."<br>";?></p>  
                                                       <?php }
                                                    }
                                                    ?>
                                                         
                                                </td>
                                                <td style="border-bottom: 1px solid black">
                                                    <?php foreach ($st as $k) 
                                                    { 
                                                        $sto = $Page->get_all_stockoutorder_by_id($k->id);
                                                        $item_rec = explode("|||", $sto->item_rec);
                                                        $item_id = explode("|||", $sto->item_qty);
                                                        $item_id1 = sizeof($item_id);

                                                        if($item_id1 == 1)
                                                        {
                                                            ?>
                                                            <p><?php echo $item_id[0]."<br>";?></p>
                                                            <?php
                                                        }
                                                        else
                                                        {
                                                            for ($i=0; $i < sizeof($item_id); $i++) 
                                                            {
                                                                if($item_id[$i] == "")
                                                                {
                                                                    ?>
                                                                    <p><?php echo "---"."<br>";?></p>
                                                                    <?php
                                                                }
                                                                else
                                                                {
                                                                    if($item_rec[$i]==1)
                                                                    {
                                                                        $rec = "(B)";
                                                                    }else
                                                                    {
                                                                        $rec = "(P)";
                                                                    }
                                                                    ?>
                                                                      <p><?php echo $item_id[$i]." ".$rec."<br>";?></p>
                                                                    <?php
                                                                }
                                                            }
                                                        }
                                                        
                                                           
                                                    }
                                                    ?>
                                                         
                                                </td>
                                                  <td style="border-bottom: 1px solid black">
                                                    <?php foreach ($st as $k) 
                                                    { 
                                                        $sto = $Page->get_all_stockoutorder_by_id($k->id);
                                                        
                                                        $it_id = explode("|||", $sto->item_id);
                                                        $item_rec = explode("|||", $sto->item_rec);
                                                        $item_qty = explode("|||", $sto->item_qty);
                                                        $item_id1 = sizeof($item_qty);
                                                        

                                                        if($item_id1 == 1)
                                                        {
                                                            ?>
                                                            <p><?php echo $item_qty[0]."<br>";?></p>
                                                            <?php
                                                        }
                                                        else
                                                        {
                                                            for ($i=0; $i < sizeof($item_qty); $i++) 
                                                            {
                                                                if($item_qty[$i] == "")
                                                                {
                                                                    ?>
                                                                    <p><?php echo "---"."<br>";?></p>
                                                                    <?php
                                                                }
                                                                else
                                                                {
                                                                    if($item_rec[$i]==1)
                                                                    {
                                                                        $rec = "(B)";
                                                                        $qt[$i] = $Page->get_tax_from_view($it_id[$i]);
                                                                        $qt[$i] =  (((int)($qt[$i]->qty))* (int)$item_qty[$i]);

                                                                    }else
                                                                    {
                                                                        $rec = "(P)";
                                                                        $qt[$i]=(int)$item_qty[$i];
                                                                    }
                                                                    $qt[$i] = $qt[$i];
                                                                    ?>
                                                                      <p><?php echo $qt[$i]; //echo $item_qty[$i]." ".$rec."<br>";?></p>
                                                                    <?php
                                                                }
                                                            }
                                                        }
                                                        
                                                           
                                                    }
                                                    ?>
                                                         
                                                </td>
                                               
                                            </tr>
                                            <?php   }elseif($_SESSION['ctype']==1)
                                                    { 
                                                        if($cn->cp_priority==1)
                                                        { 
                                            ?>
                                            <tr>
                                                <td style="border-bottom: 1px solid black"><?php echo $cn->customer_display_name;?></td>

                                                <?php
                                                $st = $Page->get_all_stockout_by_custid($key->customer_id); 
                                                ?>
                                                <td style="border-bottom: 1px solid black">
                                                    <?php foreach ($st as $k) 
                                                    { 
                                                        echo date("d-m-Y",strtotime($k->stock_dt));
                                                        break;
                                                    }
                                                    ?>

                                                </td>
                                                <!-- Type -->
                                                <td style="border-bottom: 1px solid black">
                                                    <?php foreach ($st as $k) 
                                                    { 
                                                        $sto = $Page->get_all_stockoutorder_by_id($k->id);
                                                        $item_id = explode("|||", $sto->item_id);
                                                        for ($i=0; $i <sizeof($item_id); $i++) 
                                                        { 
                                                            $s_item = $Page->get_item_by_id($item_id[$i]);
                                                            $d_type = $Page->get_type_name_by_id($s_item->type_id);
                                                            ?>
                                                            <p><?php echo $d_type->type_name."<br>";?></p>  
                                                       <?php }
                                                    }
                                                    ?>
                                                         
                                                </td>
                                                <!-- model -->
                                                <td style="border-bottom: 1px solid black">
                                                    <?php foreach ($st as $k) 
                                                    { 
                                                        $sto = $Page->get_all_stockoutorder_by_id($k->id);
                                                        $item_id = explode("|||", $sto->item_id);
                                                        for ($i=0; $i <sizeof($item_id); $i++) 
                                                        { 
                                                            $s_item = $Page->get_item_by_id($item_id[$i]);
                                                            $d_modal = $Page->get_model_name_by_id($s_item->model_id);
                                                            ?>
                                                            <p><?php echo $d_modal->model_name."<br>";?></p>  
                                                       <?php }
                                                    }
                                                    ?>
                                                         
                                                </td>
                                                <!-- category -->
                                                <td style="border-bottom: 1px solid black">
                                                    <?php foreach ($st as $k) 
                                                    { 
                                                        $sto = $Page->get_all_stockoutorder_by_id($k->id);
                                                        $item_id = explode("|||", $sto->item_id);
                                                        for ($i=0; $i <sizeof($item_id); $i++) 
                                                        { 
                                                            $s_item = $Page->get_item_by_id($item_id[$i]);
                                                            $d_category = $Page->get_category_name_by_id($s_item->category_new_id);
                                                            if(empty($d_category->category_name))
                                                            {
                                                                $d = "---";
                                                            }else
                                                            {
                                                                $d= $d_category->category_name;
                                                            }
                                                            ?>
                                                            <p><?php echo $d."<br>";?></p>  
                                                       <?php }
                                                    }
                                                    ?>
                                                         
                                                </td>
                                                <!-- Item name -->
                                              
                                                <!-- Size -->
                                                <td style="border-bottom: 1px solid black">
                                                    <?php foreach ($st as $k) 
                                                    { 
                                                        $sto = $Page->get_all_stockoutorder_by_id($k->id);
                                                        $item_id = explode("|||", $sto->item_id);
                                                        for ($i=0; $i <sizeof($item_id); $i++) 
                                                        { 
                                                            $s_item = $Page->get_item_by_id($item_id[$i]);
                                                            $d_get_size = $Page->get_size($s_item->size_id);
                                                            if(empty($d_get_size->size_name))
                                                            {
                                                                $d = "---";
                                                            }else
                                                            {
                                                                $d= $d_get_size->size_name;
                                                            }
                                                            ?>
                                                            <p><?php echo $d."<br>";?></p>  
                                                       <?php }
                                                    }
                                                    ?>     
                                                </td>
                                                <!-- Color -->
                                                <td style="border-bottom: 1px solid black">
                                                    <?php foreach ($st as $k) 
                                                    { 
                                                        $sto = $Page->get_all_stockoutorder_by_id($k->id);
                                                        $item_id = explode("|||", $sto->item_id);
                                                        for ($i=0; $i <sizeof($item_id); $i++) 
                                                        { 
                                                            $s_item = $Page->get_item_by_id($item_id[$i]);
                                                            $d_color_id = $Page->get_color($s_item->color_id);
                                                            if(empty($d_color_id->color_name))
                                                            {
                                                                $d = "---";
                                                            }else
                                                            {
                                                                $d= $d_color_id->color_name;
                                                            }
                                                            ?>
                                                            <p><?php echo $d."<br>";?></p>  
                                                       <?php }
                                                    }
                                                    ?>
                                                         
                                                </td>
                                                <td style="border-bottom: 1px solid black">
                                                    <?php foreach ($st as $k) 
                                                    { 
                                                        $sto = $Page->get_all_stockoutorder_by_id($k->id);
                                                        $item_rec = explode("|||", $sto->item_rec);
                                                        $item_id = explode("|||", $sto->item_qty);
                                                        $item_id1 = sizeof($item_id);

                                                        if($item_id1 == 1)
                                                        {
                                                            ?>
                                                            <p><?php echo $item_id[0]."<br>";?></p>
                                                            <?php
                                                        }
                                                        else
                                                        {
                                                            for ($i=0; $i < sizeof($item_id); $i++) 
                                                            {
                                                                if($item_id[$i] == "")
                                                                {
                                                                    ?>
                                                                    <p><?php echo "---"."<br>";?></p>
                                                                    <?php
                                                                }
                                                                else
                                                                {
                                                                    if($item_rec[$i]==1)
                                                                    {
                                                                        $rec = "(B)";
                                                                    }else
                                                                    {
                                                                        $rec = "(P)";
                                                                    }
                                                                    ?>
                                                                      <p><?php echo $item_id[$i]." ".$rec."<br>";?></p>
                                                                    <?php
                                                                }
                                                            }
                                                        }
                                                        
                                                           
                                                    }
                                                    ?>
                                                         
                                                </td>
                                                  <td style="border-bottom: 1px solid black">
                                                    <?php foreach ($st as $k) 
                                                    { 
                                                        $sto = $Page->get_all_stockoutorder_by_id($k->id);
                                                        
                                                        $it_id = explode("|||", $sto->item_id);
                                                        $item_rec = explode("|||", $sto->item_rec);
                                                        $item_qty = explode("|||", $sto->item_qty);
                                                        $item_id1 = sizeof($item_qty);
                                                        

                                                        if($item_id1 == 1)
                                                        {
                                                            ?>
                                                            <p><?php echo $item_qty[0]."<br>";?></p>
                                                            <?php
                                                        }
                                                        else
                                                        {
                                                            for ($i=0; $i < sizeof($item_qty); $i++) 
                                                            {
                                                                if($item_qty[$i] == "")
                                                                {
                                                                    ?>
                                                                    <p><?php echo "---"."<br>";?></p>
                                                                    <?php
                                                                }
                                                                else
                                                                {
                                                                    if($item_rec[$i]==1)
                                                                    {
                                                                        $rec = "(B)";
                                                                        $qt[$i] = $Page->get_tax_from_view($it_id[$i]);
                                                                        $qt[$i] =  (((int)($qt[$i]->qty))* (int)$item_qty[$i]);

                                                                    }else
                                                                    {
                                                                        $rec = "(P)";
                                                                        $qt[$i]=(int)$item_qty[$i];
                                                                    }
                                                                    $qt[$i] = $qt[$i];
                                                                    ?>
                                                                      <p><?php echo $qt[$i]; //echo $item_qty[$i]." ".$rec."<br>";?></p>
                                                                    <?php
                                                                }
                                                            }
                                                        }
                                                        
                                                           
                                                    }
                                                    ?>
                                                         
                                                </td>
                                               
                                            </tr>
                                            <?php
                                                }
                                            }
                                            else
                                            {
                                                if($cn->cp_priority==0)
                                                { ?>
                                            <tr>
                                                <td style="border-bottom: 1px solid black"><?php echo $cn->customer_display_name;?></td>

                                                <?php
                                                $st = $Page->get_all_stockout_by_custid($key->customer_id); 
                                                ?>
                                                <td style="border-bottom: 1px solid black">
                                                    <?php foreach ($st as $k) 
                                                    { 
                                                        echo date("d-m-Y",strtotime($k->stock_dt));
                                                        break;
                                                    }
                                                    ?>

                                                </td>
                                                <!-- Type -->
                                                <td style="border-bottom: 1px solid black">
                                                    <?php foreach ($st as $k) 
                                                    { 
                                                        $sto = $Page->get_all_stockoutorder_by_id($k->id);
                                                        $item_id = explode("|||", $sto->item_id);
                                                        for ($i=0; $i <sizeof($item_id); $i++) 
                                                        { 
                                                            $s_item = $Page->get_item_by_id($item_id[$i]);
                                                            $d_type = $Page->get_type_name_by_id($s_item->type_id);
                                                            ?>
                                                            <p><?php echo $d_type->type_name."<br>";?></p>  
                                                       <?php }
                                                    }
                                                    ?>
                                                         
                                                </td>
                                                <!-- model -->
                                                <td style="border-bottom: 1px solid black">
                                                    <?php foreach ($st as $k) 
                                                    { 
                                                        $sto = $Page->get_all_stockoutorder_by_id($k->id);
                                                        $item_id = explode("|||", $sto->item_id);
                                                        for ($i=0; $i <sizeof($item_id); $i++) 
                                                        { 
                                                            $s_item = $Page->get_item_by_id($item_id[$i]);
                                                            $d_modal = $Page->get_model_name_by_id($s_item->model_id);
                                                            ?>
                                                            <p><?php echo $d_modal->model_name."<br>";?></p>  
                                                       <?php }
                                                    }
                                                    ?>
                                                         
                                                </td>
                                                <!-- category -->
                                                <td style="border-bottom: 1px solid black">
                                                    <?php foreach ($st as $k) 
                                                    { 
                                                        $sto = $Page->get_all_stockoutorder_by_id($k->id);
                                                        $item_id = explode("|||", $sto->item_id);
                                                        for ($i=0; $i <sizeof($item_id); $i++) 
                                                        { 
                                                            $s_item = $Page->get_item_by_id($item_id[$i]);
                                                            $d_category = $Page->get_category_name_by_id($s_item->category_new_id);
                                                            if(empty($d_category->category_name))
                                                            {
                                                                $d = "---";
                                                            }else
                                                            {
                                                                $d= $d_category->category_name;
                                                            }
                                                            ?>
                                                            <p><?php echo $d."<br>";?></p>  
                                                       <?php }
                                                    }
                                                    ?>
                                                         
                                                </td>
                                                <!-- Item name -->
                                              
                                                <!-- Size -->
                                                <td style="border-bottom: 1px solid black">
                                                    <?php foreach ($st as $k) 
                                                    { 
                                                        $sto = $Page->get_all_stockoutorder_by_id($k->id);
                                                        $item_id = explode("|||", $sto->item_id);
                                                        for ($i=0; $i <sizeof($item_id); $i++) 
                                                        { 
                                                            $s_item = $Page->get_item_by_id($item_id[$i]);
                                                            $d_get_size = $Page->get_size($s_item->size_id);
                                                            if(empty($d_get_size->size_name))
                                                            {
                                                                $d = "---";
                                                            }else
                                                            {
                                                                $d= $d_get_size->size_name;
                                                            }
                                                            ?>
                                                            <p><?php echo $d."<br>";?></p>  
                                                       <?php }
                                                    }
                                                    ?>     
                                                </td>
                                                <!-- Color -->
                                                <td style="border-bottom: 1px solid black">
                                                    <?php foreach ($st as $k) 
                                                    { 
                                                        $sto = $Page->get_all_stockoutorder_by_id($k->id);
                                                        $item_id = explode("|||", $sto->item_id);
                                                        for ($i=0; $i <sizeof($item_id); $i++) 
                                                        { 
                                                            $s_item = $Page->get_item_by_id($item_id[$i]);
                                                            $d_color_id = $Page->get_color($s_item->color_id);
                                                            if(empty($d_color_id->color_name))
                                                            {
                                                                $d = "---";
                                                            }else
                                                            {
                                                                $d= $d_color_id->color_name;
                                                            }
                                                            ?>
                                                            <p><?php echo $d."<br>";?></p>  
                                                       <?php }
                                                    }
                                                    ?>
                                                         
                                                </td>
                                                <td style="border-bottom: 1px solid black">
                                                    <?php foreach ($st as $k) 
                                                    { 
                                                        $sto = $Page->get_all_stockoutorder_by_id($k->id);
                                                        $item_rec = explode("|||", $sto->item_rec);
                                                        $item_id = explode("|||", $sto->item_qty);
                                                        $item_id1 = sizeof($item_id);

                                                        if($item_id1 == 1)
                                                        {
                                                            ?>
                                                            <p><?php echo $item_id[0]."<br>";?></p>
                                                            <?php
                                                        }
                                                        else
                                                        {
                                                            for ($i=0; $i < sizeof($item_id); $i++) 
                                                            {
                                                                if($item_id[$i] == "")
                                                                {
                                                                    ?>
                                                                    <p><?php echo "---"."<br>";?></p>
                                                                    <?php
                                                                }
                                                                else
                                                                {
                                                                    if($item_rec[$i]==1)
                                                                    {
                                                                        $rec = "(B)";
                                                                    }else
                                                                    {
                                                                        $rec = "(P)";
                                                                    }
                                                                    ?>
                                                                      <p><?php echo $item_id[$i]." ".$rec."<br>";?></p>
                                                                    <?php
                                                                }
                                                            }
                                                        }
                                                        
                                                           
                                                    }
                                                    ?>
                                                         
                                                </td>
                                                  <td style="border-bottom: 1px solid black">
                                                    <?php foreach ($st as $k) 
                                                    { 
                                                        $sto = $Page->get_all_stockoutorder_by_id($k->id);
                                                        
                                                        $it_id = explode("|||", $sto->item_id);
                                                        $item_rec = explode("|||", $sto->item_rec);
                                                        $item_qty = explode("|||", $sto->item_qty);
                                                        $item_id1 = sizeof($item_qty);
                                                        

                                                        if($item_id1 == 1)
                                                        {
                                                            ?>
                                                            <p><?php echo $item_qty[0]."<br>";?></p>
                                                            <?php
                                                        }
                                                        else
                                                        {
                                                            for ($i=0; $i < sizeof($item_qty); $i++) 
                                                            {
                                                                if($item_qty[$i] == "")
                                                                {
                                                                    ?>
                                                                    <p><?php echo "---"."<br>";?></p>
                                                                    <?php
                                                                }
                                                                else
                                                                {
                                                                    if($item_rec[$i]==1)
                                                                    {
                                                                        $rec = "(B)";
                                                                        $qt[$i] = $Page->get_tax_from_view($it_id[$i]);
                                                                        $qt[$i] =  (((int)($qt[$i]->qty))* (int)$item_qty[$i]);

                                                                    }else
                                                                    {
                                                                        $rec = "(P)";
                                                                        $qt[$i]=(int)$item_qty[$i];
                                                                    }
                                                                    $qt[$i] = $qt[$i];
                                                                    ?>
                                                                      <p><?php echo $qt[$i]; //echo $item_qty[$i]." ".$rec."<br>";?></p>
                                                                    <?php
                                                                }
                                                            }
                                                        }
                                                        
                                                           
                                                    }
                                                    ?>
                                                         
                                                </td>
                                               
                                            </tr>
                                        <?php   }
                                            } 
                                        ?>
                                            <?php }?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End col -->
                </div>
                <!-- End row -->
            </div>
            <!-- End Contentbar -->

<?php require APPROOT . '/views/inc/footer.php'; ?>
<script type="text/javascript"> 
      $(document).ready(function()
        {
        var lim = 0;
        var off = 0;
        var inc = 0;
            $.ajax({
            type: "POST",
            url: '<?php echo URLROOT;?>/pages/allItemsforcatreport',
            data: {lim,off},
            cache: false,
            success:function(response)
            {
                $('#allItems').html(response);
            }
            });
        });
 </script>
<script>
    function categoryChange4(arg)
    {
        $.ajax({
            url: "<?php echo URLROOT; ?>/pages/customer_wise_sales_list",
            type: "POST",
            data: {custid},

            success: function(response)
            {   
                $('#model1').html(response);
                $('#c').val(typeid);
                categoryChange5();
            }
        });
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
            url:'<?php echo URLROOT;?>/pages/by_allcategory_item_cat1',
            data:{category_id,subCategory,subCategory1,subCategory2},
            success : function(data)
            {
               $('#allItems').html(data);
            
            }
          });
        }
   }
</script>
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