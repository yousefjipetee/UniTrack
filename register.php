<?php

require_once __DIR__ . '/classes/User.php';

$userModel = new User();

$errors = [];
$success = '';

$name = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    if ($name === '') {
        $errors[] = 'Name is required.';
    } elseif (strlen($name) < 3) {
        $errors[] = 'Name must be at least 3 characters.';
    }

    if ($email === '') {
        $errors[] = 'Email is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }

    if ($password === '') {
        $errors[] = 'Password is required.';
    } elseif (strlen($password) < 8) {
        $errors[] = 'Password must be at least 8 characters.';
    }

    if ($password !== $confirmPassword) {
        $errors[] = 'Passwords do not match.';
    }

    if (
        empty($errors) &&
        $userModel->emailExists($email)
    ) {
        $errors[] = 'This email is already registered.';
    }

    if (empty($errors)) {
        if ($userModel->register($name, $email, $password)) {
            $success = 'Account created successfully. You can now login.';

            $name = '';
            $email = '';
        } else {
            $errors[] = 'Something went wrong. Please try again.';
        }
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

    <title>Create Account | UniTrack</title>

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
                Create Account
            </h1>

            <p>
                Join UniTrack University Course Management System
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

        <?php if ($success !== ''): ?>

            <div class="alert alert-success">
                <?= htmlspecialchars($success) ?>
            </div>

        <?php endif; ?>

        <form
            method="POST"
            action=""
            id="registerForm"
            novalidate
        >

            <div class="form-group">

                <label for="name">
                    Full Name
                </label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="<?= htmlspecialchars($name) ?>"
                    minlength="3"
                    required
                    autocomplete="name"
                >

                <small
                    class="field-error"
                    id="nameError"
                ></small>

            </div>

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

                <small
                    class="field-error"
                    id="emailError"
                ></small>

            </div>

            <div class="form-group">

                <label for="password">
                    Password
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    minlength="8"
                    required
                    autocomplete="new-password"
                >

                <small
                    class="field-error"
                    id="passwordError"
                ></small>

            </div>

            <div class="form-group">

                <label for="confirm_password">
                    Confirm Password
                </label>

                <input
                    type="password"
                    id="confirm_password"
                    name="confirm_password"
                    minlength="8"
                    required
                    autocomplete="new-password"
                >

                <small
                    class="field-error"
                    id="confirmPasswordError"
                ></small>

            </div>

            <button
                type="submit"
                class="btn-primary"
            >
                Create Account
            </button>

        </form>

        <p class="auth-footer">

            Already have an account?

            <a href="login.php">
                Login
            </a>

        </p>

    </section>

</main>

<script src="assets/js/auth.js"></script>

</body>

</html>