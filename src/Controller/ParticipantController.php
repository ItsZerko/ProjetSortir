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
     * @Route("/modifier/{id}", name="modifier")
     */

    public function modifier(EntityManagerInterface $em, Request $request, $id)
    {
        $participantRepository = $em->getRepository(Participant::class);

        //récupère tout mon enregistrement :
        $participantExistant = $participantRepository->find($id);
        $form = $this->createForm(IdeaType::class,  $participantExistant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // persist est inutile ici car c'est uniquement pour une nouvelle entity !!!
            //    $em->persist($ideaExistantes);
            $em->flush();

            $this->addFlash('success', 'Souhait modifié !');
            return $this->redirectToRoute('list');
        }

        return $this->render('idea/modifier.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
