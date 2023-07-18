<?php

namespace App\Message;

use App\Entity\Book;

class UpdateBookMessage
{
    private Book $params;
    private int $bookId;

    public function __construct(int $bookId, Book $params)
    {
        $this->bookId = $bookId;
        $this->params = $params;
    }

    public function getParams(): Book
    {
        return $this->params;
    }

    public function getBookId(): int
    {
        return $this->bookId;
    }
}