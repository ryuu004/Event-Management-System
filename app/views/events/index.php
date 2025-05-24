<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>

<div class="row mb-4">
    <div class="col">
        <h2>Upcoming Events</h2>
    </div>
    <div class="col-auto">
        <input type="text" class="form-control" id="searchEvents" placeholder="Search events..." onkeyup="filterEvents()">
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

<?php echo '<!-- DEBUG: user=' . print_r($_SESSION['user'], true) . ' -->'; ?>

<div class="row" id="eventsContainer">
    <?php foreach ($events as $event): ?>
    <div class="col-md-4 mb-4 event-item">
        <div class="card event-card h-100">
            <?php if (!empty($event['poster'])): ?>
            <img src="/endama2/<?= htmlspecialchars($event['poster']) ?>" class="card-img-top" alt="Event Poster" style="max-height:220px;object-fit:cover;">
            <?php endif; ?>
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($event['title']) ?></h5>
                <p class="card-text"><?= htmlspecialchars(substr($event['description'], 0, 100)) ?>...</p>
                
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
                
                <div class="mb-3">
                    <i class="fas fa-user text-primary"></i>
                    Organized by <?= htmlspecialchars($event['organizer_name']) ?>
                </div>
            </div>
            <div class="card-footer bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="badge bg-primary">$<?= htmlspecialchars($event['price']) ?></span>
                    <?php if (isset($_SESSION['user'])): ?>
                    <a href="/endama2/events/register/<?= $event['id'] ?>" class="btn btn-success btn-sm" style="display:block !important;">
                        Join
                    </a>
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
</script> 