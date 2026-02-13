<?php
# Mezőnevek és konstruktor létrehozása
class User
{
    private int $id;
    private string $username;
    private string $email;
    private string $password;
    private bool $isAdmin;
    private DateTimeImmutable $createdAt;

    function __construct(int $id,string $username, string $email, string $password, bool $isAdmin, $createdAt)
    {
        $this->id=$id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->isAdmin = $isAdmin;
        $this->createdAt=$createdAt;
    }


    #---
    # Új User példány létrehozás
    #---
    public static function register(string $username, string $email, string $plainPassword): self
    {
        # Osztály szinten vizsgálom a helyes mező adatok megadását.
        # Vizsgálata a saját osztály metódusainak meghívásával.
        # Ha valid értékeket kapunk, akkor eltároljuk, egyébként felhívjuk a figyelmet a hibára.
        $username = self::validateUsername($username);
        $email = self::validateEmail($email);

        # A jelszónál hiba: kivétel; helyes: hasheljük.
        self::validatePassword($plainPassword);
        $hashed = password_hash($plainPassword, PASSWORD_BCRYPT);

        # Jelenlegi idő elmentés.
        $dtNow = new DateTimeImmutable('now', new DateTimeZone('Europe/Budapest'));

        # User példány összekészítése és visszaadása.
        return new self(0, $username, $email,$hashed, false, $dtNow);
    }

    # ---
    # Validációk
    # ---
    # mb_strlen: beépített string karakterszám visszaadó.
    public static function validateUsername(string $username): string
    {
        $username = trim($username);
        if ($username === '') {
            throw new InvalidArgumentException('A felhasználónév megadása kötelező.');
        }

        if (mb_strlen($username) < 3) {
            throw new InvalidArgumentException('A felhasználónév minimum 3 karakter hosszú legyen.');
        }

        if (mb_strlen($username) > 50) {
            throw new InvalidArgumentException('A felhasználónév maximum 50 karakter lehet.');
        }

        return $username;
    }

    public static function validateEmail(string $email): string
    {
        # Kisbetűsítem az ellenőrzés előtt.
        $email = strtolower(trim($email));

        if ($email === '') {
            throw new InvalidArgumentException('Az email megadása kötelező.');
        }

        # filter_var: beápített email cím ellenőrző.
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Érvénytelen email formátum.');
        }
        if (mb_strlen($email) > 255) {
            throw new InvalidArgumentException('Email túl hosszú (max 255).');
        }

        return $email;
    }

    #preg_match: beépített intervallum ellenőrző.
    public static function validatePassword(string $password): void
    {
        if ($password === '') {
            throw new InvalidArgumentException('A jelszó megadása kötelező.');
        }
        if (mb_strlen($password) < 8) {
            throw new InvalidArgumentException('A jelszó túl rövid (minimum 3 karakter) hosszúságúnak kell lennie.');
        }
        if (!preg_match('/[a-z]/', $password)) {
            throw new InvalidArgumentException('A jelszónak tartalmaznia kell kisbetűt.');
        }
        if (!preg_match('/[A-Z]/', $password)) {
            throw new InvalidArgumentException('A jelszónak tartalmaznia kell nagybetűt.');
        }
        if (!preg_match('/[0-9]/', $password)) {
            throw new InvalidArgumentException('A jelszónak tartalmaznia kell számot.');
        }
    }

## Getterek a repository-hoz
    public function getId(): int { return $this->id; }
    public function getUsername(): string { return $this->username; }
    public function getEmail(): string { return $this->email; }
    public function getPasswordHash(): string { return $this->password; }
    public function isAdmin(): bool { return $this->isAdmin; }
    public function getCreatedAt(): DateTimeImmutable { return $this->createdAt; }

}