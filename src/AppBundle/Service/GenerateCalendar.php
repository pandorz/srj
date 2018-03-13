<?php

namespace AppBundle\Service;

use AppBundle\Entity\Conge;
use AppBundle\Entity\Cour;
use AppBundle\Entity\CourDate;
use AppBundle\Entity\CourReport;
use Doctrine\ORM\EntityManager;

class GenerateCalendar
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var GoogleCalendar
     */
    private $googleCalendar;

    const GOOGLE_DATE_FORMAT= 'Ymd';

    /**
     * GenerateCalendar constructor.
     * @param EntityManager $em
     * @param GoogleCalendar $googleCalendar
     */
    public function __construct(EntityManager $em, GoogleCalendar $googleCalendar)
    {
        $this->em               = $em;
        $this->googleCalendar   = $googleCalendar;
    }

    /**
     * @param Cour $cour
     * @return bool
     */
    public function newCalendar(Cour $cour)
    {
        if (!empty($cour->getDates())) {
            try {
                $calendarId = $this->googleCalendar->getCalendarIdBySummary($cour->getSlug());

                if (empty($calendarId)) {
                    $calendar = $this->googleCalendar->createCalendar($cour->getSlug());
                    $calendarId = $calendar->getId();
                }

                $this->googleCalendar->clearCalendar($calendarId);

                /** @var CourDate $courDate */
                foreach ($cour->getDates() as $courDate) {
                    $startDate = $courDate->getDate();
                    $endDate = (is_null($courDate->getDateFin()) ? $courDate->getDate() : $courDate->getDateFin());

                    $reccurence = $this->makeReccurence(
                        $cour,
                        $courDate->getRepetition(),
                        $courDate->getJour(),
                        $startDate,
                        $endDate
                    );

                    $event = $this->googleCalendar->newEvent(
                        $courDate->getNom(),
                        $startDate,
                        $endDate,
                        $cour->getTitre(),
                        $reccurence
                    );

                    $this->googleCalendar->createEvent($calendarId, $event);
                }

                return true;
            } catch (\Exception $e) {
                return false;
            }
        }
    }

    /**
     * @param Cour $cour
     * @param int $repetition
     * @param int $day
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     * @return mixed
     */
    private function makeReccurence(Cour $cour, int $repetition, int $day, \DateTime $startDate, \DateTime $endDate)
    {
        $tabReccurence['recurrence'] = [];

        if ($repetition == 0) {
            return $tabReccurence;
        }

        $holydaysDates = $this->generateHolidays($startDate, $endDate);
        if (!empty($holydaysDates)) {
            $tabReccurence['recurrence'][] = $holydaysDates;
        }

        $reportsDates  = $this->generateReportDate($cour, $startDate, $endDate);
        if (!empty($reportsDates)) {
            $tabReccurence['recurrence'][] = $reportsDates;
        }

        $tabReccurence['recurrence'][] =  "RRULE:FREQ=WEEKLY;INTERVAL=".$repetition.
            ";UNTIL=".$endDate->format(self::GOOGLE_DATE_FORMAT).";BYDAY=".$this->getCodeDayByW($day);

        return $tabReccurence;
    }

    /**
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     * @return string
     */
    private function generateHolidays(\DateTime $startDate, \DateTime $endDate)
    {
        $holidaysDates = $this->em
            ->getRepository(Conge::class)
            ->findBetween($startDate, $endDate);

        if (!empty($holidaysDates)) {
            $stringholidaysDate = "";

            /** @var Conge $holidaysDate */
            foreach ($holidaysDates as $holidaysDate) {
                if (!empty($stringholidaysDate)) {
                    $stringholidaysDate.=",";
                }

                if ($holidaysDate->getDateDebut() == $holidaysDate->getDateFin()) {
                    $stringholidaysDate.= $holidaysDate->getDateDebut()->format(self::GOOGLE_DATE_FORMAT);
                } else {
                    $stringholidaysDate.= $this->getAlldaysBetween(
                        $holidaysDate->getDateDebut(),
                        $holidaysDate->getDateFin()
                    );
                }
            }

            return "EXDATE;VALUE=DATE:".$stringholidaysDate;
        }

        return "";
    }

    /**
     * @param Cour $cour
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     * @return string
     */
    private function generateReportDate(Cour $cour, \DateTime $startDate, \DateTime $endDate)
    {
        $reports = $this->em
            ->getRepository(CourReport::class)
            ->findBetweenByCour($cour, $startDate, $endDate);

        if (!empty($reports)) {
            $stringReportDates = "";

            /** @var CourReport $report */
            foreach ($reports as $report) {
                if (!empty($stringReportDates)) {
                    $stringReportDates.=",";
                }
                $stringReportDates.=$report->getDateReport()->format(self::GOOGLE_DATE_FORMAT);
            }

            return "RDATE;VALUE=DATE:".$stringReportDates;
        }

        return "";
    }

    /**
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     * @return string
     */
    private function getAlldaysBetween(\DateTime $startDate, \DateTime $endDate)
    {
        $stringAllDaysBetween = "";
        while ($startDate <= $endDate) {
            if (!empty($stringAllDaysBetween)) {
                $stringAllDaysBetween.= ",";
            }
            $stringAllDaysBetween.= $startDate->format(self::GOOGLE_DATE_FORMAT);
            $startDate->modify('+1 day');
        }

        return $stringAllDaysBetween;
    }

    /**
     * @param int $wDay
     * @return string
     */
    private function getCodeDayByW(int $wDay)
    {
        $string = '';
        switch ($wDay) {
            case 0:
                $string = 'SU';
                break;
            case 1:
                $string = 'MO';
                break;
            case 2:
                $string = 'TU';
                break;
            case 3:
                $string = 'WE';
                break;
            case 4:
                $string = 'TH';
                break;
            case 5:
                $string = 'FR';
                break;
            case 6:
                $string = 'SA';
                break;
        }

        return $string;
    }
}