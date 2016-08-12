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

    // Trouve un visiteur/reservation
    public function find($id)
    {
        $observation = $this->getRepository()->find($id);
        if (!$observation) {
            throw $this->createNotFoundException('Observation non trouvée');
        }
        return $observation;
    }

    /**
     *
     * Supprime une observation
     */
    public function remove($id)
    {
        $this->em->remove($this->find($id));
        $this->em->flush();
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getRepository()
    {
        return $this->em->getRepository('OCBackBundle:Observation');
    }
}