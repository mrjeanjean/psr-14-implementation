<?php

namespace Moveo\EventDispatcher;

use Psr\EventDispatcher\ListenerProviderInterface;

/**
 * Listener Provider which stores all listeners
 */
class ListenerProvider implements ListenerProviderInterface
{
    /**
     * @var array<array> $listeners
     */
    private array $listeners = [];

    /**
     * @param object $event
     * @return iterable<array>
     */
    public function getListenersForEvent(object $event): iterable
    {
        $listeners = [];
        foreach ($this->listeners as $eventName => $listener){
            if($eventName !== get_class($event)){
                continue;
            }

            $listeners = array_merge($listener, $listeners);
        }

        return $listeners;
    }

    /**
     * @param string $eventClassName
     * @param callable $callback
     */
    public function addListener(string $eventClassName, callable $callback): void
    {
        $this->listeners[$eventClassName][] = $callback;
    }
}
