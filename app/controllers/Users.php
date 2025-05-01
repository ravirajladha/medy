<?php
  class Users extends Controller
  {
      public function __construct()
      {
        $this->userModel = $this->model('User');
      }

      public function index()
      {
      	// header('Location: '.URLMAIN.'/pages/unsetAllCookies');
		  $this->view('users/login');
      }

      public function login()
      {
		$this->view('users/login');
        // header('Location: '.URLMAIN.'/pages/unsetAllCookies');
      }

      public function login1()
      {
      	$username = $_POST['username'];
      	$password = $_POST['password'];
        $success = $this->userModel->get_email($username);
        $data = [
          'email_err' =>'',
          'pass_err' =>''
        ];
        if($success)
        {
          foreach ($success as $key)
          {
              $mem_id = $key->mem_id;
              $mem_name = $key->mem_name;
              $mem_type = $key->mem_type;
              $mem_phone = $key->mem_phone;
              $mem_email = $key->mem_email;
              $mem_pass = $key->mem_pass;
			  $mem_photo = $key->mem_photo;
			  $mh_id = $key->mh_id;
          }
          if (password_verify($password, $mem_pass))
          {
			$_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no'] = $mem_id;
			$_SESSION['user_name'] = $mem_name;
			$_SESSION['type'] = $mem_type;
			$_SESSION['user_photo_medhike_87_71_18_08_80_none_med_hi_ke_no'] = $mem_photo;

			$user_id = "user_id_medhike_87_71_18_08_80_none_med_hi_ke_no";
			$mh_id = "mh_id_medhike_87_71_18_08_80_none_med_hi_ke_no";
			$user_name = "user_name";
			$type = "type";
			$email = "email";
			$photo = "user_photo_medhike_87_71_18_08_80_none_med_hi_ke_no";
			$v = "dd";

			setcookie($user_id, $mem_id, time() + (86400 * 30), "/");
			setcookie($mh_id, $mem_id, time() + (86400 * 30), "/");
			setcookie($user_name, $mem_name + (86400 * 30), "/");
			setcookie($type, $mem_type + (86400 * 30), "/");
			setcookie($email, $mem_email, + (86400 * 30), "/");
			setcookie($photo, $v, "/");
			if($mem_type == 'rec')
			{
			redirect('receptions/index');
			}
			if($mem_type == 'doc')
			{
			redirect('doctors/index');
			}
			if($mem_type == 'lab')
			{
			redirect('labs/index');
			}
          }

          else
          {
            $data = [
            'pass_err' => "Password Error"
          ];
          $this->view('users/login', $data);
          }
        }
        else
        {
          $data = [
            'email_err' => "email does'nt exists"
          ];
          $this->view('users/login', $data);
        }
        $this->view('users/login');
    }


	public function logout()
	{
		unset($_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
		unset($_SESSION['user_photo_medhike_87_71_18_08_80_none_med_hi_ke_no']);
		unset($_SESSION['user_name']);
		unset($_SESSION['type']);
		setcookie("user_id_medhike_87_71_18_08_80_none_med_hi_ke_no", "", time()-3600);
		redirect('users/login');
	}

      public function patient_login()
      {
          $this->view('patients/login');
      }


		public function primaryMedhikeLogin()
		{
			$data = [
				'mhUserId' 	=> $_POST['userId'],
				'mhPass' 	=> $_POST['password']
			];
			if($this->userModel->checkCredentials($data))
			{
				$admin = $this->userModel->getAdminCredentials($data['mhUserId']);
				$_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no'] = $admin['mem_id'];
				$mh_id = "mh_id_medhike_87_71_18_08_80_none_med_hi_ke_no";
				if($admin['mem_type'] == 'admin')
				{
					$_SESSION['mh_id_medhike_87_71_18_08_80_none_med_hi_ke_no'] = $admin['mem_id'];
					// setcookie($mh_id, $admin['mem_id'], time() + (86400 * 30), "/");
				}
				else
				{
					$_SESSION['mh_id_medhike_87_71_18_08_80_none_med_hi_ke_no'] = $admin['mh_id'];
					// setcookie($mh_id, $admin['mh_id'], time() + (86400 * 30), "/");
				}
				$_SESSION['user_name'] = $admin['mem_name'];
				$_SESSION['type'] = $admin['mem_type'];
				$_SESSION['email'] = $admin['mem_email'];
				$_SESSION['user_photo_medhike_87_71_18_08_80_none_med_hi_ke_no'] = $admin['mem_photo'];
				$_SESSION['user_single'] = $admin;
				$_SESSION['user_type'] = $admin['type'];
				// creating cookies
				$user_id = "user_id_medhike_87_71_18_08_80_none_med_hi_ke_no";
				$user_name = "user_name";
				$type = "type";
				$email = "email";
				$photo = "user_photo_medhike_87_71_18_08_80_none_med_hi_ke_no";
				$v = $admin['mem_photo'];
	
				// setcookie($user_id, $admin['mem_id'], time() + (86400 * 30), "/");
				// setcookie($mh_id, $admin['mem_id'], time() + (86400 * 30), "/");
				// setcookie($user_name, $admin['mem_name'], time() + (86400 * 30), "/");
				// setcookie($type, $admin['mem_type'], time() + (86400 * 30), "/");
				// setcookie($email, $admin['mem_email'], time() + (86400 * 30), "/");
				// setcookie($photo, $v, time() + (86400 * 30), "/");
				// echo $admin->mem_type;
				echo json_encode(array("type" => $admin['mem_type'], "plan" => $admin['plan']));
			}
			else
			{
				echo json_encode(array("type" => 0));
			}
		}

      // public function primary_login()
      // {
      //     $medhike_id = $_POST['medhike_id'];
      //     $con = mysqli_connect("localhost","root","","primary_medhike");
      //     $sql = mysqli_query($con, 'SELECT * FROM auth WHERE proj_id = $medhike_id');
      //     if($sql->num_rows > 0)
      //     {
      //         $row = $sql->fetch_assoc();
      //     }
      //      var_dump($row);
      // }

  }
  ?>