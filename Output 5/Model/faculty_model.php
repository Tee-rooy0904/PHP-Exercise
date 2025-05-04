<?php
require_once(__DIR__ . '/../db.php');

class FacultyModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        $sql = "SELECT * FROM faculty";
        $result = $this->conn->query($sql);
        
        if ($result === false) {
            throw new Exception("Query failed: " . $this->conn->error);
        }
        
        return $result->fetch_all(MYSQLI_ASSOC);
    }
 
    public function create($first_name, $middle_name, $last_name, $age, $gender, $address, $position, $salary) {
        $sql = "INSERT INTO faculty (first_name, middle_name, last_name, age, gender, address, position, salary) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssssssd", $first_name, $middle_name, $last_name, $age, $gender, $address, $position, $salary);
        return $stmt->execute();
    }

  
    public function update($id, $first_name, $middle_name, $last_name, $age, $gender, $address, $position, $salary) {
        $sql = "UPDATE faculty SET first_name = ?, middle_name = ?, last_name = ?, age = ?, gender = ?, address = ?, position = ?, salary = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssssssd", $first_name, $middle_name, $last_name, $age, $gender, $address, $position, $salary, $id);
        return $stmt->execute();
    }

    
    public function delete($id) {
        $sql = "DELETE FROM faculty WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("d", $id);
        return $stmt->execute();
    }

   
    public function getById($id) {
        $sql = "SELECT * FROM faculty WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("d", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}

?>