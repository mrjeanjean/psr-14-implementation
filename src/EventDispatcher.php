<?php

namespace Moveo\EventDispatcher;

use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\EventDispatcher\ListenerProviderInterface;
use Psr\EventDispatcher\StoppableEventInterface;

/**
 * Event Dispatcher responsible on dispatching events
 * to all listeners
 */
class EventDispatcher implements EventDispatcherInterface
{
    private ListenerProviderInterface $listenerProvider;

    public function __construct(ListenerProviderInterface $listenerProvider)
    {
        $this->listenerProvider = $listenerProvider;
    }

    /**
     * @param object $event
     * @return object
     */
    public function dispatch(object $event):object
    {
        foreach ($this->listenerProvider->getListenersForEvent($event) as $callback){
            if($event instanceof StoppableEventInterface && $event->isPropagationStopped()){
                break;
            }
            $callback($event);
        }

        return $event;
    }
}
