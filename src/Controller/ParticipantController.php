<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\ParticipantType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

<<<<<<< HEAD
        //récupère tout mon enregistrement :
        $participantExistant = $participantRepository->find($id);
        $form = $this->createForm(ParticipantType::class, $participantExistant);
=======
        $form = $this->createForm(ParticipantType::class, $participant);
>>>>>>> 58a052d349f6ecfd8116e2c21f17593185fadaa9
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($id == null) {
                $currentUser = $this->getUser();
                $participant->setMail($currentUser);

                $em->persist($participant);
                $this->addFlash('success', 'User Created');
            } else {
                $this->addFlash('success', 'User Updated');
            }

            $em->flush();

            return $this->redirectToRoute('home');
        }

<<<<<<< HEAD
        return $this->render('profil/modifier.html.twig', [
            'formParticipant' => $form->createView(),
            'participent' => $participantExistant
        ]);
=======
        return $this->render(
            "profil/modifier.html.twig",
            [
                "formParticipant" => $form->createView(),
                "participant"=>$participant
            ]
        );
>>>>>>> 58a052d349f6ecfd8116e2c21f17593185fadaa9
    }
}
