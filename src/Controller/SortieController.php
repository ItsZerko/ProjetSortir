<?php

namespace App\Controller;


use App\Entity\Inscription;
use App\Entity\Participant;
use App\Entity\Site;
use App\Entity\Sortie;
use App\Entity\Lieu;
use App\Entity\Ville;
use App\Form\InscriptionSortieType;
use App\Form\InscriptionType;
use App\Form\SortieFormType;

use App\Form\LieuType;
use App\Repository\VilleRepository;
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
    public function creationSortie(Request $request, EntityManagerInterface $em)
    {

        $sortie = new Sortie();

        $lieu = $em->getRepository(Lieu::class)->find(2);
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

            'sortieForm' => $form->createView(),
            'detail'=> ['lieu' =>$lieu->getNom(),
          'test2'=> $lieu->getRue()]
        ]);

    }

    /**
     * @Route("/ajouterLieu", name="ajouterLieu")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function AjouterLieu(Request $request, EntityManagerInterface $em) {
       $lieu = new Lieu();
       $ville = new Ville();
        $form = $this->createForm(LieuType ::class, $lieu);


        $form->handleRequest($request);
if ($form->isSubmitted() && $form->isValid()){
    $villeNom= $form->get('ville')->getData();
    $villeCode=$form->get('codePostal')->getData();
    $ville->setNom($villeNom);
    $ville->setCodePostal($villeCode);
    $lieu->setVille($ville);
    $em->persist($lieu);
    $em->flush();
    $this->redirectToRoute('sortie');



}

        return $this->render('Sortie/ajouterLieu.html.twig', [
            'controller_name' => 'SortieController',
            'formLieu'=>$form->createView()]);

    }



    /**
     * @param EntityManagerInterface $em
     * @return Response
     * @Route("/liste", name="liste")
     */
    public function recupListeSortie(EntityManagerInterface $em)
    {
        $sites = $em->getRepository(Site::class)->findAll();
        $ListeSortie = $em->getRepository(Sortie::class)->findAll();

        return $this->render('Sortie/liste.html.twig', [
            "listeSortie" => $ListeSortie,
            "sites"=>$sites,
        ]);
    }


    /**
     * @Route("/detail/{id}", name="detail")
     */
    public function detail($id, EntityManagerInterface $em)
    {
        $sortieRepository = $em->getRepository(Sortie::class);
        $sortie=$sortieRepository->find($id);

        return $this->render("sortie/detail.html.twig",
            [
                "sortie" => $sortie
            ]
        );
    }

    /**
     * @Route("/inscriptionSortie/{id}", name="inscriptionSortie")
     */
    public function incriptionSortie(EntityManagerInterface $em, Request $request, $id)
    {
        $inscription = new Inscription();
        $participant = $this->getUser();
        $sortie = $em->getRepository(Sortie::class)->find($id);

        $time = new \DateTime();
            $inscription->setIdParticipant($participant);
            $inscription->getIdSortie($sortie);
            $inscription->setDateInscription($time);
dump($participant);
dump($sortie);
die();

            $em->persist($inscription);
            $em->flush();

            return $this->redirectToRoute('liste');

//        return $this->render('Sortie/detail.html.twig', [
//            'id' => $id,
//            'erreur' => 'blabla'
//        ]);
    }

    /**
     * @Route("/annuler/{id}", name="annulerSortie")
     */
    public function annulerSortie(EntityManagerInterface $em, Request $request, $id)
    {
        $participant = $this->getUser()->getUsername();
        $participantId = $em->getRepository(Participant::class)->findOneBy(
            ["username" => $participant,
            ]);

        $sortieId = $em->getRepository(Sortie::class)->findOneBy([
            "id" => $id
        ]);
        $inscription = $em->getRepository(Inscription::class)->findOneBy(
            [
                "id_participant" => $participantId,
                "id_sortie" => $id
            ]);


        if ($this->getUser() !== null) {
            $em->remove($inscription);
            $em->flush();


            return $this->redirectToRoute('liste');
        }

        return $this->render('Sortie/detail.html.twig', [
            'id' => $id,
            'erreur' => 'blabla'
        ]);
    }

}
