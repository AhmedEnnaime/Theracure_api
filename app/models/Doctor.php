<?php

class Doctor extends Model
{

    protected $table = "doctors";

    // object properties
    public $id;
    public $name;
    public $birthday;
    public $cin;
    public $email;
    public $password;
    public $img;
    public $speciality;

    public function __construct()
    {
        parent::__construct();
    }

    public function getDoctors()
    {
        return $this->getTable();
    }

    public function add()
    {
        try {
            $query = "INSERT INTO " . $this->table . " (name, birthday, cin, email, password, img, speciality) VALUES (:name, :birthday, :cin, :email, :password, :img, :speciality)";
            // prepare query
            $this->db->query($query);

            // sanitize
            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->birthday = htmlspecialchars(strip_tags($this->birthday));
            $this->cin = htmlspecialchars(strip_tags($this->cin));
            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->password = htmlspecialchars(strip_tags($this->password));
            $this->img = htmlspecialchars(strip_tags($this->img));
            $this->img = htmlspecialchars(strip_tags($this->speciality));

            // bind values
            $this->db->bind(":name", $this->name);
            $this->db->bind(":birthday", $this->birthday);
            $this->db->bind(":cin", $this->cin);
            $this->db->bind(":email", $this->email);
            $this->db->bind(":password", $this->password);
            $this->db->bind(":img", $this->img);
            $this->db->bind(":speciality", $this->speciality);

            // execute query
            if ($this->db->execute()) {
                return true;
            }
            return false;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    public function getDoctorsNum()
    {
        return $this->getRowsNum();
    }

    public function getDoctorByAppointments()
    {
        try {
            $query = "SELECT d.name,d.speciality,aa.* FROM doctors d JOIN available_appointments aa ON d.id = aa.doctor_id WHERE aa.taken = 0";
            $this->db->query($query);
            $result = $this->db->resultSet();
            return $result;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
}
