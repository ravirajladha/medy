<?php
class Doctor
{
	private $db;

	public function __construct()
	{
		$this->db = new Database;
	}

	public function get_all_doctors($lim,$off)
	{
		$this->db->query('SELECT * FROM doctors ORDER BY doctor_id DESC limit :lim OFFSET :off');
		$this->db->bind(':lim',$lim);
        $this->db->bind(':off',$off);
		$row = $this->db->resultSet();
		return $row;
	}

	public function get_doc_ph_email($mem_id)
    {
    	$this->db->query('SELECT * FROM users WHERE mem_id = :mem_id');
    	$this->db->bind(':mem_id',$mem_id);
    	$row = $this->db->single();
    	return $row;
    }


	public function get_all_ot()
    {
    	$this->db->query('SELECT * FROM ot');
    	$row = $this->db->resultSet();
    	return $row;
    }
    
	public function get_all_ipd($lim,$off)
	{
		$this->db->query('SELECT * FROM ipd WHERE ipd_doctor_id = :doc_id ORDER BY ipd_admit_id DESC limit :lim OFFSET :off');
		$this->db->bind(':lim',$lim);
		$this->db->bind(':off',$off);
		$this->db->bind(':doc_id', $_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
		$row = $this->db->resultSet();
		return $row;
	}


	public function get_all_opd($lim,$off)
	{
		$doc_id = $_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no'];
		$this->db->query('SELECT DISTINCT opd_patient_id FROM opd WHERE opd_doctor_id = :doc_id and visit_status = 1 ORDER BY opd_visit_id DESC limit :lim OFFSET :off');
		$this->db->bind(':doc_id', $doc_id);
		$this->db->bind(':lim', $lim);
        $this->db->bind(':off', $off);
        $row = $this->db->resultSet();
		return $row;
	}

	public function get_all_opd_only_visit_id($p_id)
	{
		$this->db->query('SELECT * FROM opd WHERE opd_patient_id = :p_id ');
		$this->db->bind(':p_id', $p_id);
		$row = $this->db->single();
		return $row;
	}

	public function get_patient_by_id($p_id)
    {
        $this->db->query('SELECT * FROM patients WHERE patient_id = :p_id');
        $this->db->bind(':p_id',$p_id);
        $row = $this->db->resultSet();
        return $row;
    }

	public function get_all_opd_pat($lim,$off)
	{
		$this->db->query('SELECT * FROM opd ORDER BY opd_visit_id DESC limit :lim OFFSET :off');
		$this->db->bind(':lim', $lim);
        $this->db->bind(':off', $off);
		$row = $this->db->resultSet();
		return $row;
	}

	public function get_all_opd_patients($lim,$off)
	{
		$this->db->query('SELECT * FROM opd ORDER BY opd_visit_id DESC limit :lim OFFSET :off');
		$this->db->bind(':lim',$lim);
        $this->db->bind(':off',$off);
		$row = $this->db->resultSet();
		return $row;
	}

	public function get_all_doctors_search($search)
	{
		$this->db->query("SELECT * from doctors WHERE doctor_name LIKE concat('%', :search, '%') OR doctor_id LIKE concat('%', :search, '%') LIMIT 4");
        $this->db->bind(':search',$search);
        $row = $this->db->resultSet();
        return $row;
	} 

	public function get_all_ipd_search($search)
	{
		$this->db->query("SELECT * from ipd WHERE doctor_name LIKE concat('%', :search, '%') OR doctor_id LIKE concat('%', :search, '%') LIMIT 4");
        $this->db->bind(':search',$search);
        $row = $this->db->resultSet();
        return $row;
	} 

	public function get_op_visit($lim,$off)
	{
		$d_id = $_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no'];
		$this->db->query('SELECT * FROM opd WHERE visit_status = 0  AND opd_doctor_id = :d_id ORDER BY visit_date_time ASC limit :lim OFFSET :off');
		$this->db->bind(':lim',$lim);
        $this->db->bind(':off',$off);
        $this->db->bind(':d_id',$d_id);
		$row = $this->db->resultSet();
		return $row;
	}

	public function get_opd_patient_id($pid,$opdid)
	{
		$this->db->query('SELECT * FROM opd WHERE opd_visit_id = :opdid AND opd_patient_id = :pid');
		$this->db->bind(':pid',$pid);
		$this->db->bind(':opdid',$opdid);
		$row = $this->db->resultSet();	
		return $row;
	}

	public function get_opd_patient_id2($pid)
	{
		$this->db->query('SELECT * FROM opd WHERE opd_patient_id = :pid and visit_status = 1');
		$this->db->bind(':pid',$pid);
		$row = $this->db->resultSet();	
		return $row;
	}

	public function get_ipd_past_admit_dates($pid)
	{
		$this->db->query('SELECT * FROM ipd WHERE ipd_patient_id = :pid');
		$this->db->bind(':pid',$pid);
		$row = $this->db->resultSet();	
		return $row;
	}

	public function get_ipd_past_admit_dates_rows($pid)
	{
		$this->db->query('SELECT * FROM ipd WHERE ipd_patient_id = :pid');
		$this->db->bind(':pid',$pid);
		$row = $this->db->resultSet();
		$count = $this->db->rowCount();

		return $count;
	}


	public function save_present_visit_db($allergy_cond, $pres_cond, $exam_det, $inv_det, $other_inf, $diag, $inst, $tst_adv, $f_up_date, $n_reg_fee, $prescription, $opdid, $pid, $proc, $advice)
	{
		$dt = new DateTime("now", new DateTimeZone('Asia/Calcutta'));
      	$dat = $dt->format('Y/m/d H:i:s');
		$this->db->query('UPDATE opd SET opd_present_condition = :pres_cond, opd_examination = :exam_det, opd_investigation = :inv_det, opd_notes = :other_inf, opd_diagnosis = :diag, opd_prescription = :prescription, opd_instruction = :inst, opd_test_advised = :tst_adv, opd_followup_date = :f_up_date, opd_visit_fee = :n_reg_fee, visit_date_time = :dat, opd_prescription_procedure = :proc, visit_status = 1, q_clr_status = :q_clr_status, opd_allergy_cond = :allergy_cond, advice = :advice  WHERE opd_visit_id = :opdid AND opd_patient_id = :pid');
		$this->db->bind(':allergy_cond', $allergy_cond);
		$this->db->bind(':pres_cond', $pres_cond);
		$this->db->bind(':exam_det', $exam_det);
		$this->db->bind(':inv_det', $inv_det);
		$this->db->bind(':other_inf', $other_inf);
		$this->db->bind(':diag', $diag);
		$this->db->bind(':prescription', $prescription);
		$this->db->bind(':inst', $inst);
		$this->db->bind(':tst_adv', $tst_adv);
		$this->db->bind(':f_up_date', $f_up_date);
		$this->db->bind(':n_reg_fee', $n_reg_fee);
		$this->db->bind(':opdid', $opdid);
		$this->db->bind(':pid', $pid);
		$this->db->bind(':dat', $dat);
		$this->db->bind(':proc', $proc);
		$this->db->bind(':q_clr_status', 1);
		$this->db->bind(':advice', $advice);
		if($this->db->execute())
		{
			unset($_SESSION['procedure']);
			return true;
		}
		else
		{
			return false;
		}
	}


	public function save_co_morbidities_db($id,$hyp,$dia_mel,$cor_art_dis,$cdpvd,$dys,$hypo,$oacd)
	{
		$this->db->query('UPDATE patients SET hypertension = :hyp, diabetes = :dia_mel, coronary = :cor_art_dis, cerebro = :cdpvd, dyslipidaemia = :dys, hypothyroidism = :hypo, other = :oacd WHERE patient_id = :id');
		$this->db->bind(':hyp', $hyp);
		$this->db->bind(':id', $id);
		$this->db->bind(':dia_mel', $dia_mel);
		$this->db->bind(':cor_art_dis', $cor_art_dis);
		$this->db->bind(':cdpvd', $cdpvd);
		$this->db->bind(':dys', $dys);
		$this->db->bind(':hypo', $hypo);
		$this->db->bind(':oacd', $oacd);
		if($this->db->execute())
		{
			return false;
		}
		else
		{
			return true;
		}
	}


	public function save_pat_his_db($past_his,$fam_his,$id, $mon, $year)
	{
		$this->db->query('SELECT * FROM patients WHERE patient_id = :id');
		$this->db->bind(':id', $id);
		$pat = $this->db->single();

		$patient_history = $pat->patient_history;
		$patient_history_year = $pat->patient_history_year;
		$patient_history_mon = $pat->patient_history_mon;

		if($patient_history != NULL)
		{
			$past_his = $past_his.','.$patient_history;
			$year = $year.','.$patient_history_year;
			$mon = $mon.','.$patient_history_mon;
		}

		$this->db->query('UPDATE patients SET patient_history = :past_his, family_history = :fam_his, patient_history_mon = :mon, patient_history_year = :year WHERE patient_id = :id');
		$this->db->bind(':past_his', $past_his);
		$this->db->bind(':fam_his', $fam_his);
		$this->db->bind(':id', $id);
		$this->db->bind(':mon', $mon);
		$this->db->bind(':year', $year);
		if($this->db->execute())
		{
			return false;
		}
		else
		{
			return true;
		}
	}

	public function save_report_db($data)
	{
		$dt = new DateTime("now", new DateTimeZone('Asia/Calcutta'));
      	$dat = $dt->format('Y/m/d');
		$this->db->query('INSERT INTO reports (report_title, report_file_name, admit_id, report_date) VALUES (:original_file_name, :file_name, :report_id, :dat)');
		$this->db->bind(':original_file_name', $data['original_file_name']);
		$this->db->bind(':file_name', $data['file_name']);
		$this->db->bind(':report_id', $data['report_id']);
		$this->db->bind(':dat', $dat);
		if($this->db->execute())
		{
			return false;
		}
		else
		{
			return true;
		}
	}

	public function get_doc_name($id)
	{
		$this->db->query('SELECT doctor_name FROM doctors WHERE mem_id = :id');
		$this->db->bind(':id', $id);
		$o = $this->db->resultSet();
		return $o;
	}

	public function get_count_db()
	{
		$doc_id = $_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no'];
		$this->db->query('SELECT * FROM opd WHERE visit_status = 0 AND opd_doctor_id = :doc_id');
		$this->db->bind(':doc_id', $doc_id);
		$this->db->resultSet();
		$count = $this->db->rowCount();
		return $count;
	}

	public function get_all_prescription($lim,$off)
	{
		$this->db->query('SELECT * FROM opd WHERE visit_status = 1 AND mh_id = :mh_id ORDER BY opd_visit_id DESC limit :lim OFFSET :off');
		$this->db->bind(':lim',$lim);
		$this->db->bind(':off',$off);
		$this->db->bind(':mh_id', $_SESSION['mh_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
		$row = $this->db->resultSet();
		return $row;
	}

	public function get_all_prescription_ph($lim,$off)
	{
		$this->db->query('SELECT * FROM opd ORDER BY opd_visit_id DESC limit :lim OFFSET :off');
		$this->db->bind(':lim',$lim);
		$this->db->bind(':off',$off);
		$row = $this->db->resultSet();
		return $row;
	}

	public function get_all_prescription_pat($lim,$off)
	{
		$pid = $_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no'];
		$this->db->query('SELECT * FROM opd WHERE visit_status = 1 AND opd_patient_id = :pid AND mh_id = :mh_id ORDER BY opd_visit_id DESC limit :lim OFFSET :off ');
		$this->db->bind(':lim',$lim);
        $this->db->bind(':off',$off);
		$this->db->bind(':pid', $pid);
		$this->db->bind(':mh_id', $_SESSION['mh_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
		$row = $this->db->resultSet();
		return $row;
	}


	public function get_all_prescription_admit($lim,$off)
	{
		$this->db->query('SELECT * FROM ipd ORDER BY ipd_admit_id DESC limit :lim OFFSET :off ');
		$this->db->bind(':lim',$lim);
        $this->db->bind(':off',$off);
		$row = $this->db->resultSet();
		return $row;
	}

	public function prescription_search_by_id_db($visit_id)
	{
		$this->db->query("SELECT * from opd WHERE mh_id = :mh_id AND opd_visit_id LIKE concat('%', :visit_id, '%') LIMIT 1");
		$this->db->bind(':visit_id', $visit_id);
		$this->db->bind(':mh_id', $_SESSION['mh_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
		$row = $this->db->resultSet();
		return $row;
	}

	public function prescription_search_by_name_db($pat_name)
	{
		$this->db->query("SELECT patients.patient_name,opd.opd_visit_id, opd.opd_patient_id, opd.opd_doctor_id FROM patients INNER JOIN opd ON patients.patient_id = opd.opd_patient_id AND patients.patient_name LIKE concat('%', :pat_name, '%') LIMIT 5");
		$this->db->bind(':pat_name', $pat_name);
		$row = $this->db->resultSet();
		return $row;
	}

	public function prescription_search_by_phone_db($pat_name)
	{
		$this->db->query("SELECT patients.patient_name,opd.opd_visit_id, opd.opd_patient_id, opd.opd_doctor_id FROM patients INNER JOIN opd ON patients.patient_id = opd.opd_patient_id AND patients.patient_phone LIKE concat('%', :pat_name, '%') LIMIT 5");
		$this->db->bind(':pat_name', $pat_name);
		$row = $this->db->resultSet();
		return $row;
	}

	public function get_opd_data($id)
	{
		$this->db->query('SELECT * FROM opd WHERE opd_visit_id = :id');
		$this->db->bind(':id', $id);
		$row = $this->db->resultSet();
		return $row;
	}

	public function get_ipd_data_print($id)
	{
		$this->db->query('SELECT * FROM ipd WHERE ipd_admit_id = :id');
		$this->db->bind(':id', $id);
		$row = $this->db->resultSet();
		return $row;
	}

	public function auto_patient_name_doc($cust)
    {
		$this->db->query("SELECT patient_name, patient_id from patients WHERE patient_name LIKE concat('%', :cust, '%') LIMIT 200");
		$this->db->bind(':cust',$cust);
		$row = $this->db->resultSet();
		return $row;
    }

    public function get_all_op_patients()
    {
    	$doc_id = $_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no'];
    	$this->db->query('SELECT * FROM opd WHERE opd_doctor_id = :doc_id');
    	$this->db->bind(':doc_id', $doc_id);
    	$row = $this->db->resultSet();
    	return $row;
    }
     public function findtestnamewithid($id)
    {
    	$this->db->query('SELECT * FROM lab_test_values WHERE lab_test_value_id = :id');
    	$this->db->bind(':id', $id);
    	$row = $this->db->single();
    	return $row;
    }

     public function find_price_from_test_avaliable($id)
    {
    	$this->db->query('SELECT * FROM lab_tests_available WHERE test_id = :id');
    	$this->db->bind(':id', $id);
    	$row = $this->db->single();
    	return $row;    		
    }

    public function find_price_from_test_avaliable_id($id)
    {
    	$this->db->query('SELECT * FROM lab_tests_available WHERE test_id = :id');
    	$this->db->bind(':id', $id);
    	$row = $this->db->resultSet();
    	$count = $this->db->rowCount();
    	if($count==0)
    	{
    		return false;
    	}
    	else
    	{
    	return $count;    	
    	}
    }
    
    public function getpatientname($id)
    {
    	$this->db->query('SELECT * FROM patients WHERE patient_id = :id');
    	$this->db->bind(':id', $id);
    	$row = $this->db->single();
    	return $row;    		
    }

 	public function addtstadvtoinvoice($data)
    {
    	$this->db->query('INSERT INTO `invoices`(`invoice_item`,  `invoice_name`, `invoice_doctor`, `invoice_status`, `opip_id`, `department`) VALUES (:invoice_item, :invoice_name, :invoice_doctor, :invoice_status, :opdidwithop, :department)');

    	$this->db->bind(':invoice_item', $data['invoice_item']);
    	//$this->db->bind(':opip_id', $data['opip_id']);
    	$this->db->bind(':invoice_name', $data['invoice_name']);
    	$this->db->bind(':invoice_doctor', $data['invoice_doctor']);
    	$this->db->bind(':invoice_status', "saved");
    	$this->db->bind(':opdidwithop', $data['opdidwithop']);
    	$this->db->bind(':department', 1);
    	$a = $this->db->execute();
    	return $a;
    	}
			
		// $this->db->query('SELECT * from `invoices` WHERE invoice_item=:invoice_item and invoice_name=:invoice_name and invoice_doctor=:invoice_doctor and invoice_status=:invoice_status and department=:department and invoice_date=:dat');

    	public function get_last_entered_id($data2)
    	{
			$this->db->query('SELECT * from `invoices` WHERE invoice_item=:invoice_item and invoice_name=:invoice_name and invoice_doctor=:invoice_doctor and invoice_status=:invoice_status and department=:department ORDER BY invoice_id DESC');

			$this->db->bind(':invoice_item', $data2['invoice_item']);    	
			$this->db->bind(':invoice_name', $data2['invoice_name']);
			$this->db->bind(':invoice_doctor', $data2['invoice_doctor']);
			$this->db->bind(':invoice_status', "saved");
			$this->db->bind(':department', "1");
			//$this->db->bind('dat',date('Y-m-d h:i:s',time()));
			$p = $this->db->single();
			return $p;
    	}
     	

     	public function addtstadvtolab_test($data1)
    	{
	    	$this->db->query('INSERT INTO `lab_tests`(`lab_test_ref_id`, `lab_test_order_id`, `lab_test_date_time`) VALUES (:lab_test_ref_id, :lab_test_order_id, :lab_test_date_time)');
	    	$this->db->bind(':lab_test_ref_id', $data1['lab_test_ref_id']);
	    	$this->db->bind(':lab_test_order_id', $data1['lab_test_order_id']);
	    	$this->db->bind(':lab_test_date_time', date('Y-m-d h:i:s',time()));
	    	$r = $this->db->execute();
	    	return $r;
    	}

    public function save_active_invoice($medicine,$pid,$d1)
    {
    	$this->db->query('INSERT INTO invoice_pharms (invoice_items, invoice_status,invoice_name,invoice_doctor) VALUES (:medicine, 1, :pid, :d1)');
    	$this->db->bind(':medicine', $medicine);
    	$this->db->bind(':pid', $pid);
    	$this->db->bind(':d1', $d1);
    	if($this->db->execute())
    		return true;
    	else
    		return false;
    }

    public function get_patient_data_m($pid)
    {
    	$this->db->query('SELECT patients.patient_id, patients.patient_name, patients.patient_gender, patients.patient_dob, patients.patient_email, patients.patient_phone, patients.patient_address,patients.hypertension, patients.diabetes, patients.coronary, patients.cerebro, patients.dyslipidaemia, patients.hypothyroidism, patients.other, patients.patient_history, patients.family_history,patients.patient_history_mon, patients.patient_history_year, ipd.ipd_admit_id, ipd.ipd_bed_id, ipd.ipd_doctor_id, ipd.admission_date_time FROM patients INNER JOIN ipd ON ipd.ipd_patient_id = patients.patient_id WHERE patient_id = :pid');
    	$this->db->bind(':pid', $pid);
    	$p_data = $this->db->resultSet();
    	return $p_data;
    }

    public function ipd_day_insert($admit_id, $new_date)
    {
    	if($admit_id != NULL && $new_date != NULL)
    	{
    		$today = date('Y-m-d');
	    	$this->db->query('SELECT * FROM ipd_days WHERE ipd_day_admit_id = :admit_id AND ipd_day_val = :new_date');
	    	$this->db->bind(':admit_id', $admit_id);
	    	$this->db->bind(':new_date', $new_date);
	    	$row = $this->db->resultSet();
	    	$count = $this->db->rowCount();
	    	if($count == 0)
	    	{
	    		if($today == $new_date)
	    		{
	    			$this->db->query('INSERT INTO ipd_days (ipd_day_admit_id, ipd_day_val) VALUES(:admit_id, :new_date)');
		    		$this->db->bind(':admit_id', $admit_id);
		    		$this->db->bind(':new_date', $new_date);
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
	    			while($new_date <= $today)
	    			{
	    				$this->db->query('INSERT INTO ipd_days (ipd_day_admit_id, ipd_day_val) VALUES(:admit_id, :new_date)');
	    				$this->db->bind(':new_date', $new_date);
	    				$this->db->bind(':admit_id', $admit_id);
	    				$this->db->execute();
	    				$new_date = strtotime("+1 day", strtotime($new_date));
	    				$new_date = date('Y-m-d', $new_date);
	    			}
	    			return true;
	    		}
	    	}

	    	else
	    	{
	    		while($new_date <= $today)
				{
					$this->db->query('SELECT * FROM ipd_days WHERE ipd_day_admit_id = :admit_id AND ipd_day_val = :new_date');
					$this->db->bind(':admit_id', $admit_id);
					$this->db->bind(':new_date', $new_date);
					$this->db->resultSet();
					$check = $this->db->rowCount();
					if($check == 0)
					{
						$this->db->query('INSERT INTO ipd_days (ipd_day_admit_id, ipd_day_val) VALUES(:admit_id, :new_date)');
						$this->db->bind(':new_date', $new_date);
						$this->db->bind(':admit_id', $admit_id);
						$this->db->execute();
					}
					$new_date = strtotime("+1 day", strtotime($new_date));
					$new_date = date('Y-m-d', $new_date);
				}
				return true;
	    	}
    	}
    }


    public function get_ipd_days($admit_id)
    {
    	$this->db->query('SELECT * FROM ipd_days WHERE ipd_day_admit_id = :admit_id');
    	$this->db->bind(':admit_id', $admit_id);
    	$row = $this->db->resultSet();
    	return $row;
    }

    public function insert_days_details($day, $init_cond , $fir_exm, $fir_inv, $fir_diag, $init_test, $init_notes, $inst, $admit_id)
    {
    	$this->db->query('UPDATE ipd_days SET ipd_day_condition = :init_cond, ipd_day_examination = :fir_exm, ipd_day_investigation = :fir_inv, ipd_day_diagnosis = :fir_diag, ipd_day_test_advised = :init_test, ipd_day_notes = :init_notes, ipd_day_instruction = :inst WHERE ipd_day_val = :day AND ipd_day_admit_id = :admit_id');
    	$this->db->bind(':day', $day);
    	$this->db->bind(':init_cond', $init_cond);
    	$this->db->bind(':fir_exm', $fir_exm);
    	$this->db->bind(':fir_inv', $fir_inv);
    	$this->db->bind(':fir_diag', $fir_diag);
    	$this->db->bind(':init_test', $init_test);
    	$this->db->bind(':init_notes', $init_notes);
    	$this->db->bind(':inst', $inst);
    	$this->db->bind(':admit_id', $admit_id);
    	if($this->db->execute())
    	{
    		return true;
    	}
    	else
    	{
    		return false;
    	}

    }

    public function save_medication_db($prescription,$proc,$admit_id)
    {
    	$today = date('Y-m-d');
    	$this->db->query('SELECT ipd_day_procedure, ipd_day_prescription FROM ipd_days WHERE ipd_day_admit_id = :admit_id AND ipd_day_val = :today');
    	$this->db->bind(':admit_id', $admit_id);
    	$this->db->bind(':today', $today);
    	$row = $this->db->resultSet();
    	foreach ($row as $key)
    	{
    		$pres = $key->ipd_day_prescription;
    		$pros = $key->ipd_day_procedure;
    	}
		if($pres == null OR $pres == "$$")
		{
			$this->db->query('UPDATE ipd_days SET ipd_day_prescription = :prescription, ipd_day_procedure = :proc WHERE ipd_day_admit_id = :admit_id and ipd_day_val = :today');
	    	$this->db->bind(':prescription', $prescription);
	    	$this->db->bind(':proc', $proc);
	    	$this->db->bind(':admit_id', $admit_id);
	    	$this->db->bind(':today', $today);
	    	if($this->db->execute())
	    	{
	    		unset($_SESSION['procedure']);
	    		return true;
	    	}
	    	else
	    	{
	    		return false;
	    	}
		}

		else
		{
			$combo = explode('$$', $pres);
			$combo_med = explode(',', $combo[0]);
			$new_combo = explode('$$', $prescription);
			$new_combo_med = explode(',', $new_combo[0]);
			$final_combo = array_merge($combo_med,$new_combo_med);
			$final_combo = implode(',', $final_combo);

			$combo_unit = explode(',', $combo[1]);
			$new_combo_unit = explode(',', $new_combo[1]);
			$final_unit = (array_merge($combo_unit, $new_combo_unit));
			$final_unit = implode(',', $final_unit);
			$final = $final_combo."$$".$final_unit;

			$pros .= $proc;

			$this->db->query('UPDATE ipd_days SET ipd_day_prescription = :final, ipd_day_procedure = :pros WHERE ipd_day_admit_id = :admit_id and ipd_day_val = :today');
	    	$this->db->bind(':final', $final);
	    	$this->db->bind(':pros', $pros);
	    	$this->db->bind(':admit_id', $admit_id);
	    	$this->db->bind(':today', $today);
	    	if($this->db->execute())
	    	{
	    		unset($_SESSION['procedure_x']);
	    		return true;
	    	}
	    	else
	    	{
	    		return false;
	    	}

		}    	
    }

    public function update_medication_db($prescription,$proc,$admit_id,$day_in)
    {
    	$this->db->query('SELECT ipd_day_procedure, ipd_day_prescription FROM ipd_days WHERE ipd_day_admit_id = :admit_id AND ipd_day_val = :day_in');
    	$this->db->bind(':admit_id', $admit_id);
    	$this->db->bind(':day_in', $day_in);
    	$row = $this->db->resultSet();
    	foreach ($row as $key)
    	{
    		$pres = $key->ipd_day_prescription;
    		$pros = $key->ipd_day_procedure;
    	}
    	
    	$combo = explode('$$', $pres);
		$combo_med = explode(',', $combo[0]);
		$new_combo = explode('$$', $prescription);
		$new_combo_med = explode(',', $new_combo[0]);
		$final_combo = array_merge($combo_med,$new_combo_med);
		$final_combo = implode(',', $final_combo);

		$combo_unit = explode(',', $combo[1]);
		$new_combo_unit = explode(',', $new_combo[1]);
		$final_unit = (array_merge($combo_unit, $new_combo_unit));
		$final_unit = implode(',', $final_unit);
		$final = $final_combo."$$".$final_unit;

		$pros .= $proc;

		$this->db->query('UPDATE ipd_days SET ipd_day_prescription = :final, ipd_day_procedure = :pros WHERE ipd_day_admit_id = :admit_id and ipd_day_val = :day_in');
    	$this->db->bind(':final', $final);
    	$this->db->bind(':pros', $pros);
    	$this->db->bind(':admit_id', $admit_id);
    	$this->db->bind(':day_in', $day_in);
    	if($this->db->execute())
    	{
    		unset($_SESSION['procedure_x']);
    		unset($_SESSION['procedure']);
    		return true;
    	}
    	else
    	{
    		return false;
    	}

    }

    public function get_idp_data($admit_id)
    {
    	$this->db->query('SELECT * FROM ipd_days WHERE ipd_day_admit_id = :admit_id');
    	$this->db->bind(':admit_id', $admit_id);
    	$row = $this->db->resultSet();
    	return $row;
    }

    public function delete_med_db($curr_date, $position, $admit_id)
    {
    	$this->db->query('SELECT * FROM ipd_days WHERE ipd_day_val = :curr_date AND ipd_day_admit_id = :admit_id');
    	$this->db->bind(':curr_date', $curr_date);
    	$this->db->bind(':admit_id', $admit_id);
    	$row = $this->db->resultSet();
    	foreach ($row as $key)
    	{
    		$prescription  = $key->ipd_day_prescription;
    		$procedure = $key->ipd_day_procedure;
    	}
    	$pres_editing = explode('$$', $prescription);
    	$pres_editing1 = explode(',', $pres_editing[0]);
    	$pres_editing2 = explode(',', $pres_editing[1]);
    	unset($pres_editing1[$position]);
    	$pres_editing1 = implode(',', $pres_editing1);
    	unset($pres_editing2[$position]);
    	$pres_editing2 = implode(',', $pres_editing2);
    	$new_pres = $pres_editing1."$$".$pres_editing2; // adding updated medicine prescription

    	$pros_edit = explode('$&$x', $procedure);
    	$size = sizeof($pros_edit);
    	unset($pros_edit[$position]);
    	unset($pros_edit[$size - 1]);
    	$new_pros = implode('$&$x', $pros_edit);
    	$new_pros .= "$&$";
    	$new_pros .= "x"; // adding updated medicine procedure

    	$this->db->query('UPDATE ipd_days SET ipd_day_prescription = :new_pres, ipd_day_procedure = :new_pros WHERE ipd_day_val = :curr_date AND ipd_day_admit_id = :admit_id');
    	$this->db->bind(':new_pres', $new_pres);
    	$this->db->bind(':new_pros', $new_pros);
    	$this->db->bind(':curr_date', $curr_date);
    	$this->db->bind(':admit_id', $admit_id);
    	if($this->db->execute())
    	{
    		return true;
    	}
    	else
    	{
    		return false;
    	}
    }

    public function save_initial_diag_db($init_cond, $first_diag, $admit_id)
    {
    	$this->db->query('UPDATE ipd SET ipd_initial_condition = :init_cond, ipd_first_diagnosis = :first_diag WHERE ipd_admit_id = :admit_id');
    	$this->db->bind(':init_cond', $init_cond);
    	$this->db->bind(':first_diag', $first_diag);
    	$this->db->bind(':admit_id', $admit_id);
    	if($this->db->execute())
    		return true;
    	else
    		return false;
    }

    public function get_ipd_main_data($admit_id)
    {
    	$this->db->query('SELECT * FROM ipd WHERE ipd_admit_id = :admit_id');
    	$this->db->bind(':admit_id', $admit_id);
    	$row = $this->db->resultSet();
    	return $row;
    }

    public function get_all_ipd_addmission($patient_id)
    {
    	$this->db->query('SELECT * FROM ipd WHERE ipd_patient_id = :patient_id');
    	$this->db->bind(':patient_id', $patient_id);
    	$row = $this->db->resultSet();
    	return $row;
    }

    public function get_all_tests($search)
    {
    	$this->db->query("SELECT * FROM lab_test_values WHERE lab_test_value_id LIKE concat('%', :search, '%') OR lab_test_name LIKE concat('%', :search, '%') LIMIT 6");
    	$this->db->bind(':search', $search);
    	$row = $this->db->resultSet();
    	return $row;
    }

    public function get_patient_by_name_like($sear)
    {
        $this->db->query("SELECT * FROM patients WHERE active = 1 AND patient_name LIKE concat('%', :sear, '%') LIMIT 5");
        $this->db->bind(':sear', $sear);
        $row = $this->db->resultSet();
        return $row;
    }

     public function getyearlyreportfrom_patient_op()
    {
        $this->db->query("SELECT * FROM opd WHERE opd_doctor_id =:opd_doctor_id AND date(visit_date_time) BETWEEN :year AND :year1 ");
 		
 		$this->db->bind(':opd_doctor_id', $_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);

         $this->db->bind(':year', date('Y-01-01'));
         $this->db->bind(':year1', date('Y-12-31'));
        $row = $this->db->resultSet();
    	$count = $this->db->rowCount();
        return $count;
    }

      public function getyearlyreportfrom_patient_ip()
    {
       $this->db->query("SELECT * FROM ipd WHERE ipd_doctor_id =:ipd_doctor_id AND date(admission_date_time) BETWEEN :year AND :year1 ");
 		
 		$this->db->bind(':ipd_doctor_id', $_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);

         $this->db->bind(':year', date('Y-01-01'));
         $this->db->bind(':year1', date('Y-12-31'));
        $row = $this->db->resultSet();
    	$count = $this->db->rowCount();
        return $count;
    }

     public function getmonthlyreportfrom_patient_op()
    {
        $this->db->query("SELECT * FROM opd WHERE opd_doctor_id =:opd_doctor_id AND date(visit_date_time) BETWEEN :year AND :year1 ");
 		
 		$this->db->bind(':opd_doctor_id', $_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);

         $this->db->bind(':year', date('Y-m-01'));
         $this->db->bind(':year1', date('Y-m-31'));
        $row = $this->db->resultSet();
    	$count = $this->db->rowCount();
        return $count;
    }

      public function getmonthlyreportfrom_patient_ip()
    {
       $this->db->query("SELECT * FROM ipd WHERE ipd_doctor_id =:ipd_doctor_id AND date(admission_date_time) BETWEEN :year AND :year1 ");
 		
 		$this->db->bind(':ipd_doctor_id', $_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);

         $this->db->bind(':year', date('Y-m-01'));
         $this->db->bind(':year1', date('Y-m-31'));
        $row = $this->db->resultSet();
    	$count = $this->db->rowCount();
        return $count;
    }
     public function getdayreportfrom_patient_op()
    {
        $this->db->query("SELECT * FROM opd WHERE opd_doctor_id =:opd_doctor_id AND date(visit_date_time) BETWEEN :year AND :year1 ");
 		
 		$this->db->bind(':opd_doctor_id', $_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);

         $this->db->bind(':year', date('Y-m-d'));
         $this->db->bind(':year1', date('Y-m-d'));
        $row = $this->db->resultSet();
    	$count = $this->db->rowCount();
        return $count;
    }

      public function getdayreportfrom_patient_ip()
    {
       $this->db->query("SELECT * FROM ipd WHERE ipd_doctor_id =:ipd_doctor_id AND date(admission_date_time) BETWEEN :year AND :year1 ");
 		
 		$this->db->bind(':ipd_doctor_id', $_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);

         $this->db->bind(':year', date('Y-m-d'));
         $this->db->bind(':year1', date('Y-m-d'));
        $row = $this->db->resultSet();
    	$count = $this->db->rowCount();
        return $count;
    }

    public function ot_details_db($pid, $ip_op_doc_ref_id, $ot_date, $ot_name, $ot_des, $pat_id)
    {
    	$pid .= 'IP';
    	$this->db->query('INSERT INTO ot (ip_op_ref, ip_op_doc_ref_id, ot_date, ot_name, ot_description, patient_id) VALUES (:pid, :ip_op_doc_ref_id, :ot_date, :ot_name, :ot_des, :pat_id)');
    	$this->db->bind(':pid', $pid);
    	$this->db->bind(':ot_date', $ot_date);
    	$this->db->bind(':ot_name', $ot_name);
    	$this->db->bind(':ot_des', $ot_des);
    	$this->db->bind(':pat_id', $pat_id);
    	$this->db->bind(':ip_op_doc_ref_id', $ip_op_doc_ref_id);
    	if($this->db->execute())
    	{
    		return true;
    	}
    	else
    	{
    		return false;
    	}
    	
    }




   

    public function save_instruction_to_db($ins_category, $ins_title, $ins_body)
    {
    	$doc_id = $_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no'];
    	$ins_date = date('Y-m-d');
    	$this->db->query('INSERT INTO instruction (category, instruction_title, instruction, doctor_id, instruction_date) VALUES(:ins_category, :ins_title, :ins_body, :doc_id, :ins_date)');
    	$this->db->bind(':ins_category', $ins_category);
    	$this->db->bind(':ins_title', $ins_title);
    	$this->db->bind(':ins_body', $ins_body);
    	$this->db->bind(':doc_id', $doc_id);
    	$this->db->bind(':ins_date', $ins_date);
    	if($this->db->execute())
    	{
    		return true;
    	}
    	else
    	{
    		return false;
    	}
    }

    public function get_all_instructions_from_db()
    {
    	$doc_id = $_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no'];
    	$this->db->query('SELECT * FROM instruction WHERE doctor_id = :doc_id');
    	$this->db->bind(':doc_id', $doc_id);
    	return $row = $this->db->resultSet();
    }

    public function get_ins_having_id($ins_id)
    {
    	$this->db->query('SELECT * FROM instruction WHERE instruction_id = :ins_id');
    	$this->db->bind(':ins_id', $ins_id);
    	return $row = $this->db->resultSet();
    }

    public function update_instruction_to_db($ins_category, $ins_title, $ins_body, $ins_id)
    {
    	$ins_date = date('Y-m-d');
    	$this->db->query('UPDATE instruction SET category = :ins_category, instruction_title = :ins_title, instruction = :ins_body, instruction_date = :ins_date WHERE instruction_id = :ins_id ');
    	$this->db->bind(':ins_category', $ins_category);
    	$this->db->bind(':ins_title', $ins_title);
    	$this->db->bind(':ins_body', $ins_body);
    	$this->db->bind(':ins_id', $ins_id);
    	$this->db->bind(':ins_date', $ins_date);
    	if($this->db->execute())
    	{
    		return true;
    	}
    	else
    	{
    		return false;
    	}
    }

    public function delete_instruction_from_db($id)
    {
    	$this->db->query('DELETE FROM instruction WHERE instruction_id = :id');
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

    public function get_ip_patients($sear)
    {
        $this->db->query("SELECT patients.patient_name, patients.patient_id FROM patients INNER JOIN ipd ON patients.patient_id = ipd.ipd_patient_id WHERE patients.patient_name LIKE concat('%', :sear, '%') LIMIT 5");
        $this->db->bind(':sear', $sear);
        $row = $this->db->resultSet();
        return $row;
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

    public function save_other_upload_details_db($ip_id, $rep_tit, $idType)
    {
    	if($idType == 1)
    	{
    		$ipd_rep = explode('(', $ip_id);
	    	$ipd_rep = explode(')', $ipd_rep[1]);
	    	$ipd_rep = trim($ipd_rep[0]);
	    	$file_name = $_SESSION['file_name_upload'];
	    	unset($_SESSION['file_name_upload']);
	    	$this->db->query('UPDATE reports SET report_title = :rep_tit, visit_id = :ipd_rep WHERE report_file_name = :file_name');
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
    	elseif ($idType == 2)
    	{
    		$ipd_rep = explode('(', $ip_id);
	    	$ipd_rep = explode(')', $ipd_rep[1]);
	    	$ipd_rep = trim($ipd_rep[0]);
	    	$file_name = $_SESSION['file_name_upload'];
	    	unset($_SESSION['file_name_upload']);
	    	$this->db->query('UPDATE reports SET report_title = :rep_tit, admit_id = :ipd_rep WHERE report_file_name = :file_name');
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
    	
	}

	public function save_other_upload_details_ip_db($ip_id, $rep_tit)
    {
    	$file_name = $_SESSION['file_name_upload'];
    	unset($_SESSION['file_name_upload']);
    	$this->db->query('UPDATE reports SET report_title = :rep_tit, admit_id = :ip_id WHERE report_file_name = :file_name');
    	$this->db->bind(':rep_tit', $rep_tit);
    	$this->db->bind(':ip_id', $ip_id);
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
	
	public function get_all_instructions()
	{
		$doc_id = $_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no'];
		$this->db->query('SELECT DISTINCT category FROM instruction WHERE doctor_id = :doc_id');
		$this->db->bind(':doc_id', $doc_id);
		return $row = $this->db->resultSet();
	}

	public function get_ins_of_cat_db($ins_cat)
	{
		$doc_id = $_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no'];
		$this->db->query('SELECT * FROM instruction WHERE category = :ins_cat AND doctor_id = :doc_id');
		$this->db->bind(':ins_cat', $ins_cat);
		$this->db->bind(':doc_id', $doc_id);
		return $row = $this->db->resultSet();
	}

	public function change_dis_status($ad_id)
	{
		$this->db->query('UPDATE ipd SET discharge_date_time = NULL WHERE ipd_admit_id = :ad_id');
		$this->db->bind(':ad_id', $ad_id);
		if($this->db->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function get_reports_wrt_admit_id($admit_id)
	{
		$this->db->query('SELECT * FROM reports WHERE admit_id = :admit_id');
		$this->db->bind(':admit_id', $admit_id);
		return $row = $this->db->resultSet();
	}

	public function get_reports_comorb($id)
	{	
		$this->db->query('SELECT * FROM patients WHERE patient_id = :id');
		$this->db->bind(':id', $id);
		return $row = $this->db->resultSet();
	}

	 // public function add_mem_db($id1,$mem_name, $mem_type, $mem_ph, $mem_em)
  //   {
  //       $mem_pass1 = password_hash($mem_ph, PASSWORD_DEFAULT);

  //       $this->db->query('INSERT INTO users (mem_name, mem_type, , mem_email, mem_pass) VALUES(:mem_name, :mem_type, :mem_ph, :mem_em, :mem_pass1)');

  //       $this->db->query('UPDATE users SET mem_name = :mem_name, mem_type = :mem_type, mem_email = :mem_em, mem_pass = : WHERE mem_id = :id1');
  //       $this->db->bind(':mem_name' ,$mem_name);
  //       $this->db->bind(':mem_type' ,$mem_type);
  //       $this->db->bind(':mem_ph' ,$mem_ph);
  //       $this->db->bind(':mem_em' ,$mem_em);
  //       $this->db->bind(':mem_pass1' ,$mem_pass1);
  //       if($this->db->execute())
  //           return true;
  //       else
  //           return false;
  //   }



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
        $this->db->query('SELECT * FROM reports WHERE admit_id=:inv_id OR visit_id = :inv_id');
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

    public function getAllOperationsWithRespectToDoc()
    {
		$this->db->query('SELECT * FROM ot WHERE ip_op_doc_ref_id = :docId');
		$this->db->bind(':docId', $_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
    	return $row = $this->db->resultSet();
    }

    public function getOtDetailsById($id)
    {
    	$this->db->query('SELECT * FROM ot WHERE ot_id = :id');
    	$this->db->bind(':id', $id);
    	return $row = $this->db->single();
    }

    public function getDocName($id)
    {
    	$this->db->query('SELECT doctor_name FROM doctors WHERE mem_id = :id');
    	$this->db->bind(':id', $id);
    	return $doc = $this->db->single();
	}
	
	public function saveTimeSlotsDb($dayId, $end, $start)
	{
		$this->db->query('SELECT * FROM doctor_timeslot WHERE mem_id = :mem_id');
		$this->db->bind(':mem_id', $_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
		$row = $this->db->single();

		if($this->db->rowCount() > 0)
		{
			$daysArrayStart = explode('__', $row->days_slots_start);
			$daysArrayEnd = explode('__', $row->days_slots_end);

			// $end = implode('||', $end);
			// $start = implode('||', $start);

			$prevStart = explode('||', $daysArrayStart[$dayId]);
			$prevEnd = explode('||', $daysArrayEnd[$dayId]);

			$finalStart = array_merge($prevStart, $start);
			$finalEnd = array_merge($prevEnd, $end);
			
			$finalStart = implode('||', $finalStart);
			$finalEnd = implode('||', $finalEnd);

			// var_dump($finalStart);
			// var_dump($finalEnd);

			$daysArrayStart[$dayId] = $finalStart;
			$daysArrayEnd[$dayId] = $finalEnd;

			$daysArrayStart = implode('__', $daysArrayStart);
			$daysArrayEnd = implode('__', $daysArrayEnd);
			$this->db->query('UPDATE doctor_timeslot SET days_slots_start = :daysArrayStart, days_slots_end = :daysArrayEnd WHERE mem_id = :memId');
			$this->db->bind(':memId', $_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
			$this->db->bind(':daysArrayStart', $daysArrayStart);
			$this->db->bind(':daysArrayEnd', $daysArrayEnd);
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
			$daysArrayStart = array_fill(0, 7, 0);
			$daysArrayEnd = array_fill(0,7, 0);

			$end = implode('||', $end);
			$start = implode('||', $start);

			$daysArrayStart[$dayId] = $start;
			$daysArrayEnd[$dayId] = $end;

			$daysArrayStart = implode('__', $daysArrayStart);
			$daysArrayEnd = implode('__', $daysArrayEnd);
			$this->db->query('INSERT INTO doctor_timeslot  (mem_id, days_slots_start, days_slots_end) VALUES (:memId, :daysArrayStart, :daysArrayEnd)');
			$this->db->bind(':memId', $_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
			$this->db->bind(':daysArrayStart', $daysArrayStart);
			$this->db->bind(':daysArrayEnd', $daysArrayEnd);
			if($this->db->execute())
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	}

	public function getAllTimeslots()
	{
		$this->db->query('SELECT * FROM doctor_timeslot WHERE mem_id = :memId');
		$this->db->bind(':memId', $_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
		return $row = $this->db->single();
	}

	public function deleteTheTimeslot($timeSlotPosition, $dayPosition)
	{
		$this->db->query('SELECT * FROM doctor_timeslot WHERE mem_id = :memId');
		$this->db->bind(':memId', $_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
		$row = $this->db->single();

		$startTime = explode('__', $row->days_slots_start);
		$endTime = explode('__', $row->days_slots_end);

		$deleteStart = explode('||', $startTime[$dayPosition]);
		$deleteEnd = explode('||', $endTime[$dayPosition]);
		unset($deleteStart[$timeSlotPosition]);
		unset($deleteEnd[$timeSlotPosition]);

		$deleteStart = implode('||', $deleteStart);
		$deleteEnd = implode('||', $deleteEnd);

		$startTime[$dayPosition] = $deleteStart;
		$endTime[$dayPosition] = $deleteEnd;

		$startTime = implode('__', $startTime);
		$endTime = implode('__', $endTime);
		
		$this->db->query('UPDATE doctor_timeslot SET days_slots_start = :startTime, days_slots_end = :endTime WHERE mem_id = :memId');
		$this->db->bind(':memId', $_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
		$this->db->bind(':startTime', $startTime);
		$this->db->bind(':endTime', $endTime);
		$this->db->execute();
		return true;
		
	}

	public function getTheTimeSlot($dId)
	{
		$this->db->query('SELECT * FROM doctor_timeslot WHERE mem_id = :dId');
		$this->db->bind(':dId', $dId);
		return $row = $this->db->single();
	}

	public function getIpdPatByDoc()
	{
		$this->db->query('SELECT ipd_patient_id FROM ipd WHERE ipd_doctor_id = :docId');
		$this->db->bind(':docId', $_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
		return $row = $this->db->resultSet();
	}

	public function getOpdPatByDoc()
	{
		$this->db->query('SELECT opd_patient_id FROM opd WHERE opd_doctor_id = :docId');
		$this->db->bind(':docId', $_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
		return $row = $this->db->resultSet();
	}

	public function getTheOperationDetailsDb($id)
	{
		$this->db->query('SELECT * FROM ot WHERE ip_op_ref = :id');
		$this->db->bind(':id', $id);
		return $row = $this->db->single();
	}

	public function getAllDoctors()
    {
        $this->db->query('SELECT mem_id, doctor_name FROM doctors');
        return $row = $this->db->resultSet();
    }

    public function getAllNurses()
    {
        $this->db->query('SELECT mem_id, mem_name FROM users WHERE mem_type = "nur"');
        return $row = $this->db->resultSet();
	}
	
	public function saveAssignTeam($id, $dR, $nR, $oR)
    {
        $this->db->query('UPDATE ot SET ot_team_doc = :dR, ot_team_nur = :nR, ot_team_oth = :rO WHERE ot_id = :id');
        $this->db->bind(':id', $id);
        $this->db->bind(':dR', $dR);
        $this->db->bind(':nR', $nR);
        $this->db->bind(':rO', $oR);
        if($this->db->execute())
        {
            return true;
        }
        else
        {
            die('Error');
        }
	}
	
	public function getThePatientIdFromAdmitId($admit_id)
	{
		$this->db->query('SELECT ipd_patient_id FROM ipd WHERE ipd_admit_id = :admit_id');
		$this->db->bind(':admit_id', $admit_id);
		$p = $this->db->single();
		return $patientId = $p->ipd_patient_id;
	}

	public function getThePatientIdFromVisitId($visit_id)
	{
		$this->db->query('SELECT opd_patient_id FROM opd WHERE opd_visit_id = :visit_id');
		$this->db->bind(':visit_id', $visit_id);
		$p = $this->db->single();
		return $patientId = $p->opd_patient_id;
	}
	public function get_all_emergency_doc($lim,$off)
    {
        $this->db->query('SELECT * FROM emergency WHERE d_mem_id = :user_id ORDER BY id DESC limit :lim OFFSET :off');
        $this->db->bind(':lim',$lim);
        $this->db->bind(':off',$off);
        $this->db->bind(':user_id', $_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
        $row = $this->db->resultSet();
        return $row;
    }
    public function get_emergency_for_doctor($id)
    {
    	$this->db->query('SELECT * FROM emergency WHERE id = :id');
		$this->db->bind(':id', $id);
		$p = $this->db->single();
		return $p;
    }
    public function update_emergency_details($id,$details)
    {
        $this->db->query('UPDATE emergency SET details =:details WHERE id = :id');
        $this->db->bind(':id', $id);
        $this->db->bind(':details', $details);
        // $this->db->bind(':p_name', $p_name);
        // $this->db->bind(':d_name', $d_name);
        if($this->db->execute())
        {
        return true;
        }
        else
        {
        die('Error');
        }  
    }
     public function get_item_by_id($cid)
    {
         $this->db->query('SELECT * FROM items where id =:id');
        $this->db->bind(':id', $cid);
        $y = $this->db->single();
        return $y; 
    }
     public function add_stock_out_order_details_doc($data)
    {
    	$x ="";
    	$x = date("Y-m-d");
        $this->db->query('INSERT INTO stock_out(stock_dt,sub_total,total_amount,temp_id) VALUES( :stock_dt,:sub_total,:total_amount,:temp_id)');
        // Bind values
        $this->db->bind(':stock_dt', $x);
        $this->db->bind(':sub_total', $data['sub_total']);
        $this->db->bind(':total_amount', $data['grand_total']);
        $this->db->bind(':temp_id', $data['tempId']);
        // Execute
        if ($this->db->execute()) 
        {
            $this->db->query('SELECT * FROM stock_out WHERE temp_id = :tempId');
            $this->db->bind(':tempId', $data['tempId']);
            $r =  $this->db->single();
        	$this->db->query('INSERT INTO stock_out_order (item_id, item_name, item_qty, item_rec,item_price,item_rtotal,item_sub_total,item_grand_total,stock_out_id) VALUES(:itemId, :itemName, :qty, :rec,:price,:rtotal,:sub_total,:total_amount,:temp_id)');
	        $this->db->bind(':itemId', $data['item_id']);
	        $this->db->bind(':itemName', $data['item_name']);
	        $this->db->bind(':qty', $data['item_qty_by_doc']);
	        $this->db->bind(':rec', $data['item_receive']);
	        $this->db->bind(':price', $data['item_selling_price']);
	        $this->db->bind(':rtotal', $data['item_row_total']);
	        $this->db->bind(':sub_total', $data['sub_total']);
	        $this->db->bind(':total_amount', $data['grand_total']);
	        $this->db->bind(':temp_id', $r->id);
	        $this->db->execute();
	        return true;
        } else {
            die('Error');
        }
    }

	public function update_discharge_advice($admit_id, $advice)
	{
		$this->db->query('UPDATE ipd SET advice = :advice WHERE ipd_admit_id = :admit_id');
		$this->db->bind(':admit_id', $admit_id);
		$this->db->bind(':advice', $advice);
		$this->db->execute();
		return true;
	}

} // end of class