<?php

namespace App\Models;

use App\Core\Model;

class Event extends Model {
    public function create($data) {
        $sql = "INSERT INTO events (title, description, venue, event_date, start_time, end_time, 
                capacity, price, organizer_id, status, poster) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $params = [
            $data['title'],
            $data['description'],
            $data['venue'],
            $data['event_date'],
            $data['start_time'],
            $data['end_time'],
            $data['capacity'],
            $data['price'],
            $data['organizer_id'],
            $data['status'],
            $data['poster']
        ];
        
        return $this->query($sql, $params);
    }

    public function update($id, $data) {
        $sql = "UPDATE events SET 
                title = ?, description = ?, venue = ?, event_date = ?,
                start_time = ?, end_time = ?, capacity = ?, price = ?, status = ?, poster = ?
                WHERE id = ? AND organizer_id = ?";
        
        $params = [
            $data['title'],
            $data['description'],
            $data['venue'],
            $data['event_date'],
            $data['start_time'],
            $data['end_time'],
            $data['capacity'],
            $data['price'],
            $data['status'],
            $data['poster'],
            $id,
            $data['organizer_id']
        ];
        
        return $this->query($sql, $params);
    }

    public function getPublishedEvents() {
        return $this->findAll("SELECT e.*, CONCAT(u.first_name, ' ', u.last_name) as organizer_name 
            FROM events e 
            JOIN users u ON e.organizer_id = u.id 
            WHERE e.status = 'published'
            ORDER BY e.event_date ASC");
    }

    public function getEventsByOrganizer($organizerId) {
        return $this->findAll("SELECT * FROM events WHERE organizer_id = ?", [$organizerId]);
    }

    public function getAllEvents() {
        return $this->findAll("SELECT e.*, CONCAT(u.first_name, ' ', u.last_name) as organizer_name 
            FROM events e 
            LEFT JOIN users u ON e.organizer_id = u.id 
            ORDER BY e.created_at DESC");
    }

    public function getEventById($id) {
        return $this->findOne("SELECT e.*, CONCAT(u.first_name, ' ', u.last_name) as organizer_name 
            FROM events e 
            LEFT JOIN users u ON e.organizer_id = u.id 
            WHERE e.id = ?", [$id]);
    }

    public function getEventParticipants($eventId) {
        return $this->findAll("SELECT u.id, u.first_name as name, u.email, 
            er.ticket_code, er.created_at as registration_date 
            FROM event_registrations er 
            JOIN users u ON er.participant_id = u.id 
            WHERE er.event_id = ? 
            ORDER BY er.created_at DESC", [$eventId]);
    }

    public function delete($id, $organizerId) {
        return $this->query("DELETE FROM events WHERE id = ? AND organizer_id = ?", [$id, $organizerId]);
    }

    public function getEventParticipantCount($eventId) {
        $sql = "SELECT COUNT(*) as count FROM event_registrations WHERE event_id = ? AND status = 'active'";
        $result = $this->findOne($sql, [$eventId]);
        return $result ? $result['count'] : 0;
    }
} 