<?php

class Product extends Model
{
    // database connection and table name
    protected $table = "products";

    // object properties
    public $id;
    public $name;
    public $description;
    public $price;
    public $category_id;
    public $category_name;
    public $created;

    public function __construct()
    {
        parent::__construct();
    }

    public function getProducts()
    {
        return $this->getTable();
    }

    public function addProduct()
    {
        try {
            $query = "INSERT INTO
              " . $this->table . "
          SET
              name=:name, price=:price, description=:description, category_id=:category_id, created=:created";
            // prepare query
            $this->db->query($query);

            // sanitize
            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->price = htmlspecialchars(strip_tags($this->price));
            $this->description = htmlspecialchars(strip_tags($this->description));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));
            $this->created = htmlspecialchars(strip_tags($this->created));

            // bind values
            $this->db->bind(":name", $this->name);
            $this->db->bind(":price", $this->price);
            $this->db->bind(":description", $this->description);
            $this->db->bind(":category_id", $this->category_id);
            $this->db->bind(":created", $this->created);

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
