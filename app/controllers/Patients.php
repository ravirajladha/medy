<?php
  class Patients extends Controller
  {
      public function __construct()
      {
        $this->receptionModel = $this->model('Reception');
        $this->userModel = $this->model('User');
         $this->patientModel = $this->model('Patient');


        }

      // All Functions Starts Here

      public function index()
      {
        $nnn = $this->patientModel->get_patient_id_using_session();
        $_SESSION['patient_id']=$nnn->patient_id;
        $order = $this->receptionModel->get_order_count_new();
        $dat = date('Y-m-d');
        $count = 0;
        $count1 = 0;
        $count2 = 0;
        $count3 = 0;
        foreach ($order as $key)
        {
            if($dat == date('Y-m-d',strtotime($key->invoice_date)))
            {
                $count++;
            }
        }
        $patient = $this->receptionModel->get_patient_count_new();
        foreach ($patient as $key2)
        {
            if($dat == date('Y-m-d', strtotime($key2->registered_time)))
            {
                $count1++;
            }
        }
        $visit = $this->receptionModel->get_new_opd();
        foreach ($visit as $key3)
        {
            if($dat == date('Y-m-d', strtotime($key3->visit_date_time)))
            {
                $count2++;
            }
        }
        $admit = $this->receptionModel->get_new_ipd();
        foreach ($admit as $key4)
        {
            if($dat == date('Y-m-d', strtotime($key4->admission_date_time)))
            {
                $count3++;
            }
        }

        $data = [
          'order' => $count,
          'patient' => $count1,
          'visit' => $count2,
          'admit' => $count3
        ];
        $this ->view('patients/index', $data);
      }

      public function new_orders()
      {
        $this->view('patients/new_orders');
      }

      public function new_member()
      {
        $this->view('patients/new_member');
      }

      public function add_mem()
      {
        $mem_name = $_POST['mem_name'];
        $mem_type = $_POST['mem_type'];
        $mem_ph = $_POST['mem_ph'];
        $mem_em = $_POST['mem_em'];

        $suc = $this->receptionModel->add_mem_db($mem_name, $mem_type, $mem_ph, $mem_em);
        if($suc)
        {
          echo 'Member Added';
        }
        else
        {
          echo 'error';
        }
      }

      public function all_orders()
      {
        $this->view('patients/all_orders');
      }

      public function all_orders1()
      {
        $lim = $_POST['lim'];
        $lim = (int)$lim;
        if($lim==9)
        {
          $off = $_POST['off'];
          $off = (int)$off;
          $all_invoice = $this->receptionModel->get_all_orders_pat($lim,$off);
        }
        else
        {
          $inc = $_POST['inc'];
          $inc = (int)$inc;
          $lim = 9;
          $off = 9+(9*$inc);
          $all_invoice = $this->receptionModel->get_all_orders_pat($lim,$off);
        }
        $all_orders_print = '';
        foreach ($all_invoice as $key)
        {
          $invoice_id = $key->invoice_id;
          $invoice_name = $key->invoice_name;
          $invoice_name = explode('|', $invoice_name);
          $invoice_total = $key->invoice_total;
          $invoice_bill = $key->invoice_bill;
          $invoice_date = $key->invoice_date;
          $dep_type = $key->department;
          $cancel = $key->cancelled;
          $all_orders_print.='<tr>
            <td style="padding-top:15px; text-align:;">';
            if($dep_type==1)
            {
              $all_orders_print.='<span class="badge badge-pill badge-warning" style="background-color:#FF3366;">L</span>&nbsp;';
            }
            else
            {
              $all_orders_print.='<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;';
            }
           $all_orders_print.=''.$invoice_id.'</td>
            <td style="padding-top:15px;">'.$invoice_bill.'</td>
            <td style="padding-top:15px;">'.$invoice_total.'</td>
            <td style="padding-top:15px;">'.date('d-m-Y H:i A', strtotime($invoice_date)).'';
            $all_orders_print.='</td>

          </tr>';
        }
        echo $all_orders_print;
      }

      public function edit_order($order_id)
      {
        $edit_order_details = $this->receptionModel->get_search_orders($order_id);

        $data = [
          'edit_order_details'=>$edit_order_details
        ];
        $this->view('patients/new_orders',$data);
      }

      public function search_by_inv_id()
      {
        $inv_id = $_POST['inv'];
        $single_invoice = $this->receptionModel->get_search_orders($inv_id);
        $single_order_print = '';

        foreach ($single_invoice as $key)
        {
          $invoice_id = $key->invoice_id;
          $invoice_name = $key->invoice_name;
          $invoice_total = $key->invoice_total;
          $invoice_bill = $key->invoice_bill;
          $invoice_date = $key->invoice_date;
          $single_order_print.='<tr>
            <td>'.$invoice_id.'</td>
            <td>'.$invoice_name.'</td>
            <td>'.$invoice_total.'</td>
            <td>'.$invoice_bill.'</td>
            <td>'.$invoice_date.'</td>
            <td>
                <button style="width: 54px" type="button" class="btn btn-success btn-xs m-b-5">Print</button>
                <button style="width: 54px;" type="button" class="btn btn-purple btn-xs m-b-5">View</button>
                <br>
                <button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button>
                <button style="width: 54px" type="button" class="btn btn-warning btn-xs m-b-5">Cancel</button>
            </td>
          </tr>';
        }
          echo $single_order_print;
      }

      public function search_by_name_value()
      {
        $patient_name = $_POST['patient_name'];
        $patients_list= $this->receptionModel->get_patient_orders($patient_name);
        $patient_order_print = '';

        foreach ($patients_list as $key)
        {
          $invoice_id = $key->invoice_id;
          $invoice_name = $key->invoice_name;
          $invoice_total = $key->invoice_total;
          $invoice_bill = $key->invoice_bill;
          $invoice_date = $key->invoice_date;
          $patient_order_print.='<tr>
            <td>'.$invoice_id.'</td>
            <td>'.$invoice_name.'</td>
            <td>'.$invoice_total.'</td>
            <td>'.$invoice_bill.'</td>
            <td>'.$invoice_date.'</td>
            <td>
                <button style="width: 54px" type="button" class="btn btn-success btn-xs m-b-5">Print</button>
                <button style="width: 54px;" type="button" class="btn btn-purple btn-xs m-b-5">View</button>
                <br>
                <button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button>
                <button style="width: 54px" type="button" class="btn btn-warning btn-xs m-b-5">Cancel</button>
            </td>
          </tr>';
        }
          echo $patient_order_print;
      }

      public function new_service()
      {
          $service_types = $this->receptionModel->get_all_service_db();
          $data = [
              'service_types'=>$service_types
            ];
          $this->view('patients/new_service',$data);
      }

      public function save_new_service()
      {
          $s_name = $_POST['s_name'];
          $s_cost = $_POST['s_cost'];
          $s_type = $_POST['s_type'];
          $success = $this->receptionModel->save_new_service_db($s_name,$s_type,$s_cost);
          if($success)
            echo "upadted";
          else
            echo "error";
      }

      public function update_service()
      {
          $s_id = $_POST['e_id'];
          $s_name = $_POST['e_name'];
          $s_cost = $_POST['e_cost'];
          $s_type = $_POST['e_type'];
          $su = $this->receptionModel->update_service_db($s_id,$s_name,$s_type,$s_cost);
          if($su)
            echo "upadted";
          else
            echo "error";
      }

      public function all_services()
      {
          $this->view('patients/all_services');
      }

      public function all_services1()
      {
          $lim = $_POST['lim'];
          $lim = (int)$lim;
          if($lim==9)
          {
            $off = $_POST['off'];
            $off = (int)$off;
            $all_service = $this->receptionModel->get_all_services($lim,$off);
          }
          else
          {
            $inc = $_POST['inc'];
            $inc = (int)$inc;
            $lim = 9;
            $off = 9+(9*$inc);
            $all_service = $this->receptionModel->get_all_services($lim,$off);
          }
          $all_orders_print = '';

          foreach ($all_service as $key)
          {
            $invoice_id = $key->service_id;
            $invoice_name = $key->service_name;
            $invoice_total = $key->service_type;
            $invoice_bill = $key->service_cost;
            $all_orders_print.='<tr>
              <td id="r_id">'.$invoice_id.'</td>
              <td>'.$invoice_name.'</td>
              <td>'.$invoice_total.'</td>
              <td>'.$invoice_bill.'</td>
              <td>
                <a href="'.URLROOT.'/patients/edit_service/'.$invoice_id.'"><button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button></a>
                <button data-id="'.$invoice_id.'" style="width: 54px" type="button" class="btn btn-warning btn-xs m-b-5">Remove</button>
              </td>
            </tr>';
          }
          echo $all_orders_print;
      }

      public function delete_service()
      {
          $s_id = $_POST['ser_id'];
          $success = $this->receptionModel->delete_service_db($s_id);
          if($success)
            echo "deleted";
          else
            echo "error";

      }

      public function search_by_ser_id()
      {
          $inv_id = $_POST['inv'];
          $single_invoice = $this->receptionModel->get_search_services($inv_id);
          $all_orders_print = '';

          foreach ($single_invoice as $key)
          {
            $invoice_id = $key->service_id;
            $invoice_name = $key->service_name;
            $invoice_total = $key->service_type;
            $invoice_bill = $key->service_cost;
            $all_orders_print.='<tr>
              <td>'.$invoice_id.'</td>
              <td>'.$invoice_name.'</td>
              <td>'.$invoice_total.'</td>
              <td>'.$invoice_bill.'</td>
              <td>
                <a href="'.URLROOT.'/patients/edit_service/'.$invoice_id.'"><button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button></a>
                <button style="width: 54px" type="button" class="btn btn-warning btn-xs m-b-5">Remove</button>
              </td>
            </tr>';
          }
          echo $all_orders_print;
      }

      public function search_by_service_name()
      {
          $patient_name = $_POST['patient_name'];
          $patients_list= $this->receptionModel->get_patient_service($patient_name);
          $all_orders_print = '';

          foreach ($patients_list as $key)
          {
            $invoice_id = $key->service_id;
            $invoice_name = $key->service_name;
            $invoice_total = $key->service_type;
            $invoice_bill = $key->service_cost;
            $all_orders_print.='<tr>
              <td>'.$invoice_id.'</td>
              <td>'.$invoice_name.'</td>
              <td>'.$invoice_total.'</td>
              <td>'.$invoice_bill.'</td>
              <td>
                <a href="'.URLROOT.'/patients/edit_service/'.$invoice_id.'"><button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button></a>
                <button style="width: 54px" type="button" class="btn btn-warning btn-xs m-b-5">Remove</button>
              </td>
            </tr>';
          }
          echo $all_orders_print;
      }

      public function edit_service($inv_id)
      {
          $inv_edit_details = $this->receptionModel->get_search_services($inv_id);
          $service_types = $this->receptionModel->get_all_service_db();
          $data = [
              'service_types'=>$service_types,
              'inv_edit_details'=>$inv_edit_details
          ];
          $this->view('patients/new_service',$data);
      }

      public function new_op_visit()
      {
          $doc_list = $this->receptionModel->get_doctors_list();
          $data = [
            'doc_list' => $doc_list
          ];
          $this->view('patients/new_op_visit',$data);
      }

      public function all_visit()
      {
          $this->view('patients/all_visit');
      }

      public function new_ip_visit()
      {
          $doc_list = $this->receptionModel->get_doctors_list();
          $data = [
            'doc_list' => $doc_list
          ];
          $this->view('patients/new_ip_visit',$data);
      }

      public function all_admissions()
      {
          $this->view('patients/all_admissions');
      }

      public function all_admissions1()
      {
          $lim = $_POST['lim'];
          $lim = (int)$lim;
          if($lim==9)
          {
            $off = $_POST['off'];
            $off = (int)$off;
            $all_admits = $this->receptionModel->get_all_admission_pat($lim,$off);
          }
          else
          {
            $inc = $_POST['inc'];
            $inc = (int)$inc;
            $lim = 9;
            $off = 9+(9*$inc);
            $all_admits = $this->receptionModel->get_all_admission_pat($lim,$off);
          }
          $all_orders_print = '';

          foreach ($all_admits as $key)
          {
            $ipd_admit_id = $key->ipd_admit_id;
            $ipd_patient_id = $key->ipd_patient_id;
            $pat_name = $this->receptionModel->patient_name($ipd_patient_id);
            $ipd_admit_id_gen = "$ipd_admit_id,g";
            $ipd_admit_id_lab = "$ipd_admit_id,l";
            $ipd_patient_name = $key->ipd_patient_id;
            $ipd_doctor_id = $key->ipd_doctor_id;
            $doc_name = $this->receptionModel->doctor_name($ipd_doctor_id);
            $ipd_bed_id = $key->ipd_bed_id;
            $admission_date_time = $key->admission_date_time;
            $discharge_date_time = $key->discharge_date_time;
            $all_orders_print.='<tr>


              <td id="ad_id">'.$ipd_admit_id.'</td>
              <td style="text-align:left">'.ucwords($pat_name).'('.$ipd_patient_id.')</td>
              <td style="text-align:left">Dr. '.ucwords($doc_name).'</td>
              <td>'.$ipd_bed_id.'</td>
              <td style="width:200px;"><form action="'.URLROOT.'/receptions/update_admission/'.$ipd_admit_id.'" method="POST">
                <h5>'.date('d-m-Y h:i A', strtotime($admission_date_time)).' &nbsp;</h5>
              </td>
              <td>
                <form action="'.URLROOT.'/receptions/update_discharge/'.$ipd_admit_id.'" method="POST">
                ';
                if($discharge_date_time != NULL)
                {
                  $all_orders_print.='
                  <h5>'.date('d-m-Y h:i A', strtotime($discharge_date_time)).' &nbsp;</h5>
                ';
                }
                else
                {
                  $all_orders_print.='<h5>Not Discharged</h5>';
                }

                 $all_orders_print.='
              </td>
              </tr>';
          }
          echo $all_orders_print;
      }


      public function new_patient()
      {
          $this->view('patients/new_patient');
      }

      public function all_patients()
      {
          $this->view('patients/all_patients');
      }

      public function all_patients1()
      {
          $lim = $_POST['lim'];
          $lim = (int)$lim;
          if($lim==9)
          {
            $off = $_POST['off'];
            $off = (int)$off;
            $all_patients = $this->receptionModel->get_all_patients($lim,$off);
          }
          else
          {
            $inc = $_POST['inc'];
            $inc = (int)$inc;
            $lim = 9;
            $off = 9+(9*$inc);
            $all_patients = $this->receptionModel->get_all_patients($lim,$off);
          }
          $all_orders_print = '';

          foreach ($all_patients as $key)
          {
            $patient_id = $key->patient_id;
            $patient_name = $key->patient_name;
            $patient_gender = $key->patient_gender;
            if($patient_gender==1)
              $patient_gender = 'MALE';
            else
              $patient_gender = "FEMALE";
              $patient_dob = $key->patient_dob;
              $patinet_phone = $key->patient_phone;
              $patient_email = $key->patient_email;
              $patinet_address = $key->patient_address;
              $all_orders_print.='<tr>
              <td>'.$patient_id.'</td>
              <td style="text-align:left;">'.ucwords($patient_name).'</td>
              <td>'.$patient_gender.'</td>
              <td>'.$patinet_phone.'<br>'.$patient_email.'</td>
              <td>'.$patinet_address.'</td>
              <td>
                  <a href="'.URLROOT.'/patients/edit_patient/'.$patient_id.'"><button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button></a>
                  <button style="width: 54px" type="button" class="btn btn-warning btn-xs m-b-5">Remove</button>
              </td>
            </tr>';
          }
          echo $all_orders_print;
      }

      public function edit_patient($p_id)
      {
          $p_details = $this->receptionModel->get_patient_by_id($p_id);
          $data = [
            'p_details'=>$p_details
          ];
          $this->view('patients/new_patient',$data);
      }

      public function new_doctor()
      {
          $this->view('patients/new_doctor');
      }

      public function new_doctor1($d_id)
      {
          $d_list = $this->receptionModel->get_doctor_by_id($d_id);
          $data = [
            'd_list'=>$d_list
          ];
          $this->view('patients/new_doctor',$data);
      }

      public function new_member1($d_id)
      {
          $mem_list = $this->receptionModel->get_member_by_id($d_id);
          $data = [
            'mem_list'=>$mem_list
          ];
          $this->view('patients/new_member',$data);
      }

      public function add_doctor()
      {
          $doc_name = $_POST['doc_name'];
          $doc_spl = $_POST['doc_spl'];
          $success = $this->receptionModel->add_doctor_db($doc_name,$doc_spl);
          if($success)
            echo "Updated";
          else
            echo "Error";
      }

      public function all_doctors()
      {
          $this->view('patients/all_doctors');
      }

      public function all_doctors1()
      {
          $lim = $_POST['lim'];
          $lim = (int)$lim;
          if($lim==9)
          {
            $off = $_POST['off'];
            $off = (int)$off;
            $all_doctorss = $this->receptionModel->get_all_doctors($lim,$off);
          }
          else
          {
            $inc = $_POST['inc'];
            $inc = (int)$inc;
            $lim = 9;
            $off = 9+(9*$inc);
            $all_doctorss = $this->receptionModel->get_all_doctors($lim,$off);
          }
          $all_orders_print = '';

          foreach ($all_doctorss as $key)
          {
            $doc_id = $key->doctor_id;
            $doc_name = $key->doctor_name;
            $doc_spl = $key->doctor_speciality;
            $all_orders_print.='<tr>
              <td>'.$doc_name.'</td>
              <td>'.$doc_spl.'</td>
              <td>
                  <a href="'.URLROOT.'/patients/new_doctor1/'.$doc_id.'"><button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button></a>
                  <button style="width: 54px" type="button" class="btn btn-warning btn-xs m-b-5">Remove</button>
              </td>
            </tr>';
          }
          echo $all_orders_print;
      }

      public function all_members1()
      {
          $lim = $_POST['lim'];
          $lim = (int)$lim;
          if($lim==9)
          {
            $off = $_POST['off'];
            $off = (int)$off;
            $all_doctorss = $this->receptionModel->get_all_members($lim,$off);
          }
          else
          {
            $inc = $_POST['inc'];
            $inc = (int)$inc;
            $lim = 9;
            $off = 9+(9*$inc);
            $all_doctorss = $this->receptionModel->get_all_members($lim,$off);
          }
          $all_orders_print = '';

          foreach ($all_doctorss as $key)
          {
            $mem_id = $key->mem_id;
            $mem_name = $key->mem_name;
            $mem_type = $key->mem_type;
            $mem_phone = $key->mem_phone;
            $mem_email = $key->mem_email;
            $all_orders_print.='<tr>
              <td>'.$mem_id.'</td>
              <td>'.$mem_name.'</td>
              <td>'.$mem_type.'</td>
              <td>'.$mem_phone.'</td>
              <td>'.$mem_email.'</td>
              <td>
                  <a href="'.URLROOT.'/patients/new_member1/'.$mem_id.'"><button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button></a>
                  <a href="'.URLROOT.'/patients/remove_member/'.$mem_id.'"><button style="width: 54px" type="button" class="btn btn-warning btn-xs m-b-5">Remove</button></a>
              </td>
            </tr>';
          }
          echo $all_orders_print;
      }

      public function reports()
      {
          $this->view('patients/reports');
      }

      public function remove_member($mid)
      {
          $this->receptionModel->remove_mem_db($mid);
          $this->view('patients/all_members');
      }

      public function lab_new_orders()
      {
        $data = [
          'ty'=>'l'
        ];
        $this->view('patients/new_orders',$data);
      }

      public function get_report()
      {
          $this->view('patients/get_report');
      }

      public function all_members()
      {
        $this->view('patients/all_members');
      }

      public function prescription()
      {
          $this->view('patients/prescription');
      }

      public function lab_reports()
      {
          $this->view('patients/lab_reports');
      }

     

      public function get_auto_complete()
      {
          $name = $_POST['query'];
          $id = $_POST['button_idq'];
          $name_list = $this->receptionModel->auto_complete($name);
          $output = '';
          $output = '<ul class="list-unstyled">';
          foreach ($name_list as $key)
          {
            $service_name_id = "$key->service_name | $key->service_id";
            $output .='<li id="new'.$key->service_id.'" class="cccc" value="'.$service_name_id.'" onclick="setValue('.$id.','.$key->service_id.','.$key->service_cost.')">'.$key->service_name.''." | ".''.$key->service_id.'</li>';
          }
          $output.='</ul>';
          echo $output;
      }

      public function get_auto_complete_first()
      {
          $name = $_POST['query'];
          $name_list = $this->receptionModel->auto_complete($name);
          $output = '';
          $output = '<ul class="list-unstyled">';
          foreach ($name_list as $key)
          {
            $output .='<li class="cc">'.$key->service_name.''." | ".''.$key->service_id.'</li>';
          }
          $output.='</ul>';
          echo $output;
      }

      public function get_auto_complete_lab_first()
      {
          $name = $_POST['query'];
          $name_list = $this->receptionModel->get_available_tests_db_auto($name);
          $output = '';
          $output = '<ul class="list-unstyled">';
          foreach ($name_list as $key)
          {
            $output .='<li class="cc">'.$key->lab_test_name.''." | ".''.$key->test_id.'</li>';
          }
          $output.='</ul>';
          echo $output;
      }

      public function get_auto_complete_lab()
      {
          $name = $_POST['query'];
          $id = $_POST['button_idq'];
          $name_list = $this->receptionModel->get_available_tests_db_auto($name);
          $output = '';
          $output = '<ul class="list-unstyled">';
          foreach ($name_list as $key)
          {
            $service_name_id = "$key->lab_test_name | $key->test_id";
            $output .='<li id="new'.$key->test_id.'" class="cccc" value="'.$service_name_id.'" onclick="setValue('.$id.','.$key->test_id.','.$key->test_cost.')">'.$key->lab_test_name.''." | ".''.$key->test_id.'</li>';
          }
          $output.='</ul>';
          echo $output;
      }

      public function get_auto_patient_name()
      {
          $cname = $_POST['query3'];
          $cust_list = $this->receptionModel->auto_patient_name($cname);
          $output3 = '';
          $output3 = '<ul class="list-unstyled">';
          foreach ($cust_list as $key)
          {
            $output3 .='<li class="ee"><p>'.$key->patient_name.''." | ".''.$key->patient_id.'</p></li>';
          }
          $output3.='</ul>';
          echo $output3;
      }

      public function get_auto_patient_name2()
      {
          $cname = $_POST['query3'];
          $cust_list = $this->receptionModel->auto_patient_name2($cname);
          $output3 = '';
          $output3 = '<ul class="list-unstyled">';
          foreach ($cust_list as $key)
          {
            $output3 .='<li class="ee"><p>'.$key->patient_name.''." | ".''.$key->patient_id.'</p></li>';
          }
          $output3.='</ul>';
          echo $output3;
      }

      public function get_value_of_amt()
      {
          $aamt = $_POST['amt'];
          $aamt = explode('|', $aamt);
          $aamt = $aamt[1];
          $aamt_val = $this->receptionModel->value_of_amt($aamt);
          echo $aamt_val->service_cost;
      }

      public function get_value_of_amt_lab()
      {
          $aamt = $_POST['amt'];
          $aamt = explode('|', $aamt);
          $aamt = (int)$aamt[1];
          $aamt_val = $this->receptionModel->value_of_amt_lab($aamt);
          echo $aamt_val->test_cost;
      }

      public function save_invoice()
      {
          $inv_id_edit = $_POST['inv_id_edit'];
          $service_id = $_POST['service_id'];
          $invoice_bill = $_POST['invoice_bill'];
          $grand_total = $_POST['grand_total'];
          $patient_name = $_POST['patient_name'];
          $doctor_name = $_POST['doctor_name'];
          $ipopid = $_POST['ipopid'];
          $pay_mode = $_POST['pay_mode'];
          $amount_paid = $_POST['amount_paid'];
          $status = $_POST['status'];
          $dep = $_POST['dep_type'];
          $b = $_POST['b'];
          if($status == "saved")
          {
              // $this->create_save_session();
              $_SESSION['service_id'] = $service_id;
              $_SESSION['invoice_bill'] = $invoice_bill;
              $_SESSION['grand_total'] = $grand_total;
              $_SESSION['patient_name'] = $patient_name;
              $_SESSION['doctor_name'] = $doctor_name;
              $_SESSION['ipopid'] = $ipopid;
              $_SESSION['pay_mode'] = $pay_mode;
              $_SESSION['amount_paid'] = $amount_paid;
              $_SESSION['status'] = $status;
          }

          else
          {
              $this->unset_saved_session();
          }

          if($inv_id_edit!=0)
          {
              $success = $this->receptionModel->update_invoice_db($inv_id_edit,$service_id,$invoice_bill,$grand_total,$patient_name,$doctor_name,$ipopid,$pay_mode,$amount_paid,$status,$dep);
          }
          else
          {
              $success = $this->receptionModel->save_invoice_db($service_id,$invoice_bill,$grand_total,$patient_name,$doctor_name,$ipopid,$pay_mode,$amount_paid,$status,$dep);
          }

          if($success)
          {
            echo "updated";
          }
          else
          {
            echo "error";
          }
      }


      public function unset_saved_session()
      {
          unset($_SESSION['service_id']);
          unset($_SESSION['invoice_bill']);
          unset($_SESSION['grand_total']);
          unset($_SESSION['patient_name']);
          unset($_SESSION['doctor_name']);
          unset($_SESSION['ipopid']);
          unset($_SESSION['pay_mode']);
          unset($_SESSION['amount_paid']);
          unset($_SESSION['status']);
          return true;
      }

      public function create_visit()
      {
          $p_name = $_POST['p_name'];
          $d_name = $_POST['d_name'];
          $v_pur = $_POST['visit_pur'];
          $success = $this->receptionModel->create_visit_db($p_name,$d_name,$v_pur);
          if($success)
            echo "updated";
          else
            echo "error";
      }

      public function create_admission()
      {
          $p_name = $_POST['p_name'];
          $d_name = $_POST['d_name'];
          $v_pur = $_POST['visit_pur'];
          $success = $this->receptionModel->create_admission_db($p_name,$d_name,$v_pur);
          if($success)
            echo "updated";
          else
            echo "error";
      }

      public function view_invoice($id)
      {
          if($id == 0)
          {
            $last_inv = $this->receptionModel->get_invoice_details_for_new();
            $data = [
            'last_inv'=>$last_inv
          ];
          }
          else
          {
            $last_inv = $this->receptionModel->get_last_invoice($id);
            $data = [
              'last_inv'=>$last_inv
            ];
          }
          $this->view('patients/view_invoice',$data);
      }

      public function print_invoice($id)
      {
          if($id == 0)
          {
            $last_inv = $this->receptionModel->get_invoice_details_for_new();
            $data = [
            'last_inv'=>$last_inv
          ];
          }
          else
          {
            $last_inv = $this->receptionModel->get_last_invoice($id);
            $data = [
              'last_inv'=>$last_inv
            ];
          }
          $this->view('patients/print_invoice',$data);
      }

      public function all_visit1()
      {
          $lim = $_POST['lim'];
          $lim = (int)$lim;
          if($lim==9)
          {
            $off = $_POST['off'];
            $off = (int)$off;
            $all_visits = $this->receptionModel->get_all_visit_pat($lim,$off);
          }
          else
          {
            $inc = $_POST['inc'];
            $inc = (int)$inc;
            $lim = 9;
            $off = 9+(9*$inc);
            $all_visits = $this->receptionModel->get_all_visit_pat($lim,$off);
          }
          $all_orders_print = '';

          foreach ($all_visits as $key)
          {
            $opd_visit_id = $key->opd_visit_id;
            $opd_visit_id_gen = "$opd_visit_id,g";
            $opd_visit_id_lab = "$opd_visit_id,l";
            $opd_patient_id = $key->opd_patient_id;
            $opd_patient_name = $key->opd_patient_id;
            $opd_doctor_id = $key->opd_doctor_id;
            $opd_purpose = $key->opd_purpose;
            $visit_date_time = $key->visit_date_time;
            $opd_visit_fee = $key->opd_visit_fee;
            $pat_name = $this->receptionModel->patient_name($opd_patient_id);
            $doc_name = $this->receptionModel->doctor_name($opd_doctor_id);
            $all_orders_print.='<tr>
              <td style="text-align:left;">'.$opd_visit_id.'</td>
              <td style="text-align:left;">'.$opd_patient_id.'</td>
              <td style="text-align:left;">'.ucwords($pat_name).'</td>
              <td style="text-align:left;">Dr. '.ucwords($doc_name).'</td>
              <td style="text-align:left;">'.ucwords($opd_purpose).'</td>
              <td style="text-align:left;">'.date('d-m-Y h:i A', strtotime($visit_date_time)).'</td>
              <td style="text-align:left;">'.$opd_visit_fee.'</td>
            </tr>
            ';
          }
          echo $all_orders_print;
      }

      public function make_bill_op_visit($vis_id)
      {
          $vis_id = explode(',', $vis_id);
          $vis_id0 = $vis_id[0];
          $vis_id1 = $vis_id[1];
          $vis_id_det = $this->receptionModel->get_visit_details_id($vis_id0);
          foreach ($vis_id_det as $key)
          {
              $opi = $key->opd_patient_id;
              $odi = $key->opd_doctor_id;
              $ovi = $key->opd_visit_id;
          }
          $patient_name = $this->receptionModel->get_patient_by_id($opi);
          $doctor_name = $this->receptionModel->get_doctor_by_id($odi);
          $data = [
            'vis_id_det'=>$vis_id_det,
            'vis_id'=>$ovi,
            'doctor_name'=>$doctor_name,
            'patient_name'=>$patient_name,
            'ty'=>$vis_id1
          ];

          $this->view('patients/new_orders',$data);
      }

      public function add_patient()
      {
          $p_name = $_POST['p_name'];
          $gen = $_POST['gen'];
          $dob = $_POST['dob'];
          $age = $_POST['age'];
          $phone = $_POST['phone'];
          $email = $_POST['email'];
          $address = $_POST['address'];
          $success = $this->receptionModel->add_patient_db($p_name,$gen,$dob,$phone,$email,$address);
          if($success)
            echo "updated";
          else
            echo "error";
      }

      public function discharge()
      {
          $dis = $_POST['dis'];
          $v_id = $_POST['ser_id'];
          $success = $this->receptionModel->discharge_db($dis,$v_id);
          if($success)
            echo "discharged";
          else
            echo "error";

      }

      public function lab_reports_reception()
      {
          $lr = $this->receptionModel->get_lab_reports();
          $lab_reports = '';
          foreach ($lr as $key)
          {
            $lab_test_values = $key->lab_test_values;
            $lab_order_id = $key->lab_test_order_id;
            $lab_test_id = $key->lab_test_ref_id;
            $invoice_details = $this->receptionModel->get_search_orders($lab_order_id);
            foreach ($invoice_details as $test)
            {
                $patient_name = $test->invoice_name;
            }
            $lab_reports.='<tr>
              <td>'.$lab_order_id.'</td>
              <td>'.$patient_name.'</td>
              <td></td>
              <td></td>
              <td>
                <a href="'.URLROOT.'/patients/print_lab_reports/'.$lab_order_id.'"><button style="width: 72px" type="button" class="btn btn-success btn-xs m-b-5">Print Report</button></a>
              </td>
            </tr>';
          }
          echo $lab_reports;
      }


      public function print_lab_reports($id)
      {
          $last_inv = $this->receptionModel->get_last_invoice($id);
          $report = $this->receptionModel->get_reports_data($id);
          $data = [
            'last_inv'=>$last_inv,
            'report'=>$report
          ];
          $this->view('patients/print_lab_reports', $data);
      }

      public function patients_login()
      {
          $this->view('patients/patients_login');
      }

      public function login()
      {
          if(isset($_POST['username']))
          {
            $username = $_POST['username'];
            $password = $_POST['password'];
          
          $success = $this->userModel->patient_login_check($username, $password);
          

          if($success != 2 AND $success != 0)
          {
            
              foreach ($success as $test)
              {
                  $_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no'] = $test->patient_id;
                   $_SESSION['user_name'] = $test->patient_name;
                  $_SESSION['pat_photo'] = $test->patient_photo;
                 
              }
              
              redirect('patients/index');
          }
          elseif ($success == 2)
          {
              $data['login_check'] = 2;
              $this->view('patients/patients_login', $data);
          }
          elseif($success == 0)
          {
              $data['login_check'] = 0;
              $this->view('patients/patients_login', $data);
          }
        }
        else
        {
          $this->view('patients/patients_login');
        }

      }

      public function patient_logout()
      {
          unset($_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
          unset($_SESSION['user_name']);
          redirect('patients/patients_login');
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

              $success = $this->patientModel->update_password_db($cpass, $id, $files_array);
              if($success)
                redirect('patients/success_settings');
              else
                redirect('patients/upd_err_settings');           
          }
          else
          {
              redirect('patients/error_settings');
          }

      }
      public function settings()
      {
          $user_id =  $_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no'];
          $mem_data = $this->patientModel->get_mem_data($user_id);
          $mem_data1 = $this->patientModel->get_mem_data1($user_id);
          $data = [
            'mem_data' => $mem_data,
            'mem_data1' => $mem_data1 

          ];
          $this->view('patients/settings', $data);
      }
       public function all_prescription_pat()
    {
      $lim = $_POST['lim'];
      $lim = (int)$lim;
      if($lim==9)
      {
      $off = $_POST['off'];
      $off = (int)$off;
      $all_visits = $this->patientModel->get_all_prescription_pat($lim,$off);
      }
      else
      {
      $inc = $_POST['inc'];
      $inc = (int)$inc;
      $lim = 9;
      $off = 9+(9*$inc);
      $all_visits = $this->patientModel->get_all_prescription_pat($lim,$off);
      }
      $all_orders_print = '';

      foreach ($all_visits as $key)
      {
      $visit_id = $key->opd_visit_id;
      $pat = $this->receptionModel->get_patient_by_id($key->opd_patient_id);
      foreach ($pat as $key1)
      {
        $patient_name = $key1->patient_name;
      }
      $doc = $this->receptionModel->get_doctor_by_id($key->opd_doctor_id);
      foreach ($doc as $key2)
      {
        $doc_name = $key2->doctor_name;
      }
      $com = $key->opd_patient_id;
      $com .= ',';
      $com .= $visit_id;
      $all_orders_print.='<tr>
                  <td>'.$visit_id.'</td> 
                  <td>Dr. '.ucwords($doc_name).'</td>                               
                  <td>'.ucwords($patient_name).'</td>
                  <td>
                    <a href="'.URLROOT.'/patients/print_prescription/'.$visit_id.'"><button style="width: 100px" type="button" class="btn btn-info btn-xs m-b-5"> Print </button></a><br>
                  </td>
                </tr>';
      }
      echo $all_orders_print;
    }
    public function print_prescription($id)
      {
     
        if(isset($_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']))
        {
            $logo = $this->receptionModel->get_logo_details();
            $row = $this->patientModel->get_opd_data($id);
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
                      redirect('patients/index');             
                  }


            $data = [
              'logo' => $logo,
              'opd' => $row,
              'patient_name' =>$pat,
              'doc_name' => $doc
            ];
            $this->view('patients/print_prescription', $data);

        }
        else
        {
            redirect('users/login');
        }
      }


  }// end of class
 ?>
