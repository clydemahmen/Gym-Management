<?php
require_once 'init.php';
$auth->check();
$activePage = 'reports';
$pageTitle  = 'Reports';

$reportData = mysqli_query($database->getConnection(), "
    SELECT s.id AS session_id, m.full_name AS member_name, m.membership_type,
           s.session_type, s.session_date, s.amount, s.status,
           u.name AS processed_by, u.role AS staff_role
    FROM sessions s
    JOIN members m ON s.member_id = m.id
    JOIN users u ON s.user_id = u.id
    ORDER BY s.session_date DESC");

$revenueByMember = mysqli_query($database->getConnection(), "
    SELECT m.full_name, SUM(s.amount) AS total
    FROM sessions s
    JOIN members m ON s.member_id = m.id
    WHERE s.status = 'Completed'
    GROUP BY m.id
    ORDER BY total DESC");

$revenueByStaff = mysqli_query($database->getConnection(), "
    SELECT u.name AS staff_name, COUNT(s.id) AS total_sessions, SUM(s.amount) AS total_revenue
    FROM sessions s
    JOIN users u ON s.user_id = u.id
    WHERE s.status = 'Completed'
    GROUP BY u.id
    ORDER BY total_revenue DESC");
?>
<?php include 'head.php'; ?>
<?php include 'navbar.php'; ?>

<div class="container py-4">

    <h4 class="fw-bold mb-4">Transaction Reports</h4>

    <!-- Full JOIN Table -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-dark text-white">
            All Sessions — sessions JOIN members JOIN users
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Member</th>
                            <th>Membership</th>
                            <th>Session Type</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Processed By</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(mysqli_num_rows($reportData) > 0): ?>
                    <?php while($row = mysqli_fetch_assoc($reportData)): ?>
                    <tr>
                        <td><?= $row['session_id'] ?></td>
                        <td><?= $row['member_name'] ?></td>
                        <td><span class="badge bg-secondary"><?= $row['membership_type'] ?></span></td>
                        <td><?= $row['session_type'] ?></td>
                        <td><?= $row['session_date'] ?></td>
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
                        <td><?= $row['processed_by'] ?> (<?= $row['staff_role'] ?>)</td>
                    </tr>
                    <?php endwhile; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">No data yet.</td>
                    </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row g-4">

        <!-- Revenue by Member -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">Revenue by Member</div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Member Name</th>
                                <th>Total Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php while($row = mysqli_fetch_assoc($revenueByMember)): ?>
                        <tr>
                            <td><?= $row['full_name'] ?></td>
                            <td class="text-success">₱<?= number_format($row['total'], 2) ?></td>
                        </tr>
                        <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Staff Performance -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">Staff Performance</div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Staff Name</th>
                                <th>Sessions</th>
                                <th>Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php while($row = mysqli_fetch_assoc($revenueByStaff)): ?>
                        <tr>
                            <td><?= $row['staff_name'] ?></td>
                            <td><?= $row['total_sessions'] ?></td>
                            <td class="text-success">₱<?= number_format($row['total_revenue'], 2) ?></td>
                        </tr>
                        <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

</div>

<?php include 'footer.php'; ?>