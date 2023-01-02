<?php

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
        if (!empty($data->name) && !empty($data->birthday) && !empty($data->cin) && !empty($data->email) && !empty($data->password)) {
            $this->response = [];
            $this->doctorModel->name = $data->name;
            $this->doctorModel->birthday = date('Y-m-d');
            $this->doctorModel->cin = $data->cin;
            $this->doctorModel->email = $data->email;
            $this->doctorModel->password = $data->password;
            $this->doctorModel->img = $data->img;
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
        //print_r($data);
        //die;
    }
}
