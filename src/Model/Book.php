<?php
class Book
{
    private int $id;
    private string $title;
    private string $author;
    private string $isbn;
    private bool $available;

    function __construct(int $id, string $title, string $author, string $isbn, bool $available)
    {
        $this->id = $id;
        $this->title = $title;
        $this->author = $author;
        $this->isbn = $isbn;
        $this->available = $available;
    }

    public static function isAvailable(): bool{
        $isAvailable= false;

        
        return $isAvailable;
    }
    
    # Getterek a repository-hoz
    public function getId(): int { return $this->id; }
    public function getTitle(): string { return $this->title; }
    public function getAuthor(): string { return $this->author; }
    public function getISBN(): string { return $this->isbn; }
    public function getAvailable(): bool { return $this->available; }




}