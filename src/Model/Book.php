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
}