<?php
class BookRepository
{
    # Példányosításnál kapja meg az adatbázis kapcsolatot.
    public function __construct(private PDO $pdo)
    {
    }

    # SQL lekérdezés: Az összes könyv adatait adja vissza könyv cím szerint rendezve.
    public function getBackAllBooks(): array
    {
        return $this->pdo->query(
            "SELECT id,title,author,isbn FROM books ORDER BY title"
        )->fetchAll(PDO::FETCH_ASSOC);
    }
}
