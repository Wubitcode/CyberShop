<?php
declare(strict_types=1);

require_once __DIR__ . '/../app/config.php'; 
require_once __DIR__ . '/../app/auth.php';
require_once __DIR__ . '/../app/helpers.php';
require_once __DIR__ . '/../app/repos/products_repo.php';
require_once __DIR__ . '/../app/repos/orders_repo.php';

require_login('/public/login.php');

if (session_status() !== PHP_SESSION_ACTIVE) session_start();
$cart = $_SESSION['cart'] ?? [];

// Redirect if cart is empty
if (count($cart) === 0) {
    header("Location: " . BASE_URL . "/public/cart.php");
    exit;
}

$items = [];
$totalAmount = 0.0;

foreach ($cart as $pid => $qty) {
    $p = product_find((int)$pid);
    if (!$p) continue;
    
    $lineTotal = ((float)$p['price'] * (int)$qty);
    $totalAmount += $lineTotal;

    $items[] = [
        'productId' => (int)$p['product_id'], 
        'name'      => $p['name'],
        'qty'       => (int)$qty, 
        'unitPrice' => (float)$p['price']
    ];
}

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $user = current_user();
        
        // This now matches the 'user_id' we just set in auth.php
        $uid = (int)($user['user_id'] ?? 0);
        
        if ($uid === 0) {
            throw new Exception("SESSION_EXPIRED - System could not find 'user_id'.");
        }

        // Place the order
        $newId = order_create($uid, $items);
        
        if ($newId > 0) {
            $_SESSION['cart'] = []; 
            header("Location: " . BASE_URL . "/public/payment.php?id=" . $newId);
            exit;
        }
    } catch (Throwable $e) {
        $error = "DEPLOYMENT_FAILED: " . $e->getMessage();
    }
}

$title = "Authorize Deployment | CyberShop";
include __DIR__ . '/../app/partials/header.php';
?>

<style>
    body { background-color: #05070a !important; color: #e6edf3 !important; }
    
    .checkout-terminal {
        background: #0d1117;
        border: 1px solid rgba(0, 210, 255, 0.2);
        border-radius: 12px;
        padding: 40px;
    }

    .text-cyan { color: #00d2ff !important; }
    .text-silver { color: #a9b2bb !important; }

    .btn-authorize {
        background: #00d2ff;
        color: #000;
        font-weight: 800;
        border: none;
        padding: 15px 30px;
        text-transform: uppercase;
        letter-spacing: 1.5px;
    }

    .btn-authorize:hover {
        background: #00b4db;
        box-shadow: 0 0 20px rgba(0, 210, 255, 0.5);
        color: #000;
    }

    .summary-item {
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        padding: 12px 0;
    }
</style>

<div class="container py-5">
    <!-- Breadcrumb -->
    <div class="mb-4">
        <h6 class="text-info small fw-bold" style="letter-spacing: 2px;">SECURE_STORE > AUTHORIZE_ACQUISITION</h6>
        <h1 class="h2 text-white fw-bold"><i class="bi bi-shield-check me-2 text-info"></i>Final Authorization</h1>
    </div>

    <?php if ($error): ?>
      <div class="alert alert-danger bg-dark border-danger text-danger shadow-sm mb-4">
        <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= e($error) ?>
      </div>
    <?php endif; ?>

    <div class="row g-4">
        <div class="col-md-8">
            <div class="checkout-terminal shadow-lg">
                <h5 class="text-white mb-4 border-bottom border-secondary pb-2">MANIFEST REVIEW</h5>
                
                <?php foreach ($items as $item): ?>
                    <div class="summary-item d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-white fw-bold d-block"><?= e($item['name']) ?></span>
                            <span class="text-silver small font-monospace">QTY: <?= $item['qty'] ?> x <?= money($item['unitPrice']) ?></span>
                        </div>
                        <span class="text-cyan fw-bold font-monospace"><?= money($item['qty'] * $item['unitPrice']) ?></span>
                    </div>
                <?php endforeach; ?>

                <div class="mt-4 p-3 bg-dark bg-opacity-50 rounded border border-secondary border-opacity-25">
                    <p class="text-silver small mb-0">
                        <i class="bi bi-info-circle text-info me-2"></i> 
                        Authorized assets will be deployed to the regional node associated with your account. This action is irreversible.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="checkout-terminal border-info">
                <h6 class="text-info font-monospace small mb-2">TOTAL_COST</h6>
                <h2 class="text-white fw-bold mb-4" style="text-shadow: 0 0 10px rgba(0, 210, 255, 0.4);">
                    <?= money($totalAmount) ?>
                </h2>

                <form method="post">
                    <button type="submit" class="btn btn-authorize w-100 mb-3">
                        <i class="bi bi-lock-fill me-2"></i> PLACE ORDER
                    </button>
                    <a class="btn btn-outline-secondary w-100" href="<?= BASE_URL ?>/public/cart.php">
                        <i class="bi bi-arrow-left"></i> BACK TO CART
                    </a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../app/partials/footer.php'; ?>