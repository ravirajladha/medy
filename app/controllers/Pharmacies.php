<?php
class Pharmacies extends Controller
{
  public function __construct()
  {
    $this->pharmcyModel = $this->model('Pharmacy');
	$this->doctorModel = $this->model('Doctor');
    $this->receptionModel = $this->model('Reception');
  }

  public function index()
  { 
      $sum=0;    
      $b=0;
      $a=0;
      $c=0;
        $counter = $this->pharmcyModel->get_today_order_count();
        $total = $this->pharmcyModel->get_today_order_total_count();
         foreach($total as $s) :
          (int)$sum = (int)$sum + (int)$s->invoice_total;
         endforeach;

        foreach($total as $a) :
          $sep = explode(',', $a->invoice_items);
          
              foreach ($sep as $b) :
                {
                    (int)$c = (int)$c + (int)$b;
                }
            endforeach;

         endforeach;
  

        $count = $this->pharmcyModel->get_new_order_count();
        $drug = $this->pharmcyModel->get_all_drug_count();
        $stock = $this->pharmcyModel->get_all_stock_count();
        $data = [
            'product_sold' => $c,
            'sum' => $sum,
            'counter' => $counter,
            'new_order_count' => $count,
            'drug' => $drug,
            'stock' => $stock
        ];
    $this->view('pharmacies/index', $data);
  }

  public function new_order()
  {
    $this->view('pharmacies/new_order');
  }
    public function edit_order($id)
    {
        unset($_SESSION['forCheckEditComplete']);
        $this->pharmcyModel->deleteAllInvoiceEdit();
        redirect('pharmacies/edit_order1/'.$id.'');
    }

    public function edit_order1($id)
    {
        $check = $this->pharmcyModel->getTheEditPharmacy();
        if(empty($check))
        {
            $this->pharmcyModel->getTheEditInvoiceDetails($id);
            $data = [
                'edit' => $this->pharmcyModel->getTheEditPharmacy(),
                'invoice_details' => $this->pharmcyModel->get_invoice_by_id($id),
                'id' => $id
            ];
            $this->view('pharmacies/edit_order', $data);
        }
        else
        {
            // $this->pharmcyModel->getTheEditInvoiceDetails($id);
            $data = [
                'edit' => $this->pharmcyModel->getTheEditPharmacy(),
                'invoice_details' => $this->pharmcyModel->get_invoice_by_id($id),
                'id' => $id
            ];
            $this->view('pharmacies/edit_order', $data);
        }
    }


   public function get_batch_for_med($a)
      {
  
            $a = explode('(', $a);
            $a = explode(')', $a[1]);
            $a = $a[0];
           return $batch = $this->pharmcyModel->get_batch_using_id($a);
      }  


  public function all_orders()
  {
    $this->view('pharmacies/all_orders');
  }

  public function order_request()
  {
    $this->view('pharmacies/order_request');
  }

  public function order_request_op()
  {
    $this->view('pharmacies/order_request_op');
  }

  public function add_drugs()
  {
    $this->view('pharmacies/add_drugs');
  }

  public function edit_drug($id)
  {
    $drug_detail = $this->pharmcyModel->get_drug_details($id);
    $data = [
      'drug_detail' => $drug_detail
    ];
    $this->view('pharmacies/add_drugs', $data);
  }

  public function all_drugs()
  {
    $check = 1;
    $data = [
      'check' => $check
    ];
    $this->view('pharmacies/all_drugs', $data);
  }

  public function all_drugs_sort($sort_val)
  {
    $data = [
      'check' => $sort_val
    ];
    $this->view('pharmacies/all_drugs', $data);
  }

  public function new_purchase()
  {
    $this->view('pharmacies/new_purchase');
  }

  public function all_purchase()
  {
    $data = [
      'sort' => 1
    ];
    $this->view('pharmacies/all_purchase', $data);
  }

  public function reports()
  {
    $this->view('pharmacies/reports');
  }

  public function get_report()
  {
    $this->view('pharmacies/get_report');
  }

  public function drug($id)
  {
    $drug_details = $this->pharmcyModel->get_drug_details($id);
    $stock_details = $this->pharmcyModel->get_stock_detailsx($id);
    $data = [
      'drug' => $drug_details,
      'stock' => $stock_details
    ];
    $this->view('pharmacies/drug', $data);
  }

  public function new_drug()
  {
    $ch = $_POST['ch'];
    $drug_name = $_POST['drug_name'];
    $drug_gen = $_POST['drug_gen'];
    $drug_form = $_POST['drug_form'];
    $drug_unit_dosage = $_POST['drug_unit_dosage'];
    $drug_manf = $_POST['drug_manf'];
    $min_drg_pack = $_POST['min_drg_pack'];

    if($ch == 1)
    {
      $success = $this->pharmcyModel->save_drug($drug_name, $drug_gen, $drug_manf, $drug_form, $drug_unit_dosage, $min_drg_pack);
    }

    else
    {
      $success = $this->pharmcyModel->update_drug($drug_name, $drug_gen, $drug_manf, $drug_form, $drug_unit_dosage, $min_drg_pack, $ch);
    }
    
    if($success)
    {
      if($ch == 1)
      {
        echo "Drug Added";
      }
      else
      {
        echo "Drug Updated";      }
    }
    else
    {
      echo "Error";
    }

  }

    public function get_auto_drug()
    {
    $cname = $_POST['query3'];
    $cust_list = $this->pharmcyModel->auto_drug_name($cname);
    $output3 = '';
    $output3 = '<ul class="list-unstyled">';
    foreach ($cust_list as $key)
    {
    $output3 .='<li class="ee">'.$key->drug_name.''." | ".''.$key->drug_id.'</li>';
    }
    $output3.='</ul>';
    echo $output3;
    }

    public function get_drug_autocomplete()
    {
      $cname = $_POST['query'];
      $cust_list = $this->pharmcyModel->auto_drug_name($cname);
      $output3 = '';
      $output3 = '<ul class="list-unstyled">';
      foreach ($cust_list as $key)
      {
      $output3 .='<li class="cc">'.ucwords($key->drug_name).''."(".''.$key->drug_id.''.") ".'</li>';
      }
      $output3.='</ul>';
      echo $output3;
    }

    public function get_drug_autocomplete_x()
    {
      $cname = $_POST['query'];
      $cust_list = $this->pharmcyModel->auto_drug_name($cname);
      $output3 = '';
      $output3 = '<ul class="list-unstyled">';
      foreach ($cust_list as $key)
      {
      $output3 .='<li class="ccx">'.$key->drug_name.''."(".''.$key->drug_id.''.")".'</li>';
      }
      $output3.='</ul>';
      echo $output3;
    }

    public function get_drug_autocomplete1()
    {
      $cname = $_POST['query'];
      $id = $_POST['button_idq'];
    $cust_list = $this->pharmcyModel->auto_drug_name($cname);
    $output3 = '';
    $output3 = '<ul class="list-unstyled">';
    foreach ($cust_list as $key)
    {
      $batch_val = $this->pharmcyModel->get_batch_name($key->drug_id);
      foreach ($batch_val as $key2)
        {
            $batch = $key2->stock_batch;
        }
      $service_name_id = ucwords($key->drug_name)."(".$key->drug_id.")";
      $output3 .='<li id="new'.$key->drug_id.'" class="cccc" value="'.$service_name_id.'" onclick="mydat_val('.$id.','.$key->drug_id.','.$key->drug_id.')">'.$key->drug_name.''."(".''.$key->drug_id.''.")".'</li>';
    }
    $output3.='</ul>';
    echo $output3;
    }

    public function get_drug_autocomplete2()
    {
      $cname = $_POST['query'];
    $cust_list = $this->pharmcyModel->auto_drug_name($cname);
    $output3 = '';
    $output3 = '<ul class="list-unstyled">';
    foreach ($cust_list as $key)
    {
    $output3 .='<li class="ccc">'.$key->drug_name.''." | ".''.$key->drug_id.'</li>';
    }
    $output3.='</ul>';
    echo $output3;
    }

