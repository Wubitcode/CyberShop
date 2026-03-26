<?php
declare(strict_types=1);

require_once __DIR__ . '/../db.php';

/**
 * Finds a user by email using your DB column 'email'
 */
function user_find_by_email(string $email): ?array {
    $stmt = db()->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
    $stmt->execute([$email]);
    $user = $stmt->fetch(); // Fetch mode is already set to ASSOC in db.php
    return $user ?: null;
}

/**
 * Finds a user by ID using your DB column 'user_id'
 */
function user_find(int $id): ?array {
    $stmt = db()->prepare("SELECT * FROM users WHERE user_id = ? LIMIT 1");
    $stmt->execute([$id]);
    $row = $stmt->fetch();
    return $row ?: null;
}

/**
 * Creates a user matching your DB columns: name, email, password, role
 */
function user_create(string $name, string $email, string $password, string $role = 'user'): int {
    $hash = password_hash($password, PASSWORD_DEFAULT);
    
    // Using your exact DB columns: name, email, password, role
    $stmt = db()->prepare("
        INSERT INTO users (name, email, password, role)
        VALUES (:name, :email, :password, :role)
    ");
    
    $stmt->execute([
        ':name'     => $name,
        ':email'    => $email,
        ':password' => $hash,
        ':role'     => $role,
    ]);
    
    return (int)db()->lastInsertId();
}