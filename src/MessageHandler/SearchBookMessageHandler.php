<?php

namespace App\MessageHandler;

use App\Message\CreateBookMessage;
use App\Message\SearchBookMessage;
use App\Service\BookService;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class SearchBookMessageHandler implements MessageHandlerInterface
{
    private BookService $bookService;
    private LoggerInterface $logger;

    public function __construct(BookService $bookService, LoggerInterface $logger)
    {
        $this->bookService = $bookService;
        $this->logger = $logger;
    }
    public function __invoke(SearchBookMessage $message): array
    {
        $params = $message->getParams();
        try {
//            $book = $this->bookService->findByParam($params);
//            dd($book);
            return $this->bookService->findByParam($params);
        } catch (\Exception $exception){
            $this->logger->error($exception->getMessage());
            throw new \Exception('Something wrong when looking for book');
        }
    }
}