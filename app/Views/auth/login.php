<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Job Fair System</title>
</head>
<body>
    <h2>Login</h2>

    <?php if (session()->getFlashdata('success')): ?>
        <p style="color: green;"><?= session()->getFlashdata('success') ?></p>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <p style="color: red;"><?= session()->getFlashdata('error') ?></p>
    <?php endif; ?>

    <form action="<?= base_url('login') ?>" method="post">
        <?= csrf_field() ?>

        <label>Username:</label><br>
        <input type="text" name="username" value="<?= old('username') ?>" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit">Sign In</button>
    </form>

    <p>Need an account? <a href="<?= base_url('register') ?>">Register here</a></p>
</body>
</html>