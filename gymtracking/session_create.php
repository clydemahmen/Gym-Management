<?php
require_once 'init.php';
$auth->check();
$activePage = 'sessions';
$pageTitle  = 'Add Session';
$error = '';

$allMembers = $memberObj->getAll();

if(isset($_POST['submit'])){

    $data = [
        'member_id'    => $_POST['member_id'],
        'session_type' => $_POST['session_type'],
        'session_date' => $_POST['session_date'],
        'start_time'   => $_POST['start_time'],
        'end_time'     => $_POST['end_time'],
        'amount'       => $_POST['amount'],
        'status'       => $_POST['status'],
        'notes'        => $_POST['notes']
    ];

    if($data['member_id'] && $data['session_type'] && $data['session_date']){
        if($sessionObj->create($data, $_SESSION['user_id'])){
            header("Location: sessions.php");
            exit();
        } else {
            $error = "Error saving session.";
        }
    } else {
        $error = "Please fill in all required fields.";
    }
}
?>
<?php include 'head.php'; ?>
<?php include 'navbar.php'; ?>

<div class="container py-4">

    <h4 class="fw-bold mb-4">Add New Session</h4>

    <?php if($error != ''): ?>
    <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <div class="card shadow-sm" style="max-width: 600px;">
        <div class="card-body">
            <form method="POST">

                <div class="mb-3">
                    <label class="form-label">Member *</label>
                    <select name="member_id" class="form-select" required>
                        <option value="">-- Select Member --</option>
                        <?php while($m = mysqli_fetch_assoc($allMembers)): ?>
                        <option value="<?= $m['id'] ?>"><?= $m['full_name'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Session Type *</label>
                    <input type="text" name="session_type" class="form-control" placeholder="e.g. Yoga, Zumba, Personal Training" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Date *</label>
                    <input type="date" name="session_date" class="form-control" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Start Time</label>
                        <input type="time" name="start_time" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">End Time</label>
                        <input type="time" name="end_time" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Amount (₱)</label>
                    <input type="number" name="amount" class="form-control" step="0.01" min="0" value="0">
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="Scheduled">Scheduled</option>
                        <option value="Completed">Completed</option>
                        <option value="Cancelled">Cancelled</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" class="form-control" rows="2" placeholder="Optional..."></textarea>
                </div>

                <button type="submit" name="submit" class="btn btn-success">Save Session</button>
                <a href="sessions.php" class="btn btn-secondary">Cancel</a>

            </form>
        </div>
    </div>

</div>

<?php include 'footer.php'; ?>