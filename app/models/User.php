<?php
ini_set('display_errors', 1);
class User extends Model
{

    protected $table = "users";

    // object properties
    public $id;
    public $name;
    public $birthday;
    public $cin;
    public $email;
    public $password;
    public $img;

    public function __construct()
    {
        parent::__construct();
    }

    public function getUsers()
    {
        return $this->getTable();
    }

    public function getUsersNum()
    {
        return $this->getRowsNum();
    }

    public function add()
    {
        try {
            $query = "INSERT INTO " . $this->table . " (name,birthday,cin,email,password,img) VALUES (:name,:birthday,:cin,:email,:password,:img)";
            // prepare query
            $this->db->query($query);

            // sanitize
            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->birthday = htmlspecialchars(strip_tags($this->birthday));
            $this->cin = htmlspecialchars(strip_tags($this->cin));
            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->password = htmlspecialchars(strip_tags($this->password));
            $this->img = htmlspecialchars(strip_tags($this->img));

            // bind values
            $this->db->bind(":name", $this->name);
            $this->db->bind(":birthday", $this->birthday);
            $this->db->bind(":cin", $this->cin);
            $this->db->bind(":email", $this->email);
            $this->db->bind(":password", $this->password);
            $this->db->bind(":img", $this->img);

            // execute query
            if ($this->db->execute()) {
                return true;
            }
            return false;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    public function login($email, $password)
    {
        try {
            $this->db->query("SELECT * FROM users WHERE email = :email");
            $this->db->bind(':email', $email);
            $row = $this->db->single();
            $hashed_password = $row->password;
            if (password_verify($password, $hashed_password)) {
                return $row;
            } else {
                return false;
            }
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    public function update()
    {
        try {
            $query = "UPDATE " . $this->table . " SET name=:name,birthday=:birthday,cin=:cin,email=:email,password=:password,img=:img WHERE id = :id";
            $this->db->query($query);
            $this->db->bind(":id", $this->id);
            $this->db->bind(":name", $this->name);
            $this->db->bind(":birthday", $this->birthday);
            $this->db->bind(":cin", $this->cin);
            $this->db->bind(":email", $this->email);
            $this->db->bind(":password", $this->password);
            $this->db->bind(":img", $this->img);
            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    public function getLoggedUserInfo($id)
    {
        return $this->LoggedInUser($id);
    }
}
