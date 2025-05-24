<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<h2 class="mb-4">My Events</h2>
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
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <?php if (!empty($event['poster'])): ?>
                <img src="/endama2/<?= htmlspecialchars($event['poster']) ?>" class="card-img-top" alt="Event Poster" style="max-height:220px;object-fit:cover;">
                <?php endif; ?>
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($event['title']) ?></h5>
                    <p class="card-text"><?= htmlspecialchars($event['description']) ?></p>
                    <div class="mb-2">
                        <i class="fas fa-map-marker-alt text-primary"></i>
                        <?= htmlspecialchars($event['venue']) ?>
                    </div>
                    <div class="mb-2">
                        <i class="fas fa-calendar text-primary"></i>
                        <?= htmlspecialchars($event['event_date']) ?>
                    </div>
                    <div class="mb-2">
                        <i class="fas fa-clock text-primary"></i>
                        <?= htmlspecialchars($event['start_time']) ?> - <?= htmlspecialchars($event['end_time']) ?>
                    </div>
                    <?php if (!empty($event['ticket_code'])): ?>
                    <div class="mb-2">
                        <i class="fas fa-ticket-alt text-primary"></i>
                        Ticket: <?= htmlspecialchars($event['ticket_code']) ?>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-primary">$<?= htmlspecialchars($event['price']) ?></span>
                        <button class="btn btn-danger btn-sm" onclick="showCancelModal(<?= $event['id'] ?>)">Cancel Registration</button>
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