<?php
ini_set('display_errors', 1);
require_once "../app/controllers/headers.php";
class Users extends Controller
{

    public $userModel;
    public $response;

    public function __construct()
    {
        $this->userModel = $this->model('User');
    }

    public function index()
    {
    }

    public function signup()
    {
        $data = json_decode(file_get_contents("php://input"));
        //die(print_r($data));
        if (!empty($data->name) && !empty($data->birthday) && !empty($data->cin) && !empty($data->email) && !empty($data->password)) {
            $data->password = password_hash($data->password, PASSWORD_BCRYPT);
            $this->response = [];
            $this->userModel->name = $data->name;
            $this->userModel->birthday = date('Y-m-d');
            $this->userModel->cin = $data->cin;
            $this->userModel->email = $data->email;
            $this->userModel->password = $data->password;
            $this->userModel->img = $data->img;
            $result = $this->userModel->add();
            if ($result) {
                $this->response += ["message" => "User created successfully", "data" => $data];
                http_response_code(201);
                echo json_encode($this->response);
                exit;
            } else {
                $this->response += ["message" => "Failed creating user"];
                http_response_code(503);
                echo json_encode($this->response);
                exit;
            }
        }
        //print_r($data);
        //die;
    }

    public function getAllUsers()
    {
        $this->response = [];
        $result = $this->userModel->getUsers();
        if ($result) {
            $this->response += ["Users" => $result];
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

    public function login()
    {
        $this->response = [];
        $data = json_decode(file_get_contents("php://input"));
        if (!empty($data->email) && !empty($data->password)) {
            $loggedInUser = $this->userModel->login($data->email, $data->password);
            if ($loggedInUser) {
                $this->response += ["User logged in with the following credentials" => $data];
                http_response_code(200);
                echo json_encode($this->response);
                exit;
            } else {
                $this->response += ["message" => "Login failed"];
                http_response_code(401);
                echo json_encode($this->response);
                exit;
            }
        }
    }
}
