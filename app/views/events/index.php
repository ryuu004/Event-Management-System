<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>

<!-- Place this immediately after session_start() -->
<script>
    // Global variable to track if we need to show the success modal
    window.shouldShowSuccessModal = <?php echo (!empty($_SESSION['success']) && !empty($_SESSION['ticket_info'])) ? 'true' : 'false'; ?>;
    window.ticketInfo = <?php echo (!empty($_SESSION['ticket_info'])) ? json_encode($_SESSION['ticket_info']) : 'null'; ?>;
</script>

<!-- Modern Hero Header with Custom Cover Image for Upcoming Events -->
<div class="row mb-5">
    <div class="col-12">
        <div class="position-relative overflow-hidden py-5 px-4 rounded-4 shadow-sm text-center hero-gradient-card" style="
            background: linear-gradient(120deg, rgba(248,249,250,0.80) 0%, rgba(243,232,255,0.75) 100%), url('/endama2/app/views/events/spcc cover.png') center center / cover no-repeat;
            border: 1.5px solid #ede9fe;
            min-height: 260px;
        ">
            <!-- Accent Bar -->
            <div style="
                position: absolute;
                left: 40px;
                top: 38px;
                width: 6px;
                height: 48px;
                border-radius: 4px;
                background: linear-gradient(135deg, #7c3aed 0%, #9333ea 100%);
                opacity: 0.7;
                z-index: 1;
            "></div>
            <!-- Small Event Icon -->
            <div class="mx-auto mb-2" style="position: relative; z-index:2;">
                <i class="fas fa-calendar-alt" style="font-size:1.7rem; color:#7c3aed; background: #ede9fe; border-radius: 50%; padding: 8px 12px; box-shadow: 0 2px 8px rgba(124,58,237,0.07);"></i>
            </div>
            <h1 class="fw-bold mb-2" style="
                color: #2c3e50;
                font-size: 2.5rem;
                letter-spacing: -1px;
                position: relative;
                z-index: 2;
                display: inline-block;
                margin-bottom: 0.5rem;
            ">Upcoming Events</h1>
            <p class="lead col-md-8 mx-auto mb-0" style="color: #4b5563; font-size: 1.1rem; position: relative; z-index: 2;">
                Discover and join the latest happenings at SPCC
            </p>
        </div>
    </div>
</div>

<?php if (!empty($_SESSION['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($_SESSION['success']) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (!empty($_SESSION['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($_SESSION['error']) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['user'])) echo '<!-- DEBUG: user=' . print_r($_SESSION['user'], true) . ' -->'; ?>

<style>
.event-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    height: 100%;
}

.event-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
}

