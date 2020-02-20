<?php

namespace App\Controller;
use App\Entity\Sortie;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RechercheController extends AbstractController
{
    /**
     * @Route("/recherches/{word}", name="recherches")
     * @param $word
     * @param SortieRepository $sR
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function index( $word, SortieRepository $sR, EntityManagerInterface $em)
    {
        $query = $em->createQuery("SELECT s FROM App\Entity\Sortie s WHERE s.nom = :word");
        $query->setParameter('word', $word);
        $recherche = $query->getResult();


        return $this->json(['recherche'=>$recherche]);

    }
}
