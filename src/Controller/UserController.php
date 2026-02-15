<?php

# Irányítások
# Nekem a __DIR__ itt van: C:\xampp\htdocs\BOOKSTORE\src\Controller
# A __DIR__ magára utal, melyből "/../" jellel visszalépkedek és elnavigálok a kívánt fájlhoz.
require_once __DIR__ . '/..//../Database/BookStoreDatabase.php';
require_once __DIR__ . '/../Model/User.php';
require_once __DIR__ . '/../Repository/UserRepository.php';

# mezők nélküli osztály a login és register metódusok elvégzéséhez.
class UserController
{
    public function Login(): void
    {
        # Ha hiba történik, akkor ide rakom a felhívást.
        $error = null;

        # A login felület (weboldalon) ha megindul a POST, akkor:
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            # Ellenőrzöm, hogy az adatmezők ki lettek-e töltve és eltárolom. (ezeket már vizsgáltam).
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            # A Model/User.php-ban definiált módszerekkel ellenőrzök:
            try {
                # Amit beírt az adatmezőbe újonnan az helyes?
                $email = User::validateEmail($email);

                # Adatbázishoz kapcsolódás.
                $pdo = Database::connect();

                # Példányosítok egy UserRepository-t és átpasszolom az adatbázis kapcsolatot.
                $repo = new UserRepository($pdo);

                # Lekérem a User adatait array-ben email alapján.
                $row = $repo->findByEmail($email);

                # Ellenőrzöm, hogy a beírt email cím létezik-e. -> LOGIN: szval kell, hogy létezzen, vagy elgépelt vagy force.
                if ($row === null) {
                    throw new RuntimeException('Nincs ilyen email című felhasználó.');
                }

                # Ellenőrzöm, hogy a tárolt jelszó(hashelt) és a beírt egyeznek-e közös alakra hozva.
                if (!password_verify($password, $row['password'])) {
                    throw new RuntimeException('Hibás jelszó.');
                }

                # Még nem fut a session: !== PHP_SESSION_ACTIVE, akkor indítsuk el.
                if (session_status() !== PHP_SESSION_ACTIVE) {
                    session_start();
                }

                # A session-t feltöltöm az arrayből kiszedett adatokkal.
                $_SESSION['user_id'] = (int) $row['id'];
                $_SESSION['username'] = (string) $row['username'];
                $_SESSION['isAdmin'] = (bool) $row['isAdmin'];

                # Ha sikeres belépés történt, akkor menjünk át a könyves oldalra.
                header('Location: /BOOKSTORE/public/index.php?action=booksDisplay');
                exit;

            # Ha nem jutunk át, akkor valami hiba történt.
            } catch (Throwable $e) {
                $error = $e->getMessage();
            }
        }

        # Ha csak megnyitom az oldalt és a try catch rész kimarad.
        require __DIR__ . '/../../views/login.php';
    }

    public function Register(): void
    {
        # Ha hiba történik, akkor ide rakom a felhívást.
        $error = null;

        # A register felület (weboldalon) ha megindul a POST, akkor:
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            # Eltárolom változókban a regisztrációs felület mezőinek értékeit.
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $passwordAgain = $_POST['password2'] ?? '';


            try {
                # Létesítek egy adatbázis kapcsolatot.
                $pdo = Database::connect();

                # Példányosítok egy UserRepository-t és átpasszolom az adatbázis kapcsolatot.
                $repo = new UserRepository($pdo);

                ## Van-e már ilyen nevű felhasználó?
                if ($repo->existsByUsername(trim($username))) {
                    throw new RuntimeException('Ez a felhasználónév már foglalt.');
                }

                ## Van-e már ilyen email cím regisztrálva?
                if ($repo->existsByEmail(trim($email))) {
                    throw new RuntimeException('Ezzel az email címmel már létezik fiók.');
                }

                # Feltöltöm a User-t a saját metódusával (Itt ellenőrzöm, hogy helyes adatokat adott meg - Ha nem akkor hibakezelés és tájékoztatás)
                $user = User::register($username, $email, $password, $passwordAgain);

                # Létrehozom az adatbázisban is a User-t.
                $newId = $repo->create($user);

                # Ha sikeres regisztráció történt, akkor menjünk át a login oldalra.
                header('Location: /BOOKSTORE/public/index.php?action=login');

            } catch (Throwable $e) {
                # Különben az $error-ban gyűjtjük.
                $error = $e->getMessage();
            }
        }

        # Ha csak megnyitom az oldalt és a try catch rész kimarad.
        require __DIR__ . '/../../views/register.php';
    }
}
