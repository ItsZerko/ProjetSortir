<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Entity\Sortie;
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

            return $this->redirectToRoute('liste');
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

    /**
     * @Route("/listeParticipant", name="listeParticipant")
     */
    public function listeUser(EntityManagerInterface $em, Request $request)
    {

        $participants = $em->getRepository(Participant::class)->findAll();
        $sorties = $em->getRepository(Sortie::class)->findAll();

        return $this->render('admin/listeUser.html.twig', [
            'participants' => $participants,
            'sorties' => $sorties
        ]);
    }


    /**
     * @Route("/detailParticipant/{id}", name="detailParticipant")
     * @param EntityManagerInterface $em
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function detailUser(EntityManagerInterface $em, Request $request, $id)
    {
        $null = null;

        $participants = $em->getRepository(Participant::class)->findBy
        ([
            'id' => $id,


        ]);

        return $this->render('admin/detailUser.html.twig', [
            'participants' => $participants
        ]);

    }

    /**
     * @param EntityManagerInterface $em
     * @param Request $request
     * @param $id
     * @Route("/suppressionUser/{id}", name="suppressionUser")
     * @return RedirectResponse|Response
     */
    public function supprimerUser(EntityManagerInterface $em, Request $request,$id){

        $null = null;


        $participantId = $em->getRepository(Participant::class)->findOneBy(
            [
                'id' => $id
            ]);

            $em->remove($participantId);
            $em->flush();

        return $this->redirectToRoute('listeParticipant');
        }


    /**
     * @Route("/detailSortie/{id}", name="detailSortie")
     * @param EntityManagerInterface $em
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function detailSortie(EntityManagerInterface $em, Request $request, $id)
    {

        $sortie = $em->getRepository(Sortie::class)->find($id);

        return $this->render('admin/detailSortie.html.twig', [
            'sortie' => $sortie
        ]);

    }

    /**
     * @param EntityManagerInterface $em
     * @param Request $request
     * @param $id
     * @Route("/suppressionSortie/{id}", name="suppressionSortie")
     * @return RedirectResponse|Response
     */
    public function supprimerSortie(EntityManagerInterface $em, Request $request,$id){



        $sortie = $em->getRepository(Sortie::class)->findOneBy(
            [
                'id' => $id,
            ]);

        $em->remove($sortie);
        $em->flush();


        return $this->redirectToRoute('listeParticipant');

    }
    }
