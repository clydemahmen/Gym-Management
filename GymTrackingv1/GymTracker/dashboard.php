<?php
require_once 'init.php';
$auth->check();
$activePage = 'dashboard';
$pageTitle  = 'Dashboard';

$totalMembers    = $memberObj->countAll();
$activeMembers   = $memberObj->countByStatus('Active');
$inactiveMembers = $memberObj->countByStatus('Inactive');

$pendingOrders    = $orderObj->countByStatus('Pending');
$processingOrders = $orderObj->countByStatus('Processing');
$deliveredOrders  = $orderObj->countByStatus('Delivered');
$cancelledOrders  = $orderObj->countByStatus('Cancelled');
$totalRevenue     = $orderObj->totalRevenue();
$recentOrders     = $orderObj->getRecentOrders(5);
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

    <!-- Orders Stats -->
    <p class="text-muted mb-2"><strong>Equipment Orders Overview</strong></p>
    <div class="row g-3 mb-4">
        <div class="col-sm-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="text-warning"><?= $pendingOrders ?></h3>
                    <p class="text-muted mb-0">Pending</p>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="text-info"><?= $processingOrders ?></h3>
                    <p class="text-muted mb-0">Processing</p>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="text-success"><?= $deliveredOrders ?></h3>
                    <p class="text-muted mb-0">Delivered</p>
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

    <!-- Recent Orders -->
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">Recent Equipment Orders</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead>
                        <tr>
                            <th>Member</th>
                            <th>Equipment</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Processed By</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php while($row = mysqli_fetch_assoc($recentOrders)): ?>
                        <?php
                            $statusColors = [
                                'Pending'    => 'warning',
                                'Processing' => 'info',
                                'Delivered'  => 'success',
                                'Cancelled'  => 'danger',
                            ];
                            $sc = $statusColors[$row['status']] ?? 'secondary';
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($row['member_name']) ?></td>
                            <td><?= htmlspecialchars($row['equipment_name']) ?></td>
                            <td><?= $row['quantity'] ?></td>
                            <td>₱<?= number_format($row['price'], 2) ?></td>
                            <td><span class="badge bg-<?= $sc ?>"><?= $row['status'] ?></span></td>
                            <td><?= htmlspecialchars($row['staff_name']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <a href="members.php" class="btn btn-primary me-2">Manage Members</a>
        <a href="orders.php"  class="btn btn-warning me-2">Manage Orders</a>
        <a href="reports.php" class="btn btn-dark">View Reports</a>
    </div>
</div>

<?php include 'footer.php'; ?>