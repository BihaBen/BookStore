<?php
declare(strict_types=1);
session_start();
require_once __DIR__ . '/../src/Controller/UserController.php';
require_once __DIR__ . '/../src/Controller/BookController.php';
require_once __DIR__ . '/../src/Controller/RentController.php';

$action = $_GET['action'] ?? 'home';

# Szétvágom az $action-t és kiszedem belőle a: valódi $action-t és az isbn számot.
# Ez az isbn szám kiolvasása miatt kell, hogy tudjam
if (strpos($action, "_") == true){
    $isbnNumber= explode("_",$action)[1];
    $action= explode("_",$action)[0];
};


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
    # Könyv keresése
    case 'search':
        (new BookController())->DisplayTheSearchedBooks();
        break;
    # Kölcsönözni kivánt könyv megmutatása
    case 'rentShow':
        (new BookController())->ShowActBook((string)$isbnNumber);
        break;
    # Könyv foglalása
    case 'rent':
        (new RentController())->SubmitRent();
        break;

    default:
        echo "Home page";
}