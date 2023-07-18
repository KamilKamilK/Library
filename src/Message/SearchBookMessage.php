<?php

namespace App\Message;

class SearchBookMessage
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