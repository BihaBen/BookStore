<?php
class Rental
{
    private int $id;
    private int $user_id;
    private int $book_id;
    private DateTimeImmutable $rented_at;
    private ?DateTimeImmutable  $returned_at;

    function __construct(int $id, int $user_id, int $book_id, DateTimeImmutable $rented_at, ?DateTimeImmutable $returned_at)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->book_id = $book_id;
        $this->rented_at = $rented_at;
        $this->returned_at = $returned_at;
    }
 
}
