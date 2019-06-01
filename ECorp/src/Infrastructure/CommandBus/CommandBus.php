<?php

namespace ECorp\Infrastructure\CommandBus;

final class CommandBus implements CommandBusInterface
{
    //@TODO: Add Assertions!
    /**
     * @var array
     */
    private $handlers = [];

    public function registerHandler(string $commandClass, $handler): void
    {
        $this->handlers[$commandClass] = $handler;
    }

    public function handle($command): void
    {
        $this->handlers[get_class($command)]->handle($command);
    }
}