<?php

namespace App\Controller;


use App\Entity\Inscription;
use App\Entity\Participant;
use App\Entity\Sortie;
use App\Entity\Lieu;
use App\Form\InscriptionSortieType;
use App\Form\InscriptionType;

use App\Form\SortieFormType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;

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


        $sortie = new Sortie();
        $lieu= $em->getRepository(Lieu::class);


        $form = $this->createForm(SortieFormType ::class, $sortie);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {


            $sortie->setEtat('Créée');
            $em->persist($sortie);
            $em->flush();
            $this->redirectToRoute('sortie');

        }
        return $this->render('base/sortie.html.twig', [
            'controller_name' => 'SortieController',
            'sortieForm' => $form->createView()]);

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
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param $id
     * @return Response
     * @throws Exception
     */


    public function afficherDetail(Request $request, EntityManagerInterface $em, $id)
    {


        $inscription = new Inscription();
        $participant = $this->getUser()->getUsername();

        $detailSortie = $em->getRepository(Sortie::class)->find($id);


        $form = $this->createForm(InscriptionType::class, $inscription);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $this->getUser() !== null) {

            $time = new \DateTime();
            $inscription->setDateInscription($time);
            $inscription->setIdParticipant($participant);

            $inscription->setIdSortie($detailSortie);


            $em->persist($inscription);

            $em->flush();

            return $this->redirectToRoute('base');

        }
        return $this->render('base/detail.html.twig', [

            "detailSortie" => $detailSortie,
            'inscriptionForm' => $form->createView()

        ]);
    }


}
