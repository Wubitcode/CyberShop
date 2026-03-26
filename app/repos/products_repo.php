<?php
declare(strict_types=1);

require_once __DIR__ . '/../db.php';



/**
 * 1. Fetches only active products (isActive = 1)
 */
function products_all_active(): array {
    try {
        $stmt = db()->query("SELECT * FROM products WHERE isActive = 1 ORDER BY product_id DESC");
        return $stmt->fetchAll();
    } catch (Exception $e) {
        error_log("Repo Error: " . $e->getMessage());
        return [];
    }
}

/**
 * 2. Returns the total count of all products (FIXED: ONLY ONE DEFINITION)
 */
function products_count(): int {
    try {
        $stmt = db()->query("SELECT COUNT(*) FROM products");
        return (int)$stmt->fetchColumn();
    } catch (Exception $e) {
        return 0;
    }
}

/**
 * 3. Fetches all products for Admin
 */
function products_all(): array {
    return db()->query("SELECT * FROM products ORDER BY product_id DESC")->fetchAll();
}

/**
 * 4. Finds a specific product
 */
function product_find(int $id): ?array {
    $stmt = db()->prepare("SELECT * FROM products WHERE product_id = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetch() ?: null;
}

/**
 * 5. Deletes a product
 */
function product_delete(int $id): void {
    $stmt = db()->prepare("DELETE FROM products WHERE product_id = :id");
    $stmt->execute(['id' => $id]);
}