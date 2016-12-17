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

    /**
     * @param $keyword
     * @return array
     */
    public function searchSpecies($keyword)
    {
        $qb = $this->createQueryBuilder('s')
            ->select('s')
            ->where('s.ordre LIKE :keyword ')
            ->orWhere('s.famille LIKE :keyword')
            ->orWhere('s.cdNom LIKE :keyword')
            ->orWhere('s.cdTaxsup LIKE :keyword')
            ->orWhere('s.lbNom LIKE :keyword')
            ->orWhere('s.nomComplet LIKE :keyword')
            ->orWhere('s.nomValide LIKE :keyword')
            ->orWhere('s.nomVern LIKE :keyword')
            ->orWhere('s.nomVernEng LIKE :keyword')
            ->setParameter('keyword', $keyword.'%')
            ->setMaxResults(15)
        ;

        return $qb->getQuery()->getResult();
    }

    /**
     * @param $id
     * @return array
     */
    public function getSpeciesById($id)
    {
        $qb = $this->createQueryBuilder('t')
           // ->select('t', 'r.nom', 's.nom as status')

           /* ->select('t', 'r.nom', 's.nom as status')*/
            ->join(
                'OC\CoreBundle\Entity\Rang',
                'r',
                \Doctrine\ORM\Query\Expr\Join::WITH,
                't.rang = r.rang'
            )
            //->leftJoin('OC\CoreBundle\Entity\Statuts','s',\Doctrine\ORM\Query\Expr\Join::WITH,'t.nc = s.lettre')
           // ->leftJoin('OC\CoreBundle\Entity\Statuts','s')
           // ->where('t.fr = s.lettre')
           /* ->orWhere('t.mar = s.lettre')
            ->orWhere('t.gf = s.lettre')
            ->orWhere('t.mar = s.lettre')
            ->orWhere('t.gua = s.lettre')
            ->orWhere('t.sm = s.lettre')
            ->orWhere('t.sb = s.lettre')
            ->orWhere('t.spm = s.lettre')
            ->orWhere('t.may = s.lettre')
            ->orWhere('t.reu = s.lettre')
            ->orWhere('t.taaf = s.lettre')
            ->orWhere('t.nc = s.lettre')
            ->orWhere('t.wf = s.lettre')
            ->orWhere('t.pf = s.lettre')*/

            ->andWhere('t.id = :id')
            ->setParameter('id', $id)
        ;

        return $qb->getQuery()->getScalarResult();
    }

    /**
     * @return mixed
     */
    public function countAllTaxref()
    {
        $qb = $this->createQueryBuilder('t')
            ->select('COUNT(t)')
        ;

        return $qb->getQuery()->getSingleScalarResult();
    }

}