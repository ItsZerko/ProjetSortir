<?php

namespace App\Controller;


use App\Entity\Ville;
use App\Form\InscriptionSortieType;
use App\Form\VilleType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;

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
     * @return RedirectResponse|Response
     */
    public function listerVille(EntityManagerInterface $em)
    {

        if ($this->isGranted("ROLE_ADMIN")) {

        $villeRepository = $em->getRepository(Ville::class);
        $villes = $villeRepository->findAll();
        return $this->render("ville/listeVille.html.twig",
            [
                "villes" => $villes
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
    public function supprimer(EntityManagerInterface $em, $id = null)
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
}



