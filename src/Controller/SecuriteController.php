<?php

namespace App\Controller;
use App\Entity\User;
use App\Form\RegistrationFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Mgilet\NotificationBundle\Entity\Notification;
use Mgilet\NotificationBundle\NotifiableInterface;

class SecuriteController extends AbstractController
{
    /**
     * @Route("/securite", name="securite")
     */
    public function index()
    {
        return $this->render('securite/index.html.twig', [
            'controller_name' => 'SecuriteController',
        ]);
    }
    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('securite/home.html.twig');
    }

    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('securite/connexion.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);

    }
    /**
     * @Route("/login/redirect", name="after_login_route_name")
     * @param  NotifiableInterface $notifiable
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginRedirectAction(Request $request)
    {
        if($this->isGranted('ROLE_ADMIN'))
        {
            return $this->redirectToRoute('admin');
        }
        else if($this->isGranted('ROLE_SUPERADMIN'))
        {
            return $this->redirectToRoute('superadmin');
        }
        else if($this->isGranted('ROLE_USER'))
        {
            return $this->redirectToRoute('usersimpleuser');
        }
        else
        {
            return $this->redirectToRoute('home');
        }
    }



/**
* @Route("/logout", name="logout")
*/
    public function logout()
    {
        return $this->render('logout.html.twig');
    }
    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $roles = ['ROLE_USER'];
            $user->setRoles($roles);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // do anything else you need here, like send an email

            return $this->redirect('login');
        }

        return $this->render('securite/inscription.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}

