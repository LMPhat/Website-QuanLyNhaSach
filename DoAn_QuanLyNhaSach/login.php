<?php
$title = 'Login page';
require 'class/Database.php';
require 'class/Auth.php';

session_start();

$db = new Database();
$pdo = $db->getConnect();

$error = '';

$username = '';
$password = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $error = Auth::login($pdo, $username, $password);
}
?>

<?php require 'inc/header.php'; ?>

<div class="container text-center d-flex align-items-center min-vh-100">
    <div class="card mx-auto bg-info py-5" style="width: 25rem;">
        <h1>Login</h1>
        <div class="card-body">
            <form method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary" name="login">Login</button>
            </form>
            <p>Need a new accout?<a href="register.php"> Sign Up</a></p>
        </div>
        <?php if ($error): ?>
            <div class="card-footer">
                <p class="text-danger"><?= $error ?></p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require 'inc/footer.php'; ?>