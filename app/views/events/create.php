<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>

<style>
.create-event-form {
    background: #fff;
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    color: #333;
}

.form-control, .form-select {
    background: #fff;
    border: 1px solid #e2e8f0;
    color: #333;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: #7c3aed;
    box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
    color: #333;
}

.form-control::placeholder {
    color: #a0aec0;
}

.form-label {
    color: #2c3e50;
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.section-title {
    background: linear-gradient(135deg, #4f46e5 0%, #9333ea 100%);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
    font-weight: 800;
    letter-spacing: -0.5px;
}

.submit-btn {
    background: linear-gradient(135deg, #4f46e5 0%, #9333ea 100%);
    border: none;
    padding: 12px 25px;
    border-radius: 8px;
    font-weight: 600;
    color: #fff;
    transition: transform 0.2s, box-shadow 0.2s;
}

.submit-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(124,58,237,0.15);
    color: #fff;
}
</style>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="create-event-form p-4">
                <h3 class="section-title mb-4">Create New Event</h3>
                
                <form id="createEventForm" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="title" class="form-label">Event Title</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="venue" class="form-label">Venue</label>
                                <input type="text" class="form-control" id="venue" name="venue" required>
                            </div>

                            <div class="mb-3">
                                <label for="poster" class="form-label">Event Poster</label>
                                <input type="file" class="form-control" id="poster" name="poster" accept="image/*" required>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label for="event_date" class="form-label">Event Date</label>
                                    <input type="date" class="form-control" id="event_date" name="event_date" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="start_time" class="form-label">Start Time</label>
                                    <input type="time" class="form-control" id="start_time" name="start_time" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="end_time" class="form-label">End Time</label>
                                    <input type="time" class="form-control" id="end_time" name="end_time" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="capacity" class="form-label">Capacity</label>
                                    <input type="number" class="form-control" id="capacity" name="capacity" min="1" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="price" class="form-label">Price (₱)</label>
                                    <input type="number" class="form-control" id="price" name="price" min="0" step="0.01" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="draft">Draft</option>
                                    <option value="published">Published</option>
                                </select>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="/endama2/events/manage" class="btn btn-outline-secondary px-4" style="border-radius:8px;">Cancel</a>
                                <button type="submit" class="btn submit-btn px-4">Create Event</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('createEventForm').addEventListener('submit', function(e) {
    const startTime = document.getElementById('start_time').value;
    const endTime = document.getElementById('end_time').value;
    
    if (startTime >= endTime) {
        e.preventDefault();
        alert('End time must be later than start time');
    }
});</script> 