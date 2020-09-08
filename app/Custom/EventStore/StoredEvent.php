<?php

namespace App\Custom\EventStore;

use Spatie\EventSourcing\Models\EloquentStoredEvent;

class StoredEvent extends EloquentStoredEvent
{
    public static function boot()
    {
        parent::boot();
        static::creating(function(StoredEvent $storedEvent) {
            $user = auth()->user();
            $actor = [
                'id' => optional($user)->getKey(),
                'name' => optional($user)->adm_name
            ];
            $storedEvent->meta_data['actor'] = $actor;
            $storedEvent->meta_data['hub_id'] = current_hub_id();
        });
    }
}
