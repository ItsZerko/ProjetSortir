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
use App\Form\RechercheType;
use App\Form\SortieFormType;

use App\Form\LieuType;
use App\Repository\LieuRepository;
use App\Repository\VilleRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Console\Helper\HelperSet;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;

class SortieController extends AbstractController
{
    /**
     * @Route("/sortie", name="sortie")
     * @Route("/changeLieu/{id}", name="changLieu")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function creationSortie(Request $request, EntityManagerInterface $em, $id = null)
    {

        $sortie = new Sortie();
        $inscription= new Inscription();
    $lieu = new Lieu();

        $form = $this->createForm(SortieFormType ::class, $sortie);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $sortie->setLieu($form->get('lieu')->getData());


            if ($form->get('enregistrer')->isClicked()) {


                $sortie->setEtat('Créée');
                $inscription->setIdSortie($sortie);


                //  $em->persist($inscription);
                $em->persist($sortie);
                $em->flush();
                return $this->redirectToRoute('liste');

            } else if ($form->get('publier')->isClicked()) {

                $sortie->setEtat('Publiée');

                $em->persist($sortie);
                $em->flush();
                return $this->redirectToRoute('liste');

            }
        }


        return $this->render('Sortie/formulaire_sortie.html.twig', [
            'controller_name' => 'SortieController',
            'sortieForm' => $form->createView(),
            'detailLieu'=>$lieu
        ]);

    }

    /**
     * @Route("/ajouterLieu", name="ajouterLieu")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function AjouterLieu(Request $request, EntityManagerInterface $em)
    {
        $lieu = new Lieu();
        $ville = new Ville();
        $form = $this->createForm(LieuType ::class, $lieu);


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $villeNom = $form->get('ville')->getData();
            $villeCode = $form->get('codePostal')->getData();
            $ville->setNom($villeNom);
            $ville->setCodePostal($villeCode);

            $lieu->setVille($ville);
            $em->persist($lieu);
            $em->flush();
            return $this->redirectToRoute('sortie');


        }

        return $this->render('Sortie/ajouterLieu.html.twig', [
            'controller_name' => 'SortieController',
            'formLieu' => $form->createView()]);

    }

    /**
     * @Route ("/recherche", name="recherche")
     * @param EntityManagerInterface $em
     * @param Request $request
     * @param $requete
     * @return Response
     */


    public function recherche(EntityManagerInterface $em, Request $request, $requete)
    {

        $recherche = $request->get('recherche');
        if ($requete->getMethod() == 'POST') {
            $repository = $this->getDoctrine()
                ->getEntityManager()
                ->getRepository('ProjetbibliothequeBundle:Inscrit');
            $listeinscrit = $repository->findByNomApproximatif($requete);

            return $this->render('ProjetbibliothequeBundle:Inscrit:index.html.twig', array(
                'entities' => $listeinscrit,
            ));
        }

    }

    /**
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     * @Route("/liste", name="liste")
     */
    public function recupListeSortie(EntityManagerInterface $em, Request $request)
    {


        $user = $this->getUser()->getUsername();
        $sites = $em->getRepository(Site::class)->findAll();
        $listeSorties = $em->getRepository(Sortie::class)->findAll();

        dump($listeSorties);

        $participants = $em->getRepository(Participant::class)->findOneBy([
            "username" => $user
        ]);
        $inscription = $em->getRepository(Inscription::class)->findBy([
            "id_sortie" => $listeSorties
        ]);


        $form = $this->createForm(RechercheType::class);


        $form->handleRequest($request);
        $infoRecherche = $form->get('RechercheSortie')->getData();
        $infoSite = $form->get('RechercheSite')->getData();
        $infoDateDebut = $form->get('DateDebut')->getData();
        $infoDateFin = $form->get('DateFin')->getData();

        if ($form->isSubmitted()) {
            $listeSorties = $em->getRepository(Sortie::class)->findByCriterion($infoDateDebut, $infoDateFin, $infoRecherche, $infoSite);

        }


        return $this->render(
            'Sortie/liste.html.twig'
            // compact('listeSorties', 'sites', 'inscription', 'participants','form')
            , [
            "listeSorties" => $listeSorties,
            "sites" => $sites,
            "inscription" => $inscription,
            "participants" => $participants,
            'recherche' => $form->createView()
        ]);
    }


    /**
     * @Route("/detail/{id}", name="detail")
     */
    public function detail($id, EntityManagerInterface $em)
    {
        $sortieRepository = $em->getRepository(Sortie::class);
        $sortie = $sortieRepository->find($id);

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
        $inscription->setIdSortie($sortie);
        $inscription->setDateInscription($time);


        $em->persist($inscription);
        $em->flush();

        return $this->redirectToRoute('liste');

    }

    /**
     * @Route("/desinscrire/{id}", name="desinscrire")
     */
    public function désinscrire(EntityManagerInterface $em, Request $request, $id)
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