<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    public function __construct()
    {}

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('main/home.html.twig', []);
    }

    /*** @throws TransportExceptionInterface */
    #[Route('/contact', name: 'app_contact', methods: ['POST'])]
    public function contact(MailerInterface $mailer, Request $request): Response
    {
        $name = $request->request->get('name');
        $email = $request->request->get('email');
        $subject = $request->request->get('subject');
        $message = $request->request->get('message');

        $email = (new Email())
            ->from(new Address($email))
            ->to('contact@resto.com')
            ->subject($name.' : '.$subject)
            ->text($message)
        ;

        $mailer->send($email);

        return $this->render('main/home.html.twig', []);
    }
}