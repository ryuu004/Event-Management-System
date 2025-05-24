<?php

namespace App\Models;

use App\Core\Model;

class User extends Model {
    public function create($data) {
        $sql = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";
        $params = [$data['username'], $data['email'], password_hash($data['password'], PASSWORD_DEFAULT), $data['role']];
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
} 