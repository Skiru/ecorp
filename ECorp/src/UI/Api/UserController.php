<?php

namespace ECorp\UI\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserController extends AbstractController
{

    /**
     * @return JsonResponse
     */
    public function getAllUsers(): JsonResponse
    {
        return new JsonResponse([
            'users' => [
                'mateusz' => 'serialized_mateusz_user_data'
            ]
        ]);
    }

}
