<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<h2 class="mb-4 section-title"><span class="accent-bar"></span>My Events</h2>
<?php if (!empty($_SESSION['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
        <?= htmlspecialchars($_SESSION['success']) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>
<?php if (!empty($_SESSION['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
        <?= htmlspecialchars($_SESSION['error']) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<!-- Cancel Registration Modal -->
<div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="cancelModalLabel">Cancel Registration</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to cancel your registration for this event?
      </div>
      <div class="modal-footer">
        <form id="cancelForm" method="POST">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
          <button type="submit" class="btn btn-danger">Yes, Cancel</button>
        </form>
      </div>
    </div>
  </div>
</div>

<style>
.section-title {
    font-size: 2rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.7rem;
}
.section-title .accent-bar {
    display: inline-block;
    width: 7px;
    height: 28px;
    border-radius: 4px;
    background: linear-gradient(135deg, #7c3aed 0%, #9333ea 100%);
}
.event-card {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    transition: transform 0.2s, box-shadow 0.2s;
}
.event-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(124,58,237,0.08);
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
.event-card .card-body {
    padding: 1.5rem 1.3rem 1.1rem 1.3rem;
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
    font-size: 1.1rem;
}
.mb-2.text-muted, .mb-1.text-muted {
    margin-bottom: 1.1rem !important;
}
.card-footer {
    padding-top: 1.1rem;
    padding-bottom: 1.1rem;
}
</style>

<div class="row">
    <?php if (empty($events)): ?>
        <div class="col-12 text-center">
            <p class="text-muted">You haven't joined any events yet.</p>
            <a href="/endama2/events" class="btn btn-primary">Find Events</a>
        </div>
    <?php else: ?>
        <?php foreach ($events as $event): ?>
        <div class="col-md-4 mb-4">
            <div class="card event-card h-100 position-relative">
                <?php if (!empty($event['poster'])): ?>
                <div class="position-relative">
                    <img src="/endama2/<?= htmlspecialchars($event['poster']) ?>" class="card-img-top" alt="Event Poster" style="max-height:200px;object-fit:cover;">
                    <!-- Date Badge -->
                    <div class="event-date-badge">
                        <span class="day"><?= date('d', strtotime($event['event_date'])) ?></span>
                        <span class="month"><?= date('M', strtotime($event['event_date'])) ?></span>
                    </div>
                </div>
                <?php endif; ?>
                <div class="card-body pb-2">
                    <h5 class="card-title mb-1">
                        <?= htmlspecialchars($event['title']) ?>
                    </h5>
                    <?php if (!empty($event['ticket_code'])): ?>
                        <div class="mb-2">
                            <span class="badge bg-info text-dark" style="font-size:1rem;font-weight:bold;letter-spacing:1px;">Ticket: <?= htmlspecialchars($event['ticket_code']) ?></span>
                        </div>
                    <?php endif; ?>
                    <div class="mb-1 text-muted" style="font-size:0.95rem;">
                        <i class="fas fa-clock me-2"></i>
                        <?= date('g:i A', strtotime($event['start_time'])) ?> - <?= date('g:i A', strtotime($event['end_time'])) ?>
                    </div>
                    <div class="mb-1 text-muted">
                        <i class="fas fa-map-marker-alt me-1"></i>
                        <?= htmlspecialchars($event['venue']) ?>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 pt-0 pb-3 px-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="price-tag">₱<?= number_format($event['price'], 2) ?></span>
                        <button class="btn btn-outline-danger btn-sm px-4 py-2 fw-bold" style="border-radius: 20px;" onclick="showCancelModal(<?= $event['id'] ?>)">Cancel Registration</button>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
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

let cancelEventId = null;
function showCancelModal(eventId) {
    cancelEventId = eventId;
    const form = document.getElementById('cancelForm');
    form.action = `/endama2/events/cancel-registration/${eventId}`;
    const modal = new bootstrap.Modal(document.getElementById('cancelModal'));
    modal.show();
}
</script> 