    public function get_auto_dist()
    {
      $cname = $_POST['query3'];
    $cust_list = $this->pharmcyModel->auto_dist_name($cname);
    $output3 = '';
    $output3 = '<ul class="list-unstyled">';
    foreach ($cust_list as $key)
    {
    $output3 .='<li class="ff">'.$key->stock_distributor.'</li>';
    }
    $output3.='</ul>';
    echo $output3;
    }

    public function all_drugs1()
    {
      $filter = $_POST['filter'];
      $lim = $_POST['lim'];
        $lim = (int)$lim;
        if($lim==9)
        {
          $off = $_POST['off'];
          $off = (int)$off;
          $all_drugs = $this->pharmcyModel->get_all_drugs($lim,$off,$filter);
        }
        else
        {
          $inc = $_POST['inc'];
          $inc = (int)$inc;
          $lim = 9;
          $off = 9+(9*$inc);
          $all_drugs = $this->pharmcyModel->get_all_drugs($lim,$off,$filter);
        }
        $all_orders_print = '';

        foreach ($all_drugs as $key)
        {
          $drug_id = $key->drug_id;
          $drug_name = $key->drug_name;
          $all_orders_print.='<tr>';
          $all_orders_print.='<td style="text-align:left;">'.$drug_id.'</td>
            <td>'.ucwords($drug_name).'</td><td>';
            
            $all_orders_print.='
                  <a href="'.URLROOT.'/pharmacies/edit_drug/'.$drug_id.'"><button style="width: 54px" type="button" class="btn btn-success btn-xs m-b-5">Edit</button></a>
                  <a href="'.URLROOT.'/pharmacies/drug/'.$drug_id.'"><button style="width: 54px;" type="button" class="btn btn-purple btn-xs m-b-5">View</button></a>
                                    
                  <button data-id="'.$drug_id.'" style="width: 54px" type="button" class="btn btn-warning btn-xs m-b-5">Remove</button>';
            $all_orders_print.='</td>

          </tr>';
        }
        echo $all_orders_print;
    }

    public function remove_drug()
    {
      $drug_id = $_POST['drug_id'];
      $success = $this->pharmcyModel->remove_drug_db($drug_id);
      if($success)
      {
        echo "Removed";
      }
      else
      {
        echo "Error";
      }
    }

    public function new_batch()
    {
      $drug_id = $_POST['drug_id'];
      $drug_identity = $_POST['drug_identity'];
      $drug_batch = $_POST['drug_batch'];
      $drug_exp_yr = $_POST['drug_exp_yr'];
      $drug_exp_mth = $_POST['drug_exp_mth'];
      $drug_stck = $_POST['drug_stck'];
      $dist = $_POST['dist'];
      $drug_cgst = $_POST['drug_cgst'];
      $drug_sgst = $_POST['drug_sgst'];
      $drug_buy = $_POST['drug_buy'];
      $drug_sell = $_POST['drug_sell'];
      $success = $this->pharmcyModel->save_batch_data($drug_id, $drug_identity, $drug_batch, $drug_exp_mth, $drug_exp_yr, $drug_stck, $dist, $drug_cgst, $drug_sgst, $drug_buy, $drug_sell);
      if($success)
      {
        echo "Batch Updated";
      }
      else
      {
        echo "Error";
      }
    }

    public function all_purchase_sort($check)
    {
      $data = [
        'sort' => $check
      ];
      $this->view('pharmacies/all_purchase', $data);
    }

    public function all_purchase1()
    {
      $filter = $_POST['filter'];
      $lim = $_POST['lim'];
        $lim = (int)$lim;
        if($lim==9)
        {
          $off = $_POST['off'];
          $off = (int)$off;
          $all_drugs = $this->pharmcyModel->get_all_purchase($lim,$off,$filter);
        }
        else
        {
          $inc = $_POST['inc'];
          $inc = (int)$inc;
          $lim = 9;
          $off = 9+(9*$inc);
          $all_drugs = $this->pharmcyModel->get_all_purchase($lim,$off,$filter);
        }
        $all_orders_print = '';

        foreach ($all_drugs as $key)
        {
          $drug_id = $key->drug_id;
          $drug_name = $this->pharmcyModel->get_drug_name($drug_id);
          foreach ($drug_name as $key2) {
            $drug_name1 = $key2->drug_name;
          }
          $all_orders_print.='<tr>';
          $all_orders_print.='<td style="text-align:left;">'.$drug_name1.'</td>
            <td>'.$key->stock_quant.'</td>
            <td>'.$key->stock_batch.'</td>
            <td>'.$key->stock_expiry.'</td>
            <td>'.$key->stock_date.'</td><td>';
            
            $all_orders_print.='
                  <a href="'.URLROOT.'/pharmacies/edit_drug/'.$drug_id.'"><button style="width: 54px" type="button" class="btn btn-success btn-xs m-b-5">Edit</button></a>
                  <a href="'.URLROOT.'/pharmacies/drug/'.$drug_id.'"><button style="width: 54px;" type="button" class="btn btn-purple btn-xs m-b-5">View</button></a>
                                    
                  <button data-id="'.$drug_id.'" style="width: 54px" type="button" class="btn btn-warning btn-xs m-b-5">Remove</button>';
            $all_orders_print.='</td>

          </tr>';
        }
        echo $all_orders_print;
    }

    public function all_orders1()
    {
      $lim = $_POST['lim'];
        $lim = (int)$lim;
        if($lim==9)
        {
          $off = $_POST['off'];
          $off = (int)$off;
          $all_invoice = $this->pharmcyModel->get_all_orders($lim,$off);
        }
        else
        {
          $inc = $_POST['inc'];
          $inc = (int)$inc;
          $lim = 9;
          $off = 9+(9*$inc);
          $all_invoice = $this->pharmcyModel->get_all_orders($lim,$off);
        }
        $all_orders_print = '';

        foreach ($all_invoice as $key)
        {
          $invoice_id = $key->invoice_id;
          $invoice_name = $key->invoice_name;
          $invoice_total = $key->invoice_total;
          $invoice_net = $key->invoice_net;
          $invoice_date_time = date('d-m-Y', strtotime($key->invoice_date_time));
          $cancelled = $key->cancelled;
          $status = $key->invoice_status;
          $all_orders_print.='<tr>
            <td>';
           $all_orders_print.=''.$invoice_id.'</td>
            <td style="text-align:left;">'.ucwords($invoice_name).'</td>
            <td>'.$invoice_total.'</td>
            <td>'.$invoice_date_time.'</td>
            <td style="text-align:left;padding-left:65px;">';
                if($status!=1){
                    $all_orders_print.='<a href="'.URLROOT.'/pharmacies/print_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-success btn-xs m-b-5">Print</button></a>
                  <a href="'.URLROOT.'/pharmacies/view_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-purple btn-xs m-b-5">View</button></a>&nbsp;';
                 } 

                  if($cancelled == 1)
                  {
                    $all_orders_print.='<button style="width: 84px" type="button" class="btn btn-danger btn-xs m-b-5">Cancelled</button>';
                  }
                  else
                  {   
                      if($status == 2)
                        {}else{
                      $all_orders_print.='<a href="'.URLROOT.'/pharmacies/edit_order/'.$invoice_id.'"><button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button></a>';
                    }
                      $all_orders_print.=' <button style="width: 54px" type="button" class="btn btn-danger btn-xs m-b-5" onclick="cancell_order('.$invoice_id.')">Cancel</button>';
                  }
            $all_orders_print.='</td>

          </tr>';
        }
        echo $all_orders_print;
    }

