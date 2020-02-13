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
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ParticipantController extends AbstractController
{
    /**
     * @Route("/modifier/{id}", name="modifier")
     * @param null $id
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function form($id = null, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $em, Request $request)
    {
        if ($id == null) {
            $participant = new Participant();
        } else {
            $participant = $em->getRepository(Participant::class)->find($id);
        }

        $form = $this->createForm(ParticipantType::class, $participant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $participant->setPassword(
                $passwordEncoder->encodePassword(
                    $participant,
                    $form->get('password')->getData()));
            if ($id == null) {
                $currentUser = $this->getUser();
                $em = $this->getDoctrine()->getManager();
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

    /**
     * @Route("/monProfil/{id}", name="monProfil")
     * @param null $id
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */

    public function monProfil($id = null, EntityManagerInterface $em, Request $request)
    {
        $participantRepository = $em->getRepository(Participant::class);
        $participant = $participantRepository->find($id);

            //afficher participant dans ma page :
            return $this->render("profil/monProfil.html.twig",
                [
                    "participant" => $participant
                ]);
        }
}
