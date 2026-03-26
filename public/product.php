<?php
declare(strict_types=1);

// 1. Debugging & Dependencies
ini_set('display_errors', '1');
error_reporting(E_ALL);

require_once __DIR__ . '/../app/config.php';
require_once __DIR__ . '/../app/auth.php';
require_once __DIR__ . '/../app/helpers.php';
require_once __DIR__ . '/../app/repos/products_repo.php';

// 2. Fetch Product Data
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ?: 0;
// Note: Ensure product_find() or product_find_by_id() is in your repo
$product = $id ? product_find($id) : null;

if (!$product || (int)($product['isActive'] ?? 0) !== 1) {
    header("Location: index.php");
    exit;
}

// 3. Image Logic with Cyber Fallbacks
$image = trim((string)($product['image'] ?? ''));
if ($image === '') {
    $fallbacks = ['antivirus.png', 'firewall.png', 'vpn.png'];
    $image = BASE_URL . '/assets/images/' . $fallbacks[array_rand($fallbacks)];
} else {
    $image = BASE_URL . '/assets/images/' . $image;
}

$title = $product['name'] . " | Asset Inspection";
include __DIR__ . '/../app/partials/header.php';
?>

<style>
    body { background-color: #05070a !important; color: #e6edf3 !important; }
    
    .inspection-card {
        background: #0d1117;
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        padding: 40px;
    }

    .asset-id-tag {
        font-family: 'Consolas', monospace;
        color: #00d2ff;
        font-size: 0.8rem;
        letter-spacing: 2px;
    }

    .price-display {
        font-family: 'Consolas', monospace;
        color: #00d2ff;
        font-size: 2rem;
        font-weight: bold;
    }

    .full-description {
        color: #a9b2bb; /* High readability silver-grey */
        line-height: 1.8;
        font-size: 1.05rem;
    }

    .img-frame {
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 8px;
        background: #000;
        overflow: hidden;
    }

    .form-control-cyber {
        background: #05070a;
        border: 1px solid #30363d;
        color: #fff;
    }

    .form-control-cyber:focus {
        background: #05070a;
        border-color: #00d2ff;
        color: #fff;
        box-shadow: 0 0 10px rgba(0, 210, 255, 0.2);
    }
</style>

<div class="container py-5">
    <nav class="mb-4">
        <h6 class="text-info small fw-bold" style="letter-spacing: 1.5px;">
            SECURE_STORE > ONTARIO_NODE > ASSET_INSPECTION
        </h6>
    </nav>

    <div class="inspection-card shadow-lg">
        <div class="row g-5">
            <div class="col-md-6">
                <div class="img-frame">
                    <img class="img-fluid w-100" 
                         style="object-fit: cover; min-height: 400px; opacity: 0.9;"
                         src="<?= e($image) ?>"
                         alt="<?= e($product['name']) ?>">
                </div>
            </div>

            <div class="col-md-6">
                <div class="asset-id-tag mb-2">SKU_VERIFICATION: <?= e($product['sku'] ?? 'NULL') ?></div>
                <h1 class="display-6 fw-bold text-white mb-3"><?= e($product['name']) ?></h1>
                
                <div class="price-display mb-4">
                    <?= money((float)$product['price']) ?>
                </div>

                <div class="mb-5">
                    <h6 class="text-white text-uppercase small fw-bold border-bottom border-secondary pb-2 mb-3">Technical Description</h6>
                    <p class="full-description">
                        <?= nl2br(e((string)($product['description'] ?? 'No technical data provided.'))) ?>
                    </p>
                </div>

                <form method="post" action="<?= BASE_URL ?>/public/cart_add.php">
                    <input type="hidden" name="productId" value="<?= (int)($product['product_id'] ?? $product['id']) ?>">

                    <div class="row g-2 align-items-end">
                        <div class="col-3">
                            <label class="form-label small text-muted font-monospace">QUANTITY</label>
                            <input type="number" min="1" max="99" name="qty" class="form-control form-control-cyber" value="1">
                        </div>
                        <div class="col-9">
                            <button class="btn btn-cyan w-100 py-2 fw-bold" type="submit">
                                <i class="bi bi-cart-plus me-2"></i> ADD TO CART
                            </button>
                        </div>
                    </div>
                </form>

                <div class="mt-4">
                    <a class="btn btn-outline-secondary btn-sm w-100" href="<?= BASE_URL ?>/public/index.php">
                        <i class="bi bi-arrow-left me-2"></i> RETURN TO REPOSITORY
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../app/partials/footer.php'; ?>