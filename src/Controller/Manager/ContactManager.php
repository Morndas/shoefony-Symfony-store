<?php


namespace App\Controller\Manager;

use App\Entity\Contact;
use App\Mailer\ContactMailer;
use Doctrine\ORM\EntityManagerInterface;


class ContactManager
{
    private EntityManagerInterface $en;
    private ContactMailer $contactMailer;

    public function __construct(EntityManagerInterface $en, ContactMailer $contactMailer)
    {
        $this->en = $en;
        $this->contactMailer = $contactMailer;
    }

    public function save(Contact $contact)
    {
        $this->en->persist($contact);
        $this->en->flush();

        $this->contactMailer->send($contact);
    }
}