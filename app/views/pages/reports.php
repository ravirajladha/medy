<?php require APPROOT . '/views/inc/header.php'; ?>
            <div class="breadcrumbbar">
                <div class="row align-items-center">
                    <div class="col-md-8 col-lg-8">
                        <h4 class="page-title">Reports</h4>
                        <div class="breadcrumb-list">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo URLROOT;?>/pages/index">Home</a></li>
                             
                            </ol>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                                            
                    </div>
                </div>          
            </div>
            <div class="contentbar">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label>Purchase</label>
                                     </div>
                                    <div class="col-md-12">
                                        <label><a href="<?php echo URLROOT;?>/pages/item_by_category5">Purchase Report</a></label>
                                        <br>
                                        <label><a href="<?php echo URLROOT;?>/pages/item_by_category4">Non purchase Report</a></label>
                                        <br>
                                        <label><a href="<?php echo URLROOT;?>/pages/item_by_category6">Model wise non-purchase Report</a></label>
                                        <br>
                                        
                                     </div>
                                 </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label>Stock</label>
                                     </div>
                                    <div class="col-md-12">
                                        <label><a href="<?php echo URLROOT;?>/pages/item_by_category">Item by Category Report</a></label>
                                        <br>
                                        <label><a href="<?php echo URLROOT;?>/pages/item_by_category1">Calculating Item Age Report</a></label>
                                       
                                     </div>
                                 </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label>Sales</label>
                                     </div>
                                    <div class="col-md-12">
                                        <label><a href="<?php echo URLROOT;?>/pages/item_by_category2">Sort By Sales Report</a></label>
                                        <br>
                                        <label><a href="<?php echo URLROOT;?>/pages/customerwise_sales_report">All Customer Wise Sales Report</a></label>
                                        <br>
                                        <label><a href="<?php echo URLROOT;?>/pages/customerwise_sales_report2">All Customers Sales Report (Table)</a></label>
                                         <br>
                                        <label><a href="<?php echo URLROOT;?>/pages/customerwise_sales_report2_time">Datewise Customers Sales Report</a></label>
                                        <br>
                                        <label><a href="<?php echo URLROOT;?>/pages/item_by_category7"> Sales Order Report</a></label>
                                        <label><a href="<?php echo URLROOT;?>/pages/item_by_category8"> Sales Order Pending Report</a></label>
                                        <br>
                                     </div>
                                 </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label>Direct package</label>
                                     </div>
                                    <div class="col-md-12">
                                        <label><a href="<?php echo URLROOT;?>/pages/customerwise_sales_reportp">All Customer Wise, Direct package Report</a></label>
                                        <br>
                                        <label><a href="<?php echo URLROOT;?>/pages/customerwise_sales_report2p">All Customers Direct package Report (Table)</a></label>
                                        <br>
                                        <label><a href="<?php echo URLROOT;?>/pages/customerwise_sales_report2_time_p">Datewise Customers Direct package Report</a></label>
                                        <br>
                                        <label><a href="<?php echo URLROOT;?>/pages/item_by_category7P"> Direct package Order Report</a></label>
                                        <br>
                                     </div>
                                 </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>

                <div class="row" style="display: none;">
                    <div class="col-lg-4">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label>Sales</label>
                                     </div>
                                    <div class="col-md-12">
                                        <label><a href="<?php echo URLROOT;?>/pages/sales_by_customer">Sales by Customer</a></label>
                                     </div>
                                     <div class="col-md-12">
                                          <label><a href="<?php echo URLROOT;?>/pages/sales_by_item"> Sales by Item</a></label>
                                     </div>
                                      <div class="col-md-12">
                                          <label><a href="<?php echo URLROOT;?>/pages/order_filfillment_by_item">Order Filfillment by item</a></label>
                                     </div>
                                      <div class="col-md-12">
                                          <label><a href="<?php echo URLROOT;?>/pages/sales_return_history">Sales Return History</a></label>
                                     </div>
                                     <div class="col-md-12">
                                          <label><a href="<?php echo URLROOT;?>/pages/sales_by_sales_person">Sales by Sales Person</a></label>
                                     </div>
                                     <div class="col-md-12">
                                          <label><a href="<?php echo URLROOT;?>/pages/packing_history">Packing History</a></label>
                                     </div>
                                 </div>
                            </div>
                        </div>
                    </div> 
                    <div class="col-lg-4">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 ">
                                        <a><label>Inventory</label></a>
                                     </div>
                                    <div class="col-md-12 ">
                                        <label><a href="<?php echo URLROOT;?>/pages/inventory_summary">Inventory Summary</a></label>
                                     </div>
                                     <div class="col-md-12">
                                          <label><a href="<?php echo URLROOT;?>/pages/Inventory_Valuation_Summary"> Inventory Valuation  Summary</a></label>
                                     </div>
                                      <div class="col-md-12">
                                          <label><a href="<?php echo URLROOT;?>/pages/fifo">FIFO Cost Lot Tracking</a></label>
                                     </div>
                                      <div class="col-md-12">
                                          <label><a href="<?php echo URLROOT;?>/pages/inventory_aging_summary">Inventory Aging Summary</a></label>
                                     </div>
                                     <div class="col-md-12">
                                          <label><a href="<?php echo URLROOT;?>/pages/product_sales_report">Product Sales Report</a></label>
                                     </div>
                                     <div class="col-md-12">
                                          <label><a href="<?php echo URLROOT;?>/pages/active_purchase_order_report">Active Purchase Order Report</a></label>
                                     </div>
                                       <div class="col-md-12">
                                          <label><a href="<?php echo URLROOT;?>/pages/stock_summary_report">Stock Summary Report</a></label>
                                     </div>
                                 </div>
                            </div>
                        </div>
                    </div> 
                    <div class="col-lg-4">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 ">
                                        <a><label>Receivables</label></a>
                                     </div>
                                    <div class="col-md-12 ">
                                        <label><a href="<?php echo URLROOT;?>/pages/customer_balances">Customer Balances</a></label>
                                     </div>
                                     <div class="col-md-12">
                                          <label><a href="<?php echo URLROOT;?>/pages/invoice_details"> Invoice Deatils </a></label>
                                     </div>
                                      <div class="col-md-12">
                                          <label><a href="<?php echo URLROOT;?>/pages/sales_order_details">Sales Order Details</a></label>
                                     </div>
                                      <div class="col-md-12">
                                          <label><a href="<?php echo URLROOT;?>/pages/delivery_challan_details">Delivery Challan Details</a></label>
                                     </div>
                                     <div class="col-md-12">
                                          <label><a href="<?php echo URLROOT;?>/pages/receivable_Summary">Receivable Summary</a></label>
                                     </div>
                                     <div class="col-md-12">
                                          <label><a href="<?php echo URLROOT;?>/pages/Receivable_Details">Receivable Details</a></label>
                                     </div>
                                 </div>
                            </div>
                        </div>
                    </div> 
                    <div class="col-lg-4">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 ">
                                        <a><label>Payments Received</label></a>
                                     </div>
                                    <div class="col-md-12 ">
                                        <label><a href="<?php echo URLROOT;?>/pages/payments_received">Payments Received</a></label>
                                     </div>
                                 </div>
                            </div>
                        </div>
                    </div> 
                    <div class="col-lg-4">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 ">
                                        <a><label>Payables</label></a>
                                     </div>
                                    <div class="col-md-12 ">
                                        <label><a href="<?php echo URLROOT;?>/pages/vendor_balances">Vendor Balances</a></label>
                                     </div>
                                     <div class="col-md-12">
                                          <label><a href="<?php echo URLROOT;?>/pages/payments_made"> Payments Made </a></label>
                                     </div>
                                      <div class="col-md-12">
                                          <label><a href="<?php echo URLROOT;?>/pages/bill_details"> Bill Details</a></label>
                                     </div>
                                      <div class="col-md-12">
                                          <label><a href="<?php echo URLROOT;?>/pages/purchase_order_details">Purchase Order Details </a></label>
                                     </div>
                                      <div class="col-md-12">
                                          <label><a href="<?php echo URLROOT;?>/pages/purchase_order_by_vender">Purchase Orders by Vendor</a></label>
                                     </div>
                                 </div>
                            </div>
                        </div>
                    </div> 
                    <div class="col-lg-4">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 ">
                                        <a><label>Purchases and Expenses</label></a>
                                     </div>
                                    <div class="col-md-12 ">
                                        <label><a href="<?php echo URLROOT;?>/pages/purchases_by_item">Purchases by item</a></label>
                                     </div>
                                     <div class="col-md-12">
                                          <label><a href="<?php echo URLROOT;?>/pages/receive_history"> Receive History</a></label>
                                     </div>
                                 </div>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
<?php if(isset($_SESSION['success'])){ ?>
    <script type="text/javascript">
        swal("<?php echo $_SESSION['success']; ?>");
    </script>
<?php } unset($_SESSION['success']); ?>