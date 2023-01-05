<?php
ini_set('display_errors', 1);
require_once "../app/controllers/headers.php";
class Available_Appointments extends Controller
{
    public $availableAppointmentModel;
    public $response;

    public function __construct()
    {
        $this->availableAppointmentModel = $this->model('Available_Appointment');
    }

    public function index()
    {
    }

    public function addAppointment()
    {
        $data = json_decode(file_get_contents("php://input"));
        if (!empty($data->date) && !empty($data->time)) {
            $this->response = [];
            //date_default_timezone_set("Africa/Casablanca");
            $this->availableAppointmentModel->date = $data->date;
            $this->availableAppointmentModel->time = $data->time;
            $this->availableAppointmentModel->taken = $data->taken;
            $this->availableAppointmentModel->doctor_id = $data->doctor_id;
            $result = $this->availableAppointmentModel->add();
            if ($result) {
                $this->response += ["message" => "Appointment sets successfully", "data" => $data];
                http_response_code(201);
                echo json_encode($this->response);
                exit;
            } else {
                $this->response += ["message" => "Failed to set appointment"];
                http_response_code(503);
                echo json_encode($this->response);
                exit;
            }
        } else {
            $this->response += ["message" => "Fill all fields please"];
            echo json_encode($this->response);
            exit;
        }
    }
}
