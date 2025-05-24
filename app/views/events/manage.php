<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Manage My Events</h2>
    <a href="/endama2/events/create" class="btn btn-primary">+ Create Event</a>
</div>
<?php if (!empty($_SESSION['success'])): ?>
    <div class="alert alert-success text-center"><?= htmlspecialchars($_SESSION['success']) ?></div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>
<?php if (!empty($_SESSION['error'])): ?>
    <div class="alert alert-danger text-center"><?= htmlspecialchars($_SESSION['error']) ?></div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<?php if (empty($events)): ?>
    <div class="col-12 text-center">
        <p class="text-muted">You haven't created any events yet.</p>
        <a href="/endama2/events/create" class="btn btn-primary">Create Event</a>
    </div>
<?php else: ?>
<div class="table-responsive">
    <table class="table table-bordered align-middle">
        <thead class="table-light">
            <tr>
                <th>Poster</th>
                <th>Title</th>
                <th>Date</th>
                <th>Venue</th>
                <th>Price</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($events as $event): ?>
            <tr>
                <td style="width:120px">
                    <?php if (!empty($event['poster'])): ?>
                        <img src="/endama2/<?= htmlspecialchars($event['poster']) ?>" alt="Poster" style="max-width:100px;max-height:60px;object-fit:cover;">
                    <?php else: ?>
                        <span class="text-muted">No Poster</span>
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($event['title']) ?></td>
                <td><?= htmlspecialchars($event['event_date']) ?><br><small><?= htmlspecialchars($event['start_time']) ?> - <?= htmlspecialchars($event['end_time']) ?></small></td>
                <td><?= htmlspecialchars($event['venue']) ?></td>
                <td>$<?= htmlspecialchars($event['price']) ?></td>
                <td><span class="badge bg-<?= $event['status'] === 'published' ? 'success' : 'secondary' ?>"><?= ucfirst($event['status']) ?></span></td>
                <td>
                    <div class="btn-group">
                        <a href="/endama2/events/participants/<?= $event['id'] ?>" class="btn btn-info btn-sm" title="Participants">
                            <i class="fas fa-users"></i>
                        </a>
                        <a href="/endama2/events/update/<?= $event['id'] ?>" class="btn btn-warning btn-sm" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="/endama2/events/delete/<?= $event['id'] ?>" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm('Are you sure you want to delete this event? This action cannot be undone.');">
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?> 