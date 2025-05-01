<?php
  class Ot extends Controller
  {
		public function __construct()
		{
		// $this->doctorModel = $this->model('Doctor');
		// $this->receptionModel = $this->model('Reception');
		$this->otModel = $this->model('Ots');

		}

		public function index()
		{
			$c_op=$this->otModel->currentop_count();
			$a_op=$this->otModel->activeop_count();
			$co_op=$this->otModel->completedop_count();
			$ca_op=$this->otModel->cancledop_count();

			$data = [ 
				'req' => $c_op,
				'active' => $a_op,
				'completed' => $co_op,
				'canceled' => $ca_op
			];
			$this->view('ot/index',$data);
		}

			public function current_operation()
		{
			
			$ot = $this->otModel->get_all_ot_with_patient_name();
			$rooms = $this->otModel->get_all_rooms();

								// get_room_no($id)

			$data = [ 
				'ot' => $ot,
				'room' => $rooms,
			];
			$this->view('ot/current_operation', $data);
		}

			public function current_room_update($id)
			{
				
				 if($_SERVER['REQUEST_METHOD'] == 'POST')
		        {
		            //Sanitize post array
		            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

		            $data = [
		            		'room_id' =>  $_POST['room_id'],
		            		'ot_id' => $id,
		                    'room_id_err'    => ''
		            ];
		  			
		            //validate title
		            if(empty($data['room_id']))
		            {
		                $data['room_id_err'] = 'Please enter Description';
		            }

		            //check if errors are present
		            if(empty($data['room_id_err']) )
		            {

		                //validated
		                if($this->otModel->current_room_update_status($data))
		                {
		                	$this->otModel->room_status_update($data);
		                    //flash('post_message', 'Post Added');
		                	redirect('ot/current_operation');
		                }
		                else
		                {
		                    die('Something went wrong');
		                }
		               
		            }else{
		                //load view with errors
		                $this->view('ot/current_operation', $data);
		            }

		        }
		        else
		        {
					$this->view('ot/current_operation');
				}

			}

		





		public function temp_current_org()
		{
			
			$ot = $this->otModel->get_all_ot_with_patient_name();

			$data = [ 
				'ot' => $ot,
			];
			$this->view('ot/temp_current_org', $data);
		}

		public function active_status_from_current($id)
		{
			$r = $this->otModel->get_room_status($id);

			if($r->room_ref_id == 0)
			{
				?>
					<script type="text/javascript">
					alert("select room first");
					window.open("<?php echo URLROOT;?>/ot/current_operation",'_self');
					</script>
				<?php

				//redirect('ot/current_operation');
			}
			else
			{

			$result = $this->otModel->status_current_update($id);
			redirect('ot/active_operation');
			}
		}

		public function active_status_from_current_cancel($id)
		{
			$result = $this->otModel->status_current_update_cancel($id);
			redirect('ot/canceled_operation');
		}






		public function room_cancel_status($id)
		{
			$result = $this->otModel->room_cancel_status_for_room($id);
			redirect('ot/current_operation');
		}

		

		public function pat_name($id)
		{
			$name = $this->otModel->patient_name($id);
			return $name;
		}

		public function new_operation()
		{
			if($_SERVER['REQUEST_METHOD'] == 'POST')
		        {
		            //Sanitize post array
		            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

		            $data = [
		            		'patient_id' => $_POST['patient_id'],
		                    'op_date_time'      => $_POST['op_date_time'],
		                    'r_doctor_id'     => $_POST['r_doctor_id'],
		                    'op_name'     => $_POST['op_name'],
		                    'description'  => $_POST['description'],
		                    'description_err'    => ''
		            ];
		  			
		            //validate title
		            if(empty($data['description']))
		            {
		                $data['description_err'] = 'Please enter Description';
		            }

		            //check if errors are present
		            if(empty($data['description_err']) )
		            {

		                //validated
		                if($this->otModel->new_add_operation($data))
		                {
		                    //flash('post_message', 'Post Added');
		                	redirect('ot/current_operation');
		                }
		                else
		                {
		                    die('Something went wrong');
		                }
		               
		            }else{
		                //load view with errors
		                $this->view('ot/new_operation', $data);
		            }

		        }
		        else
		        {
					$this->view('ot/new_operation');
				}
		}
		public function active_operation()
		{
			$ot = $this->otModel->get_all_ot_with_patient_name();

			$data = [ 
				'ot' => $ot,
			];
			$this->view('ot/active_operation',$data);
		}



		public function edit_operation($id)
		{
			 $service = $this->otModel->service_details($id);
			 $result = $this->otModel->status_edit_update($id);
			 $result1 = $this->otModel->get_single_operation_fromot($id);
			 $result2 = $this->otModel->get_single_operation_frompatient($result1->patient_id);
			 $result3 = $this->otModel->get_single_operation_fromusers($result1->ip_op_doc_ref_id);
			 $result4 = $this->otModel->get_single_operation_fromipd($result1->patient_id);

			$data = [ 
						'ot_id' => $result1 ->ot_id,
						'patient_id' => $result1 ->patient_id,
						'patient_name' => $result2 ->patient_name,
						'patient_gender' => $result2 ->patient_gender,
						'patient_dob' => $result2 ->patient_dob,
						'patient_age' => $result2 ->patient_age,
						'ip_op_ref' => $result1 ->ip_op_ref,
						'ot_date' => $result1 ->ot_date,
						'ot_name' => $result1 ->ot_name,
						'ot_description' => $result1 ->ot_description,
						'status' => $result1 ->status,
						'feedback' => $result1 ->feedback,
						'created_at' => $result1 ->created_at,
						'admission_date_time' => $result4 ->admission_date_time,
						'mem_name' => $result3->mem_name,
						'serv' => $service
					];
			$this->view('ot/edit_operation',$data);
		}



		public function update_service_row($id)
		{
			$data = [
		            		'services' =>  $_POST['services'],
		            		'cost' => $_POST['cost'],
		            		'id' => $id,
		                    'services_err'    => ''
		            ];
		            if(isset($_POST['services']))
		            {
						$result = $this->otModel->update_service_row_ots($data);
					}
			redirect('ot/edit_operation/'.$id.'');
		}

		
			
        
			
			
			//redirect('ot/completed_operation');
		


		public function save_ed_op_update($id)
		{	

				if($_SERVER['REQUEST_METHOD'] == 'POST')
		        {
		            //Sanitize post array
		            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

		            $data = [
		            		'id' => $id,
		                    'op_date_time'      => $_POST['op_date_time'],
		                    'description'  => $_POST['description'],
		                    'feedback'     => $_POST['feedback'],
		                   	
		                    'description_err'    => ''
		            ];
		  			


		            //validate title
		            if(empty($data['description']))
		            {
		                $data['description_err'] = 'Please enter Description';
		            }

		            //check if errors are present
		            if(empty($data['description_err']) )
		            {

		                //validated
		                if($this->otModel->save_edit_operation($data))
		                {
		                    //flash('post_message', 'Post Added');
		                	if(isset($_POST['save']))
		                	{
		                		redirect('ot/active_operation');
		                	}
		                	elseif (isset($_POST['saveupdate'])) 
		                	{
		                		$result = $this->otModel->status_ed_op_update($id);
		                		$this->otModel->finish_operation_statusup($id);
		                		redirect('ot/completed_operation');
		                	}
		                	else
		                	{
		                		redirect('ot/index');
		                	}
		                    
		                }
		                else
		                {
		                    die('Something went wrong');
		                }
		               
		            }else{
		                //load view with errors
		                $this->view('ot/edit_operation', $data);
		            }

		        }
		        else
		        {
		        	
		        	redirect('ot/index');
		        }
		}




		public function completed_operation()
		{
			$ot = $this->otModel->get_all_ot_with_patient_name();
			$data = [ 
				'ot' => $ot,
			];
			$this->view('ot/completed_operation',$data);
		}
		public function canceled_operation()
		{
			
			$ot = $this->otModel->get_all_ot_with_patient_name();
			$data = [ 
				'ot' => $ot,
			];
			$this->view('ot/canceled_operation',$data);
		}

		public function status_cancel_update($id)
		{
			
			$result = $this->otModel->status_cancel_update($id);
			redirect('ot/current_operation');
		}


		public function record_operation()
		{
			$this->view('ot/record_operation');
		}
	
		public function op_date()
      {
          // $to = $_POST['to'];
          // $from = $_POST['from'];
          // $ord_count = $this->receptionModel->get_order_count_cus($to, $from);
          // $revenue = $this->receptionModel->get_revenue_count_cus($to, $from);
          // $discount = $this->receptionModel->get_discount_count_cus($to, $from);
          // $data = [
          //   'ord_count' => $ord_count,
          //   'rev' => $revenue,
          //   'dis' => $discount,
          //   'to_cust' => $to,
          //   'from_cust' => $from
          // ];
          // $this->view('ot/record_operation', $data);
      } 

      public function yearly_report()
      {
          $year_date = date('Y-01-01');
          $today =date('Y-m-d');
          $yr = date('Y-01-01 00:00:00');
          $yrl = date('Y-12-31 00:00:00');
          $pdata = $this->otModel->get_patient_ot_details($yr, $yrl);
          $data = [
          		    	'pdata' => $pdata
          ];  
           $this->view('ot/get_report', $data);
      }
      public function to_from_report()
      {
      	

          $year_date = date('Y-01-01');
          $today =date('Y-m-d');
          $yr = date($_POST['to'].' 00:00:00');
          $yrl = date($_POST['from'].' 00:00:00');
          $pdata = $this->otModel->get_patient_ot_details($yr, $yrl);
          $data = [
          		    	'pdata' => $pdata
          ];  
           $this->view('ot/get_report', $data);
      }

       public function monthly_report()
      {
      	

          $year_date = date('Y-01-01');
          $today =date('Y-m-d');
          $yr = date('Y-m-01 00:00:00');
          $yrl = date('Y-m-31 00:00:00');
          $pdata = $this->otModel->get_patient_ot_details($yr, $yrl);
          $data = [
          		    	'pdata' => $pdata
          ];  
           $this->view('ot/get_report', $data);
      }
       public function day_report()
      {
      	

          $year_date = date('Y-01-01');
          $today =date('Y-m-d');
          $yr = date('Y-m-d 00:00:00');
          $yrl = date('Y-m-d 00:00:00');
          $pdata = $this->otModel->get_patient_ot_details($yr, $yrl);
          $data = [
          		    	'pdata' => $pdata
          ];  
           $this->view('ot/get_report', $data);
      }


      public function print_operation_details($id)
      {
          
            $logo = $this->otModel->get_logo_details();
            $op = $this->otModel->get_patient_ot_details_byid($id);
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
				'mem_name' => $op->mem_name
            ];
          
          $this->view('ot/print_operation_details',$data);
      }

        public function view_operation_report($id)
      {
          
            $logo = $this->otModel->get_logo_details();
            $op = $this->otModel->get_patient_ot_details_byid($id);
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
				'mem_name' => $op->mem_name
            ];
          
          $this->view('ot/view_operation_report',$data);
      }

      public function getRoomName($id)
      {
      		return $name = $this->otModel->get_room_no($id);
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

              $success = $this->otModel->update_password_db($cpass, $id, $files_array);
              if($success)
                redirect('ot/success_settings');
              else
                redirect('ot/upd_err_settings');           
          }
          else
          {
              redirect('ot/error_settings');
          }

      }
       public function settings()
      {
          $user_id = $_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no'];
          $mem_data = $this->otModel->get_mem_data($user_id);
          foreach ($mem_data as $key)
          {
              $_SESSION['user_photo_medhike_87_71_18_08_80_none_med_hi_ke_no'] = $key->mem_photo;
          }
          $data = [
            'mem_data' => $mem_data 
          ];
          $this->view('ot/settings', $data);
      }

		public function teamAssign($id)
		{
			$data = [
				'doc' => $this->otModel->getAllDoctors(),
				'nur' => $this->otModel->getAllNurses(),
				'id' => $id
			];
			$this->view('ot/teamAssign', $data);
		}

		public function assignTeamToId($id)
		{
			$doc = implode(',', $_POST['doc']);
			$docRes = implode(',', $_POST['docRes']);
			$nur = implode(',', $_POST['nur']);
			$nurRes = implode(',', $_POST['nurRes']);
			$oth = implode(',', $_POST['oth']);
			$othRes = implode(',', $_POST['othRes']);

			$dR = $doc.','.$docRes;
			$nR = $nur.','.$nurRes;
			$oR = $oth.','.$othRes;
			$this->otModel->saveAssignTeam($id, $dR, $nR, $oR);
			redirect('ot/current_operation');
		}

		public function viewTeam($id)
		{
			$data = [
	            'ot' => $this->otModel->getOtDetailsById($id)
	        ];
	        $this->view('ot/viewTeam', $data);
		}
		public function addAssets()
		{
			$this->view('ot/addAssets');
		}

		public function allAssets()
		{
			$data = [ 
						'ot_assets' => $this->otModel->get_ot_assets(), 
					];
			$this->view('ot/allAssets',$data);
		}
		public function create_asset()
		{
			$data = [
						'a_name' => $_POST['asset_name'],
						'a_type' => $_POST['asset_type'],
						'a_amount' => $_POST['asset_amount'],
						'a_need' => $_POST['asset_need'],
						'a_date' => $_POST['asset_date'],
						'a_desc' => $_POST['asset_desc'],
					];
			$this->otModel->create_asset_db($data);
			redirect('ot/allAssets');
		}
		public function delete_asset($id)
		{
			$x = $this->otModel->delete_asset_db($id);
			if($x)
			{
				$_SESSION['success'] = "deleted successfully";
				redirect('ot/allAssets');	
			}
			else
			{
				$_SESSION['success'] = "try again later";
				redirect('ot/allAssets');
			}
		}
}
?>