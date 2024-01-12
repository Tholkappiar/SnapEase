<?php

trait SqlGetterSetter
{

    public $id;
    public $conn;
    public $table;

    public function __call($name, $attributes)
    {

        if (!$this->conn) {
            $this->conn = Database::getConnection();
        }
        // To get the property name without the get or set in the start
        $property = preg_replace("/[^0-9a-zA-Z]/", "", substr($name, 3));
        // To convert camelCase to Snake_Case and meke it lowerCase
        $property = strtolower(preg_replace('/\B([A-Z])/', '_$1', $property));

        if (substr($name, 0, 3) == "set") {
            return $this->_set_data($property, $attributes[0]);
        } else if (substr($name, 0, 3) == "get") {
            return $this->_get_data($property);
        } else {
            throw new Exception(__CLASS__ . "__call function : $name");
        }
    }

    public function _set_data($name, $value)
    {
        if (!$this->conn) {
            $this->conn = Database::getConnection();
        }
        try {
            $query = "UPDATE `$this->table` SET `$name`='$value' WHERE `id`='$this->id';";
            if ($this->conn->query($query)) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            throw new Exception(__CLASS__ . "::__set_data -> cannot set the data.");
        }
    }

    public function _get_data($name)
    {
        if (!$this->conn) {
            $this->conn = Database::getConnection();
        }

        try {
            $query = "SELECT `$name` FROM `$this->table` WHERE `id`='$this->id';";
            $result = $this->conn->query($query);
            if ($result->num_rows) {
                $row = $result->fetch_assoc();
                return $row[$name];
            }
        } catch (Exception $e) {
            throw new Exception( __CLASS__ . "::_get_data -> cannot get the data.");
        }
    }

    public function delete(){
        if (!$this->conn) {
            $this->conn = Database::getConnection();
        }

        try {
            $query = "DELETE FROM `$this->table` WHERE `id`='$this->id';";
            if ($this->conn->query($query)) {
               return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            throw new Exception( __CLASS__ . ":: delete -> cannot delete data.");
        }
    }

    public function getId(){
        return $this->id;
    }
}
