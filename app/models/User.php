<?php

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

    public function __construct()
    {
        parent::__construct();
    }

    public function getUsers()
    {
        $this->getTable();
    }

    public function add()
    {
        try {
            $query = "INSERT INTO " . $this->table . " (name,birthday,cin,email,password) VALUES (name=:name, birthday=:birthday, cin=:cin, email=:email, password=:password)";
            // prepare query
            $this->db->query($query);

            // sanitize
            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->birthday = htmlspecialchars(strip_tags($this->birthday));
            $this->cin = htmlspecialchars(strip_tags($this->cin));
            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->password = htmlspecialchars(strip_tags($this->password));

            // bind values
            $this->db->bind(":name", $this->name);
            $this->db->bind(":birthday", $this->birthday);
            $this->db->bind(":cin", $this->cin);
            $this->db->bind(":email", $this->email);
            $this->db->bind(":password", $this->password);

            // execute query
            if ($this->db->execute()) {
                return true;
            }
            return false;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
}
