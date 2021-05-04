<?php

declare(strict_types=1);

namespace ECorp\Infrastructure\Form\IdpClient;

class IdpClientModel
{
    public string $redirectUri = '';
    public string $grantType = 'code';
    public string $name = '';
}
