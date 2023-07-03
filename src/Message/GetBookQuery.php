<?php

namespace App\Message;

class GetBookQuery
{	private string $table;

    public function __construct( string $table ) {
        $this->table = $table;
    }

    public function getTable(): string {
        return $this->table;
    }

    public function setTable( string $table ): self {
        $this->table = $table;

        return $this;
    }

}