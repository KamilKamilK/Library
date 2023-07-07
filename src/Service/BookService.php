<?php

namespace App\Service;

use App\Entity\Book;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;

class BookService
{
    private BookRepository $bookRepository;
    private AuthorService $authorService;
    private AuthorRepository $authorRepository;

    public function __construct(BookRepository $bookRepository, AuthorRepository $authorRepository, AuthorService $authorService)
    {

        $this->bookRepository = $bookRepository;
        $this->authorService = $authorService;
        $this->authorRepository = $authorRepository;
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

        $authorCollection = $this->mapAuthors($params->getAuthors()->toArray());

//        dd($authorCollection);
        if (!empty($authorCollection)) {
//        if (!empty($authorCollection) || $authorCollection->count() > 0) {
            foreach ($authorCollection->toArray() as $author) {
                $book->addAuthor($author);
            }
        }

//        dd($book);
        $this->bookRepository->save($book, true);
    }

    public function mapAuthors($authors)
    {
        $mappedAuthors = new ArrayCollection();

        if (empty($authors)) {
            return $authors;
        }

        foreach ($authors as $newAuthor) {

            $author = $this->authorService->getAuthor($newAuthor);

            if (!$author) {
                $mapAuthor = $this->authorService->createAuthor($newAuthor);
                $mappedAuthors->add($mapAuthor);
            } else {
                $this->authorService->updateAuthor($author, $newAuthor);
            }
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

    public function removeAuthor($bookId, $authorId): void
    {
        $book = $this->bookRepository->find($bookId);
        $author = $this->authorRepository->find($authorId);

        $book->removeAuthor($author);
        $this->bookRepository->save($book, true);
    }
}