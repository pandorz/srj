<?php

namespace AppBundle\Repository;

/**
 * Class EvenementRepository
 * @package AppBundle\Repository
 */
class EvenementRepository extends \Doctrine\ORM\EntityRepository
{
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
                'annule'  => false,
                'dateFin' => date("Y-m-d",strtotime("-1 month")),
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
                'annule'  => false,
                'affiche' => true,
                'dateFin' => date("Y-m-d",strtotime("-1 month")),
                'datePublication' => date("Y-m-d")
            ]);
        }
        return $query->getResult();
    }
    
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
                'annule'  => false,
                'affiche' => true,
                'dateDebut' => date("Y-m-d"),
                'datePublication' => date("Y-m-d")
            ])
            ->setMaxResults(1)
            ->getResult();
    }
    
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
                'annule'  => false,
                'affiche' => true,
                'dateDebut' => date("Y-m-d"),
                'datePublication' => date("Y-m-d")
            ])
            ->setMaxResults($limit)
            ->getResult();
    }
}
