<?php
class Lab
{
	private $db;

	public function __construct()
	{
		$this->db = new Database;
	}

	public function get_all_test_names()
	{
		$this->db->query('SELECT * FROM lab_test_values');
		$row = $this->db->resultSet();
		return $row;
	}

	public function lab_test_type()
	{
		$this->db->query('SELECT * FROM lab_test_types');
		$row = $this->db->resultSet();
		return $row;
	}

	public function get_invoices($id)
	{
		$this->db->query('SELECT * FROM invoices WHERE invoice_id = :id');
		$this->db->bind(':id',$id);
		$row = $this->db->resultSet();
		return $row;
	}

	public function lab_test_type_ajax($search_val)
	{
		$this->db->query("SELECT * FROM lab_test_values WHERE lab_test_name LIKE concat('%', :search_val, '%') OR lab_test_name LIKE concat('%', :search_val, '%') LIMIT 8");
		$this->db->bind(':search_val',$search_val);
		$row = $this->db->resultSet();
		return $row;
	}

	public function get_test_value_1($lab_test_type_idl)
	{
		$this->db->query("SELECT * FROM lab_test_values WHERE lab_test_type='$lab_test_type_idl' AND lab_test_active='1'");
		$this->db->bind(':lab_test_type_idl',$lab_test_type_idl);
		$row = $this->db->resultSet();
		return $row;
	}

