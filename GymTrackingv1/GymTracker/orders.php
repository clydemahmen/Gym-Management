<?php
require_once 'init.php';
$auth->check();
$activePage = 'orders';
$pageTitle  = 'Equipment Orders';

$search = $_GET['search'] ?? '';
$status = $_GET['status'] ?? '';

$orders = $orderObj->getAll($search, $status);
?>
<?php include 'head.php'; ?>
<?php include 'navbar.php'; ?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Equipment Orders</h4>
        <a href="order_create.php" class="btn btn-warning">+ New Order</a>
    </div>

    <!-- Search / Filter -->
    <form method="GET" class="row g-2 mb-4">
        <div class="col-sm-5">
            <input type="text" name="search" class="form-control" placeholder="Search equipment or member..." value="<?= htmlspecialchars($search) ?>">
        </div>
        <div class="col-sm-4">
            <select name="status" class="form-select">
                <option value="">All Statuses</option>
                <?php foreach(['Pending','Processing','Delivered','Cancelled'] as $s): ?>
                    <option value="<?= $s ?>" <?= $status == $s ? 'selected' : '' ?>><?= $s ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-sm-3 d-flex gap-2">
            <button type="submit" class="btn btn-dark w-100">Filter</button>
            <a href="orders.php" class="btn btn-outline-secondary w-100">Reset</a>
        </div>
    </form>

    <!-- Table -->
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Member</th>
                            <th>Equipment</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $count = 0;
                    while($row = mysqli_fetch_assoc($orders)):
                        $count++;
                        $statusColors = [
                            'Pending'    => 'warning',
                            'Processing' => 'info',
                            'Delivered'  => 'success',
                            'Cancelled'  => 'danger',
                        ];
                        $sc    = $statusColors[$row['status']] ?? 'secondary';
                        $total = $row['price'] * $row['quantity'];
                    ?>
                    <tr>
                        <td><?= $count ?></td>
                        <td><?= htmlspecialchars($row['member_name']) ?></td>
                        <td><?= htmlspecialchars($row['equipment_name']) ?></td>
                        <td><?= $row['quantity'] ?></td>
                        <td>₱<?= number_format($row['price'], 2) ?></td>
                        <td>₱<?= number_format($total, 2) ?></td>
                        <td><span class="badge bg-<?= $sc ?>"><?= $row['status'] ?></span></td>
                        <td><?= date('M d, Y', strtotime($row['created_at'])) ?></td>
                        <td>
                            <a href="order_edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-primary me-1">Edit</a>
                            <a href="order_delete.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-danger"
                               onclick="return confirm('Delete this order?')">Delete</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    <?php if($count == 0): ?>
                    <tr><td colspan="9" class="text-center text-muted py-4">No orders found.</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