    public function all_orders_request()
    {
        $lim = $_POST['lim'];
        $lim = (int)$lim;
        if($lim==9)
        {
          $off = $_POST['off'];
          $off = (int)$off;
          $all_invoice = $this->pharmcyModel->get_all_orders_request($lim,$off);
        }
        else
        {
          $inc = $_POST['inc'];
          $inc = (int)$inc;
          $lim = 9;
          $off = 9+(9*$inc);
          $all_invoice = $this->pharmcyModel->get_all_orders_request($lim,$off);
        }
        $all_orders_print = '';

        foreach ($all_invoice as $key)
        {
          $invoice_id = $key->invoice_id;
          $invoice_name = $key->invoice_name;
          $invoice_total = $key->invoice_total;
          $invoice_net = $key->invoice_net;
          $invoice_date_time = $key->invoice_date_time;
          $cancelled = $key->cancelled;
          $all_orders_print.='<tr>
            <td>';
           $all_orders_print.=''.$invoice_id.'</td>
            <td>'.$invoice_name.'</td>
            <td>'.$invoice_total.'</td>
            <td>'.$invoice_net.'</td>
            <td>'.$invoice_date_time.'</td>
            <td>';
            
                $all_orders_print.='<a href="'.URLROOT.'/pharmacies/print_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-success btn-xs m-b-5">Print</button></a>
                  <a href="'.URLROOT.'/pharmacies/view_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-purple btn-xs m-b-5">View</button></a>
                  <br>';
                  if($cancelled == 1)
                  {
                    $all_orders_print.='<button style="width: 84px" type="button" class="btn btn-danger btn-xs m-b-5">Cancelled</button>';
                  }
                  else
                  {
                        $all_orders_print.='<a href="'.URLROOT.'/pharmacies/new_order/'.$invoice_id.'"><button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button></a>
                        <button data-id="'.$invoice_id.'" style="width: 54px" type="button" class="btn btn-warning btn-xs m-b-5">Cancel</button>';
                  }
            $all_orders_print.='</td>

          </tr>';
        }
        echo $all_orders_print;
    }

    public function view_invoice($id)
    {
        $logo = $this->receptionModel->get_logo_details();
        $invoice_details = $this->pharmcyModel->get_invoice_by_id($id);
        $data = [
              'logo' => $logo,
          'invoice' => $invoice_details
        ];
        $this->view('pharmacies/view_invoice', $data);
    }

    public function print_invoice($id)
    {
        $logo = $this->receptionModel->get_logo_details();
      $invoice_details = $this->pharmcyModel->get_invoice_by_id($id);
      $data = [
            'logo' => $logo,
        'invoice' => $invoice_details
      ];
      $this->view('pharmacies/print_invoice', $data);
    }

    public function get_manf_name($id)
    {
      $manf_name = $this->pharmcyModel->get_manf_name_db($id);
      return $manf_name;
    }

     public function get_dname_name($id)
    {
      $dname = $this->pharmcyModel->get_drugname_db($id);
      return $dname;
    }

    public function get_stock_detail($id)
    {
      $stock = $this->pharmcyModel->get_stock_details($id);
      return $stock;
    }

    public function cancel_invoice()
    {
      $drug_id = $_POST['ser_id'];
      $success = $this->pharmcyModel->cancel_invoice_db($drug_id);
      if($success)
      {
        echo "Invoice Cancelled";
      }
      else
      {
        echo "Error";
      }
    }

    public function get_drug_cost1()
    {
        $aamt = $_POST['amt'];
        $aamt = explode('(', $aamt);
        $aamt = explode(')', $aamt[1]);
        $aamt = (int)$aamt[0];
        $aamt = trim($aamt);
        $batch = '';
        $combo = '';
        $combo .= '<option>--Select--</option>';
        $batch_val = $this->pharmcyModel->get_batch_name($aamt);
        foreach ($batch_val as $key2)
        {
            $batch .= $key2->stock_batch;
            $batch .= "hyt";
        }
        $batch = explode('hyt', $batch);
        for ($i=0; $i < sizeof($batch)-1 ; $i++)
        { 
            $combo .= '<option>'.$batch[$i].'</option>';
        }
        echo $combo;
    }

    public function get_drug_costx()
    {
        $aamt = $_POST['amt'];
        $batch = '';
        $combo = '';
        $batch_val = $this->pharmcyModel->get_batch_name($aamt);
        foreach ($batch_val as $key2)
        {
            $batch .= $key2->stock_batch;
            $batch .= "hyt";
        }
        $batch = explode('hyt', $batch);
        $combo .= '<option>Select Batch</option>';
        for ($i=0; $i < sizeof($batch)-1 ; $i++)
        { 
            $combo .= '<option>'.$batch[$i].'</option>';
        }
        echo $combo;
    }

    public function get_drug_cost()
    {
        $aamt = $_POST['amt'];
        $aamt = explode('|', $aamt);
        $aamt = (int)$aamt[1];
        $aamt = trim($aamt);
        $batch = '';
        $combo = '';
        $batch_val = $this->pharmcyModel->get_batch_name($aamt);
        // foreach ($aamt_val as $key)
        // {
        //     $cost = $key->drug_sell_cost;
        // }

        foreach ($batch_val as $key2)
        {
            $batch .= $key2->stock_batch;
            $batch .= "hyt";
        }
        // $combo = $cost;
        // $combo .= "|";
        // $combo .= $batch;
        $batch = explode('hyt', $batch);
        $combo .= '<option>Select Batch</option>';
        for ($i=0; $i < sizeof($batch)-1 ; $i++)
        { 
            $combo .= '<option>'.$batch[$i].'</option>';
        }
        echo $combo;
    }

    public function get_drug_cost2()
    {
        $aamt = $_POST['selected'];
        $aamt_val = $this->pharmcyModel->get_cost($aamt);
        foreach ($aamt_val as $key)
        {
            $cost = $key->drug_sell_cost;
            $avl = $key->stock_quant;
        }
        echo $avl.'|'.$cost;
    }

    public function get_drug_quant()
    {
        $aamt = $_POST['selected'];
        $val = $this->pharmcyModel->get_cost($aamt);
        foreach ($val as $key)
        {
            $qnt = $key->stock_quant;
        }
        echo $qnt;
    }

    public function save_invoice()
    {
        $service_id = $_POST['service_id'];
        $bat = $_POST['bat'];
        $bat = implode(',', $bat);
        $invoice_bill = $_POST['invoice_bill'];
        $grand_total = $_POST['grand_total'];
        $patient_name = $_POST['patient_name'];
        $doctor_name = $_POST['doctor_name'];
        $ipopid = $_POST['ipopid'];
        $pay_mode = $_POST['pay_mode'];
        $amount_paid = $_POST['amount_paid'];
        $discount = $_POST['discount'];

        $success = $this->pharmcyModel->save_invoice_db($service_id, $bat, $invoice_bill, $grand_total, $patient_name, $doctor_name, $ipopid, $pay_mode, $amount_paid, $discount);
        if($success)
            echo "Invoice Updated";
        else
            echo "Error";
    }

      public function save_invoice_for_edit()
    {
        $id = $_POST['idd'];
        $service_id = $_POST['service_id'];
        $bat = $_POST['bat'];
        $bat = implode(',', $bat);
        $invoice_bill = $_POST['invoice_bill'];
        $grand_total = $_POST['grand_total'];
        $patient_name = $_POST['patient_name'];
        $doctor_name = $_POST['doctor_name'];
        $ipopid = $_POST['ipopid'];
        $pay_mode = $_POST['pay_mode'];
        $amount_paid = $_POST['amount_paid'];
        $discount = $_POST['discount'];

        $success = $this->pharmcyModel->save_invoice_db_edit($service_id, $bat, $invoice_bill, $grand_total, $patient_name, $doctor_name, $ipopid, $pay_mode, $amount_paid, $discount,$id);
        if($success)
            echo "Invoice Updated";
        else
            echo "Error";
    }

    public function cus_rep()
    {
        $to = $_POST['to'];
        $from = $_POST['from'];
        $data = [
        'from' => $from,
        'to' => $to
        ];
        $this->view('pharmacies/get_report', $data);
    }

    public function today_report()
    {
        $today_date = date('Y-m-d');
        $data = [
        'date_filter' => $today_date
        ];
        $this->view('pharmacies/get_report', $data);
    }

