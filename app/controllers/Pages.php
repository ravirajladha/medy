    <?php
    class Pages extends Controller
    {
        public function __construct()
        {
            
            // $_SESSION['user_type'] = 0;
            // $_SESSION['user_id'] = $_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no'];
            // $_SESSION['user_email'] = $_SESSION['email'];
            // $_SESSION['user_all'] = $_SESSION['user_single'];
            // $_SESSION['ctype'] = 3;
            // $_SESSION['db_name'] = 87;     
            if (isset($_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no'])) {
            } else {
                redirect('users/login');
            }      
            $this->pageModel = $this->model('Page');            
            $this->userModel = $this->model('User');
        }
        public function gl()
        {
            $this->pageModel->reselect_all_sessions();
            $this->view('pages/gl');
        }
        public function index()
        {   $a=$b=$c=$d=0;
            $gt=0;
            $Quantity_Ordered = $this->pageModel->all_total_quantity_ordered();
            foreach ($Quantity_Ordered as $q) 
            {
                $total_qty = explode('|||', $q->total_qty);
                for ($i=0; $i <sizeof($total_qty); $i++) 
                { 
                    $a = $a + (int)$total_qty[$i];   
                }
                $gt = $gt + $q->grand_total;
            }
            $Quantity_Ordered = $a;
            $p = $this->pageModel->to_be_packed();
            foreach ($p as $k) 
            {
                $item_to_pack = explode('|||', $k->item_to_pack);
                for ($i=0; $i <sizeof($item_to_pack); $i++) 
                { 
                    $b = $b + (int)$item_to_pack[$i];   
                }
            }
            $p = $b;
            $s = $this->pageModel->to_be_shipped();
            $b=0;
            foreach ($s as $k) 
            {
                $item_packed = explode('|||', $k->item_packed);
                for ($i=0; $i <sizeof($item_packed); $i++) 
                { 
                    $b = $b + $item_packed[$i];   
                }
            }
            $s = $b;
            $d = $this->pageModel->to_be_delivered();
            $b=0;
            foreach ($d as $k) 
            {
                $item_packed = explode('|||', $k->item_packed);
                for ($i=0; $i <sizeof($item_packed); $i++) 
                { 
                    $b = $b + $item_packed[$i];   
                }
            }
            $d = $b;
            $inv = $this->pageModel->to_be_invoiced();
            $b=0;
            foreach ($inv as $k) 
            {
                $b = $b + 1;
            }
            $inv = $b;
            $data = [
                'on_hand' => $this->pageModel->all_stock_count(),
                'rec' => $this->pageModel->all_rem_stock_count(),
                'pack' => $p,
                'ship' => $s,
                'deliver' => $d,
                'invoice' => $inv,
                'p_total_qty' => $Quantity_Ordered,
                'p_total_price' => $gt, 
                'sales' => $this->pageModel->get_all_sales_order_for_index(),
            ];

            $this->view('pages/index', $data);
        }

        //function start from here

        public function add_purchase_order()
        {
            $this->pageModel->deleteAllTempData();
            $this->pageModel->deleteAllTempData();
            $this->pageModel->deleteAllTempData();
            $data = [  'vendor' =>$this->pageModel->get_all_vendor(),
                        'cdetails' => $this->pageModel->get_company_details(),
                        'all_items' => $this->pageModel->get_all_items_for_dropdown(),
                        'cat' => $this->pageModel->getAllCategoriesDb(),
                        'cat1' => $this->pageModel->getAllCategoriesDb2(),
                        'cat2' => $this->pageModel->getAllCategoriesDb3(),
                        'cat3' => $this->pageModel->getAllCategoriesDb4(),
                        'type' => $this->pageModel->getAlltypeDb(),
                        'model' => $this->pageModel->getAllCategoriesDb_model(),
                        'cat_new' => $this->pageModel->getAllCategoriesDb_new(),
                        'subcat_new' => $this->pageModel->getAllsubCategoriesDb_new(),
                        'color' => $this->pageModel->getAllcolorDb_new(),
                        'size' => $this->pageModel->getAllsizeDb_new(),
                        'all_mfg' => $this->pageModel->getallmfg(),
                    ];
           
            $this->view('pages/add_purchase_order',$data);
        }

        public function create_purchase_order()
        {
            $item_id = $_POST['itemId'];
            $item = $_POST['product'];
            $receivable = $_POST['receivable'];
            $perUnitQty = $_POST['perUnit'];
            $actQty = $_POST['actQty'];
            $totalQty = $_POST['actQty'];
            $rowPrice = $_POST['price'];
            $rowTotal = $_POST['total'];
            if(empty($item_id))
            {}else
            {
                $this->pageModel->saveTheTempData($item_id,$item, $receivable, $perUnitQty, $actQty, $totalQty, $rowPrice, $rowTotal);
            }
            $tempId = md5(uniqid());
            $z = $this->pageModel->check_temp_data_count();
            if(empty($z))
            {
                 $_SESSION['success'] = 'Enter all fields'; 
                 redirect('pages/add_purchase_order');
            }
            else
            {
                $data = [ 
                            'vendor' => $_POST['vendor'],
                            'deliver_to' => $_POST['deliver_to'],
                            'purchase_order' => $_POST['purchase_order'],
                            'reference'=> $_POST['reference'],
                            'ndate' => $_POST['ndate'],
                            'expected_delivery_date' => $_POST['expected_delivery_date'],
                            'shipment_preference' => $_POST['shipment_preference'],
                            'payment_terms' => $_POST['payment_terms'],
                            'delivery_method' => $_POST['delivery_method'],
                            'salesperson' => $_POST['salesperson'],
                            'customer_notes' => $_POST['customer_notes'],
                            't_and_c' => $_POST['t_and_c'],
                            'vendor_id' => $_POST['vendor_id'],
                            'tempId' => $tempId,
                            'sub_total' => $_POST['sub_total'],
                            'tax' => $_POST['tax'],
                            'discount' => $_POST['discount'],
                            'discount_amount' => $_POST['discount_amount'],
                            'tax_amount' => $_POST['tax_amount'],
                            'total_amount' => $_POST['total_amount'],
                            'bill_address' => $_POST['bill_address'],
                        ];
                $tId = $this->pageModel->add_purchase_order_details($data);
                $this->pageModel->saveThePurchaseOrderItemDetails($tId, $data);
                $_SESSION['success'] = 'Purchase Order Created Successfully'; 
                redirect('pages/purchase_order');
            }
        }
        

        public function purchase_order()
        {
            $data = [ 
                        'all_pur' =>$this->pageModel->get_all_pur()
                    ];
            $this->view('pages/purchase_order',$data);
        }

        public function purchase_delete($id)
        {
            $this->pageModel->del_purchase($id);
            $_SESSION['success'] = "Purchase Order Deleted Successfully";
            redirect('pages/purchase_order');
        }
        public function edit_purchase_order($id)
        {
            $data = [ 
                        'pur' =>$this->pageModel->get_single_pur($id)
                    ];
            $this->view('pages/edit_purchase_order',$data);
        }

        public function stocks()
        {
            $data = [ 
                        'stock' =>$this->pageModel->get_all_stock()
                    ];
            $this->view('pages/stocks',$data);
        }

        public function add_stock()
        {
            $id = $_POST['prod_id'];
            $s = $this->pageModel->get_single_pur($id);
            $rec = $_POST['price1'];
            $batch = $_POST['batch'];

            $this->pageModel->add_stock_add($s, $rec, $batch);
            $_SESSION['success'] = "Stock Updated";
            redirect('pages/stocks');
        }

        public function addvenders()
        {
            $all_mfg = $this->pageModel->getAllmfg();
            $data = [
                        'all_mfg' => $all_mfg,
                    ];
            $this->view('pages/addvenders',$data);
        }
        public function all_venders()
        {
            $data = [
                'vendor' => $this->pageModel->get_all_vender()
            ];
            $this->view('pages/all_venders', $data);
        }

        public function saveTheVendorDetails()
    {
        $data = [
            'primarySalutation' => $_POST['primarySalutation'],
            'firstName' => $_POST['firstName'],
            'lastName' => $_POST['lastName'],
            'compName' => $_POST['compName'],
            'dispName' => $_POST['dispName'],
            'venEmail' => $_POST['venEmail'],
            'vendPhoneHome' => $_POST['vendPhoneHome'],
            'vendPhoneWork' => $_POST['vendPhoneWork'],
            'vendWeb' => $_POST['vendWeb'],
            'vendCurrency' => $_POST['vendCurrency'],
            'vendPayment' => $_POST['vendPayment'],
            'facebook' => $_POST['facebook'],
            'twittetr' => $_POST['twittetr'],
            'attension' => $_POST['attension'],
            'country' => $_POST['country'],
            'street1' => $_POST['street1'],
            'street2' => $_POST['street2'],
            'city' => $_POST['city'],
            'state' => $_POST['state'],
            'zipcode' => $_POST['zipcode'],
            'phoneAdd' => $_POST['phoneAdd'],
            'fax' => $_POST['fax'],
            'contSalu' => $_POST['contSalu'],
            'contFirstname' => $_POST['contFirstname'],
            'contLastName' => $_POST['contLastName'],
            'contEmail' => $_POST['contEmail'],
            'contWorkPhone' => $_POST['contWorkPhone'],
            'contWorkMobile' => $_POST['contWorkMobile'],
            'gst' => $_POST['gst'],
            'aadhar' => $_POST['aadhar'],
            'passport' => $_POST['passport'],
            'dob' => $_POST['dob'],
            'aniversary' => $_POST['aniversary'],
            'blood' => $_POST['blood'],
            'mfg_sort' => implode("|", $_POST['mfg_sort']),
        ];
        $this->pageModel->saveTheVendorDetailsDb($data);
        $_SESSION['success'] = "Vendor Added successfully";
        redirect('pages/all_venders');
    }

        public function print_purchase($id)
        {
             $data = [ 
                        'pur' =>$this->pageModel->get_single_pur($id)
                    ];
            $this->view('pages/purchase_print',$data);
        }

        public function add_customer()
        {
            $this->view('pages/addcustomer');
        }
        public function create_customer()
        {
            $c_type = "";
            if (isset($_POST['business'])) 
            {
                $c_type = "Business";
            }
            elseif (isset($_POST['business'])) 
            {
                $c_type = "Individual";
            }

            $cp=0;
            if (isset($_POST['Class1']))
            {
                $cp = 1;
            } 
            elseif (isset($_POST['Class2']))
            {
                $cp = 0;
            }
            elseif (isset($_POST['Class3']))
            {
                $cp = 4;
            }
            elseif (isset($_POST['Class4']))
            {
                $cp = 5;
            }
            elseif (isset($_POST['Class5']))
            {
                $cp = 6;
            }
            elseif (isset($_POST['Class6']))
            {
                $cp = 7;
            }
            elseif (isset($_POST['Class7']))
            {
                $cp = 8;
            }
            elseif (isset($_POST['Class8']))
            {
                $cp = 9;
            }
                
            $data = [
                'cp' => $cp,
                'c_type' => $c_type,
                'salutation' => $_POST['salutation'],
                'f_name' => $_POST['f_name'],
                'l_name' => $_POST['l_name'],
                'company_name' => $_POST['company_name'],
                'c_display_name' => $_POST['c_display_name'],
                'c_email' => $_POST['c_email'],
                'customer_home_phone' => $_POST['customer_home_phone'],
                'customer_work_phone' => $_POST['customer_work_phone'],
                'website' => $_POST['website'],
                'currency' => $_POST['currency'],
                'payment_terms' => $_POST['payment_terms'],
                'facebook' => $_POST['facebook'],
                'twitter' => $_POST['twitter'],
                'attention' => $_POST['attention'],
                'country' => $_POST['country'],
                'street1' => $_POST['street1'],
                'street2' => $_POST['street2'],
                'city' => $_POST['city'],
                'state' => $_POST['state'],
                'zip_code' => $_POST['zip_code'],
                'phone' => $_POST['phone'],
                'fax' => $_POST['fax'],
                'cp_attention' => $_POST['cp_attention'],
                'cp_country' => $_POST['cp_country'],
                'cp_street1' => $_POST['cp_street1'],
                'cp_street2' => $_POST['cp_street2'],
                'cp_city' => $_POST['cp_city'],
                'cp_state' => $_POST['cp_state'],
                'cp_zip_code' => $_POST['cp_zip_code'],
                'cp_phone' => $_POST['cp_phone'],
                'cp_fax' => $_POST['cp_fax'],
                'cp_salutation' => $_POST['cp_salutation'],
                'cp_f_name' => $_POST['cp_f_name'],
                'cp_l_name' => $_POST['cp_l_name'],
                'cp_email' => $_POST['cp_email'],
                'cp_working_phone' => $_POST['cp_working_phone'],
                'cp_mobile' => $_POST['cp_mobile'],
                'gst'=>$_POST['gst'],
                'aadhar'=>$_POST['aadhar'],
                'passport'=>$_POST['passport'],
                'dob'=>$_POST['dob'],
                'aniversary'=>$_POST['aniversary'],
                'blood'=>$_POST['blood'],
                'transport'=>$_POST['transport'],
            ];
            $this->pageModel->save_customer_details($data);
            $_SESSION['success'] = "Customer added successfully";
            redirect('pages/all_customer');
        }


        public function all_customer()
        {
            $data = [
                'all_customer' => $this->pageModel->get_all_customers()
            ];
            $this->view('pages/all_customer', $data);
        }
        public function del_customer($id)
        {
            $this->pageModel->del_customer($id);
            $_SESSION['success'] = "Customer deleted successfully";
            redirect('pages/all_customer');
        }
        public function edit_customer($id)
        {
            $data = [
                'customer' => $this->pageModel->get_single_customer($id),
                'transport' => $this->pageModel->get_all_transportdetails()
            ];
            $this->view('pages/edit_customer', $data);
        }
        public function update_customer()
        {
            $c_type = "";
            if (isset($_POST['business'])) {
                $c_type = "Business";
            } elseif (isset($_POST['business'])) {
                $c_type = "Individual";
            }
            $cp=0;
            if (isset($_POST['Class1']))
            {
                $cp = 1;
            } 
            elseif (isset($_POST['Class2']))
            {
                $cp = 0;
            }
            elseif (isset($_POST['Class3']))
            {
                $cp = 4;
            }
            elseif (isset($_POST['Class4']))
            {
                $cp = 5;
            }
            elseif (isset($_POST['Class5']))
            {
                $cp = 6;
            }
            elseif (isset($_POST['Class6']))
            {
                $cp = 7;
            }
            elseif (isset($_POST['Class7']))
            {
                $cp = 8;
            }
            elseif (isset($_POST['Class8']))
            {
                $cp = 9;
            }
            $data = [
                'cp'=>$cp,
                'c_type' => $c_type,
                'salutation' => $_POST['salutation'],
                'f_name' => $_POST['f_name'],
                'l_name' => $_POST['l_name'],
                'company_name' => $_POST['company_name'],
                'c_display_name' => $_POST['c_display_name'],
                'c_email' => $_POST['c_email'],
                'customer_home_phone' => $_POST['customer_home_phone'],
                'customer_work_phone' => $_POST['customer_work_phone'],
                'website' => $_POST['website'],
                'currency' => $_POST['currency'],
                'payment_terms' => $_POST['payment_terms'],
                'facebook' => $_POST['facebook'],
                'twitter' => $_POST['twitter'],
                'attention' => $_POST['attention'],
                'country' => $_POST['country'],
                'street1' => $_POST['street1'],
                'street2' => $_POST['street2'],
                'city' => $_POST['city'],
                'state' => $_POST['state'],
                'zip_code' => $_POST['zip_code'],
                'phone' => $_POST['phone'],
                'fax' => $_POST['fax'],
                'cp_attention' => $_POST['cp_attention'],
                'cp_country' => $_POST['cp_country'],
                'cp_street1' => $_POST['cp_street1'],
                'cp_street2' => $_POST['cp_street2'],
                'cp_city' => $_POST['cp_city'],
                'cp_state' => $_POST['cp_state'],
                'cp_zip_code' => $_POST['cp_zip_code'],
                'cp_phone' => $_POST['cp_phone'],
                'cp_fax' => $_POST['cp_fax'],
                'cp_salutation' => $_POST['cp_salutation'],
                'cp_f_name' => $_POST['cp_f_name'],
                'cp_l_name' => $_POST['cp_l_name'],
                'cp_email' => $_POST['cp_email'],
                'cp_working_phone' => $_POST['cp_working_phone'],
                'cp_mobile' => $_POST['cp_mobile'],
                'id' => $_POST['id'],
                'gst'=>$_POST['gst'],
                'aadhar'=>$_POST['aadhar'],
                'passport'=>$_POST['passport'],
                'dob'=>$_POST['dob'],
                'aniversary'=>$_POST['aniversary'],
                'blood'=>$_POST['blood'],
                'transport' => $_POST['transport']
            ];
            $this->pageModel->update_customer_details($data);
            $_SESSION['success'] = "Customer Updated successfully";
            redirect('pages/all_customer');
        }

        public function create_distributor()
        {

            $data = [
                'salutation' => $_POST['salutation'],
                'f_name' => $_POST['f_name'],
                'l_name' => $_POST['l_name'],
                'distributor_name' => $_POST['distributor_name'],
                'c_display_name' => $_POST['c_display_name'],
                'c_email' => $_POST['c_email'],
                'Distributor_home_phone' => $_POST['Distributor_home_phone'],
                'Distributor_work_phone' => $_POST['Distributor_work_phone'],
                'website' => $_POST['website'],
                'currency' => $_POST['currency'],
                'payment_terms' => $_POST['payment_terms'],
                'facebook' => $_POST['facebook'],
                'twitter' => $_POST['twitter'],
                'attention' => $_POST['attention'],
                'country' => $_POST['country'],
                'street1' => $_POST['street1'],
                'street2' => $_POST['street2'],
                'city' => $_POST['city'],
                'state' => $_POST['state'],
                'zip_code' => $_POST['zip_code'],
                'phone' => $_POST['phone'],
                'fax' => $_POST['fax'],
                'cp_attention' => $_POST['cp_attention'],
                'cp_country' => $_POST['cp_country'],
                'cp_street1' => $_POST['cp_street1'],
                'cp_street2' => $_POST['cp_street2'],
                'cp_city' => $_POST['cp_city'],
                'cp_state' => $_POST['cp_state'],
                'cp_zip_code' => $_POST['cp_zip_code'],
                'cp_phone' => $_POST['cp_phone'],
                'cp_fax' => $_POST['cp_fax'],
                'cp_salutation' => $_POST['cp_salutation'],
                'cp_f_name' => $_POST['cp_f_name'],
                'cp_l_name' => $_POST['cp_l_name'],
                'cp_email' => $_POST['cp_email'],
                'cp_working_phone' => $_POST['cp_working_phone'],
                'cp_mobile' => $_POST['cp_mobile']
            ];
            $this->pageModel->save_distributor_details($data);
            $_SESSION['success'] = "Distributor added successfully";
            redirect('pages/all_distributor');
        }


        public function del_distributor($id)
        {
            $this->pageModel->del_distributor($id);
            $_SESSION['success'] = "Distributor deleted successfully";
            redirect('pages/all_distributor');
        }
        public function edit_distributor($id)
        {
            $data = [
                'distributor' => $this->pageModel->get_single_distributor($id)
            ];
            $this->view('pages/edit_distributor', $data);
        }

        public function update_distributor()
        {

            $data = [
                'salutation' => $_POST['salutation'],
                'f_name' => $_POST['f_name'],
                'l_name' => $_POST['l_name'],
                'distributor_name' => $_POST['distributor_name'],
                'c_display_name' => $_POST['c_display_name'],
                'c_email' => $_POST['c_email'],
                'Distributor_home_phone' => $_POST['Distributor_home_phone'],
                'Distributor_work_phone' => $_POST['Distributor_work_phone'],
                'website' => $_POST['website'],
                'currency' => $_POST['currency'],
                'payment_terms' => $_POST['payment_terms'],
                'facebook' => $_POST['facebook'],
                'twitter' => $_POST['twitter'],
                'attention' => $_POST['attention'],
                'country' => $_POST['country'],
                'street1' => $_POST['street1'],
                'street2' => $_POST['street2'],
                'city' => $_POST['city'],
                'state' => $_POST['state'],
                'zip_code' => $_POST['zip_code'],
                'phone' => $_POST['phone'],
                'fax' => $_POST['fax'],
                'cp_attention' => $_POST['cp_attention'],
                'cp_country' => $_POST['cp_country'],
                'cp_street1' => $_POST['cp_street1'],
                'cp_street2' => $_POST['cp_street2'],
                'cp_city' => $_POST['cp_city'],
                'cp_state' => $_POST['cp_state'],
                'cp_zip_code' => $_POST['cp_zip_code'],
                'cp_phone' => $_POST['cp_phone'],
                'cp_fax' => $_POST['cp_fax'],
                'cp_salutation' => $_POST['cp_salutation'],
                'cp_f_name' => $_POST['cp_f_name'],
                'cp_l_name' => $_POST['cp_l_name'],
                'cp_email' => $_POST['cp_email'],
                'cp_working_phone' => $_POST['cp_working_phone'],
                'cp_mobile' => $_POST['cp_mobile'],
                'id' => $_POST['id']
            ];
            $this->pageModel->update_distributor_details($data);
            $_SESSION['success'] = "Distributor Updated successfully";
            redirect('pages/all_distributor');
        }



        public function all_distributor()
        {
            $data = [
                'all_distributor' => $this->pageModel->get_all_distributor()
            ];
            $this->view('pages/all_distributor', $data);
        }

        public function add_sales_order()
        {
            $this->pageModel->delete_all_temp_sale();
             $data = [
                        'all_distributor' => $this->pageModel->get_all_distributor(),
                        'customer' =>$this->pageModel->get_all_customers(),
                        'all_items' => $this->pageModel->get_all_items_for_dropdown(),
                        'cat' => $this->pageModel->getAllCategoriesDb(),
                        'cat1' => $this->pageModel->getAllCategoriesDb2(),
                        'cat2' => $this->pageModel->getAllCategoriesDb3(),
                        'cat3' => $this->pageModel->getAllCategoriesDb4(),
                        'type' => $this->pageModel->getAlltypeDb(),
                        'model' => $this->pageModel->getAllCategoriesDb_model(),
                        'cat_new' => $this->pageModel->getAllCategoriesDb_new(),
                        'subcat_new' => $this->pageModel->getAllsubCategoriesDb_new(),
                        'color' => $this->pageModel->getAllcolorDb_new(),
                        'size' => $this->pageModel->getAllsizeDb_new(),
                        'all_mfg' => $this->pageModel->getallmfg(),        
                     ];
            $this->view('pages/add_sales_order',$data);
        }

        public function create_sales_order()
        {
            $sta = 1;
            $item_id = $_POST['item_id'];
            $sItem = $_POST['itemName'];
            $sQty = $_POST['qty'];
            $sPrice = $_POST['price'];
            // $sTax = $_POST['stax'];
            $sTax = 0;
            $sTotal = $_POST['total'];
            if(!empty($item_id))
            {
                $this->pageModel->saveTheSalesTempData($sta, $item_id, $sItem, $sQty, $sPrice, $sTax, $sTotal);
            }
            $z = $this->pageModel->get_temp_sales_count();
            if(empty($z))
            {
                    $_SESSION['success'] = 'Enter all fields';
                    redirect('pages/add_sales_order');
            }else
            {
                $customer ='';
                $customer = $this->pageModel->get_cust_bill_for_onclick($_POST['customer_id']);
                $tempId = md5(uniqid());
                $data = [ 
                            'customer' => $customer->customer_display_name,
                            'sales_order' => $_POST['sales_order'],
                            'reference'=> $_POST['reference'],
                            'state_for_tax' => $_POST['state_for_tax'],
                            'ndate' => $_POST['ndate'],
                            'expected_delivery_date' => $_POST['expected_delivery_date'],
                            'payment_terms' => $_POST['payment_terms'],
                            'delivery_method' => $_POST['delivery_method'],
                            'salesperson' => $_POST['salesperson'],
                            'customer_notes' => $_POST['customer_notes'],
                            't_and_c' => $_POST['t_and_c'],
                            'customer_id' => $_POST['customer_id'],
                            'tempId' => $tempId,
                            'total_amount' => $_POST['total_amount'],
                            'warehouse_name' => $_POST['warehouse_name'],
                        ];
                $saleId = $this->pageModel->add_sales_order_details($data); 
                 if($this->pageModel->saveTheSalesOrderData($saleId->id))
                 {
                     $_SESSION['success'] = 'Sales Order Created Successfully';
                     redirect('pages/sales_order');
                 }
            }
        }
         public function makenew_sales_order()
        {
            $tempId = md5(uniqid());
            $data = [ 
                        'customer_id' => $_POST['customer_id'],
                        'customer' => $_POST['customer'],
                        'sales_order' => $_POST['sales_order'],
                        'reference'=> $_POST['reference'],
                        'state_for_tax' => $_POST['state_for_tax'],
                        'ndate' => $_POST['ndate'],
                        'expected_delivery_date' => $_POST['expected_delivery_date'],
                        'payment_terms' => $_POST['payment_terms'],
                        'delivery_method' => $_POST['delivery_method'],
                        'salesperson' => $_POST['salesperson'],
                        'customer_notes' => $_POST['customer_notes'],
                        't_and_c' => $_POST['t_and_c'],
                        'tempId' => $tempId,
                        'warehouse_name' => $_POST['warehouse_name'],
                        
                        'item_id'=>implode("|||", $_POST['item_id']),
                        'itemName'=>implode("|||", $_POST['itemName']),
                        'qty'=>implode("|||", $_POST['qty']),
                        'price'=>implode("|||", $_POST['price']),
                        'tax'=>implode("|||", $_POST['taxrow']),
                        'total'=>implode("|||", $_POST['total']),
                        'sub_total'=>$_POST['sub_total'],
                        'discount'=>$_POST['discount'],
                        'total_amount' => $_POST['total_amount'],
                      
                        
                    ];
            $saleId = $this->pageModel->make_order_sales_order_details($data); 
             if($this->pageModel->saveThemakesalesinvoiceOrderData($saleId->id,$data))
             {
                 $_SESSION['success'] = 'Sales Order Created Successfully';
                 redirect('pages/sales_order');
             }
        }
        public function create_sales_order_for_stock_out()
        {
            $item_id = $_POST['item_id'];
            $item_name = $_POST['itemName'];
            $sQty = $_POST['qty'];
            $rec = $_POST['rec'];
            $price = $_POST['price'];
            $total = $_POST['total'];
            if(empty($rec))
            {
                if($rec==0)
                {
                    if(empty($sQty))
                    {}
                    else
                    {
                        $this->pageModel->saveTheSalesTempData_stock_out($item_id,$item_name, $sQty, $rec,$price,$total);
                    }
                }   
            }
            else
            {
                if(empty($sQty))
                {}
                else
                {
                    $this->pageModel->saveTheSalesTempData_stock_out($item_id,$item_name, $sQty, $rec,$price,$total);
                }
                
            }
            $z = $this->pageModel->get_count_temp_stock_out_order();
            if(empty($z))
            {
                $_SESSION['success'] = "Enter all Fields";
                redirect('pages/stock_out');
            }
            else
            {
                $customer ='';
                $customer = $this->pageModel->get_cust_bill_for_onclick($_POST['customer_id']);
                $tempId = 0;
                $tempId = md5(uniqid());
                $data = [ 
                            'customer' => $customer->customer_display_name,
                            'customer_id'=> $_POST['customer_id'],
                            'stock_dt' => $_POST['stock_dt'],
                            'product' => $_POST['itemName'],
                            'qty' => $_POST['qty'],
                            'rec' => $_POST['rec'],
                            'price' => $_POST['price'],
                            'total' => $_POST['total'],
                            'sub_total' => $_POST['sub_total'],
                            'total_amount' => $_POST['total_amount'],
                            'tempId'=> $tempId,
                        ];
                $saleId = $this->pageModel->add_stock_out_order_details($data); 
                 if($this->pageModel->saveThesales_stock_out($saleId->id,$data))
                 {
                     $_SESSION['success'] = 'Stock Out Created Successfully';
                     redirect('pages/all_stock_out');
                 }
            }
        }

         public function create_delivery_challans()
        {
            $tempId = md5(uniqid());
            $data = [ 
            'customer' => $_POST['customer'],
            'delivery_challan_no' => $_POST['delivery_challan_no'],
            'reference'=> $_POST['reference'],
            'ndate' => $_POST['ndate'],
            'challan_type' => $_POST['challan_type'],
            'customer_notes' => $_POST['customer_notes'],
            't_and_c' => $_POST['t_and_c'],
            'customer_id' => $_POST['customer_id'],
            'tempId' => $tempId,
            'total_amount' => $_POST['total_amount'],
            'warehouse_name' => $_POST['warehouse_name'],
            ];

          
            $dcId = $this->pageModel->add_delivery_challan_order_details($data);
             if($this->pageModel->saveThedelivery_challanOrderData($dcId->id))
             {
                 $_SESSION['success'] = 'Delivery Challan Created Successfully';
                 redirect('pages/all_delivery_challan');
             } 
        }

        public function sales_order()
        {
            $this->view('pages/sales_order');
        }
        public function all_stock_out()
        {
            $this->view('pages/all_stock_out');
        }

        public function update_sales_order()
        {
            $vd = explode("|", $_POST['customer']);
            $_POST['customer'] = $vd[1];
            $x =0;
            foreach ($_POST['qty'] as $k) {
                $x = $x + $k;
            }
            $data = [ 
            'customer' => $_POST['customer'],
            'sales_order' => $_POST['sales_order'],
            'reference'=> $_POST['reference'],
            'ndate' => $_POST['ndate'],
            'expected_delivery_date' => $_POST['expected_delivery_date'],
            'payment_terms' => $_POST['payment_terms'],
            'delivery_method' => $_POST['delivery_method'],
            'salesperson' => $_POST['salesperson'],
            'product' => implode("|", $_POST['product']),
            'qty' => implode("|", $_POST['qty']),
            'price' => implode("|", $_POST['price']),
            'total' => implode("|", $_POST['total']),
            'sub_total' => $_POST['sub_total'],
            'tax' => $_POST['tax'],
            'tax_amount' => $_POST['tax_amount'],
            'total_amount' => $_POST['total_amount'],
            'customer_notes' => $_POST['customer_notes'],
            't_and_c' => $_POST['t_and_c'],
            'total_qty' => $x,
            'customer_id' => $vd[0],
            'id' => $_POST['id']
            ];
            $this->pageModel->update_sales_order_details($data);
            $_SESSION['success'] = 'Sales Order Updated Successfully';
            redirect('pages/sales_order');
        }
        public function edit_sales_order($id)
        {
            $data = [
                'sales' => $this->pageModel->get_single_sales($id)
            ];
            $this->view('pages/edit_sales_order', $data);
        }
        public function sales_delete($id)
        {
            $this->pageModel->del_sales($id);
            $_SESSION['success'] = "Sales Order Deleted Successfully";
            redirect('pages/sales_order');
        }
        public function add_delivery_challan()
        {
            $data=[
                  'customer' =>$this->pageModel->get_all_customers()    
            ];
            $this->view('pages/add_delivery_challan',$data);
        }
        public function all_delivery_challan()
        {

            $this->view('pages/all_delivery_challan');
        }

        public function create_distributor_order()
        {
            $tempId = md5(uniqid());
            $data = [ 
            'distributor' => $_POST['distributor'],
            'distributor_order' => $_POST['distributor_order'],
            'reference'=> $_POST['reference'],
            'state_for_tax' => $_POST['state_for_tax'],
            'ndate' => $_POST['ndate'],
            'expected_delivery_date' => $_POST['expected_delivery_date'],
            'payment_terms' => $_POST['payment_terms'],
            'delivery_method' => $_POST['delivery_method'],
            'salesperson' => $_POST['salesperson'],
            'customer_notes' => $_POST['customer_notes'],
            't_and_c' => $_POST['t_and_c'],
            'distributor_id' => $_POST['distributor_id'],
            'tempId' => $tempId,
            'total_amount' => $_POST['total_amount'],
            'warehouse_name' => $_POST['warehouse_name'],
            ];

            $dId = $this->pageModel->add_distributor_order_details($data);
             if($this->pageModel->saveThedistributorOrderData($dId->id))
             {
                 $_SESSION['success'] = 'Distributor Order Created Successfully';
                 redirect('pages/all_distributor_order');
             } 
        }
        
        public function all_distributor_order()
        {
            $data = [
                'all_distributor' => $this->pageModel->get_all_distributor_order()
            ];
            $this->view('pages/all_distributor_order', $data);
        }
        public function distributor_order_delete($id)
        {
            $this->pageModel->del_distributor_order($id);
            $_SESSION['success'] = "Distributor Order Deleted Successfully";
            redirect('pages/all_distributor_order');
        }

        //function end here

        public function item_description($id)
        {
            $data = [
                'all_items' => $this->pageModel->get_single_item($id)
            ];
            $this->view('pages/item_description', $data);
        }
        public function adjuststock()
        {

            $this->view('pages/adjuststock');
        }

        public function invoice()
        {

            $this->view('pages/invoice');
        }
        public function addinvoice()
        {

            $this->view('pages/addinvoice');
        }
        public function addcustomer()
        {
            $data = [
                'transport' => $this->pageModel->getAllTransportDetails()
            ];
            $this->view('pages/addcustomer', $data);
        }



        public function all_returns()
        {

            $this->view('pages/all_returns');
        }

        public function packed()
        {

            $this->view('pages/packed');
        }
        public function shiped()
        {

            $this->view('pages/shiped');
        }
        public function add_returns()
        {

            $this->view('pages/add_returns');
        }
        public function all_deli()
        {

            $this->view('pages/all_deli');
        }
        public function add_deli()
        {

            $this->view('pages/add_deli');
        }
        public function all_payments()
        {

            $this->view('pages/all_payments');
        }
        public function add_payments()
        {

            $this->view('pages/add_payments');
        }
        public function all_bill()
        {

            $this->view('pages/all_bill');
        }
        public function add_bill()
        {

            $this->view('pages/add_bill');
        }
        public function reports()
        {

            $this->view('pages/reports');
        }
        public function sales_by_customer()
        {

            $this->view('pages/sales_by_customer');
        }
        public function sales_by_item()
        {

            $this->view('pages/sales_by_item');
        }
        public function order_filfillment_by_item()
        {

            $this->view('pages/order_filfillment_by_item');
        }
        public function inventory_summary()
        {

            $this->view('pages/inventory_summary');
        }
        public function Inventory_Valuation_Summary()
        {

            $this->view('pages/Inventory_Valuation_Summary');
        }
        public function fifo()
        {

            $this->view('pages/fifo');
        }
        public function sales_return_history()
        {

            $this->view('pages/sales_return_history');
        }
        public function sales_by_sales_person()
        {

            $this->view('pages/sales_by_sales_person');
        }
        public function packing_history()
        {

            $this->view('pages/packing_history');
        }
        public function inventory_aging_summary()
        {

            $this->view('pages/inventory_aging_summary');
        }
        public function product_sales_report()
        {

            $this->view('pages/product_sales_report');
        }
        public function active_purchase_order_report()
        {

            $this->view('pages/active_purchase_order_report');
        }
        public function stock_summary_report()
        {

            $this->view('pages/stock_summary_report');
        }
        public function customer_balances()
        {

            $this->view('pages/customer_balances');
        }
        public function invoice_details()
        {

            $this->view('pages/invoice_details');
        }
        public function sales_order_details()
        {

            $this->view('pages/sales_order_details');
        }
        public function delivery_challan_details()
        {

            $this->view('pages/delivery_challan_details');
        }
        public function receivable_Summary()
        {

            $this->view('pages/receivable_Summary');
        }
        public function Receivable_Details()
        {

            $this->view('pages/Receivable_Details');
        }
        public function payments_received()
        {

            $this->view('pages/payments_received');
        }
        public function vendor_balances()
        {

            $this->view('pages/vendor_balances');
        }
        public function bill_details()
        {

            $this->view('pages/bill_details');
        }
        public function payments_made()
        {

            $this->view('pages/payments_made');
        }
        public function purchase_order_details()
        {

            $this->view('pages/purchase_order_details');
        }
        public function purchase_order_by_vender()
        {

            $this->view('pages/purchase_order_by_vender');
        }
        public function purchases_by_item()
        {

            $this->view('pages/purchases_by_item');
        }
        public function receive_history()
        {

            $this->view('pages/receive_history');
        }
        public function add_distributor()
        {

            $this->view('pages/add_distributor');
        }

        public function add_distributor_order()
        {

            $this->view('pages/add_distributor_order');
        }
        public function add_receipts()
        {

            $this->view('pages/add_receipts');
        }
        public function all_receipts()
        {

            $this->view('pages/all_receipts');
        }



        // all code from preetham, following from saturday




        public function getTheItems1()
        {
            $output = "";
            $tags = $_POST['tags'];
            $items = $this->pageModel->getAllItems($tags);
            foreach ($items as $key) {
                $type ='';
                $model='';
                $category='';
                if(!empty($key->type_id))
                {
                    $type = $this->pageModel->get_type_name_by_id($key->type_id);
                    if(empty($type))
                    {
                        $type = '';       
                    }
                    else
                    {
                        $type = $type->type_name;    
                    }
                }else
                {
                    $type = '';
                }
                if(!empty($key->model_id))
                {
                    $model = $this->pageModel->get_model_name_by_id($key->model_id);    
                    if(empty($model))
                    {
                        $model = '';                             
                    }
                    else
                    {
                        $model = $model->model_name;      
                    }

                }else
                {
                    $model = '';
                }
                if(!empty($key->category_new_id))
                {
                    $category = $this->pageModel->get_category_name_by_id($key->category_new_id); 
                    if(empty($category))
                    {
                        $category ='';
                    }
                    else
                    {
                        $category = $category->category_name;   
                    }
                }else
                {
                    $category = '';
                }
                $val = json_encode($key->id);
                $output .= '<a class="dropdown-item hvr" style="border-bottom:1px lightgray solid" href="#itemDetails" onclick="selectProduct(' . $key->id . ')">' . $key->name.'('.$model.')('.$category.')</a>';
            }
            echo $output;
        }

        public function getItemDetailsById1()
        {
            $val = trim($_POST['val']);
            $item = $this->pageModel->getTheItemDetails($val);
            echo $iD = $item->name . "(" . $item->id . ")";
        }
         public function getItemDetailsById2()
        {
            $val = trim($_POST['val']);
            $item = $this->pageModel->getTheItemDetails($val);
            echo $item->id;
        }
        public function getTheItems()
        {
            $output = "";
            $tags = $_POST['tags'];
            $items = $this->pageModel->getAllItems($tags);
            foreach ($items as $key) {
                $val = json_encode($key->id);
                $output .= '<a class="dropdown-item hvr" style="border-bottom:1px lightgray solid" href="#itemDetails" onclick="selectProduct(' . $key->id . ')">' . $key->name . '</a>';
            }
            echo $output;
        }

        public function getItemDetailsById()
        {
            $val = trim($_POST['val']);
            $item = $this->pageModel->getTheItemDetails($val);
            echo $iD = $item->name;
        }

        public function getReceivableForTheItem()
        {
            $iId = $_POST['iId'];
            $qtyDetails = $this->pageModel->getReceivableForTheItemDb($iId);
            $qtyArray = [
                "rec" => $qtyDetails->receive,
                "qty" => $qtyDetails->qty,
                "purchase" => $qtyDetails->purchase_price,
                "carton_qty" => $qtyDetails->carton_qty,
            ];
            echo json_encode($qtyArray);
        }

        public function tempPoData()
        {
            $item_id = $_POST['item_Id'];
            $item = $_POST['item'];
            $item = trim($item);
            $receivable = $_POST['receivable'];
            $perUnitQty = $_POST['perUnitQty'];
            $actQty = $_POST['actQty'];
            $totalQty = $_POST['totalQty'];
            $rowPrice = $_POST['rowPrice'];
            $rowTotal = $_POST['rowTotal'];

            $k = $this->pageModel->saveTheTempData($item_id,$item, $receivable, $perUnitQty, $actQty, $totalQty, $rowPrice, $rowTotal);
            $slno = ($this->pageModel->getTheRowCount()) + 1;
            if ($receivable == 0)
            {
                $receivable = "carton";
            }
            elseif ($receivable == 1)
            {
                $receivable = "Box";
            }else
            { 
                $receivable = "Piece";
            }
            $output = '
            <tr id="'.$k->temp_id.'"><td>' . $slno . '</td>\
                <td><input type="text" class="form-control" value="' . $item . '" readonly/></td>\
                <td></td>\
                <td ><input type="text" class="form-control" value="' . $receivable . '" readonly/></td>\
                <td><input type="text" class="form-control" value="' . $perUnitQty . '" readonly/></td>\
                <td><input type="text" class="form-control" value="' . $actQty . '" readonly/></td>\
                <td style="display:none"><input type="number"  class="form-control qty" step="0" min="0" id="ttlq" value="' . $totalQty . '" readonly/></td>\
                <td><input type="number"  class="form-control price" step="0.00" min="0" value="' . $rowPrice . '" readonly /></td>\
                <td><input type="number"  class="form-control total" value="' . $rowTotal . '" readonly /></td>
                <td><a onclick="delete_purchase_row('.$k->temp_id.')"><button type="button" class="btn btn-danger-rgba"><i class="dripicons-archive"></i></button></a></td>
            </tr>';
            echo $output;
        }
        public function delete_purchase_temp_row()
        {
            $id = $_POST['id'];
            $this->pageModel->delete_purchase_temp($id);
        }

        public function getAllPo()
        {
            $lim = $_POST['lim'];
            $lim = (int)$lim;
            if ($lim == 9) {
                $off = $_POST['off'];
                $off = (int)$off;
                $allPo = $this->pageModel->getAllThePo($lim, $off);
            } else {
                $inc = $_POST['inc'];
                $inc = (int)$inc;
                $lim = 9;
                $off = 9 + (9 * $inc);
                $allPo = $this->pageModel->getAllThePo($lim, $off);
            }
            $output = '';

            foreach ($allPo as $key) {
                $output .= "<tr>
                    <td>" . $key->id . "</td>
                    <td>" . ucwords($key->vendor . "(" . $key->vendor_id . ")") . "</td>
                    <td>" . date('d-M-Y', strtotime($key->ndate)) . "</td>
                    
                    <td style='text-align: center;'>
                        <button type='button' class='btn btn-primary btn-sm' onclick='processPurchaseOrderModal(" . $key->id . ")'>Process</button>
                        <a href='".URLROOT."/pages/deletePurchaseOrder/".$key->id."'class='btn btn-danger-rgba' ><i class='dripicons-archive'></i></a>
                    </td>
                </tr>";
            }
            echo $output;
        }
         // <a href='".URLROOT."/pages/editPurchaseOrder/" . $key->id . "' class='btn btn-info btn-sm' >Edit</a>
        public function deletePurchaseOrder($id)
        {
            $x = $this->pageModel->get_all_receive_item_details($id);
            if(empty($x))
            {
                if($this->pageModel->delete_single_purchase_details($id))
                {
                    $_SESSION['success'] = "Purchase order deleted successfully";
                    redirect('pages/purchase_order');
                }else
                {
                    $_SESSION['success'] = "Some Item is received. Delete not possible";
                    redirect('pages/purchase_order');
                }
            }
            else
            {
                $_SESSION['success'] = "Some Item is received. Delete not possible";
                redirect('pages/purchase_order');
            }
        }
        public function purchaseReceive($pid)
        {
            $data = [
                'purchase' => $this->pageModel->getThePurchaseDetails($pid),
                'purchaseItem' => $this->pageModel->getThePurchaseItemDetails($pid),
                'pId' => $pid,
                'receive' => $this->pageModel->receiveThePurchase($pid),
                'positions' => $this->pageModel->getAllPOsitionsForReceive(),
            ];
            $this->view('pages/purchase_receive', $data);
        }

        public function purchaseBill($pid)
        {
            echo $pid;
        }

        public function saveTheReceive($pid)
        {
            
            if(isset($_POST['temp_save']))
            {
                
                $sno = $_POST['serial_id_draft'];
                $purchase_id = $pid;
                $itemId = $_POST['itemId'][$sno];
                $itemName = $_POST['itemName'][$sno];
                $receivable = $_POST['receivable'][0];
                $rQty = $_POST['rQty'][0];
                $rPerQty = $_POST['rPerQty'][0];
                $position = $_POST['pos'][0];
                $barcode = $_POST['barcode'][0];
                $saved = $this->pageModel->save_to_draft($sno,$purchase_id,$itemId,$itemName,$receivable,$rQty,$rPerQty,$position,$barcode);
               
                if($saved){$_SESSION['success'] = "saved to draft";
                redirect('pages/purchaseReceive/'.$pid.'');
                }
            }
            elseif(isset($_POST['final_receive']))
            {   
                $rs1 = $this->pageModel->get_draft_purchase_count($pid);
                if($rs1<1)
                {

                    $batch = $_POST['batch'];
                    $rec_date = $_POST['rec_date'];
                    $itemId = implode('|||', $_POST['itemId']);
                    $itemName = implode('|||', $_POST['itemName']);
                    $receivable = implode('|||', $_POST['receivable']);
                    $rQty = implode('|||', $_POST['rQty']);
                    $rPerQty = implode('|||', $_POST['rPerQty']);
                    $notes = $_POST['notes'];
                    $position = implode('|||', $_POST['pos']);
                    $barcode = implode('|||', $_POST['barcode']);
                    //$this->pageModel->saveTheReceiveDb($batch, $itemId, $itemName, $receivable, $rQty, $rPerQty, $notes, $pid, $position,$barcode);
                    $b1 = $batch;
                    $b2 = $itemId; 
                    $b3 = $itemName;
                    $b4 = $receivable;
                    $b5 = $rQty;
                    $b6 = $rPerQty; 
                    $b7 = $notes; 
                    $b8 = $pid;
                    $b9 = $position;
                    $b10 = $barcode;
                   
                    $p = $this->pageModel->purchase_single_order_details($pid);
                    $ponly = $this->pageModel->purchase_single_details($pid);
                    $name = $ponly->vendor;
                    $expected_date = $ponly->expected_delivery_date;
                    $items = explode('|||', $p->item_id);
                    $total_qty = explode('|||', $p->total_qty);
                    $receive_qty = explode("|||", $rQty);
                    for ($i=0; $i < sizeof($items)  ; $i++) { 
                        $rem[$i] = $total_qty[$i] - $receive_qty[$i];             
                    }
                    $rem = implode("|||", $rem);
                     $this->pageModel->save_stock_with_batch($pid,$batch,$rQty,$rem,$p->item_id,$p->total_qty,$name,$expected_date,$position, $rec_date,$barcode,$receivable,$b1,$b2,$b3,$b4,$b5,$b6,$b7,$b8,$b9,$b10);
                    

                    $_SESSION['success'] ="Details Updated";
                    redirect('pages/purchase_order');
                }   
                else
                {
                    $rs2 =0;
                    $rs2 = $this->pageModel->count_all_purchase_receive_in_draft($pid);
                    if($rs2 == 1)
                    {  
                        $rs = $this->pageModel->get_temp_receive_draft_using_purchase_id($pid);
                        foreach ($rs as $k) 
                        {
                            $itemId[] = $k->itemId;
                            $itemName[] = $k->itemName;
                            $receivable[] = $k->receivable; 
                            $rQty[] = $k->rQty;
                            $rPerQty[] = $k->rPerQty;
                            $position[] = $k->position;
                            $barcode[] = $k->barcode;
                        }
                        $batch = $_POST['batch'];
                        $rec_date = $_POST['rec_date'];
                        $itemId = implode('|||', $itemId);
                        $itemName = implode('|||', $itemName);
                        $receivable = implode('|||', $receivable);
                        $rQty = implode('|||', $rQty);
                        $rPerQty = implode('|||', $rPerQty);
                        $notes = $_POST['notes'];
                        $position = implode('|||', $position);
                        $barcode = implode('|||', $barcode);

                        // $this->pageModel->saveTheReceiveDb($batch, $itemId, $itemName, $receivable, $rQty, $rPerQty, $notes, $pid, $position,$barcode);
                        $b1 = $batch;
                        $b2 = $itemId; 
                        $b3 = $itemName;
                        $b4 = $receivable;
                        $b5 = $rQty;
                        $b6 = $rPerQty; 
                        $b7 = $notes; 
                        $b8 = $pid;
                        $b9 = $position;
                        $b10 = $barcode;
                        $p = $this->pageModel->purchase_single_order_details($pid);
                        $ponly = $this->pageModel->purchase_single_details($pid);
                        $name = $ponly->vendor;
                        $expected_date = $ponly->expected_delivery_date;
                        $items = explode('|||', $p->item_id);
                        $total_qty = explode('|||', $p->total_qty);
                        $receive_qty = explode("|||", $rQty);
                        for ($i=0; $i < sizeof($items); $i++) { 
                            $rem[$i] = $total_qty[$i] - $receive_qty[$i];             
                        }
                        $rem = implode("|||", $rem);
                        $this->pageModel->save_stock_with_batch($pid,$batch,$rQty,$rem,$p->item_id,$p->total_qty,$name,$expected_date,$position, $rec_date,$barcode,$receivable,$b1,$b2,$b3,$b4,$b5,$b6,$b7,$b8,$b9,$b10);
                        $_SESSION['success'] ="Details Updated";
                        redirect('pages/purchase_order');
                    }
                    else
                    {
                        $_SESSION['success'] ="Save all then click receive";
                        redirect('pages/purchaseReceive/'.$pid.'');
                    }
                }
            }
            else
            {
                
                redirect('pages/purchaseReceive/'.$pid.'');
            }

            
        }

        public function getReceivedDetails()
        {
            $pid = $_POST['pId'];
            $rD = $this->pageModel->getTheReceivedDetails($pid);
            $output = "
                <table class='table'>
                    <thead>
                        <tr>
                            <th>Sl.No.</th>
                            <th>Item</th>
                            <th>Received Qty</th>
                            <th width='150' style='text-align:center'>Action</th>
                        </tr>
                    </thead>
            ";
            $i = 1;
            foreach ($rD as $key)
            {
                $items = explode('|||', $key->item_name);
                $item = implode('<br>', $items);
                $rec = explode('|||', $key->received_qty);
                $recs = implode('<br>', $rec);

                $output .= "<tr>
                    <td>".$i."</td>
                    <td>".$item."</td>
                    <td>".$recs."</td>";
                if($key->status == 1)
                {
                    $output .="<td><button class='btn btn-link btn-sm' style='text-align:center'>Completed</button></td></tr>";
                }
                else
                {
                    $output .="<td><a href='".URLROOT."/pages/makeBill/".$key->receive_id."'><button class='btn btn-primary btn-sm' style='text-align:center'>Make Bill</button></a></td></tr>";
                }
                $i++;

            }
            $output .= "</table>";
            echo $output;
        }
        public function getReceivedDetails_for_qr()
        {
            $pid = $_POST['pId'];
            $rD = $this->pageModel->getTheReceivedDetails($pid);
            $output = "
                <table class='table'>
                    <thead>
                        <tr>
                            <th>Sl.No.</th>
                            <th>Item</th>
                            <th>Received Qty</th>
                            <th width='150' style='text-align:center'>Action</th>
                        </tr>
                    </thead>
            ";
            $i = 1;
            foreach ($rD as $key)
            {
                $items = explode('|||', $key->item_name);
                $item_id = explode('|||', $key->item_id);
                $rec = explode('|||', $key->received_qty);
                $receivable = explode('|||', $key->receivable);
                $temp_for_qr = explode('|||', $key->temp_for_qr);
                for ($j=0; $j <sizeof($items) ; $j++) 
                { 
                    $output .= "<tr>
                    <td>".($j+1)."</td>
                    <td>".$items[$j]."</td>
                    <td>".$rec[$j]."</td>";
                    
                    $ids = array();
                    $itemid = $item_id[$j];
                    // $qty = $_POST['qty'];
                    $temp_qr_id = $temp_for_qr[$j];
                    $it = $this->pageModel->get_single_item($itemid);
                    // $npd = $this->pageModel->get_single_non_purchase($temp_qr_id);
                    if($receivable[$j] == 0)
                    {
                        $npd ='C'; 

                    }elseif($receivable[$j] == 1)
                    {
                        $npd ='B'; 
                    }else
                    {
                        $npd ='P'; 
                    }
                    
                    $x = $this->pageModel->get_selected_stock($temp_qr_id);

                    foreach ($x as $key)
                    {
                        $ids[] = $_SESSION['db_code'].$key->id;
                    }
                    $ids = implode('|', $ids);
                    if(empty($it->color_id))
                    {
                        $color = "Nil";
                    }
                    else
                    {
                        $color = $this->pageModel->get_color($it->color_id);
                        if(empty($color))
                        {
                            $color = "Nil";
                        }
                        else
                        {
                            $color = $color->color_name;  
                        }
                    }

                    if(empty($it->size_id))
                    {
                        $size = 'Nil';
                    }
                    else
                    {
                        $size = $this->pageModel->get_size($it->size_id);
                        if(empty($size))
                        {
                            $size = 'Nil';
                        }
                        else
                        {
                            $size = $size->size_name; 
                        }
                    }
                    $length ="";
                    if(empty($it->dimension))
                    {
                        $dimension = 'Nil';
                    }
                    else
                    {
                        $length = explode("x", $it->dimension);
                        $length = $length[0];
                    }
                    if($it->type_id == 4)
                    {
                        $output .="<td><a target='_blank' href='https://medhike.com/rituhospital/b/barcode/index.php?ids=".$ids."&color=".$color."&size=".$size."&length=".$length."&type=".$npd."' class='btn btn-info text-white'><i class='fa fa-qrcode' aria-hidden='true' ></i></a>

                            <a target='_blank' href='https://medhike.com/rituhospital/b/barcode/indexsm.php?ids=".$ids."&color=".$color."&size=".$size."&length=".$length."&type=".$npd."' class='btn btn-secondary text-white'><i class='fa fa-qrcode' aria-hidden='true'></i></a></td>";
                    }
                    else
                    {
                        if(empty($it->model_id))
                        {
                            $length = "Nil";
                        }else
                        {
                            $mm = $this->pageModel->get_model_by_id_single($it->model_id);
                            
                            if(empty($mm))
                            {
                                $length = "Nil";
                            }
                            else
                            {
                                $length = $mm->model_name;
                            }
                        }
                        if(empty($it->type_id))
                        {
                            $color = "Nil";
                        }else
                        {

                            $tty = $this->pageModel->get_type_name_by_id($it->type_id);
                            if(empty($tty))
                            {
                                $color = "Nil";
                            }else
                            {
                                $color = $tty->type_name;
                            }
                        }
                        if(empty($it->part_no))
                        {
                            $length = "Nil";
                        }else
                        {
                            $length = $it->part_no;
                        }
                        $output .="<td><a target='_blank' href='https://medhike.com/rituhospital/b/barcode/index.php?ids=".$ids."&color=".$color."&size=".$size."&length=".$length."&type=".$npd."' class='btn btn-info text-white'><i class='fa fa-qrcode' aria-hidden='true' ></i></a>
                            <a target='_blank' href='https://medhike.com/rituhospital/b/barcode/indexsm.php?ids=".$ids."&color=".$color."&size=".$size."&length=".$length."&type=".$npd."' class='btn btn-secondary text-white'><i class='fa fa-qrcode' aria-hidden='true' ></i></a></td>";
                    }
                    
                }

                    
            }
            $output .= "</table>";
            echo $output;
        }
        public function getReceivedDetails_for_unbox()
        {
            $pid = $_POST['pId'];
            $rD = $this->pageModel->getTheReceivedDetails($pid);
            $output = "
                <table class='table'>
                    <thead>
                        <th>Item ID</th>
                        <th>Item Name</th>
                        <th>Received IN</th>
                        <th>QTY Received</th>
                        <th>Received Date</th>
                        <th>Batch</th>
                        <th>Actions</th>
                    </thead>
                    <tbody>
            ";
            $i = 1;
            foreach ($rD as $key)
            {
                $item_id = explode('|||', $key->item_id);
                $items = explode('|||', $key->item_name);
                $recb = explode('|||', $key->receivable);
                $rec = explode('|||', $key->received_qty);
                $temp_for_qr = explode('|||', $key->temp_for_qr);
                
                for ($j=0; $j <sizeof($items); $j++) 
                { 
                    if($recb[$j]==0)
                    {
                        $recbaa = "carton";
                    }
                    elseif($recb[$j]==1)
                    {
                        $recbaa = "Box";
                    }
                    else
                    {
                        $recbaa = "Pieces";   
                    }
                    $output .= "<tr>
                    <td>".($j+1)."</td>
                    <td>".$items[$j]."</td>
                    <td>".$recbaa."</td>
                    <td>".$rec[$j]."</td>
                    <td>".$key->received_date_time."</td>
                    <td>".$key->batch."</td>";
                    if($recb[$j]==0)
                    {
                        // get_data_tomodalcarton
                        $output .= "<td><a class='btn btn-primary text-white' onclick='get_data_tomodal(".$temp_for_qr[$j].")'>ALL CARTON</a></td>";
                    }
                    elseif($recb[$j]==1)
                    {
                        $output .= "<td><a class='btn btn-primary text-white' onclick='get_data_tomodal(".$temp_for_qr[$j].")'>UNBOX</a></td>";
                    }
                    $output .= "</tr>";
                }    
            }
            $output .= "</tbody></table>";
            echo $output;
        }
        
        public function getunbox_data_tomodal()
        {
            $temp_for_qr = $_POST['temp_qr'];
            $output = '';
            $output .='<table>
                    <thead>
                        <tr>
                            <th>QRCODE</th>
                            <th>Stock on hand</th>
                            <th>Item Box QTY</th>
                            <th>Item Piece QTY</th>
                            <th colspan="5">Action</th>
                            
                        </tr>
                    </thead>
                    <tbody>';
            $alst = $this->pageModel->count_of_unboxpurchase_get_stock_from_id_temp_data($temp_for_qr);
            foreach ($alst as $ke) 
            { 
                $all_it = $this->pageModel->get_single_item($ke->item_id);
                if($ke->receivable==0)
                {
                    if($ke->stock_on_hand>0)
                    {        
                        $output .=' 
                            <tr>
                                <td><input type="text" name="stock_id" id="stock_id" class="form-control" value="EG'.$_SESSION["db_code"].$_SESSION["db_code"].''.$ke->id.'" readonly="true" autocomplete="off" /></td>

                                <td><input type="text" name="stock_on_hand" id="stock_on_hand" class="form-control" value="'.$ke->stock_on_hand.'" readonly="true"></td>
                                <td>
                                    <input type="text" name="item_qty_carton" id="item_qty_carton" class="form-control" value="'.$all_it->carton_qty.'" readonly="true">
                                </td>
                                <td>
                                    <input type="text" name="item_qty" id="item_qty" class="form-control" value="'.$all_it->qty.'" readonly="true">
                                </td>
                                <td>
                                    <input type="number" name="pieces" id="pieces" class="form-control" required="true" autocomplete="off" value="1" style="display: none;">
                                     <button type="submit" class="btn btn-primary" onclick="convert_carton_item_purchase('.$ke->id.','.$temp_for_qr.')">OPENCARTON</button>
                                </td>';
                                $a = 0;
                                $a = $all_it->qty * $ke->stock_on_hand;
                                $output .=  '<td><input type="text" name="item_id" id="item_id" value="'.$ke->item_id.'" style="display: none;">
                                </td>
                            </tr>
                        ';
                    }
                    else
                    {
                         $output .=' 
                                    <tr>
                                        <td><input type="text" name="stock_id" id="stock_id" class="form-control" value="EG'.$_SESSION["db_code"].$_SESSION["db_code"].''.$ke->id.'" readonly="true" autocomplete="off" /></td>

                                        <td><input type="text" name="stock_on_hand" id="stock_on_hand" class="form-control" value="1" readonly="true"></td>
                                        <td></td>
                                        <td>
                                        <input type="text" name="item_qty" id="item_qty" class="form-control" value="'.$all_it->qty.'" readonly="true">
                                        </td>
                                        <td>
                                            <input type="number" name="pieces" id="pieces" class="form-control" required="true" autocomplete="off" value="1" style="display: none;">

                                             <button type="submit" class="btn btn-primary" onclick="convert_after_carton_to_box_item_purchase('.$ke->id.','.$ke->temp_qr_id.')">view boxs</button>

                                             <input type="text" id="boxstockid'.$ke->id.'" class="form-control" value="'.$ke->id.'" readonly="true" autocomplete="off" style="display: none;"/>                              
                                            <a id="singleqrprint'.$ke->id.'" class="btn btn-info text-white"><i class="fa fa-qrcode" aria-hidden="true"></i></a>

                                            <script>
                                                 $("#singleqrprint'.$ke->id.'").click(function(){
                                                    var boxstockid = document.getElementById("boxstockid'.$ke->id.'").value;
                                                    $.ajax({
                                                        url: "'.URLROOT.'/pages/print_item_qr_for_cartoon_to_box",
                                                        type: "POST",
                                                        data: {boxstockid},
                                                        success: function(response)
                                                        {
                                                             window.open(response);
                                                        }
                                                    });
                                                 });
                                            </script>
                                            
                                            <a id="singleqrprintsm'.$ke->id.'" class="btn btn-secondary text-white"><i class="fa fa-qrcode" aria-hidden="true"></i></a>

                                            <script>
                                                 $("#singleqrprintsm'.$ke->id.'").click(function(){
                                                    var boxstockid = document.getElementById("boxstockid'.$ke->id.'").value;
                                                    $.ajax({
                                                        url: "'.URLROOT.'/pages/print_item_qr_for_carton_to_box_sm",
                                                        type: "POST",
                                                        data: {boxstockid},
                                                        success: function(response)
                                                        {
                                                             window.open(response);
                                                        }
                                                    });
                                                    
                                                 });
                                            </script>


                                            </td>
                                        ';
                                        $a = 0;
                                        $a = $all_it->qty * $ke->stock_on_hand;
                            $output .=  '<td><input type="text" name="item_id" id="item_id" value="'.$ke->item_id.'" style="display: none;">
                                        </td>
                                    </tr>
                                ';
                    }
                }
                elseif($ke->receivable==1)
                {
                    if($ke->stock_on_hand>0)
                    {
                        $output .=' 
                                <tr>
                                    <td><input type="text" name="stock_id" id="stock_id" class="form-control" value="EG'.$_SESSION["db_code"].$_SESSION["db_code"].''.$ke->id.'" readonly="true" autocomplete="off" /></td>

                                    <td><input type="text" name="stock_on_hand" id="stock_on_hand" class="form-control" value="'.$ke->stock_on_hand.'" readonly="true"></td>
                                    <td>
                                    </td><td>
                                    <input type="text" name="item_qty" id="item_qty" class="form-control" value="'.$all_it->qty.'" readonly="true">
                                    </td>
                                    <td>
                                        <input type="number" name="pieces" id="pieces" class="form-control" required="true" autocomplete="off" value="1" style="display: none;">
                                         <button type="submit" class="btn btn-primary" onclick="convert_box_item_purchase('.$ke->id.','.$temp_for_qr.')">Unbox</button>
                                    </td>';
                                    $a = 0;
                                    $a = $all_it->qty * $ke->stock_on_hand;
                        $output .=  '<td><input type="text" name="item_id" id="item_id" value="'.$ke->item_id.'" style="display: none;">
                                    </td>
                                </tr>
                            ';
                    }
                    else
                    {
                     $output .='<tr>
                                <td><input type="text" name="stock_id" class="form-control" value="EG'.$_SESSION["db_code"].$_SESSION["db_code"].''.$ke->id.'" readonly="true" autocomplete="off" />

                                </td>
                                <td><input type="text" name="stock_on_hand" class="form-control" value="1" readonly="true"></td>
                                <td>
                                
                                <input type="text" name="item_qty" class="form-control" value="'.$all_it->qty.'" readonly="true">
                                </td>
                                <td>
                                    <input type="number" name="pieces" class="form-control" required="true" autocomplete="off" value="1" style="display: none;">

                                  <input type="text" id="boxstockid'.$ke->id.'" class="form-control" value="'.$ke->id.'" readonly="true" autocomplete="off" style="display: none;"/>                              
                                <a id="singleqrprint'.$ke->id.'" class="btn btn-info text-white"><i class="fa fa-qrcode" aria-hidden="true"></i></a>

                                <script>
                                     $("#singleqrprint'.$ke->id.'").click(function(){
                                        var boxstockid = document.getElementById("boxstockid'.$ke->id.'").value;
                                        $.ajax({
                                            url: "'.URLROOT.'/pages/print_item_qr_for_single_pieces",
                                            type: "POST",
                                            data: {boxstockid},
                                            success: function(response)
                                            {
                                                 window.open(response);
                                            }
                                        });
                                        
                                     });
                                </script>
                                </td>
                                <td>
                                <a id="singleqrprintsm'.$ke->id.'" class="btn btn-secondary text-white"><i class="fa fa-qrcode" aria-hidden="true"></i></a>

                                <script>
                                     $("#singleqrprintsm'.$ke->id.'").click(function(){
                                        var boxstockid = document.getElementById("boxstockid'.$ke->id.'").value;
                                        $.ajax({
                                            url: "'.URLROOT.'/pages/print_item_qr_for_single_pieces_sm",
                                            type: "POST",
                                            data: {boxstockid},
                                            success: function(response)
                                            {
                                                 window.open(response);
                                            }
                                        });
                                        
                                     });
                                </script>


                                </td>';
                                $a = 0;
                                $a = $all_it->qty * $ke->stock_on_hand;
                        $output .= '<td><input type="text" name="item_id" value="'.$ke->item_id.'" style="display: none;">
                                </td>
                                
                            </tr>';
                    } 
                }
            }
                        
                    $output .='</tbody>
                </table>';
                echo $output;

        }
        public function getunbox_data_tomodal_carton()
        {
            $stock_id_for_refer = $_POST['id'];
            $temp_for_qr = $_POST['temp_for_qr'];
            $output = '';
            $output .='<table>
                    <thead>
                        <tr>
                            <th>QRCODE</th>
                            <th>Stock on hand</th>
                            <th>Item Box QTY</th>
                            <th>Item Piece QTY</th>
                            <th colspan="3">Action</th>
                            
                        </tr>
                    </thead>
                    <tbody>';
            $alst = $this->pageModel->count_of_unboxpurchase_get_stock_from_id_temp_data_carton($temp_for_qr,$stock_id_for_refer);
                foreach ($alst as $ke) 
                {
                    $all_it = $this->pageModel->get_single_item($ke->item_id);
                    if($ke->receivable==1)
                    {
                        if($ke->stock_on_hand>0)
                        {
                            $output .=' 
                                    <tr>
                                        <td><input type="text" name="stock_id" id="stock_id" class="form-control" value="EG'.$_SESSION["db_code"].''.$ke->id.'" readonly="true" autocomplete="off" /></td>

                                        <td><input type="text" name="stock_on_hand" id="stock_on_hand" class="form-control" value="'.$ke->stock_on_hand.'" readonly="true"></td>
                                        <td>
                                        </td><td>
                                        <input type="text" name="item_qty" id="item_qty" class="form-control" value="'.$all_it->qty.'" readonly="true">
                                        </td>
                                        <td>
                                            <input type="number" name="pieces" id="pieces" class="form-control" required="true" autocomplete="off" value="1" style="display: none;">
                                             <button type="submit" class="btn btn-primary" onclick="convert_box_item_purchase_carton('.$ke->id.','.$temp_for_qr.')">Unbox</button>
                                        </td>';
                                        $a = 0;
                                        $a = $all_it->qty * $ke->stock_on_hand;
                            $output .=  '<td><input type="text" name="item_id" id="item_id" value="'.$ke->item_id.'" style="display: none;">
                                        </td>
                                    </tr>
                                ';
                        }
                        else
                        {
                         $output .='<tr>
                                    <td><input type="text" name="stock_id" class="form-control" value="EG'.$_SESSION["db_code"].''.$ke->id.'" readonly="true" autocomplete="off" />

                                    </td>
                                    <td><input type="text" name="stock_on_hand" class="form-control" value="1" readonly="true"></td>
                                    <td>
                                    
                                    <input type="text" name="item_qty" class="form-control" value="'.$all_it->qty.'" readonly="true">
                                    </td>
                                    <td>
                                        <input type="number" name="pieces" class="form-control" required="true" autocomplete="off" value="1" style="display: none;">

                                      <input type="text" id="boxstockid'.$ke->id.'" class="form-control" value="'.$ke->id.'" readonly="true" autocomplete="off" style="display: none;"/>                              
                                    <a id="singleqrprint'.$ke->id.'" class="btn btn-info text-white"><i class="fa fa-qrcode" aria-hidden="true"></i></a>

                                    <script>
                                         $("#singleqrprint'.$ke->id.'").click(function(){
                                            var boxstockid = document.getElementById("boxstockid'.$ke->id.'").value;
                                            $.ajax({
                                                url: "'.URLROOT.'/pages/print_item_qr_for_single_pieces",
                                                type: "POST",
                                                data: {boxstockid},
                                                success: function(response)
                                                {
                                                     window.open(response);
                                                }
                                            });
                                            
                                         });
                                    </script>
                                    </td>
                                    <td>
                                    <a id="singleqrprintsm'.$ke->id.'" class="btn btn-secondary text-white"><i class="fa fa-qrcode" aria-hidden="true"></i></a>

                                    <script>
                                         $("#singleqrprintsm'.$ke->id.'").click(function(){
                                            var boxstockid = document.getElementById("boxstockid'.$ke->id.'").value;
                                            $.ajax({
                                                url: "'.URLROOT.'/pages/print_item_qr_for_single_pieces_sm",
                                                type: "POST",
                                                data: {boxstockid},
                                                success: function(response)
                                                {
                                                     window.open(response);
                                                }
                                            });
                                            
                                         });
                                    </script>


                                    </td>';
                                    $a = 0;
                                    $a = $all_it->qty * $ke->stock_on_hand;
                            $output .= '<td><input type="text" name="item_id" value="'.$ke->item_id.'" style="display: none;">
                                    </td>
                                    
                                </tr>';
                        } 
                    }
                }
                        
                    $output .='</tbody>
                </table>';
                echo $output;

        }

        public function makeBill($rId)
        {
            $receive = $this->pageModel->getTheReceiveDetails($rId);
            $data = [
                'rDetails' => $receive,
                'po' => $this->pageModel->getThePurchaseItemDetails($receive->purchase_order_id),
                'pid' => $receive->purchase_order_id,
                'rid' => $rId
            ];
            $this->view('pages/makeBill', $data);
        }

        public function saveBill($pid)
        {
            // $product = implode('|||', $_POST['product']);
            $itemId = array();
            $itemName = array();

            for ($i = 0; $i < sizeof($_POST['product']); $i++) {
                $first = explode('(', $_POST['product'][$i]);
                $second = explode(')', $first[1]);

                $itemId[] = $second[0];
                $itemName[] = $first[0];
            }
            $itemId = implode('|||', $itemId);
            $itemName = implode('|||', $itemName);
            $qty = implode('|||', $_POST['qty']);
            $price = implode('|||', $_POST['price']);
            $total = implode('|||', $_POST['total']);
            $subTotal = $_POST['sub_total'];
            $tax = $_POST['tax'];
            $taxAmount = $_POST['tax_amount'];
            $discount = $_POST['discount'];
            $discountAmount = $_POST['discount_amount'];
            $totalAmount = $_POST['total_amount'];
            $rid = $_POST['rid'];

            $this->pageModel->saveTheBillDb($itemId, $itemName, $qty, $price, $total, $subTotal, $tax, $taxAmount, $discount, $discountAmount, $totalAmount, $pid, $rid);
            redirect('pages/purchase_order');
        }

        public function getTheBillsForModal()
        {
            $bills = $this->pageModel->getTheBillsDb($_POST['pId']);
            $output = "
                <table class='table'>
                    <thead>
                        <tr>
                            <th>Sl.No.</th>
                            <th>Item</th>
                            <th>Amount</th>
                            <th width='150' style='text-align:center'>Action</th>
                        </tr>
                    </thead>
            ";
            $i = 1;
            foreach ($bills as $key) {
                $items = explode('|||', $key->item_name);
                $item = implode('<br>', $items);
                $output .= "<tr>
                    <td>" . $i . "</td>
                    <td>" . $item . "</td>
                    <td>" . $key->item_total . "</td>";

                $output .= "<td><a href='" . URLROOT . "/pages/viewBill/" . $key->bill_id . "'><button class='btn btn-primary btn-sm' style='text-align:center'>View Bill</button></a></td></tr>";

                $i++;
            }
            $output .= "</table>";
            echo $output;
        }
        public function viewBill($id)
        {
            $data = [
                'single_bill' => $this->pageModel->get_single_bill_from_id($id)
            ];
            $this->view('pages/view_bill', $data);
        }

        public function add_positions()
        {
            $posCode = $_POST['posCode'];
            $posDetails = $_POST['posDetails'];

            $this->pageModel->saveThePositions($posCode, $posDetails);
            redirect('pages/settings');
        }

        

        
        public function all_positions()
        {
            $this->view('pages/all_positions');
        }

        public function getTheItemCostPrice()
        {
            $itemId = $_POST['val'];
            $item = $this->pageModel->getTheCostPriceForTheItem($itemId);
            echo $item->selling_price;
        }
        public function getTheItem_for_qty()
        {
            $itemId = $_POST['val'];
            $item = $this->pageModel->getTheqtyForTheItem($itemId);
            echo $item->available_stock;
        }
        public function edititem($id)
        {   
            $data = [
                'item' => $this->pageModel->get_single_item($id),
                'cat' => $this->pageModel->getAllCategoriesDb(),
                'cat1' => $this->pageModel->getAllCategoriesDb2(),
                'cat2' => $this->pageModel->getAllCategoriesDb3(),
                'cat3' => $this->pageModel->getAllCategoriesDb4(),
                'type' => $this->pageModel->getAlltypeDb(),
                'model' => $this->pageModel->getAllCategoriesDb_model(),
                'cat_new' => $this->pageModel->getAllCategoriesDb_new(),
                'subcat_new' => $this->pageModel->getAllsubCategoriesDb_new(),
                'color' => $this->pageModel->getAllcolorDb_new(),
                'size' => $this->pageModel->getAllsizeDb_new(),
                'all_mfg' => $this->pageModel->getallmfg(),

            ];
            $this->view('pages/edititem', $data);
        }

        public function additem()
        {
            $data = [
                'cat' => $this->pageModel->getAllCategoriesDb(),
                'cat1' => $this->pageModel->getAllCategoriesDb2(),
                'cat2' => $this->pageModel->getAllCategoriesDb3(),
                'cat3' => $this->pageModel->getAllCategoriesDb4(),
                'type' => $this->pageModel->getAlltypeDb(),
                'model' => $this->pageModel->getAllCategoriesDb_model(),
                'cat_new' => $this->pageModel->getAllCategoriesDb_new(),
                'color' => $this->pageModel->getAllcolorDb_new(),
                'size' => $this->pageModel->getAllsizeDb_new(),
                'all_mfg' => $this->pageModel->getallmfg(),
            ];
            $this->view('pages/additem', $data);
        }
        public function create_item()
        {
            $mfg_id = $_POST['man_name'];
            $x = $this->pageModel->getmfgsingle($_POST['man_name']);
            $man_name = $x->mfg_name;
            $data = [
                'type_id' => $_POST['type_id'],
                'model_id' => $_POST['model_id'],
                'category_new_id' => $_POST['category_new_id'],
                'subcategory_new_id' => $_POST['subcategory_new_id'],
                'color_id' => $_POST['color_id'],
                'size_id' => $_POST['size_id'],   
                'barcode' => $_POST['barcode'],
                'name' => $_POST['name'],
                'sku' => $_POST['sku'],
                'unit' => $_POST['unit'],
                'Length' => $_POST['Length'],
                'width' => $_POST['width'],
                'height' => $_POST['height'],
                'man_name' => $man_name,
                'mfg_id' => $mfg_id,
                'upc' => $_POST['upc'],
                'ean' => $_POST['ean'],
                'weight' => $_POST['weight'],
                'brand' => $_POST['brand'],
                'mpn' => $_POST['mpn'],
                'isbn' => $_POST['isbn'],
                'selling_price' => $_POST['selling_price'],
                's_account' => $_POST['s_account'],
                's_description' => $_POST['s_description'],
                'purchase_price' => $_POST['purchase_price'],
                'p_account' => $_POST['p_account'],
                'p_description' => $_POST['p_description'],
                'inventory_type' => $_POST['inventory_type'],
                'opening_stock' => $_POST['opening_stock'],
                'reorder_point' => $_POST['reorder_point'],
                'opening_stock_rate' => $_POST['opening_stock_rate'],
                'vendor' => $_POST['vendor'],
                'vendor_id' => $_POST['vendor_id'],
                'category' => $_POST['category_id'],
                'sub_category' => $_POST['sc_id'],
                'sub_category2' => $_POST['sc_id2'],
                'sub_category3' => $_POST['sc_id3'],
                'rec' => $_POST['rec'],
                'cartonNumber' => $_POST['cartonNumber'],
                'recNumber' => $_POST['recNumber'],
                'discount' => $_POST['discount'],
                'hsn' => $_POST['hsn'],
                'tax_pre' => $_POST['tax_pre'],
                'gst' => $_POST['gst'],
                'igst' => $_POST['igst'],
                'minstock' => $_POST['minstock'],
                'maxstock' => $_POST['maxstock'],
                'part_no' => $_POST['part_no'],
            ];
            $this->pageModel->search_item($data['name']);
            $this->pageModel->add_item($data);
            $_SESSION['success'] = 'Item added successfully';
            redirect('pages/all_items');
        }
        public function convert_box_item($dt)
        {
            $dt = explode("|",$dt);
            $id = $dt[0];
            $stock_id = $dt[1];
            $stock_on_hand = $dt[2];
            $item_qty = $dt[3];
            $pieces = 1;
            if($stock_on_hand >= $pieces)
            {
                $a =0;
                $a = $a + $pieces + $stock_on_hand;
                if($this->pageModel->update_stock_convert($id,$a,$item_qty,$pieces))
                {        
                    $_SESSION['success'] = "Successfully Unboxed";
                    redirect('pages/all_non_purchase_order');
                }
            }
            else
            {
                $_SESSION['success'] = "Max QTY to Unbox ".$_POST['stock_on_hand'];        
                redirect('pages/all_non_purchase_order');   
            }
        }
        public function convert_carton_item($dt)
        {
            $dt = explode("|",$dt);
            $id = $dt[0];
            $stock_id = $dt[1];
            $stock_on_hand = $dt[2];
            $item_qty = $dt[3];
            $carton_qty = $dt[4];
            $pieces = 1;
            if($stock_on_hand >= $pieces)
            {
                $a =0;
                $a = $a + $pieces + $stock_on_hand;
                // $this->pageModel->update_stock_convert_carton_non_purchase($id,$a,$item_qty,$pieces,$carton_qty);
                if($this->pageModel->update_stock_convert_carton_non_purchase($id,$a,$item_qty,$pieces,$carton_qty))
                {        
                    $_SESSION['success'] = "Successfully converted to box";
                    redirect('pages/all_non_purchase_order');
                }
                redirect('pages/all_non_purchase_order');
            }
            else
            {
                $_SESSION['success'] = "Max QTY to Unbox ".$_POST['stock_on_hand'];        
                redirect('pages/all_non_purchase_order');   
            }
        }
        public function convert_carton_item_purchase()
        {
            $id = $_POST['id'];
            if($_POST['stock_on_hand'] >= $_POST['pieces'])
            {
                $stock_id = $_POST['stock_id'];
                $stock_on_hand = $_POST['stock_on_hand'];
                $item_qty = $_POST['item_qty'];
                $item_qty_carton = $_POST['item_qty_carton'];
                $pieces = $_POST['pieces'];
                $a =0;
                $a = $a + $pieces + $stock_on_hand;
                // $this->pageModel->update_stock_convert_carton($id,$a,$item_qty,$pieces,$item_qty_carton);
                if($this->pageModel->update_stock_convert_carton($id,$a,$item_qty,$pieces,$item_qty_carton))
                {    
                    echo "Successfully Converted to Box";    
                }
            }
            else
            {
                echo "Max QTY";
            }

        }
        public function convert_after_carton_to_box_item_purchase()
        {
            $id = $_POST['id'];
            if($_POST['stock_on_hand'] >= $_POST['pieces'])
            {
                $stock_id = $_POST['stock_id'];
                $stock_on_hand = $_POST['stock_on_hand'];
                $item_qty = $_POST['item_qty'];
                $pieces = $_POST['pieces'];
                $a =0;
                $a = $a + $pieces + $stock_on_hand;
                $this->pageModel->update_stock_convert_for_after_carton_box($id,$a,$item_qty,$pieces);
                if($this->pageModel->update_stock_convert($id,$a,$item_qty,$pieces))
                {    
                    echo "Successfully Unboxed";    
                }
            }
            else
            {
                echo "Max QTY";
            }

        }
        public function convert_box_item_purchase()
        {
            $id = $_POST['id'];
            if($_POST['stock_on_hand'] >= $_POST['pieces'])
            {
                $stock_id = $_POST['stock_id'];
                $stock_on_hand = $_POST['stock_on_hand'];
                $item_qty = $_POST['item_qty'];
                $pieces = $_POST['pieces'];
                $a =0;
                $a = $a + $pieces + $stock_on_hand;
                if($this->pageModel->update_stock_convert($id,$a,$item_qty,$pieces))
                {    
                    echo "Successfully Unboxed";    
                }
            }
            else
            {
                echo "Max QTY";
            }

        }


        public function all_items()
        {   
            $data = [
                'cat' => $this->pageModel->getAllCategoriesDb(),
                'cat1' => $this->pageModel->getAllCategoriesDb2(),
                'cat2' => $this->pageModel->getAllCategoriesDb3(),
                'cat3' => $this->pageModel->getAllCategoriesDb4(),
                'all_items' => $this->pageModel->get_all_category_wise_details(),

                'type' => $this->pageModel->getAlltypeDb(),
                'model' => $this->pageModel->getAllCategoriesDb_model(),
                'cat_new' => $this->pageModel->getAllCategoriesDb_new(),
                'subcat_new' => $this->pageModel->getAllsubCategoriesDb_new(),
                'color' => $this->pageModel->getAllcolorDb_new(),
                'size' => $this->pageModel->getAllsizeDb_new(),
                'all_mfg' => $this->pageModel->getallmfg(),

            ];
            $this->view('pages/all_items',$data);
        }


        public function update_item()
        {
            $mfg_id = $_POST['man_name'];
            $x = $this->pageModel->getmfgsingle($_POST['man_name']);
            $man_name = $x->mfg_name;
            $id = $_POST['id'];
            $data = [
                'type_id' => $_POST['type_id'],
                'model_id' => $_POST['model_id'],
                'category_new_id' => $_POST['category_new_id'],
                'subcategory_new_id' => $_POST['subcategory_new_id'],
                'color_id' => $_POST['color_id'],
                'size_id' => $_POST['size_id'],
                'barcode' => $_POST['barcode'],
                'name' => $_POST['name'],
                'sku' => $_POST['sku'],
                'unit' => $_POST['unit'],
                'Length' => $_POST['Length'],
                'width' => $_POST['width'],
                'height' => $_POST['height'],
                'man_name' => $man_name,
                'mfg_id' => $mfg_id,
                'upc' => $_POST['upc'],
                'ean' => $_POST['ean'],
                'weight' => $_POST['weight'],
                'brand' => $_POST['brand'],
                'mpn' => $_POST['mpn'],
                'isbn' => $_POST['isbn'],
                'selling_price' => $_POST['selling_price'],
                's_account' => $_POST['s_account'],
                's_description' => $_POST['s_description'],
                'purchase_price' => $_POST['purchase_price'],
                'p_account' => $_POST['p_account'],
                'p_description' => $_POST['p_description'],
                'inventory_type' => $_POST['inventory_type'],
                'opening_stock' => $_POST['opening_stock'],
                'reorder_point' => $_POST['reorder_point'],
                'opening_stock_rate' => $_POST['opening_stock_rate'],
                'vendor' => $_POST['vendor'],
                'vendor_id' => $_POST['vendor_id'],
                'category' => $_POST['category_id'],
                'sub_category' => $_POST['sc_id'],
                'sub_category2' => $_POST['sc_id2'],
                'sub_category3' => $_POST['sc_id3'],
                'rec' => $_POST['rec'],
                'cartonNumber' => $_POST['cartonNumber'],
                'recNumber' => $_POST['recNumber'],
                'discount' => $_POST['discount'],
                'hsn' => $_POST['hsn'],
                'tax_pre' => $_POST['tax_pre'],
                'gst' => $_POST['gst'],
                'igst' => $_POST['igst'],
                'minstock' => $_POST['minstock'],
                'maxstock' => $_POST['maxstock'],
                'part_no' => $_POST['part_no'],
            ];
            $this->pageModel->edit_item($data, $id);
            $_SESSION['success'] = 'Item Updated successfully';
            redirect('pages/all_items');
        }



        public function update_category()
        {
            if ($this->pageModel->checkForDuplicateCategory($_POST['cName']) > 0) {
                $_SESSION['success'] = "Category already exists";
                redirect('pages/all_categories');
            } else {
                $this->pageModel->updateCategoryDb($_POST['id'], $_POST['cName']);
                $_SESSION['success'] = "Category updated";
                redirect('pages/all_categories');
            }
        }
        public function update_type()
        {
                $this->pageModel->updatetypeDb($_POST['id'], $_POST['type']);
                $_SESSION['success'] = "Type updated";
                redirect('pages/all_types');
        }

        public function settings()
        {
            $data = [
                'cat' => $this->pageModel->getAllCategoriesDb(),
                'cat2' => $this->pageModel->getAllCategoriesDb2(),
                'cat3' => $this->pageModel->getAllCategoriesDb3(),
                'comp_details' => $this->pageModel->comp_details(),
                'type' => $this->pageModel->getAlltypeDb(),
                'model' => $this->pageModel->getAllCategoriesDb_model(),
                'cat_new' => $this->pageModel->getAllCategoriesDb_new(),

            ];
            $this->view('pages/settings', $data);
        }
        public function all_companydetails()
        {
            $data=[
            'company' => $this->pageModel->get_all_companydetails(),
            ];
            $this->view('pages/all_companydetails',$data);
        }
        
         public function all_size()
        {
            $data =[ 
                    'size' => $this->pageModel->getAllsizeDb_new(), 
                   ];
            $this->view('pages/all_size', $data);
        }
        public function del_size($id)
        {
            $a =0;
            $x = $this->pageModel->get_all_items_by_size_db($id);
            foreach ($x as $k)
            {
                $a = $a+1;
            }
            if($a>0)
            {
               $_SESSION['success'] = "cannot delete size. its used in project";
                redirect('pages/all_size');
            }
            else
            {
                $this->pageModel->delete_size($id);
                $_SESSION['success'] = "size deleted successfully";
                redirect('pages/all_size');
            }
        }
         public function all_color()
        {
            $data =[ 
                    'color' => $this->pageModel->getAllcolorDb_new(), 
                   ];
            $this->view('pages/all_color', $data);
        }
         public function all_manufacturer()
        {
            $data =[ 
                    'all_mfg' => $this->pageModel->getAllmfg(), 
                   ];
            $this->view('pages/all_manufacturer', $data);
        }
        public function del_manufacturer($id)
        {
            $a =0;
            $x = $this->pageModel->get_all_items_by_manufacturer_db($id);
            foreach ($x as $k)
            {
                $a = $a+1;
            }
            if($a>0)
            {
               $_SESSION['success'] = "cannot delete manufacturer. its used in project";
                 redirect('pages/all_manufacturer');
            }
            else
            {
                $this->pageModel->delete_mfg($id);
                $_SESSION['success'] = "manufacturer deleted successfully";
                redirect('pages/all_manufacturer');
            }
        }
        public function del_color($id)
        {
            $a =0;
            $x = $this->pageModel->get_all_items_by_color_db($id);
            foreach ($x as $k)
            {
                $a = $a+1;
            }
            if($a>0)
            {
               $_SESSION['success'] = "cannot delete color. its used in project";
                 redirect('pages/all_color');
            }
            else
            {
                $this->pageModel->delete_color($id);
                $_SESSION['success'] = "color deleted successfully";
                redirect('pages/all_color');
            }
        }

         public function add_type()
        {
            $this->pageModel->saveCategoryDb_for_type($_POST['type']);
            $_SESSION['success'] = "Type Added successfully";
            redirect('pages/settings');
        }
        public function add_color()
        {
            $this->pageModel->savecolor($_POST['color']);
            $_SESSION['success'] = "Color Added successfully";
            redirect('pages/settings');
        }
        public function add_manufacturer()
        {
            $this->pageModel->savemfg($_POST['manufacturer']);
            $_SESSION['success'] = "Manufacturer Added successfully";
            redirect('pages/settings');
        }

        public function add_size()
        {
            $this->pageModel->savesize($_POST['size']);
            $_SESSION['success'] = "Size Added successfully";
            redirect('pages/settings');
        }

        public function add_category()
        {
            if ($this->pageModel->checkForDuplicateCategory($_POST['cName']) > 0) {
                $_SESSION['checkForCategory'] = 1;
                redirect('pages/settings');
            } else {
                $this->pageModel->saveCategoryDb($_POST['cName']);
                $_SESSION['successForCategory'] = 1;
                redirect('pages/settings');
            }
        }
       

       
        public function all_categories()
        {
            $this->view('pages/all_categories');
        }
         public function all_types()
        {
            $data = [ 'all_types' => $this->pageModel->getalltypes_for_all_direct(),];
            $this->view('pages/all_types',$data);
        }
        public function all_categories_new()
        {
            $data = [ 'all_categories_new' => $this->pageModel->getAllcategory_new_direct(), ];
            $this->view('pages/all_categories_new',$data);
        }       

        public function allCategories()
        {
            $lim = $_POST['lim'];
            $lim = (int)$lim;
            if ($lim == 9) {
                $off = $_POST['off'];
                $off = (int)$off;
                $allCategory = $this->pageModel->getAllCategories($lim, $off);
            } else {
                $inc = $_POST['inc'];
                $inc = (int)$inc;
                $lim = 9;
                $off = 9 + (9 * $inc);
                $allCategory = $this->pageModel->getAllCategories($lim, $off);
            }
            $output = '';
            
            foreach ($allCategory as $key) {
                $output .= '<tr>
                    <td>' . $key->category_id . '</td>
                    <td>' . $key->category_name . '</td>
                    <td>
                        <a href="' . URLROOT . '/pages/edit_category/' . $key->category_id . '" class="btn btn-success-rgba"><i class="ri-pencil-line"></i></a>
                    </td>
                </tr>';
                
            }
            echo $output;
        }
        public function allTYpes()
        {
            $lim = $_POST['lim'];
            $lim = (int)$lim;
            if ($lim == 9) {
                $off = $_POST['off'];
                $off = (int)$off;
                $getalltypes = $this->pageModel->getalltypes_for_all($lim, $off);
            } else {
                $inc = $_POST['inc'];
                $inc = (int)$inc;
                $lim = 9;
                $off = 9 + (9 * $inc);
                $getalltypes = $this->pageModel->getalltypes_for_all($lim, $off);
            }
            $output = '';
            
            foreach ($getalltypes as $key) {
                $output .= '<tr>
                    <td>' . $key->type_id . '</td>
                    <td>' . $key->type_name . '</td>
                    <td>
                        <a href="' . URLROOT . '/pages/edit_types/' . $key->type_id . '" class="btn btn-success-rgba"><i class="ri-pencil-line"></i></a>
                        &nbsp<a href="'.URLROOT.'/pages/delete_type_new/'.$key->type_id.'" class="btn btn-danger-rgba"><i class="dripicons-archive"></i></a>
                    </td>
                </tr>';
                
            }
            echo $output;
        }
         public function delete_type_new($id)
        {
            $a =0;
            $x = $this->pageModel->get_all_items_by_type_db($id);
            foreach ($x as $k)
            {
                $a = $a+1;
            }
            if($a>0)
            {
                $_SESSION['success'] = "Type used in project, cannot delete";
                redirect('pages/all_types');
            }
            else
            {
                $this->pageModel->delete_type_db($id);
                $_SESSION['success'] = "Type deleted Successfully";
                redirect('pages/all_types');
            }
        }
        public function add_subcategory()
        {
            // check for the duplicates of the sub category
            if ($this->pageModel->checkForTheSubCategory($_POST['sCName'], $_POST['cId']) > 0) {
                $_SESSION['checkForTheSubCategory'] = 1;
                redirect('pages/settings');
            } else {
                $this->pageModel->saveSC($_POST['sCName'], $_POST['cId']);
                $_SESSION['sessionForTheSubCategory'] = 1;
                redirect('pages/settings');
            }
        }
        public function add_model()
        {
            $this->pageModel->saveSC_for_model($_POST['mname'], $_POST['tid']);
            $_SESSION['success'] = "Model Added successfully";
            redirect('pages/settings');
        }

        public function edit_types($id)
        {
            $data = ['getAlltypeDb_single' => $this->pageModel->getAlltypeDb_single($id)];
            $this->view('pages/edit_type', $data);
        }
        public function edit_category($id)
        {
            $data = ['all_categories' => $this->pageModel->get_all_category($id)];
            $this->view('pages/edit_category', $data);
        }


        public function all_subcategories()
        {
            $this->view('pages/all_subcategories');
        }

        public function allSubCategories()
        {
            $lim = $_POST['lim'];
            $lim = (int)$lim;
            if ($lim == 9) {
                $off = $_POST['off'];
                $off = (int)$off;
                $allCategory = $this->pageModel->getAllSubCategories($lim, $off);
            } else {
                $inc = $_POST['inc'];
                $inc = (int)$inc;
                $lim = 9;
                $off = 9 + (9 * $inc);
                $allCategory = $this->pageModel->getAllSubCategories($lim, $off);
            }
            $output = '';
            
            foreach ($allCategory as $key) {
                $cName = $this->pageModel->getCategoryName($key->category_id);
                $output .= '<tr>
                    <td>' . $key->sc_id . '</td>
                    <td>' . $key->sc_name . '</td>
                    <td>' . $cName . '</td>
                    <td><a href="' . URLROOT . '/pages/edit_subcategory/' . $key->sc_id . '" class="btn btn-success-rgba"><i class="ri-pencil-line"></i></a></td>
                </tr>';
                
            }
            echo $output;
            
        }
        public function edit_subcategory($id)
        {
            $data = ['get_all_subcategory' => $this->pageModel->get_all_subcategory($id)];
            $this->view('pages/edit_subcategory', $data);
        }


        public function subCategory()
        {
            $subC = $this->pageModel->getSubCategoryByCategoryId($_POST['categoryId']);
            $count =0;
            foreach ($subC as $ky) {
               $count = $count + 1;
            }
            $output = "";
            $output .= "<option selected='' disabled=''>--select--</option>";
            foreach ($subC as $key) {
                $output .= "<option value=" . $key->sc_id . ">" . $key->sc_name . "</option>";
            }
            echo $output;
        }
        public function types()
        {
            $subC = $this->pageModel->getmodels_by_id($_POST['typeid']);
            $count =0;
            foreach ($subC as $ky) {
               $count = $count + 1;
            }
            $output = "";
            $output .= "<option selected='' disabled=''>--select--</option>";
            foreach ($subC as $key) {
                $output .= "<option value=" . $key->model_id . ">" . $key->model_name . "</option>";
            }
            echo $output;
        }
         public function types1()
        {
            $subC = $this->pageModel->getmodels_by_id($_POST['typeid']);
            $count =0;
            foreach ($subC as $ky) {
               $count = $count + 1;
            }
            $output = "";
            $output .= "<option selected='' disabled=''>--select--</option>";
            foreach ($subC as $key) {
                $output .= "<option value=" . $key->model_id . ">" . $key->model_name . "</option>";
            }
            echo $output;
        }
        public function types2()
        {
            $subC = $this->pageModel->getmodels_by_id($_POST['typeid']);
            $count =0;
            foreach ($subC as $ky) {
               $count = $count + 1;
            }
            $output = "";
            $output .= "<option selected='' disabled=''>--select--</option>";
            foreach ($subC as $key) {
                $output .= "<option value=" . $key->model_id . ">" . $key->model_name . "</option>";
            }
            echo $output;
        }
        public function types3()
        {
            $subC = $this->pageModel->getmodels_by_id($_POST['typeid']);
            $count =0;
            foreach ($subC as $ky) {
               $count = $count + 1;
            }
            $output = "";
            $output .= "<option selected='' disabled=''>--select--</option>";
            foreach ($subC as $key) {
                $output .= "<option value=" . $key->model_id . ">" . $key->model_name . "</option>";
            }
            echo $output;
        }
         public function types4()
        {
            $subC = $this->pageModel->getmodels_by_id($_POST['typeid']);
            $count =0;
            foreach ($subC as $ky) {
               $count = $count + 1;
            }
            $output = "";
            $output .= "<option selected='' disabled=''>--select--</option>";
            foreach ($subC as $key) {
                $output .= "<option value=" . $key->model_id . ">" . $key->model_name . "</option>";
            }
            echo $output;
        }
        public function models()
        {
            $subC = $this->pageModel->getcategory_new_by_id($_POST['model']);
            $count =0;
            foreach ($subC as $ky) {
               $count = $count + 1;
            }
            $output = "";
            $output .= "<option selected='' disabled=''>--select--</option>";
            foreach ($subC as $key) {
                $output .= "<option value=" . $key->category_id . ">" . $key->category_name . "</option>";
            }
            echo $output;
        }
        public function category_new()
        {
            $subC = $this->pageModel->getsubcategory_new_by_id($_POST['cat_new']);
            $count =0;
            foreach ($subC as $ky) {
               $count = $count + 1;
            }
            $output = "";
            $output .= "<option selected='' disabled=''>--select--</option>";
            foreach ($subC as $key) {
                $output .= "<option value=" . $key->sc_id . ">" . $key->sc_name . "</option>";
            }
            echo $output;
        }
        public function sub_category_new()
        {
            $subC = $this->pageModel->getsubcategory_new_by_id($_POST['subCategory_new']);
            $count =0;
            foreach ($subC as $ky) {
               $count = $count + 1;
            }
            $output = "";
            $output .= "<option selected='' disabled=''>--select--</option>";
            foreach ($subC as $key) {
                $output .= "<option value=" . $key->sc_id . ">" . $key->sc_name . "</option>";
            }
            echo $output;
        }
        public function subCategory1()
        {
            $subC = $this->pageModel->getSubCategoryByCategoryId1($_POST['subCategory']);
            $output = "";

            foreach ($subC as $key) {
                $output .= "<option value=" . $key->sc2_id . ">" . $key->sc2_name . "</option>";
            }
            echo $output;
        }
        public function subCategory_2()
        {
            $subC = $this->pageModel->getSubCategoryByCategoryId2($_POST['subCategory1']);
            $output = "";

            foreach ($subC as $key) {
                $output .= "<option value=" . $key->sc3_id . ">" . $key->sc3_name . "</option>";
            }
            echo $output;
        }

        public function updatesubCategoryDb()
        {
            // check for the duplicates of the sub category
            if ($this->pageModel->checkForTheSubCategory($_POST['sCName'], $_POST['cId']) > 0) {
                $_SESSION['success'] = "Sub Category already exists";
                redirect('pages/all_subcategories');
            } else {
                $this->pageModel->updatesubCategoryDb($_POST['cId'], $_POST['cName']);
                $_SESSION['success'] = "SubCategory updated";
                redirect('pages/all_subcategories');
            }
        }
        public function get_all_vender_for_auto_complete()
        {
            $output = "";
            $tags = $_POST['tags'];
            $items = $this->pageModel->getall_venders_by_tags($tags);
            foreach ($items as $key) {
                $val = [
                    'id' => $key->vendor_id,
                    'name' => $key->dispName
                ];
                $v = json_encode($val);
                $output .= "<a class='dropdown-item hvr' style='border-bottom:1px lightgray solid' href='#itemDetails' onclick='selectProduct(" . $v . ")'>" . $key->dispName . "</a>";
            }
            echo $output;
        }

        public function get_all_vender_for_auto_complete_vname()
        {
            $output = "";
            $tags = $_POST['vname'];

            $items = $this->pageModel->getall_venders_by_tags($tags);
            foreach ($items as $key) {
                $val = [
                    'id' => $key->vendor_id,
                    'name' => $key->dispName,
                    'address' => $key->attension . " " . $key->street1 . " " . $key->street2 . " " . $key->city . " " . $key->state . " " . $key->country . " " . $key->zipcode . " " . $key->phoneAdd . " " . $key->fax,
                ];
                $v = json_encode($val);
                $output .= "<a class='dropdown-item hvr' style='border-bottom:1px lightgray solid' href='#' onclick='selectProductvname(" . $v . ")'>" . $key->dispName . "</a>";
            }
            echo $output;
        }
        public function get_cu_bill()
        {
            $id = $_POST['cid'];
            $key = $this->pageModel->get_cust_bill_for_onclick($id);
            echo $key->b_attention . " " . $key->b_street1 . " " . $key->b_street2 . " " . $key->b_city . " " . $key->b_state . " " . $key->b_country . " " . $key->b_zip_code . " " . $key->b_phone . " " . $key->b_fax;
        }
         public function get_cu_bill1()
        {
            
            $id = $_POST['cid'];
            $key = $this->pageModel->get_cust_bill_for_onclick($id);
            echo $key->customer_display_name;
        }
         public function get_ve_bill()
        {
            
            $id = $_POST['vid'];
            $key = $this->pageModel->get_vendor_bill_for_onclick($id);
            echo $key->dispName;
        }
         public function get_ve_bill1()
        {
            
            $id = $_POST['vid'];
            $key = $this->pageModel->get_vendor_bill_for_onclick($id);
            echo $key->attension . " " . $key->street1 . " " . $key->street2 . " " . $key->city . " " . $key->state . " " . $key->country . " " . $key->zipcode . " " . $key->phoneAdd . " " . $key->fax;
        }
        public function get_all_customer_for_auto_complete_cname()
        {
            $output = "";
            $tags = $_POST['cname'];
            $items = $this->pageModel->getall_customer_by_tags($tags);
            foreach ($items as $key) {
                $val = [
                    'id' => $key->id,
                    'name' => $key->customer_display_name,
                    'address' => $key->b_attention . " " . $key->b_street1 . " " . $key->b_street2 . " " . $key->b_city . " " . $key->b_state . " " . $key->b_country . " " . $key->b_zip_code . " " . $key->b_phone . " " . $key->b_fax,
                ];
                $v = json_encode($val);
                $output .= "<a class='dropdown-item hvr' style='border-bottom:1px lightgray solid' href='#' onclick='selectProductcname(" . $v . ")'>" . $key->customer_display_name . "</a>";
            }
            echo $output;
        }
         public function get_all_distributorr_for_auto_complete_dname()
        {
            $output = "";
            $tags = $_POST['dname'];
            $items = $this->pageModel->getall_distributor_by_tags($tags);
            foreach ($items as $key) {
                $val = [
                    'id' => $key->id,
                    'name' => $key->distributor_display_name,
                    'address' => $key->b_attention . " " . $key->b_street1 . " " . $key->b_street2 . " " . $key->b_city . " " . $key->b_state . " " . $key->b_country . " " . $key->b_zip_code . " " . $key->b_phone . " " . $key->b_fax,
                ];
                $v = json_encode($val);
                $output .= "<a class='dropdown-item hvr' style='border-bottom:1px lightgray solid' href='#' onclick='selectProductcname(" . $v . ")'>" . $key->distributor_display_name . "</a>";
            }
            echo $output;
        }
        
        public function item_delete($id)
        {
            $this->pageModel->del_item($id);
            $_SESSION['success'] = "item deleted successfully";
            redirect('pages/all_items');
        }


        //************************pavan */
        public function add_tax()
        {
            if ($this->pageModel->checkforduptax($_POST['tax']) > 0) {
                $_SESSION['success'] = "tax already exist";
                redirect('pages/settings');
            } else {
                $this->pageModel->savetax($_POST['tax']);
                $_SESSION['success'] = "tax added";
                redirect('pages/settings');
            }
            $this->view('pages/settings');
        }
        public function allPositions()
        {
            $lim = $_POST['lim'];
            $lim = (int)$lim;
            if ($lim == 9) {
                $off = $_POST['off'];
                $off = (int)$off;
                $allPo = $this->pageModel->getAllPositions($lim, $off);
            } else {
                $inc = $_POST['inc'];
                $inc = (int)$inc;
                $lim = 9;
                $off = 9 + (9 * $inc);
                $allPo = $this->pageModel->getAllPositions($lim, $off);
            }
            $output = '';

            foreach ($allPo as $key) {
                $output .= "<tr>
                    <td>" . $key->position_code . "</td>
                    <td>" . $key->position_details . "</td>
                    <td style='text-align: center;'>
                        <a href='". URLROOT . "/pages/edit_position/" . $key->position_id . "' class='btn btn-primary btn-sm' >Edit</a>
                    </td>
                </tr>";
            }
            echo $output;
        }
        public function edit_position($id)
        {
            $data = ['position' => $this->pageModel->get_single_position($id)];
            $this->view('pages/edit_position',$data);
        }
        public function getTheTaxSystem()
        {
            $itemId = $_POST['itemId'];
            $st = $_POST['st'];
            $taxValue = [0, 5, 12, 18, 28];
            $output = "<select class='form-control' id='xgst' name='stax'>";

            $tax = $this->pageModel->getTheTax($itemId);
            if($st == 1)
            {
                foreach ($taxValue as $t)
                {
                    if($t == $tax->gst)
                    {
                        $output .= "<option selected value='".$t."' >".$t."%</option>";
                    }
                    else
                    {
                        $output .= "<option value='".$t."' >".$t."%</option>";
                    }
                }
            }
            if($st == 2)
            {
                foreach ($taxValue as $t)
                {
                    if($t == $tax->igst)
                    {
                        $output .= "<option selected value='".$t."' >".$t."%</option>";
                    }
                    else
                    {
                        $output .= "<option value='".$t."' >".$t."%</option>";
                    }
                }
            }
            echo $output .= "</select>";
        }
        public function tempSaleData()
        {
            $sta = $_POST['sta'];
            $item_id = $_POST['item_id'];
            $sItem = $_POST['sItem'];
            $sQty = $_POST['sQty'];
            $sPrice = $_POST['sPrice'];
            $sTax = $_POST['sTax'];
            $sTotal = $_POST['sTotal'];

            $k = $this->pageModel->saveTheSalesTempData($sta, $item_id, $sItem, $sQty, $sPrice, $sTax, $sTotal);
            $slNo = $this->pageModel->getTheTempSalesDataCount() + 1;
            
            echo $output = '<tr id="'.$k->id.'">
                <td>'.$slNo.'</td>
                <td  width="400"><input class="form-control" value="'.$sItem.'" readonly></td>
                <td></td>
                <td width="150"><input class="form-control qty" value="'.$sQty.'" readonly></td>
                <td width="150"><input class="form-control price" value="'.$sPrice.'" readonly></td>
                <td width="100"><input class="form-control" id="xgst'.$slNo.'" value="'.$sTax.'%" readonly></td>
                <td width="150"><input class="form-control total"  value="'.$sTotal.'" readonly></td>
                <td><a onclick="delete_stock_out('.$k->id.')"><button type="button" class="btn btn-danger-rgba"><i class="dripicons-archive"></i></button></a></td>
            </tr>';
        }
        public function tempSaleData_stock_out()
        {
            $item_id = $_POST['item_id'];
            $item_name = $_POST['sItem'];
            $item_name = trim($item_name);
            $sQty = $_POST['sQty'];
            $rec = $_POST['rec'];
            $price = $_POST['price'];
            $total = $_POST['total'];
            $k = $this->pageModel->saveTheSalesTempData_stock_out($item_id,$item_name, $sQty, $rec,$price,$total);
            $slNo = $this->pageModel->getTheTempSalesDataCount_for_stock_out() + 1;
            if($rec==0){ $rec='Carton'; }elseif($rec==1){ $rec = 'Box'; }else{ $rec = 'Pieces';}
            echo $output = '<tr id="'.$k->id.'">
                <td><input class="form-control"  value="'.$item_name.'" readonly></td>
                <td></td>
                <td><input class="form-control " value="'.$rec.'" readonly></td>
                <td><input class="form-control qty"  value="'.$sQty.'" readonly></td>
                <td style="display:none"><input class="form-control price"  value="'.$price.'" readonly ></td>
                <td style="display:none"><input class="form-control total"  value="'.$total.'" readonly ></td>
                <td><a onclick="delete_stock_out('.$k->id.')"><button type="button" class="btn btn-danger-rgba"><i class="dripicons-archive"></i></button></a></td>
            </tr>';
        }
        public function delete_stock_out_temp_row()
        {
            $id = $_POST['id'];
            $this->pageModel->delete_stock_out_temp($id);
        }
        public function delete_stock_order_temp_row()
        {
            $id = $_POST['id'];
            $this->pageModel->delete_stock_order_temp($id);
        }
        public function tempnon_purchase()
        {
            $itemid = $_POST['itemId'];
            $item_name = $_POST['sItem'];
            $item_name = trim($item_name);
            $receive = $_POST['receive'];
            $rqty = $_POST['rqty'];
            $position = $_POST['position'];

            $k = $this->pageModel->savetempnonpurchasedb($itemid, $item_name, $receive, $rqty, $position);
            $slNo = $this->pageModel->getTheTempnon_purchase_count() + 1;
            if($receive==1)
            {
                $receive = "Box";
            }
            elseif($receive==3)
            {
                $receive = "Pieces";
            }
            echo $output = '<tr id="'.$k->id.'">
                <td width="10">'.$slNo.'</td>
                <td width="400"><input class="form-control"  value="'.$item_name.'" readonly></td>
                <td></td>
                <td><input type="text" class="form-control"  value="'.$receive.'" readonly></td>
                <td><input class="form-control" value="'.$rqty.'" readonly></td>
                <td><input class="form-control"  value="'.$position.'" readonly></td>
                <td><a onclick="delete_nonpurchase_row('.$k->id.')"><button type="button" class="btn btn-danger-rgba"><i class="dripicons-archive"></i></button></a></td>
            </tr>'; 
        }

        public function delete_non_purchase_temp_row()
        {
            $id = $_POST['id'];
            $this->pageModel->delete_non_purchase_temp($id);
        }
        public function temp_distributorData()
        {
            $sta = $_POST['sta'];
            $sItem = $_POST['sItem'];
            $sQty = $_POST['sQty'];
            $sPrice = $_POST['sPrice'];
            $sTax = $_POST['sTax'];
            $sTotal = $_POST['sTotal'];

            $this->pageModel->saveThedistributorTempData($sta, $sItem, $sQty, $sPrice, $sTax, $sTotal);
            $slNo = $this->pageModel->getTheTempDistDataCount() + 1;
            
            echo $output = '<tr>
                <td>'.$slNo.'</td>
                <td><input class="form-control" value="'.$sItem.'" readonly></td>
                <td><input class="form-control qty" value="'.$sQty.'" readonly></td>
                <td><input class="form-control price" value="'.$sPrice.'" readonly></td>
                <td><input class="form-control" id="xgst'.$slNo.'" value="'.$sTax.'%" readonly></td>
                <td><input class="form-control total"  value="'.$sTotal.'" readonly></td>
            </tr>';
        }
        public function tempdeliverychallanData()
        {
            $sta = $_POST['sta'];
            $sItem = $_POST['sItem'];
            $sQty = $_POST['sQty'];
            $sPrice = $_POST['sPrice'];
            $sTax = $_POST['sTax'];
            $sTotal = $_POST['sTotal'];

            $this->pageModel->saveThedeliverychallanTempData($sta, $sItem, $sQty, $sPrice, $sTax, $sTotal);
            $slNo = $this->pageModel->getTheTempdeliverychallanDataCount() + 1;
            
            echo $output = '<tr>
                <td>'.$slNo.'</td>
                <td><input class="form-control" value="'.$sItem.'" readonly></td>
                <td><input class="form-control qty" value="'.$sQty.'" readonly></td>
                <td><input class="form-control price" value="'.$sPrice.'" readonly></td>
                <td><input class="form-control" id="xgst'.$slNo.'" value="'.$sTax.'%" readonly></td>
                <td><input class="form-control total"  value="'.$sTotal.'" readonly></td>
            </tr>';
        }

        public function getAllSales()
        {
            $lim = $_POST['lim'];
            $lim = (int)$lim;
            if($lim==9)
            {
                $off = $_POST['off'];
                $off = (int)$off;
                $sales = $this->pageModel->get_all_sales_order($lim, $off);
            }
            else
            {
                $inc = $_POST['inc'];
                $inc = (int)$inc;
                $lim = 9;
                $off = 9+(9*$inc);
                $sales = $this->pageModel->get_all_sales_order($lim, $off);
            }
            $output = '';

            foreach ($sales as $key)
            {
                $cp_cust = $this->pageModel->get_all_customer_cp_priority($key->customer_id);
                if($_SESSION['ctype'] == 1)
                {
                    if($cp_cust->cp_priority==1)
                    {
                        $output .= "<tr>
                            <td>".$key->id."</td>
                            <td>".$key->customer_name."</td>
                            <td>".date('d-m-Y', strtotime($key->expected_delivery_date))."</td>
                            <td>".$key->total_amount."</td>
                            <td><a href='".URLROOT."/pages/salesInvoice/".$key->id."'><button type='button' class='btn btn-primary'>view Invoice</button></a><a href='".URLROOT."/pages/deleteinvoice/".$key->id."'><button type='button' class='btn btn-danger-rgba'><i class='dripicons-archive'></i></button></a></td>
                            
                        </tr>";
                    }
                }
                elseif($_SESSION['ctype'] == 4)
                {
                    if($cp_cust->cp_priority==4)
                    {
                        $output .= "<tr>
                            <td>".$key->id."</td>
                            <td>".$key->customer_name."</td>
                            <td>".date('d-m-Y', strtotime($key->expected_delivery_date))."</td>
                            <td>".$key->total_amount."</td>
                            <td><a href='".URLROOT."/pages/salesInvoice/".$key->id."'><button type='button' class='btn btn-primary'>view Invoice</button></a><a href='".URLROOT."/pages/deleteinvoice/".$key->id."'><button type='button' class='btn btn-danger-rgba'><i class='dripicons-archive'></i></button></a></td>
                            
                        </tr>";
                    }
                }
                elseif($_SESSION['ctype'] == 5)
                {
                    if($cp_cust->cp_priority==5)
                    {
                        $output .= "<tr>
                            <td>".$key->id."</td>
                            <td>".$key->customer_name."</td>
                            <td>".date('d-m-Y', strtotime($key->expected_delivery_date))."</td>
                            <td>".$key->total_amount."</td>
                            <td><a href='".URLROOT."/pages/salesInvoice/".$key->id."'><button type='button' class='btn btn-primary'>view Invoice</button></a><a href='".URLROOT."/pages/deleteinvoice/".$key->id."'><button type='button' class='btn btn-danger-rgba'><i class='dripicons-archive'></i></button></a></td>
                            
                        </tr>";
                    }
                }
                elseif($_SESSION['ctype'] == 6)
                {
                    if($cp_cust->cp_priority==6)
                    {
                        $output .= "<tr>
                            <td>".$key->id."</td>
                            <td>".$key->customer_name."</td>
                            <td>".date('d-m-Y', strtotime($key->expected_delivery_date))."</td>
                            <td>".$key->total_amount."</td>
                            <td><a href='".URLROOT."/pages/salesInvoice/".$key->id."'><button type='button' class='btn btn-primary'>view Invoice</button></a><a href='".URLROOT."/pages/deleteinvoice/".$key->id."'><button type='button' class='btn btn-danger-rgba'><i class='dripicons-archive'></i></button></a></td>
                            
                        </tr>";
                    }
                }
                elseif($_SESSION['ctype'] == 7)
                {
                    if($cp_cust->cp_priority==7)
                    {
                        $output .= "<tr>
                            <td>".$key->id."</td>
                            <td>".$key->customer_name."</td>
                            <td>".date('d-m-Y', strtotime($key->expected_delivery_date))."</td>
                            <td>".$key->total_amount."</td>
                            <td><a href='".URLROOT."/pages/salesInvoice/".$key->id."'><button type='button' class='btn btn-primary'>view Invoice</button></a><a href='".URLROOT."/pages/deleteinvoice/".$key->id."'><button type='button' class='btn btn-danger-rgba'><i class='dripicons-archive'></i></button></a></td>
                            
                        </tr>";
                    }
                }
                elseif($_SESSION['ctype'] == 8)
                {
                    if($cp_cust->cp_priority==8)
                    {
                        $output .= "<tr>
                            <td>".$key->id."</td>
                            <td>".$key->customer_name."</td>
                            <td>".date('d-m-Y', strtotime($key->expected_delivery_date))."</td>
                            <td>".$key->total_amount."</td>
                            <td><a href='".URLROOT."/pages/salesInvoice/".$key->id."'><button type='button' class='btn btn-primary'>view Invoice</button></a><a href='".URLROOT."/pages/deleteinvoice/".$key->id."'><button type='button' class='btn btn-danger-rgba'><i class='dripicons-archive'></i></button></a></td>
                            
                        </tr>";
                    }
                }
                elseif($_SESSION['ctype'] == 9)
                {
                    if($cp_cust->cp_priority==9)
                    {
                        $output .= "<tr>
                            <td>".$key->id."</td>
                            <td>".$key->customer_name."</td>
                            <td>".date('d-m-Y', strtotime($key->expected_delivery_date))."</td>
                            <td>".$key->total_amount."</td>
                            <td><a href='".URLROOT."/pages/salesInvoice/".$key->id."'><button type='button' class='btn btn-primary'>view Invoice</button></a><a href='".URLROOT."/pages/deleteinvoice/".$key->id."'><button type='button' class='btn btn-danger-rgba'><i class='dripicons-archive'></i></button></a></td>
                            
                        </tr>";
                    }
                }
                else
                {
                    if($cp_cust->cp_priority==0)
                    {
                        $output .= "<tr>
                            <td>".$key->id."</td>
                            <td>".$key->customer_name."</td>
                            <td>".date('d-m-Y', strtotime($key->expected_delivery_date))."</td>
                            <td>".$key->total_amount."</td>
                            <td><a href='".URLROOT."/pages/salesInvoice/".$key->id."'><button type='button' class='btn btn-primary'>view Invoice</button></a><a href='".URLROOT."/pages/deleteinvoice/".$key->id."'><button type='button' class='btn btn-danger-rgba'><i class='dripicons-archive'></i></button></a></td>
                            
                        </tr>";   
                    }
                }

            }
            echo $output;
        }
         public function deleteinvoice($id)
        {
            if($this->pageModel->deleteinvoice_db($id))
            {
                $_SESSION['success'] = "Invoice deleted successfully";
                redirect('pages/sales_order');
            }else
            {
                $_SESSION['success'] = "unable to delete";
                redirect('pages/sales_order');
            }

        }
        public function all_customer_un()
        {
            if($_SESSION['ctype'] == 3)
            {
                $lim = $_POST['lim'];
                $lim = (int)$lim;
                if($lim==9)
                {
                    $off = $_POST['off'];
                    $off = (int)$off;
                    $customer = $this->pageModel->get_all_customer_details($lim, $off);
                }
                else
                {
                    $inc = $_POST['inc'];
                    $inc = (int)$inc;
                    $lim = 9;
                    $off = 9+(9*$inc);
                    $customer = $this->pageModel->get_all_customer_details($lim, $off);
                }

                $output = '';

                foreach ($customer as $k)
                {
                    $output .=' <tr>
                                <td>'.$k->id.'</td>
                                <td>'.$k->customer_display_name.'</td>
                                <td>'.$k->customer_phno_work.'</td>
                                <td>'.$k->b_city.'</td>
                                <td> <a href="'.URLROOT.'/pages/edit_customer/'.$k->id.'" class="btn btn-success-rgba"><i class="ri-pencil-line"></i></a>  <a href="'.URLROOT.'/pages/del_customer/'.$k->id.'" class="btn btn-danger-rgba"><i class="ri-delete-bin-3-line"></i></a></td>
                            </tr>';   
                }       
            }
            elseif($_SESSION['ctype'] == 1)
            {
                $lim = $_POST['lim'];
                $lim = (int)$lim;
                if($lim==9)
                {
                    $off = $_POST['off'];
                    $off = (int)$off;
                    $customer = $this->pageModel->get_all_customer_details1($lim, $off);
                }
                else
                {
                    $inc = $_POST['inc'];
                    $inc = (int)$inc;
                    $lim = 9;
                    $off = 9+(9*$inc);
                    $customer = $this->pageModel->get_all_customer_details1($lim, $off);
                }

                $output = '';

                foreach ($customer as $k)
                {
                    $output .=' <tr>
                                <td>'.$k->id.'</td>
                                <td>'.$k->customer_display_name.'</td>
                                <td>'.$k->customer_phno_work.'</td>
                                <td>'.$k->b_city.'</td>
                                <td> <a href="'.URLROOT.'/pages/edit_customer/'.$k->id.'" class="btn btn-success-rgba"><i class="ri-pencil-line"></i></a>  <a href="'.URLROOT.'/pages/del_customer/'.$k->id.'" class="btn btn-danger-rgba"><i class="ri-delete-bin-3-line"></i></a></td>
                            </tr>';   
                }       
            }
            elseif($_SESSION['ctype'] == 4)
            {
                $lim = $_POST['lim'];
                $lim = (int)$lim;
                if($lim==9)
                {
                    $off = $_POST['off'];
                    $off = (int)$off;
                    $customer = $this->pageModel->get_all_customer_details4($lim, $off);
                }
                else
                {
                    $inc = $_POST['inc'];
                    $inc = (int)$inc;
                    $lim = 9;
                    $off = 9+(9*$inc);
                    $customer = $this->pageModel->get_all_customer_details4($lim, $off);
                }

                $output = '';

                foreach ($customer as $k)
                {
                    $output .=' <tr>
                                <td>'.$k->id.'</td>
                                <td>'.$k->customer_display_name.'</td>
                                <td>'.$k->customer_phno_work.'</td>
                                <td>'.$k->b_city.'</td>
                                <td> <a href="'.URLROOT.'/pages/edit_customer/'.$k->id.'" class="btn btn-success-rgba"><i class="ri-pencil-line"></i></a>  <a href="'.URLROOT.'/pages/del_customer/'.$k->id.'" class="btn btn-danger-rgba"><i class="ri-delete-bin-3-line"></i></a></td>
                            </tr>';   
                }       
            }
            elseif($_SESSION['ctype'] == 5)
            {
                $lim = $_POST['lim'];
                $lim = (int)$lim;
                if($lim==9)
                {
                    $off = $_POST['off'];
                    $off = (int)$off;
                    $customer = $this->pageModel->get_all_customer_details5($lim, $off);
                }
                else
                {
                    $inc = $_POST['inc'];
                    $inc = (int)$inc;
                    $lim = 9;
                    $off = 9+(9*$inc);
                    $customer = $this->pageModel->get_all_customer_details5($lim, $off);
                }

                $output = '';

                foreach ($customer as $k)
                {
                    $output .=' <tr>
                                <td>'.$k->id.'</td>
                                <td>'.$k->customer_display_name.'</td>
                                <td>'.$k->customer_phno_work.'</td>
                                <td>'.$k->b_city.'</td>
                                <td> <a href="'.URLROOT.'/pages/edit_customer/'.$k->id.'" class="btn btn-success-rgba"><i class="ri-pencil-line"></i></a>  <a href="'.URLROOT.'/pages/del_customer/'.$k->id.'" class="btn btn-danger-rgba"><i class="ri-delete-bin-3-line"></i></a></td>
                            </tr>';   
                }       
            }
            elseif($_SESSION['ctype'] == 6)
            {
                $lim = $_POST['lim'];
                $lim = (int)$lim;
                if($lim==9)
                {
                    $off = $_POST['off'];
                    $off = (int)$off;
                    $customer = $this->pageModel->get_all_customer_details6($lim, $off);
                }
                else
                {
                    $inc = $_POST['inc'];
                    $inc = (int)$inc;
                    $lim = 9;
                    $off = 9+(9*$inc);
                    $customer = $this->pageModel->get_all_customer_details6($lim, $off);
                }

                $output = '';

                foreach ($customer as $k)
                {
                    $output .=' <tr>
                                <td>'.$k->id.'</td>
                                <td>'.$k->customer_display_name.'</td>
                                <td>'.$k->customer_phno_work.'</td>
                                <td>'.$k->b_city.'</td>
                                <td> <a href="'.URLROOT.'/pages/edit_customer/'.$k->id.'" class="btn btn-success-rgba"><i class="ri-pencil-line"></i></a>  <a href="'.URLROOT.'/pages/del_customer/'.$k->id.'" class="btn btn-danger-rgba"><i class="ri-delete-bin-3-line"></i></a></td>
                            </tr>';   
                }       
            }
            elseif($_SESSION['ctype'] == 7)
            {
                $lim = $_POST['lim'];
                $lim = (int)$lim;
                if($lim==9)
                {
                    $off = $_POST['off'];
                    $off = (int)$off;
                    $customer = $this->pageModel->get_all_customer_details7($lim, $off);
                }
                else
                {
                    $inc = $_POST['inc'];
                    $inc = (int)$inc;
                    $lim = 9;
                    $off = 9+(9*$inc);
                    $customer = $this->pageModel->get_all_customer_details7($lim, $off);
                }

                $output = '';

                foreach ($customer as $k)
                {
                    $output .=' <tr>
                                <td>'.$k->id.'</td>
                                <td>'.$k->customer_display_name.'</td>
                                <td>'.$k->customer_phno_work.'</td>
                                <td>'.$k->b_city.'</td>
                                <td> <a href="'.URLROOT.'/pages/edit_customer/'.$k->id.'" class="btn btn-success-rgba"><i class="ri-pencil-line"></i></a>  <a href="'.URLROOT.'/pages/del_customer/'.$k->id.'" class="btn btn-danger-rgba"><i class="ri-delete-bin-3-line"></i></a></td>
                            </tr>';   
                }       
            }
            elseif($_SESSION['ctype'] == 8)
            {
                $lim = $_POST['lim'];
                $lim = (int)$lim;
                if($lim==9)
                {
                    $off = $_POST['off'];
                    $off = (int)$off;
                    $customer = $this->pageModel->get_all_customer_details8($lim, $off);
                }
                else
                {
                    $inc = $_POST['inc'];
                    $inc = (int)$inc;
                    $lim = 9;
                    $off = 9+(9*$inc);
                    $customer = $this->pageModel->get_all_customer_details8($lim, $off);
                }

                $output = '';

                foreach ($customer as $k)
                {
                    $output .=' <tr>
                                <td>'.$k->id.'</td>
                                <td>'.$k->customer_display_name.'</td>
                                <td>'.$k->customer_phno_work.'</td>
                                <td>'.$k->b_city.'</td>
                                <td> <a href="'.URLROOT.'/pages/edit_customer/'.$k->id.'" class="btn btn-success-rgba"><i class="ri-pencil-line"></i></a>  <a href="'.URLROOT.'/pages/del_customer/'.$k->id.'" class="btn btn-danger-rgba"><i class="ri-delete-bin-3-line"></i></a></td>
                            </tr>';   
                }       
            }
            elseif($_SESSION['ctype'] == 9)
            {
                $lim = $_POST['lim'];
                $lim = (int)$lim;
                if($lim==9)
                {
                    $off = $_POST['off'];
                    $off = (int)$off;
                    $customer = $this->pageModel->get_all_customer_details9($lim, $off);
                }
                else
                {
                    $inc = $_POST['inc'];
                    $inc = (int)$inc;
                    $lim = 9;
                    $off = 9+(9*$inc);
                    $customer = $this->pageModel->get_all_customer_details9($lim, $off);
                }

                $output = '';

                foreach ($customer as $k)
                {
                    $output .=' <tr>
                                <td>'.$k->id.'</td>
                                <td>'.$k->customer_display_name.'</td>
                                <td>'.$k->customer_phno_work.'</td>
                                <td>'.$k->b_city.'</td>
                                <td> <a href="'.URLROOT.'/pages/edit_customer/'.$k->id.'" class="btn btn-success-rgba"><i class="ri-pencil-line"></i></a>  <a href="'.URLROOT.'/pages/del_customer/'.$k->id.'" class="btn btn-danger-rgba"><i class="ri-delete-bin-3-line"></i></a></td>
                            </tr>';   
                }       
            }
            elseif($_SESSION['ctype'] == 0)
            {
                $lim = $_POST['lim'];
                $lim = (int)$lim;
                if($lim==9)
                {
                    $off = $_POST['off'];
                    $off = (int)$off;
                    $customer = $this->pageModel->get_all_customer_details0($lim, $off);
                }
                else
                {
                    $inc = $_POST['inc'];
                    $inc = (int)$inc;
                    $lim = 9;
                    $off = 9+(9*$inc);
                    $customer = $this->pageModel->get_all_customer_details0($lim, $off);
                }

                $output = '';

                foreach ($customer as $k)
                {
                    $output .=' <tr>
                                <td>'.$k->id.'</td>
                                <td>'.$k->customer_display_name.'</td>
                                <td>'.$k->customer_phno_work.'</td>
                                <td>'.$k->b_city.'</td>
                                <td> <a href="'.URLROOT.'/pages/edit_customer/'.$k->id.'" class="btn btn-success-rgba"><i class="ri-pencil-line"></i></a>  <a href="'.URLROOT.'/pages/del_customer/'.$k->id.'" class="btn btn-danger-rgba"><i class="ri-delete-bin-3-line"></i></a></td>
                            </tr>';   
                }       
            }
            echo $output;
        }
        public function getAllStock_out()
        {
            $lim = $_POST['lim'];
            $lim = (int)$lim;
            if($lim==9)
            {
                $off = $_POST['off'];
                $off = (int)$off;
                $sales = $this->pageModel->get_all_sales_stock_out($lim, $off);
            }
            else
            {
                $inc = $_POST['inc'];
                $inc = (int)$inc;
                $lim = 9;
                $off = 9+(9*$inc);
                $sales = $this->pageModel->get_all_sales_stock_out($lim, $off);
            }
            $output = '';
            $pnote = 0;
            $pending = '';
            foreach ($sales as $key)
            {
                $z = $this->pageModel->get_all_stock_out_package_stock_out_for_pending($key->id);
                if(empty($z))
                {
                    $pnote = 1;
                }
                else
                {
                    $item_to_pack = explode("|||", $z->item_to_pack);
                    for ($i=0; $i <sizeof($item_to_pack); $i++) { 
                       if($item_to_pack[$i]==0)
                       {
                           $pnote = 0; 
                       }else
                       {
                            $pnote = 1;
                       }
                    }
                }
                if($pnote == 0)
                {
                    $pending = "All clear";
                }else
                {
                    $pending = "Pending";
                }
                $cp_cust = $this->pageModel->get_all_customer_cp_priority($key->customer_id);
                if($_SESSION['ctype'] == 1)
                {
                    if($cp_cust->cp_priority==1)
                    {
                        $output .= "<tr>
                        <td>".$key->id."</td>
                        <td>".$key->customer."</td>
                        <td>".date('d-m-Y', strtotime($key->stock_dt))."</td>
                        <td><a  href='".URLROOT."/pages/print_stockout_details/".$key->id."'>Print</a></td>
                        <td>".$pending."</td>
                        <td>
                           
                            <button class='btn btn-info btn-sm' onclick='processModal(".$key->id.")'>Process</button>
                        </td>
                        </tr>";
                    }   
                }
                elseif($_SESSION['ctype'] == 4)
                {
                    if($cp_cust->cp_priority==4)
                    {
                        $output .= "<tr>
                        <td>".$key->id."</td>
                        <td>".$key->customer."</td>
                        <td>".date('d-m-Y', strtotime($key->stock_dt))."</td>
                        <td><a  href='".URLROOT."/pages/print_stockout_details/".$key->id."'>Print</a></td>
                        <td>".$pending."</td>
                        <td>
                           
                            <button class='btn btn-info btn-sm' onclick='processModal(".$key->id.")'>Process</button>
                        </td>
                        </tr>";
                    }   
                }
                elseif($_SESSION['ctype'] == 5)
                {
                    if($cp_cust->cp_priority==5)
                    {
                        $output .= "<tr>
                        <td>".$key->id."</td>
                        <td>".$key->customer."</td>
                        <td>".date('d-m-Y', strtotime($key->stock_dt))."</td>
                        <td><a  href='".URLROOT."/pages/print_stockout_details/".$key->id."'>Print</a></td>
                        <td>".$pending."</td>
                        <td>
                           
                            <button class='btn btn-info btn-sm' onclick='processModal(".$key->id.")'>Process</button>
                        </td>
                        </tr>";
                    }   
                }
                elseif($_SESSION['ctype'] == 6)
                {
                    if($cp_cust->cp_priority==6)
                    {
                        $output .= "<tr>
                        <td>".$key->id."</td>
                        <td>".$key->customer."</td>
                        <td>".date('d-m-Y', strtotime($key->stock_dt))."</td>
                        <td><a  href='".URLROOT."/pages/print_stockout_details/".$key->id."'>Print</a></td>
                        <td>".$pending."</td>
                        <td>
                           
                            <button class='btn btn-info btn-sm' onclick='processModal(".$key->id.")'>Process</button>
                        </td>
                        </tr>";
                    }   
                }
                elseif($_SESSION['ctype'] == 7)
                {
                    if($cp_cust->cp_priority==7)
                    {
                        $output .= "<tr>
                        <td>".$key->id."</td>
                        <td>".$key->customer."</td>
                        <td>".date('d-m-Y', strtotime($key->stock_dt))."</td>
                        <td><a  href='".URLROOT."/pages/print_stockout_details/".$key->id."'>Print</a></td>
                        <td>".$pending."</td>
                        <td>
                           
                            <button class='btn btn-info btn-sm' onclick='processModal(".$key->id.")'>Process</button>
                        </td>
                        </tr>";
                    }   
                }
                elseif($_SESSION['ctype'] == 8)
                {
                    if($cp_cust->cp_priority==8)
                    {
                        $output .= "<tr>
                        <td>".$key->id."</td>
                        <td>".$key->customer."</td>
                        <td>".date('d-m-Y', strtotime($key->stock_dt))."</td>
                        <td><a  href='".URLROOT."/pages/print_stockout_details/".$key->id."'>Print</a></td>
                        <td>".$pending."</td>
                        <td>
                           
                            <button class='btn btn-info btn-sm' onclick='processModal(".$key->id.")'>Process</button>
                        </td>
                        </tr>";
                    }   
                }
                elseif($_SESSION['ctype'] == 9)
                {
                    if($cp_cust->cp_priority==9)
                    {
                        $output .= "<tr>
                        <td>".$key->id."</td>
                        <td>".$key->customer."</td>
                        <td>".date('d-m-Y', strtotime($key->stock_dt))."</td>
                        <td><a  href='".URLROOT."/pages/print_stockout_details/".$key->id."'>Print</a></td>
                        <td>".$pending."</td>
                        <td>
                           
                            <button class='btn btn-info btn-sm' onclick='processModal(".$key->id.")'>Process</button>
                        </td>
                        </tr>";
                    }   
                }
                else
                {
                    if($cp_cust->cp_priority==0)
                    {
                        $output .= "<tr>
                        <td>".$key->id."</td>
                        <td>".$key->customer."</td>
                        <td>".date('d-m-Y', strtotime($key->stock_dt))."</td>

                        <td><a  href='".URLROOT."/pages/print_stockout_details/".$key->id."'>Print</a></td>
                        <td>".$pending."</td>
                        <td>
                           
                            <button class='btn btn-info btn-sm' onclick='processModal(".$key->id.")'>Process</button>
                        </td>
                        </tr>";
                    }
                }
            }
            echo $output;
        }

        public function getAllDistributor()
        {
            $lim = $_POST['lim'];
            $lim = (int)$lim;
            if($lim==9)
            {
                $off = $_POST['off'];
                $off = (int)$off;
                $sales = $this->pageModel->get_all_dist_order($lim, $off);
            }
            else
            {
                $inc = $_POST['inc'];
                $inc = (int)$inc;
                $lim = 9;
                $off = 9+(9*$inc);
                $sales = $this->pageModel->get_all_dist_order($lim, $off);
            }
            $output = '';

            foreach ($sales as $key)
            {
                $output .= "<tr>
                    <td>".$key->id."</td>
                    <td>".$key->distributor_name."</td>
                    <td>".date('d-m-Y', strtotime($key->expected_delivery_date))."</td>
                    <td>".$key->total_amount."</td>
                    <td>
                        <button class='btn btn-info btn-sm' onclick='processModal(".$key->id.")'>Process</button>
                    </td>
                </tr>";
            }
            echo $output;
        }
         public function getAllDelivery_challans()
        {
            $lim = $_POST['lim'];
            $lim = (int)$lim;
            if($lim==9)
            {
                $off = $_POST['off'];
                $off = (int)$off;
                $sales = $this->pageModel->get_all_Delivery_challan_order($lim, $off);
            }
            else
            {
                $inc = $_POST['inc'];
                $inc = (int)$inc;
                $lim = 9;
                $off = 9+(9*$inc);
                $sales = $this->pageModel->get_all_Delivery_challan_order($lim, $off);
            }
            $output = '';

            foreach ($sales as $key)
            {
                $output .= "<tr>
                    <td>".$key->id."</td>
                    <td>".$key->customer_name."</td>
                    <td>".date('d-m-Y', strtotime($key->ndate))."</td>
                    <td>".$key->total_amount."</td>
                    <td>
                        <a class='btn btn-info btn-sm' href='".URLROOT."/pages/delivery_challan_print/".$key->id."'>Print</a>
                    </td>
                </tr>";
            }
            echo $output;
        }
         public function delivery_challan_print($dcid)
        {
            $data = [
                'sales' => $this->pageModel->getdelivery_challan_orderDetails($dcid),
            ];
            $this->view('pages/delivery_challan_print', $data);
        }

        public function packageCreate($id)
        {
            $this->pageModel->before_delete_temp1();
            $data = [
                    'sales' => $this->pageModel->getsalesDetails($id),
                    'so' => $this->pageModel->getsalesOrderDetails($id),
                    'rem_s_ord' => $this->pageModel->getsalesOrder_forpack($id),
                    'all_rem_s_ord' => $this->pageModel->getsalesOrder_forpack_all($id)
            ];
            $this->view('pages/packageCreate', $data);
        }
         public function packageCreate_for_stockout($id)
        {
            $this->pageModel->before_delete_temp();
            $data = [
                    'stockout' => $this->pageModel->getstockoutDetails($id),
                    'so' => $this->pageModel->getstockoutOrderDetails($id),
                    'rem_s_ord' => $this->pageModel->getstockout_forpack($id),
                    'all_rem_s_ord' => $this->pageModel->getstockoutOrder_forpack_all($id)
            ];
            $this->view('pages/packageCreate_for_stockout', $data);
        }
        public function packageCreate_fordist($id)
        {
            $data = [
                    'distributor' => $this->pageModel->getdistDetails($id),
                    'do' => $this->pageModel->getdistributor_orderDetails($id),
                    'rem_d_ord' => $this->pageModel->getdistributor_order_forpack($id),
                    'all_rem_d_ord' => $this->pageModel->getdistributor_order_forpack_all($id)
            ];
            $this->view('pages/packageCreate_fordist', $data);
        }

        public function saveThePackageDetails($id)
        {
            for($i=0;$i<sizeof($_POST['itemQty']);$i++)
            {
                $a[$i] = $_POST['itemQty'][$i] - $_POST['qtyPack'][$i];
            }
            $data = [
                'sale_id' => $id,
                'itemName' => implode('|||', $_POST['itemName']),
                'itemId' => implode('|||', $_POST['itemId']),
                'itemQty' => implode('|||', $_POST['itemQty']),
                'qtyPack' => implode('|||', $_POST['qtyPack']),
                'qty_need_to_Pack' => implode('|||', $a),
            ];
            if($this->pageModel->updateThePackage($data))
            {
                redirect('pages/sales_order');
            }
        }
        public function saveThePackageDetails_stock_out($id)
        {
            for($i=0;$i<sizeof($_POST['itemQty']);$i++)
            {
                $a[$i] = $_POST['itemQty'][$i] - $_POST['qtyPack'][$i];
            }
            $st = $this->pageModel->get_all_stock_out_details($id);
            $data = [
                'stock_out_id' => $id,
                'customer_id' =>$st->customer_id,
                'customer' => $st->customer,
                'itemName' => implode('|||', $_POST['itemName']),
                'itemId' => implode('|||', $_POST['itemId']),
                'itemQty' => implode('|||', $_POST['itemQty']),
                'qtyPack' => implode('|||', $_POST['qtyPack']),
                'qty_need_to_Pack' => implode('|||', $a),
            ];

            if($this->pageModel->updateThePackage_stock_out($data))
            {
                $temp_scan_count = $this->pageModel->get_total_temp_scan_count();
                $ts = $this->pageModel->get_total_temp_scan_details();
                foreach ($ts as $t) 
                {
                    $f = $this->pageModel->get_only_single_stock($t->stock_id);  
                    $this->pageModel->insert_new_stock_scan_items($data,$f,$t->item_name,$t->qrcode);
                }
                redirect('pages/all_stock_out');
            }
            // var_dump($_POST["itemQty"]);
        }
        public function saveThePackageDetails_for_dist($id)
        {
            for($i=0;$i<sizeof($_POST['itemQty']);$i++)
            {
                $a[$i] = $_POST['itemQty'][$i] - $_POST['qtyPack'][$i];
            }
            $data = [
                'distDate'=> $_POST['distDate'],
                'distributor_id' => $id,
                'itemName' => implode('|||', $_POST['itemName']),
                'itemId' => implode('|||', $_POST['itemId']),
                'itemQty' => implode('|||', $_POST['itemQty']),
                'qtyPack' => implode('|||', $_POST['qtyPack']),
                'qty_need_to_Pack' => implode('|||', $a),
            ];
            if($this->pageModel->updateThePackage_for_dist($data))
            {
                redirect('pages/all_distributor_order');
            }
        }
        public function saveThePackageDetails_rem_pack($id)
        {
            $total_item_packed = array();
            $x = $this->pageModel->getsalesOrder_forpack_all($id);
            $x3 = 0;
            foreach ($x as $k) 
            {

                 $item_packed = explode("|||", $k->item_packed);
                 $x3 = sizeof($item_packed);
                for($i=0; $i<$x3; $i++)
                {   
                    $total_item_packed[$i] =  $total_item_packed[$i] + $item_packed[$i];             
                }
            }

            for($i=0;$i<sizeof($_POST['itemQty']);$i++)
            {
                $c[$i] = $total_item_packed[$i] + $_POST['qtyPack'][$i];
                $b[$i] = $total_item_packed[$i] + $_POST['qtyPack'][$i]; 
                $a[$i] = $_POST['itemQty'][$i] - $b[$i];
            }
             $data = [
                'sale_id' => $id,
                'itemName' => implode('|||', $_POST['itemName']),
                'itemId' => implode('|||', $_POST['itemId']),
                'itemQty' => implode('|||', $_POST['itemQty']),
                'qtyPack' => implode('|||', $_POST['qtyPack']),
                'qty_need_to_Pack' => implode('|||', $a),
                'total_item_received' => implode('|||', $c),
            ];
            
            if($this->pageModel->updateThePackage_rem_package($data))
            {
                redirect('pages/sales_order');
            }
        }
        public function saveThePackageDetails_rem_pack_for_stock($id)
        {
            $total_item_packed = array();
            $x = $this->pageModel->getstock_out_forpack_all($id);
            $x3 = 0;
            foreach ($x as $k) 
            {

                 $item_packed = explode("|||", $k->item_packed);
                 $x3 = sizeof($item_packed);
                for($i=0; $i<$x3; $i++)
                {   
                    $total_item_packed[$i] =  $total_item_packed[$i] + $item_packed[$i];             
                }
            }

            for($i=0;$i<sizeof($_POST['itemQty']);$i++)
            {
                $c[$i] = $total_item_packed[$i] + $_POST['qtyPack'][$i];
                $b[$i] = $total_item_packed[$i] + $_POST['qtyPack'][$i]; 
                $a[$i] = $_POST['itemQty'][$i] - $b[$i];
            }
             $st = $this->pageModel->get_all_stock_out_details($id);
             $data = [
                'stock_out_id' => $id,
                'customer_id' =>$st->customer_id,
                'customer' => $st->customer,
                'itemName' => implode('|||', $_POST['itemName']),
                'itemId' => implode('|||', $_POST['itemId']),
                'itemQty' => implode('|||', $_POST['itemQty']),
                'qtyPack' => implode('|||', $_POST['qtyPack']),
                'qty_need_to_Pack' => implode('|||', $a),
                'total_item_received' => implode('|||', $c),
            ];
            if($this->pageModel->updateThePackage_rem_package_for_stock_out($data))
            {
                $temp_scan_count = $this->pageModel->get_total_temp_scan_count();
                $ts = $this->pageModel->get_total_temp_scan_details();
                foreach ($ts as $t) 
                {
                    $f = $this->pageModel->get_only_single_stock($t->stock_id);  
                    $this->pageModel->insert_new_stock_scan_items($data,$f,$t->item_name,$t->barcode);
                }
                redirect('pages/all_stock_out');
            }
        }
        public function saveThePackageDetails_rem_pack_for_dist($id)
        {
            $total_item_packed = array();
            $x = $this->pageModel->getdistOrder_forpack_all($id);
            $x3 = 0;
            foreach ($x as $k) 
            {

                 $item_packed = explode("|||", $k->item_packed);
                 $x3 = sizeof($item_packed);
                for($i=0; $i<$x3; $i++)
                {   
                    $total_item_packed[$i] =  $total_item_packed[$i] + $item_packed[$i];             
                }
            }

            for($i=0;$i<sizeof($_POST['itemQty']);$i++)
            {
                $c[$i] = $total_item_packed[$i] + $_POST['qtyPack'][$i];
                $b[$i] = $total_item_packed[$i] + $_POST['qtyPack'][$i]; 
                $a[$i] = $_POST['itemQty'][$i] - $b[$i];
            }
             $data = [
                'distributor_id' => $id,
                'itemName' => implode('|||', $_POST['itemName']),
                'itemId' => implode('|||', $_POST['itemId']),
                'itemQty' => implode('|||', $_POST['itemQty']),
                'qtyPack' => implode('|||', $_POST['qtyPack']),
                'qty_need_to_Pack' => implode('|||', $a),
                'total_item_received' => implode('|||', $c),
            ];
            
            if($this->pageModel->updateThePackage_rem_package_for_dist($data))
            {
                redirect('pages/all_distributor_order');
            }
        }

        public function processCreate()
        {
            $sales = $this->pageModel->getTheProcessCreate($_POST['id']);
            $sId =$_POST['id'];
            $output = '
                <table class="table">
                    <thead>
                        <tr>
                            <th>Sl.No.</th>
                            <th>Item</th>
                            <th>Package</th>
                            <th>Status</th>
                            <th width="200">Action</th>
                        <tr>
                    </thead>
                    <tbody>
            ';
            $i = 1;
            foreach ($sales as $value)
            {
                $itemId = explode('|||', $value->item_id);
                $itemId = implode('<br>', $itemId);
                $itemName = explode('|||', $value->item_name);
                $itemName = implode('<br>', $itemName);
                $itemOrdered = explode('|||', $value->item_ordered);
                $itemOrdered = implode('<br>', $itemOrdered);
                $itemPacked = explode('|||', $value->item_packed);
                $itemPacked = implode('<br>', $itemPacked);
                $itemToPack = explode('|||', $value->item_to_pack);
                $itemToPack = implode('<br>', $itemToPack);
                $ds = $value->sp_id;
                $status = $value->status;
                if($status == 1)
                {   
                    $message = "Packed";
                }
                if($status == 2)
                {   
                    $message = "Shipped";
                }
                if($status == 3)
                {   
                    $message = "Delivered";
                }
                $output .= '<tr>';
                $output .= '
                    <td>'.$i.'</td>
                    <td>'.$itemName.'</td>
                    <td>'.$itemPacked.'</td>
                    <td>'.$message.'</td>
                ';
                if($status == 1)
                {
                    $output .= "<td><a href='".URLROOT."/pages/updateShipment/".$ds."'><button class='btn btn-info btn-sm'>Ship</button></a>&nbsp<a href='".URLROOT."/pages/packageprint/".$ds."'><i class='dripicons-print'></i></a></td>";
                }
                if($status == 2)
                {
                    $output .= "<td><a href='".URLROOT."/pages/updateShipmentDelivered/".$ds."'><button class='btn btn-info btn-sm'>Mark as Delivered</button></a>&nbsp&nbsp<a href='".URLROOT."/pages/packageprint/".$ds."'><i class='dripicons-print'></i></a></td>";
                }
                 if($status == 3)
                {
                    $output .= "<td><a href='".URLROOT."/pages/packageprint/".$ds."'><i class='dripicons-print'></i></a></td>";
                }
                $output .= '</tr>';
                $i++;
            }
             $output .= '</tr></tbody></table>';
            echo $output;
        }
        public function processCreate_stock_out()
        {
            $stock_out = $this->pageModel->getTheProcessCreate_for_stock($_POST['id']);
            $sId =$_POST['id'];
            $output = '
                <table class="table">
                    <thead>
                        <tr>
                            <th>Sl.No.</th>
                            <th>Item</th>
                            <th>Package</th>
                            <th>Pending</th>
                            <th>Status</th>
                            <th width="200">Action</th>
                        <tr>
                    </thead>
                    <tbody>
            ';
            $i = 1;
            foreach ($stock_out as $value)
            {
                $itemId = explode('|||', $value->item_id);
                $itemId = implode('<br>', $itemId);
                $itemName = explode('|||', $value->item_name);
                $itemName = implode('<br>', $itemName);
                $itemOrdered = explode('|||', $value->item_ordered);
                $itemOrdered = implode('<br>', $itemOrdered);
                $itemPacked = explode('|||', $value->item_packed);
                $itemPacked = implode('<br>', $itemPacked);
                $itemToPack = explode('|||', $value->item_to_pack);
                $itemToPack = implode('<br>', $itemToPack);
                $ds = $value->st_id;
                $stock_out_id = $value->stock_out_id;
                $status = $value->status;
                if($status == 1)
                {   
                    $message = "Packed";
                }
                if($status == 2)
                {   
                    $message = "Shipped";
                }
                if($status == 3)
                {   
                    $message = "Delivered";
                }
                $output .= '<tr>';
                $output .= '
                    <td>'.$i.'</td>
                    <td>'.$itemName.'</td>
                    <td>'.$itemPacked.'</td>
                    <td>'.$itemToPack.'</td>
                    <td>'.$message.'</td>
                ';
                if($status == 1)
                {
                    $output .= "<td><a href='".URLROOT."/pages/updateShipment_for_stock_out/".$ds."'><button class='btn btn-info btn-sm'>Ship</button></a>&nbsp<a href='".URLROOT."/pages/packageprint_for_stock_out/".$ds."'><i class='dripicons-print'></i></a></td>";

                }
                if($status == 2)
                {
                   $output .= "<td><a href='".URLROOT."/pages/updateShipment_forstockoutedit/".$ds."'><button class='btn btn-secondary btn-sm'>Edit Ship</button></a><a href='".URLROOT."/pages/updateShipmentDelivered_for_stock_out/".$ds."'><button class='btn btn-info btn-sm'>Mark as Delivered</button></a>&nbsp&nbsp<a href='".URLROOT."/pages/packageprint_for_stock_out/".$ds."'><i class='dripicons-print'></i></a></td>";
                }
                 if($status == 3)
                {
                    $output .= "<td><a href='".URLROOT."/pages/packageprint_for_stock_out/".$ds."'><i class='dripicons-print'></i></a></td>";
                }
                $output .= '</tr>';
                $i++;
            }
             $output .= '</tr></tbody></table>';
            echo $output;
        }
         public function processCreate_for_dist()
        {
            $distributor = $this->pageModel->getTheProcessCreate_fordist($_POST['id']);
            $sId =$_POST['id'];
            $output = '
                <table class="table">
                    <thead>
                        <tr>
                            <th>Sl.No.</th>
                            <th>Item</th>
                            <th>Package</th>
                            <th>Status</th>
                            <th width="200">Action</th>
                        <tr>
                    </thead>
                    <tbody>
            ';
            $i = 1;
            foreach ($distributor as $value)
            {
                $itemId = explode('|||', $value->item_id);
                $itemId = implode('<br>', $itemId);
                $itemName = explode('|||', $value->item_name);
                $itemName = implode('<br>', $itemName);
                $itemOrdered = explode('|||', $value->item_ordered);
                $itemOrdered = implode('<br>', $itemOrdered);
                $itemPacked = explode('|||', $value->item_packed);
                $itemPacked = implode('<br>', $itemPacked);
                $itemToPack = explode('|||', $value->item_to_pack);
                $itemToPack = implode('<br>', $itemToPack);
                $ds = $value->dp_id;
                $status = $value->status;
                if($status == 1)
                {   
                    $message = "Packed";
                }
                if($status == 2)
                {   
                    $message = "Shipped";
                }
                if($status == 3)
                {   
                    $message = "Delivered";
                }
                $output .= '<tr>';
                $output .= '
                    <td>'.$i.'</td>
                    <td>'.$itemName.'</td>
                    <td>'.$itemPacked.'</td>
                    <td>'.$message.'</td>
                ';
                if($status == 1)
                {
                    $output .= "<td><a href='".URLROOT."/pages/updateShipment_for_dist/".$ds."'><button class='btn btn-info btn-sm'>Ship</button></a>&nbsp<a href='".URLROOT."/pages/packageprint_for_distributor/".$ds."'><i class='dripicons-print'></i></a></td>";
                }
                if($status == 2)
                {
                    $output .= "<td><a href='".URLROOT."/pages/updateShipmentDelivered_for_dist/".$ds."'><button class='btn btn-info btn-sm'>Mark as Delivered</button></a>&nbsp&nbsp<a href='".URLROOT."/pages/packageprint_for_distributor/".$ds."'><i class='dripicons-print'></i></a></td>";
                }
                 if($status == 3)
                {
                    $output .= "<td><a href='".URLROOT."/pages/packageprint_for_distributor/".$ds."'><i class='dripicons-print'></i></a></td>";
                }
                $output .= '</tr>';
                $i++;
            }
             $output .= '</tr></tbody></table>';
            echo $output;
        }
         public function packageprint($ds)
        {
            $sId = $this->pageModel->get_sales_from_sales_pacakge($ds);
            $pack_wise_invoice = $this->pageModel->get_package_details_for_sales_invoice($ds);
            $data = [
                'sales' => $this->pageModel->getsalesOrderDetails($sId),
                'p_sales' => $pack_wise_invoice

            ];
            $this->view('pages/packageprint', $data);
        }
         public function packageprint_for_stock_out($ds)
        {
            $sId = $this->pageModel->get_stock_out_from_sales_pacakge($ds);
            $pack_wise_invoice = $this->pageModel->get_package_details_for_stock_out_invoice($ds);
            $data = [
                'stock_out' => $this->pageModel->getstockoutOrderDetails($sId),
                'p_stockout' => $pack_wise_invoice

            ];
            $this->view('pages/packageprint_for_stock_out', $data);
        }
        public function packageprint_for_distributor($ds)
        {
            $sId = $this->pageModel->get_Distributor_from_Distributor_pacakge($ds);
            $pack_wise_invoice = $this->pageModel->get_package_details_for_dist_invoice($ds);
            $data = [
                'distributor' => $this->pageModel->getdistributor_orderDetails($sId),
                'p_distributor' => $pack_wise_invoice

            ];
            $this->view('pages/packageprint_for_distributor', $data);
        }

        public function updateShipment($ds)
        {
            $data = [
                'id' => $this->pageModel->get_sales_from_sales_pacakge($ds),
                'sp_id' => $ds,
            ];
            $this->view('pages/updateShipment', $data);
        }
        public function updateShipment_for_stock_out($ds)
        {
            $iid = $this->pageModel->get_stock_out_from_stock_out_pacakge($ds);
            $st = $this->pageModel->get_all_stock_out_details($iid);
            $cust = $this->pageModel->get_single_customer($st->customer_id);
            $tt_details = $this->pageModel->get_single_transport($cust->transport);
            $data = [
                'id' => $iid,
                'st_id' => $ds,
                'tt_d' => $tt_details,
                'all_transport_details' =>$this->pageModel->get_all_transportdetails(),
            ];
            $this->view('pages/updateShipment_forstockout', $data);
        }

         public function updateShipment_forstockoutedit($ds)
        {
            $x = $this->pageModel->get_stock_out_from_stock_out_pacakge_edit($ds);
            $y = $this->pageModel->get_stock_out_from_stock_out_pacakge_edit_all($ds);
            $single_stock = $this->pageModel->get_all_stock_out_details($y->stock_out_id);
            $cust_single_details = $this->pageModel->get_single_customer($single_stock->customer_id);
            $data = [
                'id' => $x,
                'p_all' => $y,
                'st_id' => $ds,
                'ship_details' => $this->pageModel->get_transation_details($cust_single_details->transport),
                'all_transport_details' =>$this->pageModel->get_all_transportdetails(),
            ];
            $this->view('pages/updateShipment_forstockoutedit', $data);
        }


        public function updateShipment_for_dist($ds)
        {
            $data = [
                'id' => $this->pageModel->get_Distributor_from_Distributor_pacakge($ds),
                'dp_id' => $ds,
            ];
            $this->view('pages/updateShipment_for_dist', $data);
        }

        public function shipmentCreate($spId)
        {
            $shippingDate = $_POST['shippingDate'];
            $shipCarrier = $_POST['shipCarrier'];
            $tracking = $_POST['tracking'];
            $shippingCharges = $_POST['shippingCharges'];
            $shippingNotes = $_POST['shippingNotes'];

            if($this->pageModel->updateShipmentDb($shippingDate, $shipCarrier, $tracking, $shippingCharges, $shippingNotes, $spId))
            {
                redirect('pages/sales_order');
            }
        }
        public function shipmentCreate_for_stock_out($spId)
        {
            $shippingDate = $_POST['shippingDate'];
            $shipCarrier = $_POST['shipCarrier'];
            $tracking = $_POST['tracking'];
            $shippingCharges = $_POST['shippingCharges'];
            $shippingNotes = $_POST['shippingNotes'];

            if($this->pageModel->updateShipmentDb_for_stock_out($shippingDate, $shipCarrier, $tracking, $shippingCharges, $shippingNotes, $spId))
            {
                redirect('pages/all_stock_out');
            }
        }
        public function shipmentCreate_for_dist($spId)
        {
            $shippingDate = $_POST['shippingDate'];
            $shipCarrier = $_POST['shipCarrier'];
            $tracking = $_POST['tracking'];
            $shippingCharges = $_POST['shippingCharges'];
            $shippingNotes = $_POST['shippingNotes'];

            if($this->pageModel->updateShipmentDb_for_dist($shippingDate, $shipCarrier, $tracking, $shippingCharges, $shippingNotes, $spId))
            {
                redirect('pages/all_distributor_order');
            }
        }

        public function updateShipmentDelivered($ds)
        {
             $sId = $this->pageModel->get_sales_pack_details_for_calculate($ds);
            $x=0;
            $item_ordered = explode("|||", $sId->item_ordered);
            $total_item_received = explode("|||", $sId->total_item_received);
            $item_id = explode("|||", $sId->item_id);
            for ($i=0; $i < sizeof($item_ordered); $i++) 
            { 
                if($item_ordered[$i]==$total_item_received[$i])
                {
                    $this->pageModel->update_commited_stock($item_id[$i],$item_ordered[$i]);
                    $d = $this->pageModel->get_details_of_stock($sId->sales_id);
                    $this->pageModel->update_stock($d,$item_ordered[$i],$item_id[$i]);
                }
            }
            if($this->pageModel->updateTheShipmentToDelivedDb($ds))
            {
                redirect('pages/sales_order');
            }
        }
        public function updateShipmentDelivered_for_stock_out($ds)
        {
            $st_id = $this->pageModel->get_stock_out_pack_details_for_calculate($ds);
            $x=0;
            $item_ordered = explode("|||", $st_id->item_ordered);
            $total_item_received = explode("|||", $st_id->total_item_received);
            $item_id = explode("|||", $st_id->item_id);
            for ($i=0; $i < sizeof($item_ordered); $i++) 
            { 
                if($item_ordered[$i]==$total_item_received[$i])
                {
                    $this->pageModel->update_commited_stock($item_id[$i],$item_ordered[$i]);
                    $d = $this->pageModel->get_details_of_stock_for_stock_out($st_id->stock_out_id);
                    // $this->pageModel->update_stock($d,$item_ordered[$i],$item_id[$i]);
                }
            }
            if($this->pageModel->updateTheShipmentToDelivedDb_for_stock_out($ds))
            {
                redirect('pages/all_stock_out');
            }
        }
        public function updateShipmentDelivered_for_dist($ds)
        {
            $sId = $this->pageModel->get_dist_pack_details_for_calculate($ds);
            $x=0;
            $item_ordered = explode("|||", $sId->item_ordered);
            $total_item_received = explode("|||", $sId->total_item_received);
            $item_id = explode("|||", $sId->item_id);
            for ($i=0; $i < sizeof($item_ordered); $i++) 
            { 
                if($item_ordered[$i]==$total_item_received[$i])
                {
                    $this->pageModel->update_commited_stock($item_id[$i],$item_ordered[$i]);
                    $d = $this->pageModel->get_details_of_stock_for_dist($sId->distributor_id);
                    $this->pageModel->update_stock_for_dist($d,$item_ordered[$i],$item_id[$i]);
                }
            }
            if($this->pageModel->updateTheShipmentToDelivedDb_for_dist($ds))
            {
                redirect('pages/all_distributor_order');
            }
        }
        public function all_tax()
        {
           
            $this->view('pages/all_tax');
        }
        public function alltax()
        {
            $lim = $_POST['lim'];
            $lim = (int)$lim;
            if ($lim == 9) {
                $off = $_POST['off'];
                $off = (int)$off;
                $alltax = $this->pageModel->get_all_tax($lim, $off);
            } else {
                $inc = $_POST['inc'];
                $inc = (int)$inc;
                $lim = 9;
                $off = 9 + (9 * $inc);
                $alltax = $this->pageModel->get_all_tax($lim, $off);
            }
            $output = '';
            $count = 1;
            foreach ($alltax as $key) {
                $output .= '<tr>
                    <td>' . $count . '</td>
                    <td>' . $key->tax . '%</td>
                    <td>
                        <a href="' . URLROOT . '/pages/edit_tax/' . $key->id . '" class="btn btn-success-rgba"><i class="ri-pencil-line"></i></a>
                    </td>
                </tr>';
                $count++;
            }
            echo $output;
        }
        public function edit_tax($id)
        {
            $data = [ 'all_tax' => $this->pageModel->get_all_tax_from_id($id)];
            $this->view('pages/edit_tax', $data);
        }
        public function update_tax()
        {
            if ($this->pageModel->checkforduptax($_POST['tax']) > 0) {
                $_SESSION['success'] = "tax already exist";
                redirect('pages/settings');
            } else {
                $this->pageModel->updatetax($_POST['id'],$_POST['tax']);
                $_SESSION['success'] = "tax updated";
                redirect('pages/settings');
            }
            $this->view('pages/settings');
        }
        public function update_positions()
        {
            $id=$_POST['id'];
            $posCode = $_POST['posCode'];
            $posDetails = $_POST['posDetails'];

            $this->pageModel->updateThePositions($id,$posCode, $posDetails);
            $_SESSION['success'] = "Position updated";
            redirect('pages/settings');
        }
        public function add_company_details()
        {
            $data = [
                    'name' => $_POST['name'],
                    'email' => $_POST['email'],
                    'street1' => $_POST['street1'],
                    'street2' => $_POST['street2'],
                    'city' => $_POST['city'],
                    'state' => $_POST['state'],
                    'country' => $_POST['country'],
                    'zip_code' => $_POST['zip_code'],
                    'phone' => $_POST['phone'],
                    'fax' => $_POST['fax']
                ];
                $this->pageModel->add_company_details($data);
                $_SESSION['success'] = "Company details saved";
            redirect('pages/settings');
        }
        public function updatecompanydetails()
        {
           $data = [
                    'id' => $_POST['id'],
                    'name' => $_POST['name'],
                    'email' => $_POST['email'],
                    'street1' => $_POST['street1'],
                    'street2' => $_POST['street2'],
                    'city' => $_POST['city'],
                    'state' => $_POST['state'],
                    'country' => $_POST['country'],
                    'zip_code' => $_POST['zip_code'],
                    'phone' => $_POST['phone'],
                    'fax' => $_POST['fax']
                ];
                $this->pageModel->updatecompany_details($data);
                $_SESSION['success'] = "Company details updated successfully";
                   redirect('pages/all_companydetails');
        }
        public function editcompanydetails($id){
          $data = [
            'company' => $this->pageModel->get_single_company($id)
        ];
        $this->view('pages/editcompanydetails', $data);
     }

        //subcategory2
        public function add_category_new()
        {
            $this->pageModel->saveSC2_for_new_category($_POST['ccname'], $_POST['mid'],$_POST['tid']);
             $_SESSION['success'] = "Category added successfully";
            redirect('pages/settings');   
        }
        public function add_subcategory_new()
        {
            $this->pageModel->saveSC2_for_new_subcategory($_POST['scname1'], $_POST['ccid'],$_POST['mid'],$_POST['tid']);
             $_SESSION['success'] = "Subcategory added successfully";
            redirect('pages/settings');   
        }
         public function add_subcategory2()
        {
            // check for the duplicates of the sub category
            if ($this->pageModel->checkForTheSubCategory2($_POST['sCName2'], $_POST['cId2']) > 0) {
                redirect('pages/settings');
            } else {
                $this->pageModel->saveSC2($_POST['sCName2'], $_POST['cId2']);
                redirect('pages/settings');
            }
        }
        public function all_subcategories2()
        {
            $this->view('pages/all_subcategories2');
        }
        public function all_subcategories_new()
        {
            $data = [
                        'all_sub_category' => $this->pageModel->getAllsubcategory_db_direct(),
                    ];
            $this->view('pages/all_subcategories_new',$data);
        }
         public function all_model()
        {
            $data = [ 
                        'all_model' => $this->pageModel->getAllmodels_direct(),
                    ];
            $this->view('pages/all_model',$data);
        }
        public function all_model_new()
        {
            $lim = $_POST['lim'];
            $lim = (int)$lim;
            if ($lim == 9) {
                $off = $_POST['off'];
                $off = (int)$off;
                $allCategory = $this->pageModel->getAllmodels($lim, $off);
            } else {
                $inc = $_POST['inc'];
                $inc = (int)$inc;
                $lim = 9;
                $off = 9 + (9 * $inc);
                $allCategory = $this->pageModel->getAllmodels($lim, $off);
            }
            $output = '';
            
            foreach ($allCategory as $key) {
                $cName = $this->pageModel->getTYPEName($key->type_id);
                $output .= '<tr>
                    <td>' . $key->model_id . '</td>
                    <td>' . $cName . '</td>
                    <td>' . $key->model_name . '</td>
                    <td><a href="' . URLROOT . '/pages/edit_model/' . $key->model_id . '" class="btn btn-success-rgba"><i class="ri-pencil-line"></i></a>&nbsp<a href="'.URLROOT.'/pages/delete_model/'.$key->model_id.'" class="btn btn-danger-rgba"><i class="dripicons-archive"></i></a></td>
                </tr>';
                
            }
            echo $output;
            
        }

        public function all_category_new()
        {
            $lim = $_POST['lim'];
            $lim = (int)$lim;
            if ($lim == 9) {
                $off = $_POST['off'];
                $off = (int)$off;
                $allCategory = $this->pageModel->getAllcategory_db($lim, $off);
            } else {
                $inc = $_POST['inc'];
                $inc = (int)$inc;
                $lim = 9;
                $off = 9 + (9 * $inc);
                $allCategory = $this->pageModel->getAllcategory_db($lim, $off);
            }
            $output = '';
            
            foreach ($allCategory as $key) {
                $ctype = $this->pageModel->getTYPEName($key->type_id);
                $cmodel = $this->pageModel->getMODELName($key->model_id);
                $output .= '<tr>
                    <td>' . $key->category_id . '</td>
                    <td>' . $ctype . '</td>
                    <td>' . $cmodel . '</td>
                    <td>' . $key->category_name . '</td>

                    <td><a href="' . URLROOT . '/pages/edit_category_new/' . $key->category_id . '" class="btn btn-success-rgba"><i class="ri-pencil-line"></i></a>&nbsp<a href="'.URLROOT.'/pages/delete_category_new/'.$key->category_id.'" class="btn btn-danger-rgba"><i class="dripicons-archive"></i></a></td>
                </tr>';
                
            }
            echo $output;
            
        }
        public function all_subcategory_new()
        {
            $lim = $_POST['lim'];
            $lim = (int)$lim;
            if ($lim == 9) {
                $off = $_POST['off'];
                $off = (int)$off;
                $allCategory = $this->pageModel->getAllsubcategory_db($lim, $off);
            } else {
                $inc = $_POST['inc'];
                $inc = (int)$inc;
                $lim = 9;
                $off = 9 + (9 * $inc);
                $allCategory = $this->pageModel->getAllsubcategory_db($lim, $off);
            }
            $output = '';
            
            foreach ($allCategory as $key) {
                $ctype = $this->pageModel->getTYPEName($key->type_id);
                $cmodel = $this->pageModel->getMODELName($key->model_id);
                $ccategory = $this->pageModel->getCATEGORYName_db($key->category_id);
                $output .= '<tr>
                    <td>' . $key->sc_id . '</td>
                    <td>' . $ctype . '</td>
                    <td>' . $cmodel . '</td>
                    <td>' . $ccategory . '</td>
                    <td>' . $key->sc_name . '</td>

                    <td><a href="' . URLROOT . '/pages/edit_subcategory_new/' . $key->sc_id . '" class="btn btn-success-rgba"><i class="ri-pencil-line"></i></a>&nbsp<a href="'.URLROOT.'/pages/delete_subcategory_new/'.$key->sc_id.'" class="btn btn-danger-rgba"><i class="dripicons-archive"></i></a></td>
                </tr>';
                
            }
            echo $output;
            
        }
        public function delete_subcategory_new($id)
        {
            $a =0;
            $x = $this->pageModel->get_all_items_by_subcategory_db($id);
            foreach ($x as $k)
            {
                $a = $a+1;
            }
            if($a>0)
            {
                $_SESSION['success'] = "SubCategory used in project, cannot delete";
                redirect('pages/all_subcategories_new');
            }
            else
            {
                $this->pageModel->delete_subcategory_db($id);
                $_SESSION['success'] = "SubCategory deleted Successfully";
                redirect('pages/all_subcategories_new');
            }
        }
         public function edit_subcategory_new($id)
        {
            $data = ['get_all_subcategory' => $this->pageModel->get_single_subCategory_db($id)];
            $this->view('pages/edit_subcategory_new', $data);
        }
          public function update_edited_subcategory()
        {
            $this->pageModel->update_edit_subcategoryDb($_POST['cId'], $_POST['cName']);
            $_SESSION['success'] = "SubCategory updated Successfully";
            redirect('pages/all_subcategories_new');
        }
        public function delete_category_new($id)
        {
            $a =0;
            $x = $this->pageModel->get_all_items_by_category_db($id);
            foreach ($x as $k)
            {
                $a = $a+1;
            }
            if($a>0)
            {
                $_SESSION['success'] = "Category used in project, cannot delete";
                redirect('pages/all_categories_new');
            }
            else
            {
                $this->pageModel->delete_category_db($id);
                $_SESSION['success'] = "Category deleted Successfully";
                redirect('pages/all_categories_new');
            }
        }
        public function delete_model($id)
        {
            $a =0;
            $x = $this->pageModel->get_all_items_by_model_db($id);
            foreach ($x as $k)
            {
                $a = $a+1;
            }
            if($a>0)
            {
                $_SESSION['success'] = "Model used in project, cannot delete";
                redirect('pages/all_model');
            }
            else
            {
                $this->pageModel->delete_model_db($id);
                $_SESSION['success'] = "Model deleted Successfully";
                redirect('pages/all_model');
            }
        }
         public function edit_model($id)
        {
            $data = ['get_all_model' => $this->pageModel->get_single_MODEL_db_edit($id)];
            $this->view('pages/edit_model', $data);
        }
         public function edit_category_new($id)
        {
            $data = ['get_all_category' => $this->pageModel->get_single_Category_db($id)];
            $this->view('pages/edit_category_new', $data);
        }
         public function update_edited_model()
        {
            $this->pageModel->update_edit_modelDb($_POST['cId'], $_POST['cName']);
            $_SESSION['success'] = "Model updated Successfully";
            redirect('pages/all_model');
        }
        public function update_edited_category()
        {
            $this->pageModel->update_edit_categoryDb($_POST['cId'], $_POST['cName']);
            $_SESSION['success'] = "Category updated Successfully";
            redirect('pages/all_categories_new');
        }

        public function allSubCategories2()
        {
            $lim = $_POST['lim'];
            $lim = (int)$lim;
            if ($lim == 9) {
                $off = $_POST['off'];
                $off = (int)$off;
                $allCategory = $this->pageModel->getAllSubCategories2($lim, $off);
            } else {
                $inc = $_POST['inc'];
                $inc = (int)$inc;
                $lim = 9;
                $off = 9 + (9 * $inc);
                $allCategory = $this->pageModel->getAllSubCategories2($lim, $off);
            }
            $output = '';
            
            foreach ($allCategory as $key) {    
                $cName = $this->pageModel->sub_category_name($key->sub_category_id);
                $output .= '<tr>
                    <td>' . $key->sc2_id . '</td>
                    <td>' . $key->sc2_name . '</td>
                    <td>' . $cName . '</td>
                    <td><a href="' . URLROOT . '/pages/edit_subcategory2/' . $key->sc2_id . '" class="btn btn-success-rgba"><i class="ri-pencil-line"></i></a></td>
                </tr>';
               
            }
            echo $output;
        }
        public function edit_subcategory2($id)
        {
            $data = ['get_all_subcategory2' => $this->pageModel->get_all_subcategory2($id)];
            $this->view('pages/edit_subcategory2', $data);
        }
        public function subCategory2()
        {
            $subC = $this->pageModel->getSubCategoryByCategoryId2($_POST['categoryId']);
            $output = "";

            foreach ($subC as $key) {
                $output .= "<option value=" . $key->sc2_id . ">" . $key->sc2_name . "</option>";
            }
            echo $output;
        }

        public function updatesubCategoryDb2()
        {
            // check for the duplicates of the sub category
            if ($this->pageModel->checkForTheSubCategory2($_POST['sCName2'], $_POST['cId2']) > 0) {
                $_SESSION['success'] = "Sub Category2 already exists";
                redirect('pages/all_subcategories2');
            } else {
                $this->pageModel->updatesubCategoryDb2($_POST['cId2'], $_POST['cName2']);
                $_SESSION['success'] = "Sub Category2 updated";
                redirect('pages/all_subcategories2');
            }
        }
         //subcategory3
         public function add_subcategory3()
         {
             // check for the duplicates of the sub category
             if ($this->pageModel->checkForTheSubCategory3($_POST['sCName3'], $_POST['cId3']) > 0) {
                 redirect('pages/settings');
             } else {
                 $this->pageModel->saveSC3($_POST['sCName3'], $_POST['cId3']);
                 redirect('pages/settings');
             }
         }
         public function all_subcategories3()
        {
            $this->view('pages/all_subcategories3');
        }
        public function allSubCategories3()
        {
            $lim = $_POST['lim'];
            $lim = (int)$lim;
            if ($lim == 9) {
                $off = $_POST['off'];
                $off = (int)$off;
                $allCategory = $this->pageModel->getAllSubCategories3($lim, $off);
            } else {
                $inc = $_POST['inc'];
                $inc = (int)$inc;
                $lim = 9;
                $off = 9 + (9 * $inc);
                $allCategory = $this->pageModel->getAllSubCategories3($lim, $off);
            }
            $output = '';
            
            foreach ($allCategory as $key) {
                $cName = $this->pageModel->getsubcatName3($key->sub_category2_id);
                $output .= '<tr>
                    <td>' . $key->sc3_id . '</td>
                    <td>' . $key->sc3_name . '</td>
                    <td>' . $cName . '</td>
                    <td><a href="' . URLROOT . '/pages/edit_subcategory3/' . $key->sc3_id . '" class="btn btn-success-rgba"><i class="ri-pencil-line"></i></a></td>
                </tr>';
            }
            echo $output;
        }
         public function edit_subcategory3($id)
         {
             $data = ['get_all_subcategory3' => $this->pageModel->get_all_subcategory3($id)];
             $this->view('pages/edit_subcategory3', $data);
         }
         public function subCategory3()
         {
             $subC = $this->pageModel->getSubCategoryByCategoryId3($_POST['categoryId']);
             $output = "";
     
             foreach ($subC as $key) {
                 $output .= "<option value=" . $key->sc3_id . ">" . $key->sc3_name . "</option>";
             }
             echo $output;
         }
     
         public function updatesubCategoryDb3()
         {
             // check for the duplicates of the sub category
             if ($this->pageModel->checkForTheSubCategory3($_POST['cName3'], $_POST['cId3']) > 0) {
                 $_SESSION['success'] = "Sub Category3 already exists";
                 redirect('pages/all_subcategories3');
             } else {
                 $this->pageModel->updatesubCategoryDb3($_POST['cId3'], $_POST['cName3']);
                 $_SESSION['success'] = "Sub Category3 updated";
                 redirect('pages/all_subcategories3');
             }
         }


        public function allItems()
        {
            $lim = $_POST['lim'];
            $lim = (int)$lim;
            if ($lim == 9) {
                $off = $_POST['off'];
                $off = (int)$off;
                $allCategory = $this->pageModel->get_all_items($lim, $off);
            } else {
                $inc = $_POST['inc'];
                $inc = (int)$inc;
                $lim = 9;
                $off = 9 + (9 * $inc);
                $allCategory = $this->pageModel->get_all_items($lim, $off);
            }
            $output = "";
            $post = new Page();
            foreach ($allCategory as $k) {
                $a =0;
                $s_stock = $post->get_single_stock($k->id);
                foreach ($s_stock as $kw) 
                {
                $a = $a + $kw->stock_total_receive;     
                }
                $type_id = $post->get_type_name_by_id($k->type_id);
                if(empty($type_id)){ $type_id = "--";}else{ $type_id = $type_id->type_name; }
                $model_id = $post->get_model_name_by_id($k->model_id);
                if(empty($model_id)){ $model_id = "--";}else{ $model_id = $model_id->model_name; }
                $category_new_id = $post->get_category_name_by_id($k->category_new_id);
                 if(empty($category_new_id)){ $category_new_id = "--";}else{ $category_new_id = $category_new_id->category_name; }
                $subcategory_new_id = $post->get_subcategory_name_by_id($k->subcategory_new_id);
                if(empty($subcategory_new_id)){ $subcategory_new_id = "--";}else{ $subcategory_new_id = $subcategory_new_id->sc_name; }

                $dt = date("d-m-Y h:i:s a", strtotime($k->created_at));
            $output .= '<tr>
                <td scope="row">'.$k->id.'</td>
                <td><img src="'.URLROOT.'/uploads/'.$k->img.'" class="img-fluid" width="35" alt="item"></td>
                <td>'.$k->name.'</td>
                <td>'.$type_id.'</td>
                <td>'.$model_id.'</td>
                <td>'.$category_new_id.'</td>
                <td>'.$subcategory_new_id.'</td>
                <td>'.$k->selling_price.'</td>
                <td>'.$a.'</td>
                <td>
                    <div class="row">
                        <a href="'.URLROOT.'/pages/item_description/'.$k->id.'" class="btn btn-primary"><i class="ion ion-ios-browsers"></i></a>
                        &nbsp
                        <a href="'.URLROOT.'/pages/edititem/'.$k->id.'" class="btn btn-success-rgba"><i class="ri-pencil-line"></i></a>
                         &nbsp ';
                if(isset($_SESSION['user_type']))
                {
                    if($_SESSION['user_type']==0)
                    {
                        $output .='<a href="'.URLROOT.'/pages/item_delete/'.$k->id.'" class="btn btn-danger-rgba"><i class="dripicons-archive"></i></a>';
                    }
                }
                $output .='</div>
                </td>
            </tr>';
            }
            echo $output;
        }
        public function createInvoice()
        {
            $sales = $this->pageModel->getTheProcessCreate($_POST['id']);
            $sId =$_POST['id'];
            $output = '
                <table class="table">
                    <thead>
                        <tr>
                            <th>Sl.No.</th>
                            <th>Item</th>
                            <th>Package</th>
                            <th>Status</th>
                            <th width="200">Action</th>
                        <tr>
                    </thead>
                    <tbody>
            ';
            $i = 1;
            foreach ($sales as $value)
            {
                $itemId = explode('|||', $value->item_id);
                $itemId = implode('<br>', $itemId);
                $itemName = explode('|||', $value->item_name);
                $itemName = implode('<br>', $itemName);
                $itemOrdered = explode('|||', $value->item_ordered);
                $itemOrdered = implode('<br>', $itemOrdered);
                $itemPacked = explode('|||', $value->item_packed);
                $itemPacked = implode('<br>', $itemPacked);
                $itemToPack = explode('|||', $value->item_to_pack);
                $itemToPack = implode('<br>', $itemToPack);
                $sp_id = $value->sp_id;
                $status = $value->status;
                if($status == 1)
                {   
                    $message = "Packed";
                }
                if($status == 2)
                {   
                    $message = "Shipped";
                }
                if($status == 3)
                {   
                    $message = "Delivered";
                }
                $output .= '<tr>';
                $output .= '
                    <td>'.$i.'</td>
                    <td>'.$itemName.'</td>
                    <td>'.$itemPacked.'</td>
                    <td>'.$message.'</td>
                ';
                $output .= "<td><a href='".URLROOT."/pages/salesInvoice_single/".$sp_id."'><button class='btn btn-info btn-sm'>View Invoice</button></a></td>";
                $output .= '</tr>';
                $i++;
            }
            $output .= '</tbody></table>';
            echo $output;
        }
        public function createInvoice_for_stock_out()
        {
            $stock_out = $this->pageModel->getTheProcessCreate_for_stock($_POST['id']);
            $sId =$_POST['id'];
            $output = '
                <table class="table">
                    <thead>
                        <tr>
                            <th>Sl.No.</th>
                            <th>Item</th>
                            <th>Package</th>
                            <th>Status</th>
                            <th width="200">Action</th>
                        <tr>
                    </thead>
                    <tbody>
            ';
            $i = 1;
            foreach ($stock_out as $value)
            {
                $itemId = explode('|||', $value->item_id);
                $itemId = implode('<br>', $itemId);
                $itemName = explode('|||', $value->item_name);
                $itemName = implode('<br>', $itemName);
                $itemOrdered = explode('|||', $value->item_ordered);
                $itemOrdered = implode('<br>', $itemOrdered);
                $itemPacked = explode('|||', $value->item_packed);
                $itemPacked = implode('<br>', $itemPacked);
                $itemToPack = explode('|||', $value->item_to_pack);
                $itemToPack = implode('<br>', $itemToPack);
                $sp_id = $value->st_id;
                $status = $value->status;
                if($status == 1)
                {   
                    $message = "Packed";
                }
                if($status == 2)
                {   
                    $message = "Shipped";
                }
                if($status == 3)
                {   
                    $message = "Delivered";
                }
                $output .= '<tr>';
                $output .= '
                    <td>'.$i.'</td>
                    <td>'.$itemName.'</td>
                    <td>'.$itemPacked.'</td>
                    <td>'.$message.'</td>
                ';
                $output .= "<td><a href='".URLROOT."/pages/salesInvoice_single_stock_out/".$sp_id."'><button class='btn btn-info btn-sm'>View Invoice</button></a></td>";
                $output .= '</tr>';
                $i++;
            }
            $output .= '</tbody></table>';
            echo $output;
        }
        public function createInvoice_for_distributor()
        {
            $distributor = $this->pageModel->getTheProcessCreate_fordist($_POST['id']);
            $sId =$_POST['id'];
            $output = '
                <table class="table">
                    <thead>
                        <tr>
                            <th>Sl.No.</th>
                            <th>Item</th>
                            <th>Package</th>
                            <th>Status</th>
                            <th width="200">Action</th>
                        <tr>
                    </thead>
                    <tbody>
            ';
            $i = 1;
            foreach ($distributor as $value)
            {
                $itemId = explode('|||', $value->item_id);
                $itemId = implode('<br>', $itemId);
                $itemName = explode('|||', $value->item_name);
                $itemName = implode('<br>', $itemName);
                $itemOrdered = explode('|||', $value->item_ordered);
                $itemOrdered = implode('<br>', $itemOrdered);
                $itemPacked = explode('|||', $value->item_packed);
                $itemPacked = implode('<br>', $itemPacked);
                $itemToPack = explode('|||', $value->item_to_pack);
                $itemToPack = implode('<br>', $itemToPack);
                $dp_id = $value->dp_id;
                $status = $value->status;
                if($status == 1)
                {   
                    $message = "Packed";
                }
                if($status == 2)
                {   
                    $message = "Shipped";
                }
                if($status == 3)
                {   
                    $message = "Delivered";
                }
                $output .= '<tr>';
                $output .= '
                    <td>'.$i.'</td>
                    <td>'.$itemName.'</td>
                    <td>'.$itemPacked.'</td>
                    <td>'.$message.'</td>
                ';
                $output .= "<td><a href='".URLROOT."/pages/salesInvoice_single_for_distributor/".$dp_id."'><button class='btn btn-info btn-sm'>View Invoice</button></a></td>";
                $output .= '</tr>';
                $i++;
            }
            $output .= '</tbody></table>';
            echo $output;
        }
        public function salesInvoice_single($ds)
        {
            $sId = $this->pageModel->get_sales_from_sales_pacakge($ds);
            $pack_wise_invoice = $this->pageModel->get_package_details_for_sales_invoice($ds);
            $data = [
                'sales' => $this->pageModel->getsalesOrderDetails($sId),
                'p_sales' => $pack_wise_invoice

            ];
            $this->view('pages/sales_invoice_single', $data);
        }
        public function salesInvoice_single_stock_out($ds)
        {
            $sId = $this->pageModel->get_stock_out_from_sales_pacakge($ds);
            $pack_wise_invoice = $this->pageModel->get_package_details_for_stock_out_invoice($ds);
            $data = [
                'stockout' => $this->pageModel->getstockoutOrderDetails($sId),
                'p_stockout' => $pack_wise_invoice

            ];
            $this->view('pages/stock_out_invoice_single', $data);
        }
        public function salesInvoice_single_for_distributor($ds)
        {
            $sId = $this->pageModel->get_Distributor_from_Distributor_pacakge($ds);
            $pack_wise_invoice = $this->pageModel->get_package_details_for_dist_invoice($ds);
            $data = [
                'distributor' => $this->pageModel->getdistributor_orderDetails($sId),
                'p_distributor' => $pack_wise_invoice
            ];
            $this->view('pages/salesInvoice_single_for_distributor', $data);
        }
        public function salesInvoice($sId)
        {
            $data = [
                'sales' => $this->pageModel->getsalesOrderDetails($sId),
                'id' =>$sId,
            ];
            if(empty($data['sales']))
            {
                redirect('pages/sales_order');
            }
            else
            {
                $this->view('pages/sales_invoice', $data);
            }
        }
        public function distributorInvoice($sId)
        {
            $data = [
                'dist' => $this->pageModel->getdistributor_orderDetails($sId),
            ];
            if(empty($data['dist']))
            {
                redirect('pages/all_distributor_order');
            }
            else
            {
                $this->view('pages/distributor_invoice', $data);
            }
        }

        public function non_purchase()
        {
            $this->pageModel->clear_all_tempnon_purchase();
            $data = [
                        'vendor' =>$this->pageModel->get_all_vendor(),
                        'positions' => $this->pageModel->getAllPOsitionsForReceive(),
                        'cat' => $this->pageModel->getAllCategoriesDb(),
                        'cat1' => $this->pageModel->getAllCategoriesDb2(),
                        'cat2' => $this->pageModel->getAllCategoriesDb3(),
                        'cat3' => $this->pageModel->getAllCategoriesDb4(),
                        'type' => $this->pageModel->getAlltypeDb(),
                        'model' => $this->pageModel->getAllCategoriesDb_model(),
                        'cat_new' => $this->pageModel->getAllCategoriesDb_new(),
                        'subcat_new' => $this->pageModel->getAllsubCategoriesDb_new(),
                        'color' => $this->pageModel->getAllcolorDb_new(),
                        'size' => $this->pageModel->getAllsizeDb_new(),
                        'all_mfg' => $this->pageModel->getallmfg(),
                        'all_items' => $this->pageModel->get_all_items_for_dropdown(),
                        'part_no' => $this->pageModel->get_all_partnumbers()
            ];
             unset($_SESSION['print_qr']);
            $this->view('pages/non_purchase', $data);
        }

        public function saveTheReceive1()
        {
            if(isset($_SESSION['mfg_sort']))
            {
                unset($_SESSION['mfg_sort']);
            }
            $itemid = $_POST['itemId'];
            $item_name = $_POST['itemName'];
            $receive = $_POST['receivable'];
            $rqty = $_POST['rQty'];
            $position1 = $_POST['pos'];
            if(empty($itemid))
            {}
            else
            {
                $this->pageModel->savetempnonpurchasedb($itemid, $item_name, $receive, $rqty, $position1);
            }
            $z = $this->pageModel->get_temp_nonpurchasedb_count();
            if(empty($z))
            {
                $_SESSION['success'] = "Enter all Fields";
                redirect('pages/non_purchase');
            }
            else
            {
                $vendor = '';
                $vendor = $this->pageModel->get_vendor_bill_for_onclick($_POST['vendor_id']);
                $vendor_name = $vendor->dispName;
                $vendor_id = $_POST['vendor_id'];
                $batch = $_POST['batch'];
                $itemId = $_POST['itemId'];
                // $itemName = $_POST['itemName'];
                $rec_date = $_POST['rec_date'];
                $receivable = $_POST['receivable'];
                $rQty = $_POST['rQty'];
                $notes = $_POST['notes'];
                $position = $_POST['pos'];
                $barcode = $_POST['barcode'];
                $rem=0;
                $d = $this->pageModel->save_stock_with_batch1($rQty,$rem,$itemId,$rQty,$position,$batch,$rec_date,$barcode,$vendor_name,$vendor_id,$receivable,$notes);
                $_SESSION['success'] ="Details Updated";
                $data=[ 
                        'temp_qr_print_all' => $d['temp_qr_print_all'],
                        'temp_qr_id'=>$d['temp_qr_id'],
                        'itemid'=>$d['itemid'],
                        'rQty' => $d['rQty'],
                        'itemName'=>$d['itemName'],
                        'receivable_type' => $d['receivable_type'],
                      ];
                $_SESSION['print_qr'] = $data;
                redirect('pages/print_qr');
            }
        }

        public function generateBarcode()
        {
            require("barcode/barcode.class.php");
            $bar = new BARCODE();

            //Barcode
            $baccode = $bar->BarCode_link("UPC-A", "123456789128");
            echo "<img src='".$baccode."'/>";
        }

        public function barcode()
        {
            $this->view('barcode/index');
        }
        public function allItemsById()
        {
            $itm = $_POST['itm'];
            $allCategory = $this->pageModel->get_all_items_id($itm);
            $output = "";
            $post = new Page();
            foreach ($allCategory as $k) {
                $a =0;
                $s_stock = $post->get_single_stock($k->id);
                foreach ($s_stock as $kw) 
                {
                $a = $a + $kw->stock_total_receive;     
                }
                $type_id = $post->get_type_name_by_id($k->type_id);
                if(empty($type_id)){ $type_id = "--";}else{ $type_id = $type_id->type_name; }
                $model_id = $post->get_model_name_by_id($k->model_id);
                if(empty($model_id)){ $model_id = "--";}else{ $model_id = $model_id->model_name; }
                $category_new_id = $post->get_category_name_by_id($k->category_new_id);
                 if(empty($category_new_id)){ $category_new_id = "--";}else{ $category_new_id = $category_new_id->category_name; }
                $subcategory_new_id = $post->get_subcategory_name_by_id($k->subcategory_new_id);
                if(empty($subcategory_new_id)){ $subcategory_new_id = "--";}else{ $subcategory_new_id = $subcategory_new_id->sc_name; }
                $dt = date("d-m-Y h:i:s a", strtotime($k->created_at));
            $output .= '<tr>
                <td scope="row">'.$k->id.'</td>
                <td><img src="'.URLROOT.'/uploads/'.$k->img.'" class="img-fluid" width="35" alt="item"></td>
                <td>'.$k->name.'</td>
                 <td>'.$type_id.'</td>
                <td>'.$model_id.'</td>
                <td>'.$category_new_id.'</td>
                <td>'.$subcategory_new_id.'</td>
                <td>'.$k->selling_price.'</td>
                <td>'.$a.'</td>
                <td>
                    <div class="row">
                        <a href="'.URLROOT.'/pages/item_description/'.$k->id.'" class="btn btn-primary"><i class="ion ion-ios-browsers"></i></a>
                        &nbsp;
                        <a href="'.URLROOT.'/pages/edititem/'.$k->id.'" class="btn btn-success-rgba"><i class="ri-pencil-line"></i></a>
                        &nbsp;
                        <a href="'.URLROOT.'/pages/item_delete/'.$k->id.'" class="btn btn-danger-rgba"><i class="dripicons-archive"></i></a>
                    </div>
                </td>
            </tr>';
            }
            echo $output;
        }

        public function allItemsByName()
        {
            $itm = $_POST['itmName'];
            $allCategory = $this->pageModel->get_all_items_name($itm);
            $output = "";
            $post = new Page();
            foreach ($allCategory as $k) {
                 $a =0;
                $s_stock = $post->get_single_stock($k->id);
                foreach ($s_stock as $kw) 
                {
                $a = $a + $kw->stock_total_receive;     
                }
                $type_id = $post->get_type_name_by_id($k->type_id);
                if(empty($type_id)){ $type_id = "--";}else{ $type_id = $type_id->type_name; }
                $model_id = $post->get_model_name_by_id($k->model_id);
                if(empty($model_id)){ $model_id = "--";}else{ $model_id = $model_id->model_name; }
                $category_new_id = $post->get_category_name_by_id($k->category_new_id);
                 if(empty($category_new_id)){ $category_new_id = "--";}else{ $category_new_id = $category_new_id->category_name; }
                $subcategory_new_id = $post->get_subcategory_name_by_id($k->subcategory_new_id);
                if(empty($subcategory_new_id)){ $subcategory_new_id = "--";}else{ $subcategory_new_id = $subcategory_new_id->sc_name; }
                $dt = date("d-m-Y h:i:s a", strtotime($k->created_at));
            $output .= '<tr>
                <td scope="row">'.$k->id.'</td>
                <td><img src="'.URLROOT.'/uploads/'.$k->img.'" class="img-fluid" width="35" alt="item"></td>
                <td>'.$k->name.'</td>
                 <td>'.$type_id.'</td>
                <td>'.$model_id.'</td>
                <td>'.$category_new_id.'</td>
                <td>'.$subcategory_new_id.'</td>
                <td>'.$k->selling_price.'</td>
                <td>'.$a.'</td>
                <td>
                    <div class="row">
                        <a href="'.URLROOT.'/pages/item_description/'.$k->id.'" class="btn btn-primary"><i class="ion ion-ios-browsers"></i></a>
                        &nbsp;
                        <a href="'.URLROOT.'/pages/edititem/'.$k->id.'" class="btn btn-success-rgba"><i class="ri-pencil-line"></i></a>
                        &nbsp;
                        <a href="'.URLROOT.'/pages/item_delete/'.$k->id.'" class="btn btn-danger-rgba"><i class="dripicons-archive"></i></a>
                    </div>
                </td>
            </tr>';
            }
            echo $output;
        }
        public function allcustomer_byname()
        {
            $itm = $_POST['CustName'];
            if($_SESSION['ctype']==3)
            {
                $customer = $this->pageModel->get_all_customer_by_name3($itm);
                $output = "";
                foreach ($customer as $k)
                {
                    $output .=' <tr>
                                    <td>'.$k->id.'</td>
                                    <td>'.$k->customer_display_name.'</td>
                                    <td>'.$k->customer_phno_work.'</td>
                                    <td>'.$k->b_city.'</td>
                                    <td> <a href="'.URLROOT.'/pages/edit_customer/'.$k->id.'" class="btn btn-success-rgba"><i class="ri-pencil-line"></i></a>  <a href="'.URLROOT.'/pages/del_customer/'.$k->id.'" class="btn btn-danger-rgba"><i class="ri-delete-bin-3-line"></i></a></td>
                                </tr>';
                }
            }elseif($_SESSION['ctype']==1)
            {
                $cp = 1;
                $customer = $this->pageModel->get_all_customer_by_name($itm,$cp);
                $output = "";
                foreach ($customer as $k)
                {
                    $output .=' <tr>
                                    <td>'.$k->id.'</td>
                                    <td>'.$k->customer_display_name.'</td>
                                    <td>'.$k->customer_phno_work.'</td>
                                    <td>'.$k->b_city.'</td>
                                    <td> <a href="'.URLROOT.'/pages/edit_customer/'.$k->id.'" class="btn btn-success-rgba"><i class="ri-pencil-line"></i></a>  <a href="'.URLROOT.'/pages/del_customer/'.$k->id.'" class="btn btn-danger-rgba"><i class="ri-delete-bin-3-line"></i></a></td>
                                </tr>';
                }
            }
            elseif($_SESSION['ctype']==4)
            {
                $cp = 4;
                $customer = $this->pageModel->get_all_customer_by_name($itm,$cp);
                $output = "";
                foreach ($customer as $k)
                {
                    $output .=' <tr>
                                    <td>'.$k->id.'</td>
                                    <td>'.$k->customer_display_name.'</td>
                                    <td>'.$k->customer_phno_work.'</td>
                                    <td>'.$k->b_city.'</td>
                                    <td> <a href="'.URLROOT.'/pages/edit_customer/'.$k->id.'" class="btn btn-success-rgba"><i class="ri-pencil-line"></i></a>  <a href="'.URLROOT.'/pages/del_customer/'.$k->id.'" class="btn btn-danger-rgba"><i class="ri-delete-bin-3-line"></i></a></td>
                                </tr>';
                }
            }
            elseif($_SESSION['ctype']==5)
            {
                $cp = 5;
                $customer = $this->pageModel->get_all_customer_by_name($itm,$cp);
                $output = "";
                foreach ($customer as $k)
                {
                    $output .=' <tr>
                                    <td>'.$k->id.'</td>
                                    <td>'.$k->customer_display_name.'</td>
                                    <td>'.$k->customer_phno_work.'</td>
                                    <td>'.$k->b_city.'</td>
                                    <td> <a href="'.URLROOT.'/pages/edit_customer/'.$k->id.'" class="btn btn-success-rgba"><i class="ri-pencil-line"></i></a>  <a href="'.URLROOT.'/pages/del_customer/'.$k->id.'" class="btn btn-danger-rgba"><i class="ri-delete-bin-3-line"></i></a></td>
                                </tr>';
                }
            }
            elseif($_SESSION['ctype']==6)
            {
                $cp = 6;
                $customer = $this->pageModel->get_all_customer_by_name($itm,$cp);
                $output = "";
                foreach ($customer as $k)
                {
                    $output .=' <tr>
                                    <td>'.$k->id.'</td>
                                    <td>'.$k->customer_display_name.'</td>
                                    <td>'.$k->customer_phno_work.'</td>
                                    <td>'.$k->b_city.'</td>
                                    <td> <a href="'.URLROOT.'/pages/edit_customer/'.$k->id.'" class="btn btn-success-rgba"><i class="ri-pencil-line"></i></a>  <a href="'.URLROOT.'/pages/del_customer/'.$k->id.'" class="btn btn-danger-rgba"><i class="ri-delete-bin-3-line"></i></a></td>
                                </tr>';
                }
            }
            elseif($_SESSION['ctype']==7)
            {
                $cp = 7;
                $customer = $this->pageModel->get_all_customer_by_name($itm,$cp);
                $output = "";
                foreach ($customer as $k)
                {
                    $output .=' <tr>
                                    <td>'.$k->id.'</td>
                                    <td>'.$k->customer_display_name.'</td>
                                    <td>'.$k->customer_phno_work.'</td>
                                    <td>'.$k->b_city.'</td>
                                    <td> <a href="'.URLROOT.'/pages/edit_customer/'.$k->id.'" class="btn btn-success-rgba"><i class="ri-pencil-line"></i></a>  <a href="'.URLROOT.'/pages/del_customer/'.$k->id.'" class="btn btn-danger-rgba"><i class="ri-delete-bin-3-line"></i></a></td>
                                </tr>';
                }
            }
            elseif($_SESSION['ctype']==8)
            {
                $cp = 8;
                $customer = $this->pageModel->get_all_customer_by_name($itm,$cp);
                $output = "";
                foreach ($customer as $k)
                {
                    $output .=' <tr>
                                    <td>'.$k->id.'</td>
                                    <td>'.$k->customer_display_name.'</td>
                                    <td>'.$k->customer_phno_work.'</td>
                                    <td>'.$k->b_city.'</td>
                                    <td> <a href="'.URLROOT.'/pages/edit_customer/'.$k->id.'" class="btn btn-success-rgba"><i class="ri-pencil-line"></i></a>  <a href="'.URLROOT.'/pages/del_customer/'.$k->id.'" class="btn btn-danger-rgba"><i class="ri-delete-bin-3-line"></i></a></td>
                                </tr>';
                }
            }
            elseif($_SESSION['ctype']==9)
            {
                $cp = 9;
                $customer = $this->pageModel->get_all_customer_by_name($itm,$cp);
                $output = "";
                foreach ($customer as $k)
                {
                    $output .=' <tr>
                                    <td>'.$k->id.'</td>
                                    <td>'.$k->customer_display_name.'</td>
                                    <td>'.$k->customer_phno_work.'</td>
                                    <td>'.$k->b_city.'</td>
                                    <td> <a href="'.URLROOT.'/pages/edit_customer/'.$k->id.'" class="btn btn-success-rgba"><i class="ri-pencil-line"></i></a>  <a href="'.URLROOT.'/pages/del_customer/'.$k->id.'" class="btn btn-danger-rgba"><i class="ri-delete-bin-3-line"></i></a></td>
                                </tr>';
                }
            }
            else
            {
               $cp = 0;
               $customer = $this->pageModel->get_all_customer_by_name($itm,$cp); 
               $output = "";
                foreach ($customer as $k)
                {
                    $output .=' <tr>
                                    <td>'.$k->id.'</td>
                                    <td>'.$k->customer_display_name.'</td>
                                    <td>'.$k->customer_phno_work.'</td>
                                    <td>'.$k->b_city.'</td>
                                    <td> <a href="'.URLROOT.'/pages/edit_customer/'.$k->id.'" class="btn btn-success-rgba"><i class="ri-pencil-line"></i></a>  <a href="'.URLROOT.'/pages/del_customer/'.$k->id.'" class="btn btn-danger-rgba"><i class="ri-delete-bin-3-line"></i></a></td>
                                </tr>';
                }
            }
            echo $output;
        }

        public function allItemsByCat()
        {
            $itm = $_POST['itemCat'];
            $allCategory = $this->pageModel->get_all_items_cat($itm);
            $output = "";
             $post = new Page();
            foreach ($allCategory as $k) {
                $a =0;
                $s_stock = $post->get_single_stock($k->id);
                foreach ($s_stock as $kw) 
                {
                $a = $a + $kw->stock_total_receive;     
                }
                $type_id = $post->get_type_name_by_id($k->type_id);
                if(empty($type_id)){ $type_id = "--";}else{ $type_id = $type_id->type_name; }
                $model_id = $post->get_model_name_by_id($k->model_id);
                if(empty($model_id)){ $model_id = "--";}else{ $model_id = $model_id->model_name; }
                $category_new_id = $post->get_category_name_by_id($k->category_new_id);
                 if(empty($category_new_id)){ $category_new_id = "--";}else{ $category_new_id = $category_new_id->category_name; }
                $subcategory_new_id = $post->get_subcategory_name_by_id($k->subcategory_new_id);
                if(empty($subcategory_new_id)){ $subcategory_new_id = "--";}else{ $subcategory_new_id = $subcategory_new_id->sc_name; }
                $dt = date("d-m-Y h:i:s a", strtotime($k->created_at));
            $output .= '<tr>
                <td scope="row">'.$k->id.'</td>
                <td><img src="'.URLROOT.'/uploads/'.$k->img.'" class="img-fluid" width="35" alt="item"></td>
                <td>'.$k->name.'</td>
                 <td>'.$type_id.'</td>
                <td>'.$model_id.'</td>
                <td>'.$category_new_id.'</td>
                <td>'.$subcategory_new_id.'</td>
                <td>'.$k->selling_price.'</td>
                <td>'.$a.'</td>
                <td>
                    <div class="row">
                        <a href="'.URLROOT.'/pages/item_description/'.$k->id.'" class="btn btn-primary"><i class="ion ion-ios-browsers"></i></a>
                        &nbsp;
                        <a href="'.URLROOT.'/pages/edititem/'.$k->id.'" class="btn btn-success-rgba"><i class="ri-pencil-line"></i></a>
                         &nbsp;
                        <a href="'.URLROOT.'/pages/item_delete/'.$k->id.'" class="btn btn-danger-rgba"><i class="dripicons-archive"></i></a>
                    </div>
                </td>
            </tr>';
            }
            echo $output;
        }
        public function allItemsByComp()
        {
            $itm = $_POST['itemComp'];
            $allComp = $this->pageModel->get_all_items_comp($itm);
            $output = "";
             $post = new Page();
            foreach ($allComp as $k) {
                $a =0;
                $s_stock = $post->get_single_stock($k->id);
                foreach ($s_stock as $kw) 
                {
                $a = $a + $kw->stock_total_receive;     
                }
                $type_id = $post->get_type_name_by_id($k->type_id);
                if(empty($type_id)){ $type_id = "--";}else{ $type_id = $type_id->type_name; }
                $model_id = $post->get_model_name_by_id($k->model_id);
                if(empty($model_id)){ $model_id = "--";}else{ $model_id = $model_id->model_name; }
                $category_new_id = $post->get_category_name_by_id($k->category_new_id);
                 if(empty($category_new_id)){ $category_new_id = "--";}else{ $category_new_id = $category_new_id->category_name; }
                $subcategory_new_id = $post->get_subcategory_name_by_id($k->subcategory_new_id);
                if(empty($subcategory_new_id)){ $subcategory_new_id = "--";}else{ $subcategory_new_id = $subcategory_new_id->sc_name; }
                $dt = date("d-m-Y h:i:s a", strtotime($k->created_at));
            $output .= '<tr>
                <td scope="row">'.$k->id.'</td>
                <td><img src="'.URLROOT.'/uploads/'.$k->img.'" class="img-fluid" width="35" alt="item"></td>
                <td>'.$k->name.'</td>
                <td>'.$type_id.'</td>
                <td>'.$model_id.'</td>
                <td>'.$category_new_id.'</td>
                <td>'.$subcategory_new_id.'</td>
                <td>'.$k->selling_price.'</td>
                <td>'.$a.'</td>
                <td>
                    <div class="row">
                        <a href="'.URLROOT.'/pages/item_description/'.$k->id.'" class="btn btn-primary"><i class="ion ion-ios-browsers"></i></a>
                        &nbsp;
                        <a href="'.URLROOT.'/pages/edititem/'.$k->id.'" class="btn btn-success-rgba"><i class="ri-pencil-line"></i></a>
                         &nbsp;
                        <a href="'.URLROOT.'/pages/item_delete/'.$k->id.'" class="btn btn-danger-rgba"><i class="dripicons-archive"></i></a>
                    </div>
                </td>
            </tr>';
            }
            echo $output;
        }
        public function by_allcategory()
        {

            $category_id = $_POST['category_id'];
            $subCategory = $_POST['subCategory'];
            $subCategory1 = $_POST['subCategory1'];
            $subCategory2 = $_POST['subCategory2'];
             if((!empty($category_id)) && (!empty($subCategory)) && (!empty($subCategory1)) && (!empty($subCategory2)))
             {
                $allComp = $this->pageModel->get_all_category_wise_details1s($category_id,$subCategory,$subCategory1,$subCategory2);
            }
            elseif ((!empty($category_id)) && (!empty($subCategory)) && (!empty($subCategory1)) && (empty($subCategory2)))
            {
                $allComp = $this->pageModel->get_all_category_wise_details2s($category_id,$subCategory,$subCategory1);
            }
            elseif ((!empty($category_id)) && (!empty($subCategory)) && (empty($subCategory1)) && (empty($subCategory2)))
            {
                $allComp = $this->pageModel->get_all_category_wise_details3s($category_id,$subCategory);
            }
            elseif ((!empty($category_id)) && (empty($subCategory)) && (empty($subCategory1)) && (empty($subCategory2)))
            {
                $allComp = $this->pageModel->get_all_category_wise_details4s($category_id);
            }
            else
            {
                $allComp = $this->pageModel->get_all_category_wise_details();
            }
           
            $output = "";
            $post = new Page();
            foreach ($allComp as $k) {
                $a =0;
                $s_stock = $post->get_single_stock($k->id);
                foreach ($s_stock as $kw) 
                {
                $a = $a + $kw->stock_total_receive;     
                }
                $type_id = $post->get_type_name_by_id($k->type_id);
                if(empty($type_id)){ $type_id = "--";}else{ $type_id = $type_id->type_name; }
                $model_id = $post->get_model_name_by_id($k->model_id);
                if(empty($model_id)){ $model_id = "--";}else{ $model_id = $model_id->model_name; }
                $category_new_id = $post->get_category_name_by_id($k->category_new_id);
                 if(empty($category_new_id)){ $category_new_id = "--";}else{ $category_new_id = $category_new_id->category_name; }
                $subcategory_new_id = $post->get_subcategory_name_by_id($k->subcategory_new_id);
                if(empty($subcategory_new_id)){ $subcategory_new_id = "--";}else{ $subcategory_new_id = $subcategory_new_id->sc_name; }
                $dt = date("d-m-Y h:i:s a", strtotime($k->created_at));
            $output .= '<tr>
                <td scope="row">'.$k->id.'</td>
                <td><img src="'.URLROOT.'/uploads/'.$k->img.'" class="img-fluid" width="35" alt="item"></td>
                <td>'.$k->name.'</td>
                <td>'.$type_id.'</td>
                <td>'.$model_id.'</td>
                <td>'.$category_new_id.'</td>
                <td>'.$subcategory_new_id.'</td>
                <td>'.$k->selling_price.'</td>
                <td>'.$a.'</td>
                <td>
                    <div class="row">
                        <a href="'.URLROOT.'/pages/item_description/'.$k->id.'" class="btn btn-primary"><i class="ion ion-ios-browsers"></i></a>
                        &nbsp;
                        <a href="'.URLROOT.'/pages/edititem/'.$k->id.'" class="btn btn-success-rgba"><i class="ri-pencil-line"></i></a>
                         &nbsp;
                        <a href="'.URLROOT.'/pages/item_delete/'.$k->id.'" class="btn btn-danger-rgba"><i class="dripicons-archive"></i></a>
                    </div>
                </td>
            </tr>';
            }
            echo $output;
        }

        public function checkName()
        {
            $name = $_POST['name'];
            echo $count = $this->pageModel->checkNameDb($name);
        }

        public function calculate_barcode()
        {
            $itemid=$_POST['itemid'];
            $rqty = $_POST['rqty'];
            $last_id = $this->pageModel->get_last_id_stock();
            if(!empty($last_id))
            { 
            $pId = $last_id->id;
            }
            else
            {
                $pId = 0;
            }
            $qty = $rqty;
            $prId = sprintf('%06d', $itemid);
            $pId = sprintf('%03d', $pId);
            echo $ccc = $prId."0".$pId.'NP';
        }
        public function calculate_barcode1()
        {
            $itemid=$_POST['itemid'];
            $rqty = $_POST['rqty'];
            $last_id = $this->pageModel->get_last_id_stock();
            if(!empty($last_id))
            { 
            $pId = $last_id->id;
            }
            else
            {
                $pId = 0;
            }
            $qty = $rqty;
            $prId = sprintf('%06d', $itemid);
            $pId = sprintf('%03d', $pId);
            echo '<iframe align="center" width="100%" height="100%" src="https://medhike.com/rituhospital/b/barcode/index2.php?product_id='.$_SESSION['db_code'].$itemid.'&serial_id=0&pid='.$pId.'&qty='.$rqty.'" frameborder="yes" scrolling="yes" name="myIframe" id="myIframe1"> </iframe>';
        }
        public function calculate_barcode2()
        {
            $itemid=$_POST['itemid'];
            $rqty = $_POST['rqty'];
            $last_id = $this->pageModel->get_last_id_stock();
            if(!empty($last_id))
            { 
            $pId = $last_id->id;
            }
            else
            {
                $pId = 0;
            }
            $qty = $rqty;
            $prId = sprintf('%06d', $itemid);
            $pId = sprintf('%03d', $pId);
            echo '<iframe align="center" width="100%" height="100%" src="https://medhike.com/rituhospital/b/barcode/index3.php?product_id='.$_SESSION['db_code'].$itemid.'&serial_id=0&pid='.$pId.'&qty='.$rqty.'" frameborder="yes" scrolling="yes" name="myIframe" id="myIframe2"> </iframe>';        
        }
        public function allItemsforcatreport()
        {
            $lim = $_POST['lim'];
            $lim = (int)$lim;
            if ($lim == 0) {
                $off = $_POST['off'];
                $off = (int)$off;
                $allCategory = $this->pageModel->get_all_items($lim, $off);
            } else {
                $inc = $_POST['inc'];
                $inc = (int)$inc;
                $lim = 0;
                $off = 0 + (0 * $inc);
                $allCategory = $this->pageModel->get_all_items($lim, $off);
            }
            $output = "";
            $post = new Page();
            foreach ($allCategory as $k) {
                $a =0;
                $s_stock = $post->get_single_stock($k->id);
                foreach ($s_stock as $kw) 
                {
                $a = $a + $kw->stock_total_receive;     
                }
                $type_id = $post->get_type_name_by_id($k->type_id);
                if(empty($type_id)){ $type_id = "--";}else{ $type_id = $type_id->type_name; }
                $model_id = $post->get_model_name_by_id($k->model_id);
                if(empty($model_id)){ $model_id = "--";}else{ $model_id = $model_id->model_name; }
                $category_new_id = $post->get_category_name_by_id($k->category_new_id);
                 if(empty($category_new_id)){ $category_new_id = "--";}else{ $category_new_id = $category_new_id->category_name; }
                $subcategory_new_id = $post->get_subcategory_name_by_id($k->subcategory_new_id);
                if(empty($subcategory_new_id)){ $subcategory_new_id = "--";}else{ $subcategory_new_id = $subcategory_new_id->sc_name; }
                $dt = date("d-m-Y h:i:s a", strtotime($k->created_at));
                if($k->receive==1){ $rec ="Box(Qty ".$k->qty.")"; }else{ $rec ="Pieces(Qty ".$k->qty.")";}
            $output .= '<tr>
                <td scope="row">'.$k->id.'</td>
                <td>'.$k->name.'</td>
                <td>'.$rec.'</td>
                <td>'.$type_id.'</td>
                <td>'.$model_id.'</td>
                <td>'.$category_new_id.'</td>
                <td>'.$subcategory_new_id.'</td>
                <td>'.$k->brand.'</td>
                <td>'.$k->purchase_price.'</td>
                <td>'.$k->selling_price.'</td>
                <td>'.$a.'</td>
            </tr>';
            }
            echo $output;
        }
         public function by_allcategory_item_cat()
        {

            $category_id = $_POST['category_id'];
            $subCategory = $_POST['subCategory'];
            $subCategory1 = $_POST['subCategory1'];
            $subCategory2 = $_POST['subCategory2'];
             if((!empty($category_id)) && (!empty($subCategory)) && (!empty($subCategory1)) && (!empty($subCategory2)))
             { 
                $allComp = $this->pageModel->get_all_category_wise_details1($category_id,$subCategory,$subCategory1,$subCategory2);
            }
            elseif ((!empty($category_id)) && (!empty($subCategory)) && (!empty($subCategory1)) && (empty($subCategory2))) 
            {
                $allComp = $this->pageModel->get_all_category_wise_details2($category_id,$subCategory,$subCategory1);
            }
            elseif ((!empty($category_id)) && (!empty($subCategory)) && (empty($subCategory1)) && (empty($subCategory2))) 
            {
                $allComp = $this->pageModel->get_all_category_wise_details3($category_id,$subCategory);
            }
            
            elseif ((!empty($category_id)) && (empty($subCategory)) && (empty($subCategory1)) && (empty($subCategory2))) 
            {
                $allComp = $this->pageModel->get_all_category_wise_details4($category_id);
                
            }
            else
            {
                $allComp = $this->pageModel->get_all_category_wise_details();
            }
           
            $output = "";
            foreach ($allComp as $k) {
                $dt = date("d-m-Y h:i:s a", strtotime($k->created_at));
                if($k->receive==1){ $rec ="Box(Qty ".$k->qty.")"; }else{ $rec ="Pieces(Qty ".$k->qty.")";}
            $output .= '<tr>
                <td scope="row">'.$k->id.'</td>
                <td>'.$k->name.'</td>
                <td>'.$rec.'</td>
                <td class="text-success">'.$k->discount.'</td>
                <td>'.$k->brand.'</td>
                <td>'.$k->purchase_price.'</td>
                <td>'.$k->selling_price.'</td>
            </tr>';
            }
            echo $output;
        }
         public function by_allcategory_item_cat1()
        {
            $category_id = $_POST['category_id'];
            $subCategory = $_POST['subCategory'];
            $subCategory1 = $_POST['subCategory1'];
            $subCategory2 = $_POST['subCategory2'];
             if((!empty($category_id)) && (!empty($subCategory)) && (!empty($subCategory1)) && (!empty($subCategory2)))
             {
                $allComp = $this->pageModel->get_all_category_wise_details1s($category_id,$subCategory,$subCategory1,$subCategory2);
            }
            elseif ((!empty($category_id)) && (!empty($subCategory)) && (!empty($subCategory1)) && (empty($subCategory2)))
            {
                $allComp = $this->pageModel->get_all_category_wise_details2s($category_id,$subCategory,$subCategory1);
            }
            elseif ((!empty($category_id)) && (!empty($subCategory)) && (empty($subCategory1)) && (empty($subCategory2)))
            {
                $allComp = $this->pageModel->get_all_category_wise_details3s($category_id,$subCategory);
            }
            elseif ((!empty($category_id)) && (empty($subCategory)) && (empty($subCategory1)) && (empty($subCategory2)))
            {
                $allComp = $this->pageModel->get_all_category_wise_details4s($category_id);
            }
            else
            {
                $allComp = $this->pageModel->get_all_category_wise_details();
            }
            $output = "";
            $sum=0;
            $post = new Page();
            $tt = 0;
            foreach ($allComp as $k) {
                $a = 0;
                $b = 0;
                $c = 0;
                $d = 0;
                $b1=0;
                $d1=0;
                $c1 = 0;
                $s_stock = $post->get_single_stock($k->id);
                foreach ($s_stock as $kw)
                {
                    $a = $a + $kw->stock_total_receive;
                    if($kw->receivable == 0)
                    {
                        $b1 = $b1 + $kw->stock_total_receive;
                        $d1 = (int)$k->carton_qty * (int)$b1;
                        $c1 = (int)$k->qty * (int)$d1;
                    }
                    if($kw->receivable == 1)
                    {
                        $b = (int)$b + (int)$kw->stock_total_receive;
                        $d = (int)$k->qty * (int)$b;
                    }
                    if($kw->receivable == 3)
                    {
                        $c = $c + $kw->stock_total_receive;
                    }
                }
                $type_id = $post->get_type_name_by_id($k->type_id);
                if(empty($type_id)){ $type_id = "--";}else{ $type_id = $type_id->type_name; }
                $model_id = $post->get_model_name_by_id($k->model_id);
                if(empty($model_id)){ $model_id = "--";}else{ $model_id = $model_id->model_name; }
                $category_new_id = $post->get_category_name_by_id($k->category_new_id);
                 if(empty($category_new_id)){ $category_new_id = "--";}else{ $category_new_id = $category_new_id->category_name; }
                $subcategory_new_id = $post->get_subcategory_name_by_id($k->subcategory_new_id);
                if(empty($subcategory_new_id)){ $subcategory_new_id = "--";}else{ $subcategory_new_id = $subcategory_new_id->sc_name; }
                $dt = date("d-m-Y h:i:s a", strtotime($k->created_at));
                $sum = $sum + $a;
                if($k->receive==0)
                { 
                    $rec ="Carton([B]Qty ".$k->carton_qty.")<br>Box([P]Qty ".$k->qty.")"; 
                }
                elseif($k->receive==1)
                { 
                    $rec ="Box([P]Qty ".$k->qty.")"; 
                }
                else
                { 
                    $rec ="Pieces(Qty ".$k->qty.")";
                }
            $output .= '<tr>
                <td>'.$k->id.'</td>
                <td>'.$k->name.'</td>
                <td>'.$rec.'</td>
                <td>'.$type_id.'</td>
                <td>'.$model_id.'</td>
                <td>'.$category_new_id.'</td>
                <td>'.$subcategory_new_id.'</td>
                <td>Carton('.$b1.')<br>Box('.$b.')<br>Pieces('.$c.')</td>
                <td class="td-cust-b">'.$d = $d + $c + $c1.'</td>
            </tr>';
            }
            $_SESSION['sum'] = $sum;
            echo $output;
        }

        public function item_by_category()
        {
            if(isset($_SESSION['temp_print']))
            {
                redirect('pages/item_by_category');
                unset($_SESSION['temp_print']);
            }
            $data = [
                'cat' => $this->pageModel->getAllCategoriesDb(),
                'cat1' => $this->pageModel->getAllCategoriesDb2(),
                'cat2' => $this->pageModel->getAllCategoriesDb3(),
                'cat3' => $this->pageModel->getAllCategoriesDb4(),
                'type' => $this->pageModel->getAlltypeDb(),
                'model' => $this->pageModel->getAllCategoriesDb_model(),
                'cat_new' => $this->pageModel->getAllCategoriesDb_new(),
                'subcat_new' => $this->pageModel->getAllsubCategoriesDb_new(),
                'color' => $this->pageModel->getAllcolorDb_new(),
                'size' => $this->pageModel->getAllsizeDb_new(),
                'all_mfg' => $this->pageModel->getallmfg(),

            ];
            $this->view('pages/item_by_category',$data);
        }
        
        public function item_by_category_with_qrcode()
        {
            if(isset($_SESSION['temp_print']))
            {
                redirect('pages/item_by_category');
                unset($_SESSION['temp_print']);
            }
            $data = [
                'cat' => $this->pageModel->getAllCategoriesDb(),
                'cat1' => $this->pageModel->getAllCategoriesDb2(),
                'cat2' => $this->pageModel->getAllCategoriesDb3(),
                'cat3' => $this->pageModel->getAllCategoriesDb4(),
                'type' => $this->pageModel->getAlltypeDb(),
                'model' => $this->pageModel->getAllCategoriesDb_model(),
                'cat_new' => $this->pageModel->getAllCategoriesDb_new(),
                'subcat_new' => $this->pageModel->getAllsubCategoriesDb_new(),
                'color' => $this->pageModel->getAllcolorDb_new(),
                'size' => $this->pageModel->getAllsizeDb_new(),
                'all_mfg' => $this->pageModel->getallmfg(),

            ];
            $this->view('pages/item_by_category_with_qrcode',$data);
        }
        
        public function customerwise_sales_report()
        {
            $data = [
                'cat' => $this->pageModel->getAllCategoriesDb(),
                'cat1' => $this->pageModel->getAllCategoriesDb2(),
                'cat2' => $this->pageModel->getAllCategoriesDb3(),
                'cat3' => $this->pageModel->getAllCategoriesDb4(),
                'type' => $this->pageModel->getAlltypeDb(),
                'model' => $this->pageModel->getAllCategoriesDb_model(),
                'cat_new' => $this->pageModel->getAllCategoriesDb_new(),
                'subcat_new' => $this->pageModel->getAllsubCategoriesDb_new(),
                'color' => $this->pageModel->getAllcolorDb_new(),
                'size' => $this->pageModel->getAllsizeDb_new(),
                'all_mfg' => $this->pageModel->getallmfg(),
                'dist_customer_id' => $this->pageModel->get_distinct_stock_out(),

            ];
            $this->view('pages/customerwise_sales_report',$data);
        }
         public function customerwise_sales_report_print()
        {
            $data = [
                'cat' => $this->pageModel->getAllCategoriesDb(),
                'cat1' => $this->pageModel->getAllCategoriesDb2(),
                'cat2' => $this->pageModel->getAllCategoriesDb3(),
                'cat3' => $this->pageModel->getAllCategoriesDb4(),
                'type' => $this->pageModel->getAlltypeDb(),
                'model' => $this->pageModel->getAllCategoriesDb_model(),
                'cat_new' => $this->pageModel->getAllCategoriesDb_new(),
                'subcat_new' => $this->pageModel->getAllsubCategoriesDb_new(),
                'color' => $this->pageModel->getAllcolorDb_new(),
                'size' => $this->pageModel->getAllsizeDb_new(),
                'all_mfg' => $this->pageModel->getallmfg(),
                'dist_customer_id' => $this->pageModel->get_distinct_stock_out(),

            ];
            $this->view('pages/customerwise_sales_report_print',$data);
        }
        public function customerwise_sales_report_with_token()
        {
            $data = [
                'cat' => $this->pageModel->getAllCategoriesDb(),
                'cat1' => $this->pageModel->getAllCategoriesDb2(),
                'cat2' => $this->pageModel->getAllCategoriesDb3(),
                'cat3' => $this->pageModel->getAllCategoriesDb4(),
                'type' => $this->pageModel->getAlltypeDb(),
                'model' => $this->pageModel->getAllCategoriesDb_model(),
                'cat_new' => $this->pageModel->getAllCategoriesDb_new(),
                'subcat_new' => $this->pageModel->getAllsubCategoriesDb_new(),
                'color' => $this->pageModel->getAllcolorDb_new(),
                'size' => $this->pageModel->getAllsizeDb_new(),
                'all_mfg' => $this->pageModel->getallmfg(),
                'dist_customer_id' => $this->pageModel->get_distinct_stock_out(),
            ];
            $this->view('pages/customerwise_sales_report_with_token',$data);
        }
        public function customerwise_sales_report_with_token_print()
        {
            $data = [
                'cat' => $this->pageModel->getAllCategoriesDb(),
                'cat1' => $this->pageModel->getAllCategoriesDb2(),
                'cat2' => $this->pageModel->getAllCategoriesDb3(),
                'cat3' => $this->pageModel->getAllCategoriesDb4(),
                'type' => $this->pageModel->getAlltypeDb(),
                'model' => $this->pageModel->getAllCategoriesDb_model(),
                'cat_new' => $this->pageModel->getAllCategoriesDb_new(),
                'subcat_new' => $this->pageModel->getAllsubCategoriesDb_new(),
                'color' => $this->pageModel->getAllcolorDb_new(),
                'size' => $this->pageModel->getAllsizeDb_new(),
                'all_mfg' => $this->pageModel->getallmfg(),
                'dist_customer_id' => $this->pageModel->get_distinct_stock_out(),
            ];
            $this->view('pages/customerwise_sales_report_with_token_print',$data);
        }
        public function customerwise_direct_package_report_with_token()
        {
            $data = [
                'cat' => $this->pageModel->getAllCategoriesDb(),
                'cat1' => $this->pageModel->getAllCategoriesDb2(),
                'cat2' => $this->pageModel->getAllCategoriesDb3(),
                'cat3' => $this->pageModel->getAllCategoriesDb4(),
                'type' => $this->pageModel->getAlltypeDb(),
                'model' => $this->pageModel->getAllCategoriesDb_model(),
                'cat_new' => $this->pageModel->getAllCategoriesDb_new(),
                'subcat_new' => $this->pageModel->getAllsubCategoriesDb_new(),
                'color' => $this->pageModel->getAllcolorDb_new(),
                'size' => $this->pageModel->getAllsizeDb_new(),
                'all_mfg' => $this->pageModel->getallmfg(),
                'dist_customer_id' => $this->pageModel->get_distinct_direct_package_out(),
            ];
            $this->view('pages/customerwise_direct_package_report_with_token',$data);
        }
        public function customerwise_direct_package_report_with_token_print()
        {
            $data = [
                'cat' => $this->pageModel->getAllCategoriesDb(),
                'cat1' => $this->pageModel->getAllCategoriesDb2(),
                'cat2' => $this->pageModel->getAllCategoriesDb3(),
                'cat3' => $this->pageModel->getAllCategoriesDb4(),
                'type' => $this->pageModel->getAlltypeDb(),
                'model' => $this->pageModel->getAllCategoriesDb_model(),
                'cat_new' => $this->pageModel->getAllCategoriesDb_new(),
                'subcat_new' => $this->pageModel->getAllsubCategoriesDb_new(),
                'color' => $this->pageModel->getAllcolorDb_new(),
                'size' => $this->pageModel->getAllsizeDb_new(),
                'all_mfg' => $this->pageModel->getallmfg(),
                'dist_customer_id' => $this->pageModel->get_distinct_direct_package_out(),
            ];
            $this->view('pages/customerwise_direct_package_report_with_token_print',$data);
        }
        public function customerwise_sales_reportp()
        {
            $data = [
                'cat' => $this->pageModel->getAllCategoriesDb(),
                'cat1' => $this->pageModel->getAllCategoriesDb2(),
                'cat2' => $this->pageModel->getAllCategoriesDb3(),
                'cat3' => $this->pageModel->getAllCategoriesDb4(),
                'type' => $this->pageModel->getAlltypeDb(),
                'model' => $this->pageModel->getAllCategoriesDb_model(),
                'cat_new' => $this->pageModel->getAllCategoriesDb_new(),
                'subcat_new' => $this->pageModel->getAllsubCategoriesDb_new(),
                'color' => $this->pageModel->getAllcolorDb_new(),
                'size' => $this->pageModel->getAllsizeDb_new(),
                'all_mfg' => $this->pageModel->getallmfg(),
                'dist_customer_id' => $this->pageModel->get_distinct_direct_package_out(),

            ];
            $this->view('pages/customerwise_sales_reportp',$data);
        }
        public function customerwise_sales_reportp_print()
        {
            $data = [
                'cat' => $this->pageModel->getAllCategoriesDb(),
                'cat1' => $this->pageModel->getAllCategoriesDb2(),
                'cat2' => $this->pageModel->getAllCategoriesDb3(),
                'cat3' => $this->pageModel->getAllCategoriesDb4(),
                'type' => $this->pageModel->getAlltypeDb(),
                'model' => $this->pageModel->getAllCategoriesDb_model(),
                'cat_new' => $this->pageModel->getAllCategoriesDb_new(),
                'subcat_new' => $this->pageModel->getAllsubCategoriesDb_new(),
                'color' => $this->pageModel->getAllcolorDb_new(),
                'size' => $this->pageModel->getAllsizeDb_new(),
                'all_mfg' => $this->pageModel->getallmfg(),
                'dist_customer_id' => $this->pageModel->get_distinct_direct_package_out(),
            ];
            $this->view('pages/customerwise_sales_reportp_print',$data);
        }
        
         public function print_items_by_category_wise()
        {
            $_SESSION['temp_print']=1;
            $category_id = $_POST['c1'];
            $subCategory = $_POST['s1'];
            $subCategory1 = $_POST['s2'];
            $subCategory2 = $_POST['s3'];
             if((!empty($category_id)) && (!empty($subCategory)) && (!empty($subCategory1)) && (!empty($subCategory2)))
             { 
                $allComp = $this->pageModel->get_all_category_wise_details1s($category_id,$subCategory,$subCategory1,$subCategory2);
            }
            elseif ((!empty($category_id)) && (!empty($subCategory)) && (!empty($subCategory1)) && (empty($subCategory2))) 
            {
                $allComp = $this->pageModel->get_all_category_wise_details2s($category_id,$subCategory,$subCategory1);
            }
            elseif ((!empty($category_id)) && (!empty($subCategory)) && (empty($subCategory1)) && (empty($subCategory2))) 
            {
                $allComp = $this->pageModel->get_all_category_wise_details3s($category_id,$subCategory);
            }
            
            elseif ((!empty($category_id)) && (empty($subCategory)) && (empty($subCategory1)) && (empty($subCategory2))) 
            {
                $allComp = $this->pageModel->get_all_category_wise_details4s($category_id);
                
            }
            else
            {
                $allComp = $this->pageModel->get_all_category_wise_details();
            }
            // if(empty($category_id)){ $c1 = ""; }else{ $c1 = $this->pageModel->getAlltypeDb_single($category_id);}
            // if(empty($subCategory)){ $s1 = ""; }else{ $s1 = $this->pageModel->getmodels_by_id($subCategory);}
            // if(empty($subCategory1)){ $s2 = ""; }else{ $s2 = $this->pageModel->getcategory_new_by_id($subCategory1);}
            // if(empty($subCategory2)){ $s3 = ""; }else{ $s3 = $this->pageModel->getsubcategory_new_by_id($subCategory2);}
            
            $data = [ 'all_it'=> $allComp,
                       
                    ];
            $this->view('pages/print_items',$data);
        }
        public function sales_return()
        {
            $this->view('pages/sales_return');
        }
        public function return_item($id)
        {
             $data = [
                    'sales' => $this->pageModel->getsalesDetails($id),
                    'so' => $this->pageModel->getsalesOrderDetails($id),
                    'rem_s_ord' => $this->pageModel->getsalesOrder_forpack($id),
                    'all_rem_s_ord' => $this->pageModel->getsalesOrder_forpack_all($id)
            ];
            $this->view('pages/return_item',$data);
        }
        public function purchase_order_details1($id)
        {
            $data=[ 
                'p_details'=>$this->pageModel->get_all_purchase_order_details($id),
                'id' => $id,
             ];
            $this->view('pages/purchase_order_details',$data);
        }
        public function all_non_purchase_order()
        {
            $data = [ 'non_purchase'=>$this->pageModel->get_all_non_purchase(),
                    ];
            $this->view('pages/all_non_purchase_order',$data);
        }
        public function print_qr()
        {
            $data = [
                'positions' => $this->pageModel->getAllPOsitionsForReceive(),
            ];
            $this->view('pages/print_qr', $data);
        }
        public function print_item_qr()
        {
            $ids = array();
            $itemid = $_POST['item_id'];
            $qty = $_POST['qty'];
            $temp_qr_id = $_POST['temp_qr_id'];
            $typeq = $_POST['typeq'];
             if($typeq==0)
            {
                $typeq = 'C';
            }elseif($typeq==1)
            {
                $typeq = 'B';
            }
            else
            {
                $typeq = 'P';
            }
            $it = $this->pageModel->get_single_item($itemid);

            $x = $this->pageModel->get_selected_stock($temp_qr_id);

            foreach ($x as $key)
            {
                $ids[] = $_SESSION['db_code'].$key->id;
            }
            $ids = implode('|', $ids);
            if(empty($it->color_id))
            {
                $color = "Nil";
            }
            else
            {
                $color = $this->pageModel->get_color($it->color_id);
                if(empty($color))
                {
                    $color = "Nil";
                }
                else
                {
                    $color = $color->color_name;  
                }
            }

            if(empty($it->size_id))
            {
                $size = 'Nil';
            }
            else
            {
                $size = $this->pageModel->get_size($it->size_id);
                if(empty($size))
                {
                    $size = 'Nil';
                }
                else
                {
                    $size = $size->size_name; 
                }
            }
            if(empty($it->dimension))
            {
                $dimension = 'Nil';
            }
            else
            {
                $length = explode("x", $it->dimension);
                $length = $length[0];
            }
            if($it->type_id == 4)
            {
                echo "https://medhike.com/rituhospital/b/barcode/index.php?ids=".$ids."&color=".$color."&size=".$size."&length=".$length."&type=".$typeq."";
            }
            else
            {
                if(empty($it->part_no))
                {
                    $length = "Nil";
                }else
                {
                    $length = $it->part_no;
                }
                if(empty($it->type_id))
                {
                    $color = "Nil";
                }else
                {

                    $tty = $this->pageModel->get_type_name_by_id($it->type_id);
                    if(empty($tty))
                    {
                        $color = "Nil";
                    }else
                    {
                        $color = $tty->type_name;
                    }
                }
                
                echo "https://medhike.com/rituhospital/b/barcode/index.php?ids=".$ids."&color=".$color."&size=".$size."&length=".$length."&type=".$typeq."";
            }
            
           
        }
         public function print_item_qr_sm()
        {
            $ids = array();
            $itemid = $_POST['item_id'];
            $qty = $_POST['qty'];
            $temp_qr_id = $_POST['temp_qr_id'];
            $typeq = $_POST['typeq'];
            if($typeq==0)
            {
                $typeq = 'C';
            }
            elseif($typeq==1)
            {
                $typeq = 'B';
            }
            else
            {
                $typeq = 'P';
            }
            $it = $this->pageModel->get_single_item($itemid);

            $x = $this->pageModel->get_selected_stock($temp_qr_id);

            foreach ($x as $key)
            {
                $ids[] = $_SESSION['db_code'].$key->id;
            }
            $ids = implode('|', $ids);
            if(empty($it->color_id))
            {
                $color = "Nil";
            }
            else
            {
                $color = $this->pageModel->get_color($it->color_id);
                if(empty($color))
                {
                    $color = "Nil";
                }
                else
                {
                    $color = $color->color_name;  
                }
            }

            if(empty($it->size_id))
            {
                $size = 'Nil';
            }
            else
            {
                $size = $this->pageModel->get_size($it->size_id);
                if(empty($size))
                {
                    $size = 'Nil';
                }
                else
                {
                    $size = $size->size_name; 
                }
            }
            if(empty($it->dimension))
            {
                $dimension = 'Nil';
            }
            else
            {
                $length = explode("x", $it->dimension);
                $length = $length[0];
            }
            if($it->type_id == 4)
            {
                echo "https://medhike.com/rituhospital/b/barcode/indexsm.php?ids=".$ids."&color=".$color."&size=".$size."&length=".$length."&type=".$typeq."";
            }
            else
            {
                if(empty($it->part_no))
                {
                    $length = "Nil";
                }else
                {
                    $length = $it->part_no;
                }
                if(empty($it->type_id))
                {
                    $color = "Nil";
                }else
                {

                    $tty = $this->pageModel->get_type_name_by_id($it->type_id);
                    if(empty($tty))
                    {
                        $color = "Nil";
                    }else
                    {
                        $color = $tty->type_name;
                    }
                }
                
                echo "https://medhike.com/rituhospital/b/barcode/indexsm.php?ids=".$ids."&color=".$color."&size=".$size."&length=".$length."&type=".$typeq."";
            }
            
           
        }
        public function print_item_qr_all()
        {
            $a_temp = array();
            $tt_temp=0;
            $tt_temp = (int)trim($_POST['temp_qr_print_all']);
            $all_qr = $this->pageModel->get_selected_nonpurchase_print_qr_all_at_once($tt_temp);
            foreach ($all_qr as $w) 
            {
                $ids = array();
                $itemid = $w->item_id;
                $qty = $w->qty_receive;
                $temp_qr_id = $w->non_purchase_id_temp;
                $typeq = $w->receivable;
                 if($typeq==0)
                {
                    $typeq = 'C';
                }
                elseif($typeq==1)
                {
                    $typeq = 'B';
                }
                else
                {
                    $typeq = 'P';
                }
                $it = $this->pageModel->get_single_item($itemid);

                $x = $this->pageModel->get_selected_stock($temp_qr_id);

                foreach ($x as $key)
                {
                    $ids[] = $_SESSION['db_code'].$key->id;
                }
                $ids = implode('|', $ids);
                if(empty($it->color_id))
                {
                    $color = "Nil";
                }
                else
                {
                    $color = $this->pageModel->get_color($it->color_id);
                    if(empty($color))
                    {
                        $color = "Nil";
                    }
                    else
                    {
                        $color = $color->color_name;  
                    }
                }

                if(empty($it->size_id))
                {
                    $size = 'Nil';
                }
                else
                {
                    $size = $this->pageModel->get_size($it->size_id);
                    if(empty($size))
                    {
                        $size = 'Nil';
                    }
                    else
                    {
                        $size = $size->size_name; 
                    }
                }
                if(empty($it->dimension))
                {
                    $dimension = 'Nil';
                }
                else
                {
                    $length = explode("x", $it->dimension);
                    $length = $length[0];
                }
                if($it->type_id == 4)
                {
                    // echo "https://medhike.com/rituhospital/b/barcode/index.php?ids=".$ids."&color=".$color."&size=".$size."&length=".$length."&type=".$typeq."";
                    $a_temp[] = $ids."||".$color."||".$size."||".$length."||".$typeq;
                }
                else
                {
                    if(empty($it->part_no))
                    {
                        $length = "Nil";
                    }else
                    {
                        $length = $it->part_no;
                    }
                    if(empty($it->type_id))
                    {
                        $color = "Nil";
                    }else
                    {

                        $tty = $this->pageModel->get_type_name_by_id($it->type_id);
                        if(empty($tty))
                        {
                            $color = "Nil";
                        }else
                        {
                            $color = $tty->type_name;
                        }
                    }
                    // echo "https://medhike.com/rituhospital/b/barcode/index.php?ids=".$ids."&color=".$color."&size=".$size."&length=".$length."&type=".$typeq."";
                    $a_temp[] = $ids."||".$color."||".$size."||".$length."||".$typeq;
                }
            }
            $a_temp = implode("|||", $a_temp);
            echo "https://medhike.com/rituhospital/b/barcode/index1.php?ids=".$a_temp."";
            
        }
         public function print_item_qr1()
        {
            $ids = array();
            $itemid = $_POST['item_id'];
            // $qty = $_POST['qty'];
            $temp_qr_id = $_POST['temp_qr_id'];
            $it = $this->pageModel->get_single_item($itemid);
            $npd = $this->pageModel->get_single_non_purchase($temp_qr_id);

            if($npd->receivable==0){ $npd ="C"; }elseif($npd->receivable==1){  $npd = "B"; }else{  $npd = "P"; }
           
            $x = $this->pageModel->get_selected_stock($temp_qr_id);

            foreach ($x as $key)
            {
                $ids[] = $_SESSION['db_code'].$key->id;
            }
            $ids = implode('|', $ids);
            if(empty($it->color_id))
            {
                $color = "Nil";
            }
            else
            {
                $color = $this->pageModel->get_color($it->color_id);
                if(empty($color))
                {
                    $color = "Nil";
                }
                else
                {
                    $color = $color->color_name;  
                }
            }
            if(empty($it->size_id))
            {
                $size = 'Nil';
            }
            else
            {
                $size = $this->pageModel->get_size($it->size_id);
                if(empty($size))
                {
                    $size = 'Nil';
                }
                else
                {
                    $size = $size->size_name; 
                }
            }
            if(empty($it->dimension))
            {
                $dimension = 'Nil';
            }
            else
            {
                $length = explode("x", $it->dimension);
                $length = $length[0];
            }
            if($it->type_id == 4)
            {
                echo "https://medhike.com/rituhospital/b/barcode/index.php?ids=".$ids."&color=".$color."&size=".$size."&length=".$length."&type=".$npd."";
            }
            else
            {
                if(empty($it->part_no))
                {
                    $length = "Nil";
                }else
                {
                    $length = $it->part_no;
                }
                if(empty($it->type_id))
                {
                    $color = "Nil";
                }else
                {

                    $tty = $this->pageModel->get_type_name_by_id($it->type_id);
                    if(empty($tty))
                    {
                        $color = "Nil";
                    }else
                    {
                        $color = $tty->type_name;
                    }
                }
                echo "https://medhike.com/rituhospital/b/barcode/index.php?ids=".$ids."&color=".$color."&size=".$size."&length=".$length."&type=".$npd."";
            }
        }
         public function print_item_qr1_sm()
        {
            $ids = array();
            $itemid = $_POST['item_id'];
            // $qty = $_POST['qty'];
            $temp_qr_id = $_POST['temp_qr_id'];
            $it = $this->pageModel->get_single_item($itemid);
            $npd = $this->pageModel->get_single_non_purchase($temp_qr_id);

            if($npd->receivable==0){  $npd = "C"; }elseif( $npd->receivable==0){  $npd = "B"; }else{  $npd = "P"; }
           
            $x = $this->pageModel->get_selected_stock($temp_qr_id);

            foreach ($x as $key)
            {
                $ids[] = $_SESSION['db_code'].$key->id;
            }
            $ids = implode('|', $ids);
            if(empty($it->color_id))
            {
                $color = "Nil";
            }
            else
            {
                $color = $this->pageModel->get_color($it->color_id);
                if(empty($color))
                {
                    $color = "Nil";
                }
                else
                {
                    $color = $color->color_name;  
                }
            }
            if(empty($it->size_id))
            {
                $size = 'Nil';
            }
            else
            {
                $size = $this->pageModel->get_size($it->size_id);
                if(empty($size))
                {
                    $size = 'Nil';
                }
                else
                {
                    $size = $size->size_name; 
                }
            }
            if(empty($it->dimension))
            {
                $dimension = 'Nil';
            }
            else
            {
                $length = explode("x", $it->dimension);
                $length = $length[0];
            }
            if($it->type_id == 4)
            {
                echo "https://medhike.com/rituhospital/b/barcode/indexsm.php?ids=".$ids."&color=".$color."&size=".$size."&length=".$length."&type=".$npd."";
            }
            else
            {
                if(empty($it->part_no))
                {
                    $length = "Nil";
                }else
                {
                    $length = $it->part_no;
                }
                if(empty($it->type_id))
                {
                    $color = "Nil";
                }else
                {

                    $tty = $this->pageModel->get_type_name_by_id($it->type_id);
                    if(empty($tty))
                    {
                        $color = "Nil";
                    }else
                    {
                        $color = $tty->type_name;
                    }
                }
                echo "https://medhike.com/rituhospital/b/barcode/indexsm.php?ids=".$ids."&color=".$color."&size=".$size."&length=".$length."&type=".$npd."";
            }
        }
        public function print_item_qr3($dt)
        {
            $dt = explode('|', $dt);
            $receive_item_id = $dt[0];
            $item_idd = $dt[1]; 
            $temp_for_qr = $dt[2];

            $ids = array();
            $itemid = $item_idd;
            // $qty = $_POST['qty'];
            $temp_qr_id = $temp_for_qr;
            $it = $this->pageModel->get_single_item($itemid);
            // $npd = $this->pageModel->get_single_non_purchase($temp_qr_id);

            $npd ='B';
           
            $x = $this->pageModel->get_selected_stock($temp_qr_id);

            foreach ($x as $key)
            {
                $ids[] = $_SESSION['db_code'].$key->id;
            }
            $ids = implode('|', $ids);
            if(empty($it->color_id))
            {
                $color = "Nil";
            }
            else
            {
                $color = $this->pageModel->get_color($it->color_id);
                if(empty($color))
                {
                    $color = "Nil";
                }
                else
                {
                    $color = $color->color_name;  
                }
            }

            if(empty($it->size_id))
            {
                $size = 'Nil';
            }
            else
            {
                $size = $this->pageModel->get_size($it->size_id);
                if(empty($size))
                {
                    $size = 'Nil';
                }
                else
                {
                    $size = $size->size_name; 
                }
            }
            $length ="";
            if(empty($it->dimension))
            {
                $dimension = 'Nil';
            }
            else
            {
                $length = explode("x", $it->dimension);
                $length = $length[0];
            }
            
            echo "https://medhike.com/rituhospital/b/barcode/index.php?ids=".$ids."&color=".$color."&size=".$size."&length=".$length."&type=".$npd."";
            // "<a href='https://medhike.com/rituhospital/b/barcode/index.php?ids=".$ids."&color=".$color."&size=".$size."&length=".$length."&type=".$npd."' class='btn btn-primary'><i class='ion ion-ios-browsers'></i></a>" ;
           
        }
        public function print_item_qr2()
        {
            $ids = array();
            $itemid = $_POST['item_id'];
            // $qty = $_POST['qty'];
            $temp_qr_id = $_POST['temp_qr_id'];
            $it = $this->pageModel->get_single_item($itemid);

            $x = $this->pageModel->get_selected_stock1($temp_qr_id);

            foreach ($x as $key)
            {
                $ids[] = $_SESSION['db_code'].$key->id;
            }
            $ids = implode('|', $ids);
            if(empty($it->color_id))
            {
                $color = "Nil";
            }
            else
            {
                $color = $this->pageModel->get_color($it->color_id);
                if(empty($color))
                {
                    $color = "Nil";
                }
                else
                {
                    $color = $color->color_name;  
                }
            }

            if(empty($it->size_id))
            {
                $size = 'Nil';
            }
            else
            {
                $size = $this->pageModel->get_size($it->size_id);
                if(empty($size))
                {
                    $size = 'Nil';
                }
                else
                {
                    $size = $size->size_name; 
                }
            }
            
            if(empty($it->dimension))
            {
                $dimension = 'Nil';
            }
            else
            {
                $length = explode("x", $it->dimension);
                $length = $length[0];
            }
            
            echo "https://medhike.com/rituhospital/b/barcode/index.php?ids=".$ids."&color=".$color."&size=".$size."&length=".$length."";
           
        }
        public function jump()
        {
             if(isset($_SESSION['jump']))
            {
                redirect('pages/non_purchase');
                unset($_SESSION['jump']);
            }
        }
        public function allstock()
        {
            $lim = $_POST['lim'];
            $lim = (int)$lim;
            if ($lim == 9) {
                $off = $_POST['off'];
                $off = (int)$off;
                $allCategory = $this->pageModel->get_all_s_stock($lim, $off);
            } else {
                $inc = $_POST['inc'];
                $inc = (int)$inc;
                $lim = 9;
                $off = 9 + (9 * $inc);
                $allCategory = $this->pageModel->get_all_s_stock($lim, $off);
            }
            $output = "";
            $post = new Page();
            foreach ($allCategory as $k) {
                $a =0;
                $s_stock = $post->get_single_stock($k->id);
                foreach ($s_stock as $kw) 
                {
                $a = $a + $kw->stock_total_receive;     
                }
                $type_id = $post->get_type_name_by_id($k->type_id);
                if(empty($type_id)){ $type_id = "--";}else{ $type_id = $type_id->type_name; }
                $model_id = $post->get_model_name_by_id($k->model_id);
                if(empty($model_id)){ $model_id = "--";}else{ $model_id = $model_id->model_name; }
                $category_new_id = $post->get_category_name_by_id($k->category_new_id);
                 if(empty($category_new_id)){ $category_new_id = "--";}else{ $category_new_id = $category_new_id->category_name; }
                $subcategory_new_id = $post->get_subcategory_name_by_id($k->subcategory_new_id);
                if(empty($subcategory_new_id)){ $subcategory_new_id = "--";}else{ $subcategory_new_id = $subcategory_new_id->sc_name; }

                $dt = date("d-m-Y h:i:s a", strtotime($k->created_at));
            $output .= '<tr>
                <td scope="row">'.$k->id.'</td>
                <td><img src="'.URLROOT.'/uploads/'.$k->img.'" class="img-fluid" width="35" alt="item"></td>
                <td>'.$k->name.'</td>
                <td>'.$type_id.'</td>
                <td>'.$model_id.'</td>
                <td>'.$category_new_id.'</td>
                <td>'.$subcategory_new_id.'</td>
                <td>'.$k->selling_price.'</td>
                <td>'.$a.'</td>
                <td>
                    <div class="row">
                        <a href="'.URLROOT.'/pages/item_description/'.$k->id.'" class="btn btn-primary"><i class="ion ion-ios-browsers"></i></a>
                        &nbsp;
                        <a href="'.URLROOT.'/pages/edititem/'.$k->id.'" class="btn btn-success-rgba"><i class="ri-pencil-line"></i></a>
                         &nbsp;
                        <a href="'.URLROOT.'/pages/item_delete/'.$k->id.'" class="btn btn-danger-rgba"><i class="dripicons-archive"></i></a>

                    </div>
                </td>
            </tr>';
            }
            echo $output;
        }
        public function stock_out()
        {
               $this->pageModel->clear_temp_stockout_db();
               $customer = $this->pageModel->get_all_customers();
               $details = $this->pageModel->getdetails();
                    $data = [
                        'stockdetails' =>  $details,   
                        'customer' => $customer,
                        'all_items' => $this->pageModel->get_all_items_for_dropdown(),
                        'cat' => $this->pageModel->getAllCategoriesDb(),
                        'cat1' => $this->pageModel->getAllCategoriesDb2(),
                        'cat2' => $this->pageModel->getAllCategoriesDb3(),
                        'cat3' => $this->pageModel->getAllCategoriesDb4(),
                        'type' => $this->pageModel->getAlltypeDb(),
                        'model' => $this->pageModel->getAllCategoriesDb_model(),
                        'cat_new' => $this->pageModel->getAllCategoriesDb_new(),
                        'subcat_new' => $this->pageModel->getAllsubCategoriesDb_new(),
                        'color' => $this->pageModel->getAllcolorDb_new(),
                        'size' => $this->pageModel->getAllsizeDb_new(),
                        'all_mfg' => $this->pageModel->getallmfg(),                 
                           ];     
             $this->view('pages/stock_out',$data);
        }
         public function stock_out_with_out_package()
        {
               $details = $this->pageModel->getdetails();
                    $data = [
                        'stockdetails' =>  $details,   
                        'customer' =>$this->pageModel->get_all_customers()                 
                           ];     
             $this->view('pages/stock_out_with_out_package',$data);
        }
        public function getAllItem()
        {
            $row = $this->pageModel->getdetails();
            $output = '<select class="select2-single form-control">';
            foreach ($row as $key)
            {
                $output .= '<option value="'.$key->id.'">'.$key->name.'</option>';
            }
            $output .= '</select>';
            echo $output;
        }
        public function getscaneditemsAllStock_out()
        {
            $temp_scan = $this->pageModel->get_all_temp_scan();
            $output = "";
            foreach ($temp_scan as $k) 
            {
                $output .= '<tr>
                <td scope="row">'.$k->item_id.'</td>
                <td>'.$k->stock_id.'</td>
                <td>'.$k->item_name.'</td>
                <td class="text-success">'.$k->qty.'</td>
                <td>'.$k->type.'</td>
                <td>'.$k->barcode.'</td>
                </tr>';
            }
            echo $output;
        }
         public function getscaneditemsAllsalesorder()
        {
            $temp_scan1 = $this->pageModel->get_all_temp_scan1();
            $output = "";
            foreach ($temp_scan1 as $k) 
            {
                $output .= '<tr>
                <td scope="row">'.$k->item_id.'</td>
                <td>'.$k->stock_id.'</td>
                <td>'.$k->item_name.'</td>
                <td class="text-success">'.$k->qty.'</td>
                <td>'.$k->type.'</td>
                <td>'.$k->barcode.'</td>
                </tr>';
            }
            echo $output;
        }
        public function addbarcodeto()
        {
            $l = $_POST['barcode'];
            $stockoutid = $_POST['stockoutid'];

            $temp1 =  substr($l,0,3);
            if($temp1 == 'EG'.$_SESSION["db_code"].'')
            {
                $l = explode("EG".$_SESSION['db_code']."", $l);
                $l = $l[1];
            }
            else
            {
                $l = explode("EG", $l);
                $l = $l[1];
            }
            $so = $this->pageModel->get_stockoutid_from_id($stockoutid);
            $sp = $this->pageModel->stock_out_package_qty($stockoutid);
            $item_id = explode("|||", $so->item_id);
            $item_name = explode("|||", $so->item_name);
            $item_qty = explode("|||", $so->item_qty);
            $item_rec = explode("|||", $so->item_rec);
            if(!empty($sp))
            {
                $item_to_pack = explode("|||", $sp->item_to_pack);
            }
            $output='';
            $flag=0;
            $flag1=0;
            $output_item_id=0;
            $flag3=0;
            $flag4=0;
            for ($i=0; $i <sizeof($item_id); $i++) 
            { 
                // $item_rec[$i];
                $x = $this->pageModel->get_stock_from_id($l);
                $receivable='';
                if(empty($x))
                {
                     $output .= "|Item is not in stock";
                }
                elseif($x->stock_on_hand==0)
                {
                    $output .= "|Item is unboxed";
                }
                else
                {
                    $count = $this->pageModel->get_temp_scan_count_qty($item_id[$i]);
                    $count++;
                     if($x->receivable==0)
                    {
                        $receivable="Carton";
                    }
                    elseif($x->receivable==1)
                    {
                        $receivable="Box";
                    }
                    else
                    {
                        $receivable="Pieces";
                    }
                        if($x->item_id == $item_id[$i] AND $x->receivable==$item_rec[$i])
                        {
                            
                                if(empty($sp))
                                {
                                    if($item_qty[$i]>=$count)
                                    {
                                        $rs = $this->pageModel->check_tem_scan_item($l);
                                        if(empty($rs))
                                        {
                                            $this->pageModel->add_barcode_to_db($item_id[$i],$item_name[$i],$l,$receivable);
                                            
                                            $flag1 = 1;
                                            $output_item_id = $x->item_id."|".$x->receivable;
                                        }
                                        else
                                        {
                                            $flag3 =1;
                                        }
                                    }
                                    else
                                    {
                                        $flag4 =1;
                                    }
                                }
                                else
                                {
                                    
                                   if($item_to_pack[$i]>=$count)
                                    {
                                        $rs = $this->pageModel->check_tem_scan_item($l);
                                        if(empty($rs))
                                        {
                                            $this->pageModel->add_barcode_to_db($item_id[$i],$item_name[$i],$l,$receivable);
                                            
                                            $flag1 = 1;
                                            $output_item_id = $x->item_id."|".$x->receivable;
                                        }
                                        else
                                        {
                                            $flag3 =1;
                                        }
                                    }
                                    else
                                    {
                                        $flag4 =1;
                                    } 
                                } 
                            
                           
                        }
                        else
                        {
                            $flag =1;
                        }  
                }
                
            }
            if($output_item_id==0)
            {
                $output_item_id=0;
            }
            else
            {
                $output .= $output_item_id;
            }

            if($flag1==1)
            {
                $output .= "|Item Added"; 
            }
            elseif ($flag==1) 
            {
                if($flag3==1)
                {   
                   $output .= "|Quantity Completed";     
                }
                elseif($flag4==1)
                {
                    $output .= "|Already Added";
                }
                else
                {
                     $output .= "|Item is not in packed list";
                }
            }
            else
            {
                $output .= "";
            }

              echo $output;

        }
        public function addbarcodetosalesorder()
        {
            $l = $_POST['barcode'];
            $sales_order = $_POST['sales_order'];
            $l = explode("EG".$_SESSION['db_code']."", $l);
            $l = $l[1];
            $so = $this->pageModel->get_salesorder_from_id($sales_order);
            $item_id = explode("|||", $so->item_id);
            $item_name = explode("|||", $so->item_name);
            $item_qty = explode("|||", $so->item_qty);
            $output='';
            $flag=0;
            $flag1=0;
            $output_item_id=0;
            $flag3=0;
            $flag4=0;
            for ($i=0; $i <sizeof($item_id); $i++) 
            { 
                $x = $this->pageModel->get_stock_from_id($l);
                $receivable='';
                if(empty($x))
                {
                     $output .= "|Item is not in stock";
                }
                else
                {
                    $count = $this->pageModel->get_temp_scan1_count_qty($item_id[$i]);
                    $count++;
                    if($x->receivable==1)
                    {
                        $receivable="Box";
                    }
                    else
                    {
                        $receivable="Pieces";
                    }
                    if($x->item_id == $item_id[$i])
                    {
                        if($item_qty[$i]>=$count)
                        {
                            $rs = $this->pageModel->check_tem_scan1_item($l);
                            if(empty($rs))
                            {
                                $this->pageModel->add_barcode_to_db1($item_id[$i],$item_name[$i],$l,$receivable);
                                
                                $flag1 = 1;
                                $output_item_id=$x->item_id;
                            }
                            else
                            {
                                $flag3 =1;
                            }
                        }
                        else
                        {
                            $flag4 =1;
                        }
                    }
                    else
                    {
                        // $output_item_id = 0;
                        $flag =1;
                    }
                }
                
            }
            if($output_item_id==0)
            {
                $output_item_id=0;
            }
            else
            {
                $output .= $output_item_id;
            }

            if($flag1==1)
            {
                $output .= "|Item Added"; 
            }
            elseif ($flag==1) 
            {
                if($flag3==1)
                {   
                   $output .= "|Quantity Completed";     
                }
                elseif($flag4==1)
                {
                    $output .= "|Already Added";
                }
                else
                {
                     $output .= "|Item is not in packed list";
                }
            }
            else
            {
                $output .= "";
            }

            echo $output;

        }
        public function print_item_qr_for_cartoon_to_box()
        {

            $ids = array();
            $boxstockid = $_POST['boxstockid'];
            $sall = $this->pageModel->get_selected_stock_for_pieces($boxstockid);
            foreach ($sall as $x) 
            {
                $it = $this->pageModel->get_single_item($x->item_id);
                $ids[] = $_SESSION['db_code'].$x->id;
            }    
            $ids = implode('|', $ids);
            if(empty($it->color_id))
            {
                $color = "Nil";
            }
            else
            {
                $color = $this->pageModel->get_color($it->color_id);
                if(empty($color))
                {
                    $color = "Nil";
                }
                else
                {
                    $color = $color->color_name;  
                }
            }

            if(empty($it->size_id))
            {
                $size = 'Nil';
            }
            else
            {
                $size = $this->pageModel->get_size($it->size_id);
                if(empty($size))
                {
                    $size = 'Nil';
                }
                else
                {
                    $size = $size->size_name; 
                }
            }
            
            if(empty($it->dimension))
            {
                $dimension = 'Nil';
            }
            else
            {
                $length = explode("x", $it->dimension);
                $length = $length[0];
            }

            if($it->type_id == 4)
            {
                echo "https://medhike.com/rituhospital/b/barcode/index.php?ids=".$ids."&color=".$color."&size=".$size."&length=".$length."&type=B";
            }
            else
            {
                if(empty($it->part_no))
                {
                    $length = "Nil";
                }else
                {
                    $length = $it->part_no;
                }

                if(empty($it->type_id))
                {
                    $color = "Nil";
                }else
                {

                    $tty = $this->pageModel->get_type_name_by_id($it->type_id);
                    if(empty($tty))
                    {
                        $color = "Nil";
                    }else
                    {
                        $color = $tty->type_name;
                    }
                }
                echo "https://medhike.com/rituhospital/b/barcode/index.php?ids=".$ids."&color=".$color."&size=".$size."&length=".$length."&type=B";
            }
        }
        public function print_item_qr_for_carton_to_box_sm()
        {

            $ids = array();
            $boxstockid = $_POST['boxstockid'];
            $sall = $this->pageModel->get_selected_stock_for_pieces($boxstockid);
            foreach ($sall as $x) 
            {
                $it = $this->pageModel->get_single_item($x->item_id);
                $ids[] = $_SESSION['db_code'].$x->id;
            }    
            $ids = implode('|', $ids);
            if(empty($it->color_id))
            {
                $color = "Nil";
            }
            else
            {
                $color = $this->pageModel->get_color($it->color_id);
                if(empty($color))
                {
                    $color = "Nil";
                }
                else
                {
                    $color = $color->color_name;  
                }
            }

            if(empty($it->size_id))
            {
                $size = 'Nil';
            }
            else
            {
                $size = $this->pageModel->get_size($it->size_id);
                if(empty($size))
                {
                    $size = 'Nil';
                }
                else
                {
                    $size = $size->size_name; 
                }
            }
            
            if(empty($it->dimension))
            {
                $dimension = 'Nil';
            }
            else
            {
                $length = explode("x", $it->dimension);
                $length = $length[0];
            }

            if($it->type_id == 4)
            {
                echo "https://medhike.com/rituhospital/b/barcode/indexsm.php?ids=".$ids."&color=".$color."&size=".$size."&length=".$length."&type=B";
            }
            else
            {
                if(empty($it->model_id))
                {
                    $length = "Nil";
                }else
                {
                    $mm = $this->pageModel->get_model_by_id_single($it->model_id);
                    
                    if(empty($mm))
                    {
                        $length = "Nil";
                    }
                    else
                    {
                        $length = $mm->model_name;
                    }
                }
                if(empty($it->type_id))
                {
                    $color = "Nil";
                }else
                {

                    $tty = $this->pageModel->get_type_name_by_id($it->type_id);
                    if(empty($tty))
                    {
                        $color = "Nil";
                    }else
                    {
                        $color = $tty->type_name;
                    }
                }
                echo "https://medhike.com/rituhospital/b/barcode/indexsm.php?ids=".$ids."&color=".$color."&size=".$size."&length=".$length."&type=B";
            }

            
           

        }
        public function print_item_qr_for_single_pieces()
        {

            $ids = array();
            $boxstockid = $_POST['boxstockid'];
            $sall = $this->pageModel->get_selected_stock_for_pieces($boxstockid);
            foreach ($sall as $x) 
            {
                $it = $this->pageModel->get_single_item($x->item_id);
                $ids[] = $_SESSION['db_code'].$x->id;
                $receivable = $x->receivable;
            }    
            $ids = implode('|', $ids);
            if($receivable==0)
            {
                $receivable = 'C';
            }elseif($receivable==1)
            {
                $receivable = 'B';
            }else
            {
                $receivable = 'P';
            }
            if(empty($it->color_id))
            {
                $color = "Nil";
            }
            else
            {
                $color = $this->pageModel->get_color($it->color_id);
                if(empty($color))
                {
                    $color = "Nil";
                }
                else
                {
                    $color = $color->color_name;  
                }
            }

            if(empty($it->size_id))
            {
                $size = 'Nil';
            }
            else
            {
                $size = $this->pageModel->get_size($it->size_id);
                if(empty($size))
                {
                    $size = 'Nil';
                }
                else
                {
                    $size = $size->size_name; 
                }
            }
            
            if(empty($it->dimension))
            {
                $dimension = 'Nil';
            }
            else
            {
                $length = explode("x", $it->dimension);
                $length = $length[0];
            }

            if($it->type_id == 4)
            {
                echo "https://medhike.com/rituhospital/b/barcode/index.php?ids=".$ids."&color=".$color."&size=".$size."&length=".$length."&type=".$receivable."";
            }
            else
            {
                if(empty($it->part_no))
                {
                    $length = "Nil";
                }else
                {
                    $length = $it->part_no;
                }

                if(empty($it->type_id))
                {
                    $color = "Nil";
                }else
                {

                    $tty = $this->pageModel->get_type_name_by_id($it->type_id);
                    if(empty($tty))
                    {
                        $color = "Nil";
                    }else
                    {
                        $color = $tty->type_name;
                    }
                }
                echo "https://medhike.com/rituhospital/b/barcode/index.php?ids=".$ids."&color=".$color."&size=".$size."&length=".$length."&type=".$receivable."";
            }
        }
        public function print_item_qr_for_single_pieces_sm()
        {

            $ids = array();
            $boxstockid = $_POST['boxstockid'];
            $sall = $this->pageModel->get_selected_stock_for_pieces($boxstockid);
            foreach ($sall as $x) 
            {
                $it = $this->pageModel->get_single_item($x->item_id);
                $ids[] = $_SESSION['db_code'].$x->id;
                $receivable = $x->receivable;
            }    
            $ids = implode('|', $ids);
            if($receivable==0)
            {
                $receivable = 'C';
            }elseif($receivable==1)
            {
                $receivable = 'B';
            }else
            {
                $receivable = 'P';
            }
            if(empty($it->color_id))
            {
                $color = "Nil";
            }
            else
            {
                $color = $this->pageModel->get_color($it->color_id);
                if(empty($color))
                {
                    $color = "Nil";
                }
                else
                {
                    $color = $color->color_name;  
                }
            }

            if(empty($it->size_id))
            {
                $size = 'Nil';
            }
            else
            {
                $size = $this->pageModel->get_size($it->size_id);
                if(empty($size))
                {
                    $size = 'Nil';
                }
                else
                {
                    $size = $size->size_name; 
                }
            }
            
            if(empty($it->dimension))
            {
                $dimension = 'Nil';
            }
            else
            {
                $length = explode("x", $it->dimension);
                $length = $length[0];
            }

            if($it->type_id == 4)
            {
                echo "https://medhike.com/rituhospital/b/barcode/indexsm.php?ids=".$ids."&color=".$color."&size=".$size."&length=".$length."&type=".$receivable."";
            }
            else
            {
                if(empty($it->part_no))
                {
                    $length = "Nil";
                }else
                {
                    $length = $it->part_no;
                }
                if(empty($it->type_id))
                {
                    $color = "Nil";
                }else
                {

                    $tty = $this->pageModel->get_type_name_by_id($it->type_id);
                    if(empty($tty))
                    {
                        $color = "Nil";
                    }else
                    {
                        $color = $tty->type_name;
                    }
                }
                echo "https://medhike.com/rituhospital/b/barcode/indexsm.php?ids=".$ids."&color=".$color."&size=".$size."&length=".$length."&type=".$receivable."";
            }

            
           

        }
         public function checkqr()
        {
            $this->view('pages/checkqr');
        }
        public function scanQRforcheck()
        {
            $l = $_POST['barcode'];
            $temp =  substr($l,0,2);
            $output = '';
            if($temp == 'EG')
            {
                $temp1 =  substr($l,0,3);
                if($temp1 == 'EG'.$_SESSION["db_code"].'')
                {
                    $l = explode("EG".$_SESSION['db_code']."", $l);
                    $l = $l[1];
                }
                else
                {
                    $l = explode("EG", $l);
                    $l = $l[1];
                }
                $output='';
                $k = $this->pageModel->get_stock_from_id($l);
                if(!empty($k))
                {
                        $output = "";
                            $Page = new Page();
                            $item_name = $Page->getTheItemName($k->item_id);
                            if(empty($k->created_at))
                            {
                                $age =0;
                            }
                            else
                            {
                                $d = date('Y-m-d H:i:s');
                                $date1 = strtotime($k->created_at);  
                                $date2 = strtotime(date($d));  
                                $diff = abs($date2 - $date1); 
                                $years = floor($diff / (365*60*60*24));  
                                $months = floor(($diff - $years * 365*60*60*24) 
                                                            / (30*60*60*24));
                                $days = floor(($diff - $years * 365*60*60*24 -  
                                $months*30*60*60*24)/ (60*60*24));
                                $age =  "Day:".$days."<br>Month:".$months."<br>Year:".$years;
                            }
                            if($k->receivable==1)
                            {
                                $receivable = "Box";   
                            }
                            else
                            {
                                $receivable = "Pieces";
                            }
                            $output .= '<thead>
                                        <tr>
                                            <th>Stock ID</th>
                                            <th>Item ID</th>
                                            <th>Item Name</th>
                                            <th>Batch</th>
                                            <th>Position</th>
                                            <th>Received IN</th>
                                            <th>Received Date</th>
                                            <th>Item Age</th>
                                            <th colspan="2">Action</th>
                                            
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td scope="row">'.$k->id.'</td>
                                            <td>'.$k->item_id.'</td>
                                            <td>'. $item_name.'</td>
                                            <td>'. $k->batch.'</td>
                                            <td>'. $k->position.'</td>
                                            <td>'. $receivable.'</td>
                                            <td>'. $k->created_at.'</td>
                                            <td>'. $age.'</td><td>';
                                            if(empty($k->order_number))
                                            {
                                                if($k->receivable==1)
                                                {
                                                    if($k->stock_on_hand==1)
                                                    {
                                                        $output .='<a onclick="nonpurunbox('.$k->id.')" class="btn btn-primary text-white">Unbox</a>';
                                                        
                                                    }else
                                                    {
                                                        $output .='<a class="btn btn-info text-white"  onclick="generate_qr('.$k->id.')"><i class="fa fa-qrcode"></i></a>';
                                                        $output .='<a class="btn btn-secondary text-white"  onclick="generate_qrsm('.$k->id.')"><i class="fa fa-qrcode"></i></a>';
                                                    }
                                                }
                                            }
                                            else
                                            {
                                                if($k->receivable==1)
                                                {
                                                    if($k->stock_on_hand==1)
                                                    {
                                                        $output .='<a onclick="purunbox('.$k->id.')" class="btn btn-primary text-white">Unbox</a>';

                                                    }else
                                                    {
                                                        $output .='<a class="btn btn-info text-white"  onclick="generate_qr('.$k->id.')"><i class="fa fa-qrcode"></i></a>';
                                                         $output .='<a class="btn btn-secondary text-white"  onclick="generate_qrsm('.$k->id.')"><i class="fa fa-qrcode"></i></a>';
                                                    }
                                                }
                                            }
                            $output .= '</td><td><a href="'.URLROOT.'/pages/item_description/'.$k->item_id.'" class="btn btn-primary"><i class="ion ion-ios-browsers"></i></a>';
                            $output .= '</td></tr></tbody>';
                         
                }
                else
                {
                    $output .= "Not in stock";
                }
                echo $output;
            }
            elseif($temp == 'ST')
            {
                 $output='';
                $stock_out_id =0;
                $pack_id = 0;
                $l = $_POST['barcode'];
                $l = explode("ST", $l);
                $l = explode("P",$l[1]);
                $stock_out_id = $l[0];
                $pack_id = $l[1];
                $l = $stock_out_id;
                $k = $this->pageModel->get_scanqr_stockout($stock_out_id);
                if(!empty($k))
                {
                    $k1 = $this->pageModel->get_scanqr_stock_out_order($stock_out_id);
                    $item_id = explode('|||', $k1->item_id);
                    $item_name = explode('|||', $k1->item_name);
                    $item_qty = explode('|||', $k1->item_qty); 
                    $output .= '<thead>
                                    <tr>
                                        <th>Stock Out Id</th>
                                        <th>Customer Name</th>
                                        <th>Stock_Date</th>
                                        <th>Item Id</th>
                                        <th>Item Name</th>
                                        <th>Item Qty</th>
                                    </tr>
                                    </thead>
                                    <tbody>';
                                     for ($i=0; $i < sizeof($item_id); $i++) 
                                        { 
                                            $output.=' <tr>
                                                <td scope="row">'.$k->id.'</td>
                                                <td>'.$k->customer.'</td>
                                                <td>'. $k->stock_dt.'</td>
                                                <td>'. $item_id[$i].'</td>
                                                <td>'. $item_name[$i].'</td>
                                                <td>'. $item_qty[$i].'</td>
                                                </tr> ';
                                        }
                                     $output.=' </tbody>';
                     
                 }
                 else
                 {
                     $output .= "Wrong QR";
                 }
                echo $output; 
            }
            else
            {
                $output .= "Wrong QR";
                echo $output;
            }

        }
        public function convert_box_item_for_qr_check()
        {
            $id = $_POST['boxstockid'];
            $l = $this->pageModel->get_stock_from_id_temp_data_for_checkqr($id);
            $tq = $this->pageModel->get_single_item($l->item_id);
            $stock_id = $id;
            $stock_on_hand = $l->stock_on_hand;
            $item_qty = $tq->qty;
            $pieces = 1;
            $a =0;
            $a = $a + $pieces + $stock_on_hand;
            if($this->pageModel->update_stock_convert($id,$a,$item_qty,$pieces))
            {        
                echo "EG".$_SESSION['db_code'].$id;
            }
        }
         public function convert_box_item_purchase_check_qr()
        {
            $id = $_POST['boxstockid'];
            $l = $this->pageModel->get_stock_from_id_temp_data_for_checkqr($id);
            $tq = $this->pageModel->get_single_item($l->item_id); 
            $stock_id = $id;
            $stock_on_hand = $l->stock_on_hand;
            $item_qty = $tq->qty;
            $pieces = 1;
            $a =0;
            $a = $a + $pieces + $stock_on_hand;
            if($this->pageModel->update_stock_convert($id,$a,$item_qty,$pieces))
            {    
                echo "EG".$_SESSION["db_code"].$id;
            }
        }

        
        public function scanQRforcheck_direct()
        {
            $l = $_POST['barcode'];
            $l = explode("EG".$_SESSION['db_code']."", $l);
            $l = $l[1];
            $output='';
            $k = $this->pageModel->get_stock_from_id($l);
            $output = "";
                $Page = new Page();
                $item_name = $Page->getTheItemName($k->item_id);
                if(empty($k->created_at))
                {
                    $age =0;
                }
                else
                {
                    $d = date('Y-m-d H:i:s');
                    $date1 = strtotime($k->created_at);  
                    $date2 = strtotime(date($d));  
                    $diff = abs($date2 - $date1); 
                    $years = floor($diff / (365*60*60*24));  
                    $months = floor(($diff - $years * 365*60*60*24) 
                                                / (30*60*60*24));
                    $days = floor(($diff - $years * 365*60*60*24 -  
                    $months*30*60*60*24)/ (60*60*24));
                    $age =  "Day:".$days."<br>Month:".$months."<br>Year:".$years;
                }
                $output .= '<td>
                                <input type="text" name="product" placeholder="Enter Item Name" class="form-control" id="tags"autocomplete="off" />
                            </td>
                            <td><input type="number" name="qty" class="form-control" min="0" id="qty" value="" /></td>
                            <td>
                                <select name="rec" id="rec" class="form-control"required="true">
                                    <option value="" selected disabled>--select--</option>
                                    <option value="1">Box</option>
                                    <option value="3">Pieces</option>
                                </select>
                            </td>';
                $output .= '<td>'.$k->item_id.'</td>
                            <td>'. $item_name.'</td>
                            <td>'. $k->receivable.'</td>';
             echo $output;
            
        }
    public function item_by_category1()
    {
        if(isset($_SESSION['temp_print']))
        {
            redirect('pages/item_by_category');
            unset($_SESSION['temp_print']);
        }
        $data = [
            'cat' => $this->pageModel->getAllCategoriesDb(),
            'cat1' => $this->pageModel->getAllCategoriesDb2(),
            'cat2' => $this->pageModel->getAllCategoriesDb3(),
            'cat3' => $this->pageModel->getAllCategoriesDb4(),
            'type' => $this->pageModel->getAlltypeDb(),
            'model' => $this->pageModel->getAllCategoriesDb_model(),
            'cat_new' => $this->pageModel->getAllCategoriesDb_new(),
            'subcat_new' => $this->pageModel->getAllsubCategoriesDb_new(),
            'color' => $this->pageModel->getAllcolorDb_new(),
            'size' => $this->pageModel->getAllsizeDb_new(),
            'all_mfg' => $this->pageModel->getallmfg(),
        ];
        $this->view('pages/item_by_category1',$data);
    }
    public function by_allcategory_item_cat2()
    {
        $sort_id=$_POST['sort'];
        $category_id = $_POST['category_id'];
        $subCategory = $_POST['subCategory'];
        $subCategory1 = $_POST['subCategory1'];
        $subCategory2 = $_POST['subCategory2'];
         if((!empty($category_id)) && (!empty($subCategory)) && (!empty($subCategory1)) && (!empty($subCategory2)))
         {
            $allComp = $this->pageModel->get_all_category_wise_details11s($category_id,$subCategory,$subCategory1,$subCategory2,$sort_id);
        }
        elseif ((!empty($category_id)) && (!empty($subCategory)) && (!empty($subCategory1)) && (empty($subCategory2)))
        {
            $allComp = $this->pageModel->get_all_category_wise_details22s($category_id,$subCategory,$subCategory1,$sort_id);
        }
        elseif ((!empty($category_id)) && (!empty($subCategory)) && (empty($subCategory1)) && (empty($subCategory2)))
        {
            $allComp = $this->pageModel->get_all_category_wise_details33s($category_id,$subCategory,$sort_id);
        }
        elseif ((!empty($category_id)) && (empty($subCategory)) && (empty($subCategory1)) && (empty($subCategory2)))
        {
            $allComp = $this->pageModel->get_all_category_wise_details44s($category_id,$sort_id);
        }
        else
        {
            $allComp = $this->pageModel->get_all_category_wise_details1($sort_id);
        }
        $output = "";
        $sum=0;
        $post = new Page();
        foreach ($allComp as $k) {
            $created_at =0;
            $a =0;
            $s_stock = $post->get_single_stock($k->id);
             $da = '';
            foreach ($s_stock as $kw)
            {
                $a = $a + $kw->stock_total_receive;
                if(empty($kw->created_at))
                {
                     $created_at ='';
                     $da = '';
                }
                else
                {
                    $created_at = date('Y-m-d H:i:s', strtotime($kw->created_at));
                    // $created_at=$kw->created_at;
                    $d = date('Y-m-d H:i:s');
                    $date1 = strtotime($created_at);
                    $date2 = strtotime(date($d));
                    $diff = abs($date2 - $date1);
                    $years = floor($diff / (365*60*60*24));
                    $months = floor(($diff - $years * 365*60*60*24)
                                                / (30*60*60*24));
                    $days = floor(($diff - $years * 365*60*60*24 -
                    $months*30*60*60*24)/ (60*60*24));
                    $da = "Day:".$days."<br>Month:".$months."<br>Year:".$years;
                }
            }
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
            if(empty($size_id)){$size_id="--";}else{$size_id=$size_id->size_name;}
            $dt = date("d-m-Y h:i:s a", strtotime($k->created_at));
            $sum = $sum + $a;
            if($k->receive==0){ $rec ="Carton(Qty ".$k->carton_qty.")"; }elseif($k->receive==1){ $rec ="Box(Qty ".$k->qty.")"; }else{ $rec ="Pieces(Qty ".$k->qty.")";}
        $output .= '<tr>
            <td scope="row">'.$k->id.'</td>
            <td>'.$k->name.'</td>
            <td>'.$rec.'</td>
            <td>'.$type_id.'</td>
            <td>'.$model_id.'</td>
            <td>'.$category_new_id.'</td>
            <td>'.$subcategory_new_id.'</td>
            <td>'.$da.'</td>
            <td>'.$color_id.'</td>
            <td>'.$size_id.'</td>
        </tr>';
        }
        $_SESSION['sum'] = $sum;
        echo $output;
    }
     public function print_items_by_category_wise1()
    {
            $sort_id = $_POST['s4'];
        $_SESSION['temp_print']=1;
        $category_id = $_POST['c1'];
        $subCategory = $_POST['s1'];
        $subCategory1 = $_POST['s2'];
        $subCategory2 = $_POST['s3'];
         if((!empty($category_id)) && (!empty($subCategory)) && (!empty($subCategory1)) && (!empty($subCategory2)))
         {
            $allComp = $this->pageModel->get_all_category_wise_details011s($category_id,$subCategory,$subCategory1,$subCategory2,$sort_id);
        }
        elseif ((!empty($category_id)) && (!empty($subCategory)) && (!empty($subCategory1)) && (empty($subCategory2)))
        {
            $allComp = $this->pageModel->get_all_category_wise_details022s($category_id,$subCategory,$subCategory1,$sort_id);
        }
        elseif ((!empty($category_id)) && (!empty($subCategory)) && (empty($subCategory1)) && (empty($subCategory2)))
        {
            $allComp = $this->pageModel->get_all_category_wise_details033s($category_id,$subCategory,$sort_id);
        }
        elseif ((!empty($category_id)) && (empty($subCategory)) && (empty($subCategory1)) && (empty($subCategory2)))
        {
            $allComp = $this->pageModel->get_all_category_wise_details044s($category_id,$sort_id);
        }
        else
        {
            $allComp = $this->pageModel->get_all_category_wise_details1($sort_id);
        }
        $data = [ 'all_it'=> $allComp,
                ];
        $this->view('pages/print_items1',$data);
    }
    public function item_by_category2(){
        if(isset($_SESSION['temp_print']))
        {
            redirect('pages/item_by_category');
            unset($_SESSION['temp_print']);
        }
        $data = [
            'cat' => $this->pageModel->getAllCategoriesDb(),
            'cat1' => $this->pageModel->getAllCategoriesDb2(),
            'cat2' => $this->pageModel->getAllCategoriesDb3(),
            'cat3' => $this->pageModel->getAllCategoriesDb4(),
            'type' => $this->pageModel->getAlltypeDb(),
            'model' => $this->pageModel->getAllCategoriesDb_model(),
            'cat_new' => $this->pageModel->getAllCategoriesDb_new(),
            'subcat_new' => $this->pageModel->getAllsubCategoriesDb_new(),
            'color' => $this->pageModel->getAllcolorDb_new(),
            'size' => $this->pageModel->getAllsizeDb_new(),
            'all_mfg' => $this->pageModel->getallmfg(),
        ];
          $this->view('pages/item_by_category2',$data);
    }
    public function by_allcategory_item_cat3()
    {
        $category_id = $_POST['category_id'];
        $subCategory = $_POST['subCategory'];
        $subCategory1 = $_POST['subCategory1'];
        $subCategory2 = $_POST['subCategory2'];
        if((!empty($category_id)) && (!empty($subCategory)) && (!empty($subCategory1)) && (!empty($subCategory2)))
        {
            $allComp = $this->pageModel->get_all_category_wise_details111s($category_id,$subCategory,$subCategory1,$subCategory2);
        }
        elseif ((!empty($category_id)) && (!empty($subCategory)) && (!empty($subCategory1)) && (empty($subCategory2)))
        {
            $allComp = $this->pageModel->get_all_category_wise_details222s($category_id,$subCategory,$subCategory1);
        }
        elseif ((!empty($category_id)) && (!empty($subCategory)) && (empty($subCategory1)) && (empty($subCategory2)))
        {
            $allComp = $this->pageModel->get_all_category_wise_details333s($category_id,$subCategory);
        }
        elseif ((!empty($category_id)) && (empty($subCategory)) && (empty($subCategory1)) && (empty($subCategory2)))
        {
            $allComp = $this->pageModel->get_all_category_wise_details444s($category_id);
        }
        else
        {
            $allComp = $this->pageModel->get_all_category_wise_details11();
        }
        $output = "";
        $sum=0;
        $post = new Page();
        foreach ($allComp as $k) {
            $created_at =0;
            $a =0;
               $b = 0;
                $c = 0;
                $d = 0;
            $s_stock = $post->get_single_stock($k->id);
             $da = '0';
            foreach ($s_stock as $kw)
            {
                $a = $a + $kw->stock_total_receive;
                 if($kw->receivable == 1)
                    {
                        $b = $b + $kw->stock_total_receive;
                        $d = (int)$k->qty * (int)$b;
                    }
                    if($kw->receivable == 3)
                    {
                        $c = $c + $kw->stock_total_receive;
                    }
            }
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
            if(empty($size_id)){$size_id="--";}else{$size_id=$size_id->size_name;}
            $dt = date("d-m-Y h:i:s a", strtotime($k->created_at));
            $sum = $sum + $a;
            if($k->receive==0){ $rec ="Carton(Qty ".$k->carton_qty.")"."<br>Box(Qty ".$k->qty.")"; }elseif($k->receive==1){ $rec ="Box(Qty ".$k->qty.")"; }else{ $rec ="Pieces(Qty ".$k->qty.")";}
        $output .= '<tr>
            <td scope="row">'.$k->id.'</td>
            <td>'.$k->name.'</td>
            <td>'.$rec.'</td>
            <td>'.$type_id.'</td>
            <td>'.$model_id.'</td>
            <td>'.$category_new_id.'</td>
            <td>'.$subcategory_new_id.'</td>
             <td>'.$k->committed_stock.'</td>
               <td>'.$d = $d + $c.'</td>
             <td>'.  $color_id.'</td>
             <td>'.  $size_id.'</td>
        </tr>';
        }
        $_SESSION['sum'] = $sum;
        echo $output;
    }
    
    public function print_items_by_category_wise2()
    {
          $_SESSION['temp_print']=1;
        $category_id = $_POST['c1'];
        $subCategory = $_POST['s1'];
        $subCategory1 = $_POST['s2'];
        $subCategory2 = $_POST['s3'];
         if((!empty($category_id)) && (!empty($subCategory)) && (!empty($subCategory1)) && (!empty($subCategory2)))
         {
            $allComp = $this->pageModel->get_all_category_wise_details0111s($category_id,$subCategory,$subCategory1,$subCategory2);
        }
        elseif ((!empty($category_id)) && (!empty($subCategory)) && (!empty($subCategory1)) && (empty($subCategory2)))
        {
            $allComp = $this->pageModel->get_all_category_wise_details0222s($category_id,$subCategory,$subCategory1);
        }
        elseif ((!empty($category_id)) && (!empty($subCategory)) && (empty($subCategory1)) && (empty($subCategory2)))
        {
            $allComp = $this->pageModel->get_all_category_wise_details0333s($category_id,$subCategory);
        }
        elseif ((!empty($category_id)) && (empty($subCategory)) && (empty($subCategory1)) && (empty($subCategory2)))
        {
            $allComp = $this->pageModel->get_all_category_wise_details0444s($category_id);
        }
        else
        {
            $allComp = $this->pageModel->get_all_category_wise_details11();
        }
        // if(empty($category_id)){ $c1 = ""; }else{ $c1 = $this->pageModel->getAlltypeDb_single($category_id);}
        // if(empty($subCategory)){ $s1 = ""; }else{ $s1 = $this->pageModel->getmodels_by_id($subCategory);}
        // if(empty($subCategory1)){ $s2 = ""; }else{ $s2 = $this->pageModel->getcategory_new_by_id($subCategory1);}
        // if(empty($subCategory2)){ $s3 = ""; }else{ $s3 = $this->pageModel->getsubcategory_new_by_id($subCategory2);}
        $data = [ 'all_it'=> $allComp,
                ];
        $this->view('pages/print_items2',$data);
    }
    public function item_by_category3(){
          if(isset($_SESSION['temp_print']))
        {
            redirect('pages/item_by_category');
            unset($_SESSION['temp_print']);
        }
        $data = [
            'cat' => $this->pageModel->getAllCategoriesDb(),
            'cat1' => $this->pageModel->getAllCategoriesDb2(),
            'cat2' => $this->pageModel->getAllCategoriesDb3(),
            'cat3' => $this->pageModel->getAllCategoriesDb4(),
            'type' => $this->pageModel->getAlltypeDb(),
            'model' => $this->pageModel->getAllCategoriesDb_model(),
            'cat_new' => $this->pageModel->getAllCategoriesDb_new(),
            'subcat_new' => $this->pageModel->getAllsubCategoriesDb_new(),
            'color' => $this->pageModel->getAllcolorDb_new(),
            'size' => $this->pageModel->getAllsizeDb_new(),
            'all_mfg' => $this->pageModel->getallmfg(),
        ];
        $this->view('pages/item_by_category3',$data);
    }
    public function by_allcategory_item_cat4()
    {
        $category_id = $_POST['category_id'];
        $subCategory = $_POST['subCategory'];
        $subCategory1 = $_POST['subCategory1'];
        $subCategory2 = $_POST['subCategory2'];
        if(!empty($_POST['to'])){
          $to=date('Y-m-d',strtotime($_POST['to']));
    }  else
        {
            $to = date('Y-m-d');
        }
          if(!empty($_POST['from'])){
        $from=date('Y-m-d',strtotime($_POST['from']));
          }else
        {
            $from = date('Y-m-d');
        }
         if((!empty($category_id)) && (!empty($subCategory)) && (!empty($subCategory1)) && (!empty($subCategory2)))
         {
            $allComp = $this->pageModel->get_all_category_wise_details1111s($category_id,$subCategory,$subCategory1,$subCategory2,$to,$from);
        }
        elseif ((!empty($category_id)) && (!empty($subCategory)) && (!empty($subCategory1)) && (empty($subCategory2)))
        {
            $allComp = $this->pageModel->get_all_category_wise_details2222s($category_id,$subCategory,$subCategory1,$to,$from);
        }
        elseif ((!empty($category_id)) && (!empty($subCategory)) && (empty($subCategory1)) && (empty($subCategory2)))
        {
            $allComp = $this->pageModel->get_all_category_wise_details3333s($category_id,$subCategory,$to,$from);
        }
        elseif ((!empty($category_id)) && (empty($subCategory)) && (empty($subCategory1)) && (empty($subCategory2)))
        {
            $allComp = $this->pageModel->get_all_category_wise_details4444s($category_id,$to,$from);
        }
        else
        {
            $allComp = $this->pageModel->get_all_category_wise_details111($to,$from);
        }
        $output = "";
        $sum=0;
        $post = new Page();
        foreach ($allComp as $k) {
            $created_at =0;
            $a =0;
            $b=0;
            $c=0;
            $s_stock = $post->get_single_stock($k->id);
             $da = '0';
            foreach ($s_stock as $kw)
            {
                $a = $a + $kw->stock_total_receive;
                        if($kw->receivable == 1)
                 {
                  $b = $b + $kw->stock_total_receive;
                 }
                if($kw->receivable == 3)
                    {
                     $c = $c + $kw->stock_total_receive;
                    }
                if(empty($kw->created_at))
                {
                     $created_at =0;
                     $da = '0';
                }
                else
                {
                    $created_at=$kw->created_at;
                    $d = date('Y-m-d H:i:s');
                    $date1 = strtotime($created_at);
                    $date2 = strtotime(date($d));
                    $diff = abs($date2 - $date1);
                    $years = floor($diff / (365*60*60*24));
                    $months = floor(($diff - $years * 365*60*60*24)
                                                / (30*60*60*24));
                    $days = floor(($diff - $years * 365*60*60*24 -
                    $months*30*60*60*24)/ (60*60*24));
                    $da = "Day:".$days."<br>Month:".$months."<br>Year:".$years;
                }
            }
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
            if(empty($size_id)){$size_id="--";}else{$size_id=$size_id->size_name;}
            $dt = date("d-m-Y h:i:s a", strtotime($k->created_at));
            $sum = $sum + $a;
            if($k->receive==1){ $rec ="Box(Qty ".$k->qty.")"; }else{ $rec ="Pieces(Qty ".$k->qty.")";}
        $output .= '<tr>
            <td scope="row">'.$k->id.'</td>
            <td>'.$model_id.'</td>
             <td>'.$type_id.'</td>
            <td>'.$category_new_id.'</td>
            <td>'.$subcategory_new_id.'</td>
            <td>'.$k->brand.'</td>
            <td>
            <label>Box:'.$b.'</label>
            <br>
            <label>Pieces:'.$c.'</label>
            </td>
            <td>
            <label>Box:'.$k->committed_stock.'</label></td>
            <td>'.$color_id.'</td>
            <td>'.$size_id.'</td>
        </tr>';
        }
        $_SESSION['sum'] = $sum;
        echo $output;
    }
    public function print_items_by_category_wise3()
    { $_SESSION['temp_print']=1;
        $category_id = $_POST['c1'];
        $subCategory = $_POST['s1'];
        $subCategory1 = $_POST['s2'];
        $subCategory2 = $_POST['s3'];
         if((!empty($category_id)) && (!empty($subCategory)) && (!empty($subCategory1)) && (!empty($subCategory2)))
         {
            $allComp = $this->pageModel->get_all_category_wise_details001s($category_id,$subCategory,$subCategory1,$subCategory2);
        }
        elseif ((!empty($category_id)) && (!empty($subCategory)) && (!empty($subCategory1)) && (empty($subCategory2)))
        {
            $allComp = $this->pageModel->get_all_category_wise_details002s($category_id,$subCategory,$subCategory1);
        }
        elseif ((!empty($category_id)) && (!empty($subCategory)) && (empty($subCategory1)) && (empty($subCategory2)))
        {
            $allComp = $this->pageModel->get_all_category_wise_details003s($category_id,$subCategory);
        }
        elseif ((!empty($category_id)) && (empty($subCategory)) && (empty($subCategory1)) && (empty($subCategory2)))
        {
            $allComp = $this->pageModel->get_all_category_wise_details004s($category_id);
        }
        else
        {
            $allComp = $this->pageModel->get_all_category_wise_details();
        }
        
        $data = [ 'all_it'=> $allComp,
                ];
        $this->view('pages/print_items3',$data);
    }
     public function by_allcategory_item_catfornameonly()
        {

            $category_id = $_POST['category_id'];
            $subCategory = $_POST['subCategory'];
            $subCategory1 = $_POST['subCategory1'];
            $subCategory2 = $_POST['subCategory2'];
             if((!empty($category_id)) && (!empty($subCategory)) && (!empty($subCategory1)) && (!empty($subCategory2)))
             { 
                $allComp = $this->pageModel->get_all_category_wise_details1s($category_id,$subCategory,$subCategory1,$subCategory2);
            }
            elseif ((!empty($category_id)) && (!empty($subCategory)) && (!empty($subCategory1)) && (empty($subCategory2))) 
            {
                $allComp = $this->pageModel->get_all_category_wise_details2s($category_id,$subCategory,$subCategory1);
            }
            elseif ((!empty($category_id)) && (!empty($subCategory)) && (empty($subCategory1)) && (empty($subCategory2))) 
            {
                $allComp = $this->pageModel->get_all_category_wise_details3s($category_id,$subCategory);
            }
            
            elseif ((!empty($category_id)) && (empty($subCategory)) && (empty($subCategory1)) && (empty($subCategory2))) 
            {
                $allComp = $this->pageModel->get_all_category_wise_details4s($category_id);
                
            }
            else
            {
                $allComp = $this->pageModel->get_all_category_wise_details();
            }
           
            $output = "";
            $sum=0;
            $post = new Page();
            foreach ($allComp as $k) {
                if(!empty($k->color_id))
                {
                    $color = $this->pageModel->get_color($k->color_id);   
                    if(empty($color))
                    {
                        $color='';
                    }else
                    {
                        $color = $color->color_name;                 
                    }
                }else
                {
                    $color = '';
                }
                if(!empty($k->size_id))
                {
                    $size = $this->pageModel->get_size($k->size_id);
                    if(empty($size))
                    {
                        $size='';
                    }
                    else
                    {
                        $size = $size->size_name;    
                    }                
                }
                else
                {
                    $size = '';
                }

                $a =0;
                $s_stock = $post->get_single_stock($k->id);
                foreach ($s_stock as $kw) 
                {
                $a = $a + $kw->stock_total_receive; 
                } 
                $type_id = $post->get_type_name_by_id($k->type_id);
                if(empty($type_id)){ $type_id = "--";}else{ $type_id = $type_id->type_name; }
                $model_id = $post->get_model_name_by_id($k->model_id);
                if(empty($model_id)){ $model_id = "--";}else{ $model_id = $model_id->model_name; }
                $category_new_id = $post->get_category_name_by_id($k->category_new_id);
                 if(empty($category_new_id)){ $category_new_id = "--";}else{ $category_new_id = $category_new_id->category_name; }
                $subcategory_new_id = $post->get_subcategory_name_by_id($k->subcategory_new_id);
                if(empty($subcategory_new_id)){ $subcategory_new_id = "--";}else{ $subcategory_new_id = $subcategory_new_id->sc_name; }
                $dt = date("d-m-Y h:i:s a", strtotime($k->created_at));
                $sum = $sum + $a;
                $val = [
                    'id' => $k->id,
                    'name' => $k->name
                ];
                $v = json_encode($val);

                if($k->receive==1){ $rec ="Box(Qty ".$k->qty.")"; }else{ $rec ="Pieces(Qty ".$k->qty.")";}
            $output .= "<tr>
                <td scope='row'>".$k->id."</td>
                <td>".$k->name."</td>
                <td>".$color."</td>
                <td>".$size."</td>
                <td style='text-align: center;''>
                   <a class='btn btn-primary mr-1' style='color:white' href='#' onclick='select_items(" . $v . ")'>Select</a> 
                </td>
            </tr>";
            }
            $_SESSION['sum'] = $sum;
            echo $output;
        }
        public function getTheItemName_for_jquery()
        {
            $val = trim($_POST['val']);
            $item = $this->pageModel->getTheItemDetails($val);
            $all_items = $this->pageModel->get_all_items_for_dropdown();
            $option = '';
            foreach ($all_items as $k) {
                $m = $this->pageModel->get_model_name_by_id($k->model_id);
                if(empty($m->model_name)){ $m=""; }else{ $m=$m->model_name; }

                if($k->name == $item->name)
                {
                    $option .= '<option selected value="'.$k->id.'">('.$m.')'.$item->name.'</option>';
                }
                else
                {
                    $option .= '<option value="'.$k->id.'">('.$m.')'.$k->name.'</option>';
                }
            }
            echo $option;
        }
        public function getTheItemName_for_jquery_name()
        {
            $val = trim($_POST['val']);
            $item = $this->pageModel->getTheItemDetails($val);
            echo $item->name;
        }
        public function refresh_tag_for_next()
        {
            if((isset($_SESSION['mfg_sort'])) AND (!empty($_SESSION['mfg_sort'])))
            {
                $all_items = $this->pageModel->get_all_items_for_dropdown();
                $output ='';
                $output .= '<select class="select2-single form-control" name="" id="tags" onchange="getitem_name(this.value)"><option>--Select--</option>';
                    foreach ($all_items as $it) 
                    {
                        $per = explode("|",$_SESSION['mfg_sort']);
                        for ($i=0; $i <sizeof($per); $i++) 
                        {
                            if($per[$i]==$it->mfg_id)
                            {
                                $m = $this->pageModel->get_model_name_by_id($it->model_id);
                                if(empty($m->model_name)){ $m=""; }else{ $m=$m->model_name; }
                                $output .= '<option value="'.$it->id.'">'.$it->name.'</option>';
                            }
                        }
                    }
                $output .='</select>';
                echo $output;
            }
            else
            {
                $all_items = $this->pageModel->get_all_items_for_dropdown();
                $output = '';
                $output .='<option selected disabled>---select----</option>';
                foreach ($all_items as $it) 
                {
                    $m = $this->pageModel->get_model_name_by_id($it->model_id);
                    if(empty($m->model_name)){ $m=""; }else{ $m=$m->model_name; }

                    $output .= '<option value="'.$it->id.'">'.$it->name.'</option>'; 
                }
                echo $output;
            }
        }
        public function create_expenses()
        {
                $data = [
            'expensetype' => $_POST['expensetype'],
            'expensedetail' => $_POST['expensedetail'],
            'expensedate'=>$_POST['expensedate'],
            'expensevalue'=>$_POST['expensevalue'],
                  ];
        $this->pageModel->add_expense_details($data);
        // $_SESSION['success'] = "Inventory added successfully";
         redirect('pages/all_expenses');
      }
      public function create_type(){
        $data=[
            'typee'=>$_POST['typee'],
        ];
        $this->pageModel->add_expensetype_details($data);
        redirect('pages/addexpenses');
    }
    public function addexpenses()
    {
           $data = [
            'typee' => $this->pageModel->getalltypes()
        ];
        $this->view('pages/addexpenses',$data);
    }
        public function addtype()
    {
        $this->view('pages/addtype');
    }
    public function all_expenses()
    {             $data=[
                 'all_expenses' => $this->pageModel->get_all_expenses()
             ];
               $this->view('pages/all_expenses',$data);
    }
           public function all_expenses1()
    {             $data=[
                 'all_expenses' => $this->pageModel->get_all_expenses1($_POST['start'],$_POST['end'])
             ];
               $this->view('pages/all_expenses1',$data);
    }
    // table report start
    
    public function report_table()
    {
        $get_all_models = $this->pageModel->get_all_models();
        $get_all_colors = $this->pageModel->get_all_colors();
        $get_total_sizes_count = $this->pageModel->get_total_sizes_count();
        $data = [
            'get_all_models'=> $get_all_models,
            'get_all_colors'=> $get_all_colors,
            'get_total_sizes_count' => $get_total_sizes_count,
            'model_details' => ''
        ];
        $this->view('pages/report_table', $data);
    }

    public function report_table1()
    {
        $get_all_models = $this->pageModel->get_all_models();
        $get_all_colors = $this->pageModel->get_all_colors();
        $get_total_sizes_count = $this->pageModel->get_total_sizes_count();
        $data = [
            'get_all_models'=> $get_all_models,
            'get_all_colors'=> $get_all_colors,
            'get_total_sizes_count' => $get_total_sizes_count,
            'model_details' => ''
        ];
        $this->view('pages/report_table1', $data);
    }
    public function report_table1_print()
    {
        $get_all_models = $this->pageModel->get_all_models();
        $get_all_colors = $this->pageModel->get_all_colors();
        $get_total_sizes_count = $this->pageModel->get_total_sizes_count();
        $data = [
            'get_all_models'=> $get_all_models,
            'get_all_colors'=> $get_all_colors,
            'get_total_sizes_count' => $get_total_sizes_count,
            'model_details' => ''
        ];
        $this->view('pages/report_table1_print', $data);
    }

    public function report_table2()
    {
        $get_all_models = $this->pageModel->get_all_models();
        $get_all_colors = $this->pageModel->get_all_colors();
        $get_total_sizes_count = $this->pageModel->get_total_sizes_count();
        $data = [
            'get_all_models'=> $get_all_models,
            'get_all_colors'=> $get_all_colors,
            'get_total_sizes_count' => $get_total_sizes_count,
            'model_details' => ''
        ];
        $this->view('pages/report_table2', $data);
    }
    public function report_table2_c()
    {
        $get_all_models = $this->pageModel->get_all_models();
        $get_all_colors = $this->pageModel->get_all_colors();
        $get_total_sizes_count = $this->pageModel->get_total_sizes_count();
        $data = [
            'get_all_models'=> $get_all_models,
            'get_all_colors'=> $get_all_colors,
            'get_total_sizes_count' => $get_total_sizes_count,
            'model_details' => ''
        ];
        $this->view('pages/report_table2_c', $data);
    }

    public function report_table_val1($model_val)
    {
        $get_model_by_id = $this->pageModel->get_model_by_id($model_val);
        $get_all_models = $this->pageModel->get_all_models();
        $get_all_colors = $this->pageModel->get_all_colors();
        $get_total_sizes_count = $this->pageModel->get_total_sizes_count();
        $data = [
            'get_all_models'=> $get_all_models,
            'get_all_colors'=> $get_all_colors,
            'get_total_sizes_count' => $get_total_sizes_count,
            'model_details' => $get_model_by_id,
            'model_val' => $model_val
        ];
        $this->view('pages/report_table2', $data);
    }
     public function report_table_val1_print($model_val)
    {

        $get_model_by_id = $this->pageModel->get_model_by_id($model_val);
        $get_all_models = $this->pageModel->get_all_models();
        $get_all_colors = $this->pageModel->get_all_colors();
        $get_total_sizes_count = $this->pageModel->get_total_sizes_count();
        $data = [
            'get_all_models'=> $get_all_models,
            'get_all_colors'=> $get_all_colors,
            'get_total_sizes_count' => $get_total_sizes_count,
            'model_details' => $get_model_by_id,
            'model_val' => $model_val
        ];
        $this->view('pages/report_table2_print', $data);
    }
    public function report_table_val1_c($c)
    {
        $cc = $c;
        $c = explode("|", $c);
        $model_val = $c[0];
        $category_val = $c[1];
        $get_model_by_id = $this->pageModel->get_model_by_id($model_val);
        $get_all_models = $this->pageModel->get_all_models();
        $get_all_colors = $this->pageModel->get_all_colors();
        $get_total_sizes_count = $this->pageModel->get_total_sizes_count();
        $data = [
            'get_all_models'=> $get_all_models,
            'get_all_colors'=> $get_all_colors,
            'get_total_sizes_count' => $get_total_sizes_count,
            'model_details' => $get_model_by_id,
            'model_val' => $model_val,
            'cat_v' => $category_val,
            'mc' => $cc,
        ];
        $this->view('pages/report_table2_c', $data);
    }
    public function report_table_val1_c_print($c)
    {
        $c = explode("|", $c);
        $model_val = $c[0];
        $category_val = $c[1];
        $get_model_by_id = $this->pageModel->get_model_by_id($model_val);
        $get_all_models = $this->pageModel->get_all_models();
        $get_all_colors = $this->pageModel->get_all_colors();
        $get_total_sizes_count = $this->pageModel->get_total_sizes_count();
        $data = [
            'get_all_models'=> $get_all_models,
            'get_all_colors'=> $get_all_colors,
            'get_total_sizes_count' => $get_total_sizes_count,
            'model_details' => $get_model_by_id,
            'model_val' => $model_val,
            'cat_v' => $category_val,
        ];
        $this->view('pages/report_table2_c_print', $data);
    }


    public function report_table_val($model_val)
    {
        $get_model_by_id = $this->pageModel->get_model_by_id($model_val);
        $get_all_models = $this->pageModel->get_all_models();
        $get_all_colors = $this->pageModel->get_all_colors();
        $get_total_sizes_count = $this->pageModel->get_total_sizes_count();
        $data = [
            'get_all_models'=> $get_all_models,
            'get_all_colors'=> $get_all_colors,
            'get_total_sizes_count' => $get_total_sizes_count,
            'model_details' => $get_model_by_id,
        ];
        $this->view('pages/report_table', $data);
    }

    public function customerwise_sales_report1()
    {
        $get_all_models = $this->pageModel->get_all_models();
        $get_all_colors = $this->pageModel->get_all_colors();
        $get_total_sizes_count = $this->pageModel->get_total_sizes_count();
        $get_distinct_stock_out = $this->pageModel->get_distinct_stock_out(); 
        $data = [
            'get_all_models'=> $get_all_models,
            'get_all_colors'=> $get_all_colors,
            'get_total_sizes_count' => $get_total_sizes_count,
            'get_distinct_stock_out' => $get_distinct_stock_out,
            'model_details' => '',
            'customer_id' => '',
        ];
        $this->view('pages/customerwise_sales_report3', $data);
    }

    public function del($model_val)
    {


        $this->pageModel->delete_sales_report_temp(); 


        redirect('pages/customerwise_sales_report1_val/'.$model_val);
    }

    public function customerwise_sales_report1_val($model_val)
    {

    
        $d = explode("|", $model_val);

        $model_val =  $d[0];

        $cutomer_id = $d[1];

        $type_arr = array();

        $model_arr = array();
        $catagory_arr = array();

        $size_arr = array();
        $color_arr = array();

        $st = $this->pageModel->get_all_stockout_by_custid($cutomer_id); 

        foreach ($st as $k) 
        { 

            $sto = $this->pageModel->get_all_stockoutorder_by_id($k->id);

            $item_id = explode("|||", $sto->item_id);

            $item_qty = explode("|||", $sto->item_qty);

            $item_rec = explode("|||", $sto->item_rec);

            $j = 1;

            for ($i=0; $i <sizeof($item_id); $i++) 
            {
                $s_item = $this->pageModel->get_item_by_id($item_id[$i]);

                $type_arr[$j] = $s_item->type_id;
                $model_arr[$j] = $s_item->model_id;
                $catagory_arr[$j] = $s_item->category_new_id;

                $size_arr[$j] = $s_item->size_id;
                $color_arr[$j] = $s_item->color_id;

                $data = [

                    'customer_id' => $cutomer_id,
                    'item_id' => $item_id[$i],
                    'type_id' => $s_item->type_id,
                    'model_id' => $s_item->model_id,
                    'category_new_id' => $s_item->category_new_id,
                    'size_id' => $s_item->size_id,
                    'color_id' => $s_item->color_id,
                    'item_qty' => $item_qty[$i],
                    'item_rec' => $item_rec[$i],
                ];

                $insert_temp_vals = $this->pageModel->insert_temp_vals($data);

                $j++;
            }
        }


        $get_model_by_id = $this->pageModel->get_model_by_id($model_val);
        $get_all_models = $this->pageModel->get_all_models();
        $get_all_colors = $this->pageModel->get_all_colors();
        $get_total_sizes_count = $this->pageModel->get_total_sizes_count();
        $get_distinct_stock_out = $this->pageModel->get_distinct_stock_out();

        $data = [
            'get_all_models'=> $get_all_models,
            'get_all_colors'=> $get_all_colors,
            'get_total_sizes_count' => $get_total_sizes_count,
            'get_distinct_stock_out' => $get_distinct_stock_out,
            'model_details' => $get_model_by_id,
             'customer_id' => $cutomer_id,
        ];


        $get_all_customers_temp = $this->pageModel->get_all_customers_temp();

        // var_dump($get_all_customers_temp);

        foreach ($get_all_customers_temp as $key) 
        {
            $data = [

                'customer_id' => $key->customer_id,
                'type_id' => 4
               
            ];

            $get_modal_rowSpan = $this->pageModel->get_modal_rowSpan($data);

            foreach ($get_modal_rowSpan as $key_m)
            {
                $data = [

                        'customer_id' => $key->customer_id,
                        'type_id' => 4,
                        'model_id' => $key_m->model_id
                       
                    ];

                $get_catagory_rowSpan = $this->pageModel->get_catagory_rowSpan($data);

                foreach ($get_catagory_rowSpan as $key1)
                {
                   
                    $data = [

                        'customer_id' => $key->customer_id,
                        'type_id' => 4,
                        'model_id' => $key_m->model_id,
                        'category_id' => $key1->category_id
                       
                    ];

                    $get_size_rowSpan = $this->pageModel->get_size_rowSpan($data);

                    foreach ($get_size_rowSpan as $key_s)
                    {
                        // echo $key_s->size_id;

                        $data = [

                        'customer_id' => $key->customer_id,
                        'type_id' => 4,
                        'model_id' => $key_m->model_id,
                        'category_id' => $key1->category_id,
                        'size_id' => $key_s->size_id
                       
                        ];

                        $insert_rep_count = $this->pageModel->insert_rep_count($data);
                    }
                }
            }
        }      


        $this->view('pages/customerwise_sales_report3', $data);
    }

    public function customerwise_sales_report2_time()
    {
        $all_cust = $this->pageModel->all_cust();
        $all_mod = $this->pageModel->all_mod();
        $data = [
            'all_cust' => $all_cust,
            'all_mod' => $all_mod,
            'date_val' => '',                      
            ];
        $this->view('pages/customerwise_sales_report5',$data);
    }
    public function customerwise_sales_report2_time_p()
    {
        $all_cust = $this->pageModel->all_cust();
        $all_mod = $this->pageModel->all_mod();
        $data = [
            'all_cust' => $all_cust,
            'all_mod' => $all_mod,
            'date_val' => '',                      
            ];
        $this->view('pages/customerwise_sales_report5P',$data);
    }
    public function date_wise_direct_package_report()
    {
        $all_cust = $this->pageModel->all_cust();
        $all_mod = $this->pageModel->all_mod();
        $data = [
            'all_cust' => $all_cust,
            'all_mod' => $all_mod,
            'date_val' => '',                      
            ];
        $this->view('pages/date_wise_direct_package_report',$data);
    }
     public function date_wise_direct_package_report_with_cust()
    {
        $all_cust = $this->pageModel->all_cust();
        $all_mod = $this->pageModel->all_mod();
        $data = [
            'all_cust' => $all_cust,
            'all_mod' => $all_mod,
            'date_val' => '',                      
            ];
        $this->view('pages/date_wise_direct_package_report_with_cust',$data);
    }

    public function customerwise_sales_report2_time2()
    {

        $all_data = $this->pageModel->check_data_exsist(); 

        if(empty($all_data))
        {

            if(empty($_POST['customer_list']) && empty($_POST['model_list']))
            {
                $from_date= $_POST['from_date'];

                $to_date= $_POST['to_date'];

                

                $type_arr = array();

                $model_arr = array();
                $catagory_arr = array();

                $size_arr = array();
                $color_arr = array();
                

               $get_stock_by_date = $this->pageModel->get_stock_by_date($from_date, $to_date);

                foreach ($get_stock_by_date as $key_di) 
                {

                    $st = $this->pageModel->get_all_stockout_by_custid($key_di->customer_id); 

                    foreach ($st as $k) 
                    { 

                        $sto = $this->pageModel->get_all_stockoutorder_by_id($k->id);

                        $item_id = explode("|||", $sto->item_id);

                        $item_qty = explode("|||", $sto->item_qty);

                        $item_rec = explode("|||", $sto->item_rec);

                        $j = 0;

                        for ($i=0; $i <sizeof($item_id); $i++) 
                        {
                            $s_item = $this->pageModel->get_item_by_id($item_id[$i]);

                            $type_arr[$j] = $s_item->type_id;
                            $model_arr[$j] = $s_item->model_id;
                            $catagory_arr[$j] = $s_item->category_new_id;

                            $size_arr[$j] = $s_item->size_id;
                            $color_arr[$j] = $s_item->color_id;

                            $data = [

                                'customer_id' => $key_di->customer_id,
                                'item_id' => $item_id[$i],
                                'type_id' => $s_item->type_id,
                                'model_id' => $s_item->model_id,
                                'category_new_id' => $s_item->category_new_id,
                                'size_id' => $s_item->size_id,
                                'color_id' => $s_item->color_id,
                                'item_qty' => $item_qty[$i],
                                'item_rec' => $item_rec[$i],
                            ];

                            $insert_temp_vals = $this->pageModel->insert_temp_vals_new($data);

                            $j++;
                        }
                    }

                }

                $all_cust = $this->pageModel->all_cust();

                $all_mod = $this->pageModel->all_mod();

                $data=[

                    'all_cust' => $all_cust,
                    'all_mod' => $all_mod,
                    'date_val' => 1,
                    'customize_customer' => '',
                    'customize_models' => ''
                ];

                $this->view('pages/customerwise_sales_report5',$data);
            }
            elseif(empty($_POST['customer_list']) && !empty($_POST['model_list']))
            {
                redirect('pages/customerwise_sales_report2_time');
            }
            elseif(empty($_POST['model_list']))
            {
                $customer_list = $_POST['customer_list'];

                $from_date= $_POST['from_date'];

                $to_date= $_POST['to_date'];               

                $type_arr = array();

                $model_arr = array();
                $catagory_arr = array();

                $size_arr = array();
                $color_arr = array();
                
                foreach ($customer_list as $cu_list)
                {
                
                    $get_stock_by_date = $this->pageModel->get_stock_by_date_cust($from_date, $to_date, $cu_list);

                    foreach ($get_stock_by_date as $key_di) 
                    {

                        $st = $this->pageModel->get_all_stockout_by_custid($key_di->customer_id); 

                        foreach ($st as $k) 
                        { 

                            $sto = $this->pageModel->get_all_stockoutorder_by_id($k->id);

                            $item_id = explode("|||", $sto->item_id);

                            $item_qty = explode("|||", $sto->item_qty);

                            $item_rec = explode("|||", $sto->item_rec);

                            $j = 0;

                            for ($i=0; $i <sizeof($item_id); $i++) 
                            {
                                $s_item = $this->pageModel->get_item_by_id($item_id[$i]);

                                $type_arr[$j] = $s_item->type_id;
                                $model_arr[$j] = $s_item->model_id;
                                $catagory_arr[$j] = $s_item->category_new_id;

                                $size_arr[$j] = $s_item->size_id;
                                $color_arr[$j] = $s_item->color_id;

                                $data = [

                                    'customer_id' => $key_di->customer_id,
                                    'item_id' => $item_id[$i],
                                    'type_id' => $s_item->type_id,
                                    'model_id' => $s_item->model_id,
                                    'category_new_id' => $s_item->category_new_id,
                                    'size_id' => $s_item->size_id,
                                    'color_id' => $s_item->color_id,
                                    'item_qty' => $item_qty[$i],
                                    'item_rec' => $item_rec[$i],
                                ];

                                $insert_temp_vals = $this->pageModel->insert_temp_vals_new($data);

                                $j++;
                            }
                        }

                    }

                }

                $all_cust = $this->pageModel->all_cust();

                $all_mod = $this->pageModel->all_mod();

                $data=[

                    'all_cust' => $all_cust,
                    'all_mod' => $all_mod,
                    'date_val' => 1,
                    'customize_customer' => 1,
                    'customize_models' => '',
                    'customer_list' => $customer_list
                ];

                $this->view('pages/customerwise_sales_report5',$data);

            }
            elseif(!empty($_POST['customer_list']) && !empty($_POST['model_list']))
            {
                $customer_list = $_POST['customer_list'];

                $model_list = $_POST['model_list'];

                $from_date= $_POST['from_date'];

                $to_date= $_POST['to_date'];               

                $type_arr = array();

                $model_arr = array();
                $catagory_arr = array();

                $size_arr = array();
                $color_arr = array();
                
                foreach ($customer_list as $cu_list)
                {
                
                    $get_stock_by_date = $this->pageModel->get_stock_by_date_cust($from_date, $to_date, $cu_list);

                    foreach ($get_stock_by_date as $key_di) 
                    {

                        $st = $this->pageModel->get_all_stockout_by_custid($key_di->customer_id); 

                        foreach ($st as $k) 
                        { 

                            $sto = $this->pageModel->get_all_stockoutorder_by_id($k->id);

                            $item_id = explode("|||", $sto->item_id);

                            $item_qty = explode("|||", $sto->item_qty);

                            $item_rec = explode("|||", $sto->item_rec);

                            $j = 0;

                            for ($i=0; $i <sizeof($item_id); $i++) 
                            {
                                $s_item = $this->pageModel->get_item_by_id($item_id[$i]);

                                $type_arr[$j] = $s_item->type_id;
                                $model_arr[$j] = $s_item->model_id;
                                $catagory_arr[$j] = $s_item->category_new_id;

                                $size_arr[$j] = $s_item->size_id;
                                $color_arr[$j] = $s_item->color_id;

                                $data = [

                                    'customer_id' => $key_di->customer_id,
                                    'item_id' => $item_id[$i],
                                    'type_id' => $s_item->type_id,
                                    'model_id' => $s_item->model_id,
                                    'category_new_id' => $s_item->category_new_id,
                                    'size_id' => $s_item->size_id,
                                    'color_id' => $s_item->color_id,
                                    'item_qty' => $item_qty[$i],
                                    'item_rec' => $item_rec[$i],
                                ];

                                $insert_temp_vals = $this->pageModel->insert_temp_vals_new($data);

                                $j++;
                            }
                        }

                    }

                }

                $all_cust = $this->pageModel->all_cust();

                $all_mod = $this->pageModel->all_mod();

                $data=[

                    'all_cust' => $all_cust,
                    'all_mod' => $all_mod,
                    'date_val' => 1,
                    'customize_customer' => 1,
                    'customize_models' => 1,
                    'customer_list' => $customer_list,
                    'model_list' => $model_list
                ];

                $this->view('pages/customerwise_sales_report5',$data);                
            }           

        }
        else
        {

            if($this->pageModel->delete_sales_report_temp_new())  
            {
           
                if(empty($_POST['customer_list']) && empty($_POST['model_list']))
                {

                    

                        $from_date= $_POST['from_date'];

                        $to_date= $_POST['to_date'];

                        

                        $type_arr = array();

                        $model_arr = array();
                        $catagory_arr = array();

                        $size_arr = array();
                        $color_arr = array();
                        

                       $get_stock_by_date = $this->pageModel->get_stock_by_date($from_date, $to_date);

                        foreach ($get_stock_by_date as $key_di) 
                        {

                            $st = $this->pageModel->get_all_stockout_by_custid($key_di->customer_id); 

                            foreach ($st as $k) 
                            { 

                                $sto = $this->pageModel->get_all_stockoutorder_by_id($k->id);

                                $item_id = explode("|||", $sto->item_id);

                                $item_qty = explode("|||", $sto->item_qty);

                                $item_rec = explode("|||", $sto->item_rec);

                                $j = 0;

                                for ($i=0; $i <sizeof($item_id); $i++) 
                                {
                                    $s_item = $this->pageModel->get_item_by_id($item_id[$i]);

                                    $type_arr[$j] = $s_item->type_id;
                                    $model_arr[$j] = $s_item->model_id;
                                    $catagory_arr[$j] = $s_item->category_new_id;

                                    $size_arr[$j] = $s_item->size_id;
                                    $color_arr[$j] = $s_item->color_id;

                                    $data = [

                                        'customer_id' => $key_di->customer_id,
                                        'item_id' => $item_id[$i],
                                        'type_id' => $s_item->type_id,
                                        'model_id' => $s_item->model_id,
                                        'category_new_id' => $s_item->category_new_id,
                                        'size_id' => $s_item->size_id,
                                        'color_id' => $s_item->color_id,
                                        'item_qty' => $item_qty[$i],
                                        'item_rec' => $item_rec[$i],
                                    ];

                                    $insert_temp_vals = $this->pageModel->insert_temp_vals_new($data);

                                    $j++;
                                }
                            }

                        }

                        $all_cust = $this->pageModel->all_cust();

                        $all_mod = $this->pageModel->all_mod();

                        $data=[

                            'all_cust' => $all_cust,
                            'all_mod' => $all_mod,
                            'date_val' => 1,
                            'customize_customer' => '',
                            'customize_models' => ''
                        ];

                        $this->view('pages/customerwise_sales_report5',$data);
                          

                }
                elseif(empty($_POST['customer_list']) && !empty($_POST['model_list']))
                {
                    redirect('pages/customerwise_sales_report2_time');
                }
                elseif(empty($_POST['model_list']))
                {
                    $customer_list = $_POST['customer_list'];

                    $from_date= $_POST['from_date'];

                    $to_date= $_POST['to_date'];               

                    $type_arr = array();

                    $model_arr = array();
                    $catagory_arr = array();

                    $size_arr = array();
                    $color_arr = array();
                    
                    foreach ($customer_list as $cu_list)
                    {
                    
                        $get_stock_by_date = $this->pageModel->get_stock_by_date_cust($from_date, $to_date, $cu_list);

                        foreach ($get_stock_by_date as $key_di) 
                        {

                            $st = $this->pageModel->get_all_stockout_by_custid($key_di->customer_id); 

                            foreach ($st as $k) 
                            { 

                                $sto = $this->pageModel->get_all_stockoutorder_by_id($k->id);

                                $item_id = explode("|||", $sto->item_id);

                                $item_qty = explode("|||", $sto->item_qty);

                                $item_rec = explode("|||", $sto->item_rec);

                                $j = 0;

                                for ($i=0; $i <sizeof($item_id); $i++) 
                                {
                                    $s_item = $this->pageModel->get_item_by_id($item_id[$i]);

                                    $type_arr[$j] = $s_item->type_id;
                                    $model_arr[$j] = $s_item->model_id;
                                    $catagory_arr[$j] = $s_item->category_new_id;

                                    $size_arr[$j] = $s_item->size_id;
                                    $color_arr[$j] = $s_item->color_id;

                                    $data = [

                                        'customer_id' => $key_di->customer_id,
                                        'item_id' => $item_id[$i],
                                        'type_id' => $s_item->type_id,
                                        'model_id' => $s_item->model_id,
                                        'category_new_id' => $s_item->category_new_id,
                                        'size_id' => $s_item->size_id,
                                        'color_id' => $s_item->color_id,
                                        'item_qty' => $item_qty[$i],
                                        'item_rec' => $item_rec[$i],
                                    ];

                                    $insert_temp_vals = $this->pageModel->insert_temp_vals_new($data);

                                    $j++;
                                }
                            }

                        }

                    }

                    $all_cust = $this->pageModel->all_cust();

                    $all_mod = $this->pageModel->all_mod();

                    $data=[

                        'all_cust' => $all_cust,
                        'all_mod' => $all_mod,
                        'date_val' => 1,
                        'customize_customer' => 1,
                        'customize_models' => '',
                        'customer_list' => $customer_list
                    ];

                    $this->view('pages/customerwise_sales_report5',$data);

                }
                elseif(!empty($_POST['customer_list']) && !empty($_POST['model_list']))
                {
                    $customer_list = $_POST['customer_list'];

                    $model_list = $_POST['model_list'];

                    $from_date= $_POST['from_date'];

                    $to_date= $_POST['to_date'];               

                    $type_arr = array();

                    $model_arr = array();
                    $catagory_arr = array();

                    $size_arr = array();
                    $color_arr = array();
                    
                    foreach ($customer_list as $cu_list)
                    {
                    
                        $get_stock_by_date = $this->pageModel->get_stock_by_date_cust($from_date, $to_date, $cu_list);

                        foreach ($get_stock_by_date as $key_di) 
                        {

                            $st = $this->pageModel->get_all_stockout_by_custid($key_di->customer_id); 

                            foreach ($st as $k) 
                            { 

                                $sto = $this->pageModel->get_all_stockoutorder_by_id($k->id);

                                $item_id = explode("|||", $sto->item_id);

                                $item_qty = explode("|||", $sto->item_qty);

                                $item_rec = explode("|||", $sto->item_rec);

                                $j = 0;

                                for ($i=0; $i <sizeof($item_id); $i++) 
                                {
                                    $s_item = $this->pageModel->get_item_by_id($item_id[$i]);

                                    $type_arr[$j] = $s_item->type_id;
                                    $model_arr[$j] = $s_item->model_id;
                                    $catagory_arr[$j] = $s_item->category_new_id;

                                    $size_arr[$j] = $s_item->size_id;
                                    $color_arr[$j] = $s_item->color_id;

                                    $data = [

                                        'customer_id' => $key_di->customer_id,
                                        'item_id' => $item_id[$i],
                                        'type_id' => $s_item->type_id,
                                        'model_id' => $s_item->model_id,
                                        'category_new_id' => $s_item->category_new_id,
                                        'size_id' => $s_item->size_id,
                                        'color_id' => $s_item->color_id,
                                        'item_qty' => $item_qty[$i],
                                        'item_rec' => $item_rec[$i],
                                    ];

                                    $insert_temp_vals = $this->pageModel->insert_temp_vals_new($data);

                                    $j++;
                                }
                            }

                        }

                    }

                    $all_cust = $this->pageModel->all_cust();

                    $all_mod = $this->pageModel->all_mod();

                    $data=[

                        'all_cust' => $all_cust,
                        'all_mod' => $all_mod,
                        'date_val' => 1,
                        'customize_customer' => 1,
                        'customize_models' => 1,
                        'customer_list' => $customer_list,
                        'model_list' => $model_list
                    ];

                    $this->view('pages/customerwise_sales_report5',$data);                
                }

            }
            else
            {
                redirect('pages/customerwise_sales_report2_time');
            }
            
        } 
    }
    public function customerwise_sales_report2_time2_P()
    {
        $dd_delete = $this->pageModel->delete_sales_report_temp_new();
        if($dd_delete == true)
        {
            if($this->pageModel->delete_sales_report_temp_new())  
            {  
                if(empty($_POST['customer_list']) && empty($_POST['model_list']))
                {   
                        $from_date= $_POST['from_date'];
                        $to_date= $_POST['to_date'];
                        $type_arr = array();
                        $model_arr = array();
                        $catagory_arr = array();
                        $size_arr = array();
                        $color_arr = array();
                        $get_stock_by_date = $this->pageModel->get_direct_pack_by_date($from_date, $to_date);
                       
                        foreach ($get_stock_by_date as $sto2) 
                        {
                                
                                $item_id = explode("|||", $sto2->item_id);
                                $item_qty = explode("|||", $sto2->item_qty);
                                $item_rec = explode("|||", $sto2->item_rec);
                                $j = 0;
                                for ($i=0; $i <sizeof($item_id); $i++) 
                                {

                                    $s_item = $this->pageModel->get_item_by_id($item_id[$i]);
                                    $type_arr[$j] = $s_item->type_id;
                                    $model_arr[$j] = $s_item->model_id;
                                    $catagory_arr[$j] = $s_item->category_new_id;
                                    $size_arr[$j] = $s_item->size_id;
                                    $color_arr[$j] = $s_item->color_id;

                                    $data1 = [

                                        'customer_id' => $sto2->customer_id,
                                        'item_id' => $item_id[$i],
                                        'type_id' => $s_item->type_id,
                                        'model_id' => $s_item->model_id,
                                        'category_new_id' => $s_item->category_new_id,
                                        'size_id' => $s_item->size_id,
                                        'color_id' => $s_item->color_id,
                                        'item_qty' => $item_qty[$i],
                                        'item_rec' => $item_rec[$i],
                                    ];
                                    $insert_temp_vals = $this->pageModel->insert_temp_vals_new($data1);
                                    $j++;
                                }
                            

                        }

                        $all_cust = $this->pageModel->all_cust();

                        $all_mod = $this->pageModel->all_mod();

                        $data=[

                            'all_cust' => $all_cust,
                            'all_mod' => $all_mod,
                            'date_val' => 1,
                            'customize_customer' => '',
                            'customize_models' => ''
                        ];

                       $this->view('pages/customerwise_sales_report5P',$data);
                }
                elseif(empty($_POST['customer_list']) && !empty($_POST['model_list']))
                {
                    redirect('pages/customerwise_sales_report2_time_p');
                }
                elseif(empty($_POST['model_list']))
                {
                    $customer_list = $_POST['customer_list'];

                    $from_date= $_POST['from_date'];

                    $to_date= $_POST['to_date'];               

                    $type_arr = array();

                    $model_arr = array();
                    $catagory_arr = array();

                    $size_arr = array();
                    $color_arr = array();
                    
                    foreach ($customer_list as $cu_list)
                    {
                    
                        $get_stock_by_date = $this->pageModel->get_direct_package_by_date_cust($from_date, $to_date, $cu_list);

                        foreach ($get_stock_by_date as $key_di) 
                        {

                                $item_id = explode("|||", $key_di->item_id);

                                $item_qty = explode("|||", $key_di->item_qty);

                                $item_rec = explode("|||", $key_di->item_rec);

                                $j = 0;

                                for ($i=0; $i <sizeof($item_id); $i++) 
                                {
                                    $s_item = $this->pageModel->get_item_by_id($item_id[$i]);

                                    $type_arr[$j] = $s_item->type_id;
                                    $model_arr[$j] = $s_item->model_id;
                                    $catagory_arr[$j] = $s_item->category_new_id;

                                    $size_arr[$j] = $s_item->size_id;
                                    $color_arr[$j] = $s_item->color_id;

                                    $data = [

                                        'customer_id' => $key_di->customer_id,
                                        'item_id' => $item_id[$i],
                                        'type_id' => $s_item->type_id,
                                        'model_id' => $s_item->model_id,
                                        'category_new_id' => $s_item->category_new_id,
                                        'size_id' => $s_item->size_id,
                                        'color_id' => $s_item->color_id,
                                        'item_qty' => $item_qty[$i],
                                        'item_rec' => $item_rec[$i],
                                    ];

                                    $insert_temp_vals = $this->pageModel->insert_temp_vals_new($data);

                                    $j++;
                                }
                        }

                    }

                    $all_cust = $this->pageModel->all_cust();

                    $all_mod = $this->pageModel->all_mod();

                    $data=[

                        'all_cust' => $all_cust,
                        'all_mod' => $all_mod,
                        'date_val' => 1,
                        'customize_customer' => 1,
                        'customize_models' => '',
                        'customer_list' => $customer_list
                    ];

                    $this->view('pages/customerwise_sales_report5P',$data);

                }
                elseif(!empty($_POST['customer_list']) && !empty($_POST['model_list']))
                {
                    $customer_list = $_POST['customer_list'];

                    $model_list = $_POST['model_list'];

                    $from_date= $_POST['from_date'];

                    $to_date= $_POST['to_date'];               

                    $type_arr = array();

                    $model_arr = array();
                    $catagory_arr = array();

                    $size_arr = array();
                    $color_arr = array();
                    
                    foreach ($customer_list as $cu_list)
                    {
                    
                        $get_stock_by_date = $this->pageModel->get_direct_package_by_date_cust($from_date, $to_date, $cu_list);

                        foreach ($get_stock_by_date as $key_di) 
                        {

                                $item_id = explode("|||", $key_di->item_id);

                                $item_qty = explode("|||", $key_di->item_qty);

                                $item_rec = explode("|||", $key_di->item_rec);

                                $j = 0;

                                for ($i=0; $i <sizeof($item_id); $i++) 
                                {
                                    $s_item = $this->pageModel->get_item_by_id($item_id[$i]);
                                    $type_arr[$j] = $s_item->type_id;
                                    $model_arr[$j] = $s_item->model_id;
                                    $catagory_arr[$j] = $s_item->category_new_id;
                                    $size_arr[$j] = $s_item->size_id;
                                    $color_arr[$j] = $s_item->color_id;
                                    $data = [
                                        'customer_id' => $key_di->customer_id,
                                        'item_id' => $item_id[$i],
                                        'type_id' => $s_item->type_id,
                                        'model_id' => $s_item->model_id,
                                        'category_new_id' => $s_item->category_new_id,
                                        'size_id' => $s_item->size_id,
                                        'color_id' => $s_item->color_id,
                                        'item_qty' => $item_qty[$i],
                                        'item_rec' => $item_rec[$i],
                                    ];

                                    $insert_temp_vals = $this->pageModel->insert_temp_vals_new($data);

                                    $j++;
                                }
                            

                        }

                    }

                    $all_cust = $this->pageModel->all_cust();

                    $all_mod = $this->pageModel->all_mod();

                    $data=[

                        'all_cust' => $all_cust,
                        'all_mod' => $all_mod,
                        'date_val' => 1,
                        'customize_customer' => 1,
                        'customize_models' => 1,
                        'customer_list' => $customer_list,
                        'model_list' => $model_list
                    ];

                    $this->view('pages/customerwise_sales_report5P',$data);                
                }

            }
            else
            {
                redirect('pages/customerwise_sales_report2_time_p');
            }
        }   
    }

    public function customerwise_sales_report2()
    {
        $this->pageModel->delete_sales_report_temp_new(); 
        redirect('pages/customerwise_sales_report2_');
    }
    public function customerwise_sales_report2_print()
    {
        $this->pageModel->delete_sales_report_temp_new(); 
        redirect('pages/customerwise_sales_report2print_');
    }

    public function customerwise_sales_report2p()
    {
        $this->pageModel->delete_sales_report_temp_new(); 
        redirect('pages/customerwise_sales_report2_p');
    }
     public function customerwise_sales_report2p_print()
    {
        $this->pageModel->delete_sales_report_temp_new(); 
        redirect('pages/customerwise_sales_report2_p_print');
    }


    public function customerwise_sales_report2_()
    {

        $all_data = $this->pageModel->check_data_exsist(); 

        if(empty($all_data))
        {
            $type_arr = array();

            $model_arr = array();
            $catagory_arr = array();

            $size_arr = array();
            $color_arr = array();
            

            $distinct_cust_id = $this->pageModel->get_distinct_stock_out();

            foreach ($distinct_cust_id as $key_di) 
            {

                $cp_cust = $this->pageModel->get_all_customer_cp_priority($key_di->customer_id);
                if($_SESSION['ctype'] == 3)
                {
                    $st = $this->pageModel->get_all_stockout_by_custid($key_di->customer_id); 
                    foreach ($st as $k) 
                    { 

                        $sto = $this->pageModel->get_all_stockoutorder_by_id($k->id);

                        $item_id = explode("|||", $sto->item_id);

                        $item_qty = explode("|||", $sto->item_qty);

                        $item_rec = explode("|||", $sto->item_rec);

                        $j = 0;

                        for ($i=0; $i <sizeof($item_id); $i++) 
                        {
                            $s_item = $this->pageModel->get_item_by_id($item_id[$i]);

                            $type_arr[$j] = $s_item->type_id;
                            $model_arr[$j] = $s_item->model_id;
                            $catagory_arr[$j] = $s_item->category_new_id;

                            $size_arr[$j] = $s_item->size_id;
                            $color_arr[$j] = $s_item->color_id;

                            $data = [

                                'customer_id' => $key_di->customer_id,
                                'item_id' => $item_id[$i],
                                'type_id' => $s_item->type_id,
                                'model_id' => $s_item->model_id,
                                'category_new_id' => $s_item->category_new_id,
                                'size_id' => $s_item->size_id,
                                'color_id' => $s_item->color_id,
                                'item_qty' => $item_qty[$i],
                                'item_rec' => $item_rec[$i],
                            ];

                            $insert_temp_vals = $this->pageModel->insert_temp_vals_new($data);

                            $j++;
                        }
                    }    
                }elseif($_SESSION['ctype'] == 1)
                {
                    if($cp_cust->cp_priority==1)
                    {
                        $st = $this->pageModel->get_all_stockout_by_custid($key_di->customer_id); 
                        foreach ($st as $k) 
                        { 

                            $sto = $this->pageModel->get_all_stockoutorder_by_id($k->id);

                            $item_id = explode("|||", $sto->item_id);

                            $item_qty = explode("|||", $sto->item_qty);

                            $item_rec = explode("|||", $sto->item_rec);

                            $j = 0;

                            for ($i=0; $i <sizeof($item_id); $i++) 
                            {
                                $s_item = $this->pageModel->get_item_by_id($item_id[$i]);

                                $type_arr[$j] = $s_item->type_id;
                                $model_arr[$j] = $s_item->model_id;
                                $catagory_arr[$j] = $s_item->category_new_id;

                                $size_arr[$j] = $s_item->size_id;
                                $color_arr[$j] = $s_item->color_id;

                                $data = [

                                    'customer_id' => $key_di->customer_id,
                                    'item_id' => $item_id[$i],
                                    'type_id' => $s_item->type_id,
                                    'model_id' => $s_item->model_id,
                                    'category_new_id' => $s_item->category_new_id,
                                    'size_id' => $s_item->size_id,
                                    'color_id' => $s_item->color_id,
                                    'item_qty' => $item_qty[$i],
                                    'item_rec' => $item_rec[$i],
                                ];

                                $insert_temp_vals = $this->pageModel->insert_temp_vals_new($data);

                                $j++;
                            }
                        } 
                    }
                }
                elseif($_SESSION['ctype'] == 4)
                {
                    if($cp_cust->cp_priority==4)
                    {
                        $st = $this->pageModel->get_all_stockout_by_custid($key_di->customer_id); 
                        foreach ($st as $k) 
                        { 

                            $sto = $this->pageModel->get_all_stockoutorder_by_id($k->id);

                            $item_id = explode("|||", $sto->item_id);

                            $item_qty = explode("|||", $sto->item_qty);

                            $item_rec = explode("|||", $sto->item_rec);

                            $j = 0;

                            for ($i=0; $i <sizeof($item_id); $i++) 
                            {
                                $s_item = $this->pageModel->get_item_by_id($item_id[$i]);

                                $type_arr[$j] = $s_item->type_id;
                                $model_arr[$j] = $s_item->model_id;
                                $catagory_arr[$j] = $s_item->category_new_id;

                                $size_arr[$j] = $s_item->size_id;
                                $color_arr[$j] = $s_item->color_id;

                                $data = [

                                    'customer_id' => $key_di->customer_id,
                                    'item_id' => $item_id[$i],
                                    'type_id' => $s_item->type_id,
                                    'model_id' => $s_item->model_id,
                                    'category_new_id' => $s_item->category_new_id,
                                    'size_id' => $s_item->size_id,
                                    'color_id' => $s_item->color_id,
                                    'item_qty' => $item_qty[$i],
                                    'item_rec' => $item_rec[$i],
                                ];

                                $insert_temp_vals = $this->pageModel->insert_temp_vals_new($data);

                                $j++;
                            }
                        } 
                    }
                }
                elseif($_SESSION['ctype'] == 5)
                {
                    if($cp_cust->cp_priority==5)
                    {
                        $st = $this->pageModel->get_all_stockout_by_custid($key_di->customer_id); 
                        foreach ($st as $k) 
                        { 

                            $sto = $this->pageModel->get_all_stockoutorder_by_id($k->id);

                            $item_id = explode("|||", $sto->item_id);

                            $item_qty = explode("|||", $sto->item_qty);

                            $item_rec = explode("|||", $sto->item_rec);

                            $j = 0;

                            for ($i=0; $i <sizeof($item_id); $i++) 
                            {
                                $s_item = $this->pageModel->get_item_by_id($item_id[$i]);

                                $type_arr[$j] = $s_item->type_id;
                                $model_arr[$j] = $s_item->model_id;
                                $catagory_arr[$j] = $s_item->category_new_id;

                                $size_arr[$j] = $s_item->size_id;
                                $color_arr[$j] = $s_item->color_id;

                                $data = [

                                    'customer_id' => $key_di->customer_id,
                                    'item_id' => $item_id[$i],
                                    'type_id' => $s_item->type_id,
                                    'model_id' => $s_item->model_id,
                                    'category_new_id' => $s_item->category_new_id,
                                    'size_id' => $s_item->size_id,
                                    'color_id' => $s_item->color_id,
                                    'item_qty' => $item_qty[$i],
                                    'item_rec' => $item_rec[$i],
                                ];

                                $insert_temp_vals = $this->pageModel->insert_temp_vals_new($data);

                                $j++;
                            }
                        } 
                    }
                }
                elseif($_SESSION['ctype'] == 6)
                {
                    if($cp_cust->cp_priority==6)
                    {
                        $st = $this->pageModel->get_all_stockout_by_custid($key_di->customer_id); 
                        foreach ($st as $k) 
                        { 

                            $sto = $this->pageModel->get_all_stockoutorder_by_id($k->id);

                            $item_id = explode("|||", $sto->item_id);

                            $item_qty = explode("|||", $sto->item_qty);

                            $item_rec = explode("|||", $sto->item_rec);

                            $j = 0;

                            for ($i=0; $i <sizeof($item_id); $i++) 
                            {
                                $s_item = $this->pageModel->get_item_by_id($item_id[$i]);

                                $type_arr[$j] = $s_item->type_id;
                                $model_arr[$j] = $s_item->model_id;
                                $catagory_arr[$j] = $s_item->category_new_id;

                                $size_arr[$j] = $s_item->size_id;
                                $color_arr[$j] = $s_item->color_id;

                                $data = [

                                    'customer_id' => $key_di->customer_id,
                                    'item_id' => $item_id[$i],
                                    'type_id' => $s_item->type_id,
                                    'model_id' => $s_item->model_id,
                                    'category_new_id' => $s_item->category_new_id,
                                    'size_id' => $s_item->size_id,
                                    'color_id' => $s_item->color_id,
                                    'item_qty' => $item_qty[$i],
                                    'item_rec' => $item_rec[$i],
                                ];

                                $insert_temp_vals = $this->pageModel->insert_temp_vals_new($data);

                                $j++;
                            }
                        } 
                    }
                }
                elseif($_SESSION['ctype'] == 7)
                {
                    if($cp_cust->cp_priority==7)
                    {
                        $st = $this->pageModel->get_all_stockout_by_custid($key_di->customer_id); 
                        foreach ($st as $k) 
                        { 

                            $sto = $this->pageModel->get_all_stockoutorder_by_id($k->id);

                            $item_id = explode("|||", $sto->item_id);

                            $item_qty = explode("|||", $sto->item_qty);

                            $item_rec = explode("|||", $sto->item_rec);

                            $j = 0;

                            for ($i=0; $i <sizeof($item_id); $i++) 
                            {
                                $s_item = $this->pageModel->get_item_by_id($item_id[$i]);

                                $type_arr[$j] = $s_item->type_id;
                                $model_arr[$j] = $s_item->model_id;
                                $catagory_arr[$j] = $s_item->category_new_id;

                                $size_arr[$j] = $s_item->size_id;
                                $color_arr[$j] = $s_item->color_id;

                                $data = [

                                    'customer_id' => $key_di->customer_id,
                                    'item_id' => $item_id[$i],
                                    'type_id' => $s_item->type_id,
                                    'model_id' => $s_item->model_id,
                                    'category_new_id' => $s_item->category_new_id,
                                    'size_id' => $s_item->size_id,
                                    'color_id' => $s_item->color_id,
                                    'item_qty' => $item_qty[$i],
                                    'item_rec' => $item_rec[$i],
                                ];

                                $insert_temp_vals = $this->pageModel->insert_temp_vals_new($data);

                                $j++;
                            }
                        } 
                    }
                }
                elseif($_SESSION['ctype'] == 8)
                {
                    if($cp_cust->cp_priority==8)
                    {
                        $st = $this->pageModel->get_all_stockout_by_custid($key_di->customer_id); 
                        foreach ($st as $k) 
                        { 

                            $sto = $this->pageModel->get_all_stockoutorder_by_id($k->id);

                            $item_id = explode("|||", $sto->item_id);

                            $item_qty = explode("|||", $sto->item_qty);

                            $item_rec = explode("|||", $sto->item_rec);

                            $j = 0;

                            for ($i=0; $i <sizeof($item_id); $i++) 
                            {
                                $s_item = $this->pageModel->get_item_by_id($item_id[$i]);

                                $type_arr[$j] = $s_item->type_id;
                                $model_arr[$j] = $s_item->model_id;
                                $catagory_arr[$j] = $s_item->category_new_id;

                                $size_arr[$j] = $s_item->size_id;
                                $color_arr[$j] = $s_item->color_id;

                                $data = [

                                    'customer_id' => $key_di->customer_id,
                                    'item_id' => $item_id[$i],
                                    'type_id' => $s_item->type_id,
                                    'model_id' => $s_item->model_id,
                                    'category_new_id' => $s_item->category_new_id,
                                    'size_id' => $s_item->size_id,
                                    'color_id' => $s_item->color_id,
                                    'item_qty' => $item_qty[$i],
                                    'item_rec' => $item_rec[$i],
                                ];

                                $insert_temp_vals = $this->pageModel->insert_temp_vals_new($data);

                                $j++;
                            }
                        } 
                    }
                }
                elseif($_SESSION['ctype'] == 9)
                {
                    if($cp_cust->cp_priority==9)
                    {
                        $st = $this->pageModel->get_all_stockout_by_custid($key_di->customer_id); 
                        foreach ($st as $k) 
                        { 

                            $sto = $this->pageModel->get_all_stockoutorder_by_id($k->id);

                            $item_id = explode("|||", $sto->item_id);

                            $item_qty = explode("|||", $sto->item_qty);

                            $item_rec = explode("|||", $sto->item_rec);

                            $j = 0;

                            for ($i=0; $i <sizeof($item_id); $i++) 
                            {
                                $s_item = $this->pageModel->get_item_by_id($item_id[$i]);

                                $type_arr[$j] = $s_item->type_id;
                                $model_arr[$j] = $s_item->model_id;
                                $catagory_arr[$j] = $s_item->category_new_id;

                                $size_arr[$j] = $s_item->size_id;
                                $color_arr[$j] = $s_item->color_id;

                                $data = [

                                    'customer_id' => $key_di->customer_id,
                                    'item_id' => $item_id[$i],
                                    'type_id' => $s_item->type_id,
                                    'model_id' => $s_item->model_id,
                                    'category_new_id' => $s_item->category_new_id,
                                    'size_id' => $s_item->size_id,
                                    'color_id' => $s_item->color_id,
                                    'item_qty' => $item_qty[$i],
                                    'item_rec' => $item_rec[$i],
                                ];

                                $insert_temp_vals = $this->pageModel->insert_temp_vals_new($data);

                                $j++;
                            }
                        } 
                    }
                }
                else
                {
                    if($cp_cust->cp_priority==0)
                    {
                        $st = $this->pageModel->get_all_stockout_by_custid($key_di->customer_id); 
                        foreach ($st as $k) 
                        { 

                            $sto = $this->pageModel->get_all_stockoutorder_by_id($k->id);

                            $item_id = explode("|||", $sto->item_id);

                            $item_qty = explode("|||", $sto->item_qty);

                            $item_rec = explode("|||", $sto->item_rec);

                            $j = 0;

                            for ($i=0; $i <sizeof($item_id); $i++) 
                            {
                                $s_item = $this->pageModel->get_item_by_id($item_id[$i]);

                                $type_arr[$j] = $s_item->type_id;
                                $model_arr[$j] = $s_item->model_id;
                                $catagory_arr[$j] = $s_item->category_new_id;

                                $size_arr[$j] = $s_item->size_id;
                                $color_arr[$j] = $s_item->color_id;

                                $data = [

                                    'customer_id' => $key_di->customer_id,
                                    'item_id' => $item_id[$i],
                                    'type_id' => $s_item->type_id,
                                    'model_id' => $s_item->model_id,
                                    'category_new_id' => $s_item->category_new_id,
                                    'size_id' => $s_item->size_id,
                                    'color_id' => $s_item->color_id,
                                    'item_qty' => $item_qty[$i],
                                    'item_rec' => $item_rec[$i],
                                ];

                                $insert_temp_vals = $this->pageModel->insert_temp_vals_new($data);

                                $j++;
                            }
                        }
                    }
                }

            }

            $data=[

                'date_val' => 1
            ];

            $this->view('pages/customerwise_sales_report4',$data);
        }
        else
        {
            redirect('pages/customerwise_sales_report2');
        }       

    }
     public function customerwise_sales_report2print_()
    {

        $all_data = $this->pageModel->check_data_exsist(); 

        if(empty($all_data))
        {
            $type_arr = array();

            $model_arr = array();
            $catagory_arr = array();

            $size_arr = array();
            $color_arr = array();
            

            $distinct_cust_id = $this->pageModel->get_distinct_stock_out();

            foreach ($distinct_cust_id as $key_di) 
            {

                $cp_cust = $this->pageModel->get_all_customer_cp_priority($key_di->customer_id);
                if($_SESSION['ctype'] == 3)
                {
                    $st = $this->pageModel->get_all_stockout_by_custid($key_di->customer_id); 
                    foreach ($st as $k) 
                    { 

                        $sto = $this->pageModel->get_all_stockoutorder_by_id($k->id);

                        $item_id = explode("|||", $sto->item_id);

                        $item_qty = explode("|||", $sto->item_qty);

                        $item_rec = explode("|||", $sto->item_rec);

                        $j = 0;

                        for ($i=0; $i <sizeof($item_id); $i++) 
                        {
                            $s_item = $this->pageModel->get_item_by_id($item_id[$i]);

                            $type_arr[$j] = $s_item->type_id;
                            $model_arr[$j] = $s_item->model_id;
                            $catagory_arr[$j] = $s_item->category_new_id;

                            $size_arr[$j] = $s_item->size_id;
                            $color_arr[$j] = $s_item->color_id;

                            $data = [

                                'customer_id' => $key_di->customer_id,
                                'item_id' => $item_id[$i],
                                'type_id' => $s_item->type_id,
                                'model_id' => $s_item->model_id,
                                'category_new_id' => $s_item->category_new_id,
                                'size_id' => $s_item->size_id,
                                'color_id' => $s_item->color_id,
                                'item_qty' => $item_qty[$i],
                                'item_rec' => $item_rec[$i],
                            ];

                            $insert_temp_vals = $this->pageModel->insert_temp_vals_new($data);

                            $j++;
                        }
                    }    
                }elseif($_SESSION['ctype'] == 1)
                {
                    if($cp_cust->cp_priority==1)
                    {
                        $st = $this->pageModel->get_all_stockout_by_custid($key_di->customer_id); 
                        foreach ($st as $k) 
                        { 

                            $sto = $this->pageModel->get_all_stockoutorder_by_id($k->id);

                            $item_id = explode("|||", $sto->item_id);

                            $item_qty = explode("|||", $sto->item_qty);

                            $item_rec = explode("|||", $sto->item_rec);

                            $j = 0;

                            for ($i=0; $i <sizeof($item_id); $i++) 
                            {
                                $s_item = $this->pageModel->get_item_by_id($item_id[$i]);

                                $type_arr[$j] = $s_item->type_id;
                                $model_arr[$j] = $s_item->model_id;
                                $catagory_arr[$j] = $s_item->category_new_id;

                                $size_arr[$j] = $s_item->size_id;
                                $color_arr[$j] = $s_item->color_id;

                                $data = [

                                    'customer_id' => $key_di->customer_id,
                                    'item_id' => $item_id[$i],
                                    'type_id' => $s_item->type_id,
                                    'model_id' => $s_item->model_id,
                                    'category_new_id' => $s_item->category_new_id,
                                    'size_id' => $s_item->size_id,
                                    'color_id' => $s_item->color_id,
                                    'item_qty' => $item_qty[$i],
                                    'item_rec' => $item_rec[$i],
                                ];

                                $insert_temp_vals = $this->pageModel->insert_temp_vals_new($data);

                                $j++;
                            }
                        } 
                    }
                }
                elseif($_SESSION['ctype'] == 4)
                {
                    if($cp_cust->cp_priority==4)
                    {
                        $st = $this->pageModel->get_all_stockout_by_custid($key_di->customer_id); 
                        foreach ($st as $k) 
                        { 

                            $sto = $this->pageModel->get_all_stockoutorder_by_id($k->id);

                            $item_id = explode("|||", $sto->item_id);

                            $item_qty = explode("|||", $sto->item_qty);

                            $item_rec = explode("|||", $sto->item_rec);

                            $j = 0;

                            for ($i=0; $i <sizeof($item_id); $i++) 
                            {
                                $s_item = $this->pageModel->get_item_by_id($item_id[$i]);

                                $type_arr[$j] = $s_item->type_id;
                                $model_arr[$j] = $s_item->model_id;
                                $catagory_arr[$j] = $s_item->category_new_id;

                                $size_arr[$j] = $s_item->size_id;
                                $color_arr[$j] = $s_item->color_id;

                                $data = [

                                    'customer_id' => $key_di->customer_id,
                                    'item_id' => $item_id[$i],
                                    'type_id' => $s_item->type_id,
                                    'model_id' => $s_item->model_id,
                                    'category_new_id' => $s_item->category_new_id,
                                    'size_id' => $s_item->size_id,
                                    'color_id' => $s_item->color_id,
                                    'item_qty' => $item_qty[$i],
                                    'item_rec' => $item_rec[$i],
                                ];

                                $insert_temp_vals = $this->pageModel->insert_temp_vals_new($data);

                                $j++;
                            }
                        } 
                    }
                }
                elseif($_SESSION['ctype'] == 5)
                {
                    if($cp_cust->cp_priority==5)
                    {
                        $st = $this->pageModel->get_all_stockout_by_custid($key_di->customer_id); 
                        foreach ($st as $k) 
                        { 

                            $sto = $this->pageModel->get_all_stockoutorder_by_id($k->id);

                            $item_id = explode("|||", $sto->item_id);

                            $item_qty = explode("|||", $sto->item_qty);

                            $item_rec = explode("|||", $sto->item_rec);

                            $j = 0;

                            for ($i=0; $i <sizeof($item_id); $i++) 
                            {
                                $s_item = $this->pageModel->get_item_by_id($item_id[$i]);

                                $type_arr[$j] = $s_item->type_id;
                                $model_arr[$j] = $s_item->model_id;
                                $catagory_arr[$j] = $s_item->category_new_id;

                                $size_arr[$j] = $s_item->size_id;
                                $color_arr[$j] = $s_item->color_id;

                                $data = [

                                    'customer_id' => $key_di->customer_id,
                                    'item_id' => $item_id[$i],
                                    'type_id' => $s_item->type_id,
                                    'model_id' => $s_item->model_id,
                                    'category_new_id' => $s_item->category_new_id,
                                    'size_id' => $s_item->size_id,
                                    'color_id' => $s_item->color_id,
                                    'item_qty' => $item_qty[$i],
                                    'item_rec' => $item_rec[$i],
                                ];

                                $insert_temp_vals = $this->pageModel->insert_temp_vals_new($data);

                                $j++;
                            }
                        } 
                    }
                }
                elseif($_SESSION['ctype'] == 6)
                {
                    if($cp_cust->cp_priority==6)
                    {
                        $st = $this->pageModel->get_all_stockout_by_custid($key_di->customer_id); 
                        foreach ($st as $k) 
                        { 

                            $sto = $this->pageModel->get_all_stockoutorder_by_id($k->id);

                            $item_id = explode("|||", $sto->item_id);

                            $item_qty = explode("|||", $sto->item_qty);

                            $item_rec = explode("|||", $sto->item_rec);

                            $j = 0;

                            for ($i=0; $i <sizeof($item_id); $i++) 
                            {
                                $s_item = $this->pageModel->get_item_by_id($item_id[$i]);

                                $type_arr[$j] = $s_item->type_id;
                                $model_arr[$j] = $s_item->model_id;
                                $catagory_arr[$j] = $s_item->category_new_id;

                                $size_arr[$j] = $s_item->size_id;
                                $color_arr[$j] = $s_item->color_id;

                                $data = [

                                    'customer_id' => $key_di->customer_id,
                                    'item_id' => $item_id[$i],
                                    'type_id' => $s_item->type_id,
                                    'model_id' => $s_item->model_id,
                                    'category_new_id' => $s_item->category_new_id,
                                    'size_id' => $s_item->size_id,
                                    'color_id' => $s_item->color_id,
                                    'item_qty' => $item_qty[$i],
                                    'item_rec' => $item_rec[$i],
                                ];

                                $insert_temp_vals = $this->pageModel->insert_temp_vals_new($data);

                                $j++;
                            }
                        } 
                    }
                }
                elseif($_SESSION['ctype'] == 7)
                {
                    if($cp_cust->cp_priority==7)
                    {
                        $st = $this->pageModel->get_all_stockout_by_custid($key_di->customer_id); 
                        foreach ($st as $k) 
                        { 

                            $sto = $this->pageModel->get_all_stockoutorder_by_id($k->id);

                            $item_id = explode("|||", $sto->item_id);

                            $item_qty = explode("|||", $sto->item_qty);

                            $item_rec = explode("|||", $sto->item_rec);

                            $j = 0;

                            for ($i=0; $i <sizeof($item_id); $i++) 
                            {
                                $s_item = $this->pageModel->get_item_by_id($item_id[$i]);

                                $type_arr[$j] = $s_item->type_id;
                                $model_arr[$j] = $s_item->model_id;
                                $catagory_arr[$j] = $s_item->category_new_id;

                                $size_arr[$j] = $s_item->size_id;
                                $color_arr[$j] = $s_item->color_id;

                                $data = [

                                    'customer_id' => $key_di->customer_id,
                                    'item_id' => $item_id[$i],
                                    'type_id' => $s_item->type_id,
                                    'model_id' => $s_item->model_id,
                                    'category_new_id' => $s_item->category_new_id,
                                    'size_id' => $s_item->size_id,
                                    'color_id' => $s_item->color_id,
                                    'item_qty' => $item_qty[$i],
                                    'item_rec' => $item_rec[$i],
                                ];

                                $insert_temp_vals = $this->pageModel->insert_temp_vals_new($data);

                                $j++;
                            }
                        } 
                    }
                }
                elseif($_SESSION['ctype'] == 8)
                {
                    if($cp_cust->cp_priority==8)
                    {
                        $st = $this->pageModel->get_all_stockout_by_custid($key_di->customer_id); 
                        foreach ($st as $k) 
                        { 

                            $sto = $this->pageModel->get_all_stockoutorder_by_id($k->id);

                            $item_id = explode("|||", $sto->item_id);

                            $item_qty = explode("|||", $sto->item_qty);

                            $item_rec = explode("|||", $sto->item_rec);

                            $j = 0;

                            for ($i=0; $i <sizeof($item_id); $i++) 
                            {
                                $s_item = $this->pageModel->get_item_by_id($item_id[$i]);

                                $type_arr[$j] = $s_item->type_id;
                                $model_arr[$j] = $s_item->model_id;
                                $catagory_arr[$j] = $s_item->category_new_id;

                                $size_arr[$j] = $s_item->size_id;
                                $color_arr[$j] = $s_item->color_id;

                                $data = [

                                    'customer_id' => $key_di->customer_id,
                                    'item_id' => $item_id[$i],
                                    'type_id' => $s_item->type_id,
                                    'model_id' => $s_item->model_id,
                                    'category_new_id' => $s_item->category_new_id,
                                    'size_id' => $s_item->size_id,
                                    'color_id' => $s_item->color_id,
                                    'item_qty' => $item_qty[$i],
                                    'item_rec' => $item_rec[$i],
                                ];

                                $insert_temp_vals = $this->pageModel->insert_temp_vals_new($data);

                                $j++;
                            }
                        } 
                    }
                }
                elseif($_SESSION['ctype'] == 9)
                {
                    if($cp_cust->cp_priority==9)
                    {
                        $st = $this->pageModel->get_all_stockout_by_custid($key_di->customer_id); 
                        foreach ($st as $k) 
                        { 

                            $sto = $this->pageModel->get_all_stockoutorder_by_id($k->id);

                            $item_id = explode("|||", $sto->item_id);

                            $item_qty = explode("|||", $sto->item_qty);

                            $item_rec = explode("|||", $sto->item_rec);

                            $j = 0;

                            for ($i=0; $i <sizeof($item_id); $i++) 
                            {
                                $s_item = $this->pageModel->get_item_by_id($item_id[$i]);

                                $type_arr[$j] = $s_item->type_id;
                                $model_arr[$j] = $s_item->model_id;
                                $catagory_arr[$j] = $s_item->category_new_id;

                                $size_arr[$j] = $s_item->size_id;
                                $color_arr[$j] = $s_item->color_id;

                                $data = [

                                    'customer_id' => $key_di->customer_id,
                                    'item_id' => $item_id[$i],
                                    'type_id' => $s_item->type_id,
                                    'model_id' => $s_item->model_id,
                                    'category_new_id' => $s_item->category_new_id,
                                    'size_id' => $s_item->size_id,
                                    'color_id' => $s_item->color_id,
                                    'item_qty' => $item_qty[$i],
                                    'item_rec' => $item_rec[$i],
                                ];

                                $insert_temp_vals = $this->pageModel->insert_temp_vals_new($data);

                                $j++;
                            }
                        } 
                    }
                }
                else
                {
                    if($cp_cust->cp_priority==0)
                    {
                        $st = $this->pageModel->get_all_stockout_by_custid($key_di->customer_id); 
                        foreach ($st as $k) 
                        { 
                            $sto = $this->pageModel->get_all_stockoutorder_by_id($k->id);
                            $item_id = explode("|||", $sto->item_id);
                            $item_qty = explode("|||", $sto->item_qty);
                            $item_rec = explode("|||", $sto->item_rec);
                            $j = 0;
                            for ($i=0; $i <sizeof($item_id); $i++) 
                            {
                                $s_item = $this->pageModel->get_item_by_id($item_id[$i]);

                                $type_arr[$j] = $s_item->type_id;
                                $model_arr[$j] = $s_item->model_id;
                                $catagory_arr[$j] = $s_item->category_new_id;

                                $size_arr[$j] = $s_item->size_id;
                                $color_arr[$j] = $s_item->color_id;

                                $data = [

                                    'customer_id' => $key_di->customer_id,
                                    'item_id' => $item_id[$i],
                                    'type_id' => $s_item->type_id,
                                    'model_id' => $s_item->model_id,
                                    'category_new_id' => $s_item->category_new_id,
                                    'size_id' => $s_item->size_id,
                                    'color_id' => $s_item->color_id,
                                    'item_qty' => $item_qty[$i],
                                    'item_rec' => $item_rec[$i],
                                ];
                            $insert_temp_vals = $this->pageModel->insert_temp_vals_new($data);
                                $j++;
                            }
                        }
                    }
                }
            }
            $data=[

                'date_val' => 1
            ];
            $this->view('pages/customerwise_sales_report4print',$data);
        }
        else
        {
            redirect('pages/customerwise_sales_report2_print');
        }       

    }
    public function customerwise_sales_report2_p()
    {

        $all_data = $this->pageModel->check_data_exsist(); 

        if(empty($all_data))
        {
            $type_arr = array();

            $model_arr = array();
            $catagory_arr = array();

            $size_arr = array();
            $color_arr = array();
            

            $distinct_cust_id = $this->pageModel->get_distinct_direct_package_out();
            foreach ($distinct_cust_id as $key_di) 
            {
                $cp_cust = $this->pageModel->get_all_customer_cp_priority($key_di->customer_id);
                if($_SESSION['ctype'] == 3)
                {
                    $st = $this->pageModel->get_all_direct_pack_by_custid($key_di->customer_id); 
                    foreach ($st as $k) 
                    { 

                        $sto = $k;

                        $item_id = explode("|||", $sto->item_id);

                        $item_qty = explode("|||", $sto->item_qty);

                        $item_rec = explode("|||", $sto->item_rec);

                        $j = 0;

                        for ($i=0; $i <sizeof($item_id); $i++) 
                        {
                            $s_item = $this->pageModel->get_item_by_id($item_id[$i]);

                            $type_arr[$j] = $s_item->type_id;
                            $model_arr[$j] = $s_item->model_id;
                            $catagory_arr[$j] = $s_item->category_new_id;

                            $size_arr[$j] = $s_item->size_id;
                            $color_arr[$j] = $s_item->color_id;
                            $data = [

                                'customer_id' => $key_di->customer_id,
                                'item_id' => $item_id[$i],
                                'type_id' => $s_item->type_id,
                                'model_id' => $s_item->model_id,
                                'category_new_id' => $s_item->category_new_id,
                                'size_id' => $s_item->size_id,
                                'color_id' => $s_item->color_id,
                                'item_qty' => $item_qty[$i],
                                'item_rec' => $item_rec[$i],
                            ];

                            $insert_temp_vals = $this->pageModel->insert_temp_vals_new($data);

                            $j++;
                        }
                    }    
                }elseif($_SESSION['ctype'] == 1)
                {
                    if($cp_cust->cp_priority==1)
                    {
                        $st = $this->pageModel->get_all_direct_pack_by_custid($key_di->customer_id); 
                        foreach ($st as $k) 
                        { 

                            $sto = $k;

                            $item_id = explode("|||", $sto->item_id);

                            $item_qty = explode("|||", $sto->item_qty);

                            $item_rec = explode("|||", $sto->item_rec);

                            $j = 0;

                            for ($i=0; $i <sizeof($item_id); $i++) 
                            {
                                $s_item = $this->pageModel->get_item_by_id($item_id[$i]);

                                $type_arr[$j] = $s_item->type_id;
                                $model_arr[$j] = $s_item->model_id;
                                $catagory_arr[$j] = $s_item->category_new_id;

                                $size_arr[$j] = $s_item->size_id;
                                $color_arr[$j] = $s_item->color_id;
                                $data = [

                                    'customer_id' => $key_di->customer_id,
                                    'item_id' => $item_id[$i],
                                    'type_id' => $s_item->type_id,
                                    'model_id' => $s_item->model_id,
                                    'category_new_id' => $s_item->category_new_id,
                                    'size_id' => $s_item->size_id,
                                    'color_id' => $s_item->color_id,
                                    'item_qty' => $item_qty[$i],
                                    'item_rec' => $item_rec[$i],
                                ];

                                $insert_temp_vals = $this->pageModel->insert_temp_vals_new($data);

                                $j++;
                            }
                        }
                    }
                }
                elseif($_SESSION['ctype'] == 4)
                {
                    if($cp_cust->cp_priority==4)
                    {
                        $st = $this->pageModel->get_all_direct_pack_by_custid($key_di->customer_id); 
                        foreach ($st as $k) 
                        { 

                            $sto = $k;

                            $item_id = explode("|||", $sto->item_id);

                            $item_qty = explode("|||", $sto->item_qty);

                            $item_rec = explode("|||", $sto->item_rec);

                            $j = 0;

                            for ($i=0; $i <sizeof($item_id); $i++) 
                            {
                                $s_item = $this->pageModel->get_item_by_id($item_id[$i]);

                                $type_arr[$j] = $s_item->type_id;
                                $model_arr[$j] = $s_item->model_id;
                                $catagory_arr[$j] = $s_item->category_new_id;

                                $size_arr[$j] = $s_item->size_id;
                                $color_arr[$j] = $s_item->color_id;
                                $data = [

                                    'customer_id' => $key_di->customer_id,
                                    'item_id' => $item_id[$i],
                                    'type_id' => $s_item->type_id,
                                    'model_id' => $s_item->model_id,
                                    'category_new_id' => $s_item->category_new_id,
                                    'size_id' => $s_item->size_id,
                                    'color_id' => $s_item->color_id,
                                    'item_qty' => $item_qty[$i],
                                    'item_rec' => $item_rec[$i],
                                ];

                                $insert_temp_vals = $this->pageModel->insert_temp_vals_new($data);

                                $j++;
                            }
                        }
                    }
                }
                elseif($_SESSION['ctype'] == 5)
                {
                    if($cp_cust->cp_priority==5)
                    {
                        $st = $this->pageModel->get_all_direct_pack_by_custid($key_di->customer_id); 
                        foreach ($st as $k) 
                        { 

                            $sto = $k;

                            $item_id = explode("|||", $sto->item_id);

                            $item_qty = explode("|||", $sto->item_qty);

                            $item_rec = explode("|||", $sto->item_rec);

                            $j = 0;

                            for ($i=0; $i <sizeof($item_id); $i++) 
                            {
                                $s_item = $this->pageModel->get_item_by_id($item_id[$i]);

                                $type_arr[$j] = $s_item->type_id;
                                $model_arr[$j] = $s_item->model_id;
                                $catagory_arr[$j] = $s_item->category_new_id;

                                $size_arr[$j] = $s_item->size_id;
                                $color_arr[$j] = $s_item->color_id;
                                $data = [

                                    'customer_id' => $key_di->customer_id,
                                    'item_id' => $item_id[$i],
                                    'type_id' => $s_item->type_id,
                                    'model_id' => $s_item->model_id,
                                    'category_new_id' => $s_item->category_new_id,
                                    'size_id' => $s_item->size_id,
                                    'color_id' => $s_item->color_id,
                                    'item_qty' => $item_qty[$i],
                                    'item_rec' => $item_rec[$i],
                                ];

                                $insert_temp_vals = $this->pageModel->insert_temp_vals_new($data);

                                $j++;
                            }
                        }
                    }
                }
                elseif($_SESSION['ctype'] == 6)
                {
                    if($cp_cust->cp_priority==6)
                    {
                        $st = $this->pageModel->get_all_direct_pack_by_custid($key_di->customer_id); 
                        foreach ($st as $k) 
                        { 

                            $sto = $k;

                            $item_id = explode("|||", $sto->item_id);

                            $item_qty = explode("|||", $sto->item_qty);

                            $item_rec = explode("|||", $sto->item_rec);

                            $j = 0;

                            for ($i=0; $i <sizeof($item_id); $i++) 
                            {
                                $s_item = $this->pageModel->get_item_by_id($item_id[$i]);

                                $type_arr[$j] = $s_item->type_id;
                                $model_arr[$j] = $s_item->model_id;
                                $catagory_arr[$j] = $s_item->category_new_id;

                                $size_arr[$j] = $s_item->size_id;
                                $color_arr[$j] = $s_item->color_id;
                                $data = [

                                    'customer_id' => $key_di->customer_id,
                                    'item_id' => $item_id[$i],
                                    'type_id' => $s_item->type_id,
                                    'model_id' => $s_item->model_id,
                                    'category_new_id' => $s_item->category_new_id,
                                    'size_id' => $s_item->size_id,
                                    'color_id' => $s_item->color_id,
                                    'item_qty' => $item_qty[$i],
                                    'item_rec' => $item_rec[$i],
                                ];

                                $insert_temp_vals = $this->pageModel->insert_temp_vals_new($data);

                                $j++;
                            }
                        }
                    }
                }
                elseif($_SESSION['ctype'] == 7)
                {
                    if($cp_cust->cp_priority==7)
                    {
                        $st = $this->pageModel->get_all_direct_pack_by_custid($key_di->customer_id); 
                        foreach ($st as $k) 
                        { 

                            $sto = $k;

                            $item_id = explode("|||", $sto->item_id);

                            $item_qty = explode("|||", $sto->item_qty);

                            $item_rec = explode("|||", $sto->item_rec);

                            $j = 0;

                            for ($i=0; $i <sizeof($item_id); $i++) 
                            {
                                $s_item = $this->pageModel->get_item_by_id($item_id[$i]);

                                $type_arr[$j] = $s_item->type_id;
                                $model_arr[$j] = $s_item->model_id;
                                $catagory_arr[$j] = $s_item->category_new_id;

                                $size_arr[$j] = $s_item->size_id;
                                $color_arr[$j] = $s_item->color_id;
                                $data = [

                                    'customer_id' => $key_di->customer_id,
                                    'item_id' => $item_id[$i],
                                    'type_id' => $s_item->type_id,
                                    'model_id' => $s_item->model_id,
                                    'category_new_id' => $s_item->category_new_id,
                                    'size_id' => $s_item->size_id,
                                    'color_id' => $s_item->color_id,
                                    'item_qty' => $item_qty[$i],
                                    'item_rec' => $item_rec[$i],
                                ];

                                $insert_temp_vals = $this->pageModel->insert_temp_vals_new($data);

                                $j++;
                            }
                        }
                    }
                }
                elseif($_SESSION['ctype'] == 8)
                {
                    if($cp_cust->cp_priority==8)
                    {
                        $st = $this->pageModel->get_all_direct_pack_by_custid($key_di->customer_id); 
                        foreach ($st as $k) 
                        { 

                            $sto = $k;

                            $item_id = explode("|||", $sto->item_id);

                            $item_qty = explode("|||", $sto->item_qty);

                            $item_rec = explode("|||", $sto->item_rec);

                            $j = 0;

                            for ($i=0; $i <sizeof($item_id); $i++) 
                            {
                                $s_item = $this->pageModel->get_item_by_id($item_id[$i]);

                                $type_arr[$j] = $s_item->type_id;
                                $model_arr[$j] = $s_item->model_id;
                                $catagory_arr[$j] = $s_item->category_new_id;

                                $size_arr[$j] = $s_item->size_id;
                                $color_arr[$j] = $s_item->color_id;
                                $data = [

                                    'customer_id' => $key_di->customer_id,
                                    'item_id' => $item_id[$i],
                                    'type_id' => $s_item->type_id,
                                    'model_id' => $s_item->model_id,
                                    'category_new_id' => $s_item->category_new_id,
                                    'size_id' => $s_item->size_id,
                                    'color_id' => $s_item->color_id,
                                    'item_qty' => $item_qty[$i],
                                    'item_rec' => $item_rec[$i],
                                ];

                                $insert_temp_vals = $this->pageModel->insert_temp_vals_new($data);

                                $j++;
                            }
                        }
                    }
                }
                elseif($_SESSION['ctype'] == 9)
                {
                    if($cp_cust->cp_priority==9)
                    {
                        $st = $this->pageModel->get_all_direct_pack_by_custid($key_di->customer_id); 
                        foreach ($st as $k) 
                        { 

                            $sto = $k;

                            $item_id = explode("|||", $sto->item_id);

                            $item_qty = explode("|||", $sto->item_qty);

                            $item_rec = explode("|||", $sto->item_rec);

                            $j = 0;

                            for ($i=0; $i <sizeof($item_id); $i++) 
                            {
                                $s_item = $this->pageModel->get_item_by_id($item_id[$i]);

                                $type_arr[$j] = $s_item->type_id;
                                $model_arr[$j] = $s_item->model_id;
                                $catagory_arr[$j] = $s_item->category_new_id;

                                $size_arr[$j] = $s_item->size_id;
                                $color_arr[$j] = $s_item->color_id;
                                $data = [

                                    'customer_id' => $key_di->customer_id,
                                    'item_id' => $item_id[$i],
                                    'type_id' => $s_item->type_id,
                                    'model_id' => $s_item->model_id,
                                    'category_new_id' => $s_item->category_new_id,
                                    'size_id' => $s_item->size_id,
                                    'color_id' => $s_item->color_id,
                                    'item_qty' => $item_qty[$i],
                                    'item_rec' => $item_rec[$i],
                                ];

                                $insert_temp_vals = $this->pageModel->insert_temp_vals_new($data);

                                $j++;
                            }
                        }
                    }
                }
                else
                {
                    if($cp_cust->cp_priority==0)
                    {
                        $st = $this->pageModel->get_all_direct_pack_by_custid($key_di->customer_id); 
                        foreach ($st as $k) 
                        { 

                            $sto = $k;

                            $item_id = explode("|||", $sto->item_id);

                            $item_qty = explode("|||", $sto->item_qty);

                            $item_rec = explode("|||", $sto->item_rec);

                            $j = 0;

                            for ($i=0; $i <sizeof($item_id); $i++) 
                            {
                                $s_item = $this->pageModel->get_item_by_id($item_id[$i]);

                                $type_arr[$j] = $s_item->type_id;
                                $model_arr[$j] = $s_item->model_id;
                                $catagory_arr[$j] = $s_item->category_new_id;

                                $size_arr[$j] = $s_item->size_id;
                                $color_arr[$j] = $s_item->color_id;
                                $data = [

                                    'customer_id' => $key_di->customer_id,
                                    'item_id' => $item_id[$i],
                                    'type_id' => $s_item->type_id,
                                    'model_id' => $s_item->model_id,
                                    'category_new_id' => $s_item->category_new_id,
                                    'size_id' => $s_item->size_id,
                                    'color_id' => $s_item->color_id,
                                    'item_qty' => $item_qty[$i],
                                    'item_rec' => $item_rec[$i],
                                ];

                                $insert_temp_vals = $this->pageModel->insert_temp_vals_new($data);

                                $j++;
                            }
                        }
                    }
                }
            }

            $data=[

                'date_val' => 1
            ];

            $this->view('pages/customerwise_sales_report4P',$data);
        }
        else
        {
            redirect('pages/customerwise_sales_report2p');
        }       

    }
     public function customerwise_sales_report2_p_print()
    {

        $all_data = $this->pageModel->check_data_exsist(); 

        if(empty($all_data))
        {
            $type_arr = array();

            $model_arr = array();
            $catagory_arr = array();

            $size_arr = array();
            $color_arr = array();
            

            $distinct_cust_id = $this->pageModel->get_distinct_direct_package_out();
            foreach ($distinct_cust_id as $key_di) 
            {
                $cp_cust = $this->pageModel->get_all_customer_cp_priority($key_di->customer_id);
                if($_SESSION['ctype'] == 3)
                {
                    $st = $this->pageModel->get_all_direct_pack_by_custid($key_di->customer_id); 
                    foreach ($st as $k) 
                    { 

                        $sto = $k;

                        $item_id = explode("|||", $sto->item_id);

                        $item_qty = explode("|||", $sto->item_qty);

                        $item_rec = explode("|||", $sto->item_rec);

                        $j = 0;

                        for ($i=0; $i <sizeof($item_id); $i++) 
                        {
                            $s_item = $this->pageModel->get_item_by_id($item_id[$i]);

                            $type_arr[$j] = $s_item->type_id;
                            $model_arr[$j] = $s_item->model_id;
                            $catagory_arr[$j] = $s_item->category_new_id;

                            $size_arr[$j] = $s_item->size_id;
                            $color_arr[$j] = $s_item->color_id;
                            $data = [

                                'customer_id' => $key_di->customer_id,
                                'item_id' => $item_id[$i],
                                'type_id' => $s_item->type_id,
                                'model_id' => $s_item->model_id,
                                'category_new_id' => $s_item->category_new_id,
                                'size_id' => $s_item->size_id,
                                'color_id' => $s_item->color_id,
                                'item_qty' => $item_qty[$i],
                                'item_rec' => $item_rec[$i],
                            ];

                            $insert_temp_vals = $this->pageModel->insert_temp_vals_new($data);

                            $j++;
                        }
                    }    
                }elseif($_SESSION['ctype'] == 1)
                {
                    if($cp_cust->cp_priority==1)
                    {
                        $st = $this->pageModel->get_all_direct_pack_by_custid($key_di->customer_id); 
                        foreach ($st as $k) 
                        { 

                            $sto = $k;

                            $item_id = explode("|||", $sto->item_id);

                            $item_qty = explode("|||", $sto->item_qty);

                            $item_rec = explode("|||", $sto->item_rec);

                            $j = 0;

                            for ($i=0; $i <sizeof($item_id); $i++) 
                            {
                                $s_item = $this->pageModel->get_item_by_id($item_id[$i]);

                                $type_arr[$j] = $s_item->type_id;
                                $model_arr[$j] = $s_item->model_id;
                                $catagory_arr[$j] = $s_item->category_new_id;

                                $size_arr[$j] = $s_item->size_id;
                                $color_arr[$j] = $s_item->color_id;
                                $data = [

                                    'customer_id' => $key_di->customer_id,
                                    'item_id' => $item_id[$i],
                                    'type_id' => $s_item->type_id,
                                    'model_id' => $s_item->model_id,
                                    'category_new_id' => $s_item->category_new_id,
                                    'size_id' => $s_item->size_id,
                                    'color_id' => $s_item->color_id,
                                    'item_qty' => $item_qty[$i],
                                    'item_rec' => $item_rec[$i],
                                ];

                                $insert_temp_vals = $this->pageModel->insert_temp_vals_new($data);

                                $j++;
                            }
                        }
                    }
                }
                elseif($_SESSION['ctype'] == 4)
                {
                    if($cp_cust->cp_priority==4)
                    {
                        $st = $this->pageModel->get_all_direct_pack_by_custid($key_di->customer_id); 
                        foreach ($st as $k) 
                        { 

                            $sto = $k;

                            $item_id = explode("|||", $sto->item_id);

                            $item_qty = explode("|||", $sto->item_qty);

                            $item_rec = explode("|||", $sto->item_rec);

                            $j = 0;

                            for ($i=0; $i <sizeof($item_id); $i++) 
                            {
                                $s_item = $this->pageModel->get_item_by_id($item_id[$i]);

                                $type_arr[$j] = $s_item->type_id;
                                $model_arr[$j] = $s_item->model_id;
                                $catagory_arr[$j] = $s_item->category_new_id;

                                $size_arr[$j] = $s_item->size_id;
                                $color_arr[$j] = $s_item->color_id;
                                $data = [

                                    'customer_id' => $key_di->customer_id,
                                    'item_id' => $item_id[$i],
                                    'type_id' => $s_item->type_id,
                                    'model_id' => $s_item->model_id,
                                    'category_new_id' => $s_item->category_new_id,
                                    'size_id' => $s_item->size_id,
                                    'color_id' => $s_item->color_id,
                                    'item_qty' => $item_qty[$i],
                                    'item_rec' => $item_rec[$i],
                                ];

                                $insert_temp_vals = $this->pageModel->insert_temp_vals_new($data);

                                $j++;
                            }
                        }
                    }
                }
                elseif($_SESSION['ctype'] == 5)
                {
                    if($cp_cust->cp_priority==5)
                    {
                        $st = $this->pageModel->get_all_direct_pack_by_custid($key_di->customer_id); 
                        foreach ($st as $k) 
                        { 

                            $sto = $k;

                            $item_id = explode("|||", $sto->item_id);

                            $item_qty = explode("|||", $sto->item_qty);

                            $item_rec = explode("|||", $sto->item_rec);

                            $j = 0;

                            for ($i=0; $i <sizeof($item_id); $i++) 
                            {
                                $s_item = $this->pageModel->get_item_by_id($item_id[$i]);

                                $type_arr[$j] = $s_item->type_id;
                                $model_arr[$j] = $s_item->model_id;
                                $catagory_arr[$j] = $s_item->category_new_id;

                                $size_arr[$j] = $s_item->size_id;
                                $color_arr[$j] = $s_item->color_id;
                                $data = [

                                    'customer_id' => $key_di->customer_id,
                                    'item_id' => $item_id[$i],
                                    'type_id' => $s_item->type_id,
                                    'model_id' => $s_item->model_id,
                                    'category_new_id' => $s_item->category_new_id,
                                    'size_id' => $s_item->size_id,
                                    'color_id' => $s_item->color_id,
                                    'item_qty' => $item_qty[$i],
                                    'item_rec' => $item_rec[$i],
                                ];

                                $insert_temp_vals = $this->pageModel->insert_temp_vals_new($data);

                                $j++;
                            }
                        }
                    }
                }
                elseif($_SESSION['ctype'] == 6)
                {
                    if($cp_cust->cp_priority==6)
                    {
                        $st = $this->pageModel->get_all_direct_pack_by_custid($key_di->customer_id); 
                        foreach ($st as $k) 
                        { 

                            $sto = $k;

                            $item_id = explode("|||", $sto->item_id);

                            $item_qty = explode("|||", $sto->item_qty);

                            $item_rec = explode("|||", $sto->item_rec);

                            $j = 0;

                            for ($i=0; $i <sizeof($item_id); $i++) 
                            {
                                $s_item = $this->pageModel->get_item_by_id($item_id[$i]);

                                $type_arr[$j] = $s_item->type_id;
                                $model_arr[$j] = $s_item->model_id;
                                $catagory_arr[$j] = $s_item->category_new_id;

                                $size_arr[$j] = $s_item->size_id;
                                $color_arr[$j] = $s_item->color_id;
                                $data = [

                                    'customer_id' => $key_di->customer_id,
                                    'item_id' => $item_id[$i],
                                    'type_id' => $s_item->type_id,
                                    'model_id' => $s_item->model_id,
                                    'category_new_id' => $s_item->category_new_id,
                                    'size_id' => $s_item->size_id,
                                    'color_id' => $s_item->color_id,
                                    'item_qty' => $item_qty[$i],
                                    'item_rec' => $item_rec[$i],
                                ];

                                $insert_temp_vals = $this->pageModel->insert_temp_vals_new($data);

                                $j++;
                            }
                        }
                    }
                }
                elseif($_SESSION['ctype'] == 7)
                {
                    if($cp_cust->cp_priority==7)
                    {
                        $st = $this->pageModel->get_all_direct_pack_by_custid($key_di->customer_id); 
                        foreach ($st as $k) 
                        { 

                            $sto = $k;

                            $item_id = explode("|||", $sto->item_id);

                            $item_qty = explode("|||", $sto->item_qty);

                            $item_rec = explode("|||", $sto->item_rec);

                            $j = 0;

                            for ($i=0; $i <sizeof($item_id); $i++) 
                            {
                                $s_item = $this->pageModel->get_item_by_id($item_id[$i]);

                                $type_arr[$j] = $s_item->type_id;
                                $model_arr[$j] = $s_item->model_id;
                                $catagory_arr[$j] = $s_item->category_new_id;

                                $size_arr[$j] = $s_item->size_id;
                                $color_arr[$j] = $s_item->color_id;
                                $data = [

                                    'customer_id' => $key_di->customer_id,
                                    'item_id' => $item_id[$i],
                                    'type_id' => $s_item->type_id,
                                    'model_id' => $s_item->model_id,
                                    'category_new_id' => $s_item->category_new_id,
                                    'size_id' => $s_item->size_id,
                                    'color_id' => $s_item->color_id,
                                    'item_qty' => $item_qty[$i],
                                    'item_rec' => $item_rec[$i],
                                ];

                                $insert_temp_vals = $this->pageModel->insert_temp_vals_new($data);

                                $j++;
                            }
                        }
                    }
                }
                elseif($_SESSION['ctype'] == 8)
                {
                    if($cp_cust->cp_priority==8)
                    {
                        $st = $this->pageModel->get_all_direct_pack_by_custid($key_di->customer_id); 
                        foreach ($st as $k) 
                        { 

                            $sto = $k;

                            $item_id = explode("|||", $sto->item_id);

                            $item_qty = explode("|||", $sto->item_qty);

                            $item_rec = explode("|||", $sto->item_rec);

                            $j = 0;

                            for ($i=0; $i <sizeof($item_id); $i++) 
                            {
                                $s_item = $this->pageModel->get_item_by_id($item_id[$i]);

                                $type_arr[$j] = $s_item->type_id;
                                $model_arr[$j] = $s_item->model_id;
                                $catagory_arr[$j] = $s_item->category_new_id;

                                $size_arr[$j] = $s_item->size_id;
                                $color_arr[$j] = $s_item->color_id;
                                $data = [

                                    'customer_id' => $key_di->customer_id,
                                    'item_id' => $item_id[$i],
                                    'type_id' => $s_item->type_id,
                                    'model_id' => $s_item->model_id,
                                    'category_new_id' => $s_item->category_new_id,
                                    'size_id' => $s_item->size_id,
                                    'color_id' => $s_item->color_id,
                                    'item_qty' => $item_qty[$i],
                                    'item_rec' => $item_rec[$i],
                                ];

                                $insert_temp_vals = $this->pageModel->insert_temp_vals_new($data);

                                $j++;
                            }
                        }
                    }
                }
                elseif($_SESSION['ctype'] == 9)
                {
                    if($cp_cust->cp_priority==9)
                    {
                        $st = $this->pageModel->get_all_direct_pack_by_custid($key_di->customer_id); 
                        foreach ($st as $k) 
                        { 

                            $sto = $k;

                            $item_id = explode("|||", $sto->item_id);

                            $item_qty = explode("|||", $sto->item_qty);

                            $item_rec = explode("|||", $sto->item_rec);

                            $j = 0;

                            for ($i=0; $i <sizeof($item_id); $i++) 
                            {
                                $s_item = $this->pageModel->get_item_by_id($item_id[$i]);

                                $type_arr[$j] = $s_item->type_id;
                                $model_arr[$j] = $s_item->model_id;
                                $catagory_arr[$j] = $s_item->category_new_id;

                                $size_arr[$j] = $s_item->size_id;
                                $color_arr[$j] = $s_item->color_id;
                                $data = [

                                    'customer_id' => $key_di->customer_id,
                                    'item_id' => $item_id[$i],
                                    'type_id' => $s_item->type_id,
                                    'model_id' => $s_item->model_id,
                                    'category_new_id' => $s_item->category_new_id,
                                    'size_id' => $s_item->size_id,
                                    'color_id' => $s_item->color_id,
                                    'item_qty' => $item_qty[$i],
                                    'item_rec' => $item_rec[$i],
                                ];

                                $insert_temp_vals = $this->pageModel->insert_temp_vals_new($data);

                                $j++;
                            }
                        }
                    }
                }
                else
                {
                    if($cp_cust->cp_priority==0)
                    {
                        $st = $this->pageModel->get_all_direct_pack_by_custid($key_di->customer_id); 
                        foreach ($st as $k) 
                        { 

                            $sto = $k;

                            $item_id = explode("|||", $sto->item_id);

                            $item_qty = explode("|||", $sto->item_qty);

                            $item_rec = explode("|||", $sto->item_rec);

                            $j = 0;

                            for ($i=0; $i <sizeof($item_id); $i++) 
                            {
                                $s_item = $this->pageModel->get_item_by_id($item_id[$i]);

                                $type_arr[$j] = $s_item->type_id;
                                $model_arr[$j] = $s_item->model_id;
                                $catagory_arr[$j] = $s_item->category_new_id;

                                $size_arr[$j] = $s_item->size_id;
                                $color_arr[$j] = $s_item->color_id;
                                $data = [

                                    'customer_id' => $key_di->customer_id,
                                    'item_id' => $item_id[$i],
                                    'type_id' => $s_item->type_id,
                                    'model_id' => $s_item->model_id,
                                    'category_new_id' => $s_item->category_new_id,
                                    'size_id' => $s_item->size_id,
                                    'color_id' => $s_item->color_id,
                                    'item_qty' => $item_qty[$i],
                                    'item_rec' => $item_rec[$i],
                                ];

                                $insert_temp_vals = $this->pageModel->insert_temp_vals_new($data);

                                $j++;
                            }
                        }
                    }
                }
            }

            $data=[
                'date_val' => 1
            ];
            $this->view('pages/customerwise_sales_report4P_print',$data);
        }
        else
        {
            redirect('pages/customerwise_sales_report2p_print');
        }       

    }



    // table report end
    public function non_purchase_order_details($id)
    {
        $data=[ 
                 'p_details'=>$this->pageModel->get_all_nonpurchase_order_details($id),
                 'id' => $id,
                ];

        $this->view('pages/nonpurchase_order_details',$data);
    }
     public function print_stockout_details($id)
    {
        $data=[ 
                 's_details'=>$this->pageModel->get_all_stock_out_details($id),
                 'id' => $id
                ];

        $this->view('pages/print_stockout_details',$data);
    }
    public function customer_wise_sales_list()
    {
        $subC = $this->pageModel->get_all_stockout_by_custid($_POST['custid']);
        echo $subC;
    }
    public function makesales_bill($id)
    {
        $data=[ 
                 'stock_out_order'=>$this->pageModel->stock_outorder_details($id),
                ];
        $this->view('pages/makesales_bill',$data);
    }
    public function pr($id)
    {
        $data=[ 'p_details'=>$this->pageModel->get_all_purchase_order_details($id), ];
        $this->view('pages/cprint',$data);
    }
    public function prfornonpurchase($id)
    {
          $data=[ 'p_details'=>$this->pageModel->get_all_nonpurchase_order_details($id), ];
        $this->view('pages/nonpurchaseprint',$data);
    }
    public function salesorderprint($id)
    {
      $data=[ 'p_details'=>$this->pageModel->get_all_stock_out_details($id), ];
        $this->view('pages/salesorderprints',$data);
    }
    public function salesinvoiceprint($id)
        {
             $data = [
                'sales' => $this->pageModel->getsalesOrderDetails($id),
                'id'=>$id
            ];
            $this->view('pages/salesinvoiceprintt',$data);
        }
        public function edit_vendor($id){
            $all_mfg = $this->pageModel->getAllmfg();
             $data = [
                'all_mfg' => $all_mfg,
                'vendor' => $this->pageModel->get_single_vendor($id)
            ];
               $this->view('pages/edit_vendor',$data);
        }
        public function updatevendor(){
             $data = [
            'primarySalutation' => $_POST['primarySalutation'],
            'firstName' => $_POST['firstName'],
            'lastName' => $_POST['lastName'],
            'compName' => $_POST['compName'],
            'dispName' => $_POST['dispName'],
            'venEmail' => $_POST['venEmail'],
            'vendPhoneHome' => $_POST['vendPhoneHome'],
            'vendPhoneWork' => $_POST['vendPhoneWork'],
            'vendWeb' => $_POST['vendWeb'],
            'vendCurrency' => $_POST['vendCurrency'],
            'vendPayment' => $_POST['vendPayment'],
            'facebook' => $_POST['facebook'],
            'twittetr' => $_POST['twittetr'],
            'attension' => $_POST['attension'],
            'country' => $_POST['country'],
            'street1' => $_POST['street1'],
            'street2' => $_POST['street2'],
            'city' => $_POST['city'],
            'state' => $_POST['state'],
            'zipcode' => $_POST['zipcode'],
            'phoneAdd' => $_POST['phoneAdd'],
            'fax' => $_POST['fax'],
            'contSalu' => $_POST['contSalu'],
            'contFirstname' => $_POST['contFirstname'],
            'contLastName' => $_POST['contLastName'],
            'contEmail' => $_POST['contEmail'],
            'contWorkPhone' => $_POST['contWorkPhone'],
            'contWorkMobile' => $_POST['contWorkMobile'],
            'gst' => $_POST['gst'],
            'aadhar' => $_POST['aadhar'],
            'passport' => $_POST['passport'],
            'dob' => $_POST['dob'],
            'aniversary' => $_POST['aniversary'],
            'blood' => $_POST['blood'],
            'id' => $_POST['vendorid'],
            'mfg_sort' => implode("|", $_POST['mfg_sort']),
        ];
        $this->pageModel->updatevendordetails($data);
        $_SESSION['success'] = "Vendor Added successfully";
        redirect('pages/all_venders');
        }
        public function item_by_category4(){
        //   if(isset($_SESSION['temp_print']))
        // {
        //     redirect('pages/item_by_category');
        //     unset($_SESSION['temp_print']);
        // }
        // $data = [
        //     'cat' => $this->pageModel->getAllCategoriesDb(),
        //     'cat1' => $this->pageModel->getAllCategoriesDb2(),
        //     'cat2' => $this->pageModel->getAllCategoriesDb3(),
        //     'cat3' => $this->pageModel->getAllCategoriesDb4(),
        //     'type' => $this->pageModel->getAlltypeDb(),
        //     'model' => $this->pageModel->getAllCategoriesDb_model(),
        //     'cat_new' => $this->pageModel->getAllCategoriesDb_new(),
        //     'subcat_new' => $this->pageModel->getAllsubCategoriesDb_new(),
        //     'color' => $this->pageModel->getAllcolorDb_new(),
        //     'size' => $this->pageModel->getAllsizeDb_new(),
        //     'all_mfg' => $this->pageModel->getallmfg(),
        // ];
        $this->view('pages/item_by_category4');
    }
    public function by_allcategory_item_cat5(){
        if(!empty($_POST['to'])){
          $to=date('Y-m-d',strtotime($_POST['to']));
    }  else
        {
            $to = date('Y-m-d');
        }
          if(!empty($_POST['from'])){
        $from=date('Y-m-d',strtotime($_POST['from']));
          }else
        {
            $from = date('Y-m-d');
        }
          $allComp = $this->pageModel->get_all_category_wise_details789($to,$from);
            $output = "";
        $sum=0;
        $xc ="";
        $post = new Page();
        foreach ($allComp as $k) {
            $xc = $post->get_item_by_id_by_name($k->item_id);
            if(empty($xc)){ $xc = "--"; }else{ $xc = $xc->name; }
                    $output .= '<tr>
            <td>'.$k->id.'</td>
             <td>'.$k->vendor.'</td>
               <td>'.$k->item_id.'</td>
             <td>'.$xc.'</td>
            <td>'.$k->qty_receive.'</td>
            <td>'.$k->receive_date.'</td>
            <td><a href="'.URLROOT.'/pages/non_purchase_order_details/'.$k->id.'" class="btn btn-danger-rgba">More</a></td>
        </tr>';
         }
           echo $output;
    }

    public function item_by_category5(){
        $this->view('pages/item_by_category5');
    }
    public function by_allcategory_item_cat6()
    {
        if(!empty($_POST['to']))
        {
            $to=date('Y-m-d',strtotime($_POST['to']));
        }  
        else
        {
            $to = date('Y-m-d');
        }
        if(!empty($_POST['from']))
        {
            $from=date('Y-m-d',strtotime($_POST['from']));
        }
        else
        {
            $from = date('Y-m-d');
        }
        $allComp = $this->pageModel->get_all_category_wise_details00000($to,$from);
        $output = "";
        $sum=0;
        $post = new Page();
        foreach ($allComp as $k) 
        {
            $pid = $post->get_type_name_by_id1($k->id);
            if(empty($pid))
            { 
                $pid = "--";
            }
            else
            { 
                $pid = $pid->item_id; 
            }
            $pname = $post->get_type_name_by_id1($k->id);
            if(empty($pname))
            { 
                $pname = "--";
            }
            else
            { 
                $pname = $pname->item_name; 
            }
            $output .= '<tr>
                        <td>'.$k->id.'</td>
                        <td>'.$k->vendor.'</td>
                        <td>'.$k->ndate.'</td><td>';
                        $pid=explode('|||', $pid);
                        $pname=explode('|||', $pname);
                        for($l = 0; $l<sizeof($pid); $l++)
                        {
                            $output .=$pid[$l].'<br>';
                        }
            $output .='</td><td>';
                        for($l = 0; $l<sizeof($pid); $l++)
                        {
                            $output .=$pname[$l].'<br>';
                        }
            $output .= '</td><td><a href="'.URLROOT.'/pages/purchase_order_details1/'.$k->id.'" class="btn btn-danger-rgba">More</a></td>
                        </tr>';
        }
         echo $output;
    }
    public function item_by_category6()
    {
        $data=[
        'type' => $this->pageModel->getAlltypeDb(),
            'model' => $this->pageModel->getAllCategoriesDb_model(),
        ];
        $this->view('pages/item_by_category6',$data);
    }
   public function by_allcategory_item_cat7(){
      $category_id = $_POST['category_id'];
        $subCategory = $_POST['subCategory'];
          if(!empty($_POST['to'])){
          $to=date('Y-m-d',strtotime($_POST['to']));
    }  else
        {
            $to = date('Y-m-d');
        }
          if(!empty($_POST['from'])){
        $from=date('Y-m-d',strtotime($_POST['from']));
          }else
        {
            $from = date('Y-m-d');
        }
           $allComp = $this->pageModel->get_all_category_wise_details11111($category_id, $subCategory,$to,$from);
                $output = "";
        $sum=0;
        $xc ="";
        $post = new Page();
        foreach ($allComp as $k) {
            //     $item_name = $post->get_type_name_by_id($k->id);
            // if(empty($item_name)){ $item_name = "--";}else{ $item_name = $item_name->name; }
            $xc = $post->get_item_by_id_by_name($k->id);
            if(empty($xc)){ $xc = "--"; }else{ $xc = $xc->name; }
            //        $item_id = $post->get_type_name_by_id($k->id);
            // if(empty($item_id)){ $item_id = "--";}else{ $item_id = $item_id->id; }
                $id = $post->get_type_name_by_id($category_id);
             $output .= '<tr>
            <td>'.$k->ppid.'</td>
             <td>'.$k->vendor.'</td>
               <td>'.$k->id.'</td>
             <td>'.$xc.'</td>
            <td>'.$k->qty_receive.'</td>
            <td>'.$k->receive_date.'</td>
              <td><a href="'.URLROOT.'/pages/non_purchase_order_details/'.$k->ppid.'" class="btn btn-danger-rgba">More</a></td>
        </tr>';
        }
 echo $output;
}
    public function item_by_category7(){
            $data=[
                   'mod' => $this->pageModel->getallmodeldetails(),
            ];
            $this->view('pages/item_by_category7',$data);
    }
    public function item_by_category7P(){
            $data=[
                   'mod' => $this->pageModel->getallmodeldetails(),
            ];
            $this->view('pages/item_by_category7P',$data);
    }
    public function by_allcategory_item_cat8()
    {
          $sort_id=$_POST['sort'];

            if($_POST['sort']==0)
            {
                $x=$this->pageModel->getallstockoutdetails();
                $output = "";
                // $post = new Page();
                foreach ($x as $key)
                {
                    $cp_cust = $this->pageModel->get_all_customer_cp_priority($key->customer_id);
                    if($_SESSION['ctype'] == 3)
                    {
                        $y=$this->pageModel->getallstockoutorder($key->id);
                        $output .='<tr><td>'.$key->id.'</td>';
                         $item_id=explode('|||',$y->item_id);
                        $output .='<td>'.$key->customer.'</td><td>';
                        for($i=0;$i<sizeof($item_id);$i++)
                        {
                            $output .=''.$item_id[$i].'<br>';
                        }
                        $output.='</td><td>';
                           $item_name=explode('|||',$y->item_name);
                        for($j=0;$j<sizeof($item_name);$j++)
                        {
                            $output .=''.$item_name[$j].'<br>';
                        }
                        $output.='</td><td>';
                             $item_qty=explode('|||',$y->item_qty);
                        for($k=0;$k<sizeof($item_qty);$k++)
                        {
                            $output .=''.$item_qty[$k].'<br>';
                        }
                          $output.='</td><td>';
                                 $item_rec=explode('|||',$y->item_rec);
                        for($p=0;$p<sizeof($item_rec);$p++)
                        {
                            if($item_rec[$p]==1)
                            {
                                $item_rec[$p] = "Box";   
                            }
                            else
                            {
                                $item_rec[$p] = "Pieces";   
                            }
                            $output .=''.$item_rec[$p].'<br>';
                        }
                            $output .='<td>'.$key->stock_dt.'</td>';
                            $output.='</td></tr>';
                        
                    }elseif($_SESSION['ctype'] == 1)
                    {
                        if($cp_cust->cp_priority==1)
                        {

                            $y=$this->pageModel->getallstockoutorder($key->id);
                            $output .='<tr><td>'.$key->id.'</td>';
                             $item_id=explode('|||',$y->item_id);
                            $output .='<td>'.$key->customer.'</td><td>';
                            for($i=0;$i<sizeof($item_id);$i++)
                            {
                                $output .=''.$item_id[$i].'<br>';
                            }
                            $output.='</td><td>';
                               $item_name=explode('|||',$y->item_name);
                            for($j=0;$j<sizeof($item_name);$j++)
                            {
                                $output .=''.$item_name[$j].'<br>';
                            }
                            $output.='</td><td>';
                                 $item_qty=explode('|||',$y->item_qty);
                            for($k=0;$k<sizeof($item_qty);$k++)
                            {
                                $output .=''.$item_qty[$k].'<br>';
                            }
                              $output.='</td><td>';
                                     $item_rec=explode('|||',$y->item_rec);
                            for($p=0;$p<sizeof($item_rec);$p++)
                            {
                                if($item_rec[$p]==1)
                                {
                                    $item_rec[$p] = "Box";   
                                }
                                else
                                {
                                    $item_rec[$p] = "Pieces";   
                                }
                                $output .=''.$item_rec[$p].'<br>';
                            }
                                $output .='<td>'.$key->stock_dt.'</td>';
                                $output.='</td></tr>';
                        }
                    }
                    elseif($_SESSION['ctype'] == 4)
                    {
                        if($cp_cust->cp_priority==4)
                        {

                            $y=$this->pageModel->getallstockoutorder($key->id);
                            $output .='<tr><td>'.$key->id.'</td>';
                             $item_id=explode('|||',$y->item_id);
                            $output .='<td>'.$key->customer.'</td><td>';
                            for($i=0;$i<sizeof($item_id);$i++)
                            {
                                $output .=''.$item_id[$i].'<br>';
                            }
                            $output.='</td><td>';
                               $item_name=explode('|||',$y->item_name);
                            for($j=0;$j<sizeof($item_name);$j++)
                            {
                                $output .=''.$item_name[$j].'<br>';
                            }
                            $output.='</td><td>';
                                 $item_qty=explode('|||',$y->item_qty);
                            for($k=0;$k<sizeof($item_qty);$k++)
                            {
                                $output .=''.$item_qty[$k].'<br>';
                            }
                              $output.='</td><td>';
                                     $item_rec=explode('|||',$y->item_rec);
                            for($p=0;$p<sizeof($item_rec);$p++)
                            {
                                if($item_rec[$p]==1)
                                {
                                    $item_rec[$p] = "Box";   
                                }
                                else
                                {
                                    $item_rec[$p] = "Pieces";   
                                }
                                $output .=''.$item_rec[$p].'<br>';
                            }
                                $output .='<td>'.$key->stock_dt.'</td>';
                                $output.='</td></tr>';
                        }
                    }
                    elseif($_SESSION['ctype'] == 5)
                    {
                        if($cp_cust->cp_priority==5)
                        {

                            $y=$this->pageModel->getallstockoutorder($key->id);
                            $output .='<tr><td>'.$key->id.'</td>';
                             $item_id=explode('|||',$y->item_id);
                            $output .='<td>'.$key->customer.'</td><td>';
                            for($i=0;$i<sizeof($item_id);$i++)
                            {
                                $output .=''.$item_id[$i].'<br>';
                            }
                            $output.='</td><td>';
                               $item_name=explode('|||',$y->item_name);
                            for($j=0;$j<sizeof($item_name);$j++)
                            {
                                $output .=''.$item_name[$j].'<br>';
                            }
                            $output.='</td><td>';
                                 $item_qty=explode('|||',$y->item_qty);
                            for($k=0;$k<sizeof($item_qty);$k++)
                            {
                                $output .=''.$item_qty[$k].'<br>';
                            }
                              $output.='</td><td>';
                                     $item_rec=explode('|||',$y->item_rec);
                            for($p=0;$p<sizeof($item_rec);$p++)
                            {
                                if($item_rec[$p]==1)
                                {
                                    $item_rec[$p] = "Box";   
                                }
                                else
                                {
                                    $item_rec[$p] = "Pieces";   
                                }
                                $output .=''.$item_rec[$p].'<br>';
                            }
                                $output .='<td>'.$key->stock_dt.'</td>';
                                $output.='</td></tr>';
                        }
                    }
                    elseif($_SESSION['ctype'] == 6)
                    {
                        if($cp_cust->cp_priority==6)
                        {

                            $y=$this->pageModel->getallstockoutorder($key->id);
                            $output .='<tr><td>'.$key->id.'</td>';
                             $item_id=explode('|||',$y->item_id);
                            $output .='<td>'.$key->customer.'</td><td>';
                            for($i=0;$i<sizeof($item_id);$i++)
                            {
                                $output .=''.$item_id[$i].'<br>';
                            }
                            $output.='</td><td>';
                               $item_name=explode('|||',$y->item_name);
                            for($j=0;$j<sizeof($item_name);$j++)
                            {
                                $output .=''.$item_name[$j].'<br>';
                            }
                            $output.='</td><td>';
                                 $item_qty=explode('|||',$y->item_qty);
                            for($k=0;$k<sizeof($item_qty);$k++)
                            {
                                $output .=''.$item_qty[$k].'<br>';
                            }
                              $output.='</td><td>';
                                     $item_rec=explode('|||',$y->item_rec);
                            for($p=0;$p<sizeof($item_rec);$p++)
                            {
                                if($item_rec[$p]==1)
                                {
                                    $item_rec[$p] = "Box";   
                                }
                                else
                                {
                                    $item_rec[$p] = "Pieces";   
                                }
                                $output .=''.$item_rec[$p].'<br>';
                            }
                                $output .='<td>'.$key->stock_dt.'</td>';
                                $output.='</td></tr>';
                        }
                    }
                    elseif($_SESSION['ctype'] == 7)
                    {
                        if($cp_cust->cp_priority==7)
                        {

                            $y=$this->pageModel->getallstockoutorder($key->id);
                            $output .='<tr><td>'.$key->id.'</td>';
                             $item_id=explode('|||',$y->item_id);
                            $output .='<td>'.$key->customer.'</td><td>';
                            for($i=0;$i<sizeof($item_id);$i++)
                            {
                                $output .=''.$item_id[$i].'<br>';
                            }
                            $output.='</td><td>';
                               $item_name=explode('|||',$y->item_name);
                            for($j=0;$j<sizeof($item_name);$j++)
                            {
                                $output .=''.$item_name[$j].'<br>';
                            }
                            $output.='</td><td>';
                                 $item_qty=explode('|||',$y->item_qty);
                            for($k=0;$k<sizeof($item_qty);$k++)
                            {
                                $output .=''.$item_qty[$k].'<br>';
                            }
                              $output.='</td><td>';
                                     $item_rec=explode('|||',$y->item_rec);
                            for($p=0;$p<sizeof($item_rec);$p++)
                            {
                                if($item_rec[$p]==1)
                                {
                                    $item_rec[$p] = "Box";   
                                }
                                else
                                {
                                    $item_rec[$p] = "Pieces";   
                                }
                                $output .=''.$item_rec[$p].'<br>';
                            }
                                $output .='<td>'.$key->stock_dt.'</td>';
                                $output.='</td></tr>';
                        }
                    }
                    elseif($_SESSION['ctype'] == 8)
                    {
                        if($cp_cust->cp_priority==8)
                        {

                            $y=$this->pageModel->getallstockoutorder($key->id);
                            $output .='<tr><td>'.$key->id.'</td>';
                             $item_id=explode('|||',$y->item_id);
                            $output .='<td>'.$key->customer.'</td><td>';
                            for($i=0;$i<sizeof($item_id);$i++)
                            {
                                $output .=''.$item_id[$i].'<br>';
                            }
                            $output.='</td><td>';
                               $item_name=explode('|||',$y->item_name);
                            for($j=0;$j<sizeof($item_name);$j++)
                            {
                                $output .=''.$item_name[$j].'<br>';
                            }
                            $output.='</td><td>';
                                 $item_qty=explode('|||',$y->item_qty);
                            for($k=0;$k<sizeof($item_qty);$k++)
                            {
                                $output .=''.$item_qty[$k].'<br>';
                            }
                              $output.='</td><td>';
                                     $item_rec=explode('|||',$y->item_rec);
                            for($p=0;$p<sizeof($item_rec);$p++)
                            {
                                if($item_rec[$p]==1)
                                {
                                    $item_rec[$p] = "Box";   
                                }
                                else
                                {
                                    $item_rec[$p] = "Pieces";   
                                }
                                $output .=''.$item_rec[$p].'<br>';
                            }
                                $output .='<td>'.$key->stock_dt.'</td>';
                                $output.='</td></tr>';
                        }
                    }
                    elseif($_SESSION['ctype'] == 9)
                    {
                        if($cp_cust->cp_priority==9)
                        {

                            $y=$this->pageModel->getallstockoutorder($key->id);
                            $output .='<tr><td>'.$key->id.'</td>';
                             $item_id=explode('|||',$y->item_id);
                            $output .='<td>'.$key->customer.'</td><td>';
                            for($i=0;$i<sizeof($item_id);$i++)
                            {
                                $output .=''.$item_id[$i].'<br>';
                            }
                            $output.='</td><td>';
                               $item_name=explode('|||',$y->item_name);
                            for($j=0;$j<sizeof($item_name);$j++)
                            {
                                $output .=''.$item_name[$j].'<br>';
                            }
                            $output.='</td><td>';
                                 $item_qty=explode('|||',$y->item_qty);
                            for($k=0;$k<sizeof($item_qty);$k++)
                            {
                                $output .=''.$item_qty[$k].'<br>';
                            }
                              $output.='</td><td>';
                                     $item_rec=explode('|||',$y->item_rec);
                            for($p=0;$p<sizeof($item_rec);$p++)
                            {
                                if($item_rec[$p]==1)
                                {
                                    $item_rec[$p] = "Box";   
                                }
                                else
                                {
                                    $item_rec[$p] = "Pieces";   
                                }
                                $output .=''.$item_rec[$p].'<br>';
                            }
                                $output .='<td>'.$key->stock_dt.'</td>';
                                $output.='</td></tr>';
                        }
                    }
                    else
                    {
                        if($cp_cust->cp_priority==0)
                        {
                            $y=$this->pageModel->getallstockoutorder($key->id);
                            $output .='<tr><td>'.$key->id.'</td>';
                             $item_id=explode('|||',$y->item_id);
                            $output .='<td>'.$key->customer.'</td><td>';
                            for($i=0;$i<sizeof($item_id);$i++)
                            {
                                $output .=''.$item_id[$i].'<br>';
                            }
                            $output.='</td><td>';
                               $item_name=explode('|||',$y->item_name);
                            for($j=0;$j<sizeof($item_name);$j++)
                            {
                                $output .=''.$item_name[$j].'<br>';
                            }
                            $output.='</td><td>';
                                 $item_qty=explode('|||',$y->item_qty);
                            for($k=0;$k<sizeof($item_qty);$k++)
                            {
                                $output .=''.$item_qty[$k].'<br>';
                            }
                              $output.='</td><td>';
                                     $item_rec=explode('|||',$y->item_rec);
                            for($p=0;$p<sizeof($item_rec);$p++)
                            {
                                if($item_rec[$p]==1)
                                {
                                    $item_rec[$p] = "Box";   
                                }
                                else
                                {
                                    $item_rec[$p] = "Pieces";   
                                }
                                $output .=''.$item_rec[$p].'<br>';
                            }
                                $output .='<td>'.$key->stock_dt.'</td>';
                                $output.='</td></tr>';        
                        }
                    }
                }
            } 
            else
            {
                $x=$this->pageModel->getallstockoutdetails();
                $output = "";
                foreach($x as $key)
                {
                    $cp_cust = $this->pageModel->get_all_customer_cp_priority($key->customer_id);
                    if($_SESSION['ctype'] == 3)
                    {
                       

                        $y=$this->pageModel->getallstockoutorder($key->id);
                        $z=$this->pageModel->getallitemdetails($y->item_id);
                        if(($z->model_id)==$sort_id){
                        $output .='<tr><td>'.$key->id.'</td>';
                        $output .='<td>'.$key->customer.'</td><td>';
                        $item_id=explode('|||',$y->item_id);
                        for($m=0;$m<sizeof($item_id);$m++)
                        {
                            $g=$this->pageModel->getallitemdetails($item_id[$m]);
                            if(($g->model_id)==$sort_id)
                            {
                                $output .=''.$item_id[$m].'<br>';
                            }
                        }
                        $output.='</td><td>';
                           $item_name=explode('|||',$y->item_name);
                        for($n=0;$n<sizeof($item_name);$n++)
                        {
                            $g=$this->pageModel->getallitemdetails($item_id[$n]);
                            if(($g->model_id)==$sort_id)
                            {
                                $output .=''.$item_name[$n].'<br>';
                            }
                        }
                        $output.='</td><td>';
                             $item_qty=explode('|||',$y->item_qty);
                        for($d=0;$d<sizeof($item_qty);$d++)
                        {
                            $g=$this->pageModel->getallitemdetails($item_id[$d]);
                            if(($g->model_id)==$sort_id)
                            {
                                $output .=''.$item_qty[$d].'<br>';
                            }
                        }
                        $output.='</td><td>';
                         $item_rec=explode('|||',$y->item_rec);
                        for($f=0;$f<sizeof($item_rec);$f++)
                        {
                            $g=$this->pageModel->getallitemdetails($item_id[$f]);
                            if(($g->model_id)==$sort_id)
                            {
                                if($item_rec[$f]==1)
                                {
                                    $item_rec[$f] = "Box";   
                                }
                                else
                                {
                                    $item_rec[$f] = "Pieces";   
                                }
                                $output .=''.$item_rec[$f].'<br>';
                            }
                        }
                        $output .='<td>'.$key->stock_dt.'</td>';
                        $output.='</td></tr>';
                        }
                        
                    }elseif($_SESSION['ctype'] == 1)
                    {
                        if($cp_cust->cp_priority==1)
                        {

                            $y=$this->pageModel->getallstockoutorder($key->id);
                            $z=$this->pageModel->getallitemdetails($y->item_id);
                            if(($z->model_id)==$sort_id){
                            $output .='<tr><td>'.$key->id.'</td>';
                            $output .='<td>'.$key->customer.'</td><td>';
                            $item_id=explode('|||',$y->item_id);
                            for($m=0;$m<sizeof($item_id);$m++)
                            {
                                $g=$this->pageModel->getallitemdetails($item_id[$m]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_id[$m].'<br>';
                                }
                            }
                            $output.='</td><td>';
                               $item_name=explode('|||',$y->item_name);
                            for($n=0;$n<sizeof($item_name);$n++)
                            {
                                $g=$this->pageModel->getallitemdetails($item_id[$n]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_name[$n].'<br>';
                                }
                            }
                            $output.='</td><td>';
                                 $item_qty=explode('|||',$y->item_qty);
                            for($d=0;$d<sizeof($item_qty);$d++)
                            {
                                $g=$this->pageModel->getallitemdetails($item_id[$d]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_qty[$d].'<br>';
                                }
                            }
                            $output.='</td><td>';
                             $item_rec=explode('|||',$y->item_rec);
                            for($f=0;$f<sizeof($item_rec);$f++)
                            {
                                $g=$this->pageModel->getallitemdetails($item_id[$f]);
                                if(($g->model_id)==$sort_id)
                                {
                                    if($item_rec[$f]==1)
                                    {
                                        $item_rec[$f] = "Box";   
                                    }
                                    else
                                    {
                                        $item_rec[$f] = "Pieces";   
                                    }
                                    $output .=''.$item_rec[$f].'<br>';
                                }
                            }
                            $output .='<td>'.$key->stock_dt.'</td>';
                            $output.='</td></tr>';
                            }
                        }
                    }
                    elseif($_SESSION['ctype'] == 4)
                    {
                        if($cp_cust->cp_priority==4)
                        {

                            $y=$this->pageModel->getallstockoutorder($key->id);
                            $z=$this->pageModel->getallitemdetails($y->item_id);
                            if(($z->model_id)==$sort_id){
                            $output .='<tr><td>'.$key->id.'</td>';
                            $output .='<td>'.$key->customer.'</td><td>';
                            $item_id=explode('|||',$y->item_id);
                            for($m=0;$m<sizeof($item_id);$m++)
                            {
                                $g=$this->pageModel->getallitemdetails($item_id[$m]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_id[$m].'<br>';
                                }
                            }
                            $output.='</td><td>';
                               $item_name=explode('|||',$y->item_name);
                            for($n=0;$n<sizeof($item_name);$n++)
                            {
                                $g=$this->pageModel->getallitemdetails($item_id[$n]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_name[$n].'<br>';
                                }
                            }
                            $output.='</td><td>';
                                 $item_qty=explode('|||',$y->item_qty);
                            for($d=0;$d<sizeof($item_qty);$d++)
                            {
                                $g=$this->pageModel->getallitemdetails($item_id[$d]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_qty[$d].'<br>';
                                }
                            }
                            $output.='</td><td>';
                             $item_rec=explode('|||',$y->item_rec);
                            for($f=0;$f<sizeof($item_rec);$f++)
                            {
                                $g=$this->pageModel->getallitemdetails($item_id[$f]);
                                if(($g->model_id)==$sort_id)
                                {
                                    if($item_rec[$f]==1)
                                    {
                                        $item_rec[$f] = "Box";   
                                    }
                                    else
                                    {
                                        $item_rec[$f] = "Pieces";   
                                    }
                                    $output .=''.$item_rec[$f].'<br>';
                                }
                            }
                            $output .='<td>'.$key->stock_dt.'</td>';
                            $output.='</td></tr>';
                            }
                        }
                    }
                    elseif($_SESSION['ctype'] == 5)
                    {
                        if($cp_cust->cp_priority==5)
                        {

                            $y=$this->pageModel->getallstockoutorder($key->id);
                            $z=$this->pageModel->getallitemdetails($y->item_id);
                            if(($z->model_id)==$sort_id){
                            $output .='<tr><td>'.$key->id.'</td>';
                            $output .='<td>'.$key->customer.'</td><td>';
                            $item_id=explode('|||',$y->item_id);
                            for($m=0;$m<sizeof($item_id);$m++)
                            {
                                $g=$this->pageModel->getallitemdetails($item_id[$m]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_id[$m].'<br>';
                                }
                            }
                            $output.='</td><td>';
                               $item_name=explode('|||',$y->item_name);
                            for($n=0;$n<sizeof($item_name);$n++)
                            {
                                $g=$this->pageModel->getallitemdetails($item_id[$n]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_name[$n].'<br>';
                                }
                            }
                            $output.='</td><td>';
                                 $item_qty=explode('|||',$y->item_qty);
                            for($d=0;$d<sizeof($item_qty);$d++)
                            {
                                $g=$this->pageModel->getallitemdetails($item_id[$d]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_qty[$d].'<br>';
                                }
                            }
                            $output.='</td><td>';
                             $item_rec=explode('|||',$y->item_rec);
                            for($f=0;$f<sizeof($item_rec);$f++)
                            {
                                $g=$this->pageModel->getallitemdetails($item_id[$f]);
                                if(($g->model_id)==$sort_id)
                                {
                                    if($item_rec[$f]==1)
                                    {
                                        $item_rec[$f] = "Box";   
                                    }
                                    else
                                    {
                                        $item_rec[$f] = "Pieces";   
                                    }
                                    $output .=''.$item_rec[$f].'<br>';
                                }
                            }
                            $output .='<td>'.$key->stock_dt.'</td>';
                            $output.='</td></tr>';
                            }
                        }
                    }
                    elseif($_SESSION['ctype'] == 6)
                    {
                        if($cp_cust->cp_priority==6)
                        {

                            $y=$this->pageModel->getallstockoutorder($key->id);
                            $z=$this->pageModel->getallitemdetails($y->item_id);
                            if(($z->model_id)==$sort_id){
                            $output .='<tr><td>'.$key->id.'</td>';
                            $output .='<td>'.$key->customer.'</td><td>';
                            $item_id=explode('|||',$y->item_id);
                            for($m=0;$m<sizeof($item_id);$m++)
                            {
                                $g=$this->pageModel->getallitemdetails($item_id[$m]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_id[$m].'<br>';
                                }
                            }
                            $output.='</td><td>';
                               $item_name=explode('|||',$y->item_name);
                            for($n=0;$n<sizeof($item_name);$n++)
                            {
                                $g=$this->pageModel->getallitemdetails($item_id[$n]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_name[$n].'<br>';
                                }
                            }
                            $output.='</td><td>';
                                 $item_qty=explode('|||',$y->item_qty);
                            for($d=0;$d<sizeof($item_qty);$d++)
                            {
                                $g=$this->pageModel->getallitemdetails($item_id[$d]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_qty[$d].'<br>';
                                }
                            }
                            $output.='</td><td>';
                             $item_rec=explode('|||',$y->item_rec);
                            for($f=0;$f<sizeof($item_rec);$f++)
                            {
                                $g=$this->pageModel->getallitemdetails($item_id[$f]);
                                if(($g->model_id)==$sort_id)
                                {
                                    if($item_rec[$f]==1)
                                    {
                                        $item_rec[$f] = "Box";   
                                    }
                                    else
                                    {
                                        $item_rec[$f] = "Pieces";   
                                    }
                                    $output .=''.$item_rec[$f].'<br>';
                                }
                            }
                            $output .='<td>'.$key->stock_dt.'</td>';
                            $output.='</td></tr>';
                            }
                        }
                    }
                    elseif($_SESSION['ctype'] == 7)
                    {
                        if($cp_cust->cp_priority==7)
                        {

                            $y=$this->pageModel->getallstockoutorder($key->id);
                            $z=$this->pageModel->getallitemdetails($y->item_id);
                            if(($z->model_id)==$sort_id){
                            $output .='<tr><td>'.$key->id.'</td>';
                            $output .='<td>'.$key->customer.'</td><td>';
                            $item_id=explode('|||',$y->item_id);
                            for($m=0;$m<sizeof($item_id);$m++)
                            {
                                $g=$this->pageModel->getallitemdetails($item_id[$m]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_id[$m].'<br>';
                                }
                            }
                            $output.='</td><td>';
                               $item_name=explode('|||',$y->item_name);
                            for($n=0;$n<sizeof($item_name);$n++)
                            {
                                $g=$this->pageModel->getallitemdetails($item_id[$n]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_name[$n].'<br>';
                                }
                            }
                            $output.='</td><td>';
                                 $item_qty=explode('|||',$y->item_qty);
                            for($d=0;$d<sizeof($item_qty);$d++)
                            {
                                $g=$this->pageModel->getallitemdetails($item_id[$d]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_qty[$d].'<br>';
                                }
                            }
                            $output.='</td><td>';
                             $item_rec=explode('|||',$y->item_rec);
                            for($f=0;$f<sizeof($item_rec);$f++)
                            {
                                $g=$this->pageModel->getallitemdetails($item_id[$f]);
                                if(($g->model_id)==$sort_id)
                                {
                                    if($item_rec[$f]==1)
                                    {
                                        $item_rec[$f] = "Box";   
                                    }
                                    else
                                    {
                                        $item_rec[$f] = "Pieces";   
                                    }
                                    $output .=''.$item_rec[$f].'<br>';
                                }
                            }
                            $output .='<td>'.$key->stock_dt.'</td>';
                            $output.='</td></tr>';
                            }
                        }
                    }
                    elseif($_SESSION['ctype'] == 8)
                    {
                        if($cp_cust->cp_priority==8)
                        {

                            $y=$this->pageModel->getallstockoutorder($key->id);
                            $z=$this->pageModel->getallitemdetails($y->item_id);
                            if(($z->model_id)==$sort_id){
                            $output .='<tr><td>'.$key->id.'</td>';
                            $output .='<td>'.$key->customer.'</td><td>';
                            $item_id=explode('|||',$y->item_id);
                            for($m=0;$m<sizeof($item_id);$m++)
                            {
                                $g=$this->pageModel->getallitemdetails($item_id[$m]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_id[$m].'<br>';
                                }
                            }
                            $output.='</td><td>';
                               $item_name=explode('|||',$y->item_name);
                            for($n=0;$n<sizeof($item_name);$n++)
                            {
                                $g=$this->pageModel->getallitemdetails($item_id[$n]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_name[$n].'<br>';
                                }
                            }
                            $output.='</td><td>';
                                 $item_qty=explode('|||',$y->item_qty);
                            for($d=0;$d<sizeof($item_qty);$d++)
                            {
                                $g=$this->pageModel->getallitemdetails($item_id[$d]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_qty[$d].'<br>';
                                }
                            }
                            $output.='</td><td>';
                             $item_rec=explode('|||',$y->item_rec);
                            for($f=0;$f<sizeof($item_rec);$f++)
                            {
                                $g=$this->pageModel->getallitemdetails($item_id[$f]);
                                if(($g->model_id)==$sort_id)
                                {
                                    if($item_rec[$f]==1)
                                    {
                                        $item_rec[$f] = "Box";   
                                    }
                                    else
                                    {
                                        $item_rec[$f] = "Pieces";   
                                    }
                                    $output .=''.$item_rec[$f].'<br>';
                                }
                            }
                            $output .='<td>'.$key->stock_dt.'</td>';
                            $output.='</td></tr>';
                            }
                        }
                    }
                    elseif($_SESSION['ctype'] == 9)
                    {
                        if($cp_cust->cp_priority==9)
                        {

                            $y=$this->pageModel->getallstockoutorder($key->id);
                            $z=$this->pageModel->getallitemdetails($y->item_id);
                            if(($z->model_id)==$sort_id){
                            $output .='<tr><td>'.$key->id.'</td>';
                            $output .='<td>'.$key->customer.'</td><td>';
                            $item_id=explode('|||',$y->item_id);
                            for($m=0;$m<sizeof($item_id);$m++)
                            {
                                $g=$this->pageModel->getallitemdetails($item_id[$m]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_id[$m].'<br>';
                                }
                            }
                            $output.='</td><td>';
                               $item_name=explode('|||',$y->item_name);
                            for($n=0;$n<sizeof($item_name);$n++)
                            {
                                $g=$this->pageModel->getallitemdetails($item_id[$n]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_name[$n].'<br>';
                                }
                            }
                            $output.='</td><td>';
                                 $item_qty=explode('|||',$y->item_qty);
                            for($d=0;$d<sizeof($item_qty);$d++)
                            {
                                $g=$this->pageModel->getallitemdetails($item_id[$d]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_qty[$d].'<br>';
                                }
                            }
                            $output.='</td><td>';
                             $item_rec=explode('|||',$y->item_rec);
                            for($f=0;$f<sizeof($item_rec);$f++)
                            {
                                $g=$this->pageModel->getallitemdetails($item_id[$f]);
                                if(($g->model_id)==$sort_id)
                                {
                                    if($item_rec[$f]==1)
                                    {
                                        $item_rec[$f] = "Box";   
                                    }
                                    else
                                    {
                                        $item_rec[$f] = "Pieces";   
                                    }
                                    $output .=''.$item_rec[$f].'<br>';
                                }
                            }
                            $output .='<td>'.$key->stock_dt.'</td>';
                            $output.='</td></tr>';
                            }
                        }
                    }
                    else
                    {
                        if($cp_cust->cp_priority == 0)
                        {
                              $y=$this->pageModel->getallstockoutorder($key->id);
                            $z=$this->pageModel->getallitemdetails($y->item_id);
                            if(($z->model_id)==$sort_id){
                            $output .='<tr><td>'.$key->id.'</td>';
                            $output .='<td>'.$key->customer.'</td><td>';
                            $item_id=explode('|||',$y->item_id);
                            for($m=0;$m<sizeof($item_id);$m++)
                            {
                                $g=$this->pageModel->getallitemdetails($item_id[$m]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_id[$m].'<br>';
                                }
                            }
                            $output.='</td><td>';
                               $item_name=explode('|||',$y->item_name);
                            for($n=0;$n<sizeof($item_name);$n++)
                            {
                                $g=$this->pageModel->getallitemdetails($item_id[$n]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_name[$n].'<br>';
                                }
                            }
                            $output.='</td><td>';
                                 $item_qty=explode('|||',$y->item_qty);
                            for($d=0;$d<sizeof($item_qty);$d++)
                            {
                                $g=$this->pageModel->getallitemdetails($item_id[$d]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_qty[$d].'<br>';
                                }
                            }
                            $output.='</td><td>';
                             $item_rec=explode('|||',$y->item_rec);
                            for($f=0;$f<sizeof($item_rec);$f++)
                            {
                                $g=$this->pageModel->getallitemdetails($item_id[$f]);
                                if(($g->model_id)==$sort_id)
                                {
                                    if($item_rec[$f]==1)
                                    {
                                        $item_rec[$f] = "Box";   
                                    }
                                    else
                                    {
                                        $item_rec[$f] = "Pieces";   
                                    }
                                    $output .=''.$item_rec[$f].'<br>';
                                }
                            }
                            $output .='<td>'.$key->stock_dt.'</td>';
                            $output.='</td></tr>';
                            }      
                        }
                    }
                }
            }
        echo $output;
    }
    public function by_allcategory_item_cat8P()
    {
          $sort_id=$_POST['sort'];
            if($_POST['sort']==0)
            {
                $x=$this->pageModel->getalldirect_packagedetails();
                $output = "";
                // $post = new Page();
                foreach ($x as $key)
                {
                    $cp_cust = $this->pageModel->get_all_customer_cp_priority($key->customer_id);
                    if($_SESSION['ctype'] == 3)
                    {
                        $y=$key;
                        $output .='<tr><td>'.$key->p_id.'</td>';
                        $output .='<td>'.$key->pack_date.date('d-m-Y h:m A',strtotime($key->pack_date)).'</td>';
                         $item_id=explode('|||',$y->item_id);
                        $output .='<td>'.$key->customer.'</td><td>';
                        for($i=0;$i<sizeof($item_id);$i++)
                        {
                            $output .=''.$item_id[$i].'<br>';
                        }
                        $output.='</td><td>';
                           $item_name=explode('|||',$y->item_name);
                        for($j=0;$j<sizeof($item_name);$j++)
                        {
                            $output .=''.$item_name[$j].'<br>';
                        }
                        $output.='</td><td>';
                             $item_qty=explode('|||',$y->item_qty);
                        for($k=0;$k<sizeof($item_qty);$k++)
                        {
                            $output .=''.$item_qty[$k].'<br>';
                        }
                          $output.='</td><td>';
                                 $item_rec=explode('|||',$y->item_rec);
                        for($p=0;$p<sizeof($item_rec);$p++)
                        {
                            if($item_rec[$p]==0)
                            {
                                $item_rec[$p] = "Carton";   
                            }
                            elseif($item_rec[$p]==1)
                            {
                                $item_rec[$p] = "Box";   
                            }
                            else
                            {
                                $item_rec[$p] = "Pieces";   
                            }
                            $output .=''.$item_rec[$p].'<br>';
                        }
                            
                            $output.='</td></tr>';
                        
                    }elseif($_SESSION['ctype'] == 1)
                    {
                        if($cp_cust->cp_priority==1)
                        {

                            $y=$key;
                            $output .='<tr><td>'.$key->p_id.'</td>';
                            $output .='<td>'.$key->pack_date.'</td>';
                             $item_id=explode('|||',$y->item_id);
                            $output .='<td>'.$key->customer.'</td><td>';
                            for($i=0;$i<sizeof($item_id);$i++)
                            {
                                $output .=''.$item_id[$i].'<br>';
                            }
                            $output.='</td><td>';
                               $item_name=explode('|||',$y->item_name);
                            for($j=0;$j<sizeof($item_name);$j++)
                            {
                                $output .=''.$item_name[$j].'<br>';
                            }
                            $output.='</td><td>';
                                 $item_qty=explode('|||',$y->item_qty);
                            for($k=0;$k<sizeof($item_qty);$k++)
                            {
                                $output .=''.$item_qty[$k].'<br>';
                            }
                              $output.='</td><td>';
                                     $item_rec=explode('|||',$y->item_rec);
                            for($p=0;$p<sizeof($item_rec);$p++)
                            {
                                if($item_rec[$p]==0)
                                {
                                    $item_rec[$p] = "Carton";   
                                }
                                elseif($item_rec[$p]==1)
                                {
                                    $item_rec[$p] = "Box";   
                                }
                                else
                                {
                                    $item_rec[$p] = "Pieces";   
                                }
                                $output .=''.$item_rec[$p].'<br>';
                            }
                               
                                $output.='</td></tr>';
                        }
                    }
                    elseif($_SESSION['ctype'] == 4)
                    {
                        if($cp_cust->cp_priority==4)
                        {

                            $y=$key;
                            $output .='<tr><td>'.$key->p_id.'</td>';
                            $output .='<td>'.$key->pack_date.'</td>';
                             $item_id=explode('|||',$y->item_id);
                            $output .='<td>'.$key->customer.'</td><td>';
                            for($i=0;$i<sizeof($item_id);$i++)
                            {
                                $output .=''.$item_id[$i].'<br>';
                            }
                            $output.='</td><td>';
                               $item_name=explode('|||',$y->item_name);
                            for($j=0;$j<sizeof($item_name);$j++)
                            {
                                $output .=''.$item_name[$j].'<br>';
                            }
                            $output.='</td><td>';
                                 $item_qty=explode('|||',$y->item_qty);
                            for($k=0;$k<sizeof($item_qty);$k++)
                            {
                                $output .=''.$item_qty[$k].'<br>';
                            }
                              $output.='</td><td>';
                                     $item_rec=explode('|||',$y->item_rec);
                            for($p=0;$p<sizeof($item_rec);$p++)
                            {
                                if($item_rec[$p]==0)
                                {
                                    $item_rec[$p] = "Carton";   
                                }
                                elseif($item_rec[$p]==1)
                                {
                                    $item_rec[$p] = "Box";   
                                }
                                else
                                {
                                    $item_rec[$p] = "Pieces";   
                                }
                                $output .=''.$item_rec[$p].'<br>';
                            }
                                
                                $output.='</td></tr>';
                        }
                    }
                    elseif($_SESSION['ctype'] == 5)
                    {
                        if($cp_cust->cp_priority==5)
                        {

                            $y=$key;
                            $output .='<tr><td>'.$key->p_id.'</td>';
                            $output .='<td>'.$key->pack_date.'</td>';
                             $item_id=explode('|||',$y->item_id);
                            $output .='<td>'.$key->customer.'</td><td>';
                            for($i=0;$i<sizeof($item_id);$i++)
                            {
                                $output .=''.$item_id[$i].'<br>';
                            }
                            $output.='</td><td>';
                               $item_name=explode('|||',$y->item_name);
                            for($j=0;$j<sizeof($item_name);$j++)
                            {
                                $output .=''.$item_name[$j].'<br>';
                            }
                            $output.='</td><td>';
                                 $item_qty=explode('|||',$y->item_qty);
                            for($k=0;$k<sizeof($item_qty);$k++)
                            {
                                $output .=''.$item_qty[$k].'<br>';
                            }
                              $output.='</td><td>';
                                     $item_rec=explode('|||',$y->item_rec);
                            for($p=0;$p<sizeof($item_rec);$p++)
                            {
                                if($item_rec[$p]==0)
                                {
                                    $item_rec[$p] = "Carton";   
                                }
                                elseif($item_rec[$p]==1)
                                {
                                    $item_rec[$p] = "Box";   
                                }
                                else
                                {
                                    $item_rec[$p] = "Pieces";   
                                }
                                $output .=''.$item_rec[$p].'<br>';
                            }
                              
                                $output.='</td></tr>';
                        }
                    }
                    elseif($_SESSION['ctype'] == 6)
                    {
                        if($cp_cust->cp_priority==6)
                        {

                            $y=$key;
                            $output .='<tr><td>'.$key->p_id.'</td>';
                            $output .='<td>'.$key->pack_date.'</td>';
                             $item_id=explode('|||',$y->item_id);
                            $output .='<td>'.$key->customer.'</td><td>';
                            for($i=0;$i<sizeof($item_id);$i++)
                            {
                                $output .=''.$item_id[$i].'<br>';
                            }
                            $output.='</td><td>';
                               $item_name=explode('|||',$y->item_name);
                            for($j=0;$j<sizeof($item_name);$j++)
                            {
                                $output .=''.$item_name[$j].'<br>';
                            }
                            $output.='</td><td>';
                                 $item_qty=explode('|||',$y->item_qty);
                            for($k=0;$k<sizeof($item_qty);$k++)
                            {
                                $output .=''.$item_qty[$k].'<br>';
                            }
                              $output.='</td><td>';
                                     $item_rec=explode('|||',$y->item_rec);
                            for($p=0;$p<sizeof($item_rec);$p++)
                            {
                                if($item_rec[$p]==0)
                                {
                                    $item_rec[$p] = "Carton";   
                                }
                                elseif($item_rec[$p]==1)
                                {
                                    $item_rec[$p] = "Box";   
                                }
                                else
                                {
                                    $item_rec[$p] = "Pieces";   
                                }
                                $output .=''.$item_rec[$p].'<br>';
                            }
                                
                                $output.='</td></tr>';
                        }
                    }
                    elseif($_SESSION['ctype'] == 7)
                    {
                        if($cp_cust->cp_priority==7)
                        {

                            $y=$key;
                            $output .='<tr><td>'.$key->p_id.'</td>';
                            $output .='<td>'.$key->pack_date.'</td>';
                             $item_id=explode('|||',$y->item_id);
                            $output .='<td>'.$key->customer.'</td><td>';
                            for($i=0;$i<sizeof($item_id);$i++)
                            {
                                $output .=''.$item_id[$i].'<br>';
                            }
                            $output.='</td><td>';
                               $item_name=explode('|||',$y->item_name);
                            for($j=0;$j<sizeof($item_name);$j++)
                            {
                                $output .=''.$item_name[$j].'<br>';
                            }
                            $output.='</td><td>';
                                 $item_qty=explode('|||',$y->item_qty);
                            for($k=0;$k<sizeof($item_qty);$k++)
                            {
                                $output .=''.$item_qty[$k].'<br>';
                            }
                              $output.='</td><td>';
                                     $item_rec=explode('|||',$y->item_rec);
                            for($p=0;$p<sizeof($item_rec);$p++)
                            {
                                if($item_rec[$p]==0)
                                {
                                    $item_rec[$p] = "Carton";   
                                }
                                elseif($item_rec[$p]==1)
                                {
                                    $item_rec[$p] = "Box";   
                                }
                                else
                                {
                                    $item_rec[$p] = "Pieces";   
                                }
                                $output .=''.$item_rec[$p].'<br>';
                            }
                                
                                $output.='</td></tr>';
                        }
                    }
                    elseif($_SESSION['ctype'] == 8)
                    {
                        if($cp_cust->cp_priority==8)
                        {

                            $y=$key;
                            $output .='<tr><td>'.$key->p_id.'</td>';
                            $output .='<td>'.$key->pack_date.'</td>';
                             $item_id=explode('|||',$y->item_id);
                            $output .='<td>'.$key->customer.'</td><td>';
                            for($i=0;$i<sizeof($item_id);$i++)
                            {
                                $output .=''.$item_id[$i].'<br>';
                            }
                            $output.='</td><td>';
                               $item_name=explode('|||',$y->item_name);
                            for($j=0;$j<sizeof($item_name);$j++)
                            {
                                $output .=''.$item_name[$j].'<br>';
                            }
                            $output.='</td><td>';
                                 $item_qty=explode('|||',$y->item_qty);
                            for($k=0;$k<sizeof($item_qty);$k++)
                            {
                                $output .=''.$item_qty[$k].'<br>';
                            }
                              $output.='</td><td>';
                                     $item_rec=explode('|||',$y->item_rec);
                            for($p=0;$p<sizeof($item_rec);$p++)
                            {
                                if($item_rec[$p]==0)
                                {
                                    $item_rec[$p] = "Carton";   
                                }
                                elseif($item_rec[$p]==1)
                                {
                                    $item_rec[$p] = "Box";   
                                }
                                else
                                {
                                    $item_rec[$p] = "Pieces";   
                                }
                                $output .=''.$item_rec[$p].'<br>';
                            }
                                
                                $output.='</td></tr>';
                        }
                    }
                    elseif($_SESSION['ctype'] == 9)
                    {
                        if($cp_cust->cp_priority==9)
                        {

                            $y=$key;
                            $output .='<tr><td>'.$key->p_id.'</td>';
                            $output .='<td>'.$key->pack_date.'</td>';
                             $item_id=explode('|||',$y->item_id);
                            $output .='<td>'.$key->customer.'</td><td>';
                            for($i=0;$i<sizeof($item_id);$i++)
                            {
                                $output .=''.$item_id[$i].'<br>';
                            }
                            $output.='</td><td>';
                               $item_name=explode('|||',$y->item_name);
                            for($j=0;$j<sizeof($item_name);$j++)
                            {
                                $output .=''.$item_name[$j].'<br>';
                            }
                            $output.='</td><td>';
                                 $item_qty=explode('|||',$y->item_qty);
                            for($k=0;$k<sizeof($item_qty);$k++)
                            {
                                $output .=''.$item_qty[$k].'<br>';
                            }
                              $output.='</td><td>';
                                     $item_rec=explode('|||',$y->item_rec);
                            for($p=0;$p<sizeof($item_rec);$p++)
                            {
                                if($item_rec[$p]==0)
                                {
                                    $item_rec[$p] = "Carton";   
                                }
                                elseif($item_rec[$p]==1)
                                {
                                    $item_rec[$p] = "Box";   
                                }
                                else
                                {
                                    $item_rec[$p] = "Pieces";   
                                }
                                $output .=''.$item_rec[$p].'<br>';
                            }
                               
                                $output.='</td></tr>';
                        }
                    }
                    else
                    {
                        if($cp_cust->cp_priority==0)
                        {
                            $y=$key;
                            $output .='<tr><td>'.$key->p_id.'</td>';
                            $output .='<td>'.$key->pack_date.'</td>';
                             $item_id=explode('|||',$y->item_id);
                            $output .='<td>'.$key->customer.'</td><td>';
                            for($i=0;$i<sizeof($item_id);$i++)
                            {
                                $output .=''.$item_id[$i].'<br>';
                            }
                            $output.='</td><td>';
                               $item_name=explode('|||',$y->item_name);
                            for($j=0;$j<sizeof($item_name);$j++)
                            {
                                $output .=''.$item_name[$j].'<br>';
                            }
                            $output.='</td><td>';
                                 $item_qty=explode('|||',$y->item_qty);
                            for($k=0;$k<sizeof($item_qty);$k++)
                            {
                                $output .=''.$item_qty[$k].'<br>';
                            }
                              $output.='</td><td>';
                                     $item_rec=explode('|||',$y->item_rec);
                            for($p=0;$p<sizeof($item_rec);$p++)
                            {
                                if($item_rec[$p]==0)
                                {
                                    $item_rec[$p] = "Carton";   
                                }
                                elseif($item_rec[$p]==1)
                                {
                                    $item_rec[$p] = "Box";   
                                }
                                else
                                {
                                    $item_rec[$p] = "Pieces";   
                                }
                                $output .=''.$item_rec[$p].'<br>';
                            }
                                
                                $output.='</td></tr>';        
                        }
                    }
                }
            } 
            else
            {
                $x=$this->pageModel->getalldirect_packagedetails();
                $output = "";
                foreach($x as $key)
                {
                    $cp_cust = $this->pageModel->get_all_customer_cp_priority($key->customer_id);
                    if($_SESSION['ctype'] == 3)
                    {
                       

                        $y=$key;
                        $z=$this->pageModel->getallitemdetails($y->item_id);
                        if(($z->model_id)==$sort_id){
                        $output .='<tr><td>'.$key->p_id.'</td>';
                        $output .='<td>'.$key->pack_date.'</td>';
                        $output .='<td>'.$key->customer.'</td><td>';
                        $item_id=explode('|||',$y->item_id);
                        for($m=0;$m<sizeof($item_id);$m++)
                        {
                            $g=$this->pageModel->getallitemdetails($item_id[$m]);
                            if(($g->model_id)==$sort_id)
                            {
                                $output .=''.$item_id[$m].'<br>';
                            }
                        }
                        $output.='</td><td>';
                           $item_name=explode('|||',$y->item_name);
                        for($n=0;$n<sizeof($item_name);$n++)
                        {
                            $g=$this->pageModel->getallitemdetails($item_id[$n]);
                            if(($g->model_id)==$sort_id)
                            {
                                $output .=''.$item_name[$n].'<br>';
                            }
                        }
                        $output.='</td><td>';
                             $item_qty=explode('|||',$y->item_qty);
                        for($d=0;$d<sizeof($item_qty);$d++)
                        {
                            $g=$this->pageModel->getallitemdetails($item_id[$d]);
                            if(($g->model_id)==$sort_id)
                            {
                                $output .=''.$item_qty[$d].'<br>';
                            }
                        }
                        $output.='</td><td>';
                         $item_rec=explode('|||',$y->item_rec);
                        for($f=0;$f<sizeof($item_rec);$f++)
                        {
                            $g=$this->pageModel->getallitemdetails($item_id[$f]);
                            if(($g->model_id)==$sort_id)
                            {
                                if($item_rec[$f]==0)
                                {
                                    $item_rec[$f] = "Carton";   
                                }
                                elseif($item_rec[$f]==1)
                                {
                                    $item_rec[$f] = "Box";   
                                }
                                else
                                {
                                    $item_rec[$f] = "Pieces";   
                                }
                                $output .=''.$item_rec[$f].'<br>';
                            }
                        }
                       
                        $output.='</td></tr>';
                        }
                        
                    }elseif($_SESSION['ctype'] == 1)
                    {
                        if($cp_cust->cp_priority==1)
                        {

                            $y=$key;
                            $z=$this->pageModel->getallitemdetails($y->item_id);
                            if(($z->model_id)==$sort_id){
                            $output .='<tr><td>'.$key->p_id.'</td>';
                            $output .='<td>'.$key->pack_date.'</td>';
                            $output .='<td>'.$key->customer.'</td><td>';
                            $item_id=explode('|||',$y->item_id);
                            for($m=0;$m<sizeof($item_id);$m++)
                            {
                                $g=$this->pageModel->getallitemdetails($item_id[$m]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_id[$m].'<br>';
                                }
                            }
                            $output.='</td><td>';
                               $item_name=explode('|||',$y->item_name);
                            for($n=0;$n<sizeof($item_name);$n++)
                            {
                                $g=$this->pageModel->getallitemdetails($item_id[$n]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_name[$n].'<br>';
                                }
                            }
                            $output.='</td><td>';
                                 $item_qty=explode('|||',$y->item_qty);
                            for($d=0;$d<sizeof($item_qty);$d++)
                            {
                                $g=$this->pageModel->getallitemdetails($item_id[$d]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_qty[$d].'<br>';
                                }
                            }
                            $output.='</td><td>';
                             $item_rec=explode('|||',$y->item_rec);
                            for($f=0;$f<sizeof($item_rec);$f++)
                            {
                                $g=$this->pageModel->getallitemdetails($item_id[$f]);
                                if(($g->model_id)==$sort_id)
                                {
                                     if($item_rec[$f]==0)
                                    {
                                        $item_rec[$f] = "Carton";   
                                    }
                                    elseif($item_rec[$f]==1)
                                    {
                                        $item_rec[$f] = "Box";   
                                    }
                                    else
                                    {
                                        $item_rec[$f] = "Pieces";   
                                    }
                                    $output .=''.$item_rec[$f].'<br>';
                                }
                            }
                           
                            $output.='</td></tr>';
                            }
                        }
                    }
                    elseif($_SESSION['ctype'] == 4)
                    {
                        if($cp_cust->cp_priority==4)
                        {

                            $y=$key;
                            $z=$this->pageModel->getallitemdetails($y->item_id);
                            if(($z->model_id)==$sort_id){
                            $output .='<tr><td>'.$key->p_id.'</td>';
                            $output .='<td>'.$key->pack_date.'</td>';
                            $output .='<td>'.$key->customer.'</td><td>';
                            $item_id=explode('|||',$y->item_id);
                            for($m=0;$m<sizeof($item_id);$m++)
                            {
                                $g=$this->pageModel->getallitemdetails($item_id[$m]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_id[$m].'<br>';
                                }
                            }
                            $output.='</td><td>';
                               $item_name=explode('|||',$y->item_name);
                            for($n=0;$n<sizeof($item_name);$n++)
                            {
                                $g=$this->pageModel->getallitemdetails($item_id[$n]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_name[$n].'<br>';
                                }
                            }
                            $output.='</td><td>';
                                 $item_qty=explode('|||',$y->item_qty);
                            for($d=0;$d<sizeof($item_qty);$d++)
                            {
                                $g=$this->pageModel->getallitemdetails($item_id[$d]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_qty[$d].'<br>';
                                }
                            }
                            $output.='</td><td>';
                             $item_rec=explode('|||',$y->item_rec);
                            for($f=0;$f<sizeof($item_rec);$f++)
                            {
                                $g=$this->pageModel->getallitemdetails($item_id[$f]);
                                if(($g->model_id)==$sort_id)
                                {
                                     if($item_rec[$f]==0)
                                    {
                                        $item_rec[$f] = "Carton";   
                                    }
                                    elseif($item_rec[$f]==1)
                                    {
                                        $item_rec[$f] = "Box";   
                                    }
                                    else
                                    {
                                        $item_rec[$f] = "Pieces";   
                                    }
                                    $output .=''.$item_rec[$f].'<br>';
                                }
                            }
                            
                            $output.='</td></tr>';
                            }
                        }
                    }
                    elseif($_SESSION['ctype'] == 5)
                    {
                        if($cp_cust->cp_priority==5)
                        {

                            $y=$key;
                            $z=$this->pageModel->getallitemdetails($y->item_id);
                            if(($z->model_id)==$sort_id){
                            $output .='<tr><td>'.$key->p_id.'</td>';
                            $output .='<td>'.$key->pack_date.'</td>';
                            $output .='<td>'.$key->customer.'</td><td>';
                            $item_id=explode('|||',$y->item_id);
                            for($m=0;$m<sizeof($item_id);$m++)
                            {
                                $g=$this->pageModel->getallitemdetails($item_id[$m]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_id[$m].'<br>';
                                }
                            }
                            $output.='</td><td>';
                               $item_name=explode('|||',$y->item_name);
                            for($n=0;$n<sizeof($item_name);$n++)
                            {
                                $g=$this->pageModel->getallitemdetails($item_id[$n]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_name[$n].'<br>';
                                }
                            }
                            $output.='</td><td>';
                                 $item_qty=explode('|||',$y->item_qty);
                            for($d=0;$d<sizeof($item_qty);$d++)
                            {
                                $g=$this->pageModel->getallitemdetails($item_id[$d]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_qty[$d].'<br>';
                                }
                            }
                            $output.='</td><td>';
                             $item_rec=explode('|||',$y->item_rec);
                            for($f=0;$f<sizeof($item_rec);$f++)
                            {
                                $g=$this->pageModel->getallitemdetails($item_id[$f]);
                                if(($g->model_id)==$sort_id)
                                {
                                     if($item_rec[$f]==0)
                                    {
                                        $item_rec[$f] = "Carton";   
                                    }
                                    elseif($item_rec[$f]==1)
                                    {
                                        $item_rec[$f] = "Box";   
                                    }
                                    else
                                    {
                                        $item_rec[$f] = "Pieces";   
                                    }
                                    $output .=''.$item_rec[$f].'<br>';
                                }
                            }
                            
                            $output.='</td></tr>';
                            }
                        }
                    }
                    elseif($_SESSION['ctype'] == 6)
                    {
                        if($cp_cust->cp_priority==6)
                        {

                            $y=$key;
                            $z=$this->pageModel->getallitemdetails($y->item_id);
                            if(($z->model_id)==$sort_id){
                            $output .='<tr><td>'.$key->p_id.'</td>';
                            $output .='<td>'.$key->pack_date.'</td>';
                            $output .='<td>'.$key->customer.'</td><td>';
                            $item_id=explode('|||',$y->item_id);
                            for($m=0;$m<sizeof($item_id);$m++)
                            {
                                $g=$this->pageModel->getallitemdetails($item_id[$m]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_id[$m].'<br>';
                                }
                            }
                            $output.='</td><td>';
                               $item_name=explode('|||',$y->item_name);
                            for($n=0;$n<sizeof($item_name);$n++)
                            {
                                $g=$this->pageModel->getallitemdetails($item_id[$n]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_name[$n].'<br>';
                                }
                            }
                            $output.='</td><td>';
                                 $item_qty=explode('|||',$y->item_qty);
                            for($d=0;$d<sizeof($item_qty);$d++)
                            {
                                $g=$this->pageModel->getallitemdetails($item_id[$d]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_qty[$d].'<br>';
                                }
                            }
                            $output.='</td><td>';
                             $item_rec=explode('|||',$y->item_rec);
                            for($f=0;$f<sizeof($item_rec);$f++)
                            {
                                $g=$this->pageModel->getallitemdetails($item_id[$f]);
                                if(($g->model_id)==$sort_id)
                                {
                                     if($item_rec[$f]==0)
                                    {
                                        $item_rec[$f] = "Carton";   
                                    }
                                    elseif($item_rec[$f]==1)
                                    {
                                        $item_rec[$f] = "Box";   
                                    }
                                    else
                                    {
                                        $item_rec[$f] = "Pieces";   
                                    }
                                    $output .=''.$item_rec[$f].'<br>';
                                }
                            }
                           
                            $output.='</td></tr>';
                            }
                        }
                    }
                    elseif($_SESSION['ctype'] == 7)
                    {
                        if($cp_cust->cp_priority==7)
                        {

                            $y=$key;
                            $z=$this->pageModel->getallitemdetails($y->item_id);
                            if(($z->model_id)==$sort_id){
                            $output .='<tr><td>'.$key->p_id.'</td>';
                            $output .='<td>'.$key->pack_date.'</td>';
                            $output .='<td>'.$key->customer.'</td><td>';
                            $item_id=explode('|||',$y->item_id);
                            for($m=0;$m<sizeof($item_id);$m++)
                            {
                                $g=$this->pageModel->getallitemdetails($item_id[$m]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_id[$m].'<br>';
                                }
                            }
                            $output.='</td><td>';
                               $item_name=explode('|||',$y->item_name);
                            for($n=0;$n<sizeof($item_name);$n++)
                            {
                                $g=$this->pageModel->getallitemdetails($item_id[$n]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_name[$n].'<br>';
                                }
                            }
                            $output.='</td><td>';
                                 $item_qty=explode('|||',$y->item_qty);
                            for($d=0;$d<sizeof($item_qty);$d++)
                            {
                                $g=$this->pageModel->getallitemdetails($item_id[$d]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_qty[$d].'<br>';
                                }
                            }
                            $output.='</td><td>';
                             $item_rec=explode('|||',$y->item_rec);
                            for($f=0;$f<sizeof($item_rec);$f++)
                            {
                                $g=$this->pageModel->getallitemdetails($item_id[$f]);
                                if(($g->model_id)==$sort_id)
                                {
                                     if($item_rec[$f]==0)
                                    {
                                        $item_rec[$f] = "Carton";   
                                    }
                                    elseif($item_rec[$f]==1)
                                    {
                                        $item_rec[$f] = "Box";   
                                    }
                                    else
                                    {
                                        $item_rec[$f] = "Pieces";   
                                    }
                                    $output .=''.$item_rec[$f].'<br>';
                                }
                            }
                           
                            $output.='</td></tr>';
                            }
                        }
                    }
                    elseif($_SESSION['ctype'] == 8)
                    {
                        if($cp_cust->cp_priority==8)
                        {

                            $y=$key;
                            $z=$this->pageModel->getallitemdetails($y->item_id);
                            if(($z->model_id)==$sort_id){
                            $output .='<tr><td>'.$key->p_id.'</td>';
                            $output .='<td>'.$key->pack_date.'</td>';
                            $output .='<td>'.$key->customer.'</td><td>';
                            $item_id=explode('|||',$y->item_id);
                            for($m=0;$m<sizeof($item_id);$m++)
                            {
                                $g=$this->pageModel->getallitemdetails($item_id[$m]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_id[$m].'<br>';
                                }
                            }
                            $output.='</td><td>';
                               $item_name=explode('|||',$y->item_name);
                            for($n=0;$n<sizeof($item_name);$n++)
                            {
                                $g=$this->pageModel->getallitemdetails($item_id[$n]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_name[$n].'<br>';
                                }
                            }
                            $output.='</td><td>';
                                 $item_qty=explode('|||',$y->item_qty);
                            for($d=0;$d<sizeof($item_qty);$d++)
                            {
                                $g=$this->pageModel->getallitemdetails($item_id[$d]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_qty[$d].'<br>';
                                }
                            }
                            $output.='</td><td>';
                             $item_rec=explode('|||',$y->item_rec);
                            for($f=0;$f<sizeof($item_rec);$f++)
                            {
                                $g=$this->pageModel->getallitemdetails($item_id[$f]);
                                if(($g->model_id)==$sort_id)
                                {
                                     if($item_rec[$f]==0)
                                    {
                                        $item_rec[$f] = "Carton";   
                                    }
                                    elseif($item_rec[$f]==1)
                                    {
                                        $item_rec[$f] = "Box";   
                                    }
                                    else
                                    {
                                        $item_rec[$f] = "Pieces";   
                                    }
                                    $output .=''.$item_rec[$f].'<br>';
                                }
                            }
                            
                            $output.='</td></tr>';
                            }
                        }
                    }
                    elseif($_SESSION['ctype'] == 9)
                    {
                        if($cp_cust->cp_priority==9)
                        {

                            $y=$key;
                            $z=$this->pageModel->getallitemdetails($y->item_id);
                            if(($z->model_id)==$sort_id){
                            $output .='<tr><td>'.$key->p_id.'</td>';
                            $output .='<td>'.$key->pack_date.'</td>';
                            $output .='<td>'.$key->customer.'</td><td>';
                            $item_id=explode('|||',$y->item_id);
                            for($m=0;$m<sizeof($item_id);$m++)
                            {
                                $g=$this->pageModel->getallitemdetails($item_id[$m]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_id[$m].'<br>';
                                }
                            }
                            $output.='</td><td>';
                               $item_name=explode('|||',$y->item_name);
                            for($n=0;$n<sizeof($item_name);$n++)
                            {
                                $g=$this->pageModel->getallitemdetails($item_id[$n]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_name[$n].'<br>';
                                }
                            }
                            $output.='</td><td>';
                                 $item_qty=explode('|||',$y->item_qty);
                            for($d=0;$d<sizeof($item_qty);$d++)
                            {
                                $g=$this->pageModel->getallitemdetails($item_id[$d]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_qty[$d].'<br>';
                                }
                            }
                            $output.='</td><td>';
                             $item_rec=explode('|||',$y->item_rec);
                            for($f=0;$f<sizeof($item_rec);$f++)
                            {
                                $g=$this->pageModel->getallitemdetails($item_id[$f]);
                                if(($g->model_id)==$sort_id)
                                {
                                     if($item_rec[$f]==0)
                                    {
                                        $item_rec[$f] = "Carton";   
                                    }
                                    elseif($item_rec[$f]==1)
                                    {
                                        $item_rec[$f] = "Box";   
                                    }
                                    else
                                    {
                                        $item_rec[$f] = "Pieces";   
                                    }
                                    $output .=''.$item_rec[$f].'<br>';
                                }
                            }
                            
                            $output.='</td></tr>';
                            }
                        }
                    }
                    else
                    {
                        if($cp_cust->cp_priority == 0)
                        {
                            $y=$key;
                            $z=$this->pageModel->getallitemdetails($y->item_id);
                            if(($z->model_id)==$sort_id){
                            $output .='<tr><td>'.$key->p_id.'</td>';
                            $output .='<td>'.$key->pack_date.'</td>';
                            $output .='<td>'.$key->customer.'</td><td>';
                            $item_id=explode('|||',$y->item_id);
                            for($m=0;$m<sizeof($item_id);$m++)
                            {
                                $g=$this->pageModel->getallitemdetails($item_id[$m]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_id[$m].'<br>';
                                }
                            }
                            $output.='</td><td>';
                               $item_name=explode('|||',$y->item_name);
                            for($n=0;$n<sizeof($item_name);$n++)
                            {
                                $g=$this->pageModel->getallitemdetails($item_id[$n]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_name[$n].'<br>';
                                }
                            }
                            $output.='</td><td>';
                                 $item_qty=explode('|||',$y->item_qty);
                            for($d=0;$d<sizeof($item_qty);$d++)
                            {
                                $g=$this->pageModel->getallitemdetails($item_id[$d]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_qty[$d].'<br>';
                                }
                            }
                            $output.='</td><td>';
                             $item_rec=explode('|||',$y->item_rec);
                            for($f=0;$f<sizeof($item_rec);$f++)
                            {
                                $g=$this->pageModel->getallitemdetails($item_id[$f]);
                                if(($g->model_id)==$sort_id)
                                {
                                     if($item_rec[$f]==0)
                                    {
                                        $item_rec[$f] = "Carton";   
                                    }
                                    elseif($item_rec[$f]==1)
                                    {
                                        $item_rec[$f] = "Box";   
                                    }
                                    else
                                    {
                                        $item_rec[$f] = "Pieces";   
                                    }
                                    $output .=''.$item_rec[$f].'<br>';
                                }
                            }
                            
                            $output.='</td></tr>';
                            }      
                        }
                    }
                }
            }
        echo $output;
    }
    ////////////////////////////PAGES CONTROLLERS - SHREYA/////////////////////////////////
    public function add_transport_details() {
        $data = [
            'lr_number' => $_POST['lr_number'],
            'name' => $_POST['name'],
            'details' => $_POST['details']
        ];
        $this->pageModel->add_transport_details($data);
        $_SESSION['success'] = "Transport details saved";
        redirect('pages/settings');
    }
    public function all_transportdetails() {
        $data=[
            'transport' => $this->pageModel->get_all_transportdetails(),
        ];
        $this->view('pages/all_transportdetails',$data);
    }
    public function editTransportDetails($id){
        $data = [
          'transport' => $this->pageModel->get_single_transport($id)
        ];
        $this->view('pages/editTransportDetails', $data);
    }
    public function updatetransportdetails() {
        $data = [
            'id' => $_POST['id'],
            'lr_number' => $_POST['lr_number'],
            'name' => $_POST['name'],
            'details' => $_POST['details'],
            'created_by' => $_POST['created_by']
        ];
        $this->pageModel->updatetransport_details($data);
        $_SESSION['success'] = "Transport details updated successfully";
        redirect('pages/all_transportdetails');
    }
    public function deleteTransportDetails($id){
        $this->pageModel->deletetransport_details($id);
        $_SESSION['success'] = "Transport details deleted successfully";
        redirect('pages/all_transportdetails');
    }
    /////////end///////
    public function by_allcategory_item_cat9()
    {
        $sort_id=$_POST['sort'];
        if($_POST['sort']==0)
        {
            $x=$this->pageModel->getallstockoutdetails1();
            $output = "";
            $cname = "";
            foreach ($x as $key)
            {   
                $cp_cust = $this->pageModel->get_all_customer_cp_priority($key->customer_id);
                if($_SESSION['ctype'] == 3)
                {
                    
                        $cname = $key->customer;
                        $y=$this->pageModel->getallstockoutorder1($key->id);
                        $h=$this->pageModel->getallstockpackage($y->stock_out_id);
                        $output .='<tr><td>'.$key->id.'</td>';
                        $output .='<td>'.$cname.'</td>';
                        $output .='<td>'.date("d-m-Y",strtotime($key->stock_dt)).'</td><td>';
                        $item_id=explode('|||',$y->item_id);
                        for($i=0;$i<sizeof($item_id);$i++)
                        {
                            $output .=''.$item_id[$i].'<br>';
                        }
                        $output.='</td><td>';
                        $item_name=explode('|||',$y->item_name);
                        for($j=0;$j<sizeof($item_name);$j++)
                        {
                            $output .=''.$item_name[$j].'<br>';
                        }
                        $output.='</td><td>';
                        $item_qty=explode('|||',$y->item_qty);
                        for($k=0;$k<sizeof($item_qty);$k++)
                        {
                            $output .=''.$item_qty[$k].'<br>';
                        }
                        $output.='</td><td>';
                        if(empty($h->item_packed))
                        {
                            $output .='0<br>'; 
                        }
                        else
                        {
                            $item_packed=explode('|||',$h->item_packed);
                            for($a=0;$a<sizeof($item_packed);$a++)
                            {
                                $output .=''.$item_packed[$a].'<br>';
                            }
                        }
                        $output.='</td><td>';
                        if(empty($h->item_to_pack))
                        {
                            $output .='0<br>'; 
                        }
                        else
                        {
                            $item_to_pack=explode('|||',$h->item_to_pack);
                            for($u=0;$u<sizeof($item_to_pack);$u++)
                            {
                                $output .=''.$item_to_pack[$u].'<br>';
                            }
                        }
                        $output.='</td></tr>';
                    
                }elseif($_SESSION['ctype'] == 1)
                {
                    if($cp_cust->cp_priority==1)
                    {
                        $cname = $key->customer;
                        $y=$this->pageModel->getallstockoutorder1($key->id);
                        $h=$this->pageModel->getallstockpackage($y->stock_out_id);
                        $output .='<tr><td>'.$key->id.'</td>';
                        $output .='<td>'.$cname.'</td>';
                        $output .='<td>'.date("d-m-Y",strtotime($key->stock_dt)).'</td><td>';
                        $item_id=explode('|||',$y->item_id);
                        for($i=0;$i<sizeof($item_id);$i++)
                        {
                            $output .=''.$item_id[$i].'<br>';
                        }
                        $output.='</td><td>';
                        $item_name=explode('|||',$y->item_name);
                        for($j=0;$j<sizeof($item_name);$j++)
                        {
                            $output .=''.$item_name[$j].'<br>';
                        }
                        $output.='</td><td>';
                        $item_qty=explode('|||',$y->item_qty);
                        for($k=0;$k<sizeof($item_qty);$k++)
                        {
                            $output .=''.$item_qty[$k].'<br>';
                        }
                        $output.='</td><td>';
                        if(empty($h->item_packed))
                        {
                            $output .='0<br>'; 
                        }
                        else
                        {
                            $item_packed=explode('|||',$h->item_packed);
                            for($a=0;$a<sizeof($item_packed);$a++)
                            {
                                $output .=''.$item_packed[$a].'<br>';
                            }
                        }
                        $output.='</td><td>';
                        if(empty($h->item_to_pack))
                        {
                            $output .='0<br>'; 
                        }
                        else
                        {
                            $item_to_pack=explode('|||',$h->item_to_pack);
                            for($u=0;$u<sizeof($item_to_pack);$u++)
                            {
                                $output .=''.$item_to_pack[$u].'<br>';
                            }
                        }
                        $output.='</td></tr>';
                    }
                }
                elseif($_SESSION['ctype'] == 4)
                {
                    if($cp_cust->cp_priority==4)
                    {
                        $cname = $key->customer;
                        $y=$this->pageModel->getallstockoutorder1($key->id);
                        $h=$this->pageModel->getallstockpackage($y->stock_out_id);
                        $output .='<tr><td>'.$key->id.'</td>';
                        $output .='<td>'.$cname.'</td>';
                        $output .='<td>'.date("d-m-Y",strtotime($key->stock_dt)).'</td><td>';
                        $item_id=explode('|||',$y->item_id);
                        for($i=0;$i<sizeof($item_id);$i++)
                        {
                            $output .=''.$item_id[$i].'<br>';
                        }
                        $output.='</td><td>';
                        $item_name=explode('|||',$y->item_name);
                        for($j=0;$j<sizeof($item_name);$j++)
                        {
                            $output .=''.$item_name[$j].'<br>';
                        }
                        $output.='</td><td>';
                        $item_qty=explode('|||',$y->item_qty);
                        for($k=0;$k<sizeof($item_qty);$k++)
                        {
                            $output .=''.$item_qty[$k].'<br>';
                        }
                        $output.='</td><td>';
                        if(empty($h->item_packed))
                        {
                            $output .='0<br>'; 
                        }
                        else
                        {
                            $item_packed=explode('|||',$h->item_packed);
                            for($a=0;$a<sizeof($item_packed);$a++)
                            {
                                $output .=''.$item_packed[$a].'<br>';
                            }
                        }
                        $output.='</td><td>';
                        if(empty($h->item_to_pack))
                        {
                            $output .='0<br>'; 
                        }
                        else
                        {
                            $item_to_pack=explode('|||',$h->item_to_pack);
                            for($u=0;$u<sizeof($item_to_pack);$u++)
                            {
                                $output .=''.$item_to_pack[$u].'<br>';
                            }
                        }
                        $output.='</td></tr>';
                    }
                }
                elseif($_SESSION['ctype'] == 5)
                {
                    if($cp_cust->cp_priority==5)
                    {
                        $cname = $key->customer;
                        $y=$this->pageModel->getallstockoutorder1($key->id);
                        $h=$this->pageModel->getallstockpackage($y->stock_out_id);
                        $output .='<tr><td>'.$key->id.'</td>';
                        $output .='<td>'.$cname.'</td>';
                        $output .='<td>'.date("d-m-Y",strtotime($key->stock_dt)).'</td><td>';
                        $item_id=explode('|||',$y->item_id);
                        for($i=0;$i<sizeof($item_id);$i++)
                        {
                            $output .=''.$item_id[$i].'<br>';
                        }
                        $output.='</td><td>';
                        $item_name=explode('|||',$y->item_name);
                        for($j=0;$j<sizeof($item_name);$j++)
                        {
                            $output .=''.$item_name[$j].'<br>';
                        }
                        $output.='</td><td>';
                        $item_qty=explode('|||',$y->item_qty);
                        for($k=0;$k<sizeof($item_qty);$k++)
                        {
                            $output .=''.$item_qty[$k].'<br>';
                        }
                        $output.='</td><td>';
                        if(empty($h->item_packed))
                        {
                            $output .='0<br>'; 
                        }
                        else
                        {
                            $item_packed=explode('|||',$h->item_packed);
                            for($a=0;$a<sizeof($item_packed);$a++)
                            {
                                $output .=''.$item_packed[$a].'<br>';
                            }
                        }
                        $output.='</td><td>';
                        if(empty($h->item_to_pack))
                        {
                            $output .='0<br>'; 
                        }
                        else
                        {
                            $item_to_pack=explode('|||',$h->item_to_pack);
                            for($u=0;$u<sizeof($item_to_pack);$u++)
                            {
                                $output .=''.$item_to_pack[$u].'<br>';
                            }
                        }
                        $output.='</td></tr>';
                    }
                }
                elseif($_SESSION['ctype'] == 6)
                {
                    if($cp_cust->cp_priority==6)
                    {
                        $cname = $key->customer;
                        $y=$this->pageModel->getallstockoutorder1($key->id);
                        $h=$this->pageModel->getallstockpackage($y->stock_out_id);
                        $output .='<tr><td>'.$key->id.'</td>';
                        $output .='<td>'.$cname.'</td>';
                        $output .='<td>'.date("d-m-Y",strtotime($key->stock_dt)).'</td><td>';
                        $item_id=explode('|||',$y->item_id);
                        for($i=0;$i<sizeof($item_id);$i++)
                        {
                            $output .=''.$item_id[$i].'<br>';
                        }
                        $output.='</td><td>';
                        $item_name=explode('|||',$y->item_name);
                        for($j=0;$j<sizeof($item_name);$j++)
                        {
                            $output .=''.$item_name[$j].'<br>';
                        }
                        $output.='</td><td>';
                        $item_qty=explode('|||',$y->item_qty);
                        for($k=0;$k<sizeof($item_qty);$k++)
                        {
                            $output .=''.$item_qty[$k].'<br>';
                        }
                        $output.='</td><td>';
                        if(empty($h->item_packed))
                        {
                            $output .='0<br>'; 
                        }
                        else
                        {
                            $item_packed=explode('|||',$h->item_packed);
                            for($a=0;$a<sizeof($item_packed);$a++)
                            {
                                $output .=''.$item_packed[$a].'<br>';
                            }
                        }
                        $output.='</td><td>';
                        if(empty($h->item_to_pack))
                        {
                            $output .='0<br>'; 
                        }
                        else
                        {
                            $item_to_pack=explode('|||',$h->item_to_pack);
                            for($u=0;$u<sizeof($item_to_pack);$u++)
                            {
                                $output .=''.$item_to_pack[$u].'<br>';
                            }
                        }
                        $output.='</td></tr>';
                    }
                }
                elseif($_SESSION['ctype'] == 7)
                {
                    if($cp_cust->cp_priority==7)
                    {
                        $cname = $key->customer;
                        $y=$this->pageModel->getallstockoutorder1($key->id);
                        $h=$this->pageModel->getallstockpackage($y->stock_out_id);
                        $output .='<tr><td>'.$key->id.'</td>';
                        $output .='<td>'.$cname.'</td>';
                        $output .='<td>'.date("d-m-Y",strtotime($key->stock_dt)).'</td><td>';
                        $item_id=explode('|||',$y->item_id);
                        for($i=0;$i<sizeof($item_id);$i++)
                        {
                            $output .=''.$item_id[$i].'<br>';
                        }
                        $output.='</td><td>';
                        $item_name=explode('|||',$y->item_name);
                        for($j=0;$j<sizeof($item_name);$j++)
                        {
                            $output .=''.$item_name[$j].'<br>';
                        }
                        $output.='</td><td>';
                        $item_qty=explode('|||',$y->item_qty);
                        for($k=0;$k<sizeof($item_qty);$k++)
                        {
                            $output .=''.$item_qty[$k].'<br>';
                        }
                        $output.='</td><td>';
                        if(empty($h->item_packed))
                        {
                            $output .='0<br>'; 
                        }
                        else
                        {
                            $item_packed=explode('|||',$h->item_packed);
                            for($a=0;$a<sizeof($item_packed);$a++)
                            {
                                $output .=''.$item_packed[$a].'<br>';
                            }
                        }
                        $output.='</td><td>';
                        if(empty($h->item_to_pack))
                        {
                            $output .='0<br>'; 
                        }
                        else
                        {
                            $item_to_pack=explode('|||',$h->item_to_pack);
                            for($u=0;$u<sizeof($item_to_pack);$u++)
                            {
                                $output .=''.$item_to_pack[$u].'<br>';
                            }
                        }
                        $output.='</td></tr>';
                    }
                }
                elseif($_SESSION['ctype'] == 8)
                {
                    if($cp_cust->cp_priority==8)
                    {
                        $cname = $key->customer;
                        $y=$this->pageModel->getallstockoutorder1($key->id);
                        $h=$this->pageModel->getallstockpackage($y->stock_out_id);
                        $output .='<tr><td>'.$key->id.'</td>';
                        $output .='<td>'.$cname.'</td>';
                        $output .='<td>'.date("d-m-Y",strtotime($key->stock_dt)).'</td><td>';
                        $item_id=explode('|||',$y->item_id);
                        for($i=0;$i<sizeof($item_id);$i++)
                        {
                            $output .=''.$item_id[$i].'<br>';
                        }
                        $output.='</td><td>';
                        $item_name=explode('|||',$y->item_name);
                        for($j=0;$j<sizeof($item_name);$j++)
                        {
                            $output .=''.$item_name[$j].'<br>';
                        }
                        $output.='</td><td>';
                        $item_qty=explode('|||',$y->item_qty);
                        for($k=0;$k<sizeof($item_qty);$k++)
                        {
                            $output .=''.$item_qty[$k].'<br>';
                        }
                        $output.='</td><td>';
                        if(empty($h->item_packed))
                        {
                            $output .='0<br>'; 
                        }
                        else
                        {
                            $item_packed=explode('|||',$h->item_packed);
                            for($a=0;$a<sizeof($item_packed);$a++)
                            {
                                $output .=''.$item_packed[$a].'<br>';
                            }
                        }
                        $output.='</td><td>';
                        if(empty($h->item_to_pack))
                        {
                            $output .='0<br>'; 
                        }
                        else
                        {
                            $item_to_pack=explode('|||',$h->item_to_pack);
                            for($u=0;$u<sizeof($item_to_pack);$u++)
                            {
                                $output .=''.$item_to_pack[$u].'<br>';
                            }
                        }
                        $output.='</td></tr>';
                    }
                }
                elseif($_SESSION['ctype'] == 9)
                {
                    if($cp_cust->cp_priority==9)
                    {
                        $cname = $key->customer;
                        $y=$this->pageModel->getallstockoutorder1($key->id);
                        $h=$this->pageModel->getallstockpackage($y->stock_out_id);
                        $output .='<tr><td>'.$key->id.'</td>';
                        $output .='<td>'.$cname.'</td>';
                        $output .='<td>'.date("d-m-Y",strtotime($key->stock_dt)).'</td><td>';
                        $item_id=explode('|||',$y->item_id);
                        for($i=0;$i<sizeof($item_id);$i++)
                        {
                            $output .=''.$item_id[$i].'<br>';
                        }
                        $output.='</td><td>';
                        $item_name=explode('|||',$y->item_name);
                        for($j=0;$j<sizeof($item_name);$j++)
                        {
                            $output .=''.$item_name[$j].'<br>';
                        }
                        $output.='</td><td>';
                        $item_qty=explode('|||',$y->item_qty);
                        for($k=0;$k<sizeof($item_qty);$k++)
                        {
                            $output .=''.$item_qty[$k].'<br>';
                        }
                        $output.='</td><td>';
                        if(empty($h->item_packed))
                        {
                            $output .='0<br>'; 
                        }
                        else
                        {
                            $item_packed=explode('|||',$h->item_packed);
                            for($a=0;$a<sizeof($item_packed);$a++)
                            {
                                $output .=''.$item_packed[$a].'<br>';
                            }
                        }
                        $output.='</td><td>';
                        if(empty($h->item_to_pack))
                        {
                            $output .='0<br>'; 
                        }
                        else
                        {
                            $item_to_pack=explode('|||',$h->item_to_pack);
                            for($u=0;$u<sizeof($item_to_pack);$u++)
                            {
                                $output .=''.$item_to_pack[$u].'<br>';
                            }
                        }
                        $output.='</td></tr>';
                    }
                }
                else
                {
                    if($cp_cust->cp_priority==0)
                    {
                        $cname = $key->customer;
                        $y=$this->pageModel->getallstockoutorder1($key->id);
                        $h=$this->pageModel->getallstockpackage($y->stock_out_id);
                        $output .='<tr><td>'.$key->id.'</td>';
                        $output .='<td>'.$cname.'</td>';
                        $output .='<td>'.date("d-m-Y",strtotime($key->stock_dt)).'</td><td>';
                        $item_id=explode('|||',$y->item_id);
                        for($i=0;$i<sizeof($item_id);$i++)
                        {
                            $output .=''.$item_id[$i].'<br>';
                        }
                        $output.='</td><td>';
                        $item_name=explode('|||',$y->item_name);
                        for($j=0;$j<sizeof($item_name);$j++)
                        {
                            $output .=''.$item_name[$j].'<br>';
                        }
                        $output.='</td><td>';
                        $item_qty=explode('|||',$y->item_qty);
                        for($k=0;$k<sizeof($item_qty);$k++)
                        {
                            $output .=''.$item_qty[$k].'<br>';
                        }
                        $output.='</td><td>';
                        if(empty($h->item_packed))
                        {
                            $output .='0<br>'; 
                        }
                        else
                        {
                            $item_packed=explode('|||',$h->item_packed);
                            for($a=0;$a<sizeof($item_packed);$a++)
                            {
                                $output .=''.$item_packed[$a].'<br>';
                            }
                        }
                        $output.='</td><td>';
                        if(empty($h->item_to_pack))
                        {
                            $output .='0<br>'; 
                        }
                        else
                        {
                            $item_to_pack=explode('|||',$h->item_to_pack);
                            for($u=0;$u<sizeof($item_to_pack);$u++)
                            {
                                $output .=''.$item_to_pack[$u].'<br>';
                            }
                        }
                        $output.='</td></tr>';        
                    }
                }
            }
        } 
        else
        {
            $x=$this->pageModel->getallstockoutdetails1();
            $output = "";
            foreach($x as $key)
            {
                $cp_cust = $this->pageModel->get_all_customer_cp_priority($key->customer_id);
                if($_SESSION['ctype'] == 3)
                {
                        $cname = $key->customer;
                        $y=$this->pageModel->getallstockoutorder1($key->id);
                        $z=$this->pageModel->getallitemdetails1($y->item_id);
                        $h=$this->pageModel->getallstockpackage($y->stock_out_id);
                        if(($z->model_id)==$sort_id)
                        {
                            $output .='<tr><td>'.$key->id.'</td>';

                            $output .='<td>'.$cname.'</td>';
                            $output .='<td>'.date("d-m-Y",strtotime($key->stock_dt)).'</td><td>';
                            $item_id=explode('|||',$y->item_id);
                            for($m=0;$m<sizeof($item_id);$m++)
                            {
                                $g=$this->pageModel->getallitemdetails1($item_id[$m]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_id[$m].'<br>';
                                }
                            }
                            $output.='</td><td>';
                            $item_name=explode('|||',$y->item_name);
                            for($n=0;$n<sizeof($item_name);$n++)
                            {
                                $g=$this->pageModel->getallitemdetails1($item_id[$n]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_name[$n].'<br>';
                                }
                            }
                            $output.='</td><td>';
                            $item_qty=explode('|||',$y->item_qty);
                            for($d=0;$d<sizeof($item_qty);$d++)
                            {
                                $g=$this->pageModel->getallitemdetails1($item_id[$d]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_qty[$d].'<br>';
                                }
                            }
                            $output.='</td><td>';
                            if(empty($h->item_packed))
                            {
                            }
                            else
                            {
                                $item_packed=explode('|||',$h->item_packed);
                                for($t=0;$t<sizeof($item_packed);$t++)
                                {
                                    $g=$this->pageModel->getallitemdetails1($item_id[$t]);
                                    if(($g->model_id)==$sort_id)
                                    {
                                        $output .=''.$item_packed[$t].'<br>';
                                    }
                                }
                            }
                            $output.='</td><td>';
                            if(empty($h->item_to_pack))
                            {
                            }
                            else
                            {
                                $item_to_pack=explode('|||',$h->item_to_pack);
                                for($e=0;$e<sizeof($item_to_pack);$e++)
                                {
                                    $g=$this->pageModel->getallitemdetails1($item_id[$e]);
                                    if(($g->model_id)==$sort_id)
                                    {
                                        $output .=''.$item_to_pack[$e].'<br>';
                                    }
                                }
                            }
                            $output.='</td></tr>';
                        }
                    
                }elseif($_SESSION['ctype'] == 1)
                {
                    if($cp_cust->cp_priority==1)
                    {

                        $cname = $key->customer;
                        $y=$this->pageModel->getallstockoutorder1($key->id);
                        $z=$this->pageModel->getallitemdetails1($y->item_id);
                        $h=$this->pageModel->getallstockpackage($y->stock_out_id);
                        if(($z->model_id)==$sort_id)
                        {
                            $output .='<tr><td>'.$key->id.'</td>';

                            $output .='<td>'.$cname.'</td>';
                            $output .='<td>'.date("d-m-Y",strtotime($key->stock_dt)).'</td><td>';
                            $item_id=explode('|||',$y->item_id);
                            for($m=0;$m<sizeof($item_id);$m++)
                            {
                                $g=$this->pageModel->getallitemdetails1($item_id[$m]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_id[$m].'<br>';
                                }
                            }
                            $output.='</td><td>';
                            $item_name=explode('|||',$y->item_name);
                            for($n=0;$n<sizeof($item_name);$n++)
                            {
                                $g=$this->pageModel->getallitemdetails1($item_id[$n]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_name[$n].'<br>';
                                }
                            }
                            $output.='</td><td>';
                            $item_qty=explode('|||',$y->item_qty);
                            for($d=0;$d<sizeof($item_qty);$d++)
                            {
                                $g=$this->pageModel->getallitemdetails1($item_id[$d]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_qty[$d].'<br>';
                                }
                            }
                            $output.='</td><td>';
                            if(empty($h->item_packed))
                            {
                            }
                            else
                            {
                                $item_packed=explode('|||',$h->item_packed);
                                for($t=0;$t<sizeof($item_packed);$t++)
                                {
                                    $g=$this->pageModel->getallitemdetails1($item_id[$t]);
                                    if(($g->model_id)==$sort_id)
                                    {
                                        $output .=''.$item_packed[$t].'<br>';
                                    }
                                }
                            }
                            $output.='</td><td>';
                            if(empty($h->item_to_pack))
                            {
                            }
                            else
                            {
                                $item_to_pack=explode('|||',$h->item_to_pack);
                                for($e=0;$e<sizeof($item_to_pack);$e++)
                                {
                                    $g=$this->pageModel->getallitemdetails1($item_id[$e]);
                                    if(($g->model_id)==$sort_id)
                                    {
                                        $output .=''.$item_to_pack[$e].'<br>';
                                    }
                                }
                            }
                            $output.='</td></tr>';
                        }
                    }
                }
                elseif($_SESSION['ctype'] == 4)
                {
                    if($cp_cust->cp_priority==4)
                    {

                        $cname = $key->customer;
                        $y=$this->pageModel->getallstockoutorder1($key->id);
                        $z=$this->pageModel->getallitemdetails1($y->item_id);
                        $h=$this->pageModel->getallstockpackage($y->stock_out_id);
                        if(($z->model_id)==$sort_id)
                        {
                            $output .='<tr><td>'.$key->id.'</td>';

                            $output .='<td>'.$cname.'</td>';
                            $output .='<td>'.date("d-m-Y",strtotime($key->stock_dt)).'</td><td>';
                            $item_id=explode('|||',$y->item_id);
                            for($m=0;$m<sizeof($item_id);$m++)
                            {
                                $g=$this->pageModel->getallitemdetails1($item_id[$m]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_id[$m].'<br>';
                                }
                            }
                            $output.='</td><td>';
                            $item_name=explode('|||',$y->item_name);
                            for($n=0;$n<sizeof($item_name);$n++)
                            {
                                $g=$this->pageModel->getallitemdetails1($item_id[$n]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_name[$n].'<br>';
                                }
                            }
                            $output.='</td><td>';
                            $item_qty=explode('|||',$y->item_qty);
                            for($d=0;$d<sizeof($item_qty);$d++)
                            {
                                $g=$this->pageModel->getallitemdetails1($item_id[$d]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_qty[$d].'<br>';
                                }
                            }
                            $output.='</td><td>';
                            if(empty($h->item_packed))
                            {
                            }
                            else
                            {
                                $item_packed=explode('|||',$h->item_packed);
                                for($t=0;$t<sizeof($item_packed);$t++)
                                {
                                    $g=$this->pageModel->getallitemdetails1($item_id[$t]);
                                    if(($g->model_id)==$sort_id)
                                    {
                                        $output .=''.$item_packed[$t].'<br>';
                                    }
                                }
                            }
                            $output.='</td><td>';
                            if(empty($h->item_to_pack))
                            {
                            }
                            else
                            {
                                $item_to_pack=explode('|||',$h->item_to_pack);
                                for($e=0;$e<sizeof($item_to_pack);$e++)
                                {
                                    $g=$this->pageModel->getallitemdetails1($item_id[$e]);
                                    if(($g->model_id)==$sort_id)
                                    {
                                        $output .=''.$item_to_pack[$e].'<br>';
                                    }
                                }
                            }
                            $output.='</td></tr>';
                        }
                    }
                }
                elseif($_SESSION['ctype'] == 5)
                {
                    if($cp_cust->cp_priority==5)
                    {

                        $cname = $key->customer;
                        $y=$this->pageModel->getallstockoutorder1($key->id);
                        $z=$this->pageModel->getallitemdetails1($y->item_id);
                        $h=$this->pageModel->getallstockpackage($y->stock_out_id);
                        if(($z->model_id)==$sort_id)
                        {
                            $output .='<tr><td>'.$key->id.'</td>';

                            $output .='<td>'.$cname.'</td>';
                            $output .='<td>'.date("d-m-Y",strtotime($key->stock_dt)).'</td><td>';
                            $item_id=explode('|||',$y->item_id);
                            for($m=0;$m<sizeof($item_id);$m++)
                            {
                                $g=$this->pageModel->getallitemdetails1($item_id[$m]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_id[$m].'<br>';
                                }
                            }
                            $output.='</td><td>';
                            $item_name=explode('|||',$y->item_name);
                            for($n=0;$n<sizeof($item_name);$n++)
                            {
                                $g=$this->pageModel->getallitemdetails1($item_id[$n]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_name[$n].'<br>';
                                }
                            }
                            $output.='</td><td>';
                            $item_qty=explode('|||',$y->item_qty);
                            for($d=0;$d<sizeof($item_qty);$d++)
                            {
                                $g=$this->pageModel->getallitemdetails1($item_id[$d]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_qty[$d].'<br>';
                                }
                            }
                            $output.='</td><td>';
                            if(empty($h->item_packed))
                            {
                            }
                            else
                            {
                                $item_packed=explode('|||',$h->item_packed);
                                for($t=0;$t<sizeof($item_packed);$t++)
                                {
                                    $g=$this->pageModel->getallitemdetails1($item_id[$t]);
                                    if(($g->model_id)==$sort_id)
                                    {
                                        $output .=''.$item_packed[$t].'<br>';
                                    }
                                }
                            }
                            $output.='</td><td>';
                            if(empty($h->item_to_pack))
                            {
                            }
                            else
                            {
                                $item_to_pack=explode('|||',$h->item_to_pack);
                                for($e=0;$e<sizeof($item_to_pack);$e++)
                                {
                                    $g=$this->pageModel->getallitemdetails1($item_id[$e]);
                                    if(($g->model_id)==$sort_id)
                                    {
                                        $output .=''.$item_to_pack[$e].'<br>';
                                    }
                                }
                            }
                            $output.='</td></tr>';
                        }
                    }
                }
                elseif($_SESSION['ctype'] == 6)
                {
                    if($cp_cust->cp_priority==6)
                    {

                        $cname = $key->customer;
                        $y=$this->pageModel->getallstockoutorder1($key->id);
                        $z=$this->pageModel->getallitemdetails1($y->item_id);
                        $h=$this->pageModel->getallstockpackage($y->stock_out_id);
                        if(($z->model_id)==$sort_id)
                        {
                            $output .='<tr><td>'.$key->id.'</td>';

                            $output .='<td>'.$cname.'</td>';
                            $output .='<td>'.date("d-m-Y",strtotime($key->stock_dt)).'</td><td>';
                            $item_id=explode('|||',$y->item_id);
                            for($m=0;$m<sizeof($item_id);$m++)
                            {
                                $g=$this->pageModel->getallitemdetails1($item_id[$m]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_id[$m].'<br>';
                                }
                            }
                            $output.='</td><td>';
                            $item_name=explode('|||',$y->item_name);
                            for($n=0;$n<sizeof($item_name);$n++)
                            {
                                $g=$this->pageModel->getallitemdetails1($item_id[$n]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_name[$n].'<br>';
                                }
                            }
                            $output.='</td><td>';
                            $item_qty=explode('|||',$y->item_qty);
                            for($d=0;$d<sizeof($item_qty);$d++)
                            {
                                $g=$this->pageModel->getallitemdetails1($item_id[$d]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_qty[$d].'<br>';
                                }
                            }
                            $output.='</td><td>';
                            if(empty($h->item_packed))
                            {
                            }
                            else
                            {
                                $item_packed=explode('|||',$h->item_packed);
                                for($t=0;$t<sizeof($item_packed);$t++)
                                {
                                    $g=$this->pageModel->getallitemdetails1($item_id[$t]);
                                    if(($g->model_id)==$sort_id)
                                    {
                                        $output .=''.$item_packed[$t].'<br>';
                                    }
                                }
                            }
                            $output.='</td><td>';
                            if(empty($h->item_to_pack))
                            {
                            }
                            else
                            {
                                $item_to_pack=explode('|||',$h->item_to_pack);
                                for($e=0;$e<sizeof($item_to_pack);$e++)
                                {
                                    $g=$this->pageModel->getallitemdetails1($item_id[$e]);
                                    if(($g->model_id)==$sort_id)
                                    {
                                        $output .=''.$item_to_pack[$e].'<br>';
                                    }
                                }
                            }
                            $output.='</td></tr>';
                        }
                    }
                }
                elseif($_SESSION['ctype'] == 7)
                {
                    if($cp_cust->cp_priority==7)
                    {

                        $cname = $key->customer;
                        $y=$this->pageModel->getallstockoutorder1($key->id);
                        $z=$this->pageModel->getallitemdetails1($y->item_id);
                        $h=$this->pageModel->getallstockpackage($y->stock_out_id);
                        if(($z->model_id)==$sort_id)
                        {
                            $output .='<tr><td>'.$key->id.'</td>';

                            $output .='<td>'.$cname.'</td>';
                            $output .='<td>'.date("d-m-Y",strtotime($key->stock_dt)).'</td><td>';
                            $item_id=explode('|||',$y->item_id);
                            for($m=0;$m<sizeof($item_id);$m++)
                            {
                                $g=$this->pageModel->getallitemdetails1($item_id[$m]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_id[$m].'<br>';
                                }
                            }
                            $output.='</td><td>';
                            $item_name=explode('|||',$y->item_name);
                            for($n=0;$n<sizeof($item_name);$n++)
                            {
                                $g=$this->pageModel->getallitemdetails1($item_id[$n]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_name[$n].'<br>';
                                }
                            }
                            $output.='</td><td>';
                            $item_qty=explode('|||',$y->item_qty);
                            for($d=0;$d<sizeof($item_qty);$d++)
                            {
                                $g=$this->pageModel->getallitemdetails1($item_id[$d]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_qty[$d].'<br>';
                                }
                            }
                            $output.='</td><td>';
                            if(empty($h->item_packed))
                            {
                            }
                            else
                            {
                                $item_packed=explode('|||',$h->item_packed);
                                for($t=0;$t<sizeof($item_packed);$t++)
                                {
                                    $g=$this->pageModel->getallitemdetails1($item_id[$t]);
                                    if(($g->model_id)==$sort_id)
                                    {
                                        $output .=''.$item_packed[$t].'<br>';
                                    }
                                }
                            }
                            $output.='</td><td>';
                            if(empty($h->item_to_pack))
                            {
                            }
                            else
                            {
                                $item_to_pack=explode('|||',$h->item_to_pack);
                                for($e=0;$e<sizeof($item_to_pack);$e++)
                                {
                                    $g=$this->pageModel->getallitemdetails1($item_id[$e]);
                                    if(($g->model_id)==$sort_id)
                                    {
                                        $output .=''.$item_to_pack[$e].'<br>';
                                    }
                                }
                            }
                            $output.='</td></tr>';
                        }
                    }
                }
                elseif($_SESSION['ctype'] == 8)
                {
                    if($cp_cust->cp_priority==8)
                    {

                        $cname = $key->customer;
                        $y=$this->pageModel->getallstockoutorder1($key->id);
                        $z=$this->pageModel->getallitemdetails1($y->item_id);
                        $h=$this->pageModel->getallstockpackage($y->stock_out_id);
                        if(($z->model_id)==$sort_id)
                        {
                            $output .='<tr><td>'.$key->id.'</td>';

                            $output .='<td>'.$cname.'</td>';
                            $output .='<td>'.date("d-m-Y",strtotime($key->stock_dt)).'</td><td>';
                            $item_id=explode('|||',$y->item_id);
                            for($m=0;$m<sizeof($item_id);$m++)
                            {
                                $g=$this->pageModel->getallitemdetails1($item_id[$m]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_id[$m].'<br>';
                                }
                            }
                            $output.='</td><td>';
                            $item_name=explode('|||',$y->item_name);
                            for($n=0;$n<sizeof($item_name);$n++)
                            {
                                $g=$this->pageModel->getallitemdetails1($item_id[$n]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_name[$n].'<br>';
                                }
                            }
                            $output.='</td><td>';
                            $item_qty=explode('|||',$y->item_qty);
                            for($d=0;$d<sizeof($item_qty);$d++)
                            {
                                $g=$this->pageModel->getallitemdetails1($item_id[$d]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_qty[$d].'<br>';
                                }
                            }
                            $output.='</td><td>';
                            if(empty($h->item_packed))
                            {
                            }
                            else
                            {
                                $item_packed=explode('|||',$h->item_packed);
                                for($t=0;$t<sizeof($item_packed);$t++)
                                {
                                    $g=$this->pageModel->getallitemdetails1($item_id[$t]);
                                    if(($g->model_id)==$sort_id)
                                    {
                                        $output .=''.$item_packed[$t].'<br>';
                                    }
                                }
                            }
                            $output.='</td><td>';
                            if(empty($h->item_to_pack))
                            {
                            }
                            else
                            {
                                $item_to_pack=explode('|||',$h->item_to_pack);
                                for($e=0;$e<sizeof($item_to_pack);$e++)
                                {
                                    $g=$this->pageModel->getallitemdetails1($item_id[$e]);
                                    if(($g->model_id)==$sort_id)
                                    {
                                        $output .=''.$item_to_pack[$e].'<br>';
                                    }
                                }
                            }
                            $output.='</td></tr>';
                        }
                    }
                }
                elseif($_SESSION['ctype'] == 9)
                {
                    if($cp_cust->cp_priority==9)
                    {

                        $cname = $key->customer;
                        $y=$this->pageModel->getallstockoutorder1($key->id);
                        $z=$this->pageModel->getallitemdetails1($y->item_id);
                        $h=$this->pageModel->getallstockpackage($y->stock_out_id);
                        if(($z->model_id)==$sort_id)
                        {
                            $output .='<tr><td>'.$key->id.'</td>';

                            $output .='<td>'.$cname.'</td>';
                            $output .='<td>'.date("d-m-Y",strtotime($key->stock_dt)).'</td><td>';
                            $item_id=explode('|||',$y->item_id);
                            for($m=0;$m<sizeof($item_id);$m++)
                            {
                                $g=$this->pageModel->getallitemdetails1($item_id[$m]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_id[$m].'<br>';
                                }
                            }
                            $output.='</td><td>';
                            $item_name=explode('|||',$y->item_name);
                            for($n=0;$n<sizeof($item_name);$n++)
                            {
                                $g=$this->pageModel->getallitemdetails1($item_id[$n]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_name[$n].'<br>';
                                }
                            }
                            $output.='</td><td>';
                            $item_qty=explode('|||',$y->item_qty);
                            for($d=0;$d<sizeof($item_qty);$d++)
                            {
                                $g=$this->pageModel->getallitemdetails1($item_id[$d]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_qty[$d].'<br>';
                                }
                            }
                            $output.='</td><td>';
                            if(empty($h->item_packed))
                            {
                            }
                            else
                            {
                                $item_packed=explode('|||',$h->item_packed);
                                for($t=0;$t<sizeof($item_packed);$t++)
                                {
                                    $g=$this->pageModel->getallitemdetails1($item_id[$t]);
                                    if(($g->model_id)==$sort_id)
                                    {
                                        $output .=''.$item_packed[$t].'<br>';
                                    }
                                }
                            }
                            $output.='</td><td>';
                            if(empty($h->item_to_pack))
                            {
                            }
                            else
                            {
                                $item_to_pack=explode('|||',$h->item_to_pack);
                                for($e=0;$e<sizeof($item_to_pack);$e++)
                                {
                                    $g=$this->pageModel->getallitemdetails1($item_id[$e]);
                                    if(($g->model_id)==$sort_id)
                                    {
                                        $output .=''.$item_to_pack[$e].'<br>';
                                    }
                                }
                            }
                            $output.='</td></tr>';
                        }
                    }
                }
                else
                {
                    if($cp_cust->cp_priority==0)
                    {

                        $cname = $key->customer;
                        $y=$this->pageModel->getallstockoutorder1($key->id);
                        $z=$this->pageModel->getallitemdetails1($y->item_id);
                        $h=$this->pageModel->getallstockpackage($y->stock_out_id);
                        if(($z->model_id)==$sort_id)
                        {
                            $output .='<tr><td>'.$key->id.'</td>';

                            $output .='<td>'.$cname.'</td>';
                            $output .='<td>'.date("d-m-Y",strtotime($key->stock_dt)).'</td><td>';
                            $item_id=explode('|||',$y->item_id);
                            for($m=0;$m<sizeof($item_id);$m++)
                            {
                                $g=$this->pageModel->getallitemdetails1($item_id[$m]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_id[$m].'<br>';
                                }
                            }
                            $output.='</td><td>';
                            $item_name=explode('|||',$y->item_name);
                            for($n=0;$n<sizeof($item_name);$n++)
                            {
                                $g=$this->pageModel->getallitemdetails1($item_id[$n]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_name[$n].'<br>';
                                }
                            }
                            $output.='</td><td>';
                            $item_qty=explode('|||',$y->item_qty);
                            for($d=0;$d<sizeof($item_qty);$d++)
                            {
                                $g=$this->pageModel->getallitemdetails1($item_id[$d]);
                                if(($g->model_id)==$sort_id)
                                {
                                    $output .=''.$item_qty[$d].'<br>';
                                }
                            }
                            $output.='</td><td>';
                            if(empty($h->item_packed))
                            {
                            }
                            else
                            {
                                $item_packed=explode('|||',$h->item_packed);
                                for($t=0;$t<sizeof($item_packed);$t++)
                                {
                                    $g=$this->pageModel->getallitemdetails1($item_id[$t]);
                                    if(($g->model_id)==$sort_id)
                                    {
                                        $output .=''.$item_packed[$t].'<br>';
                                    }
                                }
                            }
                            $output.='</td><td>';
                            if(empty($h->item_to_pack))
                            {
                            }
                            else
                            {
                                $item_to_pack=explode('|||',$h->item_to_pack);
                                for($e=0;$e<sizeof($item_to_pack);$e++)
                                {
                                    $g=$this->pageModel->getallitemdetails1($item_id[$e]);
                                    if(($g->model_id)==$sort_id)
                                    {
                                        $output .=''.$item_to_pack[$e].'<br>';
                                    }
                                }
                            }
                            $output.='</td></tr>';
                        }
                    }        
                }
            }
        }
        echo $output;
    }
    public function item_by_category8(){
             $data=[
                   'mod' => $this->pageModel->getallmodeldetails1(),
            ];
           $this->view('pages/item_by_category8',$data);
    }
    public function editPurchaseOrder($pid)
    {
        $poBasicDetails = $this->pageModel->getThePreviousPurchaseOrderById($pid);
        $poDetails = $this->pageModel->getThePreviousPurchaseById($pid);
        $this->pageModel->insertIntoTempData($poBasicDetails);
        $purchaseDetails = $this->pageModel->getPurchaseDetails($pid);
        $purchaseOrderDetails = $this->pageModel->getPurchaseOrderDetails($pid);
        $data = [       
            'vendor' =>$this->pageModel->get_all_vendor(),
            'cdetails' => $this->pageModel->get_company_details(),
            'all_items' => $this->pageModel->get_all_items_for_dropdown(),
            'cat' => $this->pageModel->getAllCategoriesDb(),
            'cat1' => $this->pageModel->getAllCategoriesDb2(),
            'cat2' => $this->pageModel->getAllCategoriesDb3(),
            'cat3' => $this->pageModel->getAllCategoriesDb4(),
            'type' => $this->pageModel->getAlltypeDb(),
            'model' => $this->pageModel->getAllCategoriesDb_model(),
            'cat_new' => $this->pageModel->getAllCategoriesDb_new(),
            'subcat_new' => $this->pageModel->getAllsubCategoriesDb_new(),
            'color' => $this->pageModel->getAllcolorDb_new(),
            'size' => $this->pageModel->getAllsizeDb_new(),
            'all_mfg' => $this->pageModel->getallmfg(),
            'poDetails' => $poBasicDetails,
            'purchaseDetails' => $purchaseDetails,
            'purchaseOrderDetails' => $purchaseOrderDetails,
            'pid'=>$pid,
        ];
        $this->view('pages/editPurchaseOrder', $data);
    }
    public function transaction_details()
        {
           $id = $_POST['transaction_id'];
           $d = $this->pageModel->get_single_transport($id);
           $data = [ 'tname' => $d->name,
                     'lrnumber' => $d->lr_number,
                     'details' => $d->details,

                   ];
            $val = json_encode($data);
            echo $val;
        }
        public function delete_nonpurchase($id)
        {
            $n = $this->pageModel->get_single_non_purchasefor_del($id);
            $x = $this->pageModel->get_count_stock_all_temp_qr_id_based($n->non_purchase_id_temp);
            if(((int)$n->qty_receive)==((int)$x))
            {
                if($this->pageModel->del_stock_based_on_temp_qr($n->non_purchase_id_temp))
                {
                    $this->pageModel->del_nonpurchase($id); 
                    $_SESSION['success'] = "Non Purchase deleted successfully";
                    redirect('pages/all_non_purchase_order');
                }else
                {
                    $_SESSION['success'] = "Try Later";
                    redirect('pages/all_non_purchase_order');
                }

            }
            else
            {
                $_SESSION['success'] = "Some item Packed. Delete not possible";
                redirect('pages/all_non_purchase_order');    
            } 
        }
        public function delete_nonpurchase_for_box($id)
        {
            $n = $this->pageModel->get_single_non_purchasefor_del($id);
            $x = $this->pageModel->get_count_stock_all_temp_qr_id_based($n->non_purchase_id_temp);
            if(((int)$n->qty_receive)==((int)$x))
            { 
                $temp = 0;
                $check_soh = $this->pageModel->get_count_stock_all_temp_qr_id_based_stock_on_hand($n->non_purchase_id_temp);
                foreach ($check_soh as $k) {
                    $temp = $temp + $k->stock_on_hand;
                }
                if($temp==((int)$n->qty_receive))
                {
                    if($this->pageModel->del_stock_based_on_temp_qr($n->non_purchase_id_temp))
                    {
                        $this->pageModel->del_nonpurchase($id); 
                        $_SESSION['success'] = "Non Purchase deleted successfully";
                        redirect('pages/all_non_purchase_order');
                    }else
                    {
                        $_SESSION['success'] = "Try Later";
                        redirect('pages/all_non_purchase_order');
                    }
                }
                else
                {
                    $_SESSION['success'] = "Some Item is unboxed. Delete not possible";
                    redirect('pages/all_non_purchase_order');
                }
            }
            else
            {
                $_SESSION['success'] = "Some item Packed. Delete not possible";
                redirect('pages/all_non_purchase_order');    
            } 
        }
        public function update_purchase_order()
        {
            $item_id = $_POST['itemId'];
            $item = $_POST['product'];
            $receivable = $_POST['receivable'];
            $perUnitQty = $_POST['perUnit'];
            $actQty = $_POST['actQty'];
            $totalQty = $_POST['actQty'];
            $rowPrice = $_POST['price'];
            $rowTotal = $_POST['total'];
            if(empty($item_id))
            {}else
            {
                $this->pageModel->saveTheTempData($item_id,$item, $receivable, $perUnitQty, $actQty, $totalQty, $rowPrice, $rowTotal);
            }
            $tempId = md5(uniqid());
            $z = $this->pageModel->check_temp_data_count();
            if(empty($z))
            {
                 $_SESSION['success'] = 'Enter all fields'; 
                 redirect('pages/add_purchase_order');
            }
            else
            {
                $data = [ 
                            'vendor' => $_POST['vendor'],
                            'vendor_id' => $_POST['vendor_id'],
                            'bill_address' => $_POST['bill_address'],
                            'deliver_to' => $_POST['deliver_to'],
                            'purchase_order' => $_POST['purchase_order'],
                            'reference'=> $_POST['reference'],
                            'ndate' => $_POST['ndate'],
                            'expected_delivery_date' => $_POST['expected_delivery_date'],
                            'shipment_preference' => $_POST['shipment_preference'],
                            'payment_terms' => $_POST['payment_terms'],
                            'delivery_method' => $_POST['delivery_method'],
                            'salesperson' => $_POST['salesperson'],
                            
                            'itemId'=>implode("|||",$_POST['itemId']),
                            'product'=>implode("|||",$_POST['product']),
                            'receivable'=>implode("|||",$_POST['receivable']),
                            'perUnit'=>implode("|||",$_POST['perUnit']),
                            'actQty'=>implode("|||",$_POST['actQty']),
                            'price'=>implode("|||",$_POST['price']),
                            'total'=>implode("|||",$_POST['total']),
                            
                            'sub_total' => $_POST['sub_total'],
                            'tax' => $_POST['tax'],
                            'discount' => $_POST['discount'],
                            'discount_amount' => $_POST['discount_amount'],
                            'tax_amount' => $_POST['tax_amount'],
                            'total_amount' => $_POST['total_amount'],
                            'customer_notes' => $_POST['customer_notes'],
                            't_and_c' => $_POST['t_and_c'],
                            'tempId' => $tempId,
                        ];
                $tId = $this->pageModel->add_purchase_order_details($data);
                $this->pageModel->update_purchase_order_details($tId, $data);
                $_SESSION['success'] = 'Purchase Order Created Successfully'; 
                redirect('pages/purchase_order');
            }
        }
        public function update_purchase_order_old()
        {
            $id = $_POST['id'];
            $data = [ 
                        'vendor' => $_POST['vendor'],
                        'deliver_to' => $_POST['deliver_to'],
                        'purchase_order' => $_POST['purchase_order'],
                        'reference'=> $_POST['reference'],
                        'ndate' => $_POST['ndate'],
                        'expected_delivery_date' => $_POST['expected_delivery_date'],
                        'shipment_preference' => $_POST['shipment_preference'],
                        'payment_terms' => $_POST['payment_terms'],
                        'delivery_method' => $_POST['delivery_method'],
                        'salesperson' => $_POST['salesperson'],
                        'product' => implode("|", $_POST['product']),
                        'qty' => implode("|", $_POST['qty']),
                        'price' => implode("|", $_POST['price']),
                        'total' => implode("|", $_POST['total']),
                        'sub_total' => $_POST['sub_total'],
                        'tax' => $_POST['tax'],
                        'tax_amount' => $_POST['tax_amount'],
                        'total_amount' => $_POST['total_amount'],
                        'customer_notes' => $_POST['customer_notes'],
                        't_and_c' => $_POST['t_and_c']
                    ];
            $this->pageModel->update_purchase_order_details($data,$id);
            $_SESSION['success'] = 'Purchase Order updated Successfully'; 
            redirect('pages/purchase_order');
        }
    public function change_pass()
    {
        $this->view('pages/change_pass');
    }

    public function change_password()
    {
        if(isset($_POST['opass']))
        {
        $opass = $_POST['opass'];
        $r = $this->pageModel->check_pass($opass);
        if($r == true)
        {
            if(isset($_POST['npass']))
            {
                if(isset($_POST['cpass']))
                {
                  if($_POST['npass'] == $_POST['cpass'])
                  {
                        $this->pageModel->update_password($_POST['npass']);
                        $_SESSION['success'] = "Password Changed successfully..!";
                        redirect('pages/change_pass');
                  }
                  else
                  {
                        $_SESSION['success'] = "Conform Password not matching with New Password";
                        redirect('pages/change_pass');
                  }
                }
                else
                {
                        $_SESSION['success'] = "Enter Conform Password";
                        redirect('pages/change_pass');
                }
            }
            else
            {
                $_SESSION['success'] = "Enter New Password";
                redirect('pages/change_pass');
            }
        }
        else
        {
          $_SESSION['success'] = "current password not matching";
          redirect('pages/change_pass');
        }

        }
        else
        {
          $_SESSION['success'] = "Enter current Password";
          redirect('pages/change_pass');
        }
    }
    public function water_level()
    {
        $data = [
                    'all_salary' => $this->pageModel->getallsalary_report(),
                ];
        $this->view('pages/water_level',$data);
    }
    public function all_stock_water_level()
    {
        $lim = $_POST['lim'];
        $lim = (int)$lim;
        if ($lim == 9) {
            $off = $_POST['off'];
            $off = (int)$off;
            $allCategory = $this->pageModel->get_item_for_water_mark($lim, $off);
        } else {
            $inc = $_POST['inc'];
            $inc = (int)$inc;
            $lim = 9;
            $off = 9 + (9 * $inc);
            $allCategory = $this->pageModel->get_item_for_water_mark($lim, $off);
        }
        $output = "";
        $post = new Page();
        foreach ($allCategory as $k) {
            $a =0;
            $b = 0;
            $c = 0;
            $d = 0;
            $s_stock = $post->get_single_stock($k->id);
             foreach ($s_stock as $kw)
            {
                $a = $a + $kw->stock_total_receive;
                 if($kw->receivable == 1)
                    {
                        $b = $b + $kw->stock_total_receive;
                        $d = (int)$k->qty * (int)$b;
                    }
                    if($kw->receivable == 3)
                    {
                        $c = $c + $kw->stock_total_receive;
                    }
            }
            $type_id = $post->get_type_name_by_id($k->type_id);
            if(empty($type_id)){ $type_id = "--";}else{ $type_id = $type_id->type_name; }
            $model_id = $post->get_model_name_by_id($k->model_id);
            if(empty($model_id)){ $model_id = "--";}else{ $model_id = $model_id->model_name; }
            $category_new_id = $post->get_category_name_by_id($k->category_new_id);
             if(empty($category_new_id)){ $category_new_id = "--";}else{ $category_new_id = $category_new_id->category_name; }
            $subcategory_new_id = $post->get_subcategory_name_by_id($k->subcategory_new_id);
            if(empty($subcategory_new_id)){ $subcategory_new_id = "--";}else{ $subcategory_new_id = $subcategory_new_id->sc_name; }

            $dt = date("d-m-Y h:i:s a", strtotime($k->created_at));
        $output .= '<tr>
            <td scope="row">'.$k->id.'</td>
           
            <td>'.$k->name.'</td>
            <td>'.$type_id.'</td>
            <td>'.$model_id.'</td>
            <td>'.$category_new_id.'</td>
            <td>'.$subcategory_new_id.'</td>
            <td>'.$k->minstock.'</td>
            <td>'.($d+$c).'</td>
            <td>'.$k->maxstock.'</td>
            <td>
                <a href="'.URLROOT.'/pages/item_description/'.$k->id.'" class="btn btn-primary"><i class="ion ion-ios-browsers"></i></a>
            </td>
        </tr>';
        }
        echo $output;
    }
    public function allItemsById_water_level()
    {
        $itm = $_POST['itm'];
        $allCategory = $this->pageModel->get_all_items_id_water_level($itm);
        $output = "";
        $post = new Page();
        foreach ($allCategory as $k) {
            $a =0;
            $b = 0;
            $c = 0;
            $d = 0;
            $s_stock = $post->get_single_stock($k->id);
             foreach ($s_stock as $kw)
            {
                $a = $a + $kw->stock_total_receive;
                 if($kw->receivable == 1)
                    {
                        $b = $b + $kw->stock_total_receive;
                        $d = (int)$k->qty * (int)$b;
                    }
                    if($kw->receivable == 3)
                    {
                        $c = $c + $kw->stock_total_receive;
                    }
            }
            $type_id = $post->get_type_name_by_id($k->type_id);
            if(empty($type_id)){ $type_id = "--";}else{ $type_id = $type_id->type_name; }
            $model_id = $post->get_model_name_by_id($k->model_id);
            if(empty($model_id)){ $model_id = "--";}else{ $model_id = $model_id->model_name; }
            $category_new_id = $post->get_category_name_by_id($k->category_new_id);
             if(empty($category_new_id)){ $category_new_id = "--";}else{ $category_new_id = $category_new_id->category_name; }
            $subcategory_new_id = $post->get_subcategory_name_by_id($k->subcategory_new_id);
            if(empty($subcategory_new_id)){ $subcategory_new_id = "--";}else{ $subcategory_new_id = $subcategory_new_id->sc_name; }

            $dt = date("d-m-Y h:i:s a", strtotime($k->created_at));
        $output .= '<tr>
            <td scope="row">'.$k->id.'</td>
           
            <td>'.$k->name.'</td>
            <td>'.$type_id.'</td>
            <td>'.$model_id.'</td>
            <td>'.$category_new_id.'</td>
            <td>'.$subcategory_new_id.'</td>
            <td>'.$k->minstock.'</td>
            <td>'.($d+$c).'</td>
            <td>'.$k->maxstock.'</td>
            <td>
                <a href="'.URLROOT.'/pages/item_description/'.$k->id.'" class="btn btn-primary"><i class="ion ion-ios-browsers"></i></a>
            </td>
        </tr>';
        }
        echo $output;
    }
     public function allItemsByName_water_level()
        {
            $itm = $_POST['itmName'];
            $allCategory = $this->pageModel->get_all_items_namewater_level($itm);
             $output = "";
        $post = new Page();
        foreach ($allCategory as $k) {
            $a =0;
            $b = 0;
            $c = 0;
            $d = 0;
            $s_stock = $post->get_single_stock($k->id);
             foreach ($s_stock as $kw)
            {
                $a = $a + $kw->stock_total_receive;
                 if($kw->receivable == 1)
                    {
                        $b = $b + $kw->stock_total_receive;
                        $d = (int)$k->qty * (int)$b;
                    }
                    if($kw->receivable == 3)
                    {
                        $c = $c + $kw->stock_total_receive;
                    }
            }
            $type_id = $post->get_type_name_by_id($k->type_id);
            if(empty($type_id)){ $type_id = "--";}else{ $type_id = $type_id->type_name; }
            $model_id = $post->get_model_name_by_id($k->model_id);
            if(empty($model_id)){ $model_id = "--";}else{ $model_id = $model_id->model_name; }
            $category_new_id = $post->get_category_name_by_id($k->category_new_id);
             if(empty($category_new_id)){ $category_new_id = "--";}else{ $category_new_id = $category_new_id->category_name; }
            $subcategory_new_id = $post->get_subcategory_name_by_id($k->subcategory_new_id);
            if(empty($subcategory_new_id)){ $subcategory_new_id = "--";}else{ $subcategory_new_id = $subcategory_new_id->sc_name; }

            $dt = date("d-m-Y h:i:s a", strtotime($k->created_at));
        $output .= '<tr>
            <td scope="row">'.$k->id.'</td>
           
            <td>'.$k->name.'</td>
            <td>'.$type_id.'</td>
            <td>'.$model_id.'</td>
            <td>'.$category_new_id.'</td>
            <td>'.$subcategory_new_id.'</td>
            <td>'.$k->minstock.'</td>
            <td>'.($d+$c).'</td>
            <td>'.$k->maxstock.'</td>
            <td>
                <a href="'.URLROOT.'/pages/item_description/'.$k->id.'" class="btn btn-primary"><i class="ion ion-ios-browsers"></i></a>
            </td>
        </tr>';
        }
        echo $output;
        }
    public function stort_by_min_water_level()
    {
        $itm = $_POST['itmName'];
        $allCategory = $this->pageModel->get_all_items_for_waterlevel();
        $output = "";
        $post = new Page();
        foreach ($allCategory as $k) 
        {
            $a =0;
            $b = 0;
            $c = 0;
            $d = 0;
            $s_stock = $post->get_single_stock($k->id);
             foreach ($s_stock as $kw)
            {
                $a = $a + $kw->stock_total_receive;
                 if($kw->receivable == 1)
                    {
                        $b = $b + $kw->stock_total_receive;
                        $d = (int)$k->qty * (int)$b;
                    }
                    if($kw->receivable == 3)
                    {
                        $c = $c + $kw->stock_total_receive;
                    }
            }
            $type_id = $post->get_type_name_by_id($k->type_id);
            if(empty($type_id)){ $type_id = "--";}else{ $type_id = $type_id->type_name; }
            $model_id = $post->get_model_name_by_id($k->model_id);
            if(empty($model_id)){ $model_id = "--";}else{ $model_id = $model_id->model_name; }
            $category_new_id = $post->get_category_name_by_id($k->category_new_id);
             if(empty($category_new_id)){ $category_new_id = "--";}else{ $category_new_id = $category_new_id->category_name; }
            $subcategory_new_id = $post->get_subcategory_name_by_id($k->subcategory_new_id);
            if(empty($subcategory_new_id)){ $subcategory_new_id = "--";}else{ $subcategory_new_id = $subcategory_new_id->sc_name; }

            $dt = date("d-m-Y h:i:s a", strtotime($k->created_at));
            $d = $d+$c;
            if($d <= $k->minstock)
            {
            $output .= '<tr>
                <td scope="row">'.$k->id.'</td>
               
                <td>'.$k->name.'</td>
                <td>'.$type_id.'</td>
                <td>'.$model_id.'</td>
                <td>'.$category_new_id.'</td>
                <td>'.$subcategory_new_id.'</td>
                <td>'.$k->minstock.'</td>
                <td>'.$d.'</td>
                <td>'.$k->maxstock.'</td>
                <td>
                    <a href="'.URLROOT.'/pages/item_description/'.$k->id.'" class="btn btn-primary"><i class="ion ion-ios-browsers"></i></a>
                </td>
            </tr>';
            }

        }
        echo $output;
    }
    public function stort_by_max_water_level()
    {
        $itm = $_POST['itmName'];
        $allCategory = $this->pageModel->get_all_items_for_waterlevel();
        $output = "";
        $post = new Page();
        foreach ($allCategory as $k) 
        {
            $a =0;
            $b = 0;
            $c = 0;
            $d = 0;
            $s_stock = $post->get_single_stock($k->id);
             foreach ($s_stock as $kw)
            {
                $a = $a + $kw->stock_total_receive;
                 if($kw->receivable == 1)
                    {
                        $b = $b + $kw->stock_total_receive;
                        $d = (int)$k->qty * (int)$b;
                    }
                    if($kw->receivable == 3)
                    {
                        $c = $c + $kw->stock_total_receive;
                    }
            }
            $type_id = $post->get_type_name_by_id($k->type_id);
            if(empty($type_id)){ $type_id = "--";}else{ $type_id = $type_id->type_name; }
            $model_id = $post->get_model_name_by_id($k->model_id);
            if(empty($model_id)){ $model_id = "--";}else{ $model_id = $model_id->model_name; }
            $category_new_id = $post->get_category_name_by_id($k->category_new_id);
             if(empty($category_new_id)){ $category_new_id = "--";}else{ $category_new_id = $category_new_id->category_name; }
            $subcategory_new_id = $post->get_subcategory_name_by_id($k->subcategory_new_id);
            if(empty($subcategory_new_id)){ $subcategory_new_id = "--";}else{ $subcategory_new_id = $subcategory_new_id->sc_name; }

            $dt = date("d-m-Y h:i:s a", strtotime($k->created_at));
            $d = $d+$c;
            if($d > $k->maxstock)
            {
                $output .= '<tr>
                    <td scope="row">'.$k->id.'</td>
                   
                    <td>'.$k->name.'</td>
                    <td>'.$type_id.'</td>
                    <td>'.$model_id.'</td>
                    <td>'.$category_new_id.'</td>
                    <td>'.$subcategory_new_id.'</td>
                    <td>'.$k->minstock.'</td>
                    <td>'.$d.'</td>
                    <td>'.$k->maxstock.'</td>
                    <td>
                        <a href="'.URLROOT.'/pages/item_description/'.$k->id.'" class="btn btn-primary"><i class="ion ion-ios-browsers"></i></a>
                    </td>
                </tr>';
            }

        }
        echo $output;
    }
    public function swtiches_stock()
    {
        $get_all_models = $this->pageModel->get_all_models();
        $get_all_colors = $this->pageModel->get_all_colors();
        $get_total_sizes_count = $this->pageModel->get_total_sizes_count();
        $data = [
            'get_all_models'=> $get_all_models,
            'get_all_colors'=> $get_all_colors,
            'get_total_sizes_count' => $get_total_sizes_count,
            'model_details' => ''
        ];
        $this->view('pages/swtiches_stock', $data);
    }
    public function swtiches_stock_print()
    {
        $get_all_models = $this->pageModel->get_all_models();
        $get_all_colors = $this->pageModel->get_all_colors();
        $get_total_sizes_count = $this->pageModel->get_total_sizes_count();
        $data = [
            'get_all_models'=> $get_all_models,
            'get_all_colors'=> $get_all_colors,
            'get_total_sizes_count' => $get_total_sizes_count,
            'model_details' => ''
        ];
        $this->view('pages/swtiches_stock_print', $data);
    }

    public function get_sort_by_item_using_vendor_list()
    {
        $all_items = $this->pageModel->get_all_items_for_dropdown();
        $id = $_POST['vid'];
        $output ='';
        $key = $this->pageModel->get_vendor_bill_for_onclick($id);
        $output .= '<select class="select2-single form-control" name="" id="tags" onchange="getitem_name(this.value)"><option>--Select--</option>';
            if(empty($key->mfg_sort))
            {
                foreach ($all_items as $it) 
                {
                    $m = $this->pageModel->get_model_name_by_id($it->model_id);
                    if(empty($m->model_name)){ $m=""; }else{ $m=$m->model_name; }
                    $output .= '<option value="'.$it->id.'">'.$it->name.'</option>';   
                }
            }
            else
            {
                foreach ($all_items as $it) 
                {
                    $per = explode("|",$key->mfg_sort);
                    for ($i=0; $i <sizeof($per); $i++) 
                    {
                        if($per[$i]==$it->mfg_id)
                        {
                            $m = $this->pageModel->get_model_name_by_id($it->model_id);
                            if(empty($m->model_name)){ $m=""; }else{ $m=$m->model_name; }
                            $output .= '<option value="'.$it->id.'">'.$it->name.'</option>';
                        }
                    }
                }
            }
        $output .='</select>';
        $_SESSION['mfg_sort'] = $key->mfg_sort;
        echo $output;
    }
    public function change_db()
    {
        $this->view('pages/change_db');
    }
    public function update_change_DB()
    {
        if(isset($_POST['chickpet_db88']))
        {
            $_SESSION['db_name']=88;
            $_SESSION['db_code']='B';
            $_SESSION['success'] = "Database Changed";
            redirect('pages/change_db');        
        }
        elseif (isset($_POST['chamarajpet_db87'])) 
        {
            $_SESSION['db_name']=87;
            $_SESSION['db_code']='A';
            $_SESSION['success'] = "Database Changed";
            redirect('pages/change_db');        
        }
        elseif (isset($_POST['chickpet_db89'])) 
        {
            $_SESSION['db_name']=89;
            $_SESSION['db_code']='C';
            $_SESSION['success'] = "Database Changed";
            redirect('pages/change_db');        
        }
        elseif (isset($_POST['chickpet_db90'])) 
        {
            $_SESSION['db_name']=90;
            $_SESSION['db_code']='D';
            $_SESSION['success'] = "Database Changed";
            redirect('pages/change_db');        
        }
        elseif (isset($_POST['chickpet_db91'])) 
        {
            $_SESSION['db_name']=91;
            $_SESSION['db_code']='E';
            $_SESSION['success'] = "Database Changed";
            redirect('pages/change_db');        
        }
        elseif (isset($_POST['chamarajpet_db93'])) 
        {
            $_SESSION['db_name']=93;
            $_SESSION['db_code']='F';
            $_SESSION['success'] = "Database Changed";
            redirect('pages/change_db');        
        }
         elseif (isset($_POST['chamarajpet_db94'])) 
        {
            $_SESSION['db_name']=94;
            $_SESSION['db_code']='G';
            $_SESSION['success'] = "Database Changed";
            redirect('pages/change_db');        
        }
         elseif (isset($_POST['chamarajpet_db95'])) 
        {
            $_SESSION['db_name']=95;
            $_SESSION['db_code']='H';
            $_SESSION['success'] = "Database Changed";
            redirect('pages/change_db');        
        }
        else
        {
            $_SESSION['success'] = "Choose any one Database";
            redirect('pages/change_db');        
        }
    }       
//********************************salary/loan report part start**********************************
    public function salaryreport()
    {
        $data = [
                    'all_salary' => $this->pageModel->getallsalary_report(),
                ];
        $this->view('pages/salary_report',$data);
    }
    public function loan_report()
    {
        $data = [
                    'all_loan' => $this->pageModel->getallloan_report(),
                ];
        $this->view('pages/loan_report',$data);
    }
    public function all_permissions1()
    {
        $_SESSION['db_name'] = 87;
        redirect('pages/all_permissions');
    }
    public function all_permissions()
    {
        $_SESSION['db_name'] = 87;
        if($_SESSION['user_type'] == 0)
        {
            $data = [
                        'all_emp' => $this->pageModel->get_all_emp(),
                    ];
            $this->view('pages/all_permission',$data);
        }
        else
        {
            redirect('users/logout');
        }
    }
    public function give_permission($id)
    {
       $data = [
                    's_emp' => $this->pageModel->get_single_emp($id),
                    'p_all' => $this->pageModel->get_permission_all(),
                    'emp_per' => $this->pageModel->get_single_emp($id),
                ]; 
       $this->view('pages/add_or_edit_permission',$data);
    }
     public function update_permission($id)
    {
        if(isset($_POST['check23']) AND isset($_POST['check24']))
        {
            $_SESSION['success']="choose any one customer priority.";
            redirect('pages/all_permissions');   
        }elseif(isset($_POST['check87']) AND isset($_POST['check88']))
        {    
            $_SESSION['success']="choose any one Database.";
            redirect('pages/all_permissions');   
        }else
        {    
            $ps = array();
            $per = $this->pageModel->get_permission_all();
            foreach ($per as $k) 
            {
                if(isset($_POST['check'.$k->id.'']))
                {
                    $ps[] = $k->id;
                }
            }
            $ps = implode("|", $ps);
            $this->pageModel->update_permissiondb($ps,$id);
            $_SESSION['success']="Permissions created successfully";
            redirect('pages/all_permissions');
        }
    }
     public function attendence()
    {
         $data = [
                    's_emp' => $this->pageModel->get_single_emp_for_attendence(),
                ]; 
        $this->view('pages/attendence',$data);
    }
    public function punchIn()
    {
       $location = $_POST['city'];
        $this->pageModel->update_punch_in_details($location);
        $_SESSION['success'] = "Punch In successfully..!";
        redirect('pages/attendence');
    }
    public function punchOut()
    {
        $location = $_POST['city'];
        $this->pageModel->update_punch_out_details($location);
        $_SESSION['success'] = "Punch out successfully..!";
        redirect('pages/attendence');
    }
    public function emp_details()
    {
        $data = [
                    'all_emp' => $this->pageModel->get_all_emp(),
                ];
        $this->view('pages/emp_punchindetails',$data);
    }
//*******************************salary/loan report part end***********************************
//******************************vhr start*********************************************************

//******************************vhr end********************************************************
        public function new_direct_package()
        {
            if($this->pageModel->before_delete_temp2())
            {
                $this->pageModel->before_delete_temp3();    
            }
            $data = ['customer' => $this->pageModel->get_all_customers(), ];
            $this->view('pages/new_direct_package',$data);
        }
        public function scanQRfordirect_package()
        {
            $l = $_POST['barcode'];
            $temp =  substr($l,0,2);
            $output = '';
            if($temp == 'EG')
            {
                $temp1 =  substr($l,0,3);
                if($temp1 == 'EG'.$_SESSION["db_code"].'')
                {
                    $l = explode("EG".$_SESSION['db_code']."", $l);
                    $l = $l[1];
                }
                else
                {
                    $l = explode("EG", $l);
                    $l = $l[1];
                }
                $output='';
                $k = $this->pageModel->get_stock_from_id($l);
                if(!empty($k))
                {
                    if($k->stock_on_hand!=0)
                    {
                        $output = "";
                        $Page = new Page();
                        $item_name = $Page->getTheItemName($k->item_id);
                        if($k->receivable==0)
                        {
                            $receivable = "Carton";   
                        }
                        elseif($k->receivable==1)
                        {
                            $receivable = "Box";   
                        }
                        else
                        {
                            $receivable = "Pieces";
                        }
                        $count = $this->pageModel->get_temp_scan2_count_qty1($l);
                        if($count<1)
                        {
                           $co = $this->pageModel->get_item_count_for_dp($k->item_id,$receivable);
                           if($co>0)
                           {
                               $sqty = 1;
                               $co1 = $this->pageModel->get_item_for_dp3($k->item_id,$k->receivable);
                               foreach ($co1 as $k3) 
                               {
                                    $sqty = $sqty + $k3->qty;
                               }
                               $output .=$sqty;
                               if($this->pageModel->delete_item_for_dp3($k->item_id,$k->receivable))
                               {
                                   $this->pageModel->add_temp_direct_stock_out3($k->item_id,$item_name,$l,$k->receivable,$sqty); 
                               }
                               $this->pageModel->add_temp_direct_stock_out($k->item_id,$item_name,$l,$receivable);
                           }
                           else
                           {
                               
                                $this->pageModel->add_temp_direct_stock_out($k->item_id,$item_name,$l,$receivable);
                                $sqty=1;
                                $this->pageModel->add_temp_direct_stock_out3($k->item_id,$item_name,$l,$k->receivable,$sqty);
                           } 
                           
                           $output .= "Item Added";
                        }else
                        {
                            $output .="Item already added";
                        }
                    }
                    else
                    {
                        $output .="Item Unboxed/Not in stock";
                    }
                }
                else
                {
                    $output .= "Not in stock";
                }
                echo $output;
                
            }
            else
            {
                $output .= "Wrong QR";
                echo $output;
            }

        }
        public function getscaneditemsdirect_package()
        {
            $temp_scan = $this->pageModel->get_all_temp_scan_direct_package();
            $output = "";
            foreach ($temp_scan as $k) 
            {
                $output .= '<tr id="'.$k->id.'">
                <td scope="row">'.$k->item_id.'</td>
                <td>'.$k->stock_id.'</td>
                <td>'.$k->item_name.'</td>
                <td class="text-success">'.$k->qty.'</td>
                <td>'.$k->type.'</td>
                <td>'.$k->barcode.'</td>
                <td><button onclick="delete_tempscan2('.$k->id.')" class="btn btn-danger-rgba"><i class="dripicons-archive"></i></button>
                </td>
                </tr>';
            }
            echo $output;
        }
        public function getscaneditemsdirect_package_count()
        {
            $temp_scan = $this->pageModel->get_all_temp_scan_direct_package_count();
            $output = "";
            foreach ($temp_scan as $k) 
            {
                if($k->type==0)
                {
                    $rec = "Carton";
                }
                elseif($k->type==1)
                {
                    $rec = "Box";
                }else
                {
                    $rec = "Pieces";
                }
                $output .= '<tr id="c'.$k->id.'">
                <td scope="row">'.$k->item_id.'</td>
                <td>'.$k->item_name.'</td>
                <td class="text-success">'.$k->qty.'</td>
                <td>'.$rec.'</td>
                </tr>';
            }
            echo $output;
        }
        public function delete_temp_scan2()
        {
            // temp_scan3
            $id = $_POST['id'];
            $x = $this->pageModel->get_temp_scan2($id);
            if($x)
            {
                if($x1 = $this->pageModel->get_temp_scan3($x->item_id))
                {
                    $qty =0;
                    if($x1->qty==1)
                    {
                        echo "item less";
                        $this->pageModel->delete_temp_scan3_if_qty_zero($x1->id);
                        $this->pageModel->delete_tempscan2($id);
                    }
                    else
                    {
                        echo $x1->qty;
                        $qty = $x1->qty;
                        $qty = $qty - 1;
                        if($this->pageModel->before_delete_update_temp_scan3($x1->id,$qty))
                        {
                            $this->pageModel->delete_tempscan2($id);
                        }
                    }
                }
            }
            else
            {
                echo "cannot delete";
            }
            echo "item deleted";
        }
        public function create_direct_package()
        {
            $item_id = array();
            $item_name = array();
            $item_rec = array();
            $item_qty = array();
            $its = array();
            $temp_scan = $this->pageModel->get_all_temp_scan_direct_package3();
            if(empty($temp_scan))
            {
                $_SESSION['success'] = "Scan list empty";
                redirect('pages/new_direct_package');
            }
            elseif(empty($_POST['customer_id']))
            {
                $_SESSION['success'] = "Select Customer then Scan";
                redirect('pages/new_direct_package'); 
            }
            else
            {
                foreach ($temp_scan as $k) 
                {
                   $item_id[] = $k->item_id;
                   $item_name[] = $k->item_name;
                   $item_rec[] = $k->type;
                   $item_qty[] = $k->qty;
                }
                $item_id = implode("|||", $item_id); 
                $item_name = implode("|||", $item_name);
                $item_rec = implode("|||", $item_rec);
                $item_qty = implode("|||", $item_qty);
                $customer ='';
                $customer = $this->pageModel->get_cust_bill_for_onclick($_POST['customer_id']);
                $data = [ 
                            'customer' => $customer->customer_display_name,
                            'customer_id' => $_POST['customer_id'],
                            'item_id' => $item_id,
                            'item_name' => $item_name,
                            'item_rec' => $item_rec,
                            'item_qty' => $item_qty,                            
                        ];
                $packid = $this->pageModel->save_directpackage($data);
                if(!empty($packid))
                {
                    $ts = $this->pageModel->get_total_temp_scan_details2();
                    foreach ($ts as $t) 
                    {
                        $f = $this->pageModel->get_only_single_stock($t->stock_id);  
                        $this->pageModel->insert_new_stock_scan_items2($data,$packid,$f,$t->item_name,$t->barcode);
                    }

                    $_SESSION['success'] = "Direct Package created successfully";
                    redirect('pages/all_direct_package');
                }else
                {
                    $_SESSION['success'] = "Check network try later";
                    redirect('pages/all_direct_package');
                }
            }
        }
        public function all_direct_package()
        {
            $this->view('pages/all_direct_package');
        }
        public function getAlldirectpack_out()
        {
            $lim = $_POST['lim'];
            $lim = (int)$lim;
            if($lim==9)
            {
                $off = $_POST['off'];
                $off = (int)$off;
                $sales = $this->pageModel->get_all_direct_pack_details($lim, $off);
            }
            else
            {
                $inc = $_POST['inc'];
                $inc = (int)$inc;
                $lim = 9;
                $off = 9+(9*$inc);
                $sales = $this->pageModel->get_all_direct_pack_details($lim, $off);
            }
            $output = '';
            $pnote = 0;
            $pending = '';
            foreach ($sales as $key)
            {
                
                $cp_cust = $this->pageModel->get_all_customer_cp_priority($key->customer_id);
                if($_SESSION['ctype'] == 1)
                {
                    if($cp_cust->cp_priority==1)
                    {
                        $output .= "<tr>
                        <td>DP".$key->p_id."</td>
                        <td>".$key->customer."</td>
                        <td>".date('d-m-Y H:i:s A', strtotime($key->pack_date))."</td>
                        <td><a  href='".URLROOT."/pages/print_directpackage_details/".$key->p_id."'>Print</a></td>
                        
                        </tr>";
                    }   
                }
                elseif($_SESSION['ctype'] == 4)
                {
                    if($cp_cust->cp_priority==4)
                    {
                        $output .= "<tr>
                        <td>DP".$key->p_id."</td>
                        <td>".$key->customer."</td>
                        <td>".date('d-m-Y H:i:s A', strtotime($key->pack_date))."</td>
                        <td><a  href='".URLROOT."/pages/print_directpackage_details/".$key->p_id."'>Print</a></td>
                        
                        </tr>";
                    }   
                }
                elseif($_SESSION['ctype'] == 5)
                {
                    if($cp_cust->cp_priority==5)
                    {
                        $output .= "<tr>
                        <td>DP".$key->p_id."</td>
                        <td>".$key->customer."</td>
                        <td>".date('d-m-Y H:i:s A', strtotime($key->pack_date))."</td>
                        <td><a  href='".URLROOT."/pages/print_directpackage_details/".$key->p_id."'>Print</a></td>
                        
                        </tr>";
                    }   
                }
                elseif($_SESSION['ctype'] == 6)
                {
                    if($cp_cust->cp_priority==6)
                    {
                        $output .= "<tr>
                        <td>DP".$key->p_id."</td>
                        <td>".$key->customer."</td>
                        <td>".date('d-m-Y H:i:s A', strtotime($key->pack_date))."</td>
                        <td><a  href='".URLROOT."/pages/print_directpackage_details/".$key->p_id."'>Print</a></td>
                        
                        </tr>";
                    }   
                }
                elseif($_SESSION['ctype'] == 7)
                {
                    if($cp_cust->cp_priority==7)
                    {
                        $output .= "<tr>
                        <td>DP".$key->p_id."</td>
                        <td>".$key->customer."</td>
                        <td>".date('d-m-Y H:i:s A', strtotime($key->pack_date))."</td>
                        <td><a  href='".URLROOT."/pages/print_directpackage_details/".$key->p_id."'>Print</a></td>
                        
                        </tr>";
                    }   
                }
                elseif($_SESSION['ctype'] == 8)
                {
                    if($cp_cust->cp_priority==8)
                    {
                        $output .= "<tr>
                        <td>DP".$key->p_id."</td>
                        <td>".$key->customer."</td>
                        <td>".date('d-m-Y H:i:s A', strtotime($key->pack_date))."</td>
                        <td><a  href='".URLROOT."/pages/print_directpackage_details/".$key->p_id."'>Print</a></td>
                        
                        </tr>";
                    }   
                }
                elseif($_SESSION['ctype'] == 9)
                {
                    if($cp_cust->cp_priority==9)
                    {
                        $output .= "<tr>
                        <td>DP".$key->p_id."</td>
                        <td>".$key->customer."</td>
                        <td>".date('d-m-Y H:i:s A', strtotime($key->pack_date))."</td>
                        <td><a  href='".URLROOT."/pages/print_directpackage_details/".$key->p_id."'>Print</a></td>
                        
                        </tr>";
                    }   
                }
                else
                {
                    if($cp_cust->cp_priority==0)
                    {
                        $output .= "<tr>
                        <td>DP".$key->p_id."</td>
                        <td>".$key->customer."</td>
                        <td>".date('d-m-Y H:i:s A', strtotime($key->pack_date))."</td>

                        <td><a  href='".URLROOT."/pages/print_directpackage_details/".$key->p_id."'>Print</a></td>
                        
                        </tr>";
                    }
                }
            }
            echo $output;
        }
    public function print_directpackage_details($id)
    {
        $data=[ 
                 's_details'=>$this->pageModel->get_all_directpack_details($id),
                 'id' => $id
                ];

        $this->view('pages/print_direct_pack_details',$data);
    }
    public function new_stock_return()
        {
            $this->pageModel->before_delete_temp4();
            $data = ['customer' => $this->pageModel->get_all_customers(), ];
            $this->view('pages/new_stock_return',$data);
            
        }
    public function scanQRforsales_return()
    {
        $l = $_POST['barcode'];
        $temp =  substr($l,0,2);
        $output = '';
        if($temp == 'EG')
        {
            $temp1 =  substr($l,0,3);
            if($temp1 == 'EG'.$_SESSION["db_code"].'')
            {
                $l = explode("EG".$_SESSION['db_code']."", $l);
                $l = $l[1];
            }
            else
            {
                $l = explode("EG", $l);
                $l = $l[1];
            }
            $output='';
            $k = $this->pageModel->get_stock_outofsales_from_id($l);
            if(!empty($k))
            {
                if($k->stock_on_hand!=0)
                {
                    $output = "";
                    $Page = new Page();
                    $item_name = $Page->getTheItemName($k->item_id);
                    if($k->receivable==0)
                    {
                        $receivable = "Carton";   
                    }
                    elseif($k->receivable==1)
                    {
                        $receivable = "Box";   
                    }
                    else
                    {
                        $receivable = "Pieces";
                    }
                    $count = $this->pageModel->get_temp_scan4_count_qty4($l);
                    if($count<1)
                    {
                        $this->pageModel->add_temp_return_stock_out($k,$k->item_id,$item_name,$l,$receivable);
                       // $output .= "Item stock out";
                    }else
                    {
                        $output .="";
                    }
                }
                else
                {
                    $output .="Item Unboxed/Not in stockout";
                }   
            }
            else
            {
                $output .= "Not in stockout";
            }
            echo $output;
        }
        elseif($temp == 'DP')
        {
            $l = explode("DP", $l);
            $l = $l[1];
            $output='';
            $kj = $this->pageModel->get_stock_outofsales_from_id_for_all($l);
            if(!empty($kj))
            {
                foreach ($kj as $k) 
                {
                    $count = $this->pageModel->get_temp_scan4_count_qty4_for_DP($k->stock_id);
                    if($count<1)
                    {
                        $this->pageModel->add_temp_return_stock_out_DP($k);
                    }
                }
            }
            else
            {
                $output .= "Not in stockout";
            }
            echo $output;
        }
        elseif($temp == 'ST')
        {
            $l = explode("ST", $l);
            $l = $l[1];
            $l = explode("P", $l);
            $l = $l[0];
            $output='';
            $kj = $this->pageModel->get_stock_outofsales_from_id_for_all_st($l);
            if(!empty($kj))
            {
                foreach ($kj as $k) 
                {
                    $count = $this->pageModel->get_temp_scan4_count_qty4_for_DP($k->stock_id);
                    if($count<1)
                    {
                        $this->pageModel->add_temp_return_stock_out_DP($k);
                    }
                }
            }
            else
            {
                $output .= "Not in stockout";
            }
            echo $output;
        }
        else
        {
            $output .= "Wrong QR";
            echo $output;
        }

    }
    public function getscaneditemssales_return()
    {
        $temp_scan = $this->pageModel->get_all_temp_scan_sales_return();
        $output = "";
        $output .='<thead>
                        <tr>
                            <th>Customer Name</th>
                            <th>Customer ID</th>
                            <th>Sales/Direct Pack ID</th>
                            <th>Item ID</th>
                            <th>Stock ID</th>
                            <th>Item Name</th>
                            <th>Quantity</th>
                            <th>Type</th>
                            <th>QR Code</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>';
        foreach ($temp_scan as $k) 
        {
            $output .= '<tr>
            <td>'.$k->customer_name.'</td>
            <td>'.$k->customer_id.'</td>
            <td>'.$k->stock_out_id.'</td>
            <td>'.$k->item_id.'</td>
            <td>'.$k->stock_id.'</td>
            <td>'.$k->item_name.'</td>
            <td>'.$k->qty.'</td>
            <td>'.$k->type.'</td>
            <td>'.$k->barcode.'</td>
            <td><input type="checkbox" class="form-control" name="returnitems'.$k->stock_out_scan_items_id.'"></td>
            </tr>';
        }
        $output .="</tbody>";
        echo $output;
    }
    public function return_listed_tems()
    {
        $ps = array();
        $per = $this->pageModel->get_all_stock_out_scan_items_with_stid();
        foreach ($per as $k) 
        {
            if(isset($_POST['returnitems'.$k->id.'']))
            {
                $this->pageModel->stock_out_scan_items_with_stid($k->id);
            }
        }
        $_SESSION['success']="Selected Stock return successfully";
        redirect('pages/new_stock_return');
    }  
    public function categorylist()
        {
            $subC = $this->pageModel->getcategory_new_by_id_c($_POST['value1']);
            $output = "";
            $output .= "<option selected disabled >Select Category</option>";
            foreach ($subC as $key) {
                $output .= "<option value=" . $key->category_id . ">" . $key->category_name . "</option>";
            }
            echo $output;
        }    
    public function allnonpurchaseorders()
    {

        $lim = $_POST['lim'];
        $lim = (int)$lim;
        if ($lim == 9) {
            $off = $_POST['off'];
            $off = (int)$off;
            $allCategory = $this->pageModel->get_all_non_purchase_limit($lim, $off);
        } else {
            $inc = $_POST['inc'];
            $inc = (int)$inc;
            $lim = 9;
            $off = 9 + (9 * $inc);
            $allCategory = $this->pageModel->get_all_non_purchase_limit($lim, $off);
        }
        $output = "";

        $Page = new Page();
        foreach ($allCategory as $k) 
        {
           $output .='
                        <tr>
                        <td>'.$k->id.'</td>
                        <td>'.$k->vendor.'</td>
                        <td>'.$k->item_id.'</td>';
                        $mod = $Page->get_item_by_id($k->item_id);
                        if(empty($mod))
                        {
                        }else
                        {
                            $mod1 = $Page->get_model_name_by_id($mod->model_id); 
                            if(empty($mod1))
                            {

                            }
                            else
                            {
                            $output .= '<td>'.$mod1->model_name.'</td>';
                            }
                        }
                        $tt1 = $Page->getTheItemName($k->item_id);
                        $output .='<td>'.$tt1.'</td>';

                        if($k->receivable==0){ $tr =  "Carton"; }elseif($k->receivable==1){ $tr =  "Box"; }else{ $tr = "Pieces"; }
                        $output .='<td>'.$tr.'</td>';

                        $output .='<td>'.$k->qty_receive.'</td>
                        <td>'.$k->receive_date.'</td>
                        <td>'.$k->batch.'</td>
                        <td><a href="'.URLROOT.'/pages/non_purchase_order_details/'.$k->id.'" class="banner-info">View</a></td>
                        <td>';     
                        if(!empty($k->non_purchase_id_temp))
                        {

                            $output .=' <input type="text" id="item_id'.$k->id.'" name="item_id" value="'.$k->item_id.'" style="display: none;">
                                <input type="text" id="temp_qr_id'.$k->id.'" name="temp_qr_id" value="'.$k->non_purchase_id_temp.'" style="display: none;">
                                <button id="qrprint'.$k->id.'" type="submit" class="btn btn-info text-white mb-1" ><i class="fa fa-qrcode" aria-hidden="true"></i></button>
                                <button id="qrprint_sm'.$k->id.'" type="submit" class="btn btn-secondary text-white "><i class="fa fa-qrcode" aria-hidden="true"></i></button>';
                            $output .='<script>
                                     $("#qrprint'.$k->id.'").click(function(){
                                        var item_id = $("#item_id'.$k->id.'").val();
                                         var temp_qr_id = $("#temp_qr_id'.$k->id.'").val();
                                        $.ajax({
                                            url: "'.URLROOT.'/pages/print_item_qr1",
                                            type: "POST",
                                            data: {item_id,temp_qr_id},
                                            success: function(response)
                                            {
                                                window.open(response);
                                                
                                            }
                                        });
                                     });
                                     $("#qrprint_sm'.$k->id.'").click(function(){
                                        var item_id = $("#item_id'.$k->id.'").val();
                                         var temp_qr_id = $("#temp_qr_id'.$k->id.'").val();
                                        $.ajax({
                                            url: "'.URLROOT.'/pages/print_item_qr1_sm",
                                            type: "POST",
                                            data: {item_id,temp_qr_id},
                                            success: function(response)
                                            {
                                                window.open(response);
                                                
                                            }
                                        });
                                     });
                                </script>';
                        }
                        if(!empty($k->non_purchase_id_temp))
                        {  
                            if($k->receivable==0)
                            {
                                $s = $Page->get_stock_from_id_temp_data($k->non_purchase_id_temp);
                                $output .='<a href="#" class="badge badge-primary" data-toggle="modal" data-target="#exampleStandardModal'. $s->id.'">OPENCARTON</a>

                                <div class="modal fade bd-example-modal-lg" id="exampleStandardModal'.$s->id.'" tabindex="-1" role="dialog" aria-labelledby="exampleStandardModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleStandardModalLabel">Update Stock </h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <table>
                                                    <thead>
                                                        <tr>
                                                            <th style="width:150px;">QRCODE</th>
                                                            <th >Stock on hand</th>
                                                            <th style="width:150px;">Item Box QTY</th>
                                                            <th style="width:150px;">Item Piece QTY</th>
                                                            <th colspan="5">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>';
                                                        $alst = $Page->count_of_stock_get_stock_from_id_temp_data($k->non_purchase_id_temp);
                                                        foreach ($alst as $ke) 
                                                        { 
                                                            $all_it = $Page->get_single_item($ke->item_id);
                                                            if($ke->receivable==0)
                                                            {
                                                            if($ke->stock_on_hand>0)
                                                            {
                                                                $dt =0;
                                                                $dt = $ke->id."|EG".$_SESSION["db_code"].$ke->id."|".$ke->stock_on_hand."|".$all_it->qty."|".$all_it->carton_qty;
                                                                $output .='
                                                                <form>
                                                                        <tr>
                                                                            <td><input type="text" name="stock_id" class="form-control" value="EG'.$_SESSION["db_code"].$ke->id.'" readonly="true" autocomplete="off" /></td>

                                                                            <td><input type="text" name="stock_on_hand" class="form-control" value="'.$ke->stock_on_hand.'" readonly="true"></td>
                                                                            <td>
                                                                               <input type="text" class="form-control" value="'.$all_it->carton_qty.'" readonly="true"> 
                                                                            </td>
                                                                            <td>
                                                                            <input type="text" name="item_qty" class="form-control" value="'.$all_it->qty.'" readonly="true">
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" name="pieces" class="form-control" required="true" autocomplete="off" value="1" style="display: none;">
                                                                                
                                                                                <a href="'.URLROOT.'/pages/convert_carton_item/'.$dt.'" class="btn btn-primary" >OPENCARTON</a>
                                                                            </td>';
                                                                            $a = 0;
                                                                            $a = $all_it->qty * $ke->stock_on_hand;
                                                                        $output .= '<td><input type="text" name="item_id" value="'.$ke->item_id.'" style="display: none;">
                                                                            </td>
                                                                        </tr>
                                                                    </form>';
                                                            }
                                                            else
                                                            {
                                                                $output .='<tr>
                                                                        <td><input type="text" name="stock_id" class="form-control" value="EG'.$_SESSION["db_code"].$ke->id.'" readonly="true" autocomplete="off" />
                           
                                                                        </td>
                                                                        <td><input type="text" name="stock_on_hand" class="form-control" value="1" readonly="true"></td>
                                                                        <td></td>
                                                                        <td>
                                                                        <input type="text" name="item_qty" class="form-control" value="'.$all_it->qty.'" readonly="true">
                                                                        </td>
                                                                        <td>
                                                                            <input type="number" name="pieces" class="form-control" required="true" autocomplete="off" value="1" style="display: none;">

                                                                          <input type="text" id="boxstockid'.$ke->id.'" class="form-control" value="'.$ke->id.'" readonly="true" autocomplete="off" style="display: none;"/>    
                                                                        
                                                                        <button class="btn btn-primary" onclick="get_model_by_id_non('. $s->id.','. $ke->id.')">View Boxs</button>

                                                                        <a id="singleqrprint'.$ke->id.'" class="btn btn-info text-white"><i class="fa fa-qrcode" aria-hidden="true"></i></a>
                                                                        <script>
                                                                             $("#singleqrprint'.$ke->id.'").click(function(){
                                                                                var boxstockid = document.getElementById("boxstockid'.$ke->id.'").value;
                                                                                $.ajax({
                                                                                    url: "'.URLROOT.'/pages/print_item_qr_for_single_pieces",
                                                                                    type: "POST",
                                                                                    data: {boxstockid},
                                                                                    success: function(response)
                                                                                    {
                                                                                        window.open(response);
                                                                                    }
                                                                                });
                                                                             });
                                                                        </script>
                                                                        <a id="singleqrprint_sm'.$ke->id.'" class="btn btn-secondary text-white"><i class="fa fa-qrcode" aria-hidden="true"></i></a>
                                                                        <script>
                                                                             $("#singleqrprint_sm'.$ke->id.'").click(function(){
                                                                                var boxstockid = document.getElementById("boxstockid'.$ke->id.'").value;
                                                                                $.ajax({
                                                                                    url: "'.URLROOT.'/pages/print_item_qr_for_single_pieces_sm",
                                                                                    type: "POST",
                                                                                    data: {boxstockid},
                                                                                    success: function(response)
                                                                                    {
                                                                                         window.open(response);
                                                                                    }
                                                                                });
                                                                             });
                                                                        </script>
                                                                        </td>';

                                                                        $a = 0;
                                                                        $a = $all_it->qty * $ke->stock_on_hand;
                                                                    $output .='<td><input type="text" name="item_id" value="'. $ke->item_id.'" style="display: none;">
                                                                        </td>
                                                                    </tr>';
                                                                
                                                            } 
                                                        } 
                                                    }  
                                            $output .=' </tbody>
                                                </table>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="reset" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                               
                                            </div>
                                        
                                        </div>
                                    </div>
                                </div>';

                            }
                            if($k->receivable==1)
                            {
                                $s = $Page->get_stock_from_id_temp_data($k->non_purchase_id_temp);
                                $output .='<a href="#" class="badge badge-primary" data-toggle="modal" data-target="#exampleStandardModal'. $s->id.'">UNBOX</a>
                                <div class="modal fade" id="exampleStandardModal'.$s->id.'" tabindex="-1" role="dialog" aria-labelledby="exampleStandardModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleStandardModalLabel">Update Stock </h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <table>
                                                    <thead>
                                                        <tr>
                                                            <th>QRCODE</th>
                                                            <th>Stock on hand</th>
                                                            <th>Item Box QTY</th>
                                                            <th colspan="2">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>';
                                                        $alst = $Page->count_of_stock_get_stock_from_id_temp_data($k->non_purchase_id_temp);
                                                        foreach ($alst as $ke) 
                                                        { 
                                                            $all_it = $Page->get_single_item($ke->item_id);
                                                            if($ke->receivable==1)
                                                            {
                                                            if($ke->stock_on_hand>0)
                                                            {
                                                                $dt =0;
                                                                $dt = $ke->id."|EG".$_SESSION["db_code"].$ke->id."|".$ke->stock_on_hand."|".$all_it->qty;
                                                                $output .='
                                                                <form>
                                                                        <tr>
                                                                            <td><input type="text" name="stock_id" class="form-control" value="EG'.$_SESSION["db_code"].$ke->id.'" readonly="true" autocomplete="off" /></td>

                                                                            <td><input type="text" name="stock_on_hand" class="form-control" value="'.$ke->stock_on_hand.'" readonly="true"></td>
                                                                            <td>
                                                                            <input type="text" name="item_qty" class="form-control" value="'.$all_it->qty.'" readonly="true">
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" name="pieces" class="form-control" required="true" autocomplete="off" value="1" style="display: none;">
                                                                                <a href="'.URLROOT.'/pages/convert_box_item/'.$dt.'" class="btn btn-primary">Unbox</a>
                                                                            </td>';
                                                                            $a = 0;
                                                                            $a = $all_it->qty * $ke->stock_on_hand;
                                                                        $output .= '<td><input type="text" name="item_id" value="'.$ke->item_id.'" style="display: none;">
                                                                            </td>
                                                                        </tr>
                                                                    </form>';
                                                            }
                                                            else
                                                            {
                                                                $output .='<tr>
                                                                        <td><input type="text" name="stock_id" class="form-control" value="EG'.$_SESSION["db_code"].$ke->id.'" readonly="true" autocomplete="off" />
                           
                                                                        </td>
                                                                        <td><input type="text" name="stock_on_hand" class="form-control" value="1" readonly="true"></td>
                                                                        <td>
                                                                        <input type="text" name="item_qty" class="form-control" value="'.$all_it->qty.'" readonly="true">
                                                                        </td>
                                                                        <td>
                                                                            <input type="number" name="pieces" class="form-control" required="true" autocomplete="off" value="1" style="display: none;">

                                                                          <input type="text" id="boxstockid'.$ke->id.'" class="form-control" value="'.$ke->id.'" readonly="true" autocomplete="off" style="display: none;"/>                              
                                                                        <a id="singleqrprint'.$ke->id.'" class="btn btn-info text-white"><i class="fa fa-qrcode" aria-hidden="true"></i></a>
                                                                        <script>
                                                                             $("#singleqrprint'.$ke->id.'").click(function(){
                                                                                var boxstockid = document.getElementById("boxstockid'.$ke->id.'").value;
                                                                                $.ajax({
                                                                                    url: "'.URLROOT.'/pages/print_item_qr_for_single_pieces",
                                                                                    type: "POST",
                                                                                    data: {boxstockid},
                                                                                    success: function(response)
                                                                                    {
                                                                                         window.open(response);
                                                                                    }
                                                                                });
                                                                             });
                                                                        </script>
                                                                        <a id="singleqrprint_sm'.$ke->id.'" class="btn btn-secondary text-white"><i class="fa fa-qrcode" aria-hidden="true"></i></a>
                                                                        <script>
                                                                             $("#singleqrprint_sm'.$ke->id.'").click(function(){
                                                                                var boxstockid = document.getElementById("boxstockid'.$ke->id.'").value;
                                                                                $.ajax({
                                                                                    url: "'.URLROOT.'/pages/print_item_qr_for_single_pieces_sm",
                                                                                    type: "POST",
                                                                                    data: {boxstockid},
                                                                                    success: function(response)
                                                                                    {
                                                                                         window.open(response);
                                                                                    }
                                                                                });
                                                                             });
                                                                        </script>
                                                                        </td>';

                                                                        $a = 0;
                                                                        $a = $all_it->qty * $ke->stock_on_hand;
                                                                    $output .='<td><input type="text" name="item_id" value="'. $ke->item_id.'" style="display: none;">
                                                                        </td>
                                                                    </tr>';
                                                            } 
                                                        } 
                                                    }  
                                            $output .=' </tbody>
                                                </table>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="reset" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                               
                                            </div>
                                        
                                        </div>
                                    </div>
                                </div>';

                            } 
                        }
                $output .='<td>';
                            if($k->receivable==1)
                            {
                                $output .='<a href="'.URLROOT.'/pages/delete_nonpurchase_for_box/'.$k->id.'" class="btn btn-danger-rgba"><i class="dripicons-archive"></i></a>';
                            }
                            else
                            {
                                $output .='<a href="'.URLROOT.'/pages/delete_nonpurchase/'.$k->id.'" class="btn btn-danger-rgba"><i class="dripicons-archive"></i></a>';
                            }
                $output .='</td>
                    </td>
                    </tr>';
        }
        echo $output;
    }   
    public function get_sort_by_item_using_vendor_list1()
    {
        $type_id = $_POST['type_id'];
        $all_items = $this->pageModel->get_all_items_for_dropdown_by_type($type_id);
        $id = $_POST['vid'];
        $output ='';
        $key = $this->pageModel->get_vendor_bill_for_onclick($id);
        $output .= '<select class="select2-single form-control" name="" id="tags" onchange="getitem_name(this.value)"><option>--Select--</option>';
            if(empty($key->mfg_sort))
            {
                foreach ($all_items as $it) 
                {
                    $m = $this->pageModel->get_model_name_by_id($it->model_id);
                    if(empty($m->model_name)){ $m=""; }else{ $m=$m->model_name; }
                    $output .= '<option value="'.$it->id.'">'.$it->name.'</option>';   
                }
            }
            else
            {
                foreach ($all_items as $it) 
                {
                    $per = explode("|",$key->mfg_sort);
                    for ($i=0; $i <sizeof($per); $i++) 
                    {
                        if($per[$i]==$it->mfg_id)
                        {
                            $m = $this->pageModel->get_model_name_by_id($it->model_id);
                            if(empty($m->model_name)){ $m=""; }else{ $m=$m->model_name; }
                            $output .= '<option value="'.$it->id.'">'.$it->name.'</option>';
                        }
                    }
                }
            }
        $output .='</select>';
        $_SESSION['mfg_sort'] = $key->mfg_sort;
        echo $output;
    }
    public function get_sort_by_item_using_vendor_list2()
    {
        $type_id = $_POST['type_id'];
        $model_id = $_POST['model_id'];
        $all_items = $this->pageModel->get_all_items_for_dropdown_by_type_model($type_id,$model_id);
        $id = $_POST['vid'];
        $output ='';
        $key = $this->pageModel->get_vendor_bill_for_onclick($id);
        $output .= '<select class="select2-single form-control" name="" id="tags" onchange="getitem_name(this.value)"><option>--Select--</option>';
            if(empty($key->mfg_sort))
            {
                foreach ($all_items as $it) 
                {
                    $m = $this->pageModel->get_model_name_by_id($it->model_id);
                    if(empty($m->model_name)){ $m=""; }else{ $m=$m->model_name; }
                    $output .= '<option value="'.$it->id.'">'.$it->name.'</option>';   
                }
            }
            else
            {
                foreach ($all_items as $it) 
                {
                    $per = explode("|",$key->mfg_sort);
                    for ($i=0; $i <sizeof($per); $i++) 
                    {
                        if($per[$i]==$it->mfg_id)
                        {
                            $m = $this->pageModel->get_model_name_by_id($it->model_id);
                            if(empty($m->model_name)){ $m=""; }else{ $m=$m->model_name; }
                            $output .= '<option value="'.$it->id.'">'.$it->name.'</option>';
                        }
                    }
                }
            }
        $output .='</select>';
        $_SESSION['mfg_sort'] = $key->mfg_sort;
        echo $output;
    }   
    public function get_sort_by_item_using_vendor_list3()
    {
        $type_id = $_POST['type_id'];
        $model_id = $_POST['model_id'];
        $category_new1 = $_POST['category_new1'];
        $all_items = $this->pageModel->get_all_items_for_dropdown_by_type_model_category($type_id,$model_id,$category_new1);
        $id = $_POST['vid'];
        $output ='';
        $key = $this->pageModel->get_vendor_bill_for_onclick($id);
        $output .= '<select class="select2-single form-control" name="" id="tags" onchange="getitem_name(this.value)"><option>--Select--</option>';
            if(empty($key->mfg_sort))
            {
                foreach ($all_items as $it) 
                {
                    $m = $this->pageModel->get_model_name_by_id($it->model_id);
                    if(empty($m->model_name)){ $m=""; }else{ $m=$m->model_name; }
                    $output .= '<option value="'.$it->id.'">'.$it->name.'</option>';   
                }
            }
            else
            {
                foreach ($all_items as $it) 
                {
                    $per = explode("|",$key->mfg_sort);
                    for ($i=0; $i <sizeof($per); $i++) 
                    {
                        if($per[$i]==$it->mfg_id)
                        {
                            $m = $this->pageModel->get_model_name_by_id($it->model_id);
                            if(empty($m->model_name)){ $m=""; }else{ $m=$m->model_name; }
                            $output .= '<option value="'.$it->id.'">'.$it->name.'</option>';
                        }
                    }
                }
            }
        $output .='</select>';
        $_SESSION['mfg_sort'] = $key->mfg_sort;
        echo $output;
    }
    public function get_sort_by_item_using_vendor_list4_part_no()
    {
        $type_id = $_POST['type_id'];
        $model_id = $_POST['model_id'];
        $category_new1 = $_POST['category_new1'];
        $part_no = $_POST['part_no'];

        $all_items = $this->pageModel->get_all_items_for_dropdown_by_type_model_category_partnumber($type_id,$model_id,$category_new1,$part_no);
        $id = $_POST['vid'];
        $output ='';
        $key = $this->pageModel->get_vendor_bill_for_onclick($id);
        $output .= '<select class="select2-single form-control" name="" id="tags" onchange="getitem_name(this.value)"><option>--Select--</option>';
            if(empty($key->mfg_sort))
            {
                foreach ($all_items as $it) 
                {
                    $m = $this->pageModel->get_model_name_by_id($it->model_id);
                    if(empty($m->model_name)){ $m=""; }else{ $m=$m->model_name; }
                    $output .= '<option value="'.$it->id.'">'.$it->name.'</option>';   
                }
            }
            else
            {
                foreach ($all_items as $it) 
                {
                    $per = explode("|",$key->mfg_sort);
                    for ($i=0; $i <sizeof($per); $i++) 
                    {
                        if($per[$i]==$it->mfg_id)
                        {
                            $m = $this->pageModel->get_model_name_by_id($it->model_id);
                            if(empty($m->model_name)){ $m=""; }else{ $m=$m->model_name; }
                            $output .= '<option value="'.$it->id.'">'.$it->name.'</option>';
                        }
                    }
                }
                $_SESSION['mfg_sort'] = $key->mfg_sort;
            }
        $output .='</select>';
       
        echo $output;
    }  
    public function get_part_no_search_items()
    {
        $part_no = $_POST['part_no'];
        $all_items = $this->pageModel->get_all_partnumber($part_no);
        $id = $_POST['vid'];
        $output ='';
        $key = $this->pageModel->get_vendor_bill_for_onclick($id);
        $output .= '<select class="select2-single form-control" name="" id="tags" onchange="getitem_name(this.value)"><option>--Select--</option>';
            if(empty($key->mfg_sort))
            {
                foreach ($all_items as $it) 
                {
                    $m = $this->pageModel->get_model_name_by_id($it->model_id);
                    if(empty($m->model_name)){ $m=""; }else{ $m=$m->model_name; }
                    $output .= '<option value="'.$it->id.'">'.$it->name.'</option>';   
                }
            }
            else
            {
                foreach ($all_items as $it) 
                {
                    $per = explode("|",$key->mfg_sort);
                    for ($i=0; $i <sizeof($per); $i++) 
                    {
                        if($per[$i]==$it->mfg_id)
                        {
                            $m = $this->pageModel->get_model_name_by_id($it->model_id);
                            if(empty($m->model_name)){ $m=""; }else{ $m=$m->model_name; }
                            $output .= '<option value="'.$it->id.'">'.$it->name.'</option>';
                        }
                    }
                }
                $_SESSION['mfg_sort'] = $key->mfg_sort;
            }
        $output .='</select>';
       
        echo $output;
    }  
    public function custom_qr_print()
    {
      $this->view('pages/custom_qr_print');
    }  
    public function print_custom_qr()
    {
        $to = $_POST['qrto'];
        $from = $_POST['qrfrom'];
        $a_temp = array();
        $to = (int)trim($to);
        $from = (int)trim($from);
        $all_qr = $this->pageModel->get_stockdetails_for_custom_qr_print($to,$from);
        foreach ($all_qr as $w) 
        {
            $ids = 0;
            $itemid = $w->item_id;
            $typeq = $w->receivable;
            if($typeq==0)
            {
                $typeq = 'C';
            }
            elseif($typeq==1)
            {
                $typeq = 'B';
            }
            else
            {
                $typeq = 'P';
            }
            $it = $this->pageModel->get_single_item($itemid);
            $ids = $_SESSION['db_code'].$w->id;
            // $ids = implode('|', $ids);
            if(empty($it->color_id))
            {
                $color = "Nil";
            }
            else
            {
                $color = $this->pageModel->get_color($it->color_id);
                if(empty($color))
                {
                    $color = "Nil";
                }
                else
                {
                    $color = $color->color_name;  
                }
            }

            if(empty($it->size_id))
            {
                $size = 'Nil';
            }
            else
            {
                $size = $this->pageModel->get_size($it->size_id);
                if(empty($size))
                {
                    $size = 'Nil';
                }
                else
                {
                    $size = $size->size_name; 
                }
            }
            if(empty($it->dimension))
            {
                $dimension = 'Nil';
            }
            else
            {
                $length = explode("x", $it->dimension);
                $length = $length[0];
            }
            if($it->type_id == 4)
            {
                $a_temp[] = $ids."||".$color."||".$size."||".$length."||".$typeq;
            }
            else
            {
                if(empty($it->part_no))
                {
                    $length = "Nil";
                }else
                {
                    $length = $it->part_no;
                }

                if(empty($it->type_id))
                {
                    $color = "Nil";
                }else
                {

                    $tty = $this->pageModel->get_type_name_by_id($it->type_id);
                    if(empty($tty))
                    {
                        $color = "Nil";
                    }else
                    {
                        $color = $tty->type_name;
                    }
                }
                $a_temp[] = $ids."||".$color."||".$size."||".$length."||".$typeq;
            }
        }
        $a_temp = implode("|||", $a_temp);
        echo "https://medhike.com/rituhospital/b/barcode/index1.php?ids=".$a_temp."";
    }  
    public function print_custom_qr_sm()
    {
        $to = $_POST['qrto'];
        $from = $_POST['qrfrom'];
        $a_temp = array();
        $to = (int)trim($to);
        $from = (int)trim($from);
        $all_qr = $this->pageModel->get_stockdetails_for_custom_qr_print($to,$from);
        foreach ($all_qr as $w) 
        {
            $ids = 0;
            $itemid = $w->item_id;
            $typeq = $w->receivable;
            if($typeq==1)
            {
                $typeq = 'B';
            }
            else
            {
                $typeq = 'P';
            }
            $it = $this->pageModel->get_single_item($itemid);
            $ids = $_SESSION['db_code'].$w->id;
            // $ids = implode('|', $ids);
            if(empty($it->color_id))
            {
                $color = "Nil";
            }
            else
            {
                $color = $this->pageModel->get_color($it->color_id);
                if(empty($color))
                {
                    $color = "Nil";
                }
                else
                {
                    $color = $color->color_name;  
                }
            }

            if(empty($it->size_id))
            {
                $size = 'Nil';
            }
            else
            {
                $size = $this->pageModel->get_size($it->size_id);
                if(empty($size))
                {
                    $size = 'Nil';
                }
                else
                {
                    $size = $size->size_name; 
                }
            }
            if(empty($it->dimension))
            {
                $dimension = 'Nil';
            }
            else
            {
                $length = explode("x", $it->dimension);
                $length = $length[0];
            }
            if($it->type_id == 4)
            {
                $a_temp[] = $ids."||".$color."||".$size."||".$length."||".$typeq;
            }
            else
            {
                if(empty($it->model_id))
                {
                    $length = "Nil";
                }else
                {
                    $mm = $this->pageModel->get_model_by_id_single($it->model_id);
                    
                    if(empty($mm))
                    {
                        $length = "Nil";
                    }
                    else
                    {
                        $length = $mm->model_name;
                    }
                }
                if(empty($it->type_id))
                {
                    $color = "Nil";
                }else
                {

                    $tty = $this->pageModel->get_type_name_by_id($it->type_id);
                    if(empty($tty))
                    {
                        $color = "Nil";
                    }else
                    {
                        $color = $tty->type_name;
                    }
                }
                $a_temp[] = $ids."||".$color."||".$size."||".$length."||".$typeq;
            }
        }
        $a_temp = implode("|||", $a_temp);
        echo "https://medhike.com/rituhospital/b/barcode/index1sm.php?ids=".$a_temp."";
    }  
     public function by_allcategory_item_cat_with_qr()
        {
            $category_id = $_POST['category_id'];
            $subCategory = $_POST['subCategory'];
            $subCategory1 = $_POST['subCategory1'];
            $subCategory2 = $_POST['subCategory2'];
             if((!empty($category_id)) && (!empty($subCategory)) && (!empty($subCategory1)) && (!empty($subCategory2)))
             {
                $allComp = $this->pageModel->get_all_category_wise_details1s_qrcode($category_id,$subCategory,$subCategory1,$subCategory2);
            }
            elseif ((!empty($category_id)) && (!empty($subCategory)) && (!empty($subCategory1)) && (empty($subCategory2)))
            {
                $allComp = $this->pageModel->get_all_category_wise_details2s_qrcode($category_id,$subCategory,$subCategory1);
            }
            elseif ((!empty($category_id)) && (!empty($subCategory)) && (empty($subCategory1)) && (empty($subCategory2)))
            {
                $allComp = $this->pageModel->get_all_category_wise_details3s_qrcode($category_id,$subCategory);
            }
            elseif ((!empty($category_id)) && (empty($subCategory)) && (empty($subCategory1)) && (empty($subCategory2)))
            {
                $allComp = $this->pageModel->get_all_category_wise_details4s_qrcode($category_id);
            }
            else
            {
                $allComp = $this->pageModel->get_all_category_wise_details_qrcode();
            }
            $output = "";
            $post = new Page();
            foreach ($allComp as $e)
            {
                $sk = $this->pageModel->get_all_stock_by_id($e->id);
                $i = $this->pageModel->get_item_by_id($e->id);
                $type_id = $post->get_type_name_by_id($i->type_id);
                if(empty($type_id)){ $type_id = "--";}else{ $type_id = $type_id->type_name; }
                
                $model_id = $post->get_model_name_by_id($i->model_id);
                if(empty($model_id)){ $model_id = "--";}else{ $model_id = $model_id->model_name; }
                
                $category_new_id = $post->get_category_name_by_id($i->category_new_id);
                 if(empty($category_new_id)){ $category_new_id = "--";}else{ $category_new_id = $category_new_id->category_name; }
                
                $subcategory_new_id = $post->get_subcategory_name_by_id($i->subcategory_new_id);
                if(empty($subcategory_new_id)){ $subcategory_new_id = "--";}else{ $subcategory_new_id = $subcategory_new_id->sc_name; }
                foreach ($sk as $k)
                {

                    if($k->receivable==0){ $rec ="Carton"; }elseif($k->receivable==1){ $rec ="Box"; }else{ $rec ="Piece";}
                    $output .= '<tr>
                        <td>'.$k->id.'</td>
                        <td>'.$e->id.'</td>
                        <td>'.$i->name.'</td>
                        <td>'.$rec.'</td>
                        <td>'.$type_id.'</td>
                        <td>'.$model_id.'</td>
                        <td>'.$category_new_id.'</td>
                        <td>'.$subcategory_new_id.'</td>
                        <td>EG'.$_SESSION["db_code"].$k->id.'</td>
                    </tr>';
                }
            }
            echo $output;
        }  
        public function find_mfg_by_id()
        {
            $x = $this->pageModel->getmfgsingle($_POST['mfg_id']);
            echo trim($x->mfg_name);
        }
        public function getTheautosearchcategory()
        {
            $output = "";
            $type = $_POST['type'];
            $model = $_POST['model'];
            $category = $_POST['category'];

            $items = $this->pageModel->getAllautosearchcategory($type,$model,$category);
            foreach ($items as $key) {
                $val = json_encode($key->category_id);
                $output .= '<a class="dropdown-item hvr" style="border-bottom:1px lightgray solid">' . $key->category_name . '</a>';
            }
            echo $output;
        }  
        public function getTheautosearchmodel()
        {
            $output = "";
            $type = $_POST['type'];
            $model = $_POST['model'];
            $items = $this->pageModel->getAllautosearchmodel($type,$model);
            foreach ($items as $key) {
                $val = json_encode($key->model_id);
                $output .= '<a class="dropdown-item hvr" style="border-bottom:1px lightgray solid">' . $key->model_name . '</a>';
            }
            echo $output;
        }     
        public function getTheautosearchtype()
        {
            $output = "";
            $type = $_POST['type'];
            $items = $this->pageModel->getAllautosearchtype($type);
            foreach ($items as $key) {
                $val = json_encode($key->type_id);
                $output .= '<a class="dropdown-item hvr" style="border-bottom:1px lightgray solid">' . $key->type_name . '</a>';
            }
            echo $output;
        }
        public function getTheautosearchsubcategory()
        {
            $output = "";
            $type = $_POST['type'];
            $model = $_POST['model'];
            $category = $_POST['category'];
            $subcategory = $_POST['subcategory'];
            $items = $this->pageModel->getAllautosearchsubcategory($type,$model,$category,$subcategory);
            foreach ($items as $key) {
                $val = json_encode($key->sc_id);
                $output .= '<a class="dropdown-item hvr" style="border-bottom:1px lightgray solid">' . $key->sc_name . '</a>';
            }
            echo $output;
        }     
        public function all_stock_tbody()
        {
            $lim = $_POST['lim'];
            $lim = (int)$lim;
            if ($lim == 9) {
                $off = $_POST['off'];
                $off = (int)$off;
                $allCategory = $this->pageModel->get_all_stock_tbody_limit($lim, $off);
            } else {
                $inc = $_POST['inc'];
                $inc = (int)$inc;
                $lim = 9;
                $off = 9 + (9 * $inc);
                $allCategory = $this->pageModel->get_all_stock_tbody_limit($lim, $off);
            }
            $output = "";
            $Page = new Page();
            foreach ($allCategory as $s) 
            {
                $item_id = explode("|||", $s->item_id);
                $stock_on_hand = explode("|||", $s->stock_on_hand);
                $stock_total_receive = explode("|||", $s->stock_total_receive);
                $remaining_stock = explode("|||", $s->remaining_stock);
                $position = explode("|||", $s->position);
                for ($m = 0; $m < sizeof($item_id); $m++) 
                {
                    if($s->receivable == 0){ $rec =  "carton"; } elseif($s->receivable == 1){ $rec =  "Box"; }else{ $rec =  "Pieces"; } 
                    if($s->purchase_sales==0){ $pu_sal =  "Purchase Order";}else{ $pu_sal = "Sales Order";}
                    $it_name = $Page->getTheItemName($item_id[$m]);
                    if(empty($s->order_number)){ $or_nu =  "#"; }else{ $or_nu =  $s->order_number; }
                    if(empty($s->sales_order_no)){ $or_nu_sal =  "#";}else{ $or_nu_sal = $s->sales_order_no;}
                    if(empty($s->batch)){ $bt = "#";}else{ $bt = $s->batch;}
                    if(empty($s->name)){ $s_n =  "null";}else{ $s_n =  $s->name;}
                    if(empty($s->customer_name)){ $cn =  "null";}else{ $cn =  $s->customer_name;}
                    if(empty($s->distributor_name)){ $b_n =  "null";}else{ $b_n =  $s->distributor_name;}
                    if(empty($position[$m])){ $pos =  "null";}else{ $pos =  $position[$m];}
                    $d = date('Y-m-d H:i:s');
                    $date1 = strtotime($s->created_at);  
                    $date2 = strtotime(date($d));  
                    $diff = abs($date2 - $date1); 
                    $years = floor($diff / (365*60*60*24));  
                    $months = floor(($diff - $years * 365*60*60*24) 
                                                / (30*60*60*24));
                    $days = floor(($diff - $years * 365*60*60*24 -  
                    $months*30*60*60*24)/ (60*60*24));
                    $ag =  "Day:".$days."<br>Month:".$months."<br>Year:".$years;
                    $output .='
                        <tr>
                            <td>'.$s->id.'</td>
                            <td>'.$pu_sal.'</td>
                            <td>'.$item_id[$m].'</td>
                            <td>'.$it_name.'</td>
                            <td>'.$or_nu.'</td>
                            <td>'.$or_nu_sal.'</td>
                            <td>'.$bt.'</td>
                            <td>'.$s_n.'</td>
                            <td>'.$cn.'</td>
                            <td>'.$b_n.'</td>
                            <td>'.$stock_on_hand[$m].'</td>
                            <td>'.$stock_total_receive[$m].'</td>
                            <td>'.$remaining_stock[$m].'</td>
                            <td>'.$pos.'</td>
                            <td>'.$rec.'</td>
                            <td>'.$s->Expected_date.'</td>
                            <td>'.$s->created_at.'</td>
                            <td>'.$ag.'</td>
                        </tr>';
                }
            }
            echo $output;
        }
         public function getTheautosearchsize()
        {
            $output = "";
            $size = $_POST['size'];
            $items = $this->pageModel->getAllautosearchsize($size);
            foreach ($items as $key) {
                $val = json_encode($key->size_id);
                $output .= '<a class="dropdown-item hvr" style="border-bottom:1px lightgray solid">' . $key->size_name . '</a>';
            }
            echo $output;
        }
        public function getTheautosearchcolor()
        {
            $output = "";
            $color = $_POST['color'];
            $items = $this->pageModel->getAllautosearchcolor($color);
            foreach ($items as $key) {
                $val = json_encode($key->color_id);
                $output .= '<a class="dropdown-item hvr" style="border-bottom:1px lightgray solid">' . $key->color_name . '</a>';
            }
            echo $output;
        }
        public function getTheautosearchmfg()
        {
            $output = "";
            $color = $_POST['color'];
            $items = $this->pageModel->getAllautosearchmfg($color);
            foreach ($items as $key) {
                $val = json_encode($key->mfg_id);
                $output .= '<a class="dropdown-item hvr" style="border-bottom:1px lightgray solid">' . $key->mfg_name . '</a>';
            }
            echo $output;
        }
    public function getunbox_data_tomodal_non_purchase()
    {
        $id = $_POST['id'];
        $ks = $this->pageModel->get_stock_after_carton($id);

        $output ="";
        $output .= '
                    <table class="table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>QRCODE</th>
                                <th></th>
                                <th></th>
                                <th>Stock on hand</th>
                                <th></th>
                                <th>Item Box QTY</th>
                                <th></th>
                                <th colspan="2">Action</th>
                            </tr>
                        </thead>
                        <tbody style="position: absolute;overflow-y: auto;height: 380px!important">
                    ';
                        $alst = $this->pageModel->get_all_after_converted_box_id($ks->id,$ks->temp_qr_id);
                        foreach ($alst as $ke) 
                        { 
                            $all_it = $this->pageModel->get_single_item($ke->item_id);
                            if($ke->receivable==1)
                            {
                            if($ke->stock_on_hand>0)
                            {
                                $dt =0;
                                $dt = $ke->id."|EG".$_SESSION["db_code"].$ke->id."|".$ke->stock_on_hand."|".$all_it->qty;
                                $output .='
                                <form>
                                        <tr>
                                            <td><input type="text" name="stock_id" class="form-control" value="EG'.$_SESSION["db_code"].$ke->id.'" readonly="true" autocomplete="off" /></td>

                                            <td><input type="text" name="stock_on_hand" class="form-control" value="'.$ke->stock_on_hand.'" readonly="true"></td>
                                            <td>
                                            <input type="text" name="item_qty" class="form-control" value="'.$all_it->qty.'" readonly="true">
                                            </td>
                                            <td>
                                                <input type="number" name="pieces" class="form-control" required="true" autocomplete="off" value="1" style="display: none;">
                                                <a href="'.URLROOT.'/pages/convert_box_item/'.$dt.'" class="btn btn-primary">Unbox</a>
                                            </td>';
                                            $a = 0;
                                            $a = $all_it->qty * $ke->stock_on_hand;
                                        $output .= '<td><input type="text" name="item_id" value="'.$ke->item_id.'" style="display: none;">
                                            </td>
                                        </tr>
                                    </form>';
                            }
                            else
                            {
                                $output .='<tr>
                                        <td><input type="text" name="stock_id" class="form-control" value="EG'.$_SESSION["db_code"].$ke->id.'" readonly="true" autocomplete="off" />

                                        </td>
                                        <td><input type="text" name="stock_on_hand" class="form-control" value="1" readonly="true"></td>
                                        <td>
                                        <input type="text" name="item_qty" class="form-control" value="'.$all_it->qty.'" readonly="true">
                                        </td>
                                        <td>
                                            <input type="number" name="pieces" class="form-control" required="true" autocomplete="off" value="1" style="display: none;">

                                          <input type="text" id="boxstockid'.$ke->id.'" class="form-control" value="'.$ke->id.'" readonly="true" autocomplete="off" style="display: none;"/>                              
                                        <a id="singleqrprint'.$ke->id.'" class="btn btn-info text-white"><i class="fa fa-qrcode" aria-hidden="true"></i></a>
                                        <script>
                                             $("#singleqrprint'.$ke->id.'").click(function(){
                                                var boxstockid = document.getElementById("boxstockid'.$ke->id.'").value;
                                                $.ajax({
                                                    url: "'.URLROOT.'/pages/print_item_qr_for_single_pieces",
                                                    type: "POST",
                                                    data: {boxstockid},
                                                    success: function(response)
                                                    {
                                                         window.open(response);
                                                    }
                                                });
                                             });
                                        </script>
                                        <a id="singleqrprint_sm'.$ke->id.'" class="btn btn-secondary text-white"><i class="fa fa-qrcode" aria-hidden="true"></i></a>
                                        <script>
                                             $("#singleqrprint_sm'.$ke->id.'").click(function(){
                                                var boxstockid = document.getElementById("boxstockid'.$ke->id.'").value;
                                                $.ajax({
                                                    url: "'.URLROOT.'/pages/print_item_qr_for_single_pieces_sm",
                                                    type: "POST",
                                                    data: {boxstockid},
                                                    success: function(response)
                                                    {
                                                         window.open(response);
                                                    }
                                                });
                                             });
                                        </script>
                                        </td>';

                                        $a = 0;
                                        $a = $all_it->qty * $ke->stock_on_hand;
                                    $output .='<td><input type="text" name="item_id" value="'. $ke->item_id.'" style="display: none;">
                                        </td>
                                    </tr>';
                            } 
                        } 
                    }
        $output .="</tbody></table>";  
        echo $output;
    }

    public function date_wise_direct_package_report_data()
    {
        $sto = $_POST['to'];
        $sfrom = $_POST['from'];
        $x = $this->pageModel->getalldirect_packagedetails_with_date($sto,$sfrom);
        $output = "";
        foreach ($x as $key)
        {
            $cp_cust = $this->pageModel->get_all_customer_cp_priority($key->customer_id);
            if($_SESSION['ctype'] == 3)
            {
                $y=$key;
                $output .='<tr style="border:1px solid black"><td>'.$key->p_id.'</td>';
                $output .='<td style="border-left:1px solid black">'.date('d-m-Y h:m A',strtotime($key->pack_date)).'</td>';
                $item_id=explode('|||',$y->item_id);
                $output .='<td style="border-left:1px solid black">'.$key->customer.'</td><td style="border-left:1px solid black">';
                for($i=0;$i<sizeof($item_id);$i++)
                {
                    $output .=''.$item_id[$i].'<br>';
                }
                $output .='</td><td style="border-left:1px solid black">';
                for($i=0;$i<sizeof($item_id);$i++)
                {
                    $ty = $this->pageModel->get_single_item($item_id[$i]);
                    if($ty)
                    {
                        $ty1 = $this->pageModel->get_type_name_by_id($ty->type_id);
                        $output .=''.$ty1->type_name.'<br>';
                    }
                    
                }
                $output .='</td><td style="border-left:1px solid black">';
                for($i=0; $i<sizeof($item_id); $i++)
                {
                    $ty = $this->pageModel->get_single_item($item_id[$i]);
                    if($ty)
                    {
                        $ty1 = $this->pageModel->get_model_by_id_single($ty->model_id);
                        $output .=''.$ty1->model_name.'<br>';
                    }
                    
                }
                $output.='</td><td style="border-left:1px solid black">';

                $item_name=explode('|||',$y->item_name);
                for($j=0;$j<sizeof($item_name);$j++)
                {
                    $output .=''.$item_name[$j].'<br>';
                }
                $output.='</td><td style="border-left:1px solid black">';
                     $item_qty=explode('|||',$y->item_qty);
                for($k=0;$k<sizeof($item_qty);$k++)
                {
                    $output .=''.$item_qty[$k].'<br>';
                }
                  $output.='</td><td style="border-left:1px solid black">';
                         $item_rec=explode('|||',$y->item_rec);
                for($p=0;$p<sizeof($item_rec);$p++)
                {
                    if($item_rec[$p]==0)
                    {
                        $item_rec[$p] = "Carton";   
                    }
                    elseif($item_rec[$p]==1)
                    {
                        $item_rec[$p] = "Box";   
                    }
                    else
                    {
                        $item_rec[$p] = "Pieces";   
                    }
                    $output .=''.$item_rec[$p].'<br>';
                }       
                $output.='</td></tr>';
                
            }elseif($_SESSION['ctype'] == 1)
            {
                if($cp_cust->cp_priority==1)
                {

                    $y=$key;
                    $output .='<tr style="border:1px solid black"><td>'.$key->p_id.'</td>';
                    $output .='<td style="border-left:1px solid black">'.date('d-m-Y h:m A',strtotime($key->pack_date)).'</td>';
                    $item_id=explode('|||',$y->item_id);
                    $output .='<td style="border-left:1px solid black">'.$key->customer.'</td><td style="border-left:1px solid black">';
                    for($i=0;$i<sizeof($item_id);$i++)
                    {
                        $output .=''.$item_id[$i].'<br>';
                    }
                    $output .='</td><td style="border-left:1px solid black">';
                    for($i=0;$i<sizeof($item_id);$i++)
                    {
                        $ty = $this->pageModel->get_single_item($item_id[$i]);
                        if($ty)
                        {
                            $ty1 = $this->pageModel->get_type_name_by_id($ty->type_id);
                            $output .=''.$ty1->type_name.'<br>';
                        }
                        
                    }
                    $output .='</td><td style="border-left:1px solid black">';
                    for($i=0; $i<sizeof($item_id); $i++)
                    {
                        $ty = $this->pageModel->get_single_item($item_id[$i]);
                        if($ty)
                        {
                            $ty1 = $this->pageModel->get_model_by_id_single($ty->model_id);
                            $output .=''.$ty1->model_name.'<br>';
                        }
                        
                    }
                    $output.='</td><td style="border-left:1px solid black">';

                    $item_name=explode('|||',$y->item_name);
                    for($j=0;$j<sizeof($item_name);$j++)
                    {
                        $output .=''.$item_name[$j].'<br>';
                    }
                    $output.='</td><td style="border-left:1px solid black">';
                         $item_qty=explode('|||',$y->item_qty);
                    for($k=0;$k<sizeof($item_qty);$k++)
                    {
                        $output .=''.$item_qty[$k].'<br>';
                    }
                      $output.='</td><td style="border-left:1px solid black">';
                             $item_rec=explode('|||',$y->item_rec);
                    for($p=0;$p<sizeof($item_rec);$p++)
                    {
                        if($item_rec[$p]==0)
                        {
                            $item_rec[$p] = "Carton";   
                        }
                        elseif($item_rec[$p]==1)
                        {
                            $item_rec[$p] = "Box";   
                        }
                        else
                        {
                            $item_rec[$p] = "Pieces";   
                        }
                        $output .=''.$item_rec[$p].'<br>';
                    }       
                    $output.='</td></tr>';
                }
            }
            elseif($_SESSION['ctype'] == 4)
            {
                if($cp_cust->cp_priority==4)
                {

                    $y=$key;
                    $output .='<tr style="border:1px solid black"><td>'.$key->p_id.'</td>';
                    $output .='<td style="border-left:1px solid black">'.date('d-m-Y h:m A',strtotime($key->pack_date)).'</td>';
                    $item_id=explode('|||',$y->item_id);
                    $output .='<td style="border-left:1px solid black">'.$key->customer.'</td><td style="border-left:1px solid black">';
                    for($i=0;$i<sizeof($item_id);$i++)
                    {
                        $output .=''.$item_id[$i].'<br>';
                    }
                    $output .='</td><td style="border-left:1px solid black">';
                    for($i=0;$i<sizeof($item_id);$i++)
                    {
                        $ty = $this->pageModel->get_single_item($item_id[$i]);
                        if($ty)
                        {
                            $ty1 = $this->pageModel->get_type_name_by_id($ty->type_id);
                            $output .=''.$ty1->type_name.'<br>';
                        }
                        
                    }
                    $output .='</td><td style="border-left:1px solid black">';
                    for($i=0; $i<sizeof($item_id); $i++)
                    {
                        $ty = $this->pageModel->get_single_item($item_id[$i]);
                        if($ty)
                        {
                            $ty1 = $this->pageModel->get_model_by_id_single($ty->model_id);
                            $output .=''.$ty1->model_name.'<br>';
                        }
                        
                    }
                    $output.='</td><td style="border-left:1px solid black">';

                    $item_name=explode('|||',$y->item_name);
                    for($j=0;$j<sizeof($item_name);$j++)
                    {
                        $output .=''.$item_name[$j].'<br>';
                    }
                    $output.='</td><td style="border-left:1px solid black">';
                         $item_qty=explode('|||',$y->item_qty);
                    for($k=0;$k<sizeof($item_qty);$k++)
                    {
                        $output .=''.$item_qty[$k].'<br>';
                    }
                      $output.='</td><td style="border-left:1px solid black">';
                             $item_rec=explode('|||',$y->item_rec);
                    for($p=0;$p<sizeof($item_rec);$p++)
                    {
                        if($item_rec[$p]==0)
                        {
                            $item_rec[$p] = "Carton";   
                        }
                        elseif($item_rec[$p]==1)
                        {
                            $item_rec[$p] = "Box";   
                        }
                        else
                        {
                            $item_rec[$p] = "Pieces";   
                        }
                        $output .=''.$item_rec[$p].'<br>';
                    }       
                    $output.='</td></tr>';
                }
            }
            elseif($_SESSION['ctype'] == 5)
            {
                if($cp_cust->cp_priority==5)
                {

                    $y=$key;
                    $output .='<tr style="border:1px solid black"><td>'.$key->p_id.'</td>';
                    $output .='<td style="border-left:1px solid black">'.date('d-m-Y h:m A',strtotime($key->pack_date)).'</td>';
                    $item_id=explode('|||',$y->item_id);
                    $output .='<td style="border-left:1px solid black">'.$key->customer.'</td><td style="border-left:1px solid black">';
                    for($i=0;$i<sizeof($item_id);$i++)
                    {
                        $output .=''.$item_id[$i].'<br>';
                    }
                    $output .='</td><td style="border-left:1px solid black">';
                    for($i=0;$i<sizeof($item_id);$i++)
                    {
                        $ty = $this->pageModel->get_single_item($item_id[$i]);
                        if($ty)
                        {
                            $ty1 = $this->pageModel->get_type_name_by_id($ty->type_id);
                            $output .=''.$ty1->type_name.'<br>';
                        }
                        
                    }
                    $output .='</td><td style="border-left:1px solid black">';
                    for($i=0; $i<sizeof($item_id); $i++)
                    {
                        $ty = $this->pageModel->get_single_item($item_id[$i]);
                        if($ty)
                        {
                            $ty1 = $this->pageModel->get_model_by_id_single($ty->model_id);
                            $output .=''.$ty1->model_name.'<br>';
                        }
                        
                    }
                    $output.='</td><td style="border-left:1px solid black">';

                    $item_name=explode('|||',$y->item_name);
                    for($j=0;$j<sizeof($item_name);$j++)
                    {
                        $output .=''.$item_name[$j].'<br>';
                    }
                    $output.='</td><td style="border-left:1px solid black">';
                         $item_qty=explode('|||',$y->item_qty);
                    for($k=0;$k<sizeof($item_qty);$k++)
                    {
                        $output .=''.$item_qty[$k].'<br>';
                    }
                      $output.='</td><td style="border-left:1px solid black">';
                             $item_rec=explode('|||',$y->item_rec);
                    for($p=0;$p<sizeof($item_rec);$p++)
                    {
                        if($item_rec[$p]==0)
                        {
                            $item_rec[$p] = "Carton";   
                        }
                        elseif($item_rec[$p]==1)
                        {
                            $item_rec[$p] = "Box";   
                        }
                        else
                        {
                            $item_rec[$p] = "Pieces";   
                        }
                        $output .=''.$item_rec[$p].'<br>';
                    }       
                    $output.='</td></tr>';
                }
            }
            elseif($_SESSION['ctype'] == 6)
            {
                if($cp_cust->cp_priority==6)
                {

                    $y=$key;
                    $output .='<tr style="border:1px solid black"><td>'.$key->p_id.'</td>';
                    $output .='<td style="border-left:1px solid black">'.date('d-m-Y h:m A',strtotime($key->pack_date)).'</td>';
                    $item_id=explode('|||',$y->item_id);
                    $output .='<td style="border-left:1px solid black">'.$key->customer.'</td><td style="border-left:1px solid black">';
                    for($i=0;$i<sizeof($item_id);$i++)
                    {
                        $output .=''.$item_id[$i].'<br>';
                    }
                    $output .='</td><td style="border-left:1px solid black">';
                    for($i=0;$i<sizeof($item_id);$i++)
                    {
                        $ty = $this->pageModel->get_single_item($item_id[$i]);
                        if($ty)
                        {
                            $ty1 = $this->pageModel->get_type_name_by_id($ty->type_id);
                            $output .=''.$ty1->type_name.'<br>';
                        }
                        
                    }
                    $output .='</td><td style="border-left:1px solid black">';
                    for($i=0; $i<sizeof($item_id); $i++)
                    {
                        $ty = $this->pageModel->get_single_item($item_id[$i]);
                        if($ty)
                        {
                            $ty1 = $this->pageModel->get_model_by_id_single($ty->model_id);
                            $output .=''.$ty1->model_name.'<br>';
                        }
                        
                    }
                    $output.='</td><td style="border-left:1px solid black">';

                    $item_name=explode('|||',$y->item_name);
                    for($j=0;$j<sizeof($item_name);$j++)
                    {
                        $output .=''.$item_name[$j].'<br>';
                    }
                    $output.='</td><td style="border-left:1px solid black">';
                         $item_qty=explode('|||',$y->item_qty);
                    for($k=0;$k<sizeof($item_qty);$k++)
                    {
                        $output .=''.$item_qty[$k].'<br>';
                    }
                      $output.='</td><td style="border-left:1px solid black">';
                             $item_rec=explode('|||',$y->item_rec);
                    for($p=0;$p<sizeof($item_rec);$p++)
                    {
                        if($item_rec[$p]==0)
                        {
                            $item_rec[$p] = "Carton";   
                        }
                        elseif($item_rec[$p]==1)
                        {
                            $item_rec[$p] = "Box";   
                        }
                        else
                        {
                            $item_rec[$p] = "Pieces";   
                        }
                        $output .=''.$item_rec[$p].'<br>';
                    }       
                    $output.='</td></tr>';
                }
            }
            elseif($_SESSION['ctype'] == 7)
            {
                if($cp_cust->cp_priority==7)
                {

                    $y=$key;
                    $output .='<tr style="border:1px solid black"><td>'.$key->p_id.'</td>';
                    $output .='<td style="border-left:1px solid black">'.date('d-m-Y h:m A',strtotime($key->pack_date)).'</td>';
                    $item_id=explode('|||',$y->item_id);
                    $output .='<td style="border-left:1px solid black">'.$key->customer.'</td><td style="border-left:1px solid black">';
                    for($i=0;$i<sizeof($item_id);$i++)
                    {
                        $output .=''.$item_id[$i].'<br>';
                    }
                    $output .='</td><td style="border-left:1px solid black">';
                    for($i=0;$i<sizeof($item_id);$i++)
                    {
                        $ty = $this->pageModel->get_single_item($item_id[$i]);
                        if($ty)
                        {
                            $ty1 = $this->pageModel->get_type_name_by_id($ty->type_id);
                            $output .=''.$ty1->type_name.'<br>';
                        }
                        
                    }
                    $output .='</td><td style="border-left:1px solid black">';
                    for($i=0; $i<sizeof($item_id); $i++)
                    {
                        $ty = $this->pageModel->get_single_item($item_id[$i]);
                        if($ty)
                        {
                            $ty1 = $this->pageModel->get_model_by_id_single($ty->model_id);
                            $output .=''.$ty1->model_name.'<br>';
                        }
                        
                    }
                    $output.='</td><td style="border-left:1px solid black">';

                    $item_name=explode('|||',$y->item_name);
                    for($j=0;$j<sizeof($item_name);$j++)
                    {
                        $output .=''.$item_name[$j].'<br>';
                    }
                    $output.='</td><td style="border-left:1px solid black">';
                         $item_qty=explode('|||',$y->item_qty);
                    for($k=0;$k<sizeof($item_qty);$k++)
                    {
                        $output .=''.$item_qty[$k].'<br>';
                    }
                      $output.='</td><td style="border-left:1px solid black">';
                             $item_rec=explode('|||',$y->item_rec);
                    for($p=0;$p<sizeof($item_rec);$p++)
                    {
                        if($item_rec[$p]==0)
                        {
                            $item_rec[$p] = "Carton";   
                        }
                        elseif($item_rec[$p]==1)
                        {
                            $item_rec[$p] = "Box";   
                        }
                        else
                        {
                            $item_rec[$p] = "Pieces";   
                        }
                        $output .=''.$item_rec[$p].'<br>';
                    }       
                    $output.='</td></tr>';
                }
            }
            elseif($_SESSION['ctype'] == 8)
            {
                if($cp_cust->cp_priority==8)
                {

                    $y=$key;
                    $output .='<tr style="border:1px solid black"><td>'.$key->p_id.'</td>';
                    $output .='<td style="border-left:1px solid black">'.date('d-m-Y h:m A',strtotime($key->pack_date)).'</td>';
                    $item_id=explode('|||',$y->item_id);
                    $output .='<td style="border-left:1px solid black">'.$key->customer.'</td><td style="border-left:1px solid black">';
                    for($i=0;$i<sizeof($item_id);$i++)
                    {
                        $output .=''.$item_id[$i].'<br>';
                    }
                    $output .='</td><td style="border-left:1px solid black">';
                    for($i=0;$i<sizeof($item_id);$i++)
                    {
                        $ty = $this->pageModel->get_single_item($item_id[$i]);
                        if($ty)
                        {
                            $ty1 = $this->pageModel->get_type_name_by_id($ty->type_id);
                            $output .=''.$ty1->type_name.'<br>';
                        }
                        
                    }
                    $output .='</td><td style="border-left:1px solid black">';
                    for($i=0; $i<sizeof($item_id); $i++)
                    {
                        $ty = $this->pageModel->get_single_item($item_id[$i]);
                        if($ty)
                        {
                            $ty1 = $this->pageModel->get_model_by_id_single($ty->model_id);
                            $output .=''.$ty1->model_name.'<br>';
                        }
                        
                    }
                    $output.='</td><td style="border-left:1px solid black">';

                    $item_name=explode('|||',$y->item_name);
                    for($j=0;$j<sizeof($item_name);$j++)
                    {
                        $output .=''.$item_name[$j].'<br>';
                    }
                    $output.='</td><td style="border-left:1px solid black">';
                         $item_qty=explode('|||',$y->item_qty);
                    for($k=0;$k<sizeof($item_qty);$k++)
                    {
                        $output .=''.$item_qty[$k].'<br>';
                    }
                      $output.='</td><td style="border-left:1px solid black">';
                             $item_rec=explode('|||',$y->item_rec);
                    for($p=0;$p<sizeof($item_rec);$p++)
                    {
                        if($item_rec[$p]==0)
                        {
                            $item_rec[$p] = "Carton";   
                        }
                        elseif($item_rec[$p]==1)
                        {
                            $item_rec[$p] = "Box";   
                        }
                        else
                        {
                            $item_rec[$p] = "Pieces";   
                        }
                        $output .=''.$item_rec[$p].'<br>';
                    }       
                    $output.='</td></tr>';
                }
            }
            elseif($_SESSION['ctype'] == 9)
            {
                if($cp_cust->cp_priority==9)
                {

                    $y=$key;
                    $output .='<tr style="border:1px solid black"><td>'.$key->p_id.'</td>';
                    $output .='<td style="border-left:1px solid black">'.date('d-m-Y h:m A',strtotime($key->pack_date)).'</td>';
                    $item_id=explode('|||',$y->item_id);
                    $output .='<td style="border-left:1px solid black">'.$key->customer.'</td><td style="border-left:1px solid black">';
                    for($i=0;$i<sizeof($item_id);$i++)
                    {
                        $output .=''.$item_id[$i].'<br>';
                    }
                    $output .='</td><td style="border-left:1px solid black">';
                    for($i=0;$i<sizeof($item_id);$i++)
                    {
                        $ty = $this->pageModel->get_single_item($item_id[$i]);
                        if($ty)
                        {
                            $ty1 = $this->pageModel->get_type_name_by_id($ty->type_id);
                            $output .=''.$ty1->type_name.'<br>';
                        }
                        
                    }
                    $output .='</td><td style="border-left:1px solid black">';
                    for($i=0; $i<sizeof($item_id); $i++)
                    {
                        $ty = $this->pageModel->get_single_item($item_id[$i]);
                        if($ty)
                        {
                            $ty1 = $this->pageModel->get_model_by_id_single($ty->model_id);
                            $output .=''.$ty1->model_name.'<br>';
                        }
                        
                    }
                    $output.='</td><td style="border-left:1px solid black">';

                    $item_name=explode('|||',$y->item_name);
                    for($j=0;$j<sizeof($item_name);$j++)
                    {
                        $output .=''.$item_name[$j].'<br>';
                    }
                    $output.='</td><td style="border-left:1px solid black">';
                         $item_qty=explode('|||',$y->item_qty);
                    for($k=0;$k<sizeof($item_qty);$k++)
                    {
                        $output .=''.$item_qty[$k].'<br>';
                    }
                      $output.='</td><td style="border-left:1px solid black">';
                             $item_rec=explode('|||',$y->item_rec);
                    for($p=0;$p<sizeof($item_rec);$p++)
                    {
                        if($item_rec[$p]==0)
                        {
                            $item_rec[$p] = "Carton";   
                        }
                        elseif($item_rec[$p]==1)
                        {
                            $item_rec[$p] = "Box";   
                        }
                        else
                        {
                            $item_rec[$p] = "Pieces";   
                        }
                        $output .=''.$item_rec[$p].'<br>';
                    }       
                    $output.='</td></tr>';
                }
            }
            else
            {
                if($cp_cust->cp_priority==0)
                {
                   $y=$key;
                    $output .='<tr style="border:1px solid black"><td>'.$key->p_id.'</td>';
                    $output .='<td style="border-left:1px solid black">'.date('d-m-Y h:m A',strtotime($key->pack_date)).'</td>';
                    $item_id=explode('|||',$y->item_id);
                    $output .='<td style="border-left:1px solid black">'.$key->customer.'</td><td style="border-left:1px solid black">';
                    for($i=0;$i<sizeof($item_id);$i++)
                    {
                        $output .=''.$item_id[$i].'<br>';
                    }
                    $output .='</td><td style="border-left:1px solid black">';
                    for($i=0;$i<sizeof($item_id);$i++)
                    {
                        $ty = $this->pageModel->get_single_item($item_id[$i]);
                        if($ty)
                        {
                            $ty1 = $this->pageModel->get_type_name_by_id($ty->type_id);
                            $output .=''.$ty1->type_name.'<br>';
                        }
                        
                    }
                    $output .='</td><td style="border-left:1px solid black">';
                    for($i=0; $i<sizeof($item_id); $i++)
                    {
                        $ty = $this->pageModel->get_single_item($item_id[$i]);
                        if($ty)
                        {
                            $ty1 = $this->pageModel->get_model_by_id_single($ty->model_id);
                            $output .=''.$ty1->model_name.'<br>';
                        }
                        
                    }
                    $output.='</td><td style="border-left:1px solid black">';

                    $item_name=explode('|||',$y->item_name);
                    for($j=0;$j<sizeof($item_name);$j++)
                    {
                        $output .=''.$item_name[$j].'<br>';
                    }
                    $output.='</td><td style="border-left:1px solid black">';
                         $item_qty=explode('|||',$y->item_qty);
                    for($k=0;$k<sizeof($item_qty);$k++)
                    {
                        $output .=''.$item_qty[$k].'<br>';
                    }
                      $output.='</td><td style="border-left:1px solid black">';
                             $item_rec=explode('|||',$y->item_rec);
                    for($p=0;$p<sizeof($item_rec);$p++)
                    {
                        if($item_rec[$p]==0)
                        {
                            $item_rec[$p] = "Carton";   
                        }
                        elseif($item_rec[$p]==1)
                        {
                            $item_rec[$p] = "Box";   
                        }
                        else
                        {
                            $item_rec[$p] = "Pieces";   
                        }
                        $output .=''.$item_rec[$p].'<br>';
                    }       
                    $output.='</td></tr>';     
                }
            }
        }
        echo $output;
    }
    public function date_and_cust_wise_direct_package_report_data()
    {
        $sto = $_POST['to'];
        $sfrom = $_POST['from'];
        $customer_list = $_POST['customer_list'];
        $x = $this->pageModel->getalldirect_packagedetails_with_date_and_cust($sto,$sfrom,$customer_list);
        $output = "";
        foreach ($x as $key)
        {
            $cp_cust = $this->pageModel->get_all_customer_cp_priority($key->customer_id);
            if($_SESSION['ctype'] == 3)
            {
                $y=$key;
                $output .='<tr style="border:1px solid black"><td>'.$key->p_id.'</td>';
                $output .='<td style="border-left:1px solid black">'.date('d-m-Y h:m A',strtotime($key->pack_date)).'</td>';
                $item_id=explode('|||',$y->item_id);
                $output .='<td style="border-left:1px solid black">'.$key->customer.'</td><td style="border-left:1px solid black">';
                for($i=0;$i<sizeof($item_id);$i++)
                {
                    $output .=''.$item_id[$i].'<br>';
                }
                $output .='</td><td style="border-left:1px solid black">';
                for($i=0;$i<sizeof($item_id);$i++)
                {
                    $ty = $this->pageModel->get_single_item($item_id[$i]);
                    if($ty)
                    {
                        $ty1 = $this->pageModel->get_type_name_by_id($ty->type_id);
                        $output .=''.$ty1->type_name.'<br>';
                    }
                    
                }
                $output .='</td><td style="border-left:1px solid black">';
                for($i=0; $i<sizeof($item_id); $i++)
                {
                    $ty = $this->pageModel->get_single_item($item_id[$i]);
                    if($ty)
                    {
                        $ty1 = $this->pageModel->get_model_by_id_single($ty->model_id);
                        $output .=''.$ty1->model_name.'<br>';
                    }
                    
                }
                $output.='</td><td style="border-left:1px solid black">';

                $item_name=explode('|||',$y->item_name);
                for($j=0;$j<sizeof($item_name);$j++)
                {
                    $output .=''.$item_name[$j].'<br>';
                }
                $output.='</td><td style="border-left:1px solid black">';
                     $item_qty=explode('|||',$y->item_qty);
                for($k=0;$k<sizeof($item_qty);$k++)
                {
                    $output .=''.$item_qty[$k].'<br>';
                }
                  $output.='</td><td style="border-left:1px solid black">';
                         $item_rec=explode('|||',$y->item_rec);
                for($p=0;$p<sizeof($item_rec);$p++)
                {
                    if($item_rec[$p]==0)
                    {
                        $item_rec[$p] = "Carton";   
                    }
                    elseif($item_rec[$p]==1)
                    {
                        $item_rec[$p] = "Box";   
                    }
                    else
                    {
                        $item_rec[$p] = "Pieces";   
                    }
                    $output .=''.$item_rec[$p].'<br>';
                }       
                $output.='</td></tr>';
                
            }elseif($_SESSION['ctype'] == 1)
            {
                if($cp_cust->cp_priority==1)
                {

                    $y=$key;
                    $output .='<tr style="border:1px solid black"><td>'.$key->p_id.'</td>';
                    $output .='<td style="border-left:1px solid black">'.date('d-m-Y h:m A',strtotime($key->pack_date)).'</td>';
                    $item_id=explode('|||',$y->item_id);
                    $output .='<td style="border-left:1px solid black">'.$key->customer.'</td><td style="border-left:1px solid black">';
                    for($i=0;$i<sizeof($item_id);$i++)
                    {
                        $output .=''.$item_id[$i].'<br>';
                    }
                    $output .='</td><td style="border-left:1px solid black">';
                    for($i=0;$i<sizeof($item_id);$i++)
                    {
                        $ty = $this->pageModel->get_single_item($item_id[$i]);
                        if($ty)
                        {
                            $ty1 = $this->pageModel->get_type_name_by_id($ty->type_id);
                            $output .=''.$ty1->type_name.'<br>';
                        }
                        
                    }
                    $output .='</td><td style="border-left:1px solid black">';
                    for($i=0; $i<sizeof($item_id); $i++)
                    {
                        $ty = $this->pageModel->get_single_item($item_id[$i]);
                        if($ty)
                        {
                            $ty1 = $this->pageModel->get_model_by_id_single($ty->model_id);
                            $output .=''.$ty1->model_name.'<br>';
                        }
                        
                    }
                    $output.='</td><td style="border-left:1px solid black">';

                    $item_name=explode('|||',$y->item_name);
                    for($j=0;$j<sizeof($item_name);$j++)
                    {
                        $output .=''.$item_name[$j].'<br>';
                    }
                    $output.='</td><td style="border-left:1px solid black">';
                         $item_qty=explode('|||',$y->item_qty);
                    for($k=0;$k<sizeof($item_qty);$k++)
                    {
                        $output .=''.$item_qty[$k].'<br>';
                    }
                      $output.='</td><td style="border-left:1px solid black">';
                             $item_rec=explode('|||',$y->item_rec);
                    for($p=0;$p<sizeof($item_rec);$p++)
                    {
                        if($item_rec[$p]==0)
                        {
                            $item_rec[$p] = "Carton";   
                        }
                        elseif($item_rec[$p]==1)
                        {
                            $item_rec[$p] = "Box";   
                        }
                        else
                        {
                            $item_rec[$p] = "Pieces";   
                        }
                        $output .=''.$item_rec[$p].'<br>';
                    }       
                    $output.='</td></tr>';
                }
            }
            elseif($_SESSION['ctype'] == 4)
            {
                if($cp_cust->cp_priority==4)
                {

                    $y=$key;
                    $output .='<tr style="border:1px solid black"><td>'.$key->p_id.'</td>';
                    $output .='<td style="border-left:1px solid black">'.date('d-m-Y h:m A',strtotime($key->pack_date)).'</td>';
                    $item_id=explode('|||',$y->item_id);
                    $output .='<td style="border-left:1px solid black">'.$key->customer.'</td><td style="border-left:1px solid black">';
                    for($i=0;$i<sizeof($item_id);$i++)
                    {
                        $output .=''.$item_id[$i].'<br>';
                    }
                    $output .='</td><td style="border-left:1px solid black">';
                    for($i=0;$i<sizeof($item_id);$i++)
                    {
                        $ty = $this->pageModel->get_single_item($item_id[$i]);
                        if($ty)
                        {
                            $ty1 = $this->pageModel->get_type_name_by_id($ty->type_id);
                            $output .=''.$ty1->type_name.'<br>';
                        }
                        
                    }
                    $output .='</td><td style="border-left:1px solid black">';
                    for($i=0; $i<sizeof($item_id); $i++)
                    {
                        $ty = $this->pageModel->get_single_item($item_id[$i]);
                        if($ty)
                        {
                            $ty1 = $this->pageModel->get_model_by_id_single($ty->model_id);
                            $output .=''.$ty1->model_name.'<br>';
                        }
                        
                    }
                    $output.='</td><td style="border-left:1px solid black">';

                    $item_name=explode('|||',$y->item_name);
                    for($j=0;$j<sizeof($item_name);$j++)
                    {
                        $output .=''.$item_name[$j].'<br>';
                    }
                    $output.='</td><td style="border-left:1px solid black">';
                         $item_qty=explode('|||',$y->item_qty);
                    for($k=0;$k<sizeof($item_qty);$k++)
                    {
                        $output .=''.$item_qty[$k].'<br>';
                    }
                      $output.='</td><td style="border-left:1px solid black">';
                             $item_rec=explode('|||',$y->item_rec);
                    for($p=0;$p<sizeof($item_rec);$p++)
                    {
                        if($item_rec[$p]==0)
                        {
                            $item_rec[$p] = "Carton";   
                        }
                        elseif($item_rec[$p]==1)
                        {
                            $item_rec[$p] = "Box";   
                        }
                        else
                        {
                            $item_rec[$p] = "Pieces";   
                        }
                        $output .=''.$item_rec[$p].'<br>';
                    }       
                    $output.='</td></tr>';
                }
            }
            elseif($_SESSION['ctype'] == 5)
            {
                if($cp_cust->cp_priority==5)
                {

                    $y=$key;
                    $output .='<tr style="border:1px solid black"><td>'.$key->p_id.'</td>';
                    $output .='<td style="border-left:1px solid black">'.date('d-m-Y h:m A',strtotime($key->pack_date)).'</td>';
                    $item_id=explode('|||',$y->item_id);
                    $output .='<td style="border-left:1px solid black">'.$key->customer.'</td><td style="border-left:1px solid black">';
                    for($i=0;$i<sizeof($item_id);$i++)
                    {
                        $output .=''.$item_id[$i].'<br>';
                    }
                    $output .='</td><td style="border-left:1px solid black">';
                    for($i=0;$i<sizeof($item_id);$i++)
                    {
                        $ty = $this->pageModel->get_single_item($item_id[$i]);
                        if($ty)
                        {
                            $ty1 = $this->pageModel->get_type_name_by_id($ty->type_id);
                            $output .=''.$ty1->type_name.'<br>';
                        }
                        
                    }
                    $output .='</td><td style="border-left:1px solid black">';
                    for($i=0; $i<sizeof($item_id); $i++)
                    {
                        $ty = $this->pageModel->get_single_item($item_id[$i]);
                        if($ty)
                        {
                            $ty1 = $this->pageModel->get_model_by_id_single($ty->model_id);
                            $output .=''.$ty1->model_name.'<br>';
                        }
                        
                    }
                    $output.='</td><td style="border-left:1px solid black">';

                    $item_name=explode('|||',$y->item_name);
                    for($j=0;$j<sizeof($item_name);$j++)
                    {
                        $output .=''.$item_name[$j].'<br>';
                    }
                    $output.='</td><td style="border-left:1px solid black">';
                         $item_qty=explode('|||',$y->item_qty);
                    for($k=0;$k<sizeof($item_qty);$k++)
                    {
                        $output .=''.$item_qty[$k].'<br>';
                    }
                      $output.='</td><td style="border-left:1px solid black">';
                             $item_rec=explode('|||',$y->item_rec);
                    for($p=0;$p<sizeof($item_rec);$p++)
                    {
                        if($item_rec[$p]==0)
                        {
                            $item_rec[$p] = "Carton";   
                        }
                        elseif($item_rec[$p]==1)
                        {
                            $item_rec[$p] = "Box";   
                        }
                        else
                        {
                            $item_rec[$p] = "Pieces";   
                        }
                        $output .=''.$item_rec[$p].'<br>';
                    }       
                    $output.='</td></tr>';
                }
            }
            elseif($_SESSION['ctype'] == 6)
            {
                if($cp_cust->cp_priority==6)
                {

                    $y=$key;
                    $output .='<tr style="border:1px solid black"><td>'.$key->p_id.'</td>';
                    $output .='<td style="border-left:1px solid black">'.date('d-m-Y h:m A',strtotime($key->pack_date)).'</td>';
                    $item_id=explode('|||',$y->item_id);
                    $output .='<td style="border-left:1px solid black">'.$key->customer.'</td><td style="border-left:1px solid black">';
                    for($i=0;$i<sizeof($item_id);$i++)
                    {
                        $output .=''.$item_id[$i].'<br>';
                    }
                    $output .='</td><td style="border-left:1px solid black">';
                    for($i=0;$i<sizeof($item_id);$i++)
                    {
                        $ty = $this->pageModel->get_single_item($item_id[$i]);
                        if($ty)
                        {
                            $ty1 = $this->pageModel->get_type_name_by_id($ty->type_id);
                            $output .=''.$ty1->type_name.'<br>';
                        }
                        
                    }
                    $output .='</td><td style="border-left:1px solid black">';
                    for($i=0; $i<sizeof($item_id); $i++)
                    {
                        $ty = $this->pageModel->get_single_item($item_id[$i]);
                        if($ty)
                        {
                            $ty1 = $this->pageModel->get_model_by_id_single($ty->model_id);
                            $output .=''.$ty1->model_name.'<br>';
                        }
                        
                    }
                    $output.='</td><td style="border-left:1px solid black">';

                    $item_name=explode('|||',$y->item_name);
                    for($j=0;$j<sizeof($item_name);$j++)
                    {
                        $output .=''.$item_name[$j].'<br>';
                    }
                    $output.='</td><td style="border-left:1px solid black">';
                         $item_qty=explode('|||',$y->item_qty);
                    for($k=0;$k<sizeof($item_qty);$k++)
                    {
                        $output .=''.$item_qty[$k].'<br>';
                    }
                      $output.='</td><td style="border-left:1px solid black">';
                             $item_rec=explode('|||',$y->item_rec);
                    for($p=0;$p<sizeof($item_rec);$p++)
                    {
                        if($item_rec[$p]==0)
                        {
                            $item_rec[$p] = "Carton";   
                        }
                        elseif($item_rec[$p]==1)
                        {
                            $item_rec[$p] = "Box";   
                        }
                        else
                        {
                            $item_rec[$p] = "Pieces";   
                        }
                        $output .=''.$item_rec[$p].'<br>';
                    }       
                    $output.='</td></tr>';
                }
            }
            elseif($_SESSION['ctype'] == 7)
            {
                if($cp_cust->cp_priority==7)
                {

                    $y=$key;
                    $output .='<tr style="border:1px solid black"><td>'.$key->p_id.'</td>';
                    $output .='<td style="border-left:1px solid black">'.date('d-m-Y h:m A',strtotime($key->pack_date)).'</td>';
                    $item_id=explode('|||',$y->item_id);
                    $output .='<td style="border-left:1px solid black">'.$key->customer.'</td><td style="border-left:1px solid black">';
                    for($i=0;$i<sizeof($item_id);$i++)
                    {
                        $output .=''.$item_id[$i].'<br>';
                    }
                    $output .='</td><td style="border-left:1px solid black">';
                    for($i=0;$i<sizeof($item_id);$i++)
                    {
                        $ty = $this->pageModel->get_single_item($item_id[$i]);
                        if($ty)
                        {
                            $ty1 = $this->pageModel->get_type_name_by_id($ty->type_id);
                            $output .=''.$ty1->type_name.'<br>';
                        }
                        
                    }
                    $output .='</td><td style="border-left:1px solid black">';
                    for($i=0; $i<sizeof($item_id); $i++)
                    {
                        $ty = $this->pageModel->get_single_item($item_id[$i]);
                        if($ty)
                        {
                            $ty1 = $this->pageModel->get_model_by_id_single($ty->model_id);
                            $output .=''.$ty1->model_name.'<br>';
                        }
                        
                    }
                    $output.='</td><td style="border-left:1px solid black">';

                    $item_name=explode('|||',$y->item_name);
                    for($j=0;$j<sizeof($item_name);$j++)
                    {
                        $output .=''.$item_name[$j].'<br>';
                    }
                    $output.='</td><td style="border-left:1px solid black">';
                         $item_qty=explode('|||',$y->item_qty);
                    for($k=0;$k<sizeof($item_qty);$k++)
                    {
                        $output .=''.$item_qty[$k].'<br>';
                    }
                      $output.='</td><td style="border-left:1px solid black">';
                             $item_rec=explode('|||',$y->item_rec);
                    for($p=0;$p<sizeof($item_rec);$p++)
                    {
                        if($item_rec[$p]==0)
                        {
                            $item_rec[$p] = "Carton";   
                        }
                        elseif($item_rec[$p]==1)
                        {
                            $item_rec[$p] = "Box";   
                        }
                        else
                        {
                            $item_rec[$p] = "Pieces";   
                        }
                        $output .=''.$item_rec[$p].'<br>';
                    }       
                    $output.='</td></tr>';
                }
            }
            elseif($_SESSION['ctype'] == 8)
            {
                if($cp_cust->cp_priority==8)
                {

                    $y=$key;
                    $output .='<tr style="border:1px solid black"><td>'.$key->p_id.'</td>';
                    $output .='<td style="border-left:1px solid black">'.date('d-m-Y h:m A',strtotime($key->pack_date)).'</td>';
                    $item_id=explode('|||',$y->item_id);
                    $output .='<td style="border-left:1px solid black">'.$key->customer.'</td><td style="border-left:1px solid black">';
                    for($i=0;$i<sizeof($item_id);$i++)
                    {
                        $output .=''.$item_id[$i].'<br>';
                    }
                    $output .='</td><td style="border-left:1px solid black">';
                    for($i=0;$i<sizeof($item_id);$i++)
                    {
                        $ty = $this->pageModel->get_single_item($item_id[$i]);
                        if($ty)
                        {
                            $ty1 = $this->pageModel->get_type_name_by_id($ty->type_id);
                            $output .=''.$ty1->type_name.'<br>';
                        }
                        
                    }
                    $output .='</td><td style="border-left:1px solid black">';
                    for($i=0; $i<sizeof($item_id); $i++)
                    {
                        $ty = $this->pageModel->get_single_item($item_id[$i]);
                        if($ty)
                        {
                            $ty1 = $this->pageModel->get_model_by_id_single($ty->model_id);
                            $output .=''.$ty1->model_name.'<br>';
                        }
                        
                    }
                    $output.='</td><td style="border-left:1px solid black">';

                    $item_name=explode('|||',$y->item_name);
                    for($j=0;$j<sizeof($item_name);$j++)
                    {
                        $output .=''.$item_name[$j].'<br>';
                    }
                    $output.='</td><td style="border-left:1px solid black">';
                         $item_qty=explode('|||',$y->item_qty);
                    for($k=0;$k<sizeof($item_qty);$k++)
                    {
                        $output .=''.$item_qty[$k].'<br>';
                    }
                      $output.='</td><td style="border-left:1px solid black">';
                             $item_rec=explode('|||',$y->item_rec);
                    for($p=0;$p<sizeof($item_rec);$p++)
                    {
                        if($item_rec[$p]==0)
                        {
                            $item_rec[$p] = "Carton";   
                        }
                        elseif($item_rec[$p]==1)
                        {
                            $item_rec[$p] = "Box";   
                        }
                        else
                        {
                            $item_rec[$p] = "Pieces";   
                        }
                        $output .=''.$item_rec[$p].'<br>';
                    }       
                    $output.='</td></tr>';
                }
            }
            elseif($_SESSION['ctype'] == 9)
            {
                if($cp_cust->cp_priority==9)
                {

                    $y=$key;
                    $output .='<tr style="border:1px solid black"><td>'.$key->p_id.'</td>';
                    $output .='<td style="border-left:1px solid black">'.date('d-m-Y h:m A',strtotime($key->pack_date)).'</td>';
                    $item_id=explode('|||',$y->item_id);
                    $output .='<td style="border-left:1px solid black">'.$key->customer.'</td><td style="border-left:1px solid black">';
                    for($i=0;$i<sizeof($item_id);$i++)
                    {
                        $output .=''.$item_id[$i].'<br>';
                    }
                    $output .='</td><td style="border-left:1px solid black">';
                    for($i=0;$i<sizeof($item_id);$i++)
                    {
                        $ty = $this->pageModel->get_single_item($item_id[$i]);
                        if($ty)
                        {
                            $ty1 = $this->pageModel->get_type_name_by_id($ty->type_id);
                            $output .=''.$ty1->type_name.'<br>';
                        }
                        
                    }
                    $output .='</td><td style="border-left:1px solid black">';
                    for($i=0; $i<sizeof($item_id); $i++)
                    {
                        $ty = $this->pageModel->get_single_item($item_id[$i]);
                        if($ty)
                        {
                            $ty1 = $this->pageModel->get_model_by_id_single($ty->model_id);
                            $output .=''.$ty1->model_name.'<br>';
                        }
                        
                    }
                    $output.='</td><td style="border-left:1px solid black">';

                    $item_name=explode('|||',$y->item_name);
                    for($j=0;$j<sizeof($item_name);$j++)
                    {
                        $output .=''.$item_name[$j].'<br>';
                    }
                    $output.='</td><td style="border-left:1px solid black">';
                         $item_qty=explode('|||',$y->item_qty);
                    for($k=0;$k<sizeof($item_qty);$k++)
                    {
                        $output .=''.$item_qty[$k].'<br>';
                    }
                      $output.='</td><td style="border-left:1px solid black">';
                             $item_rec=explode('|||',$y->item_rec);
                    for($p=0;$p<sizeof($item_rec);$p++)
                    {
                        if($item_rec[$p]==0)
                        {
                            $item_rec[$p] = "Carton";   
                        }
                        elseif($item_rec[$p]==1)
                        {
                            $item_rec[$p] = "Box";   
                        }
                        else
                        {
                            $item_rec[$p] = "Pieces";   
                        }
                        $output .=''.$item_rec[$p].'<br>';
                    }       
                    $output.='</td></tr>';
                }
            }
            else
            {
                if($cp_cust->cp_priority==0)
                {
                   $y=$key;
                    $output .='<tr style="border:1px solid black"><td>'.$key->p_id.'</td>';
                    $output .='<td style="border-left:1px solid black">'.date('d-m-Y h:m A',strtotime($key->pack_date)).'</td>';
                    $item_id=explode('|||',$y->item_id);
                    $output .='<td style="border-left:1px solid black">'.$key->customer.'</td><td style="border-left:1px solid black">';
                    for($i=0;$i<sizeof($item_id);$i++)
                    {
                        $output .=''.$item_id[$i].'<br>';
                    }
                    $output .='</td><td style="border-left:1px solid black">';
                    for($i=0;$i<sizeof($item_id);$i++)
                    {
                        $ty = $this->pageModel->get_single_item($item_id[$i]);
                        if($ty)
                        {
                            $ty1 = $this->pageModel->get_type_name_by_id($ty->type_id);
                            $output .=''.$ty1->type_name.'<br>';
                        }
                        
                    }
                    $output .='</td><td style="border-left:1px solid black">';
                    for($i=0; $i<sizeof($item_id); $i++)
                    {
                        $ty = $this->pageModel->get_single_item($item_id[$i]);
                        if($ty)
                        {
                            $ty1 = $this->pageModel->get_model_by_id_single($ty->model_id);
                            $output .=''.$ty1->model_name.'<br>';
                        }
                        
                    }
                    $output.='</td><td style="border-left:1px solid black">';

                    $item_name=explode('|||',$y->item_name);
                    for($j=0;$j<sizeof($item_name);$j++)
                    {
                        $output .=''.$item_name[$j].'<br>';
                    }
                    $output.='</td><td style="border-left:1px solid black">';
                         $item_qty=explode('|||',$y->item_qty);
                    for($k=0;$k<sizeof($item_qty);$k++)
                    {
                        $output .=''.$item_qty[$k].'<br>';
                    }
                      $output.='</td><td style="border-left:1px solid black">';
                             $item_rec=explode('|||',$y->item_rec);
                    for($p=0;$p<sizeof($item_rec);$p++)
                    {
                        if($item_rec[$p]==0)
                        {
                            $item_rec[$p] = "Carton";   
                        }
                        elseif($item_rec[$p]==1)
                        {
                            $item_rec[$p] = "Box";   
                        }
                        else
                        {
                            $item_rec[$p] = "Pieces";   
                        }
                        $output .=''.$item_rec[$p].'<br>';
                    }       
                    $output.='</td></tr>';     
                }
            }
        }
        echo $output;
    }
    public function item_by_categorypartno()
    {
        if(isset($_SESSION['temp_print']))
        {
            unset($_SESSION['temp_print']);
            redirect('pages/item_by_categorypartno');
        }
        $data = [
            'part_no'=>$this->pageModel->get_all_partnumbers(),
            'cat' => $this->pageModel->getAllCategoriesDb(),
            'cat1' => $this->pageModel->getAllCategoriesDb2(),
            'cat2' => $this->pageModel->getAllCategoriesDb3(),
            'cat3' => $this->pageModel->getAllCategoriesDb4(),
            'type' => $this->pageModel->getAlltypeDb(),
            'model' => $this->pageModel->getAllCategoriesDb_model(),
            'cat_new' => $this->pageModel->getAllCategoriesDb_new(),
            'subcat_new' => $this->pageModel->getAllsubCategoriesDb_new(),
            'color' => $this->pageModel->getAllcolorDb_new(),
            'size' => $this->pageModel->getAllsizeDb_new(),
            'all_mfg' => $this->pageModel->getallmfg(),
        ];
        $this->view('pages/item_by_categorypartno',$data);
    }
    public function by_allcategory_item_cat1_partnumber()
    {
        $part_no = $_POST['part_no'];
        if(!empty($part_no))
        {
            $allComp = $this->pageModel->get_all_items_by_partnumber($part_no);
        }
        else
        {
            $allComp = $this->pageModel->get_all_category_wise_details();
        }
        $output = "";
        $sum=0;
        $post = new Page();
        $tt = 0;
        foreach ($allComp as $k) {
            $a = 0;
            $b = 0;
            $c = 0;
            $d = 0;
            $b1=0;
            $d1=0;
            $c1 = 0;
            $s_stock = $post->get_single_stock($k->id);
            foreach ($s_stock as $kw)
            {
                $a = $a + $kw->stock_total_receive;
                if($kw->receivable == 0)
                {
                    $b1 = $b1 + $kw->stock_total_receive;
                    $d1 = (int)$k->carton_qty * (int)$b1;
                    $c1 = (int)$k->qty * (int)$d1;
                }
                if($kw->receivable == 1)
                {
                    $b = (int)$b + (int)$kw->stock_total_receive;
                    $d = (int)$k->qty * (int)$b;
                }
                if($kw->receivable == 3)
                {
                    $c = $c + $kw->stock_total_receive;
                }
            }
            $type_id = $post->get_type_name_by_id($k->type_id);
            if(empty($type_id)){ $type_id = "--";}else{ $type_id = $type_id->type_name; }
            $model_id = $post->get_model_name_by_id($k->model_id);
            if(empty($model_id)){ $model_id = "--";}else{ $model_id = $model_id->model_name; }
            $category_new_id = $post->get_category_name_by_id($k->category_new_id);
             if(empty($category_new_id)){ $category_new_id = "--";}else{ $category_new_id = $category_new_id->category_name; }
            $subcategory_new_id = $post->get_subcategory_name_by_id($k->subcategory_new_id);
            if(empty($subcategory_new_id)){ $subcategory_new_id = "--";}else{ $subcategory_new_id = $subcategory_new_id->sc_name; }
            $dt = date("d-m-Y h:i:s a", strtotime($k->created_at));
            $sum = $sum + $a;
            if($k->receive==0)
            { 
                $rec ="Carton([B]Qty ".$k->carton_qty.")<br>Box([P]Qty ".$k->qty.")"; 
            }
            elseif($k->receive==1)
            { 
                $rec ="Box([P]Qty ".$k->qty.")"; 
            }
            else
            { 
                $rec ="Pieces(Qty ".$k->qty.")";
            }
        $output .= '<tr>
            <td>'.$k->id.'</td>
            <td>'.$k->name.'</td>
            <td>'.$rec.'</td>
            <td>'.$type_id.'</td>
            <td>'.$model_id.'</td>
            <td>'.$category_new_id.'</td>
            <td>'.$subcategory_new_id.'</td>
            <td>Carton('.$b1.')<br>Box('.$b.')<br>Pieces('.$c.')</td>
            <td class="td-cust-b">'.$d = $d + $c + $c1.'</td>
        </tr>';
        }
        $_SESSION['sum'] = $sum;
        echo $output;
    }
    public function print_items_by_category_wise_partno()
    {
        $_SESSION['temp_print']=1;
        $category_id = $_POST['c1'];
        if(!empty($category_id))
        {
            $allComp = $this->pageModel->get_all_items_by_partnumber($category_id);
        }
        else
        {
            $allComp = $this->pageModel->get_all_category_wise_details();
        }
        $data = [ 'all_it'=> $allComp,
                   
                ];
        $this->view('pages/print_items_partno',$data);
    }

	
}
?>
                            
                            
