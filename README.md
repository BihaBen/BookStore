# BookStore
## src/
### Database/schema.sql
- A fájl a kapott adatbázis szerkezetet tartalmazza isAdmin attributummal kiegészítve.
### Database/BookStoreDatabase.php
- A feladat megoldásához xampp Apache és MySql modulokat alkalmaztam.
- Az adatbázis kapcsolat ebben a fájlban van Database statikus osztályban definiálva.
- Az adatbázis neve: "bookStore_db"
- Singleton pattern: self::$conn => Az osztályból csak egyetlen példány létezik.
## test/
### test_DPO_connection.php
- Kiírattam a MySQL adatbázisban lévő táblákat, hogy ellenőrizzem a helyes kapcsolatot.
- Singleton pattern teszt: Kiírattam a csatlakozások ID-ját. Így megnéztem, hogy egy újabb csatlakozásnál nem-e jön létre egy új példány.

### public/

