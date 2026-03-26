<?php
declare(strict_types=1);
require_once __DIR__ . '/../../app/auth.php';
require_once __DIR__ . '/../../app/repos/products_repo.php';

require_admin();

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT) ?: 0;
if ($id) {
    product_delete($id);
}
header("Location: " . BASE_URL . "/admin/products/index.php");
exit;
?>