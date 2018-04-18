<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Member;
use App\Entity\Kid;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
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
    * @Route("/member/admin", name="member_admin")
    */

    public function admin(Request $request, SessionInterface $session)
    {
    $entityManager = $this->getDoctrine()->getManager();
    $members = $entityManager->getRepository(Member::class)->findAll();

    return $this->render('member/memberAdmin.html.twig', array(
            'members' => $members,
        ));
    }
    /**
    * @Route("/member/create", name="member_create")
    */

    public function create(Request $request, SessionInterface $session)
    {
        $member = new Member();

        $form = $this->createFormBuilder($member)
            ->add('memberName', TextType::class, array('label'  => 'Nom :'))
            ->add('memberSurname', TextType::class, array('label'  => 'Prénom :'))
            ->add('memberAddress1', TextType::class, array('label'  => 'Adresse :'))
            ->add('memberAddress2', TextType::class, array('label'  => 'Adresse (complément) :'))
            ->add('memberZipCode', TextType::class, array('label'  => 'Code Postal :'))
            ->add('memberCity', TextType::class, array('label'  => 'Ville :'))
            ->add('memberTel', TelType::class, array('label'  => 'Téléphone :'))
            ->add('memberEmail', EmailType::class, array('label'  => 'email :'))
            ->add('memberPassword', PasswordType::class, array('label'  => 'Mot de passe :'))
            ->add('memberButtonWallet', HiddenType::class, array('data'  => '0'))
            // ->add('memberRole', HiddenType::class, array('data'  => 'visiteur'))
            ->add('memberKidCount',IntegerType::class, array('label'  => 'Nombre d\'enfants :'))
            ->add('memberSubscription', ChoiceType::class, array(
                'label'  => 'Abonnement à la newsletter',
                'expanded'=> true,
                'choices' => array(
                    'Oui' => true,
                    'Non' => false
                )))
            ->add('memberExpertise', TextType::class, array('label'  => 'Compétence que vous pouvez mettre à disposition:'))
            ->add('memberLevel', RangeType::class, array('label'  => 'Niveau en couture:'))
            ->add('save', SubmitType::class, array('label' => 'Créez votre profil'))
            ->getForm();
        
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid())
            {
                //on récupère les données du formulaire
                $member = $form->getData();

                // on crypte le mot de passe
                $member->setMemberPassWord(password_hash($member->getMemberPassWord(), PASSWORD_BCRYPT));

                // on sauve les données dans la base de données
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($member);
                $entityManager->flush();

                $this->addFlash(
                    'notice',
                    'Votre profil a bien été crée !'
                );

                $session->set('id', $member->getId());
                $session->set('name', $member->getMemberName());
                $session->set('surname', $member->getMemberSurname());
                $session->set('submitedKidNb', '1');

                if(($member->getMemberKidCount())>0)
                {
                    return $this->redirectToRoute('kid_create');
                }
                else {
                    return $this->render('home.html.twig');
                }
            }

        return $this->render('member/memberCreate.html.twig', array(
            'form' => $form->createView()
            ));
    }
    /**
    * @Route("/member/setSession", name="member_setSession")
    */

    public function setSession(Request $request, SessionInterface $session)
    {
        $user = new Member();

        $form = $this->createFormBuilder($user)
            ->add('memberEmail', EmailType::class, array('label'  => 'Email :'))
            ->add('memberPassword', PasswordType::class, array('label'  => 'Mot de passe :'))
            ->add('save', SubmitType::class, array('label' => 'Me connecter'))
            ->getForm();
        
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid())
            {
                $user = $form->getData();

                // On récupère les données de tous les membres de la base de données.
                // voir si possible de faire autrment qu'avec un findAll
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
                    }
                    //On vérifie que l'email existe bien dans la liste de tous les mots de passe et que le test du mot de passe est ok
                    if ( (in_array($user->getMemberEmail(), $memberEmailList)==true && (in_array('true', $check )==true)))
                    {
                    // on affecte la session
                    $session->set('id', $member->getId());
                    $session->set('name', $member->getMemberName());
                    $session->set('surname', $member->getMemberSurname());

                    $this->addFlash(
                    'notice',
                    'Vous êtes bien connecté !'
                    );
                    return $this->render('home.html.twig');
                    }
                    else // sinon on demande de recommencer la saisie ou de se créer un profil
                    {
                        if((in_array($user->getMemberEmail(), $memberEmailList)==false || (in_array('true', $check )==false)))
                        {
                        $this->addFlash(
                        'notice',
                        'Votre email ou votre mot de passe ne sont pas corrects ! Veuillez recommencer la saisie !'
                        );
                        return $this->redirectToRoute('member_connect'); 
                        }
                        elseif((in_array($user->getMemberEmail(), $memberEmailList)==false && (in_array('true', $check )==false)))
                        {
                        $this->addFlash(
                        'notice',
                        'Vos identifiants n\'ont pas été crées! Veuillez vous créer un profil !'
                        );
                        return $this->redirectToRoute('member_create'); 
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
        $session->invalidate();
        $this->addFlash(
            'notice',
            'Vous êtes bien déconnecté !'
        );
        return $this->render('home.html.twig');
    }


    /**
    * @Route("/member/show", name="member_show")
    */

    public function show(Request $request, SessionInterface $session)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $member = $entityManager->getRepository(Member::class)->find($session->get('id')); 

        return $this->render('member/memberShow.html.twig', array(
            'member' => $member
        ));
    }

