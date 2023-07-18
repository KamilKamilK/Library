<?php

namespace App\Message;

class FindBookMessage
{
    private int $bookId;

    public function __construct(int $bookId)
    {
        $this->bookId = $bookId;
    }

    public function getBookId(): int
    {
        return $this->bookId;
    }
}