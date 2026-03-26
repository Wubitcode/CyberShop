<?php
declare(strict_types=1);

require_once __DIR__ . '/../app/config.php';
require_once __DIR__ . '/../app/auth.php';
require_once __DIR__ . '/../app/helpers.php';

require_admin();

$title = "Cyber Intelligence | Security Hub";
$user = current_user();

// Mock Security Data for these capston  Presentation
$threatsDetected = 0;
$failedLogins = 4;
$lastBackup = "2026-03-24 04:00 AM";
$firewallStatus = "ACTIVE";

include __DIR__ . '/../app/partials/header.php';
?>

<style>
    body, html { margin: 0 !important; padding: 0 !important; background-color: #000 !important; overflow-x: hidden; }
    .container, .container-fluid { padding: 0 !important; margin: 0 !important; max-width: 100% !important; }
</style>

<link rel="stylesheet" href="/cybershop/assets/css/admin-theme.css">

<div class="admin-wrapper">
    <?php include __DIR__ . '/../app/partials/admin_sidebar.php'; ?>

    <main class="main-terminal">
        <header class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-0 text-white">SECURITY HUB: THREAT MONITOR</h4>
                <small class="text-cyan"><i class="bi bi-shield-shaded"></i> Continuous Monitoring Active</small>
            </div>
            <div class="text-end">
                <span class="badge bg-success bg-opacity-10 text-success border border-success">SSL_VERIFIED</span>
            </div>
        </header>

        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="cyber-card border-<?= ($threatsDetected > 0) ? 'danger' : 'success' ?>">
                    <div class="stat-label">Active Threats</div>
                    <div class="stat-value <?= ($threatsDetected > 0) ? 'text-danger' : 'text-success' ?>">
                        <?= $threatsDetected ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="cyber-card">
                    <div class="stat-label">Blocked Intrusions</div>
                    <div class="stat-value text-info">128</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="cyber-card">
                    <div class="stat-label">Firewall Status</div>
                    <div class="stat-value text-success">SHIELD_UP</div>
                </div>
            </div>
        </div>

        <div class="cyber-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h6 class="fw-bold m-0">ACCESS LOGS (LIVE)</h6>
                <button class="btn btn-sm btn-outline-danger">PURGE LOGS</button>
            </div>
            <div class="table-responsive">
                <table class="table-terminal">
                    <thead>
                        <tr>
                            <th>TIMESTAMP</th>
                            <th>IP_ADDRESS</th>
                            <th>ACTION</th>
                            <th>STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-dim">2026-03-25 12:45</td>
                            <td class="fw-bold">192.168.1.1</td>
                            <td>ADMIN_LOGIN</td>
                            <td><span class="text-success small">AUTHORIZED</span></td>
                        </tr>
                        <tr>
                            <td class="text-dim">2026-03-25 11:20</td>
                            <td class="fw-bold">45.23.11.89</td>
                            <td>SQL_INJECTION_ATTEMPT</td>
                            <td><span class="text-danger small">BLOCKED</span></td>
                        </tr>
                        <tr>
                            <td class="text-dim">2026-03-25 09:15</td>
                            <td class="fw-bold">102.14.0.22</td>
                            <td>BRUTE_FORCE_GUESS</td>
                            <td><span class="text-warning small">LOCKED_OUT</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<?php include __DIR__ . '/../app/partials/footer.php'; ?>