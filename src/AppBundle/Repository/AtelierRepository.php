<?php

namespace AppBundle\Repository;

/**
 * Class AtelierRepository
 * @package AppBundle\Repository
 */
class AtelierRepository extends \Doctrine\ORM\EntityRepository
{
    public function findAllValidOverOneMonth($admin = false)
    {
        if ($admin) {
            $query = $this
            ->getEntityManager()
            ->createQuery('SELECT e '
                . 'FROM AppBundle:Atelier e '
                . 'WHERE e.annule = :annule '
                . 'AND e.date >= :date '
                . 'ORDER BY e.date DESC')
            ->setParameters([
                'annule'  => false,
                'date'    => date("Y-m-d",strtotime("-1 month")),
            ]);
        } else {
            $query = $this
            ->getEntityManager()
            ->createQuery('SELECT e '
                . 'FROM AppBundle:Atelier e '
                . 'WHERE e.annule = :annule '
                . 'AND e.affiche = :affiche '
                . 'AND e.date >= :date '
                . 'AND e.datePublication <= :datePublication '
                . 'ORDER BY e.date DESC')
            ->setParameters([
                'annule'  => false,
                'affiche' => true,
                'date'    => date("Y-m-d",strtotime("-1 month")),
                'datePublication' => date("Y-m-d")
            ]);
        }
        return $query->getResult();
    }

    public function getTop($limit)
    {
        return $this
            ->getEntityManager()
            ->createQuery('SELECT e '
                . 'FROM AppBundle:Atelier e '
                . 'WHERE e.annule = :annule '
                . 'AND e.affiche = :affiche '
                . 'AND e.datePublication <= :datePublication '
                . 'ORDER BY e.date DESC')
            ->setParameters([
                'annule'  => false,
                'affiche' => true,
                'datePublication' => date("Y-m-d")
            ])
            ->setMaxResults($limit)
            ->getResult();
    }
}