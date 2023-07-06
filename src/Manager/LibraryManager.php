<?php

namespace App\Manager;

use App\Service\AuthorService;
use App\Service\BookService;

class LibraryManager
{
    private BookService $bookService;
    private AuthorService $authorService;

    public function __construct(BookService $bookService, AuthorService $authorService)
    {
        $this->bookService = $bookService;
        $this->authorService = $authorService;
    }

    public function action($action, $id = null, $params = [])
    {
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

    public function serializer($authorList): array
    {
        return [
            'authors' => $this->authorService->serialize($authorList)
        ];
    }
}