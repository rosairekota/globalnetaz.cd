<?php

namespace App\Notification;

use Twig\Environment;
use App\Entity\Contact;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Message;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\RawMessage;
use Symfony\Component\Mime\Header\Headers;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class ContactNotification
{
    
    /**
     * @var Mailer
     */
    private $mymail;


    public function __construct(MailerInterface $mailer)
    {
      
        $this->mymail = $mailer;
    }
    public function notify(Contact $contact)
    {
       // envoi d'email simple
        /*$email =(new Email())
                 ->from('test@nsat.africa')
                 ->to('contact@nsat.africa')
                 ->subject("Agence:")
                 ->text('Test ')
                 ->html('Ceci nest test');
        $this->mymail->send($email);
         */
        // envoi d'email avec twig

        $email = (new TemplatedEmail())
            ->from('noreply@nsat.africa')
            ->to(new Address('contact@nsat.africa'))
            ->replyTo($contact->getEmail())
            ->subject('Achat du Bien:'.$contact->getProperty()->getTitle())

            // path of the Twig template to render
            ->htmlTemplate('emails/contact.html.twig')

            // pass variables (name => value) to the template
            ->context([
                'expiration_date' => new \DateTime('+7 days'),
                'contact' => $contact,
            ]);
         $this->mymail->send($email);


    }
}
