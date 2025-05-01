<?php
class Patient
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

     public function get_patient_id_using_session()
    {
    
        $this->db->query('SELECT * FROM patients WHERE patient_email = :patient_email');
        $this->db->bind(':patient_email', $_SESSION['email']);
        $row = $this->db->single();
        return $row;
    }
    
     public function update_password_db($cpass, $id, $photo)
    {
        $this->db->query('UPDATE patients SET password = :cpass, patient_photo = :photo WHERE patient_id = :id');
        $this->db->bind(':cpass', $cpass);
        $this->db->bind(':id', $id);
        $this->db->bind(':photo', $photo);
        $this->db->execute();
        return true;
    }
     public function get_mem_data($user_id)
    {
        $this->db->query('SELECT * FROM patients WHERE patient_id = :user_id');
        $this->db->bind(':user_id', $user_id);
        $row = $this->db->resultSet();
        return $row;
    }
     public function get_mem_data1($user_id)
    {
        $this->db->query('SELECT * FROM users WHERE mem_id = :user_id');
        $this->db->bind(':user_id', $user_id);
        $row = $this->db->resultSet();
        return $row;
    }
     public function get_all_prescription_pat($lim,$off)
    {
        $pid = $_SESSION['patient_id'];
        $this->db->query('SELECT * FROM opd WHERE visit_status = 1 AND opd_patient_id = :pid AND mh_id = :mh_id ORDER BY opd_visit_id DESC limit :lim OFFSET :off ');
        $this->db->bind(':lim',$lim);
        $this->db->bind(':off',$off);
        $this->db->bind(':pid', $pid);
        $this->db->bind(':mh_id', $_SESSION['mh_id_medhike_87_71_18_08_80_none_med_hi_ke_no']);
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
     public function get_patient_by_id($p_id)
    {
        $this->db->query('SELECT * FROM patients WHERE patient_id = :p_id');
        $this->db->bind(':p_id',$p_id);
        $row = $this->db->resultSet();
        return $row;
    }
}
?>
