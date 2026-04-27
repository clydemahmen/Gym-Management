<?php
require_once 'init.php';
$auth->check();
$activePage = 'sessions';
$pageTitle  = 'Sessions';

$search = '';
$filterStatus = '';

if(isset($_GET['q'])){
    $search = $_GET['q'];
}

if(isset($_GET['status'])){
    $filterStatus = $_GET['status'];
}

$sessions = $sessionObj->getAll($search, $filterStatus);
?>
<?php include 'head.php'; ?>
<?php include 'navbar.php'; ?>

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Gym Sessions</h4>
        <a href="session_create.php" class="btn btn-success">Add Session</a>
    </div>

    <form method="GET" class="card card-body shadow-sm mb-4">
        <div class="row g-2">
            <div class="col-md-6">
                <label class="form-label">Search</label>
                <input type="text" name="q" class="form-control" placeholder="Member name or session type..." value="<?= $search ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="Scheduled" <?php if($filterStatus == 'Scheduled') echo 'selected'; ?>>Scheduled</option>
                    <option value="Completed" <?php if($filterStatus == 'Completed') echo 'selected'; ?>>Completed</option>
                    <option value="Cancelled" <?php if($filterStatus == 'Cancelled') echo 'selected'; ?>>Cancelled</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">&nbsp;</label><br>
                <button type="submit" class="btn btn-primary">Search</button>
                <?php if($search || $filterStatus): ?>
                <a href="sessions.php" class="btn btn-secondary">Clear</a>
                <?php endif; ?>
            </div>
        </div>
    </form>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <?php if(mysqli_num_rows($sessions) > 0): ?>
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Member</th>
                            <th>Session Type</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Processed By</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php while($row = mysqli_fetch_assoc($sessions)): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['member_name'] ?></td>
                        <td><?= $row['session_type'] ?></td>
                        <td><?= $row['session_date'] ?></td>
                        <td><?= $row['start_time'] ?> - <?= $row['end_time'] ?></td>
                        <td>₱<?= number_format($row['amount'], 2) ?></td>
                        <td>
                            <?php
                            if($row['status'] == 'Completed'){
                                echo "<span class='badge bg-success'>Completed</span>";
                            } else if($row['status'] == 'Cancelled'){
                                echo "<span class='badge bg-danger'>Cancelled</span>";
                            } else {
                                echo "<span class='badge bg-warning text-dark'>Scheduled</span>";
                            }
                            ?>
                        </td>
                        <td><?= $row['staff_name'] ?></td>
                        <td>
                            <a href="session_edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="session_delete.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger"
                               onclick="return confirm('Delete this session?')">Delete</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <div class="text-center py-5 text-muted">
                <p>No sessions found. <a href="session_create.php">Add one!</a></p>
            </div>
            <?php endif; ?>
        </div>
    </div>

</div>

<?php include 'footer.php'; ?>