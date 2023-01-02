<?php
//ini_set('display_errors', 1);
require_once "../app/controllers/headers.php";

class Products extends Controller
{
    public $productModel;
    public $response;

    public function __construct()
    {
        $this->productModel = $this->model('Product');
    }

    //default method
    public function index()
    {
    }

    public function add()
    {
        // get posted data
        $data = json_decode(file_get_contents("php://input"));
        //print_r($data->price);
        //die;
        if (!empty($data->name) && !empty($data->price) && !empty($data->description) && !empty($data->category_id)) {
            $this->response = [];
            $this->productModel->name = $data->name;
            $this->productModel->price = $data->price;
            $this->productModel->description = $data->description;
            $this->productModel->category_id = $data->category_id;
            $this->productModel->created = date('Y-m-d H:i:s');
            $result = $this->productModel->addProduct();
            if ($result) {
                $this->response += ["message" => "Product created successfully", "data" => $data];
                http_response_code(201);
                echo json_encode($this->response);
                exit;
            } else {
                $this->response += ["message" => "Failed creating product"];
                http_response_code(503);
                echo json_encode($this->response);
                exit;
            }
        }
    }
}
