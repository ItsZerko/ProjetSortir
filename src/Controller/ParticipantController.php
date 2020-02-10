<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\ParticipantType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ParticipantController extends AbstractController
{
    /**
     * @Route("/formulaire", name="formulaire")
     */

    public function formulaire(EntityManagerInterface $em, Request $request)
    {
        $newParticipant = new Participant();
        $form = $this->createForm(ParticipantType::class, $newParticipant);

        //dit au formulaire : "récupère ce qui a été écrit par l'utilisateur dans le formulaire" :
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //envoie les informations en BDD :
            $em->persist($newParticipant);
            $em->flush();

            //ajouter un message de confirmation à l'utilisateur :
            $this->addFlash("success", "Ajouté !");

            //rediriger vers la page home
            return $this->redirectToRoute('home');

        }
        return $this->render("participantProfil/formulaire.html.twig", [
            "formParticipant" => $form->createView(),
            ]);
    }
}
