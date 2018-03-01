<?php
namespace AppBundle\Service;

use Monolog\Logger;

class GoogleCalendar
{
    /**
     * @var string
     */
    private $applicationName;

    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var \Google_Client
     */
    private $client;

    /**
     * @var \Google_Service_Calendar
     */
    private $service;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var array
     */
    private $scopes;

    const TIMEZONE      = 'Europe/Paris';

    const TDATEFORMAT   = 'YmdTHis';

    public function __construct($applicationName, $apiKey, Logger $logger)
    {
        $this->applicationName  = $applicationName;
        $this->apiKey           = $apiKey;
        $this->logger           = $logger;
        $this->scopes           = ['https://www.googleapis.com/auth/calendar'];
        $this->setClient();
        $this->setService();
    }

    private function setClient()
    {
        $client         = new \Google_Client();
        $client->setApplicationName($this->applicationName);
        $client->setDeveloperKey($this->apiKey);
        $scopes         = $client->getScopes();

        if (!empty($this->scopes)) {
            foreach ($scopes as $scope) {
                $scopes[] = $scope;
            }
        }

        $client->setScopes($scopes);
        $this->client   = $client;
    }

    /**
     * @return \Google_Client
     */
    private function getClient()
    {
        if (!($this->client instanceof \Google_Client)) {
            $this->setClient();
        }

        return $this->client;
    }

    private function setService()
    {
        try {
            $this->service = new \Google_Service_Calendar($this->getClient());
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
        }
    }

    /**
     * @return \Google_Service_Calendar
     */
    private function getService()
    {
        if (!($this->service instanceof \ Google_Service_Calendar)) {
            $this->setService();
        }

        return $this->service;
    }

    /**
     * @param $calendarId
     * @return bool
     */
    public function delCalendar($calendarId)
    {
        try {
            $response = $this->getService()->calendars->delete($calendarId);
            if (!empty($response)) {
                $this->logger->error($response);
                return false;
            }
            return true;
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            return false;
        }
    }

    /**
     * @param $calendarId
     * @return bool
     */
    public function clearCalendar($calendarId)
    {
        try {
            $response = $this->getService()->calendars->clear($calendarId);
            if (!empty($response)) {
                $this->logger->error($response);
                return false;
            }
            return true;
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            return false;
        }
    }

    /**
     * @param $summary
     * @return null
     */
    public function getCalendarIdBySummary($summary)
    {
        $calendarList = $this->getService()->calendarList->listCalendarList();

        while (true) {
            /** @var \Google_Service_Calendar_CalendarListEntry $calendar */
            foreach ($calendarList->getItems() as $calendar) {
                if (hash_equals($summary, $calendar->getSummary())) {
                    return $calendar->getId();
                }
            }
            $pageToken = $calendarList->getNextPageToken();
            if ($pageToken) {
                $calendarList = $this->getService()->calendarList->listCalendarList(['pageToken' => $pageToken]);
            } else {
                break;
            }
        }

        return null;
    }

    /**
     * @param $summary
     * @return \Google_Service_Calendar_Calendar|null
     */
    public function createCalendar($summary)
    {
        $calendar = new \Google_Service_Calendar_Calendar();
        $calendar->setSummary($summary);
        $calendar->setTimeZone(self::TIMEZONE);
        try {
            $createdCalendar = $this->getService()->calendars->insert($calendar);
            return $createdCalendar;
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            return null;
        }
    }

    /**
     * @param $summary
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     * @param string $description
     * @param string $recurrence
     * @return \Google_Service_Calendar_Event
     */
    public function newEvent($summary, \DateTime $startDate, \DateTime $endDate, $description = '', $recurrence = '')
    {
        $data = [
            'summary' => $summary,
            'start' => [
                'dateTime' => $startDate->format(self::TDATEFORMAT),
                'timeZone' => self::TIMEZONE
            ],
            'end' => [
                'dateTime' => $endDate->format(self::TDATEFORMAT),
                'timeZone' => self::TIMEZONE
            ]
        ];

        if (!empty($description)) {
            $data['description'] = $description;
        }

        if (!empty($recurrence)) {
            $data['recurrence'] = [$recurrence];
        }

        return new \Google_Service_Calendar_Event($data);
    }

    /**
     * @param $calendarId
     * @param \Google_Service_Calendar_Event $event
     * @return \Google_Service_Calendar_Event
     */
    public function createEvent($calendarId, \Google_Service_Calendar_Event $event)
    {
        try {
            $createdEvent = $this->getService()->events->insert($calendarId, $event);
            if (!($createdEvent instanceof \Google_Service_Calendar_Event)) {
                $this->logger->error($createdEvent);
                return null;
            }
            return $createdEvent;
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            return null;
        }
    }

    public function cancelEvent($calendarId, $eventId, \DateTime $cancelledDate)
    {
        $events = $this->getService()->events->instances($calendarId, $eventId);

        /** @var \Google_Service_Calendar_Event $event */
        foreach ($events->getItems() as $event) {
            if ($event->getStart()->getDateTime() == $cancelledDate) {
                $event->setStatus('cancelled');
                $this->getService()->events->update($calendarId, $event->getId(), $event);
            }
        }
    }
}
