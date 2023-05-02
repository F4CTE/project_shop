<?php

namespace App\Contact;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class ContactNotifier
{

    public function __construct(private MailerInterface $mailer, private string $adminEmail)
    {
    }

    public function send(array $data)
    {
        $email = (new Email())
            ->To($this->adminEmail)
            ->from($data['email'])
            ->subject('Nouvelle demande : ' . $data['subject']->getData())
            ->text($data['message']->getData());
        $this->mailer->send($email);
    }
}
