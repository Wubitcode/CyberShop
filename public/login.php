<?php
declare(strict_types=1);

// 1. Dependencies
require_once __DIR__ . '/../app/config.php';
require_once __DIR__ . '/../app/auth.php'; // session_start() is already inside auth.php
require_once __DIR__ . '/../app/helpers.php';
require_once __DIR__ . '/../app/repos/users_repo.php';

// 2. Redirect if already logged in
if (is_logged_in()) {
    $user = current_user();
    $target = ($user['role'] === 'admin') ? "/admin/dashboard.php" : "/public/index.php";
    header("Location: " . BASE_URL . $target);
    exit;
}

$error = null;

// 3. Process Login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = (string)$_POST['password'];

    $u = user_find_by_email($email);

    if ($u && password_verify($password, $u['password'])) {
        // This calls the function in auth.php that now includes the System Log!
        login_user($u);

        $target = ($u['role'] === 'admin') ? "/admin/dashboard.php" : "/public/index.php";
        header("Location: " . BASE_URL . $target);
        exit;
    } else {
        $error = "Access Denied: Invalid Credentials.";
    }
}

$title = "CyberShop | Secure Gateway";
include __DIR__ . '/../app/partials/header.php';
?>

<style>
    body { background-color: #000000 !important; color: #ffffff; }
    .login-card { 
        background: #191C24; 
        border: none; 
        border-radius: 8px; 
        box-shadow: 0 10px 30px rgba(0,0,0,0.5);
    }
    .form-control { 
        background-color: #2A3038 !important; 
        border: 1px solid #2c2e33 !important; 
        color: white !important;
    }
    .form-control:focus { border-color: #AF1763 !important; box-shadow: none; }
    .btn-cyber { background-color: #AF1763; border: none; color: white; font-weight: bold; }
    .btn-cyber:hover { background-color: #8a124e; color: white; }
    .text-magenta { color: #AF1763; }
</style>

<div class="container d-flex align-items-center justify-content-center" style="min-height: 80vh;">
    <div class="col-md-5">
        <div class="card login-card p-4">
            <div class="card-body">
                <div class="text-center mb-4">
                    <h2 class="fw-bold text-magenta"><i class="bi bi-shield-lock"></i> CYBERSHOP</h2>
                    <p class="text-muted small text-uppercase">Secure Terminal Access</p>
                </div>

                <?php if ($error): ?>
                    <div class="alert alert-danger py-2 small border-0" style="background: rgba(255,0,0,0.1); color: #ff6666;">
                        <i class="bi bi-exclamation-triangle"></i> <?= e($error) ?>
                    </div>
                <?php endif; ?>

                <form method="post">
                    <div class="mb-3">
                        <label class="form-label text-muted small">Identification (Email)</label>
                        <input class="form-control form-control-lg" name="email" type="email" required placeholder="name@example.com">
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-muted small">Verification (Password)</label>
                        <input class="form-control form-control-lg" name="password" type="password" required placeholder="••••••••">
                    </div>
                    <button class="btn btn-cyber btn-lg w-100 mb-3" type="submit">INITIALIZE SESSION</button>
                    
                    <div class="text-center">
                        <span class="text-muted small">New Operator?</span> 
                        <a href="<?= BASE_URL ?>/public/register.php" class="text-info text-decoration-none small ms-1">Register Assets</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../app/partials/footer.php'; ?>