    public function monthly_report()
    {
        $month_date = date('Y-m-01');
        $today = date('Y-m-d');
        $data = [
        'month_date' => $month_date,
        'today' => $today
        ];
        $this->view('pharmacies/get_report', $data);
    }

    public function yearly_report()
    {
        $year_date = date('Y-01-01');
        $today =date('Y-m-d');
        $data = [
        'year_date' => $year_date,
        'today' => $today
        ];  
        $this->view('pharmacies/get_report', $data);
    }  

    public function patient_report_year()
    {
        $year_date = $_POST['year_date'];
        $today = $_POST['today'];
        $lim = $_POST['lim'];
        $lim = (int)$lim;
        if($lim==9)
        {
          $off = $_POST['off'];
          $off = (int)$off;
          $all_invoice = $this->pharmcyModel->get_month_report($year_date,$today,$lim,$off);
        }
        else
        {
          $inc = $_POST['inc'];
          $inc = (int)$inc;
          $lim = 9;
          $off = 9+(9*$inc);
          $all_invoice = $this->pharmcyModel->get_month_report($year_date,$today,$lim,$off);
        }
        $all_orders_print = '';

        foreach ($all_invoice as $key)
        {
          $invoice_id = $key->invoice_id;
          $invoice_name = $key->invoice_name;
          $invoice_total = $key->invoice_total;
          $invoice_net = $key->invoice_net;
          $invoice_date_time = $key->invoice_date_time;
          $cancelled = $key->cancelled;
          $all_orders_print.='<tr>
            <td>';
           $all_orders_print.=''.$invoice_id.'</td>
            <td>'.$invoice_name.'</td>
            <td>'.$invoice_total.'</td>
            <td>'.$invoice_date_time.'</td>
            <td>';
            
                $all_orders_print.='<a href="'.URLROOT.'/pharmacies/print_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-success btn-xs m-b-5">Print</button></a>
                  <a href="'.URLROOT.'/pharmacies/view_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-purple btn-xs m-b-5">View</button></a>
                  <br>';
                  if($cancelled == 1)
                  {
                    $all_orders_print.='<button style="width: 84px" type="button" class="btn btn-danger btn-xs m-b-5">Cancelled</button>';
                  }
                  else
                  {
                        $all_orders_print.='<a href="'.URLROOT.'/pharmacies/edit_order/'.$invoice_id.'"><button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button></a>
                        <button data-id="'.$invoice_id.'" style="width: 54px" type="button" class="btn btn-warning btn-xs m-b-5">Cancel</button>';
                  }
            $all_orders_print.='</td>

          </tr>';
        }
        echo $all_orders_print;
    } 

    public function patient_report_month()
    {
        $month_date = $_POST['month_date'];
        $today = $_POST['today'];
        $lim = $_POST['lim'];
        $lim = (int)$lim;
        if($lim==9)
        {
          $off = $_POST['off'];
          $off = (int)$off;
          $all_invoice = $this->pharmcyModel->get_month_report($month_date,$today,$lim,$off);
        }
        else
        {
          $inc = $_POST['inc'];
          $inc = (int)$inc;
          $lim = 9;
          $off = 9+(9*$inc);
          $all_invoice = $this->pharmcyModel->get_month_report($month_date,$today,$lim,$off);
        }
        $all_orders_print = '';

        foreach ($all_invoice as $key)
        {
          $invoice_id = $key->invoice_id;
          $invoice_name = $key->invoice_name;
          $invoice_total = $key->invoice_total;
          $invoice_net = $key->invoice_net;
          $invoice_date_time = $key->invoice_date_time;
          $cancelled = $key->cancelled;
          $all_orders_print.='<tr>
            <td>';
           $all_orders_print.=''.$invoice_id.'</td>
            <td>'.$invoice_name.'</td>
            <td>'.$invoice_total.'</td>
            <td>'.$invoice_date_time.'</td>
            <td>';
            
                $all_orders_print.='<a href="'.URLROOT.'/pharmacies/print_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-success btn-xs m-b-5">Print</button></a>
                  <a href="'.URLROOT.'/pharmacies/view_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-purple btn-xs m-b-5">View</button></a>
                  <br>';
                  if($cancelled == 1)
                  {
                    $all_orders_print.='<button style="width: 84px" type="button" class="btn btn-danger btn-xs m-b-5">Cancelled</button>';
                  }
                  else
                  {
                        $all_orders_print.='<a href="'.URLROOT.'/pharmacies/edit_order/'.$invoice_id.'"><button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button></a>
                        <button data-id="'.$invoice_id.'" style="width: 54px" type="button" class="btn btn-warning btn-xs m-b-5">Cancel</button>';
                  }
            $all_orders_print.='</td>

          </tr>';
        }
        echo $all_orders_print;
    }

    public function patient_report()
    {
        $dat = $_POST['date'];
        $lim = $_POST['lim'];
        $lim = (int)$lim;
        if($lim==9)
        {
          $off = $_POST['off'];
          $off = (int)$off;
          $all_invoice = $this->pharmcyModel->get_today_report($dat,$lim,$off);
        }
        else
        {
          $inc = $_POST['inc'];
          $inc = (int)$inc;
          $lim = 9;
          $off = 9+(9*$inc);
          $all_invoice = $this->pharmcyModel->get_today_report($dat,$lim,$off);
        }
        $all_orders_print = '';

        foreach ($all_invoice as $key)
        {
          $invoice_id = $key->invoice_id;
          $invoice_name = $key->invoice_name;
          $invoice_total = $key->invoice_total;
          $invoice_net = $key->invoice_net;
          $invoice_date_time = $key->invoice_date_time;
          $cancelled = $key->cancelled;
          $all_orders_print.='<tr>
            <td>';
           $all_orders_print.=''.$invoice_id.'</td>
            <td>'.$invoice_name.'</td>
            <td>'.$invoice_total.'</td>
            <td>'.$invoice_date_time.'</td>
            <td>';
            
                $all_orders_print.='<a href="'.URLROOT.'/pharmacies/print_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-success btn-xs m-b-5">Print</button></a>
                  <a href="'.URLROOT.'/pharmacies/view_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-purple btn-xs m-b-5">View</button></a>
                  <br>';
                  if($cancelled == 1)
                  {
                    $all_orders_print.='<button style="width: 84px" type="button" class="btn btn-danger btn-xs m-b-5">Cancelled</button>';
                  }
                  else
                  {
                        $all_orders_print.='<a href="'.URLROOT.'/pharmacies/edit_order/'.$invoice_id.'"><button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button></a>
                        <button data-id="'.$invoice_id.'" style="width: 54px" type="button" class="btn btn-warning btn-xs m-b-5">Cancel</button>';
                  }
            $all_orders_print.='</td>

          </tr>';
        }
        echo $all_orders_print;        
    } 

    public function custom_date_rep()
    {
        $to = $_POST['to'];
        $from = $_POST['from'];
        $lim = $_POST['lim'];
        $lim = (int)$lim;
        if($lim==9)
        {
          $off = $_POST['off'];
          $off = (int)$off;
          $all_invoice = $this->pharmcyModel->get_month_report($to,$from,$lim,$off);
        }
        else
        {
          $inc = $_POST['inc'];
          $inc = (int)$inc;
          $lim = 9;
          $off = 9+(9*$inc);
          $all_invoice = $this->pharmcyModel->get_month_report($to,$from,$lim,$off);
        }
        $all_orders_print = '';

        foreach ($all_invoice as $key)
        {
          $invoice_id = $key->invoice_id;
          $invoice_name = $key->invoice_name;
          $invoice_total = $key->invoice_total;
          $invoice_net = $key->invoice_net;
          $invoice_date_time = $key->invoice_date_time;
          $cancelled = $key->cancelled;
          $all_orders_print.='<tr>
            <td>';
           $all_orders_print.=''.$invoice_id.'</td>
            <td>'.$invoice_name.'</td>
            <td>'.$invoice_total.'</td>
            <td>'.$invoice_date_time.'</td>
            <td>';
            
                $all_orders_print.='<a href="'.URLROOT.'/pharmacies/print_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-success btn-xs m-b-5">Print</button></a>
                  <a href="'.URLROOT.'/pharmacies/view_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-purple btn-xs m-b-5">View</button></a>
                  <br>';
                  if($cancelled == 1)
                  {
                    $all_orders_print.='<button style="width: 84px" type="button" class="btn btn-danger btn-xs m-b-5">Cancelled</button>';
                  }
                  else
                  {
                        $all_orders_print.='<a href="'.URLROOT.'/pharmacies/edit_order/'.$invoice_id.'"><button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button></a>
                        <button data-id="'.$invoice_id.'" style="width: 54px" type="button" class="btn btn-warning btn-xs m-b-5">Cancel</button>';
                  }
            $all_orders_print.='</td>

          </tr>';
        }
        echo $all_orders_print;        
    } 


//Me 
public function exp_stock()
{

  $this->view('pharmacies/exp_stock');
}

public function all_stock()
{

  $this->view('pharmacies/all_stock');
}

