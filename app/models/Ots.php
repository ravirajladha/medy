<?php
class Ots
{
	private $db;
	public function __construct()
	{
		$this->db = new Database;
	}

	public function get_all_ot()
    {
    	$this->db->query('SELECT * FROM ot');

    	$row = $this->db->resultSet();
    	return $row;
    }

    public function get_all_rooms()
    {
        $this->db->query('SELECT * FROM rooms');

        $row = $this->db->resultSet();
        return $row;
    }


	public function get_all_ot_with_patient_name()
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
        o.room_ref_id as room_ref_id,
        i.admission_date_time as admission_date_time, 
        o.created_at as created_at 
        FROM ot o, patients p, users d, ipd i WHERE o.patient_id = p.patient_id AND o.ip_op_doc_ref_id = d.mem_id AND o.patient_id = i.ipd_patient_id ORDER BY o.ot_id');
        $row = $this->db->resultSet();
        return $row;
    }

    public function get_room_no($id)
    {
        $this->db->query('SELECT room_no FROM rooms WHERE id = :id');
        $this->db->bind(':id', $id);
        $row = $this->db->single();
        return $row->room_no;
    }

    public function patient_name($id)
    {
        $this->db->query('SELECT patient_name FROM patients WHERE patient_id = :id');
        $this->db->bind(':id', $id);
        $name = $this->db->single();
        $nam = $name->patient_name;
        return $nam;
    }
    public function get_room_status($id)
    {
        $this->db->query('SELECT room_ref_id FROM ot WHERE ot_id = :id');
        $this->db->bind(':id', $id);
        $row = $this->db->single();
        return $row;
    }

     public function status_current_update($id)
        {
           
        $this->db->query('UPDATE ot SET status = :status WHERE ot_id = :id ');
              // Bind values
            $this->db->bind(':id', $id);
            $this->db->bind(':status', '1');
            // Execute
            if($this->db->execute()){
                return true;
            } else {
                return false;
            }
        }
     public function status_current_update_cancel($id)
        {
            $this->db->query('SELECT* FROM ot WHERE ot_id = :id ');
            $this->db->bind(':id', $id);
            $row = $this->db->single();
            $ro_no=$row->room_ref_id;

            $this->db->query('UPDATE rooms SET  status = :status, ot_room_id = :ot_room_id WHERE id = :ro_no ');
              // Bind values
            $this->db->bind(':ro_no', $ro_no);
            $this->db->bind(':ot_room_id', '0');
            $this->db->bind(':status', '0');
            // Execute
            $this->db->execute();

            $this->db->query('UPDATE ot SET status = :status, room_ref_id = :room_ref_id WHERE ot_id = :id ');
              // Bind values
            $this->db->bind(':id', $id);
            $this->db->bind(':status', '4');
             $this->db->bind(':room_ref_id', '0');
            // Execute
            if($this->db->execute()){
                return true;
            } else {
                return false;
            }
        }


         public function status_edit_update($id)
        {
           
        $this->db->query('UPDATE ot SET status = :status WHERE ot_id = :id ');
              // Bind values
            $this->db->bind(':id', $id);
            $this->db->bind(':status', '2');
            // Execute
            if($this->db->execute()){
                return true;
            } else {
                return false;
            }
        }

        public function status_cancel_update($id)
            {
               
            $this->db->query('UPDATE ot SET status = :status WHERE ot_id = :id ');
                  // Bind values
                $this->db->bind(':id', $id);
                $this->db->bind(':status', '0');
                // Execute
                if($this->db->execute()){
                    return true;
                } else {
                    return false;
                }
            }
         public function status_ed_op_update($id)
            {
               
            $this->db->query('UPDATE ot SET  status = :status WHERE ot_id = :id ');
                  // Bind values
                $this->db->bind(':id', $id);
                $this->db->bind(':status', '3');
                // Execute
                if($this->db->execute()){
                    return true;
                } else {
                    return false;
                }
            }

        public function finish_operation_statusup($id)
            {

               $this->db->query('SELECT * FROM ot WHERE ot_id = :id ');
               $this->db->bind(':id', $id);
               $row = $this->db->single();
               $ro_no=$row->room_ref_id;

              $this->db->query('UPDATE rooms SET  status = :status, ot_room_id = :ot_room_id WHERE id = :ro_no ');
                  // Bind values
                $this->db->bind(':ro_no', $ro_no);
                $this->db->bind(':ot_room_id', '0');
                $this->db->bind(':status', '0');
                // Execute
                if($this->db->execute()){
                    return true;
                } else {
                    return false;
                }
            }
            


         public function get_single_operation_fromot($id)
        {
            $this->db->query('SELECT ot_id, ip_op_ref, ip_op_doc_ref_id, ot_date, ot_name, ot_description, status, feedback, patient_id, created_at FROM ot WHERE ot_id = :id');
            $this->db->bind(':id', $id);
            $row = $this->db->single();
            return $row;
        }

        public function service_details($id)
        {
           
        $this->db->query('SELECT * FROM ot_services WHERE ot_ref_id = :id ');
              // Bind values
            $this->db->bind(':id', $id);
            // Execute
            $row = $this->db->resultSet();
            return $row;
        }


        public function get_single_operation_frompatient($id)
        {
           $this->db->query('SELECT patient_name, patient_gender, patient_dob, patient_age, patient_phone, patient_email, patient_address, hypertension, diabetes, coronary, cerebro, dyslipidaemia, hypothyroidism, other, patient_history, family_history, password, registered_time, active, age_update_time, patient_height, patient_weight, patient_photo FROM patients WHERE patient_id = :id');
           $this->db->bind(':id', $id);
           $row = $this->db->single();
           return $row;
        }

         public function get_single_operation_fromusers($id)
        {
           $this->db->query('SELECT mem_name FROM users WHERE mem_id = :id');
           $this->db->bind(':id', $id);
           $row = $this->db->single();
           return $row;
        }
        public function get_single_operation_fromipd($id)
        {
           $this->db->query('SELECT admission_date_time FROM ipd WHERE ipd_patient_id = :id');
           $this->db->bind(':id', $id); 
           $row = $this->db->single();
           return $row;
        }
        
        
         public function save_edit_operation($data)
        {
             $this->db->query('UPDATE ot SET  ot_date = :op_date_time, ot_description = :description, feedback = :feedback WHERE ot_id = :id');
            // Bind values

            $this->db->bind(':id', $data['id']);
            $this->db->bind(':op_date_time', $data['op_date_time']);
            $this->db->bind(':description', $data['description']);
            $this->db->bind(':feedback', $data['feedback']);
           
            // Execute
            if($this->db->execute()){
                return true;
            } else {
                return false;
            }
        }
                           
         public function new_add_operation($data)
        {
             $this->db->query('INSERT INTO ot(ip_op_doc_ref_id, ot_date, ot_name, ot_description, status, patient_id) VALUES (:r_doctor_id, :op_date_time, :op_name, :description, :status, :patient_id )');
            // Bind values
            $this->db->bind(':patient_id', $data['patient_id']);
            $this->db->bind(':op_date_time', $data['op_date_time']);
            $this->db->bind(':r_doctor_id', $data['r_doctor_id']);
            $this->db->bind(':op_name', $data['op_name']);
            $this->db->bind(':description', $data['description']);
            $this->db->bind(':status', '0');
           
            // Execute
            if($this->db->execute()){
                return true;
            } else {
                return false;
            }
        }

         public function update_service_row_ots($data)
        {
             $this->db->query('INSERT INTO `ot_services`(`ot_ref_id`, `services`, `price`) VALUES (:ot_ref_id, :services, :cost)');
            // Bind values
            $this->db->bind(':ot_ref_id', $data['id']);
            $this->db->bind(':services', $data['services']);
            $this->db->bind(':cost', $data['cost']);
            // Execute
            if($this->db->execute()){
                return true;
            } else {
                return false;
            }
        }


    public function get_patient_ot_details($yr, $yrl)
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
        $this->db->bind(':yr', $yr);
        $this->db->bind(':yrl', $yrl);
        $row = $this->db->resultSet();
        return $row;
    }


    //  public function get_order_count_yr($yr, $yrl)
    // {
    //     $this->db->query('SELECT * FROM ot WHERE date(ot_date) BETWEEN :yr AND :yrl');
    //     $this->db->bind(':yr', $yr);
    //     $this->db->bind(':yrl', $yrl);
    //     $this->db->single();
    //     $count = $this->db->rowCount();
    //     return $count;
    // }
    public function get_logo_details()
    {
        $this->db->query('SELECT * FROM service_provider ORDER BY ser_pro_id DESC LIMIT 1');
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

     public function currentop_count()
    {
        $this->db->query('SELECT * FROM ot where status=0');
        $row = $this->db->resultSet();
        $count = $this->db->rowCount();
        return $count;
    }
     public function activeop_count()
    {
        $this->db->query('SELECT * FROM ot where status=1 OR status=2');
        $row = $this->db->resultSet();
        $count = $this->db->rowCount();
        return $count;
    }
     public function completedop_count()
    {
        $this->db->query('SELECT * FROM ot where status=3');
        $row = $this->db->resultSet();
        $count = $this->db->rowCount();
        return $count;
    }
     public function cancledop_count()
    {
        $this->db->query('SELECT * FROM ot where status=4');
        $row = $this->db->resultSet();
        $count = $this->db->rowCount();
        return $count;
    }


    public function current_room_update_status($data)
        {
            $this->db->query('UPDATE ot SET  room_ref_id = :room_id WHERE ot_id = :ot_id');
            // Bind values

            $this->db->bind(':room_id', $data['room_id']);
            $this->db->bind(':ot_id', $data['ot_id']);
                    
            // Execute
            if($this->db->execute()){
                return true;
            } else {
                return false;
            }
        }
         public function room_status_update($data)
        {
            $this->db->query('UPDATE rooms SET  status = :status, ot_room_id = :ot_id WHERE id = :room_id');
            // Bind values

            $this->db->bind(':room_id', $data['room_id']);
             $this->db->bind(':ot_id', $data['ot_id']);
            $this->db->bind(':status', '1');
                    
            // Execute
            if($this->db->execute()){
                return true;
            } else {
                return false;
            }
        }

         public function room_cancel_status_for_room($id)
        {
            $this->db->query('SELECT * FROM ot WHERE ot_id = :id ');
            $this->db->bind(':id', $id);
            $row = $this->db->single();
            $ro_no=$row->room_ref_id;

            $this->db->query('UPDATE rooms SET  status = :status, ot_room_id = :ot_room_id WHERE id = :ro_no ');
              // Bind values
            $this->db->bind(':ro_no', $ro_no);
            $this->db->bind(':ot_room_id', '0');
            $this->db->bind(':status', '0');
            // Execute
            $this->db->execute();

            $this->db->query('UPDATE ot SET status = :status, room_ref_id = :room_ref_id WHERE ot_id = :id ');
              // Bind values
            $this->db->bind(':id', $id);    
            $this->db->bind(':status', '0');
             $this->db->bind(':room_ref_id', '0');
            // Execute
            if($this->db->execute()){
                return true;
            } else {
                return false;
            }
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

    public function getOtDetailsById($id)
    {
        $this->db->query('SELECT * FROM ot WHERE ot_id = :id');
        $this->db->bind(':id', $id);
        return $row = $this->db->single();
    }
    public function create_asset_db($data)
    {
        $this->db->query('INSERT INTO ot_asset(a_name, a_type, a_amount,a_need,a_date,a_desc) VALUES (:a_name,:a_type,:a_amount,:a_need,:a_date,:a_desc)');
        // Bind values
        $this->db->bind(':a_name', $data['a_name']);
        $this->db->bind(':a_type', $data['a_type']);
        $this->db->bind(':a_amount', $data['a_amount']);
        $this->db->bind(':a_need', $data['a_need']);
        $this->db->bind(':a_date', $data['a_date']);
        $this->db->bind(':a_desc', $data['a_desc']);
        // Execute
        if($this->db->execute()){
            return true;
        } else {
            return false;
        } 
    }
    public function get_ot_assets()
    {
        $this->db->query('SELECT * FROM ot_asset');
        return $row = $this->db->resultSet();
    }
    public function delete_asset_db($id)
    {
        $this->db->query('DELETE FROM ot_asset WHERE id = :id');
        // Bind values
        $this->db->bind(':id', $id);
        // Execute
        if($this->db->execute()){
            return true;
        } else {
            return false;
        } 
    }
}
?>