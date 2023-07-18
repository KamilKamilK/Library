<?php

namespace App\MessageHandler;

use App\Message\GetAllBooksMessage;
use App\Service\BookService;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class GetAllBooksMessageHandler implements MessageHandlerInterface
{
    private BookService $bookService;
    private LoggerInterface $logger;

    public function __construct(BookService $bookService, LoggerInterface $logger)
    {
        $this->bookService = $bookService;
        $this->logger = $logger;
    }

    public function __invoke(GetAllBooksMessage $message): array
    {
        try {
            return $this->bookService->getAllBooks();
        } catch (\Exception $exception) {
            $this->logger->error($exception->getMessage());
            throw new \Exception('Something wrong with when loading books');
        }
    }
}