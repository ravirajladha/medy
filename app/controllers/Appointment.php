<?php
/**
 * 
 */
class Appointment extends Controller
{
	
	function __construct()
	{
		$this->appModel = $this->model('Appointments');
	}

	public function index()
	{
        $data = [
            'loginPage' => $this->appModel->getTheLoginPage(),
            'specialty' => $this->appModel->getAllTheSpecialty(),
        ];
		$this->view('appointment/index', $data);
    }
    
    public function getTheDoctorBySpecialty()
    {
        $spec = $_POST['spec'];
        $doc = $this->appModel->getTheDoctorBySpecialtyDb($spec);
        $output = '';

        foreach ($doc as $key)
        {
            $output .= "<option>".$key->doctor_name."<small>(".$key->doctor_id.")</small></option>";
        }
        echo $output;
    }

    public function bookAppointment()
    {
        if(isset($_POST['patientId']) && isset($_POST['patientName']) && isset($_POST['phoneNumberWithout']))
        {
            $_SESSION['fillAll'] = 1; 
            redirect('appointment/index');
        }
        $data = [
            'hos_id' => $_POST['hos_id'],
            'patientId' => $_POST['patientId'],
            'docSpec' => $_POST['docSpec'],
            'docName' => $_POST['docName'],
            'date' => $_POST['date'],
            'patientName' => $_POST['patientName'],
            'phoneNumberWithout' => $_POST['phoneNumberWithout'],
        ];
        if($this->appModel->checkAppointment($data))
        {
            $_SESSION['appStatus'] = 1;
            unset($_SESSION['fillAll']);
            redirect('appointment/index');
        }
    }
}
?>