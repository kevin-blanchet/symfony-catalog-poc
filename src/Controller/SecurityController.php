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

    #[Route('/', name: 'app_index')]
    public function toProduct(): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        return $this->redirectToRoute('app_product_index');
    }
}
