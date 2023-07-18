<?php

namespace App\MessageHandler;

use App\Message\RemoveAuthorMessage;
use App\Service\BookService;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class RemoveAuthorMessageHandler implements MessageHandlerInterface
{
    private BookService $bookService;
    private LoggerInterface $logger;

    public function __construct(BookService $bookService, LoggerInterface $logger)
    {
        $this->bookService = $bookService;
        $this->logger = $logger;
    }
    public function __invoke(RemoveAuthorMessage $message): void
    {
//        $params = $message->getParams();
        $bookId = $message->getBookId();
        $authorId = $message->getAuthorId();
        try {
            $this->bookService->removeAuthor($bookId, $authorId);
        } catch (\Exception $exception){
            $this->logger->error($exception->getMessage());
            throw new \Exception('Something wrong with book update');
        }
    }
}