<?php

namespace App\Controller;


use App\Entity\Ville;
use App\Form\RechercheVilleType;
use App\Form\VilleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VilleController extends AbstractController
{

    /**
     * @Route("/formulaire_ville", name="formulaire_ville")
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function formulaireVille(EntityManagerInterface $em, Request $request)
    {
        if ($this->isGranted("ROLE_ADMIN")) {

        $newVille = new Ville();
        $form = $this->createForm(VilleType::class, $newVille);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($newVille);
            $em->flush();

            $this->addFlash("success", "Ajouté !");
            return $this->redirectToRoute('ville');
        }
        return $this->render("ville/formulaire_ville.html.twig", [
            "form" => $form->createView(),
        ]);
    } else {
            return $this->redirectToRoute('liste');
        }
    }

    /**
     * @Route("/ville", name="ville")
     * @param EntityManagerInterface $em

     * @param Request $request

     * @return RedirectResponse|Response
     */
    public function listerVille(EntityManagerInterface $em, Request $request)
    {

        if ($this->isGranted("ROLE_ADMIN")) {
            $villes = $em->getRepository(Ville::class)->findAll();

            $form = $this->createForm( RechercheVilleType::class);
            $form->handleRequest($request);


            $villeRecherchee = $form->get('villeRecherchee')->getData();

            if($form->isSubmitted()&& $villeRecherchee !== null)
            {
                $villes = $em->getRepository(Ville::class)->findBy([
                    "nom"=>$villeRecherchee
                ]);

            }


        return $this->render("ville/listeVille.html.twig",
            [
                'villes' => $villes,
                'recherche'=>$form->createView()
            ]);

    } else {
            return $this->redirectToRoute('liste');
        }
    }

    /**
     * @Route("/supprimer_ville/{id}", name="supprimer_ville")
     * @param EntityManagerInterface $em
     * @param null $id
     * @return RedirectResponse
     */
    public function supprimerVille(EntityManagerInterface $em, $id = null)
    {

        if ($this->isGranted("ROLE_ADMIN")) {
            $villes = $em->getRepository(Ville::class)->find($id);

            $em->remove($villes);
            $em->flush();
            $this->addFlash('success', 'Ville supprimée !');
            return $this->redirectToRoute('ville');
        } else {
            return $this->redirectToRoute('liste');
        }
    }

    /**
     * @Route("/modifier_ville/{id}", name="modifier_ville")
     */
    public function modifierVille(EntityManagerInterface $em, Request $request, $id)
    {
        if ($this->isGranted("ROLE_ADMIN")) {
        $villeRepository = $em->getRepository(Ville::class);

        //récupère tout mon enregistrement :
        $villeExistantes = $villeRepository->find($id);

        $form = $this->createForm(VilleType::class,  $villeExistantes);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $newCodePostal = $form->get('codePostal')->getData();
            $villeExistantes->setCodePostal($newCodePostal);
            $newVille = $form->get('nom')->getData();
            $villeExistantes->setNom($newVille);
            $em->persist($villeExistantes);
            $em->flush();
            $this->addFlash('success', 'Ville modifiée !');
            return $this->redirectToRoute('ville');
        }

        return $this->render('ville/modifier.html.twig', [
            'form' => $form->createView()
        ]);

        } else {
            return $this->redirectToRoute('liste');
        }
    }

}



