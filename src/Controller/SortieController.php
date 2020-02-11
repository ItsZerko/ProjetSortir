<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Entity\Sortie;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SortieController extends AbstractController
{
    /**
     * @Route("/sortie", name="sortie")
     */
    public function index()
    {
        return $this->render('base/index.html.twig', [
            'controller_name' => 'SortieController',
        ]);
    }

    /**
     * @Route("/", name="base")
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\Response
     */


        public function recupListeSortie(EntityManagerInterface $em){

            $ListeSortie = $em->getRepository(Sortie::class)->findAll();

            return $this->render('base/index.html.twig', [
                "listeSortie" => $ListeSortie
            ]);

        }
}
