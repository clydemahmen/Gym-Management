<?php
require_once 'init.php';
$auth->check();
$activePage = 'dashboard';
$pageTitle  = 'Dashboard';

$totalMembers    = $memberObj->countAll();
$activeMembers   = $memberObj->countByStatus('Active');
$inactiveMembers = $memberObj->countByStatus('Inactive');
$scheduledSess   = $sessionObj->countByStatus('Scheduled');
$completedSess   = $sessionObj->countByStatus('Completed');
$cancelledSess   = $sessionObj->countByStatus('Cancelled');
$totalRevenue    = $sessionObj->totalRevenue();
$recentSessions  = $sessionObj->getAll();
?>
<?php include 'head.php'; ?>
<?php include 'navbar.php'; ?>

<div class="container py-4">
    <h4 class="fw-bold mb-4">Dashboard</h4>

    <!-- Member Stats -->
    <p class="text-muted mb-2"><strong>Members Overview</strong></p>
    <div class="row g-3 mb-4">
        <div class="col-sm-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="text-primary"><?= $totalMembers ?></h3>
                    <p class="text-muted mb-0">Total Members</p>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="text-success"><?= $activeMembers ?></h3>
                    <p class="text-muted mb-0">Active</p>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="text-danger"><?= $inactiveMembers ?></h3>
                    <p class="text-muted mb-0">Inactive</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Session Stats -->
    <p class="text-muted mb-2"><strong>Sessions Overview</strong></p>
    <div class="row g-3 mb-4">
        <div class="col-sm-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="text-warning"><?= $scheduledSess ?></h3>
                    <p class="text-muted mb-0">Scheduled</p>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="text-success"><?= $completedSess ?></h3>
                    <p class="text-muted mb-0">Completed</p>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="text-danger"><?= $cancelledSess ?></h3>
                    <p class="text-muted mb-0">Cancelled</p>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="text-primary">₱<?= number_format($totalRevenue, 2) ?></h3>
                    <p class="text-muted mb-0">Total Revenue</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Sessions -->
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">Recent Sessions</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead>
                        <tr>
                            <th>Member</th>
                            <th>Session Type</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Processed By</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $count = 0;
                    while($row = mysqli_fetch_assoc($recentSessions)){
                        if($count >= 5) break;
                        $count++;

                        if($row['status'] == 'Completed'){
                            $cls = 'success';
                        } else if($row['status'] == 'Cancelled'){
                            $cls = 'danger';
                        } else {
                            $cls = 'warning';
                        }
                    ?>
                    <tr>
                        <td><?= $row['member_name'] ?></td>
                        <td><?= $row['session_type'] ?></td>
                        <td><?= $row['session_date'] ?></td>
                        <td>₱<?= number_format($row['amount'], 2) ?></td>
                        <td><span class="badge bg-<?= $cls ?>"><?= $row['status'] ?></span></td>
                        <td><?= $row['staff_name'] ?></td>
                    </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <a href="members.php"  class="btn btn-primary me-2">Manage Members</a>
        <a href="sessions.php" class="btn btn-warning me-2">Manage Sessions</a>
        <a href="reports.php"  class="btn btn-dark">View Reports</a>
    </div>
</div>

<?php include 'footer.php'; ?>