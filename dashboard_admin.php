<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}
$adminName = $_SESSION['user']['name'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            background: linear-gradient(to right, #f0f2f5, #e0f7fa);
            display: flex;
            flex-direction: column;
            height: 100vh;
        }
        header {
            background-color: #4CAF50;
            color: white;
            padding: 20px 30px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
        }
        main {
            flex: 1;
            padding: 40px;
            text-align: center;
        }
        .welcome {
            font-size: 20px;
            margin-bottom: 20px;
            color: #333;
        }
        .button-logout {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #e53935;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        .button-logout:hover {
            background-color: #c62828;
        }
    </style>
</head>
<body>

<header>
    Dashboard Admin
</header>

<main>
    <div class="welcome">Selamat datang, <strong><?= htmlspecialchars($adminName) ?></strong>!</div>

    <p>Ini adalah halaman dashboard khusus admin. Anda bisa menambahkan fitur manajemen data di sini.</p>

    <form method="POST" action="logout.php">
        <button class="button-logout" type="submit">Logout</button>
    </form>
</main>

</body>
</html>
