<?php

namespace App\Models;

use App\Core\Model;

class EventRegistration extends Model {
    public function register($eventId, $participantId, $ticketCode) {
        $sql = "INSERT INTO event_registrations (event_id, participant_id, ticket_code) 
                VALUES (?, ?, ?)";
        return $this->query($sql, [$eventId, $participantId, $ticketCode]);
    }

    public function getParticipantEvents($participantId) {
        $sql = "SELECT e.*, er.ticket_code, er.created_at as registration_date,
                CONCAT(u.first_name, ' ', u.last_name) as organizer_name
                FROM event_registrations er
                JOIN events e ON er.event_id = e.id
                JOIN users u ON e.organizer_id = u.id
                WHERE er.participant_id = ? AND er.status = 'active'
                ORDER BY e.event_date ASC";
        return $this->findAll($sql, [$participantId]);
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
        return $this->findOne("SELECT er.*, e.title as event_title, 
            CONCAT(u.first_name, ' ', u.last_name) as participant_name
            FROM event_registrations er
            JOIN events e ON er.event_id = e.id
            JOIN users u ON er.participant_id = u.id
            WHERE er.ticket_code = ?", [$ticketCode]);
    }

    public function deleteAllByEventId($eventId) {
        $sql = "DELETE FROM event_registrations WHERE event_id = ?";
        return $this->query($sql, [$eventId]);
    }

    public function deleteRegistration($eventId, $participantId) {
        $sql = "DELETE FROM event_registrations WHERE event_id = ? AND participant_id = ?";
        return $this->query($sql, [$eventId, $participantId]);
    }

    public function getRegistrationsByEventId($eventId) {
        return $this->findAll("SELECT er.*, e.title as event_title, 
            CONCAT(u.first_name, ' ', u.last_name) as organizer_name 
            FROM event_registrations er 
            JOIN events e ON er.event_id = e.id 
            JOIN users u ON e.organizer_id = u.id 
            WHERE er.event_id = ?", [$eventId]);
    }

    public function getRegistrationByTicketCode($ticketCode) {
        return $this->findOne("SELECT er.*, e.title as event_title, 
            CONCAT(u.first_name, ' ', u.last_name) as participant_name 
            FROM event_registrations er 
            JOIN events e ON er.event_id = e.id 
            JOIN users u ON er.participant_id = u.id 
            WHERE er.ticket_code = ?", [$ticketCode]);
    }
} 