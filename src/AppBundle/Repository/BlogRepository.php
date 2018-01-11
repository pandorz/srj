<?php

namespace AppBundle\Repository;
use AppBundle\Entity\Blog;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

/**
 * Class BlogRepository
 * @package AppBundle\Repository
 */
class BlogRepository extends \Doctrine\ORM\EntityRepository
{
    // TODO
    public function findAllValidOverOneMonth($admin = false)
    {
        if ($admin) {
            $query = $this
                ->getEntityManager()
                ->createQuery('SELECT e '
                    . 'FROM AppBundle:Blog e '
                    . 'WHERE e.timestampCreation >= :dateFin '
                    . 'ORDER BY e.datePublication DESC')
                ->setParameter('dateFin', date("Y-m-d",strtotime("-1 month")));
        } else {
            $query = $this
                ->getEntityManager()
                ->createQuery('SELECT e '
                    . 'FROM AppBundle:Blog e '
                    . 'WHERE e.affiche = :affiche '
                    . 'AND e.datePublication <= :datePublication '
                    . 'AND e.timestampCreation >= :dateFin '
                    . 'ORDER BY e.datePublication DESC')
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

    public function findByTag($slugTag, $limit)
    {
        $table = $this->getClassMetadata()->table["name"];

        $sql =  "SELECT b.* "
            . "FROM ".$table." AS b "
            . "INNER JOIN blog_tags bt ON bt.blog_id=b.id "
            . "INNER JOIN tag t ON bt.tag_id=t.id "
            . "WHERE t.slug = :slug "
            . "AND b.affiche = :affiche "
            . "AND b.date_publication <= :datePublication "
            . "ORDER BY b.timestamp_creation DESC"
            . (is_null($limit)?'':' LIMIT :limit');


        $rsm = new ResultSetMappingBuilder($this->getEntityManager());
        $rsm->addEntityResult(Blog::class, "b");

        foreach ($this->getClassMetadata()->fieldMappings as $obj) {
            $rsm->addFieldResult("b", $obj["columnName"], $obj["fieldName"]);
        }

        $stmt = $this->getEntityManager()->createNativeQuery($sql, $rsm);

        $stmt->setParameter(":affiche", true);
        $stmt->setParameter(":slug", $slugTag);
        $stmt->setParameter(":datePublication",  date("Y-m-d"));
        if (!is_null($limit)) {
            $stmt->setParameter(":limit", $limit);
        }

        $stmt->execute();

        return $stmt->getResult();
    }
}
