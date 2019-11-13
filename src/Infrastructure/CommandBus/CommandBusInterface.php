<?php

namespace ECorp\Infrastructure\CommandBus;

interface CommandBusInterface
{
    public function registerHandler(string $commandClass, $handler): void;
    public function handle($command): void;
}