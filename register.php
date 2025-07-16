<?php
session_start();
include 'config.php';

$errors = [];
$success = '';
$name = '';
$email = '';
$password = '';
$role = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role'];

    if ($name === '') $errors['name'] = "Nama wajib diisi";
    if ($email === '') $errors['email'] = "Email wajib diisi";
    if ($password === '') $errors['password'] = "Password wajib diisi";
    if ($role !== 'admin' && $role !== 'pelanggan') $errors['role'] = "Role tidak valid";

    if (empty($errors)) {
        $check = $db->prepare("SELECT * FROM users WHERE email = ?");
        $check->execute([$email]);

        if ($check->rowCount() > 0) {
            $errors['email'] = "Email sudah digunakan";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $db->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
            $stmt->execute([$name, $email, $hash, $role]);
            $success = "Registrasi berhasil! Silakan <a href='login.php'>login</a>.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Registrasi</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f0f2f5;
            display: flex;
            height: 100vh;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        .box {
            background-color: #ffffff;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        h2 {
            margin-bottom: 20px;
            text-align: center;
            color: #333;
        }

        label {
            display: block;
            margin-top: 10px;
            color: #555;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
        }

        button {
            margin-top: 20px;
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            border: none;
            color: white;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-top: 4px;
        }

        .success {
            background-color: #dff0d8;
            border: 1px solid #d6e9c6;
            color: #3c763d;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 6px;
        }

        p {
            margin-top: 15px;
            text-align: center;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="box">
    <h2>Register</h2>

    <?php if ($success): ?>
        <div class="success"><?= $success ?></div>
    <?php endif; ?>

    <form method="POST">
        <label>Nama:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($name) ?>">
        <?php if (isset($errors['name'])): ?><div class="error"><?= $errors['name'] ?></div><?php endif; ?>

        <label>Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($email) ?>">
        <?php if (isset($errors['email'])): ?><div class="error"><?= $errors['email'] ?></div><?php endif; ?>

        <label>Password:</label>
        <input type="password" name="password">
        <?php if (isset($errors['password'])): ?><div class="error"><?= $errors['password'] ?></div><?php endif; ?>

        <label>Role:</label>
        <select name="role">
            <option value="">-- Pilih --</option>
            <option value="admin" <?= $role == 'admin' ? 'selected' : '' ?>>Admin</option>
            <option value="pelanggan" <?= $role == 'pelanggan' ? 'selected' : '' ?>>Pelanggan</option>
        </select>
        <?php if (isset($errors['role'])): ?><div class="error"><?= $errors['role'] ?></div><?php endif; ?>

        <button type="submit" name="register">Daftar</button>
    </form>

    <p>Sudah punya akun? <a href="login.php">Login</a></p>
</div>
</body>
</html>
