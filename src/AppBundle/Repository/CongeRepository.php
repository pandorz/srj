<?php

namespace AppBundle\Repository;

/**
 * Class CongeRepository
 * @package AppBundle\Repository
 */
class CongeRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     * @return mixed
     */
    public function findBetween(\DateTime $startDate, \DateTime $endDate)
    {
        return $this
            ->getEntityManager()
            ->createQuery('SELECT e '
                . 'FROM AppBundle:Conge e '
                . 'WHERE e.dateFin <= :endDate '
                . 'AND e.dateDebut >= :startDate')
            ->setParameters([
                'startDate' => $startDate->format("Y-m-d"),
                'endDate'   => $endDate->format("Y-m-d")
            ])
            ->getResult();
    }
}
