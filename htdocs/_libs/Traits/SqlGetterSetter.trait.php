<?
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
        
        $property = preg_replace("/[^0-9a-zA-Z]/", "", substr($name, 3));
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
        try {
            $query = "UPDATE `$this->table` SET `$name`=? WHERE `id`=?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("si", $value, $this->id);
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            throw new Exception(__CLASS__ . "::_set_data -> cannot set the data.");
        }
    }

    public function _get_data($name)
    {
        try {
            $query = "SELECT `$name` FROM `$this->table` WHERE `id`=?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("i", $this->id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows) {
                $row = $result->fetch_assoc();
                return $row[$name];
            }
        } catch (Exception $e) {
            throw new Exception(__CLASS__ . "::_get_data -> cannot get the data.");
        }
    }

    public function delete(){
        if (!$this->conn) {
            $this->conn = Database::getConnection();
        }
        try {
            $query = "DELETE FROM `$this->table` WHERE `id`=?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("i", $this->id);
            if ($stmt->execute()) {
               return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            throw new Exception(__CLASS__ . ":: delete -> cannot delete data.");
        }
    }

    public function getId(){
        return $this->id;
    }
}
?>