.event-date-badge {
    position: absolute;
    top: 15px;
    left: 15px;
    background: linear-gradient(135deg, #4f46e5 0%, #9333ea 100%);
    color: #fff;
    border-radius: 8px;
    padding: 8px 12px;
    font-weight: 600;
    box-shadow: 0 3px 10px rgba(124,58,237,0.08);
    min-width: 60px;
    text-align: center;
    z-index: 2;
}

.event-date-badge .day {
    font-size: 1.2rem;
    line-height: 1;
    display: block;
}

.event-date-badge .month {
    font-size: 0.8rem;
    text-transform: uppercase;
    opacity: 0.9;
}

.card-title {
    color: #2c3e50;
    font-weight: 700;
    margin-bottom: 1.1rem;
}

.card-text {
    color: #4b5563;
    margin-bottom: 1.2rem;
}

.event-detail {
    display: flex;
    align-items: center;
    margin-bottom: 1.1rem;
    color: #6c757d;
}

.event-detail i {
    width: 16px;
    margin-right: 8px;
    color: #7c3aed;
}

.see-more-link {
    color: #7c3aed;
    text-decoration: none;
    font-weight: 500;
}

.see-more-link:hover {
    text-decoration: underline;
}

.price-tag {
    font-weight: 700;
    color: #2ecc71;
    font-size: 1.2rem;
}

.btn-primary {
    background: linear-gradient(135deg, rgb(79, 70, 229) 0%, rgb(147, 51, 234) 100%);
    border: none;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background: linear-gradient(135deg, rgb(67, 56, 202) 0%, rgb(126, 34, 206) 100%);
    box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
}

.btn-outline-primary {
    color: #7c3aed;
    border-color: #7c3aed;
}

.btn-outline-primary:hover {
    background-color: #7c3aed;
    border-color: #7c3aed;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.event-item {
    animation: fadeIn 0.5s ease-out forwards;
}

.event-item:nth-child(1) { animation-delay: 0.1s; }
.event-item:nth-child(2) { animation-delay: 0.2s; }
.event-item:nth-child(3) { animation-delay: 0.3s; }
.event-item:nth-child(4) { animation-delay: 0.4s; }
.event-item:nth-child(5) { animation-delay: 0.5s; }
.event-item:nth-child(6) { animation-delay: 0.6s; }

.event-card .card-body {
    padding: 1.5rem 1.3rem 1.1rem 1.3rem;
}

.card-footer {
    padding-top: 1.1rem;
    padding-bottom: 1.1rem;
}
</style>

<div class="row" id="eventsContainer">
    <?php foreach ($events as $event): ?>
    <?php 
    $participantCount = (new \App\Models\Event())->getEventParticipantCount($event['id']);
    $isFull = $participantCount >= $event['capacity'];
    ?>
    <div class="col-md-4 mb-4 event-item">
        <div class="card event-card h-100 border-0 shadow-sm">
            <?php if (!empty($event['poster'])): ?>
            <div class="position-relative">
                <img src="/endama2/<?= htmlspecialchars($event['poster']) ?>" class="card-img-top" alt="Event Poster" style="height: 200px; object-fit: cover;">
                <div class="event-date-badge">
                    <span class="day"><?= date('d', strtotime($event['event_date'])) ?></span>
                    <span class="month"><?= date('M', strtotime($event['event_date'])) ?></span>
                </div>
            </div>
            <?php endif; ?>
            <div class="card-body">
                <h5 class="card-title mb-2"><?= htmlspecialchars($event['title']) ?></h5>
                <p class="card-text mb-3">
                    <span class="desc-short">
                        <?= htmlspecialchars(mb_strimwidth($event['description'], 0, 60, '...')) ?>
                    </span>
                    <?php if (mb_strlen($event['description']) > 60): ?>
                        <span class="desc-full d-none"><?= htmlspecialchars($event['description']) ?></span>
                        <a href="#" class="see-more-link" onclick="toggleDescription(this); return false;"> See More</a>
                    <?php endif; ?>
                </p>
                <div class="event-detail">
                    <i class="far fa-clock"></i>
                    <span><?= date('g:i A', strtotime($event['start_time'])) ?> - <?= date('g:i A', strtotime($event['end_time'])) ?></span>
                </div>
                <div class="event-detail">
                    <i class="fas fa-map-marker-alt"></i>
                    <span><?= htmlspecialchars($event['venue']) ?></span>
                </div>
                <div class="event-detail">
                    <i class="fas fa-users"></i>
                    <span><?= $participantCount ?> / <?= $event['capacity'] ?> participants</span>
                </div>
            </div>
            <div class="card-footer bg-white border-top pt-3">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="price-tag">₱<?= number_format($event['price'], 2) ?></span>
                    <?php if (isset($_SESSION['user'])): ?>
                        <?php if (in_array((int)$event['id'], array_map('intval', $joinedEventIds))): ?>
                            <span class="badge bg-secondary py-2 px-3">Already Joined</span>
                        <?php elseif ($isFull): ?>
                            <button class="btn btn-sm btn-outline-danger" onclick="showFullCapacityModal()" disabled>
                                Full
                            </button>
                        <?php else: ?>
                            <button 
                                onclick="showJoinModal(
                                    <?= $event['id'] ?>, 
                                    '<?= htmlspecialchars($event['title']) ?>', 
                                    '<?= htmlspecialchars(date('F d, Y', strtotime($event['event_date']))) ?>', 
                                    '<?= htmlspecialchars($event['venue']) ?>', 
                                    '₱<?= number_format($event['price'], 2) ?>'
                                )" 
                                class="btn btn-primary btn-sm"
                            >
                                Join Event
                            </button>
                        <?php endif; ?>
                    <?php else: ?>
                        <a href="/endama2/auth/login" class="btn btn-outline-primary btn-sm">Login to Join</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php if (empty($events)): ?>
