<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookForm;
use App\Repository\BookRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    private BookRepository $bookRepository;
    private MailerInterface $mailer;

    public function __construct(BookRepository $bookRepository, MailerInterface $mailer)
    {
        $this->bookRepository = $bookRepository;
        $this->mailer = $mailer;
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     * @throws TransportExceptionInterface
     */
    #[Route('/book', name: 'app_book_table', methods: ['GET', 'POST'])]
    public function index(Request $request): Response
    {
        $book = new Book();
        $form = $this->createForm(BookForm::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // dd($book->getEmail(), $book->getName()); die();
            $this->bookRepository->add($book);

            $email = (new TemplatedEmail())
                ->from('contact@resto.com')
                ->to(new Address($book->getEmail()))
                ->subject('Confirmation de la réservation')
                ->htmlTemplate('main/book/email.html.twig')
                ->context([
                    'name' => $book->getName(),
                    'phone' => $book->getPhone()
                ])
            ;

            $this->mailer->send($email);

            $this->addFlash('success', 'Votre Reservation à bien été pris en compte par notre équipe');
            return $this->redirectToRoute('app_book_table', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('main/book/index.html.twig', [
            'formBook' => $form,
            'book' => $book
        ]);
    }
}