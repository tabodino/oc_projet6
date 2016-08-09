<?php

namespace OC\BackBundle\EntityManager;

use Doctrine\ORM\EntityManager;

class ObservationManager
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * Retourne tous les enregistrements de la table observation
     * @return array
     */
    public function getAll()
    {
        return $this->getRepository()->findAll();
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getRepository()
    {
        return $this->em->getRepository('OCBackBundle:Observation');
    }
}