<?php

namespace AppBundle\Repository;


/**
 * Class ActualiteRepository
 * @package AppBundle\Repository
 */
class ActualiteRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @param bool $admin
     * @return mixed
     */
    public function findAllValidOverOneMonth($admin = false)
    {
        if ($admin) {
            $query = $this
                ->getEntityManager()
                ->createQuery('SELECT e '
                    . 'FROM AppBundle:Actualite e '
                    . 'WHERE e.annule = :annule '
                    . 'AND e.dateFin >= :dateFin '
                    . 'ORDER BY e.dateDebut DESC')
                ->setParameters([
                    'annule' => false,
                    'dateFin' => date("Y-m-d", strtotime("-1 month")),
                ]);
        } else {
            $query = $this
                ->getEntityManager()
                ->createQuery('SELECT e '
                    . 'FROM AppBundle:Actualite e '
                    . 'WHERE e.annule = :annule '
                    . 'AND e.affiche = :affiche '
                    . 'AND e.dateFin >= :dateFin '
                    . 'AND e.datePublication <= :datePublication '
                    . 'ORDER BY e.dateDebut DESC')
                ->setParameters([
                    'annule' => false,
                    'affiche' => true,
                    'dateFin' => date("Y-m-d", strtotime("-1 month")),
                    'datePublication' => date("Y-m-d H:i:s")
                ]);
        }
        return $query->getResult();
    }

    /**
     * @param $limit
     * @return mixed
     */
    public function getTop($limit)
    {
        return $this
            ->getEntityManager()
            ->createQuery('SELECT e '
                . 'FROM AppBundle:Actualite e '
                . 'WHERE e.annule = :annule '
                . 'AND e.affiche = :affiche '
                . 'AND e.datePublication <= :datePublication '
                . 'ORDER BY e.dateDebut DESC')
            ->setParameters([
                'annule' => false,
                'affiche' => true,
                'datePublication' => date("Y-m-d H:i:s")
            ])
            ->setMaxResults($limit)
            ->getResult();
    }
}
