<?php
require_once 'init.php';
$auth->check();
$activePage = 'orders';
$pageTitle  = 'New Order';

$error   = '';
$success = '';

$members = $memberObj->getAll();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $data = [
        'member_id'      => $_POST['member_id'],
        'user_id'        => $_SESSION['user_id'],
        'equipment_name' => trim($_POST['equipment_name']),
        'quantity'       => (int)$_POST['quantity'],
        'price'          => (float)$_POST['price'],
        'status'         => $_POST['status'],
    ];

    if(empty($data['equipment_name']) || $data['quantity'] < 1 || $data['price'] < 0){
        $error = 'Please fill in all required fields correctly.';
    } else {
        if($orderObj->create($data)){
            header('Location: orders.php?created=1');
            exit();
        } else {
            $error = 'Failed to create order. Please try again.';
        }
    }
}
?>
<?php include 'head.php'; ?>
<?php include 'navbar.php'; ?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">New Equipment Order</h4>
        <a href="orders.php" class="btn btn-outline-secondary">← Back</a>
    </div>

    <?php if($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Member <span class="text-danger">*</span></label>
                        <select name="member_id" class="form-select" required>
                            <option value="">-- Select Member --</option>
                            <?php while($m = mysqli_fetch_assoc($members)): ?>
                                <option value="<?= $m['id'] ?>"><?= htmlspecialchars($m['full_name']) ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Equipment Name <span class="text-danger">*</span></label>
                        <input type="text" name="equipment_name" class="form-control" required
                               placeholder="e.g. Adjustable Dumbbell Set"
                               value="<?= htmlspecialchars($_POST['equipment_name'] ?? '') ?>">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Quantity <span class="text-danger">*</span></label>
                        <input type="number" name="quantity" class="form-control" min="1" required
                               value="<?= htmlspecialchars($_POST['quantity'] ?? '1') ?>">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Price (per item) ₱ <span class="text-danger">*</span></label>
                        <input type="number" name="price" class="form-control" min="0" step="0.01" required
                               value="<?= htmlspecialchars($_POST['price'] ?? '') ?>">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Status</label>
                        <select name="status" class="form-select">
                            <?php foreach(['Pending','Processing','Delivered','Cancelled'] as $s): ?>
                                <option value="<?= $s ?>" <?= (($_POST['status'] ?? 'Pending') == $s) ? 'selected' : '' ?>><?= $s ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-12 d-flex gap-2">
                        <button type="submit" class="btn btn-warning">Create Order</button>
                        <a href="orders.php" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
