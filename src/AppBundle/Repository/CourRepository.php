<?php

namespace AppBundle\Repository;

/**
 * Class CourRepository
 * @package AppBundle\Repository
 */
class CourRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @return mixed
     */
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
                'datePublication' => date("Y-m-d H:i:s")
            ])
            ->getResult();
    }
}
