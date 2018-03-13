<?php

namespace AppBundle\Repository;

/**
 * Class CongeRepository
 * @package AppBundle\Repository
 */
class CongeRepository extends \Doctrine\ORM\EntityRepository
{

    public function findBetween(\DateTime $startDate, \DateTime $endDate)
    {
        // TODO
    }
}
