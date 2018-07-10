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
     * @var string
     */
    private $clientSecretPath;

    /**
     * @var string
     */
    private $credentialPath;

    /**
     * @var array
     */
    private $scopes;

    const TIMEZONE      = 'Europe/Paris';

    const TDATEFORMAT   = 'Y-m-d\TH:i:s.uP';

    public function __construct($applicationName, $clientSecretPath, $credentialPath, Logger $logger)
    {
        $this->applicationName  = $applicationName;
        $this->logger           = $logger;
        $this->clientSecretPath = $clientSecretPath;
        $this->credentialPath   = $credentialPath;
        $this->scopes           = [\Google_Service_Calendar::CALENDAR];
        $this->setClient();
        $this->setService();
    }

    private function setClient()
    {
        $client         = new \Google_Client();
        $client->setApplicationName($this->applicationName);
        $client->setAuthConfig($this->clientSecretPath);
        $client->setAccessType('offline');
        $client->setApprovalPrompt('force');
        $scopes         = $client->getScopes();

        if (!empty($this->scopes)) {
            foreach ($this->scopes as $scope) {
                $scopes[] = $scope;
            }
        }

        $client->setScopes($scopes);

        if (file_exists($this->credentialPath)) {
            $accessToken = json_decode(file_get_contents($this->credentialPath), true);
        } else {
            // Request authorization from the user.
            $authUrl = $client->createAuthUrl();
            printf("Open the following link in your browser:\n%s\n", $authUrl);
            print 'Enter verification code: ';
            $authCode = trim(fgets(STDIN));

            // Exchange authorization code for an access token.
            $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);

            // Store the credentials to disk.
            if (!file_exists(dirname($this->credentialPath))) {
                mkdir(dirname($this->credentialPath), 0700, true);
            }
            file_put_contents($this->credentialPath, json_encode($accessToken));

            $this->logger->info("Credentials saved to ".$this->credentialPath);
        }

        $client->setAccessToken($accessToken);

        if ($client->isAccessTokenExpired()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            file_put_contents($this->credentialPath, json_encode($client->getAccessToken()));
        }


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
     * @param $calendarId
     * @return bool
     */
    public function clearManuallyCalendar($calendarId)
    {
        try {
            $events = $this->getService()->events->listEvents($calendarId);

            while (true) {
                /** @var \Google_Service_Calendar_Event $event */
                foreach ($events->getItems() as $event) {
                    $this->getService()->events->delete($calendarId, $event->getId());
                }

                $pageToken = $events->getNextPageToken();

                if ($pageToken) {
                    $optParams = array('pageToken' => $pageToken);
                    $events = $this->getService()->events->listEvents('primary', $optParams);
                } else {
                    break;
                }
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
     * @param array $recurrences
     * @return \Google_Service_Calendar_Event
     */
    public function newEvent($summary, \DateTime $startDate, \DateTime $endDate, $description = '', $recurrences = [])
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

        if (!empty($recurrences)) {
            foreach ($recurrences as $list_recurrence) {
                foreach ($list_recurrence as $recurrence) {
                    $data['recurrence'] = [$recurrence];
                }
            }
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
