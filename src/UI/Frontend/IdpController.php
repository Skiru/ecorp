<?php

namespace ECorp\UI\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class IdpController extends AbstractController
{
    public function login()
    {

    }

    public function register()
    {

    }

    /**
     * @return JsonResponse
     */
    public function homepage(): JsonResponse
    {
        return new JsonResponse([
            'Message' => 'purple clouds idp homepage'
        ]);
    }
}