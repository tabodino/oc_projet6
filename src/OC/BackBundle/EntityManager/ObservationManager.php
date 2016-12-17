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

    public function findValidatedObservation($id)
    {
        $observation = $this->getRepository()->findValidatedObservation($id);

        if (!$observation) throw $this->createNotFoundException('Observation non trouvée');

        return $observation;
    }

    public function getUnvalidatedObservation()
    {
        $observations = $this->getRepository()->getUnvalidatedObservation();
        //if (!$observations) throw $this->createNotFoundException('Observations non trouvées');

        return $observations;
    }

    public function getValidatedObservation()
    {
        $observations = $this->getRepository()->getValidatedObservation();
        if (!$observations) throw $this->createNotFoundException('Observations non trouvées');

        return $observations;
    }

    public function getAllOrderTaxref()
    {
        $orders = $this->em->getRepository('OCCoreBundle:Taxref')->getAllOrderTaxref();

        return $orders;
    }


    public function searchObservation($keyword)
    {
        $observations = $this->getRepository()->searchObservation($keyword);
        //if (!$observations) throw $this->createNotFoundException('Observations non trouvées');

        return $observations;
    }

    public function countAllObservations()
    {
        return $this->getRepository()->countAllObservations();
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