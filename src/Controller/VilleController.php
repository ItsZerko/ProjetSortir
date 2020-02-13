<?php

namespace App\Controller;


use App\Entity\Ville;
use App\Form\InscriptionSortieType;
use App\Form\VilleType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;

class VilleController extends AbstractController
{

    /**
     * @Route("/formulaire_ville", name="formulaire_ville")
     */

    public function formulaireVille(EntityManagerInterface $em, Request $request)
    {
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
    }

    /**
     * @Route("/ville", name="ville")
     */
    public function listerVille(EntityManagerInterface $em) {

        $villeRepository = $em->getRepository(Ville::class);
        $villes = $villeRepository->findAll();
         return $this->render("ville/gererVille.html.twig",
             [
                 "villes" => $villes
             ]);
     }

    /**
     * @Route("/supprimer_lieu/{id}", name="supprimer_lieu")
     */
    public function supprimer(EntityManagerInterface $em, $id=null)
    {
        $villes = $em->getRepository(Ville::class)->find($id);
        $em->remove($villes);
        $em->flush();
        $this->addFlash('success', 'Ville supprimée !');
        return $this->redirectToRoute('ville');
    }



}



