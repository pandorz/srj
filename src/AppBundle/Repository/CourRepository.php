<?php

namespace AppBundle\Repository;

/**
 * Class CourRepository
 * @package AppBundle\Repository
 */
class CourRepository extends \Doctrine\ORM\EntityRepository
{
    public function getAffichable()
    {
        return $this
            ->getEntityManager()
            ->createQuery('SELECT e '
                . 'FROM AppBundle:Cour e '
                . 'WHERE e.affiche = :affiche '
                . 'AND e.datePublication <= :datePublication ')
            ->setParameters([
                'affiche' => true,
                'datePublication' => date("Y-m-d")
            ])
            ->getResult();
    }
}
