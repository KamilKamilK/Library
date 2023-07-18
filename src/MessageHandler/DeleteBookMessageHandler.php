<?php

namespace App\MessageHandler;

use App\Message\DeleteBookMessage;
use App\Service\BookService;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class DeleteBookMessageHandler implements MessageHandlerInterface
{
    private BookService $bookService;
    private LoggerInterface $logger;

    public function __construct(BookService $bookService, LoggerInterface $logger)
    {
        $this->bookService = $bookService;
        $this->logger = $logger;
    }
    public function __invoke(DeleteBookMessage $message): void
    {
        $bookId = $message->getBookId();
        try {
            $this->bookService->deleteBook($bookId);
        } catch (\Exception $exception){
            $this->logger->error($exception->getMessage());
            throw new \Exception('Something wrong with book deletion');
        }
    }
}