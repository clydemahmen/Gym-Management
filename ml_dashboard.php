<?php
require_once 'init.php';
$auth->check();
$activePage = 'ml_dashboard';
$pageTitle  = 'ML Dashboard';

// preprocessData() — fetch data from DB
// trainModel()     — classify all customers
// predict()        — show output results

$frequentBuyers = $mlModel->getFrequentBuyers();
$summary        = $mlModel->getSummary();
$allClassified  = $mlModel->trainModel();

$classColors = [
    'Frequent Buyer'   => 'success',
    'Occasional Buyer' => 'warning',
    'New Customer'     => 'secondary',
];
$classIcons = [
    'Frequent Buyer'   => '🏆',
    'Occasional Buyer' => '🛒',
    'New Customer'     => '👤',
];
?>
<?php include 'head.php'; ?>
<?php include 'navbar.php'; ?>

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h4 class="fw-bold mb-0">ML Dashboard</h4>
        <span class="badge bg-dark fs-6">Customer Classification</span>
    </div>

    <!-- ML Info Banner -->
    <div class="alert alert-info mb-4">
        <strong>ML Package:</strong> <code>davmixcool/php-sentiment-analyzer</code> from
        <a href="https://packagist.org/packages/davmixcool/php-sentiment-analyzer" target="_blank">Packagist.org</a>
        &nbsp;|&nbsp;
        <strong>Feature:</strong> Customer Classification —
        <span class="text-success fw-semibold">Frequent Buyer</span> ·
        <span class="text-warning fw-semibold">Occasional Buyer</span> ·
        <span class="text-secondary fw-semibold">New Customer</span>
    </div>

    <!-- Classification Summary -->
    <p class="text-muted mb-2"><strong>Classification Summary</strong></p>
    <div class="row g-3 mb-4">
        <?php foreach($summary as $label => $count): ?>
        <div class="col-md-4">
            <div class="card shadow-sm border-<?= $classColors[$label] ?>">
                <div class="card-body text-center py-3">
                    <div style="font-size:2rem"><?= $classIcons[$label] ?></div>
                    <h2 class="fw-bold text-<?= $classColors[$label] ?>"><?= $count ?></h2>
                    <p class="mb-0 fw-semibold"><?= $label ?></p>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- MAIN ML OUTPUT: Predicted Frequent Buyers -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-success text-white fw-bold fs-5">
            🏆 Predicted Frequent Buyers
        </div>
        <div class="card-body p-0">
            <?php if(empty($frequentBuyers)): ?>
                <div class="text-center text-muted py-4">
                    No frequent buyers yet. Customers need 3+ orders to be classified as Frequent Buyers.
                </div>
            <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Customer Name</th>
                            <th>Membership</th>
                            <th>Total Orders</th>
                            <th>Total Spent</th>
                            <th>Last Order</th>
                            <th>ML Prediction</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($frequentBuyers as $i => $c): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><strong><?= htmlspecialchars($c['full_name']) ?></strong></td>
                        <td><?= $c['membership_type'] ?></td>
                        <td><?= $c['total_orders'] ?></td>
                        <td>₱<?= number_format($c['total_spent'], 2) ?></td>
                        <td><?= $c['last_order_date'] ? date('M d, Y', strtotime($c['last_order_date'])) : '—' ?></td>
                        <td>
                            <span class="badge bg-success fs-6">
                                🏆 Frequent Buyer
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Full Classification Table -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-dark text-white fw-bold">
            📊 All Customers — ML Classification Results
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Customer Name</th>
                            <th>Membership</th>
                            <th>Total Orders</th>
                            <th>Total Spent</th>
                            <th>ML Classification</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($allClassified as $i => $c): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= htmlspecialchars($c['full_name']) ?></td>
                        <td><?= $c['membership_type'] ?></td>
                        <td><?= $c['total_orders'] ?></td>
                        <td>₱<?= number_format($c['total_spent'], 2) ?></td>
                        <td>
                            <span class="badge bg-<?= $classColors[$c['classification']] ?>">
                                <?= $classIcons[$c['classification']] ?> <?= $c['classification'] ?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- How It Works -->
    <div class="card shadow-sm">
        <div class="card-header bg-warning text-dark fw-bold">
            🔍 How the ML Classification Works
        </div>
        <div class="card-body">
            <p>The system follows this flow:</p>
            <ol>
                <li><strong>Data Input</strong> — <code>preprocessData()</code> fetches customer and order data from MySQL</li>
                <li><strong>Model Processing</strong> — <code>trainModel()</code> runs classification on each customer</li>
                <li><strong>Output / Prediction</strong> — <code>predict()</code> returns the classification label per customer</li>
            </ol>
            <table class="table table-bordered table-sm w-auto">
                <thead class="table-dark">
                    <tr>
                        <th>Classification</th>
                        <th>Rule</th>
                        <th>Business Insight</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><span class="badge bg-success">🏆 Frequent Buyer</span></td>
                        <td>3 or more orders</td>
                        <td>Loyal customer — prioritize for promotions</td>
                    </tr>
                    <tr>
                        <td><span class="badge bg-warning text-dark">🛒 Occasional Buyer</span></td>
                        <td>1 to 2 orders</td>
                        <td>Potential — send re-engagement offers</td>
                    </tr>
                    <tr>
                        <td><span class="badge bg-secondary">👤 New Customer</span></td>
                        <td>0 orders</td>
                        <td>New member — recommend first purchase</td>
                    </tr>
                </tbody>
            </table>
            <p class="text-muted small mb-0">
                ML Package: <code>davmixcool/php-sentiment-analyzer</code> from Packagist.org.
                OOP Class: <code>MLModel.php</code> with methods:
                <code>preprocessData()</code>, <code>classify()</code>, <code>trainModel()</code>, <code>predict()</code>.
            </p>
        </div>
    </div>

</div>

<?php include 'footer.php'; ?>
