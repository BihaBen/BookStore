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
            "SELECT id,title,author,isbn FROM books WHERE available=1 ORDER BY title"
        )->fetchAll(PDO::FETCH_ASSOC);
    }

    # Visszaadja az egyezést talált könyveket.
    public function getBackTheMatchedBooks(string $searchbarInput)
    {  
        # Mindenfélekképpen legyen valamilyen egyezés és elérhető legyen.
        $stmt = $this->pdo->prepare(
            "SELECT * FROM books WHERE INSTR(title, :title)>0 AND available = true ORDER BY title"
        );

        # Futtatom
        $stmt->execute(['title' => $searchbarInput]);

        # és átadom a kapott rekordokat.
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


}
