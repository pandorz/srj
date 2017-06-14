<?php

namespace AppBundle\Repository;

/**
 * ActualiteRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
/**
 * Class ActualiteRepository
 * @package AppBundle\Repository
 */
class ActualiteRepository extends \Doctrine\ORM\EntityRepository
{
    public function findAllValidOverOneMonth()
    {
        return $this
            ->getEntityManager()
            ->createQuery('SELECT e '
                . 'FROM AppBundle:Actualite e '
                . 'WHERE e.annule = :annule '
                . 'AND e.affiche = :affiche '
                . 'AND e.dateFin >= :dateFin '
                . 'ORDER BY e.dateDebut DESC')
            ->setParameters([
                'annule'  => false,
                'affiche' => true,
                'dateFin' => date("Y-m-d",strtotime("-1 month"))
            ])
            ->getResult();
    }
}
