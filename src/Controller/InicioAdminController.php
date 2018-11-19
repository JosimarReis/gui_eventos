<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class InicioAdminController extends AbstractController
{
    /**
     * @Route("/admin", name="inicio_admin")
     */
    public function index()
    {
        return $this->render('inicio_admin/index.html.twig', [
            'controller_name' => 'InicioAdminController',
        ]);
    }
}
