<?php

namespace App\Manager;

use App\Entity\Book;
use App\Service\AuthorService;
use App\Service\BookService;
use Symfony\Component\Messenger\MessageBusInterface;

class LibraryManager
{
    private BookService $bookService;
    private AuthorService $authorService;

    public function __construct(BookService $bookService, AuthorService $authorService, MessageBusInterface $messenger)
    {

        $this->messenger = $messenger;
        $this->bookService = $bookService;
        $this->authorService = $authorService;
    }

    public function getAllBooks(): array
    {
        return $this->bookService->getAllBooks();
    }

//    public function createBook($params): void
//    {
////        $author = $this->authorService->getAuthor($params['author']);
//        $this->bookService->createBook($params);
//    }
//
//    public function findBooks($params): array
//    {
//        return $this->bookService->findByParam($params);
//    }
//
//    public function findBook($id): Book
//    {
//        return $this->bookService->findById($id);
//    }
//
//    public function deleteBook($id): void
//    {
//        $this->bookService->deleteById($id);
//    }

    public function action($action, $id = null, $params = [])
    {
//        dd($params);
        if ($action === 'find') {
            return $this->bookService->findById($id);
        } elseif ($action === 'delete') {
            $this->bookService->deleteBook($id);
        } elseif ($action === 'create') {
            $this->bookService->createBook($params);
        } elseif ($action === 'update') {
            $this->bookService->updateBook($id, $params);
        } elseif ($action === 'all') {
            return $this->bookService->getAllBooks();
        } elseif ($action === 'search') {
            return $this->bookService->findByParam($params);
        }
    }
}