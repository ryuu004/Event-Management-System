<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Event;
use App\Models\EventRegistration;

class EventController extends Controller {
    private $eventModel;
    private $registrationModel;

    public function __construct() {
        $this->eventModel = new Event();
        $this->registrationModel = new EventRegistration();
    }

    public function index() {
        $events = $this->eventModel->getPublishedEvents();
        $joinedEventIds = [];
        if (isset($_SESSION['user'])) {
            $joinedEvents = $this->registrationModel->getParticipantEvents($_SESSION['user']['id']);
            $joinedEventIds = array_column($joinedEvents, 'id');
        }
        
        if ($this->isJsonRequest()) {
            return $this->json(['events' => $events]);
        }
        
        return $this->render('events/index', [
            'events' => $events,
            'joinedEventIds' => $joinedEventIds
        ]);
    }

    public function myEvents() {
        $user = $this->requireAuth();
        $events = $this->registrationModel->getParticipantEvents($user['id']);
        return $this->render('events/my-events', [
            'events' => $events,
            'user' => $user
        ]);
    }

    public function create() {
        $user = $this->requireAuth(['organizer']);

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->render('events/create');
        }

        // Handle poster upload
        if (!isset($_FILES['poster']) || $_FILES['poster']['error'] !== UPLOAD_ERR_OK) {
            $_SESSION['error'] = 'Poster upload failed or is required.';
            header('Location: /endama2/events/create');
            exit;
        }
        $posterTmp = $_FILES['poster']['tmp_name'];
        $posterName = uniqid('poster_') . '_' . basename($_FILES['poster']['name']);
        $posterPath = 'uploads/posters/' . $posterName;
        $uploadDir = __DIR__ . '/../../uploads/posters/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        if (!move_uploaded_file($posterTmp, $uploadDir . $posterName)) {
            $_SESSION['error'] = 'Failed to save poster file.';
            header('Location: /endama2/events/create');
            exit;
        }

        $data = [
            'title' => $_POST['title'],
            'description' => $_POST['description'],
            'venue' => $_POST['venue'],
            'event_date' => $_POST['event_date'],
            'start_time' => $_POST['start_time'],
            'end_time' => $_POST['end_time'],
            'capacity' => $_POST['capacity'],
            'price' => $_POST['price'],
            'organizer_id' => $user['id'],
            'status' => $_POST['status'],
            'poster' => $posterPath
        ];

        $eventId = $this->eventModel->create($data);
        $_SESSION['success'] = 'Event created successfully!';
        header('Location: /endama2/events/manage');
        exit;
    }

    public function update($id) {
        $user = $this->requireAuth(['organizer']);
        $event = $this->eventModel->getEventById($id);

        if (!$event || $event['organizer_id'] !== $user['id']) {
            $_SESSION['error'] = 'Event not found or unauthorized';
            header('Location: /endama2/events/manage');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->render('events/edit', ['event' => $event]);
        }

        // Handle poster upload (optional)
        $posterPath = $event['poster'];
        if (isset($_FILES['poster']) && $_FILES['poster']['error'] === UPLOAD_ERR_OK) {
            $posterTmp = $_FILES['poster']['tmp_name'];
            $posterName = uniqid('poster_') . '_' . basename($_FILES['poster']['name']);
            $posterPath = 'uploads/posters/' . $posterName;
            $uploadDir = __DIR__ . '/../../uploads/posters/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            move_uploaded_file($posterTmp, $uploadDir . $posterName);
        }

        $data = [
            'title' => $_POST['title'],
            'description' => $_POST['description'],
            'venue' => $_POST['venue'],
            'event_date' => $_POST['event_date'],
            'start_time' => $_POST['start_time'],
            'end_time' => $_POST['end_time'],
            'capacity' => $_POST['capacity'],
            'price' => $_POST['price'],
            'status' => $_POST['status'],
            'poster' => $posterPath,
            'organizer_id' => $user['id']
        ];

        $this->eventModel->update($id, $data);
        $_SESSION['success'] = 'Event updated successfully!';
        header('Location: /endama2/events/manage');
        exit;
    }

    public function delete($id) {
        $user = $this->requireAuth(['organizer']);
        $this->eventModel->delete($id, $user['id']);
        return $this->json(['message' => 'Event deleted successfully']);
    }

    public function register($id) {
        $user = $this->requireAuth(); // allow any logged-in user

        // Prevent double registration
        if ($this->registrationModel->isRegistered($id, $user['id'])) {
            $_SESSION['error'] = 'You have already joined this event.';
            header('Location: /endama2/events');
            exit;
        }

        $this->registrationModel->register($id, $user['id']);
        $_SESSION['success'] = 'You have successfully joined the event!';
        header('Location: /endama2/events');
        exit;
    }

    public function participants($id) {
        $user = $this->requireAuth(['organizer']);
        $event = $this->eventModel->getEventById($id);
        
        if ($event['organizer_id'] !== $user['id']) {
            return $this->json(['error' => 'Unauthorized'], 403);
        }

        $participants = $this->eventModel->getEventParticipants($id);
        
        if ($this->isJsonRequest()) {
            return $this->json([
                'event' => $event,
                'participants' => $participants
            ]);
        }

        return $this->render('events/participants', [
            'event' => $event,
            'participants' => $participants
        ]);
    }

    public function manage() {
        $user = $this->requireAuth(['organizer']);
        $events = $this->eventModel->getEventsByOrganizer($user['id']);
        return $this->render('events/manage', ['events' => $events]);
    }

    public function cancelRegistration($id) {
        $user = $this->requireAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->registrationModel->cancelRegistration($id, $user['id']);
            $_SESSION['success'] = 'Registration cancelled successfully!';
            header('Location: /endama2/events/my-events');
            exit;
        } else {
            // Render a confirmation modal/page
            $event = $this->eventModel->getEventById($id);
            return $this->render('events/cancel-registration', ['event' => $event]);
        }
    }

    private function isJsonRequest() {
        $accept = $_SERVER['HTTP_ACCEPT'] ?? '';
        return strpos($accept, 'application/json') !== false;
    }
} 