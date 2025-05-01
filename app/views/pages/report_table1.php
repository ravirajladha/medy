<?php require APPROOT . '/views/inc/header.php'; ?>

<?php $d = new Page;  ?>

<style type="text/css">

    .aaa
    {
        overflow-x: scroll;
       

    }
</style>
<!-- Start Breadcrumbbar -->                    
<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">All Wires Stock Report</h4>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo URLROOT;?>/assets/pages/index">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo URLROOT;?>/assets/pages/index">All Wires Stock Report</a></li>
                
                </ol>
            </div>
        </div>
    </div>          
</div>
<!-- End Breadcrumbbar -->

<div class="contentbar">                
    <!-- Start row -->
    <div class="row">
        <!-- Start col -->
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="container">
                 <br>
                   
                    <div id="replace_id"> 

                    <h3 style='text-align: center;' class="mb-3" >All Wires Stock Report</h3>


                             

                                <?php

                                $d1 = array();
                        
                                $a = 1;

                                $aa = array();

                                $aa1 = array();

                                
                    
                                foreach ($data['get_all_colors'] as $key )
                                {

                                    $clr_nme = strtolower($key->color_name);
                                    if($clr_nme == "red")
                                    {
                                        $aa[1] =  $key->color_name;

                                        $aa1[1] =  $key->color_id;
                                    }
                                    elseif($clr_nme == "black")
                                    {
                                        $aa[2] =  $key->color_name;

                                        $aa1[2] =  $key->color_id;
                                    }
                                    elseif($clr_nme == "blue")
                                    {
                                       $aa[3] =  $key->color_name;

                                       $aa1[3] =  $key->color_id;
                                    }
                                    elseif($clr_nme == "yellow")
                                    {
                                        $aa[4] =  $key->color_name;

                                        $aa1[4] =  $key->color_id;
                                    }
                                    elseif($clr_nme == "green")
                                    {
                                        $aa[5] =  $key->color_name;

                                        $aa1[5] =  $key->color_id;
                                    }
                                    elseif($clr_nme == "grey")
                                    {
                                        $aa[6] =  $key->color_name;

                                        $aa1[6] =  $key->color_id;
                                    }
                                    elseif($clr_nme == "white")
                                    {
                                        $aa[7]  =  $key->color_name;

                                        $aa1[7] =  $key->color_id;
                                    }
                                }

                                // var_dump($aa);
                                // echo "<br>";
                                // print_r($aa1);
                                // echo "<br>";

                                // echo $aa[7];
                                ?>

                <div class="aaa">

                <table class='table table-bordered' id="aa" style="margin-top: 30px;"> 

                    <thead> 
                        <tr>
                            <th>Model</th>
                            <th>Catagory</th>
                            <th>Size</th>
                            <?php
                            $size_count = $data['get_total_sizes_count']; 
                            for($i = 1; $i < sizeof($aa)+1;$i++)
                            {
                               
                            ?>
                            <th class="px-4">
                                <?php echo $aa[$i]; ?></th>
                            <?php } ?>
                          
                            <th class="px-4">Total</th>
                            <!-- <th style="font-size: 12px;">Category Total</th>  -->  
                        </tr> 
                        <tr>
                    </thead>
                    <tbody>

                        <?php

                        $modal_arr_name = array();

                        $modal_arr_id = array();

                        foreach ($data['get_all_models'] as $key_mo)
                        {
                           $modal_arr_name[] = $key_mo->model_name;
                           $modal_arr_id[] = $key_mo->model_id;
                           
                        }

                        for($i = 0; $i < sizeof($modal_arr_id); $i++)
                        { 
                            $model_nme_count = 1;

                            $data = [

                                'model_id' => $modal_arr_id[$i],
                                'type_id' => 4                   
                            ];

                            $get_category_for_modal = $d->get_category_for_modal($data);

                            $category_arr_name = array();

                            $category_arr_id = array(); 

                            foreach ($get_category_for_modal as $key_cate)
                            {
                                $category_arr_name[] = $key_cate->category_name;
                                $category_arr_id[] = $key_cate->category_id;
                           
                            }

                            for($j = 0; $j < sizeof($category_arr_id); $j++)
                            {
                                $category_nme_count = 1;

                                $data = [

                                    'model_id' => $modal_arr_id[$i],
                                    'category_id' => $category_arr_id[$j],
                                    'type_id' => 4                   
                                ];

                                $get_sizes_for_category = $d->get_sizes_for_category($data);

                                $size_arr_id = array();
                                $size_nme_arr = array();

                                foreach ($get_sizes_for_category as $key_sizes)
                                {
                                    // $category_arr_name[] = $key_cate->category_name;
                                   
                                   $size_arr_id[] = $key_sizes->size_id;

                                   if(!empty($key_sizes->size_id))
                                   {
                                        $size_nme_arr[] = $d->get_size_name($key_sizes->size_id);
                                   }

                                   

                                    
                               
                                }

                                for($k = 0; $k < sizeof($size_arr_id); $k++)
                                {
 
                                ?>
                                        <tr>
                                            <th>
                                                <?php

                                                    if($model_nme_count < 2)
                                                    {
                                                        echo $modal_arr_name[$i];
                                                        $model_nme_count++;
                                                    }

                                                    
                                                ?>
                                                
                                            </th>
                                            <td>
                                                <?php

                                                    if($category_nme_count < 2)
                                                    {
                                                        echo $category_arr_name[$j];
                                                        $category_nme_count++;
                                                    }
                                                    
                                                    ?>
                                                    
                                            </td>
                                            <td>
                                                <?php 

                                                if(empty($size_arr_id[$k]))
                                                {
                                                    echo "--";
                                                }
                                                else
                                                {
                                                    echo $size_nme_arr[$k];
                                                }


                                                 ?></td>

                                            <?php

                                            $sum_boxes = 0;

                                            $sum_pieces = 0;

                                            $sum_total = 0;

                                            for($cl = 1; $cl < sizeof($aa1)+1;$cl++)
                                            {


                                                $data = [
                                                    'model_id' => $modal_arr_id[$i],
                                                    'category_new_id' => $category_arr_id[$j],
                                                    'size_id' => $size_arr_id[$k],
                                                    'color_id' => $aa1[$cl]

                                                    ];

                                                $get_fistColVal = $d->get_fistColVal($data);

                                                $stock_count_boxes = 0;
                                                $stock_count_pieces = 0;

                                                $get_each_box_count1 = 0;

                                                $get_each_box_count2 = 0;

                                                

                                                foreach ($get_fistColVal as $key)
                                                {
                                                    $get_stock_count_boxes = $d->get_stock_count_boxes($key->id);

                                                    $get_each_box_count = $d->get_each_box_count($key->id);

                                                    if(!empty($get_each_box_count->qty))
                                                    {
                                                        $get_each_box_count1 = $get_each_box_count->qty * $get_stock_count_boxes;
                                                    }

                                                    
                                                   
                                                    $stock_count_boxes+= $get_stock_count_boxes;



                                                    $get_stock_count_pieces = $d->get_stock_count_pieces($key->id);

                                                    $stock_count_pieces+= $get_stock_count_pieces;
                                        
                                                }

                                                $get_each_box_count2 = $get_each_box_count1 + $stock_count_pieces;

                                                $sum_boxes+= $stock_count_boxes;

                                                $sum_pieces+= $stock_count_pieces;

                                                $sum_total+= $get_each_box_count2;

                                            ?>
                                            <td>B (<?php echo $stock_count_boxes; ?>) <br>
                                                P (<?php echo $stock_count_pieces; ?>) <br>
                                                T (<?php echo $get_each_box_count2; ?>)</td>

                                            <?php
                                                $stock_count_boxes = 0;
                                                $stock_count_pieces = 0;
                                                $get_each_box_count1 = 0;
                                                $get_each_box_count2 = 0;
                                            }
                                            ?>
                                            <td>
                                                <b>
                                                B (<?php echo $sum_boxes; ?>) <br>
                                                P (<?php echo $sum_pieces; ?>) <br>
                                                T (<?php echo $sum_total; ?>)
                                                </b>
                                            </td>
                                        </tr>
                                <?php
                                    
                                    }
                                }
                            }
                            ?>




                    </tbody>
                </table>

                </div>
                            

                        </div>


                </div>
            </div>
        </div>
    </div>
</div>

       
 

<?php require APPROOT . '/views/inc/footer.php'; ?>





