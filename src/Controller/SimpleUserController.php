<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Entity\SimpleUser;
use App\Entity\Demandeur;
use App\Entity\Donneur;
use App\Repository\SimpleUserRepository;
use App\Repository\UserRepository;
use App\Repository\UtilisateurRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Symfony\Component\Validator\Constraints\DateTime;

class SimpleUserController extends Controller
{
    /**
     * @Route("/simpleuse", name="simple_user")
     */
    public function index()
    {
        return $this->render('simple_user/index.html.twig', [
            'controller_name' => 'SimpleUserController',
        ]);
    }

    /**
     * @Route("/simpleuser/", name="usersimpleuser")
     */
    public function simpleuser(Request $request, SimpleUserRepository $simpleUserRepository)

    {
        $datademandeurs = $simpleUserRepository->afffichertoutdemandeur();
        $datadonneurs = $simpleUserRepository->afffichertoutdonneur();

        return $this->render('simple_user/simpleuser.html.twig', ['datademandeurs' => $datademandeurs,
            'datadonneurs' => $datadonneurs
        ]);
    }

    /**
     * @Route("/simpleuser/cooor", name="coordonnes")
     */

    public function ajoutcoordonnees(Request $request, ObjectManager $manager, UserRepository $userRepository)

    {

        $user = $this->getUser();
        if (empty($user->getTest())) {
            if ($request->request->count() > 0) {
                $utilisateur = new Utilisateur();
                $utilisateur->setPrenom($request->request->get('last_name'));
                $utilisateur->setCin($request->request->get('cin'));
                $utilisateur->setNom($request->request->get('first_name'));

                $user->setTest('test');
                $manager->persist($user);
                $manager->flush();
                $utilisateur->setUserutilisateur($user);
                $utilisateur->setFonction('simple utilisateur');
                // $manager->persist($utilisateur);
                $simpleuser = new SimpleUser();
                $date = new \DateTime($request->request->get('date'));
                $simpleuser->setDatanaissance($date);
                $simpleuser->setEmail($request->request->get('email'));
                $simpleuser->setGroupesanguin($request->request->get('sang'));
                $simpleuser->setTelephone($request->request->get('phone'));
                $test = "oui";

                $manager->persist($simpleuser);
                $manager->flush();
                $utilisateur->setSimutilisateur($simpleuser);
                $manager->persist($utilisateur);
                $manager->flush();
                return $this->redirectToRoute('usersimpleuser');
            }
            return $this->render('simple_user/ajoutavecsuccess.html.twig');
        } else

            if ($request->request->count() > 0) {
                $usercourant = $this->getUser()->getId();
                $recuperersimpleuser = $userRepository->iddesimpleuser($usercourant);

                $tabuser = $recuperersimpleuser[0];

                $nomprenomuser = $userRepository->nomprenomutilisateur($usercourant);
                $tabutilisateur = $nomprenomuser[0];
                $repository = $this->getDoctrine()->getRepository(SimpleUser::class);

                $tabuser['datanaissance']= new \DateTime( $tabuser['datanaissance']);
                $simpleuser = $repository->findOneBy($tabuser);
                dump($simpleuser);
                if ($request->request->get('hosting') == "donneur") {
                    $donneur = new Donneur();

                    $donneur->setMessage($request->request->get('comment'));
                    $donneur->setUsedonneur($simpleuser);
                    $donneur->setGpe($tabuser['groupesanguin']);
                    $manager->persist($donneur);
                    $manager->flush();
                    $manager = $this->get('mgilet.notification');
                    $notif = $manager->createNotification('Donneur');
                    $notif->setMessage($request->request->get('comment'));
                    $notif->setLink($tabutilisateur['id']);
                    // or the one-line method :
                    // $manager->createNotification('Notification subject','Some random text','http://google.fr');
                    $manager->addNotification(array($userRepository->findOneBy(['id' =>14])), $notif, true);
                    // you can add a notification to a list of entities
                    // the third parameter ``$flush`` allows you to directly flush the entities

                    return $this->redirectToRoute('usersimpleuser');

                } else if ($request->request->get('hosting') == "demandeur") {
                    $demandeur = new Demandeur();
                    $demandeur->setUserdemandeur($simpleuser);
                    $demandeur->setMessage($request->request->get('comment'));
                    $demandeur->setGpe($tabuser['groupesanguin']);
                    $manager->persist($demandeur);
                    $manager->flush();
                    $manager = $this->get('mgilet.notification');
                    $notif = $manager->createNotification('Demandeur');
                    $notif->setMessage($request->request->get('comment'));
                    $notif->setLink($tabutilisateur['id']);

                    $manager->addNotification(array($userRepository->findOneBy(['id' =>14])), $notif, true);
                     return $this->redirectToRoute('usersimpleuser');

                }


            }
        return $this->render('simple_user/etape2.html.twig');

    }

    /**
     * @Route("/simpleuser/mescoordonnes", name="mescoordonnees")
     */
    public function simpleusercoordonnees(UserRepository $userRepository)

    {$user=$this->getUser()->getId();
        $utilisateur=$userRepository->getcoordonnesuser($user);
         $coordonnes=$utilisateur[0];

        return $this->render('simple_user/mescoordonnees.html.twig', ['coordonnes' => $coordonnes
        ]);
    }
}





