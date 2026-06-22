<?php
$hash = '';
$pass = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pass = $_POST['password'] ?? '';

    if ($pass !== '') {
        $hash = password_hash($pass, PASSWORD_DEFAULT);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Generador de Hash PHP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
        }
        .container {
            width: 400px;
            margin: 60px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
        }
        input, button, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
        }
        textarea {
            height: 80px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Generador de Hash (password_hash)</h2>

    <form method="POST">
        <label>Texto o contraseña:</label>
        <input type="text" name="password" value="<?= htmlspecialchars($pass) ?>" required>

        <button type="submit">Generar Hash</button>
    </form>

    <?php if ($hash): ?>
        <label>Hash generado:</label>
        <textarea readonly><?= $hash ?></textarea>
    <?php endif; ?>
</div>

</body>
</html>