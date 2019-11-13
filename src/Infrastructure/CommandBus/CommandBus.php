<?php

namespace ECorp\Infrastructure\CommandBus;

final class CommandBus implements CommandBusInterface
{
    /**
     * @var array
     */
    private $handlers = [];

    /**
     * @param string $commandClass
     * @param $handler
     */
    public function registerHandler(string $commandClass, $handler): void
    {
        $this->handlers[$commandClass] = $handler;
    }

    /**
     * @param $command
     */
    public function handle($command): void
    {
        $this->handlers[get_class($command)]->handle($command);
    }
}