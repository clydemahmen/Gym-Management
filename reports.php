<?php
require_once 'init.php';
$auth->check();
$activePage = 'reports';
$pageTitle  = 'Reports';

$totalOrders      = $orderObj->countAll();
$pendingOrders    = $orderObj->countByStatus('Pending');
$processingOrders = $orderObj->countByStatus('Processing');
$deliveredOrders  = $orderObj->countByStatus('Delivered');
$cancelledOrders  = $orderObj->countByStatus('Cancelled');
$totalRevenue     = $orderObj->totalRevenue();

$conn = $database->getConnection();

// Top ordered equipment
$topEquipment = mysqli_query($conn,
    "SELECT equipment_name, COUNT(*) AS total_orders, SUM(quantity) AS total_qty, SUM(price*quantity) AS total_revenue
     FROM orders GROUP BY equipment_name ORDER BY total_orders DESC LIMIT 10"
);

// Orders by member
$memberOrders = mysqli_query($conn,
    "SELECT m.full_name, COUNT(o.id) AS total_orders, SUM(o.price*o.quantity) AS total_spent
     FROM orders o JOIN members m ON o.member_id=m.id
     GROUP BY o.member_id ORDER BY total_orders DESC LIMIT 10"
);
?>
<?php include 'head.php'; ?>
<?php include 'navbar.php'; ?>

<div class="container py-4">
    <h4 class="fw-bold mb-4">Reports & Analytics</h4>

    <!-- Order Summary -->
    <p class="text-muted mb-2"><strong>Order Summary</strong></p>
    <div class="row g-3 mb-4">
        <div class="col-sm-2">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <h3 class="text-dark"><?= $totalOrders ?></h3>
                    <small class="text-muted">Total Orders</small>
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <h3 class="text-warning"><?= $pendingOrders ?></h3>
                    <small class="text-muted">Pending</small>
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <h3 class="text-info"><?= $processingOrders ?></h3>
                    <small class="text-muted">Processing</small>
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <h3 class="text-success"><?= $deliveredOrders ?></h3>
                    <small class="text-muted">Delivered</small>
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <h3 class="text-danger"><?= $cancelledOrders ?></h3>
                    <small class="text-muted">Cancelled</small>
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <h3 class="text-primary" style="font-size:1.2rem">₱<?= number_format($totalRevenue, 0) ?></h3>
                    <small class="text-muted">Revenue</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Top Equipment -->
        <div class="col-md-7">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">Top Ordered Equipment</div>
                <div class="card-body p-0">
                    <table class="table table-hover table-striped mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Equipment</th>
                                <th>Orders</th>
                                <th>Total Qty</th>
                                <th>Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $rank = 0;
                        while($r = mysqli_fetch_assoc($topEquipment)):
                            $rank++;
                        ?>
                        <tr>
                            <td><?= $rank ?></td>
                            <td><?= htmlspecialchars($r['equipment_name']) ?></td>
                            <td><?= $r['total_orders'] ?></td>
                            <td><?= $r['total_qty'] ?></td>
                            <td>₱<?= number_format($r['total_revenue'], 2) ?></td>
                        </tr>
                        <?php endwhile; ?>
                        <?php if($rank == 0): ?>
                            <tr><td colspan="5" class="text-center text-muted py-3">No data yet.</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Orders by Member -->
        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">Orders by Member</div>
                <div class="card-body p-0">
                    <table class="table table-hover table-striped mb-0">
                        <thead>
                            <tr>
                                <th>Member</th>
                                <th>Orders</th>
                                <th>Total Spent</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $mrank = 0;
                        while($r = mysqli_fetch_assoc($memberOrders)):
                            $mrank++;
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($r['full_name']) ?></td>
                            <td><?= $r['total_orders'] ?></td>
                            <td>₱<?= number_format($r['total_spent'], 2) ?></td>
                        </tr>
                        <?php endwhile; ?>
                        <?php if($mrank == 0): ?>
                            <tr><td colspan="3" class="text-center text-muted py-3">No data yet.</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>