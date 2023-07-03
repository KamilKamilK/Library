<?php

namespace App\Manager;

use App\Entity\Book;
use App\Factory\AuthorFactory;
use App\Service\AuthorService;
use App\Service\BookService;
use Symfony\Component\Messenger\MessageBusInterface;

class LibraryManager
{
    private BookService $bookService;
    private AuthorService $authorService;

    public function __construct(BookService $bookService, AuthorService $authorService, MessageBusInterface $messenger ) {

        $this->messenger = $messenger;
        $this->bookService = $bookService;
        $this->authorService = $authorService;
    }
    public function getAllBooks(): array
    {
//        $envelope = $this->messenger->dispatch(new GetBookQuery($table));
//        $aggregatedData = $envelope->last( HandledStamp::class )->getResult();
//
//        $rates = $this->service->mapRates( $aggregatedData['rates'] );
//
//        return new JsonResponse ( [
//            'tableNumber'  => $aggregatedData['tableNumber'],
//            'updatingDate' => $aggregatedData['updatingDate'],
//            'rates'        => $rates
//        ], Response::HTTP_OK, );


        return $this->bookService->getAllBooks();
    }


    public function createBook($params): array
    {
        $author = $this->authorService->getAuthor($params['author']);

        $this->bookService->createBook($params, $author);
    }
}