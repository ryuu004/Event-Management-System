<style>
.participants-card {
    background: rgba(24, 28, 58, 0.95);
    border-radius: 16px;
    border: 1px solid rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
}

.search-input {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: #fff;
    border-radius: 20px;
    padding: 8px 15px;
    width: 220px;
}

.search-input:focus {
    background: rgba(255, 255, 255, 0.15);
    border-color: rgba(255, 255, 255, 0.3);
    color: #fff;
    box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.1);
}

.search-input::placeholder {
    color: rgba(255, 255, 255, 0.6);
}

.back-btn {
    background: linear-gradient(45deg, #7ed6ff, #e056fd);
    border: none;
    padding: 8px 20px;
    border-radius: 20px;
    color: #fff;
    font-weight: 500;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.back-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(224, 86, 253, 0.4);
    color: #fff;
}

.ticket-badge {
    background: linear-gradient(45deg, #00b09b, #96c93d);
    padding: 5px 12px;
    border-radius: 12px;
    font-weight: 500;
    font-size: 0.9rem;
    letter-spacing: 0.5px;
}

.stats-container {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 12px;
    padding: 15px 20px;
    margin-top: 20px;
}

.stats-item {
    color: #fff;
    font-size: 0.95rem;
}

.stats-value {
    font-weight: 600;
    color: #7ed6ff;
}

.dark-table {
    color: #fff;
}

.dark-table thead th {
    background: rgba(255, 255, 255, 0.1);
    border-bottom: none;
    color: #7ed6ff;
    font-weight: 600;
    padding: 12px 15px;
}

.dark-table tbody td {
    border-color: rgba(255, 255, 255, 0.1);
    padding: 12px 15px;
}

.dark-table tbody tr:hover {
    background: rgba(255, 255, 255, 0.05);
}
</style>

<div class="container py-4">
    <div class="row mb-4 align-items-center">
        <div class="col">
            <h2 class="mb-2" style="color: #fff; font-weight: 600;">Event Participants</h2>
            <h5 style="color: #7ed6ff;"><?= htmlspecialchars($event['title']) ?></h5>
        </div>
        <div class="col-auto">
            <a href="/endama2/events/my-events" class="back-btn">
                <i class="fas fa-arrow-left me-2"></i>Back to My Events
            </a>
        </div>
    </div>

    <div class="participants-card">
        <div class="card-header border-0 py-3">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="mb-0" style="color: #fff;">Registered Participants</h5>
                </div>
                <div class="col-auto">
                    <input type="text" class="search-input" id="searchParticipants" 
                           placeholder="Search participants..." onkeyup="filterParticipants()">
                </div>
            </div>
        </div>
        
        <div class="card-body">
            <?php if (empty($participants)): ?>
            <p class="text-center" style="color: rgba(255, 255, 255, 0.6);">No participants registered yet.</p>
            <?php else: ?>
            <div class="table-responsive">
                <table class="table dark-table">
                    <thead>
                        <tr>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Ticket Code</th>
                            <th>Registration Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($participants as $participant): ?>
                        <tr class="participant-row">
                            <td><?= htmlspecialchars(trim(($participant['first_name'] ?? '') . ' ' . ($participant['last_name'] ?? ''))) ?></td>
                            <td><?= htmlspecialchars($participant['email']) ?></td>
                            <td>
                                <span class="ticket-badge">
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

            <div class="stats-container">
                <div class="row">
                    <div class="col-md-6">
                        <p class="stats-item mb-2">
                            <i class="fas fa-users me-2"></i>
                            Total Participants: <span class="stats-value"><?= count($participants) ?></span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p class="stats-item mb-0">
                            <i class="fas fa-ticket-alt me-2"></i>
                            Remaining Capacity: <span class="stats-value"><?= $event['capacity'] - count($participants) ?> spots</span>
                        </p>
                    </div>
                </div>
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
        const fullName = (row.cells[0].textContent || '').toLowerCase();
        const email = row.cells[1].textContent.toLowerCase();
        const ticketCode = row.cells[2].textContent.toLowerCase();
        
        if (fullName.includes(searchText) || 
            email.includes(searchText) || 
            ticketCode.includes(searchText)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}
</script> 