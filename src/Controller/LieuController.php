<?php

namespace App\Controller;


use App\Form\InscriptionSortieType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;

class LieuController extends AbstractController
{
    /**
     * @Route("/lieux", name="lieux")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function creationLieu(Request $request, EntityManagerInterface $em) {




    }
}



