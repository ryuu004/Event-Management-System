<style>
.participants-card {
  background: #fff;
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    padding: 2rem 2rem 1.5rem 2rem;
}

.search-input {
    background: #fff;
    border: 1px solid #e2e8f0;
    color: #333;
    border-radius: 8px;
    padding: 8px 15px;
    width: 220px;
    font-size: 1rem;
}

.search-input:focus {
    border-color: #7c3aed;
    box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
    color: #333;
}

.search-input::placeholder {
    color: #a0aec0;
}

.back-btn {
    background: #fff;
    border: 1.5px solid #e2e8f0;
    color: #2c3e50;
    border-radius: 8px;
    padding: 8px 20px;
    font-weight: 500;
    transition: background 0.2s, box-shadow 0.2s, color 0.2s;
}

.back-btn:hover {
    background: #f3f4f6;
    color: #7c3aed;
    box-shadow: 0 2px 8px rgba(124,58,237,0.07);
}

.ticket-badge {
    background: #e6f9ed;
    color: #219150;
    padding: 5px 12px;
    border-radius: 12px;
    font-weight: 500;
    font-size: 0.9rem;
    letter-spacing: 0.5px;
}

.stats-container {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 15px 20px;
    margin-top: 20px;
    border: 1px solid #e2e8f0;
}

.stats-item {
    color: #333;
    font-size: 0.95rem;
}

.stats-value {
    font-weight: 600;
    color: #2c3e50;
}

.light-table {
    color: #333;
    background: #fff;
}

.light-table thead th {
    background: #f6f6fa;
    border-bottom: none;
    color: #2c3e50;
    font-weight: 600;
    padding: 12px 15px;
}

.light-table tbody td {
    border-color: #e2e8f0;
    padding: 12px 15px;
}

.light-table tbody tr:hover {
    background: #f3f4f6;
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
</style>

<div class="container py-4">
    <div class="row mb-4 align-items-center">
        <div class="col">
            <h2 class="mb-2 section-title"><span class="accent-bar"></span>Event Participants</h2>
            <h5 style="color: #2c3e50; font-weight: 500;"><?= htmlspecialchars($event['title']) ?></h5>
        </div>
        <div class="col-auto">
            <a href="/endama2/events/my-events" class="back-btn">
                <i class="fas fa-arrow-left me-2"></i>Back to My Events
            </a>
        </div>
    </div>

    <div class="participants-card">
        <div class="card-header border-0 py-3" style="background: #f6f6fa; border-radius: 10px 10px 0 0; border: none;">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="mb-0 fw-bold" style="color: #2c3e50;">Registered Participants</h5>
                </div>
                <div class="col-auto d-flex align-items-center">
                    <input type="text" class="search-input" id="searchParticipants" 
                           placeholder="Search participants..." onkeyup="filterParticipants()">
                </div>
            </div>
        </div>
        
        <div class="card-body">
            <?php if (empty($participants)): ?>
            <p class="text-center" style="color: #6c757d;">No participants registered yet.</p>
            <?php else: ?>
            <div class="table-responsive">
                <table class="table light-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Ticket Code</th>
                            <th>Registration Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($participants as $participant): ?>
                        <tr class="participant-row">
                            <td><?= htmlspecialchars($participant['name']) ?></td>
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
                            <i class="fas fa-users me-2" style="color:#7c3aed;"></i>
                            Total Participants: <span class="stats-value"><?= count($participants) ?></span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p class="stats-item mb-0">
                            <i class="fas fa-ticket-alt me-2" style="color:#7c3aed;"></i>
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