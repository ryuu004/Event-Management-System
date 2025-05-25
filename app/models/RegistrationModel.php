<?php

class RegistrationModel {
    public function getParticipantEvents($userId) {
        $sql = "SELECT event_id FROM registrations WHERE user_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} 