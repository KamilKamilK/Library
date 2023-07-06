<?php

namespace App\Controller;

use App\Form\BookType;
use App\Form\SearchFormType;
use App\Manager\LibraryManager;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
//        phpinfo();
//        xdebug_info();
//        $this->setContainer();
        $books = $this->manager->action('all');
        $form = $this->createForm(SearchFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $params = $form->getData();
            try {
                $books = $this->manager->action('search', null, $params);
            } catch (\Exception) {
                throw $this->createNotFoundException();
            }
        } else {
            $errors = $form->getErrors(true, true);
            foreach ($errors as $error) {
                echo $error->getMessage() . "<br>";
            }
        }

        return $this->render('book/index.html.twig', [
            'books' => $books,
            'form' => $form->createView()
        ]);
    }

    #[Route('/book', name: 'add_book')]
    public function post(Request $request): Response
    {
        $form = $this->createForm(BookType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $params = $form->getData();

            try {
                $this->manager->action('create', null, $params);

                return $this->redirectToRoute('app_books');
            } catch (\Exception $exception) {
                throw new Exception($exception->getMessage());
            }
        }

        return $this->render('book/addBook.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/book/edit/{bookId}', name: 'edit_book')]
    public function put($bookId, Request $request): Response|JsonResponse
    {
        $book = $this->manager->action('find', $bookId);
        $authors = $book->getAuthors();
        $form = $this->createForm(BookType::class, $book);

        $form->get('authors')->setData($book->getAuthors()->toArray());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $params = $form->getData();

            try {
                $this->manager->action('update', $bookId, $params);

                return $this->redirectToRoute('app_books');
            } catch (\Exception $exception) {
                throw new Exception($exception->getMessage());
            }
        }

        $jsonAuthor = $this->manager->serializer($authors->toArray());

        $responseData = [
            'authors' => $jsonAuthor
        ];

        if ($request->isXmlHttpRequest()) {
            return new JsonResponse($responseData);
        } else {
            return $this->render('book/editBook.html.twig', [
                'form' => $form->createView(),
                'book' => $book,
                'authors' => $authors
            ]);
        }
    }

    #[Route('/book/delete/{bookId}', name: 'delete_book')]
    public function delete($bookId): RedirectResponse
    {
        $this->manager->action('delete', $bookId);
        return $this->redirectToRoute('app_books');
    }
}
