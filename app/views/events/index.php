<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>

<!-- Place this immediately after session_start() -->
<script>
    // Global variable to track if we need to show the success modal
    window.shouldShowSuccessModal = <?php echo (!empty($_SESSION['success']) && !empty($_SESSION['ticket_info'])) ? 'true' : 'false'; ?>;
    window.ticketInfo = <?php echo (!empty($_SESSION['ticket_info'])) ? json_encode($_SESSION['ticket_info']) : 'null'; ?>;
</script>

<!-- Hero Title with Modern Styling -->
<div class="row">
    <div class="col-12 text-center py-5" style="
        background: linear-gradient(to bottom, rgba(13, 17, 38, 0.85), rgba(13, 17, 38, 0.65));
        border-radius: 24px;
        margin: 0 2px 3rem 2px;
        position: relative;
        overflow: hidden;
    ">
        <!-- Decorative elements -->
        <div style="
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 30% 50%, rgba(125, 214, 255, 0.1) 0%, transparent 50%),
                        radial-gradient(circle at 70% 50%, rgba(224, 86, 253, 0.1) 0%, transparent 50%);
            pointer-events: none;
        "></div>
        
        <h1 style="
            font-family: 'Segoe UI', Arial, sans-serif;
            font-size: 3.2rem;
            font-weight: 900;
            color: #ffffff;
            letter-spacing: -0.02em;
            margin-bottom: 0.8rem;
            line-height: 1.1;
            text-shadow: 0 2px 20px rgba(0,0,0,0.2);
            position: relative;
        ">Upcoming Events</h1>
        
        <div style="
            font-family: 'Segoe UI', Arial, sans-serif;
            font-size: 1.25rem;
            font-weight: 400;
            color: rgba(255,255,255,0.85);
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.5;
            position: relative;
        ">Discover and join the latest happenings at SPCC</div>
    </div>
</div>

<?php if (!empty($_SESSION['success'])): ?>
    <div class="alert alert-success text-center"><?= htmlspecialchars($_SESSION['success']) ?></div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>
<?php if (!empty($_SESSION['error'])): ?>
    <div class="alert alert-danger text-center"><?= htmlspecialchars($_SESSION['error']) ?></div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['user'])) echo '<!-- DEBUG: user=' . print_r($_SESSION['user'], true) . ' -->'; ?>

<style>
.event-card {
    transform: translateY(0);
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

.event-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 40px 0 rgba(31, 38, 135, 0.25);
}

.event-card:hover img {
    filter: brightness(1) !important;
}

