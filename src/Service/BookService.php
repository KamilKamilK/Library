<?php

namespace App\Service;

use App\Entity\Author;
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
        $this->mapAuthors($params->getAuthors());

        $book = (new Book())
            ->setTitle($params->getTitle())
            ->setPublisher($params->getPublisher())
            ->setPages($params->getPages())
            ->setIsPublished($params->isPublished())
            ->setCreatedAt(new \DateTime())
            ->setUpdatedAt(new \DateTime());

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
//        dd($authors->toArray());

        foreach ($authors->toArray() as $author) {

            $mappedAuthor = $this->authorService->getAuthor($author);
//            var_dump($mappedAuthor);
            if (!$mappedAuthor) {
//                dd('kamil');
                $mappedAuthor = $this->authorService->createAuthor($author);
            }

            $mappedAuthors->add($mappedAuthor);
        }

//        dd($mappedAuthors);

        return $mappedAuthors;
    }


    public function updateBook($id, $params): void
    {
        $book = $this->findById($id);
        $book->setTitle($params->getTitle())
            ->setPublisher($params->getPublisher())
            ->setPages($params->getPages())
            ->setIsPublished($params->isPublished())
            ->setUpdatedAt(new \DateTime())
            ->setCreatedAt($params->getCreatedAt());

        $authorCollection = $this->mapAuthors($params->getAuthors());

        foreach ($authorCollection as $author) {
            $book->addAuthor($author);
        }

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