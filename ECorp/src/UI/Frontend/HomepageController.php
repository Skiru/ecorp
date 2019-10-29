<?php

namespace ECorp\UI\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class HomepageController extends AbstractController
{
    /**
     * @return JsonResponse
     */
    public function homepage(): JsonResponse
    {
        return new JsonResponse([
            'Message' => 'Hello world!!'
        ]);
    }
}