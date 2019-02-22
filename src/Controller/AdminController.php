<?php

namespace App\Controller;

use App\Entity\SimpleUser;
use App\Entity\User;
use App\Entity\Utilisateur;
use App\Repository\SimpleUserRepository;
use App\Repository\UserRepository;
use App\Repository\UtilisateurRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Mgilet\NotificationBundle\Entity\Repository\NotifiableRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Mgilet\NotificationBundle\NotifiableInterface;
use Mgilet\NotificationBundle\Model\Notification as NotificationModel;
use Symfony\Component\HttpFoundation\Request;
use Mgilet\NotificationBundle\Event;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminController extends Controller
{
    /**
     * @Route("/admin/", name="admin")
     * @Method("GET")
     * @param NotifiableInterface $notifiable
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index( UserRepository $userRepository,SimpleUserRepository $simpleUserRepository)

    {

        $notifiableRepo = $this->get('doctrine.orm.entity_manager')->getRepository('MgiletNotificationBundle:NotifiableNotification');
        $notiuser= $notifiableRepo->getusernotif($this->getUser()->getId());
        $notifiable=($notiuser[0]['id']);
        $notificationList = $notifiableRepo->findAllForNotifiableId(6);
        $noti=$notificationRepository = $this->get('doctrine.orm.entity_manager')->getRepository('MgiletNotificationBundle:Notification')->findAll();
        $toutlesuser=$userRepository->compteuser();
        $users=$toutlesuser[0];

        $ttdonneur=$simpleUserRepository->ttlesdonneur();

        $userdonneur=$ttdonneur[0];
        $ttdemandeur=$simpleUserRepository->ttlesdemandeur();

        $userdemandeur=$ttdemandeur[0];

         $test=$ttdemandeur[0]['COUNT(*)']+$ttdonneur[0]['COUNT(*)'];
        return $this->render('admin/admin2.html.twig', array(
            'notificationList' => $notificationList,
            'notifiableNotifications' => $notificationList, // deprecated: alias for backward compatibility only
             'noti'=>$noti,
            'users'=>$users,
            'userdonneur'=>$userdonneur,
            'userdemandeur'=>$userdemandeur,
            'test'=>$test


        ));

    }
    /**
     * @Route("/admin/showuser{id}", name="voir_show", methods="GET")
     */
    public function show(Utilisateur $utilisateur, SimpleUserRepository $simpleUserRepository, UserRepository $userRepository)
    {dump($utilisateur);
        $notifiableRepo = $this->get('doctrine.orm.entity_manager')->getRepository('MgiletNotificationBundle:NotifiableNotification');
        $notiuser= $notifiableRepo->getusernotif($this->getUser()->getId());
        $notifiable=($notiuser[0]['id']);
        $notificationList = $notifiableRepo->findAllForNotifiableId(6);
        $noti=$notificationRepository = $this->get('doctrine.orm.entity_manager')->getRepository('MgiletNotificationBundle:Notification')->findAll();
        $toutlesuser=$userRepository->compteuser();
        $users=$toutlesuser[0];

        $ttdonneur=$simpleUserRepository->ttlesdonneur();

        $userdonneur=$ttdonneur[0];
        $ttdemandeur=$simpleUserRepository->ttlesdemandeur();

        $userdemandeur=$ttdemandeur[0];

        $test=$ttdemandeur[0]['COUNT(*)']+$ttdonneur[0]['COUNT(*)'];
        return $this->render('admin/corrdonneesmembre.html.twig',['utilisateur' => $utilisateur,
            'notificationList' => $notificationList,
            'notifiableNotifications' => $notificationList, // deprecated: alias for backward compatibility only
             'noti'=>$noti,
            'users'=>$users,
            'userdonneur'=>$userdonneur,
            'userdemandeur'=>$userdemandeur,
            'test'=>$test
    ]);

    }
    /**
     * @Route("/admin/changermotdepasse", name="changermotpasse" )
     */
    public function changermotdepasse( SimpleUserRepository $simpleUserRepository, UserRepository $userRepository,UserPasswordEncoderInterface $passwordEncoder,Request $request,ObjectManager $entityManager)
    {
        $notifiableRepo = $this->get('doctrine.orm.entity_manager')->getRepository('MgiletNotificationBundle:NotifiableNotification');
        $notiuser= $notifiableRepo->getusernotif($this->getUser()->getId());
        $notifiable=($notiuser[0]['id']);
        $notificationList = $notifiableRepo->findAllForNotifiableId(6);
        $noti=$notificationRepository = $this->get('doctrine.orm.entity_manager')->getRepository('MgiletNotificationBundle:Notification')->findAll();
        $toutlesuser=$userRepository->compteuser();
        $users=$toutlesuser[0];

        $ttdonneur=$simpleUserRepository->ttlesdonneur();

        $userdonneur=$ttdonneur[0];
        $ttdemandeur=$simpleUserRepository->ttlesdemandeur();

        $userdemandeur=$ttdemandeur[0];

        $test=$ttdemandeur[0]['COUNT(*)']+$ttdonneur[0]['COUNT(*)'];
        if($request->request->count() > 0) {
            $user = $this->getUser();
            $motdepasse = $request->request->get('motdepasse');
            $user->setPassword($passwordEncoder->encodePassword($user, $motdepasse));
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('admin');
        }
        return $this->render('admin/changermotdepasse.html.twig',[
            'notificationList' => $notificationList,
            'notifiableNotifications' => $notificationList, // deprecated: alias for backward compatibility only
            'noti'=>$noti,
            'users'=>$users,
            'userdonneur'=>$userdonneur,
            'userdemandeur'=>$userdemandeur,
            'test'=>$test
        ]);

    }
    /**
     * List of all notifications
     *
     * @Route("/admin/{notifiable}", name="notification_list")
     * @Method("GET")
     * @param NotifiableInterface $notifiable
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction($notifiable)
    {
        $notifiableRepo = $this->get('doctrine.orm.entity_manager')->getRepository('MgiletNotificationBundle:NotifiableNotification');
        $notificationList = $notifiableRepo->findAllForNotifiableId($notifiable);
        var_dump($notificationList);
        return $this->render('admin/notification_list.html.twig', array(
            'notificationList' => $notificationList,
            'notifiableNotifications' => $notificationList // deprecated: alias for backward compatibility only
        ));
    }

    /**
     * Set a Notification as seen
     *
     * @Route("/admin/{notifiable}/mark_as_seen/{notification}", name="notification_mark_as_seen")
     * @Method("POST")
     * @param int           $notifiable
     * @param Notification  $notification
     *
     * @return JsonResponse
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\EntityNotFoundException
     * @throws \LogicException
     */
    public function markAsSeenAction($notifiable, $notification)
    {    $notifiableRepo = $this->get('doctrine.orm.entity_manager')->getRepository('MgiletNotificationBundle:NotifiableNotification');
        $notiuser= $notifiableRepo->getusernotif($this->getUser()->getId());
        $notifiable=$notiuser[0]['id'];
        $manager = $this->get('mgilet.notification');
        $manager->markAsSeen(
            $manager->getNotifiableInterface($manager->getNotifiableEntityById($notifiable),
            $manager->getNotification($notification),
            true
        ));

        return $this->redirectToRoute("admin");
    }

    /**
     * Set a Notification as unseen
     *
     * @Route("/admin/{notifiable}/mark_as_unseen/{notification}", name="notification_mark_as_unseen")
     * @Method("POST")
     * @param $notifiable
     * @param $notification
     *
     * @return JsonResponse
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\EntityNotFoundException
     * @throws \LogicException
     */
    public function markAsUnSeenAction($notifiable, $notification)
    {     $notifiableRepo = $this->get('doctrine.orm.entity_manager')->getRepository('MgiletNotificationBundle:NotifiableNotification');
        $notiuser= $notifiableRepo->getusernotif($this->getUser()->getId());
        $notifiable=$notiuser[0]['id'];
        $manager = $this->get('mgilet.notification');
        $manager->markAsUnseen(
            $manager->getNotifiableInterface($manager->getNotifiableEntityById($notifiable)),
            $manager->getNotification($notification),
            true
        );

        return $this->redirectToRoute("admin");
    }

    /**
     * Set all Notifications for a User as seen
     *
     * @Route("/admin/{notifiable}/markAllAsSeen", name="notification_mark_all_as_seen")
     * @Method("POST")
     * @param $notifiable
     *
     * @return JsonResponse
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function markAllAsSeenAction($notifiable)
    {      $notifiableRepo = $this->get('doctrine.orm.entity_manager')->getRepository('MgiletNotificationBundle:NotifiableNotification');
        $notiuser= $notifiableRepo->getusernotif($this->getUser()->getId());
        $notifiable=$notiuser[0]['id'];
        $manager = $this->get('mgilet.notification');
        $manager->markAllAsSeen(
            $manager->getNotifiableInterface($manager->getNotifiableEntityById($notifiable)),
            true
        );

        return $this->redirectToRoute("admin");
    }
    /**
     * @Route("/admin/voirmescoordonnes", name="voirmescoordonnes", methods="GET")
     */
    public function mescoordonnees( SimpleUserRepository $simpleUserRepository, UserRepository $userRepository,UtilisateurRepository $utilisateurRepository)
    {
        $notifiableRepo = $this->get('doctrine.orm.entity_manager')->getRepository('MgiletNotificationBundle:NotifiableNotification');
        $notiuser= $notifiableRepo->getusernotif($this->getUser()->getId());
        $notifiable=($notiuser[0]['id']);
        $notificationList = $notifiableRepo->findAllForNotifiableId(6);
        $noti=$notificationRepository = $this->get('doctrine.orm.entity_manager')->getRepository('MgiletNotificationBundle:Notification')->findAll();
        $toutlesuser=$userRepository->compteuser();
        $users=$toutlesuser[0];
        $utlilisateuradmin=$utilisateurRepository->findOneBy(["userutilisateur"=>$this->getUser()]);
        dump($utlilisateuradmin);

        $ttdonneur=$simpleUserRepository->ttlesdonneur();

        $userdonneur=$ttdonneur[0];
        $ttdemandeur=$simpleUserRepository->ttlesdemandeur();

        $userdemandeur=$ttdemandeur[0];

        $test=$ttdemandeur[0]['COUNT(*)']+$ttdonneur[0]['COUNT(*)'];

        return $this->render('admin/coordonneesadmin.html.twig',[
            'notificationList' => $notificationList,
            'notifiableNotifications' => $notificationList, // deprecated: alias for backward compatibility only
            'noti'=>$noti,
            'users'=>$users,
            'userdonneur'=>$userdonneur,
            'userdemandeur'=>$userdemandeur,
            'test'=>$test,
            'utlilisateuradmin'=>$utlilisateuradmin
        ]);

    }

}
