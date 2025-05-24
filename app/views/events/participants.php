<div class="container">
    <div class="row mb-4">
        <div class="col">
            <h2>Event Participants</h2>
            <h5 class="text-muted"><?= htmlspecialchars($event['title']) ?></h5>
        </div>
        <div class="col-auto">
            <a href="/endama2/events/my-events" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to My Events
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="mb-0">Registered Participants</h5>
                </div>
                <div class="col-auto">
                    <input type="text" class="form-control" id="searchParticipants" 
                           placeholder="Search participants..." onkeyup="filterParticipants()">
                </div>
            </div>
        </div>
        
        <div class="card-body">
            <?php if (empty($participants)): ?>
            <p class="text-center text-muted">No participants registered yet.</p>
            <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Ticket Code</th>
                            <th>Registration Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($participants as $participant): ?>
                        <tr class="participant-row">
                            <td><?= htmlspecialchars($participant['username']) ?></td>
                            <td><?= htmlspecialchars($participant['email']) ?></td>
                            <td>
                                <span class="badge bg-success">
                                    <?= htmlspecialchars($participant['ticket_code']) ?>
                                </span>
                            </td>
                            <td>
                                <?= date('M d, Y H:i', strtotime($participant['registration_date'])) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                <p class="mb-0">
                    <strong>Total Participants:</strong> <?= count($participants) ?>
                </p>
                <p class="mb-0">
                    <strong>Remaining Capacity:</strong> 
                    <?= $event['capacity'] - count($participants) ?> spots
                </p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function filterParticipants() {
    const searchText = document.getElementById('searchParticipants').value.toLowerCase();
    const rows = document.getElementsByClassName('participant-row');
    
    Array.from(rows).forEach(row => {
        const username = row.cells[0].textContent.toLowerCase();
        const email = row.cells[1].textContent.toLowerCase();
        const ticketCode = row.cells[2].textContent.toLowerCase();
        
        if (username.includes(searchText) || 
            email.includes(searchText) || 
            ticketCode.includes(searchText)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}
</script> 