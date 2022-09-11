<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\User;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class ApiLoginController extends AbstractController
{
        /**
         * The #[CurrentUser] can only be used in controller arguments to
         *  retrieve the authenticated user. 
         * In services, you would use getUser().
         */
    #[Route('/api/login', name: 'app_api_login')]
    public function index(#[CurrentUser] ?User $user): JsonResponse
    {
        
        if (null === $user) {
                         return $this->json([
                             'message' => 'missing credentials',
                         ], Response::HTTP_UNAUTHORIZED);
                     }
            
                     $token = '...'; // somehow create an API token for $user


        return $this->json([
            'user'  => $user->getUserIdentifier(),
             'token' => $token,
        ]);
    }
}
