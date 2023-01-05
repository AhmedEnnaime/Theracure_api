<?php
require_once "../app/controllers/headers.php";

class Doctors extends Controller
{

    public $doctorModel;
    public $response;

    public function __construct()
    {
        $this->doctorModel = $this->model('Doctor');
    }

    public function index()
    {
    }

    public function signup()
    {
        $data = json_decode(file_get_contents("php://input"));
        if (!empty($data->name) && !empty($data->birthday) && !empty($data->cin) && !empty($data->email) && !empty($data->password) && !empty($data->speciality)) {
            $data->password = password_hash($data->password, PASSWORD_BCRYPT);
            $this->response = [];
            $this->doctorModel->name = $data->name;
            $this->doctorModel->birthday = $data->birthday;
            $this->doctorModel->cin = $data->cin;
            $this->doctorModel->email = $data->email;
            $this->doctorModel->password = $data->password;
            $this->doctorModel->img = $data->img;
            $this->doctorModel->speciality = $data->speciality;
            $result = $this->doctorModel->add();
            if ($result) {
                $this->response += ["message" => "Doctor created successfully", "data" => $data];
                http_response_code(201);
                echo json_encode($this->response);
                exit;
            } else {
                $this->response += ["message" => "Failed creating doctor"];
                http_response_code(503);
                echo json_encode($this->response);
                exit;
            }
        }
    }

    public function getDoctorsNum()
    {
        $this->response = [];
        $result = $this->doctorModel->getDoctorsNum();

        if ($result) {
            $this->response += ["doctors" => $result->total];
            http_response_code(200);
            echo json_encode($this->response);
            exit;
        } else {
            $this->response += ["message" => "No doctor found"];
            http_response_code(401);
            echo json_encode($this->response);
            exit;
        }
    }

    public function getAllDoctors()
    {
        $this->response = [];
        $result = $this->doctorModel->getDoctors();
        $count = $this->doctorModel->getDoctorsNum();
        if ($count > 0) {
            if ($result) {
                $this->response += ["Doctors" => $result];
                http_response_code(200);
                echo json_encode($this->response);
                exit;
            } else {
                $this->response += ["message" => "Failed fetching data"];
                http_response_code(503);
                echo json_encode($this->response);
                exit;
            }
        } else {
            $this->response += ["message" => "No doctor available"];
            http_response_code(200);
            echo json_encode($this->response);
            exit;
        }
    }
}
