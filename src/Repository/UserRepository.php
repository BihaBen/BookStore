<?php
class UserRepository
{
    # PHP Data Object -> adatbázis kezelés.
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    # Ellenőrzöm, hogy létezik-e már az email cím.
    public function existsByEmail(string $email): bool
    {
        # Előkészítem a lekérdezést -> csak azt az 1 sort jelenítse meg, ha van érték.
        $stmt = $this->pdo->prepare(
            "SELECT 1 FROM users WHERE email = :email LIMIT 1"
        );

        # Futtatom és átadom a kapott email-t.
        $stmt->execute(['email' => $email]);

        # Létezik: true vagy nem létezik: false.
        return (bool) $stmt->fetchColumn();
    }

    public function existsByUsername(string $username): bool
    {
        # Előkészítem a lekérdezést -> csak azt az 1 sort jelenítse meg, ha van érték.
        $stmt = $this->pdo->prepare(
            "SELECT 1 FROM users WHERE username = :username LIMIT 1"
        );

        # Futtatom és átadom a kapott felhasználónevet.
        $stmt->execute(['username' => $username]);

        # Létezik: true vagy nem létezik: false.
        return (bool) $stmt->fetchColumn();
    }


    # Létrehozom regisztrációkor a User-t az adatbázisban.
    public function create(User $user): int
    {
        # Előkészítem, hogy hova mit fogok beírni futtatásnál.
        $stmt = $this->pdo->prepare("
            INSERT INTO users (username, email, password, isAdmin)
            VALUES (:username, :email, :password, :isAdmin)
        ");

        # Futtatom és átadom a kapott User getteréből jövő adatokat.
        $stmt->execute([
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
            'password' => $user->getPasswordHash(),
            'isAdmin' => $user->isAdmin() ? 1 : 0,
        ]);

        # Az utolsó ID-ra berakom.
        return (int) $this->pdo->lastInsertId();
    }

    # Email alapján megkeresem a felhasználót és egy tömböt vagy null-t adok vissza.
    public function findByEmail(string $email): ?array
    {
        # Előkészítem a lekérdezést -> csak azt az 1 sort jelenítse meg, ha van érték.
        $stmt = $this->pdo->prepare("
        SELECT id, username, email, password, isAdmin, created_at
        FROM users
        WHERE email = :email
        LIMIT 1
    ");
        # Futtatom és átadom a kapott email-t.
        $stmt->execute(['email' => $email]);

        # A futtatás után kapott sort: 1db, mert ennyit kértem le -> elmentem egy változóba.
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        # Ha a $row nem üres, akkor vissza adom különben null-lal töltöm fel.
        return $row !== false ? $row : null;
    }
}
