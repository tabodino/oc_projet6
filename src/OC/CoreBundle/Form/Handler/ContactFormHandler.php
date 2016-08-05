<?php

namespace OC\CoreBundle\Form\Handler;

use Symfony\Component\Form\Form;
use OC\CoreBundle\Services\Mailer;
use Symfony\Component\HttpFoundation\Request;

class ContactFormHandler
{
    protected $form;
    protected $request;
    protected $mailer;

    public function __construct(Form $form, Request $request, Mailer $mailer)
    {
        $this->form = $form;
        $this->request = $request;
        $this->mailer = $mailer;
    }

    public function process()
    {
        if ($this->request->isMethod('post')) {

            $contact = $this->request->get('contact');
            
            $this->onSuccess($contact);

            $this->request->getSession()
                ->getFlashBag()
                ->add('send', true)
            ;

            return true;
        }

        return false;
    }

    public function onSuccess($contact)
    {
        $this->mailer->contactConfirm($contact);
    }

    /**
     * @return Form
     */
    public function getForm()
    {
        return $this->form;
    }
}