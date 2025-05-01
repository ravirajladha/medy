<?php require APPROOT . '/views/inc/header_for_print.php'; ?>
<style type="text/css">
        @media print
        {
            .pagebreak { page-break-before: always; } /* page-break-after works, as well */
        }
    </style>
      <!-- Start Breadcrumbbar -->                    
                <!-- <div class="breadcrumbbar">
                    <div class="row align-items-center">
                        <div class="col-lg-11">
                            <h4 class="page-title">Calculating item Age</h4>
                            <div class="breadcrumb-list">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="<?php echo URLROOT; ?>/pages/index">Home</a></li>
                                   
                                </ol>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <a class="btn btn-primary" style="color: white" onclick="print_page()"><i class="fa fa-print" aria-hidden="true"></i></a>
                        </div>
                    </div>          
                </div> -->
                <!-- End Breadcrumbbar -->
            <!-- Start Contentbar -->    
            <!-- <div class="contentbar">                 -->
                <!-- Start row -->
                <!-- <div class="row"> -->
                    <!-- Start col -->
                    <div class="col-lg-12">
                        <div class="card m-b-0">
                            <!-- <div class="card-header">                                
                                <div class="row align-items-center">
                                    <div class="col-12">
                                        <center>
                                         <h6><?php echo URLROOT1;?><h6>
                                        <h5 class="card-title mb-0" style="font-size: 28px;">Calculating Item Age</h5>
                                        <br>
                                      
                                            </center>
                                    </div>
                                </div>
                            </div> -->
                            <!-- <div class="container">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row ">
                                                <div class="col-md-3">
                                                   <label >Type</label>
                                                    <input type="text" class="form-control" value="<?php echo $data['c1']->type_name;?>">
                                                </div>
                                                <div class="col-md-3">
                                                  <label>Model</label>
                                                    <input type="text" class="form-control" value="<?php echo $data['s1']->model_name;?>">
                                                </div>
                                                <div class="col-md-3">
                                                  <label>Category</label>
                                                    <input type="text" class="form-control" value="<?php echo $data['s2']->category_name;?>">
                                                </div>
                                                <div class="col-md-3">
                                                  <label>Sub Category</label>
                                                    <input type="text" class="form-control" value="<?php echo $data['s3']->sc_name;?>">
                                                </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div> -->
                            <div class="card-body">
                                <div class="table">
                                    <table class="table table-border">
                                        <thead>
                                            <tr>
                                                <th style="width: 5px;">ID</th>
                                                <th style="width: 200px;">Name</th>
                                                <th style="width: 30px;">Receivable(QTY)</th>
                                                 <th style="width: 30px;">Type</th>
                                                <th style="width: 30px;">Model</th>
                                                <th style="width: 30px;">Category</th>
                                                <th style="width: 30px;">Sub category</th>
                                               
                                                <th style="width: 30px;">Item Age</th>
                                                <th style="width: 30px;">Color</th>
                                                <th style="width: 30px;">Size</th>
                                            </tr>
                                        </thead>
                                        <tbody><?php $sum=0; $da=0; $post = new Page(); ?>
                                            <?php $a=0; foreach ($data['all_it'] as $k) {
                                                $type_id = $post->get_type_name_by_id($k->type_id);
                                                if(empty($type_id)){ $type_id = "--";}else{ $type_id = $type_id->type_name; }
                                                $model_id = $post->get_model_name_by_id($k->model_id);
                                                if(empty($model_id)){ $model_id = "--";}else{ $model_id = $model_id->model_name; }
                                                $category_new_id = $post->get_category_name_by_id($k->category_new_id);
                                                 if(empty($category_new_id)){ $category_new_id = "--";}else{ $category_new_id = $category_new_id->category_name; }
                                                $subcategory_new_id = $post->get_subcategory_name_by_id($k->subcategory_new_id);
                                                if(empty($subcategory_new_id)){ $subcategory_new_id = "--";}else{ $subcategory_new_id = $subcategory_new_id->sc_name; }
                                                     $color_id = $post->get_color_name_by_id($k->color_id);
                                             if(empty($color_id)){$color_id="--";}else{$color_id=$color_id->color_name;}
                                              $size_id=$post->get_size_name_by_id($k->size_id);
                                             if(empty($size_id)){$size_id="--";}else{$size_id=$size_id->size_name;
                                                $dt = date("d-m-Y h:i:s a", strtotime($k->created_at));

                                                $dt = date("d-m-Y h:i:s a", strtotime($k->created_at));
                                                if($k->receive==1){ $rec ="Box(Qty ".$k->qty.")"; }else{ $rec ="Pieces(Qty ".$k->qty.")";}?>
                                            <tr>
                                                    <td style="width: 30px;"><?php echo $k->id;?></td>
                                                    <td style="width: 30px;"><?php echo $k->name;?></td>
                                                    <td style="width: 30px;"><?php echo $rec;?></td>
                                                    <td style="width: 30px;"><?php echo $type_id; ?></td>
                                                    <td style="width: 30px;"><?php echo $model_id ; ?></td>
                                                    <td style="width: 30px;"><?php echo $category_new_id; ?></td>
                                                    <td style="width: 30px;"><?php echo $subcategory_new_id; ?></td>
                                                   
                                                    <td style="width: 30px;"><?php echo $da;?></td>
                                                           <td><?php echo $color_id;?></td>
                                                    <td style="width: 30px;"><?php echo $size_id;?></td>

                                                    
                                            </tr><?php $a++;?>
                                            <?php }}?>
                                            

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- End col -->
               <!--  </div> -->
                <!-- End row -->
           <!--  </div> -->
            <!-- End Contentbar -->

<?php require APPROOT . '/views/inc/footer_for_print.php'; ?>
<script type="text/javascript">
    function print_page()
    {
        window.print();
    }
</script>
<script type="text/javascript">
       window.print();
        var mediaQueryList = window.matchMedia('print');
        mediaQueryList.addListener(function(mql) {
            if (mql.matches) {
                console.log('before print dialog open');
            } else {
                history.back();
            }
        });
</script>
