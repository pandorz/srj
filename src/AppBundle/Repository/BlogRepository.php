<?php

namespace AppBundle\Repository;

/**
 * Class BlogRepository
 * @package AppBundle\Repository
 */
class BlogRepository extends \Doctrine\ORM\EntityRepository
{
    public function findAllValidOverOneMonth($admin = false)
    {
        if ($admin) {
            $query = $this
                ->getEntityManager()
                ->createQuery('SELECT e '
                    . 'FROM AppBundle:Blog e '
                    . 'WHERE e.timestampCreation >= :dateFin '
                    . 'ORDER BY e.timestampCreation DESC')
                ->setParameter('dateFin', date("Y-m-d",strtotime("-1 month")));
        } else {
            $query = $this
                ->getEntityManager()
                ->createQuery('SELECT e '
                    . 'FROM AppBundle:Blog e '
                    . 'WHERE e.affiche = :affiche '
                    . 'AND e.datePublication <= :datePublication '
                    . 'AND e.timestampCreation >= :dateFin '
                    . 'ORDER BY e.timestampCreation DESC')
                ->setParameters([
                    'affiche' => true,
                    'datePublication' => date("Y-m-d"),
                    'dateFin' => date("Y-m-d",strtotime("-1 month"))
                ]);
        }
        return $query->getResult();
    }

    public function getTop($limit)
    {
        return $this
            ->getEntityManager()
            ->createQuery('SELECT e '
                . 'FROM AppBundle:Blog e '
                . 'WHERE e.affiche = :affiche '
                . 'AND e.datePublication <= :datePublication '
                . 'ORDER BY e.timestampCreation DESC')
            ->setParameters([
                'affiche' => true,
                'datePublication' => date("Y-m-d")
            ])
            ->setMaxResults($limit)
            ->getResult();
    }
}
