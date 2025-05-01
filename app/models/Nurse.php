<?php
class Nurse
{
	private $db;

	public function __construct()
	{
		$this->db = new Database;
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
	public function get_patient_by_id($p_id)
    {
        $this->db->query('SELECT * FROM patients WHERE patient_id = :p_id');
        $this->db->bind(':p_id',$p_id);
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
	 public function doctor_name($id)
    {
        $this->db->query('SELECT doctor_name FROM doctors WHERE mem_id = :id');
        $this->db->bind(':id', $id);
        $name = $this->db->single();
        $name = $name->doctor_name;
        return $name;
    }
    public function get_all_ipd($lim,$off)
	{
		$this->db->query('SELECT * FROM ipd  ORDER BY ipd_admit_id DESC limit :lim OFFSET :off');

		$this->db->bind(':lim',$lim);
        $this->db->bind(':off',$off);
		$row = $this->db->resultSet();
		return $row;
	}

	public function get_all_ipd_myipd($lim,$off)
	{
		$this->db->query('SELECT * FROM ipd ORDER BY ipd_admit_id DESC limit :lim OFFSET :off ');

		$this->db->bind(':lim',$lim);
        $this->db->bind(':off',$off);
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

     public function get_ipd_main_data($admit_id)
    {
    	$this->db->query('SELECT * FROM ipd WHERE ipd_admit_id = :admit_id');
    	$this->db->bind(':admit_id', $admit_id);
    	$row = $this->db->resultSet();
    	return $row;
    }

     public function get_ipd_days($admit_id)
    {
    	$this->db->query('SELECT * FROM ipd_days WHERE ipd_day_admit_id = :admit_id');
    	$this->db->bind(':admit_id', $admit_id);
    	$row = $this->db->resultSet();
    	return $row;
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
     public function get_idp_data($admit_id)
    {
    	$this->db->query('SELECT * FROM ipd_days WHERE ipd_day_admit_id = :admit_id');
    	$this->db->bind(':admit_id', $admit_id);
    	$row = $this->db->resultSet();
    	return $row;
    }
     public function get_patient_data_m($pid)
    {
    	$this->db->query('SELECT patients.patient_id, patients.patient_name, patients.patient_gender, patients.patient_dob, patients.patient_email, patients.patient_phone, patients.patient_address,patients.hypertension, patients.diabetes, patients.coronary, patients.cerebro, patients.dyslipidaemia, patients.hypothyroidism, patients.other, patients.patient_history,patients.patient_history_mon,patients.patient_history_year, patients.family_history, ipd.ipd_admit_id, ipd.ipd_bed_id, ipd.ipd_doctor_id, ipd.admission_date_time FROM patients INNER JOIN ipd ON ipd.ipd_patient_id = patients.patient_id WHERE patient_id = :pid');
    	$this->db->bind(':pid', $pid);
    	$p_data = $this->db->resultSet();
    	return $p_data;
    }
    public function get_opd_data($id)
	{
		$this->db->query('SELECT * FROM opd WHERE opd_visit_id = :id');
		$this->db->bind(':id', $id);
		$row = $this->db->resultSet();
		return $row;
	}
	public function get_doc_name($id)
	{
		$this->db->query('SELECT doctor_name FROM doctors WHERE mem_id = :id');
		$this->db->bind(':id', $id);
		$o = $this->db->resultSet();
		return $o;
	}
	public function get_opd_patient_id2($pid)
	{
		$this->db->query('SELECT * FROM opd WHERE opd_patient_id = :pid and visit_status = 1');
		$this->db->bind(':pid',$pid);
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
	public function get_all_opd_pat($lim,$off)
	{
		$this->db->query('SELECT * FROM opd ORDER BY opd_visit_id DESC limit :lim OFFSET :off');
		$this->db->bind(':lim', $lim);
        $this->db->bind(':off', $off);
		$row = $this->db->resultSet();
		return $row;
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
    	$this->db->query('SELECT ipd_day_procedure, ipd_day_prescription, ipd_day_admit_id FROM ipd_days WHERE ipd_day_admit_id = :admit_id AND ipd_day_val = :today');
    	$this->db->bind(':admit_id', $admit_id);
    	$this->db->bind(':today', $today);
    	$row = $this->db->resultSet();
    	foreach ($row as $key)
    	{
    		$pres = $key->ipd_day_prescription;
    		$pros = $key->ipd_day_procedure;
    		echo $ipd_id = $key->ipd_day_admit_id;
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
	    		$this->db->query('UPDATE ipd SET nurse_id = :nurse_id WHERE ipd_admit_id = :ipd_id');
	    		$this->db->bind(':nurse_id', $_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
	    		$this->db->bind(':ipd_id', $ipd_id);
	    		$this->db->execute();
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
	    		$this->db->query('UPDATE ipd SET nurse_id = :nurse_id WHERE ipd_admit_id = :ipd_id');
	    		$this->db->bind(':nurse_id', $_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
	    		$this->db->bind(':ipd_id', $ipd_id);
	    		$this->db->execute();
	    		return true;
	    	}
	    	else
	    	{
	    		return false;
	    	}

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

	public function save_pat_his_db($past_his,$fam_his,$id)
	{
		$this->db->query('UPDATE patients SET patient_history = :past_his, family_history = :fam_his WHERE patient_id = :id');
		$this->db->bind(':past_his', $past_his);
		$this->db->bind(':fam_his', $fam_his);
		$this->db->bind(':id', $id);
		if($this->db->execute())
		{
			return false;
		}
		else
		{
			return true;
		}
	}
public function get_logo_details()
    {
        $this->db->query('SELECT * FROM service_provider ORDER BY ser_pro_id DESC LIMIT 1');
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
	public function get_reports_wrt_admit_id($admit_id)
	{
		$this->db->query('SELECT * FROM reports WHERE admit_id = :admit_id');
		$this->db->bind(':admit_id', $admit_id);
		return $row = $this->db->resultSet();
	}
	public function get_doctor_by_id($d_id)
    {
        $this->db->query('SELECT * FROM doctors WHERE mem_id = :d_id');
        $this->db->bind(':d_id',$d_id);
        $row = $this->db->resultSet();
        return $row;
    }
    public function get_reports_comorb($id)
	{	
		$this->db->query('SELECT * FROM patients WHERE patient_id = :id');
		$this->db->bind(':id', $id);
		return $row = $this->db->resultSet();
	}

	public function auto_patient_name($cust)
    {
		$this->db->query("SELECT DISTINCT * from patients WHERE patient_name LIKE concat(:cust, '%') OR patient_id LIKE concat('%', :cust, '%') LIMIT 8");
		$this->db->bind(':cust',$cust);
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
     public function update_password_db($cpass, $id, $photo)
    {
        $this->db->query('UPDATE users SET mem_pass = :cpass, mem_photo = :photo WHERE mem_id = :id');
        $this->db->bind(':cpass', $cpass);
        $this->db->bind(':id', $id);
        $this->db->bind(':photo', $photo);
        $this->db->execute();
        return true;
    }

    public function getNurseServiceDb($enteredValue)
    {
    	$this->db->query('SELECT * FROM services WHERE service_name LIKE concat("%",:enteredValue,"%") AND service_type = "Nursing Service"');
    	$this->db->bind(':enteredValue', $enteredValue);
    	return $row = $this->db->resultSet();
    }

    public function saveIpdDaysNurseService($curr_date, $ad_id, $idArray)
    {
    	$this->db->query('SELECT nursing_service FROM ipd_days WHERE ipd_day_admit_id = :ad_id AND ipd_day_val = :curr_date');
    	$this->db->bind(':curr_date', $curr_date);
    	$this->db->bind(':ad_id', $ad_id);
    	$row = $this->db->single();
    	if($row->nursing_service != NULL)
    	{
    		$idArray .= ','.$row->nursing_service;
    		$this->db->query('UPDATE ipd_days SET nursing_service = :idArray WHERE ipd_day_admit_id = :ad_id AND ipd_day_val = :curr_date');
	    	$this->db->bind(':curr_date', $curr_date);
	    	$this->db->bind(':ad_id', $ad_id);
	    	$this->db->bind(':idArray', $idArray);
	    	if($this->db->execute())
	    	{
	    		return true;
	    	}
	    	else
	    	{
	    		die('Error');
	    	}
    	}
    	else
    	{
    		$this->db->query('UPDATE ipd_days SET nursing_service = :idArray WHERE ipd_day_admit_id = :ad_id AND ipd_day_val = :curr_date');
	    	$this->db->bind(':curr_date', $curr_date);
	    	$this->db->bind(':ad_id', $ad_id);
	    	$this->db->bind(':idArray', $idArray);
	    	if($this->db->execute())
	    	{
	    		return true;
	    	}
	    	else
	    	{
	    		die('Error');
	    	}
    	}

    	
    }

    public function getServiceNameDb($id)
    {
    	$this->db->query('SELECT service_name FROM services WHERE service_id = :id');
    	$this->db->bind(':id', $id);
		$name = $this->db->single();
		if($this->db->rowCount() > 0)
		{
			return $name->service_name;
		}
		else
		{
			return false;
		}
    	
    }

    public function saveNursingServiceDb($visitId, $nS)
    {
    	$this->db->query('SELECT nursing_services FROM opd WHERE opd_visit_id = :visitId');
    	$this->db->bind(':visitId', $visitId);
    	$row = $this->db->single();
    	if($row->nursing_services == NULL)
    	{
    		$this->db->query('UPDATE opd SET nursing_services = :nS WHERE opd_visit_id = :visitId');
    		$this->db->bind(':nS', $nS);
    		$this->db->bind(':visitId', $visitId);
    		if($this->db->execute())
    		{
    			return true;
    		}
    		else
    		{
    			die('Error');
    		}
    	}
    	else
    	{
    		$nS .= ",".$row->nursing_services;
    		$this->db->query('UPDATE opd SET nursing_services = :nS WHERE opd_visit_id = :visitId');
    		$this->db->bind(':nS', $nS);
    		$this->db->bind(':visitId', $visitId);
    		if($this->db->execute())
    		{
    			return true;
    		}
    		else
    		{
    			die('Error');
    		}
    	}
    }

    public function getpatientname($id)
    {
    	$this->db->query('SELECT * FROM patients WHERE patient_id = :id');
    	$this->db->bind(':id', $id);
    	$row = $this->db->single();
    	return $row;    		
    }

    public function getAllOperationsWithRespectToDoc()
    {
    	$this->db->query('SELECT * FROM ot');
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

    


}
?>
