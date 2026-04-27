<?php
require_once 'init.php';
$auth->check();
$activePage = 'members';
$pageTitle  = 'Add Member';
$error = '';

if(isset($_POST['submit'])){

    $data = [
        'full_name'       => $_POST['full_name'],
        'email'           => $_POST['email'],
        'phone'           => $_POST['phone'],
        'address'         => $_POST['address'],
        'membership_type' => $_POST['membership_type'],
        'status'          => $_POST['status']
    ];

    if($data['full_name'] && $data['phone']){
        if($memberObj->create($data)){
            header("Location: members.php");
            exit();
        } else {
            $error = "Error saving member.";
        }
    } else {
        $error = "Please fill in required fields.";
    }
}
?>
<?php include 'head.php'; ?>
<?php include 'navbar.php'; ?>

<div class="container py-4">

    <h4 class="fw-bold mb-4">Add New Member</h4>

    <?php if($error != ''): ?>
    <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <div class="card shadow-sm" style="max-width: 600px;">
        <div class="card-body">
            <form method="POST">

                <div class="mb-3">
                    <label class="form-label">Full Name *</label>
                    <input type="text" name="full_name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Phone *</label>
                    <input type="text" name="phone" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Address</label>
                    <textarea name="address" class="form-control" rows="2"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Membership Type</label>
                    <select name="membership_type" class="form-select">
                        <option value="Basic">Basic</option>
                        <option value="Standard">Standard</option>
                        <option value="Premium">Premium</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                        <option value="Suspended">Suspended</option>
                    </select>
                </div>

                <button type="submit" name="submit" class="btn btn-success">Save Member</button>
                <a href="members.php" class="btn btn-secondary">Cancel</a>

            </form>
        </div>
    </div>

</div>

<?php include 'footer.php'; ?>