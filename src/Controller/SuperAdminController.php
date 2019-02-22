<?php

namespace App\Controller;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\Utilisateur;
use App\Repository\SimpleUserRepository;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Mgilet\NotificationBundle\NotifiableInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SuperAdminController extends Controller
{
    /**
     * @Route("/superadmi", name="super_admin")
     */
    public function index()
    {
        return $this->render('super_admin/index.html.twig', [
            'controller_name' => 'SuperAdminController',
        ]);
    }

    /**
     * @Route("/superadmin", name="superadmin")
     * @Method("GET")
     * @param NotifiableInterface $notifiable
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function superadmin(UserRepository $userRepository, SimpleUserRepository $simpleUserRepository)
    {
        $notifiableRepo = $this->get('doctrine.orm.entity_manager')->getRepository('MgiletNotificationBundle:NotifiableNotification');
        $notiuser = $notifiableRepo->getusernotif($this->getUser()->getId());
        $notifiable = ($notiuser[0]['id']);
        $notificationList = $notifiableRepo->findAllForNotifiableId(6);
        $noti = $notificationRepository = $this->get('doctrine.orm.entity_manager')->getRepository('MgiletNotificationBundle:Notification')->findAll();
        $toutlesuser = $userRepository->compteuser();
        $users = $toutlesuser[0];

        $ttdonneur = $simpleUserRepository->ttlesdonneur();

        $userdonneur = $ttdonneur[0];
        $ttdemandeur = $simpleUserRepository->ttlesdemandeur();

        $userdemandeur = $ttdemandeur[0];

        $test = $ttdemandeur[0]['COUNT(*)'] + $ttdonneur[0]['COUNT(*)'];
        return $this->render('super_admin/superadmin.html.twig', array(
            'notificationList' => $notificationList,
            'notifiableNotifications' => $notificationList, // deprecated: alias for backward compatibility only
            'noti' => $noti,
            'users' => $users,
            'userdonneur' => $userdonneur,
            'userdemandeur' => $userdemandeur,
            'test' => $test
        ));
    }

    /**
     * @Route("/superadmin/gestionuser", name="gestionuser")
     * @Method("GET")
     * @param NotifiableInterface $notifiable
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function gestionperson(SimpleUserRepository $simpleUserRepository, UserRepository $userRepository)
    {
        $notifiableRepo = $this->get('doctrine.orm.entity_manager')->getRepository('MgiletNotificationBundle:NotifiableNotification');
        $notiuser = $notifiableRepo->getusernotif($this->getUser()->getId());
        $notifiable = ($notiuser[0]['id']);
        $notificationList = $notifiableRepo->findAllForNotifiableId(6);
        $noti = $notificationRepository = $this->get('doctrine.orm.entity_manager')->getRepository('MgiletNotificationBundle:Notification')->findAll();
        $toutlesuser = $userRepository->compteuser();
        $users = $toutlesuser[0];

        $ttdonneur = $simpleUserRepository->ttlesdonneur();

        $userdonneur = $ttdonneur[0];
        $ttdemandeur = $simpleUserRepository->ttlesdemandeur();

        $userdemandeur = $ttdemandeur[0];

        $test = $ttdemandeur[0]['COUNT(*)'] + $ttdonneur[0]['COUNT(*)'];
        $alluser=$userRepository->findalladmin();
dump($alluser);
        return $this->render('super_admin/gestionadministration.html.twig', array(
            'notificationList' => $notificationList,
            'notifiableNotifications' => $notificationList, // deprecated: alias for backward compatibility only
            'noti' => $noti,
            'users' => $users,
            'userdonneur' => $userdonneur,
            'userdemandeur' => $userdemandeur,
            'test' => $test,
            'alluser'=>$alluser
        ));
    }

    /**
     * @Route("/superadmin/adduder", name="adduser")
     * @Method("GET")
     * @param NotifiableInterface $notifiable
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addperson(SimpleUserRepository $simpleUserRepository, UserPasswordEncoderInterface $passwordEncoder,UserRepository $userRepository,ObjectManager $entityManager,Request $request,\Swift_Mailer $mailer)
    {
        $notifiableRepo = $this->get('doctrine.orm.entity_manager')->getRepository('MgiletNotificationBundle:NotifiableNotification');
        $notiuser = $notifiableRepo->getusernotif($this->getUser()->getId());
        $notifiable = ($notiuser[0]['id']);
        $notificationList = $notifiableRepo->findAllForNotifiableId(6);
        $noti = $notificationRepository = $this->get('doctrine.orm.entity_manager')->getRepository('MgiletNotificationBundle:Notification')->findAll();
        $toutlesuser = $userRepository->compteuser();
        $users = $toutlesuser[0];

        $ttdonneur = $simpleUserRepository->ttlesdonneur();

        $userdonneur = $ttdonneur[0];
        $ttdemandeur = $simpleUserRepository->ttlesdemandeur();

        $userdemandeur = $ttdemandeur[0];

        $test = $ttdemandeur[0]['COUNT(*)'] + $ttdonneur[0]['COUNT(*)'];
        if ($request->request->count() > 0) {
            $user = new User();
            $user->setEmail($request->request->get('email'));
            $user->setRoles(array($request->request->get('customRadio')));
            $motdepasse = $request->request->get('motdepasse');
            $user->setPassword($passwordEncoder->encodePassword($user, $motdepasse));
            $user->setTest('test');
            $entityManager->persist($user);
            $entityManager->flush();
            $utilisateur = new Utilisateur();
            $utilisateur->setUserutilisateur($user);
            $utilisateur->setNom($request->request->get('last_name'));
            $utilisateur->setCin($request->request->get('cin'));
            $utilisateur->setPrenom($request->request->get('first_name'));
            $entityManager->persist($utilisateur);
            $entityManager->flush();
            $message = (new \Swift_Message('Site web de don du Sang'))
                ->setFrom('devwebhaifa@gmail.com')
                ->setTo($request->request->get('email'))
                ->setBody(
                    $this->renderView(
                    // templates/emails/registration.html.twig
                        'admin/mail.html.twig',
                        ['user' => $user,
                            'utilisateur' => $utilisateur,
                            'motdepasse' => $motdepasse
                        ]
                    ),
                    'text/html'
                );

            $mailer->send($message);

            return $this->redirectToRoute("gestionuser");
        }




        return $this->render('super_admin/ajouteradmin.html.twig', array(
            'notificationList' => $notificationList,
            'notifiableNotifications' => $notificationList, // deprecated: alias for backward compatibility only
            'noti' => $noti,
            'users' => $users,
            'userdonneur' => $userdonneur,
            'userdemandeur' => $userdemandeur,
            'test' => $test
        ));
    }
    /**
     * @Route("/superadmin/changeretat/{id}/{role}", name="changeretat", methods="GET")
     */
    public function changeretat($id,$role,ObjectManager $manager){
        $userRepository = $this->getDoctrine()->getRepository(User::class);
        $user=$userRepository->findOneBy(['id'=> $id]);
        dump($id);
        $user->setRoles(array($role));
        $manager->persist($user);
        $manager->flush();
        return $this->redirectToRoute('gestionuser');
    }
}
