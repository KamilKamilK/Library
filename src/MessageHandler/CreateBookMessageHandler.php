<?php

namespace App\MessageHandler;

use App\Message\CreateBookMessage;
use App\Service\BookService;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CreateBookMessageHandler implements MessageHandlerInterface
{
    private BookService $bookService;
    private LoggerInterface $logger;

    public function __construct(BookService $bookService, LoggerInterface $logger)
    {
        $this->bookService = $bookService;
        $this->logger = $logger;
    }
    public function __invoke(CreateBookMessage $message): void
    {
//        dd($message);
        $params = $message->getParams();
        try {
            $this->bookService->createBook($params);
        } catch (\Exception $exception){
            $this->logger->error($exception->getMessage());
            throw new \Exception('Something wrong with book creation');
        }
    }
}