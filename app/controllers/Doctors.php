<?php
  class Doctors extends Controller
  {
	  public function __construct()
	  {
		$this->doctorModel = $this->model('Doctor');
		$this->receptionModel = $this->model('Reception');
	  }

	  public function index()
	  {
		if(!isset($_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']))
		{
		  redirect('users/login');
		}
		else
		{
		  $op = $this->doctorModel->get_all_op_patients();
		  $jan = 1;
		  $feb = 0;
		  $mar = 2;
		  $apr = 0;
		  $may = 9;
		  $jun = 7;
		  $jul = 20;
		  $aug = 0;
		  $sep = 10;
		  $oct = 10;
		  $nov = 20;
		  $dec = 10;
		  foreach ($op as $key)
		  {
			  $visit_month = $key->visit_date_time;
			  $visit_month = substr($visit_month,0,7);
			  if($visit_month == '2019-01')
			  {
				  $jan++;
			  }
			  if($visit_month == '2019-02')
			  {
				  $feb++;
			  }
			  if($visit_month == '2019-03')
			  {
				  $mar++;
			  }
			  if($visit_month == '2019-04')
			  {
				  $apr++;
			  }
			  if($visit_month == '2019-05')
			  {
				  $may++;
			  }
			  if($visit_month == '2019-06')
			  {
				  $jun++;
			  }
			  if($visit_month == '2019-07')
			  {
				  $jul++;
			  }
			  if($visit_month == '2019-08')
			  {
				  $aug++;
			  }
			  if($visit_month == '2019-09')
			  {
				  $sep++;
			  }
			  if($visit_month == '2019-10')
			  {
				  $oct++;
			  }
			  if($visit_month == '2019-11')
			  {
				  $nov++;
			  }
			  if($visit_month == '2019-12')
			  {
				  $dec++;
			  }
		  }
		  $yearly = $this->doctorModel->getyearlyreportfrom_patient_op();
		  $yearly1 = $this->doctorModel->getyearlyreportfrom_patient_ip();
		  $yearly = $yearly + $yearly1;

		  $monthly = $this->doctorModel->getmonthlyreportfrom_patient_op();
		  $monthly1 = $this->doctorModel->getmonthlyreportfrom_patient_ip();
		  $monthly = $monthly + $monthly1;

		  $day = $this->doctorModel->getdayreportfrom_patient_op();
		  $day1 = $this->doctorModel->getdayreportfrom_patient_ip();
		  $day = $day + $day1;


		$data = [
		  'jan' => $jan,
		  'feb' => $feb,
		  'mar' => $mar,
		  'apr' => $apr,
		  'may' => $may,
		  'jun' => $jun,
		  'jul' => $jul,
		  'aug' => $aug,
		  'sep' => $sep,
		  'oct' => $oct,
		  'nov' => $nov,
		  'dec' => $dec,
		  'y' => $yearly,
		  'm' => $monthly,
		  'd' => $day

		];
		$this->view('doctors/index', $data);
		}
	  }

	  public function admissions()
	  {
		if(!isset($_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']))
		{
		  redirect('users/login');
		}
	  	$this->view('doctors/admissions');
	  }

	  public function view_patients()
	  {
		if(!isset($_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']))
		{
		  redirect('users/login');
		}
	  	$this->view('doctors/view_patients');
	  }

	  public function doc()
	  {
		if(!isset($_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']))
		{
		  redirect('users/login');
		}
	  	$this->view('doctors/doc');
	  }

	  public function instructions()
	  {
		if(!isset($_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']))
		{
		  redirect('users/login');
		}
		$data = 
		[
		  'all_ins' => $this->doctorModel->get_all_instructions_from_db()
		];
		$this->view('doctors/instructions', $data);
	  }

	  public function visit($idc)
	  {
		if(!isset($_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']))
		{
		  redirect('users/login');
		}
		$id = explode(',', $idc);
		$pat_details = $this->receptionModel->get_patient_by_id($id[0]);
		$opd_pat = $this->doctorModel->get_opd_patient_id($id[0],$id[1]);
		$opd_pat2 = $this->doctorModel->get_opd_patient_id2($id[0]);
		$ins = $this->doctorModel->get_all_instructions();
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
		  'idc'=>$idc,
		  'ipd_d' => $ipd_details,
		  'a' => $a,
		  'ins'=>$ins
		];
	  	$this->view('doctors/visit',$data);  
	  }

	  public function visits($idc)
	  {
		if(!isset($_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']))
		{
		  redirect('users/login');
		}
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
		$this->view('doctors/visits',$data);  
	  }

	  public function admission_check($pid)
	  {
		  $patient_data = $this->doctorModel->get_patient_data_m($pid);
		  foreach ($patient_data as $key)
		  {
			  $patient_id = $key->patient_id;
			  $admit_id = $key->ipd_admit_id;
			  $date_time = $key->admission_date_time;
			  $new_date = date("Y-m-d",strtotime($date_time));
		  }
		  $ipd_data = $this->doctorModel->get_idp_data($admit_id);
		  $this->doctorModel->ipd_day_insert($admit_id, $new_date);
		  $admission = $this->doctorModel->get_ipd_days($admit_id);
		  $main_ipd = $this->doctorModel->get_ipd_main_data($admit_id);
		  $all_ipd = $this->doctorModel->get_all_ipd_addmission($patient_id);
		  $reports = $this->doctorModel->get_reports_wrt_admit_id($admit_id);
		  $ins = $this->doctorModel->get_all_instructions();

		  $data = [
			'ins'=>$ins,
			'p_data' => $patient_data,
			'admission' => $admission,
			'ipd' => $admission,
			'main_ipd' => $main_ipd,
			'all_ipd' => $all_ipd,
			'reports' => $reports
		  ];
		  $this->view('doctors/admission', $data);
	  }

	  public function display_doc()
	  {
		$lim = $_POST['lim'];
		$lim = (int)$lim;
		if($lim==9)
		{
		  $off = $_POST['off'];
		  $off = (int)$off;
		  $all_doctors = $this->doctorModel->get_all_doctors($lim,$off);
		}
		else
		{
		  $inc = $_POST['inc'];
		  $inc = (int)$inc;
		  $lim = 9;
		  $off = 9+(9*$inc);
		  $all_doctors = $this->doctorModel->get_all_doctors($lim,$off);
		}
		$all_doctors_print = '';
		foreach ($all_doctors as $key)
		{
		  $doc_name = ucwords($key->doctor_name);
		  $specialities = $key->doctor_speciality;
		  $mem_id=$key->mem_id;
		  $doc_ph_email = $this->doctorModel->get_doc_ph_email($mem_id); 
		  $mail = $doc_ph_email->mem_email;
		  $phone = $doc_ph_email->mem_phone;
		  
		  $all_doctors_print .= '<div class="col-sm-4">
			  <div class="panel" style="height:250px; padding:15px!important;">
				  <div class="panel-body p-t-10" style="padding-top:14px!important;">
					  <div class="media-main">
						  <a class="pull-left" href="#">
							  <img class="thumb-lg img-circle bx-s" src="'.URLROOT.'/img/doc1.png" alt="">
						  </a>
						  <div class="info" style="margin-left:125px;">
							  <h4 style="color:#2980B9">Dr. '.$doc_name.'</h4>
							  <p class="text-muted">'.$specialities.'</p>
						  </div>
					  </div>
					  <div class="clearfix"></div>
					  <hr/>
					  <p class="text-muted"><i class="fa fa-mobile" aria-hidden="true" style="font-size:22px;"></i>&nbsp; '.$phone.'</p>
					  <p class="text-muted"><i class="fa fa-envelope" aria-hidden="true"></i>&nbsp; '.$mail.'</p>
					  <ul class="social-links list-inline p-b-10" style="float:right;">
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

	  public function getTheOperationDetails($id)
	  {
		  return $row = $this->doctorModel->getTheOperationDetailsDb($id);
	  }

	  public function display_doc_search()
	  {
		$search = $_POST['search'];
		$all_doctors = $this->doctorModel->get_all_doctors_search($search);
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

	  // opd

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
		  $all_opd = $this->doctorModel->get_all_opd($lim,$off);
		}
		else
		{
		  $inc = $_POST['inc'];
		  $inc = (int)$inc;
		  $lim = 9;
		  $off = 9+(9*$inc);
		  $all_opd = $this->doctorModel->get_all_opd($lim,$off);
		}
		$all_doctors_print = '';
		foreach ($all_opd as $key)
		{
		  $p_id = $key->opd_patient_id;
		  $opv= $this->doctorModel->get_all_opd_only_visit_id($p_id);
		  $p_id .= ','.$opv->opd_visit_id;//$p_id .= ','.$key->opd_visit_id;

		  $get_patient_det = $this->doctorModel->get_patient_by_id($p_id);
		  foreach ($get_patient_det as $key2)
		  {
			  $p_name = ucwords($key2->patient_name);
			  $phone = $key2->patient_phone;
			  $dob = $key2->patient_dob;
			  $diff = date_diff(date_create($dob), date_create($dat));
		  }
		  if($p_id==0)
		  {

		  }
		  else           
		  $all_doctors_print .= '<div class="col-sm-4">
			  <div class="panel" style="height:150px;">
				  <div class="panel-body p-t-10" style="padding-top:0px!important;">
					  <div class="media-main">
						  <a class="pull-left" href="'.URLROOT.'/doctors/visits/'.$p_id.'">
							  <img class="thumb-lg img-circle bx-s" src="'.URLROOT.'/img/pat.jpg" alt="" style="margin-top:11px;">
						  </a>
						  <div class="info" style="margin-left:120px;">
							  <a href="'.URLROOT.'/doctors/visits/'.$p_id.'" ><h4 style="color:#2980B9">'.$p_name.'</h4></a>
							  <p class="text-muted">Age - '.$diff->format('%y').'</p>
							  <p class="text-muted" style="margin-top:2px;">Patient ID - '.$key->opd_patient_id.'</p>
							  
						  </div>
					  </div>
				  </div>
			  </div>
		  </div>';
		}
		echo $all_doctors_print;
	  }


	  public function display_ipd()
	  {
		$lim = $_POST['lim'];
		$lim = (int)$lim;
		if($lim==9)
		{
		  $off = $_POST['off'];
		  $off = (int)$off;
		  $all_opd = $this->doctorModel->get_all_ipd($lim,$off);
		}
		else
		{
		  $inc = $_POST['inc'];
		  $inc = (int)$inc;
		  $lim = 9;
		  $off = 9+(9*$inc);
		  $all_opd = $this->doctorModel->get_all_ipd($lim,$off);
		}
		$all_doctors_print = '';
		foreach ($all_opd as $key)
		{
		  $p_id = $key->ipd_patient_id;
		  $bed = $key->ipd_bed_id;
		  $ipd_admit_id = $key->ipd_admit_id;
		  $admission_date_time = $key->admission_date_time;
		  $discharge_date_time = $key->discharge_date_time;
		  
		  $get_patient_det = $this->receptionModel->get_patient_by_id($p_id);
		  foreach ($get_patient_det as $key2)
		  {
			  $p_name = ucwords($key2->patient_name);
			  $phone = $key2->patient_phone;
		  }
		  if(empty($discharge_date_time))
		  {
		  $all_doctors_print .= '<div class="col-sm-4">
			  <div class="panel" style="height:170px;">
				  <div class="panel-body p-t-10" style="padding-top:0px!important;">
					  <div class="media-main" style="">
						  <a class="pull-left" href="'.URLROOT.'/doctors/admission_check/'.$p_id.'">
							  <img class="thumb-lg img-circle bx-s" src="'.URLROOT.'/img/pat.jpg" alt="" style="margin-top:11px;margin-left:0 px;">
						  </a>
						  <a href="'.URLROOT.'/doctors/admission_check/'.$p_id.'">
						  <div class="info" style="margin-right:0px;">
							  <h4 style="color:#2980B9">'.$p_name.'</h4>
							  <p class="text-muted">Bed No - '.$bed.' | Patient ID - '.$p_id.'</p>
							  <p class="text-muted" style="margin-top:2px;">Admit Date-'.$admission_date_time.'</p>
					  
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

	  public function display_ipd_search()
	  {
		$search = $_POST['search'];
		$all_doctors = $this->doctorModel->get_all_doctors_search($search);
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
							  <img class="thumb-lg img-circle bx-s" src="'.URLROOT.'/img/download.png" alt="">
						  </a>
						  <div class="info">
							  <h4>'.$doc_name.'</h4>
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
						  <li>
							  <a title="" data-placement="top" data-toggle="tooltip" class="tooltips" href="#" data-original-title="Skype"><i class="fa fa-skype"></i></a>
						  </li>
						  <li>
							  <a title="" data-placement="top" data-toggle="tooltip" class="tooltips" href="#" data-original-title="Message"><i class="fa fa-envelope-o"></i></a>
						  </li>
					  </ul>
				  </div>
			  </div>
		  </div>';
		}
		echo $all_doctors_print;
	  }

	  public function all_visit_ajax()
	  {
		  $lim = $_POST['lim'];
		  $lim = (int)$lim;
		  if($lim==9)
		  {
			$off = $_POST['off'];
			$off = (int)$off;
			$all_visits = $this->doctorModel->get_op_visit($lim,$off);
		  }
		  else
		  {
			$inc = $_POST['inc'];
			$inc = (int)$inc;
			$lim = 9;
			$off = 9+(9*$inc);
			$all_visits = $this->doctorModel->get_op_visit($lim,$off);
		  }
		  $all_orders_print = '';

		  foreach ($all_visits as $key)
		  {
			$visit_id = $key->opd_visit_id;
			$pat = $this->receptionModel->get_patient_by_id($key->opd_patient_id);
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

	  public function save_present_visit()
	  {
		$allergy_cond = $_POST['allergy_cond'];
		$pres_cond = $_POST['pres_cond'];
		$exam_det = $_POST['exam_det'];
		$inv_det = $_POST['inv_det'];
		$other_inf = $_POST['other_inf'];
		$diag = $_POST['diag'];
		$medicine = implode(',', $_POST['medicine']);
		$unit = implode(',', $_POST['unit']);
		$proc = $_SESSION['procedure'];
		$prescription = $medicine;
		$prescription .= '$$';
		$prescription .= $unit;
		$inst = $_POST['inst'];
		$tst_adv = $_POST['txt_adv'];
		$idc = $_POST['idc'];
		$id = explode(',', $idc);
		$opdid  = $id[1];
		$pid = $id[0];
		$f_up_date = $_POST['f_up_date'];
		$n_reg_fee = $_POST['n_reg_fee'];
		$d1="";
		$a="";
		$advice = $_POST['advice_for_patient'];
		// creating active sales order start
		$p_prescription = '';
		$p_prescription1 = '';
		$p_prescription = $prescription;
		$p_prescription2 = '';
		$p_prescription = explode("$$",$p_prescription);
		$p_prescription1 = $p_prescription[0];
		$p_prescription2 = $p_prescription[1];
		$p_prescription1 = explode(',',$p_prescription1);
		$p_prescription2 = explode(',',$p_prescription2);
		$item_name = array();
		$item_id = array();
		$item_qty_by_doc = array();
		$item_receive = array();
		$item_qty = array();
		$item_selling_price = array();
		$temp = '';
		$temp1 = '';
		$item_single = '';
		$item_row_total = array();
		$sub_total =0;
		$grand_total = 0;
		for ($ii=0; $ii <sizeof($p_prescription1); $ii++) 
		{ 
			$temp = explode("(", $p_prescription1[$ii]);
			$item_name[] = $temp[0];
			$temp1 = explode(")", $temp[1]);
			$item_id[] = $temp1[0];
			$item_single = $this->doctorModel->get_item_by_id($temp1[0]);
			$item_receive[] = $item_single->receive;
			$item_qty[] = $item_single->qty;
			$item_selling_price[] = $item_single->selling_price;
			$item_qty_by_doc[] = $p_prescription2[$ii];		
			$item_row_total[] = (int)$p_prescription2[$ii] * (int)$item_single->selling_price;		
			$sub_total = $sub_total + (int)$p_prescription2[$ii] * (int)$item_single->selling_price;
		}
		$tempId = md5(uniqid());
		$item_id = implode("|||", $item_id);
		$item_name = implode("|||",$item_name);
		$item_receive = implode("|||", $item_receive);
		$item_qty = implode("|||", $item_qty);
		$item_qty_by_doc = implode("|||", $item_qty_by_doc);
		$item_selling_price = implode("|||", $item_selling_price);
		$item_row_total = implode("|||", $item_row_total);
		$sub_total = (int)$sub_total + 0;
		$grand_total = (int)$sub_total + 0;
		$data = [ 
					'item_id' => $item_id,
					'item_name' => $item_name,
					'item_receive' => $item_receive,
					'item_qty' => $item_qty,
					'item_qty_by_doc' => $item_qty_by_doc,
					'item_selling_price' => $item_selling_price,
					'item_row_total' => $item_row_total,
					'sub_total' => $sub_total,
					'grand_total' => $grand_total,
					'tempId' => $tempId,
			 	];
		$this->doctorModel->add_stock_out_order_details_doc($data);
		// creating active sales order end
		if(!empty($tst_adv))
		{
						foreach (explode('(', $tst_adv) as $key) {
						  $x=$key;
						}
						$y = strrev($x);

						foreach (explode(')', $y) as $key) {
						  $z=$key;
						}
						$w = strrev($z);

						$test_k = $this->doctorModel->findtestnamewithid($w);
						$n = $test_k->lab_test_name;
					   
						 $test_price_check = $this->doctorModel->find_price_from_test_avaliable_id($w);
						 if(!empty($test_price_check))
						 {
							$test_price = $this->doctorModel->find_price_from_test_avaliable($w);
							 $a = $w.",1,".$n.",".$test_price->test_cost.",";
						 }
						 else
						 {
							 $a = $w.",1,".$n.",";
						 }
						 
						 $opdidwithop = "OP".$opdid;
						 //$b= $this->doctorModel->getpatientname($pid);
						 $b= $this->doctorModel->getpatientname($pid);
						 // $c1="OP".$opip_id;
						 $d1 = $b->patient_name."|".$pid;
						 $e1 = $_SESSION['user_name']."|".$_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no'];
						 
						 $data = [ 
							  'invoice_item' => $a,
							  // 'opip_id' => $c1,
						 
							  'invoice_name' => $d1,
							  'invoice_doctor' => $e1,
							  'opdidwithop' => $opdidwithop
							  ];  

						 $r1 = $this->doctorModel->addtstadvtoinvoice($data);
						 
						 $data2 = [ 
							  'invoice_item' => $a,
							  'invoice_name' => $d1,
							  'invoice_doctor' => $e1,
							  'opdidwithop' => $opdidwithop
							  ];  

						 $r2 = $this->doctorModel->get_last_entered_id($data2);
						 
						 $r3 = $r2->invoice_id;

						 $data1=[
								  'lab_test_ref_id'=>$w,
								  'lab_test_order_id'=>$r3
								 ];                             
						 $r2 = $this->doctorModel->addtstadvtolab_test($data1);
		}

		$success = $this->doctorModel->save_present_visit_db($allergy_cond, $pres_cond, $exam_det, $inv_det, $other_inf, $diag, $inst, $tst_adv, $f_up_date, $n_reg_fee, $prescription, $opdid, $pid, $proc, $advice);
		$d1 = $_SESSION['user_name'];
		$success2 = $this->doctorModel->save_active_invoice($medicine,$pid,$d1);
		
	   if($success && $success2)
		 redirect('doctors/index');
	   else
		  redirect('doctors/visit/'.$idc.'');
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
		  redirect('doctors/visit/'.$idc.'');
		  else
		  redirect('doctors/visit/'.$idc.'');
	  }

	  public function save_pat_his($id)
	  {
		  $past_his = implode(',', $_POST['past_his']);
		  $fam_his = $_POST['fam_his'];
		  $idc = $_POST['idc'];
		  $mon = implode(',', $_POST['mon']);
		  $year = implode(',', $_POST['year']);

		  $success = $this->doctorModel->save_pat_his_db($past_his,$fam_his,$id, $mon, $year);
		  if($success)
		  redirect('doctors/visit/'.$idc.'');
		  else
		  redirect('doctors/visit/'.$idc.'');
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
		  $this->doctorModel->save_report_db($data);
		  $this->view('doctors/index');
	  }

	  public function view_profile($id)
	  {
		if(!isset($_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']))
		{
		  redirect('users/login');
		}
		$p_data = $this->receptionModel->get_patient_by_id($id);
		$opd_data = $this->doctorModel->get_opd_patient_id2($id);
		$ipd_data = $this->doctorModel->get_all_ipd_addmission($id);
		$data = [
		  'p_data' => $p_data,
		  'opd_data' => $opd_data,
		  'ipd_data' => $ipd_data
		];
		$this->view('doctors/view_profile', $data);
	  }

	  public function get_doc($id)
	  {
		$doc_name = $this->doctorModel->get_doc_name($id);
		return $doc_name;
	  }

	  public function get_count()
	  {
		$send = '';
		$count = $this->doctorModel->get_count_db();
		$send .='<h2 style="color: white" class="m-0 counter">'.$count.'</h2>';
		echo $send;
	  }
	  public function all_prescription_ph()
	  {
		  $lim = $_POST['lim'];
		  $lim = (int)$lim;
		  if($lim==9)
		  {
			$off = $_POST['off'];
			$off = (int)$off;
			$all_visits = $this->doctorModel->get_all_prescription_ph($lim,$off);
		  }
		  else
		  {
			$inc = $_POST['inc'];
			$inc = (int)$inc;
			$lim = 9;
			$off = 9+(9*$inc);
			$all_visits = $this->doctorModel->get_all_prescription_ph($lim,$off);
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
			  $doc_name = "Dr ";
			  $doc_name .= $key2->doctor_name;
			}
			if(!isset($doc_name))
			{
			  $doc_name = "No Doctor";
			}
			if(!isset($key->visit_date_time))
			{
			  $dt = "";
			}
			else
			{
			  $dt = $key->visit_date_time;
			}
			$com = $key->opd_patient_id;
			$com .= ',';
			$com .= $visit_id;
			$all_orders_print.='<tr>
								  <td style="text-align:left;">'.$visit_id.'</td> 
								  <td style="text-align:left;">'.ucwords($doc_name).'</td>                               
								  <td style="text-align:left;">'.ucwords($patient_name).'</td>
								  <td style="text-align:left;">'.date('d-m-Y h:i A', strtotime($dt)).'</td>
								  <td>
									  <a href="'.URLROOT.'/pharmacies/print_prescription/'.$visit_id.'"><button style="width: 100px" type="button" class="btn btn-info btn-xs m-b-5"> Print </button></a><br>
								  </td>
							  </tr>';
		  }
		  echo $all_orders_print;
	  }

	  public function all_prescription()
	  {
		  $lim = $_POST['lim'];
		  $lim = (int)$lim;
		  if($lim==9)
		  {
			$off = $_POST['off'];
			$off = (int)$off;
			$all_visits = $this->doctorModel->get_all_prescription($lim,$off);
		  }
		  else
		  {
			$inc = $_POST['inc'];
			$inc = (int)$inc;
			$lim = 9;
			$off = 9+(9*$inc);
			$all_visits = $this->doctorModel->get_all_prescription($lim,$off);
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
			  $doc_name = "Dr ";
			  $doc_name .= $key2->doctor_name;
			}
			if(!isset($doc_name))
			{
			  $doc_name = "No Doctor";
			}
			if(!isset($key->visit_date_time))
			{
			  $dt = "";
			}
			else
			{
			  $dt = $key->visit_date_time;
			}
			$com = $key->opd_patient_id;
			$com .= ',';
			$com .= $visit_id;
			$all_orders_print.='<tr>
								  <td style="text-align:left;">'.$visit_id.'</td> 
								  <td style="text-align:left;">'.ucwords($doc_name).'</td>                               
								  <td style="text-align:left;">'.ucwords($patient_name).'</td>
								  <td style="text-align:left;">'.date('d-m-Y h:i A', strtotime($dt)).'</td>
								  <td>
									  <a href="'.URLROOT.'/doctors/print_prescription/'.$visit_id.'"><button style="width: 100px" type="button" class="btn btn-info btn-xs m-b-5"> Print </button></a><br>
								  </td>
							  </tr>';
		  }
		  echo $all_orders_print;
	  }

	  public function all_prescription_pat()
	  {
		  $lim = $_POST['lim'];
		  $lim = (int)$lim;
		  if($lim==9)
		  {
			$off = $_POST['off'];
			$off = (int)$off;
			$all_visits = $this->doctorModel->get_all_prescription_pat($lim,$off);
		  }
		  else
		  {
			$inc = $_POST['inc'];
			$inc = (int)$inc;
			$lim = 9;
			$off = 9+(9*$inc);
			$all_visits = $this->doctorModel->get_all_prescription_pat($lim,$off);
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
									  <a href="'.URLROOT.'/receptions/print_prescription/'.$visit_id.'"><button style="width: 100px" type="button" class="btn btn-info btn-xs m-b-5"> Print </button></a><br>
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
			$all_visits = $this->doctorModel->get_all_prescription_admit($lim,$off);
		  }
		  else
		  {
			$inc = $_POST['inc'];
			$inc = (int)$inc;
			$lim = 9;
			$off = 9+(9*$inc);
			$all_visits = $this->doctorModel->get_all_prescription_admit($lim,$off);
		  }
		  $all_orders_print = '';

		  foreach ($all_visits as $key)
		  { 
			$visit_all_ipdid=$key->ipd_patient_id;
			$visit_id = $key->ipd_admit_id;
			$pat = $this->receptionModel->get_patient_by_id($key->ipd_patient_id);
			foreach ($pat as $key1)
			{
			  $patient_name = $key1->patient_name;
			}
			$doc = $this->receptionModel->doctor_name($key->ipd_doctor_id);
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
			$this->view('doctors/print_prescription', $data);

		}
		else
		{
			redirect('users/login');
		}
	  }

	  public function print_prescription_ipd($id)
	  {
		if(isset($_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']))
		{
			$logo = $this->receptionModel->get_logo_details();
			$row = $this->doctorModel->get_ipd_data_print($id);
			$all_ipd_days = $this->doctorModel->get_ipd_days($id);
			$reports = $this->doctorModel->get_reports_wrt_admit_id($id);
		   
			foreach ($row as $key)
			{
				$pat = $this->receptionModel->get_patient_by_id($key->ipd_patient_id);
				$doc = $this->receptionModel->get_doctor_by_id($key->ipd_doctor_id);
				
			}
			 $a=0;
			 foreach ($row as $key)
			{ 
			  $a=$key->ipd_patient_id; 
			 
			}

			  $comor = $this->doctorModel->get_reports_comorb($a);

			$data = [
			  'logo' => $logo,
			  'ipd' => $row,
			  'patient_name' =>$pat,
			  'doc_name' => $doc,
			  'all_ipd' => $all_ipd_days,
			   'reports' => $reports,
			   'comorb' => $comor
			];
			$this->view('doctors/print_prescription_ipd', $data);

		}
		else
		{
			redirect('users/login');
		}
	  }

	  public function prescription_search_by_id()
	  {
		  $visit_id = $_POST['visit_id'];
		  $all_visits = $this->doctorModel->prescription_search_by_id_db($visit_id);
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
			  $doc_name = "Dr ";
			  $doc_name .= $key2->doctor_name;
			}
			if(!isset($doc_name))
			{
			  $doc_name = "No Doctor";
			}
			if(!isset($key->visit_date_time))
			{
			  $dt = "";
			}
			else
			{
			  $dt = $key->visit_date_time;
			}
			$com = $key->opd_patient_id;
			$com .= ',';
			$com .= $visit_id;
			$all_orders_print.='<tr>
								  <td style="text-align:left;">'.$visit_id.'</td> 
								  <td style="text-align:left;">'.ucwords($doc_name).'</td>                               
								  <td style="text-align:left;">'.ucwords($patient_name).'</td>
								  <td style="text-align:left;">'.date('d-m-Y h:i A', strtotime($dt)).'</td>
								  <td>
									  <a href="'.URLROOT.'/receptions/print_prescription/'.$visit_id.'"><button style="width: 100px" type="button" class="btn btn-info btn-xs m-b-5"> Print </button></a><br>
								  </td>
							  </tr>';
		  }
		  echo $all_orders_print;
	  }

	  public function prescription_search_by_name()
	  {
		  $pat_name = $_POST['pat_name'];
		  $all_visits = $this->doctorModel->prescription_search_by_name_db($pat_name);
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
			  $doc_name = "Dr ";
			  $doc_name .= $key2->doctor_name;
			}
			if(!isset($doc_name))
			{
			  $doc_name = "No Doctor";
			}
			if(!isset($key->visit_date_time))
			{
			  $dt = "";
			}
			else
			{
			  $dt = $key->visit_date_time;
			}
			$com = $key->opd_patient_id;
			$com .= ',';
			$com .= $visit_id;
			$all_orders_print.='<tr>
								  <td style="text-align:left;">'.$visit_id.'</td> 
								  <td style="text-align:left;">'.ucwords($doc_name).'</td>                               
								  <td style="text-align:left;">'.ucwords($patient_name).'</td>
								  <td style="text-align:left;">'.date('d-m-Y h:i A', strtotime($dt)).'</td>
								  <td>
									  <a href="'.URLROOT.'/receptions/print_prescription/'.$visit_id.'"><button style="width: 100px" type="button" class="btn btn-info btn-xs m-b-5"> Print </button></a><br>
								  </td>
							  </tr>';
		  }
		  echo $all_orders_print;
	  }

	  public function prescription_search_by_phone()
	  {
		  $pat_name = $_POST['pat_name'];
		  $all_visits = $this->doctorModel->prescription_search_by_phone_db($pat_name);
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
			  $doc_name = "Dr ";
			  $doc_name .= $key2->doctor_name;
			}
			if(!isset($doc_name))
			{
			  $doc_name = "No Doctor";
			}
			if(!isset($key->visit_date_time))
			{
			  $dt = "";
			}
			else
			{
			  $dt = $key->visit_date_time;
			}
			$com = $key->opd_patient_id;
			$com .= ',';
			$com .= $visit_id;
			$all_orders_print.='<tr>
								  <td style="text-align:left;">'.$visit_id.'</td> 
								  <td style="text-align:left;">'.ucwords($doc_name).'</td>                               
								  <td style="text-align:left;">'.ucwords($patient_name).'</td>
								  <td style="text-align:left;">'.date('d-m-Y h:i A', strtotime($dt)).'</td>
								  <td>
									  <a href="'.URLROOT.'/receptions/print_prescription/'.$visit_id.'"><button style="width: 100px" type="button" class="btn btn-info btn-xs m-b-5"> Print </button></a><br>
								  </td>
							  </tr>';
		  }
		  echo $all_orders_print;
	  }

	  public function procedure_session()
	  {
		$pos = $_POST['position'];
		if (isset($_SESSION['procedure']))
		{
			$check = explode('$&$x', $_SESSION['procedure']);
			if(isset($check[$pos]))
			{
				$check[$pos] = $_POST['all_procedure'];
				$_SESSION['procedure'] = implode('$&$x', $check);
			}
			else
			{
			  $_SESSION['procedure'] .= $_POST['all_procedure'];
			}
		}
		else
		{
			$_SESSION['procedure'] = $_POST['all_procedure'];
		}
		echo $_SESSION['procedure'];
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
		echo ' ';
	  }

	  public function get_all_opd_data($v_id)
	  {
		  $opd_data = $this->doctorModel->get_opd_data($v_id);
		  return $opd_data;
	  }

	  public function new_member1($d_id)
	  {
		  $mem_list = $this->receptionModel->get_member_by_id($d_id);
		  $data = [
			'mem_list'=>$mem_list
		  ];
		  $this->view('doctors/settings_doc',$data);
	  }

	  public function get_auto_patient_name()
	  {
		$cname = $_POST['query3'];
		$cust_list = $this->doctorModel->auto_patient_name_doc($cname);
		$idArray = array();
		$opdPat = $this->doctorModel->getOpdPatByDoc();
		$ipdPat = $this->doctorModel->getIpdPatByDoc();
		foreach ($opdPat as $key) 
		{
			$idArray[] = $key->opd_patient_id;
		}
		foreach ($ipdPat as $key1) 
		{
			$idArray[] = $key1->ipd_patient_id;
		}
		$output3 = '';
		$output3 = '<ul class="list-unstyled">';
		foreach ($cust_list as $key)
		{
			if(in_array($key->patient_id, $idArray))
			{
				$output3 .='<li class="ee">'.$key->patient_name.'|'.$key->patient_id.'</li>';
			}
		}
		$output3.='</ul>';
		echo $output3;
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

		  $success = $this->doctorModel->insert_days_details($day, $init_cond , $fir_exm, $fir_inv, $fir_diag, $init_test, $init_notes, $inst, $admit_id);
		  if($success)
		  {
			redirect('doctors/admission_check/'.$pat_id.'');
		  }
		  else
		  {
			redirect('doctors/admission_check/'.$pat_id.'');
		  }
	  }

	  public function save_medication($admit_id)
	  {
		  $patient_id = $_POST['pat'];
		  $medicine = implode(',', $_POST['medicine']);
		  $unit = implode(',', $_POST['unit']);
		  $proc = $_SESSION['procedure'];
		  $prescription = $medicine;
		  $prescription .= '$$';
		  $prescription .= $unit;
		  $success = $this->doctorModel->save_medication_db($prescription,$proc,$admit_id);
		  if($success)
		  {
			  echo "<script>alert('Updated');</script>";
		  }
		  else
		  {
			  echo "<script>alert('Error');</script>";
		  }
		  redirect('doctors/admission_check/'.$patient_id.'');
	  }

	  public function save_medication_particular($admit_id)
	  {
		  $patient_id = $_POST['pat'];
		  echo $day_in = $_POST['day_par'];
		  $medicine = implode(',', $_POST['medi']);
		  $unit = implode(',', $_POST['uni']);
		  echo $proc = $_SESSION['procedure'];
		  $prescription = $medicine;
		  $prescription .= '$$';
		  $prescription .= $unit;
		  $success = $this->doctorModel->update_medication_db($prescription,$proc,$admit_id,$day_in);
		  if($success)
		  {
			  echo "<script>alert('Updated');</script>";
		  }
		  else
		  {
			  echo "<script>alert('Error');</script>";
		  }

		  redirect('doctors/admission_check/'.$patient_id.'');
	  }

	  public function delete_med()
	  {
		  $patient_id = $_POST['pat_id'];
		  $curr_date = $_POST['curr_date']; 
		  $position = $_POST['position'];
		  $admit_id = $_POST['ad_id'];
		  $success = $this->doctorModel->delete_med_db($curr_date, $position, $admit_id);
		  if($success)
		  {
			  echo "<script>alert('Updated');</script>";
		  }
		  else
		  {
			  echo "<script>alert('Error');</script>";
		  }
		  redirect('doctors/admission_check/'.$patient_id.'');
	  }

	  public function save_initial_diag()
	  {
		$init_cond = $_POST['init_cond'];
		$first_diag = $_POST['first_diag'];
		$admit_id = $_POST['admit_id'];
		$pat_id = $_POST['pat_id'];
		$success = $this->doctorModel->save_initial_diag_db($init_cond, $first_diag, $admit_id);
		redirect('doctors/admission_check/'.$pat_id.'');
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
		  $success = $this->doctorModel->save_co_morbidities_db($pat,$hyp, $dia, $cad, $cd, $dys, $hypth, $allrg);
		  redirect('doctors/admission_check/'.$pat.'');
	  }

	  public function patient_history($id)
	  {
			$past_his = implode(',', $_POST['past_his']);
			$fam_his = $_POST['fam'];
			$idc = $_POST['idc'];
			$mon = implode(',', $_POST['mon']);
			$year = implode(',', $_POST['year']);

			$success = $this->doctorModel->save_pat_his_db($past_his,$fam_his,$id, $mon, $year);
			redirect('doctors/admission_check/'.$id.'');
	  }

	  public function call_for_doc_name($ipd_doctor_id)
	  {
		  $name = $this->receptionModel->doctor_name($ipd_doctor_id);
		  return $name;
	  }

	  public function get_patients_data_to_print($ppid)
	  {
		  return $pdata = $this->receptionModel->get_patient_by_id($ppid);
	  }


	  public function getTests()
	  {
		  $search = $_POST['search'];
		  $ad = $this->doctorModel->get_all_tests($search);
		  foreach ($ad as $key)
		  {
			  $response[] = array("value"=>$key->lab_test_name.$key->lab_test_value_id,"label"=>ucwords($key->lab_test_name).'('.$key->lab_test_value_id.')');
		  }
		  echo json_encode($response);
	  }


	  public function at_test()
	  {
		  $search = $_POST['search'];
		  $ad = $this->doctorModel->get_patient_by_name_like($search);
		  foreach ($ad as $key)
		  {
			  $response[] = array("value"=>$key->patient_id.$key->patient_name,"label"=>ucwords($key->patient_name).'('.$key->patient_id.')');
		  }
		  echo json_encode($response);
	  }

	  public function autocomplete_ip_patients1()
	  {
		  $cname = $_POST['search'];
		  $cust_list = $this->doctorModel->get_ip_patients($cname);
		  foreach ($cust_list as $key)
		  {
			$response[] = array("value"=>ucwords($key->patient_name).'('.$key->patient_id.')',"label"=>ucwords($key->patient_name).'('.$key->patient_id.')');
		  }
		  echo json_encode($response);
	  }

	public function ot_details()
	{   
		$ip_op_doc_ref_id = $_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no'];
		$pat_id = $_POST['pat_id'];
		$pid = $_POST['pid'];
		$ot_date = $_POST['ot_date'];
		$ot_name = $_POST['ot_name'];
		$ot_des = $_POST['ot_des'];
		$this->doctorModel->ot_details_db($pid, $ip_op_doc_ref_id, $ot_date, $ot_name, $ot_des, $pat_id);
		redirect('doctors/admission_check/'.$pat_id.'');
		// redirect('doctors/admissions');
	}

	  public function save_instruction()
	  {
		  $ins_category = $_POST['ins_category'];
		  $ins_title = $_POST['ins_title'];
		  $ins_body = $_POST['ins_body'];
		  $check = $_POST['check'];
		  if($check == 1)
		  {
			  $success = $this->doctorModel->save_instruction_to_db($ins_category, $ins_title, $ins_body);
		  }
		  elseif ($check == 2)
		  {
			  $ins_id = $_POST['ins_id'];
			  $success = $this->doctorModel->update_instruction_to_db($ins_category, $ins_title, $ins_body, $ins_id);
		  }
		  
		  if($success)
		  {
			  $data = [
				'all_ins' => $this->doctorModel->get_all_instructions_from_db()
			  ];
			  $this->view('doctors/instructions', $data);
		  }
		  else
		  {
			  redirect('doctors/instructions');
		  }
	  }

	  public function edit_instruction($ins_id)
	  {
		  $data = [
			'all_ins' => $this->doctorModel->get_all_instructions_from_db(),
			'editing_ins' => $this->doctorModel->get_ins_having_id($ins_id)
		  ];
		  $this->view('doctors/instructions', $data);
	  }

	  public function delete_instruction($id)
	  {
		  $success = $this->doctorModel->delete_instruction_from_db($id);
		  if($success)
		  {
			  redirect('doctors/instructions');
		  }
		  else
		  {
			  redirect('doctors/instructions');
		  }
	  }

	  public function autocomplete_ip_patients()
	  {
		  $cname = $_POST['query3'];
		  $cust_list = $this->doctorModel->get_ip_patients($cname);
		  $output3 = '';
		  $output3 = '<ul class="list-unstyled">';
		  foreach ($cust_list as $key)
		  {
			$output3 .='<li class="ipd_val">'.ucwords($key->patient_name).'('.$key->patient_id.''.')'.'</li>';
		  }
		  $output3.='</ul>';
		  echo $output3;
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

		  $success = $this->doctorModel->doc_upload_jq_db($files_array);
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
		  $idType = $_POST['idType'];
		  $success = $this->doctorModel->save_other_upload_details_db($ip_id, $rep_tit, $idType);
		  if($success)
		  {
			  echo true;
		  }
		  else
		  {
			  echo false;
		  }
	  }

	  public function save_other_upload_details_ip()
	  {
		  $ip_id = $_POST['ip_rep'];
		  $rep_tit = $_POST['rep_tit'];
		  $success = $this->doctorModel->save_other_upload_details_ip_db($ip_id, $rep_tit);
		  if($success)
		  {
			  echo true;
		  }
		  else
		  {
			  echo false;
		  }
	  }

	  public function get_ins_of_cat()
	  {
		  $ins_cat = $_POST['cat'];
		  $ins_data = "";
		  $ins_cat = $this->doctorModel->get_ins_of_cat_db($ins_cat);
		  foreach ($ins_cat as $key)
		  {
			  $ins_data .= "<div class='card-body' data-dismiss='modal' style='background-color: #EAF2F8; border: 1px solid #EAF2F8; border-radius:3px; cursor: pointer;' onclick='display_ins_in_textarea(".json_encode($key->instruction).")'><p style='margin:10px;'>".ucwords($key->instruction_title)."</p></div><br>";
		  }
		  echo $ins_data;
	  }

	  public function un_dis()
	  {
		$ad_id = $_POST['ad_id'];
		$success = $this->doctorModel->change_dis_status($ad_id);
		if($success)
		{
		  echo "Updated";
		}
		else
		{
		  echo "Error";
		}
		
	  }

	  public function download_rep($fname1)
	  {
		  $file1 = urldecode($fname1); // Decode URL-encoded string
		  $filepath1= "reports/" . $file1;
		  
		  // Process download
		  if(file_exists($filepath1)) {
			  header('Content-Description: File Transfer');
			  header('Content-Type: application/octet-stream');
			  header('Content-Disposition: attachment; filename="'.basename($filepath1).'"');
			  header('Expires: 0');
			  header('Cache-Control: must-revalidate');
			  header('Pragma: public');
			  header('Content-Length: ' . filesize($filepath1));
			  flush(); // Flush system output buffer
			  readfile($filepath1);
			  exit;
			  } 
	  }

	  // public function add_mem()
	  // {
	  //   $id1 = $_POST['id1'];
	  //   $mem_name = $_POST['mem_name'];
	  //   $mem_type = $_POST['mem_type'];
	  //   $mem_ph = $_POST['mem_ph'];
	  //   $mem_em = $_POST['mem_em'];

	  //   $suc = $this->receptionModel->add_mem_db($id1,$mem_name, $mem_type, $mem_ph, $mem_em);
	  //     $success = $this->receptionModel->update_password_db($cpass, $id, $files_array);
	  //   if($suc)
	  //   {
	  //     echo 'Member Added';
	  //   }
	  //   else
	  //   {
	  //     echo 'error';
	  //   }
	  // }


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

			  $success = $this->doctorModel->update_password_db($cpass, $id, $files_array);
			  if($success)
				redirect('doctors/success_settings');
			  else
				redirect('doctors/upd_err_settings');           
		  }
		  else
		  {
			  redirect('doctors/error_settings');
		  }

	  }
	   public function settings_doc()
	  {
		  $user_id = $_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no'];
		  $mem_data = $this->doctorModel->get_mem_data($user_id);
		  foreach ($mem_data as $key)
		  {
			  $_SESSION['user_photo_medhike_87_71_18_08_80_none_med_hi_ke_no'] = $key->mem_photo;
		  }
		  $data = [
			'mem_data' => $mem_data 
		  ];
		  $this->view('doctors/settings_doc', $data);
	  }


	  public function allxraydetails()
	  {
		  $this->view('doctors/allxraydetails');
	  }
	 
	  
		public function delete_xray()
	  {
		  $s_id = $_POST['ser_id'];
		  $success = $this->doctorModel->delete_xray_db($s_id);
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
			$all_service = $this->doctorModel->get_all_report($lim,$off);
		  }
		  else
		  {
			$inc = $_POST['inc'];
			$inc = (int)$inc;
			$lim = 9;
			$off = 9+(9*$inc);
			$all_service = $this->doctorModel->get_all_report($lim,$off);
		  }
		  $all_orders_print = '';

		  foreach ($all_service as $key)
		  {
			if($key->visit_id == NULL)
			{
				$vaId = $key->admit_id.' OP';
				$pId = $this->doctorModel->getThePatientIdFromAdmitId($key->admit_id);
				if($pId != 0)
				{
					$pName = $this->receptionModel->get_patient_name_only_db($pId);
				}
				else
				{
					$pName = "";
				}
				
			}  
			if($key->admit_id == NULL)
			{
				$vaId = $key->visit_id.' IP';
				$pId = $this->doctorModel->getThePatientIdFromVisitId($key->visit_id);
				if($pId != 0)
				{
					$pName = $this->receptionModel->get_patient_name_only_db($pId);
				}
				else
				{
					$pName = "";
				}
			}
			$report_id= $key->report_id;
			$patient_id = $key->patient_id;
			$invoice_name = $key->report_title;
			$report_file_name = $key->report_file_name;
			$invoice_bill = $key->report_date;
			$all_orders_print.='<tr>
			  <td id="r_id" style="text-align:left;">'.ucwords($pName).'('.$pId.')</td>
			  <td>'.$vaId.'</td>
			  <td style="text-align:left;">'.$invoice_name.'</td>
			  <td style="text-align:left;"><a download href="'.URLROOT.'/reports/'.$report_file_name.'" style="color:black;">'.$report_file_name.'</a></td>
			  <td style="text-align:left;">'.$invoice_bill.'</td>
			  <td style="text-align:left;">
				<button onclick="confirm_sec('.$report_id.')" style="width: 64px" type="button" class="btn btn-warning btn-xs m-b-5">Remove</button>
			  </td>
			</tr>';
		  }
		  echo $all_orders_print;
	  }
		 public function search_by_xray_id()
	  {
		  $inv_id = $_POST['inv'];
		  $single_invoice = $this->doctorModel->get_search_xray($inv_id);
		  $all_orders_print = '';

		  foreach ($single_invoice as $key)
		  {
			if($key->visit_id == NULL)
			{
				$vaId = $key->admit_id.' OP';
				$pId = $this->doctorModel->getThePatientIdFromAdmitId($key->admit_id);
				if($pId != 0)
				{
					$pName = $this->receptionModel->get_patient_name_only_db($pId);
				}
				else
				{
					$pName = "";
				}
				
			}  
			if($key->admit_id == NULL)
			{
				$vaId = $key->visit_id.' IP';
				$pId = $this->doctorModel->getThePatientIdFromVisitId($key->visit_id);
				if($pId != 0)
				{
					$pName = $this->receptionModel->get_patient_name_only_db($pId);
				}
				else
				{
					$pName = "";
				}
			}
			$report_id= $key->report_id;
			$patient_id = $key->patient_id;
			$invoice_name = $key->report_title;
			$report_file_name = $key->report_file_name;
			$invoice_bill = $key->report_date;
			$all_orders_print.='<tr>
			  <td id="r_id" style="text-align:left;">'.ucwords($pName).'('.$pId.')</td>
			  <td>'.$vaId.'</td>
			  <td style="text-align:left;">'.$invoice_name.'</td>
			  <td style="text-align:left;"><a download href="'.URLROOT.'/reports/'.$report_file_name.'" style="color:black;">'.$report_file_name.'</a></td>
			  <td style="text-align:left;">'.$invoice_bill.'</td>
			  <td style="text-align:left;">
				<button onclick="confirm_sec('.$report_id.')" style="width: 64px" type="button" class="btn btn-warning btn-xs m-b-5">Remove</button>
			  </td>
			</tr>';
		  }
		  echo $all_orders_print;
	  }

	   public function get_auto_patient_name2()
	  {
		  $cname = $_POST['query3'];
		  $cust_list = $this->doctorModel->auto_patient_name2($cname);
		  $output3 = '';
		  $output3 = '<ul class="list-unstyled">';
		  foreach ($cust_list as $key)
		  {
			$output3 .='<li class="ee"><p>'.ucwords($key->patient_name).''."(".''.$key->patient_id.''.")".'</p></li>';
		  }
		  $output3.='</ul>';
		  echo $output3;
	  }

	public function operations()
	{
		$data = [
		  'ot' => $this->doctorModel->getAllOperationsWithRespectToDoc(),
		];
		$this->view('doctors/operations', $data);
	}

	public function operationDetails($id)
	{
		$data = [
			'ot' => $this->doctorModel->getOtDetailsById($id)
		];
		$this->view('doctors/operationDetails', $data);
	}

	public function timeslots()
	{
		$data = [
			'times' => $this->doctorModel->getAllTimeslots()
		];
		$this->view('doctors/timeslots', $data);
	}
	
	public function saveTimeSlots()
	{
		$_SESSION['timeslot'] = $_POST['dayId'];
		$this->doctorModel->saveTimeSlotsDb($_POST['dayId'], $_POST['end'], $_POST['start']);
		redirect('doctors/timeslots');
	}

	public function updateTimeSlot($upParamas)
	{
		$updateParams = explode(',', $upParamas);
		$_SESSION['timeslot'] = $updateParams[1];
		$this->doctorModel->deleteTheTimeslot($updateParams[0], $updateParams[1]);
		redirect('doctors/timeslots');
	}

	public function showTimeSlotsByDoctorId()
	{
		$dayNumber = date('w');
		$dayName = date('l');
		$dId = $_POST['dId'];
		$timeSlots = $this->doctorModel->getTheTimeSlot($dId);
		$tStart = array();
		$output = "";
		$currentTime = date('H:i a');
		if(!empty($timeSlots))
		{
			$tStart = explode('__', $timeSlots->days_slots_start);
			$tEnd = explode('__', $timeSlots->days_slots_end);
			$tStart = explode('||', $tStart[$dayNumber]);
			$tEnd = explode('||', $tEnd[$dayNumber]);
		}
		else
		{
			$output .='<div class="col-lg-12"><h4 class="title">Doctor not present.</h4></div>';
		}
		
		if(!array_sum($tStart) == 0)
		{
		$output .='
		<div class="col-lg-12"> 
			<h4 class="title">Doctor Timeslots</h4> 
			<ul class="nav nav-tabs"> 
				<li class="active"> 
					<a href="#home" data-toggle="tab" aria-expanded="false"> 
						<span class="visible-xs">'.$dayName.'</span> 
						<span class="hidden-xs">'.$dayName.'</span> 
					</a> 
				</li> 
			</ul> 
			<div class="tab-content"> 
				<div class="tab-pane active"> 
					<div>';
					for ($i=0; $i < sizeof($tStart); $i++) 
					{
						if($tStart[$i] != 0) 
						{
							$fromTime = $tStart[$i];
							$toTime = $tEnd[$i];
							$date1 = DateTime::createFromFormat('H:i a', $currentTime);
							$date2 = DateTime::createFromFormat('H:i a', $fromTime);
							$date3 = DateTime::createFromFormat('H:i a', $toTime);
							if ($date1 > $date2 && $date1 < $date3)
							{
								$style = "btn-inverse";
							}
							else
							{
								$style = "btn-danger";
							}
							$output .='	 
							<button type="button" class="btn '.$style.' m-b-5 includer">
								'.$tStart[$i].'-'.$tEnd[$i].'
							</button>
							&nbsp &nbsp';
						}
					}
			$output .='</button>
					</div> 
				</div>
			</div>
		</div>
		';
		}
		echo $output;
	}

	public function docProfile($dId)
	{
		$data = [
			'doctors' => $this->receptionModel->get_doctor_by_id_single($dId),
			'auth' => $this->receptionModel->get_mem_data_single($dId),
			'times' => $this->receptionModel->getAllTimeslots($dId),
		];
		$this->view('doctors/docProfile', $data);
	}

	public function discharge_summary($ids)
	{
		$ids = explode(',', $ids);
		$id = $ids[0];
		$pat_id = $ids[1];
		$data = [
			'ipd_days_data' => $this->doctorModel->get_ipd_days($id),
			'ipd' => $this->doctorModel->get_ipd_main_data($id),
			'logo' => $this->receptionModel->get_logo_details(),
			'patient_id' => $pat_id
		];
		$this->view('doctors/discharge_summary', $data);
	}

	public function discharge_summary_doc()
	{
		$id = $_POST['admit'];
		$pat_id = $_POST['pat'];
		$data = [
			'ipd_days_data' => $this->doctorModel->get_ipd_days($id),
			'ipd' => $this->doctorModel->get_ipd_main_data($id),
			'logo' => $this->receptionModel->get_logo_details(),
			'patient_id' => $pat_id
		];
		$this->view('doctors/discharge_summary', $data);
	}

	public function print_admit_medicines($id)
	{
		$data = [
			'ipd_days'  => $this->doctorModel->get_ipd_days($id),
			'ipd' => $this->doctorModel->get_ipd_main_data($id),
			'logo' => $this->receptionModel->get_logo_details()
		];
		$this->view('doctors/print_admit_medicines', $data);
	}

	public function get_patient_name_only($patient_id)
	{
			$pn = $this->receptionModel->get_patient_name_only_db($patient_id);
			return $pn;
	}

	public function get_doctor_name_only($doctor_id)
	{
			$dn = $this->receptionModel->get_doctor_name_only_db($doctor_id);
			return $dn;
	}
	public function get_doctor_spec_only($doctor_id)
	{
			$dn = $this->receptionModel->get_doctor_spec_only_db($doctor_id);
			return $dn;
	}

	public function get_all_patient_details($patient_id)
	{
		return $p_data = $this->receptionModel->get_patient_by_id($patient_id);
	}

	public function teamAssign($id)
	{
		$id = explode(',', $id);
		$data = [
			'doc' => $this->doctorModel->getAllDoctors(),
			'nur' => $this->doctorModel->getAllNurses(),
			'id' => $id[0],
			'patId' => $id[1]
		];
		$this->view('doctors/teamAssign', $data);
	}

	public function assignTeamToId($id)
	{
		$id = explode(',', $id);
		$doc = implode(',', $_POST['doc']);
		$docRes = implode(',', $_POST['docRes']);
		$nur = implode(',', $_POST['nur']);
		$nurRes = implode(',', $_POST['nurRes']);
		$oth = implode(',', $_POST['oth']);
		$othRes = implode(',', $_POST['othRes']);

		$dR = $doc.','.$docRes;
		$nR = $nur.','.$nurRes;
		$oR = $oth.','.$othRes;
		$this->doctorModel->saveAssignTeam($id[0], $dR, $nR, $oR);
		redirect('doctors/admission_check/'.$id[1].'');
	}
	public function view_emergency()
	{
		$this->view('doctors/view_emergency');
	}
	public function all_emergency1()
	{
		$lim = $_POST['lim'];
		$lim = (int)$lim;
		if($lim==9)
		{
			$off = $_POST['off'];
			$off = (int)$off;
			$all_visits = $this->doctorModel->get_all_emergency_doc($lim,$off);
		}
		else
		{
			$inc = $_POST['inc'];
			$inc = (int)$inc;
			$lim = 9;
			$off = 9+(9*$inc);
			$all_visits = $this->doctorModel->get_all_emergency_doc($lim,$off);
		}
		$all_orders_print = '';
		foreach ($all_visits as $key)
		{
			$all_orders_print.='<tr>
				<td style="text-align:left;">'.$key->id.'</td>
				<td style="text-align:left;">'.$key->p_id.'</td>
				<td style="text-align:left;">'.ucwords($key->p_name).'</td>
				<td style="text-align:left;">'.ucwords($key->d_name).'</td>
				<td style="text-align:left;">'.date('d-m-Y h:i a', strtotime($key->created_by)).'</td>
				<td style="text-align:center;">
						<a href='.URLROOT.'/doctors/edit_emergency/'.$key->id.'><button style="width: 100px" type="button" class="btn btn-info btn-xs m-b-5">start consultation</button></a>
				</td>
			</tr>
			';
		}
		echo $all_orders_print;
	}
	public function edit_emergency($id)
	{
		$data = [
					'em' => $this->doctorModel->get_emergency_for_doctor($id),
				];
		$this->view('doctors/emergency_consult',$data);
	}
	public function update_emergency()
	{
		$id = $_POST['id'];
		$details = $_POST['details'];
		if($this->doctorModel->update_emergency_details($id,$details))
		{
			echo "success";
		}else
		{
			echo "try later";
		}
	}

	public function save_advice_for_discharge($patient_id, $admit_id)
	{
		$query = $this->doctorModel->update_discharge_advice($admit_id, $_POST['advice_discharge']);
		if($query)
		{
			redirect('doctors/admission_check/'.$patient_id.'');
		}
	}	
}
?>