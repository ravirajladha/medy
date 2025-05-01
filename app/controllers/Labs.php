<?php
  class Labs extends Controller
  {
      public function __construct()
      {
        $this->receptionModel = $this->model('Reception');
        $this->labModel = $this->model('Lab');
      }

      public function index()
      {
      	$this->view('labs/index');
      }

      public function orders()
      {
      	$this->view('labs/orders');
      }

      public function orders1()
      {
        $lim = $_POST['lim'];
        $lim = (int)$lim;
        if($lim==9)
        {
          $off = $_POST['off'];
          $off = (int)$off;
          $all_invoice = $this->receptionModel->get_all_orders_lab($lim,$off);
        }
        else
        {
          $inc = $_POST['inc'];
          $inc = (int)$inc;
          $lim = 9;
          $off = 9+(9*$inc);
          $all_invoice = $this->receptionModel->get_all_orders_lab($lim,$off);
        }
        $all_orders_print = '';

        foreach ($all_invoice as $key)
        {
          $invoice_id = $key->invoice_id;
		  $invoice_name = explode('|', $key->invoice_name);
		  $pName = ucwords($invoice_name[0]).'('.$invoice_name[1].')';
          $invoice_total = $key->invoice_total;
          $invoice_bill = $key->invoice_bill;
          $invoice_date = $key->invoice_date;
          $dep_type = $key->department;
		  $doctor = explode('|', $key->invoice_doctor);
		  $dName = ucwords($doctor[0]).'('.$doctor[1].')';
          $investigation = $key->invoice_item;
          $cancelled = $key->cancelled;
          $investigation = explode(',', $investigation);
          $length = sizeof($investigation);
          if($length != 4)
          {
              $length = $length - 1;
          }
          $inv_name = '';
          for($i=0; $i < $length ; $i++)
          {
            if($i != 0 && $i&1 && $i<$length/2)
            {
              $j=$i*2;
              $inv_name .= $investigation[$j];
              $inv_name .= '<br>';
            }
          }

          $all_orders_print.='<tr>
            <td>';
           	$all_orders_print.=''.$invoice_id.'</td>
            <td style="text-align: left;">'.$pName.'</td>
            <td style="text-align: left;">'.$inv_name.'</td>
            <td style="text-align: left;">'.$dName.'</td>
            <td style="text-align: left;">'.$invoice_date.'</td>
            <td>';
            if($cancelled == 1)
            {
              $all_orders_print.='<button style="width: 74px" type="button" class="btn btn-warning btn-xs m-b-5">Cancelled</button>';
            }
            else
            {
              $all_orders_print.='<a href="'.URLROOT.'/labs/view_test/'.$invoice_id.'"><button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">view</button></a>
                <button style="width: 54px" type="button" class="btn btn-danger btn-xs m-b-5" onclick="cancel_lab_order('.$invoice_id.')">Cancel</button>';
            }
            $all_orders_print.='</td>

          </tr>';
        }
        echo $all_orders_print;
      }

      public function test_group()
      {

      	$this->view('labs/test_group');
      }

      public function view_test($id)
      {
        $row = $this->labModel->get_invoices($id);
        $labTestData = $this->labModel->getLabTestData($id);
        $data = [
          'labTestData' => $labTestData,
          'row'=>$row,
          'id'=>$id
        ];
        $this->view('labs/view_test', $data);
      }

      public function part_test()
      {
        $ltt = $this->labModel->lab_test_type();
        $data=[
          'ltt'=>$ltt
        ];
        $all_data = '';
        foreach ($data['ltt'] as $key)
        {
          $lab_test_type_idl =$key->lab_test_type_id;
          $lab_test_type_namel =$key->lab_test_type_name;
          $test_type_countl=0;
          $get_test_value_1 = $this->labModel->get_test_value_1($lab_test_type_idl);
          $data = [
            'gtv'=>$get_test_value_1
          ];
          foreach ($data['gtv'] as $key)
          {
            $lab_test_namel =$key->lab_test_name;
            $lab_test_value_idl =$key->lab_test_value_id;
            $all_data.='<tr>
                <td class="col-sm-9" style="text-align: left!important;">'.$lab_test_namel.'</td>

                <td class="col-sm-1">
                        <label class="cr-styled">
                            <input type="checkbox" name="lbtest_id[]" value="'.$lab_test_value_idl.'" checked="checked">
                            <i class="fa"></i>
                        </label>
                </td>
                <td class="col-sm-2">
                    <a href="'.URLROOT.'/labs/add_test_edit/"><button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button>
                </td>
            </tr>';
          }
        }
              echo $all_data;
      }

      public function get_test_value_func_call($lab_test_type_idl)
      {
        $get_test_value_1 = $this->labModel->get_test_value_1($lab_test_type_idl);
        return $get_test_value_1;
      }

      public function test_group1()
      {
        $row = $this->labModel->get_all_test_names();
        $testType = $this->labModel->getAllTestTypes();
        $typeIdArray = array();
        $typeNameArray = array();
        foreach ($testType as $value)
        {
            array_push($typeIdArray, $value->lab_test_type_id);
            array_push($typeNameArray, $value->lab_test_type_name);
        }
        $all_orders_print = '';
        for ($i=0; $i < sizeof($typeIdArray); $i++)
        {
          $all_orders_print.=
          '
            <thead>
              <tr>
                <th colspan="4" style="text-align:left;">
                  '.$typeNameArray[$i].'
                </th>
              </tr>
			</thead>;
          ';

        foreach ($row as $key)
        {
          if($typeIdArray[$i] == $key->lab_test_type)
          {
          $test_name = $key->lab_test_name;
          $test_id = $key->lab_test_value_id;
          $yes = $this->labModel->get_lab_test_available_for_id($test_id);
          if($yes == 1)
          {
                $all_orders_print.= '
                <tbody>
                <tr>
                  <td class="col-sm-9" style="text-align: left!important;">'.$key->lab_test_name.'</td>
                  <td><input name="cost_val[]" class="form-control" id="cost'.$test_id.'" type="number" style="width:50px; border:1px solid lightgray; border-radius:3px;" placeholder="cost"></td>
                  <td class="col-sm-1">
                      <label class="cr-styled" style="margin-top:5px;">
                          <input name="hello" class="hicb" value="'.$test_id.'" type="checkbox"">
                          <i class="fa"></i>
                      </label>
                  </td>
                  <td class="col-sm-2">
                      <button onclick="get_test_id('.$test_id.')" style="width: 54px; margin-top:5px;" type="button" class="btn btn-info btn-xs m-b-5">Add</button>
                  </td>
                </tr>
                </tbody>';
              }
            }
          }
        }
        echo $all_orders_print;
      }

      public function test_group2()
      {
        if(!empty($_POST['checki']))
        {
            foreach($_POST['checki'] as $check)
            {
              echo $check;
            }
        }
      }

      public function new_test()
      {
        $row = $this->labModel->lab_test_type();
        $data = [
          'test_types'=>$row
        ];
      	$this->view('labs/new_test',$data);
      }

      public function quick_test_list()
      {
        $search_val = $_POST['val'];
        $row = $this->labModel->lab_test_type_ajax($search_val);
        $testType = $this->labModel->getAllTestTypes();
        $typeIdArray = array();
        $typeNameArray = array();
        foreach ($testType as $value)
        {
            array_push($typeIdArray, $value->lab_test_type_id);
            array_push($typeNameArray, $value->lab_test_type_name);
        }
        $all_orders_print = '';
        for ($i=0; $i < sizeof($typeIdArray); $i++)
        {
          $all_orders_print.=
          '
            <thead>
              <tr>
                <th colspan="4" style="text-align:left;">
                  '.$typeNameArray[$i].'
                </th>
              </tr>
			</thead>;
          ';

        foreach ($row as $key)
        {
          if($typeIdArray[$i] == $key->lab_test_type)
          {
          $test_name = $key->lab_test_name;
          $test_id = $key->lab_test_value_id;
          $yes = $this->labModel->get_lab_test_available_for_id($test_id);
          if($yes == 1)
          {
                $all_orders_print.= '
                <tbody>
                <tr>
                  <td class="col-sm-9" style="text-align: left!important;">'.$key->lab_test_name.'</td>
                  <td><input name="cost_val[]" class="form-control" id="cost'.$test_id.'" type="number" style="width:50px; border:1px solid lightgray; border-radius:3px;" placeholder="cost"></td>
                  <td class="col-sm-1">
                      <label class="cr-styled" style="margin-top:5px;">
                          <input name="hello" class="hicb" value="'.$test_id.'" type="checkbox"">
                          <i class="fa"></i>
                      </label>
                  </td>
                  <td class="col-sm-2">
                      <button onclick="get_test_id('.$test_id.')" style="width: 54px; margin-top:5px;" type="button" class="btn btn-info btn-xs m-b-5">Add</button>
                  </td>
                </tr>
                </tbody>';
              }
            }
          }
        }
        echo $all_orders_print;
      }

      public function add_test_edit($grtest)
      {
    	$this->view('labs/new_test');
      }

      public function create_test()
      {
        $test_name=$_POST['test_name'];
        $test_type=$_POST['test_type'];
        $test_cost=$_POST['test_cost'];
        $test_instruction=$_POST['test_instruction'];
        $test_procedure=$_POST['test_procedure'];
        $test_equipments=$_POST['test_equipments'];
        $testval_name = $_POST['testval_name'];
        $testval_specimen = $_POST['testval_specimen'];
        $testval_unit = $_POST['testval_unit'];
        $testval_ref = $_POST['testval_ref'];

        $today_date=date("Y-m-d H:i:s");
        $max_val = count($testval_name);

        $test_value="";
        for ($i=0;$i<$max_val;$i++)
        {

          $testval_ref[$i] = str_replace(array(','), '-', $testval_ref[$i]);
          if($i==0)
          {
            if($testval_name[$i])
            {
              $test_value.= "$testval_name[$i],$testval_specimen[$i],$testval_unit[$i],$testval_ref[$i]";
            }
          }
            else
            {
              if ($testval_name[$i])
              {
                $test_value.= ",$testval_name[$i],$testval_specimen[$i],$testval_unit[$i],$testval_ref[$i]";
              }
            }
        }
        $test_value=nl2br($test_value);
        $insertquery = $this->labModel->insert_test_details($test_name,$test_type,$test_instruction,$test_procedure,$test_equipments,$test_value,$today_date);
            if($insertquery)
            {
              echo "<script>alert('Test Added');</script>";
              redirect('labs/new_test');
            }

            else
            {
              echo "<script>alert('Something is worng, please check entered value')</script>";
              redirect('labs/new_test');
            }
      }

      public function get_lab_test_val_for_id($inv_id)
      {
          $lab_test_val = $this->labModel->get_test_value($inv_id);
          return $lab_test_val;
      }


      public function update_the_test_data()
      {
          if(isset($_POST['update_button']))
          {
              $test_status = 1;
          }
          else
          {
              $test_status = 2;
          }
          $object = $_POST['object'];
          $specimen = $_POST['specimen'];
          $result = $_POST['result'];
          $bri = $_POST['bri'];
          $i_id = $_POST['i_id'];
          $t_id = $_POST['t_id'];
          $all_data = '';

          for ($i=0; $i < count($object) ; $i++)
          {
              $all_data .= $object[$i];
              $all_data .= ',';
              $all_data .= $specimen[$i];
              $all_data .= ',';
              $all_data .= $result[$i];
              $all_data .= ',';
              $all_data .= $bri[$i];
              $all_data .= ',';
          }
          $success = $this->labModel->save_lab_test($all_data,$t_id,$i_id,$test_status);
          if($success)
          redirect('labs/view_test/'.$i_id.'');
      }


      public function test_update()
      {
          if(isset($_POST['update_button']))
          {
              $test_status = 1;
          }
          else
          {
              $test_status = 2;
          }
          $object_name = $_POST['object_name'];
          $specimen_name = $_POST['specimen'];
          $unit_value = $_POST['unit_value'];
          if(isset($_POST['unit_name']))
          {
              $unit_name = $_POST['unit_name'];
              $unit_value = "$unit_value$unit_name";
          }
          $bri = $_POST['bri'];
          $order_id_lab = $_POST['order_id_lab'];
          $test_id = $_POST['inv_id'];
          $all_data = "$object_name,$specimen_name,$unit_value,$bri";
          $success = $this->labModel->save_lab_test($all_data,$test_id,$order_id_lab,$test_status);
          if($success)
          redirect('labs/view_test/'.$order_id_lab.'');
      }

      public function get_data_after_update($upd_ord_val,$upd_test_val)
      {
          $gdaud = $this->labModel->get_data_after_update_db($upd_ord_val,$upd_test_val);
          return $gdaud;
      }

      public function save_available_test()
      {
          $id = $_POST['id'];
          $cost = $_POST['cost'];
          $success = $this->labModel->save_available_test_db($id,$cost);
          if($success == 5)
          {
            echo "Test Exists";
          }
          elseif($success == 1)
          {
            echo "Updated";
          }
          else
          {
            echo "Error";
          }
      }

      public function get_available_tests()
      {
          $gat = $this->labModel->get_available_tests_db();
          $all_data = '';
          foreach ($gat as $key)
          {
            $lab_test_namel =$key->lab_test_name;
            $lab_test_value_idl =$key->test_id;
            $serial_id = $key->serial_id;
            $all_data.='<tr>
                <td class="col-sm-9" style="text-align: left!important;">'.$lab_test_namel.'</td>

                <td class="col-sm-1">
                        <label class="cr-styled">
                            <input name="added_tests" type="checkbox" checked name="lbtest_id[]" value="'.$serial_id .'">
                            <i class="fa"></i>
                        </label>
                </td>
                <td class="col-sm-2">
                    <a href="'.URLROOT.'/labs/add_test_edit/'.$lab_test_value_idl.'"><button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button>
                </td>
            </tr>';
          }
          echo $all_data;
      }

      public function get_available_tests_db_autocomplete()
      {
          $val = $_POST['val'];
          $gat = $this->labModel->get_available_tests_db_auto($val);
          $all_data = '';
          foreach ($gat as $key)
          {
            $lab_test_namel =$key->lab_test_name;
            $lab_test_value_idl =$key->test_id;
            $all_data.='<tr>
                <td class="col-sm-9" style="text-align: left!important;">'.$lab_test_namel.'</td>

                <td class="col-sm-1">
                        <label class="cr-styled">
                            <input type="checkbox" name="lbtest_id[]" value="'.$lab_test_value_idl.'">
                            <i class="fa"></i>
                        </label>
                </td>
                <td class="col-sm-2">
                    <a href="'.URLROOT.'/labs/add_test_edit/"><button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button>
                </td>
            </tr>';
          }
          echo $all_data;
      }

      public function cancel_lab_order()
      {
          $id = $_POST['id'];
          $success = $this->labModel->cancel_invoice($id);
          if($success)
          {
            echo "Cancelled";
          }
          else
          {
            echo "Error";
          }
      }

      public function bulk_add_to_group()
      {
          $ids = $_POST['ch'];
          $costs = $_POST['cst'];
          $success = $this->labModel->bulk_add_to_group_db($ids, $costs);
          if($success == 5)
          {
            echo "Test Exists";
          }
          elseif($success == 1)
          {
            echo "Updated";
          }
          else
          {
            echo "Error";
          }
      }

      public function update_new_group()
      {
          $t_ids = $_POST['t_ids'];
          $success = $this->labModel->update_new_group_db($t_ids);
          if($success)
          {
            echo "Updated";
          }
          else
          {
            echo "Error";
          }
      }

      public function delete_all_tests()
      {
          $success = $this->labModel->delete_all_tests_db();
          if($success)
          {
            echo 'Updated';
          }
          else
          {
            echo 'Error';
          }
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

              $success = $this->labModel->update_password_db($cpass, $id, $files_array);
              if($success)
                redirect('labs/success_settings');
              else
                redirect('labs/upd_err_settings');
          }
          else
          {
              redirect('labs/error_settings');
          }

      }
       public function settings()
      {
          $user_id = $_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no'];
          $mem_data = $this->labModel->get_mem_data($user_id);
          foreach ($mem_data as $key)
          {
              $_SESSION['user_photo_medhike_87_71_18_08_80_none_med_hi_ke_no'] = $key->mem_photo;
          }
          $data = [
            'mem_data' => $mem_data
          ];
          $this->view('labs/settings', $data);
      }

       public function allxraydetails()
      {
          $this->view('labs/allxraydetails');
      }
       public function new_xray()
      {
          $this->view('labs/new_xray');
      }
       public function doc_upload_jq()
      {
          $f_name=$_FILES['file']['name'];
          $f_tmp=$_FILES['file']['tmp_name'];
          $size=$_FILES['file']['size'];
          $f_extension=explode('.', $f_name);
          $f_extension=strtolower(end($f_extension));
          $f_newfile=uniqid().'.'.$f_extension;
          $store="reports/".$f_newfile;
          move_uploaded_file($f_tmp, $store);
          $files_array = $f_newfile;
          $store="reports/";

          $success = $this->labModel->doc_upload_jq_db($files_array);
          if($success)
          {
            echo $success;
          }
          else
          {
            echo $success;
          }



      }

      public function save_other_upload_details()
      {

          $ip_id = $_POST['ip_rep'];
          $rep_tit = $_POST['rep_tit'];
          $success = $this->labModel->save_other_upload_details_db($ip_id, $rep_tit);
          if($success)
          {
              echo true;
          }
          else
          {
              echo false;
          }
      }
        public function delete_xray()
      {
          $s_id = $_POST['ser_id'];
          $success = $this->labModel->delete_xray_db($s_id);
          if($success)
            echo "deleted";
          else
            echo "error";

      }

            public function all_xray1()
      {
          $lim = $_POST['lim'];
          $lim = (int)$lim;
          if($lim==9)
          {
            $off = $_POST['off'];
            $off = (int)$off;
            $all_service = $this->labModel->get_all_report($lim,$off);
          }
          else
          {
            $inc = $_POST['inc'];
            $inc = (int)$inc;
            $lim = 9;
            $off = 9+(9*$inc);
            $all_service = $this->labModel->get_all_report($lim,$off);
          }
          $all_orders_print = '';

          foreach ($all_service as $key)
          {
            $report_id= $key->report_id;
            $patient_id = $key->patient_id;
            $invoice_name = $key->report_title;
            $report_file_name = $key->report_file_name;
            $invoice_bill = $key->report_date;
            $all_orders_print.='<tr>
              <td id="r_id">'.$patient_id.'</td>
              <td style="text-align:left; padding-left:40px;">'.$invoice_name.'</td>
              <td style="text-align:left; padding-left:40px; "><a download href="'.URLROOT.'/reports/'.$report_file_name.'" style="color:black;">'.$report_file_name.'</a></td>
              <td style="text-align:left;">'.$invoice_bill.'</td>
              <td style="text-align:left;padding-left:40px;">

                <button onclick="confirm_sec('.$report_id.')" style="width: 64px" type="button" class="btn btn-warning btn-xs m-b-5">Remove</button>
              </td>
            </tr>';
          }
          echo $all_orders_print;
      }
         public function search_by_xray_id()
      {
          $inv_id = $_POST['inv'];
          $single_invoice = $this->labModel->get_search_xray($inv_id);
          $all_orders_print = '';

         foreach ($single_invoice as $key)
          {
            $report_id= $key->report_id;
            $patient_id = $key->patient_id;
            $invoice_name = $key->report_title;
            $report_file_name = $key->report_file_name;
            $invoice_bill = $key->report_date;
            $all_orders_print.='<tr>
              <td id="r_id">'.$patient_id.'</td>
              <td style="text-align:left; padding-left:40px;">'.$invoice_name.'</td>
               <td style="text-align:left; padding-left:40px; "><a download href="'.URLROOT.'/reports/'.$report_file_name.'" style="color:black;">'.$report_file_name.'</a></td>
              <td style="text-align:left;">'.$invoice_bill.'</td>
              <td style="text-align:left;padding-left:40px;">

                <button onclick="confirm_sec('.$report_id.')" style="width: 64px" type="button" class="btn btn-warning btn-xs m-b-5">Remove</button>
              </td>
            </tr>';
          }
          echo $all_orders_print;
      }

       public function get_auto_patient_name2()
      {
          $cname = $_POST['query3'];
          $cust_list = $this->receptionModel->auto_patient_name2($cname);
          $output3 = '';
          $output3 = '<ul class="list-unstyled">';
          foreach ($cust_list as $key)
          {
            $output3 .='<li class="ee"><p>'.ucwords($key->patient_name).''."(".''.$key->patient_id.''.")".'</p></li>';
          }
          $output3.='</ul>';
          echo $output3;
      }

      public function uploadTestDocument($id)
      {
         $t_id = $_POST['t_id'];
         $allFilesName = array();
         $countfiles = count($_FILES['docs']['name']);
         for($i=0;$i<$countfiles;$i++)
         {
          $filename = $id.$_FILES['docs']['name'][$i];
          move_uploaded_file($_FILES['docs']['tmp_name'][$i],'reports/'.$filename);
          array_push($allFilesName, $filename);
         }
         $this->labModel->saveAllDocumentsLabOrder($id, $allFilesName, $t_id);
         redirect('labs/view_test/'.$id.'');
      }

  }
  ?>
