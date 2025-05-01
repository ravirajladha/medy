<?php
class Reception
{
	private $db;

	public function __construct()
	{
		$this->db = new Database;
	}

	public function auto_complete($name)
    {
		$this->db->query("SELECT DISTINCT * from services WHERE service_id LIKE concat('%', :name, '%') OR service_name LIKE concat('%', :name, '%') LIMIT 4");
		$this->db->bind(':name',$name);
		$row = $this->db->resultSet();
		return $row;
    }

    public function auto_complete_lab($name)
    {
        $this->db->query("SELECT DISTINCT * from lab_test_values WHERE lab_test_value_id LIKE concat('%', :name, '%') OR lab_test_name LIKE concat('%', :name, '%') LIMIT 4");
        $this->db->bind(':name',$name);
        $row = $this->db->resultSet();
        return $row;
    }

    public function auto_patient_name2($cust)
    {
        $this->db->query("SELECT DISTINCT * from patients WHERE mh_id = :mh_id AND (patient_name LIKE concat('%', :cust, '%') OR patient_id LIKE concat('%', :cust, '%') OR patient_phone LIKE concat('%', :cust, '%')) LIMIT 6");
        $this->db->bind(':cust',$cust);
        $this->db->bind(':mh_id', $_SESSION['mh_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
        $row = $this->db->resultSet();
        return $row;
    }

    public function value_of_amt($aamt)
    {
		$this->db->query('SELECT service_cost FROM services WHERE service_id = :aamt');
		$this->db->bind(':aamt',$aamt);
		$row = $this->db->single();
		return $row;
    }

    public function get_all_orders($lim,$off)
    {
    	$this->db->query('SELECT * FROM invoices WHERE mh_id = :mh_id ORDER BY invoice_id DESC limit :lim OFFSET :off');
    	$this->db->bind(':lim',$lim);
        $this->db->bind(':off',$off);
        $this->db->bind(':mh_id', $_SESSION['mh_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
    	$row = $this->db->resultSet();
    	return $row;
    }

    public function get_all_orders_pat($lim,$off)
    {
        $name = $_SESSION['user_name'];
        $id = $_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no'];
        $in_name = $name."|".$id;
        $in_name2 = $name." | ".$id;
        $this->db->query('SELECT * FROM invoices WHERE invoice_name = :in_name OR invoice_name = :in_name2 ORDER BY invoice_id DESC limit :lim OFFSET :off');
        $this->db->bind(':lim',$lim);
        $this->db->bind(':off',$off);
        $this->db->bind(':in_name2', $in_name2);
        $this->db->bind(':in_name', $in_name);
        $row = $this->db->resultSet();
        return $row;
    }

    public function get_all_orders_active($lim,$off)
    {
        $this->db->query('SELECT * FROM invoices WHERE mh_id = :mh_id AND invoice_status = "saved" ORDER BY invoice_id DESC limit :lim OFFSET :off');
        $this->db->bind(':mh_id', $_SESSION['mh_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
        $this->db->bind(':lim',$lim);
        $this->db->bind(':off',$off);
        $row = $this->db->resultSet();
        return $row;
    }
    public function checkinvoiceopid($id)
    {
        $this->db->query('SELECT * FROM invoices WHERE opip_id = :id');
        $this->db->bind(':id',$id);
        $row = $this->db->single();
        return $row;
    }

    public function get_all_orders_lab($lim,$off)
    {
        $this->db->query('SELECT * FROM invoices WHERE department=1 ORDER BY invoice_id DESC limit :lim OFFSET :off');
        $this->db->bind(':lim',$lim);
        $this->db->bind(':off',$off);
        $row = $this->db->resultSet();
        return $row;
    }

    public function get_search_orders($inv_id)
    {
    	$this->db->query('SELECT * FROM invoices WHERE invoice_id=:inv_id AND mh_id = :mh_id');
        $this->db->bind(':inv_id',$inv_id);
        $this->db->bind(':mh_id', $_SESSION['mh_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
    	$row = $this->db->resultSet();
    	return $row;
    }

    public function get_patient_orders($patient_name)
    {
        $this->db->query("SELECT * FROM invoices WHERE mh_id = :mh_id AND (invoice_name LIKE concat('%', :patient_name, '%') OR invoice_phone LIKE concat('%', :patient_name, '%')) ORDER BY invoice_id DESC LIMIT 5 ");
        $this->db->bind(':mh_id', $_SESSION['mh_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
    	$this->db->bind(':patient_name',$patient_name);
    	$row = $this->db->resultSet();
    	return $row;
    }
    
    public function get_doctorName_appointments($doctor_name)
    {
        $this->db->query("SELECT * FROM appointments WHERE doctor_name LIKE concat('%', :doctor_name, '%') ORDER BY a_id DESC");
        
    	$this->db->bind(':doctor_name',$doctor_name);
    	$row = $this->db->resultSet();
    	return $row;
    }

 // $this->db->query('SELECT * FROM invoices WHERE invoice_id=:inv_id_edit');
        // $this->db->bind(':inv_id_edit',$inv_id_edit);
        // $row = $this->db->resultSet();

        // foreach ($row as $key)
        // {
        //     $in_status = $key->invoice_status;
        // }
        // $status_arr = explode(',', $in_status);

        // if($status_arr[1]==0)
        // {
        //     $status_arr[1]=1;
        // }
        // else
        // {
        // }
        // if($status_arr[0]=='submit_and_print')
        // {
        //     $status_arr[2]=1;
        // }
        // else
        // {
        // }
        // $status_arr = implode(',', $status_arr);    // this code is part of update_invoice_db section
     public function getinvoicedepdata($inv_id_edit)
    {
    
        $this->db->query("SELECT * FROM invoices WHERE invoice_id = :inv_id_edit");
        $this->db->bind(':inv_id_edit', $inv_id_edit);
        $row = $this->db->single();
        return $row;
    }

    public function update_invoice_db_edit($data)
    {   
        
        $dateAndTime = date('Y/m/d H:i:s');
        $this->db->query('UPDATE invoices SET invoice_item=:service_id, invoice_bill=:invoice_bill, invoice_name=:patient_name, invoice_doctor=:doctor_name, invoice_pay=:pay_mode, invoice_total=:grand_total, invoice_date=:dateAndTime, invoice_status=:status, opip_id=:ipopid, department=:dep, invoice_discount = :dist, authorized_by = :authorized_by, invoice_tax = :taxx, amount_paid = :amount_paid, advance_pay = :advance_pay WHERE invoice_id=:inv_id_edit');

        $this->db->bind(':inv_id_edit',$data['inv_id_edit']);
        $this->db->bind(':service_id',$data['service_id']);
        $this->db->bind(':invoice_bill',$data['invoice_bill']);
        $this->db->bind(':patient_name',$data['patient_name']);
        $this->db->bind(':doctor_name',$data['doctor_name']);
        $this->db->bind(':pay_mode',$data['pay_mode']);
        $this->db->bind(':grand_total',$data['grand_total']);
        $this->db->bind(':dateAndTime',$dateAndTime);
        $this->db->bind(':status',$data['status']);
        $this->db->bind(':ipopid',$data['ipopid']);
        $this->db->bind(':dep',$data['dep']);
        $this->db->bind(':taxx', $data['taxx']);
        $this->db->bind(':dist', $data['dist']);
        $this->db->bind(':amount_paid', $data['amount_paid']);
        $this->db->bind(':advance_pay', $data['advance_pay']);
        $this->db->bind(':authorized_by', $data['authorized_by']);
          
        if($this->db->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function update_invoice_db_edit2($data)
    {   
        
        $dateAndTime = date('Y/m/d H:i:s');
        $this->db->query('UPDATE invoices SET invoice_item=:service_id, invoice_bill=:invoice_bill, invoice_name=:patient_name, invoice_doctor=:doctor_name, invoice_pay=:pay_mode, invoice_total=:grand_total, invoice_date=:dateAndTime, invoice_status=:status, opip_id=:ipopid, department=:dep, invoice_discount = :dist, authorized_by = :authorized_by, invoice_tax = :taxx, visit_order_done ="data comming from dep1 and update", amount_paid = :amount_paid, advance_pay = :advance_pay WHERE invoice_id=:inv_id_edit');
        $this->db->bind(':inv_id_edit',$data['inv_id_edit']);
        $this->db->bind(':service_id',$data['service_id']);
        $this->db->bind(':invoice_bill',$data['invoice_bill']);
        $this->db->bind(':patient_name',$data['patient_name']);
        $this->db->bind(':doctor_name',$data['doctor_name']);
        $this->db->bind(':pay_mode',$data['pay_mode']);
        $this->db->bind(':grand_total',$data['grand_total']);
        $this->db->bind(':dateAndTime',$dateAndTime);
        $this->db->bind(':status',$data['status']);
        $this->db->bind(':ipopid',$data['ipopid']);
        $this->db->bind(':dep',1);
        $this->db->bind(':taxx', $data['taxx']);
        $this->db->bind(':dist', $data['dist']);
        $this->db->bind(':amount_paid', $data['amount_paid']);
        $this->db->bind(':advance_pay', $data['advance_pay']);
        $this->db->bind(':authorized_by', $data['authorized_by']);
        
        if($this->db->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    public function save_invoice_db($service_id,$invoice_bill,$grand_total,$patient_name,$doctor_name,$ipopid,$pay_mode,$amount_paid,$status,$dep,$taxx,$dist,$patient_phone,$advance_pay,$authorized_by)
    {
        $a='';
        $a = substr($ipopid, 0,2);

        $dateAndTime = date('Y/m/d H:i:s');
        $this->db->query('INSERT into invoices (invoice_item,invoice_bill,invoice_name,invoice_doctor,invoice_pay,invoice_total,invoice_date,invoice_status,opip_id,department,visit_order_done,invoice_discount,authorized_by,invoice_tax,amount_paid,advance_pay,created_by,invoice_phone,mh_id) VALUES (:service_id,:invoice_bill,:patient_name,:doctor_name,:pay_mode,:grand_total,:dateAndTime,:status,:ipopid,:dep,:ipip,:dist,:authorized_by,:taxx,:amount_paid,:advance_pay,:created_by,:patient_phone,:mh_id)');
        $this->db->bind(':service_id',$service_id);
        $this->db->bind('invoice_bill',$invoice_bill);
        $this->db->bind(':patient_name',$patient_name);
        $this->db->bind(':doctor_name',$doctor_name);
        $this->db->bind(':pay_mode',$pay_mode);
        $this->db->bind(':grand_total',$grand_total);
        $this->db->bind(':dateAndTime',$dateAndTime);
        $this->db->bind(':status',$status);
        $this->db->bind(':ipopid',$ipopid);
        $this->db->bind(':dep',$dep);
        $this->db->bind(':taxx', $taxx);
        $this->db->bind(':dist', $dist);
        $this->db->bind(':amount_paid', $amount_paid);
        $this->db->bind(':advance_pay', $advance_pay);
        $this->db->bind(':authorized_by', $authorized_by);
        $this->db->bind(':ipip',$a);
        $this->db->bind(':created_by', $_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
        $this->db->bind(':mh_id', $_SESSION['mh_id_medhike_87_71_18_08_80_none_med_hi_ke_no']); 
        $this->db->bind(':patient_phone', $patient_phone);
        if($this->db->execute())
        {
            if($dep == 1)
            {
                $service_id = explode(',', $service_id);
                $this->db->query('SELECT invoice_id FROM invoices WHERE department = 1 ORDER BY invoice_id DESC LIMIT 1');
                $row = $this->db->resultSet();
                foreach ($row as $key_1)
                {
                    $lab_test_order_id = $key_1->invoice_id;
                }
                $count = count($service_id);
                $count = trim($count);
                $count = (int)$count;
                $count = $count - 1;
                for ($i=0; $i < $count/4 ; $i++)
                {
                    $service_id_id = $service_id[$i*4];
                    $this->db->query('INSERT INTO lab_tests (lab_test_ref_id, lab_test_order_id, lab_test_date_time) VALUES (:service_id_id, :lab_test_order_id, :dateAndTime)');
                    $this->db->bind(':service_id_id',$service_id_id);
                    $this->db->bind(':lab_test_order_id',$lab_test_order_id);
                    $this->db->bind(':dateAndTime',$dateAndTime);
                    $qwerty = $this->db->execute();
                }
                if($qwerty)
                    return true;
                else
                    return false;
            }
            else
            {
                return true;
            }
        }
        else
        {
            return false;
        }
    }
    public function save_invoice_db2($service_id,$invoice_bill,$grand_total,$patient_name,$doctor_name,$ipopid,$pay_mode,$amount_paid,$status,$dep,$taxx,$dist)
    {
       
        $a='';
        $z = explode('|', $patient_name);
        $a = $z[1];
        $dateAndTime = date('Y/m/d H:i:s');

        $this->db->query('INSERT into invoices (invoice_item,invoice_bill,invoice_name,invoice_doctor,invoice_pay,invoice_total,invoice_date,invoice_status,opip_id,department,visit_order_done,invoice_discount,invoice_tax) VALUES (:service_id,:invoice_bill,:patient_name,:doctor_name,:pay_mode,:grand_total,:dateAndTime,:status,:ipopid,:dep,:ipip,:dist,:taxx)');
        $this->db->bind(':service_id',$service_id);
        $this->db->bind('invoice_bill',$invoice_bill);
        $this->db->bind(':patient_name',$patient_name);
        $this->db->bind(':doctor_name',$doctor_name);
        $this->db->bind(':pay_mode',$pay_mode);
        $this->db->bind(':grand_total',$grand_total);
        $this->db->bind(':dateAndTime',$dateAndTime);
        $this->db->bind(':status',$status);
        $this->db->bind(':ipopid',$ipopid);
        $this->db->bind(':dep',$dep);
        $this->db->bind(':taxx', $taxx);
        $this->db->bind(':dist', $dist);
         $this->db->bind(':ipip',$a);
        if($this->db->execute())
        {
            if($dep == 1)
            {
                $service_id = explode(',', $service_id);
                $this->db->query('SELECT invoice_id FROM invoices WHERE department = 1 ORDER BY invoice_id DESC LIMIT 1');
                $row = $this->db->resultSet();
                foreach ($row as $key_1)
                {
                    $lab_test_order_id = $key_1->invoice_id;
                }
                $count = count($service_id);
                $count = trim($count);
                $count = (int)$count;
                $count = $count - 1;
                for ($i=0; $i < $count/4 ; $i++)
                {
                    $service_id_id = $service_id[$i*4];
                    $this->db->query('INSERT INTO lab_tests (lab_test_ref_id, lab_test_order_id, lab_test_date_time) VALUES (:service_id_id, :lab_test_order_id, :dateAndTime)');
                    $this->db->bind(':service_id_id',$service_id_id);
                    $this->db->bind(':lab_test_order_id',$lab_test_order_id);
                    $this->db->bind(':dateAndTime',$dateAndTime);
                    $qwerty = $this->db->execute();
                }
                if($qwerty)
                    return true;
                else
                    return false;
            }
            else
            {
                return true;
            }
        }
        else
        {
            return false;
        }
    }

    public function get_all_service_db()
    {
        $this->db->query('SELECT DISTINCT service_type FROM services WHERE mh_id = :mh_id');
        $this->db->bind(':mh_id', $_SESSION['mh_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
        $row = $this->db->resultSet();
        return $row;
    }

    public function save_new_service_db($s_name,$s_type,$s_cost)
    {
        $this->db->query('INSERT into services (service_name,service_type,service_cost,mh_id) VALUES (:s_name,:s_type,:s_cost,:mh_id)');
        $this->db->bind(':s_name',$s_name);
        $this->db->bind(':s_type',$s_type);
        $this->db->bind(':s_cost',$s_cost);
        $this->db->bind(':mh_id', $_SESSION['mh_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
        if($this->db->execute())
            return true;
        else
            return false;
    }

    public function get_all_services($lim,$off)
    {
        $this->db->query('SELECT * FROM services WHERE mh_id = :mh_id ORDER BY service_id DESC limit :lim OFFSET :off');
        $this->db->bind(':lim',$lim);
        $this->db->bind(':off',$off);
        $this->db->bind(':mh_id', $_SESSION['mh_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
        $row = $this->db->resultSet();
        return $row;
    }

    public function get_all_report($lim,$off)
    {
        $this->db->query('SELECT * FROM reports ORDER BY report_id DESC limit :lim OFFSET :off');
        $this->db->bind(':lim',$lim);
        $this->db->bind(':off',$off);
        $row = $this->db->resultSet();
        return $row;
    }

    public function get_search_services($inv_id)
    {
        $this->db->query('SELECT * FROM services WHERE service_id=:inv_id AND mh_id = :mh_id');
        $this->db->bind(':inv_id',$inv_id);
        $this->db->bind(':mh_id', $_SESSION['mh_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
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

    public function get_patient_service($patient_name)
    {
        $this->db->query("SELECT * FROM services WHERE mh_id = :mh_id AND service_name LIKE concat('%', :patient_name, '%') LIMIT 50");
        $this->db->bind(':patient_name',$patient_name);
        $this->db->bind(':mh_id', $_SESSION['mh_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
        $row = $this->db->resultSet();
        return $row;
    }

    public function update_service_db($s_id,$s_name,$s_type,$s_cost)
    {
        $this->db->query('UPDATE services SET service_name=:s_name, service_type=:s_type, service_cost=:s_cost WHERE service_id=:s_id');
        $this->db->bind(':s_id',$s_id);
        $this->db->bind(':s_name',$s_name);
        $this->db->bind(':s_type',$s_type);
        $this->db->bind(':s_cost',$s_cost);
        $this->db->execute();
        return true;
    }

    public function get_doctors_list()
    {
        $this->db->query('SELECT * FROM doctors');
        $row = $this->db->resultSet();
        return $row;
    }

    public function get_doctors_list1($cname)
    {
        $this->db->query("SELECT * FROM doctors WHERE doctor_name LIKE concat('%', :cname, '%') LIMIT 5");
        $this->db->bind(':cname', $cname);
        $row = $this->db->resultSet();
        return $row;
    }



    public function check_db_visit($p_name,$d_name)
    {
        $d_name = explode('|', $d_name);
        $d_name = trim($d_name[0]);
        $this->db->query('SELECT * FROM doctors WHERE mem_id=:d_name');
        $this->db->bind(':d_name',$d_name);
        $d_id = $this->db->resultSet();
        foreach ($d_id as $key)
        {
            $d_id1 = $key->mem_id;
        }

        $this->db->query('SELECT * FROM opd WHERE opd_doctor_id = :d_id1 and opd_patient_id = :p_name AND q_clr_status IS NULL AND mh_id = :mh_id');
        $this->db->bind(':d_id1',$d_id1);
        $this->db->bind(':p_name',$p_name);
        // $this->db->bind(':q_clr_status', 0);
        $this->db->bind(':mh_id', $_SESSION['mh_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
        $row = $this->db->single();
        return $row;
    }

    public function create_visit_db($p_name,$d_name,$v_pur)
    {
        $dt = new DateTime("now", new DateTimeZone('Asia/Calcutta'));
        $dat = $dt->format('Y/m/d');
        $d_name = explode('|', $d_name);
        $d_name = trim($d_name[0]);
        $this->db->query('SELECT * FROM doctors WHERE mem_id=:d_name');
        $this->db->bind(':d_name',$d_name);
        $d_id = $this->db->resultSet();
        foreach ($d_id as $key)
        {
            $d_id1 = $key->mem_id;
        }
        $this->db->query('INSERT INTO opd (opd_patient_id, opd_doctor_id, opd_purpose, visit_date_time,created_by, mh_id) VALUES (:p_name, :d_id1, :v_pur, :dat, :created_by, :mh_id)');
        $this->db->bind(':d_id1',$d_id1);
        $this->db->bind(':p_name',$p_name);
        $this->db->bind(':v_pur',$v_pur);
        $this->db->bind(':dat',$dat);
        $this->db->bind(':created_by',$_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
        $this->db->bind(':mh_id', $_SESSION['mh_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
        if($this->db->execute())
            return true;
        else
            return false;
    }
     public function create_visit_db1($p_name,$d_name,$v_pur,$dt)
    {
        
        $dat = $dt;
        $d_name = explode('|', $d_name);
        $d_name = trim($d_name[0]);
        $this->db->query('SELECT * FROM doctors WHERE doctor_name=:d_name');
        $this->db->bind(':d_name',$d_name);
        $d_id = $this->db->resultSet();
        foreach ($d_id as $key)
        {
            $d_id1 = $key->mem_id;
        }
        $this->db->query('INSERT INTO opd (opd_patient_id, opd_doctor_id, opd_purpose, visit_date_time,created_by) VALUES (:p_name, :d_id1, :v_pur, :dat, :created_by)');
        $this->db->bind(':d_id1',$d_id1);
        $this->db->bind(':p_name',$p_name);
        $this->db->bind(':v_pur',$v_pur);
        $this->db->bind(':dat',$dat);
        $this->db->bind(':created_by',$_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
        if($this->db->execute())
            return true;
        else
            return false;
    }
    

    public function get_all_visit($lim,$off)
    {
        $this->db->query('SELECT * FROM opd WHERE mh_id = :mh_id ORDER BY opd_visit_id DESC limit :lim OFFSET :off');
        $this->db->bind(':lim',200);
        $this->db->bind(':off',$off);
        $this->db->bind(':mh_id', $_SESSION['mh_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
        $row = $this->db->resultSet();
        return $row;
    }


    public function find_fee_bill($r)
    {
        $this->db->query('SELECT * FROM invoices WHERE opip_id = :id AND department=:dept');
        $this->db->bind(':id',$r);
        $this->db->bind(':dept',2);
        $row = $this->db->single();
        return $row;
    }
    public function find_fee_lab($r)
    {
        $this->db->query('SELECT * FROM invoices WHERE opip_id = :id AND department=:dept');
        $this->db->bind(':id',$r);
        $this->db->bind(':dept',1);
        $row = $this->db->single();
        return $row;
    }


    public function get_all_visit_pat($lim,$off)
    {
        $pid = $_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no'];
        $this->db->query('SELECT * FROM opd WHERE opd_patient_id = :pid ORDER BY opd_visit_id DESC limit :lim OFFSET :off');
        $this->db->bind(':pid', $pid);
        $this->db->bind(':lim',$lim);
        $this->db->bind(':off',$off);
        $row = $this->db->resultSet();
        return $row;
    }

    public function get_all_visit_by_id($id)
    {
        $this->db->query('SELECT * FROM opd WHERE opd_visit_id = :id ORDER BY opd_visit_id DESC LIMIT 1');
        $this->db->bind(':id',$id);
        $row = $this->db->resultSet();
        return $row;
    }

    public function get_all_visit_by_pat_id($id)
    {
        $this->db->query('SELECT * FROM opd WHERE opd_patient_id = :id ORDER BY opd_visit_id DESC LIMIT 10');
        $this->db->bind(':id',$id);
        $row = $this->db->resultSet();
        return $row;
    }

    public function get_all_visit_by_pat_name($pat_name)
    {
        $this->db->query('SELECT patients.patient_name, patients.patient_phone, patients.patient_id, opd.opd_visit_id, opd.opd_patient_id, opd.opd_doctor_id, opd.opd_purpose, opd.visit_date_time, opd.opd_visit_fee FROM patients INNER JOIN opd ON opd.opd_patient_id = patients.patient_id WHERE patients.patient_name LIKE concat("%", :pat_name, "%")OR patients.patient_phone LIKE concat("%", :pat_name, "%")');
        $this->db->bind(':pat_name',$pat_name);
        $row = $this->db->resultSet();
        return $row;
    }

    public function get_all_visit_by_doc_name($pat_name)
    {
        $this->db->query('SELECT doctors.doctor_name, opd.opd_visit_id, opd.opd_patient_id, opd.opd_doctor_id, opd.opd_purpose, opd.visit_date_time, opd.opd_visit_fee FROM doctors INNER JOIN opd ON opd.opd_doctor_id = doctors.mem_id WHERE doctors.doctor_name LIKE concat("%", :pat_name, "%")');
        $this->db->bind(':pat_name',$pat_name);
        $row = $this->db->resultSet();
        return $row;
    }

    public function get_visit_details_id($vis_id)
    {
        $this->db->query('SELECT * FROM opd WHERE opd_visit_id=:vis_id');
        $this->db->bind(':vis_id',$vis_id);
        $row = $this->db->resultSet();
        return $row;
    }

    public function get_admit_details_id($vis_id)
    {
        $this->db->query('SELECT * FROM ipd WHERE ipd_admit_id=:vis_id');
        $this->db->bind(':vis_id',$vis_id);
        $row = $this->db->resultSet();
        return $row;
    }

    public function getTheIpdDetails($vis_id)
    {
        $this->db->query('SELECT * FROM ipd WHERE ipd_admit_id=:vis_id');
        $this->db->bind(':vis_id',$vis_id);
        $row = $this->db->single();
        return $row;
    }

     public function check_ip_name_exist($p_name)
    {
        $this->db->query('SELECT * FROM ipd WHERE ipd_patient_id=:p_name ');
        $this->db->bind(':p_name',$p_name);
        $row = $this->db->resultSet();
        $count = $this->db->rowCount();
        return $count;
    }

    public function check_ip_name_exist_and_discharge($p_name)
    {
        $this->db->query('SELECT * FROM ipd WHERE ipd_patient_id=:p_name AND discharge_status IS NULL');
        $this->db->bind(':p_name',$p_name);
        $row = $this->db->single();
        return $count = $this->db->rowCount();
    }

    public function delete_service_db($s_id)
    {
        $this->db->query('DELETE FROM services WHERE service_id=:s_id');
        $this->db->bind(':s_id',$s_id);
        if($this->db->execute())
            return true;
        else
            return false;
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

    public function create_admission_db($p_name,$d_name,$v_pur,$insNumber,$insName,$insExpiry)
    {
        $d_name = explode('|', $d_name);
        $d_name = trim($d_name[0]);
        $tday = date('Y-m-d H:i:s');
        $this->db->query('SELECT * FROM doctors WHERE mem_id=:d_name');
        $this->db->bind(':d_name',$d_name);
        $d_id = $this->db->resultSet();
        foreach ($d_id as $key)
        {
            $d_id1 = $key->mem_id;
        }
        $this->db->query('INSERT INTO ipd (ipd_patient_id, ipd_doctor_id, ipd_bed_id, admission_date_time,created_by,insurance_id,insurance_name,insurance_expiry, mh_id) VALUES (:p_name, :d_id1, :v_pur, :tday, :created_by, :insNumber, :insName, :insExpiry, :mh_id)');
        $this->db->bind(':d_id1',$d_id1);
        $this->db->bind(':p_name',$p_name);
        $this->db->bind(':v_pur',$v_pur);
        $this->db->bind(':tday', $tday);
        $this->db->bind(':insNumber', $insNumber);
        $this->db->bind(':insName', $insName);
        $this->db->bind(':insExpiry', $insExpiry);
        $this->db->bind(':created_by',$_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']); 
        $this->db->bind(':mh_id', $_SESSION['mh_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
        if($this->db->execute())
            return true;
        else
            return false;
    }

     public function add_ip_admission_date_to_db($p_name)
    {
        
        $this->db->query('SELECT * FROM ipd WHERE ipd_patient_id = :p_name and created_by = :created_by ORDER BY ipd_admit_id DESC');
        $this->db->bind(':p_name',$p_name);
         $this->db->bind(':created_by',$_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
        $row = $this->db->single();

        $ipd_id_from_ipd = $row->ipd_admit_id;
       

        $tday = date('Y-m-d H:i:s');
        $this->db->query('INSERT INTO ipd_discharge_details (ipd_id, ipd_patient_id,  admission_date_time,created_by) VALUES (:ipd_id_from_ipd, :p_name, :tday, :created_by)');
        $this->db->bind(':ipd_id_from_ipd',$ipd_id_from_ipd);
        $this->db->bind(':p_name',$p_name);
        $this->db->bind(':tday', $tday);
        $this->db->bind(':created_by',$_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']); 
        if($this->db->execute())
            return true;
        else
            return false;
    }


     public function add_ip_admission_date_to_db1($p_name,$adm_date1)
    {
        
        $this->db->query('SELECT * FROM ipd WHERE ipd_patient_id = :p_name and created_by = :created_by ORDER BY ipd_admit_id DESC');
        $this->db->bind(':p_name',$p_name);
         $this->db->bind(':created_by',$_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
        $row = $this->db->single();

        $ipd_id_from_ipd = $row->ipd_admit_id;
       

        $tday = $adm_date1;
        $this->db->query('INSERT INTO ipd_discharge_details (ipd_id, ipd_patient_id,  admission_date_time,created_by) VALUES (:ipd_id_from_ipd, :p_name, :tday, :created_by)');
        $this->db->bind(':ipd_id_from_ipd',$ipd_id_from_ipd);
        $this->db->bind(':p_name',$p_name);
        $this->db->bind(':tday', $tday);
        $this->db->bind(':created_by',$_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']); 
        if($this->db->execute())
            return true;
        else
            return false;
    }

    public function create_admission_db1($p_name,$d_name,$v_pur,$adm)
    {
        $d_name = explode('|', $d_name);
        $d_name = trim($d_name[0]);
        $this->db->query('SELECT * FROM doctors WHERE doctor_name=:d_name');
        $this->db->bind(':d_name',$d_name);
        $d_id = $this->db->resultSet();
        foreach ($d_id as $key)
        {
            $d_id1 = $key->mem_id;
        }
        $this->db->query('INSERT INTO ipd (ipd_patient_id, ipd_doctor_id, ipd_bed_id, admission_date_time,created_by) VALUES (:p_name, :d_id1, :v_pur, :adm, :created_by)');
        $this->db->bind(':adm', $adm);
        $this->db->bind(':d_id1',$d_id1);
        $this->db->bind(':p_name',$p_name);
        $this->db->bind(':v_pur',$v_pur);
        $this->db->bind(':created_by',$_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
        if($this->db->execute())
            return true;
        else
            return false;
    }

    public function get_all_admission($lim,$off)
    {
        $this->db->query('SELECT * FROM ipd WHERE mh_id = :mh_id ORDER BY ipd_admit_id DESC limit :lim OFFSET :off');
        $this->db->bind(':lim',200);
        $this->db->bind(':off',$off);
        $this->db->bind(':mh_id', $_SESSION['mh_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
        $row = $this->db->resultSet();
        return $row;
    }

    public function get_all_admission_pat($lim,$off)
    {
        $pid = $_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no'];
        $this->db->query('SELECT * FROM ipd WHERE ipd_patient_id = :pid ORDER BY ipd_admit_id DESC limit :lim OFFSET :off');
        $this->db->bind(':lim',$lim);
        $this->db->bind(':off',$off);
        $this->db->bind(':pid',$pid);
        $row = $this->db->resultSet();
        return $row;
    }

    public function get_all_admit_by_id($id)
    {
        $this->db->query('SELECT * FROM ipd WHERE ipd_admit_id = :id ORDER BY ipd_admit_id DESC LIMIT 1');
        $this->db->bind(':id',$id);
        $row = $this->db->resultSet();
        return $row;
    }

    public function get_all_admit_by_pid($id)
    {
        $this->db->query('SELECT * FROM ipd WHERE ipd_patient_id = :id ORDER BY ipd_admit_id DESC LIMIT 1');
        $this->db->bind(':id',$id);
        $row = $this->db->resultSet();
        return $row;
    }

    public function get_all_admit_by_pname($id)
    {
        $this->db->query('SELECT patients.patient_name,patients.patient_name, patients.patient_id,ipd.ipd_admit_id, ipd.ipd_patient_id, ipd.ipd_doctor_id, ipd.ipd_bed_id, ipd.admission_date_time, ipd.discharge_date_time, ipd.advice, ipd.insurance_name, ipd.created_by FROM patients INNER JOIN ipd ON ipd.ipd_patient_id = patients.patient_id WHERE patients.patient_name LIKE concat("%", :id, "%") OR patients.patient_phone LIKE concat("%", :id, "%")');
        $this->db->bind(':id',$id);
        $row = $this->db->resultSet();
        return $row;
    }

    public function get_all_admit_by_dname($id)
    {
        $this->db->query('SELECT doctors.doctor_name,ipd.ipd_admit_id, ipd.ipd_patient_id, ipd.ipd_doctor_id, ipd.ipd_bed_id, ipd.admission_date_time, ipd.discharge_date_time, ipd.advice, ipd.insurance_name, ipd.created_by FROM doctors INNER JOIN ipd ON ipd.ipd_doctor_id = doctors.mem_id WHERE doctors.doctor_name LIKE concat("%", :id, "%")');
        $this->db->bind(':id',$id);
        $row = $this->db->resultSet();
        return $row;
    }
     public function check_email_before_insert($email)
    {
		$this->db->query('SELECT * FROM users WHERE mem_email = :mem_email');
		$this->db->bind(':mem_email',$email);
		$row = $this->db->resultSet();
		if($this->db->rowCount() > 0)
		{
			return false;
		}
		else
		{
			return true;
		}
    }
    public function check_phno_before_insert($phone)
    {
		$this->db->query('SELECT * FROM users WHERE mem_phone = :phone');
		$this->db->bind(':phone',$phone);
		$row = $this->db->resultSet();
		if($this->db->rowCount() > 0)
		{
			return false;
		}
		else
		{
			return true;
		}
    }
    public function add_patient_db($p_name,$gen,$age,$dob,$phone,$email,$address,$weight,$height,$country)
    {
        $mem_em = $email;
        $this->db->query('SELECT mem_id FROM users WHERE mem_email = :mem_em');
        $this->db->bind(':mem_em', $mem_em);
        $row = $this->db->single();
        if($this->db->rowCount() > 0)
        {
            return false;
        }
        else
        {
			$mem_pass1 = password_hash($phone, PASSWORD_DEFAULT);
			$this->db->query('INSERT INTO users (mem_name, mem_type, mem_phone, mem_email, mem_pass, mh_id, plan) VALUES(:mem_name, :mem_type, :mem_ph, :mem_em, :mem_pass1, :mh_id, 1)');
			$this->db->bind(':mem_name',$p_name);
			$this->db->bind(':mem_type' ,'patient');
			$this->db->bind(':mem_ph' ,$phone);
			$this->db->bind(':mem_em' ,$email);
			$this->db->bind(':mem_pass1' ,$mem_pass1);
			$this->db->bind(':mh_id', $_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
			if($this->db->execute())
			{
				$dt_age = date('Y-m-d');
				$this->db->query('INSERT INTO patients (patient_name,patient_gender,patient_dob,patient_phone,patient_email,patient_address,patient_age, age_update_time,patient_weight,patient_height, created_by,ph_no_isd,mh_id) VALUES (:p_name,:gen,:dob,:phone,:email,:address,:age, :dt_age, :weight, :height, :created_by, :country,:mh_id)');
				$this->db->bind(':p_name',$p_name);
				$this->db->bind(':gen',$gen);
				$this->db->bind(':age',$age);
				$this->db->bind(':dob',$dob);
				$this->db->bind(':phone',$phone);
				$this->db->bind(':email',$email);
				$this->db->bind(':address',$address);
				$this->db->bind(':dt_age',$dt_age);
				$this->db->bind(':weight',$weight);
				$this->db->bind(':height', $height);
				$this->db->bind(':country', $country.$phone);
				$this->db->bind(':created_by',$_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
				$this->db->bind(':mh_id', $_SESSION['mh_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
				if($this->db->execute())
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
    }

    public function update_patient_db($pat_id,$p_name,$gen,$age,$dob,$phone,$email,$address,$weight, $height,$country)
    {
        $this->db->query('UPDATE patients SET patient_name = :p_name, patient_gender = :gen, patient_dob = :dob, patient_phone = :phone, patient_email = :email, patient_address = :address, patient_age = :age, patient_weight = :weight, patient_height = :height, ph_no_isd = :country WHERE patient_id = :pat_id');
        $this->db->bind(':pat_id', $pat_id);
        $this->db->bind(':p_name', $p_name);
        $this->db->bind(':gen', $gen);
        $this->db->bind(':age', $age);
        $this->db->bind(':dob', $dob);
        $this->db->bind(':phone', $phone);
        $this->db->bind(':email', $email);   
        $this->db->bind(':address', $address);
        $this->db->bind(':weight',$weight);
        $this->db->bind(':height', $height);
        $this->db->bind(':country', $country.$phone);
        if($this->db->execute())
            return true;
        else
            return false;
    }    

    public function get_all_patients($lim,$off)
    {
        $this->db->query('SELECT * FROM patients WHERE active = 1 AND mh_id = :mh_id ORDER BY patient_id DESC limit :lim OFFSET :off ');
        $this->db->bind(':lim',$lim);
        $this->db->bind('off',$off);
        $this->db->bind(':mh_id', $_SESSION['mh_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
        $row = $this->db->resultSet();
        return $row;
    }

    public function get_all_patients_rem($lim,$off)
    {
        $this->db->query('SELECT * FROM patients WHERE mh_id = :mh_id AND active = 0 ORDER BY patient_id DESC limit :lim OFFSET :off ');
        $this->db->bind(':lim',$lim);
        $this->db->bind('off',$off);
        $this->db->bind(':mh_id', $_SESSION['mh_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
        $row = $this->db->resultSet();
        return $row;
    }

    public function add_doctor_db($doc_name,$doc_spl,$doc_fee,$doc_phone,$doc_email)
    {
        $this->db->query('SELECT mem_id FROM users WHERE mem_email = :mem_em');
        $this->db->bind(':mem_em', $doc_email);
        $row = $this->db->single();
        if($this->db->rowCount() > 0)
        {
            return 3;
        }
        else
        {
			$mem_pass1 = password_hash($doc_phone, PASSWORD_DEFAULT);
			$this->db->query('INSERT INTO users (mem_name, mem_type, mem_phone, mem_email, mem_pass, mh_id, plan) VALUES(:doc_name, "doc", :doc_phone, :doc_email, :mem_pass1, :mh_id, 1)');
			$this->db->bind(':doc_name' ,$doc_name);
			$this->db->bind(':doc_phone' ,$doc_phone);
			$this->db->bind(':doc_email' ,$doc_email);
			$this->db->bind(':mem_pass1' ,$mem_pass1);
			$this->db->bind(':mh_id', $_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
			if($this->db->execute())
			{
				$this->db->query('SELECT * FROM users WHERE mem_email = :doc_email');
				$this->db->bind(':doc_email', $doc_email);
				$row = $this->db->resultSet();
				foreach ($row as $key)
				{
					$mem_id = $key->mem_id;
				}

				$this->db->query('INSERT INTO doctors (doctor_name,doctor_speciality,mem_id,doctor_fees, mh_id) VALUES (:doc_name,:doc_spl,:mem_id,:doc_fee,:mh_id)');
				$this->db->bind(':mem_id', $mem_id);
				$this->db->bind(':doc_name', $doc_name);
				$this->db->bind(':doc_spl', $doc_spl);
				$this->db->bind(':doc_fee', $doc_fee);
				$this->db->bind(':mh_id', $_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
				if($this->db->execute())
				{
					return 2;
				}
				else
				{
					return 4;
				}
			}
			else
			{
				return 4;
			}
        }
    }

    public function update_doctor_db($doc_name,$doc_spl,$doc_fee,$doc_phone,$doc_email, $mem_id)
    {
        $this->db->query('UPDATE doctors SET doctor_name = :doc_name, doctor_speciality = :doc_spl, doctor_fees = :doc_fee WHERE mem_id = :mem_id');
        $this->db->bind(':mem_id', $mem_id);
        $this->db->bind(':doc_name', $doc_name);
        $this->db->bind('doc_spl', $doc_spl);
        $this->db->bind(':doc_fee', $doc_fee);
        if($this->db->execute())
        {
            $this->db->query('UPDATE users SET mem_name = :doc_name, mem_phone = :doc_phone WHERE mem_id = :mem_id');
            $this->db->bind(':mem_id', $mem_id);
            $this->db->bind(':doc_name', $doc_name);
            $this->db->bind(':doc_phone', $doc_phone);
            if($this->db->execute())
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

    public function get_all_doctors($lim,$off)
    {
        $this->db->query('SELECT * FROM doctors WHERE mh_id = :mh_id ORDER BY mem_id DESC limit :lim OFFSET :off');
        $this->db->bind(':lim',$lim);
        $this->db->bind('off',$off);
        $this->db->bind(':mh_id', $_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
        $row = $this->db->resultSet();
        return $row;
    }

    public function get_doctor_by_id($d_id)
    {
        $this->db->query('SELECT * FROM doctors WHERE mem_id = :d_id');
        $this->db->bind(':d_id',$d_id);
        $row = $this->db->resultSet();
        return $row;
    }
    

    public function get_doctor_by_id_single($d_id)
    {
        $this->db->query('SELECT * FROM doctors WHERE mem_id = :d_id');
        $this->db->bind(':d_id',$d_id);
        $row = $this->db->single();
        return $row;
    }

    public function get_member_by_id($d_id)
    {
        $this->db->query('SELECT * FROM users WHERE mem_id = :d_id');
        $this->db->bind(':d_id',$d_id);
        $row = $this->db->resultSet();
        return $row;
    }

    public function get_patient_by_id($p_id)
    {
        $this->db->query('SELECT * FROM patients WHERE patient_id = :p_id');
        $this->db->bind(':p_id',$p_id);
        $row = $this->db->resultSet();
        return $row;
    }
    //  public function getcostoftestformrec_model($cost)
    // {
    //     $this->db->query('SELECT * FROM lab_tests_available WHERE test_id = :cost');
    //     $this->db->bind(':cost',$cost);
    //     $row = $this->db->single();
    //     return $row;
    // }

    public function get_last_invoice($id)
    {
        $this->db->query('SELECT * FROM invoices WHERE invoice_id=:id');
        $this->db->bind(':id',$id);
        $row = $this->db->resultSet();
        return $row;
    }
     public function get_last_invoice1($b,$id)
    {   
        $a='';
        $a = 'OP';
        $this->db->query('SELECT * FROM invoices WHERE invoice_name=:id and visit_order_done = :opip_id');
        $this->db->bind(':id',$b);
        $this->db->bind(':opip_id',$a);
        $row = $this->db->resultSet();

        return $row;
    }
     public function get_last_invoice2($b)
    {   
        
        $a='';
        $a = 'IP';
        $this->db->query('SELECT * FROM invoices WHERE invoice_name=:id and visit_order_done = :opip_id');
        $this->db->bind(':id',$b);
        $this->db->bind(':opip_id',$a);
        $row = $this->db->resultSet();

        return $row;
    }
     public function get_patient_name_using_id($id)
    {
        $this->db->query('SELECT * FROM patients WHERE patient_id=:id');
        $this->db->bind(':id',$id);
        $row = $this->db->single();
        return $row;
    }

    public function discharge_db($dis,$v_id)
    {
        $this->db->query('UPDATE ipd SET discharge_date_time =:dis, discharge_status = "2" WHERE ipd_admit_id=:v_id');
        $this->db->bind(':dis',$dis);
        $this->db->bind(':v_id',$v_id);
        if($this->db->execute())
            return true;
        else
            return false;
    }
    public function discharge_details_update_to_discharge_db($dis,$v_id)
    {
        $this->db->query('UPDATE ipd_discharge_details SET discharge_date_time =:dis, status = "2" WHERE ipd_id=:ipd_id');
        $this->db->bind(':dis',$dis);
        $this->db->bind(':ipd_id',$v_id);   
        if($this->db->execute())
            return true;
        else
            return false;
    }

    public function add_mem_db($mem_name, $mem_type, $mem_ph, $mem_em)
    {
        $this->db->query('SELECT mem_id FROM users WHERE mem_email = :mem_em');
        $this->db->bind(':mem_em', $mem_em);
        $row = $this->db->single();
        if($this->db->rowCount() > 0)
        {
            return 3;
        }
        else
        {
            $this->db->query('SELECT * FROM users WHERE mem_email = :mem_em');
            $this->db->bind(':mem_em', $_SESSION['email']);
            $rowtemp = $this->db->single();
            $rowtemp = $rowtemp->plan;

			$mem_pass1 = password_hash($mem_ph, PASSWORD_DEFAULT);
			$this->db->query('INSERT INTO users (mem_name, mem_type, mem_phone, mem_email, mem_pass, mh_id, plan) VALUES(:mem_name, :mem_type, :mem_ph, :mem_em, :mem_pass1, :mh_id, :rowtemp)');
			$this->db->bind(':mem_name',$mem_name);
			$this->db->bind(':mem_type' ,$mem_type);
			$this->db->bind(':mem_ph' ,$mem_ph);
			$this->db->bind(':mem_em' ,$mem_em);
			$this->db->bind(':mem_pass1' ,$mem_pass1);
			$this->db->bind(':rowtemp' ,$rowtemp);
			$this->db->bind(':mh_id', $_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
			if($this->db->execute())
			{
				return 2;
            }
        }
    }

    public function edit_mem_db($mem_name, $mem_type, $mem_ph, $mem_em)
    {
        $mem_pass1 = password_hash($mem_ph, PASSWORD_DEFAULT);
        $this->db->query('UPDATE users SET mem_name = :mem_name, mem_type = :mem_type, mem_phone = :mem_ph, mem_pass = :mem_pass1 WHERE mem_email = :mem_em');
        $this->db->bind(':mem_name' ,$mem_name);
        $this->db->bind(':mem_type' ,$mem_type);
        $this->db->bind(':mem_ph' ,$mem_ph);
        $this->db->bind(':mem_em' ,$mem_em);
        $this->db->bind(':mem_pass1' ,$mem_pass1);
        if($this->db->execute())
            return true;
        else
            return false;
    }

    public function get_all_members($lim,$off)
    {
        $this->db->query('SELECT * FROM users WHERE mem_type != "doc" AND mem_type != "admin" AND mh_id = :mh_id ORDER BY mem_id DESC limit :lim OFFSET :off');
        $this->db->bind(':lim',$lim);
        $this->db->bind(':off',$off);
        $this->db->bind(':mh_id', $_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
        $row = $this->db->resultSet();
        return $row;
    }

    public function remove_mem_db($mid)
    {
        $this->db->query('DELETE FROM users WHERE mem_id=:mid');
        $this->db->bind(':mid',$mid);
        if($this->db->execute())
            return true;
        else
            return false;
    }

    public function get_invoice_details_for_new()
    {
        $this->db->query('SELECT * FROM invoices ORDER BY invoice_id DESC LIMIT 1');
        $row = $this->db->resultSet();
        return $row;
    }
     public function get_invoice_details_for_new1()
    {
        $this->db->query('SELECT * FROM invoices ORDER BY invoice_id DESC LIMIT 1');
        $row = $this->db->resultSet();
        return $row;
    }
     public function get_invoice_details_for_new2()
    {
        $this->db->query('SELECT * FROM invoices ORDER BY invoice_id DESC LIMIT 1');
        $row = $this->db->resultSet();
        return $row;
    }

    public function get_available_tests_db_auto($val)
    {
        $this->db->query('SELECT lab_tests_available.test_id,lab_tests_available.test_cost,lab_test_values.lab_test_name,lab_test_values.lab_test_values,lab_test_values.lab_test_date_time FROM lab_tests_available INNER JOIN lab_test_values on lab_test_values.lab_test_name LIKE concat("%", :val, "%") AND lab_tests_available.test_id = lab_test_values.lab_test_value_id');
        $this->db->bind(':val',$val);
        $row  = $this->db->resultSet();
        return $row;
    }

    public function value_of_amt_lab($aamt)
    {
        $this->db->query('SELECT test_cost FROM lab_tests_available WHERE test_id=:aamt');
        $this->db->bind(':aamt',$aamt);
        $row  = $this->db->single();
        return $row;
    }

    public function get_lab_reports($lim,$off)
    {
        $this->db->query('SELECT * FROM lab_tests WHERE lab_test_status = 2 ORDER BY lab_test_id DESC limit :lim OFFSET :off ');
        $this->db->bind(':lim',$lim);
        $this->db->bind('off',$off);
        $row = $this->db->resultSet();
        return $row;
    }

    public function getAllLabTest()
    {
        $this->db->query('SELECT * FROM lab_tests');
        $row = $this->db->resultSet();
        return $row;
    }

    public function get_lab_reports11()
    {
        $this->db->query('SELECT * FROM lab_tests WHERE lab_test_status = 2 ORDER BY lab_test_id DESC ');
        // $this->db->bind(':lim',$lim);
        // $this->db->bind('off',$off);
        $row = $this->db->resultSet();
        return $row;
    }

    public function get_lab_reports1($vis_id)
    {
        $this->db->query("SELECT * FROM lab_tests WHERE lab_test_status = 2 AND lab_test_order_id LIKE concat('%', :vis_id, '%') LIMIT 1");
        $this->db->bind(':vis_id',$vis_id);
        $row = $this->db->resultSet();
        return $row;
    }

    public function get_lab_reports2($vis_id)
    {
        $this->db->query("SELECT * FROM lab_tests WHERE lab_test_status = 2 AND lab_test_order_id LIKE concat('%', :vis_id, '%') LIMIT 1");
        $this->db->bind(':vis_id',$vis_id);
        $row = $this->db->resultSet();
        return $row;
    }

    public function get_reports_data($id)
    {
        $this->db->query('SELECT * FROM lab_tests WHERE lab_test_order_id = :id');
        $this->db->bind(':id' ,$id);
        $row = $this->db->resultSet();
        return $row;
    }

    public function save_service_provider_db($data)
    {
        $this->db->query('SELECT * FROM service_provider');
        $row = $this->db->single();

        if($this->db->rowCount() > 0)
        {
            $this->db->query('UPDATE service_provider SET client_name = :c_name, client_title = :c_title, client_type = :c_type, client_logo = :file_name, client_address = :c_add, client_email = :c_email, client_phone = :c_phone, d_licence = :c_licence, gst_no = :c_gst, login_photo = :loginFile');
            $this->db->bind(':c_name', $data['c_name']);
            $this->db->bind(':c_title', $data['c_title']);
            $this->db->bind(':c_type', $data['c_type']);
            $this->db->bind(':c_add', $data['c_add']);
            $this->db->bind(':file_name', $data['file_name']);
            $this->db->bind(':c_email', $data['c_email']);
            $this->db->bind(':c_phone', $data['c_phone']);
            $this->db->bind(':c_licence', $data['c_licence']);
            $this->db->bind(':c_gst', $data['c_gst']);
            $this->db->bind(':loginFile', $data['loginFile']);
            if($this->db->execute())
                return true;
            else
                return false;
        }
        else
        {
            $this->db->query('INSERT INTO service_provider (client_name, client_title, client_type, client_logo, client_address, client_email, client_phone, d_licence, gst_no, login_photo) VALUES (:c_name, :c_title, :c_type, :file_name, :c_add, :c_email, :c_phone, :c_licence , :c_gst, :loginFile)');
            $this->db->bind(':c_name', $data['c_name']);
            $this->db->bind(':c_title', $data['c_title']);
            $this->db->bind(':c_type', $data['c_type']);
            $this->db->bind(':c_add', $data['c_add']);
            $this->db->bind(':file_name', $data['file_name']);
            $this->db->bind(':c_email', $data['c_email']);
            $this->db->bind(':c_phone', $data['c_phone']);
            $this->db->bind(':c_licence', $data['c_licence']);
            $this->db->bind(':c_gst', $data['c_gst']);
            $this->db->bind(':loginFile', $data['loginFile']);
            if($this->db->execute())
                return true;
            else
                return false;
        }
    }

    public function save_service_provider_db1($data)
    {
		$this->db->query('UPDATE service_provider SET client_logo = :file_name');
		$this->db->bind(':file_name', $data['file_name']);
		if($this->db->execute())
			return true;
		else
			return false;
    }

    public function save_service_provider_db2($data)
    {
        $this->db->query('SELECT * FROM service_provider');
        $row = $this->db->single();

        if($this->db->rowCount() > 0)
        {
            $this->db->query('UPDATE service_provider SET client_name = :c_name, client_title = :c_title, client_type = :c_type, client_address = :c_add, client_email = :c_email, client_phone = :c_phone, d_licence = :c_licence, gst_no = :c_gst, login_photo = :loginFile');
            $this->db->bind(':c_name', $data['c_name']);
            $this->db->bind(':c_title', $data['c_title']);
            $this->db->bind(':c_type', $data['c_type']);
            $this->db->bind(':c_add', $data['c_add']);
            $this->db->bind(':c_email', $data['c_email']);
            $this->db->bind(':c_phone', $data['c_phone']);
            $this->db->bind(':c_licence', $data['c_licence']);
            $this->db->bind(':c_gst', $data['c_gst']);
            $this->db->bind(':loginFile', $data['loginFile']);
            if($this->db->execute())
                return true;
            else
                return false;
        }
        else
        {
            $this->db->query('INSERT INTO service_provider (client_name, client_title, client_type, client_address, client_email, client_phone, d_licence, gst_no, client_logo) VALUES (:c_name, :c_title, :c_type, :c_add, :c_email, :c_phone, :c_licence , :c_gst, :file_name)');
            $this->db->bind(':c_name', $data['c_name']);
            $this->db->bind(':c_title', $data['c_title']);
            $this->db->bind(':c_type', $data['c_type']);
            $this->db->bind(':c_add', $data['c_add']);
            $this->db->bind(':c_email', $data['c_email']);
            $this->db->bind(':c_phone', $data['c_phone']);
            $this->db->bind(':c_licence', $data['c_licence']);
            $this->db->bind(':file_name', $data['file_name']);
            $this->db->bind(':c_gst', $data['c_gst']);
            if($this->db->execute())
                return true;
            else
                return false;
        }
    }
    public function get_order_count()
    {
        $this->db->query('SELECT * FROM invoices WHERE mh_id = :mh_id');
        $this->db->bind('mh_id', $_SESSION['mh_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
        $row = $this->db->resultSet();
        $count = $this->db->rowCount();
        return $count;
    }

    public function get_patient_count()
    {
        $this->db->query('SELECT * FROM patients WHERE mh_id = :mh_id');
        $this->db->bind('mh_id', $_SESSION['mh_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
        $this->db->resultSet();
        $count = $this->db->rowCount();
        return $count;
    }

    public function get_opd_count()
    {
        $this->db->query('SELECT * FROM opd WHERE mh_id = :mh_id');
        $this->db->bind('mh_id', $_SESSION['mh_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
        $this->db->resultSet();
        $count = $this->db->rowCount();
        return $count;
    }

    public function get_ipd_count()
    {
        $this->db->query('SELECT * FROM ipd WHERE mh_id = :mh_id');
        $this->db->bind('mh_id', $_SESSION['mh_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
        $this->db->resultSet();
        $count = $this->db->rowCount();
        return $count;
    }

    public function get_order_count_new()
    {
        $this->db->query('SELECT * FROM invoices WHERE mh_id = :mh_id');
        $this->db->bind('mh_id', $_SESSION['mh_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
        $row = $this->db->resultSet();
        return $row;
    }

    public function get_patient_count_new()
    {
        $this->db->query('SELECT * FROM patients WHERE mh_id = :mh_id');
        $this->db->bind('mh_id', $_SESSION['mh_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
        $row = $this->db->resultSet();
        return $row;
    }

    public function get_new_opd()
    {
        $this->db->query('SELECT * FROM opd WHERE mh_id = :mh_id');
        $this->db->bind('mh_id', $_SESSION['mh_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
        $row = $this->db->resultSet();
        return $row;
    }

    public function get_new_ipd()
    {
        $this->db->query('SELECT * FROM ipd WHERE mh_id = :mh_id');
        $this->db->bind('mh_id', $_SESSION['mh_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
        $row = $this->db->resultSet();
        return $row;
    }

    public function get_mem_data($user_id)
    {
        $this->db->query('SELECT * FROM users WHERE mem_id = :user_id');
        $this->db->bind(':user_id', $user_id);
        $row = $this->db->resultSet();
        return $row;
    }

    public function get_mem_data_single($user_id)
    {
        $this->db->query('SELECT * FROM users WHERE mem_id = :user_id');
        $this->db->bind(':user_id', $user_id);
        $row = $this->db->single();
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

    public function cancel_invoice_db($id)
    {
        $this->db->query('UPDATE invoices SET cancelled = 1 WHERE invoice_id = :id');
        $this->db->bind(':id', $id);
        $this->db->execute();
        return true;
    }

    public function get_patient_by_id_like($sear)
    {
        $this->db->query("SELECT * FROM patients WHERE mh_id = :mh_id AND active = 1 AND patient_id LIKE concat(:sear) LIMIT 1");
        $this->db->bind(':sear', $sear);
        $this->db->bind(':mh_id', $_SESSION['mh_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
        $row = $this->db->resultSet();
        return $row;
    }

    public function get_patient_by_id_like_rem($sear)
    {
        $this->db->query("SELECT * FROM patients WHERE active = 0 AND patient_id LIKE concat('%', :sear, '%') LIMIT 1");
        $this->db->bind(':sear', $sear);
        $row = $this->db->resultSet();
        return $row;
    }

    public function get_patient_by_name_like($sear)
    {
        $this->db->query("SELECT * FROM patients WHERE active = 1 AND mh_id = :mh_id AND patient_name LIKE concat('%', :sear, '%') LIMIT 5");
        $this->db->bind(':sear', $sear);
        $this->db->bind(':mh_id', $_SESSION['mh_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
        $row = $this->db->resultSet();
        return $row;
    }

    public function get_patient_by_name_like_rem($sear)
    {
        $this->db->query("SELECT * FROM patients WHERE active = 0 AND mh_id = :mh_id AND patient_name LIKE concat('%', :sear, '%') LIMIT 5");
        $this->db->bind(':sear', $sear);
        $this->db->bind(':mh_id', $_SESSION['mh_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
        $row = $this->db->resultSet();
        return $row;
    }

    public function get_patient_by_phone_like($sear)
    {
        $this->db->query("SELECT * FROM patients WHERE active = 1 AND mh_id = :mh_id AND patient_phone LIKE concat( :sear, '%') LIMIT 5");
        $this->db->bind(':sear', $sear);
        $this->db->bind(':mh_id', $_SESSION['mh_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
        $row = $this->db->resultSet();
        return $row;
    }

    public function get_patient_by_phone_like_rem($sear)
    {
        $this->db->query("SELECT * FROM patients WHERE mh_id = :mh_id AND active = 0 AND patient_phone LIKE concat('%', :sear, '%') LIMIT 5");
        $this->db->bind(':sear', $sear);
        $this->db->bind(':mh_id', $_SESSION['mh_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
        $row = $this->db->resultSet();
        return $row;
    }    

    public function remove_patient_db($id)
    {
        $this->db->query('UPDATE patients SET active = 0 WHERE patient_id = :id');
        $this->db->bind(':id', $id);
        if($this->db->execute())
            return true;
        else
            return false;
    }

    public function restore_patient_db($id)
    {
        $this->db->query('UPDATE patients SET active = 1 WHERE patient_id = :id');
        $this->db->bind(':id', $id);
        if($this->db->execute())
            return true;
        else
            return false;
    }

    public function update_admission_date($aid, $ad_date)
    {
        $this->db->query('UPDATE ipd SET admission_date_time = :ad_date WHERE ipd_admit_id = :aid');
        $this->db->bind(':aid', $aid);
        $this->db->bind(':ad_date', $ad_date);
        $this->db->execute();
        return true;
    }

    public function update_discharge_date($aid, $dis_date)
    {
        $this->db->query('UPDATE ipd SET discharge_date_time = :dis_date, discharge_status = :discharge_status WHERE ipd_admit_id = :aid');
        $this->db->bind(':aid', $aid);
        $this->db->bind(':dis_date', $dis_date);
        $this->db->bind(':discharge_status','2');
        $this->db->execute();
        return true;
    }

    public function get_admin_data($username, $password)
    {
        $this->db->query('SELECT user_password FROM auth WHERE user_name = :username');
        $this->db->bind(':username', $username);
        $row  = $this->db->single();
        if ($this->db->rowCount())
        {
            if($row->user_password == $password)
            {
                return 1;
            }

            else
            {
                return 2;// pass wrong
            }
        }

        else
        {
            return 0; // user wrong
        }
    }

    public function get_today_report($today_date, $lim, $off)
    {
        $this->db->query('SELECT * FROM invoices WHERE DATE(invoice_date) = :today_date limit :lim OFFSET :off');
        $this->db->bind(':today_date', $today_date);
        $this->db->bind(':lim', $lim);
        $this->db->bind(':off', $off);
        $row = $this->db->resultSet();
        return $row;
    }

    public function get_month_report($month_date,$today,$lim,$off)
    {
        $this->db->query('SELECT * FROM invoices WHERE DATE(invoice_date) BETWEEN :month_date AND :today limit :lim OFFSET :off');
        $this->db->bind(':month_date', $month_date);
        $this->db->bind(':today', $today);
        $this->db->bind(':lim', $lim);
        $this->db->bind(':off', $off);
        $row = $this->db->resultSet();
        return $row;
    }

    public function invoice_print_count_db($invoice_id)
    {
        $this->db->query('SELECT invoice_status FROM invoices WHERE invoice_id = :invoice_id');
        $this->db->bind(':invoice_id', $invoice_id);
        $row = $this->db->single();
        $status = $row->invoice_status;
        $status = explode(',', $status);
        $print = (int)$status[2];
        $print = $print + 1;
        $status[2] = $print;
        $status2 = implode(',', $status); 
        $this->db->query('UPDATE invoices SET invoice_status = :status2 WHERE invoice_id = :invoice_id');
        $this->db->bind(':status2', $status2);
        $this->db->bind(':invoice_id', $invoice_id);
        $this->db->execute();
        return true;
    }

    public function get_logo_details()
    {
        $this->db->query('SELECT * FROM service_provider ORDER BY ser_pro_id DESC LIMIT 1');
        $row = $this->db->resultSet();
        return $row;
    }

    public function get_all_orders_wrt_dates_db($start, $end)
    {
        $this->db->query('SELECT * FROM invoices WHERE mh_id = :mh_id AND (invoice_date BETWEEN :start AND :endd)');
        $this->db->bind(':start', $start);
        $this->db->bind(':endd', $end);
        $this->db->bind(':mh_id', $_SESSION['mh_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
        $row = $this->db->resultSet();
        return $row;
    }


    public function get_all_admissions_wrt_dates_db($start, $end)
    {
        $this->db->query('SELECT * FROM ipd WHERE admission_date_time BETWEEN :start AND :endd');
        $this->db->bind(':start', $start);
        $this->db->bind(':endd', $end);
        $row = $this->db->resultSet();
        return $row;
    }

    public function get_all_visit_wrt_dates_db($start, $end)
    {
        $this->db->query('SELECT * FROM opd WHERE visit_date_time BETWEEN :start AND :endd');
        $this->db->bind(':start', $start);
        $this->db->bind(':endd', $end);
        $row = $this->db->resultSet();
        return $row;
    }

   

    

    public function get_order_count_today($tdy)
    {
        $this->db->query('SELECT * FROM invoices WHERE date(invoice_date)=:tdy');
        $this->db->bind(':tdy', $tdy);
        $this->db->single();
        $count = $this->db->rowCount();
        return $count;
    }

    public function get_order_count_month($mnt, $mntl)
    {
        $this->db->query('SELECT * FROM invoices WHERE date(invoice_date) BETWEEN :mnt AND :mntl');
        $this->db->bind(':mnt', $mnt);
        $this->db->bind(':mntl', $mntl);
        $this->db->single();
        $count = $this->db->rowCount();
        return $count;
    }

    public function get_order_count_yr($yr, $yrl)
    {
        $this->db->query('SELECT * FROM invoices WHERE date(invoice_date) BETWEEN :yr AND :yrl');
        $this->db->bind(':yr', $yr);
        $this->db->bind(':yrl', $yrl);
        $this->db->single();
        $count = $this->db->rowCount();
        return $count;
    }

    public function get_order_count_cus($to, $frm)
    {
        $this->db->query('SELECT * FROM invoices WHERE date(invoice_date) BETWEEN :to AND :frm');
        $this->db->bind(':to', $to);
        $this->db->bind(':frm', $frm);
        $this->db->single();
        $count = $this->db->rowCount();
        return $count;
    }

    public function get_revenue_count($tdy)
    {
        $this->db->query('SELECT SUM(invoice_total) as total FROM invoices WHERE date(invoice_date)=:tdy');
        $this->db->bind(':tdy', $tdy);
        $total = $this->db->single();
        return $total;
    }

    public function get_revenue_count_month($mnt, $mntl)
    {
        $this->db->query('SELECT SUM(invoice_total) as total FROM invoices WHERE date(invoice_date) BETWEEN :mnt AND :mntl');
        $this->db->bind(':mnt', $mnt);
        $this->db->bind(':mntl', $mntl);
        $total = $this->db->single();
        return $total;
    }

    public function get_revenue_count_yr($yr, $yrl)
    {
        $this->db->query('SELECT SUM(invoice_total) as total FROM invoices WHERE date(invoice_date) BETWEEN :yr AND :yrl');
        $this->db->bind(':yr', $yr);
        $this->db->bind(':yrl', $yrl);
        $total = $this->db->single();
        return $total;
    }  

    public function get_revenue_count_cus($to, $frm)
    {
        $this->db->query('SELECT SUM(invoice_total) as total FROM invoices WHERE date(invoice_date) BETWEEN :to AND :frm');
        $this->db->bind(':to', $to);
        $this->db->bind(':frm', $frm);
        $total = $this->db->single();
        return $total;
    }  

    public function get_discount_count($tdy)
    {
        $this->db->query('SELECT SUM(invoice_discount) as dis FROM invoices WHERE date(invoice_date)=:tdy');
        $this->db->bind(':tdy', $tdy);
        $dis = $this->db->single();
        return $dis;
    }

    public function get_discount_count_month($mnt, $mntl)
    {
        $this->db->query('SELECT SUM(invoice_discount) as dis FROM invoices WHERE date(invoice_date) BETWEEN :mnt AND :mntl');
        $this->db->bind(':mnt', $mnt);
        $this->db->bind(':mntl', $mntl);
        $dis = $this->db->single();
        return $dis;
    } 

    public function get_discount_count_yr($yr, $yrl)
    {
        $this->db->query('SELECT SUM(invoice_discount) as dis FROM invoices WHERE date(invoice_date) BETWEEN :yr AND :yrl');
        $this->db->bind(':yr', $yr);
        $this->db->bind(':yrl', $yrl);
        $dis = $this->db->single();
        return $dis;
    }   

    public function get_discount_count_cus($to, $frm)
    {
        $this->db->query('SELECT SUM(invoice_discount) as dis FROM invoices WHERE date(invoice_date) BETWEEN :to AND :frm');
        $this->db->bind(':to', $to);
        $this->db->bind(':frm', $frm);
        $dis = $this->db->single();
        return $dis;
    } 

    public function get_patient_name_only_db($patient_id)
    {
        $this->db->query('SELECT patient_name FROM patients WHERE patient_id = :patient_id');
        $this->db->bind(':patient_id', $patient_id);
        $row = $this->db->single();
        return $row->patient_name;
    }

    public function get_doctor_name_only_db($doctor_id)
    {
        $this->db->query('SELECT doctor_name FROM doctors WHERE mem_id = :doctor_id');
        $this->db->bind(':doctor_id', $doctor_id);
        $name = $this->db->single();
        return $name->doctor_name;
    }
    public function get_doctor_spec_only_db($doctor_id)
    {
        $this->db->query('SELECT doctor_speciality FROM doctors WHERE mem_id = :doctor_id');
        $this->db->bind(':doctor_id', $doctor_id);
        $name = $this->db->single();
        return $name->doctor_speciality;
    }

    public function get_search_orders_active($inv_id)
    {
        $this->db->query('SELECT * FROM invoices WHERE mh_id = :mh_id AND invoice_id=:inv_id AND invoice_status = "saved"');
        $this->db->bind(':inv_id',$inv_id);
        $this->db->bind(':mh_id', $_SESSION['mh_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
        $row = $this->db->resultSet();
        return $row;
    }

    public function get_patient_orders_active($patient_name)
    {
        $this->db->query("SELECT * FROM invoices WHERE invoice_status = 'saved' AND invoice_name LIKE concat('%', :patient_name, '%') ORDER BY invoice_id DESC LIMIT 5 ");
        $this->db->bind(':patient_name',$patient_name);
        $row = $this->db->resultSet();
        return $row;
    }

    public function get_all_orders_wrt_dates_db_active($start, $end)
    {
        $this->db->query('SELECT * FROM invoices WHERE invoice_status = "saved" AND invoice_date BETWEEN :start AND :end');
        $this->db->bind(':start', $start);
        $this->db->bind(':end', $end);
        $row = $this->db->resultSet();
        return $row;
    }

    public function undo_cancel_db($id)
    {
        $this->db->query('UPDATE invoices SET cancelled = 0 WHERE invoice_id = :id');
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

    public function upload_file_from_visit_db($visit_id, $rep_tit, $files_array)
    {
        $date_rep = date('Y-m-d');
        $this->db->query('INSERT INTO reports (report_title, report_file_name, visit_id, report_date) VALUES(:rep_tit, :files_array, :visit_id, :date_rep)');
        $this->db->bind(':visit_id', $visit_id);
        $this->db->bind(':date_rep', $date_rep);
        $this->db->bind(':rep_tit', $rep_tit);
        $this->db->bind(':files_array', $files_array);
        if($this->db->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function upload_file_from_admit_db($visit_id, $rep_tit, $files_array)
    {
        $date_rep = date('Y-m-d');
        $this->db->query('INSERT INTO reports (report_title, report_file_name, admit_id, report_date) VALUES(:rep_tit, :files_array, :visit_id, :date_rep)');
        $this->db->bind(':visit_id', $visit_id);
        $this->db->bind(':date_rep', $date_rep);
        $this->db->bind(':rep_tit', $rep_tit);
        $this->db->bind(':files_array', $files_array);
        if($this->db->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function patient_photo_upload_db($files_array)
    {

        $this->db->query('SELECT patient_id FROM patients ORDER BY patient_id DESC LIMIT 1');
        $id = $this->db->single();
        $p_id = $id->patient_id;

        $this->db->query('UPDATE patients SET patient_photo = :files_array WHERE patient_id = :p_id');
        $this->db->bind(':files_array', $files_array);
        $this->db->bind(':p_id', $p_id);
        if($this->db->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function patient_photo_upload_db1($files_array,$patient_id)
    {
        
        $this->db->query('UPDATE patients SET patient_photo = :files_array WHERE patient_id = :p_id');
        $this->db->bind(':files_array', $files_array);
        $this->db->bind(':p_id', $patient_id);
        if($this->db->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function get_patient_ot_details()
    {
        
        $this->db->query('SELECT o.ot_id as ot_id,
        p.patient_id as patient_id, 
        p.patient_name as patient_name, 
        p.patient_gender as patient_gender, 
        p.patient_dob as patient_dob,  
        p.patient_age as patient_age,  
        p.patient_phone as patient_phone, 
        p.patient_email as patient_email, 
        p.patient_address as patient_address, 
        o.ip_op_ref as ip_op_ref, 
        d.mem_name as mem_name, 
        o.ot_date as ot_date, 
        o.ot_name as ot_name, 
        o.ot_description as ot_description, 
        o.status as status, 
        o.feedback as feedback, 
        i.admission_date_time as admission_date_time, 
        o.created_at as created_at 
        FROM ot o, patients p, users d, ipd i WHERE o.patient_id = p.patient_id AND o.ip_op_doc_ref_id = d.mem_id AND o.patient_id = i.ipd_patient_id ORDER BY o.ot_id');
        $row = $this->db->resultSet();
        return $row;
    }

    public function get_patient_ot_details_byid($id)
    {
        
        $this->db->query('SELECT o.ot_id as ot_id,
        p.patient_id as patient_id, 
        p.patient_name as patient_name, 
        p.patient_gender as patient_gender, 
        p.patient_dob as patient_dob,  
        p.patient_age as patient_age,  
        p.patient_phone as patient_phone, 
        p.patient_email as patient_email, 
        p.patient_address as patient_address, 
        o.ip_op_ref as ip_op_ref, 
        d.mem_name as mem_name, 
        o.ot_date as ot_date, 
        o.ot_name as ot_name, 
        o.ot_description as ot_description, 
        o.status as status, 
        o.feedback as feedback, 
        i.admission_date_time as admission_date_time, 
        o.created_at as created_at 
        FROM ot o, patients p, users d, ipd i WHERE o.patient_id = p.patient_id AND o.ip_op_doc_ref_id = d.mem_id AND o.patient_id = i.ipd_patient_id  AND o.ot_id = :id  ORDER BY o.ot_id');
         $this->db->bind(':id', $id); 
           $row = $this->db->single();
           return $row;
    }

     public function get_parent_service($ot_id)
    {
        $this->db->query('SELECT * FROM ot_services WHERE ot_ref_id = :ot_id');
        $this->db->bind(':ot_id', $ot_id);
        $row = $this->db->resultSet();
        return $row;
    }

     public function add_fix_service($s_name, $s_cost)
    {
        $this->db->query('INSERT INTO fix_op_service (name, cost,created_by) VALUES(:s_name, :s_cost, :created_by)');
        $this->db->bind(':s_name', $s_name);
        $this->db->bind(':s_cost', $s_cost);
        $this->db->bind(':created_by', $_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
       
        if($this->db->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public function get_fix_op_services()
    {
        $this->db->query('SELECT * FROM fix_op_service ');
        //$this->db->bind(':ot_id', $ot_id);
        $row = $this->db->resultSet();
        return $row;
    }

     public function delete_fix_service($id)
    {
        $this->db->query('DELETE FROM fix_op_service WHERE id=:id');
        $this->db->bind(':id',$id);
        if($this->db->execute())
            return true;
        else
            return false;
    }

     public function check_ip_name_exist_for_opd($p_name)
    {
        $this->db->query('SELECT * FROM ipd WHERE ipd_patient_id = :p_name AND discharge_status IS NULL AND mh_id = :mh_id');
        $this->db->bind(':p_name',$p_name);
        $this->db->bind(':mh_id', $_SESSION['mh_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
        $row = $this->db->resultSet();
        $count = $this->db->rowCount();
        return $count;
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

 public function doctor_name($id)
    {
        $this->db->query('SELECT doctor_name FROM doctors WHERE mem_id = :id');
        $this->db->bind(':id', $id);
        $name = $this->db->single();
        if($name == NULL)
        {
            return " not listed";
        }
        else
        {
            $name = $name->doctor_name;
            return 'Dr. '.$name;
        }
        
    }
    // public function doctor_name($id)
    // {
    //     $this->db->query('SELECT doctor_name FROM doctors WHERE mem_id = :id');
    //     $this->db->bind(':id', $id);
    //     $name = $this->db->single();
    //     $name = $name->doctor_name;
    //     return $name;
    // }
public function patient_name($id)
    {
        $this->db->query('SELECT patient_name FROM patients WHERE patient_id = :id');
        $this->db->bind(':id', $id);
        $name = $this->db->single();
        
        if($name == NULL)
        {
            return "no patient listed";
        }
        else
        {
            $nam = $name->patient_name;
            return $nam;
        }
    }

     public function auto_patient_name($cust)
    {
        $this->db->query("SELECT DISTINCT * from patients WHERE mh_id = :mh_id AND patient_name LIKE concat('%', :cust, '%') OR patient_id LIKE concat('%', :cust, '%') LIMIT 8");
        
        $this->db->bind(':mh_id', $_SESSION['mh_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
        $this->db->bind(':cust',$cust);
        $row = $this->db->resultSet();
        return $row;
    }
    //  public function patient_name($id)
    // {
    //     $this->db->query('SELECT patient_name FROM patients WHERE patient_id = :id');
    //     $this->db->bind(':id', $id);
    //     $name = $this->db->single();
    //     $nam = $name->patient_name;
    //     return $nam;
    // }

    
    public function get_all_orders_old($lim,$off)
    {
        $this->db->query('SELECT * FROM invoices_old ORDER BY invoice_id DESC limit :lim OFFSET :off');
        $this->db->bind(':lim',$lim);
        $this->db->bind(':off',$off);
        $row = $this->db->resultSet();
        return $row;
    }

    public function get_search_orders_old($inv_id)
    {
        $this->db->query('SELECT * FROM invoices_old WHERE invoice_id=:inv_id');
        $this->db->bind(':inv_id',$inv_id);
        $row = $this->db->resultSet();
        return $row;
    }

    public function get_patient_orders_old($patient_name)
    {
        $this->db->query("SELECT * FROM invoices_old WHERE invoice_name LIKE concat('%', :patient_name, '%') ORDER BY invoice_id DESC LIMIT 5 ");
        $this->db->bind(':patient_name',$patient_name);
        $row = $this->db->resultSet();
        return $row;
    }

    public function get_all_orders_wrt_dates_db_old($start, $end)
    {
        $this->db->query('SELECT * FROM invoices_old WHERE invoice_date BETWEEN :start AND :end');
        $this->db->bind(':start', $start);
        $this->db->bind(':end', $end);
        $row = $this->db->resultSet();
        return $row;
    }

    public function get_invoice_details_for_new_old()
    {
        $this->db->query('SELECT * FROM invoices_old ORDER BY invoice_id DESC LIMIT 1');
        $row = $this->db->resultSet();
        return $row;
    }

    public function get_patient_by_id_old($p_id)
    {
        $this->db->query('SELECT * FROM patients WHERE patient_name = :p_id');
        $this->db->bind(':p_id',$p_id);
        $row = $this->db->resultSet();
        return $row;
    }

    public function get_last_invoice_db($id)
    {
        $this->db->query('SELECT * FROM invoices_old WHERE invoice_id=:id');
        $this->db->bind(':id',$id);
        $row = $this->db->resultSet();
        return $row;
    }

    public function getServiceNameDb($id)
    {
        $this->db->query('SELECT service_name FROM services WHERE service_id = :id');
        $this->db->bind(':id', $id);
        $row = $this->db->single();
        return $row->service_name;
    }

    public function getThePatientPhone($ePId)
    {
        $this->db->query('SELECT patient_phone FROM patients WHERE patient_id = :ePId');
        $this->db->bind(':ePId', $ePId);
        $phone = $this->db->single();
        return $phone->patient_phone;
    }

    public function finishVisitDb($id)
    {
        $this->db->query('UPDATE opd SET visit_status = 1 WHERE opd_visit_id = :id');
        $this->db->bind(':id', $id);
        $this->db->execute();
        return true;
    }

    public function payBalanceDb($bal, $inv)
    {
        $this->db->query('SELECT amount_paid FROM invoices WHERE invoice_id = :inv');
        $this->db->bind(':inv', $inv);
        $balance = $this->db->single();
        $balance = (int)$balance->amount_paid;

        $bal = $bal + $balance;

        $this->db->query('UPDATE invoices SET amount_paid = :bal WHERE invoice_id = :inv');
        $this->db->bind(':bal', $bal);
        $this->db->bind(':inv', $inv);
        $this->db->execute();
        return true;
    }

    public function get_all_orders_bal($lim,$off)
    {
        $this->db->query('SELECT * FROM invoices WHERE amount_paid = invoice_total ORDER BY invoice_id DESC limit :lim OFFSET :off');
        $this->db->bind(':lim',$lim);
        $this->db->bind(':off',$off);
        $row = $this->db->resultSet();
        return $row;
    }
    
    public function get_all_orders_discount($lim,$off)
    {
        $this->db->query('SELECT * FROM invoices WHERE invoice_discount != :invoice_discount ORDER BY invoice_id DESC limit :lim OFFSET :off');
        $this->db->bind(':lim',$lim);
        $this->db->bind(':off',$off);
        $this->db->bind(':invoice_discount',0);
        
        $row = $this->db->resultSet();
        return $row;
    }

    public function getRoomsDb($name)
    {
        $this->db->query('SELECT * FROM beds WHERE bed_number LIKE concat("%", :name ,"%")');
        $this->db->bind(':name', $name);
        return $row = $this->db->resultSet();
    }
 
    public function saveInsuranceDb($agId, $agName)
    {
        $this->db->query('SELECT * FROM insurance WHERE insurance_id = :agId AND mh_id = :mh_id');
        $this->db->bind(':agId', $agId);
        $this->db->bind(':mh_id', $_SESSION['mh_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
        $row = $this->db->single();
        if($this->db->rowCount() > 0)
        {
            echo $_SESSION['ins_err'] = "Agency ID already exists";
            // return 4;
        }
        else
        {
            $this->db->query('INSERT INTO insurance (insurance_id, insurance_name, mh_id) VALUES(:agId, :agName, :mh_id)');
            $this->db->bind(':agId', $agId);
            $this->db->bind(':agName', $agName);
            $this->db->bind(':mh_id', $_SESSION['mh_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
            if($this->db->execute())
            {
                echo $_SESSION['ins_err'] = "Updated";
                // return 1;
            }
            else
            {
                echo $_SESSION['ins_err'] = "Error";
                // return 2;
            }
        }
    }

    public function getAllInsu($lim,$off)
    {
        $this->db->query('SELECT * FROM insurance WHERE mh_id = :mh_id ORDER BY i_id DESC limit :lim OFFSET :off');
        $this->db->bind(':lim',$lim);
        $this->db->bind(':off',$off);
        $this->db->bind(':mh_id', $_SESSION['mh_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
        $row = $this->db->resultSet();
        return $row;
    }

    public function getAllIns()
    {
        $this->db->query('SELECT * FROM insurance WHERE mh_id = :mh_id');
        $this->db->bind(':mh_id', $_SESSION['mh_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
        return $row = $this->db->resultSet();
    }

    public function updateTheInsuranceDb($admitId, $agId, $agName, $agExpiry)
    {
        $this->db->query('UPDATE ipd SET insurance_id = :agId, insurance_name = :agName, insurance_expiry = :agExpiry WHERE ipd_admit_id = :admitId');
        $this->db->bind(':admitId', $admitId);
        $this->db->bind(':agId', $agId);
        $this->db->bind(':agName', $agName);
        $this->db->bind(':agExpiry', $agExpiry);
        $this->db->execute();
        return true;
    }

    public function getIpdDays($id)
    {
        $this->db->query('SELECT * FROM ipd_days WHERE ipd_day_admit_id = :id');
        $this->db->bind(':id', $id);
        return $row = $this->db->resultSet();
    }

    public function getServiceNameFullDb($id)
    {
        $this->db->query('SELECT * FROM services WHERE service_id = :id');
        $this->db->bind(':id', $id);
        $row = $this->db->single();
        return $row;
    }

    public function getAllServiceProviderDetails()
    {
        $this->db->query('SELECT * FROM service_provider');
        return $row = $this->db->single();
    }

    public function saveBillPattern($pattern)
    {
        $this->db->query('SELECT * FROM service_provider');
        $row = $this->db->single();
        if($this->db->rowCount() > 0)
        {
            $this->db->query('UPDATE service_provider SET page_pattern = :pattern');
            $this->db->bind(':pattern', $pattern);
            $this->db->execute();
            return true;
        }
        else
        {
            $this->db->query('INSERT INTO service_provider (pattern) VALUES(:pattern)');
            $this->db->bind(':pattern', $pattern);
            $this->db->execute();
            return true;
        }
    }

    public function getTheDoctorPhoneAndEmail($doc_id)
    {
        $this->db->query('SELECT mem_email, mem_phone, mem_id FROM users WHERE mem_id = :doc_id');
        $this->db->bind(':doc_id', $doc_id);
        return $row = $this->db->single();
    }

    // public function getAllApppointments($lim, $off)
    // {
    //     $this->db->query('SELECT * FROM appointments WHERE mh_id = :mh_id ORDER BY a_id DESC limit :lim OFFSET :off');
    // 	$this->db->bind(':lim',$lim);
    //     $this->db->bind(':off',$off);
    //     $this->db->bind('mh_id', $_SESSION['mh_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
    // 	$row = $this->db->resultSet();
    // 	return $row;
    // }
    
    public function getAllApppointments()
    {
        $this->db->query('SELECT * FROM appointments ORDER BY a_id DESC');
    // 	$this->db->bind(':lim',$lim);
    //     $this->db->bind(':off',$off);
        // $this->db->bind('mh_id', $_SESSION['mh_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
    	$row = $this->db->resultSet();
    	return $row;
    }
    
    public function getAllCancelledApppointments()
    {
        $this->db->query('SELECT * FROM appointments where status = :status ORDER BY a_id DESC');
        
        $this->db->bind(':status', 0);
        	
    // 	$this->db->bind(':lim',$lim);
    //     $this->db->bind(':off',$off);
        // $this->db->bind('mh_id', $_SESSION['mh_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
    	$row = $this->db->resultSet();
    	return $row;
    }

    public function checkForThePatient($id)
    {
        $this->db->query('SELECT * FROM appointments WHERE a_id = :id');
        $this->db->bind(':id', $id);
        $row = $this->db->single();

        if($row->patient_phone_reg != NULL || !empty($row->patient_phone_reg) )
        {
            $this->db->query('UPDATE appointments SET status = 1');
            $this->db->execute();
            return true;
        }
        else 
        {
            $tempId = md5(uniqid());
            $this->db->query('INSERT INTO patients (patient_name, patient_phone, temp_id) VALUES(:pName, :pPhone, :tempId)');
            $this->db->bind(':pName', $row->patient_name);
            $this->db->bind(':pPhone', $row->patient_phone_unreg);
            $this->db->bind(':tempId', $tempId);
            $this->db->execute();

            $this->db->query('SELECT patient_id FROM patients WHERE temp_id = :tempId');
            $this->db->bind(':tempId', $tempId);
            $aPat = $this->db->single();

            $this->db->query('UPDATE appointments SET status = 1, patient_id = :pId WHERE a_id = :id');
            $this->db->bind(':pId', $aPat->patient_id);
            $this->db->bind(':id', $id);
            $this->db->execute();
            return true;
        }
    }

    public function converToVsitDb($id)
    {
        $this->db->query('SELECT * FROM appointments WHERE a_id = :id');
        $this->db->bind(':id', $id);
        return $row = $this->db->single();
    }

    public function converToAdmitDb($id)
    {
        $this->db->query('SELECT * FROM appointments WHERE a_id = :id');
        $this->db->bind(':id', $id);
        return $row = $this->db->single();
    }

    public function getTheLoginPage()
	{
		$this->db->query('SELECT client_title, login_photo FROM service_provider');
		return $row = $this->db->single();
    }
    
    public function getAllTheSpecialty()
    {
        $this->db->query('SELECT DISTINCT doctor_speciality FROM doctors');
        return $row = $this->db->resultSet();
    }

    // public function checkAppointment($data)
    // {
    //     $doc = explode('(', $data['docName']);
    //     $docName = $doc[0];
    //     $docI = explode(')', $doc[1]);
    //     $docId = $docI[0];
    //     $this->db->query('INSERT INTO appointments (patient_name, patient_phone, doctor_name, doctor_id, status, doctor_specialty, patient_id) VALUES(:patientName, :phoneNumberWithout, :docName, :docId, 0, :docSpec, :patientId)');
    //     $this->db->bind(':patientName', $data['patientName']);
    //     $this->db->bind(':phoneNumberWithout', $data['phoneNumberWithout']);
    //     $this->db->bind(':docName', $docName);
    //     $this->db->bind(':docId', $docId);
    //     $this->db->bind(':docSpec', $data['docSpec']);
    //     $this->db->bind(':patientId', $data['patientId']);
    //     if($this->db->execute())
    //     {
    //         return true;
    //     }
    //     else
    //     {
    //         die('Error');
    //     }
    // }
    
    public function checkAppointment($data)
    {
        $doc = explode('(', $data['docName']);
        $docName = $doc[0];
        $docI = explode(')', $doc[1]);
        $docId = $docI[0];
        $this->db->query('INSERT INTO appointments (patient_name, patient_phone, doctor_name, doctor_id, status, doctor_specialty, patient_id, appointment_time) VALUES(:patientName, :phoneNumberWithout, :docName, :docId, 0, :docSpec, :patientId, :appoint_date)');
        $this->db->bind(':patientName', $data['patientName']);
        $this->db->bind(':phoneNumberWithout', $data['phoneNumberWithout']);
        $this->db->bind(':docName', $docName);
        $this->db->bind(':docId', $docId);
        $this->db->bind(':docSpec', $data['docSpec']);
        $this->db->bind(':patientId', $data['patientId']);
        $this->db->bind(':appoint_date', $data['appoint_date']);
        
        if($this->db->execute())
        {
            return true;
        }
        else
        {
            die('Error');
        }
    }

    public function getAllTimeslots($dId)
	{
		$this->db->query('SELECT * FROM doctor_timeslot WHERE mem_id = :memId');
		$this->db->bind(':memId', $dId);
		return $row = $this->db->single();
    }

    public function getPatientRow($id)
    {
        $this->db->query('SELECT * FROM patients WHERE patient_id = :id');
        $this->db->bind(':id', $id);
        return $row = $this->db->single();
    }

    public function getAllPatientRow()
    {
        $this->db->query('SELECT * FROM patients');
        return $row = $this->db->resultSet();
    }

    public function getAllInvoiceLabRow()
    {
        $this->db->query('SELECT * FROM invoices WHERE department = 1');
        return $row = $this->db->resultSet();
    }

    public function getAllInvoiceRegRow()
    {
        $this->db->query('SELECT * FROM invoices WHERE department = 2');
        return $row = $this->db->resultSet();
    }

    public function getAllPharmInvoiceRow()
    {
        $this->db->query('SELECT * FROM invoice_pharms WHERE cancelled = 0');
        return $row = $this->db->resultSet();
    }

    public function checkForRecptionCount()
    {
        $this->db->query('SELECT * FROM users WHERE mem_type = "rec" AND mh_id = :mhId');
        $this->db->bind(':mhId', $_SESSION['mh_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
        $row = $this->db->single();
        if($this->db->rowCount() > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function get_verify_code_from_email($email)
    {
        $this->db->query('SELECT * FROM verify_email WHERE uname = :email');
          $this->db->bind(':email', $email);
        return $row = $this->db->single();
    }

    public function store_verification_code_status($email)
    {
        $this->db->query('UPDATE verify_email SET status = :status WHERE uname = :email');
        $this->db->bind(':email', $email);
        $this->db->bind(':status', '1');
        $this->db->execute();
    }

    public function getTheSubscription()
    {
        $this->db->query('SELECT * FROM subscriptions WHERE mem_id = :mem_id AND status = 1');
        $this->db->bind(':mem_id', $_SESSION['mh_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
        return $row = $this->db->single();
    }

    public function checkForPlan()
    {
        $this->db->query('SELECT * FROM subscriptions WHERE status = 1');
        $row = $this->db->single();

        if($row->plan_price_type == 1)
        {
            $checkDate = date('Y-m-d H:i:s', strtotime($row->end_date));
        }
        else
        {
            $checkDate = date('Y-m-d H:i:s', strtotime($row->trial_end_date));
        }

        $today = date('Y-m-d H:i:s');
        if($today > $checkDate)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function get_doctor_by_id_1($d_id)
    {
        $this->db->query('SELECT * FROM doctors WHERE mem_id = :d_id');
        $this->db->bind(':d_id',$d_id);
        $row = $this->db->single();
        return $row;
    }
    public function get_patient_by_id_1($p_id)
    {
        $this->db->query('SELECT * FROM patients WHERE patient_id = :p_id');
        $this->db->bind(':p_id',$p_id);
        $row = $this->db->single();
        return $row;
    }
    public function add_emergency_details($p_id,$d_id,$p_name,$d_name)
    {
        $this->db->query('INSERT INTO emergency(p_id, d_mem_id, p_name, d_name) VALUES (:p_id,:d_id,:p_name,:d_name)');
        $this->db->bind(':p_id', $p_id);
        $this->db->bind(':d_id', $d_id);
        $this->db->bind(':p_name', $p_name);
        $this->db->bind(':d_name', $d_name);
        if($this->db->execute())
        {
        return true;
        }
        else
        {
        die('Error');
        }  
    }
    public function get_all_emergency($lim,$off)
    {
        $this->db->query('SELECT * FROM emergency ORDER BY id DESC limit :lim OFFSET :off');
        $this->db->bind(':lim',$lim);
        $this->db->bind(':off',$off);
        // $this->db->bind(':mh_id', $_SESSION['mh_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
        $row = $this->db->resultSet();
        return $row;
    }
    public function get_single_emergency($id)
    {
        $this->db->query('SELECT * FROM emergency WHERE id=:id');
        // $this->db->bind(':lim',$lim);
        // $this->db->bind(':off',$off);
        $this->db->bind(':id', $id);
        $row = $this->db->single();
        return $row;
    }
     public function getTheRefLab()
    {
        $this->db->query('SELECT * FROM ref_lab');
        return $this->db->resultSet();
    }
     public function getTheLabName($ref_lab_id)
    {
        $this->db->query('SELECT ref_lab_name FROM ref_lab WHERE ref_lab_id = :ref_lab_id');
        $this->db->bind(':ref_lab_id', $ref_lab_id);
        return $this->db->single();
    }

    public function removeRefLabByIdDb($refId)
    {
        $this->db->query('DELETE FROM ref_lab WHERE ref_lab_id = :refId');
        $this->db->bind(':refId', $refId);
        if($this->db->execute())
        {
            return true;
        }
        else
        {
            die('Error');
        }
    }
    public function saveBirthCertificateDb($data)
    {
        $this->db->query('INSERT INTO birth_certificate (bc_name, bc_date_time, bc_gender, bc_reg_date, mother_name, father_name, address) VALUES(:name, :dateTime, :gender, :regDate, :motherName, :fatherName, :address)');
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':dateTime', $data['dateTime']);
        $this->db->bind(':gender', $data['gender']);
        $this->db->bind(':regDate', $data['regDate']);
        $this->db->bind(':motherName', $data['motherName']);
        $this->db->bind(':fatherName', $data['fatherName']);
        $this->db->bind(':address', $data['address']);
        
        if($this->db->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    public function addAmbulanceDb($name, $vehNumber, $seatsCapacity)
    {
        $this->db->query('INSERT INTO ambulance (vehicle_name, vehicle_number, seating_capacity, status, active) VALUES(:name, :vehNumber, :seatsCapacity, 0, 1) ');
        $this->db->bind(':name', $name);
        $this->db->bind(':vehNumber', $vehNumber);
        $this->db->bind(':seatsCapacity', $seatsCapacity);
        if($this->db->execute())
        {
            return true;
        }
        else
        {
            die('Error');
        }
    }

    public function getAllTheAmbulance($lim,$off)
    {
        $this->db->query('SELECT * FROM ambulance ORDER BY vehicle_id DESC LIMIT :lim OFFSET :off');
        $this->db->bind(':lim', $lim);
        $this->db->bind(':off', $off);
        return $this->db->resultSet();
    }
    
    public function inactiveAmbulance($id)
    {
        $this->db->query('UPDATE ambulance SET active = 0 WHERE vehicle_id = :id');
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

    public function activeAmbulance($id)
    {
        $this->db->query('UPDATE ambulance SET active = 1 WHERE vehicle_id = :id');
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

    public function getAllTheAmbulanceForService()
    {
        $this->db->query('SELECT * FROM ambulance WHERE status = 0 AND active = 1');
        return $row = $this->db->resultSet();
    }

    public function saveAssignAmbulanceDetailsInt($data)
    {
        $this->db->query('INSERT INTO ambulance_service(vehicle_id, patient_id, patient_name, driver_name, initial_reading, patient_condition, from_time, remarks, service_type, address, status) VALUES(:vehicleId, :pId, :pName, :driver, :irk, :condition, :fromTime, :remarks, :type,:address, 1)');
        $this->db->bind(':vehicleId', $data['vehicleId']);
        $this->db->bind(':pName', $data['pName']);
        $this->db->bind(':pId', $data['pId']);
        $this->db->bind(':driver', $data['driver']);
        $this->db->bind(':irk', $data['irk']);
        $this->db->bind(':condition', $data['condition']);
        $this->db->bind(':fromTime', $data['fromTime']);
        $this->db->bind(':remarks', $data['remarks']);
        $this->db->bind(':address', $data['address']);
        $this->db->bind(':type', $data['type']);
        if($this->db->execute())
        {
            return true;
        }
        else
        {
            die('Error');
        }
    }

    public function getAllAssignedAmbulance($lim, $off)
    {
        $this->db->query('SELECT * FROM ambulance_service ORDER BY as_id DESC LIMIT :lim OFFSET :off');
        $this->db->bind(':lim', $lim);
        $this->db->bind(':off', $off);
        return $row = $this->db->resultSet();
    }

    public function getAssignedService($id)
    {
        $this->db->query('SELECT * FROM ambulance_service WHERE as_id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function getTheVehicle($id)
    {
        $this->db->query('SELECT * FROM ambulance WHERE vehicle_id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function saveFinishServiceDetails($resource, $finalReading, $toTime, $id)
    {
        $this->db->query('UPDATE ambulance_service SET resource_name = :resource, to_time = :toTime, final_reading = :finalReading, status = 2 WHERE as_id = :id');
        $this->db->bind(':resource', $resource);
        $this->db->bind(':toTime', $toTime);
        $this->db->bind(':finalReading', $finalReading);
        $this->db->bind(':id', $id);
        if($this->db->execute())
        {
            return true;
        }
        else
        {
            die('Error');
        }
    }
     //******************************************************************************************
    public function get_all_emp()
    {
        $this->db->query('SELECT * FROM users');
        return $this->db->resultSet(); 
    }
    public function get_single_emp($id)
    {
        $this->db->query('SELECT * FROM users WHERE mem_id=:id');
        $this->db->bind(':id', $id);
        $row = $this->db->single();
        return $row;
    }
     public function get_permission_all()
    {
        $this->db->query('SELECT * FROM permissions');
        return $this->db->resultSet(); 
    }
    public function update_permissiondb($ps,$id)
    {
        $this->db->query('UPDATE users SET permissions=:permissions WHERE mem_id =:id');
        $this->db->bind(':id', $id);
        $this->db->bind(':permissions', $ps);
        if($this->db->execute())
        {
            return true;
        }
        else
        {
            die('Error');
        }
    }
     public function get_permissions_name($id)
    {
        $this->db->query('SELECT * FROM permissions WHERE id=:id');
        $this->db->bind(':id', $id);
        $row = $this->db->single();
        if(!empty($row))
        {
            return $row->permission;
        }else
        {
            return false;
        }
    }
    
    public function get_download_content(){


            $this->db->query('SELECT * from appointments');

          

            $result=$this->db->resultSet();

             return $result;
        }
        
    public function add_message_admin($s_name)
    {
        $this->db->query('INSERT into send_message (message) VALUES (:message)');
        
        $this->db->bind(':message',$s_name);
        
        if($this->db->execute())
            return true;
        else
            return false;
    }
    
    public function get_all_message()
    {
        $this->db->query('SELECT * FROM send_message');
        
        $row = $this->db->resultSet();
        return $row;
    }
    
    public function get_message_byId($id)
    {
        $this->db->query('SELECT * FROM send_message WHERE id=:id');
        
        $this->db->bind(':id', $id);
        
        $row = $this->db->single();
        return $row;
    }
    
    public function update_message_admin($s_name, $message_id)
    {
        $this->db->query('UPDATE send_message SET message=:message WHERE id =:message_id');
        
        $this->db->bind(':message',$s_name);
        $this->db->bind(':message_id',$message_id);
        
        if($this->db->execute())
            return true;
        else
            return false;
    }
    
    public function get_all_invoice_ip($id)
    {
        $this->db->query('SELECT * FROM invoices WHERE opip_id = :id');
        $this->db->bind(':id',$id);
        $row = $this->db->resultSet();
        return $row;
    }

	public function get_the_created_name($created_by)
	{
		$this->db->query('SELECT mem_name FROM users WHERE mem_id = :created_by');
		$this->db->bind(':created_by', $created_by);
		$row = $this->db->single();
		if($row)
		{
			return $row->mem_name;
		}
		else
		{
			return NULL;
		}
	}
    
	public function save_advanced_receipt($date_time, $amount, $patient_id, $admit_id, $payment_type)
	{
		$this->db->query('INSERT INTO advance (patient_id, admit_id, created_date_time, amount, created_by, payment_type) VALUES(:patient_id, :admit_id, :date_time, :amount, :created_by, :payment_type)');
		$this->db->bind(':patient_id', $patient_id);
		$this->db->bind(':admit_id', $admit_id);
		$this->db->bind(':date_time', $date_time);
		$this->db->bind(':amount', $amount);
		$this->db->bind(':payment_type', $payment_type);
		$this->db->bind(':created_by', $_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);

		$this->db->execute();
		return true;
	}

	public function get_all_receipt($patient_id, $admit_id)
	{
		$this->db->query('SELECT * FROM advance WHERE patient_id = :patient_id AND admit_id = :admit_id');
		$this->db->bind(':patient_id', $patient_id);
		$this->db->bind(':admit_id', $admit_id);
		return $this->db->resultSet();
	}

	public function get_the_advance_receipt_details($id)
	{
		$this->db->query('SELECT * FROM advance WHERE id = :id');
		$this->db->bind(':id', $id);
		return $this->db->single();
	}

	public function save_ipd_discharge_summary($discharge_type, $remark, $x_admit_id)
	{
		$this->db->query('UPDATE ipd SET discharge_type = :discharge_type, remark = :remark WHERE ipd_admit_id = :x_admit_id');
		$this->db->bind(':discharge_type', $discharge_type);
		$this->db->bind(':remark', $remark);
		$this->db->bind(':x_admit_id', $x_admit_id);
		$this->db->execute();
		return true;
	}

	public function get_the_invoice_for_general($id)
	{
		$id = "IP".$id;
		$this->db->query('SELECT * FROM invoices WHERE opip_id = :id AND department = 2');
		$this->db->bind(':id', $id);
		return $this->db->resultSet();
	}	

	public function get_the_invoice_for_lab($id)
	{
		$id = "IP".$id;
		$this->db->query('SELECT * FROM invoices WHERE opip_id = :id AND department = 1');
		$this->db->bind(':id', $id);
		return $this->db->resultSet();
	}	

	public function get_the_invoice_for_pharm($id)
    {
		$id = "IP".$id;
        $this->db->query('SELECT * FROM invoice_pharms WHERE ip_op = :id');
        $this->db->bind(':id', $id);
        $row = $this->db->resultSet();
        return $row;
    }

	public function get_manf_name_db($id)
    {
        $this->db->query('SELECT drug_manufacturer FROM drugs WHERE drug_id =:id');
        $this->db->bind(':id', $id);
        $row = $this->db->single();
        return $row;
    }

	public function get_stock_details($id)
    {
        $this->db->query('SELECT * FROM stocks WHERE stock_batch = :id');
        $this->db->bind(':id', $id);
        $row = $this->db->resultSet();
        return $row;
    }

	public function get_the_service_type_by_service_name($service_name)
	{
		$this->db->query('SELECT * FROM services WHERE service_name = :service_name');
		$this->db->bind(':service_name', $service_name);
		$service_name = $this->db->single();
		return $service_name->service_type;
	}

	public function get_the_advance_sum($id)
	{
		$this->db->query('SELECT SUM(amount) as s FROM advance WHERE admit_id = :id');
		$this->db->bind(':id', $id);
		$sum = $this->db->single();

		return $sum->s;
	}

	public function get_all_receipts($admit_id)
	{
		$this->db->query('SELECT * FROM advance WHERE admit_id = :admit_id');
		$this->db->bind(':admit_id', $admit_id);
		return $this->db->resultSet();
	}
}
?>
