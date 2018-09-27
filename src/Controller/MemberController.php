<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Member;
use App\Form\MemberType;
use App\Repository\MemberRepository;
use App\Entity\Kid;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
// use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface; 
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class MemberController extends Controller
{

    /**
     * @Route("/member", name="member_index", methods="GET")
     */
    public function index(MemberRepository $memberRepository): Response
    {
        return $this->render('member/index.html.twig', ['members' => $memberRepository->findAll()]);
        
    }

    /**
    * @Route("/member/admin", name="member_admin")
    */

    public function admin(Request $request, SessionInterface $session)
    {
        // var_dump($session->get('user'));
        // if($session->get('user') && $session->get('user')->getMemberRole() == '6')
        // {
            $entityManager = $this->getDoctrine()->getManager();
            $members = $entityManager->getRepository(Member::class)->findAll();
            return $this->render('member/memberAdmin.html.twig', array(
            'members' => $members,
        ));
        // }
        // else
        // {
        //     $this->addFlash(
        //             'notice',
        //             'Vous n\'êtes pas autorisé à consulter cette page !'
        //         );
        //     return $this->redirectToRoute('home_show');
        // }

    
    }
    /**
    * @Route("/member/new", name="member_new")
    */

    public function new(Request $request, SessionInterface $session)
    {
        $member = new Member();
        // option avec le form builder automatique
        $form = $this->createForm(MemberType::class, $member);
        $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid())
            {
                //on récupère les données du formulaire
                $member = $form->getData();

                // on crypte le mot de passe
                $member->setMemberPassWord(password_hash($member->getMemberPassWord(), PASSWORD_BCRYPT));
                // $member->setMemberPassWord($member->getMemberPassWord());

                // on sauve les données dans la base de données
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($member);
                $entityManager->flush();

                $this->addFlash(
                    'notice',
                    'Votre profil a bien été crée !'
                );
                // on démarre une session au nom de la personne qui vient de s'inscrire
                $session->set('user', $member);
                return $this->redirectToRoute('home_show');
            }

        return $this->render('member/new.html.twig', array(
            'form' => $form->createView()
            ));
    }
    /**
    * @Route("/member/setSession", name="member_setSession")
    */

    public function setSession(Request $request, SessionInterface $session)
    {
        $user = new Member();

        // On crée un formulaire d'identification avec email et password.
        $form = $this->createFormBuilder($user)
            ->add('memberEmail', EmailType::class, array('label'  => 'Email :'))
            ->add('memberPassword', PasswordType::class, array('label'  => 'Mot de passe :'))
            ->add('save', SubmitType::class, array('label' => 'Me connecter'))
            ->getForm();
        
            $form->handleRequest($request);
        // On vérifie si le formulaire est bien soumis et on traite les données.
        if ($form->isSubmitted() && $form->isValid())
            {
                $user = $form->getData();
                
                // On récupère les données de tous les membres de la base de données.
                $entityManager = $this->getDoctrine()->getManager();
                $members = $entityManager->getRepository(Member::class)->findAll();

                // On crée une liste de tous les mots de passe
                $memberPasswordList=[];
                foreach ($members as $member)
                {
                    $memberPasswordList[]=$member->getMemberPassWord();
                }

                // On crée une liste de tous les emails
                $memberEmailList=[];
                foreach ($members as $member)
                {
                    $memberEmailList[]=$member->getMemberEmail();
                }
                
                //On vérifie que le mot de passe crypté existe bien dans la liste de tous les mots de passe
                foreach ($memberPasswordList as $memberPassword)
                {
                    $check[]=password_verify($user->getMemberPassword(),$memberPassword);

                    if($user->getMemberPassword() == $memberPassword)
                    {
                        $check[]=True;
                    } 
                    else {
                        $check[]=False;
                    }
                }
                    //On vérifie que l'email existe bien dans la liste de tous les mots de passe et que le test du mot de passe est ok
                    if ( (in_array($user->getMemberEmail(), $memberEmailList)==true && (in_array(true, $check )==true)))
                    {
                    // On affecte la session
                    $user= $entityManager->getRepository(Member::class)->findOneBy([
                        'member_email' => $user->getMemberEmail()
                    ]);
                    $session->set('user', $user);
                    
                    $this->addFlash(
                    'notice',
                    'Vous êtes bien connecté !'
                    );
                    return $this->render('home.html.twig');
                    }
                    else // Sinon on demande de recommencer la saisie ou de se créer un profil
                    {
                        if((in_array($user->getMemberEmail(), $memberEmailList)==false || (in_array(true, $check )==false)))
                        {
                        $this->addFlash(
                        'notice',
                        'Votre email ou votre mot de passe ne sont pas corrects ! Veuillez recommencer la saisie !'
                        );
                        return $this->redirectToRoute('member_setSession'); 
                        }
                        elseif((in_array($user->getMemberEmail(), $memberEmailList)==false && (in_array(true, $check )==false)))
                        {
                        $this->addFlash(
                        'notice',
                        'Vos identifiants n\'ont pas été crées! Veuillez vous créer un profil !'
                        );
                        return $this->redirectToRoute('member_new'); 
                        }
                    }
            }

        return $this->render('member/memberConnect.html.twig', array(
            'form' => $form->createView()
            ));
    }

    /**
    * @Route("/member/unsetSession", name="member_unsetSession")
    */

    public function unsetSession(SessionInterface $session)
    {
        $session->remove('user');
        $session->remove('cart');
        // RAJOUTER UNE FONCTION POUR REPASSER LES ARTICLES SELECTIONNES A VENDRE
        $this->addFlash(
            'notice',
            'Vous êtes bien déconnecté !'
        );
        return $this->render('home.html.twig');
    }


