<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact', methods: [Request::METHOD_GET, Request::METHOD_POST])]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $email = (new Email())
                ->To('admin@Synmfony.com')
                ->from($form['email']->getData())
                ->subject('Nouvelle demande : ' . $form['subject']->getData())
                ->text($form['message']->getData());
            $mailer->send($email);

            $this->addFlash('success', 'Message sent!');
        }
        return $this->renderForm('contact/contact.html.twig', [
            'form' => $form
        ]);
    }
}
