<?php

namespace App\Controller;


use App\Entity\Site;
use App\Form\RechercheSiteType;
use App\Form\SiteType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SiteController extends AbstractController
{

    /**
     * @Route("/formulaire_site", name="formulaire_site")
     */

    public function formulaireSite(EntityManagerInterface $em, Request $request)
    {
        if ($this->isGranted("ROLE_ADMIN")) {
        $newSite = new Site();
        $form = $this->createForm(SiteType::class, $newSite);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($newSite);
            $em->flush();

            $this->addFlash("success", "Ajouté !");
            return $this->redirectToRoute('site');
        }
        return $this->render("site/formulaire_site.html.twig", [
            "form" => $form->createView(),
        ]);
    } else {
            return $this->redirectToRoute('liste');
        }
    }

    /**
     * @Route("/site", name="site")
     */
    public function listerSite(EntityManagerInterface $em, Request $request){

        if ($this->isGranted("ROLE_ADMIN")) {
            $sites = $em->getRepository(Site::class)->findAll();

            $form = $this->createForm( RechercheSiteType::class);
            $form->handleRequest($request);

            $siteRecherche = $form->get('siteRecherche')->getData();

            if($form->isSubmitted()&& $siteRecherche !== null)
            {
                $sites = $em->getRepository(Site::class)->findBy([
                    "nom"=>$siteRecherche
                ]);

            }

            return $this->render("site/listeSite.html.twig",
                [
                    'sites' => $sites,
                    'recherche'=>$form->createView()
                ]);

        } else {
            return $this->redirectToRoute('liste');
        }
    }



    /**
     * @Route("/supprimer_site/{id}", name="supprimer_site")
     */
    public function supprimer(EntityManagerInterface $em, $id=null)
    {
        if ($this->isGranted("ROLE_ADMIN")) {

        $sites = $em->getRepository(Site::class)->find($id);
        $em->remove($sites);
        $em->flush();
        $this->addFlash('success', 'Site supprimé !');
        return $this->redirectToRoute('site');
    } else {
            return $this->redirectToRoute('liste');
        }
    }
}



