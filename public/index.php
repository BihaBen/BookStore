<?php
declare(strict_types=1);
session_start();
require_once __DIR__ . '/../src/Controller/UserController.php';
require_once __DIR__ . '/../src/Controller/BookController.php';

$action = $_GET['action'] ?? 'home';

# Cselekvést routoló switch
switch ($action) {
    # Belépés
    case 'login':
        (new UserController())->Login();
        break;
    
    # Regisztráció
    case 'register':
        (new UserController())->Register();
        break;
    
    # Könyv megejelítés
    case 'booksDisplay':
        (new BookController())->DisplayAllBooks();
        break;

    default:
        echo "Home page";
}