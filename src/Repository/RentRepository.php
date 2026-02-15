<?php
class RentRepository
{
    # Példányosításnál kapja meg az adatbázis kapcsolatot.
    public function __construct(private PDO $pdo)
    {
    }

    # Egy újabb könyv bérlése, ahol felülírom az adatbázis adatait -> nem elérhető. (kikölcsönözték)
    public function rentByIsbn(int $userId, string $isbn): void
    {
        # Adatbázis tranzakció -> mind lefut vagy egyik sem.
        $this->pdo->beginTransaction();

        try {

            # Ellenőrzöm, hogy hány könyv van az illetőn.
            $activeCount = $this->countActiveRentalsByUser($userId);
            if ($activeCount >= 3) {
                throw new RuntimeException('Maximum 3 db könyvet lehet bérelni.');
            }

            # Adott könyv lekérdezése, lehet, hogy ha sokat tartózkodik a könyv megjelenítőnél, akkor kiveszi más.
            $stmt = $this->pdo->prepare(
                "SELECT id, available 
                 FROM books 
                 WHERE isbn = :isbn 
                 FOR UPDATE"
            );

            # SQL lekérdezés indítása.
            $stmt->execute([
                'isbn' => $isbn
            ]);

            # Eltárolom a könyv adatait.
            $book = $stmt->fetch(PDO::FETCH_ASSOC);

            # Hibakezelések: A könyet nem lehet kivenni.
            if (!$book) {
                throw new RuntimeException('A könyv nem található.');
            }
            if ((int) $book['available'] !== 1) {
                throw new RuntimeException('A könyv jelenleg nem elérhető.');
            }

            # A kölcsönzési adatok az adatbázis táblába illesztése. (Ki, mit, mikor, milyen határidővel (2 hetes))
            $stmt = $this->pdo->prepare(
                "INSERT INTO rentals (user_id, book_id, rented_at, returned_at) 
                 VALUES (:user_id, :book_id, NOW(), (NOW()+14))"
            );

            # Futtatás.
            $stmt->execute([
                'user_id' => $userId,
                'book_id' => $book['id']
            ]);

            # A könyv elérhetőségének frissítése az adatbázisban.
            $stmt = $this->pdo->prepare(
                "UPDATE books 
                 SET available = false 
                 WHERE id = :id"
            );

            # Futtatás.
            $stmt->execute([
                'id' => $book['id']
            ]);

            # Az adatbázis tranzakció lezárása.
            $this->pdo->commit();

            # Ha valami hiba van, akkor az addigi INSERT, UPDATE visszavonódik, mintha nem csináltam volna semmit sem. (Aztán exceptiont dob).
        } catch (Throwable $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    // Aktív (vissza nem hozott) kölcsönzések számolása
    public function countActiveRentalsByUser(int $userId): int
    {
        # Számolja össze a sorokat, amelyek megjelennek egy személy kölcsönzésénél. Tehát hány könyv van nála.
        $stmt = $this->pdo->prepare(
            "SELECT COUNT(*) 
             FROM rentals 
             WHERE user_id = :user_id"
        );

        $stmt->execute([
            'user_id' => $userId
        ]);

        return (int) $stmt->fetchColumn();
    }

    # A felhasználó kölcsönzött könyveinek visszaadása array-ben.
    public function getRentedBooksByUser(int $userId): array
    {
        $stmt = $this->pdo->prepare("SELECT b.title, b.author, b.isbn FROM rentals r INNER JOIN books b ON b.id = r.book_id WHERE r.user_id = :user_id ORDER BY b.title");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    # Volt a felhasználó és az ISBN-> könyv azonosító között kapcsolat?
    public function hasRentalByUserAndIsbn(int $userId, string $isbn): bool
    {
        # Csak arra az egy kapcsolatra vagyok kiváncsi.
        $stmt = $this->pdo->prepare("SELECT 1 FROM rentals r INNER JOIN books b ON b.id = r.book_id WHERE r.user_id = :user_id AND b.isbn = :isbn LIMIT 1");
        $stmt->execute(['user_id' => $userId, 'isbn' => $isbn]);
        return (bool) $stmt->fetchColumn();
    }

    # ISBN alapján törli a kölcsönzést az adatbázisból.
    public function giveBackByIsbn(int $userId, string $isbn): void
    {
        # Adatbázis tranzakció -> mind lefut vagy egyik sem.
        $this->pdo->beginTransaction();

        # Megpróbálom előkészíteni a qery-t
        try {
            $stmt = $this->pdo->prepare(
                "SELECT id FROM books WHERE isbn = :isbn FOR UPDATE"
            );
            # Futtatom a lekérdezést az ISBN számmal.
            $stmt->execute(['isbn' => $isbn]);

            # Ha van, akkor kiszedem a book_id-t
            $book_id = (int) ($stmt->fetchColumn() ?: 0);
            if ($book_id <= 0)
                throw new RuntimeException('A könyv nem található.');

            # Megnézem, hogy az adott könyv és az adott felhasználó párosul-e.
            $stmt = $this->pdo->prepare(
                "SELECT id FROM rentals WHERE user_id = :user_id AND book_id = :book_id FOR UPDATE"
            );
            $stmt->execute(['user_id' => $userId, 'book_id' => $book_id]);

            # Hibakezelés, ha nincsen aktív kapcsolat.
            $rental_id = (int) ($stmt->fetchColumn() ?: 0);
            if ($rental_id <= 0)
                throw new RuntimeException('Nincs ilyen aktív kölcsönzés.');

            # A könyv elérhetővé tétele
            $stmt = $this->pdo->prepare("UPDATE books SET available = true WHERE id = :id");
            $stmt->execute(['id' => $book_id]);
            
            # A törlés művelete itt történik meg
            $stmt = $this->pdo->prepare("DELETE FROM rentals WHERE id = :id");
            $stmt->execute(['id' => $rental_id]);

            $stmt = $this->pdo->prepare("UPDATE books SET available = true WHERE id = :id");
            $stmt->execute(['id' => $book_id]);

            # Tranzakció zárás.
            $this->pdo->commit();
            # Ha valami rosszul sült el, akkor vonja vissza az összes intézkedést.
        } catch (Throwable $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

}
