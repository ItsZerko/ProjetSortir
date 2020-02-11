<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Entity\Sortie;
use App\Form\SortieFormType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SortieController extends AbstractController
{
    /**
     * @Route("/sortie", name="sortie")
     */
    public function index()
    {
        $sortie =  new Sortie();
        $form = $this->createForm(SortieFormType ::class, $sortie);
        return $this->render('base/sortie.html.twig', [
            'controller_name' => 'SortieController',
             'sortieForm'=> $form->createView()
        ]);
    }

    /**
     * @Route("/", name="base")
     * @param EntityManagerInterface $em
     * @return Response
     */


        public function recupListeSortie(EntityManagerInterface $em){

            $ListeSortie = $em->getRepository(Sortie::class)->findAll();

            return $this->render('base/index.html.twig', [
                "listeSortie" => $ListeSortie
            ]);

        }
}
