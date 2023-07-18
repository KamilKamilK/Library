<?php

namespace App\Serializer;

use App\Entity\Book;
use Symfony\Component\Serializer\SerializerInterface;

class ArrayNormalizer
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function normalizeArray(Book $book): string
    {
        $authors = $book->getAuthors();

        $data = [
            'title' => $book->getTitle(),
            'authors' => $authors->toArray(),
        ];

        $context = [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            },
        ];

//        return $this->serializer->serialize($data, 'json');
        return $this->serializer->serialize($data, 'json', $context);
    }
}