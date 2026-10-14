<?php

require_once __DIR__ . '/classes/User.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$userModel = new User();

$errors = [];
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '') {
        $errors[] = 'Email is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }

    if ($password === '') {
        $errors[] = 'Password is required.';
    }

    if (empty($errors)) {
        $user = $userModel->login($email, $password);

        if ($user !== null) {
            session_regenerate_id(true);

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = $user['role'];

            if ($user['role'] === 'admin') {
                header('Location: admin/dashboard.php');
                exit;
            }

            header('Location: student/dashboard.php');
            exit;
        }

        $errors[] = 'Invalid email or password.';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Login | UniTrack</title>

    <link
        rel="stylesheet"
        href="assets/css/auth.css"
    >

</head>

<body>

<main class="auth-page">

    <section class="auth-card">

        <div class="auth-header">

            <h1>
                Welcome Back
            </h1>

            <p>
                Login to your UniTrack account
            </p>

        </div>

        <?php if (!empty($errors)): ?>

            <div class="alert alert-error">

                <ul>

                    <?php foreach ($errors as $error): ?>

                        <li>
                            <?= htmlspecialchars($error) ?>
                        </li>

                    <?php endforeach; ?>

                </ul>

            </div>

        <?php endif; ?>

        <form
            method="POST"
            action=""
            id="loginForm"
        >

            <div class="form-group">

                <label for="email">
                    Email Address
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="<?= htmlspecialchars($email) ?>"
                    required
                    autocomplete="email"
                >

            </div>

            <div class="form-group">

                <label for="password">
                    Password
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                    autocomplete="current-password"
                >

            </div>

            <button
                type="submit"
                class="btn-primary"
            >
                Login
            </button>

        </form>

        <p class="auth-footer">

            Don't have an account?

            <a href="register.php">
                Create Account
            </a>

        </p>

    </section>

</main>

</body>

</html>