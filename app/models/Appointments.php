<?php
class Appointments
{
	private $db;

	public function __construct()
	{
		$this->db = new Database;
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

    public function getTheDoctorBySpecialtyDb($spec)
    {
        $this->db->query('SELECT * FROM doctors WHERE doctor_speciality = :spec');
        $this->db->bind(':spec', $spec);
        return $row = $this->db->resultSet();
    }

    public function checkAppointment($data)
    {
        $doc = explode('(', $data['docName']);
        $docName = $doc[0];
        $docI = explode(')', $doc[1]);
        $docId = $docI[0];
        $this->db->query('INSERT INTO appointments (patient_name, patient_phone, doctor_name, doctor_id, status, doctor_specialty, patient_id) VALUES(:patientName, :phoneNumberWithout, :docName, :docId, 0, :docSpec, :patientId)');
        $this->db->bind(':patientName', $data['patientName']);
        $this->db->bind(':phoneNumberWithout', $data['phoneNumberWithout']);
        $this->db->bind(':docName', $docName);
        $this->db->bind(':docId', $docId);
        $this->db->bind(':docSpec', $data['docSpec']);
        $this->db->bind(':patientId', $data['patientId']);
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
?>