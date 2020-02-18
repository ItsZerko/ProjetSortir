<?php

namespace App\Controller;


use App\Entity\Lieu;
use App\Entity\Ville;
use App\Form\LieuType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;

class LieuController extends AbstractController
{

    /**
     * @Route("/ajouterLieu", name="ajouterLieu")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function AjouterLieu(Request $request, EntityManagerInterface $em) {
       $lieu = new Lieu();
       $ville = new Ville();
        $form = $this->createForm(LieuType ::class, $lieu);


        $form->handleRequest($request);
if ($form->isSubmitted() && $form->isValid()){
    $villeNom= $form->get('ville')->getData();
    $villeCode=$form->get('codePostal')->getData();
    $ville->setNom($villeNom);
    $ville->setCodePostal($villeCode);
    $lieu->setVille($ville);
    $em->persist($lieu);
    $em->flush();
    return $this->redirectToRoute('sortie');
}
        return $this->render('lieu/ajouterLieu.html.twig', [
            'controller_name' => 'SortieController',
            'formLieu'=>$form->createView()]);
    }
}