 public function exp_stock1()
    {
      $lim = $_POST['lim'];
        $lim = (int)$lim;
        if($lim==9)
        {
          $off = $_POST['off'];
          $off = (int)$off;
          $all_invoice = $this->pharmcyModel->get_exp_all($lim,$off);
        }
        else
        {
          $inc = $_POST['inc'];
          $inc = (int)$inc;
          $lim = 9;
          $off = 9+(9*$inc);
          $all_invoice = $this->pharmcyModel->get_exp_all($lim,$off);
        }
        $all_orders_print = '';

        foreach ($all_invoice as $key)
        {
          $stock_id = $key->stock_id;
          $drug_name = $key->drug_name;
          $gen_name = $key->gen_name;
          $drug_dossage = $key->drug_dossage;
          $stock_quant = $key->stock_quant;
          $stock_batch = $key->stock_batch;
          $stock_total = $key->stock_total;
          $stock_expiry = $key->stock_expiry;
        
         
           $all_orders_print.='<tr><td>'.$stock_id.'</td>
            <td>'.$drug_name.'</td>
            <td>'.$gen_name.'</td>
            <td>'.$drug_dossage.'</td>
            <td>'.$stock_quant.'</td>
            <td>'.$stock_batch.'</td>
            <td>'.$stock_total.'</td>
            <td>'.$stock_expiry.'</td>
            </tr>';
        }
        echo $all_orders_print;
    }


    public function all_stock1()
    {
      $lim = $_POST['lim'];
        $lim = (int)$lim;
        if($lim==9)
        {
          $off = $_POST['off'];
          $off = (int)$off;
          $all_invoice = $this->pharmcyModel->get_stock_all($lim,$off);
        }
        else
        {
          $inc = $_POST['inc'];
          $inc = (int)$inc;
          $lim = 9;
          $off = 9+(9*$inc);
          $all_invoice = $this->pharmcyModel->get_stock_all($lim,$off);
        }
        $all_orders_print = '';

        foreach ($all_invoice as $key)
        {
          $stock_id = $key->stock_id;
          $drug_name = $key->drug_name;
          $stock_quant = $key->stock_quant;
          $stock_batch = $key->stock_batch;
          $stock_expiry = $key->stock_expiry;
          $stock_distributor=$key->stock_distributor;
          $drug_cgst=$key->drug_cgst;
          $drug_sgst=$key->drug_sgst;
          $drug_taxable_amount=$key->drug_taxable_amount;
          $drug_buy_cost=$key->drug_buy_cost;
          $drug_sell_cost=$key->drug_sell_cost;
          $stock_total=$key->stock_total;
          $stock_date=$key->stock_date;

          $all_orders_print.='<tr><td>'.$stock_id.'</td>
            <td>'.$drug_name.'</td>
            <td>'.$stock_quant.'</td>
            <td>'.$stock_batch.'</td>
            <td>'.$stock_expiry.'</td>
            <td>'.$stock_distributor.'</td>
            <td>'.$drug_cgst.'</td>
            <td>'.$drug_sgst.'</td>
            <td>'.$drug_taxable_amount.'</td>
            <td>'.$drug_buy_cost.'</td>
            <td>'.$drug_sell_cost.'</td>
            <td>'.$stock_total.'</td>
            <td>'.$stock_date.'</td>
           
            </tr>';

     
        }
        echo $all_orders_print;
    }


     public function update_password()
      {
          $id = $_POST['id'];
          $pass = $_POST['pass'];
          $cpass = $_POST['pass'];
          //$cpass = $_POST['cpass'];
          if($cpass == $pass)
          {
              $cpass = password_hash($cpass, PASSWORD_DEFAULT);
              $f_name=$_FILES['files']['name'];
         
              $f_tmp=$_FILES['files']['tmp_name'];
              $size=$_FILES['files']['size'];
              $f_extension=explode('.', $f_name);
              $f_extension=strtolower(end($f_extension));
              $f_newfile=uniqid().'.'.$f_extension;
              $store="user_profile_pictures/".$f_newfile;
              move_uploaded_file($f_tmp, $store);
              $files_array = $f_newfile;
              $store="user_profile_pictures/";

              $success = $this->pharmcyModel->update_password_db($cpass, $id, $files_array);
              if($success)
                redirect('pharmacies/success_settings');
              else
                redirect('pharmacies/upd_err_settings');           
          }
          else
          {
              redirect('pharmacies/error_settings');
          }

      }
       public function settings()
      {
          $user_id = $_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no'];
          $mem_data = $this->pharmcyModel->get_mem_data($user_id);
          foreach ($mem_data as $key)
          {
              $_SESSION['user_photo_medhike_87_71_18_08_80_none_med_hi_ke_no'] = $key->mem_photo;
          }
          $data = [
            'mem_data' => $mem_data 
          ];
          $this->view('pharmacies/settings', $data);
      }

public function getBatches($id)
      {
          $row = $this->pharmcyModel->get_batch_using_id($id);
          return $row;
      }

      public function getPrice()
      {
          $drugId = $_POST['b'];
          $batchName = $_POST['d'];
          echo $price = $this->pharmcyModel->getPriceDb($drugId, $batchName);
      }

        public function search_by_inv_id()
      {
        $inv_id = $_POST['inv'];
        $all_invoice = $this->pharmcyModel->get_search_orders($inv_id);
        $all_orders_print = '';

         foreach ($all_invoice as $key)
        {
          $invoice_id = $key->invoice_id;
          $invoice_name = $key->invoice_name;
          $invoice_total = $key->invoice_total;
          $invoice_net = $key->invoice_net;
          $invoice_date_time = date('d-m-Y', strtotime($key->invoice_date_time));
          $cancelled = $key->cancelled;
          $status = $key->invoice_status;
          $all_orders_print.='<tr>
            <td>';
           $all_orders_print.=''.$invoice_id.'</td>
            <td style="text-align:left;">'.ucwords($invoice_name).'</td>
            <td>'.$invoice_total.'</td>
            <td>'.$invoice_date_time.'</td>
            <td style="text-align:left;padding-left:65px;">';
                if($status!=1){
                    $all_orders_print.='<a href="'.URLROOT.'/pharmacies/print_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-success btn-xs m-b-5">Print</button></a>
                  <a href="'.URLROOT.'/pharmacies/view_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-purple btn-xs m-b-5">View</button></a>&nbsp;';
                 } 

                  if($cancelled == 1)
                  {
                    $all_orders_print.='<button style="width: 84px" type="button" class="btn btn-danger btn-xs m-b-5">Cancelled</button>';
                  }
                  else
                  {   
                      if($status == 2)
                        {}else{
                      $all_orders_print.='<a href="'.URLROOT.'/pharmacies/edit_order/'.$invoice_id.'"><button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button></a>';
                    }
                      $all_orders_print.=' <button style="width: 54px" type="button" class="btn btn-danger btn-xs m-b-5" onclick="cancell_order('.$invoice_id.')">Cancel</button>';
                  }
            $all_orders_print.='</td>

          </tr>';
        }
        echo $all_orders_print;
      }

