<?php
declare(strict_types=1);
session_start();
require_once __DIR__ . '/../src/Controller/UserController.php';
require_once __DIR__ . '/../src/Controller/BookController.php';

$action = $_GET['action'] ?? 'home';

switch ($action) {
    case 'login':
        (new UserController())->Login();
        break;

    case 'register':
        (new UserController())->Register();
        break;

    case 'rent':
        (new BookController())->Read();
        break;

    default:
        echo "Home page";
}