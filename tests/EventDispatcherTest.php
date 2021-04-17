<?php

namespace Moveo\EventDispatcher\Tests;

use Moveo\EventDispatcher\EventDispatcher;
use Moveo\EventDispatcher\ListenerProvider;
use PHPUnit\Framework\TestCase;

class EventDispatcherTest extends TestCase
{
    public function testShouldPass(): void
    {
        $this->assertTrue(true);
    }

    public function testShouldRegisterOneListeners():void
    {
        $event = new DummyEvent();
        $listenerProvider = new ListenerProvider();

        $listenerProvider->listen($event, function(){
            echo "test";
        });
        $this->assertCount(1, $listenerProvider->getListenersForEvent($event));
    }

    public function testShouldRegisterSeveralListeners():void
    {
        $event = new DummyEvent();
        $listenerProvider = new ListenerProvider();

        $listenerProvider->listen($event, function(){
            echo "test";
        });
        $listenerProvider->listen($event, function(){
            echo "test 2";
        });

        $this->assertCount(2, $listenerProvider->getListenersForEvent($event));
    }

    public function testShouldDispatchEventAndCallCallable():void
    {
        $event = new DummyEvent();
        $listenerProvider = new ListenerProvider();
        $eventDispatcher = new EventDispatcher($listenerProvider);

        $listenerProvider->listen($event, function(){
            echo "1";
        });
        $listenerProvider->listen($event, function(){
            echo "2";
        });
        $listenerProvider->listen($event, function(){
            echo "3";
        });

        $this->expectOutputString('123');
        $eventDispatcher->dispatch($event);
    }

    public function testShouldDispatchEventForRightEvent():void
    {
        $event = new DummyEvent();
        $event2 = new \stdClass();

        $listenerProvider = new ListenerProvider();
        $eventDispatcher = new EventDispatcher($listenerProvider);

        $listenerProvider->listen($event, function(){
            echo "1";
        });
        $listenerProvider->listen($event, function(){
            echo "2";
        });
        $listenerProvider->listen($event2, function(){
            echo "3";
        });

        $this->expectOutputString('12');
        $eventDispatcher->dispatch($event);
    }
}
