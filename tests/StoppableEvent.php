<?php


namespace Moveo\EventDispatcher\Tests;


use Psr\EventDispatcher\StoppableEventInterface;

class StoppableEvent implements StoppableEventInterface
{
    private bool $isStopped = false;

    public function isPropagationStopped(): bool
    {
        return $this->isStopped;
    }

    public function stopPropagation():void
    {
        $this->isStopped = true;
    }
}
