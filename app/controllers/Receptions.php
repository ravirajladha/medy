<?php
	class Receptions extends Controller
	{
			public function __construct()
			{
					$this->receptionModel = $this->model('Reception');
					$this->doctorModel = $this->model('Doctor');
					$this->otModel = $this->model('Ots');
			}


			// All Functions Starts Here


			public function index()
			{
				if(!isset($_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']) AND $_SESSION['type'] != 'rec')
				{
						redirect('users/login');
				}
				else{
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
				$this->view('receptions/index', $data);
			}
			}

			public function new_orders()
			{
				if(!isset($_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']) AND $_SESSION['type'] != 'rec')
				{
						redirect('users/login');
				}
				else
				{
					$this->view('receptions/new_orders');
				}
			}

			public function new_member()
			{
				if(!isset($_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']) AND $_SESSION['type'] != 'rec')
				{
						redirect('users/login');
				}
				else
				{
						$this->view('receptions/new_member');
				}
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
				if(!isset($_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']) AND $_SESSION['type'] != 'rec')
				{
						redirect('users/login');
				}
				else
				{
						$this->view('receptions/all_orders');
				}  
			}

			public function all_orders1()
			{
				$lim = $_POST['lim'];
				$lim = (int)$lim;
				if($lim==9)
				{
					$off = $_POST['off'];
					$off = (int)$off;
					$all_invoice = $this->receptionModel->get_all_orders($lim,$off);
				}
				else
				{
					$inc = $_POST['inc'];
					$inc = (int)$inc;
					$lim = 9;
					$off = 9+(9*$inc);
					$all_invoice = $this->receptionModel->get_all_orders($lim,$off);
				}
				$all_orders_print = '';

				foreach ($all_invoice as $key)
				{
					$invoice_id = $key->invoice_id;
					$invoice_name = $key->invoice_name;
					$invoice_name = explode('|', $invoice_name);
					$invoice_total = (int)$key->invoice_total;
					$invoice_bill = $key->invoice_bill;
					$invoice_date = $key->invoice_date;
					$dep_type = $key->department;
					$amount_paid = (int)$key->amount_paid - (int)$key->advance_pay;
					$advance_pay = (int)$key->advance_pay;
					$cancel = $key->cancelled; 
					
					$bal = $invoice_total - $amount_paid;         //#FF3366
				
				    
					
					$final_bal = 0;
					
					$all_orders_print.='<tr>
						<td style="padding-top:15px; text-align:left;">';
						if($dep_type==1)
						{
							$all_orders_print.='<span class="badge badge-pill badge-warning" style="background-color:#FA8B50;">L</span>&nbsp;';
						}
						else
						{
							$all_orders_print.='<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;';
						}
					 $all_orders_print.=''.$invoice_id.'</td>
						<td style="padding-top:17px; text-align:left;">'.ucwords($invoice_name[0]).'</td>
						
						<td style="padding-top:15px;">'.$invoice_total.'</td>
						<td style="padding-top:15px;">'.$advance_pay.'</td>
						<td style="padding-top:15px;">'.$amount_paid.'</td>
						<td style="padding-top:15px;">'.$bal.'</td>
						<td style="padding-top:15px;">'.date('d-m-Y H:i A', strtotime($invoice_date)).'</td>
						<td>'.$this->receptionModel->get_the_created_name($key->created_by).' - '.$key->created_by.'</td>
						<td style="padding-top:15px; text-align:left; padding-left:65px;">';
						if($cancel != 1)
						{
							if($dep_type==1)
							{
								// $all_orders_print.='
								// 	<a href="'.URLROOT.'/receptions/print_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-success btn-xs m-b-5">Print</button></a>
								// 	<a href="'.URLROOT.'/receptions/view_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-purple btn-xs m-b-5">View</button></a>
									
								// 	<button style="width: 54px" type="button" class="btn btn-warning btn-xs m-b-5" onclick="cancel_order('.$invoice_id.')">Cancel</button>';
								// 	if($bal != 0){
								// 		$all_orders_print.='
								// 	<button style="width: 54px" type="button" class="btn btn-primary btn-xs m-b-5" onclick="openModal('.$invoice_id.','.$bal.')">Balance</button>';
									
									
									$all_orders_print.='
									<a href="'.URLROOT.'/receptions/print_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-success btn-xs m-b-5">Print</button></a>
									<a href="'.URLROOT.'/receptions/view_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-purple btn-xs m-b-5">View</button></a>';
									if($bal != 0){
										$all_orders_print.='
									<button style="width: 54px" type="button" class="btn btn-primary btn-xs m-b-5" onclick="openModal('.$invoice_id.','.$bal.')">Balance</button>';
								}
							}

							else
							{
								// $all_orders_print.='<a href="'.URLROOT.'/receptions/print_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-success btn-xs m-b-5">Print</button></a>
								// 	<a href="'.URLROOT.'/receptions/view_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-purple btn-xs m-b-5">View</button></a>
									
								// 	<a href="'.URLROOT.'/receptions/edit_order/'.$invoice_id.'"><button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button></a>
								// 	<button style="width: 54px" type="button" class="btn btn-warning btn-xs m-b-5" onclick="cancel_order('.$invoice_id.')">Cancel</button>';
								// 	if($bal != 0){
								// 		$all_orders_print.='
								// 	<button style="width: 54px" type="button" class="btn btn-primary btn-xs m-b-5" onclick="openModal('.$invoice_id.','.$bal.')">Balance</button>';
									
									
									$all_orders_print.='<a href="'.URLROOT.'/receptions/print_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-success btn-xs m-b-5">Print</button></a>
									<a href="'.URLROOT.'/receptions/view_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-purple btn-xs m-b-5">View</button></a>
									
									<a href="'.URLROOT.'/receptions/edit_order/'.$invoice_id.'"><button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button></a>';
									
								
									
									if($bal != 0){
										$all_orders_print.='
									<button style="width: 54px" type="button" class="btn btn-primary btn-xs m-b-5" onclick="openModal('.$invoice_id.','.$bal.')">Balance</button>';
								}
							}
						}
						else
						{
								 $all_orders_print.='<button style="width: 74px;background-color:#FF7043; color:white;" type="button" class="btn btn btn-xs m-b-5" onclick="undo_cancel('.$invoice_id.')">Cancelled</button>';
						}

						$all_orders_print.='</td>

					</tr>';
				}
				echo $all_orders_print;
			}

			public function edit_order($order_id)
			{
				$edit_order_details = $this->receptionModel->get_search_orders($order_id);
				$data = [
					'in_id' => $order_id,
					'edit_order_details'=>$edit_order_details
				];
				$this->view('receptions/new_orders',$data);
			}

			public function search_by_inv_id()
			{
				$inv_id = $_POST['inv'];
				$single_invoice = $this->receptionModel->get_search_orders($inv_id);
				$all_orders_print = '';

				foreach ($single_invoice as $key)
				{
					$invoice_id = $key->invoice_id;
					$invoice_name = $key->invoice_name;
					$invoice_name = explode('|', $invoice_name);
					$invoice_total = (int)$key->invoice_total;
					$invoice_bill = $key->invoice_bill;
					$invoice_date = $key->invoice_date;
					$dep_type = $key->department;
					$amount_paid = (int)$key->amount_paid;
					$cancel = $key->cancelled; 
					$bal = $invoice_total - $amount_paid;         //#FF3366
					$all_orders_print.='<tr>
						<td style="padding-top:15px; text-align:left;">';
						if($dep_type==1)
						{
							$all_orders_print.='<span class="badge badge-pill badge-warning" style="background-color:#FA8B50;">L</span>&nbsp;';
						}
						else
						{
							$all_orders_print.='<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;';
						}
					 $all_orders_print.=''.$invoice_id.'</td>
						<td style="padding-top:17px; text-align:left;">'.ucwords($invoice_name[0]).'</td>
						
						<td style="padding-top:15px;">'.$invoice_total.'</td>
						<td style="padding-top:15px;">'.$amount_paid.'</td>
						<td style="padding-top:15px;">'.$bal.'</td>
						<td style="padding-top:15px;">'.date('d-m-Y H:i A', strtotime($invoice_date)).'</td>
						<td>'.$this->receptionModel->get_the_created_name($key->created_by).' - '.$key->created_by.'</td>
						<td style="padding-top:15px; text-align:left; padding-left:65px;">';
						if($cancel != 1)
						{
							if($dep_type==1)
							{
								$all_orders_print.='
									<a href="'.URLROOT.'/receptions/print_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-success btn-xs m-b-5">Print</button></a>
									<a href="'.URLROOT.'/receptions/view_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-purple btn-xs m-b-5">View</button></a>
									
									<button style="width: 54px" type="button" class="btn btn-warning btn-xs m-b-5" onclick="cancel_order('.$invoice_id.')">Cancel</button>';
									if($bal != 0){
										$all_orders_print.='
									<button style="width: 54px" type="button" class="btn btn-primary btn-xs m-b-5" onclick="openModal('.$invoice_id.','.$bal.')">Balance</button>';
								}
							}

							else
							{
								$all_orders_print.='<a href="'.URLROOT.'/receptions/print_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-success btn-xs m-b-5">Print</button></a>
									<a href="'.URLROOT.'/receptions/view_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-purple btn-xs m-b-5">View</button></a>
									
									<a href="'.URLROOT.'/receptions/edit_order/'.$invoice_id.'"><button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button></a>
									<button style="width: 54px" type="button" class="btn btn-warning btn-xs m-b-5" onclick="cancel_order('.$invoice_id.')">Cancel</button>';
									if($bal != 0){
										$all_orders_print.='
									<button style="width: 54px" type="button" class="btn btn-primary btn-xs m-b-5" onclick="openModal('.$invoice_id.','.$bal.')">Balance</button>';
								}
							}
						}
						else
						{
								 $all_orders_print.='<button style="width: 74px;background-color:#FF7043; color:white;" type="button" class="btn btn btn-xs m-b-5" onclick="undo_cancel('.$invoice_id.')">Cancelled</button>';
						}

						$all_orders_print.='</td>

					</tr>';
				}
					echo $all_orders_print;
			}

			public function get_all_orders_wrt_dates()
			{
				$start = $_POST['start'];
				$end = $_POST['end'];
				$single_invoice = $this->receptionModel->get_all_orders_wrt_dates_db($start, $end);
				$all_orders_print = '';

				foreach ($single_invoice as $key)
				{
					$invoice_id = $key->invoice_id;
					$invoice_name = $key->invoice_name;
					$invoice_name = explode('|', $invoice_name);
					$invoice_total = (int)$key->invoice_total;
					$invoice_bill = $key->invoice_bill;
					$invoice_date = $key->invoice_date;
					$dep_type = $key->department;
					$amount_paid = (int)$key->amount_paid;
					$cancel = $key->cancelled; 
					$bal = $invoice_total - $amount_paid;
					$all_orders_print.='<tr>
						<td style="padding-top:15px; text-align:left;">';
						if($dep_type==1)
						{
							$all_orders_print.='<span class="badge badge-pill badge-warning" style="background-color:#FA8B50;">L</span>&nbsp;';
						}
						else
						{
							$all_orders_print.='<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;';
						}
						$all_orders_print.=''.$invoice_id.'</td>
						<td style="padding-top:17px; text-align:left;">'.ucwords($invoice_name[0]).'</td>
						
						<td style="padding-top:15px;">'.$invoice_total.'</td>
						<td style="padding-top:15px;">'.$amount_paid.'</td>
						<td style="padding-top:15px;">'.$bal.'</td>
						<td style="padding-top:15px;">'.date('d-m-Y H:i A', strtotime($invoice_date)).'</td>
						<td>'.$this->receptionModel->get_the_created_name($key->created_by).' - '.$key->created_by.'</td>
						<td style="padding-top:15px; text-align:left; padding-left:65px;">';
						if($cancel != 1)
						{
							if($dep_type==1)
							{
								$all_orders_print.='
									<a href="'.URLROOT.'/receptions/print_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-success btn-xs m-b-5">Print</button></a>
									<a href="'.URLROOT.'/receptions/view_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-purple btn-xs m-b-5">View</button></a>
									
									<button style="width: 54px" type="button" class="btn btn-warning btn-xs m-b-5" onclick="cancel_order('.$invoice_id.')">Cancel</button>';
									if($bal != 0){
										$all_orders_print.='
									<button style="width: 54px" type="button" class="btn btn-primary btn-xs m-b-5" onclick="openModal('.$invoice_id.','.$bal.')">Balance</button>';
								}
							}

							else
							{
								$all_orders_print.='<a href="'.URLROOT.'/receptions/print_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-success btn-xs m-b-5">Print</button></a>
									<a href="'.URLROOT.'/receptions/view_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-purple btn-xs m-b-5">View</button></a>
									
									<a href="'.URLROOT.'/receptions/edit_order/'.$invoice_id.'"><button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button></a>
									<button style="width: 54px" type="button" class="btn btn-warning btn-xs m-b-5" onclick="cancel_order('.$invoice_id.')">Cancel</button>';
									if($bal != 0){
										$all_orders_print.='
									<button style="width: 54px" type="button" class="btn btn-primary btn-xs m-b-5" onclick="openModal('.$invoice_id.','.$bal.')">Balance</button>';
								}
							}
						}
						else
						{
							$all_orders_print.='<button style="width: 74px;background-color:#FF7043; color:white;" type="button" class="btn btn btn-xs m-b-5" onclick="undo_cancel('.$invoice_id.')">Cancelled</button>';
						}
						$all_orders_print.='</td>
					</tr>';
				}
				echo $all_orders_print;
			}

			public function get_all_admissions_wrt_dates()
			{
				$start = $_POST['start'];
				$end = $_POST['end'];
				$single_invoice = $this->receptionModel->get_all_admissions_wrt_dates_db($start, $end);
				$all_orders_print = '';

				foreach ($single_invoice as $key)
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
						$disAdmit = $ipd_patient_id.",".$ipd_admit_id;
						$all_orders_print.='<tr>


							<td id="ad_id">'.$ipd_admit_id.'</td>
							<td style="text-align:left">'.ucwords($pat_name).'('.$ipd_patient_id.')</td>
							<td style="text-align:left">'.ucwords($doc_name).'</td>
							<td>'.$ipd_bed_id.'</td>
							<td>'.$key->insurance_name.'&nbsp;';
							if($key->insurance_name == NULL OR $key->insurance_name == '') {
							$all_orders_print.='<a href="#" onclick="gotoInsurance('.$ipd_admit_id.')"><i class="fa fa-pencil-square" aria-hidden="true"></i></a>';
							} 
							$all_orders_print.='</td>
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
								</form>
							</td>
							<td>'.$key->advice.'</td>
							<td style="width:150px">';
							if(!isset($discharge_date_time))
							{
								 $all_orders_print.='<a href="'.URLROOT.'/receptions/make_bill_ip_visit/'.$ipd_admit_id_gen.'"><button style="width: 60px" type="button" class="btn btn-info btn-xs m-b-5">Make Bill</button><a>
										<a href="'.URLROOT.'/receptions/make_bill_ip_visit/'.$ipd_admit_id_lab.'"><button style="width: 60px" type="button" class="btn btn-success btn-xs m-b-5">Lab Bill</button><a>
										<button data-toggle="modal" data-target="#datemodal" data-id="'.$ipd_admit_id.'" style="width: 60px" type="button" class="btn btn-purple btn-xs m-b-5">Discharge</button>
										<button  style="width: 60px" type="button" class="btn btn-primary btn-xs m-b-5" onclick="uploadDoc('.$ipd_admit_id.')" >Upload</button>
										<a href="'.URLROOT.'/receptions/make_all_bills_ip/'.$ipd_admit_id.'"><button style="width: 60px" type="button" class="btn btn-success btn-xs m-b-5">All Bills</button><a>
										<a href="'.URLROOT.'/receptions/create_advance_receipt/'.$ipd_admit_id.'/'.$ipd_patient_id.'" class="btn btn-primary btn-xs">Advance Receipt</a>
								</td>
							</tr>';
							}
							else
							{
									$all_orders_print.='
									<a href="'.URLROOT.'/receptions/make_bill_ip_visit/'.$ipd_admit_id_gen.'"><button style="width: 60px" type="button" class="btn btn-info btn-xs m-b-5">Make Bill</button><a>
										<a href="'.URLROOT.'/receptions/make_bill_ip_visit/'.$ipd_admit_id_lab.'"><button style="width: 60px" type="button" class="btn btn-success btn-xs m-b-5">Lab Bill</button><a>
										<a style="width: 80px;" type="button" class="btn btn-warning btn-xs m-b-5">Discharged</a>
										<a href="'.URLROOT.'/receptions/discharge_summary_admit/'.$disAdmit.'" style="width: 130px;" type="button" class="btn btn-success btn-xs m-b-5">Discharge Summary</a>
										<a href="'.URLROOT.'/receptions/create_advance_receipt/'.$ipd_admit_id.'/'.$ipd_patient_id.'" class="btn btn-primary btn-xs">Advance Receipt</a>
								</td>
							</tr>';
							}
						}
					echo $all_orders_print;
			}

			public function get_all_visit_wrt_dates()
			{
				$start = $_POST['start'];
				$end = $_POST['end'];
				$single_invoice = $this->receptionModel->get_all_visit_wrt_dates_db($start, $end);
				$all_orders_print = '';

				foreach ($single_invoice as $key)
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
						$opd_test_advised=$key->opd_test_advised;
						$pat_name = $this->receptionModel->patient_name($opd_patient_id);
						$doc_name = $this->receptionModel->doctor_name($opd_doctor_id);
						$r='OP'.$opd_visit_id;
						if($opd_visit_fee == NULL)
						{
							$link='';
						}
						else
						{
						$link= URLROOT."/receptions/make_bill_op_visit/".$opd_visit_id_gen;
						}
//lab link
						if($opd_visit_fee == NULL)
						{
							$link1='';
						}
						else
						{     if(!empty($opd_test_advised))
									{
											//$getinvoiceidbyopid = $this->receptionModel->getinvoiceidbyop_id();
											$temp="OP".$opd_visit_id;
											$check = $this->receptionModel->checkinvoiceopid($temp);
											$link1 = URLROOT."/receptions/edit_order/".$check->invoice_id;
									}
									else
									{  
											$link1='';
									}
						}
						$all_orders_print.='<tr>
							<td style="text-align:left;">'.$opd_visit_id.'</td>
							<td style="text-align:left;">'.ucwords($pat_name).' ('.$opd_patient_id.')'.'</td>
							<td style="text-align:left;">'.ucwords($doc_name).'</td>
							<td style="text-align:left;">'.ucwords($opd_purpose).'</td>
							<td style="text-align:left;">'.date('d-m-Y h:i A', strtotime($visit_date_time)).'</td>
							<td style="text-align:left;">'.$opd_visit_fee.'</td>
							<td>'.$key->advice.'</td>
							<td style="text-align:center;">
									<a href='.$link.'><button style="width: 70px" type="button" class="btn btn-info btn-xs m-b-5">Make Bill</button></a>
									<a href='.$link1.'><button style="width: 70px" type="button" class="btn btn-success btn-xs m-b-5">Lab Bill</button></a>
									<button style="width: 70px" type="button" class="btn btn-purple btn-xs m-b-5" data-target="#reportupload'.$opd_visit_id.'" data-toggle="modal">Upload</button>
							</td>
						</tr>
						';
					}
					echo $all_orders_print;
			}
			
	public function search_by_dnameForAppointments_value()
	{
		$patient_name = $_POST['patient_name'];

// 		$patient_name = "sunil";
		
		$patients_list= $this->receptionModel->get_doctorName_appointments($patient_name);
		$all_orders_print = '';
				
		foreach($patients_list as $key)
		{
			$all_orders_print.='<tr>
			<td style="text-align:left;">'.$key->a_id.'</td>
			<td style="text-align:left;">'.ucwords($key->patient_name).'</td>
			<td style="text-align:left;">'.$key->patient_phone.'</td>
			<td style="text-align:left;">'.ucwords($key->doctor_name).'</td>
			<td style="text-align:left;">'.$key->doctor_specialty.'</td>
			<td style="text-align:left;">'.date('d-M-Y H:i A', strtotime($key->appointment_time)).'</td>';
			if($key->status == 0)
			{
			// 	$all_orders_print.='
			// 	<td style="text-align:center;">
			// 		<a href="'.URLROOT.'/receptions/approveAppointment/'.$key->a_id.'"><button style="width: 60px" type="button" class="btn btn-info btn-xs m-b-5">Approve</button></a>
			// 		<button style="width: 60px" type="button" class="btn btn-warning btn-xs m-b-5">Cancel</button>
			// 	</td></tr>';
			
				$all_orders_print.='
				<td style="text-align:center;">
					<a href="'.URLROOT.'/receptions/approveAppointment/'.$key->a_id.'"><button style="width: 60px" type="button" class="btn btn-info btn-xs m-b-5">Approve</button></a>
					
				</td></tr>';
			}
			else
			{
			// 	$all_orders_print.='
			// 	<td style="text-align:center;">
			// 		<a href="'.URLROOT.'/receptions/convertToVisit/'.$key->a_id.'"><button type="button" class="btn btn-info btn-xs m-b-5">Convert to Visit</button></a>
			// 		<a href="'.URLROOT.'/receptions/convertToAdmit/'.$key->a_id.'"><button type="button" class="btn btn-primary btn-xs m-b-5">Convert to Admit</button></a>
			// 		<button type="button" class="btn btn-warning btn-xs m-b-5">Cancel</button>
			// 	</td></tr>';
				
				$all_orders_print.='
				<td style="text-align:center;">
					<a href="'.URLROOT.'/receptions/convertToVisit/'.$key->a_id.'"><button type="button" class="btn btn-info btn-xs m-b-5">Convert to Visit</button></a>
					<a href="'.URLROOT.'/receptions/convertToAdmit/'.$key->a_id.'"><button type="button" class="btn btn-primary btn-xs m-b-5">Convert to Admit</button></a>
					
				</td></tr>';
			}
		}
		
		echo $all_orders_print;
	}

			public function search_by_name_value()
			{
				$patient_name = $_POST['patient_name'];
				$patients_list= $this->receptionModel->get_patient_orders($patient_name);
				$all_orders_print = '';

				foreach ($patients_list as $key)
				{
					$invoice_id = $key->invoice_id;
					$invoice_name = $key->invoice_name;
					$invoice_name = explode('|', $invoice_name);
					$invoice_total = (int)$key->invoice_total;
					$invoice_bill = $key->invoice_bill;
					$invoice_date = $key->invoice_date;
					$dep_type = $key->department;
					$amount_paid = (int)$key->amount_paid;
					$cancel = $key->cancelled; 
					$bal = $invoice_total - $amount_paid;         //#FF3366
					$all_orders_print.='<tr>
						<td style="padding-top:15px; text-align:left;">';
						if($dep_type==1)
						{
							$all_orders_print.='<span class="badge badge-pill badge-warning" style="background-color:#FA8B50;">L</span>&nbsp;';
						}
						else
						{
							$all_orders_print.='<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;';
						}
					 $all_orders_print.=''.$invoice_id.'</td>
						<td style="padding-top:17px; text-align:left;">'.ucwords($invoice_name[0]).'</td>
						
						<td style="padding-top:15px;">'.$invoice_total.'</td>
						<td style="padding-top:15px;">'.$amount_paid.'</td>
						<td style="padding-top:15px;">'.$bal.'</td>
						<td style="padding-top:15px;">'.date('d-m-Y H:i A', strtotime($invoice_date)).'</td>
						<td style="padding-top:15px; text-align:left; padding-left:65px;">';
						if($cancel != 1)
						{
							if($dep_type==1)
							{
								$all_orders_print.='
									<a href="'.URLROOT.'/receptions/print_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-success btn-xs m-b-5">Print</button></a>
									<a href="'.URLROOT.'/receptions/view_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-purple btn-xs m-b-5">View</button></a>
									
									<button style="width: 54px" type="button" class="btn btn-warning btn-xs m-b-5" onclick="cancel_order('.$invoice_id.')">Cancel</button>';
									if($bal != 0){
										$all_orders_print.='
									<button style="width: 54px" type="button" class="btn btn-primary btn-xs m-b-5" onclick="openModal('.$invoice_id.','.$bal.')">Balance</button>';
								}
							}

							else
							{
								$all_orders_print.='<a href="'.URLROOT.'/receptions/print_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-success btn-xs m-b-5">Print</button></a>
									<a href="'.URLROOT.'/receptions/view_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-purple btn-xs m-b-5">View</button></a>
									
									<a href="'.URLROOT.'/receptions/edit_order/'.$invoice_id.'"><button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button></a>
									<button style="width: 54px" type="button" class="btn btn-warning btn-xs m-b-5" onclick="cancel_order('.$invoice_id.')">Cancel</button>';
									if($bal != 0){
										$all_orders_print.='
									<button style="width: 54px" type="button" class="btn btn-primary btn-xs m-b-5" onclick="openModal('.$invoice_id.','.$bal.')">Balance</button>';
								}
							}
						}
						else
						{
								 $all_orders_print.='<button style="width: 74px;background-color:#FF7043; color:white;" type="button" class="btn btn btn-xs m-b-5" onclick="undo_cancel('.$invoice_id.')">Cancelled</button>';
						}

						$all_orders_print.='</td>

					</tr>';
				}
					echo $all_orders_print;
			}

			public function new_service()
			{
					$service_types = $this->receptionModel->get_all_service_db();
					$data = [
							'service_types'=>$service_types
						];
					$this->view('receptions/new_service',$data);
			}

			public function save_new_service()
			{
					$s_name = $_POST['s_name'];
					$s_cost = $_POST['s_cost'];
					$s_type = $_POST['s_type'];
					$success = $this->receptionModel->save_new_service_db($s_name,$s_type,$s_cost);
					if($success)
						echo "New Service Added";
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
						echo "Service Upadted";
					else
						echo "error";
			}

			public function all_services()
			{ 
				if(!isset($_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']) AND $_SESSION['type'] != 'rec')
				{
						redirect('users/login');
				}
				else
				{
					$this->view('receptions/all_services');
				}
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
							<td id="r_id" style="text-align:left;">'.$invoice_id.'</td>
							<td style="text-align:left;">'.$invoice_name.'</td>
							<td style="text-align:left;">'.$invoice_total.'</td>
							<td style="text-align:left;">'.$invoice_bill.'</td>
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
			 public function delete_xray()
			{
					$s_id = $_POST['ser_id'];
					$success = $this->receptionModel->delete_xray_db($s_id);
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
						$all_service = $this->receptionModel->get_all_report($lim,$off);
					}
					else
					{
						$inc = $_POST['inc'];
						$inc = (int)$inc;
						$lim = 9;
						$off = 9+(9*$inc);
						$all_service = $this->receptionModel->get_all_report($lim,$off);
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
					$single_invoice = $this->receptionModel->get_search_xray($inv_id);
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
							<td id="r_id" style="text-align:left;">'.$invoice_id.'</td>
							<td style="text-align:left;">'.$invoice_name.'</td>
							<td style="text-align:left;">'.$invoice_total.'</td>
							<td style="text-align:left;">'.$invoice_bill.'</td>
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
							<td id="r_id" style="text-align:left;">'.$invoice_id.'</td>
							<td style="text-align:left;">'.$invoice_name.'</td>
							<td style="text-align:left;">'.$invoice_total.'</td>
							<td style="text-align:left;">'.$invoice_bill.'</td>
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
					$this->view('receptions/new_service',$data);
			}

			public function new_op_visit()
			{
					if(!isset($_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']) AND $_SESSION['type'] != 'rec')
					{
							redirect('users/login');
					}
					else
					{
							$doc_list = $this->receptionModel->get_doctors_list();
							$data = [
								'doc_list' => $doc_list
							];
							$this->view('receptions/new_op_visit',$data);
					}
			}

			public function all_visit()
			{
				if(!isset($_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']) AND $_SESSION['type'] != 'rec')
				{
						redirect('users/login');
				}
				else
				{
					$data = [
						'opd_data' => $this->receptionModel->get_new_opd()
					];
					$this->view('receptions/all_visit', $data);
				}
			}

			public function new_ip_visit()
			{
					if(!isset($_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']) AND $_SESSION['type'] != 'rec')
					{
							redirect('users/login');
					}
					else
					{
						$doc_list = $this->receptionModel->get_doctors_list();
						$allIns = $this->receptionModel->getAllIns();
						$data = [
							'doc_list' => $doc_list,
							'ins' => $allIns,
						];
						$this->view('receptions/new_ip_visit',$data);
					}
			}

			public function all_admissions()
			{
					if(!isset($_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']) AND $_SESSION['type'] != 'rec')
					{
							redirect('users/login');
					}
					else
					{
							$data = [
								'getAllIns' => $this->receptionModel->getAllIns(),
								'ipd' => $this->receptionModel->get_new_ipd()
							];
							$this->view('receptions/all_admissions', $data);
					}
			}

			public function all_admissions1()
			{
					$lim = $_POST['lim'];
					$lim = (int)$lim;
					if($lim==9)
					{
						$off = $_POST['off'];
						$off = (int)$off;
						$all_admits = $this->receptionModel->get_all_admission($lim,$off);
					}
					else
					{
						$inc = $_POST['inc'];
						$inc = (int)$inc;
						$lim = 9;
						$off = 9+(9*$inc);
						$all_admits = $this->receptionModel->get_all_admission($lim,$off);
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
						$disAdmit = $ipd_patient_id.",".$ipd_admit_id;
						$all_orders_print.='<tr>


							<td id="ad_id">'.$ipd_admit_id.'</td>
							<td style="text-align:left">'.ucwords($pat_name).'('.$ipd_patient_id.')</td>
							<td style="text-align:left">'.ucwords($doc_name).'</td>
							<td>'.$ipd_bed_id.'</td>
							<td>'.$key->insurance_name.'&nbsp;';
							if($key->insurance_name == NULL OR $key->insurance_name == '') {
							$all_orders_print.='<a href="#" onclick="gotoInsurance('.$ipd_admit_id.')"><i class="fa fa-pencil-square" aria-hidden="true"></i></a>';
							} 
							$all_orders_print.='</td>
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
								</form>
							</td>
							<td>'.$key->advice.'</td>
							<td style="width:150px">';
							if(!isset($discharge_date_time))
							{
								 $all_orders_print.='<a href="'.URLROOT.'/receptions/make_bill_ip_visit/'.$ipd_admit_id_gen.'"><button style="width: 60px" type="button" class="btn btn-info btn-xs m-b-5">Make Bill</button><a>
								<a href="'.URLROOT.'/receptions/make_bill_ip_visit/'.$ipd_admit_id_lab.'"><button style="width: 60px" type="button" class="btn btn-success btn-xs m-b-5">Lab Bill</button><a>
								<button data-toggle="modal" data-target="#datemodal" data-id="'.$ipd_admit_id.'" style="width: 60px" type="button" class="btn btn-purple btn-xs m-b-5">Discharge</button>
								<button  style="width: 60px" type="button" class="btn btn-primary btn-xs m-b-5" onclick="uploadDoc('.$ipd_admit_id.')" >Upload</button>
								<a href="'.URLROOT.'/receptions/make_all_bills_ip/'.$ipd_admit_id.'"><button style="width: 60px" type="button" class="btn btn-success btn-xs m-b-5">All Bills</button><a>
								<a href="'.URLROOT.'/receptions/create_advance_receipt/'.$ipd_admit_id.'/'.$ipd_patient_id.'" class="btn btn-primary btn-xs">Advance Receipt</a>
								
							</tr>';
							}
							else
							{
								$all_orders_print.='
								<a href="'.URLROOT.'/receptions/make_bill_ip_visit/'.$ipd_admit_id_gen.'"><button style="width: 60px" type="button" class="btn btn-info btn-xs m-b-5">Make Bill</button><a>
									<a href="'.URLROOT.'/receptions/make_bill_ip_visit/'.$ipd_admit_id_lab.'"><button style="width: 60px" type="button" class="btn btn-success btn-xs m-b-5">Lab Bill</button><a>
									<a style="width: 80px;" type="button" class="btn btn-warning btn-xs m-b-5">Discharged</a>
									<a href="'.URLROOT.'/receptions/discharge_summary_admit/'.$disAdmit.'" style="width: 130px;" type="button" class="btn btn-success btn-xs m-b-5">Discharge Summary</a>
									<a href="'.URLROOT.'/receptions/create_advance_receipt/'.$ipd_admit_id.'/'.$ipd_patient_id.'" class="btn btn-primary btn-xs">Advance Receipt</a>
									<button class="btn btn-info btn-xs" onclick="open_ds('.$ipd_admit_id.','.$ipd_patient_id.')">DS</button>
									<a href="'.URLROOT.'/receptions/print_invoice_ipd_all/'.$ipd_admit_id.'" class="btn btn-primary btn-xs">BB</a>
									<a href="'.URLROOT.'/receptions/print_invoice_ipd_all_con/'.$ipd_admit_id.'" class="btn btn-primary btn-xs">CB</a>
								</td>
							</tr>';
							}
					}
					echo $all_orders_print;
			}

			public function search_by_admit_id()
			{
					$all_orders_print = '';
					$admit_id = $_POST['admit_id'];
					$all_admits = $this->receptionModel->get_all_admit_by_id($admit_id);
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
						$disAdmit = $ipd_patient_id.",".$ipd_admit_id;
						$all_orders_print.='<tr>


							<td id="ad_id">'.$ipd_admit_id.'</td>
							<td style="text-align:left">'.ucwords($pat_name).'('.$ipd_patient_id.')</td>
							<td style="text-align:left">'.ucwords($doc_name).'</td>
							<td>'.$ipd_bed_id.'</td>
							<td>'.$key->insurance_name.'&nbsp;';
							if($key->insurance_name == NULL OR $key->insurance_name == '') {
							$all_orders_print.='<a href="#" onclick="gotoInsurance('.$ipd_admit_id.')"><i class="fa fa-pencil-square" aria-hidden="true"></i></a>';
							} 
							$all_orders_print.='</td>
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
								</form>
							</td>
							<td>'.$key->advice.'</td>
							<td style="width:150px">';
							if(!isset($discharge_date_time))
							{
								 $all_orders_print.='<a href="'.URLROOT.'/receptions/make_bill_ip_visit/'.$ipd_admit_id_gen.'"><button style="width: 60px" type="button" class="btn btn-info btn-xs m-b-5">Make Bill</button><a>
										<a href="'.URLROOT.'/receptions/make_bill_ip_visit/'.$ipd_admit_id_lab.'"><button style="width: 60px" type="button" class="btn btn-success btn-xs m-b-5">Lab Bill</button><a>
										<button data-toggle="modal" data-target="#datemodal" data-id="'.$ipd_admit_id.'" style="width: 60px" type="button" class="btn btn-purple btn-xs m-b-5">Discharge</button>
										<button  style="width: 60px" type="button" class="btn btn-primary btn-xs m-b-5" onclick="uploadDoc('.$ipd_admit_id.')" >Upload</button>
										<a href="'.URLROOT.'/receptions/make_all_bills_ip/'.$ipd_admit_id.'"><button style="width: 60px" type="button" class="btn btn-success btn-xs m-b-5">All Bills</button><a>
										<a href="'.URLROOT.'/receptions/create_advance_receipt/'.$ipd_admit_id.'/'.$ipd_patient_id.'" class="btn btn-primary btn-xs">Advance Receipt</a>
								</td>
							</tr>';
							}
							else
							{
									$all_orders_print.='
									<a href="'.URLROOT.'/receptions/make_bill_ip_visit/'.$ipd_admit_id_gen.'"><button style="width: 60px" type="button" class="btn btn-info btn-xs m-b-5">Make Bill</button><a>
										<a href="'.URLROOT.'/receptions/make_bill_ip_visit/'.$ipd_admit_id_lab.'"><button style="width: 60px" type="button" class="btn btn-success btn-xs m-b-5">Lab Bill</button><a>
										<a style="width: 80px;" type="button" class="btn btn-warning btn-xs m-b-5">Discharged</a>
										<a href="'.URLROOT.'/receptions/discharge_summary_admit/'.$disAdmit.'" style="width: 130px;" type="button" class="btn btn-success btn-xs m-b-5">Discharge Summary</a>
										<a href="'.URLROOT.'/receptions/create_advance_receipt/'.$ipd_admit_id.'/'.$ipd_patient_id.'" class="btn btn-primary btn-xs">Advance Receipt</a>
								</td>
							</tr>';
							}
					}
					echo $all_orders_print;
			}

			public function search_by_p_id()
			{
					$all_orders_print = '';
					$admit_id = $_POST['admit_id'];
					$all_admits = $this->receptionModel->get_all_admit_by_pid($admit_id);
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
						$disAdmit = $ipd_patient_id.",".$ipd_admit_id;
						$all_orders_print.='<tr>


							<td id="ad_id">'.$ipd_admit_id.'</td>
							<td style="text-align:left">'.ucwords($pat_name).'('.$ipd_patient_id.')</td>
							<td style="text-align:left">'.ucwords($doc_name).'</td>
							<td>'.$ipd_bed_id.'</td>
							<td>'.$key->insurance_name.'&nbsp;';
							if($key->insurance_name == NULL OR $key->insurance_name == '') {
							$all_orders_print.='<a href="#" onclick="gotoInsurance('.$ipd_admit_id.')"><i class="fa fa-pencil-square" aria-hidden="true"></i></a>';
							} 
							$all_orders_print.='</td>
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
								</form>
							</td>
							<td>'.$key->advice.'</td>
							<td style="width:150px">';
							if(!isset($discharge_date_time))
							{
								 $all_orders_print.='<a href="'.URLROOT.'/receptions/make_bill_ip_visit/'.$ipd_admit_id_gen.'"><button style="width: 60px" type="button" class="btn btn-info btn-xs m-b-5">Make Bill</button><a>
										<a href="'.URLROOT.'/receptions/make_bill_ip_visit/'.$ipd_admit_id_lab.'"><button style="width: 60px" type="button" class="btn btn-success btn-xs m-b-5">Lab Bill</button><a>
										<button data-toggle="modal" data-target="#datemodal" data-id="'.$ipd_admit_id.'" style="width: 60px" type="button" class="btn btn-purple btn-xs m-b-5">Discharge</button>
										<button  style="width: 60px" type="button" class="btn btn-primary btn-xs m-b-5" onclick="uploadDoc('.$ipd_admit_id.')" >Upload</button>
										<a href="'.URLROOT.'/receptions/make_all_bills_ip/'.$ipd_admit_id.'"><button style="width: 60px" type="button" class="btn btn-success btn-xs m-b-5">All Bills</button><a>
										<a href="'.URLROOT.'/receptions/create_advance_receipt/'.$ipd_admit_id.'/'.$ipd_patient_id.'" class="btn btn-primary btn-xs">Advance Receipt</a>
								</td>
							</tr>';
							}
							else
							{
									$all_orders_print.='
									<a href="'.URLROOT.'/receptions/make_bill_ip_visit/'.$ipd_admit_id_gen.'"><button style="width: 60px" type="button" class="btn btn-info btn-xs m-b-5">Make Bill</button><a>
										<a href="'.URLROOT.'/receptions/make_bill_ip_visit/'.$ipd_admit_id_lab.'"><button style="width: 60px" type="button" class="btn btn-success btn-xs m-b-5">Lab Bill</button><a>
										<a style="width: 80px;" type="button" class="btn btn-warning btn-xs m-b-5">Discharged</a>
										<a href="'.URLROOT.'/receptions/discharge_summary_admit/'.$disAdmit.'" style="width: 130px;" type="button" class="btn btn-success btn-xs m-b-5">Discharge Summary</a>
										<a href="'.URLROOT.'/receptions/create_advance_receipt/'.$ipd_admit_id.'/'.$ipd_patient_id.'" class="btn btn-primary btn-xs">Advance Receipt</a>
								</td>
							</tr>';
							}
					}
					echo $all_orders_print;
			}

			public function search_by_p_name()
			{
					$all_orders_print = '';
					$admit_id = $_POST['admit_id'];
					$all_admits = $this->receptionModel->get_all_admit_by_pname($admit_id);
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
						$disAdmit = $ipd_patient_id.",".$ipd_admit_id;
						$all_orders_print.='<tr>


							<td id="ad_id">'.$ipd_admit_id.'</td>
							<td style="text-align:left">'.ucwords($pat_name).'('.$ipd_patient_id.')</td>
							<td style="text-align:left">'.ucwords($doc_name).'</td>
							<td>'.$ipd_bed_id.'</td>
							<td>'.$key->insurance_name.'&nbsp;';
							if($key->insurance_name == NULL OR $key->insurance_name == '') {
							$all_orders_print.='<a href="#" onclick="gotoInsurance('.$ipd_admit_id.')"><i class="fa fa-pencil-square" aria-hidden="true"></i></a>';
							} 
							$all_orders_print.='</td>
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
								</form>
							</td>
							<td>'.$key->advice.'</td>
							<td style="width:150px">';
							if(!isset($discharge_date_time))
							{
								 $all_orders_print.='<a href="'.URLROOT.'/receptions/make_bill_ip_visit/'.$ipd_admit_id_gen.'"><button style="width: 60px" type="button" class="btn btn-info btn-xs m-b-5">Make Bill</button><a>
										<a href="'.URLROOT.'/receptions/make_bill_ip_visit/'.$ipd_admit_id_lab.'"><button style="width: 60px" type="button" class="btn btn-success btn-xs m-b-5">Lab Bill</button><a>
										<button data-toggle="modal" data-target="#datemodal" data-id="'.$ipd_admit_id.'" style="width: 60px" type="button" class="btn btn-purple btn-xs m-b-5">Discharge</button>
										<button  style="width: 60px" type="button" class="btn btn-primary btn-xs m-b-5" onclick="uploadDoc('.$ipd_admit_id.')" >Upload</button>
										<a href="'.URLROOT.'/receptions/make_all_bills_ip/'.$ipd_admit_id.'"><button style="width: 60px" type="button" class="btn btn-success btn-xs m-b-5">All Bills</button><a>
										<a href="'.URLROOT.'/receptions/create_advance_receipt/'.$ipd_admit_id.'/'.$ipd_patient_id.'" class="btn btn-primary btn-xs">Advance Receipt</a>
								</td>
							</tr>';
							}
							else
							{
									$all_orders_print.='
									<a href="'.URLROOT.'/receptions/make_bill_ip_visit/'.$ipd_admit_id_gen.'"><button style="width: 60px" type="button" class="btn btn-info btn-xs m-b-5">Make Bill</button><a>
										<a href="'.URLROOT.'/receptions/make_bill_ip_visit/'.$ipd_admit_id_lab.'"><button style="width: 60px" type="button" class="btn btn-success btn-xs m-b-5">Lab Bill</button><a>
										<a style="width: 80px;" type="button" class="btn btn-warning btn-xs m-b-5">Discharged</a>
										<a href="'.URLROOT.'/receptions/discharge_summary_admit/'.$disAdmit.'" style="width: 130px;" type="button" class="btn btn-success btn-xs m-b-5">Discharge Summary</a>
										<a href="'.URLROOT.'/receptions/create_advance_receipt/'.$ipd_admit_id.'/'.$ipd_patient_id.'" class="btn btn-primary btn-xs">Advance Receipt</a>
								</td>
							</tr>';
							}
					}
					echo $all_orders_print;
			}

			public function search_by_d_name()
			{
					$all_orders_print = '';
					$admit_id = $_POST['admit_id'];
					$all_admits = $this->receptionModel->get_all_admit_by_dname($admit_id);
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
						$disAdmit = $ipd_patient_id.",".$ipd_admit_id;
						$all_orders_print.='<tr>


							<td id="ad_id">'.$ipd_admit_id.'</td>
							<td style="text-align:left">'.ucwords($pat_name).'('.$ipd_patient_id.')</td>
							<td style="text-align:left">'.ucwords($doc_name).'</td>
							<td>'.$ipd_bed_id.'</td>
							<td>'.$key->insurance_name.'&nbsp;';
							if($key->insurance_name == NULL OR $key->insurance_name == '') {
							$all_orders_print.='<a href="#" onclick="gotoInsurance('.$ipd_admit_id.')"><i class="fa fa-pencil-square" aria-hidden="true"></i></a>';
							} 
							$all_orders_print.='</td>
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
								</form>
							</td>
							<td>'.$key->advice.'</td>
							<td style="width:150px">';
							if(!isset($discharge_date_time))
							{
								 $all_orders_print.='<a href="'.URLROOT.'/receptions/make_bill_ip_visit/'.$ipd_admit_id_gen.'"><button style="width: 60px" type="button" class="btn btn-info btn-xs m-b-5">Make Bill</button><a>
										<a href="'.URLROOT.'/receptions/make_bill_ip_visit/'.$ipd_admit_id_lab.'"><button style="width: 60px" type="button" class="btn btn-success btn-xs m-b-5">Lab Bill</button><a>
										<button data-toggle="modal" data-target="#datemodal" data-id="'.$ipd_admit_id.'" style="width: 60px" type="button" class="btn btn-purple btn-xs m-b-5">Discharge</button>
										<button  style="width: 60px" type="button" class="btn btn-primary btn-xs m-b-5" onclick="uploadDoc('.$ipd_admit_id.')" >Upload</button>
										<a href="'.URLROOT.'/receptions/make_all_bills_ip/'.$ipd_admit_id.'"><button style="width: 60px" type="button" class="btn btn-success btn-xs m-b-5">All Bills</button><a>
										<a href="'.URLROOT.'/receptions/create_advance_receipt/'.$ipd_admit_id.'/'.$ipd_patient_id.'" class="btn btn-primary btn-xs">Advance Receipt</a>
								</td>
							</tr>';
							}
							else
							{
									$all_orders_print.='
									<a href="'.URLROOT.'/receptions/make_bill_ip_visit/'.$ipd_admit_id_gen.'"><button style="width: 60px" type="button" class="btn btn-info btn-xs m-b-5">Make Bill</button><a>
										<a href="'.URLROOT.'/receptions/make_bill_ip_visit/'.$ipd_admit_id_lab.'"><button style="width: 60px" type="button" class="btn btn-success btn-xs m-b-5">Lab Bill</button><a>
										<a style="width: 80px;" type="button" class="btn btn-warning btn-xs m-b-5">Discharged</a>
										<a href="'.URLROOT.'/receptions/discharge_summary_admit/'.$disAdmit.'" style="width: 130px;" type="button" class="btn btn-success btn-xs m-b-5">Discharge Summary</a>
										<a href="'.URLROOT.'/receptions/create_advance_receipt/'.$ipd_admit_id.'/'.$ipd_patient_id.'" class="btn btn-primary btn-xs">Advance Receipt</a>
								</td>
							</tr>';
							}
					}
					echo $all_orders_print;
			}


			public function new_patient()
			{
					$this->view('receptions/new_patient');
			}

			public function all_patients()
			{
				if(!isset($_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']) AND $_SESSION['type'] != 'rec')
				{
						redirect('users/login');
				}
				else
				{
					$this->view('receptions/all_patients');
				}
			}

			public function remove_patient()
			{
					$id = $_POST['ser_id'];
					$success = $this->receptionModel->remove_patient_db($id);
					if($success)
						echo "Removed";
					else
						echo "Error";
			}

			public function restore_patient()
			{
					$id = $_POST['ser_id'];
					$success = $this->receptionModel->restore_patient_db($id);
					if($success)
						echo "Removed";
					else
						echo "Error";
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
					$patient_dob = $key->patient_dob;
					$patinet_phone = $key->patient_phone;
					$patient_email = $key->patient_email;
					$patinet_address = explode(',', $key->patient_address);
					$patient_address = implode(' ', $patinet_address);
					$all_orders_print.='<tr>
					<td>'.$patient_id.'</td>
					<td style="text-align:left;">'.ucwords($patient_name).'</td>
					<td>'.$patient_gender.'</td>
					<td style="text-align:left;padding-left:13px;">'.$patinet_phone.'<br>'.$patient_email.'</td>
					<td style="text-align:left;padding-left:10px; width:300px;">'.ucwords($patient_address).'</td>
					<td>
						<a href="'.URLROOT.'/receptions/edit_patient/'.$patient_id.'"><button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button></a>
						<a href="'.URLROOT.'/receptions/view_profile_patient/'.$patient_id.'"><button style="width: 54px" type="button" class="btn btn-purple btn-xs m-b-5">View</button></a>
						<button style="width: 54px" type="button" class="btn btn-warning btn-xs m-b-5" onclick="remove_pat('.$patient_id.')">Remove</button>
						<br>
		                
		                <a href=" https://api.whatsapp.com/send?phone=+91'.$key->patient_phone.'&text= Hello, Welcome to Ritu Hospital"><button type="submit" class="btn btn-primary btn-xs m-b-5">Send Greetings</button></a>

						
					</td>
					</tr>';
				}
				echo $all_orders_print;
			}


			public function all_patients2()
			{
					$sear = $_POST['sear'];
					$all_patients = $this->receptionModel->get_patient_by_id_like($sear);
					$all_orders_print = '';

					foreach ($all_patients as $key)
					{
						$patient_id = $key->patient_id;
						$patient_name = $key->patient_name;
						$patient_gender = $key->patient_gender;
						$patient_dob = $key->patient_dob;
						$patinet_phone = $key->patient_phone;
						$patient_email = $key->patient_email;
						$patinet_address = explode(',', $key->patient_address);
						$patient_address = implode(' ', $patinet_address);
						$all_orders_print.='<tr>
						<td>'.$patient_id.'</td>
						<td style="text-align:left;">'.ucwords($patient_name).'</td>
						<td>'.$patient_gender.'</td>
						<td style="text-align:left;padding-left:13px;">'.$patinet_phone.'<br>'.$patient_email.'</td>
						<td style="text-align:left;padding-left:10px; width:300px;">'.ucwords($patient_address).'</td>
						<td>
								<a href="'.URLROOT.'/receptions/edit_patient/'.$patient_id.'"><button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button></a>
								<a href="'.URLROOT.'/receptions/view_profile_patient/'.$patient_id.'"><button style="width: 54px" type="button" class="btn btn-purple btn-xs m-b-5">View</button></a>
								<button style="width: 54px" type="button" class="btn btn-warning btn-xs m-b-5" onclick="remove_pat('.$patient_id.')">Remove</button>
						</td>
						</tr>';
					}
					echo $all_orders_print;
			}


			public function all_patients3()
			{
					$sear = $_POST['sear'];
					$all_patients = $this->receptionModel->get_patient_by_name_like($sear);
					$all_orders_print = '';

					foreach ($all_patients as $key)
					{
						$patient_id = $key->patient_id;
						$patient_name = $key->patient_name;
						$patient_gender = $key->patient_gender;
						$patient_dob = $key->patient_dob;
						$patinet_phone = $key->patient_phone;
						$patient_email = $key->patient_email;
						$patinet_address = explode(',', $key->patient_address);
						$patient_address = implode(' ', $patinet_address);
						$all_orders_print.='<tr>
						<td>'.$patient_id.'</td>
						<td style="text-align:left;">'.ucwords($patient_name).'</td>
						<td>'.$patient_gender.'</td>
						<td style="text-align:left;padding-left:13px;">'.$patinet_phone.'<br>'.$patient_email.'</td>
						<td style="text-align:left;padding-left:10px; width:300px;">'.ucwords($patient_address).'</td>
						<td>
								<a href="'.URLROOT.'/receptions/edit_patient/'.$patient_id.'"><button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button></a>
								<a href="'.URLROOT.'/receptions/view_profile_patient/'.$patient_id.'"><button style="width: 54px" type="button" class="btn btn-purple btn-xs m-b-5">View</button></a>
								<button style="width: 54px" type="button" class="btn btn-warning btn-xs m-b-5" onclick="remove_pat('.$patient_id.')">Remove</button>
						</td>
						</tr>';
					}
					echo $all_orders_print;
			}

			public function all_patients4()
			{
					$sear = $_POST['sear'];
					$all_patients = $this->receptionModel->get_patient_by_phone_like($sear);
					$all_orders_print = '';

					foreach ($all_patients as $key)
					{
						$patient_id = $key->patient_id;
						$patient_name = $key->patient_name;
						$patient_gender = $key->patient_gender;
						$patient_dob = $key->patient_dob;
						$patinet_phone = $key->patient_phone;
						$patient_email = $key->patient_email;
						$patinet_address = explode(',', $key->patient_address);
						$patient_address = implode(' ', $patinet_address);
						$all_orders_print.='<tr>
						<td>'.$patient_id.'</td>
						<td style="text-align:left;">'.ucwords($patient_name).'</td>
						<td>'.$patient_gender.'</td>
						<td style="text-align:left;padding-left:13px;">'.$patinet_phone.'<br>'.$patient_email.'</td>
						<td style="text-align:left;padding-left:10px; width:300px;">'.ucwords($patient_address).'</td>
						<td>
								<a href="'.URLROOT.'/receptions/edit_patient/'.$patient_id.'"><button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button></a>
								<a href="'.URLROOT.'/receptions/view_profile_patient/'.$patient_id.'"><button style="width: 54px" type="button" class="btn btn-purple btn-xs m-b-5">View</button></a>
								<button style="width: 54px" type="button" class="btn btn-warning btn-xs m-b-5" onclick="remove_pat('.$patient_id.')">Remove</button>
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
					$this->view('receptions/new_patient',$data);
			}

			public function new_doctor()
			{
				if(!isset($_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']) AND $_SESSION['type'] != 'rec')
				{
						redirect('users/login');
				}
				else
				{
						$this->view('receptions/new_doctor');
				}
			}

			public function new_doctor1($d_id)
			{
					$d_list = $this->receptionModel->get_doctor_by_id($d_id);
					$data = [
						'd_list'=>$d_list
					];
					$this->view('receptions/new_doctor',$data);
			}

			public function new_member1($d_id)
			{
					$mem_list = $this->receptionModel->get_member_by_id($d_id);
					$data = [
						'mem_list'=>$mem_list
					];
					$this->view('receptions/new_member',$data);
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
					if(!isset($_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']) AND $_SESSION['type'] != 'rec')
					{
							redirect('users/login');
					}
					else
					{        
							$this->view('receptions/all_doctors');
					}
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
									<a href="'.URLROOT.'/receptions/new_doctor1/'.$key->mem_id.'"><button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button></a>
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
									<a href="'.URLROOT.'/receptions/new_member1/'.$mem_id.'"><button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button></a>
									<a href="'.URLROOT.'/receptions/remove_member/'.$mem_id.'"><button style="width: 54px" type="button" class="btn btn-warning btn-xs m-b-5">Remove</button></a>
							</td>
						</tr>';
					}
					echo $all_orders_print;
			}

			public function reports()
			{
					$this->view('receptions/reports');
			}

			public function remove_member($mid)
			{
					$this->receptionModel->remove_mem_db($mid);
					$this->view('receptions/all_members');
			}

			public function lab_new_orders()
			{
				$data = [
					'ty'=>'l'
				];
				$this->view('receptions/new_orders',$data);
			}

			public function get_report()
			{
				if(!isset($_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']) AND $_SESSION['type'] != 'rec')
				{
						redirect('users/login');
				}
				else
				{
					$tdy = date('Y-m-d');
					$ord_count = $this->receptionModel->get_order_count_today($tdy);
					$revenue = $this->receptionModel->get_revenue_count($tdy);
					$discount = $this->receptionModel->get_discount_count($tdy);
					$data = [
						'ord_count' => $ord_count,
						'rev' => $revenue,
						'dis' => $discount
					];
					$this->view('receptions/get_report',$data);
				}
			}

			public function all_members()
			{
				if(!isset($_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']) AND $_SESSION['type'] != 'rec')
					{
							redirect('users/login');
					}
				else
				{
						$this->view('receptions/all_members');
				} 
			}

			public function prescription()
			{
					$this->view('receptions/prescription');
			}

			public function lab_reports()
			{
				if(!isset($_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']) AND $_SESSION['type'] != 'rec')
				{
						redirect('users/login');
				}
				else
				{
						$data = [
							'lab' => $this->receptionModel->getAllLabTest()
						];
						$this->view('receptions/lab_reports', $data);
				} 
			}

			// function for getting all member data of a logged in member.
			public function settings()
			{
					$user_id = $_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no'];
					$mem_data = $this->receptionModel->get_mem_data($user_id);
					foreach ($mem_data as $key)
					{
							$_SESSION['user_photo_medhike_87_71_18_08_80_none_med_hi_ke_no'] = $key->mem_photo;
					}
					$data = [
						'mem_data' => $mem_data 
					];
					$this->view('receptions/settings', $data);
			}

			public function error_settings()
			{
					$user_id = $_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no'];
					$mem_data = $this->receptionModel->get_mem_data($user_id);
					$data = [
						'mem_data' => $mem_data,
						'pass_err' => 1 
					];
					$this->view('receptions/settings', $data);
			}

			public function success_settings()
			{
					$user_id = $_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no'];
					$mem_data = $this->receptionModel->get_mem_data($user_id);
					foreach ($mem_data as $key)
					{
							$_SESSION['user_photo_medhike_87_71_18_08_80_none_med_hi_ke_no'] = $key->mem_photo;
					}
					$data = [
						'mem_data' => $mem_data,
						'pass_err' => 2 
					];
					$this->view('receptions/settings', $data);
			}

			public function upd_err_settings()
			{
					$user_id = $_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no'];
					$mem_data = $this->receptionModel->get_mem_data($user_id);
					$data = [
						'mem_data' => $mem_data,
						'pass_err' => 3 
					];
					$this->view('receptions/settings', $data);
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
						$output .='<li class="cc" style="padding-left:10px;">'. $key->service_name.''." | ".''.$key->service_id.'</li>';
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

			public function get_auto_patient_name_for_header()
			{
					$cname = $_POST['query3'];
					$cust_list = $this->receptionModel->auto_patient_name($cname);
					$output3 = '';
					$output3 = '<ul class="list-unstyled">';
					foreach ($cust_list as $key)
					{
						$output3 .='<li class="head_sty"><p>'.ucwords($key->patient_name).''."(".''.$key->patient_id.''.")".'</p></li>';
					}
					$output3.='</ul>';
					echo $output3;
			}

			public function get_auto_doc_name()
			{
					$cname = $_POST['query3'];
					$cust_list = $this->receptionModel->get_doctors_list1($cname);
					$output3 = '';
					$output3 = '<ul class="list-unstyled">';
					foreach ($cust_list as $key)
					{
						$output3 .='<li class="ff"><p>'.$key->doctor_name.''." | ".''.$key->mem_id.'</p></li>';
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
						$output3 .='<li class="ee"><p>'.ucwords($key->patient_name).''."(".''.$key->patient_id.''.")".'</p></li>';
					}
					$output3.='</ul>';
					echo $output3;
			}
			public function get_auto_patient_name3()
			{
					$cname = $_POST['query3'];
					$cust_list = $this->receptionModel->auto_patient_name2($cname);
					$output3 = '';
					$output3 = '<ul class="list-unstyled">';
					foreach ($cust_list as $key)
					{
						$output3 .='<li class="ee1"><p>'.ucwords($key->patient_name).''."(".''.$key->patient_id.''.")".'</p></li>';
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
					$ePId = explode('|', $patient_name);
					$ePId = trim($ePId[1]);
					$patient_phone = $this->receptionModel->getThePatientPhone($ePId);
					$doctor_name = $_POST['doctor_name'];
					$ipopid = $_POST['ipopid'];
					$pay_mode = $_POST['pay_mode'];
					$amount_paid = $_POST['amount_paid'];
					$status = $_POST['status'];
					$dep = $_POST['dep_type'];
					$b = $_POST['b'];
					$taxx = $_POST['taxx'];
					$dist = $_POST['dist'];
					$advance_pay = $_POST['advance_pay'];
					$authorized_by = $_POST['authorized_by'];
					
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
							$data = [ 
												'inv_id_edit' => $inv_id_edit,
												'service_id' => $service_id, 
												'invoice_bill' => $invoice_bill,
												'grand_total' => $grand_total, 
												'patient_name' => $patient_name,
												'doctor_name' => $doctor_name, 
												'ipopid' => $ipopid,
												'pay_mode' => $pay_mode,
												'amount_paid' => $amount_paid,
												'status' => $status,
												'dep' => $dep, 
												'taxx' => $taxx,
												'dist' => $dist,
												'advance_pay' => $advance_pay,
												'authorized_by' => $authorized_by
											];
							$result=$this->receptionModel->getinvoicedepdata($inv_id_edit);
							if($result->department == 1)
							{
								$success = $this->receptionModel->update_invoice_db_edit2($data);

							}
							else
							{
								$success = $this->receptionModel->update_invoice_db_edit($data);     
							}
						
						} 
						else 
						{
									$success = $this->receptionModel->save_invoice_db($service_id,$invoice_bill,$grand_total,$patient_name,$doctor_name,$ipopid,$pay_mode,$amount_paid,$status,$dep,$taxx,$dist,$patient_phone,$advance_pay,$authorized_by); 
						}
				 





					if($success)
					{
						echo $success;
					 
					}
					else
					{
						echo $success;
					}
			}

			 public function temp()
			{
				$this->view('receptions/temp');
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
					$success1 = $this->receptionModel->check_db_visit($p_name,$d_name);
					if(!empty($success1->opd_visit_id))
					{  }
					else
					{
						$result = $this->receptionModel->check_ip_name_exist_for_opd($p_name);
						if ($result == 1)
						{
							echo "Cannot create visit, because the patient is admitted";
						}
						else
						{
							$success = $this->receptionModel->create_visit_db($p_name,$d_name,$v_pur);
							if($success)
							{
								echo "Updated";
							}
							else
							{
								echo "Error";
							}
						}
					 
					}
					 
			}

			 public function create_visit1()
			{
					$p_name = $_POST['p_name'];
					$d_name = $_POST['d_name'];
					$v_pur = $_POST['visit_pur'];
					$dt = $_POST['dt'];

					if($dt == "")
					{
						$dt = date('Y-m-d h:i:s');
					}
					$success1 = $this->receptionModel->check_db_visit($p_name,$d_name);

					if(!empty($success1->opd_visit_id))
					{  }
					else
					{

							$result = $this->receptionModel->check_ip_name_exist_for_opd($p_name);
								if ($result==1) {
									 echo "cannot";
								}
								else
								{
								$success = $this->receptionModel->create_visit_db1($p_name,$d_name,$v_pur,$dt);
								if($success)
									 echo "updated";
								 else
									 echo "error";
								}
					}
			}

			public function create_admission()
			{
				$insNumber = $_POST['insNumber'];
				$insName = $_POST['insName'];
				if($_POST['insName'] == "NULL")
				{
					$insName = NULL;
				}
				$insExpiry = $_POST['insExpiry'];

				if(!empty($_POST['p_name']))
				{
					$p_name = $_POST['p_name'];
					$result1 = $this->receptionModel->check_ip_name_exist_and_discharge($p_name);
					if ($result1 < 1)
					{
						$p_name = $_POST['p_name'];
						$d_name = $_POST['d_name'];
						$v_pur = $_POST['visit_pur'];
						
						$success = $this->receptionModel->create_admission_db($p_name,$d_name,$v_pur,$insNumber,$insName,$insExpiry);
							$success1 = $this->receptionModel->add_ip_admission_date_to_db($p_name);
						if($success)
							echo "Updated";
						else
							echo "Error";
					}
					else
					{
						echo "Patient already admitted, you cannot create another admission";
					}
				}
				else
				{
					echo "Enter patient name first!";
				}
			}
			
			

			public function view_invoice($id)
			{
					if($id == 0)
					{
						$last_inv = $this->receptionModel->get_invoice_details_for_new();
						$logo = $this->receptionModel->get_logo_details();
						$data = [
						'logo' => $logo,
						'last_inv'=>$last_inv
					];
					}
					else
					{
						$last_inv = $this->receptionModel->get_last_invoice($id);
						$logo = $this->receptionModel->get_logo_details();
						$data = [
							'logo' => $logo,
							'last_inv'=>$last_inv
						];
					}
					$this->view('receptions/view_invoice',$data);
			}

			public function print_invoice($id)
			{
					if($id == 0)
					{
						$logo = $this->receptionModel->get_logo_details();
						$last_inv = $this->receptionModel->get_invoice_details_for_new();
						$data = [
						'logo' => $logo,
						'last_inv'=>$last_inv
					];
					}
					else
					{
						$logo = $this->receptionModel->get_logo_details();
						$last_inv = $this->receptionModel->get_last_invoice($id);
						$data = [
							'logo' => $logo,
							'last_inv'=>$last_inv
						];
					}
					$this->view('receptions/print_invoice',$data);
			}


			public function all_visit1()
			{
				$lim = $_POST['lim'];
				$lim = (int)$lim;
				if($lim==9)
				{
					$off = $_POST['off'];
					$off = (int)$off;
					$all_visits = $this->receptionModel->get_all_visit($lim,$off);
				}
				else
				{
					$inc = $_POST['inc'];
					$inc = (int)$inc;
					$lim = 9;
					$off = 9+(9*$inc);
					$all_visits = $this->receptionModel->get_all_visit($lim,$off);
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
					$opd_test_advised=$key->opd_test_advised;
					$pat_name = $this->receptionModel->patient_name($opd_patient_id);
					$doc_name = $this->receptionModel->doctor_name($opd_doctor_id);
					$r='OP'.$opd_visit_id;
					$link= URLROOT."/receptions/make_bill_op_visit/".$opd_visit_id_gen;
					$link1= URLROOT."/receptions/make_bill_op_visit/".$opd_visit_id_lab;
					$link2= URLROOT."/receptions/alternate_charges/".$opd_visit_id_lab;
					$all_orders_print.='<tr>
						<td style="text-align:left;">'.$opd_visit_id.'</td>
						<td style="text-align:left;">'.ucwords($pat_name).' ('.$opd_patient_id.')'.'</td>
						<td style="text-align:left;">'.ucwords($doc_name).'</td>
						<td style="text-align:left;">'.ucwords($opd_purpose).'</td>
						<td style="text-align:left;">'.date('d-m-Y h:i A', strtotime($visit_date_time)).'</td>
						<td style="text-align:left;">'.$opd_visit_fee.'</td>
						<td>'.$key->advice.'</td>
						<td style="text-align:center;">
								<a href='.$link.'><button style="width: 70px" type="button" class="btn btn-info btn-xs m-b-5">Make Bill</button></a>
								<a href='.$link1.'><button style="width: 70px" type="button" class="btn btn-success btn-xs m-b-5">Lab Bill</button></a>
								<button style="width: 70px" type="button" class="btn btn-purple btn-xs m-b-5" onclick="uploadModelForVisit('.$opd_visit_id.')">Upload</button>
								<a href='.$link2.'><button style="width: 70px" type="button" class="btn btn-info btn-xs m-b-5">Alt charges</button></a>
						</td>
					</tr>
					';
				}
				echo $all_orders_print;
			}
			
			public function alternate_charges($vis_id)
			{
				 
					$t='';
					$vis_id = explode(',', $vis_id);
					$vis_id0 = $vis_id[0];
					$vis_id1 = $vis_id[1];
					$vis_id_det = $this->receptionModel->get_visit_details_id($vis_id0);

					foreach ($vis_id_det as $key)
					{
							$opi = $key->opd_patient_id;
							$odi = $key->opd_doctor_id;
							$ovi = $key->opd_visit_id;
							$nrf = $key->opd_visit_fee;
							if($nrf == NULL)
							{
								$nrf = 0;
							}
					}
					$patient_name = $this->receptionModel->get_patient_by_id($opi);
					$doctor_name = $this->receptionModel->get_doctor_by_id($odi);
					$data = [
						'vis_id_det'=>$vis_id_det,
						'vis_id'=>$ovi,
						'doctor_name'=>$doctor_name,
						'patient_name'=>$patient_name,
						'ty'=>$vis_id1,
						'nrf'=>$nrf
					];

					$this->view('receptions/alternate_charges',$data);
			}

			public function search_by_visit_id()
			{
				$visit_id = $_POST['visit_id'];
				$all_visits = $this->receptionModel->get_all_visit_by_id($visit_id);
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
					$opd_test_advised=$key->opd_test_advised;
					$pat_name = $this->receptionModel->patient_name($opd_patient_id);
					$doc_name = $this->receptionModel->doctor_name($opd_doctor_id);
					$r='OP'.$opd_visit_id;
					$link= URLROOT."/receptions/make_bill_op_visit/".$opd_visit_id_gen;
					$link1= URLROOT."/receptions/make_bill_op_visit/".$opd_visit_id_lab;
					$all_orders_print.='<tr>
						<td style="text-align:left;">'.$opd_visit_id.'</td>
						<td style="text-align:left;">'.ucwords($pat_name).' ('.$opd_patient_id.')'.'</td>
						<td style="text-align:left;">'.ucwords($doc_name).'</td>
						<td style="text-align:left;">'.ucwords($opd_purpose).'</td>
						<td style="text-align:left;">'.date('d-m-Y h:i A', strtotime($visit_date_time)).'</td>
						<td style="text-align:left;">'.$opd_visit_fee.'</td>
						<td>'.$key->advice.'</td>
						<td style="text-align:center;">
								<a href='.$link.'><button style="width: 70px" type="button" class="btn btn-info btn-xs m-b-5">Make Bill</button></a>
								<a href='.$link1.'><button style="width: 70px" type="button" class="btn btn-success btn-xs m-b-5">Lab Bill</button></a>
								<button style="width: 70px" type="button" class="btn btn-purple btn-xs m-b-5" onclick="uploadModelForVisit('.$opd_visit_id.')">Upload</button>
						</td>
					</tr>';
				}
				echo $all_orders_print;
			}

			public function search_by_patient_id()
			{
					$pat_id = $_POST['pat_id'];
					$all_visits = $this->receptionModel->get_all_visit_by_pat_id($pat_id);
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
					$opd_test_advised=$key->opd_test_advised;
					$pat_name = $this->receptionModel->patient_name($opd_patient_id);
					$doc_name = $this->receptionModel->doctor_name($opd_doctor_id);
					$r='OP'.$opd_visit_id;
					$link= URLROOT."/receptions/make_bill_op_visit/".$opd_visit_id_gen;
					$link1= URLROOT."/receptions/make_bill_op_visit/".$opd_visit_id_lab;
					$all_orders_print.='<tr>
						<td style="text-align:left;">'.$opd_visit_id.'</td>
						<td style="text-align:left;">'.ucwords($pat_name).' ('.$opd_patient_id.')'.'</td>
						<td style="text-align:left;">'.ucwords($doc_name).'</td>
						<td style="text-align:left;">'.ucwords($opd_purpose).'</td>
						<td style="text-align:left;">'.date('d-m-Y h:i A', strtotime($visit_date_time)).'</td>
						<td style="text-align:left;">'.$opd_visit_fee.'</td>
						<td>'.$key->advice.'</td>
						<td style="text-align:center;">
								<a href='.$link.'><button style="width: 70px" type="button" class="btn btn-info btn-xs m-b-5">Make Bill</button></a>
								<a href='.$link1.'><button style="width: 70px" type="button" class="btn btn-success btn-xs m-b-5">Lab Bill</button></a>
								<button style="width: 70px" type="button" class="btn btn-purple btn-xs m-b-5" onclick="uploadModelForVisit('.$opd_visit_id.')">Upload</button>
						</td>
					</tr>';
					}
					echo $all_orders_print;
			}

			public function search_by_pat_name()
			{
					$pat_name = $_POST['pat_name'];
					$all_visits = $this->receptionModel->get_all_visit_by_pat_name($pat_name);
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
					$opd_test_advised=$key->opd_test_advised;
					$pat_name = $this->receptionModel->patient_name($opd_patient_id);
					$doc_name = $this->receptionModel->doctor_name($opd_doctor_id);
					$r='OP'.$opd_visit_id;
					$link= URLROOT."/receptions/make_bill_op_visit/".$opd_visit_id_gen;
					$link1= URLROOT."/receptions/make_bill_op_visit/".$opd_visit_id_lab;
					$all_orders_print.='<tr>
						<td style="text-align:left;">'.$opd_visit_id.'</td>
						<td style="text-align:left;">'.ucwords($pat_name).' ('.$opd_patient_id.')'.'</td>
						<td style="text-align:left;">'.ucwords($doc_name).'</td>
						<td style="text-align:left;">'.ucwords($opd_purpose).'</td>
						<td style="text-align:left;">'.date('d-m-Y h:i A', strtotime($visit_date_time)).'</td>
						<td style="text-align:left;">'.$opd_visit_fee.'</td>
						<td>'.$key->advice.'</td>
						<td style="text-align:center;">
								<a href='.$link.'><button style="width: 70px" type="button" class="btn btn-info btn-xs m-b-5">Make Bill</button></a>
								<a href='.$link1.'><button style="width: 70px" type="button" class="btn btn-success btn-xs m-b-5">Lab Bill</button></a>
								<button style="width: 70px" type="button" class="btn btn-purple btn-xs m-b-5" onclick="uploadModelForVisit('.$opd_visit_id.')">Upload</button>
						</td>
					</tr>';
					}
					echo $all_orders_print;
			}

			public function search_by_doc_name()
			{
					$pat_name = $_POST['pat_name'];
					$all_visits = $this->receptionModel->get_all_visit_by_doc_name($pat_name);
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
					$opd_test_advised=$key->opd_test_advised;
					$pat_name = $this->receptionModel->patient_name($opd_patient_id);
					$doc_name = $this->receptionModel->doctor_name($opd_doctor_id);
					$r='OP'.$opd_visit_id;
					$link= URLROOT."/receptions/make_bill_op_visit/".$opd_visit_id_gen;
					$link1= URLROOT."/receptions/make_bill_op_visit/".$opd_visit_id_lab;
					$all_orders_print.='<tr>
						<td style="text-align:left;">'.$opd_visit_id.'</td>
						<td style="text-align:left;">'.ucwords($pat_name).' ('.$opd_patient_id.')'.'</td>
						<td style="text-align:left;">'.ucwords($doc_name).'</td>
						<td style="text-align:left;">'.ucwords($opd_purpose).'</td>
						<td style="text-align:left;">'.date('d-m-Y h:i A', strtotime($visit_date_time)).'</td>
						<td style="text-align:left;">'.$opd_visit_fee.'</td>
						<td>'.$key->advice.'</td>
						<td style="text-align:center;">
								<a href='.$link.'><button style="width: 70px" type="button" class="btn btn-info btn-xs m-b-5">Make Bill</button></a>
								<a href='.$link1.'><button style="width: 70px" type="button" class="btn btn-success btn-xs m-b-5">Lab Bill</button></a>
								<button style="width: 70px" type="button" class="btn btn-purple btn-xs m-b-5" onclick="uploadModelForVisit('.$opd_visit_id.')">Upload</button>
						</td>
					</tr>';
					}
					echo $all_orders_print;
			}

			public function make_bill_op_visit($vis_id)
			{
				 
					$t='';
					$vis_id = explode(',', $vis_id);
					$vis_id0 = $vis_id[0];
					$vis_id1 = $vis_id[1];
					$vis_id_det = $this->receptionModel->get_visit_details_id($vis_id0);

					foreach ($vis_id_det as $key)
					{
							$opi = $key->opd_patient_id;
							$odi = $key->opd_doctor_id;
							$ovi = $key->opd_visit_id;
							$nrf = $key->opd_visit_fee;
							if($nrf == NULL)
							{
								$nrf = 0;
							}
					}
					$patient_name = $this->receptionModel->get_patient_by_id($opi);
					$doctor_name = $this->receptionModel->get_doctor_by_id($odi);
					$data = [
						'vis_id_det'=>$vis_id_det,
						'vis_id'=>$ovi,
						'doctor_name'=>$doctor_name,
						'patient_name'=>$patient_name,
						'ty'=>$vis_id1,
						'nrf'=>$nrf
					];


					$this->view('receptions/new_order1',$data);
			}

			public function make_bill_ip_visit($vis_id)
			{
				 

					$vis_id = explode(',', $vis_id);
					$vis_id0 = $vis_id[0];
					$vis_id1 = $vis_id[1];
					$vis_id_det = $this->receptionModel->get_admit_details_id($vis_id0);
					$ipdDays = $this->receptionModel->getIpdDays($vis_id0);
					foreach ($vis_id_det as $key)
					{
							$opi = $key->ipd_patient_id;
							$odi = $key->ipd_doctor_id;
							$ovi = $key->ipd_admit_id;
					}
					$patient_name = $this->receptionModel->get_patient_by_id($opi);
					$doctor_name = $this->receptionModel->get_doctor_by_id($odi);
					$data = [
						'ipdDays' => $ipdDays,
						'ad_id_det_ip'=>$vis_id_det,
						'ad_id_ip'=>$ovi,
						'doctor_name_ip'=>$doctor_name,
						'patient_name_ip'=>$patient_name,
						'ty'=>$vis_id1
					];

					$this->view('receptions/new_order',$data);
			}

			public function add_patient()
			{
					$check = $_POST['check'];
					$p_name = $_POST['p_name'];
					$gen = $_POST['gen'];
					$dob = $_POST['dob'];
					$age = $_POST['age'];
					$phone = $_POST['phone'];
					$email = $_POST['email'];
					$address = $_POST['address'];
					$weight  = $_POST['weight'];
					$height = $_POST['height'];
					$country = $_POST['country'];
					if ($check == 1)
					{

						if($this->receptionModel->check_email_before_insert($email))
						{
							if($this->receptionModel->check_phno_before_insert($phone))
							{
								$this->receptionModel->add_patient_db($p_name,$gen,$age,$dob,$phone,$email,$address,$weight,$height,$country);	
								$success = true;
							}
							else
							{
								$success = false;
							}
						}else
						{
							$success = false;
						}	
					}
					else
					{
						$pat_id = $_POST['patid'];
						$_SESSION['patid_for_file_upload']=$pat_id;
						$success = $this->receptionModel->update_patient_db($pat_id,$p_name,$gen,$age,$dob,$phone,$email,$address,$weight,$height,$country);

					}
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
					 $success1 = $this->receptionModel->discharge_details_update_to_discharge_db($dis,$v_id);
					if($success)
						echo "discharged";
					else
						echo "error";

			}


			public function lab_reports_reception()
			{
					$lim = $_POST['lim'];
					$lim = (int)$lim;
					if($lim==9)
					{
						$off = $_POST['off'];
						$off = (int)$off;
						$lr = $this->receptionModel->get_lab_reports($lim,$off);
					}
					else
					{
						$inc = $_POST['inc'];
						$inc = (int)$inc;
						$lim = 9;
						$off = 9+(9*$inc);
						$lr = $this->receptionModel->get_lab_reports($lim,$off);
					}
					$lab_reports = '';
					foreach ($lr as $key)
					{
						$lab_test_values = $key->lab_test_values;
						$lab_order_id = $key->lab_test_order_id;
						$lab_test_id = $key->lab_test_id;
						$docs = $key->lab_test_document;
						$invoice_details = $this->receptionModel->get_search_orders($lab_order_id);
						foreach ($invoice_details as $test)
						{
								$patient_name = explode('|', $test->invoice_name);
								$doctor_name = explode('|', $test->invoice_doctor);
								$invoice_date = $test->invoice_date;
						}
						$lab_reports.='<tr>
							<td>'.$lab_order_id.'</td>
							<td>'.ucwords($patient_name[0]).'</td>
							<td>'.'Dr. '.ucwords($doctor_name[0]).'</td>
							<td>'.date('d-m-Y H i A', strtotime($invoice_date)).'</td>
							<td>
								<a href="'.URLROOT.'/receptions/print_lab_reports/'.$lab_order_id.'"><button style="width: 72px" type="button" class="btn btn-success btn-xs m-b-5">Print Report</button></a>';
								if(!empty($docs))
								{
							$lab_reports.='    
								<button class="btn btn-primary btn-xs m-b-5" data-toggle="modal" data-target="#exampleModal'.$lab_test_id.'">Document</button>';
							}
							$lab_reports.='
							</td>
						</tr>

						';
					}
					echo $lab_reports;
			}

			public function lab_reports_reception1()
			{
					$search = $_POST['visit_id'];
					$lr = $this->receptionModel->get_lab_reports1($search);
					$lab_reports = '';
					foreach ($lr as $key)
					{
						$lab_test_values = $key->lab_test_values;
						$lab_order_id = $key->lab_test_order_id;
						$lab_test_id = $key->lab_test_id;
						$docs = $key->lab_test_document;
						$invoice_details = $this->receptionModel->get_search_orders($lab_order_id);
						foreach ($invoice_details as $test)
						{
								$patient_name = explode('|', $test->invoice_name);
								$doctor_name = explode('|', $test->invoice_doctor);
								$invoice_date = $test->invoice_date;
						}
						$lab_reports.='<tr>
							<td>'.$lab_order_id.'</td>
							<td>'.ucwords($patient_name[0]).'</td>
							<td>'.'Dr. '.ucwords($doctor_name[0]).'</td>
							<td>'.date('d-m-Y H i A', strtotime($invoice_date)).'</td>
							<td>
								<a href="'.URLROOT.'/receptions/print_lab_reports/'.$lab_order_id.'"><button style="width: 72px" type="button" class="btn btn-success btn-xs m-b-5">Print Report</button></a>';
								if(!empty($docs))
								{
							$lab_reports.='    
								<button class="btn btn-primary btn-xs m-b-5" data-toggle="modal" data-target="#exampleModal'.$lab_test_id.'">Document</button>';
							}
							$lab_reports.='
							</td>
						</tr>'
						;
					}
					echo $lab_reports;
			}

			public function lab_reports_reception2()
			{
					$search = $_POST['patName'];
					$lr = $this->receptionModel->get_lab_reports1($search);
					$lab_reports = '';
					foreach ($lr as $key)
					{
						$lab_test_values = $key->lab_test_values;
						$lab_order_id = $key->lab_test_order_id;
						$lab_test_id = $key->lab_test_id;
						$docs = $key->lab_test_document;
						$invoice_details = $this->receptionModel->get_search_orders($lab_order_id);
						foreach ($invoice_details as $test)
						{
								$patient_name = explode('|', $test->invoice_name);
								$doctor_name = explode('|', $test->invoice_doctor);
								$invoice_date = $test->invoice_date;
						}
						$lab_reports.='<tr>
							<td>'.$lab_order_id.'</td>
							<td>'.ucwords($patient_name[0]).'</td>
							<td>'.'Dr. '.ucwords($doctor_name[0]).'</td>
							<td>'.date('d-m-Y H i A', strtotime($invoice_date)).'</td>
							<td>
								<a href="'.URLROOT.'/receptions/print_lab_reports/'.$lab_order_id.'"><button style="width: 72px" type="button" class="btn btn-success btn-xs m-b-5">Print Report</button></a>';
								if(!empty($docs))
								{
							$lab_reports.='    
								<button class="btn btn-primary btn-xs m-b-5" data-toggle="modal" data-target="#exampleModal'.$lab_test_id.'">Document</button>';
							}
							$lab_reports.='
							</td>
						</tr>'
						;
					}
					echo $lab_reports;
			}


			public function print_lab_reports($id)
			{
					$logo = $this->receptionModel->get_logo_details();
					$last_inv = $this->receptionModel->get_last_invoice($id);
					$report = $this->receptionModel->get_reports_data($id);
					$data = [
						'logo' => $logo,
						'last_inv'=>$last_inv,
						'report'=>$report
					];
					$this->view('receptions/print_lab_reports', $data);
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

							$success = $this->receptionModel->update_password_db($cpass, $id, $files_array);
							if($success)
								redirect('receptions/success_settings');
							else
								redirect('receptions/upd_err_settings');           
					}
					else
					{
							redirect('receptions/error_settings');
					}

			}

			public function cancel_invoice()
			{
					$id = $_POST['id'];
					$success = $this->receptionModel->cancel_invoice_db($id);
					if($success)
					{
						echo true;
					}
					else
					{
						echo false;
					}
			}

			public function update_admission()
			{
					$id = $_POST['id'];
					$dte = $_POST['dte'];
					$tim = $_POST['tim'];
					$ad_date = $dte;
					$ad_date .= ' ';
					$ad_date .= $tim;
					$ac_date = date('Y-m-d H:i:s', strtotime($ad_date));
					$success = $this->receptionModel->update_admission_date($id, $ac_date);
					redirect('receptions/all_admissions');
			}

			public function update_discharge()
			{
					$id = $_POST['id'];
					$dte = $_POST['dte'];
					$tim = $_POST['tim'];
					$ad_date = $dte;
					$ad_date .= ' ';
					$ad_date .= $tim;
					$ac_date = date('Y-m-d H:i:s', strtotime($ad_date));
					$success = $this->receptionModel->update_discharge_date($id, $ac_date);
					redirect('receptions/all_admissions');
			}

			public function today_report()
			{
					$today_date = date('Y-m-d');
					$tdy = date('Y-m-d');
					$ord_count = $this->receptionModel->get_order_count_today($tdy);
					$revenue = $this->receptionModel->get_revenue_count($tdy);
					$discount = $this->receptionModel->get_discount_count($tdy);
					$data = [
						'ord_count' => $ord_count,
						'rev' => $revenue,
						'dis' => $discount,
						'date_filter' => $today_date
					];
					$this->view('receptions/get_report', $data);
			}

			public function monthly_report()
			{
					$month_date = date('Y-m-01');
					$mnt = date('Y-m-01');
					$mntl = date('Y-m-31');
					$today = date('Y-m-d');
					$ord_count = $this->receptionModel->get_order_count_month($mnt, $mntl);
					$revenue = $this->receptionModel->get_revenue_count_month($mnt, $mntl);
					$discount = $this->receptionModel->get_discount_count_month($mnt, $mntl);
					$data = [
						'ord_count' => $ord_count,
						'rev' => $revenue,
						'dis' => $discount,
						'month_date' => $month_date,
						'today' => $today
					];
					$this->view('receptions/get_report', $data);
			}

			public function yearly_report()
			{
					$year_date = date('Y-01-01');
					$today =date('Y-m-d');
					$yr = date('Y-01-01');
					$yrl = date('Y-12-31');
					$ord_count = $this->receptionModel->get_order_count_yr($yr, $yrl);
					$revenue = $this->receptionModel->get_revenue_count_yr($yr, $yrl);
					$discount = $this->receptionModel->get_discount_count_yr($yr, $yrl);
					$data = [
						'ord_count' => $ord_count,
						'rev' => $revenue,
						'dis' => $discount,
						'year_date' => $year_date,
						'today' => $today
					];  
					$this->view('receptions/get_report', $data);
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
					$all_invoice = $this->receptionModel->get_today_report($dat,$lim,$off);
				}
				else
				{
					$inc = $_POST['inc'];
					$inc = (int)$inc;
					$lim = 9;
					$off = 9+(9*$inc);
					$all_invoice = $this->receptionModel->get_today_report($dat,$lim,$off);
				}
				$all_orders_print = '';

				foreach ($all_invoice as $key)
				{
					$invoice_id = $key->invoice_id;
					$invoice_name = explode('|',$key->invoice_name);
					$invoice_total = $key->invoice_total;
					$invoice_bill = $key->invoice_bill;
					$invoice_date = $key->invoice_date;
					$dep_type = $key->department;
					$cancel = $key->cancelled;
					$all_orders_print.='<tr>
						<td>';
						if($dep_type==1)
						{
							$all_orders_print.='<span class="badge badge-pill badge-warning" style="background-color:#FF3366;">L</span>&nbsp;';
						}
						else
						{
							$all_orders_print.='<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;';
						}
					 $all_orders_print.=''.$invoice_id.'</td>
						<td style="text-align:left;">'.$invoice_name[0].'</td>
						<td>'.$invoice_total.'</td>
						<td>'.$invoice_bill.'</td>
						<td>'.date('d-m-Y', strtotime($invoice_date)).'</td>
						<td>';
						if($cancel != 1)
						{
							if($dep_type==1)
							{
								$all_orders_print.='
									<a href="'.URLROOT.'/receptions/print_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-success btn-xs m-b-5">Print</button></a>
									<a href="'.URLROOT.'/receptions/view_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-purple btn-xs m-b-5">View</button></a>';
							}

							else
							{
								$all_orders_print.='<a href="'.URLROOT.'/receptions/print_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-success btn-xs m-b-5">Print</button></a>
									<a href="'.URLROOT.'/receptions/view_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-purple btn-xs m-b-5">View</button></a>';
							}
						}
						else
						{
								 $all_orders_print.='<a style="width: 7s4px;" type="button" class="btn btn-danger btn-xs m-b-5">Cancelled</a>';
						}

						$all_orders_print.='</td>

					</tr>';
				}
				echo $all_orders_print;          
			}


			public function patient_report_custom()
			{
				$to = $_POST['to'];
				$frm = $_POST['frm'];
				$lim = $_POST['lim'];
				$lim = (int)$lim;
				if($lim==9)
				{
					$off = $_POST['off'];
					$off = (int)$off;
					$all_invoice = $this->receptionModel->get_month_report($to,$frm,$lim,$off);
				}
				else
				{
					$inc = $_POST['inc'];
					$inc = (int)$inc;
					$lim = 9;
					$off = 9+(9*$inc);
					$all_invoice = $this->receptionModel->get_month_report($to,$frm,$lim,$off);
				}
				$all_orders_print = '';

				foreach ($all_invoice as $key)
				{
					$invoice_id = $key->invoice_id;
					$invoice_name = explode('|', $key->invoice_name);
					$invoice_total = $key->invoice_total;
					$invoice_bill = $key->invoice_bill;
					$invoice_date = $key->invoice_date;
					$doctor = $key->invoice_doctor;
					$dep_type = $key->department;
					$cancel = $key->cancelled;
					$all_orders_print.='<tr>
						<td>';
						if($dep_type==1)
						{
							$all_orders_print.='<span class="badge badge-pill badge-warning" style="background-color:#FF3366;">L</span>&nbsp;';
						}
						else
						{
							$all_orders_print.='<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;';
						}
					 $all_orders_print.=''.$invoice_id.'</td>
						<td style="text-align:left;">'.ucwords($invoice_name[0]).'</td>
						<td>'.$invoice_total.'</td>
						<td>'.$invoice_bill.'</td>
						<td>'.date('d-m-Y h:i A', strtotime($invoice_date)).'</td>
						<td style="text-align:left; padding-left:120px;">';
						if($cancel != 1)
						{
							if($dep_type==1)
							{
								$all_orders_print.='
									<a href="'.URLROOT.'/receptions/print_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-success btn-xs m-b-5">Print</button></a>
									<a href="'.URLROOT.'/receptions/view_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-purple btn-xs m-b-5">View</button></a>';
							}

							else
							{
								$all_orders_print.='<a href="'.URLROOT.'/receptions/print_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-success btn-xs m-b-5">Print</button></a>
									<a href="'.URLROOT.'/receptions/view_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-purple btn-xs m-b-5">View</button></a>';
							}
						}
						else
						{
								 $all_orders_print.='<a style="width: 7s4px;" type="button" class="btn btn-danger btn-xs m-b-5">Cancelled</a>';
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
					$all_invoice = $this->receptionModel->get_month_report($month_date,$today,$lim,$off);
				}
				else
				{
					$inc = $_POST['inc'];
					$inc = (int)$inc;
					$lim = 9;
					$off = 9+(9*$inc);
					$all_invoice = $this->receptionModel->get_month_report($month_date,$today,$lim,$off);
				}
				$all_orders_print = '';

				foreach ($all_invoice as $key)
				{
					$invoice_id = $key->invoice_id;
					$invoice_name = explode('|', $key->invoice_name);
					$invoice_total = $key->invoice_total;
					$invoice_bill = $key->invoice_bill;
					$invoice_date = $key->invoice_date;
					$doctor = $key->invoice_doctor;
					$dep_type = $key->department;
					$cancel = $key->cancelled;
					$all_orders_print.='<tr>
						<td>';
						if($dep_type==1)
						{
							$all_orders_print.='<span class="badge badge-pill badge-warning" style="background-color:#FF3366;">L</span>&nbsp;';
						}
						else
						{
							$all_orders_print.='<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;';
						}
					 $all_orders_print.=''.$invoice_id.'</td>
						<td style="text-align:left;">'.ucwords($invoice_name[0]).'</td>
						<td>'.$invoice_total.'</td>
						<td>'.$invoice_bill.'</td>
						<td>'.date('d-m-Y', strtotime($invoice_date)).'</td>
						<td style="text-align:left; padding-left:110px;">';
						if($cancel != 1)
						{
							if($dep_type==1)
							{
								$all_orders_print.='
									<a href="'.URLROOT.'/receptions/print_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-success btn-xs m-b-5">Print</button></a>
									<a href="'.URLROOT.'/receptions/view_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-purple btn-xs m-b-5">View</button></a>';
							}

							else
							{
								$all_orders_print.='<a href="'.URLROOT.'/receptions/print_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-success btn-xs m-b-5">Print</button></a>
									<a href="'.URLROOT.'/receptions/view_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-purple btn-xs m-b-5">View</button></a>';
							}
						}
						else
						{
								 $all_orders_print.='<a style="width: 7s4px;" type="button" class="btn btn-danger btn-xs m-b-5">Cancelled</a>';
						}

						$all_orders_print.='</td>

					</tr>';
				}
				echo $all_orders_print;          
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
					$all_invoice = $this->receptionModel->get_month_report($year_date,$today,$lim,$off);
				}
				else
				{
					$inc = $_POST['inc'];
					$inc = (int)$inc;
					$lim = 9;
					$off = 9+(9*$inc);
					$all_invoice = $this->receptionModel->get_month_report($year_date,$today,$lim,$off);
				}
				$all_orders_print = '';

				foreach ($all_invoice as $key)
				{
					$invoice_id = $key->invoice_id;
					$invoice_name = explode('|', $key->invoice_name);
					$invoice_total = $key->invoice_total;
					$invoice_bill = $key->invoice_bill;
					$invoice_date = $key->invoice_date;
					$dep_type = $key->department;
					$cancel = $key->cancelled;
					$doctor = $key->invoice_doctor;
					$all_orders_print.='<tr>
						<td>';
						if($dep_type==1)
						{
							$all_orders_print.='<span class="badge badge-pill badge-warning" style="background-color:#FF3366;">L</span>&nbsp;';
						}
						else
						{
							$all_orders_print.='<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;';
						}
					 $all_orders_print.=''.$invoice_id.'</td>
						<td style="text-align:left;">'.ucwords($invoice_name[0]).'</td>
						<td>'.$invoice_total.'</td>
						<td>'.$invoice_bill.'</td>
						<td>'.date('d-m-Y', strtotime($invoice_date)).'</td>
						<td style="text-align:left; padding-left:110px;">';
						if($cancel != 1)
						{
							if($dep_type==1)
							{
								$all_orders_print.='
									<a href="'.URLROOT.'/receptions/print_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-success btn-xs m-b-5">Print</button></a>
									<a href="'.URLROOT.'/receptions/view_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-purple btn-xs m-b-5">View</button></a>';
							}

							else
							{
								$all_orders_print.='<a href="'.URLROOT.'/receptions/print_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-success btn-xs m-b-5">Print</button></a>
									<a href="'.URLROOT.'/receptions/view_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-purple btn-xs m-b-5">View</button></a>';
							}
						}
						else
						{
								 $all_orders_print.='<button style="width: 7s4px;" type="button" class="btn btn-danger btn-xs m-b-5">Cancelled</button>';
						}

						$all_orders_print.='</td>

					</tr>';
				}
				echo $all_orders_print;          
			}

			public function invoice_print_count($invoice_id)
			{
					$this->receptionModel->invoice_print_count_db($invoice_id);
					return true;
			}

			public function view_profile_patient($id)
			{
					$p_data = $this->receptionModel->get_patient_by_id($id);
					$opd_data = $this->doctorModel->get_opd_patient_id2($id);
					$ipd_data = $this->doctorModel->get_all_ipd_addmission($id);
					$data = [
						'p_data' => $p_data,
						'opd_data' => $opd_data,
						'ipd_data' => $ipd_data
					];
					$this->view('receptions/view_profile_patient', $data);
			} 

			public function get_doc($id)
			{
				$doc_name = $this->doctorModel->get_doc_name($id);
				return $doc_name;
			}

			public function get_all_opd_data($v_id)
			{
					$opd_data = $this->doctorModel->get_opd_data($v_id);
					return $opd_data;
			}

			public function custom_date()
			{
					$to = $_POST['to'];
					$from = $_POST['from'];
					$ord_count = $this->receptionModel->get_order_count_cus($to, $from);
					$revenue = $this->receptionModel->get_revenue_count_cus($to, $from);
					$discount = $this->receptionModel->get_discount_count_cus($to, $from);
					$data = [
						'ord_count' => $ord_count,
						'rev' => $revenue,
						'dis' => $discount,
						'to_cust' => $to,
						'from_cust' => $from
					];
					$this->view('receptions/get_report', $data);
			} 

			public function discharge_summary()
			{
					$id = $_POST['admit'];
					$pat_id = $_POST['pat'];
					$data = [
						'ipd_days_data' => $this->doctorModel->get_ipd_days($id),
						'ipd' => $this->doctorModel->get_ipd_main_data($id),
						'logo' => $this->receptionModel->get_logo_details(),
						'patient_id' => $pat_id
					];
					$this->view('receptions/discharge_summary', $data);
			}

			public function discharge_summary_admit($patAndId)
			{
					$patAndId = explode(',', $patAndId);
					$id = $patAndId[1];
					$pat_id = $patAndId[0];
					$data = [
						'ipd_days_data' => $this->doctorModel->get_ipd_days($id),
						'ipd' => $this->doctorModel->get_ipd_main_data($id),
						'logo' => $this->receptionModel->get_logo_details(),
						'patient_id' => $pat_id
					];
					$this->view('receptions/discharge_summary', $data);
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

			public function print_admit_medicines($id)
			{
				$data = [
					'ipd_days'  => $this->doctorModel->get_ipd_days($id),
					'ipd' => $this->doctorModel->get_ipd_main_data($id),
					'logo' => $this->receptionModel->get_logo_details()
				];
				$this->view('receptions/print_admit_medicines', $data);
			}

			public function removed_pat_disp()
			{
					$this->view('receptions/removed_pat_disp');
			}

			public function all_patients_rem()
			{
					$lim = $_POST['lim'];
					$lim = (int)$lim;
					if($lim==9)
					{
						$off = $_POST['off'];
						$off = (int)$off;
						$all_patients = $this->receptionModel->get_all_patients_rem($lim,$off);
					}
					else
					{
						$inc = $_POST['inc'];
						$inc = (int)$inc;
						$lim = 9;
						$off = 9+(9*$inc);
						$all_patients = $this->receptionModel->get_all_patients_rem($lim,$off);
					}
					$all_orders_print = '';

					foreach ($all_patients as $key)
					{
							$patient_id = $key->patient_id;
							$patient_name = $key->patient_name;
							$patient_gender = $key->patient_gender;
							$patient_dob = $key->patient_dob;
							$patinet_phone = $key->patient_phone;
							$patient_email = $key->patient_email;
							$patinet_address = $key->patient_address;
							$all_orders_print.='<tr>
							<td>'.$patient_id.'</td>
							<td>'.$patient_name.'</td>
							<td>'.$patient_gender.'</td>
							<td>'.$patinet_phone.'<br>'.$patient_email.'</td>
							<td>'.$patinet_address.'</td>
							<td>
									<button style="width: 54px" type="button" class="btn btn-success btn-xs m-b-5" onclick="restore_pat('.$patient_id.')">Restore</button>
							</td>
						</tr>';
					}
					echo $all_orders_print;
			}

			public function all_patients2_rem()
			{
					$sear = $_POST['sear'];
					$all_patients = $this->receptionModel->get_patient_by_id_like_rem($sear);
					$all_orders_print = '';

					foreach ($all_patients as $key)
					{
							$patient_id = $key->patient_id;
							$patient_name = $key->patient_name;
							$patient_gender = $key->patient_gender;
							$patient_dob = $key->patient_dob;
							$patinet_phone = $key->patient_phone;
							$patient_email = $key->patient_email;
							$patinet_address = $key->patient_address;
							$all_orders_print.='<tr>
							<td>'.$patient_id.'</td>
							<td>'.$patient_name.'</td>
							<td>'.$patient_gender.'</td>
							<td>'.$patinet_phone.'<br>'.$patient_email.'</td>
							<td>'.$patinet_address.'</td>
							<td>
									 <button style="width: 54px" type="button" class="btn btn-success btn-xs m-b-5" onclick="restore_pat('.$patient_id.')">Restore</button>
							</td>
						</tr>';
					}
					echo $all_orders_print;
			} 

			public function all_patients3_rem()
			{
					$sear = $_POST['sear'];
					$all_patients = $this->receptionModel->get_patient_by_name_like_rem($sear);
					$all_orders_print = '';

					foreach ($all_patients as $key)
					{
							$patient_id = $key->patient_id;
							$patient_name = $key->patient_name;
							$patient_gender = $key->patient_gender;
							$patient_dob = $key->patient_dob;
							$patinet_phone = $key->patient_phone;
							$patient_email = $key->patient_email;
							$patinet_address = $key->patient_address;
							$all_orders_print.='<tr>
							<td>'.$patient_id.'</td>
							<td>'.$patient_name.'</td>
							<td>'.$patient_gender.'</td>
							<td>'.$patinet_phone.'<br>'.$patient_email.'</td>
							<td>'.$patinet_address.'</td>
							<td>
									<button style="width: 54px" type="button" class="btn btn-success btn-xs m-b-5" onclick="restore_pat('.$patient_id.')">Restore</button>
							</td>
						</tr>';
					}
					echo $all_orders_print;
			}

			public function all_patients4_rem()
			{
					$sear = $_POST['sear'];
					$all_patients = $this->receptionModel->get_patient_by_phone_like_rem($sear);
					$all_orders_print = '';

					foreach ($all_patients as $key)
					{
							$patient_id = $key->patient_id;
							$patient_name = $key->patient_name;
							$patient_gender = $key->patient_gender;
							$patient_dob = $key->patient_dob;
							$patinet_phone = $key->patient_phone;
							$patient_email = $key->patient_email;
							$patinet_address = $key->patient_address;
							$all_orders_print.='<tr>
							<td>'.$patient_id.'</td>
							<td>'.$patient_name.'</td>
							<td>'.$patient_gender.'</td>
							<td>'.$patinet_phone.'<br>'.$patient_email.'</td>
							<td>'.$patinet_address.'</td>
							<td>
									<a href="'.URLROOT.'/receptions/edit_patient/'.$patient_id.'"><button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button></a>
									<a href="'.URLROOT.'/receptions/view_profile_patient/'.$patient_id.'"><button style="width: 54px" type="button" class="btn btn-purple btn-xs m-b-5">View</button></a>
									<button style="width: 54px" type="button" class="btn btn-warning btn-xs m-b-5" onclick="remove_pat('.$patient_id.')">Remove</button>
							</td>
						</tr>';
					}
					echo $all_orders_print;
			}

			public function test()
			{
					$this->view('receptions/test');
			} 

			public function get_patients_data_to_print($ppid)
			{
					return $pdata = $this->receptionModel->get_patient_by_id($ppid);
			}  
			

			public function help()
			{
					$this->view('receptions/help');
			} 

			public function active_orders()
			{
					$this->view('receptions/active_orders');
			}

			public function all_orders_active()
			{
				$lim = $_POST['lim'];
				$lim = (int)$lim;
				if($lim==9)
				{
					$off = $_POST['off'];
					$off = (int)$off;
					$all_invoice = $this->receptionModel->get_all_orders_active($lim,$off);
				}
				else
				{
					$inc = $_POST['inc'];
					$inc = (int)$inc;
					$lim = 9;
					$off = 9+(9*$inc);
					$all_invoice = $this->receptionModel->get_all_orders_active($lim,$off);
				}
				$all_orders_print = '';

				foreach ($all_invoice as $key)
				{
					$invoice_id = $key->invoice_id;
					$invoice_name = explode(' | ', $key->invoice_name);
					$invoice_total = $key->invoice_total;
					$invoice_bill = $key->invoice_bill;
					$invoice_date = $key->invoice_date;
					$dep_type = $key->department;
					$cancel = $key->cancelled;
					$all_orders_print.='<tr>
						<td style="padding-top:15px; text-align:left;">';
						if($dep_type==1)
						{
							$all_orders_print.='<span class="badge badge-pill badge-warning" style="background-color:#FA8B50;">L</span>&nbsp;';
						}
						else
						{
							$all_orders_print.='<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;';
						}
					 $all_orders_print.=''.$invoice_id.'</td>
						<td style="padding-top:15px; text-align:left;">'.ucwords($invoice_name[0]).'</td>
						<td style="padding-top:15px;">'.$invoice_bill.'</td>
						<td style="padding-top:15px;">'.$invoice_total.'</td>
						<td style="padding-top:15px;">'.date('d-m-Y H:i: A', strtotime($invoice_date)).'</td>
						<td style="padding-top:15px; text-align:center;">';
						if($cancel != 1)
						{
							if($dep_type==1)
							{
								// $all_orders_print.='
								// 	<a href="'.URLROOT.'/receptions/edit_order/'.$invoice_id.'"><button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button></a>
								// 	<button style="width: 54px" type="button" class="btn btn-warning btn-xs m-b-5" onclick="cancel_order('.$invoice_id.')">Cancel</button>
								// 	<a href="'.URLROOT.'/receptions/print_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-success btn-xs m-b-5">Print</button></a>';
									
									
									$all_orders_print.='
									<a href="'.URLROOT.'/receptions/edit_order/'.$invoice_id.'"><button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button></a>
									<a href="'.URLROOT.'/receptions/print_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-success btn-xs m-b-5">Print</button></a>';
								
							}

							else
							{
								// $all_orders_print.='
								// 	<a href="'.URLROOT.'/receptions/edit_order/'.$invoice_id.'"><button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button></a>
								// 	<button style="width: 54px" type="button" class="btn btn-warning btn-xs m-b-5" onclick="cancel_order('.$invoice_id.')">Cancel</button>
								// 	<a href="'.URLROOT.'/receptions/print_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-success btn-xs m-b-5">Print</button></a>';
									
									
									$all_orders_print.='
									<a href="'.URLROOT.'/receptions/edit_order/'.$invoice_id.'"><button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button></a>
									<a href="'.URLROOT.'/receptions/print_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-success btn-xs m-b-5">Print</button></a>';
							}
						}
						else
						{
								$all_orders_print.='<button style="width: 7s4px;background-color:#FF7043; color:white;" type="button" class="btn btn btn-xs m-b-5">Cancelled</button>';
						}

						$all_orders_print.='</td>

					</tr>';
				}
				echo $all_orders_print;
			} 

			public function all_orders_active_by_id()
			{
				$inv_id = $_POST['inv'];
				$single_invoice = $this->receptionModel->get_search_orders_active($inv_id);
				$all_orders_print = '';

				foreach ($single_invoice as $key)
				{
					$invoice_id = $key->invoice_id;
					$invoice_name = explode(' | ', $key->invoice_name);
					$invoice_total = $key->invoice_total;
					$invoice_bill = $key->invoice_bill;
					$invoice_date = $key->invoice_date;
					$dep_type = $key->department;
					$cancel = $key->cancelled;
					$all_orders_print.='<tr>
						<td style="padding-top:15px; text-align:left;">';
						if($dep_type==1)
						{
							$all_orders_print.='<span class="badge badge-pill badge-warning" style="background-color:#FF3366;">L</span>&nbsp;';
						}
						else
						{
							$all_orders_print.='<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;';
						}
					 $all_orders_print.=''.$invoice_id.'</td>
						<td style="padding-top:15px; text-align:left;">'.ucwords($invoice_name[0]).'</td>
						<td style="padding-top:15px;">'.$invoice_bill.'</td>
						<td style="padding-top:15px;">'.$invoice_total.'</td>
						<td style="padding-top:15px;">'.date('d-m-Y H:i: A', strtotime($invoice_date)).'</td>
						<td style="padding-top:15px; text-align:center;">';
						if($cancel != 1)
						{
							if($dep_type==1)
							{
								$all_orders_print.='
									<a href="'.URLROOT.'/receptions/edit_order/'.$invoice_id.'"><button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button></a>';
							}

							else
							{
								$all_orders_print.='
									<a href="'.URLROOT.'/receptions/edit_order/'.$invoice_id.'"><button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button></a>';
							}
						}
						else
						{
								 $all_orders_print.='<button style="width: 7s4px;background-color:#FF7043; color:white;" type="button" class="btn btn btn-xs m-b-5">Cancelled</button>';
						}

						$all_orders_print.='</td>

					</tr>';
				}
					echo $all_orders_print;
			}

			public function search_by_name_value_active()
			{
				$patient_name = $_POST['patient_name'];
				$patients_list= $this->receptionModel->get_patient_orders_active($patient_name);
				$all_orders_print = '';

				foreach ($patients_list as $key)
				{
					$invoice_id = $key->invoice_id;
					$invoice_name = explode(' | ', $key->invoice_name);
					$invoice_total = $key->invoice_total;
					$invoice_bill = $key->invoice_bill;
					$invoice_date = $key->invoice_date;
					$dep_type = $key->department;
					$cancel = $key->cancelled;
					$all_orders_print.='<tr>
						<td style="padding-top:15px; text-align:left;">';
						if($dep_type==1)
						{
							$all_orders_print.='<span class="badge badge-pill badge-warning" style="background-color:#FF3366;">L</span>&nbsp;';
						}
						else
						{
							$all_orders_print.='<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;';
						}
					 $all_orders_print.=''.$invoice_id.'</td>
						<td style="padding-top:15px; text-align:left;">'.ucwords($invoice_name[0]).'</td>
						<td style="padding-top:15px;">'.$invoice_bill.'</td>
						<td style="padding-top:15px;">'.$invoice_total.'</td>
						<td style="padding-top:15px;">'.date('d-m-Y H:i: A', strtotime($invoice_date)).'</td>
						<td style="padding-top:15px; text-align:center;">';
						if($cancel != 1)
						{
							if($dep_type==1)
							{
								$all_orders_print.='
									<a href="'.URLROOT.'/receptions/edit_order/'.$invoice_id.'"><button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button></a>';
							}

							else
							{
								$all_orders_print.='
									<a href="'.URLROOT.'/receptions/edit_order/'.$invoice_id.'"><button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button></a>';
							}
						}
						else
						{
								 $all_orders_print.='<button style="width: 7s4px;background-color:#FF7043; color:white;" type="button" class="btn btn btn-xs m-b-5">Cancelled</button>';
						}

						$all_orders_print.='</td>

					</tr>';
				}
					echo $all_orders_print;
			}

			public function get_all_orders_wrt_dates_active()
			{
				$start = $_POST['start'];
				$end = $_POST['end'];
				$single_invoice = $this->receptionModel->get_all_orders_wrt_dates_db_active($start, $end);
				$all_orders_print = '';

				foreach ($single_invoice as $key)
				{
					$invoice_id = $key->invoice_id;
					$invoice_name = explode(' | ', $key->invoice_name);
					$invoice_total = $key->invoice_total;
					$invoice_bill = $key->invoice_bill;
					$invoice_date = $key->invoice_date;
					$dep_type = $key->department;
					$cancel = $key->cancelled;
					$all_orders_print.='<tr>
						<td style="padding-top:15px; text-align:left;">';
						if($dep_type==1)
						{
							$all_orders_print.='<span class="badge badge-pill badge-warning" style="background-color:#FF3366;">L</span>&nbsp;';
						}
						else
						{
							$all_orders_print.='<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;';
						}
					 $all_orders_print.=''.$invoice_id.'</td>
						<td style="padding-top:15px; text-align:left;">'.ucwords($invoice_name[0]).'</td>
						<td style="padding-top:15px;">'.$invoice_bill.'</td>
						<td style="padding-top:15px;">'.$invoice_total.'</td>
						<td style="padding-top:15px;">'.date('d-m-Y H:i: A', strtotime($invoice_date)).'</td>
						<td style="padding-top:15px; text-align:center;">';
						if($cancel != 1)
						{
							if($dep_type==1)
							{
								$all_orders_print.='
									<a href="'.URLROOT.'/receptions/edit_order/'.$invoice_id.'"><button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button></a>';
							}

							else
							{
								$all_orders_print.='
									<a href="'.URLROOT.'/receptions/edit_order/'.$invoice_id.'"><button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button></a>';
							}
						}
						else
						{
								 $all_orders_print.='<button style="width: 7s4px;background-color:#FF7043; color:white;" type="button" class="btn btn btn-xs m-b-5">Cancelled</button>';
						}

						$all_orders_print.='</td>

					</tr>';
				}
					echo $all_orders_print;
			}

			public function at_test()
			{
					$search = $_POST['search'];
					$ad = $this->receptionModel->get_patient_by_name_like($search);
					foreach ($ad as $key)
					{
							$response[] = array("value"=>$key->patient_id.$key->patient_name,"label"=>ucwords($key->patient_name).'('.$key->patient_id.')');
					}
					echo json_encode($response);
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


			public function previl()
			{
				$this->view('receptions/previl');
			}

			public function create_admission1()
			{
					
				if(!empty($_POST['p_name']))
					{
						$p_name = $_POST['p_name'];
						$result = $this->receptionModel->check_ip_name_exist($p_name);
						$result1 = $this->receptionModel->check_ip_name_exist_and_discharge($p_name);
						if($result>=1)
						{
									
											 if ($result1->discharge_status==2)
											 {
														 $p_name = $_POST['p_name'];
														$d_name = $_POST['d_name'];
														$v_pur = $_POST['visit_pur'];
														$adm_date1 = $_POST['adm_date1'];
														$success = $this->receptionModel->create_admission_db1($p_name,$d_name,$v_pur,$adm_date1);
														 $success1 = $this->receptionModel->add_ip_admission_date_to_db1($p_name,$adm_date1);
														if($success)
															echo "updated";
														else
															echo "error";
											 }
											 else
											 {
													echo "patient already Added";
											 }
									
						}
						else
						{
											$p_name = $_POST['p_name'];
											$d_name = $_POST['d_name'];
											$v_pur = $_POST['visit_pur'];
											$adm_date1 = $_POST['adm_date1'];
											$success = $this->receptionModel->create_admission_db1($p_name,$d_name,$v_pur,$adm_date1);
											 $success1 = $this->receptionModel->add_ip_admission_date_to_db1($p_name,$adm_date1);
											if($success)
												echo "updated";
											else
												echo "error";
						}
					}
					else
					{
						echo "Enter patient name first!";
					}


			}

			public function get_all_patient_details($patient_id)
			{
				return $p_data = $this->receptionModel->get_patient_by_id($patient_id);
			}

			public function undo_cancel()
			{
					$id = $_POST['id'];
					$success = $this->receptionModel->undo_cancel_db($id);
					if($success)
					{
						echo true;
					}
					else
					{
						echo false;
					}
			}

			public function upload_file_from_visit()
			{
					$visit_id = $_POST['visit_id'];
					$rep_tit = $_POST['rep_tit'];
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
					$this->receptionModel->upload_file_from_visit_db($visit_id, $rep_tit, $files_array);
					redirect('receptions/all_visit');
			}

			public function upload_file_from_admit()
			{
				$admitId = $_POST['admitId'];
				$rep_tit = $_POST['rep_tit'];
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
				$this->receptionModel->upload_file_from_admit_db($admitId, $rep_tit, $files_array);
				redirect('receptions/all_admissions');
			}

			public function patient_photo_upload()
			{
				
					$f_name=$_FILES['file']['name'];
					$f_tmp=$_FILES['file']['tmp_name'];
					$size=$_FILES['file']['size'];
					$f_extension=explode('.', $f_name);
					$f_extension=strtolower(end($f_extension));
					$f_newfile=uniqid().'.'.$f_extension;
					$store="patient_photos/".$f_newfile;
					move_uploaded_file($f_tmp, $store);
					$files_array = $f_newfile;
					$store="patient_photos/";
				

					$success = $this->receptionModel->patient_photo_upload_db($files_array);
					if($success)
					{
						echo $success;
					}
					else
					{
						echo $success;
					}
			}

			public function patient_photo_upload1()
			{
				 
					$f_name=$_FILES['file']['name'];
					$f_tmp=$_FILES['file']['tmp_name'];
					$size=$_FILES['file']['size'];
					$f_extension=explode('.', $f_name);
					$f_extension=strtolower(end($f_extension));
					$f_newfile=uniqid().'.'.$f_extension;
					$store="patient_photos/".$f_newfile;
					move_uploaded_file($f_tmp, $store);
					$files_array = $f_newfile;
					$store="patient_photos/";
					$patient_id = $_SESSION['patid_for_file_upload'];
					$success = $this->receptionModel->patient_photo_upload_db1($files_array,$patient_id);
					if($success)
					{
						echo $success;
					}
					else
					{
						echo $success;
					}
			}

	





	//start start start 
		public function op_record_operation()
		{
			$this->view('receptions/op_record_operation');
		}

		public function record_operation()
		{
			$pdata = $this->receptionModel->get_patient_ot_details();
					$data = [
										'pdata' => $pdata
					];
			$this->view('receptions/get_report_op', $data);
		}

		 public function yearly_report1()
			{
					$year_date = date('Y-01-01');
					$today =date('Y-m-d');
					$yr = date('Y-01-01 00:00:00');
					$yrl = date('Y-12-31 00:00:00');
					$pdata = $this->receptionModel->get_patient_ot_details($yr, $yrl);
					$data = [
										'pdata' => $pdata
					];  
					 $this->view('receptions/get_report_op', $data);
			}
			public function to_from_report()
			{
				

					$year_date = date('Y-01-01');
					$today =date('Y-m-d');
					$yr = date($_POST['to'].' 00:00:00');
					$yrl = date($_POST['from'].' 00:00:00');
					$pdata = $this->receptionModel->get_patient_ot_details($yr, $yrl);
					$data = [
										'pdata' => $pdata
					];  
					 $this->view('receptions/get_report_op', $data);
			}

			 public function monthly_report1()
			{
				

					$year_date = date('Y-01-01');
					$today =date('Y-m-d');
					$yr = date('Y-m-01 00:00:00');
					$yrl = date('Y-m-31 00:00:00');
					$pdata = $this->receptionModel->get_patient_ot_details($yr, $yrl);
					$data = [
										'pdata' => $pdata
					];  
					 $this->view('receptions/get_report_op', $data);
			}

			 public function day_report1()
			{
				

					$year_date = date('Y-01-01');
					$today =date('Y-m-d');
					$yr = date('Y-m-d 00:00:00');
					$yrl = date('Y-m-d 00:00:00');
					$pdata = $this->receptionModel->get_patient_ot_details($yr, $yrl);
					$data = [
										'pdata' => $pdata
					];  
					 $this->view('receptions/get_report_op', $data);
			}
			 public function view_operation_report($id)
			{
					
						$logo = $this->receptionModel->get_logo_details();
						$op = $this->receptionModel->get_patient_ot_details_byid($id);
							$service = $this->receptionModel->get_parent_service($op ->ot_id);
						$fix_service = $this->receptionModel->get_fix_op_services();
						$sum=0;
						$sum1=0;
						foreach ($fix_service as $key) {
							$sum1=(int)$key->cost + (int)$sum1;
						}

						foreach ($service as $key) {
							$sum=(int)$key->price + (int)$sum;
						}

						$sum = (int)$sum + (int)$sum1;
						$data = [
								'logo' => $logo,
					'ot_id' => $op ->ot_id,
				'patient_id' => $op ->patient_id,
				'patient_name' => $op ->patient_name,
				'patient_gender' => $op ->patient_gender,
				'patient_dob' => $op ->patient_dob,
				'patient_age' => $op ->patient_age,
				'ip_op_ref' => $op ->ip_op_ref,
				'ot_date' => $op ->ot_date,
				'ot_name' => $op ->ot_name,
				'ot_description' => $op ->ot_description,
				'status' => $op ->status,
				'feedback' => $op ->feedback,
				'created_at' => $op ->created_at,
				'admission_date_time' => $op ->admission_date_time,
				'mem_name' => $op->mem_name,
				'services' => $service,
											'sum' => $sum,
											'fix_service' => $fix_service
						];
					
					$this->view('receptions/view_operation_report',$data);
			}
			 public function print_operation_details($id)
			{
					
						$logo = $this->receptionModel->get_logo_details();
						$op = $this->receptionModel->get_patient_ot_details_byid($id);
						$service = $this->receptionModel->get_parent_service($op ->ot_id);
						$fix_service = $this->receptionModel->get_fix_op_services();
						$sum=0;
						$sum1=0;
						foreach ($fix_service as $key) {
							$sum1=(int)$key->cost + (int)$sum1;
						}

						foreach ($service as $key) {
							$sum=(int)$key->price + (int)$sum;
						}

						$sum = (int)$sum + (int)$sum1;
						
						$data = [
											'logo' => $logo,
											'ot_id' => $op ->ot_id,
											'patient_id' => $op ->patient_id,
											'patient_name' => $op ->patient_name,
											'patient_gender' => $op ->patient_gender,
											'patient_dob' => $op ->patient_dob,
											'patient_age' => $op ->patient_age,
											'ip_op_ref' => $op ->ip_op_ref,
											'ot_date' => $op ->ot_date,
											'ot_name' => $op ->ot_name,
											'ot_description' => $op ->ot_description,
											'status' => $op ->status,
											'feedback' => $op ->feedback,
											'created_at' => $op ->created_at,
											'admission_date_time' => $op ->admission_date_time,
											'mem_name' => $op->mem_name,
											'services' => $service,
											'sum' => $sum,
											'fix_service' => $fix_service
						];
					
					$this->view('receptions/print_operation_details',$data);
			}
			public function new_operation_service()
			{
				$rows=$this->receptionModel->get_fix_op_services();
				$data=[
					'rows' => $rows
				];
				$this->view('receptions/new_operation_service',$data);
			}
			public function add_operation_service()
			{
					if(!empty($_POST['s_name']))
				{
						$s_name = $_POST['s_name'];
						$s_cost = $_POST['s_cost'];
						$this->receptionModel->add_fix_service($s_name,$s_cost);
						redirect('receptions/new_operation_service');
				}
				else
				{
					
					redirect('receptions/new_operation_service');
				}
				
			}
			public function delete_op_service($id)
			{
					
						$this->receptionModel->delete_fix_service($id);
						redirect('receptions/new_operation_service');
			
				
			}
			 public function allxraydetails()
			{
					$this->view('receptions/allxraydetails');
			}
			 public function new_xray()
			{
					$this->view('receptions/new_xray');
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

					$success = $this->receptionModel->doc_upload_jq_db($files_array);
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
					$success = $this->receptionModel->save_other_upload_details_db($ip_id, $rep_tit);
					if($success)
					{
							echo true;
					}
					else
					{
							echo false;
					}
			}

 public function print_invoice_for_all($id)
			{
					if($id == 0)
					{
						$logo = $this->receptionModel->get_logo_details();
						$last_inv = $this->receptionModel->get_invoice_details_for_new1();
						$data = [
						'logo' => $logo,
						'last_inv'=>$last_inv
					];
					}
					else
					{
						$a='';
						$b='';
						$logo = $this->receptionModel->get_logo_details();
						$pat = $this->receptionModel->get_patient_name_using_id($id);
						$a = $pat->patient_name;
						$b = $a."|".$id;
						$last_inv = $this->receptionModel->get_last_invoice1($b,$id);
						$data = [
							'logo' => $logo,
							'last_inv'=>$last_inv
						];
					}
					$this->view('receptions/print_invoice_for_all',$data);
			}

			public function print_invoice_for_all_ip($id)
			{
					if($id == 0)
					{
						$logo = $this->receptionModel->get_logo_details();
						$last_inv = $this->receptionModel->get_invoice_details_for_new2();
						$data = [
						'logo' => $logo,
						'last_inv'=>$last_inv
					];
					}
					else
					{
						$a='';
						$b='';
						$logo = $this->receptionModel->get_logo_details();
						$pat = $this->receptionModel->get_patient_name_using_id($id);
						$a = $pat->patient_name;
						$b = $a."|".$id;
						$last_inv = $this->receptionModel->get_last_invoice2($b,$id);
						$data = [
							'logo' => $logo,
							'last_inv'=>$last_inv
						];
					}
					$this->view('receptions/print_invoice_for_all_ip',$data);
			}
			
			public function oldOrder()
			{
					$this->view('receptions/oldOrder');
			}

			public function all_orders1_old()
			{
				$lim = $_POST['lim'];
				$lim = (int)$lim;
				if($lim==9)
				{
					$off = $_POST['off'];
					$off = (int)$off;
					$all_invoice = $this->receptionModel->get_all_orders_old($lim,$off);
				}
				else
				{
					$inc = $_POST['inc'];
					$inc = (int)$inc;
					$lim = 9;
					$off = 9+(9*$inc);
					$all_invoice = $this->receptionModel->get_all_orders_old($lim,$off);
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
					$cancel = $key->cancelled;          
					$all_orders_print.='<tr>
						<td style="padding-top:15px; text-align:left;"><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;';
					 $all_orders_print.=''.$invoice_id.'</td>
						<td style="padding-top:17px; text-align:left;">'.ucwords($invoice_name[0]).'</td>
						<td style="padding-top:15px;">'.$invoice_total.'</td>
						<td style="padding-top:15px;"></td>
						<td style="padding-top:15px;">'.date('d-m-Y H:i A', strtotime($invoice_date)).'</td>
						<td style="padding-top:15px; text-align:left; padding-left:95px;"><a href="'.URLROOT.'/receptions/print_invoice_old/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-success btn-xs m-b-5">Print</button></a>
									<a href="'.URLROOT.'/receptions/view_invoice_old/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-purple btn-xs m-b-5">View</button></a>';
						$all_orders_print.='</td>
					</tr>';
				}
				echo $all_orders_print;
			}

			public function search_by_inv_id_old()
			{
				$inv_id = $_POST['inv'];
				$single_invoice = $this->receptionModel->get_search_orders_old($inv_id);
				$all_orders_print = '';

				foreach ($single_invoice as $key)
				{
					$invoice_id = $key->invoice_id;
					$invoice_name = $key->invoice_name;
					$invoice_name = explode('|', $invoice_name);
					$invoice_total = $key->invoice_total;
					$invoice_bill = $key->invoice_bill;
					$invoice_date = $key->invoice_date;
					$cancel = $key->cancelled;          
					$all_orders_print.='<tr>
						<td style="padding-top:15px; text-align:left;"><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;';
					 $all_orders_print.=''.$invoice_id.'</td>
						<td style="padding-top:17px; text-align:left;">'.ucwords($invoice_name[0]).'</td>
						<td style="padding-top:15px;">'.$invoice_total.'</td>
						<td style="padding-top:15px;"></td>
						<td style="padding-top:15px;">'.date('d-m-Y H:i A', strtotime($invoice_date)).'</td>
						<td style="padding-top:15px; text-align:left; padding-left:65px;">';
						$all_orders_print.='</td>
					</tr>';
				}
					echo $all_orders_print;
			}


			public function search_by_name_value_old()
			{
				$patient_name = $_POST['patient_name'];
				$patients_list= $this->receptionModel->get_patient_orders_old($patient_name);
				$all_orders_print = '';

				foreach ($patients_list as $key)
				{
					$invoice_id = $key->invoice_id;
					$invoice_name = $key->invoice_name;
					$invoice_name = explode('|', $invoice_name);
					$invoice_total = $key->invoice_total;
					$invoice_bill = $key->invoice_bill;
					$invoice_date = $key->invoice_date;
					$cancel = $key->cancelled;          
					$all_orders_print.='<tr>
						<td style="padding-top:15px; text-align:left;"><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;';
					 $all_orders_print.=''.$invoice_id.'</td>
						<td style="padding-top:17px; text-align:left;">'.ucwords($invoice_name[0]).'</td>
						<td style="padding-top:15px;">'.$invoice_total.'</td>
						<td style="padding-top:15px;"></td>
						<td style="padding-top:15px;">'.date('d-m-Y H:i A', strtotime($invoice_date)).'</td>
						<td style="padding-top:15px; text-align:left; padding-left:65px;">';
						$all_orders_print.='</td>
					</tr>';
				}
					echo $all_orders_print;
			}

			public function get_all_orders_wrt_dates_old()
			{
				$start = $_POST['start'];
				$end = $_POST['end'];
				$single_invoice = $this->receptionModel->get_all_orders_wrt_dates_db_old($start, $end);
				$all_orders_print = '';

				foreach ($single_invoice as $key)
				{
					$invoice_id = $key->invoice_id;
					$invoice_name = $key->invoice_name;
					$invoice_name = explode('|', $invoice_name);
					$invoice_total = $key->invoice_total;
					$invoice_bill = $key->invoice_bill;
					$invoice_date = $key->invoice_date;
					$cancel = $key->cancelled;          
					$all_orders_print.='<tr>
						<td style="padding-top:15px; text-align:left;"><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;';
					 $all_orders_print.=''.$invoice_id.'</td>
						<td style="padding-top:17px; text-align:left;">'.ucwords($invoice_name[0]).'</td>
						<td style="padding-top:15px;">'.$invoice_total.'</td>
						<td style="padding-top:15px;"></td>
						<td style="padding-top:15px;">'.date('d-m-Y H:i A', strtotime($invoice_date)).'</td>
						<td style="padding-top:15px; text-align:left; padding-left:65px;">';
						$all_orders_print.='</td>
					</tr>';
				}
					echo $all_orders_print;
			}

			public function view_invoice_old($id)
			{
					if($id == 0)
					{
						$last_inv = $this->receptionModel->get_invoice_details_for_new_old();
						$logo = $this->receptionModel->get_logo_details();
						$data = [
						'logo' => $logo,
						'last_inv'=>$last_inv
					];
					}
					else
					{
						$last_inv = $this->receptionModel->get_last_invoice_db($id);
						$logo = $this->receptionModel->get_logo_details();
						$data = [
							'logo' => $logo,
							'last_inv'=>$last_inv
						];
					}
					$this->view('receptions/view_invoice_old',$data);
			}

			public function print_invoice_old($id)
			{
					if($id == 0)
					{
						$logo = $this->receptionModel->get_logo_details();
						$last_inv = $this->receptionModel->get_invoice_details_for_new_old();
						$data = [
						'logo' => $logo,
						'last_inv'=>$last_inv
					];
					}
					else
					{
						$logo = $this->receptionModel->get_logo_details();
						$last_inv = $this->receptionModel->get_last_invoice_db($id);
						$data = [
							'logo' => $logo,
							'last_inv'=>$last_inv
						];
					}
					$this->view('receptions/print_invoice_old',$data);
			}

			public function get_patients_data_to_print_old($ppid)
			{
					return $pdata = $this->receptionModel->get_patient_by_id_old($ppid);
			} 

			public function getServiceName($id)
			{
					return $serviceName = $this->receptionModel->getServiceNameDb($id);
			}

			public function finishVisit($id)
			{
					$this->receptionModel->finishVisitDb($id);
					redirect('receptions/all_visit');
			}

			public function payBalance()
			{
					$bal = $_POST['balAmt'];
					$inv = $_POST['invId'];
					$this->receptionModel->payBalanceDb($bal, $inv);
					redirect('receptions/all_orders');
			}

			public function all_orders_lab()
			{
				$this->view('receptions/all_orders_lab');
			}

			public function all_orders1_lab()
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
					$invoice_name = $key->invoice_name;
					$invoice_name = explode('|', $invoice_name);
					$invoice_total = (int)$key->invoice_total;
					$invoice_bill = $key->invoice_bill;
					$invoice_date = $key->invoice_date;
					$dep_type = $key->department;
					$amount_paid = (int)$key->amount_paid;
					$cancel = $key->cancelled; 
					$bal = $invoice_total - $amount_paid;         //#FF3366
					$all_orders_print.='<tr>
						<td style="padding-top:15px; text-align:left;">';
						if($dep_type==1)
						{
							$all_orders_print.='<span class="badge badge-pill badge-warning" style="background-color:#FA8B50;">L</span>&nbsp;';
						}
						else
						{
							$all_orders_print.='<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;';
						}
					 $all_orders_print.=''.$invoice_id.'</td>
						<td style="padding-top:17px; text-align:left;">'.ucwords($invoice_name[0]).'</td>
						
						<td style="padding-top:15px;">'.$invoice_total.'</td>
						<td style="padding-top:15px;">'.$amount_paid.'</td>
						<td style="padding-top:15px;">'.$bal.'</td>
						<td style="padding-top:15px;">'.date('d-m-Y H:i A', strtotime($invoice_date)).'</td>
						<td style="padding-top:15px; text-align:left; padding-left:65px;">';
						if($cancel != 1)
						{
							if($dep_type==1)
							{
								$all_orders_print.='
									<a href="'.URLROOT.'/receptions/print_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-success btn-xs m-b-5">Print</button></a>
									<a href="'.URLROOT.'/receptions/view_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-purple btn-xs m-b-5">View</button></a>
									
									<button style="width: 54px" type="button" class="btn btn-warning btn-xs m-b-5" onclick="cancel_order('.$invoice_id.')">Cancel</button>';
									if($bal != 0){
										$all_orders_print.='
									<button style="width: 54px" type="button" class="btn btn-primary btn-xs m-b-5" onclick="openModal('.$invoice_id.','.$bal.')">Balance</button>';
								}
							}

							else
							{
								$all_orders_print.='<a href="'.URLROOT.'/receptions/print_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-success btn-xs m-b-5">Print</button></a>
									<a href="'.URLROOT.'/receptions/view_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-purple btn-xs m-b-5">View</button></a>
									
									<a href="'.URLROOT.'/receptions/edit_order/'.$invoice_id.'"><button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button></a>
									<button style="width: 54px" type="button" class="btn btn-warning btn-xs m-b-5" onclick="cancel_order('.$invoice_id.')">Cancel</button>';
									if($bal != 0){
										$all_orders_print.='
									<button style="width: 54px" type="button" class="btn btn-primary btn-xs m-b-5" onclick="openModal('.$invoice_id.','.$bal.')">Balance</button>';
								}
							}
						}
						else
						{
								 $all_orders_print.='<button style="width: 74px;background-color:#FF7043; color:white;" type="button" class="btn btn btn-xs m-b-5" onclick="undo_cancel('.$invoice_id.')">Cancelled</button>';
						}

						$all_orders_print.='</td>

					</tr>';
				}
				echo $all_orders_print;
			}

			public function all_orders_bal()
			{
					$this->view('receptions/all_orders_bal');
			}

			public function all_orders_bal1()
			{
				$lim = $_POST['lim'];
				$lim = (int)$lim;
				if($lim==9)
				{
					$off = $_POST['off'];
					$off = (int)$off;
					$all_invoice = $this->receptionModel->get_all_orders_bal($lim,$off);
				}
				else
				{
					$inc = $_POST['inc'];
					$inc = (int)$inc;
					$lim = 9;
					$off = 9+(9*$inc);
					$all_invoice = $this->receptionModel->get_all_orders_bal($lim,$off);
				}
				$all_orders_print = '';

				foreach ($all_invoice as $key)
				{
					$invoice_id = $key->invoice_id;
					$invoice_name = $key->invoice_name;
					$invoice_name = explode('|', $invoice_name);
					$invoice_total = (int)$key->invoice_total;
					$invoice_bill = $key->invoice_bill;
					$invoice_date = $key->invoice_date;
					$dep_type = $key->department;
					$amount_paid = (int)$key->amount_paid;
					$cancel = $key->cancelled; 
					$bal = $invoice_total - $amount_paid;         //#FF3366
					$all_orders_print.='<tr>
						<td style="padding-top:15px; text-align:left;">';
						if($dep_type==1)
						{
							$all_orders_print.='<span class="badge badge-pill badge-warning" style="background-color:#FA8B50;">L</span>&nbsp;';
						}
						else
						{
							$all_orders_print.='<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;';
						}
					 $all_orders_print.=''.$invoice_id.'</td>
						<td style="padding-top:17px; text-align:left;">'.ucwords($invoice_name[0]).'</td>
						
						<td style="padding-top:15px;">'.$invoice_total.'</td>
						<td style="padding-top:15px;">'.$amount_paid.'</td>
						<td style="padding-top:15px;">'.$bal.'</td>
						<td style="padding-top:15px;">'.date('d-m-Y H:i A', strtotime($invoice_date)).'</td>
						<td style="padding-top:15px; text-align:left; padding-left:65px;">';
						if($cancel != 1)
						{
							if($dep_type==1)
							{
								$all_orders_print.='
									<a href="'.URLROOT.'/receptions/print_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-success btn-xs m-b-5">Print</button></a>
									<a href="'.URLROOT.'/receptions/view_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-purple btn-xs m-b-5">View</button></a>
									
									<button style="width: 54px" type="button" class="btn btn-warning btn-xs m-b-5" onclick="cancel_order('.$invoice_id.')">Cancel</button>';
									if($bal != 0){
										$all_orders_print.='
									<button style="width: 54px" type="button" class="btn btn-primary btn-xs m-b-5" onclick="openModal('.$invoice_id.','.$bal.')">Balance</button>';
								}
							}

							else
							{
								$all_orders_print.='<a href="'.URLROOT.'/receptions/print_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-success btn-xs m-b-5">Print</button></a>
									<a href="'.URLROOT.'/receptions/view_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-purple btn-xs m-b-5">View</button></a>
									
									<a href="'.URLROOT.'/receptions/edit_order/'.$invoice_id.'"><button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button></a>
									<button style="width: 54px" type="button" class="btn btn-warning btn-xs m-b-5" onclick="cancel_order('.$invoice_id.')">Cancel</button>';
									if($bal != 0){
										$all_orders_print.='
									<button style="width: 54px" type="button" class="btn btn-primary btn-xs m-b-5" onclick="openModal('.$invoice_id.','.$bal.')">Balance</button>';
								}
							}
						}
						else
						{
								 $all_orders_print.='<button style="width: 74px;background-color:#FF7043; color:white;" type="button" class="btn btn btn-xs m-b-5" onclick="undo_cancel('.$invoice_id.')">Cancelled</button>';
						}

						$all_orders_print.='</td>

					</tr>';
				}
				echo $all_orders_print;
			}
			
			public function all_orders_discount()
			{
					$this->view('receptions/all_orders_discount');
			}
			
			public function all_orders_discount1()
			{
				$lim = $_POST['lim'];
				$lim = (int)$lim;
				if($lim==9)
				{
					$off = $_POST['off'];
					$off = (int)$off;
					$all_invoice = $this->receptionModel->get_all_orders_discount($lim,$off);
				}
				else
				{
					$inc = $_POST['inc'];
					$inc = (int)$inc;
					$lim = 9;
					$off = 9+(9*$inc);
					$all_invoice = $this->receptionModel->get_all_orders_discount($lim,$off);
				}
				$all_orders_print = '';

				foreach ($all_invoice as $key)
				{
					$invoice_id = $key->invoice_id;
					$invoice_name = $key->invoice_name;
					$invoice_name = explode('|', $invoice_name);
					$invoice_total = (int)$key->invoice_total;
					$invoice_bill = $key->invoice_bill;
					$invoice_date = $key->invoice_date;
					$dep_type = $key->department;
					$amount_paid = (int)$key->amount_paid;
					$cancel = $key->cancelled; 
					$invoice_discount = $key->invoice_discount;
					$bal = $invoice_total - $amount_paid;         //#FF3366
					$all_orders_print.='<tr>
						<td style="padding-top:15px; text-align:left;">';
						if($dep_type==1)
						{
							$all_orders_print.='<span class="badge badge-pill badge-warning" style="background-color:#FA8B50;">L</span>&nbsp;';
						}
						else
						{
							$all_orders_print.='<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;';
						}
					 $all_orders_print.=''.$invoice_id.'</td>
						<td style="padding-top:17px; text-align:left;">'.ucwords($invoice_name[0]).'</td>
						
						<td style="padding-top:15px;">'.$invoice_total.'</td>
						<td style="padding-top:15px;">'.$invoice_discount.'</td>
						<td style="padding-top:15px;">'.$amount_paid.'</td>
						<td style="padding-top:15px;">'.$bal.'</td>
						<td style="padding-top:15px;">'.date('d-m-Y H:i A', strtotime($invoice_date)).'</td>
						<td style="padding-top:15px; text-align:left; padding-left:65px;">';
						if($cancel != 1)
						{
							if($dep_type==1)
							{
								$all_orders_print.='
									<a href="'.URLROOT.'/receptions/print_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-success btn-xs m-b-5">Print</button></a>
									<a href="'.URLROOT.'/receptions/view_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-purple btn-xs m-b-5">View</button></a>
									
									<button style="width: 54px" type="button" class="btn btn-warning btn-xs m-b-5" onclick="cancel_order('.$invoice_id.')">Cancel</button>';
									if($bal != 0){
										$all_orders_print.='
									<button style="width: 54px" type="button" class="btn btn-primary btn-xs m-b-5" onclick="openModal('.$invoice_id.','.$bal.')">Balance</button>';
								}
							}

							else
							{
								$all_orders_print.='<a href="'.URLROOT.'/receptions/print_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-success btn-xs m-b-5">Print</button></a>
									<a href="'.URLROOT.'/receptions/view_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-purple btn-xs m-b-5">View</button></a>
									
									<a href="'.URLROOT.'/receptions/edit_order/'.$invoice_id.'"><button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button></a>
									<button style="width: 54px" type="button" class="btn btn-warning btn-xs m-b-5" onclick="cancel_order('.$invoice_id.')">Cancel</button>';
									if($bal != 0){
										$all_orders_print.='
									<button style="width: 54px" type="button" class="btn btn-primary btn-xs m-b-5" onclick="openModal('.$invoice_id.','.$bal.')">Balance</button>';
								}
							}
						}
						else
						{
								 $all_orders_print.='<button style="width: 74px;background-color:#FF7043; color:white;" type="button" class="btn btn btn-xs m-b-5" onclick="undo_cancel('.$invoice_id.')">Cancelled</button>';
						}

						$all_orders_print.='</td>

					</tr>';
				}
				echo $all_orders_print;
			}

			public function getBeds()
			{
					$query3 = $_POST['query3'];
					$name_list = $this->receptionModel->getRoomsDb($query3);
					$output = '';
					$output = '<ul class="list-unstyled">';
					foreach ($name_list as $key)
					{
						$output .='<li class="ee32" style="padding-left:10px;">'. $key->bed_number.'</li>';
					}
					$output.='</ul>';
					echo $output;
			}

			public function updateTheInsurance()
			{
					$admitId = $_POST['admitId'];
					$agId = $_POST['agId'];
					$agName = $_POST['agName'];
					$agExpiry = $_POST['agExpiry'];

					$this->receptionModel->updateTheInsuranceDb($admitId, $agId, $agName, $agExpiry);
					redirect('receptions/all_admissions');
			}

			public function getServiceNameFull($id)
			{
					return $row = $this->receptionModel->getServiceNameFullDb($id);
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
											redirect('receptions/index');             
									}


						$data = [
							'logo' => $logo,
							'opd' => $row,
							'patient_name' =>$pat,
							'doc_name' => $doc
						];
						$this->view('receptions/print_prescription', $data);

				}
				else
				{
						redirect('users/login');
				}
			}

				public function getIpdDetails($onlyID2)
				{
						return $row = $this->receptionModel->getTheIpdDetails($onlyID2);
				}

				public function appointments()
				{
					$this->view('receptions/appointments');
				}
				
				public function cancelled_appointments()
				{
					$this->view('receptions/cancelled_appointments');
				}
		
		public function allAppointments()
		{
			$lim = $_POST['lim'];
			$lim = (int)$lim;
			if($lim==9)
			{
				$off = $_POST['off'];
				$off = (int)$off;
				// $allApp = $this->receptionModel->getAllApppointments($lim,$off);
				$allApp = $this->receptionModel->getAllApppointments();
			}
			else
			{
				$inc = $_POST['inc'];
				$inc = (int)$inc;
				$lim = 9;
				$off = 9+(9*$inc);
				// $appApp = $this->receptionModel->getAllApppointments($lim,$off);
				$appApp = $this->receptionModel->getAllApppointments();
			}
			$all_orders_print = '';
	
			foreach ($allApp as $key)
			{
				$all_orders_print.='<tr>
				<td style="text-align:left;">'.$key->a_id.'</td>
				<td style="text-align:left;">'.ucwords($key->patient_name).'</td>
				<td style="text-align:left;">'.$key->patient_phone.'</td>
				<td style="text-align:left;">'.ucwords($key->doctor_name).'</td>
				<td style="text-align:left;">'.$key->doctor_specialty.'</td>
				<td style="text-align:left;">'.date('d-M-Y H:i A', strtotime($key->appointment_time)).'</td>';
				if($key->status == 0)
				{
				// 	$all_orders_print.='
				// 	<td style="text-align:center;">
				// 		<a href="'.URLROOT.'/receptions/approveAppointment/'.$key->a_id.'"><button style="width: 60px" type="button" class="btn btn-info btn-xs m-b-5">Approve</button></a>
				// 		<button style="width: 60px" type="button" class="btn btn-warning btn-xs m-b-5">Cancel</button>
				// 	</td></tr>';
				
					$all_orders_print.='
					<td style="text-align:center;">
						<a href="'.URLROOT.'/receptions/approveAppointment/'.$key->a_id.'"><button style="width: 60px" type="button" class="btn btn-info btn-xs m-b-5">Approve</button></a>
						
					</td></tr>';
				}
				else
				{
				// 	$all_orders_print.='
				// 	<td style="text-align:center;">
				// 		<a href="'.URLROOT.'/receptions/convertToVisit/'.$key->a_id.'"><button type="button" class="btn btn-info btn-xs m-b-5">Convert to Visit</button></a>
				// 		<a href="'.URLROOT.'/receptions/convertToAdmit/'.$key->a_id.'"><button type="button" class="btn btn-primary btn-xs m-b-5">Convert to Admit</button></a>
				// 		<button type="button" class="btn btn-warning btn-xs m-b-5">Cancel</button>
				// 	</td></tr>';
					
					$all_orders_print.='
					<td style="text-align:center;">
						<a href="'.URLROOT.'/receptions/convertToVisit/'.$key->a_id.'"><button type="button" class="btn btn-info btn-xs m-b-5">Convert to Visit</button></a>
						<a href="'.URLROOT.'/receptions/convertToAdmit/'.$key->a_id.'"><button type="button" class="btn btn-primary btn-xs m-b-5">Convert to Admit</button></a>
						
					</td></tr>';
				}
			}
			echo $all_orders_print;
		}
		
		
		public function allCancelledAppointments()
		{
			$lim = $_POST['lim'];
			$lim = (int)$lim;
			if($lim==9)
			{
				$off = $_POST['off'];
				$off = (int)$off;
				// $allApp = $this->receptionModel->getAllApppointments($lim,$off);
				$allApp = $this->receptionModel->getAllCancelledApppointments();
			}
			else
			{
				$inc = $_POST['inc'];
				$inc = (int)$inc;
				$lim = 9;
				$off = 9+(9*$inc);
				// $appApp = $this->receptionModel->getAllApppointments($lim,$off);
				$appApp = $this->receptionModel->getAllCancelledApppointments();
			}
			$all_orders_print = '';
	
			foreach ($allApp as $key)
			{
				$all_orders_print.='<tr>
				<td style="text-align:left;">'.$key->a_id.'</td>
				<td style="text-align:left;">'.ucwords($key->patient_name).'</td>
				<td style="text-align:left;">'.$key->patient_phone.'</td>
				<td style="text-align:left;">'.ucwords($key->doctor_name).'</td>
				<td style="text-align:left;">'.$key->doctor_specialty.'</td>
				<td style="text-align:left;">'.date('d-M-Y H:i A', strtotime($key->appointment_time)).'</td>';
				$all_orders_print.='
				<td style="text-align:center;">
					Cancelled
			 	</td></tr>';
				
				// if($key->status == 0)
				// {
				// 	$all_orders_print.='
				// 	<td style="text-align:center;">
				// 		<a href="'.URLROOT.'/receptions/approveAppointment/'.$key->a_id.'"><button style="width: 60px" type="button" class="btn btn-info btn-xs m-b-5">Approve</button></a>
				// 		<button style="width: 60px" type="button" class="btn btn-warning btn-xs m-b-5">Cancel</button>
				// 	</td></tr>';
				
				// 	$all_orders_print.='
				// 	<td style="text-align:center;">
				// 		<a href="'.URLROOT.'/receptions/approveAppointment/'.$key->a_id.'"><button style="width: 60px" type="button" class="btn btn-info btn-xs m-b-5">Approve</button></a>
						
				// 	</td></tr>';
				// }
				// else
				// {
				// 	$all_orders_print.='
				// 	<td style="text-align:center;">
				// 		<a href="'.URLROOT.'/receptions/convertToVisit/'.$key->a_id.'"><button type="button" class="btn btn-info btn-xs m-b-5">Convert to Visit</button></a>
				// 		<a href="'.URLROOT.'/receptions/convertToAdmit/'.$key->a_id.'"><button type="button" class="btn btn-primary btn-xs m-b-5">Convert to Admit</button></a>
				// 		<button type="button" class="btn btn-warning btn-xs m-b-5">Cancel</button>
				// 	</td></tr>';
					
				// 	$all_orders_print.='
				// 	<td style="text-align:center;">
				// 		<a href="'.URLROOT.'/receptions/convertToVisit/'.$key->a_id.'"><button type="button" class="btn btn-info btn-xs m-b-5">Convert to Visit</button></a>
				// 		<a href="'.URLROOT.'/receptions/convertToAdmit/'.$key->a_id.'"><button type="button" class="btn btn-primary btn-xs m-b-5">Convert to Admit</button></a>
						
				// 	</td></tr>';
				// }
			}
			echo $all_orders_print;
		}

		public function approveAppointment($id)
		{
			$this->receptionModel->checkForThePatient($id);
			redirect('receptions/appointments');
		}

		public function convertToVisit($id)
		{
			$appDetails = $this->receptionModel->converToVsitDb($id);
			$data = [
				'doc_list' => $this->receptionModel->get_doctors_list(),
				'cTV' => $appDetails,
			];
			$this->view('receptions/new_op_visit', $data);
		}

		public function convertToAdmit($id)
		{
			$data = [
				'doc_list' => $this->receptionModel->get_doctors_list(),
				'cTV' => $this->receptionModel->converToAdmitDb($id),
				'ins' => $this->receptionModel->getAllIns(),
			];
			$this->view('receptions/new_ip_visit', $data);
		}

		public function newAppointment()
		{
			$data = [
				'loginPage' => $this->receptionModel->getTheLoginPage(),
				'specialty' => $this->receptionModel->getAllTheSpecialty(),
			];
			$this->view('receptions/newAppointment', $data);
		}

		public function bookAppointment()
		{
			if(!isset($_POST['patientId']) && !isset($_POST['patientName']) && !isset($_POST['phoneNumberWithout']))
			{
				$_SESSION['fillAll'] = 1; 
				redirect('receptions/newAppointment');
			}
			
			
			if(empty($_POST['patientIdName']))
			{
				$_SESSION['fillAll'] = 1; 
				redirect('receptions/newAppointment');
			}
			
			if($_POST['type'] == 1)
			{
				$data = [
					'hos_id' => $_POST['hos_id'],
					'patientId' => $_POST['patientId'],
					'docSpec' => $_POST['docSpec'],
					'docName' => $_POST['docName'],
					'appoint_date' => $_POST['appoint_date'],
					'patientName' => $_POST['patientIdName'],
					'phoneNumberWithout' => $_POST['phoneNumberWithout'],
				];
			}
			elseif ($_POST['type'] == 2) 
			{
				$data = [
					'hos_id' => $_POST['hos_id'],
					'patientId' => $_POST['patientId'],
					'docSpec' => $_POST['docSpec'],
					'docName' => $_POST['docName'],
					'appoint_date' => $_POST['appoint_date'],
					'patientName' => $_POST['patientName'],
					'phoneNumberWithout' => $_POST['phoneNumberWithout'],
				];
			}
			
			if($this->receptionModel->checkAppointment($data))
			{
				$_SESSION['appStatus'] = 1;
				unset($_SESSION['fillAll']);
				redirect('receptions/newAppointment');
			}
		}

		public function allDoctors()
		{
			$this->view('receptions/allDoc');
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
							<a class="pull-left" href="'.URLROOT.'/receptions/docProfile/'.$key->mem_id.'">
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
							<a class="pull-left" href="'.URLROOT.'/receptions/docProfile/'.$key->mem_id.'">
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

		public function docProfile($dId)
		{
			$data = [
				'doctors' => $this->receptionModel->get_doctor_by_id_single($dId),
				'auth' => $this->receptionModel->get_mem_data_single($dId),
				'times' => $this->receptionModel->getAllTimeslots($dId),
			];
			$this->view('receptions/docProfile', $data);
		}
		

			// public function get_patients_data_to_print($ppid)
			// {
			//     return $pdata = $this->receptionModel->get_patient_by_id($ppid);
			// }

		public function new_emergency()
		{
			if(!isset($_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']) AND $_SESSION['type'] != 'rec')
			{
					redirect('users/login');
			}
			else
			{
					$doc_list = $this->receptionModel->get_doctors_list();
					$data = [
						'doc_list' => $doc_list
					];
					$this->view('receptions/new_emergency',$data);
			}
			
		}
		public function create_emergency()
		{
			$p_name = $_POST['p_name'];
			$d_name = $_POST['d_name'];
			$patient_details = $this->receptionModel->get_patient_by_id_1($p_name);
			$doc_details = $this->receptionModel->get_doctor_by_id_1($d_name);
			if($this->receptionModel->add_emergency_details($p_name,$d_name,$patient_details->patient_name,$doc_details->doctor_name))
			{
				echo "Emergency Created";
			}else
			{
				echo "try later";
			}
		}
		public function all_emergency()
		{
			$this->view('receptions/all_emergency');
		}
		public function all_emergency1()
		{
			$lim = $_POST['lim'];
			$lim = (int)$lim;
			if($lim==9)
			{
				$off = $_POST['off'];
				$off = (int)$off;
				$all_visits = $this->receptionModel->get_all_emergency($lim,$off);
			}
			else
			{
				$inc = $_POST['inc'];
				$inc = (int)$inc;
				$lim = 9;
				$off = 9+(9*$inc);
				$all_visits = $this->receptionModel->get_all_emergency($lim,$off);
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
							<a href='.URLROOT.'/receptions/print_emergency/'.$key->id.'><button style="width: 70px" type="button" class="btn btn-info btn-xs m-b-5">Print</button></a>
					</td>
				</tr>
				';
			}
			echo $all_orders_print;
		}
		public function print_emergency($id)
		{
			$data = [ 
						'logo' => $logo = $this->receptionModel->get_logo_details(),
						'em' => $this->receptionModel->get_single_emergency($id), 
					];
			$this->view('receptions/print_emergency',$data);
		}
	//end end end 
		//new from medhike
		public function dailyReports()
		{
			$this->view('receptions/dailyReports');
		}
		public function dailyGeneralReports()
		{
			header("Content-type: application/vnd.ms-excel");
			header("Content-Disposition: attachment; filename=patientDetails.xls");
			// $pharmacyBills = $this->pharmcyModel->getAllThePharmacyDetailOfToday();
			$template = "<table border='1'>
			<thead>
				<tr>
				<th bgcolor='#FFD54F'>Invoice ID</th>
				<th bgcolor='#FFD54F'>Patient Name</th>
				<th bgcolor='#FFD54F'>Patient Name</th>
				<th bgcolor='#FFD54F'>Doctor Name</th>
				<th bgcolor='#FFD54F'>Invoice Items</th>
				<th bgcolor='#FFD54F'>Invoice Total</th>
				<th bgcolor='#FFD54F'>Discount</th>
				<th bgcolor='#FFD54F'>Date & Time</th>
				</tr>
			</thead>
			<tbody>
			";
			$template .= "</tbody>";
			echo $template;
		}
		public function dailyGeneralReports1()
		{
			header("Content-type: application/vnd.ms-excel");
			header("Content-Disposition: attachment; filename=patientDetails.xls");
			// $pharmacyBills = $this->pharmcyModel->getAllThePharmacyDetailOfToday();
			$template = "<table border='1'>
			<thead>
				<tr>
				<th bgcolor='#FFD54F'>Invoice ID</th>
				<th bgcolor='#FFD54F'>Patient Name</th>
				<th bgcolor='#FFD54F'>Patient Name</th>
				<th bgcolor='#FFD54F'>Doctor Name</th>
				<th bgcolor='#FFD54F'>Invoice Items</th>
				<th bgcolor='#FFD54F'>Invoice Total</th>
				<th bgcolor='#FFD54F'>Discount</th>
				<th bgcolor='#FFD54F'>Date & Time</th>
				</tr>
			</thead>
			<tbody>
			";
			$template .= "</tbody>";
			echo $template;
		}
		public function current_operation()
		{
			$ot = $this->otModel->get_all_ot_with_patient_name();
			$rooms = $this->otModel->get_all_rooms();
			$data = [ 
				'ot' => $ot,
				'room' => $rooms,
			];
			$this->view('receptions/current_operation', $data);
		}
		public function active_operation()
		{
			$ot = $this->otModel->get_all_ot_with_patient_name();

			$data = [ 
				'ot' => $ot,
			];
			$this->view('receptions/active_operation',$data);
		}
		public function completed_operation()
		{
			$ot = $this->otModel->get_all_ot_with_patient_name();
			$data = [ 
				'ot' => $ot,
			];
			$this->view('receptions/completed_operation',$data);
		}

		public function canceled_operation()
		{
			
			$ot = $this->otModel->get_all_ot_with_patient_name();
			$data = [ 
				'ot' => $ot,
			];
			$this->view('receptions/canceled_operation',$data);
		}
		public function referalDoctor()
		{
			$this->view('receptions/referalDoctor');
		}
		
		public function donwloadExcel_appointments() {




        $productResult=$this->receptionModel->get_download_content();

        

          $this->exportProductDatabase($productResult);


    }

       

      public function exportProductDatabase($productResult) {
      
        $timestamp = time();
        $filename = 'Appointments_Export_excel_' . $timestamp . '.xls';
        
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        
        $isPrintHeader = false;

        foreach ($productResult as $file) {
                        $result = [];
                        array_walk_recursive($file, function($item) use (&$result) {
                        $result[] = $item;
                        });
                     // fputcsv($output, $result);
                 


        // foreach ($productResult as $row) {
            if (! $isPrintHeader) {
                echo implode("\t", array_keys($result)) . "\n";
                $isPrintHeader = true;
            }
            echo implode("\t", array_values($result)) . "\n";


         }
        exit();
 



    }
    
    
    public function add_message_admin()
	{
	    $per = $this->receptionModel->add_message_admin($_POST['p_name']);
	}
	
	
	
	public function make_all_bills_ip($id)
	{
        
        $ip_var = "IP".$id;
        
        $last_inv = $this->receptionModel->get_all_invoice_ip($ip_var);
        
        if(empty($last_inv))
        {
            
            $_SESSION['success'] = "No bills available for this admission";
            redirect('receptions/all_admissions');
        }
        
		if($id == 0)
		{
			$last_inv = $this->receptionModel->get_invoice_details_for_new();
			$logo = $this->receptionModel->get_logo_details();
			
			$data = [
			'logo' => $logo,
			'last_inv'=>$last_inv,
			'admission_id' => $id
		];
		}
		else
		{
			$last_inv = $this->receptionModel->get_all_invoice_ip($ip_var);
			$logo = $this->receptionModel->get_logo_details();
			$data = [
				'logo' => $logo,
				'last_inv'=>$last_inv,
				'admission_id' => $id
			];
		}
		$this->view('receptions/make_all_bills_ip',$data);
    }
    
    
    public function print_all_bills_ip($id)
	{
        
        $ip_var = "IP".$id;
        
	    

	    
			if($id == 0)
			{
				$last_inv = $this->receptionModel->get_invoice_details_for_new();
				$logo = $this->receptionModel->get_logo_details();
				
				$data = [
				'logo' => $logo,
				'last_inv'=>$last_inv,
				'admission_id' => $id
			];
			}
			else
			{
				$last_inv = $this->receptionModel->get_all_invoice_ip($ip_var);
				$logo = $this->receptionModel->get_logo_details();
				$data = [
					'logo' => $logo,
					'last_inv'=>$last_inv,
					'admission_id' => $id
				];
			}
			$this->view('receptions/print_all_bills_ip',$data);
    }



	public function create_advance_receipt($admit_id, $patient_id)
	{
		$data = [
			'admit_id'	=>	$admit_id,
			'patient'	=>	$this->receptionModel->get_patient_name_using_id($patient_id),
			'bills'		=>	$this->receptionModel->get_all_receipt($patient_id, $admit_id),	
		];

		$this->view('receptions/advanced_bill', $data);
	}

	public function save_advanced_receipt()
	{
		$date_time = $_POST['datetime'];
		$amount = $_POST['amount'];
		$patient_id = $_POST['patient_id'];
		$admit_id  = $_POST['admit_id'];
		$payment_type = $_POST['payment_type'];
		if($this->receptionModel->save_advanced_receipt($date_time, $amount, $patient_id, $admit_id, $payment_type))
		{
			redirect('receptions/create_advance_receipt/'.$admit_id.'/'.$patient_id.'');
		}
	}

	public function print_receipt($id, $patient_id, $admit_id)
	{
		$logo 		= $this->receptionModel->get_logo_details();
		$advance 	= $this->receptionModel->get_the_advance_receipt_details($id);
		$data = [
			'logo' 			=> 	$logo,
			'advance'		=>	$advance,
			'patient_id'	=>	$patient_id,
			'patient'		=>	$this->receptionModel->get_patient_name_using_id($patient_id),
			'admit_id'		=>	$admit_id,
			'ipd_details'	=>	$this->receptionModel->getTheIpdDetails($admit_id),
		];
		$this->view('receptions/view_receipt', $data);
	}

	public function discharge_summary_update()
	{
		$discharge_type = $_POST['discharge_type'];
		$remark = $_POST['remark'];
		$x_admit_id = $_POST['admit_id'];
		$x_patient_id = $_POST['patient_id'];

		if($this->receptionModel->save_ipd_discharge_summary($discharge_type, $remark, $x_admit_id))
		{
			redirect('receptions/discharge_summary_admit/'.$x_patient_id.','.$x_admit_id.'');
		}
	}

	public function print_invoice_ipd_all($id)
	{
		if($id == 0)
		{
			$logo 			= 	$this->receptionModel->get_logo_details();
			$advance 		= 	$this->receptionModel->get_the_advance_sum($id);
			$all_advance	=	$this->receptionModel->get_all_receipts($id);
			$data = [
			'logo' 			=> 	$logo,
			'id' 			=> 	$id,
			'advance'		=>	$advance,
			'all_advance'	=>	$all_advance,
		];
		}
		else
		{
			$logo = $this->receptionModel->get_logo_details();
			$advance = $this->receptionModel->get_the_advance_sum($id);
			$all_advance	=	$this->receptionModel->get_all_receipts($id);
				$data = [
				'logo' 			=> 	$logo,
				'id' 			=> 	$id,
				'advance'		=>	$advance,
				'all_advance'	=>	$all_advance,
			];
		}
		$this->view('receptions/print_invoice_ipd',$data);
	}


	public function print_invoice_ipd_all_con($id)
	{
		if($id == 0)
		{
			$logo = $this->receptionModel->get_logo_details();
			$advance = $this->receptionModel->get_the_advance_sum($id);
			$all_advance	=	$this->receptionModel->get_all_receipts($id);
			$data = [
				'logo' 		=> 	$logo,
				'id' 		=> 	$id,
				'advance'	=>	$advance,
				'all_advance'	=>	$all_advance,
			];
		}
		else
		{
			$logo = $this->receptionModel->get_logo_details();
			$advance = $this->receptionModel->get_the_advance_sum($id);
			$all_advance	=	$this->receptionModel->get_all_receipts($id);
			$data = [
				'logo' 		=> 	$logo,
				'id' 		=> 	$id,
				'advance'	=>	$advance,
				'all_advance'	=>	$all_advance,
			];
		}
		$this->view('receptions/print_invoice_ipd_consolidated',$data);
	}

	public function get_manf_name($id)
    {
      $manf_name = $this->receptionModel->get_manf_name_db($id);
      return $manf_name;
    }

    public function get_stock_detail($id)
    {
      $stock = $this->receptionModel->get_stock_details($id);
      return $stock;
    }


	
    
    
//end 
 }// end of class
 ?>
