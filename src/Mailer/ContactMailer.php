<?php


namespace App\Mailer;

use App\Entity\Contact;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;


class ContactMailer
{

    function send(Contact $contact):void {


        $email = (new TemplatedEmail())
            ->from('MorndasFifou@gmail.com')
            ->to('contact@shoefony.com')
            ->subject('Un message de contact sur Shoefony')
            ->htmlTemplate('email/contact.html.twig')
            ->context([
                'contact' => $contact
            ]);

        $mailer->send($email);

    }
}