<?php

class Available_Appointment extends Model
{

    protected $table = "available_appointments";

    // object properties
    public $id;
    public $date;
    public $time;
    public $taken;
    public $doctor_id;

    public function __construct()
    {
        parent::__construct();
    }

    public function getAvailableAppointments()
    {
        return $this->getTable();
    }

    public function getAvailableAppointmentsNum()
    {
        return $this->getRowsNum();
    }

    public function add()
    {
        try {
            $query = "INSERT INTO " . $this->table . " (date,time,taken,doctor_id) VALUES (:date,:time,:taken,:doctor_id)";
            $this->db->query($query);

            $this->date = htmlspecialchars(strip_tags($this->date));
            $this->time = htmlspecialchars(strip_tags($this->time));
            $this->taken = htmlspecialchars(strip_tags($this->taken));
            $this->doctor_id = htmlspecialchars(strip_tags($this->doctor_id));

            $this->db->bind(":date", $this->date);
            $this->db->bind(":time", $this->time);
            $this->db->bind(":taken", $this->taken);
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
}
