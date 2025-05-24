<?php

namespace App\Models;

use App\Core\Model;

class EventRegistration extends Model {
    public function register($eventId, $participantId) {
        // Generate unique ticket code
        $ticketCode = strtoupper(bin2hex(random_bytes(4)));
        
        $sql = "INSERT INTO event_registrations (event_id, participant_id, ticket_code) 
                VALUES (?, ?, ?)";
        return $this->query($sql, [$eventId, $participantId, $ticketCode]);
    }

    public function getParticipantEvents($participantId) {
        return $this->findAll("SELECT e.*, er.ticket_code, er.created_at as registration_date,
                              u.username as organizer_name
                              FROM event_registrations er
                              JOIN events e ON er.event_id = e.id
                              JOIN users u ON e.organizer_id = u.id
                              WHERE er.participant_id = ? AND er.status = 'active'
                              ORDER BY e.event_date ASC", [$participantId]);
    }

    public function isRegistered($eventId, $participantId) {
        return $this->findOne("SELECT id FROM event_registrations 
                              WHERE event_id = ? AND participant_id = ? AND status = 'active'",
                              [$eventId, $participantId]);
    }

    public function cancelRegistration($eventId, $participantId) {
        return $this->query("UPDATE event_registrations SET status = 'cancelled' 
                            WHERE event_id = ? AND participant_id = ?",
                            [$eventId, $participantId]);
    }

    public function getRegistrationByTicket($ticketCode) {
        return $this->findOne("SELECT er.*, e.title as event_title, u.username as participant_name
                              FROM event_registrations er
                              JOIN events e ON er.event_id = e.id
                              JOIN users u ON er.participant_id = u.id
                              WHERE er.ticket_code = ?", [$ticketCode]);
    }
} 