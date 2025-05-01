<?php require APPROOT . '/views/inc/header.php'; ?>
<!-- Start Breadcrumbbar -->                    
<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-lg-11">
             <h4 class="page-title">Datewise Customers Direct Package Report</h4>
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
                                <h5 class="card-title mb-0" style="font-size: 28px;">Datewise Customers Direct Package Report</h5>
                                <br>
                            </center>
                        </div>
                    </div>
                </div>
          
                <div class="card-body">

                    <center>

                        <form action="<?php echo URLROOT ;?>/pages/customerwise_sales_report2_time2_P" method="POST" id="customer_form">

                            <div class="form-group">
                                <label  class="mt-1">From</label>

                                <input type="date" value="<?php echo date('Y-m-d'); ?>" name="from_date" min='1960-01-01' max="<?php echo date('Y-m-d'); ?>">

                                <label  class="ml-4 mt-1">To</label>

                                <input type="date" value="<?php echo date('Y-m-d'); ?>" class="mr-3" name="to_date" min='1960-01-01' max="<?php echo date('Y-m-d'); ?>">

                                  </div>

                                <div class="row mb-3">
                                    <div class="col-lg-1">
                                    </div>
                                    <div class="col-lg-5">
                                        
                                        <label class="ml-4 mt-1">Select Customer</label>

                                        <select name="customer_list[]" onChange="yearChangeHandler" class="select2-single mb-4" multiple="multiple" style="color: black;width: 100px;" id="customer_list">

                                        <option disabled style="color: white;">--SELECT A CUSTOMER---</option>
                                        
                                        <?php

                                        foreach ($data['all_cust'] as $key_cu)
                                        {
                                        ?>
                                        <option value="<?php echo $key_cu->id; ?>">
                                            <?php
                                            echo $key_cu->customer_display_name;
                                            ?>  
                                        </option>                                         
                                        <?php
                                        }
                                        ?>
                                    </select>
                                    </div>
                                    <div class="col-lg-5">
                                        
                                        <label  class="ml-4 mt-1">Select Model</label>

                                        <select name="model_list[]"  onChange="yearChangeHandler" class="select2-single mb-4" multiple="multiple" style="color: black;width: 100px;" id="model_list">

                                        <option disabled style="color: white;">--SELECT A MODEL---</option>
                                        <?php 
                                        foreach ($data['all_mod'] as $key_mo)
                                        {
                                        ?>
                                        <option value="<?php echo $key_mo->model_id; ?>">
                                            <?php
                                            echo $key_mo->model_name;
                                            ?>
                                                
                                        </option>                                         

                                    
                                        <?php
                                        }
                                        ?>
                                    </select>

                                    </div>
                                    <div class="col-lg-1">
                                    </div>
                                </div>



                            
                      
                        </form>

                        <input class="btn btn-primary" type="submit" id="form_submit">
                </center>

                <?php
                if(empty($data['date_val']))
                {

                }
                else
                {

                    if(empty($data['customize_customer']) && empty($data['customize_models']))
                    {
                ?>
    <table class="table table-bordered my-5 table-responsive">
        <?php
        $colors = $Page->get_all_colors();

        $color_nme_arr = array();
        $color_id_arr = array();

        $d1 = array();
        for($i = 1; $i < sizeof($d1)+1;$i++)
        {
            $color_nme_arr[$i] = "";

            $color_id_arr[$i] = "";
        }


        foreach ($colors as $key_clr )
        {

            $clr_nme = strtolower($key_clr->color_name);
            if($clr_nme == "red")
            {
                $color_nme_arr[1] =  $key_clr->color_name;

                $color_id_arr[1] =  $key_clr->color_id;
            }
            elseif($clr_nme == "black")
            {
                $color_nme_arr[2] =  $key_clr->color_name;

                $color_id_arr[2] =  $key_clr->color_id;
            }
            elseif($clr_nme == "blue")
            {
               $color_nme_arr[3] =  $key_clr->color_name;

               $color_id_arr[3] =  $key_clr->color_id;
            }
            elseif($clr_nme == "yellow")
            {
                $color_nme_arr[4] =  $key_clr->color_name;

                $color_id_arr[4] =  $key_clr->color_id;
            }
            elseif($clr_nme == "green")
            {
                $color_nme_arr[5] =  $key_clr->color_name;

                $color_id_arr[5] =  $key_clr->color_id;
            }
            elseif($clr_nme == "grey")
            {
                $color_nme_arr[6] =  $key_clr->color_name;

                $color_id_arr[6] =  $key_clr->color_id;
            }
            elseif($clr_nme == "white")
            {
                $color_nme_arr[7]  =  $key_clr->color_name;

                $color_id_arr[7] =  $key_clr->color_id;
            }
        }
        ?>
        <thead>
            <th>customer</th>
            <th>model</th>
            <th>category</th>
            <th>size</th>
            <?php
            for($i = 1; $i < sizeof($color_nme_arr)+1;$i++)
            {
               
            ?>
            <th class="px-4">
                <?php echo $color_nme_arr[$i]; ?></th>
            <?php } ?>
            <th>Total</th>
            
        </thead>
        <tbody>
            <?php
            $get_all_customers_temp = $Page->get_all_customers_ne();

            $customer_array = array();

            $customer_nme_arr = array();

            foreach ($get_all_customers_temp as $key_cu) 
            {
                $customer_array[] = $key_cu->customer_id;

                $customer_nme_arr[] = $Page->get_customer_name($key_cu->customer_id);
            }

            if(empty($customer_array))
            {
            ?>
                <tr>
                    <td>No Record found</td>
                </tr>
            <?php
            }
            else
            {

                

                for($i = 0; $i < sizeof($customer_array); $i++)
                {

                    $customer_nme_count = 1;
                   
                    $data = [

                        'customer_id' => $customer_array[$i],
                        'type_id' => 4
                       
                        ];

                    $get_modal_for_cust = $Page->get_modal_for_cust($data); 

                    $modal_array = array();

                    $modal_nme_arr = array();

                    foreach ($get_modal_for_cust as $key_m)
                    {
                        $modal_array[] = $key_m->model_id;

                        $modal_nme_arr[] = $Page->get_modal_name($key_m->model_id);
                    }

                    for($j = 0; $j < sizeof($modal_array); $j++)
                    { 

                        $modal_nme_count = 1; 

                        $data = [

                            'customer_id' => $customer_array[$i],
                            'type_id' => 4,
                            'model_id' => $modal_array[$j]
                       
                        ];

                        $get_category_for_mo = $Page->get_category_for_mo($data);

                        $category_array = array();

                        $category_nme_arr = array();

                        foreach ($get_category_for_mo as $key_cate)
                        {
                            $category_array[] = $key_cate->category_id;

                            $category_nme_arr[] = $Page->get_category_name($key_cate->category_id);
                        }

                        for($k = 0; $k < sizeof($category_array); $k++)
                        { 

                            $category_nme_count = 1;

                            $data = [

                                'customer_id' => $customer_array[$i],
                                'type_id' => 4,
                                'model_id' => $modal_array[$j],
                                'category_id' => $category_array[$k]
                               
                            ];

                            $get_size_count_cat = $Page->get_size_count_cat($data);

                            $size_arr1 = array();
                            $size_nme_arr = array();

                            foreach ($get_size_count_cat as $key_s)
                            {
                                $size_arr1[] = $key_s->size_id;

                                $size_nme_arr[] = $Page->get_size_name($key_s->size_id);

                            }

                            for($l = 0; $l < sizeof($size_arr1); $l++)
                            {

                            ?>
                            <tr>
                                <th>
                                    <?php


                                    // if($i == 0)
                                    // {
                                        if($customer_nme_count < 2)
                                        {
                                            echo $customer_nme_arr[$i];
                                            $customer_nme_count++;
                                        }
                                        
                                    // }
                                    ?>
                                        
                                </th>
                                <td>
                                    <?php


                                    if($j == 0)
                                    {
                                        if($modal_nme_count < 2)
                                        {
                                            echo $modal_nme_arr[$j];
                                            $modal_nme_count++;
                                        }
                                        
                                    }
                                    ?>
                                        
                                </td>
                                <td>
                                    <?php


                                    if($k == 0)
                                    {
                                        if($category_nme_count < 2)
                                        {
                                            echo $category_nme_arr[$k];
                                            $category_nme_count++;
                                        }
                                        
                                    }
                                    ?>
                                        
                                </td>
                               
                                
                                <td><?php


                                echo $size_nme_arr[$l]; ?></td>
                                <?php
                                $final_val = 0;
                                for($cl = 1; $cl < sizeof($color_nme_arr)+1;$cl++)
                                {

                                    $data = [

                                        'customer_id' => $customer_array[$i],
                                        'type_id' => 4,
                                        'model_id' => $modal_array[$j],
                                        'category_id' => $category_array[$k],
                                        'size_id' => $size_arr1[$l],
                                        'color_id' => $color_id_arr[$cl],
                               
                                    ];

                                    $get_val_all = $Page->get_val_all($data);

                                    $total_val = 0;
                                    
                                    foreach ($get_val_all as $key_val)
                                    {
                                        $total_val+= $key_val->item_qty;
                                    }

                                    $final_val += $total_val;
                                ?>
                                    <td>

                                        <?php

                                        echo $total_val; ?>
                                            
                                    </td>
                                <?php
                                    $total_val = 0;
                                }
                                ?>
                                <td><b><?php

                                        echo $final_val; ?></b></td>

                                       <?php $final_val = 0; ?>

                            </tr>

                            <?php
                            }
                        }
                    }
                }
            }
            ?>
        </tbody>
    </table>

    <?php
    }   
    elseif(!empty($data['customize_customer']) && empty($data['customize_models']))
    {
    ?>
    <table class="table table-bordered my-5 table-responsive">
        <?php
        $colors = $Page->get_all_colors();

        $color_nme_arr = array();
        $color_id_arr = array();

        $d1 = array();
        for($i = 1; $i < sizeof($d1)+1;$i++)
        {
            $color_nme_arr[$i] = "";

            $color_id_arr[$i] = "";
        }


        foreach ($colors as $key_clr )
        {

            $clr_nme = strtolower($key_clr->color_name);
            if($clr_nme == "red")
            {
                $color_nme_arr[1] =  $key_clr->color_name;

                $color_id_arr[1] =  $key_clr->color_id;
            }
            elseif($clr_nme == "black")
            {
                $color_nme_arr[2] =  $key_clr->color_name;

                $color_id_arr[2] =  $key_clr->color_id;
            }
            elseif($clr_nme == "blue")
            {
               $color_nme_arr[3] =  $key_clr->color_name;

               $color_id_arr[3] =  $key_clr->color_id;
            }
            elseif($clr_nme == "yellow")
            {
                $color_nme_arr[4] =  $key_clr->color_name;

                $color_id_arr[4] =  $key_clr->color_id;
            }
            elseif($clr_nme == "green")
            {
                $color_nme_arr[5] =  $key_clr->color_name;

                $color_id_arr[5] =  $key_clr->color_id;
            }
            elseif($clr_nme == "grey")
            {
                $color_nme_arr[6] =  $key_clr->color_name;

                $color_id_arr[6] =  $key_clr->color_id;
            }
            elseif($clr_nme == "white")
            {
                $color_nme_arr[7]  =  $key_clr->color_name;

                $color_id_arr[7] =  $key_clr->color_id;
            }
        }
        ?>
        <thead>
            <th>customer</th>
            <th>model</th>
            <th>category</th>
            <th>size</th>
            <?php
            for($i = 1; $i < sizeof($color_nme_arr)+1;$i++)
            {               
            ?>
                <th class="px-4">
                    <?php echo $color_nme_arr[$i]; ?>                    
                </th>
            <?php
            }
            ?>
            <th>Total</th>
            
        </thead>
        <tbody>
            <?php
            $get_all_customers_temp = $Page->get_all_customers_ne();

            $customer_array = array();

            $customer_nme_arr = array();

            foreach ($get_all_customers_temp as $key_cu) 
            {
                $customer_array[] = $key_cu->customer_id;

                $customer_nme_arr[] = $Page->get_customer_name($key_cu->customer_id);
            }

            if(empty($customer_array))
            {
            ?>
                <tr>
                    <td>No Record found</td>
                </tr>
            <?php
            }
            else
            {
                for($i = 0; $i < sizeof($customer_array); $i++)
                {

                    $customer_nme_count = 1;
                   
                    $data = [

                        'customer_id' => $customer_array[$i],
                        'type_id' => 4
                       
                        ];

                    $get_modal_for_cust = $Page->get_modal_for_cust($data); 

                    $modal_array = array();

                    $modal_nme_arr = array();

                    foreach ($get_modal_for_cust as $key_m)
                    {
                        $modal_array[] = $key_m->model_id;

                        $modal_nme_arr[] = $Page->get_modal_name($key_m->model_id);
                    }

                    for($j = 0; $j < sizeof($modal_array); $j++)
                    { 

                        $modal_nme_count = 1; 

                        $data = [

                            'customer_id' => $customer_array[$i],
                            'type_id' => 4,
                            'model_id' => $modal_array[$j]
                       
                        ];

                        $get_category_for_mo = $Page->get_category_for_mo($data);

                        $category_array = array();

                        $category_nme_arr = array();

                        foreach ($get_category_for_mo as $key_cate)
                        {
                            $category_array[] = $key_cate->category_id;

                            $category_nme_arr[] = $Page->get_category_name($key_cate->category_id);
                        }

                        for($k = 0; $k < sizeof($category_array); $k++)
                        { 

                            $category_nme_count = 1;

                            $data = [

                                'customer_id' => $customer_array[$i],
                                'type_id' => 4,
                                'model_id' => $modal_array[$j],
                                'category_id' => $category_array[$k]
                               
                            ];

                            $get_size_count_cat = $Page->get_size_count_cat($data);

                            $size_arr1 = array();
                            $size_nme_arr = array();

                            foreach ($get_size_count_cat as $key_s)
                            {
                                $size_arr1[] = $key_s->size_id;

                                $size_nme_arr[] = $Page->get_size_name($key_s->size_id);

                            }

                            for($l = 0; $l < sizeof($size_arr1); $l++)
                            {

                            ?>
                            <tr>
                                <th>
                                    <?php


                                    // if($i == 0)
                                    // {
                                        if($customer_nme_count < 2)
                                        {
                                            echo $customer_nme_arr[$i];
                                            $customer_nme_count++;
                                        }
                                        
                                    // }
                                    ?>
                                        
                                </th>
                                <td>
                                    <?php


                                    if($j == 0)
                                    {
                                        if($modal_nme_count < 2)
                                        {
                                            echo $modal_nme_arr[$j];
                                            $modal_nme_count++;
                                        }
                                        
                                    }
                                    ?>
                                        
                                </td>
                                <td>
                                    <?php


                                    if($k == 0)
                                    {
                                        if($category_nme_count < 2)
                                        {
                                            echo $category_nme_arr[$k];
                                            $category_nme_count++;
                                        }
                                        
                                    }
                                    ?>
                                        
                                </td>
                               
                                
                                <td><?php


                                echo $size_nme_arr[$l]; ?></td>
                                <?php
                                $final_val = 0;
                                for($cl = 1; $cl < sizeof($color_nme_arr)+1;$cl++)
                                {

                                    $data = [

                                        'customer_id' => $customer_array[$i],
                                        'type_id' => 4,
                                        'model_id' => $modal_array[$j],
                                        'category_id' => $category_array[$k],
                                        'size_id' => $size_arr1[$l],
                                        'color_id' => $color_id_arr[$cl],
                               
                                    ];

                                    $get_val_all = $Page->get_val_all($data);

                                    $total_val = 0;
                                    
                                    foreach ($get_val_all as $key_val)
                                    {
                                        $total_val+= $key_val->item_qty;
                                    }

                                    $final_val += $total_val;
                                ?>
                                    <td>

                                        <?php

                                        echo $total_val; ?>
                                            
                                    </td>
                                <?php
                                    $total_val = 0;
                                }
                                ?>
                                <td><b><?php

                                        echo $final_val; ?></b></td>

                                       <?php $final_val = 0; ?>

                            </tr>

                            <?php
                            }
                        }
                    }
                }
            }
            ?>
        </tbody>
    </table>


    <?php
        
    }
    elseif(!empty($data['customize_customer']) && !empty($data['customize_models']))
    {

        $model_list = $data['model_list'];
    ?>
        <table class="table table-bordered my-5 table-responsive">
        <?php
        $colors = $Page->get_all_colors();

        $color_nme_arr = array();
        $color_id_arr = array();

        $d1 = array();
        for($i = 1; $i < sizeof($d1)+1;$i++)
        {
            $color_nme_arr[$i] = "";

            $color_id_arr[$i] = "";
        }


        foreach ($colors as $key_clr )
        {

            $clr_nme = strtolower($key_clr->color_name);
            if($clr_nme == "red")
            {
                $color_nme_arr[1] =  $key_clr->color_name;

                $color_id_arr[1] =  $key_clr->color_id;
            }
            elseif($clr_nme == "black")
            {
                $color_nme_arr[2] =  $key_clr->color_name;

                $color_id_arr[2] =  $key_clr->color_id;
            }
            elseif($clr_nme == "blue")
            {
               $color_nme_arr[3] =  $key_clr->color_name;

               $color_id_arr[3] =  $key_clr->color_id;
            }
            elseif($clr_nme == "yellow")
            {
                $color_nme_arr[4] =  $key_clr->color_name;

                $color_id_arr[4] =  $key_clr->color_id;
            }
            elseif($clr_nme == "green")
            {
                $color_nme_arr[5] =  $key_clr->color_name;

                $color_id_arr[5] =  $key_clr->color_id;
            }
            elseif($clr_nme == "grey")
            {
                $color_nme_arr[6] =  $key_clr->color_name;

                $color_id_arr[6] =  $key_clr->color_id;
            }
            elseif($clr_nme == "white")
            {
                $color_nme_arr[7]  =  $key_clr->color_name;

                $color_id_arr[7] =  $key_clr->color_id;
            }
        }
        ?>
        <thead>
            <th>customer</th>
            <th>model</th>
            <th>category</th>
            <th>size</th>
            <?php
            for($i = 1; $i < sizeof($color_nme_arr)+1;$i++)
            {               
            ?>
                <th class="px-4">
                    <?php echo $color_nme_arr[$i]; ?>                    
                </th>
            <?php
            }
            ?>
            <th>Total</th>
            
        </thead>
        <tbody>
            <?php
            $get_all_customers_temp = $Page->get_all_customers_ne();

            $customer_array = array();

            $customer_nme_arr = array();

            foreach ($get_all_customers_temp as $key_cu) 
            {
                $customer_array[] = $key_cu->customer_id;

                $customer_nme_arr[] = $Page->get_customer_name($key_cu->customer_id);
            }
           
            for($i = 0; $i < sizeof($customer_array); $i++)
            {

                $customer_nme_count = 1;
               
                $data = [

                    'customer_id' => $customer_array[$i],
                    'type_id' => 4
                   
                    ];

                $get_modal_for_cust = $Page->get_modal_for_cust($data); 

                $modal_array = array();

                $modal_nme_arr = array();

                foreach ($model_list as $key_m)
                {
                    $modal_array[] = $key_m;

                    $modal_nme_arr[] = $Page->get_modal_name($key_m);
                }

                for($j = 0; $j < sizeof($modal_array); $j++)
                { 

                    $modal_nme_count = 1; 

                    $data = [

                        'customer_id' => $customer_array[$i],
                        'type_id' => 4,
                        'model_id' => $modal_array[$j]
                   
                    ];

                    $get_category_for_mo = $Page->get_category_for_mo($data);

                    $category_array = array();

                    $category_nme_arr = array();

                    foreach ($get_category_for_mo as $key_cate)
                    {
                        $category_array[] = $key_cate->category_id;

                        $category_nme_arr[] = $Page->get_category_name($key_cate->category_id);
                    }

                    if(empty($category_array))
                    {
                    ?>
                        <tr>
                            <td>No Record found</td>
                        </tr>
                    <?php
                    }
                    else
                    {

                        for($k = 0; $k < sizeof($category_array); $k++)
                        { 

                            $category_nme_count = 1;

                            $data = [

                                'customer_id' => $customer_array[$i],
                                'type_id' => 4,
                                'model_id' => $modal_array[$j],
                                'category_id' => $category_array[$k]
                               
                            ];

                            $get_size_count_cat = $Page->get_size_count_cat($data);

                            $size_arr1 = array();
                            $size_nme_arr = array();

                            foreach ($get_size_count_cat as $key_s)
                            {
                                $size_arr1[] = $key_s->size_id;

                                $size_nme_arr[] = $Page->get_size_name($key_s->size_id);

                            }

                            for($l = 0; $l < sizeof($size_arr1); $l++)
                            {

                            ?>
                            <tr>
                                <th>
                                    <?php


                                    // if($i == 0)
                                    // {
                                        if($customer_nme_count < 2)
                                        {
                                            echo $customer_nme_arr[$i];
                                            $customer_nme_count++;
                                        }
                                        
                                    // }
                                    ?>
                                        
                                </th>
                                <td>
                                    <?php


                                    if($j == 0)
                                    {
                                        if($modal_nme_count < 2)
                                        {
                                            echo $modal_nme_arr[$j];
                                            $modal_nme_count++;
                                        }
                                        
                                    }
                                    ?>
                                        
                                </td>
                                <td>
                                    <?php


                                    if($k == 0)
                                    {
                                        if($category_nme_count < 2)
                                        {
                                            echo $category_nme_arr[$k];
                                            $category_nme_count++;
                                        }
                                        
                                    }
                                    ?>
                                        
                                </td>
                               
                                
                                <td><?php


                                echo $size_nme_arr[$l]; ?></td>
                                <?php
                                $final_val = 0;
                                for($cl = 1; $cl < sizeof($color_nme_arr)+1;$cl++)
                                {

                                    $data = [

                                        'customer_id' => $customer_array[$i],
                                        'type_id' => 4,
                                        'model_id' => $modal_array[$j],
                                        'category_id' => $category_array[$k],
                                        'size_id' => $size_arr1[$l],
                                        'color_id' => $color_id_arr[$cl],
                               
                                    ];

                                    $get_val_all = $Page->get_val_all($data);

                                    $total_val = 0;
                                    
                                    foreach ($get_val_all as $key_val)
                                    {
                                        $total_val+= $key_val->item_qty;
                                    }

                                    $final_val += $total_val;
                                ?>
                                    <td>

                                        <?php

                                        echo $total_val; ?>
                                            
                                    </td>
                                <?php
                                    $total_val = 0;
                                }
                                ?>
                                <td><b><?php

                                        echo $final_val; ?></b></td>

                                       <?php $final_val = 0; ?>

                            </tr>

                            <?php
                            }
                        }
                    }
                }
            }
            
            ?>
        </tbody>
    </table>

    <?php
    }
    }
    ?>
                      

         




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

    $("#form_submit").click(function()
    {
        var customer_list = $("#customer_list").val();
        
        var model_list = $("#model_list").val();

        if(customer_list == '' && model_list == '')
        {
            
            $( "#customer_form" ).submit();
        }
        else if(customer_list == '')
        {
            alert("Please select a customer");
        }
        else if(model_list == '')
        {
            $( "#customer_form" ).submit();
        }
        else if(customer_list != '' && model_list != '')
        {
            $( "#customer_form" ).submit();
        }



        
    });


</script>

