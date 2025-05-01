<?php
class User
{
	private $db;

	public function __construct()
	{
		$this->db = new Database;
	}

	public function get_email($username)
	{
		$this->db->query('SELECT * FROM users WHERE mem_email = :username');
		$this->db->bind(':username', $username);
		$row = $this->db->resultSet();
		if($this->db->execute())
		{
        	return $row;
      	} 
      	else
      	{
        	return false;
      	}

	}

	public function patient_login_check($username, $password)
	{
		$this->db->query('SELECT * FROM patients WHERE patient_phone = :username');
		$this->db->bind(':username',$username);
		$row = $this->db->resultSet();

		foreach ($row as $test)
              {
                 
                  $_SESSION['id_patient'] = $test->patient_id;
                   $_SESSION['user_name'] = $test->patient_name;
                  $_SESSION['pat_photo'] = $test->patient_photo;
              }
		if($this->db->rowCount())
		{
			foreach ($row as $key)
			{
				$pass = $key->patient_phone;
				$password_db = $key->password;
				 $_SESSION['user_name'] = $key->patient_name;
			}
			if(empty($password))
			{
					if($pass == $password)
					{
						return $row;
					}
					else
					{
						return 2;
					}
			}
			else
			{
				if(password_verify($password, $password_db))
				{
					return $row;
				}
				else
				{
					return 2;
				}
			}
		}
		else
		{
			return 0;
		}
	}

	public function checkCredentials($data)
	{
		$this->db->query('SELECT * FROM users WHERE mem_email = :email');
		$this->db->bind(':email', $data['mhUserId']);
		$row = $this->db->single();

		if($this->db->rowCount() > 0)
		{
			if(password_verify($data['mhPass'], $row->mem_pass))
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}

	public function getAdminCredentials($email)
	{
		$servername = DB_HOST;
		$username = DB_USER;
		$password = DB_PASS;
		$dbname = DB_NAME;

		// Create connection
		$conn = mysqli_connect($servername, $username, $password, $dbname);
		// Check connection
		if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
		}
		$sql2 = "SELECT * FROM users WHERE mem_email = '$email'";
		$result = mysqli_query($conn, $sql2);
		return $row = mysqli_fetch_assoc($result);
	}
}
?>