<?php
/**
 * Created by PhpStorm.
 * User: jm
 * Date: 24/05/16
 * Time: 09:22
 */

namespace OC\CoreBundle\Services;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

class Mailer
{
    private $mailer;
    private $templating;
    private $adminEmail;

    private $subject;
    private $body;

    /**
     * @param $mailer
     * @param EngineInterface $templating
     * @param $adminEmail
     */
    public function __construct($mailer, EngineInterface $templating, $adminEmail)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->adminEmail = $adminEmail;
    }

    /**
     * @param $customerEmail
     * @param $visitors
     */
    public function contactConfirm($contact)
    {
        $this->subject = 'Contact depuis le site - NAO';
        
        $this->doTemplate('OCCoreBundle:Email:contactForm.html.twig',
            array('subject' => $contact['subject'],
                  'name' => $contact['name'],
                  'email'=> $contact['email'],
                  'message' => $contact['message'],
            ));

        $this->send();
    }

    /**
     * @param $template
     * @param array $options
     */
    private function doTemplate($template, array $options)
    {
        $this->body = $this->templating->render($template, $options);
    }

    /**
     * @param $customerEmail
     * @param $visitors
     */
    public function send()
    {
        $message = \Swift_Message::newInstance()
            ->setSubject($this->subject)
            ->setFrom('no-reply@nao.fr')
            ->setTo($this->adminEmail)
            ->setBody($this->body, 'text/html')
        ;

        $this->mailer->send($message);
    }


}