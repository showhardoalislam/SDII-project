
<?php
require 'includes/bootstrap.php';

if (me()) {
    go(me()['role'] === 'admin' ? 'admin/index.php' : 'dashboard.php');
}

$err = [];
$name = '';
$email = '';
$sid = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    check_csrf();

    $name = trim($_POST['name'] ?? '');
    $email = strtolower(trim($_POST['email'] ?? ''));
    $sid = trim($_POST['student_id'] ?? '');
    $pass = $_POST['password'] ?? '';

    if (strlen($name) < 2) {
        $err[] = 'Enter your full name.';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $err[] = 'Enter a valid email.';
    }

    if (strlen($pass) < 8) {
        $err[] = 'Password must be at least 8 characters.';
    }

    if (empty($err)) {
        try {
            $s = db()->prepare(
                "INSERT INTO users
                (name, email, student_id, password_hash)
                VALUES (?, ?, ?, ?)"
            );

            $s->execute([
                $name,
                $email,
                $sid !== '' ? $sid : null,
                password_hash($pass, PASSWORD_DEFAULT)
            ]);

            flash('Account created. Please sign in.');
            go('login.php');

        } catch (PDOException $e) {
            if ($e->getCode() === '23000') {
                $err[] = 'Email or student ID already exists.';
            } else {
                $err[] = 'Database error: ' . $e->getMessage();
            }
        }
    }
}

$pageTitle = 'Register';
require 'includes/header.php';
?>

<div class="form-wrap">
    <div class="form-card">
        <span class="eyebrow">JOIN THE PORTAL</span>

        <h1>Create your account</h1>
        <p>Register to submit and track student queries.</p>

        <?php foreach ($err as $x): ?>
            <div class="alert error">
                <?= e($x) ?>
            </div>
        <?php endforeach; ?>

        <form method="post">
            <input type="hidden" name="csrf" value="<?= e(csrf()) ?>">

            <div class="field">
                <label>Full name *</label>
                <input
                    name="name"
                    required
                    minlength="2"
                    maxlength="100"
                    value="<?= e($name) ?>"
                >
            </div>

            <div class="field">
                <label>Student ID (optional)</label>
                <input
                    name="student_id"
                    maxlength="50"
                    value="<?= e($sid) ?>"
                >
            </div>

            <div class="field">
                <label>Email *</label>
                <input
                    type="email"
                    name="email"
                    required
                    value="<?= e($email) ?>"
                >
            </div>

            <div class="field">
                <label>Password (minimum 8 characters) *</label>
                <input
                    type="password"
                    name="password"
                    required
                    minlength="8"
                >
            </div>

            <button type="submit" class="btn primary submit">
                Create account
            </button>
        </form>

        <p>
            Already registered?
            <a href="login.php">Sign in</a>
        </p>
    </div>
</div>

<?php require 'includes/footer.php'; ?>
