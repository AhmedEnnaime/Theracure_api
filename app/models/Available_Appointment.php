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
    public $slot;
    public $appointment_id;

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
            $query = "INSERT INTO " . $this->table . " (date,time,doctor_id) VALUES (:date,:time,:doctor_id)";
            $this->db->query($query);

            $this->date = htmlspecialchars(strip_tags($this->date));
            $this->time = htmlspecialchars(strip_tags($this->time));
            $this->doctor_id = htmlspecialchars(strip_tags($this->doctor_id));

            $this->db->bind(":date", $this->date);
            $this->db->bind(":time", $this->time);
            $this->db->bind(":doctor_id", $this->doctor_id);

            if ($this->db->execute()) {
                $this->db->query("SELECT * FROM available_appointments ORDER BY id DESC LIMIT 1");
                $row = $this->db->single();
                if (!$this->db->execute())
                    return false;
                foreach ($this->slot as $slt) {
                    $this->db->query("INSERT INTO schedule (slot,appointment_id,taken) VALUES (:slot,:appointment_id,:taken)");
                    $this->db->bind(":slot", $slt);
                    $this->db->bind(":appointment_id", $row->id);
                    $this->db->bind(":taken", $this->taken);
                    $this->db->execute();
                }
                return true;
            } else {
                return false;
            }
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
}
