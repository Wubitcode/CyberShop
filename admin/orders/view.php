<?php
declare(strict_types=1);

// 1. Load System Dependencies
require_once __DIR__ . '/../../app/config.php';
require_once __DIR__ . '/../../app/auth.php';
require_once __DIR__ . '/../../app/helpers.php';
require_once __DIR__ . '/../../app/repos/orders_repo.php';

// 2. Security
require_admin();

// 3. Data Acquisition
$orderId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ?: 0;
$order = order_find($orderId); 
$items = order_items($orderId); 

if (!$order) {
    header("Location: index.php");
    exit;
}

$title = "Manifest Intelligence: #" . $orderId;
$user = current_user();

include __DIR__ . '/../../app/partials/header.php';
?>

<style>
    /* Reset margins for Zero-Gap */
    body, html { margin: 0 !important; padding: 0 !important; background-color: #000 !important; }
    
    :root { --cyber-blue: #00d2ff; }
    .text-glow { color: var(--cyber-blue); text-shadow: 0 0 10px rgba(0, 210, 255, 0.3); }
    .intel-label { font-size: 0.65rem; color: #6c757d; text-transform: uppercase; letter-spacing: 1px; }
    .status-pill { font-size: 0.7rem; padding: 0.2rem 0.8rem; }
</style>

<link rel="stylesheet" href="/cybershop/assets/css/admin-theme.css">

<div class="admin-wrapper">
    <?php include __DIR__ . '/../../app/partials/admin_sidebar.php'; ?>

    <main class="main-terminal">
        <header class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h6 class="text-info small fw-bold mb-1">MANAGEMENT > ORDERS > INSPECT</h6>
                <h4 class="fw-bold mb-0 text-white text-glow">ORDER_MANIFEST: #<?= (int)$order['order_id'] ?></h4>
            </div>
            <a href="index.php" class="btn btn-dark btn-sm border-secondary text-dim">
                <i class="bi bi-chevron-left"></i> RETURN_TO_LOGS
            </a>
        </header>

        <div class="row g-4">
            <!-- Client Intel Sidebar -->
            <div class="col-xl-4">
                <div class="cyber-card h-100">
                    <h5 class="fw-bold mb-4 text-white border-bottom border-secondary border-opacity-25 pb-3">
                        <i class="bi bi-person-bounding-box me-2 text-info"></i>CLIENT_INTEL
                    </h5>
                    
                    <div class="mb-4">
                        <label class="intel-label d-block mb-1">Entity Name</label>
                        <span class="text-white fw-bold h5"><?= e($order['customer_name'] ?? 'Unknown') ?></span>
                    </div>
                    
                    <div class="mb-4">
                        <label class="intel-label d-block mb-1">Communication Channel</label>
                        <span class="text-info"><?= e($order['email'] ?? 'N/A') ?></span>
                    </div>
                    
                    <div class="mb-0">
                        <label class="intel-label d-block mb-1">Deployment Timestamp</label>
                        <span class="text-white small">
                            <?= date('F j, Y - H:i', strtotime($order['order_date'])) ?>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Itemized Manifest -->
            <div class="col-xl-8">
                <div class="cyber-card">
                    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom border-secondary border-opacity-25 pb-3">
                        <h5 class="fw-bold mb-0 text-white">
                            <i class="bi bi-box-seam me-2 text-info"></i>ASSET_DEPLOYMENT
                        </h5>
                        <span class="badge rounded-pill status-pill <?= $order['status'] === 'paid' ? 'bg-success bg-opacity-10 text-success border border-success' : 'bg-warning bg-opacity-10 text-warning border border-warning' ?>">
                            <?= strtoupper($order['status']) ?>
                        </span>
                    </div>

                    <div class="table-responsive">
                        <table class="table-terminal mb-0">
                            <thead>
                                <tr>
                                    <th>SECURITY_ASSET</th>
                                    <th class="text-center">QTY</th>
                                    <th class="text-end">UNIT_PRICE</th>
                                    <th class="text-end">SUBTOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($items as $item): 
                                    $sub = (float)$item['price_at_purchase'] * (int)$item['quantity'];
                                ?>
                                <tr>
                                    <td>
                                        <div class="fw-bold text-white"><?= e($item['name']) ?></div>
                                        <div class="text-dim x-small">NODE_ID: <?= (int)$item['product_id'] ?></div>
                                    </td>
                                    <td class="text-center text-white"><?= (int)$item['quantity'] ?></td>
                                    <td class="text-end text-dim"><?= money((float)$item['price_at_purchase']) ?></td>
                                    <td class="text-end text-cyan fw-bold"><?= money($sub) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end text-dim text-uppercase fw-bold py-4">Total Manifest Valuation:</td>
                                    <td class="text-end text-glow h4 fw-bold py-4"><?= money((float)$order['total']) ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<?php include __DIR__ . '/../../app/partials/footer.php'; ?>