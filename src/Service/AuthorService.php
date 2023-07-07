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
        return $author
            ->setCreatedAt(new \DateTime());
    }

    public function updateAuthor(Author $author, Author $newAuthor): void
    {
        $author
            ->setName($newAuthor->getName())
            ->setCountry($newAuthor->getCountry())
            ->setUpdatedAt(new \DateTime());

        $this->repository->save($author, true);
    }

    public function getAuthor(Author $author): ?Author
    {
        if ($author->getId() !== null) {
            $foundAuthor = $this->repository->findOneBy(['id' => $author->getId()]);
        } elseif ($author->getName() !== null) {
            $foundAuthor = $this->repository->findOneBy(['name' => $author->getName()]);
        } elseif ($author->getCountry() !== null) {
            $foundAuthor = $this->repository->findOneBy(['country' => $author->getCountry()]);
        }

        return $foundAuthor;
    }

    public function serialize($authorList): array
    {
        $serializedArr = [];

        foreach ($authorList as $author) {
            $authorData = [
                'id' => $author->getId(),
                'name' => $author->getName(),
                'country' => $author->getCountry(),
            ];

            $serializedArr[] = $authorData;
        }
        return $serializedArr;
    }
}