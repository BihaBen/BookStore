<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="/BOOKSTORE/public/css/style.css">
</head>

<body>
    <div class="panel">
        <h2>Bejelentkezés</h2>

        <?php if (!empty($error)): ?>
            <p style="color:red; text-align:left;">
                <?= htmlspecialchars($error) ?>
            </p>
        <?php endif; ?>

        <form method="POST" action="?action=login">
            <input type="email" name="email" placeholder="Email cím" required>
            <input type="password" name="password" placeholder="Jelszó" required>
            <button type="submit">Belépés</button>
        </form>

        <p>Még nem regisztráltál?</p>

        <a href="?action=register" class="register-link">
            Regisztráció
        </a>
    </div>

</body>

</html>