<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Cour;

/**
 * Class CourReportRepository
 * @package AppBundle\Repository
 */
class CourReportRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @param Cour $cour
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     * @return mixed
     */
    public function findBetweenByCour(Cour $cour, \DateTime $startDate, \DateTime $endDate)
    {
        return $this
        ->getEntityManager()
        ->createQuery('SELECT e '
            . 'FROM AppBundle:CourReport e '
            . 'WHERE e.dateAnnule <= :endDate '
            . 'AND e.dateAnnule >= :startDate'
            . 'AND e.cours = :cour')
        ->setParameters([
            'startDate' => $startDate->format("Y-m-d"),
            'endDate'   => $endDate->format("Y-m-d"),
            'cours'     => $cour
        ])
        ->getResult();
    }
}
