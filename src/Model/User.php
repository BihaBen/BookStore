<?php
class User
{
    private int $id;
    private string $username;
    private string $email;
    private string $password;
    private DateTimeImmutable $created_at;

    function __construct(int $id, string $username, string $email, string $password, DateTimeImmutable $created_at)
    {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->created_at = $created_at;
    }
}