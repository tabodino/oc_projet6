<?php

namespace OC\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;

class TaxrefRepository extends EntityRepository
{
    /**
     * Retourne tous les ordres de la table Taxref
     * @return array
     */
    public function getAllOrderTaxref()
    {
        $qb = $this->createQueryBuilder('t')
            ->select('t.ordre')
            ->distinct('t.ordre')
            ->addOrderBy('t.ordre', 'ASC');

        return $qb->getQuery()->getResult();
    }

    /**
     * Retourne tous les especes de l'ordre passé en paramètre
     * @param $order
     * @return array
     */
    public function getTaxrefSpeciesByOrder($order)
    {
        $qb = $this->createQueryBuilder('t')
            ->select('t')
            ->where('t.ordre = :ordre')
            ->setParameter('ordre', $order)
            ->addOrderBy('t.ordre', 'ASC');

        return $qb->getQuery()->getResult();
    }

}