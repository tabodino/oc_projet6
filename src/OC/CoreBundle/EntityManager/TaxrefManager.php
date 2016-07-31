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

    /**
     * Retourne tous les ordres de la table taxref
     * @return mixed
     */
    public function getAllOrderTaxref()
    {
        return $this->getRepository()->getAllOrderTaxref();
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
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getRepository()
    {
        return $this->em->getRepository('OCCoreBundle:Taxref');
    }
}