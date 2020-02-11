<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\ParticipantType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ParticipantController extends AbstractController
{
    /**
     * @Route("/modifier/{id}", name="modifier")
     */

    public function form($id = null, EntityManagerInterface $em, Request $request)
    {
        if ($id == null) {
            $participant = new Participant();
        } else {
            $participant = $em->getRepository(Participant::class)->find($id);
        }

        $form = $this->createForm(ParticipantType::class, $participant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($id == null) {
                $currentUser = $this->getUser();
                $participant->getUsername($currentUser);
                $participant->getNom($currentUser);
                $participant->getPrenom($currentUser);
                $participant->getTelephone($currentUser);
                $participant->setMail($currentUser);
                $participant->getPassword($currentUser);
                $participant->getPasswordVerif($currentUser);

                $em->persist($participant);
                $this->addFlash('success', 'User Created');
            } else {
                $this->addFlash('success', 'User Updated');
            }

            $em->flush();

            return $this->redirectToRoute('base');
        }
        return $this->render('profil/modifier.html.twig', [
            'formParticipant' => $form->createView(),
            'participant' => $participant
        ]);
    }
}
