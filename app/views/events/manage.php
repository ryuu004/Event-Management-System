<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>

<style>
.event-manage-card {
    background: rgba(24, 28, 58, 0.95);
    border-radius: 16px;
    border: 1px solid rgba(255, 255, 255, 0.1);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    overflow: hidden;
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
}

.event-manage-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
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
    padding: 8px 15px;
    border-radius: 50px;
    font-weight: 600;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
}

.status-published {
    background: rgba(25, 135, 84, 0.9);
    color: white;
}

.status-draft {
    background: rgba(108, 117, 125, 0.9);
    color: white;
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
    display: inline-block;
    padding: 5px 12px;
    border-radius: 50px;
    font-size: 0.85rem;
    margin-right: 8px;
    background: rgba(255, 255, 255, 0.1);
    color: #fff;
}

.create-event-btn {
    background: linear-gradient(45deg, #7ed6ff, #e056fd);
    border: none;
    padding: 12px 25px;
    border-radius: 50px;
    font-weight: 600;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.create-event-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(224, 86, 253, 0.4);
}

.section-title {
    font-size: 2rem;
    font-weight: 600;
    color: #fff;
}
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-4" style="color: #fff;">Manage Events</h2>
    <a href="/endama2/events/create" class="btn create-event-btn">
        <i class="fas fa-plus-circle me-2"></i>Create Event
    </a>
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
                <div class="event-manage-card h-100 text-white">
                    <div class="position-relative">
                        <?php if (!empty($event['poster'])): ?>
                            <img src="/endama2/<?= htmlspecialchars($event['poster']) ?>" alt="Event Poster" class="event-poster">
                        <?php else: ?>
                            <div class="event-poster d-flex align-items-center justify-content-center bg-dark">
                                <i class="fas fa-image fa-3x text-muted"></i>
                            </div>
                        <?php endif; ?>
                        <span class="status-badge status-<?= $event['status'] ?>">
                            <?= ucfirst($event['status']) ?>
                        </span>
                    </div>
                    
                    <div class="p-3">
                        <h5 class="mb-3" style="font-weight: 600;"><?= htmlspecialchars($event['title']) ?></h5>
                        
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
                                <a href="/endama2/events/participants/<?= $event['id'] ?>" class="btn btn-info btn-sm">
                                    <i class="fas fa-users me-2"></i>Participants
                                </a>
                                <div>
                                    <a href="/endama2/events/update/<?= $event['id'] ?>" class="btn btn-warning btn-sm me-2">
                                        <i class="fas fa-edit me-1"></i>Edit
                                    </a>
                                    <button onclick="confirmDelete(<?= $event['id'] ?>, '<?= htmlspecialchars($event['title']) ?>')" class="btn btn-danger btn-sm">
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
        <div class="modal-content bg-dark text-white">
            <div class="modal-header border-secondary">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the event "<span id="eventTitle"></span>"?</p>
                <p class="text-danger mb-0"><small>This action cannot be undone.</small></p>
            </div>
            <div class="modal-footer border-secondary">
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