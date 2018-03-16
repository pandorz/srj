<?php

namespace AppBundle\Service;

use AppBundle\Entity\Atelier;
use AppBundle\Entity\Evenement;
use AppBundle\Entity\Kouryukai;
use AppBundle\Entity\Sortie;
use Doctrine\ORM\EntityManager;

class FrontCalendar
{
    /**
     * @var EntityManager
     */
    private $em;

    const FORMAT_DATE = 'Y-m-d';

    /**
     * GenerateCalendar constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @return array
     */
    public function getDates()
    {
        $data       = [];
        $evenements = $this->em
            ->getRepository(Evenement::class)
            ->findAllValidOverOneMonth();

        foreach ($evenements as $evenement) {
            $start = $evenement->getDateDebut();
            $end   = $evenement->getDateFin();

            if (!is_null($start)) {
                $start = $start->format(self::FORMAT_DATE);
            }

            if (!is_null($end)) {
                $end = $end->format(self::FORMAT_DATE);
            }

            $data[] = [
                'title' => $evenement->getNom(),
                'start' => $start,
                'end'   => $end
            ];
        }

        $ateliers= $this->em
            ->getRepository(Atelier::class)
            ->findAllValidOverOneMonth();

        foreach ($ateliers as $atelier) {
            $start = $atelier->getDate();

            if (!is_null($start)) {
                $start = $start->format(self::FORMAT_DATE);
            }

            $data_temp = [
                'title' => $atelier->getNom(),
                'start' => $start
            ];

            if (!empty($atelier->getUrlInscription())) {
                $data_temp['url'] = $atelier->getUrlInscription();
            }
            $data[] = $data_temp;
        }

        $kouryukai= $this->em
            ->getRepository(Kouryukai::class)
            ->findAllValidOverOneMonth();

        foreach ($kouryukai as $k) {
            $start = $k->getDate();

            if (!is_null($start)) {
                $start = $start->format(self::FORMAT_DATE);
            }

            $data_temp = [
                'title' => $k->getNom(),
                'start' => $start
            ];

            if (!empty($k->getUrlInscription())) {
                $data_temp['url'] = $k->getUrlInscription();
            }
            $data[] = $data_temp;
        }

        $sorties = $this->em
            ->getRepository(Sortie::class)
            ->findAllValidOverOneMonth();

        foreach ($sorties as $sortie) {
            $start = $sortie->getDate();

            if (!is_null($start)) {
                $start = $start->format(self::FORMAT_DATE);
            }

            $data_temp = [
                'title' => $sortie->getNom(),
                'start' => $start
            ];

            if (!empty($sortie->getUrlInscription())) {
                $data_temp['url'] = $sortie->getUrlInscription();
            }
            $data[] = $data_temp;
        }

        return $data;
    }
}
