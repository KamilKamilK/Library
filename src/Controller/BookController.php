<?php

namespace App\Controller;

use App\Form\BookType;
use App\Form\SearchFormType;
use App\Manager\LibraryManager;
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
        $books = $this->manager->action('all');

        $form = $this->createForm(SearchFormType::class);

        if (!empty($request->request->all()['search_form'])) {
            $params = $request->request->all()['search_form'];
            try {
                $books = $this->manager->action('search', null, $params);
            } catch (\Exception $exception) {
                $this->addFlash('error', $exception->getMessage());
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
                $this->addFlash('success', 'Book is successfully created');
                return $this->redirectToRoute('app_books');
            } catch (\Exception $exception) {
                $this->addFlash('error', $exception->getMessage());
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
        $form = $this->createForm(BookType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $params = $form->getData();
            try {
                $this->manager->action('update', $bookId, $params);
                $this->addFlash('success', 'Book is successfully updated');
                return $this->redirectToRoute('app_books');
            } catch (\Exception $exception) {
                $this->addFlash('error', $exception->getMessage());
//                throw new Exception($exception->getMessage());
            }
        }

        $jsonAuthor = $this->manager->serializer($authors->toArray());

        if ($request->isXmlHttpRequest()) {
            return new JsonResponse($jsonAuthor);
        } else {
            return $this->render('book/editBook.html.twig', [
                'form' => $form->createView(),
                'book' => $book,
            ]);
        }
    }

    #[Route('/book/delete/{bookId}', name: 'delete_book')]
    public function delete($bookId): RedirectResponse
    {
        $this->manager->action('delete', $bookId);
        $this->addFlash('success', 'Book is successfully deleted');
        return $this->redirectToRoute('app_books');
    }

    #[Route('/author/remove/{bookId}/{authorId}', name: 'remove_author')]
    public function removeAuthor($bookId, $authorId): JsonResponse
    {
        $this->manager->action('remove', $bookId, $authorId);
        return new JsonResponse([
            'success' => true,
        ]);
    }
}
