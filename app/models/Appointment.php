<?php
ini_set('display_errors', 1);

class Appointment extends Model
{

    protected $table = "appointments";

    // object properties
    public $id;
    public $date;
    public $user_id;
    public $schedule_id;

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

    public function getSingleAppointment()
    {
        return $this->getElementById($this->id);
    }

    public function add()
    {
        try {
            $query = "INSERT INTO " . $this->table . " (date,user_id,schedule_id) VALUES (:date,:user_id,:schedule_id)";
            $this->db->query($query);

            $this->date = htmlspecialchars(strip_tags($this->date));
            $this->user_id = htmlspecialchars(strip_tags($this->user_id));
            $this->schedule_id = htmlspecialchars(strip_tags($this->schedule_id));

            $this->db->bind(":date", $this->date);
            $this->db->bind(":user_id", $this->user_id);
            $this->db->bind(":schedule_id", $this->schedule_id);

            if ($this->db->execute()) {
                $this->db->query("SELECT * FROM schedule WHERE id = :id");
                $this->db->bind(":id", $this->schedule_id);
                $row = $this->db->single();
                if ($row) {
                    $this->db->query("UPDATE available_appointments SET time = time-1 WHERE id = :id");
                    $this->db->bind(":id", $row->appointment_id);
                    if ($this->db->execute()) {
                        $this->db->query("UPDATE schedule SET taken = 1 WHERE id = :id");
                        $this->db->bind(":id", $this->schedule_id);
                        if ($this->db->execute()) {
                            //die(print("success"));
                            return true;
                        }
                    }
                }
            } else {
                return false;
            }
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    public function getAppointmentsByUserId()
    {
        try {
            $query = "SELECT a.*,s.slot,d.name as doctor_name,d.img as doctor_img FROM appointments a JOIN schedule s ON a.schedule_id = s.id JOIN available_appointments av ON s.appointment_id = av.id JOIN doctors d ON d.id = av.doctor_id WHERE a.user_id = :user_id;";
            $this->db->query($query);
            $this->db->bind(":user_id", $this->user_id);
            $result = $this->db->resultSet();
            return $result;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    public function deleteAppointment()
    {
        try {
            $this->db->query("SELECT * FROM schedule WHERE id = :id");
            $this->db->bind(":id", $this->schedule_id);
            $row = $this->db->single();
            if ($row && $this->getSingleAppointment()) {
                $this->db->query("UPDATE available_appointments SET time = time+1 WHERE id = :id");
                $this->db->bind(":id", $row->appointment_id);
                if ($this->db->execute()) {
                    $this->db->query("UPDATE schedule SET taken = 0 WHERE id = :id");
                    $this->db->bind(":id", $this->schedule_id);
                    if ($this->db->execute()) {
                        if ($this->delete($this->id)) {
                            return true;
                        }
                    }
                }
            } else {
                return false;
            }
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
}
