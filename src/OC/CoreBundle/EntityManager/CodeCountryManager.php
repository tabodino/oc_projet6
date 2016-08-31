<?php

namespace OC\CoreBundle\EntityManager;

use Doctrine\ORM\EntityManager;

class CodeCountryManager
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
     * Retourne tous les enregistrements de la table code_country
     * @return array
     */
    public function findAll()
    {
        return $this->getRepository()->findAll();
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getRepository()
    {
        return $this->em->getRepository('OCCoreBundle:CodeCountry');
    }
}