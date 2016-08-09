<?php

namespace OC\BackBundle\Form\Handler;


use Doctrine\ORM\EntityManager;
use OC\BackBundle\Entity\Observation;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class ObservationFormHandler
{
    protected $form;
    protected $request;
    protected $em;
    protected $observation;

    public function __construct(Form $form, Request $request, EntityManager $em, Observation $observation)
    {
        $this->form = $form;
        $this->request = $request;
        $this->em = $em;
        $this->observation = $observation;

    }

    public function process()
    {
        $this->form->handleRequest($this->request);

        if ($this->request->isMethod('post') && $this->form->isValid()) {
            $this->onSuccess();

            return true;
        }

        return false;
    }

    public function onSuccess()
    {
        $this->observation = $this->form->getData();

        $this->em->persist($this->observation);

        $this->em->flush();
    }

    /**
     * @return Form
     */
    public function getForm()
    {
        return $this->form;
    }
}