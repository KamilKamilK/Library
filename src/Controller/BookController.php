<?php

namespace App\Controller;

use App\Form\BookType;
use App\Manager\LibraryManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    private LibraryManager $manager;

    public function __construct(LibraryManager $manager)
    {

        $this->manager = $manager;
    }

    #[Route('/', name: 'app_books')]
    public function getBooks(Request $request): Response
    {
        $form = $this->createForm(BookType::class);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $params = $form->getData();

            try {
                $this->manager->createBook($params);
            } catch (\Exception) {
                throw $this->createNotFoundException();
            }
        }
        $books = $this->manager->getAllBooks();

        return $this->render('book/index.html.twig', [
            'books' => $books,
            'form' => $form->createView()
        ]);
    }
}
