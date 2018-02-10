<?php

namespace AppBundle\Repository;

/**
 * Class KouryukaiRepository
 * @package AppBundle\Repository
 */
class KouryukaiRepository extends \Doctrine\ORM\EntityRepository
{
    public function findAllValidOverOneMonth($admin = false)
    {
        if ($admin) {
            $query = $this
            ->getEntityManager()
            ->createQuery('SELECT e '
                . 'FROM AppBundle:Kouryukai e '
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
                . 'FROM AppBundle:Kouryukai e '
                . 'WHERE e.annule = :annule '
                . 'AND e.affiche = :affiche '
                . 'AND e.date >= :date '
                . 'AND e.datePublication <= :datePublication '
                . 'ORDER BY e.date DESC')
            ->setParameters([
                'annule'  => false,
                'affiche' => true,
                'date'    => date("Y-m-d",strtotime("-1 month")),
                'datePublication' => date("Y-m-d H:i:s")
            ]);
        }
        return $query->getResult();
    }

    public function getTop($limit)
    {
        return $this
            ->getEntityManager()
            ->createQuery('SELECT e '
                . 'FROM AppBundle:Kouryukai e '
                . 'WHERE e.annule = :annule '
                . 'AND e.affiche = :affiche '
                . 'AND e.datePublication <= :datePublication '
                . 'ORDER BY e.date DESC')
            ->setParameters([
                'annule'  => false,
                'affiche' => true,
                'datePublication' => date("Y-m-d H:i:s")
            ])
            ->setMaxResults($limit)
            ->getResult();
    }

    public function findProchain()
    {
        return $this
            ->getEntityManager()
            ->createQuery('SELECT e '
                . 'FROM AppBundle:Kouryukai e '
                . 'WHERE e.annule = :annule '
                . 'AND e.affiche = :affiche '
                . 'AND e.date > :dateDebut '
                . 'AND e.datePublication <= :datePublication '
                . 'ORDER BY e.date ASC ')
            ->setParameters([
                'annule'  => false,
                'affiche' => true,
                'dateDebut' => date("Y-m-d H:i:s"),
                'datePublication' => date("Y-m-d H:i:s")
            ])
            ->setMaxResults(1)
            ->getResult();
    }

    public function findDernier($limit)
    {
        return $this
            ->getEntityManager()
            ->createQuery('SELECT e '
                . 'FROM AppBundle:Kouryukai e '
                . 'WHERE e.annule = :annule '
                . 'AND e.affiche = :affiche '
                . 'AND e.date <= :dateDebut '
                . 'AND e.datePublication <= :datePublication '
                . 'ORDER BY e.date DESC ')
            ->setParameters([
                'annule'  => false,
                'affiche' => true,
                'dateDebut' => date("Y-m-d H:i:s"),
                'datePublication' => date("Y-m-d H:i:s")
            ])
            ->setMaxResults($limit)
            ->getResult();
    }
}