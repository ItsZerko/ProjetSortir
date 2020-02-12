<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\Participant;
use App\Entity\Sortie;
use App\Form\SortieFormType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SortieController extends AbstractController
{
    /**
     * @Route("/sortie", name="sortie")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function index(Request $request, EntityManagerInterface $em)
    {


    $sortie =  new Sortie();
    $etat = new Etat();

        $form = $this->createForm(SortieFormType ::class, $sortie);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
$sortie->setEtat('Créée');

            $em->persist($sortie);
            $em->flush();

         //   $this->addFlash("warning","DONE !");
            $this->redirectToRoute('sortie');

        }


        return $this->render('base/sortie.html.twig', [
            'controller_name' => 'SortieController',
             'sortieForm'=> $form->createView()
        ]);
    }

    /**
     * @param EntityManagerInterface $em
     * @return Response
     * @Route("/liste", name="liste")
     */
    public function recupListeSortie(EntityManagerInterface $em)
    {

        $ListeSortie = $em->getRepository(Sortie::class)->findAll();

        return $this->render('base/liste.html.twig', [
            "listeSortie" => $ListeSortie
        ]);

    }

    /**
     * @Route("/detail/{id}", name="detail")
     * @param EntityManagerInterface $em
     * @param $id
     * @return Response
     */
    public function afficherDetail(EntityManagerInterface $em, $id)
    {

        $detailSortie = $em->getRepository(Sortie::class)->find($id);

        return $this->render('base/detail.html.twig', [
            "detailSortie" => $detailSortie
        ]);
    }
}
