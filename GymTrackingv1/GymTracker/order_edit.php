<?php
require_once 'init.php';
$auth->check();
$activePage = 'orders';
$pageTitle  = 'Edit Order';

$id    = (int)($_GET['id'] ?? 0);
$order = $orderObj->getById($id);

if(!$order){
    header('Location: orders.php');
    exit();
}

$error   = '';
$members = $memberObj->getAll();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $data = [
        'member_id'      => $_POST['member_id'],
        'equipment_name' => trim($_POST['equipment_name']),
        'quantity'       => (int)$_POST['quantity'],
        'price'          => (float)$_POST['price'],
        'status'         => $_POST['status'],
    ];

    if(empty($data['equipment_name']) || $data['quantity'] < 1){
        $error = 'Please fill in all required fields correctly.';
    } else {
        if($orderObj->update($id, $data)){
            header('Location: orders.php?updated=1');
            exit();
        } else {
            $error = 'Update failed. Please try again.';
        }
    }
}
?>
<?php include 'head.php'; ?>
<?php include 'navbar.php'; ?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Edit Order #<?= $id ?></h4>
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
                        <label class="form-label fw-semibold">Member</label>
                        <select name="member_id" class="form-select" required>
                            <option value="">-- Select Member --</option>
                            <?php while($m = mysqli_fetch_assoc($members)): ?>
                                <option value="<?= $m['id'] ?>"
                                    <?= ($m['id'] == $order['member_id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($m['full_name']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Equipment Name</label>
                        <input type="text" name="equipment_name" class="form-control" required
                               value="<?= htmlspecialchars($order['equipment_name']) ?>">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Quantity</label>
                        <input type="number" name="quantity" class="form-control" min="1" required
                               value="<?= $order['quantity'] ?>">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Price (per item) ₱</label>
                        <input type="number" name="price" class="form-control" min="0" step="0.01" required
                               value="<?= $order['price'] ?>">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Status</label>
                        <select name="status" class="form-select">
                            <?php foreach(['Pending','Processing','Delivered','Cancelled'] as $s): ?>
                                <option value="<?= $s ?>" <?= ($order['status'] == $s) ? 'selected' : '' ?>><?= $s ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-12 d-flex gap-2">
                        <button type="submit" class="btn btn-warning">Update Order</button>
                        <a href="orders.php" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