<div class="text-center py-5">
    <div class="py-5">
        <i class="fas fa-calendar-times fa-4x text-muted mb-3"></i>
        <h3 class="text-muted">No events found</h3>
        <p class="text-muted">Check back later for upcoming events</p>
    </div>
</div>
<?php endif; ?>

<!-- Join Event Confirmation Modal -->
<div class="modal fade" id="joinEventModal" tabindex="-1" aria-labelledby="joinEventModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="joinEventModalLabel">Join Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0">Do you want to join this event?</p>
                <h4 class="mt-2 mb-3 event-title fw-bold" style="
                    background: linear-gradient(135deg, rgb(79, 70, 229) 0%, rgb(147, 51, 234) 100%);
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: transparent;
                    background-clip: text;
                "></h4>
                <div class="event-details">
                    <p class="mb-2"><i class="fas fa-calendar-alt text-purple me-2" style="color: #7c3aed;"></i> <span class="event-date"></span></p>
                    <p class="mb-2"><i class="fas fa-map-marker-alt text-danger me-2"></i> <span class="event-venue"></span></p>
                    <p class="mb-0"><i class="fas fa-tag text-success me-2"></i> <span class="event-price"></span></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="#" class="btn btn-primary join-event-btn">Join Event</a>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">
                    <i class="fas fa-check-circle text-success me-2"></i>
                    Registration Successful!
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-4">
                <div class="mb-4">
                    <i class="fas fa-ticket-alt" style="font-size: 3.5rem; color: #7c3aed;"></i>
                </div>
                <h4 class="success-event-title mb-4 fw-bold" style="
                    background: linear-gradient(135deg, rgb(79, 70, 229) 0%, rgb(147, 51, 234) 100%);
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: transparent;
                    background-clip: text;
                "></h4>
                
                <div class="ticket-info p-4 mb-4 border rounded bg-light">
                    <div class="mb-3">
                        <h5 class="mb-3">Your Ticket Information</h5>
                        <div class="ticket-code mb-2 p-3 bg-white border rounded text-center" style="
                            font-family: 'Courier New', monospace;
                            font-size: 1.8rem;
                            font-weight: bold;
                            letter-spacing: 2px;
                            color: #7c3aed;
                        "></div>
                        <div class="event-price text-success fw-bold fs-5"></div>
                    </div>
                    
                    <div class="event-details text-start">
                        <p class="mb-2">
                            <i class="fas fa-calendar-alt me-2" style="color: #7c3aed;"></i>
                            <span class="event-date"></span>
                        </p>
                        <p class="mb-0">
                            <i class="fas fa-map-marker-alt text-danger me-2"></i>
                            <span class="event-venue"></span>
                        </p>
                    </div>
                </div>

                <div class="alert alert-warning" role="alert">
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
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-primary px-4" data-bs-dismiss="modal">Got it!</button>
            </div>
        </div>
    </div>
</div>

<!-- Full Capacity Modal -->
<div class="modal fade" id="fullCapacityModal" tabindex="-1" aria-labelledby="fullCapacityModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="fullCapacityModalLabel">Event Full</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <i class="fas fa-users-slash fa-3x text-danger mb-3"></i>
        <h4>Sorry, this event has reached its maximum capacity.</h4>
        <p class="text-muted">We appreciate your interest. Please check out our other events!</p>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Okay</button>
      </div>
    </div>
  </div>
</div>

<script>
function toggleDescription(link) {
    const cardText = link.closest('.card-text');
    const shortDesc = cardText.querySelector('.desc-short');
    const fullDesc = cardText.querySelector('.desc-full');
    if (fullDesc.classList.contains('d-none')) {
        shortDesc.style.display = 'none';
        fullDesc.classList.remove('d-none');
        link.textContent = ' See Less';
    } else {
        shortDesc.style.display = '';
        fullDesc.classList.add('d-none');
        link.textContent = ' See More';
    }
}

function filterEvents() {
    const searchText = document.getElementById('searchEvents').value.toLowerCase();
    const events = document.getElementsByClassName('event-item');
    
    Array.from(events).forEach(event => {
        const title = event.querySelector('.card-title').textContent.toLowerCase();
        const description = event.querySelector('.card-text').textContent.toLowerCase();
        const venue = event.querySelector('.fa-map-marker-alt').nextElementSibling.textContent.toLowerCase();
        
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
    }
});
</script>