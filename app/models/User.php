<?php

namespace App\Models;

use App\Core\Model;

class User extends Model {
    public function create($data) {
        $sql = "INSERT INTO users (first_name, last_name, student_number, email, password, role) VALUES (?, ?, ?, ?, ?, ?)";
        $params = [
            $data['first_name'],
            $data['last_name'],
            $data['student_number'],
            $data['email'],
            password_hash($data['password'], PASSWORD_DEFAULT),
            $data['role']
        ];
        return $this->query($sql, $params);
    }

    public function findByEmail($email) {
        return $this->findOne("SELECT * FROM users WHERE email = ?", [$email]);
    }

    public function findById($id) {
        return $this->findOne("SELECT id, username, email, role FROM users WHERE id = ?", [$id]);
    }

    public function getOrganizers() {
        return $this->findAll("SELECT id, username, email FROM users WHERE role = 'organizer'");
    }

    public function getParticipants() {
        return $this->findAll("SELECT id, username, email FROM users WHERE role = 'participant'");
    }

    public function findByStudentNumber($studentNumber) {
        return $this->findOne("SELECT * FROM users WHERE student_number = ?", [$studentNumber]);
    }
} 