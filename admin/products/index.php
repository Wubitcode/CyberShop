<?php
declare(strict_types=1);

require_once __DIR__ . '/../../app/config.php';
require_once __DIR__ . '/../../app/db.php'; 
require_once __DIR__ . '/../../app/auth.php';
require_once __DIR__ . '/../../app/helpers.php';
require_once __DIR__ . '/../../app/repos/products_repo.php';

require_admin();

$title = "Inventory Terminal | CyberShop";
$user = current_user();

// Fetch all products from your repository
try {
    $products = products_all(); // Assuming this function exists in products_repo.php
} catch (Exception $e) {
    $products = [];
    error_log($e->getMessage());
}

include __DIR__ . '/../../app/partials/header.php';
?>

<style>
    body, html { margin: 0 !important; padding: 0 !important; background-color: #000 !important; }
    .container, .container-fluid { padding: 0 !important; margin: 0 !important; max-width: 100% !important; }
</style>

<link rel="stylesheet" href="/cybershop/assets/css/admin-theme.css">

<div class="admin-wrapper">
    <?php include __DIR__ . '/../../app/partials/admin_sidebar.php'; ?>

    <main class="main-terminal">
        <header class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-0 text-white">INVENTORY_LOG: ASSET_MANAGEMENT</h4>
                <small class="text-info"><i class="bi bi-cpu-fill"></i> Hardware & Software Repository</small>
            </div>
            <a href="create.php" class="btn btn-sm btn-cyan fw-bold px-3">
                <i class="bi bi-plus-lg"></i> REGISTER_NEW_ASSET
            </a>
        </header>

        <div class="cyber-card">
            <div class="table-responsive">
                <table class="table-terminal">
                    <thead>
                        <tr>
                            <th>ASSET_ID</th>
                            <th>NAME_IDENTIFIER</th>
                            <th>VALUATION</th>
                            <th>STOCK_LEVEL</th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $p): ?>
                        <tr>
                            <td class="text-dim">#<?= e($p['id']) ?></td>
                            <td class="fw-bold text-white"><?= e($p['name']) ?></td>
                            <td class="text-cyan fw-bold"><?= money((float)$p['price']) ?></td>
                            <td>
                                <?php if ($p['stock'] <= 5): ?>
                                    <span class="text-warning small fw-bold"><i class="bi bi-exclamation-triangle"></i> LOW_STOCK (<?= $p['stock'] ?>)</span>
                                <?php else: ?>
                                    <span class="text-success small fw-bold"><i class="bi bi-check2-circle"></i> OPTIMAL (<?= $p['stock'] ?>)</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="edit.php?id=<?= $p['id'] ?>" class="btn btn-dark btn-sm border-secondary text-info me-2">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a href="delete.php?id=<?= $p['id'] ?>" class="btn btn-dark btn-sm border-secondary text-danger" onclick="return confirm('Confirm Deletion?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<?php include __DIR__ . '/../../app/partials/footer.php'; ?>