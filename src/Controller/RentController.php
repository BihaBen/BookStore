<?php

# Irányítások
# Nekem a __DIR__ itt van: C:\xampp\htdocs\BOOKSTORE\src\Controller
# A __DIR__ magára utal, melyből "/../" jellel visszalépkedek és elnavigálok a kívánt fájlhoz.
require_once __DIR__ . '/..//../Database/BookStoreDatabase.php';
require_once __DIR__ . '/../Model/Rental.php';
require_once __DIR__ . '/../Repository/RentRepository.php';
require_once __DIR__ . '/../Repository/BookRepository.php';

class RentController
{
    # Létesít egy adatbázis kapcsolatot és elvezet a Repo-ba, ahol a lekérdezés megtörténik.
    public function SubmitRent(): void
    {
        # Csatlakozás az adatbázishoz.
        $pdo = Database::connect();

        # RentRepository példány készítés és DB lekérdezés.
        $rentRepo = new RentRepository($pdo);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            # Átvesszük az isbn számot.
            $isbn = $_POST['isbn'] ?? '';
            try {
                # Megpróbáljuk ezzel az isbn számmal és a userrel kikölcsönöztetni a könyvet.
                $rentRepo->rentByIsbn((int) $_SESSION['user_id'], $isbn);

                # Ha sikerül, akkor visszatérünk a könyvmegjelenítő oldalra.
                header('Location: index.php?action=booksDisplay');
                exit;


                #Ha nem sikerül, akkor hibakezelés.
            } catch (RuntimeException $e) {
                $error = $e->getMessage();
            }

        }

        # Visszaadjuk az eredményt.
        require __DIR__ . '/../../views/rent.php';
    }

    # Az összes aktív kölcsönzött könyv megjelenítése.
    public function DisplayGiveBackBooks(): void
    {
        # Csatlakozás az adatbázishoz.
        $pdo = Database::connect();
        # RentRepository példány készítés és DB lekérdezés.
        $rentRepo = new RentRepository($pdo);

        # Eltárolom a felhasználó id-ját.
        $userId = (int) ($_SESSION['user_id'] ?? 0);

        # Kérek egy array-t a felhasználó összes aktívan kölcsönzött könyvéről.
        $books = $rentRepo->getRentedBooksByUser($userId);

        # Visszaadom a formnak az adatokat.
        require __DIR__ . '/../../views/giveBackDisplay.php';
    }

    # Egy adott visszaadni kívánt könyv megjelenítése
    public function ShowGiveBackBook(string $isbn): void
    {
        # Csatlakozás az adatbázishoz.
        $pdo = Database::connect();
        # RentRepository példány készítés és DB lekérdezés.
        $rentRepo = new RentRepository($pdo);
        # BookRepository példány készítés és DB lekérdezés.
        $bookRepo = new BookRepository($pdo);

        # Eltárolom a felhasználó id-ját.
        $userId = (int) ($_SESSION['user_id'] ?? 0);

        # Hibakezelés, ha a könyv és a felhasználó nem passzolnak.
        if (!$rentRepo->hasRentalByUserAndIsbn($userId, $isbn)) {
            $error = 'Ezt a könyvet nem te kölcsönözted ki, vagy már visszahoztad.';

            # Visszadobjuk arra az oldalra, ahol a visszaadni szükséges könyvek vannak.
            $books = $rentRepo->getRentedBooksByUser($userId);
            require __DIR__ . '/../../views/giveBackDisplay.php';
            return;
        }

        # A könyv, amit vissza szeretnénk adni.
        $book = $bookRepo->findByIsbn($isbn);
        require __DIR__ . '/../../views/rentGiveBackDisplay.php';
    }

    # A könyv visszaadása:
    public function SubmitGiveBack(): void
    {
        # Létesítek egy adatbázis kapcsolatot.
        $pdo = Database::connect();
        # Példányosítok egy RentRepository-t és átpasszolom az adatbázis kapcsolatot.
        $rentRepo = new RentRepository($pdo);
        
        # User_id kiolvasása
        $user_id = (int) ($_SESSION['user_id'] ?? 0);

        # Ez egy POST kérés volt -> felhasználó kattintott, hogy visszaadja a könyvet.
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            # Az adott könyvnek kiolvasom az ISBN számát.
            $isbn = $_POST['isbn'] ?? '';
            try {
                # Törlöm a kölcsönzést az adatbázisból.
                $rentRepo->giveBackByIsbn($user_id, $isbn);

                # Vissza térek a kölcsönzött könyveim listájához és kilépek.
                header('Location: index.php?action=giveBackDisplay');
                exit;
            } catch (RuntimeException $e) {
                $error = $e->getMessage();
            }
        }

        # Frissítem a felhasználó kikölcsönzött könyveit.
        $books = $rentRepo->getRentedBooksByUser($user_id);
        require __DIR__ . '/../../views/giveBackDisplay.php';
    }

}