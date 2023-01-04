<?php
ini_set('display_errors', 1);
require_once "../app/controllers/headers.php";
class Appointments extends Controller
{

    public $appointmentModel;
    public $response;

    public function __construct()
    {
        $this->appointmentModel = $this->model('Appointment');
    }

    public function index()
    {
    }

    public function takeAppointment()
    {
        $data = json_decode(file_get_contents("php://input"));
        if (!empty($data->date) && !empty($data->time) && !empty($data->user_id) && !empty($data->doctor_id)) {
            $this->response = [];
            date_default_timezone_set("Africa/Casablanca");
            $this->appointmentModel->date = $data->date;
            $this->appointmentModel->time = $data->time;
            $this->appointmentModel->user_id = $data->user_id;
            $this->appointmentModel->doctor_id = $data->doctor_id;
            $result = $this->appointmentModel->add();
            if ($result) {
                $this->response += ["message" => "Appointment taken successfully", "data" => $data];
                http_response_code(201);
                echo json_encode($this->response);
                exit;
            } else {
                $this->response += ["message" => "Failed to take appointment"];
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
