<?php

namespace ECorp\Application\User\Command;

final class UserRegisterCommandHandler
{
    /**
     * @param UserRegisterCommand $command
     */
    public function handle(UserRegisterCommand $command)
    {
        echo var_dump($command);
        exit;
    }
}
