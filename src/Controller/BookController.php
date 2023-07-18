<?php

namespace App\Controller;

use App\Form\BookType;
use App\Form\SearchFormType;
use App\Message\CreateBookMessage;
use App\Message\DeleteBookMessage;
use App\Message\FindBookMessage;
use App\Message\GetAllBooksMessage;
use App\Message\RemoveAuthorMessage;
use App\Message\SearchBookMessage;
use App\Message\UpdateBookMessage;
use App\Serializer\ArrayNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    private MessageBusInterface $messageBus;
    private ArrayNormalizer $arrayNormalizer;

    public function __construct(ArrayNormalizer $arrayNormalizer,  MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
        $this->arrayNormalizer = $arrayNormalizer;
    }

    #[Route('/', name: 'app_books')]
    public function getBooks(Request $request): Response
    {
        $books = $this->messageBus->dispatch(new GetAllBooksMessage())
            ->last(HandledStamp::class)->getResult();

        $form = $this->createForm(SearchFormType::class);

        if (!empty($request->request->all()['search_form'])) {
            $params = $request->request->all()['search_form'];
            try {
                $books = $this->messageBus->dispatch(new SearchBookMessage($params))
                    ->last(HandledStamp::class)->getResult();;

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
                $this->messageBus->dispatch(new CreateBookMessage($params));
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
        $book = $this->messageBus->dispatch(new FindBookMessage($bookId))
            ->last(HandledStamp::class)->getResult();

        $form = $this->createForm(BookType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $params = $form->getData();
            try {
                $this->messageBus->dispatch(new UpdateBookMessage($bookId, $params));
                $this->addFlash('success', 'Book is successfully updated');
                return $this->redirectToRoute('app_books');
            } catch (\Exception $exception) {
                $this->addFlash('error', $exception->getMessage());
            }
        }

        $jsonAuthor = $this->arrayNormalizer->normalizeArray($book);

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
        $this->messageBus->dispatch(new DeleteBookMessage($bookId));
        $this->addFlash('success', 'Book is successfully deleted');
        return $this->redirectToRoute('app_books');
    }

    #[Route('/author/remove/{bookId}/{authorId}', name: 'remove_author')]
    public function removeAuthor($bookId, $authorId): JsonResponse
    {
        $this->messageBus->dispatch(new RemoveAuthorMessage($bookId, $authorId));

        return new JsonResponse([
            'success' => true,
        ]);
    }
}
