<?php

namespace OC\BackBundle\Repository;

/**
 * ObservationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ObservationRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @return array
     */
    public function getUnvalidatedObservation()
    {
        $qb = $this->createQueryBuilder('o')
            ->select('o')
            ->where('o.validated = 0')
        ;

        return $qb->getQuery()->getResult();
    }

    /**
     * @return array
     */
    public function getValidatedObservation()
    {
        $qb = $this->createQueryBuilder('o')
            ->select('o')
            ->where('o.validated = 1')
        ;

        return $qb->getQuery()->getResult();
    }

    /**
     * @param $id
     * @return array
     */
    public function findValidatedObservation($id)
    {
        $qb = $this->createQueryBuilder('o')
            ->select('o')
            ->where('o.validated = 1')
            ->andWhere('o.id = :id')
            ->setParameter('id', $id)
        ;

        return $qb->getQuery()->getResult();
    }

    /**
     * @param $keyword
     * @return array
     */
    public function searchObservation($keyword)
    {
        $qb = $this->createQueryBuilder('o')
            ->select('o')
            ->where('o.validated = 1')
            ->andWhere('o.title LIKE :keyword')
            ->orWhere('o.dsc LIKE :keyword')
            ->setParameter('keyword', $keyword.'%')
            ->setMaxResults(20)
        ;

        return $qb->getQuery()->getResult();
    }

    /**
     * Get user observations
     * @param $userId
     * @return array
     */
    public function getUserObservations($userId)
    {
        $qb = $this->createQueryBuilder('o')
            ->select('o')
            ->where('o.user = :userId')
            ->setParameter('userId', $userId);

        return $qb->getQuery()->getResult();
    }

    /**
     * @return mixed
     */
    public function countAllObservations()
    {
        $qb = $this->createQueryBuilder('o')
            ->select('COUNT(o)')
            ->where('o.validated = 1')
        ;

        return $qb->getQuery()->getSingleScalarResult();
    }

    /**
     * @return mixed
     */
    public function countInvalidatedObservations()
    {
        $qb = $this->createQueryBuilder('o')
            ->select('COUNT(o)')
            ->where('o.validated = 0')
        ;

        return $qb->getQuery()->getSingleScalarResult();
    }
}
