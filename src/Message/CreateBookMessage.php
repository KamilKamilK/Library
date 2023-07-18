<?php

namespace App\Message;

class CreateBookMessage
{
    private array $params;

    public function __construct(array $params)
    {
        $this->params = $params;
    }

    public function getParams(): array
    {
        return $this->params;
    }
}