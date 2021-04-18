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
        $listenerProvider = new ListenerProvider();

        $listenerProvider->addListener(DummyEvent::class, function(){
            echo "test";
        });

        $event = new DummyEvent();
        $this->assertCount(1, $listenerProvider->getListenersForEvent($event));
    }

    public function testShouldRegisterSeveralListeners():void
    {

        $listenerProvider = new ListenerProvider();

        $listenerProvider->addListener(DummyEvent::class, function(){
            echo "test";
        });
        $listenerProvider->addListener(DummyEvent::class, function(){
            echo "test 2";
        });

        $event = new DummyEvent();
        $this->assertCount(2, $listenerProvider->getListenersForEvent($event));
    }

    public function testShouldDispatchEventAndCallCallable():void
    {
        $listenerProvider = new ListenerProvider();
        $eventDispatcher = new EventDispatcher($listenerProvider);

        $listenerProvider->addListener(DummyEvent::class, function(){
            echo "1";
        });
        $listenerProvider->addListener(DummyEvent::class, function(){
            echo "2";
        });
        $listenerProvider->addListener(DummyEvent::class, function(){
            echo "3";
        });

        $event = new DummyEvent();
        $this->expectOutputString('123');
        $eventDispatcher->dispatch($event);
    }

    public function testShouldDispatchEventForRightEvent():void
    {
        $listenerProvider = new ListenerProvider();
        $eventDispatcher = new EventDispatcher($listenerProvider);

        $listenerProvider->addListener(DummyEvent::class, function(){
            echo "1";
        });
        $listenerProvider->addListener(DummyEvent::class, function(){
            echo "2";
        });
        $listenerProvider->addListener(\stdClass::class, function(){
            echo "3";
        });

        $event = new DummyEvent();
        $this->expectOutputString('12');
        $eventDispatcher->dispatch($event);
    }
}
