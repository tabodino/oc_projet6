<?php

namespace OC\BackBundle\EntityManager;

use Doctrine\ORM\EntityManager;

/**
 * Class ObservationManager
 * @package OC\BackBundle\EntityManager
 */
class ObservationManager
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * ObservationManager constructor.
     * @param EntityManager $em
     */
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
    /**
     * @param $id
     * @return null|object
     */
    public function find($id)
    {
        $observation = $this->getRepository()->find($id);
        if (!$observation) {
            throw $this->createNotFoundException('Observation non trouvée');
        }
        return $observation;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findValidatedObservation($id)
    {
        $observation = $this->getRepository()->findValidatedObservation($id);

        if (!$observation) throw $this->createNotFoundException('Observation non trouvée');

        return $observation;
    }

    /**
     * @return mixed
     */
    public function getUnvalidatedObservation()
    {
        $observations = $this->getRepository()->getUnvalidatedObservation();
        //if (!$observations) throw $this->createNotFoundException('Observations non trouvées');

        return $observations;
    }

    /**
     * @return mixed
     */
    public function getValidatedObservation()
    {
        $observations = $this->getRepository()->getValidatedObservation();
        if (!$observations) throw $this->createNotFoundException('Observations non trouvées');

        return $observations;
    }

    /**
     * @return mixed
     */
    public function getAllOrderTaxref()
    {
        $orders = $this->em->getRepository('OCCoreBundle:Taxref')->getAllOrderTaxref();

        return $orders;
    }

    /**
     * @param $keyword
     * @return mixed
     */
    public function searchObservation($keyword)
    {
        $observations = $this->getRepository()->searchObservation($keyword);
        //if (!$observations) throw $this->createNotFoundException('Observations non trouvées');

        return $observations;
    }

    /**
     * @param $userId
     * @return mixed
     */
    public function getUserObservations($userId)
    {
        return $this->getRepository()->getUserObservations($userId);
    }

    /**
     * @return mixed
     */
    public function countAllObservations()
    {
        return $this->getRepository()->countAllObservations();
    }

    /**
     * @return mixed
     */
    public function countInvalidatedObservations()
    {
        return $this->getRepository()->countInvalidatedObservations();
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