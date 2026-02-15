<?php

# Irányítások
# Nekem a __DIR__ itt van: C:\xampp\htdocs\BOOKSTORE\src\Controller
# A __DIR__ magára utal, melyből "/../" jellel visszalépkedek és elnavigálok a kívánt fájlhoz.
require_once __DIR__ . '/..//../Database/BookStoreDatabase.php';
require_once __DIR__ . '/../Model/Book.php';
require_once __DIR__ . '/../Repository/BookRepository.php';

class BookController
{
    # Létesít egy adatbázis kapcsolatot és elvezet a Repo-ba, ahol a lekérdezés megtörténik.
    public function DisplayAllBooks(): void
    {
        # Csatlakozás az adatbázishoz.
        $pdo = Database::connect();

        # BookRepository példány készítés és DB lekérdezés.
        $bookRepo = new BookRepository($pdo);
        $books = $bookRepo->getBackAllBooks();

        # Maradunk ezen az oldalon.
        require __DIR__ . '/../../views/booksDisplay.php';
    }

    # A keresőmező segítségével keresni lehet a könyvek között
    public function DisplayTheSearchedBooks(): void
    {
        # Ha a keresőmezőben le lett ütve az enter, azaz be lett adva a keresés, akkor:
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            # Eltárolom a keresési feltéttelt.
            $searchbarInput = $_POST['searchbar'] ?? '';

            # Csatlakozás az adatbázishoz.
            $pdo = Database::connect();

            # BookRepository példány készítés és DB lekérdezés.
            $bookRepo = new BookRepository($pdo);

            # A keresett könyvek listájának lekérése
            $books = $bookRepo->getBackTheMatchedBooks($searchbarInput);

        }
        # Maradunk ezen az oldalon.
        require __DIR__ . '/../../views/booksDisplay.php';
    }


}