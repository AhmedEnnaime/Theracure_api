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

    public function takeAppointment($userId)
    {
        $this->response = [];
        $data = json_decode(file_get_contents("php://input"));
        if (!empty($data->date) && !empty($data->schedule_id) && !empty($data->user_id)) {
            $this->appointmentModel->date = $data->date;
            $this->appointmentModel->user_id = $userId;
            $this->appointmentModel->schedule_id = $data->schedule_id;

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

    public function cancelAppointment()
    {
        $path = explode('/', $_SERVER['REQUEST_URI']);
        $this->response = [];
        $this->appointmentModel->schedule_id = $path[5];
        $this->appointmentModel->id = $path[6];
        $appointment = $this->appointmentModel->getSingleAppointment();
        $result = $this->appointmentModel->deleteAppointment();

        if ($appointment) {
            if ($result) {
                $this->response += ["message" => "Appointment canceled successfully"];
                http_response_code(200);
                echo json_encode($this->response);
                exit;
            } else {
                $this->response += ["message" => "Failed to cancel appointment"];
                http_response_code(503);
                echo json_encode($this->response);
                exit;
            }
        } else {
            $this->response += ["message" => "Appointment not found"];
            http_response_code(404);
            echo json_encode($this->response);
            exit;
        }
    }

    public function getLoggedInUserAppointments($userId)
    {
        $this->response = [];
        $this->appointmentModel->user_id = $userId;
        $result = $this->appointmentModel->getAppointmentsByUserId();
        if ($result) {
            $this->response += ["Appointments" => $result];
            http_response_code(200);
            echo json_encode($this->response);
            exit;
        } else {
            $this->response += ["message" => "Appointments not found"];
            http_response_code(404);
            echo json_encode($this->response);
            exit;
        }
    }
}
