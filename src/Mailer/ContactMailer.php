<?php


namespace App\Mailer;

use App\Entity\Contact;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
// use Symfony\Component\Mime\Email;


class ContactMailer
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    function send(Contact $contact):void {

        $email = (new TemplatedEmail())
            ->from('MorndasFifou@gmail.com')
            ->to('contact@shoefony.com')
            ->subject('Un message de contact sur Shoefony')
            ->htmlTemplate('email/contact.html.twig')
            ->context([
                'contact' => $contact
            ]);

        $this->mailer->send($email);

    }
}