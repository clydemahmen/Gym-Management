<?php
require_once 'init.php';
$auth->check();
$activePage = 'members';
$pageTitle  = 'Members';

$search = '';
$filterStatus = '';

if(isset($_GET['q'])){
    $search = $_GET['q'];
}

if(isset($_GET['status'])){
    $filterStatus = $_GET['status'];
}

$members = $memberObj->getAll($search, $filterStatus);
?>
<?php include 'head.php'; ?>
<?php include 'navbar.php'; ?>

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Gym Members</h4>
        <a href="member_create.php" class="btn btn-success">Add Member</a>
    </div>

    <form method="GET" class="card card-body shadow-sm mb-4">
        <div class="row g-2">
            <div class="col-md-6">
                <label class="form-label">Search</label>
                <input type="text" name="q" class="form-control" placeholder="Name, email, phone..." value="<?= $search ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="Active" <?php if($filterStatus == 'Active') echo 'selected'; ?>>Active</option>
                    <option value="Inactive" <?php if($filterStatus == 'Inactive') echo 'selected'; ?>>Inactive</option>
                    <option value="Suspended" <?php if($filterStatus == 'Suspended') echo 'selected'; ?>>Suspended</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">&nbsp;</label><br>
                <button type="submit" class="btn btn-primary">Search</button>
                <?php if($search || $filterStatus): ?>
                <a href="members.php" class="btn btn-secondary">Clear</a>
                <?php endif; ?>
            </div>
        </div>
    </form>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <?php if(mysqli_num_rows($members) > 0): ?>
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Membership</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php while($row = mysqli_fetch_assoc($members)): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['full_name'] ?></td>
                        <td><?= $row['email'] ?></td>
                        <td><?= $row['phone'] ?></td>
                        <td>
                            <?php
                            if($row['membership_type'] == 'Basic'){
                                echo "<span class='badge bg-primary'>Basic</span>";
                            } else if($row['membership_type'] == 'Standard'){
                                echo "<span class='badge bg-success'>Standard</span>";
                            } else {
                                echo "<span class='badge bg-warning text-dark'>Premium</span>";
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            if($row['status'] == 'Active'){
                                echo "<span class='badge bg-success'>Active</span>";
                            } else if($row['status'] == 'Inactive'){
                                echo "<span class='badge bg-danger'>Inactive</span>";
                            } else {
                                echo "<span class='badge bg-warning text-dark'>Suspended</span>";
                            }
                            ?>
                        </td>
                        <td>
                            <a href="member_edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="member_delete.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger"
                               onclick="return confirm('Delete this member?')">Delete</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <div class="text-center py-5 text-muted">
                <p>No members found. <a href="member_create.php">Add one!</a></p>
            </div>
            <?php endif; ?>
        </div>
    </div>

</div>

<?php include 'footer.php'; ?>