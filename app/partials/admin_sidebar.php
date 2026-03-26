<?php
declare(strict_types=1);

/**
 * SIDEBAR LOGIC
 * $current checks the filename for simple pages.
 * strpos checks the URI for folders (Products/Orders) so sub-pages stay active.
 */
$current = basename($_SERVER['PHP_SELF']); 
$uri = $_SERVER['REQUEST_URI'];
?>

<nav class="sidebar">
    <!-- 1. SYSTEM NODE IDENTIFIER (Replaces redundant Brand Name) -->
    <div class="sidebar-brand d-flex align-items-center justify-content-between">
        <span><i class="bi bi-terminal-split me-2 text-cyan"></i>NODE_01_ADMIN</span>
        <span class="badge bg-success bg-opacity-10 text-success border border-success x-small" style="font-size: 0.55rem;">ENCRYPTED</span>
    </div>
    
    <!-- 2. OPERATOR IDENTITY -->
    <div class="px-4 py-3 border-bottom border-secondary border-opacity-25 mb-2" style="background: rgba(0,210,255,0.02);">
        <div class="small text-muted text-uppercase mb-1" style="font-size: 0.6rem; letter-spacing: 1px;">Active_Operator</div>
        <div class="fw-bold text-white small"><?= e(strtoupper($user['fullName'] ?? 'ROOT_USER')) ?></div>
        <div class="text-success fw-bold" style="font-size: 0.65rem;">
            <span class="dot-online"></span> SESSION_SECURE
        </div>
    </div>

    <!-- 3. CORE COMMAND LINKS -->
    <div class="nav-label">Core_Control</div>
    
    <a href="/cybershop/admin/dashboard.php" 
       class="nav-link-custom <?= ($current == 'dashboard.php') ? 'active' : '' ?>">
        <i class="bi bi-grid-1x2"></i> DASHBOARD
    </a>
    
    <a href="/cybershop/admin/products/index.php" 
       class="nav-link-custom <?= (strpos($uri, 'products') !== false) ? 'active' : '' ?>">
        <i class="bi bi-cpu"></i> INVENTORY
    </a>
    
    <a href="/cybershop/admin/orders/index.php" 
       class="nav-link-custom <?= (strpos($uri, 'orders') !== false) ? 'active' : '' ?>">
        <i class="bi bi-shield-check"></i> ORDERS
    </a>

    <!-- 4. SECURITY & SYSTEM -->
    <div class="nav-label">Security_Layer</div>
    
    <a href="/cybershop/admin/security.php" 
       class="nav-link-custom <?= ($current == 'security.php') ? 'active' : '' ?>">
        <i class="bi bi-radar"></i> THREAT_DETECTION
    </a>

    <a href="/cybershop/admin/settings.php" 
       class="nav-link-custom <?= ($current == 'settings.php') ? 'active' : '' ?>">
        <i class="bi bi-sliders"></i> SETTINGS
    </a>

    <!-- 5. TERMINATE ACCESS -->
    <div class="mt-auto border-top border-secondary border-opacity-25">
        <a href="/cybershop/public/logout.php" class="nav-link-custom text-danger fw-bold py-3">
            <i class="bi bi-lock-fill me-2"></i> DEAUTHORIZE
        </a>
    </div>
</nav>

<style>
    /* Prevent sidebar text from spilling out */
    .sidebar {
        width: 250px;
        background: #080a0c;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        border-right: 1px solid rgba(255,255,255,0.05);
        overflow: hidden;
    }

    .sidebar-brand {
        padding: 1.5rem;
        background: rgba(0,0,0,0.2);
        color: #fff;
        font-family: 'Monaco', 'Consolas', monospace;
        font-size: 0.85rem;
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }

    .nav-label {
        padding: 1.5rem 1.5rem 0.5rem;
        color: #444;
        font-size: 0.65rem;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-weight: 800;
    }

    .nav-link-custom {
        padding: 0.75rem 1.5rem;
        display: flex;
        align-items: center;
        color: #888;
        text-decoration: none;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
        transition: all 0.2s;
    }

    .nav-link-custom i {
        margin-right: 12px;
        font-size: 1.1rem;
    }

    .nav-link-custom:hover {
        color: #fff;
        background: rgba(255,255,255,0.02);
    }

    .nav-link-custom.active {
        color: #00d2ff;
        background: rgba(0, 210, 255, 0.05);
        border-right: 3px solid #00d2ff;
        font-weight: bold;
    }

    .dot-online {
        height: 6px;
        width: 6px;
        background-color: #00d25b;
        border-radius: 50%;
        display: inline-block;
        margin-right: 5px;
        box-shadow: 0 0 8px #00d25b;
    }
</style>