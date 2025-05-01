<?php
  class Nurses extends Controller
  {
		public function __construct()
		{
		
		$this->nurseModel = $this->model('Nurse');
    $this->receptionModel = $this->model('Reception');
    $this->doctorModel = $this->model('Doctor');
		}

		public function index()
		{
			$this->view('nurses/index');
		}

		public function visits()
		{
			$this->view('nurses/visits');
		}

		public function admits()
		{
			$this->view('nurses/admits');
		}

		public function display_opd()
		{
			$dt = new DateTime("now", new DateTimeZone('Asia/Calcutta'));
			$dat = $dt->format('Y/m/d');
			$lim = $_POST['lim'];
			$lim = (int)$lim;
			if($lim==9)
			{
			  $off = $_POST['off'];
			  $off = (int)$off;
			  $all_opd = $this->nurseModel->get_all_opd_pat($lim,$off);
			}
			else
			{
			  $inc = $_POST['inc'];
			  $inc = (int)$inc;
			  $lim = 9;
			  $off = 9+(9*$inc);
			  $all_opd = $this->nurseModel->get_all_opd_pat($lim,$off);
			}
			$all_doctors_print = '';
			foreach ($all_opd as $key)
			{
			  $p_id = $key->opd_patient_id.','.$key->opd_visit_id;
			  $get_patient_det = $this->nurseModel->get_patient_by_id($p_id);
        $visit_status = $key->visit_status;
			  foreach ($get_patient_det as $key2)
			  {
			      $p_name = ucwords($key2->patient_name);
			      $phone = $key2->patient_phone;
			      $dob = $key2->patient_dob;
			      $diff = date_diff(date_create($dob), date_create($dat));
			  }
        if($visit_status!=0){
			  $all_doctors_print .= '<div class="col-sm-4">
              <div class="panel" style="height:150px;">
                  <div class="panel-body p-t-10" style="padding-top:0px!important;">
                      <div class="media-main">
                          <a class="pull-left" href="'.URLROOT.'/nurses/visit/'.$p_id.'">
                              <img class="thumb-lg img-circle bx-s" src="'.URLROOT.'/img/pat.jpg" alt="" style="margin-top:11px;">
                          </a>
                          <div class="info" style="margin-left:120px;">
                              <h4 style="color:#2980B9">'.$p_name.'</h4>
                              <p class="text-muted">Age - '.$diff->format('%y').'</p>
                              <p class="text-muted" style="margin-top:2px;">Patient ID - '.$key->opd_patient_id.'</p>
                              
                          </div>
                      </div>
                  </div>
              </div>
          </div>';
			}
    }
			echo $all_doctors_print;
		}

		public function display_doc_search()
		{
			$search = $_POST['search'];
			$all_doctors = $this->nurseModel->get_all_doctors_search($search);
			$all_doctors_print = '';
			foreach ($all_doctors as $key)
			{
			  $doc_name = ucwords($key->doctor_name);
			  $specialities = $key->doctor_speciality;
			  $all_doctors_print .= '<div class="col-sm-4">
			      <div class="panel" style="height:200px;">
			          <div class="panel-body p-t-10">
			              <div class="media-main">
			                  <a class="pull-left" href="#">
			                      <img class="thumb-lg img-circle bx-s" src="'.URLROOT.'/img/doc1.png" alt="">
			                  </a>
			                  <div class="info">
			                      <h4>Dr. '.$doc_name.'</h4>
			                      <p class="text-muted">'.$specialities.'</p>
			                  </div>
			              </div>
			              <div class="clearfix"></div>
			              <hr/>
			              <ul class="social-links list-inline p-b-10">
			                  <li>
			                      <a title="" data-placement="top" data-toggle="tooltip" class="tooltips" href="#" data-original-title="Facebook"><i class="fa fa-facebook"></i></a>
			                  </li>
			                  <li>
			                      <a title="" data-placement="top" data-toggle="tooltip" class="tooltips" href="#" data-original-title="Twitter"><i class="fa fa-twitter"></i></a>
			                  </li>
			                  <li>
			                      <a title="" data-placement="top" data-toggle="tooltip" class="tooltips" href="#" data-original-title="LinkedIn"><i class="fa fa-linkedin"></i></a>
			                  </li>
			              </ul>
			          </div>
			      </div>
			  </div>';
			}
			echo $all_doctors_print;
		}

		public function view_profile($id)
		{
			$p_data = $this->nurseModel->get_patient_by_id($id);
			$opd_data = $this->nurseModel->get_opd_patient_id2($id);
			$ipd_data = $this->nurseModel->get_all_ipd_addmission($id);
			$data = [
			'p_data' => $p_data,
			'opd_data' => $opd_data,
			'ipd_data' => $ipd_data
			];
			$this->view('nurses/view_profile', $data);
		}

		public function get_doc($id)
		{
			$doc_name = $this->nurseModel->get_doc_name($id);
			return $doc_name;
		}

		public function get_all_opd_data($v_id)
		{
			$opd_data = $this->nurseModel->get_opd_data($v_id);
			return $opd_data;
		}

		public function admission_check($pid)
		{
			$patient_data = $this->nurseModel->get_patient_data_m($pid);
			// $data = [
			//   'p_data' => $patient_data
			// ];
			foreach ($patient_data as $key)
			{
				$patient_id = $key->patient_id;
				$admit_id = $key->ipd_admit_id;
				$date_time = $key->admission_date_time;
				$new_date = date("Y-m-d",strtotime($date_time));
			}
			$ipd_data = $this->nurseModel->get_idp_data($admit_id);
			$this->nurseModel->ipd_day_insert($admit_id, $new_date);
			$admission = $this->nurseModel->get_ipd_days($admit_id);
			$main_ipd = $this->nurseModel->get_ipd_main_data($admit_id);
      $all_ipd = $this->nurseModel->get_all_ipd_addmission($patient_id);
      $reports = $this->doctorModel->get_reports_wrt_admit_id($admit_id);
      
			$data = [
				'p_data' => $patient_data,
				'admission' => $admission,
				'ipd' => $ipd_data,
				'main_ipd' => $main_ipd,
        'all_ipd' => $all_ipd,
        'reports' => $reports
			];
			$this->view('nurses/admission', $data);
		}

		public function display_ipd()
		{
			$lim = $_POST['lim'];
			$lim = (int)$lim;
			if($lim==9)
			{
			  $off = $_POST['off'];
			  $off = (int)$off;
			  $all_opd = $this->nurseModel->get_all_ipd_myipd($lim,$off);
			}
			else
			{
			  $inc = $_POST['inc'];
			  $inc = (int)$inc;
			  $lim = 9;
			  $off = 9+(9*$inc);
			  $all_opd = $this->nurseModel->get_all_ipd($lim,$off);
			}
			$all_doctors_print = '';
			foreach ($all_opd as $key)
			{
			  $bed = $key->ipd_bed_id;
			  $p_id = $key->ipd_patient_id;
        $discharge_date_time = $key->discharge_date_time;
			  $get_patient_det = $this->nurseModel->get_patient_by_id($p_id);
			  foreach ($get_patient_det as $key2)
			  {
			      $p_name = ucwords($key2->patient_name);
			      $phone = $key2->patient_phone;
			  }
        if(empty($discharge_date_time)){
			  $all_doctors_print .= '<div class="col-sm-4">
              <div class="panel" style="height:150px;">
                  <div class="panel-body p-t-10" style="padding-top:0px!important;">
                      <div class="media-main">
                          <a class="pull-left" href="'.URLROOT.'/nurses/admission_check/'.$p_id.'">
                              <img class="thumb-lg img-circle bx-s" src="'.URLROOT.'/img/pat.jpg" alt="" style="margin-top:11px;">
                          </a>
                          <a href="'.URLROOT.'/nurses/admission_check/'.$p_id.'">
                          <div class="info" style="margin-left:120px;">
                              <h4 style="color:#2980B9">'.$p_name.'</h4>
                              <p class="text-muted">Bed No. - '.$bed.'</p>
                              <p class="text-muted" style="margin-top:2px;">Patient ID - '.$p_id.'</p>
                          </div>
                      </div>
                      </a>
                  </div>
              </div>
          </div>';
			}
    }
			echo $all_doctors_print;
		}

		public function call_for_doc_name($ipd_doctor_id)
		{
			$name = $this->nurseModel->doctor_name($ipd_doctor_id);
			return $name;
		}

		 public function all_visit_ajax()
      {
          $lim = $_POST['lim'];
          $lim = (int)$lim;
          if($lim==9)
          {
            $off = $_POST['off'];
            $off = (int)$off;
            $all_visits = $this->nurseModel->get_op_visit($lim,$off);
          }
          else
          {
            $inc = $_POST['inc'];
            $inc = (int)$inc;
            $lim = 9;
            $off = 9+(9*$inc);
            $all_visits = $this->nurseModel->get_op_visit($lim,$off);
          }
          $all_orders_print = '';

          foreach ($all_visits as $key)
          {
            $visit_id = $key->opd_visit_id;
            $pat = $this->nurseModel->get_patient_by_id($key->opd_patient_id);
            foreach ($pat as $key1)
            {
              $patient_name = $key1->patient_name;
              $patient_id = $key1->patient_id;
            }
            $com = $key->opd_patient_id;
            $com .= ',';
            $com .= $visit_id;
            $all_orders_print.='<tr>
                                  <td>'.$visit_id.'</td>                                
                                  <td>'.ucwords($patient_name).'<small>('.$patient_id.')</small></td>
                                  <td>
                                      <a href="'.URLROOT.'/doctors/visit/'.$com.'"><button style="width: 100px" type="button" class="btn btn-info btn-xs m-b-5">Start Consultaion</button></a>
                                      <a href="'.URLROOT.'/doctors/visits/'.$com.'"><button style="width: 100px" type="button" class="btn btn-success btn-xs m-b-5">View Profile</button></a>
                                  </td>
                              </tr>';
          }
          echo $all_orders_print;
      }

      public function report_up()
      {
          $fi_name = $_POST['report_title'];
          $rep_id = $_POST['report_vid'];
          $f_name=$_FILES['files']['name'];
     
          $f_tmp=$_FILES['files']['tmp_name'];
          $size=$_FILES['files']['size'];
       
          $f_extension=explode('.', $f_name);
     
          $f_extension=strtolower(end($f_extension));
          $f_newfile=uniqid().'.'.$f_extension;
          $store="reports/".$f_newfile;
          move_uploaded_file($f_tmp, $store);
  
          $files_array = $f_newfile;
          $store="reports/";
          $data = [
            'file_name'=>$files_array,
            'path_name'=>$store,
            'report_id'=>$rep_id,
            'original_file_name'=>$fi_name,
          ];
          $this->nurseModel->save_report_db($data);
          $this->view('nurses/index');
      }
		 public function save_initial_diag()
      {
        $init_cond = $_POST['init_cond'];
        $first_diag = $_POST['first_diag'];
        $admit_id = $_POST['admit_id'];
        $pat_id = $_POST['pat_id'];
        $success = $this->nurseModel->save_initial_diag_db($init_cond, $first_diag, $admit_id);
        redirect('nurses/admission_check/'.$pat_id.'');
      }

        public function save_medication_particular($admit_id)
      {
          $patient_id = $_POST['pat'];
          echo $day_in = $_POST['day_par'];
          $medicine = implode(',', $_POST['medi']);

          $unit = implode(',', $_POST['uni']);
          echo $proc = $_SESSION['procedure_x'];
          $prescription = $medicine;
          $prescription .= '$$';
          $prescription .= $unit;
          $success = $this->nursesModel->update_medication_db($prescription,$proc,$admit_id,$day_in); 
          if($success)
          {
              echo "<script>alert('Updated');</script>";
          }
          else
          {
              echo "<script>alert('Error');</script>";
          }

          // redirect('nurses/admission_check/'.$patient_id.'');
      }

       public function delete_med()
      {
          $patient_id = $_POST['pat_id'];
          $curr_date = $_POST['curr_date']; 
          $position = $_POST['position'];
          $admit_id = $_POST['ad_id'];
          $success = $this->nurseModel->delete_med_db($curr_date, $position, $admit_id);
          if($success)
          {
              echo "<script>alert('Updated');</script>";
          }
          else
          {
              echo "<script>alert('Error');</script>";
          }
          redirect('nurses/admission_check/'.$patient_id.'');
      }

       public function update_days_details()
      {
          $pat_id = $_POST['pat_id'];
          $admit_id = $_POST['admit_id'];
          $day = $_POST['day'];
          $init_cond = $_POST['init_cond'];
          $fir_exm = $_POST['fir_exm'];
          $fir_inv = $_POST['fir_inv'];
          $fir_diag = $_POST['fir_diag'];
          $init_test = $_POST['init_test'];
          $init_notes = $_POST['init_notes'];
          $inst = $_POST['inst'];

          $success = $this->nurseModel->insert_days_details($day, $init_cond , $fir_exm, $fir_inv, $fir_diag, $init_test, $init_notes, $inst, $admit_id);
          if($success)
          {
            redirect('nurses/admission_check/'.$pat_id.'');
          }
          else
          {
            redirect('nurses/admission_check/'.$pat_id.'');
          }
      }
      

      public function save_medication($admit_id)
      {
          $patient_id = $_POST['pat'];
          $medicine = implode(',', $_POST['medicine']);
          $unit = implode(',', $_POST['unit']);
          $proc = $_SESSION['procedure_x'];
          $prescription = $medicine;
          $prescription .= '$$';
          $prescription .= $unit;
          
          $success = $this->nurseModel->save_medication_db($prescription,$proc,$admit_id);
          if($success)
          {
              echo "<script>alert('Updated');</script>";
          }
          else
          {
              echo "<script>alert('Error');</script>";
          }
          redirect('nurses/admission_check/'.$patient_id.'');
      }

       public function comorb()
      {
          $pat = $_POST['pat'];
          $admit_id = $_POST['admit_id'];
          $hyp = $_POST['hyp'];
          $dia = $_POST['dia'];
          $cad = $_POST['cad'];
          $cd = $_POST['cd'];
          $dys = $_POST['dys'];
          $hypth = $_POST['hypth'];
          $allrg = $_POST['allrg'];
          $success = $this->nurseModel->save_co_morbidities_db($pat,$hyp, $dia, $cad, $cd, $dys, $hypth, $allrg);
          redirect('nurses/admission_check/'.$pat.'');
      }
      public function patient_history()
      {
          $past = $_POST['past'];
          $fam = $_POST['fam'];
          $pat = $_POST['pat'];
          $success = $this->nurseModel->save_pat_his_db($past, $fam, $pat);
          redirect('nurses/admission_check/'.$pat.'');
      }
      public function procedure_session_x()
      {
        if (isset($_SESSION['procedure_x']))
        {
            $_SESSION['procedure_x'] .= $_POST['all_procedure'];
        }
        else
        {
            $_SESSION['procedure_x'] = $_POST['all_procedure'];
        }
        echo $_SESSION['procedure_x'];
      }

       public function print_prescription_ipd($id)
      {
        if(isset($_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']))
        {
            $logo = $this->nurseModel->get_logo_details();
            $row = $this->nurseModel->get_ipd_data_print($id);
            $all_ipd_days = $this->nurseModel->get_ipd_days($id);
            $reports = $this->nurseModel->get_reports_wrt_admit_id($id);
           
            foreach ($row as $key)
            {
                $pat = $this->nurseModel->get_patient_by_id($key->ipd_patient_id);
                $doc = $this->nurseModel->get_doctor_by_id($key->ipd_doctor_id);
                
            }
             $a=0;
             foreach ($row as $key)
            { 
              $a=$key->ipd_patient_id; 
             
            }

              $comor = $this->nurseModel->get_reports_comorb($a);

            $data = [
              'logo' => $logo,
              'ipd' => $row,
              'patient_name' =>$pat,
              'doc_name' => $doc,
              'all_ipd' => $all_ipd_days,
               'reports' => $reports,
               'comorb' => $comor
            ];
            $this->view('nurses/print_prescription_ipd', $data);

        }
        else
        {
            redirect('users/login');
        }
      }

      public function print_prescription($id)
      {
     
        if(isset($_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']))
        {
            $logo = $this->nurseModel->get_logo_details();
            $row = $this->nurseModel->get_opd_data($id);
            foreach ($row as $key)
            {
                $pat = $this->nurseModel->get_patient_by_id($key->opd_patient_id);
                $doc = $this->nurseModel->get_doctor_by_id($key->opd_doctor_id);
                $temp = $key->opd_prescription;
            }

                  foreach ($row as $key3)
                  {   
                      $op = $key3->opd_prescription;
                  }
                 if(empty($op))
                  {
                      redirect('nurses/index');             
                  }


            $data = [
              'logo' => $logo,
              'opd' => $row,
              'patient_name' =>$pat,
              'doc_name' => $doc
            ];
            $this->view('nurses/print_prescription', $data);

        }
        else
        {
            redirect('users/login');
        }
      }

       public function get_patients_data_to_print($ppid)
      {
          return $pdata = $this->nurseModel->get_patient_by_id($ppid);
      }
       public function get_auto_patient_name_for_header()
      {
          $cname = $_POST['query3'];
          $cust_list = $this->nurseModel->auto_patient_name($cname);
          $output3 = '';
          $output3 = '<ul class="list-unstyled">';
          foreach ($cust_list as $key)
          {
            $output3 .='<li class="head_sty"><p>'.ucwords($key->patient_name).''."(".''.$key->patient_id.''.")".'</p></li>';
          }
          $output3.='</ul>';
          echo $output3;
      }
       public function view_profile_patient($id)
      {
          $p_data = $this->nurseModel->get_patient_by_id($id);
          $opd_data = $this->nurseModel->get_opd_patient_id2($id);
          $ipd_data = $this->nurseModel->get_all_ipd_addmission($id);
          $data = [
            'p_data' => $p_data,
            'opd_data' => $opd_data,
            'ipd_data' => $ipd_data
          ];
          $this->view('nurses/view_profile_patient', $data);
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

              $success = $this->nurseModel->update_password_db($cpass, $id, $files_array);
              if($success)
                redirect('nurses/success_settings');
              else
                redirect('nurses/upd_err_settings');           
          }
          else
          {
              redirect('nurses/error_settings');
          }

      }
       public function settings()
      {
          $user_id = $_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no'];
          $mem_data = $this->nurseModel->get_mem_data($user_id);
          foreach ($mem_data as $key)
          {
              $_SESSION['user_photo_medhike_87_71_18_08_80_none_med_hi_ke_no'] = $key->mem_photo;
          }
          $data = [
            'mem_data' => $mem_data 
          ];
          $this->view('nurses/settings', $data);
      }

      public function visit($idc)
      {
        $id = explode(',', $idc);
        $pat_details = $this->receptionModel->get_patient_by_id($id[0]);
        $opd_pat = $this->doctorModel->get_opd_patient_id($id[0],$id[1]);
        $opd_pat2 = $this->doctorModel->get_opd_patient_id2($id[0]);
        $ipd_details = $this->doctorModel->get_ipd_past_admit_dates($id[0]);
        $ipd_details_numberofrows = $this->doctorModel->get_ipd_past_admit_dates_rows($id[0]);
        $a='';
          if($ipd_details_numberofrows<=0)
          {
            $a="No Record Found";
          }
          else
          {

          }

        $data = [
          'gen'=>$pat_details,
          'opd'=>$opd_pat,
          'opd2'=>$opd_pat2,
          'ipd_d' => $ipd_details,
          'idc'=>$idc,
          'a' => $a
        ];
        $this->view('nurses/visit',$data);  
      }

      public function myvisits()
      {
        $this->view('nurses/myvisits');
      }

      public function myadmits()
      {
        $this->view('nurses/myadmits');
      }

      public function getNurseService()
      {
          $enteredValue = $_POST['val'];
          $searchResult = $this->nurseModel->getNurseServiceDb($enteredValue);
          $output = "";
          $output .= '<ul class="list-unstyled">';
          foreach ($searchResult as $key)
          {
            $output .='<li class="ee forCursor" id="inpVal'.$key->service_id.'" onclick="putValueAndFadeOut('.$key->service_id.', '.$_POST["keyVal"].')">'.$key->service_name.''."(".''.$key->service_id.''.")".'</li>';
          }
          $output.='</ul>';
          echo $output;
      }

      public function saveNursingService()
      {
          $curr_date = $_POST['curr_date'];
          $ad_id = $_POST['ad_id'];
          $services = $_POST['services'];
          $pat_id = $_POST['pat_id'];
          $idArray = array();

          for ($i=0; $i < sizeof($services); $i++)
          { 
              $id = explode('(', $services[$i]);
              $idw = explode(')', $id[1]);

              array_push($idArray, $idw[0]);
          }
          $idArray = implode(',', $idArray);
          $this->nurseModel->saveIpdDaysNurseService($curr_date, $ad_id, $idArray);
          redirect('nurses/admission_check/'.$pat_id.'');
      }

      public function saveNursingServiceOpd()
      {
          $visitId = $_POST['visitId'];
          $nursingService = $_POST['nursingService'];
          $idArray = array();

          for ($i=0; $i < sizeof($nursingService); $i++)
          { 
              $id = explode('(', $nursingService[$i]);
              $idw = explode(')', $id[1]);

              array_push($idArray, $idw[0]);
          }
          $idArray = implode(',', $idArray);
          $this->nurseModel->saveNursingServiceDb($visitId, $idArray);
          redirect('nurses/visit/'.$_POST['patientId'].",".$visitId.'');
      }

      public function getServiceName($id)
      {
          $name = $this->nurseModel->getServiceNameDb($id);
          return $name;
      }

      public function operations()
      {
          $data = [
            'ot' => $this->nurseModel->getAllOperationsWithRespectToDoc(),
          ];
          $this->view('nurses/operations', $data);
      }

      public function operationDetails($id)
      {
          $data = [
              'ot' => $this->nurseModel->getOtDetailsById($id)
          ];
          $this->view('nurses/operationDetails', $data);
      }

    public function save_co_morbidities($id)
	  {
		  $hyp = $_POST['hyp'];
		  $dia_mel = $_POST['dia_mel'];
		  $cor_art_dis = $_POST['cor_art_dis'];
		  $cdpvd = $_POST['cdpvd'];
		  $dys = $_POST['dys'];
		  $hypo = $_POST['hypo'];
		  $oacd = $_POST['oacd'];
		  $idc = $_POST['idc'];

		  $success = $this->doctorModel->save_co_morbidities_db($id,$hyp,$dia_mel,$cor_art_dis,$cdpvd,$dys,$hypo,$oacd);
		  if($success)
		  redirect('nurses/visit/'.$idc.'');
		  else
		  redirect('nurses/visit/'.$idc.'');
	  }



	public function save_advice_for_discharge($patient_id, $admit_id)
	{
		$query = $this->doctorModel->update_discharge_advice($admit_id, $_POST['advice_discharge']);
		if($query)
		{
			redirect('nurses/admission_check/'.$patient_id.'');
		}
	}
  }
 ?>