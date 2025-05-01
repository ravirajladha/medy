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
            <h4 class="page-title">Wires Report</h4>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo URLROOT;?>/assets/pages/index">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo URLROOT;?>/assets/pages/index">Wires Report</a></li>
                
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

                    <h3 style='text-align: center;' class="mb-3">Wires report</h3>

                      <center><select name="year" id="mySelect" onChange="yearChangeHandler" class=" mb-4" >

                                <option disabled selected="" style="color: white;">--SELECT A MODEL---</option>
                                <?php


                                foreach ($data['get_all_models'] as $key1)
                                {
                                ?>
                                <option value="<?php echo $key1->model_id; ?>"><?php echo $key1->model_name; ?></option>
                            
                                <?php
                                }
                                ?>
                            </select>
                            </center>

                             <div class="aaa">

                            <table class='table table-bordered' id="aa"> 

                                <?php

                                $get_total_sizes = $d->get_total_sizes();

                                        $k = 1;

                                        foreach ($get_total_sizes as $key)
                                        {
                                           $size_arr[$k] = $key->size_name;
                                           $size_id_arr[$k] = $key->size_id;
                                           $k++;
                                        }

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



                                    if(empty($data['model_details']))
                                    {
                                        ?>
                                        <tr>
                                            <td>No Record found</td>
                                        </tr>
                                        <?php
                                    }
                                    else
                                    {

                                        

                                        $l = 1;
                                        foreach ($data['get_all_colors'] as $key)
                                        {
                                            $color_arr[$l] = $key->color_id;
                                            $l++;
                                        }


                                        foreach ($data['model_details'] as $key1)
                                        {
                                            
                                            $get_modelWise_category_count = $d->get_modelWise_category_count($key1->model_id);



                                            if($get_modelWise_category_count == 1)
                                            {
                                                 $model_rowSpan_value = $size_count;

                                            }
                                            else
                                            {
                                                $model_rowSpan_value = $get_modelWise_category_count * $size_count;
                                            } 

                                            $get_modelWise_category_data = $d->get_modelWise_category_data($key1->model_id);

                                            $j = 1;

                                            foreach ($get_modelWise_category_data as $key)
                                            {
                                               $d_arr[$j] = $key->category_name;

                                               $cat_id_arr[$j] = $key->category_id;

                                               $j++;
                                            }
  

                                            for($i = 1; $i < sizeof($d_arr) + 1; $i++)
                                            {
                                           
                                            ?>
                                                <!-- 1st row -->
                                                <tr>
                                                    <?php if($i == 1)
                                                    { 
                                                    ?>
                                                        <th rowspan="<?php echo $model_rowSpan_value; ?>" style="font-weight: 550;border-bottom: 2px solid black!important;" >
                                                    <?php 
                                                    echo $key1->model_name;
                                                    ?>
                                                        </th>
                                                    <?php 
                                                    } 
                                                    ?>
             
                                                
                                                        
                                                    <td rowspan="<?php echo $size_count; ?>" style="border-bottom: 2px solid black;font-weight: 550;">
                                                        
                                                        <?php echo $d_arr[$i]; ?>
                                                    </td>

                                                    <?php
                                                   
                                                    ?>
                                                    <td style="font-weight: 500;"> <?php echo $size_arr[1]; ?></td>

                                                    <?php

                                                    $get_fistColVal = 0;

                                                    $sum_boxes = 0;

                                                    $sum_pieces = 0;

                                                    $stock_count_boxes = 0;

                                                    $stock_count_pieces = 0;

                                                    for($s = 1; $s <= sizeof($aa1); $s++)
                                                    {
                                                        $data = [
                                                        'model_id' => $key1->model_id,
                                                        'category_new_id' => $cat_id_arr[$i],
                                                        'size_id' => $size_id_arr[1],
                                                        'color_id' => $aa1[$s]

                                                        ];

                                                        $get_fistColVal = $d->get_fistColVal($data);

                                                        foreach ($get_fistColVal as $key)
                                                        {
                                                            $get_stock_count_boxes = $d->get_stock_count_boxes($key->id);
                                                            $stock_count_boxes+= $get_stock_count_boxes;

                                                            $get_stock_count_pieces = $d->get_stock_count_pieces($key->id);
                                                            $stock_count_pieces+= $get_stock_count_pieces;
                                                        }
                                                          
                                                       $sum_boxes+= $stock_count_boxes;

                                                       $sum_pieces+= $stock_count_pieces;

                                                        ?>
                                                        <td align="center">B (<?php echo $stock_count_boxes; ?>) <br>
                                                            P (<?php echo $stock_count_pieces; ?>)
                                                        </td>
                                                        
                                                        <?php

                                                        $stock_count_boxes = 0;
                                                        $stock_count_pieces = 0;

                                                        ?>
                                                       <!--  <td align="center">
                                                            <?php  //print_r($sss); 
                                                            echo $aa[$s];
                                                            echo "<br>";
                                                            echo $size_arr[1];
                                                            echo "<br>";
                                                            echo $d_arr[$i];
                                                             ?>
                                                          
                                                        </td> -->

                                                    <?php
                                                    }
                                                    ?>
                                                  

                                                     <td style="font-weight: 520;" align="center">B (<?php echo $sum_boxes; ?>) <br>
                                                            P (<?php echo $sum_pieces; ?>)
                                                        </td>

                                                    <!-- <td style="font-weight: 520;border-bottom: 2px solid black!important;" rowspan="<?php echo $size_count; ?>">1<?php //echo $sum; ?></td>  -->   
                                                      
                                                </tr>

                                                <?php
                                                for($c = 2; $c < $size_count + 1; $c++)
                                                {
                                                ?>

                                                    <?php
                                                    if($c == $size_count)
                                                    {
                                                    ?>
                                                        <!-- 2nd row -->
                                                        <tr style="border-bottom: 2px solid black!important;">

                                                        <?php
                                                    }
                                                    else
                                                    {
                                                    ?>

                                                        <tr>

                                                        <?php
                                                    } ?>
                                                   
                                                    <td style="font-weight: 500;"><?php echo $size_arr[$c]; ?></td>

                                                    <?php

                                                    $sum_boxes = 0;

                                                    $sum_pieces = 0;

                                                    $stock_count_boxes = 0;

                                                    $stock_count_pieces = 0;

                                                    for($s = 1; $s <= sizeof($aa1); $s++)
                                                    {
                                                        $data = [
                                                        'model_id' => $key1->model_id,
                                                        'category_new_id' => $cat_id_arr[$i],
                                                        'size_id' => $size_id_arr[$c],
                                                        'color_id' => $aa1[$s]

                                                        ];

                                                        $get_fistColVal = $d->get_fistColVal($data);

                                                        foreach ($get_fistColVal as $key)
                                                        {
                                                            $get_stock_count_boxes = $d->get_stock_count_boxes($key->id);
                                                            $stock_count_boxes+= $get_stock_count_boxes;

                                                            $get_stock_count_pieces = $d->get_stock_count_pieces($key->id);
                                                            $stock_count_pieces+= $get_stock_count_pieces;
                                                        }
                                                          
                                                       $sum_boxes+= $stock_count_boxes;

                                                       $sum_pieces+= $stock_count_pieces;
                                                        ?>
                                                        <td align="center">B (<?php echo $stock_count_boxes; ?>) <br>
                                                            P (<?php echo $stock_count_pieces; ?>)
                                                        </td>
                                                        <?php

                                                        $stock_count_boxes = 0;
                                                        $stock_count_pieces = 0;

                                                        ?>
                                                       <!--  <td align="center">
                                                            <?php  //print_r($sss); 
                                                            echo $aa[$s];
                                                            echo "<br>";
                                                            echo $size_arr[$c];
                                                            echo "<br>";
                                                            echo $d_arr[$i];
                                                             ?>
                                                          
                                                        </td> -->
                                                    <?php
                                                    }
                                                    ?> 
                                                   
                                                    <td style="font-weight: 520;" align="center">B (<?php echo $sum_boxes; ?>) <br>
                                                            P (<?php echo $sum_pieces; ?>)
                                                        </td>



                                                      
                                                </tr>

                                                <?php
                                                }                                                
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

<script type="text/javascript">


    $('#mySelect').change(function()
    { 
        var value = $(this).val();

        window.location.href = '<?php  echo URLROOT;?>/pages/report_table_val/'+ value;
        
    });

</script>

       
 

<?php require APPROOT . '/views/inc/footer.php'; ?>