/**
* @Route("/member/{id}", name="member_show", methods="GET")
*/

public function show(Member $member, SessionInterface $session):Response
{
    // if($session->get('user') && ($session->get('user')->getMemberRole() == '6' || $session->get('user')->getId() == $member->getId()))
    // {
        return $this->render('member/memberShow.html.twig', array(
            'member' => $member
    ));
    // }
    // else {
    //     $this->addFlash(
    //                 'notice',
    //                 'Vous n\'êtes pas autorisé à consulter cette page !'
    //             );
    //     return $this->redirectToRoute('home_show');
    // }
    
}

/**
 * @Route("/member/{id}/edit", name="member_edit", methods="GET|POST")
 */
public function edit(Request $request, Member $member, SessionInterface $session): Response
{
    // if($session->get('user') && ($session->get('user')->getMemberRole() == '6' || $session->get('user')->getId() == $member->getId()))
    // {
        $form = $this->createForm(MemberType::class, $member);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash(
                    'notice',
                    'Votre profil a bien été modifié !'
                );

            return $this->redirectToRoute('member_edit', ['id' => $member->getId()]);
        }

        return $this->render('member/edit.html.twig', [
            'member' => $member,
            'form' => $form->createView(),
        ]);
    // }
    // else
    // {
    //     $this->addFlash(
    //                 'notice',
    //                 'Vous n\'êtes pas autorisé à consulter cette page !'
    //             );
    //     return $this->redirectToRoute('home_show');
    // }
}

/**
 *@Route("/member/delete/{id}" , name="member_delete")
 */
public function delete($id, Request $request, SessionInterface $session)
{
    $entityManager = $this->getDoctrine()->getManager();
    $member = $entityManager->getRepository(Member::class)->find($id);


    if (!$member) {
        throw $this->createNotFoundException(
            'Le membre '.$id. 'n\'existe pas !'
        );
    }
                $entityManager->remove($member);
                $entityManager->flush();

                $this->addFlash(
                    'notice',
                    'Votre profil a bien été supprimé !'
                );

        return $this->render('home.html.twig');
    }
}
