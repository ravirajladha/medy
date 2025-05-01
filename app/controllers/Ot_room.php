<?php
  class Ot_room extends Controller
  {
		public function __construct()
		{
		
		$this->otModel = $this->model('Ots_room');

		}

		public function index()
		{
			

			$data = [ 
				'req' => 0,
				'active' => 0,
				'completed' => 0,
				'canceled' => 0
			];
			$this->view('ot_room/index',$data);
		}

		public function create_rooms()
		{

			if($_SERVER['REQUEST_METHOD'] == 'POST')
		        {
		            //Sanitize post array
		            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

		            $data = [
		            		'room_no' => $_POST['room_no'],
		                    'room_type'      => $_POST['room_type'],
		                    'floor_no'     => $_POST['floor_no'],
		                    'building_no'     => $_POST['building_no'],
		                    'address'  => $_POST['address'],
		                    'room_no_err'    => ''
		            ];
		  			
		            //validate title
		            if(empty($data['room_no']))
		            {
		                $data['room_no_err'] = 'Please enter Room no';
		            }
	           	  
		            //check if errors are present
		            if(empty($data['room_no_err']) )
		            {

		                //validated
		                if($this->otModel->add_room($data))
		                {
		                    //flash('post_message', 'Post Added');
		                	redirect('ot_room/allocated_rooms');
		                }
		                else
		                {
		                    die('Something went wrong');
		                }
		               
		            }else{
		                //load view with errors
		                $this->view('ot_room/create_rooms',$data);
		            }

		        }
		        else
		        {
					$this->view('ot_room/create_rooms');
				}
			
		}

		public function available_rooms()
		{
			$av = $this->otModel->get_available_rooms();

			$data = [ 
				'ot' => $av,
			];
			$this->view('ot_room/available_rooms',$data);
		}
		
		public function allocated_rooms()
		{
			$av = $this->otModel->get_available_rooms();

			$data = [ 
				'ot' => $av,
			];
			$this->view('ot_room/allocated_rooms',$data);
		}
		public function canceled_rooms()
		{
			$av = $this->otModel->get_available_rooms();

			$data = [ 
				'ot' => $av,
			];
			$this->view('ot_room/canceled_rooms',$data);
		}	

		public function status_cancel($id)
		{
			$av = $this->otModel->status_cancel_for_room($id);
			redirect('ot_room/canceled_rooms');
		}	
		public function status_cancel_restore($id)
		{
			$av = $this->otModel->status_cancel_restore_for_rooms($id);
			redirect('ot_room/available_rooms');
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
                redirect('ot_room/success_settings');
              else
                redirect('ot_room/upd_err_settings');           
          }
          else
          {
              redirect('ot_room/error_settings');
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
          $this->view('ot_room/settings', $data);
      }	

      public function create_bed()
      {
      	  $this->view('ot_room/create_bed');
      }

      public function getRooms()
      {
      		$roomNo = $_POST['query3'];
      		$room = $this->otModel->getRooms($roomNo);
      		$output = '';
      		$output = '<ul class="list-unstyled">';
			foreach ($room as $key)
			{
				$output .='<li class="ee1" value="'.$key->room_no.'">'.$key->room_no.'</li>';
			}
			$output.='</ul>';
			echo $output;
      }

      public function createBed()
      {
      		$bedID = $_POST['bedID'];
      		$roomNo = $_POST['roomNo'];
      		$this->otModel->createBedDb($bedID, $roomNo);
      		redirect('ot_room/create_bed');
      }

      public function allocated_bed()
      {
      		$av = $this->otModel->get_available_beds();
			$data = [ 
				'ot' => $av,
			];
      		$this->view('ot_room/allocated_bed',$data);
      }

		public function bookings()
		{
			$this->view('ot_room/bookings');
		} 

		public function bookRoom()
		{
			$roomNumber = $_POST['roomNumber'];
			$bedId = $_POST['bedId'];
			$fromDate = $_POST['fromDate'];
			$toDate = $_POST['toDate'];

			if($this->otModel->bookRoomDb($roomNumber, $bedId, $fromDate, $toDate))
			{
				redirect('ot_room/allBookings');
			}
		} 

		public function allBookings()
		{
			$data = [
				'booking' => $this->otModel->getAllRoomBooking(),
			];
			$this->view('ot_room/allBookings', $data);
		}

		public function cancelBooking($id)
		{
			if($this->otModel->cancelBooking($id))
			{
				redirect('ot_room/allBookings');
			}
		}

		public function getTheRoomId()
		{
			$id = $_POST['id'];
			$row = $this->otModel->getTheBeds($id);
			$output = '';
			foreach ($row as $key)
			{
				$output .= '<option>'.$key->bed_number.'</option>';
			}
			echo $output;
		}

}
?>