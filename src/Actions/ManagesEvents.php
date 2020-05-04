<?php

namespace TestMonitor\ActiveCampaign\Actions;

use TestMonitor\ActiveCampaign\Resources\Event;

trait ManagesEvents
{
    use ImplementsActions;

    /**
     * This value is unique to ActiveCampaign account and can be found named "Event Key"
     * on Settings > Tracking > Event Tracking inside ActiveCampaign account.
     *
     * @var string
     */
    public $trackKey;

    /**
     * This value is unique to ActiveCampaign account and can be found named "actid"
     * on Settings > Tracking > Event Tracking API.
     *
     * @var string
     */
    public $trackActid;

    /**
     * Creates a new event (name only).
     *
     * @param string $name
     *
     * @return Event
     */
    public function createEvent($name)
    {
        $data = [
            'name' => $name,
        ];

        $event = $this->post('eventTrackingEvents', ['json' => ['eventTrackingEvent' => $data]]);

        return new Event($event['eventTrackingEvent']);
    }

    /**
     * List all events.
     *
     * @return Event[]
     */
    public function events()
    {
        return $this->transformCollection(
            $this->get('eventTrackingEvents'),
            Event::class,
            'eventTrackingEvents'
        );
    }

    /**
     * List name of all events.
     *
     * @return Event[]
     */
    public function eventNames()
    {
        $events = $this->get('eventTrackingEvents');

        return array_map(function ($data) {
            return $data['name'];
        }, $events['eventTrackingEvents'] ?? $events);
    }

    /**
     * Removes an existing event tracking event (name only).
     *
     * @param $name
     *
     * @throws \TestMonitor\ActiveCampaign\Exceptions\NotFoundException
     */
    public function deleteEvent($name)
    {
        $this->delete('eventTrackingEvents/'.$name);
    }

    /**
     * Tracks an event by name.
     *
     * @param string $name      name of the event to track
     * @param string $email     email address of the contact to track this event for, optional
     * @param array  $eventData a value to store for the event, optional
     *
     * @return bool TRUE on success, FALSE otherwise
     * @throws \TestMonitor\ActiveCampaign\Exceptions\FailedActionException
     */
    public function trackEvent($name, $email = '', $eventData = [])
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://trackcmp.net/event');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, [
            'actid'     => $this->trackActid,
            'key'       => $this->trackKey,
            'event'     => $name,
            'eventdata' => json_encode($eventData),
        ] + ($email ? ['visit' => json_encode(['email' => $email])] : []));

        $result = curl_exec($curl);
        if ($result !== false) {
            curl_close($curl);
            $result = json_decode($result);

            if (isset($result->success) && $result->success) {
                return true;
            }

            return false;
        } else {
            throw new \TestMonitor\ActiveCampaign\Exceptions\FailedActionException(curl_error($curl));
        }
    }
}
