<?php

namespace OC\BackBundle\Form\Handler;


use Doctrine\ORM\EntityManager;
use OC\BackBundle\Entity\Observation;
use OC\BackBundle\Services\FileUploader;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class ObservationFormHandler
{
    protected $form;
    protected $request;
    protected $em;
    protected $observation;
    protected $user;

    public function __construct(Form $form, Request $request, EntityManager $em, Observation $observation, $user)
    {
        $this->form = $form;
        $this->request = $request;
        $this->em = $em;
        $this->observation = $observation;
        $this->user = $user;

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
        $observation = $this->form->getData();

        $observation->setUser($this->user);

        if ($this->user->hasRole("ROLE_NATURALISTE"))

            $observation->setValidated(1);

        $this->em->persist($observation);

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