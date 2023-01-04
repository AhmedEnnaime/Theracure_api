<?php


class Appointment extends Model
{

    protected $table = "appointments";

    // object properties
    public $id;
    public $date;
    public $time;
    public $user_id;
    public $doctor_id;

    public function __construct()
    {
        parent::__construct();
    }

    public function getAppointments()
    {
        return $this->getTable();
    }

    public function getAppointmentsNum()
    {
        return $this->getRowsNum();
    }

    public function add()
    {
        try {
            $query = "INSERT INTO " . $this->table . " (date,time,user_id,doctor_id) VALUES (:date,:time,:user_id,:doctor_id)";
            $this->db->query($query);

            $this->date = htmlspecialchars(strip_tags($this->date));
            $this->time = htmlspecialchars(strip_tags($this->time));
            $this->user_id = htmlspecialchars(strip_tags($this->user_id));
            $this->doctor_id = htmlspecialchars(strip_tags($this->doctor_id));

            $this->db->bind(":date", $this->date);
            $this->db->bind(":time", $this->time);
            $this->db->bind(":user_id", $this->user_id);
            $this->db->bind(":doctor_id", $this->doctor_id);

            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    public function deleteAppointment($id)
    {
        return $this->delete($id, $this->id);
    }
}
