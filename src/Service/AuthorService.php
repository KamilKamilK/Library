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

    public function createAuthor(Author $author): Author
    {
        $newAuthor = (new Author())
            ->setName($author->getName())
            ->setCountry($author->getCountry())
            ->setCreatedAt(new \DateTime())
            ->setUpdatedAt(new \DateTime());

        $this->repository->save($newAuthor, true);

        return $newAuthor;
    }

    public function getAuthor(Author $author): ?Author
    {
        if ($author->getId() !== null){
            $foundAuthor = $this->repository->findOneBy(['id' => $author->getId()]);
        } elseif ($author->getName() !== null){
            $foundAuthor = $this->repository->findOneBy(['name' => $author->getName()]);
        } elseif ($author->getCountry() !== null){
            $foundAuthor = $this->repository->findOneBy(['country' => $author->getCountry()]);
        }

        return $foundAuthor;
    }
}