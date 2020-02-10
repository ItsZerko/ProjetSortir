<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BaseController extends AbstractController
{
    /**
     * @Route("/base", name="base")
     */
    public function index()
    {

        $user = $this->getUser()->getUsername();
        return $this->render('base/index.html.twig', [
            'controller_name' => 'BaseController',
            'user'=>$user
        ]);
    }
}
