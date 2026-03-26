<?php
declare(strict_types=1);

ini_set('display_errors', '1');
error_reporting(E_ALL);

// Secure pathing for Mac XAMPP
require_once __DIR__ . '/../app/config.php';
require_once __DIR__ . '/../app/db.php'; 
require_once __DIR__ . '/../app/auth.php';
require_once __DIR__ . '/../app/helpers.php';
require_once __DIR__ . '/../app/repos/orders_repo.php';

require_login();

$orderId = (int)($_GET['id'] ?? 0);
$order = order_find($orderId); // This will now work!
$user = current_user();

// Security check
if (!$order || ((int)$order['user_id'] !== (int)$user['user_id'] && !is_admin())) {
    die("FATAL_ERROR: Order #$orderId is not associated with this terminal session.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = db();
    $stmt = $db->prepare("UPDATE orders SET status = 'paid' WHERE order_id = ?");
    $stmt->execute([$orderId]);

    header("Location: order_details.php?id=" . $orderId . "&status=confirmed");
    exit;
}

$title = "Payment Terminal | CyberShop";
include __DIR__ . '/../app/partials/header.php';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card bg-dark border-info shadow-lg p-4 text-white">
                <div class="text-center mb-4">
                    <h3 class="text-info font-monospace">DEBIT_AUTHORIZATION</h3>
                    <p class="small text-muted">SECURE_NODE: <?= $_SERVER['REMOTE_ADDR'] ?></p>
                </div>

                <div class="mb-4 p-3 bg-black rounded border border-secondary">
                    <span class="small text-secondary">AMOUNT_DUE:</span>
                    <div class="h2 text-white fw-bold font-monospace"><?= money((float)$order['total']) ?></div>
                </div>

                <form method="POST">
                    <div class="mb-3">
                        <label class="small text-info">CARD_IDENTIFIER</label>
                        <input type="text" class="form-control bg-black text-info border-secondary" placeholder="0000 0000 0000 0000" required>
                    </div>
                    <div class="row mb-4">
                        <div class="col-6">
                            <input type="text" class="form-control bg-black text-info border-secondary" placeholder="MM/YY" required>
                        </div>
                        <div class="col-6">
                            <input type="password" class="form-control bg-black text-info border-secondary" placeholder="CVC" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-info w-100 fw-bold py-3">CONFIRM_TRANSACTION</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../app/partials/footer.php'; ?>