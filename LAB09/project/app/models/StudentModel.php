<?php
require_once __DIR__ . '/../core/Database.php';

class StudentModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function all() {
        return $this->db->query("SELECT * FROM students ORDER BY id DESC")->fetchAll();
    }

    public function create($data) {
        $sql = "INSERT INTO students(code, full_name, email, dob)
                VALUES (:code, :full_name, :email, :dob)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    public function update($id, $data) {
        $sql = "UPDATE students SET code=:code, full_name=:full_name,
                email=:email, dob=:dob WHERE id=:id";
        $data['id'] = $id;
        return $this->db->prepare($sql)->execute($data);
    }

    public function delete($id) {
        return $this->db->prepare("DELETE FROM students WHERE id=?")
                        ->execute([$id]);
    }
}
