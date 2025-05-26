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
            // Get all events this user has joined
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
        // Delete all registrations (tickets) for this event first
        $this->registrationModel->deleteAllByEventId($id);
        $this->eventModel->delete($id, $user['id']);
        return $this->json(['message' => 'Event deleted successfully']);
    }

    public function register($id) {
        $user = $this->requireAuth(); // allow any logged-in user

        // Get event details
        $event = $this->eventModel->getEventById($id);
        if (!$event) {
            $_SESSION['error'] = 'Event not found.';
            header('Location: /endama2/events');
            exit;
        }

        // Capacity check
        $participantCount = $this->eventModel->getEventParticipantCount($id);
        if ($participantCount >= $event['capacity']) {
            $_SESSION['error'] = 'Sorry, this event is already full!';
            header('Location: /endama2/events');
            exit;
        }

        // Prevent double registration
        if ($this->registrationModel->isRegistered($id, $user['id'])) {
            $_SESSION['error'] = 'You have already joined this event.';
            header('Location: /endama2/events');
            exit;
        }

        // Generate unique ticket code with retry mechanism
        $maxAttempts = 5;
        $attempt = 0;
        $registrationSuccess = false;

        while ($attempt < $maxAttempts && !$registrationSuccess) {
            try {
                // Generate a more unique ticket code using timestamp and random elements
                $timestamp = substr(time(), -4); // Last 4 digits of timestamp
                $random = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 3); // 3 random letters
                $ticketCode = 'SPCC' . $timestamp . $random;
                
                // Try to register with this ticket code
                $registrationSuccess = $this->registrationModel->register($id, $user['id'], $ticketCode);
                
                if ($registrationSuccess) {
                    $_SESSION['success'] = 'You have successfully joined the event!';
                    $_SESSION['ticket_info'] = [
                        'event_title' => $event['title'],
                        'ticket_code' => $ticketCode,
                        'price' => $event['price'],
                        'event_date' => date('F d, Y', strtotime($event['event_date'])) . ' at ' . date('g:i A', strtotime($event['start_time'])),
                        'venue' => $event['venue']
                    ];
                    break;
                }
            } catch (\Exception $e) {
                // If duplicate ticket code, try again
                if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                    $attempt++;
                    continue;
                }
                // For other errors, throw the exception
                throw $e;
            }
        }

        if (!$registrationSuccess) {
            $_SESSION['error'] = 'Failed to register for the event. Please try again.';
        }
        
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
            $this->registrationModel->deleteRegistration($id, $user['id']);
            $_SESSION['success'] = 'Registration cancelled and ticket deleted successfully!';
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