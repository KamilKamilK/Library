<?php

namespace App\Service;

use App\Entity\Book;
use App\Repository\BookRepository;

class BookService
{
    private BookRepository $bookRepository;

    public function __construct(BookRepository $bookRepository)
    {

        $this->bookRepository = $bookRepository;
    }

    public function getAllBooks(): array
    {
        return $this->bookRepository->findAll();
    }

    public function createBook($params, $author)
    {
        $book = (new Book())
            ->setTitle($params['title'])
            ->setPublisher($params['publisher'])
            ->setPages($params['pages'])
            ->setAuthor($author)
            ->setCreatedAt(new \DateTime());

        $this->bookRepository->save($book, true);
        return $book;
    }
}