       public function search_by_name_value()
      {
        $patient_name = $_POST['patient_name'];
        $all_invoice= $this->pharmcyModel->get_patient_orders($patient_name);
        $all_orders_print = '';

        foreach ($all_invoice as $key)
        {
          $invoice_id = $key->invoice_id;
          $invoice_name = $key->invoice_name;
          $invoice_total = $key->invoice_total;
          $invoice_net = $key->invoice_net;
          $invoice_date_time = date('d-m-Y', strtotime($key->invoice_date_time));
          $cancelled = $key->cancelled;
          $status = $key->invoice_status;
          $all_orders_print.='<tr>
            <td>';
           $all_orders_print.=''.$invoice_id.'</td>
            <td style="text-align:left;">'.ucwords($invoice_name).'</td>
            <td>'.$invoice_total.'</td>
            <td>'.$invoice_date_time.'</td>
            <td style="text-align:left;padding-left:65px;">';
                if($status!=1){
                    $all_orders_print.='<a href="'.URLROOT.'/pharmacies/print_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-success btn-xs m-b-5">Print</button></a>
                  <a href="'.URLROOT.'/pharmacies/view_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-purple btn-xs m-b-5">View</button></a>&nbsp;';
                 } 

                  if($cancelled == 1)
                  {
                    $all_orders_print.='<button style="width: 84px" type="button" class="btn btn-danger btn-xs m-b-5">Cancelled</button>';
                  }
                  else
                  {   
                      if($status == 2)
                        {}else{
                      $all_orders_print.='<a href="'.URLROOT.'/pharmacies/edit_order/'.$invoice_id.'"><button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button></a>';
                    }
                      $all_orders_print.=' <button style="width: 54px" type="button" class="btn btn-danger btn-xs m-b-5" onclick="cancell_order('.$invoice_id.')">Cancel</button>';
                  }
            $all_orders_print.='</td>

          </tr>';
        }
        echo $all_orders_print;
      }

      public function prescription_search_by_id()
      {
          $visit_id = $_POST['visit_id'];
          $all_visits = $this->pharmcyModel->prescription_search_by_id_db($visit_id);
          $all_orders_print = '';
          
          
          foreach ($all_visits as $key)
          { 
            $visit_all_ipdid = $key->ipd_patient_id;
            $visit_id = $key->ipd_admit_id;
            $pat = $this->pharmcyModel->get_patient_by_id($visit_all_ipdid);
            foreach ($pat as $key1)
            { echo $key1;
              $patient_name = $key1->patient_name;
            }
            $doc = $this->pharmcyModel->doctor_name($key->ipd_doctor_id);

            $all_orders_print.='<tr>
                                  <td>'.$visit_id.'</td> 
                                  <td>Dr. '.ucwords($doc).'</td>                               
                                  <td>'.ucwords($patient_name).'</td>
                                  <td>
                                      <a href="'.URLROOT.'/doctors/print_prescription_ipd/'.$visit_id.'"><button style="width: 100px" type="button" class="btn btn-info btn-xs m-b-5"> Print </button></a><br>
                                  </td>
                              </tr>';
          }
          echo $all_orders_print;
      }

      public function all_prescription_admit()
      {
          $lim = $_POST['lim'];
          $lim = (int)$lim;
          if($lim==9)
          {
            $off = $_POST['off'];
            $off = (int)$off;
            $all_visits = $this->pharmcyModel->get_all_prescription_admit($lim,$off);
          }
          else
          {
            $inc = $_POST['inc'];
            $inc = (int)$inc;
            $lim = 9;
            $off = 9+(9*$inc);
            $all_visits = $this->pharmcyModel->get_all_prescription_admit($lim,$off);
          }
          $all_orders_print = '';

          foreach ($all_visits as $key)
          { 
            $visit_all_ipdid=$key->ipd_patient_id;
            $visit_id = $key->ipd_admit_id;
			if($key->ipd_patient_id)
			{
				$pat = $this->pharmcyModel->get_patient_by_id($key->ipd_patient_id);
			}
			else
			{
				$pat = $this->pharmcyModel->get_patient_by_id($key->opd_patient_id);
			}
            foreach ($pat as $key1)
            {
            	$patient_name = $key1->patient_name;
            }
            $doc = $this->pharmcyModel->doctor_name($key->ipd_doctor_id);
            $all_orders_print.='<tr>
                                  <td>'.$visit_id.'</td> 
                                  <td>Dr. '.ucwords($doc).'</td>                               
                                  <td>'.ucwords($patient_name).'</td>
                                  <td>
                                      <a href="'.URLROOT.'/doctors/print_prescription_ipd/'.$visit_id.'"><button style="width: 100px" type="button" class="btn btn-info btn-xs m-b-5"> Print </button></a><br>
                                  </td>
                              </tr>';
          }
          echo $all_orders_print;
      }

//Me End#############################################################################

          public function new_stock()
  {
    $this->view('pharmacies1/new_stock');
  }

   public function add_item()
  {
    $this->view('pharmacies1/add_item');
  }

  public function add_items()
  {

      $item_name=$_POST['item_name'];
      $batch_name=$_POST['batch_name'];
      $qty=$_POST['Qty'];
      $unit=$_POST['unit'];
      $total=$_POST['total'];
      $result = $this->pharmcyModel->add_items_to_model($item_name,$batch_name,$qty,$unit,$total);
     if($result)
     {
        redirect('pharmacies1/all_items');
     }

  }
  public function add_company()
  {

    $this->view('pharmacies1/add_company');

  }

  public function add_company_details()
  {

      $name = $_POST['name'];
      $ph_no = $_POST['ph_no'];
      $email = $_POST['email'];
      $address = $_POST['address'];
      $result = $this->pharmcyModel->add_company_details_to_model($name,$ph_no,$email,$address);
     if($result)
     {
        redirect('pharmacies1/index');
     }

  }

   public function all_items()
  {
    $result = $this->pharmcyModel->get_all_items();
    $data = [ 'result' => $result ];

    $this->view('pharmacies1/all_items', $data);
  }

  public function del_item($id)
  {
    $this->pharmcyModel->delete_item($id);
    redirect('pharmacies1/all_items');
  }

   public function all_company()
  {
    $result = $this->pharmcyModel->get_all_companies();
    $data = [ 'result' => $result ];
    $this->view('pharmacies1/all_company', $data);
  }

  public function del_company($id)
  {
    $this->pharmcyModel->delete_companys($id);
    redirect('pharmacies1/all_company');
  }



      public function get_auto_item_name()
    {
      $cname = $_POST['query'];
      $cust_list = $this->pharmcyModel->auto_drug_namez($cname);
      $output3 = '';
      $output3 = '<ul class="list-unstyled">';
      foreach ($cust_list as $key)
      {
      $output3 .='<li class="cc">'.ucwords($key->drug_name).''."(".''.$key->drug_id.''.") ".'</li>';
      }
      $output3.='</ul>';
      echo $output3;
    }

 public function add_stock_all()
  {

  $z=array();
  $i=0;
  foreach ($_POST['product'] as $key) 
  {
        $a = explode("(", $key);
         $b = strrev($a[1]);
         $c = explode(")", $b);
         $d = strrev($c[1]);
         $z[$i] =$d;
         $i++;
  }
      $product = implode("|",$z);
      //$product =implode("|", $_POST['product']);
      $bat =implode("|", $_POST['bat']);
      $total_stock =implode("|", $_POST['total_stock']);
      $stock_rec =implode("|", $_POST['stock_rec']);
      $stock_rem =implode("|", $_POST['stock_rem']);
      $buy_price =implode("|", $_POST['buy_price']);
      $sell_price =implode("|", $_POST['sell_price']);
      $due_date =implode("|", $_POST['due_date']);
      $customer_val = $_POST['customer_val'];



      $result = $this->pharmcyModel->add_stock_all_model($product,$bat,$total_stock,$stock_rec, $stock_rem, $buy_price, $sell_price,  $due_date, $customer_val);
     
     if($result)
     {
        redirect('pharmacies1/index');
     }
  } 

