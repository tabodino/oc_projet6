<?php

namespace OC\CoreBundle\EntityManager;


use Doctrine\ORM\EntityManager;

class TaxrefManager
{
    protected $em;

    /**
     * TaxrefManager constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * Retourne tous les enregistrements de la table taxref
     * @return array
     */
    public function getAll()
    {
        return $this->getRepository()->findAll();
    }

    public function find($id)
    {
        return $this->getRepository()->find($id);
    }

    /**
     * Retourne tous les ordres de la table taxref
     * @return mixed
     */
    public function getAllOrderTaxref()
    {
        return $this->getRepository()->getAllOrderTaxref();
    }

    public function getSpeciesById($id)
    {
        return $this->getRepository()->getSpeciesById($id);
    }

    /**
     * Retourne tous les especes de l'ordre passé en paramètre
     * @param $order
     * @return array
     */
    public function getTaxrefSpeciesByOrder($order)
    {
        return $this->getRepository()->getTaxrefSpeciesByOrder($order);
    }

    /**
     * @param $keyword
     * @return mixed
     */
    public function searchSpecies($keyword)
    {
        return $this->getRepository()->searchSpecies($keyword);
    }

    /**
     * @return mixed
     */
    public function countAllTaxref()
    {
        return $this->getRepository()->countAllTaxref();
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getRepository()
    {
        return $this->em->getRepository('OCCoreBundle:Taxref');
    }
}