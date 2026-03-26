<?php
declare(strict_types=1);
require_once __DIR__ . '/../app/auth.php';
require_once __DIR__ . '/../app/helpers.php';
require_once __DIR__ . '/../app/repos/users_repo.php';

if (is_logged_in()) {
    header("Location: " . BASE_URL . "/public/index.php");
    exit;
}

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = trim($_POST['fullName'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = (string)($_POST['password'] ?? '');

    if ($fullName === '' || $email === '' || $password === '') {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email.";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters.";
    } elseif (user_find_by_email($email)) {
        $error = "Email already registered.";
    } else {
        $id = user_create($fullName, $email, $password, 'user');
        $u = user_find($id);
        login_user($u);
        header("Location: " . BASE_URL . "/public/index.php");
        exit;
    }
}

$title = "Register";
include __DIR__ . '/../app/partials/header.php';
?>

<div class="row justify-content-center">
  <div class="col-md-6 col-lg-5">
    <div class="card shadow-sm">
      <div class="card-body">
        <h1 class="h4 mb-3"><i class="bi bi-person-plus"></i> Create account</h1>
        <?php if ($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>
        <form method="post">
          <div class="mb-3">
            <label class="form-label">Full name</label>
            <input class="form-control" name="fullName" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input class="form-control" name="email" type="email" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input class="form-control" name="password" type="password" minlength="6" required>
          </div>
          <button class="btn btn-primary w-100" type="submit">Register</button>
          <div class="text-center mt-3">
            <a href="<?= BASE_URL ?>/public/login.php">Already have an account?</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include __DIR__ . '/../app/partials/footer.php'; ?>
