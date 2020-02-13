<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\RegisterType;
use App\Security\ParticipantAuthAuthenticator;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class  SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }
    /**
     * @Route("/register", name="app_register")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param GuardAuthenticatorHandler $guardHandler
     * @param ParticipantAuthAuthenticator $authenticator
     * @param SessionInterface $session
     * @return Response
     */
    public function register(Request $request,
                             UserPasswordEncoderInterface $passwordEncoder,
                             GuardAuthenticatorHandler $guardHandler,
                             ParticipantAuthAuthenticator $authenticator,
                             SessionInterface $session): Response
    {


        $user = new Participant();
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setRoles(['ROLE_ADMIN']);
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $session->set('pseudo',$user->getUsername());
            $session->set('id',$user->getId());
            // do anything else you need here, like send an email

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }

        return $this->render('security/register.html.twig', [
            'registerForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/participant", name="participant")
     */

    public function participant()
    {
        $this->denyAccessUnlessGranted("ROLE_PART");
    }

    /**
     * @Route("/utilisateur", name="utilisateur")
     */

    public function profile()
    {
        $this->denyAccessUnlessGranted("ROLE_USER");
    }

    /**
     * @Route("/administrateur", name="administrateur")
     */

    public function admin()
    {
        $this->denyAccessUnlessGranted("ROLE_ADMIN");
    }

    /**
     * @Route("/organisateur", name="organisateur")
     */

    public function organisateur()
    {
        $this->denyAccessUnlessGranted("ROLE_ORGA");
    }
}
