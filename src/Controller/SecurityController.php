<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    /**
     * @throws \Exception
     */
    #[Route('/logout', name: 'app_logout')]
    public function logout()
    {
        throw new \Exception('Logout not activated');
    }
}
