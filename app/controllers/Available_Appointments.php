<?php
ini_set('display_errors', 1);
require_once "../app/controllers/auth_headers.php";
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
            $slots_num = count($data->time);
            $this->availableAppointmentModel->date = $data->date;
            $this->availableAppointmentModel->time = $slots_num;
            $this->availableAppointmentModel->slot = $data->time;
            $this->availableAppointmentModel->taken = $data->taken;
            $this->availableAppointmentModel->doctor_id = $data->doctor_id;

            //die(print_r($data->time));
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

    public function getAppointmentsInfo()
    {
        $this->response = [];
        $result = $this->availableAppointmentModel->getFreeAppointmentInfo();
        if ($result) {
            $this->response += ["Appointments" => $result];
            http_response_code(200);
            echo json_encode($this->response);
            exit;
        } else {
            $this->response += ["message" => "Failed fetching data"];
            http_response_code(503);
            echo json_encode($this->response);
            exit;
        }
    }
}
