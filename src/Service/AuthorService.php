<?php

namespace App\Service;

use App\Entity\Author;
use App\Repository\AuthorRepository;

class AuthorService
{

    private AuthorRepository $repository;

    public function __construct(AuthorRepository $repository)
    {

        $this->repository = $repository;
    }

    public function getAuthor($params): Author
    {

        $task = (new Author())
            ->setName($params['title'])
            ->setCountry($params['country'])
            ->setCreatedAt(new \DateTime())
            ->setUpdatedAt(new \DateTime());

        $this->repository->save($task, true);
        return $task;
    }
}