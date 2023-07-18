<?php

namespace App\Message;

class RemoveAuthorMessage
{
    private int $bookId;
    private int $authorId;

    public function __construct(int $bookId, int $authorId)
    {
        $this->bookId = $bookId;
        $this->authorId = $authorId;
    }

    public function getAuthorId(): int
    {
        return $this->authorId;
    }


    public function getBookId(): int
    {
        return $this->bookId;
    }
}