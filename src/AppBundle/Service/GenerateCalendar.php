<?php

namespace AppBundle\Service;

use AppBundle\Entity\Cour;
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


    private function makeReccurence(int $repetition, int $day, \DateTime $startDate)
    {
        // TODO
        /**
         * "recurrence": [
        "EXDATE;VALUE=DATE:20150610",
        "RDATE;VALUE=DATE:20150609,20150611",
        "RRULE:FREQ=DAILY;UNTIL=20150628;INTERVAL=3"
        ],

         */
        // RRULE:FREQ=WEEKLY;INTERVAL=2;UNTIL=20110701T170000Z;BYDAY=TU,FR
    }

    private function generateHolidays(\DateTime $startDate)
    {
        // TODO
        // "EXDATE;VALUE=DATE:20150610"
    }

    private function generateReportDate(Cour $cour)
    {
        // TODO
        //"RDATE;VALUE=DATE:20150609,20150611"
    }
}