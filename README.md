# BookStore

## public/
### index.php
- Router: ide futnak be a formok action-jei és innen irányítódnak Controller -> Repository-ba.
### css/book_style
- A könyvekkel kapcsolatos css stílus.
### css/style
- A bejelentkezés és regisztrációval kapcsolatos stílusok.

## Database
### BookStoreDatabase.php
- A feladat megoldásához xampp Apache és MySql modulokat alkalmaztam.
- Az adatbázis kapcsolat ebben a fájlban van Database statikus osztályban definiálva.
- Az adatbázis neve: "bookStore_db"
- Singleton pattern: self::$conn => Az osztályból csak egyetlen példány létezik.
### Schema.sql
- A fájl a kapott adatbázis szerkezetet tartalmazza isAdmin attributummal kiegészítve. (Ezt sajnos nem tudtam elkészíteni.)

## src/
### Model/
#### User
- A felhasználók osztálya: mezők, konstruktor, validáció, getterek.
#### Book
- A könyvek osztálya: mezők, konstruktor, getterek (weblapnál ebből írom ki).
#### Rental
- A kölcsönzések osztálya: mezők, konstruktor.
### Controller/
#### UserController.php
- Login és Register -> A nézetekből átveszi az adatot és ellenőrzi azokat, ha minden rendben, akkor tovább küldi a repositorynak.
#### BookController.php
- Hasonlóan.
#### RentController.php
- Hasonlóan.

### Repository/
#### UserRepository
- Átveszi az adatokat a Controllerből, továbbá átveszi az adatbázis kapcsolatot is.
- Feladata kommunikáció az adatbázissal és annak manipulációja a feladat mentén.
- Validációkat végezni az adatbázis tartalmával kapcsolatban.
#### BookRepository
- Hasonlóan.
#### RentRepository
- Hasonlóan.

## test/
### test_DPO_connection.php
- Kiírattam a MySQL adatbázisban lévő táblákat, hogy ellenőrizzem a helyes kapcsolatot.
- Singleton pattern teszt: Kiírattam a csatlakozások ID-ját. Így megnéztem, hogy egy újabb csatlakozásnál nem-e jön létre egy új példány.

## views/
### login.php
-Itt található a bejelentkezési felület.
### register.php
- Itt található a regisztrációs felület.
### booksDisplay.php
- Itt listázódnak ki a könyvek, és itt lehet keresni cím alapján. (Csak az elérhető könyvek látszanak).
### rent.php
- Ezen a kis felületen lehet kikölcsönözni egy könyvet.
### giveBackDisplay.php
- Webfelület a kikölcsönzött könyvek listázására.
### rentGiveBackDisplay.php
- Ezen a kis felületen lehet visszaadni egy kikölcsönzött könyvet.

