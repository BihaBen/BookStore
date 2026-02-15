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

##### ELINDÍTÁS #####
1.) Xampp letöltése.
2.) Apache server elindítása.
3.) MySQL adatbázis elindítása.
4.) MySQL admin felület megnyitása.
4.1) Új adatbázis létrehozása: bookstore_db
4.2) Database/schema.sql importálása vagy SQL fülön bemásolás.
4.3) Tesztadatok bemásolása a táblákhoz.

##### ADATBÁZIS tesztadatok #####
INSERT INTO books (title, author, isbn, available) VALUES
('Tüskevár', 'Fekete István', '9789631193651', TRUE),
('Légy jó mindhalálig', 'Móricz Zsigmond', '9789631197482', TRUE),
('A kőszívű ember fiai', 'Jókai Mór', '9789632671189', TRUE),
('Sorstalanság', 'Kertész Imre', '9789631437458', TRUE),
('Esti Kornél', 'Kosztolányi Dezső', '9789631436178', TRUE),
('Pál utcai fiúk – Ifjúsági kiadás', 'Molnár Ferenc', '9789634152457', TRUE),
('Az ajtó', 'Szabó Magda', '9789630799250', TRUE),
('Ida regénye', 'Gárdonyi Géza', '9789632671202', TRUE),
('A Pendragon legenda', 'Szerb Antal', '9789630799441', TRUE),
('Utas és holdvilág', 'Szerb Antal', '9789630798932', TRUE),
('Iskola a határon', 'Ottlik Géza', '9789631437557', TRUE),
('Rokonok', 'Móricz Zsigmond', '9789631437021', TRUE),
('Az arany ember', 'Jókai Mór', '9789632671172', TRUE),
('Száz év magány', 'Gabriel García Márquez', '9789630788841', TRUE),
('A gyertyák csonkig égnek', 'Márai Sándor', '9789632277915', TRUE);

