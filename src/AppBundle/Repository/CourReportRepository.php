<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Cour;

/**
 * Class CourReportRepository
 * @package AppBundle\Repository
 */
class CourReportRepository extends \Doctrine\ORM\EntityRepository
{
    public function findBetweenByCour(int $idCour, \DateTime $startDate, \DateTime $endDate)
    {
        // TODO
    }
}
