<?php
  class Admin extends Controller
  {
	  public function __construct()
	  {
		  	
			$this->receptionModel = $this->model('Reception');
			$this->doctorModel = $this->model('Doctor');
			// $this->checkSubs();
	  }


	  // All Functions Starts Here
	//   public function checkSubs()
	//   {
	// 	if($this->receptionModel->checkForPlan())
	// 	{
	// 		echo "ff";
	// 	}
	// 	else
	// 	{
	// 		echo "ss";
	// 	}
	//   }

	  public function index()
	  {
		$err ='';
		if($_SERVER['REQUEST_METHOD'] == 'POST')
			{ 
			  $email=$_SESSION['email'];
			  $verify_n=$_POST['verify_n'];
			  $v_code = $this->receptionModel->get_verify_code_from_email($email); 
			 
			  if($v_code->verify_code == $verify_n){
				$this->receptionModel->store_verification_code_status($email);
				$err =  "verification successfull...thank you..!";
			  }
			  else
			  {
				 $err = "Please check verification code..!"; 
			  }
			}
		  $v_code1 = $this->receptionModel->get_verify_code_from_email($_SESSION['email']);
		  $vc = '';
		  $order = $this->receptionModel->get_order_count();
		  $patients = $this->receptionModel->get_patient_count();
		  $opd = $this->receptionModel->get_opd_count();
		  $ipd = $this->receptionModel->get_ipd_count();
		  $data = [
			'order' => $order,
			'patient' => $patients,
			'opd' => $opd,
			'ipd' => $ipd,
			'err_vcode' => $err,
			'vc' => $vc,
			'subs' => $this->receptionModel->getTheSubscription()
		  ];
		$this->view('admin/index', $data); 
	  }
	  
	  
	  public function new_orders()
	  {
		$this->view('admin/new_orders');
	  }

	  public function new_member()
	  {
			if($this->receptionModel->checkForRecptionCount())
			{
				$check = 2;
			}
			else
			{
				$check = 2;
			}
			$data = [
				'check' => $check,
			];
			$this->view('admin/new_member', $data);
	}

	  public function add_mem()
	  {
		$mem_name = $_POST['mem_name'];
		$mem_type = $_POST['mem_type'];
		$mem_ph = $_POST['mem_ph'];
		$mem_em = $_POST['mem_em'];

		$suc = $this->receptionModel->add_mem_db($mem_name, $mem_type, $mem_ph, $mem_em);
		if($suc == 2)
		{
		  echo 'Member Added';
		}
		elseif($suc == 3)
		{
		  echo 'Email already exists';
		}
		else
		{
			echo "Error";
		}
	  }

	  public function edit_mem()
	  {
		$mem_name = $_POST['mem_name'];
		$mem_type = $_POST['mem_type'];
		$mem_ph = $_POST['mem_ph'];
		$mem_em = $_POST['mem_em'];

		$suc = $this->receptionModel->edit_mem_db($mem_name, $mem_type, $mem_ph, $mem_em);
		if($suc)
		{
		  echo 'Member details updated';
		}
		else
		{
		  echo 'error';
		}
	  }

	  public function all_orders()
	  {
		$this->view('admin/all_orders');
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
		  $invoice_total = (float)$key->invoice_total;
		  $invoice_bill = $key->invoice_bill;
		  $invoice_date = $key->invoice_date;
		  $dep_type = $key->department;
		  $amount_paid = (float)$key->amount_paid;
		  $created_by = $key->created_by;
		  $cancel = $key->cancelled;          //#FF3366
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
			<td>'.abs($invoice_total - $amount_paid).'</td>
			<td style="padding-top:15px;">'.date('d-m-Y H:i A', strtotime($invoice_date)).'</td>
			<td style="padding-top:15px; text-align:left; padding-left:65px;">';
			if($cancel != 1)
			{
			  if($dep_type==1)
			  {
				$all_orders_print.='
				  <a href="'.URLROOT.'/admin/print_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-success btn-xs m-b-5">Print</button></a>
				  <a href="'.URLROOT.'/admin/view_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-purple btn-xs m-b-5">View</button></a>
				  
				  <button style="width: 54px" type="button" class="btn btn-warning btn-xs m-b-5" onclick="cancel_order('.$invoice_id.')">Cancel</button>';
			  }

			  else
			  {
				$all_orders_print.='<a href="'.URLROOT.'/admin/print_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-success btn-xs m-b-5">Print</button></a>
				  <a href="'.URLROOT.'/admin/view_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-purple btn-xs m-b-5">View</button></a>
				  
				  <a href="'.URLROOT.'/admin/edit_order/'.$invoice_id.'"><button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button></a>
				  <button style="width: 54px" type="button" class="btn btn-warning btn-xs m-b-5" onclick="cancel_order('.$invoice_id.')">Cancel</button>';
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
		$this->view('admin/new_orders',$data);
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
				  <td style="padding-top:15px; text-align:left; padding-left:65px;">';
				  if($cancel != 1)
				  {
					  if($dep_type==1)
					  {
						  $all_orders_print.='
							  <a href="'.URLROOT.'/admin/print_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-success btn-xs m-b-5">Print</button></a>
							  <a href="'.URLROOT.'/admin/view_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-purple btn-xs m-b-5">View</button></a>
							  
							  <button style="width: 54px" type="button" class="btn btn-warning btn-xs m-b-5" onclick="cancel_order('.$invoice_id.')">Cancel</button>';
							  if($bal != 0){
								  $all_orders_print.='
							  <button style="width: 54px" type="button" class="btn btn-primary btn-xs m-b-5" onclick="openModal('.$invoice_id.','.$bal.')">Balance</button>';
						  }
					  }

					  else
					  {
						  $all_orders_print.='<a href="'.URLROOT.'/admin/print_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-success btn-xs m-b-5">Print</button></a>
							  <a href="'.URLROOT.'/admin/view_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-purple btn-xs m-b-5">View</button></a>
							  
							  <a href="'.URLROOT.'/admin/edit_order/'.$invoice_id.'"><button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button></a>
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
								<a href="'.URLROOT.'/admin/print_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-success btn-xs m-b-5">Print</button></a>
								<a href="'.URLROOT.'/admin/view_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-purple btn-xs m-b-5">View</button></a>
								
								<button style="width: 54px" type="button" class="btn btn-warning btn-xs m-b-5" onclick="cancel_order('.$invoice_id.')">Cancel</button>';
								if($bal != 0){
									$all_orders_print.='
								<button style="width: 54px" type="button" class="btn btn-primary btn-xs m-b-5" onclick="openModal('.$invoice_id.','.$bal.')">Balance</button>';
							}
						}

						else
						{
							$all_orders_print.='<a href="'.URLROOT.'/admin/print_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-success btn-xs m-b-5">Print</button></a>
								<a href="'.URLROOT.'/admin/view_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-purple btn-xs m-b-5">View</button></a>
								
								<a href="'.URLROOT.'/admin/edit_order/'.$invoice_id.'"><button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button></a>
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
		  $this->view('admin/new_service',$data);
	  }

	  public function save_new_service()
	  {
		  $s_name = $_POST['s_name'];
		  $s_cost = $_POST['s_cost'];
		  $s_type = $_POST['s_type'];
		  $success = $this->receptionModel->save_new_service_db($s_name,$s_type,$s_cost);
		  if($success)
			echo "Updated";
		  else
			echo "Error";
	  }

	  public function update_service()
	  {
		  $s_id = $_POST['e_id'];
		  $s_name = $_POST['e_name'];
		  $s_cost = $_POST['e_cost'];
		  $s_type = $_POST['e_type'];
		  $su = $this->receptionModel->update_service_db($s_id,$s_name,$s_type,$s_cost);
		  if($su)
			echo "Updated";
		  else
			echo "error";
	  }

	  public function all_services()
	  {
		  $this->view('admin/all_services');
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
			  <td style="text-align:left">'.$invoice_name.'</td>
			  <td style="text-align:left">'.$invoice_total.'</td>
			  <td>'.$invoice_bill.'</td>
			  <td>
				<a href="'.URLROOT.'/admin/edit_service/'.$invoice_id.'"><button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button></a>
				<button data-id="'.$invoice_id.'" style="width: 54px" type="button" class="btn btn-warning btn-xs m-b-5">Remove</button>
			  </td>
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
					<td style="padding-top:15px; text-align:left; padding-left:65px;">';
					if($cancel != 1)
					{
						if($dep_type==1)
						{
							$all_orders_print.='
								<a href="'.URLROOT.'/admin/print_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-success btn-xs m-b-5">Print</button></a>
								<a href="'.URLROOT.'/admin/view_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-purple btn-xs m-b-5">View</button></a>
								
								<button style="width: 54px" type="button" class="btn btn-warning btn-xs m-b-5" onclick="cancel_order('.$invoice_id.')">Cancel</button>';
								if($bal != 0){
									$all_orders_print.='
								<button style="width: 54px" type="button" class="btn btn-primary btn-xs m-b-5" onclick="openModal('.$invoice_id.','.$bal.')">Balance</button>';
							}
						}

						else
						{
							$all_orders_print.='<a href="'.URLROOT.'/admin/print_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-success btn-xs m-b-5">Print</button></a>
								<a href="'.URLROOT.'/admin/view_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-purple btn-xs m-b-5">View</button></a>
								
								<a href="'.URLROOT.'/admin/edit_order/'.$invoice_id.'"><button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button></a>
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
								$all_orders_print.='
									<a href="'.URLROOT.'/admin/edit_order/'.$invoice_id.'"><button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button></a>
									<button style="width: 54px" type="button" class="btn btn-warning btn-xs m-b-5" onclick="cancel_order('.$invoice_id.')">Cancel</button>
									<a href="'.URLROOT.'/admin/print_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-success btn-xs m-b-5">Print</button></a>';
								
							}

							else
							{
								$all_orders_print.='
									<a href="'.URLROOT.'/admin/edit_order/'.$invoice_id.'"><button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button></a>
									<button style="width: 54px" type="button" class="btn btn-warning btn-xs m-b-5" onclick="cancel_order('.$invoice_id.')">Cancel</button>
									<a href="'.URLROOT.'/admin/print_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-success btn-xs m-b-5">Print</button></a>';
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
									<a href="'.URLROOT.'/admin/edit_order/'.$invoice_id.'"><button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button></a>
									<button style="width: 54px" type="button" class="btn btn-warning btn-xs m-b-5" onclick="cancel_order('.$invoice_id.')">Cancel</button>
									<a href="'.URLROOT.'/admin/print_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-success btn-xs m-b-5">Print</button></a>';
								
							}

							else
							{
								$all_orders_print.='
									<a href="'.URLROOT.'/admin/edit_order/'.$invoice_id.'"><button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button></a>
									<button style="width: 54px" type="button" class="btn btn-warning btn-xs m-b-5" onclick="cancel_order('.$invoice_id.')">Cancel</button>
									<a href="'.URLROOT.'/admin/print_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-success btn-xs m-b-5">Print</button></a>';
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
									<a href="'.URLROOT.'/admin/edit_order/'.$invoice_id.'"><button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button></a>
									<button style="width: 54px" type="button" class="btn btn-warning btn-xs m-b-5" onclick="cancel_order('.$invoice_id.')">Cancel</button>
									<a href="'.URLROOT.'/admin/print_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-success btn-xs m-b-5">Print</button></a>';
								
							}

							else
							{
								$all_orders_print.='
									<a href="'.URLROOT.'/admin/edit_order/'.$invoice_id.'"><button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button></a>
									<button style="width: 54px" type="button" class="btn btn-warning btn-xs m-b-5" onclick="cancel_order('.$invoice_id.')">Cancel</button>
									<a href="'.URLROOT.'/admin/print_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-success btn-xs m-b-5">Print</button></a>';
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
									<a href="'.URLROOT.'/admin/edit_order/'.$invoice_id.'"><button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button></a>';
							}

							else
							{
								$all_orders_print.='
									<a href="'.URLROOT.'/admin/edit_order/'.$invoice_id.'"><button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button></a>';
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

	  public function delete_service()
	  {
		  $s_id = $_POST['ser_id'];
		  $success = $this->receptionModel->delete_service_db($s_id);
		  if($success)
			echo "Deleted";
		  else
			echo "Error";
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
			  <td style="text-align:left;">'.$invoice_name.'</td>
			  <td style="text-align:left;">'.$invoice_total.'</td>
			  <td>'.$invoice_bill.'</td>
			  <td>
				<a href="'.URLROOT.'/admin/edit_service/'.$invoice_id.'"><button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button></a>
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
			  <td style="text-align:left;">'.$invoice_name.'</td>
			  <td style="text-align:left;">'.$invoice_total.'</td>
			  <td>'.$invoice_bill.'</td>
			  <td>
				<a href="'.URLROOT.'/admin/edit_service/'.$invoice_id.'"><button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button></a>
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
		  $this->view('admin/new_service',$data);
	  }

	  public function new_op_visit()
	  {
		  $doc_list = $this->receptionModel->get_doctors_list();
		  $data = [
			'doc_list' => $doc_list
		  ];
		  $this->view('admin/new_op_visit',$data);
	  }

	  public function all_visit()
	  {
		  $this->view('admin/all_visit');
	  }

	  public function new_ip_visit()
	  {
		$doc_list = $this->receptionModel->get_doctors_list();
		$allIns = $this->receptionModel->getAllIns();
		$data = [
			'doc_list' => $doc_list,
			'ins' => $allIns,
		];
		$this->view('admin/new_ip_visit',$data);
	  }

	  public function all_admissions()
	  {
		 $data = [
				'getAllIns' => $this->receptionModel->getAllIns(),
				'ipd' => $this->receptionModel->get_new_ipd()
			  ];
		  $this->view('admin/all_admissions', $data);
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
			$created_name = $this->receptionModel->get_the_created_name($key->created_by);
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
			<td>'.$created_name.'</td>
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

	public function search_by_p_name()
	{
		$all_orders_print = '';
		$admit_id = $_POST['admit_id'];
		$all_admits = $this->receptionModel->get_all_admit_by_pname($admit_id);
		foreach ($all_admits as $key)
		{
			$created_name = $this->receptionModel->get_the_created_name($key->created_by);

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
				<td>'.$created_name.'</td>
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
			$created_name = $this->receptionModel->get_the_created_name($key->created_by);
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
				<td>'.$created_name.'</td>
				<td style="width:150px">
				';
				
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

	public function search_by_admit_id()
	{
		$all_orders_print = '';
		$admit_id = $_POST['admit_id'];
		$all_admits = $this->receptionModel->get_all_admit_by_id($admit_id);
		foreach ($all_admits as $key)
		{
			$created_name = $this->receptionModel->get_the_created_name($key->created_by);
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
				<td>'.$created_name.'</td>
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
			$created_name = $this->receptionModel->get_the_created_name($key->created_by);
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
				<td>'.$created_name.'</td>
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
		  $this->view('admin/new_patient');
	  }

	  public function all_patients()
	  {
		  $this->view('admin/all_patients');
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
			$created_name = $this->receptionModel->get_the_created_name($key->created_by);
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
			<td>'.$created_name.' - '.$key->created_by.'</td>
			<td>'.date("d-M-Y H:i", strtotime($key->registered_time)).'</td>
			<td>
					<a href="'.URLROOT.'/admin/edit_patient/'.$patient_id.'"><button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button></a>
					<a href="'.URLROOT.'/admin/view_profile_patient/'.$patient_id.'"><button style="width: 54px" type="button" class="btn btn-purple btn-xs m-b-5">View</button></a>
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
			$created_name = $this->receptionModel->get_the_created_name($key->created_by);
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
			<td>'.$created_name.' - '.$key->created_by.'</td>
			<td>'.date("d-M-Y H:i", strtotime($key->registered_time)).'</td>
			<td>
					<a href="'.URLROOT.'/admin/edit_patient/'.$patient_id.'"><button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button></a>
					<a href="'.URLROOT.'/admin/view_profile_patient/'.$patient_id.'"><button style="width: 54px" type="button" class="btn btn-purple btn-xs m-b-5">View</button></a>
					<button style="width: 54px" type="button" class="btn btn-warning btn-xs m-b-5" onclick="remove_pat('.$patient_id.')">Remove</button>
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
			$created_name = $this->receptionModel->get_the_created_name($key->created_by);
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
			<td>'.$created_name.' - '.$key->created_by.'</td>
			<td>'.date("d-M-Y H:i", strtotime($key->registered_time)).'</td>
			<td>
					<a href="'.URLROOT.'/admin/edit_patient/'.$patient_id.'"><button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button></a>
					<a href="'.URLROOT.'/admin/view_profile_patient/'.$patient_id.'"><button style="width: 54px" type="button" class="btn btn-purple btn-xs m-b-5">View</button></a>
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
			$created_name = $this->receptionModel->get_the_created_name($key->created_by);
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
			<td>'.$created_name.' - '.$key->created_by.'</td>
			<td>'.date("d-M-Y H:i", strtotime($key->registered_time)).'</td>
			<td>
					<a href="'.URLROOT.'/admin/edit_patient/'.$patient_id.'"><button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button></a>
					<a href="'.URLROOT.'/admin/view_profile_patient/'.$patient_id.'"><button style="width: 54px" type="button" class="btn btn-purple btn-xs m-b-5">View</button></a>
					<button style="width: 54px" type="button" class="btn btn-warning btn-xs m-b-5" onclick="remove_pat('.$patient_id.')">Remove</button>
			</td>
			</tr>';
		  }
		  echo $all_orders_print;
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

	  public function edit_patient($p_id)
	  {
		  $p_details = $this->receptionModel->get_patient_by_id($p_id);
		  $data = [
			'p_details'=>$p_details
		  ];
		  $this->view('admin/new_patient',$data);
	  }

	  public function new_doctor()
	  {
		  $this->view('admin/new_doctor');
	  }

	  public function edit_doctor($d_id)
	  {
		  $d_list = $this->receptionModel->get_doctor_by_id_single($d_id);
		  $d_user = $this->receptionModel->get_mem_data_single($d_id);
		  $data = [
			'd_list'=> $d_list,
			'd_user' => $d_user
		  ];
		  $this->view('admin/new_doctor',$data);
	  }

	  public function new_member1($d_id)
	  {
		  $mem_list = $this->receptionModel->get_member_by_id($d_id);
		  $data = [
			'mem_list'=>$mem_list,
			'check' => 2
		  ];
		  $this->view('admin/new_member',$data);
	  }

	  public function add_doctor()
	  {
		  $doc_name = $_POST['doc_name'];
		  $doc_spl = $_POST['doc_spl'];
		  $doc_fee = $_POST['doc_fee'];
		  $doc_phone = $_POST['doc_phone'];
		  $doc_email = $_POST['doc_email'];
		  $success = $this->receptionModel->add_doctor_db($doc_name,$doc_spl,$doc_fee,$doc_phone, $doc_email);
		  if($success == 2)
		  {
				echo "Doctor Added";
		  }
		  elseif($success == 3)
		  {
				echo "Email already exists";
		  }
		  else
		  {
				echo "Error";
		  }

	  }

	  public function update_doctor()
	  {
		  $mem_id = $_POST['mem_id'];
		  $doc_name = $_POST['doc_name'];
		  $doc_spl = $_POST['doc_spl'];
		  $doc_fee = $_POST['doc_fee'];
		  $doc_phone = $_POST['doc_phone'];
		  $doc_email = $_POST['doc_email'];
		  $success = $this->receptionModel->update_doctor_db($doc_name,$doc_spl,$doc_fee,$doc_phone,$doc_email,$mem_id);
		  if($success)
			echo "Doctor details updated";
		  else
			echo "Error";
	  }        

	  public function all_doctors()
	  {
		  $this->view('admin/all_doctors');
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
		  $i = 1;

		  foreach ($all_doctorss as $key)
		  {
			$doc_id = $key->doctor_id;
			$phoneEmail = $this->receptionModel->getTheDoctorPhoneAndEmail($key->mem_id);
			$doc_name = $key->doctor_name;
			$doc_spl = $key->doctor_speciality;
			$doc_email = $phoneEmail->mem_email;
			$all_orders_print.='
			<tr>
			  <td style="text-align:left;">'.$phoneEmail->mem_id.'</td>
			  <td style="text-align:left;">'.ucwords($doc_name).'</td>
			  <td style="text-align:left; padding-left:150px;">'.ucwords($doc_spl).'</td>
			  <td style="text-align:left;">'.$doc_email.'</td>
			  <td>
				  <a href="'.URLROOT.'/admin/edit_doctor/'.$key->mem_id.'"><button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button></a>
				  
			  </td>
			</tr>';
			$i++;
		  }
		 //<button style="width: 54px" type="button" class="btn btn-warning btn-xs m-b-5">Remove</button> 
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
			if($mem_type == "rec")
			{
				$mem_type = 'Reception';
			}
			elseif ($mem_type == "nur") 
			{
				$mem_type = 'Nurse';
			}
			elseif ($mem_type == "ot_room") 
			{
				$mem_type = 'Ward Manager';
			}
			elseif ($mem_type == "ot") 
			{
				$mem_type = 'Operation Theater';
			}
			elseif ($mem_type == "pharm") 
			{
				$mem_type = 'Pharmacy';
			}
			elseif ($mem_type == "lab") 
			{
				$mem_type = 'Laboratory';
			}
			elseif ($mem_type == "acc") 
			{
				$mem_type = 'Accountant';
			}
			$mem_phone = $key->mem_phone;
			$mem_email = $key->mem_email;
			if ($mem_name == 'admin')
			{

			}
			else
			$all_orders_print.='<tr>
			  <td>'.$mem_id.'</td>
			  <td style="text-align:left">'.ucwords($mem_name).'</td>
			  <td style="text-align:left">'.ucwords($mem_type).'</td>
			  <td style="text-align:left">'.$mem_phone.'</td>
			  <td style="text-align:left">'.$mem_email.'</td>
			  <td>
				  <a href="'.URLROOT.'/admin/new_member1/'.$mem_id.'"><button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button></a>
			  </td>
			</tr>';
		  }
		//   <a href="'.URLROOT.'/admin/remove_member/'.$mem_id.'"><button style="width: 54px" type="button" class="btn btn-warning btn-xs m-b-5">Remove</button></a>
		  echo $all_orders_print;
	  }

	  public function reports()
	  {
		  $this->view('admin/reports');
	  }

	  public function remove_member($mid)
	  {
		  $this->receptionModel->remove_mem_db($mid);
		  $this->view('admin/all_members');
	  }

	  public function lab_new_orders()
	  {
		$data = [
		  'ty'=>'l'
		];
		$this->view('admin/new_orders',$data);
	  }

	  public function get_report()
	  {
		  $this->view('admin/get_report');
	  }

	  public function all_members()
	  {
		$this->view('admin/all_members');
	  }

	  public function prescription()
	  {
		  $this->view('admin/prescription');
	  }

	public function lab_reports()
	{
		$data = [
			'lab' => $this->receptionModel->getAllLabTest()
		];
		$this->view('admin/lab_reports', $data);
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
					  'dist' => $dist 
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
				$success = $this->receptionModel->save_invoice_db($service_id,$invoice_bill,$grand_total,$patient_name,$doctor_name,$ipopid,$pay_mode,$amount_paid,$status,$dep,$taxx,$dist,$patient_phone); 
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
		{ echo "Patient visit is already created."; }
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
		$this->view('admin/view_invoice',$data);
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
		  $this->view('admin/print_invoice',$data);
	  }

	  public function get_patients_data_to_print($ppid)
	  {
		  return $pdata = $this->receptionModel->get_patient_by_id($ppid);
	  } 

	  public function getIpdDetails($onlyID2)
	  {
		  return $row = $this->receptionModel->getTheIpdDetails($onlyID2);
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
			$created_name = $this->receptionModel->get_the_created_name($key->created_by);
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
			$link= URLROOT."/admin/make_bill_op_visit/".$opd_visit_id_gen;
			$link1= URLROOT."/admin/make_bill_op_visit/".$opd_visit_id_lab;
			$all_orders_print.='<tr>
				<td style="text-align:left;">'.$opd_visit_id.'</td>
				<td style="text-align:left;">'.ucwords($pat_name).' ('.$opd_patient_id.')'.'</td>
				<td style="text-align:left;">'.ucwords($doc_name).'</td>
				<td style="text-align:left;">'.ucwords($opd_purpose).'</td>
				<td style="text-align:left;">'.date('d-m-Y h:i A', strtotime($visit_date_time)).'</td>
				<td style="text-align:left;">'.$opd_visit_fee.'</td>
				<td style="text-align:left;">'.$created_name.' - '.$key->created_by.'</td>
				<td style="text-align:center;">
					<a href='.$link.'><button style="width: 70px" type="button" class="btn btn-info btn-xs m-b-5">Make Bill</button></a>
					<a href='.$link1.'><button style="width: 70px" type="button" class="btn btn-success btn-xs m-b-5">Lab Bill</button></a>
					<button style="width: 70px" type="button" class="btn btn-purple btn-xs m-b-5" onclick="uploadModelForVisit('.$opd_visit_id.')">Upload</button>
				</td>
			</tr>
			';
		}
		echo $all_orders_print;
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
			$link= URLROOT."/admin/make_bill_op_visit/".$opd_visit_id_gen;
			$link1= URLROOT."/admin/make_bill_op_visit/".$opd_visit_id_lab;
			$all_orders_print.='<tr>
				<td style="text-align:left;">'.$opd_visit_id.'</td>
				<td style="text-align:left;">'.ucwords($pat_name).' ('.$opd_patient_id.')'.'</td>
				<td style="text-align:left;">'.ucwords($doc_name).'</td>
				<td style="text-align:left;">'.ucwords($opd_purpose).'</td>
				<td style="text-align:left;">'.date('d-m-Y h:i A', strtotime($visit_date_time)).'</td>
				<td style="text-align:left;">'.$opd_visit_fee.'</td>
				<td style="text-align:center;">
					<a href='.$link.'><button style="width: 70px" type="button" class="btn btn-info btn-xs m-b-5">Make Bill</button></a>
					<a href='.$link1.'><button style="width: 70px" type="button" class="btn btn-success btn-xs m-b-5">Lab Bill</button></a>
					<button style="width: 70px" type="button" class="btn btn-purple btn-xs m-b-5" onclick="uploadModelForVisit('.$opd_visit_id.')">Upload</button>
				</td>
			</tr>
			';
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
			$link= URLROOT."/admin/make_bill_op_visit/".$opd_visit_id_gen;
			$link1= URLROOT."/admin/make_bill_op_visit/".$opd_visit_id_lab;
			$all_orders_print.='<tr>
				<td style="text-align:left;">'.$opd_visit_id.'</td>
				<td style="text-align:left;">'.ucwords($pat_name).' ('.$opd_patient_id.')'.'</td>
				<td style="text-align:left;">'.ucwords($doc_name).'</td>
				<td style="text-align:left;">'.ucwords($opd_purpose).'</td>
				<td style="text-align:left;">'.date('d-m-Y h:i A', strtotime($visit_date_time)).'</td>
				<td style="text-align:left;">'.$opd_visit_fee.'</td>
				<td style="text-align:center;">
						<a href='.$link.'><button style="width: 70px" type="button" class="btn btn-info btn-xs m-b-5">Make Bill</button></a>
						<a href='.$link1.'><button style="width: 70px" type="button" class="btn btn-success btn-xs m-b-5">Lab Bill</button></a>
						<button style="width: 70px" type="button" class="btn btn-purple btn-xs m-b-5" onclick="uploadModelForVisit('.$opd_visit_id.')">Upload</button>
				</td>
			</tr>
			';
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
					// $opd_test_advised=$key->opd_test_advised;
					$pat_name = $this->receptionModel->patient_name($opd_patient_id);
					$doc_name = $this->receptionModel->doctor_name($opd_doctor_id);
					$r='OP'.$opd_visit_id;
					$link= URLROOT."/admin/make_bill_op_visit/".$opd_visit_id_gen;
					$link1= URLROOT."/admin/make_bill_op_visit/".$opd_visit_id_lab;
					$all_orders_print.='<tr>
						<td style="text-align:left;">'.$opd_visit_id.'</td>
						<td style="text-align:left;">'.ucwords($pat_name).' ('.$opd_patient_id.')'.'</td>
						<td style="text-align:left;">'.ucwords($doc_name).'</td>
						<td style="text-align:left;">'.ucwords($opd_purpose).'</td>
						<td style="text-align:left;">'.date('d-m-Y h:i A', strtotime($visit_date_time)).'</td>
						<td style="text-align:left;">'.$opd_visit_fee.'</td>
						<td style="text-align:center;">
							<a href='.$link.'><button style="width: 70px" type="button" class="btn btn-info btn-xs m-b-5">Make Bill</button></a>
							<a href='.$link1.'><button style="width: 70px" type="button" class="btn btn-success btn-xs m-b-5">Lab Bill</button></a>
							<button style="width: 70px" type="button" class="btn btn-purple btn-xs m-b-5" onclick="uploadModelForVisit('.$opd_visit_id.')">Upload</button>
						</td>
					</tr>
					';
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
						$link= URLROOT."/admin/make_bill_op_visit/".$opd_visit_id_gen;
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
											$link1 = URLROOT."/admin/edit_order/".$check->invoice_id;
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
					// $opd_test_advised=$key->opd_test_advised;
					$pat_name = $this->receptionModel->patient_name($opd_patient_id);
					$doc_name = $this->receptionModel->doctor_name($opd_doctor_id);
					$r='OP'.$opd_visit_id;
					$link= URLROOT."/admin/make_bill_op_visit/".$opd_visit_id_gen;
					$link1= URLROOT."/admin/make_bill_op_visit/".$opd_visit_id_lab;
					$all_orders_print.='<tr>
						<td style="text-align:left;">'.$opd_visit_id.'</td>
						<td style="text-align:left;">'.ucwords($pat_name).' ('.$opd_patient_id.')'.'</td>
						<td style="text-align:left;">'.ucwords($doc_name).'</td>
						<td style="text-align:left;">'.ucwords($opd_purpose).'</td>
						<td style="text-align:left;">'.date('d-m-Y h:i A', strtotime($visit_date_time)).'</td>
						<td style="text-align:left;">'.$opd_visit_fee.'</td>
						<td style="text-align:center;">
							<a href='.$link.'><button style="width: 70px" type="button" class="btn btn-info btn-xs m-b-5">Make Bill</button></a>
							<a href='.$link1.'><button style="width: 70px" type="button" class="btn btn-success btn-xs m-b-5">Lab Bill</button></a>
							<button style="width: 70px" type="button" class="btn btn-purple btn-xs m-b-5" onclick="uploadModelForVisit('.$opd_visit_id.')">Upload</button>
						</td>
					</tr>
					';
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
			$this->view('admin/new_order1',$data);
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
								<a href="'.URLROOT.'/admin/print_lab_reports/'.$lab_order_id.'"><button style="width: 72px" type="button" class="btn btn-success btn-xs m-b-5">Print Report</button></a>';
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
			$this->view('admin/print_lab_reports', $data);
	  }

	  public function settings()
	  {
		  $data = [
			'service' => $this->receptionModel->getAllServiceProviderDetails(),
		  ];
		  $this->view('admin/settings', $data);
	  }

		public function service_provider_details()
		{
			$c_name = $_POST['c_name'];
			$c_title = $_POST['c_title'];
			$c_type = $_POST['c_type'];
			$c_add = $_POST['add'];
			$c_email = $_POST['email'];
			$c_phone = $_POST['phone'];
			$c_licence = $_POST['d_licence'];
			$c_gst = $_POST['gst_no'];
			$data = [
			"c_name"=>$c_name,
			"c_title"=>$c_title,
			"c_type"=>$c_type,
			"c_add"=>$c_add,
			"c_email"=>$c_email,
			"c_phone"=>$c_phone,
			"c_licence"=>$c_licence,
			"c_gst"=>$c_gst,
			];
			$this->receptionModel->save_service_provider_db($data);
			redirect('admin/settings');
		}

	  public function service_provider_details1()
	  {
			$f_name=$_FILES['files']['name'];
			$f_tmp=$_FILES['files']['tmp_name'];
			$size=$_FILES['files']['size'];
		
			$f_extension=explode('.', $f_name);
		
			$f_extension=strtolower(end($f_extension));
			$f_newfile='logo.'.$f_extension;
			$store="service_detail/".$f_newfile;
			move_uploaded_file($f_tmp, $store);

			$files_array = $f_newfile;
			$data = [
			"file_name"=>$files_array,
			];
			$this->receptionModel->save_service_provider_db1($data);
			redirect('admin/settings');
	  }

	  public function admin_login()
	  {
		//   header('Location: '.URLMAIN.'/pages/unsetAllCookies');
		redirect('users/login');
	  }

	  // public function login()
	  // {
	  //     header('Location: http://localhost/medhike_primary');
	  // }

		public function logout()
		{
			unset($_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
			unset($_SESSION['type']);
			unset($_SESSION['user_name']);
			redirect('admin/admin_login');
		}

	  public function newInsurance()
	  {
		  $this->view('admin/newInsurance');
	  }

	  public function saveInsurance()
	  {
		  $agId = $_POST['agId'];
		  $agName = $_POST['agName'];
		  $success = $this->receptionModel->saveInsuranceDb($agId, $agName);
		  if($success == 1)
		  {
			  redirect('admin/newInsurance');
		  }
		  else
		  {
			  redirect('admin/allInsurance');
		  }
	  }

	  public function allInsurance()
	  { 
		  $this->view('admin/allInsurance');
	  }

	  public function all_insu1()
	  {
		  $lim = $_POST['lim'];
		  $lim = (int)$lim;
		  if($lim==9)
		  {
			$off = $_POST['off'];
			$off = (int)$off;
			$all_service = $this->receptionModel->getAllInsu($lim,$off);
		  }
		  else
		  {
			$inc = $_POST['inc'];
			$inc = (int)$inc;
			$lim = 9;
			$off = 9+(9*$inc);
			$all_service = $this->receptionModel->getAllInsu($lim,$off);
		  }
		  $all_orders_print = '';

		  foreach ($all_service as $key)
		  {
			$all_orders_print.='<tr>
			  <td id="r_id" style="text-align: left;">'.$key->insurance_id.'</td>
			  <td style="text-align: left;">'.$key->insurance_name.'</td>
			</tr>';
		  }
		  echo $all_orders_print;
	  }

	  public function all_orders_lab()
	  {
		$this->view('admin/all_orders_lab');
	  }

	  public function all_orders_bal()
	  {
		  $this->view('admin/all_orders_bal');
	  }

	  public function active_orders()
	  {
		  $this->view('admin/active_orders');
	  }

	  public function oldOrder()
	  {
		  $this->view('admin/oldOrder');
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
						<td style="padding-top:15px; text-align:left; padding-left:95px;"><a href="'.URLROOT.'/admin/print_invoice_old/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-success btn-xs m-b-5">Print</button></a>
						<a href="'.URLROOT.'/admin/view_invoice_old/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-purple btn-xs m-b-5">View</button></a>';
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
						<td style="padding-top:15px; text-align:left; padding-left:65px;">
						<a href="'.URLROOT.'/admin/print_invoice_old/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-success btn-xs m-b-5">Print</button></a>
						<a href="'.URLROOT.'/admin/view_invoice_old/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-purple btn-xs m-b-5">View</button></a>';
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
						<td style="padding-top:15px; text-align:left; padding-left:65px;">
						<a href="'.URLROOT.'/admin/print_invoice_old/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-success btn-xs m-b-5">Print</button></a>
						<a href="'.URLROOT.'/admin/view_invoice_old/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-purple btn-xs m-b-5">View</button></a>';
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
						<td style="padding-top:15px; text-align:left; padding-left:65px;">
						<a href="'.URLROOT.'/admin/print_invoice_old/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-success btn-xs m-b-5">Print</button></a>
						<a href="'.URLROOT.'/admin/view_invoice_old/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-purple btn-xs m-b-5">View</button></a>';
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
					$this->view('admin/view_invoice_old',$data);
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
					$this->view('admin/print_invoice_old',$data);
			}

	  public function billPattern()
	  {
		  $pattern = $_POST['pattern'];
		  $this->receptionModel->saveBillPattern($pattern);
		  redirect('admin/settings');
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
			$this->view('admin/view_profile_patient', $data);
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
  
  public function getServiceNameFull($id)
  {
	  return $row = $this->receptionModel->getServiceNameFullDb($id);
  }

  	public function get_patients_data_to_print_old($ppid)
	{
			return $pdata = $this->receptionModel->get_patient_by_id_old($ppid);
	}

	public function getServiceName($id)
	{
			return $serviceName = $this->receptionModel->getServiceNameDb($id);
	}

	public function get_all_patient_details($patient_id)
	{
		return $p_data = $this->receptionModel->get_patient_by_id($patient_id);
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
			$this->view('admin/discharge_summary', $data);
	}

	public function print_admit_medicines($id)
	{
		$data = [
			'ipd_days'  => $this->doctorModel->get_ipd_days($id),
			'ipd' => $this->doctorModel->get_ipd_main_data($id),
			'logo' => $this->receptionModel->get_logo_details()
		];
		$this->view('admin/print_admit_medicines', $data);
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
									redirect('admin/index');             
							}


				$data = [
					'logo' => $logo,
					'opd' => $row,
					'patient_name' =>$pat,
					'doc_name' => $doc
				];
				$this->view('admin/print_prescription', $data);

		}
		else
		{
				redirect('users/login');
		}
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
                                      <a href="'.URLROOT.'/admin/print_prescription/'.$visit_id.'"><button style="width: 100px" type="button" class="btn btn-info btn-xs m-b-5"> Print </button></a><br>
                                  </td>
                              </tr>';
          }
          echo $all_orders_print;
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
                                      <a href="'.URLROOT.'/admin/print_prescription/'.$visit_id.'"><button style="width: 100px" type="button" class="btn btn-info btn-xs m-b-5"> Print </button></a><br>
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
                                      <a href="'.URLROOT.'/admin/print_prescription/'.$visit_id.'"><button style="width: 100px" type="button" class="btn btn-info btn-xs m-b-5"> Print </button></a><br>
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
                                      <a href="'.URLROOT.'/admin/print_prescription/'.$visit_id.'"><button style="width: 100px" type="button" class="btn btn-info btn-xs m-b-5"> Print </button></a><br>
                                  </td>
                              </tr>';
          }
          echo $all_orders_print;
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
			redirect('admin/all_visit');
	}

	public function removed_pat_disp()
	{
			$this->view('admin/removed_pat_disp');
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
				$patient_name = ucwords($key->patient_name);
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
				$patient_name = ucwords($key->patient_name);
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
				$patient_name = ucwords($key->patient_name);
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
				$patient_name = ucwords($key->patient_name);
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
          $this->view('admin/get_report', $data);
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
          $this->view('admin/get_report', $data);
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
          $this->view('admin/get_report', $data);
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
									<a href="'.URLROOT.'/admin/print_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-success btn-xs m-b-5">Print</button></a>
									<a href="'.URLROOT.'/admin/view_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-purple btn-xs m-b-5">View</button></a>';
							}

							else
							{
								$all_orders_print.='<a href="'.URLROOT.'/admin/print_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-success btn-xs m-b-5">Print</button></a>
									<a href="'.URLROOT.'/admin/view_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-purple btn-xs m-b-5">View</button></a>';
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
									<a href="'.URLROOT.'/admin/print_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-success btn-xs m-b-5">Print</button></a>
									<a href="'.URLROOT.'/admin/view_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-purple btn-xs m-b-5">View</button></a>';
							}

							else
							{
								$all_orders_print.='<a href="'.URLROOT.'/admin/print_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-success btn-xs m-b-5">Print</button></a>
									<a href="'.URLROOT.'/admin/view_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-purple btn-xs m-b-5">View</button></a>';
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
									<a href="'.URLROOT.'/admin/print_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-success btn-xs m-b-5">Print</button></a>
									<a href="'.URLROOT.'/admin/view_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-purple btn-xs m-b-5">View</button></a>';
							}

							else
							{
								$all_orders_print.='<a href="'.URLROOT.'/admin/print_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-success btn-xs m-b-5">Print</button></a>
									<a href="'.URLROOT.'/admin/view_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-purple btn-xs m-b-5">View</button></a>';
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
									<a href="'.URLROOT.'/admin/print_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-success btn-xs m-b-5">Print</button></a>
									<a href="'.URLROOT.'/admin/view_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-purple btn-xs m-b-5">View</button></a>';
							}

							else
							{
								$all_orders_print.='<a href="'.URLROOT.'/admin/print_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-success btn-xs m-b-5">Print</button></a>
									<a href="'.URLROOT.'/admin/view_invoice/'.$invoice_id.'"><button style="width: 54px;" type="button" class="btn btn-purple btn-xs m-b-5">View</button></a>';
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

			public function excelReports()
			{

			}

			public function patientReports()
			{
				$this->view('admin/patientReports');
			}

			public function labReports()
			{
				header("Content-type: application/vnd.ms-excel");
				header("Content-Disposition: attachment; filename=patientDetails.xls");
				$labs = $this->receptionModel->getAllInvoiceLabRow();
				$template = "<table border='1'>
					<thead>
						<tr>
							<th bgcolor='#FFD54F'>invoice_id</th>
							<th bgcolor='#FFD54F'>patient_name</th>
							<th bgcolor='#FFD54F'>patient_id</th>
							<th bgcolor='#FFD54F'>invoice_total</th>
							<th bgcolor='#FFD54F'>amount_paid</th>
							<th bgcolor='#FFD54F'>invoice_date</th>
						</tr>
					</thead>
					<tbody>
				";
				foreach($labs as $patient)
				{
					$pName = explode('|', $patient->invoice_name);
					$template .= "<tr>
						<td>".$patient->invoice_id."</td>
						<td>".ucwords($pName[0])."</td>
						<td>".$pName[1]."</td>
						<td>".$patient->invoice_total."</td>
						<td>".$patient->amount_paid."</td>
						<td>".$patient->invoice_date."</td>
					</tr>";
				}
				$template .= "</tbody>";
				echo $template;
			}

			public function pharmacyReports()
			{
				header("Content-type: application/vnd.ms-excel");
				header("Content-Disposition: attachment; filename=patientDetails.xls");
				$pharm = $this->receptionModel->getAllPharmInvoiceRow();
				$template = "<table border='1'>
					<thead>
						<tr>
							<th bgcolor='#FFD54F'>invoice_id</th>
							<th bgcolor='#FFD54F'>patient_name</th>
							<th bgcolor='#FFD54F'>invoice_total</th>
							<th bgcolor='#FFD54F'>invoice_date</th>
						</tr>
					</thead>
					<tbody>
				";
				foreach($pharm as $patient)
				{
					// $pName = explode('|', $patient->invoice_name);
					$template .= "<tr>
						<td>".$patient->invoice_id."</td>
						<td>".ucwords($patient->invoice_name)."</td>
						<td>".$patient->invoice_total."</td>
						<td>".$patient->invoice_date_time."</td>
					</tr>";
				}
				$template .= "</tbody>";
				echo $template;
			}

			public function generalReports()
			{
				header("Content-type: application/vnd.ms-excel");
				header("Content-Disposition: attachment; filename=patientDetails.xls");
				$labs = $this->receptionModel->getAllInvoiceRegRow();
				$template = "<table border='1'>
					<thead>
						<tr>
							<th bgcolor='#FFD54F'>invoice_id</th>
							<th bgcolor='#FFD54F'>patient_name</th>
							<th bgcolor='#FFD54F'>patient_id</th>
							<th bgcolor='#FFD54F'>invoice_total</th>
							<th bgcolor='#FFD54F'>amount_paid</th>
							<th bgcolor='#FFD54F'>invoice_date</th>
						</tr>
					</thead>
					<tbody>
				";
				foreach($labs as $patient)
				{
					$pName = explode('|', $patient->invoice_name);
					$template .= "<tr>
						<td>".$patient->invoice_id."</td>
						<td>".ucwords($pName[0])."</td>
						<td>".$pName[1]."</td>
						<td>".$patient->invoice_total."</td>
						<td>".$patient->amount_paid."</td>
						<td>".$patient->invoice_date."</td>
					</tr>";
				}
				$template .= "</tbody>";
				echo $template;
			}

			public function exportPatientData()
			{
				$pat = explode('|', $_POST['pat']);
				$patientId = trim($pat[1]);

				header("Content-type: application/vnd.ms-excel");
				header("Content-Disposition: attachment; filename=patientDetails.xls");
				$patient = $this->receptionModel->getPatientRow($patientId);
				$template = "<table border='1'>
					<thead>
						<tr>
						<th bgcolor='#FFD54F'>patient_id</th>
						<th bgcolor='#FFD54F'>patient_name</th>
						<th bgcolor='#FFD54F'>patient_gender</th>
						<th bgcolor='#FFD54F'>patient_dob</th>
						<th bgcolor='#FFD54F'>patient_age</th>
						<th bgcolor='#FFD54F'>patient_phone</th>
						<th bgcolor='#FFD54F'>patient_email</th>
						<th bgcolor='#FFD54F'>patient_address</th>
						<th bgcolor='#FFD54F'>hypertension</th>
						<th bgcolor='#FFD54F'>diabetes</th>
						<th bgcolor='#FFD54F'>coronary</th>
						<th bgcolor='#FFD54F'>cerebro</th>
						<th bgcolor='#FFD54F'>dyslipidaemia</th>
						<th bgcolor='#FFD54F'>hypothyroidism</th>
						<th bgcolor='#FFD54F'>registered_time</th>
						<th bgcolor='#FFD54F'>active</th>
						<th bgcolor='#FFD54F'>patient_height</th>
						<th bgcolor='#FFD54F'>patient_weight</th>
						<th bgcolor='#FFD54F'>created_by</th>
						</tr>
					</thead>
					<tbody>
				";
				$template .= "<tr>
					<td>".$patient->patient_id."</td>
					<td>".$patient->patient_name."</td>
					<td>".$patient->patient_gender."</td>
					<td>".$patient->patient_dob."</td>
					<td>".$patient->patient_age."</td>
					<td>".$patient->patient_phone."</td>
					<td>".$patient->patient_email."</td>
					<td>".$patient->patient_address."</td>
					<td>".$patient->hypertension."</td>
					<td>".$patient->diabetes."</td>
					<td>".$patient->coronary."</td>
					<td>".$patient->cerebro."</td>
					<td>".$patient->dyslipidaemia."</td>
					<td>".$patient->hypothyroidism."</td>
					<td>".$patient->registered_time."</td>
					<td>".$patient->active."</td>
					<td>".$patient->patient_height."</td>
					<td>".$patient->patient_weight."</td>
					<td>".$patient->created_by."</td>
				</tr>";
				$template .= "</tbody>";
				echo $template;
			}

			public function exportPatientAllData()
			{
				header("Content-type: application/vnd.ms-excel");
				header("Content-Disposition: attachment; filename=patientDetails.xls");
				$patients = $this->receptionModel->getAllPatientRow();
				$template = "<table border='1'>
					<thead>
						<tr>
						<th bgcolor='#FFD54F'>patient_id</th>
						<th bgcolor='#FFD54F'>patient_name</th>
						<th bgcolor='#FFD54F'>patient_gender</th>
						<th bgcolor='#FFD54F'>patient_dob</th>
						<th bgcolor='#FFD54F'>patient_age</th>
						<th bgcolor='#FFD54F'>patient_phone</th>
						<th bgcolor='#FFD54F'>patient_email</th>
						<th bgcolor='#FFD54F'>patient_address</th>
						<th bgcolor='#FFD54F'>hypertension</th>
						<th bgcolor='#FFD54F'>diabetes</th>
						<th bgcolor='#FFD54F'>coronary</th>
						<th bgcolor='#FFD54F'>cerebro</th>
						<th bgcolor='#FFD54F'>dyslipidaemia</th>
						<th bgcolor='#FFD54F'>hypothyroidism</th>
						<th bgcolor='#FFD54F'>registered_time</th>
						<th bgcolor='#FFD54F'>active</th>
						<th bgcolor='#FFD54F'>patient_height</th>
						<th bgcolor='#FFD54F'>patient_weight</th>
						<th bgcolor='#FFD54F'>created_by</th>
						</tr>
					</thead>
					<tbody>
				";
				foreach($patients as $patient)
				{
				$template .= "<tr>
					<td>".$patient->patient_id."</td>
					<td>".$patient->patient_name."</td>
					<td>".$patient->patient_gender."</td>
					<td>".$patient->patient_dob."</td>
					<td>".$patient->patient_age."</td>
					<td>".$patient->patient_phone."</td>
					<td>".$patient->patient_email."</td>
					<td>".$patient->patient_address."</td>
					<td>".$patient->hypertension."</td>
					<td>".$patient->diabetes."</td>
					<td>".$patient->coronary."</td>
					<td>".$patient->cerebro."</td>
					<td>".$patient->dyslipidaemia."</td>
					<td>".$patient->hypothyroidism."</td>
					<td>".$patient->registered_time."</td>
					<td>".$patient->active."</td>
					<td>".$patient->patient_height."</td>
					<td>".$patient->patient_weight."</td>
					<td>".$patient->created_by."</td>
				</tr>";
				}
				$template .= "</tbody>";
				echo $template;
			}

		public function getPlans()
		{
			$this->view('admin/getPlans');
		}

		public function clincBuy()
		{
			$_SESSION['currencyType'] = $_POST['currencyType'];
			$_SESSION['price'] = $_POST['price'];
			$_SESSION[] = $_POST['mOrY'];
			$this->view('admin/pgRedirect');
		}

		public function buyClinicPro()
		{
			$_SESSION['currencyType'] = $_POST['currencyType'];
			$_SESSION['price'] = $_POST['price'];
			$_SESSION[] = $_POST['mOrY'];
			$this->view('admin/pgRedirect');
		}

		public function paymentStatus()
		{
			echo "Successfull";
		}

		public function payment($plan)
		{
			if($_POST['currencyType'] == 1)
	        {
	            $_SESSION['cType'] = "INR";
	        }  
	        if($_POST['currencyType'] == 2)
	        {
	            $_SESSION['cType'] = "USD";
	        }
			$_POST['currencyType'];
			$_SESSION['price'] = (int)$_POST['price'];
			$_POST['mOrY']; 
			$_SESSION['renewPlan'] = $plan."mdhk".$_POST['mOrY']."mdhk".$_SESSION['db_name_for_assign'].'mdhk'.$_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no'];
			header('Location: '.URLMAIN.'/pages/redirectForPayments');
		}
		// End end
		public function refLabs()
		{
			$this->view('admin/refLabs');
		}

		public function allRefLab()
		{
			$data = [
				'ref' => $this->receptionModel->getTheRefLab(),
			];
			$this->view('admin/allRefLab', $data);
		}

		public function removeRefLabBy()
		{
			$this->receptionModel->removeRefLabByIdDb($_POST['ref_lab_id']);
			echo "Removed";
		}
		public function addRefLab()
		{
			$this->receptionModel->addTheRefLab($_POST['labName']);
			redirect('admin/allRefLab');
		}
		public function birthCerticate()
		{
			$this->view('admin/birthCerticate');
		}
		public function generateBirthCertificate()
		{
			$data = [
				'name' => $_POST['name'],
				'dateTime' => $_POST['dateTime'],
				'gender' => $_POST['gender'],
				'regDate' => $_POST['regDate'],
				'motherName' => $_POST['motherName'],
				'fatherName' => $_POST['fatherName'],
				'address' => $_POST['address'],	
			];
			if($this->receptionModel->saveBirthCertificateDb($data))
			{
				$data += [
					'logo' => $this->receptionModel->get_logo_details(),
				];
				$this->view('admin/generateBirthCertificate', $data);
			}
		}
		public function ambulanceService()
			{
				$data = [
					'ambulances' => $this->receptionModel->getAllTheAmbulanceForService(),
				];
				$this->view('admin/ambulanceService', $data);
			}
		public function addAmbulance()
			{
				$this->view('admin/addAmbulance');
			}

			public function saveAmbulance()
			{
				$this->receptionModel->addAmbulanceDb($_POST['name'], $_POST['vehNumber'], $_POST['seatsCapacity']);
				redirect('admin/allAmbulances');
			}

			public function allAmbulances()
			{
				$this->view('admin/allAmbulances');
			}

			public function allAmbulanceList()
			{
				$lim = $_POST['lim'];
				$lim = (int)$lim;
				if($lim==9)
				{
				$off = $_POST['off'];
				$off = (int)$off;
				$allAmb = $this->receptionModel->getAllTheAmbulance($lim,$off);
				}
				else
				{
				$inc = $_POST['inc'];
				$inc = (int)$inc;
				$lim = 9;
				$off = 9+(9*$inc);
				$allAmb = $this->receptionModel->getAllTheAmbulance($lim,$off);
				}
				$all_orders_print = '';

				foreach ($allAmb as $key)
				{
					$all_orders_print .= '<tr>
					<td>'.$key->vehicle_id.'</td>
					<td style="text-align:left">'.$key->vehicle_name.'</td>
					<td>'.strtoupper($key->vehicle_number).'</td>
					<td>'.$key->seating_capacity.'</td>
					<td>';
					if($key->active == 1)
					{
						$all_orders_print .= '
							<a href="'.URLROOT.'/admin/removeAmbulance/'.$key->vehicle_id.'"><button class="btn btn-warning btn-xs">Remove</button></a>
						</td>';
					}
					else
					{
						$all_orders_print .= '
							<a href="'.URLROOT.'/admin/restoreAmbulance/'.$key->vehicle_id.'"><button class="btn btn-success btn-xs">Restore</button></a>
						</td>';
					}
					$all_orders_print .= '</tr>';
				}
				echo $all_orders_print;
			}

			public function removeAmbulance($id)
			{
				if($this->receptionModel->inactiveAmbulance($id))
				{
					redirect('admin/allAmbulances');
				}
			}

			public function restoreAmbulance($id)
			{
				if($this->receptionModel->activeAmbulance($id))
				{
					redirect('admin/allAmbulances');
				}
			}

			public function assignAmbulance()
			{
				$vehicleId = $_POST['vehicleId'];
				$patient = $_POST['patient'];
				$driver = $_POST['driver'];
				$irk = $_POST['irk'];
				$condition = $_POST['condition'];
				$fromTime = $_POST['fromTime'];
				$remarks = $_POST['remarks'];
				$address = $_POST['address'];
				$data = [
					'vehicleId' => $vehicleId,
					'driver' => $driver,
					'irk' => $irk,
					'condition' => $condition,
					'fromTime' => $fromTime,
					'remarks' => $remarks,
					'address' => $address,
				];
				if(isset($_POST['int']))
				{
					$type = 1;
					$p = explode('|', $patient);
					$pName = $p[0];
					$pId = $p[1];
					$data += [
						'pName' => $pName,
						'pId' => $pId,
						'type' => $type,
					];
					$this->receptionModel->saveAssignAmbulanceDetailsInt($data);
					redirect('admin/ambulanceService');
				}
				if(isset($_POST['ext']))
				{
					$type = 2;
					$pName = $patient;
					$data += [
						'pName' => $pName,
						'type' => $type,
					];
					$this->receptionModel->saveAssignAmbulanceDetailsExt($data);
					redirect('admin/ambulanceService');
				}
			}

			public function assignedAmbulance()
			{
				$this->view('admin/assignedAmbulance');
			}

			public function allAssignedList()
			{
				$lim = $_POST['lim'];
				$lim = (int)$lim;
				if($lim==9)
				{
				$off = $_POST['off'];
				$off = (int)$off;
				$allAmb = $this->receptionModel->getAllAssignedAmbulance($lim,$off);
				}
				else
				{
				$inc = $_POST['inc'];
				$inc = (int)$inc;
				$lim = 9;
				$off = 9+(9*$inc);
				$allAmb = $this->receptionModel->getAllAssignedAmbulance($lim,$off);
				}
				$all_orders_print = '';

				foreach ($allAmb as $key)
				{
					$all_orders_print .= '<tr>
					<td>'.$key->vehicle_id.'</td>
					<td style="text-align:left">'.$key->patient_name.'('.$key->patient_id.')</td>
					<td>'.strtoupper($key->driver_name).'</td>
					<td>';
					if($key->service_type == 1)
					{
						$all_orders_print .= '
							Internal
						</td>';
					}
					else
					{
						$all_orders_print .= '
							External
						</td>';
					}
					$all_orders_print .= '<td>';
					if($key->status == 1)
					{
						$all_orders_print .= '
							Pending
						</td>';
					}
					elseif($key->status == 2)
					{
						$all_orders_print .= '
							Completed
						</td>';
					}
					$all_orders_print .= '<td>';
					if($key->status == 1)
					{
						$all_orders_print .= '
							<a href="'.URLROOT.'/admin/viewAmbulanceService/'.$key->as_id.'"><button class="btn btn-purple btn-xs" style="width:56px;" >View</button></a>
							<a href="'.URLROOT.'/admin/updateAmbulance/'.$key->as_id.'"><button class="btn btn-primary btn-xs" style="width:56px;">Update</button></a>
						</td>';
					}
					elseif($key->status == 2)
					{
						$all_orders_print .= '
						<a href="'.URLROOT.'/admin/viewAmbulanceService/'.$key->as_id.'"><button class="btn btn-purple btn-xs" style="width:56px;" >View</button></a>
						</td>';
					}
					$all_orders_print .= '</tr>';
				}
				echo $all_orders_print;				
			}

			public function updateAmbulance($id)
			{
				$data = [
					'service' => $this->receptionModel->getAssignedService($id),
				];
				$this->view('admin/updateAmbulance', $data);
			}

			public function finishAmbulanceService($id)
			{
				$this->receptionModel->saveFinishServiceDetails($_POST['resource'], $_POST['finalReading'], $_POST['toTime'], $id);
				redirect('admin/assignedAmbulance');
			}

			public function viewAmbulanceService($id)
			{
				$data = [
					'service' => $this->receptionModel->getAssignedService($id),
				];
				$this->view('admin/viewAmbulanceService', $data);
			}

			public function updateCth()
			{
				$this->receptionModel->saveCth($_POST['per'], $_POST['memId'], $_POST['cost']);
			}
	//all permission********************************************************************************
	public function all_permissions()
    {
        $_SESSION['db_name'] = 87;
        $_SESSION['user_type'] = 0;
        if($_SESSION['user_type'] == 0)
        {
            $data = [
                        'all_emp' => $this->receptionModel->get_all_emp(),
                    ];
            $this->view('admin/all_permission',$data);
        }
        else
        {
            redirect('users/logout');
        }
    }
	public function give_permission($id)
    {
       $data = [
                    's_emp' => $this->receptionModel->get_single_emp($id),
                    'p_all' => $this->receptionModel->get_permission_all(),
                    'emp_per' => $this->receptionModel->get_single_emp($id),
                ]; 
       $this->view('admin/add_or_edit_permission',$data);
    }
    
	public function update_permission($id)
	{
	    if(isset($_POST['check23']) AND isset($_POST['check24']))
	    {
	        $_SESSION['success']="choose any one customer priority.";
	        redirect('admin/all_permissions');   
	    }elseif(isset($_POST['check87']) AND isset($_POST['check88']))
	    {    
	        $_SESSION['success']="choose any one Database.";
	        redirect('admin/all_permissions');   
	    }else
	    {    
	        $ps = array();
	        $per = $this->receptionModel->get_permission_all();
	        foreach ($per as $k) 
	        {
	            if(isset($_POST['check'.$k->id.'']))
	            {
	                $ps[] = $k->id;
	            }
	        }
	        $ps = implode("|", $ps);
	        $this->receptionModel->update_permissiondb($ps,$id);
	        $_SESSION['success']="Permissions created successfully";
	        redirect('admin/all_permissions');
	    }
	}
	
	public function new_message()
	{
	    $this->view('admin/new_message');
	}
	
	public function add_message_admin()
	{
	    $per = $this->receptionModel->add_message_admin($_POST['p_name']);
	}
	
	public function all_message()
	{
	    $this->view('admin/all_message');
	}
	
	public function all_message1()
	{
		$lim = $_POST['lim'];
		$lim = (int)$lim;
		
		if($lim==9)
		{
		    $off = $_POST['off'];
		    $off = (int)$off;
		    $all_patients = $this->receptionModel->get_all_message();
		}
		else
		{
		    $inc = $_POST['inc'];
		    $inc = (int)$inc;
		    $lim = 9;
            $off = 9+(9*$inc);
		    $all_patients = $this->receptionModel->get_all_message();
		}
		
		$all_orders_print = '';
		
		foreach ($all_patients as $key)
		{
			$message_id = $key->id;
			$message = $key->message;
			$created_at = date('d-M-Y H:i A',strtotime($key->created_at));
			
			$all_orders_print.='<tr>
			<td>'.$message_id.'</td>
			<td style="text-align:left;">'.$message.'</td>
			<td>'.$created_at.'</td>
			<td>
			    <a href="'.URLROOT.'/admin/edit_message/'.$message_id.'"><button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button></a>
				<a href="'.URLROOT.'/admin/view_profile_patient/'.$message_id.'"><button style="width: 54px" type="button" class="btn btn-purple btn-xs m-b-5">Delete</button></a>
			</td>
			</tr>';
		}
		
	    echo $all_orders_print;
	  }
	  
	  public function edit_message($message_id)
	  {
	        $msg_res = $this->receptionModel->get_message_byId($message_id);
	      
	        $data = [
                'msg_res' => $msg_res,
                'message_id' => $message_id
            ]; 
	      
	      $this->view('admin/edit_message', $data);
	  }
	  
	public function update_message_admin()
	{
	    $per = $this->receptionModel->update_message_admin($_POST['p_name'], $_POST['message_id']);
	   
	   echo $per;
	}
	
	
	
	
	
	
	
  }// end of class
 ?>