.event-card .btn {
    transform: scale(1);
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

.event-card .btn:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 15px rgba(224, 86, 253, 0.3);
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.event-item {
    animation: fadeIn 0.6s ease-out forwards;
    opacity: 0;
}

.event-item:nth-child(1) { animation-delay: 0.1s; }
.event-item:nth-child(2) { animation-delay: 0.2s; }
.event-item:nth-child(3) { animation-delay: 0.3s; }
.event-item:nth-child(4) { animation-delay: 0.4s; }
.event-item:nth-child(5) { animation-delay: 0.5s; }
.event-item:nth-child(6) { animation-delay: 0.6s; }
</style>

<div class="row" id="eventsContainer">
    <?php foreach ($events as $event): ?>
    <?php 
    $participantCount = (new \App\Models\Event())->getEventParticipantCount($event['id']);
    $isFull = $participantCount >= $event['capacity'];
    ?>
    <div class="col-md-4 mb-4 event-item">
        <div class="card event-card h-100 position-relative" style="
            border-radius: 16px;
            overflow: hidden;
            background: rgba(24, 28, 58, 0.9);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,0.1);
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
            color: #fff;
            will-change: transform;
        ">
            <?php if (!empty($event['poster'])): ?>
            <div class="position-relative">
                <img src="/endama2/<?= htmlspecialchars($event['poster']) ?>" class="card-img-top" alt="Event Poster" style="
                    height: 240px;
                    object-fit: cover;
                    filter: brightness(0.9);
                    transition: filter 0.3s ease;
                ">
                <!-- Date Box -->
                <div class="position-absolute top-0 start-0 m-3 text-white rounded-lg px-3 py-2" style="
                    background: rgba(13, 17, 38, 0.85);
                    backdrop-filter: blur(4px);
                    border: 1px solid rgba(255,255,255,0.1);
                    min-width: 60px;
                ">
                    <div style="font-size:1.4rem;font-weight:700;line-height:1;">
                        <?= date('d', strtotime($event['event_date'])) ?>
                    </div>
                    <div style="font-size:0.85rem;text-transform:uppercase;letter-spacing:0.05em;opacity:0.9;">
                        <?= date('M', strtotime($event['event_date'])) ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <div class="card-body pb-2">
                <h5 class="card-title mb-2" style="
                    font-weight: 700;
                    font-size: 1.35rem;
                    letter-spacing: -0.01em;
                    line-height: 1.3;
                    background: linear-gradient(90deg, #7ed6ff 0%, #e056fd 100%);
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: transparent;
                    background-clip: text;
                ">
                    <?= htmlspecialchars($event['title']) ?>
                </h5>
                <div class="mb-2" style="font-size:0.95rem;">
                    <span style="color: #7ed6ff;">By: <?= htmlspecialchars($event['organizer_name'] ?? 'Organizer') ?></span>
                </div>
                <p class="card-text mb-3" style="
                    font-size: 0.97rem;
                    min-height: 38px;
                    color: rgba(255,255,255,0.85);
                    line-height: 1.5;
                ">
                    <?= htmlspecialchars(mb_strimwidth($event['description'], 0, 60, '...')) ?>
                </p>
                <div class="mb-2" style="color: #7ed6ff; font-size: 0.97rem;">
                    <i class="fas fa-clock me-2"></i>
                    <?= date('g:i A', strtotime($event['start_time'])) ?> - <?= date('g:i A', strtotime($event['end_time'])) ?>
                </div>
                <div class="mb-2" style="color: rgba(255,255,255,0.75);">
                    <i class="fas fa-map-marker-alt" style="color: #e056fd;"></i>
                    <span class="ms-2"><?= htmlspecialchars($event['venue']) ?></span>
                </div>
            </div>
            <div class="card-footer border-0 pt-0 pb-3 px-3" style="background: transparent;">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="fw-bold" style="
                        font-size: 1.3rem;
                        background: linear-gradient(90deg, #FFD700 0%, #FFA500 100%);
                        -webkit-background-clip: text;
                        -webkit-text-fill-color: transparent;
                        background-clip: text;
                    ">₱<?= number_format($event['price'], 2) ?></span>
                    <?php if (isset($_SESSION['user'])): ?>
                        <?php if (in_array((int)$event['id'], array_map('intval', $joinedEventIds))): ?>
                            <button class="btn btn-secondary btn-sm px-4 py-2 fw-bold" style="
                                border-radius: 50px;
                                font-weight: 700;
                                font-size: 0.95rem;
                                background: #888 !important;
                                color: #fff !important;
                                border: none;
                                box-shadow: none;
                                pointer-events: none;
                                opacity: 0.85;
                                cursor: not-allowed;
                            " disabled>
                                Already Joined
                            </button>
                        <?php elseif ($isFull): ?>
                            <button class="btn btn-danger btn-sm px-4 py-2 fw-bold" style="border-radius: 50px; cursor: not-allowed;" onclick="showFullCapacityModal()" disabled>
                                Full
                            </button>
                        <?php else: ?>
                            <button onclick="showJoinModal(
                                <?= $event['id'] ?>, 
                                '<?= htmlspecialchars($event['title']) ?>', 
                                '<?= htmlspecialchars($event['event_date']) ?>', 
                                '<?= htmlspecialchars($event['venue']) ?>', 
                                '₱' + <?= number_format($event['price'], 2) ?>.toFixed(2)
                            )" class="btn btn-success btn-sm px-4 py-2" style="
                                border-radius: 50px;
                                font-weight: 600;
                                font-size: 0.95rem;
                                background: linear-gradient(90deg, #7ed6ff 0%, #e056fd 100%);
                                border: none;
                                box-shadow: 0 2px 10px rgba(224, 86, 253, 0.2);
                                transition: transform 0.2s ease, box-shadow 0.2s ease;
                            ">
                                Join
                            </button>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php if (empty($events)): ?>
<div class="text-center">
    <p>No events found.</p>
</div>
<?php endif; ?>

<!-- Join Event Confirmation Modal -->
<div class="modal fade" id="joinEventModal" tabindex="-1" aria-labelledby="joinEventModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="
            background: rgba(24, 28, 58, 0.95);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 16px;
            color: #fff;
        ">
            <div class="modal-header border-bottom border-light border-opacity-10">
                <h5 class="modal-title" id="joinEventModalLabel">Join Event</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0">Do you want to join this event?</p>
                <h4 class="mt-2 mb-3 event-title" style="
                    background: linear-gradient(90deg, #7ed6ff 0%, #e056fd 100%);
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: transparent;
                    background-clip: text;
                "></h4>
                <div class="event-details">
                    <p class="mb-2"><i class="fas fa-calendar-alt text-info me-2"></i> <span class="event-date"></span></p>
                    <p class="mb-2"><i class="fas fa-map-marker-alt text-danger me-2"></i> <span class="event-venue"></span></p>
                    <p class="mb-0"><i class="fas fa-tag text-warning me-2"></i> <span class="event-price"></span></p>
                </div>
            </div>
            <div class="modal-footer border-top border-light border-opacity-10">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="#" class="btn btn-primary join-event-btn" style="
                    background: linear-gradient(90deg, #7ed6ff 0%, #e056fd 100%);
                    border: none;
                ">Join Event</a>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="
            background: rgba(24, 28, 58, 0.95);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 16px;
            color: #fff;
        ">
            <div class="modal-header border-bottom border-light border-opacity-10">
                <h5 class="modal-title" id="successModalLabel">
                    <i class="fas fa-check-circle text-success me-2"></i>
                    Registration Successful!
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-4">
                <div class="mb-4">
                    <i class="fas fa-ticket-alt text-info" style="font-size: 3.5rem;"></i>
                </div>
                <h4 class="success-event-title mb-4" style="
                    background: linear-gradient(90deg, #7ed6ff 0%, #e056fd 100%);
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: transparent;
                    background-clip: text;
                "></h4>
                
                <div class="ticket-info p-4 mb-4" style="
                    background: rgba(255,255,255,0.1);
                    border-radius: 12px;
                    border: 1px solid rgba(255,255,255,0.2);
                ">
                    <div class="mb-3">
                        <h5 class="mb-3">Your Ticket Information</h5>
                        <div class="ticket-code mb-2" style="
                            font-family: 'Courier New', monospace;
                            font-size: 2rem;
                            font-weight: bold;
                            letter-spacing: 2px;
                            color: #7ed6ff;
                            padding: 10px;
                            background: rgba(0,0,0,0.2);
                            border-radius: 8px;
                            margin: 15px 0;
                        "></div>
                        <div class="event-price" style="
                            font-size: 1.2rem;
                            color: #FFD700;
                            font-weight: bold;
                        "></div>
                    </div>
                    
                    <div class="event-details text-start">
                        <p class="mb-2">
                            <i class="fas fa-calendar-alt text-info me-2"></i>
                            <span class="event-date"></span>
                        </p>
                        <p class="mb-0">
                            <i class="fas fa-map-marker-alt text-danger me-2"></i>
                            <span class="event-venue"></span>
                        </p>
                    </div>
                </div>

                <div class="alert alert-warning" role="alert" style="
                    background: rgba(255, 193, 7, 0.1);
                    border: 1px solid rgba(255, 193, 7, 0.2);
                    color: #ffd700;
                ">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Important Reminder:</strong>
                    <ul class="mb-0 mt-2 text-start">
                        <li>Please save your ticket code: <span class="ticket-code-reminder fw-bold"></span></li>
                        <li>Prepare the exact amount: <span class="event-price-reminder fw-bold"></span></li>
                        <li>Present this ticket when attending the event</li>
                        <li>Arrive at least 15 minutes before the event starts</li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer border-top border-light border-opacity-10 justify-content-center">
                <button type="button" class="btn btn-primary px-4" data-bs-dismiss="modal" style="
                    background: linear-gradient(90deg, #7ed6ff 0%, #e056fd 100%);
                    border: none;
                    border-radius: 50px;
                    font-weight: 600;
                ">Got it!</button>
            </div>
        </div>
    </div>
</div>

<!-- Full Capacity Modal -->
<div class="modal fade" id="fullCapacityModal" tabindex="-1" aria-labelledby="fullCapacityModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="background: rgba(24, 28, 58, 0.95); color: #fff;">
      <div class="modal-header">
        <h5 class="modal-title" id="fullCapacityModalLabel">Event Full</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <i class="fas fa-frown fa-3x text-warning mb-3"></i>
        <h4>Sorry, this event has reached its maximum capacity.</h4>
        <p>We appreciate your interest. Please check out our other events!</p>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Okay</button>
      </div>
    </div>
  </div>
</div>

<script>
function filterEvents() {
    const searchText = document.getElementById('searchEvents').value.toLowerCase();
    const events = document.getElementsByClassName('event-item');
    
    Array.from(events).forEach(event => {
        const title = event.querySelector('.card-title').textContent.toLowerCase();
        const description = event.querySelector('.card-text').textContent.toLowerCase();
        const venue = event.querySelector('.fa-map-marker-alt').nextSibling.textContent.toLowerCase();
        
        if (title.includes(searchText) || description.includes(searchText) || venue.includes(searchText)) {
            event.style.display = '';
        } else {
            event.style.display = 'none';
        }
    });
}

function showJoinModal(eventId, title, date, venue, price) {
    const modal = document.getElementById('joinEventModal');
    modal.querySelector('.event-title').textContent = title;
    modal.querySelector('.event-date').textContent = date;
    modal.querySelector('.event-venue').textContent = venue;
    modal.querySelector('.event-price').textContent = price;
    
    const joinBtn = modal.querySelector('.join-event-btn');
    joinBtn.href = `/endama2/events/register/${eventId}`;
    
    const bsModal = new bootstrap.Modal(modal);
    bsModal.show();
}

function showSuccessModal(title, ticketCode, price, date, venue) {
    const modal = document.getElementById('successModal');
    modal.querySelector('.success-event-title').textContent = title;
    modal.querySelector('.ticket-code').textContent = ticketCode;
    modal.querySelector('.ticket-code-reminder').textContent = ticketCode;
    modal.querySelector('.event-price').textContent = `Entrance Fee: ${price}`
}

function showFullCapacityModal() {
    const modal = new bootstrap.Modal(document.getElementById('fullCapacityModal'));
    modal.show();
}

document.addEventListener('DOMContentLoaded', function() {
    if (window.shouldShowSuccessModal && window.ticketInfo) {
        const info = window.ticketInfo;
        const modal = document.getElementById('successModal');
        if (modal) {
            modal.querySelector('.success-event-title').textContent = info.title || '';
            modal.querySelector('.ticket-code').textContent = info.ticket_code || '';
            modal.querySelector('.ticket-code-reminder').textContent = info.ticket_code || '';
            modal.querySelector('.event-price').textContent = 'Entrance Fee: ' + (info.price || '');
            modal.querySelector('.event-price-reminder').textContent = info.price || '';
            modal.querySelector('.event-date').textContent = info.event_date || '';
            modal.querySelector('.event-venue').textContent = info.venue || '';
            const bsModal = new bootstrap.Modal(modal);
            bsModal.show();
        }
        // Optionally clear the session variables via AJAX or on next page load
    }
});
</script>