  public function all_stock_s()
{
  $result = $this->pharmcyModel->get_all_stock_for_display();
  $data =[ 'result' => $result ];
  $this->view('pharmacies1/all_stock',$data);
}


 public function single_stock()
{
  $result = $this->pharmcyModel->get_all_stock_for_display();
  $result_item_table = $this->pharmcyModel->get_all_stock_for_display2();

 // $to=0;
 // $re=0;
 // $r=0;
 //  foreach ($result as $key) {
      
 //       $a = explode("|", $key->item_name_id);
 //       $x = array_search(20, $a);

 //       $b = explode("|", $key->total_stock_quant);
 //       $c = array_values($b);
 //       $total = $c[$x]."<br>";

 //       $d = explode("|", $key->stock_qty_received);
 //       $e = array_values($d);
 //       $rec =  $e[$x]."<br>";

 //       $f = explode("|", $key->stock_qty_rem);
 //       $g = array_values($f);
 //       $rem =  $g[$x]."<br>";

 //       (int)$to = (int)$to + (int)$total;
 //       (int)$re = (int)$re + (int)$rec;
 //       (int)$r = (int)$r + (int)$rem;
 //  }
 
  $data =[ 'result' => $result,
            'items' => $result_item_table ];
  $this->view('pharmacies1/single_stock',$data);
}


  public function get_auto_doc_name()
      {
          $cname = $_POST['query3'];
          $cust_list = $this->pharmcyModel->get_doctors_list1($cname);
          $output3 = '';
          $output3 = '<ul class="list-unstyled">';
          foreach ($cust_list as $key)
          {
            $output3 .='<li class="ff"><p>'.$key->s_name.''." | ".''.$key->s_id.'</p></li>';
          }
          $output3.='</ul>';
          echo $output3;
      }

  public function get_item_autocomplete2()
    {
      $cname = $_POST['query'];
    $cust_list = $this->pharmcyModel->auto_item_name2($cname);
    $output3 = '';
    $output3 = '<ul class="list-unstyled">';
    foreach ($cust_list as $key)
    {
    $output3 .='<li class="ccc">'.$key->item_name.''." | ".''.$key->id.'</li>';
    }
    $output3.='</ul>';
    echo $output3;
    }

  
//m

    public function save_invoice_s()
    {
		$data = [
			'product' => implode('|',$_POST['product']),
			'qty' => implode('|',$_POST['qty']),
			'bat' => implode('|',$_POST['bat']),
			'price' => implode('|',$_POST['price']),
			'due_date' => implode('|',$_POST['due_date']),
			'total' => implode('|',$_POST['total']),
			'sub_total' => $_POST['sub_total'],
			'mode_of_delivery' => $_POST['customer_val'],
			'total_item' => $_POST['total_item'],
			'discount' => $_POST['discount_val'],
			'extra_tax' => $_POST['extra_tax'],
			'grand_total' => $_POST['total_amount'],
			'payment_terms' => $_POST['payment_terms'],
			'expected_date' => $_POST['expected_date'],
			'company_name' => $_POST['comany_name'],
			'comapny_details' => $_POST['comapny_details'],
			'delivery_address' => $_POST['delivery_address']
		];
        if($this->pharmcyModel->save_invoice_db_s($data))
		{
        	redirect('pharmacies/print_order');
        }
    }

    public function add_purchased_stock($id){

    $data = [
      'batch' => $_POST['batch'],
     'deliverd' => $_POST['deliverd'],
     'total' => $_POST['total'],
     'expiry' => $_POST['expiry']

   ];

   if($this->pharmcyModel->add_purchased($id,$data)){

    redirect('pharmacies/all_orders_s');
   }

    }

    public function update_stock_db($id){

      $data = [
     'recived' => $_POST['recived'],
     'remain' => $_POST['remain'],
     'id' => $_POST['id']
   ];

   if($this->pharmcyModel->update_purchased($id,$data)){

    redirect('pharmacies/all_orders_s');
   }
    }

    public function print_order(){

      $post = $this->pharmcyModel->get_data();

      $data = [

        'posts' =>$post
      ];

      $this->view('pharmacies1/print_order',$data);
    }

    public function view_listed_invoices($id){
       $post = $this->pharmcyModel->get_new_list($id);
      $data = [

        'posts' =>$post
      ];

      $this->view('pharmacies1/print_order',$data);

    }
    
    public function all_orders_s()
    {

      $post = $this->pharmcyModel->get_invice_orders();
      $data = [
        'sup' => $this->pharmcyModel->getAllSup1(),
        'posts' =>$post

      ];
      $this->view('pharmacies1/all_orders',$data);
    }

    public function get_stock_orders($id){

      $this->pharmcyModel->get_stock_orders($id);

    }

    public function accepted_order($invoice_id){

      if ($this->pharmcyModel->update_order($invoice_id)) {

      redirect('pharmacies/all_orders_s');
      }

    }
    public function reject_order($invoice_id){

      if ($this->pharmcyModel->reject_order($invoice_id)) {

      redirect('pharmacies/all_orders_s');
      }

    }
     public function deliverd_update($invoice_id){

      if ($this->pharmcyModel->deliverd_update($invoice_id)) {

      redirect('pharmacies/all_orders_s');
      }

    }
    public function new_order_s()
    {
        $company_address = $this->pharmcyModel->getCompanyAddress();
        $data = [
          'add' => $company_address->client_address,
        ];
        $this->view('pharmacies1/new_order', $data);
    }
 public function get_drug_autocomplete1_s()
    {
      $cname = $_POST['query'];
      $id = $_POST['button_idq'];
    $cust_list = $this->pharmcyModel->auto_drug_namez($cname);
    $output3 = '';
    $output3 = '<ul class="list-unstyled">';
    foreach ($cust_list as $key)
    {
      $output3 .='<li id="new'.$key->drug_id.'" class="cccc" value="'.ucwords($key->drug_name).'('.$key->drug_id.')" onclick="mydat_val('.$id.','.$key->drug_id.','.$key->drug_id.')">'.$key->drug_name.''."(".''.$key->drug_id.''.")".'</li>';
    }
    $output3.='</ul>';
    echo $output3;
    }

    public function addSuppliers()
    {
        $this->view('pharmacies/addSuppliers');
    }

    public function addSupplier()
    {
        $data = [
          'name' => $_POST['name'],
          'phone' => $_POST['phone'],
          'email' => $_POST['email'],
          'gstin' => $_POST['gstin'],
          'address' => $_POST['address']
        ];
        if($this->pharmcyModel->saveSupplier($data))
        {
          redirect('pharmacies/addSuppliers');
        }
    }

    public function allSupliers()
    {
        $data = [
          'sup' => $this->pharmcyModel->getAllSup1(),
        ];
        $this->view('pharmacies/allSupliers', $data);
    }

    public function allSup()
    {
      $lim = $_POST['lim'];
        $lim = (int)$lim;
        if($lim==9)
        {
          $off = $_POST['off'];
          $off = (int)$off;
          $all_invoice = $this->pharmcyModel->getAllSup($lim,$off);
        }
        else
        {
          $inc = $_POST['inc'];
          $inc = (int)$inc;
          $lim = 9;
          $off = 9+(9*$inc);
          $all_invoice = $this->pharmcyModel->getAllSup($lim,$off);
        }
        $all_orders_print = '';

        foreach ($all_invoice as $key)
        {
          $all_orders_print.='<tr>
            <td style="text-align:left;"><a href="#" data-toggle="modal" data-target="#'.$key->s_id.'">'.ucwords($key->s_name).'</td></a>
            <td style="text-align:left;">'.$key->s_phone.'</td>
            <td style="text-align:left;">'.$key->s_email.'</td>
            <td style="text-align:left;">'.$key->s_gstin.'</td>
            <td style="text-align:left;">'.$key->s_address.'</td>
            </tr>';
        }
        echo $all_orders_print;
    }

