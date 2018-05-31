<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Blog;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Application\Sonata\MediaBundle\Entity\Media;

/**
 * Class BlogRepository
 * @package AppBundle\Repository
 */
class BlogRepository extends \Doctrine\ORM\EntityRepository
{

    /**
     * @param Blog $blog
     * @return mixed
     */
    public function getNext(Blog $blog)
    {
        return $this
            ->getEntityManager()
            ->createQuery('SELECT e '
                . 'FROM AppBundle:Blog e '
                . 'WHERE e.affiche = :affiche '
                . 'AND e.datePublication >= :datePublication '
                . 'AND e.id != :idStart '
                . 'ORDER BY e.datePublication DESC')
            ->setParameters([
                'affiche'           => true,
                'datePublication'   => $blog->getDatePublication()->format("Y-m-d H:i:s"),
                'idStart'           => $blog->getId()
            ])
            ->setMaxResults(1)
            ->getResult();
    }

    /**
     * @param Blog $blog
     * @return mixed
     */
    public function getPrevious(Blog $blog)
    {
        return $this
            ->getEntityManager()
            ->createQuery('SELECT e '
                . 'FROM AppBundle:Blog e '
                . 'WHERE e.affiche = :affiche '
                . 'AND e.datePublication <= :datePublication '
                . 'AND e.id != :idStart '
                . 'ORDER BY e.datePublication DESC')
            ->setParameters([
                'affiche'           => true,
                'datePublication'   => $blog->getDatePublication()->format("Y-m-d H:i:s"),
                'idStart'           => $blog->getId()
            ])
            ->setMaxResults(1)
            ->getResult();
    }


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
                    . 'FROM AppBundle:Blog e '
                    . 'WHERE e.timestampCreation >= :dateFin '
                    . 'ORDER BY e.datePublication DESC')
                ->setParameter('dateFin', date("Y-m-d", strtotime("-1 month")));
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
                    'datePublication' => date("Y-m-d H:i:s"),
                    'dateFin' => date("Y-m-d", strtotime("-1 month"))
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
                . 'FROM AppBundle:Blog e '
                . 'WHERE e.affiche = :affiche '
                . 'AND e.datePublication <= :datePublication '
                . 'ORDER BY e.datePublication DESC')
            ->setParameters([
                'affiche' => true,
                'datePublication' => date("Y-m-d H:i:s")
            ])
            ->setMaxResults($limit)
            ->getResult();
    }

    /**
     * @param $slugTag
     * @param $limit
     * @return mixed
     */
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
            . "ORDER BY b.date_publication DESC"
            . (is_null($limit)?'':' LIMIT :limit');


        $rsm = new ResultSetMappingBuilder($this->getEntityManager());
        $rsm->addEntityResult(Blog::class, "b");

        foreach ($this->getClassMetadata()->fieldMappings as $obj) {
            $rsm->addFieldResult("b", $obj["columnName"], $obj["fieldName"]);
        }

        $stmt = $this->getEntityManager()->createNativeQuery($sql, $rsm);

        $stmt->setParameter(":affiche", true);
        $stmt->setParameter(":slug", $slugTag);
        $stmt->setParameter(":datePublication", date("Y-m-d H:i:s"));
        if (!is_null($limit)) {
            $stmt->setParameter(":limit", $limit);
        }

        $stmt->execute();

        return $stmt->getResult();
    }

    /**
     * @param $idBlog
     * @return mixed
     */
    public function findMedia($idBlog)
    {
        $sql = "SELECT m.* "
            . "FROM media__media AS m "
            . "INNER JOIN blog u ON u.image_id=m.id "
            . "WHERE u.id=:idBlog";


        $rsm = new ResultSetMappingBuilder($this->getEntityManager());
        $rsm->addEntityResult(Media::class, "m");

        foreach ($this->getClassMetadata()->fieldMappings as $obj) {
            $rsm->addFieldResult("m", $obj["columnName"], $obj["fieldName"]);
        }

        $stmt = $this->getEntityManager()->createNativeQuery($sql, $rsm);

        $stmt->setParameter(":idBlog", $idBlog);

        $stmt->execute();

        return $stmt->getResult();
    }
}
