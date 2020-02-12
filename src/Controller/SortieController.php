<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Entity\Sortie;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SortieController extends AbstractController
{
    /**
     * @Route("/sortie", name="sortie")
     */
    public function index()
    {
        return $this->render('base/index.html.twig', [
            'controller_name' => 'SortieController',
        ]);
    }

    /**
     * @Route("/liste", name="liste")
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function recupListeSortie(EntityManagerInterface $em)
    {

        $ListeSortie = $em->getRepository(Sortie::class)->findAll();

        return $this->render('base/liste.html.twig', [
            "listeSortie" => $ListeSortie
        ]);

    }

    /**
     * @Route("/detail/{id}", name="detail")
     * @param EntityManagerInterface $em
     * @param $id
     * @return Response
     */
    public function afficherDetail(EntityManagerInterface $em, $id)
    {

        $detailSortie = $em->getRepository(Sortie::class)->find($id);

        return $this->render('base/detail.html.twig', [
            "detailSortie" => $detailSortie
        ]);
    }
}
