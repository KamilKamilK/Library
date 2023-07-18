<?php

namespace App\MessageHandler;

use App\Message\UpdateBookMessage;
use App\Service\BookService;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class UpdateBookMessageHandler implements MessageHandlerInterface
{
    private BookService $bookService;
    private LoggerInterface $logger;

    public function __construct(BookService $bookService, LoggerInterface $logger)
    {
        $this->bookService = $bookService;
        $this->logger = $logger;
    }
    public function __invoke(UpdateBookMessage $message): void
    {
        $params = $message->getParams();
        $bookId = $message->getBookId();

        try {
            $this->bookService->updateBook($bookId, $params);
        } catch (\Exception $exception){
            $this->logger->error($exception->getMessage());
            throw new \Exception('Something wrong with book update');
        }
    }
}