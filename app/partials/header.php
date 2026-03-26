<?php

//declare(strict_types=1);
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../helpers.php';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($title ?? "CyberShop") ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center fw-bold" href="<?= BASE_URL ?>/public/index.php">
      <img src="<?= BASE_URL ?>/assets/images/cyberShoplogo.png" alt="CyberShop Logo" height="40" style="margin-right:10px;">
      <span>CyberShop</span>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navMain">
      <ul class="navbar-nav ms-auto gap-2">
        <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/public/index.php">Shop</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/public/cart.php"><i class="bi bi-cart3"></i> Cart</a></li>
        <?php if (is_logged_in()): ?>
          <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/public/orders.php"><i class="bi bi-receipt"></i> My Orders</a></li>
          <?php if (is_admin()): ?>
            <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/admin/dashboard.php"><i class="bi bi-speedometer2"></i> Admin</a></li>
          <?php endif; ?>
          <li class="nav-item"><a class="btn btn-outline-light btn-sm" href="<?= BASE_URL ?>/public/logout.php">Logout</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="btn btn-outline-light btn-sm" href="<?= BASE_URL ?>/public/login.php">Sign in</a></li>
          <li class="nav-item"><a class="btn btn-primary btn-sm" href="<?= BASE_URL ?>/public/register.php">Register</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<div class="container py-4">
  <?php
if (isset($_SESSION['user'])) {
    echo "<pre>";
    
    echo "</pre>";
}
?>