/**
 *@Route("/member/update" , name="member_update")
 */
public function update(Request $request, SessionInterface $session)
{
    $entityManager = $this->getDoctrine()->getManager();
    if($session)
    {
        $member = $entityManager->getRepository(Member::class)->find($session->get('id'));
    }
    else {
        $member = $entityManager->getRepository(Member::class)->find($request->get('memberId'));
    }
    
    // $id=$request->get('memberId');
    // $member = $entityManager->getRepository(Member::class)->find($id);

    if (!$member) {
        throw $this->createNotFoundException(
            'Le membre '.$member->getId(). 'n\'existe pas !'
        );
    }

    $form = $this->createFormBuilder($member)
            ->add('memberName', TextType::class, array('label'  => 'Nom :'))
            ->add('memberSurname', TextType::class, array('label'  => 'Prénom :'))
            ->add('memberAddress1', TextType::class, array('label'  => 'Adresse :'))
            ->add('memberAddress2', TextType::class, array('label'  => 'Adresse (complément) :'))
            ->add('memberZipCode', TextType::class, array('label'  => 'Code Postal :'))
            ->add('memberCity', TextType::class, array('label'  => 'Ville :'))
            ->add('memberTel', TelType::class, array('label'  => 'Téléphone :'))
            ->add('memberEmail', EmailType::class, array('label'  => 'email :'))
            ->add('memberPassword', PasswordType::class, array('label'  => 'Mot de passe :'))
            ->add('memberRole', EntityType::class, array('data'  => 'membre'))
            ->add('memberRole', EntityType::class, array(
                            'label'  => 'Role :',
                            'class' => 'App\Entity\Role',
                            'choice_label' => 'RoleName'))
            ->add('memberKidCount',IntegerType::class, array('label'  => 'Nombre d\'enfants :'))
            ->add('memberSubscription', RadioType::class, array('label'  => 'Abonnement à la newsletter'))
            ->add('memberExpertise', TextType::class, array('label'  => 'Compétence que vous pouvez mettre à disposition:'))
            ->add('memberLevel', RangeType::class, array('label'  => 'Niveau en couture:'))
            ->add('save', SubmitType::class, array('label' => 'Modifiez votre profil'))
            ->getForm();
        
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid())
            {
                // $form->getData() holds the submitted values
                // but, the original `$member` variable has also been updated
                $member = $form->getData();

                // ... perform some action, such as saving the member to the database
                // for example, if Member is a Doctrine entity, save it!
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($member);
                $entityManager->flush();

                $this->addFlash(
                    'notice',
                    'Votre profil a bien été modifié !'
                );

                return $this->render('home.html.twig');
            }

        return $this->render('member/memberUpdate.html.twig', array(
            'form' => $form->createView(),
            'member'=> $member
        ));

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
