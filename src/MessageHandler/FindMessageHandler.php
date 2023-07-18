<?php

namespace App\MessageHandler;

use App\Entity\Book;
use App\Message\FindBookMessage;
use App\Service\BookService;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class FindMessageHandler implements MessageHandlerInterface
{
    private BookService $bookService;
    private LoggerInterface $logger;

    public function __construct(BookService $bookService, LoggerInterface $logger)
    {
        $this->bookService = $bookService;
        $this->logger = $logger;
    }
    public function __invoke(FindBookMessage $message): Book
    {
        $bookId = $message->getBookId();
        try {
            return $this->bookService->findById($bookId);
        } catch (\Exception $exception){
            $this->logger->error($exception->getMessage());
            throw new \Exception('Something wrong with book finding');
        }
    }
}