    public function saveEditOrderDetail($invoiceId)
    {
        $id = $_POST['id'];
        $product = $_POST['product'];
        $bat = $_POST['bat'];
        $qty = $_POST['qty'];
        $price = $_POST['price'];
        $total = $_POST['total'];

        if(isset($_POST['add']))
        {
            if($this->pharmcyModel->addSaveTheEditOrder($id, $product, $bat, $qty, $price, $total))
            {
                redirect('pharmacies/edit_order1/'.$invoiceId.'');
            }
        }

        if(isset($_POST['edit']))
        {
            if($this->pharmcyModel->editSaveTheEditOrder($id, $product, $bat, $qty, $price, $total, $_POST['edit']))
            {
                redirect('pharmacies/edit_order1/'.$invoiceId.'');
            }
        }

        if(isset($_POST['remove']))
        {
            if($this->pharmcyModel->deleteSaveTheEditOrder($id, $product, $bat, $qty, $price, $total, $_POST['remove']))
            {
                redirect('pharmacies/edit_order1/'.$invoiceId.'');
            }
        }

        if(isset($_POST['default']))
        {
            if($this->pharmcyModel->defaultSaveTheEditOrder($id, $product, $bat, $qty, $price, $total))
            {
                $_SESSION['forCheckEditComplete'] = 1;
                redirect('pharmacies/edit_order1/'.$invoiceId.'');
            }
        }
    }


    public function editInvoiceSubmit()
    {
        $drugName = $_POST['drugName'];
        $drugId = array();
        for ($w=0; $w < sizeof($drugName); $w++)
        { 
            $drugName0 = explode('(', $drugName[$w]);
            $drugName1 = explode(')', $drugName0[1]);
            array_push($drugId, $drugName1[0]);
        }
        $qty = $_POST['qty'];
        $bat = $_POST['bat'];
        $patientName = $_POST['patientName'];
        $doctorName = $_POST['doctorName'];
        $ipOp = $_POST['ipOp'];
        $grandTotal = $_POST['grandTotal'];
        $payment = $_POST['payment'];
        $amountPaid = $_POST['amountPaid'];
		$invoiceId = $_POST['invoiceId'];
		
		

        $invoiceDetails = $this->pharmcyModel->get_invoice_by_id($invoiceId);
        foreach ($invoiceDetails as $key)
        {
            $invoiceItems = explode(',', $key->invoice_items);
            unset($invoiceItems[sizeof($invoiceItems)-1]);
            $itemsBatch = explode(',', $key->items_batch);
        }

        $actualIds = array();
        $actualQty = array();

        for ($j=0; $j < sizeof($invoiceItems); $j = $j+2)
        { 
            array_push($actualIds, $invoiceItems[$j]);
            array_push($actualQty, $invoiceItems[$j+1]);
        }

        // comparing the actual and updated

        // all the flags actual

        $lessQuantityFlag = array();
        $lessQuantityFlagArray = array();
        // var_dump($drugId);


        for ($i=0; $i < sizeof($actualIds); $i++)
        { 
            $keyOfId = array_search($actualIds[$i], $drugId);
            if(isset($keyOfId))
            {
                // get batch of that drug id
                $qtyOfAct = $actualQty[$i];
                $qtyPresent = $qty[$keyOfId];

                if($qtyOfAct == $qtyPresent)
                {
                    array_push($lessQuantityFlag, 0);
                }
                elseif ($qtyOfAct > $qtyPresent)
                {
                    array_push($lessQuantityFlag, 0);
                }

                elseif ($qtyOfAct < $qtyPresent)
                {
                    $diff = $qtyPresent - $qtyOfAct;
                    $presentDiff = $this->pharmcyModel->getTheQuantity($actualIds[$i], $itemsBatch[$i]);
                    if($presentDiff->stock_quant >= $diff)
                    {
                        array_push($lessQuantityFlag, 0);
                    }
                    else
                    {
                        array_push($lessQuantityFlag, 1);
                        array_push($lessQuantityFlagArray, $actualIds[$keyOfId]);
                    }
                }
            }
        }

        // present qty check

        // flags for present

        $lessQuantityFlagPresent = array();
        $lessQuantityFlagPresentArray = array();

        for ($k=0; $k < sizeof($drugId); $k++)
        { 
            if(!in_array($drugId[$k], $actualIds))
            {
                $check = $this->pharmcyModel->getTheQuantity($drugId[$k], $bat[$k]);
                if($check->stock_quant >= $qty[$k])
                {
                    array_push($lessQuantityFlag, 0);
                }
                else
                {
                    array_push($lessQuantityFlag, 1);
                    array_push($lessQuantityFlagArray, $drugId[$k]);
                }
            }
        }

        // print_r($lessQuantityFlag);
        // print_r($lessQuantityFlagArray);
        if(!empty($lessQuantityFlagArray))
        {
            $ids = implode(',', $lessQuantityFlagArray);
            echo "Product(s) having ID(s) ".$ids." do not have required stocks.";
        }
        else
        {
			$this->pharmcyModel->cancelThePreviousOrderByIdAndRestoreTheStocks($invoiceId);
			$this->pharmcyModel->save_invoice_db_after_edit($_POST['service_id'], $bat, $_POST['invoice_bill'], $grandTotal, $patientName, $doctorName, $ipOp, $payment, $amountPaid, $_POST['discount']);
            // echo sizeof($drugId);
            // echo sizeof($actualIds);
            // if(sizeof($actualIds) > sizeof($drugId))
            // {
            // 	$removedMeds = array_diff($actualIds, $drugId);
			// }
			// else
			// {
			// 	$removedMeds = array_diff($drugId, $actualIds);
			// }

            // $removedMeds = array_values($removedMeds);
            // // $removedMeds = array_combine(range(0, sizeof($removedMeds)-1), array_values($removedMeds));
            // // var_dump($drugId);
            // for ($l=0; $l < sizeof($removedMeds); $l++)
            // { 
            //     $getTheMedKey = array_search($removedMeds[$l], $actualIds);
            //     $this->pharmcyModel->removeStockOfTheMed($removedMeds[$l], $itemsBatch[$getTheMedKey], $actualQty[$getTheMedKey]);
            // }
        }
    }

    public function confirmSaveEdit()
    {
        
    }
     public function get_drug_autocomplete_new()
    {
        $cname = $_POST['query'];
        $cust_list = $this->pharmcyModel->auto_item_name_new($cname);
        $output3 = '';
        $output3 = '<ul class="list-unstyled">';
        foreach ($cust_list as $key)
        {
            // $k = $this->pharmcyModel->auto_item_name_by_stock($key->id);
            // if(!empty($k))
            // {
                // if(($k->item_id) == ($key->id))
                // {
                    $output3 .='<li class="cc">'.ucwords($key->name).''."(".''.$key->id.''.") ".'</li>';
                // }
            // }
        }
        $output3.='</ul>';
        echo $output3;
    }

	public function print_prescription($id)
	  {
	 
		if(isset($_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']))
		{
			$logo = $this->receptionModel->get_logo_details();
			$row = $this->doctorModel->get_opd_data($id);
			foreach ($row as $key)
			{
				$pat = $this->receptionModel->get_patient_by_id($key->opd_patient_id);
				$doc = $this->receptionModel->get_doctor_by_id($key->opd_doctor_id);
				$temp = $key->opd_prescription;
			}

				  foreach ($row as $key3)
				  {   
					  $op = $key3->opd_prescription;
				  }
				 if(empty($op))
				  {
					  redirect('doctors/index');             
				  }


			$data = [
			  'logo' => $logo,
			  'opd' => $row,
			  'patient_name' =>$pat,
			  'doc_name' => $doc
			];
			$this->view('pharmacies/print_prescription', $data);

		}
		else
		{
			redirect('users/login');
		}
	  }


		public function get_patients_data_to_print($ppid)
		{
			return $pdata = $this->receptionModel->get_patient_by_id($ppid);
		}









} //end of class
?>
