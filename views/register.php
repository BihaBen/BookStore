<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="/BOOKSTORE/public/css/style.css">
</head>

<body>
    <div class="panel">
        <h2>Regisztráció</h2>

        <?php if (!empty($error)): ?>
            <p style="color:red; text-align:left;">
                <?= htmlspecialchars($error) ?>
            </p>
        <?php endif; ?>

        <form method="POST" action="?action=register">
            <label for="username">Felhasználónév: (min. 3, max. 50 karakter)</label>
            <input type="text" name="username" placeholder="Példa: TesztJakab" required>

            <label for="email">Email cím: (létező email cím)</label>
            <input type="email" name="email" placeholder="Példa: tesztElek@kitalalt.hu" required>

            <label for="password">Jelszó: (min. 8 karakter: kis és nagybetű + szám)</label>
            <input type="password" name="password" placeholder="Példa: PeldaJelszo1" required>

            <label for="password">Jelszó: még egyszer</label>
            <input type="password" name="password2" placeholder="Példa: PeldaJelszo1" required>

            <!--SUBMIT: POST alapú jel.-->
            <button type="submit">Regisztráció</button>
            <button type="button"  onclick=window.history.back(1)>Vissza</button>
        </form>
    </div>

</body>

</html>