	public function update_test_val($grtest)
	{
		$this->db->query("UPDATE lab_test_values SET lab_test_active='1' WHERE lab_test_value_id=:grtest");
		$this->db->bind(':grtest',$grtest);
		if($this->db->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
	}

	public function get_test_value($grtest)
	{
		$this->db->query("SELECT * FROM lab_test_values WHERE lab_test_value_id=:grtest");
		$this->db->bind(':grtest',$grtest);
		$row = $this->db->resultSet();
		return $row;
	}

	public function get_all_services($lab_test_name)
	{
		$this->db->query("SELECT * FROM services WHERE service_name=:lab_test_name");
		$this->db->bind(':lab_test_name',$lab_test_name);
		$row = $this->db->resultSet();
		return $row;
	}

	public function insert_test($lab_test_name)
	{
		$this->db->query("INSERT INTO services (service_name,service_type,service_cost) VALUES (':lab_test_name','Lab Testing','0')");
		$this->db->bind(':lab_test_name',$lab_test_name);
		if($this->db->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
	}

	public function update_ref_id($service_id,$grtest)
	{
		$this->db->query("UPDATE lab_test_values SET service_ref_id=:service_id WHERE lab_test_value_id=:grtest");
		$this->db->bind(':service_id', $service_id);
		$this->db->bind(':grtest',$grtest);
		if($this->db->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
	}


	public function update_serv_id($service_ref_id)
	{
		$this->db->query("UPDATE services SET service_active='1' WHERE service_id=:service_ref_id");
		$this->db->bind(':service_ref_id',$service_ref_id);
		if($this->db->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
	}

	public function insert_test_details($test_name,$test_type,$test_instruction,$test_procedure,$test_equipments,$test_value,$today_date)
	{
		$this->db->query("INSERT INTO lab_test_values (lab_test_name,lab_test_type,lab_test_instruction,lab_test_procedure,lab_test_equipments,lab_test_values,lab_test_date_time) VALUES (:test_name,:test_type,:test_instruction,:test_procedure,:test_equipments,:test_value,:today_date)");
		$this->db->bind(':test_name',$test_name);
		$this->db->bind(':test_type',$test_type);
		$this->db->bind(':test_instruction',$test_instruction);
		$this->db->bind(':test_procedure',$test_procedure);
		$this->db->bind(':test_equipments',$test_equipments);
		$this->db->bind(':test_value',$test_value);
		$this->db->bind(':today_date',$today_date);
		if($this->db->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
	}

	public function save_lab_test($all_data,$test_id,$order_id_lab,$test_status)
	{
		$this->db->query('UPDATE lab_tests SET lab_test_values = :all_data, lab_test_status = :test_status, done_by = :done_by WHERE lab_test_ref_id = :test_id AND lab_test_order_id = :order_id_lab');
		$this->db->bind(':test_id',$test_id);
		$this->db->bind(':order_id_lab',$order_id_lab);
		$this->db->bind(':all_data',$all_data);
		$this->db->bind(':test_status',$test_status);
		$this->db->bind(':done_by',$_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
		if($this->db->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
	}

	public function get_data_after_update_db($upd_ord_val,$upd_test_val)
	{
		$this->db->query('SELECT * FROM lab_tests WHERE lab_test_ref_id = :upd_test_val AND lab_test_order_id = :upd_ord_val ORDER BY lab_test_id DESC LIMIT 1');
		$this->db->bind(':upd_ord_val',$upd_ord_val);
		$this->db->bind(':upd_test_val',$upd_test_val);
		$row = $this->db->resultSet();
		return $row;
	}

	public function save_available_test_db($id,$cost)
	{
		$this->db->query('SELECT * FROM lab_tests_available WHERE test_id = :id');
		$this->db->bind(':id', $id);
		$this->db->resultSet();
		if($this->db->rowCount() > 0)
		{
			return 5;
		}
		else
		{
			$this->db->query('INSERT INTO lab_tests_available (test_id,test_cost) VALUES(:id,:cost)');
			$this->db->bind(':id',$id);
			$this->db->bind(':cost',$cost);
			if($this->db->execute())
	        {
	            return 1;
	        }
	        else
	        {
	            return 0;
	        }
		}
		
	}

	public function get_available_tests_db()
	{
		$this->db->query('SELECT lab_tests_available.test_id,lab_tests_available.serial_id,lab_tests_available.test_cost,lab_test_values.lab_test_name,lab_test_values.lab_test_values,lab_test_values.lab_test_date_time FROM lab_tests_available INNER JOIN lab_test_values on lab_tests_available.test_id = lab_test_values.lab_test_value_id');
		$row  = $this->db->resultSet();
		return $row;
	}

	public function get_available_tests_db_auto($val)
	{
		$this->db->query('SELECT lab_tests_available.test_id,lab_tests_available.test_cost,lab_test_values.lab_test_name,lab_test_values.lab_test_values,lab_test_values.lab_test_date_time FROM lab_tests_available INNER JOIN lab_test_values on lab_test_values.lab_test_name LIKE concat("%", :val, "%") AND lab_tests_available.test_id = lab_test_values.lab_test_value_id');
		$this->db->bind(':val',$val);
		$row  = $this->db->resultSet();
		return $row;
	}

	// public function update_test_data($test_status,$all_data,$i_id,$t_id)
	// {
	// 	$this->db->query('INSERT INTO lab_tests ');
	// }

	public function cancel_invoice($id)
	{
		$this->db->query('UPDATE invoices SET cancelled = 1 WHERE invoice_id = :id');
		$this->db->bind(':id', $id);
		if($this->db->execute())
		{
			return true;
		}
		else
		{
			return false;
		}

	}

	public function bulk_add_to_group_db($ids, $costs)
	{
		for ($o=0; $o < sizeof($ids); $o++)
		{ 
			$res_id = $ids[$o];
			$res_cos = $costs[$o];
			$this->db->query('SELECT * FROM lab_tests_available WHERE test_id = :res_id');
			$this->db->bind(':res_id', $res_id);
			$this->db->resultSet();
			if($this->db->rowCount() > 0)
			{
				return 5;
			}
			else
			{
				$this->db->query('INSERT INTO lab_tests_available (test_id,test_cost) VALUES(:res_id,:res_cos)');
				$this->db->bind(':res_id',$res_id);
				$this->db->bind(':res_cos',$res_cos);
				$this->db->execute();
			}			
		}
		return 1;
	}

	public function update_new_group_db($t_ids)
	{
		$this->db->query('SELECT serial_id FROM lab_tests_available');
		$s_ids = $this->db->resultSet();
		$ids_arr = [];
		$i = 0;
		foreach ($s_ids as $key)
		{
			$ids_arr[$i] = $key->serial_id;
			$i++;
		}
		$result=array_diff($ids_arr,$t_ids);

		for ($i=0; $i < sizeof($ids_arr); $i++)
		{ 
			if(isset($result[$i]))
			{
				$s_id = $result[$i];
				$this->db->query('DELETE FROM lab_tests_available WHERE serial_id = :s_id');
				$this->db->bind(':s_id', $s_id);
				$this->db->execute();
			}
		}
		return true;
	}

	public function delete_all_tests_db()
	{
		$this->db->query('DELETE FROM lab_tests_available');
		if($this->db->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function get_lab_test_available_for_id($test_id)
	{
		$this->db->query('SELECT * FROM lab_tests_available WHERE test_id = :test_id');
		$this->db->bind(':test_id', $test_id);
		$this->db->resultSet();
		$count = $this->db->rowCount();
		if($count > 0)
		{
			return 0;
		}
		else
		{
			return 1;
		}
	}

	public function getAllTestTypes()
	{
		$this->db->query('SELECT * FROM lab_test_types');
		return $row = $this->db->resultSet();
	}

	public function get_mem_data($user_id)
    {
        $this->db->query('SELECT * FROM users WHERE mem_id = :user_id');
        $this->db->bind(':user_id', $user_id);
        $row = $this->db->resultSet();
        return $row;
    }
     public function update_password_db($cpass, $id, $photo)
    {
        $this->db->query('UPDATE users SET mem_pass = :cpass, mem_photo = :photo WHERE mem_id = :id');
        $this->db->bind(':cpass', $cpass);
        $this->db->bind(':id', $id);
        $this->db->bind(':photo', $photo);
        $this->db->execute();
        return true;
    }
    public function doc_upload_jq_db($files_array)
    {
        $rep_date = date('Y-m-d');
        $this->db->query('INSERT INTO reports ( report_file_name, report_date) VALUES(:files_array, :rep_date)');
        $this->db->bind(':rep_date', $rep_date);
        $this->db->bind(':files_array', $files_array);
        if($this->db->execute())
        {
            $_SESSION['file_name_upload'] = $files_array;
            return true;
        }
        else
        {
            return false;
        }
    }

    public function save_other_upload_details_db($ip_id, $rep_tit)
    {
        // $_SESSION['s']=$ip_id;
        // $ipd_rep = explode('(', $ip_id);
        // $ipd_rep = explode(')', $ipd_rep[1]);
        // $ipd_rep = trim($ipd_rep[0]);
         $ipd_rep = $ip_id;
        $file_name = $_SESSION['file_name_upload'];
        unset($_SESSION['file_name_upload']);
        $this->db->query('UPDATE reports SET report_title = :rep_tit, patient_id = :ipd_rep WHERE report_file_name = :file_name');
        $this->db->bind(':rep_tit', $rep_tit);
        $this->db->bind(':ipd_rep', $ipd_rep);
        $this->db->bind(':file_name', $file_name);
        if($this->db->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }
     public function delete_xray_db($s_id)
    {
        $this->db->query('DELETE FROM reports WHERE report_id=:s_id');
        $this->db->bind(':s_id',$s_id);
        if($this->db->execute())
            return true;
        else
            return false;
    }
     public function get_all_report($lim,$off)
    {
        $this->db->query('SELECT * FROM reports ORDER BY report_id DESC limit :lim OFFSET :off');
        $this->db->bind(':lim',$lim);
        $this->db->bind(':off',$off);
        $row = $this->db->resultSet();
        return $row;
    }
     public function get_search_xray($inv_id)
    {
        $this->db->query('SELECT * FROM reports WHERE patient_id=:inv_id');
        $this->db->bind(':inv_id',$inv_id);
        $row = $this->db->resultSet();
        return $row;
    }
    public function auto_patient_name2($cust)
    {
        $this->db->query("SELECT DISTINCT * from patients WHERE patient_name LIKE concat('%', :cust, '%') OR patient_id LIKE concat('%', :cust, '%') OR patient_phone LIKE concat('%', :cust, '%') LIMIT 6");
        $this->db->bind(':cust',$cust);
        $row = $this->db->resultSet();
        return $row;
    }

    public function saveAllDocumentsLabOrder($id, $allFilesName, $tid)
    {
    	$allFiles = implode(',', $allFilesName);
    	$this->db->query('UPDATE lab_tests SET lab_test_document = :allFiles WHERE lab_test_order_id = :id 	AND lab_test_ref_id = :tid');
    	$this->db->bind(':allFiles', $allFiles);
    	$this->db->bind(':id', $id);
    	$this->db->bind(':tid', $tid);
    	if($this->db->execute())
    	{
    		return true;
    	}
    	else
    	{
    		die('Error');
    	}
    }

    public function getLabTestData($id)
    {
    	$this->db->query('SELECT * FROM lab_tests WHERE lab_test_order_id = :id');
    	$this->db->bind(':id', $id);
    	return $row = $this->db->resultSet();
    }
}
?>