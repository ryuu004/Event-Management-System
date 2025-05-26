<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>

<style>
.event-manage-card {
    background: #fff;
    border-radius: 14px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    transition: transform 0.2s, box-shadow 0.2s;
    overflow: hidden;
    margin-bottom: 1.5rem;
}
.event-manage-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(124,58,237,0.08);
}
.event-poster {
    height: 200px;
    object-fit: cover;
    width: 100%;
    transition: transform 0.3s ease;
}
.event-manage-card:hover .event-poster {
    transform: scale(1.05);
}
.status-badge {
    position: absolute;
    top: 15px;
    right: 15px;
    padding: 7px 16px;
    border-radius: 50px;
    font-weight: 600;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    background: #fff;
    color: #7c3aed;
    border: 2px solid #7c3aed;
    box-shadow: 0 2px 8px rgba(124,58,237,0.08);
    z-index: 2;
}
.status-draft {
    background: #f3f4f6 !important;
    color: #7c3aed !important;
    border: 2px solid #e0e7ef !important;
}
.event-manage-card .action-buttons {
    opacity: 0;
    transform: translateY(10px);
    transition: all 0.3s ease;
}
.event-manage-card:hover .action-buttons {
    opacity: 1;
    transform: translateY(0);
}
.event-stats {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 5px 12px;
    border-radius: 8px;
    font-size: 0.95rem;
    margin-right: 8px;
    background: #f3f4f6;
    color: #2c3e50;
    font-weight: 500;
    margin-bottom: 6px;
}
.event-stats i {
    color: #7c3aed;
    font-size: 1rem;
    margin-right: 2px;
}
.create-event-btn {
    background: linear-gradient(135deg, #4f46e5 0%, #9333ea 100%);
    border: none;
    padding: 10px 22px;
    border-radius: 8px;
    font-weight: 600;
    color: #fff;
    font-size: 1rem;
    box-shadow: 0 2px 8px rgba(124,58,237,0.08);
    transition: transform 0.2s, box-shadow 0.2s;
}
.create-event-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(124,58,237,0.15);
}
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
.divider {
    border-top: 1px solid #e2e8f0;
    margin: 2rem 0 1.5rem 0;
}
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-4 section-title"><span class="accent-bar"></span>Manage Events</h2>
    <a href="/endama2/events/create" class="btn create-event-btn">
        <i class="fas fa-plus-circle me-2"></i>Create Event
    </a>
</div>
<div class="divider"></div>

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

<?php if (empty($events)): ?>
    <div class="text-center py-5">
        <div class="mb-4">
            <i class="fas fa-calendar-plus fa-4x text-muted"></i>
        </div>
        <h4 class="text-muted mb-3">You haven't created any events yet</h4>
        <p class="text-muted mb-4">Start by creating your first event and manage it here!</p>
        <a href="/endama2/events/create" class="btn create-event-btn">
            <i class="fas fa-plus-circle me-2"></i>Create Your First Event
        </a>
    </div>
<?php else: ?>
    <div class="row g-4">
        <?php foreach ($events as $event): ?>
            <div class="col-md-6 col-lg-4">
                <div class="event-manage-card h-100">
                    <div class="position-relative">
                        <?php if (!empty($event['poster'])): ?>
                            <img src="/endama2/<?= htmlspecialchars($event['poster']) ?>" alt="Event Poster" class="event-poster">
                        <?php else: ?>
                            <div class="event-poster d-flex align-items-center justify-content-center bg-light">
                                <i class="fas fa-image fa-3x text-muted"></i>
                            </div>
                        <?php endif; ?>
                        <span class="status-badge status-<?= $event['status'] ?>">
                            <?= ucfirst($event['status']) ?>
                        </span>
                    </div>
                    
                    <div class="p-3">
                        <h5 class="mb-3" style="font-weight: 700; color: #2c3e50; letter-spacing: 0.5px;">
                            <?= htmlspecialchars($event['title']) ?>
                        </h5>
                        <div class="mb-3">
                            <div class="event-stats">
                                <i class="fas fa-calendar me-2"></i>
                                <?= date('M d, Y', strtotime($event['event_date'])) ?>
                            </div>
                            <div class="event-stats">
                                <i class="fas fa-clock me-2"></i>
                                <?= date('g:i A', strtotime($event['start_time'])) ?>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="event-stats">
                                <i class="fas fa-map-marker-alt me-2"></i>
                                <?= htmlspecialchars($event['venue']) ?>
                            </div>
                            <div class="event-stats">
                                <i class="fas fa-tag me-2"></i>
                                ₱<?= number_format($event['price'], 2) ?>
                            </div>
                        </div>
                        <div class="action-buttons">
                            <hr class="my-3 opacity-25">
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="/endama2/events/participants/<?= $event['id'] ?>" class="btn btn-primary btn-sm" style="background: linear-gradient(135deg, #4f46e5 0%, #9333ea 100%); border: none; border-radius: 8px; font-weight: 600;">
                                    <i class="fas fa-users me-2"></i>Participants
                                </a>
                                <div>
                                    <a href="/endama2/events/update/<?= $event['id'] ?>" class="btn btn-outline-secondary btn-sm me-2" style="border-radius: 8px; font-weight: 600;">
                                        <i class="fas fa-edit me-1"></i>Edit
                                    </a>
                                    <button onclick="confirmDelete(<?= $event['id'] ?>, '<?= htmlspecialchars($event['title']) ?>')" class="btn btn-danger btn-sm" style="border-radius: 8px; font-weight: 600;">
                                        <i class="fas fa-trash me-1"></i>Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the event "<span id="eventTitle"></span>"?</p>
                <p class="text-danger mb-0"><small>This action cannot be undone.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete Event</button>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(eventId, eventTitle) {
    document.getElementById('eventTitle').textContent = eventTitle;
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    document.getElementById('confirmDeleteBtn').onclick = function() {
        fetch(`/endama2/events/delete/${eventId}`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            location.reload();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to delete event. Please try again.');
        });
        modal.hide();
    };
    modal.show();
}
</script> 