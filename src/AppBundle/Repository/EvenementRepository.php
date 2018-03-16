<?php

namespace AppBundle\Repository;

/**
 * Class EvenementRepository
 * @package AppBundle\Repository
 */
class EvenementRepository extends \Doctrine\ORM\EntityRepository
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
                    . 'FROM AppBundle:Evenement e '
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
                    . 'FROM AppBundle:Evenement e '
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
     * @return mixed
     */
    public function findProchain()
    {
        return $this
            ->getEntityManager()
            ->createQuery('SELECT e '
                . 'FROM AppBundle:Evenement e '
                . 'WHERE e.annule = :annule '
                . 'AND e.affiche = :affiche '
                . 'AND e.dateDebut > :dateDebut '
                . 'AND e.datePublication <= :datePublication '
                . 'ORDER BY e.dateDebut ASC ')
            ->setParameters([
                'annule' => false,
                'affiche' => true,
                'dateDebut' => date("Y-m-d H:i:s"),
                'datePublication' => date("Y-m-d H:i:s")
            ])
            ->setMaxResults(1)
            ->getResult();
    }

    /**
     * @param $limit
     * @return mixed
     */
    public function findDernier($limit)
    {
        return $this
            ->getEntityManager()
            ->createQuery('SELECT e '
                . 'FROM AppBundle:Evenement e '
                . 'WHERE e.annule = :annule '
                . 'AND e.affiche = :affiche '
                . 'AND e.dateDebut <= :dateDebut '
                . 'AND e.datePublication <= :datePublication '
                . 'ORDER BY e.dateFin DESC ')
            ->setParameters([
                'annule' => false,
                'affiche' => true,
                'dateDebut' => date("Y-m-d H:i:s"),
                'datePublication' => date("Y-m-d H:i:s")
            ])
            ->setMaxResults($limit)
            ->getResult();
    }
}
