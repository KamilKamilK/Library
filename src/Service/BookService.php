<?php

namespace App\Service;

use App\Entity\Book;
use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;

class BookService
{
    private BookRepository $bookRepository;
    private AuthorService $authorService;

    public function __construct(BookRepository $bookRepository, AuthorService $authorService)
    {

        $this->bookRepository = $bookRepository;
        $this->authorService = $authorService;
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
            ->setCreatedAt(new \DateTime());

        $authorCollection = $this->mapAuthors($params->getAuthors());

        foreach ($authorCollection as $author) {
            $book->addAuthor($author);
        }

        $this->bookRepository->save($book, true);

    }

    public function updateBook($id, $params): void
    {
        $book = $this->findById($id);
        $book->setTitle($params->getTitle())
            ->setPublisher($params->getPublisher())
            ->setPages($params->getPages())
            ->setIsPublished($params->isPublished());

        $authorCollection = $this->mapAuthors($params->getAuthors());

        foreach ($authorCollection as $author) {
            $book->addAuthor($author);
        }
        $this->bookRepository->save($book, true);
    }

    public function mapAuthors($authors)
    {
        $mappedAuthors = new ArrayCollection();

        if (empty($authors)) {
            return $authors;
        }

        foreach ($authors->toArray() as $author) {

            $mappedAuthor = $this->authorService->getAuthor($author);;
            if (!$mappedAuthor) {
                $mappedAuthor = $this->authorService->createAuthor($author);
            } else {
                $mappedAuthor = $this->authorService->updateAuthor($author);
            }

            $mappedAuthors->add($mappedAuthor);

        }
        return $mappedAuthors;
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

//    public function serialize($book): array
//    {
//
//        $jsonBook = [
//            'name' => $book->getName(),
//            'country' => $author->getCountry(),
//        ];
//
//        return $jsonBook;
//    }
}