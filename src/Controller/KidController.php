<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Kid;
use App\Entity\School;
use App\Entity\Member;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface; 

class KidController extends Controller
{

    /**
    * @Route("/kid/create", name="kid_create")
    */
    public function create(Request $request,SessionInterface $session)
    {
            $id=$session->get('id');
            $parent=$this->getDoctrine()->getRepository(Member::class)->find($id);
            $submitedKidNb=$session->get('submitedKidNb');
                
            $kid = new Kid();
                $form = $this->createFormBuilder($kid)
                    ->add('kidName', TextType::class, array('label'  => 'Nom :'))
                    ->add('kidSurname', TextType::class, array('label'  => 'Prénom :'))
                    ->add('kidParentList', EntityType::class, array(
                            'label'  => 'Parent :',
                            'class' => 'App\Entity\Member',
                            'choice_label' => function ($parent){
                                return $parent->getMemberName().' '.$parent->getMemberSurname();
                            },
                            'preferred_choices' => function ($parent){
                                return $parent->getMemberSurname().' '.$parent->getMemberName() == $session->get('surname').' '.$session->get('name');
                            }))
                    ->add('kidBirthday', BirthdayType::class, array(
                        'label'  => 'Date de naissance :',
                        'widget' => 'choice',
                        'format' => 'dd-MM-yyyy',
                        'placeholder' => array(
                                'day' => 'Jour', 'month' => 'Mois', 'year' => 'Année',)
                        ))
                    ->add('kidSchoolId', EntityType::class, array(
                            'label'  => 'Ecole :',
                            'class' => 'App\Entity\School',
                            'choice_label' => 'schoolName',
                            'required' => false))
                    ->add('save', SubmitType::class, array('label' => 'Créez son profil'))
                    ->getForm();
                
                    $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid())
                {
                    // $form->getData() holds the submitted values
                    // but, the original `$task` variable has also been updated
                    $kid = $form->getData();

                    // ... perform some action, such as saving the task to the database
                    // for example, if Task is a Doctrine entity, save it!
                    $entityManager = $this->getDoctrine()->getManager();
                     
                    $entityManager->persist($kid);
                    $entityManager->flush();

                    if ($submitedKidNb <= $parent->getMemberKidCount())
                    {
                    return $this->redirectToRoute('kid_create');
                    }
                    else
                    {
                    return $this->render('home.html.twig');
                    }

                $session->set('submitedKidNb', $submitedKidNb+'1');
            }
        
        return $this->render('kid/kidCreate.html.twig', array(
                    'form' => $form->createView(),
                ));
    }
}
