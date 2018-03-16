<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;

class Parameter
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * GenerateCalendar constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param $parametre
     * @return string
     */
    private function returnParametreValue($parametre)
    {
        if (!is_null($parametre) && !is_null($parametre->getValue())) {
            return $parametre->getValue();
        }
        return '';
    }

    /**
     * @param string $slug
     * @return string
     */
    public function getParamBySlug($slug)
    {
        $parametre = $this->em
            ->getRepository(\AppBundle\Entity\Parametre::class)
            ->findOneBy(['slug' => $slug]);

        return $this->returnParametreValue($parametre);
    }
}
