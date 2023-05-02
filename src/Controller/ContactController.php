<?php

namespace App\Controller;

use App\Contact\ContactNotifier;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact', methods: [Request::METHOD_GET, Request::METHOD_POST])]
    public function index(Request $request, ContactNotifier $contactNotifier): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
                
            $contactNotifier->send($form->getData());
            $this->addFlash('success', 'Message sent!');
        }
        return $this->renderForm('contact/contact.html.twig', [
            'form' => $form
        ]);
    }
}
