<?php
declare(strict_types=1);

// ===============================
// 1. Include Core App Files
// ===============================
require_once __DIR__ . '/../app/config.php';
require_once __DIR__ . '/../app/db.php';
require_once __DIR__ . '/../app/auth.php';
require_once __DIR__ . '/../app/helpers.php';
require_once __DIR__ . '/../app/repos/products_repo.php';
require_once __DIR__ . '/../app/repos/orders_repo.php';

// ===============================
// 2. Security: Only Admin Access
// ===============================
require_admin(); 

// ===============================
// 3. Page Title and Current User
// ===============================
$title = "Cyber Intelligence | Admin Dashboard";
$user = current_user(); 

// ===============================
// 4. Fetch Dashboard Data from Database
// ===============================
try {
    $totalProducts = (int)products_count();       // Total products
    $pendingOrders = (int)orders_count_pending(); // Pending orders
    $totalRevenue  = (float)orders_total_revenue(); // Total revenue
    $latestOrders  = orders_latest_limit(5);      // Last 5 orders

    // Chart placeholders
    $chartLabels = ['01','05','10','15','20','25','30'];
    $chartData   = [4000, 12000, 15000, 22000, 19000, 28000, 33700]; 
} catch (Exception $e) {
    error_log("Dashboard Data Error: " . $e->getMessage());
    $totalProducts = $pendingOrders = 0;
    $totalRevenue = 0.0;
    $latestOrders = [];
}

// ===============================
// 5. Include Header Partial
// ===============================
include __DIR__ . '/../app/partials/header.php';
?>

<!-- ===============================
     6. Admin CSS & Bootstrap Icons
================================= -->
<link rel="stylesheet" href="/cybershop/assets/css/admin_css.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<!-- ===============================
     7. Cyberpunk Admin Dashboard
================================= -->
<div class="admin-wrapper d-flex">

    <!-- ===============================
         Sidebar Navigation (Cyber Style)
    ================================= -->
    <aside class="sidebar bg-dark text-white p-3">
        <div class="sidebar-brand mb-4 text-info">
            <h4 class="fw-bold">CYBER INTEL</h4>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item mb-2"><a href="dashboard.php" class="nav-link text-white"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>
            <li class="nav-item mb-2"><a href="products/index.php" class="nav-link text-white"><i class="bi bi-box-seam me-2"></i>Manage Products</a></li>
            <li class="nav-item mb-2"><a href="products/add.php" class="nav-link text-white"><i class="bi bi-plus-square me-2"></i>Add Product</a></li>
            <li class="nav-item mb-2"><a href="orders/index.php" class="nav-link text-white"><i class="bi bi-receipt me-2"></i>Orders</a></li>
            <li class="nav-item mb-2"><a href="inventory/index.php" class="nav-link text-white"><i class="bi bi-stack me-2"></i>Inventory</a></li>
            <li class="nav-item mt-4"><a href="../public/index.php" class="nav-link btn btn-outline-info w-100 text-center">Return to Shop</a></li>
        </ul>
    </aside>

    <!-- ===============================
         Main Content (Cyber Dark Theme)
    ================================= -->
    <main class="main-content flex-grow-1 p-4" style="background-color: #0d0d0d; color: #fff;">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold text-glow">Welcome, <?= e($user['fullName'] ?? 'Operator') ?></h4>
            <div class="text-end">
                <small class="text-info"><i class="bi bi-shield-lock-fill"></i> ADMIN LIVE SESSION</small>
            </div>
        </div>

        <!-- Stats Cards (Cyber Neon Style) -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="cyber-card shadow-sm" style="border-left: 5px solid #00d2ff;">
                    <div class="stat-label">Total Revenue</div>
                    <div class="stat-value text-info"><?= money($totalRevenue) ?></div>
                    <div class="text-success small">Including Tax</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="cyber-card shadow-sm" style="border-left: 5px solid #AF1763;">
                    <div class="stat-label">Pending Orders</div>
                    <div class="stat-value"><?= $pendingOrders ?></div>
                    <div class="text-warning small">Needs Attention</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="cyber-card shadow-sm" style="border-left: 5px solid #198754;">
                    <div class="stat-label">Total Products</div>
                    <div class="stat-value"><?= $totalProducts ?></div>
                    <div class="text-success small">Active Listings</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="cyber-card shadow-sm" style="border-left: 5px solid #0dcaf0;">
                    <div class="stat-label">Security Protocol</div>
                    <div class="stat-value text-success">
                        <span class="spinner-grow spinner-grow-sm"></span> ACTIVE
                    </div>
                    <div class="text-muted small">Firewall Level 5</div>
                </div>
            </div>
        </div>

        <!-- Growth Analytics Chart -->
        <div class="row g-3 mb-4">
            <div class="col-lg-8">
                <div class="cyber-card shadow-sm p-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold text-uppercase text-info m-0">Growth Analytics</h6>
                        <span class="badge bg-dark border border-secondary text-info">30D CYCLE</span>
                    </div>
                    <div style="height: 300px;">
                        <canvas id="growthChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- System Control Panel -->
            <div class="col-lg-4">
                <div class="cyber-card shadow-sm p-3">
                    <h6 class="fw-bold mb-3 text-info">SYSTEM CONTROL</h6>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="small text-dim">Maintenance Mode</span>
                        <div class="form-check form-switch"><input class="form-check-input" type="checkbox"></div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="small text-dim">Public Registration</span>
                        <div class="form-check form-switch"><input class="form-check-input" type="checkbox" checked></div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="small text-dim">API Latency</span>
                        <span class="text-success fw-bold small">14ms</span>
                    </div>
                    <button class="btn btn-sm btn-outline-info w-100 fw-bold text-uppercase">System Configuration</button>
                </div>
            </div>
        </div>

        <!-- Recent Orders Table -->
        <div class="cyber-card shadow-sm p-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold m-0 text-uppercase text-info">Recent Orders</h6>
                <a href="orders/index.php" class="btn btn-dark btn-sm border-secondary text-info px-3">View All</a>
            </div>
            <div class="table-responsive">
                <table class="table-terminal">
                    <thead>
                        <tr>
                            <th>Client</th>
                            <th>Order ID</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($latestOrders as $row): ?>
                        <tr>
                            <td class="text-info fw-bold"><?= e($row['customer_name']) ?></td>
                            <td class="text-dim">#<?= $row['order_id'] ?></td>
                            <td class="text-success fw-bold"><?= money((float)$row['total']) ?></td>
                            <td>
                                <span class="badge <?= strtolower($row['status'])==='pending'?'bg-warning text-dark':'bg-success' ?>">
                                    <?= strtoupper($row['status']) ?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </main>
</div>

<!-- ===============================
     Chart.js Script for Growth Analytics
================================= -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('growthChart').getContext('2d');
const gradient = ctx.createLinearGradient(0, 0, 0, 300);
gradient.addColorStop(0, 'rgba(0, 210, 255, 0.4)');
gradient.addColorStop(1, 'rgba(0, 210, 255, 0)');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?= json_encode($chartLabels) ?>,
        datasets: [{
            data: <?= json_encode($chartData) ?>,
            borderColor: '#00d2ff',
            backgroundColor: gradient,
            fill: true,
            tension: 0.4,
            borderWidth: 3,
            pointRadius: 0,
            pointHoverRadius: 6
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            y: { grid: { color: 'rgba(255,255,255,0.05)' }, ticks: { color: '#6c7293' } },
            x: { grid: { display: false }, ticks: { color: '#6c7293' } }
        }
    }
});
</script>

<?php include __DIR__ . '/../app/partials/footer.php'; ?>