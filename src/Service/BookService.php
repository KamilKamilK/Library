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

    public function createBook($params): void
    {
        $book = (new Book())
            ->setTitle($params->getTitle())
            ->setPublisher($params->getPublisher())
            ->setPages($params->getPages())
            ->setIsPublished($params->isPublished())
//            ->setAuthor($author)
            ->setCreatedAt(new \DateTime())
            ->setUpdatedAt(new \DateTime());

        $this->bookRepository->save($book, true);
    }

    public function updateBook($id, $params): void
    {
        $book = $this->findById($id);
        $book->setTitle($params->getTitle())
            ->setPublisher($params->getPublisher())
            ->setPages($params->getPages())
            ->setIsPublished($params->isPublished())
//            ->setAuthor($author)
            ->setUpdatedAt(new \DateTime());

        $this->bookRepository->save($book, true);
    }

    public function findByParam($params): array
    {
        $title = $params->getTitle() ?? null;
        $publisher = $params->getPublisher() ?? null;
        $isPublished = $params->isPublished();

        return $this->bookRepository->findAllBySearchForm($title, $publisher, $isPublished);
    }
    public function findById($id): Book
    {
        return $this->bookRepository->find($id);
    }

    public function deleteBook($id): void
    {
        $book = $this->bookRepository->find($id);
        $this->bookRepository->remove($book, true);
    }
}