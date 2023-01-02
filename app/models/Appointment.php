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
}
