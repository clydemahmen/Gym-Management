<?php
require_once 'init.php';
$auth->check();
$activePage = 'sessions';
$pageTitle  = 'Edit Session';

$id = (int)$_GET['id'];
$session = $sessionObj->getById($id);

if(!$session){
    header("Location: sessions.php");
    exit();
}

$allMembers = $memberObj->getAll();
$error = '';

if(isset($_POST['update'])){

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

    if($sessionObj->update($id, $data)){
        header("Location: sessions.php");
        exit();
    } else {
        $error = "Error updating session.";
    }
}
?>
<?php include 'head.php'; ?>
<?php include 'navbar.php'; ?>

<div class="container py-4">

    <h4 class="fw-bold mb-4">Edit Session</h4>

    <?php if($error != ''): ?>
    <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <div class="card shadow-sm" style="max-width: 600px;">
        <div class="card-body">
            <form method="POST">

                <div class="mb-3">
                    <label class="form-label">Member</label>
                    <select name="member_id" class="form-select">
                        <?php while($m = mysqli_fetch_assoc($allMembers)): ?>
                        <option value="<?= $m['id'] ?>" <?php if($session['member_id'] == $m['id']) echo 'selected'; ?>><?= $m['full_name'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Session Type</label>
                    <input type="text" name="session_type" class="form-control" value="<?= $session['session_type'] ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Date</label>
                    <input type="date" name="session_date" class="form-control" value="<?= $session['session_date'] ?>">
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Start Time</label>
                        <input type="time" name="start_time" class="form-control" value="<?= $session['start_time'] ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">End Time</label>
                        <input type="time" name="end_time" class="form-control" value="<?= $session['end_time'] ?>">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Amount (₱)</label>
                    <input type="number" name="amount" class="form-control" step="0.01" value="<?= $session['amount'] ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="Scheduled" <?php if($session['status'] == 'Scheduled') echo 'selected'; ?>>Scheduled</option>
                        <option value="Completed" <?php if($session['status'] == 'Completed') echo 'selected'; ?>>Completed</option>
                        <option value="Cancelled" <?php if($session['status'] == 'Cancelled') echo 'selected'; ?>>Cancelled</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" class="form-control" rows="2"><?= $session['notes'] ?></textarea>
                </div>

                <button type="submit" name="update" class="btn btn-warning">Update Session</button>
                <a href="sessions.php" class="btn btn-secondary">Cancel</a>

            </form>
        </div>
    </div>

</div>

<?php include 'footer.php'; ?>