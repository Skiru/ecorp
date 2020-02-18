<?php

namespace ECorp\UI\Frontend;

use ECorp\Infrastructure\Form\User\UserFormModel;
use ECorp\Infrastructure\Form\User\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class IdpController extends AbstractController
{
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    public function register(Request $request)
    {
        $userFormModel = new UserFormModel();
        $form = $this->createForm(UserType::class, $userFormModel);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //handle form
        }

        return $this->render('security/register.html.twig', [
           'form' => $form->createView()
        ]);
    }

    public function profile(): Response
    {
        return $this->render('admin/profile.html.twig', []);
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