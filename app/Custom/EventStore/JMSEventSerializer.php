<?php

namespace App\Custom\EventStore;

use JMS\Serializer\SerializerBuilder;
use Spatie\EventSourcing\ShouldBeStored;
use Spatie\EventSourcing\EventSerializers\EventSerializer;

class JMSEventSerializer implements EventSerializer
{
    public function __construct()
    {
        $this->serializer = SerializerBuilder::create()->build();
    }

    public function serialize(ShouldBeStored $event): string
    {
        /*
         * We call __sleep so `Illuminate\Queue\SerializesModels` will
         * prepare all models in the event for serialization.
         */
        if (method_exists($event, '__sleep')) {
            $event->__sleep();
        }

        return $this->serializer->serialize($event, 'json');
    }

    public function deserialize(string $eventClass, string $json): ShouldBeStored
    {
        $restoredEvent = $this->serializer->deserialize($json, $eventClass, 'json');
        /*
         *  We call manually serialize and unserialize to trigger
         * `Illuminate\Queue\SerializesModels` model restoring capabilities.
         */
        return unserialize(serialize($restoredEvent));
    }
}
