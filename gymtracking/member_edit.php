<?php
require_once 'init.php';
$auth->check();
$activePage = 'members';
$pageTitle  = 'Edit Member';

$id = (int)$_GET['id'];
$member = $memberObj->getById($id);

if(!$member){
    header("Location: members.php");
    exit();
}

$error = '';

if(isset($_POST['update'])){

    $data = [
        'full_name'       => $_POST['full_name'],
        'email'           => $_POST['email'],
        'phone'           => $_POST['phone'],
        'address'         => $_POST['address'],
        'membership_type' => $_POST['membership_type'],
        'status'          => $_POST['status']
    ];

    if($memberObj->update($id, $data)){
        header("Location: members.php");
        exit();
    } else {
        $error = "Error updating member.";
    }
}
?>
<?php include 'head.php'; ?>
<?php include 'navbar.php'; ?>

<div class="container py-4">

    <h4 class="fw-bold mb-4">Edit Member</h4>

    <?php if($error != ''): ?>
    <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <div class="card shadow-sm" style="max-width: 600px;">
        <div class="card-body">
            <form method="POST">

                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="full_name" class="form-control" value="<?= $member['full_name'] ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="<?= $member['email'] ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control" value="<?= $member['phone'] ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Address</label>
                    <textarea name="address" class="form-control" rows="2"><?= $member['address'] ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Membership Type</label>
                    <select name="membership_type" class="form-select">
                        <option value="Basic" <?php if($member['membership_type'] == 'Basic') echo 'selected'; ?>>Basic</option>
                        <option value="Standard" <?php if($member['membership_type'] == 'Standard') echo 'selected'; ?>>Standard</option>
                        <option value="Premium" <?php if($member['membership_type'] == 'Premium') echo 'selected'; ?>>Premium</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="Active" <?php if($member['status'] == 'Active') echo 'selected'; ?>>Active</option>
                        <option value="Inactive" <?php if($member['status'] == 'Inactive') echo 'selected'; ?>>Inactive</option>
                        <option value="Suspended" <?php if($member['status'] == 'Suspended') echo 'selected'; ?>>Suspended</option>
                    </select>
                </div>

                <button type="submit" name="update" class="btn btn-warning">Update Member</button>
                <a href="members.php" class="btn btn-secondary">Cancel</a>

            </form>
        </div>
    </div>

</div>

<?php include 'footer.php'; ?>