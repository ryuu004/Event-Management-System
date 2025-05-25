<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<h2 class="mb-4" style="color: #fff;">My Events</h2>
<?php if (!empty($_SESSION['success'])): ?>
    <div class="alert alert-success text-center"><?= htmlspecialchars($_SESSION['success']) ?></div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>
<?php if (!empty($_SESSION['error'])): ?>
    <div class="alert alert-danger text-center"><?= htmlspecialchars($_SESSION['error']) ?></div>
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

<div class="row">
    <?php if (empty($events)): ?>
        <div class="col-12 text-center">
            <p class="text-muted">You haven't joined any events yet.</p>
            <a href="/endama2/events" class="btn btn-primary">Find Events</a>
        </div>
    <?php else: ?>
        <?php foreach ($events as $event): ?>
        <div class="col-md-4 mb-4">
            <div class="card event-card h-100 bg-dark text-white position-relative" style="border-radius: 18px; overflow: hidden;">
                <?php if (!empty($event['poster'])): ?>
                <div class="position-relative">
                    <img src="/endama2/<?= htmlspecialchars($event['poster']) ?>" class="card-img-top" alt="Event Poster" style="max-height:220px;object-fit:cover;filter:brightness(0.85);">
                    <!-- Date Box -->
                    <div class="position-absolute top-0 start-0 m-3 bg-primary text-white rounded text-center px-3 py-2 shadow" style="min-width:56px;">
                        <div style="font-size:1.2rem;font-weight:bold;line-height:1;">
                            <?= date('d', strtotime($event['event_date'])) ?>
                        </div>
                        <div style="font-size:0.9rem;text-transform:uppercase;line-height:1;">
                            <?= date('M', strtotime($event['event_date'])) ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <div class="card-body pb-2">
                    <h5 class="card-title mb-1" style="font-weight:700;letter-spacing:0.5px;">
                        <?= htmlspecialchars($event['title']) ?>
                    </h5>
                    <?php if (!empty($event['ticket_code'])): ?>
                        <div class="mb-2">
                            <span class="badge bg-info text-dark" style="font-size:1rem;font-weight:bold;letter-spacing:1px;">Ticket: <?= htmlspecialchars($event['ticket_code']) ?></span>
                        </div>
                    <?php endif; ?>
                    <div class="mb-1" style="font-size:0.95rem;">
                        <span class="text-info">By: <?= htmlspecialchars($event['organizer_name'] ?? 'Organizer') ?></span>
                    </div>
                    <p class="card-text text-light mb-2" style="font-size:0.97rem;min-height:38px;">
                        <?= htmlspecialchars(mb_strimwidth($event['description'], 0, 60, '...')) ?>
                    </p>
                    <div class="mb-2" style="color: #7ed6ff; font-size: 0.97rem;">
                        <i class="fas fa-clock me-2"></i>
                        <?= date('g:i A', strtotime($event['start_time'])) ?> - <?= date('g:i A', strtotime($event['end_time'])) ?>
                    </div>
                    <div class="mb-1">
                        <i class="fas fa-map-marker-alt text-primary"></i>
                        <span class="ms-1"><?= htmlspecialchars($event['venue']) ?></span>
                    </div>
                </div>
                <div class="card-footer bg-dark border-0 pt-0 pb-3 px-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold text-warning" style="font-size:1.2rem;">₱<?= number_format($event['price'], 2) ?></span>
                        <button class="btn btn-danger btn-sm px-4 py-2 fw-bold" style="border-radius: 20px;" onclick="showCancelModal(<?= $event['id'] ?>)">CANCEL REGISTRATION</button>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<script>
let cancelEventId = null;
function showCancelModal(eventId) {
    cancelEventId = eventId;
    const form = document.getElementById('cancelForm');
    form.action = `/endama2/events/cancel-registration/${eventId}`;
    const modal = new bootstrap.Modal(document.getElementById('cancelModal'));
    modal.show();
}
</script> 