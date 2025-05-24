<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">Edit Event</h3>
                </div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="title" class="form-label">Event Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="<?= htmlspecialchars($event['title']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4" required><?= htmlspecialchars($event['description']) ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="venue" class="form-label">Venue</label>
                            <input type="text" class="form-control" id="venue" name="venue" value="<?= htmlspecialchars($event['venue']) ?>" required>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="event_date" class="form-label">Event Date</label>
                                <input type="date" class="form-control" id="event_date" name="event_date" value="<?= htmlspecialchars($event['event_date']) ?>" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="start_time" class="form-label">Start Time</label>
                                <input type="time" class="form-control" id="start_time" name="start_time" value="<?= htmlspecialchars($event['start_time']) ?>" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="end_time" class="form-label">End Time</label>
                                <input type="time" class="form-control" id="end_time" name="end_time" value="<?= htmlspecialchars($event['end_time']) ?>" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="capacity" class="form-label">Capacity</label>
                                <input type="number" class="form-control" id="capacity" name="capacity" min="1" value="<?= htmlspecialchars($event['capacity']) ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label">Price ($)</label>
                                <input type="number" class="form-control" id="price" name="price" min="0" step="0.01" value="<?= htmlspecialchars($event['price']) ?>" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="draft" <?= $event['status'] === 'draft' ? 'selected' : '' ?>>Draft</option>
                                <option value="published" <?= $event['status'] === 'published' ? 'selected' : '' ?>>Published</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="poster" class="form-label">Event Poster (optional, leave blank to keep current)</label>
                            <?php if (!empty($event['poster'])): ?>
                                <div class="mb-2">
                                    <img src="/endama2/<?= htmlspecialchars($event['poster']) ?>" alt="Current Poster" style="max-width:180px;max-height:120px;object-fit:cover;">
                                </div>
                            <?php endif; ?>
                            <input type="file" class="form-control" id="poster" name="poster" accept="image/*">
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Update Event</button>
                            <a href="/endama2/events/manage" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> 