<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Job Fair System</title>
</head>
<body>
    <h2>Create Account</h2>

    <?php if (session()->getFlashdata('errors')): ?>
        <div style="color: red;">
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('register') ?>" method="post">
        <?= csrf_field() ?>
        
        <label>Display Name:</label><br>
        <input type="text" name="display_name" value="<?= old('display_name') ?>" required><br><br>

        <label>Username:</label><br>
        <input type="text" name="username" value="<?= old('username') ?>" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" value="<?= old('email') ?>" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <label>Role:</label><br>
        <select name="role">
            <option value="User" <?= old('role', 'User') === 'User' ? 'selected' : '' ?>>User</option>
            <option value="Field Office Staff" <?= old('role') === 'Field Office Staff' ? 'selected' : '' ?>>Field Office Staff</option>
            <option value="LGU / PESO" <?= old('role') === 'LGU / PESO' ? 'selected' : '' ?>>LGU / PESO</option>
        </select><br><br>

        <label>Assignment / Office:</label><br>
        <input type="text" name="assignment" value="<?= old('assignment') ?>"><br><br>

        <label>Address:</label><br>
        <input type="text" name="address" value="<?= old('address') ?>"><br><br>

        <button type="submit">Register Account</button>
    </form>

    <p>Already have an account? <a href="<?= base_url('login') ?>">Login here</a></p>
</body>
</html>