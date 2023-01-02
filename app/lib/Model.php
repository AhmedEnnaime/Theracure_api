<?php
//ini_set('display_errors', 1);
class Model
{
    protected $db;
    protected $table = "";

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getTable()
    {
        $this->db->query("SELECT * FROM " . $this->table);
        $result = $this->db->resultSet();
        return $result;
    }


    public function getSpecific($col, $constraint, $orderBy)
    {
        $this->db->query("SELECT * FROM $this->table WHERE $col = :constrnt ORDER BY :ordrby DESC");
        $this->db->bind(":constrnt", $constraint);
        $this->db->bind(":ordrby", $orderBy);

        $result = $this->db->resultSet();
        return $result;
    }


    public function getRecordHighestID($id)
    {
        $this->db->query("SELECT * FROM $this->table WHERE $id = (SELECT max($id) FROM $this->table)");
        $record = $this->db->single();
        $maxID = $record->$id;
        return $maxID;
    }

    public function getElementById($id)
    {
        $this->db->query("SELECT * FROM $this->table WHERE $id = :id");
        $this->db->bind(":id", $id);
        $row = $this->db->single();
        return $row;
    }

    public function delete($id, $val)
    {
        $this->db->query("DELETE FROM $this->table WHERE $id = '$val'");
        $this->db->execute();
    }
}
